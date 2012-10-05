<?php
/*
   Plugin Name: WTZ castles
   Plugin URI:
   Description: This plugin mainly filters content area.
   Version: 1
   Author: Matvienko Ilya
   Author URI:
*/
$castles_categories = array('big-castles','small-castles','slide-castles');
add_filter('the_content', 'castles_filter_content');
function castles_filter_content($content){
global $castles_categories;
	if (!is_admin()) {
	$cat = get_the_category();
//print_r($cat);
		$_in_arr = false; // this variable says whether one of the categories of a post is in array of castles_categories
		foreach($cat as $_cat){
			if (in_array($_cat->slug,$castles_categories) and $_in_arr == false) {
				$_in_arr = true;
				$_slug = $_cat->slug;
			}
		}
	if ($_in_arr == true) {

			$content .= castles_show_posts($_slug);

		} else {


	preg_match_all("/\[castles='(.+)'\]/",$content,$matches);
//	print_r($match);
//		$var = get_wpsi('array=1&number=-1&type=single');

		//print_r($var);

foreach($matches[1] as $k=>$match)
	{
		if (is_home() or is_front_page()) {
			$content = str_replace($matches[0][$k],castles_show_featured($match),$content);
		} else $content = str_replace($matches[0][$k],castles_show_posts($match),$content);
	}
	}
	}
	return $content;
}

function castles_show_featured($cat,$feat = 'featured-castles'){
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

function castles_show_posts($category){
	global $wpdb,$castles_categories,$post;
	$args = array(
		'category_name' => $category,
		'numberposts' => -1
);
	$cat = get_the_category();

	$_in_arr = false; // this variable says whether one of the categories of a post is in array of castles_categories
	foreach($cat as $_cat){
		if (in_array($_cat->slug,$castles_categories) and $_in_arr == false) {
			$_in_arr = true;
			$_slug = $_cat->slug;
		}
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


?>