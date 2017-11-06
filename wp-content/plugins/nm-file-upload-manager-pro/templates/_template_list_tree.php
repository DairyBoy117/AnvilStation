<?php
/*
 * it is loading all files uploaded by user
 */

global $nmfilemanager, $wpdb;


/** migrating old files if any **/
//$nmfilemanager -> migrate_files();

/** getting the parameters for delete file **/
if(isset($_GET['pid']) && isset($_GET['do']) == 'delete')
{
	$nmfilemanager -> delete_file();
}

$login_user_id = get_current_user_id();
$allow_public = $nmfilemanager -> get_option('_allow_public');
if ($login_user_id == 0 && $allow_public[0] == 'yes')
	$login_user_id = $nmfilemanager -> get_option('_public_user');

//$range = 2;
//$showitems = ($range * 2)+1;  
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>

<h2><?php _e('Files and Directories', 'nm-filemanager'); ?></h2>
	<p>
		<a href="<?php echo add_query_arg('view', NULL); ?>"><i class="fa fa-arrow-left" style="float:left;">Back to File Manager</i> </a>
		<div style="float: right; margin-bottom: 10px;">
			<span id="matches"></span>			
			<label><b>Filter:</b></label>
			<input name="search" placeholder="Filter..." autocomplete="off">
			<button id="btnResetSearch" style="width: 20px;padding: 3px;height: 20px;">×</button>
		</div>
	</p>
		<div style="clear: both;"></div>

<?php
/*** in case of addon enable ***/

if($nmfilemanager -> group_id == 0){
	$args = array(
			'orderby'          => 'post_title',
			'order'            => 'ASC',
			'post_type'        => 'nm-userfiles',
			'post_status'      => 'publish',
			'nopaging'		   => true,
			'author'           => $login_user_id,
			'post_parent' 	=> 0
	);
} else {
	$args = array(
			'orderby'          => 'post_title',
			'order'            => 'ASC',
			'post_type'        => 'nm-userfiles',
			'post_status'      => 'publish',
			'nopaging'		   => true,
			'post_parent' 	=> 0,
			'tax_query' => array(
				array(
					'taxonomy' => 'file_groups',
					'field'    => 'id',
					'terms'    => explode(',', $nmfilemanager -> group_id),
					'operator' => 'IN',
				),
			),
	);
}

/*
if($nmfilemanager -> admin_group_id !== 0){
	$args = array(
			'orderby'          => 'post_title',
			'order'            => 'ASC',
			'post_type'        => 'nm-userfiles',
			'post_status'      => 'publish',
			'nopaging'		   => true,
			'post_parent' 	=> 0,
			'tax_query' => array(
				array(
					'taxonomy' => 'admin_file_groups',
					'field'    => 'id',
					'terms'    => explode(',', $nmfilemanager -> admin_group_id),
					'operator' => 'IN',
				),
			),
	);
}
*/

if ( class_exists ( 'NM_WP_FileManager_Addon' ) && $nmfilemanager -> group_id == 0 ) {
	$param_delete_shared = array( 'files'	=> 'shared');
	$url_share_file = add_query_arg($param_delete_shared);
		
	// echo '<a href="'. remove_query_arg( 'files' ) .'">'.__('My Files', 'nm-filemanager').'</a> &nbsp;';
	// printf( __('<a href="%s">Shared files</a>', 'nm-filemanager'), esc_url($url_share_file) );

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
		$shared_users = get_post_meta($post->ID, 'shared_with', true);
		$arr_users = explode(',', $shared_users);
		if( in_array( $login_user_id, $arr_users ) || in_array( 0, $arr_users ) ){
			$temparr[] = get_post( $post->ID );
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

	<?php
		
		$node_init = 1;
		$treeData = array();

		while ( $post_files -> have_posts() ) : 
		  		$post_files -> the_post();
			
		global $post;

		$files = render_the_rows($node_init, $post, $login_user_id);
		
		$treeData[] = $files;

	endwhile;

	// $folderData = json_encode($treeData);
	?>

<div id="folderview"></div>

<?php
function render_the_rows($node, $post, $login_user_id, $tt_parent_id = 0, $parent_id = 0){
	
		global $nmfilemanager, $node_init;
		
		$authorid = $post -> post_author;
		
        $param_delete = array('pid'	=> $post->ID,
						'do'	=> 'delete');

		$filename = $nmfilemanager -> get_attachment_file_name( $post->ID );
		
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
		
		$row_parent = ($tt_parent_id != 0) ? 'data-tt-parent-id="'.$tt_parent_id.'"' : '';
		$post_parent = ($parent_id != 0) ? 'data-post-parent="'.$parent_id.'"' : '';
		
		$node_type = ($filename != '' ? 'file' : 'dir');
		
		//filemanager_pa($my_children);
		$file_path_dir = $nmfilemanager -> get_author_file_dir_path($authorid) . basename( $filename );
		if( file_exists( $file_path_dir ))
			$file_size = size_format( filesize( $file_path_dir ));
		else
			$file_size = '--';
	

	// settingup tree data

	if (($node_type == 'file')) {
		
		$node_init += 1;
		return array('title' => $post->post_title ,'key' => $node_init);
		
	} else {
		
		$node_init += 1;
		$file_arr = array('title' => $post->post_title ,'key' => $node_init, 'folder' => 'true');
		$my_children = get_my_children($post -> ID);
		if($my_children){
			$child_arr = array();
			$child_node = $node_init;
			foreach ($my_children as $child) {
				//$child_arr = array('title' => $child->post_title ,'key' => $child_node);
				//$child_node = $node + 1;
				//$child_node++;
				//$node_init += 1;
				$sub_files = render_the_rows($node_init, $child, $login_user_id);
				
				if( count($sub_files['children']) > 0){
					$child_node = $child_node + count($sub_files['children']);
				}
				$child_arr[] = $sub_files;
				
				//echo 'rendering '.$child -> ID;
				//render_the_rows($node, $child, $login_user_id, $node, $post->ID);
			}
			
			$file_arr['children'] = $child_arr;
		}
		
		return $file_arr;
	}
	



	?>
      <tr id="file-list-row-<?php echo $post->ID;?>" class="<?php echo $node_type;?>" data-post-id="<?php echo $post->ID;?>" data-tt-id="<?php echo $node;?>" <?php echo $row_parent;?> <?php echo $post_parent;?>>
	    <td>
		<?php  
			// echo '<div id="file-list-row-'.$post->ID.'" class="file-list-container">';
	  //   	echo '<div id="file-thumb-'.$post->ID.'" class="nm-file-thumb">';
	  		$nmfilemanager -> get_file_title_tree( $post, $authorid, $file_size );
	  //       echo '</div>';

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
				 //echo '<span class="rendering-file-title">'. $post -> post_date .'</span>'; 
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
				
			}
			
			if ( $login_user_id == $authorid ) {

				if($filename)
					
					echo '<a title="'.__('Edit file meta', 'nm-filemanager').'" href="javascript:;" onclick="edit_file_meta('. $post->ID.')"><i class="fa fa-pencil fonticons"></i></a>';
					echo '<a title="'.__('Delete file', 'nm-filemanager').'" href="javascript:;" onclick="confirmFirstDelete('."'".$urlDelete."'".')"><i class="fa fa-remove fonticons"></i></a>';
			}
 ?>
		</td>
	  </tr>

<?php

	
	if($my_children){
		$node2 = 1;
		foreach ($my_children as $child) {
			$tree_node = $node.'-'.$node2;
			//echo 'rendering '.$child -> ID;
			render_the_rows($node, $child, $login_user_id, $node, $post->ID);
			$node2++;
		}
		
	}
	//filemanager_pa($my_children);
}

function get_my_children($post_id){

	$args = array(
			'orderby'          => 'post_title',
			'order'            =>  'ASC',
			'post_type'        => 'nm-userfiles',
			'post_status'      => 'publish',
			'nopaging'		   => true,
			'post_parent' 		=> $post_id,
	);

	$children = get_posts($args);
	
	return $children;
	
}

?>
               

<script type="text/javascript"><!--

jQuery(document).ready(function($){
	var folderData = <?php echo json_encode($treeData) ?>;
	$('#folderview').fancytree({
  		source: folderData,
  		extensions: ["filter"],
      	quicksearch: true,
      	filter: {
	        autoApply: true,  // Re-apply last filter if lazy data is loaded
	        counter: true,  // Show a badge with number of matching child nodes near parent icons
	        fuzzy: false,  // Match single characters in order, e.g. 'fb' will match 'FooBar'
	        hideExpandedCounter: true,  // Hide counter badge, when parent is expanded
	        highlight: true,  // Highlight matches by wrapping inside <mark> tags
	        mode: "dimm"  // Grayout unmatched nodes (pass "hide" to remove unmatched node instead)
      	},
	});
	var tree = $("#folderview").fancytree("getTree");

	$("input[name=search]").keyup(function(e) {
	    var n,
	        opts = {
	            autoExpand: true,
	            leavesOnly: false
	        },
	        match = $(this).val();

	    if (e && e.which === $.ui.keyCode.ESCAPE || $.trim(match) === "") {
	        $("button#btnResetSearch").click();
	        return;
	    }
	    if (1) {
	        // Pass function to perform match
	        n = tree.filterNodes(function(node) {
	            return new RegExp(match, "i").test(node.title);
	        }, opts);
	    } else {
	        // Pass a string to perform case insensitive matching
	        n = tree.filterNodes(match, opts);
	    }
	    $("button#btnResetSearch").attr("disabled", false);
	    $("span#matches").text("(" + n + " matches)");
	}).focus();	

    $("button#btnResetSearch").click(function(e){
		$("input[name=search]").val("");
		$("span#matches").text("");
		tree.clearFilter();
    }).attr("disabled", true);	
});
//-->
</script>

<?php
/**
 * adding thickbox support for image larg view
 */
 add_thickbox();