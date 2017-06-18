<?php
/**
 * Vehicle Grid Loop View
 */

?>

<div class="single-vehicle-view view-grid">

	<div class="single-thumb">
			
			<?php if ( has_post_thumbnail()) { 
			$thumb = get_post_thumbnail_id();
			$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
			$image = aq_resize( $img_url, 300, 300, true ); //resize & crop the image
			?>
			<?php if(get_field('set_vehicle_as_featured')) { ?>
				<div class="featured-badge-grid">
					<i class="icon-star"></i>
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

					<?php tdp_display_new_badge();?>

				</div>

				<?php if(get_field('discount')) { ?>

					<span class="new-badge"><?php the_field('discount');?> <?php _e('Off','framework');?></span>

				<?php } ?>

			</figure>

			<?php } ?>

	</div>

	<div class="single-desc">

		<h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>

	</div>

	<ul class="grid-details">
		<?php if(get_field('mileage') && get_field('display_mileage_in_taxonomy_list','option')) { ?>
			<li class="tooltip" title="<?php _e('Vehicle Mileage','framework');?>"><i class="icon-gauge-1"></i> <?php the_field('mileage');?> <?php the_field('mileage_symbol','option');?></li>
		<?php } ?>
		<?php if(get_field('registration_year') && get_field('display_registration_year_in_taxonomy_list','option')) { ?>
			<li class="tooltip" title="<?php _e('Vehicle Registration Date','framework');?>"><i class="icon-calendar-1"></i> <?php the_field('registration_year');?> </li>
		<?php } ?>
		<li><?php tdp_vehicle_price(); ?></li>
	</ul>

	<a href="<?php the_permalink();?>" class="grid-button btn white"><?php _e('View More &raquo;','framework');?></a>

</div>

