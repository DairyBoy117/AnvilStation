<?php

$meatGeneral = array('thumb-size'	=> array(	'label'		=> __('Images thumb size', 'nm-filemanager'),
					 							'desc'		=> __('Enter integer value for thumb size for images', 'nm-filemanager'),
					 							'id'			=> 'nm_filemanager'.'_thumb_size',
					 							'type'			=> 'text',
					 							'default'		=> '75',
					 							'help'			=> __('type size in px like: <strong>100</strong>', 'nm-filemanager')
					 							),
					'button-title'	=> array(	'label'		=> __('Select File title', 'nm-filemanager'),
					 							'desc'		=> __('Enter text for uploader button', 'nm-filemanager'),
					 							'id'			=> 'nm_filemanager'.'_button_title',
					 							'type'			=> 'text',
					 							'default'		=> 'Select',
					 							'help'			=> 'Display on file select button'
					 							),
					 'upload-title'	=> array(	'label'		=> __('Upload/Save File title', 'nm-filemanager'),
					 							'desc'		=> __('Enter text for uploader button', 'nm-filemanager'),
					 							'id'			=> 'nm_filemanager'.'_upload_title',
					 							'type'			=> 'text',
					 							'default'		=> 'Upload',
					 							'help'			=> 'Dispaly button text when files ready to save'
					 							),
					'max-file_size'	=> array(	'label'		=> __('Maximum file size in MB', 'nm-filemanager'),
					 							'desc'		=> __('Enter maximum file size in mb', 'nm-filemanager'),
					 							'id'			=> 'nm_filemanager'.'_max_file_size',
					 							'type'			=> 'text',
					 							'default'		=> '',
					 							'help'			=> __('e.g: <strong>3mb</strong>', 'nm-filemanager')
					 							),
					'max-files'		=> array(	'label'		=> __('Max numbers of files (Max 5 allowed in free version)', 'nm-filemanager'),
					 							'desc'		=> __('Enter no for max files to upload at once', 'nm-filemanager'),
					 							'id'			=> 'nm_filemanager'.'_max_files',
					 							'type'			=> 'text',
					 							'default'		=> '',
					 							'help'			=> __('e.g: <strong>3</strong>', 'nm-filemanager')
					 							),
					 'max-files-users'		=> array(	'label'		=> __('Max numbers of files each User', 'nm-filemanager'),
					 							'desc'		=> __('', 'nm-filemanager'),
					 							'id'			=> 'nm_filemanager'.'_max_files_user',
					 							'type'			=> 'text',
					 							'default'		=> '',
					 							'help'			=> __('Enter no for Max. files that each user can upload. Leave blank for unlimited', 'nm-filemanager')
					 							),
					'file-types'	=> array(	'label'		=> __('File Format/Type', 'nm-filemanager'),
					 							'desc'		=> __('Enter type of files to upload', 'nm-filemanager'),
					 							'id'			=> 'nm_filemanager'.'_file_format',
					 							'type'			=> 'select',
					 							'options' => array(
					 								'image/*'=> 'Image',
					 								'video/*'=> 'Video',
					 								'audio/*'=> 'Audio',
					 								'text/*'=> 'Text',
					 								'application'=> 'Application',
					 								'custom'=> 'Custom',
				 								),
					 							'default'		=> '',
					 							'help'			=> __('Select quick format for file. If custom, please specify below', 'nm-filemanager')
					 							),
					'custom-file-types'	=> array(	'label'		=> __('Custom types', 'nm-filemanager'),
					 							'desc'		=> __('Enter type of files to upload', 'nm-filemanager'),
					 							'id'			=> 'nm_filemanager'.'_file_types',
					 							'type'			=> 'text',
					 							'default'		=> '',
					 							'help'			=> __('e.g: <strong>jpg,png,gif,zip,pdf</strong> (it will work if above is set to custom)', 'nm-filemanager')
					 							),
					'share-files'	=> array(	'label'		=> __('Allow File Sharing', 'nm-filemanager'),
					 							'desc'		=> __('It will allow users to share files with other users.', 'nm-filemanager'),
					 							'id'			=> 'nm_filemanager'.'_file_sharing',
					 							'type'			=> 'checkbox',
					 							'options'	=> array('yes'	=> 'Yes'),
					 							'default'		=> '',
					 							'help'			=> __('It will allow users to share files with other users. NOTE: You must need to purchase and install <a target="_blank" href="https://www.2checkout.com/checkout/purchase?sid=1686663&quantity=1&product_id=14">User Specific Addon</a>', 'nm-filemanager')
					 							),
					'allow-drag-drop'	=> array(	'label'		=> __('Allow Drag Drop', 'nm-filemanager'),
					 							'desc'		=> __('Enter type of files to upload', 'nm-filemanager'),
					 							'id'			=> 'nm_filemanager'.'_file_allow_drag_n_drop',
					 							'type'			=> 'checkbox',
					 							'options'	=> array('yes'	=> 'Yes'),
					 							'default'		=> '',
					 							'help'			=> __('It allows to upload files by Drag and Drop', 'nm-filemanager')
					 							),
				
					);
					

$meat_advance_settings = array('min-files'	=> array(  'label'		=> __('Min. files allowed to upload', 'nm-filemanager'),
												   'desc'		=> __('Enter min. files in numbers. Leave blank for disable this.', 'nm-filemanager'),
				  		   						   'id'			=> 'nm_filemanager'.'_min_files',
												   'type'		=> 'text',
												   'default'	=> '',
												   'help'		=> __('like: 2', 'nm-filemanager')
												),
					'default-user-quota'=> array(  'label'		=> __('Default file size quota for user role to upload', 'nm-filemanager'),
												   'desc'		=> __('Provide default file size quota for user role. Leave blank for disable this.', 'nm-filemanager'),
				  		   						   'id'			=> 'nm_filemanager'.'_default_quota',
												   'type'		=> 'textarea',
												   'default'	=> '',
												   'help'		=> __("Write per line: e.g: <strong>author|3mb</strong>", 'nm-filemanager')
												),
						   'admin-email'=> array(  'label'		=> __('Send email to admin?', 'nm-filemanager'),
												   'desc'		=> __('Please check if you want to send email notification to admin.', 'nm-filemanager'),
				  		   						   'id'			=> 'nm_filemanager'.'_admin_email',
												   'type'		=> 'checkbox',
												   'default'	=> '',
												   'options'	=> array('yes'	=> 'Yes'),
												   'help'		=> __('Please check if you want to send email notification to admin.', 'nm-filemanager')
												),	
							'from-email'=> array(  'label'		=> __('From Email', 'nm-filemanager'),
												   'desc'		=> __('Specify an email as to get Notifications and also used as FROM. Recommended is to use Email on current Domain', 'nm-filemanager'),
				  		   						   'id'			=> 'nm_filemanager'.'_from_email',
												   'type'		=> 'text',
												   'default'	=> '',
												   'help'		=> __('Please check if you want to send email notification to admin.', 'nm-filemanager')
												),	
														
						   'public-user'=> array(  'label'	=> __('User ID for public file upload', 'nm-filemanager'),
												   'desc'		=> __('Enter the user id under which public files will be upload.', 'nm-filemanager'),
				  		   						   'id'			=> 'nm_filemanager'.'_public_user',
												   'type'		=> 'text',
												   'default'	=> '',
												   'help'		=> __('Type userID like: <strong>1</strong>', 'nm-filemanager')
												),	
														
						'mail-recipients'=> array( 'label'	=> __('Email recipients for file upload', 'nm-filemanager'),
												   'desc'		=> __('Enter email, separated by comma to receive notifications for file upload.', 'nm-filemanager'),
				  		   						   'id'			=> 'nm_filemanager'.'_mail_recipients',
												   'type'		=> 'text',
												   'default'	=> '',
												   'help'		=> __('Enter email, separated by comma to receive notifications for file upload.', 'nm-filemanager')
												),
						'file-rename'		=> array(	'label'		=> __('File Rename', 'nm-filemanager'),
				 							'desc'		=> __('Rename uploaded file with Timestamp?', 'nm-filemanager'),
				 							'id'			=> 'nm_filemanager'.'_file_rename',
				 							'type'			=> 'select',
				 							'options' => array(
				 								'none'	=> 'No Rename',
				 								'prefix' => 'Yes, prefix Timestamp',
				 								//'postfix'	=> 'Yes, postfix Timestamp'
				 								),
				 							'default'		=> 'none',
				 							'help'			=> __('Select none for defaut settings', 'nm-filemanager')
				 							),

);

$meat_messages = array('file-uploaded'	=> array(	'label'		=> __('File saved message', 'nm-filemanager'),
												'desc'		=> __('Displayed when file is uploaded/saved successfully', 'nm-filemanager'),
												'id'			=> 'nm_filemanager'.'_file_saved',
												'type'			=> 'textarea',
												'default'		=> __('File(s) Uploaded!', 'nm-filemanager'),
												'help'			=> __('Displayed when file is uploaded/saved successfully', 'nm-filemanager')
												),
					'filetype-error'=> array(	'label'		=> __('Error message', 'nm-filemanager'),
												'desc'		=> __('This message will be shown when error occur in uploading file', 'nm-filemanager'),
												'id'			=> 'nm_filemanager'.'_error_msg',
												'type'			=> 'textarea',
												'default'		=> __('Fail to upload!', 'nm-filemanager'),
												'help'			=> __('This message will be shown when error occur in uploading file', 'nm-filemanager')
												),
					'public-message'=> array(  'label'	=> __('Message for Non Logged in users', 'nm-filemanager'),
											   'desc'		=> __('This message will be displayed if user is not logged. If not provided user will be redirected to default login page.', 'nm-filemanager'),
			  		   						   'id'			=> 'nm_filemanager'.'_public_message',
											   'type'		=> 'textarea',
											   'default'	=> '',
											   'help'		=> __('This message will be displayed if user is not logged. If not provided user will be redirected to default login page.', 'nm-filemanager')
												),		
					'role-message'	=> array(  'label'	=> __('Message for users who do not belongs to authorized role.', 'nm-filemanager'),
											   'desc'		=> __('This message will be displayed if user is logged in, but he do not belongs to authorized role.', 'nm-filemanager'),
			  		   						   'id'			=> 'nm_filemanager'.'_role_message',
											   'type'		=> 'textarea',
											   'default'	=> '',
											   'help'		=> __('This message will be displayed if user is logged in, but he do not belongs to authorized role.', 'nm-filemanager')
												),		
												
);


$meat_amazon = array('enable-amazon'=> array( 'label'	=> __('Upload files to Amazon Bucket?', 'nm-filemanager'),
												   'help'		=> __('Enable Amazon Addon', 'nm-filemanager'),
				  		   						   'id'			=> 'nm_filemanager'.'_enable_amazon',
												   'type'		=> 'checkbox',
												   'default'	=> '',
												   'options'	=> array('yes'	=> 'Yes'),
												   'desc'		=> __('', 'nm-filemanager')
												),		
														
						   'amazon-key'=> array(  'label'	=> __('API Key', 'nm-filemanager'),
												   'help'		=> __('Amazon API Key', 'nm-filemanager'),
				  		   						   'id'			=> 'nm_filemanager'.'_amazon_apikey',
												   'type'		=> 'text',
												   'default'	=> '',
												   'desc'		=> __('', 'nm-filemanager')
												),	
														
						'amazon-secret'=> array(  'label'	=> __('API Secret', 'nm-filemanager'),
												   'help'		=> __('Amazon API Secret', 'nm-filemanager'),
				  		   						   'id'			=> 'nm_filemanager'.'_amazon_apisecret',
												   'type'		=> 'text',
												   'default'	=> '',
												   'desc'		=> __('', 'nm-filemanager')
												),
												
						'amazon-bucket'=> array(  'label'	=> __('Bucket Name', 'nm-filemanager'),
												   'help'		=> __('You must create BUCKET in Amazon s3 service, otherwise files will not be saved to Amazon.', 'nm-filemanager'),
				  		   						   'id'			=> 'nm_filemanager'.'_amazon_bucket',
												   'type'		=> 'text',
												   'default'	=> '',
												   'desc'		=> __('Type userID like: <strong>1</strong>', 'nm-filemanager')
												),
						'amazon-expires'=> array(  'label'	=> __('URL Expiration', 'nm-filemanager'),
												   'help'		=> __('Set URL Expiration time in minutes, default is 1 minute, otherwise files will not be saved to Amazon. In minutes, e.g 3 minutes will be: <strong>3</strong>', 'nm-filemanager'),
				  		   						   'id'			=> 'nm_filemanager'.'_amazon_expires',
												   'type'		=> 'text',
												   'default'	=> '',
												   'desc'		=> __('In minutes, e.g 3 minutes will be: <strong>3</strong>', 'nm-filemanager')
												),
												
						'amazon-region'=> array(  'label'	=> __('Region Name', 'nm-filemanager'),
												   'help'		=> __('Enter region name, see list <a href="http://docs.aws.amazon.com/general/latest/gr/rande.html">Here</a>', 'nm-filemanager'),
				  		   						   'id'			=> 'nm_filemanager'.'_amazon_region',
												   'type'		=> 'text',
												   'default'	=> '',
												   'desc'		=> __('In minutes, e.g 3 minutes will be: <strong>3</strong>', 'nm-filemanager')
												),
												
						array( 'label'	=> __('Persmission: Public?', 'nm-filemanager'),
												   'help'		=> __('With public permission everyone can download file with URL. Uncheck for Private', 'nm-filemanager'),
				  		   						   'id'			=> 'nm_filemanager'.'_acl_public',
												   'type'		=> 'checkbox',
												   'default'	=> '',
												   'options'	=> array('yes'	=> 'Yes'),
												   'desc'		=> __('', 'nm-filemanager')
												),
					);

$meat_user_files = array('file-meta'	=> array(	
				 		 'desc'		=> '',
						 'type'		=> 'file',
						 'id'		=> 'user-files.php',
												 ),
						 );

$meat_file_meta = array('file-meta'	=> array(	
									'desc'		=> '',
									'type'		=> 'file',
									'id'		=> 'file-meta.php',
									),
								);

$meat_ftp = array(
			 'ftp-notification'=> array( 'label'	=> __('Notify user in files list about ftp uploaded file?', 'nm-filemanager'),
										 'desc'		=> __('Please check if you want to notify user in files list about ftp uploaded files.', 'nm-filemanager'),
										 'id'			=> 'nm_filemanager'.'_ftp_notification',
										 'type'		=> 'checkbox',
										 'default'	=> '',
										 'options'	=> array('yes'	=> 'Yes'),
										 'help'		=> __('Please check if you want to notify user in files list about ftp uploaded files..', 'nm-filemanager')
									  ),		
					'ftp-text'=> array( 'label'	=> __('Notification text', 'nm-filemanager'),
						  				'help'		=> __('Write notification text for user.', 'nm-filemanager'),
									   'id'			=> 'nm_filemanager'.'_ftp_text',
									   'type'		=> 'text',
									   'default'	=> '',
									   'desc'		=> __('Write notification text for user.', 'nm-filemanager')
									),
				'file-meta'	=> array( 'desc'	=> '',
									  'type'	=> 'file',
									  'id'		=> 'ftp-files.php',
									),									
				  );

$meat_google_drive = array('enable-google-drive'=> array( 'label'	=> __('Upload files from Google Drive?', 'nm-filemanager'),
												   'help'		=> __('Enable Google Drive', 'nm-filemanager'),
				  		   						   'id'			=> 'nm_filemanager'.'_enable_google_drive',
												   'type'		=> 'checkbox',
												   'default'	=> '',
												   'options'	=> array('yes'	=> 'Yes'),
												   'desc'		=> __('Enable Google Drive in upload area!', 'nm-filemanager')
												),		
														
						   'developer-key'=> array(  'label'	=> __('Google Drive API Key', 'nm-filemanager'),
												   'help'		=> __('Developer Key', 'nm-filemanager'),
				  		   						   'id'			=> 'nm_filemanager'.'_google_apikey',
												   'type'		=> 'text',
												   'default'	=> '',
												   'desc'		=> __('', 'nm-filemanager')
												),	
														
						'google-clientid'=> array(  'label'	=> __('Client ID', 'nm-filemanager'),
												   'help'		=> __('Google client ID', 'nm-filemanager'),
				  		   						   'id'			=> 'nm_filemanager'.'_google_clientid',
												   'type'		=> 'text',
												   'default'	=> '',
												   'desc'		=> __('', 'nm-filemanager')
												),
					);

$meat_image_options = array(
			 		'image-sizing'=> array( 'label'	=> __('Enable Image Sizing', 'nm-filemanager'),
										 'desc'		=> __('', 'nm-filemanager'),
										 'id'			=> 'nm_filemanager'.'_enable_image_sizing',
										 'type'		=> 'checkbox',
										 'options' => array('yes' => 'Enable'),
										 'default'	=> '',
										 'help'		=> __('It will enable following parameters for images', 'nm-filemanager')
									  ),
			 		'image-min-width'=> array( 'label'	=> __('Image Minimum Width', 'nm-filemanager'),
										 'desc'		=> __('', 'nm-filemanager'),
										 'id'			=> 'nm_filemanager'.'_image_min_width',
										 'type'		=> 'text',
										 'default'	=> '',
										 'help'		=> __('Image minimum width in pixels, default 320', 'nm-filemanager')
									  ),
			 		'image-min-height'=> array( 'label'	=> __('Image Minimum Height', 'nm-filemanager'),
										 'desc'		=> __('', 'nm-filemanager'),
										 'id'			=> 'nm_filemanager'.'_image_min_height',
										 'type'		=> 'text',
										 'default'	=> '',
										 'help'		=> __('Image minimum height in pixels, default 240', 'nm-filemanager')
									  ),
			 		'image-max-width'=> array( 'label'	=> __('Image Maximum Width', 'nm-filemanager'),
										 'desc'		=> __('', 'nm-filemanager'),
										 'id'			=> 'nm_filemanager'.'_image_max_width',
										 'type'		=> 'text',
										 'default'	=> '',
										 'help'		=> __('Image maximum width in pixels, default 3840', 'nm-filemanager')
									  ),
			 		'image-max-height'=> array( 'label'	=> __('Image Maximum Height', 'nm-filemanager'),
										 'desc'		=> __('', 'nm-filemanager'),
										 'id'			=> 'nm_filemanager'.'_image_max_height',
										 'type'		=> 'text',
										 'default'	=> '',
										 'help'		=> __('Image maximum height in pixels, default 2160', 'nm-filemanager')
									  ),
			 		'resize-dimensions'=> array( 'label'	=> __('Resize / Transform', 'nm-filemanager'),
										 'desc'		=> __('', 'nm-filemanager'),
										 'id'			=> 'nm_filemanager'.'_resize_transform',
										 'type'		=> 'text',
										 'default'	=> '',
										 'help'		=> __('maxWidth,maxHeight for auto transform large images, eg <strong>320,240</strong>. Leave blank to disable transform', 'nm-filemanager')
									  ),
			 		
				  );
								
$meat_howto = array('how-to'	=> array(	
									'desc'		=> '',
									'type'		=> 'file',
									'id'		=> 'howtouse.php',
									),
								);
								
$meat_frontend = array(

												
						   /*'upload-area'=> array(  'label'		=> __('Hide upload section?', 'nm-filemanager'),
												   'desc'		=> __('Please check if you want to hide upload section.', 'nm-filemanager'),
				  		   						   'id'			=> 'nm_filemanager'.'_upload_area',
												   'type'		=> 'checkbox',
												   'default'	=> '',
												   'options'	=> array('yes'	=> 'Hide'),
												   'help'		=> __('Please check if you want to hide upload section.', 'nm-filemanager')
												),
						   'download-area'=> array(  'label'	=> __('Hide file list section?', 'nm-filemanager'),
												   'desc'		=> __('Please check if you want to hide uploaded file section.', 'nm-filemanager'),
				  		   						   'id'			=> 'nm_filemanager'.'_download_area',
												   'type'		=> 'checkbox',
												   'default'	=> '',
												   'options'	=> array('yes'	=> 'Hide'),
												   'help'		=> __('Please check if you want to hide uploaded file section.', 'nm-filemanager')
												),*/												
						   'allow-public'=> array(  'label'	=> __('Allow public file upload?', 'nm-filemanager'),
												   'desc'		=> __('Please check if you want to allow public (non logged in users) to upload files.', 'nm-filemanager'),
				  		   						   'id'			=> 'nm_filemanager'.'_allow_public',
												   'type'		=> 'checkbox',
												   'default'	=> '',
												   'options'	=> array('yes'	=> 'Yes'),
												   'help'		=> __('Please check if you want to allow public (non logged in users) to upload files.', 'nm-filemanager')
												),
																								
						   'create-dir'=> array(  'label'	=> __('Allow user to create directory?', 'nm-filemanager'),
												   'desc'		=> __('Please check if you want to enable create directories tab in uploader area.', 'nm-filemanager'),
				  		   						   'id'			=> 'nm_filemanager'.'_create_dir',
												   'type'		=> 'checkbox',
												   'default'	=> '',
												   'options'	=> array('yes'	=> 'Yes'),
												   'help'		=> __('Please check if you want to enable create directories tab in uploader area.', 'nm-filemanager')
												),		

						   					
				 		'send-file'=> array(  'label'	=> __('Allow Send File', 'nm-filemanager'),
											   'desc'		=> __('Allow users to Send File in email', 'nm-filemanager'),
			  		   						   'id'			=> 'nm_filemanager'.'_send_file',
											   'type'		=> 'checkbox',
											   'default'	=> '',
											   'help'		=> __('This will allow users to send/share via Link in Email.', 'nm-filemanager'),
											   'options'	=> array('yes'	=> 'Yes')
											), 
						'file-groups'=> array(  'label'	=> __('Filter by Groups?', 'nm-filemanager'),
											   'desc'		=> __('This will show Group Filter on Frontend.', 'nm-filemanager'),
			  		   						   'id'			=> 'nm_filemanager'.'_file_groups',
											   'type'		=> 'checkbox',
											   'default'	=> '',
											   'help'		=> __('This will show Groups to users on front end.', 'nm-filemanager'),
											   'options'	=> array('yes'	=> 'Yes')
											),
						'file-groups-add'=> array(  'label'	=> __('Allow to Choose Group?', 'nm-filemanager'),
											   'desc'		=> __('This will allow user to select Group after File Upload.', 'nm-filemanager'),
			  		   						   'id'			=> 'nm_filemanager'.'_file_groups_add',
											   'type'		=> 'checkbox',
											   'default'	=> '',
											   'help'		=> __('This will allow user to select Group after File Upload.', 'nm-filemanager'),
											   'options'	=> array('yes'	=> 'Yes')
											), 
						'hide-logout-button'=> array(  'label'	=> __('Hide LogOut Button?', 'nm-filemanager'),
											   'desc'		=> __('This will hide logout button on frontend.', 'nm-filemanager'),
			  		   						   'id'			=> 'nm_filemanager'.'_hide_logout_button',
											   'type'		=> 'checkbox',
											   'default'	=> '',
											   'help'		=> __('This will hide logout button on frontend.', 'nm-filemanager'),
											   'options'	=> array('yes'	=> 'Yes')
											), 

					);


$this -> the_options = array(
					'general-settings'	=> array(	'name'		=> __('Basic Settings', 'nm-filemanager'),
													'type'	=> 'tab',
													'desc'	=> __('Set options as per your need', 'nm-filemanager'),
													'meat'	=> $meatGeneral,
										  
					),
					'advance-settings'	=> array(	'name'		=> __('Advanced Settings', 'nm-filemanager'),
												'type'	=> 'tab',
												'desc'	=> __('More features in pro version is added below', 'nm-filemanager'),
												'meat'	=> $meat_advance_settings,
												'class'	=> 'pro',
								
					),
					'front-end'	=> array(	'name'		=> __('Frontend Settings', 'nm-filemanager'),
											'type'	=> 'tab',
											'desc'	=> __('File manager front-end settings', 'nm-filemanager'),
											'meat'	=> $meat_frontend,
											'class'	=> 'pro',
								
					),
					'Messages'	=> array(	'name'		=> __('Messages', 'nm-filemanager'),
											'type'	=> 'tab',
											'desc'	=> __('All user messages regarding file manager', 'nm-filemanager'),
											'meat'	=> $meat_messages,
											'class'	=> 'pro',
								
					),
					'Image-Options'	=> array(	'name'		=> __('Image Options', 'nm-filemanager'),
											'type'	=> 'tab',
											'desc'	=> __('Following options will work when beta version is enabled', 'nm-filemanager'),
											'meat'	=> $meat_image_options,
											'class'	=> 'pro',
								
					),
					/*'user-files'=> array(	'name'		=> __('User Files', 'nm-filemanager'),
											'type'	=> 'tab',
											'desc'	=> __('Following table lising all users with their files. Click on each username to see all of his files.', 'nm-filemanager'),
											'meat'	=> $meat_user_files,
											'class'	=> 'pro',
					
					),*/
					'file-meta'	=> array(	'name'		=> __('File Meta', 'nm-filemanager'),
											'type'	=> 'tab',
											'desc'	=> __('More field can be attached to File uploader', 'nm-filemanager'),
											'meat'	=> $meat_file_meta,
											'class'	=> 'pro',
					
					),
					'ftp'	=> array(	'name'		=> __('FTP upload', 'nm-filemanager'),
											'type'	=> 'tab',
											'desc'	=> __('Post files to users accounts uploaded through FTP', 'nm-filemanager'),
											'meat'	=> $meat_ftp,
											'class'	=> '',
					
					),
					/*'google-drive'	=> array(	'name'		=> __('Google Drive', 'nm-filemanager'),
											'type'	=> 'tab',
											'desc'	=> __('Upload files from Google Drive!', 'nm-filemanager'),
											'meat'	=> $meat_google_drive,
											'class'	=> '',
					
					),*/
					'howto'	=> array(	'name'		=> __('How to use?', 'nm-filemanager'),
											'type'	=> 'tab',
											'desc'	=> __('Following guide is provided to use this plugin', 'nm-filemanager'),
											'meat'	=> $meat_howto,
											'class'	=> '',
					
					),

					);
					
if ( class_exists ( 'NM_Amazon_S3_Addon' ) ) {

		$this -> the_options['amazon-addon'] = array(	'name'		=> __('Amazon S3', 'nm-filemanager'),
											'type'	=> 'tab',
											'desc'	=> __('<a href="http://najeebmedia.com/n-media-file-uploader-add-on-for-amazon-s3/">See here how to use this Addon</a>', 'nm-filemanager'),
											'meat'	=> $meat_amazon,
											'class'	=> 'pro',
					
					);
}

if ( class_exists ( 'NM_Google_Addon' ) ) {

		$this -> the_options['google-drive'] = array(	'name'		=> __('Google Drive', 'nm-filemanager'),
											'type'	=> 'tab',
											'desc'	=> __('Upload files from Google Drive!', 'nm-filemanager'),
											'meat'	=> $meat_google_drive,
											'class'	=> 'pro',
					
					);
}

//print_r($repo_options);