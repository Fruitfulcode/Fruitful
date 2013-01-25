var file_frame;

(function($) {})(jQuery);

jQuery(document).ready(function($) {
	
	 jQuery('.add_gallery_items_button').live('click', function( event ){
			event.preventDefault();
			if (file_frame) {		
				file_frame.open();
				return;

			}

			 file_frame = wp.media.editor.send.attachment  = wp.media({
					multiple: true 
			});
 
			file_frame.on( 'select', function() {
				var selection = file_frame.state().get('selection');
					selection.map( function( attachment ) {
						attachment = attachment.toJSON();
						var image_url = attachment.url,
							image_id  = attachment.id;
						var data = {	action:  'fruitful_add_new_element_action',
										type:    'add_new_images',
										image_url: image_url,
										image_id : image_id,
										image_cnt: $("ul.sortable-admin-gallery li.glr_item").length,
										fruitful_ajax_nonce : fruitful_vars_ajax.ajax_nonce,
										
									};	
						
						$.post(fruitful_vars_ajax.ajaxurl, data, function(response) {
							if ($("ul.sortable-admin-gallery li.glr_item").length > 0) {
								$("ul.sortable-admin-gallery li.glr_item").last().after(response);
							} else {
								$("ul.sortable-admin-gallery").append(response);
							}
				  
				  
						});
			  
					});

			});

			file_frame.open();
			return false;

		});
		
	/*	Use For One Attachments
		$('.add_gallery_items_button').click(function () {
        var send_attachment_bkp = wp.media.editor.send.attachment;
		
		wp.media.editor.send.attachment = function(props, attachment) {
		var image_url = attachment.url,
			image_id  = attachment.id;
			
		var data = {	action:  'fruitful_add_new_element_action',
						type:    'add_new_images',
						image_url:  image_url,
						image_id: image_id 
					};	
						
			$.post(ajaxurl, data, function(response) {
				  
				  if ($("ul.sortable-admin-gallery li.glr_item").length > 0) {
					  $("ul.sortable-admin-gallery li.glr_item").last().after(response);
						} else {
							$("ul.sortable-admin-gallery").append(response);
					  }
				  
				  
	          });
        wp.media.editor.send.attachment = send_attachment_bkp;
    }
    wp.media.editor.open();
    return false;
	});     
	*/
	
	$( "#sortable" ).disableSelection();
	$( "#sortable" ).sortable({placeholder:'ui-SortPlaceHolder'});
	
	
	$( "#sortable li" ).mousedown(function() {
		$(this).find("a.delete_btn_glr").fadeOut(100);
	});
	
	$( "#sortable li" ).mouseup(function() {
		$(this).find("a.delete_btn_glr").fadeOut(100);
	});
	
	$( "#sortable li" ).hover(
		function () {
				$(this).find("a.delete_btn_glr").fadeIn(400);
		},
		function () {
				$(this).find("a.delete_btn_glr").fadeOut(300);
			}	
	);
	
	$("a.delete_btn_glr").live('click', function(){
		$(this).parent().remove();
	});
    
});