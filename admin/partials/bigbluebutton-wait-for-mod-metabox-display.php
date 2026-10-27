<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}
?>
<label><?php esc_html_e( 'Wait for Moderator', 'video-conferencing-with-bbb' ); ?>: </label>
<input name="bbb-room-wait-for-moderator" type="checkbox" value="checked"
<?php if ( 'true' === $existing_value) { ?>
	checked
<?php } ?>>
