<?php
/*
 * it is loading all other templates
 */

global $nmfilemanager;

$nmfilemanager -> parent_id = (isset($_REQUEST['parent_id']) ? intval($_REQUEST['parent_id']) : '0');
?>

<link rel="stylesheet" type="text/css" href="<?php echo $nmfilemanager->plugin_meta['url']?>/templates/_template_main_style.css" />

<input type="hidden" name="parent_id" value="<?php echo $nmfilemanager -> parent_id;?>">
<?php 
/*
 * loading uploader template
 */
 
 	$upload_section = $this -> get_option('_upload_area');
	$allow_create_dir = $this -> get_option('_create_dir');
	
	$template_uploader = apply_filters('nm_template_uploader', '_template_uploader.php');
	$template_directory = apply_filters('nm_template_directory', '_template_directory.php');
 	
	if ( !$upload_section == 'yes' ) {
		if ( $this->downloader == 'no' || current_user_can('manage_options') ){
		echo '<div id="the-file-directory">';
	  	echo '<ul>';
		echo ' 	<li><a href="#tabs-file">'.__('Upload files', 'nm-filemanager').'</a></li>';
		if ( $allow_create_dir == 'yes' ) 
			echo ' 	<li><a href="#tabs-directory">'.__('Create directory', 'nm-filemanager').'</a></li>';
		echo '</ul>';
		  
		  	echo '<div id="tabs-file">';
				$nmfilemanager -> load_template( $template_uploader );
			echo '</div>';	
			
			if ( $allow_create_dir == 'yes' ) {
				echo '<div id="tabs-directory">';
					$nmfilemanager -> load_template( $template_directory );
				echo '</div>';	
			}
		echo '</div>';
	} }
	
	
	/**
	 * rendering file list in different style/templates
	 */
	 
	// $template_tree = apply_filters('nm_template_tree', '_template_list_tree.php');
	$template_list_files = apply_filters('nm_template_file_list', '_template_list_files.php');
	
	
 	$download_section = $this -> get_option('_download_area');
	if ( !$download_section == 'yes' ) {
		
		/**
		 * now template tree and file list is being handlign with filter
		 * filter: nm_template_file_list
		 * @since 10.9.4
		 */
		$nmfilemanager -> load_template( $template_list_files );
		
	}
?>