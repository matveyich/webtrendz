<?php
/**
 * @package WordPress
 * @subpackage Logic theme
 */

get_header(); ?>

<script src="<? bloginfo('template_url');?>/js/jquery.logic.innerpage.js"></script>

	<div class="contentArea" id="col2">
		
		<div class="subNavCol">
        	<div class="container submenu">
<?
$page = get_page($post->ID);
$parent = get_page($page->post_parent);
?>
			<!--<h2><?echo $parent->post_title;?></h2>-->
<ul>
<?
if ($page->post_parent == 0) $child_of = $post->ID;
else $child_of = $page->post_parent;
wp_list_pages("title_li=&child_of=".$child_of);
?>
</ul>
            </div>          
    	</div>
		
		<div class="leftCol">
        	<div class="container">
                <div class="welcomeArea">
                   <div class="pageHeader">
				   		<h1><?php the_title(); ?></h1>
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
		</div>
<? get_sidebar(); ?>		
	</div>

<?php get_footer(); ?>
