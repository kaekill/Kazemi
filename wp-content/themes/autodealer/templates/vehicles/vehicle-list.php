<?php
/**
 * Vehicle List Loop View
 */


$user_info = get_userdata(get_the_author_meta( 'ID' ));

$user_id = get_the_author_meta('ID');

?>
<div class="single-vehicle-view view-list <?php if(get_field('set_vehicle_as_featured')) { ?>vehicle-is-featured<?php } ?>">

	<?php if(get_field('set_vehicle_as_featured')) { ?>

		<h3 class="featured-heading"><i class="icon-star"></i> <?php _e('Featured Advert','framework');?></h3>

	<?php } ?>

		<div class="one_third single-thumb">

			<?php 

			if(tdp_check_user_role( 'administrator', $user_id ) || tdp_check_user_role( 'tdp_dealer', $user_id )) {
				echo '<span class="dealer-badge">'.__('Dealer','framework').'</span>';
			}

			?>
			
			<?php if ( has_post_thumbnail()) { 
			$thumb = get_post_thumbnail_id();
			$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
			$image = aq_resize( $img_url, 300, 300, true ); //resize & crop the image
			?>
			<?php if(get_field('set_vehicle_as_featured')) { ?>
				<div class="featured-badge">
					<?php _e('Featured Deal','framework');?>
				</div>
			<?php } ?>
			<figure class="media post-img view-list crop-me">

				<div class="mediaholder">

					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="image-link" data-effect="">
						<img src="<?php echo $image ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
						<div class="hovercover">
				            <div class="hovericon"><i class="icon-eye"></i></div>
				         </div>
					</a>

				</div>

				<?php if(get_field('discount')) { ?>

					<span class="new-badge"><?php the_field('discount');?> <?php _e('Off','framework');?></span>

				<?php } ?>

			</figure>

			<?php } ?>
		</div>

		<div class="two_third last single-desc">

			<h3>
				<a href="<?php the_permalink();?>"><?php the_title();?></a>
			</h3>

			<span class="vehicle-price"><?php tdp_vehicle_price(); ?></span>

			<div class="clear"></div>

			<?php if(get_field('vehicle_position') && get_field('display_vehicle_position_address','option')) { $address = get_field('vehicle_position'); ?>
				<?php if(!empty($address['address'])) { ?>
				<span class="vehicle-position"><i class="icon-location"></i> <?php echo $address['address'];?></span>
				<?php } ?>
			<?php } ?>

			<?php if(get_field('set_vehicle_as_featured')) { ?><span class="featured-star tooltip" title="<?php _e('This vehicle is featured','framework');?>"><i class="icon-star"></i></span><?php } ?>

			<div class="offer-desc">
			<?php $text_desc = get_the_content(); $trimmed_desc = wp_trim_words( $text_desc, $num_words = 25, $more = null ); echo stripslashes($trimmed_desc); ?>
			</div>

			<div class="vehicle-details one_half">
			<?php if(get_field('mileage') && get_field('display_mileage_in_taxonomy_list','option')) { ?>

			<span class="vehicle-mileage tooltip" title="<?php _e('Vehicle Mileage','framework');?>"><i class="icon-gauge-1"></i> <?php the_field('mileage');?> <?php the_field('mileage_symbol','option');?></span>

			<?php } ?>

			<?php if(get_field('registration_year') && get_field('display_registration_year_in_taxonomy_list','option')) { ?>

			<span class="vehicle-year tooltip" title="<?php _e('Vehicle Registration Date','framework');?>"><i class="icon-calendar-1"></i> <?php the_field('registration_year');?> </span>

			<?php } ?>
			</div>

			<div class="vehicle-link one_half last">

				<a href="<?php the_permalink();?>" class="btn white"><?php _e('View More &raquo;','framework');?></a>

			</div>

			<div class="clear"></div>

		</div>
		
		<div class="clear"></div>

		<?php if(get_field('set_vehicle_as_featured') && get_field('display_featured_vehicle_information_bar','option')) { ?>

			<div class="featured-more">

				<?php if(get_field('display_featured_vehicle_dealer_name','option')) { ?>
					
					<h5><?php _e('On Sale By: ','framework');?><?php the_author_meta( 'display_name' ); ?></h5>

				<?php } ?>

				<?php if(get_field('display_featured_vehicle_dealer_website','option') && get_the_author_meta( 'business_website' )) { ?>

				<h5><?php _e('Dealer Website: ','framework');?><a href="<?php the_author_meta( 'business_website' ); ?>"><?php the_author_meta( 'business_website' ); ?></a></h5>

				<?php } ?>

				<?php if(get_field('display_featured_vehicle_date','option')) { ?>

				<h5 class="more-date"><?php _e('Listed On: ','framework');?> <?php the_date(); ?></h5>

				<?php } ?>

				<div class="clearboth"></div>

			</div>

		<?php } ?>

	</div>