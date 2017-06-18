<?php
/**
 * Template file required to display the dashboard inner header
 */

global $current_user;
get_currentuserinfo();

?>

<div id="vehicle-infobar">

	<div class="wrapper">
		
		<?php if(is_user_logged_in()) { ?>

		<span><i class="icon-list-numbered"></i> <?php printf( __( 'You have added a total of <span>%d</span> vehicles on sale.', 'framework' ), tdp_count_user_posts_by_type( $current_user->ID ,'vehicles') ); ?></span>
		
		<?php } ?>

		<a href="<?php the_field('submit_page','option');?>" class="pull-right btn small" id="dash-add-button"><i class="icon-list-add"></i> <?php _e('Add New Vehicle','framework');?></a>
	</div>

</div>