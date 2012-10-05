<?php
	
function widget_quicksearch($args)
{global $pr_slug,$pr_user_downloads_slug,$pr_user_properties_slug,$pr_tennant_slug;
          extract($args);
		  
?>
<script type="text/javascript">
			/*
			$(document).ready(function() {
				$('div#quicksearch input[type="radio"]').click(function(e) {
					$.post(
						'/get-maximum-price-list',
						{ 'type': e.target.value, 'currentMinValue': 0 },
						function(data) {
							$('div#quicksearch select#maximumprice').html(data);
						});

					$.post(
						'/get-minimum-price-list',
						{ 'type': e.target.value },
						function(data) {
							$('div#quicksearch select#minimumprice').html(data);
						});

					var label = $('label[for="minimumprice"]');

					switch (e.target.value) {
						case 'sale':
							label.html('Price range');
							break;

						default:
							label.html('Rent per week range');
							break;
					}
				});

				$('div#register input[type="radio"]').click(function(e) {
					$.post(
						'/get-maximum-price-list',
						{ 'type': e.target.value, 'currentMinValue': 0 },
						function(data) {
							$('div#register select#Member_MaximumPrice').html(data);
						});
				});

				$('div#quicksearch select#minimumprice').change(function(e) {
					var value = $(e.target).val();

					var type = $('input[name="type"]:checked').val();

					$.post(
						'/get-maximum-price-list',
						{ 'type': type, 'currentMinValue': value },
						function(data) {
							$('div#quicksearch select#maximumprice').html(data);
						});
				});
			});
			*/
		</script>

<div id="quicksearch">
<?if (function_exists('wpmem_inc_memberlinks')) // this is function in WP-memebers module
{
if ((is_page('my-account') or is_page($pr_user_properties_slug) or is_page($pr_user_downloads_slug) or is_page($pr_tennant_slug)) and is_user_logged_in()){ 
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
<option value="<?echo $_val;?>" <?if (isset($_GET['minimumprice']) and $_GET['minimumprice']==$_val) echo "selected"?>>&pound;<?echo $_val;?></option>
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
<option value="<?echo $_val;?>" <?if (isset($_GET['maximumprice']) and $_GET['maximumprice']==$_val) echo "selected"?>>&pound;<?echo $_val;?></option>
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
<option value="<?echo $_val;?>" <?if (isset($_GET['minimumprice']) and $_GET['minimumprice']==$_val) echo "selected"?>>&pound;<?echo $_val;?></option>
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
<option value="<?echo $_val;?>" <?if (isset($_GET['maximumprice']) and $_GET['maximumprice']==$_val) echo "selected"?>>&pound;<?echo $_val;?></option>
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
pr_edit_subform("areas_front",$_area_sel,NULL,'pr_area',NULL);?>
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
{global $wpdb,$pr_areas,$pr_properties,$pr_area_types,$pr_prop_types,$pr_pic_table,$pr_per_page,$pr_slug,$pr_img_show_folder,$pr_default_img,$pr_upload_thumbs,$pr_img_show_folder_thumbs;
// global $ID_arr;
	// условие area = ID сипользуем в последующих запросах, сейчас надо получить все ID детей прямых детей записи с area = ID
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
  switch($type)
	{
		case 1:
		$count = $wpdb->get_var("
		SELECT COUNT(pr.ID) 
		FROM $pr_properties pr LEFT JOIN $pr_areas a 
			ON pr.area = a.ID 
		WHERE pr.area IN ($ids) 
			AND a.active = 1 
			AND pr.property_type = $type 
			AND pr.let_weekrent <= $max_price 
			AND pr.let_weekrent >= $min_price 
			AND pr.bedroomnum >= $bedrooms 
			AND pr.extra_active = 1 
			AND pr.approved = 1 
			AND $_lettings_date_check");
		break;
		case 2:
		$count = $wpdb->get_var("
		SELECT COUNT(pr.ID) 
		FROM $pr_properties pr LEFT JOIN $pr_areas a 
			ON pr.area = a.ID 
		WHERE pr.area IN ($ids) 
			AND a.active = 1 
			AND pr.property_type = $type 
			AND pr.sale_price <= $max_price 
			AND pr.sale_price >= $min_price 
			AND pr.bedroomnum >= $bedrooms 
			AND pr.extra_active = 1 
			AND pr.approved = 1 
			AND $_sales_date_check");
		break;
		case "all":/// idiotic quick fix idea ot show all properties together
		$count = $wpdb->get_var("
		SELECT COUNT(pr.ID) 
		FROM $pr_properties pr LEFT JOIN $pr_areas a 
			ON pr.area = a.ID 
		WHERE pr.area IN ($ids) 
			AND a.active = 1 
			AND pr.property_type = 1 
			AND pr.let_weekrent <= $max_price 
			AND pr.let_weekrent >= $min_price 
			AND pr.bedroomnum >= $bedrooms 
			AND pr.extra_active = 1 
			AND pr.approved = 1 
			AND $_lettings_date_check") 
			+ 
			$wpdb->get_var("
		SELECT COUNT(pr.ID) 
		FROM $pr_properties pr LEFT JOIN $pr_areas a 
			ON pr.area = a.ID 
		WHERE pr.area IN ($ids) 
			AND a.active = 1 
			AND pr.property_type = 2 
			AND pr.sale_price <= $max_price 
			AND pr.sale_price >= $min_price 
			AND pr.bedroomnum >= $bedrooms 
			AND pr.extra_active = 1 
			AND pr.approved = 1 
			AND $_sales_date_check");
		break;
	}

if ($count!=0) {

	$pages = bcdiv($count,$pr_per_page);
if ($pages > 1)	 {
	if(bcmod($count,$pr_per_page) > 0) $pages++;
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
			SELECT pr.ID, pr.property_type, pr.let_weekrent as price, pr.addr_door_number as door_number, pr.addr_street as street, pr.addr_postcode as postcode, a.name as area, pt.Name as pr_type, pr.descr, pr.bedroomnum, pr.extra_status 
			FROM $pr_properties pr LEFT JOIN $pr_areas a 
			ON pr.area = a.ID LEFT JOIN $pr_prop_types pt 
				ON pr.type = pt.ID 
			WHERE pr.area iN ($ids) 
				AND a.active = 1 
				AND pr.property_type = $type 
				AND pr.let_weekrent <= $max_price 
				AND pr.let_weekrent >= $min_price 
				AND bedroomnum >= $bedrooms  
				AND pr.extra_active = 1 
				AND pr.approved = 1 
				AND $_lettings_date_check 
			ORDER BY pr.date_updated DESC, pr.date_created DESC, pr.ID DESC 
			LIMIT $start,$pr_per_page;");
		break;
		case 2://SALE
			$name = 'sales';
			$results = $wpdb->get_results("
			SELECT pr.ID, pr.property_type, pr.type, pr.sale_price as price, pr.addr_door_number as door_number, pr.addr_street as street, pr.addr_postcode as postcode, a.name as area, pt.Name as pr_type, pr.descr, pr.bedroomnum, pr.extra_status 
			FROM $pr_properties pr LEFT JOIN $pr_areas a 
			ON pr.area = a.ID LEFT JOIN $pr_prop_types pt 
				ON pr.type = pt.ID 
			WHERE pr.area iN ($ids) 
				AND a.active = 1 
				AND pr.property_type = $type 
				AND pr.sale_price <= $max_price 
				AND pr.sale_price >= $min_price 
				AND pr.bedroomnum >= $bedrooms  
				AND pr.extra_active = 1 
				AND pr.approved = 1 
				AND $_sales_date_check 
			ORDER BY pr.date_updated DESC, pr.date_created DESC, pr.ID DESC 
			LIMIT $start,$pr_per_page;");			
		break;
		case "all": /// idiotic quick fix idea again
		$name = 'sales and lettings';
		$_ids = array_merge($wpdb->get_results("
			SELECT pr.ID 
			FROM $pr_properties pr LEFT JOIN $pr_areas a 
			ON pr.area = a.ID LEFT JOIN $pr_prop_types pt 
				ON pr.type = pt.ID 
			WHERE pr.area iN ($ids) 
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
				ON pr.type = pt.ID 
			WHERE pr.area iN ($ids) 
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
			pr.addr_door_number as door_number, 
			pr.addr_street as street, 
			pr.addr_postcode as postcode, 
			a.name as area, 
			pt.Name as pr_type, 
			pr.descr, 
			pr.bedroomnum, 
			pr.extra_status 
			FROM $pr_properties pr LEFT JOIN $pr_areas a 
			ON pr.area = a.ID LEFT JOIN $pr_prop_types pt 
				ON pr.type = pt.ID 
			WHERE pr.ID iN ($ids) 
			ORDER BY pr.date_updated DESC, pr.date_created DESC, pr.ID DESC 
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
	foreach ($results as $prop)
	{
$img_src = $wpdb->get_var("SELECT img_name FROM $pr_pic_table WHERE prid = $prop->ID LIMIT 0,1");	
if(strlen($img_src)<5) $img_src = $pr_default_img;
	//$wpdb->show_errors();
	//$wpdb->print_error();
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
	?>
<table cellspacing="0" cellpadding="0" border="0">
<tbody>
	<tr class="headRow">
		<td colspan=5><?echo $prop->street.', '.$prop->area;?></td>
	</tr>
	<tr>
		<td rowspan="3" class="image">
			<img src="<?
			if(file_exists($pr_upload_thumbs.$img_src))
			echo $pr_img_show_folder_thumbs.$img_src;
			else echo $pr_img_show_folder.$img_src;
			?>" id="mainImage" alt="">
		</td>
		<td class="bedroom"><?echo $prop->bedroomnum?> bedroom</td>
		<td class="type"><?echo $prop->pr_type?></td>
		<td class="status"><?echo $status?></td>
		<td class="price"><?echo $prop->price; if ($prop->property_type == 1) echo " PCM";?></td>
	</tr>
	<tr>
		<td colspan="4" class="description">
		<?echo htmlspecialchars_decode(stripslashes($prop->descr))?>
		
		</td>
	</tr>
	<tr>
		<td colspan="4" class="viewMore"><a href="<?echo get_permalink(get_page_by_path($pr_slug)).'?pr_id='.$prop->ID?>">VIEW MORE INFORMATION</a></td>
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
	global $wpdb,$pr_areas,$pr_properties,$pr_area_types,$pr_prop_types,$pr_pic_table,$pr_per_page,$pr_slug,$pr_img_show_folder,$pr_default_img;
	$type = $wpdb->get_var($wpdb->prepare('SELECT property_type as type FROM '.$pr_properties.' WHERE ID = %d',$id));
global $_lettings_date_check,$_sales_date_check;
  switch($type)
	{
		case 1://LETTING
			$name = 'lettings';
			$results = $wpdb->get_results($wpdb->prepare("SELECT pr.ID, pr.let_weekrent as price, pr.addr_door_number as door_number, pr.addr_street as street, pr.addr_postcode as postcode, a.name as area, pt.Name as pr_type, pr.descr, pr.bedroomnum, pr.extra_status FROM $pr_properties pr LEFT JOIN $pr_areas a ON pr.area = a.ID LEFT JOIN $pr_prop_types pt ON pr.type = pt.ID WHERE pr.ID = %d AND pr.extra_active = 1 AND pr.approved = 1 AND $_lettings_date_check;",$id));
		break;
		case 2://SALE
			$name = 'sales';
			$results = $wpdb->get_results($wpdb->prepare("SELECT pr.ID, pr.sale_price as price, pr.addr_door_number as door_number, pr.addr_street as street, pr.addr_postcode as postcode, a.name as area, pt.Name as pr_type, pr.descr, pr.bedroomnum, pr.extra_status FROM $pr_properties pr LEFT JOIN $pr_areas a ON pr.area = a.ID LEFT JOIN $pr_prop_types pt ON pr.type = pt.ID WHERE pr.ID =%d AND pr.approved = 1 AND $_sales_date_check;",$id));			
		break;
	}
	//$wpdb->show_errors();
	//$wpdb->print_error();
	if (sizeof($results) > 0) // if we selected property is appropriate
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
	pr_m_($prop->street.', '.$prop->area,NULL,"h1");
	?>
	<table cellspacing="0" cellpadding="0" border="0">
		<tbody><tr>
			<td class="left">Number of Bedrooms <?echo $prop->bedroomnum?></td>
			<td class="right">
				<?
				switch($type)
				{
					case 1:
						pr_m_("&#163;$prop->price P/W");
						pr_m_("&#163;".(4*$prop->price)." P/M");
					break;
					case 2:
						pr_m_("&#163;$prop->price");
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

	</div>

	<?//pr_m_("Under construction","h2");
	}
	?>
	</div>
	<?
} else pr_m_('This property can not be viewed due to its setup. If you feel that this is a mistake, contact administration please.','error','h1');

}
function prf_images($prid)//shows pictures
{
	global $wpdb,$pr_pic_table,$pr_img_show_folder,$pr_default_img,$pr_upload_thumbs,$pr_img_show_folder_thumbs;
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
}
function prf_files($prid)//shows files
{
	global $wpdb,$pr_files_table,$pr_file_show_folder,$pr_upload_files;
	$results = $wpdb->get_results($wpdb->prepare("SELECT file_name,title FROM $pr_files_table WHERE prid = %d",$prid));
	/*
	$wpdb->show_errors();
	$wpdb->print_error();
	*/
	if(sizeof($results) == 0) echo "There are no files.";
	else {
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
    ?> (<?echo round(filesize($pr_upload_files.$file->file_name)/1024,0)?> KB) <a title="" href="<?echo $pr_file_show_folder.$file->file_name;?>">
		download	
		</a>
		</li>
		<?
	}
	?>
  </ul>
  <?
	}
}
function prf_videos($prid)// shows link to video, needs improvements
{
	global $wpdb,$pr_video_table;
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
function pr_3rd_isValidEmail($email){
	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
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
	echo getenv("HTTP_HOST");
	$to = get_bloginfo('admin_email');
	$subject = "Property viewing arrangement";
	$from = 'From: '.get_bloginfo('name').' <noreply@'.getenv("HTTP_HOST").'>'. "\r\n\\";
	$headers = $from;
	$prlink = get_bloginfo('url').'/'.$pr_slug.'/?pr_id='.$id;
	$message = ''.$_POST['firstname'].' '.$_POST['lastname'].' wants to arrange meeting '.$_POST['time'].' for '.$prlink.' Telephone number: '.$_POST['contactNumber'];
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
	global $pr_newsletter_slug,$pr_user_properties_slug,$pr_user_downloads_slug,$pr_tennant_slug;
	//$_str = '<li><a href='.get_permalink(get_page_by_path($pr_newsletter_slug)).'>Edit My Newsletter</a></li>';
	$_str = '<li><a href='.get_permalink(get_page_by_path($pr_user_properties_slug)).'>My Properties</a>
			'.prf_prop_menu().'</li>';
	$_str .= '<li><a href='.get_permalink(get_page_by_path($pr_user_downloads_slug)).'>Downloads</a></li>';
	$_str .= '<li><a href='.get_permalink(get_page_by_path($pr_tennant_slug)).'>Tenant\'s Personal Details</a></li>';
	
	return $_str;
}
function prf_sales_form($prid = NULL, $action = "add")
{global $wpdb,$pr_areas,$pr_area_types,$pr_properties,$pr_prefix,$pr_user_properties_slug,$pr_bands;
	$property = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$pr_properties.' WHERE ID = %d', $prid));
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
	switch ($action)
	{
		case "add":
			$title = "Add property for sale";
		break;
		case "edit":
			$title = "Edit property for sale";
		break;
	}
?>
<script src="<?bloginfo('template_url'); ?>/js/jquery.js" type="text/javascript"></script>
	<script type="text/javascript" src='<?bloginfo('url')?>/wp-content/plugins/properties/jquery.ui.js'></script>
<script type="text/javascript">
$(document).ready(function() {
    $('input#Let_DisplayFrom').datepicker({ dateFormat: 'yy-mm-dd' });
    $('input#Let_AvailableFrom').datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>
<?pr_m_($title,'','h1');?>
	<?
// initializing swfupload fields	
$_swfu_fields = array();
$_swfu_fields[] = array('pics','pic');	
$_swfu_fields[] = array('files','file');	
pr_swfupload_init($_swfu_fields);	
	pr_edit_subform("form_start",NULL,NULL,NULL,'');
	?>
	<div class="pr_block">
		<h3 class="manage-column column-title"><span>Sale information</span></h3>
		<div class="inside">	
			<p>Price</p><p><input type="text" name="pr_sale_price" value="<?if($prid!=NULL) echo $property[0]->sale_price;?>"></p>
			<p>Description</p><p><textarea name="pr_descr"><?if($prid!=NULL) echo $property[0]->descr;?></textarea></p>
			<p>View arrangements</p><p><textarea name="pr_viewarrange"><?if($prid!=NULL) echo $property[0]->viewarrange;?></textarea></p>
			<p>Refference number</p><p><input type="text" name="pr_refnumber" value="<?if($prid!=NULL) echo $property[0]->refnumber;?>"></p>
			<p>Area</p><p>
			<?
			if ($prid!=NULL)
			{
				$_area = $wpdb->get_var($wpdb->prepare("SELECT a.Name FROM $pr_properties pr LEFT JOIN $pr_areas a ON pr.area = a.ID WHERE pr.ID = %d",$prid));
				echo $_area;
			}
			else pr_edit_subform("areas",$area,NULL,'pr_area',NULL);
			?>
			</p>
			<p>Type</p><p><?pr_edit_subform("prop_types",$type);?></p>
			<p>Number of bedrooms</p><p><?pr_edit_subform("num_of_bedrooms",$bedroomnum,NULL,"pr_bedroomnum",10);?></p>
			<p>Number of bathrooms</p><p><?pr_edit_subform("num_of_bedrooms",$bathroomnum,NULL,"pr_bathroomnum",10);?></p>
			<p>Number of reception rooms</p><p><?pr_edit_subform("num_of_bedrooms",$receptionroomnum,NULL,"pr_receptionroomnum",10);?></p>			
		</div>
	</div>	
	
	<div class="pr_block">
		<h3 class="manage-column column-title"><span>Address information</span></h3>
		<div class="inside">	
			<p>Building name</p><p><input type="text" name="pr_addr_building_name" value="<?if($prid!=NULL) echo $property[0]->addr_building_name;?>"></p>
			<p>Door number</p><p><input type="text" name="pr_addr_door_number" value="<?if($prid!=NULL) echo $property[0]->addr_door_number;?>"></p>
			<p>Street</p><p><input type="text" name="pr_addr_street" value="<?if($prid!=NULL) echo $property[0]->addr_street;?>"></p>
			<p>Post code</p><p><input type="text" name="pr_postcode" value="<?if($prid!=NULL) echo $property[0]->addr_postcode;?>"></p>	
<?/*			
			<p>City</p><p>
			<?pr_edit_subform("city",$addr_city,NULL,"pr_addr_city");?>
			
			<p>County</p><p>
			<?pr_edit_subform("county",$addr_county,NULL,"pr_addr_county");?>
			
			<p>Country</p><p>
			<?pr_edit_subform("country",$addr_country,NULL,"pr_addr_country");?>
*/?>			
		</div>
	</div>	

	<div class="pr_block">
		<h3 class="manage-column column-title"><span>Extra information</span></h3>
		<div class="inside">	
			<?
			$_pr_band = NULL;
			if ($prid != NULL) {
			?>
      <p>Type of services</p><p>
		 <?
      $_pr_band = $property[0]->band_id;
			pr_edit_subform("bands_only_show",NULL,$pr_bands,"pr_band",$_pr_band);
			?>
			</p>
			<?
      }
      ?>
			<p>Available from</p><p>
			<input type="text" value="<?if($prid!=NULL and $property[0]->extra_date_avail_from) echo $property[0]->extra_date_avail_from;?>" name="pr_extra_date_avail_from" id="Let_AvailableFrom"></p>
			<p>Is active</p><p><input type="checkbox" value="1" name="pr_extra_active" <?if ($prid!=NULL and $property[0]->extra_active == 1) echo "checked";?>></p>
      <?
      if ($prid!=NULL)
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
      echo $property[0]->extra_date_displ_from;
      }
      else echo 'N/A';?></p>
      <p>Display to</p><p>
			<?
      if ($property[0]->extra_date_displ_to != NULL and $property[0]->extra_date_displ_to != '0000-00-00' and $property[0]->extra_date_displ_to != '')
      {
      echo $property[0]->extra_date_displ_to;
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
			<p>Furnishing</p><p><input type="text" name="pr_extra_furnishing" value="<?if($prid!=NULL) echo $property[0]->extra_furnishing;?>"></p>
			<p>Status</p><p><?pr_edit_subform("sale_status",$extra_status,NULL,"pr_extra_status");?></p>			
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
	
	<p>
	<?
	pr_edit_subform("hidden",NULL,NULL,"pr_action",$action);// this states whether we add or edit
	if ($prid != NULL) pr_edit_subform("hidden",NULL,NULL,"pr_id",$prid);// this states what property we are editing in case of action = edit
	pr_edit_subform("submit");
	?></p>
	<?
	pr_edit_subform("form_end");
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
	$results = $wpdb->get_results("SELECT pr.ID, pr.sale_price as price, pr.addr_door_number as door_number, pr.addr_street as street, pr.addr_postcode as postcode, a.name as area, pr.property_type as type,pr.extra_active as active,pr.approved as approved FROM $pr_properties pr LEFT JOIN $pr_areas a ON pr.area = a.ID WHERE user_id = $user_ID ORDER BY pr.ID ASC LIMIT $start,$pr_per_page;");			

	//$wpdb->show_errors();
	//$wpdb->print_error();
	if ($pages > 1) pr_m_($pagestring,"pagination","div");
	?>
<table class="widefat">
<thead>
<tr>
	<th class="manage-column column-title">#</th>
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
		<a href="<?echo get_permalink(get_page_by_path($pr_slug)).'?pr_id='.$prop->ID;?>">
		<?echo $prop->door_number.', '.$prop->street.', '.$prop->postcode.', '.$prop->area;?>
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
{global $wpdb,$pr_areas,$pr_area_types,$pr_properties,$pr_prefix;
	$property = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$pr_properties.' WHERE ID = %d', $prid));
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
	switch ($action)
	{
		case "add":
			$title = "Add property for letting";
		break;
		case "edit":
			$title = "Edit property for letting";
		break;
	}
?>
<script src="<?bloginfo('template_url'); ?>/js/jquery.js" type="text/javascript"></script>
	<script type="text/javascript" src='<?bloginfo('url')?>/wp-content/plugins/properties/jquery.ui.js'></script>
<script type="text/javascript">
$(document).ready(function() {
    $('input#Let_DisplayFrom').datepicker({ dateFormat: 'yy-mm-dd' });
    $('input#Let_AvailableFrom').datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>
<?pr_m_($title,'','h1');?>
	<?
// initializing swfupload fields	
$_swfu_fields = array();
$_swfu_fields[] = array('pics','pic');	
$_swfu_fields[] = array('files','file');	
pr_swfupload_init($_swfu_fields);	
	pr_edit_subform("form_start");
	?>
	<div class="pr_block">
		<h3 class="manage-column column-title"><span>Let information</span></h3>
		<div class="inside">	
			<p>Rent per weeek</p><p><input type="text" name="pr_let_weekrent" value="<?if($prid!=NULL) echo $property[0]->let_weekrent;?>"></p>
			<p>Description</p><p><textarea name="pr_descr"><?if($prid!=NULL) echo $property[0]->descr;?></textarea></p>
			<p>View arrangements</p><p><textarea name="pr_viewarrange"><?if($prid!=NULL) echo $property[0]->viewarrange;?></textarea></p>
			<p>Refference number</p><p><input type="text" name="pr_refnumber" value="<?if($prid!=NULL) echo $property[0]->refnumber;?>"></p>
			<p>Area</p><p>
			<?
			if ($prid!=NULL)
			{
				$_area = $wpdb->get_var($wpdb->prepare("SELECT a.Name FROM $pr_properties pr LEFT JOIN $pr_areas a ON pr.area = a.ID WHERE pr.ID = %d",$prid));
				echo $_area;
			}
			else pr_edit_subform("areas",$area,NULL,'pr_area',NULL);
			?>
			</p>
			<p>Type</p><p><?pr_edit_subform("prop_types",$type);?></p>
			<p>Number of bedrooms</p><p><?pr_edit_subform("num_of_bedrooms",$bedroomnum,NULL,"pr_bedroomnum",10);?></p>
			<p>Number of bathrooms</p><p><?pr_edit_subform("num_of_bedrooms",$bathroomnum,NULL,"pr_bathroomnum",10);?></p>
			<p>Number of reception rooms</p><p><?pr_edit_subform("num_of_bedrooms",$receptionroomnum,NULL,"pr_receptionroomnum",10);?></p>			
		</div>
	</div>	
	
	<div class="pr_block">
		<h3 class="manage-column column-title"><span>Address information</span></h3>
		<div class="inside">	
			<p>Building name</p><p><input type="text" name="pr_addr_building_name" value="<?if($prid!=NULL) echo $property[0]->addr_building_name;?>"></p>
			<p>Door number</p><p><input type="text" name="pr_addr_door_number" value="<?if($prid!=NULL) echo $property[0]->addr_door_number;?>"></p>
			<p>Street</p><p><input type="text" name="pr_addr_street" value="<?if($prid!=NULL) echo $property[0]->addr_street;?>"></p>
			<p>Post code</p><p><input type="text" name="pr_postcode" value="<?if($prid!=NULL) echo $property[0]->addr_postcode;?>"></p>
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
			<input type="text" value="<?if($prid!=NULL and $property[0]->extra_date_avail_from != '0000-00-00') echo $property[0]->extra_date_avail_from;?>" name="pr_extra_date_avail_from" id="Let_AvailableFrom"></p>
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
      echo $property[0]->extra_date_displ_from;
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
			<p>Furnishing</p><p><input type="text" name="pr_extra_furnishing" value="<?if($prid!=NULL) echo $property[0]->extra_furnishing;?>"></p>
			<p>Status</p><p><?pr_edit_subform("let_status",$extra_status,NULL,"pr_extra_status");?></p>			
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
	<p>
	<?
	pr_edit_subform("hidden",NULL,NULL,"pr_action",$action);// this states whether we add or edit
	if ($prid != NULL) pr_edit_subform("hidden",NULL,NULL,"pr_id",$prid);// this states what property we are editing in case of action = edit
	pr_edit_subform("submit");
	?></p>
	<?
	pr_edit_subform("form_end");
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

function prf_create_order_details($orid,$props,$ref)
{
  global $wpdb,$pr_order_details,$pr_properties,$pr_bands,$pr_areas;
// details of properties by updated properties ids
  $details = $wpdb->get_results("SELECT IF(b.Name IS NULL,'N/A',b.Name) as band, pr.addr_door_number as dnum, pr.addr_street as street, pr.addr_postcode as pcode, a.name as area, IF(pr.sale_price IS NOT NULL,pr.sale_price,pr.let_weekrent) as price FROM $pr_properties pr LEFT JOIN $pr_bands b ON pr.band_id = b.ID LEFT JOIN $pr_areas a ON pr.area = a.ID  WHERE order_ref = '$ref'");
  // inserting details to order_details by insert_last_id() for order
  foreach($details as $det)
  {
   $wpdb->query("INSERT INTO $pr_order_details (ID,details,price,order_id) values (NULL,'$det->band, $det->dnum, $det->street, $det->pcode, $det->area',$det->price,$orid)");
 // $wpdb->show_errors();
	//$wpdb->print_error(); 
  }
  
  
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
	global $wpdb,$user_ID,$pr_orders,$pr_properties,$pr_seller_mail,$pr_data_send_url,$pr_token;
	// make order completed if we get completion from paypal and item_number = pr_order.refernce

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
				if($val!=$_GET['amt']) $err = true;
			break;			
			case "payment_status":
				if($val != $_GET['st']) $err = true;
			break;			
			case "business":
				$pr_seller_mail = str_replace('@','%40',$pr_seller_mail);
				if($val != $pr_seller_mail) $err = true;
			break;			
			case "txn_id":
				if ($val != $_GET['tx']) $err = true;
			break;			
			case "item_number":
				if($val != $_GET['item_number']) $err = true;
			break;			
			case "payment_status":
				if($val != $_GET['st']) $err = true;
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
		
		if($_GET['st']=='Completed') // this order is completed
		{
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
						$wpdb->query($wpdb->prepare("UPDATE $pr_properties SET paid = 1 WHERE order_ref = %d",$_GET['item_number']));
						
					} else pr_m_('This order isn\'t new, and can\'t be paid','error','div');
				} else pr_m_('This order was requested by another user','error','div');
			} else pr_m_('The total amount of money paid and requested to pay does not match','error','div');
		} else pr_m_('Order wasn\'t completed','error','div');
		
		}
	}
}
	
}

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
		$u_country = array_unique($_country);//массив уникальных значений номеров стран
		foreach($u_country as $id_country)
		{
			$t = 0;
			for ($i=0;$i<sizeof($_country);$i++)
			{
				if ($id_country == $_country[$i]) $t++;
			}
			$count_country[] = $t;//массив количества элементов для каждой из стран
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
		
		$props = $wpdb->get_results("SELECT pr.ID,pr.sale_price as price,a.Name as area,pr.addr_postcode as postcode,pr.addr_door_number as door_number,pr.addr_street as street, pr.band_id FROM $pr_properties pr LEFT JOIN $pr_areas a ON pr.area = a.ID WHERE pr.ID IN ($_ids)");
		//$wpdb->show_errors();
		//$wpdb->print_error();
		global $pr_user_properties_slug;
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
	<td><a href="<?echo get_permalink(get_page_by_path($pr_user_properties_slug))?>?prf_edit_id=<?echo $prop->ID?>"><?echo $prop->door_number.', '.$prop->street.', '.$prop->postcode.', '.$prop->area?></a></td>
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
		pr_m_("Total: $band_total",'total','p');
		//pr_edit_subform("hidden",NULL,NULL,'pr_total_pay',$band_total);
		pr_edit_subform("submit",NULL,NULL,'Calculate total');
		pr_edit_subform("form_end");
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
}
function prf_paypal_button($total_price,$ref_number)
{
global $pr_seller_mail,$pr_data_send_url,$pr_token;
?>
<form action="<?echo $pr_data_send_url?>" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="<?echo $pr_seller_mail?>">
<input type="hidden" name="lc" value="GB">
<input type="hidden" name="item_name" value="order payment">
<input type="hidden" name="button_subtype" value="services">
<input type="hidden" name="no_note" value="0">
<input type="hidden" name="currency_code" value="GBP">
<input type="hidden" name="amount" value="<?echo $total_price?>">
<input type="hidden" name="hosted_button_id" value="XTC56GXMRNWCG">
<input type="hidden" name="item_number" value="<?echo $ref_number?>">

<input type="image" src="https://www.sandbox.paypal.com/en_GB/i/btn/btn_buynow_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.sandbox.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form>

<?
}

function prf_prop_menu()
{
	global $pr_user_properties_slug,$pr_properties,$user_ID,$wpdb,$pr_areas;
	
	$_str = "";
  //$_str .= '<li class="first"><a href=\''.get_permalink(get_page_by_path($pr_user_properties_slug)).'\'>My properties</a></li>';
	$_str .= '<li><a href=\''.get_permalink(get_page_by_path($pr_user_properties_slug)).'?pr_action=prf_add_sale\'>Add sales property</a></li>';
	$_str .= '<li><a href=\''.get_permalink(get_page_by_path($pr_user_properties_slug)).'?pr_action=prf_add_let\'>Add lettings property</a></li>';
	// huge check whether property is in exclusion area like UK(I made an array, so we possibly can create more than one). 
	// This check also uses pr_check_parent from funcs.php
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
	if(isset($_un_prop_ids) and sizeof($_un_prop_ids)>0)
	{
		$_str .= '<li><a href=\''.get_permalink(get_page_by_path($pr_user_properties_slug)).'?pr_action=checkout\'>Checkout</a></li>';	
	}
	   
	}
	$_str .= '<li><a href=\''.get_permalink(get_page_by_path($pr_user_properties_slug)).'?pr_action=orders\'>View orders</a></li>';	
	return '<ul>'.$_str.'</ul>';
}



function prf_user_properties()
{
global $user_ID,$pr_properties,$wpdb,$pr_slug;

if(is_user_logged_in()) // user must be logged in to perform all these actions
{

// menu
//pr_m_(prf_prop_menu(),'menu','div');

// обработка событий добавления и обновления
// do all the magic

	if (isset($_POST['pr_action']))
	{
		switch($_POST['pr_action'])
		{
			case 'add':
				
				switch ($_GET['pr_action']) // добавление продажи или аренды
				{
					case 'prf_add_sale':
if($_POST['pr_addr_building_name'] != NULL and $_POST['pr_addr_street'] != NULL and $_POST['pr_addr_door_number'] != NULL)
{
	
	if(!isset($_POST['pr_extra_active'])) $active = 0; else $active = $_POST['pr_extra_active'];
	//if(!isset($_POST['pr_extra_featured'])) $featured = 0; else $featured = $_POST['pr_extra_featured'];
	//$active = 0;      
	$featured = 0;
	if ($_POST['pr_extra_date_avail_from']!='') $pr_extra_date_avail_from = $_POST['pr_extra_date_avail_from']; else $pr_extra_date_avail_from = NULL;
	$pr_extra_date_displ_from = NULL;
	// user can't change this parameters
	
	pr_sale_add($_POST['pr_sale_price'],$_POST['pr_descr'],$_POST['pr_viewarrange'],$_POST['pr_refnumber'],$_POST['pr_area'],$_POST['pr_prop_types'],$_POST['pr_bedroomnum'],$_POST['pr_addr_building_name'],$_POST['pr_addr_door_number'],$_POST['pr_addr_street'],NULL,NULL,NULL,$_POST['pr_postcode'],$pr_extra_date_avail_from,$pr_extra_date_displ_from,$active,$featured,$_POST['pr_extra_furnishing'],$_POST['pr_extra_status']);
pr_m_('New property has been added');
} else {
	pr_m_('You haven\'t filled all necessary fields');
	pr_delete_tmp_pics($user_ID);
	}
					break;
					case 'prf_add_let':
if($_POST['pr_addr_building_name'] != NULL and $_POST['pr_addr_street'] != NULL and $_POST['pr_addr_door_number'] != NULL)
{
	
	if(!isset($_POST['pr_extra_active'])) $active = 0; else $active = $_POST['pr_extra_active'];
	//if(!isset($_POST['pr_extra_featured'])) $featured = 0; else $featured = $_POST['pr_extra_featured'];
	//$active = 0;
	$featured = 0;
	if ($_POST['pr_extra_date_avail_from']!='') $pr_extra_date_avail_from = $_POST['pr_extra_date_avail_from']; else $pr_extra_date_avail_from = NULL;
	$pr_extra_date_displ_from = NULL;
	// user can't change this parameters
	
	pr_letting_add($_POST['pr_let_weekrent'],$_POST['pr_descr'],$_POST['pr_viewarrange'],$_POST['pr_refnumber'],$_POST['pr_area'],$_POST['pr_prop_types'],$_POST['pr_bedroomnum'],$_POST['pr_addr_building_name'],$_POST['pr_addr_door_number'],$_POST['pr_addr_street'],NULL,NULL,NULL,$_POST['pr_postcode'],$pr_extra_date_avail_from,$pr_extra_date_displ_from,$active,$featured,$_POST['pr_extra_furnishing'],$_POST['pr_extra_status']);
pr_m_('New letting has been added');
} else {
	pr_m_('You haven\'t filled all necessary fields');
	pr_delete_tmp_pics($user_ID);
	}						
					break;
				}
				
			break;
			
			case 'edit':
			
				// get property type
				$_type = $wpdb->get_var($wpdb->prepare("SELECT property_type FROM $pr_properties WHERE ID = %d", $_POST['pr_id']));
				$_user_id = $wpdb->get_var($wpdb->prepare("SELECT user_id FROM $pr_properties WHERE ID = %d", $_POST['pr_id']));
				// these are non changable fields for user, we get them from DB
				$_non_change = $wpdb->get_results($wpdb->prepare("SELECT  area,extra_active,extra_featured,extra_date_avail_from,extra_date_displ_from FROM $pr_properties WHERE ID = %d", $_POST['pr_id']));
				//$wpdb->show_errors();
				//$wpdb->print_error();
				foreach ($_non_change as $_prop)
				{
					//$active = $_prop->extra_active;
					if(!isset($_POST['pr_extra_active'])) $active = 0; else $active = $_POST['pr_extra_active'];
					$featured = $_prop->extra_featured;
					if ($_POST['pr_extra_date_avail_from']!='') $pr_extra_date_avail_from = $_POST['pr_extra_date_avail_from']; else $pr_extra_date_avail_from = NULL; 
					$pr_extra_date_displ_from = $_prop->extra_date_displ_from;
					$area = $_prop->area;
				}
				switch($_type)
				{
					case 2://sale
if ($user_ID==$_user_id)
{					
if($_POST['pr_addr_building_name'] != NULL and $_POST['pr_addr_street'] != NULL and $_POST['pr_addr_door_number'] != NULL)
{
	
	//if(!isset($_POST['pr_extra_active'])) $active = 0; else $active = $_POST['pr_extra_active'];
	//if(!isset($_POST['pr_extra_featured'])) $featured = 0; else $featured = $_POST['pr_extra_featured'];

	pr_sale_update($_POST['pr_sale_price'],$_POST['pr_descr'],$_POST['pr_viewarrange'],$_POST['pr_refnumber'],$area,$_POST['pr_prop_types'],$_POST['pr_bedroomnum'],$_POST['pr_addr_building_name'],$_POST['pr_addr_door_number'],$_POST['pr_addr_street'],NULL,NULL,NULL,$_POST['pr_postcode'],$pr_extra_date_avail_from,$pr_extra_date_displ_from,$active,$featured,$_POST['pr_extra_furnishing'],$_POST['pr_extra_status']);
pr_m_('A sale has been edited');
} else {pr_m_('You haven\'t filled all necessary fields');
	pr_delete_tmp_pics($user_ID);
}
} else pr_m_('You don\'t have permission to edit this property','error','div');							
					break;
					case 1://let
if ($user_ID==$_user_id)
{
if($_POST['pr_addr_building_name'] != NULL and $_POST['pr_addr_street'] != NULL and $_POST['pr_addr_door_number'] != NULL)
{
	
	//if(!isset($_POST['pr_extra_active'])) $active = 0; else $active = $_POST['pr_extra_active'];
	//if(!isset($_POST['pr_extra_featured'])) $featured = 0; else $featured = $_POST['pr_extra_featured'];
	
	pr_letting_update($_POST['pr_let_weekrent'],$_POST['pr_descr'],$_POST['pr_viewarrange'],$_POST['pr_refnumber'],$area,$_POST['pr_prop_types'],$_POST['pr_bedroomnum'],$_POST['pr_addr_building_name'],$_POST['pr_addr_door_number'],$_POST['pr_addr_street'],NULL,NULL,NULL,$_POST['pr_postcode'],$pr_extra_date_avail_from,$pr_extra_date_displ_from,$active,$featured,$_POST['pr_extra_furnishing'],$_POST['pr_extra_status']);
pr_m_('A letting has been edited');
} else {pr_m_('You haven\'t filled all necessary fields');
	pr_delete_tmp_pics($user_ID);
}		
} else pr_m_('You don\'t have permission to edit this property','error','div');				
					break;
				}
			
			break;     
		}
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
				prf_sales_form();
			break;
			case "prf_add_let":
				prf_letting_form();
			break;			
			case "checkout":
				prf_checkout();
			break;
			case "orders":
	       prf_show_user_orders();
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
			else prf_prop_list();

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
	global $wpdb,$pr_properties,$pr_img_show_folder,$pr_pic_table,$pr_slug,$pr_plugin_images,$pr_default_img,$pr_upload_thumbs,$pr_img_show_folder_thumbs;
	global $_featured_date_check;
	if ($show != 0)
	{
		$_limit = "LIMIT 0,$show";
	} $_limit = "";
	$_results = $wpdb->get_results("SELECT ID from $pr_properties WHERE extra_featured = 1 AND extra_active = 1 AND approved = 1 AND $_featured_date_check ORDER BY extra_date_displ_from DESC, ID DESC $_limit;");
	?>
						
					
	<div id="featured">
				<h2>Featured properties</h2>
				<img src="<?echo $pr_plugin_images?>featured_previous.png" id="prev_image" class="disabled">
				<div class="scrollable">
					<div class="items">
					
	<?
	$_addr = get_permalink(get_page_by_path($pr_slug));
	foreach($_results as $featured)
	{
		$img_src = $wpdb->get_var("SELECT img_name FROM $pr_pic_table WHERE prid = $featured->ID LIMIT 0,1");
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
	<?
	
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
  
  $orders = $wpdb->get_results("SELECT * FROM $pr_orders WHERE user_id = $user_ID LIMIT $start,$pr_per_page");
  
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
      <?echo $order->total?>
      </td>

      <td>
      <?
      echo $order->date_issued;
      ?>
      </td>

      <td>
      <?echo $order->transaction_id;
      if($order->transaction_id != NULL) echo "<br>$order->status on $order->date_completed";?>
      </td>

      <td>
      <?echo $order->status;?>
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
					$fields_values_arr[] = $_POST[$field->Field];
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
					$fields_values_arr[] = $_POST[$field->Field];
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

function prf_tennants_form($user_id)
{
	
	global $wpdb,$pr_tennants_details,$user_ID;
	
	if(isset($_POST['submit']))
	{
	$_err = false;
	if (strlen($_POST['bank_sortcode'][0])==2 and strlen($_POST['bank_sortcode'][1])==2 and strlen($_POST['bank_sortcode'][2])==2 )
		$_POST['bank_sortcode'] = $_POST['bank_sortcode'][0].'/'.$_POST['bank_sortcode'][1].'/'.$_POST['bank_sortcode'][2];
	else {$_err = true;pr_m_('<a href=\'#bank\'>Wrong sort code in bank account section</a>','error','h3');}

	if(!preg_match("/^([a-zA-Z0-9])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/",$_POST['email']))
		{$_err = true;pr_m_('<a href=\'#personal\'>Tennant\'s email address is incorrect</a>','error','h3');}
	if(!preg_match("/^([a-zA-Z0-9])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/",$_POST['landlord_email']))
		{$_err = true;pr_m_('<a href=\'#landlord\'>Landord\'s email address is incorrect</a>','error','h3');}
	
	
	
	if ($_err == false)
	{
		if(isset($_POST['declaration']))
		{
	
	$details = $wpdb->get_results("SELECT user_id FROM $pr_tennants_details where user_id = $user_ID");
	//print_r($details);
	if (sizeof($details)>0) // there is an entry for this user_ID, so we just update it
	{
		prf_tennants_update($user_ID);					
	} else // no previous entries for this user_ID
		{
			prf_tennants_insert($user_ID);			
		}
		
		} else pr_m_('<a href=\'#declaration\'>You need to accept terms and conditions</a>','error','h3');
	}
	
	}
	$details = $wpdb->get_results("SELECT * FROM $pr_tennants_details where user_id = $user_ID");
	pr_edit_subform("form_start");
	$descr = $wpdb->get_results("DESCRIBE $pr_tennants_details;");
	//print_r($descr);
	$main_labels = array(
	'u_name' => 'Name ',
	'address' => 'Address ',
	'telephone' => 'Telephone number(s) ',
	'birthdate' => 'Date of birth ',
	'insurance' => 'National Insurance number ',
	'email' => 'Email ',
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
	foreach($descr as $_descr)
	{
	if(sizeof($details)>0) { $_A = $_descr->Field; $form_value = $details[0]->$_A;}
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
				else {pr_edit_subform('text_input',$_descr->Field,NULL,$_descr->Field,$form_value);
					if ($_descr->Field=='birthdate')
					{
?>
						<script type="text/javascript">
$(document).ready(function() {
    $('input#<?echo $_descr->Field?>').datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>
<?
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
	pr_edit_subform("submit");
	pr_edit_subform("form_end");
	
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
	echo "
	<div class=\"scrolling_news\">
	<ul class=\"featured\" id=\"featured_news\">";
	//echo "<p>".$cat."</p>";
	if ($lastposts) {
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