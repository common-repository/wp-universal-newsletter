<?php if (have_posts()): while (have_posts()) : the_post(); ?>
	
<article id="post-<?php the_ID(); ?>" <?php post_class('excerpt-version'); ?>>
    <h3><a href="<?php the_permalink();?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
    <div class="meta-info">
        <span><?php echo get_post_type();?></span>: <time><?php the_date('F d, Y');?></time> - <span><?php the_author_posts_link(); ?></span>
    </div>
<?php wp_trim_excerpt(); echo get_content(); ?>
</article>
	
<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>