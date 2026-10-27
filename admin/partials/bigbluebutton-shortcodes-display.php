<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}

$vcbbb_pro_active = VCBBB_Loader::is_bbb_pro_active();

$vcbbb_copy_icon  = '<svg class="vcbbb-sc-copy-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" focusable="false"><rect x="8" y="8" width="13" height="13" rx="2.25" fill="none" stroke="currentColor" stroke-width="2"/><path d="M16 8V5.75A2.25 2.25 0 0 0 13.75 3.5h-8A2.25 2.25 0 0 0 3.5 5.75v8A2.25 2.25 0 0 0 5.75 16H8" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';

$vcbbb_shortcode_blocks = array(
	array(
		'num'    => 1,
		'title'  => __( 'Moderator login', 'video-conferencing-with-bbb' ),
		'is_pro' => true,
		'rows'   => array(
			array(
				'code'   => '[bigbluebutton_moderator_login]',
				'is_pro' => true,
			),
		),
		'notes'  => array(
			__( 'Login form for the moderator (the person who starts the class).', 'video-conferencing-with-bbb' ),
		),
	),
	array(
		'num'    => 2,
		'title'  => __( 'Moderator room manager', 'video-conferencing-with-bbb' ),
		'is_pro' => true,
		'rows'   => array(
			array(
				'code'   => '[bigbluebutton_room_manage]',
				'is_pro' => true,
			),
		),
		'notes'  => array(
			__( 'After login, the moderator can create and edit rooms.', 'video-conferencing-with-bbb' ),
		),
	),
	array(
		'num'    => 3,
		'title'  => __( 'All rooms with Join', 'video-conferencing-with-bbb' ),
		'is_pro' => true,
		'rows'   => array(
			array(
				'code'   => '[bigbluebutton_all_rooms]',
				'is_pro' => true,
			),
		),
		'notes'  => array(
			__( 'Shows every room with a Join button.', 'video-conferencing-with-bbb' ),
		),
	),
	array(
		'num'    => 4,
		'title'  => __( 'Selected rooms with Join', 'video-conferencing-with-bbb' ),
		'is_pro' => true,
		'rows'   => array(
			array(
				'code'   => "[bigbluebutton token='z2xxx, z2yyy, ...' room_limit='50']",
				'is_pro' => true,
			),
			array(
				'code'   => "[bigbluebutton token='z2xxx, z2yyy, ...']",
				'is_pro' => false,
			),
		),
		'notes'  => array(
			__( 'Shows only the rooms you choose (use the token from BBB Rooms → All Rooms).', 'video-conferencing-with-bbb' ),
			__( 'Optional: room_limit = max people at one time. This Pro attribute overrides Settings → Room Config and the room-level limit.', 'video-conferencing-with-bbb' ),
		),
	),
	array(
		'num'    => 5,
		'title'  => __( 'One room with Join', 'video-conferencing-with-bbb' ),
		'is_pro' => true,
		'rows'   => array(
			array(
				'code'   => "[bigbluebutton token='z2xxx' room_limit='50']",
				'is_pro' => true,
			),
			array(
				'code'   => "[bigbluebutton token='z2xxx']",
				'is_pro' => false,
			),
		),
		'notes'  => array(
			__( 'Shows Join/Start for one room. Use the token from BBB Rooms → All Rooms → Token.', 'video-conferencing-with-bbb' ),
			__( 'Two versions (with or without room_limit) — paste only one, or the room appears twice.', 'video-conferencing-with-bbb' ),
		),
	),
	array(
		'num'    => 6,
		'title'  => __( 'One room with duration', 'video-conferencing-with-bbb' ),
		'is_pro' => true,
		'rows'   => array(
			array(
				'code'   => "[bigbluebutton token='z2xxx' duration='60']",
				'is_pro' => true,
			),
		),
		'notes'  => array(
			__( 'Shows Join/Start for one room and ends the meeting after the minutes you set. Use the token from BBB Rooms → All Rooms → Token.', 'video-conferencing-with-bbb' ),
			__( 'Optional: duration = meeting length in minutes. 60 = 60 minutes. This Pro attribute ends the meeting when that time is up. Time starts when the meeting is created.', 'video-conferencing-with-bbb' ),
			__( 'Paste this instead of the plain Join shortcode, or the room appears twice.', 'video-conferencing-with-bbb' ),
		),
	),
	array(
		'num'    => 7,
		'title'  => __( 'Recordings from several rooms', 'video-conferencing-with-bbb' ),
		'is_pro' => false,
		'rows'   => array(
			array(
				'code'   => "[bigbluebutton_recordings token='z2xxx, z2yyy, ...']",
				'is_pro' => false,
			),
		),
		'notes'  => array(
			__( 'Shows recorded meetings from the rooms you list. Use tokens from BBB Rooms → All Rooms → Token.', 'video-conferencing-with-bbb' ),
		),
	),
	array(
		'num'    => 8,
		'title'  => __( 'Recordings from one room', 'video-conferencing-with-bbb' ),
		'is_pro' => false,
		'rows'   => array(
			array(
				'code'   => "[bigbluebutton_recordings token='z2xxx']",
				'is_pro' => false,
			),
		),
		'notes'  => array(
			__( 'Shows recorded meetings from one room. Use the token from BBB Rooms → All Rooms → Token.', 'video-conferencing-with-bbb' ),
		),
	),
);
?>
<div class="vcbbb-shortcode-page">
	<div class="vcbbb-sc-shell">
		<a class="vcbbb-sc-back" href="<?php echo esc_url( admin_url( 'admin.php?page=bbb-room-server-settings' ) ); ?>">&larr; <?php esc_html_e( 'Back to Settings', 'video-conferencing-with-bbb' ); ?></a>

		<h1><?php esc_html_e( 'How to add a room to a page', 'video-conferencing-with-bbb' ); ?></h1>

		<div class="vcbbb-sc-intro">
			<span class="vcbbb-sc-intro-icon" aria-hidden="true">&#128161;</span>
			<div>
				<p><?php esc_html_e( 'A shortcode is a small code you paste into a WordPress page. Each one shows a different part of the classroom.', 'video-conferencing-with-bbb' ); ?></p>
				<p>
					<strong><?php esc_html_e( 'Moderator', 'video-conferencing-with-bbb' ); ?></strong>
					<?php esc_html_e( '= the person who starts the class.', 'video-conferencing-with-bbb' ); ?>
					<strong><?php esc_html_e( 'Viewer', 'video-conferencing-with-bbb' ); ?></strong>
					<?php esc_html_e( '= the person who joins it.', 'video-conferencing-with-bbb' ); ?>
				</p>
			</div>
		</div>

		<div id="shortcodes" class="vcbbb-sc-grid">
			<?php foreach ( $vcbbb_shortcode_blocks as $vcbbb_block ) : ?>
				<?php
				$vcbbb_card_locked = ! empty( $vcbbb_block['is_pro'] ) && ! $vcbbb_pro_active;
				$vcbbb_card_class  = 'vcbbb-sc-card';
				if ( $vcbbb_card_locked ) {
					$vcbbb_card_class .= ' vcbbb-sc-card-pro';
				}
				?>
				<div class="<?php echo esc_attr( $vcbbb_card_class ); ?>" tabindex="0">
					<?php if ( $vcbbb_card_locked ) : ?>
						<span class="vcbbb-pro-tag" title="<?php echo esc_attr__( 'Available in the Pro version', 'video-conferencing-with-bbb' ); ?>">
							<span class="dashicons dashicons-star-filled" aria-hidden="true"></span>
							<span class="vcbbb-pro-tag-label"><?php esc_html_e( 'PRO', 'video-conferencing-with-bbb' ); ?></span>
						</span>
					<?php endif; ?>

					<div class="vcbbb-sc-card-title">
						<?php echo esc_html( (int) $vcbbb_block['num'] . '. ' . $vcbbb_block['title'] ); ?>
					</div>

					<?php foreach ( $vcbbb_block['rows'] as $vcbbb_row ) : ?>
						<?php $vcbbb_row_locked = ! empty( $vcbbb_row['is_pro'] ) && ! $vcbbb_pro_active; ?>
						<div class="vcbbb-sc-row<?php echo $vcbbb_row_locked ? ' is-disabled' : ''; ?>">
							<div class="vcbbb-sc-code"><?php echo esc_html( $vcbbb_row['code'] ); ?></div>
							<?php if ( $vcbbb_row_locked ) : ?>
								<span class="vcbbb-sc-copy is-disabled" title="<?php echo esc_attr__( 'Available in the Pro version', 'video-conferencing-with-bbb' ); ?>" aria-disabled="true">
									<?php echo $vcbbb_copy_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG icon. ?>
								</span>
							<?php else : ?>
								<span
									class="tooltip vcbbb-sc-copy"
									onclick="copyToClipboard(this)"
									onmouseout="copyClipboardExit(this)"
									data-value="<?php echo esc_attr( $vcbbb_row['code'] ); ?>"
									role="button"
									tabindex="0"
								>
									<span class="tooltiptext shortcode-tooltip"><?php esc_html_e( 'Copy Shortcode', 'video-conferencing-with-bbb' ); ?></span>
									<?php echo $vcbbb_copy_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG icon. ?>
								</span>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>

					<div class="vcbbb-sc-notes">
						<?php foreach ( $vcbbb_block['notes'] as $vcbbb_note ) : ?>
							<div class="vcbbb-sc-note">
								<span class="vcbbb-sc-bullet" aria-hidden="true">&#8226;</span>
								<span><?php echo esc_html( $vcbbb_note ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<div id="vcbbb-sc-modal" class="vcbbb-sc-modal" aria-hidden="true">
		<div class="vcbbb-sc-modal-backdrop"></div>
		<div class="vcbbb-sc-modal-dialog" role="dialog" aria-modal="true">
			<button type="button" class="vcbbb-sc-modal-close" aria-label="<?php esc_attr_e( 'Close', 'video-conferencing-with-bbb' ); ?>">&times;</button>
			<div class="vcbbb-sc-modal-body"></div>
		</div>
	</div>
</div>
