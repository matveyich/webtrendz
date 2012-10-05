<?php
/*
Template Name: forum page
*/

get_header(); ?>


	<div class="ForumArea">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		
				<?php the_content(); ?>

				<?php #wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>



		<?php endwhile; endif; ?>
	<?php #edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	
	<?php #comments_template(); ?>					
     
    </div>

<?php get_footer(); ?>
