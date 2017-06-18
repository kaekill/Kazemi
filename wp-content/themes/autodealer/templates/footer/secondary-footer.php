<?php 
/**
 * The template for displaying the secondary footer.
 * @package ThemesDepot Framework
 */

 $secondary_footer_columns = get_field('additional_footer_widgetized_columns','option');

 ?>

 <div class="wrapper">

 	<?php if( $secondary_footer_columns == '4') { ?>

		<div class="one_fourth">
					<?php dynamic_sidebar( 'Secondary Footer 1' ); ?>
		</div>


		<div class="one_fourth">
					<?php dynamic_sidebar( 'Secondary Footer 2' ); ?>
		</div>


		<div class="one_fourth">
					<?php dynamic_sidebar( 'Secondary Footer 3' ); ?>
		</div>


		<div class="one_fourth last">
					<?php dynamic_sidebar( 'Secondary Footer 4' ); ?>
		</div>

	<?php } else if( $secondary_footer_columns == '3') { ?>

		<div class="one_third">
					<?php dynamic_sidebar( 'Secondary Footer 1' ); ?>
		</div>

		<div class="one_third">
					<?php dynamic_sidebar( 'Secondary Footer 2' ); ?>
		</div>

		<div class="one_third last">
					<?php dynamic_sidebar( 'Secondary Footer 3' ); ?>
		</div>

	<?php } else if( $secondary_footer_columns == '2') { ?>

		<div class="one_half">
					<?php dynamic_sidebar( 'Secondary Footer 1' ); ?>
		</div>

		<div class="one_half last">
					<?php dynamic_sidebar( 'Secondary Footer 2' ); ?>
		</div>

	<?php } ?>

		<div class="clearboth"></div>

 </div>