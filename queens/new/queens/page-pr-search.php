<?php
/**
Template name: properties search
 */
if (isset($_POST['pr_type']))
{
	session_start();
	$_SESSION['pr_type'] = $_POST['pr_type'];
	$_SESSION['pr_bedroomnum'] = $_POST['pr_bedroomnum'];
	$_SESSION['minimumprice'] = $_POST['minimumprice'];
	$_SESSION['maximumprice'] = $_POST['maximumprice'];
	$_SESSION['pr_area'] = $_POST['pr_area'];
}
get_header(); ?>


			<div id="content">
<?
if (isset($_GET['pr_id']))
{
	//pr_m_("Under construction","h2");
	pr_property_show($_GET['pr_id'],$_SESSION['pr_type']);
} else {
if (isset($_GET['pr_page_id'])) $page_id = $_GET['pr_page_id']; else $page_id = 1;
//print_r($_SESSION);
pr_prop_filter($_SESSION['pr_type'],$_SESSION['pr_bedroomnum'],$_SESSION['minimumprice'],$_SESSION['maximumprice'],$_SESSION['pr_area'],$page_id);
}
?>
<?php 
/*
if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php //post_class(); ?>>
					<?php 
					
					if ( is_front_page() ) { ?>
						<h2 class="entry-title"><?php the_title(); ?></h2>
					<?php } else { ?>	
						<h2 class="entry-title"><?php the_title(); ?></h2>
					<?php } 
					
					?>				


						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>

				</div><!-- #post-## -->

				<?php //comments_template( '', true ); ?>

<?php endwhile; ?>
<?*/?>
			</div><!-- #content -->


<?php get_sidebar(); ?>
<?php get_footer(); ?>
