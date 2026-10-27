<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}
?>
<div class="bbb-top-bottom-margin">
	<p>
		<label for="<?php echo esc_attr( $text_id ); ?>" class="bbb-width-30 bbb-inline-block"><?php esc_html_e( 'Tokens (separated by comma)', 'video-conferencing-with-bbb' ); ?>:</label>
		<input class="widefat" id=<?php echo esc_attr( $text_id ); ?> name="<?php echo esc_attr( $text_name ); ?>" type="text" value="<?php echo esc_attr( $text_value ); ?>" />
	</p>
</div>
