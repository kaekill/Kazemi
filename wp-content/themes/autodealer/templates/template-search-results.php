<?php
/*
Template Name: Search Results
*/
get_header();

// Enable to see default query posted by the form
define('WPAS_DEBUG', false);
$args = tdp_search_fields();
$my_search = new WP_Advanced_Search($args);

//Set the query to be displayed
$temp_query = $wp_query;
$wp_query = $my_search->query();

/* Important: here we detect if the submitted query is
 * from the advanced search form or from the search widget
 * the 2 forms have 2 different queries and so,
 * we need to modify the query according to the submitted form
-------------------------------------------------------------- */

// Start Detection
if(isset($_GET['advanced_form']) && $_GET['advanced_form'] == 'yes') {

	/*
	Modify the existing search query to set the selected vehicle model
	This is required because we are using ajax to get the child vehicle
	Something that the wpas class doesn't support.
	*/
	$taxquery = array(

	        array(
	            'taxonomy' => 'vehicle_model',
	            'field' => 'slug',
	            'terms' => $_GET['adv_tax_vehicle_model'],
	            'operator'=> 'IN'
	        ),
	        array(
	            'taxonomy' => 'vehicle_year',
	            'field' => 'slug',
	            'terms' => $_GET['tax_vehicle_year'],
	            'operator'=> 'IN'
	        ),
	        array(
	            'taxonomy' => 'vehicle_type',
	            'field' => 'slug',
	            'terms' => $_GET['tax_vehicle_type'],
	            'operator'=> 'IN'
	        ),
	        array(
	            'taxonomy' => 'vehicle_status',
	            'field' => 'slug',
	            'terms' => $_GET['tax_vehicle_status'],
	            'operator'=> 'IN'
	        ),
	        array(
	            'taxonomy' => 'vehicle_color',
	            'field' => 'slug',
	            'terms' => $_GET['tax_vehicle_color'],
	            'operator'=> 'AND'
	        ),
	        array(
	            'taxonomy' => 'vehicle_fuel_type',
	            'field' => 'slug',
	            'terms' => $_GET['tax_vehicle_fuel_type'],
	            'operator'=> 'IN'
	        ),
	        array(
	            'taxonomy' => 'vehicle_gearbox',
	            'field' => 'slug',
	            'terms' => $_GET['tax_vehicle_gearbox'],
	            'operator'=> 'IN'
	        ),
	        array(
	            'taxonomy' => 'vehicle_location',
	            'field' => 'slug',
	            'terms' => $_GET['tax_vehicle_location'],
	            'operator'=> 'IN'
	        )
	);

	$wp_query->set( 'tax_query', $taxquery );


	$metaquery = array(

		array(
		     'key' => 'price',
		     'value' => array( $_GET['adv_price_min'], $_GET['adv_price_max'] ),
		     'type' => 'numeric',
		     'compare' => 'BETWEEN'
		),
		array(
		     'key' => 'mileage',
		     'value' => array( $_GET['adv_mil_min'], $_GET['adv_mil_max'] ),
		     'type' => 'numeric',
		     'compare' => 'BETWEEN'
		)

	);

	$wp_query->set( 'meta_query', $metaquery );

	$wp_query->set('orderby', 'meta_value');
  $wp_query->set('meta_key', 'set_vehicle_as_featured');

} else {

	/*
	Modify the existing search query to set the selected vehicle model
	This is required because we are using ajax to get the child vehicle
	Something that the wpas class doesn't support.
	*/
	if($_GET['main_cat'] !== 'any' && $_GET['tax_vehicle_model'] !== 'all') {

		$taxquery = array(
		        array(
		            'taxonomy' => 'vehicle_model',
		            'field' => 'slug',
		            'terms' => $_GET['tax_vehicle_model'],
		            'operator'=> 'IN'
		        ),
		);
		$wp_query->set( 'tax_query', $taxquery );

	}

	if($_GET['main_cat'] !== 'any' && $_GET['tax_vehicle_model'] == '') {

		$taxquery = array(
			array(
			    'taxonomy' => 'vehicle_model',
			    'field' => 'id',
			    'terms' => $_GET['main_cat'],
			),
		);
		$wp_query->set( 'tax_query', $taxquery );

	}

	if(!empty($_GET['tax_vehicle_type']) || $_GET['tax_vehicle_type'] !== '' ) {

			$taxquery2 = array(
		        array(
		            'taxonomy' => 'vehicle_type',
		            'field' => 'slug',
		            'terms' => $_GET['tax_vehicle_type'],
		            'operator'=> 'IN'
		        ),

			);
			$wp_query->set( 'tax_query', $taxquery2 );

	}

	//verify that field is enabled
	if(get_field('display_price_filter','option')) {

		$metaquery = array(

		        array(
		            'key' => 'price',
		            'value' => array( $_GET['price_min'], $_GET['price_max'] ),
		            'type' => 'numeric',
		            'compare' => 'BETWEEN'
		        ),

		);

		$wp_query->set( 'meta_query', $metaquery );

		$wp_query->set('orderby', 'meta_value');
    $wp_query->set('meta_key', 'set_vehicle_as_featured');

	}

} /* End Detection here */

$wp_query->set('orderby','date');
$wp_query->set('order','desc');

/* Search Form Query Detection Finished Now We Display the Query
-------------------------------------------------------------- */

if(isset($_GET['vehicle_order']) && $_GET['vehicle_order'] == 'price_low'){

	$wp_query->set('post_status', 'publish');
	$wp_query->set('orderby', 'meta_value_num');
	$wp_query->set('order','asc');
	$wp_query->set('meta_key', 'price');

}

if(isset($_GET['vehicle_order']) && $_GET['vehicle_order'] == 'price_high'){

	$wp_query->set('post_status', 'publish');
	$wp_query->set('orderby', 'meta_value_num');
	$wp_query->set('order','desc');
	$wp_query->set('meta_key', 'price');

}

if(isset($_GET['vehicle_order']) && $_GET['vehicle_order'] == 'names_az'){

	$wp_query->set('post_status', 'publish');
	$wp_query->set('orderby','title');
	$wp_query->set('order','asc');

}

if(isset($_GET['vehicle_order']) && $_GET['vehicle_order'] == 'names_za'){

	$wp_query->set('post_status', 'publish');
	$wp_query->set('orderby','title');
	$wp_query->set('order','desc');

}

$wp_query->set('post_status', 'publish');
$wp_query->set('orderby', 'meta_value');
$wp_query->set('meta_key', 'set_vehicle_as_featured');

$wp_query->query($wp_query->query_vars);

//get layout view
$active_order = $_GET[ 'vehicle_view' ];
// Include Page Inner Header
get_template_part( 'templates/headers/page', 'header' );

if(get_field('display_advanced_search_form_in_taxonomy','option')) {
	get_template_part( 'templates/vehicles/vehicle', 'advancedform' );
}

?>

<section id="page-wrapper" class="wrapper">

	<?php

	// Display Sidebar on right side

	if(get_field('page_layout') == 'Left Side Sidebar') { ?>

	<div id="sidebar" class="one_fourth sidebar-left">

		<?php dynamic_sidebar( 'Page Sidebar' ); ?>

	</div>

	<?php } ?>

	<div id="page-content" class="<?php if(get_field('page_layout') !== 'Fullwidth') { echo 'three_fourth'; } else { echo 'fullwidth';} ?> <?php if(get_field('page_layout') == 'Left Side Sidebar') { echo 'last'; } ?>">

			<div class="inner-wrapper">

			<?php

			/**
			 * Load vehicles default loop if view mode isn't map
			*/

			if ( have_posts() && $active_order !== 'map' ) { ?>

				<?php
				/**
				 * Load vehicle filter
				 */
				get_template_part( 'templates/vehicles/vehicle', 'filter' );

				if(function_exists('wp_pagenavi') &&  get_field('display_pagination_on_top','option')) {
							echo '<div class="clear"></div>';
							wp_pagenavi();
				}

				while ( have_posts() ) : the_post(); $clear_row++; $clear_row_end++;

						/**
						 * Loop For The Default View Mode (list mode)
						 */
						if($active_order == 'list' || $active_order == '') {
							get_template_part( 'templates/vehicles/vehicle', 'list' );
						/**
						 * Loop For The Grid Mode
						 */
						} else if($active_order == 'grid') { ?>

							<div class="grid-column one_third <?php if($clear_row == 3 ) { echo " last"; $clear_row = 0; } ?>">
							<?php get_template_part( 'templates/vehicles/vehicle', 'grid' ); ?>
							</div>

							<?php if($clear_row_end == 3) { echo '<div class="clear"></div>'; $clear_row_end = 0; } ?>

						<?php
						/**
						 * Fallback
						 */
						}

				endwhile;

					if(function_exists('wp_pagenavi')) {
						echo '<div class="clear"></div>';
						wp_pagenavi();
					} else {
						echo '<p>WP PAGE NAVI PLUGIN REQUIRED. Please Install it.</p>';
					}

				?>

			<?php }
			/**
			 * Load vehicles loop mode in map view
			*/
			else if ( have_posts() && $active_order == 'map' ) { ?>

				<?php get_template_part( 'templates/vehicles/vehicle', 'map' ); ?>

			<?php } else { ?>

				<?php get_template_part( 'no-results', 'index' ); ?>

			<?php }  wp_reset_query(); $wp_query = $temp_query; ?>

			</div> <!-- inner wrapper -->

	</div><!-- page content -->

	<?php

	// Display Sidebar on right side

	if(get_field('page_layout') == '' || get_field('page_layout') == 'Right Side Sidebar') { ?>

	<div id="sidebar" class="one_fourth sidebar-right last">

		<?php dynamic_sidebar( 'Page Sidebar' ); ?>

	</div>

	<?php } ?>

	<div class="clear"></div>

</section><!-- end page wrapper -->

<?php if(get_field('display_carousel_in_search_results_page','option') == 'Display Latest Vehicles Carousel') { ?>
	<?php get_template_part( 'templates/vehicles/vehicle', 'carousel' ); ?>
<?php } ?>
<?php if(get_field('display_carousel_in_search_results_page','option') == 'Display Featured Vehicles Carousel') { ?>
	<?php get_template_part( 'templates/vehicles/vehicle', 'featuredcarousel' ); ?>
<?php } ?>
<?php if(get_field('display_brands_list_in_search_results','option')) { ?>
	<?php get_template_part( 'templates/vehicles/vehicle', 'brands' ); ?>
<?php } ?>

<?php get_footer(); ?>
