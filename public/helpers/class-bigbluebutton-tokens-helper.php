<?php
/**
 * The tokens helper to handle creating public facing views.
 *
 * @link       https://blindsidenetworks.com
 * @since      3.0.0
 *
 * @package    Bigbluebutton
 * @subpackage Bigbluebutton/public/helpers
 */

/**
 * The tokens helper to handle creating public facing views.
 *
 * Generates rooms for viewing from tokens.
 *
 * @package    Bigbluebutton
 * @subpackage Bigbluebutton/public/helpers
 * @author     Blindside Networks <contact@blindsidenetworks.com>
 */
class VCBBB_Tokens_Helper {

	/**
	 * The error message if a room cannot be displayed.
	 *
	 * @var String $error_message
	 */
	private static $error_message;

	/**
	 * Get tokens string from shortcode attributes.
	 *
	 * @since   3.0.0
	 * @param   Array $atts              Array of attributes submitted in the shortcode.
	 * @return  String $tokens_string    List of tokens separated by commas.
	 */
	public static function get_token_string_from_atts( $atts ) {
		$tokens_string = '';

		foreach ( $atts as $key => $param ) {
			if ( 'token' == $key ) {
				if ( 'token' == substr( $param, 0, 5 ) ) {
					$param = substr( $param, 5 );
				}
				$tokens_string .= $param;
			} elseif ( 'token' == substr( $param, 0, 5 ) ) {
					$param          = substr( $param, 5 );
					$tokens_string .= ',' . $param;
			}
		}
		return $tokens_string;
	}

	/**
	 * Get join form as an HTML string.
	 *
	 * @since   3.0.0
	 *
	 * @param   VCBBB_Display_Helper $display_helper     Display helper to get HTML from partials.
	 * @param   String                       $token_string       A list of tokens as a string, separated by commas.
	 * @param   Integer                      $author             The author of the content that will display the join form.
	 *
	 * @return  String                          $content            HTML string containing join forms for the corresponding rooms.
	 */
	public static function join_form_from_tokens_string( $display_helper, $token_string, $author ) {
		$content             = '';
		$tokens_arr          = preg_split( '/\,/', $token_string );
		$meta_nonce          = wp_create_nonce( 'vcbbb_join_room_meta_nonce' );
		$access_using_code   = VCBBB_Permissions_Helper::user_has_bbb_cap( 'join_with_access_code_bbb_room' );
		$access_as_moderator = VCBBB_Permissions_Helper::user_has_bbb_cap( 'join_as_moderator_bbb_room' );
		$access_as_viewer    = VCBBB_Permissions_Helper::user_has_bbb_cap( 'join_as_viewer_bbb_room' );
		$rooms               = array();

		foreach ( $tokens_arr as $raw_token ) {
			if ( sanitize_text_field( $raw_token ) == '' ) {
				continue;
			}
			$token   = preg_replace( '/[^a-zA-Z0-9]+/', '', $raw_token );
			$room_id = self::find_room_id_by_token( $token, $author );
			if ( 0 == $room_id ) {
				$content .= '<p>';
				$content .= self::$error_message;
				$content .= '</p>';
				return $content;
			}
			$rooms[] = (object) array(
				'room_id'   => $room_id,
				'room_name' => get_the_title( $room_id ),
			);

			if ( isset( $_REQUEST['room_id'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Selected room from join form (read-only request flag).
				// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- See isset ignore above; sanitized room selector, no site state change here.
				$vcbbb_request_room_id = sanitize_text_field( wp_unslash( $_REQUEST['room_id'] ) );
				if ( $vcbbb_request_room_id == $room_id || base64_decode( $vcbbb_request_room_id ) == $room_id ) {
					$selected_room_id = $room_id;
				}
			}
		}

		if ( count( $rooms ) > 0 ) {
			if ( ! $access_as_moderator ) {
				$first_room_post = get_post( $rooms[0]->room_id );
				$access_as_moderator = ( $first_room_post && get_current_user_id() == $first_room_post->post_author );
			}
			$selected_room = $rooms[0]->room_id;
			if ( isset( $selected_room_id ) ) {
				$selected_room = $selected_room_id;
			}
			$join_form = $display_helper->get_join_form_as_string( $selected_room, $meta_nonce, $access_as_moderator, $access_as_viewer, $access_using_code );
			if ( count( $rooms ) > 1 ) {
				$join_form = $display_helper->get_room_list_dropdown_as_string( $rooms, $selected_room, $join_form );
			}
			$content .= $join_form;
		} else {
			$content = '<p>' . esc_html__( 'There are no rooms in the selection.', 'video-conferencing-with-bbb' ) . '</p>';
		}
		return $content;
	}

	/**
	 * Get recordings table as an HTML string.
	 *
	 * @since   3.0.0
	 *
	 * @param   VCBBB_Display_Helper $display_helper     Display helper to get HTML from partials.
	 * @param   String                       $token_string       A list of tokens as a string, separated by commas.
	 * @param   Integer                      $author             The author of the content that will display the join form.
	 *
	 * @return  String                       $content            HTML string containing recordings from the corresponding rooms.
	 */
	public static function recordings_table_from_tokens_string( $display_helper, $token_string, $author ) {
		$manage_recordings               = VCBBB_Permissions_Helper::user_has_bbb_cap( 'manage_bbb_room_recordings' );
		$view_extended_recording_formats = VCBBB_Permissions_Helper::user_has_bbb_cap( 'view_extended_bbb_room_recording_formats' );
		$tokens_arr                      = preg_split( '/\,/', $token_string );
		$room_ids                        = array();
		$content                         = '';

		foreach ( $tokens_arr as $raw_token ) {
			if ( sanitize_text_field( $raw_token ) == '' ) {
				continue;
			}
			$token   = preg_replace( '/[^a-zA-Z0-9]+/', '', $raw_token );
			$room_id = self::find_room_id_by_token( $token, $author );
			if ( 0 == $room_id ) {
				$content .= '<p>';
				$content .= self::$error_message;
				$content .= '</p>';
				return $content;
			}
			$room_ids[] = $room_id;
		}

		if ( ! $manage_recordings ) {
			$room_ids = array_values( array_filter( $room_ids, array( __CLASS__, 'current_user_can_view_room_recordings' ) ) );
		}

		if ( empty( $room_ids ) ) {
			return $content;
		}

		$recordings = self::get_recordings( $room_ids );
		if ( count( $room_ids ) > 0 ) {
			$content .= $display_helper->get_collapsable_recordings_view_as_string( $room_ids[0], $recordings, $manage_recordings, $view_extended_recording_formats );
		}
		return $content;
	}

	/**
	 * Get rooms or recordings for a course portal lesson (FluentCommunity) as an HTML string.
	 *
	 * Portal lessons are fetched over REST and injected by a JS app, so the join form, its scripts and
	 * the post author are not available there. Rooms are shown as a link to the room page, which runs
	 * the full join flow. Recordings use a self-contained list (inline styles) because plugin CSS/JS
	 * are not loaded in the portal response.
	 *
	 * @since 3.2.16
	 *
	 * @param   VCBBB_Display_Helper $display_helper     Display helper (kept for callers; unused for portal recordings).
	 * @param   String               $token_string       A list of tokens as a string, separated by commas.
	 * @param   String               $type               Either 'room' or 'recording'.
	 *
	 * @return  String               $content            HTML string for the portal lesson.
	 */
	public static function portal_view_from_tokens_string( $display_helper, $token_string, $type ) {
		$room_ids = array();

		foreach ( preg_split( '/\,/', $token_string ) as $raw_token ) {
			$token = preg_replace( '/[^a-zA-Z0-9]+/', '', $raw_token );
			if ( '' == $token ) {
				continue;
			}
			$room_id = ( 'z' == substr( $token, 0, 1 ) )
				? self::check_if_room_exists_for_new_token_format( $token, 0 )
				: self::check_if_room_exists_for_old_token_format( $token, 0 );
			if ( 0 == $room_id ) {
				$error = self::$error_message ? self::$error_message : esc_html__( 'The room linked to this resource is not configured correctly.', 'video-conferencing-with-bbb' );
				return '<p>' . $error . '</p>';
			}
			$room_ids[] = $room_id;
		}

		if ( empty( $room_ids ) ) {
			return '<p>' . esc_html__( 'There are no rooms in the selection.', 'video-conferencing-with-bbb' ) . '</p>';
		}

		if ( 'recording' == $type ) {
			$manage_recordings               = VCBBB_Permissions_Helper::user_has_bbb_cap( 'manage_bbb_room_recordings' );
			$view_extended_recording_formats = VCBBB_Permissions_Helper::user_has_bbb_cap( 'view_extended_bbb_room_recording_formats' );

			if ( ! $manage_recordings ) {
				$room_ids = array_values( array_filter( $room_ids, array( __CLASS__, 'current_user_can_view_room_recordings' ) ) );
			}

			if ( empty( $room_ids ) ) {
				return '<p>' . esc_html__( 'This room does not currently have any recordings.', 'video-conferencing-with-bbb' ) . '</p>';
			}

			$recordings = self::get_recordings( $room_ids );
			return self::portal_recordings_list_html( $recordings, $view_extended_recording_formats );
		}

		$content = '';
		foreach ( $room_ids as $room_id ) {
			// Inline styles keep the button usable in course portals that inject HTML without this plugin's CSS.
			$link = sprintf(
				'<p class="bbb-portal-room"><a class="bbb-button bbb-btn-join" href="%1$s" target="_blank" rel="noopener noreferrer" style="display:inline-block;padding:10px 20px;border-radius:4px;background:#0073aa;color:#fff;text-decoration:none;">%2$s</a></p>',
				esc_url( get_permalink( $room_id ) ),
				esc_html(
					sprintf(
						/* translators: %s: room name */
						__( 'Join %s', 'video-conferencing-with-bbb' ),
						get_the_title( $room_id )
					)
				)
			);
			$content .= apply_filters( 'vcbbb_portal_room_link_html', $link, $room_id );
		}
		return $content;
	}

	/**
	 * Build a self-contained recordings list for course portals (no plugin CSS/JS required).
	 *
	 * @since 3.2.16
	 *
	 * @param array $recordings                       Recording objects from the BBB API helper.
	 * @param bool  $view_extended_recording_formats Whether extended playback formats may be used.
	 * @return string HTML list for the portal lesson.
	 */
	private static function portal_recordings_list_html( $recordings, $view_extended_recording_formats ) {
		if ( empty( $recordings ) || ! is_array( $recordings ) ) {
			return '<p class="bbb-portal-no-recordings">' . esc_html__( 'This room does not currently have any recordings.', 'video-conferencing-with-bbb' ) . '</p>';
		}

		$date_format                  = get_option( 'date_format' ) ? get_option( 'date_format' ) : 'Y-m-d';
		$default_bbb_recording_format = 'presentation';
		$rows                         = '';

		foreach ( $recordings as $recording ) {
			if ( ! is_object( $recording ) ) {
				continue;
			}

			// Match room-page behaviour: unpublished playback links stay hidden for viewers.
			if ( isset( $recording->published ) && 'false' === (string) $recording->published ) {
				continue;
			}

			$name = '';
			if ( isset( $recording->metadata->{'recording-name'} ) ) {
				$name = urldecode( (string) $recording->metadata->{'recording-name'} );
			}
			if ( '' === $name && isset( $recording->name ) ) {
				$name = urldecode( (string) $recording->name );
			}
			if ( '' === $name ) {
				$name = __( 'Recording', 'video-conferencing-with-bbb' );
			}

			$date = '';
			if ( isset( $recording->startTime ) ) {
				$date = date_i18n( $date_format, (int) ( $recording->startTime / 1000 ) );
			}

			$recording_url = '';
			$formats       = array();
			if ( isset( $recording->playback->format ) ) {
				$formats = is_array( $recording->playback->format ) ? $recording->playback->format : array( $recording->playback->format );
			}
			foreach ( $formats as $format ) {
				if ( ! isset( $format->type, $format->url ) ) {
					continue;
				}
				if ( (string) $format->type === $default_bbb_recording_format || $view_extended_recording_formats ) {
					$recording_url = trim( apply_filters( 'vcbbb_recording_url_display', (string) $format->url, (string) $format->type ) );
					$recording_url = VCBBB_Api::normalize_recording_playback_url( $recording_url );
					break;
				}
			}

			if ( '' === $recording_url ) {
				continue;
			}

			$row = sprintf(
				'<div class="bbb-portal-recording" style="border:1px solid #dcdcde;border-radius:6px;padding:14px 16px;margin:0 0 12px;background:#fff;">'
				. '<div class="bbb-portal-recording-name" style="font-weight:600;margin:0 0 4px;color:#1d2327;">%1$s</div>'
				. '<div class="bbb-portal-recording-date" style="font-size:13px;color:#646970;margin:0 0 12px;">%2$s</div>'
				. '<a class="bbb-button bbb-btn-join" href="%3$s" target="_blank" rel="noopener noreferrer" style="display:inline-block;padding:8px 16px;border-radius:4px;background:#0073aa;color:#fff;text-decoration:none;">%4$s</a>'
				. '</div>',
				esc_html( $name ),
				esc_html( $date ),
				esc_url( $recording_url ),
				esc_html__( 'View Recording', 'video-conferencing-with-bbb' )
			);
			$rows .= apply_filters( 'vcbbb_portal_recording_row_html', $row, $recording );
		}

		if ( '' === $rows ) {
			return '<p class="bbb-portal-no-recordings">' . esc_html__( 'This room does not currently have any recordings.', 'video-conferencing-with-bbb' ) . '</p>';
		}

		$list = '<div class="bbb-portal-recordings" style="margin:12px 0;">'
			. '<p class="bbb-portal-recordings-heading" style="font-weight:600;margin:0 0 12px;color:#1d2327;">' . esc_html__( 'Recordings', 'video-conferencing-with-bbb' ) . '</p>'
			. $rows
			. '</div>';

		return apply_filters( 'vcbbb_portal_recordings_list_html', $list, $recordings );
	}

	/**
	 * Create a short-lived guest session after access-code authentication.
	 *
	 * @param int    $room_id    Room post ID.
	 * @param string $username   Guest display name.
	 * @param string $entry_code Validated room access code.
	 * @return string Session token for the current visit.
	 */
	public static function create_guest_room_session( $room_id, $username, $entry_code, $allow_empty_username = false ) {
		$room_id = absint( $room_id );
		$username = sanitize_text_field( $username );
		$entry_code = sanitize_text_field( $entry_code );

		if ( ! $room_id || '' === $entry_code || ( ! $allow_empty_username && '' === $username ) ) {
			return '';
		}

		$token = wp_generate_password( 32, false, false );
		$ttl   = (int) apply_filters( 'vcbbb_guest_room_session_lifetime', 2 * HOUR_IN_SECONDS, $room_id );
		$data  = array(
			'room_id'    => $room_id,
			'username'   => $username,
			'entry_code' => $entry_code,
		);

		set_transient( self::get_guest_session_transient_key( $token ), $data, $ttl );

		return $token;
	}

	/**
	 * Remove any legacy guest auth cookies from older plugin versions.
	 *
	 * @param int $room_id Room post ID.
	 */
	public static function clear_legacy_guest_room_cookies( $room_id ) {
		$room_id = absint( $room_id );
		if ( ! $room_id || headers_sent() ) {
			return;
		}

		$path   = defined( 'COOKIEPATH' ) && COOKIEPATH ? COOKIEPATH : '/';
		$domain = defined( 'COOKIE_DOMAIN' ) && COOKIE_DOMAIN ? COOKIE_DOMAIN : '';
		$expire = time() - YEAR_IN_SECONDS;
		$cookies = array(
			'vcbbb_recording_access_' . $room_id,
			'vcbbb_guest_auth_' . $room_id,
		);

		foreach ( $cookies as $cookie_name ) {
			if ( isset( $_COOKIE[ $cookie_name ] ) ) {
				setcookie( $cookie_name, '', $expire, $path, $domain, is_ssl(), true );
				unset( $_COOKIE[ $cookie_name ] );
			}
		}
	}

	/**
	 * Whether the visitor is an access-code-only guest who has authenticated for this room.
	 *
	 * @param int $room_id Room post ID.
	 * @return bool
	 */
	public static function is_authenticated_access_code_guest( $room_id ) {
		return (bool) self::get_guest_session_data( $room_id );
	}

	/**
	 * Whether the visitor must authenticate before recordings are shown.
	 *
	 * @param int $room_id Room post ID.
	 * @return bool
	 */
	public static function requires_access_code_auth_for_recordings( $room_id ) {
		$room_id = absint( $room_id );
		if ( ! $room_id || ! VCBBB_Permissions_Helper::user_has_bbb_cap( 'join_with_access_code_bbb_room' ) ) {
			return false;
		}

		if ( VCBBB_Permissions_Helper::user_has_bbb_cap( 'join_as_moderator_bbb_room' ) || VCBBB_Permissions_Helper::user_has_bbb_cap( 'join_as_viewer_bbb_room' ) ) {
			return false;
		}

		$room_post = get_post( $room_id );
		if ( $room_post && (int) $room_post->post_author === get_current_user_id() ) {
			return false;
		}

		return true;
	}

	/**
	 * Get the guest session token from the current request.
	 *
	 * @return string
	 */
	public static function get_guest_session_token_from_request() {
		if ( empty( $_REQUEST['vcbbb_guest_session'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Guest session token from redirect (read-only).
			return '';
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- See empty() ignore above; sanitized guest session token from request.
		return sanitize_text_field( wp_unslash( $_REQUEST['vcbbb_guest_session'] ) );
	}

	/**
	 * Get stored guest auth details for an authenticated access-code visitor.
	 *
	 * @param int $room_id Room post ID.
	 * @return array|null
	 */
	public static function get_room_guest_auth( $room_id ) {
		$session = self::get_guest_session_data( $room_id );
		if ( ! $session ) {
			return null;
		}

		return array(
			'username'   => $session['username'],
			'entry_code' => $session['entry_code'],
			'token'      => $session['token'],
		);
	}

	/**
	 * Get validated guest session data for the current request.
	 *
	 * @param int $room_id Room post ID.
	 * @return array|null
	 */
	private static function get_guest_session_data( $room_id ) {
		$room_id = absint( $room_id );
		if ( ! $room_id || ! self::requires_access_code_auth_for_recordings( $room_id ) ) {
			return null;
		}

		$token = self::get_guest_session_token_from_request();
		if ( '' === $token ) {
			return null;
		}

		$data = get_transient( self::get_guest_session_transient_key( $token ) );
		if ( ! is_array( $data ) || empty( $data['room_id'] ) || (int) $data['room_id'] !== $room_id ) {
			return null;
		}

		$data['token'] = $token;
		return $data;
	}

	/**
	 * Build the transient key for a guest session token.
	 *
	 * @param string $token Session token.
	 * @return string
	 */
	private static function get_guest_session_transient_key( $token ) {
		return 'vcbbb_guest_session_' . sanitize_key( $token );
	}

	/**
	 * Check whether the current visitor can see recordings for a room.
	 *
	 * @param int $room_id Room post ID.
	 * @return bool
	 */
	public static function current_user_can_view_room_recordings( $room_id ) {
		$room_id = absint( $room_id );
		if ( ! $room_id ) {
			return false;
		}

		$room_post = get_post( $room_id );
		if ( $room_post && (int) $room_post->post_author === get_current_user_id() ) {
			return true;
		}

		if ( VCBBB_Permissions_Helper::user_has_bbb_cap( 'join_as_moderator_bbb_room' ) || VCBBB_Permissions_Helper::user_has_bbb_cap( 'join_as_viewer_bbb_room' ) ) {
			return true;
		}

		return (bool) self::get_guest_session_data( $room_id );
	}

	/**
	 * Check if the current user has any of the allowed roles.
	 *
	 * @param array $allowed_roles Array of allowed user role slugs.
	 * @return bool True if user has any allowed role, false otherwise.
	 */
	public static function is_current_user_in_allowed_roles( $author_id ) {
		$allowed_roles = apply_filters(
			'vcbbb_moderator_user_roles', array( 'administrator', 'bbb-moderator', 'ld-instructor', 'wdm_instructor', 'group_leader' )
		);

		$user = get_userdata( $author_id );
		if ( ! $user ) {
			return false;
		}

		$user_roles = (array) $user->roles;
		$user_role  = ! empty( $user_roles ) ? $user_roles[0] : '';

		if ( ! $user_role ) {
			return false;
		}

		return (bool) array_intersect( $allowed_roles, (array) $user_role );
	}

	/**
	 * Get room from token.
	 *
	 * @since   3.0.0
	 *
	 * @param   String  $token      Token to get associated room ID from.
	 * @param   Integer $author     Author writing the content using this shortcode.
	 *
	 * @return  Integer $room_id    ID of the room, given that the author may access it.
	 */
	public static function find_room_id_by_token( $token, $author ) {
		$in_allowed_roles = self::is_current_user_in_allowed_roles( $author );

		// Only show room if author or roles satisfy create room cap.
		if ( ! $in_allowed_roles && ! user_can( $author, 'edit_bbb_rooms' ) ) {
			self::$error_message = esc_html__( 'This user does not have permission to display any rooms in a shortcode or widget.', 'video-conferencing-with-bbb' );
			return 0;
		}

		if ( 'z' == substr( $token, 0, 1 ) ) {
			return self::check_if_room_exists_for_new_token_format( $token, $author );
		} else {
			return self::check_if_room_exists_for_old_token_format( $token, $author );
		}
	}

	/**
	 * Check if rooms and recordings should load on this page.
	 *
	 * @since  3.0.0
	 * @return Boolean  $can_view          Boolean value of whether join room form and recordings should show on this page.
	 */
	public static function can_display_room_on_page() {
		global $pagenow;
		$can_view = true;
		if ( 'edit.php' == $pagenow || 'post.php' == $pagenow || 'post-new.php' == $pagenow ) {
			$can_view = false;
		}

		// Elementor checks
		if ( ( isset( $_REQUEST['action'] ) && 'elementor_ajax' === sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) ) || isset( $_GET['elementor-preview'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Elementor editor request flags.
			$can_view = false;
		}

		if ( EE_VCBBB_Helper::check_if_rest_or_json() ) {
			$can_view = false;
		}

		return $can_view;
	}

	/**
	 * Get room ID using new token format.
	 *
	 * @since   3.0.0
	 *
	 * @param   String  $token     String value of the token.
	 * @param   Integer $author   Author writing the content using this shortcode.
	 * @return  Integer $room_id  Room ID associated with the token.
	 */
	private static function check_if_room_exists_for_new_token_format( $token, $author ) {
		$room_id = (int) substr( $token, 1 );
		$room    = get_post( $room_id );
		if ( false !== $room && null !== $room && 'bbb-room' == $room->post_type ) {
			if ( 'publish' != $room->post_status ) {
				//self::set_error_message( sprintf( wp_kses( __( 'The token: %s is not associated with a published room.', 'video-conferencing-with-bbb' ), array() ), $token ), $author );
				//return 0;
			}
			return $room->ID;
		} else {
			return self::check_if_room_exists_for_old_token_format( $token, $author );
		}
	}

	/**
	 * Get room ID using old token format.
	 *
	 * @since   3.0.0
	 *
	 * @param   String  $token     String value of the token.
	 * @param   Integer $author   Author writing the content using this shortcode.
	 * @return  Integer $room_id  Room ID associated with the token.
	 */
	private static function check_if_room_exists_for_old_token_format( $token, $author ) {
		$args = array(
			'post_type'      => 'bbb-room',
			'fields'         => 'ids',
			'no_found_rows'  => true,
			'posts_per_page' => 1,
			// Exact token→room lookup for shortcode resolution; single meta equality cannot use a non-meta query.
			'meta_key'       => 'bbb-room-token', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- Required exact meta lookup by room token.
			'meta_value'     => $token, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value -- Paired with meta_key for exact token match.
		);

		$query = new WP_Query( $args );
		if ( ! empty( $query->posts ) ) {
			foreach ( $query->posts as $key => $room_id ) {
				$room = get_post( $room_id );
				if ( 'publish' != $room->post_status ) {
					// self::set_error_message( sprintf( wp_kses( __( 'The token: %s is not associated with a published room.', 'video-conferencing-with-bbb' ), array() ), $token ), $author );
					// return 0;
				}
				return $room_id;
			}
		}

		self::set_error_message(
			sprintf(
				/* translators: %s: room token */
				wp_kses( __( 'The token: %s is not associated with an existing room.', 'video-conferencing-with-bbb' ), array() ),
				$token
			),
			$author
		);
		return 0;
	}

	/**
	 * Get recordings from recording helper.
	 *
	 * @since   3.0.0
	 *
	 * @param   Array $room_ids           Room IDs to get recordings from.
	 *
	 * @return  Array $recordings         List of recordings belonging to the selected rooms.
	 */
	private static function get_recordings( $room_ids ) {
		$recording_helper = new VCBBB_Recording_Helper();

	if ( isset( $_GET['order'], $_GET['orderby'], $_GET['nonce'] ) 
 && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['nonce'] ) ), 'vcbbb_sort_recording_columns_nonce' ) ) {
		$order   = sanitize_text_field( wp_unslash( $_GET['order'] ) );
		$orderby = sanitize_text_field( wp_unslash( $_GET['orderby'] ) );
		return $recording_helper->get_filtered_and_ordered_recordings_based_on_capability( $room_ids, $order, $orderby );
	} else {
		return $recording_helper->get_filtered_and_ordered_recordings_based_on_capability( $room_ids );
	}
	}

	/**
	 * Set error message based on if user can see the detailed error message or not.
	 *
	 * @since   3.0.0
	 *
	 * @param  String  $detailed_message                      Detailed error message that describes the issue.
	 * @param  Integer $author                                Author writing the content using this shortcode.
	 */
	private static function set_error_message( $detailed_message, $author ) {
		if ( current_user_can( 'edit_others_bbb_rooms' ) || get_current_user_id() == $author ) {
			self::$error_message = $detailed_message;
		} else {
			self::$error_message = esc_html__( 'The room linked to this resource is not configured correctly.', 'video-conferencing-with-bbb' );
		}
	}
}
