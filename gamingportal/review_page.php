<?
/*
Template Name: Review page
*/
?>
<?php get_header(); ?>

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


    <div id="ja-container-f" class="wrap clearfix">
      <div class="main"><div class="inner clearfix">

        <!-- CONTENT -->
        <div id="ja-mainbody">


            <div class="article-content">

             

              <?php
              if (have_posts()) : the_post();
              the_content();
              endif;
              ?>

            </div>

            
            <span class="article_separator">&nbsp;</span>

        </div>
        <!-- //CONTENT -->


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