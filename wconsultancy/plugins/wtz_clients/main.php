<?php

/*
   Plugin Name: WTZ Clients plugin
   Plugin URI:
   Description: Clients management
   Version: 1
   Author: Matvienko Ilya
   Author URI:
*/
register_activation_hook(__FILE__, 'wtz_cl_activate');
register_deactivation_hook(__FILE__, 'wtz_cl_deactivate');

function wtz_cl_activate(){
	global $wpdb;
	$sql = '

';
}
function wtz_cl_deactivate(){
	global $wpdb;
}
?>