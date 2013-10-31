jQuery(document).ready(function($) {
		$('.menu').mobileMenu({
			defaultText: 'Navigate to...',
			className: 	 'select-menu',
			subMenuDash: '&nbsp;&nbsp;&ndash;'
		});
		
		/*Fancy Box*/
	
		$(".fn_box_img").fancybox({
				padding		: 0,
				openEffect 	: 'elastic',
				openSpeed  	: 150,
				closeEffect : 'elastic',
				closeSpeed  : 150,
				width 		: 800,
				height 		: 600,
				maxWidth 	: 1024,
				maxHeight 	: 768,
				closeClick 	: true,
				helpers 	: {
					overlay : {
							css : {
								'background' : 'rgba(0,0,0,0.25)'
									}
								}
							}
		});
		
		$('#back-top a').click(function () {
			$('body,html').animate({  scrollTop: 0}, 800)
			return false;
		});
		
		$("#tabbed-nav").zozoTabs({
					position: "top-left",
					theme: "gray",
					rounded: true,
					shadows: true,
					autoContentHeight: true,
					size: "large",
					orientation: "vertical",
					responsive: true,
					responsiveDelay: 0,
					defaultTab: "tab1",
					style: "underlined",
					animation: {
									easing: "easeInOutExpo",
									duration: 500,
									effects: "fade"
								}
		});
});

jQuery(window).bind('scroll resize', function() {	
	if (ThGlobal.is_fixed_header != -1) {
		var outher_height = jQuery(".head-container").outerHeight()
		
		if (jQuery(window).scrollTop() > outher_height) {
			if (jQuery('#wpadminbar').length > 0) {
				jQuery(".head-container").addClass('fixed is_indent'); 
			} else {
				jQuery(".head-container").addClass('fixed'); 
			}		
		} else {	
				jQuery(".head-container").removeClass('fixed is_indent');
		}
	}
});