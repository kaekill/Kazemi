<?php
/**
 * The Template for displaying vehicle infobar
 *
 * @package ThemesDepot Framework
 */
$address = get_field('vehicle_position');
?>

<div id="vehicle-infobar">

	<div class="wrapper">

		<ul id="vehicle-toggle">
			<li id="vehicle-description" class="current-item"><a class="btn small" href="#"><i class="icon-info"></i> <?php _e('Vehicle Description','framework');?></a></li>
			<?php if(!empty($address['address'])) { ?>
			<li id="vehicle-location"><a class="btn small" href="#" ><i class="icon-location"></i> <?php _e('View Vehicle Location','framework');?></a></li>
			<?php } ?>
		</ul>

		<div id="vehicle-share">

			<ul class="share-menu">
			    <li>
			        <a href="#" class="btn small"><i class="icon-share"></i> <?php _e('Share Vehicle','framework');?> </a>
			        <ul>
			            <li><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>"><i class="icon-facebook"></i></a></li>
			            <li><a href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink(); ?>"><i class="icon-twitter"></i></a></li>
			            <li><a href="http://google.com/bookmarks/mark?op=edit&amp;bkmk=<?php the_permalink() ?>&amp;title=<?php echo urlencode(the_title('', '', false)) ?>"><i class="icon-gplus"></i></a></li>
			            <li><a href="mailto:?subject=<?php the_title();?>&amp;body=<?php the_permalink() ?>"><i class="icon-mail-1"></i></a></li>
			        </ul>
			    </li>
			</ul>

			<a class="btn small " href="javascript:window.print()"><i class="icon-print"></i> <?php _e('Print This Page','framework');?></a>

			<?php 
				
				if(get_field('enable_favorites_system','option') && is_user_logged_in()) {
					tdp_link();
				} else if(get_field('enable_favorites_system','option') && !is_user_logged_in()) {
					echo '<span class="tdp_fav-span"><a href="#" class="btn small" id="fav-nonlogged"><i class="icon-star"></i>'.__('Add To Favorites','framework').'</a></span>';
				}
				
			?>

		</div>

	</div>

</div>

<?php if(get_field('enable_favorites_system','option') && !is_user_logged_in()) { ?>

<div class="wrapper" id="fav-logged-message">
	
	<div class="alert-box warning ">
		<a href="#" class="icon-cancel close" data-dismiss="alert"></a>
		<div class="alert-content">
			<?php _e('Only registered users can save vehicles to their favorites. Login to save vehicles to your favorites.','framework');?>
		</div>
	</div>

</div>

<?php } ?>