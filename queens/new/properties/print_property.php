<?php
require('../../../wp-config.php');
require('config.php');

pr_add_admin_head();

if (isset($_GET['prid'])) {
	pr_print_property($_GET['prid']);
}
?>