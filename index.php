<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Fruitful theme
 * @since Fruitful theme 1.0
 */

get_header(); ?>
		<div class="eleven columns alpha">
		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">
		<?php if ( have_posts() ) : ?>
			
			<?php //fruitful_content_nav( 'nav-above' ); ?>
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>
			<?php fruitful_content_nav( 'nav-below' ); ?>
			

		<?php else : ?>
			<?php get_template_part( 'no-results', 'index' ); ?>
		<?php endif; ?>
		
			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->
	</div>
	<div class="five columns omega">
		<?php get_sidebar('blogright'); ?>
	</div>
<?php get_footer(); ?>