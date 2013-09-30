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
		
		/*if ($('.custom-tabs').length > 0) {
			var cntTabs = 0;
			$('.custom-tabs').each(function() {
				var vGenId = 'custom-tabs-' + cntTabs;
				$(this).attr('id', vGenId);
				
				$('#' + vGenId + ' .tab-content:eq(0)').fadeIn("slow");
				$('#' + vGenId + ' ul li:eq(0)').addClass('current');
		
				$('#' + vGenId + ' ul li').live("click", function() {
				$('#' + vGenId + ' ul li').removeClass("current");
				
					$(this).addClass('current');
					$(this).css({'border-top':'1px solid #E5E5E5'});
					$(this).css({'border-bottom':'1px solid #E5E5E5'});
					$(this).prev().css({'border-bottom':'0'});
					$(this).next().css({'border-top':'0'});
	
	
				$('#' + vGenId + ' .tab-content').hide();
				var index_a = $(this).find('a').attr("id");
					index_a = index_a.substr(index_a.indexOf('-') + 1);
					$('#' + vGenId + ' #tab_' + index_a).fadeIn("slow");
			
					return false;
				});
				cntTabs++;
			});
		}*/
});

jQuery(window).bind('scroll resize', function() {	
  
	if (ThGlobal.is_fixed_header != null) {
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