<?php

/* 
 * Remove stuff
 */

add_action('init', 'remheadlink');
    function remheadlink() {
        remove_action('wp_head', 'index_rel_link');
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
}

if ( function_exists('register_nav_menus') ) { 
        register_nav_menus(
            array(
                'primary_menu' => __('Primary Menu', 'framework'), 
                'responsive-menu' => __('Responsive Menu', 'framework')
            )
        );
}



/* 
 * Register scripts and styles 
 */
function tdp_template_scripts() {
        
        //CSS Header
        wp_enqueue_style('main-style', get_stylesheet_uri());
        wp_enqueue_style('tdp-fontello', get_template_directory_uri() . '/css/fontello.css' );
        wp_enqueue_style('tdp-animate', get_template_directory_uri() . '/css/animate.css' );
        wp_enqueue_style('tdp-flexslider', get_template_directory_uri() . '/css/flexslider.css' );
        wp_enqueue_style('tdp-popup', get_template_directory_uri() . '/css/magnific-popup.css' );
        wp_enqueue_style('tdp-shortcodes', get_template_directory_uri() . '/css/elements.css' );
        wp_enqueue_style('tdp-formsoverride', get_template_directory_uri().'/css/square/blue.css');
        wp_enqueue_style('tdp-responsive', get_template_directory_uri().'/css/responsive.css');

        if(get_field('enable_rtl','option')) {
            wp_enqueue_style('tdp-rtl', get_template_directory_uri().'/css/rtl.css');
        }
        
        //JS Header
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }   
        wp_enqueue_script( 'jquery' );
        
        if(!wp_is_mobile()):
            wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr-2.6.2.min.js');
        endif;

        wp_enqueue_script( 'google-src', 'http://maps.google.com/maps/api/js?sensor=true' );

       
        //JS FOOTER
        wp_enqueue_script( 'jquery-ui-tabs', false, false, true);
        wp_enqueue_script( 'carousel', get_template_directory_uri() . '/js/carousel.js', false, false, true);
        wp_enqueue_script( 'jcycle2', get_template_directory_uri() . '/js/jquery.cycle2.min.js', false, false, true);
        wp_enqueue_script( 'tdp_jplayer', get_template_directory_uri() . '/js/jplayer/jquery.jplayer.min.js', false, false, true);

        wp_enqueue_script( 'tdp-scripts', get_template_directory_uri() . '/js/scripts.js', false, false, true );
        
        wp_enqueue_script( 'tdp-shortcodes', get_template_directory_uri() . '/js/shortcodes.js', false, false, true);

        wp_enqueue_script( 'gmap3', get_template_directory_uri() . '/js/gmap3.min.js', $deps = array(), $ver = false, $in_footer = false );
        wp_enqueue_script( 'scrollbar', get_template_directory_uri() . '/js/jquery.mCustomScrollbar.min.js', $deps = array(), $ver = false, $in_footer = true );
        wp_enqueue_script( 'validate', get_template_directory_uri() . '/js/jquery.validate.min.js', $deps = array(), $ver = false, $in_footer = true );
        wp_enqueue_script( 'tdp-custom', get_template_directory_uri() . '/js/custom.js', $deps = array(), $ver = false, $in_footer = true );
    
}
add_action('wp_enqueue_scripts', 'tdp_template_scripts');

/**
 * Register Google Font
 * @todo Better function replacement
 */
function dp_google_font() { 
    
    //main font    
    wp_enqueue_style('tdp-main-font', ( is_ssl() ? 'https' : 'http' ) .'://'.get_field('google_font_url','option') );
    //Headings font
    wp_enqueue_style('tdp-headings-font', ( is_ssl() ? 'https' : 'http' ) .'://'.get_field('google_font_url_headings','option') );

    $font_data = "body, #olsubmit, .widget_tdp_vehicle_search select,".'input[type="text"], input[type="password"], input[type="date"], input[type="datetime"], input[type="email"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"]'." {font-family: '".get_field('google_font_name', 'option')."', Helvetica Neue, Helvetica, Arial, sans-serif !important;}";
    $font_data .= "h1, h2, h3, h4, h5, h6, #breadcrumb-wrapper, #user-menu-title a, .counter-circle-content, .content-box-percentage, .internal .number, div.tdp-field-name {font-family: '".get_field('google_font_name_headings', 'option')."', Helvetica Neue, Helvetica, Arial, sans-serif !important;}";
    wp_add_inline_style( 'main-style', $font_data );


}   
add_action('wp_enqueue_scripts', 'dp_google_font');

/**
 * Register Custom Sidebars
 */
if (function_exists('register_sidebar')){   
    
    // default sidebar array
    $sidebar_attr = array(
        'name' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title"><span>',
        'after_title' => '</span></h3>'
    );

    $sidebar_id = 0;
    $dp_sidebar = array(
        "Blog Sidebar" => 'Place widgets in this area to display widgets inside the blog sidebar.', 
        "Page Sidebar" => 'Place widgets in this area to display widgets into each single page sidebar.', 
        "Single Post Sidebar" => 'This widgets area is reserved for the each single post page', 
        "Vehicles Sidebar" => 'Use this area to display widgets into vechiles taxonomies pages such as type/fuel type/interiors/exteriors/etc...', 
        "Single Vehicles Sidebar" => 'Use this area to display widgets into the single vehicle page area.', 
        "Footer 1" => 'Use this area to display widgets inside the main dark footer at the bottom of the website', 
        "Footer 2" => 'Use this area to display widgets inside the main dark footer at the bottom of the website', 
        "Footer 3" => 'Use this area to display widgets inside the main dark footer at the bottom of the website', 
        "Footer 4" => 'Use this area to display widgets inside the main dark footer at the bottom of the website', 
        "Secondary Footer 1" => 'Use this area to display widgets inside the secondary footer area above the primary footer', 
        "Secondary Footer 2" => 'Use this area to display widgets inside the secondary footer area above the primary footer', 
        "Secondary Footer 3" => 'Use this area to display widgets inside the secondary footer area above the primary footer', 
        "Secondary Footer 4" => 'Use this area to display widgets inside the secondary footer area above the primary footer'
    );

    //check if secondary footer is enabled
    // if not, remove footer sidebars not needed
    if(!get_field('enable_additional_footer','option')) {
        $key = array_search("Secondary Footer 1", $dp_sidebar);
        $key2 = array_search("Secondary Footer 2", $dp_sidebar);
        $key3 = array_search("Secondary Footer 3", $dp_sidebar);
        $key4 = array_search("Secondary Footer 4", $dp_sidebar);
        unset($dp_sidebar[$key]);
        unset($dp_sidebar[$key2]);
        unset($dp_sidebar[$key3]);
        unset($dp_sidebar[$key4]);
    }

    //print_r($dp_sidebar);

    foreach( $dp_sidebar as $sidebar_name => $value ){

        $sidebar_attr['name'] = $sidebar_name;
        $sidebar_attr['description'] = $value;
        $sidebar_attr['id'] = 'custom-sidebar' . $sidebar_id++ ;
        register_sidebar($sidebar_attr);
    }

}

/**
 * This function is needed to hide the user profile popup form since themeforest forces the js to be in the footer the popup sometimes is visible on page load
 */
function tdp_inline_js() { ?>
    
    <?php if(!is_admin()) { ?>

        <script type="text/javascript">

            jQuery("#user-menu").hide();

            <?php if(get_field('enable_rtl','option')) : ?>

            var theme_is_rtl = 'yes';

            <?php else: ?>

            var theme_is_rtl = 'no';

            <?php endif; ?>

            var tdp_submission_error_message = '<?php _e("This field is required.","framework");?>';

            var tdp_submission_form_complete_validation = '<?php _e("You have missed some fields. Please check that every required field has been filled.","framework");?>';

        </script>
        
        <!--[if gt IE 6]>
        <link rel='stylesheet' id='ie-css'  href='<?php echo get_template_directory_uri();?>/css/ie.css' type='text/css' media='all' />
        <![endif]-->

    <?php } ?>

<?php }   
add_action('wp_head', 'tdp_inline_js');