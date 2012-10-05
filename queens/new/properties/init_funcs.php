<?php

function pri_AddUpdateProperty(){
	global $user_ID,$pr_properties,$wpdb,$pr_slug,$_err_ids;

$_result = FALSE; // making temp variable to store error text
$_err_ids = NULL;

if(is_user_logged_in()) // user must be logged in to perform all these actions
{

	// menu
	//pr_m_(prf_prop_menu(),'menu','div');

	// ????????? ??????? ?????????? ? ??????????
	// do all the magic

	if (isset($_POST['pr_action']))
	{
		switch($_POST['pr_action'])
		{
			case 'add':
				// ?????????? ??????? ??? ??????
				switch ($_GET['pr_action'])
				{
					case 'prf_add_sale':
if($_POST['pr_addr_street'] != NULL and $_POST['pr_addr_door_number'] != NULL and $_POST['pr_area'] != NULL and $_POST['pr_prop_types'] !=NULL)
{

	if(!isset($_POST['pr_extra_active'])) $active = 0; else $active = $_POST['pr_extra_active'];
	//if(!isset($_POST['pr_extra_featured'])) $featured = 0; else $featured = $_POST['pr_extra_featured'];
	//$active = 0;
	$featured = 0;
	if ($_POST['pr_extra_date_avail_from']!='') $pr_extra_date_avail_from = $_POST['pr_extra_date_avail_from']; else $pr_extra_date_avail_from = NULL;
	$pr_extra_date_displ_from = NULL;
	// user can't change this parameters

	pr_sale_add($_POST['pr_sale_price'],$_POST['pr_descr'],$_POST['pr_viewarrange'],$_POST['pr_refnumber'],$_POST['pr_area'],$_POST['pr_prop_types'],$_POST['pr_bedroomnum'],$_POST['pr_addr_building_name'],$_POST['pr_addr_door_number'],$_POST['pr_addr_street'],NULL,NULL,NULL,$_POST['pr_postcode'],$pr_extra_date_avail_from,$pr_extra_date_displ_from,$active,$featured,$_POST['pr_extra_furnishing'],$_POST['pr_extra_status']);
	$_result = TRUE;
	//pr_m_('New property has been added');
} else {
	//pr_m_('You haven\'t filled all necessary fields');
	$_err_msg = 'You haven\'t filled all necessary fields';

	//print_r($_err_ids);
	pr_delete_tmp_pics($user_ID);
}
						break;

					case 'prf_add_let':
if($_POST['pr_addr_street'] != NULL and $_POST['pr_addr_door_number'] != NULL and $_POST['pr_area'] != NULL and $_POST['pr_prop_types'])
{

	if(!isset($_POST['pr_extra_active'])) $active = 0; else $active = $_POST['pr_extra_active'];
	//if(!isset($_POST['pr_extra_featured'])) $featured = 0; else $featured = $_POST['pr_extra_featured'];
	//$active = 0;
	$featured = 0;
	if ($_POST['pr_extra_date_avail_from']!='') $pr_extra_date_avail_from = $_POST['pr_extra_date_avail_from']; else $pr_extra_date_avail_from = NULL;
	$pr_extra_date_displ_from = NULL;
	// user can't change this parameters

	pr_letting_add($_POST['pr_let_weekrent'],$_POST['pr_descr'],$_POST['pr_viewarrange'],$_POST['pr_refnumber'],$_POST['pr_area'],$_POST['pr_prop_types'],$_POST['pr_bedroomnum'],$_POST['pr_addr_building_name'],$_POST['pr_addr_door_number'],$_POST['pr_addr_street'],NULL,NULL,NULL,$_POST['pr_postcode'],$pr_extra_date_avail_from,$pr_extra_date_displ_from,$active,$featured,$_POST['pr_extra_furnishing'],$_POST['pr_extra_status']);

	$_result = TRUE;
	//pr_m_('New letting has been added');
} else {
	//pr_m_('You haven\'t filled all necessary fields');
	$_err_msg = 'You haven\'t filled all necessary fields';
	$_err_ids = pr_set_errors_adding_property();
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
if($_POST['pr_addr_street'] != NULL and $_POST['pr_addr_door_number'] != NULL and $_POST['pr_prop_types'])

{

	//if(!isset($_POST['pr_extra_active'])) $active = 0; else $active = $_POST['pr_extra_active'];
	//if(!isset($_POST['pr_extra_featured'])) $featured = 0; else $featured = $_POST['pr_extra_featured'];

	pr_sale_update($_POST['pr_sale_price'],$_POST['pr_descr'],$_POST['pr_viewarrange'],$_POST['pr_refnumber'],$area,$_POST['pr_prop_types'],$_POST['pr_bedroomnum'],$_POST['pr_addr_building_name'],$_POST['pr_addr_door_number'],$_POST['pr_addr_street'],NULL,NULL,NULL,$_POST['pr_postcode'],$pr_extra_date_avail_from,$pr_extra_date_displ_from,$active,$featured,$_POST['pr_extra_furnishing'],$_POST['pr_extra_status']);
	//pr_m_('A sale has been edited');
	$_result = TRUE;
} else {
	//pr_m_('You haven\'t filled all necessary fields');
	$_err_msg = 'You haven\'t filled all necessary fields';
	pr_delete_tmp_pics($user_ID);
}
} else {
	$_err_msg = 'You don\'t have permission to edit this property';
	//pr_m_('You don\'t have permission to edit this property','error','div');
}
						break;
					case 1://let
if ($user_ID==$_user_id)
{
if($_POST['pr_addr_street'] != NULL and $_POST['pr_addr_door_number'] != NULL and $_POST['pr_prop_types'])
{


	//if(!isset($_POST['pr_extra_active'])) $active = 0; else $active = $_POST['pr_extra_active'];
	//if(!isset($_POST['pr_extra_featured'])) $featured = 0; else $featured = $_POST['pr_extra_featured'];

	pr_letting_update($_POST['pr_let_weekrent'],$_POST['pr_descr'],$_POST['pr_viewarrange'],$_POST['pr_refnumber'],$area,$_POST['pr_prop_types'],$_POST['pr_bedroomnum'],$_POST['pr_addr_building_name'],$_POST['pr_addr_door_number'],$_POST['pr_addr_street'],NULL,NULL,NULL,$_POST['pr_postcode'],$pr_extra_date_avail_from,$pr_extra_date_displ_from,$active,$featured,$_POST['pr_extra_furnishing'],$_POST['pr_extra_status']);
	//pr_m_('A letting has been edited');
	$_result = TRUE;
} else {
	//pr_m_('You haven\'t filled all necessary fields');
	$_err_msg = 'You haven\'t filled all necessary fields';
	pr_delete_tmp_pics($user_ID);
}
} else {
	//pr_m_('You don\'t have permission to edit this property','error','div');
	$_err_msg = 'You don\'t have permission to edit this property';
}
						break;
				}

				break;
		}
	}
}
	$_POST['_err_ids'] = $_err_ids;
	$_POST['AddUpdateProperty'] = $_err_msg;
	return $_result;
}

?>