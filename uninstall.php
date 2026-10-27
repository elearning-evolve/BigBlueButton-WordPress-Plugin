<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://blindsidenetworks.com
 * @since      3.0.0
 *
 * @package    Bigbluebutton
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

if ( ! class_exists( 'VCBBB_Uninstall' ) ) {
	class VCBBB_Uninstall {

		/**
		 * Remove all capabilities associated with this plugin.
		 *
		 * Remove capabilities for creating/editing/viewing rooms and joining as moderator/viewer.
		 *
		 * @since    3.0.0
		 */
		public static function uninstall() {
			if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
				exit;
			}

			self::trash_rooms_and_categories();
			self::delete_capabilities();
			self::remove_options();
		}

		/**
		 * Remove all rooms and custom types.
		 *
		 * @since 3.0.0
		 */
		private static function trash_rooms_and_categories() {
			global $wpdb;
			$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->postmeta} WHERE post_id IN (SELECT ID FROM {$wpdb->posts} WHERE post_type = %s)", 'bbb-room' ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Uninstall cleanup.
			$wpdb->query( "DELETE FROM {$wpdb->term_relationships} WHERE term_taxonomy_id IN (SELECT term_taxonomy_id FROM {$wpdb->term_taxonomy} WHERE taxonomy = 'bbb-room-category')" ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Uninstall cleanup.
			$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->posts} WHERE post_type = %s", 'bbb-room' ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Uninstall cleanup.
			$wpdb->query( "DELETE FROM {$wpdb->term_taxonomy} WHERE taxonomy = 'bbb-room-category'" ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Uninstall cleanup.
		}

		/**
		 * Delete all capabilitie sassociated with this plugin.
		 *
		 * @since 3.0.0
		 */
		private static function delete_capabilities() {
			$rooms               = get_post_type_object( 'bbb-room' );
			$custom_capabilities = array(
				'join_as_moderator_bbb_room',
				'join_as_viewer_bbb_room',
				'join_with_access_code_bbb_room',
				'create_recordable_bbb_room',
				'manage_bbb_room_recordings',
				'view_extended_bbb_room_recording_formats',
				'add_bbb_rooms',
				'can_limit_user_in_bbb_rooms',
			);

			if ( empty( $rooms ) ) {
				$room_capabilities = array(
					'edit_bbb_room',
					'read_bbb_room',
					'delete_bbb_room',
					'edit_bbb_rooms',
					'edit_others_bbb_rooms',
					'publish_bbb_rooms',
					'read_private_bbb_rooms',
					'delete_bbb_rooms',
					'delete_private_bbb_rooms',
					'delete_published_bbb_rooms',
					'delete_others_bbb_rooms',
					'edit_private_bbb_rooms',
					'edit_published_bbb_rooms',
				);
			} elseif ( property_exists( $rooms, 'cap' ) ) {
				$room_capabilities = array_values( get_object_vars( $rooms->cap ) );
			} else {
				$room_capabilities = [];
			}

			$capabilities = array_merge( $room_capabilities, $custom_capabilities );
			$roles        = get_editable_roles();
			$role_names   = array_keys( $roles );

			foreach ( $role_names as $name ) {
				$role = get_role( $name );

				foreach ( $capabilities as $cap ) {
					if ( strpos( $cap, 'bbb_room' ) === false ) {
						continue;
					}
					if ( $role->has_cap( $cap ) ) {
						$role->remove_cap( $cap );
					}
				}
			}
		}

		/**
		 * Remove bigbluebutton specific options.
		 *
		 * @since 3.0.0
		 */
		private static function remove_options() {
			delete_option( 'vcbbb_url' );
			delete_option( 'vcbbb_salt' );
			delete_option( 'bigbluebutton_url' );
			delete_option( 'bigbluebutton_salt' );
			delete_option( 'bigbluebutton_plugin_version' );
			delete_option( 'vcbbb_default_roles_set' );
			delete_option( 'bigbluebutton_default_roles_set' );
			delete_option( 'video_conf_with_bbb_version' );
			delete_option( 'vcbbb_migrated_bn_test_server' );
			delete_option( 'vcbbb_migrated_legacy_default_server' );
			delete_option( 'ee_bb_default_bbb_room' );
			delete_option( 'bbb_flush_incorrect_caps_once' );
		}
	}
}
VCBBB_Uninstall::uninstall();
