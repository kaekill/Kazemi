<?php
/**
 * My Packages
 *
 * Shows packages on the account page
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<h2><?php echo apply_filters( 'woocommerce_my_account_auto_packages_title', __( 'My auto packages', auto_manager ) ); ?></h2>

<table class="shop_table my_account_auto_packages">
	<thead>
		<tr>
			<th scope="col"><?php _e( 'Package Name', auto_manager ); ?></th>
			<th scope="col"><?php _e( 'Allowance Remaining', auto_manager ); ?></th>
			<th scope="col"><?php _e( 'Listing Duration', auto_manager ); ?></th>
			<th scope="col"><?php _e( 'Featured?', auto_manager ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ( $packages as $package ) : ?>
			<tr>
				<td><?php
					$product = get_post( $package->product_id );
					if ( $product )
						echo $product->post_title;
					else
						echo '-';
				?></td>
				<td><?php echo absint( $package->auto_limit - $package->auto_count ); ?></td>
				<td><?php echo sprintf( __( '%d day', '%d days', $package->auto_duration, auto_manager ), $package->auto_duration ); ?></td>
				<td><?php if ( $package->auto_featured ) _e( 'Yes', auto_manager ); else _e( 'No', auto_manager ); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>