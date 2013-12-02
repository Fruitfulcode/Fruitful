<?php
/**
 * The template for displaying Home Page.
 *
 * @package WordPress
 * @subpackage Fruitful theme
 * @since Fruitful theme 1.0
 */

 get_header(); ?>
		<?php if (get_option('page_on_front') != 0) { 
					echo '<div class="content">';
						while ( have_posts() ) : the_post(); 
							the_content(); 
						endwhile; // end of the loop. 
					echo '</div>';
			  } else {	
					echo '<div class="eleven columns alpha">';
						echo '<div id="primary" class="content-area">';
							echo '<div id="content" class="site-content" role="main">';
					if ( have_posts() ) : 
						//fruitful_content_nav( 'nav-above' ); 
						/* Start the Loop */ 
						while ( have_posts() ) : the_post(); 
							/* Include the Post-Format-specific template for the content.
							* If you want to overload this in a child theme then include a file
							* called content-___.php (where ___ is the Post Format name) and that will be used instead.
							*/
							get_template_part( 'content', get_post_format() );
						
						endwhile;
						fruitful_content_nav( 'nav-below' ); 
					elseif ( current_user_can( 'edit_posts' ) ) : 
						get_template_part( 'no-results', 'index' ); 
					endif; 
		
			echo '</div><!-- #content .site-content -->';
		echo '</div><!-- #primary .content-area -->';
	echo '</div>';
	echo '<div class="five columns omega">';
		  get_sidebar('blogright'); 
	echo '</div>';
	} ?>
	
<?php get_footer(); ?>