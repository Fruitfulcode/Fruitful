<?php
/**
 * The template for displaying Author archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Fruitful theme
 * @since Fruitful theme 1.0
 */

get_header(); ?>
	<?php if ( have_posts() ) : ?>
		<?php the_post(); ?>
		<header class="archive-header">
			<h1 class="archive-title"><?php printf( __( 'All posts by %s', 'fruitful' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h1>
		</header><!-- .archive-header -->
	<?php endif; ?>
					
					
	<div class="eleven columns alpha">
		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

				<?php if ( have_posts() ) : ?>
					<?php //fruitful_content_nav('nav-above'); ?>
					<?php the_post(); ?>
					<?php rewind_posts(); ?>
					<?php if ( get_the_author_meta( 'description' ) ) : ?>
						<?php get_template_part( 'author-bio' ); ?>
					<?php endif; ?>

					<?php /* The loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>
					<?php fruitful_content_nav('nav-below'); ?>
				<?php else : ?>
					<?php get_template_part( 'content', 'none' ); ?>
				<?php endif; ?>
			</div><!-- #content -->
		</div><!-- #primary -->
	</div>

	<div class="five columns omega">
		<?php get_sidebar('blogright'); ?>
	</div>
<?php get_footer(); ?>