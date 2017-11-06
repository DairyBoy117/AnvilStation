<?php
/*
 * it is loading all other templates
 */

global $nmfilemanager;
$allow_public = $nmfilemanager -> get_option('_allow_public');

$nmfilemanager -> parent_id = (isset($_REQUEST['parent_id']) ? intval($_REQUEST['parent_id']) : '0');
?>

<style>
	<?php echo $nmfilemanager -> load_template('_template_main_style.css');?>
</style>
	
	
	<input type="hidden" name="parent_id" value="<?php echo $nmfilemanager -> parent_id;?>">
<?php 
/*
 * loading uploader template
 */
if ( is_user_logged_in() || $allow_public == 'yes' ) { 
 	$upload_section = $this -> get_option('_upload_area');
	$allow_create_dir = $this -> get_option('_create_dir');
 	
	if ( !$upload_section == 'yes' ) {
		if ( $this->downloader == 'no' || current_user_can('manage_options') ){
		echo '<div id="the-file-directory">';
	  	echo '<ul>';
		echo ' 	<li><a href="#tabs-file">'.__('Upload files', 'nm-filemanager').'</a></li>';
		if ( $allow_create_dir == 'yes' ) 
			echo ' 	<li><a href="#tabs-directory">'.__('Create directory', 'nm-filemanager').'</a></li>';
		echo '</ul>';
		  
		  	echo '<div id="tabs-file">';
				$nmfilemanager -> load_template( 'bp/_template_uploader.php' );
			echo '</div>';	
			
			if ( $allow_create_dir == 'yes' ) {
				echo '<div id="tabs-directory">';
					$nmfilemanager -> load_template( 'bp/_template_directory.php' );
				echo '</div>';	
			}
		echo '</div>';
	} }
	
/*
 * loading uploaded files (list files) template
 */
 	$download_section = $this -> get_option('_download_area');
	if ( !$download_section == 'yes' ) {
		if ($nmfilemanager -> get_option('_enable_tree') == 'yes') {

			$nmfilemanager -> load_template( 'bp/_template_list_tree.php' );
			
		} else {

			$nmfilemanager -> load_template( 'bp/_template_list_files.php' );
		}
		
	}
}else{
			
	$public_message = $nmfilemanager -> get_option('_public_message');
	if($public_message != ''){
		echo '<div class="update"><p>';
		printf(__('%s', 'nm-filemanager'), $public_message);
		echo '</p></div>';
	}else{
		echo '<script type="text/javascript">
		window.location = "'.wp_login_url( get_permalink() ).'"
		</script>';
	}
}
	
?>