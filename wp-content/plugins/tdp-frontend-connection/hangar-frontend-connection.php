<?php
/*
Plugin Name: TDP Front-End Connection
Plugin URI: http://themesdepot.org
Description: Add a powerful frontend modal registration/login popup.
Version: 1.5
Author: ThemesDepot
Author URI: http://themesdepot.org
*/

	// Return our data saved in the database to load some things.
	$wpml_settings = get_option( 'tdp_connection_options' );

/**
 * Replaces the default wp_new_user_notification function of the core.
 *
 * Email login credentials to a newly-registered user.
 * A new user registration notification is also sent to admin email.
 *
 * @since 1.0.0
 * @access public
 * @return void
 */
function autodealer_new_user_notification( $user_id, $plaintext_pass ) {

	$user = get_userdata( $user_id );
	// The blogname option is escaped with esc_html on the way into the database in sanitize_option
	// we want to reverse this for the plain text arena of emails.
	$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

	/* == Send notification to the user now == */
	if ( empty( $plaintext_pass ) )
		return;

		$message  = sprintf( __( 'There are you account details on %s:', 'tdp-fec' ), $blogname ) . "\r\n\r\n";
		$message .= sprintf( __( 'Username: %s', 'tdp-fec' ), $user->user_login ) . "\r\n\r\n";
		$message .= sprintf( __( 'Password: %s', 'tdp-fec' ), $plaintext_pass ) . "\r\n";
		wp_mail( $user->user_email, sprintf( __( 'Your Account Details for %s', 'tdp-fec' ), $blogname ), $message );

}

	// Load our primary class.
	require_once( 'includes/class-wp-modal-login.php' );

	/**
	 * Create a helper function for adding our login goodness
	 * @param String $login_text  The text for the login link. Default 'Login'.
	 * @param String $logout_text The text for the logout link. Default 'Logout'.
	 * @param String $logout_url  The url to redirect to when users logout. Empty by default.
	 * @param Bool   $show_admin  The setting to display the link to the admin area when logged in.
	 * @return HTML
	 *
	 * @version 1.0
	 * @since 2.0
	 */
	function add_modal_login_button( $login_text = 'Login', $logout_text = 'Logout', $logout_url = '', $show_admin = true ) {
		global $wp_modal_login_class;

		// Make sure our class is really truly loaded.
		if ( isset( $wp_modal_login_class ) ) {
			echo $wp_modal_login_class->modal_login_btn( $login_text, $logout_text, $logout_url, $show_admin );
		} else {
			echo __( 'ERROR: WP Modal Login class not loaded.', 'tdp-fec' );
		}
	}

	function tdp_fep_load_textdomain()
	{
	    load_plugin_textdomain( 'tdp-fec', false, dirname( plugin_basename( __FILE__ ) ) . '/langs/' );
	}
	add_action( 'plugins_loaded', 'tdp_fep_load_textdomain' );



	// Load this shiz.
	if ( class_exists( 'Tdp_frontend_WP_Modal_Login' ) )
		$wp_modal_login_class = new Tdp_frontend_WP_Modal_Login;
