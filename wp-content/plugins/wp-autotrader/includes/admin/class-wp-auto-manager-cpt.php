<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WP_Auto_Manager_CPT class.
 */
class WP_Auto_Manager_CPT {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		add_filter( 'manage_edit-vehicles_columns', array( $this, 'columns' ) );
		add_action( 'manage_vehicles_posts_custom_column', array( $this, 'custom_columns' ), 2 );
		add_action( 'admin_footer-edit.php', array( $this, 'add_bulk_actions' ) );
		add_action( 'load-edit.php', array( $this, 'do_bulk_actions' ) );
		add_action( 'admin_init', array( $this, 'approve_auto' ) );
		add_action( 'admin_notices', array( $this, 'approved_notice' ) );

		foreach ( array( 'post', 'post-new' ) as $hook )
			add_action( "admin_footer-{$hook}.php", array( $this,'extend_submitdiv_post_status' ) );
	}

	/**
	 * Edit bulk actions
	 */
	public function add_bulk_actions() {
		global $post_type;

		if ( $post_type == 'auto_listing' ) {
			?>
			<script type="text/javascript">
		      jQuery(document).ready(function() {
		        jQuery('<option>').val('approve_autos').text('<?php _e( 'Approve Vehicles', 'auto_manager' )?>').appendTo("select[name='action']");
		        jQuery('<option>').val('approve_autos').text('<?php _e( 'Approve Vehicles', 'auto_manager' )?>').appendTo("select[name='action2']");
		      });
		    </script>
		    <?php
		}
	}

	/**
	 * Do custom bulk actions
	 */
	public function do_bulk_actions() {
		$wp_list_table = _get_list_table( 'WP_Posts_List_Table' );
		$action        = $wp_list_table->current_action();

		switch( $action ) {
			case 'approve_autos' :
				check_admin_referer( 'bulk-posts' );

				$post_ids      = array_map( 'absint', array_filter( (array) $_GET['post'] ) );
				$approved_autos = array();

				if ( ! empty( $post_ids ) )
					foreach( $post_ids as $post_id ) {
						$auto_data = array(
							'ID'          => $post_id,
							'post_status' => 'publish'
						);
						if ( get_post_status( $post_id ) == 'pending' && wp_update_post( $auto_data ) )
							$approved_autos[] = $post_id;
					}

				wp_redirect( remove_query_arg( 'approve_autos', add_query_arg( 'approved_autos', $approved_autos, admin_url( 'edit.php?post_type=vehicles' ) ) ) );
				exit;
			break;
		}

		return;
	}

	/**
	 * Approve a single auto
	 */
	public function approve_auto() {
		if ( ! empty( $_GET['approve_auto'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'], 'approve_auto' ) && current_user_can( 'edit_post', $_GET['approve_auto'] ) ) {
			$post_id = absint( $_GET['approve_auto'] );
			$auto_data = array(
				'ID'          => $post_id,
				'post_status' => 'publish'
			);
			wp_update_post( $auto_data );
			wp_redirect( remove_query_arg( 'approve_auto', add_query_arg( 'approved_autos', $post_id, admin_url( 'edit.php?post_type=vehicles' ) ) ) );
			exit;
		}
	}

	/**
	 * Show a notice if we did a bulk action or approval
	 */
	public function approved_notice() {
		 global $post_type, $pagenow;

		if ( $pagenow == 'edit.php' && $post_type == 'vehicles' && ! empty( $_REQUEST['approved_autos'] ) ) {
			$approved_autos = $_REQUEST['approved_autos'];
			if ( is_array( $approved_autos ) ) {
				$approved_autos = array_map( 'absint', $approved_autos );
				$titles        = array();
				foreach ( $approved_autos as $auto_id )
					$titles[] = get_the_title( $auto_id );
				echo '<div class="updated"><p>' . sprintf( __( '%s approved', 'auto_manager' ), '&quot;' . implode( '&quot;, &quot;', $titles ) . '&quot;' ) . '</p></div>';
			} else {
				echo '<div class="updated"><p>' . sprintf( __( '%s approved', 'auto_manager' ), '&quot;' . get_the_title( $approved_autos ) . '&quot;' ) . '</p></div>';
			}
		}
	}

	/**
	 * post_updated_messages function.
	 *
	 * @access public
	 * @param mixed $messages
	 * @return void
	 */
	public function post_updated_messages( $messages ) {
		global $post, $post_ID;

		$messages['auto_listing'] = array(
			0 => '',
			1 => sprintf( __( 'Vehicle listing updated. <a href="%s">View Vehicle</a>', "auto_manager" ), esc_url( get_permalink( $post_ID ) ) ),
			2 => __( 'Custom field updated.', "auto_manager" ),
			3 => __( 'Custom field deleted.', "auto_manager" ),
			4 => __( 'Vehicle listing updated.', "auto_manager" ),
			5 => isset( $_GET['revision'] ) ? sprintf( __( 'Vehicle listing restored to revision from %s', "auto_manager" ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __( 'Vehicle listing published. <a href="%s">View Vehicle</a>', "auto_manager" ), esc_url( get_permalink( $post_ID ) ) ),
			7 => __('Vehicle listing saved.', "auto_manager"),
			8 => sprintf( __( 'Vehicle listing submitted. <a target="_blank" href="%s">Preview Vehicle</a>', "auto_manager" ), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
			9 => sprintf( __( 'Vehicle listing scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Vehicle</a>', "auto_manager" ),
			  date_i18n( __( 'M j, Y @ G:i', "auto_manager" ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
			10 => sprintf( __( 'Vehicle listing draft updated. <a target="_blank" href="%s">Preview Vehicle</a>', "auto_manager" ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
		);

		return $messages;
	}

	/**
	 * columns function.
	 *
	 * @access public
	 * @param mixed $columns
	 * @return void
	 */
	public function columns( $columns ) {
		if ( ! is_array( $columns ) )
			$columns = array();

		unset( $columns['comments'], $columns['date'] );

		$columns["auto_expires"]          = __( "Expires", "auto_manager" );
		$columns['auto_status']           = __( "Status", "auto_manager" );
		$columns['auto_actions']          = __( "Actions", "auto_manager" );

		return $columns;
	}

	/**
	 * custom_columns function.
	 *
	 * @access public
	 * @param mixed $column
	 * @return void
	 */
	public function custom_columns( $column ) {
		global $post, $auto_manager;

		switch ( $column ) {
			
			case "auto_expires" :
				if ( $post->_auto_expires )
					echo '<strong>' . date_i18n( __( 'M j, Y', 'auto_manager' ), strtotime( $post->_auto_expires ) ) . '</strong>';
				else
					echo '&ndash;';
			break;
			case "auto_status" :
				echo get_the_auto_status( $post );
			break;
			case "auto_actions" :
				echo '<div class="actions">';
				$admin_actions           = array();
				if ( $post->post_status == 'pending' ) {
					$admin_actions['approve']   = array(
						'action'  => 'approve',
						'name'    => __( 'Approve', 'auto_manager' ),
						'url'     =>  wp_nonce_url( add_query_arg( 'approve_auto', $post->ID ), 'approve_auto' )
					);
				}
				if ( $post->post_status !== 'trash' ) {
					$admin_actions['view']   = array(
						'action'  => 'view',
						'name'    => __( 'View', 'auto_manager' ),
						'url'     => get_permalink( $post->ID )
					);
					$admin_actions['edit']   = array(
						'action'  => 'edit',
						'name'    => __( 'Edit', 'auto_manager' ),
						'url'     => get_edit_post_link( $post->ID )
					);
					$admin_actions['delete'] = array(
						'action'  => 'delete',
						'name'    => __( 'Delete', 'auto_manager' ),
						'url'     => get_delete_post_link( $post->ID )
					);
				}

				$admin_actions = apply_filters( 'auto_manager_admin_actions', $admin_actions, $post );

				foreach ( $admin_actions as $action ) {
					$image = isset( $action['image_url'] ) ? $action['image_url'] : AUTO_MANAGER_PLUGIN_URL . '/assets/images/icons/' . $action['action'] . '.png';
					printf( '<a class="button tips" href="%s" data-tip="%s"><img src="%s" alt="%s" width="14" /></a>', esc_url( $action['url'] ), esc_attr( $action['name'] ), esc_attr( $image ), esc_attr( $action['name'] ) );
				}

				echo '</div>';

			break;
		}
	}

    /**
	 * Adds post status to the "submitdiv" Meta Box and post type WP List Table screens. Based on https://gist.github.com/franz-josef-kaiser/2930190
	 *
	 * @return void
	 */
	public function extend_submitdiv_post_status() {
		global $wp_post_statuses, $post, $post_type;

		// Abort if we're on the wrong post type, but only if we got a restriction
		if ( 'vehicles' !== $post_type ) {
			return;
		}

		// Get all non-builtin post status and add them as <option>
		$options = $display = '';
		foreach ( $wp_post_statuses as $status )
		{
			if ( ! $status->_builtin ) {
				// Match against the current posts status
				$selected = selected( $post->post_status, $status->name, false );

				// If we one of our custom post status is selected, remember it
				$selected AND $display = $status->label;

				// Build the options
				$options .= "<option{$selected} value='{$status->name}'>{$status->label}</option>";
			}
		}
		?>
		<script type="text/javascript">
			jQuery( document ).ready( function($)
			{
				<?php
				// Add the selected post status label to the "Status: [Name] (Edit)"
				if ( ! empty( $display ) ) :
				?>
					$( '#post-status-display' ).html( '<?php echo $display; ?>' )
				<?php
				endif;

				// Add the options to the <select> element
				?>
				var select = $( '#post-status-select' ).find( 'select' );
				$( select ).append( "<?php echo $options; ?>" );
			} );
		</script>
		<?php
	}
}

new WP_Auto_Manager_CPT();