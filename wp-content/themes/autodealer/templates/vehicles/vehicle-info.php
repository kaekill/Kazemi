<?php
/**
 * The Template for displaying vehicle info
 *
 * @package ThemesDepot Framework
 */

?>
<section id="single-vehicle-info">

	<?php 

	// Display Sidebar on right side
	if(get_field('single_vehicle_layout','option') == 'Left Side Sidebar') { ?>
	<div id="sidebar" class="one_fourth sidebar-left">
		
		<?php dynamic_sidebar( 'Single Vehicles Sidebar' ); ?>

	</div>
	<?php } ?>

	<div class="<?php if(get_field('single_vehicle_layout') !== 'Fullwidth') { echo 'three_fourth'; } else { echo 'fullwidth';} ?> <?php if(get_field('single_vehicle_layout') == 'Left Side Sidebar') { echo 'last'; } ?>">
		
		<h3 class="single-vehicle-title"><i class="icon-info-circled-1"></i> <?php _e('Vehicle Description','framework');?></h3>

		<?php the_content();?>

		<?php if(!get_field('disable_vehicle_features_display')) { ?>

		<h3 class="single-vehicle-title overview-title"><i class="icon-list-bullet"></i> <?php _e('Vehicle Overview','framework');?></h3>

		<script type="text/javascript">
			jQuery(function() {
		        jQuery( "#tabs-listing" ).tabs();
		    });

		</script>

			<div id="tabs-listing">
				  
				  <ul>	
				  		<?php if( get_field('vehicle_features','option') && in_array( 'Display Exterior & Interior Features', get_field('vehicle_features','option') ) ) { ?>
				  		<li><a href="#tabs-1"><i class="icon-list-1"></i> <?php _e('Exterior & Interior Features','framework');?></a></li>
				  		<?php } ?>
				  		<?php if( get_field('vehicle_features','option') && in_array( 'Display Safety & Extra Features', get_field('vehicle_features','option') ) ) { ?>
				  		<li><a href="#tabs-2"><i class="icon-list-1"></i> <?php _e('Safety & Extra Features','framework');?></a></li>
				  		<?php } ?>
				  		<?php if( get_field('vehicle_features','option') && in_array( 'Display Contact Dealer', get_field('vehicle_features','option') ) ) { ?>
				  		<li><a href="#tabs-3"><i class="icon-mail-alt"></i> <?php _e('Contact Dealer','framework');?></a></li>
				  		<?php } ?>
				  </ul>
				  
				  <?php if( get_field('vehicle_features','option') && in_array( 'Display Exterior & Interior Features', get_field('vehicle_features','option') ) ) { ?>
				  <div id="tabs-1" class="tab-cont">
				  		<?php get_template_part( 'templates/vehicles/vehicle', 'features' ); ?>
				  </div>
				  <?php } ?>
				  <?php if( get_field('vehicle_features','option') && in_array( 'Display Safety & Extra Features', get_field('vehicle_features','option') ) ) { ?>
				  <div id="tabs-2" class="tab-cont">
				  		<?php get_template_part( 'templates/vehicles/vehicle', 'extra' );?>
				  </div>
				  <?php } ?>
				  <?php if( get_field('vehicle_features','option') && in_array( 'Display Contact Dealer', get_field('vehicle_features','option') ) ) { ?>
				  <div id="tabs-3" class="tab-cont">
				  		<?php get_template_part( 'templates/vehicles/vehicle', 'contact' );?>
				  </div>
				  <?php } ?>

				  <?php if(!get_field('vehicle_features','option')) : ?>

				  	Navigate to the theme options panel -> Vehicles Options -> Single Vehicle Settings -> Vehicle Features and enable at least 1 of the options there then press the save button.

				  <?php endif; ?>

			</div>

		<?php } ?>

	</div>

	<?php 

	// Display Sidebar on right side
	if(get_field('single_vehicle_layout','option') == '' || get_field('single_vehicle_layout','option') == 'Right Side Sidebar') { ?>
	<div id="sidebar" class="one_fourth sidebar-right last">
		
		<?php dynamic_sidebar( 'Single Vehicles Sidebar' ); ?>

	</div>
	<?php } ?>

	<div class="clear"></div>

</section>