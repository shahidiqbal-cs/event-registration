<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class File extends CI_Controller {

    private $files_location;

    public function __construct() {
        parent::__construct();
        if (!is_logged()):
            redirect(site_url('login'));
        endif;
        $this->load->helper('directory');
        $this->load->helper('file');
        $this->files_location = 'assets/files';
    }

    private function template($output) {
        $output->ideologies = $this->ideology_model->get_ideologies();
        $this->parser->parse('template', $output);
    }

    function index() {
//        echo '<pre>';
//        print_r($this->get_files_data());
//        exit(0);
        $data = (object) array();
        $data->title = 'Files';
        $data->heading = 'Files';
        $data->heading_desc = 'Files';
        $data->content = 'files';
        $data->files = $this->get_files_data();
        $this->template($data);
    }

    private function get_files_data() {
        $files_with_details = array();
        $files = directory_map($this->files_location);
        foreach ($files as $file):
            $file_path = $this->files_location . '/' . $file;
            $fileinfo = get_file_info($file_path);
            $fileinfo['ext'] = pathinfo($file_path, PATHINFO_EXTENSION);
            $fileinfo['file_name'] = str_replace("_", " ", pathinfo($file_path, PATHINFO_FILENAME));
            $fileinfo['fa_icon'] = $this->get_file_fa_icon_class($fileinfo['ext']);
            $fileinfo['type'] = $this->get_file_type($fileinfo['ext']);
            $fileinfo['size_with_unit'] = $this->get_size_with_unit($fileinfo['size']);
            array_push($files_with_details, $fileinfo);
        endforeach;
        return $files_with_details;
    }

    private function get_size_with_unit($size) {
        if ($size < 1024):
            return $size . ' Byte';
        endif;
        $size = round($size / 1024, 2);
        if ($size < 1024):
            return $size . ' KB';
        endif;
        $size = round($size / 1024, 2);
        if ($size < 1024):
            return $size . ' MB';
        endif;
    }

    private function get_file_fa_icon_class($ext) {
        if ($ext == 'xls' or $ext == 'xlsx'):
            return 'fa-file-excel-o';
        elseif ($ext == 'doc' or $ext == 'docx'):
            return 'fa-file-word-o';
        elseif ($ext == 'ppt' or $ext == 'pptx'):
            return 'fa-file-powerpoint-o';
        elseif ($ext == 'pdf'):
            return 'fa-file-pdf-o';
        elseif ($ext == 'txt'):
            return 'fa-file-text-o';
        elseif ($ext == 'zip' or $ext == 'rar'):
            return 'fa-file-archive-o';
        elseif ($ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'png' or $ext == 'bmp'):
            return 'fa-file-picture-o';
        else:
            return 'fa-file-o';
        endif;
    }

    private function get_file_type($ext) {
        if ($ext == 'xls' or $ext == 'xlsx'):
            return 'Microsoft Excel';
        elseif ($ext == 'doc' or $ext == 'docx'):
            return 'Microsoft Word';
        elseif ($ext == 'ppt' or $ext == 'pptx'):
            return 'Microsoft Powerpoint';
        elseif ($ext == 'pdf'):
            return 'PDF';
        elseif ($ext == 'txt'):
            return 'Notepad';
        elseif ($ext == 'zip' or $ext == 'rar'):
            return 'Compressed';
        elseif ($ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'png' or $ext == 'bmp'):
            return 'Image';
        else:
            return 'File';
        endif;
    }

    function upload() {
        if (user_role() == 'admin'):
            $post_max_size = ini_get('post_max_size');
            strstr($post_max_size, 'M', true);
            $max_size = 2048;
            if (strstr($post_max_size, 'M', true)):
                $max_upload_allowed_size_in_mb = (int) strstr($post_max_size, 'M', true);
                $max_size = $max_upload_allowed_size_in_mb * 1024;
            endif;
            $config['upload_path'] = $this->files_location;
            $config['allowed_types'] = array('doc', 'docx', 'xls', 'xlsx', 'pdf', 'zip', 'rar', 'txt');
            $config['max_size'] = $max_size;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file')):
                flash_msg('error', $this->upload->display_errors(''));
            else:
                flash_msg('success', 'File uploaded successfully.');
            endif;
        endif;
        redirect(site_url('file'));
    }

    function delete() {
        if ($this->input->get('file_url')):
            if (@unlink($this->input->get('file_url'))):
                flash_msg('success', 'File deleted successfully.');
            else:
                flash_msg('error', 'Failed to delete. Try again.');
            endif;
            flash_msg('error', 'Something went wrong. Contact Admin.');
        endif;
        redirect(site_url('file'));
    }

}
