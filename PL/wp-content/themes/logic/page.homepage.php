<?php
/*
Template Name: homepage
*/

/**
 * @package WordPress
 * @subpackage Logic theme
 */

get_header(); ?>

<script src="<? bloginfo('template_url');?>/js/jquery.logic.homepage.js"></script>

	<div class="contentArea">
		
<?
/* WTZ 
this gets image gallery from homepage gallery and puts it into carousel
*/
$wplink = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_select_db(DB_NAME,$wplink);
// query
$query = "SELECT gid FROM ".$wpdb->nggallery." WHERE title = 'homepage gallery' LIMIT 0,1;";
$result = mysql_query($query, $wplink); echo mysql_error($wplink);
$row = mysql_fetch_array($result);

if (function_exists('nggShowGallery')) echo nggShowGallery($row['gid'], "home"); else echo "no nggShowGallery function";
/*WTZ */
?>	
		
		<div class="leftCol1 mrgTop">
        	<div class="container">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>			
                <div class="welcomeArea">
                    <!--<h1><?php the_title(); ?></h1>-->
                    <?php 
					#p75GetThumbnail($post->ID);
					the_content(); ?>
                </div>
<?php endwhile; endif; ?>				

                <div class="multiArea mrgTop">
<? if (function_exists('dynamic_sidebar')) dynamic_sidebar("Homepage posts"); ?>						
                </div>

				<div class="Blog mrgTop">
<? if (function_exists('dynamic_sidebar')) dynamic_sidebar("Blog posts"); ?>	

                </div>
               
                
                <div class="topEarners mrgTop">
<? if (function_exists('top_earners')) top_earners(); ?>	                  
                    </div>
                </div>
		</div>
<? get_sidebar(); ?>
	</div>

<?php get_footer(); ?>
