<?php
/**
 * The shortcode for the plugin.
 *
 * @link       https://blindsidenetworks.com
 * @since      3.0.0
 *
 * @package    Bigbluebutton
 * @subpackage Bigbluebutton/public
 */

/**
 * The shortcode for the plugin.
 *
 * Registers the shortcode and handles displaying the shortcode.
 *
 * @package    Bigbluebutton
 * @subpackage Bigbluebutton/public
 * @author     Blindside Networks <contact@blindsidenetworks.com>
 */
class Bigbluebutton_Public_Shortcode {

	/**
	 * Register bigbluebutton shortcodes.
	 *
	 * @since   3.0.0
	 */
	public function register_shortcodes() {
		add_shortcode( 'bigbluebutton', array( $this, 'display_bigbluebutton_shortcode' ) );
		add_shortcode( 'bigbluebutton_recordings', array( $this, 'display_bigbluebutton_old_recordings_shortcode' ) );
	}

	/**
	 * Handle shortcode attributes.
	 *
	 * @since   3.0.0
	 *
	 * @param   Array  $atts       Parameters in the shortcode.
	 * @param   String $content    Content of the shortcode.
	 *
	 * @return  String $content    Content of the shortcode with rooms and recordings.
	 */
	public function display_bigbluebutton_shortcode( $atts = array(), $content = null ) {
		global $pagenow, $post;
		$type           = 'room';
		$post_id        = ( isset( $post->ID ) ? $post->ID : 0 );
		$author         = (int) get_the_author_meta( 'ID' );
		$display_helper = new Bigbluebutton_Display_Helper( plugin_dir_path( __FILE__ ) );

		$room_limit_cpt = intval( get_post_meta( $post_id, 'bbb-room-limit', true ) );
		if ( $room_limit_cpt ) {
			update_post_meta( $post_id, 'bbb_pro_room_limit', sanitize_text_field( $room_limit_cpt ) );
		}

		if ( $post_id && isset( $atts['room_limit'] ) && $atts['room_limit'] ) {
			update_post_meta( $post_id, 'bbb_pro_room_limit', sanitize_text_field( $atts['room_limit'] ) );
		}

		if ( ! Bigbluebutton_Tokens_Helper::can_display_room_on_page() ) {
			return $content;
		}

		if ( array_key_exists( 'type', $atts ) && 'recording' == $atts['type'] ) {
			$type = 'recording';
			unset( $atts['type'] );
		}

		$tokens_string = Bigbluebutton_Tokens_Helper::get_token_string_from_atts( $atts );

		if ( 'room' == $type ) {
			$content .= Bigbluebutton_Tokens_Helper::join_form_from_tokens_string( $display_helper, $tokens_string, $author );
		} elseif ( 'recording' == $type ) {
			$content .= Bigbluebutton_Tokens_Helper::recordings_table_from_tokens_string( $display_helper, $tokens_string, $author );
		}
		return $content;
	}

	/**
	 * Shows recordings for the old recordings shortcode format.
	 *
	 * @since   3.0.0
	 * @param   Array  $atts       Parameters in the shortcode.
	 * @param   String $content    Content of the shortcode.
	 *
	 * @return  String $content    Content of the shortcode with recordings.
	 */
	public function display_bigbluebutton_old_recordings_shortcode( $atts = array(), $content = null ) {
		$atts['type'] = 'recording';
		return $this->display_bigbluebutton_shortcode( $atts, $content );
	}
}
