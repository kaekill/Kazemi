<?php
/*
Plugin Name: TDP Favorite Listings
Plugin URI: http://themesdepot.org
Description: Add the ability for users to favorite listings and save them into their dashboard.
Version: 1.3.1
Author: ThemesDepot
Author URI: http://themesdepot.org
*/

define('TDP_PATH', plugins_url() . '/tdp-favorite-listings');
define('TDP_META_KEY', "tdp_favorites");
define('TDP_USER_OPTION_KEY', "tdp_useroptions");
define('TDP_COOKIE_KEY', "wp-favorite-posts");

// manage default privacy of users favorite post lists by adding this constant to wp-config.php
if ( !defined( 'TDP_DEFAULT_PRIVACY_SETTING' ) )
    define( 'TDP_DEFAULT_PRIVACY_SETTING', false );

$ajax_mode = 1;

function wp_favorite_posts() {
    if (isset($_REQUEST['tdpaction'])):
        global $ajax_mode;
        $ajax_mode = isset($_REQUEST['ajax']) ? $_REQUEST['ajax'] : false;
        if ($_REQUEST['tdpaction'] == 'add') {
            tdp_add_favorite();
        } else if ($_REQUEST['tdpaction'] == 'remove') {
            tdp_remove_favorite();
        } else if ($_REQUEST['tdpaction'] == 'clear') {
            if (tdp_clear_favorites()) tdp_die_or_go(tdp_get_option('cleared'));
            else tdp_die_or_go("ERROR");
        }
    endif;
}
add_action('wp_loaded', 'wp_favorite_posts');

function tdp_add_favorite($post_id = "") {
    if ( empty($post_id) ) $post_id = $_REQUEST['postid'];
    if (tdp_get_option('opt_only_registered') && !is_user_logged_in() ) {
        tdp_die_or_go(tdp_get_option('text_only_registered') );
        return false;
    }

    if (tdp_do_add_to_list($post_id)) {
        // added, now?
        do_action('tdp_after_add', $post_id);
        if (tdp_get_option('statics')) tdp_update_post_meta($post_id, 1);
        if (tdp_get_option('added') == 'show remove link') {
            $str = tdp_link(1, "remove", 0, array( 'post_id' => $post_id ) );
            tdp_die_or_go($str);
        } else {

            $link = __('Added To Favorites','tdp');

            tdp_die_or_go($link);
        }
    }
}
function tdp_do_add_to_list($post_id) {
    if (tdp_check_favorited($post_id))
        return false;
    if (is_user_logged_in()) {
        return tdp_add_to_usermeta($post_id);
    } else {
        return tdp_set_cookie($post_id, "added");
    }
}

function tdp_remove_favorite($post_id = "") {
    if (empty($post_id)) $post_id = $_REQUEST['postid'];
    if (tdp_do_remove_favorite($post_id)) {
        // removed, now?
        do_action('tdp_after_remove', $post_id);
        if (tdp_get_option('statics')) tdp_update_post_meta($post_id, -1);
        if (tdp_get_option('removed') == 'show add link') {
            if ( isset($_REQUEST['page']) && $_REQUEST['page'] == 1 ):
                $str = '';
            else:
                $str = tdp_link(1, "add", 0, array( 'post_id' => $post_id ) );
            endif;
            tdp_die_or_go($str);
        } else {
            tdp_die_or_go(__('Removed From Favorites','tdp'));
        }
    }
    else return false;
}

function tdp_die_or_go($str) {
    global $ajax_mode;
    if ($ajax_mode):
        die($str);
    else:
        wp_redirect($_SERVER['HTTP_REFERER']);
    endif;
}

function tdp_add_to_usermeta($post_id) {
    $tdp_favorites = tdp_get_user_meta();
    $tdp_favorites[] = $post_id;
    tdp_update_user_meta($tdp_favorites);
    return true;
}

function tdp_check_favorited($cid) {
    if (is_user_logged_in()) {
        $favorite_post_ids = tdp_get_user_meta();
        if ($favorite_post_ids)
            foreach ($favorite_post_ids as $fpost_id)
                if ($fpost_id == $cid) return true;
	} else {
	    if (tdp_get_cookie()):
	        foreach (tdp_get_cookie() as $fpost_id => $val)
	            if ($fpost_id == $cid) return true;
	    endif;
	}
    return false;
}

function tdp_link( $return = 0, $action = "", $show_span = 1, $args = array() ) {
    global $post;
    //print_r($post);
    $post_id = &$post->ID;
    extract($args);
    $str = "";
    if ($show_span)
        $str = "<span class='tdp-span'>";
    if ($action == "remove"):
        $str .= tdp_link_html($post_id, __('Remove From Favorites','tdp'), "remove");
    elseif ($action == "add"):
        $str .= tdp_link_html($post_id, __('Add To Favorites','tdp'), "add");
    elseif (tdp_check_favorited($post_id)):
        $str .= tdp_link_html($post_id, __('Remove From Favorites','tdp'), "remove");
    else:
        $str .= tdp_link_html($post_id, __('Add To Favorites','tdp'), "add");
    endif;
    if ($show_span)
        $str .= "</span>";
    if ($return) { return $str; } else { echo $str; }
}

function tdp_link_html($post_id, $opt, $action) {
    $link = "<a class='tdp-link btn small tdp_fav-link' href='?tdpaction=".$action."&amp;postid=". $post_id . "' title='". $opt ."' rel='nofollow'><i class='icon-star'></i>". $opt ."</a>";
    $link = apply_filters( 'tdp_link_html', $link );
    return $link;
}

function tdp_get_users_favorites($user = "") {
    $favorite_post_ids = array();

    if (!empty($user)):
        return tdp_get_user_meta($user);
    endif;

    # collect favorites from cookie and if user is logged in from database.
    if (is_user_logged_in()):
        $favorite_post_ids = tdp_get_user_meta();
	else:
	    if (tdp_get_cookie()):
	        foreach (tdp_get_cookie() as $post_id => $post_title) {
	            array_push($favorite_post_ids, $post_id);
	        }
	    endif;
	endif;
    return $favorite_post_ids;
}

function tdp_list_favorite_posts( $args = array() ) {
    $user = isset($_REQUEST['user']) ? $_REQUEST['user'] : "";
    extract($args);
    global $favorite_post_ids;
    if ( !empty($user) ) {
        if ( tdp_is_user_favlist_public($user) )
            $favorite_post_ids = tdp_get_users_favorites($user);

    } else {
        $favorite_post_ids = tdp_get_users_favorites();
    }

	if ( @file_exists(TEMPLATEPATH.'/tdp-page-template.php') || @file_exists(STYLESHEETPATH.'/tdp-page-template.php') ):
        if(@file_exists(TEMPLATEPATH.'/tdp-page-template.php')) :
            include(TEMPLATEPATH.'/tdp-page-template.php');
        else :
            include(STYLESHEETPATH.'/tdp-page-template.php');
        endif;
    else:
        include("tdp-page-template.php");
    endif;
}

function tdp_fav_list_favorite_posts( $args = array() ) {
    $user = isset($_REQUEST['user']) ? $_REQUEST['user'] : "";
    extract($args);
    global $favorite_post_ids;
    if ( !empty($user) ) {
        if ( tdp_is_user_favlist_public($user) )
            $favorite_post_ids = tdp_get_users_favorites($user);

    } else {
        $favorite_post_ids = tdp_get_users_favorites();
    }

    if ( @file_exists(TEMPLATEPATH.'/tdp-page-template.php') || @file_exists(STYLESHEETPATH.'/tdp-page-template.php') ):
        if(@file_exists(TEMPLATEPATH.'/tdp-page-template.php')) :
            include(TEMPLATEPATH.'/tdp-page-template.php');
        else :
            include(STYLESHEETPATH.'/tdp-page-template.php');
        endif;
    else:
        include("tdp-page-template.php");
    endif;
}

function tdp_list_most_favorited($limit=5) {
    global $wpdb;
    $query = "SELECT post_id, meta_value, post_status FROM $wpdb->postmeta";
    $query .= " LEFT JOIN $wpdb->posts ON post_id=$wpdb->posts.ID";
    $query .= " WHERE post_status='publish' AND meta_key='".TDP_META_KEY."' AND meta_value > 0 ORDER BY ROUND(meta_value) DESC LIMIT 0, $limit";
    $results = $wpdb->get_results($query);
    if ($results) {
        echo "<ul>";
        foreach ($results as $o):
            $p = get_post($o->post_id);
            echo "<li>";
            echo "<a href='".get_permalink($o->post_id)."' title='". $p->post_title ."'>" . $p->post_title . "</a> ($o->meta_value)";
            echo "</li>";
        endforeach;
        echo "</ul>";
    }
}

function tdp_loading_img() {
    return "<img src='".TDP_PATH."/img/loading.gif' alt='Loading' title='Loading' class='tdp-hide tdp-img' />";
}

function tdp_before_link_img() {
    $options = tdp_get_options();
    $option = $options['before_image'];
    if ($option == '') {
        return "";
    } else if ($option == 'custom') {
        return "<img src='" . $options['custom_before_image'] . "' alt='Favorite' title='Favorite' class='tdp-img' />";
    } else {
        return "<img src='". TDP_PATH . "/img/" . $option . "' alt='Favorite' title='Favorite' class='tdp-img' />";
    }
}

function tdp_clear_favorites() {
    if (tdp_get_cookie()):
        foreach (tdp_get_cookie() as $post_id => $val) {
            tdp_set_cookie($post_id, "");
            tdp_update_post_meta($post_id, -1);
        }
    endif;
    if (is_user_logged_in()) {
        $favorite_post_ids = tdp_get_user_meta();
        if ($favorite_post_ids):
            foreach ($favorite_post_ids as $post_id) {
                tdp_update_post_meta($post_id, -1);
            }
        endif;
        if (!delete_user_meta(tdp_get_user_id(), TDP_META_KEY)) {
            return false;
        }
    }
    return true;
}

function tdp_do_remove_favorite($post_id) {
    if (!tdp_check_favorited($post_id))
        return true;

    $a = true;
    if (is_user_logged_in()) {
        $user_favorites = tdp_get_user_meta();
        $user_favorites = array_diff($user_favorites, array($post_id));
        $user_favorites = array_values($user_favorites);
        $a = tdp_update_user_meta($user_favorites);
    }
    if ($a) $a = tdp_set_cookie($_REQUEST['postid'], "");
    return $a;
}

function tdp_add_js_script() {
	if (!tdp_get_option('dont_load_js_file'))
		wp_enqueue_script( "wp-favroite-posts", TDP_PATH . "/tdp.js", array( 'jquery' ), false, true );
}
add_action('wp_print_scripts', 'tdp_add_js_script');

function tdp_wp_print_styles() {
	if (!tdp_get_option('dont_load_css_file'))
		echo "<link rel='stylesheet' id='tdp-css' href='" . TDP_PATH . "/tdp.css' type='text/css' />" . "\n";
}
add_action('wp_print_styles', 'tdp_wp_print_styles');

function tdp_init() {
    $tdp_options = array();
    $tdp_options['add_favorite'] = "Add to favorites";
    $tdp_options['added'] = "Added to favorites!";
    $tdp_options['remove_favorite'] = "Remove from favorites";
    $tdp_options['removed'] = "Removed from favorites!";
    $tdp_options['clear'] = "Clear favorites";
    $tdp_options['cleared'] = "<p>Favorites cleared!</p>";
    $tdp_options['favorites_empty'] = "Favorite list is empty.";
    $tdp_options['cookie_warning'] = "Your favorite posts saved to your browsers cookies. If you clear cookies also favorite posts will be deleted.";
    $tdp_options['rem'] = "remove";
    $tdp_options['text_only_registered'] = "Only registered users can favorite!";
    $tdp_options['statics'] = 1;
    $tdp_options['widget_title'] = '';
    $tdp_options['widget_limit'] = 5;
    $tdp_options['uf_widget_limit'] = 5;
    $tdp_options['before_image'] = 'star.png';
    $tdp_options['custom_before_image'] = '';
    $tdp_options['dont_load_js_file'] = 0;
    $tdp_options['dont_load_css_file'] = 0;
    $tdp_options['post_per_page'] = 20;
    $tdp_options['autoshow'] = '';
    $tdp_options['opt_only_registered'] = 0;
    add_option('tdp_options', $tdp_options);
}
add_action('activate_wp-favorite-posts/wp-favorite-posts.php', 'tdp_init');

function tdp_update_user_meta($arr) {
    return update_user_meta(tdp_get_user_id(),TDP_META_KEY,$arr);
}

function tdp_update_post_meta($post_id, $val) {
	$oldval = tdp_get_post_meta($post_id);
	if ($val == -1 && $oldval == 0) {
    	$val = 0;
	} else {
		$val = $oldval + $val;
	}
    return add_post_meta($post_id, TDP_META_KEY, $val, true) or update_post_meta($post_id, TDP_META_KEY, $val);
}

function tdp_delete_post_meta($post_id) {
    return delete_post_meta($post_id, TDP_META_KEY);
}

function tdp_get_cookie() {
    if (!isset($_COOKIE[TDP_COOKIE_KEY])) return;
    return $_COOKIE[TDP_COOKIE_KEY];
}

function tdp_get_options() {
   return get_option('tdp_options');
}

function tdp_get_user_id() {
    global $current_user;
    get_currentuserinfo();
    return $current_user->ID;
}

function tdp_get_user_meta($user = "") {
    if (!empty($user)):
        $userdata = get_user_by( 'login', $user );
        $user_id = $userdata->ID;
        return get_user_meta($user_id, TDP_META_KEY, true);
    else:
        return get_user_meta(tdp_get_user_id(), TDP_META_KEY, true);
    endif;
}

function tdp_get_post_meta($post_id) {
    $val = get_post_meta($post_id, TDP_META_KEY, true);
    if ($val < 0) $val = 0;
    return $val;
}

function tdp_set_cookie($post_id, $str) {
    $expire = time()+60*60*24*30;
    return setcookie("wp-favorite-posts[$post_id]", $str, $expire, "/");
}

function tdp_is_user_favlist_public($user) {
    $user_opts = tdp_get_user_options($user);
    if (empty($user_opts)) return TDP_DEFAULT_PRIVACY_SETTING;
    if ($user_opts["is_tdp_list_public"])
        return true;
    else
        return false;
}

function tdp_get_user_options($user) {
    $userdata = get_user_by( 'login', $user );
    $user_id = $userdata->ID;
    return get_user_meta($user_id, TDP_USER_OPTION_KEY, true);
}

function tdp_is_user_can_edit() {
    if (isset($_REQUEST['user']) && $_REQUEST['user'])
        return false;
    return true;
}

function tdp_remove_favorite_link($post_id) {
    if (tdp_is_user_can_edit()) {
        $tdp_options = tdp_get_options();
        $class = 'tdp-link remove-parent';
        $link = "<a id='rem_$post_id' class='$class' href='?tdpaction=remove&amp;page=1&amp;postid=". $post_id ."' title='".tdp_get_option('rem')."' rel='nofollow'>".__('Remove From Favorites','tdp')."</a>";
        $link = apply_filters( 'tdp_remove_favorite_link', $link );
        echo $link;
    }
}

function tdp_clear_list_link() {
    if (tdp_is_user_can_edit()) {
        $tdp_options = tdp_get_options();
        echo "<a class='tdp-link' href='?tdpaction=clear' rel='nofollow'>". __('Clear Favorites','tdp') . "</a>";
    }
}

function tdp_cookie_warning() {
    if (!is_user_logged_in() && !isset($_GET['user']) ):
        echo "<p>".tdp_get_option('cookie_warning')."</p>";
    endif;
}

function tdp_get_option($opt) {
    $tdp_options = tdp_get_options();
    return htmlspecialchars_decode( stripslashes ( $tdp_options[$opt] ) );
}

function tdp_load_textdomain_fep()
{
    load_plugin_textdomain( 'tdp', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );  
}
add_action("init", "tdp_load_textdomain_fep", 1);