<div class="bbb-warning-notice notice is-dismissible notice-<?php echo $notice_type; ?>" data-notice="<?php esc_html_e( $bbb_warning_type ); ?>" data-nonce="<?php esc_html_e( $bbb_admin_notice_nonce ); ?>">
	<p>
	<?php
	if ( isset( $bbb_admin_review_message ) ) {
		;
		?>
		<?php echo wp_kses( $bbb_admin_review_message, array( 'strong' => array() ) ); ?>
		<br /><br />
		<?php if ( 'review_request' == $type ) : ?>
			<a target="_blank" rel="noopener" href="https://wordpress.org/support/plugin/video-conferencing-with-bbb/reviews/#new-post">
				<button class="bbb-settings-btn" data-notice="<?php esc_html_e( $bbb_warning_type ); ?>" data-nonce="<?php esc_html_e( $bbb_admin_notice_nonce ); ?>">Share feedback</button>
			</a>
			<?php elseif ( 'room_create_limit' == $type ) : ?>
			
			<a target="_blank" rel="noopener" href="<?php echo VIDEO_CONF_WITH_BBB_PRO; ?>">
				<button class="bbb-settings-btn" data-notice="<?php esc_html_e( $bbb_warning_type ); ?>" data-nonce="<?php esc_html_e( $bbb_admin_notice_nonce ); ?>">
				Get Pro Version
			</button>
			</a>
		<?php endif; ?>
	<?php } ?>
	</p>
</div>
