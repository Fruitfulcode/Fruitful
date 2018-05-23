(function () {
    "use strict";

    // 	Allow Subscribe for news
    jQuery(document).ready(function () {
        var allowSubscribeBtn = document.getElementById("subscribe-to-newsletters-btn");

        if ( 'undefined' === typeof allowSubscribeBtn || null === allowSubscribeBtn) {
            return;
        }

        var notificationContainer = allowSubscribeBtn.parentElement;
        allowSubscribeBtn.addEventListener("click", function (e) {
            e.preventDefault();
            var data = {
                action: "fruitful_allow_subscribe",
                type: "json",
            };

            jQuery.post(ajaxurl, data, function (response) {
                if (response.status === "success") {
                    notificationContainer.innerHTML = response.message;
                } else{
                    notificationContainer.innerHTML = response.message;
                }
            });
        });
    });
}());


