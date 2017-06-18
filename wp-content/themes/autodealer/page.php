<?php
/**
 * The Template for displaying all single posts.
 *
 * @package ThemesDepot Framework
 */

get_header(); 

// Include Page Inner Header
get_template_part( 'templates/headers/page', 'header' );

//check if woocommerce is enabled and is checkout page
if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_checkout()) {
	get_template_part( 'templates/headers/page', 'cart' );
}

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

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<article <?php post_class();?>>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', 'page' );

						wp_link_pages('before=<p>&after=</p>&next_or_number=number&pagelink=page %');

					?>

					</article>

					<?php
						wp_link_pages( $args );
						// If comments are open or we have at least one comment, load up the comment template
						if ( !get_field('disable_comments_on_pages','option') && comments_open() || '0' != get_comments_number())
							comments_template();
					
					?>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'index' ); ?>

			<?php endif; ?>

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