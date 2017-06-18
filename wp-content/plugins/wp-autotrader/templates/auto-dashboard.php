<div id="auto-manager-auto-dashboard">

	<?php 

		if(get_field('enable_favorites_system','option')) {

			tdp_fav_list_favorite_posts(); 

		}

	?>

	<h2><i class="icon-list-numbered"></i> <?php _e( 'Submitted Vehicles', 'auto_manager' ); ?></h2>
	<br/>
	<div class="alert-box info ">
		<a href="#" class="icon-cancel close" data-dismiss="alert"></a>
		<div class="alert-content"><?php _e( 'Your vehicle listings are shown in the table below. Expired listings will be automatically removed after 30 days.', 'auto_manager' ); ?></div>
	</div>

	<table class="auto-manager-autos sf-table striped_bordered">
		<thead>
			<tr>
				<th class="auto_title"><?php _e( 'Vehicle Title', 'auto_manager' ); ?></th>
				<th class="date"><?php _e( 'Date Posted', 'auto_manager' ); ?></th>
				<th class="status"><?php _e( 'Status', 'auto_manager' ); ?></th>
				<th class="expires"><?php _e( 'Expires', 'auto_manager' ); ?></th>
				<th class="filled"><?php _e( 'Actions', 'auto_manager' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php if ( ! $autos ) : ?>
				<tr>
					<td colspan="6"><?php _e( 'You do not have any active listings.', 'auto_manager' ); ?></td>
				</tr>
			<?php else : ?>
				<?php foreach ( $autos as $auto ) : ?>
					<tr>
						<td class="auto_title">
							<a href="<?php echo get_permalink( $auto->ID ); ?>"><?php echo $auto->post_title; ?></a>
						</td>
						<td class="date"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $auto->post_date ) ); ?></td>
						<td class="status"><?php the_auto_status( $auto ); ?></td>
						<td class="expires"><?php
							$expires = $auto->_auto_expires;

							echo $expires ? date_i18n( get_option( 'date_format' ), strtotime( $expires ) ) : '&ndash;';
						?></td>
						<td class="filled">
							<ul class="auto-dashboard-actions">
								<?php
									$actions = array();

									switch ( $auto->post_status ) {
										case 'publish' :
											
											$actions['edit'] = array( 'icon' =>'icon-pencil', 'label' => __( 'Edit', 'auto_manager' ), 'nonce' => false, 'edit-vehicle' => true );

											break;
									}

									$actions['delete'] = array( 'icon' =>'icon-cancel', 'label' => __( 'Delete', 'auto_manager' ), 'nonce' => true, 'edit-vehicle' => false );
									$actions           = apply_filters( 'auto_manager_my_auto_actions', $actions, $auto );

									foreach ( $actions as $action => $value ) {
										$action_url = add_query_arg( array( 'action' => $action, 'auto_id' => $auto->ID ) );
										if( $value['edit-vehicle']) {
											$action_url = get_field('edit_vehicle_page','option') . '?pid='.$auto->ID;
										}
										if ( $value['nonce'] )
											$action_url = wp_nonce_url( $action_url, 'auto_manager_my_auto_actions' );
										echo '<li><a href="' . $action_url . '" class="tooltip auto-dashboard-action-' . $action . '" title="'.$value['label'].'"><i class="' . $value['icon'] . '"></i></a></li>';
									}
								?>
							</ul>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<?php get_auto_manager_template( 'pagination.php', array( 'max_num_pages' => $max_num_pages ) ); ?>
</div>

<div class="clear"></div><br/>

<?php if(in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )) : ?>

<h2><i class="icon-check-1"></i> <?php echo apply_filters( 'woocommerce_my_account_auto_packages_title', __( 'Purchased Submission Packages', 'auto_manager' ) ); ?></h2>

<table class="shop_table my_account_auto_packages sf-table striped_bordered">
	<thead>
		<tr>
			<th scope="col"><?php _e( 'Package Name', 'auto_manager' ); ?></th>
			<th scope="col"><?php _e( 'Allowance Remaining', 'auto_manager' ); ?></th>
			<th scope="col"><?php _e( 'Listing Duration', 'auto_manager' ); ?></th>
			<th scope="col"><?php _e( 'Featured?', 'auto_manager' ); ?></th>
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
				<td><?php echo sprintf( __( '%d day', '%d days', $package->auto_duration, 'auto_manager' ), $package->auto_duration ); ?></td>
				<td><?php if ( $package->auto_featured ) _e( 'Yes', 'auto_manager' ); else _e( 'No', 'auto_manager' ); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php endif; ?>

