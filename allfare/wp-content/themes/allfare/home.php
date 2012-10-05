<?php
/*
Template Name: homepage
*/
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

get_header(); ?>

<div class="banner">
		<div class="bannerTxt">
			<img src="<? bloginfo('template_url');?>/images/text.png" alt="We bring you the world on a plate." />
		</div>

		<div id="gallery" class="content">
					<div id="controls" class="controls"></div>

					<div class="slideshow-container">
						<div id="loading" class="loader"></div>
						<div id="slideshow" class="slideshow"></div>
					</div>
					<div id="caption" class="caption-container"></div>
		</div>
				<div id="thumbs" class="navigation">
					<ul class="thumbs noscript">
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
					</ul>
				</div>
</div>

<div class="contentArea">

<?php if ( function_exists('dynamic_sidebar') and is_active_sidebar('homepage-blocks')==true) {?>
		<div class="contentHead" id="homepage_sidebar">
		<!-- text widgets -->

 <?dynamic_sidebar('Homepage blocks');?>

		</div>
<?/*?><?*/?>
		<div class="clr"></div>
		<div class="contentFooter"></div>

<?} ?>

		<!-- featured posts -->

<?show_posts('category=7&numberposts=0&orderby=modified')?>

<?php if ( function_exists('dynamic_sidebar') and is_active_sidebar('homepage-blocks')==true) {?>
		<div class="contentHead" id="latest_sidebar">
 <?dynamic_sidebar('latest-news-blocks');?>
		</div>
		<div class="clr"></div>
		<div class="contentFooter"></div>

<?} ?>

<?show_posts('category=-7&numberposts=0','tertiaryContent');?>
</div>

<?php #get_sidebar(); ?>

<?php get_footer(); ?>
