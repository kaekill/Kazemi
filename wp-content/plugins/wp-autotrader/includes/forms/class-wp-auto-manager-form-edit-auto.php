<?php

include_once( 'class-wp-auto-manager-form-submit-auto.php' );

/**
 * WP_Auto_Manager_Form_Edit_Auto class.
 */
class WP_Auto_Manager_Form_Edit_Auto extends WP_Auto_Manager_Form_Submit_Auto {

	public static $form_name = 'edit-auto';

	/**
	 * Constructor
	 */
	public static function init() {
		self::$auto_id = ! empty( $_REQUEST['auto_id'] ) ? absint( $_REQUEST[ 'auto_id' ] ) : 0;
	}

	/**
	 * output function.
	 *
	 * @access public
	 * @return void
	 */
	public static function output() {
		self::submit_handler();
		self::submit();
	}

	/**
	 * Submit Step
	 */
	public static function submit() {
		global $auto_manager, $post;

		$auto = get_post( self::$auto_id );

		if ( empty( self::$auto_id  ) || $auto->post_status !== 'publish' ) {
			echo wpautop( __( 'Invalid auto', 'auto_manager' ) );
			return;
		}

		self::init_fields();

		foreach ( self::$fields as $group_key => $fields ) {
			foreach ( $fields as $key => $field ) {
				switch ( $key ) {
					case 'auto_title' :
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							self::$fields[ $group_key ][ $key ]['value'] = $auto->post_title;
					break;
					case 'auto_description' :
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							self::$fields[ $group_key ][ $key ]['value'] = $auto->post_content;
					break;
					
					case 'auto_type' :
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_model', array( 'fields' => 'slugs' ) ) );
					break;
					case 'set_type':
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_type', array( 'fields' => 'slugs' ) ) );
					case 'auto_category' :
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_model', array( 'fields' => 'slugs' ) ) );
					break;
					case 'auto_fuel_type' :
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_fuel_type', array( 'fields' => 'slugs' ) ) );
					break;
					case 'auto_fuel_color' :
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_color', array( 'fields' => 'slugs' ) ) );
					break;
					case 'auto_status' :
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_status', array( 'fields' => 'slugs' ) ) );
					break;
					case 'auto_gearbox' :
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_gearbox', array( 'fields' => 'slugs' ) ) );
					break;
					case 'auto_country_location' :
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_location', array( 'fields' => 'slugs' ) ) );
					break;
					case 'auto_years_old' :
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_year', array( 'fields' => 'slugs' ) ) );
					break;
					case 'auto_interior' :
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_interior_feature', array( 'fields' => 'slugs' ) ) );
					break;
					case 'auto_exterior' :
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_exterior_feature', array( 'fields' => 'slugs' ) ) );
					break;
					case 'auto_safety' :
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_safety_feature', array( 'fields' => 'slugs' ) ) );
					break;
					case 'auto_extra' :
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_extra_feature', array( 'fields' => 'slugs' ) ) );
					break;
					case 'featured_image' :
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							self::$fields[ $group_key ][ $key ]['value'] = wp_get_attachment_url(get_post_thumbnail_id($auto->ID));
					case 'additional_image_1' :
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							if(is_numeric(get_field($key, $auto->ID))) {
								self::$fields[ $group_key ][ $key ]['value'] = wp_get_attachment_url( get_field($key, $auto->ID) );
							} else {
								self::$fields[ $group_key ][ $key ]['value'] = get_field($key, $auto->ID);
							}
					case 'additional_image_2' :
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							if(is_numeric(get_field($key, $auto->ID))) {
								self::$fields[ $group_key ][ $key ]['value'] = wp_get_attachment_url( get_field($key, $auto->ID) );
							} else {
								self::$fields[ $group_key ][ $key ]['value'] = get_field($key, $auto->ID);
							}
					case 'additional_image_3' :
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							if(is_numeric(get_field($key, $auto->ID))) {
								self::$fields[ $group_key ][ $key ]['value'] = wp_get_attachment_url( get_field($key, $auto->ID) );
							} else {
								self::$fields[ $group_key ][ $key ]['value'] = get_field($key, $auto->ID);
							}
					case 'additional_image_4' :
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							if(is_numeric(get_field($key, $auto->ID))) {
								self::$fields[ $group_key ][ $key ]['value'] = wp_get_attachment_url( get_field($key, $auto->ID) );
							} else {
								self::$fields[ $group_key ][ $key ]['value'] = get_field($key, $auto->ID);
							}
					case 'additional_image_5' :
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							if(is_numeric(get_field($key, $auto->ID))) {
								self::$fields[ $group_key ][ $key ]['value'] = wp_get_attachment_url( get_field($key, $auto->ID) );
							} else {
								self::$fields[ $group_key ][ $key ]['value'] = get_field($key, $auto->ID);
							}
					default:
						if ( ! isset( self::$fields[ $group_key ][ $key ]['value'] ) )
							self::$fields[ $group_key ][ $key ]['value'] = get_field($key, $auto->ID);
					break;
				}
			}
		}

		self::$fields = apply_filters( 'submit_auto_form_fields_get_auto_data', self::$fields, $auto );

		get_auto_manager_template( 'auto-edit.php');

		get_auto_manager_template( 'auto-submit.php', array(
			'form'               => self::$form_name,
			'auto_id'             => self::get_auto_id(),
			'action'             => self::get_action(),
			'auto_fields'         => self::get_fields( 'auto' ),
			'additional_fields'     => self::get_fields( 'additional_fields' ),
			'media_fields'     => self::get_fields( 'media_fields' ),
			'other_fields'     => self::get_fields( 'other_fields' ),
			'submit_button_text' => __( 'Update auto listing', 'auto_manager' )
			) );
	}

	/**
	 * Submit Step is posted
	 */
	public static function submit_handler() {
		if ( empty( $_POST['submit_auto'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'submit_form_posted' ) )
			return;

		try {

			// Get posted values
			$values = self::get_posted_fields();

			// Validate required
			if ( is_wp_error( ( $return = self::validate_fields( $values ) ) ) )
				throw new Exception( $return->get_error_message() );

			// Update the auto
			self::save_auto( $values['auto']['auto_title'], $values['auto']['auto_description'], 'publish' );
			self::update_auto_data( $values );

			// Successful
			echo '<div class="alert-box success ">
				<a href="#" class="icon-cancel close" data-dismiss="alert"></a>
				<div class="alert-content">' . __( 'Your changes have been saved.', 'auto_manager' ), ' <a href="' . get_permalink( self::$auto_id ) . '">' . __( 'View Vehicle Listing &rarr;', 'auto_manager' ) . '</a>' . '</div>
			</div>';

		} catch ( Exception $e ) {
			echo '<div class="auto-manager-error">' . $e->getMessage() . '</div>';
			return;
		}
	}
}