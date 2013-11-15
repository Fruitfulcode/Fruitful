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
		'fruitful_options', 		// Options group, see settings_fields() call in fruitful_theme_options_render_page()
		'fruitful_theme_options', 	// Database option, see fruitful_get_theme_options()
		'' // The sanitization callback, see fruitful_theme_options_validate()
	);
	// Register our settings field group
	add_settings_section('general',			'',  '__return_false', 'theme_options' );
	add_settings_section('background',		'',  '__return_false', 'theme_options' );
	add_settings_section('logo', 			'',  '__return_false', 'theme_options' );
	add_settings_section('menu', 			'',  '__return_false', 'theme_options' );
	add_settings_section('fonts', 			'',  '__return_false', 'theme_options' );
	add_settings_section('slider', 			'',  '__return_false', 'theme_options' );
	add_settings_section('links', 			'',  '__return_false', 'theme_options' );
	add_settings_section('footer', 			'',  '__return_false', 'theme_options' );
	add_settings_section('css', 			'',  '__return_false', 'theme_options' );
	
	add_settings_field( 'general_rs', 		__( 'Layout', 	'fruitful' ),	'fruitful_get_responsive_design',	'theme_options',  'general', array('info' => __( 'Theme supported 2 types of html layout. Default responsive  setting which adapt for mobile devices and static page with fixed width. Uncheck arrow below if you need static website display. ', 'fruitful' )));
	add_settings_field( 'general_cm',		__( 'Comments', 'fruitful' ), 	'fruitful_get_general_comment',  	'theme_options',  'general', array('info' => __( 'If you want to display comments on your post page or page, select options below.', 'fruitful' )));
	add_settings_field( 'general_hd',		__( 'Header', 	'fruitful' ), 	'fruitful_get_general_header',  	'theme_options',  'general', array('info' => __( 'Options relating to the website header', 'fruitful' )));
	add_settings_field( 'general_ds',		__( 'Default theme style css', 'fruitful' ),'fruitful_get_style_theme',  		'theme_options',  'general', array('info' => __( 'Orange style by default, enable this option to see it. Theme option for styling is not working, if this option enable.', 'fruitful' )));
	add_settings_field( 'general_rb',		__( 'Reset all options to default', 'fruitful' ),	'fruitful_reset_btn', 		  'theme_options',  'general', array('info' => __( 'Reset Button. ', 'fruitful' )));
	
	
	
	add_settings_field( 'background_image', __( 'Background Image', 'fruitful' ), 'fruitful_get_background_img',  'theme_options',  'background', array('info' => __( 'Upload your background image for site background. (Supported files .png, .jpg, .gif)', 'fruitful' )));
	add_settings_field( 'background_color', __( 'Background Color ', 'fruitful' ), 'fruitful_get_background_color', 'theme_options', 'background', array('info' => __( 'Choose color for body background', 'fruitful' )));
		
	add_settings_field( 'logo_image', 		__( 'Upload your logo Image', 'fruitful' ), 	'fruitful_get_logo_img', 	'theme_options', 'logo', 		array('info' => __( 'Default theme logo is just a sample. Upload logo image for your website. (Supported files .png, .jpg, .gif)', 'fruitful' )));
	//add_settings_field( 'logo_size', 		__( 'Logo Size', 'fruitful' ), 		'fruitful_get_logo_wh',	 	'theme_options', 'logo', 		array('info' => __( 'Specify resolution for your logo image. Our theme will crop (timthumb) your image for need size.', 'fruitful' )) );
	add_settings_field( 'fav_icon', 		__( 'Favicon', 'fruitful' ), 		'fruitful_get_fav_icon', 	'theme_options', 'logo', 		array('info' => __( 'Upload needed image for site favicon. (Supported files .ico (16x16))', 'fruitful' )));
	add_settings_field( 'menu_style',		__( 'Menu css styling', 'fruitful' ),	'fruitful_menu_style',		'theme_options', 'menu',    	array('info' => __( 'Choose styles for main menu.', 'fruitful' )) );
	add_settings_field( 'fonts_options', 	__( 'Fonts', 'fruitful' ), 	'fruitful_fonts_options',	'theme_options', 'fonts', 		array('info' => __( 'Popular web safe font collection, select and use for your needs.', 'fruitful' )) );
	
	add_settings_field( 'fonts_headers', 	__( 'Headers', 'fruitful' ),'fruitful_fonts_headers',	'theme_options', 'fonts', array('info' => __( 'Choose font-family for all headlines.', 'fruitful' )) );
	add_settings_field( 'fonts_menu', 		__( 'Menu',    'fruitful' ),'fruitful_fonts_menu',		'theme_options', 'fonts', array('info' => __( 'Choose font-family for primary menu.', 'fruitful' )) );
	add_settings_field( 'fonts_content', 	__( 'Body', 'fruitful' ),   'fruitful_fonts_content',	'theme_options', 'fonts', array('info' => __( 'Choose font-family for <body>.', 'fruitful' )) );
	
	add_settings_field( 'fonts_size', 		__( 'Font size', 'fruitful' ), 		'fruitful_fonts_size',		'theme_options', 'fonts',  array('info' => __( 'Choose font size for specific html elements. Set size as number, without px.', 'fruitful' )) );
	add_settings_field( 'slider_select',	__( 'Slider', 'fruitful' ),	'fruitful_slider_select',	'theme_options', 'slider', array('info' => __( 'Select a slider type that will be used by default.', 'fruitful' )) );
	add_settings_field( 'slider_options',	__( 'Slider Options', 'fruitful' ),	'fruitful_slider_options',	'theme_options', 'slider', array('info' => __( 'Choose needed options for slider: animation type, sliding direction, speed of animations, etc', 'fruitful' )) );
	add_settings_field( 'slider_image',		__( 'Slides', 'fruitful' ), 		'fruitful_slider_images',	'theme_options', 'slider', array('info' => __( 'Add images to slider (Supported files .png, .jpg, .gif). If you want to change order, just drag and drop it. Image size for slides is original from media gallery, please upload images in same size, to get best display on page. To display slider in needed place use shortcode [slider]. Current theme version support only one slider per website. ', 'fruitful' )) );
	add_settings_field( 'socials_links', 	__( 'Socials Links', 'fruitful' ), 	'fruitful_settings_field_socials_links', 'theme_options', 'links', array('info' => __( 'Add link to your social media profiles. Icons with link will be display in footer.', 'fruitful' )) );
	add_settings_field( 'footer_text_copy',	__( 'Footer options', 'fruitful' ), 'fruitful_settings_field_footer_text', 'theme_options',   'footer', array('info' => __( 'Replace default theme copyright information and links.', 'fruitful' )) );
	
	add_settings_field( 'csutom_css',		__( 'Custom CSS', 'fruitful' ), 'fruitful_settings_field_custom_css', 'theme_options', 'css' , array('info' => __( 'Theme has two css files style.css and fixed-style.css which use default styles for front-end responsive and static layout. Do not edit theme default css files, use textarea editor below for overwriting all css styles.', 'fruitful' )) );
	
	if(!get_option( 'fruitful_theme_options' )) {
		add_option( 'fruitful_theme_options', fruitful_get_theme_options());
	}
}
	
add_action( 'admin_init', 'fruitful_theme_options_init' );

add_action( 'admin_enqueue_scripts', 'add_admin_options_and_styles' );
function add_admin_options_and_styles($hook) {
	if( 'appearance_page_theme_options' != $hook ) return;
	fruitful_add_jquery_script();
	fruitful_add_admin_style();
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
	$theme_page = add_theme_page(
		__( 'Fruitful Theme Options', 'fruitful' ),   	// Name of page
		__( 'Theme Options', 'fruitful' ),   			// Label in menu
			'edit_theme_options',          	 			// Capability required
			'theme_options',                     		// Menu slug, used to uniquely identify the page
			'fruitful_theme_options_render_page' 		// Function that renders the options page
	);
}


add_action( 'admin_bar_menu', 'fruitful_add_custom_link_options', 1000 );
function fruitful_add_custom_link_options() {
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
	$defaults = fruitful_get_default_array();
	$defaults = apply_filters( 'fruitful_default_theme_options', $defaults );
	$options  = wp_parse_args( $saved, $defaults );
	$options = array_intersect_key( $options, $defaults );
	return $options;
}

function fruitful_get_responsive_design() { 
	$options = fruitful_get_theme_options();
	?>
	<div class="box-option">
			<label for="responsive_ch"><input type="checkbox" name="fruitful_theme_options[responsive]" id="responsive_ch" <?php checked( 'on', esc_attr($options['responsive'])); ?> />
			<?php _e( 'Responsive', 'fruitful' ); ?>
			</label>
	</div>
<?php }

function fruitful_get_general_comment() {
	$options = fruitful_get_theme_options();
	?>
		<div class="box-option">
			<label for="postcomment_ch"><input type="checkbox" name="fruitful_theme_options[postcomment]" id="postcomment_ch" <?php checked( 'on', esc_attr($options['postcomment'])); ?> />
			<?php _e( 'Display comment on posts page', 'fruitful' ); ?>
			</label>
		</div>
		<div class="box-option">
			<label for="pagecomment_ch"><input type="checkbox" name="fruitful_theme_options[pagecomment]" id="pagecomment_ch" <?php checked( 'on', esc_attr($options['pagecomment'])); ?> />
			<?php _e( 'Display comment on page', 'fruitful' ); ?>
			</label>
		</div>
	<?php	
}

function fruitful_get_general_header() {
	$options = fruitful_get_theme_options();
	?>
		<div class="box-option">
			<label for="is_fixed_header_ch"><input type="checkbox" name="fruitful_theme_options[is_fixed_header]" id="is_fixed_header_ch" <?php checked( 'on', esc_attr($options['is_fixed_header'])); ?> />
			<?php _e( 'Fixed Header', 'fruitful' ); ?>
			</label>
		</div>
	<?php
}

function fruitful_get_style_theme() {
	$options = fruitful_get_theme_options();
	?>
		<div class="box-option">
			<label for="style_theme"><input type="checkbox" name="fruitful_theme_options[styletheme]" id="style_theme" <?php checked( 'on', esc_attr($options['styletheme'])); ?> />
			<?php _e( 'Enable default css', 'fruitful' ); ?>
			</label>
		</div>
	<?php	
}

function fruitful_reset_btn() { 
	?>
	<div class="box-option">
		<input name="reset" type="reset" class="button-secondary reset-btn" value="<?php esc_attr_e('Reset Defaults', 'fruitful'); ?>" />		
	</div>	
	<?php	
}


function fruitful_settings_field_socials_links() {
	$options = fruitful_get_theme_options();
	?>
	<div class="socials">
		<h4>Facebook</h4>		<input id="facebook_url" 	name="fruitful_theme_options[facebook_url]" type="text"   value="<?php echo esc_url( $options['facebook_url'] ); ?>"/>
		<h4>Twitter</h4>		<input id="twitter_url" 	name="fruitful_theme_options[twitter_url]" 	type="text"   value="<?php echo esc_url( $options['twitter_url'] ); ?>"/>
		<h4>LinkedIn</h4>		<input id="linkedin_url" 	name="fruitful_theme_options[linkedin_url]" type="text"   value="<?php echo esc_url( $options['linkedin_url'] ); ?>"/>
		<h4>MySpace</h4>		<input id="myspace_url" 	name="fruitful_theme_options[myspace_url]" 	type="text"   value="<?php echo esc_url( $options['myspace_url'] ); ?>"/>
		<h4>Google Plus+</h4>	<input id="googleplus_url" 	name="fruitful_theme_options[googleplus_url]" type="text" value="<?php echo esc_url( $options['googleplus_url'] ); ?>"/>
		<h4>Dribbble</h4>		<input id="dribbble_url" 	name="fruitful_theme_options[dribbble_url]" type="text"   value="<?php echo esc_url( $options['dribbble_url'] ); ?>"/>
		<h4>Skype</h4>			<input id="skype_link" 		name="fruitful_theme_options[skype_link]" 	type="text"   value="<?php echo esc_url( $options['skype_link'] ); ?>"/>
		<h4>Flickr</h4>			<input id="flickr_link" 	name="fruitful_theme_options[flickr_link]" 	type="text"   value="<?php echo esc_url( $options['flickr_link'] ); ?>"/>
		<h4>You Tube</h4>		<input id="youtube_url" 	name="fruitful_theme_options[youtube_url]"	type="text"   value="<?php echo esc_url( $options['youtube_url'] ); ?>"/>
		<h4>RSS</h4>			<input id="rss_link" 		name="fruitful_theme_options[rss_link]" 	type="text"   value="<?php echo esc_url( $options['rss_link'] ); ?>"/>
	</div>
	<?php
}	
	
function fruitful_settings_field_footer_text() {
	$options = fruitful_get_theme_options();
	?>
	<h4><?php _e( 'Copyright section', 'fruitful' ); ?></h4><textarea class="large-text" type="text" name="fruitful_theme_options[footer_text]" id="footer-text" cols="50" rows="20" /><?php echo stripslashes($options['footer_text']); ?></textarea>
<?php
}

function fruitful_settings_field_custom_css() {
	$options = fruitful_get_theme_options();
	?>
	<h4><?php _e( 'Styles editor', 'fruitful' ); ?></h4><textarea class="large-text" type="text" name="fruitful_theme_options[custom_css]" id="css-text" cols="50" rows="30" /><?php echo stripslashes($options['custom_css']); ?></textarea>
<?php
}

function fruitful_get_background_img () {
	$options = fruitful_get_theme_options();
	$upload  = $options['backgroung_img'];
	
	echo fruitful_get_box_upload_image($upload, 'backgroung_img'); 
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

	echo fruitful_get_box_upload_image($upload, 'logo_img', 'upload_btn', 'reset_btn', 'logo');
}


function fruitful_get_fav_icon () {
	$options = fruitful_get_theme_options();
	$upload  = $options['fav_icon'];

	echo fruitful_get_box_upload_image($upload, 'fav_icon', 'upload_btn', 'reset_btn', 'favicon');
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
	/*No Options*/
	?>
	
	<?php
}

function fruitful_fonts_headers () {
	$options = fruitful_get_theme_options();
	?>
    <div class="text_fonts">
		<div id="header_sample_font" class="sample_text">Sample Font</div>
		<?php fruitful_get_select_fields('h_font_family',$options, fruitful_fonts_list(), 'select-fonts'); ?>
	</div>

	<?php
}

function fruitful_fonts_menu () {
	$options = fruitful_get_theme_options();
	?>
    <div class="text_fonts">
		<div id="menu_sample_font" class="sample_text">Sample Font</div>
		<?php fruitful_get_select_fields('m_font_family',$options, fruitful_fonts_list(), 'select-fonts'); ?>
	</div>
	<?php
}

function fruitful_fonts_content () {
	$options = fruitful_get_theme_options();
	?>
    <div class="text_fonts">
		<div id="content_sample_font" class="sample_text">Sample Font</div>
		<?php fruitful_get_select_fields('p_font_family', $options, fruitful_fonts_list(), 'select-fonts'); ?>
	</div>		
	<?php
}

function fruitful_fonts_size () {
	$options = fruitful_get_theme_options();
	?>
    <h4><?php _e( 'H1',   'fruitful' ); ?></h4><input type="text" name="fruitful_theme_options[h1_size]" id="h1-size" value ="<?php echo intval($options['h1_size']); ?>"/>
	<h4><?php _e( 'H2',   'fruitful' ); ?></h4><input type="text" name="fruitful_theme_options[h2_size]" id="h2-size" value ="<?php echo intval($options['h2_size']); ?>"/>
	<h4><?php _e( 'H3',   'fruitful' ); ?></h4><input type="text" name="fruitful_theme_options[h3_size]" id="h4-size" value ="<?php echo intval($options['h3_size']); ?>"/>
	<h4><?php _e( 'H4',   'fruitful' ); ?></h4><input type="text" name="fruitful_theme_options[h4_size]" id="h4-size" value ="<?php echo intval($options['h4_size']); ?>"/>
	<h4><?php _e( 'H5',   'fruitful' ); ?></h4><input type="text" name="fruitful_theme_options[h5_size]" id="h5-size" value ="<?php echo intval($options['h5_size']); ?>"/>
	<h4><?php _e( 'H6',   'fruitful' ); ?></h4><input type="text" name="fruitful_theme_options[h6_size]" id="h6-size" value ="<?php echo intval($options['h6_size']); ?>"/>	
	<h4><?php _e( 'Menu', 'fruitful' ); ?></h4><input type="text" name="fruitful_theme_options[m_size]"  id="m-size"  value ="<?php echo intval($options['m_size']); ?>"/>	
	<h4><?php _e( 'P', 'fruitful' ); ?></h4><input type="text"    name="fruitful_theme_options[p_size]"  id="p-size"  value ="<?php echo intval($options['p_size']); ?>"/>
	<?php
}



function fruitful_slider_select() {
	$options = fruitful_get_theme_options();
	fruitful_get_select_fields('select_slider',$options, fruitful_slide_select(), 'select-slider'); 
 }


function fruitful_slider_options() {
	$options = fruitful_get_theme_options();
	?>
	<input type="button" id="view_all_options" class="button-secondary" value="View Options" /> 
		<div id="slider_main_options" class="slider-main-options">
			<div class="no-slider-select">
				<div class="option_block"><h4><?php _e( 'No Slider Select!', 'fruitful' ); ?></h4></div>
			</div>	
			<div class="flex-slider">
				<div class="option_block"><h4><?php _e( 'Animation type', 'fruitful' ); ?></h4><?php fruitful_get_select_fields('s_animation',$options, fruitful_slide_anim_list()); ?></div>	
				<div class="option_block"><h4><?php _e( 'Sliding direction, "horizontal" or "vertical"', 'fruitful' ); ?></h4><?php fruitful_get_select_fields('s_direction',$options, fruitful_slide_direction_list()); ?></div>		
				<div class="option_block"><h4><?php _e( 'Reverse the animation direction', 'fruitful' ); ?></h4><?php fruitful_get_select_fields('s_reverse',$options, fruitful_bool_list()); ?></div>		
				<div class="option_block"><h4><?php _e( 'Animate slider automatically', 'fruitful' ); ?></h4><?php fruitful_get_select_fields('s_slideshow',$options, fruitful_bool_list()); ?></div>		
				<div class="option_block"><h4><?php _e( 'Set the speed of the slideshow cycling, in milliseconds', 'fruitful' ); ?></h4><input type="text" id="speed-slideshow" name="fruitful_theme_options[s_slideshowSpeed]" value="<?php echo $options['s_slideshowSpeed']; ?>"/></div>		
				<div class="option_block"><h4><?php _e( 'Set the speed of animations, in milliseconds', 'fruitful' ); ?></h4><input type="text" id="speed-animation" name="fruitful_theme_options[s_animationSpeed]" value="<?php echo $options['s_animationSpeed']; ?>"/></div>	
				<div class="option_block"><h4><?php _e( 'Set an initialization delay, in milliseconds', 'fruitful' ); ?></h4><input type="text" id="init-delay" name="fruitful_theme_options[s_initDelay]" value="<?php echo $options['s_initDelay']; ?>"/></div>	
				<div class="option_block"><h4><?php _e( 'Randomize slide order', 'fruitful' ); ?></h4><?php fruitful_get_select_fields('s_randomize',$options, fruitful_bool_list()); ?></div>	
				<div class="option_block"><h4><?php _e( 'Manual control usage', 'fruitful' ); ?></h4><?php fruitful_get_select_fields('s_controlnav',$options, fruitful_bool_list()); ?></div>	
			</div>
			<div class="nivo-slider">
				<div class="option_block"><h4><?php _e( 'Slider Skins', 'fruitful' ); ?></h4><?php fruitful_get_select_fields('nv_skins',$options, fruitful_slide_skins_select()); ?></div>	
				<div class="option_block"><h4><?php _e( 'Effect', 'fruitful' ); ?></h4><?php fruitful_get_select_fields('nv_animation',$options, fruitful_flex_effect()); ?></div>	
				<div class="option_block"><h4><?php _e( 'For slice animations', 'fruitful' ); ?></h4><input type="text" id="nv-slice" name="fruitful_theme_options[nv_slice]" value="<?php echo $options['nv_slice']; ?>"/></div>						
				<div class="option_block"><h4><?php _e( 'For box animations (Cols)', 'fruitful' ); ?></h4><input type="text" id="nv-boxCols" name="fruitful_theme_options[nv_boxCols]" value="<?php echo $options['nv_boxCols']; ?>"/></div>						
				<div class="option_block"><h4><?php _e( 'For box animations (Rows)', 'fruitful' ); ?></h4><input type="text" id="nv-boxRows" name="fruitful_theme_options[nv_boxRows]" value="<?php echo $options['nv_boxRows']; ?>"/></div>						
				<div class="option_block"><h4><?php _e( 'Slide transition speed', 'fruitful' ); ?></h4><input type="text" id="nv-animSpeed" name="fruitful_theme_options[nv_animSpeed]" value="<?php echo $options['nv_animSpeed']; ?>"/></div>										
				<div class="option_block"><h4><?php _e( 'How long each slide will show', 'fruitful' ); ?></h4><input type="text" id="nv-pauseTime" name="fruitful_theme_options[nv_pauseTime]" value="<?php  echo $options['nv_pauseTime']; ?>"/></div>										
				<div class="option_block"><h4><?php _e( 'Set starting Slide (0 index)', 'fruitful' ); ?></h4><input type="text" id="nv-startSlide" name="fruitful_theme_options[nv_startSlide]" value="<?php echo $options['nv_startSlide']; ?>"/></div>										
				<div class="option_block"><h4><?php _e( 'Next & Prev navigation', 'fruitful' ); ?></h4><?php fruitful_get_select_fields('nv_directionNav',$options, fruitful_bool_list()); ?></div>										
				<div class="option_block"><h4><?php _e( '1,2,3... navigation', 'fruitful' ); ?></h4><?php fruitful_get_select_fields('nv_controlNav',$options, fruitful_bool_list()); ?></div>														
				<div class="option_block"><h4><?php _e( 'Use thumbnails for Control Nav', 'fruitful' ); ?></h4><?php fruitful_get_select_fields('nv_controlNavThumbs',$options, fruitful_bool_list()); ?></div>														
				<div class="option_block"><h4><?php _e( 'Stop animation while hovering', 'fruitful' ); ?></h4><?php fruitful_get_select_fields('nv_pauseOnHover',$options, fruitful_bool_list()); ?></div>														
				<div class="option_block"><h4><?php _e( 'Force manual transitions', 'fruitful' ); ?></h4><?php fruitful_get_select_fields('nv_manualAdvance',$options, fruitful_bool_list()); ?></div>														
				<div class="option_block"><h4><?php _e( 'Prev directionNav text',  'fruitful'); ?></h4><input type="text" id="nv-prevText" name="fruitful_theme_options[nv_prevText]" value="<?php echo esc_html($options['nv_prevText']); ?>"/></div>																		
				<div class="option_block"><h4><?php _e( 'Next directionNav text',  'fruitful'); ?></h4><input type="text" id="nv-nextText" name="fruitful_theme_options[nv_nextText]" value="<?php echo esc_html($options['nv_nextText']); ?>"/></div>																		
				<div class="option_block"><h4><?php _e( 'Start on a random slide', 'fruitful'); ?></h4><?php fruitful_get_select_fields('nv_randomStart',$options, fruitful_bool_list()); ?></div>																		
			</div>
	</div>
	
	<?php
}

function fruitful_get_slide($ind, $id, $link_url = null) {
	$out = '';
	$out .= '<li class="slide" id="slide-image-' . $ind . '">';
		$out .= '<h4 class="slide-header" id="slide-header-'. $ind .'">Slide #' . $ind;
			$out .= '<span class="content-close-slide" id="content-slide-close_' . $ind . '"></span>';
				$out .= '<span class="remove-slide" id="remove-slide-'.$ind.'"></span>';
		$out .= '</h4>';
		
		$out .= '<div class="slide-content" id="slide-content-'. $ind .'">';
			$out .= fruitful_get_box_upload_slide($id, $link_url, $ind);
		$out .= '</div>';
	$out .= '</li>';
	return $out;
}	

function fruitful_slider_images() {
	$slides = get_option( 'fruitful_theme_options' );
	$vcount_slides = 0;
	if(isset($slides['slides']) && ($slides['slides'] != '')) {
		$vcount_slides  = count($slides['slides']); 
	}
	?>
		<div class="slides-btn">
			<span class="collapse_all"><?php _e('Collapse all', 'fruitful'); ?></span>
			<span class="expand_all"><?php _e('Expand all', 'fruitful'); ?></span>
		</div>
		<ul class="slides">
			<?php 
					/*Init First Slide for noraml work script*/
					if ($vcount_slides == 0) {
						echo fruitful_get_slide(1, -1); 
					} else {
						foreach ($slides['slides'] as $key=>$slide) {
							$slide_inndex = -1;
							$attach_id 	  = $slide['attach_id'];
							$link_url   = null;
							
							$slide_inndex = trim(substr($key, strrpos($key, '-')+1, 5));
							if (isset($slide['link'])) {
								$link_url = $slide['link'];
							}
							echo fruitful_get_slide($slide_inndex, $attach_id, esc_url($link_url)); 
						}
					}
			?>
		</ul>
		<input type="button" class="button-primary add_new_btn" value="<?php _e('Add New Slide', 'fruitful'); ?>" />
<?php
}

function fruitful_menu_style () {
	$options = fruitful_get_theme_options();
	?>
		<div class="box-options">
			<h4><?php _e( 'Menu background-color', 'fruitful' ); ?></h4>
			<div id="menubgcolor"><div style="background-color: <?php echo esc_attr($options['menu_bg_color']); ?>"></div></div>
			<input type="text" id="menu_bg_color" name="fruitful_theme_options[menu_bg_color]" value="<?php echo esc_attr($options['menu_bg_color']); ?>"/>
		</div>
		<div class="box-options">
			<h4><?php _e( 'Menu button background-color', 'fruitful' ); ?></h4>
			<div id="menubntcolor"><div style="background-color: <?php echo esc_attr($options['menu_btn_color']); ?>"></div></div>
			<input type="text" id="menu_btn_color" name="fruitful_theme_options[menu_btn_color]" value="<?php echo esc_attr($options['menu_btn_color']); ?>"/>
		</div>
		<div class="box-options">
			<h4><?php _e( 'Default font color', 'fruitful' ); ?></h4>
			<div id="menufontcolor"><div style="background-color: <?php echo esc_attr($options['menu_font_color']); ?>"></div></div>
			<input type="text" id="menu_font_color" name="fruitful_theme_options[menu_font_color]" value="<?php echo esc_attr($options['menu_font_color']); ?>"/>
		</div>
		<div class="box-options">
			<h4><?php _e( 'Font color for active and :hover state', 'fruitful' ); ?></h4>
			<div id="menufontcolorachvr"><div style="background-color: <?php echo esc_attr($options['menu_hover_color']); ?>"></div></div>
			<input type="text" id="menu_hover_color" name="fruitful_theme_options[menu_hover_color]" value="<?php echo esc_attr($options['menu_hover_color']); ?>"/>
		</div>
	<?php
}
	
function fruitful_get_background_color () {
	$options = fruitful_get_theme_options();
	?>
		<div id="colorSelector"><div style="background-color: <?php echo esc_attr($options['background_color']); ?>"></div></div>
		<input type="text" id="background_color" name="fruitful_theme_options[background_color]" value="<?php echo esc_attr($options['background_color']); ?>"/>
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
			<h2 class="title_theme"><?php _e( 'Theme Options', 'fruitful' ); ?></h2> 
			<?php submit_button(); ?>
			<?php settings_errors(); ?>
		</div>
		
			<div class="content">
				<div class="menu-options">
					<ul>
						<li class="current"><a  id="item_0" href="javascript:void(0)" 	title="General Settings"><span id="menu_img_0"></span><?php _e( 'General Settings', 'fruitful' ); ?></a></li>
						<li><a  id="item_1" href="javascript:void(0)" title="Background">		<span id="menu_img_1"></span><?php _e( 'Background', 'fruitful' ); ?></a></li>
						<li><a  id="item_2" href="javascript:void(0)" title="Logo">				<span id="menu_img_2"></span><?php _e( 'Logo',   'fruitful' ); ?></a></li>
						<li><a  id="item_3" href="javascript:void(0)" title="Menu">				<span id="menu_img_3"></span><?php _e( 'Menu', 'fruitful' ); ?></a></li>
						<li><a  id="item_4" href="javascript:void(0)" title="Fonts">			<span id="menu_img_4"></span><?php _e( 'Fonts', 'fruitful' ); ?></a></li>
						<li><a  id="item_5" href="javascript:void(0)" title="Slider">			<span id="menu_img_5"></span><?php _e( 'Slider', 'fruitful' ); ?></a></li>
						<li><a  id="item_6" href="javascript:void(0)" title="Social Links">		<span id="menu_img_6"></span><?php _e( 'Social Links', 'fruitful' ); ?></a></li>
						<li><a  id="item_7" href="javascript:void(0)" title="Footer">			<span id="menu_img_7"></span><?php _e( 'Footer', 'fruitful' ); ?></a></li>
						<li><a  id="item_8" href="javascript:void(0)" title="CSS">		<span id="menu_img_8"></span><?php _e( 'Custom CSS', 'fruitful' ); ?></a></li>
					</ul>
				</div> 	
				<?php
					settings_fields( 'fruitful_options' );
					fruitful_custom_do_settings_sections( 'theme_options');
				?>
		
		</div>
		
		<div class="footer">
			<?php submit_button();  ?>
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
		
		<div id="sidebar-promo" class="sidebar-promo">
			<h3><?php _e('Contact support', 'fruitful'); ?></h3>
			<p><?php _e( 'If you faced with any problems, have a question or suggestion you always can contact us with any request on our website <a href="http://fruitfulcode.com">fruitfulcode.com</a>', 'fruitful' ); ?></p>
		</div>
	</div>
	<?php
}


add_action('wp_ajax_fruitful_reset_btn', 'fruitful_reset_action');
function fruitful_reset_action() {
	delete_option('fruitful_theme_options', '');
	die();
}


add_action('wp_ajax_fruitful_add_new_slide_action', 'fruitful_new_slide');
function fruitful_new_slide() {
	$slides = (array) get_option( 'fruitful_theme_slides_options' );
	$data 	 = $_POST['data'];
	echo fruitful_get_slide($data, -1, ''); 
	die();
}

add_action('wp_ajax_fruitful_theme_options_action', 'fruitful_data_save');
function fruitful_data_save() {
	$data = $_POST['fruitful_theme_options'];
	
	if (!isset($data['responsive'])) 	  {$data['responsive'] 	= 'off'; }
	if (!isset($data['postcomment'])) 	  {$data['postcomment'] = 'off'; }
	if (!isset($data['pagecomment'])) 	  {$data['pagecomment'] = 'off'; }
	if (!isset($data['is_fixed_header'])) {$data['is_fixed_header'] = 'off'; }
	if (!isset($data['styletheme'])) 	  {$data['styletheme'] 		= 'off'; }
	if (!isset($data['bg_repeating'])) 	  {$data['bg_repeating'] 	= 'off'; }
	
	if(!empty($data)) {
	   if(update_option('fruitful_theme_options', $data)) {
	           die('1');
	        } else {
	           die('0');
	        }
	    } else {
	           die('1');  
	    }
}
?>