<?php
/**
Template name: homepage
 */

get_header(); ?>


			<div id="content">
<?
/* WTZ 
this gets image gallery from homepage gallery and puts it into carousel
*/
$wplink = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_select_db(DB_NAME,$wplink);
// query
$query = "SELECT gid FROM ".$wpdb->nggallery." WHERE title = 'main' LIMIT 0,1;";
$result = mysql_query($query, $wplink); echo mysql_error($wplink);
$row = mysql_fetch_array($result);

if (function_exists('nggShowGallery')) echo nggShowGallery($row['gid'], "homepage"); else echo "no nggShowGallery function";
/*WTZ */
?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

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

<?php endwhile; ?>
<?if(function_exists('prf_featured_gallery')) prf_featured_gallery();?>
<?if(function_exists('prf_last_posts')) prf_last_posts('featured_news');?>
			</div><!-- #content -->


<?php get_sidebar(); ?>
<?php get_footer(); ?>
