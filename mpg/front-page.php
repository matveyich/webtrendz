<?php
/**
 * Template Name: homepage
 */

get_header(); 
?>
<div class="contentContainer">				
	<div class="scrollerArea">
	<?mpg_front_page_gallery();?>
	</div>
	<div class="contentArea">
		<?get_template_part( 'loop', 'index' );?>
	
		<?get_sidebar('services');?>
	
	</div>
</div>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
