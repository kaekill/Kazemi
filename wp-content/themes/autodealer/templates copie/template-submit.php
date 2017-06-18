<?php
/**
 * Template Name: Submit Vehicle
 * The Template for displaying the all brands page.
 *
 * @package ThemesDepot Framework
 */

get_header(); 

// Include Page Inner Header
get_template_part( 'templates/headers/page', 'header' );

?>

<section id="page-wrapper" class="wrapper">

	
	<div id="page-content" class="fullwidth">

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

					<?php echo do_shortcode('[submit_auto_form]' ); ?>

					</article>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'index' ); ?>

			<?php endif; ?>

	</div>

	<div class="clear"></div>

</section><!-- end page wrapper -->

<?php get_footer(); ?>
