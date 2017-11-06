<?php
$choice = array(
	"Default"	=> "",
	"Yes" 	=> "yes",
	"No" => "no",
);
$settings_params = array(

	array(
		"type" 			=> "dropdown",
		"heading" 		=> __("Allow user to create directory?", "nm-filemanager"),
		"param_name" 	=> "nm_filemanager_create_dir",
		"description" 	=> __("Want to enable user to create directories?", "nm-filemanager"),
		"group" 		=> 'Frontend Settings',
		"value" 		=> $choice
	),
	array(
		"type" 			=> "dropdown",
		"heading" 		=> __("Allow public file upload? ", "nm-filemanager"),
		"param_name" 	=> "nm_filemanager_allow_public",
		"description" 	=> __("Want to allow public (non logged in users) to upload files?", "nm-filemanager"),
		"group" 		=> 'Frontend Settings',
		"value"         => $choice,
	),
	array(
		"type" 			=> "dropdown",
		"heading" 		=> __("Allow Send File? ", "nm-filemanager"),
		"param_name" 	=> "nm_filemanager_send_file",
		"description" 	=> __("Allow user to send file to other people via email link?", "nm-filemanager"),
		"group" 		=> 'Frontend Settings',
		"value"         => $choice,
	),
	array(
		"type" 			=> "dropdown",
		"heading" 		=> __("Filter by Groups? ", "nm-filemanager"),
		"param_name" 	=> "nm_filemanager_file_groups",
		"description" 	=> __("Enable files filtering based on groups?", "nm-filemanager"),
		"group" 		=> 'Frontend Settings',
		"value"         => $choice,
	),
	array(
		"type" 			=> "dropdown",
		"heading" 		=> __("Allow to Choose Group? ", "nm-filemanager"),
		"param_name" 	=> "nm_filemanager_file_groups_add",
		"description" 	=> __("Allow user to select group after file upload?", "nm-filemanager"),
		"group" 		=> 'Frontend Settings',
		"value"         => $choice,
	),
	array(
		"type" 			=> "dropdown",
		"heading" 		=> __("Hide LogOut Button? ", "nm-filemanager"),
		"param_name" 	=> "nm_filemanager_hide_logout_button",
		"description" 	=> __("Hide logout button on frontend", "nm-filemanager"),
		"group" 		=> 'Frontend Settings',
		"value"         => $choice,
	),
	
	/* Titles/Lables*/
	
	array(
		"type" 			=> "textfield", 
		"heading" 		=> __("Select File Button Title"),
		"param_name" 	=> "nm_filemanager_button_title",
		"description" 	=> __("Title for button used for selecting file to upload.", "nm-filemanager"),
		"group" 		=> 'Titles / Lables',
	),
	array(
		"type" 			=> "textfield", 
		"heading" 		=> __("Upload/Save File title"),
		"param_name" 	=> "nm_filemanager_upload_title",
		"description" 	=> __("Button text when files ready to save.", "nm-filemanager"),
		"group" 		=> 'Titles / Lables',
	),
);

?>