<?php
$_head_profile_attr = '';
if ( bb_is_profile() ) {
	global $self;
	if ( !$self ) {
		$_head_profile_attr = ' profile="http://www.w3.org/2006/03/hcard"';
	}
}
// WTZ custom functions for bbpress
function pl_login_menu()
{
$list = "<ul id='profile-menu'>";
$list .= "<li><a href=\"".get_permalink(get_page_by_path('members-area'))."\">Log in</a></li>";
$list .= "\n</ul>";
echo $list;
}
//echo $self;
function pl_profile_menu() { // this is a custom edition of standard bbpress function profile_menu()
	global $user_id, $profile_menu, $self, $profile_page_title;
	bb_global_profile_menu_structure();// this call helps us to retieve global vars that are important to show some of the profile menus
	$list  = "<ul id='profile-menu'>";
	$list .= "\n\t<li" . ( ( $self ) ? '' : ' class="current"' ) . '><a href="' . esc_attr( get_user_profile_link( $user_id ) ) . '">' . __('Profile') . '</a></li>';
	$id = bb_get_current_user_info( 'id' );
	//print_r($profile_menu);
	foreach ($profile_menu as $item) {
		// 0 = name, 1 = users cap, 2 = others cap, 3 = file
		$class = '';
		if ( $item[3] == $self ) {
			$class = ' class="current"';
			$profile_page_title = $item[0];
		}
		if ( bb_can_access_tab( $item, $id, $user_id ) )
			if ( file_exists($item[3]) || is_callable($item[3]) )
				$list .= "\n\t<li$class><a href='" . esc_attr( get_profile_tab_link($user_id, $item[4]) ) . "'>{$item[0]}</a></li>";
	}
	// additional fields for profile menu
	$wp_mem_page = get_permalink(get_page_by_path('members-area'));
	$list .= "<li><a class=\"\" href=\"".$wp_mem_page."\">My account</a></li>";
	$list .= "<li><a class=\"\" href=\"".$wp_mem_page."?a=logout\">Log out</a></li>";
	
	$list .= "\n</ul>";
	echo $list;
}

function bbcrumbs($add = "")
{
/*echo '<p>';
		printf(
			__(''),
			esc_attr( bb_get_uri( 'bb-login.php', null, BB_URI_CONTEXT_A_HREF + BB_URI_CONTEXT_BB_USER_FORMS ) )
		);*/
		/*echo "You must be <a href=\"".get_permalink(get_page_by_path('members-area'))."?a=registration\">registered</a> and <a href=\"".get_permalink(get_page_by_path('members-area'))."\">logged in</a> to post.";
		echo '</p>';*/

	//Rahim FIX START
  			echo '<div class="forumHead">';
			/*
			echo '<div class="wpLogin">';
				$wp_mem_page = get_permalink(get_page_by_path('members-area'));
					
						
					if (!is_user_logged_in()) 
						{
						echo "You must be <a href=\"".$wp_mem_page."?a=registration\">registered</a> and <a href=\"".$wp_mem_page."\">logged in</a> to post.";
						} else {
							echo "<a class=\"myAcc\" href=\"".$wp_mem_page."\">My account</a>";
							echo " <span>|</span> "; 
							echo "<a class=\"loginLnk\" href=\"".$wp_mem_page."?a=logout\">Log out</a>";
							}
					
			echo '</div>';*/
						
						?>	
<div class="breadcrumb">You are here: 
<a href="<?echo get_bloginfo('url');?>">Home</a> > 
<a href="<?echo get_permalink(get_page_by_path("supportfaq"))?>">Support/FAQ</a> > 
<a href="<?php bb_uri(); ?>"><?php bb_option('name'); ?></a>
<?php 
	$args = array(
		//'forum_id' => 0,
		'separator' => ' > ',
		'class' => null
	);
bb_forum_bread_crumb($args); 
echo $add;
?></div></div>
<?
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"<?php bb_language_attributes( '1.1' ); ?>>
<head<?php echo $_head_profile_attr; ?>>
	<meta http-equiv="X-UA-Compatible" content="IE=8" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php bb_title() ?></title>
	<link rel="stylesheet" href="<?php bb_stylesheet_uri(); ?>" type="text/css" />
<?php if ( 'rtl' == bb_get_option( 'text_direction' ) ) : ?>
	<link rel="stylesheet" href="<?php bb_stylesheet_uri( 'rtl' ); ?>" type="text/css" />
<?php endif; ?>

<?php bb_feed_head(); ?>

<?php bb_head(); ?>

</head>
<? get_header();?>



<?php //if ( bb_is_profile() ) 
if(is_user_logged_in())	pl_profile_menu(); 
	else pl_login_menu();
		
		?>
