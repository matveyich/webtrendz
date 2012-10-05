<?php 
/*
Template Name: Poker reviews
*/
get_header(); ?>
<!-- MAIN NAVIGATION -->
<div id="ja-mainnav" class="wrap">
  <div class="main">
    <div class="inner clearfix">
    <ul id="ja-cssmenu" class="clearfix">
<?php if (is_home()) { ?>
            <li class="current_page_item"><a href="<?php echo get_option('home'); ?>">Home</a></li>
        <?php } else { ?>
            <li><a href="<?php echo get_option('home'); ?>">Home</a></li>
        <?php } ?>
        <?php wp_list_pages('exclude_tree=296&title_li=&depth=2&sort_column=menu_order'); ?>
</ul>



   </div>
  </div>
</div>
<!-- //MAIN NAVIGATION -->

<!-- TOP SPOTLIGHT -->
<div id="ja-topsl" style="height:1px;" class="wrap">
  <div class="main">
    <div class="inner clearfix">
    </div>
  </div>
</div>
<!-- //TOP SPOTLIGHT -->

<!-- PATHWAY -->
<div id="ja-pathway" class="wrap">
  <div class="main">
    <div class="inner clearfix">

    <div class="ja-pathway-text">
    <?php include ( TEMPLATEPATH . '/breadcrumbs.php'); ?>

    </div>

        <div id="ja-search">
  <div class="search">
  <?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('search') ) : ?>
<?php endif; ?>
</div>
    </div>

    </div>
  </div>
</div>
<!-- //PATHWAY -->

<div id="ja-container" class="wrap clearfix">
  <div class="main"><div class="inner clearfix">

    <!-- CONTENT -->

    <div id="ja-mainbody">


      <div id="ja-current-content" class="clearfix">

<h1 class="contentheading"><?php the_title(); ?></h1>

<? if (function_exists("list_several_reviews")) list_several_reviews("Poker");?>

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
<input type="submit" value="go" name="Submit"/></p></form>

</div>
<div class="cleared"></div>


</div>

    </div>
</div>

<?php
    return;
  }
?>
<!--/password url-->
                    <?php
          //$page_id = $post->ID;
          //var_dump($page_id);
//!!MOP!!!+
          if (have_posts()) : the_post();
          the_content();
          endif;
//          $contentposted = $wpdb->get_var("SELECT post_content FROM $wpdb->posts WHERE id = $post->ID");
//          if ($contentposted) printf ("%s",$contentposted);
/*
          $sql=mysql_query('SELECT `post_content` FROM `wp_posts` WHERE `ID`="'.$post->ID.'"');

          while ($cont = mysql_fetch_array($sql, MYSQL_NUM)) {
            printf ($cont[0]);
          }
*/
//!!MOP!!!-
                    ?>
</div>

<span class="article_separator">&nbsp;</span>

      </div>
<? if (function_exists("list_several_reviews")) list_several_reviews("Poker",0,"blocks_new");?>


    </div>
    <!-- //CONTENT -->
 <!-- RIGHT COLUMN -->
            <div id="ja-colwrap">
              <div class="ja-innerpad">
					<!--block_1-->
                    <div class="moduletable_tabs" id="Mod45">
                        <div class="ja-box-ct clearfix">
                            <div class="ja-tabswrap opal" style="width: 100%;">
                                <div id="myTab-1334991908" class="container">
                                    <div class="ja-tabs-title-top" style="height: 38px;">
                                        <ul class="ja-tabs-title">
                                            <?php
                                            $sql2=mysql_query('SELECT `alttext` FROM `wp_ngg_pictures` WHERE `galleryid`=2');
                                            $tmp_path3='http://thevipgambler.com/wp-content/gallery/right-sidebar-galerry';
                                                while ($cont2 = mysql_fetch_array($sql2, MYSQL_ASSOC)) {
                                                    printf ('<li class="first active" title="mod_custom"><h3><span>'.$cont2["alttext"].'</span></h3></li>
                                                        ');
                                                //mysql_free_result($sql2);
                                                } ?>
                                        </ul>
                                    </div>
                                    <div style="height: 240px;" class="ja-tab-panels-top">
                                        <?php
                                        $sql3=mysql_query('SELECT `filename`,`description` FROM `wp_ngg_pictures` WHERE `galleryid`=2');
                                        while ($cont3 = mysql_fetch_array($sql3, MYSQL_ASSOC)) {
                                            printf ('<div style="left: 0px; top: 0px;" class="ja-tab-content">
                                                        <div class="ja-tab-subcontent">
                                                            <img src="'.$tmp_path3.'/'.$cont3["filename"].'" alt="" class="img-border">
                                                            <span>'.$cont3["description"].'</span>
                                                        </div>
                                                    </div>
                                                ');
                                        }?>
                                     </div>
                                </div>
                            </div>
                            <script type="text/javascript" charset="utf-8">
                                window.addEvent("load", init);
                                function init() {
                                    myTabs1 = new JATabs("myTab-1334991908", {animType:'animMoveHor',style:'opal',position:'top',width:'100%',height:'auto',mouseType:'click',duration:1000,colors:10,useAjax:false,skipAnim:false});
                                }
                                //new JATabs("myTab-1334991908", {animType:'animMoveHor',style:'opal',position:'top',width:'100%',height:'auto',mouseType:'click',duration:1000,colors:10,useAjax:false,skipAnim:false});
                             </script>
                        </div>
                    </div>
                    <!--end block_1-->


                    <div class="moduletable_blank" id="Mod51">
                        <div class="ja-box-ct clearfix">
                            <?php  if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('advertisement') ) : ?><?php  endif; ?>
                        </div>
                    </div>
                    <!--block_2-->
                    <div class="moduletable" id="Mod53">

<?php //!!!MOP!!!+ ?>
<li id="newsletter" class="widget widget_wpmemwidget">
  <h3 class="clearfix"><span class="right-bg clearfix"><span class="left-bg">Newsletter</span></span></h3>
  <div class="ja-box-ct clearfix">
  	<?php if (class_exists('ajaxNewsletter')): ?>
    <!-- place your HTML code here -->
    <?php ajaxNewsletter::newsletterForm(); ?>
    <!-- place your HTML code here -->
    <?php endif; ?>
  </div>
</li>
<?php //!!!MOP!!!- ?>
                    
					<?php  if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('right panel') ) : ?><?php  endif; ?>
                    </div>
                    <!--end block_2-->
                </div>
            </div>
            <!-- //RIGHT COLUMN -->


  </div></div>
</div>
    <!-- BOTTOM SPOTLIGHT-->

  <div id="ja-botsl" class="wrap">
    <div class="main clearfix">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer panel') ) : ?><?php endif; ?>
    </div>
    </div>
  <!-- //BOTTOM SPOTLIGHT 2 -->
<?php get_footer(); ?>