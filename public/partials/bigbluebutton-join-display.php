<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}
// phpcs:disable WordPress.Security.NonceVerification.Recommended -- Join form reads public query flags set by this plugin.
?>
<?php if ( isset( $start_time ) && $start_time ) : ?>
	<?php  do_action( 'vcbbb_countdown_display', $room_id, $start_time ); ?>
<?php elseif ( isset( $_REQUEST['bbb_room_join'] ) && $room_id == base64_decode( sanitize_text_field( wp_unslash( $_REQUEST['room_id'] ?? '' ) ) ) ) : ?>
	<?php  do_action( 'vcbbb_on_room_join', $room_id ); ?>
<?php elseif ( isset( $_REQUEST['rec_url'] ) ) : ?>
	<?php  do_action( 'vcbbb_recording_display' ); ?>
<?php else : ?>

<form id="joinroom<?php echo esc_attr( $room_id ); ?>" 
      target="<?php echo esc_attr( $form_target ); ?>" 
      action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" 
      class="bbb-form validate"
	<?php if ( ! empty( $requires_access_code_auth ) ) : ?>
      data-vcbbb-requires-auth="1"
	<?php endif; ?>
	<?php if ( ! empty( $guest_authenticated ) ) : ?>
      data-vcbbb-guest-authenticated="1"
	<?php endif; ?>>

	<input type="hidden" name="action" value="<?php echo esc_attr( $args['action'] ); ?>">
	<input data-id="bbb_join_room_id<?php echo esc_attr( $room_id ); ?>" type="hidden" name="room_id" value="<?php echo esc_attr( $room_id ); ?>">
	<input type="hidden" id="vcbbb_join_room_meta_nonce" name="vcbbb_join_room_meta_nonce" value="<?php echo esc_attr( $meta_nonce ); ?>">
	<input type="hidden" name="current_page" value="<?php echo esc_url( $args['current_page'] ); ?>">
	<input type="hidden" name="post_id" value="<?php echo esc_attr( $args['post_id'] ); ?>">

	<?php
	$vcbbb_guest_ready = ! empty( $guest_authenticated ) && ! empty( $guest_room_auth );
	$vcbbb_guest_named = $vcbbb_guest_ready && '' !== trim( (string) $guest_room_auth['username'] );
	?>
	<?php if ( $vcbbb_guest_named ) : ?>
		<input type="hidden" name="bbb_meeting_username" value="<?php echo esc_attr( $guest_room_auth['username'] ); ?>" />
		<input type="hidden" name="bbb_meeting_access_code" value="<?php echo esc_attr( $guest_room_auth['entry_code'] ); ?>" />
		<input type="hidden" name="vcbbb_guest_session" value="<?php echo esc_attr( $guest_room_auth['token'] ); ?>" />
	<?php else : ?>
		<?php if ( ! is_user_logged_in() ) : ?>
			<div id="bbb_join_with_username" class="bbb-join-form-block">
				<label id="bbb_meeting_name_label" class="bbb-join-room-label"><?php esc_html_e( 'Name', 'video-conferencing-with-bbb' ); ?></label>
				<input type="text" data-id="bbb_meeting_username" name="bbb_meeting_username" aria-labelledby="bbb_meeting_name_label" class="bbb-join-room-input" required />
			</div>
		<?php endif; ?>

		<?php if ( $vcbbb_guest_ready ) : ?>
			<input type="hidden" name="bbb_meeting_access_code" value="<?php echo esc_attr( $guest_room_auth['entry_code'] ); ?>" />
			<input type="hidden" name="vcbbb_guest_session" value="<?php echo esc_attr( $guest_room_auth['token'] ); ?>" />
		<?php else : ?>
			<?php if ( ! $access_as_moderator && ! $access_as_viewer && $access_using_code ) : ?>
				<div id="bbb_join_with_password" class="bbb-join-form-block">
			<?php else : ?>
				<div id="bbb_join_with_password" class="bbb-join-form-block" style="display:none;">
			<?php endif; ?>
					<label id="bbb_meeting_access_code_label" class="bbb-join-room-label"><?php esc_html_e( 'Access Code', 'video-conferencing-with-bbb' ); ?></label>
					<input type="text" data-id="bbb_meeting_access_code" name="bbb_meeting_access_code" aria-labelledby="bbb_meeting_access_code_label" class="bbb-join-room-input vcbbb-field-invalid" placeholder="<?php esc_attr_e( 'Enter a room access code', 'video-conferencing-with-bbb' ); ?>" <?php echo ( ! $access_as_moderator && ! $access_as_viewer && $access_using_code ) ? 'required' : ''; ?>>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( isset( $_REQUEST['max_user_error'] ) && ( sanitize_text_field( wp_unslash( $_REQUEST['room_id'] ?? '' ) ) == $room_id ) ) : ?>
		<div class="bbb-error">
			<label><?php esc_html_e( 'The participants limit for this meeting has been reached. Please try again in a while.', 'video-conferencing-with-bbb' ); ?></label>
		</div>
	<?php endif; ?>

	<?php if ( isset( $_REQUEST['password_error'] ) && ( sanitize_text_field( wp_unslash( $_REQUEST['room_id'] ?? '' ) ) == $room_id ) ) : ?>
		<div class="bbb-error">
			<label><?php esc_html_e( 'The access code you have entered is incorrect. Please try again.', 'video-conferencing-with-bbb' ); ?></label>
		</div>
	<?php endif; ?>

	<?php if ( isset( $_REQUEST['vcbbb_wait_for_mod'] ) && ( sanitize_text_field( wp_unslash( $_REQUEST['room_id'] ?? '' ) ) == $room_id ) ) : ?>
		<div class="bbb-join-form-block">
			<?php
				// Sanitize user inputs
				$vcbbb_temp_entry_pass = isset( $_REQUEST['temp_entry_pass'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['temp_entry_pass'] ) ) : '';
				$vcbbb_wait_username   = isset( $_REQUEST['username'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['username'] ) ) : '';
			?>
			<label id="bbb-wait-for-mod-msg"
				data-room-id="<?php echo esc_attr( $room_id ); ?>"
				<?php if ( $vcbbb_temp_entry_pass ) : ?>
					data-temp-room-pass="<?php echo esc_attr( $vcbbb_temp_entry_pass ); ?>"
				<?php endif; ?>
				<?php if ( $vcbbb_wait_username ) : ?>
					data-room-username="<?php echo esc_attr( $vcbbb_wait_username ); ?>"
				<?php endif; ?>
			>
				<?php if ( $heartbeat_available ) : ?>
					<?php esc_html_e( 'The meeting has not started yet. You will be automatically redirected to the meeting when it starts.', 'video-conferencing-with-bbb' ); ?>
				<?php else : ?>
					<?php esc_html_e( 'The meeting has not started yet. Please wait for a moderator to start the meeting before joining.', 'video-conferencing-with-bbb' ); ?>
				<?php endif; ?>
			</label>
		</div>
	<?php endif; ?>

	<?php if ( $is_join_web ) : ?>
		<a rel="noopener" href="javascript:void(0)" onclick="joinBBBRoomFromPage('<?php echo esc_url( $url ); ?>', 0, this)">
			<button type="button" name="bbb_join_web" class="bbb-button bbb-btn-join button button-primary"><?php echo esc_html( $join_btn ); ?></button>
		</a>
	<?php endif; ?>

	<?php  do_action( 'vcbbb_join_form_buttons', $access_as_moderator, $args ); ?>

	<?php if ( ! empty( $requires_access_code_auth ) && empty( $guest_authenticated ) ) : ?>
		<a rel="noopener" href="#" onclick="return vcbbbGuestViewRecordings('<?php echo esc_url( $url ); ?>', this)">
			<button type="button" class="bbb-button bbb-btn-join button button-primary"><?php esc_html_e( 'View Recording', 'video-conferencing-with-bbb' ); ?></button>
		</a>
	<?php endif; ?>
</form>

<?php endif; ?>