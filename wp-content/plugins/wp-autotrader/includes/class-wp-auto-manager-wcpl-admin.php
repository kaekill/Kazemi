<?php
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * Admin
 */
class WP_Auto_Manager_WCPL_Admin {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'product_type_selector' , array( $this, 'product_type_selector' ) );
		add_action( 'woocommerce_process_product_meta', array( $this,'save_product_data' ) );
		add_action( 'woocommerce_product_options_general_product_data', array( $this, 'auto_package_data' ) );
	}

	/**
	 * Add the product type
	 */
	public function product_type_selector( $types ) {
		$types[ 'auto_package' ] = __( 'Vehicle Package', auto_manager );
		return $types;
	}

	/**
	 * Show the auto package product options
	 */
	public function auto_package_data() {
		global $post;
		$post_id = $post->ID;
		include( 'views/html-auto-package-data.php' );
	}

	/**
	 * Save Auto Package data for the product
	 *
	 * @param  int $post_id
	 */
	public function save_product_data( $post_id ) {
		global $wpdb;

		// Save meta
		$meta_to_save = array(
			'_auto_listing_duration' => '',
			'_auto_listing_limit'    => 'int',
			'_auto_listing_featured' => 'yesno'
		);

		foreach ( $meta_to_save as $meta_key => $sanitize ) {
			$value = ! empty( $_POST[ $meta_key ] ) ? $_POST[ $meta_key ] : '';
			switch ( $sanitize ) {
				case 'int' :
					$value = absint( $value );
					break;
				case 'float' :
					$value = floatval( $value );
					break;
				case 'yesno' :
					$value = $value == 'yes' ? 'yes' : 'no';
					break;
				default :
					$value = sanitize_text_field( $value );
			}
			update_post_meta( $post_id, $meta_key, $value );
		}
	}
}

new WP_Auto_Manager_WCPL_Admin();