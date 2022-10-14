<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              Studio14online.co.uk
 * @since             1.0.0
 * @package           Rise_Events_Users_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Rise Events Users Plugin
 * Plugin URI:        rise-wp-theme
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area to show all registered candidates for a RISE event.
 * Version:           1.0.0
 * Author:            Studio14
 * Author URI:        Studio14online.co.uk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rise-events-users-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'RISE_EVENTS_USERS_PLUGIN_VERSION', '1.0.0' );
define( 'RISE_EVENTS_USERS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'RISE_EVENTS_USERS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rise-events-users-plugin-activator.php
 */
function activate_rise_events_users_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rise-events-users-plugin-activator.php';
	$activator = new Rise_Events_Users_Plugin_Activator();
	$activator->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rise-events-users-plugin-deactivator.php
 */
function deactivate_rise_events_users_plugin() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-rise-events-users-plugin-activator.php';
    $activator = new Rise_Events_Users_Plugin_Activator();


	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rise-events-users-plugin-deactivator.php';
    $deactivator = new Rise_Events_Users_Plugin_Deactivator($activator);
	$deactivator->deactivate();
}

register_activation_hook( __FILE__, 'activate_rise_events_users_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_rise_events_users_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-rise-events-users-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_rise_events_users_plugin() {

	$plugin = new Rise_Events_Users_Plugin();
	$plugin->run();

}
run_rise_events_users_plugin();
