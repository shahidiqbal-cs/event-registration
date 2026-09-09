<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        if (!is_logged() || (user_role() != 'admin')):
            redirect(site_url('login'));
        endif;
    }

    private function template($output) {
        $output->ideologies = $this->ideology_model->get_ideologies();
        $this->parser->parse('template', $output);
    }

    function index() {
        $data = (object) array();
        $data->title = 'Maintenance';
        $data->heading = 'Maintenance';
        $data->heading_desc = 'Maintenance';
        $data->content = 'maintenance';
        $this->template($data);
    }

    function backup() {
        $this->load->dbutil();
        $file_name = 'backup_tfw_' . date('Y_m_d_His') . '.sql.zip';
        $prefs = array(
            'tables' => array(), // Array of tables to backup.
            'ignore' => array(), // List of tables to omit from the backup
            'format' => 'zip', // gzip, zip, txt
            'filename' => $file_name, // File name - NEEDED ONLY WITH ZIP FILES
            'add_drop' => TRUE, // Whether to add DROP TABLE statements to backup file
            'add_insert' => TRUE, // Whether to add INSERT data to backup file
            'newline' => "\n"                         // Newline character used in backup file
        );

        $backup = $this->dbutil->backup($prefs);
        $this->load->helper('download');
        force_download($file_name, $backup);
    }

    private function upload_file() {
        $config['upload_path'] = 'assets';
        $config['allowed_types'] = 'zip';
        $config['overwrite'] = true;
        $config['max_size'] = 2048;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('sqlfile')) :
            flash_msg('error', $this->upload->display_errors('', ''));
            redirect(site_url('maintenance'));
        endif;
        $uploadData = $this->upload->data();
        $uploadedFilePath = $config['upload_path'] . '/' . $uploadData['file_name'];
        $uploadedFileInfo = pathinfo($uploadedFilePath);
        if ($uploadedFileInfo['extension'] != 'zip'):
            @unlink($uploadedFilePath);
            flash_msg('error', 'File is corrupted.');
            redirect(site_url('maintenance'));
        endif;
        return $uploadedFilePath;
    }

    private function get_sql_file($uploadedFilePath) {
        $this->load->library('unzip');
        //Optional: Only take out these files, anything else is ignored
        $this->unzip->allow(array('sql'));
        $extractedFiles = $this->unzip->extract($uploadedFilePath);
        $this->unzip->close();
        $sqlFile = '';
        foreach ($extractedFiles as $file):
            $fileInfo = pathinfo($file);
            $filePath = $fileInfo['dirname'] . '/' . $fileInfo['basename'];
            if ($fileInfo['extension'] == 'sql' && !$sqlFile):
                $sqlFile = $filePath;
            else:
                @unlink($filePath);
            endif;
        endforeach;
        return $sqlFile;
    }

    function import() {
        $uploadedFilePath = $this->upload_file();
        $sqlFile = $this->get_sql_file($uploadedFilePath);
        @unlink($uploadedFilePath);
        if (!$sqlFile):
            flash_msg('error', 'File is corrupted.');
            redirect(site_url('maintenance'));
        endif;
        set_time_limit(0);
        ini_set('default_charset', 'utf-8');
        header('Content-Type: text/html;charset=utf-8');
        $this->sqlImport($sqlFile);
        @unlink($sqlFile);
        flash_msg('success', 'Database imported successfully. Login again to continue.');
        redirect(site_url('maintenance'));
    }

    private function sqlImport($file) {
        $delimiter = ';';
        $file = fopen($file, 'r');
        $isFirstRow = true;
        $isMultiLineComment = false;
        $sql = '';
        while (!feof($file)) {

            $row = fgets($file);

            // remove BOM for utf-8 encoded file
            if ($isFirstRow) {
                $row = preg_replace('/^\x{EF}\x{BB}\x{BF}/', '', $row);
                $isFirstRow = false;
            }

            // 1. ignore empty string and comment row
            if (trim($row) == '' || preg_match('/^\s*(#|--\s)/sUi', $row)) {
                continue;
            }

            // 2. clear comments
            $row = trim($this->clearSQL($row, $isMultiLineComment));

            // 3. parse delimiter row
            if (preg_match('/^DELIMITER\s+[^ ]+/sUi', $row)) {
                $delimiter = preg_replace('/^DELIMITER\s+([^ ]+)$/sUi', '$1', $row);
                continue;
            }

            // 4. separate sql queries by delimiter
            $offset = 0;
            while (strpos($row, $delimiter, $offset) !== false) {
                $delimiterOffset = strpos($row, $delimiter, $offset);
                if ($this->isQuoted($delimiterOffset, $row)) {
                    $offset = $delimiterOffset + strlen($delimiter);
                } else {
                    $sql = trim($sql . ' ' . trim(substr($row, 0, $delimiterOffset)));
                    $this->query($sql);

                    $row = substr($row, $delimiterOffset + strlen($delimiter));
                    $offset = 0;
                    $sql = '';
                }
            }
            $sql = trim($sql . ' ' . $row);
        }
        if (strlen($sql) > 0) {
            $this->query($row);
        }

        fclose($file);
    }

    /**
     * Remove comments from sql
     *
     * @param string sql
     * @param boolean is multicomment line
     * @return string
     */
    private function clearSQL($sql, &$isMultiComment) {
        if ($isMultiComment) {
            if (preg_match('#\*/#sUi', $sql)) {
                $sql = preg_replace('#^.*\*/\s*#sUi', '', $sql);
                $isMultiComment = false;
            } else {
                $sql = '';
            }
            if (trim($sql) == '') {
                return $sql;
            }
        }

        $offset = 0;
        while (preg_match('{--\s|#|/\*[^!]}sUi', $sql, $matched, PREG_OFFSET_CAPTURE, $offset)) {
            list($comment, $foundOn) = $matched[0];
            if ($this->isQuoted($foundOn, $sql)) {
                $offset = $foundOn + strlen($comment);
            } else {
                if (substr($comment, 0, 2) == '/*') {
                    $closedOn = strpos($sql, '*/', $foundOn);
                    if ($closedOn !== false) {
                        $sql = substr($sql, 0, $foundOn) . substr($sql, $closedOn + 2);
                    } else {
                        $sql = substr($sql, 0, $foundOn);
                        $isMultiComment = true;
                    }
                } else {
                    $sql = substr($sql, 0, $foundOn);
                    break;
                }
            }
        }
        return $sql;
    }

    /**
     * Check if "offset" position is quoted
     *
     * @param int $offset
     * @param string $text
     * @return boolean
     */
    private function isQuoted($offset, $text) {
        if ($offset > strlen($text))
            $offset = strlen($text);

        $isQuoted = false;
        for ($i = 0; $i < $offset; $i++) {
            if ($text[$i] == "'")
                $isQuoted = !$isQuoted;
            if ($text[$i] == "\\" && $isQuoted)
                $i++;
        }
        return $isQuoted;
    }

    private function query($sql) {
        if (!$query = $this->db->query($sql)) {
            throw new Exception("Cannot execute request to the database {$sql}: ");
        }
    }

}
