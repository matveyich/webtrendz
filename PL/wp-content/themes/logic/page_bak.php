<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

get_header(); ?>

<script src="<? bloginfo('template_url');?>/js/jquery.logic.subpage.js"></script>


	<div class="contentArea" id="col3">
		
		<div class="subNavCol">
        	<div class="container submenu">
			<!--<h2><?echo $post->post_title;?></h2> -->
<ul>
<?wp_list_pages("title_li=&child_of=".$post->ID);?>
</ul>
            </div>          
    	</div>
		
		<div class="leftCol">
        	<div class="container">
                   <div class="pageHeader">
				   		<h1><?php the_title();?></h1>
				   </div>
                    
					<div class="contentContainer">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	
			<div class="entry">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

			</div>

		<?php endwhile; endif; ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	
	<?php comments_template(); ?>					
					</div>
            </div>
                
		</div>
<? get_sidebar(); ?>
	</div>

<?php get_footer(); ?>
