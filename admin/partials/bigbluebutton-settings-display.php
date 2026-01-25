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
				<?php do_action( 'bbb_settings_tab_nav', $tab ); ?>
			</nav>		
			<form id="bbb-general-settings-form" method="POST" action="" enctype="multipart/form-data">
				<input type="hidden" name="action" value="bbb_general_settings">
				<input type="hidden" id="bbb_edit_server_settings_meta_nonce" name="bbb_edit_server_settings_meta_nonce" value="<?php echo $meta_nonce; ?>">
				 <div class="tab-content">
					<?php if ( null === $tab ) : ?>
						<?php do_action( 'bbb_setup_tab_content' ); ?>
						<div class="bbb-row">
							<p id="bbb_endpoint_label" class="bbb-col-left bbb-important-label"><?php esc_html_e( 'EndPoint URL', 'bigbluebutton' ); ?>: </p>
							<input class="bbb-col-right" type="text" name="bbb_url" size=50 value="<?php echo esc_url( $bbb_settings['bbb_url'] ); ?>" aria-labelledby="bbb_endpoint_label">
						</div>
						<div class="bbb-row">
							<p class="bbb-col-left"></p>
							<label aria-labelledby="bbb_endpoint_label" class="bbb-col-right"><i><?php esc_html_e( 'Test Instance Endpoint', 'bigbluebutton' ); ?>: <?php echo esc_url( $bbb_settings['bbb_default_url'] ); ?></i></label>
						</div>
						<div class="bbb-row">
							<p id="bbb_shared_secret_label" class="bbb-col-left bbb-important-label"><?php esc_html_e( 'Shared Secret/Salt', 'bigbluebutton' ); ?>: </p>
							<input class="bbb-col-right" type="text" name="bbb_salt" size=50 value="<?php echo esc_attr( $bbb_settings['bbb_salt'] ); ?>" aria-labelledby="bbb_shared_secret_label">
						</div>
						<div class="bbb-row">
							<p class="bbb-col-left"></p>
							<label class="bbb-col-right" aria-labelledby="bbb_shared_secret_label"><?php esc_html_e( 'Test Instance Secret', 'bigbluebutton' ); ?>: <?php echo esc_attr( $bbb_settings['bbb_default_salt'] ); ?></label>
						</div>
						<br />
						<label id="endpoint-url-note">
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
										'h4'     => array(
											'class' => array(),
										),
										'p'      => array(
											'class' => array(),
										),
									)
								)
							);
							?>
						</label>
						
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
				<input class="bbb-settings-btn bbb-settings-submit" type="submit" value="<?php esc_html_e( 'Save Changes' ); ?>"/>
			</form>
		</div>
		<section id="shortcodes" class="bbb-pro-shortcode-usage">
			<h3>Shortcode Usage Guide</h3>
			<p>Below are the <a rel="noopnerer" target="_blank" href="https://www.wpbeginner.com/wp-tutorials/how-to-add-a-shortcode-in-wordpress/">shortcodes</a> offered by the plugin that you can use anywhere on your site.</p>
				<ol>
					<li>
						<p>Display moderator login from on frontend</p>
						<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)"
							data-value="[bigbluebutton_moderator_login]">
							<span class="tooltiptext shortcode-tooltip"><?php esc_html_e( 'Copy Shortcode', 'bigbluebutton' ); ?></span>
							<input size="30" type="text" disabled value="[bigbluebutton_moderator_login]"/>
							<span class="bbb-dashicon dashicons dashicons-admin-page"></span> <strong><?php esc_html_e( 'Pro Version Note', 'bigbluebutton' ); ?></strong>
						</span>
						<div class="desc">
							<ul>
								<li>This shortcode displays the moderator login form on frontend</li>
							</ul>
						</div>
					</li>
					<li>
						<p>Display moderator room management area</p>
						<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)"
							data-value="[bigbluebutton_room_manage]">
							<span class="tooltiptext shortcode-tooltip"><?php esc_html_e( 'Copy Shortcode', 'bigbluebutton' ); ?></span>
							<input size="30" type="text" disabled value="[bigbluebutton_room_manage]"/>
							<span class="bbb-dashicon dashicons dashicons-admin-page"></span> <strong><?php esc_html_e( 'Pro Version Note', 'bigbluebutton' ); ?></strong>
						</span>
						<div class="desc">
							<ul>
								<li>This shortcode displays the moderator room management area on frontend</li>
							</ul>
						</div>
					</li>
					<li>
						<p>Display all the available BBB rooms with the join form</p>
						<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)"
							data-value="[bigbluebutton_all_rooms]">
							<span class="tooltiptext shortcode-tooltip"><?php esc_html_e( 'Copy Shortcode', 'bigbluebutton' ); ?></span>
							<input size="30" type="text" disabled value="[bigbluebutton_all_rooms]"/>
							<span class="bbb-dashicon dashicons dashicons-admin-page"></span> <strong><?php esc_html_e( 'Pro Version Note', 'bigbluebutton' ); ?></strong>
						</span>
						<div class="desc">
							<ul>
								<li>This shortcode will show all the rooms created under BBB Rooms -> All Rooms to the user</li>
							</ul>
						</div>
					</li>
					
					<li>
						<p>Display a list of BBB rooms with join form</p>
						<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)"
							data-value="[bigbluebutton token='z2xxx, z2yyy, ...' room_limit='50']">
							<span class="tooltiptext shortcode-tooltip"><?php esc_html_e( 'Copy Shortcode', 'bigbluebutton' ); ?></span>
							<input size="40" type="text" disabled value="[bigbluebutton token='z2xxx, z2yyy, ...' room_limit='50']"/>
							<span class="bbb-dashicon dashicons dashicons-admin-page"></span> <strong><?php esc_html_e( 'Pro Version Note', 'bigbluebutton' ); ?></strong>
						</span>
						<div class="spacer"></div>
						<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)"
							data-value="[bigbluebutton token='z2xxx, z2yyy, ...']">
							<span class="tooltiptext shortcode-tooltip"><?php esc_html_e( 'Copy Shortcode', 'bigbluebutton' ); ?></span>
							<input size="30" type="text" disabled value="[bigbluebutton token='z2xxx, z2yyy, ...']"/>
							<span class="bbb-dashicon dashicons dashicons-admin-page"></span>
						</span>
						<div class="desc">
							<ul>
								<li><strong>token</strong> : The BBB Room tokens, see BBB Rooms -> All Rooms -> Token</li>								
								<li><strong>room_limit (overrides Settings -> Room Config  & Room level limit)</strong> : Set the max no.of users allowed to join the room at the same time</li>
							</ul>
						</div>
					</li>
					<li>
						<p>Add this shortcode to your page to show a single BBB room join form</p>
							<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)"
								data-value="[bigbluebutton token='z2xxx' room_limit='50']">
								<span class="tooltiptext shortcode-tooltip"><?php esc_html_e( 'Copy Shortcode', 'bigbluebutton' ); ?></span>
								<input size="30" type="text" disabled value="[bigbluebutton token='z2xxx' room_limit='50']"/>
								<span class="bbb-dashicon dashicons dashicons-admin-page"></span> <strong><?php esc_html_e( 'Pro Version Note', 'bigbluebutton' ); ?></strong>
							</span>
							<div class="spacer"></div>
							<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)"
								data-value="[bigbluebutton token='z2xxx']">
								<span class="tooltiptext shortcode-tooltip"><?php esc_html_e( 'Copy Shortcode', 'bigbluebutton' ); ?></span>
								<input size="30" type="text" disabled value="[bigbluebutton token='z2xxx']"/>
								<span class="bbb-dashicon dashicons dashicons-admin-page"></span>
							</span>
						<div class="desc">
							<ul>
								<li><strong>token</strong> : The BBB Room token, see BBB Rooms -> All Rooms -> Token</li>
								<li><strong>room_limit (overrides Settings -> Room Config  & Room level limit)</strong> : Set the max no.of users allowed to join the room at the same time</li>
							</ul>
						</div>
					</li>
					<li>
						<p>Display a list of BBB room recordings from multiple rooms</p>
							<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)"
								data-value="[bigbluebutton_recordings token='z2xxx, z2yyy, ...']">
								<span class="tooltiptext shortcode-tooltip"><?php esc_html_e( 'Copy Shortcode', 'bigbluebutton' ); ?></span>
								<input size="40" type="text" disabled value="[bigbluebutton_recordings token='z2xxx, z2yyy, ...']"/>
								<span class="bbb-dashicon dashicons dashicons-admin-page"></span>
							</span>
						<div class="desc">
							<ul>
								<li><strong>token</strong> : The BBB Room tokens, see BBB Rooms -> All Rooms -> Token</li>
							</ul>
						</div>
					</li>
					<li>
						<p>Display BBB room recordings from a single room</p>
							<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)"
								data-value="[bigbluebutton_recordings token='z2xxx']">
								<span class="tooltiptext shortcode-tooltip"><?php esc_html_e( 'Copy Shortcode', 'bigbluebutton' ); ?></span>
								<input size="30" type="text" disabled value="[bigbluebutton_recordings token='z2xxx']"/>
								<span class="bbb-dashicon dashicons dashicons-admin-page"></span>
							</span>
						<div class="desc">
							<ul>
								<li><strong>token</strong> : The BBB Room token, see BBB Rooms -> All Rooms -> Token</li>
							</ul>
						</div>
					</li>
				</ol>
		</section>
	</div>
	<div class="zvc-position-floater-right">
		<div class="zvc-information-sec">
			<img width="70%" height="25" src="<?php echo VIDEO_CONF_WITH_BBB_IMG_URL . '/learndash-logo.webp'; ?>" title="LearnDash LMS Development Service" alt="LearnDash LMS Development Service"/>
				<h3>Need help with LMS Building?</h3>
				<p>Being officially recognized as LearnDash LMS experts, we're here to aid you with your customization needs.</p>
				<a target="_blank" rel="noopener"
					href="<?php echo esc_url( 'https://elearningevolve.com/learndash-developer/' ); ?>">
					<button class="bbb-settings-btn">View LearnDash Services</button>
				</a>
			</div>
			
		<div class="zvc-information-sec">
				<h3>Never miss an important update</h3>
				<a target="_blank" rel="noopener"
					href="<?php echo esc_url( 'https://elearningevolve.com/subscribe/?display_name=' . $display_name . '&user_email=' . $user_email ); ?>">
					<button class="bbb-settings-btn">Subscribe</button>
				</a>
			</div>
		<div class="zvc-information-sec">
			<h3>Go To Links</h3>
			<ol>
				<li><a target="_blank" rel="noopener" href="https://wordpress.org/plugins/video-conferencing-with-bbb#faq/">FAQ: Commonly Occurring Issues</a></li>
				<li><a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/hosting-virtual-classroom-for-wordpress/">How to get Endpoint URL/Secret</a></li>
				<li><a target="_blank" rel="noopener" href="https://wordpress.org/support/plugin/video-conferencing-with-bbb/">Support Request</a></li>
				<li><a target="_blank" rel="noopener" href="https://wordpress.org/plugins/video-conferencing-with-bbb#reviews">Write a Review</a></li>
				<li><a target="_blank" rel="noopener" href="https://elearningevolve.com/contact/">Contact Us</a></li>
				<li><a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/bigbluebutton-hosting/">Recommended BigBlueButton Hosting</a></li>
			</ol>
		</div>
		<div class="zvc-information-sec">
			<h3 id="tutorials">Tutorials</h3>
			<ol>
				<li><a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/hosting-virtual-classroom-for-wordpress/">How to set up hosting & get Endpoint URL/Secret for Virtual Classroom for WordPress</a></li>
				<li><a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/how-to-allow-instructors-to-manage-bbb-rooms-on-wp/">How to allow instructors or users to manage BigblueButton Rooms on WordPress</a></li>
				<li><a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/how-to-join-bigbluebutton-room-from-wordpress/">How to join BigBlueButton Room from WordPress</a></li>
				<li><a target="_blank" rel="noopener" href="https://elearningevolve.com/blog/how-to-limit-number-of-users-for-bigbluebutton-room-on-wordpress/">How to limit number of users for BigBlueButton Room on WordPress
					</a>
				</li>
			</ol>
		</div>
		<?php if ( ! Bigbluebutton_Loader::is_bbb_pro_active() ) : ?>
		<div class="zvc-information-sec">
			<h3 id="pro-version"><a target="_blank" rel="noopener" href="https://elearningevolve.com/products/bigbluebutton-wordpress-pro/">Pro Version Features</a></h3>
			<ul>
				<li>Embed BigBlueButton Room on WordPress</li>
				<li>Set a Countdown/Schedule for Room</li>
				<li>Fully White-label Virtual Classroom</li>
				<li>Limit the max allowed participants for a room e.g (5, 10, .. etc) both on a per room and per page basis. This can allow you to conduct a 1:1 or group session</li>
				<li>Upload your brand logo that is visible in the BBB room</li>
				<li>Customize the room background-color as per your brand color</li>
				<li>Change welcome message that is displayed in the Public Chat section of the room</li>
				<li>Customize thank you message when the user leaves the meeting</li>
				<li>Pre-upload your presentation (ability to upload both globally and per room basis)</li>
			</ul>
		</div>
		<?php endif; ?>
		<?php if ( ! Bigbluebutton_Loader::is_bbb_pro_active() ) : ?>
			<div class="zvc-information-sec">
				<h3>Pro Version</h3>
					<img width="100%" height="180" src="<?php echo VIDEO_CONF_WITH_BBB_IMG_URL . '/video-conferencing-with-BBB.png'; ?>" title="BigBlueButton WordPress Pro" alt="BigBlueButton WordPress Pro"/>
					<p>
						Pro version of this plugin that enables you to create fully white-label virtual classrooms & enhanced customization options for BBB Rooms.
					</p>
					<a rel="noopnerer"  target="_blank" href="https://elearningevolve.com/products/video-conferencing-with-bbb-pro/"><button class="bbb-settings-btn">View More</button></a>
					<hr />
			</div>
		<?php endif; ?>
	</div>
</div>
