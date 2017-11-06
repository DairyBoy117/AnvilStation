var AddedModal = false;
var ChangingIcon = 0;
jQuery(document).ready(function () {
	BindButtons();
});

jQuery(document).ready(function () {
var empty_themeoptions_item = jQuery('.wp-submenu li a[href="themes.php?page=options-framework"]');
empty_themeoptions_item.remove();
});


function BindButtons() {

	var link = jQuery('#myTab a');
	var content = jQuery('.tab-content');

    link.click(function (e) {
    	//console.log('aaaaaa');
    e.preventDefault()
    var id = jQuery(this).attr('id');
    //console.log(id);
  	content.children().removeClass("active");
    jQuery('.tab-content #'+id).addClass("active");
   });

 jQuery("#userForm .panel-title input[type='checkbox']").change(function () {
  	jQuery(this).closest('div').next().find(".panel-body input[type='checkbox']").prop('checked', this.checked);
  });


jQuery(".pb-cat-cont label span").each(function (e) {
	var tmpcls = jQuery(this).attr('class');
	jQuery(this).parents().eq(1).addClass(tmpcls);
});

}

jQuery(document).ready(function () {
	var admin_page_form = jQuery('#bp-admin-page-form .form-table');
	var admin_page_form_h3 = jQuery('#bp-admin-page-form h3');
	var admin_page_form_p = jQuery('#bp-admin-page-form p');
	admin_page_form.eq(1).remove();
	admin_page_form_h3.eq(1).remove();
	admin_page_form_p.eq(1).remove();
});

