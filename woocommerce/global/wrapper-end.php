<?php
/**
 * Content wrappers
 *
 * @author 		Fruitful
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */


$template    = strtolower(get_option( 'template' ));
$woo_sidebar = fruitful_get_woo_sidebar();

switch( $template ) {
	case 'twentyeleven' :
		echo '</div></div>';
		break;
	case 'twentytwelve' :
		echo '</div></div>';
		break;
	case 'twentythirteen' :
		echo '</div></div>';
		break;
	case 'twentyfourteen' :
		echo '</div></div></div>';
		get_sidebar( 'content' );
		break;
	case 'fruitful' :
		$theme_options = fruitful_get_theme_options();
		$curr_template = esc_attr($theme_options['layout_tag_templ']);	
		
		if (is_tax('product_tag')) {
			if ($curr_template == 0) { 
				return false;
			} else if ($curr_template == 1) { 
				echo '</div></div></div>';
				echo '<div class="five columns alpha woo-loop-sidebar">';
						get_sidebar( 'shop' );
				echo '</div>';
			} else if ($curr_template == 2) {
				echo '</div></div></div>';
				echo '<div class="five columns omega woo-loop-sidebar">';
						get_sidebar( 'shop' );
				echo '</div>';
			}
		}		
		else {
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
		}
		break;
	default :
		echo '</div></div>';
		break;
}