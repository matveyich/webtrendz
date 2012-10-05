<?php
/**
 * The Sidebar containing the primary and secondary widget areas.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>

 					<div class="col2">
<?php
 					/* When we call the dynamic_sidebar() function, it'll spit out
 					   * the widgets for that widget area. If it instead returns false,
 					   * then the sidebar simply doesn't exist, so we'll hard-code in
 					   * some default sidebar stuff just in case.
 					*/
?>
<?
if (!is_page()) {
	?>


                        <div class="relatedArticles">
                            <?
$category = get_the_category($post->ID);
//print_r($category);

$categories = array();
foreach ($category as $cat){
	$categories[] = $cat->term_id;
}
$category = implode(',',$categories);
//print_r($category);

$args = array(
'numberposts'     => 0,
'offset'          => 0,
'category'        => $category,
'orderby'         => 'post_date',
'order'           => 'DESC',
'post_type'       => 'post',
'post_status'     => 'publish' );
							wtz_show_posts_sidebar($args);


                            ?>
                        </div>
	<?
}
?>
<?
dynamic_sidebar( 'sidebar-right' );
// end primary widget area ?>


                    </div>
