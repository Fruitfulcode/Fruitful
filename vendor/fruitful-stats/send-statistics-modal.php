<?php


if ( !class_exists('FruitfulStatisticModal')) {
	
	class FruitfulStatisticModal {
		
		public $data;
		
		/**
		 * Constructor
		 **/
		public function __construct( $data ) {
			
			$this->data = $data;
			
			// Add action to enqueue modal notification scripts
			add_action( 'admin_enqueue_scripts', array( $this, 'add_admin_scripts' ) );
			
			// Add action on submit modal notification
			add_action( 'wp_ajax_fruitful_statistic_submit_modal', array( $this, 'submit_modal' ) );
			
		}
		
		/**
		 * Function enqueue scripts for all admin pages
		 */
		public function add_admin_scripts() {
			if ( ! wp_script_is( 'fruitful-stats-modal', 'enqueued' ) ) {
				wp_enqueue_script( 'fruitful-stats-modal', $this->data['stats_uri'] . 'fruitful-stats/assets/js/admin_scripts.js', array( 'jquery' ) );
			}
			if ( ! wp_style_is( 'fruitful-stats-modal-styles', 'enqueued' ) ) {
				wp_enqueue_style( 'fruitful-stats-modal-styles', $this->data['stats_uri'] . 'fruitful-stats/assets/styles/admin_styles.css' );
			}
		}
		
		/**
		 * Function show modal notification
		 * And update fruitful theme settings options on first theme init
		 */
		public function admin_show_modal() {
			require $this->data['stats_path'] . 'fruitful-stats/view/send-statistics-modal-view.php';
		}
		
		/**
		 * Action on submit statistics modal notification
		 */
		public function submit_modal() {
			
			$request_data = $_POST['data'];
			
			$response = array(
				'status'            => 'failed',
				'title'             => esc_html__( 'Uh oh!', 'fruitful-stats' ),
				'error_message'     => esc_html__( 'Sorry, something went wrong, and we failed to receive the shared data from you.', 'fruitful-stats' ),
				'error_description' => esc_html__( 'No worries; go to the theme option to enter the required data manually and save changes.', 'fruitful-stats' ),
				'stat_msg'          => '',
				'subscr_msg'        => ''
			);
			
			$ffc_statistics_option = get_option( 'ffc_statistics_option' );
			
			if ( ! empty( $request_data ) ) {
				foreach ( $request_data as $option => $value ) {
					
					if ( $option === 'ffc_statistic' || $option === 'ffc_subscribe' ) {
						$ffc_statistics_option[ $option ] = (int) $value;
					} elseif ( $option === 'ffc_subscribe_name' ) {
						$ffc_statistics_option[ $option ] = sanitize_text_field( $value );
					} elseif ( $option === 'ffc_subscribe_email' ) {
						$ffc_statistics_option[ $option ] = sanitize_email( $value );
					} else {
						$ffc_statistics_option[ $option ] = $value;
					}
				}
				update_option( 'ffc_statistics_option', $ffc_statistics_option );
				
				if ( $ffc_statistics_option['ffc_statistic'] === 1 || $ffc_statistics_option['ffc_subscribe'] === 1 ) {
					$response = array(
						'status'            => 'success',
						'title'             => esc_html__( 'Thank you!', 'fruitful-stats' ),
						'error_message'     => '',
						'error_description' => '',
						'stat_msg'          => $ffc_statistics_option['ffc_statistic'] === 1 ? esc_html__( 'Thank you for being supportive, we appreciate your understanding and assistance!', 'fruitful-stats' ) : '',
						'subscr_msg'        => $ffc_statistics_option['ffc_subscribe'] === 1 ? esc_html__( 'Don\'t forget to check your inbox for our latest letter - you\'ll like that!', 'fruitful-stats' ) : '',
					);
				} else {
					$response = array(
						'status'            => 'success',
						'title'             => esc_html__( 'What a pity!', 'fruitful-stats' ),
						'error_message'     => '',
						'error_description' => '',
						'stat_msg'          => esc_html__( 'We wish you could have shared your site anonymous technical data and joined our community.', 'fruitful-stats' ),
						'subscr_msg'        => esc_html__( 'But if you ever change your mind, you can always do that in the theme options.', 'fruitful-stats' )
					);
				}
			}
			
			wp_send_json( $response );
		}
		
	}
}
