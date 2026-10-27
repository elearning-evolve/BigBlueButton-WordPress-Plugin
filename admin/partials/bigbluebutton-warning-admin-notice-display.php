<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}
?>
<div class="notice notice-warning is-dismissible bbb-warning-notice" 
     data-notice="<?php echo esc_attr( $bbb_warning_type ); ?>" 
     data-nonce="<?php echo esc_attr( $bbb_admin_notice_nonce ); ?>" >
     
	<p>
	<?php if ( isset( $bbb_action_link ) ) { ?>
		<a href="<?php echo esc_url( $bbb_action_link ); ?>" target="_blank" rel="noopener">
			<?php echo esc_html( $bbb_admin_warning_message ); ?>
		</a>
	<?php } else { ?>
		<?php echo esc_html( $bbb_admin_warning_message ); ?>
	<?php } ?>
	</p>
</div>