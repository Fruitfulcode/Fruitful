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
 * @since      3.7
 * @license    https://opensource.org/licenses/OSL-3.0
 */

/** including Curl library */
require_once __DIR__ . '/libs/Curl.php';

/** @var WP_Theme $theme_info */
$theme_info = wp_get_theme();
/** @var string $wp_version version of installed wordpress instance */
global $wp_version;

/**
 * Function sends request to our server
 */
$send_stats = function () use ( $wp_version, $theme_info ) {

	$curl = new \Curl\Curl();
	$curl->setOpt( CURLOPT_SSL_VERIFYPEER, false );

	$host = 'https://app.fruitfulcode.com/';
	$uri  = 'api/product/statistics';

	$pararms = array(
		'product_name' => $theme_info->get( 'Name' ),
		'domain'       => site_url(),
		'email'        => get_option( 'admin_email' ),
		'name'         => get_option('blogname'),
		'php_ver'      => null !== PHP_VERSION ? PHP_VERSION : phpversion(),
		'prod_ver'     => $theme_info->get( 'Version' ),
		'wp_ver'       => $wp_version
	);

	$curl->get( $host . $uri . '?' . http_build_query( $pararms ) );
};

add_action( 'after_switch_theme', $send_stats );

/**
 * Add Weekly cron
 */
add_filter( 'cron_schedules', function ( $schedules ) {
	$schedules['weekly'] = array(
		'interval' => strtotime( '+1 week' ),
		'display'  => __( 'Weekly' )
	);

	return $schedules;
} );

/**
 * Add cron action
 */
add_action( 'send_stats_hook_cron', $send_stats );

/**
 * Schedule cron every week
 */
if ( ! wp_next_scheduled( 'send_stats_hook_cron' ) ) {
	wp_schedule_event( time(), 'weekly', 'send_stats_hook_cron' );
}