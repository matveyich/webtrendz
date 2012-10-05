<?php
/**
 * Template Name: video page
 */

get_header(); 
?>
			
<div class="contentContainer supCol">				
	<div class="contentArea">
		<div class="youTubeVideo">
			<?mpg_video_banner();?>
		</div>
		<div class="breadcrumb">
			<?mpg_breadcrumbs()?>
        </div>
		<?get_template_part( 'loop', 'index' );?>
	
		<?//get_sidebar('services');?>
	
	</div>
	<?get_sidebar('see-also');?>
</div>
		

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
