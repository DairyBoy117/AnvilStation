<?php
/*
 * this is main plugin class
 */


/* ======= the model main class =========== */
if (! class_exists ( 'NM_Framwork_V1_filemanager' )) {
	$_framework = dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . 'nm-framework.php';
	if (file_exists ( $_framework ))
		include_once ($_framework);
	else
		die ( 'Reen, Reen, BUMP! not found ' . $_framework );
}

/*
 * [1]
 */
class NM_WP_FileManager extends NM_Framwork_V1_filemanager {
	
	
	private static $ins = null;
	
	public $shortcode_params;
	
	public static function init()
	{
		add_action('plugins_loaded', array(self::get_instance(), '_setup'));
	}
	
	public static function get_instance()
	{
		// create a new object if it doesn't exist.
		is_null(self::$ins) && self::$ins = new self;
		return self::$ins;
	}
	
	
	static $tbl_file_meta = 'nm_files_meta';
	var $allow_file_upload;
	var $inputs;
	var $parend_id;
	
	
	//this property is set to true when shortcode is render, then images thumbnails didn't generated
	var $is_uploader = false;
	
	
	//this will hold all user files V10
	var $user_files = array();
	var $only_file_titles = array();

	
	/*
	 * plugin constructur
	 */
	function _setup() {
		//ini_set( 'mysql.trace_mode', 0 );
		// setting plugin meta saved in config.php
		$this->plugin_meta = get_plugin_meta_filemanager ();
		
		// getting saved settings
		$this->plugin_settings = get_option ( $this->plugin_meta ['shortname'] . '_settings' );
		
		// file upload dir name
		
		$this->user_uploads = 'user_uploads';
		
		// check amazon addon enabled
		$this -> is_amazon_enabled = $this -> check_amazon_enabled();
		
		// this will hold form form_id
		$this->group_id = '';
		$this->downloader = 'no';
		//$this->admin_group_id = '';
		$this->role = '';		
		
		// populating $inputs with NM_Inputs object
		$this->inputs = $this->get_all_inputs ();
		
		/*
		 * [2] TODO: update scripts array for SHIPPED scripts only use handlers
		 */
		// setting shipped scripts
		$this->wp_shipped_scripts = array (
				'jquery' 
		);
		
		
		add_action ( 'wp_enqueue_scripts', array (
		$this,
		'load_scripts_extra'
		) );
		
		/*
		 * [3] TODO: update scripts array for custom scripts/styles
		 */
		// setting plugin settings
		$this->plugin_scripts = array (
				
				array (
						'script_name' => 'scripts',
						'script_source' => '/js/script.js',
						'localized' => true,
						'type' => 'js',
						'depends'		=> array('jquery', 'thickbox', 'jquery-ui-tabs',),
				),
				/*array (
						'script_name' => 'flexslider',
						'script_source' => '/js/jquery.flexslider-min.js',
						'localized' => true,
						'type' => 'js' 
				),*/
				array (
						'script_name' => 'colorbox',
						'script_source' => '/js/jquery.colorbox-min.js',
						'localized' => true,
						'type' => 'js' 
				),
				
				array (
						'script_name' => 'nm-ui-style',
						'script_source' => '/js/ui/css/smoothness/jquery-ui-1.10.3.custom.min.css',
						'localized' => false,
						'type' => 'style',
						'page_slug' => array (
								'nm-new-form' 
						) 
				) 
		);

		
		/*
		 * [4] Localized object will always be your pluginshortname_vars e.g: pluginshortname_vars.ajaxurl
		 */
		 
		 $messages_js = array('files_loading'	=> __('Files are being loaded ...', 'nm-filemanager'),
		 						'file_sharing'	=> __('Please wait ...', 'nm-filemanager'),
		 						'file_uploading'=> __('File(s) are being saved', 'nm-filemanager'),
		 						'file_uploaded' => __('File is uploaded successfully', 'nm-filemanager'),
		 						'file_upload_error' => __('Sorry, but some error while uplaoding. Please try again', 'nm-filemanager'),
		 						'file_settings_error' => __("This file cannot be uploaded due to following error\n\n\n", 'nm-filemanager'),
		 						'file_delete' => __('Are you sure?', 'nm-filemanager'),
		 						'file_deleting' => __('Deleting file ...', 'nm-filemanager'),
		 						'file_deleted' => __('File deleted', 'nm-filemanager'),
		 						'file_updating' => __('Updating file ...', 'nm-filemanager'),
		 						'directory_creating' => __('Creating directory ...', 'nm-filemanager'),
		 						'directory_created' => __('Directory is created', 'nm-filemanager'),
		 						'select_group' => __('Select Group', 'nm-filemanager'),
		 						
		 					);
		 					
		$this->localized_vars = array (
				'ajaxurl' 					=> admin_url( 'admin-ajax.php', (is_ssl() ? 'https' : 'http') ),
				'plugin_url'				=> $this->plugin_meta ['url'],
				'doing' 					=> $this->plugin_meta ['url'] . '/images/loading.gif',
				'settings' 					=> $this->plugin_settings,
				'file_upload_path_thumb' 	=> $this->get_file_dir_url ( true ),
				'file_upload_path' 			=> $this->get_file_dir_url (),
				'message_max_files_limit'	=> __(' File are allowed to upload', 'nm-filemanager'),
				'delete_file_message'		=> __('It will delete all child files/directories too, Delete it?', 'nm-filemanager'),
				'share_file_heading'		=> __('Share file', 'nm-filemanager'),
				'file_meta_heading'			=> __('Edit file meta', 'nm-filemanager'),
				'file_meta' 				=> get_option('filemanager_meta'),
				'file_meta_label'			=> __('Add Meta', 'nm-filemanager'),
				'file_meta_notice'			=> __('Please add file Properties to proceed', 'nm-filemanager'),
				'messages'					=> apply_filters('nmfilemanager_messages_string', $messages_js),
				'user_name'					=> wp_get_current_user() -> user_login,
		);
		
		/*
		 * [5] TODO: this array will grow as plugin grow all functions which need to be called back MUST be in this array setting callbacks
		 */
		// following array are functions name and ajax callback handlers
		$this->ajax_callbacks = array (
				'save_settings', // do not change this action, is for admin
				'save_file_meta',
				'save_file_data_ng',
				'save_file_data',
				'upload_file',
				'delete_file',
				'delete_file_new',
				'delete_meta',
				'save_edited_photo',
				'load_shortcodes',
				'get_form_meta',
				'send_files_email',
				'delete_all_posts',
				'update_file_data',
				'delete_all_directores_of_user',
				'share_file',
				'edit_file_meta',
				'validate_api',
				'create_directory',
				'share_user_file',
				'get_popup_contents',
				'save_ftp_files',
				//version 10 callback
				'get_user_files',
				'edit_file_title_desc',
				'share_file_admin',
				'move_file'
		);
		
		/*
		 * plugin localization being initiated here
		 */
		
		add_action ( 'init', array (
				$this,
				'wpp_textdomain' 
		) );
		
		
		/*
		 * plugin main shortcode if needed
		 */
		add_shortcode ( $this->plugin_meta ['shortcode'], array (
				$this,
				'render_shortcode_template' 
		) );

		add_shortcode ( 'nm-wp-file-downloader', array (
				$this,
				'render_shortcode_downloader' 
		) );
		
		/*
		 * hooking up scripts for front-end
		 */
		add_action ( 'wp_enqueue_scripts', array (
				$this,
				'load_scripts' 
		) );
		
		/*
		 * registering callbacks
		 */
		$this->do_callbacks ();
		
		/*
		 * add custom post type support if enabled
		 */
		add_action ( 'init', array (
				$this,
				'enable_custom_post' 
		) );

		/*
		 * add custom taxonomies for CPT nm-userfiles
		 */
		add_action ( 'init', array (
				$this,
				'enable_custom_taxonomies' 
		), 0 );
		
		
		/**
		 * following hooks adding post column for images and other meta
		 */
		add_filter('manage_nm-userfiles_posts_columns', array($this ,'file_thumb_column_head'));
		add_action('manage_nm-userfiles_posts_custom_column', array($this ,'file_thumb_column_content'), 10, 2);	
		
		/**
		 * adding some styles to admin
		 */
		add_action('admin_head', array($this, 'admin_styles'));
		
		
		add_action('setup_styles_and_scripts_nm_filemanager', array($this, 'get_connected_to_load_it'));
		
		//preventing to not generate thumbs for images
		add_filter('intermediate_image_sizes_advanced', array($this, 'prevent_thumbs_generation'));
		
		//BuddyPress Group File Sharing since 8.4+
		add_action( 'bp_init', array($this, 'extend_bp_group') );
		
		
		// ========= -- comments related hooks -- ==============
		// this will enable comments for all nm-userfiles post type
		add_filter( 'comments_open', array($this, 'userfiles_comment_open'), 10, 2 );
		//when comment is saved then we need to return some response
		add_action('set_comment_cookies', array($this, 'return_comment_response'), 10, 2);
		//removing reply to comment link
		add_filter('comment_reply_link', array($this, 'remove_reply_link'), 10, 4);
		// delete user folder from user_uploads
		add_action( 'delete_user', array($this, 'nm_delete_user_folder') );
		
		if( class_exists('NM_Google_Addon') ) {
			// Google Object
			global $googleaddon;
	    	$googleaddon = new NM_Google_Addon($this -> get_option('_enable_google_drive'));
		}
		
		
		// some local filters used in plugin
		add_filter('nmfile_upload_file_text', array($this, 'upload_file_button_text'));
		add_filter('nm_template_uploader', array($this, 'bp_template_uploader'), 10, 1);
		add_filter('nm_template_directory', array($this, 'bp_template_directory'), 10, 1);
		add_filter('nm_template_file_list', array($this, 'filelist_template'), 10, 1);
		// add_filter('nm_template_list', array($this, 'bp_template_list'), 10, 1);
		// changin filename
		add_filter('filemanager_filename', array($this, 'change_filename'), 10, 1);
		
		// restricting nm-userfiles post from direct access
		add_filter( 'the_content', array($this, 'restrict_contents' ));
		
		if( $this -> is_amazon_enabled ) {
			// generating amazon file url via shortcode
			add_shortcode('nm-amazon-s3', array(NMAMAZONS3(), 'generate_url'));
			add_action( 'woocommerce_download_file_nmamazon', array( NMAMAZONS3(), 'download_wc_file' ), 10, 2 );
			add_filter( 'woocommerce_file_download_method', array( NMAMAZONS3(), 'add_download_method' ) );
		}
		
		// adding css for nm-userfiles cpt
		add_action( 'admin_print_scripts-edit.php', array($this, 'userfiles_css'), 11 );
		 
	}
	
	// i18n and l10n support here
	// plugin localization
	function wpp_textdomain() {
		$locale_dir = dirname( plugin_basename( dirname(__FILE__) ) ) . '/locale/';
		load_plugin_textdomain('nm-filemanager', false, $locale_dir);
		
		$this->download_private_file();
	}
	
	
	/*
	 * =============== Comments callback/hooks ===========================
	 */
	function userfiles_comment_open( $open, $post_id ) {

		$post = get_post( $post_id );
	
		if ( 'nm-userfiles' == $post->post_type )
			$open = true;
	
		return $open;
	}
	
	
	function return_comment_response($comment, $user){
		
		global $post;
		
		if( $post -> post_type == 'nm-userfiles' && $comment )
			die('success');
	}
	
	function remove_reply_link($link, $args, $comment, $post){
		
		if ( 'nm-userfiles' == $post->post_type )
			return '';
		else
			return $link;
	}

	function nm_delete_user_folder( $userid ){

		/* delete all custom posts for user */
		$this->nm_deleteAllCustomPosts ($userid);
		/* delete users upload folder */
		$folder_to_delete = $this->get_author_file_dir_path( $userid );
		$this->nm_recursiveRemoveDirectory( $folder_to_delete );
	}
	
	
	/*
	 * =============== NOW do your JOB ===========================
	 */
	function enable_custom_post() {
		register_post_type ( 'nm-userfiles', array (
				'labels' => array (
						'name' 				 => __ ( 'User Files', 'nm-filemanager' ),
						'singular_name' 	 => __ ( 'User Files', 'nm-filemanager' ),
						'add_new' 			 => __('Add New', 'nm-filemanager'),
						'add_new_item' 		 => __('Add User Files', 'nm-filemanager'),
						'edit' 				 => __('Edit', 'nm-filemanager'),
						'edit_item' 		 => __('Edit User Files', 'nm-filemanager'),
						'new_item' 			 => __('New User Files', 'nm-filemanager'),
						'view' 				 => __('View', 'nm-filemanager'),
						'view_item' 		 => __('View User Files', 'nm-filemanager'),
						'search_items' 		 => __('Search User Files', 'nm-filemanager'),
						'not_found' 		 => __('No User Files found', 'nm-filemanager'),
						'not_found_in_trash' => __('No User Files found in Trash', 'nm-filemanager'),
						'parent' 			 => __('Parent User Files', 'nm-filemanager') 
				),
				'public' => true,
				'capabilities' => array(
						'edit_post'          => 'update_core',
						'read_post'          => 'update_core',
						'delete_post'        => 'update_core',
						'edit_posts'         => 'update_core',
						'edit_others_posts'  => 'update_core',
						'delete_posts'       => 'update_core',
						'publish_posts'      => 'update_core',
						'read_private_posts' => 'update_core'
				),
				'supports' => array (
						'title',
						'editor',
						'custom-fields',
						'comments',
						'thumbnail',
				),
				'menu_icon' => $this->plugin_meta ['logo'] 
		) );
	}

	function enable_custom_taxonomies() {
		// Add new taxonomy, make it non hierarchical (like categories)
		$labels = array(
			'name'              => _x( 'File_Groups', 'taxonomy general name', 'nm-filemanager' ),
			'singular_name'     => _x( 'File_Group', 'taxonomy singular name', 'nm-filemanager' ),
			'search_items'      => __( 'Search Group', 'nm-filemanager' ),
			'all_items'         => __( 'All Groups', 'nm-filemanager' ),
			'parent_item'       => __( 'Parent Group', 'nm-filemanager' ),
			'parent_item_colon' => __( 'Parent Groups', 'nm-filemanager' ),
			'edit_item'         => __( 'Edit Group', 'nm-filemanager' ),
			'update_item'       => __( 'Update Group', 'nm-filemanager' ),
			'add_new_item'      => __( 'Add New Group', 'nm-filemanager' ),
			'new_item_name'     => __( 'New Group Name', 'nm-filemanager' ),
			'menu_name'         => __( 'File Groups', 'nm-filemanager' ),
		);
	
		$args = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'file_groups' ),
		);
	
		register_taxonomy( 'file_groups', array( 'nm-userfiles' ), $args );
	}
	
	function load_shortcodes(){
	
		$this -> load_template('admin/meta-shortcodes.php');
	
		die(0);
	}
	
	/*
	 * saving form meta in admin call
	 */
	function save_file_meta() {
		
		//print_r($_REQUEST); exit;
		global $wpdb;
		
		update_option('filemanager_meta', $_REQUEST['file_meta']);
		
		$resp = array (
					'message' => __ ( 'Form added successfully', 'nm-filemanager' ),
					'status' => 'success',
					'form_id' => $res_id 
			);
		
		echo json_encode ( $resp );
		
		
		die ( 0 );
	}
	
	/*
	 * updating form meta in admin call
	 */
	function update_form_meta() {
		
		//print_r($_REQUEST); exit;
		global $wpdb;
		
		extract ( $_REQUEST );
		
		$dt = array (
				'form_name' => $form_name,
				'sender_email' => $sender_email,
				'sender_name' => $sender_name,
				'subject' => $subject,
				'receiver_emails' => $receiver_emails,
				'button_label' => $button_label,
				'button_class' => $button_class,
				'success_message' => stripslashes ( $success_message ),
				'error_message' => stripslashes ( $error_message ),
				'thumb_size' => stripslashes ( $thumb_size ),
				'form_style' => $form_style,
				'the_meta' => json_encode ( $form_meta ) 
		);
		
		$where = array (
				'form_id' => $form_id 
		);
		
		$format = array (
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s' 
		);
		$where_format = array (
				'%d' 
		);
		
		$res_id = $this->update_table ( self::$tbl_file_meta, $dt, $where, $format, $where_format );
		
		// $wpdb->show_errors(); $wpdb->print_error();
		
		$resp = array ();
		if ($res_id) {
			
			$resp = array (
					'message' => __ ( 'Form updated successfully', 'nm-filemanager' ),
					'status' => 'success',
					'form_id' => $form_id 
			);
		} else {
			
			$resp = array (
					'message' => __ ( 'Error while updating form, please try again', 'nm-filemanager' ),
					'status' => 'failed',
					'form_id' => $form_id 
			);
		}
		
		echo json_encode ( $resp );
		
		die ( 0 );
	}
	
	/*
	 * saving admin setting in wp option data table
	 */
	function save_settings() {
		
		 //$this -> pa($_REQUEST);
		$existingOptions = get_option ( $this->plugin_meta ['shortname'] . '_settings' );
		// pa($existingOptions);
		
		update_option ( $this->plugin_meta ['shortname'] . '_settings', $_REQUEST );
		_e ( 'All options are updated', 'nm-filemanager' );
		die ( 0 );
	}
	
	/*
	 * rendering template against shortcode
	 */
	function render_shortcode_template($atts) {
		
		$this -> shortcode_params = $atts;
		
		$allow_public = nm_can_public_upload_files();
		if ( is_user_logged_in() || $allow_public == 'yes') {
			
			extract ( shortcode_atts ( array (
			'group_id'  => 0
					), $atts ) );
					
			$this -> is_uploader = false;
			
			$this->group_id = $group_id;
			
			//get variable from query string - view
			
			if( isset($_GET['view']) && $_GET['view'] == 'tree'){

				$skin = $this -> get_option('_tree_skin');
	
				$treetheme = ($skin != '') ? $skin : 'skin-win8' ;

				wp_enqueue_style( 'fancy-tree-css', $this->plugin_meta['url'].'/js/fancytree/skin-'.$treetheme.'/ui.fancytree.min.css');
				wp_enqueue_script( 'jquery-ui', '//code.jquery.com/ui/1.11.2/jquery-ui.min.js', array('jquery'));
				wp_enqueue_script( 'fancy-tree-js', $this->plugin_meta['url'].'/js/fancytree/jquery.fancytree.min.js', array('jquery'));
				wp_enqueue_script( 'fancy-tree-filter', $this->plugin_meta['url'].'/js/fancytree/jquery.fancytree.filter.js');
				
				
				ob_start ();
			
				$this->load_template ( '_template_list_tree.php' );
			
				$output_string = ob_get_contents ();
				ob_end_clean ();
			
				return $output_string;
				
			} elseif ($this-> get_option('_enable_old_version') == 'yes' || $this -> check_browser() == true){
				
				wp_enqueue_style( 'data-table-css', $this->plugin_meta['url'].'/js/dataTables-1.10.10/css/jquery.dataTables.css');
				wp_enqueue_script( 'data-table-js', $this->plugin_meta['url'].'/js/dataTables-1.10.10/js/jquery.dataTables.js', array('jquery'));
				

				ob_start ();
			
				$this->load_template ( '_template_main.php' );
			
				$output_string = ob_get_contents ();
				ob_end_clean ();
			
				return $output_string;
				
			}else{	// by default new version is set
				
				wp_enqueue_style( 'nm-bootstrap', $this->plugin_meta['url'].'/templates/v10/css/bootstrap.min.css');
				wp_enqueue_style( 'font-awesome', $this->plugin_meta['url'].'/templates/v10/css/font-awesome.min.css');
				wp_enqueue_style( 'nm-styles', $this->plugin_meta['url'].'/templates/v10/css/styles.css');

				// wp_enqueue_script( 'bootstrap-js', $this->plugin_meta['url'].'/templates/v10/js/bootstrap.min.js', array('jquery'));
				
				
				//FileApi
				wp_enqueue_script( 'nm-fileuploader-fileapi', $this->plugin_meta['url'].'/templates/v10/js/fileapi/FileAPI.min.js');
				wp_enqueue_script( 'nm-fileuploader-fileapi-exif', $this->plugin_meta['url'].'/templates/v10/js/fileapi/FileAPI.exif.js');
				wp_enqueue_script( 'nm-fileuploader-fileapi-jquery', $this->plugin_meta['url'].'/templates/v10/js/fileapi/jquery.fileapi.min.js');
				
				
				// Google File Picker
				if( nm_google_obj('ison') ) {
					
					$gooleaddon_url = nm_google_obj('dir_url');
					
					wp_enqueue_script( 'nm-googleaddon-script', $gooleaddon_url.'/js/googleaddon.js', array('jquery'));
					$googleaddon_vars = array('ajaxurl' 	=> admin_url( 'admin-ajax.php', (is_ssl() ? 'https' : 'http') ),
												'plugin_url'=> $gooleaddon_url,
												'g_apikey'	=> $this->get_option('_google_apikey'),
												'g_clientid'=> $this->get_option('_google_clientid'),
												);
					wp_localize_script( 'nm-googleaddon-script', 'googleaddon_vars', $googleaddon_vars);
				}
				
				
				//agular stuff
				wp_enqueue_script( 'angular-js', $this->plugin_meta['url'].'/templates/v10/js/angular.min.js', array('jquery'));
				wp_enqueue_script( 'nm-fileuploader-app', $this->plugin_meta['url'].'/templates/v10/js/app.js', array('angular-js'));
				// angular drag-drop
				wp_enqueue_script( 'nm-ng-drag-drop', $this->plugin_meta['url'].'/templates/v10/js/draganddrop.min.js', array('angular-js'));
				
				
				
				// BlockUI
				wp_enqueue_style('filemanager-blockui-css', $this->plugin_meta['url'].'/templates/v10/js/block-ui-ng/dist/angular-block-ui.css');
				wp_enqueue_script( 'filemanager-blockui-js', $this->plugin_meta['url'].'/templates/v10/js/block-ui-ng/dist/angular-block-ui.min.js', array('angular-js'));
				
				
				//popup
				wp_enqueue_style( 'pretty-photo-css', $this->plugin_meta['url'].'/templates/v10/css/prettyPhoto.css');
				wp_enqueue_script( 'pretty-photo-script', $this->plugin_meta['url'].'/templates/v10/js/jquery.prettyPhoto.js', array('jquery'));
				
				//adding script to amazon upload
				if($this -> is_amazon_enabled){
					// wp_enqueue_script( 'amazonaws-s3', '//sdk.amazonaws.com/js/aws-sdk-2.3.16.min.js', array('jquery'));
					wp_enqueue_script( 'amazonaws-s3', '//sdk.amazonaws.com/js/aws-sdk-2.7.20.min.js', array('jquery'));
				}
				
				wp_localize_script( 'nm-fileuploader-app', 'nm_uploader_settings', array(
					
						// uploader related
						'image_size' => ($this -> get_option('_thumb_size') != '') ? $this -> get_option('_thumb_size') : '150',
						'max_file_size' => $this -> get_option('_max_file_size'),
						'max_files' => $this -> get_option('_max_files'),
						'max_files_message' => sprintf(__("Max. %d file(s) can be uploaded", 'nm-filemanager'), $this -> get_option('_max_files')),
						'file_format' => ($this -> get_option('_file_format') == 'custom') ? $this -> get_option('_file_types') : $this -> get_option('_file_format'),
						'file_auto_upload' => ($this -> get_option('_file_auto_upload') == 'yes') ? true : false,
						'file_allow_duplicate' => ($this -> get_option('_file_allow_duplicate') == 'yes') ? true : false,
						'file_drag_drop' => ($this -> get_option('_file_allow_drag_n_drop') == 'yes') ? '.upload_file_area' : false,
						// 'file_chunk_size' => ($this -> get_option('_file_chunk_size') != '') ? $this -> get_option('_file_chunk_size') : '3000',
						
						// image related
						'image_sizing' => ($this -> get_option('_enable_image_sizing') == 'yes') ? true : false,
						'image_min_width' => ($this -> get_option('_image_min_width') != '') ? $this -> get_option('_image_min_width') : '320',
						'image_min_height' => ($this -> get_option('_image_min_height') != '') ? $this -> get_option('_image_min_height') : '240',
						'image_max_width' => ($this -> get_option('_image_max_width') != '') ? $this -> get_option('_image_max_width') : '3840',
						'image_max_height' => ($this -> get_option('_image_max_height') != '') ? $this -> get_option('_image_max_height') : '2160',
						'image_resize' => ($this -> get_option('_resize_transform') != '') ? $this -> get_option('_resize_transform') : false,
						// amazon
						'amazon_key'	=> $this->get_option('_amazon_apikey'),
						'amazon_secret' => $this->get_option('_amazon_apisecret'),
						'amazon_bucket'	=> $this->get_option('_amazon_bucket'),
						'amazon_region'	=> $this->get_option('_amazon_region'),
						'amazon_enabled'=> $this -> is_amazon_enabled,
						'amazon_acl'=> $this->get_option('_acl_public'),
						'file_group_add' => nm_can_user_choose_group_fileupload()
					) );
				ob_start ();
				
				echo '<div id="status"></div><ul id="objects"></ul>';
			
				$this->load_template ( 'v10/_template_main.php' );
			
				$output_string = ob_get_contents ();
				ob_end_clean ();
			
				return $output_string;
			}
			
			
			
			
			
		}else{
			
			$public_message = $this -> get_option('_public_message');
			if($public_message != ''){
				ob_start ();
			
				printf(__('%s', 'nm-filemanager'), $public_message);
				$output_string = ob_get_contents ();
				ob_end_clean ();
				return $output_string;
			}else{
				echo '<script type="text/javascript">
				window.location = "'.wp_login_url( get_permalink() ).'"
				</script>';
			}
		}
		
		
	}

	/*
	 * rendering template against download area
	 */
	function render_shortcode_downloader($atts) {
		global $current_user;
		// No need here
		//$allow_public = $this -> get_option('_allow_public');
			
		extract ( shortcode_atts ( array (
		'group_id'		=> 0,
		'role'			=> ''
				), $atts ) );
		
		$this->downloader = 'yes';
		$this->group_id = $group_id;
		$this->role = $role;
		$authorized_roles = explode(',', $this->role = $role);
		
		if ( in_array( 'public', $authorized_roles ) ) {
			$this->load_template ( '_template_main.php' );
		}
		elseif ( is_user_logged_in() ) {
			
			ob_start ();

			//$current_user_role = key($current_user->caps);
			
			$current_user_roles = $current_user->roles;
			$user_allowed = false;

			foreach ($authorized_roles as $authorized_role){
				if( in_array( $authorized_role, $current_user_roles ) ){
					$user_allowed = true;
					break;
				}
			}

			if ($this->role == '' or $user_allowed or current_user_can( 'manage_options' ) or in_array( 'public', $authorized_roles )){

				wp_enqueue_style( 'data-table-css', $this->plugin_meta['url'].'/js/dataTables-1.10.10/css/jquery.dataTables.css');
				wp_enqueue_script( 'data-table-js', $this->plugin_meta['url'].'/js/dataTables-1.10.10/js/jquery.dataTables.js', array('jquery'));
			
				$this->load_template ( '_template_main.php' );
			} else {
				$role_message = $this -> get_option('_role_message');
				printf(__('%s', 'nm-filemanager'), $role_message);
			}
			
			$output_string = ob_get_contents ();
			ob_end_clean ();
			
			return $output_string;
			
		}else{
			
			$public_message = $this -> get_option('_public_message');
			if($public_message != ''){
				ob_start ();
			
				printf(__('%s', 'nm-filemanager'), $public_message);
				$output_string = ob_get_contents ();
				ob_end_clean ();
				return $output_string;
			}else{
				echo '<script type="text/javascript">
				window.location = "'.wp_login_url( get_permalink() ).'"
				</script>';
			}
		}
		
		
	}
	
	function share_user_file() {
		
		if ( isset($_POST['shareusersfile']) ) {

			if ( update_post_meta($_POST['post_id'], 'shared_with', $_POST['shareusersfile'] ) )
			
				_e( 'File Shared', 'nm-filemanager');
			
			else
			
				_e( 'Unable to share file. Please try again!', 'nm-filemanager');
		}
		
		die(0);	
	}
	
	function get_popup_contents() {
		
		extract($_REQUEST);

		$post = get_post( $id, 'array' );

		// print_r($post);
		$this->load_template('/file-detail.php');

		
		die(0);	
	}
	
	/*
	 * sending data to admin/others
	 */
	function save_file_data_ng() {
		
		// print_r($_REQUEST); exit;
		
		global $wpdb;
		$current_user = get_userdata( get_current_user_id() );
		$allow_public = nm_can_public_upload_files();
		if ($current_user -> ID == 0 && $allow_public == 'yes')
			$current_user = get_userdata($this -> get_option('_public_user'));
		
		extract( $_REQUEST );
		
		if (empty ( $_POST ) || ! wp_verify_nonce ( $_POST ['nm_filemanager_nonce'], 'saving_file' )) {
			print 'Sorry, You are not HUMANE.';
			exit ();
		}
		
		//it's a flag property to restrict thumbs generation only for uploader not for all other media upload in wp
		$this -> is_uploader = true;
		
		$submitted_data = $_REQUEST;
		$submitted_data = array_map('stripslashes', $submitted_data);
	
		unset ( $submitted_data ['action'] );
		unset ( $submitted_data ['nm_filemanager_nonce'] );
		unset ( $submitted_data ['_wp_http_referer'] );
		
		unset ( $submitted_data ['file_term_id'] );
		//unset ( $submitted_data ['nm_share_bp_group_id'] );		
		//unset ( $submitted_data ['admin_file_term_id'] );		
		
		
		//merging all file title and description in each array
		$all_files_with_data = array();
		foreach($uploaded_files as $key => $file){
			
			$all_files_with_data[$key] = array('filename'	=> $file['filename'],
												'title'		=> $file['title'],
												'description'	=> $file['file_details'],
												'file_group'	=> $file['file_group'],
												);
												
			//if amazon data found
			if( isset($file['amazon']) ){
				$all_files_with_data[$key]['amazon'] = $file['amazon'];
			}
		}
		
		// print_r($all_files_with_data); exit;
		
		$post_ids = array();		//saving all post ids
		foreach( $all_files_with_data as $key => $file_data){
			
			$allowed_html = array (
				'a' => array (
						'href' => array (),
						'title' => array () 
				),
				'br' => array (),
				'em' => array (),
				'strong' => array (),
				'p' => array (),
				'ul' => array (),
				'li' => array (),
				'h3' => array () 
			);
		
			$title = sanitize_text_field ( $file_data['title'] );
		
			// creating post
			$file_post = array (
					'post_title' => $title,
					'post_content' => wp_kses ( $file_data['description'], $allowed_html ),
					'post_status' => 'publish',
					'post_type' => 'nm-userfiles',
					'post_author' => $current_user -> ID,
					'comment_status' => 'closed',
					'ping_status' => 'closed',
					'post_parent' => intval($_REQUEST['parent_id']),
			);
			
			
			// saving the post into the database
			$the_post_id = wp_insert_post ( $file_post );
			$post_ids[] = array('id' => $the_post_id, 'title' => $title, 'filename' => $file_data['filename']);
			
			update_post_meta($the_post_id, 'nm_log_file_download', 0);
			
			/**
			 * setting file group if selected after uploading
			 * @since 11.4
			 **/
			if( isset($file_data['file_group']) && $file_data['file_group'] != '') {
				
				wp_set_object_terms( $the_post_id , $file_data['file_group'], 'file_groups');
			}
			
			/**
			**************** If Share File Add on enabled *****************************
			*/
			if ( class_exists ( 'NM_WP_FileManager_Addon' ) && isset($_POST['shareusers']) && $_POST['shareusers'] != '' ) {
				//$nmfilemanager_addon = new NM_WP_FileManager_Addon();
				update_post_meta($the_post_id, 'shared_with', $_POST['shareusers']);
			}
			/**
			**************** If Share File Add on enabled *****************************
			*/
			
			// adding taxonomy to file.explode(',', $this->group_id)
			if (isset($_POST['file_term_id']) && $_POST['file_term_id'] !== '0'){
				$myar = explode(',', $_POST['file_term_id']); //array('3');
				$terms = array_map('intval', $myar );
				wp_set_object_terms( $the_post_id , $terms, 'file_groups');
			}

			/* sharing file in buddypress group if set to sahre */
			if (isset($_REQUEST['nm_share_bp_group_id']) && $_REQUEST['nm_share_bp_group_id'] !== '0'){
				$bp_group_file_option = groups_get_groupmeta( $nm_share_bp_group_id, $meta_key = 'nm_bp_file_sharing');
				if ($bp_group_file_option == 'group')
					update_post_meta($the_post_id, 'nm_share_bp_group_id', $nm_share_bp_group_id);
			}

			
			
			$post_attachment_url = '';
			$post_attachment_path = '';
			
			/**
			**************** If Amzon S3 Add-on enabled *****************************
			*/
			
			if ( $this -> is_amazon_enabled	&& isset($file_data['amazon']) ) {
				
				$file_saved_location = 'amazon';
				
				update_post_meta($the_post_id, 'amazon_data', $file_data['amazon']);
				$post_attachment_url = $file_data['location'];
				
				
			}else{
			
				$post_attachment_url 	= $this -> get_file_dir_url() . $file_data['filename'];
				$post_attachment_path 	= $this -> get_file_dir_path() . $file_data['filename'];
				$file_saved_location			= 'local';
			
			}
			/**
			**************** If Amzon S3 Add-on enabled *****************************
			*/
			
			
			if( file_exists($post_attachment_path) ){
				
				$wp_filetype = wp_check_filetype(basename( $post_attachment_url ), null );
			
				$attachment = array(
						'guid' => $post_attachment_url,
						'post_mime_type' => $wp_filetype['type'],
						'post_title' => basename($post_attachment_url),
						'post_content' => '',
						'post_status' => 'inherit'
				);
		
				$attach_id = wp_insert_attachment($attachment, $post_attachment_url, $the_post_id);
				
				wp_update_attachment_metadata( $attach_id, wp_generate_attachment_metadata($attach_id, $post_attachment_path ));
			}
			
			
			//setting a post meta for file location 1. local or 2. amazon
			update_post_meta($the_post_id, 'file_location', $file_saved_location);
			
			$admin_message = ($this -> get_option ( '_file_saved' ) == '' ? 'File saved' : $this -> get_option ( '_file_saved' ));
			update_user_meta( $current_user -> ID, '_nm_used_filesize', $this -> get_user_files_size() );
			
			// Action
			do_action('nm_after_file_created', $the_post_id, $post_attachment_path);
		
		}
		
			$resp ['status'] = 'success';
			$resp ['postids'] = $post_ids;
			$resp ['message'] = sprintf(__("%s", 'nm-filemanager'), $admin_message);
		
		$is_notfiy_admin = $this -> get_option ( '_admin_email' );
		if ($the_post_id && $is_notfiy_admin == 'yes' ){
			
			$email_resp = $this -> send_notifications_email_ng( $post_ids );
			$resp['email'] = $email_resp;
		  
		}
		
		
		echo json_encode ( $resp );
		
		die ( 0 );
	}
	
	/*
	 * sending data to admin/others - old version
	 */
	function save_file_data() {
		
		global $wpdb;
		$current_user = get_userdata( get_current_user_id() );
		$allow_public = nm_can_public_upload_files();
		if ($current_user -> ID == 0 && $allow_public == 'yes')
			$current_user = get_userdata($this -> get_option('_public_user'));
		
		//print_r($_REQUEST); exit;
		extract( $_REQUEST );
		
		if (empty ( $_POST ) || ! wp_verify_nonce ( $_POST ['nm_filemanager_nonce'], 'saving_file' )) {
			print 'Sorry, You are not HUMANE.';
			exit ();
		}
		
		//it's a flag property to restrict thumbs generation only for uploader not for all other media upload in wp
		$this -> is_uploader = true;
		
		$submitted_data = $_REQUEST;
		
		unset ( $submitted_data ['action'] );
		unset ( $submitted_data ['nm_filemanager_nonce'] );
		unset ( $submitted_data ['_wp_http_referer'] );
		unset ( $submitted_data ['file_term_id'] );
		unset ( $submitted_data ['nm_share_bp_group_id'] );		
		//unset ( $submitted_data ['admin_file_term_id'] );		
		
		
		//merging all file title and description in each array
		$all_files_with_data = array();
		foreach($uploaded_files as $key => $file){
			
			$all_files_with_data[$key] = array('filename'	=> $file,
												'title'		=> $file_title[$key],
												'description'	=> $file_description[$key],
												);
		}
		
		$post_ids = array();		//saving all post ids
		foreach( $all_files_with_data as $key => $file_data){
			
			$allowed_html = array (
				'a' => array (
						'href' => array (),
						'title' => array () 
				),
				'br' => array (),
				'em' => array (),
				'strong' => array (),
				'p' => array (),
				'ul' => array (),
				'li' => array (),
				'h3' => array () 
			);
		
			$title = sanitize_text_field ( $file_data['title'] );
		
			// creating post
			$file_post = array (
					'post_title' => $title,
					'post_content' => wp_kses ( $file_data['description'], $allowed_html ),
					'post_status' => 'publish',
					'post_type' => 'nm-userfiles',
					'post_author' => $current_user -> ID,
					'comment_status' => 'closed',
					'ping_status' => 'closed',
					'post_parent' => intval($_REQUEST['parent_id']),
			);
			
			
			// saving the post into the database
			$the_post_id = wp_insert_post ( $file_post );
			$post_ids[] = array('id' => $the_post_id, 'title' => $title, 'filename' => $file_data['filename']);
			
			update_post_meta($the_post_id, 'nm_log_file_download', 0);
			
			/**
			**************** If Share File Add on enabled *****************************
			*/
			if ( class_exists ( 'NM_WP_FileManager_Addon' ) && $_POST['shareusers'] != '' ) {
				//$nmfilemanager_addon = new NM_WP_FileManager_Addon();
				update_post_meta($the_post_id, 'shared_with', $_POST['shareusers']);
			}
			/**
			**************** If Share File Add on enabled *****************************
			*/
			
			// adding taxonomy to file.explode(',', $this->group_id)
			if ($file_term_id !== 0){
				$myar = explode(',', $file_term_id); //array('3');
				$terms = array_map('intval', $myar );
				wp_set_object_terms( $the_post_id , $terms, 'file_groups');
			}

			/* sharing file in buddypress group if set to sahre */
			if (isset($_REQUEST['nm_share_bp_group_id']) && $_REQUEST['nm_share_bp_group_id'] !== ''){
				$bp_group_file_option = groups_get_groupmeta( $nm_share_bp_group_id, $meta_key = 'nm_bp_file_sharing');
				if ($bp_group_file_option == 'group')
					update_post_meta($the_post_id, 'nm_share_bp_group_id', $nm_share_bp_group_id);
			}

			
			$post_attachment_url 	= $this -> get_file_dir_url() . $file_data['filename'];
			$post_attachment_path 	= $this -> get_file_dir_path() . $file_data['filename'];
			$file_saved_location			= 'local';
			
			/**
			**************** If Amzon S3 Add-on enabled *****************************
			*/
			
			if ( $this -> is_amazon_enabled ) {
				
				$amazon_bucket	= $this->get_option('_amazon_bucket');
				
				//getting user directory to append as key/filename
				$current_user = get_userdata( get_current_user_id() );
				$allow_public = nm_can_public_upload_files();
				if ($current_user -> ID == 0 && $allow_public == 'yes')
					$current_user = get_userdata($this -> get_option('_public_user'));
				
				$file_key = $current_user -> user_login . '/' . $file_data['filename'];
				
				
				if(file_exists($post_attachment_path)){
					
					try {
						$s3_resp = NMAMAZONS3() -> upload_file($amazon_bucket, $post_attachment_path, $file_key);
						
					}
					catch ( Exception $e ) {
						error_log( 'Error uploading ' . $file_key . ' to S3: ' . $e->getMessage() );
					}
					
					$file_saved_location = 'amazon';
				}
				
				
			}
			/**
			**************** If Amzon S3 Add-on enabled *****************************
			*/
			
			
			$wp_filetype = wp_check_filetype(basename( $post_attachment_url ), null );
			
			$attachment = array(
					'guid' => $post_attachment_url,
					'post_mime_type' => $wp_filetype['type'],
					'post_title' => basename($post_attachment_url),
					'post_content' => '',
					'post_status' => 'inherit'
			);
	
			$attach_id = wp_insert_attachment($attachment, $post_attachment_url, $the_post_id);
			
			//setting a post meta for file location 1. local or 2. amazon
			update_post_meta($the_post_id, 'file_location', $file_saved_location);
			
			wp_update_attachment_metadata( $attach_id, wp_generate_attachment_metadata($attach_id, $post_attachment_path ));
			
			$admin_message = ($this -> get_option ( '_file_saved' ) == '' ? 'File saved' : $this -> get_option ( '_file_saved' ));
			update_user_meta( $current_user -> ID, '_nm_used_filesize', $this -> get_user_files_size() );
			
			// Action
			do_action('nm_after_file_created', $the_post_id, $post_attachment_path);
			
			//if file is uploaded to Amazon then delete local file.
			if( $file_saved_location == 'amazon' ){
				@unlink( $post_attachment_path );
			}
		
		}
		
			$resp ['status'] = 'success';
			$resp ['postids'] = $post_ids;
			$resp ['message'] = sprintf(__("%s", 'nm-filemanager'), $admin_message);
		
		$is_notfiy_admin = $this -> get_option ( '_admin_email' );
		if ($the_post_id && $is_notfiy_admin == 'yes' && !get_option('filemanager_meta') ){
			
			$file_meta['_post_id'] = $the_post_id;
			$email_resp = $this -> send_notifications_email( $file_data, $file_meta );
		  
		}
		
		
		echo json_encode ( $resp );
		
		die ( 0 );
	}
	

	
	/*
	 * sending data to admin/others
	 */
	function save_ftp_files() {
		
		$arrUsers = get_users( array( 'fields' => array( 'ID', 'display_name' ) ) );
		//filemanager_pa($arrUsers);exit();
		
		foreach ( $arrUsers as $user ) {

			$scr_file_path = $this->get_author_file_dir_path($user->ID);
			
			if ( is_dir ( $scr_file_path.'ftp/' ) && $handle = opendir( $scr_file_path.'ftp/' )) {
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != "..") {
						//copy file to user's folder
						if ( copy( $scr_file_path.'ftp/'.$entry, $scr_file_path.$entry) ){
							// making thumb if images
							if($this -> is_image($entry))
							{
								$h = $this -> get_option('_thumb_size', 150);
								$w = $this -> get_option('_thumb_size', 150);				
								$thumb_size = array(array('h' => $h, 'w' => $w, 'crop' => true),
								);
								$thumb_meta = $this -> create_thumb($scr_file_path, $entry, $thumb_size);
							}
							
							if ($this->save_ftp_file($entry, $user->ID) ){
								unlink($scr_file_path.'ftp/'.$entry);
								echo $entry . __(" posted to ", 'nm-filemanager'). $user->display_name . "<br/>";
							}
						}
					}
				}
		    	closedir($handle);
			}
		}		
		
		die ( 0 );
	}

	/*
	 * saving single ftp file
	 */
	function save_ftp_file($filename, $userid) {

		// creating post
		$file_post = array (
				'post_title' => $filename,
				'post_content' => $filename,
				'post_status' => 'publish',
				'post_type' => 'nm-userfiles',
				'post_author' => $userid,
				'comment_status' => 'closed',
				'ping_status' => 'closed',
				'post_parent' => 0,
		);
		
		
		// saving the post into the database
		$the_post_id = wp_insert_post ( $file_post );
		
		if ( $the_post_id ){
			update_post_meta($the_post_id, 'nm_log_file_download', 0);
			update_post_meta($the_post_id, 'nm_ftp_uploaded', 'yes');
		}

		$post_attachment_url 	= $this -> get_file_dir_url($userid) . $filename;
		$post_attachment_path 	= $this -> get_author_file_dir_path($userid) . $filename;
		$file_saved_location			= 'local';

		$wp_filetype = wp_check_filetype(basename( $post_attachment_url ), null );
		
		$attachment = array(
				'guid' => $post_attachment_url,
				'post_mime_type' => $wp_filetype['type'],
				'post_title' => basename($post_attachment_url),
				'post_content' => '',
				'post_status' => 'inherit'
		);

		$attach_id = wp_insert_attachment($attachment, $post_attachment_url, $the_post_id);
		
		//setting a post meta for file location 1. local or 2. amazon
		update_post_meta($the_post_id, 'file_location', $file_saved_location);
		
		wp_update_attachment_metadata( $attach_id, wp_generate_attachment_metadata($attach_id, $post_attachment_path ));
		
		$admin_message = ($this -> get_option ( '_file_saved' ) == '' ? 'File saved' : $this -> get_option ( '_file_saved' ));
		update_user_meta( $userid, '_nm_used_filesize', $this -> get_user_files_size() );
		
		$is_notfiy_admin = $this -> get_option ( '_admin_email' );
		if ($the_post_id )
			return true;
		else
			return false;
		
	}
	
	
	/**
	 * sending email to admin 
	 * @since 12.0
	 **/
	function send_notifications_email_ng($uploaded_files){
	 	
	 	if( ! is_array($uploaded_files) ) 
	 		return;
	 		
	 	$site_title = get_bloginfo();
	 	$from_email = $this -> get_option('_from_email');
	 	$from_email = ($from_email == '' ? get_bloginfo('admin_email') : $from_email);
		
		$mail_recipients = $this -> get_option ( '_mail_recipients' ); ;
	    $mail_recipients = ($mail_recipients == '' ? get_bloginfo('admin_email') : explode(',', $mail_recipients));
		
		
		// building email content
		$email_html = sprintf(__('Following file(s) uploaded via website %s', 'nm-filemanager'), $site_title);
		
		
		$file_titles = array();
	    foreach($uploaded_files as $file) {
	    	
	    	$file_title = isset($file['title']) ? $file['title'] : $file['filename'];
	    	$file_name  = $file['filename'];
	    	$file_id	= $file['id'];
	    	
	    	// for email subject only
	    	$file_titles[] = $file_title;
	    	
	    	$file_download_url = $this->generate_download_url($file_id);
	    	
	    	
	    	$email_html .= "<p>" .sprintf(__('File Title: %s', 'nm-filemanager'), $file_title) . "</p>";
	    	$email_html .= '<p> <a href="' . esc_url($file_download_url) . '">'.sprintf(__('Download File %s', 'nm-filemanager'), $file_name).'</a> </p>';
	    	$email_html .= '<br><hr>';
	    }
	    
	    
		$subject = sprintf(__("File(s) Received %s", 'nm-filemanager'), implode(',', $file_titles) );
		
		
		//Filters
		if(has_filter('fileupload_from_email')) {
			$from_email = apply_filters('fileupload_from_email', $from_email);
		}
		
		if(has_filter('fileupload_subject')) {
			$subject = apply_filters('fileupload_subject', $subject, $file_titles);
		}
		
							 
		if(has_filter('fileupload_message')) {
			$message = apply_filters('fileupload_message', $email_html, $uploaded_files);
		}
		
		if(has_filter('fileupload_receivers')) {
			$mail_recipients = apply_filters('fileupload_receivers', $mail_recipients);
		}

		$headers[] = "From: {$site_title} <{$from_email}>";
		$headers[] = "Content-Type: text/html";
		$headers[] = "MIME-Version: 1.0\r\n";
		
	
		if (wp_mail ( $mail_recipients, $subject, $email_html, $headers )) {					  
			  $resp ['mail_message'] = __( 'Mail sent successfully!', 'nm-filemanager' );	  
		} else {
			  $resp ['mail_message'] = __ ( 'Error: while seding Email', 'nm-filemanager' );		  
		}
		
		return $resp;
	 }
	
	/**
	 * sending notifcation email to receivers
	 * */
	 
	 function send_notifications_email($file_data, $file_meta=null){
	 	
	 	$site_title = get_bloginfo();
		$from_email = $this -> get_option('_from_email');
		
		$file_id	= isset($file_meta['_post_id']) ? $file_meta['_post_id'] : null;
		
	    
	    $from_email = ($from_email == '' ? get_bloginfo('admin_email') : $from_email);
	    
	    $mail_recipients = explode(',', $this -> get_option ( '_mail_recipients' ));
	    $mail_recipients = ($mail_recipients == '' ? get_bloginfo('admin_email') : $mail_recipients);

		
		$url_private_download = $this -> generate_download_url($file_id);
		 
		$subject = __("A file is uploaded - ", 'nm-filemanager') . $file_data['filename'];
		
		
		$message  = '';
		$message .= "<p>" . __ ( 'A file is being uploaded via website: ', 'nm-filemanager' ) . $site_title . "</p>";
		$message .= "<p>Filename: " . $file_data['filename'] . "</p>";
		$message .= '<p> <a href="' . $url_private_download . '">'.$file_data['filename'].'</a> </p>';

		//Filters
		if(has_filter('fileupload_from_email')) {
			$from_email = apply_filters('fileupload_from_email', $from_email);
		}
		
		if(has_filter('fileupload_subject')) {
			$subject = apply_filters('fileupload_subject', $subject, $file_data['filename']);
		}
		
		$filter_args = array('title'	 	=> $file_data['title'],
							 'file_name' 	=> $file_data['filename'],
							 'file_meta'	=> $file_meta
							 );
							 
		if(has_filter('fileupload_message')) {
			$message = apply_filters('fileupload_message', $message, $filter_args);
		}
		
		if(has_filter('fileupload_receivers')) {
			$mail_recipients = apply_filters('fileupload_receivers', $mail_recipients);
		}

		$headers[] = "From: {$site_title} <{$from_email}>";
		$headers[] = "Content-Type: text/html";
		$headers[] = "MIME-Version: 1.0\r\n";
		
		if (wp_mail ( $mail_recipients, $subject, $message, $headers )) {					  
			  $resp ['mail_message'] = __( 'Mail sent successfully!', 'nm-filemanager' );	  
		} else {
			  $resp ['mail_message'] = __ ( 'Error: while seding Email', 'nm-filemanager' );		  
		}
		
		return $resp;
	 }

	/*
	 * sending data to admin/others
	 */
	function update_file_data() {
		global $wpdb;

		// print_r($_REQUEST); exit;
		
		if (empty ( $_POST ) || ! wp_verify_nonce ( $_POST ['nm_filemanager_nonce'], 'doing_contact' )) {
			print 'Sorry, You are not HUMANE.';
			exit ();
		}
		
	
	
		// saving contact form if Enabled
		$postid = $_REQUEST['_post_id'];
		unset( $_REQUEST['nm_filemanager_nonce'] );
		unset( $_REQUEST['action'] );
		unset( $_REQUEST['_wp_http_referer']);
		
		$file_data = array('title' => $_REQUEST['_post_title'], 'filename' => $_REQUEST['_post_filename']);
		
		$meta_status = 'updated';
		if($_REQUEST['_post_filename'] != 'undefined'){
			$this -> send_notifications_email($file_data, $_REQUEST);
			$meta_status = 'saved';
		}

		
		/* =============== updating meta values ======================= */
		
		foreach ( $_REQUEST as $key => $val ) {
			update_post_meta ( $postid, $key, $val );
		}
	
		
		$resp = array('status' => $meta_status, 'message' => __('File meta saved successfully', 'nm-filemanager'), 'postid' => $postid );
		echo json_encode ( $resp );
		
		die ( 0 );
	}
		
	/*
	 * rendering email template
	 */
	function render_email_template() {
		ob_start ();
		$this->load_template ( '/render.email.php' );
		return ob_get_clean ();
	}
	
	/*
	 * uploading file here
	 */
	function upload_file() {
	
	
		header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
		header ( "Last-Modified: " . gmdate ( "D, d M Y H:i:s" ) . " GMT" );
		header ( "Cache-Control: no-store, no-cache, must-revalidate" );
		header ( "Cache-Control: post-check=0, pre-check=0", false );
		header ( "Pragma: no-cache" );
	
		// setting up some variables
		$file_dir_path = $this->setup_file_directory ();
		$response = array ();
		if ($file_dir_path == 'errDirectory') {
				
			$response ['status'] = 'error';
			$response ['message'] = __ ( 'Error while creating directory', 'nm-filemanager' );
			die ( 0 );
		}
		
		$file_name = '';
		
		if( isset($_REQUEST['name']) && $_REQUEST['name'] != '') {
			$file_name = sanitize_file_name( $_REQUEST['name'] );
		}elseif( isset($_REQUEST['_file']) && $_REQUEST['_file'] != '') {
			$file_name = sanitize_file_name( $_REQUEST['_file'] );
		}
		
		
		// Clean the fileName for security reasons
		$file_name = preg_replace ( '/[^\w\._]+/', '_', $file_name );
		$file_name = strtolower($file_name);
		
		$file_name = apply_filters('filemanager_filename', $file_name);
		
		/* ========== Invalid File type checking ========== */
		$file_type = wp_check_filetype_and_ext($file_dir_path, $file_name);
		$extension = $file_type['ext'];
		
		// for some files if above function fails to check extension we need to check otherway
		if( ! $extension ) {
			$extension = pathinfo($file_name, PATHINFO_EXTENSION);
		}
		
		$allowed_types = $this -> get_option('_file_types');
		if( ! $allowed_types ) {
			$good_types = apply_filters('nm_allowed_file_types', array('jpg', 'png', 'gif', 'zip','pdf') );
		}else {
			$good_types = explode(",", $allowed_types );
		}
		
	
		if( ! in_array($extension, $good_types ) ){
			$response ['status'] = 'error';
			$response ['message'] = __ ( 'File type not valid', 'nm-filemanager' );
			die ( json_encode($response) );
		}
		/* ========== Invalid File type checking ========== */
	
		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds
	
		// 5 minutes execution time
		@set_time_limit ( 5 * 60 );
	
		// Uncomment this one to fake upload time
		// usleep(5000);
	
		// Get parameters
		$chunk = isset ( $_REQUEST ["chunk"] ) ? intval ( $_REQUEST ["chunk"] ) : 0;
		$chunks = isset ( $_REQUEST ["chunks"] ) ? intval ( $_REQUEST ["chunks"] ) : 0;
	
		
	
		// Make sure the fileName is unique but only if chunking is disabled
		if ($chunks < 2 && file_exists ( $file_dir_path . $file_name )) {
			$ext = strrpos ( $file_name, '.' );
			$file_name_a = substr ( $file_name, 0, $ext );
			$file_name_b = substr ( $file_name, $ext );
				
			$count = 1;
			while ( file_exists ( $file_dir_path . $file_name_a . '_' . $count . $file_name_b ) )
				$count ++;
				
			$file_name = $file_name_a . '_' . $count . $file_name_b;
		}
	
		// Remove old temp files
		if ($cleanupTargetDir && is_dir ( $file_dir_path ) && ($dir = opendir ( $file_dir_path ))) {
			while ( ($file = readdir ( $dir )) !== false ) {
				$tmpfilePath = $file_dir_path . $file;
	
				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match ( '/\.part$/', $file ) && (filemtime ( $tmpfilePath ) < time () - $maxFileAge) && ($tmpfilePath != "{$file_path}.part")) {
					@unlink ( $tmpfilePath );
				}
			}
				
			closedir ( $dir );
		} else
			die ( '{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}' );
	
		$file_path = $file_dir_path . $file_name;
	
		// Look for the content type header
		if (isset ( $_SERVER ["HTTP_CONTENT_TYPE"] ))
			$contentType = $_SERVER ["HTTP_CONTENT_TYPE"];
	
		if (isset ( $_SERVER ["CONTENT_TYPE"] ))
			$contentType = $_SERVER ["CONTENT_TYPE"];
			
		// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
		if (strpos ( $contentType, "multipart" ) !== false) {
			if (isset ( $_FILES ['file'] ['tmp_name'] ) && is_uploaded_file ( $_FILES ['file'] ['tmp_name'] )) {
				// Open temp file
				$out = fopen ( "{$file_path}.part", $chunk == 0 ? "wb" : "ab" );
				if ($out) {
					// Read binary input stream and append it to temp file
					$in = fopen ( $_FILES ['file'] ['tmp_name'], "rb" );
						
					if ($in) {
						while ( $buff = fread ( $in, 4096 ) )
							fwrite ( $out, $buff );
					} else
						die ( '{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}' );
					fclose ( $in );
					fclose ( $out );
					@unlink ( $_FILES ['file'] ['tmp_name'] );
				} else
					die ( '{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}' );
			} else
				die ( '{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}' );
		} else {
			// Open temp file
			$out = fopen ( "{$file_path}.part", $chunk == 0 ? "wb" : "ab" );
			if ($out) {
				// Read binary input stream and append it to temp file
				$in = fopen ( "php://input", "rb" );
	
				if ($in) {
					while ( $buff = fread ( $in, 4096 ) )
						fwrite ( $out, $buff );
				} else
					die ( '{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}' );
	
				fclose ( $in );
				fclose ( $out );
			} else
				die ( '{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}' );
		}
	
		// Check if file has been uploaded
		if (! $chunks || $chunk == $chunks - 1) {
			// Strip the temp .part suffix off
			rename ( "{$file_path}.part", $file_path );
				
			// making thumb if images
			if($this -> is_image($file_name))
			{
				$h = $this -> get_option('_thumb_size', 150);
				$w = $this -> get_option('_thumb_size', 150);				
				$thumb_size = array(array('h' => $h, 'w' => $w, 'crop' => true),
				);
				$thumb_meta = $this -> create_thumb($file_dir_path, $file_name, $thumb_size);
	
				$response = array(
						'file_name'			=> $file_name,
						'thumb_meta'			=> $thumb_meta,
						'status' => 'success',
						'file_groups'	=> nm_show_file_groups());
			}else{
				$response = array(
						'file_name'			=> $file_name,
						'file_w'			=> 'na',
						'file_h'			=> 'na',
						'status' => 'success',
						'file_groups'	=> nm_show_file_groups());
			}
		}
			
		// Return JSON-RPC response
		//die ( '{"jsonrpc" : "2.0", "result" : '. json_encode($response) .', "id" : "id"}' );
		die ( json_encode($response) );
	
	
	}
	
	/*
	 * deleting uploaded file from directory
	 */
	function delete_file() {
		
		//check if it has attachment
		$file_id = intval($_REQUEST['pid']);
		$file_title = get_the_title($file_id);
		$args = array(
			'post_type' => 'attachment',
			'numberposts' => null,
			'post_status' => null,
			'post_parent' => $file_id
		);
		$attachments = get_posts($args);

		if ($attachments) {
			foreach($attachments as $attachment){
				$file_name = $this -> get_attachment_file_name( $file_id );
				$dir_path = $this -> setup_file_directory();
				
				$file_path = $dir_path . $file_name;
	
				if(get_post_meta($file_id, 'file_location', true) == 'amazon')
					$this -> delete_file_amazon($file_name);
				
				if (file_exists($file_path)) {
					if (unlink($file_path)) {
						$file_path_thumb = $dir_path . 'thumbs/' . $file_name;
						if (file_exists($file_path_thumb)) {
							unlink($file_path_thumb);
						}
					}
				}
				
				/********* deleting all thumbs of the image *********/
				$sizes = array_merge(array('full'),get_intermediate_image_sizes());
				foreach ($sizes as $imageSize) {
					$image_object = wp_get_attachment_image_src($attachment->ID, $imageSize );
					$image_thumb_path = $dir_path.basename($image_object[0]);
					if (file_exists($file_path_thumb) && !is_dir($file_path_thumb)) {
						unlink($image_thumb_path);
					}
				}
				/***************************************************/

				wp_delete_attachment($attachment->ID, true);
			}
		}else{
			$this -> delete_children($file_id);
		}

	  	if( wp_delete_post( $file_id ) ){
			  echo '<div class="nm-prefix">';
			  	echo '<div class="alert alert-info">';
			  		echo sprintf(__('%s is successfully Removed', 'nm-filemanager'), $file_title);
			  	echo '</div>';
			  echo '</div>';
			  update_user_meta( get_current_user_id(), '_nm_used_filesize', $this -> get_user_files_size() );
			  
			  if ($this-> get_option('_enable_old_version') == 'yes') {
				  $sendback = remove_query_arg( array('pid', 'do'), wp_get_referer() );
				  wp_redirect( $sendback );
	   			  exit;
			  }

		}
		
		
		die(0);
	
	}
	
	private function delete_children($post_id){
		
		$args = array(
			'post_type' => 'nm-userfiles',
			'posts_per_page' => -1, 
			'post_status' =>'any',
			'post_parent' => $post_id
		);

	  	$posts = get_posts($args);
		//filemanager_pa($posts);exit();
	  	if (is_array($posts) && count($posts) > 0) {
  			//filemanager_pa($posts);
	  		// Delete all the Children of the Parent Post
	  		foreach($posts as $post){
	  			
				//check if it has attachment
				$sub_args = array(
					'post_type' => 'attachment',
					'numberposts' => null,
					'post_status' => null,
					'post_parent' => $post->ID
				);
				$attachments = get_posts($sub_args);
				if ($attachments) {
					foreach($attachments as $attachment){
						$file_name = $this -> get_attachment_file_name( $post->ID );
						$dir_path = $this -> setup_file_directory();
						$file_path = $dir_path . $file_name;
			
						if(get_post_meta($post->ID, 'file_location', true) == 'amazon')
							$this -> delete_file_amazon($file_name);
						
						if (file_exists($file_path)) {
							if (unlink($file_path)) {
								$file_path_thumb = $dir_path . 'thumbs/' . $file_name;
								if (file_exists($file_path_thumb)) {
									unlink($file_path_thumb);
								}
							}
						}

						/********* deleting all thumbs of the image *********/
						$sizes = array_merge(array('full'),get_intermediate_image_sizes());
						foreach ($sizes as $imageSize) {
							$image_object = wp_get_attachment_image_src($attachment->ID, $imageSize );
							$image_thumb_path = $dir_path.basename($image_object[0]);
							if ( file_exists( $image_thumb_path ) ) {
								unlink($image_thumb_path);
							}
						}
						/***************************************************/
						
						wp_delete_attachment($attachment->ID, true);
					}

					//wp_delete_attachment($post->ID);
				}else{
					$this -> delete_children($post->ID);
				}
  
				wp_delete_post($post->ID, true);
  
		  	}
  
  		}
	}
	
	private function delete_children_nj($post_id, $has_attachment=true){
		
		
		$post_type = ($has_attachment == true ? 'attachment' : 'nm-userfiles');
		
		$args = array(
				'post_type' => $post_type,
				'posts_per_page' => -1, 
				'post_status' => 'any',
			  	'post_parent' => intval( $post_id ),
			  	);
		
	  	$posts = get_posts($args);
		
		
	  	if (is_array($posts) && count($posts) > 0) {
  			//filemanager_pa($posts);
	  		// Delete all the Children of the Parent Post
	  		foreach($posts as $post){
	  			
				//check if it has attachment
				$args = array(
					'post_type' => 'attachment',
					'numberposts' => null,
					'post_status' => null,
					'post_parent' => $post_id
				);
				$attachments = get_posts($args);
				if ($attachments) {
					foreach($attachments as $attachment){
						$file_name = $this -> get_attachment_file_name( $file_id );
						$dir_path = $this -> setup_file_directory();
						$file_path = $dir_path . $file_name;
			
						if(get_post_meta($file_id, 'file_location', true) == 'amazon')
							$this -> delete_file_amazon($file_name);
						
						if (file_exists($file_path)) {
							if (unlink($file_path)) {
								$file_path_thumb = $dir_path . 'thumbs/' . $file_name;
								if (file_exists($file_path_thumb)) {
									unlink($file_path_thumb);
								}
							}
						}
						wp_delete_attachment($attachment->ID, true);
					}

					//wp_delete_attachment($post->ID);
				}else{
					$this -> delete_children($post->ID);
				}
  
				wp_delete_post($post->ID, true);
  
		  	}
  
  		}
	}	
	
	/**
	 * follwing function is deleting file physically once it is uploaded
	 * but not saved as post
	 */
	function delete_file_new() {
		$dir_path = $this -> setup_file_directory();
		$file_path = $dir_path . $_REQUEST['file_name'];
		if( file_exists($file_path))
			$file_size = filesize($file_path);
		$response = array();
		
		if (file_exists($file_path)) {
			if (unlink($file_path)) {
	
				$response ['file_size'] = $file_size;
				$response ['message'] = __ ( 'File removed', 'nm-filemanager' );

				$file_path_thumb = $dir_path . 'thumbs/' . $_REQUEST['file_name'];
				if (file_exists($file_path_thumb)) {
					if (unlink($file_path_thumb)) {
						//$response ['file_size'] = $file_size;
						$response ['message'] = __ ( 'File removed', 'nm-filemanager' );
					}
				}
				echo json_encode($response);
			}

		} else {
			$response ['message'] = sprintf(__('Error while deleting file %s', 'nm-filemanager'), $file_path);
			echo json_encode($response);
		}

		die(0);
	}
	
	/**
	 * 
	 * check if amazon enaabled or not
	 * 
	 * @since 10.5
	 */
	 public function check_amazon_enabled() {
	 	
	 	$return = false;
	 	if ( class_exists('NM_Amazon_S3_Addon') && $this->get_option('_enable_amazon') == 'yes' ) {
				$return = true;
			}else{
				
				$return = false;
			}
			
			return $return;
	 }
	
	/**
	 * deleting files from amazon if Exist
	 * */
	 function delete_file_amazon($filename){
	 	
	 	if ( $this -> is_amazon_enabled ) {
				
				$amazon_bucket	= $this->get_option('_amazon_bucket');
				
				//getting user directory to append as key/filename
				$current_user = get_userdata( get_current_user_id() );
				$allow_public = nm_can_public_upload_files();
				if ($current_user -> ID == 0 && $allow_public == 'yes')
					$current_user = get_userdata($this -> get_option('_public_user'));
				
				$file_key = $current_user -> user_login . '/' . $filename;
				
				NMAMAZONS3() -> delete_file($amazon_bucket, $file_key);
			}
		
	 }
	/*
	 * saving contact form as CPT: nm-userfiles
	 */
	function save_contact_form($subject, $message, $attachments, $submitted_data) {
		$allowed_html = array (
				'a' => array (
						'href' => array (),
						'title' => array () 
				),
				'br' => array (),
				'em' => array (),
				'strong' => array (),
				'p' => array (),
				'ul' => array (),
				'li' => array (),
				'h3' => array () 
		);
		
		$title = date ( 'D,m-Y' ) . '-' . sanitize_text_field ( $subject );
		//$file_name = array_values($attachments);
		
		//$file_name = preg_replace ( '/[^\w\._]+/', '_', $file_name );
		$posttitle = ($attachments == '') ? $title : $attachments;
		// creating post
		$contact_form = array (
				'post_title' => $posttitle,
				'post_content' => wp_kses ( $message, $allowed_html ),
				'post_status' => 'private',
				'post_type' => 'nm-userfiles',
				'post_author' => '',
				'comment_status' => 'closed',
				'ping_status' => 'closed' 
		);
		
		// saving the post into the database
		$formid = wp_insert_post ( $contact_form );
		
		// now adding submitted data as form/post meta
		foreach ( $submitted_data as $key => $val ) {
			update_post_meta ( $formid, $key, $val );
		}
		
		// files uploaded
		//update_post_meta ( $formid, '_file_meta', json_encode ( $attachments ) );
		$file_dir_path = $this->get_file_dir_path();
		update_post_meta ($formid, '_file_path', $file_dir_path);
	}
	
	/*
	 * this function is saving photo returned by Aviary
	 */
	function save_edited_photo() {
		$file_path = $this->plugin_meta ['path'] . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'aviary.php';
		if (! file_exists ( $file_path )) {
			die ( 'Could not find file ' . $file_path );
		}
		
		include_once $file_path;
		
		$aviary = new NM_Aviary ();
		
		$aviary->plugin_meta = get_plugin_meta_filemanager();
		$aviary->dir_path = $this->get_file_dir_path ();
		$aviary->dir_name = $this->user_uploads;
		$aviary->posted_data = json_decode ( stripslashes ( $_REQUEST ['postdata'] ) );
		$aviary->image_data = file_get_contents ( $_REQUEST ['url'] );
		
		$aviary->save_file_locally ();
		die ( 0 );
	}
	
	
	/**
	 * sharing file with users with email
	 */
	
	function share_file(){

		/*
		 * loading uploader template
		 */

		$this -> load_template( '_template_share_file.php' );
		

		die(0);
	}
	
	
	function edit_file_meta(){

		/*
		 * loading uploader template
		 */

		$this -> load_template( '_template_file_meta.php' );
		

		die(0);
	}
	
	
	function extend_bp_group() {
		
		include('class.bpgroups.php');
	}
	
	// ================================ SOME HELPER FUNCTIONS =========================================
	
	/*
	 * getting meta based on id
	 */
	function get_forms($form_id = '') {
		$select = array (
				self::$tbl_file_meta => '*' 
		);
		
		if ($form_id) {
			$where = array (
					'd' => array (
							'form_id' => $form_id 
					) 
			);
			
			$res = $this->get_row_data ( $select, $where );
		} else {
			$where = NULL;
			$res = $this->get_rows_data ( $select, $where );
		}
		
		return $res;
	}
	
	/*
	 * simplifying meta for admin view in existing-meta.php
	 */
	function simplify_meta($meta) {
		$metas = json_decode ( $meta );
		
		echo '<ul>';
		if ($metas) {
			foreach ( $metas as $meta => $data ) {
				
				$req = ( isset( $data->required ) == 'on') ? 'yes' : 'no';
				
				echo '<li>';
				echo '<strong>label:</strong> ' . $data->title;
				echo ' | <strong>type:</strong> ' . $data->type;
				
				if ( isset( $data->options ) && ! is_object ( $data->options ))
					echo ' | <strong>options:</strong> ' . $data->options;
				echo ' | <strong>required:</strong> ' . $req;
				echo '</li>';
			}
			
			echo '</ul>';
		}
	}
	
	/*
	 * delete meta
	 */
	function delete_meta() {
		global $wpdb;
		
		extract ( $_REQUEST );
		
		$res = $wpdb->query ( "DELETE FROM `" . $wpdb->prefix . self::$tbl_file_meta . "` WHERE form_id = " . $formid );
		
		if ($res) {
			
			_e ( 'Meta deleted successfully', 'nm-filemanager' );
		} else {
			$wpdb->show_errors ();
			$wpdb->print_error ();
		}
		
		die ( 0 );
	}
	
	/*
	 * setting up user directory
	 */
	function setup_file_directory() {
		$current_user = get_userdata( get_current_user_id() );
		$allow_public = nm_can_public_upload_files();
		if ($current_user -> ID == 0 && $allow_public == 'yes')
			$current_user = get_userdata($this -> get_option('_public_user'));
		$upload_dir = wp_upload_dir ();
		
		$file_dir_path = $upload_dir ['basedir'] . '/' . $this->user_uploads . '/' . $current_user -> user_login . '/' ;
		
		if (! is_dir ( $file_dir_path )) {
			if (mkdir ( $file_dir_path, 0775, true ))
				$dirThumbPath = $file_dir_path . 'thumbs/';
				$dirFTP = $file_dir_path . 'ftp/';
			if ( mkdir ( $dirThumbPath, 0775, true ) && mkdir ( $dirFTP, 0775, true ) )
				return $file_dir_path;
			else
				return 'errDirectory';
		} else {
			$dirThumbPath = $file_dir_path . 'thumbs/';
			$dirFTP = $file_dir_path . 'ftp/';
			
			if (! is_dir ( $dirFTP )) 
				mkdir ( $dirFTP, 0775, true );

			if (! is_dir ( $dirThumbPath )) {
				if (mkdir ( $dirThumbPath, 0775, true ))
					return $file_dir_path;
				else
					return 'errDirectory';
			} else {
				return $file_dir_path;
			}
		}
	}
	
	/*
	 * getting file URL
	 */
	function get_file_dir_url($thumbs = false, $owner_id = null) {
		
		if ( in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) )
    		return;
    		
    	if ( !is_user_logged_in() )
    		return;
    		
		if($owner_id)
			$current_user = get_userdata( $owner_id );
		else
			$current_user = get_userdata( get_current_user_id() );
		
		$allow_public = nm_can_public_upload_files();
		if ($current_user -> ID == 0 && $allow_public == 'yes')
			$current_user = get_userdata($this -> get_option('_public_user'));
		
		//$content_url = content_url( 'uploads' );
		$content_url = wp_upload_dir();
		$content_url = $content_url['baseurl'];

		
		if ($thumbs)
			return $content_url . '/' . $this->user_uploads . '/' . $current_user -> user_login . '/thumbs/';
		else
			return $content_url . '/' . $this->user_uploads . '/' . $current_user -> user_login . '/';
	}
	
	function get_file_dir_path($sub_path = false) {
		$current_user = get_userdata( get_current_user_id() );
		$allow_public = nm_can_public_upload_files();
		if ($current_user -> ID == 0 && $allow_public == 'yes')
			$current_user = get_userdata($this -> get_option('_public_user'));
		$upload_dir = wp_upload_dir ();
		
		if ($sub_path) {
			return $upload_dir ['basedir'] . '/' . $this->user_uploads . '/' . $current_user -> user_login . '/' . $sub_path;
		}else{
			return $upload_dir ['basedir'] . '/' . $this->user_uploads . '/' . $current_user -> user_login . '/';
		}
		
		
	}

	/*
	 * geting file path of author. by QS
	 */
	function get_author_file_dir_path( $authorid ) {
		$current_user = get_userdata( $authorid );
		$upload_dir = wp_upload_dir ();
		
		return $upload_dir ['basedir'] . '/' . $this->user_uploads . '/' . $current_user -> user_login . '/';
	}

	
	/*
	 * creating thumb using WideImage Library Since 21 April, 2013
	 */
	function create_thumb($dest, $image_name, $thumb_size) {
	
		// using wp core image processing editor, 6 May, 2014
		$image = wp_get_image_editor ( $dest . $image_name );
		
		$thumbs_resp = '';
		if( is_array($thumb_size) ){
			
			foreach($thumb_size as $size){
				$thumb_name = $image_name;
				$thumb_dest = $dest . 'thumbs/' . $thumb_name;
				if (! is_wp_error ( $image )) {
					$image->resize ( $size['h'], $size['w'], $size['crop'] );
					$image->save ( $thumb_dest );
					$thumbs_resp[$thumb_name] = array('name' => $thumb_name, 'thumb_size' => getimagesize($thumb_dest) );
				}
			}
		}
		return $thumbs_resp;
	}

	
	
	function activate_plugin() {

		if ( ! wp_next_scheduled( 'setup_styles_and_scripts_nm_filemanager' ) ) {
			wp_schedule_event( time(), 'daily', 'setup_styles_and_scripts_nm_filemanager');
		}
		
	}

	function deactivate_plugin() {
		
		wp_clear_scheduled_hook( 'setup_styles_and_scripts_nm_filemanager' );

	}
	
	/*
	 * checking if aviary addon is installed or not
	 */
	function is_aviary_installed() {
		$aviary_file = $this->plugin_meta ['path'] . '/lib/aviary.php';
		
		if (file_exists ( $aviary_file ))
			return true;
		else
			return false;
	}
	
	/*
	 * returning NM_Inputs object
	 */
	private function get_all_inputs() {
		if (! class_exists ( 'NM_Inputs_filemanager' )) {
			$_inputs = $this->plugin_meta ['path'] . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'input.class.php';
			if (file_exists ( $_inputs ))
				include_once ($_inputs);
			else
				die ( 'Reen, Reen, BUMP! not found ' . $_inputs );
		}
		
		$nm_inputs = new NM_Inputs_filemanager ();
		// filemanager_pa($this->plugin_meta);
		
		// registering all inputs here
		
		return array (
				
				'text' 		=> $nm_inputs->get_input ( 'text' ),
				'masked' 	=> $nm_inputs->get_input ( 'masked' ),
				'email' 	=> $nm_inputs->get_input ( 'email' ),
				'date' 		=> $nm_inputs->get_input ( 'date' ),
				'textarea' 	=> $nm_inputs->get_input ( 'textarea' ),
				'select' 	=> $nm_inputs->get_input ( 'select' ),
				'radio' 	=> $nm_inputs->get_input ( 'radio' ),
				'checkbox' 	=> $nm_inputs->get_input ( 'checkbox' ),
				'file' 		=> $nm_inputs->get_input ( 'file' ),
				'image' 	=> $nm_inputs->get_input ( 'image' ),
				'section' 	=> $nm_inputs->get_input ( 'section' ),
		);
		
		// return new NM_Inputs($this->plugin_meta);
	}
	
	
	/*
	 * check if file is image and return true
	 */
	function is_image($file){
		
		$type = strtolower ( substr ( strrchr ( $file, '.' ), 1 ) );
		
		if (($type == "gif") || ($type == "jpeg") || ($type == "png") || ($type == "pjpeg") || ($type == "jpg"))
			return true;
		else 
			return false;
	}
	
	/**
	 * this function is checking the browser type and returning the 
	 * correct runtime for plupload
	 */
	 function get_runtime(){
	 	
		$filemanager_runtime = '';
		if(!(isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))){
				//return false;
				$filemanager_runtime = 'html5,flash,silverlight,html4,browserplus,gear';
			}else{
				$filemanager_runtime = 'html5,html4';
		}
			
		return $filemanager_runtime;
	 }
	 
	 function check_browser(){
		
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false) {
			return true;
		} else {
			return false;
		}

					
		
	 }
	
	/*
	 * download file
	 */
	function download_private_file(){

		
		if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'download' && !$_REQUEST['file_name'] == '') {
			
			
			$retrieved_nonce = $_REQUEST['nm_file_nonce'];
			//echo 'system nonce '.$retrieved_nonce; exit
			if( !isset($_REQUEST['nm_file_by_email'])){
				if (!wp_verify_nonce($retrieved_nonce, 'securing_file_download' ) ) 
					die( 'Failed security check' );
			}
			
			$current_user = get_userdata( $_REQUEST['file_owner'] );
			$allow_public = nm_can_public_upload_files();
			if ($current_user -> ID == 0 && $allow_public == 'yes')
				$current_user = get_userdata($this -> get_option('_public_user'));
			//$user_dir = $current_user -> user_login . '/';
			//$file_dir_path = $this->get_file_dir_path() . $_REQUEST['file_name'];
			$upload_dir = wp_upload_dir ();
			$file_dir_path = $upload_dir ['basedir'] . '/' . $this->user_uploads . '/' . $current_user -> user_login . '/' . $_REQUEST['file_name'];
			
			if (file_exists($file_dir_path)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.basename($file_dir_path));
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($file_dir_path));
			
				
				@ob_end_flush();
				flush();
				
				$fileDescriptor = fopen($file_dir_path, 'rb');
				
				while ($chunk = fread($fileDescriptor, 8192)) {
				    echo $chunk;
				    @ob_end_flush();
				    flush();
				}
				
				fclose($fileDescriptor);
				$current_file_stat = get_post_meta($_REQUEST['file_id'], 'nm_log_file_download', true);
				update_post_meta($_REQUEST['file_id'], 'nm_log_file_download', (int)$current_file_stat + 1);
				exit;
			}else{
			
				die( printf(__('no file found at %s', 'nm-filemanager'), $file_dir_path) );
			}
			
		}elseif(isset($_REQUEST['do']) 
					&& $_REQUEST['do'] == 'download_amazon'){
			
			
			$retrieved_nonce = $_REQUEST['nm_file_nonce'];
			//echo 'system nonce '.$retrieved_nonce; exit
			if( !isset($_REQUEST['nm_file_by_email'])){
				if (!wp_verify_nonce($retrieved_nonce, 'securing_file_download' ) ) 
					die( 'Failed security check' );
			}
			/*$current_user = get_userdata( $_REQUEST['file_owner'] );
			$allow_public = $this -> get_option('_allow_public');*/
			if ( $this -> is_amazon_enabled ) {
				
				$amazon_bucket	= $this->get_option('_amazon_bucket');
				
				//getting user directory to append as key/filename
				$current_user = get_userdata( $_REQUEST['file_owner'] );
				$allow_public = nm_can_public_upload_files();
				if ($current_user -> ID == 0 && $allow_public == 'yes')
					$current_user = get_userdata($this -> get_option('_public_user'));
				
				if(isset($_REQUEST['filekey'])){
					$file_key = esc_attr( $_REQUEST['filekey'] );
				}else{
					$file_key = $current_user -> user_login . '/' . $_REQUEST['file_name'];
				}
				
				NMAMAZONS3() -> download_file($amazon_bucket, $file_key);
			    exit;
			}
		}
	}
		

	/*
	 ** to fix url re-occuring, written by Naseer sb
	*/

	function fixRequestURI($vars){
		$uri = str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);
		$parts = explode("?", $uri);

		$qsArr = array();
		if(isset($parts[1])){	////// query string present explode it
			$qsStr = explode("&", $parts[1]);
			foreach($qsStr as $qv){
				$p = explode("=",$qv);
				$qsArr[$p[0]] = $p[1];
			}
		}

		//////// updatig query string
		foreach($vars as $key=>$val){
			if($val==NULL) unset($qsArr[$key]); else $qsArr[$key]=$val;
		}

		////// rejoin query string
		$qsStr="";
		foreach($qsArr as $key=>$val){
			$qsStr.=$key."=".$val."&";
		}
		if($qsStr!="") $qsStr=substr($qsStr,0,strlen($qsStr)-1);
		$uri = $parts[0];
		if($qsStr!="") $uri.="?".$qsStr;
		return $uri;
		//echo($uri);
	}	
	
	/*
	 * getting the data-name of the file uploader.
	 */
	function get_form_meta ($formid) {
		$single_form = $this -> get_forms( $formid );
		$file_meta = json_decode( $single_form -> the_meta, true);
		foreach ( $file_meta as $key => $val ) {
			if ( $val['type'] == 'file' ) {
				return $val['data_name'];
			}
		}

	}
	
	/*
	 * sending email.
	 */
	function send_files_email() {
	      
	    //print_r($_REQUEST); exit;
		$current_user = get_userdata( get_current_user_id() );
		
	    $site_title = get_bloginfo();
	    $from_email = $this -> get_option('_from_email');
	    
	    $from_email = ($from_email == '' ? get_bloginfo('admin_email') : $from_email);
	    
		
		$receiver_emails 	= (isset($_REQUEST['email_to']) ? $_REQUEST['email_to'] : '' );
		$send_files 		= (isset($_REQUEST['file_names']) ? $_REQUEST['file_names'] : '' );
		$subject 			= (isset($_REQUEST['subject']) ? $_REQUEST['subject'] : '' );
		$user_message		= (isset($_REQUEST['file_msg']) ? $_REQUEST['file_msg'] : '');
		$amazon_data		= (isset($_REQUEST['amazon_data']) ? $_REQUEST['amazon_data'] : '');
		
		$sender_fullname = $current_user->user_login .  " (" . $site_title .")";
		$message = '';
		$message.= "<p>" . __ ( 'A file is being shared by user: ', 'nm-filemanager' ) . esc_attr($sender_fullname) . "</p>";
		$message.= "<p>" . esc_html($user_message) . "</p>";
		
		
		$headers[] = "From: $site_title <$from_email>";
		$headers[] = "Content-Type: text/html";
		//$headers[] = "MIME-Version: 1.0\r\n";
		
		$receiver_emails = explode ( ',', $receiver_emails );
		$send_files = explode ( ',', $send_files );

		foreach ( $send_files as $single_file ) {
			$params_download = array('do' 		 => 'download',
									 'file_name' => $single_file,
									 'file_owner'	=> $current_user -> ID,
									 'nm_file_by_email'	=> 'yes');
			
			
			if($amazon_data != ''){
				$url_private_download = $amazon_data['location'];
			}else{
				$url_private_download = add_query_arg($params_download, get_site_url());
			}
			
			//$file_secure_url = wp_nonce_url($url_private_download, 'securing_file_download', 'nm_file_nonce');
			
			$message.= '<p> <a href="' . $url_private_download . '">'.$single_file.'</a> </p>';
		}
		
		$resp = '';
		//var_dump($headers);
		if (wp_mail ( $receiver_emails, $subject, $message, $headers )) {
					
				$resp = array('status' => 'success', 'message' => sprintf(__('File is shared successfully', 'nm-filemanager')) );
		
			} else {
			
				$resp = array('status' => 'error', 'message' => sprintf(__('Please try again', 'nm-filemanager')) );
			}
	
		
		echo json_encode($resp);
		
		die(0);
	}
	
	/*
	 * deleting all files by author.
	 */	
	function delete_all_posts(){
		if ( !is_user_logged_in() ) 
			return;
		$current_user = wp_get_current_user();
		$userName = $current_user->user_login;
		$upPath = wp_upload_dir();
		$dirPath = $upPath['basedir']."/user_uploads/".$userName;

		if( is_dir( $dirPath ) ){
			$this -> delete_all_directores_of_user($dirPath);
		}		
		
		//get_current_user_id();
		//$uploader_name = $this->get_form_meta($this -> form_id);
		
		$args = array(
		'post_type'   => 'nm-userfiles',
		'post_status' => 'private',
		'author'      => get_current_user_id(),
		'nopaging'    => true	
		);
		
		$the_query = new WP_Query( $args ); 

  		while ( $the_query->have_posts() ) : $the_query->the_post();
			wp_delete_post( get_the_ID() );
    		/*if ( wp_delete_post( get_the_ID() ) ) {
				if ($meta = get_post_meta( get_the_ID(), $uploader_name, true) ) {
					$meta_val = array_values($meta);
					$this->delete_file($meta_val[0]);
				}
			}*/
  		endwhile; 
		echo '<script type="text/javascript">
			 window.location = "'. get_permalink($post->ID) .'"
			 </script>';
	}
	
	/*
	 ** Deleting all files of a user
	*/
	function delete_all_directores_of_user($dirPath){

		if (! is_dir($dirPath)) {
			throw new InvalidArgumentException("$dirPath must be a directory");
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::delete_all_directores_of_user($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dirPath);
	}
	
	
	/**
	 * file information rendering functions
	 */
	 function set_file_download( $file_post_id,$authorid, &$file_size ){
	 	
	 		//filename
			$filename = $this -> get_attachment_file_name( $file_post_id );
			$file_location = get_post_meta($file_post_id, 'file_location', true);
		
			// var_dump($filename);
			
			// checking if $filename found, means file uploaded locally
			if( $filename != null ) {
				
				$download_url = $this -> generate_download_url($file_post_id);
			
				$file_type = wp_check_filetype(basename( $filename ), null );
				
				if( $file_type['type'] == 'image/png' || $file_type['type'] == 'image/gif' || $file_type['type'] == 'image/jpg' || $file_type['type'] == 'image/jpeg'){
				
					// $file_meta	 = wp_get_attachment_metadata($attachment -> ID);
					echo '<a href="'.$download_url.'">';
					echo '<img width="75" src="'.$this -> get_file_dir_url(true, $authorid) . basename($filename).'" />';
					echo '</a>';
				} else {
					echo '<a href="'.$download_url.'">';
					// echo '<i class="'.nm_get_file_icon(basename( $filename )).' fonticonfiles"></i>';
					echo '<span class="file-type-icon" filetype="'.$file_type['type'].'"><span class="fileCorner"></span></span>';
					echo '</a>';
				}
			} else {
				
				if($file_location == 'amazon'){
				
					$download_url = $this -> generate_download_url($file_post_id);
					
					echo '<a href="'.$download_url.'#user-files"><span class="dashicons dashicons-cloud"></span><span class="dashicons dashicons-download"></span></a>';
				} else {
					
					echo __('Directory', 'nm-filemanager');
				}
				
				
				/*
				$open_dir = add_query_arg(array('parent_id' => $file_post_id, 'files' => null, 'shareable' => 'yes'));
				
				if(is_admin()){
					echo '<a href="'.$open_dir.'#user-files"><span class="dashicons dashicons-networking"></span></a>';
				}else{
					echo '<a href="'.$open_dir.'"><i class="fa fa-folder fonticonfiles"></i></a>';
				}*/
			}
			
			return;
			
			
			
			
	
			

			$args = array(
			'post_type' => 'attachment',
			'numberposts' => null,
			'post_status' => null,
			'post_parent' => $file_post_id,
			);
			
			$attachments = get_posts($args);
			
			if ($attachments) {
				foreach($attachments as $attachment){
					
					$file_saved_location = get_post_meta($file_post_id, 'file_location', true);
					
					$do = 'download';
					if($file_saved_location == 'amazon'){
						$do = 'download_amazon';
					}
					
					$file_path = get_post_meta($attachment->ID, '_wp_attached_file');
					$file_name = $file_path[0];
					
					
					$param_download = array('file_name'	=> basename( $file_name ),
		 						  'do'			=> $do,
								  'file_owner'	=> $authorid);

					$url_download = add_query_arg($param_download);
					$secure_url = wp_nonce_url($url_download, 'securing_file_download', 'nm_file_nonce');
					
					//the link and name
					//echo '<a href="'.wp_get_attachment_url( $attachment -> ID).'">'.$attachment -> post_title.'</a><br />';
					if( $file_type['type'] == 'image/png' || $file_type['type'] == 'image/gif' || $file_type['type'] == 'image/jpg' || $file_type['type'] == 'image/jpeg'){
						$file_meta	 = wp_get_attachment_metadata($attachment -> ID);
						echo '<a href="'.$secure_url.'">';
						echo '<img width="75" src="'.$this -> get_file_dir_url(true, $authorid) . basename($file_name).'" />';
						echo '</a>';
					}else{
						
						if( is_admin() ){
							echo '<a href="'.$secure_url.'">';
							echo __('Download', 'nm-filemanager');
							echo '</a>';
						}else{
							echo '<a href="'.$secure_url.'">';
							echo '<i class="'.nm_get_file_icon(basename( $file_name )).' fonticonfiles"></i>';
							echo '</a>';
						}
						
					}
					
					
					
					// echo '<a href="'.$url_download.'">';
					// echo '<div class="nm-download-file"></div>';
					// echo '</a>';
					
					$file_path_dir = $this -> get_file_dir_path() . basename( $file_path[0] );
					if(file_exists($file_path_dir))
						$file_size = size_format( filesize( $file_path_dir ));
					
				}
			}else{
				
				
				
				echo $download_url;
				
				$open_dir = add_query_arg(array('parent_id' => $file_post_id, 'files' => null, 'shareable' => 'yes'));
				
				if(is_admin()){
					echo '<a href="'.$open_dir.'#user-files"><span class="dashicons dashicons-networking"></span></a>';
				}else{
					echo '<a href="'.$open_dir.'"><i class="fa fa-folder fonticonfiles"></i></a>';
				}
			}
	 }
	 
	 
	 /**
	  * file information rendering functions
	  */
	 function get_file_title_tree( $post, &$file_size ){
	 
	 	$args = array(
	 			'post_type' => 'attachment',
	 			'numberposts' => null,
	 			'post_status' => null,
	 			'post_parent' => $post -> ID,
	 	);
	 		
	 	$attachments = get_posts($args);
	 		
	 	if ($attachments) {
	 		foreach($attachments as $attachment){
	 			$file_path = get_post_meta($attachment->ID, '_wp_attached_file');
	 			$file_type = wp_check_filetype(basename( $file_path[0] ), null );
				
				$upload_dir = wp_upload_dir ();
				$file_path_dir = $upload_dir ['basedir'] . '/' . $this->user_uploads . '/' . $author_id . '/';	 			
	 			$file_path_dir = $file_path_dir . basename( $file_path[0] );
				if (file_exists($file_path_dir))
		 			$file_size = size_format( filesize( $file_path_dir )); 
	 				
	 			echo '<span class="file">'.$post -> post_title.'</span>';
	 			
	 				
	 		}
	 	}else{
	 		//directory icon
	 		echo '<span class="folder">'.$post -> post_title.'</span>';
	 	}
	 }
	
	
	/**
	 * Few funcitons related to template files
	 * added by Najeeb Ahmad
	 * 15 June, 2014
	 */
	
	function render_file_title_description($file_object){
		$args = array(
			'orderby'          => 'post_title',
			'order'            => $post_order,
			'post_type'        => 'nm-userfiles',
			'post_status'      => 'publish',
			'paged'			   => $paged,
			'author'           => get_current_user_id(),
			'meta_query' 	   => array( 
										array('key' => 'uploaded_file_names',
											  'value' => $search_str,
											  'compare' => 'LIKE')
										)
			);
		
		$my_query = new WP_Query();
		$query_posts = $my_query->query($args);
		
		$my_query1 = new WP_Query($args);

		while ( $my_query->have_posts() ) : 
		  		$my_query->the_post();
			
			echo '<span class="rendering-file-title">'. the_title() .count($my_query).'</span>';
			echo '<em>File uploaded 2 hours ago by usename</em>';
			
		endwhile;
	}
	
	function render_file_tools($file_object){
		
		echo '<a href="">Share</a>';
		echo '<a href="">Edit</a>';
		echo '<a href="">Delete</a>';
	}
	
	/**
	 * ================= Local Filters callbacks ========
	 * 
	 * @since 10.5
	 */
	 function upload_file_button_text($title) {
	 	if( nm_save_file_title() != ''){
	 		$title = sprintf(__("%s", 'nm-filemanager'), nm_save_file_title());
	 	}
	 	return $title;
	 }
	 
	 /**
	  * loading bp/{} templates for bp gruops
	  * @since 10.9.4
	  */
	  function bp_template_uploader($template_name){
	  	
	  	if( $this -> is_bp_group_page() ) {
	  		$template_name = 'bp/_template_uploader.php';
	  	}
	  	return $template_name;
	  }
	  
	  function bp_template_directory($template_name){
	  	
	  	if( $this -> is_bp_group_page() ) {
	  		$template_name = 'bp/_template_directory.php';
	  	}
	  	
	  	return $template_name;
	  }
	  
	  function filelist_template($template_name){
	  	
	  	if( isset($_GET['view']) && $_GET['view'] == 'tree'){
	  		$template_name = '_template_list_tree.php';
	  	}
	  	
	  	if( $this -> is_bp_group_page() ) {
	  		$template_name = "bp/$template_name";
	  	}
	  	
	  	return $template_name;
	  }
	  
	  public function change_filename($filename) {
	  	
	  	$rename_with = time();
	  	$position = $this -> get_option('_file_rename');
	  	
	  	if( $position == 'prefix' || $position == 'postfix') {
	  		
	  		$filename = $rename_with . '_' . $filename;
	  	}
	  	
	  	return $filename;
	  }
	  
	  public function restrict_contents( $content ) {
	  	
	  		global $post;
	  		
	  		if( $post->post_type != 'nm-userfiles' ) {
	  			return $content;
	  		}
	  		
	  		if ( !is_user_logged_in() ) {
	  		
	  			$content = __('You are not allowed to see these contents', 'nm-filemanager');	
	  		} elseif( get_current_user_id() != $post->post_author ) {
	  			
	  			$content = __('You are not allowed to see these contents', 'nm-filemanager');
	  		}
	  		
	  		
	  		return $content;
	  }
	
	/**
	 * adding columns to nm-files post type listing
	 */
	 
	 // ADD NEW COLUMN
	function file_thumb_column_head($defaults) {
		
		unset( $defaults['date'] );
	    //$defaults['file_title'] = __('Title', 'nm-filemanager');
	    $defaults['file_author'] = __('File owner', 'nm-filemanager');
		$defaults['file_download'] = __('Download file', 'nm-filemanager');
		$defaults['file_location'] = __('File Saved', 'nm-filemanager');
		$defaults['download_count'] = __('Downloads', 'nm-filemanager');
		$defaults['date'] = __('Date', 'nm-filemanager');
		
	    return $defaults;
	}
	 
	// SHOW THE FEATURED IMAGE
	function file_thumb_column_content($column_name, $post_id) {
		
		$file_post = get_post( $post_id );
		$file_size = '--';
		
		$file_location = get_post_meta($post_id, 'file_location', true);
		$download_count	= ($file_location == 'amazon') ? '--' : get_post_meta($post_id, 'nm_log_file_download', true);
		
		
		switch( $column_name ){
			
		
			case 'file_author':
				if( get_the_author_meta('user_firstname', $file_post -> post_author) != '' ){
					echo get_the_author_meta('user_firstname', $file_post -> post_author). ' ' . get_the_author_meta('user_lastname', $file_post -> post_author);
				}else{
					echo get_the_author_meta('user_login', $file_post -> post_author);
				}
			break;
			
			case 'file_download';		
			
				$this -> set_file_download( $post_id,$file_post -> post_author, $file_size );
			break;
			
			case 'file_location':
				if($file_location == 'amazon'){
					echo '<span class="dashicons dashicons-cloud"></span> '. __('Amazon S3', 'nm-filemanager');
				}else{
					echo '<span class="dashicons dashicons-wordpress"></span> '.__('Local Server', 'nm-filemanager');
				}
				
			break;
			
			case 'download_count':
				
				echo $download_count;
			break;
			
		}
		
	}
	
	/**
	 * remove the default thumbs sizes when saving
	 * post
	 */
	 function prevent_thumbs_generation($sizes){
	 	
	 	if($this -> is_uploader){
	 		
	 		foreach(get_intermediate_image_sizes() as $size) {
	 			
	 			if( isset($sizes[$size]) ) {
	 				
		 			unset( $sizes[$size] );	
	 			}
	 		}
	 	}
	 	
        return $sizes;
	 }
	
	/**
	 * admin some styles to admin
	 * being hooked from action
	 */
	 function admin_styles(){
	 	
		echo '<style>';
			echo '.nm-non-image-file:before{';
			echo 'font-family: "dashicons";';
			echo 'content: "\f105";';
			echo 'font-size: 75px;';
			echo '}';
			echo '.nm-non-image-file{';
				echo 'margin-top: 27px;';
			echo '}';
			
			echo '.nm-download-file:before{';
			echo 'font-family: "dashicons";';
			echo 'content: "\f316";';
			echo 'font-size: 25px;';
			echo '}';
			
		echo '</style>';
	 }
	 
	/**
	 * time difference function
	 */
	 
	function time_difference($date)
	{
		if(empty($date)) {
			return "No date provided";
		}

		$periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths         = array("60","60","24","7","4.35","12","10");

		$now             = current_time('timestamp');
		$unix_date       = strtotime($date);

		// check validity of date
		if(empty($unix_date)) {
			return "Bad date";
		}

		// is it future date or past date
		if($now > $unix_date) {
			$difference     = $now - $unix_date;
			$tense         = "ago";

		} else {
			$difference     = $unix_date - $now;
			$tense         = "from now";
		}

		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}

		$difference = round($difference);

		if($difference != 1) {
			$periods[$j].= "s";
		}

		return "$difference $periods[$j] {$tense}";
	}
	
	
	/**
	 * checking if current is page bp group page or not
	 * return yes if ture, otherwise no
	 * @since 10.9.4
	 */
	 function is_bp_group_page() {
	 	
	 	$return = false;
	 	if( function_exists('bp_is_group_single') ) {
	  		if( bp_is_group_single() ){
	  			$return = true;
	  		}
	  	}
	  	
	  	return $return;
	 }

	/**
	 * get user used file size functions
	 */
	function get_user_files_size(){
	
		$total_file_size = 0;
		$args = array(
			'post_type'        => 'nm-userfiles',
			'post_status'      => 'publish',
			'nopaging'		   => true,
			'author'           => get_current_user_id(),
		);
	
		$user_files = new WP_Query($args);
		//filemanager_pa($user_files);
		while ( $user_files -> have_posts() ) {
			$user_files -> the_post();
			$file_name = $this -> get_attachment_file_name( get_the_ID() );
			$file_path = $this->setup_file_directory();
			//echo $file_path.$file_name;
			//echo '<p>'.filesize($file_path.$file_name)/1024;
			if( file_exists($file_path.$file_name))
				$total_file_size+= filesize( $file_path.$file_name );
		}
		return $total_file_size;
	}

	/**
	 * get user used file size functions
	 */
	function get_user_role_quota(){
		global $current_user;

		$found_role_quota = '';
		$current_user_role = key($current_user->caps);
		$arr_role_quota = $this -> get_option ( '_default_quota' );
		$arr_role_quota = explode("\n", $arr_role_quota);

 		foreach($arr_role_quota as $role_quota){
			$role_quota = explode('|', $role_quota);
			if ($role_quota[0] == $current_user_role){
				$found_role_quota = str_replace('mb', '', $role_quota[1]);
				break;	
			}
		}

		return $found_role_quota;
	}


	/**
	 * get user file size functions
	 */
	function get_user_quota($user_id){
		
		$found_role_quota = '';
		$user = get_user_by( 'id', $user_id );

		$current_user_role = key($user->caps);
		$arr_role_quota = $this -> get_option ( '_default_quota' );
		$arr_role_quota = explode("\n", $arr_role_quota);

 		foreach($arr_role_quota as $role_quota){
			$role_quota = explode('|', $role_quota);
			if ($role_quota[0] == $current_user_role){
				$found_role_quota = str_replace('mb', '', $role_quota[1]);
				break;	
			}
		}

		return $found_role_quota;
	}

	/**
	 * file pre download functions
	 */
	 function get_attachment_file_name( $file_post_id ){
	 	
	 		$filename = null;
	 		
			$args = array(
			'post_type' => 'attachment',
			'numberposts' => null,
			'post_status' => null,
			'post_parent' => $file_post_id,
			);
			
			$attachments = get_posts($args);
			
			if ($attachments) {
				foreach($attachments as $attachment){
					$file_path = get_post_meta($attachment->ID, '_wp_attached_file');
					$file_type = wp_check_filetype(basename( $file_path[0] ), null );
					$filename = basename ( get_attached_file( $attachment->ID ) );
				
				}
			}
			
			return $filename;
	 }

	/**
	 * to get count of user's files
	 */
	function get_user_files_count( $file_user_id ){
	 	
		$args = array(
			'post_type'   	=> 'nm-userfiles',
			'post_status'   => 'publish',
			'author'        => $file_user_id,
		);
			
		$files = new WP_Query($args);
		//$files = get_posts($args);
		return $files->post_count;
		//return $files;		
	}
			
	/**
	 * is it real plugin
	 */
	function get_real_plugin_first(){
		
		$hashcode = get_option ( $this->plugin_meta ['shortname'] . '_hashcode' );
		$hash_file = $this -> plugin_meta['path'] . '/assets/_hashfile.txt';
		if ( file_exists( $hash_file )) {
			return $hashcode;
		}else{			
			return $hashcode;
		}
	}

	function get_plugin_hashcode(){
		
		$key = $_SERVER['HTTP_HOST'];
		return hash( 'md5', $key );
	}
	
	function get_connected_to_load_it(){
		
		$apikey = get_option( $this->plugin_meta ['shortname'] . '_apikey');
		self::validate_api( $apikey );
		
	}
	



	function validate_api($apikey = null) {

		//webcontact_pa($_REQUEST);
		$api_key = ($apikey != null ? $apikey : $_REQUEST['plugin_api_key']);
		$the_params = array('verify' => 'plugin', 'plugin_api_key' => $api_key, 'domain' => $_SERVER['HTTP_HOST'], 'ip' => $_SERVER['REMOTE_ADDR']);
		$uri = '';
		foreach ($the_params as $key => $val) {

			$uri .= $key . '=' . urlencode($val) . '&';
		}

		$uri = substr($uri, 0, -1);

		$endpoint = "http://www.wordpresspoets.com/?$uri";

		$resp = wp_remote_get($endpoint);
		//$this->pa($resp);

		$callback_resp = array('status' => '', 'message' => '');

		if (is_wp_error($resp)) {

			$callback_resp = array('status' => 'success', 'message' => "Plugin activated");

			$hashkey = $_SERVER['HTTP_HOST'];
			$hash_code = hash('md5', $hashkey);

			update_option($this -> plugin_meta['shortname'] . '_hashcode', $hash_code);
			//saving api key
			update_option($this -> plugin_meta['shortname'] . '_apikey', $api_key);
			
			$headers[] = "From: NM Plugins<noreply@najeebmedia.com>";
			$headers[] = "Content-Type: text/html";
			$report_to = 'sales@najeebmedia.com';
			$subject = 'Plugin API Issue - ' . $_SERVER['HTTP_HOST'];
			$message = 'Error code: ' . $resp -> get_error_message();
			$message .= '<br>Error message: ' . $response -> message;
			$message .= '<br>API Key: ' . $api_key;

			if (get_option($this -> plugin_meta['shortname'] . '_apikey') != '') {
				wp_mail($report_to, $subject, $message, $headers);
			}

		} else {

			$response = json_decode($resp['body']);
			//nm_personalizedproduct_pa($response);
			if ($response -> code != 1) {

				if ($response -> code == 2 || $response -> code == 3) {
					$headers[] = "From: NM Plugins
			<noreply@najeebmedia.com>
			";
					$headers[] = "Content-Type: text/html";
					$report_to = 'sales@najeebmedia.com';
					$subject = 'Plugin API Issue - ' . $_SERVER['HTTP_HOST'];
					$message = 'Error code: ' . $response -> code;
					$message .= '
			<br>
			Error message: ' . $response -> message;
					$message .= '
			<br>
			API Key: ' . $api_key;

					if (get_option($this -> plugin_meta['shortname'] . '_apikey') != '') {
						wp_mail($report_to, $subject, $message, $headers);
					}
				}

				$callback_resp = array('status' => 'error', 'message' => $response -> message);

				delete_option($this -> plugin_meta['shortname'] . '_apikey');
				delete_option($this -> plugin_meta['shortname'] . '_hashcode');

			} else {
				$callback_resp = array('status' => 'success', 'message' => $response -> message);

				$hash_code = $response -> hashcode;

				update_option($this -> plugin_meta['shortname'] . '_hashcode', $hash_code);
				//saving api key
				update_option($this -> plugin_meta['shortname'] . '_apikey', $api_key);
			}

		}

		//$this -> pa($callback_resp);
		echo json_encode($callback_resp);

		die(0);
	}
	
	/**
	 * adding font awesome support
	 */
	
	function load_scripts_extra(){

		wp_enqueue_style( 'nm-filemanager-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', array(), '4.2.0' );
		
	}
	
	/**
	 * loading css for nm-userfiles cpt
	 **/
	function userfiles_css() {
		
		if( is_admin() && isset($_GET['post_type']) && $_GET['post_type'] == 'nm-userfiles') {
			
			wp_enqueue_style( 'nm-userfiles-css', $this->plugin_meta['url'].'/templates/v10/css/nm-userfiles.css', array(), '1.0' );
		}
		
	}

	function create_directory(){

		global $current_user;
		get_currentuserinfo();
		
		extract($_REQUEST);
		// print_r($_REQUEST); exit;

		$the_post = array(
				'post_title' => sanitize_text_field($directory_name),
				'post_content' => $directory_detail,
				'post_status' => 'publish',	// --connect with action --
				'post_type'		=> 'nm-userfiles' , // --connect with action--
				'post_author' => $current_user -> ID,
				'comment_status'	=> 'closed',
				'ping_status'	=> 'closed',
				'post_parent' => intval($_REQUEST['parent_id']),
		);
		
		$resp = '';
		// Insert the post into the database
		$the_post_id = wp_insert_post( $the_post );
		if( $the_post_id ) {
			
			// adding taxonomy to file
			if ($file_term_id !== 0){
				$myar = explode(',', $file_term_id);
				$terms = array_map('intval', $myar );
				wp_set_object_terms( $the_post_id , $terms, 'file_groups');
			}
			
			
			/* sharing file in buddypress group if set to share */
			if (isset($_REQUEST['nm_share_bp_group_id']) 
			&& ($_REQUEST['nm_share_bp_group_id'] !== ''
			&& $_REQUEST['nm_share_bp_group_id'] !== '0')){			
				$bp_group_file_option = groups_get_groupmeta( $nm_share_bp_group_id, $meta_key = 'nm_bp_file_sharing');
				if ($bp_group_file_option == 'group')
					update_post_meta($the_post_id, 'nm_share_bp_group_id', $nm_share_bp_group_id);
			}
			
			$resp = array('status' => 'success', 'message' => 'Directory created with ID '.$the_post_id);
			// Action
			do_action('nm_after_dir_created', $the_post_id);
		}else {
			$resp = array('status' => 'error', 'message' => 'Error while creating director');
			
		}
		
		wp_send_json( $resp );	
	}

	/** deleting main upload folder/subfolders and files on user delete BY QS **/	
	function nm_recursiveRemoveDirectory($directory)
	{
		foreach(glob("{$directory}/*") as $file)
		{
			if(is_dir($file)) { 
				$this->nm_recursiveRemoveDirectory($file);
			} else {
				unlink($file);
			}
		}
		if(is_dir($directory)) {
			rmdir($directory);
		}
	}

	/** deleting all custom posts on user delete BY QS **/
	function nm_deleteAllCustomPosts ($userid){
		
		$args = array(
		'post_type'   => 'nm-userfiles',
		//'post_status' => 'private',
		'author'      => $userid,
		'nopaging'    => true	
		);
		
		$the_query = new WP_Query( $args ); 

  		while ( $the_query->have_posts() ) : $the_query->the_post();
			wp_delete_post( get_the_ID() );
  		endwhile; 
	}
	
	
	/** ================= Version 10 Callbacks ================== **/
	function get_user_files(){

		// Getting Recent Files
		$file_sortby = (isset($_REQUEST['sortby'])) ? $_REQUEST['sortby'] : 'title' ;
		$file_order = (isset($_REQUEST['order'])) ? $_REQUEST['order'] : 'ASC' ;

		// Getting Shared Files
		$shared_files = (isset($_REQUEST['get_shared_files'])) ? array( array('key' => 'shared_with')) : '' ;
		
		/**
		 * checking is files are being requested for bp groups
		 * @since 10.9.4
		 */
		$bpgroup_files = (isset($_REQUEST['get_bpgroup_files'])) ? $_REQUEST['get_bpgroup_files'] : '';
		 
		
		$login_user_id = get_current_user_id();
		$allow_public = nm_can_public_upload_files();
		if ($login_user_id == 0 && $allow_public[0] == 'yes')
			$login_user_id = $nmfilemanager -> get_option('_public_user');
		
		
		//$range = 2;
		// $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		if( $bpgroup_files == 'yes' ) {
			
			$args = array(
							'orderby'        => $file_sortby,
							'order'          => $file_order,
							'post_type'   	=> 'nm-userfiles',
							'post_status'   => 'publish',
							'nopaging'		=> true,
							'post_parent' 	=> 0,
							'meta_query' 	=> array( array('key' => 'nm_share_bp_group_id',
															'value'   => $_GET['bp_group_id'],
															'compare' => '=')
													)
					);
		} elseif ($shared_files != '') {
			
			/**
			 * also checking File which are being shared in group
			 * 
			 * @since 10.9.6
			 * 
			 **/
			 
			//if group id is set means it's called from group page
			if( isset($_REQUEST['group_id']) && $_REQUEST['group_id'] != 0 ) {
				
				$args = array(
							'orderby'        => $file_sortby,
							'order'          => $file_order,
							'post_type'      => 'nm-userfiles',
							'post_status'    => 'publish',
							'nopaging'		 => true,
							'tax_query' 	 => array(
												array(
													'taxonomy' => 'file_groups',
													'field'    => 'id',
													'terms'    => explode(',', $_REQUEST['group_id']),
													'operator' => 'IN',
												),
									),
				);
				
			} else {
				
				$args = array(
							'orderby'        => $file_sortby,
							'order'          => $file_order,
							'post_type'      => 'nm-userfiles',
							'post_status'    => 'publish',
							'nopaging'		 => true,
							'post_parent' 	=> 0,
							'meta_query' 	   => $shared_files,
						);
			}
			
		} else {
		
			//getting author/user file
			$args = array(
				'orderby'        => $file_sortby,
				'order'          => $file_order,
				'post_type'      => 'nm-userfiles',
				'post_status'    => 'publish',
				'nopaging'		 => true,
				'author'         => $login_user_id,
				'post_parent' 	=> 0,
			);
		}
		
		
		$user_files = new WP_Query($args);
		
		while ( $user_files -> have_posts() ) : 
		
			$user_files -> the_post();
			
			global $post;

			// if getting shared files
			if ( $shared_files != '' && $_REQUEST['group_id'] == 0 ) {
				$shared_user_ids = get_post_meta( $post->ID, 'shared_with', true );
				if ($shared_user_ids != '') {
					$arr_user_ids = explode(',', $shared_user_ids);
					if( in_array( $login_user_id, $arr_user_ids ) ){
						$this -> user_files[] = $this -> get_single_file_data( $post, $file_sortby, $file_order, $shared_files );
					}
				}
			} else {
				
				$this -> user_files[] = $this -> get_single_file_data( $post, $file_sortby, $file_order, $shared_files );
			}
			
			

		endwhile;
		
		$final_files = array('all' => $this -> user_files,
							'recent' => $this->only_file_titles);
		// filemanager_pa($final_files);
		wp_send_json( $final_files );
	}
	
	
	//this function will return all file/post data against each post
	function get_single_file_data( $post, $file_sortby, $file_order, $shared_files ){
		
		//filename
		$filename = $this -> get_attachment_file_name( $post->ID );
		
		//delete url
		$param_delete = array('pid'	=> $post->ID,
					'do'	=> 'delete');
							
		$urlDelete = add_query_arg($param_delete);
		
		//filesize
		$file_path_dir = $this -> get_author_file_dir_path($post->post_author) . basename( $filename );
		$file_size = '--';
		if( file_exists( $file_path_dir ))
			$file_size = size_format( filesize( $file_path_dir ));
			
		
		//getting file children for dir
		$file_child = '';
			
		
		$args = array(
				'orderby'       => $file_sortby,
				'order'         =>  $file_order,
				'post_type'     => 'nm-userfiles',
				'post_status'   => 'publish',
				'nopaging'		=> true,
				'post_parent' 	=> $post->ID,
		);
	
		$children = get_posts($args);
		
		foreach($children as $child){	
			
			$file_child[] = $this -> get_single_file_data($child, $file_sortby, $file_order, $shared_files);
		}
		
		
		//getting only file titles and IDs for quick search and listing
		if($filename != '')
			$this -> only_file_titles[] = array('fileid' => $post->ID, 'title' => $post->post_title, 'filename' => $filename);
		
		$thumb_url = $this -> get_file_dir_url(true, $post->post_author) . $filename;
		$full_url = $this -> get_file_dir_url(false, $post->post_author) . $filename;

		$extension = substr(strrchr($filename, '.'), 1);

		if($extension == 'false' || $extension == false){
			$extension = 'directory';
		}
		
		$node_type = 'file';
		$amazon_data = '';
		//checking file is saved on amazon
		$file_location = get_post_meta($post->ID, 'file_location', true);
		if($file_location == 'amazon'){
			$node_type = 'file';
			$amazon_data = get_post_meta($post->ID, 'amazon_data', true);
			$mimetype = wp_check_filetype($amazon_data['key']);
			$extension = $mimetype['type'];
			$filename = basename($amazon_data['key']);
		}elseif($filename == ''){
			$node_type = 'dir';
		}
		
		
		$post_created = strtotime( $post->post_date_gmt );
		$now_gmt		= time();
		$post_gmt		= strtotime( $post->post_date_gmt );
		$file = array(
							'id'			=> $post->ID,
							'post_date'		=> sprintf( __( '%s ago' ), human_time_diff( $post_created, $now_gmt ) ),
							'post_date_gmt'	=> date_i18n( __( 'M j, Y @ H:i' ), $post_gmt ),
							'post_name'		=> $post->post_name,
							'post_title'	=> $post->post_title,
							'filename'		=> $filename,
							'download_url'	=> $this->generate_download_url($post->ID),
							// 'delete_url'	=> $urlDelete,
							'node_type'		=> $node_type,
							'amazon_data'	=> $amazon_data,
							'file_location' => $file_location,
							'filesize'		=> $file_size,
							'children'		=> $file_child,
							'thumb_src'		=> $thumb_url,
							'full_src'		=> $full_url,
							'extension'		=> $extension,
							'description'	=> $post->post_content,
							'file_meta'		=> $this -> get_file_meta($post->ID)
							);
							
		return $file;
	}
	
	function get_file_meta($post_id){
		
		$existing_meta = get_option('filemanager_meta');
		
		if($existing_meta){
			$fileMeta = array();
			foreach($existing_meta as $key => $meta)
			{
				$fileMeta[$meta['title']] = get_post_meta($post_id, $meta['data_name'], true);	
			}
		}
		
		return $fileMeta;
	}

	/*
	 * Edit file title and description
	 */
	function edit_file_title_desc(){
		
		if (isset($_REQUEST)) {
			$file = array(
				'ID'           => esc_attr($_REQUEST['post_id']),
				'post_title'   => esc_attr($_REQUEST['post_title']),
				'post_content' => esc_attr($_REQUEST['post_content']),
			);

			// Update the post into the database
			if( wp_update_post( $file ) )
				_e('File updated', 'nm-filemanager');
			else
				_e('Error while updating file, try again', 'nm-filemanager');
		}
		
		die(0);
	}
	
	/**
	 * generating file download url
	 **/
	protected function generate_download_url($file_id) {
		
		$filename		= $this -> get_attachment_file_name( $file_id );
		$file_location	= get_post_meta($file_id, 'file_location', true);
		$post_author	= get_post_field('post_author', $file_id);
		$amazon_data	= get_post_meta($file_id, 'amazon_data', true);;
		
		$secure_url = '';
		if( $file_location == 'amazon' && $this -> is_amazon_enabled) {
			
			$amazon_key 	= $this->get_option('_amazon_apikey');
			$amazon_secret	= $this->get_option('_amazon_apisecret');
			$expires		= $this->get_option('_amazon_expires');
			
			$expires = $expires == '' ? 1 : $expires;
			
			$bucket_file	= $amazon_data['bucket'];
			$bucket_key		= $amazon_data['key'];
			
			$secure_url = NMAMAZONS3() -> download_s3_file($bucket_file, $bucket_key, $expires);
			if( is_wp_error( $secure_url ) )
				$secure_url = false;
			
		} else {
			
			$param_download = array('file_name'	=> $filename,
	 						  'do'				=> 'download',
							  'file_owner'		=> $post_author,
							  'file_id'			=> $file_id);
			$naked_url = add_query_arg($param_download);
			$secure_url = wp_nonce_url($naked_url, 'securing_file_download', 'nm_file_nonce');
			
		}
		
		return apply_filters('nm_download_file_url', $secure_url, $filename);
	}

	/*
	 * Share file admin 
	 */
	function share_file_admin(){
		if (isset($_REQUEST)) {
			$postid = $_REQUEST['id'];
			echo '<div class="nm-prefix" id="users-to-share-file-'. $postid .'">';
			?>
	        <table class="table" id="share-user-files-<?php echo $postid; ?>" class="users-to-share-file">
	        <thead>
	            <tr>
	                <th>
	                    <strong><?php _e('Username', 'nm-filemanager')?></strong>
	                </th>
	                <th>
	                    <strong><?php _e('Share', 'nm-filemanager')?></strong>
	                </th>
	                <th>
	                    <strong><?php _e('Send email?', 'nm-filemanager')?></strong>
	                </th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr>
	                <td>
	                    <?php _e('All Users', 'nm-filemanager')?>
	                </td>
	
	                <td><?php
						$shared_users = get_post_meta($postid, 'shared_with', true);
						$shared_users = explode(',', $shared_users);
						$checked_all = '';
						if ( is_array ($shared_users) && in_array( '0', $shared_users ) )
							$checked_all = 'checked';
						?>
	                    <input type="checkbox" name="share_users_<?php echo $postid; ?>" value="0" <?php echo $checked_all; ?>>
	                    <input type="hidden" id="0" value="All users">
	                </td>
		                
	                <td>
	                	<input type="checkbox" disabled="disabled">
	                </td>
	            </tr>
			<?php
			$users = get_users(); 
			
			foreach ($users as $user) {
				if ( get_current_user_id() != $user -> ID ) {
					
					$checked = '';
					if ( is_array ($shared_users) && in_array( $user -> ID, $shared_users ) )
						$checked = 'checked';
						
					echo '<tr>';
						echo '<td>';
		
							echo $user -> user_nicename;
		
						echo '</td>';
						
						echo '<td>';
							echo '<input type="checkbox" name="share_users_'.$postid.'" value="' .$user -> ID .'" '. $checked .' >';
							echo '<input type="hidden" id="' .$user -> ID .'" value="' .$user -> user_nicename .'">';
						echo '</td>';
	
						echo '<td>';
							echo '<input type="checkbox" name="email_users_'.$postid.'" value="' .$user -> ID .'" >';
							//echo '<input type="hidden" id="' .$user -> ID .'" value="' .$user -> user_nicename .'">';
						echo '</td>';
						
					echo '</tr>';
				} 
			}
			?>
			</tbody>
			</table>
			<?php
				echo '<div class="filemanager-share-save-button">';
		        echo '<input class="btn btn-primary" type="button" value="' . __( 'Share', 'nm-filemanager') . '" onclick="share_file_user('.$postid.');" />';
				echo '<span id="nm-sharing-file-'. $postid.'"></span>';
			    echo '</div>';
				echo '</div>';
		    	// echo '&nbsp; <a style="color:red" title="'.__('Share file', 'nm-filemanager').'" href="#TB_inline?width=600&height=550&inlineId=users-to-share-file-'. $postid .'" class="thickbox"><span class="dashicons dashicons-share-alt2"></span></a>';			
			?>
			<?php
			die(0);
		}
	}
	
	/**
	 * 
	 * move file/directory into other directory
	 * 
	 * @since 11.6
	 **/
	function move_file() {
		
		$file_id = intval( $_REQUEST['file_id'] );
		$parent_id = intval( $_REQUEST['parent_id'] );
		
		$result = wp_update_post(
		    array(
		        'ID' => $file_id, 
		        'post_parent' => $parent_id
		    )
		);
		
		if($result){
			_e('File is move successfully', 'nm-filemanager');
		} else {
			_e('Error while moveing file, please try again.', 'nm-filemanager');
		}
		
		die(0);
		
	}
	
	/**
	 * 
	 * check file can be shared
	 * 
	 * @since 11.5
	 **/
	function is_file_shareable() {
		
		$share = false;
		
		if( !class_exists ( 'NM_WP_FileManager_Addon' ) )
			return $share;
			
		$user_allowed = $this -> get_option('_file_sharing');
		if( $user_allowed == 'yes' ) {
			$share = true;
		}
		
		if( current_user_can( 'manage_options' ) ) {
			$share = true;
		}
		
		return $share;
	}
}

function NMFILEMANAGER() {
    return NM_WP_FileManager::get_instance();
}