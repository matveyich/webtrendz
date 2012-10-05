<?php
/**
 * @package WordPress
 * @subpackage Castles_Theme
 Template Name: Home page
 */

get_header(); ?>

    <div class="contentArea">
	
    	<div class="top">
        	<span class="tl"></span>
        </div>

        <div class="mid">
        	<div class="contentContainer">		

			<div class="topContentContainer">
<?
if (function_exists('show_top_gallery')) show_top_gallery("homepage gallery", "top");
?>			
			</div>
<?
//Highlight msg
if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('top bar') ) : endif;
//Highlight msg
if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('highlights') ) : endif;
?>			

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

				<?php #wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
	
		<?php endwhile; endif; ?>
	<?php #edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	
	<?php comments_template(); ?>
            
			</div>
        </div>	
		
		<div class="bot">
        	<span class="bl"></span>
        </div>
		
	</div>

<?php #get_sidebar(); ?>

<?php get_footer(); ?>
