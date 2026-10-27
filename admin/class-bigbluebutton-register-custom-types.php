<?php
/**
 * Registration of necessary components for the plugin.
 *
 * @link       https://blindsidenetworks.com
 * @since      3.0.0
 *
 * @package    Bigbluebutton
 * @subpackage Bigbluebutton/admin
 */

/**
 * Registration of necessary components for the plugin.
 *
 * Registers rooms, room categories, and metaboxes for the rooms.
 *
 * @package    Bigbluebutton
 * @subpackage Bigbluebutton/admin
 * @author     Blindside Networks <contact@blindsidenetworks.com>
 */
class VCBBB_Register_Custom_Types {

	/**
	 * Register room as custom post.
	 *
	 * @since   3.0.0
	 */
	public function vcbbb_room_as_post_type() {
		$params = array(
			'public'          => true,
			'show_ui'         => true,
			'labels'          => array(
				'name'                     => __( 'BBB Rooms', 'video-conferencing-with-bbb' ),
				'add_new'                  => __( 'Add New', 'video-conferencing-with-bbb' ),
				'add_new_item'             => __( 'Add New Room', 'video-conferencing-with-bbb' ),
				'edit_item'                => __( 'Edit Room', 'video-conferencing-with-bbb' ),
				'new_item'                 => __( 'New Room', 'video-conferencing-with-bbb' ),
				'view_item'                => __( 'View Room', 'video-conferencing-with-bbb' ),
				'view_items'               => __( 'View Rooms', 'video-conferencing-with-bbb' ),
				'search_items'             => __( 'Search Rooms', 'video-conferencing-with-bbb' ),
				'not_found'                => __( 'No rooms found', 'video-conferencing-with-bbb' ),
				'not_found_in_trash'       => __( 'No rooms found in trash', 'video-conferencing-with-bbb' ),
				'all_items'                => __( 'All Rooms', 'video-conferencing-with-bbb' ),
				'archives'                 => __( 'Room Archives', 'video-conferencing-with-bbb' ),
				'attributes'               => __( 'Room Attributes', 'video-conferencing-with-bbb' ),
				'insert_into_item'         => __( 'Insert into room', 'video-conferencing-with-bbb' ),
				'uploaded_to_this_item'    => __( 'Uploaded to this room', 'video-conferencing-with-bbb' ),
				'filter_items_list'        => __( 'Filter rooms list', 'video-conferencing-with-bbb' ),
				'items_list_navigation'    => __( 'Rooms list navigation', 'video-conferencing-with-bbb' ),
				'items_list'               => __( 'Rooms list', 'video-conferencing-with-bbb' ),
				'item_published'           => __( 'Room published', 'video-conferencing-with-bbb' ),
				'item_published_privately' => __( 'Room published privately', 'video-conferencing-with-bbb' ),
				'item_reverted_to_draft'   => __( 'Room reverted to draft', 'video-conferencing-with-bbb' ),
				'item_scheduled'           => __( 'Room scheduled', 'video-conferencing-with-bbb' ),
				'item_updated'             => __( 'Room updated', 'video-conferencing-with-bbb' ),
			),
			'taxonomies'      => array( 'bbb-room-category' ),
			'capability_type' => 'bbb_room',
			'has_archive'     => true,
			'supports'        => array( 'title', 'editor' ),
			'rewrite'         => array( 'slug' => 'bbb-room' ),
			'show_in_menu'    => 'vcbbb_room',
			'map_meta_cap'    => true,
			//'query_var'       => true,
			// Enables block editing in the rooms editor.
			'show_in_rest'    => true,
			'supports'        => array( 'title', 'editor', 'author', 'thumbnail', 'permalink' ),
		);

		// Gate CPT creation on add_bbb_rooms (not do_not_allow). Pro frontend
		// may elevate this temporarily for allowlisted LMS/moderator roles.
		$params['capabilities'] = array(
			'create_posts' => 'add_bbb_rooms',
		);

		register_post_type(
			'bbb-room',
			$params
		);
	}

	/**
	 * Register category as custom taxonomy.
	 *
	 * @since   3.0.0
	 */
	public function vcbbb_room_category_as_taxonomy_type() {
		register_taxonomy(
			'bbb-room-category',
			array( 'bbb-room' ),
			array(
				'labels'       => array(
					'name'          => __( 'Categories', 'video-conferencing-with-bbb' ),
					'singular_name' => __( 'Category', 'video-conferencing-with-bbb' ),
				),
				'hierarchical' => true,
				'query_var'    => true,
				'show_in_ui'   => true,
				'show_in_menu' => 'vcbbb_room',
				'show_in_rest' => true,
			)
		);
	}

	/**
	 * Rewrite permalinks after post type is registered
	 * Credits: https://andrezrv.com/2014/08/12/efficiently-flush-rewrite-rules-plugin-activation/
	 * @since   3.0.0
	 */
	public function flush_rewrite_rules_maybe() {
		if ( get_option( 'ee_bb_flush_rewrite_rules_flag' ) ) {
			flush_rewrite_rules( false );
			delete_option( 'ee_bb_flush_rewrite_rules_flag' );
		}
	}

	/**
	 * Generate the default BBB Room
	 * @since   3.0.0
	 */
	public function default_bbb_room() {
		if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || EE_VCBBB_Helper::check_if_rest_or_json() ) {
			return;
		}

		if ( get_option( 'ee_bb_default_bbb_room' ) ) {
			return;
		}

		$home_room = array(
			'post_title'  => __( 'Home Room', 'video-conferencing-with-bbb' ),
			'post_status' => 'publish',
			'post_type'   => 'bbb-room',
			'menu_order'  => -1,
		);

		$room_id = wp_insert_post( $home_room );

		// Add room codes to postmeta data.
		update_post_meta( $room_id, 'bbb-room-moderator-code', VCBBB_Admin_Helper::generate_random_code() );
		update_post_meta( $room_id, 'bbb-room-viewer-code', VCBBB_Admin_Helper::generate_random_code() );
		update_post_meta( $room_id, 'bbb-room-meeting-id', sha1( home_url() . VCBBB_Admin_Helper::generate_random_code( 12 ) ) );

		// Update room recordable value.
		update_post_meta( $room_id, 'bbb-room-recordable', 'true' );
		//update_post_meta( $room_id, 'bbb-room-wait-for-moderator', ( $wait_for_mod ? 'true' : 'false' ) );

		update_option( 'ee_bb_default_bbb_room', intval( $room_id ), false );
	}

	/**
	 * Create moderator and Viewer Access Code metaboxes on room creation and edit.
	 *
	 * @since   3.0.0
	 */
	public function register_room_code_metaboxes() {
		/**
		 * Remove Custom Fields meta box
		 */
		remove_meta_box( 'postcustom', 'bbb-room', 'normal' );
		add_meta_box( 'bbb-moderator-code', __( 'Moderator Access Code', 'video-conferencing-with-bbb' ), array( $this, 'display_moderator_code_metabox' ), 'bbb-room' );
		add_meta_box( 'bbb-viewer-code', __( 'Viewer Access Code', 'video-conferencing-with-bbb' ), array( $this, 'display_viewer_code_metabox' ), 'bbb-room' );
	}

	/**
	 * Show recordable option in room creation to users who have the corresponding capability.
	 *
	 * @since   3.0.0
	 */
	public function register_record_room_metabox() {
		if ( current_user_can( 'create_recordable_bbb_room' ) ) {
			add_meta_box( 'bbb-room-recordable', __( 'Recordable', 'video-conferencing-with-bbb' ), array( $this, 'display_allow_record_metabox' ), 'bbb-room' );
		}
	}

	/**
	 * Show wait for moderator option in room creation.
	 *
	 * @since   3.0.0
	 */
	public function register_wait_for_moderator_metabox() {
		add_meta_box( 'bbb-room-wait-for-moderator', __( 'Wait for Moderator', 'video-conferencing-with-bbb' ), array( $this, 'display_wait_for_mod_metabox' ), 'bbb-room' );
	}

	/**
	 * Display Moderator Access Code metabox.
	 *
	 * @since   3.0.0
	 *
	 * @param   Object $object     The object that has the room ID.
	 */
	public function display_moderator_code_metabox( $object ) {
		$entry_code       = VCBBB_Admin_Helper::generate_random_code();
		$entry_code_label = __( 'Moderator Access Code', 'video-conferencing-with-bbb' );
		$entry_code_msg   = __( 'Note:', 'video-conferencing-with-bbb' );

		$entry_code_name = 'bbb-moderator-code';
		$existing_value  = get_post_meta( $object->ID, 'bbb-room-moderator-code', true );
		wp_nonce_field( 'bbb-room-moderator-code-nonce', 'bbb-room-moderator-code-nonce' );
		require 'partials/bigbluebutton-room-code-metabox-display.php';
	}

	/**
	 * Display Viewer Access Code metabox.
	 *
	 * @since   3.0.0
	 *
	 * @param   Object $object     The object that has the room ID.
	 */
	public function display_viewer_code_metabox( $object ) {
		$entry_code       = VCBBB_Admin_Helper::generate_random_code();
		$entry_code_label = __( 'Viewer Access Code', 'video-conferencing-with-bbb' );
		$entry_code_msg   = __( 'Note:', 'video-conferencing-with-bbb' );
		$entry_code_name  = 'bbb-viewer-code';
		$existing_value   = get_post_meta( $object->ID, 'bbb-room-viewer-code', true );
		wp_nonce_field( 'bbb-room-viewer-code-nonce', 'bbb-room-viewer-code-nonce' );
		require 'partials/bigbluebutton-room-code-metabox-display.php';
	}

	/**
	 * Display wait for moderator metabox.
	 *
	 * @since   3.0.0
	 *
	 * @param   Object $object     The object that has the room ID.
	 */
	public function display_wait_for_mod_metabox( $object ) {
		$existing_value = get_post_meta( $object->ID, 'bbb-room-wait-for-moderator', true );
		wp_nonce_field( 'bbb-room-wait-for-moderator-nonce', 'bbb-room-wait-for-moderator-nonce' );
		require 'partials/bigbluebutton-wait-for-mod-metabox-display.php';
	}

	/**
	 * Display recordable metabox.
	 *
	 * @since   3.0.0
	 *
	 * @param   Object $object     The object that has the room ID.
	 */
	public function display_allow_record_metabox( $object ) {
		$existing_value = get_post_meta( $object->ID, 'bbb-room-recordable', true );

		wp_nonce_field( 'bbb-room-recordable-nonce', 'bbb-room-recordable-nonce' );
		require 'partials/bigbluebutton-recordable-metabox-display.php';
	}
}
