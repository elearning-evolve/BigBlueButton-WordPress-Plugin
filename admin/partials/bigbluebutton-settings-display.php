
<div class="zvc-row">
	<div class="zvc-position-floater-left">			
		<div class="bbb-settings-card">
			<h1><?php esc_html_e( 'Room Settings', 'bigbluebutton' ); ?></h1>
			<h2><?php esc_html_e( 'Server', 'bigbluebutton' ); ?></h2>
			<p><?php esc_html_e( 'There are 3 methods to get the BigBlueButton server details needed below.', 'bigbluebutton' ); ?></p>
			<ol>
				<li><?php echo sprintf( __( '%1$s You can use the default test install server hosted by Blindside Networks.', 'bigbluebutton' ), '<strong>' . esc_html( 'Default', 'bigbluebutton' ) . ':</strong>' ); ?></li>
				<li><?php echo sprintf( __( '%1$s You can host and %2$s BBB on your own server.', 'bigbluebutton' ), '<strong>' . esc_html( 'Fairly Technical', 'bigbluebutton' ) . ':</strong>', '<a target="_blank" href="https://bigbluebutton.org/2018/03/28/install-bigbluebutton-in-15-minutes/">' . esc_html( 'install', 'bigbluebutton' ) . '</a>' ); ?></li>
				<li><?php echo sprintf( __( '%1$s You can purchase a BigBlueButton cloud hosting service. Please %2$s for more details.', 'bigbluebutton' ), '<strong>' . esc_html( 'Recommended', 'bigbluebutton' ) . ':</strong>', '<a target="_blank" href="https://elearningevolve.com/contact/">' . esc_html( 'contact us', 'bigbluebutton' ) . '</a>' ); ?></li>
			</ol>
			
			<form id="bbb-general-settings-form" method="POST" action="">
				<input type="hidden" name="action" value="bbb_general_settings">
				<input type="hidden" id="bbb_edit_server_settings_meta_nonce" name="bbb_edit_server_settings_meta_nonce" value="<?php echo $meta_nonce; ?>">
				<div class="bbb-row">
					<p id="bbb_endpoint_label" class="bbb-col-left bbb-important-label"><?php esc_html_e( 'EndPoint URL', 'bigbluebutton' ); ?>: </p>
					<input class="bbb-col-right" type="text" name="bbb_url" size=50 value="<?php echo $bbb_settings['bbb_url']; ?>" aria-labelledby="bbb_endpoint_label">
				</div>
				<div class="bbb-row">
					<p class="bbb-col-left"></p>
					<label aria-labelledby="bbb_endpoint_label" class="bbb-col-right"><?php esc_html_e( 'Example', 'bigbluebutton' ); ?>: <?php echo $bbb_settings['bbb_default_url']; ?></label>
				</div>
				<div class="bbb-row">
					<p id="bbb_shared_secret_label" class="bbb-col-left bbb-important-label"><?php esc_html_e( 'Shared Secret/Salt', 'bigbluebutton' ); ?>: </p>
					<input class="bbb-col-right" type="text" name="bbb_salt" size=50 value="<?php echo $bbb_settings['bbb_salt']; ?>" aria-labelledby="bbb_shared_secret_label">
				</div>
				<div class="bbb-row">
					<p class="bbb-col-left"></p>
					<label class="bbb-col-right" aria-labelledby="bbb_shared_secret_label"><?php esc_html_e( 'Example', 'bigbluebutton' ); ?>: <?php echo $bbb_settings['bbb_default_salt']; ?></label>
				</div>
				<?php if ( $bbb_settings['bbb_url'] == $bbb_settings['bbb_default_url'] ) { ?>
				<label><?php esc_html_e( 'Default server settings 1. Default server settings 2.', 'bigbluebutton' ); ?></label>
				<?php } ?>
				<?php if ( $change_success == 1 ) { ?>
					<div class="updated">
						<p><?php esc_html_e( 'Save server settings success message.', 'bigbluebutton' ); ?></p>
					</div>
				<?php } elseif ( $change_success == 2 ) { ?>
					<div class="error">
						<p><?php esc_html_e( 'Save server settings bad url error message.', 'bigbluebutton' ); ?></p>
					</div>
				<?php } elseif ( $change_success == 3 ) { ?>
					<div class="error">
						<p><?php esc_html_e( 'Save server settings bad server settings error message.', 'bigbluebutton' ); ?></p>
					</div>
				<?php } ?>
				<br><br>
				<input class="button button-primary bbb-settings-submit" type="submit" value="<?php esc_html_e( 'Save Changes' ); ?>"/>
			</form>
		</div>
	</div>
	<div class="zvc-position-floater-right">
		<div class="zvc-information-sec">
			<h3>Go To Links</h3>
			<ol>
				<li><a target="_blank" href="https://wordpress.org/plugins/video-conferencing-with-bbb#faq/">FAQ: Commonly Occurring Issues</a></li>
				<li><a target="_blank" href="https://wordpress.org/support/plugin/video-conferencing-with-bbb/">Support Request</a></li>
				<li><a target="_blank" href="https://wordpress.org/plugins/video-conferencing-with-bbb#reviews">Write a Review</a></li>
				<li><a target="_blank" href="https://elearningevolve.com/contact/">Contact Us</a></li>
				<li><a href="<?php echo esc_url( admin_url( 'admin.php?page=bbb-room-subscribe-updates' ) ); ?>">Subscribe: Catch All Plugin Updates</a></li>
			</ol>
		</div>
		<!-- <div class="zvc-information-sec">
			<h3 id="tutorials">Tutorials</h3>
			<ol>
				<li>Generate Zoom Meeting from <a target="_blank" href="https://elearningevolve.com/blog/generate-zoom-meeting-shortcode/">WP Editor</a></li>
				<li>Setup <a target="_blank" href="https://elearningevolve.com/blog/zoom-webinar-on-wordpress/">Zoom Webinar</a></li>
				<li>Setup <a target="_blank" href="https://elearningevolve.com/blog/multiple-hosts-with-zoom/">Multiple Meeting Hosts</a></li>
				<li>Setup <a target="_blank" href="https://elearningevolve.com/blog/zoom-cloud-recordings-in-wordpress/">Meeting Cloud Recordings</a></li>
			</ol>
		</div> -->
		<div class="zvc-information-sec">
			<h3>Our Plugins</h3>
			<ol>
				<li>
					<p>Create & join Zoom meetings directly from your WordPress site with our powerful <a target="_blank" href="https://elearningevolve.com/products/zoom-wordpress-plugin">Zoom WordPress Plugin</a></p>
				</li>
				<li>
					<p>Enable students to become active contributors for your LearnDash courses with our <a target="_blank" href="https://elearningevolve.com/products/learndash-student-voice/">LearnDash Student Voice</a></p>
				</li>
			</ol>
		</div>
	</div>
</div>
