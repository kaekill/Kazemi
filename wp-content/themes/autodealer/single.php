<?php
/**
 * The Template for displaying all single posts.
 *
 * @package ThemesDepot Framework
 */

get_header(); 

// Include Page Inner Header
get_template_part( 'templates/headers/page', 'header' );

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

					<?php do_action('tdp_after_single_post');?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() )
							comments_template();
					?>

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