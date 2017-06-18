<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WP_Auto_Manager_Install
 */
class WP_Auto_Manager_Install {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		$this->init_user_roles();
		$this->default_meta();
		$this->cron();
		delete_transient( 'wp_auto_manager_addons_html' );
		update_option( 'wp_auto_manager_version', AUTO_MANAGER_VERSION );
	}

	/**
	 * Init user roles
	 *
	 * @access public
	 * @return void
	 */
	public function init_user_roles() {
		global $wp_roles;

		if ( class_exists( 'WP_Roles' ) && ! isset( $wp_roles ) )
			$wp_roles = new WP_Roles();

		if ( is_object( $wp_roles ) ) {
			$wp_roles->add_cap( 'administrator', 'manage_auto_listings' );
		}
	}

	/**
	 * Add default meta values for all posts
	 */
	public function default_meta() {
		$autos = get_posts( array(
			'post_type'      => 'vehicles',
			'posts_per_page' => -1,
			'fields'         => 'ids'
		) );

		foreach ( $autos as $auto ) {
			add_post_meta( $auto, '_featured', 0, true );
		}
	}

	/**
	 * Setup cron autos
	 */
	public function cron() {
		wp_clear_scheduled_hook( 'auto_manager_check_for_expired_autos' );
		wp_schedule_event( time(), 'hourly', 'auto_manager_check_for_expired_autos' );
	}
}

new WP_Auto_Manager_Install();