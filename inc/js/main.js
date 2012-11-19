jQuery(document).ready(function($) {
  $('input[type=checkbox]').ezMark();
  
  $('#settings-section-0').fadeIn("slow");
  $('.form-admin-fruitful .content .menu-options ul li').click(function() {

	$('.form-admin-fruitful .content .menu-options ul li').removeClass("current");
	$(this).addClass("current");
	$(this).prev().css({'border-bottom':'0'});
	$(this).css({'border-top':'1px solid #E5E5E5'});
	
	$('.form-admin-fruitful .content .settings-section').hide();

	var index_a = $(this).find('a').attr("id");
		 index_a = index_a.substr(index_a.indexOf('_') + 1);
		$('#settings-section-' + index_a).fadeIn("slow");
  });
	
	$("#upload_bg_button").click(function() {
		$("#background_img").click();
	});
	
	$('#colorSelector').ColorPicker({
		color: $('#background_color').val(),
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#colorSelector div').css('backgroundColor', '#' + hex);
			$('#background_color').val('#' + hex);
		}
	});
	
	$('#menubntcolor').ColorPicker({
		color: $('#menu_btn_color').val(),
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#menubntcolor div').css('backgroundColor', '#' + hex);
			$('#menu_btn_color').val('#' + hex);
		}
	});
	
	$('#menuboxshcolor').ColorPicker({
		color: $('#menu_boxsh_color').val(),
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#menuboxshcolor div').css('backgroundColor', '#' + hex);
			$('#menu_boxsh_color').val('#' + hex);
		}
	});
	
	
	$('#menufontcolorachvr').ColorPicker({
		color: $('#menu_hover_color').val(),
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#menufontcolorachvr div').css('backgroundColor', '#' + hex);
			$('#menu_hover_color').val('#' + hex);
		}
	});
	
	$('#menutxtshcolor').ColorPicker({
		color: $('#menu_txtsh_color').val(),
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#menutxtshcolor div').css('backgroundColor', '#' + hex);
			$('#menu_txtsh_color').val('#' + hex);
		}
	});
	
	$('#menufontcolor').ColorPicker({
		color: $('#menu_font_color').val(),
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#menufontcolor div').css('backgroundColor', '#' + hex);
			$('#menu_font_color').val('#' + hex);
		}
	});
	
		$(".select-fonts").each(function() {
			var vTextFontSample = $(this).prev();
			vTextFontSample.css({"font-family" : $(this).val()});
		});
		

				  
		btnUploadInit('.upload_btn', 'fruitful_theme_options_action');
		btnUploadInit('.upload_slide_btn', 'fruitful_theme_options_slider');
		btnResetInit('.reset_btn', 'fruitful_theme_options_action')
		btnResetInit('.reset_slide_btn',  'fruitful_theme_options_slider')
	
		$(".select-fonts").live("change", function(){
			var vTextFontSample = $(this).prev();
				  vTextFontSample.css({"font-family" : $(this).val()});
		});

		/*Sortable slide*/
		$("ul.slides").sortable({ 
			 opacity: 0.9,
			 cursor: 'move',
 			 revert: true,
			 beforeStop: function(event, ui) {
				var order = $(this).sortable("toArray"); 
				var data = {
						action: 'sorting_slides_image',
						type: 'sortbeforestop',
						data: order
					};
					jQuery.post(ajaxurl, data, function(response) {}); 
			 },
			 change :function(event, ui) {/*make to chnage sort item index*/ }
			 
		});
		 
		
			
		$('#form-admin-fruitful').submit(function() {
	         var data = $(this).serialize();
	          jQuery.post(ajaxurl, data, function(response) {
	              var vRes = parseInt($.trim(response));
				  
				  if(vRes == 1) {
	                  show_message(1);
	                  t = setTimeout('fade_message()', 2000);
	              } else {
	                  show_message(2);
	                  t = setTimeout('fade_message()', 2000);
	              }
	          });
	          return false;
	     });
	
		$(".add_new_btn").live("click", function() {
			var data = {
						action: 'fruitful_add_new_slide_action',
						type:    'add_new_slide',
						data: $('.slides').children().size() + 1
					};	
		 
			jQuery.post(ajaxurl, data, function(response) {
				  
				  if ($("ul.slides li.slide").length > 0) {
					  $("ul.slides li.slide").last().after(response);
						} else {
							$("ul.slides").append(response);
					  }
				  
				  btnUploadInit('.upload_slide_btn', 'fruitful_theme_options_slider');
				  btnResetInit('.reset_slide_btn', 'fruitful_theme_options_slider');
	          });
	          return false;
		});
		
		$('#view_all_options').live("click", function() {
			var vElemSlideOpt = $('#slider_main_options');
			vElemSlideOpt.fadeIn('slow'); 
			$(this).remove();
		});
  
		$(".content-close-slide").live("click", function() {
			var vElem = $(this).parent().next();
			 if (vElem.css('display') == "none" ) { vElem.fadeIn('slow'); } else { vElem.fadeOut('slow'); }	
		});
	
		$(".remove-slide").live("click", function() {
			var vElemRemove = $(this).parent().parent();
			console.log($(this).parent().next().find('.reset_slide_btn').length);
			if ($(this).parent().next().find('.reset_slide_btn').length > 0) {
			   $(this).parent().next().find('.reset_slide_btn').click();
			}
			
			vElemRemove.remove();
			
			/*Update Array() for order slides on remove slide*/
			var order = $("ul.slides").sortable("toArray"); 
			var data = {
								action: 'sorting_slides_image',
								type: 'sortbeforestop',
								data: order 
					};
			jQuery.post(ajaxurl, data, function(response) {}); 
					
		});

		
		$('input[name="reset"]').live("click", function(){
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		$( "#dialog-confirm" ).dialog({ 
			width:   364,
			resizable: false,
			modal: true,
			position: "center",
			buttons: {
				"Reset all saved data?": function() {
				var data = {
										action: 	'fruitful_reset_btn',
										type:   	'reset',
										data: 		''
									};	
									
				jQuery.post(ajaxurl, data, function(response) { });
					$( this ).dialog( "close" );
					  setTimeout(function(){
							location.reload(true);
						}, 1000);  
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
			});
		});
					
		/*end soratble slide*/
		if ($("ul.slides li").size() >2) {
			$("ul.slides li .slide-content").hide("slow");
		}		
		
		$(".expand_all").live("click", function(){
			$("ul.slides li .slide-content").show("slow");
		});
		
		$(".collapse_all").live("click", function(){
			$("ul.slides li .slide-content").hide("slow");
		});
	
		$("#save_options").center();
		$(window).bind('resize', function() {
			$('#save_options').center();
		});
});


function show_message(n) {
	if(n == 1) {
			$('.save-options').html('<div class="icon-sc"></div><div class="text">Success data save...</div>').show();
		} else {
			$('.save-options').html('<div class="icon-al"></div><div class="text">No data saved...</div>').show();
		}
	}
	     
function fade_message() {
	$('.save-options').fadeOut(1000);
	clearTimeout(t);
}
		
		function btnUploadInit(btn_name, action_name) {
		jQuery(btn_name).each(function(){

			var clickedObject = jQuery(this);
			var clickedID = jQuery(this).attr('id');	
			
			new AjaxUpload(clickedID, {
				  action: ajaxurl,
				  name: clickedID, // File upload name
				  data: { 			   // Additional data to send
						action: action_name,
						type:   'upload',
						data:   clickedID },
				  autoSubmit: true, // Submit file after selection
				  responseType: false,
				  onChange: function(file, extension){},
				  onSubmit: function(file, extension){
						clickedObject.text('Uploading'); 	// change button text, when user selects file	
						this.disable(); 							// If you want to allow uploading only 1 file at time, you can disable upload button
						interval = window.setInterval(function(){
							var text = clickedObject.text();
							  if (text.length < 13){	clickedObject.text(text + '.'); }
							else { clickedObject.text('Uploading'); } 
						}, 200);
				  },
				  onComplete: function(file, response) {
					var vfullname  = response.substring(0, response.indexOf('zc=0')+4);
					var vorigname = response.substring(response.indexOf('src=')+4, response.indexOf('&amp'));				   
					
					window.clearInterval(interval);
					clickedObject.text('Upload Image');	
					this.enable(); // enable upload button
					
					// If there was an error
					if(response.search('Upload Error') > -1){
						var buildReturn = '<span class="upload-error">' + response + '</span>';
						jQuery(".upload-error").remove();
						clickedObject.parent().after(buildReturn);
					}
					else{
						var buildReturn = '<img class="none upload-image" id="image_' + clickedID + '" src="' + vfullname + '" alt="" />';
						jQuery(".upload-error").remove();	
						jQuery("#image_" + clickedID).remove();	
						clickedObject.parent().after(buildReturn);
						jQuery('img#image_'+clickedID).fadeIn();
						clickedObject.next('span').fadeIn();
						clickedObject.parent().prev('input').val(vorigname);
					}
				  }
				});
			});
			}
			
			function btnResetInit(btn_name, action_name) {
			jQuery(btn_name).click(function(){
			
					var clickedObject = jQuery(this);
					var clickedID 		  = jQuery(this).attr('id');
					var theID 			  = jQuery(this).attr('title');	
						
					var data = {
						action: action_name,
						type: 'upload_delete',
						data: theID
					};
					
					jQuery.post(ajaxurl, data, function(response) {
						var image_to_remove = jQuery('#image_' + theID);
						var button_to_hide = jQuery('#reset_' + theID);
						image_to_remove.fadeOut(500,function(){ jQuery(this).remove(); });
						button_to_hide.fadeOut();
						clickedObject.parent().prev('input').val('');
					});
					return false; 
				});
			}
			

$.fn.center = function () {
    var heightRatio = ($('#form-admin-fruitful').height() != 0) 
            ? this.outerHeight() / $('#form-admin-fruitful').height() : 1;
    var widthRatio = ($('#form-admin-fruitful').width() != 0) 
            ? this.outerWidth() / $('#form-admin-fruitful').width() : 1;

    this.css({
        position: 'fixed',
        margin: 0,
        top: (50*(1-heightRatio)) + "%" ,
        left: (50*(1-widthRatio))  + "%"
    });

    return this;
}