<?php
// Check Whether User Can Add Review
if(!current_user_can('manage_pgr')) {
  die('Access Denied');
}

$base_name = plugin_basename('pg-review/pgr-manager.php');
$base_page = 'admin.php?page='.$base_name;
$pgrvw = $wpdb->prefix . 'pgrvw';
$pgrvw_right = $wpdb->prefix . 'pgrvw_right';
$pgrvw_mbox = $wpdb->prefix . 'pgrvw_mbox';

include_once('wpframe.php');
wpframe_stop_direct_call(__FILE__);
wpframe_add_editor_js();

$pgr_id = isset($_REQUEST['pgr_id']) ? $_REQUEST['pgr_id'] : '';
if (!$flogo_url) $logo_url = isset($_REQUEST['logo_url']) ? $_REQUEST['logo_url'] : '';
else $logo_url = $flogo_url;
$pgr_title = isset($_REQUEST['pgr_title']) ? $_REQUEST['pgr_title'] : '';
$parent_id = isset($_REQUEST['parent_id']) ? $_REQUEST['parent_id'] : '';
$pgr_type = isset($_REQUEST['pgr_type']) ? $_REQUEST['pgr_type'] : '';
$pgr_score = isset($_REQUEST['pgr_score']) ? $_REQUEST['pgr_score'] : '';
$pgr_rurl = isset($_REQUEST['pgr_rurl']) ? $_REQUEST['pgr_rurl'] : '';
$pgr_durl = isset($_REQUEST['pgr_durl']) ? $_REQUEST['pgr_durl'] : '';
$pgr_player = isset($_REQUEST['pgr_player']) ? $_REQUEST['pgr_player'] : '';
$pgr_fullhtml = isset($_REQUEST['pgr_fullhtml']) ? str_replace('"', '&quot;', $_REQUEST['pgr_fullhtml']) : '';
$pgr_subtitle = isset($_REQUEST['pgr_subtitle']) ? $_REQUEST['pgr_subtitle'] : '';
$pgr_descr = isset($_REQUEST['pgr_descr']) ? str_replace('"', '&quot;', $_REQUEST['pgr_descr']) : '';
//$pgr_descr = isset($_REQUEST['descr_pgr']) ? $_REQUEST['descr_pgr'] : '';
if (!$fr_url) $pgr_img = isset($_REQUEST['pgr_img']) ? $_REQUEST['pgr_img'] : '';
else $pgr_img = $fr_url;
$pgr_os_pc = isset($_REQUEST['pgr_os_pc']) ? $_REQUEST['pgr_os_pc'] : '';
$pgr_os_mac = isset($_REQUEST['pgr_os_mac']) ? $_REQUEST['pgr_os_mac'] : '';
$pgr_featured = isset($_REQUEST['pgr_featured']) ? $_REQUEST['pgr_featured'] : '';
$pgr_position = isset($_REQUEST['pgr_position']) ? $_REQUEST['pgr_position'] : '';
$pgr_shdescr = isset($_REQUEST['pgr_shdescr']) ? $_REQUEST['pgr_shdescr'] : '';
$pgr_offtitle = isset($_REQUEST['pgr_offtitle']) ? $_REQUEST['pgr_offtitle'] : '';
$pgr_bonustype = isset($_REQUEST['pgr_bonustype']) ? $_REQUEST['pgr_bonustype'] : '';
$pgr_offvaluef = isset($_REQUEST['pgr_offvaluef']) ? $_REQUEST['pgr_offvaluef'] : '';
$pgr_offvaluet = isset($_REQUEST['pgr_offvaluet']) ? $_REQUEST['pgr_offvaluet'] : '';
$pgr_offbcode = isset($_REQUEST['pgr_offbcode']) ? $_REQUEST['pgr_offbcode'] : '';
$pgr_offbreg = isset($_REQUEST['pgr_offbreg']) ? $_REQUEST['pgr_offbreg'] : '';
$pgr_offrvwlnktitle = isset($_REQUEST['pgr_offrvwlnktitle']) ? $_REQUEST['pgr_offrvwlnktitle'] : '';
// for right side box
$pgr_rsb_name = isset($_REQUEST['pgr_rsb_name']) ? $_REQUEST['pgr_rsb_name'] : '';
$pgr_rsb_establish = isset($_REQUEST['pgr_rsb_establish']) ? $_REQUEST['pgr_rsb_establish'] : '';
$pgr_rsb_country = isset($_REQUEST['pgr_rsb_country']) ? $_REQUEST['pgr_rsb_country'] : '';
$pgr_rsb_auditor = isset($_REQUEST['pgr_rsb_auditor']) ? $_REQUEST['pgr_rsb_auditor'] : '';
$pgr_rsb_network = isset($_REQUEST['pgr_rsb_network']) ? $_REQUEST['pgr_rsb_network'] : '';
$pgr_rsb_size = isset($_REQUEST['pgr_rsb_size']) ? $_REQUEST['pgr_rsb_size'] : '';
$pgr_rsb_email = isset($_REQUEST['pgr_rsb_email']) ? $_REQUEST['pgr_rsb_email'] : '';
$pgr_rsb_tel = isset($_REQUEST['pgr_rsb_tel']) ? $_REQUEST['pgr_rsb_tel'] : '';
$pgr_rsb_payvisa = isset($_REQUEST['pgr_rsb_payvisa']) ? $_REQUEST['pgr_rsb_payvisa'] : '';
$pgr_rsb_paymaster = isset($_REQUEST['pgr_rsb_paymaster']) ? $_REQUEST['pgr_rsb_paymaster'] : '';
$pgr_rsb_payukash = isset($_REQUEST['pgr_rsb_payukash']) ? $_REQUEST['pgr_rsb_payukash'] : '';
$pgr_rsb_payclickbuy = isset($_REQUEST['pgr_rsb_payclickbuy']) ? $_REQUEST['pgr_rsb_payclickbuy'] : '';
$pgr_rsb_payneteller = isset($_REQUEST['pgr_rsb_payneteller']) ? $_REQUEST['pgr_rsb_payneteller'] : '';
$pgr_rsb_paybookers = isset($_REQUEST['pgr_rsb_paybookers']) ? $_REQUEST['pgr_rsb_paybookers'] : '';
$pgr_rsb_payclickpay = isset($_REQUEST['pgr_rsb_payclickpay']) ? $_REQUEST['pgr_rsb_payclickpay'] : '';
$pgr_rsb_payentro = isset($_REQUEST['pgr_rsb_payentro']) ? $_REQUEST['pgr_rsb_payentro'] : '';
$pgr_rsb_payecash = isset($_REQUEST['pgr_rsb_payecash']) ? $_REQUEST['pgr_rsb_payecash'] : '';
$pgr_rsb_paydebit = isset($_REQUEST['pgr_rsb_paydebit']) ? $_REQUEST['pgr_rsb_paydebit'] : '';
$pgr_rsb_paycheques = isset($_REQUEST['pgr_rsb_paycheques']) ? $_REQUEST['pgr_rsb_paycheques'] : '';
$pgr_rsb_paywire = isset($_REQUEST['pgr_rsb_paywire']) ? $_REQUEST['pgr_rsb_paywire'] : '';
$pgr_rsb_paydiners = isset($_REQUEST['pgr_rsb_paydiners']) ? $_REQUEST['pgr_rsb_paydiners'] : '';
$pgr_rsb_paywu = isset($_REQUEST['pgr_rsb_paywu']) ? $_REQUEST['pgr_rsb_paywu'] : '';
$pgr_rsb_paypal = isset($_REQUEST['pgr_rsb_paypal']) ? $_REQUEST['pgr_rsb_paypal'] : '';
$pgr_rsb_paytransfers = isset($_REQUEST['pgr_rsb_paytransfers']) ? $_REQUEST['pgr_rsb_paytransfers'] : '';
// for multiplay boxes
$pgr_mtitle = isset($_REQUEST['pgr_mtitle']) ? $_REQUEST['pgr_mtitle'] : '';
$pgr_mrating = isset($_REQUEST['pgr_mrating']) ? $_REQUEST['pgr_mrating'] : '';
//$pgr_mdescr = isset($_REQUEST['pgr_mdescr']) ? $_REQUEST['pgr_mdescr'] : '';
$pgr_mdescr = isset($_REQUEST['pgr_mdescr']) ? $_REQUEST['pgr_mdescr'] : '';

//$pgr_fullhtml = addslashes($pgr_fullhtml);
$txt_hidden = "";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_title\" value=\"$pgr_title\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_shdescr\" value=\"$pgr_shdescr\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"parent_id\" value=\"$parent_id\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_type\" value=\"$pgr_type\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_score\" value=\"$pgr_score\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rurl\" value=\"$pgr_rurl\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_durl\" value=\"$pgr_durl\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_player\" value=\"$pgr_player\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_subtitle\" value=\"$pgr_subtitle\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_fullhtml\" value=\"$pgr_fullhtml\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_descr\" value=\"$pgr_descr\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_mdescr\" value=\"$pgr_mdescr\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_os_pc\" value=\"$pgr_os_pc\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_os_mac\" value=\"$pgr_os_mac\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_featured\" value=\"$pgr_featured\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_position\" value=\"$pgr_position\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_offtitle\" value=\"$pgr_offtitle\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_bonustype\" value=\"$pgr_bonustype\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_offvaluef\" value=\"$pgr_offvaluef\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_offvaluet\" value=\"$pgr_offvaluet\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_offbcode\" value=\"$pgr_offbcode\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_offbreg\" value=\"$pgr_offbreg\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_offrvwlnktitle\" value=\"$pgr_offrvwlnktitle\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_name\" value=\"$pgr_rsb_name\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_establish\" value=\"$pgr_rsb_establish\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_country\" value=\"$pgr_rsb_country\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_auditor\" value=\"$pgr_rsb_auditor\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_network\" value=\"$pgr_rsb_network\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_size\" value=\"$pgr_rsb_size\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_email\" value=\"$pgr_rsb_email\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_tel\" value=\"$pgr_rsb_tel\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_payvisa\" value=\"$pgr_rsb_payvisa\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_paymaster\" value=\"$pgr_rsb_paymaster\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_paymaster\" value=\"$pgr_rsb_paymaster\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_payukash\" value=\"$pgr_rsb_payukash\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_payclickbuy\" value=\"$pgr_rsb_payclickbuy\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_payneteller\" value=\"$pgr_rsb_payneteller\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_paybookers\" value=\"$pgr_rsb_paybookers\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_payclickpay\" value=\"$pgr_rsb_payclickpay\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_payentro\" value=\"$pgr_rsb_payentro\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_payecash\" value=\"$pgr_rsb_payecash\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_paydebit\" value=\"$pgr_rsb_paydebit\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_paycheques\" value=\"$pgr_rsb_paycheques\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_paywire\" value=\"$pgr_rsb_paywire\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_paydiners\" value=\"$pgr_rsb_paydiners\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_paywu\" value=\"$pgr_rsb_paywu\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_paypal\" value=\"$pgr_rsb_paypal\" />";
$txt_hidden .= "<input type=\"hidden\" name=\"pgr_rsb_paytransfers\" value=\"$pgr_rsb_paytransfers\" />";

?>