<?php if ( isset( $start_time ) && $start_time ) : ?>
	<?php do_action( 'bbb_countdown_display', $room_id, $start_time ); ?>
<?php elseif ( isset( $_REQUEST['join'] ) ) : ?>
	<?php do_action( 'bbb_on_room_join' ); ?>
<?php elseif ( isset( $_REQUEST['rec_url'] ) ) : ?>
	<?php do_action( 'bbb_recording_display' ); ?>
<?php else : ?>
<form id="joinroom" target="<?php echo esc_attr( $form_target ); ?>" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="bbb-form validate">
	<input type="hidden" name="action" value="join_room">
	<input id="bbb_join_room_id" type="hidden" name="room_id" value="<?php echo esc_attr( $room_id ); ?>">
	<input type="hidden" id="bbb_join_room_meta_nonce" name="bbb_join_room_meta_nonce" value="<?php echo esc_attr( $meta_nonce ); ?>">
	<input type="hidden" name="REQUEST_URI" value="<?php echo esc_url( $current_url ); ?>">
	<input type="hidden" name="post_id" value="<?php echo esc_attr( $post_id ); ?>">
	<?php if ( ! is_user_logged_in() ) { ?>
		<div id="bbb_join_with_username" class="bbb-join-form-block">
			<label id="bbb_meeting_name_label" class="bbb-join-room-label"><?php esc_html_e( 'Name' ); ?>: </label>
			<input type="text" name="bbb_meeting_username" aria-labelledby="bbb_meeting_name_label" class="bbb-join-room-input">
		</div>
	<?php } ?>
	<?php if ( ! $access_as_moderator && ! $access_as_viewer && $access_using_code ) { ?>
		<div id="bbb_join_with_password" class="bbb-join-form-block">
	<?php } else { ?>
		<div id="bbb_join_with_password" class="bbb-join-form-block" style="display:none;">
	<?php } ?>
			<label id="bbb_meeting_access_code_label" class="bbb-join-room-label"><?php esc_html_e( 'Access Code', 'bigbluebutton' ); ?>: </label>
			<input type="text" name="bbb_meeting_access_code" aria-labelledby="bbb_meeting_access_code_label" class="bbb-join-room-input">
		</div>
		<?php if ( isset( $_REQUEST['max_user_error'] ) && $_REQUEST['room_id'] == $room_id ) { ?>
			<div class="bbb-error">
				<label><?php esc_html_e( 'The limit for the max no.of users allowed to join the room has been reached. Please try again in a while.', 'bigbluebutton' ); ?></label>
			</div>
		<?php } ?>
		<?php if ( isset( $_REQUEST['password_error'] ) && $_REQUEST['room_id'] == $room_id ) { ?>
			<div class="bbb-error">
				<label><?php esc_html_e( 'The access code you have entered is incorrect. Please try again.', 'bigbluebutton' ); ?></label>
			</div>
		<?php } ?>
	<?php if ( isset( $_REQUEST['bigbluebutton_wait_for_mod'] ) && $_REQUEST['room_id'] == $room_id ) { ?>
		<div class="bbb-join-form-block">
			<label id="bbb-wait-for-mod-msg"
				data-room-id="<?php echo $room_id; ?>"
				<?php if ( isset( $_REQUEST['temp_entry_pass'] ) ) { ?>
					data-temp-room-pass="<?php echo esc_attr( $_REQUEST['temp_entry_pass'] ); ?>"
				<?php } ?>
				<?php if ( isset( $_REQUEST['username'] ) ) { ?>
					data-room-username="<?php echo esc_attr( $_REQUEST['username'] ); ?>"
				<?php } ?>>
				<?php if ( $heartbeat_available ) { ?>
					<?php esc_html_e( 'The meeting has not started yet. You will be automatically redirected to the meeting when it starts.', 'bigbluebutton' ); ?>
				<?php } else { ?>
					<?php esc_html_e( 'The meeting has not started yet. Please wait for a moderator to start the meeting before joining.', 'bigbluebutton' ); ?>
				<?php } ?>
			</label>
		</div>
	<?php } ?>
	<input class="bbb-button button button-primary" type="submit" value="<?php echo esc_attr( $join_btn ); ?>">
	<?php do_action( 'bbb_join_form_buttons', $access_as_moderator ); ?>
</form>
<?php endif; ?>
