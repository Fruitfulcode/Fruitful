<?php
/**
 * Send statistics to system via Curl
 *
 * PHP version 5.4
 *
 * @category   Fruitful
 * @package    Fruitful Stats
 * @author     Fruitful code <support@fruitfulcode.com>
 * @copyright  2018 Fruitful code
 * @version    1.0
 * @since      3.6.1
 * @license    https://opensource.org/licenses/OSL-3.0
 */




if ( !class_exists('FruitfulStatistic')) {
	
	abstract class FruitfulStatistic {
		
		public $product_type;
		
		public $product_option_name;
		
		public $controller;
		
		public $stats_path;
		
		public $stats_uri;
		
		public $root_file;
		

		
		/**
		 * Constructor
		 **/
		public function __construct( $root_file ) {
			
			$this->root_file = $root_file;
			
			if ( $this->product_type == 'theme' ) {
				$this->stats_path = get_template_directory() . '/vendor/';
				$this->stats_uri = get_template_directory_uri() . '/vendor/';
			} else {
				$this->stats_path = plugin_dir_path( $this->root_file ) . '/vendor/';
				$this->stats_uri = plugin_dir_url( $this->root_file )  . '/vendor/';
			}
			
			// INIT LOGIC
			add_action( 'admin_footer', array( $this, 'init_stats_option' ) );
			
			
			// Add general action hook for fruitful PRODUCT to send stat
			// --------------------------------------------------------------
			add_action( 'fruitful_send_stats', array( $this, 'send_stats' ) );
			
			// SENDING STATS by ffc_statistics_option changes
			add_action( 'add_option_ffc_statistics_option', function () {
				do_action( 'fruitful_send_stats' );
			} );
			
			add_action( 'update_option_ffc_statistics_option', function () {
				do_action( 'fruitful_send_stats' );
			} );
			
			
			// Add general action hook for sync fruitful PRODUCT options by ffc_statistics_option change
			// ----------------------------------------------------------------------------------
			add_action( 'product_stats_settings_update', array( $this, 'product_stats_settings_update' ) );
			
			// Sync PRODUCT options by ffc_statistics_option(pre_update_option_{$option})(add|update_option_{$option})
			
			add_action( 'add_option_ffc_statistics_option', function () {
				do_action( 'product_stats_settings_update' );
			} );
			
			add_action( 'update_option_ffc_statistics_option', function () {
				do_action( 'product_stats_settings_update' );
			} );
			
			
			// Sync ffc_statistics_option by PRODUCT options(pre_update_option_{$option})
			// ----------------------------------------------------------------------------
			add_filter( 'pre_update_option_' . $this->product_option_name, array(
				$this,
				'sync_general_stats_option'
			), 10, 3 );
			
			
			// Add any update THEME\PLUGIN action to send stats
			// ------------------------------------------------
			add_action( 'upgrader_process_complete', function () {
				do_action( 'fruitful_send_stats' );
			} );
			
			
			// Add sending stats periodically  by transient
			// ------------------------------------------------
			add_action( 'admin_footer', array( $this, 'check_stats' ), 999 );
			
			if ( ! function_exists( 'get_plugin_data' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
		}
		
		/**
		 * Load and instantiate all application
		 * classes necessary for ffc statistics
		 **/
		public function dispatch() {
			
			$this->controller = new stdClass();
			
			// Controller for modal notification
			require_once __DIR__ . '/send-statistics-modal.php';
			$this->controller->modal = new FruitfulStatisticModal( $this );
		}
		
		/**
		 * Function sends request to our server
		 */
		public function send_stats() {
			
			$params = $this->get_stats_info_array();
			
			if ( ! empty( $params ) ) {
				
				$host = 'https://app.fruitfulcode.com/';
				$uri  = 'api/product/statistics';
				
				$success = wp_remote_post( $host . $uri, array(
					'method'    => 'POST',
					'sslverify' => true,
					'timeout'   => 20,
					'blocking'  => false,
					'body'      => $params
				) );
				
				
				return is_wp_error( $success ) ? false : true;
			}
		}
		
		/**
		 * Function check stat options and returns statistic info array
		 *
		 * @return array
		 */
		public function get_stats_info_array() {
			$ffc_statistic = $ffc_subscribe = $ffc_email = $ffc_name = '';
			
			/** General statistics option for all fruitfulcode products */
			$ffc_statistics_option = get_option( 'ffc_statistics_option' );
			
			if ( $ffc_statistics_option ) {
				
				if ( isset( $ffc_statistics_option['ffc_statistic'] ) ) {
					$ffc_statistic = $ffc_statistics_option['ffc_statistic'];
				}
				if ( isset( $ffc_statistics_option['ffc_subscribe'] ) ) {
					$ffc_subscribe = $ffc_statistics_option['ffc_subscribe'];
				}
				if ( isset( $ffc_statistics_option['ffc_subscribe_email'] ) ) {
					$ffc_email = $ffc_statistics_option['ffc_subscribe_email'];
				}
				if ( isset( $ffc_statistics_option['ffc_subscribe_name'] ) ) {
					$ffc_name = $ffc_statistics_option['ffc_subscribe_name'];
				}
			}
			
			return $this->build_stats_info_array( $ffc_statistic, $ffc_subscribe, $ffc_email, $ffc_name );
		}
		
		/**
		 * Function returns statistic info array
		 *
		 * @param int $ffc_statistic
		 * @param int $ffc_subscribe
		 * @param string $ffc_email
		 * @param string $ffc_name
		 *
		 * @return array
		 */
		public function build_stats_info_array( $ffc_statistic, $ffc_subscribe, $ffc_email, $ffc_name ) {
			
			/** @var string $wp_version version of installed wordpress instance */
			global $wp_version;
			/** @var WP_Theme $theme_info */
			$theme_info = wp_get_theme();
			
			$all_info    = array();
			$basic_info  = array();
			$stat_info   = array();
			$user_info   = array();
			$plugin_data = array();
			
			
			// basic_info
			
			if ( $this->product_type == 'theme' ) {
				$basic_info = [
					'product_name' => $theme_info->get( 'Name' ),
					'domain'       => site_url(),
				];
			} else { // this block for plugins only
				$plugin_data = get_plugin_data( $this->root_file );
				$basic_info  = [
					'product_name' => $plugin_data['Name'],
					'domain'       => site_url(),
				];
			}
			
			
			// user_info
			
			if ( $ffc_subscribe === 1 ) {
				
				$client_email = sanitize_email( $ffc_email );
				$client_name  = sanitize_text_field( $ffc_name );
				
				$user_info = array(
					'client_name' => $client_name,
					'email'       => $client_email,
				);
				
			} else {
				$user_info = array(
					'client_name' => 'empty',
					'email'       => 'empty',
				);
			}
			
			
			// stat_info
			
			if ( $ffc_statistic === 1 ) {
				if ( $this->product_type == 'theme' ) {
					$stat_info = array(
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
					$stat_info = array(
						'site_name'    => get_option( 'blogname' ),
						'php'          => PHP_VERSION,
						'product_ver'  => $plugin_data['Version'],
						'platform'     => 1,
						'platform_ver' => $wp_version,
						'service_info' => json_encode( array(
							'plugins' => get_option( 'active_plugins' ),
							'active_theme' => array(
								'Name' => $theme_info->get( 'Name' ),
								'ThemeURI' => $theme_info->get( 'ThemeURI' ),
								'Description' => $theme_info->get( 'Description' ),
								'Author' => $theme_info->get( 'Author' ),
								'AuthorURI' => $theme_info->get( 'AuthorURI' ),
								'Version' => $theme_info->get( 'Version' ),
								'Template' => $theme_info->get( 'Template' ),
								'Status' => $theme_info->get( 'Status' ),
								'Tags' => implode(', ', $theme_info->get( 'Tags' )),
							)
						) )
					);
				}
			}
			
			// all_info
			
			if ( $ffc_subscribe === 1 || $ffc_statistic === 1 ) {
				$all_info = array_merge( $basic_info, $user_info, $stat_info );
			}
			
			return $all_info;
		}
		
		/**
		 * Function send statistics on first theme init
		 */
		public function check_stats() {
			
			$ffc_fruitfultheme_stat_sent = get_transient( 'ffc_fruitfultheme_stat_sent' );
			
			if ( empty( $ffc_fruitfultheme_stat_sent ) ) {
				set_transient( 'ffc_fruitfultheme_stat_sent', 1, 1728000 ); //1728000 = 3600 * 24 * 20
				do_action( 'fruitful_send_stats' );
			}
		}
		
		/**
		 * Function update general ffc_statistics_option on save theme PRODUCT options
		 *
		 * @param $value
		 * @param $old_value
		 *
		 * @return mixed
		 */
		public function sync_general_stats_option( $value, $old_value ) {
			
			
			if ( ! isset( $value['ffc_subscribe'] ) && ! isset( $old_value['ffc_subscribe'] ) &&
			     ! isset( $value['ffc_subscribe_name'] ) && ! isset( $old_value['ffc_subscribe_name'] ) &&
			     ! isset( $value['ffc_subscribe_email'] ) && ! isset( $old_value['ffc_subscribe_email'] ) &&
			     ! isset( $value['ffc_statistic'] ) && ! isset( $old_value['ffc_statistic'] ) ) {
				
				return $value;
			}
			
			if ( $value['ffc_subscribe'] !== $old_value['ffc_subscribe'] ||
			     $value['ffc_subscribe_name'] !== $old_value['ffc_subscribe_name'] ||
			     $value['ffc_subscribe_email'] !== $old_value['ffc_subscribe_email'] ||
			     $value['ffc_statistic'] !== $old_value['ffc_statistic']
			) {
				$ffc_statistics_option = get_option( 'ffc_statistics_option' );
				
				$ffc_statistics_option['ffc_statistic']       = ( $value['ffc_statistic'] === 'on' ) ? 1 : 0;
				$ffc_statistics_option['ffc_subscribe']       = ( $value['ffc_subscribe'] === 'on' ) ? 1 : 0;
				$ffc_statistics_option['ffc_subscribe_email'] = sanitize_email( $value['ffc_subscribe_email'] );
				$ffc_statistics_option['ffc_subscribe_name']  = sanitize_text_field( $value['ffc_subscribe_name'] );
				
				update_option( 'ffc_statistics_option', $ffc_statistics_option );
			}
			
			return $value;
		}
		
		public function init_stats_option() {
			
			$ffc_statistics_option = get_option( 'ffc_statistics_option' );
			
			if ( ! empty( $ffc_statistics_option ) ) {
				return;
			}
			
			$this->controller->modal->admin_show_modal();
			
			$ffc_statistics_option                  = array();
			$ffc_statistics_option['ffc_statistic'] = 1;
			$ffc_statistics_option['ffc_subscribe'] = 0;
			
			update_option( 'ffc_statistics_option', $ffc_statistics_option );
		}
		
		public function isModalShowed() {
			return self::$modal_showed;
		}
		
		public function setModalShowed() {
			self::$modal_showed = true;
		}
		
		
		/**
		 * Function update fruitful theme customizer option from general ffc statistic option
		 * (individual for each product)
		 */
		abstract public function product_stats_settings_update();
	}
}

/**
 * custom product class
 */
require_once 'send-statistics-product.php';

/**
 * modal form for request to sending statistics
 */
require_once 'send-statistics-modal.php';
