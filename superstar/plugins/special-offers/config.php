<?
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

global $so_table, $so_destination_table, $so_categories_table;
$so_prefix = "so_";
$so_table = $so_prefix."table";
$so_destination_table = $so_prefix."destination";
$so_categories_table = $so_prefix."categories";

$so_upload_dir = "/upload/";
$so_plugin_url = "/wp-content/plugins/special-offers";

$so_img_show_folder = get_bloginfo('url').$so_plugin_url.$so_upload_dir;
$so_upload = dirname(__FILE__).$so_upload_dir;
$so_version = 4;      

?>