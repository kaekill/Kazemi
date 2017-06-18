<?php
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * Orders
 */
class WP_Auto_Manager_WCPL_Forms {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
		add_filter( 'submit_auto_steps', array( $this, 'submit_auto_steps' ), 10 );
		add_filter( 'submit_auto_step_preview_submit_text', array( $this, 'submit_button_text' ), 10 );
	}

	/**
	 * Add form styles
	 */
	public function styles() {
		wp_enqueue_style( 'wc-paid-listings-packages', AUTO_MANAGER_WCPL_PLUGIN_URL . '/assets/css/packages.css' );
	}

	/**
	 * Change the steps during the submission process
	 *
	 * @param  array $steps
	 * @return array
	 */
	public function submit_auto_steps( $steps ) {
		// We need to hijack the preview submission so we can take a payment
		$steps['preview']['handler'] = array( $this, 'preview_handler' );

		// Add the payment step
		$steps['wc-pay'] = array(
			'name'     => __( 'Choose a package', auto_manager ),
			'view'     => array( __CLASS__, 'choose_package' ),
			'handler'  => array( __CLASS__, 'choose_package_handler' ),
			'priority' => 25
		);

		return $steps;
	}

	/**
	 * [choose_package description]
	 * @return [type]
	 */
	public static function choose_package() {
		// get auto listing packages
		$packages = get_posts( array(
			'post_type'  => 'product',
			'posts_per_page'      => -1,
			'tax_query'  => array(
				array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => 'auto_package'
				)
			)
		) );
		$user_packages = get_user_auto_packages( get_current_user_id() );
		?>
		<div id="step-wrapper">

			<ul>

				<li>
					<div class="step-number">1</div>
					<div class="step-title"><span><?php _e('Vehicle Details',auto_manager);?></span> <br/><?php _e('Fill In All The Required Details Here.',auto_manager);?></div>
				</li>
				<li>
					<div class="step-number">2</div>
					<div class="step-title"><span><?php _e('Review Details',auto_manager);?></span> <br/><?php _e('Review The Submitted Details Here.',auto_manager);?></div>
				</li>
				<li class="active-step">
					<div class="step-number">3</div>
					<div class="step-title"><span><?php _e('Submit Vehicle',auto_manager);?></span> <br/><?php _e('Select Package And Submit Vehicle.',auto_manager);?></div>
				</li>

			</ul>	
			<div class="clear"></div>

		</div>
		<form method="post" id="auto_package_selection">
			<div class="auto_listing_packages_title">
				<input type="hidden" name="auto_id" value="<?php echo esc_attr( WP_Auto_Manager_Form_Submit_Auto::get_auto_id() ); ?>" />
				<input type="hidden" name="step" value="<?php echo esc_attr( WP_Auto_Manager_Form_Submit_Auto::get_step() ); ?>" />
				<input type="hidden" name="auto_manager_form" value="<?php echo WP_Auto_Manager_Form_Submit_Auto::$form_name; ?>" />
				<h2><i class="icon-help-circled-1"></i> <?php _e( 'Select A Package From The List', auto_manager ); ?></h2>
			</div>
			<div class="auto_listing_packages">
				<?php get_auto_manager_template( 'package-selection.php', array( 'packages' => $packages, 'user_packages' => $user_packages ), 'auto_manager_wc_paid_listings', AUTO_MANAGER_WCPL_PLUGIN_DIR . '/templates/' ); ?>
				<input type="submit" name="continue" class="button" id="checkout-package-button" value="<?php echo apply_filters( 'submit_auto_step_choose_package_submit_text', __( 'Complete Submission &rarr;', auto_manager ) ); ?>" />
			</div>
		</form>
		<?php
	}

	/**
	 * Change submit button text
	 * @return string
	 */
	public function submit_button_text() {
		return __( 'Proceed To Checkout &rarr;', auto_manager );
	}

	/**
	 * [choose_package_handler description]
	 * @return [type]
	 */
	public static function choose_package_handler() {
		global $woocommerce;

		// Get and validate package
		if ( is_numeric( $_POST['auto_package'] ) )
			$auto_package_id = absint( $_POST['auto_package'] );
		else
			$user_auto_package_id = absint( substr( $_POST['auto_package'], 5 ) );

		// Get auto ID
		$auto_id = WP_Auto_Manager_Form_Submit_Auto::get_auto_id();

		if ( ! empty( $auto_package_id ) ) {
			$auto_package = get_product( $auto_package_id );

			if ( ! $auto_package->is_type( 'auto_package' ) ) {
				WP_Auto_Manager_Form_Submit_Auto::add_error( __( 'Invalid Package', auto_manager ) );
				return;
			}

			// Give auto the package attributes
			update_post_meta( $auto_id, '_auto_duration', $auto_package->get_duration() );
			update_post_meta( $auto_id, 'set_vehicle_as_featured', $auto_package->auto_listing_featured == 'yes' ? 1 : 0 );

			// Add package to the cart
			$woocommerce->cart->add_to_cart( $auto_package_id, 1, '', '', array(
				'auto_id' => $auto_id
			) );

			woocommerce_add_to_cart_message( $auto_package_id );

			// Redirect to checkout page
			wp_redirect( get_permalink( woocommerce_get_page_id( 'checkout' ) ) );
			exit;
		} elseif ( $user_auto_package_id && user_auto_package_is_valid( get_current_user_id(), $user_auto_package_id ) ) {
			$auto = get_post( $auto_id );

			// Give auto the package attributes
			$auto_package = get_user_auto_package( $user_auto_package_id );
			update_post_meta( $auto_id, '_auto_duration', $auto_package->auto_duration );
			update_post_meta( $auto_id, 'set_vehicle_as_featured', $auto_package->auto_featured );

			// Approve the auto
			if ( $auto->post_status == 'pending_payment' ) {
				approve_paid_auto_listing_with_package( $auto->ID, get_current_user_id(), $user_auto_package_id );
			}

			WP_Auto_Manager_Form_Submit_Auto::next_step();
		} else {
			WP_Auto_Manager_Form_Submit_Auto::add_error( __( 'Invalid Package', auto_manager ) );
			return;
		}
	}

	/**
	 * Handle the form when the preview page is submitted
	 */
	public function preview_handler() {
		if ( ! $_POST )
			return;

		// Edit = show submit form again
		if ( ! empty( $_POST['edit_auto'] ) ) {
			WP_Auto_Manager_Form_Submit_Auto::previous_step();
		}

		// Continue = Take Payment
		if ( ! empty( $_POST['continue'] ) ) {

			$auto = get_post( WP_Auto_Manager_Form_Submit_Auto::get_auto_id() );

			if ( $auto->post_status == 'preview' ) {
				$update_auto                = array();
				$update_auto['ID']          = $auto->ID;
				$update_auto['post_status'] = 'pending_payment';
				wp_update_post( $update_auto );
			}

			WP_Auto_Manager_Form_Submit_Auto::next_step();
		}
	}
}

new WP_Auto_Manager_WCPL_Forms();