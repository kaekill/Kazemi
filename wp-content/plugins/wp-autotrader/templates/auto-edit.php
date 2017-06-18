<?php
/**
 * Auto Edit
 */
if ( ! defined( 'ABSPATH' ) ) exit;

global $auto_manager;

?>

<?php if($_GET['action'] == 'edit') { ?>

	<div class="alert-box warning ">
		<a href="#" class="icon-cancel close" data-dismiss="alert"></a>
		<div class="alert-content"><?php _e('You are currently modifying an existing vehicle.','auto_manager');?> <a href="<?php the_field('dashboard_page','option');?>"><?php _e('Click here to go back to the dashboard','auto_manager');?></a></div>
	</div>

<?php } ?>
