<?php
/*
Plugin Name: Geesee Chat
Plugin URI: http://www.geesee.com/provide/plugins.aspx
Description: This plugin allows you to insert Geesee chat into page or post body by clicking on a button in your WordPress admin text editor or to add a link to your sidebar, which opens Geesee chat in a new browser window. You can choose width and height of Geesee and the default chat room in Geesee options under your WordPress admin.
Author: Geesee, Ltd.
Author URI: http://www.geesee.com
Version: 1.0
*/

/* Buttonsnap library */
$include = true;
$included_files = get_included_files();

foreach ($included_files as $include_file) {
	if (substr_count($include_file,'buttonsnap.php')) {
		$include = false;
	}
}

if ($include) {
	include('buttonsnap.php');
}


/* Action calls for all functions */
add_action('admin_head', 'geesee_chat_add_options_page');
add_action('init', 'geesee_chat_init');
add_action('marker_css', 'geesee_chat_marker_css');
add_filter('the_content', 'chat_content', 7);


/* Functions definition */

function geesee_chat_add_options_page() {
	add_options_page('Chat Options', 'Geesee Chat', 'manage_options', 'wp_geesee_chat/wp_geesee_chat_options.php');
}

function geesee_chat_init() {
	$geesee_chat_button_url = buttonsnap_dirname(__FILE__) . '/geesee_button.png';

	buttonsnap_textbutton($geesee_chat_button_url, 'Insert Geesee Chat', '<!--GEESEE CHAT-->');
	buttonsnap_register_marker('GEESEE CHAT', 'geesee_marker');
}

function geesee_chat_marker_css() {
		$geesee_marker = buttonsnap_dirname(__FILE__) . '/geesee_marker.gif';
		echo "
			.geesee_marker {
					display: block;
					height: 15px;
					width: 155px
					margin-top: 5px;
					background-image: url({$geesee_marker});
					background-repeat: no-repeat;
					background-position: center;
			}
		";
}

function chat_content($content) {
	if(! preg_match('|<!--GEESEE CHAT-->|', $content)) {
		return $content;
	} else {
		/*Get options for chat */
		$gc_width = stripslashes(get_option('geesee_chat_width'));
		$gc_height = stripslashes(get_option('geesee_chat_height'));
		$gc_default_room = urlencode(stripslashes(get_option('geesee_chat_default_room')));
		$gc_chat = sprintf('<script type="text/javascript" src="http://www.geesee.com/sys/geeseejs.ashx?chatid=1027&Width=%d&Height=%d&DefaultRoomName=%s"></script>', $gc_width, $gc_height, $gc_default_room);
		$content = str_replace('<!--GEESEE CHAT-->',$gc_chat,$content);

		return $content;
	}
}

function wp_add_geesee_chat() {
	$gc_default_room = urlencode(stripslashes(get_option('geesee_chat_default_room')));
	printf('<a href="http://www.geesee.com/sys/geesee.ashx?chatid=1027&DefaultRoomName=%s" target="_blank">START CHAT</a>', $gc_default_room);
}

function widget_chat() {
	
	// Check for the required API functions
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;
	function widget_chat1() {
?>
    <li class="sideblock">
     <h2>Chat</h2>
     <ul>
  		<li><?php wp_add_geesee_chat(); ?></li> 
     </ul>	
    </li>
<?php
}		

if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Geesee Chat'), 'widget_chat1');	
}
add_action('widgets_init', 'widget_chat');

?>