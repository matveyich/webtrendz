<?php
/**
 * The Header for our theme.
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 * We filter the output of wp_title() a bit -- see
	 * twentyten_filter_wp_title() in functions.php.
	 */
	wp_title( '|', true, 'right' );
// wp_title('&laquo;', true, 'right');  bloginfo('name');

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />

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
<link href="<?bloginfo('template_url'); ?>/css/shared/layout.css" rel="Stylesheet" type="text/css" />
<script src="<?bloginfo('template_url'); ?>/js/jquery.js" type="text/javascript"></script>
<script src="http://cdn.jquerytools.org/1.2.5/full/jquery.tools.min.js"></script>
<script src="<?bloginfo('template_url'); ?>/js/jquery.jcarousel.js" type="text/javascript"></script>
<link href="<?bloginfo('template_url'); ?>/css/shared/jquery.fancybox.css" rel="Stylesheet" type="text/css" />

<script src="<?bloginfo('template_url'); ?>/js/jquery.fancybox.js" type="text/javascript"></script>
<script src="<?bloginfo('template_url'); ?>/js/swfobject.js" type="text/javascript"></script>

<link href="<?bloginfo('template_url'); ?>/css/home/index.css" rel="Stylesheet" type="text/css" />
<script src="<?bloginfo('template_url'); ?>/js/jquery.tools.js" type="text/javascript"></script>
<script src="<?bloginfo('template_url'); ?>/js/jquery.ui.js" type="text/javascript"></script>


</head>

<body <?php #body_class(); ?>>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-580995-8']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

		<div id="header">
			<div class="header">
			<?/*?>
				<img src="<?bloginfo('template_url'); ?>/images/header.png" />
			<?*/?>
				<?
				if(function_exists('prf_basket')) prf_basket();
				?>
			</div>
			<div id="menuimagewrapper">
				<div id="menu">
<?php wp_nav_menu( array( 'container' => '', 'container_class' => '', 'theme_location' => 'primary', 'menu' => 'main' ) ); ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>