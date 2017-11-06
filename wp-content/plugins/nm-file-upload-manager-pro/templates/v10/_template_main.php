<?php
/**
 * 
 * File Manager Main Template
 * 
 * @package Plugin
 */
 $allow_create_dir = $this -> get_option('_create_dir');
 
 $bg_group_id = 0;
 if( function_exists('bp_get_group_id') && bp_get_group_id() != NULL ) {
 	$bg_group_id = bp_get_group_id();
 }
 $group_terms = get_terms( array(
    'taxonomy' => 'file_groups',
    'hide_empty' => false,
) );

 ?>
<div ng-app="fileUploaderApp" class="nm-prefix" style="display:none">
	
	<div id="popup" class="popup" style="display: none;">
		<div class="popup__body"><div class="js-img"></div></div>
		<div style="margin: 0 0 5px; text-align: center;">
			<div class="js-upload btn btn_browse btn_browse_small"><?php _e( 'Upload', 'nm-filemanager' ); ?></div>
		</div>
	</div>
	
	<div ng-controller="MainCtrl" block-ui="filemanager-blockUI" ng-init="maxUserFiles=<?php echo nm_files_allower_per_user();?>">

	    <div class="navbar navbar-default">
	    	<div class="container-fluid">
		        <form class="navbar-form navbar-right hidden-xs" role="search">
		        	
		        	<?php if( nm_can_user_filter_file() == 'yes'){?>
		        	<select class="form-control" ng-model="selectedGroup" id="nm-groups" ng-change="load_group_files()">
						<option value="0"><?php _e('Select Group', 'nm-filemanager')?></option>
						<?php 
							foreach($group_terms as $term){
								echo '<option value="'.$term->term_id.'">'.$term->name.'</option>';
							}
						?>
					</select>
					<?php } ?>
					
		        	<input ng-hide="activeView == 'file_details'" ng-model="search.post_title" type="text" class="form-control" placeholder="<?php _e( 'Search Files', 'nm-filemanager' ); ?>" name="srch-term">
		        	<?php if(nm_can_user_hide_logout_button() == 'no' || nm_can_user_hide_logout_button() == '' ){?>
			        	<a href="<?php echo wp_logout_url(); ?>" title="<?php _e( 'Log Out', 'nm-filemanager' ); ?>" class="btn btn-danger"><span class="glyphicon glyphicon-log-out"></span></a>
			        <?php } ?>
			        
			        
		        </form>
				<ul class="nav navbar-nav navbar-left">
					<li ng-class="{active: activeNav == 'myfiles'}"><a ng-click="get_my_files();"> <span class="glyphicon glyphicon-folder-close"></span> <?php _e( 'My Files', 'nm-filemanager' ); ?></a></li>
					<li ng-class="{active: activeNav == 'recentfiles'}"><a ng-click="get_recent_files();"> <span class="glyphicon glyphicon-time"></span> <?php _e( 'Recent', 'nm-filemanager' ); ?></a></li>
					<li ng-class="{active: activeNav == 'sharedfiles'}"><a ng-click="get_shared_files(<?php echo $this->group_id;?>);"> <span class="glyphicon glyphicon-folder-open"></span> <?php _e( 'Shared with me', 'nm-filemanager' ); ?></a></li>
				
					
					<?php
					//filemanager_pa($group_terms[0]);
					//echo $group_terms[0]->name;
					/**
					 * addding new tab if files are being viewed in bp groups
					 * @since 10.9.4
					 */
					 if( $this -> is_bp_group_page() ) {
					 	
				 	?>
			  			<li ng-class="{active: activeNav == 'group-files'}"><a ng-click="get_bpgroup_files('<?php echo bp_get_group_id();?>');"> <span class="glyphicon glyphicon-folder-open"></span> <?php _e( 'Group Files', 'nm-filemanager' ); ?></a></li>
			  		<?php
					 }
					 ?>
					
				</ul>
			</div>
	    </div>
	    <!-- Main Body Container Starts -->
	    <div class="nm-wrap" id="dnd_upload_file">
			<ol class="breadcrumb pull-left" ng-hide="activeView == 'list_thumb'">
				<li><a ng-click="go_to_home();" ><?php _e('Home', 'nm-filemanager');?></a></li>
				<li ng-repeat="bc in breadCrumb" ng-class="{'active':$last}">
					<a ng-if="!$last" ng-click="breadcrumb_nav($index, bc.fileIndex);">{{bc.fileTitle}}</a>
					<span ng-if="$last">{{bc.fileTitle}}</span>
				</li>
			</ol>

			<div class="toolbar pull-right">
				<div class="btn-group pull-right" ng-hide="activeView == 'file_details'">
					<button type="button" ng-click="filesListStyle = 'details'" class="btn btn-default" ng-class="{'active':filesListStyle == 'details'}"><i class="fa fa-list"></i></button>
					<button type="button" ng-click="filesListStyle = 'thumbs'" class="btn btn-default" ng-class="{'active':filesListStyle == 'thumbs'}"><i class="fa fa-th"></i></button>
				</div>

				<div class="form-inline pull-right hidden-sm hidden-xs" style="margin-left:10px;" ng-hide="activeView == 'file_details'">
					<select class="form-control" ng-model="sortBy">
						<option value="" disabled><?php _e( 'Sort By', 'nm-filemanager' ); ?></option>
						<option value="post_title"><?php _e( 'Name', 'nm-filemanager' ); ?></option>
						<option value="extension"><?php _e( 'Type', 'nm-filemanager' ); ?></option>
					</select>
					<div class="radio">
						<label>
							<input ng-model="filesOrder" type="radio" name="sortorder" checked value="">
							<?php _e( 'Ascending', 'nm-filemanager' ); ?>
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="sortorder" ng-model="filesOrder" value="DESC">
							<?php _e( 'Descending', 'nm-filemanager' ); ?> &nbsp;
						</label>
					</div>
				</div>

			</div>

			<!-- Breadcrumbs Area Ends -->
			<div class="clearfix"></div>
			
			<!-- Loading Screen -->

			<div class="thumbnail" ng-show="activeView == 'loading'" style="min-height: 200px; background-repeat: no-repeat; background-position: center center;background-image: url(<?php echo $this->plugin_meta['url'].'/templates/v10/images/ajax-loader.gif'; ?>);"></div>

			<!-- Upload Area -->
			<div class="row new_files_area" ng-hide="activeFilesScope.length >= maxUserFiles">
				
				<!-- it will contain all file data input generated by JS -->
				<div id="nm_file_list">
				
				</div>
				
				
				<div class="col-sm-12 text-center text-primary file_upload_button">
					
					<div class="btn btn-success" ng-hide="creating_dir == 'true'">
						<span><?php echo (nm_select_file_button_title() != '') ? nm_select_file_button_title() : 'Choose files'; ?></span>
						<?php
							$file_format = ($this->get_option('_file_format') == 'custom') ? $this->get_option('_file_types') : $this->get_option('_file_format');
						?>
						<input type="file" id="filechooser" multiple accept="<?php echo $file_format; ?>" />
						
					</div>
					
					
					<div class="text-center upload_choosed_files" style="display:none;">
						<?php if($this->get_option('_enable_amazon') == 'yes'){?>
							<button class="btn btn-primary upload_all_amazon"><?php echo ($this->get_option(_button_title) != '') ? $this->get_option(_button_title) : 'Choose files'; ?></button>
						<?php
						}else{
						?>
							<button class="btn btn-primary upload_all_files"><?php echo ($this->get_option(_button_title) != '') ? $this->get_option(_button_title) : 'Choose files'; ?></button>
						<?php
						}
						?>
					</div>
					
					<?php if ( nm_can_user_create_directory() == 'yes' ){ ?>
						<button class="btn btn-warning" ng-click="creating_dir = 'true'" ng-hide="creating_dir == 'true'"><?php _e('Create Directory', 'nm-filemanager'); ?></button>
					<?php } ?>
			
			
					<a href="{{ajaxurl}}?ajax=true&action=nm_filemanager_delete_file&pid={{current_directory}}"  
								deletefile prettyphoto 
								ng-hide="!current_directory || creating_dir=='true'"
								class="btn btn-danger"><?php _e( 'Delete Current Dir', 'nm-filemanager' ); ?>
					</a>
					
					<?php if ( nm_can_user_create_directory() == 'yes' ){ ?>
						<div class="form-inline">
							<div ng-show="creating_dir == 'true'" class="form-group">
								<label for="dirname"><?php _e('Directory Name', 'nm-filemanager');?></label>
								<input type="text" ng-model="new_dir_name" class="form-control" id="dirname">
								<button class="btn btn-success" ng-click="create_directory(new_dir_name,<?php echo $this->group_id;?>, <?php echo $bg_group_id;?>);" ng-disabled="!new_dir_name"><?php _e('Create', 'nm-filemanager'); ?></button>
								<button class="btn btn-danger" ng-click="creating_dir = 'false'"><?php _e('Cancel', 'nm-filemanager'); ?></button>
							</div>
						</div>	
					<?php } ?>
				</div>
				
				
				
				<div class="col-sm-12">
					
					<div class="new_file_upload thumbnail text-center">
					   <button class="btn btn-primary btn-lg save_all_files" ng-click="saveAllFiles()"><?php echo apply_filters('nmfile_upload_file_text', __('Upload', 'nm-filemanager')); ?></button>
					   
					  <?php
					  /**
					   * form nonce 
					   * */
					   wp_nonce_field('saving_file','nm_filemanager_nonce');
					   ?>
						<input type="hidden" name="action" value="nm_filemanager_save_file_data_ng">
						<input type="hidden" name="parent_id" value="{{current_directory}}">
						<input name="file_term_id" id="file_term_id" type="hidden" value="<?php echo $this->group_id;?>" /> 
						<input name="nm_share_bp_group_id" type="hidden" value="<?php echo $bg_group_id;?>" />
					</div>
				</div>
			</div>
			

			<!-- Files Listing Area -->
			
			<div ng-show="activeView == 'list_thumb'">

				<div class="row" ng-show="filesListStyle == 'thumbs'">		
					<div ui-draggable="true" drag="fileData" ui-on-Drop="onDrop($event,$data,fileData)" on-drop-success="dropSuccessHandler($event, $index, fileData)" class="col-md-2 col-sm-4 col-xs-6" ng-repeat="(file_indx, fileData) in activeFilesScope | filter:search | orderBy:sortBy:filesOrder">
						<div class="thumb">
							
							<a ng-if="fileData.node_type == 'dir'" class="thumbnail" ng-click="display_dir(fileData, file_indx);">
								<img ng-src="{{folder_icon}}" alt="folder icon">
							</a>
							
							<a ng-if="fileData.node_type == 'file'" class="thumbnail" ng-click="display_file(fileData);">

								<img ng-if="fileData.extension == 'png' || fileData.extension == 'jpg' || fileData.extension == 'jpeg' || fileData.extension == 'gif'" ng-src="{{fileData.thumb_src}}" alt="folder icon">

								<span ng-if="fileData.extension != 'png' && fileData.extension != 'jpg' && fileData.extension != 'jpeg' && fileData.extension != 'gif'" class="file-type-icon" filetype="{{fileData.extension}}">
									<span class="fileCorner"></span>
								</span>
							</a>
						</div>
						<h5 class="text-center" ng-if="fileData.node_type == 'dir'"><b>{{fileData.post_title}}</b></h5>
						<h5 class="text-center" ng-if="fileData.node_type == 'file'">{{fileData.post_title | limitTo:10}}</h5>
					</div>
					<div class="col-md-12" ng-if="activeFilesScope == ''">
						<p class="alert alert-info text-center"><?php _e( 'This directory is empty...', 'nm-filemanager' ); ?></p>
					</div>
				</div>
				
				<!-- Files Listing Area -->
				<div class="row details-view" ng-show="filesListStyle == 'details'">
					<div class="col-sm-12">
						<table class="table table-hover">
							<tr>
								<th><?php _e( 'Name', 'nm-filemanager' ); ?></th>
								<th><?php _e( 'Date', 'nm-filemanager' ); ?></th>
								<th><?php _e( 'Type', 'nm-filemanager' ); ?></th>
								<th><?php _e( 'Size', 'nm-filemanager' ); ?></th>
								
								<?php
								/**
								 * adding Hook: action
								 * since 12.1
								 **/
								 do_action('nm_after_files_list_row_header');
								 ?>
							</tr>
							<tr ng-repeat="(index, fileData) in activeFilesScope | filter:search | orderBy:sortBy:filesOrder">
								<td>
									<a ng-if="fileData.node_type == 'dir'" ng-click="display_dir(fileData, index);">
										<img ng-src="{{folder_icon}}" alt="folder icon" width="32px">
										&nbsp;
										<span class="file-title">{{fileData.post_title}}</span>
									</a>
									
									<a ng-if="fileData.node_type == 'file'" ng-click="display_file(fileData);">

										<img width="32px" ng-if="fileData.extension == 'png' || fileData.extension == 'jpg' || fileData.extension == 'jpeg' || fileData.extension == 'gif'" ng-src="{{fileData.thumb_src}}" alt="folder icon">

										<span ng-if="fileData.extension != 'png' && fileData.extension != 'jpg' && fileData.extension != 'jpeg' && fileData.extension != 'gif'" class="file-type-icon" filetype="{{fileData.extension}}">
											<span class="fileCorner"></span>
										</span>

										<span ng-if="fileData.extension != 'png' && fileData.extension != 'jpg' && fileData.extension != 'jpeg' && fileData.extension != 'gif'" class="gutter"></span>
										&nbsp;
										<span class="file-title">{{fileData.post_title}}</span>
									</a>								
								</td>
								<td>{{fileData.post_date}}</td>
								<td>{{fileData.extension}}</td>
								<td>{{fileData.filesize}}</td>
								
								<?php
								/**
								 * adding Hook: action
								 * since 12.1
								 **/
								 do_action('nm_after_files_list_row_data');
								 ?>
							</tr>
						</table>					

					</div>
				</div>

			</div>


			<!-- Single File Details Area -->


			<div class="row single-file" ng-show="activeView == 'file_details'">
				<div class="col-sm-3">
					<div class="thumbnail" style="min-height: 100px;">
						<a href="{{theFile.download_url | escape }}" prettyphoto ng-if="theFile.extension == 'png' || theFile.extension == 'jpg' || theFile.extension == 'jpeg' || theFile.extension == 'gif'">
							<img ng-src="{{theFile.thumb_src}}" alt="{{theFile.post_title}}">
						</a>
						<span ng-if="theFile.extension != 'png' && theFile.extension != 'jpg' && theFile.extension != 'jpeg' && theFile.extension != 'gif'" class="file-type-icon" filetype="{{theFile.extension}}">
							<span class="fileCorner"></span>
						</span>					
					</div>
					
					<a href="{{theFile.download_url | escape }}" class="btn btn-block btn-success"><?php _e( 'Download', 'nm-filemanager' ); ?></a>
					<?php
					if ( NMFILEMANAGER() -> is_file_shareable() ) { ?>
						<a href="{{ajaxurl}}?ajax=true&action=nm_filemanager_share_file_admin&id={{theFile.id}}" prettyphoto class="btn btn-block btn-info"><?php _e( 'Share File', 'nm-filemanager' ); ?></a>
					<?php } ?>
					<?php
						do_action('nm_after_file_detail_thumnail');
					?>					
					<br>
					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<tr ng-show="theFile.file_location=='local'">
								<td><b><?php _e( 'File Name', 'nm-filemanager' ); ?></b></td>
							</tr>
							<tr ng-show="theFile.file_location=='local'">
								<td>{{theFile.filename}}</td>
							</tr>
							<tr ng-show="theFile.file_location=='amazon'">
								<td><b><?php _e( 'File Key', 'nm-filemanager' ); ?></b></td>
							</tr>
							<tr ng-show="theFile.file_location=='amazon'">
								<td>{{theFile.amazon_data.key}}</td>
							</tr>
							<tr ng-show="theFile.file_location=='amazon'">
								<td><b><?php _e( 'URL Shortcode', 'nm-filemanager' ); ?></b></td>
							</tr>
							<tr ng-show="theFile.file_location=='amazon'">
								<td>[nm-amazon-s3 file_id="{{theFile.id}}"]</td>
							</tr>
							
							<tr ng-show="theFile.file_location=='amazon'">
								<td><b><?php _e( 'Bucket', 'nm-filemanager' ); ?></b></td>
							</tr>
							<tr ng-show="theFile.file_location=='amazon'">
								<td>{{theFile.amazon_data.bucket}}</td>
							</tr>
							
							
							<tr ng-show="theFile.file_location=='local'">
								<td><b><?php _e( 'File Size', 'nm-filemanager' ); ?></b></td>
							</tr>
							<tr ng-show="theFile.file_location=='local'">
								<td>{{theFile.filesize}}</td>
							</tr>
							
							<tr ng-show="theFile.file_location=='local'">
								<td><b><?php _e( 'File ID', 'nm-filemanager' ); ?></b></td>
							</tr>
							<tr ng-show="theFile.file_location=='local'">
								<td>{{theFile.id}}</td>
							</tr>
							
							<tr>
								<td><b><?php _e( 'Post Date', 'nm-filemanager' ); ?></b></td>
							</tr>
							<tr>
								<td>{{theFile.post_date}}</td>
							</tr>
							<tr>
								<td><b><?php _e( 'Post Date (GMT)', 'nm-filemanager' ); ?></b></td>
							</tr>
							<tr>
								<td>{{theFile.post_date_gmt}}</td>
							</tr>
						</table>

					</div>
					<br>
					
					<a ng-show="theFile.file_location=='local'" href="{{ajaxurl}}?ajax=true&action=nm_filemanager_delete_file&pid={{theFile.id}}" deletefile prettyphoto class="btn btn-danger btn-block"><?php _e( 'Delete File', 'nm-filemanager' ); ?></a>
					
					<!-- for amazon -->
					<a ng-show="theFile.file_location=='amazon'" ng-click="deleteAmazonFile(theFile.amazon_data, theFile.id)" class="btn btn-danger btn-block"><?php _e( 'Delete File', 'nm-filemanager' ); ?></a>
				
				</div>
				<div class="col-sm-9" ng-init="editTitleDesc = false; editingMeta = false">
					<h2 ng-show="editTitleDesc == false" style="margin-top: 0;">{{theFile.post_title}}
						<button class="pull-right btn btn-info" ng-click="editTitleDesc = true;newTitle=theFile.post_title;newDesc=theFile.description" ng-show="editTitleDesc == false">
							<?php _e( 'Edit Title and Description', 'nm-filemanager' ); ?>
						</button>
					</h2>
					<p ng-show="editTitleDesc == false">{{theFile.description}}</p>
					
					<h4 ng-show="editTitleDesc == true"><?php _e( 'Title', 'nm-filemanager' ); ?></h4>
					<textarea ng-model="newTitle" ng-show="editTitleDesc == true" class="form-control"></textarea>
					
					<h4 ng-show="editTitleDesc == true"><?php _e( 'Description', 'nm-filemanager' ); ?></h4>
					<textarea ng-model="newDesc" ng-show="editTitleDesc == true" class="form-control"></textarea>
					<br ng-show="editTitleDesc == true">
					
					<button class="btn btn-success" ng-show="editTitleDesc == true" ng-click="saveTitleDesc(theFile.id, newTitle, newDesc);"><?php _e( 'Save Changes', 'nm-filemanager' ); ?></button>
					<button class="btn btn-info" ng-show="editTitleDesc == true" ng-click="editTitleDesc = false"><?php _e( 'Cancel', 'nm-filemanager' ); ?></button>
					<br ng-show="editTitleDesc == true">
					<br ng-show="editTitleDesc == true">

					<div class="panel panel-primary" ng-show="editingMeta == false" ng-if="theFile.file_meta != null">
						<div class="panel-heading">
							<h3 class="panel-title"><?php _e( 'File Meta', 'nm-filemanager' ); ?></h3>
						</div>
						<div class="panel-body">
							<table class="table table-striped">
								<tr>
									<th><?php _e( 'Meta Name', 'nm-filemanager' ); ?></th>
									<th><?php _e( 'Value', 'nm-filemanager' ); ?></th>
								</tr>
								<tr ng-repeat="(key, value) in theFile.file_meta">
									<td>{{key}}</td>
									<td>{{value}}</td>
								</tr>
							</table>
							<button class="pull-right btn btn-info" ng-click="editFileMeta();"><?php _e( 'Edit', 'nm-filemanager' ); ?></button>
						</div>
					</div>
					
					<hr ng-show="editingMeta">
					<div ng-show="editingMeta == true" ng-bind-html="render_html();">
						
					</div>

					<hr>
				
					<?php if(nm_can_user_send_file() == 'yes') { ?>
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title"><?php _e( 'Send File', 'nm-filemanager' ); ?></h3>
						</div>
						<div class="panel-body">
							<form class="form-horizontal" name="shareFileForm" novalidate>
								<div class="form-group">
									<label for="emailaddress" class="col-sm-2 control-label"><?php _e( 'Email', 'nm-filemanager' ); ?></label>
									<div class="col-sm-10">
										<input required type="email" ng-model="sharefile.email" class="form-control" id="emailaddress" placeholder="Email Address">
									</div>
								</div>
								<div class="form-group">
									<label for="sendername" class="col-sm-2 control-label"><?php _e( 'Subject', 'nm-filemanager' ); ?></label>
									<div class="col-sm-10">
										<input required type="text" ng-model="sharefile.subject" class="form-control" id="sendername" placeholder="Email Subject">
									</div>
								</div>
								<div class="form-group">
									<label for="message" class="col-sm-2 control-label"><?php _e( 'Message', 'nm-filemanager' ); ?></label>
									<div class="col-sm-10">
										<textarea name="message" ng-model="sharefile.msg" id="message" class="form-control"></textarea>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button class="btn btn-primary" ng-disabled="shareFileForm.$invalid" ng-click="share_this_file();">Share</button>
									</div>
									
								</div>
							</form>
						</div>
					</div>
					<?php
					}
					?>

				</div>
			</div>			
	    </div>
	    <!-- Main container Ends -->
	</div>
	<!-- Controller Ends -->
</div>