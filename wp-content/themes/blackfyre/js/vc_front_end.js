jQuery(document).ready(function () {

	window.setTimeout( function () {
	var button_group = jQuery('.vc_ui-btn-group');
	button_group.remove();

	var help_block = jQuery('.vc_ui-help-block');
	help_block.remove();



	var welcome = jQuery('.vc_welcome-header');
	welcome.empty();
	welcome.append(settingsVC.msg);
	welcome.append("<div class=\"sk-folding-cube\"><div class=\"sk-cube1 sk-cube\"></div><div class=\"sk-cube2 sk-cube\"></div><div class=\"sk-cube4 sk-cube\"></div><div class=\"sk-cube3 sk-cube\"></div></div>");
	}, 20 );

});