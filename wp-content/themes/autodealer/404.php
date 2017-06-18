<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package ThemesDepot Framework
 */

get_header(); 

// Include Page Inner Header
get_template_part( 'templates/headers/404', 'header' );

?>

<section id="page-wrapper" class="wrapper <?php if(get_field('remove_subheader_spacing')) { echo 'remove-margin';}?>">

	<div id="page-content" class="not-found-wrapper">

		<i class="icon-attention-circled"></i>

		<h1><?php _e('Error 404: Page Not Found','framework');?></h1>

		<p><?php _e( 'It looks like nothing was found at this location. ', 'framework' ); ?></p>

		<a href="<?php echo home_url();?>"><?php _e('Back To The Homepage','framework');?></a>

	</div>

</section>


<?php get_footer(); ?>