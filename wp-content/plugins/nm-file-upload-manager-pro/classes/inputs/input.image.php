<?php
/*
 * Followig class handling pre-uploaded image control and their dependencies. Do not make changes in code Create on: 9 November, 2013
 */
class NM_Image extends NM_Inputs_filemanager {
	
	/*
	 * input control settings
	 */
	var $title, $desc, $settings;
	
	/*
	 * this var is pouplated with current plugin meta
	 */
	var $plugin_meta;
	function __construct() {
		$this->plugin_meta = get_plugin_meta_filemanager ();
		
		$this->title = __ ( 'Image (Pre-uploaded)', 'nm-filemanager' );
		$this->desc = __ ( 'Images selection', 'nm-filemanager' );
		$this->settings = self::get_settings ();
	}
	private function get_settings() {
		return array (
				'title' => array (
						'type' => 'text',
						'title' => __ ( 'Title', 'nm-filemanager' ),
						'desc' => __ ( 'It will be shown as field label', 'nm-filemanager' ) 
				),
				'data_name' => array (
						'type' => 'text',
						'title' => __ ( 'Data name', 'nm-filemanager' ),
						'desc' => __ ( 'REQUIRED: The identification name of this field, that you can insert into body email configuration. Note:Use only lowercase characters and underscores.', 'nm-filemanager' ) 
				),
				'description' => array (
						'type' => 'text',
						'title' => __ ( 'Description', 'nm-filemanager' ),
						'desc' => __ ( 'Small description, it will be diplay near name title.', 'nm-filemanager' ) 
				),
				'error_message' => array (
						'type' => 'text',
						'title' => __ ( 'Error message', 'nm-filemanager' ),
						'desc' => __ ( 'Insert the error message for validation.', 'nm-filemanager' ) 
				),
				
				'class' => array (
						'type' => 'text',
						'title' => __ ( 'Class', 'nm-filemanager' ),
						'desc' => __ ( 'Insert an additional class(es) (separateb by comma) for more personalization.', 'nm-filemanager' ) 
				),
				
				'width' => array (
						'type' => 'text',
						'title' => __ ( 'Width', 'nm-filemanager' ),
						'desc' => __ ( 'Type field width in % e.g: 50%', 'nm-filemanager' ) 
				),
				
				'required' => array (
						'type' => 'checkbox',
						'title' => __ ( 'Required', 'nm-filemanager' ),
						'desc' => __ ( 'Select this if it must be required.', 'nm-filemanager' ) 
				),
				
				'images' => array (
						'type' => 'pre-images',
						'title' => __ ( 'Select images', 'nm-filemanager' ),
						'desc' => __ ( 'Select images from media library', 'nm-filemanager' ) 
				),
				
				'multiple_allowed' => array (
						'type' => 'checkbox',
						'title' => __ ( 'Allow multiple?', 'nm-filemanager' ),
						'desc' => __ ( 'Allow users to select more then one images?.', 'nm-filemanager' ) 
				),
				
				'popup_width' => array (
						'type' => 'text',
						'title' => __ ( 'Popup width', 'nm-filemanager' ),
						'desc' => __ ( 'Popup window width in px e.g: 750', 'nm-filemanager' ) 
				),
				
				'popup_height' => array (
						'type' => 'text',
						'title' => __ ( 'Popup height', 'nm-filemanager' ),
						'desc' => __ ( 'Popup window height in px e.g: 550', 'nm-filemanager' ) 
				),
				
				'logic' => array (
						'type' => 'checkbox',
						'title' => __ ( 'Enable conditional logic', 'nm-filemanager' ),
						'desc' => __ ( 'Tick it to turn conditional logic to work below', 'nm-filemanager' ) 
				),
				'conditions' => array (
						'type' => 'html-conditions',
						'title' => __ ( 'Conditions', 'nm-filemanager' ),
						'desc' => __ ( 'Tick it to turn conditional logic to work below', 'nm-filemanager' ) 
				) 
		);
	}
	
	/*
	 * @params: $options
	 */
	function render_input($args, $images = "", $existing_val = "") {
		$existing_images = unserialize ( $existing_val );
		
		$_html = '<div class="pre_upload_image_box">';
		
		$img_index = 0;
		$popup_width = $args ['popup-width'] == '' ? 600 : $args ['popup-width'];
		$popup_height = $args ['popup-height'] == '' ? 450 : $args ['popup-height'];
		
		if ( is_array($images) ){
		foreach ( $images as $image ) {
			$checked = '';
			/*if ( !isset($image ['link']) ){
				$image ['link'] = '';
			}*/
			$_html .= '<div class="pre_upload_image">';
			if ( isset($image ['link']) ){
				$_html .= '<img width="75" src="' . $image ['link'] . '" />';
			}
			if ($existing_images) {
				
				if ( isset($image ['link']) && in_array ( $image ['link'], $existing_images )) {
					$checked = 'checked="checked"';
				} else {
					$checked = '';
				}
			}
			
			// for bigger view
			if ( isset($image ['link']) ){
				$_html .= '<div style="display:none" id="pre_uploaded_image_' . $args ['id'] . '-' . $img_index . '"><img style="margin: 0 auto;display: block;" src="' . $image ['link'] . '" /></div>';
			}
			$_html .= '<div class="input_image">';
			if ($args['multiple-allowed'] == 'on') {
				$_html .= '<input type="checkbox" data-price="' . $image ['price'] . '" data-title="' . stripslashes ( $image ['title'] ) . '" name="' . $args ['name'] . '[]" value="' . $image ['link'] . '" ' . $checked . ' />';
			} else {
				$_html .= '<input type="radio" data-price="' . $image ['price'] . '" data-title="' . stripslashes ( $image ['title'] ) . '" name="' . $args ['name'] . '" value="' . $image ['link'] . '" ' . $checked . ' />';
			}
			
			// image big view
			$price = '';
			/*if (function_exists ( woocommerce_price ))
				$price = woocommerce_price ( $image ['price'] );
			else*/
				$price = $image ['price'];
			
			$_html .= '<a href="#TB_inline?width=' . $popup_width . '&height=' . $popup_height . '&inlineId=pre_uploaded_image_' . $args ['id'] . '-' . $img_index . '" class="thickbox" title="' . $image ['title'] . '"><img width="15" src="' . $this->plugin_meta ['url'] . '/images/zoom.png" /></a>';
			$_html .= '<div class="p_u_i_name">' . stripslashes ( $image ['title'] ) . ' ' . $price . '</div>';
			$_html .= '</div>'; // input_image
			
			$_html .= '</div>';
			
			$img_index ++;
		}}
		
		$_html .= '<div style="clear:both"></div>'; // container_buttons
		
		$_html .= '</div>'; // container_buttons
		
		echo $_html;
		
		$this->get_input_js ( $args );
	}
	
	/*
	 * following function is rendering JS needed for input
	 */
	function get_input_js($args) {
		?>

<script type="text/javascript">	
					<!--
					jQuery(function($){
	
						
					});
					
					//--></script>
<?php
	}
}