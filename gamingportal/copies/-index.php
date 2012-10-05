<?php get_header(); ?>
<?
function featured_news($what = "reviews")
{
	$args = array(
		'numberposts' => 3,
		'orderby' => 'date',
		'order' => 'DESC',
		'category_name' => 'games'
	);
	$lastposts = get_posts($args);
	if ($lastposts) {?>
	<div class="ja-zinfp-normal column clearfix">
		<div class="ja-zincontent inner clearfix first">
		<div class="featured-header">
		<h2 class="fh">
			Featured <? echo $what;?>
			</h2></div>
		<div class="featured-content">
			<div class="featured-inner-content">
	<?
	switch ($what) 
	{
	case "news":
		foreach ($lastposts as $post) {
		setup_postdata($post);
		?>
		<div class="featured-news-block">
			<div class="featured-img">
			<?php the_post_thumbnail('medium'); ?>
			</div> 
			<div class="featured-title"><h2><a href="<? echo get_permalink($post->ID);?>"><? echo $post->post_title;?></a></h2></div>
			<!--<div class="featured-meta"><? echo $post->post_date;?></div>-->
			<div class="featured-text"><? echo $post->post_content;?></div>
		</div>
		<?
		}
	break;
	case "reviews":
		list_reviews(); // from functions.php
	break;
	}
	?>		</div>
		</div>
		</div>
	</div>	
	<?
	}
}
function top_post()
{
		$args = array(
		'numberposts' => 1,
		'orderby' => 'date',
		'order' => 'DESC',
		'category_name' => 'top-post'
	);
	$lastposts = get_posts($args);
	if ($lastposts) {?>
	<div class="ja-zinfp-normal column clearfix">
		<div class="ja-zincontent inner clearfix first">
		<div class="top-content">
			<div class="top-inner-content">
	<?
		foreach ($lastposts as $post) {
		setup_postdata($post);
		#print_r($post);?>
		<div class="top-news-block">
			<div class="top-img">
			<?php the_post_thumbnail('full'); ?>
			</div> 
			<div class="top-title"><h2><a href="<? echo get_permalink($post->ID);?>"><? echo $post->post_title;?></a></h2></div>
			<!--<div class="top-meta"><? echo $post->post_date;?></div>-->
			<div class="top-text"><? echo $post->post_excerpt;?>
			</div><a href="<?php echo get_permalink($post->ID);?>" class="readon">Read more...</a>
		</div>
		<?
		}
// display two small blocks
	?>		
			<div class="two-small">
				<div class="top-small">
					<div class="top-small-heading">
						<h2><a href="#">Small top block</a></h2>
					</div>
					<div class="top-small-text">
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis, lacus non ultrices varius, dolor lectus interdum arcu, sit amet commodo tortor orci congue elit. 
					</div>
					<a href="#" class="readon">Read more...</a>
				</div>
				<div class="top-small">
					<div class="top-small-heading">
						<h2><a href="#">Small top block</a></h2>
					</div>
					<div class="top-small-text">
				Etiam ut ornare arcu. Duis non magna dolor. Vivamus ipsum dolor, auctor id facilisis sed, aliquet eu sapien.
					</div>
					<a href="#" class="readon">Read more...</a>
				</div>
			</div>
			</div>
		</div>
		</div>
	</div>	
	<?
	}
}
?>
    <!-- BREADCRUMBS -->
    <div id="ja-breadcrumbs" class="wrap">
      <div class="main">
        <div class="inner clearfix">
          <strong>You are here: </strong>
          <span class="breadcrumbs pathway">Home</span>
        </div>
      </div>
    </div>
    <!-- //BREADCRUMBS -->


    <!-- MAIN CONTAINER -->
    <div id="ja-container" class="wrap ja-r1">
      <div class="main clearfix">

        <!-- CONTENT -->
        <div id="ja-mainbody" style="width: 70%;">
          <div id="ja-main" style="width: 100%;">
            <div class="inner clearfix">

              <div id="ja-contentwrap" class="">
                <div id="ja-content" class="column" style="width: 100%;">
                  <div id="ja-current-content" class="column" style="width: 100%;">

                    <div class="ja-content-top clearfix">
                      <!--
					  <div class="ja-moduletable moduletable  clearfix" id="Mod175">
                        <div class="ja-box-ct clearfix">

                          <div class="leading">
                            <div class="contentpaneopen clearfix">
                              <div class="article-content">
                                <div class="ja-innerpad"> 
			this is content big post								
                                  <?php if ( !function_exists('dynamic_sidebar')
                                  || !dynamic_sidebar('top post') ) : ?>
                                  <?php endif; ?>
                                 
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
						-->
					</div><!--ja-content-top clearfix-->




                    <div class="ja-content-top clearfix">
                      <div class="ja-moduletable moduletable  clearfix" id="Mod75">
                        <div class="ja-box-ct clearfix">

                          <div id="ja-zinfpwrap">
                            <div id="ja-zinfp" class="clearfix">

                              <div class="ja-zinfp-block clearfix">

                                <div class="ja-zinfp-featured column clearfix">

                                </div>
<?
if (is_home()) {top_post(); featured_news();wp_reset_query();}
?>

                                <div class="ja-zinfp-normal column clearfix">
                                  <div class="ja-zincontent inner clearfix first">
<? if (is_home()) rewind_posts();?>
<?php 
$show_posts = false; // WTZ we don't want to show posts
if (have_posts() && $show_posts==true) :  ?>
                                    <?php while (have_posts()) : the_post(); ?>
                                    <? if (!in_category(array( 'top-post', 'games' ))) {
									#print_r($post);
									?>
                                    <div class="article_column column1 cols1">
                                      <div class="contentpaneopen clearfix">
                                        <div class="article-content">
                                          <div class="ja-innerpad">
                                          
											<h2 class="contentheading"><a href="<?php the_permalink() ?>" class="contentpagetitle" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'kubrick'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
                                            <?php $icons = array(); ?>
                                            <?php if (!is_page()): ?><?php ob_start(); ?><?php the_time(__('F jS, Y', 'kubrick')) ?>
                                            <?php $icons[] = ob_get_clean(); ?><?php endif; ?><?php if (!is_page()): ?><?php ob_start(); ?><?php _e('Author', 'kubrick'); ?>: <span><?php the_author() ?></span>
                                            <?php $icons[] = ob_get_clean(); ?><?php endif; ?><?php if (current_user_can('edit_post', $post->ID)): ?><?php ob_start(); ?><?php edit_post_link(__('Edit', 'kubrick'), ''); ?>
                                            <?php $icons[] = ob_get_clean(); ?><?php endif; ?><?php if (0 != count($icons)): ?>
                                            <div class="img-desc">
                                            <?php the_post_thumbnail('medium'); ?>
											</div> 
												<div class="post-text">
												<div class="article-meta">
                                                  <span class="createdate"><?php echo implode(' | ', $icons); ?></span>
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
                                    </div>
									
									<? }?>
									
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

                                  </div>

                                </div>
                              </div>

                            </div>
                          </div>
                        </div>
                      </div>
                    </div><!--ja-content-top clearfix-->

                  </div>
                </div>
              </div><!--ja-contentwrap-->

            </div>
          </div>
        </div><!--70%-->
        <!-- //CONTENT -->

        <!-- RIGHT COLUMN-->
        <div id="ja-right" class="column ja-cols sidebar" style="width: 30%;">
          <div class="ja-colswrap clearfix ja-r1">
            <div class="ja-col  column">

              <!--Show Most Read AND Latest news-->
              <div class="ja-moduletable moduletable_tabs  clearfix" id="Mod61">
                <div class="ja-box-ct clearfix">

                  <div class="ja-tabswrap seleni" style="width: 100%;">
                    <div id="myTab-1080109050" class="container">
                      <div class="ja-tabs-title-top" style="height: 30px;">
                        <ul class="ja-tabs-title">
                          <li class="first active" title="Most Read"><h3><span>Most Read</span></h3></li>
                          <li class="last" title="Latest News"><h3><span>Latest News</span></h3></li>
                        </ul>
                      </div>
                      <div style="height: 292px;" class="ja-tab-panels-top">
                        <div style="position: absolute; left: 0px; display: block;" class="ja-tab-content">
                          <div class="ja-tab-subcontent">
                            <?php if (function_exists('get_least_viewed')): ?>
                              <ul>
                                <?php get_least_viewed(); ?>
                              </ul>
                            <?php endif; ?>
                          </div>
                        </div>
                        <div style="position: absolute; left: 0px; display: none;" class="ja-tab-content">
                          <div class="ja-tab-subcontent">
                            <ul>
                              <?php wp_get_archives('type=postbypost&limit=10&format=html'); ?>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <script type="text/javascript" charset="utf-8">
                    window.addEvent("load", init);
                    function init()
                    {
                      myTabs1 = new JATabs("myTab-1080109050", {animType:'animNone',style:'seleni',position:'top',width:'100%',height:'auto',mouseType:'click',duration:1000,colors:10,useAjax:false,skipAnim:false});
                    }
                    //new JATabs("myTab-1080109050", {animType:'animNone',style:'seleni',position:'top',width:'100%',height:'auto',mouseType:'click',duration:1000,colors:10,useAjax:false,skipAnim:false});
                  </script>
                </div>
              </div>

              <div class="ja-moduletable moduletable_tabs  clearfix" id="Mod161">
                <div class="ja-box-ct clearfix">
				<li class="widget">
					<h3 class="clearfix">Newsletter</h3>
					<div class="ja-box-ct clearfix">
					<ul>
                  <?php if (class_exists('ajaxNewsletter')): ?>
                  <!-- place your HTML code here -->
                  <?php ajaxNewsletter::newsletterForm(); ?>
                  <!-- place your HTML code here -->
                  <?php endif; ?>
				  </ul>
					</div>
				</li>
                </div>
              </div>

              <div class="moduletable_blank" id="Mod51">
                <div class="ja-box-ct clearfix">
                  <?php  if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('advertisement') ) : ?><?php  endif; ?>
                </div>
              </div>

              <!--block_2-->
              <div class="ja-moduletable moduletable_tabs  clearfix" id="Mod53">
                <div class="ja-box-ct clearfix">
                  <?php  if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('right panel') ) : ?><?php  endif; ?>
                </div>
              </div>
              <!--end block_2-->

            </div>
          </div>
        </div><!--30%-->
        <!-- RIGHT COLUMN-->


      </div>
    </div>
    <!-- //MAIN CONTAINER -->
	
    <!-- BOTTOM SPOTLIGHT-->
    <div id="ja-botsl" class="wrap">
      <div class="main clearfix">
          <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer panel') ) : ?><?php endif; ?>
      </div>
      </div>
    <!-- //BOTTOM SPOTLIGHT 2 -->

<?php get_footer(); ?>