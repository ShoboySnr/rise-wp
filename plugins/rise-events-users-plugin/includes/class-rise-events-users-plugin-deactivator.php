<?php

/**
 * Fired during plugin deactivation
 *
 * @link       Studio14online.co.uk
 * @since      1.0.0
 *
 * @package    Rise_Events_Users_Plugin
 * @subpackage Rise_Events_Users_Plugin/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Rise_Events_Users_Plugin
 * @subpackage Rise_Events_Users_Plugin/includes
 * @author     Studio14 <support@studio14online.co.uk>
 */
class Rise_Events_Users_Plugin_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */

	private $table_activator;

	public function __construct($activator)
    {
        $this->table_activator = $activator;
    }

    public function deactivate() {

	    global $wpdb;
	        //drop tables when plugin uninstalls

        $wpdb->query("DROP TABLE IF EXISTS" . $this->table_activator->wp_rise_events_registration_tbl() );

	}

}
