<?php

/**
Template name: blogposts
 */


get_header(); ?>


<div id="content">


<?php
//query_posts(array('category__not_in' => array(6,7,8)));

$query = array (
	'tag__not_in' => array(6,7,8)
);

$queryObject = new WP_Query($query);
// The Loop...
if ($queryObject->have_posts()) {
	while ($queryObject->have_posts()) {
		$queryObject->the_post();
?>
				<div id="post-<?php the_ID(); ?>" <?php //post_class(); ?>>
					<?php
					/*
					   if ( is_front_page() ) { ?>
					   <h2 class="entry-title"><?php the_title(); ?></h2>
					   <?php } else { ?>
					   <h2 class="entry-title"><?php the_title(); ?></h2>
					   <?php }
					*/
					?>


						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>

				</div><!-- #post-## -->

				<?php //comments_template( '', true ); ?>
<?
	}
}
/*
if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php //post_class(); ?>>
					<?php
					/*
					if ( is_front_page() ) { ?>
						<h2 class="entry-title"><?php the_title(); ?></h2>
					<?php } else { ?>
						<h2 class="entry-title"><?php the_title(); ?></h2>
					<?php }
					*/
					?>


						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>

				</div><!-- #post-## -->

				<?php //comments_template( '', true ); ?>

<?php endwhile;
//wp_reset_query();
*/
?>

</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
