
<div class="zvc-row">
	<div class="zvc-position-floater-left">			
		<div class="bbb-settings-card">
			<h1><?php esc_html_e( 'Room Settings', 'bigbluebutton' ); ?></h1>
			<nav class="nav-tab-wrapper">
				<a href="?page=bbb-room-server-settings" class="nav-tab 
				<?php
				if ( $tab === null ) :
					?>
				 nav-tab-active 
				<?php endif; ?>"><?php esc_html_e( 'Setup', 'bigbluebutton' ); ?></a>
				<?php do_action( 'bbb_settings_tab_nav' ); ?>
			</nav>		
			<form id="bbb-general-settings-form" method="POST" action="" enctype="multipart/form-data">
				<input type="hidden" name="action" value="bbb_general_settings">
				<input type="hidden" id="bbb_edit_server_settings_meta_nonce" name="bbb_edit_server_settings_meta_nonce" value="<?php echo $meta_nonce; ?>">
				 <div class="tab-content">
					<?php if ( null === $tab ) : ?>
						<?php do_action( 'bbb_setup_tab_content' ); ?>
						<h4><?php esc_html_e( 'There are 3 methods to get the BBB server EndPoint URL and Salt required below:', 'bigbluebutton' ); ?></h4>
						<ol>
							<li><?php echo sprintf( __( '%1$s You can use the default test install server hosted by %2$s.', 'bigbluebutton' ), '<strong>' . esc_html( 'Default (for dev/staging site only)', 'bigbluebutton' ) . ':</strong>', '<a target="_blank" rel="noopener" href="https://bigbluebutton.host">Bigbluebutton.host</a>' ); ?></li>
							<li><?php echo sprintf( __( '%1$s You can host and %2$s BBB on your own server.', 'bigbluebutton' ), '<strong>' . esc_html( 'Fairly Technical', 'bigbluebutton' ) . ':</strong>', '<a target="_blank" rel="noopener" href="https://bigbluebutton.org/2018/03/28/install-bigbluebutton-in-15-minutes/">' . esc_html( 'install', 'bigbluebutton' ) . '</a>' ); ?></li>
							<li><?php echo sprintf( __( '%1$s You can choose one of our recommended managed %2$s.', 'bigbluebutton' ), '<strong>' . esc_html( 'Recommended (for production site)', 'bigbluebutton' ) . ':</strong>', '<a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/bigbluebutton-hosting">' . esc_html( 'BBB hosting providers', 'bigbluebutton' ) . '</a>' ); ?></li>
						</ol>
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
						<br />
						<?php if ( $bbb_settings['bbb_url'] == $bbb_settings['bbb_default_url'] ) { ?>
						<label>
							<?php
							echo apply_filters(
								'bbb_room_default_server_notice',
								wp_kses(
									__( 'Default server settings 1. Default server settings 2.', 'bigbluebutton' ),
									array(
										'a'      => array(
											'href'   => array(),
											'title'  => array(),
											'target' => array(),
											'rel'    => array(),
										),
										'strong' => array(
											'class' => array(),
										),
									)
								)
							);
							?>
						</label>
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
					<?php else : ?>
						<?php do_action( 'bbb_settings_tab_content' ); ?>
					<?php endif; ?>
				 </div>
				<br><br>
				<input class="button button-primary bbb-settings-submit" type="submit" value="<?php esc_html_e( 'Save Changes' ); ?>"/>
			</form>
		</div>
		<section id="shortcodes" class="bbb-pro-shortcode-usage">
			<h3>Shortcode Usage Guide</h3>
			<p>Below are the <a rel="noopnerer"  target="_blank" href="https://www.wpbeginner.com/wp-tutorials/how-to-add-a-shortcode-in-wordpress/">shortcodes</a> offered by the plugin that you can use anywhere on your site.</p>
				<ol>
					<li>
						<p>Display a list of BBB rooms for the user to choose from</p>
						<?php if ( Bigbluebutton_Loader::is_bbb_pro_active() ) : ?>
							<code>[bigbluebutton token='zxxxx, zyyyy, ...' room_limit='x']</code>
						<?php else : ?>
							<code>[bigbluebutton token='zxxxx, zyyyy, ...']</code>
						<?php endif; ?>
						<div class="desc">
							<ul>
								<li><strong>tokens</strong> : The BBB Room tokens, see BBB Rooms -> All Rooms -> Token</li>
								<?php if ( Bigbluebutton_Loader::is_bbb_pro_active() ) : ?>
									<li><strong>room_limit (overrides global setting)</strong> : Set the max no.of users allowed to join the room at the same time</li>
								<?php endif; ?>
							</ul>
						</div>
					</li>
					<li>
						<p>Display a specific BBB room window anywhere on the site</p>
						<?php if ( Bigbluebutton_Loader::is_bbb_pro_active() ) : ?>
							<code>[bigbluebutton token='zxxxx' room_limit='x']</code>
						<?php else : ?>
							<code>[bigbluebutton token='zxxxx']</code>
						<?php endif; ?>
						<div class="desc">
							<ul>
								<li><strong>token</strong> : The BBB Room token, see BBB Rooms -> All Rooms -> Token</li>
								<?php if ( Bigbluebutton_Loader::is_bbb_pro_active() ) : ?>
									<li><strong>room_limit (overrides global setting)</strong> : Set the max no.of users allowed to join the room at the same time</li>
								<?php endif; ?>
							</ul>
						</div>
					</li>
				</ol>
		</section>
	</div>
	<div class="zvc-position-floater-right">
		<div class="zvc-information-sec">
			<h3>Go To Links</h3>
			<ol>
				<li><a target="_blank" rel="noopener" href="https://wordpress.org/plugins/video-conferencing-with-bbb#faq/">FAQ: Commonly Occurring Issues</a></li>
				<li><a target="_blank" rel="noopener" href="https://wordpress.org/support/plugin/video-conferencing-with-bbb/">Support Request</a></li>
				<li><a target="_blank" rel="noopener" href="https://wordpress.org/plugins/video-conferencing-with-bbb#reviews">Write a Review</a></li>
				<li><a target="_blank" rel="noopener" href="https://elearningevolve.com/contact/">Contact Us</a></li>
				<li><a href="<?php echo esc_url( admin_url( 'admin.php?page=bbb-room-subscribe-updates' ) ); ?>">Subscribe: Catch All Plugin Updates</a></li>
				<li><a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/bigbluebutton-hosting/">Recommended BigBlueButton Hosting</a></li>
			</ol>
		</div>
		<!-- <div class="zvc-information-sec">
			<h3 id="tutorials">Tutorials</h3>
			<ol>
				<li>Generate Zoom Meeting from <a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/generate-zoom-meeting-shortcode/">WP Editor</a></li>
				<li>Setup <a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/zoom-webinar-on-wordpress/">Zoom Webinar</a></li>
				<li>Setup <a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/multiple-hosts-with-zoom/">Multiple Meeting Hosts</a></li>
				<li>Setup <a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/zoom-cloud-recordings-in-wordpress/">Meeting Cloud Recordings</a></li>
			</ol>
		</div> -->
		<div class="zvc-information-sec">
			<h3>Our Plugins</h3>
			<ol>
				<?php if ( ! Bigbluebutton_Loader::is_bbb_pro_active() ) : ?>
				<li>
					<p><strong><a target="_blank" rel="noopener" href="https://elearningevolve.com/products/bigbluebutton-wordpress-pro/">Video Conferencing with BigBlueButton (BBB) Pro</a></strong> is a premium plugin that provides enhanced features on top of our free plugin.</p>
				</li>
				<?php endif; ?>
				<li>
					<p>Create & join Zoom meetings directly from your WordPress site with our powerful <a target="_blank" rel="noopener" href="https://elearningevolve.com/products/zoom-wordpress-plugin">Zoom WordPress Plugin</a></p>
				</li>
				<li>
					<p>Enable students to become active contributors for your LearnDash courses with our <a target="_blank" rel="noopener" href="https://elearningevolve.com/products/learndash-student-voice/">LearnDash Student Voice</a></p>
				</li>
			</ol>
		</div>
	</div>
</div>
