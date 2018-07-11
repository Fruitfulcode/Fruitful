<?php
/**
 * Fruitful send techical data libruary
 *
 * This libruary send anonymous technical data to app.fruitfulcode.com
 * Also, if user subscribe to the Fruitful Code newsletters, system send to app.fruitfulcode user Name and Email for the latest updates.
 *
 * PHP version 5.4
 *
 * @category   Fruitful
 * @package    Fruitful Stats
 * @author     Fruitful code <support@fruitfulcode.com>
 * @link       https://fruitfulcode.com
 * @copyright  2018 Fruitful code
 * @version    1.0
 * @license    GPL-2.0+
 * @textdomain fruitful-stats
 */




if ( !class_exists('FruitfulStatistic')) {
	
	abstract class FruitfulStatistic {
		
		public $product_type;
		
		public $product_option_name;
		
		public $controller;
		
		public $data;
		
		public $root_file;

		
		/**
		 * Constructor
		 **/
		public function __construct( $root_file ) {
			
			$this->root_file = $root_file;
			
			/*
			* Adding path and urls. Can change in extended class
			*/
			if ( $this->product_type == 'theme' ) {
				$this->data['stats_path'] = get_template_directory() . '/vendor/';
				$this->data['stats_uri'] = get_template_directory_uri() . '/vendor/';
			} else {
				$this->data['stats_path'] = plugin_dir_path( $this->root_file ) . 'vendor/';
				$this->data['stats_uri'] = plugin_dir_url( $this->root_file )  . 'vendor/';
			}
			
			// INIT LOGIC
			add_action( 'admin_footer', array( $this, 'init_stats_option' ) );
			
			/*
			* Sync PRODUCT options by ffc_statistics_option (add|update_option_{$option})
			* And SENDING STATS by ffc_statistics_option changes
			*/
			add_action( 'add_option_ffc_statistics_option', function () {
				$this->product_stats_settings_update();
				$this->send_stats();
			} );
			
			add_action( 'update_option_ffc_statistics_option', function () {
				$this->product_stats_settings_update();
				$this->send_stats();
			} );
			
			if ( $this->product_type == 'theme' ) {
				add_action( 'after_switch_theme', function () {
					$this->product_stats_settings_update();
				} );
			} else {
				register_activation_hook( $this->root_file, array( $this, 'product_stats_settings_update' ) );
			}
			
			/*
			* Sync ffc_statistics_option by PRODUCT options(pre_update_option_{$product_option_name})
			* --------------------------------------------------------------
			*/
			add_filter( 'pre_update_option_' . $this->product_option_name, array( $this, 'general_stats_option_update' ), 10, 3 );
			
			
			// Add any update THEME\PLUGIN action to send stats
			// --------------------------------------------------------------
			add_action( 'upgrader_process_complete', array( $this, 'send_stats' ) );
			
			add_action( 'activated_plugin', array( $this, 'send_stats' ) );
			
			add_action( 'deactivated_plugin', array( $this, 'send_stats' ) );
			
			//Custom action to send stats (need do_action( 'fruitful_send_stats'))
			add_action( 'fruitful_send_stats', array( $this, 'send_stats' ) );
		}
		
		/**
		 * Load and instantiate all application
		 * classes necessary for ffc statistics
		 **/
		public function dispatch() {
			
			$this->controller = new stdClass();
			
			// Controller for modal notification
			require_once __DIR__ . '/send-statistics-modal.php';
			$this->controller->modal = new FruitfulStatisticModal( $this->data );
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
					'domain'       => esc_url(site_url()),
				];
			} else { // this block for plugins only
				$plugin_data = get_plugin_data( $this->root_file );
				$basic_info  = [
					'product_name' => $plugin_data['Name'],
					'domain'       => esc_url(site_url()),
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
		 * Function check options on init in wp admin
		 */
		public function init_stats_option() {
			
			$ffc_statistics_option = get_option( 'ffc_statistics_option' );
			
			if ( ! empty( $ffc_statistics_option ) ) {
				return;
			}
			
			$this->controller->modal->admin_show_modal();
			
			$ffc_statistics_option            = array();
			$ffc_statistics_option['ffc_statistic'] = 1;
			$ffc_statistics_option['ffc_subscribe'] = 0;
			
			update_option( 'ffc_statistics_option', $ffc_statistics_option );
		}
		
		/**
		 * Function update general ffc_statistics_option on save theme PRODUCT options
		 * (individual for each product)
		 *
		 * @param $value
		 * @param $old_value
		 *
		 * @return mixed
		 */
		abstract public function general_stats_option_update( $value, $old_value );
		
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
