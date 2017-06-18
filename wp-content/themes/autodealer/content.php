<?php
/**
 * Template file required to display posts
 */

$blog_layout = get_field('blog_layout','option');

/**
 * Classic Style
 */
if( $blog_layout == 'Classic Style' || $blog_layout == '' || is_single()) { ?>

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

	<section id="post-data" class="one_sixth">

		<span class="top-day"><?php the_time('d'); ?></span>

		<span class="bottom-date"><?php the_time('M Y'); ?></span>

	</section>

	<section id="post-content" class="five_sixth last">

	<?php if(!is_single()) { ?>

		<h3 class="post-title">
			<a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a>
		</h3>

	<?php } ?>
	
		<div class="meta-wrapper">

			<ul>
				<li>
					<span><i class="icon-user"></i><?php echo __('By: ', 'framework'); ?></span> <?php the_author_posts_link(); ?>
				</li>
				<li>
					<span><i class="icon-chat"></i><?php echo __('With ','framework');?></span> <?php comments_popup_link(__('0 Comments', 'framework'), __('1 Comment', 'framework'), '% Comments'.''); ?>
				</li>
				<li>
					<span><i class="icon-folder-1"></i><?php echo __('In ','framework');?></span> <?php the_category(', '); ?> <?php the_tags( ); ?>
				</li>
			</ul>

		</div>

		<div class="post-content">
			<?php the_content('<span class="more-link">'.__('Continue Reading &raquo;','framework').'</span>');?>
		</div>

	</section>

	<div class="clear"></div>

<?php } else if($blog_layout == 'Mini Style') { ?>

	<section class="one_half">
		<?php if ( has_post_thumbnail()) { 

			$thumb = get_post_thumbnail_id();
			$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
			$image = aq_resize( $img_url, 415, 340, true ); //resize & crop the image

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
	</section>

	<section id="post-content" class="one_half last">

		<h3 class="post-title">
			<a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a>
		</h3>

		<div class="meta-wrapper">

			<ul>
				<li>
					<span><i class="icon-user"></i><?php echo __('By: ', 'framework'); ?></span> <?php the_author_posts_link(); ?>
				</li>
				<li>
					<span><i class="icon-chat"></i></span> <?php comments_popup_link(__('0 Comments', 'framework'), __('1 Comment', 'framework'), '% Comments'.''); ?>
				</li>

				<li>
					<span><i class="icon-calendar"></i><?php echo __('On ','framework');?></span> <?php the_time('d, M Y'); ?>
				</li>
			</ul>

		</div>

		<div class="post-content">
			<?php the_content('<span class="more-link">'.__('Continue Reading &raquo;','framework').'</span>');?>
		</div>

	</section>

	<div class="clear"></div>

<?php } ?>