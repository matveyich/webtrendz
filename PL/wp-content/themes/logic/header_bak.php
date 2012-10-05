<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
/**
 * @package WordPress
 * @subpackage Logic theme
 */
 $url = get_bloginfo('url');
if (is_page('forum')) header("Location: ".$url."/forum/"); 
if (is_page('terms-and-conditions')) header("Location: ".$url."/terms-conditions/"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="<? bloginfo('template_url');?>/js/jquery.tools.min.js"></script>

<script>
  var jq = jQuery.noConflict();
</script>

<script src="<? bloginfo('template_url');?>/js/jqueryslidemenu.js"></script>
<script src="<? bloginfo('template_url');?>/js/jquery.tools.tabseffect.js"></script>
<script src="<? bloginfo('template_url');?>/js/jquery.logic.general.js"></script>

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

<link rel="stylesheet" href="<? bloginfo('template_url');?>/css/site-style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<? bloginfo('template_url');?>/css/forum-style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<? bloginfo('template_url');?>/css/jqueryslidemenu.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<? bloginfo('template_url');?>/css/carousel.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<? bloginfo('template_url');?>/css/info_block_gallery.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<? bloginfo('template_url');?>/css/tabs.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<? bloginfo('template_url');?>/css/style-overlay.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<? bloginfo('template_url');?>/style.css" type="text/css" media="screen" />

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<?php wp_head(); ?>
</head>

<body <?php #body_class(); ?>>
<div class="wrapper">

	<div class="header">
		
		<a href="<?bloginfo('url');?>" class="logo"><img alt="InterPartners Logo" border="0" src="<? bloginfo('template_url');?>/img/InterPartner-logo.png" /></a> 
		<div>
			<div class="accountNav">
		<?php //WTZ FIX START
                    /*wp_loginout();*/
					$wp_mem_page = get_permalink(get_page_by_path('members-area'));
					
					echo "<a class=\"register\" href=\"".$wp_mem_page."?a=registration\">Sign up</a>";
					echo " <span>|</span> "; 
					echo "<a class=\"loginLnk\" href=\"".$wp_mem_page."?a=login_form\">Log in</a>"; 
						
					
						?>	
			</div>
			
		</div>
		<div class="mainNav jqueryslidemenu" id="slidemenu">
			<ul>
				<? 
				$exclude_page = get_page_by_path("footer");
				$exclude_trees = $exclude_page->ID;
				$exclude_page = get_page_by_path("members-area");
				$exclude_pages = $exclude_page->ID;
				$args = array (
				"title_li" => "",
				"exclude_tree" => $exclude_trees,
				"exclude" => $exclude_pages,
				"echo" => 0,
				);
				$menu = wp_list_pages($args);
				$menu = preg_replace('/title=\"(.*?)\"/','',$menu);
				$to_replace = 'class="page_item ';
				$replacement = 'class="page_item last ';

				echo substr_replace($menu,$replacement,strrpos($menu,$to_replace),strlen($replacement));
				//echo $menu;
				?>
					<li class="searchArea">
					<?get_search_form();?>
					</li>
			</ul>
			
		</div>
<?
if (!(is_front_page() || is_home()) and !function_exists('bbcrumbs')) {
?>		
<div class="breadcrumb">
<?php
if(function_exists('bcn_display'))
{
	echo 'You are here:'; bcn_display();
}
?>
</div>
<?
}
?>

	</div>

