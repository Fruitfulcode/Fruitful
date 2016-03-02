jQuery(document).ready(function() {  
	jQuery('input[type=checkbox]').ezMark();  
	if (document.body.clientWidth > 580){
		jQuery('select').styler();    
	}
	
	jQuery('.customize-control input[type=checkbox]').each(function() {
		check_val = jQuery(this).val();
		if (check_val == 'off') {
			jQuery(this).parent('.ez-checkbox').removeClass('ez-checked');
		}
	});

});	
	