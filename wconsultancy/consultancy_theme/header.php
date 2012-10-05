<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php //body_class(); ?>>


<div class="wrapper">
<!--- page wraper -->
	<div class="pageWrapper">

        <div class="header">
            <div class="site_logo">
            	<a href="http://webtrendz.co.uk/activecollab/public/index.php?path_info=">
            	<img width="372" height="95" border="0" title="Back to start page" alt="Webtrendz logo" src="<?echo get_bloginfo('template_directory')?>/images/webtrendz-logo.jpg">
            	</a>
                <h1>website design and development consultancy</h1>
            </div>
            <div class="userActions">
                <div class="myAccount">
                    <ul>
						<li>
							<?
$wp_mem_slug = 'members-area';
							if (is_user_logged_in()) {?>
								<a title="Profile" href="<?echo get_permalink(get_page_by_path($wp_mem_slug));?>">Profile</a>
							<?} else {?>
								<a title="Sign up" href="<?echo get_permalink(get_page_by_path($wp_mem_slug));?>?a=registration">Sign up</a>
							<?}?>
						</li>
						<li class="last">
							<?if (is_user_logged_in()) {?>
								<a title="Log out" href="<?echo get_permalink(get_page_by_path($wp_mem_slug));?>?a=logout">Log out</a>
							<?} else {?>
								<a title="Client login" href="<?echo get_permalink(get_page_by_path($wp_mem_slug));?>?a=login_form">Client login</a>
							<?}?>
						</li>
                    </ul>
                </div>
                <div class="contactUsBtn"> <a href="#">LIVE CHAT</a> </div>
            </div>
        </div>
        <?
// main menu
		wp_nav_menu( array(
			'container_class' => 'js-active',
			'theme_location' => 'primary',
			'container_id' => 'menu',
			'link_before' => '<span>',
			'link_after' => '</span>'

			) );
// MM ends
		?>

        <div class="contentHeader">
            <div class="breadcrumb">
            	<span>you are here: </span>
				<ul>
<?php
if(function_exists('bcn_display'))
{
	bcn_display();
}
?>
				</ul>
            </div>
            <div class="searchArea">
                <form method="get" action="<?echo get_bloginfo('url');?>">
				<ul>
                    <li>
                        <label class="hideMe" for="searchInput">Start your search</label>
                    </li>
                    <li>
                        <input id="s" type="text" class="searchInputfield" id="searchInput" name="s" value="search ...">
                    </li>
                    <li>
                        <input type="submit" value="search" class="searchSubitBtn hideMe">
                    </li>
                </ul>
                </form>
            </div>
        </div>


