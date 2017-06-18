<?php
/**
 * Template file required to display the profile information
 */

$user_id = sanitize_title($_GET['dealer_profile']);
$user_info = get_userdata($user_id);

//print_r($user_info);
$display_name = $user_info->display_name;
$registered = ($user_info->user_registered . "\n");
$get_reg_date = date("F j, Y", strtotime($registered));

$vehicles_submitted = tdp_count_user_posts_by_type($user_id, 'vehicles');

?>

<div id="vehicle-infobar">

	<div class="wrapper">
		<span><i class="icon-user-1"></i> <?php printf( __( '%s has been a member since %s and has a total of <span>%d</span> vehicles on sale.', 'framework' ), $display_name, $get_reg_date, $vehicles_submitted ); ?></span>
		<a href="<?php echo $user_info->business_website; ?>" target="_blank" class="pull-right btn small" id="dash-add-button" rel="nofollow"><i class="icon-link-ext-alt"></i> <?php _e('Visit Dealer Website &raquo;','framework');?></a>
	</div>

</div>