<?php
/*
 * working behind the seen
 */
class NM_WP_FileManager_Admin extends NM_WP_FileManager {
	var $menu_pages, $plugin_scripts_admin, $plugin_settings;
	function __construct() {
		
		// setting plugin meta saved in config.php
		$this->plugin_meta = get_plugin_meta_filemanager ();
		
		//getting saved settings
		$this -> plugin_settings = get_option($this->plugin_meta['shortname'].'_settings');
		
	
		if($this -> get_plugin_hashcode() == $this -> get_real_plugin_first()){
			
			$this->menu_pages = array (
				array (
							'page_title' => $this->plugin_meta ['name'],
							'menu_title' => $this->plugin_meta ['name'],
							'cap' => 'manage_options',
							'slug' => $this->plugin_meta ['shortname'],
							'callback' => 'nm_settings',
							'parent_slug' => ''
					),
					
				array (
							'page_title' => __('User Files', 'nm-filemanager'),
							'menu_title' => __('User Files', 'nm-filemanager'),
							'cap' => 'manage_options',
							'slug' => 'user-files',
							'callback' => 'nm_userfiles',
							'parent_slug' => $this->plugin_meta ['shortname'],
					),
		);
		
		}else{
			
			$this->menu_pages = array (
					array (
							'page_title' => $this->plugin_meta ['name'],
							'menu_title' => $this->plugin_meta ['name'] . ' - validate plugin',
							'cap' => 'manage_options',
							'slug' => $this->plugin_meta ['shortname'],
							'callback' => 'activate_plugin',
							'parent_slug' => ''
					),
					);
			
		}

		
		/*
		 * [2] TODO: Change this for admin related scripts JS scripts and styles to loaded ADMIN
		 */
		$this->plugin_scripts_admin = array (

				array(	'script_name'	=> 'scripts-chosen',
						'script_source'	=> '/js/chosen/chosen.jquery.min.js',
						'localized'		=> false,
						'type'			=> 'js',
						'page_slug'		=> array(
											$this->plugin_meta ['shortname'],
											'user-files',
											),
						'depends' => array ('jquery')
				),
				
				array (
						'script_name' => 'chosen-style',
						'script_source' => '/js/chosen/chosen.min.css',
						'localized' => false,
						'type' => 'style',
						'page_slug' => array(
											$this->plugin_meta ['shortname'],
											'user-files',
											),
				),
				
				array (
						'script_name' => 'scripts-admin',
						'script_source' => '/js/admin.js',
						'localized' => true,
						'type' => 'js',
						'page_slug' => array(
											$this->plugin_meta ['shortname'],
											'user-files',
											),
						'depends' => array (
								'jquery',
								'jquery-ui-accordion',
								'jquery-ui-draggable',
								'jquery-ui-droppable',
								'jquery-ui-sortable',
								'jquery-ui-slider',
								'jquery-ui-dialog',
								'jquery-ui-tabs',
								'media-upload',
								'wp-color-picker',
								'thickbox'
						) 
				),
				array (
						'script_name' => 'ui-style',
						'script_source' => '/js/ui/css/smoothness/jquery-ui-1.10.3.custom.min.css',
						'localized' => false,
						'type' => 'style',
						'page_slug' => $this->plugin_meta ['shortname'],
						'depends' => '',
				),
				
				
				array (
						'script_name' => 'plugin-css',
						'script_source' => '/templates/admin/style.css',
						'localized' => false,
						'type' => 'style',
						'page_slug' => $this->plugin_meta ['shortname'],
						'depends' => '',
				),
				
				array (
						'script_name' => 'wp-color-picker',
						'script_source' => 'shipped',
						'localized' => false,
						'type' => 'style',
						'page_slug' => array (
								$this->plugin_meta ['shortname'],
						)
				),
		);
		
		$this -> ajax_callbacks = array('save_settings'	=> true);		//do not change this action, is for admin
		
		add_action ( 'admin_menu', array ($this, 'add_menu_pages') );
		
		add_action ( 'admin_init', array ($this, 'init_admin') );
		
		/**
		 * laoding admin scripts only for plugin pages
		 * since 27 september, 2014
		 * Najeeb's
		 */
		add_action( 'admin_enqueue_scripts', array (
		$this,
		'load_scripts_admin'
				));
		
		
		$this -> do_callbacks();
		
		//Auto update notification
		add_action('in_plugin_update_message-nm-file-upload-manager-pro/index.php', array($this, 'update_message'), 2, 10);
		
	}
	
	public function update_message(){
		
		echo '<div style="color:red;font:bold">';
		echo 'Download your plugin new version from <a target="_blank" href="https://www.wordpresspoets.com/member-area/">Member Area</a>';
		echo ' Or <a target="_blank" href="https://codecanyon.net/">CodeCanyon</a> and replace with existing';
		echo '</div>';
	}
	
	function load_scripts_admin($hook) {
	
		/**
		 * Note: we mostly hook independant page for our plugins
		 * so it's page hook will be: toplevel_page_PAGE_SLUG
		 */
			
		//var_dump($hook);
			
		// loading script for only plugin optios pages
		// page_slug is key in $plugin_scripts_admin which determine the page
	
	
	
		foreach ( $this->plugin_scripts_admin as $script ) {
	
			$attach_script = false;
			if (is_array ( $script ['page_slug'] )) {
					
	
				foreach( $script ['page_slug'] as $page){
					/**
					 * its very important var, when menu page is loaded as submenu of current plugin
					 * then it has different hook_suffix
					 */
					$plugin_sublevel = "filemanager_page_".$page;
					$plugin_toplevel = "toplevel_page_".$page;
	
					if ( $hook == $plugin_toplevel || $hook == $plugin_sublevel){
						$attach_script = true;
					}
				}
			} else {
				/**
				 * its very important var, when menu page is loaded as submenu of current plugin
				 * then it has different hook_suffix
				 */
				$plugin_sublevel = "THE_PLUGIN_HOOK".$script ['page_slug'];
				$plugin_toplevel = "toplevel_page_".$script ['page_slug'];
				if ( $hook == $plugin_toplevel || $hook == $plugin_sublevel){
	
					$attach_script = true;
				}
			}
	
			//echo 'script page '.$script_pages;
			if( $attach_script ){
	
				// adding media upload scripts (WP 3.5+)
				wp_enqueue_media();
	
				// localized vars in js
				$arrLocalizedVars = array (
						'plugin_url' => $this->plugin_meta ['url'],
						'doing' => $this->plugin_meta ['url'] . '/images/loading.gif',
						'plugin_admin_page' => admin_url ( 'options-general.php?page='.$this->plugin_meta ['shortname'] ),
						'delete_file_message'	=> __('Are you sure?', 'nm-filemanager'),
				);
	
				// checking if it is style
				if ($script ['type'] == 'js') {
					$depends = (isset($script['depends']) ? $script['depends'] : NULL);
					$in_footer = (isset($script['in_footer']) ? $script['in_footer'] : false);
					wp_enqueue_script ( $this->plugin_meta ['shortname'] . '-' . $script ['script_name'], $this->plugin_meta ['url'] . $script ['script_source'], $depends, $this->plugin_meta['plugin_version'], $in_footer );
	
					// if localized
					if ($script ['localized'])
						wp_localize_script ( $this->plugin_meta ['shortname'] . '-' . $script ['script_name'], $this -> plugin_meta['shortname'] . '_vars', $arrLocalizedVars );
				} else {
	
					if ($script ['script_source'] == 'shipped')
						wp_enqueue_style ( $script ['script_name'] );
					else
						wp_enqueue_style ( $this->plugin_meta ['shortname'] . '-' . $script ['script_name'], $this->plugin_meta ['url'] . $script ['script_source'] );
				}
			}
		}
	
	}
	
	
	
	
	/*
	 * creating menu page for this plugin
	*/
	
	function add_menu_pages(){
	
		foreach ($this -> menu_pages as $page){
	
		if ($page['parent_slug'] == ''){

				$menu = add_menu_page(sprintf(__("%s", 'nm-filemanager'),$page['page_title']),
						sprintf(__("%s", 'nm-filemanager'),$page['menu_title']),
						$page['cap'],
						$page['slug'],
						array($this, $page['callback']),
						$this->plugin_meta['logo'],
						$this->plugin_meta['menu_position']);
			}else{

				$menu = add_submenu_page($page['parent_slug'],
						sprintf(__("%s", 'nm-filemanager'),$page['page_title']),
						sprintf(__("%s", 'nm-filemanager'),$page['menu_title']),
						$page['cap'],
						$page['slug'],
						array($this, $page['callback'])
				);

			}
	
		}
		
	}
	
	
	
	
	/**
	 * after init admin
	 */
	function init_admin() {
		add_meta_box ( 'contact_forms_meta_box', 'Uploaded file', array (
				$this,
				'display_contact_form_meta_box' 
		), 'nm-forms', 'normal', 'high' );
	}
	
	/**
	* these are loading files in custom post type editor in admin
	*/
	
	function display_contact_form_meta_box($form) {
		echo '<p>' . __ ( 'Following files are uploaded:', 'nm-filemanager' ) . '</p>';
		
		$uploaded_files = get_post_meta ( $form->ID, 'uploaded_files', true );
		$uploaded_files = json_decode ( $uploaded_files );
		
		
		echo '<table>';
		
		if ($uploaded_files) {
			foreach ( $uploaded_files as $id => $file ) {
				
				$file_url = $this->get_file_dir_url () . $file;
				
				$type = strtolower ( substr ( strrchr ( $file, '.' ), 1 ) );
				if (($type == "gif") || ($type == "jpeg") || ($type == "png") || ($type == "pjpeg") || ($type == "jpg"))
					$thumb_url = $this->get_file_dir_url ( true ) . $file;
				else
					$thumb_url = $this->plugin_meta ['url'] . '/images/file.png';
				
				echo '<tr>';
				echo '<td style="width: 20%"><img src="' . $thumb_url . '" /></td>';
				echo '<td><a href="' . $file_url . '" target="_blank">' . __ ( 'Download file/image: '.$id, 'nm-filemanager' ) . '</a></td>';
				
				$edited_path = $this->get_file_dir_path() . 'edits/' . $file;
				if (file_exists($edited_path)) {
					$file_url_edit = $this->get_file_dir_url () .  'edits/' . $file;
					echo '<td><a href="' . $file_url_edit . '" target="_blank">' . __ ( 'Download edited image: '.$id, 'nm-filemanager' ) . '</a></td>';;
				}
				echo '</tr>';
			}
		}
		echo '</table>';
	}
	
	// ====================== CALLBACKS =================================
	
	
	/*
	 * saving admin setting in wp option data table
	*/
	function save_settings(){
	
		//print_r($_REQUEST); exit;
	
		update_option($this -> plugin_meta['shortname'].'_settings', $_REQUEST);
		_e('All options are updated', 'nm-filemanager');
		die(0);
	}
	
	function nm_settings(){
	
		$this -> load_template('admin/settings.php');
	}
	
	function activate_plugin(){
		
		echo '<div class="wrap">';
		echo '<h2>' . __ ( 'Provide API key below:', 'nm_webcontact' ) . '</h2>';
		echo '<p>' . __ ( 'If you don\'t know your API key, please login into your: <a target="_blank" href="http://wordpresspoets.com/member-area">Member area</a>', 'nm_webcontact' ) . '</p>';
		
		echo '<form onsubmit="return validate_api_'.$this->plugin_meta['shortname'].'(this)">';
			echo '<p><label id="plugin_api_key">'.__('Entery API key', 'nm-filemanager').':</label><br /><input type="text" name="plugin_api_key" id="plugin_api_key" /></p>';
			wp_nonce_field();
			echo '<p><input type="submit" class="button-primary button" name="plugin_api_key" /></p>';
			echo '<p id="nm-sending-api"></p>';
		echo '</form>';
		
		echo '</div>';
		
	}
	
	/**
	 * listing all user files
	 * */
	 function nm_userfiles(){
	 	
	 	
	 	$this -> load_template('admin/user-files.php');
	 }
	
	
	/* ============== some helper functions =============== */
	function render_settings_input($data) {
	
		$field_id 	= $data['id'];
		$type 		= $data['type'];
		$value		= (isset($this ->plugin_settings[ $data['id']]) ? $this ->plugin_settings[ $data['id']] : '');
		$value		= stripslashes( $value );
		$options	= (isset($data['options']) ? $data['options'] : '');
	
		switch($type) {
	
			case 'text' :
				echo '<input type="text" name="' . $field_id . '" id="' . $field_id . '" value="' . $value . '" class="regular-text">';
				break;
	
			case 'textarea':
				echo '<textarea cols="45" rows="6" name="' . $field_id . '" id="' . $field_id . '" >'.$value.'</textarea>';
				break;
	
			case 'checkbox':
	
				foreach($options as $k => $label){
						
					echo '<label for="'.$field_id.'-'.$k.'">';
					echo '<input type="checkbox" name="' . $field_id . '" id="'.$field_id.'-'.$k.'" value="' . $k . '" '.checked( $value, $k, false).'>';
					printf(__("%s", 'nm-filemanager'), $label);
					echo '</label> ';
				}
	
				break;
	
			case 'radio':
					
				foreach($options as $k => $label){
	
					echo '<label for="'.$field_id.'-'.$k.'">';
					echo '<input type="radio" name="' . $field_id . '" id="'.$field_id.'-'.$k.'" value="' . $k . '" '.checked( $value, $k, false).'>';
					printf(__("%s", 'nm-filemanager'), $label);
					echo '</label> ';
				}
					
				break;
	
			case 'select':
	
				$default = (isset($data['default']) ? $data['default'] : 'Select option');
	
				echo '<select name="' . $field_id . '" id="' . $field_id . '" class="the_chosen">';
				echo '<option value="">'.$default.'</option>';
	
				foreach($options as $k => $label){
	
					echo '<option value="'.$k.'" '.selected( $value, $k, false).'>'.$label.'</option>';
				}
	
				echo '</select>';
				break;
	
			case 'color' :
				echo '<input type="text" name="' . $field_id . '" id="' . $field_id . '" value="' . $value . '" class="wp-color-field">';
				break;
	
		}
	}
	
}