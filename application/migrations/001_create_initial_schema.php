<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Initial database schema for the Event Registration System.
 */
class Migration_Create_initial_schema extends CI_Migration {

    /** Tables in creation order; down() drops them in reverse. */
    private $tables = array(
        'region', 'zone', 'city', 'halqa',
        'ideology', 'propagation', 'intazami', 'majlis_amomi',
        'event', 'event_title', 'participant', 'registration',
        'feedback', 'numbers', 'options', 'user',
    );

    public function up()
    {
        $statements = array(

            "CREATE TABLE `region` (
				`region_id` int NOT NULL AUTO_INCREMENT,
				`region_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`region_description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				PRIMARY KEY (`region_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8",

            "CREATE TABLE `zone` (
				`zone_id` int NOT NULL AUTO_INCREMENT,
				`region_id` int NOT NULL,
				`zone_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`zone_description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				PRIMARY KEY (`zone_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8",

            "CREATE TABLE `city` (
				`city_id` int NOT NULL AUTO_INCREMENT,
				`zone_id` int unsigned NOT NULL,
				`city_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`city_name_english` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
				`city_description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				PRIMARY KEY (`city_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8",

            "CREATE TABLE `halqa` (
				`halqa_id` int NOT NULL AUTO_INCREMENT,
				`city_id` int NOT NULL,
				`halqa_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`halqa_description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				PRIMARY KEY (`halqa_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8",

            "CREATE TABLE `ideology` (
				`ideology_id` int unsigned NOT NULL AUTO_INCREMENT,
				`ideology_status` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				PRIMARY KEY (`ideology_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8",

            "CREATE TABLE `propagation` (
				`propagation_id` int unsigned NOT NULL AUTO_INCREMENT,
				`propagation_status` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`propagation_description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				PRIMARY KEY (`propagation_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8",

            "CREATE TABLE `intazami` (
				`intazami_id` int NOT NULL AUTO_INCREMENT,
				`intazami_status` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				PRIMARY KEY (`intazami_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8",

            "CREATE TABLE `majlis_amomi` (
				`majlis_amomi_id` int NOT NULL AUTO_INCREMENT,
				`majlis_amomi_status` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`majlis_amomi_description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				PRIMARY KEY (`majlis_amomi_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8",

            "CREATE TABLE `event` (
				`event_id` int unsigned NOT NULL AUTO_INCREMENT,
				`event_name` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`event_date` date NOT NULL,
				`event_location` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`event_header` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`organizer` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`organizer_id` int unsigned NOT NULL,
				`participants_organization` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`organization_ids` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`selected_ideology` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`selected_majlis_amomi` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`selected_propagation` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`selected_intazamia` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				PRIMARY KEY (`event_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8",

            "CREATE TABLE `event_title` (
				`title_id` int NOT NULL AUTO_INCREMENT,
				`event_title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`title_description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				PRIMARY KEY (`title_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8",

            "CREATE TABLE `participant` (
				`participant_id` int NOT NULL AUTO_INCREMENT,
				`name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`father_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`participant_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
				`participant_no` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
				`participant_cnic` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
				`temp_address` text CHARACTER SET utf8 COLLATE utf8_general_ci,
				`permanent_address` text CHARACTER SET utf8 COLLATE utf8_general_ci,
				`ideology_id` int unsigned NOT NULL,
				`propagation_id` int unsigned NOT NULL,
				`majlis_amomi_id` int NOT NULL DEFAULT '0',
				`intazami_id` int NOT NULL DEFAULT '0',
				`administrative_status` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
				`participant_status` tinyint unsigned NOT NULL DEFAULT '1',
				`participant_status_text` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
				`comments` text CHARACTER SET utf8 COLLATE utf8_general_ci,
				`city_id` int unsigned NOT NULL DEFAULT '1',
				`blood_group` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
				PRIMARY KEY (`participant_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8",

            "CREATE TABLE `registration` (
				`registration_id` int unsigned NOT NULL AUTO_INCREMENT,
				`event_id` int unsigned NOT NULL,
				`participant_id` int unsigned NOT NULL,
				`registration_status` tinyint unsigned NOT NULL DEFAULT '0',
				`on_leave` tinyint unsigned NOT NULL DEFAULT '0',
				`leave_date_time` datetime NOT NULL,
				`registration_time` datetime NOT NULL,
				PRIMARY KEY (`registration_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8",

            "CREATE TABLE `feedback` (
				`feedback_id` int NOT NULL AUTO_INCREMENT,
				`feedbacker_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`feedback_type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`feedback` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`feedback_dev` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				PRIMARY KEY (`feedback_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8",

            "CREATE TABLE `numbers` (
				`id` int NOT NULL AUTO_INCREMENT,
				`name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
				`number` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1",

            "CREATE TABLE `options` (
				`option_id` int unsigned NOT NULL AUTO_INCREMENT,
				`option_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
				`option_value` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
				PRIMARY KEY (`option_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1",

            "CREATE TABLE `user` (
				`user_id` int NOT NULL AUTO_INCREMENT,
				`user_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`user_password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`user_role` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				`last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				PRIMARY KEY (`user_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8",
        );

        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        foreach ($statements as $sql)
        {
            $this->db->query($sql);
        }
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
    }

    public function down()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        foreach (array_reverse($this->tables) as $table)
        {
            $this->dbforge->drop_table($table, TRUE);
        }
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
    }
}
