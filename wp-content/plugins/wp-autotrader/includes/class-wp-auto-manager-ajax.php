<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WP_Auto_Manager_Ajax class.
 */
class WP_Auto_Manager_Ajax {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wp_ajax_nopriv_auto_manager_get_listings', array( $this, 'get_listings' ) );
		add_action( 'wp_ajax_auto_manager_get_listings', array( $this, 'get_listings' ) );
	}

	/**
	 * Get listings via ajax
	 */
	public function get_listings() {
		global $auto_manager, $wpdb;

		ob_start();

		$search_location   = sanitize_text_field( stripslashes( $_POST['search_location'] ) );
		$search_keywords   = sanitize_text_field( stripslashes( $_POST['search_keywords'] ) );
		$search_categories = isset( $_POST['search_categories'] ) ? $_POST['search_categories'] : '';
		$filter_auto_types  = isset( $_POST['filter_auto_type'] ) ? array_filter( array_map( 'sanitize_title', (array) $_POST['filter_auto_type'] ) ) : null;

		if ( is_array( $search_categories ) ) {
			$search_categories = array_map( 'sanitize_text_field', array_map( 'stripslashes', $search_categories ) );
		} else {
			$search_categories = array( sanitize_text_field( stripslashes( $search_categories ) ), 0 );
		}

		$search_categories = array_filter( $search_categories );

		$autos = get_auto_listings( array(
			'search_location'   => $search_location,
			'search_keywords'   => $search_keywords,
			'search_categories' => $search_categories,
			'auto_types'         => is_null( $filter_auto_types ) ? '' : $filter_auto_types + array( 0 ),
			'orderby'           => sanitize_text_field( $_POST['orderby'] ),
			'order'             => sanitize_text_field( $_POST['order'] ),
			'offset'            => ( absint( $_POST['page'] ) - 1 ) * absint( $_POST['per_page'] ),
			'posts_per_page'    => absint( $_POST['per_page'] )
		) );

		$result = array();
		$result['found_autos'] = false;

		if ( $autos->have_posts() ) : $result['found_autos'] = true; ?>

			<?php while ( $autos->have_posts() ) : $autos->the_post(); ?>

				<?php get_auto_manager_template_part( 'content', 'auto_listing' ); ?>

			<?php endwhile; ?>

		<?php else : ?>

			<li class="no_auto_listings_found"><?php _e( 'No more autos found matching your selection.', 'auto_manager' ); ?></li>

		<?php endif;

		$result['html']    = ob_get_clean();

		// Generate 'showing' text
		$types = get_auto_listing_types();

		if ( sizeof( $filter_auto_types ) > 0 && ( sizeof( $filter_auto_types ) !== sizeof( $types ) || $search_keywords || $search_location || $search_categories || apply_filters( 'auto_manager_get_listings_custom_filter', false ) ) ) {
			$showing_types = array();
			$unmatched     = false;

			foreach ( $types as $type ) {
				if ( in_array( $type->slug, $filter_auto_types ) )
					$showing_types[] = $type->name;
				else
					$unmatched = true;
			}

			if ( ! $unmatched )
				$showing_types  = '';
			elseif ( sizeof( $showing_types ) == 1 ) {
				$showing_types  = implode( ', ', $showing_types ) . ' ';
			} else {
				$last           = array_pop( $showing_types );
				$showing_types  = implode( ', ', $showing_types );
				$showing_types .= " &amp; $last ";
			}

			$showing_categories = array();

			if ( $search_categories ) {
				foreach ( $search_categories as $category ) {
					$category = get_term_by( 'slug', $category, 'auto_listing_category' );

					if ( ! is_wp_error( $category ) )
						$showing_categories[] = $category->name;
				}
			}

			if ( $search_keywords ) {
				$showing_autos  = sprintf( __( 'Showing %s&ldquo;%s&rdquo; %sautos', 'auto_manager' ), $showing_types, $search_keywords, implode( ', ', $showing_categories ) );
			} else {
				$showing_autos  = sprintf( __( 'Showing all %s%sautos', 'auto_manager' ), $showing_types, implode( ', ', $showing_categories ) . ' ' );
			}

			$showing_location  = $search_location ? sprintf( ' ' . __( 'located in &ldquo;%s&rdquo;', 'auto_manager' ), $search_location ) : '';

			$result['showing'] = apply_filters( 'auto_manager_get_listings_custom_filter_text', $showing_autos . $showing_location );

		} else {
			$result['showing'] = '';
		}

		// Generate RSS link
		$result['showing_links'] = auto_manager_get_filtered_links( array(
			'filter_auto_types'  => $filter_auto_types,
			'search_location'   => $search_location,
			'search_categories' => $search_categories,
			'search_keywords'   => $search_keywords
		) );

		$result['max_num_pages'] = $autos->max_num_pages;

		echo '<!--WPJM-->';
		echo json_encode( $result );
		echo '<!--WPJM_END-->';

		die();
	}
}

new WP_Auto_Manager_Ajax();