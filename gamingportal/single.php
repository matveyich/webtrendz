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
      <div class="main"><!--main-->
        <div class="inner clearfix">

          <!-- CONTENT -->
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>				  
          <div id="ja-mainbody" style="width: 70%;">
            <div id="ja-current-content" class="clearfix">
              <h2 class="contentheading"><?php the_title(); ?></h2>
              <div class="article-toolswrap">
                <div class="article-tools clearfix">
                  <div class="article-meta">
                    <span class="createdate"><?php $date_p = $post->post_date; echo $date_p; ?></span>
                    <span class="createby"></span>
                  </div>
                  <div class="buttonheading"></div>
                </div>
              </div>
              <div class="article-content"><!--article-content-->
                <div class="art-contentLayout"><!--art-contentLayout-->
                  <div class="art-content"><!--art-content-->
                    <?php
                      /*$sql=mysql_query('SELECT `post_content` FROM `wp_posts` WHERE `ID`="'.$post->ID.'"');
                        while ($cont = mysql_fetch_array($sql, MYSQL_NUM)) {
                          printf ($cont[0]);
                        }*/
						the_content();
                        ?>

                  </div><!--/art-content-->
                </div><!--/art-contentLayout-->
              </div><!--/article-content-->
              <div class="cleared"></div>
			  <?php comments_template(); ?>
              <span class="article_separator">&nbsp;</span>
            </div>
          </div>
	<?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>	          
		  <!-- //CONTENT -->
		  
      <? 
	  // WTZ sidebar. finally for this site
	  // 30% width
	  //sidebar.php
	  get_sidebar();
	  ?>
	  
        </div>
      </div><!--/main-->
    </div>

    <!-- BOTTOM SPOTLIGHT-->
    <div id="ja-botsl" class="wrap">
      <div class="main clearfix">
          <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer panel') ) : ?><?php endif; ?>
      </div>
      </div>
    <!-- //BOTTOM SPOTLIGHT 2 -->

<?php get_footer(); ?>