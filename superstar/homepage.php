<?php
/*
Template Name: Homepage
*/
get_header();
?>
<?php
get_sidebar();
?>
<!-- Cell with the main content-->
<td style="vertical-align:top;padding:10px;">
<? if (function_exists('dynamic_sidebar')) dynamic_sidebar("main gallery sidebar"); ?>	
<!--PostContent-->		  
<div>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="post" id="post-<?php the_ID(); ?>">

<div class="storycontent">
<?php the_content(__('(more?)')); ?>
</div>

</div> <!?closing .post ?>
<?php endwhile; else: ?>

<?php endif; ?>
<? if (function_exists('dynamic_sidebar')) dynamic_sidebar("special offers sidebar"); ?>	
<? if (function_exists('dynamic_sidebar')) dynamic_sidebar("homepage bottom sidebar"); ?>	

</div>
</td>
<!--EndOfPostContent-->
</tr>
<?php get_footer(); ?>





