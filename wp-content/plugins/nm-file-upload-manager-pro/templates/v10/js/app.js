var app = angular.module('fileUploaderApp',['blockUI', 'ang-drag-drop'], function($httpProvider){
	// Use x-www-form-urlencoded Content-Type
	$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

	/**
	 * The workhorse; converts an object to x-www-form-urlencoded serialization.
	 * @param {Object} obj
	 * @return {String}
	 */
	var param = function(obj) {
	    var query = '',
	        name, value, fullSubName, subName, subValue, innerObj, i;

	    for (name in obj) {
	        value = obj[name];

	        if (value instanceof Array) {
	            for (i = 0; i < value.length; ++i) {
	                subValue = value[i];
	                fullSubName = name + '[' + i + ']';
	                innerObj = {};
	                innerObj[fullSubName] = subValue;
	                query += param(innerObj) + '&';
	            }
	        } else if (value instanceof Object) {
	            for (subName in value) {
	                subValue = value[subName];
	                fullSubName = name + '[' + subName + ']';
	                innerObj = {};
	                innerObj[fullSubName] = subValue;
	                query += param(innerObj) + '&';
	            }
	        } else if (value !== undefined && value !== null)
	            query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
	    }

	    return query.length ? query.substr(0, query.length - 1) : query;
	};

	// Override $http service's default transformRequest
	$httpProvider.defaults.transformRequest = [function(data) {
	    return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
	}];	
});


/** config block  */
app.config(function(blockUIConfig) {

  // Tell blockUI not to mark the body element as the main block scope.

  blockUIConfig.autoInjectBodyBlock = false;  

})

	/* Controllers */

app.controller('MainCtrl', ['$scope', '$http', '$sce', 'blockUI', '$timeout' , function($scope, $http, $sce, blockUI, $timeout){

    $scope.activeNav = 'myfiles';
    $scope.activeView = 'list_thumb';
    $scope.filesListStyle = 'thumbs';
    
    var pluginBlockUI = blockUI.instances.get('filemanager-blockUI');
    
    $scope.ajaxurl = nm_filemanager_vars.ajaxurl;

    $scope.activeFilesScope = [];

    $scope.breadCrumb = [];

    $scope.theFile = {};
    
    $scope.current_directory = '';
    
    $scope.activeFileIndex = '';
    
    $scope.creating_dir = false;
    
    $scope.selectedGroup = '0';
    
    $scope.dir_move_id = '';
    
    // max number of file allowed/user @since 11.7
    $scope.maxUserFiles = 0;
    
    $scope.dropSuccessHandler = function($event, index, file){
          
          // if file is not dropped into directory then return
          if( $scope.dir_move_id === '' )
            return;
         
         pluginBlockUI.start({message: nm_filemanager_vars.messages.files_loading});   
            
          var file_dropped_id = file.id;
          
           var data = {
    		action: 'nm_filemanager_move_file',
    		file_id: file_dropped_id,
    		parent_id: $scope.dir_move_id
    	}
    	
    	$http.post(nm_filemanager_vars.ajaxurl, data ).success(function(resp){   
            
            
            $scope.get_my_files();
            
            pluginBlockUI.stop();
            
        });
      };
      
      $scope.onDrop = function($event,$data,file){
          if( file.node_type === 'file' )
            return;
            
        // setting directory id where file is being dropped
        $scope.dir_move_id = file.id;
       
      };
    

    $scope.folder_icon = nm_filemanager_vars.plugin_url+'/templates/v10/images/folder_icon.png';
    
    pluginBlockUI.start({message: nm_filemanager_vars.messages.files_loading});

    $http.get(nm_filemanager_vars.ajaxurl +'?action=nm_filemanager_get_user_files').success(function(data){

      $scope.activeFilesScope = data.all;
      $scope.allFiles = data.all;
      $scope.activeView = 'list_thumb';
      
      
      pluginBlockUI.stop();

    });
    
    $scope.display_dir = function(file, index){
    // 	var index = $scope.activeFilesScope.indexOf(file);
		var bc = {fileIndex: index, fileTitle: $scope.activeFilesScope[index].post_title};
		$scope.breadCrumb.push(bc);
		
		$scope.activeFileIndex = index;
		$scope.current_directory = $scope.activeFilesScope[index].id;
		$scope.activeFilesScope = $scope.activeFilesScope[index].children;
    }
    
    $scope.display_file = function(file){
    	var index = $scope.activeFilesScope.indexOf(file);
		var bc = {fileIndex: index, fileTitle: $scope.activeFilesScope[index].post_title};
		$scope.breadCrumb.push(bc);    	
		$scope.activeView = 'file_details';
		$scope.theFile = $scope.activeFilesScope[index];
    }
    
    $scope.go_to_home = function(){
    	$scope.breadCrumb = [];
		$scope.activeView = 'list_thumb';
		$scope.editingMeta = false;
		$scope.editTitleDesc = false;
		$scope.activeFilesScope = $scope.allFiles;
		$scope.current_directory = '';
    }
    
    $scope.breadcrumb_nav = function(bc_index, file_index){

    	$scope.activeView = 'list_thumb';
    	$scope.editingMeta = false;
    	$scope.editTitleDesc = false;
      
      	$scope.breadCrumb.length = bc_index + 1;

      	$scope.currentFilesNode = [];

		for (var i = 0; i <= $scope.breadCrumb.length; i++) {

			if ($scope.currentFilesNode.length > 0) {
				$scope.currentFilesNode = $scope.currentFilesNode[$scope.breadCrumb[i].fileIndex].children;
			} else {
				$scope.currentFilesNode = $scope.allFiles[$scope.breadCrumb[i].fileIndex].children;
			}

			if (i == bc_index) {
				break;
			};
		};
      
		$scope.activeFilesScope = $scope.currentFilesNode;
    }

    $scope.get_my_files = function(){
    	$scope.activeNav = 'myfiles';
        //$scope.activeView = 'loading';
        pluginBlockUI.start({message: nm_filemanager_vars.messages.files_loading});
        
        $http.get(nm_filemanager_vars.ajaxurl +'?action=nm_filemanager_get_user_files').success(function(data){

            $scope.activeFilesScope = data.all;
            $scope.allFiles = data.all;
            $scope.activeView = 'list_thumb';
            $scope.breadCrumb = [];
            $scope.editingMeta = false;
            $scope.editTitleDesc = false;
            
            pluginBlockUI.stop();
            
            
            // $scope.current_directory = '';
            if( $scope.activeFileIndex !== '' ) {
                // setting currect directory view
                var dir_data = $scope.activeFilesScope[$scope.activeFileIndex];
                $scope.display_dir(dir_data, $scope.activeFileIndex);
            }
            // $scope.$apply();

        });        
    }
    
    // just refreshing file after performing some action on data like delte, update, create etc
    $scope.refresh_files = function(){
    	$scope.activeNav = 'myfiles';
        //$scope.activeView = 'loading';
        pluginBlockUI.start({message: nm_filemanager_vars.messages.files_loading});
        
        $http.get(nm_filemanager_vars.ajaxurl +'?action=nm_filemanager_get_user_files').success(function(data){

            $scope.activeFilesScope = data.all;
            $scope.allFiles = data.all;
            $scope.activeView = 'list_thumb';
            
            // resetting breadcrum to hom
            $scope.go_to_home();
            // $scope.editingMeta = false;
            // $scope.editTitleDesc = false;
            
            pluginBlockUI.stop();
            
        });        
    }

    $scope.get_recent_files = function(){
        $scope.activeNav = 'recentfiles';
        //$scope.activeView = 'loading';
        pluginBlockUI.start({message: nm_filemanager_vars.messages.files_loading});
        
        
        $http.get(nm_filemanager_vars.ajaxurl +'?action=nm_filemanager_get_user_files&sortby=date&order=DESC').success(function(data){

            $scope.activeFilesScope = data.all;
            $scope.allFiles = data.all;
            $scope.activeView = 'list_thumb';
            $scope.breadCrumb = [];
            $scope.editingMeta = false;
            $scope.editTitleDesc = false;
            
            pluginBlockUI.stop();

        });
    }
    
    
    /**
     * loading file for selected group
     * also setting file_term_id hidden valu
     * @since 11.0
     **/
    $scope.load_group_files= function() {
        
        pluginBlockUI.start({message: nm_filemanager_vars.messages.files_loading});
        $http.get(nm_filemanager_vars.ajaxurl +'?action=nm_filemanager_get_user_files&get_shared_files=yes&group_id='+$scope.selectedGroup).success(function(data){

            $scope.activeFilesScope = data.all;
            $scope.allFiles = data.all;
            $scope.activeView = 'list_thumb';
            $scope.breadCrumb = [];
            $scope.editingMeta = false;
            $scope.editTitleDesc = false;
            
            // now setting file_term_id
            jQuery('#file_term_id').val($scope.selectedGroup);
            pluginBlockUI.stop();

        });
    }

    $scope.get_shared_files = function(group_id){
        $scope.activeNav = 'sharedfiles';
        //$scope.activeView = 'loading';
        pluginBlockUI.start({message: nm_filemanager_vars.messages.files_loading});
        
        $http.get(nm_filemanager_vars.ajaxurl +'?action=nm_filemanager_get_user_files&get_shared_files=yes&group_id='+group_id).success(function(data){

            $scope.activeFilesScope = data.all;
            $scope.allFiles = data.all;
            $scope.activeView = 'list_thumb';
            $scope.breadCrumb = [];
            $scope.editingMeta = false;
            $scope.editTitleDesc = false;
            
            pluginBlockUI.stop();

        });
    }

    $scope.get_shared_by_group_files = function(group_id){
        $scope.activeNav = 'sharedfiles';
        //$scope.activeView = 'loading';
        pluginBlockUI.start({message: nm_filemanager_vars.messages.files_loading});
        $http.get(nm_filemanager_vars.ajaxurl +'?action=nm_filemanager_get_user_files&get_shared_files=yes&group_id='+group_id).success(function(data){

            $scope.activeFilesScope = data.all;
            $scope.allFiles = data.all;
            $scope.activeView = 'list_thumb';
            $scope.breadCrumb = [];
            $scope.editingMeta = false;
            $scope.editTitleDesc = false;
            
            pluginBlockUI.stop();

        });
    }
    
    $scope.get_bpgroup_files = function(group_id){
        $scope.activeNav = 'group-files';
        //$scope.activeView = 'loading';
        pluginBlockUI.start({message: nm_filemanager_vars.messages.files_loading});
        
        $http.get(nm_filemanager_vars.ajaxurl +'?action=nm_filemanager_get_user_files&get_bpgroup_files=yes&bp_group_id='+group_id).success(function(data){

            $scope.activeFilesScope = data.all;
            $scope.allFiles = data.all;
            $scope.activeView = 'list_thumb';
            $scope.breadCrumb = [];
            $scope.editingMeta = false;
            $scope.editTitleDesc = false;
            
            pluginBlockUI.stop();

        });
    }
    
    $scope.create_directory = function(dir_name, group_id, bp_group_id){
        
        // 	$scope.activeView = 'loading';
        
        /**
         * now checking if $scope.selectedGroup is set (NOT ZERO)
         * then use $scope.selectedGroup instead group_id from paramenter
         * 
         * @since 11.0
         **/
        if( $scope.selectedGroup !== '0' ){
            group_id = $scope.selectedGroup;
        }
        
        pluginBlockUI.start({message: nm_filemanager_vars.messages.directory_creating});
    	var data = {
    		action: 'nm_filemanager_create_directory',
    		directory_name: dir_name,
    		parent_id: $scope.current_directory,
    		directory_detail: '',
    		file_term_id: group_id,
    		nm_share_bp_group_id: bp_group_id
    	}
    	
        $http.post(nm_filemanager_vars.ajaxurl, data ).success(function(resp){   
            
            // console.log(resp);
            $timeout(function() { 
              pluginBlockUI.message( nm_filemanager_vars.messages.directory_created ); 
            }, 2000);
            

            $timeout(function() { 
              pluginBlockUI.stop();
            //   $scope.get_my_files();
            }, 3000);
            
            window.location.reload();
            
        });        
    }

    $scope.saveTitleDesc = function(id, title, desc){
    // 	$scope.activeView = 'loading';
    
        pluginBlockUI.start({message: nm_filemanager_vars.messages.file_updating});
    	var data = {
    		action: 'nm_filemanager_edit_file_title_desc',
    		post_id: id,
    		post_title: title,
    		post_content: desc,
    	}
        $http.post(nm_filemanager_vars.ajaxurl, data ).success(function(resp){   
            
            $timeout(function() { 
              pluginBlockUI.message( resp ); 
            }, 2000);
            

            $timeout(function() { 
              pluginBlockUI.stop();
              $scope.get_my_files();
            }, 3000);
            
        });
    }

    $scope.editFileMeta = function(){
    	$scope.activeView = 'loading';
    	var data = {
    		action: 'nm_filemanager_edit_file_meta',
    		postid: $scope.theFile.id,
    		title: $scope.theFile.post_title,
    		filename: $scope.theFile.filename,
    	}
        $http.post(nm_filemanager_vars.ajaxurl, data ).success(function(resp){
        	$scope.editingMeta = true;
            $scope.editMetaHTML = resp;
            $scope.activeView = 'file_details';
        });
    }

    $scope.render_html = function() {
        return $sce.trustAsHtml($scope.editMetaHTML);
    };

    $scope.share_this_file = function(){
        //$scope.activeView = 'loading';
        
        pluginBlockUI.start({message: nm_filemanager_vars.messages.file_sharing});
        var data = {
            action: 'nm_filemanager_send_files_email',
            email_to: $scope.sharefile.email,
            file_names: $scope.theFile.filename,
            subject: $scope.sharefile.subject,
            file_msg: $scope.sharefile.msg,
            amazon_data: $scope.theFile.amazon_data,
        }
        $http.post(nm_filemanager_vars.ajaxurl, data ).success(function(resp){
            $scope.sharefile = {};
            //$scope.activeView = 'file_details';
            
            $timeout(function() { 
              pluginBlockUI.message( resp.message ); 
            }, 2000);
            

            $timeout(function() { 
              pluginBlockUI.stop(); 
            }, 3000); 
            
        });   
    }
    
    /**
     * uplaoding/saving all files
     * 
     * @since 10.5
     */
     $scope.saveAllFiles = function() {
         
        pluginBlockUI.start({message: nm_filemanager_vars.messages.file_uploading});
        var data = jQuery('.new_files_area input, .new_files_area textarea, .new_files_area select').serialize();
        
        
        
    	$http.post(nm_filemanager_vars.ajaxurl, data).success(function(resp) {
    	    //console.log(resp);
    		if(resp.status == 'success'){
    		    jQuery('.new_file_upload').after('<div class="alert alert-success">'+resp.message+'</div>');
    		    jQuery('.new_file_upload').hide();
    		    
    		    $timeout(function() { 
                  pluginBlockUI.message( resp.message ); 
                }, 2000);
                
    
                $timeout(function() { 
                  pluginBlockUI.stop(); 
                //   $scope.get_my_files();
                  window.location.reload();
                }, 3000);
                
    		} else {
    		    alert( nm_filemanager_vars.messages.file_upload_error );
    		}
    	});
     }
    
    
    // deleting file form Amazon
    $scope.deleteAmazonFile = function (amazon_data, file_id){
        
        //console.log( amazon_data );
        var a = confirm(nm_filemanager_vars.messages.file_delete);
        if(a){
            
        //adding support to upload files directly to Amazon
        AWS.config.update({accessKeyId: nm_uploader_settings.amazon_key, 
                            secretAccessKey: nm_uploader_settings.amazon_secret});
        
        //AWS.config.region = nm_uploader_settings.amazon_region;
        var bucket = new AWS.S3({params: {Bucket: nm_uploader_settings.amazon_bucket}});
        var deleteParam = {
            Bucket: amazon_data.bucket,
            Key: amazon_data.key,
        };
        
        pluginBlockUI.start({message: nm_filemanager_vars.messages.file_deleting});
        var data = {
            action: 'nm_filemanager_delete_file',
            pid: file_id,
        }
        $http.post(nm_filemanager_vars.ajaxurl, data ).success(function(resp){
            
            $timeout(function() { 
              pluginBlockUI.message( 'Deleting from Amazon AWS' ); 
            });
            
            bucket.deleteObject(deleteParam, function(err, data) {
                if (err){
                  //console.log(err);  
                } else {
                    //console.log('delete', data);
                    //callback();
                   $timeout(function() { 
                      pluginBlockUI.message( nm_filemanager_vars.messages.file_deleted ); 
                    }, 2000);
                
                    $timeout(function() { 
                      pluginBlockUI.stop(); 
                      $scope.get_my_files();
                    }, 3000); 
                    
                }
            });
            
            
            

            
        });
             
        }
    }

}]);

app.filter('escape', function() {
    return function(uri){
        if (uri != undefined) {
            return uri.replace(/&amp;/g, '&');
        };
    }
});

app.directive('prettyphoto', [function() {
   return {
      restrict: 'A',
      link: function(scope, elem, attrs) {
         jQuery(elem).prettyPhoto({
    		social_tools      : false,
    		theme             : 'pp_woocommerce',
    		horizontal_padding: 20,
    		opacity           : 0.8,
    		deeplinking       : false,
    		callback          : function(){
    		    if(attrs.$attr.deletefile){
    		        scope.refresh_files();
    		    }
    		},
    	 });
      }
   };
}]);

//nmFiles contail all files being added into queue
var nmFiles = [];
var imgTransform;

jQuery(document).ready(function($){
    // console.log(nm_uploader_settings);
    
    // now display template when all DOM is ready
    $(".nm-prefix").show();
    
    FileAPI.event.on(filechooser, 'change', function (evt){
      var files = FileAPI.getFiles(evt); // Retrieve file list
      
        var minWidth = parseInt(nm_uploader_settings.image_min_width);
        var minHeight = parseInt(nm_uploader_settings.image_min_height);
        var maxWidth = parseInt(nm_uploader_settings.image_max_width);
        var maxHeight = parseInt(nm_uploader_settings.image_max_height);
      
      FileAPI.filterFiles(files, function (file, info/**Object*/){
          
        var size_in_bytes = parseInt(nm_uploader_settings.max_file_size) * 1024 * 1024;
        
        if( file.size <= size_in_bytes){
            
            if( /^image/.test(file.type) ){
                if(nm_uploader_settings.image_sizing){
                    if( ! (info.width >= minWidth && info.height >= minHeight) || !(info.width <= maxWidth && info.height <= maxHeight) ){
                        var msg_local = nm_filemanager_vars.messages.file_settings_error +
                        ' Min Height: '+minHeight+' Min Width: '+minWidth+ ' Max Height: '+maxHeight+' Max Width: '+maxWidth;
                        alert(msg_local);
                        return false;
                    }else{
                        console.log(file);
                        return true;
                    }
                }else{
                    return true;
                }
            }
            
        }else{
            var msg_local = nm_filemanager_vars.messages.file_settings_error +
            ' Max Filesize: ' + nm_uploader_settings.max_file_size;
            
            alert(msg_local);
            return false;
        }
        
        
        return true;
      }, function (files/**Array*/, rejected/**Array*/){
        
        //console.log(rejected);
        
        if( files.length && files.length <= nm_uploader_settings.max_files){
            
          show_selected_images_preview(files);
          
          if(nm_uploader_settings.amazon_enabled){
              upload_selected_files_amazon(files)
          }else{
              upload_selected_files(files);
          }
        }else{
            
            alert(nm_uploader_settings.max_files_message);
            return false;
        }
      });
    });
    
    // setting up uploader
    if(nm_uploader_settings.file_drag_drop == '.upload_file_area'){
        var dnd_el = document.getElementById('dnd_upload_file');
        FileAPI.event.dnd(dnd_el, function (over){
            dnd_el.style.backgroundColor = over ? '#f60': '';
        }, function (files){
            if( files.length ){
                show_selected_images_preview(files);
            }
        });
    }
    
    if(nm_uploader_settings.image_resize){
        var resize_params = nm_uploader_settings.image_resize.split(',');
        imgTransform = {
            maxWidth: resize_params[0],
            maxHeight: resize_params[1]
        }
    } else {
        imgTransform = undefined;        
    }
    
    $('.new_file_upload').hide();
    
    
});


/**
 * upload all files to local server
 * 
 * @since 10.5
 */
function upload_selected_files(uploadFiles) {
        
    // Uploading Files
      FileAPI.upload({
        url: nm_filemanager_vars.ajaxurl + '?action=nm_filemanager_upload_file',
        files: {file: uploadFiles},
        fileprogress: function (evt, file){ 
            var class_name = file.name.replace(/[^a-zA-Z0-9]/g, "");
            jQuery('.'+class_name+' .progress').show();
            var percent = parseInt((evt.loaded / evt.total * 100));
            jQuery('.'+class_name+' .progress .progress-bar').css('width', percent+'%');
            jQuery('.'+class_name+' .progress .progress-bar').text(percent+'%');
        },
        complete: function (err, xhr){
            if(err == false){
                
                var response = jQuery.parseJSON(xhr.response);
                // console.log(response);
                if( response.status === 'error' ) {
					alert( response.message );
					window.location.reload();
					
				}
                jQuery('.file_upload_button').hide();
                jQuery('.new_file_upload').show();
                
            } else {
                alert('There is some Error...');
            }                
        },
        imageTransform: imgTransform,
        filecomplete: function (err/**String*/, xhr/**Object*/, file/**Object/, options/**Object*/){
            if( !err ){
              // File successfully uploaded
                //console.log(file);
                var class_name = file.name.replace(/[^a-zA-Z0-9]/g, "");
                jQuery('.'+class_name+' .progress .progress-bar').text('Uploaded!');
                
              
              var result = JSON.parse(xhr.responseText);
            //   console.log(result);
              
              render_html_file_data(xhr.uid, class_name, result.file_name, '', result.file_groups);
            }
          }
      });
}


/**
 * 
 * upload all files to Amazon s3 if enabled
 * 
 * @since 10.5
 */
 function upload_selected_files_amazon(uploadFiles) {
        
        //adding support to upload files directly to Amazon
        AWS.config.update({accessKeyId: nm_uploader_settings.amazon_key, 
                            secretAccessKey: nm_uploader_settings.amazon_secret,
                            region: nm_uploader_settings.amazon_region
        });
        
        // AWS.config.region = nm_uploader_settings.amazon_region;
        // console.log(nm_uploader_settings.amazon_region);
        
        var bucket = new AWS.S3({params: {Bucket: nm_uploader_settings.amazon_bucket}});
        
        jQuery('.file_upload_button').hide();
                    
                    
        jQuery(uploadFiles).each(function(index, file){
           
           //console.log(file); 
        
            var fileKey = file.name;
            if(nm_filemanager_vars.user_name !== ''){
                fileKey = nm_filemanager_vars.user_name+'/'+file.name;
            }
            var acl_permission = nm_uploader_settings.amazon_acl == 'yes' ? 'public-read' : 'private';
            
            var params = {Key: fileKey, ContentType: file.type, Body: file, ACL: acl_permission};
          bucket
            .upload(params)
            .on('httpUploadProgress', function(evt) {
                var class_name = file.name.replace(/[^a-zA-Z0-9]/g, "");
                jQuery('.'+class_name+' .progress').show();
                var percent = parseInt((evt.loaded / evt.total * 100));
                jQuery('.'+class_name+' .progress .progress-bar').css('width', percent+'%');
                jQuery('.'+class_name+' .progress .progress-bar').text(percent+'%');
                
                //console.log("Uploaded :: " + parseInt((evt.loaded * 100) / evt.total)+'%');
            })
            .send(function(err, data) {
                console.log(data);
                var class_name = file.name.replace(/[^a-zA-Z0-9]/g, "");
                jQuery('.'+class_name+' .progress .progress-bar').text(file.name);
                    
            
                render_html_file_data(index, class_name, data.Key, data);
                
                
                jQuery('.new_file_upload').show();
                
                
            });
            
        });
  
    }
/** 
 * Display Images Preview
 */
 function show_selected_images_preview(files){
  FileAPI.each(files, function (file){
      
      var class_name = file.name.replace(/[^a-zA-Z0-9]/g, "");
      //div with 3 column to hold image
      var new_row = jQuery('<div/>', { 
        class: 'row '+class_name
      }).appendTo('#nm_file_list');
      
    if( ! /^image/.test(file.type) ){
        
        var thumb_holder = jQuery('<div/>', { 
                class: 'col-sm-3 text-center'
            }).appendTo(new_row).append(file.name);
            
        //progressbar holder
        var fileprogress_holder = jQuery('<div/>', {
           class: 'progress',
        }).appendTo(thumb_holder)
        .append('<div class="progress-bar"></div>');
        
    }else{
        
        FileAPI.Image(file).preview(nm_uploader_settings.image_size).get(function (err, img){
        
            var thumb_holder = jQuery('<div/>', { 
                class: 'col-sm-3 text-center'
            }).appendTo(new_row).append(img);
            
            //progressbar holder
            var fileprogress_holder = jQuery('<div/>', {
               class: 'progress',
            }).appendTo(thumb_holder)
            .append('<div class="progress-bar"></div>');
            
        });
        
    }
    // console.log(thumb_holder);
   
    // jQuery('.upload_choosed_files').show();
    jQuery('.file_upload_button .btn-success').hide();
    jQuery('.file_upload_button .btn-warning').hide();
  
    nmFiles.push(file);
  });     
 }
 

/** generating html block for file input (title, desc) **/
function render_html_file_data(fileid, class_name, file_name, amazon_data='', file_groups=''){
    //creating HTML of added file
   //div with 9 column to hold file data input title, desc
   var filedata_holder = jQuery('<div/>', {
       class: 'col-sm-9 text-left',
   }).appendTo('.'+class_name);
   
   //title input holder
   var filetitle_holder = jQuery('<div/>', {
       class: 'form-group',
   }).appendTo(filedata_holder)
   .append('<input type="text" name="uploaded_files['+fileid+'][title]" class="form-control" placeholder="Title" value="">');
   
   //hidden input filename
   var filetitle_holder = jQuery('<div/>', {
       class: 'form-group',
   }).appendTo(filedata_holder)
   .append('<input type="hidden" name="uploaded_files['+fileid+'][filename]" class="form-control" value="'+file_name+'">');
   
   //desc input holder
   var filedesc_holder = jQuery('<div/>', {
       class: 'form-group',
   }).appendTo(filedata_holder)
   .append('<textarea placeholder="Description" class="form-control" name="uploaded_files['+fileid+'][file_details]"></textarea>');
   
   // File groups if enabled
   if(nm_uploader_settings.file_group_add == 'yes' && file_groups !== null && file_groups.length > 0 ) {
       
       var file_groups_html = '';
       file_groups_html = '<select class="form-control" name="uploaded_files['+fileid+'][file_group]">';
       file_groups_html += '<option value="0">'+nm_filemanager_vars.messages.select_group+'</option>';
       jQuery.each(file_groups, function(i, group) {
          file_groups_html += '<option value="'+group.slug+'">'+group.name+'</option>';
       });
       file_groups_html += '</select>';
       
       var filegroup_holder = jQuery('<div/>', {
           class: 'form-group',
       }).appendTo(filedata_holder)
       .append(file_groups_html);
   }
    
    if( amazon_data !== ''){
        
    var filetitle_holder = jQuery('<div/>', {
           class: 'form-group',
       }).appendTo(filedata_holder)
       .append('<input type="hidden" name="uploaded_files['+fileid+'][amazon][bucket]" class="form-control" value=\''+amazon_data.Bucket+'\'>')
       .append('<input type="hidden" name="uploaded_files['+fileid+'][amazon][key]" class="form-control" value=\''+amazon_data.Key+'\'>')
       .append('<input type="hidden" name="uploaded_files['+fileid+'][amazon][location]" class="form-control" value=\''+amazon_data.Location+'\'>');
    }
    
}