<?php
/**
 * Created by PhpStorm.
 * User: viktor
 * Date: 31/05/18
 * Time: 13:00
 */


	/**
	 * Enqueue scripts for all admin pages
	 */
	add_action( 'admin_enqueue_scripts', 'fruitful_add_admin_scripts' );
	function fruitful_add_admin_scripts() {
		wp_enqueue_script( 'fruitful-stats-modal', get_template_directory_uri() . '/inc/func/fruitful-stats/assets/js/admin_scripts.js', array( 'jquery' ) );
		wp_enqueue_style( 'fruitful-stats-modal-styles', get_template_directory_uri() . '/inc/func/fruitful-stats/assets/styles/admin_styles.css' );
	}

	add_action( 'admin_footer', 'fruitful_admin_modal' );
	function fruitful_admin_modal() {
		$options = fruitful_get_theme_options();
		if ( $options['ffc_is_hide_subscribe_notification'] === 'off' ) {
			require get_template_directory(). '/inc/func/fruitful-stats/view/send-statistics-modal-view.php';
		}
	}

	add_action( 'wp_ajax_fruitful_submit_modal', 'fruitful_submit_modal' );
	function fruitful_submit_modal() {

		$options = fruitful_get_theme_options();
		$request_data = $_POST['data'];

		$response = array(
			'status'            => 'failed',
			'title'             => __( 'Uh oh!', 'fruitful' ),
			'error_message'     => __( 'Sorry, something went wrong, and we failed to receive the shared data from you.', 'fruitful' ),
			'error_description' => __( 'No worries; go to the theme option to enter the required data manually and save changes.', 'fruitful' ),
			'stat_msg'          => '',
			'subscr_msg'        => ''
		);


		if ( ! empty( $request_data ) ) {
			foreach ( $request_data as $option => $value ) {
				if ( isset( $options[ $option ] ) ) {
					$options[$option] = $value;
				}
			}
			$options['ffc_is_hide_subscribe_notification'] = 'on';
			update_option('fruitful_theme_options', $options);

			if ( $request_data['ffc_statistic'] === 'on' || $request_data['ffc_subscribe'] === 'on' ) {
				$response = array(
					'status'            => 'success',
					'title'             => __( 'Thank you!', 'fruitful' ),
					'error_message'     => '',
					'error_description' => '',
					'stat_msg'          => __( 'Thank you for being supportive, we appreciate your understanding and assistance!', 'fruitful' ),
					'subscr_msg'        => $request_data['ffc_subscribe'] === 'on' ? __( "Don't forget to check your inbox for our latest letter - you’d like that!", 'fruitful' ) : ''
				);
			} else {
				$response = array(
					'status'            => 'success',
					'title'             => __( 'What a pity!', 'fruitful' ),
					'error_message'     => '',
					'error_description' => '',
					'stat_msg'          => __( 'We wish you could have shared your site statistic and joined our community.', 'fruitful' ),
					'subscr_msg'        => __( 'But if you ever change your mind, you can always do that in the theme options.', 'fruitful' )
				);
			}
		}

		wp_send_json( $response );
	}

	add_action( 'wp_ajax_fruitful_dismiss_subscribe_notification', 'fruitful_dismiss_subscribe_notification' );
	function fruitful_dismiss_subscribe_notification() {
		$options = fruitful_get_theme_options();
		$options['ffc_is_hide_subscribe_notification'] = 'on';
		update_option('fruitful_theme_options', $options);
		wp_send_json('success');
	}

