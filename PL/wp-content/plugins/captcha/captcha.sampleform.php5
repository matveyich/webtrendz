<?php
/*
 This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; either version 2.1 of the License, or (at your option) any later version.
This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License for more details.
You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

Project: The CAPTCHA. A PHP function for creating and verifying CAPTCHA images. See documentation.html in this package for help
File: captcha.sampleform.php5 - This sample form shows The CAPTCHA in action
Official site of the project: www.thecaptcha.com
Author: Eugene Orlov <eugene.orlov@gmail.com>
Copyright: 2007 Eugene Orlov
Version: 1.0 October 2007

Make sure the path to the library is correct.
*/
include("captcha.function.php5");

session_start();

// Change this to your real email address:
$myemail = 'matveyich@gmail.com';

// Initialising the $error variable. At the start it is 0. Each field in this form is processed, and if something is wrong (empty input, wrong email address, invalid captcha code, etc) $error is incremented. Form will stop processing if $error is > 0.
$error = 0;
$name_text = 'Please enter your name';
$name = '';
$email_text = 'Please enter you email';
$email = '';
$message_text = 'Please enter your message';
$message = '';
$captcha_text = 'Please tell me you\'re not a spambot';

// This piece of code decides whether to show the form or to process it
if (!isset($_POST['action']) || $_POST['action'] != 'submit') {
	show_form();
	die;
}

// Ok, let's process the form
else {
	// Checking name
	if (empty($_POST['name'])) {
		$error .= 1;
		$name_text = '<span>Please enter your name</span>';
	} else {
		$error  .= 0;
		$name_text = 'your name';
		// Please note, that in 'real life' you have to do something like this with user's data: mysql_real_escape_string(strip_tags(trim($_POST['name'])));
		$name = strip_tags($_POST['name']);
	}
	
	// Checking email
	if (empty($_POST['email'])) {
		$error .= 1;
		$email_text = '<span>Please enter your email</span>';
	} elseif (!eregi('^[-!#$%&\'*+\\./0-9=?A-Z^_a-z{|}~]+'.'@'.'[-!#$%&\'*+\\/0-9=?A-Z^_a-z{|}~]+\.'.'[-!#$%&\'*+\\./0-9=?A-Z^_a-z{|}~]+$', $_POST['email'])) {
		$error .= 1;
		$email_text = '<span>Please enter correct email address</span>';
		$email = strip_tags($_POST['email']);
	} else {
		$error .= 0;
		$email_text = 'your email';
		$email = strip_tags($_POST['email']);
	}
	
	// Checking message
	if (empty($_POST['message'])) {
		$error .= 1;
		$message_text = '<span>Please enter your message</span>';
	} elseif ((strlen($_POST['message']) < 10)) {
		$error .= 1;
		$message_text = '<span>Please enter no less than 10 symbols</span>';
		$message = $_POST['message'];
	} else {
		$error .= 0;
		$message_text = 'your message';
		$message = $_POST['message'];
	}
	
	// Now let's check The CAPTCHA
	if (!captcha_verify_word()) {
		$error .= 1;
		$captcha_text = '<span>Wrong image code</span>';
	} else {
		$error .= 0;
	}
	
	// If $error is > 0, we'll show the form again
	if ($error > 0) {
		show_form();
		die;
	} else {
		// If everything is ok, we'll send an email
		$name = strip_tags(trim($_POST['name']));
		$email = strip_tags(trim($_POST['email']));
		$message = wordwrap(strip_tags(trim($_POST['message'])), 70);
		$email = 'From: '.$name.' <'.$email.'>';
		$subject = 'New message from your website!';
		mail($myemail, $subject, $message, $email);
		echo "Thank you for your message!";
		die();
	}
}

// This function shows the form
function show_form() {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<style type="text/css">
<!--
*, body, div, table  { font-family: Arial, Helvetica, sans-serif; font-size: 100%; }
h1 { font-size: 120%; font-weight: 400; letter-spacing: -0.08em; }
#myform { padding: 1%; }
#myform div { margin-bottom: 0.5em; }
#myform span { color: #FF0000; font-weight: 700; }
#myform input { border: 1px solid #CCCCCC; padding: 0.2em; background-color: #F9FDFF; }
#myform textarea { border: 1px solid #CCCCCC; padding: 0.2em; background-color: #F9FDFF; }
#myform button { border: 1px solid; background-color: #3366CC; color: #FFFFEE; border-left-color: #6DBFFF; border-top-color: #6DBFFF; border-bottom-color: #0C3F67; border-right-color: #0C3F67; }
-->
</style>
<title>My contact form</title>
</head>
<body>
<h1>Please feel free to leave your message:</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="myform">
<input type="hidden" name="action" value="submit">
<div><input name="name" type="text" tabindex="1" value="<?php echo $GLOBALS['name']; ?>">&nbsp;<?php echo $GLOBALS['name_text']; ?></div>
<div><input name="email" type="text" tabindex="2" value="<?php echo $GLOBALS['email']; ?>">&nbsp;<?php echo $GLOBALS['email_text']; ?></div>
<div><?php echo $GLOBALS['message_text']; ?><br>
<textarea name="message" cols="30" rows="6" tabindex="3"><?php echo $GLOBALS['message']; ?></textarea></div>
<div><?php echo $GLOBALS['captcha_text']; ?><br>
<img src="captcha.image.php5?nocache=<?php echo md5(time()); ?>" border="0"><br>
<input name="magicword" type="text" tabindex="4">
</div>
<div>Please fill in all the fields and press the button below</div>
<div><button type="submit" tabindex="5">Submit your message</button></div>
</form>
</body>
</html>
<?php
}
?>
