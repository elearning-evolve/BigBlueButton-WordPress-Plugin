<?php

/**
 * The public-facing recordings API of the plugin.
 *
 * @link       https://blindsidenetworks.com
 * @since      3.0.0
 *
 * @package    Bigbluebutton
 * @subpackage Bigbluebutton/public
 */

/**
 * The public-facing recordings API of the plugin.
 *
 * Answers the API calls made from public facing pages about recordings.
 *
 * @package    Bigbluebutton
 * @subpackage Bigbluebutton/public
 * @author     Blindside Networks <contact@blindsidenetworks.com>
 */
class VCBBB_Public_Recording_Api {

	/**
	 * Handle publishing/unpublishing a recording
	 *
	 * @since   3.0.0
	 *
	 * @return  array  $response   JSON response to changing a recording's publication status.
	 */
	public function set_vcbbb_recording_publish_state() {
		$response            = array( 'success' => false );

		if ( ! VCBBB_Permissions_Helper::user_has_bbb_cap( 'manage_bbb_room_recordings' ) ) {
			wp_send_json( $response );
		}

		// Check required POST variables
		if ( ! isset( $_POST['meta_nonce'], $_POST['record_id'], $_POST['value'] ) ) {
			wp_send_json( $response );
		}

		// Sanitize POST variables
		$meta_nonce = sanitize_text_field( wp_unslash( $_POST['meta_nonce'] ) );
		$record_id  = sanitize_text_field( wp_unslash( $_POST['record_id'] ) );
		$value      = sanitize_text_field( wp_unslash( $_POST['value'] ) );

		// Validate value
		if ( $value !== 'true' && $value !== 'false' ) {
			wp_send_json( $response );
		}

		// Verify nonce
		if ( ! wp_verify_nonce( $meta_nonce, 'vcbbb_manage_recordings_nonce' ) ) {
			wp_die( esc_html__( 'Nonce verification failed', 'video-conferencing-with-bbb' ) );
		}

		// Call API to set publish state
		$return_code = VCBBB_Api::set_recording_publish_state( $record_id, $value );

		if ( $return_code === 200 ) {
			$response['success'] = true;
		}

		wp_send_json( $response );
	}

	/**
	 * Handle protect/unprotect a recording
	 *
	 * @since   3.0.0
	 *
	 * @return  array  $response   JSON response to changing a recording's protection status.
	 */
	public function set_vcbbb_recording_protect_state() {
		$response            = array( 'success' => false );

		if ( ! VCBBB_Permissions_Helper::user_has_bbb_cap( 'manage_bbb_room_recordings' ) ) {
			wp_send_json( $response );
		}

		if ( ! isset( $_POST['meta_nonce'], $_POST['record_id'], $_POST['value'] ) ) {
			wp_send_json( $response );
		}

		$meta_nonce = sanitize_text_field( wp_unslash( $_POST['meta_nonce'] ) );
		$record_id  = sanitize_text_field( wp_unslash( $_POST['record_id'] ) );
		$value      = sanitize_text_field( wp_unslash( $_POST['value'] ) );

		if ( $value !== 'true' && $value !== 'false' ) {
			wp_send_json( $response );
		}

		if ( ! wp_verify_nonce( $meta_nonce, 'vcbbb_manage_recordings_nonce' ) ) {
			wp_die( esc_html__( 'Nonce verification failed', 'video-conferencing-with-bbb' ) );
		}

		$return_code = VCBBB_Api::set_recording_protect_state( $record_id, $value );

		if ( $return_code === 200 ) {
			$response['success'] = true;
		}

		wp_send_json( $response );
	}

	/**
	 * Handle deleting a recording.
	 *
	 * @since   3.0.0
	 *
	 * @return  array  $response   JSON response to deleting a recording.
	 */
	public function trash_vcbbb_recording() {
		$response            = array( 'success' => false );

		if ( ! VCBBB_Permissions_Helper::user_has_bbb_cap( 'manage_bbb_room_recordings' ) ) {
			wp_send_json( $response );
		}

		if ( ! isset( $_POST['meta_nonce'], $_POST['record_id'] ) ) {
			wp_send_json( $response );
		}

		$meta_nonce = sanitize_text_field( wp_unslash( $_POST['meta_nonce'] ) );
		$record_id  = sanitize_text_field( wp_unslash( $_POST['record_id'] ) );

		if ( ! wp_verify_nonce( $meta_nonce, 'vcbbb_manage_recordings_nonce' ) ) {
			wp_die( esc_html__( 'Nonce verification failed', 'video-conferencing-with-bbb' ) );
		}

		$return_code = VCBBB_Api::delete_recording( $record_id );

		if ( $return_code === 200 ) {
			$response['success'] = true;
		}

		wp_send_json( $response );
	}

	/**
	 * Send recording metadata to Bigbluebutton API.
	 *
	 * @since   3.0.0
	 *
	 * @return  array  $response   JSON response to editing a recording's metadata.
	 */
	public function set_vcbbb_recording_edits() {
		$response            = array( 'success' => false );

		if ( ! VCBBB_Permissions_Helper::user_has_bbb_cap( 'manage_bbb_room_recordings' ) ) {
			wp_send_json( $response );
		}

		if ( ! isset( $_POST['meta_nonce'], $_POST['record_id'], $_POST['type'], $_POST['value'] ) ) {
			wp_send_json( $response );
		}

		$meta_nonce = sanitize_text_field( wp_unslash( $_POST['meta_nonce'] ) );
		$record_id  = sanitize_text_field( wp_unslash( $_POST['record_id'] ) );
		$type       = sanitize_text_field( wp_unslash( $_POST['type'] ) );
		$value      = sanitize_text_field( wp_unslash( $_POST['value'] ) );

		if ( ! wp_verify_nonce( $meta_nonce, 'vcbbb_manage_recordings_nonce' ) ) {
			wp_die( esc_html__( 'Nonce verification failed', 'video-conferencing-with-bbb' ) );
		}

		$return_code = VCBBB_Api::set_recording_edits( $record_id, $type, $value );

		if ( $return_code === 200 ) {
			$response['success'] = true;
		}

		wp_send_json( $response );
	}

}