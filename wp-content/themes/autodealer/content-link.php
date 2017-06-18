<?php
/**
 * Template file required to display posts gallery
 */

$blog_layout = get_field('blog_layout','option');

$thumbnail_size = 'blog-thumb';

/**
 * Classic Style
 */
if( $blog_layout == 'Classic Style' || $blog_layout == '' || is_single()) { ?>
	
	<div class="post-link">

		<?php if(get_field('link_label')) { ?>

			<a href="<?php the_field('link');?>"><i class="icon-link-1"></i> <?php the_field('link_label');?></a>

		<?php } else { ?>

			<a href="<?php the_field('link');?>"><i class="icon-link-1"></i> <?php the_field('link');?></a>

		<?php } ?> 

	</div>	 

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
					<span><i class="icon-folder-1"></i><?php echo __('In ','framework');?></span> <?php the_category(', '); ?>
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
		
		<div class="post-link">

		<?php if(get_field('link_label')) { ?>

			<a href="<?php the_field('link');?>"><i class="icon-link-1"></i> <?php the_field('link_label');?></a>

		<?php } else { ?>

			<a href="<?php the_field('link');?>"><i class="icon-link-1"></i> <?php the_field('link');?></a>

		<?php } ?> 

		</div>	

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