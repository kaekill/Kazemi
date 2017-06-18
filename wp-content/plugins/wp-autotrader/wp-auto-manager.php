<?php
/*
Plugin Name: WP Auto Manager
Plugin URI: http://themesdepot.org
Description: Manage vehicles listings from the WordPress admin panel, and allow users to post vehicles directly to your site.
Version: 1.4.4
Author: Alessandro Tesoro
Author URI: http://themesdepot.org

	Copyright: 2013 Alessandro Tesoro
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * WP_Auto_Manager class.
 */
class WP_Auto_Manager {

	/**
	 * __construct function.
	 */
	public function __construct() {
		// Define constants
		define( 'AUTO_MANAGER_VERSION', '1.4.2' );
		define( 'AUTO_MANAGER_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'AUTO_MANAGER_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );

		// Includes
		include( 'wp-auto-manager-functions.php' );
		include( 'wp-auto-manager-template.php' );
		include( 'includes/class-wp-auto-manager-post-types.php' );
		include( 'includes/class-wp-auto-manager-shortcodes.php' );
		include( 'includes/class-wp-auto-manager-api.php' );
		include( 'includes/class-wp-auto-manager-forms.php' );

		if ( is_admin() )
			include( 'includes/admin/class-wp-auto-manager-admin.php' );

		// Init classes
		$this->forms      = new WP_Auto_Manager_Forms();
		$this->post_types = new WP_Auto_Manager_Post_Types();

		// Activation - works with symlinks
		register_activation_hook( basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ), array( $this->post_types, 'register_post_types' ), 10 );
		register_activation_hook( basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ), create_function( "", "include_once( 'includes/class-wp-auto-manager-install.php' );" ), 10 );
		register_activation_hook( basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ), 'flush_rewrite_rules', 15 );

		// Actions
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
		//add_action( 'switch_theme', array( $this->post_types, 'register_post_types' ) );
		add_action( 'switch_theme', 'flush_rewrite_rules', 15 );
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
		add_action( 'admin_init', array( $this, 'updater' ) );
	}

	/**
	 * Handle Updates
	 */
	public function updater() {
		if ( version_compare( AUTO_MANAGER_VERSION, get_option( 'wp_auto_manager_version' ), '>' ) )
			include_once( 'includes/class-wp-auto-manager-install.php' );
	}

	/**
	 * Localisation
	 *
	 * @access private
	 * @return void
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'auto_manager', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * frontend_scripts function.
	 *
	 * @access public
	 * @return void
	 */
	public function frontend_scripts() {
		wp_register_script( 'wp-auto-manager-ajax-filters', AUTO_MANAGER_PLUGIN_URL . '/assets/js/ajax-filters.min.js', array( 'jquery' ), AUTO_MANAGER_VERSION, true );
		wp_register_script( 'wp-auto-manager-auto-dashboard', AUTO_MANAGER_PLUGIN_URL . '/assets/js/auto-dashboard.min.js', array( 'jquery' ), AUTO_MANAGER_VERSION, true );
		wp_register_script( 'wp-auto-manager-auto-application', AUTO_MANAGER_PLUGIN_URL . '/assets/js/auto-application.min.js', array( 'jquery' ), AUTO_MANAGER_VERSION, true );

		wp_localize_script( 'wp-auto-manager-ajax-filters', 'auto_manager_ajax_filters', array(
			'ajax_url' => admin_url('admin-ajax.php')
		) );
		wp_localize_script( 'wp-auto-manager-auto-dashboard', 'auto_manager_auto_dashboard', array(
			'i18n_confirm_delete' => __( 'Are you sure you want to delete this auto?', 'auto_manager' )
		) );

		wp_enqueue_style( 'wp-auto-manager-frontend', AUTO_MANAGER_PLUGIN_URL . '/assets/css/frontend.css' );
	}
}

$GLOBALS['auto_manager'] = new WP_Auto_Manager();

/**
 * Init the plugin when all plugins are loaded
 */
function wp_auto_manager_wcpl_init() {

	if ( ! class_exists( 'WooCommerce' ) )
		return;

	/**
	 * WP_Auto_Manager_WCPL class.
	 */
	class WP_Auto_Manager_WCPL {

		/**
		 * Constructor
		 */
		public function __construct() {
			// Define constants
			define( 'AUTO_MANAGER_WCPL_VERSION', '1.0.3' );
			define( 'AUTO_MANAGER_WCPL_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
			define( 'AUTO_MANAGER_WCPL_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
			define( 'AUTO_MANAGER_WCPL_TEMPLATE_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/templates/' );

			// Hooks
			add_action( 'init', array( $this, 'init' ), 12 );
			add_filter( 'the_auto_status', array( $this, 'the_auto_status' ), 10, 2 );
			add_filter( 'auto_manager_valid_submit_auto_statuses', array( $this, 'valid_submit_auto_statuses' ) );

			// Includes
			include_once( 'includes/class-wc-product-auto-package.php' );
			include_once( 'includes/class-wp-auto-manager-wcpl-admin.php' );
			include_once( 'includes/class-wp-auto-manager-wcpl-cart.php' );
			include_once( 'includes/class-wp-auto-manager-wcpl-orders.php' );
			include_once( 'includes/class-wp-auto-manager-wcpl-forms.php' );
			include_once( 'includes/user-functions.php' );
			include_once( 'includes/auto-functions.php' );

		}

		/**
		 * Localisation
		 */
		public function init() {
			load_plugin_textdomain( 'auto_manager', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

			register_post_status( 'pending_payment', array(
				'label'                     => _x( 'Pending Payment', 'auto_listing', 'auto_manager' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Pending Payment <span class="count">(%s)</span>', 'Pending Payment <span class="count">(%s)</span>', 'auto_manager' ),
			) );
		}

		/**
		 * Filter auto status name
		 *
		 * @param  string $nice_status
		 * @param  string $status
		 * @return string
		 */
		public function the_auto_status( $status, $auto ) {
			if ( $auto->post_status == 'pending_payment' )
				$status = __( 'Pending Payment', 'auto_manager' );
			return $status;
		}

		/**
		 * Ensure the submit form lets us continue to edit/process a auto with the pending_payment status
		 * @return array
		 */
		public function valid_submit_auto_statuses( $status ) {
			$status[] = 'pending_payment';
			return $status;
		}
	}

	new WP_Auto_Manager_WCPL();
}

add_action( 'plugins_loaded', 'wp_auto_manager_wcpl_init' );

/**
 * Install the plugin
 */
function wp_auto_manager_wcpl_install() {
	global $wpdb;

	$wpdb->hide_errors();

	$collate = '';
    if ( $wpdb->has_cap( 'collation' ) ) {
		if( ! empty($wpdb->charset ) )
			$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
		if( ! empty($wpdb->collate ) )
			$collate .= " COLLATE $wpdb->collate";
    }

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    /**
     * Table for user auto packs
     */
    $sql = "
CREATE TABLE {$wpdb->prefix}user_auto_packages (
  id bigint(20) NOT NULL auto_increment,
  user_id bigint(20) NOT NULL,
  product_id bigint(20) NOT NULL,
  auto_duration bigint(20) NOT NULL,
  auto_featured int(1) NOT NULL,
  auto_limit bigint(20) NOT NULL,
  auto_count bigint(20) NOT NULL,
  PRIMARY KEY  (id)
) $collate;
";
    dbDelta($sql);
}

register_activation_hook( __FILE__, 'wp_auto_manager_wcpl_install' );