<?php
/**
 * Register all helpers
 *
 * @link       elearningevolve.com
 * @since      1.0.0
 *
 * @package    Bigbluebuttonpro
 * @subpackage Bigbluebuttonpro/includes
 */
class EE_VCBBB_Helper {
	/**
	 * Check if rest or json request
	 *
	 */
	public static function check_if_rest_or_json() {

		if ( defined( 'WC_API_REQUEST' ) || defined( 'JSON_REQUEST' ) || defined( 'WP_CLI' )
			|| defined( 'DOING_CRON' ) || defined( 'REST_REQUEST' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if this is a REST request from an app-style course portal (FluentCommunity
	 * lessons) that renders lesson content through the_content.
	 *
	 * @since 3.2.16
	 * @return bool
	 */
	public static function is_course_portal_rest_request() {
		if ( ! defined( 'REST_REQUEST' ) || ! REST_REQUEST ) {
			return false;
		}

		/*
		 * During REST, core stores the path on $wp->query_vars['rest_route']
		 * (see rest_api_loaded()) before WP_Query is fully populated — so read
		 * $wp first. get_query_var() is a secondary source when available.
		 * Using global $wp avoids $GLOBALS (WP coding standards / Plugin Check).
		 */
		global $wp;
		$route = '';
		if ( isset( $wp->query_vars['rest_route'] ) && is_string( $wp->query_vars['rest_route'] ) ) {
			$route = $wp->query_vars['rest_route'];
		} elseif ( function_exists( 'get_query_var' ) ) {
			$route = (string) get_query_var( 'rest_route', '' );
		}
		$route = '/' . ltrim( $route, '/' );

		$is_portal = ( 0 === strpos( $route, '/fluent-community/' ) && false !== strpos( $route, '/courses' ) );

		return (bool) apply_filters( 'vcbbb_is_course_portal_rest_request', $is_portal, $route );
	}

	/**
	 * Get user's name for the meeting.
	 *
	 * @since   3.0.0
	 *
	 * @param   Object $user       User object.
	 * @return  String $username   Display of the user for joining the meeting.
	 */
	public static function get_meeting_username( $user = false ) {
		$username = '';

		if ( $user && $user->display_name ) {
			$username = sanitize_text_field( $user->display_name );
		} elseif ( isset( $_GET['bbb_meeting_username'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Public join passes display name via query string; value is sanitized below and does not change site state.
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- See isset ignore above; sanitized public join username.
			$username = sanitize_text_field( wp_unslash( $_GET['bbb_meeting_username'] ) );
		}

		return $username;
	}

	public static function check_room_limit( $room_id, $username = false, $return_url = false, $room_limit_global = false, $room_limit_cpt = false, $room_limit_post = false ) {
		if ( $room_limit_global || $room_limit_post || $room_limit_cpt ) {
			// If cpt limit set then ignore global limit
			if ( $room_limit_cpt ) {
				$room_limit_global = $room_limit_cpt;
			}

			// If post limit set then ignore cpt limit
			if ( $room_limit_post ) {
				$room_limit_global = $room_limit_post;
			}

			if ( ! $room_id ) {
				return;
			}

			$m_info = VCBBB_Api::get_meeting_info( $room_id );
			if ( $m_info && isset( $m_info->participantCount ) && $room_limit_global ) {
				$room_limit_global += 1; // Keep atleast one partc space incase of disconnection issues
				if ( $m_info->participantCount >= $room_limit_global ) {
					$query = array(
						'max_user_error' => true,
						'room_id'        => $room_id,
						'username'       => $username,
					);
					self::safe_redirect( add_query_arg( $query, $return_url ) );
				}
			}
		}
	}

	/**
	 * Timezone string compatible with WordPress 5.1+.
	 *
	 * @since 3.2.3
	 *
	 * @return string
	 */
	public static function get_timezone_string() {
		if ( function_exists( 'wp_timezone_string' ) ) {
			return wp_timezone_string();
		}

		$timezone = get_option( 'timezone_string' );
		if ( ! empty( $timezone ) ) {
			return $timezone;
		}

		$offset    = (float) get_option( 'gmt_offset' );
		$hours     = (int) $offset;
		$minutes   = ( $offset - $hours );
		$sign      = ( $offset < 0 ) ? '-' : '+';
		$abs_hour  = abs( $hours );
		$abs_mins  = abs( $minutes * 60 );

		return sprintf( '%s%02d:%02d', $sign, $abs_hour, $abs_mins );
	}

	/**
	 * Redirect to a same-site URL.
	 *
	 * @since 3.2.3
	 *
	 * @param string $url Destination URL.
	 */
	public static function safe_redirect( $url ) {
		wp_safe_redirect( esc_url_raw( $url ) );
		exit;
	}

	/**
	 * Redirect to a plugin-generated BigBlueButton join URL.
	 *
	 * @since 3.2.3
	 *
	 * @param string $url Destination URL from the BBB API.
	 */
	public static function safe_redirect_bbb( $url ) {
		$url  = esc_url_raw( $url );
		$host = wp_parse_url( $url, PHP_URL_HOST );

		if ( ! empty( $host ) ) {
			add_filter(
				'allowed_redirect_hosts',
				static function ( $hosts ) use ( $host ) {
					$hosts[] = $host;
					return $hosts;
				}
			);
		}

		wp_safe_redirect( $url );
		exit;
	}
}
