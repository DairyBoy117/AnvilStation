var file_count_metaadded = Array();
jQuery(function($){
	
	$("#the-file-directory").tabs();
	
	$("#form-save-new-file").submit(function(e){
		
		e.preventDefault();
		
		
		var form = $(this); 
		//console.log(form);
		var is_validated = validate_file_data();
		if ( is_validated ) {
			jQuery(form).find("#nm-saving-file").html(
					'<img src="' + nm_filemanager_vars.doing + '">');

			var data = jQuery(form).serialize();
			data = data + '&action=nm_filemanager_save_file_data&parent_id='+get_parent_id();
			var share_users = new Array();
				jQuery("input[name='share_users']:checked").each(function()
				{
					share_users.push(jQuery(this).val());
				});
			data = data + '&shareusers='+share_users;
			//console.log(data); return false;

			jQuery.post(nm_filemanager_vars.ajaxurl, data, function(resp) {
				//console.log(resp); return false;
				//var str = "Edit file meta";
				//var edit_meta_link = str.link("javascript:edit_file_meta("+resp.postid+")");
				if(resp.status == 'error'){
					jQuery(form).find("#nm-saving-file").html(resp.message).css('color', 'red');
				}else{
						jQuery(form).find("#fileupload-button").hide();
						
						jQuery(form).find("#nm-saving-file").html(resp.message).css('color', 'green');
	
						if(nm_filemanager_vars.file_meta.length == 0)
							window.location.reload(true);
						else
							show_file_meta_button(resp.postids);
							// jQuery(form).find("#nm-saving-file").append('<br>'+nm_filemanager_vars.file_meta_notice).css('color', 'green');
				}
			}, 'json');

		} 
		
	});
	
	
});

function share_file_user(post_id) {

	jQuery('#nm-sharing-file-'+post_id).html('<img src="' + nm_filemanager_vars.doing + '">');

	data = 'action=nm_filemanager_share_user_file&post_id='+post_id;
	var share_users_file = new Array();
		jQuery("input[name='share_users_"+post_id+"']:checked").each(function()
		{
			share_users_file.push(jQuery(this).val());
		});
	data = data + '&shareusersfile='+share_users_file;
	//console.log(data); return false;

	jQuery.post(nm_filemanager_vars.ajaxurl, data, function(resp) {
	
		alert(resp);
		jQuery('#nm-sharing-file-'+post_id).html('');
		// self.parent.tb_remove();
		jQuery.prettyPhoto.close();
		return false

	});

}

function show_file_meta_button(postids){
	
	jQuery('span.u_i_c_box').each(function(i, box){

		// var meta_link = '<a href="javascript:;" onclick="edit_file_meta('+postids[i].id+', \''+postids[i].title+'\', \''+postids[i].filename+'\')" class="add_fiemeta"><i class="fa fa-plus-square fonticons"></i> '+nm_filemanager_vars.file_meta_label+'</a>';
		var postData = {
			action: 'nm_filemanager_edit_file_meta',
			postid: postids[i].id,
			title: postids[i].title,
			filename: postids[i].filename
		}
		jQuery.post(nm_filemanager_vars.ajaxurl, postData, function(resp) {
			jQuery(box).find('.nm-file-title-description').html(resp);
		});
	});
	
}


function get_parent_id(){

	//checking if tree template is selected
	var parent_id = 0;
	parent_id = jQuery('input[name="parent_id"]').val();

	return parent_id;

}

/**
 * validating the file data
 * return true if ok
 */
function validate_file_data(){
	var total_files = jQuery('input:checkbox[name^="uploaded_files"]').length;
	var title_text = jQuery('.filelist').find('input[type="text"]');
	var is_ok = true;

	if( !get_option('_min_files') == '' && total_files < get_option('_min_files') ){
		is_ok = false;
		alert('You must upload atleast '+get_option('_min_files')+' files.');
	} else {	
		jQuery.each(title_text, function(i, item){
			
			jQuery(item).css({'border-color':'#000'});
			
			if( jQuery(item).val() == ''){
				is_ok = false;
				jQuery(item).css({'border-color':'#ff0000'});
			}
		});
	}
	return is_ok;
}

/**
 * saving file meta 
 */
function update_file_data(form) {

	//console.log(form);
	jQuery(form).find("#nm-saving-file-meta").html(
			'<img src="' + nm_filemanager_vars.doing + '">');
	
	var is_ok = validate_update_data(form);
	var file_ok = true;
	
	if (is_ok && file_ok) {

		var data = jQuery(form).serialize();
		data = data + '&action=nm_filemanager_update_file_data';
		
		jQuery.post(nm_filemanager_vars.ajaxurl, data, function(resp) {

			//console.log(resp);
			
			if(resp.status == 'error'){
				jQuery(form).find("#nm-saving-file-meta").html(jQuery('input:hidden[name="_error_message"]').val()).css('color', 'red');
			}else{
					jQuery(form).find("#nm-saving-file-meta").html(resp.message).css('color', 'green');
					tb_remove(nm_filemanager_vars.file_meta_heading);
					file_count_metaadded.push(resp.postid);
					//console.log(file_count_metaadded);
					
					if(file_count_metaadded.length >= jQuery('input:checkbox[name^="uploaded_files"]').length && resp.status != 'updated'){
						window.location.reload();	
					}
			}
		}, 'json');

	} else {

		jQuery(form).find("#nm-saving-file-meta")
				.html('Please fill required fields.').css('color', 'red');
	}

	return false;
}

function validate_update_data(form){
	
	var form_data = jQuery.parseJSON( jQuery(form).attr('data-form') );
	var has_error = true;
	var error_in = '';
	
	jQuery.each( form_data, function( key, meta ) {
		
		var type = meta['type'];
		var error_message	= stripslashes( meta['error_message'] );
		
		console.log('typ e'+type+' error message '+error_message+'\n\n');
		  
		if(type === 'text' || type === 'textarea' || type === 'select' || type === 'email' || type === 'date'){
			
			var input_control = jQuery('#'+meta['data_name']);
			
			if(meta['required'] === "on" && jQuery(input_control).val() === ''){
				jQuery(input_control).closest('div').find('span.errors').html(error_message).css('color', 'red');
				has_error = false;
				error_in = meta['data_name']
			}else{
				jQuery(input_control).closest('div').find('span.errors').html('').css({'border' : '','padding' : '0'});
			}
		}else if(type === 'checkbox'){
			
			//console.log('im error in cb '+error_message);	
			if(meta['required'] === "on" && jQuery('input:checkbox[name="'+meta['data_name']+'[]"]:checked').length === 0){
				
				jQuery('input:checkbox[name="'+meta['data_name']+'[]"]').closest('div').find('span.errors').html(error_message).css('color', 'red');
				has_error = false;
			}else if(meta['min_checked'] != '' && jQuery('input:checkbox[name="'+meta['data_name']+'[]"]:checked').length < meta['min_checked']){
				jQuery('input:checkbox[name="'+meta['data_name']+'[]"]').closest('div').find('span.errors').html(error_message).css('color', 'red');
				has_error = false;
			}else if(meta['max_checked'] != '' && jQuery('input:checkbox[name="'+meta['data_name']+'[]"]:checked').length > meta['max_checked']){
				jQuery('input:checkbox[name="'+meta['data_name']+'[]"]').closest('div').find('span.errors').html(error_message).css('color', 'red');
				has_error = false;
			}else{
				
				jQuery('input:checkbox[name="'+meta['data_name']+'[]"]').closest('div').find('span.errors').html('').css({'border' : '','padding' : '0'});
				
				}
		}else if(type === 'radio'){
				
				if(meta['required'] === "on" && jQuery('input:radio[name="'+meta['data_name']+'"]:checked').length === 0){
					jQuery('input:radio[name="'+meta['data_name']+'"]').closest('div').find('span.errors').html(error_message).css('color', 'red');
					has_error = false;
					error_in = meta['data_name']
				}else{
					jQuery('input:radio[name="'+meta['data_name']+'"]').closest('div').find('span.errors').html('').css({'border' : '','padding' : '0'});
				}
		}else if(type === 'masked'){
			
			var input_control = jQuery('#'+meta['data_name']);
			
			if(meta['required'] === "on" && (jQuery(input_control).val() === '' || jQuery(input_control).attr('data-ismask') === 'no')){
				jQuery(input_control).closest('div').find('span.errors').html(error_message).css('color', 'red');
				has_error = false;
				error_in = meta['data_name'];
			}else{
				jQuery(input_control).closest('div').find('span.errors').html('').css({'border' : '','padding' : '0'});
			}
		}
		
	});
	
	//console.log( error_in ); return false;
	return has_error;
}

/**
 * this function extract values from setting 
 */
function get_option(key) {

	/*
	 * TODO: change plugin shortname
	 */
	var keyprefix = 'nm_filemanager';

	key = keyprefix + key;

	var req_option = '';

	jQuery.each(nm_filemanager_vars.settings, function(k, option) {

		// console.log(k);

		if (k == key)
			req_option = option;
	});

	// console.log(req_option);
	return req_option;
}
/**
 * this function confirms before deleting file 
 */
function confirmFirstDelete(url)
{
	var a = confirm(nm_filemanager_vars.delete_file_message);
	if(a)
	{
		window.location = url;
	}
}

/* sharing file with thick box dialog */
function share_file( file_name, file_owner_id ){
	
var uri_string = encodeURI('action=nm_filemanager_share_file&width=600&height=375&filename='+file_name+'&fileownerid='+file_owner_id);
	
	var url = nm_filemanager_vars.ajaxurl + '?' + uri_string;
	tb_show(nm_filemanager_vars.share_file_heading, url);
}

/* sharing file ajax function */
function send_files_email(form) {
	//console.log(form);
	
	jQuery("#sending-mail").show();
		if (jQuery("#shared_single_file").val() != "") 
			var files_to_send = jQuery("#shared_single_file").val();
		else
			var files_to_send = jQuery("#file-names").val();
			
		var data = {
			action: 'nm_filemanager_send_files_email',
			file_names: files_to_send,
			subject: jQuery("#subject").val(),
			email_to: jQuery("#email-to").val(),
			file_msg: jQuery("#file-msg").val(),
			file_owner_id: jQuery("#file_owner_id").val(),
		};
		//alert("done");
		jQuery.post(nm_filemanager_vars.ajaxurl, data, function(resp) {
			
			if(resp.status === 'error'){
				jQuery("#sending-mail").html(resp.message).css('color', 'red');	
			}else{
				jQuery("#sending-mail").html(resp.message).css('color', 'green');	
				location.reload(true);
			}
			
			
			
		}, 'json');

	return false;
}


/* edit file meta with thick box dialog */
function edit_file_meta( id, title, filename ){
	
	var uri_string = encodeURI('action=nm_filemanager_edit_file_meta&width=600&postid='+id+'&title='+title+'&filename='+filename);
	
	var url = nm_filemanager_vars.ajaxurl + '?' + uri_string;
	tb_show(nm_filemanager_vars.file_meta_heading, url);
}

/* edit file meta with thick box dialog */
function print_user_names(){
	jQuery("#shared-user-names").html('');
	jQuery("input[name='share_users']:checked").each(function()
			{
				//share_users.push(jQuery(this).val());
				jQuery("#shared-user-names").append(jQuery('#'+jQuery(this).val()).val()+', ');
			});
}

function stripslashes (str) {
	  // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	  // +   improved by: Ates Goral (http://magnetiq.com)
	  // +      fixed by: Mick@el
	  // +   improved by: marrtins
	  // +   bugfixed by: Onno Marsman
	  // +   improved by: rezna
	  // +   input by: Rick Waldron
	  // +   reimplemented by: Brett Zamir (http://brett-zamir.me)
	  // +   input by: Brant Messenger (http://www.brantmessenger.com/)
	  // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
	  // *     example 1: stripslashes('Kevin\'s code');
	  // *     returns 1: "Kevin's code"
	  // *     example 2: stripslashes('Kevin\\\'s code');
	  // *     returns 2: "Kevin\'s code"
	  return (str + '').replace(/\\(.?)/g, function (s, n1) {
	    switch (n1) {
	    case '\\':
	      return '\\';
	    case '0':
	      return '\u0000';
	    case '':
	      return '';
	    default:
	      return n1;
	    }
	  });
	}
