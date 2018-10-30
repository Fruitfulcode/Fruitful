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

            public $product_type;

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

                if($data === false) {
                    return;
                }

                $option = get_option('ffc_advertising_option');

                if( $option === false ) {
                    $option = array();
                }

                $option[ $data['product_name'] ] = $data['advertising'];

                update_option( 'ffc_advertising_option', $option );

            }

            /**
             * Get product info
             */
            public function get_product_info_array() {

                $info    = array();

                /** @var WP_Theme $theme_info */
                $theme_info = wp_get_theme();

                if ( $this->product_type === 'theme' ) {
                    $info = array(
                        'product_name' => !empty($theme_info->parent_theme) ? $theme_info->parent_theme:$theme_info->get( 'Name' ),
                        'domain'       => esc_url(site_url()),
                    );

                } else { // this block for plugins only
                    if( !function_exists('get_plugin_data') ){  //Need when theme options update by ajax
                        require_once ABSPATH . 'wp-admin/includes/plugin.php';
                    }
                    $plugin_data = get_plugin_data( $this->root_file );
                    $info  = array(
                        'product_name' => $plugin_data['Name'],
                        'domain'       => esc_url(site_url()),
                    );
                }

                return $info;
            }


            /**
             * Get advertising data from server
             **/
            public function get_advertising() {

                //TODO change host to https://app.fruitfulcode.com/
                $host = 'https://dev.app.fruitfulcode.com/';
                $uri  = 'api/advertising/get';

                $params = $this->get_product_info_array();

                $response = wp_remote_post( $host . $uri, array(
                    'timeout'     => 20,
                    'sslverify' => true,
                    'body'    => $params
                ) );

                return ( !is_wp_error( $response ) ) ? array( 'product_name' => $params['product_name'], 'advertising' => (array) json_decode($response['body']) ) : false;
            }

            /**
             * Function check options on init in wp admin
             */
            public function init_advertising_option() {

                $product_info = $this->get_product_info_array();

                if ( (bool) get_transient('ffc_advertising_option_actual_' . $product_info['product_name'] ) === true ) {
                    return;
                }

                $this->update_advertising();

                //Seting transient to prevent often updates (checking in function init_advertising_option)
                set_transient( 'ffc_advertising_option_actual_' . $product_info['product_name'], true, 24 * HOUR_IN_SECONDS );
            }
        }
    }

    /**
     * Custom product class
     */
    require_once 'fruitful-advertising-product.php';
