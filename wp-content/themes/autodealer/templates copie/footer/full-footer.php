<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package ThemesDepot Framework
 */
$footer_columns = get_field('widgetized_columns','option');
?>

<div class="top-footer">

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

</div>

<?php get_template_part( 'templates/footer/copyright', 'holder' ); ?>