<?php

/**
 * some 3rd party functions
 *
 * @version $Id$
 * @copyright 2011
 */

function pr_3rd_array_to_object($array = array()) {
	if (!empty($array)) {
		$data = false;
		foreach ($array as $akey => $aval) {
			$data -> {$akey} = $aval;
		}
		return $data;
	}
	return false;
}

function pr_3rd_isValidEmail($email){
	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
}

// Vitalyk's function
function chopsentences($n, $option)
{
	$n=strip_tags($n);
	$sentences=preg_split('/[.|!|?]+/',$n);
	foreach($sentences as $k=>$v){
		$words=preg_split('/ /',$v);
		$total+=count($words);$res.=$v.'.';
		if($total>=$option)break;
	}
	return $res.'..';
}
?>