<?php
/*
 * it is responsible to upload files
 */
 
global $nmfilemanager;
//$running_quota = 0;
$filemanager_runtime = $nmfilemanager -> get_runtime();
?>


<form id="form-save-new-file" style="background-color: <?php echo $this -> get_option('_uploader_bg_color'); ?>">
  
 	<div id="nm-uploadfile" class="nm-uploader-area">
	    <div id="container_buttons">
	        <div class="btn_center">
	            <a id="select-button" href="javascript:;" style="background-color: <?php echo $this -> get_option('_button_bg_color'); ?>; color: <?php echo $this -> get_option('_button_txt_color'); ?>">
	                <?php
					 $select_file_label = $this -> get_option ( '_button_title' );
				     $select_file_label	= (!$select_file_label == '') ? $select_file_label : 'Select Files';
					 printf(__('%s', 'nm-filemanager'), $select_file_label);
					?>
					<br />
					<i class="fa fa-upload fonticons"></i>
	            </a>
	            <?php
	            
				 $nm_file_size      = $this -> get_option ( '_max_file_size' );
				 $nm_file_types     = $this -> get_option ( '_file_types' );
				 $nm_file_quota		= $nmfilemanager -> get_user_role_quota();

				 // in free version we will have condition here to limit to 5 files only

				 $nm_files_allowed  = $this -> get_option ( '_max_files' );
				 $nm_files_allowed	= (!$nm_files_allowed == '') ? $nm_files_allowed : 5;

				 $nm_file_size 		= (!$nm_file_size == '') ? $nm_file_size : '5mb';
				 $nm_file_types		= (!$nm_file_types == '') ? $nm_file_types : 'jpg,png,gif,zip,pdf';
				 $total_used_size 	= get_user_meta( get_current_user_id(), '_nm_used_filesize', true );//$nmfilemanager->get_user_files_size(); 
				 $total_used_size   = (!$total_used_size == '') ? $total_used_size : '0';
 				 $myar = explode(',', $this->group_id); //array('3');

				 ?>
	            <em><?php printf( __('File max size: %s', 'nm-filemanager'), $nm_file_size);?></em><br />
	            <em><?php printf( __('File types: %s', 'nm-filemanager'), $nm_file_types);?></em><br />
                <em><?php printf( __('Files allowed: %s', 'nm-filemanager'), $nm_files_allowed);?></em><br />
                <em><?php printf( __('You have used %s of %s disk storage space.', 'nm-filemanager'), 
									($total_used_size > 0) ? size_format($total_used_size, 2) : '0 Bytes', 
									size_format($nm_file_quota*1024*1024, 2) );?></em>
	        </div>
	    </div>
	    <div id="filelist-uploadfile" class="filelist">
	        
	        
	    </div>
	</div>
	<div id="fileupload-button-bar" class="clearfix">
		<?php
		/**
		 * DO IT:
		 * Button label will be an option
		 */
		 $save_button_label = ( isset($save_button_label) ? $save_button_label : 'Save');
		 ?>
        <input name="file_term_id" type="hidden" value="<?php echo $this->group_id;?>" /> 
        <input name="nm_share_bp_group_id" type="hidden" value="<?php echo bp_get_group_id();?>" />         
		<input id="fileupload-button" type="submit" value="<?php printf( __('%s', 'nm-filemanager'), $save_button_label);?>" />
		<p style="text-align:center;margin-top: 25px;" id="nm-saving-file"></p> 
	</div>

    <?php 
	/**
	**************** User Area for Share File if Add on enabled *****************************
	*/
	if ( class_exists ( 'NM_WP_FileManager_Addon' ) && current_user_can( 'manage_options' ) ) {
		$nmfilemanager_addon = new NM_WP_FileManager_Addon();
		$nmfilemanager_addon -> render_share_users();
	}
	
	/**
	**************** END -- User Area for Share File if Add on enabled **********************
	*/
	?>
	
	<?php
	/**
	 * wp nonce
	 */
	 wp_nonce_field('saving_file','nm_filemanager_nonce');
	 ?>
</form>

<script>
	<!--
	var file_count_filemanager = 1;
	var running_quota = 0;
	var uploader_filemanager;
	
	jQuery(document).ready(function($) {
    $('.tabs .tab-links a').on('click', function(e)  {
        var currentAttrValue = $(this).attr('href');
 
        // Show/Hide Tabs
        $('.tabs ' + currentAttrValue).show().siblings().hide();
 
        // Change/remove current tab to active
        $(this).parent('li').addClass('active').siblings().removeClass('active');
 
        e.preventDefault();
    });

    $('#fileupload-button').on('click', function(e)  {
    	e.preventDefault();
    	$('#form-save-new-file').submit();
    });
    

    // file uploader script
    var $filelist_DIV = $('#filelist-uploadfile');
    uploader_filemanager = new plupload.Uploader({
		runtimes 			: '<?php echo $filemanager_runtime?>',
		browse_button 		: 'select-button', // you can pass in id...
		container			: 'nm-uploadfile', // ... or DOM Element itself
		drop_element		: 'nm-uploadfile',
		url 				: '<?php echo admin_url( 'admin-ajax.php', (is_ssl() ? 'https' : 'http') );?>',
		multipart_params 	: {'action' : 'nm_filemanager_upload_file'},
		max_file_size 		: '<?php echo $nm_file_size;?>',
		max_file_count 		: <?php echo $nm_files_allowed;?>,
		filesize_quota 		: <?php echo $nm_file_quota*1024*1024;?>,
		size_used			: <?php echo $total_used_size ?>,
	    
	    chunk_size: '1mb',
		
	    // Flash settings
		flash_swf_url 		: '<?php echo $postfront -> plugin_meta['url']?>/js/plupload-2.1.2/js/uploader/Moxie.swf',
		// Silverlight settings
		silverlight_xap_url : '<?php echo $postfront -> plugin_meta['url']?>/js/plupload-2.1.2/js/uploader/Moxie.xap',
		
		filters : {
			mime_types: [
				{title : "Filetypes", extensions : "<?php echo $nm_file_types;?>"}
			]
		},
		
		init: {
			PostInit: function() {
				$filelist_DIV.html('');

			},

			FilesAdded: function(up, files) {

				var files_added = up.files.length;
				var max_count_error = false;
				var user_quota_error = false;

			    plupload.each(files, function (file) {
			    	if(file_count_filemanager <= uploader_filemanager.settings.max_file_count){
						if ((running_quota + file.size + uploader_filemanager.settings.size_used) <= uploader_filemanager.settings.filesize_quota || uploader_filemanager.settings.filesize_quota == '') {
			        		// Code to add pending file details, if you want
				            add_thumb_box(file, $filelist_DIV, up);
				            setTimeout('uploader_filemanager.start()', 100);
							running_quota += file.size;
				            file_count_filemanager++;
			      		}else{
							user_quota_error = true;
						}
			        }else{
			            max_count_error = true;
			        }
			        
			        
			    });

			    
			    if(max_count_error){
			    	alert(<?php echo $nm_files_allowed;?> + nm_filemanager_vars.message_max_files_limit);
			    }
				if(user_quota_error){
			    	alert('You are exceeding your file size quota');
					//location.reload();
			    }

			    
			},
			
			FileUploaded: function(up, file, info){
				
				/* console.log(up);
				console.log(file);*/
				
				
				$filelist_DIV.find('#u_i_c_' + file.id).find('.file-thumb-title-description').show();
				$('#fileupload-button-bar').show();
				
				var obj_resp = $.parseJSON(info.response);
				//console.log(obj_resp);
				var file_thumb 	= ''; 

			
				// checking if uploaded file is thumb
				ext = obj_resp.file_name.substring(obj_resp.file_name.lastIndexOf('.') + 1);					
				ext = ext.toLowerCase();
				
				if(ext == 'png' || ext == 'gif' || ext == 'jpg' || ext == 'jpeg'){

					$.each(obj_resp.thumb_meta, function(i, item){
						file_thumb = nm_filemanager_vars.file_upload_path_thumb + item.name;
						$filelist_DIV.find('#u_i_c_' + file.id).find('.u_i_c_thumb').append('<img width="150" src="'+file_thumb+ '" id="thumb_'+file.id+'" />');
					});
					
					
					
					var file_full 	= nm_filemanager_vars.file_upload_path + obj_resp.file_name;
					// thumb thickbox only shown if it is image
					$filelist_DIV.find('#u_i_c_' + file.id).find('.u_i_c_thumb').append('<div style="display:none" id="u_i_c_big' + file.id + '"><img src="'+file_full+ '" /></div>');
					
					// zoom effect
					$filelist_DIV.find('#u_i_c_' + file.id).find('.u_i_c_tools_zoom').append('<a href="#TB_inline?width=900&height=500&inlineId=u_i_c_big'+file.id+'" class="thickbox" title="'+obj_resp.file_name+'"><img width="15" src="'+nm_filemanager_vars.plugin_url+'/images/zoom.png" /></a>');
					is_image = true;
				}else{
					
					
					$filelist_DIV.find('#u_i_c_' + file.id).find('.u_i_c_thumb').html('<i class="fa fa-file-text fonticonfiles"></i>');
					is_image = false;
				}
				
				// adding checkbox input to Hold uploaded file name as array
				$filelist_DIV.append('<input style="display:none" checked="checked" type="checkbox" value="'+obj_resp.file_name+'" name="uploaded_files['+file.id+']" />');
				
				//file name	
				$filelist_DIV.find('#u_i_c_' + file.id).find('.progress_bar').html(obj_resp.file_name);
			
			},

			UploadProgress: function(up, file) {
				//document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
				//console.log($filelist_DIV.find('#' + file.id).find('.progress_bar_runner'));
				$filelist_DIV.find('#u_i_c_' + file.id).find('.progress_bar_number').html(file.percent + '%');
				$filelist_DIV.find('#u_i_c_' + file.id).find('.progress_bar_runner').css({'display':'block', 'width':file.percent + '%'});
			},

			Error: function(up, err) {
				//document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
				alert("\nError #" + err.code + ": " + err.message);
			}
		}
		

	});

    uploader_filemanager.init();
    
    // delete file
			$(".nm-file-thumb").find('.u_i_c_tools_del > a').live('click', function(){

				//console.log($(this));
				var a = confirm(nm_filemanager_vars.delete_file_message);
				if(a){
					// it is removing from uploader instance
					var fileid = $(this).attr("data-fileid");
					uploader_filemanager.removeFile(fileid);

					var filename  = jQuery('input:checkbox[name="uploaded_files['+fileid+']"]').val();
					
					// it is removing physically if uploaded
					jQuery("#u_i_c_"+fileid).find('img').attr('src', nm_filemanager_vars.plugin_url+'/images/loading.gif');
					
						var data = {action: 'nm_filemanager_delete_file_new', file_name: filename};
					
						jQuery.post(nm_filemanager_vars.ajaxurl, data, function(resp){
							alert(resp.message);
							jQuery("#u_i_c_"+fileid).hide(500).remove();

							// it is removing for input Holder
							jQuery('input:checkbox[name="uploaded_files['+fileid+']"]').remove();
							running_quota -= resp.file_size;
							file_count_filemanager--;
						
					}, 'json');
				}
			});

});


	
	function add_thumb_box(file, $filelist_DIV){
		
		var inner_html 		= '<div class="file-thumb-title-description" style="display:none">';
				inner_html 		+= '<div class="nm-file-thumb">';
				inner_html 		+= '<div class="u_i_c_thumb"></div>';
				inner_html		+= '<span class="u_i_c_tools_zoom"></span> ';
				inner_html		+= '<span class="u_i_c_tools_del"><a href="javascript:;" data-fileid="' + file.id+'" title="Delete"><img width="15" src="'+nm_filemanager_vars.plugin_url+'/images/delete.png" /></a></span>';
				        
		    	inner_html		+= '</div>';
		    
			    inner_html		+= '<div class="nm-file-title-description">';
			    inner_html		+= '<input name="file_title['+file.id+']" type="text" placeholder="<?php _e('File title', 'nm-filemanager');?>" />';
			    inner_html		+= '<textarea name="file_description['+file.id+']" rows="5" placeholder="<?php _e('Description (optional)', 'nm-filemanager');?>"></textarea>';
			    inner_html		+= '</div>';
			    
			    inner_html 		+= '<p class="file-add-meta-data"></p>';
		    
		    	inner_html		+= '<div class="clear"></div>';
		    	
		    inner_html		+= '</div>';
			
			inner_html		+= '<div class="progress_bar"><span class="progress_bar_runner"></span><span class="progress_bar_number">(' + plupload.formatSize(file.size) + ')<span></div>';
		
		jQuery( '<div />', {
			'id'	: 'u_i_c_'+file.id,
			'class'	: 'u_i_c_box',
			'html'	: inner_html,
			
		}).appendTo($filelist_DIV);

		// clearfix
		// 1- removing last clearfix first
		$filelist_DIV.find('.u_i_c_box_clearfix').remove();
		
		jQuery( '<div />', {
			'class'	: 'u_i_c_box_clearfix',				
		}).appendTo($filelist_DIV);
	}
	//-->
</script>
