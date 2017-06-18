<?php
/**
 * The Template for displaying vehicle info
 *
 * @package ThemesDepot Framework
 */

?>

<h2 class="single-price">
	<?php tdp_vehicle_price(); ?> 
	<?php if(get_field('set_vehicle_as_featured') && get_field('vehicle_details','option') && in_array( 'Display Featured Mark', get_field('vehicle_details','option') ) ) { ?>
		<span class="featured-star featured-title" title=""><?php _e('This vehicle is featured','framework');?></span>
	<?php } ?>
</h2>

<?php if(get_field('vehicle_position') && get_field('display_vehicle_address','option')) { $address = get_field('vehicle_position'); ?>
	<?php if(!empty($address['address'])) { ?>
	<span class="vehicle-position"><i class="icon-location"></i> <?php echo $address['address'];?></span>
	<?php } ?>
<?php } ?>

<div class="features_table">
	<?php if( get_field('vehicle_details','option') && in_array( 'Display Model Type', get_field('vehicle_details','option') ) ) { ?>
	<div class="line grey_area1">
		<div class="left"><?php _e('Model, Body type:','framework');?></div>
		<div class="right">
			<?php 
			$vehicle_types = wp_get_post_terms(get_the_ID(), 'vehicle_type', array("fields" => "names"));
			$t = count($vehicle_types);
			$c = 0;
			foreach($vehicle_types as $vehicle_type) {
				$c++;
				echo $vehicle_type;
				if($c < $t ) echo ', ';
			}
			?>
		</div>
	</div>
	<?php } ?>
	<?php if( get_field('vehicle_details','option') && in_array( 'Display Registration Year', get_field('vehicle_details','option') ) ) { ?>
	<div class="line">
		<div class="left"><?php _e('Registration:','framework');?></div>
		<div class="right"><?php the_field('registration_year');?></div>
	</div>
	<?php } ?>
	<?php if( get_field('vehicle_details','option') && in_array( 'Display Fuel Type', get_field('vehicle_details','option') ) ) { ?>
	<div class="line grey_area1">
		<div class="left"><?php _e('Fuel Type:','framework');?></div>
		<div class="right">
			
			<?php $terms = get_the_terms( $post->ID , 'vehicle_fuel_type' ); foreach( $terms as $term ) {  print $term->name;  unset($term); }?>

		</div>
	</div>
	<?php } ?>
	<?php if( get_field('vehicle_details','option') && in_array( 'Display Engine Details', get_field('vehicle_details','option') ) ) { ?>
	<div class="line">
		<div class="left"><?php _e('Engine Power','framework');?></div>
		<div class="right"><?php the_field('capacity');?> ( <?php the_field('power_kw');?> <?php _e('KW','framework');?> / <?php the_field('power_bhp');?> <?php _e('BHP','framework');?> )</div>
	</div>
	<?php } ?>
	<?php if( get_field('vehicle_details','option') && in_array( 'Display Transmission', get_field('vehicle_details','option') ) ) { ?>
	<div class="line grey_area1">
		<div class="left"><?php _e('Transmission','framework');?></div>
		<div class="right">
			
			<?php $terms = get_the_terms( $post->ID , 'vehicle_gearbox' ); foreach( $terms as $term ) {  print $term->name;  unset($term); }?>

		</div>
	</div>
	<?php } ?>
	<?php if( get_field('vehicle_details','option') && in_array( 'Display Color', get_field('vehicle_details','option') ) ) { ?>
	<div class="line">
		<div class="left"><?php _e('Color:','framework');?></div>
		<div class="right">
			<?php 
			$vehicles_colors = wp_get_post_terms(get_the_ID(), 'vehicle_color', array("fields" => "names"));
			$count_color = count($vehicles_colors);
			$counter = 0;
			foreach($vehicles_colors as $vehicle_color) {
				$counter++;
				echo $vehicle_color;
				if($counter < $count_color ) echo ', ';
			}
			?>
		</div>
	</div>
	<?php } ?>
	<?php if( get_field('vehicle_details','option') && in_array( 'Display Doors', get_field('vehicle_details','option') ) ) { ?>
	<div class="line grey_area1">
		<div class="left"><?php _e('Doors:','framework');?></div>
		<div class="right"><?php the_field('doors');?></div>
	</div>
	<?php } ?>
	<?php if( get_field('vehicle_details','option') && in_array( 'Display Emissions', get_field('vehicle_details','option') ) ) { ?>
	<div class="line">
		<div class="left"><?php _e('CO2-Emissions:','framework');?></div>
		<div class="right"><?php the_field('emission_class');?></div>
	</div>
	<?php } ?>
	<?php if( get_field('vehicle_details','option') && in_array( 'Display Location', get_field('vehicle_details','option') ) ) { ?>
	<div class="line grey_area1">
		<div class="left"><?php _e('Location:','framework');?></div>
		<div class="right">
			<?php $terms = get_the_terms( $post->ID , 'vehicle_location' ); foreach( $terms as $term ) {  print $term->name;  unset($term); }?>
		</div>
	</div>
	<?php } ?>
	<?php if( get_field('vehicle_details','option') && in_array( 'Display Mileage', get_field('vehicle_details','option') ) ) { ?>
	<div class="line">
		<div class="left"><?php _e('Mileage:','framework');?></div>
		<div class="right"><?php the_field('mileage');?> <?php the_field('mileage_symbol','option');?></div>
	</div>
	<?php } ?>

	<?php if( !get_field('vehicle_details','option')) :?>

		Navigate to the theme options panel -> Vehicles Options -> Single Vehicle Settings -> Vehicle Details and enable at least 1 of the options there then press the save button.

	<?php endif; ?>

</div>