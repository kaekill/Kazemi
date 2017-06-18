<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WP_Auto_Manager_Admin class.
 */
class WP_Auto_Manager_Admin {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		include_once( 'class-wp-auto-manager-cpt.php' );
		//include_once( 'class-wp-auto-manager-settings.php' );
		include_once( 'class-wp-auto-manager-writepanels.php' );

		//$this->settings_page = new WP_Auto_Manager_Settings();

		//add_action( 'admin_menu', array( $this, 'admin_menu' ), 12 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}

	/**
	 * admin_enqueue_scripts function.
	 *
	 * @access public
	 * @return void
	 */
	public function admin_enqueue_scripts() {
		global $auto_manager, $wp_scripts;

		$jquery_version = isset( $wp_scripts->registered['jquery-ui-core']->ver ) ? $wp_scripts->registered['jquery-ui-core']->ver : '1.9.2';

		wp_enqueue_style( 'jquery-ui-style', '//ajax.googleapis.com/ajax/libs/jqueryui/' . $jquery_version . '/themes/smoothness/jquery-ui.css' );
		wp_enqueue_style( 'auto_manager_admin_menu_css', AUTO_MANAGER_PLUGIN_URL . '/assets/css/menu.css' );
		wp_enqueue_style( 'auto_manager_admin_css', AUTO_MANAGER_PLUGIN_URL . '/assets/css/admin.css' );
		wp_register_script( 'jquery-tiptip', AUTO_MANAGER_PLUGIN_URL. '/assets/js/jquery-tiptip/jquery.tipTip.min.js', array( 'jquery' ), AUTO_MANAGER_VERSION, true );
		wp_enqueue_script( 'auto_manager_admin_js', AUTO_MANAGER_PLUGIN_URL. '/assets/js/admin.min.js', array( 'jquery', 'jquery-tiptip', 'jquery-ui-datepicker' ), AUTO_MANAGER_VERSION, true );
	}

	/**
	 * admin_menu function.
	 *
	 * @access public
	 * @return void
	 */
	public function admin_menu() {
		add_submenu_page( 'edit.php?post_type=vehicles', __( 'Settings', 'auto_manager' ), __( 'Settings', 'auto_manager' ), 'manage_options', 'auto-manager-settings', array( $this->settings_page, 'output' ) );
	}

}

new WP_Auto_Manager_Admin();