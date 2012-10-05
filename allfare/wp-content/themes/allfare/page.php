<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

get_header(); ?>

	<div class="contentArea">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="contentHead">
	<div class="com99 ">
<h2><? the_title();?></h2>

				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

	</div>
</div>
<div class="contentFooter"></div>


		<?php endwhile; endif; ?>
	<?php #edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	
	<?php #comments_template(); ?>
	
	</div>

<?php #get_sidebar(); ?>

<?php get_footer(); ?>
