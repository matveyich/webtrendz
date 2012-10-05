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


    <div id="ja-container" class="wrap clearfix">
      <div class="main"><div class="inner clearfix">

        <!-- CONTENT -->
        <div id="ja-mainbody" style="width:70%">
          <div id="ja-current-content" class="clearfix">
            <h2 class="contentheading"><?php the_title(); ?></h2>

            <div class="article-content">

              <!--password url-->
              <?php if ( post_password_required() ) { ?>
                <div class="art-Post">
                  <div class="art-Post-body">
                    <div class="art-Post-inner art-article">
                      <div class="art-PostContent">
                        <p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'kubrick'); ?></p>
                        <form method="post" action="http://thevipgambler.com/wp-pass.php">
                          <p><label for="pwbox-229">password:<br/>
                          <input type="password" size="20" id="pwbox-229" name="post_password"/></label><br/>
                          <input type="submit" value="go" name="Submit"/>
                          </p>
                        </form>
                      </div>
                      <div class="cleared"></div>
                    </div>
                  </div>
                </div>
              <?php return; } ?>
              <!--/password url-->

              <?php
              if (have_posts()) : the_post();
              the_content();
              endif;
              ?>

            </div>

      
            <span class="article_separator">&nbsp;</span>
          </div>
        </div>
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