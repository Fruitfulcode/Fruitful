<?php
	/**
	 * Enqueue scripts for all admin pages
	 */
	add_action( 'admin_enqueue_scripts', 'fruitfultheme_add_admin_scripts' );
	function fruitfultheme_add_admin_scripts() {
		if(!wp_script_is( 'fruitful-stats-modal', 'enqueued' )) {
			wp_enqueue_script( 'fruitful-stats-modal', get_template_directory_uri() . '/inc/func/fruitful-stats/assets/js/admin_scripts.js', array( 'jquery' ) );
		}
		if(!wp_style_is( 'fruitful-stats-modal-styles', 'enqueued' )) {
			wp_enqueue_style( 'fruitful-stats-modal-styles', get_template_directory_uri() . '/inc/func/fruitful-stats/assets/styles/admin_styles.css' );
		}
	}

	/**
	 * Checking is set fruitful statistic variable
	 * And showing statistics settings modal if fruitful statistic variable not set
	 * Or update fruitful theme settings options if fruitful statistic variable set and this is first init
	 */
	add_action( 'admin_footer', 'fruitfultheme_shortcodes_admin_notice' );
	function fruitfultheme_shortcodes_admin_notice() {

		$ffc_statistics_option = get_option('ffc_statistics_option');

		if( !$ffc_statistics_option ) {
			update_option('ffc_statistics_option', array('ffc_is_now_showing_subscribe_notification' => '1', 'ffc_is_hide_subscribe_notification' => '0', 'ffc_path_to_current_notification' => __FILE__ ) );
			require plugin_dir_path( __FILE__ ). '/view/send-statistics-modal-view.php';
		} else {
			if( isset($ffc_statistics_option['ffc_is_hide_subscribe_notification']) && isset($ffc_statistics_option['ffc_is_now_showing_subscribe_notification']) && isset($ffc_statistics_option['ffc_path_to_current_notification']) )
			{
				if( $ffc_statistics_option['ffc_is_hide_subscribe_notification'] == '0' ) {
					if ( $ffc_statistics_option['ffc_is_now_showing_subscribe_notification'] != '1' || $ffc_statistics_option['ffc_path_to_current_notification'] == __FILE__) {
						$ffc_statistics_option['ffc_is_now_showing_subscribe_notification'] = '1';
						$ffc_statistics_option['ffc_path_to_current_notification'] = __FILE__;
						update_option('ffc_statistics_option', $ffc_statistics_option);
						require plugin_dir_path( __FILE__ ). '/view/send-statistics-modal-view.php';
					}
				}
				else {
					if(get_option('fruitfultheme_stat_first_init')!='1') // update fruitful theme settings options if fruitful statistic variable set and this is first init
					{
						do_action('fruitful_stats_setting_update');
						update_option('fruitfultheme_stat_first_init', '1');
					}
				}
			}
		}
	}

	/**
	 * Action on submit statistics modal
	 */
	add_action( 'wp_ajax_fruitfultheme_submit_modal', 'fruitfultheme_submit_modal' );
	function fruitfultheme_submit_modal() {

		$request_data = $_POST['data'];

		$response = array(
			'status'            => 'failed',
			'title'             => esc_html__( 'Uh oh!', 'fruitful' ),
			'error_message'     => esc_html__( 'Sorry, something went wrong, and we failed to receive the shared data from you.', 'fruitful' ),
			'error_description' => esc_html__( 'No worries; go to the theme option to enter the required data manually and save changes.', 'fruitful' ),
			'stat_msg'          => '',
			'subscr_msg'        => ''
		);

		$ffc_statistics_option = get_option('ffc_statistics_option');

		if ( ! empty( $request_data ) ) {
			foreach ( $request_data as $option => $value ) {
				if ( isset( $value ) ) {
					$ffc_statistics_option[$option] = $value;
				}
			}
			$ffc_statistics_option['ffc_is_hide_subscribe_notification'] = '1';
			$ffc_statistics_option['ffc_is_now_showing_subscribe_notification'] = '0';
			$ffc_statistics_option['ffc_path_to_current_notification'] = '';
			update_option('ffc_statistics_option', $ffc_statistics_option);

			if ( $request_data['ffc_statistic'] === '1' || $request_data['ffc_subscribe'] === '1' ) {
				$response = array(
					'status'            => 'success',
					'title'             => esc_html__( 'Thank you!', 'fruitful' ),
					'error_message'     => '',
					'error_description' => '',
					'stat_msg'          => esc_html__( 'Thank you for being supportive, we appreciate your understanding and assistance!', 'fruitful' ),
					'subscr_msg'        => $request_data['ffc_subscribe'] === '1' ? __( "Don't forget to check your inbox for our latest letter - you’d like that!", 'fruitful' ) : ''
				);
			} else {
				$response = array(
					'status'            => 'success',
					'title'             => esc_html__( 'What a pity!', 'fruitful' ),
					'error_message'     => '',
					'error_description' => '',
					'stat_msg'          => esc_html__( 'We wish you could have shared your site statistic and joined our community.', 'fruitful' ),
					'subscr_msg'        => esc_html__( 'But if you ever change your mind, you can always do that in the theme options.', 'fruitful' )
				);
			}
		}
		do_action('fruitful_stats_setting_update');
		do_action('fruitful_send_stats');
		wp_send_json( $response );
	}

	/**
	 * Action click close button statistics modal
	 */
	add_action( 'wp_ajax_fruitfultheme_dismiss_subscribe_notification', 'fruitfultheme_dismiss_subscribe_notification' );
	function fruitfultheme_dismiss_subscribe_notification() {

		$ffc_statistics_option = get_option('ffc_statistics_option');
		$ffc_statistics_option['ffc_is_now_showing_subscribe_notification'] = '0';
		$ffc_statistics_option['ffc_is_hide_subscribe_notification'] = '1';
		$ffc_statistics_option['ffc_path_to_current_notification'] = '';
		update_option('ffc_statistics_option', $ffc_statistics_option);
		do_action('fruitful_send_stats');
		wp_send_json( 'success' );
	}

	/**
	 * Update settings in fruitful theme theme customizer
	 * when statistics settings changed in another fruitful products
	 */
	add_action( 'fruitful_stats_setting_update', 'fruitfultheme_statistics_settings_update' );
	function fruitfultheme_statistics_settings_update() {

		$ffc_statistics_option = get_option('ffc_statistics_option');
		$options = fruitful_get_theme_options();

		if( isset($ffc_statistics_option) ) {

			if( isset($ffc_statistics_option['ffc_statistic']) ) {
				$options['ffc_statistic'] = ($ffc_statistics_option['ffc_statistic']=="1") ? "on" : "off";
			} else {
				$options['ffc_statistic'] = 'on';
			}

			if( isset($ffc_statistics_option['ffc_subscribe']) ) {
				$options['ffc_subscribe']= ($ffc_statistics_option['ffc_subscribe']=="1") ? "on" : "off";
			} else {
				$options['ffc_subscribe'] = 'off';
			}

			if( isset($ffc_statistics_option['ffc_subscribe_name']) ) {
				$options['ffc_subscribe_name'] = $ffc_statistics_option['ffc_subscribe_name'];
			} else {
				$options['ffc_subscribe_name'] = '';
			}

			if( isset($ffc_statistics_option['ffc_subscribe_email']) ) {
				$options['ffc_subscribe_email'] = $ffc_statistics_option['ffc_subscribe_email'];
			} else {
				$options['ffc_subscribe_email'] = '';
			}

			update_option('fruitful_theme_options', $options);
			do_action('fruitful_send_stats');
		}
	}

