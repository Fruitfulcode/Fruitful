<?php
/** 
* The Header for our theme. 
* Displays all of the <head> section and everything up till <div id="main"> 
* @package WordPress 
* @subpackage Fruitful theme 
* @since Fruitful theme 1.0 
**/
?><!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="ie ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<?php fruitful_metadevice(); ?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php fruitful_get_favicon(); ?>
<!--[if lt IE 9]><script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script><![endif]-->
<?php wp_head(); ?> 
</head>
<body <?php body_class(); ?>>
		<div id="page" class="hfeed site">	
			<div class="head-container">		
				<div class="container">			
					<div class="sixteen columns">				
						<header id="masthead" class="site-header" role="banner">					
							<hgroup>
								<?php echo fruitful_get_logo(); ?>
							</hgroup>	
							
							<?php languages_list_header(); ?>
							
							<?php if (class_exists('Woocommerce')) { ?>
								<div class="cart-button">
									<a href="<?php echo get_permalink( woocommerce_get_page_id( 'cart' ) ); ?>" class="cart-contents">
										<div class="cart_image"></div> 
										<span class="num_of_product_cart"><?php global $woocommerce;
										echo $woocommerce->cart->cart_contents_count; ?> </span>
									</a>
								</div>							
							<?php } ?>
							
							<nav role="navigation" class="site-navigation main-navigation">
								<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>					
							</nav><!-- .site-navigation .main-navigation -->				
						</header><!-- #masthead .site-header -->			
					</div>		
				</div>	
			</div>		
			<div class="container page-container">		
				<?php do_action( 'before' ); ?>		
				<div class="sixteen columns">