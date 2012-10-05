<?php
/**
 * @package WordPress
 * @subpackage Refreshing
 */
get_header();
?>


    <!-- BREADCRUMBS -->
    <div id="ja-breadcrumbs" class="wrap">
      <div class="main">
        <div class="inner clearfix">
			<div class="breadcrumbs pathway">
              <?php include ( TEMPLATEPATH . '/breadcrumbs.php'); ?>
            </div>	
        </div>
      </div>
    </div>
    <!-- //BREADCRUMBS -->

    <div id="ja-container" class="wrap clearfix"><!--ja-container-->
      <div class="main">
		
		<div id="ja-mainbody" style="width: 70%;">
          <div id="ja-main">
        
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <div class="post" id="post-<?php the_ID(); ?>">
          <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
          <div class="meta">Category <?php the_category(',') ?>, Author <?php the_author() ?> - <?php the_time('M j, Y') ?></div>
          <div class="entry">
            <?php #the_content('More &raquo;'); ?>
            <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
          </div>
          <div class="comments"><?php comments_popup_link('0 comment. &raquo;', '1 comment. &raquo;', '% comment. &raquo;'); ?></div>
          <!--<div class="date"><?php the_time('M') ?><br /><?php the_time('n') ?></div>-->
        </div>

        <?php endwhile; ?>

        <div class="navigation postnavigation">
          <div class="alignleft"><?php next_posts_link('Previous') ?></div>
          <div class="alignright"><?php previous_posts_link('Next') ?></div>
        </div>

        <?php else: ?>

        <p style="padding: 10px 0 50px 0">No posts found. Please try a different search.</p>

        <?php endif; ?>
		
			</div>
		</div>
		
      <? 
	  // WTZ sidebar. finally for this site
	  // 30% width
	  //sidebar.php
	  get_sidebar();
	  ?>
		
      </div>
    </div>

    <!-- BOTTOM SPOTLIGHT-->
    <div id="ja-botsl" class="wrap">
      <div class="main clearfix">
          <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer panel') ) : ?><?php endif; ?>
      </div>
      </div>
    <!-- //BOTTOM SPOTLIGHT 2 -->

<?php get_footer(); ?>