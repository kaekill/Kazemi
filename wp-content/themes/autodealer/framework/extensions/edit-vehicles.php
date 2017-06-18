<?php
/**
 * Hide Option on frontend.
 */
function tdp_hide_fields_on_frontend( $field ){     
    $url = get_field('edit_vehicle_page','option');
    $postid = url_to_postid( $url );
    if(!is_admin() && is_page( $postid ) ) {
    	$field = null;
    }
    return $field;
}
add_filter('acf/load_field/name=set_vehicle_as_featured', 'tdp_hide_fields_on_frontend');

/**
 * Hide Option on backend.
 */
function tdp_hide_fields_on_backend( $field ){     
    if(is_admin()) {
    	$field = null;
    }
    return $field;
}
add_filter('acf/load_field/name=listing_title', 'tdp_hide_fields_on_backend');
add_filter('acf/load_field/name=listing_description', 'tdp_hide_fields_on_backend');
add_filter('acf/load_field/key=field_5284d114becls', 'tdp_hide_fields_on_backend');
add_filter('acf/load_field/name=select_vehicle_model_manufacturer', 'tdp_hide_fields_on_backend');
add_filter('acf/load_field/name=vehicle_type', 'tdp_hide_fields_on_backend');
add_filter('acf/load_field/name=vehicle_fuel_type', 'tdp_hide_fields_on_backend');
add_filter('acf/load_field/name=select_vehicle_color', 'tdp_hide_fields_on_backend');
add_filter('acf/load_field/name=select_vehicle_status', 'tdp_hide_fields_on_backend');
add_filter('acf/load_field/name=select_vehicle_gearbox', 'tdp_hide_fields_on_backend');
add_filter('acf/load_field/name=select_vehicle_interior_features', 'tdp_hide_fields_on_backend');
add_filter('acf/load_field/name=select_vehicle_exterior_features', 'tdp_hide_fields_on_backend');
add_filter('acf/load_field/name=select_vehicle_safety_features', 'tdp_hide_fields_on_backend');
add_filter('acf/load_field/name=select_vehicle_extra_features', 'tdp_hide_fields_on_backend');
add_filter('acf/load_field/name=select_vehicle_location', 'tdp_hide_fields_on_backend');
add_filter('acf/load_field/name=select_vehicle_age', 'tdp_hide_fields_on_backend');
add_filter('acf/load_field/name=select_vehicle_age', 'tdp_hide_fields_on_backend');
add_filter('acf/load_field/name=vehicle_featured_image', 'tdp_hide_fields_on_backend');

/**
 * Load vehicle title.
 */
function tdp_vehicle_load_title( $value, $post_id, $field )
{	

	$vehicle_id = null;
	if(isset($_GET['pid'])) {
		$vehicle_id = $_GET['pid'];
	}

    // run the_content filter on all textarea values
    $value = get_the_title($vehicle_id);
 
    return $value;
}
add_filter('acf/load_value/name=listing_title', 'tdp_vehicle_load_title', 10, 3);

/**
 * Load Vehicle Description.
 */
function tdp_vehicle_load_description( $value, $post_id, $field )
{	

	$vehicle_id = null;
	if(isset($_GET['pid'])) {
		$vehicle_id = $_GET['pid'];
	}

	$vehicle_object = get_post( $vehicle_id );

    // run the_content filter on all textarea values
    $value = $vehicle_object->post_content;
 
    return $value;
}
add_filter('acf/load_value/name=listing_description', 'tdp_vehicle_load_description', 10, 3);

/**
 * Update vehicle function.
 */
if(!function_exists("tdp_listings_update_listing")) {

function tdp_listings_update_listing( $post_id ) {
  	
  	global $wpdb;

  	$url = get_field('edit_vehicle_page','option');
    $editpage = url_to_postid( $url );

  	if ( 'vehicles' == get_post_type() || is_page($editpage) ) {
	  	//get new title
	  	$title = $_POST["fields"]['field_533c029127838'];
	  	$content = $_POST["fields"]['field_533c02a827839'];
 	}

  	if( $post_id != 'new_listing' && !is_admin() && is_page($editpage) ) {
 
  		$wpdb->query("UPDATE $wpdb->posts SET post_title = '".$title."' WHERE ID = '".$post_id."'");
  		$wpdb->query("UPDATE $wpdb->posts SET post_content = '".$content."' WHERE ID = '".$post_id."'");

  		set_post_thumbnail( $post_id, $_POST["fields"]['field_5284d3935e6ft'] );

	}
}
}
add_filter('acf/save_post' , 'tdp_listings_update_listing', 20 );

/**
 * Add Capabilities to upload images.
 */
if ( current_user_can('subscriber') )
    add_action('init', 'allow_contributor_uploads');
 
function allow_contributor_uploads() {
    $subscriber = get_role('subscriber');
    $subscriber->add_cap('upload_files');
    $subscriber->add_cap('edit_others_pages');
    $subscriber->add_cap('edit_published_pages');
}

if ( current_user_can('tdp_dealer') )
    add_action('init', 'allow_dealer_uploads');
 
function allow_dealer_uploads() {
    $dealer = get_role('tdp_dealer');
    $dealer->add_cap('upload_files');
    $dealer->add_cap('edit_others_pages');
    $dealer->add_cap('edit_published_pages');
}



