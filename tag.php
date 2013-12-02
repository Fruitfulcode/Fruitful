<?php
/**
 * @package WordPress
 * @subpackage Fruitful theme
 * @since Fruitful theme 1.0
 */

get_header(); ?>

	<header class="archive-header">
		<h1 class="archive-title"><?php printf( __( 'Tag Archives: %s', 'fruitful' ), single_tag_title( '', false ) ); ?></h1>

		<?php if ( tag_description() ) : // Show an optional tag description ?>
		<div class="archive-meta"><?php echo tag_description(); ?></div>
		<?php endif; ?>
	</header><!-- .archive-header -->
				
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
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>
			</div><!-- #content -->
		</div><!-- #primary -->
	</div>

	<div class="five columns omega">
		<?php get_sidebar('Main Sidebar'); ?>
	</div>	
<?php get_footer(); ?>