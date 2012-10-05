<?php
/**
 * @package WordPress
 * @subpackage Castles_Theme
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="keywords" content="Bounce About Castles, bouncy castles London, bouncy castle hire uk, bouncy castle sales, inflatable hire, London, Enfield, Barnet, Essex, Uk" />
<meta name="description" content="Bounce About Castles, are one of the biggest suppliers of Bouncy castles in North London, Enfield and Barnet, East London and Essex." />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="stylesheet" href="<? bloginfo('template_url');?>/style.css" type="text/css" media="screen" />

<link rel="stylesheet" href="<? bloginfo('template_url');?>/css/style-scrollable.css" type="text/css" media="screen" />

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<?php wp_head(); ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="<? bloginfo('template_url');?>/js/jquery.tools.min.js"></script>
<script>
  var jq = jQuery.noConflict();
</script>

</head>

<body <?php #body_class(); ?>>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td>
			<a href="" class="logo"><img src="<? bloginfo('template_url');?>/images/bounceaboutcastles_logo.gif" alt="BounceAboutCastles" border="0" width="750" height="75" /></a>
<?
//Header message
//if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('header bar') ) : endif;
?>		  
		  </td>
        </tr>
      </table></td>
    <td>&nbsp;</td>
  </tr>

  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr> 
    <td width="50%" align="center" valign="bottom" class="nav_bg">&nbsp; </td>
    <td width="750" align="center" valign="bottom">
    <div class="nav">
    	<ul>
        	<? wp_list_pages('title_li=&link_before=<span>&link_after=</span>&sort_column=menu_order&sort_order=ASC&depth=1');?>
        </ul>
    </div>
	</td>
    <td width="50%" align="center" valign="bottom" class="nav_bg">&nbsp;</td>

  </tr>
  <tr>
    <td width="50%" align="center" valign="bottom">&nbsp;</td>
    <td align="center"> 
	<table width="750" border="0" cellspacing="2" cellpadding="2" class="content">
		<tr>	
			<td>
    
