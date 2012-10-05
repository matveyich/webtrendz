<?
/*
Plugin Name: WTZ properties
Plugin URI:
Description: This plugin adds special offers sections to content
Version: 6
Author: Matvienko Ilya
Author URI:
*/

require_once (dirname (__FILE__) . '/config.php');

require_once (dirname (__FILE__) . '/funcs.php');
require_once (dirname (__FILE__) . '/init_funcs.php');
//require_once (dirname (__FILE__) . '/additinal_funcs.php');

require_once (dirname (__FILE__) . '/front_funcs.php');
require_once (dirname (__FILE__) . '/bands_funcs.php');
require_once (dirname (__FILE__) . '/user_basket_funcs.php');
require_once (dirname (__FILE__) . '/3rd_funcs.php');
require_once (dirname (__FILE__) . '/cron_funcs.php');

define('PLUG_NAME','Properties');
define('PR_VERSION',$pr_version);
define('PR_URLPATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('PR_FOLDER', plugin_basename( dirname(__FILE__)) );

function pr_destroy()
{
	global $wpdb;
	global $pr_properties, $pr_areas, $pr_area_types, $pr_version, $pr_paypal_opt;

	require_once (dirname (__FILE__) . '/config.php');
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	pr_pp_uninstall(); // paypal options are deleted on deactivation
/*
	$wpdb->query("DROP TABLE ".$pr_table.";");
*/
}

function pr_create_db()
{
	global $wpdb;
	global $pr_properties, $pr_areas, $pr_area_types, $pr_version, $pr_prop_types, $pr_pic_table, $pr_video_table, $pr_files_table, $pr_bands, $pr_orders, $pr_order_details, $pr_tennants_details,$pr_pic_table_tmp;

	add_option("pr_version", $pr_version);
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	pr_pp_install();//paypal option created

	$table_name = $pr_areas;
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name)
	{

$sql = "
CREATE TABLE ".$table_name." (
`ID`  int NOT NULL AUTO_INCREMENT ,
`name`  varchar(128) NOT NULL ,
`parent_id`  int NOT NULL DEFAULT 0 ,
`type` int(16)  NOT NULL DEFAULT 1 ,
`child_type` int(16)  NOT NULL DEFAULT 2 ,
`active` tinyint NOT NULL DEFAULT 0,
PRIMARY KEY (`ID`)
)
;";
//dbDelta($sql);
$wpdb->query($sql);
	}

	$table_name = $pr_bands;
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name)
	{


$sql = "
CREATE TABLE ".$table_name." (
`ID`  int NOT NULL AUTO_INCREMENT ,
`Name`  varchar(128) NOT NULL ,

PRIMARY KEY (`ID`)
)
;
INSERT INTO $table_name values (NULL,'Band A');
INSERT INTO $table_name values (NULL,'Band B');
INSERT INTO $table_name values (NULL,'Band C');

";
//bDelta($sql);
$wpdb->query($sql);
	}

	$table_name = $pr_area_types;
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name)
	{

$sql = "
CREATE TABLE ".$table_name." (
`ID`  int NOT NULL AUTO_INCREMENT ,
`name`  varchar(128) NOT NULL ,
`order_a`  int(16) NOT NULL default 0,
PRIMARY KEY (`ID`)
)
;";
//bDelta($sql);
$wpdb->query($sql);
	}

	$table_name = $pr_prop_types;
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name)
	{

$sql = "
CREATE TABLE `".$table_name."` (
`ID`  int NULL AUTO_INCREMENT,
`Name`  varchar(128) NOT NULL ,
PRIMARY KEY (`ID`)
)
;";
//bDelta($sql);
$wpdb->query($sql);
	}

	$table_name = $pr_pic_table;
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name)
	{

$sql = "
CREATE TABLE `".$table_name."` (
`ID`  int(32) NOT NULL AUTO_INCREMENT ,
`prid`  int(16) NOT NULL ,
`img_name`  varchar(128) NOT NULL ,
PRIMARY KEY (`ID`)
)
;";
//bDelta($sql);
$wpdb->query($sql);
	}
	$table_name = $$pr_pic_table_tmp;
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name)
	{

$sql = "
CREATE TABLE `".$table_name."` (
`ID`  int NOT NULL ,
`filename`  mediumtext NOT NULL ,
`user_id`  int NOT NULL ,
`identifier`  mediumtext NOT NULL ,
PRIMARY KEY (`ID`)
)
;";
//bDelta($sql);
$wpdb->query($sql);
	}

	$table_name = $pr_video_table;
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name)
	{

$sql = "
CREATE TABLE `".$table_name."` (
`ID`  int NOT NULL AUTO_INCREMENT ,
`prid`  int(16) NOT NULL ,
`title`  varchar(256) NULL ,
`url`  text(512) NULL ,
`descr`  text(1024) NULL ,
`yt_id`  varchar(256) NULL,
PRIMARY KEY (`ID`)
)
;";
//bDelta($sql);
$wpdb->query($sql);
	}

	$table_name = $pr_files_table;
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name)
	{

$sql = "
CREATE TABLE `".$table_name."` (
`ID`  int(16) NOT NULL AUTO_INCREMENT ,
`prid`  int(16) NOT NULL ,
`file_name`  varchar(128) NOT NULL ,
`title`  text(512) NULL,
PRIMARY KEY (`ID`)
)
;";
//bDelta($sql);
$wpdb->query($sql);
	}

	$table_name = $pr_orders;
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name)
	{

$sql = "
CREATE TABLE `".$table_name."` (
`ID`  int NOT NULL AUTO_INCREMENT ,
`total`  int NOT NULL ,
`user_id`  int NOT NULL ,
`reference`  varchar(512) NOT NULL ,
`status`  varchar(128) NOT NULL DEFAULT 'new' ,
`transaction_id` text(512) NULL,
`date_issued` datetime NOT NULL,
`date_completed` datetime NULL,
PRIMARY KEY (`ID`)
)
;";
//bDelta($sql);
$wpdb->query($sql);
	}

  $table_name = $pr_tennants_details;
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name)
	{

$sql = "
CREATE TABLE `".$table_name."` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `u_name` varchar(128) DEFAULT NULL,
  `address` text,
  `telephone` text,
  `birthdate` date DEFAULT NULL,
  `insurance` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `credit` tinyint(1) DEFAULT NULL,
  `pastaddr` text,
  `pastperiod` text,
  `employment` tinyint(4) DEFAULT NULL,
  `employer` mediumtext,
  `position` mediumtext,
  `salary` mediumint(9) DEFAULT NULL,
  `employer_addr` text,
  `rent_responsible` mediumtext,
  `employer_tel` mediumtext,
  `accountant_name` varchar(128) DEFAULT NULL,
  `accountant_addr` mediumtext,
  `accountant_tel` mediumtext,
  `landlord_name` varchar(128) DEFAULT NULL,
  `landlord_addr` mediumtext,
  `landlord_email` varchar(128) DEFAULT NULL,
  `landlord_tel` text,
  `bank_addr` mediumtext,
  `bank_sortcode` mediumtext,
  `bank_acc_name` mediumtext,
  `bank_acc_number` mediumtext,
  `ref_name` varchar(128) DEFAULT NULL,
  `ref_addr` mediumtext,
  `ref_tel` mediumtext,
  `ref_qual` mediumtext,
  `rel_relation` mediumtext,
  `other_children` mediumtext,
  `other_pets` mediumtext,
  `other_other` mediumtext,
  `declaration` tinyint(1) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
)
;";
//bDelta($sql);
$wpdb->query($sql);
	}

  $table_name = $pr_tennants_details;
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name)
	{

$sql = "
CREATE TABLE `".$table_name."` (
`ID`  int NOT NULL AUTO_INCREMENT ,
`details`  text NOT NULL ,
`price`  int NOT NULL ,
`order_id`  int NOT NULL ,
PRIMARY KEY (`ID`)
)
;";
//bDelta($sql);
$wpdb->query($sql);
	}

	$table_name = $pr_properties;
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name)
	{

$sql = "
CREATE TABLE ".$table_name." (
`ID`  int(16) NOT NULL AUTO_INCREMENT,
`sale_price`  int(11) NULL DEFAULT NULL ,
`let_weekrent`  int(11) NULL DEFAULT NULL ,
`descr`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`viewarrange`  varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`refnumber`  varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`area`  int(16) NULL DEFAULT NULL ,
`type`  int(16) NULL DEFAULT NULL ,
`bedroomnum`  tinyint(8) NULL DEFAULT NULL ,
`bathroomnum`  tinyint(8) NULL DEFAULT NULL ,
`receptionroomnum`  tinyint(8) NULL DEFAULT NULL ,
`addr_building_name`  varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`addr_door_number`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`addr_street`  varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`addr_city`  int(16) NULL DEFAULT NULL ,
`addr_county`  int(16) NULL DEFAULT NULL ,
`addr_country`  int(16) NULL DEFAULT NULL ,
`addr_postcode`  varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`extra_date_avail_from`  date NULL DEFAULT NULL ,
`extra_date_displ_from`  date NULL DEFAULT NULL ,
`extra_date_displ_to`  date NULL ,
`extra_active`  tinyint(1) NULL DEFAULT NULL ,
`extra_featured`  tinyint(1) NULL DEFAULT NULL ,
`extra_furnishing`  varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`extra_status`  tinyint(4) NULL DEFAULT NULL ,
`property_type`  int(4) NULL DEFAULT NULL ,
`user_id` int(16) NOT NULL DEFAULT 1 ,
`approved`  tinyint(1) NOT NULL DEFAULT 0,
`paid`  tinyint(1) NOT NULL DEFAULT 0,
`band_id`  tinyint(8) NULL DEFAULT 0,
`order_ref`  varchar(512) NULL,
`date_created`  datetime NULL,
`date_updated`  datetime NULL,
PRIMARY KEY (`ID`)
)
;";
//dbDelta($sql);
$wpdb->query($sql);
	}


}

$role = get_role('administrator');
if(!$role->has_cap('manage_pr'))
{
  $role->add_cap('manage_pr');
  $view_level= 'administrator';
}
$erole = get_role('editor');
if(!$erole->has_cap('manage_pr'))
{
  $erole->add_cap('manage_pr');
  $view_level= 'administrator';
}

if(function_exists('add_action'))
{

  // Add the admin menu
add_action('init', 'pr_init_');  // session initialization for search engine and its content area substitution
add_action( 'wp_head', 'pr_redirect');
add_action( 'admin_menu', 'pr_menu');
add_action('wp_head', 'pr_add_site_head');
//add_action('wp_loaded', 'pr_swfupload_init',1000);
add_action('admin_head', 'pr_add_admin_head');
add_action('edit_user_profile', 'prf_tennants_form');
add_action('profile_update', 'prf_tennants_submit');
add_action('delete_user','pr_user_prop_reassign'); // i also added here a check for baskets
add_filter('the_content', 'pr_content_filter'); // we substitute content of search page for search engine
// bands
add_action('edit_user_profile', 'prb_baskets_user_show'); // just showing baskets
add_action('profile_update', 'prb_baskets_user_update');

}

//////////// upgrades
pr_pp_init();
$current_ver = get_option( "pr_version" );
/*
if ($current_ver != $pr_version)
{
	pr_upgrade_plugin($pr_version);
}
*/
///////////
//register_activation_hook(__FILE__,'pr_create_db');
//register_deactivation_hook( __FILE__, 'pr_destroy' );


?>