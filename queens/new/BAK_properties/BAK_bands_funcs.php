<?php

/*
bands functions
 */

function pr_bands_edit(){
	?>
<div class="wrap">
<style>
input[type="text"]
{
	width:400px;
}
textarea
{
	width:400px;
	height:100px;
}
</style>
<?
pr_m_('<img src="'.plugins_url('properties/images/paypal-logo.png').'" /> Bands settings','','h2');
?>
</div>
	<?


	if (isset($_POST['band_name'])){

	if ($_POST['band_name'] != '') {
		if (isset($_GET['band_id'])) {
			pr_band_update($_GET['band_id']);
		} else pr_band_add();
	} else pr_m_('Band name is neccessary','err','h3');
	}


	if (isset($_GET['band_del_id'])) {
		pr_band_delete($_GET['band_del_id']);
	}
	pr_add_bands_form();
	pr_list_bands();

}
function pr_band_update($bid){
	global $wpdb,$pr_bands_new;
	$pr_bands = $pr_bands_new;
	$_POST['band_limit'] == '' ? $_POST['band_limit'] = 0 : $_POST['band_limit'] = $_POST['band_limit'];
	$_POST['band_period'] == '' ? $_POST['band_period'] = 0 : $_POST['band_period'] = $_POST['band_period'];
	$query = 'update '.$pr_bands.'
	set bandname=%s,
	type=%d,
	price=%s,
	prop_limit=%d,
	period=%d,
	area=%d,
	property_type=%d,
	user_level=%d,
	description = %s
	where bandid=%d';
	$wpdb->query($wpdb->prepare($query,$_POST['band_name'],$_POST['band_types'],$_POST['band_price'],$_POST['band_limit'],$_POST['band_period'],$_POST['band_area'],$_POST['property_types'],$_POST['user_level'],$_POST['band_description'],$bid));
	// check baskets for validity which have this band
	// pr_check_baskets_validity_by_band_id($bid);
}
function pr_band_delete($bid){
	global $wpdb,$pr_bands_new,$pr_baskets;
	$pr_bands = $pr_bands_new;
// delete band
	$query = '
	delete from '.$pr_bands.' where bandid=%d
';
	$wpdb->query($wpdb->prepare($query,$bid));
// update baskets which have this band
	$query = 'update '.$pr_baskets.' set bandid=0 where bandid=%d';
	$wpdb->query($wpdb->prepare($query,$bid));
}
function pr_band_add(){
	global $wpdb,$pr_bands_new;
		$pr_bands = $pr_bands_new;
	if ($_POST['band_limit'] == '') {
		$_POST['band_limit'] = 'DEFAULT';
	}
	if ($_POST['band_period'] == '') {
		$_POST['band_period'] = 'DEFAULT';
	}
	if ($_POST['band_price'] == '') {
		$_POST['band_price'] = 'DEFAULT';
	}
	$query = '
	insert into '.$pr_bands.' (bandid,bandname,prop_limit,period,type,area,price,property_type,user_level)
		values (NULL,\''.$_POST['band_name'].'\','.$_POST['band_limit'].','.$_POST['band_period'].','.$_POST['band_types'].','.$_POST['band_area'].','.$_POST['band_price'].','.$_POST['property_types'].','.$_POST['user_level'].','.$_POST['band_description'].')';
	$wpdb->query($query);
//	$wpdb->show_errors();
//	$wpdb->print_error();

}
function pr_get_band_details($bid){
	global $wpdb,$pr_bands_new;
	$pr_bands = $pr_bands_new;
	$query = 'select * from '.$pr_bands.' where bandid=%d';
	$band = $wpdb->get_results($wpdb->prepare($query,$bid));
//	$wpdb->show_errors();
//	$wpdb->print_error();
	return $band[0];
}
function pr_band_types_select($btid=0,$instance=''){
	global $wpdb,$pr_band_types;
	if ($btid!=0) {
		$query = "
		select * from $pr_band_types";
	} else $query = "select * from $pr_band_types";
	$types = $wpdb->get_results($query);
	if ($instance=='READONLY') {
		echo $types[$btid];
	} else {
	?>
	<select name="band_types">
	<?
	foreach ($types as $type){
		?>
		<option value="<?echo $type->typeid?>"
		<?if ($type->typeid==$btid) {
			echo 'selected';
		}?>>
		<?echo $type->typename?>
		</option>
		<?
	}
	?>
	</select>
	<?
	}
}
function pr_band_areas_select($aid=0,$instance=''){
	global $wpdb,$pr_non_international,$pr_areas;
	foreach ($pr_non_international as $area)
	{
		$_excl_arid[] = $wpdb->get_var("SELECT ID FROM $pr_areas WHERE name = '$area'");// получаем ИД для исключаемых зон
	}
	if ($instance=='READONLY') {
		if ($aid==0) {
			echo 'International';
		} else {
			$area = pr_get_area_info($aid);



			echo $area->name;
		}
	} else {
	?>
	<select name="band_area" <?echo ($instance=='disabled' ? 'disabled' : '');?>>
	<option value="0" <?if ($aid==0) {
		echo 'selected';
	}?>>International</option>
	<?
	foreach ($pr_non_international as $k=>$area){
		?>
		<option value="<?echo $_excl_arid[$k]?>" <?if ($aid==$_excl_arid[$k]) {
			echo 'selected';
		}?>><?echo $area?></option>
		<?
	}
	?>
	</select>
	<?
	}
}
function pr_add_bands_form(){
	global $wpdb,$pr_property_types;
	if (isset($_GET['band_id'])) {
		$_editing = true;
	} else $_editing = false;
	if ($_editing==true) {
		//$_input = 'READONLY';
		$_input = '';
		$band = pr_get_band_details($_GET['band_id']);
		$_band_name = $band->bandname;
		$_band_limit = $band->prop_limit;

		$_band_period = $band->period;
		$_band_price = $band->price;
		$_baid = $band->area;
		$_btid = $band->type;
		$_bptid = $band->property_type;
		$_user_level = $band->user_level;
		$_band_description = $band->description;
	} else {
		$_input = '';
		$_band_name = '';
		$_band_limit = '';
		$_band_period = '';
		$_band_price = '';
		$_btid=0;
		$_baid=0;
		$_bptid=0;
		$_user_level = 0;
		$_band_description = '';
	}
	?>
	<form name="band_form" method="POST" action="">
		<p>Band name: <input type="text" name="band_name" value="<?echo $_band_name?>"></p>
		<p>Band limit: <input type="text" name="band_limit" value="<?echo $_band_limit?>" <?echo $_input;?>> properties</p>
		<p>Band period: <input type="text" name="band_period" value="<?echo $_band_period?>" <?echo $_input;?>> days</p>
		<p>Band price: <input type="text" name="band_price" value="<?echo $_band_price?>"> pounds</p>

		<p>Band type: <?pr_band_types_select($_btid);?></p>
		<p>Band area: <?pr_band_areas_select($_baid,$_input);?></p>
		<p>For properties: <?pr_property_types_select($_bptid,$_input);?></p>
		<p>For users: <?pr_select_user_levels($_user_level);?></p>
		<p>Description:<br>
			<textarea name="band_description"><?echo $_band_description?></textarea>
		</p><input type="submit" value="submit"></p>
	</form>
	<?
}

function pr_list_bands(){
	global $wpdb, $pr_band_types, $pr_bands_new, $pr_property_types, $pr_areas, $pr_avail_bands,$pr_user_properties_slug,$pr_unlimited_amount,$pr_unlimited_period,$user_ID;
	$user_info = get_userdata($user_ID);
	$pr_bands = $pr_bands_new;
	$query = "
	select
		bn.bandid,
		bn.bandname,
		bt.typename as type,
		IF(bn.prop_limit=$pr_unlimited_amount,'Unlimited',bn.prop_limit) as prop_limit,
		IF(bn.period=$pr_unlimited_period,'Unlimited',bn.period) as period,
		IF(bn.area=0,'International',a.name) as area,
		bn.price,
		bn.description,
		pt.type_name as property_type
		from $pr_bands bn inner join $pr_band_types bt
			on bn.type=bt.typeid inner join $pr_property_types pt
			on bn.property_type=pt.typeid left join $pr_areas a
			on bn.area = a.id
			where bn.user_level<".$user_info->user_level."
		order by bn.area ASC, bn.property_type ASC, bn.bandname ASC
	";
	$bands = $wpdb->get_results($query);

//	echo '<h3 class=red>Under construction</h3>';
	?>
<script>
$(document).ready(function() {
$(".band_list tbody").tabs(".band_list div.hidden_description", {tabs:"tr a.list_number",effect:"slide"});
});
</script>
<div class="band_list">
<table class="widefat">
<thead>
<tr>
	<th class="manage-column column-title">#</th>
	<th class="manage-column column-title">Band</th>
	<th class="manage-column column-title">Type</th>
	<th class="manage-column column-title">Limit</th>
	<th class="manage-column column-title">Days</th>
	<th class="manage-column column-title">Area</th>
	<th class="manage-column column-title">Price</th>
	<th class="manage-column column-title">Property type</th>
	<th class="manage-column column-title">Action</th>
</tr>
</thead>
<tbody>
<?
foreach ($bands as $band){
	?>
<tr>
		<td>
		<a class='list_number' name="<?echo $band->bandid?>"><?echo $band->bandid?></a>
		</td>
		<td>
		<div class="band_name"><?echo $band->bandname?></div>
		<div class="hidden_description">Description: <?echo $band->description?></div>
		</td>
		<td>
		<?echo $band->type?></td>
		<td>
		<?echo $band->prop_limit?></td>
		<td>
		<?echo $band->period?></td>
		<td>
		<?echo $band->area?></td>
		<td>
		<?echo pr_price($band->price)?></td>
		<td>
		<?echo $band->property_type?></td>
		<td>
<?
if (is_admin()) {
	?>
		<a href="javascript:sureness('admin.php?page=bands&amp;band_del_id=<?echo $band->bandid?>')">Delete</a>
		<a href="admin.php?page=bands&amp;band_id=<?echo $band->bandid?>">Edit</a>
	<?
} elseif (is_user_logged_in() and is_page($pr_avail_bands)) {
	?>
		<a href='<? echo get_permalink(get_page_by_path($pr_user_properties_slug))?>?pr_action=checkout&buy_band_id=<?echo $band->bandid;?>'>Buy</a>
	<?
}
?>

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
function prb_baskets_user_update($user_id){
	global $wpdb,$pr_baskets;
	$pr_bands = $pr_bands_new;
	if (is_object($user_id)) { // variable which we get from admin page
		$user_id = $user_id->data->ID;
	}
if (is_admin()) {
	$_activate=implode(', ',$_POST['activate_basket']);
	// deactivate all user's baskets
	$sql = 'update '.$pr_baskets.' set active=0 where userid='.$user_id;
	$wpdb->query($sql);
	// activate those, which are chosen
	$sql = 'update '.$pr_baskets.' set active=1 where userid='.$user_id.' and basketid IN ('.$_activate.')';
	$wpdb->query($sql);
	}
	// delete chosen baskets
	$_delete = implode(', ',$_POST['delete_basket']);
	$sql = 'delete from '.$pr_baskets.' where basketid IN ('.$_delete.') and userid='.$user_id;
	$wpdb->query($sql);
	/// check user cart and delete it if needed
	$user_cart = prub_check_user_cart($user_id);
	if($user_cart==false or $user_cart['bands_number']==0){

			// delete basket
			prub_delete_user_cart($user_id);

	}
}
function prb_get_properties_for_basket($basket_id){
	// gets properties by basket id
	global $wpdb,$pr_properties,$pr_areas,$pr_baskets;
	$sq = "SELECT
				pr.ID,
				IF(pr.property_type=2,pr.sale_price,pr.let_weekrent) as price
			FROM $pr_properties pr inner join $pr_areas a
			ON pr.area=a.ID inner join $pr_baskets b
			ON pr.basketid=b.basketid
			WHERE b.basketid=$basket_id";
	$properties = $wpdb->get_results($sq);
	//$wpdb->show_errors();
	//$wpdb->print_error();
	if (sizeof($properties)>0) {
		return $properties;
	} else return false;
}
function prb_remove_property_from_basket($user_id,$property_ids){
	// assigns 0 to basketid in properties table
	// if the number of properties in basket = 0, we delete the basket from the cart
	global $wpdb,$pr_properties;
	$property_ids = implode(', ', $property_ids);
	$sq = "SELECT DISTINCT basketid FROM $pr_properties WHERE ID IN ($property_ids)";
	$baskets = $wpdb->get_results($sq,'ARRAY_A');
	$uq = "UPDATE $pr_properties SET basketid=0 WHERE ID IN ($property_ids)";
	$wpdb->query($uq);
	foreach ($baskets as $basket){
		if (prb_get_basket_used_slots($basket['basketid'])==0) {// check if there are any properties assigned to basket
			prub_remove_basket_from_user_cart($user_id, $basket['basketid']); // deleting basket from cart
		}
	}

}
function prb_get_user_baskets($user_id,$cart_id = false){
	// gets the list of user's baskets
	global $wpdb,$pr_baskets,$pr_property_types,$pr_infinity_date,$pr_areas;
	$sq = 'select
			b.basketid,
			b.bandname,
			b.startdate,
			b.prop_limit,
			IF(b.area=0,\'International\',a.name) as area,
			IF(b.enddate=\''.$pr_infinity_date.'\',\'Unlimited\',b.enddate) as enddate,
			b.active,
			pt.type_name
			 from '.$pr_baskets.' b inner join '.$pr_property_types.' pt
			 	on b.property_type=pt.typeid left join '.$pr_areas.' a
				on b.area = a.id
				where b.userid='.$user_id.'';
		if ($cart_id!=false) {
			$sq = $sq." and b.user_cartid=$cart_id";
		}
	$results = $wpdb->get_results($sq);
	if (sizeof($results)>0) {
		return $results;
	} else return false;
}
function prb_show_user_properties_in_basket($user_id,$basket_id,$form = TRUE){

	// shows user's properties in bakset
	//$form=true - shows checkboxes with property_ids.
	global $wpdb,$pr_baskets,$pr_areas,$pr_properties,$pr_user_properties_slug,$pr_slug;
/*handles delete action
   // make this handling in parent function
	if ($form==true) {
		if (isset($_POST['remove_pr_ids'])) {
			prb_remove_property_from_basket($user_id,$_POST['remove_pr_ids']);
		}
	}
*/
	$user_cart = prub_check_user_cart($user_id);
	if ($user_cart!=false) {//user has cart
		//$properties

		$properties = prb_get_properties_for_basket($basket_id);
		//print_r($properties);

		?>
<ul class="clear">
		<?
		foreach ($properties as $prop){
			?>
			<li>
				<div>
					<?
					echo pr_price($prop->price);
					?>
					<a href="<?echo get_permalink(get_page_by_path($pr_user_properties_slug))?>?prf_edit_id=<?echo $prop->ID?>">
					<?
						echo pr_get_prop_address($prop->ID);
					?>
					</a>
				<?
				if ($form == TRUE) {
				?>
				<input type="checkbox" value="<?echo $prop->ID?>" name="remove_pr_ids[]">
				<?
				}
				?>
				</div>
			</li>
			<?
		}
		?>
</ul>
		<?
	}
}
function prb_baskets_user_show($user_id,$user_cart_id = 0)
{
	global $wpdb,$pr_baskets,$pr_bands_new,$pr_infinity_date,$pr_properties,$pr_orders,$pr_property_types, $pr_areas,$pr_user_basket;
	$pr_bands = $pr_bands_new;
	if (is_object($user_id)) { // variable which we get from admin page
		$user_id = $user_id->data->ID;
	}
	$_today = date('Y-m-d');
	$_location = 'front';
	if (is_admin()) {
		$_location = 'admin';
		$sql = 'select
			b.basketid,
			b.bandname,
			b.startdate,
			b.prop_limit,
			IF(b.area=0,\'International\',a.name) as area,
			IF(b.enddate=\''.$pr_infinity_date.'\',\'Unlimited\',b.enddate) as enddate,
			b.active,
			pt.type_name
			 from '.$pr_baskets.' b inner join '.$pr_orders.' o
			 	on b.order_ref=o.reference inner join '.$pr_property_types.' pt
			 	on b.property_type=pt.typeid left join '.$pr_areas.' a
				on b.area = a.id
				where o.status IN (\'PENDING\',\'COMPLETED\',\'NEW\')
					and b.userid='.$user_id.'
					and now() between b.startdate and b.enddate';
	} elseif(is_page($pr_user_basket)) {
		// handling removing of properties from baskets
		if (isset($_POST['remove_pr_ids'])) {
			prb_remove_property_from_basket($user_id,$_POST['remove_pr_ids']);
		}
		$_location = 'cart';
		$sql = 'select
			b.basketid,
			b.bandname,
			b.startdate,
			b.prop_limit,
			b.price,
			IF(b.area=0,\'International\',a.name) as area,
			IF(b.enddate=\''.$pr_infinity_date.'\',\'Unlimited\',b.enddate) as enddate,
			b.active,
			pt.type_name
			 from '.$pr_baskets.' b inner join '.$pr_property_types.' pt
			 	on b.property_type=pt.typeid left join '.$pr_areas.' a
				on b.area = a.id
				where b.userid='.$user_id.'';
	} else {
		$sql = 'select
			b.basketid,
			b.bandname,
			b.startdate,
			b.prop_limit,
			IF(b.area=0,\'International\',a.name) as area,
			IF(b.enddate=\''.$pr_infinity_date.'\',\'Unlimited\',b.enddate) as enddate,
			b.active,
			pt.type_name
			 from '.$pr_baskets.' b inner join '.$pr_orders.' o
			 	on b.order_ref=o.reference inner join '.$pr_property_types.' pt
			 	on b.property_type=pt.typeid left join '.$pr_areas.' a
				on b.area = a.id
				where o.status IN (\'PENDING\',\'COMPLETED\',\'NEW\')
					and b.userid='.$user_id.'
					and now() between b.startdate and b.enddate';
	}
	$sql = $sql.' and user_cartid='.$user_cart_id;
	$baskets = $wpdb->get_results($sql);
//	$wpdb->show_errors();
//	$wpdb->print_error();
	pr_m_('User\'s bands','','h2');
	if (sizeof($baskets)>0) {
?>
<table class="widefat">
<thead>
<tr>
	<th class="manage-column column-title">#</th>
<?
if (is_page($pr_user_basket)) {
	?>
	<th class="manage-column column-title">Price</th>
	<?
}
?>
	<th class="manage-column column-title">Band Name</th>
	<th class="manage-column column-title">Used slots</th>
<? if (!is_page($pr_user_basket)) {
?>
	<th class="manage-column column-title">Start date</th>
	<th class="manage-column column-title">End date</th>
<?
}
?>
	<th class="manage-column column-title">Type</th>
	<th class="manage-column column-title">Area</th>
<? if (!is_page($pr_user_basket)) {
?>
	<th class="manage-column column-title">Delete</th>
	<th class="manage-column column-title">Active</th>
<?
}
?>
</tr>
</thead>
<tbody>
<?
foreach ($baskets as $basket){
$used_slots = $wpdb->get_var('select COUNT(ID) from '.$pr_properties.' where basketid='.$basket->basketid);
//$wpdb->show_errors();
//$wpdb->print_error();
?>
<tr>
		<td>
		<a name="<?echo $basket->basketid?>"><?echo $basket->basketid?></a>
		</td>
<?
if (is_page($pr_user_basket)) {
?>
		<td>
		<? echo pr_price($basket->price);?>
		</td>
	<?
}
?>
		<td>
		<?echo $basket->bandname?>
		</td>
		<td>
		<?echo $used_slots.'/'.$basket->prop_limit?>
		</td>
<?
if (!is_page($pr_user_basket)) {
?>
		<td>
		<?echo $basket->startdate?>
		</td>
		<td>
		<?echo $basket->enddate?>
		</td>
<?
}
?>
		<td>
		<?echo $basket->type_name?>
		</td>
		<td>
		<?echo $basket->area?>
		</td>
<?
if (!is_page($pr_user_basket)) {
?>
		<td>
		<input type="checkbox" name="delete_basket[]" value="<?echo $basket->basketid?>">
		</td>
		<td>
		<input type="checkbox" name="activate_basket[]" value="<?echo $basket->basketid?>" <?if ($basket->active==1) {
			echo 'checked';
		}?>
		<?
		if (!is_admin()) {
			echo 'DISABLED';
		}?>>
		</td>
<?
}
?>
	</tr>
	<?
	if (is_page($pr_user_basket)) {
	?>
	<tr>
		<td colspan="6">
		<? prb_show_user_properties_in_basket($user_id, $basket->basketid);?>
		</td>
	</tr>
	<?
	}
}
?>
	</tbody>
</table>
	<?
	return true;
} else {
	pr_m_('User has no bands','','h3');
	return false;
}
}
function prbf_show_available_bands(){
	pr_list_bands();
}
function prbf_show_user_bands($user_id,$user_cart_id = 0,$submit = 'submit'){
	global $pr_user_basket,$prf_action_add_property,$pr_user_properties_slug;
/*
	if (isset($_POST['update_baskets'])) {
		prb_baskets_user_update($user_id);
	}
*/
	?>
	<form action="" method="post">
	<?
	$_baskets = prb_baskets_user_show($user_id,$user_cart_id);
	if ($_baskets==true) {
	?>
		<input type="submit" name="update_baskets" value="<? echo $submit?>">
	<?
		if (is_page($pr_user_basket)) {
		?>
		<input type="button" onclick="window.location.href='<? echo get_permalink(get_page_by_path($pr_user_properties_slug)).'?pr_action='.$prf_action_add_property?>'" value="Add new property">
		<?
		}
	}
	?>
	</form>
	<?

}
//function prbf_show_bands_to_buy_by_type($type){
//	global $wpdb,$pr_bands_new;
//}
function prf_add_prop_form(){
	global $pr_user_properties_slug;
	if (isset($_POST['band_area']) and isset($_POST['property_types'])) {
/*
		switch($_POST['property_types'])
		{
			case 2:
				prf_sales_form();
				break;
			case 1:
				prf_letting_form();
				break;
			}
*/
		pr_property_types_select($_POST['property_types'],'disabled');
		pr_band_areas_select($_POST['band_area'],'disabled');
	} else {
$_method = 'POST';
switch($_POST['property_types'])
{
	case 2:
		$_action = 'prf_add_sale';
		break;
	case 1:
		$_action = 'prf_add_let';
		break;
	default:
		$_action = 'prf_add_property';
		$_method = 'GET';
}
	?>
	<form action="<?echo get_permalink(get_page_by_path($pr_user_properties_slug));?>?pr_action=<?echo $_action?>" name="add_prop" method="POST">

	<h2>Add a Property</h2>
    <p>Please select the type of propery you would like to add onto the Queens Park Real Estate Database.</p> 
	<?
  
	if (!isset($_POST['property_types'])) {	
		echo '<div class="addPropStage stage1"><label for="property_types">Property Type:</label>';
		pr_property_types_select();	
		echo '</div>';
	} else {
		echo '<div class="addPropStage stage1"><label><span>Property Type:</span>';
		pr_property_types_select($_POST['property_types'],'disabled');
		echo '</label></div>';
		echo  '<div class="addPropStage stage2"><label><span>Property Location:</span>';	
		pr_band_areas_select();
		echo '</label></div>';
		?>
		<input type="hidden" name="property_types" value="<?echo $_POST['property_types']?>">
		<?
	}
	?>
	<div><input type="submit" class="submit" name="submit" value="Continue"></div>
	</form>
	<?
	}
}
function prb_remove_prop_from_band($prop_id){
	global $wpdb,$pr_properties;
	// sets basketid of property to 0
	$uq = "UPDATE $pr_properties SET basketid=0 WHERE ID=$prop_id";
	$wpdb->query($uq);
//	$wpdb->show_errors();
//	$wpdb->print_error();
}
function prbf_show_available_bands_for_property($pr_type_id,$area_id){
global $wpdb,$pr_bands_new,$pr_band_types,$pr_property_types,$pr_areas,$user_ID,$pr_infinity_date,$pr_unlimited_amount,$pr_unlimited_period;
	$user_info = get_userdata($user_ID);
	$pr_bands = $pr_bands_new;
	$query = "
	select
		bn.bandid,
		bn.bandname,
		bt.typename as type,
		IF(bn.prop_limit=$pr_unlimited_amount,'Unlimited',bn.prop_limit) as prop_limit,
		IF(bn.period=$pr_unlimited_period,IF(bn.type=2,'Recurrent','Unlimited'),bn.period) as period,
		IF(bn.area=0,'International',a.name) as area,
		bn.price,
		bn.description,
		pt.type_name as property_type
		from $pr_bands bn inner join $pr_band_types bt
			on bn.type=bt.typeid inner join $pr_property_types pt
			on bn.property_type=pt.typeid left join $pr_areas a
			on bn.area = a.id
			where bn.property_type=$pr_type_id
				and bn.area = $area_id
				and bn.user_level<=".$user_info->user_level."
	";
	$bands = $wpdb->get_results($query);
//	$wpdb->show_errors();
//	$wpdb->print_error();
	if (sizeof($bands)>0) {
	?>
<script>
$(document).ready(function() {
$(".prop_band_list tbody").tabs(".prop_band_list div.hidden_description", {effect:"slide", tabs:".prop_band_name"});
$('.prop_band_list input').change(function(){$('.baskets_to_assign input').removeAttr("checked");});
});
</script>
<div class="prop_band_list">
	<table class="widefat">
	<thead>
		<tr>
			<th class="manage-column column-title"></th>
			<th class="manage-column column-title">Band</th>
			<th class="manage-column column-title">Num of Properties</th>
			<th class="manage-column column-title">Time</th>
			<th class="manage-column column-title">Price</th>
		</tr>
	</thead>
	<tbody>
	<?
	foreach($bands as $k=>$band){
		?>
		<tr>
			<td>
				<input type="radio" value="<?echo $band->bandid?>" name="band_to_buy">
			</td>
			<td><div class="prop_band_name"><?echo $band->bandname?></div>
			<div class="hidden_description">Description: <?echo $band->type.'<br>'.$band->description?></div>
			</td>
			<td><?echo $band->prop_limit?></td>
			<td><?echo $band->period?></td>
			<td> <?echo pr_price($band->price) ?></td>
		</tr>
		<?
	}
	?>
	</tbody>
	</table>
</div>
	<?
	} else pr_m_('No available bands','','span');
}
function prbf_show_user_bands_for_property($pr_type_id,$area_id,$user_id,$_chosen_bandid = NULL){
global $wpdb,$pr_bands_new,$pr_band_types,$pr_property_types,$pr_areas,$pr_baskets,$pr_properties,$pr_unlimited_amount,$pr_infinity_date;
$pr_bands = $pr_bands_new;
	$_today = date('Y-m-d');
if ($area_id==-1) {
	$_band_area_check = 'bn.area IS NOT NULL';
} else $_band_area_check = "bn.area = $area_id";
$query = "
	select
		bn.basketid,
		bn.bandname,
		bt.typename as type,
		bn.prop_limit,
		bn.startdate,
		bn.enddate,
		IF(bn.prop_limit=$pr_unlimited_amount,'Unlimited',bn.prop_limit) as prop_limit,
		IF(bn.prop_limit > (select count(ID) from $pr_properties where basketid=bn.basketid) OR bn.prop_limit = $pr_unlimited_amount,0,1) as band_is_full,
		IF(bn.area=0,'International',a.name) as area,
		bn.price,
		pt.type_name as property_type
		from $pr_baskets bn inner join $pr_band_types bt
			on bn.band_type=bt.typeid inner join $pr_property_types pt
			on bn.property_type=pt.typeid left join $pr_areas a
			on bn.area = a.id
			where pt.typeid=$pr_type_id
				and $_band_area_check
				and bn.userid = $user_id
				#and bn.active = 1
				and now() between bn.startdate and bn.enddate
				and (bn.prop_limit > (select count(ID) from $pr_properties where basketid=bn.basketid) OR bn.prop_limit = $pr_unlimited_amount)
	";
$baskets = $wpdb->get_results($query);
//$wpdb->show_errors();
//$wpdb->print_error();
if (sizeof($baskets)>0) {
?>
<script>
$(document).ready(function() {
$('.baskets_to_assign input').click(function(){$('.prop_band_list input').removeAttr("checked");});
});
</script>
<div class="baskets_to_assign">
	<table class="widefat">
	<thead>
		<tr>
			<th class="manage-column column-title"></th>
			<th class="manage-column column-title">Band</th>
			<th class="manage-column column-title">Used slots</th>
			<th class="manage-column column-title">Time</th>
		</tr>
	</thead>
	<tbody>
	<?
	foreach($baskets as $k=>$basket){
	$used_slots = $wpdb->get_var('select COUNT(ID) from '.$pr_properties.' where basketid='.$basket->basketid);

	?>
		<tr>
			<td>
				<input type="radio" value="<?echo $basket->basketid?>" name="basket_to_assign" <?echo $_chosen_bandid==$basket->basketid ? 'checked' : '';?> <?echo $basket->band_is_full==1 ? 'disabled' : ''?>>
			</td>
			<td><?echo $basket->bandname?></td>
			<td><?echo $used_slots?>/<?echo $basket->prop_limit?></td>
			<td><?
				if ($basket->enddate == $pr_infinity_date) {
					echo 'Unlimited';
				} else echo $basket->startdate.' - '.$basket->enddate
				?></td>
		</tr>
		<?
}
?>
	</tbody>
	</table>
</div>
	<?
	} else pr_m_('No bought bands','','span');
}
function prb_get_basket_cartid($basket_id){
	global $wpdb,$pr_baskets;
	$sq = "SELECT user_cartid FROM $pr_baskets WHERE basketid=$basket_id";
	$cartid = $wpdb->get_var($sq);
	//echo $cartid;
	return $cartid;
}
function prb_assign_basket_to_property($basket_id,$property_id,$user_id=false){
	global $wpdb,$pr_properties,$pr_baskets,$user_ID;
	if ($user_id==false) {
		$user_id = $user_ID;
	}
	// select basket id for current property
	$property_ids = $property_id;
	$sq = "SELECT DISTINCT basketid FROM $pr_properties WHERE ID IN ($property_ids)";
	$baskets = $wpdb->get_results($sq,'ARRAY_A');
	//print_r($baskets);
	$sql = "update $pr_properties pr
				set pr.basketid = $basket_id
				where pr.ID=$property_id";
	$wpdb->query($sql);

// check previous basket of property, if it is empty and after update, we should remove it from cart.
	foreach ($baskets as $basket){
		if (prb_get_basket_used_slots($basket['basketid'])==0 and prb_get_basket_cartid($basket['basketid'])>0) {// check if there are any properties assigned to basket
			prub_remove_basket_from_user_cart($user_id, $basket['basketid']); // deleting basket from cart
		}
	}
	prub_order_update_info($user_id);
}
function prb_create_new_basket($band_id,$user_id){
	global $wpdb, $pr_bands_new, $pr_baskets,$pr_unlimited_period,$pr_infinity_date;
	$pr_bands = $pr_bands_new;
	// band details
	$band = pr_get_band_details($band_id);
	if ($band->period==$pr_unlimited_period) {
		$_enddate = "'".$pr_infinity_date."'";
	} else $_enddate = "now()+interval ".$band->period." day";
	$sql = "insert into $pr_baskets (
						basketid,
						userid,
						startdate,
						enddate,
						bandid,
						active,
						prop_limit,
						price,
						band_type,
						area,
						property_type,
						bandname,
						period
						) values (
						NULL,
						$user_id,
						now(),
						".$_enddate.",
						$band_id,
						0,
						".$band->prop_limit.",
						".$band->price.",
						".$band->type.",
						".$band->area.",
						".$band->property_type.",
						'".$band->bandname."',
						".$band->period."
						);";
	$wpdb->query($sql);
//	$wpdb->show_errors();
//	$wpdb->print_error();
	$_lid = mysql_insert_id();
	return $_lid;
}
function prb_activate_basket_by_id($basket_id){
	global $wpdb,$pr_baskets;
	$sql = "update $pr_baskets set active=1 where basketid=$basket_id";

	$wodb->query($sql);
//	$wpdb->show_errors();
//	$wpdb->print_error();
}
function prb_update_status_basket_by_refnum($refnum,$status=0){
	global $wpdb,$pr_baskets,$pr_properties;
	// update baskets
	$sql = "update $pr_baskets set active=$status where order_ref=$refnum";
	$wpdb->query($sql);

	// update properties
	if ($status == 0) {
		$_approved = 0;
	} else $_approved = 1;
	$uq = "UPDATE $pr_properties SET extra_active=$status, approved=$_approved
			WHERE basketid IN (SELECT basketid FROM $pr_baskets WHERE order_ref=$refnum)";
	$wpdb->query($sql);
	switch($status){
		case 1:
			$_status = 'Completed';
			break;
		default:
			$_status = 'CANCELLED';
	} // switch
	prb_update_status_order_by_refnum($refnum,$_status);
//	$wpdb->show_errors();
//	$wpdb->print_error();
}
function prb_update_status_order_by_refnum($refnum,$status){
	global $wpdb,$pr_orders;
	$sql = "update $pr_orders set status=%s where reference=$refnum";

	$wpdb->query($wpdb->prepare($sql,$status));
	//	$wpdb->show_errors();
	//	$wpdb->print_error();
}
function prb_band_bought(){
	/*
		create order

	*/
	if (prf_make_payment() == true) {
		return true;
	} else return false;
}
function prb_buy_a_band_form($band_id){
	global $wpdb,$pr_bands_new,$user_ID;
	$pr_bands = $pr_bands_new;
	$sql = "select * from $pr_bands where bandid=$band_id";
	$band_info = $wpdb->get_results($sql);
	$band_info = $band_info[0];
	$price = $band_info->price;
//		$wpdb->show_errors();
//	$wpdb->print_error();
	$ref_number = mktime();// reference number for created order to pay
	pr_m_('Band cost: '.pr_price($price),'','p');
	switch($band_info->type){
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
	$_new_basket = prb_create_new_basket($band_id,$user_ID);

//	$_GLOBALS['pr_id_assign'] was declared in pr_add_property_hook and in pr_update_property_hook
	prb_assign_basket_to_property($_new_basket, $_GET['pr_id_assign']);

	prf_create_new_order_for_basket($ref_number,$user_ID,$price,$_new_basket);
	pr_m_('Your band will be activated after it has been paid automatically','','p');
}
function prb_buy_a_band_question($band_id,$user_id = 0){
	global $user_ID;
	if ($user_id == 0) {
		$user_id = $user_ID;
	}
//	echo $user_id;
	if (prb_band_bought()==true) {
		return true;//
	} else {
		//prb_buy_a_band_form($band_id);
		$_new_basket = prb_create_new_basket($band_id, $user_id);
//		echo $_new_basket;
		if (prub_add_band_to_user_cart($user_id, $_new_basket) == false) {
			pr_m_('The type of basket mismatches the type of band you want to buy');
		} else {
			pr_m_('The band was added to your basket. You can pay for it from basket menu');
			prb_assign_basket_to_property($_new_basket, $_GET['pr_id_assign']);
		}
	}
}
function prb_get_basket_for_property($prid){
	global $wpdb,$pr_baskets,$pr_properties,$pr_orders;
$_today = date('Y-m-d');
	$sql = "select bs.*
				from $pr_properties pr inner join $pr_baskets bs on pr.basketid=bs.basketid
					#inner join $pr_orders o	on bs.order_ref=o.reference
				where pr.ID=$prid
						#and o.status NOT IN ('new')
						and now() between bs.startdate and bs.enddate";
	$basket = $wpdb->get_results($sql);
//	$wpdb->show_errors();
//	$wpdb->print_error();
	if (sizeof($basket)>0) {
		return $basket[0];
	} else return false;
}

function prb_get_basket_used_slots($bid){
	global $wpdb,$pr_properties,$pr_baskets;
	$sql = 'select COUNT(pr.ID) from '.$pr_properties.' pr where pr.basketid = '.$bid;
	return $wpdb->get_var($sql);
}
?>