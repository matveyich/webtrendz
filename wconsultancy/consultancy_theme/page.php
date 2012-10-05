<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

	<div class="contentAreaContainer">

            <div class="contentArea">

				<div class="pageContainer">
                    <div class="col1">
                        <div class="mainArticle">
                            <h2><?php the_title(); ?></h2>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


			<div class="entry">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

			</div>

		<?php endwhile; endif; ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

	<?php //comments_template(); ?>
                        </div>
                    </div>
  <?php get_sidebar('sidebar'); ?>
                </div>

<?
wtz_pre_footer();
?>

			</div>

		</div>

<?php get_footer(); ?>
