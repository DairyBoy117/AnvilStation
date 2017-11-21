<?php
/**
 * Plugin Name: Anvil File Share
 * Plugin URI: http://anvilstation.com
 * Description: A plugin for sharing images, videos, and other files
 * Version: 1.0.0
 * Author: Austin Verburg
 * Author URI: http://austinverburg.com
 * License: GPL2
 */

function add_pepekura_files($addPep){
    $addPep['pdo'] = 'pepekura/pdo'; //Adding svg extension
    return $addPep;
}
add_filter('upload_mimes', 'add_pepekura_files', 1, 1);

function create_file_share() {
    $labels = array(
        'name'                => __( 'Files' ),
        'singular_name'       => __( 'File' ),
        'menu_name'           => __( 'Files' ),
        'all_items'           => __( 'All Files' ),
        'view_item'           => __( 'View File' ),
        'add_new_item'        => __( 'Add New File' ),
        'add_new'             => __( 'Add New' ),
        'edit_item'           => __( 'Edit File' ),
        'update_item'         => __( 'Update File' ),
        'search_items'        => __( 'Search File' )
    );


    $args = array(
      'label' => 'Files',
      'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'rewrite' => array('slug' => 'property'),
        'query_var' => true,
        'menu_icon' => 'dashicons-building',
        'supports' => array(
            'title',
            'editor',
            'thumbnail'),
        );
    register_post_type( 'files', $args );
}
add_action( 'init', 'create_file_share' );

function add_file_uploader() {
 
    add_meta_box(
        'upload_files',
        'Upload Files',
        'files_meta_info',
        'files',
        'normal'
    );
 
}
add_action('add_meta_boxes', 'add_file_uploader');

function files_meta_info() { ?>

	<h1>Testing</h1>

<?php }

?>