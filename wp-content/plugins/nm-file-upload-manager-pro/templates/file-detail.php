<?php 
global $nmfilemanager;

$existing_meta = get_option('filemanager_meta');

$post_file = get_post( $_REQUEST['id'] );

$query = new WP_Query( array( 'post_type' => 'nm-userfiles', 'post__in' => array( $_REQUEST['id'] ) ) );

if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
  
$authorid = $post_file -> post_author;
$title = $post_file->post_title;
$file_path_dir = $nmfilemanager -> get_author_file_dir_path($authorid);
$file_size = size_format( filesize( $file_path_dir ));
//var_dump($file_path_dir);
?>
<button class="button b-close"><span>X</span></button>

<table class="nm-file-detail">
	<tr>
		<td class="img-wrap">
			<?php $nmfilemanager -> set_file_download( $_REQUEST['id'], $authorid, $file_size ); ?>
			<table class="file-infor-table">
				<tr>
					<td><strong> <?php _e('File Name :', 'nm-filemanager'); ?></strong></td>
					<td><?php echo $nmfilemanager -> get_attachment_file_name( $_REQUEST['id'] ); ?></td>
					
				</tr>
				<tr>
					<td><strong><?php _e('File Size:', 'nm-filemanager'); ?></strong></td>
					<td><?php echo $file_size; ?></td>
					
				</tr>
				<tr>
					<td><strong><?php _e('File Type:', 'nm-filemanager'); ?></strong></td>
					<td><?php $post_type = get_post_mime_type( $_REQUEST['id'] + 1 ); echo $post_type; //print_r($post ); ?></td>
					
				</tr>
			</table>			
		</td>
		<td>
			<div class="file-discr">
				<?php
				if ( the_content() != '' ){//$post -> post_content ){
					echo '<h3>'.__('Description', 'nm-filemanager').'</h3>';
					echo '<p>' . the_content() . '</p>';
				}
			    ?>
			    <?php 
				if($existing_meta){ 
				?>
				<div class="meta-dis">
					<h3><?php _e('Meta', 'nm-filemanager'); ?></h3>
					<table border="1">
						<thead>
					  <tr>
					     <th><strong><?php _e('Key', 'nm-filemanager'); ?></strong></th>
					     <th><strong><?php _e('Value', 'nm-filemanager'); ?></strong></th>
					  </tr>
					 </thead>
					 
			         <tbody>
					 <?php 
					 foreach($existing_meta as $key => $meta) {
					 	echo '<tr>';
					  		echo '<td>' . $meta['title'] . '</td>';
					  		echo '<td>' . get_post_meta($_REQUEST['id'], $meta['data_name'], true) . '</td>';
					  	echo '</tr>';
			         }
					 ?>
			         </tbody>
					</table>
				</div>
			    <?php } ?>
				<!-- END META DIV -->
				<div class="nm-coment">
				<h3><?php _e('Comments', 'nm-filemanager'); ?></h3>
			    
			<?php 
				global $withcomments;
				$withcomments = 1;
				comments_template(); ?>    
			</div>
			<p class="clear"></p>

			<?php
			endwhile;
			wp_reset_postdata();
			endif;
			?>			
		</td>
	</tr>
</table>
<script type="text/javascript">
  jQuery('document').ready(function($){
    // Get the comment form
    var commentform=$('#commentform');
    // Add a Comment Status message
    commentform.prepend('<div id="comment-status" ></div>');
    // Defining the Status message element 
    var statusdiv=$('#comment-status');
    commentform.submit(function(){
      // Serialize and store form data
      var formdata=commentform.serialize();
      //Add a status message
      statusdiv.html('<p class="ajax-placeholder">Processing...</p>');
      //Extract action URL from commentform
      var formurl=commentform.attr('action');
      //Post Form with data
      $.ajax({
        type: 'post',
        url: formurl,
        data: formdata,
        error: function(XMLHttpRequest, textStatus, errorThrown){
        	console.log(errorThrown);
          statusdiv.html('<p class="ajax-error" >You might have left one of the fields blank, or be posting too quickly</p>');
        },
        success: function(data, textStatus){
          if(data=="success") {
            statusdiv.html('<p class="ajax-success" >Thanks for your comment. We appreciate your response.</p>');
        }
          else {
            statusdiv.html('<p class="ajax-error" >Please wait a while before posting your next comment</p>');
        }
          commentform.find('textarea[name=comment]').val('');
        	window.location.reload();
        }
      });
      return false;
    });
  });
</script>