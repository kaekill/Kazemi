<?php
/**
 * Auto Package Product Type
 */
class WC_Product_Auto_Package extends WC_Product {

	/**
	 * Constructor
	 */
	public function __construct( $product ) {
		$this->product_type = 'auto_package';
		parent::__construct( $product );
	}

	/**
	 * We want to sell autos one at a time
	 * @return boolean
	 */
	public function is_sold_individually() {
		return true;
	}

	/**
	 * Auto Packages can always be purchased regardless of price.
	 * @return boolean
	 */
	public function is_purchasable() {
		return true;
	}

	/**
	 * Autos are always virtual
	 * @return boolean
	 */
	public function is_virtual() {
		return true;
	}

	/**
	 * Return auto listing duration granted
	 * @return int
	 */
	public function get_duration() {
		if ( $this->auto_listing_duration )
			return $this->auto_listing_duration;
		else
			return get_option( 'auto_manager_submission_duration' );
	}

	/**
	 * Return auto listing limit
	 * @return int
	 */
	public function get_limit() {
		if ( $this->auto_listing_limit )
			return $this->auto_listing_limit;
		else
			return 1;
	}

}