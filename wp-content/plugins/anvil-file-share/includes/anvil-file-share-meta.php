<?php

function files_meta_info() { ?>

	<div id="meta-box-tabs">

		<label for="file-uploader">Upload File</label> <br>
		<input type="text" name="file-uploader" id="file-uploader" value="<?php echo $fileUpload; ?>"/>
		<a href="<?php echo $uploadFloorPlan ?>" class="add-media" id="add-file"> Add Media </a> 

		<script>

			<?php include ( plugin_dir_path( __FILE__ ) . '../js/upload_scripts.js'); ?>

		</script>

	</div>

<?php }

?>