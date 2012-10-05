<?php 
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

if(isset($_GET['reviewid']))
{
// WTZ redirect through internal function
require_once (ABSPATH . 'wp-includes/wp-db.php');
	if (isset($_GET['download']) and $_GET['download'] == 1) {
	$result = $wpdb->get_row("SELECT urldownload FROM wp_pgrvw WHERE id = ".$_GET['reviewid']);
	header("Location: ".$result->urldownload."");	
	}
	else {
	$result = $wpdb->get_row("SELECT urlreview FROM wp_pgrvw WHERE id = ".$_GET['reviewid']);
	header("Location: ".$result->urlreview."");
	}
} else {

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
<div id="ja-topsl" class="wrap">
  <div class="main"><!--main-->
        <div class="inner clearfix">
            <div id="ja-slideshow"><!--ja-slideshow-->
        <script src="<?php bloginfo('template_url'); ?>/ja_004.js" type="text/javascript"></script>
                <script src="<?php bloginfo('template_url'); ?>/ja.js" type="text/javascript"></script>
                <div class="ja-slidewrap" id="ja-slide-44" style="visibility: visible;">
                    <div style="width: 640px; height: 300px;" class="ja-slide-main-wrap">
                        <div class="ja-slide-main">
                          <?php
              //WTZ FIX
              $ban=mysql_query('SELECT `filename`,`alttext`,`fulllink` FROM `wp_ngg_pictures` WHERE `galleryid`=3');
              $tmp_path=$_SERVER['DOCUMENT_ROOT'];
              $tmp_path2='http://thevipgambler.com/wp-content/gallery/banner-image';
              $flink = "urls:[";
                while ($cont = mysql_fetch_array($ban, MYSQL_ASSOC)) {
                    printf ('<div style="width: 640px; height: 300px; position: absolute; left: 0px; top: 0px; display: none; visibility: hidden; opacity: 0; z-index: 9;" class="ja-slide-item"><a href="'.$cont[fulllink].'" target="_blank"><img style="width: 640px; height: 300px;" src="'.$tmp_path2.'/'.$cont["filename"].'" alt="'.$cont["alttext"].'" /></a></div>');
                    $flink .= "'$cont[fulllink]',";
                }
              $flink .= "],";
                //mysql_free_result($ban);
              // WTZ FIX END
              ?>
                        </div>
                        <div style="display: block; position: absolute; top: 0px; left: 0px; width: 640px; height: 300px; visibility: visible; opacity: 0.01;" class="maskDesc">
                        <div class="inner"><a href="#" class="readon" title=""><span>Readmore</span></a></div>
                            <?php
              //WTZ FIX
              $ban2=mysql_query('SELECT `alttext`,`description` FROM `wp_ngg_pictures` WHERE `galleryid`=3');
                while ($cont2 = mysql_fetch_array($ban2, MYSQL_ASSOC)) {
                  printf ('<div class="ja-slide-desc"><h3>'.$cont2["alttext"].'</h3><br /><p>'.$cont2["description"].'</p></div>');
                }
                //mysql_free_result($ban);
              // WTZ FIX END
              ?>
                        </div>
                    </div>
                    <div class="ja-slide-descs"></div>
                    <div class="ja-slide-mask"></div>
                    <div style="min-width: 42px; height: 42px;" class="ja-slide-thumbs-wrap">
                      <div style="left: 0px;" class="ja-slide-thumbs">
                           <?php
              //WTZ FIX
              $tmp_path3='http://thevipgambler.com/wp-content/gallery/banner-image/thumbs';
              $ban3=mysql_query('SELECT `filename`,`alttext`,`description` FROM `wp_ngg_pictures` WHERE `galleryid`=3');
                $thumbcount = 0;
				while ($cont3 = mysql_fetch_array($ban3, MYSQL_ASSOC)) {
                  printf ('<div style="width: 42px; height: 42px;" class="ja-slide-thumb">
                                <img src="'.$tmp_path3.'/thumbs_'.$cont3["filename"].'" alt="'.$cont3["alttext"].'" />
                             </div>');
                $thumbcount++;// counting number of thumbs to display in JS (showItem parameter)
				}
                //mysql_free_result($ban);
              // WTZ FIX END
              ?>
                      </div>
                        <div style="left: -2000px; width: 5000px;" class="ja-slide-thumbs-mask">
                          <span style="height: 42px; width: 2000px; visibility: visible; opacity: 0.8;" class="ja-slide-thumbs-mask-left">&nbsp;</span>
                            <span style="height: 42px; width: 42px; visibility: visible; opacity: 0.8;" class="ja-slide-thumbs-mask-center">&nbsp;</span>
                            <span style="height: 42px; width: 2000px; visibility: visible; opacity: 0.8;" class="ja-slide-thumbs-mask-right">&nbsp;</span>
                            <span style="height: 42px; width: 42px; visibility: visible; opacity: 0.8;" class="ja-slide-thumbs-mask-right">&nbsp;</span>
                            <span style="height: 42px; width: 2000px; visibility: visible; opacity: 0.8;" class="ja-slide-thumbs-mask-left">&nbsp;</span>
                            <span style="height: 42px; width: 42px; visibility: visible; opacity: 0.8;" class="ja-slide-thumbs-mask-center">&nbsp;</span>
                            <span style="height: 42px; width: 2000px; visibility: visible; opacity: 0.8;" class="ja-slide-thumbs-mask-right">&nbsp;</span>
                            <span style="height: 42px; width: 42px; visibility: visible; opacity: 0.8;" class="ja-slide-thumbs-mask-right">&nbsp;</span>
                            <span style="height: 42px; width: 2000px; visibility: visible; opacity: 0.8;" class="ja-slide-thumbs-mask-right">&nbsp;</span>
                            <span style="height: 42px; width: 42px; visibility: visible; opacity: 0.8;" class="ja-slide-thumbs-mask-right">&nbsp;</span>

                        </div>
                        <p style="left: 0px;" class="ja-slide-thumbs-handles">
                          <span class="" style="width: 42px; height: 42px;">&nbsp;</span>
                          <span class="" style="width: 42px; height: 42px;">&nbsp;</span>
                          <span class="" style="width: 42px; height: 42px;">&nbsp;</span>
                          <span class="" style="width: 42px; height: 42px;">&nbsp;</span>
                          <span class="" style="width: 42px; height: 42px;">&nbsp;</span>
                          <span class="" style="width: 42px; height: 42px;">&nbsp;</span>
                          <span class="" style="width: 42px; height: 42px;">&nbsp;</span>
                          <span class="" style="width: 42px; height: 42px;">&nbsp;</span>
						  <span class="" style="width: 42px; height: 42px;">&nbsp;</span>
                          <span class="active" style="width: 42px; height: 42px;">&nbsp;</span>
                        </p>
                    </div>
                </div>
                <script type="text/javascript">
              window.addEvent('load', function(){
                new JASlideshow2('ja-slide-44', {
                            startItem: 0,
                            showItem: <?echo $thumbcount;?>,
                            itemWidth: 42,
                            itemHeight: 42,
                            mainWidth: 640,
                            mainHeight: 300,
                            duration: 300,
                            transition: Fx.Transitions.quadOut,
                            animation: 'fade',
                            thumbOpacity:0.8,
                            maskOpacity: 0.8,
                            buttonOpacity: 0.6,
                            showDesc: 'desc-readmore',
                            descMode: 'mouseover',
                            readmoretext: 'Readmore',
                            overlap: 0,
                            navigation:'thumbs',
                            <?php echo $flink ?>
                                            autoPlay: 1,
                                            interval: 7000              });
              });
            </script>
      </div><!--/ja-slideshow-->
        <div id="ja-hl">
                <div class="moduletable" id="Mod25">
                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('highlight module') ) : ?><?php endif; ?>
                </div>
        </div>
      </div>
  </div><!--/main-->
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
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('search') ) : ?><?php endif; ?>
        </div>
        </div>
      </div>
  </div>
</div>
<!-- //PATHWAY -->

<div id="ja-container" class="wrap clearfix"><!--ja-container-->
  <div class="main">
      <div class="inner clearfix">
      <!-- CONTENT -->
        <div id="ja-mainbody"><!--ja-mainbody-->
        <div id="ja-current-content" class="clearfix"><!--ja-current-content-->
            <div id="ja-contentheading"><!--ja-contentheading-->
                        <h3 class="componentheading clearfix"><span class="right-bg clearfix"><span class="left-bg">Home Page</span></span></h3>
                        <div class="blog"><!--blog-->
                            <div class="leading">
                                <div class="contentpaneopen clearfix">
                                    <div class="article-content">
                                        <div class="ja-innerpad">
                                        <?php if ( !function_exists('dynamic_sidebar')
                                        || !dynamic_sidebar('top post') ) : ?>
                                        <?php endif; ?>
                                        <!--this is content big post-->
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="leading" style="border: 0px;">
                                <div class="contentpaneopen clearfix">
                                    <div class="article-content">
                                        <div class="ja-innerpad">
<?
if ( function_exists('list_reviews')) list_reviews();
?>
                                        <!--this is content featured reviews-->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="article_row clearfix">
                                <div class="art-contentLayout">
                                    <div class="art-content"><!--art-content-->
<?php 
$show_posts = false; // WTZ we don't want to show posts
if (have_posts() && $show_posts==true) : 
?>										
                                        <?php while (have_posts()) : the_post(); ?>
                                        <div class="article_column column1 cols3">
                                                <div class="contentpaneopen clearfix">
                                                    <div class="article-content">
                                                        <div class="ja-innerpad">
                                                            <div class="img-desc clearfix">
                                                                <?php the_post_thumbnail('medium'); ?>
                                                            </div>
                                                            <h2 class="contentheading"><a href="<?php the_permalink() ?>" class="contentpagetitle" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'kubrick'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
        <?php $icons = array(); ?>
        <?php if (!is_page()): ?><?php ob_start(); ?><?php the_time(__('F jS, Y', 'kubrick')) ?>
        <?php $icons[] = ob_get_clean(); ?><?php endif; ?><?php if (!is_page()): ?><?php ob_start(); ?><?php _e('Author', 'kubrick'); ?>: <span><?php the_author() ?></span>
        <?php $icons[] = ob_get_clean(); ?><?php endif; ?><?php if (current_user_can('edit_post', $post->ID)): ?><?php ob_start(); ?><?php edit_post_link(__('Edit', 'kubrick'), ''); ?>
        <?php $icons[] = ob_get_clean(); ?><?php endif; ?><?php if (0 != count($icons)): ?>
                                                            <div class="article-toolswrap">
                                                                <div class="article-tools">
                                                                    <div class="article-meta">
                                                                        <span class="createdate"><?php echo implode(' | ', $icons); ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
        <?php endif; ?>
                                                            <div class="art-PostContent">
                                                            <?php if (is_search()) the_excerpt(); else the_excerpt_reloaded(25, '<img>', 'content_rss', FALSE); ?>
                                                            </div>
                                                            <div class="cleared"></div>
        <?php $icons = array(); ?>
        <?php if (!is_page()): ?><?php ob_start(); ?><?php printf(__('Posted in %s', 'kubrick'), get_the_category_list(', ')); ?>
        <a href="<?php the_permalink() ?>" class="readon" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'kubrick'), the_title_attribute('echo=0')); ?>">Read more...</a>
        <?php $icons[] = ob_get_clean(); ?><?php endif; ?><?php if (!is_page() && get_the_tags()): ?><?php ob_start(); ?><?php the_tags(__('Tags:', 'kubrick') . ' ', ', ', ' '); ?>
        <?php $icons[] = ob_get_clean(); ?><?php endif; ?><?php if (!is_page() && !is_single()): ?><?php ob_start(); ?><?php comments_popup_link(__('No Comments &#187;', 'kubrick'), __('1 Comment &#187;', 'kubrick'), __('% Comments &#187;', 'kubrick'), '', __('Comments Closed', 'kubrick') ); ?>
        <?php $icons[] = ob_get_clean(); ?><?php endif; ?><?php if (0 != count($icons)): ?>
        <a href="<?php the_permalink() ?>" class="readon" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'kubrick'), the_title_attribute('echo=0')); ?>">Read more...</a>
        <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
        <?php $prev_link = get_previous_posts_link(__('Newer Entries &raquo;', 'kubrick'));
        $next_link = get_next_posts_link(__('&laquo; Older Entries', 'kubrick')); ?>
        <?php if ($prev_link || $next_link): ?>
                                        <div class="art-Post">
                                            <div class="art-Post-body">
                                                <div class="art-Post-inner art-article">
                                                    <div class="art-PostContent">
                                                        <div class="navigation">
                                                            <div class="alignleft"><?php echo $next_link; ?></div>
                                                            <div class="alignright"><?php echo $prev_link; ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="cleared"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <?php else : ?>
                                         <?php 
										 if(function_exists('get_search_form') && $show_posts==true) 
										 {
										 get_search_form(); ?>
										<h2 class="center"><?php _e('Not Found', 'kubrick'); ?></h2>
                                        <p class="center"><?php _e('Sorry, but you are looking for something that isn&#8217;t here.', 'kubrick'); ?></p>
										<? }?>
                                        <?php endif; ?>
                                        <span class="article_separator">&nbsp;</span>
                                        <span class="row_separator">&nbsp;</span>
                                    </div><!--/art-content-->
                                </div>
                            </div>
                        </div><!--/blog-->
                        <div id="ja-news"><!-- JA NEWS -->
                            <div class="moduletable" id="Mod57">
                            <h3 class="clearfix">
                                <span class="right-bg clearfix"><span class="left-bg">Video</span></span>
                            </h3>
                            <div class="ja-box-ct clearfix">
                            <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/ja_002.js"></script>
                                <div id="jazin-wrap">
                                    <div id="jazin" class="clearfix">
                                        <div class="jazin-left" style="width: 99.90%;"><!--start categories-->
                                        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Video') ) : ?><?php endif; ?>
                                        </div><!--/end categories-->
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div><!-- //JA NEWS -->
                        <div id="ja-cs"><!-- JA CONTENT SLIDER -->
                            <div class="clearfix"><!--clearfix-->
                                <div class="moduletable" id="Mod56">
                                    <h3 class="clearfix"><span class="right-bg clearfix"><span class="left-bg">Latest photo</span></span></h3>
                                    <div class="ja-box-ct clearfix">
                                    <script type="text/javascript">
                        //<!--[CDATA[
                        var jscontentslider = null;
                        //]]-->
                     </script>
                     <script type="text/javascript">
                    //<!--[CDATA[
                function contentSliderInit () {
                    var options={
                        w: 155,
                        h: 150,
                        num_elem: 4,
                        mode: 'horizontal', //horizontal or vertical
                        direction: 'left', //horizontal: left or right; vertical: up or down
                        total: 5,
                        url: 'http://templates.joomlart.com/ja_opal/modules/mod_ja_contentslide/mod_ja_contentslide.php',
                        wrapper: 'ja-contentslider-center',
                        duration: 1000,
                        interval: 5000,
                        modid: 56,
                        running: false,
                        auto: 0     };

                    jscontentslider = new JS_ContentSlider(options);
                    elems = $('ja-contentslider-center').getElementsByClassName ('content_element');
                    for(i=0;i<elems.length;i++){
                        jscontentslider.update (elems[i].innerHTML, i);
                    }

                    jscontentslider.setPos(null);
                    if(jscontentslider.options.auto){
                        jscontentslider.nextRun();
                    }

                                    $("ja-contentslide-left-img").onmouseover = function(){setDirection('left',0);};
                        $("ja-contentslide-left-img").onmouseout = function(){setDirection('left',1);};
                        $("ja-contentslide-right-img").onmouseover = function(){setDirection('right',0);};
                        $("ja-contentslide-right-img").onmouseout = function(){setDirection('right',1);};

                }

                window.addEvent( 'load', contentSliderInit );

                // window.addEvent( 'load', contentSliderInit);

                function setDirection(direction,ret){
                    jscontentslider.options.direction = direction;
                    if(ret){
                    //  $('ja-contentslide-'+direction+'-img').src = 'http://templates.joomlart.com/ja_opal/templates/ja_opal/images/re-'+direction+'.gif';
                        jscontentslider.options.interval = 5000;
                        jscontentslider.options.duration = 1000;
                        jscontentslider.options.auto = 0;
                        jscontentslider.nextRun();
                    }
                    else{
                ///   $('ja-contentslide-'+direction+'-img').src = 'http://templates.joomlart.com/ja_opal/templates/ja_opal/images/re-'+direction+'-hover.gif';
                        jscontentslider.options.interval = 500;
                        jscontentslider.options.duration = 500;
                        jscontentslider.options.auto = 1;
                        jscontentslider.nextRun();
                    }
                }
                //]]-->
             </script>
                                        <div id="ja-contentslider" class="clearfix">
                                            <div id="ja-contentslider-left" style="height: 150px; line-height: 150px;">
                                                <img id="ja-contentslide-left-img" src="<?php bloginfo('template_url'); ?>/re-left.gif" alt="left direction" title="left direction" />
                                            </div>
                                            <div id="ja-contentslider-center-wrap" class="clearfix">
                                                <div style="overflow: hidden; position: relative; width: 620px; height: 150px;" id="ja-contentslider-center">
                                                <?php
                                                //WTZ FIX
                                                $sql=mysql_query('SELECT `filename`,`alttext`,`description` FROM `wp_ngg_pictures` WHERE `galleryid`=1');
                                                $tmp_path=$_SERVER['DOCUMENT_ROOT'];
                                                $tmp_path2='http://thevipgambler.com/wp-content/gallery/gallery';
                                                    while ($cont = mysql_fetch_array($sql, MYSQL_ASSOC)) {
                                                        printf ('<div style="width: 155px; height: 150px;" class="content_element">
                                                        <div class="ja_slidetitle"><span>'.$cont["alttext"].'</span></div>
                                                        <div class="ja_slideimages clearfix">
                                                            <div style="float: left; width: 130px;" class="img_caption left">
                                                                <img src="'.$tmp_path2.'/'.$cont["filename"].'" alt="Sample image" title="" class="caption" width="130" align="left" height="90" />
                                                                <p>'.$cont["description"].'</p>
                                                            </div>
                                                         </div>
                                                    </div>');
                                                    }
                                                    mysql_free_result($sql);
                                                // WTZ FIX END
                                                ?>
                                                </div>
                                            </div>
                                            <div id="ja-contentslider-right" style="height: 150px; line-height: 150px;">
                                                <img id="ja-contentslide-right-img" src="<?php bloginfo('template_url'); ?>/re-right.gif" alt="" title="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!--/clearfix-->
                        </div><!-- //JA CONTENT SLIDER -->
          </div><!--/ja-contentheading-->
        </div><!--/ja-current-content-->
            </div><!--/ja-mainbody-->
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

				<?php  if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('right panel') ) : ?><?php  endif; ?>
                    </div>
                    <!--end block_2-->
                </div>
            </div>
            <!-- //RIGHT COLUMN -->
    </div>
  </div>
</div><!--/ja-container-->

<!-- BOTTOM SPOTLIGHT-->
<div id="ja-botsl" class="wrap">
  <div class="main clearfix">
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer panel') ) : ?><?php endif; ?>
        <?php wp_list_pages('include=88&title_li=&depth=2&sort_column=menu_order'); ?>
  </div>
</div>
<!-- //BOTTOM SPOTLIGHT 2 -->
<?php get_footer(); 
}
?>