<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}
?>
<?php if ( $entry_code_name == 'bbb-moderator-code' ) : ?>
<h4><strong><?php echo esc_html( $entry_code_msg ); ?> <?php esc_html_e( 'Access codes must be at least 3 characters. To change it during a meeting, end the meeting first', 'video-conferencing-with-bbb' ); ?></strong></h4>
<?php endif; ?>

<label><?php echo esc_html( $entry_code_label ); ?>: </label>
<?php if ( $existing_value != '' ) { ?>
	<input name="<?php echo esc_attr( $entry_code_name ); ?>" 
       type="text" minlength="3" 
       value="<?php echo esc_attr( $existing_value ); ?>">
<?php } else { ?>
	<input name="<?php echo esc_attr( $entry_code_name ); ?>" type="text" minlength="3" value="<?php echo esc_attr( $entry_code ); ?>">
<?php } ?>
