<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en-gb" xmlns="http://www.w3.org/1999/xhtml" lang="en-gb">
<head>
<? if (is_404()){
$url = get_bloginfo('url');
Header( "HTTP/1.1 301 Moved Permanently" );
Header( "Location: ".$url );
}
?> 
<meta name="google-site-verification" content="v5ErzHKBQQtjW2_llFtRsy5-SdT4L39eU6J-YEmjXZg" />
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<?php wp_head(); ?>
	<link href="<?php bloginfo('template_url'); ?>/favicon.ico" rel="shortcut icon" type="image/x-icon">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ja_contentslide.css" type="text/css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ja.css" type="text/css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ja_002.css" type="text/css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/addon.css" type="text/css">
	
	<link type="text/css" href="<?php bloginfo('template_url'); ?>/css/ja_tabs.css" rel="stylesheet">
	<link type="text/css" href="<?php bloginfo('template_url'); ?>/css/style_default_WP_parts.css" rel="stylesheet">

	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/system.css" type="text/css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/general.css" type="text/css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/template.css" type="text/css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/typo.css" type="text/css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/base_126.css" type="text/css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/style-review.css" type="text/css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script>
  var jq = jQuery.noConflict();
</script>

<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/mootools.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/caption.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/ja_contentslide.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/ja_tabs.js" charset="utf-8"></script>

<script language="javascript" type="text/javascript">
  var siteurl = '<?php bloginfo('template_url'); ?>';
  var tmplurl = '<?php bloginfo('template_url'); ?>';
</script>

<script language="javascript" type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/ja.script.js"></script>
<script language="javascript" type="text/javascript" src="<?php bloginfo('template_url'); ?>/wtz_edtoolbar.js"></script>
<!-- js for dragdrop -->

<!-- Menu head -->
      <link href="<?php bloginfo('template_url'); ?>/ja_menus/ja_moomenu/ja.moomenu.css" rel="stylesheet" type="text/css">
<script src="<?php bloginfo('template_url'); ?>/ja_menus/ja_moomenu/ja.moomenu.js" language="javascript" type="text/javascript"></script>
      <link href="<?php bloginfo('template_url'); ?>/css/colors/default.css" rel="stylesheet" type="text/css">

<!--[if lte IE 6]>
<style type="text/css">
img {border: none;}
</style>
<![endif]-->

<script charset="utf-8" id="injection_graph_func" src="<?php bloginfo('template_url'); ?>/injection_graph_func.js"></script>
<script id="_nameHighlight_injection"></script>

	<link class="skype_name_highlight_style" href="<?php bloginfo('template_url'); ?>/css/injection_nh_graph.css" type="text/css" rel="stylesheet" charset="utf-8" id="_injection_graph_nh_css">
	<link href="<?php bloginfo('template_url'); ?>/css/skypeplugin_dropdownmenu.css" type="text/css" rel="stylesheet" charset="utf-8" id="_skypeplugin_dropdownmenu_css">
	

</head>

<body id="bd" class="  fs3">



<div id="ja-wrapper" class="ja-mainbg">
<a name="Top" id="Top"></a>

<!-- HEADER -->
<div id="ja-header" class="wrap">
  <div class="main clearfix">

        <div class="logo">
      <a href="<?php echo get_option('home'); ?>" title=""><img src="<?php bloginfo('template_url'); ?>/The-VIP-Gambler-Logo.png" alt="Logo"></a>
    </div>
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('top banner') ) : ?><?php endif; ?>
         

  </div>
</div>
<?php wp_head(); ?>
<!-- //HEADER -->