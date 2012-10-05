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
  register_sidebar(array('name'=>'right panel',
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</div></li>',
    'before_title' => '<hr/><h3 class="clearfix"><span class="right-bg clearfix"><span class="left-bg">',
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
/* for thumbnails*/
if ( function_exists( 'add_theme_support' ) )
add_theme_support( 'post-thumbnails', array( 'post' ) );

/** @ignore */
function kubrick_head() {
  $head = "<style type='text/css'>\n<!--";
  $output = '';
  if ( kubrick_header_image() ) {
    $url =  kubrick_header_image_url() ;
    $output .= "#header { background: url('$url') no-repeat bottom center; }\n";
  }
  if ( false !== ( $color = kubrick_header_color() ) ) {
    $output .= "#headerimg h1 a, #headerimg h1 a:visited, #headerimg .description { color: $color; }\n";
  }
  if ( false !== ( $display = kubrick_header_display() ) ) {
    $output .= "#headerimg { display: $display }\n";
  }
  $foot = "--></style>\n";
  if ( '' != $output )
    echo $head . $output . $foot;
}

add_action('wp_head', 'kubrick_head');

function kubrick_header_image() {
  return apply_filters('kubrick_header_image', get_option('kubrick_header_image'));
}

function kubrick_upper_color() {
  if (strpos($url = kubrick_header_image_url(), 'header-img.php?') !== false) {
    parse_str(substr($url, strpos($url, '?') + 1), $q);
    return $q['upper'];
  } else
    return '69aee7';
}

function kubrick_lower_color() {
  if (strpos($url = kubrick_header_image_url(), 'header-img.php?') !== false) {
    parse_str(substr($url, strpos($url, '?') + 1), $q);
    return $q['lower'];
  } else
    return '4180b6';
}

function kubrick_header_image_url() {
  if ( $image = kubrick_header_image() )
    $url = get_template_directory_uri() . '/images/' . $image;
  else
    $url = get_template_directory_uri() . '/images/kubrickheader.jpg';

  return $url;
}

function kubrick_header_color() {
  return apply_filters('kubrick_header_color', get_option('kubrick_header_color'));
}

function kubrick_header_color_string() {
  $color = kubrick_header_color();
  if ( false === $color )
    return 'white';

  return $color;
}

function kubrick_header_display() {
  return apply_filters('kubrick_header_display', get_option('kubrick_header_display'));
}

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

function kubrick_header_display_string() {
  $display = kubrick_header_display();
  return $display ? $display : 'inline';
}

add_action('admin_menu', 'kubrick_add_theme_page');

function kubrick_add_theme_page() {
  if ( isset( $_GET['page'] ) && $_GET['page'] == basename(__FILE__) ) {
    if ( isset( $_REQUEST['action'] ) && 'save' == $_REQUEST['action'] ) {
      check_admin_referer('kubrick-header');
      if ( isset($_REQUEST['njform']) ) {
        if ( isset($_REQUEST['defaults']) ) {
          delete_option('kubrick_header_image');
          delete_option('kubrick_header_color');
          delete_option('kubrick_header_display');
        } else {
          if ( '' == $_REQUEST['njfontcolor'] )
            delete_option('kubrick_header_color');
          else {
            $fontcolor = preg_replace('/^.*(#[0-9a-fA-F]{6})?.*$/', '$1', $_REQUEST['njfontcolor']);
            update_option('kubrick_header_color', $fontcolor);
          }
          if ( preg_match('/[0-9A-F]{6}|[0-9A-F]{3}/i', $_REQUEST['njuppercolor'], $uc) && preg_match('/[0-9A-F]{6}|[0-9A-F]{3}/i', $_REQUEST['njlowercolor'], $lc) ) {
            $uc = ( strlen($uc[0]) == 3 ) ? $uc[0]{0}.$uc[0]{0}.$uc[0]{1}.$uc[0]{1}.$uc[0]{2}.$uc[0]{2} : $uc[0];
            $lc = ( strlen($lc[0]) == 3 ) ? $lc[0]{0}.$lc[0]{0}.$lc[0]{1}.$lc[0]{1}.$lc[0]{2}.$lc[0]{2} : $lc[0];
            update_option('kubrick_header_image', "header-img.php?upper=$uc&lower=$lc");
          }

          if ( isset($_REQUEST['toggledisplay']) ) {
            if ( false === get_option('kubrick_header_display') )
              update_option('kubrick_header_display', 'none');
            else
              delete_option('kubrick_header_display');
          }
        }
      } else {

        if ( isset($_REQUEST['headerimage']) ) {
          check_admin_referer('kubrick-header');
          if ( '' == $_REQUEST['headerimage'] )
            delete_option('kubrick_header_image');
          else {
            $headerimage = preg_replace('/^.*?(header-img.php\?upper=[0-9a-fA-F]{6}&lower=[0-9a-fA-F]{6})?.*$/', '$1', $_REQUEST['headerimage']);
            update_option('kubrick_header_image', $headerimage);
          }
        }

        if ( isset($_REQUEST['fontcolor']) ) {
          check_admin_referer('kubrick-header');
          if ( '' == $_REQUEST['fontcolor'] )
            delete_option('kubrick_header_color');
          else {
            $fontcolor = preg_replace('/^.*?(#[0-9a-fA-F]{6})?.*$/', '$1', $_REQUEST['fontcolor']);
            update_option('kubrick_header_color', $fontcolor);
          }
        }

        if ( isset($_REQUEST['fontdisplay']) ) {
          check_admin_referer('kubrick-header');
          if ( '' == $_REQUEST['fontdisplay'] || 'inline' == $_REQUEST['fontdisplay'] )
            delete_option('kubrick_header_display');
          else
            update_option('kubrick_header_display', 'none');
        }
      }
      //print_r($_REQUEST);
      wp_redirect("themes.php?page=functions.php&saved=true");
      die;
    }
    add_action('admin_head', 'kubrick_theme_page_head');
  }
  add_theme_page(__('Custom Header'), __('Custom Header'), 'edit_themes', basename(__FILE__), 'kubrick_theme_page');
}

function kubrick_theme_page_head() {
?>
<script type="text/javascript" src="../wp-includes/js/colorpicker.js"></script>
<script type='text/javascript'>
// <![CDATA[
  function pickColor(color) {
    ColorPicker_targetInput.value = color;
    kUpdate(ColorPicker_targetInput.id);
  }
  function PopupWindow_populate(contents) {
    contents += '<br /><p style="text-align:center;margin-top:0px;"><input type="button" class="button-secondary" value="<?php esc_attr_e('Close Color Picker'); ?>" onclick="cp.hidePopup(\'prettyplease\')"></input></p>';
    this.contents = contents;
    this.populated = false;
  }
  function PopupWindow_hidePopup(magicword) {
    if ( magicword != 'prettyplease' )
      return false;
    if (this.divName != null) {
      if (this.use_gebi) {
        document.getElementById(this.divName).style.visibility = "hidden";
      }
      else if (this.use_css) {
        document.all[this.divName].style.visibility = "hidden";
      }
      else if (this.use_layers) {
        document.layers[this.divName].visibility = "hidden";
      }
    }
    else {
      if (this.popupWindow && !this.popupWindow.closed) {
        this.popupWindow.close();
        this.popupWindow = null;
      }
    }
    return false;
  }
  function colorSelect(t,p) {
    if ( cp.p == p && document.getElementById(cp.divName).style.visibility != "hidden" )
      cp.hidePopup('prettyplease');
    else {
      cp.p = p;
      cp.select(t,p);
    }
  }
  function PopupWindow_setSize(width,height) {
    this.width = 162;
    this.height = 210;
  }

  var cp = new ColorPicker();
  function advUpdate(val, obj) {
    document.getElementById(obj).value = val;
    kUpdate(obj);
  }
  function kUpdate(oid) {
    if ( 'uppercolor' == oid || 'lowercolor' == oid ) {
      uc = document.getElementById('uppercolor').value.replace('#', '');
      lc = document.getElementById('lowercolor').value.replace('#', '');
      hi = document.getElementById('headerimage');
      hi.value = 'header-img.php?upper='+uc+'&lower='+lc;
      document.getElementById('header').style.background = 'url("<?php echo get_template_directory_uri(); ?>/images/'+hi.value+'") center no-repeat';
      document.getElementById('advuppercolor').value = '#'+uc;
      document.getElementById('advlowercolor').value = '#'+lc;
    }
    if ( 'fontcolor' == oid ) {
      document.getElementById('header').style.color = document.getElementById('fontcolor').value;
      document.getElementById('advfontcolor').value = document.getElementById('fontcolor').value;
    }
    if ( 'fontdisplay' == oid ) {
      document.getElementById('headerimg').style.display = document.getElementById('fontdisplay').value;
    }
  }
  function toggleDisplay() {
    td = document.getElementById('fontdisplay');
    td.value = ( td.value == 'none' ) ? 'inline' : 'none';
    kUpdate('fontdisplay');
  }
  function toggleAdvanced() {
    a = document.getElementById('jsAdvanced');
    if ( a.style.display == 'none' )
      a.style.display = 'block';
    else
      a.style.display = 'none';
  }
  function kDefaults() {
    document.getElementById('headerimage').value = '';
    document.getElementById('advuppercolor').value = document.getElementById('uppercolor').value = '#69aee7';
    document.getElementById('advlowercolor').value = document.getElementById('lowercolor').value = '#4180b6';
    document.getElementById('header').style.background = 'url("<?php echo get_template_directory_uri(); ?>/images/kubrickheader.jpg") center no-repeat';
    document.getElementById('header').style.color = '#FFFFFF';
    document.getElementById('advfontcolor').value = document.getElementById('fontcolor').value = '';
    document.getElementById('fontdisplay').value = 'inline';
    document.getElementById('headerimg').style.display = document.getElementById('fontdisplay').value;
  }
  function kRevert() {
    document.getElementById('headerimage').value = '<?php echo esc_js(kubrick_header_image()); ?>';
    document.getElementById('advuppercolor').value = document.getElementById('uppercolor').value = '#<?php echo esc_js(kubrick_upper_color()); ?>';
    document.getElementById('advlowercolor').value = document.getElementById('lowercolor').value = '#<?php echo esc_js(kubrick_lower_color()); ?>';
    document.getElementById('header').style.background = 'url("<?php echo esc_js(kubrick_header_image_url()); ?>") center no-repeat';
    document.getElementById('header').style.color = '';
    document.getElementById('advfontcolor').value = document.getElementById('fontcolor').value = '<?php echo esc_js(kubrick_header_color_string()); ?>';
    document.getElementById('fontdisplay').value = '<?php echo esc_js(kubrick_header_display_string()); ?>';
    document.getElementById('headerimg').style.display = document.getElementById('fontdisplay').value;
  }
  function kInit() {
    document.getElementById('jsForm').style.display = 'block';
    document.getElementById('nonJsForm').style.display = 'none';
  }
  addLoadEvent(kInit);
// ]]>
</script>
<style type='text/css'>
  #headwrap {
    text-align: center;
  }
  #kubrick-header {
    font-size: 80%;
  }
  #kubrick-header .hibrowser {
    width: 780px;
    height: 260px;
    overflow: scroll;
  }
  #kubrick-header #hitarget {
    display: none;
  }
  #kubrick-header #header h1 {
    font-family: 'Trebuchet MS', 'Lucida Grande', Verdana, Arial, Sans-Serif;
    font-weight: bold;
    font-size: 4em;
    text-align: center;
    padding-top: 70px;
    margin: 0;
  }

  #kubrick-header #header .description {
    font-family: 'Lucida Grande', Verdana, Arial, Sans-Serif;
    font-size: 1.2em;
    text-align: center;
  }
  #kubrick-header #header {
    text-decoration: none;
    color: <?php echo kubrick_header_color_string(); ?>;
    padding: 0;
    margin: 0;
    height: 200px;
    text-align: center;
    background: url('<?php echo kubrick_header_image_url(); ?>') center no-repeat;
  }
  #kubrick-header #headerimg {
    margin: 0;
    height: 200px;
    width: 100%;
    display: <?php echo kubrick_header_display_string(); ?>;
  }

        .description {
                margin-top: 16px;
                color: #fff;
        }

  #jsForm {
    display: none;
    text-align: center;
  }
  #jsForm input.submit, #jsForm input.button, #jsAdvanced input.button {
    padding: 0px;
    margin: 0px;
  }
  #advanced {
    text-align: center;
    width: 620px;
  }
  html>body #advanced {
    text-align: center;
    position: relative;
    left: 50%;
    margin-left: -380px;
  }
  #jsAdvanced {
    text-align: right;
  }
  #nonJsForm {
    position: relative;
    text-align: left;
    margin-left: -370px;
    left: 50%;
  }
  #nonJsForm label {
    padding-top: 6px;
    padding-right: 5px;
    float: left;
    width: 100px;
    text-align: right;
  }
  .defbutton {
    font-weight: bold;
  }
  .zerosize {
    width: 0px;
    height: 0px;
    overflow: hidden;
  }
  #colorPickerDiv a, #colorPickerDiv a:hover {
    padding: 1px;
    text-decoration: none;
    border-bottom: 0px;
  }
</style>
<?php
}

function kubrick_theme_page() {
  if ( isset( $_REQUEST['saved'] ) ) echo '<div id="message" class="updated fade"><p><strong>'.__('Options saved.').'</strong></p></div>';
?>
<div class='wrap'>
  <h2><?php _e('Customize Header'); ?></h2>
  <div id="kubrick-header">
    <div id="headwrap">
      <div id="header">
        <div id="headerimg">
          <h1><?php bloginfo('name'); ?></h1>
          <div class="description"><?php bloginfo('description'); ?></div>
        </div>
      </div>
    </div>
    <br />
    <div id="nonJsForm">
      <form method="post" action="">
        <?php wp_nonce_field('kubrick-header'); ?>
        <div class="zerosize"><input type="submit" name="defaultsubmit" value="<?php esc_attr_e('Save'); ?>" /></div>
          <label for="njfontcolor"><?php _e('Font Color:'); ?></label><input type="text" name="njfontcolor" id="njfontcolor" value="<?php echo esc_attr(kubrick_header_color()); ?>" /> <?php printf(__('Any CSS color (%s or %s or %s)'), '<code>red</code>', '<code>#FF0000</code>', '<code>rgb(255, 0, 0)</code>'); ?><br />
          <label for="njuppercolor"><?php _e('Upper Color:'); ?></label><input type="text" name="njuppercolor" id="njuppercolor" value="#<?php echo esc_attr(kubrick_upper_color()); ?>" /> <?php printf(__('HEX only (%s or %s)'), '<code>#FF0000</code>', '<code>#F00</code>'); ?><br />
        <label for="njlowercolor"><?php _e('Lower Color:'); ?></label><input type="text" name="njlowercolor" id="njlowercolor" value="#<?php echo esc_attr(kubrick_lower_color()); ?>" /> <?php printf(__('HEX only (%s or %s)'), '<code>#FF0000</code>', '<code>#F00</code>'); ?><br />
        <input type="hidden" name="hi" id="hi" value="<?php echo esc_attr(kubrick_header_image()); ?>" />
        <input type="submit" name="toggledisplay" id="toggledisplay" value="<?php esc_attr_e('Toggle Text'); ?>" />
        <input type="submit" name="defaults" value="<?php esc_attr_e('Use Defaults'); ?>" />
        <input type="submit" class="defbutton" name="submitform" value="&nbsp;&nbsp;<?php esc_attr_e('Save'); ?>&nbsp;&nbsp;" />
        <input type="hidden" name="action" value="save" />
        <input type="hidden" name="njform" value="true" />
      </form>
    </div>
    <div id="jsForm">
      <form style="display:inline;" method="post" name="hicolor" id="hicolor" action="<?php echo esc_attr($_SERVER['REQUEST_URI']); ?>">
        <?php wp_nonce_field('kubrick-header'); ?>
  <input type="button"  class="button-secondary" onclick="tgt=document.getElementById('fontcolor');colorSelect(tgt,'pick1');return false;" name="pick1" id="pick1" value="<?php esc_attr_e('Font Color'); ?>"></input>
    <input type="button" class="button-secondary" onclick="tgt=document.getElementById('uppercolor');colorSelect(tgt,'pick2');return false;" name="pick2" id="pick2" value="<?php esc_attr_e('Upper Color'); ?>"></input>
    <input type="button" class="button-secondary" onclick="tgt=document.getElementById('lowercolor');colorSelect(tgt,'pick3');return false;" name="pick3" id="pick3" value="<?php esc_attr_e('Lower Color'); ?>"></input>
        <input type="button" class="button-secondary" name="revert" value="<?php esc_attr_e('Revert'); ?>" onclick="kRevert()" />
        <input type="button" class="button-secondary" value="<?php esc_attr_e('Advanced'); ?>" onclick="toggleAdvanced()" />
        <input type="hidden" name="action" value="save" />
        <input type="hidden" name="fontdisplay" id="fontdisplay" value="<?php echo esc_attr(kubrick_header_display()); ?>" />
        <input type="hidden" name="fontcolor" id="fontcolor" value="<?php echo esc_attr(kubrick_header_color()); ?>" />
        <input type="hidden" name="uppercolor" id="uppercolor" value="<?php echo esc_attr(kubrick_upper_color()); ?>" />
        <input type="hidden" name="lowercolor" id="lowercolor" value="<?php echo esc_attr(kubrick_lower_color()); ?>" />
        <input type="hidden" name="headerimage" id="headerimage" value="<?php echo esc_attr(kubrick_header_image()); ?>" />
        <p class="submit"><input type="submit" name="submitform" class="button-primary" value="<?php esc_attr_e('Update Header'); ?>" onclick="cp.hidePopup('prettyplease')" /></p>
      </form>
      <div id="colorPickerDiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;visibility:hidden;"> </div>
      <div id="advanced">
        <form id="jsAdvanced" style="display:none;" action="">
          <?php wp_nonce_field('kubrick-header'); ?>
          <label for="advfontcolor"><?php _e('Font Color (CSS):'); ?> </label><input type="text" id="advfontcolor" onchange="advUpdate(this.value, 'fontcolor')" value="<?php echo esc_attr(kubrick_header_color()); ?>" /><br />
          <label for="advuppercolor"><?php _e('Upper Color (HEX):');?> </label><input type="text" id="advuppercolor" onchange="advUpdate(this.value, 'uppercolor')" value="#<?php echo esc_attr(kubrick_upper_color()); ?>" /><br />
          <label for="advlowercolor"><?php _e('Lower Color (HEX):'); ?> </label><input type="text" id="advlowercolor" onchange="advUpdate(this.value, 'lowercolor')" value="#<?php echo esc_attr(kubrick_lower_color()); ?>" /><br />
          <input type="button" class="button-secondary" name="default" value="<?php esc_attr_e('Select Default Colors'); ?>" onclick="kDefaults()" /><br />
          <input type="button" class="button-secondary" onclick="toggleDisplay();return false;" name="pick" id="pick" value="<?php esc_attr_e('Toggle Text Display'); ?>"></input><br />
        </form>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php
?>