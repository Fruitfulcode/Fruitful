<?php

require_once('plugin-activation.php');

define('CloudServer', 'http://s3.amazonaws.com/DSMarketer');
define('PluginFolder', CloudServer . '/plugins/');

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
/**
 * Register the required plugins for Fruitful theme.
 */
function my_theme_register_required_plugins() {

	$plugins = array(
		array(
			'name'    => 'Contact Form 7',
			'slug'    => 'contact-form-7',
			'required'  => false,
		),
		
		array(
			'name'    => 'Maintenance',
			'slug'    => 'maintenance',
			'required'  => false,
		),

		array(
			'name'    => 'WordPress SEO by Yoast',
			'slug'    => 'wordpress-seo',
			'required'  => false,
		),

		array(
			'name'    => 'WooCommerce - excelling eCommerce',
			'slug'    => 'woocommerce',
			'required'  => false,
		),
	);

	$config = array(
		'domain'          => 'fruitful',          
		'default_path'    => '',                         
		'parent_menu_slug'  => 'themes.php',        
		'parent_url_slug'   => 'themes.php',        
		'menu'            => 'install-required-plugins',
		'has_notices'       => true,                    
		'is_automatic'      => true,         
		'message'       => '<br />1. Select all plugins checkbox to the left of "Plugin" <br />2. Click "Bulk Actions" and then Install <br />3. Click "Apply" button',              
		'strings'         => array(
			'page_title'                            => __( 'Fruitful Plugin Integration', 'fruitful' ),
			'menu_title'                            => __( 'Plugin Integration', 'fruitful' ),
			'installing'                            => __( 'Installing Plugin: %s', 'fruitful' ), // %1$s = plugin name
			'oops'                                  => __( 'Something went wrong with the plugin API.', 'fruitful' ),
			'notice_can_install_required'           => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'      => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'          => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'     => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link'                  => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link'                 => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                                => __( 'Return to Required Plugins Installer', 'fruitful' ),
			'plugin_activated'                      => __( 'Plugin activated successfully.', 'fruitful' ),
			'complete'                  => __( 'All plugins installed and activated successfully. %s', 'fruitful' ), // %1$s = dashboard link
			'nag_type'                  => 'updated' 
		)
	);

  tgmpa( $plugins, $config );
}

?>