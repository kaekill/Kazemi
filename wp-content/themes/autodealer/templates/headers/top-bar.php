<?php
/**
 * Template file required to display the top bar
 */

// Get user information
global $current_user;
get_currentuserinfo();

/**
 * Replace Strings In Message
 */

$str_string = get_field('top_bar_logged_in_content','option');

$str_nonlogged = get_field('top_bar_visitors_content','option');

$search = array('%user_name%', '%email%', '%phone%', '%social_icons%');

$email_address = '<i class="icon-mail-alt"></i><a href="mailto:' .get_field('email_address','option').  '">' . get_field('email_address','option') . '</a>';

$phone = '<i class="icon-phone"></i><a href="tel:' .get_field('phone_number','option').  '">' . get_field('phone_number','option') . '</a>';

$social_icons = '';

$replace = array( $current_user->display_name, $email_address , $phone, $social_icons); 

?>
<section id="top-bar">

	<div class="wrapper">

		<div class="one_half top-intro-text">

			<div class="top-inner-wrapper">	

				<?php echo str_replace($search, $replace, $str_nonlogged ); ?>

			</div>

		</div>

		<div class="one_half last" id="top-right-side">

			<?php 

				/**
				 * Display profile when logged in
				 */

				if(is_user_logged_in()) { ?>

					<div class="user-profile">

						<ul class="user-module">

							<li class="dropit-trigger dropit-open">
								<a href="#" class="btn2 small2"><i class="icon-home-1"></i> <?php _e('My Garage','framework');?></a>
								<ul class="dropit-submenu">
						            <li><a href="<?php the_field('dashboard_page','option');?>"><i class="icon-gauge-1"></i> <?php _e('Dashboard','framework');?></a></li>
						            <li><a href="<?php the_field('submit_page','option');?>"><i class="icon-plus-circled-1"></i> <?php _e('Sell Vehicle','framework');?></a></li>
						            <li><a href="<?php the_field('edit_profile_page','option');?>"><i class="icon-cog"></i> <?php _e('Your Settings','framework');?></a></li>
						            <?php if(current_user_can( 'edit_dealer_fields' )) { ?>
						            <li><a href="<?php the_field('dealer_profile_page','option');?>?dealer_profile=<?php echo get_current_user_id(); ?>"><i class="icon-user-1"></i> <?php _e('View Your Profile','framework');?></a></li>
						            <?php } ?>
						            <li><a href="<?php echo wp_logout_url( home_url() ); ?>"><i class="icon-off"></i> <?php _e('Logout','framework');?></a></li>
						        </ul>
							</li>

							<?php if(get_field('display_profile_link_in_top_bar','option')) { ?>

							<li class="adj-btn"><span class="btn2 small2 username"><a href='<?php echo get_field('dashboard_page','option');?>'><i class='icon-user-1'></i> <?php echo $current_user->display_name; ?></a></span></li>

							<?php } ?>

							<li><a href="<?php echo wp_logout_url( home_url() ); ?>"><i class="icon-off"></i> <?php _e('Logout','framework');?></a></li>

						</ul>


					</div>

			<?php } 

				/**
				 * Display Login Form When Non Logged In
				 */

				else { ?>


					<div class="user-profile">

						<ul class="user-module">

						<?php if(function_exists('add_modal_login_button')) { ?>

							<li><?php _e('Hello visitor, not registered yet?','framework');?></li>

							<li><a href="#login-box" id="open-login" class="login wpml-btn login-window"><i class="icon-login"></i> <?php _e('Sign In','framework');?> <i class="icon-user-1"></i> <?php _e('Register Now','framework');?></a></li>

						<?php } else { ?>

							<li>Please Enable Frontend Connection Module in "Hangar" from your WP Dashboard</li>

						<?php } ?>

						</ul>	

					</div>

			<?php } ?>

		</div>

		<div class="clear"></div>

	</div><!-- end wrapper -->

</section><!-- end topbar -->