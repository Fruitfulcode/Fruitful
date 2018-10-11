;(function () {
	"use strict";

	// 	Allow Subscribe for news
	jQuery(document).ready(function () {
		var modalContainer = document.getElementById('subscribe-notification-container');
		if ('undefined' === typeof modalContainer || null === modalContainer) {
			return;
		}
		var statsInput = document.getElementById('modal-ffc-statistic');
		var subscribeInput = document.getElementById('modal-ffc-subscribe');
		var userInfoContainer = document.getElementById("ffst-modal__content_user-info");

		var modalForm = document.getElementById("ffst-modal-form");
		var submitBtn = document.getElementById("ffst-modal__submit-btn");
		var modalData = {};

		modalContainer.addEventListener("click", function (e) {

			//Statistics checkbox event. If checked value=1
			if (e.target === statsInput) {
				statsInput.value = statsInput.checked ?  1 : 0;
			}

			//Subscribe checkbox event. If checked show additional inputs If checked value=1
			if (e.target === subscribeInput) {
				userInfoContainer.classList.toggle("hidden");
				if (userInfoContainer.classList.contains("hidden")) {
					userInfoContainer.querySelector('input[type="email"]').setAttribute('disabled', 'true');
					userInfoContainer.querySelector('input[type="text"]').setAttribute('disabled', 'true');
				} else {
					userInfoContainer.querySelector('input[type="email"]').removeAttribute('disabled');
					userInfoContainer.querySelector('input[type="text"]').removeAttribute('disabled');
				}

				subscribeInput.value = subscribeInput.checked ?  1 : 0;

			}

			// Subscribe to newsletter click event - create modalData
			if (e.target === submitBtn) {
				modalData['ffc_statistic'] = +statsInput.checked;
				modalData['ffc_subscribe'] = +subscribeInput.checked;
				if (userInfoContainer.classList.contains("hidden")) {
					modalData['ffc_subscribe_name'] = '';
					modalData['ffc_subscribe_email'] = '';
				} else {
					modalData['ffc_subscribe_name'] = userInfoContainer.querySelector('input[type="text"]').value;
					modalData['ffc_subscribe_email'] = userInfoContainer.querySelector('input[type="email"]').value;
				}
			}

			// Dismiss subscribe notification Event
			if (e.target.classList.contains("notice-dismiss")) {
				modalContainer.remove();
			}

		});

		if(typeof modalForm !== 'undefined') {
			if (modalForm !== null ) {
				modalForm.addEventListener('submit', function (e) {

					e.preventDefault();

					var __notificationText = modalForm.querySelector('.ffst-modal__content');

					var data = {
						action: "fruitful_statistic_submit_modal",
						type: "json",
						data: modalData
					};

					jQuery.post(ajaxurl, data, function (response) {
						var __title, __statMsg, __subscrMsg, __errMsg, __errDescr;
						if (response.status === 'success') {
							__title = "<h2>" + response.title + "</h2>";
							__statMsg = "<p>" + response.stat_msg + "</p>";
							__subscrMsg = "<p>" + response.subscr_msg + "</p>";
							__errMsg = '';
							__errDescr = '';
						} else {
							__title = '';
							__statMsg = '';
							__subscrMsg = '';
							__errMsg = "<p>" + response.error_message + "</p>";
							__errDescr = "<p>" + response.error_description + "</p>";
						}
						__notificationText.innerHTML = __title + __statMsg + __subscrMsg + __errMsg + __errDescr;
					});

				});
			}
		}
	});
}());


