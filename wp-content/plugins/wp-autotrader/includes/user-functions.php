<?php
/**
 * Get a users packages from the DB
 * @param  int $user_id
 * @return array of objects
 */
function get_user_auto_packages( $user_id ) {
	global $wpdb;

	$packages = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}user_auto_packages WHERE user_id = %d AND auto_count < auto_limit;", $user_id ), OBJECT_K );

	return $packages;
}

/**
 * Get a package
 * @param  int $package_id
 * @return object
 */
function get_user_auto_package( $package_id ) {
	global $wpdb;

	return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}user_auto_packages WHERE id = %d;", $package_id ) );
}

/**
 * Give a user a package
 * @param  int $user_id
 * @param  int $product_id
 * @return int|bool false
 */
function give_user_auto_package( $user_id, $product_id ) {
	global $wpdb;

	$package = get_product( $product_id );

	if ( ! $package->is_type( 'auto_package' ) )
		return false;

	$wpdb->insert(
		"{$wpdb->prefix}user_auto_packages",
		array(
			'user_id'      => $user_id,
			'product_id'   => $product_id,
			'auto_count'    => 0,
			'auto_duration' => $package->get_duration(),
			'auto_limit'    => $package->get_limit(),
			'auto_featured' => ( $package->auto_listing_featured == 'yes' ? 1 : 0 )
		),
		array(
			'%d',
			'%d',
			'%d',
			'%d',
			'%d',
			'%d'
		)
	);

	return $wpdb->insert_id;
}

/**
 * Increase auto count for package
 * @param  int $user_id
 * @param  int $package_id
 * @return int affected rows
 */
function increase_auto_package_auto_count( $user_id, $package_id ) {
	global $wpdb;

	$packages = get_user_auto_packages( $user_id );

	if ( isset( $packages[ $package_id ] ) ) {
		$new_count = $packages[ $package_id ]->auto_count + 1;
	} else {
		$new_count = 1;
	}

	return $wpdb->update(
		"{$wpdb->prefix}user_auto_packages",
		array(
			'auto_count' => $new_count,
		),
		array(
			'user_id' => $user_id,
			'id'      => $package_id
		),
		array( '%d' ),
		array( '%d', '%d' )
	);

	return false;
}

/**
 * See if a package is valid for use
 * @return bool
 */
function user_auto_package_is_valid( $user_id, $package_id ) {
	global $wpdb;

	$package = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}user_auto_packages WHERE user_id = %d AND id = %d;", $user_id, $package_id ) );

	if ( ! $package )
		return false;

	if ( $package->auto_count >= $package->auto_limit )
		return false;

	return true;
}