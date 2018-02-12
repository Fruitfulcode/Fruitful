<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$template = strtolower(get_option( 'template' ));
$woo_sidebar = fruitful_get_woo_sidebar();

switch( $template ) {
	case 'twentyeleven' :
    case 'twentyeleven' :
        echo '<div id="primary"><div id="content" role="main" class="twentyeleven">';
        break;
    case 'twentytwelve' :
        echo '<div id="primary" class="site-content"><div id="content" role="main" class="twentytwelve">';
        break;
    case 'twentythirteen' :
        echo '<div id="primary" class="site-content"><div id="content" role="main" class="entry-content twentythirteen">';
        break;
    case 'twentyfourteen' :
        echo '<div id="primary" class="content-area"><div id="content" role="main" class="site-content twentyfourteen"><div class="tfwc">';
        break;
    case 'twentyfifteen' :
        echo '<div id="primary" role="main" class="content-area twentyfifteen"><div id="main" class="site-main t15wc">';
        break;
    case 'twentysixteen' :
        echo '<div id="primary" class="content-area twentysixteen"><main id="main" class="site-main" role="main">';
        break;
	case 'fruitful' :
	    $theme_options = fruitful_get_theme_options();
		$prod_num_row_class = '';
		if (is_shop() || is_product_category() || is_tax('product_tag')) {
			if (!empty($theme_options['shop_num_row'])){
				$prod_num_row = $theme_options['shop_num_row'];
				$prod_num_row_class = 'prod_num_row-'.$prod_num_row;
			}
		}		

		if ($woo_sidebar == 1 || $woo_sidebar == 4 || $woo_sidebar == 5){
			echo '<div class="woo-loop-content alpha omega '.$prod_num_row_class.'"><div id="container"><div id="content" role="main">';
		} elseif($woo_sidebar == 2) {
			echo '<div class="eleven columns woo-loop-content omega '.$prod_num_row_class.'"><div id="container"><div id="content" role="main">';
		} else {
			echo '<div class="eleven columns woo-loop-content alpha '.$prod_num_row_class.'"><div id="container"><div id="content" role="main">';
		}		

		break;
    default :
        echo '<div id="container"><div id="content" role="main">';
        break;
}