<?
/*
Template Name: free online games tmpl
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


    <div id="ja-container" class="wrap clearfix">
      <div class="main"><div class="inner clearfix">

        <!-- CONTENT -->
        <div id="ja-mainbody" style="width:70%">
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
<?
// free online games START

/* WTZ 
this gets image gallery from header_gallery and puts it into 3 blocks
*/
// query
$query = "SELECT gid FROM ".$wpdb->nggallery." WHERE title = 'Free online games' LIMIT 0,1;";
$row = $wpdb->get_results($query); 
echo mysql_error();
if (function_exists('nggShowGallery')) echo nggShowGallery($row[0]->gid, 'buttomgal'); else echo "no nggShowGallery function";
/*WTZ */

// free online games END
?>
            <span class="modifydate">
              Last Updated (<?php $date_m = $post->post_modified_gmt; echo $date_m; ?>)
            </span>
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
    </div>
	
	<!-- overlayed element -->
<div class="simple_overlay" id="fog_overlay">

	<!-- the external content is loaded inside this tag -->
	<div class="contentWrap">
	<iframe id="dataframe" src="" frameborder=0 width=752 height=560></iframe>
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