<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Fruitful theme
 * @since Fruitful theme 1.0
 */

get_header(); ?>
		<?php if (get_post_type( $post ) == 'post') { 
				
				$post_template = get_post_meta( $post->ID, 'post_sidebar_position_val', true );
				switch ($post_template) {
					case 'full_width':
							echo '<div class="sixteen columns alpha omega">';
								echo '<div id="primary" class="content-area">';
									echo '<div id="content" class="site-content" role="main">';
										while ( have_posts() ) : the_post();
											get_template_part( 'content', get_post_format() );
											fruitful_content_nav( 'nav-below' );
											if (fruitful_state_post_comment()) {
												if ( comments_open() || '0' != get_comments_number() )
													 comments_template(); 
												}
										endwhile; // end of the loop. 
									echo '</div><!-- #content .site-content -->';
								echo '</div><!-- #primary .content-area -->';
							echo '</div>';
					break;
					case 'left_side':
							echo '<div class="eleven columns omega">';
								echo '<div id="primary" class="content-area">';
									echo '<div id="content" class="site-content" role="main">';
									while ( have_posts() ) : the_post();
										get_template_part( 'content', get_post_format() );
										fruitful_content_nav( 'nav-below' );
										if (fruitful_state_post_comment()) {
											if ( comments_open() || '0' != get_comments_number() )
												 comments_template(); 
											}
									endwhile; // end of the loop.
									echo '</div><!-- #content .site-content -->';
								echo '</div><!-- #primary .content-area -->';
							echo '</div>';
							echo '<div class="five columns alpha">';
								get_sidebar('single-post');
							echo '</div>';
					break;
					case 'right_side': 
							echo '<div class="eleven columns alpha">';
								echo '<div id="primary" class="content-area">';
									echo '<div id="content" class="site-content" role="main">';
									while ( have_posts() ) : the_post();
										get_template_part( 'content', get_post_format() );
										fruitful_content_nav( 'nav-below' );
										if (fruitful_state_post_comment()) {
											if ( comments_open() || '0' != get_comments_number() )
												 comments_template(); 
											}
									endwhile; // end of the loop.
									echo '</div><!-- #content .site-content -->';
								echo '</div><!-- #primary .content-area -->';
							echo '</div>';
							echo '<div class="five columns omega">';
								get_sidebar('single-post');
							echo '</div>';
					break;	
				}
				
		} else { ?>
			<div class="eleven columns alpha">
				<div id="primary" class="content-area">
					<div id="content" class="site-content" role="main">
					<?php while ( have_posts() ) : the_post(); ?>
					<?php //fruitful_content_nav( 'nav-above' ); ?>
					<?php get_template_part( 'content', get_post_format() ); ?>
					<?php fruitful_content_nav( 'nav-below' ); ?>
					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if (fruitful_state_post_comment()) {
							if ( comments_open() || '0' != get_comments_number() )
								 comments_template(); 
							}
					?>
				<?php endwhile; // end of the loop. ?>
					</div><!-- #content .site-content -->
				</div><!-- #primary .content-area -->
			</div>
			<div class="five columns omega">
				<?php get_sidebar('single-post'); ?>
			</div>
		<?php } ?>
<?php get_footer(); ?>