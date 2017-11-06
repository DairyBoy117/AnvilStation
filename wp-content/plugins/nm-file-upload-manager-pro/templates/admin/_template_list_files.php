<link rel="stylesheet" type="text/css" href="<?php echo $this->plugin_meta ['url'].'/js/dataTables-1.10.10/jquery.dataTables.css'?>">
<script type="text/javascript" charset="utf8" src="<?php echo $this->plugin_meta ['url'].'/js/dataTables-1.10.10/jquery.dataTables.js'?>"></script>

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


$user_info = get_user_by('id', $_REQUEST['uid']);

//$range = 2;
//$showitems = ($range * 2)+1;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$parent_id = (isset($_REQUEST['parent_id']) ? $_REQUEST['parent_id'] : 0);

?>

<h3><?php printf(__('Files and Directories by %s', 'nm-filemanager'), $user_info -> display_name); ?></h3>

<?php render_the_breadcrumb(); ?>

<?php
/*** in case of addon enable ***/

if($nmfilemanager -> group_id == 0){
	$args = array(
			'orderby'		=> 'post_title',
			'order'         => 'ASC',
			'post_type'   	=> 'nm-userfiles',
			'post_status'   => 'publish',
			'nopaging'		=> true,
			'author'        => $_GET['uid'],
			'post_parent' 	=> $parent_id,
	);
} else {
	$args = array(
			'orderby'		=> 'post_title',
			'order'         => 'ASC',
			'post_type'   	=> 'nm-userfiles',
			'post_status'   => 'publish',
			'nopaging'		=> true,
			'post_parent' 	=> $parent_id,
			'tax_query' => array(
				array(
					'taxonomy' => 'file_groups',
					'field'    => 'id',
					'terms'    => explode(',', $nmfilemanager -> group_id),
					'operator' => 'IN',
				),
			),
	);
	
	//$args = array_merge($args, $term_arr);
}

if ( class_exists ( 'NM_WP_FileManager_Addon' ) && $nmfilemanager -> group_id == 0 ) {
	$param_delete_shared = array( 'files'	=> 'shared');
	$urlSharedFiles = add_query_arg($param_delete_shared);

	//echo '<a href="'. remove_query_arg( 'files' ) .'">'.__('My Files', 'nm-filemanager').'</a> &nbsp;';
	//printf( __('<a href="%s">Shared Files</a>', 'nm-filemanager'), esc_url($urlSharedFiles) );

	if ( isset( $_GET['files'] ) && isset( $_GET['files'] ) == 'shared' ) {

		$meta_args = array(	'orderby'          => 'post_title',
				'post_type'        => 'nm-userfiles',
				'post_status'      => 'publish',
				'nopaging'		   => true,
				'meta_query' 	   => array( array('key' => 'shared_with',))
		);

		$post_files = new WP_Query();
		$my_meta_query = new WP_Query($meta_args);
		$temparr = array();
		while ($my_meta_query->have_posts() ) :
		$my_meta_query->the_post();
		$shared_users = get_post_meta(get_the_ID(), 'shared_with', true);
		$arr_users = explode(',', $shared_users);
		if( in_array( $login_user_id, $arr_users ) || in_array( 0, $arr_users ) ){
			$temparr[] = get_post( get_the_ID() );
		}
		endwhile;
		$post_files -> posts = $temparr;
		$post_files -> post_count = count( $post_files -> posts );
	} else {
		$post_files = new WP_Query($args);
	}
} else {
	$post_files = new WP_Query($args);
}
/*** in case of addon enable ENDs ***/
?>

<table id="user-files-table" class="display">
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
					
        $param_download = array('file_name'	=> $filename,
		 						  'do'			=> $do,
								  'file_owner'	=> $authorid);

		$urlDelete = add_query_arg($param_delete);
		$urlPrivateDownload = add_query_arg($param_download);
		$urlPrivateDownload = wp_nonce_url($urlPrivateDownload, 'securing_file_download', 'nm_file_nonce');

		$meta = get_post_meta($post->ID, '_wp_attachment_metadata', true);
		$file_meta = json_decode($meta, true);

		$file_size = '--';
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
			?>

        </td>

        <td>
        	<?php echo $file_size;?>

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

				echo '<a title="'.__('Download file', 'nm-filemanager').'" href="'.$urlPrivateDownload.'"><span class="dashicons dashicons-download"></span></a>';
				//echo '<a title="'.__('Share file', 'nm-filemanager').'" href="javascript:;" onclick="share_file(\''.$nmfilemanager -> get_attachment_file_name( $post->ID ).'\', '.$authorid.')"><span class="dashicons dashicons-email-alt"></span></a>';

			}else{

				$open_dir = add_query_arg(array('parent_id' => $post->ID));
				echo '<a title="'.__('Open directory', 'nm-filemanager').'" href="'.$open_dir.'"><i class="fa fa-folder-open fonticons"></i></a>';
			}

			//if ( $login_user_id == $authorid ) {

				if($filename)

				echo '<a title="'.__('Edit file meta', 'nm-filemanager').'" href="javascript:;" onclick="edit_file_meta('. $post->ID.')"><i class="fa fa-pencil fonticons"></i></a>';
				echo '<a title="'.__('Delete file', 'nm-filemanager').'" href="javascript:;" onclick="confirmFirstDelete('."'".$urlDelete."'".')"><span class="dashicons dashicons-trash"></span></a>';
				if ( class_exists ( 'NM_WP_FileManager_Addon' ) && current_user_can( 'manage_options' ) ) {
			
					$nmfilemanager_addon = new NM_WP_FileManager_Addon();
					$nmfilemanager_addon -> render_file_share_users( $post->ID );

				}
			//}
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

function render_the_breadcrumb(){

	$dir_id = (isset($_REQUEST['parent_id']) ? $_REQUEST['parent_id'] : 0);

	$parents = get_post_ancestors($dir_id);
	//reverse the order
	$parents = array_reverse($parents);
	$breadcrumbs = '';
	if($parents){
		$root_url = add_query_arg(array('parent_id' => null));
		$breadcrumbs .= '<a href="'.$root_url.'"><i class="fa fa-home"></i></a> &raquo; ';
		foreach($parents as $parend_id){

			$dir_url = add_query_arg(array('parent_id' => $parend_id));
			$parent = get_page( $parend_id );
			$breadcrumbs .= '<a href="'.$dir_url.'">'.$parent -> post_title.'</a> &raquo; ';
		}
	}elseif($dir_id > 0){ //the root directory inside
		$root_url = add_query_arg(array('parent_id' => null));
		$breadcrumbs .= '<a href="'.$root_url.'"><i class="fa fa-home"></i></a> &raquo; ';
	}

	$breadcrumbs = rtrim($breadcrumbs, "&raquo; ");
	echo '<p class="filemanager-breadcrumbs">'.$breadcrumbs.'</p>';
}
?>

<script type="text/javascript"><!--

jQuery(document).ready(function($){
	$('#user-files-table').dataTable();
} );
//-->
</script>

<?php
/**
 * adding thickbox support for image larg view
 */
 add_thickbox();