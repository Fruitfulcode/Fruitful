(function () {
    "use strict";

    // 	Allow Subscribe for news
    jQuery(document).ready(function () {
        var modalContainer = document.getElementById('subscribe-notification-container');
        if ('undefined' === typeof modalContainer || null === modalContainer) {
            return;
        }
        var statsInput = document.getElementById('modal-ffc-statistic');
        var subscribeInput = document.getElementById('modal-ffc-subscribe');
        var userInfoContainer = document.getElementById("frtfl-modal__content_user-info");

        var modalForm = document.getElementById("frtfl-modal-form");
        var submitBtn = document.getElementById("frtfl-modal__submit-btn");
        var modalData = {};

        modalContainer.addEventListener("click", function (e) {

            //Subscribe checkbox event. If checked show additional inputs
            if (e.target === subscribeInput) {
                userInfoContainer.classList.toggle("hidden");
                if (userInfoContainer.classList.contains("hidden")) {
                    userInfoContainer.querySelector('input[type="email"]').setAttribute('disabled', 'true');
                    userInfoContainer.querySelector('input[type="text"]').setAttribute('disabled', 'true');
                } else {
                    userInfoContainer.querySelector('input[type="email"]').removeAttribute('disabled');
                    userInfoContainer.querySelector('input[type="text"]').removeAttribute('disabled');
                }

            }

            // Subscribe to newsletter click event - create modalData
            if (e.target === submitBtn) {
                modalData['ffc_statistic'] = (statsInput.checked) ? 'on' : 'off';
                modalData['ffc_subscribe'] = (subscribeInput.checked) ? 'on' : 'off';
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
                var data = {
                    action: "fruitful_dismiss_subscribe_notification",
                    type: "json",
                };

                jQuery.post(ajaxurl, data, function (response) {
                    modalContainer.remove();
                    location.reload();
                });
            }

        });

        modalForm.addEventListener('submit', function (e) {

            e.preventDefault();

            var __notificationText = modalForm.querySelector('.frtfl-modal__content');

            var data = {
                action: "fruitful_submit_modal",
                type: "json",
                data: modalData
            };

            jQuery.post(ajaxurl, data, function (response) {
                var __title, __statMsg, __subscrMsg, __errMsg, __errDescr;
                if (response.status === 'success'){
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

    });

    //Tweaks on theme options page
    document.addEventListener('DOMContentLoaded', function () {
        var subscribeToNewsCheckbox = document.getElementById('ffc_subscribe');
        if (typeof subscribeToNewsCheckbox === 'undefined' || subscribeToNewsCheckbox === null){
            return;
        }
        var isHideModal = document.getElementById('ffc_is_hide_subscribe_notification');

        var subscribeNameInput = document.getElementById('ffc_subscribe_name');
        var subscribeEmailInput = document.getElementById('ffc_subscribe_email');

        var nameRow = subscribeNameInput.closest('.settings-form-row');
        var emailRow = subscribeEmailInput.closest('.settings-form-row');

        isHideModal.closest('.settings-form-row').classList.add('hidden');

        console.log(subscribeToNewsCheckbox.checked);
        if (subscribeToNewsCheckbox.checked){
            nameRow.classList.remove('hidden');
            emailRow.classList.remove('hidden');
        } else {
            nameRow.classList.add('hidden');
            emailRow.classList.add('hidden');
        }

        subscribeToNewsCheckbox.addEventListener('click', function () {
            nameRow.classList.toggle('hidden');
            emailRow.classList.toggle('hidden');
        })
    });


}());


