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

			$response['html'] = '<div class="ff-adv-inner"><a href="https://fruitfulcode.com/products/lovely-one-page-wordpress-theme/" class="thumb" target="_blank"><img src="https://38k3yyk4vw814f94ak1lhssj-wpengine.netdna-ssl.com/wp-content/uploads/2014/08/lovely-showcase-420x420.jpg" alt="Lovely | One page WordPress Theme" class="" data-width="420" data-height="420" data-src="https://38k3yyk4vw814f94ak1lhssj-wpengine.netdna-ssl.com/wp-content/uploads/2014/08/lovely-showcase-420x420.jpg"></a><div class="product-footer"><div class="product-desc-container"><a href="https://fruitfulcode.com/products/lovely-one-page-wordpress-theme/" target="_blank">Lovely | One page WordPress Theme</a><p>Template can be used by creative and design agencies, freelance designers, photographers and other creative souls! The greatest feature is ultra easy editing of a modern “skewed” background blocks. Also sections or elements can be animated with prepared animation.</p></div></div></div>';
			$response['css'] = '.ff-adv-inner {max-width: 290px;} .product-desc-container a {color: #ff5c35;font-weight: bold;text-decoration: none; font-size: 15px;margin-top: 10px;display: inline-block;text-align: center; transition: 0.2s;} .product-desc-container a:focus{outline:none; box-shadow: none;}.product-desc-container a:hover {color: #3e3e3e; transition: 0.3s;}  .thumb{display: block; overflow: hidden;} .thumb img {display:block; width:100%; height:auto; transition: 0.35s;} .thumb:hover img {transform: scale(1.2) rotate(10deg);}';
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
