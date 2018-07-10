=== Sending statistics for Fruitfulcode Products ===

This module use general option "ffc_statistics_option" for all Fruitfulcode products.

This option include:

ffc_statistics_option['ffc_statistic'] - flag for allow send statistics to Fruitful Code.                           Values: 1 - allow; 0 - disallow;
ffc_statistics_option['ffc_subscribe'] - flag for allow subscribe to the Fruitful Code newsletters.                 Values: 1 - allow; 0 - disallow;
ffc_statistics_option['ffc_subscribe_name'] - Name for subscribe to the Fruitful Code newsletters.
ffc_statistics_option['ffc_subscribe_email'] - Email for subscribe to the Fruitful Code newsletters.


General sending statistics hooks for all Fruitfulcode products:

action: fruitful_send_stats
action: product_stats_settings_update
