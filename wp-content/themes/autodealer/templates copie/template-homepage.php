<?php
/**
 * Template Name: Homepage With Search Form
 * The Template for displaying the homepage.
 *
 * @package ThemesDepot Framework
 */

get_header();

?>

<section id="landing-search">

			<div id="landing-form-wrapper">

				<?php if(get_field('add_landing_image','option') && get_field('enable_overlay','option')) {
					echo '<div id="form-overlay"></div>';
				}?>

				<div class="wrapper">

					<div class="tagline">
						<?php the_field('search_form_tagline','option');?>
					</div>

				</div>

			</div>

</section>

<section id="page-wrapper" class="wrapper remove-margin">

	<h3 class="homepage-search-title"><i class="icon-search"></i> <?php _e('Recherche avancée','framework');?></h3>

	<div class="home-search-form-wrapper">

		<?php the_widget( 'TDP_Vehicle_Search', 'title=' ); ?>

		<div class="clearboth"></div>

	</div>

	<?php

	// Display Sidebar on right side

	if(get_field('page_layout') == 'Left Side Sidebar') { ?>

	<div id="sidebar" class="one_fourth sidebar-left">

		<?php dynamic_sidebar( 'Homepage Sidebar' ); ?>

	</div>

	<?php } ?>

	<div id="page-content" class="<?php if(get_field('page_layout') !== 'Left Side Sidebar' || get_field('page_layout') == 'Left Side Sidebar') { echo "fullwidth"; } else {echo "three_fourth";} ?> <?php if(get_field('page_layout') == 'Left Side Sidebar') { echo 'last'; } ?>">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<article <?php post_class();?>>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', 'page' );
					?>

					</article>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'index' ); ?>

			<?php endif; ?>

	</div>

	<?php

	// Display Sidebar on right side

	if(get_field('page_layout') == '' || get_field('page_layout') == 'Right Side Sidebar') { ?>

	<div id="sidebar" class="one_fourth sidebar-right last">

		<?php dynamic_sidebar( 'Homepage Sidebar' ); ?>

	</div>

	<?php } ?>

	<div class="clear"></div>

</section><!-- end page wrapper -->

<?php get_footer();?>
