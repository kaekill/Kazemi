<?php
/**
 * Template Name: All Brands
 * The Template for displaying the all brands page.
 *
 * @package ThemesDepot Framework
 */

get_header(); 

// Include Page Inner Header
get_template_part( 'templates/headers/page', 'header' );

?>

<section id="page-wrapper" class="wrapper">

	
	<div id="page-content" class="fullwidth">

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

			            $terms = get_terms("vehicle_model",'hide_empty=0&parent=0');
			            $count = count($terms);
			            if ( $count > 0 ){

			                echo "<ul class='brand_list2'>";
			                foreach ( $terms as $term ) {

			                	if(get_field('add_brand_image', 'vehicle_model_' . $term->term_id )) { ?>
			                		
			                		<li class="">
			                			<a href="<?php echo get_term_link( $term );?>">
			                				<img src="<?php echo get_field('add_brand_image', 'vehicle_model_' . $term->term_id ); ?>"/>
			                			</a>

			                			<div class="brand-information">

			                				<h5><?php printf(__("%s Offers Available", "framework"), $term->count ); ?></h5>

			                				<a href="<?php echo get_term_link( $term );?>" class="btn small white"><?php _e('View Offers &raquo;','framework');?></a>

			                			</div>

			                		</li>  

			                	<?php }

			                }
			               	echo "</ul>";
			            }
			        
			        ?>

					</article>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'index' ); ?>

			<?php endif; ?>

	</div>

	<div class="clear"></div>

</section><!-- end page wrapper -->

<?php get_footer(); ?>
