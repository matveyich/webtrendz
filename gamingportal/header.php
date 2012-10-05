<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en-gb" xmlns="http://www.w3.org/1999/xhtml" lang="en-gb">

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="robots" content="index, follow">
  <meta name="keywords" content="gamingportals">
  <meta name="description" content="gamingportals - Game portal">
  <meta name="generator" content="gamingportals">
  <title>Welcome to the GamingPortals</title>
  <link href="<?php bloginfo('template_url'); ?>/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />

  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/style_005.css" type="text/css" />
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/style_003.css" type="text/css" />
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/mod_jasidenews.css" type="text/css" />
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ja.css" type="text/css">
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ja_002.css" type="text/css">
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/style_004.css" type="text/css" />
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/mod_janews_fp.css" type="text/css" />
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ja_contentslide.css" type="text/css">
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/style.css" type="text/css" media="screen">
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ja_tabs.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/style_006.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/system.css" type="text/css">
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/general.css" type="text/css">
  
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/template.css" type="text/css">
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/typo.css" type="text/css">
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/base_126.css" type="text/css">
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/mega.css" type="text/css" />
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/addons.css" type="text/css" />
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/skypeplugin_dropdownmenu.css" type="text/css">
  
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style-scrollable.css" type="text/css" />
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style-overlay.css" type="text/css" />
  


  <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/mootools.js"></script>
  <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/caption.js"></script>
  <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/ja_contentslide.js"></script>
  <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/script.js"></script>
  <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/ja_tabs.js"></script>
  <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/mega.js" language="javascript"></script>
  <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/ja.script.js" language="javascript"></script>

  <!-- js for dragdrop -->
  <!-- Menu head -->
    <link href="<?php bloginfo('template_url'); ?>/ja_menus/ja_moomenu/ja.moomenu.css" rel="stylesheet" type="text/css">
    <script src="<?php bloginfo('template_url'); ?>/ja_menus/ja_moomenu/ja.moomenu.js" language="javascript" type="text/javascript"></script>
    <link href="<?php bloginfo('template_url'); ?>/colors/default.css" rel="stylesheet" type="text/css">
  <!--[if lte IE 6]>
  <style type="text/css">
    img {border: none;}
  </style>
  <![endif]-->
  <script language="javascript" type="text/javascript">
    var siteurl = '<?php bloginfo('template_url'); ?>';
    var tmplurl = '<?php bloginfo('template_url'); ?>';
  </script>
  <script charset="utf-8" id="injection_graph_func" src="<?php bloginfo('template_url'); ?>/injection_graph_func.js"></script>
  <script id="_nameHighlight_injection"></script>
  
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<script type="text/javascript" src="<? bloginfo('template_url');?>/jquery.tools.min.js"></script>
<script type="text/javascript" src="<? bloginfo('template_url');?>/jquery.tools.overlay.min.js"></script>
<script type="text/javascript" src="<? bloginfo('template_url');?>/jquery.tools.expose.min.js"></script>

  <script type="text/javascript">
  var jq = jQuery.noConflict();
  </script>

</head>

<body id="bd" class="fs3 FF">

  <div id="ja-wrapper">
    <a name="Top" id="Top"></a>

    <!-- HEADER -->
    <div id="ja-header" class="wrap">

      <div class="main">
        <div class="inner clearfix">
          <h1 class="logo">
            <a href="http://webtrendz.co.uk/gamingportals/" title="GamingPortals"><span>GamingPortals</span></a>
          </h1>
          <div id="ja-search">
            <form action="<? bloginfo('url');?>/" method="get" class="search" role="search">
              <label for="mod_search_searchword"> Search  </label>
              <input name="s" id="s" class="inputbox" size="20" type="text" />
              <input name="option" value="com_search" type="hidden" />
              <input name="task" value="search" type="hidden" />
            </form>
          </div>
        </div>
      </div>
<?
// WTZ funcs
function latest_update()
{
$dates = array();
	$latest_post = get_posts('numberposts=1&order=DESC&orderby=modified');
	foreach ($latest_post as $post) { 
		setup_postdata($post);
		$dates[0] = $post->post_modified_gmt;
	}
	$latest_post = get_posts('numberposts=1&order=DESC&orderby=date');
	foreach ($latest_post as $post) { 
		setup_postdata($post);
		$dates[1] = $post->post_date_gmt;
	}
	sort($dates);
	echo $dates[1];
}
?>

      <div id="ja-topbar" class="wrap">
        <div class="main clearfix">
          <p class="ja-day">
            <span class="day"><? echo date('l');?></span><span class="date">, <? echo date('M jS');?></span>
          </p>
          <p class="ja-updatetime"><span>Last update</span><em><? latest_update();?> GMT</em></p>
          <div class="ja-healineswrap" style="display:none">
            <em>Headlines:</em>
            <div style="width: 393px;" id="jalh-modid58" class="ja-headlines ">
              <div style="white-space: nowrap;" id="jahl-wapper-items-jalh-modid58">
                <!-- HEADLINE CONTENT -->
                <div class="ja-headlines-item jahl-horizontal" style="visibility: hidden; z-index: 10; width: 393px; opacity: 0; left:393px;">
                  <a title="Tincidunt pretium Phasellus ipsum purus Aenean lacus urna augue Aenean consequat. Sollicitudin Aenean In enim laoreet felis Integer risus quis turpis Nam. Duis ac sem lacinia justo sed leo dolor Nam sem Nulla. Fringilla consequat semper dui metus hendrerit ac sit Nulla congue adipiscing. Cursus male..." href="http://templates.joomlart.com/ja_seleni/index.php?option=com_content&amp;view=article&amp;id=91:interdum-quis-tortor-tempus-mauris-orci-ut-dui-interdum&amp;catid=39:tv-a-home-theater&amp;Itemid=111">
                    <span>Interdum quis tortor tempus Mauris orci ut dui interdum justo risus vestibulumamet</span>
                  </a>
                </div>
                <div class="ja-headlines-item jahl-horizontal" style="visibility:hidden; z-index: 9; width: 225px; opacity: 0; left: 393px;">
                  <a title="Eget Nam porttitor amet at wisi vel faucibus mauris lacinia justo. Et Vestibulum tortor tempus lorem nec consectetuer Morbi Vestibulum nibh ultrices. Curabitur nibh In condimentum In consectetuer Curabitur faucibus orci Curabitur augue. Pulvinar pulvinar Integer ut mauris tempor suscipit et pretium ..." href="http://templates.joomlart.com/ja_seleni/index.php?option=com_content&amp;view=article&amp;id=90:pellentesque-et-nibh-magnis-suspendisse-justo&amp;catid=41:cell-phones-a-pdas&amp;Itemid=109">
                    <span>Pellentesque et nibh magnis Suspendisse justo</span>
                  </a>
                </div>
                <!-- //HEADLINE CONTENT -->
              </div>
            </div>
          </div>

<script type="text/javascript">
/* <![CDATA[ */
  //$(window).addEvent('domready', function(){
    // options setting
    var options = { box:$('jalh-modid58'),
            items: $$('#jalh-modid58 .ja-headlines-item'),
            mode: 'horizontal',
            wrapper:$('jahl-wapper-items-jalh-modid58'),
            buttons:{next: $$('.ja-headelines-next'), previous: $$('.ja-headelines-pre')},
            interval:3000,
            fxOptions : { duration: 500,
                    transition: Fx.Transitions.linear ,
                    wait: false } };

    var jahl = new JANewSticker( options );
  // });
/* ]]> */
</script>

        </div>
      </div>

      <!-- MAIN NAVIGATION -->
      <div id="ja-mainnav" class="wrap">
        <div class="main">
          <div class="inner clearfix">
          <ul id="ja-cssmenu" class="clearfix">
            <?php if (is_home()) { ?>
              <li class="current_page_item"><a href="<?php echo get_option('home'); ?>">Home</a></li>
            <?php } else { ?>
              <li><a href="<?php echo get_option('home'); ?>">Home</a></li>
            <?php } ?>
            <?php wp_list_pages('exclude_tree=296&title_li=&depth=2&sort_column=menu_order'); ?>
			  <li><a href="http://mb.winneronline.com/">Forum</a></li>
          </ul>
         </div>
        </div>
      </div>
      <!-- //MAIN NAVIGATION -->

    </div>
    <!-- //HEADER -->

    <?php wp_head(); ?>
