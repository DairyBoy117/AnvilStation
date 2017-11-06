<?php 
/*
 * Listing all users with file stats
 */
global $nmfilemanager;

$total_users = count_users();
$total_users = $total_users['total_users'];
$paged      = (isset($_GET['paged'])) ? $_GET['paged'] : 1;
$number = 20;
$offset     = ($paged - 1) * $number;

$total_pages = intval($total_users / $number) + 1;
$args = array(
  'offset' => $offset,//$paged ? ($paged - 1) * $number : 0,
  'number' => $number,
  'count_total'  => true,
  );
$arrUsers = get_users( $args );
?>
<h2>
	<?php _e("User Files", 'nm-filemanager')?>
</h2>
<div id="filemanager-userfiles" class="wrap">

<?php
if(isset($_GET['uid']) && isset($_GET['uid']) !== ''){
	echo '<a class="button button-primary" href="'. remove_query_arg( 'uid' ) .'#user-files">'.__('&laquo; All Users', 'nm-filemanager').'</a> &nbsp;';
	$nmfilemanager -> load_template( 'admin/_template_list_files.php' );
	
}else{
?>


<div class="user-uploaded-files">
<table width="100%" border="0" id="user-files" class="wp-list-table widefat fixed posts">
<thead>
	<tr>
    	<th style="width: 75px;" align="center" valign="middle">
        <strong><?php _e('Sr No', 'nm-filemanager')?></strong></th>
        <th width="146" align="center" valign="middle">
        <strong><?php _e('User Name', 'nm-filemanager')?></strong></th>
        <th width="203" align="center" valign="middle">
        <strong><?php _e('Files Stats', 'nm-filemanager')?></strong></th>
        <th width="203" align="center" valign="middle">
        <strong><?php _e('User Quota', 'nm-filemanager')?></strong></th>
      </tr>
</thead>


<tbody>
<?php 
$srNo = 1;
foreach($arrUsers as $user):
//filemanager_pa($user->data->display_name);exit();
//print_r(parse_url($_SERVER['HTTP_REFERER']));
?>
  <tr>
   	<td>
		<?php echo $srNo++;?>
    </td>
    <td> 
		<?php
			$param_user_files = array( 'uid'	=> $user->data->ID);
			$urlUserFiles = add_query_arg($param_user_files).'#user-files';
			printf( __('<a href="%s" style="text-align:center;width:100px" class="button">'.$user->data->display_name.'</a>', 'nm-filemanager'), esc_url($urlUserFiles) );
		?>
    </td>
    
    <td>
    <?php echo $nmfilemanager->get_user_files_count($user->data->ID);?>
    </td>

    <td>
    <?php 
		 $nm_file_quota		= $nmfilemanager -> get_user_quota($user->data->ID);
		 $total_used_size 	= get_user_meta( $user->data->ID, '_nm_used_filesize', true );
		 $total_used_size   = (!$total_used_size == '') ? $total_used_size : '0';
		 printf( __('Used %s of %s disk storage space.', 'nm-filemanager'), 
									($total_used_size > 0) ? size_format($total_used_size, 2) : '0 Bytes', 
									size_format($nm_file_quota*1024*1024, 2) );?>
    </td>
    
   
  </tr>
<?php endforeach;?>
  
</tbody>
</table>
  
</div>

<?php
if($total_users > $number){
$pl_args = array(
     'base'     => add_query_arg('paged','%#%'),
     'format'   => '&paged=%#%',
     'total'    => ceil($total_users / $number),
     'current'  => max(1, $paged),
  );

  // for ".../page/n"
  if($GLOBALS['wp_rewrite']->using_permalinks())
    $pl_args['base'] = user_trailingslashit(trailingslashit(get_pagenum_link(1)).'&paged=%#%', 'paged');

  echo paginate_links($pl_args);
}   
}
?>

</div>