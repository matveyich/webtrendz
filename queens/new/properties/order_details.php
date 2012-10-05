<?
ini_set('display_errors', 1);
error_reporting(E_ALL);

require('../../../wp-config.php');
//require('../../../wp-includes/wp-db.php');
//require('../../../wp-includes/general-template.php');
require('config.php');
$wpdb = new wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST );
	// as we call wpdb class directly, which is not recommended, we initialize some of the tables
	$wpdb->users = $table_prefix.'users';
	$wpdb->usermeta = $table_prefix.'usermeta';
	
if (isset($_GET['order_id']))
{
//print_r($_SESSION);
$curr_user = get_userdata($_SESSION['current_user_id']);
//echo $curr_user->user_level;

	$results = $wpdb->get_results($wpdb->prepare("SELECT details, price FROM $pr_order_details WHERE order_id = %d",$_GET['order_id']));

	$_order = $wpdb->get_results($wpdb->prepare("SELECT ID,user_id,total,status,transaction_id,date_issued,date_completed FROM $pr_orders WHERE ID = %d",$_GET['order_id']));

		
?>
<html dir="ltr" lang="en-US">

<head>
<meta charset="UTF-8" />
<title>Order details | Queens Park Real Estates</title>
<link rel='stylesheet' href='<?bloginfo('url')?>/wp-content/themes/queens/css/shared/layout.css' type='text/css' media='all' />

</head>

<body class="popup">
<?
if ($curr_user->user_level>=8 || $_order[0]->user_id == $_SESSION['current_user_id'])
{
	
	foreach($_order as $order)//should be only one as ID is primary key
	{
		echo "<div id='content' class='orderDetails'>";
		echo "<h3>Order details</h3>";
		echo "<p>Order id: $order->ID</p>";
		echo "<p>Total: $order->total</p>";
		echo "<p>Transaction ID: $order->transaction_id</p>";
		echo "<p>Status: $order->status</p>";
		echo "<p>Date issued: $order->date_issued</p>";
		if ($order->date_completed != NULL) echo "<p>Date completed: $order->date_completed</p>";
		
		echo "<h3>User details</h3>";
		if (! $u_info = get_userdata($order->user_id)) echo "Can't get user data";		
		//print_r($u_info);
		if ($u_info->user_firstname!=NULL) echo "<p>Name: $u_info->user_firstname</p>";
		if ($u_info->user_lastname!=NULL) echo "<p>Last name: $u_info->user_lastname</p>";
		if ($u_info->user_email!=NULL) echo "<p>Email: $u_info->user_email</p>";
		if ($u_info->phone1!=NULL) echo "<p>Landline number: $u_info->phone1</p>";
		if ($u_info->mobile!=NULL) echo "<p>Cell: $u_info->mobile</p>";
		
	}
	?>

<h3>User properties in this order</h3>	
<table class="widefat">
<thead>
<tr>
	<th class="manage-column column-title">Address</th>
	<th class="manage-column column-title">Price</th>
</tr>	
</thead>
<tbody>
<?
	foreach($results as $order)
	{
?>
    <tr>
		<td>
		<?
		echo $order->details;
		?>
		</td>
		<td>
		<?echo $order->price;?>
		</td>
    </tr>    
<?
	}
?>
    </tbody>
</table>
</div>
<?
}
else {
?>
	<h3>You don't have rights to view this page. If you think this is a mistake, ask administrator about it.</h3>
<?
}
?>
</body>

</html>
	<?
	
}
?>