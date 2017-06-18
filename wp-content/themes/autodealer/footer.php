<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package ThemesDepot Framework
 */

?>

<?php if(get_field('enable_additional_footer','option')) { ?>

<section id="pre-footer">
	
	<?php get_template_part( 'templates/footer/secondary', 'footer' ); ?>

</section>

<?php } ?>

<footer <?php if(get_field('enable_stats_column','option')) { echo 'class="override-margin"'; } ?>>

	<div class="wrapper">

		<?php if(get_field('enable_stats_column','option')) { ?>

			<?php get_template_part( 'templates/footer/single', 'footer' ); ?>

		<?php } else { ?>

			<?php get_template_part( 'templates/footer/full', 'footer' ); ?>

		<?php } ?>

	</div>

</footer>
<a id="to-top"><i class="icon-angle-up"></i></a>
</div><!-- end theme wrapper -->
<?php wp_footer(); ?>
</body>
</html>