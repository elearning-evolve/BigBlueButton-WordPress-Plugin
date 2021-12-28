<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://elearningevolve.com/
 * @since             3.0.0
 * @package           Bigbluebutton
 *
 * @wordpress-plugin
 * Plugin Name:       BigBlueButton
 * Plugin URI:        https://github.com/elearning-evolve/wordpress-plugin_bigbluebutton
 * Description:       BigBlueButton is an open source web conferencing system. This plugin integrates BigBlueButton into WordPress allowing bloggers to create and manage meetings rooms by using a Custom Post Type. For more information on setting up your own BigBlueButton server or for using an external hosting provider visit http://bigbluebutton.org/support.
 * Version:           3.1.0
 * Author:            eLearning evolve <info@elearningevolve.com>
 * Author URI:        https://elearningevolve.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bigbluebutton
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'get_plugin_data' ) ) {
	include_once ABSPATH . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'plugin.php';
}

if ( function_exists( 'get_plugin_data' ) ) {
	$plugin_data = get_plugin_data( __FILE__ );

	$eevolve_constants = array(
		'BIGBLUEBUTTON_VERSION'     => esc_html( $plugin_data['Version'] ),
		'BIGBLUEBUTTON_PLUGIN_NAME' => esc_html( $plugin_data['Name'] ),
	);

	foreach ( $eevolve_constants as $constant => $value ) {
		if ( ! defined( $constant ) ) {
			define( $constant, $value );
		}
	}
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bigbluebutton-activator.php
 */
function activate_bigbluebutton() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bigbluebutton-activator.php';
	Bigbluebutton_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bigbluebutton-deactivator.php
 */
function deactivate_bigbluebutton() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bigbluebutton-deactivator.php';
	Bigbluebutton_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bigbluebutton' );
register_deactivation_hook( __FILE__, 'deactivate_bigbluebutton' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bigbluebutton.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    3.0.0
 */
function run_bigbluebutton() {

	$plugin = new Bigbluebutton();
	$plugin->run();

}
run_bigbluebutton();
