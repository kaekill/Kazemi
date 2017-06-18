<?php
/**
 * Template file required to display taxonomies
 */
get_header(); 

// Include Page Inner Header
get_template_part( 'templates/headers/archive', 'header' );

if(get_field('display_advanced_search_form_in_taxonomy','option')) {
	get_template_part( 'templates/vehicles/vehicle', 'advancedform' );
}

//get layout view
$active_order = null;
if(isset($_GET[ 'vehicle_view' ])) {
$active_order = $_GET[ 'vehicle_view' ];
} else {

	if(get_field('default_vehicles_view','option') == 'Grid Mode') {
		$active_order = 'grid';
	} else {
		$active_order = null;
	}
	
}

?>
<section id="page-wrapper" class="wrapper">
	<?php 

	// Display Sidebar on right side
	if(get_field('categories_layout_settings','option') == 'Left Side Sidebar') { ?>
	<div id="sidebar" class="one_fourth sidebar-left">
		
		<?php dynamic_sidebar( 'Vehicles Sidebar' ); ?>

	</div>
	<?php } ?>
	
	<div id="page-content" class="<?php if(get_field('categories_layout_settings','option') !== 'Fullwidth') { echo 'three_fourth'; } else { echo 'fullwidth';} ?> <?php if(get_field('categories_layout_settings','option') == 'Left Side Sidebar') { echo 'last'; } ?>">

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

			<?php } ?>

			</div>

	</div>

	<?php 

	// Display Sidebar on right side
	if(get_field('categories_layout_settings','option') == '' || get_field('categories_layout_settings','option') == 'Right Side Sidebar') { ?>
	<div id="sidebar" class="one_fourth sidebar-right last extendright">
		
		<?php dynamic_sidebar( 'Vehicles Sidebar' ); ?>

	</div>
	<?php } ?>

	<div class="clear"></div>

</section><!-- end page wrapper -->
<?php get_footer();?>