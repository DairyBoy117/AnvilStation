<?php
/**
* Plugin Name: Blackfyre types
* Plugin URI: http://skywarriorthemes.com/
* Description: Custom post types for BlackFyre theme.
* Version: 1.4
* Author: Skywarrior themes
* Author URI: http://www.skywarriorthemes.com/
* License: GPL
*/



class Blackfyre_Types {

    function __construct() {
        register_activation_hook( __FILE__,array( $this,'activate' ) );
        add_action( 'init', array( $this, 'blackfyre_create_post_types' ), 1 );
    }

    function activate() {
        $this->blackfyre_create_post_types();
    }

    function blackfyre_create_post_types() {

		 $labels = array(
        'name' => _x('Matches', 'post type general name','blackfyre'),
        'singular_name' => _x('Match', 'post type singular name','blackfyre'),
        'add_new' => _x('Add New', 'match item' ,'blackfyre'),
        'add_new_item' => __('Add New Match','blackfyre'),
        'edit_item' => __('Edit Match','blackfyre'),
        'new_item' => __('New Match','blackfyre'),
        'view_item' => __('View Match','blackfyre'),
        'search_items' => __('Search Matches','blackfyre'),
        'not_found' =>  __('Nothing found','blackfyre'),
        'not_found_in_trash' => __('Nothing found in Trash','blackfyre'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => plugin_dir_url(__FILE__). 'img/portfolio.png',
        'rewrite' => true,
        'capability_type' => 'post',
          'capabilities' => array(
            'create_posts' => false, // Removes support for the "Add New" function
          ),
        'map_meta_cap' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title','editor','thumbnail', 'comments')

      );
    register_post_type( 'matches' , $args );

	  $labels = array(
        'name' => 'All Slide',
        'menu_name' => 'Blackfyre Sliders',
        'add_new' => 'Add New Slider',
        'add_new_item' => 'Add New Slide',
        'edit_item' => 'Edit Slide'

    );
    $args = array(

        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Slideshows',
        'supports' => array('title'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'page'
    );
    register_post_type('slider', $args);

	  register_post_type( 'clan',
        array(
            'labels' => array(
                'name' => __( 'Clans', 'blackfyre' ),
                'singular_name' => __( 'Clan', 'blackfyre' )
            ),
        'supports' => array( 'title', 'editor', 'shortlinks', 'comments', 'author' ),
        'public' => true,
        'publicly_queryable' => true,
        'capability_type' => 'page',
        'rewrite' => true,
        'has_archive' => false,
        'query_var' => true,
        'menu_icon' => plugin_dir_url(__FILE__) . 'img/clans.png',
        )
    );


	register_post_type('pricetable',array(
		'labels' => array(
			'name' => __('Price Tables', 'blackfyre'),
			'singular_name' => __('Price Table', 'blackfyre'),
			'add_new' => __('Add New', 'blackfyre'),
			'add_new_item' => __('Add New Price Table', 'blackfyre'),
			'edit_item' => __('Edit Price Table', 'blackfyre'),
			'new_item' => __('New Price Table', 'blackfyre'),
			'all_items' => __('All Price Tables', 'blackfyre'),
			'view_item' => __('View Price Table', 'blackfyre'),
			'search_items' => __('Search Price Tables', 'blackfyre'),
			'not_found' =>  __('No Price Tables found', 'blackfyre'),
		),
		'public' => true,
		'capability_type' => 'page',
		'has_archive' => false,
		'supports' => array( 'title'),
		'menu_icon' => plugin_dir_url(__FILE__).'img/price_tables.png',
	));


	$labels = array(
		    'name' => __( 'Field&nbsp;Groups', 'blackfyre' ),
			'singular_name' => __( 'Advanced Custom Fields', 'blackfyre' ),
		    'add_new' => __( 'Add New' , 'blackfyre' ),
		    'add_new_item' => __( 'Add New Field Group' , 'blackfyre' ),
		    'edit_item' =>  __( 'Edit Field Group' , 'blackfyre' ),
		    'new_item' => __( 'New Field Group' , 'blackfyre' ),
		    'view_item' => __('View Field Group', 'blackfyre'),
		    'search_items' => __('Search Field Groups', 'blackfyre'),
		    'not_found' =>  __('No Field Groups found', 'blackfyre'),
		    'not_found_in_trash' => __('No Field Groups found in Trash', 'blackfyre'),
		);

		register_post_type('blackfyre', array(
			'labels' => $labels,
			'public' => false,
			'show_ui' => true,
			'_builtin' =>  false,
			'capability_type' => 'page',
			'hierarchical' => true,
			'rewrite' => false,
			'query_var' => "acf",
			'supports' => array(
				'title',
			),
			'show_in_menu'	=> false,
		));




	register_post_type( 'optionsframework', array(
			'labels' => array(
				'name' => __( 'Options Framework Internal Container' , 'blackfyre'),
			),
			'public' => true,
			'show_ui' => false,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => false,
			'supports' => array( 'title', 'editor' ),
			'query_var' => false,
			'can_export' => true,
			'show_in_nav_menus' => false
		) );


		$check = $this::skywarrior_post_by_title('Image ');
		if ( is_admin() && empty($check)) {

    $post = array(
      'post_content'   => '',
      'post_name'      => 'acf_image',
      'post_title'     => 'Image ',
      'post_status'    =>'publish',
      'post_type'      => 'blackfyre',
      'post_author'    => 1,
      'ping_status'    =>'closed',
      'post_parent'    => 0,
      'menu_order'     => 0,
      'comment_status' => 'closed'
    );

    $post_ID = wp_insert_post( $post );

     add_post_meta($post_ID, 'field_53f5d4c019b0c', 'a:13:{s:3:"key";s:19:"field_53f5d4c019b0c";s:5:"label";s:13:"Slider images";s:4:"name";s:13:"slider_images";s:4:"type";s:8:"repeater";s:12:"instructions";s:0:"";s:8:"required";s:1:"0";s:10:"sub_fields";a:2:{i:0;a:12:{s:3:"key";s:19:"field_53f5fbbfce05e";s:5:"label";s:12:"Slider image";s:4:"name";s:12:"slider_image";s:4:"type";s:5:"image";s:12:"instructions";s:0:"";s:8:"required";s:1:"0";s:12:"column_width";s:0:"";s:11:"save_format";s:6:"object";s:12:"preview_size";s:9:"thumbnail";s:7:"library";s:3:"all";s:17:"conditional_logic";a:3:{s:6:"status";s:1:"0";s:5:"rules";a:1:{i:0;a:3:{s:5:"field";s:4:"null";s:8:"operator";s:2:"==";s:5:"value";s:0:"";}}s:8:"allorany";s:3:"all";}s:8:"order_no";i:0;}i:1;a:14:{s:3:"key";s:19:"field_53f60a628666a";s:5:"label";s:17:"Image description";s:4:"name";s:17:"image_description";s:4:"type";s:8:"textarea";s:12:"instructions";s:0:"";s:8:"required";s:1:"0";s:12:"column_width";s:0:"";s:13:"default_value";s:0:"";s:11:"placeholder";s:0:"";s:9:"maxlength";s:0:"";s:4:"rows";s:0:"";s:10:"formatting";s:2:"br";s:17:"conditional_logic";a:3:{s:6:"status";s:1:"0";s:5:"rules";a:1:{i:0;a:2:{s:5:"field";s:4:"null";s:8:"operator";s:2:"==";}}s:8:"allorany";s:3:"all";}s:8:"order_no";i:1;}}s:7:"row_min";s:0:"";s:9:"row_limit";s:0:"";s:6:"layout";s:5:"table";s:12:"button_label";s:9:"Add Image";s:17:"conditional_logic";a:3:{s:6:"status";s:1:"0";s:5:"rules";a:1:{i:0;a:2:{s:5:"field";s:4:"null";s:8:"operator";s:2:"==";}}s:8:"allorany";s:3:"all";}s:8:"order_no";i:0;}', true);
     add_post_meta($post_ID, 'position', 'normal', true);
     add_post_meta($post_ID, 'layout', 'no_box', true);
     add_post_meta($post_ID, 'hide_on_screen', '', true);
     add_post_meta($post_ID, 'rule', 'a:5:{s:5:"param";s:9:"post_type";s:8:"operator";s:2:"==";s:5:"value";s:6:"slider";s:8:"order_no";i:0;s:8:"group_no";i:0;}', true);

}


}

/*check if posts with this title exists*/
function skywarrior_post_by_title($title) {
	global $wpdb;
	$tit = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " . $wpdb->posts . " WHERE post_title = %s && post_status = 'publish' && post_type = 'blackfyre'", $title));
	return $tit;
}

}
$Blackfyre_Types = new Blackfyre_Types();

?>