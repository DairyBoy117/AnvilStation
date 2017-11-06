<?php
/*
 * it is loading share file form for thickbox
 */
?>
<style>
	.filename-alert {
		color: #3c763d;
		background-color: #dff0d8;
		border-color: #d6e9c6;
		padding: 15px !important;
		margin-bottom: 20px;
		border: 1px solid transparent;
		border-radius: 4px;
	}
	.nm-label {
		display: inline-block;
		max-width: 100%;
		margin-bottom: 5px;
		font-weight: 700;		
		margin-top: 10px;
	}
	.form-styles {
		display: block;
		width: 100%;
		padding: 6px 12px;
		font-size: 14px;
		line-height: 1.42857143;
		color: #555;
		background-color: #fff;
		background-image: none;
		border: 1px solid #ccc;
		border-radius: 4px;
		-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
		box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
		-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
		-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
		transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
		box-sizing: border-box;		
	}
</style>
<div id="filemanager-sendfile">
	<form id="frm-send-files" method="post" onsubmit="return send_files_email(this)">
		<input type="hidden" id="shared_single_file" value="<?php echo $_REQUEST['filename'] ?>">
		<input type="hidden" id="file_owner_id" value="<?php echo $_REQUEST['fileownerid'] ?>">
		
		<p class="filename-alert"><i class="fa fa-paperclip"></i> File attached - <strong><?php echo $_REQUEST['filename']; ?></strong></p>

		<label class="nm-label" for="subject"><?php echo _e('Subject', 'nm-filemanager'); ?></label>
		<input class="filemanager-sendfile-input form-styles" type="text" id="subject"/>

		<label class="nm-label" for="email-to"><?php echo _e('Email separated by commas', 'nm-filemanager'); ?></label>
		<input class="filemanager-sendfile-input form-styles" type="text" id="email-to"/>

		<label class="nm-label" for="file-msg"><?php echo _e('Any message', 'nm-filemanager'); ?></label>
		<textarea rows="3" class="filemanager-sendfile-textarea form-styles" id="file-msg"></textarea>

		<input class="filemanager-sendfile-button submit-styles" type="submit" value="<?php echo _e('Send File', 'nm-filemanager'); ?>" />

		<div id="sending-mail" style="display:none">
			<img src="<?php echo $this->plugin_meta ['url'];  ?>/images/loading.gif">
		</div>
	</form>
</div>