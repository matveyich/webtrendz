<?php
/**
 * @package WordPress
 * @subpackage Refreshing
 */
get_header();
?>
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
            <div class="ja-pathway-text"><div id="ja-search">
				<div class="search">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('search') ) : ?><?php endif; ?>
				</div>
  			</div>
  		</div>
	</div>
</div>
<!-- //PATHWAY -->
</div>

<div id="ja-container" class="wrap clearfix"><!--ja-container-->
  <div class="main srch">
		<div class="inner clearfix">
		<!-- CONTENT -->
        <div id="ja-mainbody"><!--ja-mainbody-->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="post" id="post-<?php the_ID(); ?>">
	<h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	<div class="meta">Category <?php the_category(',') ?>, Author <?php the_author() ?> - <?php the_time('M j, Y') ?></div>
	<div class="entry">
		<?php #the_content('More &raquo;'); ?>
		<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
	</div>
	<div class="comments"><?php comments_popup_link('0 comment. &raquo;', '1 comment. &raquo;', '% comment. &raquo;'); ?></div>
	<!--<div class="date"><?php the_time('M') ?><br /><?php the_time('n') ?></div> -->
</div>

<?php endwhile; ?>

<div class="navigation postnavigation">
	<div class="alignleft"><?php next_posts_link('Previous') ?></div>
	<div class="alignright"><?php previous_posts_link('Next') ?></div>
</div>

<?php else: ?>

<p style="padding: 10px 0 50px 0">
No posts found. Please try a different search.
</p>

<?php endif; ?>
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
			
		</div>
		
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