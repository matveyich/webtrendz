<div class="wrap">
<? 
$prid = NULL;
if (isset($_GET['pr_id']))
{
	$prid = $_GET['pr_id'];
	pr_m_('Edit letting','','h2');
	$action = "edit";
}
else 
{
	pr_m_('Add new letting','','h2');
	$action = "add";
}
?>
</div>


<?
if (isset($_POST['submit'])){
switch ($_POST['pr_action'])
{
	case "add":
if($_POST['pr_addr_building_name'] != NULL and $_POST['pr_addr_street'] != NULL and $_POST['pr_addr_door_number'] != NULL)
{
	
	if(!isset($_POST['pr_extra_active'])) $active = 0; else $active = $_POST['pr_extra_active'];
	if(!isset($_POST['pr_extra_featured'])) $featured = 0; else $featured = $_POST['pr_extra_featured'];
	
	pr_letting_add($_POST['pr_let_weekrent'],$_POST['pr_descr'],$_POST['pr_viewarrange'],$_POST['pr_refnumber'],$_POST['pr_area'],$_POST['pr_prop_types'],$_POST['pr_bedroomnum'],$_POST['pr_addr_building_name'],$_POST['pr_addr_door_number'],$_POST['pr_addr_street'],NULL,NULL,NULL,$_POST['pr_postcode'],$_POST['pr_extra_date_avail_from'],$_POST['pr_extra_date_displ_from'],$active,$featured,$_POST['pr_extra_furnishing'],$_POST['pr_extra_status']);
pr_m_('New letting has been added');
} else {pr_m_('You haven\'t filled all necessary fields');
		pr_delete_tmp_pics($user_ID);
	}
	break;
	case "edit":
	if($_POST['pr_addr_building_name'] != NULL and $_POST['pr_addr_street'] != NULL and $_POST['pr_addr_door_number'] != NULL)
{
	
	if(!isset($_POST['pr_extra_active'])) $active = 0; else $active = $_POST['pr_extra_active'];
	if(!isset($_POST['pr_extra_featured'])) $featured = 0; else $featured = $_POST['pr_extra_featured'];
	
	pr_letting_update($_POST['pr_let_weekrent'],$_POST['pr_descr'],$_POST['pr_viewarrange'],$_POST['pr_refnumber'],$_POST['pr_area'],$_POST['pr_prop_types'],$_POST['pr_bedroomnum'],$_POST['pr_addr_building_name'],$_POST['pr_addr_door_number'],$_POST['pr_addr_street'],NULL,NULL,NULL,$_POST['pr_postcode'],$_POST['pr_extra_date_avail_from'],$_POST['pr_extra_date_displ_from'],$active,$featured,$_POST['pr_extra_furnishing'],$_POST['pr_extra_status']);
pr_m_('A letting has been edited');
} else {
	pr_m_('You haven\'t filled all necessary fields');
	pr_delete_tmp_pics($user_ID);
	}
	break;
}
}

if (isset($_GET['page_id'])) $page_id = $_GET['page_id']; else $page_id = 1;
if (isset($_GET['pr_del_id'])) pr_prop_delete($_GET['pr_del_id']);

if($action == "add") pr_prop_list(1,$page_id);

pr_letting_form($prid,$action);//if prid is not null the form will generated for editing letting with ID = prid

if($action == "edit") pr_prop_list(1,$page_id);
?>