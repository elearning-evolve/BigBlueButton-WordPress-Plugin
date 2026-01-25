<?php
/**
 * Fired during plugin activation
 *
 * @link       https://blindsidenetworks.com
 * @since      3.0.0
 *
 * @package    Bigbluebutton
 * @subpackage Bigbluebutton/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      3.0.0
 * @package    Bigbluebutton
 * @subpackage Bigbluebutton/includes
 * @author     Blindside Networks <contact@blindsidenetworks.com>
 */
class Bigbluebutton_Activator {

	/**
	 * Set default capabilities for roles.
	 *
	 * By default, only administrators and authors can create, edit, and delete rooms.
	 * Only administrators and owners can enter a meeting as a moderator. Everyone else enters as a viewer.
	 *
	 * @since    3.0.0
	 */
	public static function activate() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		if ( ! get_option( 'ee_bb_flush_rewrite_rules_flag' ) ) {
			add_option( 'ee_bb_flush_rewrite_rules_flag', true, '', 'no' );
		}
		
		// Create the default BBB room on plugin activate
		$plugin_admin_register_custom_types = new Bigbluebutton_Register_Custom_Types();
		$plugin_admin_register_custom_types->default_bbb_room();
	}

	public static function admin_init() {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			$blogs = get_sites();
			foreach ( $blogs as $blog ) {
				switch_to_blog( $blog->blog_id );
				self::set_default_roles();
				restore_current_blog();
			}
		} else {
			self::set_default_roles();
		}
	}

	/**
	 * Set default capabilities for rooms.
	 *
	 * Recurse through each role and assign default capabilities involving rooms, how to enter rooms, and recordings.
	 *
	 * @since   3.0.0
	 */
	public static function set_default_roles() {
		$version          = get_option( 'video_conf_with_bbb_version' );
		$are_defaults_set = get_option( 'bigbluebutton_default_roles_set' );

		// If permissions already set or the version updated check passed
		if ( true == $are_defaults_set && VIDEO_CONF_WITH_BBB_VERSION === $version ) {
			return;
		}

		if ( get_role( 'anonymous' ) === null ) {
			add_role(
				'anonymous',
				__( 'Anonymous' ),
				array(
					'read' => true,
				)
			);
		}
		$roles      = get_editable_roles();
		$role_names = array_keys( $roles );

		self::set_default_capabilities_for_each_role( $role_names );
		update_option( 'bigbluebutton_default_roles_set', true, false );
		update_option( 'video_conf_with_bbb_version', VIDEO_CONF_WITH_BBB_VERSION, false );
		update_option( 'bbb_flush_incorrect_caps_once', 1, false );
	}

	/**
	 * Loop through each role and set default capabilities.
	 *
	 * @since  3.0.0
	 *
	 * @param  Array $role_names     List of role names.
	 */
	private static function set_default_capabilities_for_each_role( $role_names ) {
		foreach ( $role_names as $name ) {
			self::set_default_capability_for_one_role( $name );
		}
	}

	/**
	 * Set default capability for one role.
	 *
	 * @since  3.0.0
	 *
	 * @param  String $name    Role name to set capability for.
	 */
	private static function set_default_capability_for_one_role( $name ) {
		global $wp_roles;
		$all_roles    = array_keys( $wp_roles->roles );
		$role         = get_role( $name );
		$set_join_cap = self::join_permissions_set( $role );
		$role->add_cap( 'read_bbb_room' );
		$admin_cap = false;

		// flush admin capabilities incorrectly set for other roles in v1.2.1
		if ( ! get_option( 'bbb_flush_incorrect_caps_once' ) ) {
			self::flush_incorrect_caps_once( $role );
		}

		if ( $role->has_cap( 'activate_plugins' ) ) {
			$admin_cap = true;
			self::set_admin_capability( $role );
		}

		if ( 'administrator' == $name ) {
			$admin_cap = true;
			self::set_admin_capability( $role );
			$role->add_cap( 'join_as_moderator_bbb_room' );
			return;
		}
		if ( 'author' == $name ) {
			self::set_edit_room_capability( $role );
		}

		// Assign viewer access to all WP roles @1.5.0
		if ( ! $admin_cap && in_array( $name, $all_roles ) && $name != 'anonymous' ) {
			//if ( 'author' == $name || 'editor' == $name || 'contributor' == $name || 'subscriber' == $name ) {
			$role->add_cap( 'join_as_viewer_bbb_room' );
			return;
		}

		if ( ! $set_join_cap ) {
			$role->add_cap( 'join_with_access_code_bbb_room' );
		}
	}

	/**
	 * Set default capability for admin.
	 *
	 * @since  3.0.0
	 *
	 * @param  Object $role The role object to set capabilties for.
	 */
	private static function set_admin_capability( $role ) {
		self::set_edit_room_capability( $role );
		$role->add_cap( 'add_bbb_rooms' );
		$role->add_cap( 'edit_others_bbb_rooms' );
		$role->add_cap( 'delete_others_bbb_rooms' );
		$role->add_cap( 'create_recordable_bbb_room' );
		$role->add_cap( 'manage_bbb_room_recordings' );
		$role->add_cap( 'can_limit_user_in_bbb_rooms' );
		$role->add_cap( 'view_extended_bbb_room_recording_formats' );
	}

	/**
	 * Set admin's extensive capabilities.
	 *
	 * @since  3.0.0
	 *
	 * @param  Role $role The role object to set capabilties for.
	 */
	private static function set_edit_room_capability( $role ) {
		$role->add_cap( 'edit_bbb_rooms' );
		$role->add_cap( 'edit_published_bbb_rooms' );
		$role->add_cap( 'delete_bbb_rooms' );
		$role->add_cap( 'delete_published_bbb_rooms' );
		$role->add_cap( 'publish_bbb_rooms' );
		if ( ! $role->has_cap( 'manage_categories' ) ) {
			$role->add_cap( 'manage_categories' );
		}
	}

	/**
	 * Check if the role already has join room permissions set, from migration.
	 *
	 * @param  Object $role       The role object to check join room permissions.
	 * @return Boolean true|false  The boolean value of whether the role already has join room permissions set.
	 */
	private static function join_permissions_set( $role ) {
		if ( $role->has_cap( 'join_as_moderator_bbb_room' ) || $role->has_cap( 'join_as_viewer_bbb_room' ) ) {
			return true;
		}
		return false;
	}

	/**
	 * flush admin and editor caps set incorrectly for other user roles in v1.2.1 update
	 *
	 */
	private static function flush_incorrect_caps_once( $role ) {
		$role->remove_cap( 'add_bbb_rooms' );
		$role->remove_cap( 'read_private_bbb_rooms' );
		$role->remove_cap( 'edit_others_bbb_rooms' );
		$role->remove_cap( 'edit_private_bbb_rooms' );
		$role->remove_cap( 'delete_others_bbb_rooms' );
		$role->remove_cap( 'delete_private_bbb_rooms' );
		$role->remove_cap( 'create_recordable_bbb_room' );
		$role->remove_cap( 'manage_bbb_room_recordings' );
		$role->remove_cap( 'can_limit_user_in_bbb_rooms' );
		$role->remove_cap( 'view_extended_bbb_room_recording_formats' );
		$role->remove_cap( 'edit_bbb_rooms' );
		$role->remove_cap( 'edit_published_bbb_rooms' );
		$role->remove_cap( 'delete_bbb_rooms' );
		$role->remove_cap( 'delete_published_bbb_rooms' );
		$role->remove_cap( 'publish_bbb_rooms' );
		if ( ! $role->has_cap( 'manage_categories' ) ) {
			$role->remove_cap( 'manage_categories' );
		}
	}
}
