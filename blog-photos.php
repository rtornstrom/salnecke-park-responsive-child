<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Blog Template
 *
   Template Name: Blog Photos
 *
 * @file           blog-photos.php
 * @package        Responsive 
 * @author         Roger Törnström
 * @copyright      2013 Roger Törnström
 * @license        LICENSE
 * @version        Release: 1.0.0
 * @filesource     wp-content/themes/salnecke-park-responsive-child/blog-photos.php
 * @link           http://codex.wordpress.org/Templates
 */

get_header(); 

global $more; $more = 0; 
?>

<div id="content-blog" class="<?php echo implode( ' ', responsive_get_content_classes() ); ?>">
	
	<?php if( have_posts() ) : ?>
		
		<?php while( have_posts() ) : the_post(); ?>
			
			<?php get_template_part( 'loop-header' ); ?>
			
			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
				<?php responsive_entry_top(); ?>
				
				<?php get_template_part( 'post-meta-page' ); ?>
				
				<div class="post-entry">
					<?php the_content() ?>
					
				</div>
				
				<?php get_template_part( 'post-data' ); ?>
				
				<?php responsive_entry_bottom(); ?>
			
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>
			
	<?php
		endwhile;

		get_template_part( 'loop-nav' );

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>

	<?php 
	global $wp_query, $paged;
	if( get_query_var( 'paged' ) ) {
		$paged = get_query_var( 'paged' );
	}
	elseif( get_query_var( 'page' ) ) {
		$paged = get_query_var( 'page' );
	}
	else {
		$paged = 1;
	}
	$blog_query = new WP_Query( array( 'category__in' => array( 6 ), 'post_type' => 'post', 'paged' => $paged ) );
	$temp_query = $wp_query;
	$wp_query = null;
	$wp_query = $blog_query;

	if ( $blog_query->have_posts() ) :

			while ( $blog_query->have_posts() ) : $blog_query->the_post(); 
				?>
        
			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>       
				<?php responsive_entry_top(); ?>
					
					<?php get_template_part( 'post-meta' ); ?>
					
					<div class="post-entry">
						<?php if ( has_post_thumbnail()) : ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
						<?php the_post_thumbnail(); ?>
							</a>
						<?php endif; ?>
						<?php the_content(__('Read more &#8250;', 'responsive')); ?>
						<?php wp_link_pages(array('before' => '<div class="pagination">' . __('Pages:', 'responsive'), 'after' => '</div>')); ?>
					</div><!-- end of .post-entry -->
					
					<?php get_template_part( 'post-data' ); ?>
				               
				<?php responsive_entry_bottom(); ?>      
			</div><!-- end of #post-<?php the_ID(); ?> -->       
			<?php responsive_entry_after(); ?>
				
		<?php 
		endwhile;

        if (  $wp_query->max_num_pages > 1 ) : 
			?>
			<div class="navigation">
				<div class="previous"><?php next_posts_link( __( '&#8249; Older posts', 'responsive' ), $wp_query->max_num_pages ); ?></div>
				<div class="next"><?php previous_posts_link( __( 'Newer posts &#8250;', 'responsive' ), $wp_query->max_num_pages ); ?></div>
			</div><!-- end of .navigation -->
			<?php 
		endif;

	else : 

		get_template_part( 'loop-no-posts' ); 

	endif; 
	$wp_query = $temp_query;
	wp_reset_postdata();
	?>  
      
</div><!-- end of #content-blog -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

