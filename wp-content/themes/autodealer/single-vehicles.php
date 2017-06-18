<?php
/**
 * The Template for displaying all single vehicles.
 *
 * @package ThemesDepot Framework
 */

get_header(); 

// Include Page Inner Header
get_template_part( 'templates/headers/page', 'header' );

?>

<?php get_template_part( 'templates/vehicles/vehicle', 'infobar' ); ?>

<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<section id="page-wrapper" class="wrapper">

			<div id="page-content" class="fullwidth">

				<?php the_field('custom_top_content','option');?>

				<div class="vehicle-location">
					
					<?php get_template_part( 'templates/vehicles/vehicle', 'single-map' ); ?>

				</div>

				<div class="vehicle-description">

					<div class="one_half" id="vehicle-gallery">

						<?php get_template_part( 'templates/vehicles/vehicle', 'gallery' ); ?>

					</div>

					<div class="one_half last" id="vehicle-overview">

						<?php get_template_part( 'templates/vehicles/vehicle', 'overview' ); ?>

					</div>

					<div class="clear"></div>

				</div>

				<?php get_template_part( 'templates/vehicles/vehicle', 'info' ); ?>

			</div>

			<div class="clear"></div>

			<?php the_field('custom_bottom_content','option');?>	

		</section>
		
	<?php endwhile; ?>

	<?php if(get_field('display_latest_vehicle_carousel','option')) { ?>
		<?php get_template_part( 'templates/vehicles/vehicle', 'carousel' ); ?>
	<?php } ?>

	<?php if(get_field('display_featured_vehicle_carousel','option')) { ?>
		<?php get_template_part( 'templates/vehicles/vehicle', 'featuredcarousel' ); ?>
	<?php } ?>

	<?php if(get_field('display_brands_carousel','option')) { ?>
		<?php get_template_part( 'templates/vehicles/vehicle', 'brands' ); ?>
	<?php } ?>


<?php else : ?>

		<?php get_template_part( 'no-results', 'index' ); ?>

<?php endif; ?>

<?php get_footer();?>