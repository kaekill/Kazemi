<?php
/**
 * Template Name: Dealer Profile
 * The Template for displaying all single posts.
 *
 * @package ThemesDepot Framework
 */

get_header(); 

// Include Page Inner Header
get_template_part( 'templates/headers/profile', 'header' );

if(get_field('display_profile_info_bar','option')) {
	get_template_part( 'templates/headers/profile', 'info' );
}

if(get_field('display_profile_information','option')) {
	get_template_part( 'templates/headers/profile', 'overview' );
}

//get layout view
$active_order = $_GET[ 'vehicle_view' ]; 

$user_id = sanitize_title($_GET['dealer_profile']);

?>

<section id="page-wrapper" class="wrapper <?php if(get_field('remove_subheader_spacing')) { echo 'remove-margin';}?>">

	<?php 

	// Display Sidebar on right side

	if(get_field('page_layout') == 'Left Side Sidebar') { ?>

	<div id="sidebar" class="one_fourth sidebar-left">
		
		<?php dynamic_sidebar( 'Page Sidebar' ); ?>

	</div>

	<?php } ?>
	
	<div id="page-content" class="<?php if(get_field('page_layout') !== 'Fullwidth') { echo 'three_fourth'; } else { echo 'fullwidth';} ?> <?php if(get_field('page_layout') == 'Left Side Sidebar') { echo 'last'; } ?>">

			<?php 

			/**
			 * Load vehicles default loop if view mode isn't map
			*/

			$args = array( 'post_type' => 'vehicles', 'posts_per_page' => 5, 'author' => $user_id, 'paged' => get_query_var('paged'), 'orderby' => 'meta_value', 'meta_key' => 'set_vehicle_as_featured' );
			
			$dealer_loop = new WP_Query( $args );

			if ( $dealer_loop->have_posts() ) { ?>

				<?php 
				/**
				 * Load vehicle filter
				 */
				while ( $dealer_loop->have_posts() ) : $dealer_loop->the_post(); $clear_row++; $clear_row_end++;
					
					get_template_part( 'templates/vehicles/vehicle', 'list' );

				endwhile; 
					
					if(function_exists('wp_pagenavi')) {
						echo '<div class="clear"></div>';
						wp_pagenavi(array( 'query' => $dealer_loop ));
						wp_reset_postdata();
					} else {
						echo '<p>WP PAGE NAVI PLUGIN REQUIRED. Please Install it.</p>';
					}

				?>

			<?php } else { ?>

				<?php get_template_part( 'no-results', 'index' ); ?>

			<?php } ?>

	</div>

	<?php 

	// Display Sidebar on right side

	if(get_field('page_layout') == '' || get_field('page_layout') == 'Right Side Sidebar') { ?>

	<div id="sidebar" class="one_fourth sidebar-right last">
		
		<?php dynamic_sidebar( 'Page Sidebar' ); ?>

	</div>

	<?php } ?>

	<div class="clear"></div>

</section><!-- end page wrapper -->

<?php get_footer(); ?>