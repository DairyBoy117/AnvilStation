<?php
/*
 * rendering product meta on product page
*/

global $nmfilemanager;

$existing_meta = get_option('filemanager_meta');

//filemanager_pa($existing_meta);

if($existing_meta){
?>

<style>
	#nm-filemanager-box {
		padding: 5px;
	}
	#nm-filemanager-box label.meta-data-label{
		font-size: 18px;
	}
	
	#nm-filemanager-box .show_description{
		font-size: 12px;
		color: #CCCCCC;
	}
	
	#nm-filemanager-box p{
		float:left;
	}
	
</style>

<?php 

echo '<form id="filemanager-meta" class="form-horizontal"';
echo 'onsubmit = "return update_file_data(this)"';
echo 'data-form="'.esc_attr( json_encode( $existing_meta )	 ).'">';
echo '<div id="nm-filemanager-box" class="nm-filemanager-box">';

echo "<input type='hidden' name='_post_id' id='_post_id' value='". $_REQUEST['postid']."'>";
echo "<input type='hidden' name='_post_title' id='_post_title' value='". $_REQUEST['title']."'>";
echo "<input type='hidden' name='_post_filename' id='_filename' value='". $_REQUEST['filename']."'>";
//echo "post id is ".$_REQUEST['postid'];
$postid = $_REQUEST['postid'];
		foreach($existing_meta as $key => $meta)
		{
			
			//filemanager_pa($meta);
			$type = $meta['type'];
			$name = strtolower( preg_replace("![^a-z0-9]+!i", "_", $meta['data_name']) );
			
			// conditioned elements

			$visibility = '';
			$conditions_data = '';
			if ( isset($meta['logic']) && $meta['logic'] == 'on' ) {
				
				if($meta['conditions']['visibility'] == 'Show')
					$visibility = 'display: none';
		
				$conditions_data	= 'data-rules="'.esc_attr( json_encode($meta['conditions'] )).'"';
			}
			
			$show_asterisk 		= (isset( $meta['required'] ) && $meta['required']) ? '<span class="show_required"> *</span>' : '';
			$show_description	= ($meta['description']) ? '<span class="show_description"> '.stripslashes($meta['description']).'</span>' : '';

			$the_width = ($meta['width'] == '' ? 50 : $meta['width']);
			$the_width = intval( $the_width ) - 1 .'%';
			$the_margin = '1%';

			$field_label = stripslashes( $meta['title'] ) . $show_asterisk;
			
			if( isset( $meta['required'] ) ){
				$required = $meta['required'];
			} else {
				$required = '';
			}
			if( isset( $meta['error_message'] ) ){
				$error_message = $meta['error_message'];
			} else {
				$error_message = '';
			}
			$args = '';
			
			switch($type)
			{
				
				case 'text':
					
					$args = array(	'name'			=> $name,
									'id'			=> $name,
									'data-type'		=> $type,
									'data-req'		=> $required,
									'data-message'	=> $error_message);

					echo '<div class="form-group" id="box-'.$name.'">';
						echo '<label for="'.$name.'" class="col-sm-3 control-label">'. $field_label.'</label>';
						echo '<div class="col-sm-9">';
							$existing_value = get_post_meta($postid, $meta['data_name'], true);
							$nmfilemanager -> inputs[$type]	-> render_input($args, $existing_value);					
							echo '<span class="help-block">'.$show_description.'</span>';
						echo '</div>';
					
					
					//for validtion message
					echo '<span class="errors"></span>';
					echo '</div>';
					break;
					
				case 'masked':
						
					$args = array(	'name'			=> $name,
					'id'			=> $name,
					'data-type'		=> $type,
					'data-req'		=> $required,
					'data-mask'		=> $meta['mask'],
					'data-ismask'	=> "no",
					'data-message'	=> $error_message);

					echo '<div class="form-group" id="box-'.$name.'">';
						echo '<label for="'.$name.'" class="col-sm-3 control-label">'. $field_label.'</label>';
						echo '<div class="col-sm-9">';
							$existing_value = get_post_meta($postid, $meta['data_name'], true);
							$nmfilemanager -> inputs[$type]	-> render_input($args, $existing_value);
							echo '<span class="help-block">'.$show_description.'</span>';
						echo '</div>';
						
					//for validtion message
					echo '<span class="errors"></span>';
					echo '</div>';
					break;
				
				
			
				case 'date':
					
					$args = array(	'name'			=> $name,
									'id'			=> $name,
									'data-type'		=> $type,
									'data-req'		=> $required,
									'data-message'	=> $error_message,
									'data-format'	=> $meta['date_formats']);
			
					echo '<div class="form-group" id="box-'.$name.'">';
						echo '<label for="'.$name.'" class="col-sm-3 control-label">'. $field_label.'</label>';
						echo '<div class="col-sm-9">';
							$existing_value = get_post_meta($postid, $meta['data_name'], true);
							$nmfilemanager -> inputs[$type]	-> render_input($args, $existing_value);
							echo '<span class="help-block">'.$show_description.'</span>';
						echo '</div>';
					//for validtion message
					echo '<span class="errors"></span>';
					echo '</div>';
					break;
		
		
				case 'textarea':
				
		
					$args = array(	'name'	=> $name,
							'id'			=> $name,
							'data-type'		=> $type,
							'data-req'		=> $required,
							'data-message'	=> $error_message);
					
					echo '<div class="form-group" id="box-'.$name.'">';
						echo '<label for="'.$name.'" class="col-sm-3 control-label">'. $field_label.'</label>';
						echo '<div class="col-sm-9">';
							$existing_value = get_post_meta($postid, $meta['data_name'], true);
							$nmfilemanager -> inputs[$type]	-> render_input($args, $existing_value);
							echo '<span class="help-block">'.$show_description.'</span>';
						echo '</div>';
					//for validtion message
					echo '<span class="errors"></span>';
					echo '</div>';
					break;
					
						
				case 'select':
					
					
					$existing_value = get_post_meta($postid, $meta['data_name'], true);
					$options = explode("\n", $meta['options']);
					$default_selected = $existing_value;//$meta['selected'];
					
					$args = array(	'name'			=> $name,
									'id'			=> $name,
									'data-type'		=> $type,
									'data-req'		=> $required,
									'data-message'	=> $error_message);

					echo '<div class="form-group" id="box-'.$name.'">';
						echo '<label for="'.$name.'" class="col-sm-3 control-label">'. $field_label.'</label>';
						echo '<div class="col-sm-9">';
							$nmfilemanager -> inputs[$type]	-> render_input($args, $options, $default_selected);
							echo '<span class="help-block">'.$show_description.'</span>';
						echo '</div>';
					
					
				
					//for validtion message
					echo '<span class="errors"></span>';
					echo '</div>';					
					break;
						
				case 'radio':
					
					$existing_value = get_post_meta($postid, $meta['data_name'], true);
					$options = explode("\n", $meta['options']);
					$default_selected = $existing_value;//$meta['selected'];
					
					$args = array(	'name'			=> $name,
									'id'			=> $name,
									'data-type'		=> $type,
									'data-req'		=> $required,
									'data-message'	=> $error_message);

					echo '<div class="form-group" id="box-'.$name.'">';
						echo '<label for="'.$name.'" class="col-sm-3 control-label">'. $field_label.'</label>';
						echo '<div class="col-sm-9">';
							$nmfilemanager -> inputs[$type]	-> render_input($args, $options, $default_selected);
							echo '<span class="help-block">'.$show_description.'</span>';
						echo '</div>';
					
					
					//for validtion message
					echo '<span class="errors"></span>';
					echo '</div>';
					break;
		
				case 'checkbox':
			
					$existing_value = get_post_meta($postid, $meta['data_name'], true);
					$options = explode("\n", $meta['options']);
					$defaul_checked = $existing_value;//explode("|", $meta['checked']);
		
					$args = array(	'name'			=> $name,
							'id'			=> $name,
							'data-type'		=> $type,
							'data-req'		=> $required,
							'data-message'	=> $error_message);

					echo '<div class="form-group" id="box-'.$name.'">';
						echo '<label for="'.$name.'" class="col-sm-3 control-label">'. $field_label.'</label>';
						echo '<div class="col-sm-9">';
							$nmfilemanager -> inputs[$type]	-> render_input($args, $options, $defaul_checked);
							echo '<span class="help-block">'.$show_description.'</span>';
						echo '</div>';
					
					
					//for validtion message
					echo '<span class="errors"></span>';
					echo '</div>';
					break;
							
				}
		}
		
		
		echo '<div style="clear: both"></div>';
	
	echo '</div>';  //ends nm-filemanager-box
	
	$nm_upload_form_class = apply_filters('nm-uploadform-submit-class', 'submit-styles');
	echo '<p class=" text-center"><input type="submit" class="btn btn-success value="'.__('Update', 'nm-filemanager').'"></p>';
	echo '<span id="nm-saving-file-meta"></span>';
	wp_nonce_field('doing_contact','nm_filemanager_nonce');
	echo '</form>';
}
?>