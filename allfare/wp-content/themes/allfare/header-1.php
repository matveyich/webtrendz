<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

	<link rel="stylesheet" type="text/css" media="screen" href="<? bloginfo('template_url');?>/css/site-style.css" type="text/css" media="screen" />
	<link rel="stylesheet" media="all" type="text/css" href="<? bloginfo('template_url');?>/css/dropdown.css" />
	<link rel="stylesheet" media="all" type="text/css" href="<? bloginfo('template_url');?>/css/lightbox.css" />
	<script type="text/javascript" src="<? bloginfo('template_url');?>/js/jquery-1.3.2.js"></script>
	<script type="text/javascript" src="<? bloginfo('template_url');?>/js/jquery.galleriffic.js"></script>
	<script type="text/javascript" src="<? bloginfo('template_url');?>/js/jquery.opacityrollover.js"></script>
	<script type="text/javascript" src="<? bloginfo('template_url');?>/js/jquery.lightbox.js"></script>
	<script type="text/javascript" src="<? bloginfo('template_url');?>/js/jquery.pngFix.js"></script>

	<script type="text/javascript">

		<!-- We only want the thunbnails to display when javascript is disabled -->
		document.write('<style>.noscript { display: none; }</style>');


		<!--IE6 PNG fix -->
		$(document).ready(function(){
			$('.bannerTxt').pngFix();
			$(".lightbox").lightbox();
		});
	</script>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-580995-7");
pageTracker._trackPageview();
} catch(err) {}
</script>

	<!--[if lte IE 6]>
		<link rel="stylesheet" media="all" type="text/css" href="css/dropdown_ie.css" />
	<![endif]-->

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<?php wp_head(); ?>
</head>
<body <?php #body_class(); ?>>

<div class="pageWrapper">
<div class="header">
		<a class="siteLogo" href="<?php echo get_option('home'); ?>/"><img src="<? bloginfo('template_url');?>/images/alltheworldsfare-logo.gif" alt="<?php bloginfo('name'); ?>" border="0" /></a>
		<!--<h1 class="siteTitle">"Our passion for quality is reflected<br />
 in the service we provide" ... <em>Clifton Sinclair</em></h1> -->
		<h2 class="telnum"><span>Customer Services:</span><br />+44 (0) 20 7328 5521</h2>
</div>
<div class="mainNav">
<?php //wp_nav_menu( array( 'container' => '', 'container_class' => '', 'theme_location' => 'primary', 'menu' => 'main' ) ); ?>
<??>
		<ul>
			<?php if (!is_404()) wp_list_pages('title_li=&sort_column=menu_order&sort_order=ASC&depth=2&exclude_tree=28'); else wp_list_pages('title_li=&sort_column=menu_order&sort_order=ASC&depth=2&exclude_tree=28');?>
		</ul>
<??>
		<span class="navEnd"></span>
	</div>

