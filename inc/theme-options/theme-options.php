<?php
/**
 * Fruitful theme Theme Options
 *
 * @package Fruitful theme
 * @since Fruitful theme 1.0
 */

/**
 * Register the form setting for our fruitful_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, fruitful_theme_options_validate(),
 * which is used when the option is saved, to ensure that our option values are properly
 * formatted, and safe.
 *
 * @since Fruitful theme 1.0
 */
function fruitful_theme_options_init() {
	register_setting(
		'fruitful_options', 				// Options group, see settings_fields() call in fruitful_theme_options_render_page()
		'fruitful_theme_options', 		// Database option, see fruitful_get_theme_options()
		'' // The sanitization callback, see fruitful_theme_options_validate()
	);
	// Register our settings field group
	add_settings_section('general',			'',  '__return_false', 'theme_options' );
	add_settings_section('background',		'',  '__return_false', 'theme_options' );
	add_settings_section('logo', 				'',  '__return_false', 'theme_options' );
	add_settings_section('menu', 				'',  '__return_false', 'theme_options' );
	add_settings_section('fonts', 				'',  '__return_false', 'theme_options' );
	add_settings_section('slider', 				'',  '__return_false', 'theme_options' );
	add_settings_section('links', 				'',  '__return_false', 'theme_options' );
	add_settings_section('footer', 				'',  '__return_false', 'theme_options' );
	
	add_settings_field( 'general_rs', 		__( 'Layout', 'fruitful' ),	    'fruitful_get_responsive_design',	'theme_options',  'general', array('info' => __( 'Theme supported 2 types of layout. Default static and responsive which adapt for mobile devices, if you will scale width of browser window, website will be collapsed. <a target="_blank" href="http://fruitfulcode.com/blog/responsive">Learn more</a> about Responsive. ', 'fruitful' )));
	add_settings_field( 'general_cm',		__( 'Comments', 'fruitful' ), 'fruitful_get_general_comment',  	'theme_options',  'general', array('info' => __( 'If you want to display comments on your post page or page, select options below.', 'fruitful' )));
	add_settings_field( 'general_ds',		__( 'Default css', 'fruitful' ), 	'fruitful_get_style_theme',  			'theme_options',  'general', array('info' => __( 'Theme has styles by default, if you are using theme as based for development and dont what overwrite default css styles, you can disable our styles. ', 'fruitful' )));
	
	
	add_settings_field( 'background_image', 	__( 'Background Image', 'fruitful' ), 'fruitful_get_background_img',  'theme_options',  'background', array('info' => __( 'Upload needed image for site background. (Supported files .png, .jpg, .gif)', 'fruitful' )));
	add_settings_field( 'background_color', 	__( 'Background Color ', 'fruitful' ), 'fruitful_get_background_color', 'theme_options', 'background', array('info' => __( 'Choose color for body background', 'fruitful' )));
		
	add_settings_field( 'logo_image', 			__( 'Logo Image', 'fruitful' ), 		'fruitful_get_logo_img',	'theme_options', 'logo', 	array('info' => __( 'Upload needed image for site logo. (Supported files .png, .jpg, .gif)', 'fruitful' )));
	add_settings_field( 'logo_size', 				__( 'Logo Size', 'fruitful' ), 		'fruitful_get_logo_wh',		'theme_options', 'logo', 	array('info' => __( 'Specify resolution for your logo image. Our theme will crop (timthumb) your image for need size.', 'fruitful' )) );
	add_settings_field( 'menu_style',				__( 'Menu Style ', 'fruitful' ),	 	'fruitful_menu_style',		'theme_options', 'menu',  array('info' => __( 'Choose styles for main menu.', 'fruitful' )) );
	add_settings_field( 'fonts_options', 			__( 'Fonts Options', 'fruitful' ), 	'fruitful_fonts_options',	'theme_options', 'fonts', array('info' => __( 'We collected web safe fonts and google web fonts in this option. You can select the desired font or upload own. <a target="_blank" href="http://fruitfulcode.com/fruitful/documentation">Learn more</a> about how to add own font to this option.', 'fruitful' )) );
	
	add_settings_field( 'fonts_headers', 			__( 'Headers', 'fruitful' ), 	'fruitful_fonts_headers',	'theme_options', 'fonts', array('info' => __( 'Choose font-family for all headlines.', 'fruitful' )) );
		
	add_settings_field( 'fonts_content', 			__( 'Content', 'fruitful' ), 	'fruitful_fonts_content',	'theme_options', 'fonts', array('info' => __( 'Choose font-family for text.', 'fruitful' )) );
	
	add_settings_field( 'fonts_size', 			__( 'Font size', 'fruitful' ), 	'fruitful_fonts_size',	'theme_options', 'fonts', array('info' => __( 'Choose font size for specific html elements. Set size as number, without px.', 'fruitful' )) );
	
	add_settings_field( 'slider_options',			__( 'Slider Options', 'fruitful' ), 	'fruitful_slider_options',	'theme_options', 'slider', array('info' => __( 'Choose needed options for slider. Width, height, animation type, sliding direction, speed of animations, etc', 'fruitful' )) );
	add_settings_field( 'slider_image',			__( 'Slides', 'fruitful' ), 	'fruitful_slider_images',	'theme_options', 'slider', array('info' => __( 'Add images to slider (Supported files .png, .jpg, .gif). After upload it will be saved automatically. If you want to change slides order, just drag and drop it. If images have not property size, set image size in slider options. To display slider in needed place use shortcode [slider]. <a href="http://fruitfulcode.com/fruitful/documentation/shortcodes">Learn more</a> about shortcodes. ', 'fruitful' )) );
	
	add_settings_field( 'socials_links', 			__( 'Socials Links', 'fruitful' ), 	'fruitful_settings_field_socials_links', 'theme_options', 'links', array('info' => __( 'Add link to your social media profiles. Icons with link will be display in footer.', 'fruitful' )) );
	add_settings_field( 'footer_text_copy',		__( 'Footer Options', 'fruitful' ), 'fruitful_settings_field_footer_text', 'theme_options', 'footer' );
	
	add_option( 'fruitful_theme_slides_options', '', '', 'yes' ); 
	add_option( 'fruitful_theme_slides_sort_options', '', '', 'yes' ); 
}
	
add_action( 'admin_init', 'fruitful_theme_options_init' );

add_action( 'admin_enqueue_scripts', 'add_admin_options_and_styles' );
function add_admin_options_and_styles($hook) {
	if( 'toplevel_page_theme_options' != $hook ) return;
	add_jquery_script();
	add_admin_style();
} 

/**
 * Change the capability required to save the 'fruitful_options' options group.
 *
 * @see fruitful_theme_options_init() First parameter to register_setting() is the name of the options group.
 * @see fruitful_theme_options_add_page() The edit_theme_options capability is used for viewing the page.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function fruitful_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_fruitful_options', 'fruitful_option_page_capability' );

/**
 * Add our theme options page to the admin menu.
 *
 * This function is attached to the admin_menu action hook.
 *
 * @since Fruitful theme 1.0
 */
add_action( 'admin_menu', 'fruitful_theme_options_add_page' );
 function fruitful_theme_options_add_page() {
	$theme_page = add_menu_page(
		__( 'Fruitful Theme Options', 'fruitful' ),   	// Name of page
		__( 'Theme Options', 'fruitful' ),   			    // Label in menu
			'edit_theme_options',          	 			// Capability required
			'theme_options',                     			// Menu slug, used to uniquely identify the page
			'fruitful_theme_options_render_page' 	// Function that renders the options page
	);
}


add_action( 'admin_bar_menu', 'add_custom_link_options', 1000 );
function add_custom_link_options() {
    global $wp_admin_bar, $wpdb;
		if ( !is_super_admin() || !is_admin_bar_showing() )
		return;

	/* Add the main siteadmin menu item */
    $wp_admin_bar->add_menu( array( 'id' => 'fruitfultheme_options', 'title' => __( 'Theme Options', 'textdomain' ), 'href' => admin_url('admin.php?page=theme_options')));	
}


/**
 * Returns the options array for Fruitful theme.
 *
 * @since Fruitful theme 1.0
 */
function fruitful_get_theme_options() {
	$saved = (array) get_option( 'fruitful_theme_options' );
	$defaults = get_default_array();
	$defaults = apply_filters( 'fruitful_default_theme_options', $defaults );
	$options = wp_parse_args( $saved, $defaults );
	$options = array_intersect_key( $options, $defaults );
	return $options;
}

function fruitful_get_responsive_design() { 
	$options = fruitful_get_theme_options();
	?>
	<div class="box-option">
			<label for="responsive_ch"><input type="checkbox" name="fruitful_theme_options[responsive]" id="responsive_ch" <?php checked( 'on', $options['responsive']); ?> />
			<?php _e( 'Responsive', 'fruitful' ); ?>
			</label>
	</div>
<?php }

function fruitful_get_general_comment() {
	$options = fruitful_get_theme_options();
	?>
		<div class="box-option">
			<label for="postcomment_ch"><input type="checkbox" name="fruitful_theme_options[postcomment]" id="postcomment_ch" <?php checked( 'on', $options['postcomment']); ?> />
			<?php _e( 'Display comment on posts page', 'fruitful' ); ?>
			</label>
		</div>
		<div class="box-option">
			<label for="pagecomment_ch"><input type="checkbox" name="fruitful_theme_options[pagecomment]" id="pagecomment_ch" <?php checked( 'on', $options['pagecomment']); ?> />
			<?php _e( 'Display comment on page', 'fruitful' ); ?>
			</label>
		</div>
	<?php	
}

function fruitful_get_style_theme() {
	$options = fruitful_get_theme_options();
	?>
		<div class="box-option">
			<label for="style_theme"><input type="checkbox" name="fruitful_theme_options[styletheme]" id="style_theme" <?php checked( 'on', $options['styletheme']); ?> />
			<?php _e( 'Enable default css', 'fruitful' ); ?>
			</label>
		</div>
	<?php	
}
	

function fruitful_settings_field_socials_links() {
	$options = fruitful_get_theme_options();
	?>
	<div class="socials">
		<h4>Facebook</h4><input id="facebook_url" name="fruitful_theme_options[facebook_url]" type="text" value="<?php echo esc_url( $options['facebook_url'] ); ?>"/>
		<h4>Twitter</h4><input id="twitter_url" name="fruitful_theme_options[twitter_url]" type="text" value="<?php echo esc_url( $options['twitter_url'] ); ?>"/>
		<h4>LinkedIn</h4><input id="linkedin_url" name="fruitful_theme_options[linkedin_url]" type="text" value="<?php echo esc_url( $options['linkedin_url'] ); ?>"/>
		<h4>MySpace</h4><input id="myspace_url" name="fruitful_theme_options[myspace_url]" type="text" value="<?php echo esc_url( $options['myspace_url'] ); ?>"/>
		<h4>Google Plus+</h4><input id="googleplus_url" name="fruitful_theme_options[googleplus_url]" type="text" value="<?php echo esc_url( $options['googleplus_url'] ); ?>"/>
		<h4>Dribbble</h4><input id="dribbble_url" name="fruitful_theme_options[dribbble_url]" type="text" value="<?php echo esc_url( $options['dribbble_url'] ); ?>"/>
		<h4>Skype</h4><input id="skype_link" name="fruitful_theme_options[skype_link]" type="text" value="<?php echo esc_url( $options['skype_link'] ); ?>"/>
		<h4>Flickr</h4><input id="flickr_link" name="fruitful_theme_options[flickr_link]" type="text" value="<?php echo esc_url( $options['flickr_link'] ); ?>"/>
		<h4>You Tube</h4><input id="youtube_url" name="fruitful_theme_options[youtube_url]" type="text" value="<?php echo esc_url( $options['youtube_url'] ); ?>"/>
		<h4>RSS</h4><input id="rss_link" name="fruitful_theme_options[rss_link]" type="text" value="<?php echo esc_url( $options['rss_link'] ); ?>"/>
	</div>
	<?php
}	
	
function fruitful_settings_field_footer_text() {
	$options = fruitful_get_theme_options();
	?>
	<h4><?php _e( 'Footer Text', 'fruitful' ); ?></h4><textarea class="large-text" type="text" name="fruitful_theme_options[footer_text]" id="footer-text" cols="50" rows="10" /><?php echo stripslashes($options['footer_text']); ?></textarea>
	<h4><?php _e( 'Tracking Code', 'fruitful' ); ?></h4><input id="tracking_code" name="fruitful_theme_options[tracking_code]" type="text" value="<?php echo $options['tracking_code']; ?>"/>
<?php
}

function fruitful_get_background_img () {
	$options = fruitful_get_theme_options();
	$upload  = $options['backgroung_img'];
	
	echo get_code_upload_images($upload, 'backgroung_img', 400, 400); 
	?>
	<div class="box-option">
		<label for="bg_checkbox">
			<input type="checkbox" name="fruitful_theme_options[bg_repeating]" id="bg_checkbox" <?php checked( 'on', $options['bg_repeating'] ); ?> />
			<?php _e( 'Background  repeat', 'fruitful' ); ?>
		</label>
	</div>
	
	<?php
	}

function fruitful_get_logo_img () {
	$options = fruitful_get_theme_options();
	$upload  = $options['logo_img'];

	echo get_code_upload_images($upload, 'logo_img', 400, 400,  'upload_btn', 'reset_btn', 'logo_img');
}

	function fruitful_get_logo_wh () {
	$options = fruitful_get_theme_options();
	$upload  = $options['logo_img'];
	?>
	<h4 class="full-width"><?php _e( 'Width', 'fruitful' ); ?></h4>
	<input type="text" name="fruitful_theme_options[logo_w]"  id="logo-w" value ="<?php echo $options['logo_w']; ?>"/>
	<h4 class="full-width"><?php _e( 'Height', 'fruitful' ); ?></h4><input type="text" name="fruitful_theme_options[logo_h]" id="logo-h"  value ="<?php echo $options['logo_h']; ?>"/>

	<?php }
	
function fruitful_fonts_options () {
	$options = fruitful_get_theme_options();
	?>

	<?php
}

function fruitful_fonts_headers () {
	$options = fruitful_get_theme_options();
	?>
    <div class="text_fonts">
		<div id="header_sample_font" class="sample_text">Sample Font</div>
		<?php get_select_fields('h_font_family',$options, fruitful_fonts_list(), 'select-fonts'); ?>
	</div>

	<?php
}

function fruitful_fonts_content () {
	$options = fruitful_get_theme_options();
	?>
    <div class="text_fonts">
		<div id="content_sample_font" class="sample_text">Sample Font</div>
		<?php get_select_fields('p_font_family', $options, fruitful_fonts_list(), 'select-fonts'); ?>
	</div>		
	<?php
}

function fruitful_fonts_size () {
	$options = fruitful_get_theme_options();
	?>
    <h4><?php _e( 'H1', 'fruitful' ); ?></h4><input type="text" name="fruitful_theme_options[h1_size]" id="h1-size" value ="<?php echo $options['h1_size']; ?>"/>
	<h4><?php _e( 'H2', 'fruitful' ); ?></h4><input type="text" name="fruitful_theme_options[h2_size]" id="h2-size" value ="<?php echo $options['h2_size']; ?>"/>
	<h4><?php _e( 'H3', 'fruitful' ); ?></h4><input type="text" name="fruitful_theme_options[h3_size]" id="h4-size" value ="<?php echo $options['h3_size']; ?>"/>
	<h4><?php _e( 'H4', 'fruitful' ); ?></h4><input type="text" name="fruitful_theme_options[h4_size]" id="h4-size" value ="<?php echo $options['h4_size']; ?>"/>
	<h4><?php _e( 'H5', 'fruitful' ); ?></h4><input type="text" name="fruitful_theme_options[h5_size]" id="h5-size" value ="<?php echo $options['h5_size']; ?>"/>
	<h4><?php _e( 'H6', 'fruitful' ); ?></h4><input type="text" name="fruitful_theme_options[h6_size]" id="h6-size" value ="<?php echo $options['h6_size']; ?>"/>	
	<h4><?php _e( 'P', 'fruitful' ); ?></h4><input type="text" name="fruitful_theme_options[p_size]" id="p-size" value ="<?php echo $options['p_size']; ?>"/>
	<?php
}





function fruitful_slider_options() {
	$options = fruitful_get_theme_options();
	?>
	<input type="button" id="view_all_options" class="button-secondary" value="View Options" /> 
	<div id="slider_main_options" class="slider-main-options">
		<div class="option_block"><h4><?php _e( 'Width', 'fruitful' ); ?></h4><input type="text" id="width-slider" name="fruitful_theme_options[s_width]" value="<?php echo $options['s_width']; ?>"/></div>		
		<div class="option_block"><h4><?php _e( 'Height', 'fruitful' ); ?></h4><input type="text" id="height-slider" name="fruitful_theme_options[s_height]" value="<?php echo $options['s_height']; ?>"/></div>		
		<div class="option_block"><h4><?php _e( 'Animation type', 'fruitful' ); ?></h4><?php get_select_fields('s_animation',$options, fruitful_slide_anim_list()); ?></div>	
		<div class="option_block"><h4><?php _e( 'Sliding direction, "horizontal" or "vertical"', 'fruitful' ); ?></h4><?php get_select_fields('s_direction',$options, fruitful_slide_direction_list()); ?></div>		
		<div class="option_block"><h4><?php _e( 'Reverse the animation direction', 'fruitful' ); ?></h4><?php get_select_fields('s_reverse',$options, fruitful_bool_list()); ?></div>		
		<div class="option_block"><h4><?php _e( 'Animate slider automatically', 'fruitful' ); ?></h4><?php get_select_fields('s_slideshow',$options, fruitful_bool_list()); ?></div>		
		<div class="option_block"><h4><?php _e( 'Set the speed of the slideshow cycling, in milliseconds', 'fruitful' ); ?></h4><input type="text" id="speed-slideshow" name="fruitful_theme_options[s_slideshowSpeed]" value="<?php echo $options['s_slideshowSpeed']; ?>"/></div>		
		<div class="option_block"><h4><?php _e( 'Set the speed of animations, in milliseconds', 'fruitful' ); ?></h4><input type="text" id="speed-animation" name="fruitful_theme_options[s_animationSpeed]" value="<?php echo $options['s_animationSpeed']; ?>"/></div>	
		<div class="option_block"><h4><?php _e( 'Set an initialization delay, in milliseconds', 'fruitful' ); ?></h4><input type="text" id="init-delay" name="fruitful_theme_options[s_initDelay]" value="<?php echo $options['s_initDelay']; ?>"/></div>	
		<div class="option_block"><h4><?php _e( 'Randomize slide order', 'fruitful' ); ?></h4><?php get_select_fields('s_randomize',$options, fruitful_bool_list()); ?></div>	
		<div class="option_block"><h4><?php _e( 'Manual control usage', 'fruitful' ); ?></h4><?php get_select_fields('s_controlnav',$options, fruitful_bool_list()); ?></div>	
	</div>
	<?php
}

function fruitful_get_slide($options, $id, $w, $h) {
	$out = '';
	$upload  = $options['slide_' . $id];
	
	$out .= '<li class="slide" id="slide_image_' . $id . '">';
		$out .= '<h4 class="slide-header" id="slide_header_'. $id .'">Slide #' . $id;
			$out .= '<span class="content-close-slide" id="content_slide_close_' . $id . '"></span>';
			//if ($upload != '') {
				$out .= '<span class="remove-slide" id="remove_slide_'.$id.'"></span>';
			//}
		$out .= '</h4>';
		
		$out .= '<div class="slide-content" id="slide_content_'. $id .'">';
			
			$out .= get_code_upload_images($upload, 'slide_' . $id, $w, $h, 'upload_slide_btn', 'reset_slide_btn', '', true);
		
		$out .= '</div>';
	$out .= '</li>';
	return $out;
}	

function fruitful_slider_images() {
	$options_slides = array_filter((array) get_option( 'fruitful_theme_slides_options' ));
	$options_order  = array_filter((array) get_option( 'fruitful_theme_slides_sort_options' ));
	
	$vcount_slide  = count($options_slides);
	$vcount_order = count($options_order);
	
	?>
		<div class="slides-btn">
			<span class="collapse_all">Collapse all</span>
			<span class="expand_all">Expand all</span>
		</div>
		<ul class="slides">
			<?php 
					/*Init First Slide for noraml work script*/
					if (($vcount_order != 0) && ($vcount_order == $vcount_slide) ) {
						foreach ($options_order as $value) {
							$index = str_replace("slide_image_", "", $value);
								if ($options_slides['slide_' . $index] != '') {
									echo fruitful_get_slide($options_slides, $index, 608, 300); 
								}
						}
					} else {
					
					if ($vcount_slide == 0) {
						echo fruitful_get_slide($options_slides, 1,608, 300); 
					}

					
					for ($i = 1; $i <= $vcount_slide; $i++) {
						    if ($options_slides['slide_' . $i] != '') {
								echo fruitful_get_slide($options_slides, $i, 608, 300); 
								
							}
						}
					}
			?>
		</ul>
		<input type="button" class="button-primary add_new_btn" value="Add New Slide" />
<?php
}

function fruitful_menu_style () {
	$options = fruitful_get_theme_options();
	?>
		<div class="box-options">
			<h4><?php _e( 'Button color ', 'fruitful' ); ?></h4>
			<div id="menubntcolor"><div style="background-color: <?php echo $options['menu_btn_color']; ?>"></div></div>
			<input type="text" id="menu_btn_color" name="fruitful_theme_options[menu_btn_color]" value="<?php echo $options['menu_btn_color']; ?>"/>
		</div>
		<div class="box-options">
			<h4><?php _e( 'Box-shadow color ', 'fruitful' ); ?></h4>
			<div id="menuboxshcolor"><div style="background-color: <?php echo $options['menu_boxsh_color']; ?>"></div></div>
			<input type="text" id="menu_boxsh_color" name="fruitful_theme_options[menu_boxsh_color]" value="<?php echo $options['menu_boxsh_color']; ?>"/>
		</div>	
		<div class="box-options">
			<h4><?php _e( 'Font color', 'fruitful' ); ?></h4>
			<div id="menufontcolor"><div style="background-color: <?php echo $options['menu_font_color']; ?>"></div></div>
			<input type="text" id="menu_font_color" name="fruitful_theme_options[menu_font_color]" value="<?php echo $options['menu_font_color']; ?>"/>
		</div>
		<div class="box-options">
			<h4><?php _e( 'Font color (Active, Hover)', 'fruitful' ); ?></h4>
			<div id="menufontcolorachvr"><div style="background-color: <?php echo $options['menu_hover_color']; ?>"></div></div>
			<input type="text" id="menu_hover_color" name="fruitful_theme_options[menu_hover_color]" value="<?php echo $options['menu_hover_color']; ?>"/>
		</div>
		<div class="box-options">
			<h4><?php _e( 'Text-shadow (Active, Hover)', 'fruitful' ); ?></h4>
			<div id="menutxtshcolor"><div style="background-color: <?php echo $options['menu_txtsh_color']; ?>"></div></div>
			<input type="text" id="menu_txtsh_color" name="fruitful_theme_options[menu_txtsh_color]" value="<?php echo $options['menu_txtsh_color']; ?>"/>
		</div>	
	<?php
}
	
function fruitful_get_background_color () {
	$options = fruitful_get_theme_options();
	?>
		<div id="colorSelector"><div style="background-color: <?php echo $options['background_color']; ?>"></div></div>
		<input type="text" id="background_color" name="fruitful_theme_options[background_color]" value="<?php echo $options['background_color']; ?>"/>
	<?php
}

/**
 * Renders the Theme Options administration screen.
 *
 * @since Fruitful theme 1.0
 */
function fruitful_theme_options_render_page() {
	?>
	<div class="wrap">
	<form method="post" action="/" enctype="multipart/form-data"  class="form-admin-fruitful" id="form-admin-fruitful">
		<div id="save_options" class="save-options"></div>	
		<div class="header">
			<?php screen_icon(); ?>
			<h2 class="title_theme"><?php printf( __( '%s Theme Options', 'fruitful' ), $theme_name ); ?></h2>
			<?php settings_errors(); ?>
		</div>
		
			<div class="content">
				<div class="menu-options">
					<ul>
						<li class="current"><a  id="item_0" href="javascript:void(0)" 	title="General Settings"><span id="menu_img_0"></span><?php _e( 'General Settings', 'fruitful' ); ?></a></li>
						<li><a  id="item_1" href="javascript:void(0)"	title="Background">	<span id="menu_img_1"></span><?php _e( 'Background', 'fruitful' ); ?></a></li>
						<li><a  id="item_2" href="javascript:void(0)" title="Logo">				<span id="menu_img_2"></span><?php _e( 'Logo',   'fruitful' ); ?></a></li>
						<li><a  id="item_3" href="javascript:void(0)" title="Menu">				<span id="menu_img_3"></span><?php _e( 'Menu', 'fruitful' ); ?></a></li>
						<li><a  id="item_4" href="javascript:void(0)" title="Fonts">			<span id="menu_img_4"></span><?php _e( 'Fonts', 'fruitful' ); ?></a></li>
						<li><a  id="item_5" href="javascript:void(0)" title="Slider">			<span id="menu_img_5"></span><?php _e( 'Slider', 'fruitful' ); ?></a></li>
						<li><a  id="item_6" href="javascript:void(0)" title="Social Links">	<span id="menu_img_6"></span><?php _e( 'Social Links', 'fruitful' ); ?></a></li>
						<li><a  id="item_7" href="javascript:void(0)" title="Footer">			<span id="menu_img_7"></span><?php _e( 'Footer', 'fruitful' ); ?></a></li>
					</ul>
				</div> 	
		
				<?php
					settings_fields( 'fruitful_options' );
					custom_do_settings_sections( 'theme_options');
				?>
		
		</div>
		
		<div class="footer">
			<?php submit_button();  ?>
			<input name="reset" type="reset" class="button-secondary reset-btn" value="<?php esc_attr_e('Reset Defaults', 'fruitful'); ?>" />		
			<div id="dialog-confirm" title="Reset all theme options?">
				<p>
					<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
					<?php _e( 'Theme settings will be reset to default.', 'fruitful' ); ?>
				</p>
			</div>
		</div>
		  <input type="hidden" name="action"    value="fruitful_theme_options_action" />
		  <input type="hidden" name="security" value="<?php echo wp_create_nonce('fruitful_theme_data'); ?>" />
		</form>
		
		<div id="sidebar_promo" class="sidebar-promo">
			<p><?php _e( 'If you faced with any problems or have a question you always can contact us with request.', 'fruitful' ); ?></p>
			<p><?php _e( 'Our team can propose live consultation, web development,  web design, customization of our products.', 'fruitful' ); ?></p>
			<a class="button_help" href="mailto:support@fruitfulcode.com" target="_blank"><?php _e( 'Support', 'fruitful' ); ?></a>
		</div>
	</div>
	<?php
}


add_action('wp_ajax_fruitful_reset_btn', 'fruitful_reset_action');
function fruitful_reset_action() {
	$upload_dir = wp_upload_dir(); 
	$dir = $upload_dir['basedir'] . "/fruitfulimg"; 

	delete_option('fruitful_theme_slides_sort_options');
	delete_option('fruitful_theme_slides_options');
	delete_option('fruitful_theme_options', '');
	
	remove_dir ($dir);
	die();
}

add_action('wp_ajax_sorting_slides_image', 'fruitful_slide_sort');
function fruitful_slide_sort() {
	$data = (array) $_POST['data'];
	$data = array_filter($data);
	$type = $_POST['type'];
	
	if  ($type == "sortbeforestop") {
		 update_option('fruitful_theme_slides_sort_options', $data);
	}
	die();
}

add_action('wp_ajax_fruitful_add_new_slide_action', 'fruitful_new_slide');
function fruitful_new_slide() {
	$options_slides = (array) get_option( 'fruitful_theme_slides_options' );
	$data 	 = $_POST['data'];
	echo fruitful_get_slide($options_slides, $data, 608, 300); 
	die();
}

add_action('wp_ajax_fruitful_theme_options_slider', 'fruitful_slides_save');
function fruitful_slides_save() {
	$type   = $_POST['type'];
	echo file_upload($type, '/fruitfulimg/slides/', 'fruitful_theme_slides_options', 608, 300);
	die();  
}

add_action('wp_ajax_fruitful_theme_options_action', 'fruitful_data_save');
function fruitful_data_save() {
	$type = $_POST['type'];
	
	if ($type != "")  {
	   echo file_upload($type);
	   die();  
	}
	 else {
		$data = $_POST['fruitful_theme_options'];
	
	    if(!is_array($options)) {
	        $options = array();
	    } else {
	        $options = get_option('fruitful_theme_options');
	    }
	 
	    if(!empty($data)) {
	        $compare_new	= array_diff ($options, $data);
	        $compare_old   	= array_diff ($data, $options);
	        $compare 	 		= array_merge ($compare_new, $compare_old);
	    } else {
	        $compare = array();
	    }
	         
	    if(!empty($compare)) {
	        if(update_option('fruitful_theme_options', $compare)) {
	           die('1');
	        } else {
	           die('0');
	        }
	    } else {
	           die('1');  
	    }
		}
}
?>