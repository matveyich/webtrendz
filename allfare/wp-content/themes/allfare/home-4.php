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

 <?php //rewind_posts(); ?>
<?php //query_posts('post_type=post'); ?>
<?php //if (have_posts()) : ?>
<?$lastposts = get_posts('numberposts=0');?>
<?php if (sizeof($lastposts)>0) : ?>
		<div class="secondaryContent">
		<div class="contentHead">
		<!-- text widgets -->

<?php //while (have_posts()) : the_post(); ?>
 <?
 foreach($lastposts as $post) :
    setup_postdata($post);
?>

			<div class="com30 gryGrad eqlHght" id="post--<?php the_ID(); ?>">
				<h2><a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				<!--<small><?php the_time('F jS, Y') ?> <!-- by <?php the_author() ?> --></small>-->

<a href="<?php the_permalink() ?>" title="Permanent Link to <?php the_title_attribute(); ?>"><img src="<?echo p75GetThumbnail(get_the_ID());?>" /></a>
				<div class="entry">
					<?php the_excerpt(); ?>
				</div>

				<!--<p class="postmetadata"><?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>-->
			</div>

		<?php //endwhile; ?>
		<?php endforeach; ?>
<!--
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>
-->
			<div class="clr"></div>

		</div>
		<div class="contentFooter"></div>
		</div>
<?php

endif; ?>
</div>

<?php #get_sidebar(); ?>

<?php get_footer(); ?>
