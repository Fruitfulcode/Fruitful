<?php
function fruitful_slide_anim_list() {
	$slide_anim_options = array(
		'0' => array(
			'value' =>	   'fade',
			'label' => __( 'fade', 'fruitful' )
		),
		'1' => array(
			'value' =>	   'slide',
			'label' => __( 'slide', 'fruitful' )
		)
	);

	return apply_filters( 'fruitful_slide_anim_list', $slide_anim_options );
}

function fruitful_slide_direction_list() {
	$slide_direct_options = array(
		'0' => array(
			'value' =>	   'horizontal',
			'label' => __( 'horizontal', 'fruitful' )
		),
		'1' => array(
			'value' =>	   'vertical',
			'label' => __( 'vertical', 'fruitful' )
		)
	);

	return apply_filters( 'fruitful_slide_direction_list', $slide_direct_options );
}

function fruitful_bool_list() {
	$font_bool_options = array(
		'0' => array(
			'value' =>	   'true',
			'label' => __( 'true', 'fruitful' )
		),
		'1' => array(
			'value' =>	   'false',
			'label' => __( 'false', 'fruitful' )
		)
	);
	return apply_filters( 'fruitful_bool_list', $font_bool_options);
}



function fruitful_fonts_list() {
	$font_family_options = array(
		'0' => array(
			'value' =>	   'Verdana, Geneva, sans-serif',
			'label' => __( 'Verdana, Geneva, sans-serif', 'fruitful' )
		),
		'1' => array(
			'value' =>	   'Georgia, Times New Roman, Times, serif',
			'label' => __( 'Georgia, Times New Roman, Times, serif', 'fruitful' )
		),
		'2' => array(
			'value' => 	   	'Courier New, Courier, monospace',
			'label' => __( 	'Courier New, Courier, monospace', 'fruitful' )
		),
		'3' => array(
			'value' => 	   'Arial, Helvetica, sans-serif',
			'label' => __( 'Arial, Helvetica, sans-serif', 'fruitful' )
		),
		'4' => array(
			'value' => 	   'Tahoma, Geneva, sans-serif',
			'label' => __( 'Tahoma, Geneva, sans-serif', 'fruitful' )
		),
		'5' => array(
			'value' => 	   'Trebuchet MS, Arial, Helvetica, sans-serif',
			'label' => __( 'Trebuchet MS, Arial, Helvetica, sans-serif', 'fruitful' )
		),
		'6' => array(
			'value' => 	   'Arial Black, Gadget, sans-serif',
			'label' => __( 'Arial Black, Gadget, sans-serif', 'fruitful' )
		),
		'7' => array(
			'value' => 	   'Times New Roman, Times, serif',
			'label' => __( 'Times New Roman, Times, serif', 'fruitful' )
		),
		'8' => array(
			'value' => 	   'Comic Sans MS, cursive',
			'label' => __( 'Comic Sans MS, cursive', 'fruitful' )
		),
		'9' => array(
			'value' => 	   'Open Sans, sans-serif',
			'label' => __( 'Open Sans, sans-serif', 'fruitful' )
		)
	);

	return apply_filters( 'fruitful_fonts_list', $font_family_options );
}

 function custom_do_settings_sections($page) {
    global $wp_settings_sections, $wp_settings_fields;
	$id_=0;
	$optins = (array) get_option( 'fruitful_theme_options' );
    if ( !isset($wp_settings_sections) || !isset($wp_settings_sections[$page]) )
        return;
    foreach( (array) $wp_settings_sections[$page] as $section ) {

		if ($section['title'] != "") {
		   print "<h3>{$section['title']}</h3>\n";
		}
        call_user_func($section['callback'], $section);
        if ( !isset($wp_settings_fields) ||
             !isset($wp_settings_fields[$page]) ||
             !isset($wp_settings_fields[$page][$section['id']]) )
                continue;
        	 
			$name_id = "settings-section-" . $id_;
			 print '<div id="'. $name_id .'" class="settings-section">';
					custom_do_settings_fields($page, $section['id']);
			 print '</div>';
		$id_++;		 
    }
}


function custom_do_settings_fields($page, $section) {
    global $wp_settings_fields;
	$id_=0;

    if ( !isset($wp_settings_fields) ||
         !isset($wp_settings_fields[$page]) ||
         !isset($wp_settings_fields[$page][$section]) )
        return;
		
    foreach ( (array) $wp_settings_fields[$page][$section] as $field ) {
        print '<div id="set_form_row_' . $id_ .'" class="settings-form-row">';
        if ( !empty($field['args']['label_for']) )
            print '<h3 class="main-header-options">' . $field['title'];
        else
            print '<h3 class="main-header-options">' . $field['title'];
			print '</h3>';
				print '<span class="add_element_info">'.$field['args']['info'].'</span>';
				print '<div class="box-options">';
				call_user_func($field['callback'], $field['args']);
		print '</div></div>';
			$id_++;		 
    }
}

function add_admin_style() {
	wp_enqueue_style('admin-style', 		ADMIN_STYLE . 'admin.css');
	wp_enqueue_style('colorpicker-style',	ADMIN_JQS 	   . 'colorpicker/colorpicker.css');
	wp_enqueue_style('ch-style',				ADMIN_JQS 	   . 'ch/ch.css');
	wp_enqueue_style('sl-style',				ADMIN_JQS 	   . 'sl/sl.css');
}

function add_jquery_script() {
	wp_deregister_script	("main-jquery");
	wp_register_script		("main-jquery", "http://code.jquery.com/jquery-1.8.2.min.js", array('jquery'));
	wp_enqueue_script	("main-jquery");
	
	wp_enqueue_script('admin-jQuery-fruit',	ADMIN_JQS . "main.js", array('jquery'));
	wp_enqueue_script('color-picker',			ADMIN_JQS . "colorpicker/colorpicker.js", array('jquery'));
	wp_enqueue_script('ajaxupload',   			ADMIN_JQS . "ajaxupload.js", array('jquery'));
	/*ui*/
	wp_enqueue_script('core-js',   				ADMIN_JQS . "ui/jquery.ui.core.min.js", array('jquery'));
	wp_enqueue_script('widget-js',				ADMIN_JQS . "ui/jquery.ui.widget.min.js", array('jquery'));
	wp_enqueue_script('mouse-js',				ADMIN_JQS . "ui/jquery.ui.mouse.min.js", array('jquery'));
	wp_enqueue_script('draggable-js',			ADMIN_JQS . "ui/jquery.ui.draggable.min.js", array('jquery'));
	wp_enqueue_script('sortable-js',				ADMIN_JQS . "ui/jquery.ui.sortable.min.js", array('jquery'));
	
	wp_enqueue_script('dialog',						ADMIN_JQS . "ui/jquery.ui.dialog.min.js", array('jquery'));
	wp_enqueue_script('position',					ADMIN_JQS . "ui/jquery.ui.position.min.js", array('jquery'));
	
	wp_enqueue_script('chJq',						ADMIN_JQS . "ch/ch.js", array('jquery'));
	wp_enqueue_script('slJq',						ADMIN_JQS . "sl/sl.js", array('jquery'));
	}

function file_upload($action, $dir_upload = '/fruitfulimg/', $name_options= 'fruitful_theme_options', $w=400, $h=400)
	{
		$upload_dir = wp_upload_dir();
  		$dir = $upload_dir[ 'basedir' ] . $dir_upload;
        $url = $upload_dir[ 'baseurl' ] . $dir_upload;
			
		$options = (array) get_option($name_options);
		$field_name = $_POST['data']; 
		
		
		
	if ($action == "upload") {
		$file = array( 
					'tmp_name'  	=> $_FILES[$field_name]['tmp_name'],
					'name' 			=> $_FILES[$field_name]['name'],
					'size' 		 	=> $_FILES[$field_name]['size'],
					'error' 		  	=> $_FILES[$field_name]['error']
				 );
				 
			$file['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $file['name']); 

		if ( !file_exists( dirname($dir) ) ) {
			mkdir( dirname($dir) );
		}
	
		if ( !file_exists( $dir ) ) {
			mkdir( $dir );
		}
		
		if ( $file['name'] ) {
			$filename = strtolower($file['name']);
			move_uploaded_file( $file['tmp_name'], $dir . $filename );
			
			$file_url = $url . $filename;
			$data = array($field_name => $file_url);

			if(!empty($data)) {
				$compare_new	    = array_diff ($options, $data);
				$compare_old     	= array_diff ($data, $options);
				$compare 	 			= array_merge ($compare_new, $compare_old);
			} else {
				$compare = array();
			}
			
			if(!empty($compare)) {
	        if(update_option($name_options, $compare)) {
	           
			   return get_thumb_img ($file_url, $w, $h);
	        } else {
	           return 'Error! No file upload...';
	        }
			}
		}
	}
	else {
			$file_del = basename($options[$field_name]);
			unlink($dir . $file_del);
			
			unset($options[0]);
			unset($options[$field_name]);
			$compare = $options;
			
			 if(update_option($name_options, $compare)) {
	           print_r($compare);
	        } else {
	           return 'Error! No file delete...';
	        }
		}
}


function get_thumb_img ($path, $w, $h)	 {
			return get_bloginfo('template_url') . '/inc/functions/timthumb.php?src=' . $path . '&h=' . $h . '&w=' . $w . '&zc=0';
}

function get_code_upload_images($val, $field, $w, $h, $btn_class_upload = 'upload_btn', $btn_class_reset = 'reset_btn', $class_img = '', $no_name = false) {
	$out  = $none = "";
	
	if ($no_name != false) {
		$out .= '<input class="of-input" id="'. $field .'_upload" type="text" value="'. $val .'" />';
		
	} else { 
		$out .= '<input class="of-input" name="fruitful_theme_options['. $field .']" id="'. $field .'_upload" type="text" value="'. $val .'" />';
	}
	
	$out .= '<div class="upload_button_div"><span class="button '. $btn_class_upload .'" id="'. $field .'">Upload Image</span>';
	if(!empty($val)) {$none = '';} else { $none = 'none';}
	$out .= '<span class="button ' . $btn_class_reset . ' ' . $none .'" id="reset_'. $field .'" title="' . $field . '">Remove</span>';
	$out .='</div>' . "\n";

	if(!empty($val)){
		$out .= '<img class="upload-image ' . $class_img . '" id="image_' . $field . '" src="'. get_thumb_img ($val, $w, $h) .'" alt=""/>';
		}
	return $out;
}


function get_select_fields($field_name, $options, $array_of_values, $class_name = "selected") {
		$out = '';
		$out .= '<select class="'. $class_name .'" name="fruitful_theme_options['.$field_name.']" id="options-'.$field_name.'">' . chr(13);
		$selected = $options[$field_name];
		$p = $r = '';

			foreach ( $array_of_values as $option ) {
				$label = $option['label'];
				if ( $selected == $option['value'] ) // Make default first in list
					$p = "\n\t<option style=\"padding-right: 10px;\" selected='selected' value='" . esc_attr( $option['value'] ) . "'>$label</option>";
				else
					$r .= "\n\t<option style=\"padding-right: 10px;\" value='" . esc_attr( $option['value'] ) . "'>$label</option>";
			}
			$out .= $p . $r;
		
	$out .= '</select>' . chr(13);
	echo $out;
}
	
function ret_options ($name_options) {
   return $options = array_filter((array) get_option($name_options));
}
 
function remove_dir($dir)  {
	$all_files = scandir($dir);
	if (count($all_files) != 0) {
		for ($i = 2; $i <= count($all_files); $i++) {
			if (is_dir($dir . '/' . $all_files[$i])) {
				
				$sub_dir = $dir . '/' . $all_files[$i];
				$all_sub_files = scandir($sub_dir);
					for ($m = 2; $m <= count($all_sub_files); $m++) {
						if (!is_dir($sub_dir . '/' . $all_sub_files[$m])) {
							unlink($sub_dir . '/' . $all_sub_files[$m]);
						}
					}
				rmdir($sub_dir);	
				} else {
			  unlink ($dir . '/' . $all_files[$i]);
			}
		}
	}	
}	



function get_default_array() {
return array(
				/*General Settings*/
				'responsive'					=> 'on',
			
				'postcomment'				=> 'on',
				'pagecomment'				=> 'on',
		
		
				/*Background Image*/
				'backgroung_img'        	=> '',
				'background_color'			=> '#ffffff', 
				'bg_repeating'				=> 'off',
			
				/*logo*/
				'logo_img'						=> '',
				'logo_w'							=> '160',
				'logo_h'							=> '60',
				
				/*menu*/
				'menu_btn_color'			=> '#e1704b',
				'menu_boxsh_color'		=> '#000000',
				'menu_hover_color'			=> '#ffffff',
				'menu_txtsh_color'			=> '#84442c',
				'menu_font_color'			=> '#333333',		
				
				/*fonts*/
				'h_font_family'				=> 'Open Sans, sans-serif',
				'h1_size'						=> '26',
				'h2_size'						=> '24',
				'h3_size'						=> '18',
				'h4_size'						=> '14',
				'h5_size'						=> '12',
				'h6_size'						=> '10',
				'p_font_family'				=> 'Open Sans, sans-serif',
				'p_size'							=> '12',
				
				/*slider*/
				's_width'						=> '960',
				's_height'						=> '500',
				's_animation'					=> 'fade', 
				's_direction'					=> 'horizontal',
				's_reverse'						=> 'false',
				's_slideshow'					=> 'true',
				's_slideshowSpeed'		=> '7000',
				's_animationSpeed'		=> '600',
				's_initDelay'					=> '0',
				's_randomize'				=> 'false',
				's_controlnav'					=> 'true',
				
				/*footer*/
				'footer_text'					=> stripslashes('Fruitful theme powered by Wordpress'),
				'tracking_code'				=> '',
				
				/*socials*/
				'facebook_url' 				=> '',
				'twitter_url' 					=> '',
				'linkedin_url'					=> '',
				'myspace_url'				=> '',
				'googleplus_url'				=> '',
				'dribbble_url'					=> '',
				'skype_link'					=> '',
				'flickr_link'						=> '',
				'youtube_url'					=> '',
				'rss_link'						=> ''			
		);
	
}
?>