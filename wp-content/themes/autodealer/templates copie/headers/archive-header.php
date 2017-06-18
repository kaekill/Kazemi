<?php
/**
 * Template file required to display the page inner header
 */

$header_content_type = get_field('page_header_content_type');

// Adjust alignment through css - so we assign a class
$page_header_class = null;
$bd_class = null;

if($header_content_type == '' || $header_content_type == 'Title Only')  {
	$page_header_class = 'class="title_only" ';
	$bd_class = 'class="title_only_bd" ';
} else if ($header_content_type == 'Title With Subtitle') {
	$bd_class = 'class="push_bd" ';
}

$has_overlay = get_field('overlay_color');

?>

<section id="page-top" <?php echo $page_header_class; ?>>

	<?php if($has_overlay) { ?>

		<div id="page-overlay"></div>

	<?php } ?>
				
	<div class="wrapper">

		<div class="one_half" id="header-left-content">

			<h1><?php _e('Browse Vehicles','framework'); ?></h1>

		</div>

		<div class="one_half last">

			<div id="breadcrumb-wrapper" <?php echo $bd_class; ?>>

				<?php if(function_exists('bcn_display')) { bcn_display(); } ?>

			</div>

		</div>

		<div class="clear"></div>

	</div>

</section>