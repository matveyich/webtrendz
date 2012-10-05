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

///// WTZ FIX
// Latest news widget
function widget_latestnews($args) {
          extract($args);
      ?>
              <?php echo $before_widget; ?>
                  <?php echo $before_title
                      . 'Latest news'
                      . $after_title; ?>
<?php
$args = array(
		'numberposts' => -1,
		'orderby' => 'date',
		'order' => 'DESC',
		'category_name' => 'news',
	);
	$lastposts = get_posts($args);
	if ($lastposts) {
		foreach ($lastposts as $post) {
		setup_postdata($post);
		$show_lnk = true;
		foreach((get_the_category($post->ID)) as $category) { 
			if ('hide' == $category->cat_name) $show_lnk = false; 
		} 
		if ($show_lnk == true) 
			{
		?>
		<a href="<? echo get_permalink($post->ID);?>"><? echo $post->post_title;?></a><br><br>
		<?
			}
		}
	}              
?>              
			  <?php echo $after_widget; ?>
			  <a class="archive_lnk readon" style="color:#444444" href="<?bloginfo('url');?>/category/news/">Archive</a>			  
      <?php
}
      register_sidebar_widget('Latest News Widget', 'widget_latestnews');
// Latest news widget END
function widget_archives_block($args) {
	extract($args);
	echo $before_widget;
    echo $before_title. 'Archive by date'. $after_title; 
	wp_get_archives();
	echo $after_widget;
	
	echo $before_widget;
    echo $before_title. 'Categories'. $after_title; 
	wp_list_categories('orderby=name&hide_empty=0&child_of='.get_category_by_slug('archive-categories').'&title_li=');
	echo $after_widget;
	/*
	echo $before_widget;
	echo $before_title. 'Categories'. $after_title; 
	wp_list_categories('title_li=&exclude=6');
	echo $after_widget;
	*/
}
      register_sidebar_widget('Archives widget', 'widget_archives_block');	  
function widget_newsletter($args) {
	extract($args);
	echo $before_widget;
	echo $before_title;
	?>
Newsletter
<?
	echo $after_title;
?>
  <div class="ja-box-ct clearfix">
  	<?php if (class_exists('ajaxNewsletter')): ?>
    <!-- place your HTML code here -->
    <?php ajaxNewsletter::newsletterForm(); ?>
    <!-- place your HTML code here -->
    <?php endif; ?>
  </div>

<?
	echo $after_widget;
}
      register_sidebar_widget('Newsletter widget', 'widget_newsletter');

//  Last reviews 
function list_reviews()
{
	$query = mysql_query('SELECT review_type FROM `wp_pgrvw` WHERE featured=1 AND review_type!="" AND review_type != "Live-dealer" GROUP BY review_type;');
	echo mysql_error();
	 $i = 0;
	 while ($cont = mysql_fetch_array($query, MYSQL_ASSOC)) {
		$cat[$i] = $cont[review_type];
		$i++;
	 }
	 // going through an array of categories to retrieve data for featured reviews in each of them
?>
<div id="featured_reviews">	 
<?	 
	 foreach ($cat as $r_type) {
		$query = mysql_query("SELECT id,urllogo, title, shdescr AS descr, padeid AS page_id, urlreview FROM `wp_pgrvw` WHERE featured=1 AND review_type='".$r_type."' ORDER BY position, title ASC;");?>
	<div class="featured_rvws_block">
		<div class="featured_title"><h2>Top <? echo $r_type;?> Reviews </h2></div>
		<div class="featured_content">
<?
		while ($cont = mysql_fetch_array($query, MYSQL_ASSOC)) {
?>
	<div class="featured_review_box">
		<div class="featured_review">
			<?if (isset($cont[urllogo]) && $cont[urllogo]!="") {?>
<a class="LogoLink" href="<? echo get_bloginfo('url')."?reviewid=".$cont[id];?>" target="_blank"><img alt="<? echo $cont[title];?>" src="<?echo $cont[urllogo];?>" /></a>
<?}?>
			<div class="featured_review_title">
			<? echo "<a href='".$cont[urlreview]."' target='_blank'>".$cont[title]."</a>";?>
			</div>
			<div class="featured_review_text">
			<?
			#echo chopsentences($cont[descr],3);
			echo $cont[descr];
			?>
			</div>
		</div>
		<div class="featured_review_bottom">
			<? echo "<a class=\"readon\" href='".get_permalink($cont[page_id])."'>Read more</a>";?>
			<?
			if ($cont[urlreview] != "") echo "<a class=\"playNow\" href='".get_bloginfo('url')."?reviewid=".$cont[id]."' target=\"_blank\">Play now</a>";
			?>
		</div>
	</div>		
			<?
		}
		?>
		</div>
	</div>
		<?
	 }
?>
</div>	 
<?
}
// 

function list_several_reviews($r_type, $n = 0, $type = "table")
{
global $wpdb;
if ($n!=0)
{
	$limit = "LIMIT 0,".$n;
} else {$limit = "";}
switch ($type)
{
	case "blocks_new":
?>
<div class="article-content">	 
	<div class="reviewList">
	<div class="post-content mrgTop">	 

<?	 
		$query = mysql_query("SELECT rw.id, rw.urllogo, rw.title, rw.mediumdescr AS descr, rw.padeid AS page_id, rw.urlreview, rw.bonus_type, rw.offervaluet, rw.offervaluef FROM `wp_pgrvw` rw INNER JOIN $wpdb->posts p ON rw.padeid = p.ID WHERE rw.review_type='".$r_type."' AND p.post_status='publish' ORDER BY position, title ASC ".$limit.";");?>
<?
		while ($cont = mysql_fetch_array($query, MYSQL_ASSOC)) {
?>
	<p></p>
	<div class="indent">
			<h2><? echo '<a href="'.get_bloginfo('url').'?reviewid='.$cont[id].'" target="_blank" title="Play at '.$cont[title].'">'.$cont[title].'</a>';?></h2>
			<p class="bonus"><span>Bonus</span> 
			<?
switch($cont[bonus_type]){
	case 1:echo $cont[offervaluef]." Up To ".$cont[offervaluet];break;
	case 2:echo $cont[offervaluef]." PLAY WITH ".$cont[offervaluet];break;
	case 3:echo $cont[offervaluef]." FREE";break;	
}			
			?>			
			</p>
			<div class="box">
			<?
			#echo chopsentences($cont[descr],3);
if (isset($cont[urllogo]) && $cont[urllogo]!="") {?>
<a class="LogoLink" href="<? echo get_permalink($cont[page_id]);?>" target="_blank" title="Read <?=$cont[title]?> review"><img alt="<? echo $cont[title];?>" src="<?echo $cont[urllogo];?>" title="Read <?=$cont[title]?> review" /></a>
<?}
			?>
			<p class="desc"><?echo stripslashes($cont[descr]);?></p>	
			<div class="buttons">
			<? echo '<a href="'.get_permalink($cont[page_id]).'" title="Read '.$cont[title].' review">Read more</a>';?>
			<? if ($cont[urlreview] != "") echo "<a href='".get_bloginfo('url')."?reviewid=".$cont[id]."' target=\"_blank\" title=\"Play at $cont[title]\">Play now</a>";
			?>
			</div>
			</div>
	</div>
	<p></p>
			<?
		}
		?>
	</div>
	</div>
</div>	 
<script>
jq("div.indent:odd").addClass("oddOne");
</script>
<?
	break;
	case "blocks":
?>
<div id="featured_reviews">	 
<?	 
		$query = mysql_query("SELECT id, urllogo, title, shdescr AS descr, padeid AS page_id, urlreview FROM `wp_pgrvw` WHERE review_type='".$r_type."' AND ORDER BY position, title ASC ".$limit.";");?>
	<div class="featured_rvws_block_row">
		<div class="featured_content">
<?
		while ($cont = mysql_fetch_array($query, MYSQL_ASSOC)) {
?>
	<div class="featured_review_box">
		<div class="featured_review">
			<?if (isset($cont[urllogo]) && $cont[urllogo]!="") {?>
<a class="LogoLink" href="<? echo get_bloginfo('url')."?reviewid=".$cont[id];?>" target="_blank"><img alt="<? echo $cont[title];?>" src="<?echo $cont[urllogo];?>" /></a>
<?}?>
			<div class="featured_review_title">
			<? echo "<a href='".get_bloginfo('url')."?reviewid=".$cont[id]."' target='_blank'>".$cont[title]."</a>";?>
			</div>
			<div class="featured_review_text">
			<?
			#echo chopsentences($cont[descr],3);
			echo $cont[descr];
			?>
			</div>
		</div>
		<div class="featured_review_bottom">
			<? echo "<a class=\"readon\" href='".get_permalink($cont[page_id])."'>Read more</a>";?>
			<?
			if ($cont[urlreview] != "") echo "<a class=\"playNow\" href='".get_bloginfo('url')."?reviewid=".$cont[id]."' target=\"_blank\">Play now</a>";
			?>
		</div>
	</div>		
			<?
		}
		?>
		</div>
	</div>

</div>	 
<?
	break;
	case "table":
?>
<div id="featured_reviews">	 
<?	 
		$query = mysql_query("SELECT rw.id, rw.urllogo, rw.title, rw.padeid AS page_id, rw.urlreview, rw.bonus_type, rw.offervaluet, rw.offervaluef FROM `wp_pgrvw` rw INNER JOIN $wpdb->posts p ON rw.padeid = p.ID WHERE rw.review_type='".$r_type."' AND p.post_status='publish' ORDER BY position,title ASC ".$limit.";");?>
	<div class="featured_rvws_block_table">

	<table>
		<tbody>
			<tr>
				<th>
				
				</th>
				<th>
				Name
				</th>				
				<th>
				Bonus
				</th>
				<th>
				
				</th>				
			</tr>
		</tbody>
		<tbody>
<?
while ($cont = mysql_fetch_array($query, MYSQL_ASSOC)) 
{
	//if ("publish" == get_post_status($cont[page_id]))
	//{
		?>
			<tr>

				<td>
			<?if (isset($cont[urllogo]) && $cont[urllogo]!="") {?>
<a class="LogoLink" href="<?echo get_bloginfo('url')."?reviewid=".$cont[id];?>" target="_blank"><img alt="<? echo $cont[title];?>" src="<?echo $cont[urllogo];?>" /></a>
<?}?>
				</td>
			
				<td>
			<? echo "<a href='".get_bloginfo('url')."?reviewid=".$cont[id]."' target='_blank'>".$cont[title]."</a>";?>
			</td>
				
				<td>
			<?
switch($cont[bonus_type])
{
	case 1:
		echo $cont[offervaluef]." Up To ".$cont[offervaluet];
	break;
	case 2:
		echo $cont[offervaluef]." PLAY WITH ".$cont[offervaluet];
	break;
	case 3:
		echo $cont[offervaluef]." FREE";
	break;
	
}			
			?>
				</td>
			
				<td>
			<? echo "<a class=\"readon\" href='".get_permalink($cont[page_id])."'>Read more</a>";?>
			<?
			if ($cont[urlreview] != "") echo "<a class=\"playNow\" href='".get_bloginfo('url')."?reviewid=".$cont[id]."' target=\"_blank\">Play now</a>";
			?>
				</td>
			
			</tr>
			<?
		
	//}
}
		?>
		</tbody>
	</table>

	</div>

</div>	 
<?
	break;
}

}
//

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
//Playlist widget
function widget_playlist($args) {
          extract($args);
      ?>
              <?php echo $before_widget; ?>
                  <?php echo $before_title. ''. $after_title; ?>
 <object width="100%" height="400">
	<param name="movie" value="http://www.youtube.com/p/835DBC7F68FDAAA8&fs=1"></param>
	<param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
	<embed src="http://www.youtube.com/p/835DBC7F68FDAAA8&fs=1" type="application/x-shockwave-flash" width="100%" height="400" allowscriptaccess="always" allowfullscreen="true"></embed>
</object>           
			  <?php echo $after_widget; ?>
      <?php
}
      register_sidebar_widget('Featured Playlist Widget', 'widget_playlist');
// Latest news widget END 

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
class Topbanner extends WP_Widget {
    /** constructor */
    function Topbanner() {
	                $widget_ops = array('classname' => 'widget_text', 'code' => __('Top banner code'));
	                $control_ops = array('width' => 400, 'height' => 350);
	                $this->WP_Widget('Topbanner', __('Topbanner'), $widget_ops, $control_ops);
	        }
	
	        function widget( $args, $instance ) {
	                extract($args);
	                $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
	                $code = apply_filters( 'widget_text', $instance['code'], $instance );
	                echo $before_widget;
					?>
				
					<?
	                //if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
	                <?php echo $code; ?>
				
					<?php
	                echo $after_widget;
	        }
	
	        function update( $new_instance, $old_instance ) {
	                $instance = $old_instance;
	                $instance['title'] = strip_tags($new_instance['title']);
	                if ( current_user_can('unfiltered_html') )
	                        $instance['code'] =  $new_instance['code'];
	                else
	                        $instance['code'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['code']) ) ); // wp_filter_post_kses() expects slashed
	                $instance['filter'] = isset($new_instance['filter']);
	                return $instance;
	        }
	
	        function form( $instance ) {
	                $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'code' => '' ) );
	                $title = strip_tags($instance['title']);
	                $code = format_to_edit($instance['code']);
	?>
	                <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
	                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
					<p>
	                <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('code'); ?>" name="<?php echo $this->get_field_name('code'); ?>"><?php echo $code; ?></textarea>
	
	                </p>
	<?php
	        }

}
add_action('widgets_init', create_function('', 'return register_widget("Topbanner");'));
/////// WTZ FIX END

if ( function_exists('register_sidebar') ) {
	register_sidebar(array('name'=>'right panel',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</div></li>',
		'before_title' => '<h3 class="clearfix"><span class="right-bg clearfix"><span class="left-bg">',
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
        register_sidebar(array('name'=>'Video',
		'before_widget' => '<div class="jazin-theme jazin-box1">
				<div class="">
                    <div class="jazin-section clearfix">',
		'after_widget' => '</ul>
				</div>
			</div>',
		'before_title' => '',
		'after_title' => '
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
		'before_title' => '<h1 class="contentheading"><span class="contentpagetitle">',
		'after_title' => '</span></h1>
    
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
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	));
	register_sidebar(array('name'=>'bottom menu',
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '',
		'after_title' => '',
	));
}
	register_sidebar(array('name'=>'archive panel',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</div></li>',
		'before_title' => '<h3 class="clearfix"><span class="right-bg clearfix"><span class="left-bg">',
		'after_title' => '</span></span></h3>
						<div class="ja-box-ct clearfix">',
	));	
	register_sidebar(array('name'=>'top banner',
		'before_widget' => '<div class="top_banner">',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
	));	
function dimox_breadcrumbs() {

  $delimiter = '&raquo;'; //????????? ????? ????????
  $name = 'Home'; //????? ?????? "???????"
  $currentBefore = '';
  $currentAfter = '';

  //if ( is_home() || is_front_page() || is_paged() ) {
echo '<strong>You are here:</strong> ';
    //echo '<div id="crumbs">';

    global $post;
    $home = get_bloginfo('url');
    echo '<a href="' . $home . '">' . $name . '</a> ';
	if (!(is_home() || is_front_page())) { echo $delimiter.' ';}

    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $currentBefore;
      single_cat_title();
      echo $currentAfter;

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
      the_title(); //echo "single";
      echo $currentAfter;

    } elseif ( is_page() && !$post->post_parent && !is_page('footer')) {
      echo $currentBefore;
      the_title();//echo 's_page() && !$post->post_parent ';
      echo $currentAfter;

    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;//echo 'is_page() && $post->post_parent ';
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        if (get_the_title($page->ID) != 'Footer')
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

    //echo '</div>';

  //}
}