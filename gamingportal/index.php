<?php get_header(); ?>
<?
function blog_post()
{
	$args = array(
		'numberposts' => 3,
		'orderby' => 'date',
		'order' => 'DESC',
		'category_name' => 'blog'
	);
	$blogpost = get_posts($args);
	?>
	<div id="blogpost" class="ja-zinfp-normal column clearfix">
		<div class="featured-header">
		<h2 class="fh">
			Blog
			</h2>
		</div>
		<div class="featured-content">
			<div class="featured-inner-content">
	<?
	foreach ($blogpost as $post) :
	setup_postdata($post);
	?>
			<div class="featured-news-block">
				<div class="featured-title">
				<h2><a href="<? echo get_permalink($post->ID);?>"><? echo $post->post_title;?></a></h2>
				</div>
				<!--<div class="featured-meta"><? echo $post->post_date;?></div>-->
				<div class="featured-text">
				<? echo $post->post_excerpt;?>
				</div>
				<a href="<?php echo get_permalink($post->ID);?>" class="readon">Read more...</a>
			</div>
	<?
	endforeach;
	?>		
			</div>
		</div>
	</div>	
	<?
}
function featured_news($what = "reviews")
{
	switch ($what) 
	{
	case "news":
		$args = array(
		'numberposts' => 3,
		'orderby' => 'date',
		'order' => 'DESC',
		'category_name' => 'news'
		);
		$lastposts = get_posts($args);
	break;
	case "reviews":
		// nothing here
	break;
	}
	#if ($lastposts) {?>
	<div class="ja-zinfp-normal column clearfix">
		<div class="ja-zincontent inner clearfix first">
		<div class="featured-header">
		<h2 class="fh">
			Latest <? echo $what;?>
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
				<div class="featured-title">
				<h2><a href="<? echo get_permalink($post->ID);?>"><? echo $post->post_title;?></a></h2>
				</div>
				<!--<div class="featured-meta"><? echo $post->post_date;?></div>-->
				<div class="featured-text">
				<? echo $post->post_excerpt;?>
				</div>
				<a href="<?php echo get_permalink($post->ID);?>" class="readon">Read more...</a>
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
	#}
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
			<div class="breadcrumbs pathway">
              <?php include ( TEMPLATEPATH . '/breadcrumbs.php'); ?>
            </div>
        </div>
      </div>
    </div>
    <!-- //BREADCRUMBS -->


    <!-- MAIN CONTAINER -->
    <div id="ja-container" class="wrap ja-r1">
	      <div class="main clearfix">

        <!-- CONTENT -->
        <div id="ja-mainbody" style="width: 70%;">
          <div id="ja-main">

								<div class="slider">
<?
/* WTZ 
this gets image gallery from header_gallery and puts it into carousel
*/
// query
$query = "SELECT gid FROM ".$wpdb->nggallery." WHERE title = 'main gallery' LIMIT 0,1;";
$row = $wpdb->get_results($query); 
echo mysql_error();
if (function_exists('nggShowGallery')) echo nggShowGallery($row[0]->gid, 'headergal'); else echo "no nggShowGallery function";
/*WTZ */
?>	
								</div>
								
<?
if (is_home()) 
	{


//Blog post
	blog_post();
	
// Latest news
	featured_news("news");

// Latest reviews
	featured_news();

// Banner
if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('bottom banner') ) : endif; 

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


//top_post(); 
// Welcome post	
if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('top post') ) : endif;	
}
?>
          </div>
        </div><!--70%-->
        <!-- //CONTENT -->

      <? 
	  // WTZ sidebar. finally for this site
	  // 30% width
	  //sidebar.php
	  get_sidebar();
	  ?>


      </div>
    </div>
    <!-- //MAIN CONTAINER -->
	
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