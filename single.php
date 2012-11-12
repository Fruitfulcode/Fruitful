<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Fruitful theme
 * @since Fruitful theme 1.0
 */

get_header(); ?>
		
		<header class="entry-header">
			<h1 class="entry-title">Blog</h1>
		</header><!-- .entry-header -->
		
		<div class="eleven columns alpha">
			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

				<?php fruitful_content_nav( 'nav-above' ); ?>
				<?php get_template_part( 'content', 'single' ); ?>
				<?php fruitful_content_nav( 'nav-below' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template( '', true );
				?>

			<?php endwhile; // end of the loop. ?>

				</div><!-- #content .site-content -->
			</div><!-- #primary .content-area -->
		</div>
		<div class="five columns omega">
			<?php get_sidebar('blogright'); ?>
		</div>
<?php get_footer(); ?>