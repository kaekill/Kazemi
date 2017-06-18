
<?php if ( $packages || $user_packages ) : ?>
	<ul class="auto_packages">
		<?php foreach ( $packages as $key => $package ) : $product = get_product( $package ); ?>

			<li>
				<div class="package-details one_half">
					<div class="inner-pad">
						<label for="package-<?php echo $product->id; ?>">
							
							<input type="radio" <?php checked( $key, 0 ); ?> name="auto_package" value="<?php echo $product->id; ?>" id="package-<?php echo $product->id; ?>" /> 
							
							<?php echo $product->get_title(); ?>
							
							<?php if(get_post_meta( $package->ID, '_auto_listing_featured', true ) == 'yes') { ?>
								<span class="featured-package"><?php _e('Featured Listings', 'auto_manager');?></span>
							<?php } ?>

						</label>
						<br/>
						<span class="package-description">
							<?php echo $package->post_content; ?><br/>
						</span>
					</div>
				</div>
				<div class="package-price one_half last">
					<?php
								printf( _n( '%s for %d auto', '%s for %s autos', $product->get_limit(), 'auto_manager' ) . ' ', $product->get_price_html(), $product->get_limit() );

								printf( _n( 'listed for %s day', 'listed for %s days', $product->get_duration(), 'auto_manager' ), $product->get_duration() );
							?>
				</div>
				<div class="clear"></div>
			</li>

		<?php endforeach; ?>

		
	</ul>

	<?php if($user_packages) { ?>

	<h2 class="m-top-30"><i class="icon-check-1"></i><?php _e('Already Purchased Packages','auto_manager');?></h2>

	<ul class="auto_packages">
	<?php foreach ( $user_packages as $key => $package ) : $product = get_product( $package->product_id ); ?>

			<li>
				<div class="package-details one_half">
					<div class="inner-pad">
						<label for="user-package-<?php echo $package->id; ?>">
							<input type="radio" name="auto_package" value="user-<?php echo $key; ?>" id="user-package-<?php echo $package->id; ?>" /> 
							<?php if ( $product ) echo $product->get_title(); else echo '-'; ?>
							<?php if(get_post_meta( $package->id, '_auto_listing_featured', true ) == 'yes') { ?>
								<span class="featured-package"><?php _e('Featured Listings','auto_manager');?></span>
							<?php } ?>
						</label>
						<br/>
						<span class="package-description">
								<?php echo $product->post->post_content; ?><br/>
						</span>
					</div>
				</div>
				<div class="package-price one_half last">
					<?php
					printf( _n( '%s auto posted out of %d', '%s autos posted out of %s', $package->auto_count, 'auto_manager' ) . ', ', $package->auto_count, $package->auto_limit );

					printf( _n( 'listed for %s day', 'listed for %s days', $package->auto_duration, 'auto_manager' ), $package->auto_duration );
					?>
				</div>
				<div class="clear"></div>
			</li>

	<?php endforeach; ?>
	</ul>
	<?php } ?>

<?php else : ?>

	<p><?php _e( 'No packages found', 'auto_manager' ); ?></p>

<?php endif; ?>
