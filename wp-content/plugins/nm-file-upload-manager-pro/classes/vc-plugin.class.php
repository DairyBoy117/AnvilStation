<?php 
/**
* Plugin Main Class
*/


class NM_WP_FileManager_Admin_VC  extends NM_WP_FileManager 
{
	
	function __construct()
	{
		add_action('vc_before_init', array($this, 'nm_option_settings'));
		
	}

	function nm_option_settings(){
	    
	    include( plugin_dir_path( __FILE__ ) . 'vc-addon/vc-settings-options.php');


		$nm_main_var = array(
			"name" => __("File Upload and Manager"),
			"base" => "nm-wp-file-uploader",
			"category" => __('File Manger by N-Media'),
			"description" => __('Upload and manage files from frontend'),
			"params" => $settings_params
		);

		vc_map($nm_main_var);
	}
}
 ?>