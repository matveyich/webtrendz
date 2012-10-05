<?php

/**
 * cron funcs
 *
 * version 1
 * copyright 2011
 */


function prc_check_baskets(){
	global $wpdb,$pr_baskets;
	$uq = "UPDATE $pr_baskets SET active=0 WHERE now() > enddate + INTERVAL 1 DAY and active = 1";
	$_affected_rows = $wpdb->query($uq);
/*
	$wpdb->show_errors();
	$wpdb->print_error();
*/
	//print_r($_affected_rows);
	if ($_affected_rows != FALSE) {
		prc_write_log($_affected_rows.' basket(s) were deactivated');
	}

}

function prc_write_log($comment){
	global $wpdb,$pr_log;
	$iq = "INSERT INTO $pr_log (eventid,comment,eventdate) VALUES (NULL,'$comment',now())";
	$wpdb->query($iq);
/*
	$wpdb->show_errors();
	$wpdb->print_error();
*/
}

?>