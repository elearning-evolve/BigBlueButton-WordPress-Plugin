<?php if ( $entry_code_name == 'bbb-moderator-code' ) : ?>
<h4><strong><?php echo esc_html( $entry_code_msg ); ?> <?php _e( 'Access codes must be at least 3 characters. To change it during a meeting, end the meeting first', 'bigbluebutton' ); ?></strong></h4>
<?php endif; ?>

<label><?php echo $entry_code_label; ?>: </label>
<?php if ( $existing_value != '' ) { ?>
	<input name="<?php echo $entry_code_name; ?>" type="text" minlength="3" value="<?php echo $existing_value; ?>">
<?php } else { ?>
	<input name="<?php echo $entry_code_name; ?>" type="text" minlength="3" value="<?php echo $entry_code; ?>">
<?php } ?>
