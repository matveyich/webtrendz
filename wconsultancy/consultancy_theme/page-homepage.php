<?php
/**
Template name: homepage
 */

get_header(); ?>

<div class="contentAreaContainer">
            <h2 class="pageTitle">... recently completed web projects</h2>
            <div class="bannerArea">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<? the_content();?>
<?php endwhile; endif; ?>
            </div>
            <div class="contentArea">
<?
	wtz_show_stuff_posts('category=7&numberposts=0');
?>
<?
	wtz_testimonials();
?>
<?
	wtz_show_articles();
?>
<?
wtz_pre_footer();
?>
            </div>
        </div>

<?php get_footer(); ?>
