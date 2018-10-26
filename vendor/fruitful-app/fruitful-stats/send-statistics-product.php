<?php

class FruitfulTheme_Stats extends FruitfulStatistic {

	public $product_type;

	public $product_option_name;

	/**
	 * Constructor
	 **/
	public function __construct( $root_file, $product_type, $product_option_name ) {

		$this->product_type = $product_type;
		$this->product_option_name = $product_option_name;

		parent::__construct( $root_file );

        //Redeclare path and uri ( in FruitfulStatistic construct it declared without /fruitful-app/ )
        if($product_type === 'plugin') {
            $this->data['stats_path'] = plugin_dir_path($root_file) . '/vendor/fruitful-app/';
            $this->data['stats_uri'] = plugin_dir_url($root_file) . '/vendor/fruitful-app/';
        } else {
            $this->data['stats_path'] = get_template_directory() . '/vendor/fruitful-app/';
            $this->data['stats_uri'] = get_template_directory_uri() . '/vendor/fruitful-app/';
        }
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
			$this->send_stats();
		}
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
	public function general_stats_option_update( $value, $old_value ) {

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
}
