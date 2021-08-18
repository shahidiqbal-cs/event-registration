<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    private $db_name;

    public function __construct() {
        parent::__construct();
        $this->db_name = 'tfw';
    }

    function index() {
        if (!is_logged() && (user_role() != 'admin')):
            redirect(site_url('login'));
        endif;
        $data = (object) array();
        $data->title = 'Dashboard';
        $data->heading = 'Dashboard';
        $data->heading_desc = 'Control panel';
        $data->content = 'dashboard';
        $this->template($data);
    }

    private function template($output) {
        $this->parser->parse('template', $output);
    }

    function drop_db() {
        if (!is_logged() && (user_role() != 'admin')):
            redirect(site_url('login'));
        endif;
        if ($this->input->post()) :
            $confirm = $this->input->post('confirm');
            if ($confirm):
                $this->load->dbutil();
                if ($this->dbutil->database_exists($this->db_name)):
                    $this->load->dbforge();
                    if ($this->dbforge->drop_database($this->db_name)):
                        flash_msg('success', 'All data and database removed.');
                    else:
                        flash_msg('error', 'Something goes wrong. Try again!');
                    endif;
                else:
                    flash_msg('error', 'Database not exists.');
                endif;
            else:
                flash_msg('error', 'You should confirm before remove Data and database.');
            endif;
            redirect(current_url());
        else:
            $data = (object) array();
            $data->title = 'Remove Database';
            $data->heading = 'Remove Database';
            $data->heading_desc = 'Remove Database';
            $data->content = 'drop_db';
            $this->template($data);
        endif;
    }

    function new_db() {
        if (!is_logged() && (user_role() != 'admin')):
            redirect(site_url('login'));
        endif;
        $data = (object) array();
        $data->title = 'New Database';
        $data->heading = 'New Database';
        $data->heading_desc = 'New Database';
        $data->content = 'new_db';
        $this->template($data);
    }

    function login() {
        if (is_logged()):
            redirect(site_url());
        endif;
        if ($this->form_validation->run('login') == FALSE) :
            $this->load->view('login');
        else:
            $user_name = $this->input->post('user_name');
            $password = $this->input->post('password');
            if ($user_name == 'admin' && $password == md5('admin')) :
                $userId = 'admin';
                $name = 'admin';
                $user_role = 'admin';
                logged_in_user($userId, $name, $user_role);
            else:
                flash_msg('error', 'Wrong user name/password');
            endif;
            redirect(current_url());
        endif;
    }

    function logout() {
        logout();
        redirect(site_url());
    }

    private function upload_file() {
        $config['upload_path'] = 'assets';
        $config['allowed_types'] = 'zip';
        $config['overwrite'] = true;
        $config['max_size'] = 2048;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('sqlfile')) :
            flash_msg('error', $this->upload->display_errors('', ''));
            redirect(site_url('admin/new_db'));
        endif;
        $uploadData = $this->upload->data();
        $uploadedFilePath = $config['upload_path'] . '/' . $uploadData['file_name'];
        $uploadedFileInfo = pathinfo($uploadedFilePath);
        if ($uploadedFileInfo['extension'] != 'zip'):
            @unlink($uploadedFilePath);
            flash_msg('error', 'File is corrupted.');
            redirect(site_url('admin/new_db'));
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
        $this->create_db();
        $sqlFile = $this->get_sql_file($uploadedFilePath);
        @unlink($uploadedFilePath);
        if (!$sqlFile):
            flash_msg('error', 'File is corrupted.');
            redirect(site_url('admin/new_db'));
        endif;
        set_time_limit(0);
        ini_set('default_charset', 'utf-8');

        header('Content-Type: text/html;charset=utf-8');
        $this->sqlImport($sqlFile);
        @unlink($sqlFile);
        flash_msg('success', 'Database imported with Peak MB: ' . memory_get_peak_usage(true) / 1024 / 1024);
        redirect(site_url('admin/new_db'));
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

    private function create_db() {
        $this->load->dbutil();
        if (!$this->dbutil->database_exists($this->db_name)):
            $this->load->dbforge();
            if (!$this->dbforge->create_database($this->db_name)):
                flash_msg('error', 'Error creating database. Try again!');
                redirect(site_url('admin/new_db'));
            endif;
        endif;
        $this->load->database('tfw_db', FALSE, TRUE);
    }

}
