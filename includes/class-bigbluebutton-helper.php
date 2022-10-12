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
class EE_Bigbluebutton_Helper {
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
		} elseif ( isset( $_GET['bbb_meeting_username'] ) ) {
			$username = sanitize_text_field( $_GET['bbb_meeting_username'] );
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

			$m_info = Bigbluebutton_Api::get_meeting_info( $room_id );
			if ( $m_info && isset( $m_info->participantCount ) && $room_limit_global ) {
				$room_limit_global += 1; // Keep atleast one partc space incase of disconnection issues
				if ( $m_info->participantCount >= $room_limit_global ) {
					$query = array(
						'max_user_error' => true,
						'room_id'        => $room_id,
						'username'       => $username,
					);
					wp_redirect( add_query_arg( $query, $return_url ) );
					exit;
				}
			}
		}
	}
}
