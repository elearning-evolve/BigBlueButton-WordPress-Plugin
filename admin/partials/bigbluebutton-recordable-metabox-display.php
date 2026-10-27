<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}
?>
<label><?php esc_html_e( 'Recordable', 'video-conferencing-with-bbb' ); ?>: <input name="bbb-room-recordable" type="checkbox" value="checked"
<?php if ( 'true' === $existing_value || '' === $existing_value ) { ?>
	checked
<?php } ?>></label>
