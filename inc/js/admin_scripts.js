(function () {
    "use strict";

    // 	Allow Subscribe for news
    jQuery(document).ready(function () {
        var notificationContainer = document.getElementById('subscribe-notification-container');
        if ('undefined' === typeof notificationContainer || null === notificationContainer) {
            return;
        }

        notificationContainer.addEventListener("click", function (e) {

            // Subscribe to newsletter event
            if (e.target.getAttribute("id") === "subscribe-to-newsletters-btn") {
                e.preventDefault();

                var __subscribeBtn = e.target;
                var __notificationText = __subscribeBtn.parentElement;

                var data = {
                    action: "fruitful_allow_subscribe",
                    type: "json",
                };

                jQuery.post(ajaxurl, data, function (response) {
                    if (response.status === "success") {
                        __notificationText.innerHTML = response.message;
                    } else {
                        __notificationText.innerHTML = response.message;
                    }
                });
            }

            // Dismiss subscribe notification Event
            if (e.target.classList.contains("notice-dismiss")) {
                var data = {
                    action: "fruitful_dismiss_subscribe_notification",
                    type: "json",
                };

                jQuery.post(ajaxurl, data, function (response) {});

            }

        });
    });
}());


