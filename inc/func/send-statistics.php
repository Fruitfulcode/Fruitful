<?php
/**
 * Send statistics to system via Curl
 *
 * PHP version 5.4
 *
 * @category   Fruitful
 * @package    Fruitful
 * @author     Fruitful code <support@fruitfulcode.com>
 * @copyright  2018 Fruitful code
 * @version    1.0
 * @since      3.6.1
 * @license    https://opensource.org/licenses/OSL-3.0
 */

/**
 * Function sends request to our server
 */
function fruitful_send_stats() {

	$pararms = fruitful_build_stats_info_array();

	if ( ! empty( $pararms ) ) {

		$host = 'https://app.fruitfulcode.com/';
		$uri  = 'api/product/statistics';

		wp_remote_post( $host . $uri, array(
			'method'    => 'POST',
			'sslverify' => true,
			'timeout'   => 30,
			'body'      => $pararms
		) );

	}
}

/**
 * Function returns statistic info array
 *
 * @return array
 */
function fruitful_build_stats_info_array() {

	/** @var string $wp_version version of installed wordpress instance */
	global $wp_version;
	/** @var WP_Theme $theme_info */
	$theme_info = wp_get_theme();

	$options = fruitful_get_theme_options();

	$stats_arr  = [];
	$subscr_arr = [];

	if ( $options['ffc_statistic'] === 'on' ) {
		$stats_arr = array(
			'product_name' => $theme_info->get( 'Name' ),
			'domain'       => site_url(),
			'name'         => get_option( 'blogname' ),
			'php_ver'      => PHP_VERSION,
			'prod_ver'     => $theme_info->get( 'Version' ),
			'wp_ver'       => $wp_version,
			'service_info' => json_encode( array(
				'plugins' => get_option( 'active_plugins' )
			) )
		);
	}

	if ( $options['ffc_subscribe'] === 'on' ) {
		$subscr_arr = array(
			'email' => get_option( 'admin_email' ),
		);
	}

	return array_merge( $stats_arr, $subscr_arr );
}

function fruitful_check_stats() {

	$fruitful_stat_sent = get_transient( 'fruitful_stat_sent' );

	if ( empty( $fruitful_stat_sent ) ) {
		set_transient( 'fruitful_stat_sent', '1', 3600 * 24 * 20 );
		fruitful_send_stats();
	}
}


/**
 * Add theme activate action
 */
add_action( 'after_switch_theme', 'fruitful_send_stats' );

/**
 * Add any update action
 */
add_action( 'upgrader_process_complete', 'fruitful_send_stats' );

/**
 * Add first init action
 */
add_action( 'init', 'fruitful_check_stats', 999 );

 


