<?php
/**
 * The class_exists() check is recommended, to prevent problems during upgrade
 * or when the Groups component is disabled
 */

if ( class_exists( 'BP_Group_Extension' ) ) :



class NM_BP_Group_Fileuploader extends BP_Group_Extension {
	/**
	 * Your __construct() method will contain configuration options for
	 * your extension, and will pass them to parent::init()
	 */
	function __construct() {
		$args = array(
				'slug' => 'files',
				'name' => 'Files',
		);
		parent::init( $args );
	}

	/**
	 * display() contains the markup that will be displayed on the main
	 * plugin tab
	 */
	function display($group_id = NULL) {
		
		echo do_shortcode('[nm-wp-file-uploader]');
	}

	/**
	 * settings_screen() is the catch-all method for displaying the content
	 * of the edit, create, and Dashboard admin panels
	 */
	function settings_screen( $group_id = NULL ) {
		$nm_bp_file_sharing = groups_get_groupmeta( $group_id, 'nm_bp_file_sharing' );

		echo '<p>';
		_e('File Sharing Option', 'nm-filemanager');
		echo '<br>';
		echo '<label for="nm_bp_file_sharing_group">Group:';
		echo '<input '.checked( 'group', $nm_bp_file_sharing, false).' type="radio" value="group" name="nm_bp_file_sharing" id="nm_bp_file_sharing_group"></label>';
		echo '<em>'.__('Files uploaded by users will be shared in current Group', 'nm-filemanager').'</em><br>';
		echo '<label for="nm_bp_file_sharing_private">Private:';
		echo '<input '.checked( 'private', $nm_bp_file_sharing, false).' type="radio" value="private" name="nm_bp_file_sharing" id="nm_bp_file_sharing_private"></label>';
		echo '<em>'.__('Files uploaded by users will NOT be shared with anyone.', 'nm-filemanager').'</em><br>';
		
		
    }
 
    /**
     * settings_sceren_save() contains the catch-all logic for saving 
     * settings from the edit, create, and Dashboard admin panels
     */
    function settings_screen_save( $group_id = NULL ) {
        $setting = '';
 
        if ( isset( $_POST['nm_bp_file_sharing'] ) ) {
            $nm_bp_file_sharing = $_POST['nm_bp_file_sharing'];
        }
 
        groups_update_groupmeta( $group_id, 'nm_bp_file_sharing', $nm_bp_file_sharing );
    }
}
bp_register_group_extension( 'NM_BP_Group_Fileuploader' );
 
endif; // if ( class_exists( 'BP_Group_Extension' ) )