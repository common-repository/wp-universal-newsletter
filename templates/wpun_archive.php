<?php get_header();?>
<?php
 // Uncomment these to Turn on Errors for this page
	#ini_set('display_errors','on');
	#error_reporting(E_ALL);
    //Get the Post Type Object
    $obj = get_post_type_object( get_post_type() );
    
	?>
	
    <div class="content_wrapper clear">
		<section role="main" class="main" id="scroll-container">	
		<h1><?php echo $obj->labels->name.' Archive' ?></h1>
	
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
                
            <article id="post-<?php the_ID(); ?>" <?php post_class('excerpt-version'); ?>>
                <h2><a href="<?php the_permalink();?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                <div class="meta-info">
                    <time><?php the_date('F d, Y');?></time> - <span><?php the_author_posts_link(); ?></span>
                </div>
            <?php echo wp_trim_excerpt(); ?>
            </article>
                
            <?php endwhile; ?>
            
            <?php else: ?>
            
                <!-- article -->
                <article>
                    <h2><?php _e( 'Sorry, nothing to display.' ); ?></h2>
                </article>
                <!-- /article -->
            
        <?php endif; ?>
		
		<!-- pagination -->
        <div class="pagination">
            <?php wpun_pagination(); ?>
        </div>
        <!-- /pagination -->
	
		</section>
	</div><!-- end content_wrapper -->    
<?php get_footer(); ?>