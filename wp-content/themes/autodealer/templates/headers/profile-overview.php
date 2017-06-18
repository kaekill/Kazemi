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

<div id="profile-overview">

	<div class="wrapper">

		<div class="user-description">

			<div class="one_third">

				<h3><?php printf( __( 'About %s:', 'framework' ), $display_name ); ?></h3>

				<?php 
					echo $user_info->business_description;
				?>

			</div>

			<div class="one_third">

				<h3><?php _e('Follow Us:','framework') ?></h3>

				<ul id="profile-socials">
					<?php if($user_info->twitter) { ?>
						<li><a href="<?php echo $user_info->twitter;?>"><i class="icon-twitter"></i></a></li>
					<?php } ?>
					<?php if($user_info->facebook) { ?>
						<li><a href="<?php echo $user_info->facebook;?>"><i class="icon-facebook"></i></a></li>
					<?php } ?>
					<?php if($user_info->linkedin) { ?>
						<li><a href="<?php echo $user_info->linkedin;?>"><i class="icon-linkedin"></i></a></li>
					<?php } ?>
				</ul>

			</div>

			<div class="one_third last">

				<h3><?php _e('Get In Touch:','framework') ?></h3>

				<p><i class="icon-phone"></i><?php echo $user_info->business_phone_number;?></p>
				<p><i class="icon-location"></i><?php echo $user_info->business_location;?></p>

			</div>

			<div class="clearboth"></div>

		</div>
		
	</div>

</div>