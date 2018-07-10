# Sending statistics for Fruitful Code Products

This module use general option "ffc_statistics_option" for all [![Fruitful Code](https://fruitfulcode.com/wp-content/uploads/2018/07/favicon_trpr16x16.png)](https://fruitfulcode.com) [Fruitful Code](https://fruitfulcode.com) [products](https://fruitfulcode.com/products/).

## This option include:

- ffc_statistics_option['ffc_statistic'] - flag for allow send statistics to Fruitful Code. Values: 1 - allow; 0 - disallow;
- ffc_statistics_option['ffc_subscribe'] - flag for allow subscribe to the Fruitful Code newsletters. Values: 1 - allow; 0 - disallow;
- ffc_statistics_option['ffc_subscribe_name'] - Name for subscribe to the Fruitful Code newsletters.
- ffc_statistics_option['ffc_subscribe_email'] - Email for subscribe to the Fruitful Code newsletters.



## General sending statistics hooks for all Fruitfulcode products:

action: fruitful_send_stats


Fuctions to customize:

- product_stats_settings_update
- general_stats_option_update
