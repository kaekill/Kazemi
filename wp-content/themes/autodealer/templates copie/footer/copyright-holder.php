<?php
/**
 * The template for displaying the footer copyright.
 *
 * @package ThemesDepot Framework
 */
 ?>

<div id="copyright-holder">
			<span class="footer-border"></span>

			<?php the_field('copyright_text','option');?>

			<div id="footer-social">
				<?php echo dp_social_icon();?>
			</div>
</div>