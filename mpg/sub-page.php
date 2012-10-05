<?php
/**
 * Template Name: sub page
 */

get_header(); 
?>
			
<div class="contentContainer supCol">				
	<div class="contentArea">
		<div class="subPageBanner">
			<?mpg_subpage_banner();?>
		</div>
		<div class="breadcrumb">
			<?mpg_breadcrumbs()?>
        </div>
		<?get_template_part( 'loop', 'index' );?>
	
	
	</div>
	<?get_sidebar('see-also');?>
</div>
		

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
