<?php
/*
 * it is responsible to upload files
 */
 
global $nmfilemanager, $filemanager_runtime;

?>


<form id="form-create-new-directory"  style="background-color: <?php echo $this -> get_option('_uploader_bg_color'); ?>">
  
 	<div id="nm-create-directory" class="nm-uploader-area-directory">

 		<p>
	 		<label for="directory_name"><?php echo _e('Directory Name', 'nm-filemanager'); ?></label>
		    <input class="regular-text" type="text" name="directory_name" id="directory_name" />
	    </p>
	    <p>
	    	<label for="directory_detail"><?php echo _e('Directory Details', 'nm-filemanager'); ?></label>
	    	<textarea id="directory_detail" name="directory_detail"></textarea>
	    </p>
            <input name="file_term_id" type="hidden" value="<?php echo $this->group_id;?>" />
            <input name="nm_share_bp_group_id" type="hidden" value="<?php echo bp_get_group_id();?>" /> 
	</div>
	
	<div class="clear"></div>
	<div id="directory-button-bar" class="clearfix">
		<?php
		/**
		 * DO IT:
		 * Button label will be an option
		 */
		 $save_button_label = ( isset($save_button_label) ? $save_button_label : 'Save');
		 ?>
		<input type="submit" class="submit-styles" id="creat-directory-button" <?php  __('Create directory', 'nm-filemanager');?> />
			
		<p style="text-align:center;margin-top: 25px;" id="nm-saving-dir"></p> 
	</div>

   
	<?php
	/**
	 * wp nonce
	 */
	 wp_nonce_field('create_directory','nm_filemanager_nonce');
	 ?>
</form>

<script>
	<!--
	jQuery(document).ready(function($) {
   

    $('#form-create-new-directory').on('submit', function(e)  {
    	e.preventDefault();
    	
    	var dir_name = $("#directory_name");
    	
    	if(dir_name.val() === ''){
    		dir_name.css('border', 'red 2px solid');
    	}

    	else {
    		
	    	$("#nm-saving-dir").text('Creating...');

	    	var directory_data = $(this).serialize();
			directory_data = directory_data + '&action=nm_filemanager_create_directory&parent_id='+get_parent_id();

			$.post(nm_filemanager_vars.ajaxurl, directory_data, function(resp){
					
				$("#nm-saving-dir").text('Directory Created').css({'color':'green'});
				location.reload();
			});

    	}

    });
});

//-->
</script>
