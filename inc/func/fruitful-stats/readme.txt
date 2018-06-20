=== Sending statistics for Fruitfulcode Products ===

This module use general option "ffc_statistics_option" for all Fruitfulcode products.

This option include:

ffc_statistics_option['ffc_statistic'] - flag for allow send statistics to Fruitful Code.                           Values: 1 - allow; 0 - disallow;
ffc_statistics_option['ffc_subscribe'] - flag for allow subscribe to the Fruitful Code newsletters.                 Values: 1 - allow; 0 - disallow;
ffc_statistics_option['ffc_subscribe_name'] - Name for subscribe to the Fruitful Code newsletters.
ffc_statistics_option['ffc_subscribe_email'] - Email for subscribe to the Fruitful Code newsletters.
ffc_statistics_option['ffc_is_hide_subscribe_notification'] - flag for hidding subscribe modal notification.        Values: 1 - hide; 0 - show;
ffc_statistics_option['ffc_is_now_showing_subscribe_notification'] - flag is now showing modal notification         Values: 1 - showing; 0 - hide (used to prevent duplicate modals when use 2 or more Fruitfulcode products)
ffc_statistics_option['ffc_path_to_current_notification'] - path to Fruitfulcode product current modal notification Values: path; '' (used to prevent hiding modal, without submit it, when page refresh)


General sending statistics hooks for all Fruitfulcode products:

action: fruitful_send_stats
action: fruitful_stats_settings_update
