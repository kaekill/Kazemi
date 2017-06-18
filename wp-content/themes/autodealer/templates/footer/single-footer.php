<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package ThemesDepot Framework
 */
$footer_columns = get_field('widgetized_columns','option');

//get the stat column content 
$str_string = get_field('stats_column_content','option');

//search for values to replace
$search = array('%total_vehicles%', '%total_users%', '%submit%');

//prepare variables to replace
$available_vehicles = wp_count_posts('vehicles')->publish;

if($available_vehicles == '' || $available_vehicles == '0') {
	$available_vehicles = 'None Yet';
}

$count_posts = '<span class="number">'.$available_vehicles.'</span>';

$users = count_users();
$total_users = '<span class="number">'.$users['total_users'].'</span>';

$submit_page = get_field('submit_page','option');

$submit_button = '<a class="big-button" href="'.$submit_page.'">'.__('Submit Your Vehicle','framework').' <i class="icon-plus-circled"></i></a>';

//merge search & replace
$replace = array( $count_posts, $total_users , $submit_button);

?>

<div class="top-footer two_third footer-single-column">

			<?php if($footer_columns == '4') { ?>

				<div class="one_fourth">
							<?php dynamic_sidebar( 'Footer 1' ); ?>
				</div>


				<div class="one_fourth">
							<?php dynamic_sidebar( 'Footer 2' ); ?>
				</div>


				<div class="one_fourth">
							<?php dynamic_sidebar( 'Footer 3' ); ?>
				</div>


				<div class="one_fourth last">
							<?php dynamic_sidebar( 'Footer 4' ); ?>
				</div>

			<?php } else if($footer_columns == '3') { ?>

				<div class="one_third">
							<?php dynamic_sidebar( 'Footer 1' ); ?>
				</div>

				<div class="one_third">
							<?php dynamic_sidebar( 'Footer 2' ); ?>
				</div>

				<div class="one_third last">
							<?php dynamic_sidebar( 'Footer 3' ); ?>
				</div>

			<?php } else if($footer_columns == '2') { ?>

				<div class="one_half">
							<?php dynamic_sidebar( 'Footer 1' ); ?>
				</div>

				<div class="one_half last">
							<?php dynamic_sidebar( 'Footer 2' ); ?>
				</div>

			<?php } ?>

			<div class="clearboth"></div>

			<?php get_template_part( 'templates/footer/copyright', 'holder' ); ?>

</div>

<div class="stats-column one_third last">

	<div class="internal">
		
		<?php echo str_replace($search, $replace, $str_string ); ?>

	</div>

</div>

<div class="clearboth"></div>