<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Fruitful theme
 * @since Fruitful theme 1.0
 */

get_header(); ?>
		<div class="eleven columns alpha">
			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'page' ); ?>
					<?php if (fruitful_state_page_comment()) { comments_template( '', true );  }	 ?>
				<?php endwhile; // end of the loop. ?>
				</div><!-- #content .site-content -->
			</div><!-- #primary .content-area -->
		</div>
		<?php 
			$is_sidebar = true;
			$is_sidebar = fruitful_is_woo_sidebar();
			if ($is_sidebar) {
		?>
		<div class="five columns omega">
			<?php get_sidebar('page'); ?>
		</div>	
		<?php } ?>
		
<?php get_footer(); ?>