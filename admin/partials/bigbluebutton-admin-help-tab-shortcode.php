<ol>
	<li><?php echo esc_html( __( 'When adding shortcode to a page please make sure you start the meeting from that same page as a moderator', 'bigbluebutton' ) ); ?></li>
	<li><?php echo esc_html( __( 'You can start the meeting from here when not adding the shortcode to a page and using the below invite link for the room', 'bigbluebutton' ) ); ?></li>
	<li><?php echo esc_html( __( 'See All available plugin shortcodes', 'bigbluebutton' ) ); ?>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=bbb-room-server-settings#shortcodes' ) ); ?>" target="_blank" rel="noopener">
		<?php echo esc_html( __( 'here', 'bigbluebutton' ) ); ?>
		</a>
	</li>
</ol>
