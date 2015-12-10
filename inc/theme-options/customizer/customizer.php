<?php
class fruitful_theme_options_customizer {


	public $sections = array();
	public $args     = array();

	public function __construct() {
		//add_action( 'admin_init', array( $this, 'customizer_update' ),99 );
		add_action( 'init', array( $this, 'init_settings' ), 11 );
		add_action( 'customize_register' , array( $this, 'register_settings' ) );
		add_action ( 'customize_controls_enqueue_scripts'	, array( $this , 'tc_customize_controls_js_css' ));
	}

	public function init_settings () {
		$this->settings_fields();
		require_once get_template_directory() . '/customizer/class-customize-control.php';	
		require_once get_template_directory() . '/inc/theme-options/theme-options.php';		
	}	
	
	// public function customizer_update () {
		// $options = (array) get_option( 'fruitful_theme_options' );
		// if (isset ($options) && ($options != null) ) {
			// foreach ($options as $key=>$val) {
			// update_option( $key, $val );
			
			// }
			// if (($options['responsive'] == 'off')) 	  	{update_option('responsive','');}
			// if (($options['postcomment'] =='off')) 	  	{update_option('postcomment','');}
			// if (($options['pagecomment'] == 'off')) 	{update_option('pagecomment','');}
			// if (($options['is_fixed_header'] == 'off')) {update_option('is_fixed_header','');}
			// if (($options['styletheme'] == 'off')) 	  	{update_option('styletheme','');}
			// if (($options['showcart'] == 'off')) 	 	{update_option('showcart','');}
			// if (($options['is_wpml_ready'] == 'off'))   {update_option('is_wpml_ready','');}
			// if (($options['bg_repeating'] == 'off')) 	{update_option('bg_repeating','');}					
		// }
	// }	
	
	
	
function tc_customize_controls_js_css() {
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

	$wp_customize->add_panel( $opt_name, array(
		'priority'          => 10,
		'capability'        => 'edit_theme_options',
		'theme_supports'    => '',
		'title'             => 'Fruitful Theme Options',
		'description'       => '',
	));
	$type = 'option'; 
	if ( is_array($this->sections ) ) {
		foreach ($this->sections as $option ) {
			$wp_customize->add_section( esc_attr( $option['id'] ), array(
				'priority'          => $option['priority'],
				'title'             => $option['title'],
				'description'       => $option['description'],
				'panel'             => $opt_name,
			) );
			foreach ( $option['fields'] as $field) {

			if (!empty($field['fields'])) {
				foreach ($field['fields'] as $key=>$group) {

					$wp_customize->add_setting( esc_attr( $group['id'] ), array(
						'default'           => $group['default'],
						'type'              => $type,
						'capability'        => $capability,
					));
					 if ($key == 0) {
						$top_label = $field['label'];
						$top_info = $field['info'];
					 }
					 else {
						$top_label = '';
						$top_info = '';
					 }

					 switch ( $group['type'] ) {
						case 'checkbox':
							$wp_customize->add_control( new Fruitful_Customize_Checkbox_Control( $wp_customize, esc_attr( $group['id'] ), array(
								'type'              => 'checkbox',
								'priority'          => $priority,
								'section'           => $option['id'],
								'label'             => $group['label'],
								'description'       => $group['description'],
								'info' 				=> $group['info'],	
								'top_label'			=> $top_label,
								'top_info'			=> $top_info,
								
							)));
						break;
						case 'text':
							$wp_customize->add_control( new Fruitful_Customize_Text_Control( $wp_customize, esc_attr( $group['id'] ), array(
								'type'              => 'text',
								'priority'          => $priority,
								'section'           => $option['id'],
								'label'             => $group['label'],
								'description'       => $group['description'],
								'info' 				=> $group['info'],
								'top_label'			=> $top_label,
								'top_info'			=> $top_info,
								'box_title'			=> $group['box-title']								
							)));
						break;
						case 'select':
							$choices  = ( isset( $group['options'] ) ) ? $group['options'] : array();

							$wp_customize->add_control( new Fruitful_Customize_Select_Control( $wp_customize, esc_attr( $group['id'] ), array(
								'type'              => 'select',
								'priority'          => $priority,
								'section'           => $option['id'],
								'label'             => $group['label'],
								'description'       => $field['description'],
								'choices'           => $choices,
								'info' 				=> $group['info'],	
								'top_label'			=> $top_label,
								'top_info'			=> $top_info,								
								'box_title'			=> $group['box-title']								
							)));
						break;
						case 'image':
							$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, esc_attr( $group['id'] ), array(
								'priority'          => $priority,
								'section'           => $option['id'],
								'label'             => $field['label'],
								'description'       => $field['info'],
							)));
						break;
						case 'color':
							$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, esc_attr(  $group['id'] ), array(
								'priority'          => $priority,
								'section'           => $option['id'],
								'label'             => $top_label,
								'description'       => $group['box-title'],
								'info' 				=> $group['info'],										
							)));
						break;
						case 'textarea':
							$wp_customize->add_control( new Fruitful_Customize_Textarea_Control( $wp_customize, esc_attr( $group['id'] ), array(
								'priority'          => $priority,
								'section'           => $option['id'],
								'label'             => $group['label'],
								'description'       => $group['description'],
								'info' 				=> $group['info'],
							)));
						break;
					}					
				}
			}	
				$wp_customize->add_setting( esc_attr( $field['id'] ), array(
					'default'           => $field['default'],
					'type'              => $type,
					'capability'        => $capability,
				) );
		
				switch ( $field['type'] ) {
					case 'checkbox':
						$wp_customize->add_control( new Fruitful_Customize_Checkbox_Control( $wp_customize, esc_attr( $field['id'] ), array(
							'type'              => 'checkbox',
							'priority'          => $priority,
							'section'           => $option['id'],
							'label'             => $field['label'],
							'description'       => $field['description'],
							'info' 				=> $field['info'],	
						)));
					break;
					case 'text':
						$wp_customize->add_control( new Fruitful_Customize_Text_Control( $wp_customize, esc_attr( $field['id'] ), array(
							'type'              => 'text',
							'priority'          => $priority,
							'section'           => $option['id'],
							'label'             => $field['label'],
							'description'       => $field['description'],
							'info' 				=> $field['info'],
						)));
					break;
					case 'select':
						$choices  = ( isset( $field['options'] ) ) ? $field['options'] : array();

						$wp_customize->add_control( new Fruitful_Customize_Select_Control( $wp_customize, esc_attr( $field['id'] ), array(
							'type'              => 'select',
							'priority'          => $priority,
							'section'           => $option['id'],
							'label'             => $field['label'],
							'description'       => $field['description'],
							'choices'           => $choices,
							'info' 				=> $field['info'],									
						)));
					break;
					case 'font':
						$choices  = ( isset( $field['options'] ) ) ? $field['options'] : array();

						$wp_customize->add_control( new Fruitful_Customize_Font_Control( $wp_customize, esc_attr( $field['id'] ), array(
							'type'              => 'select',
							'priority'          => $priority,
							'section'           => $option['id'],
							'label'             => $field['label'],
							'description'       => $field['description'],
							'choices'           => $choices,
							'info' 				=> $field['info'],									
						)));
					break;						
					case 'image':
						$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, esc_attr( $field['id'] ), array(
							'priority'          => $priority,
							'section'           => $option['id'],
							'label'             => $field['label'],
							'description'       => $field['info'],
						)));
					break;
					case 'color':
						$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, esc_attr(  $field['id'] ), array(
							'priority'          => $priority,
							'section'           => $option['id'],
							'label'             => $field['label'],
							'description'       => $field['info'],
						)));
					break;
					case 'textarea':
						$wp_customize->add_control( new Fruitful_Customize_Textarea_Control( $wp_customize, esc_attr( $field['id'] ), array(
							'priority'          => $priority,
							'section'           => $option['id'],
							'label'             => $field['label'],
							'description'       => $field['description'],
							'info' 				=> $field['info'],
						)));
					break;
				}
			}
		}}
		$wp_customize->remove_section('slider');	
	}
}	
global $fruitful_theme_options_customizer;	
$fruitful_theme_options_customizer = new fruitful_theme_options_customizer();

