<?php
/**
* ThemesDepot Framework Extension: AutoTrader Module For Hangar
* This module is only loaded if the wp-autotrader plugin isn't enabled. 
*/

/**
* Add Vechicles Post Type
*/
if ( ! function_exists('tdp_autotrader_cpt') ) {

// Register Custom Post Type
function tdp_autotrader_cpt() {

	$labels = array(
		'name'                => _x( 'Vehicles', 'Post Type General Name', 'hangar' ),
		'singular_name'       => _x( 'Vehicle', 'Post Type Singular Name', 'hangar' ),
		'menu_name'           => __( 'Vehicles', 'hangar' ),
		'parent_item_colon'   => __( 'Parent Vehicle:', 'hangar' ),
		'all_items'           => __( 'All Vehicles', 'hangar' ),
		'view_item'           => __( 'View Vehicle', 'hangar' ),
		'add_new_item'        => __( 'Add New Vehicle', 'hangar' ),
		'add_new'             => __( 'New Vehicle', 'hangar' ),
		'edit_item'           => __( 'Edit Vehicle', 'hangar' ),
		'update_item'         => __( 'Update Vehicle', 'hangar' ),
		'search_items'        => __( 'Search Vehicles', 'hangar' ),
		'not_found'           => __( 'No Vehicles found', 'hangar' ),
		'not_found_in_trash'  => __( 'No Vehicles found in Trash', 'hangar' ),
	);
	$rewrite = array(
		'slug'                => apply_filters( 'tdp_change_vehicles_slug', 'vehicle' ),
	);
	$args = array(
		'label'               => __( 'vehicles', 'hangar' ),
		'description'         => __( 'Vehicles Post Type Compatible With ThemesDepot Themes', 'hangar' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_icon'           => get_template_directory_uri() . '/images/vehicle_post_type.png',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'page',
	);
	register_post_type( 'vehicles', $args );

}

// Hook into the 'init' action
add_action( 'init', 'tdp_autotrader_cpt', 0 );

}


/**
* Add Type Taxonomy
*/
if ( ! function_exists('tdp_autotrader_vehicles_type') ) {

// Register Custom Taxonomy
function tdp_autotrader_vehicles_type()  {

	$labels = array(
		'name'                       => _x( 'Types', 'Taxonomy General Name', 'hangar' ),
		'singular_name'              => _x( 'Type', 'Taxonomy Singular Name', 'hangar' ),
		'menu_name'                  => __( 'Type', 'hangar' ),
		'all_items'                  => __( 'All Types', 'hangar' ),
		'parent_item'                => __( 'Parent Type', 'hangar' ),
		'parent_item_colon'          => __( 'Parent Type:', 'hangar' ),
		'new_item_name'              => __( 'New Type Name', 'hangar' ),
		'add_new_item'               => __( 'Add New Type', 'hangar' ),
		'edit_item'                  => __( 'Edit Type', 'hangar' ),
		'update_item'                => __( 'Update Type', 'hangar' ),
		'separate_items_with_commas' => __( 'Separate Types with commas', 'hangar' ),
		'search_items'               => __( 'Search Types', 'hangar' ),
		'add_or_remove_items'        => __( 'Add or remove Types', 'hangar' ),
		'choose_from_most_used'      => __( 'Choose from the most used Types', 'hangar' ),
	);
	$rewrite = array(
		'slug'                       => 'vehicle-type',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'query_var'                  => 'vehicle_type',
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'vehicle_type', 'vehicles', $args );

}

// Hook into the 'init' action
add_action( 'init', 'tdp_autotrader_vehicles_type', 0 );

}

/**
* Add Fuel Type
*/
if ( ! function_exists('tdp_autotrader_vehicles_fuel_type') ) {

// Register Custom Taxonomy
function tdp_autotrader_vehicles_fuel_type()  {

	$labels = array(
		'name'                       => _x( 'Fuel Types', 'Taxonomy General Name', 'hangar' ),
		'singular_name'              => _x( 'Fuel Type', 'Taxonomy Singular Name', 'hangar' ),
		'menu_name'                  => __( 'Fuel Type', 'hangar' ),
		'all_items'                  => __( 'All Fuel Types', 'hangar' ),
		'parent_item'                => __( 'Parent Fuel Type', 'hangar' ),
		'parent_item_colon'          => __( 'Parent Fuel Type:', 'hangar' ),
		'new_item_name'              => __( 'New Fuel Type Name', 'hangar' ),
		'add_new_item'               => __( 'Add Fuel New Type', 'hangar' ),
		'edit_item'                  => __( 'Edit Fuel Type', 'hangar' ),
		'update_item'                => __( 'Update Fuel Type', 'hangar' ),
		'separate_items_with_commas' => __( 'Separate Fuel Types with commas', 'hangar' ),
		'search_items'               => __( 'Search Fuel Types', 'hangar' ),
		'add_or_remove_items'        => __( 'Add or remove Fuel Types', 'hangar' ),
		'choose_from_most_used'      => __( 'Choose from the most used Fuel Types', 'hangar' ),
	);
	$rewrite = array(
		'slug'                       => 'fuel',
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'query_var'                  => 'vehicle_fuel_type',
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'vehicle_fuel_type', 'vehicles', $args );

}

// Hook into the 'init' action
add_action( 'init', 'tdp_autotrader_vehicles_fuel_type', 0 );

}

/**
* Add Color Taxonomy
*/

if ( ! function_exists('tdp_autotrader_vehicles_color') ) {

// Register Custom Taxonomy
function tdp_autotrader_vehicles_color()  {

	$labels = array(
		'name'                       => _x( 'Colors', 'Taxonomy General Name', 'hangar' ),
		'singular_name'              => _x( 'Color', 'Taxonomy Singular Name', 'hangar' ),
		'menu_name'                  => __( 'Color', 'hangar' ),
		'all_items'                  => __( 'All Colors', 'hangar' ),
		'parent_item'                => __( 'Parent Color', 'hangar' ),
		'parent_item_colon'          => __( 'Parent Color:', 'hangar' ),
		'new_item_name'              => __( 'New Color', 'hangar' ),
		'add_new_item'               => __( 'Add Color', 'hangar' ),
		'edit_item'                  => __( 'Edit Color', 'hangar' ),
		'update_item'                => __( 'Update Color', 'hangar' ),
		'separate_items_with_commas' => __( 'Separate Colors with commas', 'hangar' ),
		'search_items'               => __( 'Search Colors', 'hangar' ),
		'add_or_remove_items'        => __( 'Add or remove Colors', 'hangar' ),
		'choose_from_most_used'      => __( 'Choose from the most used Colors', 'hangar' ),
	);
	$rewrite = array(
		'slug'                       => 'color',
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'query_var'                  => 'vehicle_color',
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'vehicle_color', 'vehicles', $args );

}

// Hook into the 'init' action
add_action( 'init', 'tdp_autotrader_vehicles_color', 0 );

}

/**
* Add Statuses
*/

if ( ! function_exists('tdp_autotrader_vehicles_statuses') ) {

// Register Custom Taxonomy
function tdp_autotrader_vehicles_statuses()  {

	$labels = array(
		'name'                       => _x( 'Statuses', 'Taxonomy General Name', 'hangar' ),
		'singular_name'              => _x( 'Status', 'Taxonomy Singular Name', 'hangar' ),
		'menu_name'                  => __( 'Status', 'hangar' ),
		'all_items'                  => __( 'All Statuses', 'hangar' ),
		'parent_item'                => __( 'Parent Status', 'hangar' ),
		'parent_item_colon'          => __( 'Parent Status:', 'hangar' ),
		'new_item_name'              => __( 'New Status', 'hangar' ),
		'add_new_item'               => __( 'Add Status', 'hangar' ),
		'edit_item'                  => __( 'Edit Status', 'hangar' ),
		'update_item'                => __( 'Update Status', 'hangar' ),
		'separate_items_with_commas' => __( 'Separate Statuses with commas', 'hangar' ),
		'search_items'               => __( 'Search Statuses', 'hangar' ),
		'add_or_remove_items'        => __( 'Add or remove Statuses', 'hangar' ),
		'choose_from_most_used'      => __( 'Choose from the most used Statuses', 'hangar' ),
	);
	$rewrite = array(
		'slug'                       => 'status',
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'query_var'                  => 'vehicle_status',
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'vehicle_status', 'vehicles', $args );

}

// Hook into the 'init' action
add_action( 'init', 'tdp_autotrader_vehicles_statuses', 0 );

}

/**
* Add Gearbox
*/

if ( ! function_exists('tdp_autotrader_vehicles_gearbox') ) {

// Register Custom Taxonomy
function tdp_autotrader_vehicles_gearbox()  {

	$labels = array(
		'name'                       => _x( 'Gearboxes', 'Taxonomy General Name', 'hangar' ),
		'singular_name'              => _x( 'Gearbox', 'Taxonomy Singular Name', 'hangar' ),
		'menu_name'                  => __( 'Gearbox', 'hangar' ),
		'all_items'                  => __( 'All Gearboxes', 'hangar' ),
		'parent_item'                => __( 'Parent Gearbox', 'hangar' ),
		'parent_item_colon'          => __( 'Parent Gearbox:', 'hangar' ),
		'new_item_name'              => __( 'New Gearbox', 'hangar' ),
		'add_new_item'               => __( 'Add Gearbox', 'hangar' ),
		'edit_item'                  => __( 'Edit Gearbox', 'hangar' ),
		'update_item'                => __( 'Update Gearbox', 'hangar' ),
		'separate_items_with_commas' => __( 'Separate Gearboxes with commas', 'hangar' ),
		'search_items'               => __( 'Search Gearboxes', 'hangar' ),
		'add_or_remove_items'        => __( 'Add or remove Gearboxes', 'hangar' ),
		'choose_from_most_used'      => __( 'Choose from the most used Gearboxes', 'hangar' ),
	);
	$rewrite = array(
		'slug'                       => 'gearbox',
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'query_var'                  => 'vehicle_gearbox',
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'vehicle_gearbox', 'vehicles', $args );

}

// Hook into the 'init' action
add_action( 'init', 'tdp_autotrader_vehicles_gearbox', 0 );

}

/**
* Add Interior Features
*/

if ( ! function_exists('tdp_autotrader_vehicles_interior_features') ) {

// Register Custom Taxonomy
function tdp_autotrader_vehicles_interior_features()  {

	$labels = array(
		'name'                       => _x( 'Interior Features', 'Taxonomy General Name', 'hangar' ),
		'singular_name'              => _x( 'Interior Feature', 'Taxonomy Singular Name', 'hangar' ),
		'menu_name'                  => __( 'Interior Feature', 'hangar' ),
		'all_items'                  => __( 'All Interior Feature', 'hangar' ),
		'parent_item'                => __( 'Parent Interior Feature', 'hangar' ),
		'parent_item_colon'          => __( 'Parent Interior Feature:', 'hangar' ),
		'new_item_name'              => __( 'New Interior Feature', 'hangar' ),
		'add_new_item'               => __( 'Add Interior Feature', 'hangar' ),
		'edit_item'                  => __( 'Edit Interior Feature', 'hangar' ),
		'update_item'                => __( 'Update Interior Feature', 'hangar' ),
		'separate_items_with_commas' => __( 'Separate Interior Features with commas', 'hangar' ),
		'search_items'               => __( 'Search Interior Features', 'hangar' ),
		'add_or_remove_items'        => __( 'Add or remove Interior Features', 'hangar' ),
		'choose_from_most_used'      => __( 'Choose from the most used Interior Features', 'hangar' ),
	);
	$rewrite = array(
		'slug'                       => 'interior',
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'query_var'                  => 'vehicle_interior_feature',
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'vehicle_interior_feature', 'vehicles', $args );

}

// Hook into the 'init' action
add_action( 'init', 'tdp_autotrader_vehicles_interior_features', 0 );

}

/**
* Add Exterior Features
*/

if ( ! function_exists('tdp_autotrader_vehicles_exterior_features') ) {

// Register Custom Taxonomy
function tdp_autotrader_vehicles_exterior_features()  {

	$labels = array(
		'name'                       => _x( 'Exterior Features', 'Taxonomy General Name', 'hangar' ),
		'singular_name'              => _x( 'Exterior Feature', 'Taxonomy Singular Name', 'hangar' ),
		'menu_name'                  => __( 'Exterior Feature', 'hangar' ),
		'all_items'                  => __( 'All Exterior Feature', 'hangar' ),
		'parent_item'                => __( 'Parent Exterior Feature', 'hangar' ),
		'parent_item_colon'          => __( 'Parent Exterior Feature:', 'hangar' ),
		'new_item_name'              => __( 'New Exterior Feature', 'hangar' ),
		'add_new_item'               => __( 'Add Exterior Feature', 'hangar' ),
		'edit_item'                  => __( 'Edit Exterior Feature', 'hangar' ),
		'update_item'                => __( 'Update Exterior Feature', 'hangar' ),
		'separate_items_with_commas' => __( 'Separate Exterior Features with commas', 'hangar' ),
		'search_items'               => __( 'Search Exterior Features', 'hangar' ),
		'add_or_remove_items'        => __( 'Add or remove Exterior Features', 'hangar' ),
		'choose_from_most_used'      => __( 'Choose from the most used Exterior Features', 'hangar' ),
	);
	$rewrite = array(
		'slug'                       => 'exterior',
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'query_var'                  => 'vehicle_exterior_feature',
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'vehicle_exterior_feature', 'vehicles', $args );

}

// Hook into the 'init' action
add_action( 'init', 'tdp_autotrader_vehicles_exterior_features', 0 );

}

/**
* Add safety Features
*/

if ( ! function_exists('tdp_autotrader_vehicles_safety_features') ) {

// Register Custom Taxonomy
function tdp_autotrader_vehicles_safety_features()  {

	$labels = array(
		'name'                       => _x( 'Safety Features', 'Taxonomy General Name', 'hangar' ),
		'singular_name'              => _x( 'Safety Feature', 'Taxonomy Singular Name', 'hangar' ),
		'menu_name'                  => __( 'Safety Feature', 'hangar' ),
		'all_items'                  => __( 'All Safety Feature', 'hangar' ),
		'parent_item'                => __( 'Parent Safety Feature', 'hangar' ),
		'parent_item_colon'          => __( 'Parent Safety Feature:', 'hangar' ),
		'new_item_name'              => __( 'New Safety Feature', 'hangar' ),
		'add_new_item'               => __( 'Add Safety Feature', 'hangar' ),
		'edit_item'                  => __( 'Edit Safety Feature', 'hangar' ),
		'update_item'                => __( 'Update Safety Feature', 'hangar' ),
		'separate_items_with_commas' => __( 'Separate Safety Features with commas', 'hangar' ),
		'search_items'               => __( 'Search Safety Features', 'hangar' ),
		'add_or_remove_items'        => __( 'Add or remove Safety Features', 'hangar' ),
		'choose_from_most_used'      => __( 'Choose from the most used Safety Features', 'hangar' ),
	);
	$rewrite = array(
		'slug'                       => 'safety',
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'query_var'                  => 'vehicle_safety_feature',
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'vehicle_safety_feature', 'vehicles', $args );

}

// Hook into the 'init' action
add_action( 'init', 'tdp_autotrader_vehicles_safety_features', 0 );

}

/**
* Add extra
*/

if ( ! function_exists('tdp_autotrader_vehicles_extra') ) {

// Register Custom Taxonomy
function tdp_autotrader_vehicles_extra()  {

	$labels = array(
		'name'                       => _x( 'Extras', 'Taxonomy General Name', 'hangar' ),
		'singular_name'              => _x( 'Extra', 'Taxonomy Singular Name', 'hangar' ),
		'menu_name'                  => __( 'Extra', 'hangar' ),
		'all_items'                  => __( 'All Extras', 'hangar' ),
		'parent_item'                => __( 'Parent Extra', 'hangar' ),
		'parent_item_colon'          => __( 'Parent Extra:', 'hangar' ),
		'new_item_name'              => __( 'New Extra', 'hangar' ),
		'add_new_item'               => __( 'Add Extra', 'hangar' ),
		'edit_item'                  => __( 'Edit Extra', 'hangar' ),
		'update_item'                => __( 'Update Extra', 'hangar' ),
		'separate_items_with_commas' => __( 'Separate Extras with commas', 'hangar' ),
		'search_items'               => __( 'Search Extras', 'hangar' ),
		'add_or_remove_items'        => __( 'Add or remove Extras', 'hangar' ),
		'choose_from_most_used'      => __( 'Choose from the most used Extras', 'hangar' ),
	);
	$rewrite = array(
		'slug'                       => 'extra',
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'query_var'                  => 'vehicle_extra',
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'vehicle_extra', 'vehicles', $args );

}

// Hook into the 'init' action
add_action( 'init', 'tdp_autotrader_vehicles_extra', 0 );

}

/**
* Add location
*/


if ( ! function_exists('tdp_autotrader_vehicles_location') ) {

// Register Custom Taxonomy
function tdp_autotrader_vehicles_location()  {

	$labels = array(
		'name'                       => _x( 'Locations', 'Taxonomy General Name', 'hangar' ),
		'singular_name'              => _x( 'Location', 'Taxonomy Singular Name', 'hangar' ),
		'menu_name'                  => __( 'Location', 'hangar' ),
		'all_items'                  => __( 'All Locations', 'hangar' ),
		'parent_item'                => __( 'Parent Location', 'hangar' ),
		'parent_item_colon'          => __( 'Parent Location:', 'hangar' ),
		'new_item_name'              => __( 'New Location', 'hangar' ),
		'add_new_item'               => __( 'Add Location', 'hangar' ),
		'edit_item'                  => __( 'Edit Location', 'hangar' ),
		'update_item'                => __( 'Update Location', 'hangar' ),
		'separate_items_with_commas' => __( 'Separate Locations with commas', 'hangar' ),
		'search_items'               => __( 'Search Locations', 'hangar' ),
		'add_or_remove_items'        => __( 'Add or remove Locations', 'hangar' ),
		'choose_from_most_used'      => __( 'Choose from the most used Locations', 'hangar' ),
	);
	$rewrite = array(
		'slug'                       => 'location',
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'query_var'                  => 'vehicle_location',
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'vehicle_location', 'vehicles', $args );

}



// Hook into the 'init' action
add_action( 'init', 'tdp_autotrader_vehicles_location', 0 );

}



/**
* Add Year
*/
if ( ! function_exists('tdp_autotrader_vehicles_year') ) {

// Register Custom Taxonomy
function tdp_autotrader_vehicles_year()  {

	$labels = array(
		'name'                       => _x( 'Years', 'Taxonomy General Name', 'hangar' ),
		'singular_name'              => _x( 'Year', 'Taxonomy Singular Name', 'hangar' ),
		'menu_name'                  => __( 'Year', 'hangar' ),
		'all_items'                  => __( 'All Years', 'hangar' ),
		'parent_item'                => __( 'Parent Year', 'hangar' ),
		'parent_item_colon'          => __( 'Parent Year:', 'hangar' ),
		'new_item_name'              => __( 'New Year Name', 'hangar' ),
		'add_new_item'               => __( 'Add New TYear', 'hangar' ),
		'edit_item'                  => __( 'Edit TYear', 'hangar' ),
		'update_item'                => __( 'Update Year', 'hangar' ),
		'separate_items_with_commas' => __( 'Separate Years with commas', 'hangar' ),
		'search_items'               => __( 'Search Years', 'hangar' ),
		'add_or_remove_items'        => __( 'Add or remove Years', 'hangar' ),
		'choose_from_most_used'      => __( 'Choose from the most used Years', 'hangar' ),
	);
	$rewrite = array(
		'slug'                       => 'vehicle-year',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'query_var'                  => 'vehicle_year',
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'vehicle_year', 'vehicles', $args );

}

// Hook into the 'init' action
add_action( 'init', 'tdp_autotrader_vehicles_year', 0 );

}


/**
* Add model
*/

if ( ! function_exists('tdp_autotrader_vehicles_model') ) {

// Register Custom Taxonomy
function tdp_autotrader_vehicles_model()  {

	$labels = array(
		'name'                       => _x( 'Models/Makers', 'Taxonomy General Name', 'hangar' ),
		'singular_name'              => _x( 'Model/Maker', 'Taxonomy Singular Name', 'hangar' ),
		'menu_name'                  => __( 'Model/Maker', 'hangar' ),
		'all_items'                  => __( 'All Models/Makers', 'hangar' ),
		'parent_item'                => __( 'Parent Model/Maker', 'hangar' ),
		'parent_item_colon'          => __( 'Parent Model/Maker:', 'hangar' ),
		'new_item_name'              => __( 'New Model/Maker', 'hangar' ),
		'add_new_item'               => __( 'Add Model/Maker', 'hangar' ),
		'edit_item'                  => __( 'Edit Model/Maker', 'hangar' ),
		'update_item'                => __( 'Update Model/Maker', 'hangar' ),
		'separate_items_with_commas' => __( 'Separate Models/Makers with commas', 'hangar' ),
		'search_items'               => __( 'Search Models/Makers', 'hangar' ),
		'add_or_remove_items'        => __( 'Add or remove Models/Makers', 'hangar' ),
		'choose_from_most_used'      => __( 'Choose from the most used Models/Makers', 'hangar' ),
	);
	$rewrite = array(
		'slug'                       => 'model',
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'query_var'                  => 'vehicle_model',
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'vehicle_model', 'vehicles', $args );

}

// Hook into the 'init' action
add_action( 'init', 'tdp_autotrader_vehicles_model', 0 );

}

