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
class fruitful_theme_options {
	public $args = array();
	public $sections = array();

	public function __construct() {
		add_action( 'init', array( $this, 'init_settings' ), 11 );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'add_menu_item' ) );
		add_action( 'admin_bar_menu', array( $this, 'fruitful_add_custom_link_options' ), 1000 );
	}

	public function init_settings() {
		$this->settings_fields();
		$this->setArguments();
		if ( ! isset( $this->args['opt_name'] ) ) {
			return;
		}
	}

	public function settings_fields() {

		/*General*/

		$this->sections['general'] = array(
			'title'  => __( 'General', 'fruitful' ),
			'id'     => 'general',
			'fields' => array(
				array(
					'id'          => 'responsive',
					'label'       => __( 'Layout', 'fruitful' ),
					'info'        => __( 'Theme supported 2 types of html layout. Default responsive setting which adapt for mobile devices and static page with fixed width. Uncheck arrow below if you need static website display',
						'fruitful' ),
					'description' => __( 'Responsive', 'fruitful' ),
					'type'        => 'checkbox',
					'default'     => 'on',
				),
				array(
					'id'     => 'pagecomment_ch',
					'label'  => __( 'Comments', 'fruitful' ),
					'info'   => __( 'If you want to display comments on your post page or page, select options below.',
						'fruitful' ),
					'fields' => array(
						array(
							'id'          => 'postcomment',
							'description' => __( 'Display comment on posts page', 'fruitful' ),
							'type'        => 'checkbox',
							'default'     => 'on',
						),
						array(
							'id'          => 'pagecomment',
							'description' => __( 'Display comment on page', 'fruitful' ),
							'type'        => 'checkbox',
							'default'     => 'on',
						),
					)
				),
				// array(
				// 'id' 			=> 'styletheme',
				// 'label'			=> __( 'Default theme styles' , 'fruitful' ),
				// 'info'          => __( 'Default CSS. Theme option for styling is not working, if this option enable.', 'fruitful' ),
				// 'description'	=> __( 'Enable', 'fruitful' ),
				// 'type'			=> 'checkbox',
				// 'default'		=> 'off',
				// ),
				array(
					'id'      => 'latest_posts_templ',
					'label'   => __( 'Front page template with latest posts', 'fruitful' ),
					'info'    => __( 'Settings > Reading > Front page displays > Your latest posts', 'fruitful' ),
					'type'    => 'select',
					'options' => array(
						'0' => __( 'Full width', 'fruitful' ),
						'1' => __( 'Right sidebar', 'fruitful' ),
						'2' => __( 'Left sidebar', 'fruitful' )
					),
					'default' => '0'
				),
				array(
					'label'  => __( 'Page templates by default', 'fruitful' ),
					'info'   => __( 'Choose default display for templates.', 'fruitful' ),
					'fields' => array(
						array(
							'id'        => 'layout_page_templ',
							'type'      => 'select',
							'box-title' => __( 'Page:', 'fruitful' ),
							'options'   => array(
								'1' => __( 'Right sidebar', 'fruitful' ),
								'0' => __( 'Full width', 'fruitful' ),
								'2' => __( 'Left sidebar', 'fruitful' )
							),
							'default'   => '1'
						),
						array(
							'id'        => 'layout_single_templ',
							'type'      => 'select',
							'box-title' => __( 'Single Post:', 'fruitful' ),
							'options'   => array(
								'1' => __( 'Right sidebar', 'fruitful' ),
								'0' => __( 'Full width', 'fruitful' ),
								'2' => __( 'Left sidebar', 'fruitful' )
							),
							'default'   => '1'
						),
						array(
							'id'        => 'layout_archive_templ',
							'type'      => 'select',
							'box-title' => __( 'Archive:', 'fruitful' ),
							'options'   => array(
								'1' => __( 'Right sidebar', 'fruitful' ),
								'0' => __( 'Full width', 'fruitful' ),
								'2' => __( 'Left sidebar', 'fruitful' )
							),
							'default'   => '1'
						),
						array(
							'id'        => 'layout_author_templ',
							'type'      => 'select',
							'box-title' => __( 'Author:', 'fruitful' ),
							'options'   => array(
								'1' => __( 'Right sidebar', 'fruitful' ),
								'0' => __( 'Full width', 'fruitful' ),
								'2' => __( 'Left sidebar', 'fruitful' )
							),
							'default'   => '1'
						),
						array(
							'id'        => 'layout_cat_templ',
							'type'      => 'select',
							'box-title' => __( 'Category:', 'fruitful' ),
							'options'   => array(
								'1' => __( 'Right sidebar', 'fruitful' ),
								'0' => __( 'Full width', 'fruitful' ),
								'2' => __( 'Left sidebar', 'fruitful' )
							),
							'default'   => '1'
						),
						array(
							'id'        => 'layout_tag_templ',
							'type'      => 'select',
							'box-title' => __( 'Tags:', 'fruitful' ),
							'options'   => array(
								'1' => __( 'Right sidebar', 'fruitful' ),
								'0' => __( 'Full width', 'fruitful' ),
								'2' => __( 'Left sidebar', 'fruitful' )
							),
							'default'   => '1'
						),
						array(
							'id'        => 'layout_404_templ',
							'type'      => 'select',
							'box-title' => __( '404:', 'fruitful' ),
							'options'   => array(
								'1' => __( 'Right sidebar', 'fruitful' ),
								'0' => __( 'Full width', 'fruitful' ),
								'2' => __( 'Left sidebar', 'fruitful' )
							),
							'default'   => '1'
						),
						array(
							'id'        => 'layout_search_templ',
							'type'      => 'select',
							'box-title' => __( 'Search:', 'fruitful' ),
							'options'   => array(
								'1' => __( 'Right sidebar', 'fruitful' ),
								'0' => __( 'Full width', 'fruitful' ),
								'2' => __( 'Left sidebar', 'fruitful' )
							),
							'default'   => '1'
						),
					)
				),
				array(
					'id'          => 'show_featured_single',
					'label'       => __( 'Show Featured image on single post', 'fruitful' ),
					'info'        => __( 'Select option below for show featured image on single post page.',
						'fruitful' ),
					'description' => __( 'Show featured image', 'fruitful' ),
					'type'        => 'checkbox',
					'default'     => 'on',
				),

				( ( function_exists( 'icl_get_languages' ) ) ?
					array(
						'id'          => 'is_wpml_ready',
						'type'        => 'checkbox',
						'label'       => __( 'Multilingual Switch in Header (WPML)', 'fruitful' ),
						'info'        => __( 'If you wish to show Language Switch in header, select option below.',
							'fruitful' ),
						'description' => __( 'Enable', 'fruitful' ),
						'default'     => 'off'
					) :
					array(
						'id'      => 'reset',
						'label'   => __( 'Reset options', 'fruitful' ),
						'info'    => __( 'All theme options will be reset to default.', 'fruitful' ),
						'type'    => 'button',
						'default' => __( 'Reset Defaults', 'fruitful' ),
						'class'   => 'button-primary reset-btn',
					)
				),
				array(
					'id'      => 'reset',
					'label'   => __( 'Reset options', 'fruitful' ),
					'info'    => __( 'All theme options will be reset to default.', 'fruitful' ),
					'type'    => 'button',
					'default' => __( 'Reset Defaults', 'fruitful' ),
					'class'   => 'button-primary reset-btn',
				),
			)
		);


		/*Header*/

		$this->sections['header'] = array(
			'title'  => __( 'Header', 'fruitful' ),
			'id'     => 'header',
			'fields' => array(
				array(
					'id'          => 'is_fixed_header',
					'label'       => __( 'Sticky  header', 'fruitful' ),
					'info'        => __( 'Options relating to the website header', 'fruitful' ),
					'description' => __( 'Enabled', 'fruitful' ),
					'type'        => 'checkbox',
					'default'     => 'on',
				),
				array(
					'id'      => 'menu_position',
					'label'   => __( 'Menu Position', 'fruitful' ),
					'info'    => __( 'Set menu position.', 'fruitful' ),
					'type'    => 'select',
					'options' => array(
						'2' => __( 'Right', 'fruitful' ),
						'0' => __( 'Left', 'fruitful' ),
						'1' => __( 'Center', 'fruitful' )
					),
					'default' => '2'
				),
				array(
					'id'      => 'menu_type_responsive',
					'label'   => __( 'Type of Responsive menu', 'fruitful' ),
					'info'    => __( 'Set type of responsive menu.', 'fruitful' ),
					'type'    => 'select',
					'options' => array(
						'inside_content' => __( 'Select menu', 'fruitful' ),
						'full_width'     => __( 'Button menu', 'fruitful' )
					),
					'default' => 'inside_content'
				),
				array(
					'id'      => 'menu_icon_color',
					'label'   => __( 'Menu icon color', 'fruitful' ),
					'info'    => __( 'Chose color for collapsing menu icon', 'fruitful' ),
					'type'    => 'color',
					'default' => '#333333',
				),
				array(
					'label'  => __( 'Background for header', 'fruitful' ),
					'info'   => __( 'Upload image with full width for background in header area. (Supported files .png, .jpg, .gif)',
						'fruitful' ),
					'fields' => array(
						array(
							'id'        => 'header_img',
							'type'      => 'image',
							'imagetype' => 'headerbackground',
						),
						array(
							'id'        => 'header_bg_color',
							'type'      => 'color',
							'default'   => '#ffffff',
							'box-title' => __( 'Header background-color', 'fruitful' )
						)
					)
				),
				array(
					'id'      => 'header_img_size',
					'label'   => __( 'Background image size', 'fruitful' ),
					'info'    => __( 'Choose size for background image - full width or only for content area.',
						'fruitful' ),
					'type'    => 'select',
					'options' => array(
						'full'     => __( 'Full width position', 'fruitful' ),
						'centered' => __( 'Centered position', 'fruitful' )
					),
					'default' => 'full'
				),
				array(
					'id'      => 'header_height',
					'label'   => __( 'Height for header area', 'fruitful' ),
					'info'    => __( 'Minimum height in pixels', 'fruitful' ),
					'type'    => 'text',
					'default' => '80',
				),
			)
		);

		/*Background*/

		$this->sections['background'] = array(
			'title'  => __( 'Background', 'fruitful' ),
			'id'     => 'background',
			'fields' => array(
				array(
					'label'  => __( 'Background Image', 'fruitful' ),
					'info'   => __( 'Upload your background image for site background. (Supported files .png, .jpg, .gif)',
						'fruitful' ),
					'fields' => array(
						array(
							'id'        => 'backgroung_img',
							'type'      => 'image',
							'imagetype' => 'headerbackground',
						),
						array(
							'id'          => 'bg_repeating',
							'description' => __( 'Background repeat', 'fruitful' ),
							'type'        => 'checkbox',
							'default'     => 'off',
						),
					)
				),
				array(
					'id'      => 'background_color',
					'label'   => __( 'Background Color', 'fruitful' ),
					'info'    => __( 'Choose color for body background', 'fruitful' ),
					'type'    => 'color',
					'default' => '#ffffff'
				),
				array(
					'id'      => 'container_bg_color',
					'label'   => __( 'Background color for content', 'fruitful' ),
					'info'    => __( 'Choose color for main content area', 'fruitful' ),
					'type'    => 'color',
					'default' => '#ffffff'
				),
			)
		);

		/*Logo*/
		$this->sections['logo'] = array(
			'title'  => __( 'Logo', 'fruitful' ),
			'id'     => 'logo',
			'fields' => array(
				array(
					'id'      => 'logo_position',
					'label'   => __( 'Logo Position', 'fruitful' ),
					'info'    => __( 'Set Logo Position', 'fruitful' ),
					'type'    => 'select',
					'options' => array(
						'0' => __( 'Left', 'fruitful' ),
						'1' => __( 'Center', 'fruitful' ),
						'2' => __( 'Right', 'fruitful' )
					),
					'default' => '0'
				),
				array(
					'label'  => __( 'Logo size', 'fruitful' ),
					'info'   => __( 'Specify resolution for your logo image', 'fruitful' ),
					'fields' => array(
						array(
							'id'        => 'logo_w',
							'type'      => 'text',
							'default'   => '0',
							'box-title' => __( 'Width', 'fruitful' )
						),
						array(
							'id'        => 'logo_h',
							'type'      => 'text',
							'default'   => '0',
							'box-title' => __( 'Height', 'fruitful' )
						),
					)
				),
				array(
					'id'        => 'logo_img',
					'label'     => __( 'Logo image', 'fruitful' ),
					'info'      => __( 'Upload logo image for your website. Size is original (Supported files .png, .jpg, .gif)',
						'fruitful' ),
					'type'      => 'image',
					'imagetype' => 'logo',
				),
				array(
					'id'        => 'logo_img_retina',
					'label'     => __( 'Logo image retina', 'fruitful' ),
					'info'      => __( 'Upload logo in double size (If your logo is 100 x 20px, it should be 200 x 40px)',
						'fruitful' ),
					'type'      => 'image',
					'imagetype' => 'logo_retina',
				),
				array(
					'id'        => 'fav_icon',
					'label'     => __( 'Favicon', 'fruitful' ),
					'info'      => __( 'A favicon is a 16x16 pixel icon that represents your site; upload your custom Favicon here.',
						'fruitful' ),
					'type'      => 'image',
					'imagetype' => 'favicon',
				),
				array(
					'id'        => 'fav_icon_iphone',
					'label'     => __( 'Favicon iPhone', 'fruitful' ),
					'info'      => __( 'Upload a custom favicon for iPhone (57x57 pixel png).', 'fruitful' ),
					'type'      => 'image',
					'imagetype' => 'favicon_iphone',
				),
				array(
					'id'        => 'fav_icon_iphone_retina',
					'label'     => __( 'Favicon iPhone Retina', 'fruitful' ),
					'info'      => __( 'Upload a custom favicon for iPhone retina (114x114 pixel png).', 'fruitful' ),
					'type'      => 'image',
					'imagetype' => 'favicon_iphone_retina',
				),
				array(
					'id'        => 'fav_icon_ipad',
					'label'     => __( 'Favicon iPad', 'fruitful' ),
					'info'      => __( 'Upload a custom favicon for iPad (72x72 pixel png).', 'fruitful' ),
					'type'      => 'image',
					'imagetype' => 'favicon_ipad',
				),
				array(
					'id'        => 'fav_icon_ipad_retina',
					'label'     => __( 'Favicon iPad Retina', 'fruitful' ),
					'info'      => __( 'Upload a custom favicon for iPhone retina (144x144 pixel png).', 'fruitful' ),
					'type'      => 'image',
					'imagetype' => 'favicon_ipad_retina',
				),

			)
		);

		/*Colors*/
		$this->sections['colors'] = array(
			'title'  => __( 'Colors', 'fruitful' ),
			'id'     => 'main-colors',
			'fields' => array(
				array(
					'id'     => 'menu-color',
					'label'  => __( 'Main menu color', 'fruitful' ),
					'info'   => __( 'Choose your colors for main menu in header', 'fruitful' ),
					'newrow' => true,
					'fields' => array(
						array(
							'id'        => 'menu_bg_color',
							'type'      => 'color',
							'default'   => '#ffffff',
							'box-title' => __( 'Background color', 'fruitful' )
						),
						array(
							'id'        => 'menu_btn_color',
							'type'      => 'color',
							'default'   => '#F15A23',
							'box-title' => __( 'Menu button color', 'fruitful' )
						),
						array(
							'id'        => 'menu_font_color',
							'type'      => 'color',
							'default'   => '#333333',
							'box-title' => __( 'Font color', 'fruitful' )
						),
						array(
							'id'        => 'menu_hover_color',
							'type'      => 'color',
							'default'   => '#ffffff',
							'box-title' => __( 'Font color (active and hover)', 'fruitful' )
						),
					)
				),
				array(
					'id'     => 'dd-menu-color',
					'label'  => __( 'Dropdown menu color', 'fruitful' ),
					'info'   => __( 'Choose your colors for dropdown menu in header', 'fruitful' ),
					'fields' => array(
						array(
							'id'        => 'dd_menu_bg_color',
							'type'      => 'color',
							'default'   => '#ffffff',
							'box-title' => __( 'Background color', 'fruitful' )
						),
						array(
							'id'        => 'dd_menu_btn_color',
							'type'      => 'color',
							'default'   => '#F15A23',
							'box-title' => __( 'Menu button color', 'fruitful' )
						),
						array(
							'id'        => 'dd_menu_font_color',
							'type'      => 'color',
							'default'   => '#333333',
							'box-title' => __( 'Font color', 'fruitful' )
						),
						array(
							'id'        => 'dd_menu_hover_color',
							'type'      => 'color',
							'default'   => '#ffffff',
							'box-title' => __( 'Font color (active and hover)', 'fruitful' )
						),
					)
				),
				array(
					'id'     => 'g-menu-color',
					'label'  => __( 'General font color', 'fruitful' ),
					'info'   => __( 'Choose your colors for text and links', 'fruitful' ),
					'newrow' => true,
					'fields' => array(
						array(
							'id'        => 'p_font_color',
							'type'      => 'color',
							'default'   => '#333333',
							'box-title' => __( 'Font color', 'fruitful' )
						),
						array(
							'id'        => 'a_font_color',
							'type'      => 'color',
							'default'   => '#333333',
							'box-title' => __( 'Link color', 'fruitful' )
						),
						array(
							'id'        => 'a_hover_font_color',
							'type'      => 'color',
							'default'   => '#FF5D2A',
							'box-title' => __( 'Link color (hover)', 'fruitful' )
						),
						array(
							'id'        => 'a_focus_font_color',
							'type'      => 'color',
							'default'   => '#FF5D2A',
							'box-title' => __( 'Link color (focus)', 'fruitful' )
						),
						array(
							'id'        => 'a_active_font_color',
							'type'      => 'color',
							'default'   => '#FF5D2A',
							'box-title' => __( 'Link color (active)', 'fruitful' )
						),
					)
				),
				array(
					'id'     => 'lines-color',
					'label'  => __( 'Color for lines', 'fruitful' ),
					'info'   => __( 'Choose your colors for lines and separators', 'fruitful' ),
					'fields' => array(
						array(
							'id'        => 'widgets_sep_color',
							'type'      => 'color',
							'default'   => '#F15A23',
							'box-title' => __( 'Widget separator color', 'fruitful' )
						),
						array(
							'id'        => 'date_of_post_b_color',
							'type'      => 'color',
							'default'   => '#F15A23',
							'box-title' => __( 'Blog post date color', 'fruitful' )
						),
						array(
							'id'        => 'date_of_post_f_color',
							'type'      => 'color',
							'default'   => '#ffffff',
							'box-title' => __( 'Date font color', 'fruitful' )
						),
					)
				),
				array(
					'id'     => 'buttons-color',
					'label'  => __( 'Color for buttons', 'fruitful' ),
					'info'   => __( 'Choose your colors for buttons', 'fruitful' ),
					'newrow' => true,
					'fields' => array(
						array(
							'id'        => 'btn_color',
							'type'      => 'color',
							'default'   => '#333333',
							'box-title' => __( 'Button background color', 'fruitful' )
						),
						array(
							'id'        => 'btn_active_color',
							'type'      => 'color',
							'default'   => '#F15A23',
							'box-title' => __( 'Button background color (hover, active, focus, current page - pagenavi)',
								'fruitful' )
						),
					)
				),
				array(
					'id'     => 'social-color',
					'label'  => __( 'Color for social icons', 'fruitful' ),
					'info'   => __( 'Choose your colors for social icons', 'fruitful' ),
					'fields' => array(
						array(
							'id'        => 'soc_icon_bg_color',
							'type'      => 'color',
							'default'   => '#333333',
							'box-title' => __( 'Social icons background color', 'fruitful' )
						),
						array(
							'id'        => 'soc_icon_color',
							'type'      => 'color',
							'default'   => '#ffffff',
							'box-title' => __( 'Button background color (hover, active, focus, current page - pagenavi)',
								'fruitful' )
						),
					)
				),
				array(
					'id'     => 'woocommerce-color',
					'label'  => __( 'WooCommerce colors', 'fruitful' ),
					'info'   => __( 'Choose your colors for WooCommerce', 'fruitful' ),
					'fields' => array(
						array(
							'id'        => 'woo_sale_price_color',
							'type'      => 'color',
							'default'   => '#919191',
							'box-title' => __( 'Sale price color', 'fruitful' )
						),
						array(
							'id'        => 'woo_rating_color_regular',
							'type'      => 'color',
							'default'   => '#333333',
							'box-title' => __( 'Rating color (regular)', 'fruitful' )
						),
						array(
							'id'        => 'woo_rating_color_active',
							'type'      => 'color',
							'default'   => '#FF5D2A',
							'box-title' => __( 'Rating color (hover, active)', 'fruitful' )
						),
					)
				),
			)
		);

		/*Fonts*/
		$this->sections['fonts'] = array(
			'title'  => __( 'Fonts', 'fruitful' ),
			'id'     => 'fonts',
			'fields' => array(
				// array(
				// 'label'			=> __( 'Fonts' , 'fruitful' ),
				// 'info'			=> __( 'Popular web safe font collection, select and use for your needs.', 'fruitful' ),
				// ),
				array(
					'id'      => 'h_font_family',
					'label'   => __( 'Headers', 'fruitful' ),
					'info'    => __( 'Choose font-family for all headlines.', 'fruitful' ),
					'type'    => 'font',
					'options' => fruitful_fonts_list(),
					'default' => 'Open Sans, sans-serif',
				),
				array(
					'id'      => 'm_font_family',
					'label'   => __( 'Menu', 'fruitful' ),
					'info'    => __( 'Choose font-family for primary menu.', 'fruitful' ),
					'type'    => 'font',
					'options' => fruitful_fonts_list(),
					'default' => 'Open Sans, sans-serif',
				),
				array(
					'id'      => 'p_font_family',
					'label'   => __( 'Body', 'fruitful' ),
					'info'    => __( 'Choose font-family for content.', 'fruitful' ),
					'type'    => 'font',
					'options' => fruitful_fonts_list(),
					'default' => 'Open Sans, sans-serif',
				),
				array(
					'id'     => 'font-size',
					'label'  => __( 'Font size', 'fruitful' ),
					'info'   => __( 'Choose font size for specific html elements. Set size as number, without px..',
						'fruitful' ),
					'fields' => array(
						array(
							'id'        => 'h1_size',
							'type'      => 'text',
							'default'   => '27',
							'box-title' => __( 'H1', 'fruitful' ),
						),
						array(
							'id'        => 'h2_size',
							'type'      => 'text',
							'default'   => '34',
							'box-title' => __( 'H2', 'fruitful' ),
						),
						array(
							'id'        => 'h3_size',
							'type'      => 'text',
							'default'   => '18',
							'box-title' => __( 'H3', 'fruitful' ),
						),
						array(
							'id'        => 'h4_size',
							'type'      => 'text',
							'default'   => '17',
							'box-title' => __( 'H4', 'fruitful' ),
						),
						array(
							'id'        => 'h5_size',
							'type'      => 'text',
							'default'   => '14',
							'box-title' => __( 'H5', 'fruitful' ),
						),
						array(
							'id'        => 'h6_size',
							'type'      => 'text',
							'default'   => '12',
							'box-title' => __( 'H6', 'fruitful' ),
						),
						array(
							'id'        => 'm_size',
							'type'      => 'text',
							'default'   => '14',
							'box-title' => __( 'Menu', 'fruitful' ),
						),
						array(
							'id'        => 'p_size',
							'type'      => 'text',
							'default'   => '14',
							'box-title' => __( 'P', 'fruitful' ),
						),
					)
				)

			),
		);

		/*Slider*/
		$this->sections['slider'] = array(
			'title'  => __( 'Slider', 'fruitful' ),
			'id'     => 'slider',
			'fields' => array(
				array(
					'id'      => 'select_slider',
					'class'   => 'select-slider',
					'label'   => __( 'Slider', 'fruitful' ),
					'info'    => __( 'Select a slider type that will be used by default.', 'fruitful' ),
					'type'    => 'select',
					'options' => array(
						'1' => __( 'FlexSlider', 'fruitful' ),
						'2' => __( 'Nivo Slider', 'fruitful' )
					),
					'default' => '1'
				),
				array(
					'id'     => 'slider-options',
					'label'  => __( 'Slider Options', 'fruitful' ),
					'info'   => __( 'Choose needed options for slider: animation type, sliding direction, speed of animations, etc',
						'fruitful' ),
					'type'   => 'slider-options',
					'fields' => array(
						array(
							'id'           => 's_animation',
							'type'         => 'select',
							'option-block' => 'flex-slider',
							'box-title'    => __( 'Animation type', 'fruitful' ),
							'options'      => array(
								'fade'  => __( 'fade', 'fruitful' ),
								'slide' => __( 'slide', 'fruitful' )
							),
							'default'      => 'fade'
						),
						array(
							'id'           => 's_direction',
							'type'         => 'select',
							'option-block' => 'flex-slider',
							'box-title'    => __( 'Sliding direction, "horizontal" or "vertical"', 'fruitful' ),
							'options'      => array(
								'horizontal' => __( 'horizontal', 'fruitful' ),
								'vertical'   => __( 'vertical', 'fruitful' )
							),
							'default'      => 'horizontal'
						),
						array(
							'id'           => 's_reverse',
							'type'         => 'select',
							'option-block' => 'flex-slider',
							'box-title'    => __( 'Reverse the animation direction', 'fruitful' ),
							'options'      => array(
								'false' => __( 'false', 'fruitful' ),
								'true'  => __( 'true', 'fruitful' )
							),
							'default'      => 'false'
						),
						array(
							'id'           => 's_slideshow',
							'type'         => 'select',
							'option-block' => 'flex-slider',
							'box-title'    => __( 'Animate slider automatically', 'fruitful' ),
							'options'      => array(
								'true'  => __( 'true', 'fruitful' ),
								'false' => __( 'false', 'fruitful' )
							),
							'default'      => 'true'
						),
						array(
							'id'           => 's_slideshowSpeed',
							'type'         => 'text',
							'option-block' => 'flex-slider',
							'box-title'    => __( 'Set the speed of the slideshow cycling, in milliseconds',
								'fruitful' ),
							'default'      => '7000'
						),
						array(
							'id'           => 's_animationSpeed',
							'type'         => 'text',
							'option-block' => 'flex-slider',
							'box-title'    => __( 'Set the speed of animations, in milliseconds', 'fruitful' ),
							'default'      => '600'
						),
						array(
							'id'           => 's_initDelay',
							'type'         => 'text',
							'option-block' => 'flex-slider',
							'box-title'    => __( 'Set an initialization delay, in milliseconds', 'fruitful' ),
							'default'      => '0'
						),
						array(
							'id'           => 's_randomize',
							'type'         => 'select',
							'option-block' => 'flex-slider',
							'box-title'    => __( 'Randomize slide order', 'fruitful' ),
							'options'      => array(
								'false' => __( 'false', 'fruitful' ),
								'true'  => __( 'true', 'fruitful' )
							),
							'default'      => 'false'
						),
						array(
							'id'           => 's_controlnav',
							'type'         => 'select',
							'option-block' => 'flex-slider',
							'box-title'    => __( 'Manual control usage', 'fruitful' ),
							'options'      => array(
								'true'  => __( 'true', 'fruitful' ),
								'false' => __( 'false', 'fruitful' )
							),
							'default'      => 'true'
						),
						array(
							'id'           => 's_touch',
							'type'         => 'select',
							'option-block' => 'flex-slider',
							'box-title'    => __( 'Touch swipe', 'fruitful' ),
							'options'      => array(
								'true'  => __( 'true', 'fruitful' ),
								'false' => __( 'false', 'fruitful' )
							),
							'default'      => 'true'
						),
						array(
							'id'           => 'nv_skins',
							'type'         => 'select',
							'option-block' => 'nivo-slider',
							'box-title'    => __( 'Slider Skins', 'fruitful' ),
							'options'      => array(
								'theme-bar'     => __( 'bar', 'fruitful' ),
								'theme-default' => __( 'default', 'fruitful' ),
								'theme-dark'    => __( 'dark', 'fruitful' ),
								'theme-light'   => __( 'light', 'fruitful' )
							),
							'default'      => 'theme-bar'
						),
						array(
							'id'           => 'nv_animation',
							'type'         => 'select',
							'option-block' => 'nivo-slider',
							'box-title'    => __( 'Effect', 'fruitful' ),
							'options'      => array(
								'random'                 => __( 'random', 'fruitful' ),
								'sliceDownRight'         => __( 'sliceDownRight', 'fruitful' ),
								'sliceDownLeft'          => __( 'sliceDownLeft', 'fruitful' ),
								'sliceUpRight'           => __( 'sliceUpRight', 'fruitful' ),
								'sliceUpDown'            => __( 'sliceUpDown', 'fruitful' ),
								'sliceUpDownLeft'        => __( 'sliceUpDownLeft', 'fruitful' ),
								'fold'                   => __( 'fold', 'fruitful' ),
								'fade'                   => __( 'fade', 'fruitful' ),
								'boxRandom'              => __( 'boxRandom', 'fruitful' ),
								'boxRain'                => __( 'boxRain', 'fruitful' ),
								'boxRainReverse'         => __( 'boxRainReverse', 'fruitful' ),
								'boxRainGrow'            => __( 'boxRainGrow', 'fruitful' ),
								'boxRainGrowReverse	' => __( 'boxRainGrowReverse', 'fruitful' )
							),
							'default'      => 'random'
						),
						array(
							'id'           => 'nv_slice',
							'type'         => 'text',
							'option-block' => 'nivo-slider',
							'box-title'    => __( 'For slice animations', 'fruitful' ),
							'default'      => '15'
						),
						array(
							'id'           => 'nv_boxCols',
							'type'         => 'text',
							'option-block' => 'nivo-slider',
							'box-title'    => __( 'For box animations (Cols)', 'fruitful' ),
							'default'      => '8'
						),
						array(
							'id'           => 'nv_boxRows',
							'type'         => 'text',
							'option-block' => 'nivo-slider',
							'box-title'    => __( 'For box animations (Rows)', 'fruitful' ),
							'default'      => '4'
						),
						array(
							'id'           => 'nv_animSpeed',
							'type'         => 'text',
							'option-block' => 'nivo-slider',
							'box-title'    => __( 'Slide transition speed', 'fruitful' ),
							'default'      => '500'
						),
						array(
							'id'           => 'nv_pauseTime',
							'type'         => 'text',
							'option-block' => 'nivo-slider',
							'box-title'    => __( 'How long each slide will show', 'fruitful' ),
							'default'      => '3000'
						),
						array(
							'id'           => 'nv_startSlide',
							'type'         => 'text',
							'option-block' => 'nivo-slider',
							'box-title'    => __( 'Set starting Slide (0 index)', 'fruitful' ),
							'default'      => '0'
						),
						array(
							'id'           => 'nv_directionNav',
							'type'         => 'select',
							'option-block' => 'nivo-slider',
							'box-title'    => __( 'Next & Prev navigation', 'fruitful' ),
							'options'      => array(
								'true'  => __( 'true', 'fruitful' ),
								'false' => __( 'false', 'fruitful' ),
							),
							'default'      => 'true'
						),
						array(
							'id'           => 'nv_controlNav',
							'type'         => 'select',
							'option-block' => 'nivo-slider',
							'box-title'    => __( '1,2,3... navigation', 'fruitful' ),
							'options'      => array(
								'true'  => __( 'true', 'fruitful' ),
								'false' => __( 'false', 'fruitful' ),
							),
							'default'      => 'true'
						),
						array(
							'id'           => 'nv_controlNavThumbs',
							'type'         => 'select',
							'option-block' => 'nivo-slider',
							'box-title'    => __( 'Use thumbnails for Control Nav', 'fruitful' ),
							'options'      => array(
								'true'  => __( 'true', 'fruitful' ),
								'false' => __( 'false', 'fruitful' ),
							),
							'default'      => 'false'
						),
						array(
							'id'           => 'nv_pauseOnHover',
							'type'         => 'select',
							'option-block' => 'nivo-slider',
							'box-title'    => __( 'Stop animation while hovering', 'fruitful' ),
							'options'      => array(
								'true'  => __( 'true', 'fruitful' ),
								'false' => __( 'false', 'fruitful' ),
							),
							'default'      => 'true'
						),
						array(
							'id'           => 'nv_manualAdvance',
							'type'         => 'select',
							'option-block' => 'nivo-slider',
							'box-title'    => __( 'Force manual transitions', 'fruitful' ),
							'options'      => array(
								'true'  => __( 'true', 'fruitful' ),
								'false' => __( 'false', 'fruitful' ),
							),
							'default'      => 'false'
						),
						array(
							'id'           => 'nv_prevText',
							'type'         => 'text',
							'option-block' => 'nivo-slider',
							'box-title'    => __( 'Prev directionNav text', 'fruitful' ),
							'default'      => __( 'Prev', 'fruitful' )
						),
						array(
							'id'           => 'nv_nextText',
							'type'         => 'text',
							'option-block' => 'nivo-slider',
							'box-title'    => __( 'Next directionNav text', 'fruitful' ),
							'default'      => __( 'Next', 'fruitful' )
						),
						array(
							'id'           => 'nv_randomStart',
							'type'         => 'select',
							'option-block' => 'nivo-slider',
							'box-title'    => __( 'Start on a random slide', 'fruitful' ),
							'options'      => array(
								'true'  => __( 'true', 'fruitful' ),
								'false' => __( 'false', 'fruitful' ),
							),
							'default'      => 'false'
						),
					)

				),
				array(
					'id'    => 'slides',
					'type'  => 'slides',
					'label' => __( 'Slides', 'fruitful' ),
					'info'  => __( 'Add images to slider (Supported files .png, .jpg, .gif). If you want to change order, just drag and drop it. Image size for slides is original from media gallery, please upload images in same size, to get best display on page. To display slider in needed place use shortcode [fruitful_slider]. Current theme version support only one slider per website.',
						'fruitful' ),
				)
			)
		);

		/*Social Links*/
		$this->sections['social-links'] = array(
			'title'  => __( 'Social Links', 'fruitful' ),
			'id'     => 'social-links',
			'fields' => array(
				array(
					'id'      => 'sl_position',
					'label'   => __( 'Socials Links Position', 'fruitful' ),
					'info'    => __( 'Choose place where social links will be displayed.', 'fruitful' ),
					'type'    => 'select',
					'options' => array( '0' => __( 'Footer', 'fruitful' ), '1' => __( 'Header', 'fruitful' ) ),
					'default' => '0'
				),
				array(
					'id'     => 'social-links',
					'label'  => __( 'Socials Links', 'fruitful' ),
					'info'   => __( 'Add link to your social media profiles. Icons with link will be display in header or footer.',
						'fruitful' ),
					'fields' => array(
						array(
							'id'        => 'facebook_url',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'Facebook', 'fruitful' )
						),
						array(
							'id'        => 'twitter_url',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'Twitter', 'fruitful' )
						),
						array(
							'id'        => 'linkedin_url',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'LinkedIn', 'fruitful' )
						),
						array(
							'id'        => 'myspace_url',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'MySpace', 'fruitful' )
						),
						array(
							'id'        => 'googleplus_url',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'Google Plus+', 'fruitful' )
						),
						array(
							'id'        => 'dribbble_url',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'Dribbble', 'fruitful' )
						),
						array(
							'id'        => 'skype_link',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'Skype', 'fruitful' )
						),
						array(
							'id'        => 'flickr_link',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'Flickr', 'fruitful' )
						),
						array(
							'id'        => 'youtube_url',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'You Tube', 'fruitful' )
						),
						array(
							'id'        => 'vimeo_url',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'Vimeo', 'fruitful' )
						),
						array(
							'id'        => 'rss_link',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'RSS', 'fruitful' )
						),
						array(
							'id'        => 'vk_link',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'Vk.com', 'fruitful' )
						),
						array(
							'id'        => 'instagram_url',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'Instagram', 'fruitful' )
						),
						array(
							'id'        => 'pinterest_url',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'Pinterest', 'fruitful' )
						),
						array(
							'id'        => 'yelp_url',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'Yelp', 'fruitful' )
						),
						array(
							'id'        => 'email_link',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'E-mail', 'fruitful' )
						),
						array(
							'id'        => 'github_link',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'Github', 'fruitful' )
						),
						array(
							'id'        => 'tumblr_link',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'Tumblr', 'fruitful' )
						),
						array(
							'id'        => 'soundcloud_link',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'Soundcloud', 'fruitful' )
						),
						array(
							'id'        => 'tripadvisor_link',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'Tripadvisor', 'fruitful' )
						),
						array(
							'id'        => 'ello_link',
							'type'      => 'text',
							'default'   => '',
							'box-title' => __( 'Ello.co', 'fruitful' )
						),
					)
				),
			)
		);

		/*Footer*/
		$this->sections['footer'] = array(
			'title'  => __( 'Footer', 'fruitful' ),
			'id'     => 'footer',
			'fields' => array(
				array(
					'id'        => 'footer_text',
					'label'     => __( 'Footer options', 'fruitful' ),
					'info'      => __( 'Replace default theme copyright information and links', 'fruitful' ),
					'box-title' => __( 'Copyright section', 'fruitful' ),
					'type'      => 'textarea',
					'default'   => __( 'Fruitful theme by <a href="https://github.com/fruitfulcode/">fruitfulcode</a> Powered by: <a href="http://wordpress.org">WordPress</a>',
						'fruitful' ),
				)
			)
		);

		/*Custom CSS*/
		$this->sections['custom-css'] = array(
			'title'  => __( 'Custom CSS', 'fruitful' ),
			'id'     => 'custom-css',
			'fields' => array(
				array(
					'id'        => 'custom_css',
					'label'     => __( 'Custom CSS', 'fruitful' ),
					'info'      => __( 'Theme has two css files style.css and fixed-style.css which use default styles for front-end responsive and static layout. Do not edit theme default css files, use textarea editor below for overwriting all css styles.',
						'fruitful' ),
					'box-title' => __( 'Styles editor', 'fruitful' ),
					'type'      => 'textarea',
					'default'   => '',
				)
			)
		);

		/*Woocommerce*/
		if ( class_exists( 'Woocommerce' ) ) {
			$this->sections['woo'] = array(
				'title'  => __( 'Woocommerce', 'fruitful' ),
				'id'     => 'woo',
				'fields' => array(
					array(
						'id'          => 'showcart',
						'label'       => __( 'Show cart in header', 'fruitful' ),
						'info'        => __( 'If you want to display cart link in header select options below.',
							'fruitful' ),
						'type'        => 'checkbox',
						'description' => __( 'Enable', 'fruitful' ),
						'default'     => 'on',
					),
					array(
						'label'   => __( 'Cart color', 'fruitful' ),
						'info'    => __( 'Choose color for cart icon', 'fruitful' ),
						'id'      => 'cart_color',
						'type'    => 'color',
						'default' => '#020202',
					),
					array(
						'id'      => 'woo_shop_sidebar',
						'label'   => __( 'Woocommerce Shop Sidebar', 'fruitful' ),
						'info'    => __( 'Show or hide sidebar', 'fruitful' ),
						'type'    => 'select',
						'options' => array(
							'2' => __( 'Left sidebar', 'fruitful' ),
							'1' => __( 'Full width', 'fruitful' ),
							'3' => __( 'Right sidebar', 'fruitful' )
						),
						'default' => '2',
					),
					array(
						'id'      => 'woo_product_sidebar',
						'label'   => __( 'Woocommerce Product Sidebar', 'fruitful' ),
						'info'    => __( 'Show or hide sidebar', 'fruitful' ),
						'type'    => 'select',
						'options' => array(
							'1' => __( 'Full width with tabs on right side', 'fruitful' ),
							'2' => __( 'Left sidebar', 'fruitful' ),
							'3' => __( 'Right sidebar', 'fruitful' ),
							'4' => __( 'Full width with tabs on left side', 'fruitful' ),
							'5' => __( 'Full width with tabs in center', 'fruitful' )
						),
						'default' => '1',
					),
					array(
						'id'      => 'shop_num_row',
						'label'   => __( 'Woocommerce pages products per row', 'fruitful' ),
						'info'    => __( 'Choose number of products', 'fruitful' ),
						'type'    => 'select',
						'options' => array(
							'2' => __( '2 products', 'fruitful' ),
							'3' => __( '3 products', 'fruitful' ),
							'4' => __( '4 products', 'fruitful' ),
							'5' => __( '5 products', 'fruitful' )
						),
						'default' => '4',
					),
					array(
						'id'      => 'woo_shop_num_prod',
						'label'   => __( 'Number of products on Shop pages', 'fruitful' ),
						'info'    => __( 'Choose number of products. Write -1 for show all products on one page',
							'fruitful' ),
						'type'    => 'text',
						'default' => '10',
					),
				)
			);
		}

		$this->sections = apply_filters( 'settings_fields', $this->sections );

		return $this->sections;
	}

	public function setArguments() {
		$this->args = array(
			'opt_name'  => 'fruitful_theme_options', // Database option
			'opt_group' => 'fruitful_options',         // Options group
			'opt_slug'  => 'theme_options',          // Menu slug
		);
	}

	public function add_menu_item() {
		/*
		* Add our theme options page to the admin menu.
		* This function is attached to the admin_menu action hook.
		* @since Fruitful theme 1.0
		*/
		$admin_page = add_theme_page(
			__( 'Theme Options', 'fruitful' ),                             // Name of page
			__( 'Theme Options', 'fruitful' ),                             // Label in menu
			'edit_theme_options',                                     // Capability required
			$this->args['opt_slug'],                                 // Menu slug, used to uniquely identify the page
			array( &$this, 'fruitful_theme_options_render_page' )    // Function that renders the options page
		);
		add_action( 'admin_print_scripts-' . $admin_page, array( &$this, 'settings_assets' ) );
	}

	public function fruitful_add_custom_link_options() {
		global $wp_admin_bar, $wpdb;
		if ( ! is_super_admin() || ! is_admin_bar_showing() ) {
			return;
		}

		/* Add the main siteadmin menu item */
		$wp_admin_bar->add_menu( array(
			'id'    => 'fruitfultheme_options',
			'title' => __( 'Theme Options', 'fruitful' ),
			'href'  => admin_url( 'admin.php?page=theme_options' )
		) );
	}

	public function settings_assets() {
		wp_print_scripts( 'jquery-ui-tabs' );
		fruitful_add_jquery_script();
		fruitful_add_admin_style();
	}

	public function display_field( $data = array(), $echo = true ) {
		$field       = $data;
		$option_name = $data = '';

		$id   = ( isset( $field['id'] ) ) ? $field['id'] : '';
		$type = ( isset( $field['type'] ) ) ? $field['type'] : '';

		$option_name = $id;
		$option      = fruitful_get_theme_options();

		if ( isset( $option ) ) {
			$data = $option[ $option_name ];
		}

		if ( $data == null && isset( $field['default'] ) ) {
			$data = $field['default'];
		} elseif ( $data === null ) {
			$data = '';
		}
		$html = '';
		switch ( $type ) {
			case 'text':
				if ( ! empty( $field['box-title'] ) ) {
					$html .= '<h4>' . esc_attr( $field['box-title'] ) . '</h4>';
				}
				$html .= '<input class="text-input" id="' . esc_attr( $field['id'] ) . '" type="text" name="' . $this->args['opt_name'] . '[' . esc_attr( $field['id'] ) . ']" value="' . $data . '" />' . "\n";
				break;
			case 'textarea':
				if ( ! empty( $field['box-title'] ) ) {
					$html .= '<h4>' . esc_attr( $field['box-title'] ) . '</h4>';
				}
				$html .= '<textarea class="large-text" id="' . esc_attr( $field['id'] ) . '" rows="20" cols="50" name="' . $this->args['opt_name'] . '[' . esc_attr( $field['id'] ) . ']" >' . stripslashes( $data ) . '</textarea>' . "\n";
				break;
			case 'checkbox':
				if ( ! empty( $field['box-title'] ) ) {
					$html .= '<h4>' . esc_attr( $field['box-title'] ) . '</h4>';
				}
				$html .= '<label for="' . esc_attr( $field['id'] ) . '"><input type="checkbox" id="' . esc_attr( $field['id'] ) . '" name="' . $this->args['opt_name'] . '[' . esc_attr( $field['id'] ) . ']" ' . checked( 'on',
						$data, false ) . '/> ' . esc_attr( $field['description'] ) . '</label>';
				break;
			case 'select':
				$class = '';
				if ( ! empty( $field['box-title'] ) ) {
					$html .= '<h4>' . esc_attr( $field['box-title'] ) . '</h4>';
				}
				if ( ! empty( $field['class'] ) ) {
					$class = esc_attr( $field['class'] );
				}
				$html .= '<select class="' . $class . '" name="' . $this->args['opt_name'] . '[' . esc_attr( $field['id'] ) . ']" id="' . esc_attr( $field['id'] ) . '">';
				foreach ( $field['options'] as $k => $v ) {
					$selected = false;
					if ( $k == $data ) {
						$selected = true;
					}
					$html .= '<option ' . selected( $selected, true,
							false ) . ' value="' . esc_attr( $k ) . '">' . esc_attr( $v ) . '</option>';
				}
				$html .= '</select> ';
				break;
			case 'button':
				$html .= '<input class="' . esc_attr( $field['class'] ) . '" name="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['default'] ) . '" id="' . esc_attr( $field['id'] ) . '" />';
				break;
			case 'image':
				$html .= '<div class="box-image">';
				if ( $data != '' ) {
					$html             .= '<div class="img-container">';
					$image_attributes = wp_get_attachment_image_src( $data, 'full' );
					if ( ! empty( $image_attributes ) ) {
						$image_link = esc_url_raw( $image_attributes[0] );
					} else {
						$image_link = $data;
					}
					$html .= '<img src="' . $image_link . '" alt="" />';
					$html .= '</div>	';
				}

				$html       .= '<input class="of-input" name="' . $this->args['opt_name'] . '[' . esc_attr( $field['id'] ) . ']"   id="' . esc_attr( $field['id'] ) . '_upload" type="hidden" value="' . $data . '" />';
				$html       .= '<div class="upload_button_div">';
				$image_type = ( isset( $field['imagetype'] ) ) ? 'data-imagetype="' . $field['imagetype'] . '"' : '';
				$html       .= '<span ' . $image_type . ' class="button upload_btn" id="' . esc_attr( $field['id'] ) . '">' . __( 'Upload Image',
						'fruitful' ) . '</span>';
				if ( ! empty( $data ) ) {
					$none = '';
				} else {
					$none = 'none';
				}
				$html .= '<span class="button reset_btn ' . $none . '" id="reset_' . esc_attr( $field['id'] ) . '" title="' . esc_attr( $field['id'] ) . '">' . __( 'Remove',
						'fruitful' ) . '</span>';
				$html .= '</div>';
				$html .= '</div>';
				break;
			case 'color':
				if ( ! empty( $field['box-title'] ) ) {
					$html .= '<h4>' . esc_attr( $field['box-title'] ) . '</h4>';
				}
				$html .= '<input type="text" id="' . esc_attr( $field['id'] ) . '" class="colorPicker" name="' . $this->args['opt_name'] . '[' . esc_attr( $field['id'] ) . ']" value="' . esc_attr( $data ) . '" data-default-color="' . $field['default'] . '"/>';
				break;
			case 'font':
				$html .= '<div class="text_fonts">';
				$html .= '<div id="menu_sample_font" class="sample_text">' . __( 'Sample Font', 'fruitful' ) . '</div>';
				$html .= '<select class="select-fonts" name="' . $this->args['opt_name'] . '[' . esc_attr( $field['id'] ) . ']" id="options-' . esc_attr( $field['id'] ) . '">';
				foreach ( $field['options'] as $k => $v ) {
					$selected = false;
					if ( $k == $data ) {
						$selected = true;
					}
					$html .= '<option ' . selected( $selected, true,
							false ) . ' value="' . esc_attr( $k ) . '">' . esc_attr( $v ) . '</option>';
				}
				$html .= '</select> ';
				$html .= '</div>';
				break;
			case 'slides':
				fruitful_slider_images();
				break;
		}
		if ( ! $echo ) {
			return $html;
		}
		echo $html;
	}


	public function register_settings() {
		if ( is_array( $this->sections ) ) {
			foreach ( $this->sections as $section => $data ) {
				add_settings_section( $section, $data['title'], '__return_false', $this->args['opt_slug'] );
				foreach ( $data['fields'] as $field ) {
					$id    = ( isset( $field['id'] ) ) ? $field['id'] : '';
					$label = ( isset( $field['label'] ) ) ? $field['label'] : '';
					register_setting( $this->args['opt_group'], $this->args['opt_name'], '' );
					add_settings_field( $id, $label, array( $this, 'display_field' ), $this->args['opt_slug'], $section,
						$field );
				}
			}
		}
	}

	/**
	 * Renders the Theme Options administration screen.
	 *
	 * @since Fruitful theme 1.0
	 */
	public function fruitful_theme_options_render_page() {
		?>
        <div class="wrap">
            <h2></h2>
            <form method="post" action="/" enctype="multipart/form-data" class="form-admin-fruitful"
                  id="form-admin-fruitful">
                <div id="save_options" class="save-options"></div>
                <div class="header">
                    <h2 class="title_theme"><?php _e( 'Theme Options', 'fruitful' ); ?></h2>
					<?php submit_button( __( 'Save', 'fruitful' ) ); ?>
					<?php settings_errors(); ?>
                </div>
                <div class="content">
                    <div class="menu-options">
                        <ul>
							<?php
							$idx = 0;
							$idm = 0;
							foreach ( $this->sections as $section => $data ) {
								echo '<li id="' . $section . '"><a  id="item_' . $idx ++ . '" href="javascript:void(0)"><span class="menu-img" id="menu_img_' . $idm ++ . '"></span><span class="menu-text">' . $data['title'] . '</a></li>';
							}
							?>

                        </ul>
                    </div>
					<?php
					settings_fields( $this->args['opt_group'] );
					fruitful_custom_do_settings_sections( $this->args['opt_slug'] );
					?>

                </div>
                <div class="footer">
					<?php submit_button( __( 'Save', 'fruitful' ) ); ?>
                </div>
                <input type="hidden" name="action" value="fruitful_theme_options_action"/>
                <input type="hidden" name="security" value="<?php echo wp_create_nonce( 'fruitful_theme_data' ); ?>"/>
            </form>

            <div id="sidebar-promo" class="sidebar-promo">
                <div class="sidebar-promo-widget promo-support">
                    <h3><?php _e( 'Support', 'fruitful' ); ?></h3>
                    <p class="sidebar-promo-content"><?php
						_e( 'If You faced with problems or find error or bug, please', 'fruitful' );
						echo ' <a target="_blank" href="http://fruitfulcode.zendesk.com/hc/en-us/requests/new">';
						_e( 'submit request.', 'fruitful' );
						echo '</a> ';
						_e( 'On official ', 'fruitful' );
						echo ' <a target="_blank" href="http://wordpress.org/support/theme/fruitful">';
						_e( 'Support forum', 'fruitful' );
						echo '</a> ';
						_e( 'You may find answers on Your questions.', 'fruitful' );
						?></p>
                </div>
                <div class="sidebar-promo-widget promo-customization">
                    <h3><?php _e( 'Additional customization', 'fruitful' ); ?></h3>
                    <p class="sidebar-promo-content"><?php
						_e( 'Our team is available for any type of WordPress development. ', 'fruitful' );
						_e( 'If You want customize theme or add new features, You can', 'fruitful' );
						echo ' ';
						_e( 'submit order', 'fruitful' );
						echo ' ';
						_e( 'on our website', 'fruitful' );
						?></p>
                </div>
                <div class="sidebar-promo-widget promo-about">
                    <h3><?php _e( 'Fruitful PRO', 'fruitful' ); ?></h3>
                    <p class="sidebar-promo-content"><?php
						echo ' <a target="_blank" href="https://fruitfulcode.com/product/fruitful-pro">';
						_e( 'Fruitful PRO - WordPress responsive theme', 'fruitful' );
						echo '</a> ';
						_e( ' that contains all the options of ', 'fruitful' );
						echo ' <a target="_blank" href="https://wordpress.org/themes/fruitful/">';
						_e( 'FREE version', 'fruitful' );
						echo '</a> ';
						_e( ' plus:', 'fruitful' );
						?></p>
                    <ul class="sidebar-promo-list"><?php
						echo '<li><span>More options</span> like ability to change width for container grid.</li>';
						echo '<li><span>Priority</span> Support 24/7 with access to Help Center.</li>';
						echo '<li><span>Support</span> latest <a target="_blank" href="https://wordpress.org/plugins/woocommerce/">WooCommerce</a></li>';
						echo '<li><span>1 hour for customization</span> of your theme by our specialists.</li>';
						?></ul>
                </div>
            </div>
        </div>
		<?php
	}
}

global $fruitful_theme_options;
$fruitful_theme_options = new fruitful_theme_options();