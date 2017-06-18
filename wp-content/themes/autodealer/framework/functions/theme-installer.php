<?php
/**
 * TDP - Theme Installer Plugin Configuration File
 *
 * @package ThemesDepot Framework
 */

/**
 * Add Setup Steps To Plugin Interface
 */
function tdp_installer_steps() { ?>

	<?php 
	
	?>

	<div class="setup-entry">

		<div class="setup-number">1</div>

		<div class="setup-desc">

			<h3>Install The Theme "<?php echo wp_get_theme( );?>"</h3>
			<p class="step-desc">
				Theme has been correctly installed and it's now ready to be used. Make sure that all the steps described here are marked as done (the green icon here on the right).
			</p>

		</div>

		<div class="setup-status">
			<i class="icon-check-1"></i>
		</div>

	</div>

	<div class="setup-entry">

		<div class="setup-number">2</div>

		<div class="setup-desc">

			<h3>Install and enable the "TDP AutoDealer" Plugin</h3>
			<p class="step-desc">
				The "TDP AutoDealer" plugin is the plugin required for the frontend submission system. 
			</p>

		</div>

		<div class="setup-status">
			<?php if ( in_array( 'wp-autotrader/wp-auto-manager.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?>
			<i class="icon-check-1"></i>
			<?php } else { ?>
			<i class="icon-attention-1"></i>
			<?php } ?>
		</div>

	</div>

	<div class="setup-entry">

		<div class="setup-number">3</div>

		<div class="setup-desc">

			<h3>Install and enable the "Breadcrumb NavXT" Plugin</h3>
			<p class="step-desc">
				Install the Breadcrumb NavXT plugin. 
			</p>

		</div>

		<div class="setup-status">
			<?php if ( in_array( 'breadcrumb-navxt/breadcrumb-navxt.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?>
			<i class="icon-check-1"></i>
			<?php } else { ?>
			<i class="icon-attention-1"></i>
			<?php } ?>
		</div>

	</div>

	<div class="setup-entry">

		<div class="setup-number">4</div>

		<div class="setup-desc">

			<h3>Install and enable the "TDP - Frontend Edit Profile" Plugin</h3>
			<p class="step-desc">
				Install the TDP - Frontend Edit Profile to display a form on the frontend that allows you to modify the profile from the frontend.
			</p>

		</div>

		<div class="setup-status">
			<?php if ( in_array( 'tdp-profile-edit/tdp-profile-edit.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?>
			<i class="icon-check-1"></i>
			<?php } else { ?>
			<i class="icon-attention-1"></i>
			<?php } ?>
		</div>

	</div>

	<div class="setup-entry">

		<div class="setup-number">5</div>

		<div class="setup-desc">

			<h3>Install and enable the "TDP Shortcodes" Plugin</h3>
			<p class="step-desc">
				Install the TDP Shortcodes plugin to add a powerful set of shortcodes to your theme.
			</p>

		</div>

		<div class="setup-status">
			<?php if ( in_array( 'tdp-shortcodes/tdp-shortcodes.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?>
			<i class="icon-check-1"></i>
			<?php } else { ?>
			<i class="icon-attention-1"></i>
			<?php } ?>
		</div>

	</div>

	<div class="setup-entry">

			<div class="setup-number">6</div>

			<div class="setup-desc">

				<h3>Install and enable the "WooCommerce" Plugin</h3>
				<p class="step-desc">
					The "WooCommerce" plugin is required to process payments subscriptions and checkout for your memberships connected to the frontend submission system. 
				</p>

			</div>

			<div class="setup-status">
				<?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?>
				<i class="icon-check-1"></i>
				<?php } else { ?>
				<i class="icon-attention-1"></i>
				<?php } ?>
			</div>

	</div>

	<div class="setup-entry">

			<div class="setup-number">7</div>

			<div class="setup-desc">

				<h3>Install and enable the "WP-PageNavi" Plugin</h3>
				<p class="step-desc">
					The "WP-PageNavi" plugin is required to for the pagination system of the theme. 
				</p>

			</div>

			<div class="setup-status">
				<?php if ( in_array( 'wp-pagenavi/wp-pagenavi.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?>
				<i class="icon-check-1"></i>
				<?php } else { ?>
				<i class="icon-attention-1"></i>
				<?php } ?>
			</div>

	</div>

	<div class="setup-entry">

		<div class="setup-number">8</div>

		<div class="setup-desc">

			<h3>Save Default Theme Options</h3>
			<p class="step-desc">
				<a href="<?php echo admin_url('admin.php?page=acf-options-theme-options');?>">Go to the "Theme Options" panel</a> and 
				press the save button at the bottom of the page, this will ensure the default options are saved. <strong>YOU MUST REPEAT THIS STEP FOR EVERY SUB PAGE OF THE THEME OPTIONS PANEL.</strong>
			</p>

		</div>

		<div class="setup-status">
			<?php if (get_field('categories_layout_settings','option') !== '' && get_field('google_font_url','option') !=='' && get_field('maximum_value','option') !== '' && get_field('submit_page','option') !== '' && get_field('dashboard_page','option') !=='') { ?>
			<i class="icon-check-1"></i>
			<?php } else { ?>
			<i class="icon-attention-1"></i>
			<?php } ?>
		</div>

	</div>

	<div class="setup-entry">

		<div class="setup-number">9</div>

		<div class="setup-desc">

			<h3>Change Your Permalink Structure</h3>
			<p class="step-desc">
				<a href="<?php echo admin_url('options-permalink.php');?>">Change your permalink structure</a> and 
				set the option to any other value other than the default one. This is required for the search form to work.
			</p>

		</div>

		<div class="setup-status">
			<?php if (get_option('permalink_structure' ) !== '' ) { ?>
			<i class="icon-check-1"></i>
			<?php } else { ?>
			<i class="icon-attention-1"></i>
			<?php } ?>
		</div>

	</div>

	<div class="setup-entry">

		<div class="setup-number">10</div>

		<div class="setup-desc">

			<h3>Create the homepage</h3>
			<p class="step-desc">
				Navigate to "Pages -> Add New" create a new page and assign one of the homepage template available.
			</p>

		</div>

		<div class="setup-status">
			<?php 

			$homepage1 = get_pages(array(
			    'meta_key' => '_wp_page_template',
			    'meta_value' => 'templates/template-homepage.php',
			));
			$homepage2 = get_pages(array(
			    'meta_key' => '_wp_page_template',
			    'meta_value' => 'templates/template-homepage2.php',
			));

			if ($homepage1 || $homepage2 ) { ?>
			<i class="icon-check-1"></i>
			<?php } else { ?>
			<i class="icon-attention-1"></i>
			<?php } ?>
		</div>

	</div>

	<div class="setup-entry">

		<div class="setup-number">11</div>

		<div class="setup-desc">

			<h3>Setup The Homepage</h3>
			<p class="step-desc">
				<a href="<?php echo admin_url('options-reading.php');?>">Change your frontpage display option to static page</a>, 
				change the option "Front page displays" from "Your latest posts" to "A static page" and select the page you just create from the step above as "Front page"
			</p>

		</div>

		<div class="setup-status">
			<?php

			if (get_option('show_on_front' ) == 'page' ) { ?>
			<i class="icon-check-1"></i>
			<?php } else { ?>
			<i class="icon-attention-1"></i>
			<?php } ?>
		</div>

	</div>

	<div class="setup-entry">

		<div class="setup-number">12</div>

		<div class="setup-desc">

			<h3>Setup The Search Results Page</h3>
			<p class="step-desc">
				Create a new page and assign the page template "Search Results", once published, navigate to <a href="<?php echo admin_url('admin.php?page=acf-options-search-setup');?>">"Theme Options -> Search Setup"</a> and select the page you just created into the option called "Search Results Page". This will ensure the search form correctly works.
			</p>

		</div>

		<div class="setup-status">
			<?php

			$postid = url_to_postid( get_field('search_results_page','option'));

			$page_template = get_page_template_slug( $postid );

			if ($page_template == 'templates/template-search-results.php' ) { ?>
			<i class="icon-check-1"></i>
			<?php } else { ?>
			<i class="icon-attention-1"></i>
			<?php } ?>
		</div>

	</div>

	<div class="setup-entry">

		<div class="setup-number">13</div>

		<div class="setup-desc">

			<h3>Setup Dashboard Page</h3>
			<p class="step-desc">
				Create a new page and assign the page template "User Dashboard", once published, navigate to <a href="<?php echo admin_url('admin.php?page=acf-options-user-dashboard');?>">"Theme Options -> User Dashboard"</a> and select the page you just created into the option called "Dashboard Page". This will ensure frontend dashboard works and it's linked into the menu.
			</p>

		</div>

		<div class="setup-status">
			<?php

			$postid2 = url_to_postid( get_field('dashboard_page','option'));

			$page_template2 = get_page_template_slug( $postid2 );

			if ($page_template2 == 'templates/template-dashboard.php' ) { ?>
			<i class="icon-check-1"></i>
			<?php } else { ?>
			<i class="icon-attention-1"></i>
			<?php } ?>
		</div>

	</div>

	<div class="setup-entry">

		<div class="setup-number">14</div>

		<div class="setup-desc">

			<h3>Setup FrontEnd Submission Page</h3>
			<p class="step-desc">
				Create a new page and assign the page template "Submit Vehicle", once published, navigate to <a href="<?php echo admin_url('admin.php?page=acf-options-vehicles-submission');?>">"Theme Options -> Vehicles Submission"</a> and select the page you just created into the option called "Submit Page". This will ensure frontend submission works and it's linked into the menu.
			</p>

		</div>

		<div class="setup-status">
			<?php

			$postid3 = url_to_postid( get_field('submit_page','option'));

			$page_template3 = get_page_template_slug( $postid3 );

			if ($page_template3 == 'templates/template-submit.php' ) { ?>
			<i class="icon-check-1"></i>
			<?php } else { ?>
			<i class="icon-attention-1"></i>
			<?php } ?>
		</div>

	</div>
	<div class="setup-entry">

		<div class="setup-number">15</div>

		<div class="setup-desc">

			<h3>Setup Edit Profile Page</h3>
			<p class="step-desc">
				Create a new page and assign the page template "Edit Profile", once published, navigate to <a href="<?php echo admin_url('admin.php?page=acf-options-user-dashboard');?>">"Theme Options -> User Dashboard"</a> and select the page you just created into the option called "Edit Profile Page". 
			</p>

		</div>

		<div class="setup-status">
			<?php

			$postid4 = url_to_postid( get_field('edit_profile_page','option'));

			$page_template4 = get_page_template_slug( $postid4 );

			if ($page_template4 == 'templates/template-edit-profile.php' ) { ?>
			<i class="icon-check-1"></i>
			<?php } else { ?>
			<i class="icon-attention-1"></i>
			<?php } ?>
		</div>

	</div>
	<div class="setup-entry">

		<div class="setup-number">16</div>

		<div class="setup-desc">

			<h3>Setup Dealer Profile Page</h3>
			<p class="step-desc">
				Create a new page and assign the page template "Dealer Profile", once published, navigate to <a href="<?php echo admin_url('admin.php?page=acf-options-user-dashboard');?>">"Theme Options -> User Dashboard -> Dealer Profile"</a> and select the page you just created into the option called "Dealer Profile Page". 
			</p>

		</div>

		<div class="setup-status">
			<?php

			$postid5 = url_to_postid( get_field('dealer_profile_page','option'));

			$page_template5 = get_page_template_slug( $postid5 );

			if ($page_template5 == 'templates/template-dealer-profile.php' ) { ?>
			<i class="icon-check-1"></i>
			<?php } else { ?>
			<i class="icon-attention-1"></i>
			<?php } ?>
		</div>

	</div>

<?php }
add_action('tdp_installer_theme_steps','tdp_installer_steps');

/**
 * Automatically Setup Permalinks
 */

function tdp_installer_update_permalinks() {

	update_option( 'permalink_structure', '/%postname%/' );
	// Flush rules after update
	flush_rewrite_rules();

}
add_action( 'tdp_installer_start_setup', 'tdp_installer_update_permalinks' );

/**
 * Automatically Setup Pages For WooCommerce Plugin
 */
function tdp_installer_woocommerce_pages() {

	// Set pages
	$woopages = array(
		'woocommerce_shop_page_id' => 'Shop',
		'woocommerce_cart_page_id' => 'Cart',
		'woocommerce_checkout_page_id' => 'Checkout',
		'woocommerce_pay_page_id' => 'Checkout &#8594; Pay',
		'woocommerce_thanks_page_id' => 'Order Received',
		'woocommerce_myaccount_page_id' => 'My Account',
		'woocommerce_edit_address_page_id' => 'Edit My Address',
		'woocommerce_view_order_page_id' => 'View Order',
		'woocommerce_change_password_page_id' => 'Change Password',
		'woocommerce_logout_page_id' => 'Logout',
		'woocommerce_lost_password_page_id' => 'Lost Password'
	);
	foreach($woopages as $woo_page_name => $woo_page_title) {
		$woopage = get_page_by_title( $woo_page_title );
		if($woopage->ID) {
			update_option($woo_page_name, $woopage->ID); // Front Page
		}
	}

	// We no longer need to install pages
	delete_option( '_wc_needs_pages' );
	delete_transient( '_wc_activation_redirect' );

	// Flush rules after install
	flush_rewrite_rules();

}
add_action( 'tdp_installer_start_setup', 'tdp_installer_woocommerce_pages' );

/**
 * Automatically Setup Menu
 */

function tdp_installer_setup_menu() {

	// Set imported menus to registered theme locations
	$locations = get_theme_mod( 'nav_menu_locations' ); // registered menu locations in theme
	$menus = wp_get_nav_menus(); // registered menus

	if($menus) {
		foreach($menus as $menu) { // assign menus to theme locations
			if( $menu->name == 'Primary Menu' ) {
				$locations['primary_menu'] = $menu->term_id;
				$locations['responsive-menu'] = $menu->term_id;
			} else if( $menu->name == 'Primary Menu' ) {
				$locations['responsive-menu'] = $menu->term_id;
			}
		}
	}

	set_theme_mod( 'nav_menu_locations', $locations ); // set menus to locations
}
add_action( 'tdp_installer_start_setup', 'tdp_installer_setup_menu' );

/**
 * Automatically Setup Widgets
 */
function tdp_installer_import_widgets() {
	// Add data to widgets
	$widgets_json = get_template_directory_uri() . '/framework/data/widget_data.json'; // widgets data file
	tdp_process_import_file( $widgets_json );
}
add_action( 'tdp_installer_start_setup', 'tdp_installer_import_widgets' );

/**
 * Automatically Setup Homepage & Blog
 */
function tdp_installer_setup_homepage() {
	// Set reading options
	$homepage = get_page_by_title( 'Homepage Search' );
	$posts_page = get_page_by_title( 'Blog' );
	if($homepage->ID && $posts_page->ID) {
		update_option('show_on_front', 'page');
		update_option('page_on_front', $homepage->ID); // Front Page
		update_option('page_for_posts', $posts_page->ID); // Blog Page
	}
}
add_action( 'tdp_installer_start_setup', 'tdp_installer_setup_homepage' );