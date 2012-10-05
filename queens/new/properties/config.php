<?
/**
 *
 * @module properties
 * @version 1
 * @copyright 2011
 */


/*
ini_set('display_errors', 1);
error_reporting(E_ALL);
  */
global $pr_properties, $pr_areas, $pr_area_types, $pr_prefix, $pr_version, $pr_prop_types,$pr_per_page,$pr_upload_files,$pr_upload_pictures, $pr_pic_table, $pr_video_table, $pr_files_table, $pr_sales_page, $pr_lettings_page, $pr_areas_page, $pr_area_types_page, $pr_properties_page;

//////////////////////////////////////////////
//prefix
$pr_prefix = "pr_";
$prf_prefix = "prf_";

//////////////////////////////////////////////
//date
$date_save_format = 'Y-m-d';
$datetime_save_format = 'Y-m-d H:i:s';


//////////////////////////////////////////////
//slug
//////////////////////////////////////////////
$pr_slug = "pr-search";
$pr_newsletter_slug = 'pr-newsletter';
$pr_user_properties_slug = 'pr-properties';
$pr_user_downloads_slug = 'pr-downloads';
$pr_tennant_slug = 'pr-tennant';
$pr_avail_bands = 'pr-avail-bands';
$pr_user_bands = 'pr-my-bands';
$pr_user_basket = 'pr-my-basket';

//////////////////////////////////////////////
//seesion
$pr_sess_id = "pr-realestate-12345";

//////////////////////////////////////////////
//def pic
$pr_default_img = "default_img.jpg";


//////////////////////////////////////////////
//TABLES
//////////////////////////////////////////////
$pr_properties = $pr_prefix."properties";
$pr_property_types = $pr_prefix."property_types";
$pr_tmp_properties = $pr_prefix."tmp_properties";
$pr_areas = $pr_prefix."areas";
$pr_area_types = $pr_prefix."area_types";
$pr_area_codes = $pr_prefix."area_codes";
$pr_prop_types = $pr_prefix."prop_types";
$pr_pic_table = $pr_prefix."pictures";
$pr_pic_table_tmp = $pr_prefix."pictures_tmp";

$pr_video_table = $pr_prefix."videos";
$pr_tmp_video_table = $pr_prefix."tmp_videos";
$pr_files_table = $pr_prefix."files";
$pr_files_table_tmp = $pr_prefix."files_tmp";

$pr_bands = $pr_prefix."bands";
$pr_orders = $pr_prefix."orders";
$pr_order_details = $pr_prefix."order_details";
$pr_tennants_details = $pr_prefix."tennants_details";

$pr_band_types = $pr_prefix.'band_types';// types of bands
$pr_bands_new = $pr_prefix.'bands_new';// bands
$pr_baskets = $pr_prefix.'baskets';// bands, which are assigned to users
$pr_user_baskets = $pr_prefix.'carts'; // users' baskets
$pr_carts = $pr_user_baskets;//

$pr_log = $pr_prefix.'log';

//////////////////////////////////////////////
//PATHS
//////////////////////////////////////////////
$pr_upload_dir = "/upload/";
$pr_export_dir = "/export/";
$pr_plugin_url = "/wp-content/plugins/properties";
$pr_tmp_pics = "upload/tmp/"; // for AJAX use

$pr_img_show_folder = get_bloginfo('url').$pr_plugin_url.$pr_upload_dir.'pictures/';
$pr_tmp_show_folder = get_bloginfo('url').$pr_plugin_url.'/'.$pr_tmp_pics;
$pr_img_show_folder_thumbs = get_bloginfo('url').$pr_plugin_url.$pr_upload_dir.'pictures/thumbs/';
$pr_file_show_folder = get_bloginfo('url').$pr_plugin_url.$pr_upload_dir.'files/';
$pr_upload = dirname(__FILE__).$pr_upload_dir;
$pr_upload_files = $pr_upload .'files/';
$pr_upload_pictures = $pr_upload .'pictures/';
$pr_upload_pictures_tmp = $pr_upload .'tmp/';
$pr_upload_thumbs = $pr_upload_pictures.'thumbs/';
$pr_plugin_images = get_bloginfo('url').$pr_plugin_url.'/images/';


//////////////////////////////////////////////
// some constants
//////////////////////////////////////////////
$pr_infinity_date = '2099-01-01'; // this date is used to define those date which area infinite on site
$pr_unlimited_amount = 0;
$pr_unlimited_period = 0;

$pr_wrong_input_class = 'wrong_input';

$pr_version = 1;
$pr_per_page = 20;//properties per page
$pr_maxthumbw = 150; // thumb width
$pr_maxthumbh = 130; // thumb height


//////////////////////////////////////////////
//for admin menu
//////////////////////////////////////////////
$pr_sales_page = 'properties/salesmngr.php';
$pr_lettings_page = 'properties/lettingsmngr.php';
$pr_areas_page = 'properties/areamngr.php';
$pr_area_types_page = 'properties/areatypesmngr.php';
$pr_properties_page = 'properties/manager.php';
$pr_prop_types_page = 'properties/proptypesmngr.php';
$pr_downloads_page = 'properties/downloads.php';
$pr_invoices_page = 'properties/invoices.php';
$pr_filter_page = 'properties/filter.php';

//////////////////////////////////////////////
// user additional menu
$prf_action_add_property = $prf_prefix.'add_property';

$pr_newsletters_page = 'properties/newsletters.php';
$pr_export_page = 'export';
//paypal want to move this to an options page later in admin panel
/*
$pr_seller_mail = "matvey_1281359411_biz@gmail.com";
$pr_data_send_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
$pr_token = "Qtw6luJnqWQcC1ry3KWvUxqOLWLkeapxVF1WeKiElqYWkz_0Wn9zIebP-68";
*/

//////////////////////////////////////////////
// WP options
//////////////////////////////////////////////
$pr_paypal_opt = $pr_prefix.'paypal_opt';
$pr_paypal_page = get_bloginfo('url').'/paypal_edit.php';
$pr_paypal_recur_period = 30; //days
$pr_paypal_ipn_log = dirname(__FILE__).'/paypal/ipn/IPN.log';


$pr_option_DG = array('DG'=>'DG','DGI'=>'DGI'); // Digital group option name

// some global variables for several functions
	$_today = date('Y-m-d');
	$_lettings_date_check = "
		(pr.extra_date_displ_from <= '".$_today."' OR pr.extra_date_displ_from = '0000-00-00')
		AND
		(pr.extra_date_displ_to >= '".$_today."' OR pr.extra_date_displ_to = '0000-00-00')";
	$_sales_date_check = "
		pr.extra_date_displ_from <= '".$_today."'
		AND
		pr.extra_date_displ_to >= '".$_today."'";
	$_featured_date_check = "
		(extra_date_displ_from <= '".$_today."' OR extra_date_displ_from = '0000-00-00')
		AND
		(extra_date_displ_to >= '".$_today."' OR extra_date_displ_to = '0000-00-00')";

//////////////////////////////////////////////
// EXPORT Settings
//////////////////////////////////////////////

//Arrays
$furnishing = array(
	0 => 'false',
	1 => 'true'
	);
$selling_state = array(
	1 => array('code'=>'L','name'=>'Let'),
	2 => array('code'=>'V','name'=>'Available'),// code for Viewing from export doc
	3 => array('code'=>'N','name'=>'New instruction'),
	4 => array('code'=>'S','name'=>'Sold'),
	5 => array('code'=>'U','name'=>'Under offer'),
	6 => array('code'=>'H','name'=>'Hidden')
);
$property_tenure = array(
	1=> array('code'=>'F','name'=>'Freehold'),
	2=> array('code'=>'S','name'=>'Share of Freehold'),
	3=> array('code'=>'L','name'=>'Leasehold'),
	4=> array('code'=>'X','name'=>'Not specified'),
);
// Export FTP
$pr_export_ftp_host = 'ftp2.primelocation.com';//'ftp.queensparkrealestates.co.uk';
$pr_export_ftp_user = 'QPREGR';//'queensparkrealestates.co.uk';
$pr_export_ftp_pwd = 'lngvleroibho2';'r/nqgHssE';

$exclude_areas = array('United Kingdom');
$exclude_areas_ids = array(222);
$pr_non_international = $exclude_areas;


//////////////////////////////////////////////
//WTZ Notifications options
//////////////////////////////////////////////
$pr_ntf_opt = $pr_prefix.'ntf_opt';
$pr_ntf_opt_names = $pr_prefix.'ntf_opt_names';
//WTZ Notifications hooks
//User adds paid property - do_action arg2 = $pr_u_adds_pp - MODIFIED to USER ADDS PROPERTY(whether it is paid or not)
$pr_u_adds_pp = $pr_prefix.'u_adds_pp';
//User adds not paid property - do_action arg2 = $pr_u_adds_npp - DEPRICATED
$pr_u_adds_npp = $pr_prefix.'u_adds_npp';
//User pays for property - do_action arg2 = $pr_u_adds_pfp
$pr_u_adds_pfp = $pr_prefix.'u_adds_pfp';
// Notifications tags
$pr_ntf_tags = array('{user_firstname}', '{user_lastname}', '{user_email}', '{date}', '{admin_property_link}', '{frontend_property_link}');

/// more hooks
$pr_add_property_hook = $pr_prefix.'add_property';
$pr_update_property_hook = $pr_prefix.'update_property';

$pr_letting_form_hook = $pr_prefix.'letting_form_hook';
$pr_sale_form_hook = $pr_prefix.'sale_form_hook';
?>