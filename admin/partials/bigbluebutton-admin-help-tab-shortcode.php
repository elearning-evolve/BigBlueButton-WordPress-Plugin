<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}
?>
<ol>
	<li><?php echo esc_html( __( 'When adding shortcode to a page please make sure you start the meeting from that same page as a moderator', 'video-conferencing-with-bbb' ) ); ?></li>
	<li><?php echo esc_html( __( 'You can start the meeting from here when not adding the shortcode to a page and using the below invite link for the room', 'video-conferencing-with-bbb' ) ); ?></li>
	<li><?php echo esc_html( __( 'See All available plugin shortcodes', 'video-conferencing-with-bbb' ) ); ?>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=bbb-room-shortcodes' ) ); ?>" target="_blank" rel="noopener">
		<?php echo esc_html( __( 'here', 'video-conferencing-with-bbb' ) ); ?>
		</a>
	</li>
</ol>
