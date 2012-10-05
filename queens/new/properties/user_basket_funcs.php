<?php

/**
 *
 * descr: functions to work with user carts
 * version 1
 * copyright 2011
 */
function prub_check_user_cart($user_id){
// checks for: user has bakset, basket type
	global $wpdb,$pr_carts,$pr_baskets;
	$sql = "SELECT * FROM $pr_carts WHERE userid = $user_id";
	$user_cart = $wpdb->get_results($sql,'ARRAY_A');
	$user_cart = $user_cart[0];
	//print_r($user_cart);
	if(sizeof($user_cart)>0){//user has a basket
		$sql = "SELECT COUNT(basketid) FROM $pr_baskets WHERE userid=$user_id AND user_cartid=".$user_cart['ubid']; // number of assigned bands to basket
		$user_cart['bands_number'] = $wpdb->get_var($sql);
/*
			$wpdb->show_errors();
			$wpdb->print_error();
		print_r($user_cart);
*/
		return $user_cart;
	} else return false;
}
function prub_create_user_cart($user_id,$band_type){
	// create new user band with band type
	global $wpdb,$pr_carts;
	$sql = "INSERT INTO $pr_carts (ubid,userid,band_type) VALUES (NULL,$user_id,$band_type)";
	$wpdb->query($sql);
//	$wpdb->show_errors();
//	$wpdb->print_error();
	// return last insert id
	return $wpdb->get_var("SELECT LAST_INSERT_ID()");
}
function prub_delete_user_cart($user_id){
	global $wpdb,$pr_carts;
	$sql = "DELETE FROM $pr_carts WHERE userid=$user_id";
	$wpdb->query($sql);
}
function prub_add_band_to_user_cart($user_id,$user_band_id){
// check if user has a basket.
// check if a basket of the same type as added band
// assigns user basket id to user band
// assigns band type to user basket
	global $wpdb,$pr_carts,$pr_baskets;
	$user_cart = prub_check_user_cart($user_id);
$_err = FALSE;
	$sql = "SELECT band_type FROM $pr_baskets WHERE basketid=$user_band_id";
	$band_type = $wpdb->get_var($sql);//type of band, which we try to assign
//	$wpdb->show_errors();
//	$wpdb->print_error();
	if($user_cart!=false){
		if($user_cart['band_type']==$band_type){
			$_err = FALSE;
		} else {
			// can't assign this type of band to current user's basket
			$_err = TRUE;
			return false;
		}
	} else {
		// create basket for user
		$user_cart['ubid'] = prub_create_user_cart($user_id,$band_type);
	//	echo 'cart created';



	}
	if($_err==FALSE){
		// assign user basket id to user band
		$sql = "UPDATE $pr_baskets SET user_cartid=".$user_cart['ubid']." WHERE basketid=$user_band_id";
		$wpdb->query($sql);
	//	echo 'basket assigned to cart.';
		return TRUE;
	} else return FALSE;
}

function prub_remove_basket_from_user_cart($user_id,$basket_id){
// if this band is last we delete the basket as well
	global $wpdb,$pr_carts,$pr_baskets;
	//$sql = "UPDATE $pr_baskets SET user_bandid=0 WHERE basketid=$basket_id";
	$dq = "DELETE FROM $pr_baskets WHERE basketid=$basket_id";
	$wpdb->query($dq);
	// get user basket info to check whether there are any other bands assigned to it
	$user_cart = prub_check_user_cart($user_id);
	//print_r($user_cart);
	if($user_cart==FALSE or $user_cart['bands_number']==0){

			// delete basket
			prub_delete_user_cart($user_id);

	}
	prub_order_update_info($user_id);
	return TRUE;
}
function prub_clear_user_cart($user_id){
// delete basket, clear user bakset id for user bands
	global $wpdb,$pr_baskets;
	$sql = "UPDATE $pr_baskets SET user_bandid=0 WHERE userid=$user_id";
	$wpdb->query($sql);
	prub_delete_user_cart($user_id);
}
function prub_count_user_cart_cost($user_id){
	global $wpdb,$pr_carts,$pr_baskets;
	$user_cart = prub_check_user_cart($user_id);
	if ($user_cart == false) {
		return false;
	} else {
		$sql = "SELECT ROUND(SUM(price),2) FROM $pr_baskets WHERE user_cartid=".$user_cart['ubid'];
		$_price = $wpdb->get_var($sql);
		return $_price;
	}
}
function prub_create_new_order_for_cart($ref,$user_id,$total,$cart_id)
{
	global $wpdb,$pr_orders,$pr_baskets;

	//delete existing new orders for user
	prub_order_delete_existing_new($user_id);
	//create order
	$wpdb->query("INSERT INTO $pr_orders (ID,total,user_id,reference,status,date_issued) values (NULL,$total,$user_id,'$ref','new','".date('Y-m-d H:i:s')."');");
	$_lid = $wpdb->get_var("SELECT LAST_INSERT_ID()");
	//$wpdb->show_errors();
	//$wpdb->print_error();
	//$_ids = pr_array_list($props);
	//update baskets. we put for each of requested properties order_ref = ref
	$wpdb->query("UPDATE $pr_baskets SET order_ref = '$ref' WHERE user_cartid=$cart_id;");
	//prf_create_order_details_for_basket($_lid,$basketid,$ref);
}
function prub_order_delete_existing_new($user_id){
	global $wpdb,$pr_orders;
	$wpdb->query("DELETE FROM $pr_orders WHERE status='new' and user_id=$user_id");
}
function prub_order_update_info($user_id){
	$user_cart = prub_check_user_cart($user_id);
	if ($user_cart != false) {
		$price = prub_count_user_cart_cost($user_id);
		$ref_number = mktime();
		prub_create_new_order_for_cart($ref_number,$user_id,$price,$user_cart['ubid']);
	} else {
		prub_order_delete_existing_new($user_id);
	}
}
function prub_pay_for_cart_form($user_id){
	global $wpdb,$pr_carts;
	$user_cart = prub_check_user_cart($user_id);
	//		$wpdb->show_errors();
	//	$wpdb->print_error();
	$price = prub_count_user_cart_cost($user_id);
if ($price > 0) {

	pr_m_('Cost: '.pr_price($price),'','h3');
	$ref_number = mktime();// reference number for created order to pay

	switch($user_cart->band_type){
		case 1:
			$cmd = '_xclick';
			break;
		case 2:
			$cmd = '_xclick-subscriptions';
			break;
		default:
			$cmd = '_xclick';
	} // switch
	prf_paypal_button($price,$ref_number,$cmd);
	prub_create_new_order_for_cart($ref_number,$user_id,$price,$user_cart['ubid']);
	pr_m_('All bands from the basket will be activated automatically after being paid','','p');
	}
}
function prubf_show_user_cart($user_id){
	global $wpdb,$pr_baskets,$pr_carts;
	if (isset($_POST['update_baskets'])) {
		prb_baskets_user_update($user_id);
	}
    prub_cleanup_user_cart($user_id);
	$user_cart = prub_check_user_cart($user_id);
//	print_r($user_cart);
	if ($user_cart == false or $user_cart['bands_number']==0) {
		if (!is_admin()) {
			pr_m_('You do not have any bands in your basket at the moment','','h2');
		} else pr_m_('User does not have any bands in the basket','','h2');
	} else {
		prbf_show_user_bands($user_id,$user_cart['ubid'],'Remove selected properties');

/*
   		$_baskets = prb_get_user_baskets($user_id,$user_cart['ubid']);//get user bands(baskets) in a cart
?>
<form action="" method="post" name="user_cart">
<table class="widefat">
<tbody>
<?
		foreach ($_baskets as $basket){
			?>
			<tr>
				<td>

				</td>
			</tr>
			<?
		}
?>
</tbody>
</table>
</form>
<?
*/
		prub_pay_for_cart_form($user_id);
	}
}
function prub_cleanup_user_cart($userid = 0){
    global $user_ID,$wpdb,$pr_baskets,$pr_cart;
    if ($userid == 0){
        $userid = $user_ID;
    }
    $sq = "SELECT basketid FROM $pr_baskets WHERE userid=$userid";
	$baskets = $wpdb->get_results($sq,'ARRAY_A');

// check previous basket of property, if it is empty and after update, we should remove it from cart.
	foreach ($baskets as $basket){
		if (prb_get_basket_used_slots($basket['basketid'])==0 and prb_get_basket_cartid($basket['basketid'])>0) {// check if there are any properties assigned to basket
			prub_remove_basket_from_user_cart($user_id, $basket['basketid']); // deleting basket from cart
		}
	}
	prub_order_update_info($user_id);
}
?>