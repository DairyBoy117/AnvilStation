jQuery(document).ready(function () {

	function blackfyre_setup_template(){
		var template = jQuery('#vc_ui-panel-templates .vc_default_template-999999 .vc_ui-list-bar-item-trigger');
		template[0].click();

	}
	setTimeout(blackfyre_setup_template, 8000);

	function blackfyre_remove_templates(){

		var templates = jQuery('#vc_templates-editor-button');
		templates.remove();
	}
	setTimeout(blackfyre_remove_templates, 1000);

});