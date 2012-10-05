<?php
/*
Plugin Name: WP-Members
Plugin URI: http://butlerblog.com/wp-members/
Description: WP access restriction and user registration.  For more information and to download the free "quick start guide," visit <a href="http://butlerblog.com/wp-members">http://butlerblog.com/wp-members</a>.  View the live demo at <a href="http://butlerblog.com/wpmembers">http://butlerblog.com/wpmembers</a>.
Version: 2.2.1
Author: Chad Butler
Author URI: http://butlerblog.com/
License: GPL2
*/


/*
	Copyright (c) 2006-2010  Chad Butler (email : plugins@butlerblog.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

	You may also view the license here:
	http://www.gnu.org/licenses/gpl.html#SEC1
*/


/*
A NOTE ABOUT LICENSE:

	While this plugin is released as free and open-source under the GPL2
	license, that does not mean it is "public domain." You are free to modify
	and redistribute as long as you comply with the license. This includes
	keeping a derivative work available as open source and also giving proper
	attribution to the original author and copyright holder.  This means you
	cannot change two lines of code and claim copyright of the entire work as
	your own.  If you are unsure or have questions about how a derivative work
	you are developing complies with the license and copyright, contact the
	original author at plugins@butlerblog.com.


INSTALLATION PROCEDURE:

	* Save wp-members.php to your plugins directory
	* Login to the WP admin
	* Go to plugins tab and activate the plugin
	* That's it!

	For more complete installation and usage instructions,
	visit http://butlerblog.com/wp-members/
*/


// hooks and filters
add_action('init', 'wpmem');  // runs the wpmem() function right away, allows for setting cookies
add_action('widgets_init', 'widget_wpmemwidget_init');  // if you are using widgets, this initializes the widget
add_filter('the_content', 'wpmem_securify', $content);  // runs the wpmem_securify on the $content.
add_action('wp_head', 'wpmem_head');
define("WP_MEM_VERSION", "2.2.1");

// Generally, the plugin uses a/wpmem_a to define an action that it is passing from page to page.
// It usese wpmem_regchk to pass what it is doing between functions (specifically, the init and the_content).


/*****************************************************
PRIMARY FUNCTIONS
*****************************************************/

function wpmem()
{
	global $wpmem_a,$nwsltr_fs;

	//WTZ newsletter fields array, look up at wpmem_install
	$nwsltr_fs = array (7,8,9,10,11,12,13,14);

	$wpmem_a = trim($_REQUEST['a']);

	switch ($wpmem_a) {

	case ("login"):
		wpmem_login();
		break;

	case ("logout"):
		wpmem_logout();
		break;

	case ("register"):
		wpmem_register();
		break;

	case ("update"):
		wpmem_update();
		break;

	case ("nwsltr_update")://WTZ newsletter update
		wpmem_registration('nwsltr_update');
		break;

	case ("pwdchange"):
		wpmem_change_password();
		break;

	case ("pwdreset"):
		wpmem_reset_password();
		break;

	} // end of switch $a (action)

}


function wpmem_securify ($content)
{
	global $wpmem_regchk, $wpmem_themsg, $wpmem_a;
/*
	if ($wpmem_regchk == "loginfailed") { //WTZ (was login_failed)
		wpmem_inc_loginfailed();
		wpmem_reset_password(); // WTZ
		$content = '';
		return $content;
	}
*/
	// Block/unblock Posts
	if (is_single()) {
		if (!is_user_logged_in()) {

			//check settings
			$wpmem_settings = get_option('wpmembers_settings');

			if ($wpmem_settings[1] == 1 && !get_post_custom_values('unblock')) { $chk_securify = "block"; }
			if ($wpmem_settings[1] == 0 &&  get_post_custom_values('block')) { $chk_securify = "block"; }

			//if (!get_post_custom_values('unblock')) {
			if ($chk_securify == "block") {

				// show the login and registration forms
				if ($wpmem_regchk) {

					switch($wpmem_regchk) {

					case "loginfailed":
						wpmem_inc_loginfailed();
						//wpmem_inc_resetpassword(); //WTZ reset password form
						break;

					case "success":
						wpmem_inc_regmessage($wpmem_regchk,$wpmem_themsg);
						wpmem_inc_login();
						break;

					default:
						wpmem_inc_regmessage($wpmem_regchk,$wpmem_themsg);
						wpmem_inc_registration($fields);
						break;
					}

				} else {

					wpmem_inc_login();
					wpmem_inc_registration($fields);
				}

				//return empty content
				$content = "";
			}
		}
	}

	// Block/unblock Pages
	if (is_page() && !is_page('my-account')) {

		if (!is_user_logged_in()) {

			//check settings
			$wpmem_settings = get_option('wpmembers_settings');

			if ($wpmem_settings[2] == 1 && !get_post_custom_values('unblock')) { $chk_securify = "block"; }
			if ($wpmem_settings[2] == 0 &&  get_post_custom_values('block')) { $chk_securify = "block"; }

			//if (get_post_custom_values('block')) {
			if ($chk_securify == "block") {

				// show the login and registration forms
				if ($wpmem_regchk) {

					switch($wpmem_regchk) {

					case "loginfailed":
						wpmem_inc_loginfailed();
						//wpmem_reset_password(); // WTZ
						break;

					case "success":
						wpmem_inc_regmessage($wpmem_regchk,$wpmem_themsg);
						wpmem_inc_login();
						break;

					default:
						wpmem_inc_regmessage($wpmem_regchk,$wpmem_themsg);
						wpmem_inc_registration($fields);
						break;
					}

				} else {

					wpmem_inc_login();
					wpmem_inc_registration($fields);
				}

				//return empty content
				$content = "";
			}
		}
	}

	// Members Area
	//   this takes a bit of manipulation to get it all to work on one page.
	//   make sure if you use this, to set the page slug to "members-area" or change the is_page() below
	if (is_page('my-account')) {
		if (!is_user_logged_in()) {
			if ($wpmem_a == 'register') {

				switch($wpmem_regchk) {

				case "success":
					wpmem_inc_regmessage($wpmem_regchk,$wpmem_themsg);
					wpmem_inc_login();
					break;

				case "loginfailed":
					wpmem_inc_loginfailed();;
					break;

				default:

          wpmem_inc_regmessage($wpmem_regchk,$wpmem_themsg);
					wpmem_inc_registration($fields);

					// WTZ
					if ($wpmem_regchk == "loginfailed")
					{
						wpmem_inc_resetpassword();
          } // WTZ
					break;
				}

			} elseif ($wpmem_a == 'pwdreset') {

				switch($wpmem_regchk) {

				case "pwdreseterr":
					wpmem_inc_regmessage($wpmem_regchk);
					break;

				case "pwdresetsuccess":
					wpmem_inc_regmessage($wpmem_regchk);
					break;

				default:
					wpmem_inc_resetpassword();
					break;
				}

			} else {
			// standard login form page
				// WTZ
         switch($wpmem_regchk){
         	case "loginfailed":
         		wpmem_inc_loginfailed();
         		wpmem_inc_login('members');
         		wpmem_inc_registration($fields);
         		break;
         	default:
         		wpmem_inc_login('members');
				wpmem_inc_registration($fields);

        // WTZ
				if ($wpmem_regchk == "loginfailed")
					{
						wpmem_inc_resetpassword();
        			} // WTZ;
         		break;
         } // switch

			}
			$output = '';
			$content = '';

		} else {

			switch($wpmem_a) {

			case "edit":
				wpmem_inc_registration($fields,'edit',"<h1>Personal Details</h1>");
				wpmem_inc_changepassword(); // WTZ change password form
        $content = '';
				break;
			case "nwsltr": // WTZ newsletter
				wpmem_inc_registration($fields,'nwsltr',"<h1>Newsletter Settings</h1>");
				$content = '';
				break;

			case "nwsltr_update":

				$output = wpmem_inc_memberlinks();
			break;

			case "update":

				// determine if there are any errors/empty fields

				if ($wpmem_regchk == "updaterr") {

					wpmem_inc_regmessage($wpmem_regchk,$wpmem_themsg);
					wpmem_inc_registration($fields,'edit',"<h1>Edit Your Information</h1>");
					$content = '';

				} else {

					//case "editsuccess":
					wpmem_inc_regmessage($wpmem_regchk,$wpmem_themsg);
					$output = wpmem_inc_memberlinks();

				}
				break;

			case "pwdchange":

				switch ($wpmem_regchk) {

				case "pwdchangerr":
					wpmem_inc_regmessage($wpmem_regchk);
					wpmem_inc_changepassword();
					$content = '';
					break;

				case "pwdchangesuccess":
					wpmem_inc_regmessage($wpmem_regchk);
					break;

				default:
					wpmem_inc_changepassword();
					$content = '';
					break;
				}
				break;

			default:
				$output = wpmem_inc_memberlinks();
				break;
			}

		}

		$content = preg_replace("/\<!--members-area-->/", $output, $content);

	}

	return $content;
}


// login function
function wpmem_login($user_login = false, $user_pass = false)
{
	global $wpdb,$wpmem_regchk;

	$redirect_to = $_REQUEST['redirect_to'];
	if (!$redirect_to) {
		$redirect_to = $_SERVER['PHP_SELF'];
	}

	// we are reusing WP's own login scripts here.

	if ($user_login == false) $user_login = $_POST['log'];
	$user_login = sanitize_user( $user_login );
	if ($user_pass == false) $user_pass  = $_POST['pwd'];
	$rememberme = $_POST['rememberme'];
	do_action('wp_authenticate', array(&$user_login, &$user_pass));

	if ( $user_login && $user_pass ) {
		$user = new WP_User(0, $user_login);
/*
$creds = array();
$creds['user_login'] = $user_login;
$creds['user_password'] = $user_pass;
$creds['remember'] = true;///probably
$user = wp_signon( $creds, true );
	if ( is_wp_error($user) )
		{
		echo $user->get_error_message();
*/
		if ( wp_login($user_login, $user_pass, $using_cookie) )
		{
			if ( !$using_cookie )
				wp_setcookie($user_login, $user_pass, false, '', '', $rememberme);
			do_action('wp_login', $user_login);

		wp_redirect($redirect_to);
		exit();
		} else {
		//login failed
		$wpmem_regchk = "loginfailed";
	   }

	} else {
		//login failed
		$wpmem_regchk = "loginfailed";
	}

} // end of login function


function wpmem_logout()
{
	//take 'em to the blog home page
	$redirect_to = get_bloginfo('url');

	wp_clearcookie();
	do_action('wp_logout');
	nocache_headers();

	wp_redirect($redirect_to);
	exit();
}


function wpmem_login_status()
{
	if (is_user_logged_in()) {	echo wpmem_inc_status(); }
}


function wpmem_change_password()
{
	global $wpdb,$user_ID,$userdata,$wpmem_regchk;
	if ($_POST['formsubmit']) {

		$pass1 = $_POST['pass1'];
		$pass2 = $_POST['pass2'];

		if ($pass1 != $pass2) {

			$wpmem_regchk = "pwdchangerr";

		} else {

			//update password in wpdb
			$new_pass = md5($pass1);
			$wpdb->update( $wpdb->users, array( 'user_pass' => $new_pass ), array( 'ID' => $user_ID ), array( '%s' ), array( '%d' ) );

			$wpmem_regchk = "pwdchangesuccess";
		// we have updated pswd, now let's try to login using it
		$_u_info = get_userdata($user_ID);

		wpmem_login($_u_info->user_login,$pass1);
		}
	}
	return;
}


function wpmem_reset_password()
{
	// make sure native WP registration functions are loaded
	require_once( ABSPATH . WPINC . '/registration-functions.php');

	global $wpdb,$wpmem_regchk;
	if ($_POST['formsubmit']) {

		$user  = $_POST['user'];
		$email = $_POST['email'];

		if (!$user || !$email) {

			// there was an empty field
			$wpmem_regchk = "pwdreseterr";
			//return;

		} else {

			if (username_exists($user)) {

				$user_info = get_userdatabylogin($user);
				if($user_info->user_email !== $email) {
					// the username was there, but the email did not match
					$wpmem_regchk = "pwdreseterr";
					//return;
				} else {
					// everything checks out, go ahead and reset
					$new_pass     = substr( md5( uniqid( microtime() ) ), 0, 7);
					$hashpassword = md5($new_pass);
					$wpdb->update( $wpdb->users, array( 'user_pass' => $hashpassword ), array( 'user_login' => $user ), array( '%s' ), array( '%s' ) );
					$the_id = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE user_login = '{$user}'");

					wpmem_inc_regemail($the_id,$new_pass,'true');
					$wpmem_regchk = "pwdresetsuccess";
					//return;
				}
			} else {

				// username did not exist
				$wpmem_regchk = "pwdreseterr";
				//return;
			}
		}
	}
	return;
}


function wpmem_head()
{
	echo "<!-- WP-Members version ".WP_MEM_VERSION.", available at http://butlerblog.com/wp-members -->";
}


function  wpmem_register()
{
	wpmem_registration('register');
}


function wpmem_update()
{
	wpmem_registration('update');
}


function wpmem_registration($toggle)
{
	// make sure native WP registration functions are loaded
	require_once( ABSPATH . WPINC . '/registration-functions.php');

	global $wpdb,$user_ID,$userdata,$wpmem_regchk,$wpmem_themsg,$username,$user_email,$wpmem_fieldval_arr,$nwsltr_fs;

	if($toggle=='register'){ $username = $_POST['log']; }
	$user_email = $_POST['user_email'];

	//build array of the posts
	$wpmem_fields = get_option('wpmembers_fields');
	for ($row = 0; $row < count($wpmem_fields); $row++) {
		$wpmem_fieldval_arr[$row] = $_POST[$wpmem_fields[$row][2]];
	}

	// check for required fields
	$wpmem_fields_rev = array_reverse($wpmem_fields);
	$wpmem_fieldval_arr_rev = array_reverse($wpmem_fieldval_arr);

	for ($row = 0; $row < count($wpmem_fields); $row++) {
		if ( $wpmem_fields_rev[$row][5] == 'y' ) {
			if ( !$wpmem_fieldval_arr_rev[$row] ) { $wpmem_themsg = $wpmem_fields_rev[$row][1]." is a required field."; }
		}
	}

	switch($toggle) {

	case "register":

		if ( !$username ) { $wpmem_themsg = "username is a required field"; }
		if ( $wpmem_themsg ) {

			$wpmem_regchk = "empty";

		} else {

			if (username_exists($username)) {

				$wpmem_regchk = "user";

			} else {

				$email_exists = $wpdb->get_var("SELECT user_email FROM $wpdb->users WHERE user_email = '$user_email'");
				if ( $email_exists) {

					$wpmem_regchk = "email";

				} else {

				//everything checks out, so go ahead and insert

					//The main insertion process was taken from the WP core, the rest is modified to accomodate WP-Members user defined fields.

					$password = substr( md5( uniqid( microtime() ) ), 0, 7);
					$hashpassword = md5($password);
					$user_registered = gmdate('Y-m-d H:i:s');

					$query = "INSERT INTO $wpdb->users
						(user_login, user_pass, user_email, user_registered, user_nicename, display_name) VALUES
						('$username', '$hashpassword', '$user_email', '$user_registered', '$username', '$username')";

					$query = apply_filters('create_user_query', $query);
					$wpdb->query( $query );
					$user_id = $wpdb->insert_id;

					//Sets the user to the default role.
					$user = new WP_User($user_id);
					$user->set_role(get_option('default_role'));

					update_user_meta( $user_id, 'nickname', $username); // gotta have this whether it's used or not; if it's included w/ custom, value should be overwritten below.
					for ($row = 0; $row < count($wpmem_fields); $row++) {

						/*there are two native wp fields that throw a sticky wicket into our clean array - email and website.
						  they go into the wp_users table.  email is already done above, we need to then screen for putting in
						  website, if used, and screen out email, since it's already done. */
						if ($wpmem_fields[$row][2] == 'user_url') {
							$wpdb->update( $wpdb->users, array('user_url'=>$wpmem_fieldval_arr[$row]), array('ID'=>$user_id) );
						} else {
							if ($wpmem_fields[$row][2] != 'user_email') {update_user_meta( $user_id, $wpmem_fields[$row][2], $wpmem_fieldval_arr[$row]);}
						}
					}

					//if this was successful, and you have email properly
					//configured, send a notification email to the user
					wpmem_inc_regemail($user_id,$password);

					// successful registration message
					$wpmem_regchk = "success";

				}
			}
		}

		break;

	case "update":

		if ( $wpmem_themsg ) {

			$wpmem_regchk = "updaterr";

		} else {

			for ($row = 0; $row < count($wpmem_fields); $row++) {

				/*there are two native wp fields that throw a sticky wicket into our clean array - email and website.
				  they go into the wp_users table.  we need to then screen for these and put them in a different way*/
				switch ($wpmem_fields[$row][2]) {

				case ('user_url'):
					$wpdb->update( $wpdb->users, array('user_url'=>$wpmem_fieldval_arr[$row]), array('ID'=>$user_ID) );
					break;

				case ('user_email'):
					$wpdb->update( $wpdb->users, array('user_email'=>$wpmem_fieldval_arr[$row]), array('ID'=>$user_ID) );
					break;

				default:
					if (!in_array($wpmem_fields[$row][0],$nwsltr_fs))
					{
					update_user_meta( $user_ID, $wpmem_fields[$row][2], $wpmem_fieldval_arr[$row]);
					}
					break;
				}
			}

			$wpmem_regchk = "editsuccess";

		}

		break;
		// WTZ addition for Newsletter
		case "nwsltr_update":
			for ($row = 0; $row < count($wpmem_fields); $row++) {

				/*there are two native wp fields that throw a sticky wicket into our clean array - email and website.
				  they go into the wp_users table.  we need to then screen for these and put them in a different way*/
				if (in_array($wpmem_fields[$row][0],$nwsltr_fs))
					{
					//echo $wpmem_fields[$row][2].'='.$wpmem_fieldval_arr[$row];
update_user_meta( $user_ID, $wpmem_fields[$row][2], $wpmem_fieldval_arr[$row]);
					}
				}
		break;

	}



} // end registration function


/*****************************************************
END PRIMARY FUNCTIONS
*****************************************************/


/*****************************************************
UTILITY FUNCTIONS
*****************************************************/


function wpmem_create_formfield($name,$type,$value,$valtochk=null)
{
	switch ($type) {

	case "checkbox":
		echo "<input name=\"$name\" type=\"$type\" id=\"$name\" value=\"on\" ";wpmem_selected($value,$valtochk,$type);echo " />\n";
		break;

	case "text":
		echo "<input name=\"$name\" type=\"$type\" id=\"$name\" value=\"$value\" />\n";
		break;

	case "textarea":
		echo "<textarea cols=\"20\" rows=\"5\" name=\"$name\">$val</textarea>";
		break;

	case "password":
		echo "<input name=\"$name\" type=\"$type\" id=\"$name\" />\n";
		break;

	case "hidden":
		echo "<input name=\"$name\" type=\"$type\" value=\"$value\" />\n";
		break;

	case "title":
		?>
		<select name="<?echo $name?>">
			<option>Mr</option>
			<option>Mrs</option>
			<option>Miss</option>
			<option>Ms</option>
			<option>Dr</option>
			<option>Prof</option>
			<option>Rev</option>
			<option>Sir</option>
		</select>
		<?
		break;
////// WTZ addon for WTZ properites module
	case "bedroom_drop_down":
		if(function_exists('prf_bedroom_drop_down')) prf_bedroom_drop_down($name,0,10,10,$value);
		 else echo "Areas selection isn't available without WTZ properties plugin";
		//echo "<input name=\"$name\" type=\"$type\" value=\"$value\" />\n";

		break;
	case "price_drop_down":
		if(function_exists('prf_price_drop_down')) prf_price_drop_down($name,10000,100000,10,$value);
		 else echo "Areas selection isn't available without WTZ properties plugin";
		//echo "<input name=\"$name\" type=\"$type\" value=\"$value\" />\n";
		break;
	case "rent_drop_down":
		if(function_exists('prf_rent_drop_down')) prf_rent_drop_down($name,100,5000,10,$value);
		 else echo "Areas selection isn't available without WTZ properties plugin";
		//echo "<input name=\"$name\" type=\"$type\" value=\"$value\" />\n";
		break;
	case "areas_drop_down":
		if(function_exists('pr_edit_subform')) pr_edit_subform("areas_front",	$value, NULL,$name,NULL);
		 else echo "Areas selection isn't available without WTZ properties plugin";
		//echo "<input name=\"$name\" type=\"$type\" value=\"$value\" />\n";
		break;

	}
}


function wpmem_selected($value,$valtochk,$type=null)
{
	if($value == $valtochk){ echo "checked"; }
}


function wpmem_chk_qstr()
{
	$permalink = get_settings('permalink_structure');
	if (!$permalink) {
		// no fancy permalinks.  Append to ?=
		$return_url = get_settings('home') . "/?" . $_SERVER['QUERY_STRING'] . "&amp;";
	} else {
		// permalinks in use.  Add a ?
		$return_url = get_permalink() . "?";
	}
	return $return_url;
}


function wpmem_generatePassword()
{
	return substr( md5( uniqid( microtime() ) ), 0, 7);
}


/*****************************************************
END UTILITY FUNCTIONS
*****************************************************/


/*****************************************************
WIDGET FUNCTIONS
*****************************************************/


function widget_wpmemwidget_init()
{
	function widget_wpmemwidget($args)
	{
		extract($args);

		$options = get_option('widget_wpmemwidget');
		$title = $options['title'];

		echo $before_widget;

			// Widget Title
			if (!$title) {$title = "Login Status";}
			echo $before_title . $title . $after_title;

			// The Widget
			if (function_exists('wpmem')) { wpmem_inc_sidebar($widget);}

		echo $after_widget;
	}

	function widget_wpmemwidget_control()
	{
		// Get our options and see if we're handling a form submission.
		$options = get_option('widget_wpmemwidget');
		if ( !is_array($options) )
			$options = array('title'=>'', 'buttontext'=>__('WP Members', 'widgets'));
		if ( $_POST['wpmemwidget-submit'] ) {

			// Remember to sanitize and format use input appropriately.
			$options['title'] = strip_tags(stripslashes($_POST['wpmemwidget-title']));
			update_option('widget_wpmemwidget', $options);
		}

		// Be sure you format your options to be valid HTML attributes.
		$title = htmlspecialchars($options['title'], ENT_QUOTES);

		// Here is our little form segment. Notice that we don't need a
		// complete form. This will be embedded into the existing form.
		echo '<p style="text-align:right;"><label for="wpmemwidget-title">' . __('Title:') . ' <input style="width: 200px;" id="wpmemwidget-title" name="wpmemwidget-title" type="text" value="'.$title.'" /></label></p>';
		echo '<input type="hidden" id="wpmemwidget-submit" name="wpmemwidget-submit" value="1" />';
	}

	register_sidebar_widget('WP Members', 'widget_wpmemwidget');
	register_widget_control('WP Members', 'widget_wpmemwidget_control');
}


/*****************************************************
END WIDGET FUNCTIONS
*****************************************************/


/*****************************************************
DIALOG OUTPUT FUNCTIONS
*****************************************************/


function wpmem_inc_login($page='page')
{
	/*
	This is the form and table for the login.
	You can redesign in any way you wish as long
	as you DO NOT change the form or input properties */

	global $wpmem_regchk;

	$wpmem_dialogs = get_option('wpmembers_dialogs');

	if($page == "page"){
	     if($wpmem_regchk!="success"){

		//this shown above blocked content ?>
		<p><?php echo $wpmem_dialogs[0]; ?></p>

	<?php }
	} ?>

	<form class="formLogin" name="form1" method="post" action="<?php the_permalink() ?>">
		<h1>Existing Users Login</h1>
	  <ul>
		<li>
		  <label for="log">Username</label>
		  <input type="text" name="log" />
		</li>
		<li>
		  <label for="pwd">Password</label>
		  <input type="password" name="pwd" />
		</li>


 <?php if($page == "members"){
	  	$link = wpmem_chk_qstr();

	  	// this is only shown on the "members" page ?>
	  	<li class="forgot">
	  	  Forgot password? <a href="<?php echo $link; ?>a=pwdreset">Click here to reset</a>
	  	</li>
	  <?php } ?>

		<li><label for="rememberme">Remember me</label>
			<input name="rememberme" type="checkbox" id="rememberme" value="forever" />
		</li>
		<li class="userAction">
		  	<input type="hidden" name="redirect_to" value="<?php the_permalink() ?>" />
			<input type="hidden" name="a" value="login" />
			<input type="submit" name="Submit" value="Login" class="login" />
		</li>


	  </ul>
	</form>

	<?php  // end edits for function wpmem_inc_login()
}


function wpmem_inc_loginfailed()
{
	/*
	failed login message.
	you can customize this to fit your theme, etc.

	You may edit below this line */?>

	<div align="center">
		<h1>Login Failed!</h1>
		<p>You entered an invalid username or password.</p>
		<?/*?>
		   <p><a href="<?php echo $_SERVER['REQUEST_URI'];?>">Click here to continue.</a></p>
		<?*/?>
	</div>

	<?php  // end edits for function wpmem_inc_loginfailed()
}


function wpmem_inc_status()
{
	/*
	reminder email was successfully sent message.
	you can customize this to fit your theme, etc.
	*/

	global $user_login;
	$logout = get_bloginfo('url')."/?a=logout";

	//You may edit below this line

	$wpmem_login_status = "
	<p>".__('You are logged in as')." $user_login | <a href=\"".$logout."\">".__('click here to logout')."</a></p>";

	// end edits for function wpmem_inc_status()

	return $wpmem_login_status;
}


function wpmem_inc_sidebar()
{
	/*
	This function determines if the user is logged in
	and displays either a login form, or the user's
	login status. Typically used for a sidebar.
	You can call this directly, or with the widget
	*/
	global $user_login;
	$url = get_bloginfo('url');
	$logout = $url."/?a=logout";

	//this returns us to the right place
	if(is_home()) {
		$post_to = $_SERVER['PHP_SELF'];
	}else{
		$post_to = get_permalink();
	}

	if (!is_user_logged_in()){
	/*
	This is the login form.
	You may edit below this line, but do not
	change the <?php ?> tags or their contents */?>
	<ul>
		<p>You are not currently logged in.<br />
			<form name="form" method="post" action="<?php echo $post_to; ?>">
			Username<br />
			<input type="text" name="log" /><br />
			Password<br />
			<input type="password" name="pwd" /><br />
			<input type="hidden" name="rememberme" value="forever" />
			<input type="hidden" name="redirect_to" value="<?php echo $post_to; ?>" />
			<input type="hidden" name="a" value="login" />
			<input type="submit" name="Submit" value="Login" />
			</form>
		</p>
	</ul>
	<?php } else {
	/*
	This is the displayed when the user is logged in.
	You may edit below this line, but do not
	change the <?php ?> tags or their contents */?>
	<ul>
		<p>
		  You are logged in as <?php echo $user_login; ?><br />
		  <a href="<?php echo $logout;?>">click here to logout</a>
		</p>
	</ul>

	<?php }
}


function wpmem_inc_registration($fields,$toggle = 'new',$heading = '')
{

	global $wpdb,$user_ID, $userdata,$securify,$wpmem_regchk,$username,$wpmem_fieldval_arr,$nwsltr_fs;


	if (!$heading) { $heading = "<h1>New Users Registration</h1>"; }
	if (is_user_logged_in()) { get_currentuserinfo(); }	?>

	<form class="formRegister" name="form2" method="post" action="<?php the_permalink();//wpmem_chk_qstr();?>">
		  <?php echo $heading; ?>
	  <ul>
		<li class="reqTxt"><font color="red">*</font> Required field</li>
		<?php if ($toggle == 'edit') { ?>
		<li>
		  <label>Username:</label>
		  <?php echo $userdata->user_login?>
		</li>
		<?php }
				elseif ($toggle == 'nwsltr')
				{

		$wpmem_fields = get_option('wpmembers_fields');
		for ($row = 0; $row < count($wpmem_fields); $row++)
		{
			if ($wpmem_fields[$row][4] == 'y' and in_array($wpmem_fields[$row][0],$nwsltr_fs)) { ?>
				<li>
					<label for="<?=$wpmem_fields[$row][2]?>"><?php
						echo $wpmem_fields[$row][1].":";
						if ($wpmem_fields[$row][5] == 'y') { ?><font color="red">*</font><?php } ?>
					</label>
					<?php
					if (($toggle == 'nwsltr') && ($wpmem_regchk != 'updaterr')) {
						switch ($wpmem_fields[$row][2]) {
						case('description'):
							$val = get_usermeta($user_ID,'description');
							break;

						case('user_email'):
							$val = $userdata->user_email;
							break;

						case('user_url'):
							$val = $userdata->user_url;
							break;

						default:
							$val = get_usermeta($user_ID,$wpmem_fields[$row][2]);
							break;
						}

					} else {

						$val = $wpmem_fieldval_arr[$row];

					}

					if ('checkbox' == $wpmem_fields[$row][3]) wpmem_create_formfield($wpmem_fields[$row][2],$wpmem_fields[$row][3],$val,'on');
						else wpmem_create_formfield($wpmem_fields[$row][2],$wpmem_fields[$row][3],$val,'');
					?>
				</li>
			<?php }
		}
				}
				else { ?>
		<li>
		  <label for="log">Choose a Username <font color="red">*</font></label>
		  <input name="log" type="text" value="<?php echo $username;?>" />
		</li>
		<?php } ?>

		<?php
		if ($toggle != 'nwsltr')// wtz newsletter filter start
		{
		$wpmem_fields = get_option('wpmembers_fields');
		for ($row = 0; $row < count($wpmem_fields); $row++)
		{
			if ($wpmem_fields[$row][4] == 'y' and !in_array($wpmem_fields[$row][0],$nwsltr_fs)) { ?>
				<li>
					<label for="<?=$wpmem_fields[$row][2]?>"><?php
						echo $wpmem_fields[$row][1].":";
						if ($wpmem_fields[$row][5] == 'y') { ?><font color="red">*</font><?php } ?>
					</label>
					<?php
					if (($toggle == 'edit') && ($wpmem_regchk != 'updaterr')) {
						switch ($wpmem_fields[$row][2]) {
						case('description'):
							$val = get_usermeta($user_ID,'description');
							break;

						case('user_email'):
							$val = $userdata->user_email;
							break;

						case('user_url'):
							$val = $userdata->user_url;
							break;

						default:
							$val = get_usermeta($user_ID,$wpmem_fields[$row][2]);
							break;
						}

					} else {

						$val = $wpmem_fieldval_arr[$row];

					}

					if ('checkbox' == $wpmem_fields[$row][3]) wpmem_create_formfield($wpmem_fields[$row][2],$wpmem_fields[$row][3],$val,'on');
						else wpmem_create_formfield($wpmem_fields[$row][2],$wpmem_fields[$row][3],$val,'');
					?>
				</li>
			<?php }
		}
		} // wtz newsletter filter end
		?>
		<li class="userAction">
		  <?php if ($toggle == 'edit') { ?>
		  	<input name="a" type="hidden" value="update" />
		  <?php }	elseif ($toggle == 'nwsltr') { // wtz fixes?>
		  	<input name="a" type="hidden" value="nwsltr_update" />
		  <?php	}	else { ?>
		    <input name="a" type="hidden" value="register" />
		  <?php } ?>
			<input name="redirect_to" type="hidden" value="<?php the_permalink();?>" />
	<input name="Reset" type="reset" value="Clear Form" class="reset" />
	&nbsp;&nbsp;
			<input name="Submit" type="submit" value="Submit" class="submit" />


		</li>
	  </ul>
	</form>


	<?php
}


function wpmem_inc_changepassword()
{ ?>
	  <form name="form" method="post" action="<?php the_permalink();?>">
		<h1>Change Password</h1
	  <ul>
		<li>
		  <label for="pass1">New Password</label>
		  <td width="166"><input type="password" name="pass1" />
		</li>
		<li>
		  <label for="pass2">Repeat Password</label>
		  <td width="166"><input type="password" name="pass2" />
		</li>
		<li class="hint">
		  Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).
		</li>
		<li class="userAction">
		  	<input type="hidden" name="redirect_to" value="<?php the_permalink() ?>" />
			<input type="hidden" name="formsubmit" value="1" />
			<input type="hidden" name="a" value="pwdchange" />
			<input type="submit" name="Submit" value="Update Password" class="submit" />
		</li>
	  </ul>
	  </form>
	  <?php
}


function wpmem_inc_resetpassword()
{ ?>
	  <form name="form" method="post" action="<?php the_permalink();?>">
		<h1>Reset Forgotten Password</h1>
	  <ul>
		<li>
		  <label for="user">Username</label>
		  <input type="text" name="user" />
		</li>
		<li>
		  <label for="email">Email</label>
		  <input type="text" name="email" />
		</li>
		<li class="userAction">
		  	<input type="hidden" name="redirect_to" value="<?php the_permalink() ?>" />
			<input type="hidden" name="formsubmit" value="1" />
			<input type="hidden" name="a" value="pwdreset" />
			<input type="submit" name="Submit" value="Reset Password" class="submit"/>
		</li>
	  </ul>
	  </form>
	  <?php
}


function wpmem_inc_memberlinks()
{
	//$link = wpmem_chk_qstr(); // this was by default. I chabged it it get_permalink
	$link = get_permalink(get_page_by_path('my-account'));
	$str  = "<ul class=\"accountNav\">\n";
	$str .= "<li><a href=\"".$link."?a=edit\">Profile</a></li>\n";
	//$str .= "<li><a href=\"".$link."?a=pwdchange\">Change Password</a></li>\n";
	//$str .= "<li><a href=\"".$link."?a=nwsltr\">Newsletter</a></li>\n";
	//WTZ additional menu links here
	if(function_exists('prf_additional_menu')) $str .= prf_additional_menu();
	$str .= "<li><a href=\"".$link."?a=logout\">Log out</a></li>\n";
	$str .="</ul>";

	return $str;
}


function wpmem_inc_regmessage($toggle,$themsg='')
{

	$wpmem_dialogs = get_option('wpmembers_dialogs');
	$wpmem_dialogs_toggle = array('user','email','success','editsuccess','pwdchangerr','pwdchangesuccess','pwdreseterr','pwdresetsuccess');

	for ($row = 0; $row < count($wpmem_dialogs_toggle); $row++) {

		if ($toggle == $wpmem_dialogs_toggle[$row]) { ?>

			<div class="wpmem_msg" align="center">
				<p>&nbsp;</p>
				<p><b><?php echo $wpmem_dialogs[$row+1]; ?></b></p>
				<p>&nbsp;</p>
			</div>

			<?php
			$didtoggle = "true";
		}
	}

	if ($didtoggle != "true") { ?>

		<div class="wpmem_msg" align="center">
			<p>&nbsp;</p>
			<p><b>Sorry, <?php echo $themsg; ?></b></p>
			<p>&nbsp;</p>
		</div>

	<?php }
}


function wpmem_inc_regemail($user_id,$password,$pwdreset='false')
{
	/*
	here you can customize the message that is sent to
	a user when they request a reminder of their login info
	*/
	$user = new WP_User($user_id);

	$user_login = stripslashes($user->user_login);
	$user_email = stripslashes($user->user_email);

	$blogname = get_settings('blogname');
	$the_permalink = $_REQUEST['redirect_to'];
	$admin_email = get_settings('admin_email');
	/*
	You may edit below this line,
	  but be careful not to change variables */

	// set the subject line of the message
	$subj = "Your registration info for $blogname";

	// set the body of the message
	if ($pwdreset == "false") {
		//this is a new registration
		$body = "Thank you for registering for $blogname\r\n\r\n";
		$body.= "Your registration information is below.\r\n\r\n";
		$body.= "You may wish to retain a copy for your records.\r\n\r\n";
		$body.= "username: $user_login\r\n";
	}else{
		//this is not a new registration
		$body = "Your password has been reset for $blogname\r\n\r\n";
		$body.= "Your new password is included below.\r\n\r\n";
		$body.= "You may wish to retain a copy for your records.\r\n\r\n";
	}

	$body.= "password: $password\r\n\r\n";
	$body.= "You may login here:\r\n";
	$body.= "$the_permalink\r\n\r\n";
	$body.= "-----------------------------------\r\n";
	$body.= "This is an automated message \r\n";
	$body.= "from $blogname\r\n";
	$body.= "Please do not reply to this address\r\n";

	// end edits for function wpmem_inc_regemail()
	$headers = 'From: '.$blogname.' <'.$admin_email.'>' . "\r\n\\";
	wp_mail($user_email, $subj, $body, $headers);

}


function wpmem_inc_dialog_title()
{
	$wpmem_dialog_title_arr = array(
    	"Restricted post (or page), displays above the login/registration form",
        "Username is taken",
        "Email is registered",
        "Registration completed",
        "User update",
        "Passwords did not match",
        "Password changes",
        "Username or email do not exist when trying to reset forgotten password",
        "Password reset"
    );
	return $wpmem_dialog_title_arr;
}


/*****************************************************
END DIALOG OUTPUT FUNCTIONS
*****************************************************/



/*****************************************************
BEGIN ADMIN FEATURES
*****************************************************/


add_action('edit_user_profile', 'wpmem_admin_fields');
function wpmem_admin_fields()
{
	$user_id = $_REQUEST['user_id']; ?>

	<h3>Newsletter preferences</h3>
 	<table class="form-table">
		<?php
		$wpmem_fields = get_option('wpmembers_fields');
		for ($row = 0; $row < count($wpmem_fields); $row++) {

			if($wpmem_fields[$row][6] == "n" && $wpmem_fields[$row][4] == "y") { ?>

				<tr>
					<th><label><?php echo $wpmem_fields[$row][1]; ?></label></th>
					<td>
<?
// WTZ performs check whether WTZ properties plugin is activated and uses its function to show drop down
if ($wpmem_fields[$row][3] == 'areas_drop_down' and function_exists('pr_edit_subform'))
	{
	wpmem_create_formfield($wpmem_fields[$row][2],$wpmem_fields[$row][3],get_usermeta($user_id,$wpmem_fields[$row][2]),'');
	}
	elseif ($wpmem_fields[$row][3] == 'checkbox')
	{
	wpmem_create_formfield($wpmem_fields[$row][2],$wpmem_fields[$row][3],get_usermeta($user_id,$wpmem_fields[$row][2]),'on');
	}
	elseif($wpmem_fields[$row][3] == 'bedroom_drop_down' and function_exists('pr_edit_subform'))
	{
		wpmem_create_formfield($wpmem_fields[$row][2],$wpmem_fields[$row][3],get_usermeta($user_id,$wpmem_fields[$row][2]),'');
	}
	elseif($wpmem_fields[$row][3] == 'price_drop_down' and function_exists('pr_edit_subform'))
	{
	wpmem_create_formfield($wpmem_fields[$row][2],$wpmem_fields[$row][3],get_usermeta($user_id,$wpmem_fields[$row][2]),'');
	}
	elseif($wpmem_fields[$row][3] == 'rent_drop_down' and function_exists('pr_edit_subform'))
	{
	wpmem_create_formfield($wpmem_fields[$row][2],$wpmem_fields[$row][3],get_usermeta($user_id,$wpmem_fields[$row][2]),'');
	}
	else {
?>
					<input id="<?php echo $wpmem_fields[$row][2]; ?>" type="text" class="input" name="<?php echo $wpmem_fields[$row][2]; ?>" value="<?php echo get_usermeta($user_id,$wpmem_fields[$row][2]);?>" size="25" />

<?
		}
?>
					</td>
				</tr>

			<?php }

		} ?>
	</table><?php
}


add_action('profile_update', wpmem_admin_update);
function wpmem_admin_update()
{
	$user_id = $_REQUEST['user_id'];
	$wpmem_fields = get_option('wpmembers_fields');
	for ($row = 0; $row < count($wpmem_fields); $row++) {
		if ($wpmem_fields[$row][6] == "n") {update_user_meta($user_id,$wpmem_fields[$row][2],$_POST[$wpmem_fields[$row][2]]);}
	}
}

add_action('admin_menu', 'wpmem_admin_options');
function wpmem_admin_options()
{
	add_options_page('WP-Members', 'WP-Members', 8, basename(__FILE__), 'wpmem_admin');
}


function wpmem_admin()
{
	$wpmem_settings         = get_option('wpmembers_settings');
	$wpmem_fields           = get_option('wpmembers_fields');
	$wpmem_dialogs          = get_option('wpmembers_dialogs');
	$wpmem_dialog_title_arr = wpmem_inc_dialog_title();

	switch ($_POST['wpmem_admin_a']) {

	case ("update_settings"):

		check_admin_referer('wpmem-update-settings');

		$wpmem_newsettings = array(
			WP_MEM_VERSION,
			$_POST['wpmem_settings_block_posts'],
			$_POST['wpmem_settings_block_pages'],
			$_POST['wpmem_settings_ignore_warnings']
		);

		update_option('wpmembers_settings',$wpmem_newsettings);
		$wpmem_settings = $wpmem_newsettings;
		$did_update = "true";
		break;

	case ("update_fields"):

		check_admin_referer('wpmem-update-fields');

		//rebuild the array, don't touch user_email - it's always mandatory
		for ($row = 0; $row < count($wpmem_fields); $row++) {

			for ($i = 0; $i < 4; $i++) {
				$wpmem_newfields[$row][$i] = $wpmem_fields[$row][$i];
			}

			$display_field = $wpmem_fields[$row][2]."_display";
			$require_field = $wpmem_fields[$row][2]."_required";

			if ($wpmem_fields[$row][2]!='user_email'){
				if ($_POST[$display_field] == "on") {$wpmem_newfields[$row][4] = 'y';}
				if ($_POST[$require_field] == "on") {$wpmem_newfields[$row][5] = 'y';}
			} else {
				$wpmem_newfields[$row][4] = 'y';
				$wpmem_newfields[$row][5] = 'y';
			}

			if ($wpmem_newfields[$row][4] != 'y' && $wpmem_newfields[$row][5] == 'y') { $chkreq = "err"; }
			$wpmem_newfields[$row][6] = $wpmem_fields[$row][6];
		}

		update_option('wpmembers_fields',$wpmem_newfields);
		$wpmem_fields = $wpmem_newfields;
		$did_update = "true";
		break;

	case ("update_dialogs"):

		check_admin_referer('wpmem-update-dialogs');

		for ($row = 0; $row < count($wpmem_dialogs); $row++) {
			$dialog = "dialogs_".$row;
			$wpmem_newdialogs[$row] = $_POST[$dialog];
		}

		update_option('wpmembers_dialogs',$wpmem_newdialogs);
		$wpmem_dialogs = $wpmem_newdialogs;
		$did_update = "true";
		break;

	}

	?>
    <div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
    <h2>WP-Members <?php _e('Settings'); ?></h2>

    <?php
	if ($did_update == "true") {

		if ($chkreq == "err") { ?>
			<div class="error"><p><strong>Settings were saved, but you have required field that are not set to display!</strong><br /><br />Note:
				This will not cause an error for the end user, as only displayed fields are validated.  However, you should still check that
				your displayed and required fields match up.  Mismatched fields are highlighted below.</p></div>
		<?php } else { ?>
			<div id="message" class="updated fade"><p><strong>Settings saved.</strong></p></div>
		<?php }

	}

	if (get_option('users_can_register') != 0 && $wpmem_settings[3] == 0) { ?>

		<div class="error"><p><strong>Your WP settings allow anyone to register - this is not the recommended setting.</strong>  You can <a href="options-general.php">change this here</a> making sure the box next to "Anyone can register" is unchecked.</p> [<span title="This setting allows a link on the /wp-login.php page to register using the WP native registration process thus circumventing any registration you are using with WP-Members. In some cases, this may suit the users wants/needs, but most users should uncheck this option. If you do not change this setting, you can choose to ignore these warning messages under WP-Members Settings.">why is this?</span>]</div>

	<?php }

	if (get_option('comment_registration') !=1 && $wpmem_settings[3] == 0) { ?>

		<div class="error"><p><strong>Your WP settings allow anyone to comment - this is not the recommended setting.</strong>  You can <a href="options-discussion.php">change this here</a> by checking the box next to "Users must be registered and logged in to comment."</p> [<span title="This setting allows any users to comment, whether or not they are registered. Depending on how you are using WP-Members will determine whether you should change this setting or not. If you do not change this setting, you can choose to ignore these warning messages under WP-Members Settings.">why is this?]</div>

	<?php } ?>

	<p><strong><a href="http://butlerblog.com/wp-members/" target="_blank">WP-Members</a> Version: <?php echo WP_MEM_VERSION; ?></strong>
		[ Follow ButlerBlog: <a href="http://feeds.butlerblog.com/butlerblog" target="_blank">RSS</a> | <a href="http://www.twitter.com/butlerblog" target="_blank">Twitter</a> ]
		<br />
		If you find this plugin useful, please consider making a donation <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="hosted_button_id" value="QC2W6AM9WUZML">
	<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>
	</p>
	<h3>Manage Options</h3>
		<form name="updatesettings" id="updatesettings" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?page=wp-members.php">
		<?php if ( function_exists('wp_nonce_field') ) { wp_nonce_field('wpmem-update-settings'); } ?>
		<table class="form-table">
		<?php $arr = array(
			array('Block Posts by default?','wpmem_settings_block_posts'),
			array('Block Pages by default?','wpmem_settings_block_pages'),
			array('Ignore admin warning messages?','wpmem_settings_ignore_warnings') ); ?>
		<?php for ($row = 0; $row < count($arr); $row++) { ?>
		  <tr valign="top">
			<th align="left" scope="row"><?php echo $arr[$row][0]; ?></th>
			<td><select name="<?php echo $arr[$row][1]; ?>">
				<option value="1" <?php if ($wpmem_settings[$row+1]==1) {echo "selected";}?>>Yes</option>
				<option value="0"  <?php if ($wpmem_settings[$row+1]==0) {echo "selected";}?>>No</option>
			</select></td>
		  </tr>
		  <?php if ($row == 1) { ?>
		  <tr valign="top">
			<td colspan="2"><small><i>(Posts and Pages can be individually blocked or unblocked at the article level)</i></small></td>
		  </tr>
		  <?php } ?>
		<?php } ?>
		  <tr valign="top">
			<td>&nbsp;</td>
			<td><input type="hidden" name="wpmem_admin_a" value="update_settings">
				<input type="submit" name="UpdateSettings" value="Update Settings &raquo;" style="font-weight: bold;" tabindex="4" class="button" />    </td>
		  </tr>
		</table>
	</form>
	<p>&nbsp;</p>
	<h3><?php _e('Manage Fields'); ?></h3>
    <p><?php _e('Determine which fields will display and which are required.  This includes all fields, both native WP fields and WP-Members custom fields.  (Note: Email is always mandatory. and cannot be changed.)'); ?></p>
    <form name="updatefieldform" id="updatefieldform" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?page=wp-members.php">
	<?php if ( function_exists('wp_nonce_field') ) { wp_nonce_field('wpmem-update-fields'); } ?>
	<table class="widefat">
		<thead><tr class="head">
        	<th scope="col" align="right"><?php _e('Field Label') ?></th>
			<th scope="col" align="center"><?php _e('Display?') ?></th>
            <th scope="col" align="center"><?php _e('Required?') ?></th>
            <th scope="col" align="center"><?php _e('WP Native?') ?></th>
        </tr></thead>
	<?php
	// order, label, optionname, input type, display, required, native
	$class = '';
	for ($row = 0; $row < count($wpmem_fields); $row++) {
		if ($chkreq == "err" && $wpmem_fields[$row][5] == 'y' && $wpmem_fields[$row][4] != 'y') {
			$class = "updated fade";
		} else {
			$class = ($class == 'alternate') ? '' : 'alternate';
		}
		?><tr class="<?php echo $class; ?>" valign="top">
        	<td><?php
				echo $wpmem_fields[$row][1];
				if ($wpmem_fields[$row][5] == 'y'){ ?><font color="red">*</font><?php }
				?>
            </td>
			<td><?php if ($wpmem_fields[$row][2]!='user_email'){ wpmem_create_formfield($wpmem_fields[$row][2]."_display",'checkbox', 'y', $wpmem_fields[$row][4]); } ?></td>
            <td><?php if ($wpmem_fields[$row][2]!='user_email'){ wpmem_create_formfield($wpmem_fields[$row][2]."_required",'checkbox', 'y', $wpmem_fields[$row][5]); } ?></td>
			<td><?php if ($wpmem_fields[$row][6] == 'y') { echo "yes"; }?></td>
          </tr><?php
	}	?>
    	<tr>
        	<td colspan="6">
            	<input type="hidden" name="wpmem_admin_a" value="update_fields" />
        		<input type="submit" name="save" value="<?php _e('Update Fields'); ?> &raquo;" style="font-weight: bold;" class="button" />
            </td>
        </tr>
    </table>
    </form>
	<p>&nbsp;</p>
	<h3>WP-Members Dialogs and Error Messages</h3>
	<form name="updatedialogform" id="updatedialogform" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?page=wp-members.php">
	<?php if ( function_exists('wp_nonce_field') ) { wp_nonce_field('wpmem-update-dialogs'); } ?>
		<table class="form-table">
		<tr>
			<td colspan="2">You can customize the following text.  Simple HTML is allowed - &lt;p&gt;, &lt;b&gt;, &lt;i&gt;, etc.</td>
		</tr>
        <?php for ($row = 0; $row < count($wpmem_dialog_title_arr); $row++) { ?>
			<tr valign="top">
				<th scope="row"><?php echo $wpmem_dialog_title_arr[$row]; ?></th>
				<td><textarea name="<?php echo "dialogs_".$row; ?>" rows="3" cols="50" id="" class="large-text code"><?php echo $wpmem_dialogs[$row]; ?></textarea></td>
			</tr>
		<?php } ?>
			<tr valign="top">
				<th scope="row">&nbsp;</th>
				<td>
					<input type="hidden" name="wpmem_admin_a" value="update_dialogs" />
					<input type="submit" name="save" value="<?php _e('Update Dialogs'); ?> &raquo;" style="font-weight: bold;" class="button" />
				</td>
			</tr>
		</table>
	</form>
	<p>&nbsp;</p>
	<p><i>Thank you for using WP-Members! You are using version <?php echo WP_MEM_VERSION; ?>. If you find this plugin useful, please consider a <a href="http://butlerblog.com/wp-members">donation</a>.<br />
	  WP-Members is copyright &copy; 2006-2010 by Chad Butler, <a href="http://butlerblog.com">butlerblog.com</a> |
	  <a href="http://feeds.butlerblog.com/butlerblog" target="_blank">RSS</a> | <a href="http://www.twitter.com/butlerblog" target="_blank">Twitter</a></i></p>
	<p>&nbsp;</p>
</div>
<?php
}


/*****************************************************
END ADMIN FEATURES
*****************************************************/

// activation
register_activation_hook(__FILE__, 'wpmem_install');
function wpmem_install()
{
	if(!get_option('wpmembers_settings')) {

		// this is an upgrade from 2.1 or earlier

		$wpmem_settings = array(WP_MEM_VERSION,1,0,0);
		add_option('wpmembers_settings', $wpmem_settings, '', 'yes');

		$wpmem_fields_options_arr = array(
			// order, label, optionname, input type, display, required, native
			array (1,'Title','title','title','y','n','n'),
			array (2,'First Name','first_name','text','y','n','y'),
			array (3,'Last Name','last_name','text','y','n','y'),
			array (4,'Email','user_email','text','y','y','y'),
			array (5,'Landline number','phone1','text','y','n','n'),
			array (6,'Mobile number','mobile','text','y','n','n'),

/*
array (7,'For selling','sale','checkbox','y','n','n'),/// from here WTZ adds its own options
			array (8,'For renting','rent','checkbox','y','n','n'),
			array (9,'For letting','let','checkbox','y','n','n'),
			array (10,'For buying','buy','checkbox','y','n','n'),
			array (11,'Maximum price','price','price_drop_down','y','n','n'),
			array (12,'Maximum rent per week','rent_price','rent_drop_down','y','n','n'),
			array (13,'Minimum number of rooms','bedrooms','bedroom_drop_down','y','n','n'),
			array (14,'Areas','areas','areas_drop_down','y','n','n'),
*/
			array (15,'Address 1','addr1','text','n','n','n'),
			array (16,'Address 2','addr2','text','n','n','n'),
			array (17,'City','city','text','n','n','n'),
			array (18,'State','thestate','text','n','n','n'),
			array (19,'Zip','zip','text','n','n','n'),
			array (20,'Country','country','text','n','n','n'),
			array (21,'Website','user_url','text','n','n','y'),
			array (22,'AIM','aim','text','n','n','y'),
			array (23,'Yahoo IM','yim','text','n','n','y'),
			array (24,'Jabber/Google Talk','jabber','text','n','n','y'),
			array (25,'Bio','description','textarea','n','n','y'),
		);

		add_option('wpmembers_fields',$wpmem_fields_options_arr,'','yes');

		$wpmem_dialogs_arr = array(
			"Content is restricted to site members.  Site membership is free, register below. If you are an existing user, please login.",
			"Sorry, that username is taken, please try another.",
			"Sorry, that email address already has an account.<br />Please try another.",
			"Congratulations! Your registration was successful.<br /><br />You may now login using the password that was emailed to you.",
			"Your information was updated!",
			"Passwords did not match.<br /><br />Please try again.",
			"Password successfully changed!<br /><br />You will need to re-login with your new password.",
			"Either the username or email address do not exist in our records.",
			"Password successfully reset!<br /><br />An email containing a new password has been sent to the email address on file for your accont. You may change this random password when re-login with your new password."
		);

		add_option('wpmembers_dialogs',$wpmem_dialogs_arr,'','yes');
	}
}

//deactivation from WTZ
register_deactivation_hook(__FILE__, 'wpmem_deactivate');
function wpmem_deactivate()
{
	delete_option('wpmembers_fields');
	delete_option('wpmembers_dialogs');
	delete_option('wpmembers_settings');
}

// that's all folks!
?>