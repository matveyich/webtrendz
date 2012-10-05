<?
/*
Template Name: Review page
*/
?>
<?php get_header(); ?>
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

<div id="ja-container-f" class="wrap clearfix">
  <div class="main"><div class="inner clearfix">

    <!-- CONTENT -->

    <div id="ja-mainbody">

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


<?php #$date_m = $post->post_modified_gmt; echo $date_m; ?>


<span class="article_separator">&nbsp;</span>

      

    </div>
    <!-- //CONTENT -->
</div>
</div>
</div>

  <div id="ja-botsl" class="wrap">
    <div class="main clearfix">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer panel') ) : ?><?php endif; ?>
    </div>
    </div>
  <!-- //BOTTOM SPOTLIGHT 2 -->
<?php get_footer(); ?>