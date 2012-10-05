<?php
$date = '2010-12-01';

$date_save_format = 'Y-m-d';
$datetime_save_format = 'Y-m-d Hi:s';
function pr_date_save($date, $time = false){
	global $date_save_format,$datetime_save_format;

	$date = new DateTime($date);
	if ($time == true) {
		$date = $date->format($datetime_save_format);
	} else $date = $date->format($date_save_format);

	return $date;
}
//echo pr_date_save($date);
	//$date = new DateTime($date);
	//$date = $date->format($date_save_format);
	$date = pr_date_save($date);
	echo $date;
?>