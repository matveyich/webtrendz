<?
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

  add_menu_page(__('Paypal', 'paypal'), __('Paypal', 'paypal'), 'manage_pr',  'paypal', 'pr_pp_edit',  plugins_url('properties/images/paypal.png'));
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
global $pr_slug;
if(is_page('lettings'))
	{
		wp_redirect( get_permalink(get_page_by_path($pr_slug)).'?pr_type=1&pr_bedroomnum=0&minimumprice=0&maximumprice=&pr_area=0&submit=SEARCH&exclude=222' );
	}
	elseif(is_page('sales'))
	{
		wp_redirect( get_permalink(get_page_by_path($pr_slug)).'?pr_type=2&pr_bedroomnum=0&minimumprice=0&maximumprice=&pr_area=0&submit=SEARCH&exclude=222' );
	}
	elseif (is_page('international'))
	{
		wp_redirect(get_permalink(get_page_by_path($pr_slug)).'?pr_type=all&pr_bedroomnum=0&minimumprice=0&maximumprice=&pr_area=0&submit=SEARCH&exclude=222');
	}
}
function pr_init_()
{
// проверка наличия переменной сортировки по ценам
if (isset($_POST['sort_by_price']))
	{
	$_SESSION['sort_by_price'] = $_POST['sort_by_price'];
	}
elseif(!isset($_SESSION['sort_by_price'])) {
	$_SESSION['sort_by_price'] = 'ASC';
	}
// обраобтка POST фильтра
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
{global $pr_slug,$pr_newsletter_slug,$pr_user_properties_slug,$pr_user_downloads_slug,$pr_tennant_slug;
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
	return $content;
}
function pr_add_site_head()
{
	?>
	<!-- properties module wtz styles-->
	<link rel='stylesheet' href='<?bloginfo('url')?>/wp-content/plugins/properties/style.css' type='text/css' media='all' />
	<link rel='stylesheet' href='<?bloginfo('url')?>/wp-content/plugins/properties/datepicker1.css' type='text/css' media='all' />
	<link rel="Stylesheet" href="<?bloginfo('url')?>/wp-content/plugins/properties/jquery-ui-1.7.2.custom.css" type="text/css" />

	<!-- properties module wtz styles-->
<script src="<?bloginfo('template_url'); ?>/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src='<?bloginfo('url')?>/wp-content/plugins/properties/jquery.ui.js'></script>

<script language="JavaScript" type="text/javascript" src="<?bloginfo('url')?>/wp-content/plugins/properties/somescripting.js"></script>



	<?
}
function pr_add_admin_head()
{

	?>
	<!-- properties module wtz styles-->
	<link rel='stylesheet' href='<?bloginfo('url')?>/wp-content/plugins/properties/style_admin.css' type='text/css' media='all' />
	<link rel='stylesheet' href='<?bloginfo('url')?>/wp-content/plugins/properties/datepicker1.css' type='text/css' media='all' />
	<link rel="Stylesheet" href="<?bloginfo('url')?>/wp-content/plugins/properties/jquery-ui-1.7.2.custom.css" type="text/css" />
	<!-- properties module wtz styles-->
	<?/*?><script type="text/javascript" src="<?bloginfo('url')?>/wp-content/plugins/properties/nicEditor/nicEdit.js"></script><?*/?>
<script src="<?bloginfo('template_url'); ?>/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src='<?bloginfo('url')?>/wp-content/plugins/properties/jquery.ui.js'></script>

<script language="JavaScript" type="text/javascript" src="<?bloginfo('url')?>/wp-content/plugins/properties/somescripting.js"></script>


	<?//pr_create_thumbs_for_old();
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
	<form name="<?echo $field_name;?>" action="<?echo $_action;?>" method="post" enctype="multipart/form-data">
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
	<input type="submit" name="submit" value="<?echo $field_name;?>" class="button-primary">
		<?} else {?>
	<input type="submit" name="submit" value="<?echo $field_name;?>" class="submit">
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
			else {$results = $wpdb->get_results('SELECT a.ID, a.name, a.parent_id FROM '.$pr_areas.' a WHERE a.active = 1 ORDER BY a.parent_id ASC, a.name ASC, a.ID ASC');}
			echo '<select name="'.$field_name.'">';
			echo '<option value="0">All</option>';
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
			?>
			<select name="<?echo $field_name?>">
			<option value="1" <?if($id==1) echo "selected"?>>Let</option>
			<option value="2" <?if($id==2) echo "selected"?>>Available</option>
			<option value="3" <?if($id==3) echo "selected"?>>New instruction</option>
			</select>
			<?
		break;
		case "sale_status":
			?>
			<select name="<?echo $field_name?>">
			<option value="4" <?if($id==4) echo "selected"?>>Sold</option>
			<option value="5" <?if($id==5) echo "selected"?>>Under offer</option>
			<option value="2" <?if($id==2) echo "selected"?>>Available</option>
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
			<input class="short_input" type="text" name="<?echo $field_name?>[]" value="<?if($field_value!=NULL) echo $in1;?>" MAXLENGTH="2"> / <input class="short_input" type="text" name="<?echo $field_name?>[]" value="<?if($field_value!=NULL) echo $in2;?>" MAXLENGTH="2"> / <input class="short_input" type="text" name="<?echo $field_name?>[]" value="<?if($field_value!=NULL) echo $in3;?>" MAXLENGTH="2">
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
	//$start = 0;//для случаев когда дети выше родителей, такое бывает))
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
	$start = 0;//для случаев когда дети выше родителей, такое бывает))
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
	//$start = 0;//для случаев когда дети выше родителей, такое бывает))
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
pr_edit_subform("name",$_GET['area_id'],$pr_areas,$pr_prefix.'area_name',NULL);	// это поле лучше заменить на текстовое со вставкой нужного значения.
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
	<a href="javascript:sureness('admin.php?page=<?echo $_GET['page']?>&action=area_delete&area_id=<?echo $area->ID;?>')">Delete</a> |
		<?
		if ($edit_this==true)
		{
pr_edit_subform("submit");
pr_edit_subform("hidden",NULL,NULL,'action',$_GET['action']);
pr_edit_subform("hidden",NULL,NULL,'area_id',$_GET['area_id']);
		} else {?>
<a href="admin.php?page=<?echo $_GET['page']?>&action=area_edit&area_id=<?echo $area->ID;?>#<?echo $area->ID;?>">Edit</a>
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
	return $results[0];
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

	if($displfrom==''||$displfrom=='0000-00-00')
      {
		//$displfrom = date('Y-m-d');
		$displfrom = NULL;
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
	if($_POST['pr_extra_date_displ_to']==''||$_POST['pr_extra_date_displ_to']=='0000-00-00')
      {
		if ($displfrom!=NULL)
			{
			list($year,$month,$day) = explode('-',$displfrom);
			$year++;
			$_displ_to = $year.'-'.$month.'-'.$day;
			}
		else $_displ_to = NULL;

      } else $_displ_to = $_POST['pr_extra_date_displ_to'];
		$wpdb->query($wpdb->prepare("UPDATE $pr_properties SET paid = $_paid, approved = $_approved, extra_date_displ_to = '$_displ_to' WHERE ID = %d",$last_id));
	}
	// picture upload
	pr_transfer_tmp_pics($user_ID,$last_id); // pics transfer using swfuplader

	if($_FILES[$pr_prefix.'pic_upload'] != NULL)
	{
		$filename = pr_upload($last_id,'pic_upload');
		// добавляем запись в таблицу картинок
		if($filename != false)
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
		// добавляем запись в таблицу files
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
		$wpdb->query($wpdb->prepare("INSERT INTO ".$pr_video_table." (ID,prid,yt_id) values (NULL,".$last_id.",'%s')",$_POST[$pr_prefix.'yt_id']));
			//$wpdb->show_errors();
			//$wpdb->print_error();
	}
}
/**/
function pr_letting_update($rent,$descr,$viewing,$refnum,$area,$type,$bedrooms,$bname,$dnumber,$street,$city,$county,$country,$pcode,$avalfrom,$displfrom,$active,$featured,$furnishing,$status)
{global $wpdb,$pr_properties,$pr_pic_table,$pr_files_table,$pr_video_table,$pr_prefix,$user_ID;
	// не имеет собого смысла если не переписать запись в БД, что головняк, т.к. придется делать через одно место.
	// выведем просто в форму пустую строку если в дате храниться, что-то типа 0000-00-00
	// это же учтем для выбора аренды в посике и рассылках

	if($displfrom==''||$displfrom=='0000-00-00')
      {
		//$displfrom = date('Y-m-d');
		$displfrom = NULL;
	  }

	if (isset($_POST['pr_user_id'])) $update_user_id = $_POST['pr_user_id']; else {$update_user_id = $user_ID;}
	$wpdb->query($wpdb->prepare("UPDATE ".$pr_properties." SET let_weekrent = %d,let_monthrent = %d,descr='%s',viewarrange='%s',refnumber='%s',area=%d,type=%d,bedroomnum=%d,addr_building_name='%s',addr_door_number='%s',addr_street='%s',addr_city=%d,addr_county=%d,addr_country=%d,addr_postcode='%s',extra_date_avail_from='%s',extra_date_displ_from='%s',extra_active=%d,extra_featured=%d,extra_furnishing=%d,extra_status=%d,property_type=%d, user_id=%d, date_updated = '".date('Y-m-d H:i:s')."',bathroomnum=%d,receptionroomnum=%d WHERE ID = %d",$rent,$_POST['pr_let_monthrent'],stripslashes($descr),stripslashes($viewing),stripslashes($refnum),$area,$type,$bedrooms,stripslashes($bname),stripslashes($dnumber),stripslashes($street),$city,$county,$country,stripslashes($pcode),$avalfrom,$displfrom,$active,$featured,stripslashes($furnishing),$status,1,$update_user_id,$_POST['pr_bathroomnum'],$_POST['pr_receptionroomnum'],$_POST['pr_id']));

	// extra check for paid field. it should be accessed only from admin page
	if (is_admin())
	{
		if(isset($_POST['pr_paid'])) $_paid = 1; else $_paid = 0;
		if(isset($_POST['pr_approved'])) $_approved = 1; else $_approved = 0;
	if($_POST['pr_extra_date_displ_to']==''||$_POST['pr_extra_date_displ_to']=='0000-00-00')
      {
		if ($displfrom!=NULL)
		{
			list($year,$month,$day) = explode('-',$displfrom);
			$year++;
			$_displ_to = $year.'-'.$month.'-'.$day;
		}
		else $_displ_to = NULL;
      } else $_displ_to = $_POST['pr_extra_date_displ_to'];
    $wpdb->query($wpdb->prepare("UPDATE $pr_properties SET paid = $_paid, approved = $_approved, extra_date_displ_to = '$_displ_to' WHERE ID = %d",$_POST['pr_id']));

	}
	//$wpdb->show_errors();
	//$wpdb->print_error();
	//print_r($_FILES);
	$last_id = $_POST['pr_id'];
	// picture upload
	pr_transfer_tmp_pics($user_ID,$last_id); // pics transfer using swfuplader

	if($_FILES[$pr_prefix.'pic_upload'] != NULL)
	{
		$filename = pr_upload($last_id,'pic_upload');
		// добавляем запись в таблицу картинок
		if($filename != false)
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
		// добавляем запись в таблицу files
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
	// entry to video table
	/**/
	if($_POST[$pr_prefix.'yt_id'] != NULL)
	{
		$check = $wpdb->get_var($wpdb->prepare("SELECT COUNT(prid) FROM ".$pr_video_table." WHERE prid = %d",$_POST['pr_id']));
		if ($check != 0)
		{
		$wpdb->query($wpdb->prepare("UPDATE ".$pr_video_table." SET yt_id='%s' WHERE prid = %d",$_POST[$pr_prefix.'yt_id'],$_POST['pr_id']));
		} else
			{
			$wpdb->query($wpdb->prepare("INSERT INTO ".$pr_video_table." (ID,prid,yt_id) values (NULL,".$last_id.",'%s')",$_POST[$pr_prefix.'yt_id']));
			}
			//$wpdb->show_errors();
			//$wpdb->print_error();
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
?>
	<script src="<?bloginfo('template_url'); ?>/js/jquery.js" type="text/javascript"></script>
	<script type="text/javascript" src='<?bloginfo('url')?>/wp-content/plugins/properties/jquery.ui.js'></script>
<script type="text/javascript">
$(document).ready(function() {
    $('input#Let_DisplayFrom').datepicker({ dateFormat: 'yy-mm-dd' });
    $('input#Let_DisplayTo').datepicker({ dateFormat: 'yy-mm-dd' });
    $('input#Let_AvailableFrom').datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>
<?//pr_m_($title);?>
	<?
// initializing swfupload fields
$_swfu_fields = array();
$_swfu_fields[] = array('pics','pic');
$_swfu_fields[] = array('files','file');
pr_swfupload_init($_swfu_fields);
	pr_edit_subform("form_start");
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
			<??>
			</div>
<script type="text/javascript">
$("#pr_descr").width('100%');
</script>
			</p>
			<p>View arrangements</p><p><textarea name="pr_viewarrange"><?if($prid!=NULL) echo $property[0]->viewarrange;?></textarea></p>
			<p>Refference number</p><p><input type="text" name="pr_refnumber" value="<?if($prid!=NULL) echo $property[0]->refnumber;?>"></p>
			<p>Area</p><p><?pr_edit_subform("areas",$area,NULL,'pr_area',NULL);?></p>
			<p>Type</p><p><?pr_edit_subform("prop_types",$type);?></p>
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
			<p>Building name</p><p><input type="text" name="pr_addr_building_name" value="<?if($prid!=NULL) echo $property[0]->addr_building_name;?>"></p>
			<p>Door number<span class="required">*</span></p><p><input type="text" name="pr_addr_door_number" value="<?if($prid!=NULL) echo $property[0]->addr_door_number;?>"></p>
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
			<input type="text" value="<?if($prid!=NULL and $property[0]->extra_date_avail_from != '0000-00-00') echo $property[0]->extra_date_avail_from;?>" name="pr_extra_date_avail_from" id="Let_AvailableFrom"></p>
			<p>Display from</p><p>
			<input type="text" value="<?if($prid!=NULL and $property[0]->extra_date_displ_from != '0000-00-00') echo $property[0]->extra_date_displ_from;?>" name="pr_extra_date_displ_from" id="Let_DisplayFrom"></p>
			<p>Display to</p><p>
			<input type="text" value="<?if($prid!=NULL and $property[0]->extra_date_displ_to != '0000-00-00') echo $property[0]->extra_date_displ_to;?>" name="pr_extra_date_displ_to" id="Let_DisplayTo"></p>
			<?
      if ($prid!=NULL)
      {
          pr_m_('Created: '.$property[0]->date_created);
        if ($property[0]->date_updated!=NULL)
        {
          pr_m_('Last updated: '.$property[0]->date_updated);
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
				// нужны дополнительные проверки на длину имени файла и его расширение, исключить обязательно .php
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
function pr_prop_delete($id)
{
	global $pr_properties,$wpdb,$pr_pic_table,$pr_video_table,$pr_files_table;

	// добавить удаление записей из медиа таблиц + сами файлы надо удалить
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
	// now we finally delete property entry
	$wpdb->query($wpdb->prepare('DELETE FROM '.$pr_properties.' WHERE ID=%d',$id));
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

	if($displfrom==''||$displfrom=='0000-00-00')
      {
		$displfrom = date('Y-m-d');
	  }

if (isset($_POST['pr_band'])) $_pr_band = $_POST['pr_band'];
	else $_pr_band = NULL;
	if (isset($_POST['pr_user_id'])) $insert_user_id = $_POST['pr_user_id']; else {$insert_user_id = $user_ID;}
	$wpdb->query($wpdb->prepare("INSERT INTO ".$pr_properties." (ID,sale_price,descr,viewarrange,refnumber,area,type,bedroomnum,addr_building_name,addr_door_number,addr_street,addr_city,addr_county,addr_country,addr_postcode,extra_date_avail_from,extra_date_displ_from,extra_active,extra_featured,extra_furnishing,extra_status,property_type,user_id,band_id,date_created,date_updated,bathroomnum,receptionroomnum) values (NULL,%d,'%s','%s','%s',%d,%d,%d,'%s','%s','%s',%d,%d,%d,'%s','%s','%s',%d,%d,%d,%d,%d,%d,%d,'".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."',%d,%d)",$price,stripslashes($descr),stripslashes($viewing),stripslashes($refnum),$area,$type,$bedrooms,stripslashes($bname),stripslashes($dnumber),stripslashes($street),$city,$county,$country,stripslashes($pcode),$avalfrom,$displfrom,$active,$featured,stripslashes($furnishing),$status,2,$insert_user_id,$_pr_band,$_POST['pr_bathroomnum'],$_POST['pr_receptionroomnum']));
	//$wpdb->show_errors();
	//$wpdb->print_error();
	$last_id = $wpdb->get_var("SELECT LAST_INSERT_ID();");
  if (is_admin())
	{
		if(isset($_POST['pr_paid'])) $_paid = 1; else $_paid = 0;
		if(isset($_POST['pr_approved'])) $_approved = 1; else $_approved = 0;
	if($_POST['pr_extra_date_displ_to']==''||$_POST['pr_extra_date_displ_to']=='0000-00-00')
      {
      if ($displfrom!=NULL)
			{
			list($year,$month,$day) = explode('-',$displfrom);
			$year++;
			$_displ_to = $year.'-'.$month.'-'.$day;
			}
		else $_displ_to = NULL;
      } else $_displ_to = $_POST['pr_extra_date_displ_to'];
		$wpdb->query($wpdb->prepare("UPDATE $pr_properties SET paid = $_paid, approved = $_approved, extra_date_displ_to = '$_displ_to' WHERE ID = %d",$last_id));

	}
  // picture upload
	pr_transfer_tmp_pics($user_ID,$last_id); // pics transfer using swfuplader

	if($_FILES[$pr_prefix.'pic_upload'] != NULL)
	{
		$filename = pr_upload($last_id,'pic_upload');
		// добавляем запись в таблицу картинок
		if($filename != false)
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
		// добавляем запись в таблицу files
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
		$wpdb->query($wpdb->prepare("INSERT INTO ".$pr_video_table." (ID,prid,yt_id) values (NULL,".$last_id.",'%s')",$_POST[$pr_prefix.'yt_id']));
			//$wpdb->show_errors();
			//$wpdb->print_error();
	}
}
function pr_sale_update($price,$descr,$viewing,$refnum,$area,$type,$bedrooms,$bname,$dnumber,$street,$city,$county,$country,$pcode,$avalfrom,$displfrom,$active,$featured,$furnishing,$status)
{global $wpdb,$pr_properties,$pr_pic_table,$pr_files_table,$pr_video_table,$pr_prefix,$user_ID;
	if (isset($_POST['pr_user_id'])) $update_user_id = $_POST['pr_user_id']; else {$update_user_id = $user_ID;}
if (isset($_POST['pr_band'])) $_pr_band = $_POST['pr_band'];
	else $_pr_band = NULL;

	if($displfrom==''||$displfrom=='0000-00-00')
      {
		$displfrom = date('Y-m-d');
	  }

	$wpdb->query($wpdb->prepare("UPDATE ".$pr_properties." SET sale_price = %d,descr='%s',viewarrange='%s',refnumber='%s',area=%d,type=%d,bedroomnum=%d,addr_building_name='%s',addr_door_number='%s',addr_street='%s',addr_city=%d,addr_county=%d,addr_country=%d,addr_postcode='%s',extra_date_avail_from='%s',extra_date_displ_from='%s',extra_active=%d,extra_featured=%d,extra_furnishing=%d,extra_status=%d,property_type=%d,band_id=%d,user_id=%d,date_updated = '".date('Y-m-d H:i:s')."',bathroomnum=%d,receptionroomnum=%d WHERE ID = %d",$price,stripslashes($descr),stripslashes($viewing),stripslashes($refnum),$area,$type,$bedrooms,stripslashes($bname),stripslashes($dnumber),stripslashes($street),$city,$county,$country,stripslashes($pcode),$avalfrom,$displfrom,$active,$featured,stripslashes($furnishing),$status,2,$_pr_band,$update_user_id,$_POST['pr_bathroomnum'],$_POST['pr_receptionroomnum'],$_POST['pr_id']));
	// extra check for paid field. it should be accessed only from admin page
	if (is_admin())
	{
		if(isset($_POST['pr_paid'])) $_paid = 1; else $_paid = 0;
		if(isset($_POST['pr_approved'])) $_approved = 1; else $_approved = 0;
	if($_POST['pr_extra_date_displ_to']==''||$_POST['pr_extra_date_displ_to']=='0000-00-00')
      {
		if ($displfrom!=NULL)
			{
			list($year,$month,$day) = explode('-',$displfrom);
			$year++;
			$_displ_to = $year.'-'.$month.'-'.$day;
			}
		else $_displ_to = NULL;
      } else $_displ_to = $_POST['pr_extra_date_displ_to'];
    $wpdb->query($wpdb->prepare("UPDATE $pr_properties SET paid = $_paid, approved = $_approved, extra_date_displ_to = '$_displ_to' WHERE ID = %d",$_POST['pr_id']));
	}
	//$wpdb->show_errors();
	//$wpdb->print_error();
	//print_r($_FILES);
	$last_id = $_POST['pr_id'];
	// picture upload
	pr_transfer_tmp_pics($user_ID,$last_id); // pics transfer using swfuplader

	if($_FILES[$pr_prefix.'pic_upload'] != NULL)
	{
		$filename = pr_upload($last_id,'pic_upload');
		// добавляем запись в таблицу картинок
		if($filename != false)
			{
			$wpdb->query("INSERT INTO ".$pr_pic_table." (ID,prid,img_name) values (NULL,".$last_id.",'".$filename."');");
			}
	}
	// file upload
	if($_FILES[$pr_prefix.'file_upload'] != NULL)
	{
		$filename = pr_upload($last_id,'file_upload');
		// добавляем запись в таблицу files
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
	// entry to video table
	/**/
	if($_POST[$pr_prefix.'yt_id'] != NULL)
	{
		$check = $wpdb->get_var($wpdb->prepare("SELECT COUNT(prid) FROM ".$pr_video_table." WHERE prid = %d",$_POST['pr_id']));
		if ($check != 0)
		{
		$wpdb->query($wpdb->prepare("UPDATE ".$pr_video_table." SET yt_id='%s' WHERE prid = %d",$_POST[$pr_prefix.'yt_id'],$_POST['pr_id']));
		} else
			{
				$wpdb->query($wpdb->prepare("INSERT INTO ".$pr_video_table." (ID,prid,yt_id) values (NULL,".$last_id.",'%s')",$_POST[$pr_prefix.'yt_id']));
			}
			//$wpdb->show_errors();
			//$wpdb->print_error();
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
function pr_sales_form($prid = NULL, $action = "add")
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
			$title = "Add sale property";
		break;
		case "edit":
			$title = "Edit sale property";
		break;
	}
?>
	<script src="<?bloginfo('template_url'); ?>/js/jquery.js" type="text/javascript"></script>
	<script type="text/javascript" src='<?bloginfo('url')?>/wp-content/plugins/properties/jquery.ui.js'></script>
<script type="text/javascript">
$(document).ready(function() {
    $('input#Let_DisplayFrom').datepicker({ dateFormat: 'yy-mm-dd' });
    $('input#Let_DisplayTo').datepicker({ dateFormat: 'yy-mm-dd' });
    $('input#Let_AvailableFrom').datepicker({ dateFormat: 'yy-mm-dd'  });
});
</script>
<p><?//pr_m_($title);?></p>
	<?
// initializing swfupload fields
$_swfu_fields = array();
$_swfu_fields[] = array('pics','pic');
$_swfu_fields[] = array('files','file');
pr_swfupload_init($_swfu_fields);
	pr_edit_subform("form_start");
	?>
	<div class="pr_block">
	<div class="metabox-holder">
		<div class="postbox widefat">
		<h3 class="manage-column column-title"><span>Sale information</span></h3>
		<div class="inside">
			<p>Property owner</p>
			<p><?pr_edit_subform("user_list",NULL,NULL,"pr_user_id",$update_user_id);?></p>
			<p>Price</p><p><input type="text" name="pr_sale_price" value="<?if($prid!=NULL) echo pr_price($property[0]->sale_price);?>"></p>
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
			<??>
			</div>
<script type="text/javascript">
$("#pr_descr").width('100%');
</script>
			</p>
			<p>View arrangements</p><p><textarea name="pr_viewarrange"><?if($prid!=NULL) echo $property[0]->viewarrange;?></textarea></p>
			<p>Refference number</p><p><input type="text" name="pr_refnumber" value="<?if($prid!=NULL) echo $property[0]->refnumber;?>"></p>
			<p>Area</p><p><?pr_edit_subform("areas",$area,NULL,'pr_area',NULL);?></p>
			<p>Type</p><p><?pr_edit_subform("prop_types",$type);?></p>
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
			<p>Building name</p><p><input type="text" name="pr_addr_building_name" value="<?if($prid!=NULL) echo $property[0]->addr_building_name;?>"></p>
			<p>Door number<span class="required">*</span></p><p><input type="text" name="pr_addr_door_number" value="<?if($prid!=NULL) echo $property[0]->addr_door_number;?>"></p>
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
			<input type="text" value="<?if($prid!=NULL and $property[0]->extra_date_avail_from != '0000-00-00') echo $property[0]->extra_date_avail_from;?>" name="pr_extra_date_avail_from" id="Let_AvailableFrom"></p>
			<p>Display from</p><p>
			<input type="text" value="<?if($prid!=NULL and $property[0]->extra_date_displ_from != '0000-00-00') echo $property[0]->extra_date_displ_from;?>" name="pr_extra_date_displ_from" id="Let_DisplayFrom"></p>
      <p>Display to</p><p>
			<input type="text" value="<?if($prid!=NULL and $property[0]->extra_date_displ_to != '0000-00-00') echo $property[0]->extra_date_displ_to;?>" name="pr_extra_date_displ_to" id="Let_DisplayTo"></p>
			<?
      if ($prid!=NULL)
      {
          pr_m_('Created: '.$property[0]->date_created);
        if ($property[0]->date_updated!=NULL)
        {
          pr_m_('Last updated: '.$property[0]->date_updated);
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
		<?echo $prop->door_number.', '.$prop->street.', '.$prop->postcode.', '.pr_area_path($prop->area_id);?>
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

$_unpaid = $wpdb->get_var("SELECT COUNT(ID) FROM $pr_properties WHERE paid = 0 AND property_type = 2;"); // есть ли вообще неоплаченные недвижимости
	if ($_unpaid>0)
	{
		// есть неоплаченные
		$_excl_area = $exclude_areas;// исключаем зону УК из возможных неоплаченных
		foreach ($_excl_area as $area)
		{
			$_excl_arid[] = $wpdb->get_var("SELECT ID FROM $pr_areas WHERE name = '$area'");// получаем ИД для исключаемых зон
		}

		$_unpaid = $wpdb->get_results("SELECT ID,area FROM $pr_properties WHERE paid = 0 AND property_type = 2;"); // получаем все ИД зон для неоплаченных
		$_un_prop_ids = array();
		foreach($_unpaid as $prop)
		{
			if(!in_array($prop->area,$_excl_arid) and pr_check_parent($prop->area,$_excl_arid)==false)
				{
					$_un_prop_ids[] = $prop->ID;// массив ИД недвижимостей для влючаемых в результаты неоплаченных
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
			$results = $wpdb->get_results("SELECT pr.ID, IF (pr.property_type=2,pr.sale_price,pr.let_weekrent) as price, pr.addr_door_number as door_number, pr.addr_street as street, pr.addr_postcode as postcode, a.name as area,pr.area as area_id,pr.property_type as type,pr.user_id FROM $pr_properties pr LEFT JOIN $pr_areas a ON pr.area = a.ID WHERE pr.paid = 0 AND property_type = 2 AND pr.ID IN ($_include) ORDER BY price ".$_SESSION['sort_by_price'].", pr.ID ASC LIMIT $start,$pr_per_page;");


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
		<?echo $prop->door_number.', '.$prop->street.', '.$prop->postcode.', '.pr_area_path($prop->area_id);?>
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
		$pp_opts = array($pr_seller_mail,$pr_data_send_url_testing,$pr_data_send_url_live,$pr_token,$pr_mode);
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
	global $pr_paypal_opt,$pr_seller_mail,$pr_data_send_url,$pr_token;
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
		$pp_opts = array($_POST['pr_seller_mail'], $_POST['pr_data_send_url_testing'], $_POST['pr_data_send_url_live'],$_POST['pr_token'],$_POST['pr_pp_url']);
		update_option($pr_paypal_opt,$pp_opts);
	}
	if(get_option($pr_paypal_opt)) {
		$pp_opts = get_option($pr_paypal_opt);
		$pr_seller_mail = $pp_opts[0];
		$pr_data_send_url_testing = $pp_opts[1];
		$pr_data_send_url_live = $pp_opts[2];
		$pr_token = $pp_opts[3];
		$pr_mode = $pp_opts[4];
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
	?><p><?
		pr_edit_subform("submit","Submit");
	?></p><?
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
	} else pr_m_('You are not allowed to delete this property.','error','h3');

	} else pr_m_('You are not logged in.','error','h3');
}


function pr_export()
{
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
if (isset($_POST['submit']))
{
	if ($_POST['pr_xml_name'] != '')
	{
	pr_export_file_create();
	} else pr_m_('You need to specify XML file name','error','h3');
}

pr_export_DG_settings_form();
pr_export_files_list();
//echo "under construction";

}
function pr_export_file_create_get_properties($types = 'all',$from_date = NULL) // получаем айдишники всех актуальных для данного диапазона врмени недвижимостей.
{
	global $wpdb,$pr_properties;
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
		$_and_from_date = "AND date_created > '$from_date'";
	} else $_and_from_date = '';
	$sql = "SELECT ID FROM $pr_properties WHERE ID IS NOT NULL $_and_types $_and_from_date";
	$results = $wpdb->get_results($sql);
	//print_r($results);
	//$wpdb->show_errors();
	//$wpdb->print_error();
	$res = array(); // resulting array of property IDs
	foreach($results as $result)
	{
		$res[] = $result->ID;
	}
	return $res;
}
function pr_export_file_write_property($file,$prop)
{
	global $wpdb,$selling_state,$furnishing,$pr_prop_types;

	$_additionalKeywords = array();

	// getting areas route
	$area = pr_get_area_info($prop->area);
	$area_parents = pr_get_area_parents($prop->area,'all');// get parents route for area

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
}	else $root_area_info = pr_get_area_info($prop->ID);// root area info

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
	// property type
	$_property_root_type = pr_get_property_type_parents($prop->type,'root'); // get root type parents

	if ($_property_root_type != NULL) // if type of property has parents
		{
		$_property_root_type_code = pr_get_property_type_code($_property_root_type->ID);// if this prop type has parents we get its parent code

			$_property_sub_type_code = pr_get_property_type_code($prop->type);// get subtype code
			if ($_property_sub_type_code == NULL) // no code found
			{
				$_additionalKeywords[] = $wpdb->get_var("SELECT Name from $pr_prop_types WHERE ID = $prop->type"); // add current type name to additionalKeys field
			}

		}
		else { // if type of property doesn't have parents
			$_property_root_type_code = pr_get_property_type_code($prop->type);// root type is current type, and we get its code
			if ($_property_root_type_code == NULL) // if root type doesn't its code
				{
					$_additionalKeywords[] = $wpdb->get_var("SELECT Name FROM $pr_prop_types WHERE ID = $prop->type");// add current type name to additionalKeys field
				}
			}


	// images
	$_main_image = pr_get_property_images($prop->ID,'main');
	$_additional_images = pr_get_property_images($prop->ID,'without_main');

	$_hipdoc = pr_get_property_files($prop->ID,'one');

	$_additionalKeywords = implode(',',$_additionalKeywords);
	$string	= '<property propertyID="'.$prop->ID.'">
                <fullPostCode>'.$prop->addr_postcode.'</fullPostCode>
                <countryCode>'.$root_area_info->code.'</countryCode>
                <name>'.$_addr_building_name.'</name>
                <address>'.$prop->addr_street.', '.$areas_route.', '.$prop->addr_postcode.'</address>
                <regionCode></regionCode>
                <summary></summary>
                <details><![CDATA['.$prop->descr.']]></details>
				<pricePrefix>'.$_price_prefix.'</pricePrefix>
                <price>'.$_price.'</price>
                <priceCurrency>GBP</priceCurrency>
                <sellingState>'.$selling_state[$prop->extra_status]['code'].'</sellingState>';
if ($_property_root_type_code != NULL)
	$string	.= '<propertyType>'.$_property_root_type_code.'</propertyType>';

if ($_property_sub_type_code != NULL)
	$string	.=  '<propertySubType>'.$_property_sub_type_code.'</propertySubType>';

	$string	.=  '<newHome></newHome>
                <saleOrRent>'.$_sale_or_rent.'</saleOrRent>
                <groundRent></groundRent>
                <serviceCharge></serviceCharge>
                <furnished>'.$furnishing[$prop->extra_furnishing].'</furnished>
                <tenure></tenure>
                <bedrooms>'.$prop->bedroomnum.'</bedrooms>
                <bathrooms>'.$prop->bathroomnum.'</bathrooms>
                <receptionRooms>'.$prop->receptionroomnum.'</receptionRooms>

				<mainImage>'.$_main_image->img_name.'</mainImage>
				';
// showing additional images, max 8
	if ($_additional_images != NULL )
		{
		if (sizeof($_additional_images) < 8) $stop = sizeof($_additional_images);
			else $stop = 8;
			for ($i = 0;$i<$stop;$i++)
				$string	.=  '<additionalImage'.($i+1).'>'.$_additional_images[$i].'</additionalImage'.($i+1).'>
				';
        }
// HIP document
if ($_hipdoc != NULL)
	$string	.=  '<propertySubType>'.$_hipdoc.'</propertySubType>';

    $string	.=  '<createdDate>'.str_replace(' ','T',$prop->date_created).'</createdDate>
                <modifiedDate>'.str_replace(' ','T',$prop->date_updated).'</modifiedDate>

                <additionalKeywords>'.$_additionalKeywords.'</additionalKeywords>
            </property>';

	fwrite($file,stripslashes($string));
}
function pr_export_file_write_sale($file,$prop)
{
	//$string
}
function pr_export_file_create()
{
	global $wpdb,$pr_properties,$pr_export_dir;
	$_POST['pr_xml_name'] = str_replace(' ','_',trim($_POST['pr_xml_name']));
	$file = fopen(dirname(__FILE__).$pr_export_dir.$_POST['pr_xml_name'].'_'.date('Y-m-d_H:i:s').'.xml','w');
	$export_head = '<?xml version="1.0" encoding="UTF-8"?>
<root xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:noNamespaceSchemaLocation="http://www.fastcropit.com/schemas/FastcropX1.xsd">
    <agentGroup code="'.$_POST['pr_xml_agent_group'].'">
        <mode>'.$_POST['pr_xml_mode'].'</mode>
        <exportDate>'.date('Y-m-d').'T'.date('H:i:s').'</exportDate> <!-- xsd:dateTime format yyyy-mm-ddThh:mm:ss /-->
        <agentBranch code="'.$_POST['pr_xml_agent_branch'].'">
		';
$export_bottom = '</agentBranch>
    </agentGroup>
</root>
';
	fwrite($file,stripslashes($export_head));

	$ids = pr_export_file_create_get_properties($_POST['xml_Export_prop_type'],$_POST['xml_Export_from']);
	//print_r($ids);
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

function pr_export_DG_settings_form()
{
?>
<script type="text/javascript">
$(document).ready(function() {
    $('input#xml_Export_from').datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>
<?
pr_edit_subform("form_start",NULL,NULL,'admin.php?page='.$_GET['page']);
echo "<p><label for=\"xml_name\">Exporting file name:</label><br>";
pr_edit_subform("text_input","xml_name",NULL,"pr_xml_name");
echo "</p>";
echo "<p><label for=\"xml_agent_group\">Agent group code:</label><br>";
pr_edit_subform("text_input","xml_agent_group",NULL,"pr_xml_agent_group");
echo "</p>";
echo "<p><label for=\"xml_agent_branch\">Agent branch code:</label><br>";
pr_edit_subform("text_input","xml_agent_branch",NULL,"pr_xml_agent_branch");
echo "</p>";
echo "<p><label for=\"xml_Export_from\">Export properties from:</label><br>";
pr_edit_subform("text_input","xml_Export_from",NULL,"xml_Export_from");
echo "</p>";
echo "<p><label for=\"xml_Export_prop_type\">Export properties:</label><br>";
?>
<select name="xml_Export_prop_type" id="xml_Export_prop_type">
<option value="all">All</option>
<option value="lettings">Lettings</option>
<option value="sales">Sales</option>
</select>
<?
echo "</p>";
echo "<p><label for=\"xml_mode\">Export mode:</label><br>";
?>
<select name="pr_xml_mode" id="xml_mode">
<option value="FULL">FULL</option>
<option value="INCR">INCR</option>
</select>
<?
echo "</p>";

echo "<p>";
pr_edit_subform("submit","Export",NULL,"Export");
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
				post_params: {"PHPSESSID": "<?php echo session_id(); ?>","upload_type":"<?echo $type?>"<? if (isset($_GET['pr_id'])) {?>,"prid":"<?echo $_GET['pr_id'];?>"<?}?>},

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

function pr_upload_pic_tmp($pic,$filename) // called via AJAX
{
	global $wpdb,$pr_pic_table_tmp,$pr_tmp_pics;
	// $_SESSION vaiables must be set

	$_ext = pr_file_extension($pic['name']);
	move_uploaded_file($pic['tmp_name'],$pr_tmp_pics.$filename.'.'.$_ext); // moving uploaded to tmp folder
	$wpdb->query($wpdb->prepare("INSERT INTO $pr_pic_table_tmp (ID,filename,user_id,identifier) values (NULL, '%s',%d,'%s')",$filename.'.'.$_ext,$_SESSION['user_id'],$_SESSION['identifier']));// adding rows to tmp table

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
function pr_upload_file_tmp($file,$filename) // called via AJAX
{
	global $wpdb,$pr_files_table_tmp,$pr_tmp_pics;
	// $_SESSION vaiables must be set

	//$_ext = pr_file_extension($file['name']);
	move_uploaded_file($file['tmp_name'],$pr_tmp_pics.$_SESSION['identifier'].'_'.$filename.'_'.$file['name']); // moving uploaded to tmp folder
	$wpdb->query($wpdb->prepare("INSERT INTO $pr_files_table_tmp (ID,filename,user_id,identifier) values (NULL, '%s',%d,'%s')",$_SESSION['identifier'].'_'.$filename.'_'.$file['name'],$_SESSION['user_id'],$_SESSION['identifier']));// adding rows to tmp table

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
			$file_title = str_replace($_SESSION['identifier'].'_','',$file->filename);// удаляем
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
if ($parents != NULL)
{
	$parents = array_reverse($parents);
	if ($type=='root') return $parents[0];// первая запись - корень дерева area
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
			return $pics;
			}
				else {return NULL;}
		break;
		case 'without_main':
			$pics = $wpdb->get_results("SELECT img_name FROM $pr_pic_table WHERE prid = $prid AND main = 0;");
			//print_r($pics);
			if ($pics != NULL) {
			foreach($pics as $k=>$pic)
			{
				$pics[$k] = $pr_img_show_folder.$pic->img_name;
			}
			return $pics;
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
	if ($type=='root') return $parents[0];// первая запись - корень дерева area
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
$sql = "INSERT INTO $tree_table ($add) values ($values);";	// не мешало бы защиту от инъекций сделать, но пока это доступно только со страницы админа.
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
$sql = "UPDATE $tree_table SET $set WHERE $id_column = $branch_id;";	// не мешало бы защиту от инъекций сделать, но пока это доступно только со страницы админа.
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
	//$start = 0;//для случаев когда дети выше родителей, такое бывает))
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
	$start = 0;//для случаев когда дети выше родителей, такое бывает))
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
	if ($_parent != NULL)
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
	if (isset($_GET['action']) and ($_GET['action'] == $form_prefix.'_branch_edit') and isset($_GET['branch_id'])) $selected_id = $_GET['branch_id'];// выбранная для редактирования ветка дерева
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
	$price = number_format($price,2);

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
/*$count = $wpdb->get_var("SELECT COUNT(ID) FROM $pr_properties WHERE property_type = $type");// тут необходима выборка с учетом фильтра
//$wpdb->show_errors();
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
		<?echo $prop->door_number.', '.$prop->street.', '.$prop->postcode.', '.pr_area_path($prop->area_id);?>
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
?>