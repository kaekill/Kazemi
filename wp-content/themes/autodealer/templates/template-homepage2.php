<?php
/**
 * Template Name: Homepage With Slider
 * The Template for displaying the homepage.
 *
 * @package ThemesDepot Framework
 */

get_header(); 

?>

<section id="homepage-slider">
	<?php echo do_shortcode(get_field('slider_shortcode','option')); ?>
</section>

<section id="page-wrapper" class="wrapper remove-margin">

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

	<div class="clear"></div>

</section><!-- end page wrapper -->

<?php get_footer();?>