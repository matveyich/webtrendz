<?php
/*
ini_set('display_errors', 1);
error_reporting(E_ALL);
*/
require('../../../wp-config.php');
require('config.php');
//require('../../../wp-includes/wp-db.php');
//require('../../../wp-includes/general-template.php');

//require('funcs.php');
//require('front_funcs.php');

/* Note: This thumbnail creation script requires the GD PHP Extension.  
		If GD is not installed correctly PHP does not render this page correctly
		and SWFUpload will get "stuck" never calling uploadSuccess or uploadError
	 */

	// Get the session Id passed from SWFUpload. We have to do this to work-around the Flash Player Cookie Bug
	if (isset($_POST["PHPSESSID"])) {
		session_id($_POST["PHPSESSID"]);
	}

	session_start();

	// Check the upload
	if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
		header("HTTP/1.1 500 Internal Server Error");
		echo "invalid upload";
		exit(0);
	}
switch($_POST['upload_type'])
	{
	case "pic":
	
	// Get the image and create a thumbnail
	$img = @imagecreatefromjpeg($_FILES["Filedata"]["tmp_name"]);
	if (!$img) {
		header("HTTP/1.1 500 Internal Server Error");
		echo "could not create image handle";
		exit(0);
	}

	$width = imageSX($img);
	$height = imageSY($img);

	if (!$width || !$height) {
		header("HTTP/1.1 500 Internal Server Error");
		echo "Invalid width or height";
		exit(0);
	}
		
	// Build the thumbnail
	$target_width = 100;
	$target_height = 100;
	$target_ratio = $target_width / $target_height;

	$img_ratio = $width / $height;

	if ($target_ratio > $img_ratio) {
		$new_height = $target_height;
		$new_width = $img_ratio * $target_height;
	} else {
		$new_height = $target_width / $img_ratio;
		$new_width = $target_width;
	}

	if ($new_height > $target_height) {
		$new_height = $target_height;
	}
	if ($new_width > $target_width) {
		$new_height = $target_width;
	}

	$new_img = ImageCreateTrueColor(100, 100);
	if (!@imagefilledrectangle($new_img, 0, 0, $target_width-1, $target_height-1, 0)) {	// Fill the image black
		header("HTTP/1.1 500 Internal Server Error");
		echo "Could not fill new image";
		exit(0);
	}

	if (!@imagecopyresampled($new_img, $img, ($target_width-$new_width)/2, ($target_height-$new_height)/2, 0, 0, $new_width, $new_height, $width, $height)) {
		header("HTTP/1.0 500 Internal Server Error");
		echo "Could not resize image";
		exit(0);
	}

	if (!isset($_SESSION["file_info"])) {
		$_SESSION["file_info"] = array();
	}

	// Use a output buffering to load the image into a variable
	ob_start();
	imagejpeg($new_img);
	$imagevariable = ob_get_contents();
	ob_end_clean();

	$file_id = md5($_FILES["Filedata"]["tmp_name"] + rand()*100000);
	
	$_SESSION["file_info"][$file_id] = $imagevariable;

	echo $file_id;	// Return the file id to the script
	//$_ext = pr_file_extension($_FILES["Filedata"]["name"]);

			pr_upload_pic_tmp($_FILES["Filedata"],$file_id);
			
		break;		
		
		case "file":
		$file_id = md5($_FILES["Filedata"]["tmp_name"] + rand()*100000);
	
		//$_SESSION["file_info"][$file_id] = $imagevariable;

		echo $file_id;	// Return the file id to the script
			pr_upload_file_tmp($_FILES["Filedata"],$file_id);
			
		break;
	}
	//move_uploaded_file($_FILES["Filedata"]["tmp_name"],$pr_tmp_pics.$file_id.'.'.$_ext);
?>