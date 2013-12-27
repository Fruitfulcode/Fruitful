jQuery(document).ready(function($) {
		$('.menu').mobileMenu({
			defaultText: 'Navigate to...',
			className: 	 'select-menu',
			subMenuDash: '&nbsp;&nbsp;&ndash;'
		});
		
		/*Fancy Box*/
		if ($(".fancybox").length > 0) {
			$(".fancybox").fancybox({
				'overlayShow'	 : true,
				'transitionIn'	 : 'elastic',
				'transitionOut'	 : 'elastic',
				'padding'		 : 0,
				'autoScale'		 : false,
				'speedIn' 		 : 250,
				'speedOut'  	 : 250,
				'width' 		 : 800,
				'height' 		 : 600,
				'overlayOpacity' : 0.25,
				'overlayColor'   : '#000',
				'autoScale' : true,
				'autoDimensions' : false,
				'centerOnScroll' : true
		});
		}
		
		$('#back-top a').click(function () {
			$('body,html').animate({ scrollTop: 0}, 850)
			return false;
		});
		
		if ($(".tabbed-nav").length > 0 ) {
			$(".tabbed-nav").easyResponsiveTabs({
				type: 'vertical',
				width: 'auto',
				fit: true
			});
		}
		
		$('.menu li:has(ul)').mobileMenuDropdown();
		
		jQuery(window).resize();
});

jQuery(window).bind('resize', function() { 
	var vAllH 	= jQuery('.site-header').outerWidth(),
		vHgroup = jQuery('hgroup').outerWidth(),
		vMenu   = jQuery('.site-navigation').outerWidth();
	
	if (vAllH < (vHgroup + vMenu)) {
		jQuery('.site-navigation').css({'float':'left'});
	} else {
		jQuery('.site-navigation').css({'float':'right'});
	}		
		
});

jQuery(window).bind('scroll', function() { 
	if (ThGlobal.is_fixed_header != -1) {
		var outher_height = jQuery(".head-container").outerHeight();
		
		if (jQuery(this).scrollTop() > outher_height) {
			if (jQuery('#wpadminbar').length > 0) {
				jQuery(".head-container").addClass('fixed is_indent'); 
			} else {
				jQuery(".head-container").addClass('fixed'); 
			}  
		} else { 
			jQuery(".head-container").removeClass('fixed is_indent');
		}
	}
  
	if( jQuery(window).scrollTop() + jQuery(window).height() == jQuery(document).height()) {
		jQuery('#back-top').fadeIn('slow'); 
	} else {
		jQuery('#back-top').fadeOut('slow');
	}
});