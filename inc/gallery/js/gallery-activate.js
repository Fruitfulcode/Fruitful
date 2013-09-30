 jQuery(document).ready(function() {
	
	var api=jQuery('#gallery-' + fruitful_megafolio_js.id ).megafoliopro({
			filterChangeAnimation:"fade",			
			filterChangeSpeed:	fruitful_megafolio_js.animations_speed,					
			filterChangeRotate:	fruitful_megafolio_js.rotation_corner,					
			filterChangeScale:	fruitful_megafolio_js.scale,					
			delay:20,
			defaultWidth:980,
			paddingHorizontal:fruitful_megafolio_js.padding_images_hor,
			paddingVertical  :fruitful_megafolio_js.padding_images_ver,
			layoutarray:[0]		
	
		});
	
	if (fruitful_megafolio_js.megaremix != 0) {
		api.megaremix(fruitful_megafolio_js.megaremix);
	}	
 });
