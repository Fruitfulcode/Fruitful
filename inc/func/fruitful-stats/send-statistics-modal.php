<?php

class ffc_fruitful_stats_modal extends ffc_fruitful_stats
{
	/**
	 * Constructor
	 **/
	function __construct()
	{
		parent::__construct();
		$this->run();
	}

	/**
	 * Run actions for modal notification
	 **/
	function run() {

		// Add action to enqueue modal notification scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'ffc_add_admin_scripts' ) );

		// Add action to show modal notification
		add_action( 'admin_footer', array( $this, 'ffc_shortcodes_admin_notice' ) );

		// Add action on submit modal notification
		add_action( 'wp_ajax_fruitfultheme_submit_modal', array( $this, 'ffc_submit_modal' ) );

		// Add action on click close button modal notification
		add_action( 'wp_ajax_fruitfultheme_dismiss_subscribe_notification', array( $this, 'ffc_dismiss_subscribe_notification' ) );

	}

	/**
	 * Function enqueue scripts for all admin pages
	 */
	public function ffc_add_admin_scripts() {
		if(!wp_script_is( 'fruitful-stats-modal', 'enqueued' )) {
			wp_enqueue_script( 'fruitful-stats-modal', get_template_directory_uri() . '/inc/func/fruitful-stats/assets/js/admin_scripts.js', array( 'jquery' ) );
		}
		if(!wp_style_is( 'fruitful-stats-modal-styles', 'enqueued' )) {
			wp_enqueue_style( 'fruitful-stats-modal-styles', get_template_directory_uri() . '/inc/func/fruitful-stats/assets/styles/admin_styles.css' );
		}
	}

	/**
	 * Function show modal notification
	 * And update fruitful theme settings options on first theme init
	 */
	function ffc_shortcodes_admin_notice() {

		$ffc_statistics_option = get_option('ffc_statistics_option');

		//Checking is set ffc statistic option and showing modal notification if is not set
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
					// Update fruitful theme settings options if ffc statistic option set and this is first theme init
					if(get_option('fruitfultheme_stat_first_init')!='1')
					{
						do_action('fruitful_stats_settings_update');
						update_option('fruitfultheme_stat_first_init', '1');
					}
				}
			}
		}
	}

	/**
	 * Action on submit statistics modal notification
	 */
	function ffc_submit_modal() {

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
		do_action('fruitful_stats_settings_update');
		do_action('fruitful_send_stats');
		wp_send_json( $response );
	}

	/**
	 * Action click close button statistics modal notification
	 */
	function ffc_dismiss_subscribe_notification() {

		$ffc_statistics_option = get_option('ffc_statistics_option');
		$ffc_statistics_option['ffc_is_now_showing_subscribe_notification'] = '0';
		$ffc_statistics_option['ffc_is_hide_subscribe_notification'] = '1';
		$ffc_statistics_option['ffc_path_to_current_notification'] = '';
		update_option('ffc_statistics_option', $ffc_statistics_option);
		do_action('fruitful_send_stats');
		wp_send_json( 'success' );
	}
}

