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
 * Plugin Name:       Virtual Classroom for WordPress
 * Plugin URI:        https://wordpress.org/plugins/video-conferencing-with-bbb
 * Description:       This plugin allows teachers to manage their virtual classrooms right from WordPress using BigBlueButton
 * Version:           2.3.1
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
		'VIDEO_CONF_WITH_BBB_VERSION'     => esc_html( $plugin_data['Version'] ),
		'VIDEO_CONF_WITH_BBB_ENDPOINT'    => 'https://test-install.blindsidenetworks.com/bigbluebutton/',
		'VIDEO_CONF_WITH_BBB_SALT'        => '8cd8ef52e8e101574e400365b55e11a6',
		'VIDEO_CONF_WITH_BBB_PLUGIN_NAME' => esc_html( $plugin_data['Name'] ),
		'VIDEO_CONF_WITH_BBB_PUBLIC_PATH' => __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR,
		'VIDEO_CONF_WITH_BBB_IMG_URL'     => plugin_dir_url( __FILE__ ) . '/images',
		'VIDEO_CONF_WITH_BBB_PRO'         => esc_url( 'https://elearningevolve.com/products/wp-virtual-classroom/' ),
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
function ee_activate_video_conf_with_bbb() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bigbluebutton-activator.php';
	Bigbluebutton_Activator::activate();
}
register_activation_hook( __FILE__, 'ee_activate_video_conf_with_bbb' );

//add_action( 'admin_init', 'ee_activate_video_conf_with_bbb', 1 );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bigbluebutton-deactivator.php
 */
// function deactivate_video_conf_bbb() {
// 	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bigbluebutton-deactivator.php';
// 	Bigbluebutton_Deactivator::deactivate();
// }
//register_deactivation_hook( __FILE__, 'deactivate_video_conf_bbb' );

// Show plugin conflict notice
add_action(
	'admin_notices',
	function() {
		$notice = get_transient( 'video_conf_bbb_conflict_notice' );
		if ( $notice ) {
			echo '<div class="error"><p>' . wp_kses( $notice, 'br' ) . '</p></div>';
		}
	}
);

/**
 * Check plugin conflicts.
 *
 */
function video_conf_bbb_check_conflict( $is_echo = true ) {

	$conflict_basenames = array( 'bigbluebutton/bigbluebutton.php', 'bbb-administration-panel/bigbluebutton-plugin.php' );

	foreach ( $conflict_basenames as $basename ) {
		$conf_plugin_file = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $basename;
		if ( file_exists( $conf_plugin_file ) ) {
			$plugin_data                   = get_plugin_data( $conf_plugin_file );
			$plugins[ $basename ]['msg']   = sprintf( __( '%1$s is not compatible with %2$s. Please deactivate %1$s before activating %2$s.', 'bigbluebutton' ), '<strong>' . esc_html( VIDEO_CONF_WITH_BBB_PLUGIN_NAME ) . '</strong>', '<strong> ' . esc_html( $plugin_data['Name'] ) . ' </strong>' );
			$plugins[ $basename ]['class'] = $plugin_data['Name'];
		}
	}

	if ( isset( $plugins ) ) {
		foreach ( $plugins as $basename => $plugin ) {
			if ( is_plugin_active( $basename ) || is_plugin_active_for_network( $basename )
				|| defined( $plugin['class'] ) || ( isset( $_REQUEST['plugin'] ) && isset( $_REQUEST['action'] ) && 'activate' == $_REQUEST['action'] && $basename == $_REQUEST['plugin'] ) ) {

				if ( isset( $_GET['activate'] ) ) {
					unset( $_GET['activate'] );
				}

				deactivate_plugins( $basename );

				if ( $is_echo ) {
					set_transient( 'video_conf_bbb_conflict_notice', $plugin['msg'], 3 );
				}

				return $plugin['msg'];
			}
		}
	}

	return false;
}

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
if ( ! function_exists( 'run_video_conf_bbb' ) && ! video_conf_bbb_check_conflict() ) {
	function run_video_conf_bbb() {

		$plugin = new VideoConferencingWithBBB();
		$plugin->run();

	}
	run_video_conf_bbb();
}

