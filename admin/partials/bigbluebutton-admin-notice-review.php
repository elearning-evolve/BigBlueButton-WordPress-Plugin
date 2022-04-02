<div class="notice notice-info">
	<p>
	<?php if ( isset( $bbb_admin_review_message ) ) { ?>
		<?php echo wp_kses( $bbb_admin_review_message, array( 'strong' => array() ) ); ?>
		<br /><br />
		<a target="_blank" rel="noopener" href="https://wordpress.org/support/plugin/video-conferencing-with-bbb/reviews/#new-post">
			<button class="button button-primary bbb-warning-notice" data-notice="<?php esc_html_e( $bbb_warning_type ); ?>" data-nonce="<?php esc_html_e( $bbb_admin_notice_nonce ); ?>">Yes, update plugin author</button>
		</a>
		<button onClick="window.location.reload()" class="button button-sm-primary bbb-warning-notice" data-notice="<?php esc_html_e( $bbb_warning_type ); ?>" data-nonce="<?php esc_html_e( $bbb_admin_notice_nonce ); ?>">Ignore, remove this notice</button>
	<?php } else { ?>
		<?php esc_html_e( $bbb_admin_review_message ); ?>
	<?php } ?>
	</p>
</div>
