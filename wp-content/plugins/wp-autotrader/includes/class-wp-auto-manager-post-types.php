<?php
/**
 * WP_Auto_Manager_Content class.
 */
class WP_Auto_Manager_Post_Types {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'admin_head', array( $this, 'admin_head' ) );
		add_action( 'auto_manager_check_for_expired_autos', array( $this, 'check_for_expired_autos' ) );
		add_action( 'pending_to_publish', array( $this, 'set_expirey' ) );
		add_action( 'preview_to_publish', array( $this, 'set_expirey' ) );
		add_action( 'draft_to_publish', array( $this, 'set_expirey' ) );
		add_action( 'auto-draft_to_publish', array( $this, 'set_expirey' ) );
	}

	/**
	 * Change label
	 */
	public function admin_head() {
		global $menu;

		$plural     = __( 'Vehicles', 'auto_manager' );
		$count_autos = wp_count_posts( 'vehicles', 'readable' );

		foreach ( $menu as $key => $menu_item ) {
			if ( strpos( $menu_item[0], $plural ) === 0 ) {
				if ( $order_count = $count_autos->pending ) {
					$menu[ $key ][0] .= " <span class='awaiting-mod update-plugins count-$order_count'><span class='pending-count'>" . number_format_i18n( $count_autos->pending ) . "</span></span>" ;
				}
				break;
			}
		}
	}

	/**
	 * Expire autos
	 */
	public function check_for_expired_autos() {
		global $wpdb;

		// Change status to expired
		$auto_ids = $wpdb->get_col( $wpdb->prepare( "
			SELECT postmeta.post_id FROM {$wpdb->postmeta} as postmeta
			LEFT JOIN {$wpdb->posts} as posts ON postmeta.post_id = posts.ID
			WHERE postmeta.meta_key = '_auto_expires'
			AND postmeta.meta_value > 0
			AND postmeta.meta_value < %s
			AND posts.post_status = 'publish'
			AND posts.post_type = 'vehicles'
		", date( 'Y-m-d', current_time( 'timestamp' ) ) ) );

		if ( $auto_ids ) {
			foreach ( $auto_ids as $auto_id ) {
				$auto_data       = array();
				$auto_data['ID'] = $auto_id;
				$auto_data['post_status'] = 'expired';
				wp_update_post( $auto_data );
			}
		}

		// Delete old expired autos
		$auto_ids = $wpdb->get_col( $wpdb->prepare( "
			SELECT posts.ID FROM {$wpdb->posts} as posts
			WHERE posts.post_type = 'vehicles'
			AND posts.post_modified < %s
			AND posts.post_status = 'expired'
		", date( 'Y-m-d', strtotime( '-30 days', current_time( 'timestamp' ) ) ) ) );

		if ( $auto_ids ) {
			foreach ( $auto_ids as $auto_id ) {
				wp_trash_post( $auto_id );
			}
		}
	}

	/**
	 * Set expirey date when auto status changes
	 */
	public function set_expirey( $post ) {
		if ( $post->post_type !== 'vehicles' )
			return;

		// See if it is already set
		$expires  = get_post_meta( $post->ID, '_auto_expires', true );

		if ( ! empty( $expires ) )
			return;

		// Get duration from the product if set...
		$duration = get_post_meta( $post->ID, '_auto_duration', true );

		// ...otherwise use the global option
		if ( ! $duration )
			$duration = absint( get_field('listing_duration','option') );

		if ( $duration ) {
			$expires = date( 'Y-m-d', strtotime( "+{$duration} days", current_time( 'timestamp' ) ) );
			update_post_meta( $post->ID, '_auto_expires', $expires );

			// In case we are saving a post, ensure post data is updated so the field is not overridden
			if ( isset( $_POST[ '_auto_expires' ] ) )
				$_POST[ '_auto_expires' ] = $expires;

		} else {
			update_post_meta( $post->ID, '_auto_expires', '' );
		}
	}
}