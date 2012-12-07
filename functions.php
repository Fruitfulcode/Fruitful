<?php
/**
 * Fruitful theme functions and definitions
 *
 * @package Fruitful theme
 * @since Fruitful theme 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Fruitful theme 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 960; /* pixels */

if ( ! function_exists( 'fruitful_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Fruitful theme 1.0
 */
 
define('ADMIN_JQS',  	get_template_directory_uri() . '/inc/js/' );
define('ADMIN_STYLE',  get_template_directory_uri() . '/inc/css/' );
define('GENERAL', 		TEMPLATEPATH . '/inc/');
define('GENERAL_FUNCTIONS',	TEMPLATEPATH . '/inc/functions/');


function fruitful_setup() {
	/**
	 * Custom template tags for this theme.
	 */
	require( GENERAL. 'template-tags.php' );
	require( GENERAL. 'widgets.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( GENERAL . 'tweaks.php' );
	require( GENERAL_FUNCTIONS . 'fruitful-function.php' );
	
	/**
	 * Custom Theme Options
	 */
	require( GENERAL . 'theme-options/theme-options.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Fruitful theme, use a find and replace
	 * to change 'fruitful' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'fruitful', get_template_directory() . '/languages' );
	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );
	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'fruitful' ),
	) );

	/**
	 * Add support for the Aside Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', ) );
}
endif; // fruitful_setup
add_action( 'after_setup_theme', 'fruitful_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Fruitful theme 1.0
 */
function fruitful_widgets_init() {
	register_widget( 'Fruitful_Widget_News_Archive' );
	
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'fruitful' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Blog Right Sidebar', 'fruitful' ),
		'id' => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Single Page Right Sidebar', 'fruitful' ),
		'id' => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}


add_action( 'widgets_init', 'fruitful_widgets_init' );

/**
 * Enqueue scripts and styles
 */
 function fruitful_scripts() {
		wp_deregister_script	("jquery");
		wp_register_script		("jquery", "http://code.jquery.com/jquery-1.8.0.min.js", false, "1.8.0", true);
		wp_enqueue_script	("jquery");
	
	wp_enqueue_style( 'slider', 	get_template_directory_uri() . '/js/slider/slider.css');
	wp_enqueue_script('fitvid-j',				get_template_directory_uri() . '/js/slider/jquery.flexslider-min.js', array( 'jquery' ), '20120206', false );
	wp_enqueue_script('froogaloop-j',		get_template_directory_uri() . '/js/slider/froogaloop.js', array( 'jquery' ), '20120206', false );
	wp_enqueue_script('easing-j', 			get_template_directory_uri() . '/js/slider/jquery.easing.js', array( 'jquery' ), '20120206', false );
	wp_enqueue_script('fitvid-j',				get_template_directory_uri() . '/js/slider/jquery.fitvid.js', array( 'jquery' ), '20120206', false);
	wp_enqueue_script('mousewheel-j',	get_template_directory_uri() . '/js/slider/jquery.mousewheel.js', array( 'jquery' ), '20120206', false );
	wp_enqueue_script('modernizr-j',		get_template_directory_uri() . '/js/slider/modernizr.js', array( 'jquery' ), '20120206', false );
	wp_enqueue_script('shCore-j',			get_template_directory_uri() . '/js/slider/shCore.js', array( 'jquery' ), '20120206', false );
	
	/*add fancybox*/
	wp_enqueue_script('fn-box',			get_template_directory_uri() . '/js/fnBox/jquery.fancybox.pack.js', array( 'jquery' ), '20120206', false );
	wp_enqueue_style( 'fn-box-style',	get_template_directory_uri() . '/js/fnBox/jquery.fancybox.css');
	
	wp_enqueue_style( 'fn-box-btn',		get_template_directory_uri() . '/js/fnBox/helpers/jquery.fancybox-buttons.css');
	wp_enqueue_script('fn-box-btns',		get_template_directory_uri() . '/js/fnBox/helpers/jquery.fancybox-buttons.js', array( 'jquery' ), '20120206', false );

	wp_enqueue_style( 'fn-box-thumb',		get_template_directory_uri() . '/js/fnBox/helpers/jquery.fancybox-thumbs.css');
	wp_enqueue_script('fn-box-thumbs',		get_template_directory_uri() . '/js/fnBox/helpers/jquery.fancybox-thumbs.js', array( 'jquery' ), '20120206', false );
	wp_enqueue_script('fn-box-media',		get_template_directory_uri() . '/js/fnBox/helpers/jquery.fancybox-media.js', array( 'jquery' ), '20120206', false );
	
	
  //wp_enqueue_script('small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', false );
	wp_enqueue_script('small-menu-select', get_template_directory_uri() . '/js/small-menu-select.js', array( 'jquery' ), '20120206', false );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'fruitful_scripts' );

/**
 * Implement the Custom Header feature
 */
require( GENERAL . 'custom-header.php' );

/*Slider*/

function get_sliders_options() {
	$out = "";
	$theme_options = ret_options("fruitful_theme_options");
	
	$out .= '$(".flexslider").flexslider({' .chr(13);
	$out .= 'animation: "'			. $theme_options['s_animation']				.'",' . chr(13);
	$out .= 'direction: "'  			. $theme_options['s_direction']   				.'",' . chr(13);
	$out .= 'reverse: '				. $theme_options['s_reverse'] 					. ',' . chr(13);
	$out .= 'slideshow: ' 		  	. $theme_options['s_slideshow'] 				. ',' . chr(13);
	$out .= 'slideshowSpeed: ' 	. $theme_options['s_slideshowSpeed'] 	. ',' . chr(13);
	$out .= 'animationSpeed: ' 	. $theme_options['s_animationSpeed'] 	. ',' . chr(13);
	$out .= 'controlNav: ' 			. $theme_options['s_controlnav'] 				. ',' . chr(13);
	
	if ($theme_options['s_initDelay']  != "") {
		$out .= 'initDelay: ' . $theme_options['s_initDelay'] .',' . chr(13);
	}
	$out .= 'randomize: '	. $theme_options['s_randomize'] . chr(13);
    $out .= '});' .chr(13);
	
	return $out;
}	  

function fruitful_get_slider($atts) {
	$slider_ = "";
	
	 extract(shortcode_atts(array(
		  'id'		=> 'slider_0'
     ), $atts));
	 
	$theme_options  = ret_options("fruitful_theme_options");
	$slider_img		 = ret_options("fruitful_theme_slides_options");
	$slider_order	   	 = ret_options("fruitful_theme_slides_sort_options");
	
	$vcount_slider_img = count($slider_img);
	$vcount_order = count($slider_order);
	
	$w_slider	=  $theme_options['s_width'];
	$h_slider  =  $theme_options['s_height']; 
	if ($vcount_slider_img != 0) {
		$slider_ .= '<div class="main-slider-container">' 	. chr(13);
		$slider_ .= '<section class="slider">' 					. chr(13);
		$slider_ .= '<div class= "flexslider" id="' . $id . '">' . chr(13);
		$slider_ .= '<ul class="slides">' 							. chr(13);

		if (($vcount_order != 0) and ($vcount_order == $vcount_slider_img) ) {
									foreach ($slider_order as $value) {
										$index = str_replace("slide_image_", "", $value);
										$val = $slider_img['slide_' . $index]; 
											if ($val != '') {
												$slider_ .= '<li>' . chr(13);
													$slider_ .= '<img src="'. get_thumb_img ($val, $w_slider, $h_slider) .'" />' . chr(13);
												$slider_ .= '</li>' . chr(13);
											}
									}
									} else {
					
									for ($i = 1; $i <= $vcount_slider_img; $i++) {
										$val = $slider_img['slide_' . $i]; 
										if ($val != '') {
											$slider_ .= '<li>' . chr(13);
												$slider_ .= '<img src="'. get_thumb_img ($val, $w_slider, $h_slider) .'" />' . chr(13);
											$slider_ .= '</li>' . chr(13);
										}
									}
								}
		$slider_ .= '</ul></div></section></div>';
	}
	
	return $slider_;
}
add_shortcode('slider', 'fruitful_get_slider');

/*Get logo img*/
function get_logo () {
	$theme_options  = ret_options("fruitful_theme_options");
	
	$url_logo 		= $theme_options['logo_img'];
	$logo_w  		= $theme_options['logo_w'];
	$logo_h  		= $theme_options['logo_h'];
	$description  = get_bloginfo('description');
	
	if ($url_logo != "") {
		return  '<a href="' . home_url( '/' ) . '" title="' . $description .'" rel="home"><img class="logo" src="'. get_thumb_img ($url_logo, $logo_w, $logo_h)  .'" alt="' . $description . '"/></a>';
	} else {
		return  '<a href="' . home_url( '/' ) . '" title="' . $description .'" rel="home"><img class="logo" src="'. get_bloginfo("template_url") . '/images/default_logo.png'  .'" alt="' . $description . '"/></a>';
	}	
}

/*Get all styles*/
function get_all_style () {
	unset($out);
	$theme_options  = ret_options("fruitful_theme_options"); 
	
	if (isset($theme_options['styletheme'])) {

		$out .= '$("H1").css({"font-size" : "'.$theme_options['h1_size'] .'px"});' . chr(13);
		$out .= '$("H2").css({"font-size" : "'.$theme_options['h2_size'] .'px"});' . chr(13);
		$out .= '$("H3").css({"font-size" : "'.$theme_options['h3_size'] .'px"});' . chr(13);
		$out .= '$("H4").css({"font-size" : "'.$theme_options['h4_size'] .'px"});' . chr(13);
		$out .= '$("H5").css({"font-size" : "'.$theme_options['h5_size'] .'px"});' . chr(13);
		$out .= '$("H6").css({"font-size" : "'.$theme_options['h6_size'] .'px"});' . chr(13);
	
		$out .= '$("H1, H2, H3, H4, H5, H6").css({"font-family" : "'.$theme_options['h_font_family'] .'"});'. chr(13);
		$out .= '$("p").css({"font-size" : "'. $theme_options['p_size'] .'px", "font-family" : "' .$theme_options['p_font_family'] . '"});'. chr(13);
	
	
	
		if(!empty($theme_options['background_color'])) 	{ $back_sytle .= '"background-color"   :  "'.$theme_options['background_color'] .'", '; }
		if(!empty($theme_options['backgroung_img'])) 	{ 
				if($theme_options['bg_repeating'] == "on")	{ 
						$back_sytle .= '"background-image" : "url(' .$theme_options['backgroung_img'] .')", "background-repeat" : "repeat"'; 	
					} else {
						$back_sytle .= '"background-image" : "url(' .$theme_options['backgroung_img'] .')", "background-repeat" : "no-repeat"'; 	
					}
				}

		$out .= '$("body").css({'. $back_sytle .'});' . chr(13); 
	
	
		$out .= '$(".main-navigation a").css({"color" : "'.$theme_options['menu_font_color']. '"});' . chr(13); 
		if ($theme_options['menu_btn_color'] != "") 		{$out .= '$(".main-navigation ul li.current_page_item a, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current-menu-parent a, .main-navigation ul li.current_page_parent a").css({"background-color" : "'.$theme_options['menu_btn_color'] . '"});' . chr(13); 	}
		if ($theme_options['menu_hover_color'] !="") 	{$out .= '$(".main-navigation ul li.current_page_item a, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current-menu-parent a, .main-navigation ul li.current_page_parent a").css({"color" : "'.$theme_options['menu_hover_color'] . '"});' . chr(13); 	}
		if ($theme_options['menu_txtsh_color'] != "") 	{$out .= '$(".main-navigation ul li.current_page_item a, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current-menu-parent a, .main-navigation ul li.current_page_parent a").css({"text-shadow" : " 0 1px 0 '.$theme_options['menu_txtsh_color'] . '"});' . chr(13); }
		if ($theme_options['menu_boxsh_color'] != "") 	{$out .= '$(".main-navigation ul li.current_page_item a, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current-menu-parent a, .main-navigation ul li.current_page_parent a").css({"box-shadow" : " 0 0 2px '.$theme_options['menu_boxsh_color'] . ' inset"});' . chr(13); }
	
		$out .= '$(".main-navigation ul#menu-mainmenu li:visible").hover( function() { ' .chr(13);
			if ($theme_options['menu_btn_color'] != "") 		{$out .= '$(this).find("a").css({"background-color" : "'.$theme_options['menu_btn_color'] . '"});' . chr(13); }
			if ($theme_options['menu_hover_color'] !="") 	{$out .= '$(this).find("a").css({"color" : "'.$theme_options['menu_hover_color'] . '"});' . chr(13); }
			if ($theme_options['menu_txtsh_color'] != "") 	{$out .= '$(this).find("a").css({"text-shadow" : " 0 1px 0 '.$theme_options['menu_txtsh_color'] . '"});' . chr(13); }
			if ($theme_options['menu_boxsh_color'] !="") 	{$out .= '$(this).find("a").css({"box-shadow" : " 0 0 2px '.$theme_options['menu_boxsh_color'] . ' inset"});' . chr(13); }
		$out .= '}, function() {' .chr(13);
	
		$out .= '$(this).find("a").removeAttr("style"); ' . chr(13);  
		$out .= '$(".main-navigation a").css({"color" : "'.$theme_options['menu_font_color']. '"});' . chr(13); 
		if ($theme_options['menu_btn_color'] != "") 		{$out .= '$(".main-navigation ul li.current_page_item a, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current-menu-parent a, .main-navigation ul li.current_page_parent a").css({"background-color" : "'.$theme_options['menu_btn_color'] . '"});' . chr(13); 	}
		if ($theme_options['menu_hover_color'] !="") 	{$out .= '$(".main-navigation ul li.current_page_item a, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current-menu-parent a, .main-navigation ul li.current_page_parent a").css({"color" : "'.$theme_options['menu_hover_color'] . '"});' . chr(13); 	}
		if ($theme_options['menu_txtsh_color'] != "") 	{$out .= '$(".main-navigation ul li.current_page_item a, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current-menu-parent a, .main-navigation ul li.current_page_parent a").css({"text-shadow" : " 0 1px 0 '.$theme_options['menu_txtsh_color'] . '"});' . chr(13); 	}	
		if ($theme_options['menu_boxsh_color'] != "") 	{$out .= '$(".main-navigation ul li.current_page_item a, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current-menu-parent a, .main-navigation ul li.current_page_parent a").css({"box-shadow" : " 0 0 2px '.$theme_options['menu_boxsh_color'] . ' inset"});' . chr(13); }
	
	
		$out .= '});' .chr(13);
		}
	return $out;
}

/*Get footer text*/
function get_footer_text () {
	$theme_options  = ret_options("fruitful_theme_options"); 
	return stripslashes($theme_options['footer_text']);
}

/*Get footer social icons*/
function get_footer_socials_icon () {
	unset($out);
	$theme_options  = ret_options("fruitful_theme_options"); 
	
	if(!empty($theme_options['facebook_url'])) 		{ $out .= '<a class="facebook" href="'. esc_url($theme_options['facebook_url']) . '" target="_blank"></a>';	}
	if(!empty($theme_options['twitter_url']))		 		{ $out .= '<a class="twitter" href="'. esc_url($theme_options['twitter_url']) . '" target="_blank"></a>'; }
	if(!empty($theme_options['linkedin_url'])) 			{ $out .= '<a class="linkedin" href="'. esc_url($theme_options['linkedin_url']) . '" target="_blank"></a>'; }
	if(!empty($theme_options['myspace_url'])) 		{ $out .= '<a class="myspace" href="'. esc_url($theme_options['myspace_url']) . '" target="_blank"></a>'; }	
	if(!empty($theme_options['googleplus_url'])) 		{ $out .= '<a class="googleplus" href="'. esc_url($theme_options['googleplus_url']) . '" target="_blank"></a>'; }		
	if(!empty($theme_options['dribbble_url'])) 	 		{ $out .= '<a class="dribbble" href="'. esc_url($theme_options['dribbble_url']) . '" target="_blank"></a>'; }		
	if(!empty($theme_options['skype_link'])) 			{ $out .= '<a class="skype" href="'. esc_url($theme_options['skype_link']) . '" target="_blank"></a>'; }		
	if(!empty($theme_options['flickr_link'])) 			{ $out .= '<a class="flickr" href="'. esc_url($theme_options['flickr_link']) . '" target="_blank"></a>'; }		
	if(!empty($theme_options['youtube_url'])) 			{ $out .= '<a class="youtube" href="'. esc_url($theme_options['youtube_url']) . '" target="_blank"></a>'; }		
	if(!empty($theme_options['rss_link'])) 				{ $out .= '<a class="rss" href="'. esc_url($theme_options['rss_link']) . '" target="_blank"></a>'; }			
	
	return $out;
}


/*Add description block into content block*/
function add_description_block ($atts, $content = null) {
	$out = "";
	 extract(shortcode_atts(array(
		  'id'		=> 'description_0',
		  'style' 	=> 'font-size: 40px; text-transform : uppercase; text-align: center; font-weight: 300;'
     ), $atts));
   
    $out .= '<div class="description" id="'. $id .'">' . chr(13);
		$out .= '<span class="top_line"></span>' .chr(13);
		
			if (!empty($content)) {
				$out .=	'<div class="text" style="'. $style .'">' . $content . '</div>';
			}
			else {
				$out .= '<div class="text" style="'. $style .'">No text Description</div>';
			}			
		$out .= '<span class="btm_line"></span>' .chr(13);
	$out .= '</div>' .chr(13);
	
    return $out;
}
add_shortcode ("description", "add_description_block");

function add_info_box_area ($atts, $content = null) {
	 $out = ""; 
	 
	 extract(shortcode_atts(array(
		  'id'		=> 'info_box_area_0'
     ), $atts));
	 
	 $out .= '<div class="info_box_area row clearfix" id="'. $id .'">' .chr(13);
		$out .= do_shortcode($content);
	 $out .= '</div>'.chr(13);
	 return $out;
	 
}
add_shortcode('info_box_area', 'add_info_box_area');

/*Add information box into content block*/
function add_info_box ($atts, $content = null) {
$out = "";
	 extract(shortcode_atts(array(
		  'id'			=> 'info_box_0',
		  'icon_url' 	=> get_bloginfo('template_url') . '/images/default_icon.png' , 
		  'title'	   	=> 'Some title', 
		  'type_column' 	=> '', 
		  'style_text'	  	=> 'text-align:center; font-size:13px;',
		  'style_title'		=> 'text-align:center; font-size: 20px; text-transform: uppercase; '
     ), $atts));
	 $out .= '<div class="one-third column info_box '. $type_column .'" id="' . $id . '">' . chr(13);
		$out .= '<img class="icon" src="'. $icon_url .'" title="' . $title . '" />' . chr(13); 
		$out .= '<div class="infobox_title" style="' . $style_title .'">' . $title . '</div>' .chr(13);
		$out .= '<div class="info_box_text" style="'. $style_text .'" >' . $content . '</div>' . chr(13);
	 $out .= '</div>';
return $out;	 
} 
add_shortcode ("info_box", "add_info_box");

/*Tracking Site Activity*/
function get_tracking_code() {
	$theme_options  = ret_options("fruitful_theme_options"); 
	return $theme_options['tracking_code'];
	
}

/*Enable Comment*/
function state_post_comment () {
	$theme_options  = ret_options("fruitful_theme_options"); 
	return ($theme_options['postcomment'] == "on");
	
}

function state_page_comment () {
	$theme_options  = ret_options("fruitful_theme_options"); 
	return ($theme_options['pagecomment'] == "on");
}

function get_responsive_style () {
	$theme_options  = ret_options("fruitful_theme_options"); 
	if ($theme_options['responsive'] == 'on') {
		return '<link rel="stylesheet" type="text/css" media="all" href="'. get_bloginfo( 'stylesheet_url' ) .'" />';
	} else {
		return '<link rel="stylesheet" type="text/css" media="all" href="'. get_bloginfo( 'template_url' ) .'/style_nr.css" />';
	}	
}

