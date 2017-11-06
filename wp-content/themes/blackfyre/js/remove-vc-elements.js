jQuery(document).ready(function() {
	    setTimeout(function(){
    
     //templates
       var landing = jQuery('.vc_default-templates div[data-template_unique_id="1"]');
       var call_action = jQuery('.vc_default-templates div[data-template_unique_id="2"]');
       var feature_list = jQuery('.vc_default-templates div[data-template_unique_id="3"]');
       var description = jQuery('.vc_default-templates div[data-template_unique_id="4"]');
       var service_list = jQuery('.vc_default-templates div[data-template_unique_id="5"]');
       var template_button = jQuery('.vc_default-templates .vc_default-templates-more-layouts');
       
       
       landing.remove();
       call_action.remove();
       feature_list.remove();
       description.remove();
       service_list.remove();
       template_button.remove();
	}, 500);

});