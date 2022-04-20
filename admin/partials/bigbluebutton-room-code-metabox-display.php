<label><?php echo $entry_code_label; ?>: </label>
<?php if ( $existing_value != '' ) { ?>
	<input name="<?php echo $entry_code_name; ?>" type="text" value="<?php echo $existing_value; ?>">
<?php } else { ?>
	<input name="<?php echo $entry_code_name; ?>" type="text" value="<?php echo $entry_code; ?>">
<?php } ?>
<p><?php echo esc_html( $entry_code_msg ); ?></p>
