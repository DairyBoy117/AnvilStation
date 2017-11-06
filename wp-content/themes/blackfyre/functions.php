<?php
//translatable theme
load_theme_textdomain( 'blackfyre', get_template_directory() . '/langs');
?>
<?php

/*include important files*/
require_once (get_template_directory() . '/pluginactivation.php');
require_once (get_template_directory() .'/themeOptions/functions.php');
require_once (get_template_directory() .'/themeOptions/rating.php');
require_once (get_template_directory() .'/theme-functions/page-templates.php' );
require_once (get_template_directory() .'/bootstrap-carousel.php');
require_once (get_template_directory() .'/widgets/rating/popular-widget.php');
require_once (get_template_directory() .'/widgets/latest_twitter/latest_twitter_widget.php');
require_once (get_template_directory() .'/widgets/instagram/instagram.php');
require_once (get_template_directory() .'/addons/smartmetabox/SmartMetaBox.php');
require_once (get_template_directory() .'/addons/icon_addon/icon_addon.php' );
require_once (get_template_directory() .'/addons/heart/love/heart-love.php');
require_once (get_template_directory() .'/addons/clan-wars/wp-clanwars.php');
require_once (get_template_directory() .'/addons/multiple-post-thumbnails/multi-post-thumbnails.php');
require_once (get_template_directory() .'/addons/slider/acf.php');
require_once (get_template_directory() .'/addons/slider/acf-repeater/repeater.php');
require_once (get_template_directory() .'/addons/google-fonts/google-fonts.php');
require_once (get_template_directory() .'/addons/persist-admin-notices-dismissal/persist-admin-notices-dismissal.php');
require_once (get_template_directory() .'/post_templates.php');
require_once (get_template_directory() .'/functions_lj.php');
require_once (get_template_directory() . '/vc.php');
require_once ( ABSPATH . 'wp-admin/includes/plugin.php');


/* Custom code goes below this line. */


add_action( 'after_setup_theme', 'blackfyre_theme_setup' );

function blackfyre_theme_setup() {
    /* Add filters, actions, and theme-supported features. */

    /*****ACTIONS*****/

    /*menu*/
    add_action( 'admin_menu', 'blackfyre_create_menu' );
    add_action( 'wp_update_nav_menu_item', 'blackfyre_nav_update',10, 3);
    add_action( 'init', 'blackfyre_register_my_menus' );
    add_action( 'admin_menu', 'skywarrior_remove_menus' );
    add_action( 'admin_init', 'skywarrior_restrict_admin', 1 );

    /*styles*/
    add_action( 'wp_enqueue_scripts', 'blackfyre_style' );
    add_action( 'wp_enqueue_scripts', 'blackfyre_fonts' );
    add_action( 'wp_enqueue_scripts', 'blackfyre_external_styles' );
    add_action( 'admin_enqueue_scripts', 'blackfyre_styles_admin' );


    /*scripts*/
    add_action( 'wp_enqueue_scripts', 'blackfyre_my_scripts' );
    add_action( 'admin_enqueue_scripts', 'blackfyre_scripts_admin' );

    /*plugin activation*/
    add_action( 'tgmpa_register', 'blackfyre_register_required_plugins' );

    /*custom post type*/
    add_action( 'admin_menu', 'blackfyre_remove_matches_menu' );
    add_action( 'delete_post', 'blackfyre_onclan_delete' );
    add_action( 'publish_clan', 'blackfyre_onclan_publish' );

    /*metaboxes*/
    add_action( 'save_post', 'blackfyre_change_clan_admin' );

    /*buffering*/
    add_action( 'init', 'blackfyre_do_output_buffer' );

    /*comments*/
    add_action( 'comment_post', 'blackfyre_ajaxify_comments',20, 2 );
    remove_action ('comment_form', 'wp_comment_form_unfiltered_html_nonce');

    /*slider*/
    add_action( 'manage_slider_posts_custom_column', 'blackfyre_custom_slider_column', 10, 2 );
    add_action( 'save_post', 'blackfyre_save_slider_info' );

    /*sessions*/
    add_action( 'init', 'blackfyre_myStartSession', 1 );
    add_action( 'wp_logout', 'blackfyre_myEndSession' );
    add_action( 'wp_login', 'blackfyre_myEndSession' );

    /*user registration countries*/
    add_action( 'blackfyre_registration_clist', 'blackfyre_registration_country_list' );

    /*buddypress*/
    add_action( 'wp', 'blackfyre_remove_profile_subnav', 2 );
    add_action( 'bp_setup_nav', 'blackfyre_mb_profile_menu_tabs', 201 );
    remove_action( 'bp_init', 'bp_core_wpsignup_redirect');
    add_action( 'wp_before_admin_bar_render', 'skywarrior_bpfr_admin_bar_render' );
    add_action( 'wp_ajax_addremove_friend', 'skywarrior_bp_legacy_theme_ajax_addremove_friend',1 );
    add_action( 'wp_ajax_nopriv_addremove_friend', 'skywarrior_bp_legacy_theme_ajax_addremove_friend',1 );
    add_action('xprofile_avatar_uploaded', 'blackfyre_update_avatar_admin');
    remove_action( 'admin_notices', 'bp_core_print_admin_notices');

    /*ajax calls*/
    add_action( 'wp_ajax_update_user_profile_pic', 'blackfyre_update_user_profile_pic_callback' );
    add_action( 'wp_ajax_update_user_clan_bg', 'blackfyre_update_user_clan_bg_callback' );
    add_action( 'wp_ajax_update_page_bg', 'blackfyre_update_page_bg_callback' );
    add_action( 'wp_ajax_update_user_profile_bg', 'blackfyre_update_user_profile_bg_callback' );
    add_action( 'wp_ajax_update_clan_pic', 'blackfyre_update_clan_pic_callback' );
    add_action( 'wp_ajax_nopriv_update_clan_pic', 'blackfyre_update_clan_pic_callback' );
    add_action( 'wp_ajax_nopriv_blackfyre_redirect', 'blackfyre_redirect' );
    add_action( 'wp_ajax_blackfyre_redirect', 'blackfyre_redirect' );
    add_action( 'wp_ajax_nopriv_blackfyre_delete_page_background', 'blackfyre_delete_page_background' );
    add_action( 'wp_ajax_blackfyre_delete_page_background', 'blackfyre_delete_page_background' );
    add_action( 'wp_ajax_nopriv_blackfyre_change_membership_block', 'blackfyre_change_membership_block' );
    add_action( 'wp_ajax_blackfyre_change_membership_block', 'blackfyre_change_membership_block' );
    add_action( 'wp_ajax_nopriv_blackfyre_change_membership_let_join', 'blackfyre_change_membership_let_join' );
    add_action( 'wp_ajax_blackfyre_change_membership_let_join', 'blackfyre_change_membership_let_join' );
    add_action( 'wp_ajax_nopriv_blackfyre_change_membership_remove_friend_admin', 'blackfyre_change_membership_remove_friend_admin' );
    add_action( 'wp_ajax_blackfyre_change_membership_remove_friend_admin', 'blackfyre_change_membership_remove_friend_admin' );
    add_action( 'wp_ajax_nopriv_blackfyre_change_membership_make_administrator', 'blackfyre_change_membership_make_administrator' );
    add_action( 'wp_ajax_blackfyre_change_membership_make_administrator', 'blackfyre_change_membership_make_administrator' );
    add_action( 'wp_ajax_nopriv_blackfyre_change_membership_downgrade_to_user', 'blackfyre_change_membership_downgrade_to_user' );
    add_action( 'wp_ajax_blackfyre_change_membership_downgrade_to_user', 'blackfyre_change_membership_downgrade_to_user' );
    add_action( 'wp_ajax_nopriv_blackfyre_clan_members_ajax', 'blackfyre_clan_members_ajax' );
    add_action( 'wp_ajax_blackfyre_clan_members_ajax', 'blackfyre_clan_members_ajax' );
    add_action( 'wp_ajax_nopriv_blackfyre_challenge_acc_rej', 'blackfyre_challenge_acc_rej' );
    add_action( 'wp_ajax_blackfyre_challenge_acc_rej', 'blackfyre_challenge_acc_rej' );
    add_action( 'wp_ajax_nopriv_blackfyre_challenge_acc_rej_single', 'blackfyre_challenge_acc_rej_single' );
    add_action( 'wp_ajax_blackfyre_challenge_acc_rej_single', 'blackfyre_challenge_acc_rej_single' );
    add_action( 'wp_ajax_nopriv_blackfyre_match_score_acc_rej', 'blackfyre_match_score_acc_rej' );
    add_action( 'wp_ajax_blackfyre_match_score_acc_rej', 'blackfyre_match_score_acc_rej' );
    add_action( 'wp_ajax_nopriv_blackfyre_clan_delete', 'blackfyre_clan_delete' );
    add_action( 'wp_ajax_blackfyre_clan_delete', 'blackfyre_clan_delete' );
    add_action( 'wp_ajax_nopriv_blackfyre_match_delete', 'blackfyre_match_delete' );
    add_action( 'wp_ajax_blackfyre_match_delete', 'blackfyre_match_delete' );
    add_action( 'wp_ajax_nopriv_blackfyre_match_delete_confirmation', 'blackfyre_match_delete_confirmation' );
    add_action( 'wp_ajax_blackfyre_match_delete_confirmation', 'blackfyre_match_delete_confirmation' );
    add_action( 'wp_ajax_nopriv_blackfyre_match_delete_single', 'blackfyre_match_delete_single' );
    add_action( 'wp_ajax_blackfyre_match_delete_single', 'blackfyre_match_delete_single' );
    add_action( 'wp_ajax_nopriv_blackfyre_mutual_games', 'blackfyre_mutual_games' );
    add_action( 'wp_ajax_blackfyre_mutual_games', 'blackfyre_mutual_games' );
    add_action( 'wp_ajax_nopriv_blackfyre_all_clans_pagination_v2_ajax', 'blackfyre_all_clans_pagination_v2_ajax' );
    add_action( 'wp_ajax_blackfyre_all_clans_pagination_v2_ajax', 'blackfyre_all_clans_pagination_v2_ajax' );
    add_action( 'wp_ajax_nopriv_blackfyre_edit_acc_rej', 'blackfyre_edit_acc_rej' );
    add_action( 'wp_ajax_blackfyre_edit_acc_rej', 'blackfyre_edit_acc_rej' );
    add_action( 'wp_ajax_nopriv_blackfyre_edit_acc_rej_single', 'blackfyre_edit_acc_rej_single' );
    add_action( 'wp_ajax_blackfyre_edit_acc_rej_single', 'blackfyre_edit_acc_rej_single' );
    add_action( 'wp_ajax_nopriv_blackfyre_list_all_clans_for_selected_game_ajax', 'blackfyre_list_all_clans_for_selected_game_ajax' );
    add_action( 'wp_ajax_blackfyre_list_all_clans_for_selected_game_ajax', 'blackfyre_list_all_clans_for_selected_game_ajax' );

    /*multiple thumbnails*/
    add_action( 'admin_enqueue_scripts', 'blackfyre_admin_header_scripts' );

    /*vc*/
    add_action( 'admin_footer-edit.php', 'blakcfyre_footer_manager' );
    add_action( 'admin_footer-post.php', 'blakcfyre_footer_manager' );
    add_action( 'vc_load_default_templates','blackfyre_custom_template_for_vc' );
    add_action( 'vc_before_init', 'vc_remove_be_pointers' );
    add_action( 'vc_before_init', 'vc_remove_fe_pointers' );


    /*media library*/
    add_action( 'pre_get_posts','blackfyre_restrict_media_library' );
    add_action('wp_enqueue_scripts', 'blackfyre_add_media_upload_scripts');

    /*post templates*/
    add_action( 'init', 'blackfyre_post_templates_plugin_init' );

    /*notices*/
    add_action( 'admin_notices', 'skywarrior_update_nag', 1 );

    /*user profiles*/
    add_action( 'personal_options_update', 'save_skywarrior_clan_extra_user_profile_fields' );
    add_action( 'edit_user_profile_update', 'save_skywarrior_clan_extra_user_profile_fields' );
    add_action( 'show_user_profile', 'skywarrior_clan_extra_user_profile_fields' );
    add_action( 'edit_user_profile', 'skywarrior_clan_extra_user_profile_fields' );

    /*remove users from clan*/
    add_action( 'delete_user', 'blackfyre_remove_user_from_clan_on_delete' );

    /*add nickname column*/
    add_action('admin_init', 'skywarrior_load_sortable_user_meta_columns');

    /*roles*/
    add_action( 'admin_init', 'add_theme_caps');

    /*check if user is active*/
    add_action('wp_login', 'blackfyre_user_active_check', 10, 2);

    /*clan unique name*/
    add_action( 'wp_ajax_blackfyre_check_if_clanname_unique', 'blackfyre_check_if_clanname_unique' );
    add_action( 'wp_ajax_nopriv_blackfyre_check_if_clanname_unique', 'blackfyre_check_if_clanname_unique' );

    /*init notice*/
    add_action( 'admin_init', array( 'PAnD', 'init' ) );
    add_action( 'admin_notices', 'blackfyre_admin_notice__success1' );

    /*clan images*/
    add_action( 'add_meta_boxes', 'blackfyre_clan_image_metabox' );
    add_action('save_post', 'blackfyre_clan_image_metabox_save', 1, 2);
    /*****FILTERS*****/

    /*menu*/
    add_filter( 'wp_setup_nav_menu_item','blackfyre_nav_item' );
    add_filter( 'wp_edit_nav_menu_walker', 'blackfyre_nav_edit_walker',10,2 );

    /*sidebars*/
    add_filter('dynamic_sidebar_params','blackfyre_widget_first_last_classes');

    /*excerpt*/
    add_filter( 'excerpt_length', 'blackfyre_excerpt_length', 999 );
    add_filter( 'excerpt_length', 'blackfyre_excerpt_length_pro', 999 );

    /*slider*/
    add_filter( 'the_content', 'blackfyre_remove_slider_from_home' );
    add_filter( 'manage_edit-slider_columns', 'blackfyre_set_custom_edit_slider_columns' );

    /*woocommerce*/
    add_filter( 'add_to_cart_fragments', 'blackfyre_woocommerce_header_add_to_cart_fragment' );

    /*tinymce*/
    add_filter( 'tiny_mce_before_init', 'blackfyre_change_mce_options' );

    /*social login*/
    add_filter( 'pre_user_email', 'blackfyre_skip_email_exist' );

    /*gravatar*/
    add_filter( 'get_avatar', 'blackfyre_be_gravatar_filter', 1, 6 );
    add_filter( 'bp_core_mysteryman_src', 'blackfyre_be_gravatar_filter_admin', 1, 5 );

    /*buddypress*/
    add_filter( 'bp_get_add_friend_button', 'blackfyre_add_friend_link_text' );
    add_filter( 'bp_core_mysteryman_src', 'skywarrior_buddypress_avatar' );
    add_filter( 'bp_get_activity_secondary_avatar', 'skywarrior_turn_secondary_avatars_to_links' );
    add_filter( 'bp_core_fetch_avatar', 'filter_bp_core_fetch_avatar', 10, 3 );
    add_filter( 'bp_before_xprofile_cover_image_settings_parse_args', 'blackfyre_cover_image_css', 10, 1 );
    add_filter( 'bp_before_groups_cover_image_settings_parse_args', 'blackfyre_cover_image_css', 10, 1 );
    add_filter('bp_directory_members_search_form', 'blackfyre_bp_directory_members_search_form');

    /*role*/
    add_filter( 'pre_option_default_role', 'blackfyre_defaultrole' );

    /*comments*/
    add_filter( 'comments_open', 'blackfyre_comments_open', 10, 2 );
    add_filter( 'wp_insert_post_data', 'blackfyre_comments_on' );
    add_filter( 'wp_insert_post_data', 'skywarrior_matches_comments_on');
    add_filter( 'save_post', 'skywarrior_matches_edit_comments_on' );
    add_filter('comment_text', 'wp_filter_nohtml_kses');
    add_filter('comment_text_rss', 'wp_filter_nohtml_kses');
    add_filter('comment_excerpt', 'wp_filter_nohtml_kses');


    /*register page*/
    add_filter( 'register_url', 'blackfyre_register_page' );


    /*****THEME-SUPPORTED FEATURES*****/

    /*add custom menu support*/
    add_theme_support( 'menus' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'woocommerce' );
    add_theme_support( 'title-tag' );

}

/*register sidebars*/
 add_action( 'after_setup_theme', 'blackfyre_register_sidebars' );
function blackfyre_register_sidebars() {
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => esc_html__( 'Home sidebar', 'blackfyre' ),
'id' => 'one',
'description' => esc_html__( 'Widgets in this area will be shown in the home page.' , 'blackfyre'),
'before_widget' => '<div class="widget">',
'after_widget' => '</div>',
'before_title' => '<div class="title-wrapper"><h3 class="widget-title">',
'after_title' => '</h3><div class="clear"></div></div>', ));
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => esc_html__( 'General sidebar', 'blackfyre' ),
'id' => 'two',
'description' => esc_html__( 'General sidebar for use with page builder.' , 'blackfyre'),
'before_widget' => '<div class="widget">',
'after_widget' => '</div>',
'before_title' => '<div class="title-wrapper"><h3 class="widget-title">',
'after_title' => '</h3><div class="clear"></div></div>', ));
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => esc_html__( 'Blog sidebar', 'blackfyre' ),
'id' => 'three',
'description' => esc_html__( 'Widgets in this area will be shown in the blog sidebar.' , 'blackfyre'),
'before_widget' => '<div class="widget">',
'after_widget' => '</div>',
'before_title' => '<div class="title-wrapper"><h3 class="widget-title">',
'after_title' => '</h3><div class="clear"></div></div>', ));
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => esc_html__( 'Footer area widgets', 'blackfyre' ),
'id' => 'footer',
'description' => esc_html__( 'Widgets in this area will be shown in the footer.' , 'blackfyre'),
'before_widget' => '<div class="footer_widget col-lg-4 col-md-4">',
'after_widget' => '</div>',
'before_title' => '<div class="title-wrapper"><h3 class="widget-title">',
'after_title' => '</h3><div class="clear"></div></div>', ));
}
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => 'WooCommerce Sidebar',
'id' => 'woo',
'description' => esc_html__( 'Widgets in this area will be shown in the WooCommerce sidebar.' , 'blackfyre'),
'before_widget' =>  '<div id="%1$s" class="widget widgetSidebar %2$s">',
'after_widget'  => '</div>',
'before_title' => '<div class="title-wrapper"><h3 class="widget-title">',
'after_title' => '</h3><div class="clear"></div></div>', ));
}
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => 'ClanWars Sidebar',
'id' => 'clanwars',
'description' => esc_html__( 'Widgets in this area will be shown in the Clan Wars sidebar.' , 'blackfyre'),
'before_widget' =>  '<div id="%1$s" class="widget widgetSidebar %2$s">',
'after_widget'  => '</div>',
'before_title' => '<div class="title-wrapper"><h3 class="widget-title">',
'after_title' => '</h3><div class="clear"></div></div>', ));
if ( is_plugin_active( 'buddypress/bp-loader.php' ) ) {
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => 'BuddyPress Sidebar',
'id' => 'buddypress',
'description' => esc_html__( 'Widgets in this area will be shown in the BuddyPress sidebar.' , 'blackfyre'),
'before_widget' =>  '<div id="%1$s" class="widget widgetSidebar %2$s">',
'after_widget'  => '</div>',
'before_title' => '<div class="title-wrapper"><h3 class="widget-title">',
'after_title' => '</h3><div class="clear"></div></div>', ));
}


/**
 * Dynamically sets classes on footer widgets based on number of widgets.
 *
 * @since Blackfyre 1.4
 */
function blackfyre_footer_sidebar_classes( $params ) {
    $sidebar_id = $params[0]['id'];

    if ( $sidebar_id == 'footer' ) {

        $total_widgets = wp_get_sidebars_widgets();
        $sidebar_widgets = count( $total_widgets[$sidebar_id] );

        if ( $sidebar_widgets == 2 ) {
            $params[0]['before_widget'] = str_replace( 'col-lg-4', 'col-lg-6', $params[0]['before_widget'] );
            $params[0]['before_widget'] = str_replace( 'col-md-4', 'col-md-6', $params[0]['before_widget'] );
        } else if ( $sidebar_widgets == 4 ) {
            $params[0]['before_widget'] = str_replace( 'col-lg-4', 'col-lg-3', $params[0]['before_widget'] );
            $params[0]['before_widget'] = str_replace( 'col-md-4', 'col-md-3', $params[0]['before_widget'] );
        } else if ( $sidebar_widgets == 1 ) {
            $params[0]['before_widget'] = str_replace( 'col-lg-4', 'col-lg-12', $params[0]['before_widget'] );
            $params[0]['before_widget'] = str_replace( 'col-md-4', 'col-md-12', $params[0]['before_widget'] );
        }

    }

    return $params;
}
add_filter( 'dynamic_sidebar_params', 'blackfyre_footer_sidebar_classes' );


/*add custom menu support*/
function blackfyre_create_menu(){
$themeicon1 = get_template_directory_uri()."/img/favicon.png";
add_menu_page("Theme Options", "Theme Options", 'edit_theme_options', 'options-framework', 'optionsframework_page',$themeicon1,1800 );
}


function blackfyre_nav_update($menu_id, $menu_item_db_id, $args ) {
    if (isset($_REQUEST['menu-item-custom'])) {
        if ( is_array($_REQUEST['menu-item-custom']) ) {
            $custom_value = $_REQUEST['menu-item-custom'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_custom', $custom_value );
        }
    }
    $removemegamenu = true;
    if (isset($_REQUEST['megamenu-checkbox'])) {
        if ( is_array($_REQUEST['megamenu-checkbox']) ) {
            if (isset($_REQUEST['megamenu-checkbox'][$menu_item_db_id])) {
            if ($_REQUEST['megamenu-checkbox'][$menu_item_db_id] == "on") {
                update_post_meta( $menu_item_db_id, '_uses_megamenu', "yes" );
                $removemegamenu = false;
            }
          }
        }
    }
    if ($removemegamenu == true) {
        update_post_meta( $menu_item_db_id, '_uses_megamenu', "no" );
    }
}
/*
 * Adds value of new field to $item object that will be passed to     Walker_Nav_Menu_Edit_Custom
 */

function blackfyre_nav_item($menu_item) {
    $menu_item->custom = get_post_meta( $menu_item->ID, '_menu_item_custom', true );
    return $menu_item;
}

function blackfyre_nav_edit_walker($walker,$menu_id) {
    return 'Walker_Nav_Menu_Edit_Custom';
}


add_action( 'after_setup_theme', 'blackfyre_theme_tweak' );
function blackfyre_theme_tweak(){


// When this theme is activated send the user to the theme options
if (is_admin() && isset($_GET['activated'] ) ) {
// Do redirect
header( 'Location: '.admin_url().'themes.php?page=options-framework' ) ;
}


/*register theme location menu*/
function blackfyre_register_my_menus() {
  register_nav_menus(
    array(
      'header-menu' => esc_html__( 'Header Menu' , 'blackfyre'),
      )
  );
}
}


/* Breadcrumbs */
function blackfyre_pg(){
    $pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'tmp-blog.php'
));
foreach($pages as $page){
   return $page->post_name;
}}
function blackfyre_get_page_id($name){
global $wpdb;
// get page id using custom query
$page_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE ( post_name = %s or post_title = %s )
and post_status = 'publish' and post_type='page'",
    $name));
return $page_id;
}
function blackfyre_get_page_permalink($name){
$page_id = blackfyre_get_page_id($name);
return get_permalink($page_id);
}
// Breadcrumbs
function blackfyre_breadcrumbs_inner() {
    if (!is_home()) {
        echo '<a href="';
        echo esc_url(home_url());
        echo '">';
        esc_html_e('Home', 'blackfyre');
        echo "</a> / ";

        if(get_post_type() == 'matches' && !is_search()){
        esc_html_e('Matches', 'blackfyre');
            if (is_single()) {
                echo " / ";
                the_title();
            }
        } elseif(is_category()) {
            esc_html_e('Category: ', 'blackfyre');
            echo esc_attr(single_cat_title());

        } elseif(is_404()) {
            echo '404';

        } elseif(is_search()) {
            esc_html_e('Search: ', 'blackfyre');
            echo esc_attr(get_search_query());

        } elseif(is_author()) {
            $curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author')); echo esc_attr($curauth->user_nicename);
        } elseif (is_page()) {
            echo the_title();
        } elseif (is_single()) {
            echo the_title();
        }elseif(is_tag()) {
              esc_html_e('Tag: ', 'blackfyre');
             echo blackfyre_GetTagName(get_query_var('tag_id'));
        }elseif( function_exists( 'is_shop' ) && is_shop() ){
             esc_html_e('Shop', 'blackfyre');
        }elseif( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {

                the_title();
        } elseif(is_archive()) {
        if ( is_day() ) : ?>
            <?php printf( esc_html__( 'Daily Archives: %s', 'blackfyre' ), get_the_date() ); ?>
        <?php elseif ( is_month() ) : ?>
            <?php printf( esc_html__( 'Monthly Archives: %s', 'blackfyre' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'blackfyre' ) ) ); ?>
        <?php elseif ( is_year() ) : ?>
            <?php printf( esc_html__( 'Yearly Archives: %s', 'blackfyre' ), get_the_date( _x( 'Y', 'yearly archives date format', 'blackfyre' ) ) ); ?>
        <?php else : ?>
            <?php esc_html_e( 'Blog Archives', 'blackfyre' ); ?>
        <?php endif;

        }

     if(is_admin()){
        $current_user= wp_get_current_user();
        $level = $current_user->user_level;
        if($level == 1){
            global $wp_post_types; $obj = $wp_post_types['video'];print $obj->labels->singular_name;
        }}
    }
}

function blackfyre_breadcrumbs(){

if(function_exists('is_bbpress')){
    if(is_bbpress()){
        bbp_breadcrumb();
    }else{
        blackfyre_breadcrumbs_inner();}
}else{
        blackfyre_breadcrumbs_inner();
  }
}

/*custom excerpt lenght*/
function blackfyre_excerpt_length( $length ){
    return 55;
}
function blackfyre_excerpt_length_pro( $length ) {
    return 40;
}


/*Post templates*/
function blackfyre_post_templates_plugin_init() {
    new Blackfyre_Single_Post_Template_Plugin;
}


/*pagination*/
function blackfyre_kriesi_pagination($pages = '', $range = 1){
$showitems = ($range * 1)+1;
$general_show_page  = of_get_option('general_post_show');
global $paged;
global $paginate;
if(empty($paged)) $paged = 1;
if($pages == '')
{
global $wp_query;
$pages = $wp_query->max_num_pages;
if(!$pages)
{
$pages = 1;
}
}
if(1 != $pages){
$url= get_template_directory_uri();
$leftpager= '&laquo;';
$rightpager= '&raquo;';
if($paged > 2 && $paged > $range+1 && $showitems < $pages) $paginate.=  "";
if($paged > 1 ) $paginate.=  "<a class='page-selector' href='".get_pagenum_link($paged - 1)."'>". $leftpager. "</a>";
for ($i=1; $i <= $pages; $i++){
if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
$paginate.=  ($paged == $i)? "<li class='active'><a href='".get_pagenum_link($i)."'>".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a></li>";
}
}
if ($paged < $pages ) $paginate.=  "<li><a class='page-selector' href='".get_pagenum_link($paged + 1)."' >". $rightpager. "</a></li>";
}
return $paginate;
}

/*color converter*/
function blackfyre_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

/*add featured image support*/
if ( function_exists( 'add_image_size' ) ) {
   set_post_thumbnail_size( 287, 222, true );
   set_post_thumbnail_size( 305, 305, true );
   add_image_size( 'profile-photo', 250, 250, true );
}

/*
 * Include the TGM_Plugin_Activation class.
 */

/*
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function blackfyre_register_required_plugins() {
    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        // This is an example of how to include a plugin pre-packaged with a theme
       array(
            'name'                  => 'BBpress', // The plugin name
            'slug'                  => 'bbpress', // The plugin slug (typically the folder name)
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
        ),array(
            'name'                  => 'BuddyPress', // The plugin name
            'slug'                  => 'buddypress', // The plugin slug (typically the folder name)
            'required'              => true, // If false, the plugin is only 'recommended' instead of required
        ),array(
            'name'                  => 'WooCommerce', // The plugin name
            'slug'                  => 'woocommerce', // The plugin slug (typically the folder name)
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
        ),array(
            'name'                  => 'Disqus Comment System', // The plugin name
            'slug'                  => 'disqus-comment-system', // The plugin slug (typically the folder name)
            'required'              => false,
        ),array(
            'name'                  => 'Blackfyre types', // The plugin name
            'slug'                  => 'blackfyre_custom_post_types', // The plugin slug (typically the folder name)
            'source'                => 'https://www.skywarriorthemes.com/plugins/blackfyre_custom_post_types.zip', // The plugin source
            'required'              => true,// If false, the plugin is only 'recommended' instead of required
        ),
         array(
            'name'                  => 'Visual composer', // The plugin name
            'slug'                  => 'js_composer', // The plugin slug (typically the folder name)
            'source'                =>  get_template_directory_uri() .'/plugins/js_composer.zip', // The plugin source
            'required'              => true, // If false, the plugin is only 'recommended' instead of required
        ),
         array(
            'name'                  => 'Parallax backgrounds for VC', // The plugin name
            'slug'                  => 'parallax-backgrounds-for-vc', // The plugin slug (typically the folder name)
            'source'                =>  get_template_directory_uri() .'/plugins/parallax-backgrounds-for-vc.zip', // The plugin source
            'required'              => true, // If false, the plugin is only 'recommended' instead of required
        ),array(
            'name'                  => esc_html__('Captcha', 'arcane'), // The plugin name
            'slug'                  => 'captcha', // The plugin slug (typically the folder name)
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
        ),
        array(
            'name'                  => 'Super Socializer', // The plugin name
            'slug'                  => 'super-socializer', // The plugin slug (typically the folder name)
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
        ),
        array(
            'name'                  => 'Pricing Tables', // The plugin name
            'slug'                  => 'pricing-table-by-supsystic', // The plugin slug (typically the folder name)
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
        ),

    );
    // Change this to your theme text domain, used for internationalising strings
    $theme_text_domain = 'blackfyre';
    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'domain'            => $theme_text_domain,          // Text domain - likely want to be the same as your theme.
        'default_path'      => '',                          // Default absolute path to pre-packaged plugins
        'menu'              => 'install-required-plugins',  // Menu slug
        'has_notices'       => true,                        // Show admin notices or not
        'is_automatic'      => true,                       // Automatically activate plugins after installation or not
        'message'           => '',                          // Message to output right before the plugins table
        'strings'           => array(
            'page_title'                                => esc_html__( 'Install Required Plugins', 'blackfyre' ),
            'menu_title'                                => esc_html__( 'Install Plugins', 'blackfyre' ),
            'installing'                                => esc_html__( 'Installing Plugin: %s', 'blackfyre' ), // %1$s = plugin name
            'oops'                                      => esc_html__( 'Something went wrong with the plugin API.', 'blackfyre' ),
            'notice_can_install_required'               => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'blackfyre'  ), // %1$s = plugin name(s)
            'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' , 'blackfyre' ), // %1$s = plugin name(s)
            'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' , 'blackfyre' ), // %1$s = plugin name(s)
            'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'blackfyre'  ), // %1$s = plugin name(s)
            'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'blackfyre'  ), // %1$s = plugin name(s)
            'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'blackfyre'  ), // %1$s = plugin name(s)
            'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'blackfyre'  ), // %1$s = plugin name(s)
            'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'blackfyre'  ), // %1$s = plugin name(s)
            'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'blackfyre'  ),
            'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins' , 'blackfyre'),
            'return'                                    => esc_html__( 'Return to Required Plugins Installer', 'blackfyre' ),
            'plugin_activated'                          => esc_html__( 'Plugin activated successfully.', 'blackfyre' ),
            'complete'                                  => esc_html__( 'All plugins installed and activated successfully. %s', 'blackfyre' ), // %1$s = dashboard link
            'nag_type'                                  => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
        )
    );
    tgmpa( $plugins, $config );
}

/*add media*/
 function blackfyre_add_media_upload_scripts() {
            if ( is_admin() ) {
                 return;
               }
            wp_enqueue_media();
}

/*theme styles*/
function blackfyre_style() {
  wp_enqueue_style( 'blackfyre_mytheme_style-style',  get_bloginfo( 'stylesheet_url' ), array(), '20150401' );
  wp_enqueue_style('wp-cw-sitecss', WP_CLANWARS_URL . '/css/site.css', array(), WP_CLANWARS_VERSION);
  wp_enqueue_style('wp-cw-widgetcss', WP_CLANWARS_URL . '/css/widget.css', array(), WP_CLANWARS_VERSION);

   if ( is_rtl() )
    {
        wp_enqueue_style('blackfyre-rtl',  get_template_directory_uri() . '/css/rtl.css', array(), '20150401');
    }

    wp_enqueue_style('blackfyre-font-awesome',  get_template_directory_uri() . '/css/font-awesome.css', array(), '20160930');
    wp_enqueue_style('blackfyre-font-awesome-min',  get_template_directory_uri() . '/css/font-awesome.min.css', array(), '20160930');
    wp_enqueue_style('blackfyre-shadowbox',  get_template_directory_uri() . '/css/shadowbox.css', array(), '20160930');
    wp_enqueue_style('blackfyre-easy-slider',  get_template_directory_uri() . '/css/easy-slider.css', array(), '20160930');
    wp_enqueue_style('blackfyre-tooltip',  get_template_directory_uri() . '/css/tooltip.css', array(), '20160930');
}

function blackfyre_fonts() {
    wp_enqueue_style( 'blackfyre-fonts',blackfyre_fonts_url(), array(),'1.0.0');
}



function blackfyre_external_styles(){
  wp_enqueue_style( 'custom-style1',  get_template_directory_uri().'/css/jquery.fancybox.css',  array(), '20150401');
  wp_enqueue_style( 'custom-style2',  get_template_directory_uri().'/css/jquery.bxslider.css',  array(), '20150401');
  wp_enqueue_style( 'animatecss',  get_template_directory_uri().'/css/animate.css',  array(), '20150401');
  wp_enqueue_style( 'vcfixes',  get_template_directory_uri().'/css/vcfixes.css',  array(), '20150401');

}



/*theme scripts*/

function blackfyre_my_scripts(){

wp_enqueue_script( 'bootstrap1', get_template_directory_uri().'/js/bootstrap.min.js','','',true);

$settingsNoty = array(
            'challenge_accepted' => esc_html__('Challenge accepted!', 'blackfyre'),
            'challenge_rejected' => esc_html__('Challenge rejected!', 'blackfyre'),
            'delete_accepted' => esc_html__('Delete accepted!', 'blackfyre'),
            'delete_rejected' => esc_html__('Delete rejected!', 'blackfyre'),
            'match_delete_rejected' => esc_html__('Match delete rejected!', 'blackfyre'),
            'match_deleted_request' => esc_html__('Delete request sent!', 'blackfyre'),
            'edit_accepted' => esc_html__('Edit accepted!', 'blackfyre'),
            'edit_rejected' => esc_html__('Edit rejected!', 'blackfyre'),
            'match_deleted' => esc_html__('Match deleted!', 'blackfyre'),
            'match_deleted_canceled' => esc_html__('Match delete canceled!', 'blackfyre'),
            'score_accepted' => esc_html__('Score accepted!', 'blackfyre'),
            'score_rejected' => esc_html__('Score rejected!', 'blackfyre'),
            'challenge_request_sent' => esc_html__('Challenge request sent!', 'blackfyre'),
            'submitted' => esc_html__('Score has been submitted!', 'blackfyre'),
            'already_submitted' => esc_html__('Score has already been submitted by other team!', 'blackfyre'),
            'join_clan' => esc_html__('Your request to join clan has been sent!', 'blackfyre'),
            'let_this_member_join' => esc_html__('User joined your clan!', 'blackfyre'),
            'remove_friend' => esc_html__('Removed from clan!', 'blackfyre'),
            'cancel_request' => esc_html__('Request canceled!', 'blackfyre'),
            'make_administrator' => esc_html__('Added as administrator!', 'blackfyre'),
            'downgrade_to_user' => esc_html__('Admin downgraded!', 'blackfyre'),
            'reported' => esc_html__('Match has been reported!', 'blackfyre'),
            'clan_deleted' => esc_html__('Clan has been deleted!', 'blackfyre'),
            'delete_page_background' => esc_html__('Clan page background deleted successfully!', 'blackfyre'),
             );
wp_enqueue_script( 'noty', get_template_directory_uri().'/js/noty/packaged/jquery.noty.packaged.min.js','','',true);
wp_localize_script('noty', 'settingsNoty', $settingsNoty);

if(of_get_option('scrollbar') == 1){
wp_enqueue_script( 'custom_js1',   get_template_directory_uri().'/js/theme.min.js','','',true);
}
if ( !current_user_can( 'administrator' ) ) {
 wp_enqueue_script( 'vcelementsremove',  get_template_directory_uri().'/js/remove-vc-elements.js','','',true);
}
if (of_get_option('auto_slider') == 1) {
wp_enqueue_script( 'bxslider',  get_template_directory_uri().'/js/bx_slider_auto.js','','',true);
}else{
wp_enqueue_script( 'bxslider',  get_template_directory_uri().'/js/bx_slider_regular.js','','',true);
}

$user = new WP_User( get_current_user_id() );
if(in_array( 'gamer', (array) $user->roles )){
$settingsVC = array(
    'msg' => esc_html__('Please wait while we prepare your template...', 'blackfyre'),
);
wp_enqueue_script( 'vc_front_end',  get_template_directory_uri().'/js/vc_front_end.js','','',true);
wp_localize_script( 'vc_front_end', 'settingsVC', $settingsVC );
}

wp_enqueue_script( 'easing',  get_template_directory_uri().'/js/easing.js','','',true);
wp_enqueue_script( 'main',  get_template_directory_uri().'/js/main.js','','',true);
wp_enqueue_script( 'fancybox',  get_template_directory_uri().'/js/jquery.fancybox.js','','',true);
wp_enqueue_script( 'custom_js3',  get_template_directory_uri().'/js/jquery-ui.min.js','','',true);
wp_enqueue_script( 'custom_js4',  get_template_directory_uri().'/js/jquery.carouFredSel-6.2.1-packed.js','','',true);
wp_enqueue_script( 'custom_js5',   get_template_directory_uri().'/js/appear.js','','',true);
wp_enqueue_script( 'custom_js7',  get_template_directory_uri().'/js/jquery.webticker.js','','',true);
wp_enqueue_script( 'custom_js8',  get_template_directory_uri().'/js/jquery.bxslider.min.js','','',true);
wp_enqueue_script( 'custom_js9',   get_template_directory_uri().'/js/isotope.js','','',true);
wp_enqueue_script( 'custom_js10',   get_template_directory_uri().'/js/imagesloaded.min.js','','',true);
wp_enqueue_script( 'custom_js11',   get_template_directory_uri().'/js/jquery.validate.min.js','','',true);
wp_enqueue_script( 'custom_js12',   get_template_directory_uri().'/js/ps.js','','',true);

$settingsGlobal = array(
            'checking_name' => esc_html__('Checking if clan name is unique...', 'blackfyre'),
            'taken_name' => esc_html__('Clan name is taken! Please select a unique clan name!', 'blackfyre'),
            'available_name' => esc_html__('Clan name is available!', 'blackfyre')
             );

wp_enqueue_script( 'custom_js99',   get_template_directory_uri().'/js/global.js', array( 'fancybox', 'jquery' ),'',true);
wp_localize_script('custom_js99', 'settingsGlobal', $settingsGlobal);


wp_enqueue_script( 'imagescale',   get_template_directory_uri().'/js/imagescale.js','','',true);
wp_enqueue_script( 'transit',   get_template_directory_uri().'/js/transit.js','','',true);

$baseurl = get_template_directory_uri() . '/include/';
$settings = array(
    'authlocation' => $baseurl,
    'ajax'         => admin_url( 'admin-ajax.php' )
);
wp_enqueue_script( 'social_js', get_template_directory_uri() . '/js/social.js', '', '', true );
wp_localize_script( 'social_js', 'settings', $settings );

wp_enqueue_script( 'cw',   get_template_directory_uri().'/addons/clan-wars/js/matches.js','','',true);
wp_localize_script('cw',
                'wpCWL10n',
                array(
                'plugin_url' =>  get_template_directory_uri().'/addons/clan-wars',
                'addRound' => esc_html__('Add Round', 'blackfyre'),
                'excludeMap' => esc_html__('Exclude map from match', 'blackfyre'),
                'removeRound' => esc_html__('Remove round', 'blackfyre')
                )
            );
wp_enqueue_script( 'heart-love', get_template_directory_uri() . '/addons/heart/love/js/heart-love.js', 'jquery', '1.0', TRUE );
wp_localize_script( 'heart-love', 'heartLove', array('ajaxurl' => admin_url('admin-ajax.php')));
}
/*admin sctipts*/
function blackfyre_scripts_admin(){
if((!isset($_GET['ed']))){
    $user = new WP_User( get_current_user_id() );
    if(in_array( 'gamer', (array) $user->roles )){
    wp_register_script( 'vc_back_end',  get_template_directory_uri().'/js/vc_back_end.js','','',true);
    wp_enqueue_script('vc_back_end');
    }
}

wp_enqueue_script( 'custom11',   get_template_directory_uri().'/js/admin.js','','',true);
wp_enqueue_script( 'custom22',   get_template_directory_uri().'/js/jquery.elastic.source.js','','',true);
wp_enqueue_script( "mpt-featured-image",  get_template_directory_uri().'/addons/multiple-post-thumbnails/js/multi-post-thumbnails-admin.js', array( 'jquery', 'set-post-thumbnail' ));
wp_enqueue_script( "mpt-featured-image-modal",  get_template_directory_uri().'/addons/multiple-post-thumbnails/js/media-modal.js', array( 'jquery', 'media-models' ));
}

/*admin styles*/
function blackfyre_styles_admin(){
wp_enqueue_style( 'custom-style44',  get_template_directory_uri().'/css/font-awesome.css',  array(), '20130401');
wp_enqueue_style( 'custom-style55',  get_template_directory_uri().'/css/admin.css',  array(), '20130401');
wp_enqueue_style( 'custom-style66',  get_template_directory_uri().'/css/gf-style.css',  array(), '20130401');
wp_enqueue_style( 'vcfixes1',  get_template_directory_uri().'/css/vcfixes.css',  array(), '20150401');
}

/*post id for multipost thumbnails*/
function blackfyre_admin_header_scripts() {
    $post_id = get_the_ID();
    if(empty($post_id))$post_id=0;
    echo "<script>var post_id = $post_id;</script>";
}

/*add last item in footer sidebar class*/
function blackfyre_widget_first_last_classes($params) {
    global $my_widget_num; // Global a counter array
    $this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
    $arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets
    if(!$my_widget_num) {// If the counter array doesn't exist, create it
        $my_widget_num = array();
    }
    if(!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) { // Check if the current sidebar has no widgets
        return $params; // No widgets in this sidebar... bail early.
    }
    if(isset($my_widget_num[$this_id])) { // See if the counter array has an entry for this sidebar
        $my_widget_num[$this_id] ++;
    } else { // If not, create it starting with 1
        $my_widget_num[$this_id] = 1;
    }
    $class = 'class="widget-' . $my_widget_num[$this_id] . ' '; // Add a widget number class for additional styling options
    if($my_widget_num[$this_id] == 1) { // If this is the first widget
        $class .= 'first ';
    } elseif($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
        $class .= 'last ';
    }
    $params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']); // Insert our new classes into "before widget"
    return $params;
}


/*custom comments*/
function blackfyre_custom_comments($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
    $GLOBALS['comment_depth'] = $depth;
  ?>
    <li class="comment">
        <div class="wcontainer"><img alt="img" class="photo avatar" src="<?php echo blackfyre_commenter_avatar($comment->user_id); ?>" />
  <?php if ($comment->comment_approved == '0'){ ?><span class='unapproved'><?php esc_html_e("Your comment is awaiting moderation.", 'blackfyre'); ?></span> <?php } ?>
          <div class="comment-body">
             <div class="comment-author"><?php blackfyre_commenter_link() ?> <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>
             <i><small><?php comment_time('M j, Y @ G:i a'); ?></small> </i><br />
             <?php comment_text(); ?>

        </div>
        <div class="clear"></div>
        </div>
    </li>
<?php }


/*custom pings*/
function blackfyre_custom_pings($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment;
        ?>
         <div class="project-comment row">
                <div class="comment-author"><?php printf(esc_html__('By %1$s on %2$s at %3$s', 'blackfyre'),
                        get_comment_author_link(),
                        get_comment_date(),
                        get_comment_time() );
                        edit_comment_link(esc_html__('Edit', 'blackfyre'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
    <?php if ($comment->comment_approved == '0'){ ?><span class="unapproved"><?php esc_html_e('Your trackback is awaiting moderation.', 'blackfyre');?> </span><?php } ?>
            <div class="comment-content span6">
                <?php comment_text(); ?>
            </div>
            </div>
<?php
}

/*Produces an avatar image with the hCard-compliant photo class*/
function blackfyre_commenter_link() {
   $commenter = get_comment_author_link();
    if ( preg_match( '/<a[^>]* class=[^>]+>/', $commenter ) ) {
        $commenter = preg_replace( '/(<a[^>]* class=[\'"]?)/', '\\1url ' , $commenter );
    } else {
        $commenter = preg_replace( '/(<a )/', '\\1class="url "/' , $commenter );
    }
    echo ' <span class="comment-info">' . $commenter . '</span>';
}

/*Commenter avatar*/
function blackfyre_commenter_avatar($uid) {
     $url0 = get_user_meta($uid, 'profile_photo', true);
     if(!empty($url0)){
       $url1 = blackfyre_aq_resize( $url0, 100, 100, true, '', true );
       $url = $url1[0];  //resize & crop img
     }
     if(empty($url)){ $url = get_template_directory_uri().'/img/defaults/default_profile55x55.png'; }
     return $url;
}



function blackfyre_remove_matches_menu() {
    remove_menu_page( 'edit.php?post_type=matches' );
}



function blackfyre_change_clan_admin( $post_id ) {
    if(isset($_POST['post_type']))
    if ('clan' == $_POST['post_type'] ) {
        $post_arr['super_admin'] = $_POST['post_author'];
        $post_arr['admins'] = array();
        $post_arr['users'] = array();

        $meta = get_post_meta($post_id, 'clan', true);
        $post_arr['admins'] = $meta['admins'];
        $post_arr['users'] = $meta['users'];

        $post_arr['super_admin'] = $_POST['post_author'];
        update_post_meta($post_id, 'clan', $post_arr);
        $currentclans = get_user_meta($_POST['post_author'], 'clan_post_id' );
        if(!blackfyre_is_val_exists($post_id,$currentclans)){
            add_user_meta($_POST['post_author'],'clan_post_id',array($post_id, time()));
        }
  }
}

function blackfyre_select_meta(){
$args = array(
  'orderby' => 'name',
  'order' => 'ASC',
  'type' => 'post'
  );
$categories = get_categories($args);
$i=2;
$cat_ar = array();
$cat_ar[] = esc_html__('Do not use post slider', 'blackfyre');
foreach($categories as $category) {
    $cat_ar[] = $category->name;
    $i++;
   }

    return $cat_ar;
}

add_smart_meta_box('my-meta-box7', array(
'title' => esc_html__('Post category','blackfyre' ), // the title of the meta box
'pages' => array('slider'),  // post types on which you want the metabox to appear
'context' => 'normal', // meta box context (see above)
'priority' => 'high', // meta box priority (see above)
'fields' => array( // array describing our fields
array(
'name' => esc_html__('Select post category for the slider.','blackfyre' ),
'id' => 'my-awesome-field7',
'type' => 'select',
'default' => '1-val',
'options' => blackfyre_select_meta()
),)));

add_smart_meta_box('my-meta-box8', array(
'title' => esc_html__('Lock match','blackfyre' ), // the title of the meta box
'pages' => array('wp-clanwars-matches'),  // post types on which you want the metabox to appear
'context' => 'normal', // meta box context (see above)
'priority' => 'high', // meta box priority (see above)
'fields' => array( // array describing our fields
array(
'name' => esc_html__('Lock this match.','blackfyre' ),
'id' => 'lock_match',
'type' => 'select',
'default' => '1-val',
'options' => esc_html__('Lock', 'blackfyre')
),)));

add_smart_meta_box('my-meta-box9', array(
'title' => esc_html__('Slider shortcode (works with "Homepage" template only)','blackfyre' ), // the title of the meta box
'pages' => array('page'),  // post types on which you want the metabox to appear
'context' => 'normal', // meta box context (see above)
'priority' => 'high', // meta box priority (see above)
'fields' => array( // array describing our fields
array(
'name' => esc_html__('Paste your slider shortcode here.','blackfyre' ),
'id' => 'slider_short',
'type' => 'textarea',
'default' => ''
),)));

/*prevent headers alread sent*/
function blackfyre_do_output_buffer() {
        ob_start();
}




/*remove slider from home*/
function blackfyre_remove_slider_from_home( $content = null ){
    global $post;
    if( is_page_template('tmp-home.php') ){
        $pattern = get_shortcode_regex();
        preg_match('/'.$pattern.'/s', $content, $matches);
        if ( isset($matches[2]) && is_array($matches) && $matches[2] == 'layerslider') {
            //shortcode is being used
            $content = str_replace( $matches['0'], '', $content );
        }
    }
    return $content;
}



/*get tag name*/
function blackfyre_GetTagName($meta){
    if (is_string($meta) || (is_numeric($meta) && !is_double($meta))
            || is_int($meta)){
                if (is_numeric($meta))
                    $meta = (int)$meta;
                        if (is_int($meta))
                            $TagSlug = get_term_by('id', $meta, 'post_tag');
                        else
                            $TagSlug = get_term_by('slug', $meta, 'post_tag');
                    return $TagSlug->name;
            }
}

/*image resize*/
function blackfyre_aq_resize( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = false ) {

    // Validate inputs.
    if ( ! $url || ( ! $width && ! $height ) ) return false;

    // Caipt'n, ready to hook.
    if ( true === $upscale ) add_filter( 'image_resize_dimensions', 'blackfyre_aq_upscale', 10, 6 );

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
    if ( false === strpos( $url, $upload_url ) ) return false;

    // Define path of image.
    $rel_path = str_replace( $upload_url, '', $url );
    $img_path = $upload_dir . $rel_path;

    // Check if img path exists, and is an image indeed.
    if ( ! file_exists( $img_path ) or ! getimagesize( $img_path ) ) return false;

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
            return false;
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
                    return false;

                $resized_file = $editor->save();

                if ( ! is_wp_error( $resized_file ) ) {
                    $resized_rel_path = str_replace( $upload_dir, '', $resized_file['path'] );
                    $img_url = $upload_url . $resized_rel_path;
                } else {
                    return false;
                }

            } else {

                $resized_img_path = wp_get_image_editor( $img_path, $width, $height, $crop ); // Fallback foo.
                if ( ! is_wp_error( $resized_img_path ) ) {
                    $resized_rel_path = str_replace( $upload_dir, '', $resized_img_path );
                    $img_url = $upload_url . $resized_rel_path;
                } else {
                    return false;
                }

            }

        }
    }

    // Okay, leave the ship.
    if ( true === $upscale ) remove_filter( 'image_resize_dimensions', 'blackfyre_aq_upscale' );

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


function blackfyre_aq_upscale( $default, $orig_w, $orig_h, $dest_w, $dest_h, $crop ) {
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

//add video input field
add_smart_meta_box('my-meta-box77', array(
'title' => esc_html__('Video url', 'blackfyre'), // the title of the meta box
'pages' => array('post'),
'context' => 'normal', // meta box context (see above)
'priority' => 'high', // meta box priority (see above)
'fields' => array( // array describing our fields
array(
'name' => esc_html__('Put your embed video URL here', 'blackfyre'),
'id' => 'my-awesome-field77',
'type' => 'textarea',
),)));


//woocommerce

function blackfyre_woocommerce_header_add_to_cart_fragment( $fragments ) {
    global $woocommerce;

    ob_start(); ?>
    <a class="cart-contents" href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>"><div class="cart-icon-wrap"><i class="fa fa-shopping-cart"></i> <div class="cart-wrap"><span><?php echo esc_attr($woocommerce->cart->cart_contents_count); ?> </span></div> </div></a>
    <?php

    $fragments['a.cart-contents'] = ob_get_clean();

    return $fragments;
}

//ajax comments
function blackfyre_ajaxify_comments($comment_ID, $comment_status){
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
        switch($comment_status){
            case "0":
            wp_notify_moderator($comment_ID);
            case "1": //Approved comment
            esc_html_e("success","blackfyre");
            $commentdata =& get_comment($comment_ID, ARRAY_A);
            $post =& get_post($commentdata['comment_post_ID']);
            wp_notify_postauthor($comment_ID, $commentdata['comment_type']);
            break;
            default:
            esc_html_e("error",'blackfyre');
        }
    exit;
    }
}

//multiple featured images
  if (class_exists('BlackfyreMultiPostThumbnails')) {

                 new BlackfyreMultiPostThumbnails(
                    array(
                        'label' => 'Header Image',
                        'id' => 'header-image',
                        'post_type' => 'page'
                    )
                );

                 new BlackfyreMultiPostThumbnails(
                    array(
                        'label' => 'Header Image',
                        'id' => 'header-image-post',
                        'post_type' => 'post'
                    )
                );
            }
function blackfyre_change_mce_options( $init ) {
    // Command separated string of extended elements
    $ext = 'pre[id|name|class|style]';

    // Add to extended_valid_elements if it alreay exists
    if ( isset( $init['extended_valid_elements'] ) ) {
        $init['extended_valid_elements'] .= ',' . $ext;
    } else {
        $init['extended_valid_elements'] = $ext;
    }

    // Super important: return $init!
    return $init;
}


function blackfyre_get_category_id($cat_name){
    $term = get_term_by('name', $cat_name, 'category');
    return $term->term_id;
}

add_shortcode("blackfyre_slider", "blackfyre_simple_display_slider");
function blackfyre_simple_display_slider($attr,$content) {
    global $post;
    extract(shortcode_atts(array(
            'id' => ''
            ), $attr));

     echo '
        <div class="slider-wrapper">
        <div class="slider-left-wall"></div>
        <div class="slider-right-wall"></div>
        <div class="net"></div>
        <div class="slider-text-wrapper">
            <img alt="" class="slider-pick" src="'.esc_url(get_template_directory_uri()).'/img/pick.png" />
            <div class="slider_text slantybox">
            </div>
            <div class="bx-controls-direction">
                <a class=" bx-next-out"></a>
            </div>
        </div>
        <div class="slider_text_src" style="display: none;"><ul>';

    if(get_post_meta($id, '_smartmeta_my-awesome-field7', true) == 'Do not use post slider'){

        if( get_field('field_53f5d4c019b0c', $id) )
    {

        $idc = 1;
        while( the_repeater_field('field_53f5d4c019b0c', $id) )
        {
            $img_desc = get_sub_field('image_description');
            echo '<li data-id="'.esc_attr($idc).'">'.html_entity_decode($img_desc).'</li>';
            $idc ++;
        }

    }

    }else{

        $category_ID = blackfyre_get_category_id(get_post_meta($id, '_smartmeta_my-awesome-field7', true));
        $the_query = new WP_Query( 'showposts=5&cat='.$category_ID );
        $idc = 1;
        if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
            $num_comments = get_comments_number(); // get_comments_number returns only a numeric value

            if ( comments_open() ) {
                if ( $num_comments == 0 ) {
                    $comments = esc_html__('No Comments', 'blackfyre');
                } elseif ( $num_comments > 1 ) {
                    $comments = $num_comments . esc_html__(' Comments', 'blackfyre');
                } else {
                    $comments = esc_html__('1 Comment', 'blackfyre');
                }
                $write_comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
            } else {
                $write_comments =  esc_html__('Comments are off for this post.', 'blackfyre');
            }
             echo '<li data-id="'.$idc.'"><a href ="'.esc_url(get_the_permalink()).'">'.mb_substr(get_the_title(), 0, 55).'...</a><div class="slider_com_wrap"><i class="fa fa-comments"></i>'.$write_comments.'</div></li>';
             $idc ++;
        endwhile; endif;
    }
    echo '</ul></div><ul class="bxslider">';

    if(get_post_meta($id, '_smartmeta_my-awesome-field7', true) == 'Do not use post slider'){

    if( get_field('field_53f5d4c019b0c', $id) )
    {

        $idc = 1;
        while( the_repeater_field('field_53f5d4c019b0c', $id) )
        {
            $img_url = get_sub_field('slider_image');
            $image = blackfyre_aq_resize( $img_url['url'], 585, 340, true, '', true );
            echo '<li data-id="'.$idc.'"><a href="'.esc_url(get_the_permalink()).'"><img alt="img" src="'.esc_url($image[0]).'" /></a></li>';
            $idc ++;
        }

    }

    }else{

        $category_ID = blackfyre_get_category_id(get_post_meta($id, '_smartmeta_my-awesome-field7', true));
        $the_query = new WP_Query( 'showposts=5&cat='.$category_ID );
        $idc = 1;
        if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
             $thumb = get_post_thumbnail_id($post->ID);
             $img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
             $image = blackfyre_aq_resize( $img_url, 585, 340, true, '', true ); //resize & crop img
             echo '<li data-id="'.$idc.'"><a href="'.esc_url(get_the_permalink()).'"><img alt="img" src="'.esc_url($image[0]).'" /></a></li>';
             $idc ++;
        endwhile; endif;
    }
   echo '</ul>';
   echo '<div class="next_slide_text"><i class="fa fa-bolt"></i><strong>'.esc_html__("Next:", "blackfyre").'</strong><div class="next_slide_text_inner"> </div></div></div>';



}





function blackfyre_set_custom_edit_slider_columns($columns) {
    return $columns
    + array('slider_shortcode' => esc_html__('Shortcode', 'blackfyre'));
}

function blackfyre_custom_slider_column($column, $post_id) {
    $slider_meta = get_post_meta($post_id, "_blackfyre_slider_meta", true);
    $slider_meta = ($slider_meta != '') ? json_decode($slider_meta) : array();

    switch ($column){
        case 'slider_shortcode':
            echo "[blackfyre_slider id=$post_id]";
        break;
    }
}

function blackfyre_save_slider_info($post_id) {
    if(isset($_POST['blackfyre_slider_box_nonce']) && $_POST['post_type'])
    {
        if (!wp_verify_nonce($_POST['blackfyre_slider_box_nonce'], basename(__FILE__))){
            return $post_id;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
            return $post_id;
        }
        if ('slider' == $_POST['post_type'] && current_user_can('edit_post', $post_id)){
            $gallery_images = (isset($_POST['gallery_img']) ? $_POST['gallery_img'] : '');
            $gallery_images = strip_tags(json_encode($gallery_images));
            update_post_meta($post_id, "_simple_gallery_images", $gallery_images);
        }else{
            return $post_id;
        }
    }

}




/*****social login*****/
function blackfyre_social_createoptions() {
    $siteurl = get_site_url();
    $holdtheme = get_template_directory();
    $thetheme = explode("/", $holdtheme);
    $nametheme = $thetheme[count($thetheme) -1];
    if (substr($siteurl, -1) != "/") {
        $siteurl .= "/";
    }  //add trailing slash
        if ( !empty( $_SERVER['HTTPS'] ) ) {
            $siteurl = str_replace("http://", "https://", $siteurl);
        }

    $baseurl = content_url().'/themes/'.$nametheme.'/include/';
    if ( !empty( $_SERVER['HTTPS'] ) ) {
            $baseurl = str_replace("http://", "https://", $baseurl);
        }
    $redirecturl = content_url().'/themes/'.$nametheme.'/include/handler/index.php';

    return
      array(
        "base_url" => $baseurl,
        "redirect_url" => $redirecturl,
        "redirect_uri" => $redirecturl,
        "providers" => array (
            // openid providers
            "OpenID" => array (
                "enabled" => true
            ),
            "Facebook" => array (
                "enabled" => true,
                "keys"    => array ( "id" => of_get_option('facebook_app'), "secret" => of_get_option('facebook_secret') )
            ),

            "Twitter" => array (
                "enabled" => true,
                "keys"    => array ( "key" =>  of_get_option('twitter_app'), "secret" =>  of_get_option('twitter_secret'))
            ),

           "Google" => array (
                "enabled" => true,
                 "keys"    => array ( "id" =>  of_get_option('google_app'), "secret" =>  of_get_option('google_secret'))
            ),

            "TwitchTV" => array (
                "enabled" => true,
                 "keys"    => array ( "id" =>  of_get_option('twitch_client_id'), "secret" =>  of_get_option('twitch_secret'))
            ),
            "Steam" => array (
                "enabled" => true,
                 "keys"    => array ( "key" =>  of_get_option('steam_app'))
            ),
        ),


        // if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
        "debug_mode" => false,

        "debug_file" => ""
    );
}


/*handle sessions in wordpress*/
function blackfyre_myStartSession() {
    global $wpdb; // hook the wp db
    global $usermeta;
    if(!session_id()) { //if there's no session, start it
       @session_start();
    }
    $wordpress_user = wp_get_current_user();

    if (!((!isset ($wordpress_user)) OR ($wordpress_user->ID == 0))) {
        $usermeta = get_user_meta($wordpress_user->ID);
    }


}



/*ends session*/
function blackfyre_myEndSession() {
    session_destroy ();
}

//This function allows multiple same emails, to allow social accounts to be unlinked
function blackfyre_skip_email_exist($user_email){
    define( 'WP_IMPORTING', 'BLACKFYRE_SKIP_EMAIL_EXIST' );
    return $user_email;
}

function blackfyre_be_gravatar_filter($avatar, $id_or_email, $size = 150, $default = true, $alt = false, $class = false) {

    if($class['class']) $class = implode(' ',$class['class']);
    if (is_int($id_or_email)) {
        $user_data = get_user_meta( $id_or_email, 'thechamp_large_avatar', true );
        if(isset($user_data) && !empty($user_data)){
            $custom_avatar = $user_data;

        }else{
            $custom_avatar = get_the_author_meta('profile_photo', $id_or_email);

        }
    } else {
        $custom_avatar = get_the_author_meta('profile_photo');
    }

    if ($custom_avatar)
        $return = '<img src="'.esc_url($custom_avatar).'" width="'.esc_attr($size).'" height="'.esc_attr($size).'" alt="'.esc_attr($alt).'" class="'.esc_attr($class).'" />';
    elseif (!empty(get_avatar_url($id_or_email)))
        $return = '<img src="'.get_avatar_url($id_or_email).'" width="'.esc_attr($size).'" height="'.esc_attr($size).'" alt="'.esc_attr($alt).'" class="'.esc_attr($class).'" />';
    elseif ($avatar)
        $return = '<img src="'.get_template_directory_uri().'/img/defaults/default-profile.jpg" width="'.esc_attr($size).'" height="'.esc_attr($size).'" alt="'.esc_attr($alt).'" class="'.esc_attr($class).'" />';


    return $return;
}

function blackfyre_be_gravatar_filter_admin($avatar, $id_or_email, $size = 150, $default = true, $alt = false) {


    if (is_int($id_or_email)) {
        $custom_avatar = get_the_author_meta('profile_photo', $id_or_email);
    } else {
        $custom_avatar = get_the_author_meta('profile_photo');
    }

    if ($custom_avatar)
        $return = $custom_avatar;
    elseif ($avatar)
        $return = get_template_directory_uri().'/img/defaults/default-profile.jpg';


    return $return;
}


//register custom pages, prep function
function blackfyre_get_ID_by_slug($page_slug) {
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}


/***** add country option to profile *****/
add_action('after_setup_theme', 'blackfyre_country');
function blackfyre_country() {
      include_once(TEMPLATEPATH.'/themeOptions/admin/country/usercountry.php');
}

/** add country field to registration page **/
function blackfyre_registration_country_list() {
    global $wpdb;
    $table = $wpdb->prefix."user_countries";
    $countries = $wpdb->get_results( "SELECT * FROM $table ORDER BY `name`");
    return $countries;
}

/*remove profile tab from subnav*/
function blackfyre_remove_profile_subnav() {
    if ( is_plugin_active('buddypress/bp-loader.php') && function_exists( 'bp_core_remove_subnav_item' ) ) {
        global $bp;
        if ( $bp->current_component == $bp->settings->slug ) {
            bp_core_remove_subnav_item( $bp->settings->slug, 'profile' );
        }
    }
}


/*ajax call for user profile picture*/
function blackfyre_update_user_profile_pic_callback() {
    $url = $_POST['file'];
    if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
        die('Not a valid URL');
    }
    update_user_meta(bp_displayed_user_id(), 'profile_photo', $url);
    esc_html_e("Profile picture updated successfully!", "blackfyre");
    wp_die(); // this is required to terminate immediately and return a proper response
}

/*ajax call for clan banner picture*/
function blackfyre_update_user_clan_bg_callback() {
     $url = $_POST['file'];
    $p_id = $_POST['idp'];

     $p_id = filter_var($p_id, FILTER_SANITIZE_NUMBER_INT);
    if (is_numeric($p_id)) {
      if (current_user_can('edit_post', $p_id)) {
        update_post_meta($p_id, 'clan_bg', $url);
        esc_html_e("Clan banner updated successfully!", "blackfyre");

      }
    }

    wp_die(); // this is required to terminate immediately and return a proper response
}

/*ajax call for clan page background*/
function blackfyre_update_page_bg_callback() {
    $url = $_POST['file'];
    $p_id = $_POST['idp'];
    $p_id = filter_var($p_id, FILTER_SANITIZE_NUMBER_INT);

    if (is_numeric($p_id)) {
      if (current_user_can('edit_post', $p_id)) {
         update_post_meta($p_id, 'clan_page_bg', $url);
         esc_html_e("Clan page background updated successfully!", "blackfyre");
    ?>
    <script>
        var bck_btn =  jQuery('#change_page_bg_pic');
        bck_btn.after(' <a class="ajaxdeletebck" href="javascript:void(0);" data-pid="<?php echo esc_attr($p_id); ?>" ><i data-original-title="<?php esc_html_e("Delete Background", "blackfyre");?>" data-toggle="tooltip" data-placement="right" class="fa fa-times"></i></a>');
    </script>
    <?php
      }
    }
 wp_die();
}


/*ajax call for user profile picture*/
function blackfyre_update_user_profile_bg_callback() {
    $url = $_POST['file'];
    if (filter_var($url, FILTER_SANITIZE_NUMBER_INT) === FALSE) {
          die('Not a valid ID');
    }
    update_user_meta(bp_displayed_user_id(), 'profile_bg', $url);
    esc_html_e("Profile background updated successfully!", "blackfyre");
    wp_die(); // this is required to terminate immediately and return a proper response
}


/*ajax call for user clan picture*/
function blackfyre_update_clan_pic_callback() {
     $url = $_POST['file'];
    $p_id = $_POST['idp'];
    $p_id = filter_var($p_id, FILTER_SANITIZE_NUMBER_INT);

    if (is_numeric($p_id)) {
      if (current_user_can('edit_post', $p_id)) {
          update_post_meta($p_id, 'clan_photo', $url);
          esc_html_e("Clan photo updated successfully!", "blackfyre");
      }
    }
    wp_die(); // this is required to terminate immediately and return a proper response
}

/*Add friend button classes and text*/
function blackfyre_add_friend_link_text($button) {
    $fricon_remove = '<i class="fa fa-times" data-original-title="'.esc_html__("Remove friend", "blackfyre").'" data-toggle="tooltip"></i>';
    $fricon_add = '<i class="fa fa-user"></i>';
    $fricon_cancel = '<i class="fa fa-times" data-original-title="'.esc_html__("Cancel request!", "blackfyre").'" data-toggle="tooltip"></i>';

    switch ( $button['id'] ) {
        case 'pending' :
            $button['link_text'] = $fricon_cancel.esc_html__(' Cancel request!', 'blackfyre');
            $button['link_title'] = 'Cancel friend request';
            $button['link_class'] .= ' add-friend';
        break;

        case 'is_friend' :
            $button['link_text'] = $fricon_remove.esc_html__(' Remove friend!', 'blackfyre');;
            $button['link_class'] .= ' add-friend';
        break;

        default:
            $button['link_text'] = $fricon_add.esc_html__(' Add as a friend!', 'blackfyre');
            $button['link_title'] = 'Add as a friend';
            $button['link_class'] .= ' add-friend';
    }
    return $button;
}


/*add font awesome into buddypress navigation*/
function blackfyre_mb_profile_menu_tabs(){
global $bp;
$profile_icon = '<i class="fa fa-user"></i>';
$notifications_icon = '<i class="fa fa-flag"></i>';
$messages_icon = '<i class="fa fa-comments-o"></i>';
$friends_icon = '<i class="fa fa-users"></i>';
$settings_icon = '<i class="fa fa-cog"></i>';
$activity_icon = '<i class="fa fa-bolt"></i>';
$forums_icon = '<i class="fa fa-forumbee"></i>';
$groups_icon = '<i class="fa fa-users"></i>';


bp_core_new_nav_item(
array(
    'name' => $profile_icon.esc_html__(' profile', 'blackfyre'),
    'slug' => $bp->profile->slug,
    'position' => 10,
));

if ( bp_is_active( 'activity' ) )
bp_core_new_nav_item(
array(
    'name' => $activity_icon.esc_html__(' activity', 'blackfyre'),
    'slug' => $bp->activity->slug,
    'position' => 20,
));

if ( bp_is_active( 'notifications' ) && bp_is_my_profile() )
bp_core_new_nav_item(
array(
    'name' => $notifications_icon.esc_html__(' notifications', 'blackfyre'),
    'slug' => $bp->notifications->slug,
    'position' => 30,
));

if ( bp_is_active( 'messages' ) && bp_is_my_profile() )
bp_core_new_nav_item(
array(
    'name' => $messages_icon.esc_html__(' messages', 'blackfyre'),
    'slug' => $bp->messages->slug,
    'position' => 40,
));

if ( bp_is_active( 'friends' ) )
bp_core_new_nav_item(
array(
    'name' => $friends_icon.esc_html__(' friends', 'blackfyre'),
    'slug' => $bp->friends->slug,
    'position' => 50,
));

if ( bp_is_active( 'settings' ) && bp_is_my_profile() )
bp_core_new_nav_item(
array(
    'name' => $settings_icon.esc_html__(' settings', 'blackfyre'),
    'slug' => $bp->settings->slug,
    'position' => 80,
));

if ( bp_is_active( 'groups' ) )
bp_core_new_nav_item(
array(
    'name' => $groups_icon.esc_html__(' groups', 'blackfyre'),
    'slug' => $bp->groups->slug,
    'position' => 60,
));

}


/*create redirection for new post*/
function blackfyre_redirect(){
    $user_id = get_current_user_id();
    $post_data = array(
    'post_title'    => 'Clan name',
    'post_type'     => 'clan',
    'post_content'  => '',
    'post_status'   => 'draft',
    'post_author'   => $user_id
);

// insert the post into the database
$post_id = wp_insert_post( $post_data );

//$uid = array();
//$pid =  array();
//$uid['id'] = $user_id;
//$uid['status'] = 1;
//$pid[] = $post_id;
//add_post_meta($post_id, 'admin', $uid);
//add_user_meta($user_id, 'clan', $pid);

#--------- 1. varijanta ----------
$post_arr['super_admin'] = $user_id;
$post_arr['admins'] = array();
$arr['active'] = array();
$arr['pending'] = array();
$post_arr['users'] = $arr;
add_post_meta($post_id, 'clan', $post_arr);
add_user_meta($user_id, 'clan_post_id', array($post_id, time()));
#-------------------------------------------

echo json_encode($post_id);
exit();
}


/*on clan delete update metas*/
function blackfyre_onclan_delete($post_id) {
    global $wpClanWars;
    $post = get_post($post_id);

    if ($post->post_type == 'clan') {

         $users = get_users(array(
    'meta_key' => 'clan_post_id',
    'meta_query' => array(
            'relation' => 'OR',
            array(
                'key'     => 'clan_post_id',
                'value'   =>  ':'.$post_id.';',
                'compare' => 'LIKE',
            ),
            /*backversion compatibility*/
            array(
                'key'     => 'clan_post_id',
                'value'   =>  $post_id
            )
        )
        )
    );
        if(!empty($users)){
            foreach ($users as $user) {

            $klanovi = get_user_meta($user->ID, 'clan_post_id');
                if(empty($klanovi))$klanovi = array();

                if(blackfyre_is_val_exists($post_id, $klanovi)){
                    $index = array_search($post_id, array_column($klanovi, 0));
          if ($index !== false) {
            delete_user_meta($user->ID, 'clan_post_id', $klanovi[$index]);
          }
                }
            /*backversion compatibility*/
             delete_user_meta($user->ID, 'clan_post_id', $post_id);

            }
        }
        $id = blackfyre_return_team_id_by_post_id($post_id);
        $wpClanWars->delete_team($id[0]->id);
       }
}

/*on clan publish*/
function blackfyre_onclan_publish($post_id) {
    global $wpClanWars;
    $id = blackfyre_return_team_id_by_post_id($post_id);
    $post = get_post($post_id);
    if ($post->post_type == 'clan') {
    $imgurl =  get_post_meta( $post_id, 'clan_photo', true );
    $arr = array(
            'title' => $post->post_title,
            'logo' => blackfyre_get_attachment_id($imgurl),
            'post_id' => $post_id
    );
          if(empty($id[0]->id)){$wpClanWars->add_team($arr);}else{ $wpClanWars->update_team($id[0]->id, $arr);}
       }
}

/*MATCHES FUNCTIONS*/
function blackfyre_return_match_locked($post_id){
     global $wpdb;
     $matches = $wpdb->prefix."cw_matches";
     $rslt = $wpdb->get_results( $wpdb->prepare("SELECT locked FROM $matches where `post_id` = %s",$post_id ));
     return $rslt[0];
}
function blackfyre_return_match_status($post_id){
     global $wpdb;
     $matches = $wpdb->prefix."cw_matches";
     $rslt = $wpdb->get_results($wpdb->prepare("SELECT status FROM $matches where `post_id` = %s",$post_id));
     if(!isset($rslt[0]))$rslt[0]='';
     return $rslt[0];
}
function blackfyre_return_all_clan_matches($clan_id){
     global $wpdb;
     $matches = $wpdb->prefix."cw_matches";
     $rslt = $wpdb->get_results($wpdb->prepare("SELECT * FROM $matches where (`team1` = %s or `team2` = %s) and (`status` = 'active' or `status` = 'submitted1' or `status` = 'submitted2' or `status` = 'deleted1' or `status` = 'deleted2' or `status` = 'done') ORDER BY `date` DESC",$clan_id,$clan_id));
     return $rslt;
}

function blackfyre_return_match_id_by_post_id($post_id){
     global $wpdb;
     $matches = $wpdb->prefix."cw_matches";
     $rslt = $wpdb->get_results($wpdb->prepare("SELECT `id` FROM $matches where `post_id` = %s",$post_id));
     return $rslt;
}

function blackfyre_return_match_reported_by_match_id($match_id){
     global $wpdb;
     $matches = $wpdb->prefix."cw_matches";
     $rslt = $wpdb->get_results($wpdb->prepare("SELECT `reported_reason` FROM $matches where `id` = %s", $match_id));
     return $rslt[0];
}

function blackfyre_return_post_id_by_match_id($match_id){
     global $wpdb;
     $teams = $wpdb->prefix."cw_teams";
     $rslt = $wpdb->get_results($wpdb->prepare("SELECT `post_id` FROM $teams where `id` = %s", $match_id));
     return $rslt[0];
}

function blackfyre_return_post_id_by_match_id_from_matches($match_id){
     global $wpdb;
     $matches = $wpdb->prefix."cw_matches";
     $rslt = $wpdb->get_results($wpdb->prepare("SELECT `post_id` FROM $matches where `id` = %s", $match_id));
     return $rslt[0]->post_id;
}

function blackfyre_return_match_score($match_id){
    global $wpdb;
    $rounds = $wpdb->prefix."cw_rounds";
    $teams = $wpdb->prefix."cw_teams";
    $matches = $wpdb->prefix."cw_matches";
    $games = $wpdb->prefix."cw_games";
    $rslt = $wpdb->get_results($wpdb->prepare(
                    "SELECT t1.id,
                            (SELECT SUM(sumt1.tickets1) FROM $rounds AS sumt1 WHERE sumt1.match_id = t1.id) AS team1_tickets,
                            (SELECT SUM(sumt2.tickets2) FROM $rounds AS sumt2 WHERE sumt2.match_id = t1.id) AS team2_tickets

                     FROM $matches AS t1
                     LEFT JOIN $games AS t2 ON t1.game_id=t2.id
                     LEFT JOIN $teams AS tt1 ON t1.team1=tt1.id
                     LEFT JOIN $teams AS tt2 ON t1.team2=tt2.id where t1.id = %s", $match_id));
     return $rslt;
}



/*CHALLENGES FUNCTIONS*/
function blackfyre_return_all_clan_challenges($clan_id){
     global $wpdb;
     $matches = $wpdb->prefix."cw_matches";
     $rslt = $wpdb->get_results($wpdb->prepare("SELECT * FROM $matches where (`team1` = %s or `team2` = %s) and `status` = 'pending' ORDER BY `date` ASC", $clan_id, $clan_id));
     return $rslt;
}

function blackfyre_return_challenge_matches_team2($clan_id){
     global $wpdb;
     $matches = $wpdb->prefix."cw_matches";
     $rslt = $wpdb->get_results($wpdb->prepare("SELECT * FROM $matches where `team2` = %s and `status` = 'pending' ORDER BY `date` ASC", $clan_id));
     return $rslt;
}

function blackfyre_return_challenge_matches_team1($clan_id){
     global $wpdb;
     $matches = $wpdb->prefix."cw_matches";
     $rslt = $wpdb->get_results($wpdb->prepare("SELECT * FROM $matches where `team1` = %s and `status` = 'pending' ORDER BY `date` ASC",$clan_id ));
     return $rslt;
}

/*EDITS*/
function blackfyre_return_all_clan_edits($clan_id){
     global $wpdb;
     $matches = $wpdb->prefix."cw_matches";
     $rslt = $wpdb->get_results($wpdb->prepare("SELECT * FROM $matches where (`team1` = %s or   `team2` = %s) and ( `status` = 'edited2' or `status` = 'edited1') ORDER BY `date` ASC", $clan_id, $clan_id));
     return $rslt;
}

/*DELETES*/
function blackfyre_return_all_clan_deletes($clan_id){
     global $wpdb;
     $matches = $wpdb->prefix."cw_matches";
     $rslt = $wpdb->get_results($wpdb->prepare("SELECT * FROM $matches where (`team1` = %s or `team2` = %s ) and (  `status` = 'deleted_req_team2' or `status` = 'deleted_req_team1') ORDER BY `date` ASC", $clan_id, $clan_id));
     return $rslt;
}

/*CLAN FUNCTIONS*/

function blackfyre_add_user_to_clan($user_id, $post_id){
    $post_arr = get_post_meta( $post_id, 'clan', true );
    $usr_meta = get_user_meta( $user_id, 'clan_post_id');

    $is_member =  (blackfyre_is_val_exists($post_id,$usr_meta)) ? true : false;
    if(!$is_member) {
        $post_arr['admins'][] = $user_id;
        update_post_meta($post_id, 'clan', $post_arr);
        update_user_meta($user_id, 'clan_post_id', array($post_id, time()));
    }
}

function blackfyre_clan_members($post_id=false, $currentPage=1){
    global $current_user;

    $membersa = array();
    $membersu = array();
    $members = array();
    $post_meta_arr = get_post_meta( $post_id, 'clan', true );


    $su_admin = ( isset( $post_meta_arr['super_admin'] ) && $post_meta_arr['super_admin'] == $current_user->ID ) ? true : false;
    if ( $su_admin || ( ( isset( $post_meta_arr['admins'] ) && is_array( $post_meta_arr['admins'] ) && in_array( $current_user->ID, $post_meta_arr['admins'] ) ) || ( isset( $post_meta_arr['admins'] ) && $current_user->ID == $post_meta_arr['admins'] ) ) ) {
        if(!isset($post_meta_arr['users']['pending']))  $post_meta_arr['users']['pending'] = array();
        if ( is_array( $post_meta_arr['users']['pending'] ) ) {
            foreach( $post_meta_arr['users']['pending'] as $item ) {
                $membersu[] = $item;
            }
        } elseif ( ! empty( $post_meta_arr['users']['pending'] ) ) {
            $membersu[] = $post_meta_arr['users']['pending'];
        }
    }

    if ( isset( $post_meta_arr['super_admin'] ) ) {
        $membersa[0] = $post_meta_arr['super_admin'];
    }

    if ( isset( $post_meta_arr['admins'] ) ) {
        if ( is_array( $post_meta_arr['admins'] ) ) {
            foreach( $post_meta_arr['admins'] as $item ){
                $membersu[] = $item;
            }
        } elseif ( ! empty( $post_meta_arr['admins'] ) ) {
            $membersu[] = $post_meta_arr['admins'];
        }
    }

    if ( isset( $post_meta_arr['users']['active'] ) ) {
        if ( is_array( $post_meta_arr['users']['active'] ) ) {
            foreach( $post_meta_arr['users']['active'] as $item ) {
                $membersu[] = $item;
            }
        } elseif ( ! empty( $post_meta_arr['users']['active'] ) ) {
            $membersu[] = $post_meta_arr['users']['active'];
        }
    }

    $members = array_merge($membersa,$membersu);
    end($members);
    $last_key = key($members);
    reset($members);

    $members_count = count($members);
    $members_per_page = 50;

    if ($members_count==0) return false;

    include "addons/pagination/pagination.class.php";
    $p = new blackfyre_pagination;
    $p->items($members_count);
    $p->limit($members_per_page);
    $p->parameterName('members_list_page');
    $p->currentPage($currentPage);
    $p->nextLabel(esc_html__('Next','blackfyre'));
    $p->prevLabel(esc_html__('Previous','blackfyre'));
    ?>

    <?php if(blackfyre_is_admin($post_id,$current_user->id)){ ?>
    <ul id="members-list-fn" class="item-list">
    <?php }else{ ?>
     <ul id="members-list-fn" class="item-list third_user" >
    <?php } ?>
    <?php
        for ($x=0; $x<$members_per_page; $x++) {
            $position = (int) ($currentPage-1) * $members_per_page + $x;

            $member = get_userdata($members[$position]);

            blackfyre_clan_members_links($member,$post_meta_arr, $post_id, $su_admin);

            if ( $position >= $last_key ) break;
        }
    ?>


    </ul>
 <div class="clear"></div>
    <?php  if ($members_count > $members_per_page) : ?>
    <div id="pag-bottom" class="pagination">
            <?php $p->show(); ?>
    </div>
   <?php  endif ; ?>
<?php }

function blackfyre_clan_members_links($member, $post_meta_arr, $post_id, $su_admin){ global $current_user; ?>

    <?php if ( isset( $post_meta_arr['users']['pending'] ) && ( ( is_array( $post_meta_arr['users']['pending'] ) && in_array( $member->ID, $post_meta_arr['users']['pending'] ) ) || $member->ID == $post_meta_arr['users']['pending'] ) ) : ?>
        <li class="pending <?php echo esc_attr($member->ID); ?>">
    <?php else : ?>
           <?php if($member->ID == $current_user->ID || ( isset( $post_meta_arr['super_admin'] ) && $member->ID == $post_meta_arr['super_admin'] ) ){ ?>

           <li class="<?php echo esc_attr($member->ID); ?> third_user">

            <?php }else{ ?>
           <li class="<?php echo esc_attr($member->ID); ?>">
            <?php } ?>
    <?php endif;?>

        <?php    $user_data = get_user_meta( $member->ID, 'thechamp_large_avatar', true );
                    if(isset($user_data) && !empty($user_data)){
                        $url = $user_data;

                    }else{
                        $url = get_the_author_meta('profile_photo', $id_or_email);
                         $url = blackfyre_aq_resize( $url, 55, 55, true, true, true );

                    }
                 if(empty($url)){ $url = get_template_directory_uri().'/img/defaults/default_profile55x55.png'; }

         ?>
        <div class="member-list-wrapper">
            <div class="item-avatar">
               <a href="<?php echo esc_url(bp_core_get_user_domain( $member->ID )); ?>">
                <img alt="img" src="<?php echo esc_url($url); ?>" class="avatar">
               </a>
            </div>

            <div class="item">
                <div class="item-title">
                    <a href="<?php echo esc_attr(bp_core_get_user_domain( $member->ID )); ?>"><?php echo esc_attr($member->display_name); ?></a>
                    <div class="item-meta"><span class="activity"><?php esc_html_e("Joined: ","blackfyre"); ?><?php echo floor((strtotime("now")-strtotime($member->user_registered))/3600/24)?><?php esc_html_e(" days ago","blackfyre"); ?></span></div>
                </div>
            </div>
            <?php if(!is_array($post_meta_arr['admins'])) $post_meta_arr['admins']= array(); ?>
            <?php if(in_array($member->ID, $post_meta_arr['admins']) or ($member->ID == $post_meta_arr['super_admin'])):?>
                <div class="is-admin" data-original-title="Admin" data-toggle="tooltip" ><i class="fa-star fa"></i></div>
            <?php endif;?>
            <?php if(isset($post_meta_arr['users']['pending'])){ ?>
                <?php if(in_array($member->ID, $post_meta_arr['users']['pending'])):?>
                    <div class="pending-text"><?php esc_html_e("Pending","blackfyre"); ?></div>
                <?php endif;?>
            <?php } ?>

            <div class="clear"></div>
        </div>

    <div class="member-list-more">

    <?php if($su_admin): ?>

        <?php /* SUPER ADMIN BEGIN */?>
        <?php if(!isset($post_meta_arr['admins']))$post_meta_arr['admins'] = array();if(!isset($post_meta_arr['users']['active']))$post_meta_arr['users']['active'] = array(); ?>
        <?php if( in_array($member->ID, $post_meta_arr['admins']) || in_array($member->ID, $post_meta_arr['users']['active']) ):?>
            <div class="mlm1">
                <a class="ajaxloadremoveadmin" href="javascript:void(0);" data-req="remove_friend_admin" data-pid="<?php echo esc_attr($post_id); ?>" data-uid="<?php echo esc_attr($member->ID); ?>">
                    <i class="fa fa-times"></i> <?php esc_html_e('Remove user','blackfyre');?>
                </a>
            </div>
        <?php endif;?>

        <?php if(in_array($member->ID, $post_meta_arr['users']['active'])):?>
            <div class="mlm2 u">
                <a class="ajaxloadmakeadmin" href="javascript:void(0);" data-req="make_administrator" data-pid="<?php echo esc_attr($post_id); ?>" data-uid="<?php echo esc_attr($member->ID); ?>">
                    <i class="fa fa-chevron-up"></i> <?php esc_html_e('Make administrator','blackfyre');?>
                </a>
            </div>
        <?php elseif(in_array($member->ID, $post_meta_arr['admins'])): ?>
            <div class="mlm2">
                <a class="ajaxloaddowngrade" href="javascript:void(0);" data-req="downgrade_to_user" data-pid="<?php echo esc_attr($post_id); ?>" data-uid="<?php echo esc_attr($member->ID); ?>">
                    <i class="fa fa-chevron-down"></i> <?php esc_html_e('Downgrade to user','blackfyre');?>
                </a>
            </div>
        <?php endif;?>

        <?php if(in_array($member->ID, $post_meta_arr['users']['pending'])):?>
            <div class="mlm1 mj"><?php esc_html_e('Let this member join?','blackfyre');?>
                <a class="ajaxloadletjoin" href="javascript:void(0);" data-req="let_this_member_join" data-pid="<?php echo esc_attr($post_id); ?>" data-uid="<?php echo esc_attr($member->ID); ?>"><i class="fa fa-check"></i></a>
                <a class="ajaxloadremoveadmin" href="javascript:void(0);" data-req="remove_friend_admin" data-pid="<?php echo esc_attr($post_id); ?>" data-uid="<?php echo esc_attr($member->ID); ?>"><i class="fa fa-times"></i></a>
            </div>
        <?php endif;?>
        <?php /* SUPER ADMIN END */?>



    <?php elseif(!$su_admin && in_array($current_user->ID, $post_meta_arr['admins']) ):?>

        <?php /* ADMIN BEGIN */?>
        <?php if( in_array($member->ID, $post_meta_arr['users']['active']) ):?>
            <div class="mlm1">
                <a class="ajaxloadremoveadmin" href="javascript:void(0);" data-req="remove_friend_admin" data-pid="<?php echo esc_attr($post_id); ?>" data-uid="<?php echo esc_attr($member->ID); ?>">
                    <i class="fa fa-times"></i> <?php esc_html_e('Remove user','blackfyre');?>
                </a>
            </div>
            <div class="mlm2 u">
                <a class="ajaxloadmakeadmin" href="javascript:void(0);" data-req="make_administrator" data-pid="<?php echo esc_attr($post_id); ?>" data-uid="<?php echo esc_attr($member->ID); ?>">
                    <i class="fa fa-chevron-up"></i> <?php esc_html_e('Make administrator','blackfyre');?>
                </a>
            </div>
        <?php endif;?>


        <?php if(in_array($member->ID, $post_meta_arr['users']['pending'])):?>
            <div class="mlm1 mj"><?php esc_html_e('Let this member join?','blackfyre');?>
                <a class="ajaxloadletjoin" href="javascript:void(0);" data-req="let_this_member_join" data-pid="<?php echo esc_attr($post_id); ?>" data-uid="<?php echo esc_attr($member->ID); ?>"><i class="fa fa-check"></i></a>
                <a class="ajaxloadremoveadmin" href="javascript:void(0);" data-req="remove_friend_admin" data-pid="<?php echo esc_attr($post_id); ?>" data-uid="<?php echo esc_attr($member->ID); ?>"><i class="fa fa-times"></i></a>
            </div>
        <?php endif;?>
        <?php /* ADMIN END */?>


    <?php endif;?>
    </div>
    </li>
<?php }


function blackfyre_is_member($post_id=false, $user_id=false){
    if ($post_id==false && $user_id==false) return false;
    $post_meta_arr = get_post_meta( $post_id, 'clan', true );
    $usr_meta = get_user_meta( $user_id, 'clan_post_id');
    $is_member = (blackfyre_is_val_exists($post_id,$usr_meta)) ? true : false;
    return $is_member;
}

function blackfyre_is_member_of_any_clan($user_id=false){
    if ($user_id==false) return false;
    $usr_meta = get_user_meta( $user_id, 'clan_post_id');
    foreach ($usr_meta as $usr_m) {
        if(blackfyre_is_super_admin($usr_m[0],$user_id) or blackfyre_is_user($usr_m[0],$user_id) or blackfyre_is_admin($usr_m[0],$user_id)){
            $clanje = true;
        }
        /*backversion compatibility*/
        elseif(blackfyre_is_super_admin($usr_m,$user_id) or blackfyre_is_user($usr_m,$user_id) or blackfyre_is_admin($usr_m,$user_id)){
            $clanje = true;
        }
    }
    if(!isset($clanje)) $clanje = false;
    $is_member = $clanje ? true : false;
    return $is_member;
}

function blackfyre_is_pending_member($post_id=false, $user_id=false){
    if ($post_id==false && $user_id==false) return false;
    $post_meta_arr = get_post_meta( $post_id, 'clan', true );
    if( ( ! isset( $post_meta_arr['users'] ) ) || ( ! isset( $post_meta_arr['users']['pending'] ) ) || $post_meta_arr['users']['pending'] === NULL) {
        $is_member = false;
    } else if ( isset( $post_meta_arr['users']['pending'] ) && is_array( $post_meta_arr['users']['pending'] ) ) {
        $is_member = (in_array($user_id, $post_meta_arr['users']['pending'])) ? true : false;
    } else {
        $is_member = false;
    }
    return $is_member;
}

function blackfyre_is_user($post_id=false, $user_id=false){
    if ($post_id==false && $user_id==false) return false;
    if (in_array(blackfyre_membership_status($post_id,$user_id), array('user') ) ) return true;
    else return false;
}

function blackfyre_is_super_admin($post_id=false, $user_id=false){
    if ($post_id==false && $user_id==false) return false;
    if (in_array(blackfyre_membership_status($post_id,$user_id), array('super_admin') ) ) return true;
    else return false;
}

function blackfyre_is_admin($post_id=false, $user_id=false){
    if ($post_id==false && $user_id==false) return false;
    if (in_array(blackfyre_membership_status($post_id,$user_id), array('super_admin', 'admin') ) ) return true;
    else return false;
}


function blackfyre_membership_status($post_id=false, $user_id=false){
    if ($post_id==false && $user_id==false) return false;
    if ($post_id && $user_id) {
        $post_meta_arr = get_post_meta($post_id, 'clan', true);

        if ($post_meta_arr=='') return false;
        if($post_meta_arr['super_admin']==$user_id) return 'super_admin';

        if(!isset($post_meta_arr['admins']))$post_meta_arr['admins'] = array();
        if(!is_array($post_meta_arr['admins'])) $post_meta_arr['admins'] = (array) $post_meta_arr['admins'];
        if(in_array($user_id, $post_meta_arr['admins'])) return 'admin';

        if(!isset($post_meta_arr['users']['active'])){
             if(empty($post_meta_arr['users'])){
                  $post_meta_arr['users'] = array();
             }

             $post_meta_arr['users']['active'] = array();
        }
        if(!is_array($post_meta_arr['users']['active'])) $post_meta_arr['users']['active'] = (array) $post_meta_arr['users']['active'];
        if(in_array($user_id, $post_meta_arr['users']['active'])) return 'user';

        if(!isset($post_meta_arr['users']['pending'])){
             if(empty($post_meta_arr['users'])){
                  $post_meta_arr['users'] = array();
             }

             $post_meta_arr['users']['pending'] = array();
        }
        if(!is_array($post_meta_arr['users']['pending'])) $post_meta_arr['users']['pending'] = (array) $post_meta_arr['users']['pending'];
        if(in_array($user_id, $post_meta_arr['users']['pending'])) return 'user_pending';

    } else return false;

}

function blackfyre_games_for_postid ($pid) { return get_post_meta( $pid, 'games'); }

function blackfyre_get_user_clans($user_id){
    $clans = get_user_meta( $user_id, 'clan_post_id');

    $active_clans = array();

    foreach ($clans as $clan) {
        if((blackfyre_is_user($clan[0], $user_id) or blackfyre_is_super_admin($clan[0], $user_id) or blackfyre_is_admin($clan[0], $user_id)) && get_post_status($clan[0]) == 'publish' ){
            $active_clans[]=$clan[0];
        }
        /*backversion compatibility*/
        elseif((blackfyre_is_user($clan, $user_id) or blackfyre_is_super_admin($clan, $user_id) or blackfyre_is_admin($clan, $user_id)) && get_post_status($clan) == 'publish' ){
            $active_clans[]=$clan;
        }
    }
    return $active_clans;
}

function blackfyre_return_clan_image($clan_id){
    global $wpdb;
    $teams = $wpdb->prefix."cw_teams";
    $logo = $wpdb->get_results($wpdb->prepare("SELECT logo FROM $teams WHERE `id`= %s ", $clan_id ));

    if(!empty($logo)){
    $thumb = $logo[0]->logo;
    $img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
    $image = blackfyre_aq_resize( $img_url, 55, 55, true, true, true ); //resize & crop img
    }

    $pid = blackfyre_return_team_post__by_team_id($clan_id);
    $imag = get_post_meta ((int)$pid->post_id, 'clan_photo', true);

    if(!empty($imag)){
     $image = blackfyre_aq_resize( $imag, 210, 178, true, true, true ); //resize & crop img
    }

    if(!$image){ $image = get_template_directory_uri().'/img/defaults/default_profile55x55.png';  }
    return $image;
}

function blackfyre_return_clan_image_big($clan_id){
    global $wpdb;
    $teams = $wpdb->prefix."cw_teams";
    $logo = $wpdb->get_results($wpdb->prepare("SELECT logo FROM $teams WHERE `id`= %s", $clan_id));

    if(!empty($logo)){
    $thumb = $logo[0]->logo;
    $img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
    $image = blackfyre_aq_resize( $img_url, 210, 178, true, true, true ); //resize & crop img
    }

    $pid = blackfyre_return_team_post__by_team_id($clan_id);
    $imag = get_post_meta ((int)$pid->post_id, 'clan_photo', true);

    if(!empty($imag)){
     $image = blackfyre_aq_resize( $imag, 210, 178, true, true, true ); //resize & crop img
    }

    if(!$image){ $image = get_template_directory_uri().'/img/defaults/default-clan.jpg';  }
    return $image;
}
function blackfyre_return_team_name_by_team_id($team_id){
    global $wpdb;
    $teams = $wpdb->prefix."cw_teams";
    $title = $wpdb->get_results($wpdb->prepare("SELECT title FROM $teams WHERE `id`= %s", $team_id));
    return $title;
}

function blackfyre_return_team_post__by_team_id($team_id){
    global $wpdb;
    $teams = $wpdb->prefix."cw_teams";
    $post_id = $wpdb->get_results($wpdb->prepare("SELECT post_id FROM $teams WHERE `id`= %s", $team_id));
    return $post_id[0];
}

function blackfyre_return_team_id_by_post_id($post_id){
    global $wpdb;
    $teams = $wpdb->prefix."cw_teams";
    $title = $wpdb->get_results($wpdb->prepare("SELECT id FROM $teams WHERE `post_id`= %s", $post_id));
    return $title;
}

function blackfyre_return_teams_by_post_id($post_id){
    global $wpdb;
    $teams = $wpdb->prefix."cw_teams";
    $matches = $wpdb->prefix."cw_matches";
    $rslt = $wpdb->get_results($wpdb->prepare("SELECT team1,team2 FROM $matches as matches
                                INNER JOIN $teams as teams
                                ON matches.team1 = teams.id
                                WHERE matches.post_id= %s", $post_id));
    return $rslt[0];
}

function blackfyre_return_teams_by_match_id($match_id){
    global $wpdb;
    $matches = $wpdb->prefix."cw_matches";
    $teams = $wpdb->prefix."cw_teams";
    $rslt = $wpdb->get_results($wpdb->prepare("SELECT team1,team2 FROM $matches as matches
                                INNER JOIN $teams as teams
                                ON matches.team1 = teams.id
                                WHERE matches.id= %s", $match_id));
    return $rslt[0];
}
function blackfyre_return_post_id_by_team_id($team_id){
    global $wpdb;
    $teams = $wpdb->prefix."cw_teams";
    $rslt = $wpdb->get_results($wpdb->prepare("SELECT post_id FROM $teams WHERE `id`= %s",$team_id));
    return $rslt[0];
}


function blackfyre_return_number_of_members($clan_id){
    $members = get_post_meta( $clan_id, 'clan', true );
    $ad = ( is_array( $members ) && isset( $members['admins'] ) && is_array( $members['admins'] )  ) ? $members['admins'] : array();
    $us = ( is_array( $members ) && isset( $members['users'] ) && is_array( $members['users'] ) && isset( $members['users']['active'] ) ) ? $members['users']['active'] : array();
    $total = count($ad) + count($us) + 1;
    return  $total;
}

/*MATCH FUNCTIONS*/
function blackfyre_return_team_ids_from_match_by_post_id($post_id){
    global $wpdb;
    $matches = $wpdb->prefix."cw_matches";
    $rslt = $wpdb->get_results($wpdb->prepare("SELECT team1,team2 FROM $matches WHERE `post_id`= %s", $post_id));
    return $rslt[0];
}

function blackfyre_return_team_ids_from_match_by_match_id($match_id){
    global $wpdb;
    $matches = $wpdb->prefix."cw_matches";
    $rslt = $wpdb->get_results($wpdb->prepare("SELECT team1,team2 FROM $matches WHERE `id`= %s", $match_id));
    return $rslt[0];
}

function blackfyre_return_match_status_by_post_id($post_id){
    global $wpdb;
    $matches = $wpdb->prefix."cw_matches";
    $rslt = $wpdb->get_results($wpdb->prepare("SELECT status FROM $matches WHERE `post_id`= %s", $post_id));
    return $rslt[0];
}

function blackfyre_return_match_status_by_match_id($match_id){
    global $wpdb;
    $matches = $wpdb->prefix."cw_matches";
    $rslt = $wpdb->get_results($wpdb->prepare("SELECT status FROM $matches WHERE `id`= %s", $match_id));
    return $rslt[0];
}


/*OTHER CW FUNCTIONS*/


function blackfyre_delete_usermeta_on_clan_delete($post_id){
     global $wpdb;
     $usermeta = $wpdb->prefix."usermeta";
     $wpdb->query($wpdb->prepare("DELETE FROM $usermeta WHERE `meta_key` = 'clan_post_id' && `meta_value` LIKE %s;", '%i:'.$wpdb->esc_like($post_id).';%'));

     /*backversion compatibility*/
     $wpdb->query($wpdb->prepare("DELETE FROM $usermeta WHERE `meta_key` = 'clan_post_id' && `meta_value` = %s;", $post_id));
}

function blackfyre_return_map_pic($map_id){
     global $wpdb;
     $maps = $wpdb->prefix."cw_maps";
     $rslt = $wpdb->get_results($wpdb->prepare("SELECT `screenshot` FROM $maps where `id` = %s", $map_id));
     $thumb = $rslt[0]->screenshot;
     $img_url = wp_get_attachment_url( $thumb,'full');
     return $img_url;
}

function blackfyre_return_map_title($map_id){
     global $wpdb;
     $maps = $wpdb->prefix."cw_maps";
     $rslt = $wpdb->get_results($wpdb->prepare("SELECT `title` FROM $maps where `id` = %s", $map_id));
     return $rslt[0]->title;
}



function blackfyre_return_game_image($game_id){
    global $wpdb;
    $games = $wpdb->prefix."cw_games";
    $game_img = $wpdb->get_results($wpdb->prepare("SELECT `icon` FROM $games WHERE `id`= %s", $game_id));

    if(!empty($game_img)){
    $img_url = wp_get_attachment_url( $game_img[0]->icon,'full'); //get img URL
    $image = blackfyre_aq_resize( $img_url, 51, 71, true, true, true ); //resize & crop img
    }
    if(!$image){ $image = get_template_directory_uri().'/img/defaults/gamedefault.jpg';  }
    return $image;

}

function blackfyre_return_game_id_by_post_id($post_id){
    global $wpdb;
    $matches = $wpdb->prefix."cw_matches";
    $game_id = $wpdb->get_results($wpdb->prepare("SELECT `game_id` FROM $matches WHERE `post_id`= %s",$post_id));

    if(isset($game_id[0])){
         return $game_id[0];
    }else{
         return '';
    }

}

function blackfyre_return_game_banner($game_id){
    global $wpdb;
    $games = $wpdb->prefix."cw_games";
    $game_img = $wpdb->get_results($wpdb->prepare("SELECT g_banner_file FROM $games WHERE `id`= %s",$game_id));

     if(!empty($game_img)){
    $thumb = $game_img[0]->g_banner_file;
    $img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
    $image = blackfyre_aq_resize( $img_url, 1168, 230, true, true, true ); //resize & crop img
    }
    if(!$image){ $image = get_template_directory_uri().'/img/defaults/default-banner.jpg';  }
    return $image;

}

function blackfyre_return_all_games($team_id){
    global $wpdb;
    $matches = $wpdb->prefix."cw_matches";
    $rslt = $wpdb->get_results($wpdb->prepare("SELECT `game_id` FROM $matches WHERE `team1`= %s or `team2`= %s ", $team_id,$team_id));
    $gids = array();
    foreach ($rslt as $rsl) {
        $gids[] = $rsl->game_id;
    }
    return $gids;
}

function blackfyre_return_all_games_string($team_id){
    global $wpdb;
    $matches = $wpdb->prefix."cw_matches";
    $rslt = $wpdb->get_results($wpdb->prepare("SELECT `game_id` FROM $matches WHERE `team1`= %s or `team2`= %s ",$team_id,$team_id));

    $gids = '';
    $i = 0;
    $len = count($rslt);
    foreach ($rslt as $rsl) {

        if(($i == $len - 1) && $i != 0){
            $gids = $gids . ', '. $rsl->game_id;
        }else{
            if ($i == 0) {
               $gids = $rsl->game_id;
            }else{
               $gids = $gids. ', '.$rsl->game_id;
            }
        }
     $i++;
    }
    return $gids;
}

function blackfyre_mutual_games_inter($team1, $team2){
    $games1 = blackfyre_games_for_postid($team1);
    $games2 = blackfyre_games_for_postid($team2);
    $wpClanWars = new WP_ClanWars();
    if( isset($games1[0]) && is_array($games1[0]) && isset($games2[0]) && is_array($games2[0]) ){
        foreach($games1[0] as $item) {
            if (in_array($item, $games2[0])) {
                $game = $wpClanWars->get_game(array('id'=>$item));
                $ret[$item]=$game[0]->title;
            }
        }
        if(empty($ret)){ ?>
            <option value=""><?php esc_html_e('No mutual games', 'blackfyre'); ?></option>
        <?php }else{
        foreach($ret as $key=>$val): ?>
            <option value="<?php echo esc_attr($key);?>"><?php echo esc_attr($val);?></option>
        <?php endforeach; }
    }else{ ?>
         <option value=""><?php esc_html_e('No mutual games', 'blackfyre'); ?></option>
   <?php }
}

function blackfyre_get_all_games($post_id){
    $wpClanWars = new WP_ClanWars();
    $arr =  array(
        'id' => false,
        'limit' => 0,
        'offset' => 0,
        'orderby' => 'id',
        'order' => 'ASC'
    );
    $tmp_arr = get_post_meta($post_id, 'games', true);
    $games_postmeta_arr = is_array($tmp_arr) ? $tmp_arr : array();
    $games = $wpClanWars->get_game($arr); ?>
    <form id="frm_matches">
    <?php foreach($games as $game){ ?>
        <div><label><input type="checkbox" class="chk_games" name="chk_games[]"
        <?php if(in_array($game->id, $games_postmeta_arr)):?>checked<?php endif;?>
        value="<?php echo esc_attr($game->id); ?>">&nbsp;<?php echo esc_attr($game->title); ?></label></div>
    <?php } ?>
    </form>
<?php }


/*AJAX CALLS*/
function blackfyre_delete_page_background(){
    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_NUMBER_INT);
    if (is_numeric($pid)) {
      if (current_user_can('edit_post', $pid)) {
        delete_post_meta($pid, 'team_page_bg');
      }
    }
    die();
}


function blackfyre_list_all_clans_for_selected_game($gid,$page=1, $term=''){

    $post_per_page = 40;
    $offset = ($page -1) * $post_per_page;

    $args = array(
        'post_type'  => 'clan',
        'meta_key'   => 'games',
        'posts_per_page'   => -1,
        'meta_query' => array(
            array(
                'key'     => 'games',
                'value'   => $gid,
                'compare' => 'LIKE',
            ),
        ),
    );

    $my_posts = get_posts($args);

    include "addons/pagination/pagination.class.php";
    $p = new blackfyre_pagination;
    $p->items(count($my_posts));
    $p->limit($post_per_page);

    $p->parameterName("page");
    $p->currentPage(isset($_GET['page'])?$_GET['page']:1);
    unset($_GET['page']);
    $_GET['term'] = $term;
    $p->target("?".http_build_query($_GET));

    #$p->parameterName('paged');
    #$p->currentPage($paged);
    #$p->target("?term={$term}");


    $p->nextLabel(esc_html__('Next','blackfyre'));
    $p->prevLabel(esc_html__('Previous','blackfyre'));


    if ( $my_posts ) { ?>

       <ul id="members-list" class="item-list" >
       <?php foreach ( $my_posts as $post ) { ?>
            <li>
                    <div class="clan-list-wrapper">
                        <div class="item-avatar">
                           <a href="<?php echo esc_url(get_permalink($post->ID)); ?> ">
                             <?php //$img = get_post_meta( $post->ID, 'team_photo', true );
                                   $img = get_post_meta( $post->ID, 'clan_photo', true );
                                   $image = blackfyre_aq_resize( $img, 50, 50, true, true, true );

                                   if(empty($image)){
                                       $image = esc_url(get_template_directory_uri()).'/img/defaults/default-clan-50x50.jpg';
                                   }
                                   ?>
                            <img alt="img" src="<?php echo esc_url($image); ?>" class="avatar" >
                           </a>
                        </div>

                        <div class="item">
                            <div class="item-title">
                                <a href="<?php echo esc_url(get_permalink($post->ID)); ?> "> <?php if(strlen($post->post_title) > 25){ $dot= '...'; echo esc_attr( mb_substr($post->post_title, 0 ,25).$dot); }else{ echo esc_attr($post->post_title); } ?></a>

                                <div class="item-meta">
                                    <span class="activity">
                                        <?php $members = blackfyre_return_number_of_members($post->ID); ?>
                                        <?php if($members == 1){
                                            echo esc_attr($members); ?>&nbsp;<?php esc_html_e('Member','blackfyre');
                                        }else{
                                            echo esc_attr($members); ?>&nbsp;<?php esc_html_e('Members','blackfyre');
                                        } ?>
                                    </span></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>

                </li>
       <?php } ?>

       </ul>
<div class="clear"></div>
    <?php } else { ?>
        <div class="error_msg"><span><?php esc_html_e('There are no clans that play this game at the moment!', 'blackfyre'); ?> </span></div>
    <?php } ?>


    <?php $p->show();
    wp_reset_postdata();
}

function blackfyre_list_all_clans_for_selected_game_search($page=1, $term=''){

    global $wpdb;

    $post_per_page = 40;
    $offset = ($page -1) * $post_per_page;

    $query = "
    SELECT SQL_CALC_FOUND_ROWS *
    FROM {$wpdb->posts} WHERE 1=1
    AND post_type = 'clan'
    AND post_name LIKE '%{$term}%'
    AND (post_status = 'publish' OR post_status = 'closed')
    ORDER BY post_name ASC
    LIMIT {$offset}, {$post_per_page}
    ";

    $results = $wpdb->get_results( $query);

    $res_count = (int) $wpdb->get_var( "SELECT FOUND_ROWS()" );

    include "addons/pagination/pagination.class.php";
    $p = new blackfyre_pagination;
    $p->items($res_count);
    $p->limit($post_per_page);

    $p->parameterName("page");
    $p->currentPage(isset($_GET['page'])?$_GET['page']:1);
    unset($_GET['page']);
    $_GET['term'] = $term;
    $p->target("?".http_build_query($_GET));

    #$p->parameterName('paged');
    #$p->currentPage($paged);
    #$p->target("?term={$term}");


    $p->nextLabel(esc_html__('Next','blackfyre'));
    $p->prevLabel(esc_html__('Previous','blackfyre'));


    if ( $results ) { ?>

       <ul id="members-list" class="item-list" >
       <?php foreach ( $results as $post ) { ?>
            <li>
                    <div class="clan-list-wrapper">
                        <div class="item-avatar">
                           <a href="<?php echo esc_url(get_permalink($post->ID)); ?> ">
                             <?php $img = get_post_meta( $post->ID, 'clan_photo', true );
                                   $image = blackfyre_aq_resize( $img, 50, 50, true, true, true );
                                   if(empty($image)){
                                       $image = esc_url(get_template_directory_uri()).'/img/defaults/default-clan-50x50.jpg';
                                   }
                                   ?>
                            <img alt="img" src="<?php echo esc_url($image); ?>" class="avatar" >
                           </a>
                        </div>

                        <div class="item">
                            <div class="item-title">
                                <a href="<?php echo esc_url(get_permalink($post->ID)); ?> "> <?php if(strlen($post->post_title) > 25){ $dot= '...'; echo esc_attr( mb_substr($post->post_title, 0 ,25).$dot); }else{ echo esc_attr($post->post_title); } ?></a>

                                <div class="item-meta">
                                    <span class="activity">
                                        <?php $members = blackfyre_return_number_of_members($post->ID); ?>
                                        <?php if($members == 1){
                                            echo esc_attr($members); ?>&nbsp;<?php esc_html_e('Member','blackfyre');
                                        }else{
                                            echo esc_attr($members); ?>&nbsp;<?php esc_html_e('Members','blackfyre');
                                        } ?>
                                    </span></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>

                </li>
       <?php } ?>

       </ul>
<div class="clear"></div>
    <?php } else { ?>
        <div class="error_msg"><span><?php esc_html_e('We couldn\'t find any results for your search.', 'blackfyre'); ?> </span></div>
    <?php } ?>


    <?php $p->show();
}

function blackfyre_list_all_clans_for_selected_game_ajax(){
    $_POST['href'] = str_replace('?','', $_POST['href']);
    parse_str($_POST['href'], $_GET);
    blackfyre_list_all_clans_for_selected_game_search($_GET['page'], $_GET['term']);
    die();
}

function blackfyre_change_membership_block(){
    $pid = filter_var($_POST['pid'], FILTER_SANITIZE_NUMBER_INT); //team id
    $req =  filter_var($_POST['req'], FILTER_SANITIZE_STRING); //wat du
    $uid = get_current_user_id(); //my uid anyways
    $pid = (int)$pid;
    if (!($uid > 0 )) {
      die('Would be a good idea to login first, woudn\'t it?');
    }

    if (!($pid > 0)) {
      die();
    }

    $post_meta_arr = get_post_meta($pid, 'clan', true );
    $data = array();


    if($req=="remove_friend_user"){
        $key = array_search($uid,$post_meta_arr['admins']);
        if($key!==false) unset($post_meta_arr['admins'][$key]);

        $key = array_search($uid,$post_meta_arr['users']['active']);
        if($key!==false) unset($post_meta_arr['users']['active'][$key]);

        $key = array_search($uid,$post_meta_arr['users']['pending']);
        if($key!==false) unset($post_meta_arr['users']['pending'][$key]);

        $klanovi = get_user_meta($uid, 'clan_post_id');

        if(blackfyre_is_val_exists($pid, $klanovi)){
            $index = array_search($pid, array_column($klanovi, 0));
            delete_user_meta($uid, 'clan_post_id', $klanovi[$index]);
        }

        /*backversion compatibility*/
        delete_user_meta($uid, 'clan_post_id', $pid);
        $data[0] = "remove_friend_user";
        $data[1] = $uid;
    } elseif($req=="join_clan"){

        $post_meta_arr['users']['pending'][] = $uid;
        add_user_meta($uid, 'clan_post_id', array($pid, time()));
        $data[0] = "join_clan";

        if (isset($post_meta_arr["super_admin"])) {
          blackfyre_request_email($post_meta_arr["super_admin"], $pid);
        }
    }elseif($req=="cancel_request"){
        $key = array_search($uid,$post_meta_arr['admins']);
        if($key!==false) unset($post_meta_arr['admins'][$key]);

        $key = array_search($uid,$post_meta_arr['users']['active']);
        if($key!==false) unset($post_meta_arr['users']['active'][$key]);

        $key = array_search($uid,$post_meta_arr['users']['pending']);
        if($key!==false) unset($post_meta_arr['users']['pending'][$key]);

        $klanovi = get_user_meta($uid, 'clan_post_id');

        if(blackfyre_is_val_exists($pid, $klanovi)){
            $index = array_search($pid, array_column($klanovi, 0));
            delete_user_meta($uid, 'clan_post_id', $klanovi[$index]);
        }
        /*backversion compatibility*/
        delete_user_meta($uid, 'clan_post_id', $pid);
        $data[0] = "cancel_request";
    }
    update_post_meta($pid, 'clan', $post_meta_arr);
    echo json_encode($data);
    die();
}


function blackfyre_change_membership_let_join(){
    $pid = filter_var($_POST['pid'], FILTER_SANITIZE_NUMBER_INT); //team id
    $req =  filter_var($_POST['req'], FILTER_SANITIZE_STRING); //wat du
    $uid = filter_var($_POST['uid'], FILTER_SANITIZE_NUMBER_INT); //user id
    if (!($uid > 0 )) {
      die('Would be a good idea to login first, woudn\'t it?');
    }

    if (!($pid > 0)) {
      die();
    }

    $c_id = get_current_user_id();
    $post = get_post($pid);
    $a_id = $post->post_author;

    if((current_user_can( 'manage_options' )))$is_admin = true;
      if($c_id == $a_id){$is_mine = true;}

       if (($is_admin == true) OR ($is_mine == true)) {
    $post_meta_arr = get_post_meta($pid, 'clan', true );
    $data = array();
    if($req=="let_this_member_join"){
        $key = array_search($uid,$post_meta_arr['users']['pending']);
        if($key!==false) unset($post_meta_arr['users']['pending'][$key]);
        $post_meta_arr['users']['active'][] = $uid;
        $data[0] = "let_this_member_join";
        $data[1] = $uid;
    }
    update_post_meta($pid, 'clan', $post_meta_arr);
    echo json_encode($data);
    die();
    }
}

function blackfyre_change_membership_remove_friend_admin(){
   $pid = filter_var($_POST['pid'], FILTER_SANITIZE_NUMBER_INT); //team id
    $req =  filter_var($_POST['req'], FILTER_SANITIZE_STRING); //wat du
    $uid = filter_var($_POST['uid'], FILTER_SANITIZE_NUMBER_INT); //user id
     if (!($uid > 0 )) {
      die('Would be a good idea to login first, woudn\'t it?');
    }

    if (!($pid > 0)) {
      die();
    }

    $c_id = get_current_user_id();
    $post = get_post($pid);
    $a_id = $post->post_author;

    if((current_user_can( 'manage_options' )))$is_admin = true;
      if($c_id == $a_id){$is_mine = true;}

      if (($is_admin == true) OR ($is_mine == true)) {
    $post_meta_arr = get_post_meta($pid, 'clan', true );
    $data = array();
    if($req=="remove_friend_admin"){
        $key = array_search($uid,$post_meta_arr['admins']);
        if($key!==false) unset($post_meta_arr['admins'][$key]);

        $key = array_search($uid,$post_meta_arr['users']['active']);
        if($key!==false) unset($post_meta_arr['users']['active'][$key]);

        $key = array_search($uid,$post_meta_arr['users']['pending']);
        if($key!==false) unset($post_meta_arr['users']['pending'][$key]);
        $klanovi = get_user_meta($uid, 'clan_post_id');

        if(blackfyre_is_val_exists($pid, $klanovi)){
            $index = array_search($pid, array_column($klanovi, 0));
            delete_user_meta($uid, 'team_post_id', $klanovi[$index]);
        }
        /*backversion compatibility*/
        delete_user_meta($uid, 'clan_post_id', $pid);
        $data[0] = "remove_friend_admin";
        $data[1] = $uid;
    }
    update_post_meta($pid, 'clan', $post_meta_arr);
    echo json_encode($data);
    die();
      }
}


function blackfyre_change_membership_make_administrator(){
    $pid = filter_var($_POST['pid'], FILTER_SANITIZE_NUMBER_INT); //team id
    $req =  filter_var($_POST['req'], FILTER_SANITIZE_STRING); //wat du
    $uid = filter_var($_POST['uid'], FILTER_SANITIZE_NUMBER_INT); //user id
    if (!($uid > 0 )) {
      die('Would be a good idea to login first, woudn\'t it?');
    }

    if (!($pid > 0)) {
      die();
    }

    $c_id = get_current_user_id();
    $post = get_post($pid);
    $a_id = $post->post_author;

    if((current_user_can( 'manage_options' )))$is_admin = true;
      if($c_id == $a_id){$is_mine = true;}

     if (($is_admin == true) OR ($is_mine == true)) {
    $post_meta_arr = get_post_meta($pid, 'clan', true );
    $data = array();
    if($req=="make_administrator"){
        $key = array_search($uid,$post_meta_arr['users']['active']);
        if($key!==false) unset($post_meta_arr['users']['active'][$key]);
        $post_meta_arr['admins'][] = $uid;
        $data[0] = "make_administrator";
        $data[1] = $uid;
    }
    update_post_meta($pid, 'clan', $post_meta_arr);
    echo json_encode($data);
    die();
     }
}


function blackfyre_change_membership_downgrade_to_user(){
    $pid = filter_var($_POST['pid'], FILTER_SANITIZE_NUMBER_INT); //team id
  $req =  filter_var($_POST['req'], FILTER_SANITIZE_STRING); //wat du
  $uid = filter_var($_POST['uid'], FILTER_SANITIZE_NUMBER_INT); //user id
  if (!($uid > 0 )) {
    die('Would be a good idea to login first, woudn\'t it?');
  }

  if (!($pid > 0)) {
    die();
  }

  $c_id = get_current_user_id();
  $post = get_post($pid);
  $a_id = $post->post_author;

  if((current_user_can( 'manage_options' )))$is_admin = true;
    if($c_id == $a_id){$is_mine = true;}


    if (($is_admin == true) OR ($is_mine == true)) {
    $post_meta_arr = get_post_meta($pid, 'clan', true );
    $data = array();
    if($req=="downgrade_to_user"){
        $key = array_search($uid,$post_meta_arr['admins']);
        if($key!==false) unset($post_meta_arr['admins'][$key]);
        $post_meta_arr['users']['active'][] = $uid;
        $data[0] = "downgrade_to_user";
        $data[1] = $uid;
    }
    update_post_meta($pid, 'clan', $post_meta_arr);
    echo json_encode($data);
    die();
    }
}


function blackfyre_clan_members_ajax(){
    $_POST['page'] = str_replace('?','', $_POST['page']);
    parse_str($_POST['page'], $page);
    blackfyre_clan_members($_POST['pid'], $page['members_list_page'] );
    die();
}


function blackfyre_edit_acc_rej(){

       global $wpClanWars;
       $req = filter_var($_POST['req'], FILTER_SANITIZE_STRING);
       $challenge_id = filter_var($_POST['cid'], FILTER_SANITIZE_NUMBER_INT); //is actually a game id
       $cid = get_current_user_id();
       $pid = blackfyre_return_post_id_by_match_id_from_matches($challenge_id);

       if (blackfyre_is_user_in_game($challenge_id, $cid) OR  current_user_can( 'manage_options' )) {
          $data = array();
          if($req=="accept_edit"){
              $data[0] = $challenge_id;
              $data[1] = 'accepted';
              echo json_encode($data);
              $previous_status = get_post_meta($pid, 'match_status_edit', true);
              $p = array('status' => $previous_status);
              $wpClanWars->update_match($challenge_id, $p);
          }

          if($req=="reject_edit"){
              $data[0] = $challenge_id;
              $data[1] = 'rejected';
              echo json_encode($data);
              $title = get_post_meta($pid,'title_edit', true);
              $description = get_post_meta($pid,'description_edit', true);
              $external_url = get_post_meta($pid,'external_url_edit', true);
              $date = get_post_meta($pid,'date_edit', true);
              $match_status = get_post_meta($pid,'match_status_edit', true);
              $p = array('title'=> $title, 'description'=> $description,'external_url'=> $external_url, 'date'=> $date, 'status'=> $match_status,);
              $wpClanWars->update_match($challenge_id, $p);
          }
        }
die();
}

function blackfyre_edit_acc_rej_single(){
        global $wpClanWars;
        $req = filter_var($_POST['req'], FILTER_SANITIZE_STRING);
        $challenge_id = filter_var($_POST['cid'], FILTER_SANITIZE_NUMBER_INT); //is actually a game id
        $cid = get_current_user_id();
        $pid = blackfyre_return_post_id_by_match_id_from_matches($challenge_id);
        if (blackfyre_is_user_in_game($challenge_id, $cid) OR  current_user_can( 'manage_options' )) {
          $data = '';

          $match = $wpClanWars->get_match(array('id' => $challenge_id));

          if($req=="accept_edit"){
              $data = 'accepted';
              echo json_encode($data);
              $previous_status = get_post_meta($pid, 'match_status_edit', true);
              $p = array('status' => $previous_status);
              $wpClanWars->update_match($challenge_id, $p);
          }

          if($req=="reject_edit"){
              $data = 'rejected';
              echo json_encode($data);
              $title = get_post_meta($pid,'title_edit', true);
              $description = get_post_meta($pid,'description_edit', true);
              $external_url = get_post_meta($pid,'external_url_edit', true);
              $date = get_post_meta($pid,'date_edit', true);
              $match_status = get_post_meta($pid,'match_status_edit', true);
              $p = array('title'=> $title, 'description'=> $description,'external_url'=> $external_url, 'date'=> $date, 'status'=> $match_status,);
              $wpClanWars->update_match($challenge_id, $p);

          }
        }
die();
}

function blackfyre_challenge_acc_rej(){
       global $wpClanWars;
        $req = filter_var($_POST['req'], FILTER_SANITIZE_STRING);
        $challenge_id = filter_var($_POST['cid'], FILTER_SANITIZE_NUMBER_INT); //is actually a game id
        $cid = get_current_user_id();
        if (blackfyre_is_user_in_game($challenge_id, $cid) OR  current_user_can( 'manage_options' )) {
            $data = array();
            if($req=="accept_challenge"){
                $data[0] = $challenge_id;
                $data[1] = 'accepted';
                echo json_encode($data);
                $p = array('status' => 'active');
                $wpClanWars->update_match($challenge_id, $p);
            }

            if($req=="reject_challenge"){
                $data[0] = $challenge_id;
                $data[1] = 'rejected';
                echo json_encode($data);
                $p = array('status' => 'rejected_challenge');
                $wpClanWars->update_match($challenge_id, $p);
            }
        }

die();
}

function blackfyre_challenge_acc_rej_single(){
        global $wpClanWars;
        $req = filter_var($_POST['req'], FILTER_SANITIZE_STRING);
        $challenge_id = filter_var($_POST['cid'], FILTER_SANITIZE_NUMBER_INT); //is actually a game id
        $cid = get_current_user_id();
        if (blackfyre_is_user_in_game($challenge_id, $cid) OR  current_user_can( 'manage_options' )) {
        $data = '';
        if($req=="accept_challenge"){
            $data = 'accepted';
            echo json_encode($data);
            $p = array('status' => 'active');
            $wpClanWars->update_match($challenge_id, $p);
        }

        if($req=="reject_challenge"){
            $data = 'rejected';
            echo json_encode($data);
            $p = array('status' => 'rejected_challenge');
            $wpClanWars->update_match($challenge_id, $p);
        }
        }
die();
}

function blackfyre_match_score_acc_rej(){
        global $wpClanWars;
        $req = filter_var($_POST['req'], FILTER_SANITIZE_STRING);
        $match_id = filter_var($_POST['mid'], FILTER_SANITIZE_NUMBER_INT); //is actually a game id
        $cid = get_current_user_id();
        if (blackfyre_is_user_in_game($match_id, $cid) OR  current_user_can( 'manage_options' )) {

            if($req=="accept_score"){
                $data = 'accepted';
                $p = array('status' => 'done');
                $wpClanWars->update_match($match_id, $p);

            }

            if($req=="reject_score"){
                $data = 'rejected';
                $p = array('status' => 'active');
                $wpClanWars->update_match($match_id, $p);
            }
            echo json_encode($data);

        }
die();

}

function blackfyre_clan_delete(){
        global $wpClanWars;
        $post_id = filter_var($_POST['pid'], FILTER_SANITIZE_NUMBER_INT);
        if ($post_id > 0) {

            $post = get_post($post_id);
          if (empty($post)) {
            die();
          }
          $cid = get_current_user_id();

              if (($post->post_author == $cid) OR current_user_can( 'manage_options' ))  {

            blackfyre_delete_usermeta_on_clan_delete($post_id);
            wp_delete_post($post_id);

              }
        }

die();
}


function blackfyre_match_delete_single(){
        global $wpClanWars;
        $mid = filter_var($_POST['mid'], FILTER_SANITIZE_NUMBER_INT);
        $pid = filter_var($_POST['pid'], FILTER_SANITIZE_NUMBER_INT);
        $cid = get_current_user_id();

        if (blackfyre_is_user_in_game($mid, $cid) OR  current_user_can( 'manage_options' )) {


        $match = $wpClanWars->get_match(array('id' => $mid));
        $pid1 = blackfyre_return_team_post__by_team_id($match[0]->team1);
        $pid2 = blackfyre_return_team_post__by_team_id($match[0]->team2);


        if(blackfyre_is_member($pid1->post_id,$cid))$team = 'deleted_req_team1';
        if(blackfyre_is_member($pid2->post_id,$cid))$team = 'deleted_req_team2';

        $previous_status = $match[0]->status;
        update_post_meta($pid, 'status_backup', $previous_status);
        $p = array('status' => $team);
        $wpClanWars->update_match($mid, $p);

        }
        die();
}


function blackfyre_match_delete(){
        global $wpClanWars;
        $mid = filter_var($_POST['mid'], FILTER_SANITIZE_NUMBER_INT);
        $req = filter_var($_POST['req'], FILTER_SANITIZE_STRING);
        $pid = filter_var($_POST['pid'], FILTER_SANITIZE_NUMBER_INT);
        $cid = get_current_user_id();

        if (blackfyre_is_user_in_game($mid, $cid) OR  current_user_can( 'manage_options' )) {

         $data = array();

          if($req=="accept_delete"){
             $data[0] = $mid;
             $data[1] = 'accepted';
              echo json_encode($data);
             $wpClanWars->delete_match($mid);
          }

          if($req=="reject_delete"){
             $data[0] = $mid;
             $data[1] = 'rejected';
             echo json_encode($data);
             $previous_status = get_post_meta($pid, 'status_backup', true);
             $p = array('status' => $previous_status);
             $wpClanWars->update_match($mid, $p);
          }


        }
        die();
}

function blackfyre_match_delete_confirmation(){
        global $wpClanWars;
        $match_id = filter_var($_POST['mid'],FILTER_SANITIZE_NUMBER_INT);
        $req = filter_var($_POST['req'], FILTER_SANITIZE_STRING);
        $pid = filter_var($_POST['pid'], FILTER_SANITIZE_NUMBER_INT);
        $cid = get_current_user_id();

        if (blackfyre_is_user_in_game($match_id, $cid) OR  current_user_can( 'manage_options' )) {
          $data = '';

          if($req=="accept_delete_request"){
              $data = 'accepted';
              echo json_encode($data);
              $wpClanWars->delete_match($match_id);
          }

          if($req=="reject_delete_request"){
             $data = 'rejected';
             echo json_encode($data);
             $previous_status = get_post_meta($pid, 'status_backup', true);
             $p = array('status' => $previous_status);
             $wpClanWars->update_match($match_id, $p);
          }
    die();

    }
}

function blackfyre_mutual_games(){
    if( $_POST['team1']=='' || $_POST['team2']=='' ) die();
    blackfyre_mutual_games_inter(filter_var($_POST['team1'], FILTER_SANITIZE_NUMBER_INT), filter_var($_POST['team2'], FILTER_SANITIZE_NUMBER_INT));
    die();
}


function blackfyre_get_attachment_id( $image_url ) {
    global $wpdb;
    $attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM " . $wpdb->posts . " WHERE guid=%s", $image_url ) );
    return $attachment[0];
}

function blackfyre_change_membership_remove_friend_admin_by_id($uid, $pid ){

    $post_meta_arr = get_post_meta($pid, 'clan', true );

    if(isset($post_meta_arr['admins'])){
        $key = array_search($uid,$post_meta_arr['admins']);
        if($key!==false) unset($post_meta_arr['admins'][$key]);
    }

    if(isset($post_meta_arr['users']['active'])){
        $key = array_search($uid,$post_meta_arr['users']['active']);
        if($key!==false) unset($post_meta_arr['users']['active'][$key]);
    }

    if(isset($post_meta_arr['users']['pending'])){
        $key = array_search($uid,$post_meta_arr['users']['pending']);
        if($key!==false) unset($post_meta_arr['users']['pending'][$key]);
    }

    $klanovi = get_user_meta($uid, 'clan_post_id');

    if(blackfyre_is_val_exists($pid, $klanovi)){
        $index = array_search($pid, array_column($klanovi, 0));
        delete_user_meta($uid, 'clan_post_id', $klanovi[$index]);
    }

    /*backversion compatibility*/
    delete_user_meta($uid, 'clan_post_id', $pid);

    update_post_meta($pid, 'clan', $post_meta_arr);

}


/*remove user from clan on delete*/
function blackfyre_remove_user_from_clan_on_delete( $user_id ) {
    $clans = get_user_meta($user_id,'clan_post_id');
    foreach ($clans as $clan) {
        blackfyre_change_membership_remove_friend_admin_by_id($user_id, $clan[0]);

        /*backversion compatibility*/
        blackfyre_change_membership_remove_friend_admin_by_id($user_id, $clan);
    }
}


/******** force permalinks structure******/
add_action('after_setup_theme', 'blackfyre_force_permalinks');
function blackfyre_force_permalinks(){
if (get_option('permalink_structure') != '/%postname%/') {
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
}
}


 function blakcfyre_footer_manager(){
    global $user_ID;
    if ( !current_user_can( 'administrator' ) ) { ?>
    <script>
   jQuery(window).bind("load", function($) {

   //header buttons
       var backend_button = jQuery('.vc_btn-backend-editor');
       var draft_button = jQuery('.vc_btn-save-draft');
       var css_field = jQuery('#vc_ui-panel-post-settings .vc_row .vc_col-sm-12');

       var news = jQuery('.wpb-content-layouts li[data-element="vc_column_news"]');
       var news_horizontal = jQuery('.wpb-content-layouts li[data-element="vc_column_news_horizontal"]');
       var news_tabbed = jQuery('.wpb-content-layouts li[data-element="vc_column_news_tabbed"]');
       var blog = jQuery('.wpb-content-layouts li[data-element="vc_column_blog"]');
       var clans = jQuery('.wpb-content-layouts li[data-element="vc_clans"]');
       var contact = jQuery('.wpb-content-layouts li[data-element="vc_contact"]');
       var woocommerce_cart = jQuery('.wpb-content-layouts li[data-element="woocommerce_cart"]');
       var woocommerce_checkout = jQuery('.wpb-content-layouts li[data-element="woocommerce_checkout"]');
       var woocommerce_order_tracking = jQuery('.wpb-content-layouts li[data-element="woocommerce_order_tracking"]');
       var woocommerce_my_account = jQuery('.wpb-content-layouts li[data-element="woocommerce_my_account"]');
       var recent_products = jQuery('.wpb-content-layouts li[data-element="recent_products"]');
       var featured_products = jQuery('.wpb-content-layouts li[data-element="featured_products"]');
       var product = jQuery('.wpb-content-layouts li[data-element="product"]');
       var products = jQuery('.wpb-content-layouts li[data-element="products"]');
       var add_to_cart = jQuery('.wpb-content-layouts li[data-element="add_to_cart"]');
       var add_to_cart_url = jQuery('.wpb-content-layouts li[data-element="add_to_cart_url"]');
       var product_page = jQuery('.wpb-content-layouts li[data-element="product_page"]');
       var product_category = jQuery('.wpb-content-layouts li[data-element="product_category"]');
       var product_categories = jQuery('.wpb-content-layouts li[data-element="product_categories"]');
       var sale_products = jQuery('.wpb-content-layouts li[data-element="sale_products"]');
       var best_selling_products = jQuery('.wpb-content-layouts li[data-element="best_selling_products"]');
       var top_rated_products = jQuery('.wpb-content-layouts li[data-element="top_rated_products"]');
       var product_attribute = jQuery('.wpb-content-layouts li[data-element="product_attribute"]');
       var raw_html = jQuery('.wpb-content-layouts li[data-element="vc_raw_html"]');
       var raw_js = jQuery('.wpb-content-layouts li[data-element="vc_raw_js"]');
       var post_grid = jQuery('.wpb-content-layouts li[data-element="vc_basic_grid"]');
       var media_grid = jQuery('.wpb-content-layouts li[data-element="vc_media_grid"]');
       var masonry_grid = jQuery('.wpb-content-layouts li[data-element="vc_masonry_grid"]');
       var masonry_media_grid = jQuery('.wpb-content-layouts li[data-element="vc_masonry_media_grid"]');
       var carousel = jQuery('.wpb-content-layouts li[data-element="vc_carousel"]');
       var post_slider = jQuery('.wpb-content-layouts li[data-element="vc_posts_slider"]');
       var widget_sidebar = jQuery('.wpb-content-layouts li[data-element="vc_widget_sidebar"]');
       var cta_button = jQuery('.wpb-content-layouts li[data-element="vc_cta"]');
       var cta_button2 = jQuery('.wpb-content-layouts li[data-element="vc_cta_button2"]');
       var custom_heading = jQuery('.wpb-content-layouts li[data-element="vc_custom_heading"]');
       var wp_search = jQuery('.wpb-content-layouts li[data-element="vc_wp_search"]');
       var wp_meta = jQuery('.wpb-content-layouts li[data-element="vc_wp_meta"]');
       var wp_recentcomments = jQuery('.wpb-content-layouts li[data-element="vc_wp_recentcomments"]');
       var wp_calendar = jQuery('.wpb-content-layouts li[data-element="vc_wp_calendar"]');
       var wp_pages = jQuery('.wpb-content-layouts li[data-element="vc_wp_pages"]');
       var wp_tagcloud = jQuery('.wpb-content-layouts li[data-element="vc_wp_tagcloud"]');
       var wp_custommenu = jQuery('.wpb-content-layouts li[data-element="vc_wp_custommenu"]');
       var wp_text = jQuery('.wpb-content-layouts li[data-element="vc_wp_text"]');
       var wp_posts = jQuery('.wpb-content-layouts li[data-element="vc_wp_posts"]');
       var wp_categories = jQuery('.wpb-content-layouts li[data-element="vc_wp_categories"]');
       var wp_archives = jQuery('.wpb-content-layouts li[data-element="vc_wp_archives"]');
       var wp_rss = jQuery('.wpb-content-layouts li[data-element="vc_wp_rss"]');
       var wp_categories = jQuery('.wpb-content-layouts li[data-element="vc_wp_categories"]');
       var pointers = jQuery('.wp-pointer');

       news.remove();
       news_horizontal.remove();
       news_tabbed.remove();
       blog.remove();
       clans.remove();
       contact.remove();
       woocommerce_cart.remove();
       woocommerce_checkout.remove();
       woocommerce_order_tracking.remove();
       woocommerce_my_account.remove();
       recent_products.remove();
       featured_products.remove();
       product.remove();
       products.remove();
       add_to_cart.remove();
       add_to_cart_url.remove();
       product_page.remove();
       product_category.remove();
       product_categories.remove();
       sale_products.remove();
       best_selling_products.remove();
       top_rated_products.remove();
       product_attribute.remove();
       raw_html.remove();
       raw_js.remove();
       post_grid.remove();
       carousel.remove();
       post_slider.remove();
       widget_sidebar.remove();
       wp_search.remove();
       wp_meta.remove();
       wp_recentcomments.remove();
       wp_calendar.remove();
       wp_pages.remove();
       wp_tagcloud.remove();
       wp_custommenu.remove();
       wp_text.remove();
       wp_posts.remove();
       wp_categories.remove();
       wp_archives.remove();
       wp_rss.remove();
       wp_categories.remove();
       cta_button.remove();
       cta_button2.remove();
       custom_heading.remove();
       pointers.remove();
       media_grid.remove();
       masonry_grid.remove();
       masonry_media_grid.remove();


       backend_button.remove();
       draft_button.remove();
       css_field.next().css('display', 'none');

    });
    </script>
    <?php }
 }

 /***** limit media to logged in user *****/
function blackfyre_restrict_media_library( $wp_query_obj ) {
    global $current_user, $pagenow;

    if( !is_a( $current_user, 'WP_User') )
        return;

    if( 'admin-ajax.php' != $pagenow || $_REQUEST['action'] != 'query-attachments' )
    return;

    if( !current_user_can('delete_pages') )
        $wp_query_obj->set('author', $current_user->id );

    return;
}

/**default landing tab bpress**/
define('BP_DEFAULT_COMPONENT', 'profile' );

/**get string between two strings**/
function blackfyre_string_between($string, $start, $end){
    $string = " ".$string;
    $ini = strpos($string,$start);
    if ($ini == 0) return "";
    $ini += strlen($start);
    $len = strpos($string,$end,$ini) - $ini;
    return mb_substr($string,$ini,$len);
}

/****************************************All clans page pagination and search**********************************************/
function blackfyre_title_filter($where, &$wp_query){
    global $wpdb;

    if($search_term = $wp_query->get( 'clan_name' )){
        $search_term = $wpdb->esc_like($search_term);
        $search_term = ' \'%' . $search_term . '%\'';
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE '.$search_term;
    }

    return $where;
}

function blackfyre_all_clans_pagination(){
    global $post;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
          'post_type' => 'clan',
          'orderby' => 'name',
          'order' => 'ASC',
          'showposts' => 1,
          'paged'  => $paged
          );

    if (isset($_POST['clan_name']) && $_POST['clan_name']!='') {
        $args['clan_name'] = $_POST['clan_name'];
        add_filter( 'posts_where', 'blackfyre_title_filter', 10, 2 );
        $the_query = new WP_Query($args);
        remove_filter( 'posts_where', 'blackfyre_title_filter', 10, 2 );
    } else {
        $the_query = new WP_Query($args);
    }


    if ( $the_query->have_posts() ) { ?>

       <ul id="members-list" class="item-list" >

       <?php while ( $the_query->have_posts() ) { $the_query->the_post(); ?>
            <li>
                    <div class="clan-list-wrapper">
                        <div class="item-avatar">
                           <a href="<?php echo esc_url(get_permalink($post->ID)); ?> ">
                             <?php $img = get_post_meta( $post->ID, 'clan_photo', true );
                                   $image = blackfyre_aq_resize( $img, 50, 50, true, true, true );
                                   if(!$image){
                                       $image = get_template_directory_uri().'/img/defaults/default-clan-50x50.jpg';
                                   }
                                   ?>
                            <img alt="img" src="<?php echo esc_url($image); ?>" class="avatar" >
                           </a>
                        </div>

                        <div class="item">
                            <div class="item-title">
                                <a href="<?php echo esc_url(get_permalink($post->ID)); ?> "> <?php if(strlen($post->post_title) > 25){ $dot= '...'; echo esc_attr( mb_substr($post->post_title, 0 ,25).$dot); }else{ echo esc_attr($post->post_title); } ?></a>
                                <div class="item-meta"><span class="activity">
                                    <?php $members = blackfyre_return_number_of_members($post->ID); ?>
            <?php if($members == 1){ echo esc_attr($members); ?>&nbsp;<?php esc_html_e('Member','blackfyre'); }else{ echo esc_attr($members); ?>&nbsp;<?php esc_html_e('Members','blackfyre'); } ?></span></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>

                </li>
       <?php } ?>

       </ul>
<div class="clear"></div>
    <?php } else { ?>
        <div class="error_msg"><span><?php  esc_html_e('There are no clans at the moment!', 'blackfyre'); ?> </span></div>
    <?php } ?>

    <?php wp_reset_postdata(); ?>

    <?php previous_posts_link('&laquo; ' . esc_html__('Previous page', 'blackfyre')) ?>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <?php next_posts_link(esc_html__('Next page', 'blackfyre') . ' &raquo;', $the_query->max_num_pages) ?>

<?php }


function blackfyre_all_clans_pagination_v2_ajax(){
    $_POST['href'] = str_replace('?','', $_POST['href']);
    parse_str($_POST['href'], $_GET);
    blackfyre_all_clans_pagination_v2($_GET['page'], $_GET['term']);
    die();
}

function blackfyre_all_clans_pagination_v2($page=1, $term=''){
    global $wpdb;

    $post_per_page = 40;
    $offset = ($page -1) * $post_per_page;

    $query = "
    SELECT SQL_CALC_FOUND_ROWS *
    FROM {$wpdb->posts} WHERE 1=1
    AND post_type = 'clan'
    AND post_name LIKE '%{$term}%'
    AND (post_status = 'publish' OR post_status = 'closed')
    ORDER BY post_name ASC
    LIMIT {$offset}, {$post_per_page}
    ";

    $results = $wpdb->get_results( $query);

    $res_count = (int) $wpdb->get_var( "SELECT FOUND_ROWS()" );

    include "addons/pagination/pagination.class.php";
    $p = new blackfyre_pagination;
    $p->items($res_count);
    $p->limit($post_per_page);

    $p->parameterName("page");
    $p->currentPage(isset($_GET['page'])?$_GET['page']:1);
    unset($_GET['page']);
    $_GET['term'] = $term;
    $p->target("?".http_build_query($_GET));

    #$p->parameterName('paged');
    #$p->currentPage($paged);
    #$p->target("?term={$term}");


    $p->nextLabel(esc_html__('Next','blackfyre'));
    $p->prevLabel(esc_html__('Previous','blackfyre'));


    if ( $results ) { ?>

       <ul id="members-list" class="item-list" >
       <?php foreach ( $results as $post ) { ?>
            <li>
                    <div class="clan-list-wrapper">
                        <div class="item-avatar">
                           <a href="<?php echo esc_url(get_permalink($post->ID)); ?> ">
                             <?php $img = get_post_meta( $post->ID, 'clan_photo', true );
                                   $image = blackfyre_aq_resize( $img, 50, 50, true, true, true );
                                   if(!$image){
                                       $image = esc_url(get_template_directory_uri()).'/img/defaults/default-clan-50x50.jpg';
                                   }
                                   ?>
                            <img alt="img" src="<?php echo esc_url($image); ?>" class="avatar" >
                           </a>
                        </div>

                        <div class="item">
                            <div class="item-title">
                                <a href="<?php echo esc_url(get_permalink($post->ID)); ?> "> <?php if(strlen($post->post_title) > 25){ $dot= '...'; echo esc_attr( mb_substr($post->post_title, 0 ,25).$dot); }else{ echo esc_attr($post->post_title); } ?></a>

                                <div class="item-meta">
                                    <span class="activity">
                                        <?php $members = blackfyre_return_number_of_members($post->ID); ?>
                                        <?php if($members == 1){
                                            echo esc_attr($members); ?>&nbsp;<?php esc_html_e('Member','blackfyre');
                                        }else{
                                            echo esc_attr($members); ?>&nbsp;<?php esc_html_e('Members','blackfyre');
                                        } ?>
                                    </span></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>

                </li>
       <?php } ?>

       </ul>
<div class="clear"></div>
    <?php } else { ?>
        <div class="error_msg"><span><?php esc_html_e('There are no clans at the moment!', 'blackfyre'); ?> </span></div>
    <?php } ?>


    <?php $p->show();

}

/**************************************** /All clans page pagination and search**********************************************/


function skywarrior_buddypress_avatar( $url ){
    $uid = get_current_user_id();
    $url0 = get_user_meta($uid, 'profile_photo', true);
     if(!empty($url0)){
       $url1 = blackfyre_aq_resize( $url0, 50, 50, true, '', true );
       $url = $url1[0];  //resize & crop img
     }
     if(empty($url)){ $url = get_template_directory_uri().'/img/defaults/default_profile55x55.png'; }
     return $url;

}

function skywarrior_bpfr_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('user-admin'); // change to your need
    }


function blackfyre_bp_directory_members_search_form() {

    $query_arg = bp_core_get_component_search_query_arg( 'members' );

    if ( ! empty( $_REQUEST[ $query_arg ] ) ) {
        $search_value = stripslashes( $_REQUEST[ $query_arg ] );
    } else {
        $search_value = bp_get_search_default_text( 'members' );
    }

    $search_form_html = '<form action="" method="get" id="search-members-form">
        <label for="members_search"><input type="text" name="' . esc_attr( $query_arg ) . '" id="members_search" placeholder="'. esc_attr( $search_value ) .'" /></label>
        <input type="submit" id="members_search_submit" name="members_search_submit" value="' . __( 'Search', 'buddypress' ) . '" />
    </form>';
  return $search_form_html;
}

/*buddypress friends ajax*/
function skywarrior_bp_legacy_theme_ajax_addremove_friend() {

    // Bail if not a POST action
    if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) )
        return;

    // Cast fid as an integer
    $friend_id = (int) $_POST['fid'];

    // Trying to cancel friendship
    if ( 'is_friend' == BP_Friends_Friendship::check_is_friend( bp_loggedin_user_id(), $friend_id ) ) {
        check_ajax_referer( 'friends_remove_friend' );

        if ( ! friends_remove_friend( bp_loggedin_user_id(), $friend_id ) ) {
            echo esc_html__( 'Friendship could not be canceled.', 'blackfyre' );
        } else {
            echo '<a id="friend-' . esc_attr( $friend_id ) . '" class="add friendship-button add-friend" rel="add" title="' . esc_html__( 'Add as a Friend', 'blackfyre' ) . '" href="' . wp_nonce_url( bp_loggedin_user_domain() . bp_get_friends_slug() . '/add-friend/' . $friend_id, 'friends_add_friend' ) . '"><i class="fa fa-user"></i>' . esc_html__( 'Add as a friend!', 'blackfyre' ) . '</a>';
        }

    // Trying to request friendship
    } elseif ( 'not_friends' == BP_Friends_Friendship::check_is_friend( bp_loggedin_user_id(), $friend_id ) ) {
        check_ajax_referer( 'friends_add_friend' );

        if ( ! friends_add_friend( bp_loggedin_user_id(), $friend_id ) ) {
            echo esc_html__(' Friendship could not be requested.', 'blackfyre' );
        } else {
            echo '<a id="friend-' . esc_attr( $friend_id ) . '" class="remove friendship-button pending_friend requested add-friend" rel="remove" title="' . esc_html__( 'Cancel Request', 'blackfyre' ) . '" href="' . wp_nonce_url( bp_loggedin_user_domain() . bp_get_friends_slug() . '/requests/cancel/' . $friend_id . '/', 'friends_withdraw_friendship' ) . '" class="requested"><i class="fa fa-times" data-original-title="'.esc_html__("Cancel request!", "blackfyre").'" data-toggle="tooltip"></i>'.esc_html__(' Cancel request!', 'blackfyre').'</a>';
        }

    // Trying to cancel pending request
    } elseif ( 'pending' == BP_Friends_Friendship::check_is_friend( bp_loggedin_user_id(), $friend_id ) ) {
        check_ajax_referer( 'friends_withdraw_friendship' );

        if ( friends_withdraw_friendship( bp_loggedin_user_id(), $friend_id ) ) {
            echo '<a id="friend-' . esc_attr( $friend_id ) . '" class="add friendship-button add-friend" rel="add" title="' . esc_html__( 'Add as a friend', 'blackfyre' ) . '" href="' . wp_nonce_url( bp_loggedin_user_domain() . bp_get_friends_slug() . '/add-friend/' . $friend_id, 'friends_add_friend' ) . '"><i class="fa fa-user"></i>' . esc_html__( 'Add as a friend!', 'blackfyre' ) . '</a>';
        } else {
            echo esc_html__("Friendship request could not be cancelled.", 'blackfyre');
        }

    // Request already pending
    } else {
        echo esc_html__( 'Request Pending', 'blackfyre' );
    }

    exit;
}

/*add clan creation field to user profile*/
function skywarrior_clan_extra_user_profile_fields( $user ) { ?>
<h3><?php esc_html_e("Clan creation", "blackfyre"); ?></h3>
<table class="form-table">
<tr>
<th><label for="clan_account"><?php esc_html_e("Allow user to create clans", 'blackfyre'); ?></label>
</th>
<td>
<input type="checkbox" name="_checkbox_clan_user" id="_checkbox_clan_user" value="yes" <?php if (esc_attr( get_the_author_meta( "_checkbox_clan_user", $user->ID )) == "yes") echo "checked"; ?> />
<br />
</td>
</tr>
</table>



<h3><?php esc_html_e("Activate user", "blackfyre"); ?></h3>
<table class="form-table">
<tr>
<th><label for="user_active"><?php esc_html_e("Make this user active", 'blackfyre'); ?></label>
</th>
<td>
<input type="checkbox" name="_checkbox_user_active" id="_checkbox_user_active" value="true" <?php if (esc_attr( get_the_author_meta( "active", $user->ID )) == "true") echo "checked"; ?> />
<br />
</td>
</tr>
</table>
<?php }


function save_skywarrior_clan_extra_user_profile_fields( $user_id ) {
if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
update_user_meta( $user_id, '_checkbox_clan_user', $_POST['_checkbox_clan_user'] );
if(empty($_POST['_checkbox_user_active']))$_POST['_checkbox_user_active']= 'false';
update_user_meta( $user_id, 'active', $_POST['_checkbox_user_active'] );
}

function skywarrior_turn_secondary_avatars_to_links( $avatar ) {
global $activities_template;

switch ( $activities_template->activity->component ) {
case 'groups' :
$item_id = $activities_template->activity->item_id;
$group = groups_get_group( array( 'group_id' => $item_id ) );
$url = apply_filters( 'bp_get_group_permalink', trailingslashit( bp_get_root_domain() . '/' . bp_get_groups_root_slug() . '/' . $group->slug . '/' ) );
break;
case 'blogs' :
break;
case 'friends' :
$item_id = $activities_template->activity->secondary_item_id;
$url = bp_core_get_user_domain($item_id);
$avatar = get_avatar((int)$activities_template->activity->secondary_item_id, 20,null,'" class="avatar user-4-avatar avatar-20 photo');
break;
default :
break;

}
if ( !empty( $url ) ) {
$avatar = '' . $avatar . '';
}
return $avatar;
}

// define the bp_core_fetch_avatar callback
function filter_bp_core_fetch_avatar( $jfb_bp_avatar, $number, $number1 )
{
    if($number['object'] == 'group'){
    $avatar_options = array ( 'item_id' => $number['item_id'], 'object' => $number['object'], 'type' => $number['type'], 'avatar_dir' => $number['avatar_dir'], 'alt' => $number['alt'], 'class' => $number['class'], 'width' => $number['width'], 'height' => $number['height'], 'html' => false );
    $result = bp_core_fetch_avatar($avatar_options);

    return '<img src="'.$result.'" width="'.$number['width'].'" height="'.$number['height'].'" alt="'.$number['alt'].'" />';
    }else{

    $uid = $number['item_id'];

    $custom_avatar = get_the_author_meta('profile_photo', $uid);
    $check_new = get_the_author_meta('check_profile_photo', $uid);

    if ($check_new == true) {
        $src = (string) reset(simplexml_import_dom(DOMDocument::loadHTML($jfb_bp_avatar))->xpath("//img/@src"));
        $custom_avatar = $src;
        delete_user_meta($uid, 'check_profile_photo');
        update_user_meta($uid, 'profile_photo', $src);
    }

    if ($number['html'] == 1) {
        if (strlen($custom_avatar) > 1)
            $returner = '<img src="'.$custom_avatar.'" width="'.$number['width'].'" height="'.$number['height'].'" alt="'.$number['alt'].'" />';
        else
            $returner = '<img src="'.get_template_directory_uri().'/img/defaults/default-profile.jpg" width="'.$number['width'].'" height="'.$number['height'].'" alt="'.$number['alt'].'" />';
    } else {
        if (strlen($custom_avatar) > 1)
            $returner = $custom_avatar;
        else
            $returner = get_template_directory_uri().'/img/defaults/default-profile.jpg';
    }
    return $returner;
    }
};

/*avatars fix*/
function blackfyre_update_avatar_admin(){
    $userid = get_current_user_id();
    update_user_meta($userid,'check_profile_photo',true);
}

/*return author using post id*/

function skywarrior_get_author( $post_id = 0 ){
     $post = get_post( $post_id );
     return $post->post_author;
}


/*************************************ROLES****************************************************/



/*hide admin bar for all users except admin*/
function skywarrior_admin_bar(){

    if (of_get_option('admin_toolbar') == '0' ) {
        show_admin_bar(false);
    }elseif( wp_get_current_user()->roles[0] != 'administrator' && wp_get_current_user()->roles[0] != 'author' && wp_get_current_user()->roles[0] != 'editor' && wp_get_current_user()->roles[0] != 'contributor' ){
        show_admin_bar(false);
    }

}
add_action( 'after_setup_theme' , 'skywarrior_admin_bar');

/*remove menus for non admins*/
function skywarrior_remove_menus(){

  if (!current_user_can('administrator') && !current_user_can('editor') && !current_user_can('author')) {
  remove_menu_page( 'index.php' );                      //Dashboard
  remove_menu_page( 'edit.php' );                       //Posts
  remove_menu_page( 'upload.php' );                     //Media
  remove_menu_page( 'edit.php?post_type=page' );        //Pages
  remove_menu_page( 'edit.php?post_type=slider' );      //Slider
  remove_menu_page( 'edit.php?post_type=clan' );        //Clans
  remove_menu_page( 'edit-comments.php' );              //Comments
  remove_menu_page( 'themes.php' );                     //Appearance
  remove_menu_page( 'plugins.php' );                    //Plugins
  remove_menu_page( 'users.php' );                      //Users
  remove_menu_page( 'tools.php' );                      //Tools
  remove_menu_page( 'options-general.php' );            //Settings
  }
}

/*disable update notifications*/
function skywarrior_update_nag() {
  if (!current_user_can('administrator')) {
    remove_action( 'admin_notices', 'update_nag', 3 );

  }
}

function blackfyre_endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}


/*restrict admi naccess for non admins*/
function skywarrior_restrict_admin() {
    $user = new WP_User( get_current_user_id() );
    if (isset($_POST['_wp_http_referer'])) {
        $referer = $_POST['_wp_http_referer'];
    } else {
        $referer = "";
        if (strpos($_SERVER['REQUEST_URI'], "action=edit") !== false) {
            $referer = '   post_type=clan    ';
        }
    }
    if ( !current_user_can( 'manage_options' ) ) {
        if ( in_array( 'gamer', (array) $user->roles ) ) {
            //is a gamer
            if((strpos($_SERVER['REQUEST_URI'], "post_type=clan") === false) && (strpos($referer, "post_type=clan") === false) && (strpos($_SERVER['REQUEST_URI'], "admin-ajax.php") === false)  && ((strpos($_SERVER['REQUEST_URI'], "post.php") !== false) && (strpos($_SERVER['REQUEST_URI'], "image-editor") !== false) ) ) {
                //default check for rest of shit
                wp_die( esc_html__('You are not allowed to access this part of the site ', 'blackfyre').$_SERVER['REQUEST_URI']);
            } else {
                $holder = explode ('/', $_SERVER['REQUEST_URI'] );
                if (strlen($holder[count($holder) -1 ]) < 3 ) {
                    wp_die( esc_html__('You are not allowed to access this part of the site ', 'blackfyre').$_SERVER['REQUEST_URI']);
                } elseif ((strpos($holder[count($holder) -1 ], '-new') !== false) AND (strpos($referer, "post_type=clan") === false)) {
                        wp_die( esc_html__('You are not allowed to access this part of the site ', 'blackfyre').$_SERVER['REQUEST_URI']);
                    }
                else{
                    if(blackfyre_endsWith($_SERVER['REQUEST_URI'], "edit.php")){
                        wp_die( esc_html__('You are not allowed to access this part of the site ', 'blackfyre').$_SERVER['REQUEST_URI']);
                    }
                }
            }
        } elseif((strpos($_SERVER['REQUEST_URI'], "post_type=clan") === false) && (strpos($referer, "post_type=clan") === false)&& (strpos($_SERVER['REQUEST_URI'], "admin-ajax.php") === false)  && ((strpos($_SERVER['REQUEST_URI'], "post.php") !== false) && (strpos($_SERVER['REQUEST_URI'], "image-editor") !== false) ) ) {
         wp_die( esc_html__('You are not allowed to access this part of the site ', 'blackfyre').$_SERVER['REQUEST_URI']);
       }
    } else {
        if ( in_array( 'gamer', (array) $user->roles ) ) {
            //is a gamer
            if((strpos($_SERVER['REQUEST_URI'], "post_type=clan") === false) && (strpos($referer, "post_type=clan") === false)&& (strpos($_SERVER['REQUEST_URI'], "admin-ajax.php") === false)  && ((strpos($_SERVER['REQUEST_URI'], "post.php") !== false) && (strpos($_SERVER['REQUEST_URI'], "image-editor") !== false) ) ) {
                //default check for rest of shit
                wp_die( esc_html__('You are not allowed to access this part of the site ', 'blackfyre').$_SERVER['REQUEST_URI']);
            }
        }
    }
}


/*Set default role on new users register*/
function blackfyre_defaultrole($default_role){
    return 'gamer'; // This is changed
    return $default_role; // This allows default
}

function add_theme_caps() {
    // gets the author role
    $role = get_role( 'gamer' );
    $role->add_cap( 'delete_posts' );
    $role->add_cap( 'delete_published_posts ' );
    $role->add_cap( 'edit_pages' );
    $role->add_cap( 'edit_posts' );
    $role->add_cap( 'edit_published_pages' );
    $role->add_cap( 'edit_others_pages' );
    $role->add_cap( 'edit_others_posts' );
    $role->add_cap( 'level_0' );
    $role->add_cap( 'level_1' );
    $role->add_cap( 'level_2' );
    $role->add_cap( 'level_3' );
    $role->add_cap( 'level_4' );
    $role->add_cap( 'publish_pages' );
    $role->add_cap( 'publish_posts' );
    $role->add_cap( 'read' );
    $role->add_cap( 'upload_files' );
}



add_role( 'gamer', 'Gamer',  array(
        'read'         => true,  // true allows this capability
        'edit_posts'   => true,
        'delete_posts' => true,
        'publish_posts' => true,
        'upload_files'  => true,
        'edit_others_pages' => true,
        'edit_published_posts' => true,
        'delete_published_posts' => true,
    ) );


/*******open comments *********/
function blackfyre_comments_open( $open, $post_id ) {

    $post = get_post( $post_id );
    if(! empty($post) && is_a($post, 'WP_Post')){
    if ( 'clan' == $post->post_type or 'matches' == $post->post_type)
        $open = true;
    return $open;
    }
}

function blackfyre_comments_on( $data ) {
    if( $data['post_type'] == 'clan' ) {
        $data['comment_status'] = 'open';
    }

    return $data;
}

function skywarrior_matches_comments_on( $data ) {
    if( $data['post_type'] == 'matches' ) {
        $data['comment_status'] = 'open';
    }

    return $data;
}

function skywarrior_matches_edit_comments_on( $data ) {
    if( $data['post_type'] == 'matches' ) {
        $data['comment_status'] = 'open';
    }

    return $data;
}


function skywarrior_get_id_by_slug($page_slug) {
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}

/*add nickname columns to user listing*/
function skywarrior_load_sortable_user_meta_columns(){
//THIS IS WHERE YOU ADD THE meta_key => display-title values
$args = array('nickname'=> esc_html__('Nickname', 'blackfyre'), 'user_registered'=>esc_html__('Date Registered', 'blackfyre'));
new sortable_user_meta_columns($args);
}

class sortable_user_meta_columns{
var $defaults = array('nicename', 'email', 'url', 'registered','user_nicename', 'user_email', 'user_url', 'user_registered','display_name','name','post_count','ID','id','user_login');
function __construct($args){
$this->args = $args;
add_action('pre_user_query', array(&$this, 'query'));
add_action('manage_users_custom_column', array(&$this, 'content'), 10, 3);
add_filter('manage_users_columns', array(&$this, 'columns'));
add_filter( 'manage_users_sortable_columns', array(&$this, 'sortable') );
}
function query($query){
$vars = $query->query_vars;
if(in_array($vars['orderby'], $this->defaults)) return;
$title = $this->args[$vars['orderby']];
if(!empty($title)){
$query->query_from .= " LEFT JOIN wp_usermeta m ON (wp_users.ID = m.user_id AND m.meta_key = '$vars[orderby]')";
$query->query_orderby = "ORDER BY m.meta_value ".$vars['order'];
}
}
function columns($columns) {
foreach($this->args as $key=>$value){
$columns[$key] = $value;
}
return $columns;
}
function sortable($columns){
foreach($this->args as $key=>$value){
$columns[$key] = $key;
}
return $columns;
}
function content($value, $column_name, $user_id) {
$user = get_userdata( $user_id );
return $user->$column_name;
}
}


/*
Register Fonts
*/
function blackfyre_fonts_url() {
    $font_url = '';

    /*
    Translators: If there are characters in your language that are not supported
    by chosen font(s), translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'blackfyre' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Oswald:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic
        |Roboto:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic
        |Open+Sans:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic' ), "//fonts.googleapis.com/css" );
    }
    return $font_url;
}


/*add vc tempaltes*/

function vc_remove_be_pointers() {
   remove_action( 'admin_init', 'vc_add_admin_pointer' );
}

function vc_remove_fe_pointers() {
   remove_action( 'admin_init', 'vc_frontend_editor_pointer' );
}


if(is_plugin_active('js_composer/js_composer.php')){


class WPBakeryShortCode_VC_Column_news extends WPBakeryShortCode {}
class WPBakeryShortCode_VC_Column_news_tabbed extends WPBakeryShortCode {}
class WPBakeryShortCode_VC_Column_news_horizontal extends WPBakeryShortCode {}
class WPBakeryShortCode_VC_Column_blog extends WPBakeryShortCode {}
class WPBakeryShortCode_VC_Column_boxed_text extends WPBakeryShortCode {}
class WPBakeryShortCode_VC_contact extends WPBakeryShortCode {}
class WPBakeryShortCode_VC_comments extends WPBakeryShortCode {}
class WPBakeryShortCode_VC_social extends WPBakeryShortCode {}
class WPBakeryShortCode_VC_clan_games extends WPBakeryShortCode {}
class WPBakeryShortCode_VC_clans extends WPBakeryShortCode {}
class WPBakeryShortCode_VC_members_clan_page extends WPBakeryShortCode {}
class WPBakeryShortCode_VC_hover_image extends WPBakeryShortCode {}
class WPBakeryShortCode_VC_latest_matches extends WPBakeryShortCode {}
class WPBakeryShortCode_VC_popular_posts extends WPBakeryShortCode {}

function blackfyre_custom_template_for_vc($data) {
/** Clan Page template */
$template               = array();
$template['name']       = esc_html__( 'Clan Page', 'blackfyre' );
$template['image_path'] = vc_asset_url( 'vc/templates/feature_list.png' );
$template['custom_class'] = 'vc_default_template-999999';
$template['content']    = <<<CONTENT
[vc_row][vc_column width="2/3"][vc_column_boxed_text el_text_title="About us"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse egestas rhoncus nisi ut ullamcorper. Aenean facilisis venenatis justo eu rhoncus. Integer facilisis faucibus lacus, non eleifend tellus. Maecenas eu pulvinar tellus. Curabitur mollis urna elit, vitae suscipit quam aliquet ut. Aenean lobortis dui mi, eget accumsan ipsum suscipit egestas. Vivamus ut porttitor erat. Donec hendrerit vulputate condimentum. Nullam sit amet nunc felis. Etiam non magna sit amet leo elementum accumsan sed nec ante. Pellentesque consequat malesuada mollis.

Phasellus efficitur dolor nec felis auctor, eu lacinia quam aliquet. Praesent nec rhoncus augue. Donec tempor dolor sit amet dui aliquam elementum. Cras varius laoreet neque in ultrices. Nulla fringilla massa interdum diam vestibulum bibendum. Sed viverra egestas augue et finibus. Fusce id urna magna. Aliquam erat volutpat. Nullam venenatis tempor velit, vel lacinia justo condimentum in. Curabitur mollis urna elit, vitae suscipit quam aliquet ut. Aenean lobortis dui mi, eget accumsan ipsum suscipit egestas. Vivamus ut porttitor erat. Donec hendrerit vulputate condimentum. Nullam sit amet nunc felis. Etiam non magna sit amet leo elementum accumsan sed nec ante. Pellentesque consequat malesuada mollis.[/vc_column_boxed_text][vc_comments el_comments_title="Clan Discussion"][/vc_column][vc_column width="1/3"][vc_members_clan_page el_countries="United Kingdom" el_languages="English" el_link_text1="Official site" el_link1="http://skywarriorthemes11.com" el_link_text2="Buy us a coffee!" el_link2="http://skywarriorthemes22.com"][vc_clan_games el_games_title="games"][vc_latest_matches el_matches_title="Latest matches"][/vc_column][/vc_row][vc_row][vc_column][/vc_column][/vc_row]
CONTENT;

array_unshift( $data, $template );
return $data;
}

}

/*check if user is active*/
function blackfyre_user_active_check($user_login, $user){
    $active = get_user_meta($user->ID, 'active', true);
    if(!in_array('administrator',$user->roles)){
        if( $active == 'false'){
            wp_logout();
            wp_redirect(esc_url(blackfyre_get_permalink_for_template('page-user-activation')).'?act_error=1');
            exit();
        }
    }
}

/*cut content withour breaking html*/
function blackfyre_html_cut($text, $max_length)
{
    $tags   = array();
    $result = "";

    $is_open   = false;
    $grab_open = false;
    $is_close  = false;
    $in_double_quotes = false;
    $in_single_quotes = false;
    $tag = "";

    $i = 0;
    $stripped = 0;

    $stripped_text = strip_tags($text);

    while ($i < strlen($text) && $stripped < strlen($stripped_text) && $stripped < $max_length)
    {
        $symbol  = $text{$i};
        $result .= $symbol;

        switch ($symbol)
        {
           case '<':
                $is_open   = true;
                $grab_open = true;
                break;

           case '"':
               if ($in_double_quotes)
                   $in_double_quotes = false;
               else
                   $in_double_quotes = true;

            break;

            case "'":
              if ($in_single_quotes)
                  $in_single_quotes = false;
              else
                  $in_single_quotes = true;

            break;

            case '/':
                if ($is_open && !$in_double_quotes && !$in_single_quotes)
                {
                    $is_close  = true;
                    $is_open   = false;
                    $grab_open = false;
                }

                break;

            case ' ':
                if ($is_open)
                    $grab_open = false;
                else
                    $stripped++;

                break;

            case '>':
                if ($is_open)
                {
                    $is_open   = false;
                    $grab_open = false;
                    array_push($tags, $tag);
                    $tag = "";
                }
                else if ($is_close)
                {
                    $is_close = false;
                    array_pop($tags);
                    $tag = "";
                }

                break;

            default:
                if ($grab_open || $is_close)
                    $tag .= $symbol;

                if (!$is_open && !$is_close)
                    $stripped++;
        }

        $i++;
    }

    while ($tags)
        $result .= "</".array_pop($tags).">";

    return $result;
}


/**
 * Your theme callback function
 *
 * @see bp_legacy_theme_cover_image() to discover the one used by BP Legacy
 */
function balckfyre_cover_image_callback( $params = array() ) {
    if ( empty( $params ) ) {
        return;
    }
        if(!empty($params["height"])){
        echo '<style>
            /* Cover image - Do not forget this part */
            #buddypress #header-cover-image {
                height: ' . $params["height"] . 'px;
                background-image: url(' . $params['cover_image'] . ');
                background-position: center top;
                background-repeat: no-repeat;
                background-size: cover;
                border: 0;
                display: block;
                left: 0;
                margin: 0;
                padding: 0;
                position: absolute;
                top: 0;
                width: 100%;
            }

            .group-create  #buddypress #header-cover-image {
                position: relative !important;
            }
            </style>
        ';
    }
}

function blackfyre_cover_image_css( $settings = array() ) {
    $settings['callback'] = 'balckfyre_cover_image_callback';

    return $settings;
}

/*registration page redirection*/
function blackfyre_register_page( $register_url ) {
return home_url( '/user-registration/' );
}





function blackfyre_return_team_win_lose_score($team_id){

    global $wpdb;
    $table = $wpdb->prefix."cw_matches";
    $table2 = $wpdb->prefix."cw_rounds";
    $matches1 =     $wpdb->get_results($wpdb->prepare( "SELECT * FROM $table WHERE `team1` = %s", $team_id));
    $matches2 =     $wpdb->get_results($wpdb->prepare( "SELECT * FROM $table WHERE `team2` = %s", $team_id));

    $won = 0;
    $lost = 0;
    $overall = 0;

    if(!empty($matches1)){
        foreach ($matches1 as $match1) {
            $rounds1 = $wpdb->get_results($wpdb->prepare( "SELECT matches.id, SUM(round.tickets1) as suma1, SUM(round.tickets2) as suma2 FROM $table matches LEFT JOIN $table2 round  ON matches.id = round.match_id WHERE `match_id` = %s AND `status` = 'done'", $match1->id));
            if($rounds1[0]->suma1 > $rounds1[0]->suma2 )$won++;
            if($rounds1[0]->suma1 < $rounds1[0]->suma2 )$lost++;
        }
    }

    if(!empty($matches2)){
        foreach ($matches2 as $match2) {
            $rounds2 = $wpdb->get_results($wpdb->prepare( "SELECT matches.id, SUM(round.tickets1) as suma1, SUM(round.tickets2) as suma2 FROM $table matches LEFT JOIN $table2 round  ON matches.id = round.match_id WHERE `match_id` = %s AND `status` = 'done'", $match2->id));
            if($rounds2[0]->suma1 < $rounds2[0]->suma2 )$won++;
            if($rounds2[0]->suma1 > $rounds2[0]->suma2 )$lost++;
        }
    }

    $overall = $won - $lost;
    return $overall;

}


function blackfyre_check_if_clanname_unique() {
    $value = trim(sanitize_text_field($_POST['currentText']));
    $post = get_page_by_title( $value, 'OBJECT', 'clan' );


    if ($post != NULL) {
        echo "/*-notunique*-/";
    } else {
        echo $value;
    }


    wp_die();
}

function blackfyre_sort_objects_by_score($a, $b)
            {
                if($a->score == $b->score){ return 0 ; }
                return ($a->score > $b->score) ? -1 : 1;
            }

function blackfyre_is_user_in_game ($gid, $uid) {
  global $wpClanWars;
  $game = $wpClanWars->get_match(array('id' => $gid));

  $clan1 = $game[0]->team1;
  $clan2 = $game[0]->team2;

  $clan1_id = blackfyre_return_team_post__by_team_id($clan1);
  $clan2_id = blackfyre_return_team_post__by_team_id($clan2);

    if( (blackfyre_is_admin($clan1_id->post_id, $uid) || blackfyre_is_admin($clan2_id->post_id, $uid) )
        || (blackfyre_is_super_admin($clan1_id->post_id, $uid) || blackfyre_is_super_admin($clan2_id->post_id, $uid))
        || ( blackfyre_is_user($clan1_id->post_id, $uid) ||  blackfyre_is_user($clan2_id->post_id, $uid))
        ){
        return true;
      }


  return false;
}


function blackfyre_is_val_exists($needle, $haystack) {

     if(in_array($needle, $haystack)) {
          return true;
     }

     foreach($haystack as $element) {
          if(is_array($element) && blackfyre_is_val_exists($needle, $element))
               return true;
     }
   return false;
}

function blackfyre_challenge_email($user_id, $post_id){
$user_data = get_userdata($user_id);
$pageurl = get_permalink($post_id);
$subject = esc_html__("New challenge! On: ","blackfyre").get_bloginfo();
$message .= "\n\n";
$message .= esc_html__("Please visit this link to view and manage this challenge: ","blackfyre");
$message .= esc_url($pageurl);
$headers = "From: ".get_bloginfo()." <".get_option('admin_email').">\r\n Reply-To: ". $user_data->user_email;
wp_mail( $user_data->user_email, $subject, $message, $headers );
}

function blackfyre_request_email($user_id, $post_id){
    $current_user = wp_get_current_user();
    $pageurl = get_permalink($post_id);

    $user_data = get_userdata($user_id);
    $subject = esc_html__("New join request! On: ","blackfyre").get_bloginfo();
    $message = esc_html__("User","blackfyre").' '.esc_attr($current_user->display_name).' '.esc_html__("wants to join your team!","blackfyre");
    $message .= "\n\n";
    $message .= esc_html__("Please click this link to view: ","blackfyre");
    $message .= esc_url($pageurl);
    $headers = "From: ".get_bloginfo()." <".get_option('admin_email').">\r\n Reply-To: ". $user_data->user_email;
    wp_mail( $user_data->user_email, $subject, $message, $headers );
}
function blackfyre_dateFormatTojQuery($dateFormat) {
    $chars = array(
        'd' => 'dd', 'j' => 'd', 'l' => 'DD', 'D' => 'D',
        'm' => 'mm', 'n' => 'm', 'F' => 'MM', 'M' => 'M',
        'Y' => 'yy', 'y' => 'y',
    );
    return strtr((string)$dateFormat, $chars);
}


function blackfyre_clan_image_metabox () {
    add_meta_box( 'clanimage', __( 'Clan Images', 'blackfyre' ), 'blackfyre_clan_image_metabox_callback', 'clan', 'side', 'low');
}

function blackfyre_clan_image_metabox_callback ( $post ) {

    wp_nonce_field( basename( __FILE__ ), 'clanimage_nonce' );

    $clan_bg = get_post_meta( $post->ID, 'clan_bg', true );
    $clan_bg_url = wp_get_attachment_url($clan_bg);
    $clan_photo = get_post_meta( $post->ID, 'clan_photo', true );

    if ( !did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }
?>
    <p class="upload"><label>Clan Photo</label><br />
        <img src="<?php echo $clan_photo; ?>" class="preview-upload"/>
        <input type="text" class="hidden" name="clan_photo" value="<?php echo $clan_photo; ?>"/>
        <button type="submit" class="upload_image_button button"><?php esc_html_e("Upload Image", "blackfyre"); ?></button>
        <button type="submit" class="remove_image_button button">&times;</button>
    </p>
    <p class="upload"><label>Clan Background</label><br />
        <img src="<?php echo $clan_bg_url; ?>" class="preview-upload"/>
        <input type="text" class="hidden" name="clan_bg" value="<?php echo $clan_bg; ?>"/>
        <button type="submit" class="upload_image_button button imgid"><?php esc_html_e("Upload Image", "blackfyre"); ?></button>
        <button type="submit" class="remove_image_button button">&times;</button>
    </p>

<script type="text/javascript">
jQuery(function($) {

    // the upload image button, saves the id and outputs a preview of the image
 $('.upload_image_button').click(function(){
    var button = $(this);
    var myuploader = wp.media(
    {
        title : 'Select Image',
        button : {
            text : 'Insert',
        },
        multiple : false
    })

    .on('select', function()
    {
    attachment = myuploader.state().get('selection').first().toJSON();

            if($(button).hasClass("imgid")) {
                $(button).parent('.upload').find('input[type=text]').val(attachment.id);
            } else {
                $(button).parent('.upload').find('input[type=text]').val(attachment.url);
            }
            $(button).parent('.upload').find('img').attr('src', attachment.url);
            $(button).parent('.upload').find('img').show();

    })
    .open(button);

    return false;
});

    // the remove image link, removes the image id from the hidden field and replaces the image preview

    $('.remove_image_button').click(function(){

            $(this).parent('.upload').find('img').attr('src', '');
            $(this).parent('.upload').find('img').hide();
            $(this).parent('.upload').find('input[type=text]').val('');

        return false;
    });


});
</script>
<?php

}

function blackfyre_clan_image_metabox_save($post_id) {
  global $post;

    if ( ! current_user_can( 'edit_post', $post_id ) )
        return;

    if ( ! isset( $_POST['clanimage_nonce'] ) || ! wp_verify_nonce( $_POST['clanimage_nonce'], basename( __FILE__ ) ) )
        return;

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return;

    $post = get_post($post_id);
    if ($post->post_type == 'clan') {
        update_post_meta($post_id, 'clan_photo', esc_attr($_POST['clan_photo']));
        update_post_meta($post_id, 'clan_bg', $_POST['clan_bg']);
    }
    return $post_id;
}

function blackfyre_admin_notice__success1() {
if ( ! PAnD::is_admin_notice_active( 'notice-one-forever' ) ) {
        return;
    }

    ?>
    <div data-dismissible="notice-one-forever" class="updated notice notice-success is-dismissible notice premium-tournaments">
       <a target="_blank" href="https://www.skywarriorthemes.com/arcane-theme/"><img src="<?php echo get_template_directory_uri(); ?>/img/pb-t-img.png" /> <span><?php esc_html_e( 'Newest gaming theme', 'blackfyre' ); ?></span> <i>//</i> <strong><?php esc_html_e( 'Including tournaments, matches, teams and much more!', 'blackfyre' ); ?></strong></a>
    </div>
    <?php
}

/* Custom code goes above this line. */
?>