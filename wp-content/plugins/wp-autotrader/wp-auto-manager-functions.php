<?php
if ( ! function_exists( 'get_auto_listing_types' ) ) :
/**
 * Outputs a form to submit a new auto to the site from the frontend.
 *
 * @access public
 * @return array
 */
function get_auto_listing_types() {
	return get_terms( "vehicle_model", array(
		'orderby'       => 'name',
	    'order'         => 'ASC',
	    'parent'         => 0,
	    'hide_empty'    => false,
	) );
}
endif;

if ( ! function_exists( 'get_auto_listing_categories' ) ) :
/**
 * Outputs a form to submit a new auto to the site from the frontend.
 *
 * @access public
 * @return array
 */
function get_auto_listing_categories() {
	return get_terms( "auto_listing_category", array(
		'orderby'       => 'name',
	    'order'         => 'ASC',
	    'hide_empty'    => false,
	) );
}
endif;

if ( ! function_exists( 'get_auto_listing_fuels' ) ) :
/**
 * Outputs a form to submit a new auto to the site from the frontend.
 *
 * @access public
 * @return array
 */
function get_auto_listing_fuels() {
	return get_terms( "vehicle_fuel_type", array(
		'orderby'       => 'name',
	    'order'         => 'ASC',
	    'hide_empty'    => false,
	) );
}
endif;

if ( ! function_exists( 'get_auto_listing_color' ) ) :
/**
 * Outputs a form to submit a new auto to the site from the frontend.
 *
 * @access public
 * @return array
 */
function get_auto_listing_color() {
	return get_terms( "vehicle_color", array(
		'orderby'       => 'name',
	    'order'         => 'ASC',
	    'hide_empty'    => false,
	) );
}
endif;

if ( ! function_exists( 'get_auto_listing_status' ) ) :
/**
 * Outputs a form to submit a new auto to the site from the frontend.
 *
 * @access public
 * @return array
 */
function get_auto_listing_status() {
	return get_terms( "vehicle_status", array(
		'orderby'       => 'name',
	    'order'         => 'ASC',
	    'hide_empty'    => false,
	) );
}
endif;

if ( ! function_exists( 'get_auto_listing_gear' ) ) :
/**
 * Outputs a form to submit a new auto to the site from the frontend.
 *
 * @access public
 * @return array
 */
function get_auto_listing_gear() {
	return get_terms( "vehicle_gearbox", array(
		'orderby'       => 'name',
	    'order'         => 'ASC',
	    'hide_empty'    => false,
	) );
}
endif;

if ( ! function_exists( 'get_auto_listing_location' ) ) :
/**
 * Outputs a form to submit a new auto to the site from the frontend.
 *
 * @access public
 * @return array
 */
function get_auto_listing_location() {
	return get_terms( "vehicle_location", array(
		'orderby'       => 'name',
	    'order'         => 'ASC',
	    'hide_empty'    => false,
	) );
}
endif;

if ( ! function_exists( 'get_auto_listing_years' ) ) :
/**
 * Outputs a form to submit a new auto to the site from the frontend.
 *
 * @access public
 * @return array
 */
function get_auto_listing_years() {
	return get_terms( "vehicle_year", array(
		'orderby'       => 'name',
	    'order'         => 'ASC',
	    'hide_empty'    => false,
	) );
}
endif;

if ( ! function_exists( 'get_auto_listing_interior' ) ) :
/**
 * Outputs a form to submit a new auto to the site from the frontend.
 *
 * @access public
 * @return array
 */
function get_auto_listing_interior() {
	return get_terms( "vehicle_interior_feature", array(
		'orderby'       => 'name',
	    'order'         => 'ASC',
	    'hide_empty'    => false,
	) );
}
endif;

if ( ! function_exists( 'get_auto_listing_exterior' ) ) :
/**
 * Outputs a form to submit a new auto to the site from the frontend.
 *
 * @access public
 * @return array
 */
function get_auto_listing_exterior() {
	return get_terms( "vehicle_exterior_feature", array(
		'orderby'       => 'name',
	    'order'         => 'ASC',
	    'hide_empty'    => false,
	) );
}
endif;

if ( ! function_exists( 'get_auto_listing_safety' ) ) :
/**
 * Outputs a form to submit a new auto to the site from the frontend.
 *
 * @access public
 * @return array
 */
function get_auto_listing_safety() {
	return get_terms( "vehicle_safety_feature", array(
		'orderby'       => 'name',
	    'order'         => 'ASC',
	    'hide_empty'    => false,
	) );
}
endif;

if ( ! function_exists( 'get_auto_listing_extra' ) ) :
/**
 * Outputs a form to submit a new auto to the site from the frontend.
 *
 * @access public
 * @return array
 */
function get_auto_listing_extra() {
	return get_terms( "vehicle_extra", array(
		'orderby'       => 'name',
	    'order'         => 'ASC',
	    'hide_empty'    => false,
	) );
}
endif;

if ( ! function_exists( 'get_auto_set_type' ) ) :
/**
 * Outputs a form to submit a new auto to the site from the frontend.
 *
 * @access public
 * @return array
 */
function get_auto_set_type() {
	return get_terms( "vehicle_type", array(
		'orderby'       => 'name',
	    'order'         => 'ASC',
	    'hide_empty'    => false,
	) );
}
endif;

// retrieves the attachment ID from the file URL
function pn_get_attachment_id_from_url( $attachment_url = '' ) {
 
	global $wpdb;
	$attachment_id = false;
 
	// If there is no url, return.
	if ( '' == $attachment_url )
		return;
 
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
 
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
 
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
 
	}
 
	return $attachment_id;
}

if ( ! function_exists( 'auto_manager_create_account' ) ) :
/**
 * Handle account creation.
 *
 * @param  [type] $account_email
 * @return WP_error | bool was an account created?
 */
function wp_auto_manager_create_account( $account_email ) {
	global  $current_user;

	$user_email = apply_filters( 'user_registration_email', sanitize_email( $account_email ) );

	if ( empty( $user_email ) )
		return false;

	if ( ! is_email( $user_email ) )
		return new WP_Error( 'validation-error', __( 'Your email address isn&#8217;t correct.', 'auto_manager' ) );

	if ( email_exists( $user_email ) )
		return new WP_Error( 'validation-error', __( 'This email is already registered, please choose another one.', 'auto_manager' ) );

	// Email is good to go - use it to create a user name
	$username = sanitize_user( current( explode( '@', $user_email ) ) );
	$password = wp_generate_password();

	// Ensure username is unique
	$append     = 1;
	$o_username = $username;

	while( username_exists( $username ) ) {
		$username = $o_username . $append;
		$append ++;
	}

	// Final error check
	$reg_errors = new WP_Error();
	do_action( 'register_post', $username, $user_email, $reg_errors );
	$reg_errors = apply_filters( 'registration_errors', $reg_errors, $username, $user_email );

	if ( $reg_errors->get_error_code() )
		return $reg_errors;

	// Create account
	$new_user = array(
    	'user_login' => $username,
    	'user_pass'  => $password,
    	'user_email' => $user_email
    );

    $user_id = wp_insert_user( apply_filters( 'auto_manager_create_account_data', $new_user ) );

    if ( is_wp_error( $user_id ) )
    	return $user_id;

    // Notify
    wp_new_user_notification( $user_id, $password );

	// Login
    wp_set_auth_cookie( $user_id, true, is_ssl() );
    $current_user = get_user_by( 'id', $user_id );

    return true;
}
endif;