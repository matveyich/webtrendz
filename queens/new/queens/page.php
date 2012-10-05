<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the wordpress construct of pages
 * and that other 'pages' on your wordpress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>


			<div id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php //post_class(); ?>>
					<?php if ( is_front_page()) { /*?>
						<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php*/ 
					} elseif(function_exists('pr_init_') and (is_page($pr_slug) || is_page($pr_newsletter_slug) || is_page($pr_user_properties_slug) || is_page($pr_user_downloads_slug) || is_page($pr_tennant_slug))) { 
					}
					elseif(function_exists('wpmem') and is_page('my-account')){
					
					}
					else {?>	
						<h1 <?/*?>class="entry-title"<?*/?>><?php the_title(); ?></h1>
					<?php } ?>				


						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>
						<?php //edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>

				</div><!-- #post-## -->

				<?php //comments_template( '', true ); ?>

<?php endwhile; ?>

			</div><!-- #content -->


<?php get_sidebar(); ?>
<?php get_footer(); ?>
