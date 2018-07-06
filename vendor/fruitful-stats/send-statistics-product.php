<?php

class FruitfulShortcodes_Stats extends FruitfulStatistic {
	
	public $product_type = 'plugin';
	
    public $product_option_name = 'fruitful-shortcodes';
    
	/**
	 * Constructor
	 **/
	public function __construct( $root_file ) {
		parent::__construct( $root_file );
	}
    
    /**
	 * Function update fruitful theme customizer option from general ffc statistic option
	 * (individual for each product)
	 */
	public function product_stats_settings_update()
    {
		$ffc_statistics_option = get_option('ffc_statistics_option');
		$options = fruitful_get_theme_options();

		if( !empty($ffc_statistics_option) ) {

			if( isset($ffc_statistics_option['ffc_statistic']) ) {
				$options['ffc_statistic'] = ($ffc_statistics_option['ffc_statistic'] === 1) ? 'on' : 'off';
			} else {
				$options['ffc_statistic'] = 'on';
			}

			if( isset($ffc_statistics_option['ffc_subscribe']) ) {
				$options['ffc_subscribe']= ($ffc_statistics_option['ffc_subscribe'] === 1) ? 'on' : 'off';
			} else {
				$options['ffc_subscribe'] = 'off';
			}

			if( isset($ffc_statistics_option['ffc_subscribe_name']) ) {
				$options['ffc_subscribe_name'] = sanitize_text_field($ffc_statistics_option['ffc_subscribe_name']);
			} else {
				$options['ffc_subscribe_name'] = '';
			}

			if( isset($ffc_statistics_option['ffc_subscribe_email']) ) {
				$options['ffc_subscribe_email'] = sanitize_email($ffc_statistics_option['ffc_subscribe_email']);
			} else {
				$options['ffc_subscribe_email'] = '';
			}

			update_option($this->product_option_name, $options);
		}
	}
}

/* usage :  

$optAdapter = new FFStatOptionsAdapter();

$optAdapter->sync_product_options_by_main();

$optAdapter->sync_main_options_by_product();

*/