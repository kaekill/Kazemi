<?php
/**
 * The Template for displaying single vehicle gallery
 *
 * @package ThemesDepot Framework
 */

 ?>

<script type="text/javascript">
	jQuery(window).load(function() {
		  jQuery('#carousel').flexslider({
		    animation: "slide",
		    controlNav: false,
		    animationLoop: false,
		    slideshow: false,
		    itemWidth: 150,
		    prevText: "",           //String: Set the text for the "previous" directionNav item
			nextText: "",
		    itemMargin: 1,
		    asNavFor: '#slider',
		    
		  });
		   
		  jQuery('#slider').flexslider({
		    animation: "slide",
		    controlNav: false,
		    animationLoop: false,
		    prevText: "",           //String: Set the text for the "previous" directionNav item
			nextText: "",
		    slideshow: false,
		    sync: "#carousel",
		    start: function(){
		         jQuery('#slider ul.slides img').show(); 
		    },
		  });

		  });

</script>




<div id="slider" class="flexslider" >
	
	<ul class="slides gallery_thumbs loading">
		
		<?php if ( has_post_thumbnail()) { 
			$thumb = get_post_thumbnail_id();
			$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
		?>

		<li  class="flex-element">
			<a href="<?php echo $img_url ?>" title="<?php the_title(); ?>" class="image-link" data-effect="">
				<img src="<?php echo fImg::resize( $img_url, 600, 350, true ); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
			</a>
		</li>

		<?php } ?>



		<?php if(get_field('additional_image_1')) { 

			if(is_numeric(get_field('additional_image_1'))) {
				$additiona_image1 = wp_get_attachment_url( get_field('additional_image_1') );
			} else {
				$additiona_image1 = get_field('additional_image_1');
			}

		?>
			<li  class="flex-element">
				<a href="<?php echo $additiona_image1 ?>" title="<?php the_title(); ?>" class="image-link" data-effect="">	
					<img src="<?php echo fImg::resize( $additiona_image1, 600, 350, true ); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
				</a>
			</li>
		<?php } ?>

		<?php if(get_field('additional_image_2')) { 

			if(is_numeric(get_field('additional_image_2'))) {
				$additiona_image2 = wp_get_attachment_url( get_field('additional_image_2') );
			} else {
				$additiona_image2 = get_field('additional_image_2');
			}

		?>
			<li  class="flex-element">
				<a href="<?php echo $additiona_image2 ?>" class="image-link" data-effect="">	
					<img src="<?php echo fImg::resize( $additiona_image2, 600, 350, true ); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
				</a>
			</li>
		<?php } ?>

		<?php if(get_field('additional_image_3')) { 

			if(is_numeric(get_field('additional_image_3'))) {
				$additiona_image3 = wp_get_attachment_url( get_field('additional_image_3') );
			} else {
				$additiona_image3 = get_field('additional_image_3');
			}

		?>
			<li  class="flex-element">
				<a href="<?php echo $additiona_image3 ?>" title="<?php the_title(); ?>" class="image-link" data-effect="">	
					<img src="<?php echo fImg::resize( $additiona_image3, 600, 350, true ); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
				</a>
			</li>
		<?php } ?>

		<?php if(get_field('additional_image_4')) { 

			if(is_numeric(get_field('additional_image_4'))) {
				$additiona_image4 = wp_get_attachment_url( get_field('additional_image_4') );
			} else {
				$additiona_image4 = get_field('additional_image_4');
			}

		?>
			<li  class="flex-element">
				<a href="<?php echo $additiona_image4 ?>" title="<?php the_title(); ?>" class="image-link" data-effect="">	
					<img src="<?php echo fImg::resize( $additiona_image4, 600, 350, true ); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
				</a>
			</li>
		<?php } ?>

		<?php if(get_field('additional_image_5')) { 

			if(is_numeric(get_field('additional_image_5'))) {
				$additiona_image5 = wp_get_attachment_url( get_field('additional_image_5') );
			} else {
				$additiona_image5 = get_field('additional_image_5');
			}

		?>
			<li  class="flex-element">
				<a href="<?php echo $additiona_image5 ?>" title="<?php the_title(); ?>" class="image-link" data-effect="">	
					<img src="<?php echo fImg::resize( $additiona_image5 , 600, 350, true ); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
				</a>
			</li>
		<?php } ?>

	</ul>

	<?php if(get_field('discount')) { ?>

		<span class="new-badge"><?php the_field('discount');?> <?php _e('Off','framework');?></span>

	<?php } ?>

</div>


<div id="carousel" class="flexslider">
	
	<ul class="slides">
		
		<?php if ( has_post_thumbnail()) { 
			$thumb = get_post_thumbnail_id();
			$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
			$image = aq_resize( $img_url, 500, 500, true ); //resize & crop the image
		?>

		<li>
			<img src="<?php echo fImg::resize( $img_url, 107, 58, true ); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
		</li>

		<?php } ?>

		<?php if(get_field('additional_image_1')) { ?>
			<li>
				<img src="<?php echo fImg::resize( $additiona_image1 , 107, 58, true ); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
			</li>
		<?php } ?>
		
		<?php if(get_field('additional_image_2')) { ?>
			<li>
				<img src="<?php echo fImg::resize( $additiona_image2, 107, 58, true ); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
			</li>
		<?php } ?>

		<?php if(get_field('additional_image_3')) { ?>
			<li>
				<img src="<?php echo fImg::resize( $additiona_image3, 107, 58, true ); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
			</li>
		<?php } ?>

		<?php if(get_field('additional_image_4')) { ?>
			<li>
				<img src="<?php echo fImg::resize( $additiona_image4, 107, 58, true ); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
			</li>
		<?php } ?>

		<?php if(get_field('additional_image_5')) { ?>
			<li>
				<img src="<?php echo fImg::resize( $additiona_image5, 107, 58, true ); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">
			</li>
		<?php } ?>
	</ul>

</div>