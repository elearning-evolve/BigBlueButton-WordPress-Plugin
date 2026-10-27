<?php
/**
 * The views of the plugin.
 *
 * @link       https://blindsidenetworks.com
 * @since      3.0.0
 *
 * @package    Bigbluebutton
 * @subpackage Bigbluebutton/public
 */

/**
 * The views of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Bigbluebutton
 * @subpackage Bigbluebutton/public
 * @author     Blindside Networks <contact@blindsidenetworks.com>
 */
class VCBBB_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    3.0.0
	 * @param    String $plugin_name       The name of the plugin.
	 * @param    String $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    3.0.0
	 */
	public function enqueue_styles() {
		wp_register_style(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'css/bigbluebutton-public.css',
			array(),
			$this->version,
			'all'
		);

		if ( self::should_load_frontend_assets() ) {
			wp_enqueue_style( $this->plugin_name );
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    3.0.0
	 */
	public function enqueue_scripts() {
		$translations = array(
			'expand_recordings'   => __( 'Expand recordings', 'video-conferencing-with-bbb' ),
			'collapse_recordings' => __( 'Collapse recordings', 'video-conferencing-with-bbb' ),
			'edit'                => __( 'Edit', 'video-conferencing-with-bbb' ),
			'published'           => __( 'Published', 'video-conferencing-with-bbb' ),
			'unpublished'         => __( 'Unpublished', 'video-conferencing-with-bbb' ),
			'protected'           => __( 'Protected', 'video-conferencing-with-bbb' ),
			'unprotected'         => __( 'Unprotected', 'video-conferencing-with-bbb' ),
			'ajax_url'            => admin_url( 'admin-ajax.php' ),
			'join_form_nonce'     => wp_create_nonce( 'vcbbb_view_join_form' ),
		);

		wp_register_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/bigbluebutton-public.js',
			array( 'jquery', 'wp-i18n' ),
			$this->version,
			true
		);
		wp_localize_script( $this->plugin_name, 'vcbbb_php_vars', $translations );

		if ( self::should_load_frontend_assets() ) {
			wp_enqueue_script( $this->plugin_name );
		}
	}

	/**
	 * Enqueues dashicon icons for use on front end.
	 *
	 * @since   3.0.0
	 */
	public function enqueue_front_end_dashicons() {
		if ( ! self::should_load_frontend_assets() ) {
			return;
		}

		if ( ! wp_style_is( 'dashicons', 'enqueued' ) ) {
			wp_enqueue_style( 'dashicons' );
		}
	}

	/**
	 * Whether frontend BBB CSS/JS should load on the current request.
	 *
	 * @since 3.2.14
	 *
	 * @return bool
	 */
	public static function should_load_frontend_assets() {
		if ( is_singular( 'bbb-room' ) ) {
			return true;
		}

		if ( get_query_var( 'vcbbb_wait_for_mod' ) ) {
			return true;
		}

		if ( is_active_widget( false, false, 'bigbluebuttonwidget', true ) ) {
			return true;
		}

		if ( ! is_singular() ) {
			return false;
		}

		$post = get_post();
		if ( ! $post instanceof WP_Post ) {
			return false;
		}

		$shortcodes = array( 'bigbluebutton', 'bigbluebutton_recordings', 'video-conferencing-with-bbb' );
		foreach ( $shortcodes as $shortcode ) {
			if ( has_shortcode( $post->post_content, $shortcode ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Enqueue frontend assets when a shortcode or widget renders BBB UI.
	 *
	 * Safe to call after wp_enqueue_scripts; ensures styles/scripts load even when
	 * content comes from builders that store shortcodes outside post_content.
	 *
	 * @since 3.2.14
	 */
	public static function enqueue_frontend_assets() {
		wp_enqueue_style( 'vcbbb' );
		wp_enqueue_script( 'vcbbb' );

		if ( ! wp_style_is( 'dashicons', 'enqueued' ) ) {
			wp_enqueue_style( 'dashicons' );
		}
	}

	/**
	 * Enqueue heartbeat API for viewers to wait for moderator to join the meeting.
	 *
	 * @since   3.0.0
	 */
	public function enqueue_heartbeat() {
		if ( get_query_var( 'vcbbb_wait_for_mod' ) ) {
			wp_enqueue_script( 'heartbeat' );
		}
	}

	/**
	 * Add query vars for conditions.
	 *
	 * @since   3.0.0
	 *
	 * @param   Array $vars List of existing vars that can be queried using WordPress core functions.
	 * @return  Array $vars List of vars that can be queried, including BigBlueButton variables.
	 */
	public function add_query_vars( $vars ) {
		$vars[] = 'vcbbb_wait_for_mod';
		return $vars;
	}

	/**
	 * Display join room button and recordings in the bbb-room post.
	 *
	 * @since   3.0.0
	 *
	 * @param   String $content    Post content as string.
	 * @return  String $content    Post content as string.
	 */
	public function vcbbb_room_content( $content ) {
		global $pagenow;

		if ( ! VCBBB_Tokens_Helper::can_display_room_on_page() ) {
			return $content;
		}

		$room_id = get_the_ID();
		$room_post = get_post( $room_id );

		if ( null === $room_id || false === $room_id || ! $room_post || 'bbb-room' != $room_post->post_type ) {
			return $content;
		}

		$token = 'z' . $room_id;

		// Editors often paste the recommended shortcode into the bbb-room body; this filter also
		// injects the same tag. Without this guard, do_shortcode runs the room twice (duplicate UI).
		if ( ! $this->vcbbb_content_has_room_join_shortcode_for( $content, $room_id ) ) {
			$content .= '[bigbluebutton token="' . esc_attr( $token ) . '"]';
		}

		// Add recordings list to post content if the room is recordable.
		$room_can_record = get_post_meta( $room_id, 'bbb-room-recordable', true );

		if ( 'true' == $room_can_record && ! $this->vcbbb_content_has_recording_shortcode_for( $content, $room_id ) ) {
			$content .= '[bigbluebutton type="recording" token="' . esc_attr( $token ) . '"]';
		}

		return $content;
	}

	/**
	 * Whether post content already includes a (non-recording) BBB shortcode for this room.
	 *
	 * @param string $content Raw post content.
	 * @param int    $room_id bbb-room post ID.
	 * @return bool
	 */
	private function vcbbb_content_has_room_join_shortcode_for( $content, $room_id ) {
		return $this->vcbbb_parse_shortcodes_for_room_token( $content, (int) $room_id, false );
	}

	/**
	 * Whether post content already includes a recording-only BBB shortcode for this room.
	 *
	 * @param string $content Raw post content.
	 * @param int    $room_id bbb-room post ID.
	 * @return bool
	 */
	private function vcbbb_content_has_recording_shortcode_for( $content, $room_id ) {
		return $this->vcbbb_parse_shortcodes_for_room_token( $content, (int) $room_id, true );
	}

	/**
	 * Locate bigbluebutton / legacy shortcode tags that reference a room token.
	 *
	 * @param string $content        Raw post content.
	 * @param int    $room_id        bbb-room post ID.
	 * @param bool   $recording_only True = match type="recording" only; false = match join/room blocks only.
	 * @return bool
	 */
	private function vcbbb_parse_shortcodes_for_room_token( $content, $room_id, $recording_only ) {
		$tags = array( 'bigbluebutton', 'video-conferencing-with-bbb' );
		foreach ( $tags as $tag ) {
			if ( ! has_shortcode( $content, $tag ) ) {
				continue;
			}
			$pattern = '/' . get_shortcode_regex( array( $tag ) ) . '/';
			if ( ! preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER ) ) {
				continue;
			}
			foreach ( $matches as $match ) {
				if ( empty( $match[3] ) ) {
					continue;
				}
				$atts = shortcode_parse_atts( $match[3] );
				if ( ! is_array( $atts ) ) {
					continue;
				}
				$is_recording = isset( $atts['type'] ) && 'recording' === $atts['type'];
				if ( $recording_only ) {
					if ( ! $is_recording ) {
						continue;
					}
				} elseif ( $is_recording ) {
					continue;
				}
				if ( empty( $atts['token'] ) ) {
					continue;
				}
				$tok = preg_replace( '/[^a-zA-Z0-9]+/', '', $atts['token'] );
				$zid = 'z' . $room_id;
				$nid = (string) $room_id;
				if ( $tok === $zid || $tok === $nid ) {
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Ensure core/post-terms markup includes a div before Blockify theme filters run.
	 *
	 * Blockify (render_block_core/post-terms, priority 10) expects a div wrapper when the
	 * block has an align attribute. Core can return empty HTML or non-div markup; older
	 * Blockify then calls getAttribute() on null. Runs at priority 9 so the theme still runs.
	 *
	 * @since 3.0.0
	 *
	 * @param string $html  Rendered block HTML.
	 * @param array  $block Parsed block data.
	 * @return string
	 */
	public function vcbbb_blockify_post_terms_compat( $html, $block ) {
		$attrs = isset( $block['attrs'] ) && is_array( $block['attrs'] ) ? $block['attrs'] : array();
		if ( empty( $attrs['align'] ) ) {
			return $html;
		}
		if ( is_string( $html ) && preg_match( '/<div\b/i', $html ) ) {
			return $html;
		}
		return '<div class="wp-block-post-terms">' . $html . '</div>';
	}

	/**
	 * Register bigbluebutton widget.
	 *
	 * @since   3.0.0
	 */
	public function register_widget() {
		register_widget( 'VCBBB_Public_Widget' );
	}
}
