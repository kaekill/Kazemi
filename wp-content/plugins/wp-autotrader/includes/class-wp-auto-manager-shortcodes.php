<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WP_Auto_Manager_Shortcodes class.
 */
class WP_Auto_Manager_Shortcodes {

	private $auto_dashboard_message = '';

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		add_action( 'wp', array( $this, 'shortcode_action_handler' ) );

		add_shortcode( 'submit_auto_form', array( $this, 'submit_auto_form' ) );
		add_shortcode( 'auto_dashboard', array( $this, 'auto_dashboard' ) );
	}

	/**
	 * Handle actions which need to be run before the shortcode e.g. post actions
	 */
	public function shortcode_action_handler() {
		global $post;

		$this->auto_dashboard_handler();
	}

	/**
	 * Show the auto submission form
	 */
	public function submit_auto_form() {
		return $GLOBALS['auto_manager']->forms->get_form( 'submit-auto' );
	}

	/**
	 * Handles actions on auto dashboard
	 */
	public function auto_dashboard_handler() {
		if ( ! empty( $_REQUEST['action'] ) && ! empty( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'], 'auto_manager_my_auto_actions' ) ) {

			$action = sanitize_title( $_REQUEST['action'] );
			$auto_id = absint( $_REQUEST['auto_id'] );

			try {
				// Get Auto
				$auto    = get_post( $auto_id );

				// Check ownership
				if ( $auto->post_author != get_current_user_id() )
					throw new Exception( __( 'Invalid Auto ID', 'auto_manager' ) );

				switch ( $action ) {
					case 'mark_filled' :
						// Check status
						if ( $auto->_filled == 1 )
							throw new Exception( __( 'This auto is already filled', 'auto_manager' ) );

						// Update
						update_post_meta( $auto_id, '_filled', 1 );

						// Message
						$this->auto_dashboard_message = '<div class="auto-manager-message">' . sprintf( __( '%s has been filled', 'auto_manager' ), $auto->post_title ) . '</div>';
						break;
					case 'mark_not_filled' :
						// Check status
						if ( $auto->_filled != 1 )
							throw new Exception( __( 'This auto is already not filled', 'auto_manager' ) );

						// Update
						update_post_meta( $auto_id, '_filled', 0 );

						// Message
						$this->auto_dashboard_message = '<div class="auto-manager-message">' . sprintf( __( '%s has been marked as not filled', 'auto_manager' ), $auto->post_title ) . '</div>';
						break;
					case 'delete' :
						// Trash it
						wp_trash_post( $auto_id );

						// Message

						
						$this->auto_dashboard_message = '<div class="alert-box success ">
							<a href="#" class="icon-cancel close" data-dismiss="alert"></a>
							<div class="alert-content">' . sprintf( __( '%s has been deleted', 'auto_manager' ), $auto->post_title ) . '</div>
						</div>';

						break;
				}

				do_action( 'auto_manager_my_auto_do_action', $action, $auto_id );

			} catch ( Exception $e ) {
				$this->auto_dashboard_message = '<div class="auto-manager-error">' . $e->getMessage() . '</div>';
			}
		}
	}

	/**
	 * Shortcode which lists the logged in user's autos
	 */
	public function auto_dashboard( $atts ) {
		global $auto_manager;

		if(function_exists('is_woocommerce')) {

		$packages = get_user_auto_packages( get_current_user_id() );

		}

		if ( ! is_user_logged_in() ) {
			_e( 'You need to be signed in to manage your auto listings.', 'auto_manager' );
			return;
		}

		extract( shortcode_atts( array(
			'posts_per_page' => '25',
		), $atts ) );

		wp_enqueue_script( 'wp-auto-manager-auto-dashboard' );

		// If doing an action, show conditional content if needed....
		if ( ! empty( $_REQUEST['action'] ) ) {

			$action = sanitize_title( $_REQUEST['action'] );
			$auto_id = absint( $_REQUEST['auto_id'] );

			switch ( $action ) {
				case 'edit' :
					return $auto_manager->forms->get_form( 'edit-auto' );
			}
		}

		// ....If not show the auto dashboard
		$args     = apply_filters( 'auto_manager_get_dashboard_autos_args', array(
			'post_type'           => 'vehicles',
			'post_status'         => array( 'publish', 'expired', 'pending' ),
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $posts_per_page,
			'offset'              => ( max( 1, get_query_var('paged') ) - 1 ) * $posts_per_page,
			'orderby'             => 'date',
			'order'               => 'desc',
			'author'              => get_current_user_id()
		) );

		$autos = new WP_Query;

		ob_start();

		echo $this->auto_dashboard_message;

		get_auto_manager_template( 'auto-dashboard.php', array( 'autos' => $autos->query( $args ), 'max_num_pages' => $autos->max_num_pages, 'packages' => $packages ) );

		return ob_get_clean();

		
	}

	
}

new WP_Auto_Manager_Shortcodes();