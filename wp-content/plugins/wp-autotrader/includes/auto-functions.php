<?php
/**
 * Approve a auto listing
 * @param  int $auto_id
 * @param  int $user_id
 * @param  int $user_package_id
 */
function approve_paid_auto_listing_with_package( $auto_id, $user_id, $user_package_id ) {
	$update_auto                = array();
	$update_auto['ID']          = $auto_id;
	$update_auto['post_status'] = get_field('approval_required','option') ? 'pending' : 'publish';
	wp_update_post( $update_auto );
	increase_auto_package_auto_count( $user_id, $user_package_id );
}