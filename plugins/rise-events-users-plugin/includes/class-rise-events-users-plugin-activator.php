<?php

/**
 * Fired during plugin activation
 *
 * @link       Studio14online.co.uk
 * @since      1.0.0
 *
 * @package    Rise_Events_Users_Plugin
 * @subpackage Rise_Events_Users_Plugin/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Rise_Events_Users_Plugin
 * @subpackage Rise_Events_Users_Plugin/includes
 * @author     Studio14 <support@studio14online.co.uk>
 */
class Rise_Events_Users_Plugin_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function activate() {

	    global $wpdb;

	    if($wpdb->get_var("SHOW tables like '".$this->wp_rise_events_registration_tbl()."'") != $this->wp_rise_events_registration_tbl()){

            //Dynamic table generating Code

            $table_query = "CREATE TABLE `".$this->wp_rise_events_registration_tbl()."` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `first_name` varchar(150) DEFAULT NULL,
                         `surname` varchar(150) DEFAULT NULL,
                         `business_name` varchar(200) DEFAULT NULL,
                         `job_title` varchar(150) DEFAULT NULL,
                         `telephone` varchar(150) DEFAULT NULL,
                         `website` varchar(150) DEFAULT NULL,
                         `business_sector` varchar(150) DEFAULT NULL,
                         `business_location` varchar(150) DEFAULT NULL,
                         `business_number` varchar(150) DEFAULT NULL,
                         `email` varchar(150) DEFAULT NULL,
                         `rise_member_status` varchar(150) DEFAULT NULL,
                         `rise_event_title` varchar(200) DEFAULT NULL,
                         `rise_events_post_id` int(11) DEFAULT NULL,
                         `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                         `event_start_date` date DEFAULT NULL,
                         `event_end_date` date DEFAULT NULL,
                         PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4"; //Table creation query

            require_once (ABSPATH .'wp-admin/includes/upgrade.php');
            dbDelta($table_query);

        }

	}



    public function wp_rise_events_registration_tbl(){
        global $wpdb;

        return $wpdb->prefix ."rise_events_registration_tbl"; // $wpdb->prefix => wp_
    }

}
