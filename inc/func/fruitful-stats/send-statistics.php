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
function fruitful_fruitfultheme_send_stats() {

	$pararms = fruitful_fruitfultheme_build_stats_info_array();

	if ( ! empty( $pararms ) ) {

		$host = 'https://dev.app.fruitfulcode.com/';
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
function fruitful_fruitfultheme_build_stats_info_array($is_theme = true) {

	/** @var string $wp_version version of installed wordpress instance */
	global $wp_version;
	/** @var WP_Theme $theme_info */
	$theme_info = wp_get_theme();

	$ffc_statistic = $ffc_subscribe = $ffc_email = $ffc_name = '';

	/** General statistics option for all fruitfulcode products */
	$ffc_statistics_option = get_option('ffc_statistics_option');

	if( $ffc_statistics_option ) {

		if( isset($ffc_statistics_option['ffc_statistic']) ) {
			$ffc_statistic = $ffc_statistics_option['ffc_statistic'];
		}
		if( isset($ffc_statistics_option['ffc_subscribe']) ) {
			$ffc_subscribe = $ffc_statistics_option['ffc_subscribe'];
		}
		if( isset($ffc_statistics_option['ffc_subscribe_email']) ) {
			$ffc_email = $ffc_statistics_option['ffc_subscribe_email'];
		}
		if( isset($ffc_statistics_option['ffc_subscribe_name']) ) {
			$ffc_name = $ffc_statistics_option['ffc_subscribe_name'];
		}
	}

	if( $is_theme ) {
		$basic_params = [
			'product_name' => $theme_info->get( 'Name' ),
			'domain'       => site_url(),
		];
	}
	else {
		$path = plugin_dir_path( __FILE__ ).'/../fruitfultheme.php';
		$plugin_data = get_plugin_data( $path );
		$basic_params = [
			'product_name' => $plugin_data['Name'],
			'domain'       => site_url(),
		];
	}
	$site_info  = array();
	$stats_info = array();

	if ( $ffc_subscribe === '1' ) {

		$client_email = $ffc_email;
		$client_name  = $ffc_name;

		$user_info = array(
			'client_name' => $client_name,
			'email'       => $client_email,
		);

	} else {
		$user_info = array(
			'client_name' => 'deleted',
			'email'       => 'deleted',
		);
	}

	if ( $ffc_statistic === '1' ) {
		if($is_theme)
		{
			$site_info = array(
				'site_name'    => get_option( 'blogname' ),
				'php'          => PHP_VERSION,
				'product_ver'  => $theme_info->get( 'Version' ),
				'platform'     => 1,
				'platform_ver' => $wp_version,
				'service_info' => json_encode( array(
					'plugins' => get_option( 'active_plugins' )
				) )
			);
		} else {
			$site_info = array(
				'site_name'    => get_option( 'blogname' ),
				'php'          => PHP_VERSION,
				'product_ver'  => $plugin_data['Version'],
				'platform'     => 1,
				'platform_ver' => $wp_version,
				'service_info' => json_encode( array(
					'plugins' => get_option( 'active_plugins' )
				) )
			);
		}
	}

	if ( ! empty( $user_info ) || ! empty( $site_info ) ) {
		$stats_info = array_merge( $basic_params, $user_info, $site_info );
	}

	return $stats_info;
}

function fruitful_fruitfultheme_check_stats() {

	$fruitful_fruitfultheme_stat_sent = get_transient( 'fruitful_fruitfultheme_stat_sent' );

	if ( empty( $fruitful_fruitfultheme_stat_sent ) ) {
		set_transient( 'fruitful_fruitfultheme_stat_sent', '1', 3600 * 24 * 20 );
		do_action('fruitful_send_stats');
	}
}

/**
 * Update fruitful general statistics options on save theme customizer options
 *
 * @param $value
 * @param $old_value
 *
 * @return mixed
 */
function fruitful_fruitfultheme_send_stats_on_save( $value, $old_value ) {

	if( isset($value['ffc_subscribe']) && isset($old_value['ffc_subscribe']) &&
		isset($value['ffc_subscribe_name']) && isset($old_value['ffc_subscribe_name']) &&
		isset($value['ffc_subscribe_email']) && isset($old_value['ffc_subscribe_email']) &&
		isset($value['ffc_statistic']) && isset($old_value['ffc_statistic']) ) {

		if ($value['ffc_subscribe'] !== $old_value['ffc_subscribe'] ||
			$value['ffc_subscribe_name'] !== $old_value['ffc_subscribe_name'] ||
			$value['ffc_subscribe_email'] !== $old_value['ffc_subscribe_email'] ||
			$value['ffc_statistic'] !== $old_value['ffc_statistic']
		) {
			$ffc_statistics_option = get_option('ffc_statistics_option');

			$ffc_statistics_option['ffc_statistic'] = ($value['ffc_statistic'] == "on") ? "1" : "0";
			$ffc_statistics_option['ffc_subscribe'] = ($value['ffc_subscribe'] == "on") ? "1" : "0";
			$ffc_statistics_option['ffc_subscribe_email'] = $value['ffc_subscribe_email'];
			$ffc_statistics_option['ffc_subscribe_name'] = $value['ffc_subscribe_name'];

			update_option('ffc_statistics_option', $ffc_statistics_option);
			do_action('fruitful_send_stats');
		}
	}
	return $value;
}
/**
 * Start general fruitfulcode update settings action
 */
function fruitful_fruitfultheme_update_stats () {
	do_action('fruitful_stats_setting_update');
}
/**
 * Start general fruitfulcode send statistics action
 */
function fruitful_fruitfultheme_send_stats_action () {
	do_action('fruitful_send_stats');
}

/**
 * Add general fruitful sending stat hook
 */
add_action( 'fruitful_send_stats', 'fruitful_fruitfultheme_send_stats' );

/**
 * Add theme activate action
 */
add_action( 'after_switch_theme', 'fruitful_fruitfultheme_send_stats_action' );

/**
 * Add any update action
 */
add_action( 'upgrader_process_complete', 'fruitful_fruitfultheme_send_stats_action' );

/**
 * Add first init action
 */
add_action( 'init', 'fruitful_fruitfultheme_check_stats', 999 );

/**
 * Add update theme options on save action
 */
add_filter( 'pre_update_option_fruitful_theme_options', 'fruitful_fruitfultheme_send_stats_on_save', 10, 3 );

/**
 * Add action update general statistics option to change fruitfultheme theme settings option
 */
add_action( 'update_option_ffc_statistics_option', 'fruitful_fruitfultheme_update_stats');
