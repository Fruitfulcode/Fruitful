<div class="frtfl-modal modal" id="subscribe-notification-container">
	<form action="#" id="frtfl-modal-form">
		<div class="frtfl-modal__content">
			<h2><?php _e( 'Please, help us perform better!', 'dr-plastic-surgery' ); ?></h2>
			<p class="description">
				<?php _e( 'We would be happy if you assist us in becoming better. Share your site statistic to help us
                        improve our products and services. Also, don’t forget to subscribe to the Fruitful Code
                        newsletters for the latest updates!', 'dr-plastic-surgery' ); ?>
			</p>
			<div class="form-group">
				<label>
					<input type="checkbox"
					       id="modal-ffc-statistic"
					       value="1"
					       checked>
					<?php _e( 'Send statistics to Fruitful Code', 'dr-plastic-surgery' ) ?>
				</label>
			</div>

			<div class="form-group" id="modal-ffc-subscribe__wrapper">
				<label>
					<input type="checkbox"
					       id="modal-ffc-subscribe"
					       value="0">
					<?php _e( 'Subscribe to the Fruitful Code newsletters', 'dr-plastic-surgery' ) ?>
				</label>

				<div class="frtfl-modal__content_user-info hidden" id="frtfl-modal__content_user-info">
					<div class="floating-placeholder__wrapper subscribe__input_name">
						<input type="text" placeholder="Name" required disabled>
						<label><?php _e( 'Name', 'dr-plastic-surgery' ); ?>*</label>
					</div>
					<div class="floating-placeholder__wrapper subscribe__input_email">
						<input type="email" placeholder="E-mail" required disabled>
						<label><?php _e( 'E-mail', 'dr-plastic-surgery' ); ?>*</label>
					</div>
				</div>
			</div>

			<div class="form-group submit-btn__wrapper">
				<button id="frtfl-modal__submit-btn"
				        class="button button-primary"><?php _e( 'Submit', 'dr-plastic-surgery' ); ?></button>
			</div>
		</div>
		<button type="button" class="notice-dismiss"></button>
	</form>
</div>