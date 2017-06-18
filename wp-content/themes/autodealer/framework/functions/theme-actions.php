<?php
/**
 * Core Framework Theme Actions
 */

/**
 * Display Logo
 */
if ( !function_exists('tdp_display_logo') ) { 

	function tdp_display_logo($value='')
	{
		/*
		 *	display the theme logo by checking if the default logo was overwritten in the backend.
		 */
		echo dp_logo(get_template_directory_uri().'/images/logo2.png');
	}

}
add_action('tdp_display_logo','tdp_display_logo');

/**
 * Display Navigation
 */
if ( !function_exists('tdp_display_navigation') ) { 

	function tdp_display_navigation( $menu, $menu_class, $is_megamenu = false )
	{

			if ( has_nav_menu( $menu ) ) {

				if($is_megamenu == true) {

					wp_nav_menu( array(
						'theme_location' => $menu,
						'container' => 'nav',
						'container_id' => 'tdp-main-navigation',
						'container_class' => 'main_menu',
						'menu_class' => 'main-navigation-ul',
						'fallback_cb' => '',
						'walker' => new tdp_megamenu_walker
					));

				} else {

				    wp_nav_menu( array(
						'theme_location' => $menu,
						'menu_class'      => $menu_class,
					)); 

				}
			} else {

				echo '<p class="no-menu">'.__('Please select the menu location from "Appearance -> Menu"','framework').'</p>';

			}

	}
}
add_action('tdp_display_navigation','tdp_display_navigation', 10, 3 );

/**
 * Add Custom Style To Blog Inner Header
 */
if ( !function_exists('tdp_blog_styles') ) {

	function tdp_blog_styles() {

		$custom_blog = '';
		
		if(is_single() || is_page() || function_exists('is_woocommerce') && is_woocommerce() || is_404()) {
			$header_color = get_field('header_background_color');
			$header_image = get_field('header_background_image');
			$has_overlay = get_field('overlay_color');

			if($header_color !== '') {

				$custom_blog .= '#page-top {background-color:'.$header_color.'}';

			}

			if($header_image) {

				$custom_blog .= '#page-top {background-image:url('.$header_image.'); background-position: center center; background-attachment: scroll; background-size: 100%;}';

			}

			if($has_overlay) {
				$custom_blog .= '#page-overlay {background-color:'.$has_overlay.'}';
			}

		} else if(is_tax( ) || is_archive()) {

			$header_color = get_field('categories_header_background_color','option');
			$header_image = get_field('categories_header_background_image','option');
			$has_overlay = get_field('categories_header_overlay_color','option');

			if($header_color !== '') {

				$custom_blog .= '#page-top {background-color:'.$header_color.'}';

			}

			if($header_image) {

				$custom_blog .= '#page-top {background-image:url('.$header_image.'); background-position: center center; background-attachment: scroll; background-size: 100%;}';

			}

			if($has_overlay) {
				$custom_blog .= '#page-overlay {background-color:'.$has_overlay.'}';
			}

		} else {

			$header_color = get_field('header_custom_background_color','option');
			$header_image = get_field('header_custom_background_image','option');
			$has_overlay = get_field('header_custom_background_image_overlay','option');

			if($header_color !== '') {

				$custom_blog .= '#page-top {background-color:'.$header_color.'}';

			}

			if($header_image) {

				$custom_blog .= '#page-top {background-image:url('.$header_image.'); background-position: center center; background-attachment: scroll; background-size: 100%;}';

			}

			if($has_overlay) {
				$custom_blog .= '#page-overlay {background-color:'.$has_overlay.'}';
			}

		}


        wp_add_inline_style( 'main-style', $custom_blog );


        // Secondary Styles For Additional Elements
        $custom_carousel = null;
        if(is_singular( 'vehicles' ) && get_field("set_background_picture_for_carousel","option") ) {
        	$custom_carousel .= '.latest_offers {background-image:url('.get_field("set_background_picture_for_carousel","option").'); background-position: center center; background-attachment: scroll; background-size: 100%;}';
        	$custom_carousel .= '.latest_offers .overlay {background-color:'.get_field("set_background_image_overlay_color","option").'; margin-top: -35px; }';
        }

        wp_add_inline_style( 'main-style', $custom_carousel );

        $custom_homepage_form = null;
        if(is_page_template( 'templates/template-homepage.php' ) && !get_field('add_landing_image','option')) {
        	$custom_homepage_form .= '#landing-form-wrapper {background-color:'.get_field("form_area_background","option").';}';
        } else if(is_page_template( 'templates/template-homepage.php' ) && get_field('add_landing_image','option')) {
        	$custom_homepage_form .= '#landing-form-wrapper {background-image:url('.get_field("upload_landing_image","option").'); background-position: center center; background-attachment: scroll; background-size: 100%; -webkit-background-size: cover;
-moz-background-size: cover;
-o-background-size: cover;
background-size: cover;}';
        	$custom_homepage_form .= '#landing-form-wrapper {background-color:'.get_field("form_area_background","option").';}';
        }

        if(is_page_template( 'templates/template-homepage.php' ) && get_field('add_landing_image','option') && get_field('enable_overlay','option')) {
        	$custom_homepage_form .= '#form-overlay {background-color:'.get_field("overlay_color","option").';}';
        }


        wp_add_inline_style( 'main-style', $custom_homepage_form );

	}

	

}
add_action('wp_enqueue_scripts', 'tdp_blog_styles', 20);


/**
 * Display Post Title Badge
 */
if ( !function_exists('tdp_badge_icon') ) { 

	function tdp_badge_icon() {

		$icon_format = get_post_format();

		$output = '<span class="badge-format">';

		if($icon_format == 'aside' || $icon_format == '') {

			$output .= '<i class="icon-doc-inv"></i>';

		} else {
			$output .= '<i class="icon-ok2"></i>';
		}

		$output .= '</span>';

		echo $output;
		
	}

}
add_action('tdp_before_post_title', 'tdp_badge_icon');

/**
 * Display Share Box
 */

if( !function_exists('tdp_share_box')) {

	function tdp_share_box() { ?>

		<?php if(get_field('enable_social_sharing_buttons','option')) { ?>

			<div class="sharebox">
				<h4 class="barhead"><span><?php _e('Share this Story', 'framework'); ?></span></h4>
				<div class="social-icons">
					<ul>
						<li class="social-facebook">
							<a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>" title="<?php _e( 'Facebook', 'framework' ) ?>" target="_blank"><i class="icon-facebook"></i></a>
						</li>
						<li class="social-twitter">
							<a href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink(); ?>" title="<?php _e( 'Twitter', 'framework' ) ?>" target="_blank"><i class="icon-twitter"></i></a>
						</li>
						<li class="social-linkedin">
							<a href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink();?>&amp;title=<?php the_title();?>" title="<?php _e( 'LinkedIn', 'framework' ) ?>" target="_blank"><i class="icon-linkedin"></i></a>
						</li>
						<li class="social-googleplus">
							<a href="http://google.com/bookmarks/mark?op=edit&amp;bkmk=<?php the_permalink() ?>&amp;title=<?php echo urlencode(the_title('', '', false)) ?>" title="<?php _e( 'Google+', 'framework' ) ?>" target="_blank"><i class="icon-gplus"></i></a>
						</li>
						<li class="social-email">
							<a href="mailto:?subject=<?php the_title();?>&amp;body=<?php the_permalink() ?>" title="<?php _e( 'E-Mail', 'framework' ) ?>" target="_blank"><i class="icon-mail-alt"></i></a>
						</li>
					</ul>
				</div>
				<div class="clear"></div>
			</div>

		<?php } ?>

	<?php }
}
add_action('tdp_after_single_post','tdp_share_box');

/**
 * Display Author Box Information
 */

if( !function_exists('tdp_author_box')) {

	function tdp_author_box() { ?>

		<?php if(get_field('enable_author_box','option')) { ?>
		<div id="author-info" class="clearfix">
				    <div class="author-image one_sixth">
				    	<a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php echo get_avatar( get_the_author_meta('user_email'), '55', '' ); ?></a>
				    </div>   
				    <div class="author-bio five_sixth last">
				        <h4><?php _e('About the Author', 'framework'); ?></h4>
				        <?php the_author_meta('description'); ?>
				    </div>
				    <div class="clear"></div>
			</div>
		<?php } ?>

	<?php }

}
add_action('tdp_after_single_post','tdp_author_box');

/**
 * Change Products Per Page In WooCommerce
 */
// Disable WooCommerce CSS
define('WOOCOMMERCE_USE_CSS', false);
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );


// Register your custom function to override some LayerSlider data
add_action('layerslider_ready', 'my_layerslider_overrides');
function my_layerslider_overrides() {
	// Disable auto-updates
	$GLOBALS['lsAutoUpdateBox'] = false;
}


/**
 * Handles Custom Skin Creation
 */
function tdp_custom_skin() {

	$user_style = null;

	if(get_field('enable_custom_skin','option')) {

		//General Settings

		//primary color 
		$user_style .= '
		a,
		.primary-color,
		.user-menu-link:hover i,
		.user-menu-link:hover span,
		.post-title a:hover,
		.finder-vehicle .price,
		.finder-vehicle .vehicle-mileage,
		.vehicle-features li i,
		.to-inner-action a:hover,
		.single-desc h3 a,
		.vehicle-price,
		.vehicle-position,
		.vehicle-details span,
		ul.grid-details 
		{color:'.get_field('primary_color','option').';}';

		//primary bg
		$user_style .= '
		.primary-bg,
		.white-popup h3.popup-title,
		.post-link,
		#to-top:hover,
		#to-top.dark:hover,
		.new-badge,
		.irs-diapason,
		.form-intro-title,
		.to-inner-action a,
		.sf-menu li ul li a:hover, .sf-menu li ul li.sfHover > a,
		#page-top,
		.badge-format,
		.user-module li ul li a:hover,
		div.fancy-select ul.options li.selected,
		.share-menu li ul li a:hover,
		.irs-diapason, .irs-from, .irs-to, .irs-single,
		.active-step .step-number,
		.widget_tdp_dealer_profile .widget-title {background:'.get_field('primary_color','option').' !important;}';

		//primary border
		$user_style .= '
		.irs-from:after, .irs-to:after, .irs-single:after,
		#profile-socials li a,
		.to-inner-action a:hover {border-color:'.get_field('primary_color','option').'!important;}';

		//secondary bg color
		$user_style .= '
		.secondary-bg,
		.internal .big-button,
		.user-module .avatar,
		.sf-menu > li a:after, #navigation-wrapper .sfHover > a:after,.footer-border{background:'.get_field('secondary_color','option').' !important;}';

		//secondary color
		$user_style .= '
		#top-bar a i,
		li.current-menu-item a,
		footer a, footer a:hover,
		.internal .big-button:hover{color:'.get_field('secondary_color','option').' !important;}';

		//secondary border
		$user_style .= '
		footer .widget-title span,
		.internal .big-button:hover{border-color:'.get_field('secondary_color','option').' !important;}';

		//alternative color
		$user_style .= '.secondary-color, .meta-wrapper, .meta-wrapper a, .sidenav li ul li a, .widget_wp_nav_menu_desc li ul li a, .widget_search input, .widget_tag_cloud a,
		.commentlist li .date,
		.commentlist li .date a,
		#respond input[type=text], #respond textarea,
		.woocommerce-result-count,
		.woocommerce-pagination a,
		.woocommerce-pagination span,
		.products li .price del,
		.product .price del,
		.product_meta .posted_in,
		.product_meta .tagged_as,
		.product_meta .sku_wrapper,
		.woocommerce table.cart td.actions .coupon .input-text,.woocommerce-page table.cart td.actions .coupon .input-text,.woocommerce #content table.cart td.actions .coupon .input-text,.woocommerce-page #content table.cart td.actions .coupon .input-text,
		.cart_totals td,
		.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,.woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle{color:'.get_field('alternative_color','option').';}';

		//topbar

		$user_style .= '#top-bar {
			border-bottom: 1px solid '.get_field('top_bar_bottom_border_color','option').';
			background-color: '.get_field('top_bar_background','option').';
			color: '.get_field('top_bar_text_color','option').';
		}';

		$user_style .= '#top-bar a:hover, #top-bar .sfHover > a {
				color: '.get_field('top_bar_link_color','option').'!important;
		}';

		$user_style .= 'header {
			background: #333;
			background: -webkit-gradient(linear, 0% 0%, 0% 100%, from('.get_field('header_background_gradient_end_color','option').'), to('.get_field('header_background_gradient_start_color','option').'));
			background: -webkit-linear-gradient(top, '.get_field('header_background_gradient_end_color','option').', '.get_field('header_background_gradient_start_color','option').');
			background: -moz-linear-gradient(top, '.get_field('header_background_gradient_end_color','option').', '.get_field('header_background_gradient_start_color','option').');
			background: -ms-linear-gradient(top, '.get_field('header_background_gradient_end_color','option').', '.get_field('header_background_gradient_start_color','option').');
			background: -o-linear-gradient(top, '.get_field('header_background_gradient_end_color','option').', '.get_field('header_background_gradient_start_color','option').');
		}';

		$user_style .= '.sf-menu > li a {
			color: '.get_field('navigation_menu_links_color','option').';
		}';

		$user_style .= '#navigation-wrapper div.menu-primary-menu-container > ul > li.megamenu > ul.sub-menu {
			background-color: '.get_field('submenu__background_color','option').';
		}';

		// page
		$user_style .= '#theme-wrapper {background-color: '.get_field('page_background_color','option').';}';
		$user_style .= 'h1, h2, h3, h4, h5, h6, .the-content h1, .the-content h2, .the-content h3, .the-content h4, .the-content h5, .the-content h6 {color: '.get_field('headings_color','option').';}';
		$user_style .= 'body {color:'.get_field('paragraphs_and_text_color','option').';}';

		$user_style .= '.post-title a {color: '.get_field('posts_title_color','option').';}';


		$user_style .= '.widget-title, h3#comments, h3.title {
		color:'.get_field('widget_titles_color','option').';
		border-bottom: 1px solid '.get_field('widget_title_border_color','option').';
		}';

		$user_style .= 'widget-title span, h3#comments > span, h3.title span {
			border-bottom: 1px solid '.get_field('widget_title_border_highlight_color','option').';
		}';

		$user_style .= '#sidebar {color:'.get_field('sidebar_text_color','option').';}';

		// vehicles

		$user_style .= '.featured-heading, .featured-more {
			background: '.get_field('featured_vehicles_top_highlight_background_color','option').';
			border-bottom: 1px solid '.get_field('featured_vehicles_top_highlight_border','option').';
		}';

		$user_style .= '#vehicle-infobar {
			background: '.get_field('vehicles_top_bar_background','option').';
			border-color:'.get_field('vehicles_top_bar_border','option').';
		}';

		$user_style .= '.latest_offers {
			background: '.get_field('vehicles_carousel_background','option').';
			border-top-color:'.get_field('vehicles_carousel_top_border','option').';
			border-bottom-color:'.get_field('vehicles_carousel_border_bottom','option').';
		}';

		$user_style .= '.signup-message a {
			color: '.get_field('vehicles_carousel_sign_up_link_color','option').';
		}';

		$user_style .= '.signup-message a {
			color: '.get_field('vehicles_carousel_sign_up_link_color','option').';
		}';

		$user_style .= '.latest_item a {
			color: '.get_field('vehicles_carousel_link_color','option').';
		}';

		$user_style .= '.item-date {
			color: '.get_field('vehicles_carousel_date_color','option').';
		}';

		$user_style .= '.item-views a {
			color: '.get_field('vehicles_carousel_read_more_color','option').';
		}';

		//footer 

		$user_style .= 'pre-footer, .use-color-no {
			background: '.get_field('pre_footer_background','option').';
			border-top: solid 1px '.get_field('pre_footer_top_border','option').';
			color:'.get_field('pre_footer_text_color','option').';
		}';

		$user_style .= '#pre-footer a, .use-color-no a {
			color: '.get_field('pre_footer_links_color','option').';
		}';

		$user_style .= '#pre-footer .widget-title {
		color: '.get_field('pre_footer_widget_titles','option').';
		}';

		$user_style .= 'footer {
		background: '.get_field('main_footer_background_color','option').';
		color: 
		}';

		$user_style .= '.internal h3 {
		color: '.get_field('main_footer_info_area_headings','option').';
		}';

		$user_style .= '.internal .number {
			color: '.get_field('main_footer_info_area_stats_color','option').';
		}';

		$user_style .= '.internal .big-button {
		color: '.get_field('main_footer_info_area_button_text_color','option').';
		}';


		$user_style .= 'footer .widget-title {color: '.get_field('main_footer_widget_titles','option').';}';

		$user_style .= '.stats-column:before {
			background: '.get_field('main_footer_stats_column_background','option').';
			border-left: 1px solid '.get_field('main_footer_stats_column_border','option').';
		}';

	}

	wp_add_inline_style( 'main-style', $user_style );
}
add_action('wp_enqueue_scripts', 'tdp_custom_skin', 20);