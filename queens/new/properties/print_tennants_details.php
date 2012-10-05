<?php
require('../../../wp-config.php');
require('config.php');

pr_add_admin_head();

if (isset($_GET['user_id'])) {
	prf_tennants_print($_GET['user_id']);
}
?>