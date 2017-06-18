<?php
/**
 * Template Name: Edit Vehicle
 * The Template for displaying the edit vehicle page
 *
 * @package ThemesDepot Framework
 */
acf_form_head();
get_header(); 

global $wpdb, $wp_query;

$postdata = get_post($_GET['pid'], ARRAY_A);
$authorID = $postdata['post_author'];

// Include Page Inner Header
get_template_part( 'templates/headers/dashboard', 'header' );

get_template_part( 'templates/headers/dashboard', 'info' );

?>

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

						//lets check if the user is editing a post or if he is just visiting this page
						//if it's editing the post show the form
						if (isset($_GET['pid']) && !empty($_GET['pid'])) {

							//now we need to check if the current logged in user is the post author
							//we also need to check that he is not trying to hack the ID

							if($authorID == $current_user->ID) {
								
								$args_edit = array(
									'post_id' => $_GET['pid'],
									'field_groups' => array( 'acf_vehicle-options', 'acf_asd' ),
									'submit_value' => __('Update This Listing &raquo;','framework'), // value for submit field
								);

								echo '<h3 class="form-title"><i class="icon-gauge-1"></i>'.__('Vehicle details', 'framework').'</h3>';

								echo '<div class="alert-box warning ">
		<a href="#" class="icon-cancel close" data-dismiss="alert"></a>
		<div class="alert-content">'.__('You are currently modifying an existing vehicle.','framework').'<a href="'.get_field('dashboard_page','option').'">'.__('Click here to go back to the dashboard','framework').'</a></div>
	</div>';

								acf_form( $args_edit ); 
							
							} else { ?>

								<div id="content-container" class="error-container">

									<h1 class="entry-title">

										<span class="error-title"><i class="icon-frown"></i></span>

										<?php _e( 'Unauthorized Access', 'framework' ); ?>

									</h1>

									<p><?php _e('You are not allowed to edit this listing.','framework');?></p>

								</div>

							<?php }

						} else if(isset($_GET['updated']) && $_GET['updated'] == 'true') { ?>

							<div class="update-ok">

								<i class="icon-ok"></i>

								<h1><?php _e('Vehicle Successfully Updated.','framework');?></h1>

								<br/>

								<a class="btn" href="<?php echo get_field('dashboard_page','option'); ?>"><?php _e('Visit Your Dashboard','framework');?></a>

							</div>

						<?php } else { ?>

							<div class="alert-box warning ">
								<div class="alert-content"><?php _e('Visit your dashboard to edit a vehicle.','framework');?><a href="<?php echo get_field('dashboard_page','option'); ?>"><?php _e('Click here to go back to the dashboard','framework');?></a></div>
							</div>

						<?php } ?>

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
