<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WP_Auto_Manager_Settings class.
 */
class WP_Auto_Manager_Settings {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		$this->settings_group = 'auto_manager';
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * init_settings function.
	 *
	 * @access protected
	 * @return void
	 */
	protected function init_settings() {
		$this->settings = apply_filters( 'auto_manager_settings',
			array(
				'auto_listings' => array(
					__( 'Auto Listings', 'auto_manager' ),
					array(
						array(
							'name'        => 'auto_manager_per_page',
							'std'         => '10',
							'placeholder' => '',
							'label'       => __( 'Autos per page', 'auto_manager' ),
							'desc'        => __( 'How many autos should be shown per page by default?', 'auto_manager' ),
							'attributes'  => array()
						),
						array(
							'name'       => 'auto_manager_hide_filled_positions',
							'std'        => '0',
							'label'      => __( 'Filled positions', 'auto_manager' ),
							'cb_label'   => __( 'Hide filled positions', 'auto_manager' ),
							'desc'       => __( 'If enabled, filled positions will be hidden from the auto list.', 'auto_manager' ),
							'type'       => 'checkbox',
							'attributes' => array()
						),
						array(
							'name'       => 'auto_manager_enable_categories',
							'std'        => '0',
							'label'      => __( 'Auto categories', 'auto_manager' ),
							'cb_label'   => __( 'Enable auto categories', 'auto_manager' ),
							'desc'       => __( 'Choose whether to enable auto categories. Categories must be setup by an admin for users to choose during auto submission.', 'auto_manager' ),
							'type'       => 'checkbox',
							'attributes' => array()
						),
					),
				),
				'auto_submission' => array(
					__( 'Auto Submission', 'auto_manager' ),
					array(
						array(
							'name'       => 'auto_manager_enable_registration',
							'std'        => '1',
							'label'      => __( 'Account creation', 'auto_manager' ),
							'cb_label'   => __( 'Allow account creation', 'auto_manager' ),
							'desc'       => __( 'If enabled, non-logged in users will be able to create an account by entering their email address on the auto submission form.', 'auto_manager' ),
							'type'       => 'checkbox',
							'attributes' => array()
						),
						array(
							'name'       => 'auto_manager_user_requires_account',
							'std'        => '1',
							'label'      => __( 'Account required', 'auto_manager' ),
							'cb_label'   => __( 'Auto submission requires an account', 'auto_manager' ),
							'desc'       => __( 'If disabled, non-logged in users will be able to submit auto listings without creating an account.', 'auto_manager' ),
							'type'       => 'checkbox',
							'attributes' => array()
						),
						array(
							'name'       => 'auto_manager_submission_requires_approval',
							'std'        => '1',
							'label'      => __( 'Approval Required', 'auto_manager' ),
							'cb_label'   => __( 'New submissions require admin approval', 'auto_manager' ),
							'desc'       => __( 'If enabled, new submissions will be inactive, pending admin approval.', 'auto_manager' ),
							'type'       => 'checkbox',
							'attributes' => array()
						),
						array(
							'name'       => 'auto_manager_submission_duration',
							'std'        => '30',
							'label'      => __( 'Listing duration', 'auto_manager' ),
							'desc'       => __( 'How many <strong>days</strong> listings are live before expiring. Can be left blank to never expire.', 'auto_manager' ),
							'attributes' => array()
						),
						array(
							'name' 		=> 'auto_manager_submit_page_slug',
							'std' 		=> '',
							'label' 	=> __( 'Submit Page Slug', 'auto_manager' ),
							'desc'		=> __( 'Enter the slug of the page where you have placed the [submit_auto_form] shortcode. This lets the plugin know where the form is located.', 'auto_manager' ),
							'type'      => 'input'
						)
					)
				),
			)
		);
	}

	/**
	 * register_settings function.
	 *
	 * @access public
	 * @return void
	 */
	public function register_settings() {
		$this->init_settings();

		foreach ( $this->settings as $section ) {
			foreach ( $section[1] as $option ) {
				if ( isset( $option['std'] ) )
					add_option( $option['name'], $option['std'] );
				register_setting( $this->settings_group, $option['name'] );
			}
		}
	}

	/**
	 * output function.
	 *
	 * @access public
	 * @return void
	 */
	public function output() {
		$this->init_settings();
		?>
		<div class="wrap">
			<form method="post" action="options.php">

				<?php settings_fields( $this->settings_group ); ?>
				<?php screen_icon(); ?>

			    <h2 class="nav-tab-wrapper">
			    	<?php
			    		foreach ( $this->settings as $key => $section ) {
			    			echo '<a href="#settings-' . sanitize_title( $key ) . '" class="nav-tab">' . esc_html( $section[0] ) . '</a>';
			    		}
			    	?>
			    </h2><br/>

				<?php
					if ( ! empty( $_GET['settings-updated'] ) ) {
						flush_rewrite_rules();
						echo '<div class="updated fade"><p>' . __( 'Settings successfully saved', 'auto_manager' ) . '</p></div>';
					}

					foreach ( $this->settings as $key => $section ) {

						echo '<div id="settings-' . sanitize_title( $key ) . '" class="settings_panel">';

						echo '<table class="form-table">';

						foreach ( $section[1] as $option ) {

							$placeholder    = ( ! empty( $option['placeholder'] ) ) ? 'placeholder="' . $option['placeholder'] . '"' : '';
							$class          = ! empty( $option['class'] ) ? $option['class'] : '';
							$value          = get_option( $option['name'] );
							$option['type'] = ! empty( $option['type'] ) ? $option['type'] : '';
							$attributes     = array();

							if ( ! empty( $option['attributes'] ) && is_array( $option['attributes'] ) )
								foreach ( $option['attributes'] as $attribute_name => $attribute_value )
									$attributes[] = esc_attr( $attribute_name ) . '="' . esc_attr( $attribute_value ) . '"';

							echo '<tr valign="top" class="' . $class . '"><th scope="row"><label for="setting-' . $option['name'] . '">' . $option['label'] . '</a></th><td>';

							switch ( $option['type'] ) {

								case "checkbox" :

									?><label><input id="setting-<?php echo $option['name']; ?>" name="<?php echo $option['name']; ?>" type="checkbox" value="1" <?php echo implode( ' ', $attributes ); ?> <?php checked( '1', $value ); ?> /> <?php echo $option['cb_label']; ?></label><?php

									if ( $option['desc'] )
										echo ' <p class="description">' . $option['desc'] . '</p>';

								break;
								case "textarea" :

									?><textarea id="setting-<?php echo $option['name']; ?>" class="large-text" cols="50" rows="3" name="<?php echo $option['name']; ?>" <?php echo implode( ' ', $attributes ); ?> <?php echo $placeholder; ?>><?php echo esc_textarea( $value ); ?></textarea><?php

									if ( $option['desc'] )
										echo ' <p class="description">' . $option['desc'] . '</p>';

								break;
								case "select" :

									?><select id="setting-<?php echo $option['name']; ?>" class="regular-text" name="<?php echo $option['name']; ?>" <?php echo implode( ' ', $attributes ); ?>><?php
										foreach( $option['options'] as $key => $name )
											echo '<option value="' . esc_attr( $key ) . '" ' . selected( $value, $key, false ) . '>' . esc_html( $name ) . '</option>';
									?></select><?php

									if ( $option['desc'] )
										echo ' <p class="description">' . $option['desc'] . '</p>';

								break;
								case "password" :

									?><input id="setting-<?php echo $option['name']; ?>" class="regular-text" type="password" name="<?php echo $option['name']; ?>" value="<?php esc_attr_e( $value ); ?>" <?php echo implode( ' ', $attributes ); ?> <?php echo $placeholder; ?> /><?php

									if ( $option['desc'] )
										echo ' <p class="description">' . $option['desc'] . '</p>';

								break;
								default :

									?><input id="setting-<?php echo $option['name']; ?>" class="regular-text" type="text" name="<?php echo $option['name']; ?>" value="<?php esc_attr_e( $value ); ?>" <?php echo implode( ' ', $attributes ); ?> <?php echo $placeholder; ?> /><?php

									if ( $option['desc'] )
										echo ' <p class="description">' . $option['desc'] . '</p>';

								break;

							}

							echo '</td></tr>';
						}

						echo '</table></div>';

					}
				?>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'auto_manager' ); ?>" />
				</p>
		    </form>
		</div>
		<script type="text/javascript">
			jQuery('.nav-tab-wrapper a').click(function() {
				jQuery('.settings_panel').hide();
				jQuery('.nav-tab-active').removeClass('nav-tab-active');
				jQuery( jQuery(this).attr('href') ).show();
				jQuery(this).addClass('nav-tab-active');
				return false;
			});

			jQuery('.nav-tab-wrapper a:first').click();
		</script>
		<?php
	}
}