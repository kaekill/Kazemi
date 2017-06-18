<?php
/**
 * Setup Theme Options Pages
 */
if(function_exists("register_options_page"))
{
    register_options_page('Theme Options');
    register_options_page('Vehicles Options');
    register_options_page('Search Setup');
    register_options_page('Vehicles Submission');
    register_options_page('User Dashboard');
    register_options_page('Skin Customization');
}

/**
 * Rename Default ACF Page to Theme Options
 */
if( function_exists('acf_set_options_page_title') )
{
    acf_set_options_page_title( __('Theme Options','framework') );
}

/**
 * Add css to dashboard
 */
function tdp_dashboard_css() {
    wp_register_style( 'tdp_dashboard_css', get_template_directory_uri() . '/css/admin-css.css', false, '1.0.0' );
    wp_register_style( 'tdp_dashboard_css2', get_template_directory_uri() . '/css/fontello.css', false, '1.0.0' );
    wp_enqueue_style( 'tdp_dashboard_css' );
    wp_enqueue_style( 'tdp_dashboard_css2' );
}
add_action( 'admin_enqueue_scripts', 'tdp_dashboard_css' );

/**
 * Remove admin bar for non admin
 */
function tdp_remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
      show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'tdp_remove_admin_bar');

/**
 * Modify Taxonomy Query
 */
function wpse_order_by() {
    global $wpdb;
    return $wpdb->prepare( "$wpdb->postmeta.meta_value+0 DESC, post_date DESC", $id );
}

add_action('pre_get_posts', 'add_custom_taxonomy_query');
function add_custom_taxonomy_query(&$query)
{   


    $vehicles_per_page = get_field('vehicles_per_page','option');

    if (!is_admin() && $query->is_main_query() && is_archive()) {
        $query->set('post_status', 'publish');
    }

    if (!is_admin() && $query->is_main_query() && is_tax() || !is_admin() && $query->is_main_query() && is_archive()) {

        /**
         * Display vehicles by highest price first
         */
        if(isset($_GET['vehicle_order']) && $_GET['vehicle_order'] == 'price_high'){

            $query->set('orderby', 'meta_value_num');
            $query->set('order','desc');
            $query->set('meta_key', 'price');

        /**
         * Display vehicles by lowest price first
         */
        } else if(isset($_GET['vehicle_order']) && $_GET['vehicle_order'] == 'price_low'){

            $query->set('orderby', 'meta_value_num');
            $query->set('order','asc');
            $query->set('meta_key', 'price');


        /**
         * Display vehicles by name a-z
         */
        } else if(isset($_GET['vehicle_order']) && $_GET['vehicle_order'] == 'names_az'){

            $query->set('orderby','title');
            $query->set('order','asc');

        /**
         * Display vehicles by name z-a
         */

        } else if(isset($_GET['vehicle_order']) && $_GET['vehicle_order'] == 'names_za'){

            $query->set('orderby','title');
            $query->set('order','desc');

        /**
         * Display featured vehicles at the top by default
         */
        } else {

            $query->set('post_status', 'publish');

        }

        $query->set('post_status', 'publish');

        $query->set('posts_per_page', $vehicles_per_page );
    }
    return $query;
}

/**
 * Helper Function to define new user role
 */
add_role('tdp_dealer', 'Vehicle Dealer', array(
    'read' => true, // True allows that capability
    'edit_dealer_fields' => true
));
// Add capability to admins
function tdp_add_theme_caps() {
    // gets the author role
    $role = get_role( 'administrator' );

    // This only works, because it accesses the class instance.
    // would allow the author to edit others' posts for current theme only
    $role->add_cap( 'edit_dealer_fields', true ); 
}
add_action( 'admin_init', 'tdp_add_theme_caps');

/**
 * Add browser classes to body tag filter based on current vehicle author role
 * needed to display/disable the dealer profile widget
 */
function tdp_user_browser_body_class($classes) {

    global $post;

    if(is_singular( 'vehicles' )) {

        $user_info = get_userdata($post->post_author);

        $current_user_role = implode(', ', $user_info->roles);

        $classes[] = 'is-'.$current_user_role;

    }

    return $classes;
}
add_filter('body_class','tdp_user_browser_body_class');

/**
 * Helper Function to add additional fields for the vehicle dealer user role
 */

add_action ( 'show_user_profile', 'tdp_dealer_fields' );
add_action ( 'edit_user_profile', 'tdp_dealer_fields' );

function tdp_dealer_fields ( $user )
{
?>  
    <table class="form-table">
    <tr>
            <th><label for="business_phone_number"><?php _e('Contact Phone Number','framework');?></label></th>
            <td>
                <input type="text" name="business_phone_number" id="business_phone_number" value="<?php echo esc_attr( get_the_author_meta( 'business_phone_number', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e('Enter your phone number here. This will be displayed on the sidebar of your listings.','framework');?></span>
            </td>
        </tr>
        </table>

    <?php if(current_user_can( 'edit_dealer_fields', $user->ID )) { ?>
    <div class="tdp-field tdp-seperator tdp-edit tdp-edit-show"><?php _e('Dealer Settings','framework');?></div>

    <table class="form-table">
        <tr>
            <th><label for="twitter"><?php _e('Twitter Profile Url','framework');?></label></th>
            <td>
                <input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e('Enter your twitter profile url','framework');?></span>
            </td>
        </tr>
        <tr>
            <th><label for="facebook"><?php _e('Facebook Profile Url','framework');?></label></th>
            <td>
                <input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e('Enter your facebook profile url','framework');?></span>
            </td>
        </tr>
        <tr>
            <th><label for="linkedin"><?php _e('LinkedIn Profile Url','framework');?></label></th>
            <td>
                <input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr( get_the_author_meta( 'linkedin', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e('Enter your linkedin profile url','framework');?></span>
            </td>
        </tr>
        <tr>
            <th><label for="business_website"><?php _e('Business Website','framework');?></label></th>
            <td>
                <input type="text" name="business_website" id="business_website" value="<?php echo esc_attr( get_the_author_meta( 'business_website', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e('Enter the website of your business if you have one.','framework');?></span>
            </td>
        </tr>
        <tr>
            <th><label for="business_location"><?php _e('Business Location','framework');?></label></th>
            <td>
                <input type="text" name="business_location" id="business_location" value="<?php echo esc_attr( get_the_author_meta( 'business_location', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e('Enter the location where your business is. This will be displayed into the sidebar of your listings.','framework');?></span>
            </td>
        </tr>
        <tr>
            <th><label for="business_description"><?php _e('Business Description','framework');?></label></th>
            <td>
                <textarea name="business_description" id="business_description"class="regular-text" /><?php echo esc_attr( get_the_author_meta( 'business_description', $user->ID ) ); ?></textarea><br />
                <span class="description"><?php _e('Enter a description for your business.','framework');?></span>
            </td>
        </tr>
    </table>
    <?php } ?>
<?php
}

add_action ( 'personal_options_update', 'tdp_dealer_save_fields' );
add_action ( 'edit_user_profile_update', 'tdp_dealer_save_fields' );

function tdp_dealer_save_fields( $user_id )
{
    /* Copy and paste this line for additional fields. Make sure to change 'business_phone_number' to the field ID. */
    update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
    update_user_meta( $user_id, 'facebook', $_POST['facebook'] );
    update_user_meta( $user_id, 'linkedin', $_POST['linkedin'] );
    update_user_meta( $user_id, 'business_phone_number', $_POST['business_phone_number'] );
    update_user_meta( $user_id, 'business_website', $_POST['business_website'] );
    update_user_meta( $user_id, 'business_location', $_POST['business_location'] );
    update_user_meta( $user_id, 'business_description', $_POST['business_description'] );
}

/**
 * Helper Function to display new badge if post is new
 */
function tdp_display_new_badge(){

    $days = get_field('days_post_is_marked_as_new','option');

    if ( (time()-get_the_time('U')) <= ($days*86400) ) { // The number 3 is how many days to keep posts marked as new
        echo '<span class="new-badge">'.__('New','framework').'</span>';
    }

}

/**
 * Helper Function to display loading icon for search form/submit form
 */
function tdp_theme_images_var() { ?>
    
    <script type="text/javascript">
        /* 
        * Ajax Request to get vehicles
        */
        var theme_images = "<?php echo get_template_directory_uri();?>";
    </script>

<?php }
add_action('wp_footer','tdp_theme_images_var');

/**
 * Helper Function to display total amount of user posts
 */
function tdp_count_user_posts_by_type( $userid, $post_type = 'post' ) {
    global $wpdb;

    $where = get_posts_by_author_sql( $post_type, true, $userid );

    $count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts $where" );

    return apply_filters( 'get_usernumposts', $count, $userid );
}

/**
 * Helper Function to display dealer name in page title
 * when on dealer profile page
 */

function tdp_dealer_profile_title( $title, $sep ) {
    global $paged, $page;

    $get_profile_page_id = url_to_postid( get_field('dealer_profile_page','option') );

    if(is_page( $get_profile_page_id )) {

        if(isset($_GET['dealer_profile'])) {

            $user_id = sanitize_title($_GET['dealer_profile']);
            $user_info = get_userdata($user_id);
            
            echo $user_info->display_name . ' ';

        }

    }

    return $title;
}
add_filter( 'wp_title', 'tdp_dealer_profile_title', 10, 2 );

/**
 * Helper Function to display audio/video player
 */
function get_audio_player($src, $color='#00b4cc', $extra_class = '', $uniqid){
    
    return  "<div class='tdp_element tdp_elem_audio $extra_class'>
                <div id='jquery_jplayer_$uniqid' pid='$uniqid' src='$src' class='jp-jplayer tdp-jplayer-audio'></div>
                <div class='jp-audio-container'>
                    <div class='jp-audio'>
                        <div class='jp-type-single'>
                            <div id='jp_interface_$uniqid' class='jp-interface'>
                                <ul class='jp-controls-play'>
                                    <li><a href='#' class='jp-play' tabindex='1' style='display: block; color:$color; '><i class='icon-play'></i></a></li>
                                    <li><a href='#' class='jp-pause' tabindex='1' style='display: none; color:$color;'><i class='icon-pause'></i></a></li>
                                </ul>
                                <div class='jp-progress-container'>
                                    <div class='jp-progress'>
                                        <div class='jp-seek-bar' style='width: 100%; '>
                                            <div class='jp-play-bar' style='width: 1.18944845234691%; background-color:$color;'></div>
                                        </div>
                                    </div>
                                </div>
                                <div class='jp-time-holder' style='color:$color;'>
                                    <div class='jp-current-time'></div>
                                    <div class='jp-duration'></div>
                                </div>
                                <ul class='jp-controls-sound'>  
                                    <li><a href='#' class='jp-mute' tabindex='1' style='color:$color;'><i class='icon-volume-up'></i></a></li>
                                    <li><a href='#' class='jp-unmute' tabindex='1' style='display: none; color:$color;'><i class='icon-volume-off'></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
}



function get_video_player($url, $color='#3a87ad', $extra_class = '', $poster = null){
    $path_info = pathinfo($url);
    $ext = $path_info['extension'];
    //$ext = substr($url, -3, 3);
    $uniqid = uniqid();
    return "<div class='tdp_element tdp_elem_video $extra_class'>
                <div id='jquery_jplayer_$uniqid' pid='$uniqid' ext='$ext' src='$url' poster='$poster' class='jp-jplayer tdp-jplayer-video'></div>
                <div class='jp-video-container'>
                        <div class='jp-audio'>
                            <div class='jp-type-single'>
                                <div id='jp_interface_$uniqid' class='jp-interface'>
                                    <ul class='jp-controls-play'>
                                        <li><a href='#' class='jp-play' tabindex='1' style='display: block; color:$color; '><i class='icon-play'></i></a></li>
                                        <li><a href='#' class='jp-pause' tabindex='1' style='display: none; color:$color;'><i class='icon-pause'></i></a></li>
                                    </ul>
                                    <div class='jp-progress-container'>
                                        <div class='jp-progress'>
                                            <div class='jp-seek-bar' style='width: 100%; '>
                                                <div class='jp-play-bar' style='width: 1.18944845234691%; background-color:$color;'></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='jp-time-holder' style='color:$color;'>
                                        <div class='jp-current-time'></div>
                                        <div class='jp-duration'></div>
                                    </div>
                                    <ul class='jp-controls-sound'>  
                                        <li><a href='#' class='jp-mute' tabindex='1' style='color:$color;'><i class='icon-volume-up'></i></a></li>
                                        <li><a href='#' class='jp-unmute' tabindex='1' style='display: none; color:$color;'><i class='icon-volume-off'></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>";
}


/**
 * Title         : Aqua Resizer
 * Description   : Resizes WordPress images on the fly
 * Version       : 1.1.7
 * Author        : Syamil MJ
 * Author URI    : http://aquagraphite.com
 * License       : WTFPL - http://sam.zoy.org/wtfpl/
 * Documentation : https://github.com/sy4mil/Aqua-Resizer/
 *
 * @param string  $url    - (required) must be uploaded using wp media uploader
 * @param int     $width  - (required)
 * @param int     $height - (optional)
 * @param bool    $crop   - (optional) default to soft crop
 * @param bool    $single - (optional) returns an array if false
 * @uses  wp_upload_dir()
 * @uses  image_resize_dimensions() | image_resize()
 * @uses  wp_get_image_editor()
 *
 * @return str|array
 */

function tdp_aq_resize( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = false ) {

    // Validate inputs.
    if ( ! $url || ( ! $width && ! $height ) ) return $url;

    // Caipt'n, ready to hook.
    if ( true === $upscale ) add_filter( 'image_resize_dimensions', 'tdp_aq_upscale', 10, 6 );

    // Define upload path & dir.
    $upload_info = wp_upload_dir();
    $upload_dir = $upload_info['basedir'];
    $upload_url = $upload_info['baseurl'];

    $http_prefix = "http://";
    $https_prefix = "https://";

    /* if the $url scheme differs from $upload_url scheme, make them match 
       if the schemes differe, images don't show up. */
    if(!strncmp($url,$https_prefix,strlen($https_prefix))){ //if url begins with https:// make $upload_url begin with https:// as well
        $upload_url = str_replace($http_prefix,$https_prefix,$upload_url);
    }
    elseif(!strncmp($url,$http_prefix,strlen($http_prefix))){ //if url begins with http:// make $upload_url begin with http:// as well
        $upload_url = str_replace($https_prefix,$http_prefix,$upload_url);      
    }


    // Check if $img_url is local.
    if ( false === strpos( $url, $upload_url ) ) return $url;

    // Define path of image.
    $rel_path = str_replace( $upload_url, '', $url );
    $img_path = $upload_dir . $rel_path;

    // Check if img path exists, and is an image indeed.
    if ( ! file_exists( $img_path ) or ! getimagesize( $img_path ) ) return $url;

    // Get image info.
    $info = pathinfo( $img_path );
    $ext = $info['extension'];
    list( $orig_w, $orig_h ) = getimagesize( $img_path );

    // Get image size after cropping.
    $dims = image_resize_dimensions( $orig_w, $orig_h, $width, $height, $crop );
    $dst_w = $dims[4];
    $dst_h = $dims[5];

    // Return the original image only if it exactly fits the needed measures.
    if ( ! $dims && ( ( ( null === $height && $orig_w == $width ) xor ( null === $width && $orig_h == $height ) ) xor ( $height == $orig_h && $width == $orig_w ) ) ) {
        $img_url = $url;
        $dst_w = $orig_w;
        $dst_h = $orig_h;
    } else {
        // Use this to check if cropped image already exists, so we can return that instead.
        $suffix = "{$dst_w}x{$dst_h}";
        $dst_rel_path = str_replace( '.' . $ext, '', $rel_path );
        $destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

        if ( ! $dims || ( true == $crop && false == $upscale && ( $dst_w < $width || $dst_h < $height ) ) ) {
            // Can't resize, so return false saying that the action to do could not be processed as planned.
            return $url;
        }
        // Else check if cache exists.
        elseif ( file_exists( $destfilename ) && getimagesize( $destfilename ) ) {
            $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
        }
        // Else, we resize the image and return the new resized image url.
        else {

            // Note: This pre-3.5 fallback check will edited out in subsequent version.
            if ( function_exists( 'wp_get_image_editor' ) ) {

                $editor = wp_get_image_editor( $img_path );

                if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $width, $height, $crop ) ) )
                    return $url;

                $resized_file = $editor->save();

                if ( ! is_wp_error( $resized_file ) ) {
                    $resized_rel_path = str_replace( $upload_dir, '', $resized_file['path'] );
                    $img_url = $upload_url . $resized_rel_path;
                } else {
                    return $url;
                }

            } else {

                $resized_img_path = image_resize( $img_path, $width, $height, $crop ); // Fallback foo.
                if ( ! is_wp_error( $resized_img_path ) ) {
                    $resized_rel_path = str_replace( $upload_dir, '', $resized_img_path );
                    $img_url = $upload_url . $resized_rel_path;
                } else {
                    return $url;
                }

            }

        }
    }

    // Okay, leave the ship.
    if ( true === $upscale ) remove_filter( 'image_resize_dimensions', 'tdp_aq_upscale' );

    // Return the output.
    if ( $single ) {
        // str return.
        $image = $img_url;
    } else {
        // array return.
        $image = array (
            0 => $img_url,
            1 => $dst_w,
            2 => $dst_h
        );
    }

    return $image;
}

function tdp_aq_upscale( $default, $orig_w, $orig_h, $dest_w, $dest_h, $crop ) {
    if ( ! $crop ) return null; // Let the wordpress default function handle this.

    // Here is the point we allow to use larger image size than the original one.
    $aspect_ratio = $orig_w / $orig_h;
    $new_w = $dest_w;
    $new_h = $dest_h;

    if ( ! $new_w ) {
        $new_w = intval( $new_h * $aspect_ratio );
    }

    if ( ! $new_h ) {
        $new_h = intval( $new_w / $aspect_ratio );
    }

    $size_ratio = max( $new_w / $orig_w, $new_h / $orig_h );

    $crop_w = round( $new_w / $size_ratio );
    $crop_h = round( $new_h / $size_ratio );

    $s_x = floor( ( $orig_w - $crop_w ) / 2 );
    $s_y = floor( ( $orig_h - $crop_h ) / 2 );

    return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
}

/**
 * Remove woocommerce packages from shop page
 */

add_action( 'pre_get_posts', 'tdp_woocommerce_custom_pre_get_posts_query' );
 
function tdp_woocommerce_custom_pre_get_posts_query( $q ) {
 
    if ( ! $q->is_main_query() ) return;
    if ( ! $q->is_post_type_archive() ) return;
    
    if ( ! is_admin() && in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_shop() ) {
 
        $q->set( 'tax_query', array(array(
            'taxonomy' => 'product_type',
            'field' => 'slug',
            'terms' => array( 'auto_package' ), // Don't display products in the category on the shop page
            'operator' => 'NOT IN'
        )));
    
    }
 
    remove_action( 'pre_get_posts', 'tdp_woocommerce_custom_pre_get_posts_query' );
 
}

/**
 * Handles Email Notification when a vehicle is submitted.
 */
function tdp_send_vehicle_submission_email($the_auto_id) {
    
    //verify if option is enabled first
    if(get_field('vehicle_submission_email_admin','option')) {

        $listing_title = get_the_title($the_auto_id);

        $post = get_post( $the_auto_id );
        $listing_author = $post->post_author;
        $adminurl = admin_url( 'post.php?post='.$the_auto_id.'&action=edit', 'https' );

        //prepare email settings
        $mailto = get_option('admin_email');
        $subject = __('New Vehicle Submission','framework');
        $headers = 'From: '. __('AutoDealer Admin', 'framework') .' <'. get_option('admin_email') .'>' . "\r\n";
            
        // The blogname option is escaped with esc_html on the way into the database in sanitize_option
        // we want to reverse this for the plain text arena of emails.
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        $message  = __('Dear Admin,', 'framework') . "\r\n\r\n";
        $message .= sprintf(__('The following listing has just been submitted on your %s website.', 'framework'), $blogname) . "\r\n\r\n";
        $message .= __('Listing Details', 'framework') . "\r\n";
        $message .= __('-----------------', 'framework') . "\r\n";
        $message .= __('Title: ', 'framework') . $listing_title . "\r\n";
        $message .= __('Author: ', 'framework') . $listing_author . "\r\n\r\n";
        $message .= __('-----------------', 'framework') . "\r\n\r\n";
        $message .= sprintf(__('Review Listing: %s', 'framework'), $adminurl) . "\r\n\r\n\r\n";
        // ok let's send the email
        wp_mail($mailto, $subject, $message, $headers);

    }

}
add_action( 'auto_manager_after_submission', 'tdp_send_vehicle_submission_email', 10, 1 );

/**
 * Handles Email Notification for user after vehicle is submitted.
 */
function tdp_send_vehicle_submission_email_to_author($the_auto_id) {

    //verify if option is enabled first
    if(get_field('notification_to_user','option')) {
        $the_listing = get_post($the_auto_id);
        $listing_title = stripslashes($the_listing->post_title);
        $listing_status = stripslashes($the_listing->post_status);
        $listing_author = stripslashes(get_the_author_meta('user_login', $the_listing->post_author));
        $listing_author_email = stripslashes(get_the_author_meta('user_email', $the_listing->post_author));
        $dashurl = get_field('dashboard_page','option');
        $siteurl = trailingslashit(home_url( ));
            
        // The blogname option is escaped with esc_html on the way into the database in sanitize_option
        // we want to reverse this for the plain text arena of emails.
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        $mailto = $listing_author_email;

        $subject = sprintf(__('Your Listing Submission on %s','framework'), $blogname);
        $headers = 'From: '. sprintf(__('%s Admin', 'framework'), $blogname) .' <'. get_option('admin_email') .'>' . "\r\n";
        $message  = sprintf(__('Hi %s,', 'framework'), $listing_author) . "\r\n\r\n";
        $message .= sprintf(__('Thank you for your recent submission! Your ad listing has been submitted for review and will not appear live on our site until it has been approved. Below you will find a summary of your ad listing on the %s website.', 'framework'), $blogname) . "\r\n\r\n";
        $message .= __('Listing Details', 'framework') . "\r\n";
        $message .= __('-----------------', 'framework') . "\r\n";
        $message .= __('Title: ', 'framework') . $listing_title . "\r\n";
        $message .= __('Status: ', 'framework') . $listing_status . "\r\n";
        $message .= __('-----------------', 'framework') . "\r\n\r\n";
        $message .= __('You may check the status of your listing(s) at anytime by logging into your dashboard.', 'framework') . "\r\n";
        $message .= $dashurl . "\r\n\r\n\r\n\r\n";
        $message .= __('Regards,', 'framework') . "\r\n\r\n";
        $message .= sprintf(__('Your %s Team', 'framework'), $blogname) . "\r\n";
        $message .= $siteurl . "\r\n\r\n\r\n\r\n";
        // ok let's send the email
        wp_mail($mailto, $subject, $message, $headers);
    }

}
add_action( 'auto_manager_after_submission', 'tdp_send_vehicle_submission_email_to_author', 10, 1 );


/*-----------------------------------------------------------------------------------*/
/* Notify users when a listing is approved. */
/*-----------------------------------------------------------------------------------*/
function tdp_authorNotification($post_id) {

    if(get_field('approval_email','option')) {

        $post = get_post($post_id);
        $author = get_userdata($post->post_author);
        $message = sprintf(__('Hi %s, your listing %s has just been published at %s. Well done!', 'framework'), $author->display_name, $post->post_title, get_permalink( $post_id ) ) . "\r\n";
        wp_mail($author->user_email, __('Your listing is online','framework'), $message);

    }
}
add_action('publish_vehicles', 'tdp_authorNotification');

/*-----------------------------------------------------------------------------------*/
/* Check User Role. */
/*-----------------------------------------------------------------------------------*/

function tdp_check_user_role( $role, $user_id = null ) {
 
    if ( is_numeric( $user_id ) )
    $user = get_userdata( $user_id );
    else
        $user = wp_get_current_user();
 
    if ( empty( $user ) )
    return false;
 
    return in_array( $role, (array) $user->roles );
}


function tdp_formatcurrency($floatcurr, $curr = 'USD')
{
 
/**
 * A list of the ISO 4217 currency codes with symbol,format and symbol order
 * 
 * Symbols from 
 * http://character-code.com/currency-html-codes.php
 * http://www.phpclasses.org/browse/file/2054.html
 * https://github.com/yiisoft/yii/blob/633e54866d54bf780691baaaa4a1f847e8a07e23/framework/i18n/data/en_us.php
 * 
 * Formats from 
 * http://www.joelpeterson.com/blog/2011/03/formatting-over-100-currencies-in-php/
 * 
 * Array with key as ISO 4217 currency code
 * 0 - Currency Symbol if there's
 * 1 - Round
 * 2 - Thousands separator
 * 3 - Decimal separator
 * 4 - 0 = symbol in front OR 1 = symbol after currency
 */
 
$currencies = array(
        'ARS' => array('',2,',','.',0),          //  Argentine Peso
        'AMD' => array('',2,'.',',',0),          //  Armenian Dram
        'AWG' => array('',2,'.',',',0),          //  Aruban Guilder
        'AUD' => array('',2,'.',' ',0),          //  Australian Dollar
        'BSD' => array('',2,'.',',',0),          //  Bahamian Dollar
        'BHD' => array('',3,'.',',',0),          //  Bahraini Dinar
        'BDT' => array('',2,'.',',',0),          //  Bangladesh, Taka
        'BZD' => array('',2,'.',',',0),          //  Belize Dollar
        'BMD' => array('',2,'.',',',0),          //  Bermudian Dollar
        'BOB' => array('',2,'.',',',0),          //  Bolivia, Boliviano
        'BAM' => array('',2,'.',',',0),          //  Bosnia and Herzegovina, Convertible Marks
        'BWP' => array('',2,'.',',',0),          //  Botswana, Pula
        'BRL' => array('',2,',','.',0),          //  Brazilian Real
        'BND' => array('',2,'.',',',0),          //  Brunei Dollar
        'CAD' => array('',2,'.',',',0),          //  Canadian Dollar
        'KYD' => array('',2,'.',',',0),          //  Cayman Islands Dollar
        'CLP' => array('',0,'','.',0),           //  Chilean Peso
        'CNY' => array('',2,'.',',',0),          //  China Yuan Renminbi
        'COP' => array('',2,',','.',0),          //  Colombian Peso
        'CRC' => array('',2,',','.',0),          //  Costa Rican Colon
        'HRK' => array('',2,',','.',0),          //  Croatian Kuna
        'CUC' => array('',2,'.',',',0),          //  Cuban Convertible Peso
        'CUP' => array('',2,'.',',',0),          //  Cuban Peso
        'CYP' => array('',2,'.',',',0),          //  Cyprus Pound
        'CZK' => array('',2,'.',',',1),          //  Czech Koruna
        'DKK' => array('',2,',','.',0),          //  Danish Krone
        'DOP' => array('',2,'.',',',0),          //  Dominican Peso
        'XCD' => array('',2,'.',',',0),          //  East Caribbean Dollar
        'EGP' => array('',2,'.',',',0),          //  Egyptian Pound
        'SVC' => array('',2,'.',',',0),          //  El Salvador Colon
        'EUR' => array('',2,',','.',0),          //  Euro
        'GHC' => array('',2,'.',',',0),          //  Ghana, Cedi
        'GIP' => array('',2,'.',',',0),          //  Gibraltar Pound
        'GTQ' => array('',2,'.',',',0),          //  Guatemala, Quetzal
        'HNL' => array('',2,'.',',',0),          //  Honduras, Lempira
        'HKD' => array('',2,'.',',',0),          //  Hong Kong Dollar
        'HUF' => array('',0,'','.',0),           //  Hungary, Forint
        'ISK' => array('',0,'','.',1),           //  Iceland Krona
        'INR' => array('',2,'.',',',0),          //  Indian Rupee ₹
        'IDR' => array('',2,',','.',0),          //  Indonesia, Rupiah
        'IRR' => array('',2,'.',',',0),          //  Iranian Rial
        'JMD' => array('',2,'.',',',0),          //  Jamaican Dollar
        'JPY' => array('',0,'',',',0),           //  Japan, Yen
        'JOD' => array('',3,'.',',',0),          //  Jordanian Dinar
        'KES' => array('',2,'.',',',0),          //  Kenyan Shilling
        'KWD' => array('',3,'.',',',0),          //  Kuwaiti Dinar
        'LVL' => array('',2,'.',',',0),          //  Latvian Lats
        'LBP' => array('',0,'',' ',0),           //  Lebanese Pound
        'LTL' => array('',2,',',' ',1),          //  Lithuanian Litas
        'MKD' => array('',2,'.',',',0),          //  Macedonia, Denar
        'MYR' => array('',2,'.',',',0),          //  Malaysian Ringgit
        'MTL' => array('',2,'.',',',0),          //  Maltese Lira
        'MUR' => array('',0,'',',',0),           //  Mauritius Rupee
        'MXN' => array('',2,'.',',',0),          //  Mexican Peso
        'MZM' => array('',2,',','.',0),          //  Mozambique Metical
        'NPR' => array('',2,'.',',',0),          //  Nepalese Rupee
        'ANG' => array('',2,'.',',',0),          //  Netherlands Antillian Guilder
        'ILS' => array('',2,'.',',',0),          //  New Israeli Shekel ₪
        'TRY' => array('',2,'.',',',0),          //  New Turkish Lira
        'NZD' => array('',2,'.',',',0),          //  New Zealand Dollar
        'NOK' => array('',2,',','.',1),          //  Norwegian Krone
        'PKR' => array('',2,'.',',',0),          //  Pakistan Rupee
        'PEN' => array('',2,'.',',',0),          //  Peru, Nuevo Sol
        'UYU' => array('',2,',','.',0),          //  Peso Uruguayo
        'PHP' => array('',2,'.',',',0),          //  Philippine Peso
        'PLN' => array('',2,'.',' ',0),          //  Poland, Zloty
        'GBP' => array('',2,'.',',',0),          //  Pound Sterling
        'OMR' => array('',3,'.',',',0),          //  Rial Omani
        'RON' => array('',2,',','.',0),          //  Romania, New Leu
        'ROL' => array('',2,',','.',0),          //  Romania, Old Leu
        'RUB' => array('',2,',','.',0),          //  Russian Ruble
        'SAR' => array('',2,'.',',',0),          //  Saudi Riyal
        'SGD' => array('',2,'.',',',0),          //  Singapore Dollar
        'SKK' => array('',2,',',' ',0),          //  Slovak Koruna
        'SIT' => array('',2,',','.',0),          //  Slovenia, Tolar
        'ZAR' => array('',2,'.',' ',0),          //  South Africa, Rand
        'KRW' => array('',0,'',',',0),           //  South Korea, Won ₩
        'SZL' => array('',2,'.',', ',0),         //  Swaziland, Lilangeni
        'SEK' => array('',2,',','.',1),          //  Swedish Krona
        'CHF' => array('',2,'.','\'',0),         //  Swiss Franc 
        'TZS' => array('',2,'.',',',0),          //  Tanzanian Shilling
        'THB' => array('',2,'.',',',1),          //  Thailand, Baht ฿
        'TOP' => array('',2,'.',',',0),          //  Tonga, Paanga
        'AED' => array('',2,'.',',',0),          //  UAE Dirham
        'UAH' => array('',2,',',' ',0),          //  Ukraine, Hryvnia
        'USD' => array('',2,'.',',',0),          //  US Dollar
        'VUV' => array('',0,'',',',0),           //  Vanuatu, Vatu
        'VEF' => array('',2,',','.',0),          //  Venezuela Bolivares Fuertes
        'VEB' => array('',2,',','.',0),          //  Venezuela, Bolivar
        'VND' => array('',0,'','.',0),           //  Viet Nam, Dong ₫
        'ZWD' => array('',2,'.',' ',0),          //  Zimbabwe Dollar
        );
    
        
        //rupees weird format
        if ($curr == "INR")
            $number = formatinr($floatcurr);
        else 
            $number = number_format($floatcurr,$currencies[$curr][1],$currencies[$curr][2],$currencies[$curr][3]);
 
        //adding the symbol in the back
        if ($currencies[$curr][0] === NULL)
            $number.= ' '.$curr;
        elseif ($currencies[$curr][4]===1)
            $number.= $currencies[$curr][0];
        //normally in front
        else
            $number = $currencies[$curr][0].$number;
 
        return $number;
    }
 
    /**
     * formats to indians rupees
     * from http://www.joelpeterson.com/blog/2011/03/formatting-over-100-currencies-in-php/
     * @param  float $input money
     * @return string        formated currency
     */
    function formatinr($input){
        //CUSTOM FUNCTION TO GENERATE ##,##,###.##
        $dec = "";
        $pos = strpos($input, ".");
        if ($pos === false){
            //no decimals   
        } else {
            //decimals
            $dec = substr(round(substr($input,$pos),2),1);
            $input = substr($input,0,$pos);
        }
        $num = substr($input,-3); //get the last 3 digits
        $input = substr($input,0, -3); //omit the last 3 digits already stored in $num
        while(strlen($input) > 0) //loop the process - further get digits 2 by 2
        {
            $num = substr($input,-2).",".$num;
            $input = substr($input,0,-2);
        }
        return $num . $dec;
    }
 

/**
 * Helper Function to define vehicle price, currency, currency position
 */
if(!function_exists('tdp_vehicle_price')):
    function tdp_vehicle_price() {

        $currency_symbol = get_field('currency_symbol','option');
        $currency_position = get_field('currency_position','option');

        $price = get_field('price');
        $chars = strlen($price);

        
        if($currency_position == 'Left' || $currency_position == '') {

            echo $currency_symbol.tdp_formatcurrency($price, get_field('currency_code','option'));

        } else if($currency_position == 'Right') {

           echo tdp_formatcurrency($price, get_field('currency_code','option')).$currency_symbol;
        
        } else {

            echo $currency_symbol.tdp_formatcurrency($price, get_field('currency_code','option'));

        }
    }
endif;