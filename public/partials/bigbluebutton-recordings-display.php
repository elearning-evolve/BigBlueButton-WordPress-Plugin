<div id="bbb-recordings-list-<?php echo esc_attr( $room_id ); ?>">
	<?php if ( empty( $recordings ) ) { ?>
		<p id="bbb-no-recordings-msg"><?php esc_html_e( 'This room does not currently have any recordings.', 'bigbluebutton' ); ?></p>
	<?php } else { ?>
		<p id="bbb-no-recordings-msg" style="display:none;"><?php esc_html_e( 'This room does not currently have any recordings.', 'bigbluebutton' ); ?></p>
		<div id="bbb-recordings-table" class="bbb-table-container" role="table">
			<div class="bbb-flex-table bbb-flex-table-<?php echo $columns; ?> bbb-header" role="rowgroup">
				<!-- <div class="flex-row flex-row-<?php echo $columns; ?> first" role="columnheader"><?php esc_html_e( 'Meeting', 'bigbluebutton' ); ?></div> -->
				<a href="<?php echo esc_url( $sort_fields['name']->url ); ?>" class="flex-row flex-row-<?php echo esc_attr( $columns ); ?> <?php echo esc_html( $sort_fields['name']->header_classes ); ?>" role="columnheader">
					<?php esc_html_e( 'Recording', 'bigbluebutton' ); ?>
					<i class="<?php echo esc_attr( $sort_fields['name']->classes ); ?>"></i>
				</a>
				<?php if( $recording_description_exist ): ?>
				<a href="<?php echo esc_url( $sort_fields['description']->url ); ?>" class="flex-row flex-row-<?php echo esc_attr( $columns ); ?> <?php echo esc_html( $sort_fields['description']->header_classes ); ?>" role="columnheader">
					<?php esc_html_e( 'Description' ); ?>
					<i class="<?php echo esc_attr( $sort_fields['description']->classes ); ?>"></i>
				</a>
				<?php endif; ?>
				<a href="<?php echo esc_url( $sort_fields['date']->url ); ?>" class="flex-row flex-row-<?php echo esc_attr( $columns ); ?> <?php echo esc_html( $sort_fields['date']->header_classes ); ?>" role="columnheader">
					<?php esc_html_e( 'Date' ); ?>
					<i class="<?php echo esc_attr( $sort_fields['date']->classes ); ?>"></i>
				</a>
				<div class="flex-row flex-row-<?php echo esc_attr( $columns ); ?>" role="columnheader"><?php esc_html_e( 'Action' ); ?></div>
				<?php if ( $manage_bbb_recordings ) { ?>
					<div class="flex-row flex-row-<?php echo esc_attr( $columns ); ?>" role="columnheader">
						<?php esc_html_e( 'Manage', 'bigbluebutton' ); ?>
					</div>
				<?php } ?>
			</div>
			<?php foreach ( $recordings as $recording ) { ?>
				<div id="bbb-recording-<?php echo esc_attr( $recording->recordID ); ?>" class="bbb-flex-table bbb-flex-table-<?php echo esc_attr( $columns ); ?> bbb-recording-row" role="rowgroup">
					<!-- <div class="flex-row flex-row-<?php echo esc_attr( $columns ); ?> first" role="cell"><?php echo esc_html( urldecode( $recording->name ) ); ?></div> -->
					<div id="bbb-recording-name-<?php echo esc_attr( $recording->recordID ); ?>" class="flex-row flex-row-<?php echo esc_attr( $columns ); ?>" role="cell">
						<?php echo esc_html( urldecode( $recording->metadata->{'recording-name'} ) ); ?>
						<?php if ( $manage_bbb_recordings ) { ?>
							<i id="edit-recording-name-<?php echo esc_attr( $recording->recordID ); ?>"
								title="<?php esc_html_e( 'Edit' ); ?>"
								aria-label="<?php esc_html_e( 'Edit' ); ?>"
								data-record-id="<?php echo esc_attr( $recording->recordID ); ?>"
								data-record-value="<?php echo esc_attr( urldecode( $recording->metadata->{'recording-name'} ) ); ?>"
								data-record-type="name"
								data-meta-nonce="<?php echo esc_attr( $meta_nonce ); ?>"
								class="dashicons dashicons-edit bbb-icon bbb_edit_recording_data"></i>
						<?php } ?>
					</div>
					<?php if( $recording_description_exist ): ?>
						<div id="bbb-recording-description-<?php echo esc_attr( $recording->recordID ); ?>" class="flex-row flex-row-<?php echo esc_attr( $columns ); ?>" role="cell">
							<?php echo esc_html( urldecode( $recording->metadata->{'recording-description'} ) ); ?>
							<?php if ( $manage_bbb_recordings ) { ?>
								<i id="edit-recording-description-<?php echo esc_attr( $recording->recordID ); ?>"
									title="<?php esc_html_e( 'Edit' ); ?>"
									aria-label="<?php esc_html_e( 'Edit' ); ?>"
									data-record-id="<?php echo esc_attr( $recording->recordID ); ?>"
									data-record-value="<?php echo esc_attr( urldecode( $recording->metadata->{'recording-description'} ) ); ?>"
									data-record-type="description"
									data-meta-nonce="<?php echo esc_attr( $meta_nonce ); ?>"
									class="dashicons dashicons-edit bbb-icon bbb_edit_recording_data"></i>
							<?php } ?>
						</div>
					<?php endif; ?>
					<div class="flex-row flex-row-<?php echo esc_attr($columns); ?>" role="cell">
						<?php echo esc_html( date_i18n( $date_format, (int) $recording->startTime / 1000 ) ); ?>
					</div>
					<div class="flex-row flex-row-<?php echo esc_attr($columns); ?>" role="cell">
						<div id="bbb-recording-links-block-<?php echo esc_attr($recording->recordID); ?>" class="bbb-recording-link-block" style="<?php echo ( $recording->published == 'false' ? 'display:none;' : '' ); ?>">
							<?php foreach ( $recording->playback->format as $format ) { ?>
								<?php
								if ( $format->type == $default_bbb_recording_format || $view_extended_recording_formats ) {
									$recording_url = trim( apply_filters( 'bbb_recording_url_display', $format->url, $format->type ) );
									?>
									<button class="bbb-button bbb-btn-join button button-primary" onclick="window.open('<?php echo esc_url( $recording_url ); ?>', '_blank')"><?php esc_html_e( 'View Recording', 'bigbluebutton' ); ?></button>
								<?php } ?>
							<?php } ?>
						</div>
					</div>
					<?php if ( $manage_bbb_recordings ) { ?>
						<div class="flex-row flex-row-<?php echo $columns; ?>" role="cell">
							<?php if ( isset( $recording->protected_icon_classes ) && isset( $recording->protected_icon_title ) ) { ?>
								<i data-record-id="<?php echo esc_attr( $recording->recordID ); ?>"
										data-meta-nonce="<?php echo esc_attr( $meta_nonce ); ?>"
										class="<?php echo esc_attr( $recording->protected_icon_classes ); ?>"
										title="<?php echo esc_attr( $recording->protected_icon_title ); ?>"
										aria-label="<?php echo esc_attr( $recording->protected_icon_title ); ?>"></i>
								&nbsp;
							<?php } ?>
							<i data-record-id="<?php echo esc_attr( $recording->recordID ); ?>"
									data-meta-nonce="<?php echo esc_attr( $meta_nonce ); ?>"
									class="<?php echo esc_attr( $recording->published_icon_classes ); ?>"
									title="<?php echo esc_attr( $recording->published_icon_title ); ?>"
									aria-label="<?php echo esc_attr( $recording->published_icon_title ); ?>"></i>
							&nbsp;
							<i data-record-id="<?php echo esc_attr( $recording->recordID ); ?>"
								data-meta-nonce="<?php echo esc_attr( $meta_nonce ); ?>"
								class="<?php echo esc_attr( $recording->trash_icon_classes ); ?>"
								title="<?php _ex( 'Trash', 'post status' ); ?>"
								aria-label="<?php _ex( 'Trash', 'post status' ); ?>"></i>
							&nbsp;
							<div class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)"
								data-value="<?php echo esc_url( $recording_url ); ?>">
								<span class="tooltiptext recording-url-tooltip"><?php esc_html_e( 'Share Recording URL', 'bigbluebutton' ); ?></span>
								<span class="<?php echo esc_attr( $recording->share_icon_classes ); ?>"></span>
							</div>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
</div>
