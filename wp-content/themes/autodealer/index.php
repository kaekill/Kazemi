<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package ThemesDepot Framework
 */

get_header(); 

// Include Page Inner Header
get_template_part( 'templates/headers/blog', 'header' );

?>

<section id="page-wrapper" class="wrapper">

	<?php 

	// Display Sidebar on right side

	if(get_field('blog_sidebar_position','option') == 'Left Side') { ?>

	<div id="sidebar" class="one_fourth sidebar-left">
		
		<?php dynamic_sidebar( 'Blog Sidebar' ); ?>

	</div>

	<?php } ?>
	
	<div id="page-content" class="three_fourth <?php if(get_field('blog_sidebar_position','option') == 'Left Side') { echo 'last'; } ?>">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<article <?php post_class();?>>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>

					</article>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'index' ); ?>

			<?php endif; ?>

			<?php if(function_exists('wp_pagenavi')) { ?>

				<?php wp_pagenavi(); ?>

			<?php } else { ?>

				<p>Please Install the WP - Page Navi Plugin </p>

			<?php } ?>

	</div>

	<?php 

	// Display Sidebar on right side

	if(get_field('blog_sidebar_position','option') == 'Right Side') { ?>

	<div id="sidebar" class="one_fourth sidebar-right last">
		
		<?php dynamic_sidebar( 'Blog Sidebar' ); ?>

	</div>

	<?php } ?>

	<div class="clear"></div>

</section><!-- end page wrapper -->

<?php get_footer(); ?>