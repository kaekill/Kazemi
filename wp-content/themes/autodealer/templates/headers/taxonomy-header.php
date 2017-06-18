<?php
/**
 * Template file required to display the page inner header for taxonomies
 */

$header_content_type = get_field('categories_header_type','option');

// Adjust alignment through css - so we assign a class
$page_header_class = null;
$bd_class = null;

if($header_content_type == '' || $header_content_type == 'Title Only')  {
	$page_header_class = 'class="title_only" ';
	$bd_class = 'class="title_only_bd" ';
} else if ($header_content_type == 'Title With Subtitle') {
	$bd_class = 'class="push_bd" ';
}

$has_overlay = get_field('categories_header_overlay_color','option');

?>

<section id="page-top" <?php echo $page_header_class; ?>>

	<?php if($has_overlay) { ?>

		<div id="page-overlay"></div>

	<?php } ?>
				
	<div class="wrapper">

		<div class="one_half" id="header-left-content">

			<?php if($header_content_type == '' || $header_content_type == 'Title Only') { ?>

				<h1><?php single_cat_title( ); ?></h1>

			<?php } else if ($header_content_type == 'Title With Subtitle') { ?>

				<h1><?php single_cat_title(); ?></h1>

				<span class="tax-desc"><?php echo category_description( ); ?></span>

			<?php } ?>

		</div>

		<div class="one_half last">

			<div id="breadcrumb-wrapper" <?php echo $bd_class; ?>>

				<?php if(function_exists('bcn_display')) { bcn_display(); } ?>

			</div>

		</div>

		<div class="clear"></div>

	</div>

</section>