<?php
/*
   Plugin Name: WTZ plugin
   Plugin URI:
   Description: Does some stuff.
   Version: 1
   Author: Matvienko Ilya
   Author URI:
*/

/*

   ADMIN FILTERING

*/
add_action('admin_menu', 'wtz_admin_menu');
add_action('admin_footer', 'wtz_init_plugin');


function wtz_admin_menu(){

if ( function_exists('add_menu_page') )
{
	//add_menu_page( 'Gallery export', 'Gallery export', 'activate_plugins', 'gallery-export', 'wtz_gallery_export' );
}
}
function wtz_init_plugin(){
	if (isset($_GET['page']) and $_GET['page']=='nggallery-manage-gallery') {
			$gid = $_GET['gid'];
		if (nggcf_get_gallery_field($gid, 'exportable')=='yes') {
			//wtz_do_export_gallery($gid);
			// currently disabled, as we use piecemaker2 plugin
		}
		}
}
function wtz_do_export_gallery($gid){
	global $wpdb;
	$XML_start = '<?xml version="1.0" encoding="utf-8"?>
<Piecemaker>
  <Settings>
    <imageWidth>850</imageWidth>
    <imageHeight>261</imageHeight>
    <segments>10</segments>
    <tweenTime>1.2</tweenTime>
    <tweenDelay>0.1</tweenDelay>
    <tweenType>easeInOutBack</tweenType>
    <zDistance>0</zDistance>
    <expand>10</expand>
    <innerColor>0x46A8F8</innerColor>
    <textBackground>0x46A8F8</textBackground>
    <shadowDarkness>200</shadowDarkness>
    <textDistance>25</textDistance>
    <autoplay>12</autoplay>
  </Settings>
';
	$XML_end = '</Piecemaker>
';
	$XML_file = 'piecemakerXML.xml';
	if (function_exists('nggShowGallery')) $imgs = nggShowGallery($gid, "export"); else echo "no nggShowGallery function";
	//print_r($imgs);
	$fp = fopen(get_theme_root().'/'.get_template().'/'.$XML_file,'w');
	fwrite($fp, $XML_start);
	fwrite($fp, $imgs);
	fwrite($fp, $XML_end);
	fclose($fp);
	//echo get_theme_root().'/'.get_template().'/'.$XML_file;
	//print_r(file(get_theme_root().'/'.get_template().'/'.$XML_file));
}
function wtz_gallery_export()
{
	echo 'Export gallery page';
}

/*

   ADMIN FILTERING END

*/








/*

CONTENT FILTERING
some userful functions made for previous projects
*/

add_filter('the_content', 'wtz_filter_content');

function wtz_filter_content($content)
{

	$exprs = array('/\[accordion([\s]+)([a-zA-Z0-9_]+)\]/', '/\[last-post([\s]+)([a-zA-Z0-9_-]+)\]/', "/\[category='(.+)'\]/"); // to find
	foreach ($exprs as $expr)
	{

		if (preg_match_all($expr, $content, $params,PREG_PATTERN_ORDER))
		{
			//print_r($params);
			foreach ($params[2] as $param)
			{
				switch ($expr)
				{
					case '/\[accordion([\s]+)([a-zA-Z0-9_]+)\]/':
						$content = str_replace("[accordion $param]", pl_parse_params($param), $content);
						break;
					case '/\[last-post([\s]+)([a-zA-Z0-9_-]+)\]/':
						$content = str_replace("[last-post $param]",last_posts($param,1,true),$content);
						break;
					case "/\[category='(.+)'\]/":
						$content = str_replace("[last-post $param]",last_posts($param,1,true),$content);
						break;
				}
			}
		}

	}
	return $content;
}

function wtz_show_featured($cat,$feat = 'featured'){
	global $wpdb,$table_prefix;
	$select = $wpdb->get_results('select ID from '.$table_prefix.'posts p inner join '.$table_prefix.'term_relationships t on p.ID = t.object_id left join '.$table_prefix.'terms ts on t.term_taxonomy_id = ts.term_id where ts.slug = \''.$cat.'\' ');
	$select1 = array();
	foreach($select as $_select){
		$select1[] = $_select->ID;
	}
	$select = $wpdb->get_results('select ID from '.$table_prefix.'posts p inner join '.$table_prefix.'term_relationships t on p.ID = t.object_id left join '.$table_prefix.'terms ts on t.term_taxonomy_id = ts.term_id where ts.slug = \''.$feat.'\' ');
	$select2 = array();
	foreach($select as $_select){
		$select2[] = $_select->ID;
	}
	$ids = array_intersect($select1, $select2);
	$previews = '<div class="ngg-galleryoverview">';
	foreach($ids as $id){
		$post = get_post($id);
		setup_postdata($post);
		$previews .= '
	<div class="ngg-gallery-thumbnail clear">
		<div class="post-title"><a href=\''.get_permalink($post->ID).'\'>'.$post->post_title.'</a></div>
		<div class="post-excerpt">'.$post->post_excerpt.'</div>
		<div class="post-thumbnail"><a href=\''.get_permalink($post->ID).'\'>'.get_the_post_thumbnail().'</a></div>
		<div class="post-readmore"><a href=\''.get_permalink($post->ID).'\' class="read-more">Read more</a></div>
	</div>';
	}
	$previews .= '</div>';
	return $previews;
}

function wtz_show_posts($category){
	global $wpdb,$post;
	$args = array(
		'category_name' => $category,
		'numberposts' => -1
);
	$cat = get_the_category();

	$_in_arr = false; // this variable says whether one of the categories of a post is in array of castles_categories
	foreach($cat as $_cat){
	//	if (in_array($_cat->slug,$castles_categories) and $_in_arr == false) {
			$_in_arr = true;
			$_slug = $_cat->slug;
	//	}
	}

	if ($_in_arr == true and is_single()) {
		$args['exclude'] = $post->ID;
	}

	$posts = get_posts($args);
	$previews = '<div class="ngg-galleryoverview">';
	foreach ($posts as $post){
		setup_postdata($post);
		//print_r($post);
		$previews .= '
	<div class="ngg-gallery-thumbnail clear">
		<div class="post-title"><a href=\''.get_permalink($post->ID).'\'>'.$post->post_title.'</a></div>
		<div class="post-excerpt">'.$post->post_excerpt.'</div>
		<div class="post-thumbnail"><a href=\''.get_permalink($post->ID).'\'>'.get_the_post_thumbnail().'</a></div>
		<div class="post-readmore"><a href=\''.get_permalink($post->ID).'\' class="read-more">Read more</a></div>
	</div>';
		//echo $post->the_title.'<br>';
	}
	$previews .= '</div>';
	return $previews;
}

function last_posts_by_cat_id_featured($cat_id,$num = 10)
{

$args = array(
		'numberposts' => $num,
		'orderby' => 'date',
		'order' => 'DESC',
		'category' => "12,$cat_id",
	);
$lastposts = get_posts($args);
echo "<div>";
//echo "<p>".$cat."</p>";
if ($lastposts) {
foreach ($lastposts as $post) {
setup_postdata($post);
?>
		<p><a href="<? echo get_permalink($post->ID);?>"><? echo $post->post_title;?></a></p>
		<?
}
}
echo "</div>";
}

function latest_news($cat,$num = 10,$content = false,$title="... latest news")
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
function last_posts($cat,$num = 10,$content = false)
{

$args = array(
'numberposts' => $num,
'orderby' => 'date',
'order' => 'DESC',
'category_name' => $cat
);
$lastposts = get_posts($args);
echo "<div>";
//echo "<p>".$cat."</p>";
if ($lastposts) {
foreach ($lastposts as $post) {
setup_postdata($post);
if ($content == false)
{?>
		<p><a href="<? echo get_permalink($post->ID);?>"><? echo $post->post_title;?></a></p>
		<?
} else
{
	$cat = get_category(get_category_by_slug($cat));
	echo "<h3><a href=\"".get_permalink($post->ID)."\">$post->post_title</a></h3><p>$post->post_content</p><p><a href=\"".get_category_link($cat->cat_ID)."\" class=\"archive\">$cat->name archive</a></p>";
}
}
}
echo "</div>";
}

function last_posts_accordion($cat,$num = 0)
{

$args = array(
'numberposts' => $num,
'orderby' => 'date',
'order' => 'DESC',
'category_name' => $cat
);
$lastposts = get_posts($args);
echo "<ul id=\"accordion_$cat\" class=\"accordion\">";
//echo "<p>".$cat."</p>";
if ($lastposts) {
foreach ($lastposts as $post) {
setup_postdata($post);
?>
		<li>
		<h2><? echo $post->post_title;?></h2>
		<p class="pane">
		<?echo $post->post_content;?>
		</p>
		</li>
		<?
}
}
echo "</ul>";
?>
<script>
jq(function() {

jq("#accordion<?echo "_$cat";?> p.pane").each(function(index) {jq(this).height(jq(this).height());});// устанавливаем высоту каждой ячейки
jq("#accordion<?echo "_$cat";?> p.pane").css('display','none'); // сворачиваем все ячейки
jq("#accordion<?echo "_$cat";?> h2").click(function(){
var index = jq(this).parent("li").eq();// кажется можно закомнетить это
//jq("#accordion<?echo "_$cat";?> li.open p.pane").slideUp(300);
//jq("#accordion<?echo "_$cat";?> li.open p.pane").not(jq(this).parent().children('p.pane')).css('display','none');
jq("#accordion<?echo "_$cat";?> li.open p.pane").not(jq(this).parent().children('p.pane')).slideUp(600); // закрываем текущий открытый блок при нажатии на его заголовке
jq("#accordion<?echo "_$cat";?> li.open").not(jq(this).parent()).toggleClass('open');// переключаем класс его открытости
jq("#accordion<?echo "_$cat";?> li h2.current").not(jq(this)).toggleClass('current');// переключаем класс того, что он текущий открытый
if(jq(this).parent("li").children("p.pane").css('display') == 'none') // если блок скрыт
{
jq(this).parent("li").children("p.pane").slideDown(600); // открываем его
//jq(this).parent("li").children("p.pane").css('display','block');
}
	else {
    jq(this).parent("li").children("p.pane").slideUp(600); // закрываем если он открыт
    //jq(this).parent("li").children("p.pane").css('display','none');
    }
jq(this).toggleClass('current'); // переключаем класс
jq(this).parent("li").toggleClass('open'); // переключаем класс его родителя

});
/*
jq("#accordion<?echo "_$cat";?>").tabs("#accordion<?echo "_$cat";?> p.pane", {tabs: 'h2', effect: 'slide', initialIndex: -1, onClick: function(tabIndex){
var currPane = this.getCurrentPane();
currPane.click(function(){
jq(this).slideUp(300);
});
}});
*/
// additional open/close on click
/*
jq("#accordion<?echo "_$cat";?> .current").click(function(){
jq(this).removeClass('current').parent().removeClass('open').children('.pane').slideUp(300);});*/
});
</script>
<script>

// add new effect to the tabs
/*
jq.tools.tabs.addEffect("slide", function(i, done) {

	// 1. upon hiding, the active pane has a ruby background color
	this.getPanes().slideUp(300,function()  {
		jq(this).parent().removeClass('open');

		// the supplied callback must be called after the effect has finished its job
		done.call();
	});

	// 2. after a pane is revealed, its background is set to its original color (transparent)
	this.getPanes().eq(i).slideDown(600,function()  {
		jq(this).parent().addClass('open');

		// the supplied callback must be called after the effect has finished its job
		done.call();
	});

  	/*this.getPanes().eq(i).click(function() {
    jq(this).parent().removeClass('open');
    jq(this).slideUp(300);
    onClick.call();
  }); */
/*
}); */
</script>
	<?
}
function last_posts_ext($cat,$num = 10)
{

$args = array(
'numberposts' => $num,
'orderby' => 'date',
'order' => 'DESC',
'category_name' => $cat
);
$lastposts = get_posts($args);
echo "<div>";
//echo "<p>".$cat."</p>";
if ($lastposts) {
foreach ($lastposts as $post) {
setup_postdata($post);
?>
			<p class="tabs_post_date"><a href="<? echo get_permalink($post->ID);?>"><?echo $post->post_title;?></a><?//echo date("jS M Y",strtotime($post->post_date));#the_date("jS M Y");?></p>
			<?
			if($_src = p75GetThumbnail(get_the_ID()))
			{
			?>
<p class="tabs_post_pic"><a href="<? echo get_permalink($post->ID);?>"><img src="<?echo $_src;?>" /></a>
<?
}
?>
			<p class="tabs_post_excerpt"><?echo $post->post_excerpt;?><br><a href="<? echo get_permalink($post->ID);?>">More</a></p>

		<?
}
}
echo "</div>";
}
/*

   CONTENT FILTERING END

*/
?>