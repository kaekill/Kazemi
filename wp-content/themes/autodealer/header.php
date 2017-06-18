<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package ThemesDepot Framework
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<meta name="description" content="<?php bloginfo('description'); ?>" />
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="theme-wrapper">

	
	<?php 

		do_action( 'tdp_open_body' );

		/**
		 * Check if topbar is enabled and display it.
		 */
		if(get_field('display_top_bar','option')) {

			get_template_part( 'templates/headers/top', 'bar' );

		}
	
	?>

	<header>

		<section class="wrapper">

			<div id="mobile-menu">
				<nav>
					<?php wp_nav_menu( array( 'theme_location' => 'responsive-menu', 'menu_class' => 'mobile-menu', )); ?>
				</nav>
			</div>
			
			<div id="logo-container" class="one_third">

				<?php 

				/**
				 * Display The Logo
				 */

				do_action( 'tdp_display_logo' );

				?>

			</div>

			<div id="navigation-wrapper" class="two_third last">

				<?php 

				/**
				 * Display Navigation
				 */

				do_action( 'tdp_display_navigation', 'primary_menu', 'sf-menu', false );

				?>

			</div>

			<div class="clear"></div>

		</section> <!-- end section -->

	</header><!-- header end -->

	<?php do_action('tdp_after_header'); ?>
