<?php
/*
 * it is loading all files uploaded by user
 */


global $nmfilemanager, $wpdb;

/** getting the parameters for delete file **/
if(isset($_GET['pid']) && isset($_GET['do']) == 'delete')
{
	$nmfilemanager -> delete_file();
}

$login_user_id = get_current_user_id();
$allow_public = $nmfilemanager -> get_option('_allow_public');
if ($login_user_id == 0 && $allow_public[0] == 'yes')
	$login_user_id = $nmfilemanager -> get_option('_public_user');

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

?>
<div class="pop-view"></div>
 

	<script src="<?php echo $nmfilemanager->plugin_meta['url']?>/js/ui/bpopup.js"></script>
	<link rel="stylesheet" href="<?php echo $nmfilemanager->plugin_meta['url']?>/js/ui/css/popup-style.css">
	
<div id="ajax-loader" style="display: none;"></div>
<h2><?php _e('Files and Directories', 'nm-filemanager'); ?></h2>
<?php $treeview = $nmfilemanager -> get_option('_enable_tree'); ?>
<?php render_the_breadcrumb($treeview); ?>

<?php
$args = array(
		'orderby'		=> 'post_title',
		'order'         => 'ASC',
		'post_type'   	=> 'nm-userfiles',
		'post_status'   => 'publish',
		'nopaging'		=> true,
		'author'        => $login_user_id,
		'post_parent' 	=> $nmfilemanager -> parent_id,
);


$param_delete_shared = array( 'files'	=> 'shared');
$urlSharedFiles = add_query_arg($param_delete_shared);

echo '<a href="'. remove_query_arg( 'files' ) .'">'.__('My Files', 'nm-filemanager').'</a> &nbsp;';
printf( __('<a href="%s">Group Files</a>', 'nm-filemanager'), esc_url($urlSharedFiles) );

if ( isset( $_GET['files'] ) && isset( $_GET['files'] ) == 'shared' ) {

	$meta_args = array(
			'orderby'		=> 'post_title',
			'order'         => 'ASC',
			'post_type'   	=> 'nm-userfiles',
			'post_status'   => 'publish',
			'nopaging'		=> true,
			'post_parent' 	=> $nmfilemanager -> parent_id,
			'meta_query' 	=> array( array('key' => 'nm_share_bp_group_id',
											'value'   => bp_get_group_id(),
											'compare' => '=')
									)
	);

	$post_files = new WP_Query($meta_args);
} else {
	$post_files = new WP_Query($args);	
}	

?>

<table id="user-files" class="display">
<thead>
	<tr>
        <th>
        	<strong><?php _e('Thumb', 'nm-filemanager')?></strong>
        </th>
        <th>
        	<strong><?php _e('File Title', 'nm-filemanager')?></strong>
        </th>
        <th>
        	<strong><?php _e('File Size', 'nm-filemanager')?></strong>
        </th>
        <th>
        	<strong><?php _e('Uploaded on', 'nm-filemanager')?></strong>
        </th>
        <th>
        	<strong><?php _e('File Tools', 'nm-filemanager')?></strong>
        </th>
        <th>
        	<strong><?php _e('Download Stats', 'nm-filemanager')?></strong>
        </th>
    </tr>
</thead>
<tbody>

<?php

	while ( $post_files -> have_posts() ) :
	  		$post_files -> the_post();

		global $post;

		$amazon_data = get_post_meta($post->ID, 'amazon_data', true);
		if($amazon_data == '')	//it's checking that amazon file being uploaded by new version v10
			render_the_row($post, $login_user_id);
	endwhile;
	?>

 </tbody>
</table>

<?php

function render_the_row($post, $login_user_id){

		global $nmfilemanager;
		$authorid = $post -> post_author;

        $param_delete = array('pid'	=> $post->ID,
						'do'	=> 'delete');

		$filename =  $nmfilemanager -> get_attachment_file_name( $post->ID );
		
		$file_saved_location = get_post_meta($post->ID, 'file_location', true);
					
		$do = 'download';
		if($file_saved_location == 'amazon'){
			$do = 'download_amazon';
		}
					
        $param_download = array('file_name'		=> $filename,
		 						'do'			=> $do,
								'file_owner'	=> $authorid,
								'postid'		=> $post->ID);

		$urlDelete = add_query_arg($param_delete);
		$urlPrivateDownload = add_query_arg($param_download);
		$urlPrivateDownload = wp_nonce_url($urlPrivateDownload, 'securing_file_download', 'nm_file_nonce');

		$meta = get_post_meta($post->ID, '_wp_attachment_metadata', true);
		$file_meta = json_decode($meta, true);

		$file_path_dir = $nmfilemanager -> get_author_file_dir_path($authorid) . basename( $filename );
		
		$file_size = '';
		if( file_exists( $file_path_dir ))
			$file_size = size_format( filesize( $file_path_dir ));

		//$file_size = '--?--';
	?>
      <tr id="file-list-row-<?php echo $post->ID;?>">
	    <td>
			<?php  echo '<div id="file-list-row-'.$post->ID.'" class="file-list-container">';
    	echo '<div id="file-thumb-'.$post->ID.'" class="nm-file-thumb">';
    		$nmfilemanager -> set_file_download( $post->ID, $authorid, $file_size );
        echo '</div>';
		 ?>

		</td>

		<td>
        	<?php
				echo '<span class="rendering-file-title">'. the_title() .'</span>';
				if ( $login_user_id != $authorid ) {
					echo "<br /><i>" . __('Shared by ', 'nm-filemanager'). "</i>"; the_author();
				}
				if($nmfilemanager -> group_id !== 0){
					$terms = wp_get_post_terms( $post->ID, 'file_groups',  array("fields" => "names") );
					echo "<br /><i>" . __('File categoris: ', 'nm-filemanager'). "</i>"; 
					echo implode(',', $terms);
				}
				if( $nmfilemanager -> get_option('_ftp_notification') == "yes" && get_post_meta($post->ID, 'nm_ftp_uploaded', true) == "yes" ){
					echo "<br /><i>" . $nmfilemanager -> get_option('_ftp_text'). "</i>"; 
				}
			?>

        </td>

        <td>
        	<?php echo $file_size; ?>

        </td>

        <td>
        	<?php
				$display_time = $nmfilemanager -> get_option('_display_time');
				echo '<span class="rendering-file-title">';
				if ($display_time == "yes")
					echo the_time('F j, Y g:i a');
				else
					echo get_the_date();
				echo '</span>';
			?>
        </td>
    	<td>
			<?php

             /*
             * rendering file tootls, edit, sharing, delete etc
             */

			if($filename){

				echo '<a title="'.__('Download file', 'nm-filemanager').'" href="'.$urlPrivateDownload.'"><i class="fa fa-download fonticons"></i></a>';
				echo '<a title="'.__('Share file', 'nm-filemanager').'" href="javascript:;" onclick="share_file(\''.$nmfilemanager -> get_attachment_file_name( $post->ID ).'\', '.$authorid.')"><i class="fa fa-envelope fonticons"></i></a>';

			}else{

				$open_dir = add_query_arg(array('parent_id' => $post->ID, 'files' => null, 'shareable' => 'yes'));
				echo '<a title="'.__('Open directory', 'nm-filemanager').'" href="'.$open_dir.'"><i class="fa fa-folder-open fonticons"></i></a>';
			}

			if ( $login_user_id == $authorid ) {

				if($filename){
					echo '<a title="'.__('Edit file meta', 'nm-filemanager').'" href="javascript:;" onclick="edit_file_meta('. $post->ID.')"><i class="fa fa-pencil fonticons"></i></a>';
					echo'<a class="open-popup" title="view details" href="#" id="'. $post->ID.'"><i class="fa fa-info-circle fonticons"></i></a>';					
				}

				echo '<a title="'.__('Delete file', 'nm-filemanager').'" href="javascript:;" onclick="confirmFirstDelete('."'".$urlDelete."'".')"><i class="fa fa-remove fonticons"></i></a>';

				if ( class_exists ( 'NM_WP_FileManager_Addon' ) && current_user_can( 'manage_options' ) ) {
			
					$nmfilemanager_addon = new NM_WP_FileManager_Addon();
					$nmfilemanager_addon -> render_file_share_users( $post->ID );

				}
			}


 ?>				

		</td>
        <td>
        	<?php 
			
			echo get_post_meta($post->ID, 'nm_log_file_download', true) == '' ? __('No Data', 'nm-filemanager') : get_post_meta($post->ID, 'nm_log_file_download', true);
			
			?>
        </td>
	  </tr>


<?php
}	//render_the_row

function render_the_breadcrumb($enabletree){

	$dir_id = (isset($_REQUEST['parent_id']) ? $_REQUEST['parent_id'] : 0);
	$treeviewbtn = '';
	if ($enabletree == 'yes') {
		$treeviewbtn = '<a title="Tree View" href="'.add_query_arg('view', 'tree').'"><i class="fa fa-list"></i></a>';
	}
	$parents = get_post_ancestors($dir_id);
	//reverse the order
	$parents = array_reverse($parents);
	$breadcrumbs = '';
	if($parents){
		$treeviewbtn = '';
		$root_url = add_query_arg(array('parent_id' => null));
		$root_url = remove_query_arg( array('files', 'shareable'), $root_url);
		$breadcrumbs .= '<a href="'.$root_url.'"><i class="fa fa-home"></i></a> &raquo; ';
		foreach($parents as $parend_id){

			$dir_url = add_query_arg(array('parent_id' => $parend_id));
			$parent = get_page( $parend_id );
			$breadcrumbs .= '<a href="'.$dir_url.'">'.$parent -> post_title.'</a> &raquo; ';
		}
		$breadcrumbs .=  get_the_title( $dir_id );
	}elseif($dir_id > 0){ //the root directory inside
		$root_url = add_query_arg(array('parent_id' => null, 'shareable' => null));
		$breadcrumbs .= '<a href="'.$root_url.'"><i class="fa fa-home"></i></a> &raquo; ' . get_the_title( $dir_id );
		$treeviewbtn = '';
	}

	$breadcrumbs = rtrim($breadcrumbs, "&raquo; ");
	echo '<div class="filemanager-breadcrumbs"><span style="float: left;">'.$breadcrumbs.'</span><span style="float: right;">'.$treeviewbtn;
}
?>

<script type="text/javascript"><!--

jQuery(document).ready(function($){
	
	    $('.open-popup').on('click', function(event) {
	    	event.preventDefault();
	    	jQuery('#ajax-loader').show();
	    	var data = {
	    		action: 'nm_filemanager_get_popup_contents',
	    		id: jQuery(this).attr('id'),
	    	}

	       $.post(nm_filemanager_vars.ajaxurl, data, function(resp) {

	       		$('.pop-view').html(resp);
	       		
	    		jQuery('#ajax-loader').hide();
	            $('.pop-view').bPopup({

	    			 modalClose: true,
					 opacity: 0.6,
					 positionStyle: 'fixed' //'fixed' or 'absolute'
					 
					  
	            	
	        	});
	       	
	       });
	       
	    });
	    
	    
	    setTimeout(function() {
	    	$('.users-to-share-file').dataTable();
	    	$('#user-files').dataTable();
	    }, 300);
		

} );
//-->
</script>

<?php
/**
 * adding thickbox support for image larg view
 */
 add_thickbox();