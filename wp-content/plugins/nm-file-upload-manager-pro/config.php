<?php
/*
 * this file contains pluing meta information and then shared
 * between pluging and admin classes
 * 
 * [1]
 */

// Google Addon object
$googleaddon = '';

function get_plugin_meta_filemanager(){

$plugin_meta		= array('name'			=> 'FileManager',
							'shortname'		=> 'nm_filemanager',
							'shortcode'		=> 'nm-wp-file-uploader',
							'path'					=> untrailingslashit(plugin_dir_path( __FILE__ )),
							'url'				=> untrailingslashit(plugin_dir_url( __FILE__ )),
							'plugin_version'	=> 8.2,
							'logo'			=> plugin_dir_url( __FILE__ ) . 'images/logo.png',
							'menu_position'	=> 69);
	
	//print_r($plugin_meta);
	
	return $plugin_meta;
}


/*
 * rendering that It is Pro
 */
function nm_filemanager_pro(){
	
	echo '<a href="#">'.__('It is PRO', 'nm_filemanager').'</a>';
}

function filemanager_pa($arr){
	
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}


/**
 * this function returns the relevant font icon
 * against file type
 */
 function nm_get_file_icon($filename = null){
 	$filetype = wp_check_filetype($filename);
	$filetype = $filetype['ext'];
	
	$icons = array(	'excel-o'		=> array('xls', 'xlx'),
					'pdf-o'			=> array('pdf'),
					'sound-o'		=> array('mp3','mp4'),
					'word-o'		=> array('docs', 'docx'),
					'zip-o'			=> array('rar','zip','tar','gz'),
					'image-o'		=> array('png','gif','jpg','psd','ai','tiff','bmp'),
					'text'			=> array('txt'),
					'movie-o'		=> array('mov','flv','ogg','mp3'),
					'code-o'		=> array('html','php','css','js','sql'),
					'powerpoint-o' 	=> array('ppt','pptx','ppx'),
					);
					
	$font_icon = 'file';
	foreach($icons as $icon => $types){
		
		if(in_array($filetype, $types)){
			$font_icon = $icon;
		}
	}
	
	return 'fa fa-file-'.$font_icon;
	
 }
 
 
  // Get Addon Object
function nm_google_obj($key = null) {
    
    global $googleaddon;
    
    if( ! $googleaddon )
    	return null;
    
    if( $key ) {
        if( $googleaddon->$key)
        	return $googleaddon->$key;
    }else{
    	$googleaddon;
    }
}

/**
 * return file groups html/select
 * for file upload
 * @since 11.4
 **/
 function nm_show_file_groups() {
 	
 	$file_groups = get_terms( array(
    'taxonomy' => 'file_groups',
    'hide_empty' => false,
	) );
	
	if ( $file_groups )
		return $file_groups;
	else
		return null;
 }
 
 /**
  * return number of files allowed per user
  * @since 11.7
  **/
 function nm_files_allower_per_user() {
 	
 	$max_files = NMFILEMANAGER() -> get_option('_max_files_user');
 	if( $max_files == ''){
 		$max_files = 10000;
 	}
 	
 	return intval($max_files);
 }
 
 
 /**
  * return can user create directory
  * @since 12.0
  * @labibahmed
  * @ 9/5/2017
  **/
 function nm_can_user_create_directory() {
 	
 	$shortcode_params = NMFILEMANAGER() -> shortcode_params;
 	$can_create_dir_option = NMFILEMANAGER() -> get_option('_create_dir');
 	if( isset($shortcode_params['nm_filemanager_create_dir']) ){
 		return $shortcode_params['nm_filemanager_create_dir'];
 	} elseif( !isset($shortcode_params['nm_filemanager_create_dir'])  ) {
 		return $can_create_dir_option;
 	}
 	
 }
 
 /**
  * return can non-logged in user can upload file
  * @since 12.0
  * @labibahmed
  * @ 9/5/2017
  **/
 function nm_can_public_upload_files() {
 	
 	$shortcode_params = NMFILEMANAGER() -> shortcode_params;
 	$can_public_upload_file_option = NMFILEMANAGER() -> get_option('_allow_public');
 	if( isset($shortcode_params['nm_filemanager_allow_public']) ){
 		return $shortcode_params['nm_filemanager_allow_public'];
 	} elseif( !isset($shortcode_params['nm_filemanager_allow_public'])  ) {
 		return $can_public_upload_file_option;
 	}
 	
 }
 
 /**
  * return can user send file
  * @since 12.0
  * @labibahmed
  * @ 9/5/2017
  **/
 function nm_can_user_send_file() {
 	
 	$shortcode_params = NMFILEMANAGER() -> shortcode_params;
 	$can_send_file_option = NMFILEMANAGER() -> get_option('_send_file');
 	if( isset($shortcode_params['nm_filemanager_send_file']) ){
 		return $shortcode_params['nm_filemanager_send_file'];
 	} elseif( !isset($shortcode_params['nm_filemanager_send_file'])  ) {
 		return $can_send_file_option;
 	}
 	
 }
 
 /**
  * return can filter files by groups
  * @since 12.0
  * @labibahmed
  * @ 9/5/2017
  **/
 function nm_can_user_filter_file() {
 	
 	$shortcode_params = NMFILEMANAGER() -> shortcode_params;
 	$can_filter_file_option = NMFILEMANAGER() -> get_option('_file_groups');
 	if( isset($shortcode_params['nm_filemanager_file_groups']) ){
 		return $shortcode_params['nm_filemanager_file_groups'];
 	} elseif( !isset($shortcode_params['nm_filemanager_file_groups'])  ) {
 		return $can_filter_file_option;
 	}
 	
 }
 
 /**
  * return can choose group on file upload complete
  * @since 12.0
  * @labibahmed
  * @ 9/5/2017
  **/
 function nm_can_user_choose_group_fileupload() {
 	
 	$shortcode_params = NMFILEMANAGER() -> shortcode_params;
 	$can_choose_file_group_option = NMFILEMANAGER() -> get_option('_file_groups_add');
 	if( isset($shortcode_params['nm_filemanager_file_groups_add']) ){
 		return $shortcode_params['nm_filemanager_file_groups_add'];
 	} elseif( !isset($shortcode_params['nm_filemanager_file_groups_add'])  ) {
 		return $can_choose_file_group_option;
 	}
 	
 }
 
 /**
  * return can hide logout button
  * @since 12.0
  * @labibahmed
  * @ 9/5/2017
  **/
 function nm_can_user_hide_logout_button() {
 	
 	$shortcode_params = NMFILEMANAGER() -> shortcode_params;
 	$can_hide_logout_button = NMFILEMANAGER() -> get_option('_hide_logout_button');
 	if( isset($shortcode_params['nm_filemanager_hide_logout_button']) && $shortcode_params['nm_filemanager_hide_logout_button'] != ""){
 		return $shortcode_params['nm_filemanager_hide_logout_button'];
 	} elseif( !isset($shortcode_params['nm_filemanager_hide_logout_button'])  ) {
 		return $can_hide_logout_button;
 	}
 	
 }
 
 /**
  * return select file button title
  * @since 12.0
  * @labibahmed
  * @ 9/5/2017
  **/
 function nm_select_file_button_title() {
 	
 	$shortcode_params = NMFILEMANAGER() -> shortcode_params;
 	$select_file_button_title_option = NMFILEMANAGER() -> get_option('_button_title');
 	if( isset($shortcode_params['nm_filemanager_button_title']) && $shortcode_params['nm_filemanager_button_title'] != ""){
 		return $shortcode_params['nm_filemanager_button_title'];
 	} elseif( !isset($shortcode_params['nm_filemanager_button_title'])  ) {
 		return $select_file_button_title_option;
 	}
 	
 }
 
 /**
  * return save file title
  * @since 12.0
  * @labibahmed
  * @ 9/5/2017
  **/
 function nm_save_file_title() {
 	
 	$shortcode_params = NMFILEMANAGER() -> shortcode_params;
 	$save_file_button_title_option = NMFILEMANAGER() -> get_option('_upload_title');
 	if( isset($shortcode_params['nm_filemanager_upload_title']) && $shortcode_params['nm_filemanager_upload_title'] != ""){
 		return $shortcode_params['nm_filemanager_upload_title'];
 	} elseif( !isset($shortcode_params['nm_filemanager_upload_title'])  ) {
 		return $save_file_button_title_option;
 	}
 	
 }