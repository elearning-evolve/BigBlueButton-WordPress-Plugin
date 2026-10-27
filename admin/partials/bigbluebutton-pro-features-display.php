<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}

$vcbbb_pro_features = array(
	__( 'Embed BigBlueButton Room on WordPress', 'video-conferencing-with-bbb' ),
	__( 'Set a Countdown/Schedule for Room', 'video-conferencing-with-bbb' ),
	__( 'Fully White-label Virtual Classroom', 'video-conferencing-with-bbb' ),
	__( 'Limit the max allowed participants for a room e.g (5, 10, .. etc) both on a per room and per page basis. This can allow you to conduct a 1:1 or group session', 'video-conferencing-with-bbb' ),
	__( 'Set a meeting duration in minutes e.g (30, 60, .. etc) so the room ends automatically when that time is up. Time starts when the meeting is created', 'video-conferencing-with-bbb' ),
	__( 'Upload your brand logo that is visible in the BBB room', 'video-conferencing-with-bbb' ),
	__( 'Customize the room background-color as per your brand color', 'video-conferencing-with-bbb' ),
	__( 'Change welcome message that is displayed in the Public Chat section of the room', 'video-conferencing-with-bbb' ),
	__( 'Customize thank you message when the user leaves the meeting', 'video-conferencing-with-bbb' ),
	__( 'Pre-upload your presentation (ability to upload both globally and per room basis)', 'video-conferencing-with-bbb' ),
	__( 'Moderator frontend room management area so teachers can log in from the site and create, edit, or start rooms without using the WordPress admin', 'video-conferencing-with-bbb' ),
);
?>
<div class="vcbbb-pro-page">
	<div class="vcbbb-pro-shell">
		<a class="vcbbb-pro-back" href="<?php echo esc_url( admin_url( 'admin.php?page=bbb-room-server-settings' ) ); ?>">&larr; <?php esc_html_e( 'Back to Settings', 'video-conferencing-with-bbb' ); ?></a>

		<div class="vcbbb-pro-header">
			<div>
				<h1><?php esc_html_e( 'Pro Version Feature', 'video-conferencing-with-bbb' ); ?></h1>
				<p><?php esc_html_e( 'Everything below is included with Virtual Classroom Pro.', 'video-conferencing-with-bbb' ); ?></p>
			</div>
			<a class="vcbbb-pro-upgrade" href="<?php echo esc_url( VIDEO_CONF_WITH_BBB_PRO ); ?>" target="_blank" rel="noopener noreferrer">
				<?php esc_html_e( 'Upgrade to Pro', 'video-conferencing-with-bbb' ); ?>
			</a>
		</div>

		<div class="vcbbb-pro-grid">
			<?php foreach ( $vcbbb_pro_features as $vcbbb_feature ) : ?>
				<div class="vcbbb-pro-card">
					<span class="vcbbb-pro-check" aria-hidden="true">&#10003;</span>
					<span class="vcbbb-pro-text"><?php echo esc_html( $vcbbb_feature ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
