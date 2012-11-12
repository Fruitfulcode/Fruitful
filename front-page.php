<?php get_header(); ?>
		<div class="content">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; // end of the loop. ?>
		</div>	
<?php get_footer(); ?>