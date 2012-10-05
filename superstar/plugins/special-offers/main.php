<?
/*
Plugin Name: WTZ special offers
Plugin URI: 
Description: This plugin adds special offers sections to content
Version: 1
Author: Matvienko Ilya
Author URI: 
*/

require_once (dirname (__FILE__) . '/funcs.php');

define('PLUG_NAME','Special-offers');
define('SO_VERSION',$so_version);
define('SO_URLPATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('SO_FOLDER', plugin_basename( dirname(__FILE__)) );

function so_destroy()
{
	global $wpdb;
	global $so_table,$so_destination_table,$so_categories_table;
	
	require_once (dirname (__FILE__) . '/config.php');
	require_once (dirname (__FILE__) . '/config.php');
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
/*
	$wpdb->query("DROP TABLE ".$so_table.";");
	$wpdb->query("DROP TABLE ".$so_destination_table.";");
	$wpdb->query("DROP TABLE ".$so_categories_table.";");
*/	
}

function so_create_db()
{
	global $wpdb;
	global $so_table,$so_destination_table,$so_categories_table,$so_version;
require_once (dirname (__FILE__) . '/config.php');
	add_option("so_version", $so_version);
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');	

	$table_name = $so_table;
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) 
	{
		
$sql = "
	CREATE TABLE " . $table_name . " (
`ID`  int NULL AUTO_INCREMENT ,
`destination`  smallint NULL ,
`category`  smallint NULL ,
`resort_name`  varchar(256) NULL ,
`room_type`  varchar(256) NULL ,
`num_of_nights`  varchar(256) NULL ,
`stars`   varchar(256) NULL ,
`tour_type`  varchar(256) NULL ,
`direct_flights`  varchar(512) NULL ,
`departure_date`  varchar(128) NULL ,
`board_type`  varchar(256) NULL ,
`price`  varchar(256) NULL ,
`link`  varchar(512) NULL ,
`img_src`  varchar(512) NULL ,
`featured`  tinyint NULL DEFAULT 0 ,
PRIMARY KEY (`ID`)
)
;";
dbDelta($sql);

	}	
	
	$table_name = $so_destination_table;
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) 
	{
		
$sql = "
CREATE TABLE " . $table_name . " (
`ID`  int NULL AUTO_INCREMENT ,
`Name`  varchar(256) NULL ,
`gid` int NULL,
`pid` int NULL,
PRIMARY KEY (`ID`)
)
;";
dbDelta($sql);

	}	
	
	$table_name = $so_categories_table;
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) 
	{
		
$sql = "
CREATE TABLE " . $table_name . " (
`ID`  int NULL AUTO_INCREMENT ,
`Name`  varchar(256) NULL ,
PRIMARY KEY (`ID`)
)
;";
dbDelta($sql);

	}


}

$role = get_role('administrator');
if(!$role->has_cap('manage_so'))
{
  $role->add_cap('manage_so');
  $view_level= 'administrator';
}
$erole = get_role('editor');
if(!$erole->has_cap('manage_so'))
{
  $erole->add_cap('manage_so');
  $view_level= 'administrator';
}

if(function_exists('add_action'))
{

  // Add the admin menu
add_action( 'admin_menu', 'so_menu');

}
add_filter('the_content','so_show_offers');

//////////// upgrades

$current_ver = get_option( "so_version" );

if ($current_ver != $so_version) 
{
	so_upgrade_plugin($so_version);
}

///////////
register_activation_hook(__FILE__,'so_create_db');
register_deactivation_hook( __FILE__, 'so_destroy' );


?>