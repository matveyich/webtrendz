<?
//// some global variables

$wtz_our_clients_page = 'our-clients';//our clients page slug


if (!is_admin()) {

add_action('wp_print_styles', 'wtz_add_site_styles');
add_action('wp_print_scripts', 'wtz_add_site_scripts');
add_filter('the_content', 'wtz_content_filter');
}

function wtz_add_site_styles()
{
	$path = get_bloginfo('template_url').'/';
?>
	<!-- wtz styles-->
<link type="text/css" rel="stylesheet" href="<?echo $path?>css/site-style.css" media="screen" />
<link type="text/css" rel="stylesheet" href="<?echo $path?>css/mainMenu.css" media="screen" />
<link type="text/css" rel="stylesheet" href="<?echo $path?>css/typography.css" media="screen" />
<link type="text/css" rel="stylesheet" href="<?echo $path?>css/additional_style.css" media="screen" />

	<!-- wtz styles-->
<?
}
function wtz_add_site_scripts()
{
	$path = get_bloginfo('template_url').'/';
?>
	<!-- wtz scripts go after 1st jquery instance-->
<?
//wp_enqueue_script ( 'wtz_script01', $path.'js/jquery.quicksand.js', array('jquery'), '1.0');
wp_enqueue_script ( 'wtz_script0', 'http://cdn.jquerytools.org/1.2.5/jquery.tools.min.js', array('jquery'), '1.0');
wp_enqueue_script ( 'wtz_script1', $path.'js/jquery_003.js', array('jquery'), '1.0');
wp_enqueue_script ( 'wtz_script2', $path.'js/jquery_004.js', array('jquery','wtz_script1'), '1.0');
//wp_enqueue_script ( 'wtz_script3', $path.'js/other.js', array('jquery','wtz_script1','wtz_script2'), '1.0');
wp_enqueue_script ( 'wtz_script4', $path.'js/flashScroller.js', array('jquery','wtz_script1','wtz_script2'), '1.0');
wp_enqueue_script ( 'wtz_script5', $path.'js/wtz_scripts.js', array('jquery','wtz_script1','wtz_script2','wtz_script4'), '1.0');
if (is_home() or is_front_page()) {
	wp_enqueue_script ( 'wtz_script6', $path.'js/wtz_home_scripts.js', array('jquery','wtz_script1','wtz_script2','wtz_script4', 'wtz_script5'), '1.0');
}
	wp_enqueue_script ( 'wtz_script7', $path.'js/jquery.effects.core.js', array('jquery'), '1.0');
	wp_enqueue_script ( 'wtz_script8', $path.'js/jquery.effects.slide.js', array('jquery'), '1.0');
	wp_enqueue_script ( 'wtz_script9', $path.'js/jquery.easing.1.3.js', array('jquery'), '1.0');
/*?><script src="js/jquery.js" language="javascript"></script>
<script src="<?echo $path?>js/jquery_003.js" language="javascript"></script>
<script src="<?echo $path?>js/jquery_004.js" language="javascript"></script>
<script src="<?echo $path?>js/other.js" language="javascript"></script>
<script src="<?echo $path?>js/flashScroller.js" language="javascript"></script>
<?*/?>
	<!-- wtz scripts-->
<?
}
$sidebar = array(
'name'          => 'Right bar',
'id'            => 'sidebar-right',
'description'   => '',
'before_widget' => '<div class="divider">',
'after_widget'  => '</div>',
'before_title'  => '<h3>',
'after_title'   => '</h3>' );
register_sidebar($sidebar);

$sidebar = array(
'name'          => 'Bottom widget area',
'id'            => 'sidebar-bottom',
'description'   => '',
'before_widget' => '<div class="bootm-widgets">',
'after_widget'  => '</div>',
'before_title'  => '<h3>',
'after_title'   => '</h3>' );
register_sidebar($sidebar);

$sidebar = array(
'name'          => 'Footer widgets',
'id'            => 'footer-widgets',
'description'   => '',
'before_widget' => '<div class="footer-widgets">',
'after_widget'  => '</div>',
'before_title'  => '<h2>',
'after_title'   => '</h2>' );
register_sidebar($sidebar);

function wtz_testimonials_widget(){
	$projects = simple_portfolio_get_projects();// taxonomy slug is taken from wp_terms

	if (sizeof($projects)>0) {

		$positions = array();
	foreach ($projects as $post){
	//setup_postdata($post);
	$position = trim(get_post_meta($post->ID,'portfolio_position',true));
	if ($position != NULL and $position != '') {
		$positions[] = $position;
	} else $positions[] = '9999999';
	}
		asort($positions);
?>
						<div class="testimonials divider">
                            <h4>Client testimonials</h4>
                            <div id="testimonialsContent" class="testimonialsContent scrollable">
							<ul class="items">
<?php
foreach ($positions as $k=>$position):
$post = $projects[$k];
?>
								<li>
                                    <div class="quoteholder">
                                        <blockquote>
<?php echo get_post_meta($post->ID,'portfolio_testimonial',true); ?>
<a href="<?echo get_permalink($post->ID);?>" class="readMore" title="read more">[read more]</a>
										</blockquote>
                                    </div>
                                </li>
<?
endforeach;
?>
                            </ul>
                            </div>
                            <a class="prev browse left">left</a>
                            <a class="next browse right">right</a>
                        </div>

<script>
// execute your scripts when the DOM is ready. this is mostly a good habit
jq(function() {

	// initialize scrollable
	jq(".scrollable").scrollable();
	jq(".scrollable ul.items").css('display','block');

});
</script>
<?
	}
}
register_sidebar_widget('Testimonials','wtz_testimonials_widget');

function wtz_testimonials(){
$projects = simple_portfolio_get_projects();// taxonomy slug is taken from wp_terms

	if (sizeof($projects)>0) {

$positions = array();
foreach ($projects as $post){
	if(get_post_meta($post->ID,'portfolio_featured',true)){
		//setup_postdata($post);
		$position = trim(get_post_meta($post->ID,'porfolio_position',true));
		if ($position != NULL and $position != '') {
			$positions[] = $position;
		} else $positions[] = '9999999';
	}
}
		asort($positions);
		//print_r($positions);
?>
	<div class="testimonials">
                    <div class="testimonialsContainer">
                        <h2>... what do they say about us</h2>
                        <div class="testimonialsContentArea">
                            <div class="iconNav" id="iconNav">
                                <ul>
<?


foreach ($positions as $k=>$position):
	$post = $projects[$k];
	$image_media = simple_portfolio_media($post->ID, 'image');
?>
									<li>
										<a rel="<?echo $post->ID;?>">

				<?php $image_id = $image_media[0]; ?>

				<?php $image = wp_get_attachment_image_src($image_id['value'], 'thumbnail'); ?>

											<img width="96" height="34" border="0" align="" src="<?echo $image[0];?>" class="thumb">
										</a>
									</li>
<?
//}
endforeach;
?>

                                </ul>
                            </div>
                            <div class="testimonialsContent" id="testimonialsContent">
<?
foreach ($positions as $k=>$position):
$post = $projects[$k];
?>
								<div class="aTestimonial" rel="<?echo $post->ID;?>">
                                    <h2><?php echo $post->post_title; ?></h2>
                                    <a href="<?echo get_permalink($post->ID);?>" class="secondaryBtn">find out more</a>
                                    <div class="quoteholder">
                                        <blockquote>
<?php echo get_post_meta($post->ID,'portfolio_testimonial',true); ?>
										</blockquote>
                                    </div>
                                </div>
<?
//}
endforeach;
?>
                            </div>
                        </div>
                    </div>
                </div>
<?
	}
}

function wtz_content_filter($content){
	global $wtz_our_clients_page;
	return $content;
}







/*
   Newsletter Widget class
*/
class Newsletter extends WP_Widget {
/** constructor */
function Newsletter() {
	//$widget_ops = array('classname' => 'widget_text');
	$this->WP_Widget('Newsletter', __('Newsletter'));
}

function widget( $args, $instance ) {
extract($args);
$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

//echo $before_widget;

?>
<div class="newsletterSignup divider">
  <?if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
<p>To join our newsletter, just insert your email address below.</p>
  	<?php if (class_exists('ajaxNewsletter')): ?>
    <!-- place your HTML code here -->
    <?php ajaxNewsletter::newsletterForm(); ?>
    <!-- place your HTML code here -->
    <?php endif; ?>

</div>
	                <?php
//echo $after_widget;

}

function update( $new_instance, $old_instance ) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	return $instance;
}

function form( $instance ) {
$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
$title = strip_tags($instance['title']);
?>
	                <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
	                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
	<?php
}

}
add_action('widgets_init', create_function('', 'return register_widget("Newsletter");'));



function wtz_show_posts_sidebar($args){
	global $post;
	$posts = get_posts($args);

	?>
							<h2>Related articles</h2>

							<ul class="bull">
<?
foreach ($posts as $_post){
	//print_r($post);)
	setup_postdata($_post);
	//print_r($_post);
	if ($post->ID != $_post->ID) {
?>
								<li><a title="<?echo $_post->post_title?>" href="<?echo get_permalink($_post->ID);?>"><?echo $_post->post_title?></a></li>
<?
	}
}
?>
                            </ul>
	<?
}
function wtz_bottom_widgets(){
if ( is_active_sidebar( 'sidebar-bottom' ) ) :
?>
	<div class="bottom_widgets" id="bottom_wigets">
		<?dynamic_sidebar( 'sidebar-bottom' );?>
	</div>
<?
endif;
}
function wtz_pre_footer(){
	// footer menu
	wtz_bottom_widgets();
	wp_nav_menu( array(
        			'container_class' => 'footerlinks',
        			'theme_location' => 'footer',
        			'container_id' => 'footer-menu',
        			'link_before' => '',
        			'link_after' => ''
        			) );
	// FM ends
}

function wtz_show_stuff_posts($args){
	$posts = get_posts($args);


$posts_ = $posts;
$positions = array();
foreach ($posts_ as $post){
	setup_postdata($post);
	$position = trim(get_post_meta($post->ID,'position',true));
	if ($position != NULL and $position != '') {
		$positions[] = $position;
	} else $positions[] = '9999999';
}
//	print_r($positions);
//	echo "<br>";
	asort($positions);
//	print_r($positions);
	?>
                <div class="tabbedContentContainer" id="tabbedContentContainer">
                    <div class="tabbedContentNav">
                        <h2>... stuff we know about</h2>
                        <ul class="tabbedNav" id="tabbedNav">
<?foreach($positions as $k=>$position)
{
	$post = $posts[$k];
	setup_postdata($post);?>
							<li> <a title="<?echo $post->post_title?>" rel="<?echo $post->ID?>"><?echo $post->post_title?></a> </li>
<?}?>
                        </ul>
                        <p class="highlight">Contact us via our LIVE CHAT service or call us on +44 7957 459902.</p>
                    </div>
                    <div class="tabbedContent" id="tabbedContent">
<?foreach($positions as $k=>$position)
{
	$post = $posts[$k];
	setup_postdata($post);
	?>
                        <div id="stuff-<?echo $post->ID?>" rel="<?echo $post->ID?>">
						<h2 class="subTitle"><?echo $post->post_title?></h2>
                        <p>
						<?
                        //print_r($post);
                        echo $post->post_excerpt;
						?>
						</p>
                        <a class="primaryBtn" href="<?echo get_permalink($post->ID);?>">find out more</a>
						</div>
<?}?>
                    </div>
                </div>
	<?
}
function wtz_show_articles(){
$args = array(
'numberposts'     => 3,
'offset'          => 0,
'category'        => 10,
'orderby'         => 'post_date',
'order'           => 'DESC',
'post_type'       => 'post',
'post_status'     => 'publish' );
	$posts = get_posts($args);
	$articles = array();
	foreach ($posts as $post){
		$articles[] = $post;
	}
	?>
                <div class="artcles">
                    <div class="artclesContainer">
                        <div class="col1">
                            <div class="secondArticle">
<?$post = $articles[1];setup_postdata($post);?>
								<h2><?echo $post->post_title?></h2>
                                <?
                                $img = get_the_post_thumbnail();
                                $img = str_replace('class="', 'class="thumb ', $img);
                                echo $img;
                                ?>
                                <p><?echo $post->post_excerpt;?> <a class="fltRht readMore" href="<?echo get_permalink($post->ID);?>">[read more]</a></p>
                            </div>
                            <div class="thirdArticle">
<?$post = $articles[2];setup_postdata($post);?>
                                <h2><?echo $post->post_title?></h2>
                                <?
                                $img = get_the_post_thumbnail();
                                $img = str_replace('class="', 'class="thumb ', $img);
                                echo $img;
                                ?>
                                <p><?echo $post->post_excerpt;?> <a class="fltRht readMore" href="<?echo get_permalink($post->ID);?>">[read more]</a></p>
                            </div>
                        </div>
                        <div class="col2">
                            <div class="mainArticle">
<?$post = $articles[0];setup_postdata($post);?>
                                <h2><?echo $post->post_title?></h2>
                                <?
                                $img = get_the_post_thumbnail();
                                $img = str_replace('class="', 'class="thumb ', $img);
                                echo $img;
                                ?>
                                <p><?echo $post->post_excerpt;?> <a class="fltRht readMore" href="<?echo get_permalink($post->ID);?>">[read more]</a></p>
                            </div>

                        </div>
                    </div>
                </div>
	<?
}

function wtz_latest_news($cat,$num = 10,$content = false,$title="... latest news")
{

$args = array(
'numberposts' => $num,
'orderby' => 'date',
'order' => 'DESC',
'category_name' => $cat
);
$lastposts = get_posts($args);
echo "
<div class=\"newsArea\">
	<h2>$title</h2>
	<ul class=\"bull\">";
//echo "<p>".$cat."</p>";
if ($lastposts) {
foreach ($lastposts as $post) {
setup_postdata($post);
if ($content == false)
{?>
		<li><a href="<? echo get_permalink($post->ID);?>"><? echo $post->post_title;?></a></li>
		<?
} else
{
	$cat = get_category(get_category_by_slug($cat));
	echo "<h3><a href=\"".get_permalink($post->ID)."\">$post->post_title</a></h3><p>$post->post_content</p><p><a href=\"".get_category_link($cat->cat_ID)."\" class=\"archive\">$cat->name archive</a></p>";
}
}
}
echo "
	</ul>
</div>";
}

/*

   CONTENT FILTERING
   some userful functions made for previous projects
*/

add_filter('the_content', 'wtz_filter_content');


function wtz_filter_content($content)
{
global $wpdb,$post;

	$exprs = array('[projects]'); // to find
	foreach ($exprs as $expr)
	{
		$content = str_ireplace($expr, wtz_our_clients(), $content);

	}
	// filtering the content area of post
	if (isset($post) and $post->post_type=='portfolio') {
		$content = wtz_portfolio_show($post->ID).$content;
	}
	return $content;
}

function wtz_our_clients(){
//select all projects
$projects = simple_portfolio_get_projects();// taxonomy slug is taken from wp_terms

	//if there're any projects were selected
	if (sizeof($projects)>0) {

	$positions = array();
	foreach ($projects as $post){
	$position = trim(get_post_meta($post->ID,'portfolio_position',true));
	if ($position != NULL and $position != '') {
		$positions[] = $position;
	} else $positions[] = '9999999';
	}
		asort($positions);

$result = '';
$result .= '
		<div class="demo">

          <form id="filter">
        		<fieldset>
        			<legend>Filter by client</legend>
        			<label><input type="radio" name="type" value="all" checked="checked">All</label>
';

$categories = simple_portfolio_get_categories();
foreach ($categories as $cat){
$result .= '
					<label><input type="radio" name="type" value="'.$cat->slug.'">'.$cat->name.'></label>
';
}
$result .= '
				</fieldset>

        	</form>
';

$result .= '
		<ul id="applications" class="image-grid">
';

foreach ($positions as $k=>$position):
	$post = $projects[$k];
	$image_media = simple_portfolio_media($post->ID, 'image');
	//$text_media = simple_portfolio_media(get_the_ID(), 'text');
	$permalink = get_permalink($post->ID);
	$image_id = $image_media[0];
	$image = wp_get_attachment_image_src($image_id['value'], 'thumbnail');
	$categories = simple_portfolio_get_categories($post->ID);
	$cat_names = array();
foreach ($categories as $cat){
	$cat_names[] = $cat->slug;
}
	$cat_names = implode(', ', $cat_names);

$result .= '
			<li data-id="id-'.$k.'" data-type="'.$cat_names.'">
              <a href="'.$permalink.'">
			  <img width="96" height="34" border="0" align="" src="'.$image[0].'">
			  </a>
              <strong>'.$post->post_title.'</strong>
            </li>
';

endforeach;

$result .= '
		</ul>

    </div>
';

$path = get_bloginfo('template_url').'/';
?>
      	<script type='text/javascript' src='<?echo $path?>js/jquery.quicksand.js'></script>
        <script type="text/javascript">
var $ = jQuery.noConflict();
          // Custom sorting plugin
          (function($) {
          	$.fn.sorted = function(customOptions) {
          		var options = {
          			reversed: false,
          			by: function(a) { return a.text(); }
          		};
          		$.extend(options, customOptions);
          		$data = $(this);
          		arr = $data.get();
          		arr.sort(function(a, b) {
          		   	var valA = options.by($(a));
          		   	var valB = options.by($(b));
          			if (options.reversed) {
          				return (valA < valB) ? 1 : (valA > valB) ? -1 : 0;
          			} else {
          				return (valA < valB) ? -1 : (valA > valB) ? 1 : 0;
          			}
          		});
          		return $(arr);
          	};
          })(jQuery);

          // DOMContentLoaded
          $(function() {

            // bind radiobuttons in the form
          	var $filterType = $('#filter input[name="type"]');
          	var $filterSort = $('#filter input[name="sort"]');

          	// get the first collection
          	var $applications = $('#applications');

          	// clone applications to get a second collection
          	var $data = $applications.clone();

            // attempt to call Quicksand on every form change
          	$filterType.add($filterSort).change(function(e) {
          		if ($($filterType+':checked').val() == 'all') {
          			var $filteredData = $data.find('li');
          		} else {
          			//var $filteredData = $data.find('li[data-type=' + $($filterType+":checked").val() + ']');
          			var $filteredData = $data.find('li[data-type*=' + $($filterType+":checked").val() + ']');
          		}

              // if sorted by size
          		if ($('#filter input[name="sort"]:checked').val() == "size") {
          			var $sortedData = $filteredData.sorted({
          				by: function(v) {
          					return parseFloat($(v).find('span[data-type=size]').text());
          				}
          			});
          		} else {
          		// if sorted by name
          			var $sortedData = $filteredData.sorted({
          				by: function(v) {
          					return $(v).find('strong').text().toLowerCase();
          				}
          			});
          		}

          		// finally, call quicksand
          	  $applications.quicksand($sortedData, {
          	    duration: 800,
          	    easing: 'easeInOutQuad'
          	  });

          	});

          });
        </script>
<?
	} else $result = NULL;
	return $result;
}

function wtz_portfolio_show($pid){

	$image_media = simple_portfolio_media($post->ID, 'image');
	if (sizeof($image_media)>1) {
		$image_id = $image_media[1];// choosing 2nd image
		$image = wp_get_attachment_image_src($image_id['value'], 'full');
	} else $image = NULL;

	$categories = simple_portfolio_get_categories($pid);

$result = '
	<div class="portfolio-image">
		<img src="'.$image[0].'" />
	</div>
';
$result .= '
	<div class="portfolio">
	<ul class="categories">
';
	foreach ($categories as $category){
$result .= '
		<li class="'.$category->slug.'">
			'.$category->name.'
		</li>
';
	}
$result .= '
	</ul>
	</div>
';
	//print_r($categories);

	return $result;
}











/**
 * TwentyTen functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, twentyten_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyten_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Ten

 * @since Twenty Ten 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
/*
if ( ! isset( $content_width ) )
	$content_width = 640;
*/

/** Tell WordPress to run twentyten_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'twentyten_setup' );

if ( ! function_exists( 'twentyten_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentyten_setup() in a child theme, add your own twentyten_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

/*
	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'twentyten', TEMPLATEPATH . '/languages' );


	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
*/
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'twentyten' ),
		'footer' => __( 'Footer Navigation', 'twentyten' ),
	) );



}
endif;



/*



					Twenty ten theme functions which i don't need'




*/
if ( ! function_exists( 'twentyten_admin_header_style' ) ) :
/**

 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in twentyten_setup().
 *
 * @since Twenty Ten 1.0
 */
function twentyten_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
//add_filter( 'wp_page_menu_args', 'twentyten_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function twentyten_excerpt_length( $length ) {
	return 40;
}
//add_filter( 'excerpt_length', 'twentyten_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function twentyten_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' ) . '</a>';
}

/**

 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyten_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function twentyten_auto_excerpt_more( $more ) {
	return ' &hellip;' . twentyten_continue_reading_link();
}
//add_filter( 'excerpt_more', 'twentyten_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function twentyten_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= twentyten_continue_reading_link();
	}
	return $output;
}
//add_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css.
 *
 * @since Twenty Ten 1.0
 * @return string The gallery style filter, with the styles themselves removed.
 */
function twentyten_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );

}
//add_filter( 'gallery_style', 'twentyten_remove_gallery_css' );

if ( ! function_exists( 'twentyten_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_comment( $comment, $args, $depth ) {
$GLOBALS['comment'] = $comment;
switch ( $comment->comment_type ) :
case '' :
?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'twentyten' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'twentyten' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
			/* translators: 1: date, 2: time */
			printf( __( '%1$s at %2$s', 'twentyten' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
	break;
	case 'pingback'  :
	case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyten' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'twentyten'), ' ' ); ?></p>
	<?php
break;
endswitch;
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override twentyten_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Twenty Ten 1.0
 * @uses register_sidebar
 */
function twentyten_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'twentyten' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Secondary Widget Area', 'twentyten' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'twentyten' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'twentyten' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'twentyten' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 6, located in the footer. Empty by default.
	register_sidebar( array(

		'name' => __( 'Fourth Footer Widget Area', 'twentyten' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
/** Register sidebars by running twentyten_widgets_init() on the widgets_init hook. */
//add_action( 'widgets_init', 'twentyten_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *

 * @since Twenty Ten 1.0
 */
function twentyten_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
//add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );

if ( ! function_exists( 'twentyten_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'twentyten' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
			get_the_author()

		)
	);
}
endif;

if ( ! function_exists( 'twentyten_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {

		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,

		get_permalink(),
		the_title_attribute( 'echo=0' )

	);
}
endif;

?>