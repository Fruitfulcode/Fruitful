<?php

require_once dirname( __FILE__ ) . '/plugin-activation.php';

add_action( 'tgmpa_register', 'fruitful_register_required_plugins' );
/**
 * Register the required plugins for Fruitful theme.
 */
function fruitful_register_required_plugins() {

	$plugins = array(
		array(
			'name'    => 'Maintenance',
			'slug'    => 'maintenance',
			'required'  => false,
		),

		array(
			'name'    => 'Fruitful Shortcodes',
			'slug'    => 'fruitful-shortcodes',
			'required'  => true,
		),
		
		array(
			'name'     				=> 'Elementor', 
			'slug'     				=> 'elementor ',
			'required' 				=> false,
		),

		array(
			'name'    => 'WPForms Lite',
			'slug'    => 'wpforms-lite',
			'required'  => false,
		),

	);

	$config = array(
		'id'           => 'fruitful',                  // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                          // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins',  // Menu slug.
		'parent_slug'  => 'themes.php',           	   // Parent menu slug.
		'capability'   => 'edit_theme_options',   	 // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    	// Show admin notices or not.
		'dismissable'  => true,                   	 // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                     	 // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                  	 // Automatically activate plugins after installation or not.
		'message'       => '<span class="fruitful-msg"><br />1. Select all plugins checkbox to the left of "Plugin" <br />2. Click "Bulk Actions" and then Install <br />3. Click "Apply" button</span>',              
		'strings'      => array(
			'page_title'                            => __( 'Fruitful Plugin Integration', 'fruitful' ),
			'menu_title'                            => __( 'Plugin Integration', 'fruitful' ),
			'installing'                            => __( 'Installing Plugin: %s', 'fruitful' ), // %1$s = plugin name
			'oops'                                  => __( 'Something went wrong with the plugin API.', 'fruitful' ),
			'notice_can_install_required'     => _n_noop(
				'Fruitful theme requires the following plugin: %1$s.',
				'Fruitful theme requires the following plugins: %1$s.',
				'fruitful'
			), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop(
				'Fruitful theme recommends the following plugin: %1$s.',
				'Fruitful theme recommends the following plugins: %1$s.',
				'fruitful'
			), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'fruitful'
			), // %1$s = plugin name(s).
			// 'notice_ask_to_update_maybe'      => _n_noop(
				// 'There is an update available for: %1$s.',
				// 'There are updates available for the following plugins: %1$s.',
				// 'theme-slug'
			// ), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'fruitful'
			), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'fruitful'
			), // %1$s = plugin name(s).
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'fruitful'
			),
			// 'update_link' 					  => _n_noop(
				// 'Begin updating plugin',
				// 'Begin updating plugins',
				// 'theme-slug'
			// ),
			'activate_link'                   => _n_noop(
				'Activate installed plugin',
				'Activate installed plugins',
				'fruitful'
			),
			'return'                         	=> __( 'Return to Required Plugins Installer', 'fruitful' ),
			'plugin_activated'                  => __( 'Plugin activated successfully.', 'fruitful' ),
			//'activated_successfully'          => __( 'The following plugin was activated successfully:', 'fruitful' ),
			//'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'fruitful' ),  // %1$s = plugin name(s).
			//'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'fruitful' ),  // %1$s = plugin name(s).
			'complete'                          => __( 'All plugins installed and activated successfully. %1$s', 'fruitful' ), // %s = dashboard link.
			//'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'fruitful' ),
			//'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'fruitful' ),
			'nag_type'                          => 'updated', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
	); 
	

  tgmpa( $plugins, $config );
}

?>