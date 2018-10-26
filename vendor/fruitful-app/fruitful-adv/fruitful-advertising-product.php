<?php

	class FruitfulTheme_Adv extends FruitfulAdv {

		public $root_file;
		public $root_url;
		public $root_path;
		public $product_type;

		/**
		 * Constructor
		 **/
		public function __construct( $root_file, $product_type ) {

			$this->root_file = $root_file;
            $this->product_type = $product_type;

			//Adding path and urls
			if ( $this->product_type == 'theme' ) {
				$this->root_path = get_template_directory() . '/vendor/fruitful-app/';
				$this->root_url = get_template_directory_uri() . '/vendor/fruitful-app/';
			} else {
				$this->root_path = plugin_dir_path( $this->root_file ) . 'vendor/fruitful-app/';
				$this->root_url = plugin_dir_url( $this->root_file )  . 'vendor/fruitful-app/';
			}

			parent::__construct();

			//Add action for display advertising on fruitfulcode product option page
			add_action( 'ffc_display_advertising', array( $this, 'display_advertising' ) );

			// Add action to enqueue advertising styles and scripts
			add_action( 'admin_enqueue_scripts', array( $this, 'add_admin_scripts' ) );
		}

		/**
		 * Function enqueue styles and scripts for all admin pages
		 */
		public function add_admin_scripts() {

			$adv = get_option( 'ffc_advertising_option' );

			//enqueue scripts for advertising
			if( ! empty($adv['js']) ) {
				if ( ! wp_script_is( 'fruitful-app-advertising-scripts', 'enqueued' ) ) {
					wp_enqueue_script( 'fruitful-app-advertising-scripts', $this->root_url . 'fruitful-adv/assets/js/scripts.js', array( 'jquery' ) );
					wp_add_inline_script( 'fruitful-app-advertising-scripts', $adv['js'] );
				}
			}

			//enqueue styles for advertising
			if( ! empty($adv['css']) ) {
				if ( ! wp_style_is( 'fruitful-app-advertising-styles', 'enqueued' ) ) {
					wp_enqueue_style( 'fruitful-app-advertising-styles', $this->root_url . 'fruitful-adv/assets/styles/styles.css');
					wp_add_inline_style( 'fruitful-app-advertising-styles', $adv['css'] );
				}
			}
		}

		/**
		 * Display advertising on fruitfulcode product option page
		 */
		public function display_advertising() {

			$adv = get_option( 'ffc_advertising_option' );

			if( ! empty($adv['html']) ) {
				echo $adv['html'];
			}
		}

		/**
		* Check is advertising enabled
		*/
		public function is_advertising_enabled() {
			$adv = get_option( 'ffc_advertising_option' );

			if( ! empty($adv['html']) ) {
				return true;
			}

			return false;
		}
	}