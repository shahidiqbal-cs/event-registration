<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Seed_data extends CI_Migration
{

    public function up()
    {
        $this->db->query(
            "INSERT INTO `user` (`user_name`, `user_password`, `user_role`) VALUES
				('admin', MD5('admin123'), 'admin'),
				('desk',  MD5('desk123'),  'desk')"
        );

        $this->db->query(
            "INSERT INTO `region` (`region_name`, `region_description`) VALUES
				('Sample Region', '')"
        );
    }

    public function down()
    {
        $this->db->query('TRUNCATE TABLE `user`');
        $this->db->query('TRUNCATE TABLE `region`');
    }
}
