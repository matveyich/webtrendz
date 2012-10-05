<?php
get_header();
?>
<?php
get_sidebar();
?>
<!-- Cell with the main content-->
<td style="vertical-align:top;padding:10px;">
<?
/* WTZ 
this gets image gallery from homepage gallery and puts it into carousel
*/
$wplink = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_select_db(DB_NAME,$wplink);
// query
$query = "SELECT gid FROM ".$wpdb->nggallery." WHERE title = 'main gallery' LIMIT 0,1;";
$result = mysql_query($query, $wplink); echo mysql_error($wplink);
$row = mysql_fetch_array($result);

if (function_exists('nggShowGallery')) echo nggShowGallery($row['gid'], "main"); else echo "no nggShowGallery function";
/*WTZ */
?>
<!--PostContent-->		  
<div style="display:table">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="post" id="post-<?php the_ID(); ?>">

<div class="storycontent">
<?php the_content(__('(more?)')); ?>
</div>

</div> <!?closing .post ?>
<?php endwhile; else: ?>

<p>
<?php _e('Sorry, no posts matched your criteria.'); ?>
</p>
<?php endif; ?>
<?php posts_nav_link(' ? ', __('? ?????????? ????????'), __('????????? ???????? ?')); ?>
</div>
</td>
<!--EndOfPostContent-->
</tr>
<?php get_footer(); ?>





