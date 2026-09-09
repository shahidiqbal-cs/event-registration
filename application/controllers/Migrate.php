<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Command-line migration runner.
 *
 *   php index.php migrate              migrate up to the latest version
 *   php index.php migrate version 0    roll everything back
 *   php index.php migrate version 1    migrate to a specific version
 */
class Migrate extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if ( ! is_cli())
        {
            show_error('The migration runner is only available from the command line.', 403);
        }

        $this->load->library('migration');
    }

    public function index()
    {
        $this->latest();
    }

    public function latest()
    {
        if ($this->migration->latest() === FALSE)
        {
            $this->fail();
        }

        $this->config->load('migration', TRUE);
        fwrite(STDOUT, 'Database migrated to the latest version ('.(int) $this->config->item('migration_version', 'migration').').'.PHP_EOL);
    }

    public function version($target)
    {
        if ($this->migration->version((int) $target) === FALSE)
        {
            $this->fail();
        }

        fwrite(STDOUT, 'Database migrated to version '.(int) $target.'.'.PHP_EOL);
    }

    private function fail()
    {
        fwrite(STDERR, $this->migration->error_string().PHP_EOL);
        exit(1);
    }
}
