<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://blindsidenetworks.com
 * @since      3.0.0
 *
 * @package    Bigbluebutton
 * @subpackage Bigbluebutton/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      3.0.0
 * @package    Bigbluebutton
 * @subpackage Bigbluebutton/includes
 * @author     Blindside Networks <contact@blindsidenetworks.com>
 */
class VideoConferencingWithBBB {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    3.0.0
	 * @access   protected
	 * @var      Bigbluebutton_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    3.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    3.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    3.0.0
	 */
	public function __construct() {
		if ( defined( 'VIDEO_CONF_WITH_BBB_VERSION' ) ) {
			$this->version = VIDEO_CONF_WITH_BBB_VERSION;
		} else {
			$this->version = '3.0.0';
		}
		$this->plugin_name = 'bigbluebutton';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_global_hooks();
	}

	/**
	 * Global hooks for both public and admin
	 *
	 * @return void
	 */
	public function define_global_hooks() {
		// Resolve conflict with Woffice WordPress theme
		$this->loader->add_filter( 'fw_ext_shortcodes_disable_shortcodes', $this, 'fw_ext_shortcodes_disable_shortcodes' );
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Bigbluebutton_Loader. Orchestrates the hooks of the plugin.
	 * - Bigbluebutton_I18n. Defines internationalization functionality.
	 * - Bigbluebutton_Admin. Defines all hooks for the admin area.
	 * - Bigbluebutton_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    3.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		/**
		 * The activator class
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-bigbluebutton-activator.php';

		/**
		 * The class for all helper functions
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-bigbluebutton-helper.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-bigbluebutton-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-bigbluebutton-i18n.php';

		/**
		 * The class responsible for defining actions specific to the admin area.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-bigbluebutton-admin.php';

		/**
		 * Registration of necessary components for the plugin.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-bigbluebutton-register-custom-types.php';

		/**
		 * Admin area API
		 */
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-bigbluebutton-admin-api.php';

		/**
		 * Admin helper.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'admin/helpers/class-bigbluebutton-admin-helper.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'public/class-bigbluebutton-public.php';

		/**
		 * The class responsible for migrations from previous versions of the plugin to new ones.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-bigbluebutton-migration.php';

		/**
		 * Public facing plugin API
		 */
		require_once plugin_dir_path( __DIR__ ) . 'public/class-bigbluebutton-public-room-api.php';
		require_once plugin_dir_path( __DIR__ ) . 'public/class-bigbluebutton-public-recording-api.php';

		/**
		 * Shortcodes
		 */
		require_once plugin_dir_path( __DIR__ ) . 'public/class-bigbluebutton-public-shortcode.php';

		/**
		 * Widget
		 */
		require_once plugin_dir_path( __DIR__ ) . 'public/class-bigbluebutton-public-widget.php';

		/**
		 * Bigbluebutton API
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-bigbluebutton-api.php';

		/**
		 * Bigbluebutton Recordings helper
		 */
		require_once plugin_dir_path( __DIR__ ) . 'public/helpers/class-bigbluebutton-recording-helper.php';

		/**
		 * Bigbluebutton public view helper
		 */
		require_once plugin_dir_path( __DIR__ ) . 'public/helpers/class-bigbluebutton-display-helper.php';

		/**
		 * Bigbluebutton tokens helper
		 */
		require_once plugin_dir_path( __DIR__ ) . 'public/helpers/class-bigbluebutton-tokens-helper.php';

		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		/**
		 * Bigbluebutton permissions helper
		 */
		require_once plugin_dir_path( __DIR__ ) . 'public/helpers/class-bigbluebutton-permissions-helper.php';

		$this->loader = new Bigbluebutton_Loader();
		//$this->loader->add_action( 'plugins_loaded', $this, 'check_migration' );
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Bigbluebutton_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    3.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Bigbluebutton_I18n();

		$this->loader->add_action( 'init', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    3.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin                       = new Bigbluebutton_Admin( $this->get_plugin_name(), $this->get_version() );
		$plugin_admin_api                   = new Bigbluebutton_Admin_Api();
		$plugin_admin_register_custom_types = new Bigbluebutton_Register_Custom_Types();
		$activator                          = new Bigbluebutton_Activator();

		// Set plugin roles
		$this->loader->add_action( 'admin_init', $activator, 'admin_init' );

		// Suggest not disabling heartbeat.
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'check_for_heartbeat_script' );

		$this->loader->add_action( 'admin_notices', $plugin_admin, 'notice_review_plugin', 999 );

		// Dismiss admin dashboard notices.
		$this->loader->add_action( 'wp_ajax_dismissed_notice_handler', $plugin_admin_api, 'dismiss_admin_notices' );

		// Show update notice.
		$this->loader->add_action( 'in_plugin_update_message-bigbluebutton/bigbluebutton-plugin.php', $plugin_admin, 'bigbluebutton_show_upgrade_notification', 10, 2 );

		// Register bbb-rooms and custom fields.
		$this->loader->add_action( 'init', $plugin_admin_register_custom_types, 'bbb_room_as_post_type' );
		$this->loader->add_action( 'init', $plugin_admin_register_custom_types, 'bbb_room_category_as_taxonomy_type' );
		$this->loader->add_action( 'init', $plugin_admin_register_custom_types, 'flush_rewrite_rules_maybe', 20 );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Hide viewing other's rooms in rooms list.
		$this->loader->add_filter( 'pre_get_posts', $plugin_admin, 'filter_rooms_list' );

		// Create admin menu.
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'create_admin_menu' );
		$this->loader->add_filter( 'parent_file', $plugin_admin, 'bbb_set_current_menu' );

		// Add room metadata hooks.
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin_register_custom_types, 'register_room_code_metaboxes' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin_register_custom_types, 'register_record_room_metabox' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin_register_custom_types, 'register_wait_for_moderator_metabox' );
		$this->loader->add_action( 'save_post_bbb-room', $plugin_admin_api, 'save_bbb_room', 999, 3 );

		// Show custom fields in rooms table.
		$this->loader->add_action( 'manage_posts_custom_column', $plugin_admin, 'bbb_room_custom_columns', 10, 2 );
		$this->loader->add_filter( 'manage_bbb-room_posts_columns', $plugin_admin, 'add_custom_room_column_to_list' );

		// Show taxonomy filter in rooms table
		$this->loader->add_action( 'restrict_manage_posts', $plugin_admin, 'bbb_filter_post_type_by_taxonomy' );
		$this->loader->add_filter( 'parse_query', $plugin_admin, 'bbb_convert_id_to_term_in_query' );

		// Order posts by menu order
		$this->loader->add_action( 'pre_get_posts', $plugin_admin, 'bbb_order_rooms' );

		// Start meeting from admin
		$this->loader->add_action( 'init', $plugin_admin, 'bbb_start_meeting_admin' );

		// Add contextual help tab
		$this->loader->add_action( 'current_screen', $plugin_admin, 'add_help_tab' );
	}

	/**
	 * Register all of the hooks related to Bigbluebutton_Public the public-facing functionality
	 * of the plugin.
	 *
	 * @since    3.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public               = new Bigbluebutton_Public( $this->get_plugin_name(), $this->get_version() );
		$plugin_public_shortcode     = new Bigbluebutton_Public_Shortcode();
		$plugin_public_room_api      = new Bigbluebutton_Public_Room_Api( $this->get_plugin_name(), $this->get_version() );
		$plugin_public_recording_api = new Bigbluebutton_Public_Recording_Api();

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Enqueue dashicon icons for front end.
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_front_end_dashicons' );

		// Display join room form.
		$this->loader->add_filter( 'the_content', $plugin_public, 'bbb_room_content' );

		// Wait for moderator Heartbeat API calls.
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_heartbeat' );
		$this->loader->add_filter( 'query_vars', $plugin_public, 'add_query_vars' );

		// Join room API.
		$this->loader->add_action( 'init', $plugin_public_room_api, 'bbb_user_join_room' );
		$this->loader->add_filter( 'heartbeat_received', $plugin_public_room_api, 'bbb_check_meeting_state', 10, 2 );
		$this->loader->add_filter( 'heartbeat_nopriv_received', $plugin_public_room_api, 'bbb_check_meeting_state', 10, 2 );

		// Manage recording state API.
		$this->loader->add_action( 'wp_ajax_set_bbb_recording_publish_state', $plugin_public_recording_api, 'set_bbb_recording_publish_state' );
		$this->loader->add_action( 'wp_ajax_nopriv_set_bbb_recording_publish_state', $plugin_public_recording_api, 'set_bbb_recording_publish_state' );
		$this->loader->add_action( 'wp_ajax_set_bbb_recording_protect_state', $plugin_public_recording_api, 'set_bbb_recording_protect_state' );
		$this->loader->add_action( 'wp_ajax_nopriv_set_bbb_recording_protect_state', $plugin_public_recording_api, 'set_bbb_recording_protect_state' );
		$this->loader->add_action( 'wp_ajax_trash_bbb_recording', $plugin_public_recording_api, 'trash_bbb_recording' );
		$this->loader->add_action( 'wp_ajax_nopriv_trash_bbb_recording', $plugin_public_recording_api, 'trash_bbb_recording' );

		// Edit recording actions.
		$this->loader->add_action( 'wp_ajax_set_bbb_recording_edits', $plugin_public_recording_api, 'set_bbb_recording_edits' );
		$this->loader->add_action( 'wp_ajax_nopriv_set_bbb_recording_edits', $plugin_public_recording_api, 'set_bbb_recording_edits' );

		// Manage shortcodes.
		$this->loader->add_action( 'init', $plugin_public_shortcode, 'register_shortcodes' );
		$this->loader->add_action( 'wp_ajax_view_join_form', $plugin_public_room_api, 'get_join_form' );
		$this->loader->add_action( 'wp_ajax_nopriv_view_join_form', $plugin_public_room_api, 'get_join_form' );

		// Register widget.
		$this->loader->add_action( 'widgets_init', $plugin_public, 'register_widget' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    3.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     3.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     3.0.0
	 * @return    Bigbluebutton_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     3.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

		/**
		 * Resolve conflict with Woffice WordPress theme
		 *
		 * @param [array] $to_disable
		 * @return array
		 */
	public function fw_ext_shortcodes_disable_shortcodes( $to_disable ) {
		$to_disable[] = 'bigbluebutton';

		return $to_disable;
	}
}
