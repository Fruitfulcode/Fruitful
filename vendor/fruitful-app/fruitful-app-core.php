<?php

	/**
	 * Class Fruitful[Product]App
	 * Fruitfulcode application core
	 * (individual for each product)
	 */

class FruitfulThemeApp {

	public $product_type = 'theme'; //{theme|plugin}

	public $product_option_name = 'fruitful_theme_options';

	public $root_file;

	/**
	 * Constructor
	 **/
	public function __construct($root_file) {

		// Fruitful statistics
		$this->root_file = $root_file;

	}

	/**
	 * Load and initiate all modules of fruitfulcode application
	 **/
	public function dispatch() {

		$this->controller = new stdClass();

		// Controller for fruitfulcode statistics
		require_once dirname($this->root_file) . '/vendor/fruitful-app/fruitful-stats/send-statistics.php';
		$this->controller->statistic = new FruitfulTheme_Stats( $this->root_file, $this->product_type, $this->product_option_name );
		$this->controller->statistic->dispatch();

		// Controller for fruitfulcode advertising
		require_once dirname($this->root_file) . '/vendor/fruitful-app/fruitful-adv/fruitful-advertising.php';
		$this->controller->advertising = new FruitfulTheme_Adv( $this->root_file, $this->product_type );

	}
    
}
