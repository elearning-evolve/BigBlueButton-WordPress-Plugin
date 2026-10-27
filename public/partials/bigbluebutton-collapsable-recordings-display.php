<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access' );
}
?>
<div class="bbb-recording-display-block">
	<div id="bbb-recordings-display-<?php echo esc_attr( $room_id ); ?>" class="bbb-recordings-display">
		<i class="dashicons dashicons-arrow-down-alt2"></i>
		<p class="bbb-expandable-header"><?php esc_html_e( 'Collapse recordings', 'video-conferencing-with-bbb' ); ?></p>
	</div>
	<?php
	$vcbbb_allowed_recordings_html = array(
		'div'    => array(
			'id'    => true,
			'class' => true,
			'style' => true,
			'role'  => true,
		),
		'a'      => array(
			'href'  => true,
			'class' => true,
			'role'  => true,
		),
		'span'   => array(
			'class'          => true,
			'data-value'     => true,
			'onclick'        => true,
			'onmouseout'     => true,
			'aria-label'     => true,
			'title'          => true,
		),
		'i'      => array(
			'class'             => true,
			'title'             => true,
			'aria-label'        => true,
			'data-record-id'    => true,
			'data-record-value' => true,
			'data-record-type'  => true,
			'data-meta-nonce'   => true,
			'id'                => true,
		),
		'button' => array(
			'class'   => true,
			'onclick' => true,
		),
		'input'  => array(
			'type'     => true,
			'value'    => true,
			'class'    => true,
			'id'       => true,
			'disabled' => true,
		),
		'p'      => array(
			'class' => true,
			'id'    => true,
			'style' => true,
		),
		'label'  => array(
			'id'    => true,
			'class' => true,
		),
	);
	echo wp_kses( $html_recordings, $vcbbb_allowed_recordings_html );
	?>
</div>
