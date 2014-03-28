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


 /**
 * Implement the Custom Header feature
 */
 
 /*require get_template_directory() . '/inc/custom-header.php';*/

 /**
 * Custom template tags for this theme.
 */
 
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/widgets.php';


 /**
 * Adding recommended plugins for Fruitful Theme.
 */
require_once('inc/func/plugins-included.php');


/**
 * Custom functions that act independently of the theme templates
 */
require get_template_directory() . '/inc/tweaks.php';
require get_template_directory() . '/inc/func/fruitful-function.php';
require get_template_directory() . '/inc/func/import_front_page.php';
require get_template_directory() . '/inc/func/comment-inline-error.php';
	
/**
 * Custom Theme Options
 */
require get_template_directory() . '/inc/theme-options/theme-options.php';

function fruitful_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Source Sans Pro, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$source_sans_pro = _x( 'on', 'Source Sans Pro font: on or off', 'fruitful' );

	/* Translators: If there are characters in your language that are not
	 * supported by Bitter, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$bitter = _x( 'on', 'Bitter font: on or off', 'fruitful' );

	if ( 'off' !== $source_sans_pro || 'off' !== $bitter ) {
		$font_families = array();

		if ( 'off' !== $source_sans_pro )
			$font_families[] = 'Source Sans Pro:300,400,700,300italic,400italic,700italic';

		if ( 'off' !== $bitter )
			$font_families[] = 'Bitter:400,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

function fruitful_setup() {
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
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
	
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );
	
	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'fruitful' ),
	) );

	
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 604, 270, true );
	add_image_size( 'slider-thumb', 608, 300, true );
	
	add_editor_style( array( 'css/editor-style.css', 'fonts/genericons.css', fruitful_fonts_url() ) );
	
	$defaults = array(
		'default-color'          => 'fff',
		'default-image'          => '',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
		);
	/*add_theme_support( 'custom-background', $defaults );*/
	
	add_filter( 'use_default_gallery_style', '__return_false' );
	
}
endif; 
add_action( 'after_setup_theme', 'fruitful_setup' );
// fruitful_setup


function fruitful_wp_title( $title, $sep ) {
	global $paged, $page;
	if ( is_feed() ) return $title;

	$title .= get_bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
 		 $title = "$title $sep $site_description";
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'fruitful' ), max( $paged, $page ) );
	return $title;
}
add_filter( 'wp_title', 'fruitful_wp_title', 10, 2 );


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
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Blog Right Sidebar', 'fruitful' ),
		'id' => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Single Post Sidebar', 'fruitful' ),
		'id' => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Shop Page Sidebar', 'fruitful' ),
		'id' => 'sidebar-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
}


add_action( 'widgets_init', 'fruitful_widgets_init' );

/**
 * Enqueue scripts and styles
 */
 function fruitful_scripts() {
	$theme_options = fruitful_ret_options("fruitful_theme_options");
	wp_enqueue_script('migrate', get_template_directory_uri() . '/js/jquery-migrate-1.2.1.min.js', array( 'jquery' ), '20130930', false );
	if (isset($theme_options['select_slider'])){
		  if ($theme_options['select_slider'] == "1") {
				wp_enqueue_style( 'flex-slider', 			get_template_directory_uri() . '/js/flex_slider/slider.css');
				wp_enqueue_script('flex-fitvid-j',			get_template_directory_uri() . '/js/flex_slider/jquery.flexslider-min.js', array( 'jquery' ), '20130930', false );
				wp_enqueue_script('flex-froogaloop-j',		get_template_directory_uri() . '/js/flex_slider/froogaloop.js', 	array( 'jquery' ), '20130930', false );
				wp_enqueue_script('flex-easing-j', 			get_template_directory_uri() . '/js/flex_slider/jquery.easing.js', 	array( 'jquery' ), '20130930', false );
				wp_enqueue_script('flex-fitvid-j',			get_template_directory_uri() . '/js/flex_slider/jquery.fitvid.js', 	array( 'jquery' ), '20130930', false);
				wp_enqueue_script('flex-mousewheel-j',		get_template_directory_uri() . '/js/flex_slider/jquery.mousewheel.js', array( 'jquery' ), '20130930', false );
				wp_enqueue_script('flex-modernizr-j',		get_template_directory_uri() . '/js/flex_slider/modernizr.js', array( 'jquery' ), '20130930', false );
			} else if ($theme_options['select_slider'] == "2") {
				wp_enqueue_style( 'nivo-bar-skin', 		get_template_directory_uri() . '/js/nivo_slider/skins/bar/bar.css');
				wp_enqueue_style( 'nivo-dark-skin', 	get_template_directory_uri() . '/js/nivo_slider/skins/dark/dark.css');
				wp_enqueue_style( 'nivo-default-skin', 	get_template_directory_uri() . '/js/nivo_slider/skins/default/default.css');
				wp_enqueue_style( 'nivo-light-skin', 	get_template_directory_uri() . '/js/nivo_slider/skins/light/light.css');
				wp_enqueue_style( 'nivo-style', 		get_template_directory_uri() . '/js/nivo_slider/nivo-slider.css');
				wp_enqueue_script('nivo-slider',		get_template_directory_uri() . '/js/nivo_slider/jquery.nivo.slider.pack.js', array( 'jquery' ), '20130930', false );
			}
	}	
	
	/*add woocommerce styles for ie*/
	wp_enqueue_style( 'ie-style',		get_template_directory_uri() . '/woocommerce/ie.css');
	
	/*add fancybox*/
	wp_enqueue_script('fn-box',				get_template_directory_uri() . '/js/fnBox/jquery.fancybox-1.3.4.pack.js',   array( 'jquery' ), '20130930', false );
	wp_enqueue_script('fn-box-wheel',		get_template_directory_uri() . '/js/fnBox/jquery.mousewheel-3.0.4.pack.js', array( 'jquery' ), '20130930', false );
	wp_enqueue_style( 'fn-box-style',		get_template_directory_uri() . '/js/fnBox/jquery.fancybox-1.3.4.css');
	
	wp_enqueue_style( 'fn-tabs',			get_template_directory_uri() . '/js/tabs/easyResponsiveTabs.css');
	wp_enqueue_script('fn-tabs',			get_template_directory_uri() . '/js/tabs/easyResponsiveTabs.js', 	array( 'jquery' ), '20130930', false );
	
	wp_enqueue_script('resp-dropdown',		get_template_directory_uri() . '/js/mobile-dropdown.min.js', 	array( 'jquery' ), '20130930', false );
	
	wp_enqueue_script('init',				get_template_directory_uri() . '/js/init.min.js', array( 'jquery' ), '20130930', false );
	
	$is_fixed_header = -1;
	if (isset($theme_options['is_fixed_header']) && ($theme_options['is_fixed_header'] == 'on')) {
		$is_fixed_header = 1;
	}
	
	wp_localize_script( 'init', 'ThGlobal', 	array( 'ajaxurl' 			=> admin_url( 'admin-ajax.php' ), 
													   'is_fixed_header' 	=> $is_fixed_header ) );  
	
	wp_enqueue_script('small-menu-select', get_template_directory_uri() . '/js/small-menu-select.js', array( 'jquery' ), '20130930', false );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'fruitful_scripts' );

function fruitful_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

/*Slider*/

function fruitful_get_slider_options_flex() {
	$out = "";
	$theme_options = fruitful_ret_options("fruitful_theme_options");
	
	$out .= '$(".flexslider").flexslider({' . "\n";
	$out .= 'animation: "'			. esc_attr($theme_options['s_animation'])		.'",' . "\n";
	$out .= 'direction: "'  		. esc_attr($theme_options['s_direction'])   	.'",' . "\n";
	$out .= 'reverse: '				. esc_attr($theme_options['s_reverse']) 		. ',' . "\n";
	$out .= 'slideshow: ' 		  	. esc_attr($theme_options['s_slideshow']) 		. ',' . "\n";
	$out .= 'slideshowSpeed: ' 		. esc_attr($theme_options['s_slideshowSpeed']) 	. ',' . "\n";
	$out .= 'animationSpeed: ' 		. esc_attr($theme_options['s_animationSpeed']) 	. ',' . "\n";
	$out .= 'controlNav: ' 			. esc_attr($theme_options['s_controlnav']) 		. ',' . "\n";
	
	if (isset($theme_options['s_initDelay'])) {
		$out .= 'initDelay: ' . $theme_options['s_initDelay'] .',' . "\n";
	}
	$out .= 'randomize: '	. $theme_options['s_randomize'] . "\n";
    $out .= '});' . "\n";
	
	return $out;
}	  


function fruitful_get_slider_options_nivo() {
	$out = "";
	$theme_options = fruitful_ret_options("fruitful_theme_options");
	
	$out .= '$(".nivoSlider").nivoSlider({' . "\n";
	$out .= 'effect: "'				. esc_attr($theme_options['nv_animation'])		. '",' . "\n";
    $out .= 'slices: '				. esc_attr($theme_options['nv_slice'])			.  ',' . "\n";
    $out .= 'boxCols: '				. esc_attr($theme_options['nv_boxCols'])		.  ',' . "\n";
    $out .= 'boxRows: '				. esc_attr($theme_options['nv_boxRows'])		.  ',' . "\n";
    $out .= 'animSpeed: '			. esc_attr($theme_options['nv_animSpeed'])		.  ',' . "\n";
    $out .= 'pauseTime: '			. esc_attr($theme_options['nv_pauseTime'])		.  ',' . "\n";
	$out .= 'startSlide:' . (isset($theme_options['nv_startSlide']) ? $theme_options['nv_startSlide'] : 0) . ',' . "\n";
    $out .= 'directionNav: '		. esc_attr($theme_options['nv_directionNav'])		.  ',' . "\n";
    $out .= 'controlNav: '			. esc_attr($theme_options['nv_controlNav'])			.  ',' . "\n";
    $out .= 'controlNavThumbs: '	. esc_attr($theme_options['nv_controlNavThumbs'])	.  ',' . "\n";
    $out .= 'pauseOnHover: '		. esc_attr($theme_options['nv_pauseOnHover'])	.  ',' . "\n";
    $out .= 'manualAdvance: '		. esc_attr($theme_options['nv_manualAdvance'])	.  ',' . "\n";
    $out .= 'prevText: "'			. esc_attr($theme_options['nv_prevText'])		.  '",' . "\n";
    $out .= 'nextText: "'			. esc_attr($theme_options['nv_nextText'])		.  '",' . "\n";
    $out .= 'randomStart: '			. esc_attr($theme_options['nv_randomStart']) . "\n";
	$out .= '});';
	
	return $out;
}


function fruitful_get_slider($atts) {
	$slider_ = "";
	
	shortcode_atts(array( 'id' => ''), $atts, 'fruitful_slider');
	
	$id = 'main_slider';
	if (isset($atts['id'])) { $id = $atts['id']; }	
	
	$theme_options   = fruitful_ret_options("fruitful_theme_options");
	/*Full Backend Options*/
	if(isset($theme_options['slides']) && (count($theme_options['slides']) > 0)) {
		 if ($theme_options['select_slider'] == "1") {
				$slider_ .= '<div class="main-slider-container">';
					$slider_ .= '<section class="slider">';
						$slider_ .= '<div class= "flexslider" id="' . $id . '">';
							$slider_ .= '<ul class="slides">';
							foreach ($theme_options['slides'] as $key=>$slide) {
								$path_to_img = $val = '';
								$val = wp_get_attachment_image_src( esc_attr($slide['attach_id']), 'full');
								$path_to_img = esc_url_raw($val[0]);
								$slider_ .= '<li>';
									if (!empty($slide['link'])) {
										if (!empty($slide['is_blank'])) {
											$slider_ .= '<a href="'.esc_url($slide['link']).'" target="_blank">';
										} else {
											$slider_ .= '<a href="'.esc_url($slide['link']).'">';
										}	
											$slider_ .= '<img src="'.$path_to_img.'" />';
										$slider_ .= '</a>';	
									} else {
										$slider_ .= '<img src="'.$path_to_img.'" />';
									}
								$slider_ .= '</li>';
							}
							$slider_ .= '</ul></div></section></div>';
		} else if ($theme_options['select_slider'] == "2") {
				$slider_ .= '<div class="slider-wrapper '. $theme_options['nv_skins'] .'">';
					$slider_ .= '<div id="nivo-slider-'. $id . '" class="nivoSlider">';
					foreach ($theme_options['slides'] as $key=>$slide) {
						$path_to_img = $val = '';
						$val = wp_get_attachment_image_src( esc_attr($slide['attach_id']), 'full');
						$path_to_img = esc_url_raw($val[0]);
						
						if (!empty($slide['link'])) {
							if (!empty($slide['is_blank'])) {
								$slider_ .= '<a href="'.esc_url($slide['link']).'" target="_blank">';
							} else {
								$slider_ .= '<a href="'.esc_url($slide['link']).'">';
							}	
								$slider_ .= '<img src="'. $path_to_img .'" data-thumb="'. $path_to_img .'" alt="" />';
							$slider_ .= '</a>';	
						} else {
							$slider_ .= '<img src="'. $path_to_img .'" data-thumb="'. $path_to_img .'" alt="" />';
						}
					}	
					$slider_ .= '</div>';
				$slider_ .= '</div>';
		}	
	} else {
		$slider_ .= '<h3>Please add images for slider in theme options!</h3>';
	}
	return $slider_;
}
add_shortcode('fruitful_slider', 'fruitful_get_slider');

/*Get logo img*/
function fruitful_get_logo () {
	$theme_options  = fruitful_ret_options("fruitful_theme_options");
	$url_logo = '';
	
	if (!empty($theme_options['logo_img'])) { $url_logo_id	= esc_attr($theme_options['logo_img']); } else { $url_logo_id 	= ''; }
	
	/*Full Backend Options*/
	$description  = $name = '';
	$description  = esc_attr(get_bloginfo('description'));
	$name  		  = esc_attr(get_bloginfo('name'));
	
	if ($url_logo_id != "") {
		$url_logo = wp_get_attachment_image_src($url_logo_id, 'full');
		$url_logo = esc_url_raw($url_logo[0]);
		echo  '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . $description .'" rel="home"><img class="logo" src="'. $url_logo  .'" alt="' . $description . '"/></a>';
	} else {
		echo  '<a class="logo-description" href="' . esc_url( home_url( '/' ) ) . '" title="' . $description .'" rel="home"><h1 class="site-title">'. $name .'</h1><h2 class="site-description">'. $description .'</h2></a>';
	}	
}


/*Get Favicon*/
function fruitful_get_favicon () {
	$out_fav_html = '';
	$theme_options  = fruitful_ret_options("fruitful_theme_options");
	
	if (isset($theme_options['fav_icon'])) {
		$url_favicon = esc_attr($theme_options['fav_icon']);
		$url_favicon = wp_get_attachment_image_src($url_favicon, 'full');
		$url_favicon = esc_url_raw($url_favicon[0]);
	} else {
		$url_favicon = '';
	}	
	
	if ($url_favicon != "") {
		$out_fav_html .=  '<link rel="shortcut icon" href="'. $url_favicon .'">';	
		$out_fav_html .=  '<link rel="apple-touch-icon-precomposed" sizes="16x16" href="'. $url_favicon .'">';	
	} else {
		/*Default favicon file*/
	}	
	echo $out_fav_html;
}

/*Get footer text*/
function fruitful_get_footer_text () {
	$out_footer_text = $footer_text = '';
	$theme_options   = fruitful_ret_options("fruitful_theme_options"); 
	if (!empty($theme_options['footer_text'])) {
		$footer_text = fruitful_kses_data(stripslashes($theme_options['footer_text']));
		
		if (is_home() || is_front_page()) {
			$out_footer_text .= $footer_text;
		} else {
			$out_footer_text .= '<nofollow>';
				$out_footer_text .= $footer_text;
			$out_footer_text .= '</nofollow>';
			
		}		
	echo $out_footer_text;
	}	
}

/*Get position for social icons*/
function fruitful_is_social_header () {
	$pos = false;
	$theme_options  = fruitful_ret_options("fruitful_theme_options"); 
	if(!empty($theme_options['sl_position']))	{ $pos =  esc_attr($theme_options['sl_position']); }
	return $pos;
}

/*Get footer social icons*/
function fruitful_get_socials_icon () {
	$out = '';
	$theme_options  = fruitful_ret_options("fruitful_theme_options"); 
	
	if(!empty($theme_options['facebook_url'])) 		{ $out .= '<a class="facebook" 	href="'	. esc_url($theme_options['facebook_url']) 	. '" target="_blank"></a>';	}
	if(!empty($theme_options['twitter_url']))		{ $out .= '<a class="twitter" 	href="'	. esc_url($theme_options['twitter_url']) 	. '" target="_blank"></a>'; }
	if(!empty($theme_options['linkedin_url'])) 		{ $out .= '<a class="linkedin" 	href="'	. esc_url($theme_options['linkedin_url']) 	. '" target="_blank"></a>'; }
	if(!empty($theme_options['myspace_url'])) 		{ $out .= '<a class="myspace" 	href="'	. esc_url($theme_options['myspace_url']) 	. '" target="_blank"></a>'; }	
	if(!empty($theme_options['googleplus_url'])) 	{ $out .= '<a class="googleplus" href="'. esc_url($theme_options['googleplus_url']) . '" target="_blank"></a>'; }		
	if(!empty($theme_options['dribbble_url'])) 	 	{ $out .= '<a class="dribbble" 	href="'			. esc_url($theme_options['dribbble_url']) 	. '" target="_blank"></a>'; }		
	if(!empty($theme_options['skype_link'])) 		{ $out .= '<a class="skype" 	href="skype:' 	. esc_attr($theme_options['skype_link'])	. '?call"></a>'; }		
	if(!empty($theme_options['flickr_link'])) 		{ $out .= '<a class="flickr" 	href="'		. esc_url($theme_options['flickr_link']) 	. '" target="_blank"></a>'; }		
	if(!empty($theme_options['youtube_url'])) 		{ $out .= '<a class="youtube" 	href="'		. esc_url($theme_options['youtube_url']) 	. '" target="_blank"></a>'; }		
	if(!empty($theme_options['rss_link'])) 			{ $out .= '<a class="rss" 		href="'		. esc_url($theme_options['rss_link']) 		. '" target="_blank"></a>'; }			
	if(!empty($theme_options['vk_link'])) 			{ $out .= '<a class="vk" 		href="'		. esc_url($theme_options['vk_link']) 		. '" target="_blank"></a>'; }			
	if(!empty($theme_options['instagram_url']))		{ $out .= '<a class="instagram"	href="'		. esc_url($theme_options['instagram_url'])	. '" target="_blank"></a>'; }			
	if(!empty($theme_options['pinterest_url']))		{ $out .= '<a class="pinterest"	href="'		. esc_url($theme_options['pinterest_url'])	. '" target="_blank"></a>'; }			
	if(!empty($theme_options['yelp_url']))			{ $out .= '<a class="yelp"		href="'		. esc_url($theme_options['yelp_url'])		. '" target="_blank"></a>'; }			
	if(!empty($theme_options['email_link'])) 		{ $out .= '<a class="email" 	href="mailto:'		. sanitize_email($theme_options['email_link']) . '"></a>'; }			
	
	echo '<div class="social-icon">' . $out . '</div>';
}


/*Add description block into content block*/
function fruitful_add_description_block ($atts, $content = null) {
	$out = '';
	shortcode_atts(array(
		  'id'		=> '',
		  'style' 	=> ''
     ), $atts, 'description');
	
	$id = 'desc_0';
	
	if (wp_is_mobile()) {
		$style = ' font-size: 20px; text-transform : uppercase; text-align: center; font-weight: 300; ';
	} else {
		$style = ' font-size: 40px; text-transform : uppercase; text-align: center; font-weight: 300; ';
	}
	
	if (!empty($atts['id']))    { $id 	 = sanitize_html_class($atts['id']); }
	if (!empty($atts['style'])) { $style = esc_html($atts['style']); }
   
    $out .= '<div class="description" id="'. $id .'">';
		$out .= '<span class="top_line"></span>';
			if (!empty($content)) { $out .=	'<div class="text" style="'. $style .'">' . $content . '</div>'; } else 
								  { $out .= '<div class="text" style="'. $style .'">No text Description</div>'; }			
		$out .= '<span class="btm_line"></span>';
	$out .= '</div>';
	
    return $out;
}
add_shortcode ("description", "fruitful_add_description_block");

function fruitful_add_info_box_area ($atts, $content = null) {
	 global $columns_count;
			$columns_count = 3;
			
	 $out = ""; 
	 shortcode_atts(array(
		  'id'	=> '', 
		  'columns_count' => ''
     ), $atts, 'info_box_area');
	 
	 $id = 'box_area_0';
	 
	 if (isset($atts['id'])) { $id = sanitize_html_class($atts['id']); }
	 if (isset($atts['columns_count'])) { $columns_count = intval($atts['columns_count']); }
	 
	 $out .= '<div class="info_box_area row clearfix" id="'. $id .'">';
		$out .=	fruitful_esc_content_pbr(do_shortcode($content));
	 $out .= '</div>';
	 return $out;
	 
}
add_shortcode('info_box_area', 'fruitful_add_info_box_area');

/*Add information box into content block*/
function fruitful_add_info_box ($atts, $content = null) {
	global $columns_count;
	$out = $columns_class = "";
	shortcode_atts(array(
		  'id'				=> '',
		  'icon_url' 		=> '', 
		  'title'	   		=> '', 
		  'type_column' 	=> '', 
		  'alt'				=> '',
		  'style_text'	  	=> '',
		  'style_title'		=> ''
     ), $atts, 'info_box');
	
	 $id = 'info_box_0';
	 $icon_url  = get_template_directory_uri()  . '/images/default_icon.png'; 
	 $title		= 'Some title';
	 $type_column = '';
	 $alt 		  = '';
	 $style_text  = 'text-align:center; font-size:13px; ';
	 $style_title = 'text-align:center; font-size: 20px; text-transform: uppercase; ';
	 
	 if (isset($atts['id'])) 			{ $id = sanitize_html_class($atts['id']); }
	 if (isset($atts['type_column'])) 	{ $type_column  = esc_attr($atts['type_column']); }
	 if (isset($atts['icon_url'])) 		{ $icon_url 	= $atts['icon_url']; }
	 if (isset($atts['title'])) 		{ $title 		= esc_attr($atts['title']); }
	 if (isset($atts['alt'])) 			{ $alt 			= esc_attr($atts['alt']); }
	 if (isset($atts['style_text'])) 	{ $style_text  	= esc_html($atts['style_text']); }
	 if (isset($atts['style_title'])) 	{ $style_title 	= esc_html($atts['style_title']); }
	 
	 if ($columns_count != '') {
		 if ($columns_count == 1) { $columns_class	= 'sixteen columns'; } 
		 else if ($columns_count == 2)	{ $columns_class	= 'eight columns';} 
		 else if ($columns_count == 3)	{ $columns_class	= 'one-third column'; } 
		 else if ($columns_count == 4)	{ $columns_class	= 'four columns'; }
	 }
	 
	 $out .= '<div class="'.$columns_class.' info_box '. $type_column .'" id="' . $id . '">';
		$out .= '<img class="icon" src="'. esc_url($icon_url) .'" title="' . $title . '" alt="'.$alt.'"/>';
		$out .= '<div class="infobox_title" style="' . $style_title .'">'  . $title . '</div>';
		$out .= '<div class="info_box_text" style="' . $style_text .'" >'  . $content . '</div>';
	 $out .= '</div>';
return $out;	 
} 
add_shortcode ("info_box", "fruitful_add_info_box");

/*Enable Comment*/
function fruitful_state_post_comment () {
	$theme_options  = fruitful_ret_options("fruitful_theme_options"); 
	if (!empty($theme_options['postcomment'])) {
		return ($theme_options['postcomment'] == "on");
	} else {
		return false;
	}	
	
}

function fruitful_state_page_comment () {
	$theme_options  = fruitful_ret_options("fruitful_theme_options"); 
	if (!empty($theme_options['pagecomment'])) {
		return ($theme_options['pagecomment'] == "on");
	} else {
		return false;
	}	
}

function fruitful_get_responsive_style () {
	$style_ = $back_style = $woo_style_ = '';
	$theme_options  = fruitful_ret_options("fruitful_theme_options"); 
 
	wp_enqueue_style('fonts-style', get_template_directory_uri()    . '/inc/css/fonts-style.css');
	if (isset($theme_options['responsive']) && ($theme_options['responsive'] == 'on')) {
		wp_enqueue_style('main-style',  get_stylesheet_uri());
		wp_enqueue_style( 'woo-style', get_template_directory_uri() . '/woocommerce/woo.css');
	} else {
		wp_enqueue_style('main-style',  get_stylesheet_directory_uri()  .'/fixed-style.css');
		wp_enqueue_style( 'woo-style', get_template_directory_uri() . '/woocommerce/woo-fixed.css');
	} 
 
	if (!empty($theme_options['styletheme'])) {
		if ($theme_options['styletheme'] == 'off') {
			$style_ .= 'H1 {font-size : '.esc_js($theme_options['h1_size']) .'px; }' . "\n";
			$style_ .= 'H2 {font-size : '.esc_js($theme_options['h2_size']) .'px; }' . "\n";
			$style_ .= 'H3 {font-size : '.esc_js($theme_options['h3_size']) .'px; }' . "\n";
			$style_ .= 'H4 {font-size : '.esc_js($theme_options['h4_size']) .'px; }' . "\n";
			$style_ .= 'H5 {font-size : '.esc_js($theme_options['h5_size']) .'px; }' . "\n";
			$style_ .= 'H6 {font-size : '.esc_js($theme_options['h6_size']) .'px; }' . "\n";
 
			$style_ .= 'H1, H2, H3, H4, H5, H6 {font-family : '. esc_js($theme_options['h_font_family']) .'; } ' . "\n";
			$style_ .= '.main-navigation a     {font-family : '. esc_js($theme_options['m_font_family']) .'; color : '.esc_js($theme_options['menu_font_color']). '; } ' . "\n";
			$style_ .= '.main-navigation ul:not(.sub-menu) > li > a, .main-navigation ul:not(.sub-menu) > li:hover > a   { font-size : '.esc_js($theme_options['m_size']) .'px;    } ' . "\n";
			
			
			if (!empty($theme_options['menu_bg_color']))   { $style_ .= '.main-navigation {background-color : ' .esc_js($theme_options['menu_bg_color']) . '; }' . "\n";  }
   
			$style_ .= '#header_language_select a {font-family : '.  esc_js($theme_options['m_font_family']) .';} ' . "\n";
			$style_ .= 'body {font-size : '. esc_js($theme_options['p_size']) .'px; font-family : ' . esc_js($theme_options['p_font_family']) . '; }' . "\n";
 
  
			if(!empty($theme_options['background_color']))  { $back_style .= ' background-color : '. esc_js($theme_options['background_color']) .'; '; }
			if(!empty($theme_options['backgroung_img']))    { 
				$bg_url = array();
				$bg_url = wp_get_attachment_image_src(intval($theme_options['backgroung_img']), 'full'); 
				$bg_url = esc_url_raw($bg_url[0]);
				
				if(isset($theme_options['bg_repeating']) && ($theme_options['bg_repeating'] == 'on')) { 
					$back_style .= 'background-image : url(' .$bg_url .'); background-repeat : repeat; ';  
				} else {
					$back_style .= 'background-image : url(' .$bg_url .'); background-repeat : no-repeat; background-size:100% 100%; background-size:cover; background-attachment:fixed; ';  
				}
			}

			$style_ .= 'body {'. $back_style .'}' . "\n";
 
			if(!empty($theme_options['container_bg_color']))  {
				$style_ .= '.container.page-container {background-color : '. esc_js($theme_options['container_bg_color']) . '; } ' . "\n";
			}
 
  
			if (!empty($theme_options['header_bg_color']))   { $style_ .= '.head-container  {background-color : ' .esc_js($theme_options['header_bg_color']) . '; }' . "\n";  }
			if (!empty($theme_options['header_img']))    {
				$header_url = wp_get_attachment_image_src(intval($theme_options['header_img']), 'full'); 
				$header_url = esc_url_raw($header_url[0]);
				$style_ .= '.head-container {background-image : url(' .esc_js($header_url) . '); } ' . "\n";  
			}
  
			if (!empty($theme_options['header_height'])) {
				$style_ .= '.head-container {min-height : '.esc_js($theme_options['header_height']).'px; }' . "\n";  
			}

			if (!empty($theme_options['menu_btn_color']))    { $style_ .= '.main-navigation ul li.current_page_item a, .main-navigation ul li.current-menu-ancestor a, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current-menu-parent a, .main-navigation ul li.current_page_parent a {background-color : '.esc_js($theme_options['menu_btn_color']) . '; }' . "\n";  }
			if (!empty($theme_options['menu_hover_color']))  { $style_ .= '.main-navigation ul li.current_page_item a, .main-navigation ul li.current-menu-ancestor a, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current-menu-parent a, .main-navigation ul li.current_page_parent a {color : '.esc_js($theme_options['menu_hover_color']) . '; } ' . "\n";  }
  
			$style_ .= '.main-navigation ul > li:hover>a {' . "\n";
				if (!empty($theme_options['menu_btn_color']))    { $style_ .= 'background-color : '. esc_js($theme_options['menu_btn_color']) . '; ' . "\n"; }
				if (!empty($theme_options['menu_hover_color']))  { $style_ .= 'color : '.esc_js($theme_options['menu_hover_color']) . ';  ' . "\n"; }
			$style_ .= ' } ' . "\n"; 
  
			/*styles for dropdown menu*/
			$style_ .= '#masthead .main-navigation ul > li > ul > li > a {' . "\n";
				if (!empty($theme_options['dd_menu_bg_color']))    { $style_ .= 'background-color : '. esc_js($theme_options['dd_menu_bg_color']) . '; ' . "\n"; }
				if (!empty($theme_options['dd_menu_font_color']))  { $style_ .= 'color : '.esc_js($theme_options['dd_menu_font_color']) . ';  ' . "\n"; }
			$style_ .= ' } ' . "\n"; 

			$style_ .= '#masthead .main-navigation ul > li > ul > li:hover > a {' . "\n";
				if (!empty($theme_options['dd_menu_btn_color']))    { $style_ .= 'background-color : '. esc_js($theme_options['dd_menu_btn_color']) . '; ' . "\n"; }
				if (!empty($theme_options['dd_menu_hover_color']))  { $style_ .= 'color : '.esc_js($theme_options['dd_menu_hover_color']) . ';  ' . "\n"; }
			$style_ .= ' } ' . "\n"; 
			
			$style_ .= '#masthead .main-navigation ul > li ul > li.current-menu-item > a {' . "\n";
				if (!empty($theme_options['dd_menu_btn_color']))    { $style_ .= 'background-color : '. esc_js($theme_options['dd_menu_btn_color']) . '; ' . "\n"; }
				if (!empty($theme_options['dd_menu_hover_color']))  { $style_ .= 'color : '.esc_js($theme_options['dd_menu_hover_color']) . ';  ' . "\n"; }
			$style_ .= ' } ' . "\n"; 
			
			$style_ .= '#masthead div .main-navigation ul > li > ul > li > ul a {' . "\n";
				if (!empty($theme_options['dd_menu_bg_color']))    { $style_ .= 'background-color : '. esc_js($theme_options['dd_menu_bg_color']) . '; ' . "\n"; }
				if (!empty($theme_options['dd_menu_font_color']))  { $style_ .= 'color : '.esc_js($theme_options['dd_menu_font_color']) . ';  ' . "\n"; }
			$style_ .= ' } ' . "\n"; 

			$style_ .= '#masthead div .main-navigation ul > li > ul > li > ul li:hover a {' . "\n";
				if (!empty($theme_options['dd_menu_btn_color']))    { $style_ .= 'background-color : '. esc_js($theme_options['dd_menu_btn_color']) . '; ' . "\n"; }
				if (!empty($theme_options['dd_menu_hover_color']))  { $style_ .= 'color : '.esc_js($theme_options['dd_menu_hover_color']) . ';  ' . "\n"; }
			$style_ .= ' } ' . "\n"; 
				
			$style_ .= '#lang-select-block li ul li a{'. "\n";
				if (!empty($theme_options['dd_menu_bg_color']))    { $style_ .= 'background-color : '. esc_js($theme_options['dd_menu_bg_color']) . '; ' . "\n"; }
				if (!empty($theme_options['dd_menu_font_color']))  { $style_ .= 'color : '.esc_js($theme_options['dd_menu_font_color']) . ';  ' . "\n"; }
			$style_ .= '}';
			
			$style_ .= '#lang-select-block li ul li a:hover{'. "\n";
				if (!empty($theme_options['dd_menu_btn_color']))    { $style_ .= 'background-color : '. esc_js($theme_options['dd_menu_btn_color']) . '; ' . "\n"; }
				if (!empty($theme_options['dd_menu_hover_color']))  { $style_ .= 'color : '.esc_js($theme_options['dd_menu_hover_color']) . ';  ' . "\n"; }
			$style_ .= '}';
			
			$style_ .= '#lang-select-block li ul li.active a{'. "\n";
				if (!empty($theme_options['dd_menu_btn_color']))    { $style_ .= 'background-color : '. esc_js($theme_options['dd_menu_btn_color']) . '; ' . "\n"; }
				if (!empty($theme_options['dd_menu_hover_color']))  { $style_ .= 'color : '.esc_js($theme_options['dd_menu_hover_color']) . ';  ' . "\n"; }
			$style_ .= '}';
			/*end of styles for dropdown menu*/
  
			$style_ .= '#header_language_select ul li.current > a { color : '.esc_js($theme_options['menu_font_color']). '; } ' . "\n";
			if (!empty($theme_options['menu_bg_color'])) { $style_ .= '#header_language_select { background-color : '.esc_js($theme_options['menu_bg_color']) . '; } ' . "\n";  }
  
			$style_ .= '#header_language_select ul li.current:hover > a { ' . "\n";
				if (!empty($theme_options['menu_btn_color']))    { $style_ .= 'background-color : '. esc_js($theme_options['menu_btn_color']) . ';' . "\n"; }
				if (!empty($theme_options['menu_hover_color']))  { $style_ .= 'color : '.esc_js($theme_options['menu_hover_color']) . ';' . "\n"; }
			$style_ .= '} ' . "\n";
			
			/*Add Custom Colors to theme*/
			if (!empty($theme_options['p_font_color']))  	    { $style_ .= 'body {color : '. esc_js($theme_options['p_font_color']) .'; } ' . "\n"; }
			if (!empty($theme_options['a_font_color']))   		{ $style_ .= 'a    {color : '. esc_js($theme_options['a_font_color']) .'; } ' . "\n"; }
			if (!empty($theme_options['a_hover_font_color']))   { $style_ .= 'a:hover   {color : '. esc_js($theme_options['a_hover_font_color']) .'; } '  . "\n"; }
			if (!empty($theme_options['a_focus_font_color']))   { $style_ .= 'a:focus   {color : '. esc_js($theme_options['a_focus_font_color']) .'; } '  . "\n"; }
			if (!empty($theme_options['a_active_font_color']))  { $style_ .= 'a:active  {color : '. esc_js($theme_options['a_active_font_color']) .'; } ' . "\n"; }
			if (!empty($theme_options['widgets_sep_color']))  { 
				$style_ .= '#page .container #secondary .widget h3.widget-title, #page .container #secondary .widget h1.widget-title, header.post-header .post-title  {border-color : '. esc_js($theme_options['widgets_sep_color']) .'; } ' . "\n";
				$style_ .= 'body.single-product #page .related.products h2  {border-bottom-color : '. esc_js($theme_options['widgets_sep_color']) .'; } ' . "\n";
			}
			
			if (!empty($theme_options['date_of_post_b_color']))  { 
				$style_ .= '.blog_post .date_of_post  {background : none repeat scroll 0 0 '. esc_js($theme_options['date_of_post_b_color']) .'; } ' . "\n";
			}
			
			if (!empty($theme_options['date_of_post_f_color']))  { 
				$style_ .= '.blog_post .date_of_post  {color : '. esc_js($theme_options['date_of_post_f_color']) .'; } ' . "\n";
			}
			
			$woo_style_ .= '.num_of_product_cart {border-color: '. esc_js($theme_options['menu_btn_color']) . '; }  ' . "\n"; 	
			
			if (!empty($theme_options['btn_color'])) {
				$style_		 .= 'button, input[type="button"], input[type="submit"], input[type="reset"]{background-color : '.esc_js($theme_options['btn_color']).' !important; } ' . "\n";
				$woo_style_  .= '.woocommerce table.my_account_orders .order-actions .button, .woocommerce-page table.my_account_orders .order-actions .button{background-color : '.esc_js($theme_options['btn_color']).' !important; } ' . "\n";
				$style_ 	 .= '.nav-links.shop .pages-links .page-numbers, .nav-links.shop .nav-next a, .nav-links.shop .nav-previous a{background-color : '.esc_js($theme_options['btn_color']).' !important; } ' . "\n";
			}	
			
			if (!empty($theme_options['btn_active_color'])) {
				$style_ .= 'button:hover, button:active, button:focus{background-color : '.esc_js($theme_options['btn_active_color']).' !important; } ' . "\n";
				$style_ .= 'input[type="button"]:hover, input[type="button"]:active, input[type="button"]:focus{background-color : '.esc_js($theme_options['btn_active_color']).' !important; } ' . "\n";
				$style_ .= 'input[type="submit"]:hover, input[type="submit"]:active, input[type="submit"]:focus{background-color : '.esc_js($theme_options['btn_active_color']).' !important; } ' . "\n";
				$style_ .= 'input[type="reset"]:hover, input[type="reset"]:active, input[type="reset"]:focus{background-color : '.esc_js($theme_options['btn_active_color']).' !important; } ' . "\n";
				$woo_style_  .= '.woocommerce table.my_account_orders .order-actions .button:hover, .woocommerce-page table.my_account_orders .order-actions .button:hover{background-color : '.esc_js($theme_options['btn_active_color']).' !important; } ' . "\n";
				$style_ .= '.nav-links.shop .pages-links .page-numbers:hover, .nav-links.shop .nav-next a:hover, .nav-links.shop .nav-previous a:hover, .nav-links.shop .pages-links .page-numbers.current{background-color : '.esc_js($theme_options['btn_active_color']).' !important; } ' . "\n";
			}	
		} else {
			$style_ .= 'body {font-family:Open Sans, sans-serif}' . "\n";
		}
	} 
		
	if (!empty($theme_options['custom_css'])) {
		$style_ .= wp_kses_stripslashes($theme_options['custom_css']) . "\n";
	}	
	
	wp_add_inline_style( 'main-style', $style_ ); 
	if ($woo_style_ != '') {
		wp_add_inline_style( 'woo-style', $woo_style_ ); 
	}	
}
add_action('wp_enqueue_scripts', 'fruitful_get_responsive_style', 99);

function fruitful_get_sliders() {
	$theme_options = fruitful_ret_options("fruitful_theme_options");
	if (!empty($theme_options['select_slider'])) {
		if ($theme_options['select_slider'] == "1") {
			echo fruitful_get_slider_options_flex(); 
		} else if ($theme_options['select_slider'] == "2") {
			echo fruitful_get_slider_options_nivo();
		}	
	}	
}

function fruitful_custom_css_and_slider_scripts() {
	echo '<script type="text/javascript">';
		echo 'jQuery(document).ready(function($) { ';
				fruitful_get_sliders();
		echo '});';
	echo '</script>';
}
add_action('wp_head', 'fruitful_custom_css_and_slider_scripts', 25);

function fruitful_entry_meta() { 
?>
	<span class="author-link"><a href="<?php print esc_url( get_author_posts_url( get_the_author_meta( 'ID' ))); ?>"><?php print get_the_author(); ?></a></span>
	<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
	<?php
		/* translators: used between list items, there is a space after the comma */
		 $categories_list = get_the_category_list( __( ', ', 'fruitful' ) );
	if ( $categories_list && fruitful_categorized_blog() ) : ?>
		<span class="cat-links">
			<?php printf( __( 'Posted in %1$s', 'fruitful' ), $categories_list ); ?>
		</span>
	<?php endif; // End if categories ?>

	<?php
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'fruitful' ) );
		if ( $tags_list ) :
	?>
		<span class="tag-links">
			<?php // printf( __( 'Tagged %1$s', 'fruitful' ), $tags_list ); ?>
			<?php echo $tags_list; ?>
		</span> 
		<?php endif; // End if $tags_list ?>
	<?php endif; // End if 'post' == get_post_type() ?>
<?php 
}

function fruitful_entry_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) )
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'fruitful' );
	else
		$format_prefix = '%2$s';

	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'fruitful' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);

	if ($echo ) echo $date;
	return $date;
}


function fruitful_customize_register( $wp_customize ) {

	class Fruitful_Theme_Options_Button_Control extends WP_Customize_Control {
		public $type = 'button_link_control';
 
		public function render_content() {
			?>
				<label>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<input class="button button-primary save link_to_options" type="button" value="Theme Options" onclick="javascript:location.href='<?php echo esc_url(admin_url('admin.php?page=theme_options')); ?>'"/>
				</label>
			<?php
		}
	}
	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
	
	$wp_customize->remove_section( 'colors');
	$wp_customize->remove_section( 'header_image');
	$wp_customize->remove_section( 'background_image');
	
	$wp_customize->add_section('fruitful_themeoptions_link', array(
							   'title' => __('Fruitful Theme Options', 'fruitful'),
							   'priority' => 10,
							));
	
	$wp_customize->add_setting( 'themeoptions_button_control' );
 
	$wp_customize->add_control(
		new Fruitful_Theme_Options_Button_Control (
        $wp_customize,
        'button_link_control',
        array(
            'label' 	=> 'Advanced theme settings',
			'section' 	=> 'fruitful_themeoptions_link',
            'settings' 	=> 'themeoptions_button_control'
        )
    )
);
}
add_action( 'customize_register', 'fruitful_customize_register' );

function fruitful_customize_preview_js() {
	wp_enqueue_script( 'fruitful-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130226', true );
}
add_action( 'customize_preview_init', 'fruitful_customize_preview_js' );

function fruitful_tabs_main($atts, $content = null) {
	global $tab_counter_2;
	$output = '';
	shortcode_atts(array('tab' => array('')), $atts, 'tabs');
	$tab_counter_1 = 1;
	$tab_counter_2 = 1;
	$tabs = array();
	if (!empty( $atts)) {
		$tabs = $atts;
	}
	
	$output .= '<div class="tabbed-nav" id="tabbed-nav">';
		$output .= '<ul class="resp-tabs-list">';
	if (count($tabs) > 0) {
		foreach ($tabs as $tab) {
			$in_array = explode('=', $tab);
			$output .= '<li><a>';
			if (!empty($in_array[1])) {
				$output .= esc_attr($in_array[1]);
			}	
			$output .= '</a></li>';
			$tab_counter_1++;
		}
	}	
	 
	$output .= '</ul>';
	$output .= '<div class="resp-tabs-container">';
		$output .= fruitful_esc_content_pbr(do_shortcode($content));
	$output .= '</div>';
	$output .='</div>';
	return $output;
	unset($tab_counter_2);
}
add_shortcode('tabs', 'fruitful_tabs_main');

function fruitful_tab_elements($atts, $content = null) {
	global $tab_counter_2;
	$out_tab = '';
	shortcode_atts(array(), $atts);
	$out_tab .= '<div>' . do_shortcode($content) . '</div>';
	$tab_counter_2++;
	return $out_tab;
}
add_shortcode('tab', 'fruitful_tab_elements');


function fruitful_metadevice() {
	$browser = '';				
	$browser_ip	= strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");		
	$browser_an	= strpos($_SERVER['HTTP_USER_AGENT'],"Android");		
	$browser_ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");			 
	if ($browser_ip  	== true) { $browser = 'iphone';  }	 
	if ($browser_an		== true) { $browser = 'android'; } 	 
	if ($browser_ipad 	== true) { $browser = 'ipad'; }

	if($browser == 'iphone') 	{ echo '<meta name="viewport" content="width=480">';  } 
    if($browser == 'android') 	{ echo '<meta name="viewport" content="target-densitydpi=device-dpi, width=device-width" />'; } 
	if($browser == 'ipad') 		{ echo '<meta name="viewport" content="width=768px, minimum-scale=1.0, maximum-scale=1.0" />'; } 
}

function fruitful_esc_content_pbr($content = null) {
	 $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content );
	 $Old     = array( '<br />', '<br>' );
	 $New     = array( '','' );
	 $content = str_replace( $Old, $New, $content );
	 return $content;
}

function fruitful_get_class_pos($index)  {
	if ($index == 0) {
		$pos_class = 'left-pos';
	} else if ($index == 1) {
		$pos_class = 'center-pos';	
	} else {
		$pos_class = 'right-pos';		
	}
	
	return $pos_class;
}

function fruitful_kses_data($text = null) {
	$allowed_tags = wp_kses_allowed_html( 'post' );
	return wp_kses($text, $allowed_tags);
}

function fruitful_get_languages_list(){
    $theme_options = fruitful_ret_options("fruitful_theme_options");
	if( function_exists('icl_get_languages') && $theme_options['is_wpml_ready'] == 'on' ){ 
		$languages = icl_get_languages('skip_missing=0');
		if(!empty($languages)){
			echo '<div id="header_language_select"><ul id="lang-select-block">';
			foreach($languages as $l){
				if($l['active']) {
					echo '<li class="current">';
						echo '<a class="'.$l['language_code'].'" href="'.$l['url'].'" onclick="return false">';
							echo $l['language_code'];
						echo '</a>';
					echo '<ul id="lang-select-popup">';					
					
						echo '<li class="active">';
							echo '<a class="'.$l['language_code'].'" href="'.$l['url'].'" onclick="return false">';
								echo $l['native_name'];
							echo '</a>';
						echo '</li>';
				} 
					
			}
			foreach($languages as $l){
				if(!($l['active'])) {
						echo '<li class="unactive">';
						echo '<a class="'.$l['language_code'].'" href="'.$l['url'].'">';
							echo $l['native_name'];
						echo '</a></li>';
				}
			}
					echo '</ul>';
				echo '</li>';					
			echo '</ul></div>';
		}
	}
}

/*woocommerce theme support*/
add_theme_support( 'woocommerce' );

/*remove sidebar from all woocommerce pages except shop page*/
if (class_exists('Woocommerce')) { 
	add_action( 'wp', 'init' );
	function init() {
		if ( !is_shop() && !is_product_category()) {
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
		}
	}
}


/*rewrite pagenavi for woocommerce*/
function fruitful_wp_corenavi() {  
	global $wp_query, 
			$wp_rewrite;  
	$next_label = $prev_label = '';
	if (wp_is_mobile()) {
		$next_label = ' &laquo; '; 
		$prev_label = ' &raquo; ';
	} else {
		$next_label = '&laquo; Previous Page';
		$prev_label = 'Next Page &raquo;'; 
	}
	
	$pages = '';  
	$max = $wp_query->max_num_pages;  
	if (!$current = get_query_var('paged')) {
		$current = 1;  
	} 
	 
	$a['base']    = str_replace(999999999, '%#%', get_pagenum_link(999999999));  
	$a['total']   = $max;  
	$a['current'] = $current;  
	  
	$total = 0;    //1 - display the text "Page N of N", 0 - not display  
	$a['mid_size'] = 2;  //how many links to show on the left and right of the current  
	$a['end_size'] = 1;  //how many links to show in the beginning and end  
	$a['prev_text'] = '';  //text of the "Previous page" link  
	$a['next_text'] = '';  //text of the "Next page" link  
	  
	if  ($max > 1) {
		echo '<div class="pagination nav-links shop aligncenter">';  
	} 
	if  ($total == 1 && $max > 1) {
		$pages = '<span class="pages">Page ' . $current . ' of ' . $max . '</span>'."\r\n";  
	} 
	echo '<div class="nav-previous ">'; previous_posts_link($next_label); echo '</div>';
		echo '<div class="pages-links">';
			echo $pages . paginate_links($a);  
		echo '</div>';
	echo '<div class="nav-next">';  next_posts_link($prev_label); echo '</div>';
	if ($max > 1) {
		echo '</div>';  
	} 
}

if (class_exists('Woocommerce')) { 
	remove_action('woocommerce_pagination', 'woocommerce_pagination', 10);
	add_action( 'woocommerce_pagination', 'woocommerce_pagination', 10);
}
function woocommerce_pagination() { 
	fruitful_wp_corenavi();
}

/*rewrite get_product_search_form() function*/
function fruitful_get_product_search_form(){
	?>
	<form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
			<div>
				<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php _e( 'Search for products', 'woocommerce' ); ?>" />
				<input type="submit" id="searchsubmit" value="<?php echo esc_attr__( 'Search' ); ?>" />
				<input type="hidden" name="post_type" value="product" />
			</div>
		</form>
	<?php
}

/*change title in tabs on single product page*/
if (class_exists('Woocommerce')) { 
	add_filter('woocommerce_product_description_heading','fruitful_product_description_heading');
}
function fruitful_product_description_heading() {
   return '';
}

/*4 cross products for cart*/
if (class_exists('Woocommerce')) { 
	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
	add_action( 'woocommerce_cart_collaterals', 'fruitful_woocommerce_cross_sell_display' );
}

function fruitful_woocommerce_cross_sell_display(){
	
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	global $woocommerce_loop, $woocommerce, $product;
	$crosssells = $woocommerce->cart->get_cross_sells();
	if ( sizeof( $crosssells ) == 0 ) return;
	$meta_query = $woocommerce->query->get_meta_query();
	$args = array(
		'post_type'           => 'product',
		'ignore_sticky_posts' => 1,
		'posts_per_page'      => apply_filters( 'woocommerce_cross_sells_total', 4 ),
		'no_found_rows'       => 1,
		'orderby'             => 'rand',
		'post__in'            => $crosssells,
		'meta_query'          => $meta_query
	);
	$products = new WP_Query( $args );
	$woocommerce_loop['columns'] 	= apply_filters( 'woocommerce_cross_sells_columns', 4 );
	if ( $products->have_posts() ) : ?>
		<div class="cross-sells">
			<h2><?php _e( 'You may be interested in&hellip;', 'woocommerce' ) ?></h2>
			<?php woocommerce_product_loop_start(); ?>
				<?php while ( $products->have_posts() ) : $products->the_post(); ?>
					<?php woocommerce_get_template_part( 'content', 'product' ); ?>
				<?php endwhile; // end of the loop. ?>
			<?php woocommerce_product_loop_end(); ?>
		</div>
	<?php endif;
	wp_reset_query();
	
}

/*4 related products for single-product*/
function fruitful_woocommerce_related_products_limit() {
		global $product;
		$args = array(
			'post_type'        		=> 'product',
			'no_found_rows'    		=> 1,
			'posts_per_page'   		=> 4,
			'ignore_sticky_posts' 	=> 1,
			'orderby'             	=> $orderby,
			'post__in'            	=> $related,
			'post__not_in'        	=> array($product->id)
		);
		return $args;
	}

if (class_exists('Woocommerce')) { 
	add_filter( 'woocommerce_related_products_args', 'fruitful_woocommerce_related_products_limit' ); 
}

// Update cart contents update when products are added to the cart via AJAX 
if (class_exists('Woocommerce')) { 
	add_filter('add_to_cart_fragments', 'fruitful_woocommerce_header_add_to_cart_fragment');
}
function fruitful_woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	?>
	<a href="<?php echo get_permalink( woocommerce_get_page_id( 'cart' ) ); ?>" class="cart-contents">
		<div class="cart_image"></div>
		<span class="num_of_product_cart"><?php global $woocommerce;
		 echo sprintf(_n('%d ', '%d ', $woocommerce->cart->cart_contents_count, 'fruitful'), $woocommerce->cart->cart_contents_count); ?> </span>
	</a>
	<?php
	$fragments['a.cart-contents'] = ob_get_clean();
	return $fragments;
}


function fruitful_is_woo_sidebar() {
	$is_sidebar = true;
	if (class_exists('Woocommerce')) { 
		if (is_cart() || is_checkout() || is_account_page()) {
 			 $is_sidebar = false;
		}
	}	
	return $is_sidebar;
}

/* Add sidebar option for Standard Post */
function fruitful_add_post_sidebar() {  
	$screens = array( 'post');
	foreach ( $screens as $screen ) {
		 add_meta_box(
            'fruitful_post_sidebar_metaboxes',
            __( 'Page Attributes', 'fruitful' ),  
            'fruitful_post_sidebar_metaboxes_inner',
            $screen,
			'side',
			'low'
        );
	}					
}  
add_action( 'add_meta_boxes', 'fruitful_add_post_sidebar', 99 );

function fruitful_post_sidebar_metaboxes_inner($post ){
	wp_nonce_field( 'fruitful_post_sidebar_metaboxes', 'fruitful_post_sidebar_metaboxes_nonce' );
	$frutiful_posts_template = (get_post_meta( $post->ID, 'frutiful_posts_template', true ) !== '' ? get_post_meta( $post->ID, 'frutiful_posts_template', true ) : '3');
	?>
	<label for="frutiful_posts_template_val" class="screen-reader-text"><?php _e( 'Template', 'fruitful' ); ?></label>
	<select id="frutiful_posts_template" name="frutiful_posts_template">
		<option value="1" <?php selected( $frutiful_posts_template, 1 ); ?>><?php _e('Left sidebar Template','fruitful'); ?></option>
		<option value="2" <?php selected( $frutiful_posts_template, 2 ); ?>><?php _e('Full width Template','fruitful'); ?></option>
		<option value="3" <?php selected( $frutiful_posts_template, 3 ); ?>><?php _e('Right sidebar Template','fruitful'); ?></option>
	</select>
	<p class="howto"><?php _e( 'Choose template for post', 'fruitful' ); ?></p>
	<?php
}

function fruitful_post_sidebar_metabox_save( $post_id ) {
	if ( ! isset( $_POST['fruitful_post_sidebar_metaboxes_nonce'] ) )
		return $post_id;
	$nonce = $_POST['fruitful_post_sidebar_metaboxes_nonce'];

	if ( ! wp_verify_nonce( $nonce, 'fruitful_post_sidebar_metaboxes' ) )
		return $post_id;

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return $post_id;

	if ( 'post' == $_POST['post_type'] ) {
	if ( ! current_user_can( 'edit_page', $post_id ) )
		return $post_id;
	} else {
	if ( ! current_user_can( 'edit_post', $post_id ) )
		return $post_id;
	}
	
	$frutiful_posts_template = $_POST['frutiful_posts_template'];
	update_post_meta( $post_id, 'frutiful_posts_template', $frutiful_posts_template );
}
add_action( 'save_post', 'fruitful_post_sidebar_metabox_save' );


function fruitful_get_content_with_custom_sidebar($curr_template) {
	function get_content_part() {
		global $post;
		while ( have_posts() ) : the_post();
			get_template_part( 'content', get_post_format() );
			fruitful_content_nav( 'nav-below' );
			if (fruitful_state_post_comment()) {
				if ( comments_open() || '0' != get_comments_number() ) comments_template(); 
			}
		endwhile;
	}
	function get_html_custom_post_template($content_, $sidebar_, $type_ = 1) { ?>
		<?php if ($type_ == 1) { ?>
		<div class="eleven columns <?php echo $content_;?>">
		<?php } else { ?>
		<div class="sixteen columns <?php echo $content_ . ' ' . $sidebar_;?>">
		<?php } ?>
			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">
					<?php get_content_part(); ?>				
				</div><!-- #content .site-content -->
			</div><!-- #primary .content-area -->
		</div>
		<?php if ($type_ == 1) { ?>
			<div class="five columns <?php echo $sidebar_;?>">
				<?php get_sidebar('single-post'); ?>
			</div>
		<?php } ?>
	<?php	
	}
	if ($curr_template == 1) { 
		get_html_custom_post_template('omega', 'alpha');
	} else if ($curr_template == 3) { 
		get_html_custom_post_template('alpha', 'omega');
	} else if ($curr_template == ''){
		get_html_custom_post_template('alpha', 'omega');
	} else {
		get_html_custom_post_template('omega', 'alpha', 0);
	}
}