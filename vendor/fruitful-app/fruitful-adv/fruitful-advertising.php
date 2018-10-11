<?php
/**
 * Fruitful advertising library
 *
 * This library get advertising data from app.fruitfulcode.com
 *
 * PHP version 5.4
 *
 * @category   Fruitful
 * @package    Fruitful App
 * @author     Fruitful code <support@fruitfulcode.com>
 * @link       https://fruitfulcode.com
 * @copyright  2018 Fruitful code
 * @version    0.0.1
 * @license    GPL-2.0+
 * @textdomain fruitful-app
 */


if ( !class_exists('FruitfulAdv')) {
	
	abstract class FruitfulAdv {
		
		/**
		 * Constructor
		 **/
		public function __construct() {

			add_action( 'admin_footer', array( $this, 'init_advertising_option' ) );

		}

		/**
		 * Update advertising data
		 **/
		public function update_advertising() {

			$data = $this->get_advertising();

			update_option( 'ffc_advertising_option', $data );

			//Seting transient to prevent often updates (checking in function init_advertising_option)
			set_transient( 'ffc_advertising_option_actual', true, 24 * HOUR_IN_SECONDS );
		}

		/**
		 * Get advertising data from server
		 **/
		public function get_advertising() {

			$response = array();

			$response['html'] = '<span class="ff-advertising">Advertising</span>';
			$response['css'] = '.ff-advertising { color: orange; }';
			$response['js'] = 'console.log("test");';

			return $response;

		}

		/**
		 * Function check options on init in wp admin
		 */
		public function init_advertising_option() {

			if ( ! empty( get_option( 'ffc_advertising_option' ) ) && (bool) get_transient('ffc_advertising_option_actual') === true ) {
				return;
			}

			$this->update_advertising();
		}
	}
}

/**
 * Custom product class
 */
require_once 'fruitful-advertising-product.php';
