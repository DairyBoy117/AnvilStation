<?php 
/*
 Plugin Name: N-Media File Upload and Manager PRO
Plugin URI: http://www.najeebmedia.com
Description: This plugin is front-end file uploader and manager which allow users to upload and manage files and admin can watch all these files with full control over.
Version: 12.2
Author: Najeeb Ahmad
Text Domain: nm-filemanager
Author URI: http://www.najeebmedia.com/
*/


require 'plugin-update-checker/plugin-update-checker.php';
$nmUpdateChecker = PucFactory::buildUpdateChecker(
		// 'http://wordpresspoets.com/wp-update-server/?action=get_metadata&slug=nm-file-upload-manager-pro',
		'https://www.wordpresspoets.com/release-json/fileupload.json',
		__FILE__
);

$nmUpdateChecker->addQueryArgFilter('nm_filemanager_update_checks');
function nm_filemanager_update_checks($queryArgs) {
    $apikey = get_option('nm_filemanager_apikey');
    if ( !empty($apikey) ) {
        $queryArgs['api_key'] = $apikey;
    }
    return $queryArgs;
}


/*
 * loading plugin config file
 */

$_config = dirname(__FILE__).'/config.php';
if( file_exists($_config))
	include_once($_config);
else
	die('Reen, Reen, BUMP! not found '.$_config);


/* ======= the plugin main class =========== */
$_plugin = dirname(__FILE__).'/classes/plugin.class.php';
if( file_exists($_plugin))
	include_once($_plugin);
else
	die('Reen, Reen, BUMP! not found '.$_plugin);


/* ======= the plugin visual composer class =========== */

$vc_admin = dirname(__FILE__).'/classes/vc-plugin.class.php';
if( file_exists($vc_admin ))
	include_once($vc_admin );
else
	die('file not found! '.$vc_admin);

$nmfilemanager_admin_vc = new NM_WP_FileManager_Admin_VC();


/*
 * [1]
 */
$nmfilemanager = NM_WP_FileManager::get_instance();
NM_WP_FileManager::init();



if( is_admin() ){

	$_admin = dirname(__FILE__).'/classes/admin.class.php';
	if( file_exists($_admin))
		include_once($_admin );
	else
		die('file not found! '.$_admin);

	$nmfilemanager_admin = new NM_WP_FileManager_Admin();
	
	/*
	 * adding custom button to editor
	*/
	//include('classes/class.mcebutton.php');
	//$tbutton = new NM_addCustomButton_filemanager("|", "nmuploader", $nmfilemanager_admin->plugin_meta['url'].'/js/shortcode-button/btn_download.js');
}


/*
 * activation/install the plugin data
*/
register_activation_hook( __FILE__, array('NM_WP_FileManager', 'activate_plugin'));
register_deactivation_hook( __FILE__, array('NM_WP_FileManager', 'deactivate_plugin'));