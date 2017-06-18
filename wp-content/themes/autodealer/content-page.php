<?php
/**
 * Template file required to display posts
 */

?>
	
	<?php if ( has_post_thumbnail()) { 

		$thumb = get_post_thumbnail_id();
		$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
		$image = aq_resize( $img_url, 815, 300, true ); //resize & crop the image

		?>

		<figure class="post-img media">

			<div class="mediaholder">

				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="image-link" data-effect="">
					<img src="<?php echo $image ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
					<div class="hovercover">
			            <div class="hovericon"><i class="icon-eye"></i></div>
			         </div>
				</a>


			</div>

		</figure>

	<?php } ?>

	<section id="post-content">

		<div class="the-content">
			<?php the_content('<span class="more-link">'.__('Continue Reading &raquo;','framework').'</span>');?>
		</div>

	</section>

	<div class="clear"></div>