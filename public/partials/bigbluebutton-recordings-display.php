<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}
?>
<div id="bbb-recordings-list-<?php echo esc_attr( $room_id ); ?>">
	<?php if ( empty( $recordings ) ) { ?>
		<p id="bbb-no-recordings-msg" class="bbb-no-recordings-msg"><?php esc_html_e( 'This room does not currently have any recordings.', 'video-conferencing-with-bbb' ); ?></p>
	<?php } else { ?>
		<p id="bbb-no-recordings-msg" class="bbb-no-recordings-msg is-hidden"><?php esc_html_e( 'This room does not currently have any recordings.', 'video-conferencing-with-bbb' ); ?></p>
		<div id="bbb-recordings-table" class="bbb-table-container vcbbb-table-container" role="table">
			<div class="bbb-flex-table vcbbb-flex-table vcbbb-flex-table-<?php echo esc_attr( $columns ); ?> bbb-header vcbbb-header" role="rowgroup">
				<a href="<?php echo esc_url( $sort_fields['name']->url ); ?>" class="flex-row flex-row-<?php echo esc_attr( $columns ); ?> <?php echo esc_html( $sort_fields['name']->header_classes ); ?>" role="columnheader">
					<?php esc_html_e( 'Recording', 'video-conferencing-with-bbb' ); ?>
					<i class="<?php echo esc_attr( $sort_fields['name']->classes ); ?>"></i>
				</a>
				<?php if ( $recording_description_exist ) : ?>
				<a href="<?php echo esc_url( $sort_fields['description']->url ); ?>" class="flex-row flex-row-<?php echo esc_attr( $columns ); ?> <?php echo esc_html( $sort_fields['description']->header_classes ); ?>" role="columnheader">
					<?php esc_html_e( 'Description', 'video-conferencing-with-bbb' ); ?>
					<i class="<?php echo esc_attr( $sort_fields['description']->classes ); ?>"></i>
				</a>
				<?php endif; ?>
				<a href="<?php echo esc_url( $sort_fields['date']->url ); ?>" class="flex-row flex-row-<?php echo esc_attr( $columns ); ?> <?php echo esc_html( $sort_fields['date']->header_classes ); ?>" role="columnheader">
					<?php esc_html_e( 'Date', 'video-conferencing-with-bbb' ); ?>
					<i class="<?php echo esc_attr( $sort_fields['date']->classes ); ?>"></i>
				</a>
				<div class="flex-row flex-row-<?php echo esc_attr( $columns ); ?>" role="columnheader"><?php esc_html_e( 'Action', 'video-conferencing-with-bbb' ); ?></div>
				<?php if ( $manage_bbb_recordings ) { ?>
					<div class="flex-row flex-row-<?php echo esc_attr( $columns ); ?>" role="columnheader">
						<?php esc_html_e( 'Manage', 'video-conferencing-with-bbb' ); ?>
					</div>
				<?php } ?>
			</div>
			<?php foreach ( $recordings as $vcbbb_recording ) { ?>
				<div id="bbb-recording-<?php echo esc_attr( $vcbbb_recording->recordID ); ?>" class="bbb-flex-table vcbbb-flex-table vcbbb-flex-table-<?php echo esc_attr( $columns ); ?> bbb-recording-row" role="rowgroup">
					<div id="bbb-recording-name-<?php echo esc_attr( $vcbbb_recording->recordID ); ?>" class="flex-row flex-row-<?php echo esc_attr( $columns ); ?>" role="cell">
						<?php echo esc_html( urldecode( $vcbbb_recording->metadata->{'recording-name'} ) ); ?>
						<?php if ( $manage_bbb_recordings ) { ?>
							<i id="edit-recording-name-<?php echo esc_attr( $vcbbb_recording->recordID ); ?>"
								title="<?php esc_html_e( 'Edit', 'video-conferencing-with-bbb' ); ?>"
								aria-label="<?php esc_html_e( 'Edit', 'video-conferencing-with-bbb' ); ?>"
								data-record-id="<?php echo esc_attr( $vcbbb_recording->recordID ); ?>"
								data-record-value="<?php echo esc_attr( urldecode( $vcbbb_recording->metadata->{'recording-name'} ) ); ?>"
								data-record-type="name"
								data-meta-nonce="<?php echo esc_attr( $meta_nonce ); ?>"
								class="dashicons dashicons-edit vcbbb-icon vcbbb_edit_recording_data"></i>
						<?php } ?>
					</div>
					<?php if ( $recording_description_exist ) : ?>
						<div id="bbb-recording-description-<?php echo esc_attr( $vcbbb_recording->recordID ); ?>" class="flex-row flex-row-<?php echo esc_attr( $columns ); ?>" role="cell">
							<?php echo esc_html( urldecode( $vcbbb_recording->metadata->{'recording-description'} ) ); ?>
							<?php if ( $manage_bbb_recordings ) { ?>
								<i id="edit-recording-description-<?php echo esc_attr( $vcbbb_recording->recordID ); ?>"
									title="<?php esc_html_e( 'Edit', 'video-conferencing-with-bbb' ); ?>"
									aria-label="<?php esc_html_e( 'Edit', 'video-conferencing-with-bbb' ); ?>"
									data-record-id="<?php echo esc_attr( $vcbbb_recording->recordID ); ?>"
									data-record-value="<?php echo esc_attr( urldecode( $vcbbb_recording->metadata->{'recording-description'} ) ); ?>"
									data-record-type="description"
									data-meta-nonce="<?php echo esc_attr( $meta_nonce ); ?>"
									class="dashicons dashicons-edit vcbbb-icon vcbbb_edit_recording_data"></i>
							<?php } ?>
						</div>
					<?php endif; ?>
					<div class="flex-row flex-row-<?php echo esc_attr( $columns ); ?>" role="cell">
					<?php echo esc_html( date_i18n( $date_format, (int) ( $vcbbb_recording->startTime / 1000 ) ) ); ?>
					</div>
					<?php
						$vcbbb_recording_url = '';
						$vcbbb_formats       = isset( $vcbbb_recording->playback->format ) ? ( is_array( $vcbbb_recording->playback->format ) ? $vcbbb_recording->playback->format : array( $vcbbb_recording->playback->format ) ) : array();
						foreach ( $vcbbb_formats as $vcbbb_format ) {
							if ( ( isset( $vcbbb_format->type ) && ( (string) $vcbbb_format->type == $default_bbb_recording_format || $view_extended_recording_formats ) ) && isset( $vcbbb_format->url ) ) {
								$vcbbb_recording_url = trim( apply_filters( 'vcbbb_recording_url_display', (string) $vcbbb_format->url, isset( $vcbbb_format->type ) ? (string) $vcbbb_format->type : '' ) );
								$vcbbb_recording_url = VCBBB_Api::normalize_recording_playback_url( $vcbbb_recording_url );
								break;
							}
						}
					?>
					<div class="flex-row flex-row-<?php echo esc_attr( $columns ); ?>" role="cell">
						<div id="bbb-recording-links-block-<?php echo esc_attr( $vcbbb_recording->recordID ); ?>" class="bbb-recording-link-block" style="<?php echo ( $vcbbb_recording->published == 'false' ? 'display:none;' : '' ); ?>">
							<?php if ( ! empty( $vcbbb_recording_url ) ) : ?>
								<button type="button" class="bbb-button bbb-btn-join vcbbb-button vcbbb-btn-join vcbbb-view-recording button button-primary" onclick="window.open('<?php echo esc_url( $vcbbb_recording_url ); ?>', '_blank')"><?php esc_html_e( 'View Recording', 'video-conferencing-with-bbb' ); ?></button>
							<?php endif; ?>
						</div>
					</div>
					<?php if ( $manage_bbb_recordings ) { ?>
						<div class="flex-row flex-row-<?php echo esc_attr( $columns ); ?>" role="cell">
							<?php if ( isset( $vcbbb_recording->protected_icon_classes ) && isset( $vcbbb_recording->protected_icon_title ) ) { ?>
								<i data-record-id="<?php echo esc_attr( $vcbbb_recording->recordID ); ?>"
										data-meta-nonce="<?php echo esc_attr( $meta_nonce ); ?>"
										class="<?php echo esc_attr( $vcbbb_recording->protected_icon_classes ); ?>"
										title="<?php echo esc_attr( $vcbbb_recording->protected_icon_title ); ?>"
										aria-label="<?php echo esc_attr( $vcbbb_recording->protected_icon_title ); ?>"></i>
								&nbsp;
							<?php } ?>
							<i data-record-id="<?php echo esc_attr( $vcbbb_recording->recordID ); ?>"
									data-meta-nonce="<?php echo esc_attr( $meta_nonce ); ?>"
									class="<?php echo esc_attr( $vcbbb_recording->published_icon_classes ); ?>"
									title="<?php echo esc_attr( $vcbbb_recording->published_icon_title ); ?>"
									aria-label="<?php echo esc_attr( $vcbbb_recording->published_icon_title ); ?>"></i>
							&nbsp;
							<i data-record-id="<?php echo esc_attr( $vcbbb_recording->recordID ); ?>"
								data-meta-nonce="<?php echo esc_attr( $meta_nonce ); ?>"
								class="<?php echo esc_attr( $vcbbb_recording->trash_icon_classes ); ?>"
								title="<?php echo esc_attr_x( 'Trash', 'post status', 'video-conferencing-with-bbb' ); ?>"
                                aria-label="<?php echo esc_attr_x( 'Trash', 'post status', 'video-conferencing-with-bbb' ); ?>"></i>
							&nbsp;
							<span class="tooltip" onclick="copyToClipboard(this)" onmouseout="copyClipboardExit(this)"
								data-value="<?php echo esc_url( $vcbbb_recording_url ); ?>">
								<span class="tooltiptext recording-url-tooltip"><?php esc_html_e( 'Share Recording URL', 'video-conferencing-with-bbb' ); ?></span>
								<span class="<?php echo esc_attr( $vcbbb_recording->share_icon_classes ); ?>"></span>
							</span>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
</div>
