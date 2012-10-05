<?php
/**
 *
 * @module properties
 * @version 1
 * @copyright 2011
 */

function widget_quicksearch($args)
{global $pr_slug,$pr_user_downloads_slug,$pr_user_properties_slug,$pr_tennant_slug,$pr_avail_bands,$pr_user_bands, $pr_user_basket;
          extract($args);

?>

<div id="quicksearch">
<?if (function_exists('wpmem_inc_memberlinks')) // this is function in WP-memebers module
{
if ((is_page('my-account') or is_page($pr_user_properties_slug) or is_page($pr_user_downloads_slug) or is_page($pr_tennant_slug) or is_page($pr_avail_bands) or is_page($pr_user_bands) or is_page($pr_user_basket)) and is_user_logged_in()){
	$_show_acc_menu = true;
	} else {$_show_acc_menu = false;}
}	else {
	$_show_acc_menu = false;
	}

	if ($_show_acc_menu == true)
	{
	echo wpmem_inc_memberlinks();
	} else {
?>
	<script>
$(document).ready(function() {
price_range_change();
$('#sale, #rent').change(function() {price_range_change();});
function price_range_change() {
switch($('#quicksearch ul li input:checked').attr('id'))
{
//$('#sale').focus(function(){

	case "sale":
	$('#lettings_price_range').hide();
	$('#sales_price_range').show();
	$('#lettings_price_range select').attr('name',function(){return $(this).attr('name') + '_hidden';});
	$('#sales_price_range select').attr('name',function(){return $(this).attr('name').replace("_hidden","");});
	//});

	break;
//$('#rent').focus(function(){
	case "rent":
	$('#lettings_price_range').show();
	$('#sales_price_range').hide();
	$('#sales_price_range select').attr('name',function(){return $(this).attr('name') + '_hidden';});
	$('#lettings_price_range select').attr('name',function(){return $(this).attr('name').replace("_hidden","");});
	//});
	break;
}
}
});
	</script>
	<form action="<?bloginfo('url');echo "/$pr_slug";?>" method="get">
		<h2>Property Search</h2>
		<ul>
		<li class="item1">
		<label for="sale">For sale</label>
		<input name="pr_type" id="sale" value="2" type="radio" <?if(isset($_GET['pr_type'])) {if(1!=$_GET['pr_type']) echo 'checked="checked"';} else echo 'checked="checked"';?>>
		</li>
		<li class="item2">
		<label for="rent">For rent</label>
		<input name="pr_type" id="rent" value="1" <?if(isset($_GET['pr_type']) and 1==$_GET['pr_type']) echo 'checked="checked"';?> type="radio">
		</li>
		<li class="item3">
		<label for="minimumrooms">Minimum Bedrooms</label>
<?
if (isset($_GET['pr_bedroomnum'])) $_bdrm_num = $_GET['pr_bedroomnum']; else $_bdrm_num = NULL;
pr_edit_subform("num_of_bedrooms",$_bdrm_num,NULL,"pr_bedroomnum",10);?>
<?
$_pounds_arr = array(100,200,300,400,500,600,700,800,900,1000,2000,3000,4000,5000);
$_pounds_arr_sales = array(50000,100000,200000,300000,400000,500000,600000,700000,800000,900000,1000000,2000000,3000000,4000000,5000000);
?>
		</li>
		<li class="item4">
		<label for="minimumprice" class="block">Price range</label>
<div id="lettings_price_range">
		<select name="minimumprice">
		<option value="0">Min price</option>
<?
foreach($_pounds_arr as $_val)
{
?>
<option value="<?echo $_val;?>" <?if (isset($_GET['minimumprice']) and $_GET['minimumprice']==$_val) echo "selected"?>>&pound;<?echo pr_price($_val);?></option>
<?
}
?>
</select>
		<select name="maximumprice">
		<option value="">Max price</option>
<?
foreach($_pounds_arr as $_val)
{
?>
<option value="<?echo $_val;?>" <?if (isset($_GET['maximumprice']) and $_GET['maximumprice']==$_val) echo "selected"?>>&pound;<?echo pr_price($_val);?></option>
<?
}
?>

</select>
</div>
<div id="sales_price_range">
		<select name="minimumprice">
		<option value="0">Min price</option>
<?
foreach($_pounds_arr_sales as $_val)
{
?>
<option value="<?echo $_val;?>" <?if (isset($_GET['minimumprice']) and $_GET['minimumprice']==$_val) echo "selected"?>>&pound;<?echo pr_price($_val);?></option>
<?
}
?>





</select>
		<select name="maximumprice">
		<option value="">Max price</option>
<?
foreach($_pounds_arr_sales as $_val)
{
?>
<option value="<?echo $_val;?>" <?if (isset($_GET['maximumprice']) and $_GET['maximumprice']==$_val) echo "selected"?>>&pound;<?echo pr_price($_val);?></option>
<?
}
?>

</select>
</div>
		</li>
		<li class="item5">
		<label for="area" class="block">Area</label>
<?
if(isset($_GET['pr_area'])) $_area_sel = $_GET['pr_area']; else $_area_sel = NULL;
$_include_parent = 222;
$_include_areas = array();
pr_find_children($_include_parent, &$_include_areas);
//print_r($_include_areas);
$_include_areas = implode(', ',$_include_areas);
$_include_areas .= ', '.$_include_parent;
//echo $_include_areas;
pr_edit_subform("areas_front",$_area_sel,NULL,'pr_area',NULL, NULL, $_include_areas);?>
		</li>
		<li class="item6">
		<?if (isset($_GET['exclude'])) {?><input type="hidden" value="<?echo $_GET['exclude']?>" name="exclude"><?}?>
		<input name="submit" id="submit" value="SEARCH" class="submit" type="submit">
		</li>
		</ul>
	</form>
<?
}
?>
</div>
<?
	if ($_show_acc_menu == false)
	{
?>
			<a href="<?echo get_permalink(get_page_by_path('my-account'));?>"><img src="<?bloginfo('template_url')?>/images/register.png"></a>
			<a href="<?echo get_permalink(get_page_by_path('landlords'));?>"><img src="<?bloginfo('template_url')?>/images/landlords.png"></a>
			<a href="<?echo get_permalink(get_page_by_path('vendors'));?>"><img src="<?bloginfo('template_url')?>/images/Vendors.png"></a>
			<a href="<?echo get_permalink(get_page_by_path('tenants'));?>"><img src="<?bloginfo('template_url')?>/images/Tenants.png"></a>

			<div class="adverts">
				<img src="<?bloginfo('template_url')?>/images/rightmove.png" alt="">
				<img src="<?bloginfo('template_url')?>/images/findproperty.png" alt="">
				<img src="<?bloginfo('template_url')?>/images/homesproperty.png" alt="">
			</div>
<?
	}
?>
<?
}
register_sidebar_widget('Property search widget', 'widget_quicksearch');

function pr_find_children($parent_id, $ids, $exclude = false, $reccur = false)//looks up a tree to find children of current item
{
	global $wpdb,$pr_areas;
  // global $ID_arr;
	if ($reccur == false) $ids[] = $parent_id;
	//$_ids = array();
  if ($exclude == false) $results = $wpdb->get_results($wpdb->prepare("SELECT ID,parent_id FROM $pr_areas WHERE parent_id = $parent_id AND active = 1"));
  else $results = $wpdb->get_results($wpdb->prepare("SELECT ID,parent_id FROM $pr_areas WHERE parent_id = $parent_id AND active = 1 AND ID NOT IN($exclude)"));
	if(sizeof($results)>0)
	{
	foreach ($results as $result)
	{
		//$ID_arr[] = $result->ID;
		$ids[] = $result->ID;
		pr_find_children($result->ID, &$ids, true);
    //$ids = array_merge($ids,$_ids);
	}
	}

}
function pr_prop_filter($type,$bedrooms,$min_price,$max_price,$area,$page_id = 1)//main search function
{global $wpdb,$pr_areas,$pr_properties,$pr_area_types,$pr_prop_types,$pr_pic_table,$pr_per_page,$pr_slug,$pr_img_show_folder,$pr_default_img,$pr_upload_thumbs,$pr_img_show_folder_thumbs,$pr_baskets;
// global $ID_arr;
	// ������� area = ID ���������� � ����������� ��������, ������ ���� �������� ��� ID ����� ������ ����� ������ � area = ID
	//$ID_arr[] = $area;
	if ($max_price=='') $max_price = 79228162514264337593543950335;
	$ID_arr = array();
	if (isset($_GET['exclude']))
	{ $exclude = $_SESSION['exclude'];}
	else $exclude = false;
	pr_find_children($area,&$ID_arr,$exclude);
//	print_r($ID_arr);
	/*
	$results = $wpdb->get_results($wpdb->prepare("SELECT ID,parent_id FROM $pr_areas WHERE parent_id = $area"));
	foreach ($results as $result)
	{
		$ID_arr[] = $result->ID;
	}
	*/
	$ids = pr_array_list($ID_arr);
	//print_r($ID_arr);
global $_lettings_date_check,$_sales_date_check;
  $_today = date('Y-m-d');
  switch($type)
	{
		case 1:
		$count = $wpdb->get_var("
		SELECT COUNT(pr.ID)
		FROM $pr_properties pr LEFT JOIN $pr_areas a
			ON pr.area = a.ID INNER JOIN $pr_baskets b
			ON pr.basketid=b.basketid
		WHERE pr.area IN ($ids)
			AND a.active = 1
			AND pr.property_type = $type
			AND pr.let_weekrent <= $max_price
			AND pr.let_weekrent >= $min_price
			AND pr.bedroomnum >= $bedrooms
			AND pr.extra_active = 1
			AND pr.approved = 1
			AND b.active = 1
			AND '$_today' between b.startdate and b.enddate
			AND $_lettings_date_check");
		break;
		case 2:
		$count = $wpdb->get_var("
		SELECT COUNT(pr.ID)
		FROM $pr_properties pr LEFT JOIN $pr_areas a
			ON pr.area = a.ID INNER JOIN $pr_baskets b
			ON pr.basketid=b.basketid
		WHERE pr.area IN ($ids)
			AND a.active = 1
			AND pr.property_type = $type
			AND pr.sale_price <= $max_price
			AND pr.sale_price >= $min_price
			AND pr.bedroomnum >= $bedrooms
			AND pr.extra_active = 1
			AND pr.approved = 1
			AND b.active = 1
			AND '$_today' between b.startdate and b.enddate
			AND $_sales_date_check");
		break;
		case "all":/// idiotic quick fix idea ot show all properties together
		$count = $wpdb->get_var("
		SELECT COUNT(pr.ID)
		FROM $pr_properties pr LEFT JOIN $pr_areas a
			ON pr.area = a.ID INNER JOIN $pr_baskets b
			ON pr.basketid=b.basketid
		WHERE pr.area IN ($ids)
			AND a.active = 1
			AND pr.property_type = 1
			AND pr.let_weekrent <= $max_price
			AND pr.let_weekrent >= $min_price
			AND pr.bedroomnum >= $bedrooms
			AND pr.extra_active = 1
			AND pr.approved = 1
			AND b.active = 1
			AND '$_today' between b.startdate and b.enddate
			AND $_lettings_date_check")
			+
			$wpdb->get_var("
		SELECT COUNT(pr.ID)
		FROM $pr_properties pr LEFT JOIN $pr_areas a
			ON pr.area = a.ID INNER JOIN $pr_baskets b
			ON pr.basketid=b.basketid
		WHERE pr.area IN ($ids)
			AND a.active = 1
			AND pr.property_type = 2
			AND pr.sale_price <= $max_price
			AND pr.sale_price >= $min_price
			AND pr.bedroomnum >= $bedrooms
			AND pr.extra_active = 1
			AND pr.approved = 1
			AND b.active = 1
			AND '$_today' between b.startdate and b.enddate
			AND $_sales_date_check");
		break;
	}
//	$wpdb->show_errors();
//	$wpdb->print_error();
if ($count!=0) {

	$pages = bcdiv($count,$pr_per_page);
if(bcmod($count,$pr_per_page) > 0) $pages++;
if ($pages > 1)	 {
	$pagestring = "Pages ";
	/**/
	$bu = get_permalink(get_page_by_path($pr_slug))."?pr_type=$type&pr_bedroomnum=$bedrooms&minimumprice=$min_price&maximumprice=".$_SESSION['maximumprice']."&pr_area=$area";
	if ($exclude != false) $bu .= "&exclude=$exclude";
	for ($i = 1;$i <= $pages;$i++)
	{
		if ($page_id == $i)
		{
		$pagestring .= "<a class='selected' href=$bu&pr_page_id=".$i.">".$i."</a> ";
		} else {
		$pagestring .= "<a href=$bu&pr_page_id=".$i.">".$i."</a> ";
		}
	}
}
	$start = ($page_id-1)*$pr_per_page;//according to page we start our select from DB
	//$wpdb->show_errors();
	//$wpdb->print_error();

	//we get data from DB according
	switch($type)
	{
		case 1://LETTING
			$name = 'lettings';
			$results = $wpdb->get_results("
			SELECT
			pr.ID,
			pr.property_type,
			pr.let_weekrent as price,
			pr.let_monthrent as price_pm,
			pr.addr_door_number as door_number,
			pr.addr_street as street,
			pr.addr_postcode as postcode,
			a.name as area,
			pr.area as area_id,
			pt.Name as pr_type,
			pr.descr, pr.bedroomnum,
			pr.extra_status
			FROM $pr_properties pr LEFT JOIN $pr_areas a
			ON pr.area = a.ID LEFT JOIN $pr_prop_types pt
				ON pr.type = pt.ID INNER JOIN $pr_baskets b
				ON pr.basketid=b.basketid
			WHERE pr.area iN ($ids)
				AND '$_today' between b.startdate and b.enddate
				AND a.active = 1
				AND pr.property_type = $type
				AND pr.let_weekrent <= $max_price
				AND pr.let_weekrent >= $min_price
				AND bedroomnum >= $bedrooms
				AND pr.extra_active = 1
				AND pr.approved = 1
				AND $_lettings_date_check
			ORDER BY price ".$_SESSION['sort_by_price'].", pr.date_updated DESC, pr.date_created DESC, pr.ID DESC
			LIMIT $start,$pr_per_page;");
		break;
		case 2://SALE
			$name = 'sales';
			$results = $wpdb->get_results("
			SELECT
			pr.ID,
			pr.property_type,
			pr.type, pr.sale_price as price,
			pr.addr_door_number as door_number,
			pr.addr_street as street,
			pr.addr_postcode as postcode,
			a.name as area,
			pr.area as area_id,
			pt.Name as pr_type,
			pr.descr,
			pr.bedroomnum,
			pr.extra_status
			FROM $pr_properties pr LEFT JOIN $pr_areas a
			ON pr.area = a.ID LEFT JOIN $pr_prop_types pt
				ON pr.type = pt.ID INNER JOIN $pr_baskets b
			ON pr.basketid=b.basketid
			WHERE pr.area iN ($ids)
				AND '$_today' between b.startdate and b.enddate
				AND a.active = 1
				AND pr.property_type = $type
				AND pr.sale_price <= $max_price
				AND pr.sale_price >= $min_price
				AND pr.bedroomnum >= $bedrooms

				AND pr.extra_active = 1
				AND pr.approved = 1
				AND $_sales_date_check
			ORDER BY price ".$_SESSION['sort_by_price'].", pr.date_updated DESC, pr.date_created DESC, pr.ID DESC
			LIMIT $start,$pr_per_page;");
		break;
		case "all": /// idiotic quick fix idea again
		$name = 'sales and lettings';
		$_ids = array_merge($wpdb->get_results("
			SELECT pr.ID
			FROM $pr_properties pr LEFT JOIN $pr_areas a

			ON pr.area = a.ID LEFT JOIN $pr_prop_types pt
				ON pr.type = pt.ID INNER JOIN $pr_baskets b
				ON pr.basketid=b.basketid
			WHERE pr.area iN ($ids)
				AND '$_today' between b.startdate and b.enddate
				AND a.active = 1
				AND pr.property_type = 1
				AND pr.let_weekrent <= $max_price
				AND pr.let_weekrent >= $min_price
				AND pr.bedroomnum >= $bedrooms
				AND pr.extra_active = 1
				AND pr.approved = 1
				AND $_lettings_date_check
			ORDER BY pr.date_updated DESC, pr.date_created DESC, pr.ID DESC",'ARRAY_N'),
			$wpdb->get_results("SELECT pr.ID
			FROM $pr_properties pr LEFT JOIN $pr_areas a
			ON pr.area = a.ID LEFT JOIN $pr_prop_types pt
				ON pr.type = pt.IDINNER JOIN $pr_baskets b
				ON pr.basketid=b.basketid
			WHERE pr.area iN ($ids)
				AND '$_today' between b.startdate and b.enddate
				AND a.active = 1
				AND pr.property_type = 2
				AND pr.sale_price <= $max_price
				AND pr.sale_price >= $min_price
				AND pr.bedroomnum >= $bedrooms
				AND pr.extra_active = 1
				AND pr.approved = 1
				AND $_sales_date_check
			ORDER BY pr.date_updated DESC, pr.date_created DESC, pr.ID DESC ",'ARRAY_N'));
			$ids = array();
			foreach($_ids as $id)
			{
				$ids[] = $id[0];
			}
			$ids = pr_array_list($ids);
			// now we just select all of the properties in descendiong order of creation/update date which have ID in array
			$results = $wpdb->get_results("
			SELECT
			pr.ID,
			pr.property_type,
			IF (pr.property_type = 2,pr.sale_price,pr.let_weekrent) as price,
			pr.let_monthrent as price_pm,
			pr.addr_door_number as door_number,
			pr.addr_street as street,
			pr.addr_postcode as postcode,
			a.name as area,
			pr.area as area_id,
			pt.Name as pr_type,
			pr.descr,
			pr.bedroomnum,
			pr.extra_status
			FROM $pr_properties pr LEFT JOIN $pr_areas a
			ON pr.area = a.ID LEFT JOIN $pr_prop_types pt
				ON pr.type = pt.ID
			WHERE pr.ID iN ($ids)
			ORDER BY price ".$_SESSION['sort_by_price'].", pr.date_updated DESC, pr.date_created DESC, pr.ID DESC
			LIMIT $start,$pr_per_page;
			");
		break;
	}
	//$wpdb->show_errors();
	//$wpdb->print_error();
	//print_r($results);
}
	?>
<div id="search">
<h1>Search Results<?if ($count > 0) {?> &mdash; <?echo $count.' '.$name?> found <?}?></h1>
<?if ($count==0) {
pr_m_('No properties found matching your criteria.','notice','h3');
}

else {

if ($pages > 1 ) pr_m_($pagestring,"pagination","div");?>
	<?
// sorting form
pr_edit_subform('price_sort_form');

	foreach ($results as $prop)
	{
		$img_main_src = $wpdb->get_var("SELECT img_name FROM $pr_pic_table WHERE prid = $prop->ID AND main = 1 LIMIT 0,1");
		if ($img_main_src != NULL) {
			$img_src = $img_main_src;
		}
		else{
		$img_src = $wpdb->get_var("SELECT img_name FROM $pr_pic_table WHERE prid = $prop->ID LIMIT 0,1");
		}
if(strlen($img_src)<5) $img_src = $pr_default_img;
	//$wpdb->show_errors();
	//$wpdb->print_error();
global $selling_state;
$status = $selling_state[$prop->extra_status]['name'];
	/*
switch ($prop->extra_status)
{
	case 1:
		$status = "Let";
	break;
	case 2:
		$status = "Available";
	break;
	case 3:
		$status = "New instruction";
	break;
	case 4:
		$status = "Sold";
	break;
	case 5:
		$status = "Under order";
	break;

}
*/

	?>
<table cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr class="headRow">
		<td colspan=5><?echo pr_get_prop_address($prop->ID)?></td>
	</tr>
	<tr>
		<td rowspan="3" class="image">
			<img src="<?
			if(file_exists($pr_upload_thumbs.$img_src))
			echo $pr_img_show_folder_thumbs.$img_src;
			else echo $pr_img_show_folder.$img_src;
			?>" id="mainImage" title="<?echo $prop->street.', '.pr_area_path($prop->area_id);?>">
		</td>
		<td class="bedroom"><?
		if ($prop->bedroomnum > 1) {
			echo $prop->bedroomnum." bedrooms";
		} elseif($prop->bedroomnum == 1) {
			echo $prop->bedroomnum." bedroom";
		}
		?></td>
		<td class="type"><?echo $prop->pr_type?></td>
		<td class="status"><?echo $status?></td>
		<td class="price">
		<?
		switch($prop->property_type)
				{
					case 1:
						if ($prop->price>0) pr_m_("&#163;".pr_price($prop->price)." P/W");
						if ($prop->price_pm>0) pr_m_("&#163;".pr_price($prop->price_pm)." PCM");
						//else pr_m_("&#163;".pr_price(round(4*$prop->price,2)).".00 PCM");
					break;
					case 2:
						if ($prop->price>0) pr_m_("&#163;".pr_price($prop->price));
					break;
				}
		//echo $prop->price; if ($prop->property_type == 1) echo " PCM";
		?>
		</td>
	</tr>
	<tr>
		<td colspan="4" class="description">
		<?echo htmlspecialchars_decode(stripslashes($prop->descr))?>

		</td>
	</tr>
	<tr>
		<td colspan="4" class="viewMore"><a href="<?
if (isset($_GET['exclude'])) $_exclude = '&exclude='.$_GET['exclude'];
else $_exclude = NULL;
echo get_permalink(get_page_by_path($pr_slug)).'?pr_id='.$prop->ID.$_exclude;?>">VIEW MORE INFORMATION</a></td>
	</tr>
</tbody>
</table>
	<?
	}
?>
<?if ($pages > 1 ) pr_m_($pagestring,"pagination","div");

}

?>
</div>
<?
}
function pr_property_show($id)//property details
{
	global $wpdb,$pr_areas,$pr_properties,$pr_area_types,$pr_prop_types,$pr_pic_table,$pr_per_page,$pr_slug,$pr_img_show_folder,$pr_default_img,$pr_tmp_properties,$_lettings_date_check,$_sales_date_check,$pr_baskets;

$_today = date('Y-m-d');

  $approved_check = "pr.approved = 1"; // approved check flag
  $active_check = "pr.extra_active = 1"; // active check flag
  $_band_check = "AND '$_today' between b.startdate and b.enddate AND b.active=1"; //

  if (isset($_GET['act']) and $_GET['act'] == 'preview') {
  	// we replace standard properties table for temporary one
  	$pr_properties = $pr_tmp_properties;
  	$approved_check = "pr.approved IS NOT NULL";
  	$active_check = "pr.extra_active IS NOT NULL";
  	$_band_check = "";
  	$_lettings_date_check = "";
  	$_sales_date_check = "";
  } else {
  	$_lettings_date_check = 'AND '.$_lettings_date_check;
  	$_sales_date_check = 'AND '.$_sales_date_check;
  }
	$type = $wpdb->get_var($wpdb->prepare('SELECT property_type as type FROM '.$pr_properties.' WHERE ID = %d',$id));
	//print_r($wpdb->get_results("SELECT * FROM $pr_properties WHERE ID = $id"));

  switch($type)
	{
		case 1://LETTING
			$name = 'lettings';
			$results = $wpdb->get_results($wpdb->prepare("
	SELECT
		pr.ID,
		pr.let_weekrent as price,
		pr.let_monthrent as price_pm,
		a.name as area,
		pr.area as area_id,
		pt.Name as pr_type,
		pr.descr,
		pr.bedroomnum,
		pr.extra_status,
		pr.user_id
	FROM $pr_properties pr LEFT JOIN $pr_areas a
		ON pr.area = a.ID LEFT JOIN $pr_prop_types pt
		ON pr.type = pt.ID LEFT JOIN $pr_baskets b
		ON pr.basketid=b.basketid
	WHERE pr.ID = %d
		$_band_check
		AND $active_check
		AND $approved_check
		$_lettings_date_check;",$id));
		break;
		case 2://SALE
			$name = 'sales';
			$results = $wpdb->get_results($wpdb->prepare("
	SELECT
		pr.ID,
		pr.sale_price as price,
		a.name as area,
		pr.area as area_id,
		pt.Name as pr_type,
		pr.descr,
		pr.bedroomnum,
		pr.extra_status,
		pr.user_id
	FROM $pr_properties pr LEFT JOIN $pr_areas a
		ON pr.area = a.ID LEFT JOIN $pr_prop_types pt
		ON pr.type = pt.ID LEFT JOIN $pr_baskets b
		ON pr.basketid=b.basketid
	WHERE pr.ID =%d
		$_band_check
		AND $approved_check
		$_sales_date_check;",$id));
		break;
	}
  if (isset($_GET['act']) and $_GET['act'] == 'preview') {
//	$wpdb->show_errors();
//	$wpdb->print_error();
	}
	if (sizeof($results) > 0) // if selected property is appropriate
	{

	?>
	<div id="property">
	<script type="text/javascript">
		$(document).ready(function() {
			$("div#videos a").fancybox({
				'hideOnContentClick': false,
				'overlayShow': false,
				'frameWidth': 400,
				'frameHeight': 600,
				'callbackOnClose': function() {
					if (ytplayer) {
						ytplayer.stopVideo();
					}
				}
			});

			$("div#images a").fancybox();

			$("div#information").accordion({
				autoHeight: false
			});
		});
	</script>
	<?
	foreach($results as $prop)
	{
$author_info = get_userdata($prop->user_id);

		$_address_line = pr_get_prop_address($prop->ID);
/*
	if ($prop->door_number != '' and $prop->door_number != NULL and $prop->door_number != 0) $_address_line[] = $prop->door_number;
	if ($prop->street != '' and $prop->street != NULL) $_address_line[] = $prop->street;
	if ($prop->area_id != '' and $prop->area_id != NULL and $prop->area_id != 0) $_address_line[] = pr_area_path($prop->area_id);
	if ($prop->postcode != '' and $prop->postcode != NULL) $_address_line[] = $prop->postcode;
	$_address_line = implode(', ',$_address_line);
*/
pr_m_($_address_line,NULL,"h1");

	//pr_m_($prop->street.', '.pr_area_path($prop->area_id),NULL,"h1");
	?>
	<table cellspacing="0" cellpadding="0" border="0">
		<tbody><tr>
			<td class="left">
<? if ($prop->bedroomnum > 1) {
	echo "Number of Bedrooms $prop->bedroomnum";
} elseif ($prop->bedroomnum == 1) {
	echo "Number of Bedroom $prop->bedroomnum";
}
?>

			</td>
			<td class="right">
				<?
				switch($type)
				{
					case 1:
						if ($prop->price>0) {
							pr_m_("&#163;".pr_price($prop->price)." P/W");
						}
						if ($prop->price_pm>0) pr_m_("&#163;".pr_price($prop->price_pm)." P/M");
						//else pr_m_("&#163;".pr_price(round(4*$prop->price,2))." P/M");
					break;
					case 2:
						if ($prop->price>0) pr_m_("&#163;".pr_price($prop->price));
					break;

				}?>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="right">
				<!--<a href="#">Arrange viewing</a>
				<a target="_blank" href="http://www.upmystreet.com/local/W2.html">About this area</a>
				<a target="_blank" href="http://maps.google.co.uk/?q=W2">View map</a>
				-->
			</td>
		</tr>
		</tbody>
	</table>
	<div id="images">
	<?prf_images($id)?>
	</div>
		<div id="information">
		<h3>Description</h3>
		<div id="description">
			<?echo $prop->descr;?>
		</div>
		<h3>Video</h3>
		<div id="videos">

			<p><?prf_videos($id);?></p>

		</div>
		<h3>Attachments</h3>
		<div id="files">

			<p>
			<?prf_files($id);?>
			</p>

		</div>

		<?prf_arrange_view($id);?>
		<?prf_tell_friend_form($id);?>
<?
if ($author_info->user_level>=8) { // admin has level >= 8
	$args = array(
		'category' => 8,
		'numberposts' => 1
	);
} else {
	$args = array(
		'category' => 7,
		'numberposts' => 1
);
}
$posts = get_posts($args);
if (sizeof($posts) > 0) {
foreach ($posts as $post){
?>
		<h3><?echo $post->post_title?></h3>
		<div id="files">

			<p>
			<?echo $post->post_content?>
			</p>

		</div>
		<?
}
}

?>
	</div>

	<?
	pr_print_button_forms($id,$_address_line);
	//pr_m_("Under construction","h2");
	}
	?>
	</div>
	<?
} else pr_m_('This property can not be viewed due to its setup. If you feel that this is a mistake, contact administration please.','error','h1');

}
function pr_area_path($aid,$return = 'string',$post_code = NULL)
{
	$areas_route = NULL;
if (strlen($post_code)>0) {
	$post_code = explode(' ', $post_code);
}

if ($aid!=NULL and $aid!='' and $aid != 0) {
	$area_info = pr_get_area_info($aid);
	if ($area_info != false and $area_info->active == 1) {

	$area_parents = pr_get_area_parents($aid,'all');// get parents route for area
	//echo sizeof($area_parents);
if (sizeof($area_parents)>0)
{
	$_stop = sizeof($area_parents)-1;
	//$area_parents = array_reverse($area_parents);
	$areas = array();
	foreach($area_parents as $k=>$parent)
	{
		if (trim($parent['name'])!='United Kingdom') {

			$parent_info = pr_get_area_info($parent['id']);
			//echo $parent_info->type;
			if (strtoupper(trim($parent_info->type))=='CITY' and strlen($post_code[0])>0) {
				$areas[] = $parent['name'].' '.$post_code[0];
			} else $areas[] = $parent['name'];
		}
		/*if ($k<sizeof($area_parents)-1) {
				$areas_route .= ', ';
			}
		*/
	}
}
	switch($return){
		case 'string':
			if (sizeof($areas)>0) {
				$areas = array_reverse($areas);
				$areas_route = implode(', ',$areas);
			}

				$area_info = pr_get_area_info($aid);
			if ($areas_route!=NULL) {
				$areas_route = $area_info->name.', '.$areas_route;
			} else $areas_route = $area_info->name;
			break;
		case 'array':
			if ($areas_route!=NULL) {
				$areas_route = array();
				$areas_route = $areas;
				$area_info = pr_get_area_info($aid);

			}
			$areas_route[] = $area_info->name;
			$areas_route = array_reverse($areas_route);
			break;
		default:
			$areas_route = $areas;
	} // switch


return $areas_route;
}
}
	return NULL;
}

function prf_images($prid)//shows pictures
{
	global $wpdb,$pr_pic_table,$pr_img_show_folder,$pr_default_img,$pr_upload_thumbs,$pr_img_show_folder_thumbs;

if (isset($_GET['act']) and $_GET['act']=='preview' and isset($_GET['edited_id'])) {
$prid = $_GET['edited_id'];
}

	$results = $wpdb->get_results($wpdb->prepare("SELECT img_name FROM $pr_pic_table WHERE prid = %d",$prid));

	/*
	$wpdb->show_errors();
	$wpdb->print_error();
	*/

	foreach ($results as $img)
	{
		?>
		<a title="" href="<?echo $pr_img_show_folder.$img->img_name;?>">
			<img alt="" src="<?
			if(file_exists($pr_upload_thumbs.$img->img_name))
			echo $pr_img_show_folder_thumbs.$img->img_name;
			else echo $pr_img_show_folder.$img->img_name;
			?>">
		</a>
		<?
	}
// for tmp preview
if (isset($_GET['act']) and $_GET['act']=='preview') {
	global $pr_tmp_show_folder,$pr_pic_table_tmp,$user_ID,$pr_maxthumbw,$pr_maxthumbh;
	$tmp_pics = "SELECT * FROM $pr_pic_table_tmp WHERE user_id = $user_ID";
	$tmp_pics = $wpdb->get_results($tmp_pics);

foreach ($tmp_pics as $img)
{
?>
		<a title="" href="<?echo $pr_tmp_show_folder.$img->filename;?>">
			<img alt="" src="<?
			if(file_exists($pr_upload_thumbs.$img->filename))
				echo $pr_img_show_folder_thumbs.$img->filename;
			else echo $pr_tmp_show_folder.$img->filename;
			?>" width="<?echo $pr_maxthumbw?>" heigth="<?echo $pr_maxthumbh?>">
		</a>
		<?
}
}
}
function prf_files($prid, $show_lnk = true)//shows files
{
	global $wpdb,$pr_files_table,$pr_file_show_folder,$pr_upload_files,$pr_tmp_show_folder;

if (isset($_GET['act']) and $_GET['act']=='preview' and isset($_GET['edited_id'])) {
$prid = $_GET['edited_id'];
}

	$results = $wpdb->get_results($wpdb->prepare("SELECT file_name,title FROM $pr_files_table WHERE prid = %d",$prid));
	/*
	$wpdb->show_errors();
	$wpdb->print_error();
	*/
	if(sizeof($results) > 0) {
	?>
  <ul class="files_list">
  <?
	foreach ($results as $file)

	{
    ?>
    <li>
    <?
    if ($file->title != NUll)
      echo $file->title;
        else echo $file->file_name;
    ?> (<?echo round(filesize($pr_upload_files.$file->file_name)/1024,0)?> KB)
    <?if ($show_lnk == true) {?>
		<a title="" href="<?echo $pr_file_show_folder.$file->file_name;?>">
		download
		</a>
	<?}?>
		</li>
		<?
	}
	?>
  </ul>
  <?
	}
// for tmp preview
if (isset($_GET['act']) and $_GET['act']=='preview') {
global $pr_tmp_show_folder,$pr_files_table_tmp,$user_ID,$pr_upload_pictures_tmp;
$tmp_files = "SELECT * FROM $pr_files_table_tmp WHERE user_id = $user_ID";
$tmp_files = $wpdb->get_results($tmp_files);
?>
  <ul class="files_list">
  <?
foreach ($tmp_files as $file)
{
?>
    <li>
    <?
    if ($file->title != NUll)
    	echo $file->title;
    else echo $file->filename;
    ?> (<?echo round(filesize('/'.$pr_upload_pictures_tmp.$file->filename)/1024,0)?> KB)
    <?if ($show_lnk == true) {?>
		<a title="" href="<?echo $pr_tmp_show_folder.$file->filename;?>">
		download
		</a>
	<?}?>
		</li>
		<?
}
?>
  </ul>
  <?
}
if (sizeof($results) == 0) {
	if (isset($_GET['act']) and $_GET['act'] == 'preview' and sizeof($tmp_files) == 0) {
		$no_files = true;
	} else $no_files = true;
} else $no_files = false;
if ($no_files == true) {
	echo "There are no files.";
}
}
function prf_videos($prid)// shows link to video, needs improvements
{
	global $wpdb,$pr_video_table,$pr_tmp_video_table;

if (isset($_GET['act']) and $_GET['act']=='preview') {
	$pr_video_table = $pr_tmp_video_table;
}
	$results = $wpdb->get_results($wpdb->prepare("SELECT yt_id FROM $pr_video_table WHERE prid = %d",$prid));
	/*
	$wpdb->show_errors();
	$wpdb->print_error();
	*/
	if(sizeof($results) == 0) echo "There are no videos.";
	else {
	foreach ($results as $vid)
	{
		?>
		<object width="320" height="200">
      <param name="movie" value="http://www.youtube.com/v/<?echo $vid->yt_id?>?fs=1&amp;hl=en_US"></param>
      <param name="allowFullScreen" value="true"></param>
      <param name="allowscriptaccess" value="always"></param>
      <embed src="http://www.youtube.com/v/<?echo $vid->yt_id?>?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="320" height="200"></embed>
      </object>

		<?//pr_m_($vid->descr);
	}
	}
}
function prf_tell_friend_form($prid)
{
	global $user_ID,$pr_slug;

	pr_m_("Tell a friend",'','h3');


	pr_edit_subform("form_start");
	?>
	<div class="in_form">
	<?
	// send inside the form tag
	prf_tell_friend_send($prid);

	pr_m_('Friend\'s email','label','p');
	?><p><?pr_edit_subform(NULL,NULL,NULL,"prf_friend_email");?></p><?

	if (is_user_logged_in())
	{
	$_u_info = get_userdata($user_ID);
	$_name = $_u_info->display_name;
	$_email = $_u_info->user_email;
	} else {
	$_name = NULL;
	$_email = NULL;
	}
	pr_m_('Your email','label','p');
	?><p><?pr_edit_subform(NULL,NULL,NULL,"prf_your_email",$_email);?></p><?
	pr_m_('Your name','label','p');
	?><p><?pr_edit_subform(NULL,NULL,NULL,"prf_your_name",$_name);?></p><?
	pr_m_('Message','label','p');
	$_link = get_permalink(get_page_by_path($pr_slug)).'?pr_id='.$prid;
	?><p><?pr_edit_subform("textarea",NULL,NULL,"prf_your_message","Look at that property $_link.");?></p><?
	/// the msg better to make configurable from admin panel

	pr_edit_subform("hidden",NULL,NULL,"prf_action","prf_tell_friend");
	?><p><?pr_edit_subform("submit",NULL,NULL,NULL,"Send");	?></p><?
	?>
	</div>
	<?
	pr_edit_subform("form_end");
}
function prf_tell_friend_send($prid)
{
	if (isset($_POST['prf_action']) and $_POST['prf_action']=="prf_tell_friend")
	{
	$friend_email = stripslashes($_POST['prf_friend_email']);//needs to be checked
	$user_email = stripslashes($_POST['prf_your_email']);
	if (pr_3rd_isValidEmail($friend_email) and pr_3rd_isValidEmail($user_email))
	{
	$user_login = stripslashes($_POST['prf_your_name']);

	$user_email = stripslashes($_POST['prf_your_email']);
	$blogname = get_settings('blogname');
	$admin_email = get_settings('admin_email');

	$subj = "Your friend sent you a link via $blogname";

	// set the body of the message

	$body = stripslashes($_POST['prf_your_message']);
	$body.= "\r\n\n-----------------------------------\r\n";
	$body.= "This is an automated message \r\n";
	$body.= "from $blogname\r\n";
	$body.= "Please do not reply to this address\r\n";

	// end edits for function wpmem_inc_regemail()
	$headers = 'From: '.$blogname.' <'.$user_email.'>' . "\r\n\\";
	wp_mail($friend_email, $subj, $body, $headers);
	pr_m_('A message has been sent.','success','h3');
	} else {pr_m_('Error! You specified an uncorrect email.','error','h3');}
	}
}
function prf_arrange_view($prid)//shows form for arrange_viewing, also calls function to send a notification about arrangement
{

//global $si_contact_form;
?>
<h3>Arrange viewing</h3>

	<div id="aform">
<?

// this function will perform all the checks for $_POST array and will send the msg if needed
prf_arrange_send($prid);
pr_m_("Arrange viewing for this property",NULL,"h2");
	// we use SI contact form builder to create this form
	//if ( isset($si_contact_form) ) echo $si_contact_form->si_contact_form_short_code( array( 'form' => '3' ) );
	//else {
	// we may show our own form in case SI contact form wasn't installed and configured, but at the moment we don't have function for sending messages
?>
<form action="" method="post">
	<ul>
		<li><label for="firstname">First-name</label>
		<input name="firstname" id="firstname" value="" type="text"></li>
		<li><label for="lastname">Last-name</label>
		<input name="lastname" id="lastname" value="" type="text"></li>
		<li><label for="contactNumber">Contact number</label>
		<input name="contactNumber" id="contactNumber" value="" type="text"></li>
		<li><label for="contactEmail">Email</label>
		<input name="contactEmail" id="contactEmail" value="" type="text"></li>
		<li><label for="time">Time</label>
		<select name="time" id="time">
			<option value="ASAP">ASAP</option>
			<option value="this week">This week</option>
			<option value="next week">Next week</option>
		</select></li>
		<li><input value="Submit" type="submit" class="submit">
		<?
		pr_edit_subform('hidden',NULL,NULL,'prf_arrange_prid',$prid);
		?></li>
	</ul>
</form>
	<div class="clear"></div>
	<?
	//}
?>
	</div>

<?
}
function prf_arrange_send($id)
{ global $pr_slug,$pr_properties,$wpdb;

if (isset($_POST['firstname']) and isset($_POST['lastname']) and isset($_POST['contactNumber']))
{
	if ($_POST['firstname'] != NULL and $_POST['lastname'] !=NULL and $_POST['contactNumber'] != NULL)
	{
	//$sql = "SELECT u.user_email from $pr_properties pr INNER JOIN $wpdb->users u ON pr.user.id = u.ID WHERE pr.ID = $id";
	//$to = $wpdb->get_var($sql);
	//echo getenv("HTTP_HOST");
	$to = get_bloginfo('admin_email');
	$subject = "Property viewing arrangement";
	$from = 'From: '.get_bloginfo('name').' <noreply@'.str_replace('www.','',getenv("HTTP_HOST")).'>'. "\r\n";
	$headers = $from;
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$prlink = get_bloginfo('url').'/'.$pr_slug.'/?pr_id='.$id;
	$message = ''.$_POST['firstname'].' '.$_POST['lastname'].' wants to arrange meeting '.$_POST['time'].' for '.$prlink.' <br> Telephone number: '.$_POST['contactNumber'].' <br> Email: '.$_POST['contactEmail'];
	wp_mail( $to, $subject, $message, $headers);
	pr_m_('Your arrangement has been sent',NULL,'h2');
	} else pr_m_('You need to fill all the fields to send an arrangement request',NULL,'h3');
}
}

function prf_price_drop_down($name,$min,$max,$steps,$value = NULL)
{

	$step = ($max-$min)/$steps;
	echo "<select name=$name>";
	for ($i = $min;$i<=$max;$i = $i+$step)
	{
		if ($value == $i) echo "<option value=$i selected>&#163;$i</option>";
			else echo "<option value=$i>&#163;$i</option>";
	}
	echo "</select>";
}
function prf_rent_drop_down($name,$min,$max,$steps,$value = NULL)
{

	$step = ($max-$min)/$steps;
	echo "<select name=$name>";
	for ($i = $min;$i<=$max;$i = $i+$step)
	{
		if ($value == $i) echo "<option value=$i selected>&#163;$i</option>";
			else echo "<option value=$i>&#163;$i</option>";
	}
	echo "</select>";
}
function prf_bedroom_drop_down($name,$min,$max,$steps,$value = NULL)
{

	$step = ($max-$min)/$steps;
	echo "<select name=$name>";
	for ($i = $min;$i<=$max;$i = $i+$step)
	{
		if ($value == $i) echo "<option value=$i selected>$i</option>";
			else echo "<option value=$i>$i</option>";
	}
	echo "</select>";
}
function prf_additional_menu()
{
	global $pr_newsletter_slug,$pr_user_properties_slug,$pr_user_downloads_slug,$pr_tennant_slug,$pr_avail_bands,$pr_user_bands,$pr_user_basket;
	//$_str = '<li><a href='.get_permalink(get_page_by_path($pr_newsletter_slug)).'>Edit My Newsletter</a></li>';
	$_str = '<li><a href='.get_permalink(get_page_by_path($pr_user_properties_slug)).'>My Properties</a>
			'.prf_prop_menu().'</li>';
	//$_str .= '<li><a href='.get_permalink(get_page_by_path($pr_avail_bands)).'>Buy a Band</a></li>';
	$_str .= '<li><a href='.get_permalink(get_page_by_path($pr_user_downloads_slug)).'>Downloads</a></li>';
	$_str .= '<li><a href='.get_permalink(get_page_by_path($pr_tennant_slug)).'>Tenant\'s Personal Details</a></li>';

	return $_str;
}
function prf_sales_form($prid = NULL, $action = "add")
{global $wpdb,$pr_areas,$pr_area_types,$pr_properties,$pr_prefix,$pr_tmp_properties,$user_ID,$_err_ids,$pr_wrong_input_class;
/*
	if ($prid != NULL) {
*/

		if (isset($_POST['submit'])) {//user submits property data
			$tmp_id = pr_tmp_new($user_ID,$_POST['property_types']);//create temp property
			$_POST['act']='preview';
			$_POST['tmp_id']=$tmp_id;
			pr_update_tmp_property();//now we call the same function, which we use for creating previews
			// after that we get property datat from temp table by its tmp_id
			$property = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$pr_tmp_properties.' WHERE ID = %d', $tmp_id));
			//print_r($property);
		} else {
			$property = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$pr_properties.' WHERE ID = %d', $prid));
		}

/*
	} else {
		$property_obj = pr_3rd_array_to_object($_POST);
		$property = array();
		$property[0] = $property_obj;
	}
*/
	// assigning vars for pr_edit_subform function, whichgenerates forms
	isset($property[0]->area) ? $area = $property[0]->area : $area = NULL;
	isset($property[0]->addr_city) ? $addr_city = $property[0]->addr_city : $addr_city = NULL;
	isset($property[0]->addr_county) ? $addr_county = $property[0]->addr_county : $addr_county = NULL;
	isset($property[0]->addr_country) ? $addr_country = $property[0]->addr_country : $addr_country = NULL;
	isset($property[0]->type) ? $type = $property[0]->type : $type = NULL;
	isset($property[0]->bedroomnum) ? $bedroomnum = $property[0]->bedroomnum : $bedroomnum = NULL;
	isset($property[0]->bathroomnum) ? $bathroomnum = $property[0]->bathroomnum : $bathroomnum = NULL;
	isset($property[0]->receptionroomnum) ? $receptionroomnum = $property[0]->receptionroomnum : $receptionroomnum = NULL;
	isset($property[0]->extra_status) ? $extra_status = $property[0]->extra_status : $extra_status = NULL;
	isset($property[0]->approved) ? $approved = $property[0]->approved : $approved = 0;
	switch ($action)
	{
		case "add":
			prf_add_prop_form(); // showing disabled forms on property form
			$title = "Add property for sale";
		break;
		case "edit":
			$title = "Edit property for sale";
		break;
	}
if ($prid == NULL or $approved == 0) {
	$_block_editing = false;
} else $_block_editing = true;

pr_init_property_form();

$_dates = array($property[0]->extra_date_displ_from,$property[0]->extra_date_avail_from);
pr_dateinput('input#Let_DisplayFrom, input#Let_AvailableFrom');?>
<? pr_m_($title,'','h1');?>
	<?
// initializing swfupload fields
$_swfu_fields = array();
$_swfu_fields[] = array('pics','pic');
$_swfu_fields[] = array('files','file');

pr_swfupload_init($_swfu_fields);
	pr_edit_subform("form_start","sales_form",NULL,NULL,'');
	?>
	<div class="pr_block">
		<h3 class="manage-column column-title"><span>Sale information</span></h3>
		<div class="inside">
			<p>Price</p><p><input type="text" name="pr_sale_price" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->sale_price;?>"></p>
			<p>Description</p><p>
			<div class="editor_container">
			<?php
			$_descr_text = '';
			if ($prid != NULL or $tmp_id!=NULL) {
				$_descr = $property[0]->descr;
			}
			//the_editor(str_replace("\'", "'", str_replace('\&quot;', '"', stripslashes($_descr))),'pr_descr','pr_descr');
			?>
			   <textarea id="pr_descr" name="pr_descr"><?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->descr;?></textarea>
			<?
			//pr_editor_init($_descr, '#pr_descr');
			?>

			</div>
			</p>
			<p>View arrangements</p><p><textarea name="pr_viewarrange"><?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->viewarrange;?></textarea></p>
			<p>Refference number</p><p><input type="text" name="pr_refnumber" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->refnumber;?>"></p>

			<p class="<?if (in_array(4, $_err_ids)) echo $pr_wrong_input_class;?>">Type<span class="required">*</span></p><p><?pr_edit_subform("prop_types",$type);?></p>
			<p>Number of bedrooms</p><p><?pr_edit_subform("num_of_bedrooms",$bedroomnum,NULL,"pr_bedroomnum",10);?></p>
			<p>Number of bathrooms</p><p><?pr_edit_subform("num_of_bedrooms",$bathroomnum,NULL,"pr_bathroomnum",10);?></p>
			<p>Number of reception rooms</p><p><?pr_edit_subform("num_of_bedrooms",$receptionroomnum,NULL,"pr_receptionroomnum",10);?></p>
		</div>
	</div>

	<div class="pr_block">
		<h3 class="manage-column column-title"><span>Address information</span></h3>
		<div class="inside">
			<p class="<?if (in_array(3, $_err_ids)) echo $pr_wrong_input_class;?>">Area<span class="required">*</span></p><p>
			<?
			if ($_block_editing == true)
			{
				$_area = $wpdb->get_var($wpdb->prepare("SELECT a.Name FROM $pr_properties pr LEFT JOIN $pr_areas a ON pr.area = a.ID WHERE pr.ID = %d",$prid));
				echo $_area;
			}
			else {
				prf_area_select_form($area);
				//pr_edit_subform("areas",$area,NULL,'pr_area',NULL);
			}
			?>
			</p>
			<p>Building name</p>
				<?if ($_block_editing == false) {?>
				<p><input type="text" name="pr_addr_building_name" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->addr_building_name;?>"></p>
				<?} else {?>
				<p><input type="hidden" name="pr_addr_building_name" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->addr_building_name;?>"></p>
				<?

pr_m_($property[0]->addr_building_name);
}?>

			<p class="<?if (in_array(2, $_err_ids)) echo $pr_wrong_input_class;?>">Door number<span class="required">*</span></p>
				<?if ($_block_editing == false) {?>
				<p><input type="text" id="door_number" name="pr_addr_door_number" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->addr_door_number;?>"></p>
				<?} else {?>
				<p><input type="hidden" id="door_number" name="pr_addr_door_number" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->addr_door_number;?>"></p>
				<?
pr_m_($property[0]->addr_door_number);
}?>

			<p class="<?if (in_array(1, $_err_ids)) echo $pr_wrong_input_class;?>">Street<span class="required">*</span></p>
				<?if ($_block_editing == false) {?>
				<p><input type="text" name="pr_addr_street" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->addr_street;?>"></p>
				<?} else {?>
				<p><input type="hidden" name="pr_addr_street" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->addr_street;?>"></p>
				<?
pr_m_($property[0]->addr_street);
}?>

			<p>Post code</p>
				<?if ($_block_editing == false) {?>
				<p><input type="text" name="pr_postcode" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->addr_postcode;?>"></p>
				<?} else {?>
				<p><input type="hidden" name="pr_postcode" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->addr_postcode;?>"></p>
				<?
pr_m_($property[0]->addr_postcode);
}?>
<?/*
   <p>City</p><p>
   <?//pr_edit_subform("city",$addr_city,NULL,"pr_addr_city");?>
   </p>
   <p>County</p><p>
   <?//pr_edit_subform("county",$addr_county,NULL,"pr_addr_county");?>
   </p>
   <p>Country</p><p>
   <?//pr_edit_subform("country",$addr_country,NULL,"pr_addr_country");?>
   </p>
*/?>
		</div>
	</div>

	<div class="pr_block">
		<h3 class="manage-column column-title"><span>Extra information</span></h3>
		<div class="inside">

			<p>Available from</p><p>
			<input type="text" value="<?if(($prid!=NULL or $tmp_id!=NULL) and $property[0]->extra_date_avail_from != '0000-00-00') echo pr_date_show($property[0]->extra_date_avail_from);?>" name="pr_extra_date_avail_from" id="Let_AvailableFrom"></p>
			<p>Is active</p><p><input type="checkbox" value="1" name="pr_extra_active" <?if ($prid!=NULL and $property[0]->extra_active == 1) echo "checked";?>></p>
      <?if ($prid!=NULL)
      {
      ?>
      <p>Is approved</p><p><?
      switch($property[0]->approved)
      {
      	case 1: echo "yes";break;
      	case 0: echo "no";break;
      }
      ?>
			</p>
      <p>Display from</p><p>
			<? if ($property[0]->extra_date_displ_from != NULL and $property[0]->extra_date_displ_to != '0000-00-00' and $property[0]->extra_date_displ_to != '')
			{
				echo pr_date_show($property[0]->extra_date_displ_from);
			}
			else echo 'N/A';?></p>
      <p>Display to</p><p>
			<?
			if ($property[0]->extra_date_displ_to != NULL and $property[0]->extra_date_displ_to != '0000-00-00' and $property[0]->extra_date_displ_to != '')
			{
				echo pr_date_show($property[0]->extra_date_displ_to);
			}
			else echo 'N/A';?></p>

      <?/*?>
         <p>Is active</p><p><?
         switch($property[0]->extra_active)
         {
         case 1: echo "yes";break;
         case 0: echo "no";break;
         }
         ?>

         </p>

         <?*/?>
			<p>Is featured</p><p>
			<?
			switch($property[0]->extra_featured)
			{
				case 1: echo "yes";break;
				case 0: echo "no";break;
			}
			?>
			</p>
			<?}?>


			<p>Furnishing</p><p>
			<?/*?><input type="text" name="pr_extra_furnishing" value="<?if($prid!=NULL) echo $property[0]->extra_furnishing;?>"><?*/?>
			<?
			$furnishing_vals = array(0,1);
			$furnishing_labels = array('Unfurnished','Furnished');
			pr_edit_subform('select', NULL, NULL, 'pr_extra_furnishing', $property[0]->extra_furnishing,2,$furnishing_vals,$furnishing_labels);?>
			</p>
			<? if (isset($prid)) {?>
			<p>Status</p><p><?global $selling_state; echo $selling_state[$extra_status]['name'];?></p>
			<?}?>
		</div>
	</div>


	<div class="pr_block">
		<h3 class="manage-column column-title"><span>Additional</span></h3>
		<div class="inside">
			<?pr_m_('Pictures');?>
			<?if(isset($prid)) {?><p><?pr_edit_subform('pictures_list',$prid);?></p><?}?>
						<p><?
		pr_swfupload_form('pics','pic');
			//pr_edit_subform('upload_form',NULL,NULL,$pr_prefix.'pic_upload');
			?></p>
			<?pr_m_('Files');?>
			<?if(isset($prid)) {?><p><?pr_edit_subform('files_list_edit',$prid);?></p><?}?>
			<p><?
		pr_swfupload_form('files','file');
	  /*
	  echo "File title<br>";
      pr_edit_subform('text',NULL,NULL,'pr_file_title');
      echo "<br>";
      pr_edit_subform('upload_form',NULL,NULL,$pr_prefix.'file_upload');
	  */
	  ?></p>

			<?pr_m_('Video link');?>
			<p><?pr_edit_subform('video_block',$prid);?></p>

		</div>

	</div>
<?
	global $pr_sale_form_hook;
	do_action($pr_sale_form_hook);
?>
	<p>
	<?
	pr_edit_subform("hidden",NULL,NULL,"pr_action",$action);// this states whether we add or edit
	if ($prid != NULL) pr_edit_subform("hidden",NULL,NULL,"pr_id",$prid);// this states what property we are editing in case of action = edit
	pr_edit_subform("submit",'submit_button');
	?></p>
	<?
	pr_edit_subform("form_end");
	pr_preview_button("sales_form",2,"Preview");
	?>

	<?
}
function prf_prop_list()
{global $wpdb,$pr_areas,$pr_properties,$pr_area_types,$pr_per_page,$user_ID,$pr_user_properties_slug,$pr_slug;
	if (isset($_GET['pr_page_id'])) $pr_page_id = $_GET['pr_page_id'];
		else $pr_page_id = 1;

	$count = $wpdb->get_var("SELECT COUNT(ID) FROM $pr_properties WHERE user_id = $user_ID");
	//$wpdb->show_errors();
	//$wpdb->print_error();
	// getting number of pages
pr_m_('My properties','','h1');
if ($count>0)
{
	$pages = bcdiv($count,$pr_per_page);
	if(bcmod($count,$pr_per_page) > 0) $pages++;
	$pagestring = "Pages ";
	/**/
	for ($i = 1;$i <= $pages;$i++)
	{

		if ($pr_page_id == $i)
		{
		$pagestring .= "<a class='selected' href=".get_permalink(get_page_by_path($pr_user_properties_slug))."?pr_page_id=".$i.">".$i."</a> ";
		} else {
		$pagestring .= "<a href=".get_permalink(get_page_by_path($pr_user_properties_slug))."?pr_page_id=".$i.">".$i."</a> ";
		}
	}

	$start = ($pr_page_id-1)*$pr_per_page;//according to page we start our select from DB
	//we get data from DB according to type of properties
	$results = $wpdb->get_results("
	SELECT
	pr.ID,
	IF (pr.property_type=2,pr.sale_price,pr.let_weekrent) as price,
	a.name as area,
	pr.property_type as type,
	pr.extra_active as active,
	pr.approved as approved,
	a.ID as area_id,
	pr.paid
	FROM $pr_properties pr LEFT JOIN $pr_areas a
		ON pr.area = a.ID
	WHERE user_id = $user_ID
	ORDER BY price ".$_SESSION['sort_by_price'].",
		pr.ID ASC
		LIMIT $start,$pr_per_page;");

	//$wpdb->show_errors();
	//$wpdb->print_error();
	if ($pages > 1) pr_m_($pagestring,"pagination","div");
	?>
<?
pr_edit_subform('price_sort_form');
?>
<table class="widefat">
<thead>
<tr>
	<th class="manage-column column-title">#</th>
	<th class="manage-column column-title">Price</th>
	<th class="manage-column column-title">Address</th>
	<th class="manage-column column-title">Type</th>
	<th class="manage-column column-title">Action</th>
	<th class="manage-column column-title">Active</th>
	<th class="manage-column column-title">Approved</th>

</tr>
</thead>
<tbody>
	<?
	foreach ($results as $prop)
	{
	?>
	<tr>
		<td>
		<a name="<?echo $prop->ID;?>"><?echo $prop->ID;?></a>
		</td>
		<td>
		<?echo pr_price($prop->price);?>
		</td>
		<td>
		<a href="<?echo get_permalink(get_page_by_path($pr_slug)).'?pr_id='.$prop->ID;?>">
		<?

		echo pr_get_prop_address($prop->ID);
		?>
		</a>
		</td>
		<td>
		<?
		switch($prop->type)
		{
			case 1: echo "Let";break;
			case 2: echo "Sale";break;
		}?>
		</td>
		<td>
		<a href="javascript:sureness('<?echo get_permalink(get_page_by_path($pr_user_properties_slug))?>?prf_del_id=<?echo $prop->ID?>')">Delete</a>
		<a href="<?echo get_permalink(get_page_by_path($pr_user_properties_slug))?>?prf_edit_id=<?echo $prop->ID?>">Edit</a>
		</td>
		<td>
		<?if ($prop->active == 1) echo "yes"; else echo "no";?>
		</td>
		<td>
		<?if ($prop->approved == 1) echo "yes"; else echo "no";?>
		</td>
		<?
		/*
		?>
		<td>
		<?
		switch($prop->type)
		{
			case 1: echo 'n/a';break;
			case 2:
				$root_parent = pr_get_area_parents($prop->area_id);
				if ($root_parent['name'] != 'United Kingdom')
				{
					if ($prop->paid == 1) echo 'yes'; else echo 'no';
				} else echo 'n/a';
				//if ()// �������� ����� ������ ��� ������ area
				//echo "Sale";
			break;
		}
		?>
		</td>
		<?
		*/
		?>
	</tr>
	<?
	}
?>
</tbody>
</table>
<?
if ($pages > 1) pr_m_($pagestring,"pagination","div");

} else pr_m_('No properties found','notice','p');

}
function prf_letting_form($prid = NULL, $action = "add")
{global $wpdb,$pr_areas,$pr_area_types,$pr_properties,$pr_prefix,$pr_tmp_properties,$user_ID,$_err_ids,$pr_wrong_input_class;
/*
	if ($prid != NULL) {
*/

		if (isset($_POST['submit'])) {//user submits property data
			$tmp_id = pr_tmp_new($user_ID,$_POST['property_types']);//create temp property
			$_POST['act']='preview';
			$_POST['tmp_id']=$tmp_id;
			pr_update_tmp_property();//now we call the same function, which we use for creating previews
			// after that we get property datat from temp table by its tmp_id
			$property = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$pr_tmp_properties.' WHERE ID = %d', $tmp_id));
			//print_r($property);
		} else {
			$property = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$pr_properties.' WHERE ID = %d', $prid));
		}

/*
	} else {
		$property_obj = pr_3rd_array_to_object($_POST);
		$property = array();
		$property[0] = $property_obj;
	}
*/

	// assigning vars for pr_edit_subform function, whichgenerates forms
	isset($property[0]->area) ? $area = $property[0]->area : $area = NULL;
	isset($property[0]->addr_city) ? $addr_city = $property[0]->addr_city : $addr_city = NULL;
	isset($property[0]->addr_county) ? $addr_county = $property[0]->addr_county : $addr_county = NULL;
	isset($property[0]->addr_country) ? $addr_country = $property[0]->addr_country : $addr_country = NULL;
	isset($property[0]->type) ? $type = $property[0]->type : $type = NULL;
	isset($property[0]->bedroomnum) ? $bedroomnum = $property[0]->bedroomnum : $bedroomnum = NULL;
	isset($property[0]->bathroomnum) ? $bathroomnum = $property[0]->bathroomnum : $bathroomnum = NULL;
	isset($property[0]->receptionroomnum) ? $receptionroomnum = $property[0]->receptionroomnum : $receptionroomnum = NULL;
	isset($property[0]->extra_status) ? $extra_status = $property[0]->extra_status : $extra_status = NULL;
	isset($property[0]->approved) ? $approved = $property[0]->approved : $approved = 0;
	switch ($action)
	{
		case "add":
			prf_add_prop_form(); // showing disabled forms on property form
			$title = "Add property for letting";
		break;
		case "edit":
			$title = "Edit property for letting";
		break;
	}
if ($prid == NULL or $approved == 0) {
	$_block_editing = false;
} else $_block_editing = true;

pr_init_property_form();

$_dates = array($property[0]->extra_date_displ_from,$property[0]->extra_date_avail_from);
pr_dateinput('input#Let_DisplayFrom, input#Let_AvailableFrom');?>
<?pr_m_($title,'','h1');?>
	<?
// initializing swfupload fields
$_swfu_fields = array();
$_swfu_fields[] = array('pics','pic');
$_swfu_fields[] = array('files','file');
pr_swfupload_init($_swfu_fields);
	pr_edit_subform("form_start","letting_form");

	?>
	<div class="pr_block">
		<h3 class="manage-column column-title"><span>Let information</span></h3>
		<div class="inside">
			<p>Rent per weeek</p><p><input type="text" name="pr_let_weekrent" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->let_weekrent;?>"></p>
			<p>Rent per month</p><p><input type="text" name="pr_let_monthrent" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->let_monthrent;?>"></p>
			<p>Description</p><p>
			<div class="editor_container">
			<?php
			$_descr_text = '';
			if ($prid != NULL or $tmp_id!=NULL) {
				$_descr = $property[0]->descr;
			}
			//the_editor(str_replace("\'", "'", str_replace('\&quot;', '"', stripslashes($_descr))),'pr_descr','pr_descr');
			?>
			   <textarea id="pr_descr" name="pr_descr"><?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->descr;?></textarea>
			<?
			//pr_editor_init($_descr, '#pr_descr');
			?>
			</div>
			</p>
			<p>View arrangements</p><p><textarea name="pr_viewarrange"><?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->viewarrange;?></textarea></p>
			<p>Refference number</p><p><input type="text" name="pr_refnumber" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->refnumber;?>"></p>

			<p class="<?if (in_array(4, $_err_ids)) echo $pr_wrong_input_class;?>">Type<span class="required">*</span></p><p><?pr_edit_subform("prop_types",$type);?></p>
			<p>Number of bedrooms</p><p><?pr_edit_subform("num_of_bedrooms",$bedroomnum,NULL,"pr_bedroomnum",10);?></p>
			<p>Number of bathrooms</p><p><?pr_edit_subform("num_of_bedrooms",$bathroomnum,NULL,"pr_bathroomnum",10);?></p>
			<p>Number of reception rooms</p><p><?pr_edit_subform("num_of_bedrooms",$receptionroomnum,NULL,"pr_receptionroomnum",10);?></p>
		</div>
	</div>

	<div class="pr_block">
		<h3 class="manage-column column-title"><span>Address information</span></h3>
		<div class="inside">
			<p class="<?if (in_array(3, $_err_ids)) echo $pr_wrong_input_class;?>">Area<span class="required">*</span></p><p>
			<?
			if ($_block_editing==true)
			{
				$_area = $wpdb->get_var($wpdb->prepare("SELECT a.Name FROM $pr_properties pr LEFT JOIN $pr_areas a ON pr.area = a.ID WHERE pr.ID = %d",$prid));
				echo $_area;
			}
			else {
				prf_area_select_form($area);
				//pr_edit_subform("areas",$area,NULL,'pr_area',NULL);
			}
			?>
			</p>
			<p>Building name</p>
				<?if ($_block_editing==false) {?>
				<p><input type="text" name="pr_addr_building_name" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->addr_building_name;?>"></p>
				<?} else {?>
				<p><input type="hidden" name="pr_addr_building_name" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->addr_building_name;?>"></p>
				<?

				pr_m_($property[0]->addr_building_name);
				}?>

			<p class="<?if (in_array(2, $_err_ids)) echo $pr_wrong_input_class;?>">Door number<span class="required">*</span></p>
				<?if ($_block_editing==false) {?>
				<p><input type="text" id="door_number" name="pr_addr_door_number" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->addr_door_number;?>"></p>
				<?} else {?>
				<p><input type="hidden" id="door_number" name="pr_addr_door_number" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->addr_door_number;?>"></p>
				<?
				pr_m_($property[0]->addr_door_number);
				}?>

			<p class="<?if (in_array(1, $_err_ids)) echo $pr_wrong_input_class;?>">Street<span class="required">*</span></p>
				<?if ($_block_editing==false) {?>
				<p><input type="text" name="pr_addr_street" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->addr_street;?>"></p>
				<?} else {?>
				<p><input type="hidden" name="pr_addr_street" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->addr_street;?>"></p>
				<?
				pr_m_($property[0]->addr_street);
				}?>

			<p>Post code</p>
				<?if ($_block_editing==false) {?>
				<p><input type="text" name="pr_postcode" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->addr_postcode;?>"></p>
				<?} else {?>
				<p><input type="hidden" name="pr_postcode" value="<?if($prid!=NULL or $tmp_id!=NULL) echo $property[0]->addr_postcode;?>"></p>
				<?
				pr_m_($property[0]->addr_postcode);
				}?>
<?/*
			<p>City</p><p>
			<?//pr_edit_subform("city",$addr_city,NULL,"pr_addr_city");?>
			</p>
			<p>County</p><p>
			<?//pr_edit_subform("county",$addr_county,NULL,"pr_addr_county");?>
			</p>
			<p>Country</p><p>
			<?//pr_edit_subform("country",$addr_country,NULL,"pr_addr_country");?>
			</p>
*/?>
		</div>
	</div>

	<div class="pr_block">
		<h3 class="manage-column column-title"><span>Extra information</span></h3>
		<div class="inside">

			<p>Available from</p><p>
			<input type="text" value="<?if(($prid!=NULL or $tmp_id!=NULL) and $property[0]->extra_date_avail_from != '0000-00-00') echo pr_date_show($property[0]->extra_date_avail_from);?>" name="pr_extra_date_avail_from" id="Let_AvailableFrom"></p>
			<p>Is active</p><p><input type="checkbox" value="1" name="pr_extra_active" <?if ($prid!=NULL and $property[0]->extra_active == 1) echo "checked";?>></p>
      <?if ($prid!=NULL)
			{
			?>
      <p>Is approved</p><p><?
			switch($property[0]->approved)
			{
				case 1: echo "yes";break;
				case 0: echo "no";break;
			}
				?>
			</p>
      <p>Display from</p><p>
			<? if ($property[0]->extra_date_displ_from != NULL and $property[0]->extra_date_displ_to != '0000-00-00' and $property[0]->extra_date_displ_to != '')
			{
				echo pr_date_show($property[0]->extra_date_displ_from);
			}
			else echo 'N/A';?></p>
      <p>Display to</p><p>
			<?
			if ($property[0]->extra_date_displ_to != NULL and $property[0]->extra_date_displ_to != '0000-00-00' and $property[0]->extra_date_displ_to != '')
			{
				echo pr_date_show($property[0]->extra_date_displ_to);
			}
			else echo 'N/A';?></p>

      <?/*?>
			<p>Is active</p><p><?
			switch($property[0]->extra_active)
			{
				case 1: echo "yes";break;
				case 0: echo "no";break;
			}
				?>

				</p>

			<?*/?>
			<p>Is featured</p><p>
			<?
			switch($property[0]->extra_featured)
			{
				case 1: echo "yes";break;
				case 0: echo "no";break;
			}
				?>
			</p>
			<?}?>

			<p>Furnishing</p><p>
			<?/*?><input type="text" name="pr_extra_furnishing" value="<?if($prid!=NULL) echo $property[0]->extra_furnishing;?>"><?*/?>
			<?
			$furnishing_vals = array(0,1);
			$furnishing_labels = array('Unfurnished','Furnished');
			pr_edit_subform('select', NULL, NULL, 'pr_extra_furnishing', $property[0]->extra_furnishing,2,$furnishing_vals,$furnishing_labels);?>
			</p>
			<? if (isset($prid)) {?>
			<p>Status</p><p><?global $selling_state; echo $selling_state[$extra_status]['name'];?></p>
			<?}?>
		</div>
	</div>

	<div class="pr_block">
		<h3 class="manage-column column-title"><span>Additional</span></h3>
		<div class="inside">
			<?pr_m_('Pictures');?>
			<?if(isset($prid)) {?><p><?pr_edit_subform('pictures_list',$prid);?></p><?}?>
						<p><?
		pr_swfupload_form('pics','pic');
			//pr_edit_subform('upload_form',NULL,NULL,$pr_prefix.'pic_upload');
			?></p>
			<?pr_m_('Files');?>
			<?if(isset($prid)) {?><p><?pr_edit_subform('files_list_edit',$prid);?></p><?}?>
			<p><?
		pr_swfupload_form('files','file');
	  /*
	  echo "File title<br>";
      pr_edit_subform('text',NULL,NULL,'pr_file_title');
      echo "<br>";
      pr_edit_subform('upload_form',NULL,NULL,$pr_prefix.'file_upload');
	  */
	  ?></p>

			<?pr_m_('Video link');?>
			<p><?pr_edit_subform('video_block',$prid);?></p>

		</div>
	</div>
<?
	global $pr_letting_form_hook;
	do_action($pr_letting_form_hook);
?>
	<p>
	<?
	pr_edit_subform("hidden",NULL,NULL,"pr_action",$action);// this states whether we add or edit
	if ($prid != NULL) pr_edit_subform("hidden",NULL,NULL,"pr_id",$prid);// this states what property we are editing in case of action = edit
	pr_edit_subform("submit",'submit_button');
	?></p>
	<?
	pr_edit_subform("form_end");
	pr_preview_button("letting_form",1,"Preview");
	?>

	<?
}
function prf_find_new_order($user_id)
{
	global $wpdb,$pr_orders;
	$_new = $wpdb->get_var("SELECT ID FROM $pr_orders WHERE status = 'new' and user_id = $user_id;");
	if ($_new == NULL) return NULL;
		else return $_new;
}
function prf_create_new_order_for_basket($ref,$user_id,$total,$basketid)
{
	global $wpdb,$pr_orders,$pr_baskets;

	//create order
	$wpdb->query("DELETE FROM $pr_orders WHERE status='new' and user_id=$user_id");
	$wpdb->query("INSERT INTO $pr_orders (ID,total,user_id,reference,status,date_issued) values (NULL,$total,$user_id,'$ref','new','".date('Y-m-d H:i:s')."');");
	$_lid = $wpdb->get_var("SELECT LAST_INSERT_ID()");
	//$wpdb->show_errors();
	//$wpdb->print_error();
	//$_ids = pr_array_list($props);
	//update baskets. we put for each of requested properties order_ref = ref
	$wpdb->query("UPDATE $pr_baskets SET order_ref = '$ref' WHERE basketid=$basketid;");
	prf_create_order_details_for_basket($_lid,$basketid,$ref);
}
function prf_create_new_order($ref,$user_id,$total,$props)
{
	global $wpdb,$pr_orders,$pr_properties;

	//create order
	$wpdb->query("INSERT INTO $pr_orders (ID,total,user_id,reference,status,date_issued) values (NULL,$total,$user_id,'$ref','new','".date('Y-m-d H:i:s')."');");
	$_lid = $wpdb->get_var("SELECT LAST_INSERT_ID()");
	//$wpdb->show_errors();
	//$wpdb->print_error();
	$_ids = pr_array_list($props);
	//update properties. we put for each of requested properties order_ref = ref
	$wpdb->query("UPDATE $pr_properties SET order_ref = '$ref' WHERE ID IN ($_ids) and band_id != 0;");
	prf_create_order_details($_lid,$props,$ref);
}
function prf_create_order_details_for_basket($orid,$basketid,$ref)
{
	global $wpdb,$pr_order_details,$pr_baskets,$pr_property_types,$pr_band_types;
	// details of properties by updated properties ids
	$sql = "select b.bandname, pt.type_name, b.startdate, b.enddate, b.price, b.prop_limit, bt.typename as bandtype
				from $pr_baskets b inner join $pr_property_types pt
					on b.property_type = pt.typeid inner join $pr_band_types bt
					on b.band_type = bt.typeid
				where basketid=$basketid";
	$details = $wpdb->get_results($sql);
	$det = $details[0];
	$details = $det->bandname.' start: '.$det->startdate.' end:'.$det->enddate.' propery type: '.$det->type_name.' band type: '.$det->bandtype;
	$sql = "INSERT INTO $pr_order_details (ID,details,price,order_id)
				values (NULL,'$details',$det->price,$orid) ";
	$wpdb->query($sql);


}
function prf_create_order_details($orid,$props,$ref)
{
  global $wpdb,$pr_order_details,$pr_properties,$pr_bands,$pr_areas;
// details of properties by updated properties ids
  $details = $wpdb->get_results("SELECT IF(b.Name IS NULL,'N/A',b.Name) as band, pr.addr_door_number as dnum, pr.addr_street as street, pr.addr_postcode as pcode, a.name as area, pr.area as area_id, IF(pr.sale_price IS NOT NULL,pr.sale_price,pr.let_weekrent) as price FROM $pr_properties pr LEFT JOIN $pr_bands b ON pr.band_id = b.ID LEFT JOIN $pr_areas a ON pr.area = a.ID  WHERE order_ref = '$ref'");
  // inserting details to order_details by insert_last_id() for order
  foreach($details as $det)
  {
  $areas_route = pr_area_path($det->area_id);
   $wpdb->query("INSERT INTO $pr_order_details (ID,details,price,order_id) values (NULL,'$det->band, $det->dnum, $det->street, $det->pcode, $areas_route',$det->price,$orid)");
 // $wpdb->show_errors();
	//$wpdb->print_error();
  }


}
function prf_update_order_for_basket($order_id,$ref,$user_id,$total,$basketid)
{
	global $wpdb,$pr_orders,$pr_baskets;

	//update order
	$wpdb->query("UPDATE $pr_orders SET reference = '$ref', user_id = $user_id, total = $total, status = 'new', date_issued = '".date('Y-m-d H:i:s')."' WHERE ID = $order_id;");
	$_ids = $basketid;
	//update properties. we put for each of requested properties order_ref = ref
	$wpdb->query("UPDATE $pr_baskets SET order_ref = '$ref' WHERE ID IN ($_ids)");
	prf_update_order_details_for_basket($order_id,$basketid,$ref);
}
function prf_update_order($order_id,$ref,$user_id,$total,$props)
{
	global $wpdb,$pr_orders,$pr_properties;

	//update order
	$wpdb->query("UPDATE $pr_orders SET reference = '$ref', user_id = $user_id, total = $total, status = 'new', date_issued = '".date('Y-m-d H:i:s')."' WHERE ID = $order_id;");
	$_ids = pr_array_list($props);
	//update properties. we put for each of requested properties order_ref = ref
	$wpdb->query("UPDATE $pr_properties SET order_ref = '$ref' WHERE ID IN ($_ids) and band_id != 0;");
	 prf_update_order_details($order_id,$props,$ref);
}
function prf_update_order_details_for_basket($orid,$basketid,$ref)
{
	global $wpdb,$pr_order_details,$pr_baskets;
	//delete all previous details from order_details
	$wpdb->query("DELETE FROM $pr_order_details WHERE order_id = $orid");
	// $wpdb->show_errors();
	//	$wpdb->print_error();
	// get details of newly updated properties
prf_create_order_details_for_basket($orid,$basketid,$ref);
}
function prf_update_order_details($orid,$props,$ref)
{
  global $wpdb,$pr_order_details,$pr_properties,$pr_bands,$pr_areas;
  //delete all previous details from order_details
  $wpdb->query("DELETE FROM $pr_order_details WHERE order_id = $orid");
 // $wpdb->show_errors();
//	$wpdb->print_error();
  // get details of newly updated properties
  $details = $wpdb->get_results("SELECT IF(b.Name IS NULL,'N/A',b.Name) as band, pr.addr_door_number as dnum, pr.addr_street as street, pr.addr_postcode as pcode, a.name as area, IF(pr.sale_price IS NOT NULL,pr.sale_price,pr.let_weekrent) as price FROM $pr_properties pr LEFT JOIN $pr_bands b ON pr.band_id = b.ID LEFT JOIN $pr_areas a ON pr.area = a.ID WHERE order_ref = '$ref'");
 // $wpdb->show_errors();
//	$wpdb->print_error();
  // add new details for order_id
  foreach($details as $det)
  {
   $wpdb->query("INSERT INTO $pr_order_details (ID,details,price,order_id) values (NULL,'$det->band, $det->dnum, $det->street, $det->pcode, $det->area',$det->price,$orid)");
//  $wpdb->show_errors();
//	$wpdb->print_error();
  }
}

function prf_make_payment()
{
	global $wpdb,$user_ID,$pr_orders,$pr_properties,$pr_seller_mail,$pr_data_send_url,$pr_token,$pr_baskets;
	// make order completed if we get completion from paypal and item_number = pr_order.refernce
$err = true;
if (isset($_GET['tx']))
{
$handle = file($pr_data_send_url.'?tx='.$_GET['tx'].'&cmd=_notify-synch&at='.$pr_token);
//print_r($handle);
//echo "Under construction";
if(trim($handle[0])=="SUCCESS")
{
	$err = false;
	foreach($handle as $row)
	{
		list($par,$val) = explode("=",trim($row));
		switch($par)
		{
			case "mc_gross":
				if($val!=$_GET['amt']) {
					$err = true;
					pr_m_($par.' error','error','p');
				}
			break;
			case "payment_status":
				if($val != $_GET['st']) {
					$err = true;
					pr_m_($par.' error','error','p');
				}
			break;
			case "business":
				$pr_seller_mail = str_replace('@','%40',$pr_seller_mail);
				if($val != $pr_seller_mail) {
					$err = true;
					pr_m_($par.' error','error','p');
				}
			break;
			case "txn_id":
				if ($val != $_GET['tx']) {
					$err = true;
					pr_m_($par.' error','error','p');
				}
			break;
			case "item_number":
				if($_GET['item_number']=='') $_GET['item_number'] = $val; // for subscriptions this field is emty in GET array
				if($val != $_GET['item_number']) {
					$err = true;
					pr_m_($par.' error','error','p');
				}
			break;
			case "payment_status":
				if($val != $_GET['st']) {
					$err = true;
					pr_m_($par.' error','error','p');
				}
			break;

		}

	}
} else { pr_m_("Failure in varifying transaction.",'error','div');$err = true;}
/*
?>
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr/" method="post">
<input type="hidden" name="tx" value="<?echo $_GET['tx']?>">
<input type="hidden" name="cmd" value="_notify-synch">
<input type="hidden" name="at" value="Qtw6luJnqWQcC1ry3KWvUxqOLWLkeapxVF1WeKiElqYWkz_0Wn9zIebP-68">
<input type="submit" value="Verify">
</form>
<?
*/
/**/
if ($err == false)
{
pr_m_('Payment verified','success','div');
	$_order = $wpdb->get_results($wpdb->prepare("SELECT * FROM $pr_orders WHERE reference = %s",$_GET['item_number']));
	if(sizeof($_order)!=1)
	{
		pr_m_('Internal error','error','div');
	} else { // we have 1 order with correct reference
		foreach ($_order as $order)
		{

		if(strtoupper($_GET['st'])=='PENDING' or strtoupper($_GET['st'])=='COMPLETED') // this order is completed Pending(will be 'Completed' within 24 hours)
		{
			pr_m_('Order was completed','success','div');
			//echo $_GET['st'];
			if($_GET['amt'] == $order->total)
			{
				if($user_ID == $order->user_id)
				{
					if($order->status == 'new')
					{
						// finally we checked all the stuff
						// update order
						$wpdb->query($wpdb->prepare("UPDATE $pr_orders SET status = '%s', transaction_id = '%s', date_completed = '".date('Y-m-d H:i:s')."' WHERE reference = '%s';",$_GET['st'],$_GET['tx'],$_GET['item_number']));
						// update properties, make them paid

						//activating all bands for current order ref
						$wpdb->query($wpdb->prepare("UPDATE $pr_baskets SET active = 1, startdate=now(), user_cartid=0 WHERE order_ref = %s",$_GET['item_number']));

						//updating end date of one-off bands
						$wpdb->query($wpdb->prepare("UPDATE $pr_baskets SET enddate=now() + period day WHERE order_ref = %s and band_type=1",$_GET['item_number']));

						// deleting cart
						prub_delete_user_cart($user_ID);

						//$wpdb->query($wpdb->prepare("UPDATE $pr_properties SET paid = 1 WHERE order_ref = %d",$_GET['item_number']));

						// WTZ HOOK for Notifications
						global $pr_u_adds_pfp;
						$ids = $wpdb->get_results($wpdb->prepare("SELECT basketid as ID FROM $pr_baskets WHERE order_ref = %s",$_GET['item_number']));
						//$ids = $wpdb->get_results($wpdb->prepare("SELECT ID FROM $pr_properties WHERE order_ref = %d",$_GET['item_number']));
						$pr_ids = array();
						foreach ($ids as $id){
							$pr_ids[] = $id->ID;
						}
						do_action($pr_u_adds_pfp, $pr_ids, $pr_u_adds_pfp);

					} else pr_m_('This order isn\'t new, and can\'t be paid','error','div');
				} else pr_m_('This order was requested by another user','error','div');
			} else pr_m_('The total amount of money paid and requested to pay does not match','error','div');
		} else pr_m_('Order wasn\'t completed','error','div');

		}
	}
}

}

if ($err==false) {
	return true;
}else return false;
}

function prf_checkout()
{
	global $pr_user_properties_slug,$pr_properties,$user_ID,$wpdb,$pr_areas,$pr_bands,$pr_area_types;
	// function checks all by itself
	prf_make_payment();

	if (isset($_POST['pr_bands']) and isset($_POST['pr_prop_ids']))
	{
		// update bands
		$i = 0;
		foreach($_POST['pr_prop_ids'] as $prid)
		{
			$wpdb->query($wpdb->prepare("UPDATE $pr_properties SET band_id = %d WHERE ID = %d;",$_POST['pr_bands'][$i],$prid));
			$i++;
		}
	}


	$_unpaid = $wpdb->get_var("SELECT COUNT(ID) FROM $pr_properties WHERE paid = 0 AND user_id = $user_ID AND property_type = 2;");
	if ($_unpaid>0)

	{


		$_excl_area = array('United Kingdom');
		foreach ($_excl_area as $area)
		{
			$_excl_arid[] = $wpdb->get_var("SELECT ID FROM $pr_areas WHERE name = '$area'");
		}

		$_unpaid = $wpdb->get_results("SELECT ID,area FROM $pr_properties WHERE paid = 0 AND user_id = $user_ID AND property_type = 2;");
		foreach($_unpaid as $prop)
		{
			if(!in_array($prop->area,$_excl_arid) and pr_check_parent($prop->area,$_excl_arid)==false)
				{
					$_un_prop_ids[] = $prop->ID;
				}
		}
		//print_r($_un_prop_ids);
	if(isset($_un_prop_ids) and sizeof($_un_prop_ids)>0)
	{
		$_ids = pr_array_list($_un_prop_ids); // making $ids row for SQL

		if(isset($_POST['submit']))
		{

		// COUNT total price for properties according to their Bands
		// Band A
		$band_a_count = $wpdb->get_var("SELECT COUNT(pr.ID) FROM $pr_properties pr LEFT JOIN $pr_bands b ON pr.band_id = b.ID WHERE pr.ID IN ($_ids) AND b.Name = 'Band A';");
		if ($band_a_count>0)
		{
		//$wpdb->show_errors();
		//$wpdb->print_error();

		switch ($band_a_count)
		{
			case 0:	$band_a = 0;break;
			case 1: $band_a = 100;break;
			case 2: $band_a = 150;break;
			default: $band_a = 150 + ($band_a_count-2)*25;
		}
		//echo $band_a;
		}

		// Band B
		$band_b_areas = $wpdb->get_results("SELECT pr.area FROM $pr_properties pr LEFT JOIN $pr_bands b ON pr.band_id = b.ID WHERE pr.ID IN ($_ids) AND b.Name = 'Band B';");
		$band_b_count = sizeof($band_b_areas);
		if ($band_b_count>0)
		{
		//$wpdb->show_errors();
		//$wpdb->print_error();
		foreach($band_b_areas as $area)
		{
			$_type = $wpdb->get_var("SELECT t.name FROM $pr_areas a LEFT JOIN $pr_area_types t ON a.type = t.ID WHERE a.ID = $area->area");
			if ($_type == 'Country') $_country[] = $area->area;
				else $_country[] = pr_find_parent_by_type($area->area,'Country');
		}
		$u_country = array_unique($_country);//������ ���������� �������� ������� �����
		foreach($u_country as $id_country)
		{
			$t = 0;
			for ($i=0;$i<sizeof($_country);$i++)
			{
				if ($id_country == $_country[$i]) $t++;
			}
			$count_country[] = $t;//������ ���������� ��������� ��� ������ �� �����
		}
		//print_r($_country);
		//print_r($count_country);
		$band_b = 0;
		foreach($count_country as $count)
		{
			switch($count)
			{
				case 1: $band_b += 250;break;
				case 2: $band_b += 350;break;
				default: $band_b += 350+($count-2)*50;break;
			}
		}
		//echo $band_b;
		}

		// Band C
		$band_c_count = $wpdb->get_var("SELECT COUNT(pr.ID) FROM $pr_properties pr LEFT JOIN $pr_bands b ON pr.band_id = b.ID WHERE pr.ID IN ($_ids) AND b.Name = 'Band C';");
		$band_c = $band_c_count*100;
		//echo $band_c;

		$band_total = $band_a+$band_b+$band_c;
		} else $band_total = "not counted";

		$props = $wpdb->get_results("SELECT pr.ID,pr.sale_price as price,a.Name as area,pr.addr_postcode as postcode,pr.addr_door_number as door_number,pr.addr_street as street, pr.band_id, pr.area as area_id FROM $pr_properties pr LEFT JOIN $pr_areas a ON pr.area = a.ID WHERE pr.ID IN ($_ids)");
		//$wpdb->show_errors();
		//$wpdb->print_error();
		global $pr_user_properties_slug;

		pr_edit_subform('price_sort_form');

		pr_edit_subform("form_start",NULL,NULL,$pr_user_properties_slug.'/?pr_action='.$_GET['pr_action']);
		?>
<table class="widefat">
<thead>
<tr>
	<th class="manage-column column-title">#</th>
	<th class="manage-column column-title">Address</th>
	<th class="manage-column column-title">Band</th>
</tr>
</thead>
<tbody>
		<?
		foreach($props as $prop)
		{
?>
<tr>
	<td><?echo $prop->ID?></td>

	<td><a href="<?echo get_permalink(get_page_by_path($pr_user_properties_slug))?>?prf_edit_id=<?echo $prop->ID?>">
	<?
	$_addr_line = pr_get_prop_address($prop->ID);
	echo $_addr_line;
	?>
	</a></td>
	<td>
	<?
	pr_edit_subform("bands",NULL,$pr_bands,"pr_bands[]",$prop->band_id);
	pr_edit_subform("hidden",NULL,NULL,"pr_prop_ids[]",$prop->ID);
	?>
	</td>
</tr>
<?
		}
		?>
</tbody>
</table>
		<?
		pr_m_("Total: &pound;".pr_price($band_total),'total','p');
		//pr_edit_subform("hidden",NULL,NULL,'pr_total_pay',$band_total);
		pr_edit_subform("submit",NULL,NULL,'Calculate total');
		pr_edit_subform("form_end");

		if (isset($_POST['submit']) and $band_total > 0)
		{
			$ref_number = mktime();// reference number for created order to pay
			// check if current user has any orders already with 'new' status
			$_order_id = prf_find_new_order($user_ID);
			if ($_order_id == NULL)
			{
				prf_create_new_order($ref_number,$user_ID,$band_total,$_POST['pr_prop_ids']);
				//echo "we create new order";
			}
			else
			{
				prf_update_order($_order_id,$ref_number,$user_ID,$band_total,$_POST['pr_prop_ids']);
				//echo "we update existing not completed order";
			}

			prf_paypal_button($band_total,$ref_number);
		}

?>
<p>
<b>Band A</b> - With this band, your property receives maximum exposure via the internet and all papers in which Queens Park Real Estates uses as a marketing medium. At the moment we do use the best and most visited websites, where your property can be viewed by all around the world. We also use our website which is regularly updated and is visited by millions of people around the world on a daily basis. Our marketing team are working endlessly to give our properties maximum exposure and improve our quality of service. All you need to do is send us the details of the property to include pictures and we do the rest. We would provide all applicants your details and they can contact you directly also we would forward the details of all applicants to you and you can contact them yourself. Under this band, NO COMMISION IS CHARGED ON SALE ONLY A ONE OF FEE OF <b>&pound;100</b>(which allows you to give your property maximum exposure for 12months). Two properties - <b>&pound;150</b>, each next - <b>&pound;25</b>.
</p>
<p>
<b>Band B</b> - With this band, you enjoy all the facilities Band A offers but in this case we give you a valuation, and take all measurements and pictures ourselves we also advise you on your property  so you can achieve the highest market price possible. We also advertise your property with our local representative in the respective region (please confirm with our team that we do have an office in your region).You communicate directly with all clients that indicates an interest in your property.
Under this band, NO COMMISION IS CHARGED ON SALE ONLY A ONE OF FEE OF<b>&pound;250</b>(which allows you to give your property maximum exposure for 12months). Two properties in the same country - <b>&pound;350</b>, each next property in the same country - <b>&pound;50</b>.
 </p>
<p>
<b>Band C</b> - We take charge of the sale of your property from valuation to completion. The charge for this band is <b>&pound;100</b> BY THE MARKETING DEPARTMENT AND THE SALE COMMISSION (which varies from one country to the other. Please ask our team what the applied sale commission in your region is)
</p>
<?
	}

	}


}
function prf_paypal_button($total_price,$ref_number,$cmd='_xclick',$period=NULL)
{
global $pr_seller_mail,$pr_data_send_url,$pr_token,$pr_hosted_button_id,$pr_item_number,$pr_paypal_recur_period;
switch($cmd){
	case '_xclick-subscriptions':
		$period = $pr_paypal_recur_period;
		$src = 1;
/*
		Recurring payments. Subscription payments recur unless subscribers cancel their subscriptions before the end of the current billing cycle or you limit the number of times that payments recur with the value that you specify for srt.
		Allowable values:
		0 – subscription payments do not recur
		1 – subscription payments recur
		The default is 0.
*/

		$srt = 99999;
/*
		Recurring times. Number of times that subscription payments recur. Specify an integer above 1. Valid only if you specify src="1".
*/
		$sra = 1;
/*
		Reattempt on failure. If a recurring payment fails, PayPal attempts to collect the payment two more times before canceling the subscription.
		Allowable values:
		0 – do not reattempt failed recurring payments
		1 – reattempt failed recurring payments before canceling
		The default is 1.
*/
		$a3 = $total_price;
			//Regular subscription price.
		$p3 = $period;
		//Subscription duration. Specify an integer value in the allowable range for the units of duration that you specify with t3.
		$t3 = 'D';

/*
		Regular subscription units of duration. Allowable values:
		D – for days; allowable range for p3 is 1 to 90
		W – for weeks; allowable range for p3 is 1 to 52
		M – for months; allowable range for p3 is 1 to 24
		Y – for years; allowable range for p3 is 1 to 5
*/
		break;
} // switch
?>
<form action="<?echo $pr_data_send_url?>" method="post">

<input type="hidden" name="cmd" value="<?echo $cmd?>">
<?/*?>
<input type="hidden" name="cmd" value="_s-xclick"><?*/?>
<input type="hidden" name="business" value="<?echo $pr_seller_mail?>">
<input type="hidden" name="lc" value="GB">
<input type="hidden" name="item_name" value="order payment">
<input type="hidden" name="button_subtype" value="services">
<input type="hidden" name="no_note" value="0">
<input type="hidden" name="currency_code" value="GBP">
<input type="hidden" name="amount" value="<?echo $total_price?>">
<?/*?><input type="hidden" name="hosted_button_id" value="<?echo $pr_hosted_button_id?>"><?*/?>
<input type="hidden" name="item_number" value="<?echo $ref_number?>">
<?if ($cmd=='_xclick-subscriptions') {
?>
<input type="hidden" name="src" value="<?echo $src?>">
<?/*?><input type="hidden" name="srt" value="<?echo $srt?>"><?*/?>
<input type="hidden" name="sra" value="<?echo $sra?>">
<input type="hidden" name="a3" value="<?echo $a3?>">
<input type="hidden" name="p3" value="<?echo $p3?>">
<input type="hidden" name="t3" value="<?echo $t3?>">
<?
}?>
<?/*?>
<input type="hidden" name="return" value="http://www.queensparkrealestates.co.uk/pr-properties/?pr_action=finish_checkout">
<input type="hidden" name="rm" value="2">
<?*/?>

<? pr_edit_subform('submit',NULL,NULL,"Pay now"); ?>
<?/*?>

<input type="image" src="https://www.sandbox.paypal.com/en_GB/i/btn/btn_buynow_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.sandbox.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1">
<?*/?>
</form>

<?
}

function prf_prop_menu()
{
	global $pr_user_properties_slug,$pr_properties,$user_ID,$wpdb,$pr_areas,$exclude_areas,$pr_user_bands,$pr_user_basket,$prf_action_add_property;

	$_str = "";
	$_str .= '<li><a href=\''.get_permalink(get_page_by_path($pr_user_properties_slug)).'?pr_action='.$prf_action_add_property.'\'>Add  property</a></li>';
	$_str .= '<li><a href=\''.get_permalink(get_page_by_path($pr_user_basket)).'\'>Basket</a></li>';
	$_str .= '<li><a href=\''.get_permalink(get_page_by_path($pr_user_properties_slug)).'?pr_action=orders\'>View orders</a></li>';
	$_str .= '<li><a href=\''.get_permalink(get_page_by_path($pr_user_bands)).'\'>View my bands</a></li>';

	return '<ul>'.$_str.'</ul>';
}



function prf_user_properties()
{
global $user_ID,$pr_properties,$wpdb,$pr_slug,$_err_ids;

if(is_user_logged_in()) // user must be logged in to perform all these actions
{

//// AddUpdateProperty function called in pr_redirect
//	if (isset($_POST['_err_ids'])) {
//		$_err_ids = $_POST['_err_ids'];
//	}

	if (isset($_POST['AddUpdateProperty']) and isset($_POST['_err_ids']) != FALSE) {
		pr_m_($_POST['AddUpdateProperty'],'error','h3');
	}

	if (isset($_GET['prf_del_id']))

	{
		$_user_id = $wpdb->get_var($wpdb->prepare("SELECT user_id FROM $pr_properties WHERE ID = %d", $_GET['prf_del_id']));
		if ($_user_id==$user_ID)
		{
			pr_prop_delete($_GET['prf_del_id']);
		} else pr_m_('You don\'t have permission to delete this property','error','div');
	}
// show forms and properties

// switching between actions, then edit_ids and then between del_ids
	if(isset($_GET['pr_action']))
	{
		switch($_GET['pr_action'])
		{
			case "prf_add_sale":
				//if (!isset($_POST['band_to_buy'])) { // simple check whether user is buying a new band
					prf_sales_form();
				//}
			break;
			case "prf_add_let":
				//if (!isset($_POST['band_to_buy'])) { // simple check whether user is buying a new band
					prf_letting_form();
				//}
			break;
			case "prf_add_property":
				prf_add_prop_form();
			break;
			case "checkout":
				//prf_checkout();
				//prf_checkout_by_bands();
			break;
			case "orders":
				prf_show_user_orders();
			break;
			case "cancel_checkout":
				prf_cancel_checkout();
			break;
			case "finish_checkout":
				prf_finish_checkout();
			break;

		}
	}
	elseif(isset($_GET['prf_edit_id'])) //
		{
		// get type.......................
		$type = $wpdb->get_var($wpdb->prepare("SELECT property_type FROM $pr_properties WHERE ID = %d", $_GET['prf_edit_id']));
		$_user_id = $wpdb->get_var($wpdb->prepare("SELECT user_id FROM $pr_properties WHERE ID = %d", $_GET['prf_edit_id']));
		// perform user_id check
		if ($_user_id == $user_ID)
		{
		switch($type)
		{
			case 2://SALE

				prf_sales_form($_GET['prf_edit_id'],'edit');

			break;
			case 1://LET
				prf_letting_form($_GET['prf_edit_id'],'edit');
			break;
		}
		} else pr_m_('You don\'t have permission to edit this property','error','div');
		/**/
		//echo "under construction";
		}

		//elseif(isset($_GET['prf_del_id']))
			//{
				// prf_delete();
				//prf_prop_list();
        //echo "under construction";
			//}
	else {
		//prf_prop_list();//user's property list
		prf_properties_by_bands();
	}


} else pr_m_('Error! You must be logged in to view this page.','error','h3');

}

function prf_user_downloads()
{
	global $pr_upload_files,$pr_files_table,$pr_prefix,$pr_file_show_folder,$wpdb;

		pr_m_('Files to download','','h1');
	if(is_user_logged_in())
	{
		$id = 0;// this is a property ID which doesn't exist, it's for general files

		if($db_table_name==NULL)$db_table_name = $pr_files_table;
		if($field_name==NULL) $field_name = "file_name";
			$results = $wpdb->get_results($wpdb->prepare('SELECT ID,'.$field_name.',title FROM '.$db_table_name.' WHERE prid = %d',$id));
			?>
      <ul class="download-files">
      <?
      foreach($results as $uploaded)
			{
				?>
				<li class="uploaded_file <?echo pr_file_extension($uploaded->$field_name)?>">
				<?
        if ($uploaded->title != NULL)
          echo $uploaded->title;
            else echo $uploaded->$field_name;
        ?> (<?echo round(filesize($pr_upload_files.$uploaded->$field_name)/1024,0).'KB';?>) <a href="<?echo $pr_file_show_folder.$uploaded->$field_name;?>">download</a>
				</li>
				<?
			}
			?>
      </ul>
      <?
	} else pr_m_('You can\'t access this page','error','h3');
}
function prf_featured_gallery($show = 0)
{
	global $wpdb,$pr_properties,$pr_img_show_folder,$pr_pic_table,$pr_slug,$pr_plugin_images,$pr_default_img,$pr_upload_thumbs,$pr_img_show_folder_thumbs,$_featured_date_check,$pr_baskets;
	if ($show != 0)
	{
		$_limit = "LIMIT 0,$show";
	} $_limit = "";
	$_today = date('Y-m-d');
	$_results = $wpdb->get_results("
	SELECT
	ID
	from
	$pr_properties pr INNER JOIN $pr_baskets b

			ON pr.basketid=b.basketid
	WHERE extra_featured = 1
		AND '$_today' between b.startdate and b.enddate
		AND extra_active = 1
		AND approved = 1
		AND extra_active = 1
		AND b.active = 1
		AND $_featured_date_check
	ORDER BY date_updated DESC,
		ID DESC
		$_limit;");
//$wpdb->show_errors();
//$wpdb->print_error();
	if (count($_results) > 0)
	{
	?>


	<div id="featured">
				<h2>Featured properties</h2>
				<img src="<?echo $pr_plugin_images?>featured_previous.png" id="prev_image" class="disabled">
				<div id="featured_scrollable" class="scrollable">
					<div class="items">

	<?
	$_addr = get_permalink(get_page_by_path($pr_slug));
	foreach($_results as $featured)
	{
		$img_main_src = $wpdb->get_var("SELECT img_name FROM $pr_pic_table WHERE prid = $featured->ID AND main = 1 LIMIT 0,1");
		if ($img_main_src != NULL) {
			$img_src = $img_main_src;
		}
		else {
		$img_src = $wpdb->get_var("SELECT img_name FROM $pr_pic_table WHERE prid = $featured->ID LIMIT 0,1");

		}
		if(strlen($img_src)<5) $img_src = $pr_default_img;
?>
		<div><a href="<?echo $_addr.'?pr_id='.$featured->ID?>"><img alt="" src="<?
		if(file_exists($pr_upload_thumbs.$img_src))
		echo $pr_img_show_folder_thumbs.$img_src;
		else echo $pr_img_show_folder.$img_src;
		?>"></a></div>
<?
	}
	?>
					</div>
				</div>
				<img src="<?echo $pr_plugin_images?>featured_next.png" id="next_image">
				<div class="clear"></div>
			</div>
<script>
$(document).ready(function() {
	$('div#featured_scrollable').scrollable({
 	size: 3,
 	clickable: false,
 	prev: '#prev_image',
 	next: '#next_image'
 });
});
		</script>
	<?
	}
}
function prf_show_user_orders()
{
  global $wpdb,$pr_orders,$pr_properties,$pr_per_page,$pr_lettings_page,$pr_sales_page,$pr_order_details,$user_ID,$pr_user_properties_slug;

  if (isset($_GET['del_id'])) pr_order_delete($_GET['del_id']);
  $count = $wpdb->get_var("SELECT COUNT(ID) FROM $pr_orders WHERE user_id = $user_ID");
  pr_m_('My orders','','h1');
if ($count>0)
{
	// getting number of pages
if (isset($_GET['pr_page_id'])) $page_id = $_GET['pr_page_id'];
  else $page_id = 1;
// pages section

	$pages = bcdiv($count,$pr_per_page);
	if(bcmod($count,$pr_per_page) > 0) $pages++;
	$pagestring = "Pages ";

	for ($i = 1;$i <= $pages;$i++)
	{
		if ($page_id == $i)
		{
		$pagestring .= "<a class='selected' href=".get_permalink(get_page_by_path($pr_user_properties_slug))."?pr_action=".$_GET['pr_action']."&pr_page_id=".$i.">".$i."</a> ";
		} else {
		$pagestring .= "<a href=href=".get_permalink(get_page_by_path($pr_user_properties_slug))."?pr_action=".$_GET['pr_action']."&pr_page_id=".$i.">".$i."</a> ";
		}
	}
	// pages end
	$start = ($page_id-1)*$pr_per_page;//according to page we start our select from DB

  $orders = $wpdb->get_results("SELECT * FROM $pr_orders WHERE user_id = $user_ID ORDER BY date_issued ASC, date_completed ASC, ID ASC LIMIT $start,$pr_per_page");

  pr_m_($pagestring,'pagination','div');
  $_SESSION['current_user_id'] = $user_ID;// current user ID for pop up window security

  //pr_m_('','','p');

?>
<table class="widefat">
<thead>
<tr>
	<th class="manage-column column-title">#</th>
	<!--<th class="manage-column column-title">User</th>-->
	<th class="manage-column column-title">Total</th>
	<th class="manage-column column-title">Issued on</th>
	<th class="manage-column column-title">Transaction ID</th>
	<th class="manage-column column-title">Status</th>
	<th class="manage-column column-title">Details</th>
</tr>
</thead>
<tbody>
<?
  foreach($orders as $order)
  {
    ?>
    <tr>
      <td><?echo $order->ID?></td>
      <!--<td><?
    $user_info = get_userdata($order->user_id);
		echo "<a href='".get_bloginfo('url')."/wp-admin/user-edit.php?user_id=$order->user_id'>$user_info->user_login</a>";
      ?></td>-->

      <td>
      <?echo pr_price($order->total);?>
      </td>

      <td>

      <?
      echo $order->date_issued;
      ?>
      </td>

      <td>
      <?echo $order->transaction_id;
      if($order->transaction_id != NULL) echo "<br>".str_ireplace('pending', 'Complete', $order->status)." on $order->date_completed";?>
      </td>

      <td>
      <?echo str_ireplace('pending', 'Complete', $order->status);?>
      </td>

      <td>
      <a href="javascript:open_win('<?echo plugins_url('/order_details.php?order_id='.$order->ID, __FILE__)?>','Order_details', 800,600)">View</a>
	  <?
	  if($order->status == 'new')
	  {
		?>
		<a href="javascript:sureness('<?echo get_permalink($pr_user_properties_slug)?>?pr_action=orders&del_id=<?echo $order->ID?>')">Delete</a>
		<?

	  }
      /*
	  $details = $wpdb->get_results("SELECT * FROM $pr_order_details WHERE order_id = $order->ID");
      foreach($details as $det)
      {
        echo "$det->details - $det->price <br>";
      }
      */
	  ?>
      </td>
    </tr>
    <?
  }
?>
</tbody>
</table>
<?
pr_m_($pagestring,'pagination','div');
	}// END IF count>0
	else pr_m_('No orders found','','p');

}

function prf_tennants_update($user_id)
{
	global $wpdb,$pr_tennants_details;
	$descr = $wpdb->get_results("DESCRIBE $pr_tennants_details;");
	if (is_object($user_id)) { // variable which we get from admin page
		$user_id = $user_id->data->ID;
	}
	//$fields_list = "ID, user_id, ";
	//$fields_values = "NULL, $user_id, ";
	//$fields_values = "";
	$fields_values_arr = array();
	$prepare_fields = "";
$_err = false; // internal error
	foreach($descr as $k=>$field)
	{
		if($field->Field != 'ID' and $field->Field != 'user_id' and $field->Field != 'date_created' and $field->Field != 'date_updated')
		{
		if (isset($_POST[$field->Field]))
		{
			//$fields_list .= $field->Field.', ';
			if ($_POST[$field->Field] != NULL)
			{

			if (strpos($field->Type,'int') !== false)
			{
					$prepare_fields .= "$field->Field = %d, ";
					//$fields_values .= $_POST[$field->Field].', ';
					$fields_values_arr[] = $_POST[$field->Field];
			} elseif (strpos($field->Type,'tinyint') !== false)
			{
					$prepare_fields .= "$field->Field = %d, ";
					//$fields_values .= $_POST[$field->Field].', ';
					$fields_values_arr[] = $_POST[$field->Field];
			} elseif (strpos($field->Type,'text') !== false)
			{
					$prepare_fields .= "$field->Field = '%s', ";
					//$fields_values .= "'".$_POST[$field->Field]."', ";
					$fields_values_arr[] = $_POST[$field->Field];
			}
			elseif(strpos($field->Type,'mediumtext') !== false)
			{
					$prepare_fields .= "$field->Field = '%s', ";
					//$fields_values .= "'".$_POST[$field->Field]."', ";
					$fields_values_arr[] = $_POST[$field->Field];
			}
			elseif(strpos($field->Type,'longtext') !== false)
			{
					$prepare_fields .= "$field->Field = '%s', ";
					//$fields_values .= "'".$_POST[$field->Field]."', ";
					$fields_values_arr[] = $_POST[$field->Field];
			}
			elseif(strpos($field->Type,'char') !== false)
			{
					$prepare_fields .= "$field->Field = '%s', ";
					//$fields_values .= "'".$_POST[$field->Field]."', ";
					$fields_values_arr[] = $_POST[$field->Field];
			}
			elseif(strpos($field->Type,'varchar') !== false)
			{
					$prepare_fields .= "$field->Field = '%s', ";
					//$fields_values .= "'".$_POST[$field->Field]."', ";
					$fields_values_arr[] = $_POST[$field->Field];
			}
			elseif(strpos($field->Type,'date') !== false)
			{
					$prepare_fields .= "$field->Field = '%s', ";
					//$fields_values .= "'".$_POST[$field->Field]."', ";
					$fields_values_arr[] = pr_date_save($_POST[$field->Field]);
			}
			} else $prepare_fields .= "$field->Field = NULL, ";
		} else $_err = true;
		}
	}
	if($_err == false)
	{
	// fields list addition

	//$fields_list .= 'date_created, date_updated';
	//echo $fields_list;
	//echo "<br>";
	$date = date('Y-m-d  H:i:s');
	//$fields_values .= "'$date', '$date'";
	$prepare_fields .= "date_updated = '$date'";
	$fields_values_arr[] = $date;
	//$fields_values_arr[] = $date;
	//$prepare_fields .= "'%s', '%s'"; //dates
	//echo $fields_values;

	$query = "UPDATE $pr_tennants_details SET $prepare_fields WHERE user_id = $user_id;";
	//$fields_values = "NULL, $user_id, ".$fields_values;
	//$query = "INSERT INTO $pr_tennants_details ($fields_list) VALUES ($fields_values);";
	//echo $query;
	//echo $fields_values;
	$wpdb->query($wpdb->prepare($query,$fields_values_arr));
	//$wpdb->query($query);
	//$wpdb->show_errors();
	//$wpdb->print_error();
	} else pr_m_('Probably not all fields were filled correctly','error','h3');
}
function prf_tennants_insert($user_id)
{
	global $wpdb,$pr_tennants_details;
	$descr = $wpdb->get_results("DESCRIBE $pr_tennants_details;");
	$fields_list = "ID, user_id, ";
	//$fields_values = "NULL, $user_id, ";
	$fields_values = "";
	$fields_values_arr = array();
	$prepare_fields = "NULL, $user_id, ";

$_err = false; // internal error

	foreach($descr as $k=>$field)
	{
		if($field->Field != 'ID' and $field->Field != 'user_id' and $field->Field != 'date_created' and $field->Field != 'date_updated')
		{
		if (isset($_POST[$field->Field]))
		{
			$fields_list .= $field->Field.', ';
			if ($_POST[$field->Field] != NULL)
			{

			if (strpos($field->Type,'int') !== false)
			{
					$prepare_fields .= "%d, ";
					$fields_values .= $_POST[$field->Field].', ';
					$fields_values_arr[] = $_POST[$field->Field];
			} elseif (strpos($field->Type,'tinyint') !== false)
			{
					$prepare_fields .= "%d, ";
					$fields_values .= $_POST[$field->Field].', ';
					$fields_values_arr[] = $_POST[$field->Field];
			} elseif (strpos($field->Type,'text') !== false)
			{
					$prepare_fields .= "'%s', ";
					$fields_values .= "'".$_POST[$field->Field]."', ";
					$fields_values_arr[] = $_POST[$field->Field];
			}
			elseif(strpos($field->Type,'mediumtext') !== false)
			{
					$prepare_fields .= "'%s', ";
					$fields_values .= "'".$_POST[$field->Field]."', ";
					$fields_values_arr[] = $_POST[$field->Field];
			}
			elseif(strpos($field->Type,'longtext') !== false)
			{
					$prepare_fields .= "'%s', ";
					$fields_values .= "'".$_POST[$field->Field]."', ";
					$fields_values_arr[] = $_POST[$field->Field];
			}
			elseif(strpos($field->Type,'char') !== false)
			{
					$prepare_fields .= "'%s', ";
					$fields_values .= "'".$_POST[$field->Field]."', ";
					$fields_values_arr[] = $_POST[$field->Field];
			}
			elseif(strpos($field->Type,'varchar') !== false)
			{
					$prepare_fields .= "'%s', ";
					$fields_values .= "'".$_POST[$field->Field]."', ";
					$fields_values_arr[] = $_POST[$field->Field];
			}
			elseif(strpos($field->Type,'date') !== false)
			{
					$prepare_fields .= "'%s', ";
					$fields_values .= "'".$_POST[$field->Field]."', ";
					$fields_values_arr[] = pr_date_save($_POST[$field->Field]);
			}
			} else $prepare_fields .= "NULL, ";
		} else $_err = true;
		}
	}
	if($_err == false)
	{
	// fields list addition
	$fields_list .= 'date_created, date_updated';
	//echo $fields_list;
	//echo "<br>";
	$date = date('Y-m-d H:i:s');
	$fields_values .= "'$date', '$date'";
	$fields_values_arr[] = $date;
	$fields_values_arr[] = $date;
	$prepare_fields .= "'%s', '%s'"; //dates

	//echo $fields_values;

	$query = "INSERT INTO $pr_tennants_details ($fields_list) VALUES ($prepare_fields);";
	//$fields_values = "NULL, $user_id, ".$fields_values;
	//$query = "INSERT INTO $pr_tennants_details ($fields_list) VALUES ($fields_values);";
	//echo $query;
	//echo $fields_values;
	$wpdb->query($wpdb->prepare($query,$fields_values_arr));
	//$wpdb->query($query);
	//$wpdb->show_errors();
	//$wpdb->print_error();
	} else pr_m_('Probably not all fields were filled correctly','error','h3');
}
function prf_tennants_submit($user_id){
	global $wpdb,$pr_tennants_details;
	if (is_object($user_id)) { // variable which we get from admin page
		$user_id = $user_id->data->ID;
	}
	$_err = false;
	if (strlen($_POST['bank_sortcode'][0])==2 and strlen($_POST['bank_sortcode'][1])==2 and strlen($_POST['bank_sortcode'][2])==2 )
		$_POST['bank_sortcode'] = $_POST['bank_sortcode'][0].'/'.$_POST['bank_sortcode'][1].'/'.$_POST['bank_sortcode'][2];
	else {$_err = true;pr_m_('<a href=\'#bank\'>Wrong sort code in bank account section</a>','error','h3');}

	if(!preg_match("/^([a-zA-Z0-9])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/",$_POST['personal_email']))
	{$_err = true;pr_m_('<a href=\'#personal\'>Tennant\'s email address is incorrect</a>','error','h3');}
	if(!preg_match("/^([a-zA-Z0-9])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/",$_POST['landlord_email']))
	{$_err = true;pr_m_('<a href=\'#landlord\'>Landord\'s email address is incorrect</a>','error','h3');}



	if ($_err == false)
	{
		if(isset($_POST['declaration']))

		{

			$details = $wpdb->get_results("SELECT user_id FROM $pr_tennants_details where user_id = $user_id");

			if (sizeof($details)>0) // there is an entry for this user_ID, so we just update it
			{
				prf_tennants_update($user_id);
			} else // no previous entries for this user_ID

			{
				prf_tennants_insert($user_id);
			}

		} else pr_m_('<a href=\'#declaration\'>You need to accept terms and conditions</a>','error','h3');
	}
}

function prf_tennants_form($user_id = false)
{
//print_r($user_id->data->ID);
	global $wpdb,$pr_tennants_details,$user_ID;
if (is_object($user_id)) { // variable which we get from admin page
	$user_id = $user_id->data->ID;
}

	if(isset($_POST['submit']))
	{
prf_tennants_submit($user_id);
	}
	$details = $wpdb->get_results("SELECT * FROM $pr_tennants_details where user_id = $user_id");
if (!is_admin()) pr_edit_subform("form_start");
	$descr = $wpdb->get_results("DESCRIBE $pr_tennants_details;");
	//print_r($descr);
	$main_labels = array(
	'u_name' => 'Name ',
	'address' => 'Address ',
	'telephone' => 'Telephone number(s) ',
	'birthdate' => 'Date of birth ',
	'insurance' => 'National Insurance number ',
	'personal_email' => 'Email ',
	'status' => 'Status ',
	'type' => 'Type',
	'credit' => 'Have you ever had any adverse credit history?(if yes please give details separately)',
	'pastaddr' => 'Address(es) for past three years where different from above ',
	'pastperiod' => 'Period at this address(es)',
	'employment' => 'Employment status ',
	'employer' => 'Employer / College name ',
	'position' => 'Position held/ Course attending',
	'salary' => 'Current sallary ',
	'employer_addr' => 'Employer / College address',
	'rent_responsible' => 'Who would be responsible for the rent',
	'employer_tel' => 'Employer telephone number(s)',
	'accountant_name' => 'Name',
	'accountant_addr' => 'Address ',
	'accountant_tel' => 'Telephone number(s) ',
	'landlord_name' => 'Name ',
	'landlord_addr' => 'Name',
	'landlord_email' => 'Email ',
	'landlord_tel' => 'Telephone number(s) ',
	'bank_addr' => 'Bank/Building Society address ',
	'bank_sortcode' => 'Sort Code ',
	'bank_acc_name' => 'Account name ',
	'bank_acc_number' => 'Account number',
	'ref_name' => 'Name',
	'ref_addr' => 'Address ',
	'ref_tel' => 'Telephone number(s)',
	'ref_qual' => 'Qualifications (if any) ',
	'rel_relation' => 'Relationship ',
	'other_children' => 'Children ',
	'other_pets' => 'Pets ',
	'other_other' => 'Other ',
	'declaration' => 'I declare that the information given above is true, to the best of my knowledge and belief.<br>I authorise you to obtain any relevant information from any of the above and hereby auyhorise any of the above to release such relevant information.'
	);
if (is_admin()) {
?>
<!-- WTZ properties scripting -->
<script src="<?bloginfo('template_url'); ?>/js/jquery.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="<?bloginfo('url')?>/wp-content/plugins/properties/somescripting.js"></script>
<script src="http://cdn.jquerytools.org/1.2.5/full/jquery.tools.min.js"></script>
<link rel="Stylesheet" href="<?bloginfo('url')?>/wp-content/plugins/properties/dateinput.css" type="text/css" />
<?
		pr_m_('Tennant\'s details', NULL, 'h3');
		pr_print_button_forms($user_id,'Details','user_id','/print_tennants_details.php?','Print details');
	}
	foreach($descr as $_descr)
	{
	if(sizeof($details)>0) { $_A = $_descr->Field; $form_value = $details[0]->$_A;}
		elseif(isset($_POST[$_descr->Field]) and $_POST[$_descr->Field] != '') $form_value = $_POST[$_descr->Field];
		else $form_value = NULL;
		//echo $_descr->Field.' '.$_descr->Type.'<br>';
		if($_descr->Field != 'ID' and $_descr->Field != 'user_id' and $_descr->Field != 'date_created' and $_descr->Field != 'date_updated')
		{

			switch ($_descr->Field) // this switch creates boxes around groups of fields according to field topic
			{
				case "u_name":
					echo "<div class=\"topic_block\">";
					pr_m_('<a name=\'personal\'>Personal details</a>','topic_title','h3');
				break;
				case "employment":
					echo "<div class=\"topic_block\">";
					pr_m_('<a name=\'employment\'>College/Employment Details</a>','topic_title','h3');
				break;
				case "accountant_name":
					echo "<div class=\"topic_block\">";
					pr_m_('<a name=\'accountant\'>Accountant Details</a>','topic_title','h3');
				break;
				case "landlord_name":
					echo "<div class=\"topic_block\">";
					pr_m_('<a name=\'landlord\'>Current Landlord/Agent Details</a>','topic_title','h3');
				break;
				case "bank_addr":
					echo "<div class=\"topic_block\">";
					pr_m_('<a name=\'bank\'>Bank/Building Society Details (current account)</a>','topic_title','h3');
				break;
				case "ref_name":
					echo "<div class=\"topic_block\">";
					pr_m_('<a name=\'reference\'>Personal Reference / Guarantors Details</a>','topic_title','h3');
				break;
				case "other_children":
					echo "<div class=\"topic_block\">";
					pr_m_('<a name=\'other\'>Other Relevant Details</a>','topic_title','h3');
				break;
				case "declaration":
					echo "<div class=\"topic_block\">";
					pr_m_('<a name=\'declaration\'>Declaration</a>','topic_title','h3');
				break;

			}
			echo '<p>';
			if ($_descr->Field != 'declaration') echo "<label for=\"$_descr->Field\">".$main_labels[$_descr->Field]."</label><br>";
			if($_descr->Field == 'bank_sortcode')
			{
				pr_edit_subform('bank_sortcode',$_descr->Field,NULL,$_descr->Field,$form_value);
			}
			else
			{
			if(strpos($_descr->Type,'text') !== false)
			{
				pr_edit_subform('textarea',$_descr->Field,NULL,$_descr->Field,$form_value);
			} elseif (strpos($_descr->Type,'tinyint') !== false)
				{
				switch($_descr->Field)
				{
					case "status":
					//$fields =
					$labels = array('Single', 'Married', 'Divorced', 'Separated');
					pr_edit_subform("radiogroup",NULL,NULL,$_descr->Field,$form_value,4,NULL,$labels);
					break;
					case "type":
					$labels = array('House owner', 'Private tenant', 'Living with parents', 'Council tenant');
					pr_edit_subform("radiogroup",NULL,NULL,$_descr->Field,$form_value,count($labels),NULL,$labels);
					break;
					case "credit":
					$labels = array('yes','no');
					pr_edit_subform("radiogroup",NULL,NULL,$_descr->Field,$form_value,count($labels),NULL,$labels);

					break;
					case "employment":
					$labels = array('Employed', 'Unemployed', 'Self-employed', 'Retired', 'Student');
					pr_edit_subform("radiogroup",NULL,NULL,$_descr->Field,$form_value,count($labels),NULL,$labels);
					break;

					case "declaration":
					//$labels = array('Employed', 'Unemployed', 'Self-employed', 'Retired', 'Student');
					pr_edit_subform("checkbox",NULL,NULL,$_descr->Field,$form_value);
					break;

				}
				}
				elseif ($_descr->Field=='birthdate') {
					if($form_value!=NULL and $form_value != '0000-00-00') {
						$_date = pr_date_show($form_value);
					} else $_date = '';
					//pr_edit_subform('text_input',$_descr->Field,NULL,$_descr->Field,$_date);
?>
<input type="text" min="1900-09-01" value="<?echo $_date?>" name="<?echo $_descr->Field?>" id="<?echo $_descr->Field?>">
<?
						$_dates = array($form_value);

						pr_dateinput('input#'.$_descr->Field,$_dates,"-3650000",'10','[-100, 0]');
/*
   ?><script type="text/javascript">
   $(document).ready(function() {
   $('input#<?echo $_descr->Field?>').datepicker({ dateFormat: 'yy-mm-dd' });
   });

   </script>
   <?
*/
				}
				else {
					pr_edit_subform('text_input',$_descr->Field,NULL,$_descr->Field,$form_value);
				}
			}
			if ($_descr->Field == 'declaration') echo "<label for=\"$_descr->Field\">".$main_labels[$_descr->Field]."</label>";
			echo '</p>';
			// end of box
			switch ($_descr->Field) // this switch creates boxes around groups of fields according to field topic
			{
				case "pastperiod":
					echo "</div>";
				break;
				case "employer_tel":
					echo "</div>";
				break;
				case "accountant_tel":
					echo "</div>";
				break;
				case "landlord_tel":
					echo "</div>";
				break;
				case "bank_acc_number":
					echo "</div>";
				break;
				case "rel_relation":
					echo "</div>";
				break;
				case "other_other":
					echo "</div>";
				break;
				case "declaration":
					echo "</div>";
				break;

			}
		}
	}
if (!is_admin())
{
	pr_edit_subform("submit");
	pr_edit_subform("form_end");
} else {

}

}
function prf_tennants_print($user_id = false)
{
//print_r($user_id->data->ID);
global $wpdb,$pr_tennants_details,$user_ID;

if (is_object($user_id)) { // variablem which we get from admin page
	$user_id = $user_id->data->ID;
}

$details = $wpdb->get_results("SELECT * FROM $pr_tennants_details where user_id = $user_id");
if (!is_admin()) pr_edit_subform("form_start");
$descr = $wpdb->get_results("DESCRIBE $pr_tennants_details;");
//print_r($descr);
$main_labels = array(
'u_name' => 'Name ',
'address' => 'Address ',
'telephone' => 'Telephone number(s) ',
'birthdate' => 'Date of birth ',
'insurance' => 'National Insurance number ',
'personal_email' => 'Email ',
'status' => 'Status ',
'type' => 'Type',
'credit' => 'Have you ever had any adverse credit history?(if yes please give details separately)',
'pastaddr' => 'Address(es) for past three years where different from above ',
'pastperiod' => 'Period at this address(es)',
'employment' => 'Employment status ',
'employer' => 'Employer / College name ',
'position' => 'Position held/ Course attending',
'salary' => 'Current sallary ',
'employer_addr' => 'Employer / College address',
'rent_responsible' => 'Who would be responsible for the rent',
'employer_tel' => 'Employer telephone number(s)',
'accountant_name' => 'Name',
'accountant_addr' => 'Address ',
'accountant_tel' => 'Telephone number(s) ',
'landlord_name' => 'Name ',
'landlord_addr' => 'Name',
'landlord_email' => 'Email ',
'landlord_tel' => 'Telephone number(s) ',
'bank_addr' => 'Bank/Building Society address ',
'bank_sortcode' => 'Sort Code ',
'bank_acc_name' => 'Account name ',
'bank_acc_number' => 'Account number',
'ref_name' => 'Name',
'ref_addr' => 'Address ',
'ref_tel' => 'Telephone number(s)',
'ref_qual' => 'Qualifications (if any) ',
'rel_relation' => 'Relationship ',
'other_children' => 'Children ',
'other_pets' => 'Pets ',
'other_other' => 'Other ',
'declaration' => 'I declare that the information given above is true, to the best of my knowledge and belief.<br>I authorise you to obtain any relevant information from any of the above and hereby auyhorise any of the above to release such relevant information.'
);

	pr_m_('Tennant\'s details', NULL, 'h3');
	pr_print_button();
foreach($descr as $_descr)
{
if(sizeof($details)>0) { $_A = $_descr->Field; $form_value = $details[0]->$_A;}
elseif(isset($_POST[$_descr->Field]) and $_POST[$_descr->Field] != '') $form_value = $_POST[$_descr->Field];
else $form_value = NULL;
//echo $_descr->Field.' '.$_descr->Type.'<br>';
if($_descr->Field != 'ID' and $_descr->Field != 'user_id' and $_descr->Field != 'date_created' and $_descr->Field != 'date_updated')
{

echo '<p>';
if ($_descr->Field != 'declaration') echo "<label for=\"$_descr->Field\">".$main_labels[$_descr->Field]."</label><br>";
if($_descr->Field == 'bank_sortcode')
{
	echo $form_value;
}
else
{
if(strpos($_descr->Type,'text') !== false)
{
	echo $form_value;
} elseif (strpos($_descr->Type,'tinyint') !== false)
{
	switch($_descr->Field)
	{
		case "status":
			//$fields =
			$labels = array('Single', 'Married', 'Divorced', 'Separated');
			echo $labels[$form_value];
			break;
		case "type":
			$labels = array('House owner', 'Private tenant', 'Living with parents', 'Council tenant');
			echo $labels[$form_value];
			break;
		case "credit":
			$labels = array('yes','no');
			echo $labels[$form_value];
			break;
		case "employment":
			$labels = array('Employed', 'Unemployed', 'Self-employed', 'Retired', 'Student');
			echo $labels[$form_value];
			break;

		case "declaration":
			//$labels = array('Employed', 'Unemployed', 'Self-employed', 'Retired', 'Student');
			pr_edit_subform("checkbox",NULL,NULL,$_descr->Field,$form_value);
			break;

	}
}
else {echo $form_value;

if ($_descr->Field=='birthdate')
{
	pr_date_show($form_value);

}

}
}
if ($_descr->Field == 'declaration') echo "<label for=\"$_descr->Field\">".$main_labels[$_descr->Field]."</label>";
echo '</p>';
// end of box
switch ($_descr->Field) // this switch creates boxes around groups of fields according to field topic
{
	case "pastperiod":
		echo "</div>";
		break;
	case "employer_tel":
		echo "</div>";
		break;
	case "accountant_tel":
		echo "</div>";
		break;
	case "landlord_tel":
		echo "</div>";
		break;
	case "bank_acc_number":
		echo "</div>";
		break;
	case "rel_relation":
		echo "</div>";
		break;
	case "other_other":
		echo "</div>";
		break;
	case "declaration":
		echo "</div>";
		break;

}
}
}

}

function prf_basket()
{
/*
global $user_ID,$pr_properties,$pr_areas,$exclude_areas,$pr_user_properties_slug,$wpdb;
	// huge check whether property is in exclusion area like UK(I made an array, so we possibly can create more than one).
	// This check also uses pr_check_parent from funcs.php
	$_str = '';
	$_unpaid = $wpdb->get_var("SELECT COUNT(ID) FROM $pr_properties WHERE paid = 0 AND user_id = $user_ID AND property_type = 2;"); // ���� �� ������ ������������ ������������
	if ($_unpaid>0)
	{
		// ���� ������������
		$_excl_area = $exclude_areas;// ��������� ���� �� �� ��������� ������������
		foreach ($_excl_area as $area)
		{
			$_excl_arid[] = $wpdb->get_var("SELECT ID FROM $pr_areas WHERE name = '$area'");// �������� �� ��� ����������� ���
		}

		$_unpaid = $wpdb->get_results("SELECT ID,area FROM $pr_properties WHERE paid = 0 AND user_id = $user_ID AND property_type = 2;"); // �������� ��� �� ��� ��� ������������

		foreach($_unpaid as $prop)
		{
			if(!in_array($prop->area,$_excl_arid) and pr_check_parent($prop->area,$_excl_arid)==false)
				{
					$_un_prop_ids[] = $prop->ID;
				}
		}

	if(isset($_un_prop_ids) and sizeof($_un_prop_ids)>0)
	{
		$_str .= '<div class="basket"><a href=\''.get_permalink(get_page_by_path($pr_user_properties_slug)).'?pr_action=checkout\'>Checkout</a> ('.sizeof($_un_prop_ids).')</div>';
	}

	}
echo $_str;
*/
}

function prf_tennants_details()
{
	global $pr_tennants_details,$user_ID;
	pr_m_('Tennant\'s details','','h3');
	prf_tennants_form($user_ID);
	pr_m_('Under construction','','p');
}

function prf_last_posts($cat,$num = 10,$content = true)
{

$args = array(
		'numberposts' => $num,
		'orderby' => 'date',
		'order' => 'DESC',
		'category_name' => $cat
	);
	$lastposts = get_posts($args);
	if ($lastposts) {
	echo "
	<div class=\"scrolling_news\">
	<ul class=\"featured\" id=\"featured_news\">";
	//echo "<p>".$cat."</p>";

		foreach ($lastposts as $post) {
		setup_postdata($post);
		?>
		<li>
		<?

		if ($content == false)
		{?>

		<p><a href="<? echo get_permalink($post->ID);?>"><? echo $post->post_title;?></a></p>
		<?
		} else
		  {
      //$cat = get_category(get_category_by_slug($cat));
			echo "<div><h3><a href=\"".get_permalink($post->ID)."\">$post->post_title</a></h3><p>".chopsentences($post->post_excerpt,8)."</p><span><a href=\"".get_permalink($post->ID)."\">Read more</a></span></div>";
		}
		?>
		</li>
		<?
		}

	echo "</ul>
	</div>
	";
	?>
	<script type="text/javascript" src="<?echo plugins_url('properties/jquery.vticker-min.js','properties');?>"></script>
	<script type="text/javascript" src="<?echo plugins_url('properties/jquery.liscroller.js','properties');?>"></script>
	<script>
$('.scrolling_news').find('div').css('display','block').height(120);


$('.scrolling_news').vTicker({
speed: 1500,
pause: 6000,
showItems: 1,
animation: 'fade',
mousePause: true,
height: 120,
direction: 'up'
});

/*
	$(function(){ $("ul#featured_news").liScroll({travelocity: 0.15}); });
*/
	</script>
	<?
	}
}
function prf_cancel_checkout(){
	pr_m_('Order payment status','attention','h2');
	pr_m_('Your order wasn\'t payed. You\'ll need to try it to do once again when editing or adding property.','','p');
}
function prf_finish_checkout(){
	//prb_band_bought();
	pr_m_('Payment verification','','h2');
	prf_make_payment();
}
function prf_properties_by_bands(){
global $wpdb,$pr_areas,$pr_properties,$pr_area_types,$pr_per_page,$user_ID,$pr_user_properties_slug,$pr_slug,$pr_baskets;
if (isset($_GET['pr_page_id'])) $pr_page_id = $_GET['pr_page_id'];
else $pr_page_id = 1;

$count = $wpdb->get_var("SELECT COUNT(ID) FROM $pr_properties WHERE user_id = $user_ID");
//$wpdb->show_errors();
//$wpdb->print_error();
// getting number of pages
pr_m_('My properties','','h1');
if ($count>0)
{
$pages = bcdiv($count,$pr_per_page);
if(bcmod($count,$pr_per_page) > 0) $pages++;
$pagestring = "Pages ";
/**/
	for ($i = 1;$i <= $pages;$i++)
	{

		if ($pr_page_id == $i)
		{
			$pagestring .= "<a class='selected' href=".get_permalink(get_page_by_path($pr_user_properties_slug))."?pr_action=".$_GET['pr_action']."&pr_page_id=".$i.">".$i."</a> ";
		} else {
			$pagestring .= "<a href=".get_permalink(get_page_by_path($pr_user_properties_slug))."?pr_action=".$_GET['pr_action']."&pr_page_id=".$i.">".$i."</a> ";
		}
	}

	$start = ($pr_page_id-1)*$pr_per_page;//according to page we start our select from DB
//we get data from DB according to type of properties
$results = $wpdb->get_results("
	SELECT
	pr.ID,
	IF (pr.property_type=2,pr.sale_price,pr.let_weekrent) as price,
	a.name as area,
	pr.property_type as type,
	IF(pr.extra_active=0,'No','Yes') as active,
	IF(pr.approved=0,'No','Yes') as approved,
	a.ID as area_id,
	pr.paid,
	pr.basketid,
	IF(pr.basketid=0,'N/A',b.bandname) as basket_name,
	IF(pr.basketid=0,'N/A',b.price) as basket_price,
	IF(pr.basketid=0,'N/A',b.startdate) as basket_startdate,
	IF(pr.basketid=0,'N/A',b.enddate) as basket_enddate
	FROM $pr_properties pr LEFT JOIN $pr_areas a
		ON pr.area = a.ID LEFT JOIN $pr_baskets b
		ON pr.basketid = b.basketid
	WHERE user_id = $user_ID
	ORDER BY price ".$_SESSION['sort_by_price'].",
		pr.ID ASC
		LIMIT $start,$pr_per_page;");

//$wpdb->show_errors();
//$wpdb->print_error();
if ($pages > 1) pr_m_($pagestring,"pagination","div");
?>
<?
pr_edit_subform('price_sort_form');
?>
<table class="widefat">
<thead>
<tr>
	<th class="manage-column column-title">#</th>
	<th class="manage-column column-title">Price</th>
	<th class="manage-column column-title">Information</th>
	<th class="manage-column column-title">Type</th>
	<th class="manage-column column-title">Action</th>
</tr>
</thead>
<tbody>
	<?
	foreach ($results as $prop)
	{
	?>
	<tr>
		<td>
		<a name="<?echo $prop->ID;?>"><?echo $prop->ID;?></a>
		</td>
		<td>
		<?echo pr_price($prop->price);?>
		</td>
		<td>
		<p>
			<a href="<?echo get_permalink(get_page_by_path($pr_slug)).'?pr_id='.$prop->ID;?>">
			<?
			echo pr_get_prop_address($prop->ID);
			?>
			</a>
		</p>
		<p>
			Band:<?echo $prop->basket_name?>
			<?
			if ($prop->basketid != 0) {
				?><br>
			Period: <?echo $prop->basket_startdate.'/'.$prop->basket_enddate?><br>
			Price: <? pr_price($prop->basket_price,true)?>
				<?
			}
			?>
		</p>
		</td>
		<td>

		<?
		switch($prop->type)
		{
			case 1: echo "Let";break;
			case 2: echo "Sale";break;
		}?>
		</td>
		<td>
		<a href="javascript:sureness('<?echo get_permalink(get_page_by_path($pr_user_properties_slug))?>?prf_del_id=<?echo $prop->ID?>')">Delete</a>
		<a href="<?echo get_permalink(get_page_by_path($pr_user_properties_slug))?>?prf_edit_id=<?echo $prop->ID?>">Edit</a>
		</td>
		<?
		/*
		   ?>
		   <td>
		   <?
		   switch($prop->type)
		   {
		   case 1: echo 'n/a';break;
		   case 2:
		   $root_parent = pr_get_area_parents($prop->area_id);
		   if ($root_parent['name'] != 'United Kingdom')
		   {
		   if ($prop->paid == 1) echo 'yes'; else echo 'no';
		   } else echo 'n/a';
		   //if ()// �������� ����� ������ ��� ������ area
		   //echo "Sale";
		   break;
		   }
		   ?>
		   </td>
		   <?
		*/
		?>
	</tr>
	<?
}
?>
</tbody>
</table>
<?
if ($pages > 1) pr_m_($pagestring,"pagination","div");

} else pr_m_('No properties found','notice','p');

}
function prf_area_select_form($area_id){
	if ($_POST['band_area']==0) {
		// international areas
		$_GET['exclude'] = 222;
	}
	$_include_parent = 222;
	$_include_areas = array();
	pr_find_children($_include_parent, &$_include_areas);
	//print_r($_include_areas);
	$_include_areas = implode(', ',$_include_areas);
	$_include_areas .= ', '.$_include_parent;
	pr_edit_subform("areas_front",$area_id,NULL,'pr_area',NULL, NULL, $_include_areas);
}
?>