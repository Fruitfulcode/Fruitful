<?php
class fruitful_theme_options_customizer {
	public $sections = array();
	public $args     = array();

	public function __construct() {
		add_action('init', array( $this, 'init_settings'), 11 );
		add_action('customize_register' , array($this, 'register_settings'));
		add_action('customize_controls_enqueue_scripts'	, array($this , 'tc_customize_controls_js_css'));
	}

	public function init_settings () {
		$this->settings_fields();
		require_once get_template_directory() . '/inc/theme-options/customizer/class-customize-control.php';	
		require_once get_template_directory() . '/inc/theme-options/theme-options.php';		
	}	
	
	public function tc_customize_controls_js_css() {
		wp_enqueue_style('c-style',				get_template_directory_uri() . '/inc/css/customizer-style.css');
		wp_enqueue_style('ch-style',			get_template_directory_uri() . '/inc/js/ch/ch.css');
		wp_enqueue_style('sl-style',			get_template_directory_uri() . '/inc/js/sl/jquery.formstyler.css');
		wp_enqueue_script('chJq',				get_template_directory_uri() . "/inc/js/ch/ch.js", array('jquery'));
		wp_enqueue_script('slJq',				get_template_directory_uri() . "/inc/js/sl/jquery.formstyler.min.js", array('jquery'));
		wp_enqueue_script( 'custom-customize',  get_template_directory_uri() . '/inc/js/custom.customize.js', array( 'jquery', 'customize-controls' ), false, true );
	}	

	public function settings_fields () {
		global $fruitful_theme_options;
		$this->sections = $fruitful_theme_options->settings_fields();
	}

	public function register_settings ($wp_customize) {
		global $fruitful_theme_options;
		$opt_name = $fruitful_theme_options->args['opt_name'];	
		$theme_options  = fruitful_get_theme_options();
		$height = (isset($theme_options['header_height'])) ? $theme_options['header_height'] : 80;
		
		$wp_customize->add_panel($opt_name, array(
			'priority'          => 10,
			'capability'        => 'edit_theme_options',
			'theme_supports'    => '',
			'title'             => __('Fruitful Theme Options', 'fruitful'),
			'description'       => '',
		));
		$type = 'option'; 
		if ( is_array($this->sections)) {
			foreach ($this->sections as $option ) {
				$priority 		= (isset($option['priority'])) ? $option['priority'] : 10;
				$id 			= (isset($option['id'])) ? $option['id'] : '';
				$title 			= (isset($option['title'])) ? esc_attr($option['title']) : '' ;
				$description 	= (isset($option['description'])) ? esc_attr($option['description']) : '';

				$wp_customize->add_section(esc_attr($id), array(
					'priority'          => $priority,
					'title'             => $title,
					'description'       => $description,
					'panel'             => $opt_name,
				) );
				foreach ( $option['fields'] as $field) {
					$f_id		 	= (isset($field['id'])) ? esc_attr($field['id']) : '';	
					$f_default		= (isset($field['default'])) ? esc_attr($field['default']) : '';
					$f_label 		= (isset($field['label'])) ? esc_attr($field['label']) : '';
					$f_description 	= (isset($field['description'])) ? esc_attr($field['description'])  : '';
					$f_info 		= (isset($field['info'])) ? esc_attr($field['info']) : '';
					$f_type 		= (isset($field['type'])) ? esc_attr($field['type']) : '';
					$f_choices  	= (isset($field['options'])) ? $field['options'] : array();
					$section 		= (isset($option['id'])) ? esc_attr($option['id']) : '';
			
					if ($f_type == 'checkbox') {
						$sanitize =  'fruitful_theme_sanitize_checkbox';
					}	
					else {
						$sanitize = '';
					}							
					if (!empty($field['fields'])) {
						foreach ($field['fields'] as $key=>$group) {
							$g_default 		= (isset($group['default'])) ? esc_attr($group['default']) : '';
							$g_label 		= (isset($group['label'])) ? esc_attr($group['label']) : '';
							$g_description 	= (isset($group['description'])) ? esc_attr( $group['description']) : '';
							$g_info 		= (isset($group['info'])) ? esc_attr($group['info']) : '';
							$g_boxtitle 	= (isset($group['box-title'])) ? esc_attr($group['box-title']) : '';		
							$g_type 		= (isset($group['type'])) ? esc_attr($group['type']) : '';	
							$g_choices 		= (isset($group['options'] )) ? $group['options'] : array();
							$g_id 			= (isset($group['id'])) ? esc_attr($group['id']) : '';	

							if ($g_type == 'checkbox') {
								$sanitize =  'fruitful_theme_sanitize_checkbox';
							}
							else {
								$sanitize = '';
							}
							$id = $opt_name . '['.$g_id.']';
							$wp_customize->add_setting(esc_attr($id), array(
								'default'           => $g_default,
								'type'              => $type,
								'capability'        => 'edit_theme_options',
								'sanitize_callback'	=> $sanitize
							));
							 if ($key == 0) {
								$top_label = $field['label'];
								$top_info  = $field['info'];
							 }
							 else {
								$top_label = '';
								$top_info  = '';
							 }

							 switch ( $g_type ) {
								case 'checkbox':
									$wp_customize->add_control(new Fruitful_Customize_Checkbox_Control($wp_customize, esc_attr($id), array(
										'type'              => 'checkbox',
										'priority'          => $priority,
										'section'           => $section,
										'label'             => $g_label,
										'description'       => $g_description,
										'info' 				=> $g_info,	
										'top_label'			=> $top_label,
										'top_info'			=> $top_info,
										
									)));
								break;
								case 'text':
									$wp_customize->add_control(new Fruitful_Customize_Text_Control($wp_customize, esc_attr($id), array(
										'type'              => 'text',
										'priority'          => $priority,
										'section'           => $section,
										'label'             => $g_label,
										'description'       => $g_description,
										'info' 				=> $g_info,
										'top_label'			=> $top_label,
										'top_info'			=> $top_info,
										'box_title'			=> $g_boxtitle							
									)));
								break;
								case 'select':
									$wp_customize->add_control(new Fruitful_Customize_Select_Control($wp_customize, esc_attr($id), array(
										'type'              => 'select',
										'priority'          => $priority,
										'section'           => $section,
										'label'             => $g_label,
										'description'       => $f_description,
										'choices'           => $g_choices,
										'info' 				=> $g_info,	
										'top_label'			=> $top_label,
										'top_info'			=> $top_info,								
										'box_title'			=> $g_boxtitle								
									)));
								break;
								case 'image':
								if (class_exists( 'WP_Customize_Cropped_Image_Control' ) && $id == $opt_name . '[header_img]') {
										$wp_customize->add_control(new WP_Customize_Cropped_Image_Control( $wp_customize, esc_attr($id), array(
											'priority'          => $priority,
											'section'           => $section,
											'label'             => $f_label,
											'description'       => $f_info,
											'flex_width'  => true, 
											'flex_height' => false,
											'width'       => 1600,
											'height'      => $height									
										)));
								 }
								 else {
									$wp_customize->add_control(new WP_Customize_Image_Control( $wp_customize, esc_attr($id), array(
										'priority'          => $priority,
										'section'           => $section,
										'label'             => $f_label,
										'description'       => $f_info,
									)));
								}	
								break;
								case 'color':
									$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, esc_attr($id), array(
										'priority'          => $priority,
										'section'           => $section,
										'label'             => $top_label,
										'description'       => $g_boxtitle,
										'info' 				=> $g_info,										
									)));
								break;
								case 'textarea':
									$wp_customize->add_control(new Fruitful_Customize_Textarea_Control($wp_customize, esc_attr($id), array(
										'priority'          => $priority,
										'section'           => $section,
										'label'             => $g_label,
										'description'       => $g_description,
										'info' 				=> $g_info,
									)));
								break;
							}					
						}
					}	

					$id = $opt_name . '['.$f_id.']';
					$wp_customize->add_setting(esc_attr($id), array(
						'default'           => $f_default,
						'type'              => $type,
						'capability'        => 'edit_theme_options',
						'sanitize_callback'	=> $sanitize
					) );
			
					switch ($f_type) {
						case 'checkbox':
							$wp_customize->add_control(new Fruitful_Customize_Checkbox_Control($wp_customize, esc_attr($id), array(
								'type'              => 'checkbox',
								'priority'          => $priority,
								'section'           => $section,
								'label'             => $f_label,
								'description'       => $f_description,
								'info' 				=> $f_info,	
							)));
						break;
						case 'text':
							$wp_customize->add_control(new Fruitful_Customize_Text_Control($wp_customize, esc_attr($id), array(
								'type'              => 'text',
								'priority'          => $priority,
								'section'           => $section,
								'label'             => $f_label,
								'description'       => $f_description,
								'info' 				=> $f_info,
							)));
						break;
						case 'select':
							$wp_customize->add_control(new Fruitful_Customize_Select_Control($wp_customize, esc_attr($id), array(
								'type'              => 'select',
								'priority'          => $priority,
								'section'           => $section,
								'label'             => $f_label,
								'description'       => $f_description,
								'choices'           => $f_choices,
								'info' 				=> $f_info,									
							)));
						break;
						case 'font':
							$wp_customize->add_control(new Fruitful_Customize_Font_Control($wp_customize, esc_attr($id), array(
								'type'              => 'select',
								'priority'          => $priority,
								'section'           => $section,
								'label'             => $f_label,
								'description'       => $f_description,
								'choices'           => $f_choices,
								'info' 				=> $f_info,									
							)));
						break;						
						case 'image':
							$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, esc_attr($id), array(
								'priority'          => $priority,
								'section'           => $section,
								'label'             => $f_label,
								'description'       => $f_info,
							)));
						break;
						case 'color':
							$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, esc_attr($id), array(
								'priority'          => $priority,
								'section'           => $section,
								'label'             => $f_label,
								'description'       => $f_info,
							)));
						break;
						case 'textarea':
							$wp_customize->add_control(new Fruitful_Customize_Textarea_Control($wp_customize, esc_attr($id), array(
								'priority'          => $priority,
								'section'           => $section,
								'label'             => $f_label,
								'description'       => $f_description,
								'info' 				=> $f_info,
							)));
						break;
					}
				}
			}
		}
		$wp_customize->remove_section('slider');	
	}
}	
global $fruitful_theme_options_customizer;	
$fruitful_theme_options_customizer = new fruitful_theme_options_customizer();

