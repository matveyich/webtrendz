<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
function art_list_pages_filter($output)
{
  global $artThemeSettings;
  $pref ='page-item-';
  if($artThemeSettings['menu.topItemIDs'])
    foreach($artThemeSettings['menu.topItemIDs'] as $id){
      $output = preg_replace('~<li class="([^"]*)\b(' . $pref . $id . ')\b([^"]*)"><a ([^>]+)>([^<]*)</a>~',
        '<li class="$1$2$3"><a $4>' . $artThemeSettings['menu.topItemBegin']
          . '$5' . $artThemeSettings['menu.topItemEnd'] . '</a>', $output, 1);
    }

  $frontID = null;
  $blogID = null;
  if('page' == get_option('show_on_front')) {
    $frontID = get_option('page_on_front');
    $blogID = $artThemeSettings['menu.blogID'];
  }
  if ($frontID)
    $output = preg_replace('~<li class="([^"]*)\b(' . $pref . $frontID . ')\b([^"]*)"><a href="([^"]*)" ~',
      '<li class="$1$2$3"><a href="'. get_option('home') .'" ', $output, 1);

  if ((is_home() && $blogID) || $artThemeSettings['menu.activeID'])
    $output = preg_replace('~<li class="([^"]*)\b(' . $pref . (is_home() ? $blogID : $artThemeSettings['menu.activeID']) . ')\b([^"]*)"><a ~',
      '<li class="$1$2$3"><a class="active" ', $output, 1);
  return $output;
}

load_theme_textdomain( 'kubrick' );

$content_width = 450;

automatic_feed_links();
// WTZ START

function last10_posts($cat)
{

$args = array(
		'numberposts' => 10,
		'orderby' => 'date',
		'order' => 'DESC',
		'category_name' => $cat
	);
	$lastposts = get_posts($args);
	if ($lastposts) {
	echo "<ul>";
		foreach ($lastposts as $post) {
		setup_postdata($post);
		?>
		<li><a href="<? echo get_permalink($post->ID);?>"><? echo $post->post_title;?></a></li>
		<?
		}
	echo "</ul>";
	}              

}
function widget_Newsletter_ajax($args)
{	extract($args);
echo $before_widget; 
echo 
$before_title
. 'Newsletter'.
$after_title; 
?>			
			<ul>
                  <?php if (class_exists('ajaxNewsletter')): ?>
                  <!-- place your HTML code here -->
                  <?php ajaxNewsletter::newsletterForm(); ?>
                  <!-- place your HTML code here -->
                  <?php endif; ?>
			</ul>
<?
echo $after_widget;
}
register_sidebar_widget('Newsletter ajax', 'widget_Newsletter_ajax');

// Latest news widget
function widget_latestnews($args) {
          extract($args);
      ?>
              <?php echo $before_widget; ?>
                  <?php echo $before_title
                      . ''
                      . $after_title; ?>
<?php
$args = array(
		'numberposts' => 7,
		'orderby' => 'date',
		'order' => 'DESC',
		'category_name' => 'news'
	);
	$lastposts = get_posts($args);
	if ($lastposts) {
		foreach ($lastposts as $post) {
		setup_postdata($post);
		?>
		<a href="<? echo get_permalink($post->ID);?>"><? echo $post->post_title;?></a><br><br>
		<?
		}
	}              
?>              
			  <?php echo $after_widget; ?>
      <?php
}
      register_sidebar_widget('Latest News Widget', 'widget_latestnews');
// Latest news widget END
//  Last reviews 
function list_reviews()
{
	$query = mysql_query('SELECT review_type FROM `wp_pgrvw` WHERE featured=1 AND review_type!="" GROUP BY review_type;');
	echo mysql_error();
	 $i = 0;
	 while ($cont = mysql_fetch_array($query, MYSQL_ASSOC)) {
		$cat[$i] = $cont[review_type];
		$i++;
	 }
	 // going through an array of categories to retrieve data for featured reviews in each of them
	 foreach ($cat as $r_type) {
		$query = mysql_query("SELECT urllogo, title, descr, padeid AS page_id, urlreview FROM `wp_pgrvw` WHERE featured=1 AND review_type='".$r_type."' ORDER BY id DESC LIMIT 0,3;");?>
		<div class="featured_title"><h2> <? echo $r_type;?> reviews </h2></div>
		<div class="featured_content">
<?
		while ($cont = mysql_fetch_array($query, MYSQL_ASSOC)) {
?>
			<div class="featured_review">
			<?if (isset($cont[urllogo]) && $cont[urllogo]!="") {?><img alt="<? echo $cont[title];?>" src="<?echo $cont[urllogo];?>" /> <?}?>
			<div class="featured_review_title">
			<? echo "<a href='".get_permalink($cont[page_id])."'>".$cont[title]."</a>";?>
			</div>
			<div class="featured_review_text">
			<?
			echo chopsentences($cont[descr],3);
			?>
			</div>
			<div class="featured_review_bottom">
			<? echo "<a class=\"readon\" href='".get_permalink($cont[page_id])."'>Read more</a>";?>
			<?
			if ($cont[urlreview] != "") echo "<a class=\"readon\" href='".$cont[urlreview]."' target=\"_blank\">Play now</a>";
			?>
			</div>
			</div>
			<?
		}
		?>
		</div>
		<?
	 }
}
// WTZ END
function chopsentences($n, $option)
{
$n=strip_tags($n);
   $sentences=preg_split('/[.|!|?]+/',$n);
   foreach($sentences as $k=>$v){ 
	$words=preg_split('/ /',$v);
	$total+=count($words);$res.=$v.'.';
	if($total>=$option)break;  
   }  
   return $res.'..';
}	
/**
WTZ function for editor
 */
function the_editor_wtz($content, $id = 'content', $canvasname, $prev_id = 'title', $media_buttons = true, $tab_index = 2) {
	$rows = get_option('default_post_edit_rows');
	if (($rows < 3) || ($rows > 100))
		$rows = 12;

	if ( !current_user_can( 'upload_files' ) )
		$media_buttons = false;

	$richedit =  user_can_richedit();
	$class = '';

	if ( $richedit || $media_buttons ) { ?>
	<div id="editor-toolbar">
<?php
	if ( $richedit ) {
		$wp_default_editor = wp_default_editor(); ?>
		<div class="zerosize"><input accesskey="e" type="button" onclick="switchEditors.go('<?php echo $id; ?>')" /></div>
<?php	if ( 'html' == $wp_default_editor ) {
			add_filter('the_editor_content', 'wp_htmledit_pre'); ?>
			<a id="edButtonHTML" class="active hide-if-no-js" onclick="switchEditors.go('<?php echo $id; ?>', 'html');"><?php _e('HTML'); ?></a>
			<a id="edButtonPreview" class="hide-if-no-js" onclick="switchEditors.go('<?php echo $id; ?>', 'tinymce');"><?php _e('Visual'); ?></a>
<?php	} else {
			$class = " class='theEditor'";
			add_filter('the_editor_content', 'wp_richedit_pre'); ?>
			<a id="edButtonHTML" class="hide-if-no-js" onclick="switchEditors.go('<?php echo $id; ?>', 'html');"><?php _e('HTML'); ?></a>
			<a id="edButtonPreview" class="active hide-if-no-js" onclick="switchEditors.go('<?php echo $id; ?>', 'tinymce');"><?php _e('Visual'); ?></a>
<?php	}
	}

	if ( $media_buttons ) { ?>
		<div id="media-buttons" class="hide-if-no-js">
<?php	do_action( 'media_buttons' ); ?>
		</div>
<?php
	} ?>
	</div>
<?php
	}
?>
	<div id="quicktags"><?php
	wp_print_scripts( 'quicktags' ); ?>
	<script type="text/javascript">edToolbar_wtz('<?echo $canvasname;?>')</script>
	</div>

<?php
	$the_editor = apply_filters('the_editor', "<div id='editorcontainer'><textarea rows='$rows'$class cols='40' name='$id' tabindex='$tab_index' id='$id'>%s</textarea></div>\n");
	$the_editor_content = apply_filters('the_editor_content', $content);

	printf($the_editor, $the_editor_content);

?>
	<script type="text/javascript">
	<?echo $canvasname;?> = document.getElementById('<?php echo $id; ?>');
	</script>
<?php
}
/////// WTZ FIX END
 
if ( function_exists('register_sidebar') ) {
  register_sidebar(array('name'=>'members login',
    'before_widget' => '<li id="%1$s_id" class="widget %2$s %1$s">',
    'after_widget' => '</div></li>',
    'before_title' => '<h3 class="clearfix %1$s_title"><span class="right-bg clearfix"><span class="left-bg">',
    'after_title' => '</span></span></h3>
            <div class="ja-box-ct clearfix">',
  ));
  register_sidebar(array('name'=>'right panel',
	'before_widget' => '<li id="%1$s_id" class="widget %2$s %1$s">',
    'after_widget' => '</div></li>',
    'before_title' => '<h3 class="clearfix %1$s_title"><span class="right-bg clearfix"><span class="left-bg">',
    'after_title' => '</span></span></h3>
            <div class="ja-box-ct clearfix">',
  ));
        register_sidebar(array('name'=>'footer panel',
    'before_widget' => '<div class="ja-box-left"><div class="moduletable">',
    'after_widget' => '</div></div></div>',
    'before_title' => '<h3 class="clearfix"><span class="right-bg clearfix"><span class="left-bg">',
    'after_title' => '</span></span></h3>
            <div class="ja-box-ct clearfix">',
  ));
        register_sidebar(array('name'=>'all categories',
    'before_widget' => '<div class="jazin-boxwrap jazin-theme jazin-box1">
        <div class="jazin-box">
                    <div class="jazin-section clearfix">',
    'after_widget' => '</ul>
        </div>
      </div>',
    'before_title' => '<span>',
    'after_title' => '</span>
                    </div>
                    <ul class="jazin-links">',
  ));
  register_sidebar(array('name'=>'search',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '',
    'after_title' => '',
  ));  
  register_sidebar(array('name'=>'top post',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h2 class="contentheading"><a href="#" class="contentpagetitle">',
    'after_title' => '</a></h2>

    <div class="article-toolswrap">
    <div class="article-tools">
      <div class="article-meta">


      </div>

          </div>
  </div>',
  ));
  register_sidebar(array('name'=>'highlight module',
    'before_widget' => '',
    'after_widget' => '</td>
  </tr>
  <tr>
        <td valign="top">

          </td>
     </tr>
</tbody></table>
      </div></div>',
    'before_title' => '<h3 class="clearfix"><span class="right-bg clearfix"><span class="left-bg">',
    'after_title' => '</span></span></h3>
            <div class="ja-box-ct clearfix">
            <div class="over">
<table class="contentpaneopen">
  <tbody><tr>
    <td valign="top">',
  ));
  register_sidebar(array('name'=>'advertisement',
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</div></li>',
    'before_title' => '<hr/><h3 class="clearfix"><span class="right-bg clearfix"><span class="left-bg">',
    'after_title' => '</span></span></h3>
            <div class="ja-box-ct clearfix">',
  ));  

  register_sidebar(array('name'=>'bottom menu',
    'before_widget' => '<li>',
    'after_widget' => '</li>',
    'before_title' => '',
    'after_title' => '',
  ));  
  register_sidebar(array('name'=>'bottom banner',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<!--',
    'after_title' => '-->',
  ));
}
/* for thumbnails*/
if ( function_exists( 'add_theme_support' ) )
add_theme_support( 'post-thumbnails', array( 'post' ) );


function dimox_breadcrumbs() {

  $delimiter = '&raquo;'; //????????? ????? ????????
  $name = '???????'; //????? ?????? "???????"
  $currentBefore = '<span class="current">';
  $currentAfter = '</span>';

  if ( !is_home() || !is_front_page() || is_paged() ) {

    echo '<div id="crumbs">';

    global $post;
    $home = get_bloginfo('url');
    echo '<a href="' . $home . '">' . $name . '</a> ' . $delimiter . ' ';

    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $currentBefore . 'Archive by category &#39;';
      single_cat_title();
      echo '&#39;' . $currentAfter;

    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('d') . $currentAfter;

    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('F') . $currentAfter;

    } elseif ( is_year() ) {
      echo $currentBefore . get_the_time('Y') . $currentAfter;

    } elseif ( is_single() ) {
      $cat = get_the_category(); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo $currentBefore;
      the_title();
      echo $currentAfter;

    } elseif ( is_page() && !$post->post_parent ) {
      echo $currentBefore;
      the_title();
      echo $currentAfter;

    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;

    } elseif ( is_search() ) {
      echo $currentBefore . 'Search results for &#39;' . get_search_query() . '&#39;' . $currentAfter;

    } elseif ( is_tag() ) {
      echo $currentBefore . 'Posts tagged &#39;';
      single_tag_title();
      echo '&#39;' . $currentAfter;

    } elseif ( is_author() ) {
      global $author;
      $userdata = get_userdata($author);
      echo $currentBefore . 'Articles posted by ' . $userdata->display_name . $currentAfter;

    } elseif ( is_404() ) {
      echo $currentBefore . 'Error 404' . $currentAfter;
    }

    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }

    echo '</div>';

  }
}
?>