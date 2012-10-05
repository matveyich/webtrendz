<?php
/**
 * @package WordPress
 * @subpackage Castles_Theme
 */

$content_width = 450;

automatic_feed_links();

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'header bar',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2 class="header_title">',
		'after_title' => '</h2>',
	));
	register_sidebar(array(
		'name' => 'highlights',
		'before_widget' => '<div class="highlight fltRht">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
	register_sidebar(array(
		'name' => 'bottom bar',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2 class="bottom_title">',
		'after_title' => '</h2>',
	));
	register_sidebar(array(
		'name' => 'top bar',
		'before_widget' => '<div class="highlight fltRht">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="latest_news_title">',
		'after_title' => '</h2>',
	));
}
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
function show_top_gallery($name, $template) {
global $wpdb;
// query
$query = "SELECT gid FROM ".$wpdb->nggallery." WHERE title = '".$name."' LIMIT 0,1;";
$row = $wpdb->get_results($query);
echo mysql_error();

if (function_exists('nggShowGallery')) echo nggShowGallery($row[0]->gid, $template); else echo "no nggShowGallery function";

}