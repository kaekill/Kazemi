<?php
/*
Plugin Name: Hangar
Plugin URI: http://themesdepot.org
Description: Hangar is a powerful collection of features to enhance your website. This plugin is compatible only if you are using a ThemesDepot theme.
Version: 1.3
Author: ThemesDepot
Author URI: http://themesdepot.org/
License: 
*/	

/**
* Check for framework and load components
*
* @since 1.1.0
*/
function tdp_supported_components2(){

	/**
	 * Display warning telling the user they must have a
	 * theme with TDP Framework 2.4+ installed in
	 * order to run this plugin.
	 *
	 * @since 1.2.0
	 */
	function tdp_notheme_warning() {
		global $current_user;
		// DEBUG: delete_user_meta( $current_user->ID, 'tdp_notheme' )
		if( ! get_user_meta( $current_user->ID, 'tdp_notheme' ) ){
			echo '<div class="updated">';
			echo '<p>'.__( 'You currently have the "Hangar Toolkit" plugin activated, however you are not using a theme from ThemesDepot, and so this plugin will not be compatible with this theme.', 'tdp_notheme' ).'</p>';
			echo '<p><a href="'.tdp_notheme_disable_url('tdp_notheme').'">'.__('Dismiss this notice', 'tdp_notheme').'</a> | <a href="http://www.themesdepot.org" target="_blank">'.__('Visit ThemesDepot.org', 'tdp_notheme').'</a></p>';
			echo '</div>';
		}
	}

	/**
	 * Dismiss an admin notice.
	 *
	 * @since 1.2.0
	 */
	function tdp_notheme_disable_nag() {
		global $current_user;
	    if ( isset( $_GET['tdp_nag_ignore'] ) )
	         add_user_meta( $current_user->ID, $_GET['tdp_nag_ignore'], 'true', true );
	}

	/**
	 * Disable admin notice URL.
	 *
	 * @since 1.2.0
	 */
	function tdp_notheme_disable_url( $id ) {

		global $pagenow;

		$url = admin_url( $pagenow );

		if( ! empty( $_SERVER['QUERY_STRING'] ) )
			$url .= sprintf( '?%s&tdp_nag_ignore=%s', $_SERVER['QUERY_STRING'], $id );
		else
			$url .= sprintf( '?tdp_nag_ignore=%s', $id );

		return $url;
	}

	/**
	 * Check if framework is available.
	 *
	 * @since 1.2.0
	 */
	if( ! defined( 'TDP_FRAMEWORK_VERSION' ) ) {
		add_action( 'admin_notices', 'tdp_notheme_warning' );
		add_action( 'admin_init', 'tdp_notheme_disable_nag' );
		return;
	}

	//load pointers
	require_once('supported/class.pointers.php');

	if(current_theme_supports( 'tdp_autotrader' ) ) {
		require_once( 'supported/autotrader.php' );
	}


}
add_action('after_setup_theme', 'tdp_supported_components2');

?>