<?php
/**
 * Template Name: Edit Profile
 * The Template for displaying all single posts.
 *
 * @package ThemesDepot Framework
 */

get_header(); 

// Include Page Inner Header
get_template_part( 'templates/headers/editprofile', 'header' );

?>

<script type="text/javascript">
jQuery(function() {
	jQuery( "#tabs-listing" ).tabs();
});
</script>

<section id="page-wrapper" class="wrapper">

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

					?>
					
					<?php 

						if(is_user_logged_in()) {

							echo do_shortcode('[editprofile]' );

						} else {

							echo '<div class="alert-box error">
									<a href="#" class="icon-cancel close" data-dismiss="alert"></a>
									<div class="alert-content">'.__('You need to be logged in to edit your profile.','framework').'</div>
								</div>';

						}

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
		
		<?php dynamic_sidebar( 'Page Sidebar' ); ?>

	</div>

	<?php } ?>

	<div class="clear"></div>

</section><!-- end page wrapper -->

<?php get_footer(); ?>