<?php
require('../../../wp-config.php');
require('config.php');
//print_r($_POST);
pr_update_tmp_property(); // this function is in funcs.php
/*
$res = $wpdb->get_results("SELECT * FROM $pr_tmp_properties WHERE ID = ".$_POST['tmp_id']);
$wpdb->show_errors();
$wpdb->print_error();
print_r($res);
*/
?>