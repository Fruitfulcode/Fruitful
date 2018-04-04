<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-end.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes/Fruitfulcode
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

$woo_sidebar = fruitful_get_woo_sidebar();

if ($woo_sidebar == 1 || $woo_sidebar == 4 || $woo_sidebar == 5) {
    echo '</div></div></div>';
} elseif($woo_sidebar == 2) {
    echo '</div></div></div>';
    echo '<div class="five columns alpha woo-loop-sidebar">';
        if (is_shop() || is_product_category()) {
            get_sidebar( 'shop' );
        } else {
            get_sidebar( 'product' );
        }
    echo '</div>';
} else {
    echo '</div></div></div>';
    echo '<div class="five columns omega woo-loop-sidebar">';
        if (is_shop() || is_product_category()){
            get_sidebar( 'shop' );
        } else {
            get_sidebar( 'product' );
        }
    echo '</div>';
}