<?php
/**
 * ThemesDepot Framework functions and definitions
 *
 * @package ThemesDepot Framework
 */

define('TDP_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/framework/');
define('TDP_FRAMEWORK_VERSION', '2.5.0');

define('THEME_PATH', get_template_directory());
define('THEME_DIR', get_template_directory_uri());
define('STYLESHEET_PATH', get_stylesheet_directory());
define('STYLESHEET_DIR', get_stylesheet_directory_uri());

/**
 * Required: include Custom Fields Framework.
 */
require_once('framework/acf/acf.php' );
require_once('framework/addons/acf-flexible-content/acf-flexible-content.php' );
require_once('framework/addons/acf-gallery/acf-gallery.php' );
require_once('framework/addons/acf-repeater/acf-repeater.php' );
require_once('framework/addons/acf-location-field-master/acf-location.php' );

/**
 * Required: include Main Options.
 */
require_once('framework/admin/acf-options-page/acf-options-page.php' );
require_once('framework/extensions/options.php' );

/**
 * Load Framework Setup
 */
require_once('framework/functions/class-tgm-plugin-activation.php' );
require_once('framework/functions/core-functions.php' );
require_once('framework/functions/required-plugins.php' );
require_once('framework/functions/theme-actions.php' );
require_once('framework/functions/theme-setup.php' );
require_once('framework/functions/theme-widgets.php' );
require_once('framework/functions/theme-installer.php' );
require_once('framework/functions/tdp-styleswitcher.php' );

/**
 * Load Framework Search Modules
 */
require_once('framework/functions/wpas.php' );
require_once( trailingslashit( get_stylesheet_directory() ) . 'framework/extensions/search.php' ); // this file can be overriden through child themes
require_once( trailingslashit( get_stylesheet_directory() ) . 'framework/extensions/advanced-search.php' ); // this file can be overriden through child themes

/**
 * Load Theme Specific Functions
 */
require_once('framework/extensions/theme-specific.php' );
/**
 * Add Support For TDP Extensions
 */
add_theme_support( 'tdp_autotrader' ); // Add support for the autotrader module (custom post type, etc.)
add_theme_support( 'tdp_installer' ); // Add support for tdp - installer plugin
// add support for theme specific shortcodes. These shortcodes work only with this theme. Other shortcodes for layout and elements are into the plugin
require_once('framework/extensions/tdp-shortcodes-extend.php' );
require_once('framework/extensions/edit-vehicles.php' ); 

/**
 * Add Support For Hangar Widgets
 */
require_once('framework/extensions/widgets/widget_vehicles_types.php' );
require_once('framework/extensions/widgets/widget_vehicles_fuel.php' );
require_once('framework/extensions/widgets/widget_vehicles_color.php' );
require_once('framework/extensions/widgets/widget_vehicle_status.php' );
require_once('framework/extensions/widgets/widget_vehicles_gear.php' );
require_once('framework/extensions/widgets/widget_vehicles_interior.php' );
require_once('framework/extensions/widgets/widget_vehicles_exterior.php' );
require_once('framework/extensions/widgets/widget_vehicles_safety.php' );
require_once('framework/extensions/widgets/widget_vehicles_extra.php' );
require_once('framework/extensions/widgets/widget_vehicles_location.php' );
require_once('framework/extensions/widgets/widget_vehicle_year.php' );
require_once('framework/extensions/widgets/widget_vehicles_model.php' );
require_once('framework/extensions/widgets/widget-listings-details.php' );
require_once('framework/extensions/widgets/widget-listings-profile.php' );
require_once('framework/extensions/widgets/widget-vehicle-search.php' );
require_once('framework/extensions/widgets/widget-latest-listings.php' );
require_once('framework/extensions/widgets/widget-featured-listings.php' );
require_once('framework/extensions/widgets/widget-dealer-profile.php' );

/**
 * Add Support For WooCommerce
 */
add_theme_support( 'woocommerce' );

/**
 * Add Support for custom slug
 */
function tdp_change_slug() {
	if(get_field('vehicle_permalink','option')) {
		return get_field('vehicle_permalink','option');
	}
}
add_filter( 'tdp_change_vehicles_slug', 'tdp_change_slug');

function acf_translate_fields( $field )
{
	$field['label' ] = __( $field['label' ], 'framework'  );
	$field['instructions' ] = __( $field['instructions' ], 'framework'  );

	return $field;
}
add_filter('acf/load_field' , 'acf_translate_fields' );

// Remove WC Styles.
add_filter( 'woocommerce_enqueue_styles', '__return_false' );