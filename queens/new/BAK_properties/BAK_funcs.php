<?
/**
 *
 * @module properties
 * @version 1
 * @copyright 2011
 */


function pr_menu()
{global $pr_sales_page, $pr_lettings_page, $pr_areas_page, $pr_area_types_page, $pr_properties_page, $pr_downloads_page,$pr_invoices_page,$pr_newsletters_page,$pr_prop_types_page,$pr_filter_page;
if ( function_exists('add_menu_page') )
  {
	add_menu_page(__('Properties', 'properties'), __('Properties', 'properties'), 'manage_pr',  $pr_properties_page, '',  plugins_url('properties/images/icon.png'));

	add_submenu_page( $pr_properties_page, "Property types", "Property types", 'manage_pr', $pr_prop_types_page, '');
	add_submenu_page( $pr_properties_page, "Manage areas", "Manage areas", 'manage_pr', $pr_areas_page, '');

	add_submenu_page( $pr_properties_page, "Manage area types", "Manage area types", 'manage_pr', $pr_area_types_page, '');

	add_submenu_page( $pr_properties_page, "Filter properties", "Filter properties", 'manage_pr', $pr_filter_page, 'pr_filter_properties');

	add_submenu_page( $pr_properties_page, "Manage Lettings", "Manage Lettings", 'manage_pr', $pr_lettings_page, '');
	add_submenu_page( $pr_properties_page, "Manage Sales", "Manage Sales", 'manage_pr', $pr_sales_page, '');
	add_submenu_page( $pr_properties_page, "User downloads", "User downloads", 'manage_pr', $pr_downloads_page, '');
	add_submenu_page( $pr_properties_page, "User orders", "User orders", 'manage_pr', $pr_invoices_page, '');
	/*add_submenu_page( 'properties/manager.php', "Add offer", "Add offer", 'manage_pr', 'special-offers/add.php', '');

	add_submenu_page( 'special-offers/manager.php', "Manage destinations", "Manage destinations", 'manage_so', 'special-offers/destinations.php', '');
	add_submenu_page( 'special-offers/manager.php', "Manage categories", "Manage categories", 'manage_so', 'special-offers/categories.php', '');
	*/

  add_menu_page(__('Newsletters', 'newsletters'), __('Newsletters', 'newsletters'), 'manage_pr',  $pr_newsletters_page, '',  plugins_url('properties/images/nwsltr.png'));

  add_menu_page(__('Notifications', 'notifications'), __('Notifications', 'notifications'), 'manage_pr',  'notifications', 'pr_notifications_page',  plugins_url('properties/images/mail_notification.png'));

  add_menu_page(__('Paypal', 'paypal'), __('Paypal', 'paypal'), 'manage_pr',  'paypal', 'pr_pp_edit',  plugins_url('properties/images/paypal.png'));

  add_menu_page(__('Bands', 'bands'), __('Bands', 'bands'), 'manage_pr',  'bands', 'pr_bands_edit',  plugins_url('properties/images/paypal.png'));

  add_menu_page(__('Export', 'Export'), __('Export', 'Export'), 'manage_pr',  'export', 'pr_export',  plugins_url('properties/images/export.png'));
  }
  pr_profile_redirect();
}
// The following function restricts all but admins to access wp-admin, others are redirected
function pr_profile_redirect() {
$url = get_bloginfo('url').'/wp-login.php';
$user_info = wp_get_current_user();
if($user_info->user_level < 8 || $user_info->user_level == "")
{
	//if (strpos($_SERVER['PHP_SELF'],'profile.php')===false || strpos($_SERVER['PHP_SELF'],'wp-login.php')===false) {
	wp_redirect($url);
	exit();
	//}
}
}
function pr_redirect()
{
global $pr_slug,$pr_user_properties_slug,$pr_user_basket;

	$_page = get_page();
	$_parent = get_page($_page->post_parent);
if(is_page('lettings'))
	{
		if ($_parent->post_name=='international') {
			wp_redirect( get_permalink(get_page_by_path($pr_slug)).'?pr_type=1&pr_bedroomnum=0&minimumprice=0&maximumprice=&pr_area=0&submit=SEARCH&exclude=222' );
		} else {
			wp_redirect( get_permalink(get_page_by_path($pr_slug)).'?pr_type=1&pr_bedroomnum=0&minimumprice=0&maximumprice=&minimumprice_hidden=0&maximumprice_hidden=&pr_area=222' );
		}

	}
	elseif(is_page('sales'))
	{
		if ($_parent->post_name=='international') {
			wp_redirect( get_permalink(get_page_by_path($pr_slug)).'?pr_type=2&pr_bedroomnum=0&minimumprice=0&maximumprice=&pr_area=0&submit=SEARCH&exclude=222' );
		} else {
			wp_redirect( get_permalink(get_page_by_path($pr_slug)).'?pr_type=2&pr_bedroomnum=0&minimumprice_hidden=0&maximumprice_hidden=&minimumprice=0&maximumprice=&pr_area=222' );
		}

	}
	elseif (is_page($pr_user_properties_slug)) {
	//	echo $pr_user_properties_slug;
	if (isset($_GET['pr_action']) or isset($_GET['prf_edit_id'])) {
		$_result = pri_AddUpdateProperty();
		if ($_POST['_err_ids'] == FALSE and $_result == TRUE) {
			//print_r($_POST['AddUpdateProperty']);
			if (isset($_POST['band_to_buy'])) {
				wp_redirect(get_permalink(get_page_by_path($pr_user_basket)));
			} elseif (isset($_POST['basket_to_assign'])) {
				$_cartid = prb_get_basket_cartid($_POST['basket_to_assign']);
				if ($_cartid > 0) {
					wp_redirect(get_permalink(get_page_by_path($pr_user_basket)));
				} else {
					wp_redirect(get_permalink(get_page_by_path($pr_user_properties_slug)));
				}


			} else {
				wp_redirect(get_permalink(get_page_by_path($pr_user_properties_slug)));
			}
			}
		}
	}

/*
	elseif (is_page('international'))
	{
		wp_redirect(get_permalink(get_page_by_path($pr_slug)).'?pr_type=all&pr_bedroomnum=0&minimumprice=0&maximumprice=&pr_area=0&submit=SEARCH&exclude=222');
	}
*/
}
function pr_init_()
{
global $user_ID,$pr_user_properties_slug,$pr_user_basket;

$_SESSION['user_id'] = $user_ID;
if (isset($_POST['sort_by_price']))
	{
	$_SESSION['sort_by_price'] = $_POST['sort_by_price'];
	}
elseif(!isset($_SESSION['sort_by_price'])) {
	$_SESSION['sort_by_price'] = 'ASC';
	}
if (isset($_POST['area_id_filter'])) {
		$_SESSION['area_id_filter'] = $_POST['area_id_filter'];
	}
if (isset($_POST['keyword_filter'])) {
		$_SESSION['keyword_filter'] = $_POST['keyword_filter'];
	}
if (isset($_POST['user_filter'])) {
	$_SESSION['user_filter'] = $_POST['user_filter'];
	}
if (isset($_POST['type_filter'])) {
		$_SESSION['type_filter'] = $_POST['type_filter'];

}
if (isset($_POST['clear_filter'])) {//we clear session varaibles
		unset($_SESSION['area_id_filter']);
		unset($_SESSION['keyword_filter']);
		unset($_SESSION['user_filter']);
		unset($_SESSION['type_filter']);
	}

if (isset($_POST['pr_type']))
{
	session_start();
	$_SESSION['pr_type'] = $_POST['pr_type'];
	$_SESSION['pr_bedroomnum'] = $_POST['pr_bedroomnum'];
	$_SESSION['minimumprice'] = $_POST['minimumprice'];
	$_SESSION['maximumprice'] = $_POST['maximumprice'];
	$_SESSION['pr_area'] = $_POST['pr_area'];
}

if (isset($_GET['pr_type']))
{
	session_start();
	$_SESSION['pr_type'] = $_GET['pr_type'];
	$_SESSION['pr_bedroomnum'] = $_GET['pr_bedroomnum'];
	$_SESSION['minimumprice'] = $_GET['minimumprice'];
	$_SESSION['maximumprice'] = $_GET['maximumprice'];
	$_SESSION['pr_area'] = $_GET['pr_area'];
	if (isset($_GET['exclude'])) $_SESSION['exclude'] = $_GET['exclude'];
}

	// WTZ Hooks for Notifications to be send
	global $pr_u_adds_pp,$pr_u_adds_npp,$pr_u_adds_pfp;
	add_action($pr_u_adds_pp,'pr_ntf_send',10,2);
	add_action($pr_u_adds_npp,'pr_ntf_send',10,2);
	add_action($pr_u_adds_pfp,'pr_ntf_send',10,2);

	global $pr_add_property_hook,$pr_update_property_hook,$pr_letting_form_hook,$pr_sale_form_hook;
	add_action($pr_add_property_hook,'pr_add_property_hook',10,4);
	add_action($pr_update_property_hook,'pr_update_property_hook',10,4);
	add_action($pr_letting_form_hook,'pr_letting_form_hook');
	add_action($pr_sale_form_hook,'pr_sale_form_hook');

	if (isset($_GET['ipn'])) {
		pr_pp_ipn($_GET['ipn']);// IPN Listener call
	}
}
function prf_properties() // this function is responsible for search engine and properties' details show
{
	if (isset($_GET['pr_id']))
	{
	//pr_m_("Under construction","h2");
	pr_property_show($_GET['pr_id']);
	} else {
	if (isset($_GET['pr_page_id'])) $page_id = $_GET['pr_page_id']; else $page_id = 1;
	//print_r($_SESSION);
	pr_prop_filter($_SESSION['pr_type'],$_SESSION['pr_bedroomnum'],$_SESSION['minimumprice'],$_SESSION['maximumprice'],$_SESSION['pr_area'],$page_id);
	}
}
function pr_content_filter($content)
{global $pr_slug,$pr_newsletter_slug,$pr_user_properties_slug,$pr_user_downloads_slug,$pr_tennant_slug,$pr_avail_bands,$pr_user_bands,$user_ID,$pr_user_basket;
	if(is_page($pr_slug))
	{
		$content = prf_properties();
	}
	elseif (is_page($pr_newsletter_slug))
	{

	}
	elseif (is_page($pr_user_properties_slug))
	{
		$content = prf_user_properties();
	}
	elseif (is_page($pr_user_downloads_slug))
	{
		$content = prf_user_downloads();
	}
	elseif (is_page($pr_tennant_slug))
	{
		$content = prf_tennants_details();
	}
	elseif (is_home() || is_front_page())
	{
		//add_action('wp_footer','prf_featured_gallery');
		// this gallery will be added through calling function from homepage template
	}
	elseif (is_page($pr_avail_bands))
	{
		$content = prbf_show_available_bands();
	}
	elseif (is_page($pr_user_bands))
	{
		$content = prbf_show_user_bands($user_ID);
	}
	elseif (is_page($pr_user_basket))
	{
		$content = prubf_show_user_cart($user_ID);
	}
	return $content;
}
function pr_add_site_head()
{
	?>
	<!-- properties module wtz styles-->
	<link rel='stylesheet' href='<?bloginfo('url')?>/wp-content/plugins/properties/style.css' type='text/css' media='all' />
	<link rel='stylesheet' href='<?bloginfo('url')?>/wp-content/plugins/properties/datepicker1.css' type='text/css' media='all' />
	<link rel="Stylesheet" href="<?bloginfo('url')?>/wp-content/plugins/properties/jquery-ui-1.7.2.custom.css" type="text/css" />
	<link rel="Stylesheet" href="<?bloginfo('url')?>/wp-content/plugins/properties/dateinput.css" type="text/css" />

	<!-- properties module wtz styles-->

<script src="<?bloginfo('template_url'); ?>/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src='<?bloginfo('url')?>/wp-content/plugins/properties/jquery.ui.js'></script>




<script language="JavaScript" type="text/javascript" src="<?bloginfo('url')?>/wp-content/plugins/properties/somescripting.js"></script>
<!-- editor data -->
<link rel="Stylesheet" href="<?bloginfo('url')?>/wp-content/plugins/properties/jwysiwyg/jquery.wysiwyg.css" type="text/css" />

	<?
}
function pr_add_admin_head()
{
global $pr_sales_page,$pr_lettings_page,$pr_areas_page,$pr_area_types_page,$pr_properties_page,$pr_prop_types_page,$pr_downloads_page,$pr_invoices_page,$pr_filter_page,$pr_newsletters_page,$pr_paypal_page,$pr_export_page;

	$pages = array($pr_sales_page,$pr_lettings_page,$pr_areas_page,$pr_area_types_page,$pr_properties_page,$pr_prop_types_page,$pr_downloads_page,$pr_invoices_page,$pr_filter_page,$pr_newsletters_page,$pr_paypal_page,$pr_export_page,'bands');

if(in_array($_GET['page'],$pages))
{

	?>
	<!-- properties module wtz styles-->
	<link rel='stylesheet' href='<?bloginfo('url')?>/wp-content/plugins/properties/style_admin.css' type='text/css' media='all' />
	<link rel='stylesheet' href='<?bloginfo('url')?>/wp-content/plugins/properties/datepicker1.css' type='text/css' media='all' />
	<link rel="Stylesheet" href="<?bloginfo('url')?>/wp-content/plugins/properties/jquery-ui-1.7.2.custom.css" type="text/css" />
	<link rel="Stylesheet" href="<?bloginfo('url')?>/wp-content/plugins/properties/dateinput.css" type="text/css" />
	<!-- properties module wtz styles-->
	<?/*?><script type="text/javascript" src="<?bloginfo('url')?>/wp-content/plugins/properties/nicEditor/nicEdit.js"></script><?*/?>
<script src="<?bloginfo('template_url'); ?>/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src='<?bloginfo('url')?>/wp-content/plugins/properties/jquery.ui.js'></script>
<script language="JavaScript" type="text/javascript" src="<?bloginfo('url')?>/wp-content/plugins/properties/somescripting.js"></script>
<script src="http://cdn.jquerytools.org/1.2.5/full/jquery.tools.min.js"></script>
<!-- editor data -->
<link rel="Stylesheet" href="<?bloginfo('url')?>/wp-content/plugins/properties/jwysiwyg/jquery.wysiwyg.css" type="text/css" />

	<?
}

	   //pr_create_thumbs_for_old();
}

function pr_m_($string,$classes = "",$tag = "p")
{
	echo "<$tag class=\"$classes\">$string</$tag>";
}

function pr_edit_subform($field,$id = NULL,$db_table_name = NULL,$field_name = NULL,$field_value = NULL,$number_of_fields = 1,$field_values = NULL,$labels = NULL)
{
	global $pr_prefix,$wpdb,$pr_areas,$pr_area_types,$pr_prop_types;
	switch ($field) { // we select some of the basic fields for form building

	case "form_start":
		//if ($field_value == NULL) $_action = "admin.php?page=$_GET['page']";
			$_action = $field_value;
		?>
	<form name="<?echo $field_name;?>" id="<?echo $id?>" action="<?echo $_action;?>" method="post" enctype="multipart/form-data">
		<?
	break;
	case "form_end":
		?>
	</form>
		<?
	break;
	case "submit":
		if($field_name == NULL) $field_name = "Submit";
		if(is_admin())
		{
		?>
	<input type="submit" name="submit" value="<?echo $field_name;?>" class="button-primary" id="<?echo $id?>">
		<?} else {?>
	<input type=gtbfieldid"submit" name="submit" value="<?echo $field_name;?>" class="submit" id="<?echo $id?>">
		<?}
	break;
	case "checkbox":
		if($id == NULL) $_value = 1;
			else $_value = $id;
		?>
		<input type="<?echo $field;?>" name="<?echo $field_name;?>" value="<?echo $_value;?>" <?if (1==$field_value) echo "checked";?> <?if ($id != NULL) echo "id=\"$field_name\"";?> />
		<?
	break;
	case "radiogroup":

		for ($i = 0;$i<$number_of_fields;$i++)
		{
			if ($field_values == NULL) $value = $i+1;
				else $value = $field_values[$i];
			?>
			<input type="radio" name="<?echo $field_name?>" id="<?echo $field_name.'_'.$i?>" value=<?echo $value?> <?if($field_value != NULL and $field_value == $value) echo "checked";?>><label for="<?echo $field_name.'_'.$i?>"><?echo $labels[$i]?></label>
			<?
		}

	break;
	case "select":
		?>
       
		<select name="<?echo $field_name?>" <?if ($id != NULL) echo "id=\"$id\"";?>>
		<?
		for ($i = 0;$i<$number_of_fields;$i++)
		{
			?>
			<option value="<?echo $field_values[$i]?>" <?if ($field_values[$i] == $field_value) echo "selected"?>><?echo $labels[$i]?></option>
			<?
		}
		?></select><?
	break;
	case "hidden": //some additional hidden fields
	?>
	<input type="hidden" name="<?echo $field_name?>" value="<?echo $field_value?>">
		<?
	break;
	case "textarea":
	?>
	<textarea name="<?echo $field_name?>" <?if ($id != NULL) echo "id=\"$id\"";?>><?echo $field_value?></textarea>
		<?
	break;
	default:
// none of the standard

	switch ($field) // we may add couple of other special fields for every projects, others are routine
	{
		case "area_type": // this will be drop down menu
			$results = $wpdb->get_results("SELECT ID,Name FROM ".$pr_area_types." ORDER BY order_a DESC, ID ASC");
			if ($id != NULL) $area_type = $wpdb->get_var($wpdb->prepare('SELECT type FROM '.$pr_areas.' WHERE ID = %d', $id));
			echo '<select name="'.$field_name.'">';
			foreach($results as $type)
			{
				?>
				<option value="<?echo $type->ID;?>" <?if($id != NULL and $type->ID == $area_type) echo "selected"?>>
				<?echo $type->Name?>
				</option>
				<?
			}
			echo '</select>';
		break;
		case "child_type": // this will be drop down menu
			$results = $wpdb->get_results('SELECT ID,Name FROM '.$pr_area_types.' ORDER BY order_a DESC, ID ASC');
			if ($id != NULL) $child_type = $wpdb->get_var($wpdb->prepare('SELECT child_type FROM '.$pr_areas.' WHERE ID = %d', $id));
			echo '<select name="'.$field_name.'">';
			foreach($results as $type)
			{
				?>
				<option value="<?echo $type->ID;?>" <?if($id != NULL and $type->ID == $child_type) echo "selected"?>>
				<?echo $type->Name?>



				</option>
				<?
			}
			echo '</select>';
		break;
		case "parent_id": // this will be drop down menu of areas for editing particular area
			if ($id != NULL) {
				$pid = $wpdb->get_var($wpdb->prepare('SELECT parent_id FROM '.$pr_areas.' WHERE ID = %d',$id));
				$disabled_pid = $id;
			} else {$pid = NULL;$disabled_pid = NULL;}
			//$results = $wpdb->get_results('SELECT ID,name FROM '.$pr_areas);
			$results = $wpdb->get_results('SELECT a.ID, a.name, a.parent_id FROM '.$pr_areas.' a WHERE a.active = 1 ORDER BY a.parent_id ASC, a.name ASC, a.ID ASC');
			echo '<select name="'.$field_name.'">';
			?>
				<option value="0">
				No parent
				</option>
			<?
			pr_area_tree_dropdown(0,0,&$results,0,NULL,$pid,$disabled_pid);
			echo '</select>';
		break;
		case "areas": // this will be drop down menu, at the moment it's the same as parent_id case
		//used for add area form
			/*
			if ($id != NULL) {
				$pid = $wpdb->get_var($wpdb->prepare('SELECT parent_id FROM '.$pr_areas.' WHERE ID = %d',$id));
				$disabled_pid = $id;
			} else {$pid = NULL;$disabled_pid = NULL;}
			*/
			//$results = $wpdb->get_results('SELECT ID,name FROM '.$pr_areas);
			$results = $wpdb->get_results('SELECT a.ID, a.name, a.parent_id FROM '.$pr_areas.' a WHERE a.active = 1 ORDER BY a.parent_id ASC, a.name ASC, a.ID ASC');
			echo '<select name="'.$field_name.'">';
			echo '<option value=NULL>Select one</option>';
			pr_area_tree_dropdown(0,0,&$results,0,NULL,$id,NULL);
			echo '</select>';
		break;
		case "areas_front": // used for widget
			if (isset($_GET['exclude'])) {
			$results = $wpdb->get_results('SELECT a.ID, a.name, a.parent_id FROM '.$pr_areas.' a WHERE a.active = 1 AND a.ID NOT IN ('.$_GET['exclude'].') ORDER BY a.parent_id ASC, a.name ASC, a.ID ASC');}
			elseif($field_values != NULL) { // include values
				$results = $wpdb->get_results('SELECT a.ID, a.name, a.parent_id FROM '.$pr_areas.' a WHERE a.active = 1 AND a.ID IN ('.$field_values.') ORDER BY a.parent_id ASC, a.name ASC, a.ID ASC');
			}
			else {$results = $wpdb->get_results('SELECT a.ID, a.name, a.parent_id FROM '.$pr_areas.' a WHERE a.active = 1 ORDER BY a.parent_id ASC, a.name ASC, a.ID ASC');}
			echo '<select name="'.$field_name.'">';
			if ($field_values == NULL) echo '<option value="0">All</option>'; // ⠽��볷ॠ컠豯糥젩nclude properties 蠭堨�ﮫ�糥적ll
			pr_area_tree_dropdown(0,0,&$results,0,NULL,$id,NULL);
			echo '</select>';
		break;
		case "num_of_bedrooms":
			?>
			<select name="<?echo $field_name?>">
			<?
			for($i = 0;$i<$field_value+1;$i++)
			{
			?>
				<option value="<?echo $i?>" <?if ($id!=NULL and $id == $i) echo "selected";?>><?echo $i?></option>
			<?

			}
			?>
			</select>
			<?
		break;
		case "prop_types":
pr_tree_dropdown($pr_prop_types,'ID','parent','Name','pr_prop_types',$id);
			/*
			$prop_types = $wpdb->get_results('SELECT ID,Name from '.$pr_prop_types);
			echo '<select name=\'pr_prop_types\'>';
			echo '<option value=0>Not selected</option>';
			foreach ($prop_types as $type)
			{
				echo '<option value='.$type->ID;
				if ($id != NULL and $id == $type->ID) echo ' selected';
				echo '>'.$type->Name.'</option>';
			}
			echo '</select>';
			*/
		break;
		case "let_status":
			global $selling_state;
			?>
			<select name="<?echo $field_name?>">
			<option value="1" <?if($id==1) echo "selected"?>><?echo $selling_state[1]['name']?></option>
			<option value="2" <?if($id==2) echo "selected"?>><?echo $selling_state[2]['name']?></option>
			<option value="3" <?if($id==3) echo "selected"?>><?echo $selling_state[3]['name']?></option>
			</select>
			<?
		break;
		case "sale_status":
			global $selling_state;
			?>
			<select name="<?echo $field_name?>">
			<option value="4" <?if($id==4) echo "selected"?>><?echo $selling_state[4]['name']?></option>
			<option value="5" <?if($id==5) echo "selected"?>><?echo $selling_state[5]['name']?></option>
			<option value="2" <?if($id==2) echo "selected"?>><?echo $selling_state[2]['name']?></option>
			</select>
			<?
		break;
		case "prop_tenure":
			global $property_tenure;
			?>
			<select name="<?echo $field_name?>">
			<?foreach($property_tenure as $k=>$tenure){?>
			<option value="<?echo $k?>" <?if($id==$k) echo "selected"?>><?echo $tenure['name']?></option>
			<?}?>
			</select>
			<?

		break;
		case "city":
			$cities = $wpdb->get_results("SELECT c.ID, c.name FROM ".$pr_areas." c LEFT JOIN ".$pr_area_types." t ON c.type = t.ID WHERE t.Name = 'City'");
			?>
			<select name="<?echo $field_name?>">
			<?
			foreach($cities as $city)
			{
				?><option value=<?echo $city->ID?> <?if($city->ID == $id) echo "selected"?>><?echo $city->name?></option><?
			}

			?>
			</select>
			<?
		break;
		case "county":
			$cities = $wpdb->get_results("SELECT c.ID, c.name FROM ".$pr_areas." c LEFT JOIN ".$pr_area_types." t ON c.type = t.ID WHERE t.Name = 'County'");
			?>
			<select name="<?echo $field_name?>">
			<?
			foreach($cities as $city)
			{
				?><option value=<?echo $city->ID?> <?if($city->ID == $id) echo "selected"?>><?echo $city->name?></option><?
			}
			?>
			</select>
			<?
		break;
		case "country":
			$countries = $wpdb->get_results("SELECT c.ID, c.name FROM ".$pr_areas." c LEFT JOIN ".$pr_area_types." t ON c.type = t.ID WHERE t.Name = 'Country'");
			?>

			<select name="<?echo $field_name?>">
			<?
			foreach($countries as $country)
			{
				?><option value=<?echo $country->ID?> <?if($country->ID == $id) echo "selected"?>><?echo $country->name?></option><?
			}
			?>
			</select>
			<?
		break;
		case "area":
			$cities = $wpdb->get_results("SELECT c.ID, c.name FROM ".$pr_areas." c LEFT JOIN ".$pr_area_types." t ON c.type = t.ID WHERE t.Name = 'Area'");
			?>
			<select name="<?echo $field_name?>">
			<?
			foreach($cities as $city)
			{
				?><option value=<?echo $city->ID?> <?if($city->ID == $id) echo "selected"?>><?echo $city->name?></option><?
			}
			?>
			</select>
			<?
		break;
		case "upload_form":
			if($field_name == $pr_prefix.'pic_upload') pr_swfupload_form('pics','pic');
			else {?><input type="file" name="<?echo $field_name?>" <?if ($id != NULL) echo "id=$id";?>><?}
		break;
		case "pictures_list":
		global $pr_upload_pictures,$pr_pic_table,$pr_prefix,$pr_img_show_folder,$pr_upload_thumbs,$pr_img_show_folder_thumbs;

		if($db_table_name==NULL)$db_table_name = $pr_pic_table;
		if($field_name==NULL) $field_name = "img_name";
			$results = $wpdb->get_results($wpdb->prepare('SELECT ID,'.$field_name.',main FROM '.$db_table_name.' WHERE prid = %d',$id));
			////$wpdb->show_errors();
			////$wpdb->print_error();
			foreach($results as $uploaded)
			{
				?>
				<div class="uploaded_img">
				<img src="<?
					if(file_exists($pr_upload_thumbs.$uploaded->$field_name))
					echo $pr_img_show_folder_thumbs.$uploaded->$field_name;
					else echo $pr_img_show_folder.$uploaded->$field_name;

					?>">
				<input type="checkbox" name="<? echo $pr_prefix.$field_name?>_del[]" value="<?echo $uploaded->ID?>"> delete
				<input type="radio" name="<? echo $pr_prefix.'main'?>_pic" value="<?echo $uploaded->ID?>" <?if ($uploaded->main == 1) echo "'checked'";?>> main
				</div>
				<?
			}
		break;
		case "files_list":
		global $pr_upload_files,$pr_files_table,$pr_prefix,$pr_file_show_folder;
		if($db_table_name==NULL)$db_table_name = $pr_files_table;
		if($field_name==NULL) $field_name = "file_name";
			$results = $wpdb->get_results($wpdb->prepare('SELECT ID,title,file_name FROM '.$db_table_name.' WHERE prid = %d',$id));
			foreach($results as $uploaded)
			{

				?>
				<div class="uploaded_img">
				<a href="<?echo $pr_file_show_folder.$uploaded->file_name;?>">
        <?
        if ($uploaded->title != NULL)
        echo $uploaded->title;
        else echo $uploaded->file_name;
        ?>
        </a>
				<input type="checkbox" name="<? echo $pr_prefix.$field_name?>_del[]" value="<?echo $uploaded->ID?>"> delete
				</div>
				<?
			}
		break;
		case "files_list_edit":
		global $pr_upload_files,$pr_files_table,$pr_prefix,$pr_file_show_folder;
		if($db_table_name==NULL)$db_table_name = $pr_files_table;
		if($field_name==NULL) $field_name = "file_name";
			$results = $wpdb->get_results($wpdb->prepare('SELECT ID,title,file_name FROM '.$db_table_name.' WHERE prid = %d',$id));
			foreach($results as $uploaded)
			{
				?>
				<div class="uploaded_file">
				<input type="text" name="<? echo $pr_prefix.$field_name?>_title[]" value="<?echo $uploaded->title;?>">
				<input type="hidden" name="<? echo $pr_prefix.$field_name?>_index[]" value="<?echo $uploaded->ID;?>">
        <a href="<?echo $pr_file_show_folder.$uploaded->file_name;?>">
        <?
        if ($uploaded->title != NULL)
        echo $uploaded->title;
        else echo $uploaded->file_name;
        ?>
        </a>
				<input type="checkbox" name="<? echo $pr_prefix.$field_name?>_del[]" value="<?echo $uploaded->ID?>"> delete
				</div>
				<?
			}
		break;
		case "video_block":
		global $pr_video_table;
		if($db_table_name==NULL)$db_table_name = $pr_video_table;
		if($id!=NULL)
		{
		$result = $wpdb->get_results($wpdb->prepare('SELECT ID,title,url,descr,yt_id FROM '.$db_table_name.' WHERE prid = %d',$id));
		////$wpdb->show_errors();
		////$wpdb->print_error();
		}
			?>
			<?
      /*
      pr_m_('Title');?>
			<p><input type="text" name="pr_video_title" value="<?if($id!=NULL and sizeof($result) != 0) echo $result[0]->title;?>"></p>
			<?pr_m_('URL');?>
			<p><input type="text" name="pr_video_url" value="<?if($id!=NULL and sizeof($result) != 0) echo $result[0]->url;?>"></p>
			<?pr_m_('Description');?>
			<p><textarea name="pr_video_descr"><?if($id!=NULL and sizeof($result) != 0) echo $result[0]->descr;?></textarea></p>
			<?*/
			pr_m_('You tube ID');?>
			<p>
      <?pr_edit_subform('text',NULL,NULL,'pr_yt_id',$result[0]->yt_id);?>
      </p>
      <?
			if ($id != NULL and sizeof($result) != 0)
			{
			?>
      <object width="160" height="100">
      <param name="movie" value="http://www.youtube.com/v/<?echo $result[0]->yt_id?>?fs=1&amp;hl=en_US"></param>
      <param name="allowFullScreen" value="true"></param>
      <param name="allowscriptaccess" value="always"></param>
      <embed src="http://www.youtube.com/v/<?echo $result[0]->yt_id?>?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="160" height="100"></embed>
      </object>
      <?
			pr_m_('Delete video');?>
			<p><input type="checkbox" name="pr_video_del[]" value="<?echo $id?>"> delete</p>
			<?}
		break;
		case "bands":
			$_bands = $wpdb->get_results("SELECT * FROM $db_table_name");
			?>
			<select name="<?echo $field_name?>">
			<?
				foreach($_bands as $band)
				{
					if ($band->ID == $field_value) echo "<option selected value=\"$band->ID\">$band->Name</option>";
						else echo "<option value=\"$band->ID\">$band->Name</option>";
				}
			?>
					<option value="0" <?if ($field_value == 0) echo "selected"?>>N/A</option>
			</select>
			<?
		break;
		case "bands_only_show":
			if ($field_value == 0) echo "N/A";
			 else{
        $_band = $wpdb->get_var("SELECT Name FROM $db_table_name WHERE ID = $field_value");
        echo $_band;
			    }
		break;
		// this is among default as it's just a text input
		case "text_input":
		?>
		<input type="text" name="<?echo $field_name?>" value="<?echo $field_value;?>" <?if ($id != NULL) echo "id=\"$id\"";?>>
		<?
		break;
		case "user_list":
			$users = $wpdb->get_results("SELECT ID, user_login, user_email FROM $wpdb->users");
			//$wpdb->show_errors();
			//$wpdb->print_error();
			?>
			<select name="<?echo $field_name?>">
			<?
			foreach($users as $user)
			{
				$info = get_userdata($user->ID);
				echo "<option value=\"$user->ID\"";
				if ($field_value != NULL and $field_value == $user->ID) echo "selected";
				elseif($field_value == NULL and 1 == $user->ID) echo "selected";
				echo ">$user->user_login, $info->first_name, $info->last_name, $user->user_email</option>";
			}
			?>
			</select>
			<?
		break;
		case "user_list_all":
			$users = $wpdb->get_results("SELECT ID, user_login, user_email FROM $wpdb->users");
			//$wpdb->show_errors();
			//$wpdb->print_error();
			?>
			<select name="<?echo $field_name?>">
			<option value="all">All</option>
			<?
			foreach($users as $user)
			{
				$info = get_userdata($user->ID);
				echo "<option value=\"$user->ID\"";
				if ($field_value != NULL and $field_value == $user->ID) echo "selected";
				elseif($field_value == NULL and 1 == $user->ID) echo "selected";
				echo ">$user->user_login, $info->first_name, $info->last_name, $user->user_email</option>";
			}
			?>
			</select>
			<?

		break;
		case "bank_sortcode":
			if ($field_value != NULL)
			{
				list($in1,$in2,$in3) = explode("/",$field_value);
			}
			?>
			<input class="short_input" type="text" name="<?echo $field_name?>[]" value="<?if($field_value!=NULL) echo $in1;?>" maxlength="2"> / <input class="short_input" type="text" name="<?echo $field_name?>[]" value="<?if($field_value!=NULL) echo $in2;?>" maxlength="2"> / <input class="short_input" type="text" name="<?echo $field_name?>[]" value="<?if($field_value!=NULL) echo $in3;?>" maxlength="2">
			<?
		break;
		case "sort_drop_down":
		$num_of_fields = 2;
		$fields_vals = array('ASC','DESC');
		$fields_labels = array('ascending','descending');

		pr_m_('Sort by price');
		pr_edit_subform('select',NULL,NULL,'sort_by_price',$_SESSION['sort_by_price'],$num_of_fields,$fields_vals,$fields_labels);

		break;
		case "price_sort_form":
		?>
		<div class="sort_order">
		<?
		pr_edit_subform('form_start');
		pr_edit_subform('sort_drop_down');
		pr_edit_subform('submit',NULL,NULL,'sort');
		pr_edit_subform('form_end');
		?>
		</div>
		<?
		break;
		case "property_type":
			$num_of_fields = 3;
			$fields_vals = array(0,1,2);
			$fields_labels = array('All','Lettings','Sales');

			//pr_m_('Sort by price');
			pr_edit_subform('select',NULL,NULL,'type_filter',$field_value,$num_of_fields,$fields_vals,$fields_labels);
			break;

		case "text": // this one is a text input
if ($id != NULL and $db_table_name != NULL) $result = $wpdb->get_results("SELECT ".$field." FROM ".$db_table_name." WHERE ID = ".$id.";");
	?>
<input type="text" id="<?echo $id?>" name="<?echo $field_name?>" value="<?if ($id != NULL) echo $result[0]->$field;if($field_value!=NULL) echo $field_value;?>">
	<?
		break;
		default: // this one is a text input
if ($id != NULL) $result = $wpdb->get_results("SELECT ".$field." FROM ".$db_table_name." WHERE ID = ".$id.";");

	?>
<input type="text" name="<?echo $field_name?>" value="<?if ($id != NULL) echo $result[0]->$field;if($field_value!=NULL) echo $field_value;?>">
	<?
		break;
	}

	break;
		}
}


function pr_add_area_types_form()
{
	?>
	<div class="pr_block">
	<div class="metabox-holder">
		<div class="postbox widefat">
<h3 class="manage-column column-title"><span>Add area type</span></h3>
		<div class="inside">
	<?
	pr_edit_subform("form_start");
	?><p>Name:<?pr_edit_subform("text",NULL,NULL,"pr_area_type_name");?></p><?
	?><p>Order:<?pr_edit_subform("text",NULL,NULL,"pr_area_type_order");?></p><?
	pr_edit_subform("hidden",NULL,NULL,"action","area_type_add");
	?><p><?pr_edit_subform("submit");?></p><?
	pr_edit_subform("form_end");
	?>
		</div>
		</div>

	</div>
	</div>
	<?
}
function pr_show_area_types()
{
global $wpdb,$pr_area_types;
if (isset($_POST['action']))
{
	switch ($_POST['action'])

	{
		case "area_type_edit":pr_update_area_types($_POST['area_type_id'],$_POST['pr_area_type_name'],$_POST['pr_area_type_order_a']);break;
		case "area_type_add":pr_add_area_types($_POST['pr_area_type_name'],$_POST['pr_area_type_order']);break;
		//case "area_type_delete":pr_delete_area();break; this wo'nt work as area_delete is in _GET not _POST array. we check it separately
	}
}
if (isset($_GET['action']) and $_GET['action'] == 'area_type_delete')
{
	pr_delete_area_types($_GET['area_type_id']);
}

pr_add_area_types_form();
$results = $wpdb->get_results('SELECT ID,Name,order_a FROM '.$pr_area_types.' ORDER BY order_a DESC;');
// checking for editing some entry
if (isset($_GET['action']) and $_GET['action'] == "area_type_edit")
{
	pr_edit_subform("form_start",NULL,NULL,"edit_area_type_form","admin.php?page=".$_GET['page']);
}
?>
<table class="widefat">
<thead>
<tr>
	<th class="manage-column column-title">#</th>
	<th class="manage-column column-title">Name</th>
	<th class="manage-column column-title">Order</th>
	<th class="manage-column column-title">Action</th>
</tr>
</thead>
<tbody>
<?
foreach ($results as $area_type)
	{
	if(isset($_GET['area_type_id']) and $_GET['area_type_id'] == $area_type->ID)
	{	$edit_this = true;
	} else $edit_this = false;
?>
<tr>
	<td><a name="<?echo $area_type->ID;?>" /><?echo $area_type->ID;?></td>

	<td><?if ($edit_this==true)
		{
pr_edit_subform("Name",$_GET['area_type_id'],$pr_area_types,'pr_area_type_name',NULL);
		} else	echo $area_type->Name;?>
	</td>

	<td><?if ($edit_this==true)

		{
pr_edit_subform("order_a",$_GET['area_type_id'],$pr_area_types,'pr_area_type_order_a',NULL);
		} else	echo $area_type->order_a;?>
	</td>

	<td>
<a href="javascript:sureness('admin.php?page=<?echo $_GET['page']?>&action=area_type_delete&area_type_id=<?echo $area_type->ID;?>')">Delete</a> |
		<?
		if ($edit_this==true)
		{
pr_edit_subform("submit");
pr_edit_subform("hidden",NULL,NULL,'action',$_GET['action']);
pr_edit_subform("hidden",NULL,NULL,'area_type_id',$_GET['area_type_id']);
		} else {?>
<a href="admin.php?page=<?echo $_GET['page']?>&action=area_type_edit&area_type_id=<?echo $area_type->ID;?>#<?echo $area_type->ID;?>">Edit</a>
<?}?>

	</td>
</tr>
<?
	}

?>
</tbody>
</table>
<?
// checking for editing some entry
if (isset($_GET['action']) and $_GET['action'] == "area_type_edit")
{
	pr_edit_subform("form_end");
}
}
function pr_update_area_types($id,$name,$order)
{ global $wpdb, $pr_area_types;
	$wpdb->query($wpdb->prepare("
	UPDATE ".$pr_area_types."
	SET Name = %s, order_a = %d
	WHERE ID = %d
	", $name, $order, $id));
	//$wpdb->show_errors();
	//echo "update function";
}
function pr_add_area_types($name,$order_a)
{global $wpdb,$pr_area_types;
	$wpdb->query($wpdb->prepare("
	INSERT INTO $pr_area_types
	(ID,Name,order_a)
	values (NULL, '%s', %d)
	",$name,$order_a));
	//$wpdb->show_errors();
	////$wpdb->print_error();
	//echo "add function";
}
function pr_delete_area_types($id)
{
	global $wpdb, $pr_area_types;
	$wpdb->query($wpdb->prepare('
	DELETE FROM '.$pr_area_types.' WHERE ID = %d
	', $id));
	//$wpdb->show_errors();
	//echo "delete function";
}

function pr_area_tree_dropdown($pid,$lvl,$results,$start,$stop = NULL, $selected_pid = NULL, $disabled_pid = NULL)
{ global $pr_areas, $pr_area_types;


	//foreach($results as $area)
	//$start = 0;//䫿 �볷ॢ ꮣ䠠䥲蠢��堰�嫥鬠�મ堡�⠥�))
	if ($stop == NULL) $stop = sizeof($results);
	for ($i = $start;$i<$stop;$i++)
	{
	$area = $results[$i];
	if ($area->parent_id > $pid)
		{
		$stop = $i;
		}
		else
		{
?>
<option
	<?if($selected_pid != NULL and $selected_pid == $area->ID) {echo "selected";}
	if($disabled_pid != NULL and $disabled_pid == $area->ID) {echo "disabled";}?>
	value="<?echo $area->ID;?>">
<?echo str_repeat("-",$lvl);echo $area->name;?>
</option>
<?
	$child_id = pr_find_child($area->ID,$i,$stop,&$results);
	//print_r($child_id);
	if($child_id != false)
		{
			$lvl++;
			pr_area_tree_dropdown($area->ID,$lvl,&$results,$child_id,$stop,$selected_pid);
			$lvl--;
		}
		//if($pid != 0) {unset($results[$i]);$i--;$stop--;}
		}
	}
}

function pr_update_multiple_items_field($field_name,$table_name,$value_selected,$value_non_selected,$ids_arr,$id_field_name) // this function is for multiple checkbox inputs update

{
	global $wpdb;
	$ids = pr_array_list($ids_arr);
	$wpdb->query("UPDATE $table_name SET $field_name = $value_selected WHERE $id_field_name IN ($ids)");
	//$wpdb->show_errors();
	//$wpdb->print_error();
	$wpdb->query("UPDATE $table_name SET $field_name = $value_non_selected WHERE $id_field_name NOT IN ($ids)");
	//$wpdb->show_errors();
	//$wpdb->print_error();

}
function pr_update_area($id,$name,$type,$child_type,$parent_id,$active)
{ global $wpdb, $pr_areas, $pr_prefix, $pr_area_codes;
	$wpdb->query($wpdb->prepare("
	UPDATE ".$pr_areas."
	SET name = %s, type = %d, child_type = %d, parent_id = %d, active = %d
	WHERE ID = %d
	", $name, $type, $child_type, $parent_id, $active, $id));
	$_area_codes = "SELECT COUNT(code) FROM $pr_area_codes WHERE area_id = $id";
	$_area_codes = $wpdb->get_var($_area_codes);
	if ($_area_codes > 0)
		$wpdb->query($wpdb->prepare("UPDATE $pr_area_codes SET code = '%s' WHERE area_id = $id",$_POST[$pr_prefix.'area_code']));
	else $wpdb->query($wpdb->prepare("INSERT INTO $pr_area_codes (ID,code,area_id) values (NULL, '%s', $id)",$_POST[$pr_prefix.'area_code']));
	//$wpdb->show_errors();
	//$wpdb->print_error();
	//echo "update function";
}
function pr_add_area($name,$type,$child_type,$parent_id,$active = NULL)
{global $wpdb,$pr_areas;
	$_such = $wpdb->get_var($wpdb->prepare("SELECT COUNT(ID) from $pr_areas WHERE name = '%s' AND parent_id = %d",$name,$parent_id));//we check whether we have such children already, it is prohibited
	if ($_such == 0){
	$wpdb->query($wpdb->prepare("INSERT INTO ".$pr_areas." (ID,name,parent_id,type,child_type,active) values (NULL, '%s', %d, %d, %d, %d)",$name,$parent_id,$type,$child_type,$active));
	} else pr_m_("Error! $name area already exists for parent ID $parent_id",'','h3');
	//$wpdb->show_errors();
	//$wpdb->print_error();
	//echo "add function",$name,$type,$child_type,$parent_id;
}
function pr_delete_area($id)
{
	global $wpdb, $pr_areas,$pr_properties;
	$pid = $wpdb->get_var($wpdb->prepare("SELECT parent_id from $pr_areas WHERE ID = %d",$id));
	//$wpdb->show_errors();
	//$wpdb->print_error();
	$wpdb->query($wpdb->prepare("UPDATE $pr_areas SET parent_id = $pid WHERE parent_id = %d",$id));//update children of the area
	//$wpdb->show_errors();
	//$wpdb->print_error();
	$wpdb->query($wpdb->prepare("UPDATE $pr_properties SET area = $pid WHERE area = %d",$id));//update properties of the area
	//$wpdb->show_errors();
	//$wpdb->print_error();
	$wpdb->query($wpdb->prepare('DELETE FROM '.$pr_areas.' WHERE ID = %d', $id));//finally we delte it
	//echo "delete function";

}
function pr_add_area_form()
{
	?>
	<div class="pr_block">
	<div class="metabox-holder">
		<div class="postbox widefat">
<h3 class="manage-column column-title"><span>Add area</span></h3>
		<div class="inside">
	<?
	pr_edit_subform("form_start");
	?>
	<p>Name:<?pr_edit_subform("text",NULL,NULL,"pr_area_name");?></p><?
	?><p>Area type:<?pr_edit_subform("area_type",NULL,NULL,"pr_area_type");?></p><?
	?><p>Child type:<?pr_edit_subform("child_type",NULL,NULL,"pr_area_child_type");?></p><?
	?><p>Parent id:<?pr_edit_subform("parent_id",NULL,NULL,"pr_area_parent_id");?></p><?
	?><p>Active:<?pr_edit_subform("checkbox",NULL,NULL,"pr_area_active");?></p><?
	pr_edit_subform("hidden",NULL,NULL,"action","area_add");
	?><p><?pr_edit_subform("submit");?></p>
	<?
	pr_edit_subform("form_end");
	?>
		</div>
		</div>
	</div>
	</div>
	<?
}
function pr_find_child($pid,$start,$stop,$results)
{
	$start = 0;//䫿 �볷ॢ ꮣ䠠䥲蠢��堰�嫥鬠�મ堡�⠥�))
	$answer = false;
	for ($i = $start;$i<$stop;$i++)
	{
		if($results[$i]->parent_id == $pid and $answer == false) {$answer = $i;}
	}
	return $answer;
}

function pr_show_area_tree($pid,$lvl,$results,$start,$stop = NULL)
{ global $pr_areas, $pr_area_types,$pr_prefix;
	//foreach($results as $area)
	//$start = 0;//䫿 �볷ॢ ꮣ䠠䥲蠢��堰�嫥鬠�મ堡�⠥�))
	if ($stop == NULL) $stop = sizeof($results);
	for ($i = $start;$i<$stop;$i++)
	{
	$area = $results[$i];
	if ($area->parent_id > $pid)
		{
		$stop = $i;
		}
		else
		{
	$edit_this = false;
	$_editing = false;
	if (isset($_GET['area_id']) and $_GET['action'] == 'area_edit')
	{
		if ($_GET['area_id'] == $area->ID) $edit_this = true;
		$_editing = true;
	}
?>
<tr>

	<td><a name="<?echo $area->ID;?>" /><?echo $area->ID;?></td>

	<td>
	<?if ($edit_this==true)
		{
pr_edit_subform("name",$_GET['area_id'],$pr_areas,$pr_prefix.'area_name',NULL);	// �� 볷�堧ଥ��� ���媱�報��ࢪ������孨�.
		} else {echo str_repeat("&nbsp;",$lvl);echo $area->name;}?>
	</td>

	<td>
	<?if ($edit_this==true)
		{
pr_edit_subform("area_type",$_GET['area_id'],$pr_areas,$pr_prefix.'area_type',NULL);
		} else	echo $area->type;?>
	</td>

	<td>
	<?if ($edit_this==true)
		{
pr_edit_subform("child_type",$_GET['area_id'],$pr_areas,$pr_prefix.'area_child_type',NULL);
		} else	echo $area->child_type;?>
	</td>

	<td><?if ($edit_this==true)
		{
pr_edit_subform("parent_id",$_GET['area_id'],$pr_areas,$pr_prefix.'area_parent_id',NULL);
		} else	echo $area->parent;?>
	</td>
	<td>
	<?$area_info = pr_get_area_info($area->ID);
	if ($edit_this==true)
		{
pr_edit_subform('text_input',null,null,$pr_prefix.'area_code',$area_info->code);
		} else	echo $area_info->code;
	?>
	</td>

	<td>
	<?if ($edit_this==true)
		{
pr_edit_subform("checkbox",NULL,NULL,'pr_area_active',$area->active);
		} else	{
			if ($_editing==true)
				{
					if (1==$area->active) echo 'yes'; else echo 'no';
				} else pr_edit_subform("checkbox",$area->ID,NULL,'pr_area_active_arr[]',$area->active);
			}
		?>
	</td>

	<td>
	<a class="deleteBtn" href="javascript:sureness('admin.php?page=<?echo $_GET['page']?>&action=area_delete&area_id=<?echo $area->ID;?>')">Delete</a> |
		<?
		if ($edit_this==true)
		{
pr_edit_subform("submit");
pr_edit_subform("hidden",NULL,NULL,'action',$_GET['action']);
pr_edit_subform("hidden",NULL,NULL,'area_id',$_GET['area_id']);
		} else {?>
<a class="editBtn" href="admin.php?page=<?echo $_GET['page']?>&action=area_edit&area_id=<?echo $area->ID;?>#<?echo $area->ID;?>">Edit</a>
<?}?>
	</td>

</tr>
<?
	$child_id = pr_find_child($area->ID,$i,$stop,&$results);
	//print_r($child_id);
	if($child_id != false)
		{
			$lvl++;
			pr_show_area_tree($area->ID,$lvl,&$results,$child_id,$stop);
			$lvl--;
		}
		//if($pid != 0) {unset($results[$i]);$i--;$stop--;}
		}
	}
}

function pr_get_area_info($id)
{
	global $wpdb,$pr_area_types,$pr_areas,$pr_prefix,$pr_area_codes;
	$sql = "SELECT a.name,t.name as type,a.parent_id,a.active,c.code
		FROM $pr_areas a LEFT JOIN $pr_area_types t
			ON a.type = t.ID
			LEFT JOIN $pr_area_codes c ON a.ID = c.area_id
			WHERE a.ID = %d
			LIMIT 0,1";
	$results = $wpdb->get_results($wpdb->prepare($sql,$id));
	//$wpdb->show_errors();
	//$wpdb->print_error();
	//print_r($results);
	if (sizeof($results)>0) {
		return $results[0];
	} else return false;
}
function pr_show_areas()
{
	global $wpdb,$pr_area_types,$pr_areas,$pr_prefix;
if (isset($_POST['pr_area_active_arr']))
{
	//echo 'updating all areas\' active flag<br>';
	pr_update_multiple_items_field('active',$pr_areas,1,0,$_POST['pr_area_active_arr'],'ID');
}
if (isset($_POST['action']))
{
	switch ($_POST['action'])
	{
		case "area_edit":
		if(!isset($_POST['pr_area_active'])) $active = 0; else $active = $_POST['pr_area_active'];
		pr_update_area($_POST['area_id'],$_POST['pr_area_name'],$_POST['pr_area_type'],$_POST['pr_area_child_type'], $_POST['pr_area_parent_id'],$active);break;
		case "area_add":
		if(!isset($_POST['pr_area_active'])) $active = 0; else $active = $_POST['pr_area_active'];
		pr_add_area($_POST['pr_area_name'],$_POST['pr_area_type'],$_POST['pr_area_child_type'],$_POST['pr_area_parent_id'],$active);break;
		//case "area_delete":pr_delete_area();break; this wo'nt work as area_delete is in _GET not _POST array. we check it separately
	}
}
if (isset($_GET['action']) and $_GET['action'] == 'area_delete')
{
	pr_delete_area($_GET['area_id']);
}
// form for adding new areas
pr_add_area_form();


$results = $wpdb->get_results('SELECT a.ID, a.name, t.Name as type, tt.Name as child_type, IF(a.parent_id != 0,ap.Name,"No") as parent, a.parent_id, a.active FROM '.$pr_areas.' a LEFT JOIN '.$pr_area_types.' t ON a.type = t.ID LEFT JOIN '.$pr_area_types.' tt ON a.child_type = tt.ID LEFT JOIN '.$pr_areas.' ap ON a.parent_id = ap.ID ORDER BY a.parent_id ASC, a.name ASC, a.ID ASC');



// checking for editing some entry
if (isset($_GET['action']) and $_GET['action'] == "area_edit")
{
	pr_edit_subform("form_start",NULL,NULL,"edit_area_form","admin.php?page=".$_GET['page']);
} else pr_edit_subform("form_start",NULL,NULL,"pr_area_general_form");//general form for activating areas

?>
<table class="widefat">
<thead>
<tr>
	<th class="manage-column column-title">#</th>
	<th class="manage-column column-title">Area Name</th>
	<th class="manage-column column-title">Area type</th>
	<th class="manage-column column-title">Child area type</th>
	<th class="manage-column column-title">Parent area</th>

	<th class="manage-column column-title">Area code</th>
	<th class="manage-column column-title">Active</th>
	<th class="manage-column column-title">Action</th>
</tr>
</thead>
<tbody>
<?
	pr_show_area_tree(0,0,&$results,0);
?>
</tbody>
</table>
<?
// checking for editing some entry
if (isset($_GET['action']) and $_GET['action'] == "area_edit")
{
	pr_edit_subform("form_end");
} else {
	pr_edit_subform("submit",NULL,NULL,"Activate/Deactivate");
	pr_edit_subform("form_end");// end of general form for areas
	}
}

////////////////// LETTINGS
function pr_letting_add($rent,$descr,$viewing,$refnum,$area,$type,$bedrooms,$bname,$dnumber,$street,$city,$county,$country,$pcode,$avalfrom,$displfrom,$active,$featured,$furnishing,$status)

{global $wpdb,$pr_properties,$pr_pic_table,$pr_files_table,$pr_video_table,$pr_prefix,$user_ID;
	if ($status==NULL) {
		$status = 2;
	}
	if(strlen($displfrom) <= 0||$displfrom=='0000-00-00')
      {
		//$displfrom = date('Y-m-d');
		$displfrom = NULL;
	} else {
		$displfrom = pr_date_save($displfrom);
	}
	if (strlen($avalfrom) > 0 ) {
		$avalfrom = pr_date_save($avalfrom);
	}

	if (isset($_POST['pr_user_id'])) $insert_user_id = $_POST['pr_user_id']; else {$insert_user_id = $user_ID;}
	$wpdb->query($wpdb->prepare("INSERT INTO ".$pr_properties." (ID,let_weekrent,let_monthrent,descr,viewarrange,refnumber,area,type,bedroomnum,addr_building_name,addr_door_number,addr_street,addr_city,addr_county,addr_country,addr_postcode,extra_date_avail_from,extra_date_displ_from,extra_active,extra_featured,extra_furnishing,extra_status,property_type,user_id,date_created,date_updated,bathroomnum,receptionroomnum) values (NULL,%d,%d,'%s','%s','%s',%d,%d,%d,'%s','%s','%s',%d,%d,%d,'%s','%s','%s',%d,%d,%d,%d,%d,%d,'".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."',%d,%d)",$rent,$_POST['pr_let_monthrent'],stripslashes($descr),stripslashes($viewing),stripslashes($refnum),$area,$type,$bedrooms,stripslashes($bname),stripslashes($dnumber),stripslashes($street),$city,$county,$country,stripslashes($pcode),$avalfrom,$displfrom,$active,$featured,stripslashes($furnishing),$status,1,$insert_user_id,$_POST['pr_bathroomnum'],$_POST['pr_receptionroomnum']));
	//$wpdb->show_errors();
	//$wpdb->print_error();
	//print_r($_FILES);
	$last_id = $wpdb->get_var("SELECT LAST_INSERT_ID();");
  if (is_admin())
	{
		if(isset($_POST['pr_paid'])) $_paid = 1; else $_paid = 0;
		if(isset($_POST['pr_approved'])) $_approved = 1; else $_approved = 0;
	if(strlen($_POST['pr_extra_date_displ_to']) <= 0||$_POST['pr_extra_date_displ_to']=='0000-00-00')
      {
		if ($displfrom!=NULL)
			{
			list($year,$month,$day) = explode('-',$displfrom);
			$year++;
			$_displ_to = $year.'-'.$month.'-'.$day;
			}
		else $_displ_to = NULL;

	} else {
		$_displ_to = $_POST['pr_extra_date_displ_to'];
		$_displ_to = pr_date_save($_displ_to);

	}
		$wpdb->query($wpdb->prepare("UPDATE $pr_properties SET paid = $_paid, approved = $_approved, extra_date_displ_to = '$_displ_to' WHERE ID = %d",$last_id));
	}
	// picture upload
	pr_transfer_tmp_pics($user_ID,$last_id); // pics transfer using swfuplader

	if($_FILES[$pr_prefix.'pic_upload'] != NULL)
	{
		$filename = pr_upload($last_id,'pic_upload');
		// 䮡ࢫ�嬠砯豼 ⠲࡫足 ꠰�譮ꍊ		if($filename != false)
			{
			$wpdb->query("INSERT INTO ".$pr_pic_table." (ID,prid,img_name) values (NULL,".$last_id.",'".$filename."');");
			//$wpdb->show_errors();
			//$wpdb->print_error();
			}
	}
	// file upload
	if($_FILES[$pr_prefix.'file_upload'] != NULL)
	{
		$filename = pr_upload($last_id,'file_upload');
		// 䮡ࢫ�嬠砯豼 ⠲࡫足 files
		if($_POST['pr_file_title'] != '')
      $filetitle = $_POST['pr_file_title'];
      else $filetitle = $filename;
		if($filename != false)


			{
			$wpdb->query("INSERT INTO ".$pr_files_table." (ID,prid,file_name,title) values (NULL,".$last_id.",'".$filename."','".$filetitle."');");
			//$wpdb->show_errors();
			//$wpdb->print_error();
			}
	}
	// entry to video table
	if($_POST[$pr_prefix.'yt_id'] != NULL)
	{
		pr_video_add_update($last_id);
	}
	// WTZ HOOK for Notifications
	global $pr_u_adds_npp;
	$pr_ids = array($last_id);
	do_action($pr_u_adds_npp, $pr_ids, $pr_u_adds_npp);
	global $pr_add_property_hook,$_err_ids;
if (sizeof($_err_ids)==0) {

	isset($_POST['band_to_buy']) ? $band_id=$_POST['band_to_buy'] : $band_id = 0;
	isset($_POST['basket_to_assign']) ? $basket_id=$_POST['basket_to_assign'] : $basket_id = 0;
	do_action($pr_add_property_hook, $insert_user_id, $last_id, $basket_id,$band_id);

	}

}
/**/
function pr_letting_update($rent,$descr,$viewing,$refnum,$area,$type,$bedrooms,$bname,$dnumber,$street,$city,$county,$country,$pcode,$avalfrom,$displfrom,$active,$featured,$furnishing,$status)
{global $wpdb,$pr_properties,$pr_pic_table,$pr_files_table,$pr_video_table,$pr_prefix,$user_ID;
	// ⻢夥젯� �� ﳱ��� ��� 屫蠢 䠲堵�୨���, ��诠 0000-00-00
	// ��堳��嬠䫿 ⻡ థ�� ⠯ꥠ蠰౱�몠�
	global $pr_tmp_properties;
	$pr_id = $_POST['pr_id'];
	if (isset($_POST['act']) and $_POST['act']=='preview') {
		$pr_properties = $pr_tmp_properties;
		$pr_id = $_POST['tmp_id'];
	}
//	$wpdb->show_errors();
//	$wpdb->print_error();
	if(strlen($displfrom) <= 0||$displfrom=='0000-00-00')
      {
		//$displfrom = date('Y-m-d');
		$displfrom = NULL;
	} else {
		$displfrom = pr_date_save($displfrom);
	}
	if (strlen($avalfrom) > 0 ) {
		$avalfrom = pr_date_save($avalfrom);
	}

/*
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) and $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
	$update_user_id = $_SESSION['user_id'];
} else
*/
if (isset($_POST['pr_user_id'])) {$update_user_id = $_POST['pr_user_id']; }
	else {$update_user_id = $user_ID;}

	$wpdb->query($wpdb->prepare("UPDATE ".$pr_properties." SET let_weekrent = %d,let_monthrent = %d,descr='%s',viewarrange='%s',refnumber='%s',area=%d,type=%d,bedroomnum=%d,addr_building_name='%s',addr_door_number='%s',addr_street='%s',addr_city=%d,addr_county=%d,addr_country=%d,addr_postcode='%s',extra_date_avail_from='%s',extra_date_displ_from='%s',extra_active=%d,extra_featured=%d,extra_furnishing=%d,extra_status=%d,property_type=%d, user_id=%d, date_updated = '".date('Y-m-d H:i:s')."',bathroomnum=%d,receptionroomnum=%d WHERE ID = %d",$rent,$_POST['pr_let_monthrent'],stripslashes($descr),stripslashes($viewing),stripslashes($refnum),$area,$type,$bedrooms,stripslashes($bname),stripslashes($dnumber),stripslashes($street),$city,$county,$country,stripslashes($pcode),$avalfrom,$displfrom,$active,$featured,stripslashes($furnishing),$status,1,$update_user_id,$_POST['pr_bathroomnum'],$_POST['pr_receptionroomnum'],$pr_id));

	// extra check for paid field. it should be accessed only from admin page
$curr_user = get_userdata($_SESSION['user_id']);

	$_update_granted = false;
	if (is_admin()){
		$_update_granted = true;
	} elseif($curr_user->user_level>=8) {
		$_update_granted = true;
	}
	if ($_update_granted == true)
	{
		if(isset($_POST['pr_paid'])) $_paid = 1; else $_paid = 0;
		if(isset($_POST['pr_approved'])) $_approved = 1; else $_approved = 0;
	if(strlen($_POST['pr_extra_date_displ_to']) <= 0||$_POST['pr_extra_date_displ_to']=='0000-00-00')
      {
		if ($displfrom!=NULL)
		{
			list($year,$month,$day) = explode('-',$displfrom);
			$year++;
			$_displ_to = $year.'-'.$month.'-'.$day;
		}
		else $_displ_to = NULL;
	} else {
		$_displ_to = $_POST['pr_extra_date_displ_to'];
		$_displ_to = pr_date_save($_displ_to);
	}
    $wpdb->query($wpdb->prepare("UPDATE $pr_properties SET paid = $_paid, approved = $_approved, extra_date_displ_to = '$_displ_to' WHERE ID = %d",$pr_id));

	}

	//print_r($_FILES);
	$last_id = $pr_id;
	// entry to video table
	/**/
	if($_POST[$pr_prefix.'yt_id'] != NULL)
	{
		pr_video_add_update($pr_id);
	}
if (!(isset($_POST['act']) and $_POST['act'] == 'preview')) {

	// picture upload
	pr_transfer_tmp_pics($user_ID,$last_id); // pics transfer using swfuplader

	if($_FILES[$pr_prefix.'pic_upload'] != NULL)
	{
		$filename = pr_upload($last_id,'pic_upload');
		// 䮡ࢫ�嬠砯豼 ⠲࡫足 ꠰�譮ꍊ		if($filename != false)
			{
			$wpdb->query("INSERT INTO ".$pr_pic_table." (ID,prid,img_name) values (NULL,".$last_id.",'".$filename."');");
			//$wpdb->show_errors();
			//$wpdb->print_error();
			}
	}
	// file upload
	if($_FILES[$pr_prefix.'file_upload'] != NULL)
	{
		$filename = pr_upload($last_id,'file_upload');
		// 䮡ࢫ�嬠砯豼 ⠲࡫足 files
		if($_POST['pr_file_title'] != '')
      $filetitle = $_POST['pr_file_title'];
      else $filetitle = $filename;
		if($filename != false)
			{
			$wpdb->query("INSERT INTO ".$pr_files_table." (ID,prid,file_name,title) values (NULL,".$last_id.",'".$filename."','".$filetitle."');");
			//$wpdb->show_errors();
			//$wpdb->print_error();
			}
	}

	// file title update
	$i = 0;
if (isset($_POST[$pr_prefix.'file_name_title']))
{
  foreach($_POST[$pr_prefix.'file_name_title'] as $_title)
	{
    $wpdb->query($wpdb->prepare("UPDATE $pr_files_table SET title = '%s' WHERE ID = %d",$_title,$_POST[$pr_prefix.'file_name_index'][$i]));
    $i++;

  }
}

	// update main picture
	if (isset($_POST['pr_main_pic']))
	{


		$wpdb->query($wpdb->prepare("UPDATE $pr_pic_table SET main = 0 WHERE prid = %d",$_POST['pr_id']));
		$wpdb->query($wpdb->prepare("UPDATE $pr_pic_table SET main = 1 WHERE ID = %d",$_POST['pr_main_pic']));
	}
	// delete files
	if(isset($_POST['pr_img_name_del']))
	{
		//print_r($_POST['pr_img_name_del']);
		pr_delete_files("img",$_POST['pr_img_name_del']);
	}
	if(isset($_POST['pr_file_name_del']))
	{
		//print_r($_POST['pr_file_name_del']);
		pr_delete_files("files",$_POST['pr_file_name_del']);
	}
	if(isset($_POST['pr_video_del']))
	{
		//print_r($_POST['pr_video_del']);
		pr_delete_files("video",$_POST['pr_video_del']);
	}
}
		global $pr_update_property_hook,$_err_ids;
if (sizeof($_err_ids)==0) {

	isset($_POST['band_to_buy']) ? $band_id=$_POST['band_to_buy'] : $band_id = 0;
	isset($_POST['basket_to_assign']) ? $basket_id=$_POST['basket_to_assign'] : $basket_id = 0;
	do_action($pr_update_property_hook, $update_user_id, $pr_id, $basket_id, $band_id);

}

}

function pr_letting_form($prid = NULL, $action = "add")
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
	isset($property[0]->user_id) ? $update_user_id = $property[0]->user_id : $update_user_id = NULL;
	switch ($action)
	{
		case "add":
			$title = "Add letting property";
		break;
		case "edit":
			$title = "Edit letting property";
		break;
	}
pr_init_property_form();
$_dates = array($property[0]->extra_date_displ_from,$property[0]->extra_date_displ_to,$property[0]->extra_date_avail_from);
pr_dateinput('input#Let_DisplayFrom, input#Let_DisplayTo, input#Let_AvailableFrom',$_dates);?>
<?//pr_m_($title);?>
	<?
// initializing swfupload fields
$_swfu_fields = array();
$_swfu_fields[] = array('pics','pic');
$_swfu_fields[] = array('files','file');
pr_swfupload_init($_swfu_fields);
	pr_edit_subform("form_start","letting_form");
	?>
	<div class="pr_block">
	<div class="metabox-holder">
		<div class="postbox widefat">
		<h3 class="manage-column column-title"><span>Let information</span></h3>
		<div class="inside">
			<p>Property owner</p>
			<p><?pr_edit_subform("user_list",NULL,NULL,"pr_user_id",$update_user_id);?></p>
			<p>Rent per week</p><p><input type="text" name="pr_let_weekrent" value="<?if($prid!=NULL) echo $property[0]->let_weekrent;?>"></p>
			<p>Rent per month</p><p><input type="text" name="pr_let_monthrent" value="<?if($prid!=NULL) echo $property[0]->let_monthrent;?>"></p>
			<p>Description</p><p>
			<div class="editor_container">
			<?php
			$_descr_text = '';


			if ($prid != NULL) {
				$_descr = $property[0]->descr;
			}
		//	the_editor(str_replace("\'", "'", str_replace('\&quot;', '"', stripslashes($_descr))),'pr_descr','pr_descr', true, 1);
			?>
			<textarea id="pr_descr" name="pr_descr"><?if($prid!=NULL) echo $property[0]->descr;?></textarea>
			<?
			pr_editor_init($_descr, '#pr_descr');
			?>
			</div>
			</p>
			<p>View arrangements</p><p><textarea name="pr_viewarrange"><?if($prid!=NULL) echo $property[0]->viewarrange;?></textarea></p>
			<p>Refference number</p><p><input type="text" name="pr_refnumber" value="<?if($prid!=NULL) echo $property[0]->refnumber;?>"></p>
			<p>Type*</p><p><?pr_edit_subform("prop_types",$type);?></p>
			<p>Number of bedrooms</p><p><?pr_edit_subform("num_of_bedrooms",$bedroomnum,NULL,"pr_bedroomnum",10);?></p>
			<p>Number of bathrooms</p><p><?pr_edit_subform("num_of_bedrooms",$bathroomnum,NULL,"pr_bathroomnum",10);?></p>
			<p>Number of reception rooms</p><p><?pr_edit_subform("num_of_bedrooms",$receptionroomnum,NULL,"pr_receptionroomnum",10);?></p>

		</div>
		</div>
	</div>
	</div>
	<div class="pr_block">
	<div class="metabox-holder">
		<div class="postbox widefat">
		<h3 class="manage-column column-title"><span>Address information</span></h3>
		<div class="inside">
			<p>Area*</p><p><?pr_edit_subform("areas",$area,NULL,'pr_area',NULL);?></p>
			<p>Building name</p><p><input type="text" name="pr_addr_building_name" value="<?if($prid!=NULL) echo $property[0]->addr_building_name;?>"></p>
			<p>Door number<span class="required">*</span></p><p><input type="text" id="door_number" name="pr_addr_door_number" value="<?if($prid!=NULL) echo $property[0]->addr_door_number;?>"></p>
			<p>Street<span class="required">*</span></p><p><input type="text" name="pr_addr_street" value="<?if($prid!=NULL) echo $property[0]->addr_street;?>"></p>
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
	</div>
	</div>
	<div class="pr_block">
	<div class="metabox-holder">
		<div class="postbox widefat">
		<h3 class="manage-column column-title"><span>Extra information</span></h3>
		<div class="inside">
			<?//if ($prid!=NULL){?>
			<?/*?>
			<p>Paid</p><p>
			<input type="checkbox" value="1" name="pr_paid" <?if ($prid!=NULL and $property[0]->paid == 1) echo "checked";?>>
			</p>
			<?*/?>
      <p>Approved</p><p>
			<input type="checkbox" value="1" name="pr_approved" <?if ($prid!=NULL and $property[0]->approved == 1) echo "checked";?>>
			</p>
			<?//}?>

			<p>Available from</p><p>
			<input type="text" value="<?if($prid!=NULL and $property[0]->extra_date_avail_from != '0000-00-00') echo pr_date_show($property[0]->extra_date_avail_from);?>" name="pr_extra_date_avail_from" id="Let_AvailableFrom"></p>
			<p>Display from</p><p>
			<input type="text" value="<?if($prid!=NULL and $property[0]->extra_date_displ_from != '0000-00-00') echo pr_date_show($property[0]->extra_date_displ_from);?>" name="pr_extra_date_displ_from" id="Let_DisplayFrom"></p>
			<p>Display to</p><p>
			<input type="text" value="<?if($prid!=NULL and $property[0]->extra_date_displ_to != '0000-00-00') echo pr_date_show($property[0]->extra_date_displ_to);?>" name="pr_extra_date_displ_to" id="Let_DisplayTo"></p>
			<?
      if ($prid!=NULL)
      {
          pr_m_('Created: '.pr_date_show($property[0]->date_created, true));
        if ($property[0]->date_updated!=NULL)
        {
          pr_m_('Last updated: '.pr_date_show($property[0]->date_updated, true));
        }
      }
      ?>
      <p>Is active</p><p><input type="checkbox" value="1" name="pr_extra_active" <?if ($prid!=NULL and $property[0]->extra_active == 1) echo "checked";?>></p>
			<p>Is featured</p><p><input type="checkbox" value="1" name="pr_extra_featured" <?if ($prid!=NULL and $property[0]->extra_featured == 1) echo "checked";?>></p>

			<p>Furnishing</p><p>
			<?/*?><input type="text" name="pr_extra_furnishing" value="<?if($prid!=NULL) echo $property[0]->extra_furnishing;?>"><?*/?>
			<?
			$furnishing_vals = array(0,1);
			$furnishing_labels = array('Unfurnished','Furnished');
			pr_edit_subform('select', NULL, NULL, 'pr_extra_furnishing', $property[0]->extra_furnishing,2,$furnishing_vals,$furnishing_labels);?>
			</p>
			<p>Status</p><p><?pr_edit_subform("let_status",$extra_status,NULL,"pr_extra_status");?></p>
		</div>
		</div>
	</div>
	</div>
	<div class="pr_block">
	<div class="metabox-holder">
		<div class="postbox widefat">
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
	if ($action == 'edit') {
		$_address_line = pr_get_prop_address($prid);
		pr_print_button_forms($prid,$_address_line);
	}
	pr_edit_subform("form_end");
	pr_preview_button("letting_form",1,"Preview");

}
function pr_upload($id = NULL,$type = 'pic_upload',$filename = NULL)
{global $pr_prefix,$pr_upload_pictures,$pr_upload_files,$pr_upload_thumbs;
	if (isset($_FILES[$pr_prefix.$type]) and $_FILES[$pr_prefix.$type]['name'] != ''){
	switch($type)
	{
		case "pic_upload":
			$pr_upload = $pr_upload_pictures;
			if (strpos($_FILES[$pr_prefix.$type]['type'],"image") !== false) {
			$err = false;
			//$msg = 'File is ok';
			}	else {
			$msg = 'File isn\'t an image';
			//print_r($_FILES[$pr_prefix.$type]);
			$err = true;
			}
		break;
		case "file_upload":
			$pr_upload = $pr_upload_files;
				// ����䮯貥뼭�堯��ꨠ��䫨��謥���੫ࠨ 壮 �౸谥��, 豪뾷貼 砲嫼��.php
				// only .doc and .pdf
				$exts = array('doc','pdf','ppt');
				$ext = pr_file_extension($_FILES[$pr_prefix.$type]['name']);
				if ((strpos($_FILES[$pr_prefix.$type]['type'],'application/pdf') !== false || strpos($_FILES[$pr_prefix.$type]['type'],'application/octet-stream') !== false) and (in_array($ext,$exts)))
				{
					$err = false;
				} else {$msg = 'File is not appropriate';$err = true;}

		break;
	}
	$pid = $id;
	$filename = $pr_prefix.$pid."_".$_FILES[$pr_prefix.$type]['name'];
	$i = 0;
	while(file_exists($pr_upload.$filename))
	{
		$i++;
		$filename = $pr_prefix.$pid."_".$i."_".$_FILES[$pr_prefix.$type]['name'];
	}

	//echo strpos($_FILES[$so_prefix.$type]['type'],"image");
if ($err == false) {
	//pr_m_($msg);
	if(move_uploaded_file($_FILES[$pr_prefix.$type]['tmp_name'], $pr_upload.$filename))
	{
	if ($type=='pic_upload')
	{
	//thumbnail creation
		$_thumb = false;
		if (pr_thumbnail_create($filename) == true) $_thumb = true;
	}
	//pr_m_('File was uploaded');
	return $filename;
	}


}
else {
	pr_m_($msg);
	//print_r($_FILES);
	//print "</p>";
	return false;
}
	}
}
function pr_thumbnail_create($srcpic,$maxthumbw = 150,$maxthumbh = 130)

{
	global $pr_prefix,$pr_upload_pictures,$pr_upload_thumbs;
	// maximum thumbnails' width and height are got through function parameters
	if (!file_exists($pr_upload_pictures.$srcpic)) return false;
	list($width, $height) = getimagesize($pr_upload_pictures.$srcpic);
	if ($width > $maxthumbw || $height > $maxthumbh)
	{
	if($width >= $height)
	{
		$neww = $maxthumbw;
		$newh = round(($neww/$width)*$height,0);
	} else {
		$newh = $maxthumbh;
		$neww = round(($newh/$height)*$width,0);
			}
		$image_thumb = imagecreatetruecolor($neww, $newh);
		switch(exif_imagetype($pr_upload_pictures.$srcpic))
		{
			case IMAGETYPE_GIF:
				$image_created = imagecreatefromgif($pr_upload_pictures.$srcpic);
				imagecopyresampled($image_thumb,$image_created,0,0,0,0,$neww,$newh,$width,$height);
				imagegif($image_thumb,$pr_upload_thumbs.$srcpic);
			break;
			case IMAGETYPE_JPEG:
				$image_created = imagecreatefromjpeg($pr_upload_pictures.$srcpic);

				imagecopyresampled($image_thumb,$image_created,0,0,0,0,$neww,$newh,$width,$height);
				imagejpeg($image_thumb,$pr_upload_thumbs.$srcpic);
			break;

			case IMAGETYPE_PNG:
				$image_created = imagecreatefrompng($pr_upload_pictures.$srcpic);
				imagecopyresampled($image_thumb,$image_created,0,0,0,0,$neww,$newh,$width,$height);
				imagepng($image_thumb,$pr_upload_thumbs.$srcpic);
			break;
			case IMAGETYPE_BMP:
				$image_created = imagecreatefromwbmp($pr_upload_pictures.$srcpic);
				imagecopyresampled($image_thumb,$image_created,0,0,0,0,$neww,$newh,$width,$height);
				imagewbmp($image_thumb,$pr_upload_thumbs.$srcpic);
			break;
		}
	}
		return true;
}
function pr_prop_delete($id, $user_id = false)
{
	global $pr_properties,$wpdb,$pr_pic_table,$pr_video_table,$pr_files_table,$user_ID;
if ($user_id==false) {
	$user_id = $user_ID;
}
	// 䮡ࢨ�� �䠫孨堧௨�婠觠쥤蠠�࡫趠+ �ନ �੫� ��䠫貼
	//getting data from video, pic and files tables for current property
	//$videos = $wpdb->get_results($wpdb->prepare('SELECT ID FROM '.$pr_video_table.' WHERE prid = %d',$id));//we know that have only one row for each property in video table, so we can delete them rightaway
	/*
	//$wpdb->show_errors();
	//$wpdb->print_error();
	print_r($videos);
	$i = 0;
	foreach($videos as $video)
	{
		$video_arr[$i] = $video->ID;
		$i++;
	}
	*/
	//now we finally can delete files using previously written function
	$ids[0] = $id;
	pr_delete_files("video",$ids);
	//select from pics table to delete files
	$pics = $wpdb->get_results($wpdb->prepare('SELECT ID FROM '.$pr_pic_table.' WHERE prid = %d',$id));
	//$wpdb->show_errors();
	//$wpdb->print_error();
	if(sizeof($pics)!=0)
	{
	$i = 0;
	foreach($pics as $pic)
	{
		$pic_arr[$i] = $pic->ID;
		$i++;
	}
	//now we finally can delete files using previously written function
	pr_delete_files("img",$pic_arr);
	}
	//select from files table to delete files
	$files = $wpdb->get_results($wpdb->prepare('SELECT ID FROM '.$pr_files_table.' WHERE prid = %d',$id));
	//$wpdb->show_errors();
	//$wpdb->print_error();
	if(sizeof($files)!=0)
	{
	$i = 0;
	foreach($files as $file)
	{
		$file_arr[$i] = $file->ID;
		$i++;
	}
	//now we finally can delete files using previously written function
	pr_delete_files("files",$file_arr);
	}
	// check if there are any basket assigned to property
	$property_basket = prb_get_basket_for_property($id);
	// now we finally delete property entry
	$wpdb->query($wpdb->prepare('DELETE FROM '.$pr_properties.' WHERE ID=%d',$id));
	// check wether basket of deleted property is empty
	if ($property_basket != false) {
		if (prb_get_basket_used_slots($property_basket->basketid)==0) {// check if there are any properties assigned to basket
			prub_remove_basket_from_user_cart($user_id,$property_basket->basketid); // deleting basket from cart
		}
	}
	//$wpdb->show_errors();
	//$wpdb->print_error();
}
function pr_array_list($array)
{
	$size = sizeof($array);
	$line = "";
	$key = 0;
	//print_r($array);
	foreach ($array as $item)
	{
		if ($key != $size-1)
		{$line .= $item.',';}
		else {$line .= $item;}
	$key++;
	}
	return $line;
}
function pr_delete_files($type,$files)//files is an array of IDs
{global $wpdb,$pr_upload_files,$pr_upload_pictures,$pr_pic_table,$pr_files_table,$pr_video_table,$pr_upload_thumbs;
	switch($type)
	{
		case "video":
			// we actually only delete entry from DB
			$ids = pr_array_list($files);
			$table = $pr_video_table;
			$wpdb->query('DELETE FROM '.$table.' WHERE prid IN ('.$ids.')');
			//$wpdb->show_errors();
			//$wpdb->print_error();
		break;
		case "img":
			//delete files
			$ids = pr_array_list($files);
			$pics = $wpdb->get_results('SELECT img_name FROM '.$pr_pic_table.' WHERE ID IN ('.$ids.')');
			//$wpdb->show_errors();
			//$wpdb->print_error();
			foreach($pics as $pic)
			{
				if (file_exists($pr_upload_pictures.$pic->img_name)) unlink($pr_upload_pictures.$pic->img_name);
				if (file_exists($pr_upload_thumbs.$pic->img_name)) unlink($pr_upload_thumbs.$pic->img_name);
			}
			$table = $pr_pic_table;
			$wpdb->query('DELETE FROM '.$table.' WHERE ID IN ('.$ids.')');

		break;
		case "files":
			//delete files
			$ids = pr_array_list($files);
			$files = $wpdb->get_results('SELECT file_name FROM '.$pr_files_table.' WHERE ID IN ('.$ids.')');
			//$wpdb->show_errors();
			//$wpdb->print_error();
			foreach($files as $file)
			{
				unlink($pr_upload_files.$file->file_name);
			}
			$table = $pr_files_table;
			$wpdb->query('DELETE FROM '.$table.' WHERE ID IN ('.$ids.')');
		break;
	}
}


//////////////////SALES
function pr_sale_add($price,$descr,$viewing,$refnum,$area,$type,$bedrooms,$bname,$dnumber,$street,$city,$county,$country,$pcode,$avalfrom,$displfrom,$active,$featured,$furnishing,$status)
{global $wpdb,$pr_properties,$pr_pic_table,$pr_files_table,$pr_video_table,$pr_prefix,$user_ID;
	global $pr_tmp_properties;
	if ($status==NULL) {
		$status = 2;
	}
	if (isset($_POST['prop_tenure'])) {
		$tenure = $_POST['prop_tenure'];
	}
	$prid = NULL;
	if (isset($_GET['act']) and $_GET['act']=='preview') {
		$pr_properties = $pr_tmp_properties;
		$prid = $_GET['tmp_id'];
	}

	if(strlen($displfrom) <= 0||$displfrom=='0000-00-00')
      {
		$displfrom = date('Y-m-d');
	} else {
		$displfrom = pr_date_save($displfrom);
	}
	if (strlen($avalfrom) > 0 ) {
		$avalfrom = pr_date_save($avalfrom);
	}

if (isset($_POST['pr_band'])) $_pr_band = $_POST['pr_band'];
	else $_pr_band = NULL;
	if (isset($_POST['pr_user_id'])) $insert_user_id = $_POST['pr_user_id']; else {$insert_user_id = $user_ID;}
$wpdb->query($wpdb->prepare("
	INSERT INTO ".$pr_properties."
	(
	ID,
	sale_price,
	descr,
	viewarrange,
	refnumber,
	area,
	type,
	bedroomnum,
	addr_building_name,
	addr_door_number,
	addr_street,
	addr_city,

	addr_county,
	addr_country,
	addr_postcode,
	extra_date_avail_from,
	extra_date_displ_from,
	extra_active,
	extra_featured,
	extra_furnishing,
	extra_status,
	property_type,
	user_id,
	band_id,
	date_created,
	date_updated,
	bathroomnum,
	receptionroomnum,
	tenure)
	values (
	NULL,
	%d,
	'%s',
	'%s',
	'%s',
	%d,
	%d,
	%d,
	'%s',
	'%s',
	'%s',
	%d,
	%d,
	%d,
	'%s',
	'%s',
	'%s',
	%d,
	%d,
	%d,
	%d,
	%d,
	%d,
	%d,
	'".date('Y-m-d H:i:s')."',
	'".date('Y-m-d H:i:s')."',
	%d,
	%d,
	%d
	)",
$price,
stripslashes($descr),
stripslashes($viewing),
stripslashes($refnum),
$area,
$type,
$bedrooms,
stripslashes($bname),
stripslashes($dnumber),
stripslashes($street),
$city,
$county,
$country,
stripslashes($pcode),
$avalfrom,
$displfrom,
$active,
$featured,
stripslashes($furnishing),
$status,
2,
$insert_user_id,
$_pr_band,
$_POST['pr_bathroomnum'],
$_POST['pr_receptionroomnum'],
$tenure));
	//$wpdb->show_errors();
	//$wpdb->print_error();
	$last_id = $wpdb->get_var("SELECT LAST_INSERT_ID();");
  if (is_admin())
	{
		if(isset($_POST['pr_paid'])) $_paid = 1; else $_paid = 0;
		if(isset($_POST['pr_approved'])) $_approved = 1; else $_approved = 0;
	if(strlen($_POST['pr_extra_date_displ_to']) <= 0||$_POST['pr_extra_date_displ_to']=='0000-00-00')
      {
      if ($displfrom!=NULL)
			{
			list($year,$month,$day) = explode('-',$displfrom);
			$year++;
			$_displ_to = $year.'-'.$month.'-'.$day;
			}
		else $_displ_to = NULL;
	} else {
		$_displ_to = $_POST['pr_extra_date_displ_to'];
		$_displ_to = pr_date_save($_displ_to);
	}
		$wpdb->query($wpdb->prepare("UPDATE $pr_properties SET paid = $_paid, approved = $_approved, extra_date_displ_to = '$_displ_to' WHERE ID = %d",$last_id));

	}
  // picture upload
	pr_transfer_tmp_pics($user_ID,$last_id); // pics transfer using swfuplader

	if($_FILES[$pr_prefix.'pic_upload'] != NULL)
	{
		$filename = pr_upload($last_id,'pic_upload');
		// 䮡ࢫ�嬠砯豼 ⠲࡫足 ꠰�譮ꍊ		if($filename != false)
			{
			$wpdb->query("INSERT INTO ".$pr_pic_table." (ID,prid,img_name) values (NULL,".$last_id.",'".$filename."');");
			//$wpdb->show_errors();
			//$wpdb->print_error();
			}
	}
	// file upload
	if($_FILES[$pr_prefix.'file_upload'] != NULL)
	{
		$filename = pr_upload($last_id,'file_upload');
		// 䮡ࢫ�嬠砯豼 ⠲࡫足 files
		if($_POST['pr_file_title'] != '')
      $filetitle = $_POST['pr_file_title'];
      else $filetitle = $filename;
		if($filename != false)
			{
			$wpdb->query("INSERT INTO ".$pr_files_table." (ID,prid,file_name,title) values (NULL,".$last_id.",'".$filename."','".$filetitle."');");
			//$wpdb->show_errors();
			//$wpdb->print_error();
			}
	}

	// entry to video table
	if($_POST[$pr_prefix.'yt_id'] != NULL)
	{
		pr_video_add_update($last_id);
	}
	// WTZ HOOK for Notifications



	global $pr_u_adds_npp,$pr_u_adds_pp;
	$pr_ids = array($last_id);
	if (pr_check_chargeble($last_id)>0) {
		do_action($pr_u_adds_pp, $pr_ids, $pr_u_adds_pp);
	} else do_action($pr_u_adds_npp, $pr_ids, $pr_u_adds_npp);
	global $pr_add_property_hook,$_err_ids;
if (sizeof($_err_ids)==0) {

	isset($_POST['band_to_buy']) ? $band_id=$_POST['band_to_buy'] : $band_id = 0;
	isset($_POST['basket_to_assign']) ? $basket_id=$_POST['basket_to_assign'] : $basket_id = 0;
	do_action($pr_add_property_hook, $insert_user_id, $last_id, $basket_id,$band_id);
}
}
function pr_sale_update($price,$descr,$viewing,$refnum,$area,$type,$bedrooms,$bname,$dnumber,$street,$city,$county,$country,$pcode,$avalfrom,$displfrom,$active,$featured,$furnishing,$status)
{global $wpdb,$pr_properties,$pr_pic_table,$pr_files_table,$pr_video_table,$pr_prefix,$user_ID;
	global $pr_tmp_properties;
	$pr_id = $_POST['pr_id'];
	if (isset($_POST['act']) and $_POST['act']=='preview') {
		$pr_properties = $pr_tmp_properties;
		$pr_id = $_POST['tmp_id'];
	}
	if ($status==NULL) {
		$status = pr_get_prop_state($pr_id);
	}
	if (isset($_POST['prop_tenure'])) {

		$tenure = $_POST['prop_tenure'];
	} else $tenure = pr_get_prop_tenure($pr_id);
/*
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) and $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
	$update_user_id = $_SESSION['user_id'];
} else
*/
if (isset($_POST['pr_user_id'])) {$update_user_id = $_POST['pr_user_id']; }
	else {$update_user_id = $user_ID;}


if (isset($_POST['pr_band'])) $_pr_band = $_POST['pr_band'];
	else $_pr_band = NULL;

	if(strlen($displfrom) <= 0 || $displfrom=='0000-00-00')
      {
		$displfrom = date('Y-m-d');
	} else {
		$displfrom = pr_date_save($displfrom);
	}

	if (strlen($avalfrom) > 0 ) {
		$avalfrom = pr_date_save($avalfrom);
	}

$wpdb->query($wpdb->prepare("
	UPDATE ".$pr_properties."
		SET sale_price = %d,
			descr='%s',
			viewarrange='%s',
			refnumber='%s',
			area=%d,
			type=%d,
			bedroomnum=%d,
			addr_building_name='%s',
			addr_door_number='%s',
			addr_street='%s',
			addr_city=%d,
			addr_county=%d,
			addr_country=%d,
			addr_postcode='%s',
			extra_date_avail_from='%s',
			extra_date_displ_from='%s',
			extra_active=%d,
			extra_featured=%d,
			extra_furnishing=%d,
			extra_status=%d,
			property_type=%d,
			band_id=%d,
			user_id=%d,
			date_updated = '".date('Y-m-d H:i:s')."',
			bathroomnum=%d,
			receptionroomnum=%d,
			tenure=%d
		WHERE ID = %d",
	$price,
	stripslashes($descr),
	stripslashes($viewing),
	stripslashes($refnum),
	$area,
	$type,
	$bedrooms,
	stripslashes($bname),
	stripslashes($dnumber),
	stripslashes($street),
	$city,
	$county,
	$country,
	stripslashes($pcode),
	$avalfrom,
	$displfrom,
	$active,
	$featured,
	stripslashes($furnishing),
	$status,
	2,
	$_pr_band,
	$update_user_id,
	$_POST['pr_bathroomnum'],
	$_POST['pr_receptionroomnum'],
	$tenure,
	$pr_id));
	//$wpdb->show_errors();
	//$wpdb->print_error();
// extra check for paid field. it should be accessed only from admin page OR BY the admin
$curr_user = get_userdata($_SESSION['user_id']);

	$_update_granted = false;
	if (is_admin()){
		$_update_granted = true;
	} elseif($curr_user->user_level>=8) {
		$_update_granted = true;
	}
	if ($_update_granted == true)
	{
		if(isset($_POST['pr_paid'])) $_paid = 1; else $_paid = 0;
		if(isset($_POST['pr_approved'])) $_approved = 1; else $_approved = 0;
	if(strlen($_POST['pr_extra_date_displ_to']) <= 0 || $_POST['pr_extra_date_displ_to']=='0000-00-00')
      {
		if ($displfrom!=NULL)
			{
			list($year,$month,$day) = explode('-',$displfrom);
			$year++;
			$_displ_to = $year.'-'.$month.'-'.$day;
			}
		else $_displ_to = NULL;
	} else {
		$_displ_to = $_POST['pr_extra_date_displ_to'];
		$_displ_to = pr_date_save($_displ_to);
	}
       $wpdb->query($wpdb->prepare("UPDATE $pr_properties SET paid = $_paid, approved = $_approved, extra_date_displ_to = '$_displ_to' WHERE ID = %d",$pr_id));
	//$wpdb->show_errors();
	//$wpdb->print_error();
	}

	$last_id = $pr_id;
	// entry to video table
	/**/
	if($_POST[$pr_prefix.'yt_id'] != NULL)
	{
		pr_video_add_update($pr_id);
	}
if (!(isset($_POST['act']) and $_POST['act'] == 'preview')) {

	//print_r($_FILES);

	// picture upload
	pr_transfer_tmp_pics($user_ID,$last_id); // pics transfer using swfuplader

	if($_FILES[$pr_prefix.'pic_upload'] != NULL)
	{
		$filename = pr_upload($last_id,'pic_upload');
		// 䮡ࢫ�嬠砯豼 ⠲࡫足 ꠰�譮ꍊ		if($filename != false)
			{
			$wpdb->query("INSERT INTO ".$pr_pic_table." (ID,prid,img_name) values (NULL,".$last_id.",'".$filename."');");
			}
	}
	// file upload
	if($_FILES[$pr_prefix.'file_upload'] != NULL)
	{
		$filename = pr_upload($last_id,'file_upload');
		// 䮡ࢫ�嬠砯豼 ⠲࡫足 files
		if($_POST['pr_file_title'] != '')
      $filetitle = $_POST['pr_file_title'];
      else $filetitle = $filename;
		if($filename != false)
			{
			$wpdb->query("INSERT INTO ".$pr_files_table." (ID,prid,file_name,title) values (NULL,".$last_id.",'".$filename."','".$filetitle."');");
			//$wpdb->show_errors();
			//$wpdb->print_error();
			}
	}

		// file title update
	$i = 0;
if (isset($_POST[$pr_prefix.'file_name_title']))
{
  foreach($_POST[$pr_prefix.'file_name_title'] as $_title)
	{
    $wpdb->query($wpdb->prepare("UPDATE $pr_files_table SET title = '%s' WHERE ID = %d",$_title,$_POST[$pr_prefix.'file_name_index'][$i]));
    $i++;
  }
}


	// update main picture
	if (isset($_POST['pr_main_pic']))
	{
		$wpdb->query($wpdb->prepare("UPDATE $pr_pic_table SET main = 0 WHERE prid = %d",$_POST['pr_id']));
		$wpdb->query($wpdb->prepare("UPDATE $pr_pic_table SET main = 1 WHERE ID = %d",$_POST['pr_main_pic']));
	}
	// delete files
	if(isset($_POST['pr_img_name_del']))
	{
		//print_r($_POST['pr_img_name_del']);
		pr_delete_files("img",$_POST['pr_img_name_del']);
	}
	if(isset($_POST['pr_file_name_del']))
	{

		//print_r($_POST['pr_file_name_del']);
		pr_delete_files("files",$_POST['pr_file_name_del']);
	}
	if(isset($_POST['pr_video_del']))
	{
		//print_r($_POST['pr_video_del']);
		pr_delete_files("video",$_POST['pr_video_del']);
	}
}

		global $pr_update_property_hook,$_err_ids;
if (sizeof($_err_ids)==0) {

	isset($_POST['band_to_buy']) ? $band_id=$_POST['band_to_buy'] : $band_id = 0;
	isset($_POST['basket_to_assign']) ? $basket_id=$_POST['basket_to_assign'] : $basket_id = 0;
	do_action($pr_update_property_hook, $update_user_id, $pr_id, $basket_id, $band_id);
}

}
function pr_sales_form($prid = NULL, $action = "add")
{global $wpdb,$pr_areas,$pr_area_types,$pr_properties,$pr_prefix,$user_ID;


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
	isset($property[0]->user_id) ? $update_user_id = $property[0]->user_id : $update_user_id = NULL;
	switch ($action)
	{
		case "add":
			$title = "Add sale property";
		break;
		case "edit":
			$title = "Edit sale property";
		break;
	}
pr_init_property_form();

$_dates = array($property[0]->extra_date_displ_from,$property[0]->extra_date_displ_to,$property[0]->extra_date_avail_from);
pr_dateinput('input#Let_DisplayFrom, input#Let_DisplayTo, input#Let_AvailableFrom',$_dates);?>
<p><?//pr_m_($title);?></p>
	<?
// initializing swfupload fields
$_swfu_fields = array();
$_swfu_fields[] = array('pics','pic');
$_swfu_fields[] = array('files','file');
pr_swfupload_init($_swfu_fields);
	pr_edit_subform("form_start","sales_form");
	?>
	<div class="pr_block">
	<div class="metabox-holder">
		<div class="postbox widefat">
		<h3 class="manage-column column-title"><span>Sale information</span></h3>
		<div class="inside">
			<p>Property owner</p>
			<p><?pr_edit_subform("user_list",NULL,NULL,"pr_user_id",$update_user_id);?></p>
			<p>Price</p><p><input type="text" name="pr_sale_price" value="<?if($prid!=NULL) echo $property[0]->sale_price;?>"></p>
			<p>Description</p><p>
			<div class="editor_container">
			<?php
			$_descr_text = '';
			if ($prid != NULL) {
				$_descr = $property[0]->descr;
			}
			//the_editor(str_replace("\'", "'", str_replace('\&quot;', '"', stripslashes($_descr))),'pr_descr','pr_descr');
			?>
			<textarea id="pr_descr" name="pr_descr"><?if($prid!=NULL) echo $property[0]->descr;?></textarea>
			<?
			pr_editor_init($_descr, '#pr_descr');
			?>
			</div>

			</p>
			<p>View arrangements</p><p><textarea name="pr_viewarrange"><?if($prid!=NULL) echo $property[0]->viewarrange;?></textarea></p>
			<p>Refference number</p><p><input type="text" name="pr_refnumber" value="<?if($prid!=NULL) echo $property[0]->refnumber;?>"></p>
			<p>Type*</p><p><?pr_edit_subform("prop_types",$type);?></p>
			<p>Number of bedrooms</p><p><?pr_edit_subform("num_of_bedrooms",$bedroomnum,NULL,"pr_bedroomnum",10);?></p>
			<p>Number of bathrooms</p><p><?pr_edit_subform("num_of_bedrooms",$bathroomnum,NULL,"pr_bathroomnum",10);?></p>
			<p>Number of reception rooms</p><p><?pr_edit_subform("num_of_bedrooms",$receptionroomnum,NULL,"pr_receptionroomnum",10);?></p>
		</div>
		</div>

	</div>
	</div>
	<div class="pr_block">
	<div class="metabox-holder">
		<div class="postbox widefat">
		<h3 class="manage-column column-title"><span>Address information</span></h3>
		<div class="inside">
			<p>Area*</p><p><?pr_edit_subform("areas",$area,NULL,'pr_area',NULL);?></p>
			<p>Building name</p><p><input type="text" name="pr_addr_building_name" value="<?if($prid!=NULL) echo $property[0]->addr_building_name;?>"></p>
			<p>Door number<span class="required">*</span></p><p><input type="text" id="door_number" name="pr_addr_door_number" value="<?if($prid!=NULL) echo $property[0]->addr_door_number;?>"></p>
			<p>Street<span class="required">*</span></p><p><input type="text" name="pr_addr_street" value="<?if($prid!=NULL) echo $property[0]->addr_street;?>"></p>
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
	</div>
	</div>
	<div class="pr_block">
	<div class="metabox-holder">
		<div class="postbox widefat">
		<h3 class="manage-column column-title"><span>Extra information</span></h3>
		<div class="inside">
			<?//if ($prid!=NULL){?>
			<p>Paid</p><p>
			<input type="checkbox" value="1" name="pr_paid" <?if ($prid!=NULL and $property[0]->paid == 1) echo "checked";?>></p>
      <p>Approved</p><p>

			<input type="checkbox" value="1" name="pr_approved" <?if ($prid!=NULL and $property[0]->approved == 1) echo "checked";?>>
			</p>
			<?if ($prid!=NULL and $property[0]->paid == 1)
			{
			global $pr_orders;
			$_tx = $wpdb->get_var($wpdb->prepare("SELECT o.transaction_id as tx FROM $pr_orders o INNER JOIN $pr_properties pr ON o.reference = pr.order_ref WHERE pr.ID = %d",$prid));
			?>
			<p>PayPal Transaction ID: #<?echo $_tx;?></p>
			<?}?>
			<?//}?>
			<p>Available from</p><p>
			<input type="text" value="<?if($prid!=NULL and $property[0]->extra_date_avail_from != '0000-00-00') echo pr_date_show($property[0]->extra_date_avail_from);?>" name="pr_extra_date_avail_from" id="Let_AvailableFrom"></p>
			<p>Display from</p><p>
			<input type="text" value="<?if($prid!=NULL and $property[0]->extra_date_displ_from != '0000-00-00') echo pr_date_show($property[0]->extra_date_displ_from);?>" name="pr_extra_date_displ_from" id="Let_DisplayFrom"></p>
      <p>Display to</p><p>
			<input type="text" value="<?if($prid!=NULL and $property[0]->extra_date_displ_to != '0000-00-00') echo pr_date_show($property[0]->extra_date_displ_to);?>" name="pr_extra_date_displ_to" id="Let_DisplayTo"></p>
			<?
      if ($prid!=NULL)
      {
          pr_m_('Created: '.pr_date_show($property[0]->date_created, true));
        if ($property[0]->date_updated!=NULL)
        {
          pr_m_('Last updated: '.pr_date_show($property[0]->date_updated, true));
        }
      }
      ?>
      <p>Is active</p><p><input type="checkbox" value="1" name="pr_extra_active" <?if ($prid!=NULL and $property[0]->extra_active == 1) echo "checked";?>></p>
			<p>Is featured</p><p><input type="checkbox" value="1" name="pr_extra_featured" <?if ($prid!=NULL and $property[0]->extra_featured == 1) echo "checked";?>></p>
			<p>Furnishing</p><p>
			<?/*?><input type="text" name="pr_extra_furnishing" value="<?if($prid!=NULL) echo $property[0]->extra_furnishing;?>"><?*/?>
			<?
			$furnishing_vals = array(0,1);
			$furnishing_labels = array('Unfurnished','Furnished');
			pr_edit_subform('select', NULL, NULL, 'pr_extra_furnishing', $property[0]->extra_furnishing,2,$furnishing_vals,$furnishing_labels);?>
			</p>
			<p>Status</p><p><?pr_edit_subform("sale_status",$extra_status,NULL,"pr_extra_status");?></p>
			<p>Tenure</p><p><?pr_edit_subform('prop_tenure',$property[0]->tenure,NULL,'prop_tenure');?></p>
		</div>
		</div>
	</div>
	</div>
	<div class="pr_block">
	<div class="metabox-holder">
		<div class="postbox widefat">
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
	?>
	</p>
	<?
	if ($action == 'edit') {
		$_address_line = pr_get_prop_address($prid);

		pr_print_button_forms($prid,$_address_line);
	}
	pr_edit_subform("form_end");
	pr_preview_button("sales_form",2,"Preview");
}
function pr_prop_list($type,$page_id = 1)
{global $wpdb,$pr_areas,$pr_properties,$pr_area_types,$pr_per_page;
	$count = $wpdb->get_var("SELECT COUNT(ID) FROM $pr_properties WHERE property_type = $type");
	//$wpdb->show_errors();
	//$wpdb->print_error();
	// getting number of pages
	$pages = bcdiv($count,$pr_per_page);
	if(bcmod($count,$pr_per_page) > 0) $pages++;
	$pagestring = "Pages ";
	/**/
	for ($i = 1;$i <= $pages;$i++)
	{
		if ($page_id == $i)
		{
		$pagestring .= "<a class='selected' href=admin.php?page=".$_GET['page']."&page_id=".$i.">".$i."</a> ";
		} else {
		$pagestring .= "<a href=admin.php?page=".$_GET['page']."&page_id=".$i.">".$i."</a> ";
		}
	}


	$start = ($page_id-1)*$pr_per_page;//according to page we start our select from DB
	//we get data from DB according to type of properties
	switch($type)
	{
		case 1://LETTING
			$results = $wpdb->get_results("
	SELECT
	pr.ID,
	pr.let_weekrent as price,
	pr.addr_door_number as door_number,
	pr.addr_street as street,
	pr.addr_postcode as postcode,
	a.name as area,pr.area as area_id,
	pr.user_id,
	pr.type as prop_type,
	pr.extra_active as active,

	pr.approved as approved
	FROM $pr_properties pr LEFT JOIN $pr_areas a
		ON pr.area = a.ID
		WHERE pr.property_type = $type
		ORDER BY price ".$_SESSION['sort_by_price'].", pr.ID ASC
		LIMIT $start,$pr_per_page;");
		break;
		case 2://SALE
			$results = $wpdb->get_results("
	SELECT
	pr.ID,
	pr.sale_price as price,
	pr.addr_door_number as door_number,
	pr.addr_street as street,
	pr.addr_postcode as postcode,

	a.name as area,
	pr.area as area_id,
	pr.user_id,
	pr.type as prop_type,
	pr.extra_active as active,
	pr.approved as approved
	FROM $pr_properties pr LEFT JOIN $pr_areas a
		ON pr.area = a.ID
		WHERE pr.property_type = $type
		ORDER BY price ".$_SESSION['sort_by_price'].", pr.ID ASC
		LIMIT $start,$pr_per_page;");
		break;
	}
	//$wpdb->show_errors();
	//$wpdb->print_error();
	pr_edit_subform('price_sort_form');
	pr_m_($pagestring,"pagination","div");
	?>
<table class="widefat">
<thead>
<tr>
	<th class="manage-column column-title">#</th>
	<th class="manage-column column-title">Address</th>
	<th class="manage-column column-title">User</th>
	<th class="manage-column column-title">Price</th>
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
		<?
		$_address_line = pr_get_prop_address($prop->ID);
		echo $_address_line;
		//echo $prop->door_number.', '.$prop->street.', '.$prop->postcode.', '.pr_area_path($prop->area_id);?>
		</td>
		<td>
		<?
		$user_info = get_userdata($prop->user_id);
		echo "<a href='".get_bloginfo('url')."/wp-admin/user-edit.php?user_id=$prop->user_id'>$user_info->user_login</a>";
		?>
		</td>
		<td>
		<?echo pr_price($prop->price);?>
		</td>
		<td>
		<a href="javascript:sureness('admin.php?page=<?echo $_GET['page']?>&pr_del_id=<?echo $prop->ID?>')">Delete</a>
		<a href="admin.php?page=<?echo $_GET['page']?>&pr_id=<?echo $prop->ID?>&page_id=<?if(isset($_GET['page_id'])) echo $_GET['page_id']; else echo 1;?>">Edit</a>
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
pr_m_($pagestring,"pagination","div");
}
function pr_general_prop_list($page_id = 1)
{global $wpdb,$pr_areas,$pr_properties,$pr_area_types,$pr_per_page,$pr_sales_page,$pr_lettings_page,$exclude_areas;

$_unpaid = $wpdb->get_var("SELECT COUNT(ID) FROM $pr_properties WHERE paid = 0 AND property_type = 2;"); //
	if ($_unpaid>0)
	{
		$_excl_area = $exclude_areas;//
		foreach ($_excl_area as $area)
		{
			$_excl_arid[] = $wpdb->get_var("SELECT ID FROM $pr_areas WHERE name = '$area'");// ﮫ��६ Ȅ 䫿 豪뾷६�� 箭
		}

		$_unpaid = $wpdb->get_results("SELECT ID,area FROM $pr_properties WHERE paid = 0 AND property_type = 2;"); // ﮫ��६ ⱥ Ȅ 箭 䫿 ��﫠�孭��
		$_un_prop_ids = array();
		foreach($_unpaid as $prop)
		{
			if(!in_array($prop->area,$_excl_arid) and pr_check_parent($prop->area,$_excl_arid)==false)
				{
					$_un_prop_ids[] = $prop->ID;// 젱�袠Ȅ ��⨦謮��婠䫿 ⫾�६�� ⠰姳뼲಻ ��﫠�孭��
				}
				$_include = implode(',',$_un_prop_ids);
		}
	} else $_include = NULL;

	//$wpdb->show_errors();
	//$wpdb->print_error();
	// getting number of pages

	$count = $wpdb->get_var("SELECT COUNT(ID) FROM $pr_properties WHERE paid = 0 AND property_type = 2 AND ID IN ($_include);");

	$pr_per_page = $pr_per_page*2;
	$pages = bcdiv($count,$pr_per_page);
	if(bcmod($count,$pr_per_page) > 0) $pages++;
	$pagestring = "Pages ";
	/**/
	for ($i = 1;$i <= $pages;$i++)
	{
		if ($page_id == $i)
		{
		$pagestring .= "<a class='selected' href=admin.php?page=".$_GET['page']."&page_id=".$i.">".$i."</a> ";
		} else {
		$pagestring .= "<a href=admin.php?page=".$_GET['page']."&page_id=".$i.">".$i."</a> ";
		}
	}

	$start = ($page_id-1)*$pr_per_page;//according to page we start our select from DB
	//we get data from DB according to type of properties
			$results = $wpdb->get_results("
	SELECT
	pr.ID,
	IF (pr.property_type=2,pr.sale_price,pr.let_weekrent) as price,
	pr.addr_door_number as door_number,
	pr.addr_street as street,
	pr.addr_postcode as postcode,
	a.name as area,
	pr.area as area_id,
	pr.property_type as type,
	pr.type as prop_type,
	pr.user_id
	FROM $pr_properties pr LEFT JOIN $pr_areas a
		ON pr.area = a.ID
	WHERE pr.paid = 0
		AND property_type = 2
		AND pr.ID IN ($_include)
	ORDER BY price ".$_SESSION['sort_by_price'].", pr.ID ASC
	LIMIT $start,$pr_per_page;");


	//$wpdb->show_errors();
	//$wpdb->print_error();
	pr_m_('The following properties are not paid','notice','h3');
pr_edit_subform('price_sort_form');
	if ($pages>0) pr_m_($pagestring,"pagination","div");
	?>
<table class="widefat">
<thead>
<tr>
	<th class="manage-column column-title">#</th>
	<th class="manage-column column-title">Price</th>
	<th class="manage-column column-title">Address</th>
	<th class="manage-column column-title">Type</th>
	<th class="manage-column column-title">User</th>
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
		<?
		$_address_line = pr_get_prop_address($prop->ID);
		echo $_address_line;
		//echo $prop->door_number.', '.$prop->street.', '.$prop->postcode.', '.pr_area_path($prop->area_id);?>
		</td>
		<td>
		<?switch($prop->type)
		{
			case 1: echo "Letting";break;
			case 2: echo "Sale";break;
		}
		?>
		</td>
		<td>
		<?
		$user_info = get_userdata($prop->user_id);
		echo "<a href='".get_bloginfo('url')."/wp-admin/user-edit.php?user_id=$prop->user_id'>$user_info->user_login</a>";
		?>
		</td>
		<td>
		<?
		switch ($prop->type)
		{
			case 1: //let
			$_page = $pr_lettings_page;
			break;
			case 2://sale
			$_page = $pr_sales_page;
			break;
		}
		?>
		<a href="javascript:sureness('admin.php?page=<?echo $_page?>&pr_del_id=<?echo $prop->ID?>')">Delete</a>
		<a href="admin.php?page=<?echo $_page?>&pr_id=<?echo $prop->ID?>">Edit</a>

		</td>
	</tr>
	<?
	}
?>
</tbody>

</table>
<?
if ($pages>0) pr_m_($pagestring,"pagination","div");
}


function pr_check_parent($arid,$pids)
{
	global $wpdb,$pr_areas;
	$_pid = $wpdb->get_var("SELECT parent_id FROM $pr_areas WHERE ID = $arid");
	if (in_array($_pid,$pids)) $_ans = true;
		elseif($_pid == 0) $_ans = false;
			else $_ans = pr_check_parent($_pid,$pids);
			return $_ans;
}
function pr_find_parent_by_type($arid,$type)
{
	global $wpdb,$pr_areas,$pr_area_types;
	$_parent = $wpdb->get_results("SELECT a.parent_id,t.name as type FROM $pr_areas a INNER JOIN $pr_areas ar ON a.parent_id = ar.ID LEFT JOIN $pr_area_types t ON ar.type = t.ID WHERE a.ID = $arid");

	foreach($_parent as $parent)
	{
	if ($parent->type == $type) $_ans = $parent->parent_id;
		elseif($parent->parent_id == 0) $_ans = $parent->parent_id;
			else $_ans = pr_find_parent_by_type($parent->parent_id,$type);
	}
			return $_ans;
}

function pr_show_orders()
{
  global $wpdb,$pr_orders,$pr_properties,$pr_per_page,$pr_lettings_page,$pr_sales_page,$pr_order_details,$user_ID;
  if (isset($_GET['del_id'])) pr_order_delete($_GET['del_id']);
  $count = $wpdb->get_var("SELECT COUNT(ID) FROM $pr_orders");
	// getting number of pages
if (isset($_GET['page_id'])) $page_id = $_GET['page_id'];
  else $page_id = 1;

	$pages = bcdiv($count,$pr_per_page);
	if(bcmod($count,$pr_per_page) > 0) $pages++;
	$pagestring = "Pages ";
	/**/
	for ($i = 1;$i <= $pages;$i++)
	{
		if ($page_id == $i)
		{
		$pagestring .= "<a class='selected' href=admin.php?page=".$_GET['page']."&page_id=".$i.">".$i."</a> ";
		} else {
		$pagestring .= "<a href=admin.php?page=".$_GET['page']."&page_id=".$i.">".$i."</a> ";
		}
	}
	  $_SESSION['current_user_id'] = $user_ID;// current user ID for pop up window security
	$start = ($page_id-1)*$pr_per_page;//according to page we start our select from DB
  $orders = $wpdb->get_results("SELECT * FROM $pr_orders LIMIT $start,$pr_per_page");
  echo $pagestring;
?>
<table class="widefat">
<thead>
<tr>
	<th class="manage-column column-title">#</th>
	<th class="manage-column column-title">User</th>
	<th class="manage-column column-title">Total</th>
	<th class="manage-column column-title">Reference number</th>
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
      <td><?
    $user_info = get_userdata($order->user_id);
		echo "<a href='".get_bloginfo('url')."/wp-admin/user-edit.php?user_id=$order->user_id'>$user_info->user_login</a>";
      ?></td>

      <td>
      <?echo $order->total?>
      </td>

      <td>
      <?echo $order->reference.'<br>';
      echo "Issued on $order->date_issued";
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
	  //if($order->status == 'new')
	  //{
		?>
		<a href="javascript:sureness('admin.php?page=<?echo $_GET['page']?>&del_id=<?echo $order->ID?>')">Delete</a>
		<?
	  //}
      /*
	  $details = $wpdb->get_results("SELECT * FROM $pr_order_details WHERE order_id = $order->ID");
      foreach($details as $det)
      {
        echo "$det->details - $det->price <br>";
      }
	  */
      /*
      // showing links to properties for order by ID,
      //substitued by history from order_details in new version
      $props = $wpdb->get_results("SELECT ID, property_type, area, addr_door_number, addr_street,addr_postcode FROM $pr_properties WHERE order_ref = $order->reference");
      foreach($props as $prop)
      {
      switch ($prop->property_type)
		    {
			   case 1: //let
			   $_page = $pr_lettings_page;
			   break;
			   case 2://sale
			   $_page = $pr_sales_page;
			   break;
		    }
        echo '<a href="admin.php?page='.$_page.'&pr_id='.$prop->ID.'">'.$prop->addr_door_number.', '.$prop->addr_street.', '.$prop->addr_postcode.', '.$prop->area.'</a><br>';
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
echo $pagestring;
}
function pr_send_property_notification($id)
{
	global $wpdb,$pr_properties;
	$headers = 'From: '.get_bloginfo('name').' <noreply@'.getenv("HTTP_HOST").'>' . "\r\n\\";
	$to = get_bloginfo('admin_email');
	$subj = "New property has been submitted";
	$body = "New property has been submitted on <date time>.\n
User: <firstname> <lastname>, <email>\n
Property address: <address>\n
Please visit this url to approve it: <url>\n";

	wp_mail($to, $subj, $body, $headers);
}

function pr_send_newsletter()
{
  global $wpdb,$pr_properties,$pr_slug;
  global $_lettings_date_check,$_sales_date_check;
   $_lettings_date_check = str_replace('pr.','',$_lettings_date_check);
   $_sales_date_check = str_replace('pr.','',$_sales_date_check);
  // global $ID_arr;
  switch($_POST['pr_nwsltr_type'])
  {
    case 1:   // --------------------- sending properties to one user
    if (isset($_POST['pr_client_email']) and $_POST['pr_client_email'] != '' and pr_3rd_isValidEmail($_POST['pr_client_email']))
    {

  //$ID_arr[] = $_POST['pr_nwsltr_areas'];
  // find all areas in whitch to look for properties
  $ID_arr = array();
	pr_find_children($_POST['pr_nwsltr_areas'],&$ID_arr);
	$ids = pr_array_list($ID_arr);
       $_err = true;
      // $_msg = "Properties you wanted\r\n\n";
       $_today = date('Y-m-d');
       if(isset($_POST['pr_for_sale']))  // get sales
       {
          $_err = false;
          $props = $wpdb->get_results($wpdb->prepare("SELECT ID FROM $pr_properties WHERE area IN ($ids) AND sale_price < %d AND bedroomnum >= %d  AND property_type = 2 AND extra_active = 1 AND approved = 1 AND $_sales_date_check",$_POST['pr_nwsltr_price'], $_POST['pr_nwsltr_bedroomnum']));
         // $wpdb->show_errors();
         // $wpdb->print_error();
        $_msg .= "For sale: \r\n\n";
        foreach ($props as $prop)
        {
           $_msg .= get_permalink(get_page_by_path($pr_slug))."?pr_id=$prop->ID\r\n";
        }
        $_msg .= "\r\n\n-----------------------------\r\n\n";
       }
       if(isset($_POST['pr_for_let'])) // get lettings
       {
          $_err = false;
          $props = $wpdb->get_results($wpdb->prepare("SELECT ID FROM $pr_properties WHERE area IN ($ids) AND let_weekrent < %d AND bedroomnum >= %d AND property_type = 1 AND extra_active = 1 AND approved = 1 AND $_lettings_date_check",$_POST['pr_nwsltr_rent'], $_POST['pr_nwsltr_bedroomnum']));
         // $wpdb->show_errors();
         // $wpdb->print_error();
        $_msg .= "For let: \r\n\n";
        foreach ($props as $prop)
        {
          $_msg .= get_permalink(get_page_by_path($pr_slug))."?pr_id=$prop->ID\r\n";
        }
        $_msg .= "\r\n\n-----------------------------\r\n\n";

       }
       if ($_err == false)       // no errors with choice of properties' type
       {
	$blogname = get_settings('blogname');
	$admin_email = get_settings('admin_email');

	//message subject
  if (isset($_POST['pr_msg_subject'])) $subj = $_POST['pr_msg_subject'];
  else $subj = "Properties via $blogname";

	// set the body of the message

	$body = "";
  if (isset($_POST['pr_msg_text'])) $body .= $_POST['pr_msg_text']."\r\n\n"; // message text from textarea
  $body .= $_msg;
	$body.= "\r\n\n-----------------------------------\r\n";
	$body.= "This is an automated message \r\n";
	$body.= "from $blogname\r\n";
	$body.= "Please do not reply to this address\r\n";

	// end edits for function wpmem_inc_regemail()
	$headers = 'From: '.$blogname.' <'.$admin_email.'>' . "\r\n\\";
	wp_mail($_POST['pr_client_email'], $subj, $body, $headers);
	pr_m_('A message has been sent.','success','h3');
       } else pr_m_('You didn\'t chose type of sales to send','error','h3');


    } else pr_m_('Client email is incorrect','error','h3');
    break;

    case 2: // ----------------- sending to user group

    if(isset($_POST['pr_nwsltr_msg']) and $_POST['pr_nwsltr_msg'] != '' and $_POST['pr_nwsltr_subj'] != '')
    {
      // findiing all users with checket metas
      if(isset($_POST['pr_for']))
      {
        $ids_u = array();
        foreach($_POST['pr_for'] as $_for_meta)
        {
          $_ids = $wpdb->get_results("SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '$_for_meta' AND meta_value = 'on'");
          foreach($_ids as $_id)
          {
            $ids_u[] = $_id->user_id;
          }
          //$wpdb->show_errors();
          //$wpdb->print_error();
         // print_r($_ids);
         //$ids_u = array_merge($ids_u,$ids);
        }
        $ids_u = array_unique($ids_u); // array of user_ids which are unique
        $_ids = pr_array_list($ids_u);
        $emails = $wpdb->get_results("SELECT user_email FROM $wpdb->users WHERE ID IN ($_ids) AND user_email != 'none@none.com' AND user_email IS NOT NULL AND user_email != '';");

        $blogname = get_settings('blogname');
	    $admin_email = get_settings('admin_email');

	    $subj = strip_tags(stripslashes($_POST['pr_nwsltr_subj']));

	// set the body of the message

	$body = strip_tags(stripslashes($_POST['pr_nwsltr_msg']));
	$body.= "\r\n\n-----------------------------------\r\n";
	$body.= "This is an automated message \r\n";
	$body.= "from $blogname\r\n";
	$body.= "Please do not reply to this address\r\n";

	// end edits for function wpmem_inc_regemail()
	$headers = 'From: '.$blogname.' <'.$admin_email.'>' . "\r\n\\";
        foreach($emails as $email)
        {
          	wp_mail($email->user_email, $subj, $body, $headers);
        }
        //print_r($emails);
        pr_m_('A message has been sent','success','h3');
      } else pr_m_('Need to check at least one group of users','error','h3');

    } else pr_m_('Write a message and its subject please','error','h3');

    break;

    case 3:
      // first, we select all lettings and sales which correspond to general rules of selecting(approved, display date, active)
      $_today = date('Y-m-d');
      $lettings = $wpdb->get_results("SELECT ID FROM $pr_properties WHERE property_type = 1 AND extra_active = 1 AND approved = 1 AND $_lettings_date_check");
      //$wpdb->show_errors();
	  //$wpdb->print_error();
	  if (count($lettings)>0)
      {
      $no_lettings = false;
      $let_ids = array();
      foreach($lettings as $let)
      {
        $let_ids[] = $let->ID;
      }
	  $lettings = pr_array_list($let_ids);
	  //echo $lettings;
      } else $no_lettings = true;

      $sales = $wpdb->get_results("SELECT ID FROM $pr_properties WHERE property_type = 2 AND extra_active = 1 AND approved = 1 AND $_sales_date_check");
	  //$wpdb->show_errors();
	  //$wpdb->print_error();
      if (count($sales)>0)
      {
      $no_sales = false;
      $sale_ids = array();
      foreach($sales as $sale)
      {
        $sale_ids[] = $sale->ID;
      }
      $sales = pr_array_list($sale_ids);
	  //echo $sales;
      } else $no_sales = true;

	  // 2nd, we get two arrays of users, who area interested in lettings and sales
      $for_rent_ob = $wpdb->get_results("SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'rent' AND meta_value = 'on'");
      $for_rent = array();
      foreach($for_rent_ob as $_ob)
		{ $for_rent[] = $_ob->user_id; }
      $for_buy_ob =  $wpdb->get_results("SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'buy' AND meta_value = 'on'");
      $for_buy = array();
      foreach($for_buy_ob as $_ob)
		{ $for_buy[] = $_ob->user_id;}
      $intersect = array_intersect($for_rent,$for_buy);    // users_ids who are interested in both topics
      $merge = array_merge($for_rent,$for_buy);
      //echo "merged ";print_r($merge);echo "<br>";
      // leave only unique entries
      $merge = array_unique($merge);


      $only_for_buy = array_diff($merge,$for_rent);// users_ids who are interested in buying only
      $only_for_rent = array_diff($merge,$for_buy);// users_ids who are interested in renting only
      /*
      echo "for rent ";print_r($for_rent);echo "<br>";
      echo "for buy ";print_r($for_buy);echo "<br>";
      echo "intersect ";print_r($intersect);echo "<br>";
      echo "merged unique ";print_r($merge);echo "<br>";
      echo "only buy ";print_r($only_for_buy);echo "<br>";
      echo "only rent ";print_r($only_for_rent);echo "<br>";
       */

    // finally we have all needed arrays for users ids
$_msg_count = 0; // message counter
	//message subject
  if (isset($_POST['pr_msg_subject'])) $subj = strip_tags(stripslashes($_POST['pr_msg_subject']));
  else $subj = "Properties via $blogname";
  $body = "";
  if (isset($_POST['pr_msg_text'])) $body .= strip_tags(stripslashes($_POST['pr_msg_text']))."\r\n\n"; // message text from textarea

	$blogname = get_settings('blogname');
	$admin_email = get_settings('admin_email');


	$body_end.= "\r\n\n-----------------------------------\r\n";
	$body_end.= "This is an automated message \r\n";
	$body_end.= "from $blogname\r\n";
	$body_end.= "Please do not reply to this address\r\n";

	// end edits for function wpmem_inc_regemail()
	$headers = 'From: '.$blogname.' <'.$admin_email.'>' . "\r\n\\";
      // users who are interested in both topics

      foreach($intersect as $id)
      {
        //echo $id;
        $u_inf = get_userdata($id);
if ($u_inf->user_email != 'none@none.com' AND $u_inf->user_email != NULL AND $u_inf->user_email != '')
{
        $rent_price = $u_inf->rent_price;
        $price = $u_inf->price;
        $bedrooms = $u_inf->bedrooms;
        $areas = $u_inf->areas;
        //$areas = get_user_meta($id,'areas');
        //print_r($areas);
        //echo $u_inf->areas;

        $ID_arr = array();
		pr_find_children($areas,&$ID_arr);
	    $areas_ids = pr_array_list($ID_arr); // all subareas + area itself
	      //echo  $areas_ids;

        $_body = "";

		if ($no_sales == false)
	      {
          $results = $wpdb->get_results("SELECT ID FROM $pr_properties WHERE ID IN ($sales) AND area IN ($areas_ids) AND bedroomnum >= $bedrooms AND sale_price <= $price");
          //$wpdb->show_errors();

		  //$wpdb->print_error();
		  //print_r($results);
		  if (count($results) > 0)
          {
            $msg = "Sales, corresponding to your criterias\r\n";
            foreach($results as $prop)
            {
              $msg .= get_permalink(get_page_by_path($pr_slug))."?pr_id=$prop->ID\r\n";
            }
            $msg .= "----------------------\r\n\n";
          } else $msg = "No sales corresponding to your demands.";
        } else $msg = "No active sales on the site at the moment.";

		$_body .= $msg;

		if ($no_lettings == false)
	      {
          $results = $wpdb->get_results("SELECT ID FROM $pr_properties WHERE ID IN ($lettings) AND area IN ($areas_ids) AND bedroomnum >= $bedrooms AND let_weekrent <= $rent_price");
          //$wpdb->show_errors();
		  //$wpdb->print_error();
          //print_r($results);
		  if (count($results) > 0)
          {
            $msg = "Lettings, corresponding to your criterias\r\n";
            foreach($results as $prop)
            {
              $msg .= get_permalink(get_page_by_path($pr_slug))."?pr_id=$prop->ID\r\n";
            }
            $msg .= "----------------------\r\n\n";
          } else $msg = "No lettings corresponding to your demands.";
        } else $msg = "No active lettings on the site at the moment.";
        $_body .= $msg;
     /* */
	 //echo $_body;

	$_body = $body.$_body.$body_end;
//echo $_body.'<br>';
	wp_mail($u_inf->user_email, $subj, $_body, $headers);

	$_msg_count++;
	//echo $u_inf->user_email.'<br>';
}
      }
////////////// end of intersected users


// only for buy
	  foreach($only_for_buy as $id)
      {

        $u_inf = get_userdata($id);
if ($u_inf->user_email != 'none@none.com' AND $u_inf->user_email != NULL AND $u_inf->user_email != '')
{
        $rent_price = $u_inf->rent_price;
        $price = $u_inf->price;
        $bedrooms = $u_inf->bedrooms;
        $areas = $u_inf->areas;

        $ID_arr = array();
	    pr_find_children($areas,&$ID_arr);
	    $areas_ids = pr_array_list($ID_arr); // all subareas + area itself

        $_body = "";

		if ($no_sales == false)
	      {
          $results = $wpdb->get_results("SELECT ID FROM $pr_properties WHERE ID IN ($sales) AND area IN ($areas_ids) AND bedroomnum >= $bedrooms AND sale_price <= $price");
          //$wpdb->show_errors();
		  //$wpdb->print_error();
		  //print_r($results);
		  if (count($results) > 0)
          {
            $msg = "Sales, corresponding to your criterias\r\n";
            foreach($results as $prop)
            {
              $msg .= get_permalink(get_page_by_path($pr_slug))."?pr_id=$prop->ID\r\n";

            }
            $msg .= "----------------------\r\n\n";
          } else $msg = "No sales corresponding to your demands.";
        } else $msg = "No active sales on the site at the moment.";


		$_body .= $msg;

	$_body = $body.$_body.$body_end;
//echo $_body.'<br>';
	wp_mail($u_inf->user_email, $subj, $_body, $headers);

	$_msg_count++;
	//echo $u_inf->user_email.'<br>';
}
      }
////////////////////// end of only for buy

// only for rent
      foreach($only_for_rent as $id)
      {
        //echo $id;
        $u_inf = get_userdata($id);
if ($u_inf->user_email != 'none@none.com' AND $u_inf->user_email != NULL AND $u_inf->user_email != '')
{
        $rent_price = $u_inf->rent_price;
        $price = $u_inf->price;
        $bedrooms = $u_inf->bedrooms;
        $areas = $u_inf->areas;
        //$areas = get_user_meta($id,'areas');
        //print_r($areas);
        //echo $u_inf->areas;
        $ID_arr = array();

	      pr_find_children($areas,&$ID_arr);
	      $areas_ids = pr_array_list($ID_arr); // all subareas + area itself
	      //echo  $areas_ids;

        $_body = "";

		if ($no_lettings == false)
	      {
          $results = $wpdb->get_results("SELECT ID FROM $pr_properties WHERE ID IN ($lettings) AND area IN ($areas_ids) AND bedroomnum >= $bedrooms AND let_weekrent <= $rent_price");
          //$wpdb->show_errors();
		  //$wpdb->print_error();
          //print_r($results);
		  if (count($results) > 0)
          {
            $msg = "Lettings, corresponding to your criterias\r\n";
            foreach($results as $prop)
            {
              $msg .= get_permalink(get_page_by_path($pr_slug))."?pr_id=$prop->ID\r\n";
            }
            $msg .= "----------------------\r\n\n";
          } else $msg = "No lettings corresponding to your demands.";
        } else $msg = "No active lettings on the site at the moment.";
        $_body .= $msg;
     /* */
	 //echo $_body;

	$_body = $body.$_body.$body_end;
//echo $_body.'<br>';
	wp_mail($u_inf->user_email, $subj, $_body, $headers);

	$_msg_count++;
	//echo $u_inf->user_email.'<br>';

}
      }
//////////// end of only for rent

	// end of all
	pr_m_("$_msg_count messages have been sent",'','h3');
    break;
  }
}
function pr_newsletters_form()
{
  global $wpdb;
?>
<div class="pr_block clear full_width">
	<div class="metabox-holder">
		<div class="postbox widefat">
		<h3 class="manage-column column-title"><span>Newsletter for 1 client</span></h3>
		<div class="inside">
<?
  pr_edit_subform("form_start");
  pr_m_('Send properties, which are ');
  echo "<p> "; pr_edit_subform("checkbox",NULL,NULL,"pr_for_sale",1);echo "For sale";echo "</p>";
 echo "<p> ";pr_edit_subform("checkbox",NULL,NULL,"pr_for_let",1); echo "For let";echo "</p>";
  echo "<p>Maximum price ";
    prf_price_drop_down("pr_nwsltr_price",10000,100000,10);echo "</p>";
	echo "<p>Maximum rent per week ";
    prf_rent_drop_down("pr_nwsltr_rent",100,5000,10);
    echo "</p>";
    echo "<p>Minimum number of bedrooms ";
    prf_bedroom_drop_down("pr_nwsltr_bedroomnum",0,10,10);
    echo "</p>";
  	echo "<p>Area ";
    pr_edit_subform("areas_front",NULL,NULL,"pr_nwsltr_areas",NULL);echo "</p>";

  echo "<p>Client email ";
    pr_edit_subform("text",NULL,NULL,"pr_client_email",NULL);
  echo "</p>";
  echo "<p>Subject ";
    $_today = date('Y-m-d');
    pr_edit_subform("text","pr_msg_subject_for_1",NULL,"pr_msg_subject","Available properties on $_today");
  echo "</p>";
  echo "<p>Message text<br>";
    pr_edit_subform("textarea","msg_txt_for_1",NULL,"pr_msg_text","Test message");
  echo "</p>";

?>
    <script>
    $(document).ready(function() {
		$("#pr_msg_subject_for_1").width(350);
		$("#msg_txt_for_1").width(350).height(150);
    });
	</script>
<?
  pr_edit_subform("hidden",NULL,NULL,"pr_nwsltr_type",1);
  echo "<p>";pr_edit_subform("submit",NULL,NULL,"Send");echo "</p>"; /**/
  pr_edit_subform("form_end");
?>
		</div>
		</div>
	</div>
</div>

<div class="pr_block clear full_width">
	<div class="metabox-holder">
		<div class="postbox widefat">
		<h3 class="manage-column column-title"><span>Newsletter for user group</span></h3>
		<div class="inside">
<?
  pr_edit_subform("form_start");
  pr_m_('For those clients, who are looking ');
  echo "<p> ";pr_edit_subform("checkbox","buy",NULL,"pr_for[]","buy"); echo "For buy ";echo "</p>";
  echo "<p> ";pr_edit_subform("checkbox","rent",NULL,"pr_for[]","rent"); echo "For rent ";echo "</p>";
  echo "<p> ";pr_edit_subform("checkbox","sale",NULL,"pr_for[]","sale"); echo "For sale ";echo "</p>";
  echo "<p> ";pr_edit_subform("checkbox","let",NULL,"pr_for[]","let"); echo "For let ";echo "</p>";
  echo "<p>Subject ";
  pr_edit_subform("text","pr_subj_for_group",NULL,"pr_nwsltr_subj",NULL);
  echo "</p>";
  pr_m_('Message ');
  echo "<p>";
    pr_edit_subform("textarea","msg_for_group",NULL,"pr_nwsltr_msg");echo "</p>";
  echo "</p>";
?>
    <script>
    $(document).ready(function() {
		$("#pr_subj_for_group").width(350);
		$("#msg_for_group").width(350).height(150);
    });
	</script>
<?
  pr_edit_subform("hidden",NULL,NULL,"pr_nwsltr_type",2);
  echo "<p>";pr_edit_subform("submit",NULL,NULL,"Send");echo "</p>"; /**/
  pr_edit_subform("form_end");
?>
		</div>
		</div>
	</div>
</div>

<div class="pr_block clear full_width">
	<div class="metabox-holder">
		<div class="postbox widefat">
		<h3 class="manage-column column-title"><span>Newsletter for all clients</span></h3>
		<div class="inside">
<?
  pr_edit_subform("form_start");
  pr_m_('The properties will be selected according to each client\'s settings in Newsletter section of their profiles.');
  echo "<p>Subject ";
    $_today = date('Y-m-d');
    pr_edit_subform("text","pr_subj_for_all",NULL,"pr_msg_subject","Available properties on $_today");
  echo "</p>";
  echo "<p>Message text<br>";
    pr_edit_subform("textarea","msg_for_all",NULL,"pr_msg_text","Test message");
  echo "</p>";
?>
    <script>
    $(document).ready(function() {
		$("#pr_subj_for_all").width(350);
		$("#msg_for_all").width(350).height(150);
    });
	</script>
<?
  pr_edit_subform("hidden",NULL,NULL,"pr_nwsltr_type",3);
  echo "<p>";pr_edit_subform("submit",NULL,NULL,"Send");echo "</p>"; /**/
  pr_edit_subform("form_end");
?>
		</div>
		</div>
	</div>
</div>
<?
}
//////// PAY PAL settings
function pr_pp_install()
{
	global $pr_paypal_opt;
	if(!get_option($pr_paypal_opt)) { // no such option
		// theese are options for pay pal
		$pr_seller_mail = "matvey_1281359411_biz@gmail.com";
		$pr_data_send_url_testing = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		$pr_data_send_url_live = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		$pr_token = "Qtw6luJnqWQcC1ry3KWvUxqOLWLkeapxVF1WeKiElqYWkz_0Wn9zIebP-68";
		$pr_mode = "testing";
		$pr_hosted_button_id = "XTC56GXMRNWCG";
		//$pr_item_number = "1287438424";
		$pp_opts = array($pr_seller_mail,$pr_data_send_url_testing,$pr_data_send_url_live,$pr_token,$pr_mode,$pr_hosted_button_id);
		add_option($pr_paypal_opt, $pp_opts, '', 'yes');
	}

}
function pr_pp_uninstall()

{
	global $pr_paypal_opt;
	if(get_option($pr_paypal_opt)) {
		delete_option($pr_paypal_opt);
	}
}
function pr_pp_init()
{
	global $pr_paypal_opt,$pr_seller_mail,$pr_data_send_url,$pr_token,$pr_hosted_button_id;
	if(get_option($pr_paypal_opt)) {
		$pp_opts = get_option($pr_paypal_opt);
		$pr_seller_mail = $pp_opts[0];
		switch($pp_opts[4]) //switching mode
		{
		case "testing":
			$pr_data_send_url = $pp_opts[1];
		break;
		case "live":
			$pr_data_send_url = $pp_opts[2];
		break;
		}
		$pr_token = $pp_opts[3];
		$pr_hosted_button_id = $pp_opts[5];
		//$pr_item_number = $pp_opts[6];
	}
}

function pr_pp_edit()
{
	global $pr_paypal_opt;
	if(isset($_POST['submit'])) // updating paypal settings
	{
		switch($_POST['pr_pp_url'])
		{
		case "testing":
			$url = $_POST['pr_data_send_url_testing'];
		break;
		case "live":
			$url = $_POST['pr_data_send_url_live'];
		break;
		}
		$pp_opts = array($_POST['pr_seller_mail'], $_POST['pr_data_send_url_testing'], $_POST['pr_data_send_url_live'],$_POST['pr_token'],$_POST['pr_pp_url'],$_POST['pr_hosted_button_id']);
		update_option($pr_paypal_opt,$pp_opts);
	}
	if(get_option($pr_paypal_opt)) {
		$pp_opts = get_option($pr_paypal_opt);
		$pr_seller_mail = $pp_opts[0];
		$pr_data_send_url_testing = $pp_opts[1];
		$pr_data_send_url_live = $pp_opts[2];
		$pr_token = $pp_opts[3];
		$pr_mode = $pp_opts[4];
		$pr_hosted_button_id = $pp_opts[5];
		//$pr_item_number = $pp_opts[6];
	}
	pr_edit_subform("form_start");
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
pr_m_('<img src="'.plugins_url('properties/images/paypal-logo.png').'" /> PayPal settings','','h2');
?>
</div>
	<?
	?><p>
		<label for="pr_seller_mail">Merchant ID</label><br>
		<?pr_edit_subform("text_input","pr_seller_mail",NULL,"pr_seller_mail",$pr_seller_mail);
	?></p><?
	?><p>
		<input type="radio" name="pr_pp_url" value="testing" <?if ($pr_mode == "testing") echo "checked";?>><label for="pr_data_send_url_testing">Testing URL to send data</label><br>
		<?pr_edit_subform("textarea","pr_data_send_url_testing",NULL,"pr_data_send_url_testing",$pr_data_send_url_testing);
	?></p><?
	?><p>
		<input type="radio" name="pr_pp_url" value="live" <?if ($pr_mode == "live") echo "checked";?>><label for="pr_data_send_url_live">LIVE URL to send data</label><br>
		<?pr_edit_subform("textarea","pr_data_send_url_live",NULL,"pr_data_send_url_live",$pr_data_send_url_live);
	?></p><?
	?><p>
		<label for="pr_token">PayPal Token</label><br>
		<?pr_edit_subform("textarea","pr_token",NULL,"pr_token",$pr_token);
	?></p><?
	//pr_edit_subform();
	?><p>
		<label for="pr_hosted_button_id">Hostedd button ID</label><br>
		<?pr_edit_subform("text_input","pr_hosted_button_id",NULL,"pr_hosted_button_id",$pr_hosted_button_id);
	?></p><?
	?><p><?
		pr_edit_subform("submit","Submit");
	?></p>
	<?
	pr_edit_subform("form_end");

}

function pr_order_delete($del_id)
{
	global $wpdb,$user_ID,$pr_orders,$pr_order_details;
	if (isset($user_ID))

	{

	$user_info = get_userdata($user_ID);
	$_allow_del = false;
	if ($user_info->user_level >= 8)
	{

		$_allow_del = true;
	}
	else {
	$user_id = $wpdb->get_var($wpdb->prepare("SELECT user_id from $pr_orders WHERE ID = $del_id",$del_id));
	if ($user_ID == $user_id)
	{
		$_allow_del = true;
	}
	}

	if ($_allow_del == true)
	{
		$wpdb->query($wpdb->prepare("DELETE FROM $pr_orders WHERE ID = $del_id"));
		$wpdb->query($wpdb->prepare("DELETE FROM $pr_order_details WHERE order_id = $del_id"));
		pr_m_('An order was successfully deleted.','success','h3');
	} else pr_m_('You are not allowed to delete this order.','error','h3');

	} else pr_m_('You are not logged in.','error','h3');
}


function pr_export()
{
	global $pr_option_DG;
	$page = $_GET['page'];
?>
<div class="wrap">
<style>
input[type="text"]
{
	width:400px;
}
textarea
{
	width:500px;
	height:200px;
}
</style>
<?
pr_m_('<img src="'.plugins_url('properties/images/export-logo.png').'" /> Export','','h2');
?>
</div>
<?
if (isset($_GET['del_export_filename']))
{
	pr_export_file_delete($_GET['del_export_filename']);
}
if (isset($_GET['export'])) {
			pr_export_file_create($pr_option_DG[$_GET['export']]);
}
if (isset($_GET['settings'])) {
		pr_export_DG_settings();
} else pr_export_main();



//echo "Export function is under construction";

}

function pr_export_main(){
	global $pr_option_DG;
	$page = $_GET['page'];
?>
<table class="widefat">
	<thead>
	<tr>
		<th class="name">Export name</th>
		<th class="name">Action</th>
	</tr>
	</thead>
	<tbody>

<?

foreach ($pr_option_DG as $_option){
if(get_option($_option)){
$DG = get_option($_option);
	list($export_name,$export_agent_group,$export_agent_branch,$export_from,$export_prop_types,$export_mode) = $DG;
	$settings = true;
} else {
	$settings = false;
	$export_name = $_option.' (not configured)';
}

?>
	<tr>
		<td><?echo $export_name;?></td>
		<td><?if ($settings==true) {

			?>
			<a href="admin.php?page=<?echo $page?>&export=<?echo $_option?>">Export</a>
			<?
		}?>
		<a href="admin.php?page=<?echo $page?>&settings=<?echo $_option?>">Settings</a>
		</td>
	</tr>
<?
//} else {
//	$export_name = 'Digital group (without settings)';
//	$settings = false;
//}
}

?>

	</tbody>
</table>
<?
pr_m_('List of exports made', NULL, 'h3');
pr_export_files_list();
}

function pr_export_file_create_get_properties($types = 'all',$area = 0,$from_date = NULL) // ﮫ��६ ੤踭誨 ⱥ� લ�ૼ�� 䫿 䠭��蠯৮��Ⱜ孨 ��⨦謮��婮
{
	global $wpdb,$pr_properties,$pr_baskets;
	// get properties
	switch($types)
	{
		case "all":
			$_and_types = '';
		break;
		case "lettings":
			$_and_types = 'AND property_type=1';
		break;
		case "sales":
			$_and_types = 'AND property_type=2';
		break;
		default:
			$_and_types = '';

		break;
	}
	if ($from_date != NULL and $from_date != '')
	{
		$from_date = str_replace('/','.',$from_date);
		$from_date = date_create($from_date);
		$from_date = date_format($from_date,'Y-m-d');
		$_and_from_date = "AND date_created > '$from_date'";
	} else $_and_from_date = '';
	$sql = "SELECT ID FROM $pr_properties pr inner join $pr_baskets b
			ON pr.basketid = b.basketid
			WHERE pr.ID IS NOT NULL $_and_types $_and_from_date
			AND b.area = $area
			";
	$results = $wpdb->get_results($sql);
//	print_r($results);
//	$wpdb->show_errors();
//	$wpdb->print_error();
	$res = array(); // resulting array of property IDs
	foreach($results as $result)
	{
		$res[] = $result->ID;
	}
	return $res;
}
function pr_export_file_write_property($file,$prop)
{
	global $wpdb,$selling_state,$furnishing,$pr_prop_types,$property_tenure;

	$_additionalKeywords = array(); //initialize additional keywords array
	// property type
	$_property_root_type = pr_get_property_type_parents($prop->type,'root'); // get root type parents
	//echo $prop->ID.'-';print_r($_property_root_type);	echo '<br>';
	$_export_prop = true;
	if ($prop->area==NULL or pr_get_area_info($prop->area)==false) {
		$_export_prop = false;
	}
	if ($_property_root_type != NULL) // if type of property has parents
	{
		$_property_root_type_code = pr_get_property_type_code($_property_root_type['id']);// if this prop type has parents we get its parent code
		//echo $prop->ID.'-'.$_property_root_type_code.'<br>';

		if ($_property_root_type_code=='A') // no code found
		{
			$_additionalKeywords[] = $wpdb->get_var("SELECT Name from $pr_prop_types WHERE ID = $prop->type"); // add current type name to additionalKeys field
		} else{
			$_sub_code = pr_get_property_type_code($prop->type);
				if ($_property_root_type_code==$_sub_code){
					$_property_sub_type_code = NULL;
				} else $_property_sub_type_code = $_sub_code;// get subtype code
			}

	}
	else { // if type of property doesn't have parents
		//echo $prop->ID.'-NULL<br>';
		$_property_root_type_code = pr_get_property_type_code($prop->type);// root type is current type, and we get its code
		$_property_sub_type_code = NULL;
		if ($_property_root_type_code == NULL) // if root type doesn't have its code
		{
			$_export_prop = false;
			//$_additionalKeywords[] = $wpdb->get_var("SELECT Name FROM $pr_prop_types WHERE ID = $prop->type");// add current type name to additionalKeys field
		}
	}

if ($_export_prop == true) {


	// getting areas route
	$area = pr_get_area_info($prop->area);
	$area_parents = pr_get_area_parents($prop->area,'all');// get parents route for area
//echo $prop->ID.'-';print_r($area_parents);echo '<br>';
	$areas_route = '';
if ($area_parents != NULL)
{
	$_parents_num = sizeof($area_parents);
	foreach($area_parents as $k=>$parent)
	{
		$areas_route .= $parent['name'];
		//if ($k<$_parents_num-1)
			$areas_route .= ', ';
	}

	$root_area_info = pr_get_area_info($area_parents[0]['id']);// root area info
}	else $root_area_info = $area; // root area info OR pr_get_area_info($prop->area);

	$areas_route .= $area->name;
	$areas_route = htmlentities($areas_route);

	// building name
	if ($prop->addr_building_name == '' and $prop->addr_building_name == NULL)
		$_addr_building_name = $prop->addr_street.', '.$prop->addr_door_number;
		else $_addr_building_name = $prop->addr_building_name;

	// prices
switch($prop->property_type)
{
	case 1: //letting

	if ($prop->let_monthrent != NULL and $prop->let_monthrent != '')
		{
			$_price_prefix = 'M';
			$_price = $prop->let_monthrent;
		} else {
				$_price_prefix = 'W';
				$_price = $prop->let_weekrent;
				}
		$_sale_or_rent = 'R';
	break;
	case 2: //sale
		$_price_prefix = 'F';
		$_price = $prop->sale_price;
		$_sale_or_rent = 'S';
	break;
}


	// description
	$prop->descr = str_replace('&nbsp;','',$prop->descr);
	// images
	$_main_image = pr_get_property_images($prop->ID,'main');
	//print_r($_main_image);
	$_additional_images = pr_get_property_images($prop->ID,'without_main');

	$_hipdoc = pr_get_property_files($prop->ID,'one');
	//$_address_line = pr_get_prop_address($prop->ID);
	$_address_line = pr_get_prop_address($prop->ID,'export');
	$_summary = explode('.',$prop->descr);
	$_additionalKeywords = implode(',',$_additionalKeywords);
	if ($prop->extra_status == NULL) {
		$prop->extra_status = 2;
	}
	if ($prop->extra_furnishing == NULL) {
		$prop->extra_furnishing = 0;
	}
$string	= '<property propertyID="'.$prop->ID.'">
                <fullPostCode>'.htmlspecialchars($prop->addr_postcode).'</fullPostCode>
                <countryCode>'.htmlspecialchars($root_area_info->code).'</countryCode>
                <name>'.htmlspecialchars(trim(implode(' ',array($prop->addr_door_number,$prop->addr_building_name)))).'</name>
                <address>'.htmlspecialchars($_address_line).'</address>
                <regionCode></regionCode>
                <summary>'.htmlspecialchars(trim($_summary[0])).'</summary>
                <details><![CDATA['.htmlspecialchars($prop->descr).']]></details>
				<pricePrefix>'.htmlspecialchars($_price_prefix).'</pricePrefix>
                <price>'.htmlspecialchars(round($_price,0)).'</price>
                <priceCurrency>GBP</priceCurrency>
                <sellingState>'.htmlspecialchars($selling_state[$prop->extra_status]['code']).'</sellingState>
				';
if ($_property_root_type_code != NULL)
	$string	.= '<propertyType>'.htmlspecialchars($_property_root_type_code).'</propertyType>
				';

if ($_property_sub_type_code != NULL)
	$string	.=  '<propertySubType>'.htmlspecialchars($_property_sub_type_code).'</propertySubType>
				';

	$string	.=  '<newHome></newHome>
                <saleOrRent>'.htmlspecialchars($_sale_or_rent).'</saleOrRent>
                <groundRent>0</groundRent>
                <serviceCharge>0</serviceCharge>
                <furnished>'.htmlspecialchars($prop->extra_furnishing).'</furnished>

				';
if ($prop->property_type==2) {
$string	.=      '<tenure>'.htmlspecialchars($property_tenure[$prop->tenure]['code']).'</tenure>
				';
}
$string	.=      '<bedrooms>'.htmlspecialchars($prop->bedroomnum).'</bedrooms>
                <bathrooms>'.htmlspecialchars($prop->bathroomnum).'</bathrooms>
                <receptionRooms>'.htmlspecialchars($prop->receptionroomnum).'</receptionRooms>
				<mainImage>'.htmlspecialchars($_main_image[0]).'</mainImage>
				';
// showing additional images, max 8
	if ($_additional_images != NULL )
		{
		if (sizeof($_additional_images) < 8) $stop = sizeof($_additional_images);
			else $stop = 8;
			for ($i = 0;$i<$stop;$i++)
	$string	.=  '<additionalImage'.($i+1).'>'.htmlspecialchars($_additional_images[$i]).'</additionalImage'.($i+1).'>
				';
        }
// HIP document
if ($_hipdoc != NULL)
	$string	.=  '<HIPDocument>'.htmlspecialchars($_hipdoc).'</HIPDocument>
				';

    $string	.=  '<createdDate>'.htmlspecialchars(str_replace(' ','T',$prop->date_created)).'</createdDate>
                <modifiedDate>'.htmlspecialchars(str_replace(' ','T',$prop->date_updated)).'</modifiedDate>
                <additionalKeywords>'.htmlspecialchars($_additionalKeywords).'</additionalKeywords>
            </property>
            ';

	fwrite($file,stripslashes($string));


}//end of export_prop check


}
function pr_export_file_write_sale($file,$prop)
{
	//$string
}
function pr_export_file_create($_option)
{
	global $wpdb,$pr_properties,$pr_export_dir;
	$DG = get_option($_option);
	list($export_name,$export_agent_group,$export_agent_branch,$export_from,$export_prop_types,$export_mode,$area) = $DG;
	//print_r($DG);

	$export_name = str_replace(' ','_',trim($export_name));
	$file = fopen(dirname(__FILE__).$pr_export_dir.$export_name.'.xml','w');
	$export_head = '<?xml version="1.0" encoding="UTF-8"?>
<root xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:noNamespaceSchemaLocation="http://www.fastcropit.com/schemas/FastcropX1.xsd">
    <agentGroup code="'.$export_agent_group.'">
        <mode>'.$export_mode.'</mode>
        <exportDate>'.date('Y-m-d').'T'.date('H:i:s').'</exportDate> <!-- xsd:dateTime format yyyy-mm-ddThh:mm:ss /-->
        <agentBranch code="'.$export_agent_branch.'">
		';
$export_bottom = '</agentBranch>
    </agentGroup>
</root>
';
	fwrite($file,stripslashes($export_head));

	$ids = pr_export_file_create_get_properties($export_prop_types,$area,$export_from);
	//print_r($ids);
if (sizeof($ids)>0) {

	$ids = pr_array_list($ids);
	$sql = "SELECT * FROM $pr_properties WHERE ID IN ($ids)";
	$results = $wpdb->get_results($sql);
	//$wpdb->show_errors();
	//$wpdb->print_error();
	foreach($results as $prop)
	{
		pr_export_file_write_property(&$file,&$prop);
		/*
		switch($prop->property_type)
		{
			case 1: // lettings
			pr_export_file_write_letting(&$file,&$prop);
			break;
			case 2: //sales
			//pr_export_file_write_sale(&$file,&$prop);
			break;
		}
		*/
	}

	fwrite($file,stripslashes($export_bottom));
	fclose($file);
	pr_export_ftp_upload(dirname(__FILE__).$pr_export_dir.$export_name.'.xml');
} else {
	pr_m_('No proerties exported','Attention','h3');
}

}
function pr_export_file_delete($filename)
{
	global $pr_export_dir,$user_ID;
	$u_info = get_userdata($user_ID);
	if ($u_info->user_level>8)
	{
		if (file_exists(dirname(__FILE__).$pr_export_dir.$filename))
		unlink(dirname(__FILE__).$pr_export_dir.$filename);
	} else pr_m_('You don\'t have enough rights to delete files','error','h3');
}
function pr_export_files_list()
{
	global $pr_export_dir;
	if (is_dir(dirname(__FILE__).$pr_export_dir))
	{
		if ($dir = opendir(dirname(__FILE__).$pr_export_dir))
		{
//print_r($dir);
			while ($file = readdir($dir))
			{

if ($file != "." && $file != "..") {
echo "<a href=".plugins_url('/properties'.$pr_export_dir.$file).">$file</a> | <a href=admin.php?page=".$_GET['page']."&del_export_filename=$file>Delete</a><br>";
}
			}
		}
	}
}

function pr_export_DG_settings()
{
	global $pr_option_DG;
	$pr_option_DG = $pr_option_DG[$_GET['settings']];
?>
<script type="text/javascript">
$(document).ready(function() {
    $('input#xml_Export_from').datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>
<?
if(isset($_POST['submit']) and isset($_POST['pr_xml_name'])){
	$option = array($_POST['pr_xml_name'],$_POST['pr_xml_agent_group'],$_POST['pr_xml_agent_branch'],$_POST['xml_Export_from'],$_POST['xml_Export_prop_type'],$_POST['pr_xml_mode'],$_POST['band_area']);
	update_option($pr_option_DG,$option);
}

if(get_option($pr_option_DG)){
	$DG = get_option($pr_option_DG);
	list($export_name,$export_agent_group,$export_agent_branch,$export_from,$export_prop_types,$export_mode,$area) = $DG;
	$settings = true;
} else {
	list($export_name,$export_agent_group,$export_agent_branch,$export_from,$export_prop_types,$export_mode,$area) = array('','','','','','','');
	$settings = false;
}

pr_edit_subform("form_start",NULL,NULL,'admin.php?page='.$_GET['page']);
echo "<p><label for=\"xml_name\">Exporting file name:</label><br>";
pr_edit_subform("text_input","xml_name",NULL,"pr_xml_name",$export_name);
echo "</p>";
echo "<p><label for=\"xml_agent_group\">Agent group code:</label><br>";
pr_edit_subform("text_input","xml_agent_group",NULL,"pr_xml_agent_group",$export_agent_group);
echo "</p>";
echo "<p><label for=\"xml_agent_branch\">Agent branch code:</label><br>";
pr_edit_subform("text_input","xml_agent_branch",NULL,"pr_xml_agent_branch",$export_agent_branch);
echo "</p>";
$_dates = array($export_from);
pr_dateinput('input#xml_Export_from');

echo "<p><label for=\"xml_Export_from\">Export start date:</label><br>";
pr_edit_subform("text_input","xml_Export_from",NULL,"xml_Export_from",$export_from);
echo "</p>";
echo "<p><label for=\"band_area\">Area:</label><br>";
pr_band_areas_select($area);
echo "</p>";
echo "<p><label for=\"xml_Export_prop_type\">Export properties:</label><br>";
?>
 
    	<label>Property Location:</label><select name="xml_Export_prop_type" id="xml_Export_prop_type">
<option value="all" <?if ($export_prop_types == '') {
	echo 'selected';
}?>>All</option>
<option value="lettings" <?if ($export_prop_types == 'lettings') {
	echo 'selected';
}?>>Lettings</option>
<option value="sales" <?if ($export_prop_types == 'sales') {
	echo 'selected';
}?>>Sales</option>
</select>
<?
echo "</p>";
echo "<p><label for=\"xml_mode\">Export mode:</label><br>";
?>
<select name="pr_xml_mode" id="xml_mode">
<option value="FULL" <?if ($export_mode == 'FULL' || $export_mode=='') {
	echo 'selected';
}?>>FULL</option>
<option value="INCR" <?if ($export_mode == 'INCR') {
	echo 'selected';
}?>>INCR</option>
</select>
<?
echo "</p>";

echo "<p>";
pr_edit_subform("submit","Save",NULL,"Save");
echo "</p>";
pr_edit_subform("form_end");
}

function pr_file_extension($filename)
{
	$ext = explode('.',$filename);
	return $ext[count($ext)-1];
}

function pr_swfupload_init($args)
{
global $user_ID;
	$_SESSION['user_id'] = $user_ID;
	$_u_info = get_userdata($user_ID);
	$_SESSION['identifier'] = md5($user_ID + $_u_info->lastname + $_u_info->level + $_u_info->login + $_u_info->email + $_u_info->firstname + rand()*14703900);

?>
	<link href="<?echo plugins_url('swfupload/css/default.css','swfupload');?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?echo plugins_url('swfupload/swfupload/swfupload.js','swfupload');?>"></script>
	<script type="text/javascript" src="<?echo plugins_url('swfupload/applicationdemo/js/handlers.js','swfupload');?>"></script>
<?
pr_swfupload_forms_init(&$args);
}
function pr_swfupload_forms_init($args)
{
	global $user_ID;
$vars = '';
$vars_prefix = 'swfu_';
$_n = sizeof($args)-1;
foreach($args as $k=>$arg)
{
	$vars .= $vars_prefix.$arg[0];
	if ($k<$_n) $vars .= ',';
}
	?>
	<script>
		// our thumnail.php path
		thumbnail = "<?echo plugins_url('swfupload/applicationdemo/thumbnail.php','swfupload');?>";
		//thumbnail_create = false; // ??? ???

		var <?echo $vars;?>;
		window.onload = function () {
<?
foreach($args as $arg)
{
list($name,$type) = $arg;
	switch($type)
	{
		case "pic":
			$_file_types = '*.jpg;*.jpeg';
			$_file_size_limit = '2 MB';
			$_file_types_description = 'JPG Images';
			$_thumbnail_create = 'true';
			$_button_text = '<span class="button">Select Images <span class="buttonSmall">(2 MB Max)</span></span>';
			$_debug = 'false';
		break;
		case "file":
			$_file_types = '*.doc;*.pdf;*.ppt';
			$_file_size_limit = '2 MB';
			$_file_types_description = 'Doc, PDF, PowerPoint files';
			$_thumbnail_create = 'false';
			$_button_text = '<span class="button">Select Files <span class="buttonSmall">(2 MB Max)</span></span>';
			$_debug = 'false';
		break;

	}

?>
			<?echo $vars_prefix.$name?> = new SWFUpload({
				// Backend Settings
				//upload_url: "http://www.webtrendz.co.uk/queensparkrealestates/wp-content/plugins/swfupload/applicationdemo/upload.php",
				upload_url: "<?echo plugins_url('properties/external_upload.php','properties');?>",
				post_params: {"PHPSESSID": "<?php echo session_id(); ?>","user_ID":"<?echo $user_ID?>","upload_type":"<?echo $type?>"<? if (isset($_GET['pr_id'])) {?>,"prid":"<?echo $_GET['pr_id'];?>"<?}?>},

				// File Upload Settings
				file_size_limit : "<?echo $_file_size_limit?>",	// 2MB
				file_types : "<?echo $_file_types?>",
				file_types_description : "<?echo $_file_types_description?>",
				file_upload_limit : "0",

				// Event Handler Settings - these functions as defined in Handlers.js
				//  The handlers are not part of SWFUpload but are part of my website and control how
				//  my website reacts to the SWFUpload events.
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,

				// Button Settings
				//button_image_url : "images/SmallSpyGlassWithTransperancy_17x18.png",
				button_placeholder_id : "spanButtonPlaceholder<?echo '_'.$name?>",
				button_width: 180,
				button_height: 18,
				button_text : '<?echo $_button_text;?>',
				button_text_style : '.button { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; } .buttonSmall { font-size: 10pt; }',
				button_text_top_padding: 0,
				button_text_left_padding: 18,
				button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
				button_cursor: SWFUpload.CURSOR.HAND,

				// Flash Settings
				flash_url : "<?echo plugins_url('swfupload/swfupload/swfupload.swf','swfupload');?>",

				custom_settings : {
					upload_target : "divFileProgressContainer<?echo '_'.$name?>"
				},

				// Debug Settings

				debug: <?echo $_debug?>
			});
<?
}
?>
		};
	</script>

	<?
}
function pr_swfupload_form($upload_name,$upload_type = 'pic')
{
	global $user_ID;
	switch($upload_type)
	{
		case "pic":

			$_thumbnail_create = true;

		break;
		case "file":

			$_thumbnail_create = false;

		break;
	}
	?>

<div>

	<div style="display: inline; border: solid 1px #7FAAFF; background-color: #C5D9FF; padding: 2px;">
		<span id="spanButtonPlaceholder<?echo '_'.$upload_name?>"></span>
	</div>


	<div id="divFileProgressContainer<?echo '_'.$upload_name?>" style="height: 75px;"></div>
	<?if ($_thumbnail_create == true) {?>
	<div id="thumbnails"></div>
	<?}?>

</div>
<?
}

function pr_upload_pic_tmp($pic,$filename,$u_ID) // called via AJAX
{
	global $wpdb,$pr_pic_table_tmp,$pr_tmp_pics;
	// $_SESSION vaiables must be set
//$u_ID = 1;
	$_ext = pr_file_extension($pic['name']);
	move_uploaded_file($pic['tmp_name'],$pr_tmp_pics.$filename.'.'.$_ext); // moving uploaded to tmp folder
	$wpdb->query($wpdb->prepare("INSERT INTO $pr_pic_table_tmp (ID,filename,user_id,identifier) values (NULL, '%s',%d,'%s')",$filename.'.'.$_ext,$u_ID,$_SESSION['identifier']));// adding rows to tmp table

}

function pr_transfer_tmp_pics($user_id,$prid) // called within the module, so has all the global variables
{
//$prid - is property ID
	global $wpdb,$pr_pic_table_tmp,$pr_pic_table,$pr_upload_pictures,$pr_upload_pictures_tmp;
	$tmp_pics = $wpdb->get_var($wpdb->prepare("SELECT COUNT(ID) FROM $pr_pic_table_tmp WHERE user_id = %d AND identifier = '%s'",$user_id,$_SESSION['identifier']));
	if ($tmp_pics > 0)
	{
		$tmp_pics = $wpdb->get_results($wpdb->prepare("SELECT filename FROM $pr_pic_table_tmp WHERE user_id = %d AND identifier = '%s'",$user_id,$_SESSION['identifier']));

		foreach($tmp_pics as $pic)
		{
			rename($pr_upload_pictures_tmp.$pic->filename,$pr_upload_pictures.$pic->filename);//moving file to an upload pics folder
			pr_thumbnail_create($pic->filename);
			$wpdb->query($wpdb->prepare("INSERT INTO $pr_pic_table (ID,prid,img_name) values (NULL,%d,'%s')",$prid,$pic->filename));

		}
		$wpdb->query($wpdb->prepare("DELETE FROM $pr_pic_table_tmp WHERE user_id = %d AND identifier = '%s'",$user_id,$_SESSION['identifier']));

	}
// also transfer files
pr_transfer_tmp_files($user_id,$prid);
}
function pr_upload_file_tmp($file,$filename,$u_ID) // called via AJAX
{
	global $wpdb,$pr_files_table_tmp,$pr_tmp_pics;
	// $_SESSION vaiables must be set

	//$_ext = pr_file_extension($file['name']);
	move_uploaded_file($file['tmp_name'],$pr_tmp_pics.$_SESSION['identifier'].'_'.$filename.'_'.$file['name']); // moving uploaded to tmp folder
	$wpdb->query($wpdb->prepare("INSERT INTO $pr_files_table_tmp (ID,filename,user_id,identifier) values (NULL, '%s',%d,'%s')",$_SESSION['identifier'].'_'.$filename.'_'.$file['name'],$u_ID,$_SESSION['identifier']));// adding rows to tmp table

}
function pr_transfer_tmp_files($user_id,$prid) // called within the module, so has all the global variables
{
//$prid - is property ID
	global $wpdb,$pr_files_table_tmp,$pr_files_table,$pr_upload_files,$pr_upload_pictures_tmp;
	$tmp_files = $wpdb->get_var($wpdb->prepare("SELECT COUNT(ID) FROM $pr_files_table_tmp WHERE user_id = %d AND identifier = '%s'",$user_id,$_SESSION['identifier']));
	//$wpdb->show_errors();
	//$wpdb->print_error();
	$_file_prefix = 'pr_'.$prid.'_';
	if ($tmp_files > 0)
	{
		$tmp_files = $wpdb->get_results($wpdb->prepare("SELECT filename FROM $pr_files_table_tmp WHERE user_id = %d AND identifier = '%s'",$user_id,$_SESSION['identifier']));

		foreach($tmp_files as $file)
		{
			$file_title = str_replace($_SESSION['identifier'].'_','',$file->filename);// �䠫�嬍

			rename($pr_upload_pictures_tmp.$file->filename,$pr_upload_files.$_file_prefix.$file->filename);//moving file to an upload files folder
			$wpdb->query($wpdb->prepare("INSERT INTO $pr_files_table (ID,prid,file_name,title) values (NULL,%d,'%s','%s')",$prid,$_file_prefix.$file->filename,$file_title));

		}
		$wpdb->query($wpdb->prepare("DELETE FROM $pr_files_table_tmp WHERE user_id = %d AND identifier = '%s'",$user_id,$_SESSION['identifier']));

	}
}
function pr_delete_tmp_pics($user_id) // it also will delete tmp_files
{
	global $wpdb,$pr_pic_table_tmp,$pr_upload_pictures_tmp,$pr_files_table_tmp;
// deletes pictures
	$tmps_ = $wpdb->get_results($wpdb->prepare("SELECT filename FROM $pr_pic_table_tmp WHERE user_id = %d",$user_id));
	//$wpdb->show_errors();
	//$wpdb->print_error();
	foreach($tmps_ as $tmp)
	{
		unlink($pr_upload_pictures_tmp.$tmp->filename);
	}
	$wpdb->query($wpdb->prepare("DELETE FROM $pr_pic_table_tmp WHERE user_id = %d",$user_id));
// now delete some files

	$tmps_ = $wpdb->get_results($wpdb->prepare("SELECT filename FROM $pr_files_table_tmp WHERE user_id = %d",$user_id));
	//$wpdb->show_errors();
	//$wpdb->print_error();
	foreach($tmps_ as $tmp)
	{
		unlink($pr_upload_pictures_tmp.$tmp->filename);
	}

	$wpdb->query($wpdb->prepare("DELETE FROM $pr_files_table_tmp WHERE user_id = %d",$user_id));
	//$wpdb->show_errors();
	//$wpdb->print_error();
}

function pr_show_prop_types()
{
	global $pr_prop_types;
	$form_prefix = 'prop_types_';

$fields = array();
$fields[] = array('key' => 'ID','name' => '#','type'=>'id');
$fields[] = array('key' => 'Name','name' => 'Name','type' => 'name');
$fields[] = array('key' => 'parent','name' => 'Parent','type' => 'parent');
$fields[] = array('key' => 'code','name' => 'Code','type'=>'additional');
$add_form_title = 'Add new property type';
pr_show_tree_form(&$pr_prop_types,&$fields,&$form_prefix,&$add_form_title);

}

function pr_get_area_parents($id,$type = 'root')
{
	global $wpdb,$pr_areas;
	$id_column = 'ID';
	$parent_column = 'parent_id';
	$name_column = 'name';
	$parents = pr_tree_get_parents(&$pr_areas,&$id,&$id_column,&$parent_column,&$name_column);
if (sizeof($parents)>0)
{
	$parents = array_reverse($parents);
	if ($type=='root') return $parents[0];// 殺⠿ 砯豼 - ꮰ孼 䥰墠 area
		else return $parents;
} else return NULL;
}
function pr_get_property_images($prid,$type = 'all')
{
	global $wpdb,$pr_pic_table,$pr_img_show_folder;
	switch($type)
	{
		case 'main':
			$pics = $wpdb->get_results("SELECT img_name FROM $pr_pic_table WHERE prid = $prid AND main = 1;"); //should be only one
			if ($pics != NULL) {
			foreach($pics as $k=>$pic)
			{
				$pics[$k] = $pr_img_show_folder.$pic->img_name;
			}
			//print_r($pics);
			return $pics;
			} else {
				$pics = $wpdb->get_results("SELECT img_name FROM $pr_pic_table WHERE prid = $prid LIMIT 0,1");
				if (sizeof($pics)>0) {
					foreach($pics as $k=>$pic)
					{
						$pics[$k] = $pr_img_show_folder.$pic->img_name;

					}
					return $pics;
				} else {return NULL;}
			}
		break;
		case 'without_main':
			$pics = $wpdb->get_results("SELECT img_name FROM $pr_pic_table WHERE prid = $prid AND main = 0;");
			if (pr_get_property_images($prid,'main'==NULL)) {
				$_omit_1st = true;
			} else $_omit_1st = false;
			//print_r($pics);
			if ($pics != NULL) {

			$_pics = array();
			foreach($pics as $k=>$pic)
			{
				if (!($_omit_1st == true and $k==0)) {
					$_pics[] = $pr_img_show_folder.$pic->img_name;
				}
			}
			return $_pics;
			}
				else {return NULL;}
		break;
		default:
			$pics = $wpdb->get_results("SELECT img_name FROM $pr_pic_table WHERE prid = $prid;");
			if ($pics != NULL) {
			foreach($pics as $k=>$pic)
			{
				$pics[$k] = $pr_img_show_folder.$pic->img_name;
			}
			return $pics;
			}

				else {return NULL;}
		break;
	}
}
function pr_get_property_files($prid,$type = 'all')
{
	global $wpdb,$pr_files_table,$pr_file_show_folder;
	$files = $wpdb->get_results("SELECT file_name FROM $pr_files_table WHERE prid = $prid ORDER BY ID ASC");
	foreach($files as $k=>$file)
	{
		$files[$k] = $pr_file_show_folder.$file->file_name;
	}
	switch($type)
	{
		case 'one':
			return $files[0];
		break;
		default:
			return $files;
		break;
	}
}
function pr_get_property_videos($prid,$type = 'all')
{
	global $wpdb,$pr_video_table;
	$vids = $wpdb->get_resutls("SELECT yt_id FROM $pr_video_table WHERE prid = $prid ORDER BY ID ASC");
	switch($type)
	{
		case 'one':
			return $vids[0];
		break;

		default:
			return $vids;
		break;
	}
}
function pr_get_property_type_parents($tid,$type = 'root')
{
	global $pr_prop_types;
	$id_column = 'ID';
	$parent_column = 'parent';
	$name_column = 'Name';
	$parents = pr_tree_get_parents(&$pr_prop_types,&$tid,&$id_column,&$parent_column,&$name_column);
if ($parents != NULL)
{
	$parents = array_reverse($parents);
	if ($type=='root') return $parents[0];// 殺⠿ 砯豼 - ꮰ孼 䥰墠 area
		else return $parents;
} else return NUll;
}

function pr_get_property_type_code($tid)
{
	global $wpdb,$pr_prop_types;
	return $wpdb->get_var($wpdb->prepare("SELECT code FROM $pr_prop_types WHERE ID = %d",$tid));
}

/*
// this function was creating thumbnails for those pictures, whic didn't have them
function pr_create_thumbs_for_old()
{ global $wpdb,$pr_pic_table;
$pics = $wpdb->get_results($wpdb->prepare('SELECT ID,img_name FROM '.$pr_pic_table,$id));
	//$wpdb->show_errors();
	//$wpdb->print_error();

	foreach($pics as $pic)
	{
		echo "$pic->img_name<br>";
		pr_thumbnail_create($pic->img_name);
	}
}
*/



///////////// My tree functions

function pr_tree_branch_delete($tree_table,$branch_id,$id_column)
{
	global $wpdb;
	$wpdb->query("DELETE FROM $tree_table WHERE $id_column = $branch_id");
	//$wpdb->show_errors();
	//$wpdb->print_error();
}

function pr_tree_branch_add($tree_table,$fields,$form_prefix)

{
	global $wpdb;
	// preparing all fields
$add = '';
$values = '';
$_size = sizeof($fields);
foreach($fields as $k=>$field)
{
	$add .= $field['key'];
	if ($k<$_size-1) $add .= ',';
	if ($field['type']=='id') {
			$id_column = $field['key'];
			$values .= 'NULL';
			}
	elseif ($field['type']=='parent') {
			$parent_column = $field['key'];
			$values .= $_POST[$form_prefix.$field['key']];
			}
	elseif ($field['type']=='name') {
			$name_column = $field['key'];
			$values .= "'".$_POST[$form_prefix.$field['key']]."'";
			}
	else $values .= "'".$_POST[$form_prefix.$field['key']]."'";
	if ($k<$_size-1) $values .= ',';
}
$sql = "INSERT INTO $tree_table ($add) values ($values);";	// ��쥸૮ Ỡ砹貳 譺媶詠�䥫಼, ��ﮪ࠽��ﭮ �ꮠ���୨�� ब譠.
$wpdb->query($sql);
//$wpdb->show_errors();
//$wpdb->print_error();
}


function pr_tree_branch_update($tree_table,$branch_id,$id_column,$fields,$form_prefix)
{
	global $wpdb;
		// preparing all fields
$set = '';
$_size = sizeof($fields);
foreach($fields as $k=>$field)
{
	if ($field['type']=='id') {
			$id_column = $field['key'];
			}
	elseif ($field['type']=='parent') {
			$parent_column = $field['key'];
			$set .= $field['key'].'='.$_POST[$form_prefix.$field['key']];
			}
	elseif ($field['type']=='name') {
			$name_column = $field['key'];
			$set .= $field['key'].'='."'".trim($_POST[$form_prefix.$field['key']])."'";
			}
	else $set .= $field['key'].'='."'".trim($_POST[$form_prefix.$field['key']])."'";
	if ($k<$_size-1 and $field['type']!='id') $set .= ',';
}
$sql = "UPDATE $tree_table SET $set WHERE $id_column = $branch_id;";	// ��쥸૮ Ỡ砹貳 譺媶詠�䥫಼, ��ﮪ࠽��ﭮ �ꮠ���୨�� ब譠.
$wpdb->query($sql);
//$wpdb->show_errors();
//$wpdb->print_error();
}


function pr_tree_dropdown($tree_table,$id_column,$parent_column,$name_column,$field_name,$selected = NULL,$disabled = NULL,$exclude = NULL,$first_item = 'one')

{
global $wpdb;
			if ($exclude != NULL) {
			$results = $wpdb->get_results("SELECT a.$id_column, a.$name_column, a.$parent_column FROM $tree_table a WHERE a.$id_column NOT IN ($exclude) ORDER BY a.$parent_column ASC, a.$name_column ASC, a.$id_column ASC");}
			else {$results = $wpdb->get_results("SELECT a.$id_column, a.$name_column, a.$parent_column FROM $tree_table a ORDER BY a.$parent_column ASC, a.$name_column ASC, a.$id_column ASC");}
			echo '<select name="'.$field_name.'">';
		switch($first_item)
		{
			case "one":
			echo '<option value=NULL>Select one</option>';
			break;
			case "all":
			echo '<option value="0">All</option>';
			break;
			case "none":
			echo '<option value="0">None</option>';
			break;
		}
			pr_tree_dropdown_options(0,0,&$results,0,$id_column,$parent_column,$name_column,NULL,$selected,$disabled);
			echo '</select>';
}

function pr_tree_dropdown_options($pid,$lvl,$results,$start,$id_column,$parent_column,$name_column,$stop = NULL, $selected_pid = NULL, $disabled_pid = NULL)
{
	//foreach($results as $area)
	//$start = 0;//䫿 �볷ॢ ꮣ䠠䥲蠢��堰�嫥鬠�મ堡�⠥�))
	if ($stop == NULL) $stop = sizeof($results);
	for ($i = $start;$i<$stop;$i++)
	{
	$branch = $results[$i];
	if ($branch->$parent_column > $pid)
		{
		$stop = $i;
		}

		else
		{
?>
<option
	<?if($selected_pid != NULL and $selected_pid == $branch->$id_column) {echo "selected";}
	if($disabled_pid != NULL and $disabled_pid == $branch->$id_column) {echo "disabled";}?>

	value="<?echo $branch->$id_column;?>">
<?echo str_repeat("-",$lvl);echo $branch->$name_column;?>
</option>
<?
	$child_id = pr_tree_find_child($branch->$id_column,$i,$stop,&$results,$id_column,$parent_column,$name_column);
	//print_r($child_id);
	if($child_id != false)
		{
			$lvl++;
			pr_tree_dropdown_options($branch->$id_column,$lvl,&$results,$child_id,$id_column,$parent_column,$name_column,$stop,$selected_pid,$disabled_pid);
			$lvl--;
		}
		//if($pid != 0) {unset($results[$i]);$i--;$stop--;}
		}
	}
}
function pr_show_tree($pid,$lvl,$results,$start,$id_column,$parent_column,$name_column,$stop = NULL, $selected_id = NULL, $disabled_id = NULL,$form_prefix = NULL,$fields,$tree_table)
{
	global $wpdb;
	if ($stop == NULL) $stop = sizeof($results);
	for ($i = $start;$i<$stop;$i++)
	{
	$branch = $results[$i];
	if ($branch->$parent_column > $pid)
		{
		$stop = $i;
		}
		else
		{
?>
<tr>
	<?
	if ($selected_id != null and $selected_id == $branch->$id_column)
	{
		foreach($fields as $field)
		{
				?>
				<td>
				<?
				if ($field['type']=='id')
				{
					echo '<a name="'.$branch->$field['key'].'">'.$branch->$field['key'].'</a>';
				}
				elseif ($field['type'] == 'parent')
				{pr_tree_dropdown(&$tree_table,&$id_column,&$parent_column,&$name_column,$form_prefix.$field['key'],$branch->$parent_column,null,null,'none');}
					elseif($field['type'] != 'id')
					{pr_edit_subform('text_input',null,null,$form_prefix.$field['key'],&$branch->$field['key']);}
						?>
				</td>
				<?
		}
			echo '<td>';
			echo '<a href="javascript:sureness(\'admin.php?page='.$_GET['page'].'&action='.$form_prefix.'_branch_delete&branch_id='.$branch->$id_column.	'\')">Delete</a>';
			echo ' | ';
			pr_edit_subform("submit");
			pr_edit_subform("hidden",NULL,NULL,'action',$_GET['action']);
			pr_edit_subform("hidden",NULL,NULL,'branch_id',$_GET['branch_id']);
			echo '</td>';
	}
		else {
		foreach($fields as $field)
		{
			echo '<td>';


			if ($field['type']=='name') {echo str_repeat("&nbsp;",$lvl);}

			if ($field['type']=='id')
			{
				echo '<a name="'.$branch->$field['key'].'">'.$branch->$field['key'].'</a>';
			}
				else echo $branch->$field['key'];

			echo '</td>';
		}

			echo '<td>';
			echo '<a href="javascript:sureness(\'admin.php?page='.$_GET['page'].'&action='.$form_prefix.'_branch_delete&branch_id='.$branch->$id_column.	'\')">Delete</a>';
			echo ' | ';
			echo '<a href="admin.php?page='.$_GET['page'].'&action='.$form_prefix.'_branch_edit&branch_id='.$branch->$id_column.'#'.$branch->$id_column.'">Edit</a>';
			echo '</td>';

			}
	?>

</tr>
<?
	$child_id = pr_tree_find_child($branch->$id_column,$i,$stop,&$results,&$id_column,&$parent_column,&$name_column);
	//print_r($child_id);
	if($child_id != false)
		{
			$lvl++;
			pr_show_tree($branch->$id_column,$lvl,&$results,$child_id,&$id_column,&$parent_column,&$name_column,$stop,&$selected_id,&$disabled_id,&$form_prefix,&$fields,&$tree_table);
			$lvl--;
		}
		//if($pid != 0) {unset($results[$i]);$i--;$stop--;}
		}
	}
}
function pr_tree_find_child($pid,$start,$stop,$results,$id_column,$parent_column,$name_column)
{
	$start = 0;//䫿 �볷ॢ ꮣ䠠䥲蠢��堰�嫥鬠�મ堡�⠥�))
	$answer = false;
	for ($i = $start;$i<$stop;$i++)

	{
		if($results[$i]->$parent_column == $pid and $answer == false) {$answer = $i;}
	}
	return $answer;
}

function pr_tree_get_parents($tree_table,$branch_id,$id_column,$parent_column,$name_column)
{
	global $wpdb;
	$results = array();
	$sql = "SELECT
		parent.$id_column,
		parent.$name_column,
		parent.$parent_column
		FROM $tree_table parent INNER JOIN $tree_table child
			ON parent.$id_column = child.$parent_column
		WHERE child.$id_column = $branch_id LIMIT 0,1;";
	$_parent = $wpdb->get_results($sql);
	//$wpdb->show_errors();
	//$wpdb->print_error();
	if (sizeof($_parent)>0)
	{
	$results[] = array('id' => $_parent[0]->$id_column,'name' => $_parent[0]->$name_column);
	if ($_parent[0]->$parent_column != 0)
		$results = array_merge($results,pr_tree_get_parents(&$tree_table,$_parent[0]->$id_column,&$id_column,&$parent_column,&$name_column));
	return $results;
	} else return NULL;
}

function pr_show_tree_form($tree_table,$fields = NULL,$form_prefix,$add_form_title)
{
//$fields is a two-dimensional array
	global $wpdb;

if ($fields != NULL and is_admin()){ // initialization is ok
// preparing all fields
$select = '';
$_size = sizeof($fields);
foreach($fields as $k=>$field)
{
	$select .= $field['key'];
	if ($k<$_size-1) $select .= ',';
	if ($field['type']=='id') $id_column = $field['key'];
	if ($field['type']=='parent') $parent_column = $field['key'];
	if ($field['type']=='name') $name_column = $field['key'];

}

// event handling
if (isset($_POST['action']))
{
switch($_POST['action'])
	{
	case $form_prefix.'_branch_add':
			pr_tree_branch_add(&$tree_table,&$fields,&$form_prefix);
	break;
	case $form_prefix.'_branch_edit':
		if (isset($_POST['branch_id']))
		{
			pr_tree_branch_update(&$tree_table,$_POST['branch_id'],&$id_column,&$fields,&$form_prefix);
		}
	break;
	}
}

// checking for editing some entry
/**/

if (isset($_GET['action']))
{
	switch ($_GET['action'])
	{
	case $form_prefix."_branch_edit":
		pr_edit_subform("form_start",NULL,NULL,$form_prefix."_branch_form","admin.php?page=".$_GET['page']);
	break;
	case $form_prefix.'_branch_delete':
		pr_tree_branch_delete(&$tree_table,$_GET['branch_id'],&$id_column);
	break;
	}
}

// output to display
pr_tree_add_form(&$tree_table,&$fields,&$form_prefix,&$add_form_title);
$results = $wpdb->get_results('SELECT '.$select.' FROM '.$tree_table.' ORDER BY '.$parent_column.' ASC, '.$name_column.' ASC, '.$name_column.' ASC');
?>
<table class="widefat">
<thead>
<tr>
	<?
	foreach($fields as $field)
	{
	?>
	<th class="manage-column column-title"><?echo $field['name']?></th>
	<?
	}
	?>
	<th class="manage-column column-title">Actions</th>
</tr>
</thead>
<tbody>
<?
	$selected_id = NULL;
	if (isset($_GET['action']) and ($_GET['action'] == $form_prefix.'_branch_edit') and isset($_GET['branch_id'])) $selected_id = $_GET['branch_id'];// ⻡�୭࿠䫿 �夠겨��� ⥲ꠠ䥰�
	pr_show_tree(0,0,&$results,0,&$id_column,&$parent_column,&$name_column,NULL, &$selected_id, NULL,&$form_prefix,&$fields,&$tree_table);
?>
</tbody>
</table>
<?
/**/
// checking for editing some entry
if (isset($_GET['action']) and $_GET['action'] == $form_prefix."_branch_edit")
{
	pr_edit_subform("form_end");
}

}

}

function pr_tree_add_form($tree_table,$fields,$form_prefix,$add_form_title = 'Add branch to a tree')
{
	?>
	<div class="pr_block">
	<div class="metabox-holder">
		<div class="postbox widefat">
<h3 class="manage-column column-title"><span><? echo $add_form_title ?></span></h3>
		<div class="inside">
	<?
	foreach($fields as $k=>$field)
{
	if ($field['type']=='id') $id_column = $field['key'];
	if ($field['type']=='parent') $parent_column = $field['key'];
	if ($field['type']=='name') $name_column = $field['key'];
}

	pr_edit_subform("form_start");
	pr_edit_subform("hidden",NULL,NULL,"action",$form_prefix.'_branch_add');

	foreach($fields as $field)
	{
		if ($field['type'] != 'id')
		{
			if ($field['type'] == 'parent')
			{
				echo '<p>'.$field['name'].' ';pr_tree_dropdown(&$tree_table,&$id_column,&$parent_column,&$name_column,$form_prefix.$field['key'],null,null,null,'none');echo '</p>';
			} else {
				echo '<p>'.$field['name'].' ';
				pr_edit_subform('text_input',null,null,$form_prefix.$field['key'],NULL);
				echo '</p>';
				}
		}
	}
	?><p><?pr_edit_subform("submit");?></p>
	<?
	pr_edit_subform("form_end");
	?>
		</div>
		</div>
	</div>
	</div>
	<?
}

function pr_user_delete($id)

{
	echo "user id is $id";
}
function pr_price($price,$echo = false)
{
	global $pr_slug;
	$price = number_format($price,2);

	if (!is_page($pr_slug)) {
		$price = '&pound;'.$price;
	}

	if ($echo == true)
		echo $price;
		else return $price;
}

function pr_prop_filter_form()
{
pr_edit_subform('price_sort_form');

pr_edit_subform('form_start'); //form start
pr_edit_subform("areas_front",$_SESSION['area_id_filter'],NULL,'area_id_filter',NULL); //filter by area
pr_edit_subform('text_input',NULL,NULL,'keyword_filter',$_SESSION['keyword_filter']); //filter by keyword
pr_edit_subform('user_list_all',NULL,NULL,'user_filter',$_SESSION['user_filter']); //filter by user
pr_edit_subform('property_type',NULL,NULL,'type_filter',$_SESSION['type_filter']); //filter by type
pr_edit_subform('submit', NULL, NULL, 'Filter'); //
pr_edit_subform('form_end'); //form end
// form to clear all that
pr_edit_subform('form_start');
pr_edit_subform('submit',NULL,NULL,'Clear filter');
pr_edit_subform('hidden',NULL,NULL,'clear_filter',1);
pr_edit_subform('form_end');
}


function pr_filter_properties()
{

if (isset($_GET['page_id'])) $page_id = $_GET['page_id']; else $page_id = 1;
if (isset($_GET['pr_del_id'])) pr_prop_delete($_GET['pr_del_id']);
pr_prop_filter_form();

pr_prop_filter_admin();

}
function pr_prop_filter_admin(){
global $wpdb,$pr_areas,$pr_properties,$pr_area_types,$pr_per_page,$pr_lettings_page,$pr_sales_page,$pr_slug;
/*$count = $wpdb->get_var("SELECT COUNT(ID) FROM $pr_properties WHERE property_type = $type");// ��� ��ᵮ䨬ࠢ�᮰ꠠ� ��岮젴諼��͊//$wpdb->show_errors();
//$wpdb->print_error();
// getting number of pages

$pages = bcdiv($count,$pr_per_page);
if(bcmod($count,$pr_per_page) > 0) $pages++;
$pagestring = "Pages ";

	for ($i = 1;$i <= $pages;$i++)
	{
		if ($page_id == $i)
		{
			$pagestring .= "<a class='selected' href=admin.php?page=".$_GET['page']."&page_id=".$i.">".$i."</a> ";
		} else {
			$pagestring .= "<a href=admin.php?page=".$_GET['page']."&page_id=".$i.">".$i."</a> ";
		}
	}

	$start = ($page_id-1)*$pr_per_page;//according to page we start our select from DB
*/
//we get data from DB according to type of properties


// checking filter data from sessions
// this will be precheck to cut a number of rows to filter by keywo rd
	$_first_clause = true;
if (isset($_SESSION['area_id_filter']) and $_SESSION['area_id_filter'] != 0) {
	$ID_arr = array();
	pr_find_children($_SESSION['area_id_filter'],&$ID_arr,false);
	$ids = pr_array_list($ID_arr);
	$_area_id_filter = "pr.area IN ($ids)";
	if ($_first_clause == false) {
		$_area_id_filter = ' AND '.$_area_id_filter;
	} else $_first_clause = false;
} else $_area_id_filter = '';

if (isset($_SESSION['user_filter']) and $_SESSION['user_filter'] != 'all') {
	$_user_filter = 'pr.user_id = '.$_SESSION['user_filter'];
	if ($_first_clause == false) {
		$_user_filter = ' AND '.$_user_filter;
	} else $_first_clause = false;
} else $_user_filter = '';

if (isset($_SESSION['type_filter']) and $_SESSION['type_filter'] != 0) {
	$_type_filter = 'pr.property_type = '.$_SESSION['type_filter'];
	if ($_first_clause == false) {

		$_type_filter = ' AND '.$_type_filter;
	} else $_first_clause = false;
}
if (isset($_SESSION['keyword_filter']) and $_SESSION['keyword_filter'] != '') {
	$_keyword_filter = 'MATCH (pr.addr_street,pr.addr_building_name,pr.addr_postcode, pr.descr) AGAINST (\''.$_SESSION['keyword_filter'].'\')';
	if ($_first_clause == false) {
		$_keyword_filter = ' AND '.$_keyword_filter;
	} else $_first_clause = false;
} else $_keyword_filter = '';

	$filter = $_area_id_filter.$_user_filter.$_type_filter.$_keyword_filter;
	if (strlen($filter) > 0) {
		$filter = 'WHERE '.$filter;
	}
$sql = "
	SELECT
	pr.ID,
	IF(pr.property_type=1,pr.let_weekrent, pr.sale_price)as price,
	pr.addr_door_number as door_number,
	pr.addr_street as street,
	pr.addr_postcode as postcode,
	a.name as area,
	pr.area as area_id,
	pr.user_id,
	pr.type as prop_type,
	pr.extra_active as active,
	pr.property_type as type,
	pr.approved as approved
	FROM $pr_properties pr LEFT JOIN $pr_areas a
		ON pr.area = a.ID
		$filter
		ORDER BY price ".$_SESSION['sort_by_price'].", pr.ID ASC;";
		//LIMIT $start,$pr_per_page;

$results = $wpdb->get_results($sql);
//$wpdb->show_errors();
//$wpdb->print_error();
//pr_edit_subform('price_sort_form');
//pr_m_($pagestring,"pagination","div");
pr_m_('Properties found - '.count($results));
?>
<table class="widefat">
<thead>
<tr>
	<th class="manage-column column-title">#</th>
	<th class="manage-column column-title">Address</th>
	<th class="manage-column column-title">User</th>
	<th class="manage-column column-title">Price</th>
	<th class="manage-column column-title">Type</th>
	<th class="manage-column column-title">Action</th>
	<th class="manage-column column-title">Active</th>
	<th class="manage-column column-title">Approved</th>
	<th class="manage-column column-title">Property type</th>
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
		<a href="<?echo get_permalink(get_page_by_path($pr_slug))."?pr_id=$prop->ID"?>">

		<?
		$_address_line = pr_get_prop_address($prop->ID);

/*		if ($prop->door_number != '' and $prop->door_number != NULL and $prop->door_number != 0) {
			if ($prop->prop_type == 63) {
				$_address_line[] = 'Flat '.$prop->door_number;// hardcoded Flat show
			} else $_address_line[] = $prop->door_number;
		}
		if ($prop->street != '' and $prop->street != NULL) $_address_line[] = $prop->street;
		if ($prop->area_id != '' and $prop->area_id != NULL and $prop->area_id != 0) $_address_line[] = pr_area_path($prop->area_id);
		if ($prop->postcode != '' and $prop->postcode != NULL) $_address_line[] = $prop->postcode;
		$_address_line = implode(', ',$_address_line);
   */
		//pr_m_($_address_line,NULL,"h1");
		echo $_address_line;
		//echo $prop->door_number.', '.$prop->street.', '.$prop->postcode.', '.pr_area_path($prop->area_id);
		?>

		</a>
		</td>
		<td>
		<?
		$user_info = get_userdata($prop->user_id);
		echo "<a href='".get_bloginfo('url')."/wp-admin/user-edit.php?user_id=$prop->user_id'>$user_info->user_login</a>";
		?>
		</td>
		<td>
		<?echo pr_price($prop->price);?>
		</td>
		<td>
		<?
		switch($prop->type) {
			case 1:
				echo "Letting";
				break;
			case 2:
				echo "Sale";
				break;

		}?>
		</td>
		<td>
		<?
		switch($prop->type){
			case 1:
				$edit_page = $pr_lettings_page;
				break;
			case 2:
				$edit_page = $pr_sales_page;
				break;
		}
		?>
		<a href="javascript:sureness('admin.php?page=<?echo $_GET['page']?>&pr_del_id=<?echo $prop->ID?>')">Delete</a>
		<a href="admin.php?page=<?echo $edit_page?>&pr_id=<?echo $prop->ID?>&page_id=<?if(isset($_GET['page_id'])) echo $_GET['page_id']; else echo 1;?>">Edit</a>
		</td>
		<td>
		<?if ($prop->active == 1) echo "yes"; else echo "no";?>
		</td>
		<td>
		<?if ($prop->approved == 1) echo "yes"; else echo "no";?>
		</td>
		<td>
		<?
		$_type = pr_get_prop_type($prop->ID);
		if ($_type == false) echo '<span class=Na>N/a</span>';
			else echo $_type->Name;
		?>
		</td>
	</tr>
	<?
}
?>

</tbody>

</table>
<?
//pr_m_($pagestring,"pagination","div");
}
/**
 WTZ function for editor
 */
function the_editor_wtz($content, $id = 'content', $canvasname, $prev_id = 'title', $media_buttons = false, $tab_index = 1) {
$rows = get_option('default_post_edit_rows');
if (($rows < 3) || ($rows > 100))
	$rows = 12;

if ( !current_user_can( 'upload_files' ) )
	$media_buttons = false;

$richedit =  user_can_richedit();
$class = '';

if ( $richedit || $media_buttons ) { ?>
	<div id="editor-toolbar">

<?php
if ( $richedit ) {
$wp_default_editor = wp_default_editor(); ?>
		<div class="zerosize"><input accesskey="e" type="button" onclick="switchEditors.go('<?php echo $id; ?>')" /></div>
<?php	if ( 'html' == $wp_default_editor ) {
add_filter('the_editor_content', 'wp_htmledit_pre'); ?>
			<a id="edButtonHTML" class="active hide-if-no-js" onclick="switchEditors.go('<?php echo $id; ?>', 'html');"><?php _e('HTML'); ?></a>
			<a id="edButtonPreview" class="hide-if-no-js" onclick="switchEditors.go('<?php echo $id; ?>', 'tinymce');"><?php _e('Visual'); ?></a>
<?php	} else {
$class = " class='theEditor'";
add_filter('the_editor_content', 'wp_richedit_pre'); ?>
			<a id="edButtonHTML" class="hide-if-no-js" onclick="switchEditors.go('<?php echo $id; ?>', 'html');"><?php _e('HTML'); ?></a>
			<a id="edButtonPreview" class="active hide-if-no-js" onclick="switchEditors.go('<?php echo $id; ?>', 'tinymce');"><?php _e('Visual'); ?></a>
<?php	}
}

if ( $media_buttons ) { ?>
		<div id="media-buttons" class="hide-if-no-js">
<?php	do_action( 'media_buttons' ); ?>
		</div>
<?php
} ?>
	</div>
<?php
}
?>
	<div id="quicktags"><?php
	wp_print_scripts( 'quicktags' ); ?>
	<script type="text/javascript">edToolbar_wtz('<?echo $canvasname;?>')</script>
	</div>

<?php
$the_editor = apply_filters('the_editor', "<div id='editorcontainer'><textarea rows='$rows'$class cols='40' name='$id' tabindex='$tab_index' id='$id'>%s</textarea></div>\n");
$the_editor_content = apply_filters('the_editor_content', $content);

printf($the_editor, $the_editor_content);

?>
	<script type="text/javascript">
	<?echo $canvasname;?> = document.getElementById('<?php echo $id; ?>');
	</script>
<?php
}

function pr_date_show($date, $time = false){

	$_date_format = get_option('date_format');
	$date = new DateTime($date);
	if ($time == true) {
		$_time_format = get_option('time_format');
		$date = $date->format($_date_format.' '.$_time_format);
	} else $date = $date->format($_date_format);

	//date($_date_format,$date);

	return $date;
}
function pr_date_save($date, $time = false){
	global $date_save_format,$datetime_save_format;
//echo $date;
	$date = str_replace('/','.',$date);
	$date = new DateTime($date);
//print_r($date);
	if ($time == true) {
		$date1 = $date->format(get_option('time_format'));
		$date1 = $date->format($datetime_save_format);
	} else {
			//echo get_option('date_format');
			$date1 = $date->format(get_option('date_format'));//print_r($date1);
			$date1 = $date->format($date_save_format);
	}
//print_r($date1);
	return $date1;
}
function pr_dateinput($jquery_elements, $values = false,$min = NULL,$max = '600',$yearRange = NULL){
	$_date_format = get_option('date_format');
	$_date_format = str_replace('j','d',$_date_format); 	//Day of the month as digits; no leading zero for single-digit days.
	$_date_format = str_replace('d','dd',$_date_format); 	//Day of the month as digits; leading zero for single-digit days.
	$_date_format = str_replace('D','ddd',$_date_format); 	//Day of the week as a three-letter abbreviation.
	$_date_format = str_replace('l','dddd',$_date_format); 	//Day of the week represented by its full name.

	$_date_format = str_replace('n','m',$_date_format); 	//Month as digits; no leading zero for single-digit months.
	$_date_format = str_replace('m','mm',$_date_format); 	//Month as digits; leading zero for single-digit months.
	$_date_format = str_replace('M','mmm',$_date_format); 	//Month as a three-letter abbreviation.
	$_date_format = str_replace('F','mmmm',$_date_format); 	//Month represented by its full name.

	$_date_format = str_replace('y','yy',$_date_format); 	//Year as last two digits; leading zero for years less than 10.
	$_date_format = str_replace('Y','yyyy',$_date_format); 	//Year represented by four digits.
	?>
<script src="http://cdn.jquerytools.org/1.2.5/full/jquery.tools.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    <?
		$elems = explode(', ',$jquery_elements);
    	foreach($elems as $k=>$elem)
    	{
			$elem = trim($elem);
    		echo "$('$jquery_elements').dateinput({ format: '$_date_format', selectors: true";
    		if ($values != false) {
    			if ($values[$k] != '0000-00-00') {
    				//list($_y,$_m,$_d) = explode('-',$values[$k]);
    				//echo ", value: '$values[$k]'";
    				echo ", value: '".pr_date_show($values[$k])."'";
    			}
    		}
			echo ", max: $max";
			if ($min !=NULL) echo ", min: $min";
			if ($yearRange !=NULL) echo ", yearRange: $yearRange";
			echo "});\n";
    	}
    ?>
//	$('<?echo $jquery_elements?>').dateinput({ format: '<?echo $_date_format;?>', selectors: true, max: <?echo $max;?><?if ($min != NULL) echo ", min: $min";?> });

var border_color = $('#door_number').css('border-color');
var color = $('#door_number').css('color');

$('#door_number').change(function(){
var contains_space = $('#door_number').val();
if (contains_space.indexOf(' ')>0) {
	$('#door_number').css({'border-color': 'red', 'color' : 'red'});
	$('#submit_button').hide();
} else {
	$('#door_number').css({'border-color': '#DFDFDF', 'color' : '#000'});
	$('#submit_button').show();
}
});


});
</script>
	<?

}
function pr_user_prop_reassign(){
	global $wpdb,$pr_properties,$pr_bands_new,$id;
	$sql = "UPDATE $pr_properties SET user_id=%d WHERE user_id=%d";
	$wpdb->query($wpdb->prepare($sql,$_POST['reassign_user'],$id));

	$pr_bands = $pr_bands_new;
	$sql = "UPDATE $pr_bands SET userid=%d WHERE userid=%d";
	$wpdb->query($wpdb->prepare($sql,$_POST['reassign_user'],$id));
}

function pr_editor_init($content,$name){
	?>
<script type="text/javascript" src="<?bloginfo('url')?>/wp-content/plugins/properties/jwysiwyg/jquery.wysiwyg.js"></script>
<script type="text/javascript">
$(function()
  {
      $('#pr_descr').wysiwyg();
  });
$("#pr_descr").width('100%');

</script>
	<?
}
function pr_print_button($name = 'Print This Page'){
	?>
<script>
document.write("<input type='button' " +
"onClick='window.print()' " +
"class='printbutton' " +
"value='<?echo $name;?>'/>");
</script>
	<?
}
function pr_print_property($id)//property details
{
global $wpdb,$pr_areas,$pr_properties,$pr_area_types,$pr_prop_types,$pr_pic_table,$pr_per_page,$pr_slug,$pr_img_show_folder,$pr_default_img;
$type = $wpdb->get_var($wpdb->prepare('SELECT property_type as type FROM '.$pr_properties.' WHERE ID = %d',$id));
global $_lettings_date_check,$_sales_date_check;

$curr_user = get_userdata($_SESSION['user_id']);
	//print_r($curr_user);
if ($curr_user->user_level>=8) {
	//echo "admin";
	$_where_lettings = "WHERE pr.ID = %d";
	$_where_sales = "WHERE pr.ID =%d";
} else {
	$_where_lettings = "WHERE pr.ID = %d AND pr.extra_active = 1 AND pr.approved = 1 AND $_lettings_date_check";
	$_where_sales = "WHERE pr.ID =%d AND pr.approved = 1 AND $_sales_date_check";
}
switch($type)
{
	case 1://LETTING
		$name = 'lettings';
		$results = $wpdb->get_results($wpdb->prepare("SELECT pr.ID, pr.let_weekrent as price,pr.let_monthrent as price_pm, pr.addr_door_number as door_number, pr.addr_street as street, pr.addr_postcode as postcode, a.name as area, pr.area as area_id, pt.Name as pr_type, pr.descr, pr.bedroomnum, pr.extra_status FROM $pr_properties pr LEFT JOIN $pr_areas a ON pr.area = a.ID LEFT JOIN $pr_prop_types pt ON pr.type = pt.ID $_where_lettings;",$id));
		break;
	case 2://SALE

		$name = 'sales';
		$results = $wpdb->get_results($wpdb->prepare("SELECT pr.ID, pr.sale_price as price, pr.addr_door_number as door_number, pr.addr_street as street, pr.addr_postcode as postcode, a.name as area, pr.area as area_id, pt.Name as pr_type, pr.descr, pr.bedroomnum, pr.extra_status FROM $pr_properties pr LEFT JOIN $pr_areas a ON pr.area = a.ID LEFT JOIN $pr_prop_types pt ON pr.type = pt.ID $_where_sales;",$id));
		break;
}
//$wpdb->show_errors();
//$wpdb->print_error();
if (sizeof($results) > 0) // if we selected property is appropriate
{
?>
	<div class="print_btn">
		<?pr_print_button();?>
	</div>
	<div id="property">

	<?
	foreach($results as $prop)
	{

	if ($prop->door_number != '' || $prop->door_number != NULL) echo $prop->door_number;
	if ($prop->street != '' || $prop->street != NULL) echo ', '.$prop->street;
	if ($prop->area_id != '' || $prop->area_id != NULL) echo ', '.pr_area_path($prop->area_id);
	if ($prop->postcode != '' || $prop->postcode != NULL) echo ', '.$prop->postcode;

	//pr_m_($prop->street.', '.pr_area_path($prop->area_id),NULL,"h1");
	?>
<? if ($prop->bedroomnum > 1) {
	echo "Number of Bedrooms $prop->bedroomnum";
} elseif ($prop->bedroomnum == 1) {
	echo "Number of Bedroom $prop->bedroomnum";
}
?>
			<div class="right">
				<?
				switch($type)
				{
					case 1:
						pr_m_("&#163;".pr_price($prop->price)." P/W");
						if ($prop->price_pm != NULL) pr_m_("&#163;".pr_price($prop->price_pm)." P/M");
						else pr_m_("&#163;".pr_price(round(4*$prop->price,2))." P/M");
						break;
					case 2:
						pr_m_("&#163;".pr_price($prop->price));
						break;
				}?>
			</div>
<??>
	<div id="images">
	<?prf_images($id)?>
	</div>
<??>
		<div id="information">
		<h3>Description</h3>
		<div id="description">
			<?echo $prop->descr;?>
		</div>
<?/*?>
		<h3>Video</h3>
		<div id="videos">

			<p><?prf_videos($id);?></p>

		</div>
<?*/?>
<?/*?>
		<h3>Attachments</h3>
		<div id="files">

			<p>
			<?prf_files($id, false);?>
			</p>

		</div>
<?*/?>
		<?//prf_arrange_view($id);?>
		<?//prf_tell_friend_form($id);?>

	</div>

	<?//pr_m_("Under construction","h2");
}
?>
	</div>
	<?
} else pr_m_('This property can not be viewed due to its setup. If you feel that this is a mistake, contact administration please.','error','h1');

}


function pr_print_button_forms($id,$_address_line,$id_name = 'prid',$page = '/print_property.php?',$button_text = 'Print this property'){
$_address_line = str_replace(' ','_',$_address_line);
?>
<input class="button-secondary" type="button" onclick="open_win('<?echo plugins_url($page.$id_name.'='.$id, __FILE__)?>','<?echo $_address_line;?>',800,600)" value="<?echo $button_text?>">

<?
}
function pr_tmp_new($user_id, $type){
	global $pr_tmp_properties,$pr_properties,$wpdb;

	pr_user_tmp_cleanup($user_id);	// �䠫孨堢�嬥��� �੫蠪ల譮꠯�蠧ࣰ�窥

	$sql = "DELETE FROM $pr_tmp_properties WHERE editor_id = $user_id";
	$wpdb->query($sql);

	if (isset($_GET['pr_id'])) $prid = $_GET['pr_id'];
		elseif (isset($_GET['prf_edit_id'])) $prid = $_GET['prf_edit_id'];
			else $prid = NULL;

	if ($prid != NULL) {
		$descr = "DESCRIBE $pr_properties";
		$descr = $wpdb->get_results($descr);
		$fields = array();

		foreach($descr as $_descr)
			if ($_descr->Field != 'ID') $fields[] = $_descr->Field; // 豪뾷६ ID 觠�僧ꠠꮯ谳嬻� �륬孲 ��觡妠�� 䳡먰��

		$descr = implode(",",$fields);

		$sql = "INSERT INTO $pr_tmp_properties ($descr) SELECT $descr FROM $pr_properties WHERE $pr_properties.ID = $prid"; // ��� ᳤岠Ⱳࢫ孠ID ���屲⳾�婠property, 䳡먰�� ��嫨��岱� �嬬 ������ ꫾�嬠�⫿岱� editor_id
	} else $sql = "INSERT INTO $pr_tmp_properties (ID, editor_id, property_type) values (NULL, $user_id, $type)";
	$wpdb->query($sql);
//	$wpdb->show_errors();
//	$wpdb->print_error();
	$ID = $wpdb->get_var("SELECT LAST_INSERT_ID();");

	if ($prid != NULL) {
		$sql = "UPDATE $pr_tmp_properties SET editor_id = $user_id WHERE ID = $ID";
		$wpdb->query($sql);
	}
// �볦塭ﮫ堥ditor_id. �.ꮠuser_id ﰨ ﰥ⼾ 觠ब譠嫨 殺宯�夥뿥���

//$res = $wpdb->get_var($wpdb->prepare('SELECT property_type as type FROM '.$pr_tmp_properties.' WHERE ID = %d',$ID));
//echo $res;

	return $ID;
}
function pr_preview_button($form_preview, $type, $text = "Show preview"){
global $pr_slug,$user_ID;
	$tmp_id = pr_tmp_new($user_ID,$type);
	if (is_admin()) {
		$_class = 'button-secondary';
	} else $_class = 'submit';
?>
<input type="button" value="<?echo $text?>" name="preview" id="preview_btn" class="<?echo $_class;?>">
<script>
    $(document).ready(function() {
		$("#preview_btn").click(function() {string = $("#<?echo $form_preview?>").serialize() + "&act=preview&tmp_id=<?echo $tmp_id;?>";$.post("<?echo  plugins_url('/make_preview_ajax.php', __FILE__);?>", string,function() {window.open("<?echo get_permalink(get_page_by_path($pr_slug))?>?pr_id=<?echo $tmp_id;?>&act=preview<?if (isset($_GET['pr_id'])) echo '&edited_id='.$_GET['pr_id'];?>","Preview property");});});
    });
</script>
	<?
/**/

}
function pr_user_tmp_cleanup($user_id)
{
	global $pr_pic_table_tmp, $pr_files_table_tmp, $pr_upload_pictures_tmp, $pr_tmp_video_table, $wpdb;

// cleaning up pics
			$pics = $wpdb->get_results('SELECT filename as img_name FROM '.$pr_pic_table_tmp.' WHERE user_id = '.$user_id);
			foreach($pics as $pic)
			{
				if (file_exists($pr_upload_pictures_tmp.$pic->img_name)) unlink($pr_upload_pictures_tmp.$pic->img_name);
				if (file_exists($pr_upload_thumbs.$pic->img_name)) unlink($pr_upload_thumbs.$pic->img_name);// delete thumbs, they don't exist, but anyway they might in future versions
			}
			$wpdb->query('DELETE FROM '.$pr_pic_table_tmp.' WHERE user_id = '.$user_id);



// cleaning up fiels
			$files = $wpdb->get_results('SELECT filename as file_name FROM '.$pr_files_table_tmp.' WHERE user_id = '.$user_id);
			foreach($files as $file)
			{
				if (file_exists($pr_upload_pictures_tmp.$file->file_name)) unlink($pr_upload_pictures_tmp.$file->file_name);

			}
			$wpdb->query('DELETE FROM '.$pr_files_table_tmp.' WHERE user_id = '.$user_id);

			//$wpdb->show_errors();
			//$wpdb->print_error();

// cleaning up videos
	$videos = "DELETE FROM $pr_tmp_video_table WHERE user_id = $user_id";
	$wpdb->query($videos);

}
function pr_video_add_update($pr_id){
	global $pr_video_table, $pr_tmp_video_table, $user_ID, $wpdb, $pr_prefix;

	if (isset($_POST['act']) and $_POST['act'] == 'preview') {
		$pr_video_table = $pr_tmp_video_table;
	}
	$check = $wpdb->get_var($wpdb->prepare("SELECT COUNT(prid) FROM ".$pr_video_table." WHERE prid = %d",$pr_id));
	if ($check != 0)
	{
		$wpdb->query($wpdb->prepare("UPDATE ".$pr_video_table." SET yt_id='%s' WHERE prid = %d",$_POST[$pr_prefix.'yt_id'],$pr_id));
	} else
	{
		$wpdb->query($wpdb->prepare("INSERT INTO ".$pr_video_table." (ID,prid,yt_id,user_id) values (NULL,".$pr_id.",'%s',$user_ID)",$_POST[$pr_prefix.'yt_id']));
	}
	//$wpdb->show_errors();
	//$wpdb->print_error();
}
function pr_get_prop_state($prid){
	global $wpdb,$selling_state,$pr_properties;
	return $selling_state[$wpdb->get_var('select extra_status from '.$pr_properties.' where ID='.$prid)];
}
function pr_get_prop_tenure($prid){
	global $wpdb,$property_tenure,$pr_properties;
	return $property_tenure[$wpdb->get_var('select tenure from '.$pr_properties.' where ID='.$prid)];
}
function pr_get_prop_address($prid,$type='general'){
	global $wpdb,$pr_properties;
	$select = "SELECT
		pr.addr_door_number as door_number,
		pr.addr_street as street,
		pr.addr_postcode as postcode,
		pr.area as area_id,
		pr.addr_building_name as building_name,
		pr.type as prop_type
		from $pr_properties pr
		where pr.ID=$prid";
	$props = $wpdb->get_results($select);
//	print_r($props);
	$_address_line = array();
	foreach($props as $prop){

	if ($prop->door_number != '' and $prop->door_number != NULL and $prop->door_number != 0 and is_admin() and $type!='export') {
		if ($prop->prop_type == 63) {
			$_address_line['door_number'] = 'Flat '.$prop->door_number;// hardcoded Flat show
		} else $_address_line['door_number'] = $prop->door_number;
	}

	if ($prop->building_name != '' and $prop->building_name != NULL and $type!='export') $_address_line['building_name'] = $prop->building_name;
	if ($prop->street != '' and $prop->street != NULL) $_address_line['street'] = $prop->street;
	//if ($prop->postcode != '' and $prop->postcode != NULL) $_address_line['postcode'] = $prop->postcode;

	if ($prop->area_id != '' and $prop->area_id != NULL and $prop->area_id != 0) {

/*
if (!is_admin) {
			$area_path = pr_area_path($prop->area_id,'array');
			if (trim($area_path[sizeof($area_path)-1])=='United Kingdom') {
				$_area_path_last = $area_path[sizeof($area_path)-2];
				$_area_path_other = $area_path[sizeof($area_path)-2];
			} else
			$_address_line['area_path'] = ;
		} else
*/
 $_address_line['area_path'] = pr_area_path($prop->area_id,'string',$prop->postcode);
	}

	}
/*
	if (!is_admin() and trim($area_path[sizeof($area_path)-1])=='United Kingdom') {
		$_front_uk_addr_line = array();
		$_front_uk_addr_line[] = $_address_line['street'];
		$_front_uk_addr_line[] = $_address_line['street'];
		$_address_line = implode(', ',$_front_uk_addr_line);
	} else */$_address_line = implode(', ',$_address_line);
	if ($type=='export') {
		$_address_line = explode(', ', $_address_line);
		unset($_address_line[sizeof($_address_line)-1]);
		$_address_line = implode(', ', $_address_line);
	}

	return $_address_line;
}
function pr_get_property_type($prid){ // letting or sales
	global $wpdb,$pr_property_types,$pr_properties;
	$select = "

	SELECT t.typeid, t.type_name
		FROM $pr_properties pr INNER JOIN $pr_property_types t
			ON pr.property_type=t.typeid
		WHERE pr.ID=$prid
	";
	$type = $wpdb->get_results($select);
	if (sizeof($type)>0) {
		return $type[0];
	} else {
		return false;
	}
}
function pr_get_prop_type($prid){ // one of the many
	global $wpdb,$pr_prop_types,$pr_properties;
	$select = "

	SELECT t.ID,t.Name,t.parent,t.code
		FROM $pr_properties pr INNER JOIN $pr_prop_types t
			ON pr.type=t.ID
		WHERE pr.ID=$prid
	";
	$type = $wpdb->get_results($select);
	if (sizeof($type)>0) {
		return $type[0];
	} else {
		return false;
	}
}
function pr_notifications_page(){
	global $pr_ntf_opt,$pr_ntf_opt_names;
//delete_option($pr_ntf_opt_names);
if (!get_option($pr_ntf_opt_names)) {
	$option_names = array();
	$option_names[1] = 'Paid property added (Admin)';
	$option_names[2] = 'Paid property added (User)';
	$option_names[3] = 'Non paid property added (Admin)';
	$option_names[4] = 'Non paid property added (User)';
	$option_names[5] = 'Payment confirmation (Admin)';
	$option_names[6] = 'Payment confirmation (User)';
	update_option($pr_ntf_opt_names, $option_names);
}
?>
<div class="wrap">
<?
pr_m_('<img src="'.plugins_url('properties/images/notification.png').'" /> Notifications','','h2');
?>
</div>
<?
$option_names = get_option($pr_ntf_opt_names);
if (sizeof($option_names)>0) {
?>
		<ul class="subsubsub">
		<?
		foreach ($option_names as $i=>$option_name){
		?>
			<li class="">
			<a class="<?if ($_GET['option']==$i) {
				echo 'current';
			}?>" href="admin.php?page=<? echo $_GET['page']?>&option=<?echo $i?>"><?echo $option_name;?></a>
			<?if (bcmod($i, 2)==0 and $i!=sizeof($option_names)) {
				echo ' | ';
			}?>
			</li>
			<?
}
?>
		</ul>
		<?
}


		?>
<div class="pr_block clear full_width">
	<div class="metabox-holder">
		<div class="postbox widefat">
		<h3 class="manage-column column-title"><span><?if (isset($_GET['option'])) {echo $option_names[$_GET['option']]; }else echo 'Notifications'; ?></span></h3>
		<div class="inside">
<?
if (isset($_GET['option']))
{
	if (get_option($pr_ntf_opt))
	{
		$options = get_option($pr_ntf_opt);
		if (isset($_POST['submit']) and isset($_POST['pr_msg_subject']) and isset($_POST['pr_msg_text'])) {
			$options[$_GET['option']]['title'] = $_POST['pr_msg_subject'];
			$options[$_GET['option']]['body'] = $_POST['pr_msg_text'];
			update_option($pr_ntf_opt, $options);
			$options = get_option($pr_ntf_opt);
		}
?>
	<form enctype="multipart/form-data" method="post" action="" id="" name="">
		<p>Subject<br>
			<input type="text" value="<?echo $options[$_GET['option']]['title'];?>" name="pr_msg_subject" id="pr_subj_ntf" style="width: 550px;">
		</p>
		<p>Message text<br>
			<textarea id="msg_ntf" name="pr_msg_text" style="width: 550px; height: 150px;"><?echo $options[$_GET['option']]['body'];?></textarea>
		</p>
	<input type="hidden" value="<?echo $_GET['option']?>" name="pr_ntf_option">
		<p>	<input type="submit" id="" class="button-primary" value="Submit" name="submit">
		</p>
	</form>
<p class="tags">
Tags:
<?
global $pr_ntf_tags;

$tags = implode(', ',$pr_ntf_tags);
echo $tags;
?>
</p>
		<?
	}
} else {
	?>
	<p>
	Choose Notification type to edit from upper row
	</p>
	<?
}
?>
		</div>
		</div>
	</div>
</div>
<?
}
function pr_ntf_prepare($text, $pr_id){
	global $current_user,$pr_ntf_tags;

	$tags = $pr_ntf_tags;

	get_currentuserinfo();

	$parsed_tags = array($current_user->user_firstname,$current_user->user_lastname,$current_user->user_email,date('d-m-Y h:m:s'),pr_get_property_link($pr_id,'admin'),pr_get_property_link($pr_id));

	$text = str_ireplace($tags, $parsed_tags, $text);

	return $text;
}
function pr_ntf_send($pr_ids, $type){
	//echo '<h2>hook works</h2>';
	global $pr_u_adds_pp,$pr_u_adds_npp,$pr_u_adds_pfp,$pr_ntf_opt;
	global $wpdb,$pr_properties;
	// hardcoded mapping of hook(opt_name) to body and title for user and admin
	$pr_ntfs_mapping = array($pr_u_adds_pp=>array(1,2),$pr_u_adds_npp=>array(3,4),$pr_u_adds_pfp=>array(5,6));

	$mapping = $pr_ntfs_mapping[$type];

//	echo $type;
//	print_r($pr_ids);
	switch($type){
		case $pr_u_adds_pp:
				foreach ($pr_ids as $pr_id){
					// several emails need to be sent
					pr_ntf_send_to($mapping,$pr_id);
				}
			break;
		case $pr_u_adds_npp:
			foreach ($pr_ids as $pr_id){
				// several emails need to be sent
				pr_ntf_send_to($mapping,$pr_id);
			}
			break;
		case $pr_u_adds_pfp:
			// at this moment we actually send to this function basket ids
			$basket_ids = implode(', ',$pr_ids);
			// get pr_ids for all of the basket ids
			$sq = "SELECT ID FROM $pr_properties WHERE basketid IN ($basket_ids)";
			$pr_ids = $wpdb->get_results($sq);
			foreach ($pr_ids as $pr_id){
				$pr_id = $pr_id->ID;
				// several emails need to be sent
				pr_ntf_send_to($mapping,$pr_id);
			}
			break;
		default:
			pr_m_('Can\'t send Notification due to wrong type of hook. Contact developer');
	} // switch
}
function pr_get_property_link($prid,$type='frontend'){
	global $pr_properties,$wpdb,$pr_slug,$pr_sales_page,$pr_lettings_page;

	$pr_type = $wpdb->get_var("SELECT property_type FROM $pr_properties WHERE ID=$prid");
	switch($type){
		case 'admin':
			switch($pr_type){
				case 1:
					$link = site_url('/wp-admin/admin.php?page='.$pr_lettings_page.'&pr_id='.$prid);

					break;
				default:
					$link = site_url('/wp-admin/admin.php?page='.$pr_sales_page.'&pr_id='.$prid);;
			} // switch
			break;
		default:
			$link = get_permalink(get_page_by_path($pr_slug)).'?pr_id='.$prid;
	} // switch
	return $link;
}
function pr_ntf_send_to($mapping,$pr_id){
	global $current_user,$pr_ntf_opt;

	$admin_mapping = array(1,3,5);
	$user_mapping = array(2,4,6);
	$admin_email = get_bloginfo('admin_email');

	$options = get_option($pr_ntf_opt);


	get_currentuserinfo();
	$user_email = $current_user->user_email;
	foreach ($mapping as $opt_id){
		// whom to send to??
		if (in_array($opt_id,$admin_mapping)) {
			$to = $admin_email;
		} elseif (in_array($opt_id,$user_mapping)){
			$to = $user_email;
		}
		//prepare title and body
		$title = pr_ntf_prepare($options[$opt_id]['title'], $pr_id);
		$body = pr_ntf_prepare($options[$opt_id]['body'], $pr_id);
		// some headers
		$blogname = get_settings('blogname');
		//$admin_email = get_settings('admin_email');
		// end edits for function wpmem_inc_regemail()
		$headers = 'From: '.$blogname.' <'.$admin_email.'>' . "\r\n";
		// send it finally
		mail($to,$title,$body,$headers);
	}
}
function pr_check_chargeble($prid){
	global $pr_properties,$exclude_areas,$wpdb,$pr_areas;
	$props = $wpdb->get_results("SELECT ID, area FROM $pr_properties WHERE ID = $prid AND property_type = 2;");
//print_r($props);
	if (sizeof($props)>0) {
		$prop = $props[0];
		$_excl_arid = array();
		$_excl_area = $exclude_areas;// ????????? ???? ?? ?? ????????? ????????????
		//print_r($_excl_area);
		foreach ($_excl_area as $area)
		{
			$_excl_arid[] = $wpdb->get_var("SELECT ID FROM $pr_areas WHERE name = '$area'");// ???????? ?? ??? ??????????? ???
		}
		//print_r($_excl_arid);
		if(!in_array($prop->area,$_excl_arid) and pr_check_parent($prop->area,$_excl_arid)==false)
		{
			return $prop->ID;
		} else return 0; // proerty not chargebale

	} else {

		return 0; // proerty not chargebale
	}
}

function pr_property_types_select($id=0, $instance=''){
	global $wpdb, $pr_property_types;
/*
	if ($id != 0) {
		$query = "
				select * from $pr_property_types
					where typeid = $id
					";
	} else
*/
	if ($instance=='READONLY') {
		$query = "select * from $pr_property_types where typeid = $id";
		$types = $wpdb->get_results($query);
		echo $types[0]->type_name;
	} else {
$query = "select * from $pr_property_types order by typeid ASC";
$types = $wpdb->get_results($query);
//$wpdb->show_errors();
//$wpdb->print_error();
	?>
    <select id="property_types" name="property_types" <?echo ($instance=='disabled' ? 'disabled' : '');?>>
	<?
	foreach($types as $type){
		if ($type->typeid != $instance) {
		?>
		<option value="<?echo $type->typeid;?>" <?if ($type->typeid==$id) {
			echo 'selected';
		}?>><?echo $type->type_name;?></option>
		<?
		}
	}
	?>
	</select>
	<?
	}
}

function pr_select_user_levels($id){
?>
	<select name="user_level">
		<option value="0" <?if($id==0) { echo 'selected';}?>>Subscriber</option>
		<option value="8" <?if($id==8) { echo 'selected';}?>>Admin</option>
	</select>
	<?
}

function pr_get_prop_area($prid,$type='normal'){
	global $wpdb,$pr_properties;
	$sql = 'select area from '.$pr_properties.' where ID='.$prid;
	$area_id = $wpdb->get_var($sql);
//	echo $area_id;
	switch($type){
		case 'normal':
			return $area_id;
			break;
		case 'root':
			$parent_area_id = pr_get_area_parents($area_id); // if NULL then this area_id is the root one
			return $parent_area_id == NULL ? $area_id : $parent_area_id;
			break;
		default:
			return false;
	} // switch
}

// theese two functions are almost identical but have different meaning
function pr_check_area_on_exclude($check_area_id){
	global $wpdb,$exclude_areas,$pr_areas;
	$_excl_arid = array();
	$_excl_area = $exclude_areas;// ????????? ???? ?? ?? ????????? ????????????
	//print_r($_excl_area);
	foreach ($_excl_area as $area)
	{
		$_excl_arid[] = $wpdb->get_var("SELECT ID FROM $pr_areas WHERE name = '$area'");// ???????? ?? ??? ??????????? ???
	}
	if (in_array($check_area_id, $_excl_arid)) {
		return true;
	} else return false;
}
function pr_check_area_on_noninternational($check_area_id){
	global $wpdb,$pr_non_international,$pr_areas;
	$_excl_arid = array();
	$_excl_area = $pr_non_international;// ????????? ???? ?? ?? ????????? ????????????
	//print_r($_excl_area);
	foreach ($_excl_area as $area)
	{
		$_excl_arid[] = $wpdb->get_var("SELECT ID FROM $pr_areas WHERE name = '$area'");// ???????? ?? ??? ??????????? ???
	}
	//print_r($_excl_arid);
	if (in_array($check_area_id, $_excl_arid)) {
		return true;
	} else return false;
}

/// finally we are using some WP hooks, very handful

function pr_add_property_hook($user_id,$prop_id,$basket_id,$band_id){
//if (!is_admin()) {
if (prb_get_basket_for_property($prop_id)==false)
	{
		if ($basket_id!=0) { // if basket is 0 then band is probably being bought
			prb_assign_basket_to_property($basket_id,$prop_id);
		} elseif ($band_id!=0){
			$_GET['pr_id_assign'] = $prop_id;
			prb_buy_a_band_question($band_id);
		} else pr_m_('You need to choose an existing band or buy a new one','','h2');
	}
//}
}
function pr_update_property_hook($user_id,$prop_id,$basket_id,$band_id){
//if (!is_admin()) {
		if ($basket_id!=0) { // if basket is not 0 then band is probably being bought
			prb_assign_basket_to_property($basket_id,$prop_id);
		} elseif ($band_id!=0){
			$_GET['pr_id_assign'] = $prop_id;
			prb_buy_a_band_question($band_id);
		} elseif (prb_get_basket_for_property($prop_id)==false) // check if property has active baskets
			{ pr_m_('You need to choose an existing band or buy a new one','','h2');}

//}
}

function pr_property_common_form_hook(){
	$_prop_to_edit = NULL; //property to edit
	if (isset($_GET['prf_edit_id'])) {// editing property on front end
		$_prop_to_edit = $_GET['prf_edit_id'];
	} elseif (isset($_GET['pr_id']) and is_admin()){ // editing property on back end
		$_prop_to_edit =$_GET['pr_id'];
	}

	if ($_prop_to_edit == NULL) {
	isset($_POST['band_area']) ? $_POST['band_area'] = $_POST['band_area'] : $_POST['band_area'] = 0;
	isset($_POST['property_types']) ? $_POST['property_types'] = $_POST['property_types'] : $_POST['property_types'] = 0;
	?>
	<input type="hidden" value="<?echo $_POST['property_types']?>" name="property_types">
	<input type="hidden" value="<?echo $_POST['band_area']?>" name="band_area">
	<?
	$current_basket = false;//current band for property is not assigned if we just going to add a property
	} else {
		// the propertly might have a basket assigned to it if we are edititng it, so let's check it
		$pr_edit_id = $_prop_to_edit;

		$current_basket = prb_get_basket_for_property($pr_edit_id);
	}
$_show_baskets_mode = 1; // always show baskets list, even if basket is already shosen
// was $current_basket == false
if ($_show_baskets_mode == 1) {

// initializing internal variables according to $_POST ones
if (isset($_POST['property_types'])) {
	$property_type = $_POST['property_types'];
} else {
	$property_type = pr_get_property_type($pr_edit_id);
	$property_type = $property_type->typeid;
}
if (isset($_POST['band_area'])) {
	$area = $_POST['band_area'];
} else {
	$area = pr_get_prop_area($pr_edit_id,'root');
	$area_id = $area['id'];
	if (pr_check_area_on_noninternational($area_id)==true) {
		$area = $area_id;
	} else $area = 0; // international
}
	?>
	<div class="pr_block">
		<h3 class="manage-column column-title"><span>Bands</span></h3>
		<div class="inside">
		<?
		if (!is_admin()) {
// admin page check start

		pr_m_('Bands to buy');?>
		<p>
		<?
		prbf_show_available_bands_for_property($property_type,$area);?>
		</p>
		<?
// admin page check end
		}

		pr_m_('My bands to assign property to');?>
		<p>
		<?
		global $user_ID;
		//echo $current_basket->basketid;
		prbf_show_user_bands_for_property($property_type,$area,$user_ID,$current_basket->basketid);?>
		</p>
		</div>
	</div>
	<?

} else{
	$basket = $current_basket;
	?>
	<div class="pr_block">
		<h3 class="manage-column column-title"><span>Bands</span></h3>
		<div class="inside">
		<?pr_m_('Assigned band Information');?>
		<p>
			<table class="widefat">
			<thead>
				<th class="manage-column column-title">Band</th>
				<th class="manage-column column-title">Time</th>
				<th class="manage-column column-title">Used slots</th>
				<th class="manage-column column-title">Status</th>
			</thead>
			<tbody>
				<tr>
					<td><?echo $basket->bandname?></td>
					<td><?echo $basket->startdate.' - '.$basket->enddate?></td>
					<td><?echo prb_get_basket_used_slots($basket->basketid)?>/<?echo $basket->prop_limit?></td>
					<td><?echo $basket->active==1 ? 'Active' : 'Inactive';?></td>
				</tr>
			</tbody>
			</table>
		</p>
		</div>
	</div>
	<?
}
}
function pr_letting_form_hook(){
	if (is_admin()) {
		$_POST['band_area'] = -1;
		$_POST['property_types'] = 1;
	}
	pr_property_common_form_hook();
}
function pr_sale_form_hook(){
	if (is_admin()) {
		$_POST['band_area'] = -1;
		$_POST['property_types'] = 2;
	}
	pr_property_common_form_hook();
}
function pr_update_tmp_property(){

// used for ajax creating previews
//print_r($_POST);
if (isset($_POST['pr_action'])) {
	if (isset($_POST['property_types']) and $_POST['property_types']==2)
	{
		pr_sale_update($_POST['pr_sale_price'],$_POST['pr_descr'],$_POST['pr_viewarrange'],$_POST['pr_refnumber'],$_POST['pr_area'],$_POST['pr_prop_types'],$_POST['pr_bedroomnum'],$_POST['pr_addr_building_name'],$_POST['pr_addr_door_number'],$_POST['pr_addr_street'],NULL,NULL,NULL,$_POST['pr_postcode'],$_POST['pr_extra_date_avail_from'],$_POST['pr_extra_date_displ_from'],$active,$featured,$_POST['pr_extra_furnishing'],$_POST['pr_extra_status']);
	} elseif(isset($_POST['property_types']) and $_POST['property_types']==1){
		pr_letting_update($_POST['pr_let_weekrent'],$_POST['pr_descr'],$_POST['pr_viewarrange'],$_POST['pr_refnumber'],$_POST['pr_area'],$_POST['pr_prop_types'],$_POST['pr_bedroomnum'],$_POST['pr_addr_building_name'],$_POST['pr_addr_door_number'],$_POST['pr_addr_street'],NULL,NULL,NULL,$_POST['pr_postcode'],$_POST['pr_extra_date_avail_from'],$_POST['pr_extra_date_displ_from'],$active,$featured,$_POST['pr_extra_furnishing'],$_POST['pr_extra_status']);
	}
	}
}
/*

function pr_get_prop_tmp_id_by_user_id(){

// depricated for now

	// this function gets $tmp_id for property preview
	// we store data there when user submits property data in order to restore it in case of errors
	// tmp_id is got by user_id
	// temporary entry is created by pr_preview_button function
	global $pr_tmp_properties,$user_ID;

}
*/
function pr_set_errors_adding_property(){
	$_err_ids = array();
	if ($_POST['pr_addr_street'] == NULL || $_POST['pr_addr_street'] == '' || $_POST['pr_addr_street'] == 'NULL') $_err_ids[] = 1;
	if ($_POST['pr_addr_door_number'] == NULL || $_POST['pr_addr_door_number'] == '' || $_POST['pr_addr_door_number'] == 'NULL') $_err_ids[] = 2;
	if ($_POST['pr_area'] == NULL || $_POST['pr_area'] == '' || $_POST['pr_area'] == 'NULL') $_err_ids[] = 3;
	if ($_POST['pr_prop_types'] == NULL || $_POST['pr_prop_types'] == '' || $_POST['pr_prop_types'] == 'NULL') $_err_ids[] = 4;
	return $_err_ids;
}
function pr_export_ftp_upload($file){
	global $pr_export_ftp_host,$pr_export_ftp_user,$pr_export_ftp_pwd,$pr_export_dir;
	//print_r($file);
	$ftp_server = $pr_export_ftp_host;
	$ftp_user = $pr_export_ftp_user;
	$ftp_pass = $pr_export_ftp_pwd;
	$remote_file = str_replace(dirname(__FILE__).$pr_export_dir,'',$file); // we replace all path until the name of the file
	$remote_file = $remote_file;

$conn_id = ftp_connect($ftp_server) or die("Can not connect to $ftp_server");

	// ﮯ��ꠠ⵮䠍
if (@ftp_login($conn_id, $ftp_user, $ftp_pass)) {
	//echo "Connected to $ftp_server as $ftp_user\n";
	if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
	echo "$remote_file was uploaded\n";
} else {
	echo "Couldn't load $remote_file to server\n";
}

} else {
	echo "Can not connect as $ftp_user\n";
}

	// close the connection
	ftp_close($conn_id);
}

function pr_pp_ipn($action){
	global $pr_paypal_ipn_log;
	//error_reporting(E_ALL ^ E_NOTICE);

	$email = get_bloginfo('admin_email');
	$header = "";
	$emailtext = "";
	$logtext = "--------------- [".date('Y-m-d H:i:s')."] ---------------"."\n";

	// Read the post from PayPal and add 'cmd'
	$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc'))
{
	$get_magic_quotes_exits = true;
}
foreach ($_POST as $key => $value)
	// Handle escape characters, which depends on setting of magic quotes
{
	if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1){
		$value = urlencode(stripslashes($value));
	} else {
		$value = urlencode($value);
	}
	$req .= "&$key=$value";
}
	// Post back to PayPal to validate
	$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
	$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);



	// Process validation from PayPal
	// TODO: This sample does not test the HTTP response code. All
	// HTTP response codes must be handles or you should use an HTTP
	// library, such as cUrl

if (!$fp) { // HTTP ERROR
} else {
	// NO HTTP ERROR
	fputs ($fp, $header . $req);

	if (file_exists($pr_paypal_ipn_log)) {
		$log = fopen($pr_paypal_ipn_log,'a');
	} else $log = fopen($pr_paypal_ipn_log,'w');

while (!feof($fp)) {
	$res = fgets ($fp, 1024);
	if (strcmp ($res, "VERIFIED") == 0) {
		$logtext .= "VERIFIED\n";
		// TODO:
		// Check the payment_status is Completed
		// Check that txn_id has not been previously processed
		// Check that receiver_email is your Primary PayPal email
		// Check that payment_amount/payment_currency are correct
		// Process payment
		// If 'VERIFIED', send an email of IPN variables and values to the
		// specified email address
		foreach ($_POST as $key => $value){
			$emailtext .= $key . " = " .$value ."\n\n";
			$logtext .= $key . " = " .$value ."\n";
		}
		//mail($email, "Live-VERIFIED IPN", $emailtext . "\n\n" . $req);
		fwrite($log, $logtext);
	} else if (strcmp ($res, "INVALID") == 0) {
		$logtext .= "INVALID\n";
		// If 'INVALID', send an email. TODO: Log for manual investigation.
		foreach ($_POST as $key => $value){
			$emailtext .= $key . " = " .$value ."\n\n";
			$logtext .= $key . " = " .$value ."\n";
		}
		//mail($email, "Live-INVALID IPN", $emailtext . "\n\n" . $req);
		fwrite($log, $logtext);
	}
	if ($_POST['txn_type']=='subscr_cancel') {
		prb_update_status_basket_by_refnum($_POST['item_number']);
	}
}
	fclose($log);
	fclose ($fp);
}
}
function pr_init_property_form(){
	$_prop_to_edit = NULL; //property to edit
	if (isset($_GET['prf_edit_id'])) {// editing property on front end
		$_prop_to_edit = $_GET['prf_edit_id'];
	} elseif (isset($_GET['pr_id']) and is_admin()){ // editing property on back end
		$_prop_to_edit =$_GET['pr_id'];
	}
if ($_prop_to_edit != NULL) {
	$pr_edit_id = $_prop_to_edit;
	// reinitializing $_POST variables for edititng prorty
if (!isset($_POST['property_types'])) {

	$property_type = pr_get_property_type($pr_edit_id);
	$_POST['property_types'] = $property_type->typeid;
}
if (!isset($_POST['band_area'])) {
	$area = pr_get_prop_area($pr_edit_id,'root');
	$area_id = $area['id'];
	if (pr_check_area_on_noninternational($area_id)==true) {
		$_POST['band_area'] = $area_id;
	} else $_POST['band_area'] = 0; // international
}
	}
}
?>