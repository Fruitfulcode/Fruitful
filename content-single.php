<?php
/**
 * @package Fruitful theme
 * @since Fruitful theme 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog_post'); ?>>
	<?php $day 			= get_the_date('d'); 
			  $month_abr = get_the_date('M');
	?>
	<div class="date_of_post">
		<span class="day_post"><?php print $day; ?></span>
		<span class="month_post"><?php print $month_abr; ?></span>
	</div>
	<div class="post-content">	
	
	<header class="post-header">
		<h1 class="post-title"><?php the_title(); ?></h1>
		<!--<div class="entry-meta">-->
			<?php //fruitful_posted_on(); ?>
		<!--</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'fruitful' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
	 <span class="author-link"><a href="<?php print esc_url( get_author_posts_url( get_the_author_meta( 'ID' ))); ?>"><?php print get_the_author(); ?></a></span>
		<?php
			$category_list = get_the_category_list( __( ', ', 'fruitful' ) );
			$tag_list 		 = get_the_tag_list( '', ', ' );
		?>
		<span class="cat-links">
				<?php
							if (!empty($category_list)) {
								printf( __( 'Posted in %1$s', 'fruitful' ), $category_list ); 
							}	
				?>
		</span>
		<span class="tag-links">
				<?php 
						if (!empty($tag_list)) {
							printf( __( 'Tagged %1$s', 'fruitful' ), $tag_list ); 
						}	
				
				?>
		</span>
		<?php edit_post_link( __( 'Edit', 'fruitful' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
