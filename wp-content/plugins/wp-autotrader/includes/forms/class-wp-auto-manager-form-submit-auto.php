<?php

/**
 * WP_Auto_Manager_Form_Submit_Auto class.
 */
class WP_Auto_Manager_Form_Submit_Auto extends WP_Auto_Manager_Form {

	public    static $form_name = 'submit-auto';
	protected static $auto_id;
	protected static $preview_auto;
	protected static $steps;
	protected static $step = 0;

	/**
	 * Init form
	 */
	public static function init() {
		add_action( 'wp', array( __CLASS__, 'process' ) );

		self::$steps  = (array) apply_filters( 'submit_auto_steps', array(
			'submit' => array(
				'name'     => __( 'Submit Details', 'auto_manager' ),
				'view'     => array( __CLASS__, 'submit' ),
				'handler'  => array( __CLASS__, 'submit_handler' ),
				'priority' => 10
				),
			'preview' => array(
				'name'     => __( 'Preview', 'auto_manager' ),
				'view'     => array( __CLASS__, 'preview' ),
				'handler'  => array( __CLASS__, 'preview_handler' ),
				'priority' => 20
			),
			'done' => array(
				'name'     => __( 'Done', 'auto_manager' ),
				'view'     => array( __CLASS__, 'done' ),
				'priority' => 30
			)
		) );

		uasort( self::$steps, array( __CLASS__, 'sort_by_priority' ) );

		// Get step/auto
		if ( ! empty( $_REQUEST['step'] ) ) {
			self::$step = is_numeric( $_REQUEST['step'] ) ? max( absint( $_REQUEST['step'] ), 0 ) : array_search( $_REQUEST['step'], array_keys( self::$steps ) );
		}
		self::$auto_id = ! empty( $_REQUEST['auto_id'] ) ? absint( $_REQUEST[ 'auto_id' ] ) : 0;

		// Validate auto ID if set
		if ( self::$auto_id && ! in_array( get_post_status( self::$auto_id ), apply_filters( 'auto_manager_valid_submit_auto_statuses', array( 'preview' ) ) ) ) {
			self::$auto_id = 0;
			self::$step   = 0;
		}
	}

	/**
	 * Get step from outside of the class
	 */
	public static function get_step() {
		return self::$step;
	}

	/**
	 * Increase step from outside of the class
	 */
	public static function next_step() {
		self::$step ++;
	}

	/**
	 * Decrease step from outside of the class
	 */
	public static function previous_step() {
		self::$step --;
	}

	/**
	 * Sort array by priority value
	 */
	private static function sort_by_priority( $a, $b ) {
		return $a['priority'] - $b['priority'];
	}

	/**
	 * Get the submitted auto ID
	 * @return int
	 */
	public static function get_auto_id() {
		return absint( self::$auto_id );
	}

	/**
	 * init_fields function.
	 *
	 * @access public
	 * @return void
	 */
	public static function init_fields() {
		
		$features_required = false;
		$is_mileage = false;
		$is_capacity = false;
		$is_motor = false;
		$is_consumption = false;
		$is_emission = false;
		$is_doors = false;
		$is_date = false;
		$is_featured_image = false;
		$is_image1 = false;
		$is_image2 = false;
		$is_image3 = false;
		$is_image4 = false;
		$is_image5 = false;
		$is_address = false;


		if(get_field('set_vehicle_features_fields_as_required','option')) {
			$features_required = true;
		}

		if(get_field('set_mileage_as_required','option')) {
			$is_mileage = true;
		}

		if(get_field('set_motor_capacity_as_required','option')) {
			$is_capacity = true;
		}

		if(get_field('set_motor_power_fields_as_required','option')) {
			$is_motor = true;
		}

		if(get_field('set_consumption_field_as_required','option')) {
			$is_consumption = true;
		}

		if(get_field('set_emission_class_field_as_required','option')) {
			$is_emission = true;
		}

		if(get_field('set_doors_field_as_required','option')) {
			$is_doors = true;
		}

		if(get_field('set_registration_date_field_as_required','option')) {
			$is_date = true;
		}

		if(get_field('set_featured_image_field_as_required','option')) {
			$is_featured_image = true;
		}

		if(get_field('set_additional_image_1_as_required','option')) {
			$is_image1 = true;
		}
		if(get_field('set_additional_image_2_as_required','option')) {
			$is_image2 = true;
		}
		if(get_field('set_additional_image_3_as_required','option')) {
			$is_image3 = true;
		}
		if(get_field('set_additional_image_4_as_required','option')) {
			$is_image4 = true;
		}
		if(get_field('set_additional_image_5_as_required','option')) {
			$is_image5 = true;
		}

		if(get_field('set_vehicle_address_field_as_required','option')) {
			$is_address = true;
		}

		if ( self::$fields )
			return;

		self::$fields = apply_filters( 'submit_auto_form_fields', array(
			'auto' => array(

				'auto_title' => array(
					'label'       => __( 'Enter Vehicle Title', 'auto_manager' ),
					'type'        => 'text',
					'required'    => true,
					'placeholder' => '',
					'priority'    => 1
				),
				'price' => array(
					'label'       => __( 'Enter Vehicle Price Without Currency', 'auto_manager' ),
					'type'        => 'text',
					'required'    => true,
					'placeholder' => '',
					'priority'    => 2
				),
				'auto_description' => array(
					'label'       => __( 'Enter Vehicle Description', 'auto_manager' ),
					'type'        => 'auto-description',
					'required'    => true,
					'placeholder' => '',
					'priority'    => 3
				),
				'auto_type' => array(
					'label'       => __( 'Select Vehicle Maker', 'auto_manager' ). '<i class="icon-help-circled-1 tooltip" title="'.__('Select A Brand And Then Select A Model On The Right Here.','auto_manager').'"></i>',
					'type'        => 'select',
					'required'    => true,
					'options'     => self::auto_types(),
					'taxonomy'	  => 'vehicle_model',
					'placeholder' => '',
					'priority'    => 4
				),
				'auto_category' => array(
					'label'       => __( 'Select Vehicle Model', 'auto_manager' ) . '<i class="icon-help-circled-1 tooltip" title="'.__('Select A Brand First Then Select A Model Here.','auto_manager').'"></i>',
					'type'        => 'select',
					'required'    => true,
					'options'     => self::auto_categories(),
					'taxonomy'	  => 'vehicle_model',
					'placeholder' => '',
					'priority'    => 5
				),
				'auto_fuel_type' => array(
					'label'       => __( 'Select Fuel Type', 'auto_manager' ),
					'type'        => 'select',
					'required'    => true,
					'options'     => self::auto_fuels(),
					'placeholder' => '',
					'priority'    => 6
				),
				'auto_fuel_color' => array(
					'label'       => __( 'Select Vehicle Color', 'auto_manager' ),
					'type'        => 'select',
					'required'    => true,
					'options'     => self::auto_color(),
					'placeholder' => '',
					'priority'    => 7
				),
				'auto_status' => array(
					'label'       => __( 'Select Vehicle Status', 'auto_manager' ),
					'type'        => 'select',
					'required'    => true,
					'options'     => self::auto_status(),
					'placeholder' => '',
					'priority'    => 8
				),
				'auto_gearbox' => array(
					'label'       => __( 'Select Vehicle Gear Type', 'auto_manager' ),
					'type'        => 'select',
					'required'    => true,
					'options'     => self::auto_gear(),
					'placeholder' => '',
					'priority'    => 9
				),
				'auto_country_location' => array(
					'label'       => __( 'Select Location Country', 'auto_manager' ),
					'type'        => 'select',
					'required'    => true,
					'options'     => self::auto_location(),
					'placeholder' => '',
					'priority'    => 9
				),
				'auto_years_old' => array(
					'label'       => __( 'Vehicle Age', 'auto_manager' ),
					'type'        => 'select',
					'required'    => false,
					'options'     => self::auto_years(),
					'placeholder' => '',
					'priority'    => 10
				),
				'auto_interior' => array(
					'label'       => __( 'Interior Features', 'auto_manager' ),
					'type'        => 'multiselect',
					'required'    => $features_required,
					'options'     => self::auto_interior(),
					'taxonomy'	  => 'vehicle_interior_feature',
					'placeholder' => '',
					'priority'    => 11
				),
				'auto_exterior' => array(
					'label'       => __( 'Exterior Features', 'auto_manager' ),
					'type'        => 'multiselect',
					'required'    => $features_required,
					'options'     => self::auto_exterior(),
					'taxonomy'	  => 'vehicle_exterior_feature',
					'placeholder' => '',
					'priority'    => 12
				),
				'auto_safety' => array(
					'label'       => __( 'Safety Features', 'auto_manager' ),
					'type'        => 'multiselect',
					'required'    => $features_required,
					'options'     => self::auto_safety(),
					'taxonomy'	  => 'vehicle_safety_feature',
					'placeholder' => '',
					'priority'    => 13
				),
				'auto_extra' => array(
					'label'       => __( 'Extra Features', 'auto_manager' ),
					'type'        => 'multiselect',
					'required'    => $features_required,
					'options'     => self::auto_extra(),
					'taxonomy'    => 'vehicle_extra',
					'placeholder' => '',
					'priority'    => 14
				),
			),
			'additional_fields' => array(
				'set_type' => array(
					'label'       => __( 'Vehicle Type', 'auto_manager' ),
					'type'        => 'select',
					'required'    => true,
					'options'     => self::set_type(),
					'placeholder' => '',
					'priority'    => 1
				),
				'mileage' => array(
					'label'       => __( 'Current Mileage', 'auto_manager' ),
					'type'        => 'text',
					'required'    => $is_mileage,
					'placeholder' => '',
					'priority'    => 2
				),
				'capacity' => array(
					'label'       => __( 'Motor capacity', 'auto_manager' ),
					'type'        => 'text',
					'required'    => $is_capacity,
					'placeholder' => '',
					'priority'    => 3
				),
				'power_bhp' => array(
					'label'       => __( 'Motor Power BHP', 'auto_manager' ),
					'type'        => 'text',
					'required'    => $is_motor,
					'placeholder' => '',
					'priority'    => 4
				),
				'power_kw' => array(
					'label'       => __( 'Motor Power KW', 'auto_manager' ),
					'type'        => 'text',
					'required'    => $is_motor,
					'placeholder' => '',
					'priority'    => 5
				),
				'consumption_mpg' => array(
					'label'       => __( 'Consumption', 'auto_manager' ),
					'type'        => 'text',
					'required'    => $is_consumption,
					'placeholder' => 'Consumption to 100 km',
					'priority'    => 6
				),
				'emission_class' => array(
					'label'       => __( 'Emission Class', 'auto_manager' ),
					'type'        => 'text',
					'required'    => $is_emission,
					'placeholder' => 'Ex: EURO 5 (428 g/KM)',
					'priority'    => 7
				),
				'doors' => array(
					'label'       => __( 'Doors', 'auto_manager' ),
					'type'        => 'text',
					'required'    => $is_doors,
					'placeholder' => '',
					'priority'    => 8
				),
				'registration_year' => array(
					'label'       => __( 'Registration Date', 'auto_manager' ),
					'type'        => 'text',
					'required'    => $is_date,
					'placeholder' => 'dd/mm/yyyy',
					'priority'    => 9
				),
				'discount' => array(
					'label'       => __( 'Price Discount', 'auto_manager' ),
					'type'        => 'text',
					'required'    => false,
					'placeholder' => '',
					'priority'    => 10
				),
			),
			'media_fields' => array(
				'featured_image' => array(
					'label'       => __( 'Featured Image', 'auto_manager' ),
					'type'        => 'file',
					'required'    => $is_featured_image,
					'placeholder' => '',
					'priority'    => 1
				),
				'additional_image_1' => array(
					'label'       => __( 'Additional Image 1', 'auto_manager' ),
					'type'        => 'file',
					'required'    => $is_image1,
					'placeholder' => '',
					'priority'    => 2
				),
				'additional_image_2' => array(
					'label'       => __( 'Additional Image 2', 'auto_manager' ),
					'type'        => 'file',
					'required'    => $is_image2,
					'placeholder' => '',
					'priority'    => 3
				),
				'additional_image_3' => array(
					'label'       => __( 'Additional Image 3', 'auto_manager' ),
					'type'        => 'file',
					'required'    => $is_image3,
					'placeholder' => '',
					'priority'    => 4
				),
				'additional_image_4' => array(
					'label'       => __( 'Additional Image 4', 'auto_manager' ),
					'type'        => 'file',
					'required'    => $is_image4,
					'placeholder' => '',
					'priority'    => 5
				),
				'additional_image_5' => array(
					'label'       => __( 'Additional Image 5', 'auto_manager' ),
					'type'        => 'file',
					'required'    => $is_image5,
					'placeholder' => '',
					'priority'    => 6
				),
			),
			'other_fields' => array(
				'set_address' => array(
					'label'       => __( 'Vehicle Current Address', 'auto_manager' ),
					'type'        => 'map',
					'required'    => $is_address,
					'placeholder' => '',
					'priority'    => 1
				),
			),
			
			
		) );

		
	}

	/**
	 * Get post data for fields
	 *
	 * @return array of data
	 */
	/*
	protected static function get_posted_fields() {
		self::init_fields();

		$values = array();

		foreach ( self::$fields as $group_key => $fields ) {
			foreach ( $fields as $key => $field ) {
				
				if($key == 'auto_interior') {
					//do nothing
				} else if ($key == 'auto_exterior'){
					//do nothing
				//} else if ($key == 'auto_extra'){
					//do nothing
				} else if ($key == 'auto_safety'){
					//do nothing
				} else {
					$values[ $group_key ][ $key ] = isset( $_POST[ $key ] ) ? stripslashes( $_POST[ $key ] ) : '';
				}

				switch ( $key ) {
					case 'auto_description' :
						$values[ $group_key ][ $key ] = wp_kses_post( trim( $values[ $group_key ][ $key ] ) );
					break;
					case 'auto_interior' :
						$values[ $group_key ][ $key ] = $_POST[ $key ];
					break;
					case 'auto_exterior' :
						$values[ $group_key ][ $key ] = $_POST[ $key ];
					break;
					case 'auto_extra' :
						$values[ $group_key ][ $key ] = $_POST[ $key ];
					break;
					case 'auto_safety' :
						$values[ $group_key ][ $key ] = $_POST[ $key ];
					break;
					case 'featured_image' :
						$image_url = self::upload_featured_image( 'featured_image' );
						if ( $image_url )
							$values[ $group_key ][ $key ] = $image_url;
					break;
					case 'additional_image_1' :
						$image_url = self::upload_image( 'additional_image_1' );
						if ( $image_url )
							$values[ $group_key ][ $key ] = $image_url;
					break;
					case 'additional_image_2' :
						$image_url = self::upload_image( 'additional_image_2' );
						if ( $image_url )
							$values[ $group_key ][ $key ] = $image_url;
					break;
					case 'additional_image_3' :
						$image_url = self::upload_image( 'additional_image_3' );
						if ( $image_url )
							$values[ $group_key ][ $key ] = $image_url;
					break;
					case 'additional_image_4' :
						$image_url = self::upload_image( 'additional_image_4' );
						if ( $image_url )
							$values[ $group_key ][ $key ] = $image_url;
					break;
					case 'additional_image_5' :
						$image_url = self::upload_image( 'additional_image_5' );
						if ( $image_url )
							$values[ $group_key ][ $key ] = $image_url;
					break;
					default:
						$values[ $group_key ][ $key ] = sanitize_text_field( $values[ $group_key ][ $key ] );
					break;
				}

				// Set fields value
				self::$fields[ $group_key ][ $key ]['value'] = $values[ $group_key ][ $key ];
			}
		}

		return $values;
	}*/

	/**
	 * Get post data for fields
	 *
	 * @return array of data
	 */
	protected static function get_posted_fields() {

		self::init_fields();

		$values = array();

		foreach ( self::$fields as $group_key => $fields ) {
			foreach ( $fields as $key => $field ) {
				// Get the value
				if ( method_exists( __CLASS__, "get_posted_{$field['type']}_field" ) ) :
					$values[ $group_key ][ $key ] = call_user_func( __CLASS__ . "::get_posted_{$field['type']}_field", $key, $field );
				elseif ($field['type'] == 'auto-description') :
					$values[ $group_key ][ $key ] = self::get_posted_wp_editor_field( $key, $field );
				else :
					$values[ $group_key ][ $key ] = self::get_posted_field( $key, $field );
				endif;

				// Set fields value
				self::$fields[ $group_key ][ $key ]['value'] = $values[ $group_key ][ $key ];
			}
		}

		return $values;
	}


	/**
	 * Get the value of a posted field
	 * @param  string $key
	 * @param  array $field
	 * @return string
	 */
	protected static function get_posted_field( $key, $field ) {
		return isset( $_POST[ $key ] ) ? sanitize_text_field( trim( stripslashes( $_POST[ $key ] ) ) ) : '';
	}

	/**
	 * Get the value of a posted multiselect field
	 * @param  string $key
	 * @param  array $field
	 * @return array
	 */
	protected static function get_posted_multiselect_field( $key, $field ) {
		return isset( $_POST[ $key ] ) ? array_map( 'sanitize_text_field',  $_POST[ $key ] ) : array();
	}

	/**
	 * Get the value of a posted file field
	 * @param  string $key
	 * @param  array $field
	 * @return string
	 */
	protected static function get_posted_file_field( $key, $field ) {
		return self::upload_image( $key );
	}

	/**
	 * Get the value of a posted textarea field
	 * @param  string $key
	 * @param  array $field
	 * @return string
	 */
	protected static function get_posted_textarea_field( $key, $field ) {
		return isset( $_POST[ $key ] ) ? wp_kses_post( trim( stripslashes( $_POST[ $key ] ) ) ) : '';
	}

	/**
	 * Get the value of a posted textarea field
	 * @param  string $key
	 * @param  array $field
	 * @return string
	 */
	protected static function get_posted_wp_editor_field( $key, $field ) {
		return self::get_posted_textarea_field( $key, $field );
	}

	/**
	 * Validate the posted fields
	 *
	 * @return bool on success, WP_ERROR on failure
	 */
	protected static function validate_fields( $values ) {
		foreach ( self::$fields as $group_key => $fields ) {
			foreach ( $fields as $key => $field ) {
				if ( $field['required'] && empty( $values[ $group_key ][ $key ] ) )
					return new WP_Error( 'validation-error', sprintf( __( '%s is a required field', 'auto_manager' ), $field['label'] ) );
			}
		}

		return apply_filters( 'submit_auto_form_validate_fields', true, self::$fields, $values );
	}

	/**
	 * auto_types function.
	 *
	 * @access private
	 * @return void
	 */
	private static function auto_types() {
		$options = array( '0' =>  __('Select A Maker From The List','auto_manager') );
		$terms   = get_auto_listing_types();
		foreach ( $terms as $term )
			$options[ $term->term_id ] = $term->name;
		return $options;
	}

	/**
	 * auto_types function.
	 *
	 * @access private
	 * @return void
	 */
	private static function auto_types_slug() {
		$options = array();
		$terms   = get_auto_listing_types();
		foreach ( $terms as $term )
			$options[ $term->term_slug ] = $term->name;
		return $options;
	}

	/**
	 * auto_types function.
	 *
	 * @access private
	 * @return void
	 */
	private static function auto_categories() {
		$options = array(  '0' =>  __('Select A Maker First','auto_manager'));
		$terms   = get_auto_listing_categories();
		foreach ( $terms as $term )
			$options[ $term->slug ] = $term->name;
		return $options;
	}

	/**
	 * auto_fuels function.
	 *
	 * @access private
	 * @return void
	 */
	private static function auto_fuels() {
		$options = array();
		$terms   = get_auto_listing_fuels();
		foreach ( $terms as $term )
			$options[ $term->slug ] = $term->name;
		return $options;
	}

	/**
	 * auto_color function.
	 *
	 * @access private
	 * @return void
	 */
	private static function auto_color() {
		$options = array();
		$terms   = get_auto_listing_color();
		foreach ( $terms as $term )
			$options[ $term->slug ] = $term->name;
		return $options;
	}

	/**
	 * auto_status function.
	 *
	 * @access private
	 * @return void
	 */
	private static function auto_status() {
		$options = array();
		$terms   = get_auto_listing_status();
		foreach ( $terms as $term )
			$options[ $term->slug ] = $term->name;
		return $options;
	}

	/**
	 * auto_gear function.
	 *
	 * @access private
	 * @return void
	 */
	private static function auto_gear() {
		$options = array();
		$terms   = get_auto_listing_gear();
		foreach ( $terms as $term )
			$options[ $term->slug ] = $term->name;
		return $options;
	}

	/**
	 * auto_location function.
	 *
	 * @access private
	 * @return void
	 */
	private static function auto_location() {
		$options = array();
		$terms   = get_auto_listing_location();
		foreach ( $terms as $term )
			$options[ $term->slug ] = $term->name;
		return $options;
	}

	/**
	 * auto_years function.
	 *
	 * @access private
	 * @return void
	 */
	private static function auto_years() {
		$options = array();
		$terms   = get_auto_listing_years();
		foreach ( $terms as $term )
			$options[ $term->slug ] = $term->name;
		return $options;
	}

	/**
	 * auto_interior function.
	 *
	 * @access private
	 * @return void
	 */
	private static function auto_interior() {
		$options = array();
		$terms   = get_auto_listing_interior();
		foreach ( $terms as $term )
			$options[ $term->slug ] = $term->name;
		return $options;
	}

	/**
	 * auto_exterior function.
	 *
	 * @access private
	 * @return void
	 */
	private static function auto_exterior() {
		$options = array();
		$terms   = get_auto_listing_exterior();
		foreach ( $terms as $term )
			$options[ $term->slug ] = $term->name;
		return $options;
	}

	/**
	 * auto_safety function.
	 *
	 * @access private
	 * @return void
	 */
	private static function auto_safety() {
		$options = array();
		$terms   = get_auto_listing_safety();
		foreach ( $terms as $term )
			$options[ $term->slug ] = $term->name;
		return $options;
	}

	/**
	 * auto_extra function.
	 *
	 * @access private
	 * @return void
	 */
	private static function auto_extra() {
		$options = array();
		$terms   = get_auto_listing_extra();
		foreach ( $terms as $term )
			$options[ $term->slug ] = $term->name;
		return $options;
	}

	/**
	 * auto_extra function.
	 *
	 * @access private
	 * @return void
	 */
	private static function set_type() {
		$options = array();
		$terms   = get_auto_set_type();
		foreach ( $terms as $term )
			$options[ $term->slug ] = $term->name;
		return $options;
	}

	/**
	 * Process function. all processing code if needed - can also change view if step is complete
	 */
	public static function process() {
		$keys = array_keys( self::$steps );

		if ( isset( $keys[ self::$step ] ) && is_callable( self::$steps[ $keys[ self::$step ] ]['handler'] ) ) {
			call_user_func( self::$steps[ $keys[ self::$step ] ]['handler'] );
		}
	}

	/**
	 * output function. Call the view handler.
	 */
	public static function output() {
		$keys = array_keys( self::$steps );

		self::show_errors();

		if ( isset( $keys[ self::$step ] ) && is_callable( self::$steps[ $keys[ self::$step ] ]['view'] ) ) {
			call_user_func( self::$steps[ $keys[ self::$step ] ]['view'] );
		}
	}

	/**
	 * Submit Step
	 */
	public static function submit() {
		global $auto_manager, $post;

		self::init_fields();

		// Load data if neccessary
		if ( ! empty( $_POST['edit_auto'] ) && self::$auto_id ) {
			$auto = get_post( self::$auto_id );
			foreach ( self::$fields as $group_key => $fields ) {
				foreach ( $fields as $key => $field ) {
					switch ( $key ) {
						case 'auto_title' :
							self::$fields[ $group_key ][ $key ]['value'] = $auto->post_title;
						break;
						case 'auto_description' :
							self::$fields[ $group_key ][ $key ]['value'] = $auto->post_content;
						break;
						case 'price' :
							self::$fields[ $group_key ][ $key ]['value'] = get_post_meta( $auto->ID, $key, true );
						break;
						case 'auto_type' :
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_model', array( 'fields' => 'slugs' ) ) );
						break;
						case 'auto_category' :
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_model', array( 'fields' => 'slugs' ) ) );
						break;
						case 'auto_fuel_type' :
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_fuel_type', array( 'fields' => 'slugs' ) ) );
						break;
						case 'auto_fuel_color' :
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_color', array( 'fields' => 'slugs' ) ) );
						break;
						case 'auto_status' :
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_status', array( 'fields' => 'slugs' ) ) );
						break;
						case 'auto_gearbox' :
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_gearbox', array( 'fields' => 'slugs' ) ) );
						break;
						case 'auto_country_location' :
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_location', array( 'fields' => 'slugs' ) ) );
						break;
						case 'auto_years_old' :
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_year', array( 'fields' => 'slugs' ) ) );
						break;
						case 'auto_interior' :
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_interior_feature', array( 'fields' => 'slugs' ) ) );
						break;
						case 'auto_exterior' :
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_exterior_feature', array( 'fields' => 'slugs' ) ) );
						break;
						case 'auto_safety' :
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_safety_feature', array( 'fields' => 'slugs' ) ) );
						break;
						case 'auto_extra' :
							self::$fields[ $group_key ][ $key ]['value'] = current( wp_get_object_terms( $auto->ID, 'vehicle_extra_feature', array( 'fields' => 'slugs' ) ) );
						break;
						default:
							self::$fields[ $group_key ][ $key ]['value'] = get_post_meta( $auto->ID, $key, true );
						break;
					}
				}
			}

			self::$fields = apply_filters( 'submit_auto_form_fields_get_auto_data', self::$fields, $auto );

		// Get user meta
		}

		get_auto_manager_template( 'auto-submit.php', array(
			'form'               => self::$form_name,
			'auto_id'             => self::get_auto_id(),
			'action'             => self::get_action(),
			'auto_fields'         => self::get_fields( 'auto' ),
			'additional_fields'     => self::get_fields( 'additional_fields' ),
			'media_fields'     => self::get_fields( 'media_fields' ),
			'other_fields'     => self::get_fields( 'other_fields' ),
			'form_step'          => self::$step,
			'submit_button_text' => __( 'Preview auto listing &rarr;', 'auto_manager' )
			) );
	}

	/**
	 * Submit Step is posted
	 */
	public static function submit_handler() {
		try {

			// Get posted values
			$values = self::get_posted_fields();

			if ( empty( $_POST['submit_auto'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'submit_form_posted' ) )
				return;

			// Validate required
			if ( is_wp_error( ( $return = self::validate_fields( $values ) ) ) )
				throw new Exception( $return->get_error_message() );

			// Account creation
			if ( ! is_user_logged_in() ) {
				$create_account = false;

				if ( auto_manager_enable_registration() && ! empty( $_POST['create_account_email'] ) )
					$create_account = wp_auto_manager_create_account( $_POST['create_account_email'] );

				if ( is_wp_error( $create_account ) )
					throw new Exception( $create_account->get_error_message() );
			}

			if ( auto_manager_user_requires_account() && ! is_user_logged_in() )
				throw new Exception( __( 'You must be signed in to post a new auto listing.' ) );

			// Update the auto
			self::save_auto( $values['auto']['auto_title'], $values['auto']['auto_description'] );
			self::update_auto_data( $values );

			// Successful, show next step
			self::$step ++;

		} catch ( Exception $e ) {
			self::add_error( $e->getMessage() );
			return;
		}
	}

	/**
	 * Update or create a auto listing from posted data
	 *
	 * @param  string $post_title
	 * @param  string $post_content
	 * @param  string $status
	 */
	protected static function save_auto( $post_title, $post_content, $status = 'preview' ) {
		$auto_data = apply_filters( 'submit_auto_form_save_auto_data', array(
			'post_title'     => $post_title,
			'post_content'   => $post_content,
			'post_status'    => $status,
			'post_type'      => 'vehicles',
			'comment_status' => 'closed'
		) );

		if ( self::$auto_id ) {
			$auto_data['ID'] = self::$auto_id;
			wp_update_post( $auto_data );
		} else {
			self::$auto_id = wp_insert_post( $auto_data );
		}
	}

	/**
	 * Set auto meta + terms based on posted values
	 *
	 * @param  array $values
	 */
	protected static function update_auto_data( $values ) {

		/* Update Vehicle Model Based On 2 Terms */
		$term_slug = get_term_by('slug', $values['auto']['auto_category'], 'vehicle_model');
		$term_id = $term_slug; // Lucky number :)
		$child_term = get_term( $term_id, 'vehicle_model' );
		$parent_term = get_term( $child_term->parent, 'vehicle_model' );
		$set_vehicle_model = array( $parent_term->slug, $values['auto']['auto_category'] );
		wp_set_object_terms( self::$auto_id, $set_vehicle_model , 'vehicle_model', false );

		// All Other Terms
		wp_set_object_terms( self::$auto_id, array( $values['auto']['auto_fuel_type'] ), 'vehicle_fuel_type', false );
		wp_set_object_terms( self::$auto_id, array( $values['auto']['auto_fuel_color'] ), 'vehicle_color', false );
		wp_set_object_terms( self::$auto_id, array( $values['auto']['auto_status'] ), 'vehicle_status', false );
		wp_set_object_terms( self::$auto_id, array( $values['auto']['auto_gearbox'] ), 'vehicle_gearbox', false );
		wp_set_object_terms( self::$auto_id, array( $values['auto']['auto_country_location'] ), 'vehicle_location', false );
		wp_set_object_terms( self::$auto_id, array( $values['auto']['auto_years_old'] ), 'vehicle_year', false );

		//wp_set_object_terms( self::$auto_id, $values['auto']['auto_interior'] , 'vehicle_interior_feature', false );
		wp_set_object_terms( self::$auto_id, ( is_array( $values['auto']['auto_interior'] ) ? $values['auto']['auto_interior'] : array( $values['auto']['auto_interior'] ) ), 'vehicle_interior_feature', false );
		wp_set_object_terms( self::$auto_id, $values['auto']['auto_exterior'] , 'vehicle_exterior_feature', false );
		wp_set_object_terms( self::$auto_id, $values['auto']['auto_safety'] , 'vehicle_safety_feature', false );
		//wp_set_object_terms( self::$auto_id, $values['auto']['auto_extra'] , 'vehicle_extra', false );

		wp_set_object_terms( self::$auto_id, ( is_array( $values['auto']['auto_extra'] ) ? $values['auto']['auto_extra'] : array( $values['auto']['auto_extra'] ) ), 'vehicle_extra', false );

		wp_set_object_terms( self::$auto_id, array( $values['additional_fields']['set_type'] ) , 'vehicle_type', false );

		// Custom MetaFields
		update_post_meta( self::$auto_id, 'price', $values['auto']['price'] );
		update_post_meta( self::$auto_id, 'mileage', $values['additional_fields']['mileage'] );
		update_post_meta( self::$auto_id, 'capacity', $values['additional_fields']['capacity'] );
		update_post_meta( self::$auto_id, 'power_bhp', $values['additional_fields']['power_bhp'] );
		update_post_meta( self::$auto_id, 'power_kw', $values['additional_fields']['power_kw'] );
		update_post_meta( self::$auto_id, 'discount', $values['additional_fields']['discount'] );
		update_post_meta( self::$auto_id, 'consumption_mpg', $values['additional_fields']['consumption_mpg'] );
		update_post_meta( self::$auto_id, 'consumption_mpg', $values['additional_fields']['consumption_mpg'] );
		update_post_meta( self::$auto_id, 'emission_class', $values['additional_fields']['emission_class'] );
		update_post_meta( self::$auto_id, 'doors', $values['additional_fields']['doors'] );
		update_post_meta( self::$auto_id, 'registration_year', $values['additional_fields']['registration_year'] );

		require_once(ABSPATH . 'wp-admin' . '/includes/image.php');
		require_once(ABSPATH . 'wp-admin' . '/includes/file.php');
		require_once(ABSPATH . 'wp-admin' . '/includes/media.php');
		
		/*
		if(isset($values['media_fields']['featured_image']) && !empty($values['media_fields']['featured_image'])) {
			
			media_sideload_image($values['media_fields']['featured_image'], self::$auto_id);
			$attachments = get_posts( array(
				'post_type' => 'attachment',
				'number_posts' => 1,
				'post_status' => null,
				'post_parent' => $post_id,
				'orderby' => 'post_date',
				'order' => 'DESC',) 
			);
			set_post_thumbnail( self::$auto_id, $attachments[0]->ID );

		}*/

		update_post_meta( self::$auto_id, '_thumbnail_id', $values['media_fields']['featured_image'] );
		update_field('field_5284d3935e6ft', $values['media_fields']['featured_image'], self::$auto_id);

		// Upload Images
		update_post_meta( self::$auto_id, 'additional_image_1', $values['media_fields']['additional_image_1'] );
		update_post_meta( self::$auto_id, 'additional_image_1', $values['media_fields']['additional_image_1'] );
		update_post_meta( self::$auto_id, 'additional_image_2', $values['media_fields']['additional_image_2'] );
		update_post_meta( self::$auto_id, 'additional_image_3', $values['media_fields']['additional_image_3'] );
		update_post_meta( self::$auto_id, 'additional_image_4', $values['media_fields']['additional_image_4'] );
		update_post_meta( self::$auto_id, 'additional_image_5', $values['media_fields']['additional_image_5'] );

		// Set address
		//$value_address = explode('|', $values['other_fields']['set_address']);
		//$value_address = array( 'coordinates' => $value_address[1], 'address' => $value_address[0] );
			
		//print_r();

		update_field('field_5285291966a70', $values['other_fields']['set_address'], self::$auto_id);

		update_post_meta( self::$auto_id, '_filled', 0 );
		update_post_meta( self::$auto_id, '_featured', 0 );

		/* Fix if WooCommerce is not enabled */
		if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			update_field( 'set_vehicle_as_featured', 0, self::$auto_id );
		}

		do_action( 'auto_manager_update_auto_data', self::$auto_id, $values );
	}

	/**
	 * Preview Step
	 */
	public static function preview() {
		global $auto_manager, $post;

		if ( self::$auto_id ) {

			$post = get_post( self::$auto_id );
			setup_postdata( $post );

			?>
			<div id="step-wrapper">

				<ul>

					<li>
						<div class="step-number">1</div>
						<div class="step-title"><span><?php _e('Vehicle Details','auto_manager');?></span> <br/><?php _e('Fill In All The Required Details Here.','auto_manager');?></div>
					</li>
					<li class="active-step">
						<div class="step-number">2</div>
						<div class="step-title"><span><?php _e('Review Details','auto_manager');?></span> <br/><?php _e('Review The Submitted Details Here.','auto_manager');?></div>
					</li>
					<li>
						<div class="step-number">3</div>
						<div class="step-title"><span><?php _e('Submit Vehicle','auto_manager');?></span> <br/><?php _e('Vehicle Has Been Successfully Submitted.','auto_manager');?></div>
					</li>

				</ul>	
				<div class="clear"></div>
			</div>

			<div class="clear"></div>

			<form method="post" id="auto_preview">
				<div class="auto_listing_preview_title">
					
					<input type="hidden" name="auto_id" value="<?php echo esc_attr( self::$auto_id ); ?>" />
					<input type="hidden" name="step" value="<?php echo esc_attr( self::$step ); ?>" />
					<input type="hidden" name="auto_manager_form" value="<?php echo self::$form_name; ?>" />
					<h2>
						<i class="icon-info-circled-1"></i> <?php _e( 'Confirm Submitted Details', 'auto_manager' ); ?>
					</h2>
				</div>
				<div class="auto_listing_preview single_auto_listing">
					<?php get_auto_manager_template_part( 'content-single', 'auto_listing' ); ?>
				</div>
				<div class="auto_listing_confirmation">
					<input type="submit" name="edit_auto" class="button" value="<?php _e( '&larr; Edit Vehicle Details', 'auto_manager' ); ?>" />
					<input type="submit" name="continue" id="auto_preview_submit_button" class="button" value="<?php echo apply_filters( 'submit_auto_step_preview_submit_text', __( 'Submit Vehicle &rarr;', 'auto_manager' ) ); ?>" />
				</div>
			</form>
			<?php

			wp_reset_postdata();
		}
	}

	/**
	 * Preview Step Form handler
	 */
	public static function preview_handler() {
		if ( ! $_POST )
			return;

		// Edit = show submit form again
		if ( ! empty( $_POST['edit_auto'] ) ) {
			self::$step --;
		}
		// Continue = change auto status then show next screen
		if ( ! empty( $_POST['continue'] ) ) {

			$auto = get_post( self::$auto_id );

			if ( $auto->post_status == 'preview' ) {
				$update_auto                = array();
				$update_auto['ID']          = $auto->ID;
				$update_auto['post_status'] = get_field('approval_required','option') == 1 ? 'pending' : 'publish';
				wp_update_post( $update_auto );
			}

			self::$step ++;
		}
	}

	/**
	 * Done Step
	 */
	public static function done() {
		
		do_action( 'auto_manager_auto_submitted', self::$auto_id );

		$the_auto_id = self::$auto_id;

		do_action( 'auto_manager_after_submission', $the_auto_id );

		get_auto_manager_template( 'auto-submitted.php', array( 'auto' => get_post( self::$auto_id ) ) );

	}

	/**
	 * Upload Image
	 */
	public static function upload_image( $field_key ) {

		
		include_once( ABSPATH . 'wp-admin/includes/file.php' );

		include_once( ABSPATH . 'wp-admin/includes/media.php' );

		if ( isset( $_FILES[ $field_key ] ) && ! empty( $_FILES[ $field_key ] ) && ! empty( $_FILES[ $field_key ]['name'] ) ) {
			$file   = $_FILES[ $field_key ];

			if ( $_FILES[ $field_key ]["type"] != "image/jpeg" && $_FILES[ $field_key ]["type"] != "image/gif" && $_FILES[ $field_key ]["type"] != "image/png" )
    			throw new Exception( __( 'Logo needs to be jpg, gif or png.', 'auto_manager' ) );

			//add_filter( 'upload_dir',  array( __CLASS__, 'upload_dir' ) );

			$upload = wp_handle_upload( $file, array( 'test_form' => false ) );

			if ( $upload ) {
			    $wp_filetype = $upload['type'];
			    $filename = $upload['file'];
			    $wp_upload_dir = wp_upload_dir();
			    $attachment = array(
			        'guid' => $wp_upload_dir['url'] . '/' . basename( $filename ),
			        'post_mime_type' => $wp_filetype,
			        'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
			        'post_content' => '',
			        'post_status' => 'inherit'
			    );
			    $attach_id = wp_insert_attachment( $attachment, $filename);
			}

			//remove_filter('upload_dir', array( __CLASS__, 'upload_dir' ) );

			if ( ! empty( $upload['error'] ) ) {
				throw new Exception( $upload['error'] );
			} else {
				return $attach_id;
			}
		}

	}

	/**
	 * Upload Featured Image
	 */

	public static function upload_featured_image( $field_key ) {

		include_once( ABSPATH . 'wp-admin/includes/file.php' );

		include_once( ABSPATH . 'wp-admin/includes/media.php' );

		if ( isset( $_FILES[ $field_key ] ) && ! empty( $_FILES[ $field_key ] ) && ! empty( $_FILES[ $field_key ]['name'] ) ) {
			$file   = $_FILES[ $field_key ];

			if ( $_FILES[ $field_key ]["type"] != "image/jpeg" && $_FILES[ $field_key ]["type"] != "image/gif" && $_FILES[ $field_key ]["type"] != "image/png" )
    			throw new Exception( __( 'Logo needs to be jpg, gif or png.', 'auto_manager' ) );

			add_filter( 'upload_dir',  array( __CLASS__, 'upload_dir' ) );

			$upload = wp_handle_upload( $file, array( 'test_form' => false ) );

			remove_filter('upload_dir', array( __CLASS__, 'upload_dir' ) );

			if ( ! empty( $upload['error'] ) ) {
				throw new Exception( $upload['error'] );
			} else {
				return $upload['url'];
			}
		}

	}

	/**
	 * Filter the upload directory
	 */
	public static function upload_dir( $pathdata ) {
		$subdir             = '/auto_listing_images';
		$pathdata['path']   = str_replace( $pathdata['subdir'], $subdir, $pathdata['path'] );
		$pathdata['url']    = str_replace( $pathdata['subdir'], $subdir, $pathdata['url'] );
		$pathdata['subdir'] = str_replace( $pathdata['subdir'], $subdir, $pathdata['subdir'] );
		return $pathdata;
	}
}