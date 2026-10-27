<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}

$vcbbb_stored_url  = isset( $bbb_settings['vcbbb_url'] ) ? untrailingslashit( (string) $bbb_settings['vcbbb_url'] ) : '';
$vcbbb_default_url = isset( $bbb_settings['vcbbb_default_url'] ) ? untrailingslashit( (string) $bbb_settings['vcbbb_default_url'] ) : '';
$vcbbb_stored_host = is_string( $vcbbb_stored_url ) ? wp_parse_url( $vcbbb_stored_url, PHP_URL_HOST ) : '';
$vcbbb_default_host = is_string( $vcbbb_default_url ) ? wp_parse_url( $vcbbb_default_url, PHP_URL_HOST ) : '';
$vcbbb_is_test_instance = (
	is_string( $vcbbb_stored_host ) && '' !== $vcbbb_stored_host
	&& is_string( $vcbbb_default_host ) && '' !== $vcbbb_default_host
	&& strtolower( $vcbbb_stored_host ) === strtolower( $vcbbb_default_host )
);
$vcbbb_show_tabs = ( VCBBB_Loader::is_bbb_pro_active() || null !== $tab );
?>
<div class="vcbbb-settings-layout">
	<form id="bbb-general-settings-form" method="POST" action="" enctype="multipart/form-data">
		<input type="hidden" name="action" value="vcbbb_general_settings">
		<input type="hidden" id="vcbbb_edit_server_settings_meta_nonce" name="vcbbb_edit_server_settings_meta_nonce" value="<?php echo esc_attr( $meta_nonce ); ?>">

		<div class="vcbbb-settings-grid">
			<div class="vcbbb-settings-main">
				<div class="vcbbb-settings-card">
					<div class="vcbbb-settings-card-header">
						<div>
							<h1><?php esc_html_e( 'Room Settings', 'video-conferencing-with-bbb' ); ?></h1>
							<p><?php esc_html_e( 'Connect your BigBlueButton server to power virtual classrooms.', 'video-conferencing-with-bbb' ); ?></p>
						</div>
						<?php if ( null === $tab ) : ?>
							<span class="vcbbb-status-pill">
								<span class="vcbbb-status-dot" aria-hidden="true"></span>
								<?php
								echo $vcbbb_is_test_instance
									? esc_html__( 'Connected (Test Instance)', 'video-conferencing-with-bbb' )
									: esc_html__( 'Connected', 'video-conferencing-with-bbb' );
								?>
							</span>
						<?php endif; ?>
					</div>

					<?php if ( $vcbbb_show_tabs ) : ?>
						<nav class="nav-tab-wrapper vcbbb-settings-tabs">
							<a href="<?php echo esc_url( admin_url( 'admin.php?page=bbb-room-server-settings' ) ); ?>" class="nav-tab<?php echo ( null === $tab ) ? ' nav-tab-active' : ''; ?>">
								<?php esc_html_e( 'Setup', 'video-conferencing-with-bbb' ); ?>
							</a>
							<?php do_action( 'vcbbb_settings_tab_nav', $tab ); ?>
						</nav>
					<?php endif; ?>

					<div class="vcbbb-settings-card-body">
						<?php if ( null === $tab ) : ?>
							<?php do_action( 'vcbbb_setup_tab_content' ); ?>

							<?php if ( 1 === (int) $change_success ) : ?>
								<div class="notice notice-success vcbbb-settings-notice"><p><?php esc_html_e( 'Success! Your room server settings have been saved.', 'video-conferencing-with-bbb' ); ?></p></div>
							<?php elseif ( 2 === (int) $change_success ) : ?>
								<div class="notice notice-error vcbbb-settings-notice"><p><?php esc_html_e( "Error: the URL you have entered must end with '/bigbluebutton/'.", 'video-conferencing-with-bbb' ); ?></p></div>
							<?php elseif ( 3 === (int) $change_success ) : ?>
								<div class="notice notice-error vcbbb-settings-notice"><p><?php esc_html_e( 'Error: The server cannot be reached. Are you sure the server is running and your settings are correct?', 'video-conferencing-with-bbb' ); ?></p></div>
							<?php endif; ?>

							<div class="vcbbb-settings-fields">
								<div class="vcbbb-settings-field">
									<label for="vcbbb_url"><?php esc_html_e( 'Endpoint URL', 'video-conferencing-with-bbb' ); ?></label>
									<input id="vcbbb_url" type="text" name="vcbbb_url" value="<?php echo esc_url( $bbb_settings['vcbbb_url'] ); ?>" aria-describedby="vcbbb-endpoint-help">
									<div id="vcbbb-endpoint-help" class="vcbbb-field-help">
										<?php esc_html_e( 'Test Instance:', 'video-conferencing-with-bbb' ); ?>
										<?php echo esc_url( $bbb_settings['vcbbb_default_url'] ); ?>
									</div>
								</div>
								<div class="vcbbb-settings-field">
									<label for="vcbbb_salt"><?php esc_html_e( 'Shared Secret / Salt', 'video-conferencing-with-bbb' ); ?></label>
									<input id="vcbbb_salt" type="text" name="vcbbb_salt" value="<?php echo esc_attr( $bbb_settings['vcbbb_salt'] ); ?>" aria-describedby="vcbbb-salt-help">
									<div id="vcbbb-salt-help" class="vcbbb-field-help">
										<?php esc_html_e( 'Test Instance Secret:', 'video-conferencing-with-bbb' ); ?>
										<?php echo esc_html( $bbb_settings['vcbbb_default_salt'] ); ?>
									</div>
								</div>
							</div>

							<button type="submit" class="vcbbb-settings-save"><?php esc_html_e( 'Save Changes', 'video-conferencing-with-bbb' ); ?></button>

							<?php
							$vcbbb_how_to  = '<p class="vcbbb-howto-title"><span aria-hidden="true">&#128161;</span> ' . esc_html__( 'How to set this up', 'video-conferencing-with-bbb' ) . '</p>';
							$vcbbb_how_to .= '<div class="vcbbb-howto-steps">';
							$vcbbb_how_to .= '<div class="vcbbb-howto-step"><span class="vcbbb-howto-num">1</span><span>' . esc_html__( 'Use the values above for testing.', 'video-conferencing-with-bbb' ) . '</span></div>';
							$vcbbb_how_to .= '<div class="vcbbb-howto-step"><span class="vcbbb-howto-num">2</span><span>';
							$vcbbb_how_to .= sprintf(
								/* translators: 1: opening Blindside link, 2: closing Blindside link, 3: opening bigbluebutton.host link, 4: closing bigbluebutton.host link */
								esc_html__( 'For live classes, create your own account and choose a plan from %1$sBlindside Networks%2$s or %3$sbigbluebutton.host%4$s.', 'video-conferencing-with-bbb' ),
								'<a rel="noopener" href="https://registration-portal.blindsidenetworks.com/sign-in" target="_blank">',
								'</a>',
								'<a rel="noopener" href="https://bigbluebutton.host/plans/#economyplans" target="_blank">',
								'</a>'
							);
							$vcbbb_how_to .= '</span></div>';
							$vcbbb_how_to .= '<div class="vcbbb-howto-step"><span class="vcbbb-howto-num">3</span><span>' . esc_html__( 'Paste your URL and Secret here, then click Save Changes.', 'video-conferencing-with-bbb' ) . '</span></div>';
							$vcbbb_how_to .= '<div class="vcbbb-howto-step"><span class="vcbbb-howto-num">4</span><span>';
							$vcbbb_how_to .= sprintf(
								/* translators: 1: opening anchor tag, 2: closing anchor tag */
								esc_html__( 'Need help? Read the %1$shosting guide%2$s.', 'video-conferencing-with-bbb' ),
								'<a rel="noopener" href="https://elearningevolve.com/blog/hosting-virtual-classroom-for-wordpress" target="_blank">',
								'</a>'
							);
							$vcbbb_how_to .= '</span></div></div>';

							echo '<div id="endpoint-url-note" class="vcbbb-howto">';
							echo wp_kses(
								apply_filters( 'vcbbb_room_default_server_notice', $vcbbb_how_to ),
								array(
									'a'      => array(
										'href'   => true,
										'title'  => true,
										'target' => true,
										'rel'    => true,
									),
									'strong' => array( 'class' => true ),
									'p'      => array( 'class' => true ),
									'div'    => array( 'class' => true ),
									'span'   => array(
										'class'       => true,
										'aria-hidden' => true,
									),
									'h4'     => array( 'class' => true ),
								)
							);
							echo '</div>';
							?>
						<?php else : ?>
							<?php do_action( 'vcbbb_settings_tab_content', $tab ); ?>
							<button type="submit" class="vcbbb-settings-save"><?php esc_html_e( 'Save Changes', 'video-conferencing-with-bbb' ); ?></button>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<aside class="vcbbb-settings-sidebar">
				<div class="vcbbb-side-card">
					<h3><?php esc_html_e( 'Go To Links', 'video-conferencing-with-bbb' ); ?></h3>
					<div class="vcbbb-side-links">
						<a target="_blank" rel="noopener" href="https://wordpress.org/plugins/video-conferencing-with-bbb#faq/"><?php esc_html_e( 'FAQ: Commonly Occurring Issues', 'video-conferencing-with-bbb' ); ?></a>
						<a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/hosting-virtual-classroom-for-wordpress/"><?php esc_html_e( 'How to get Endpoint URL/Secret', 'video-conferencing-with-bbb' ); ?></a>
						<a target="_blank" rel="noopener" href="https://wordpress.org/support/plugin/video-conferencing-with-bbb/"><?php esc_html_e( 'Support Request', 'video-conferencing-with-bbb' ); ?></a>
						<a target="_blank" rel="noopener" href="https://wordpress.org/plugins/video-conferencing-with-bbb#reviews"><?php esc_html_e( 'Write a Review', 'video-conferencing-with-bbb' ); ?></a>
						<a target="_blank" rel="noopener" href="https://elearningevolve.com/contact/"><?php esc_html_e( 'Contact Us', 'video-conferencing-with-bbb' ); ?></a>
						<a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/bigbluebutton-hosting/"><?php esc_html_e( 'Recommended BigBlueButton Hosting', 'video-conferencing-with-bbb' ); ?></a>
					</div>
				</div>
				<div class="vcbbb-side-card">
					<h3 id="tutorials"><?php esc_html_e( 'Tutorials', 'video-conferencing-with-bbb' ); ?></h3>
					<div class="vcbbb-side-links">
						<a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/hosting-virtual-classroom-for-wordpress/"><?php esc_html_e( 'How to set up hosting & get Endpoint URL/Secret for Virtual Classroom for WordPress', 'video-conferencing-with-bbb' ); ?></a>
						<a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/how-to-allow-instructors-to-manage-bbb-rooms-on-wp/"><?php esc_html_e( 'How to allow instructors or users to manage BigBlueButton Rooms on WordPress', 'video-conferencing-with-bbb' ); ?></a>
						<a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/how-to-join-bigbluebutton-room-from-wordpress/"><?php esc_html_e( 'How to join BigBlueButton Room from WordPress', 'video-conferencing-with-bbb' ); ?></a>
						<a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/how-to-limit-number-of-users-for-bigbluebutton-room-on-wordpress/"><?php esc_html_e( 'How to limit number of users for BigBlueButton Room on WordPress', 'video-conferencing-with-bbb' ); ?></a>
					</div>
				</div>
			</aside>
		</div>
	</form>
</div>
