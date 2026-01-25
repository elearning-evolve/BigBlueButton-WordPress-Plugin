
<div class="bbb-join-form-block bbb-room-selection-block">
	<label id="bbb-room-selection" class="bbb-join-room-label"><?php esc_html_e( 'Select Room' ); ?></label>
	<select aria-labelledby="bbb-room-selection" class="bbb-room-selection bbb-join-room-input">
		<?php foreach ( $rooms as $room ) { ?>
			<option id="<?php echo $room->room_id; ?>" value="<?php echo $room->room_id; ?>"
				<?php if ( $selected_room == $room->room_id ) { ?>
					selected
				<?php } ?>><?php echo $room->room_name; ?></option>
		<?php } ?>
	</select>
	<?php echo $html_form; ?>
</div>
