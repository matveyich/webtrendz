<script>
function edToolbar_wtz(canvas_name)
	{
	document.write('<div id="ed_toolbar">');
	for(var a=0;a<edButtons.length;a++)
	{
	edShowButton_wtz(edButtons[a],a,canvas_name); 
	}
	document.write('<input type="button" id="ed_spell" class="ed_button" onclick="edSpell('+canvas_name+');" title="'+quicktagsL10n.dictionaryLookup+'" value="'+quicktagsL10n.lookup+'" />');
	document.write('<input type="button" id="ed_close" class="ed_button" onclick="edCloseAllTags_wtz('+canvas_name+');" title="'+quicktagsL10n.closeAllOpenTags+'" value="'+quicktagsL10n.closeTags+'" />');
	document.write("</div>")
	}
function edCloseAllTags_wtz(canvas_name)
	{
	var a=edOpenTags.length,b;
	for(b=0;b<a;b++)
		{
		edInsertTag(canvas_name,edOpenTags[edOpenTags.length-1])
		}
	}	
function edShowButton_wtz(b,a,canvas_name)
	{
	if(b.id=="ed_img")
	{
		document.write('<input type="button" id="'+b.id+'" accesskey="'+b.access+'" class="ed_button" onclick="edInsertImage('+canvas_name+');" value="'+b.display+'" />')
	}else{
		if(b.id=="ed_link")
		{
			document.write('<input type="button" id="'+b.id+'" accesskey="'+b.access+'" class="ed_button" onclick="edInsertLink('+canvas_name+', '+a+');" value="'+b.display+'" />')
		}else{
		document.write('<input type="button" id="'+b.id+'" accesskey="'+b.access+'" class="ed_button" onclick="edInsertTag('+canvas_name+', '+a+');" value="'+b.display+'"  />')
		}
		}
	}
</script>
<style>
#editorcontainer textarea {width:100%;}
</style>
<?php

include_once('func.php');
$pgract = isset($_REQUEST['doaction']) ? $_REQUEST['doaction'] : '';
$pid = isset($_REQUEST['pid']) ? $_REQUEST['pid'] : '';
//==Decide What To Do==
switch($pgract)
{
  // Save info for main, summary, offer
  // Ask info Right side boxes
  case __('Update Review', 'pg-review'):
    $result = $wpdb->query( $wpdb->prepare("UPDATE $pgrvw SET urllogo=%s,title=%s,parent_id=%d,review_type=%s,score=%f,urlreview=%s,urldownload=%s,player=%s,fullhtml=%s,subtitle=%s,descr=%s,urlimg=%s,ospc=%d,osmac=%d,offertitle=%s,offervaluef=%s,offervaluet=%s,offerbcode=%s,offerbregular=%s,offerlnktitle=%s,name=%s,establish=%s,country=%s,auditor=%s,network=%s,size=%s,email=%s,tel=%s,payvisa=%d,paymaster=%d,payukash=%d,payclickbuy=%d,payneteller=%d,paybookers=%d,payclickpay=%d,payentro=%d,paydebit=%d,paycheques=%d,paywire=%d,paydiners=%d,paywu=%d,paypal=%d,featured=%d,shdescr=%s WHERE id = %d",$logo_url,$pgr_title,$parent_id,$pgr_type,$pgr_score,$pgr_rurl,$pgr_durl,$pgr_player,$pgr_fullhtml,$pgr_subtitle,$pgr_descr,$pgr_img,$pgr_os_pc,$pgr_os_mac,$pgr_offtitle,$pgr_offvaluef,$pgr_offvaluet,$pgr_offbcode,$pgr_offbreg,$pgr_offrvwlnktitle,$pgr_rsb_name,$pgr_rsb_establish,$pgr_rsb_country,$pgr_rsb_auditor,$pgr_rsb_network,$pgr_rsb_size,$pgr_rsb_email,$pgr_rsb_tel,$pgr_rsb_payvisa,$pgr_rsb_paymaster,$pgr_rsb_payukash,$pgr_rsb_payclickbuy,$pgr_rsb_payneteller,$pgr_rsb_paybookers,$pgr_rsb_payclickpay,$pgr_rsb_payentro,$pgr_rsb_paydebit,$pgr_rsb_paycheques,$pgr_rsb_paywire,$pgr_rsb_paydinres,$pgr_rsb_paywu,$pgr_rsb_paypal,$pgr_featured,$pgr_shdescr,$pgr_id) );
echo mysql_error();

    $page['ID'] = $wpdb->get_var("SELECT padeid FROM $pgrvw WHERE id = $pgr_id");
    $parent_id = $wpdb->get_var("SELECT parent_id FROM $pgrvw WHERE id = $pgr_id");
    $pgr_pageid = $page['ID'];
    include_once('pgr-template.php');
    $page['post_type'] = 'page';
    $page['post_content'] = $contentofpage;
    $page['post_parent'] = $parent_id;
    $page['post_author'] = $user_ID;
    $page['post_status'] = 'publish';
    $page['post_title'] = $pgr_title;
	// WTZ flag for wp_insert_post() in wp-includes/post.php
	$page['from_rvw_mngmnt'] = true;
    // update post
    wp_update_post($page);
update_post_meta($pgr_pageid, '_wp_page_template', 'review_page.php');
    ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo plugin_basename(__FILE__); ?>" enctype="multipart/form-data">
    <div class="wrap">
      <div id="icon-wp-pgr" class="icon32"><br /></div>
      <h2><?php _e('Edit Review', 'pg-review'); ?></h2>
        <table class="form-table">
          <tr>
            <?php
            if ($result)
            {
            ?>
            <td width="80%">Page Review Changed</td>
            <?php
            }
            else
            {
            ?>
            <td width="80%">Page Review NOT Changed.<br/> Error: Record not stored in database.</td>
            <?php
            }
            ?>
          </tr>
          <tr>
            <td width="80%"><input type="submit" name="doaction" value="<?php _e('List Reviews', 'pg-review'); ?>"  class="button" />&nbsp;&nbsp;<input type="button" name="cancel" value="<?php _e('Back', 'pg-review'); ?>" class="button" onclick="javascript:history.go(-1)" /></td>
          </tr>
        </table>
    </div>
    </form>
  <?php
  break;
   
  // Upload Logo
  case __('Upload Logo Image', 'pg-review'):
  case __('Change Logo Image', 'pg-review'):
    ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo plugin_basename(__FILE__); ?>" enctype="multipart/form-data">
    <input type="hidden" name="pgr_img" value="<?php echo $_REQUEST['pgr_img']; ?>" />
    <input type="hidden" name="doaction" value="Edit" />
    <input type="hidden" name="pgr_id" value="<?php echo $pgr_id;?>" />
    <?php echo $txt_hidden;?>
    <div class="wrap">
      <div id="icon-wp-pgr" class="icon32"><br /></div>
      <h2><?php _e('Add New Review', 'pg-review'); ?></h2>
      <!-- Main Info -->
      <h3><?php _e('Upload Logo', 'pg-review'); ?></h3>
      <table class="form-table">
        <tr>
          <th width="20%" scope="row" valign="top"><?php _e('Select Image', 'pg-review') ?></th>
          <td width="80%"><input type="file" name="pgr_logo"></td>
        </tr>
        <tr>
          <th width="20%" scope="row" valign="top">&nbsp;</th>
          <td width="80%"><input type="submit" name="doact" value="<?php _e('Upload', 'pg-review'); ?>"  class="button" />&nbsp;&nbsp;<input type="button" name="cancel" value="<?php _e('Cancel', 'pg-review'); ?>" class="button" onclick="javascript:history.go(-1)" /></td>
        </tr>
      </table>
    </div>
    </form>
    <?php
  break;

  // Upload Review Image
  case __('Upload Review Image', 'pg-review'):
  case __('Change Review Image', 'pg-review'):
    ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo plugin_basename(__FILE__); ?>" enctype="multipart/form-data">
    <input type="hidden" name="logo_url" value="<?php echo $_REQUEST['logo_url']; ?>" />
    <input type="hidden" name="doaction" value="Edit" />
    <input type="hidden" name="pgr_id" value="<?php echo $pgr_id;?>" />
    <?php echo $txt_hidden;?>
    <div class="wrap">
      <div id="icon-wp-pgr" class="icon32"><br /></div>
      <h2><?php _e('Add New Review', 'pg-review'); ?></h2>
      <!-- Main Info -->
      <h3><?php _e('Upload Review Image', 'pg-review'); ?></h3>
      <table class="form-table">
        <tr>
          <th width="20%" scope="row" valign="top"><?php _e('Select Image', 'pg-review') ?></th>
          <td width="80%"><input type="file" name="pgr_img"></td>
        </tr>
        <tr>
          <th width="20%" scope="row" valign="top">&nbsp;</th>
          <td width="80%"><input type="submit" name="doact" value="<?php _e('Upload', 'pg-review'); ?>"  class="button" />&nbsp;&nbsp;<input type="button" name="cancel" value="<?php _e('Cancel', 'pg-review'); ?>" class="button" onclick="javascript:history.go(-1)" /></td>
        </tr>
      </table>
    </div>
    </form>
    <?php
  break;


  // edit multiboxes
  case __('Edit MultiBox', 'pg-review'):
  case 'doedit_mbox':
    $mbox_id = isset($_REQUEST['mbox_id']) ? $_REQUEST['mbox_id'] : '';
    $tmpmbox = $wpdb->get_results("SELECT * FROM $pgrvw_mbox WHERE id = '$mbox_id'");
    if ($tmpmbox)
    {
      foreach($tmpmbox as $mdata)
      {
        $data_mtitle = $mdata->title;
        $data_mrating = $mdata->rating;
        $data_mdescr = $mdata->descr;
      }
    }
    ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo plugin_basename(__FILE__); ?>" enctype="multipart/form-data">
    <input type="hidden" name="pgr_id" value="<?php echo $pgr_id;?>" />
    <input type="hidden" name="mbox_id" value="<?php echo $mbox_id;?>" />
    <div class="wrap">
      <div id="icon-wp-pgr" class="icon32"><br /></div>
      <h2><?php _e('Edit Box', 'pg-review'); ?></h2>
      <!-- Main Info -->
      <table class="form-table">
        <tr>
          <th width="20%" scope="row" valign="top"><?php _e('Title', 'pg-review') ?></th>
          <td width="80%"><input type="text" size="20" name="pgr_mtitle" value="<?php echo $data_mtitle;?>" /></td>
        </tr>
        <tr>
          <th width="20%" scope="row" valign="top"><?php _e('Rating', 'pg-review') ?></th>
          <td width="80%">
            <select name="pgr_mrating">
              <option disabled selected value="">Please rating from dropdown list</option>
              <?php
                $i = 0;
                $imrating[$i] = 1;
                echo "<option value=\"$imrating[$i]\">$imrating[$i]</option>\n";
                while ($imrating[$i] < 10)
                {
                  $i ++;
                  $imrating[$i] = $imrating[$i-1] + 0.5;
                  if($data_mrating=="$imrating[$i]") $txtselected = "selected";
                  else $txtselected = "";
                  echo "<option value=\"$imrating[$i]\" $txtselected>$imrating[$i]</option>\n";
                }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <div id="poststuff" style="min-width:550px">
              <div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" class="postarea">
                <div class="postbox">
                  <h3 class="hndle"><span><?php _e('Description', 'pg-review') ?></span></h3>
                  <div class="inside">
                    <?php the_editor_wtz(stripslashes($data_mdescr),'pgr_mdescr','pgr_mdescr'); ?>
                  </div>
                </div>
              </div>
            </div>
          </td>
        </tr>

        <tr>
          <td colspan="2"><input type="submit" name="doaction" value="<?php _e('Update MultiBox', 'pg-review'); ?>" class="button" /></td>
        </tr>
      </table>
    </div>
    </form>
    <?php
  break;

  // edit review and do storing to DB
  case __('Edit', 'pg-review'):
  case __('Ledit', 'pg-review'):
  case __('Add MultiBox', 'pg-review'):
  case __('Update MultiBox', 'pg-review'):
  case 'dodel_mbox': 

  //delete multiboxes
	if ($pgract == 'dodel_mbox')
    { 
		$mbox_id = isset($_REQUEST['mbox_id']) ? $_REQUEST['mbox_id'] : '';
		$result = $wpdb->query("DELETE FROM $pgrvw_mbox WHERE id = '$mbox_id'");
		echo mysql_error();
	}
	
	// if adding new mbox
    if ($pgract == __('Add MultiBox', 'pg-review'))
    {
      $result = $wpdb->query("INSERT INTO $pgrvw_mbox (pid,title,rating,descr) VALUES ('$pgr_id','$pgr_mtitle','$pgr_mrating','$pgr_mdescr')");
      $pgr_mtitle = '';
      $pgr_mrating = '';
      $pgr_mdescr = '';
    }
    else
    {
      $mbox_id = isset($_REQUEST['mbox_id']) ? $_REQUEST['mbox_id'] : '';
      if ($mbox_id)
      {
        $resultm = $wpdb->query( $wpdb->prepare("UPDATE $pgrvw_mbox SET title=%s,rating=%f,descr=%s WHERE id = %d",$pgr_mtitle,$pgr_mrating,$pgr_mdescr,$mbox_id) );
        $pgr_mtitle = '';
        $pgr_mrating = '';
        $pgr_mdescr = '';
      }
    }
    $pgrs = $wpdb->get_row("SELECT * FROM $pgrvw WHERE id = '$pgr_id'");
    if(($pgract == __('Ledit', 'pg-review')) || (($pgract == __('Update MultiBox', 'pg-review'))))
    {
      $pgr_title = $pgrs->title;
      $parent_id = $pgrs->parent_id;
      $pgr_type = $pgrs->review_type;
      $pgr_score = $pgrs->score;
      $pgr_rurl = $pgrs->urlreview;
      $pgr_durl = $pgrs->urldownload;
      $pgr_player = $pgrs->player;
      $pgr_subtitle = $pgrs->subtitle;
      $pgr_descr = $pgrs->descr;
      $pgr_os_pc = $pgrs->ospc;
      $pgr_os_mac = $pgrs->osmac;
      $pgr_offtitle = $pgrs->offertitle;
      $pgr_offvaluef = $pgrs->offervaluef;
      $pgr_offvaluet = $pgrs->offervaluet;
      $pgr_offbcode = $pgrs->offerbcode;
      $pgr_offbreg = $pgrs->offerbregular;
      $pgr_offrvwlnktitle = $pgrs->offerlnktitle;
      $pgr_rsb_name = $pgrs->name;
      $pgr_rsb_establish = $pgrs->establish;
      $pgr_rsb_country = $pgrs->country;
      $pgr_rsb_auditor = $pgrs->auditor;
      $pgr_rsb_network = $pgrs->network;
      $pgr_rsb_size = $pgrs->size;
      $pgr_rsb_email = $pgrs->email;
      $pgr_rsb_tel = $pgrs->tel;
      $pgr_rsb_payvisa = $pgrs->payvisa;
      $pgr_rsb_paymaster = $pgrs->paymaster;
      $pgr_rsb_payukash = $pgrs->payukash;
      $pgr_rsb_payclickbuy = $pgrs->payclickbuy;
      $pgr_rsb_payneteller = $pgrs->payneteller;
      $pgr_rsb_paybookers = $pgrs->paybookers;
      $pgr_rsb_payclickpay = $pgrs->payclickpay;
      $pgr_rsb_payentro = $pgrs->payentro;
      #$pgr_rsb_payecash = $pgrs->payecash;
      $pgr_rsb_paydebit = $pgrs->paydebit;
      $pgr_rsb_paycheques = $pgrs->paycheques;
      $pgr_rsb_paywire = $pgrs->paywire;
      $pgr_rsb_paydinres = $pgrs->paydinres;
      $pgr_rsb_paywu = $pgrs->paywu;
      $pgr_rsb_paypal = $pgrs->paypal;
      #$pgr_rsb_paytransfers = $pgrs->paytransfers;
	  
	  $pgr_featured = $pgrs->featured;
	  $pgr_shdescr = $pgrs->shdescr;
    }
    $pgr_fullhtml = $pgrs->fullhtml;

    $overrides = array('test_form' => false);
    $file = wp_handle_upload($_FILES['pgr_logo'], $overrides);
    $flogo_url = $file['url'];
    $flogo_type = $file['type'];
    $flogo_file = $file['file'];
    $flogo_filename = basename($flogo_file);

    $rfile = wp_handle_upload($_FILES['pgr_img'], $overrides);
    $fr_url = $rfile['url'];
    $fr_type = $rfile['type'];
    $fr_file = $rfile['file'];
    $fr_filename = basename($fr_file);

    if ($flogo_url) $logo_url = $flogo_url;
    else $logo_url = $pgrs->urllogo;
    if ($fr_url) $pgr_img = $fr_url;
    else $pgr_img = $pgrs->urlimg;
    ?>

    <form name="mainform" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo plugin_basename(__FILE__); ?>">
      <input type="hidden" name="doaction" id="doaction">
      <input type="hidden" name="mbox_id" id="mbox_id">
      <input type="hidden" name="logo_url" value="<?php echo $logo_url ?>" />
      <input type="hidden" name="pgr_img" value="<?php echo $pgr_img ?>" />
      <input type="hidden" name="pgr_id" value="<?php echo $pgr_id ?>" />
      <div class="wrap">
        <div id="icon-wp-pgr" class="icon32"><br /></div>
        <h2><?php _e('Edit Review', 'pg-review'); ?></h2>
        <table width="100%" class="form-table">
        <tr>
        <td width="100%" valign="top">
          <!-- Main Info -->

		<table class="form-table">
          <h3><?php _e('MAIN INFO', 'pg-review'); ?></h3>
           <tr>
            <th width="20%" scope="row" valign="top">Featured</th>
            <td width="80%"><input type="checkbox" size="50" name="pgr_featured" value="1"<?php if ($pgr_featured==1) echo "checked=\"\"";?> /></td>
          </tr>
		  <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Logo image', 'pg-review') ?></th>
            <td width="80%">
            <?php
              if (!$logo_url)
              {
                ?>
                <input type="button" value="<?php _e('Upload Logo Image', 'pg-review'); ?>" onclick="document.mainform.doaction.value='<?php _e('Upload Logo Image', 'pg-review'); ?>'; document.mainform.submit();">
                <?php
              }
              else
              {
                ?>
                <img src="<?php echo $logo_url ?>" title="Logo" alt="logo"/>
                &nbsp;&nbsp;&nbsp;
                <input type="button" value="<?php _e('Change Logo Image', 'pg-review'); ?>" onclick="document.mainform.doaction.value='<?php _e('Change Logo Image', 'pg-review'); ?>'; document.mainform.submit();">
                <?php
              }
            ?>
            </td>
          </tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Title', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="50" name="pgr_title" value="<?php echo $pgr_title;?>" /></td>
          </tr>
		  <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Short description', 'pg-review') ?></th>
            <td width="80%"><textarea style="width:100%;height:60px" name="pgr_shdescr"><?php echo $pgr_shdescr;?></textarea></td>
		  </tr>
		  <tr>
            <td colspan="2">
              
			   
			   <div id="poststuff">
                <div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" class="postarea">
                  <div class="postbox">
                    <h3 class="hndle"><span><?php _e('Full Description') ?></span></h3>
                    <div class="inside">
                      <?php the_editor_wtz(stripslashes($pgr_fullhtml),'fullhtml_pgr','fullhtml_pgr'); ?>
                    </div>
                  </div>
                </div>
              </div>
			  
            </td>
          </tr>
          <tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Page Parent', 'pg-review'); ?></th>
            <td width="80%">
              <select name="parent_id">
                <option value="0"><?php _e ('Main page (No parent)', 'pg-review'); ?></option>
                <?php
                  parent_dropdown ($parent_id);
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Type', 'pg-review') ?></th>
            <td width="80%">
              <select name="pgr_type">
                <option disabled selected value="">Please select type from dropdown list</option>
                <option value="Casino" <?php if($pgr_type=='Casino') echo"selected" ?> >Casino</option>
                <option value="Poker" <?php if($pgr_type=='Poker') echo"selected" ?> >Poker</option>
                <option value="Sports" <?php if($pgr_type=='Sports') echo"selected" ?> >Sports</option>
                <option value="Ohter" <?php if($pgr_type=='Other') echo"selected" ?> >Other</option>
              </select>
            </td>
          </tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Score', 'pg-review') ?></th>
            <td width="80%">
              <select name="pgr_score">
                <option disabled selected value="">Please select score from dropdown list</option>
                <?php
                  $i = 0;
                  $iscore[$i] = 1;
                  echo "<option value=\"$iscore[$i]\">$iscore[$i]</option>\n";
                  while ($iscore[$i] < 10)
                  {
                    $i ++;
                    $iscore[$i] = $iscore[$i-1] + 0.5;
                    if($pgr_score=="$iscore[$i]") $txtselected = "selected";
                    else $txtselected = "";
                    echo "<option value=\"$iscore[$i]\" $txtselected>$iscore[$i]</option>\n";
                  }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Review URL', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="50" name="pgr_rurl" value="<?php echo $pgr_rurl;?>" /></td>
          </tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Download URL', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="50" name="pgr_durl" value="<?php echo $pgr_durl;?>" /></td>
          </tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Player', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="50" name="pgr_player" value="<?php echo $pgr_player;?>" /></td>
          </tr>
        </table>
	

        <!-- Summary Info -->
	
        <h3><?php _e('SUMMARY INFO', 'pg-review'); ?></h3>
        <table class="form-table">
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Review image', 'pg-review') ?></th>
            <td width="80%">
            <?php
              if (!$pgr_img)
              {
                ?>
                <input type="button" value="<?php _e('Upload Review Image', 'pg-review'); ?>" onclick="document.mainform.doaction.value='<?php _e('Upload Review Image', 'pg-review'); ?>'; document.mainform.submit();">
                <?php
              }
              else
              {
                ?>
                <img src="<?php echo $pgr_img ?>" title="Review Image" alt="Review Image"/>
                &nbsp;&nbsp;&nbsp;
                <input type="button" value="<?php _e('Change Review Image', 'pg-review'); ?>" onclick="document.mainform.doaction.value='<?php _e('Change Review Image', 'pg-review'); ?>'; document.mainform.submit();">
                <?php
              }
            ?>
            </td>
          </tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Subtitle', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="50" name="pgr_subtitle" value="<?php echo $pgr_subtitle;?>" /></td>
          </tr>

          <tr>
            <td colspan="2">
              <div id="poststuff">
                <div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" class="postarea">
                  <div class="postbox">
                    <h3 class="hndle"><span><?php _e('Description', 'pg-review') ?></span></h3>
                    <div class="inside">
                      <?php the_editor_wtz(stripslashes($pgr_descr),'descr_pgr','descr_pgr'); ?>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
		  
            <th width="20%" scope="row" valign="top"><?php _e('Operating system', 'pg-review') ?></th>
            <td width="80%">
              <input type="checkbox" name="pgr_os_pc" value="1" <?php if($pgr_os_pc) echo"checked";?> /> - pc<br/>
              <input type="checkbox" name="pgr_os_mac" value="1"  <?php if($pgr_os_mac) echo"checked";?> /> - mac<br/>
            </td>
          </tr>
        </table>

        <!-- Offer Info -->

        <h3><?php _e('OFFER INFO', 'pg-review'); ?></h3>
        <table class="form-table">
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Offer title', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="50" name="pgr_offtitle" value="<?php echo $pgr_offtitle;?>" /></td>
          </tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Offer value from', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="50" name="pgr_offvaluef" value="<?php echo $pgr_offvaluef;?>" /></td>
          </tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Offer value to', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="50" name="pgr_offvaluet" value="<?php echo $pgr_offvaluet;?>" /></td>
          </tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Bonus code', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="50" name="pgr_offbcode" value="<?php echo $pgr_offbcode;?>" /></td>
          </tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Regular bonus', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="50" name="pgr_offbreg" value="<?php echo $pgr_offbreg;?>" /></td>
          </tr>
         <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Review link title', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="50" name="pgr_offrvwlnktitle" value="<?php echo $pgr_offrvwlnktitle;?>" /></td>
          </tr>
          
        </table>

        </td>
	</tr>
	<tr>
        <td width="100%" valign="top">

        <!-- Right Side Boxes -->

        <h3><?php _e('INFO BOX', 'pg-review'); ?></h3>
<table class="form-table" width="100%">
    <tr>
		<td width="50%">		  
        <table class="form-table">
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Name', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="20" name="pgr_rsb_name" value="<?php echo $pgr_rsb_name;?>" /></td>
          </tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Established', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="20" name="pgr_rsb_establish" value="<?php echo $pgr_rsb_establish;?>" /></td>
          </tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Country', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="20" name="pgr_rsb_country" value="<?php echo $pgr_rsb_country;?>" /></td>
          </tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Auditor', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="20" name="pgr_rsb_auditor" value="<?php echo $pgr_rsb_auditor;?>" /></td>
          </tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Network', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="20" name="pgr_rsb_network" value="<?php echo $pgr_rsb_network;?>" /></td>
          </tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Size', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="20" name="pgr_rsb_size" value="<?php echo $pgr_rsb_size;?>" /></td>
          </tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('email', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="20" name="pgr_rsb_email" value="<?php echo $pgr_rsb_email;?>" /></td>
          </tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Telephone', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="20" name="pgr_rsb_tel" value="<?php echo $pgr_rsb_tel;?>" /></td>
          </tr>
        </table>
		</td>
		<td width="50%">
		<table class="form-table">
		<tr>
            <th width="20%" scope="row" valign="top"><?php _e('Payment options', 'pg-review') ?></th>
            <td width="80%">
              <input type="checkbox" name="pgr_rsb_payvisa" value="1" <?php if($pgr_rsb_payvisa) echo"checked";?> /> - Visa<br/>
              <input type="checkbox" name="pgr_rsb_paymaster" value="1"  <?php if($pgr_rsb_paymaster) echo"checked";?> /> - Mastercard<br/>
              <input type="checkbox" name="pgr_rsb_payukash" value="1"  <?php if($pgr_rsb_payukash) echo"checked";?> /> - Ukash<br/>
              <input type="checkbox" name="pgr_rsb_payclickbuy" value="1"  <?php if($pgr_rsb_payclickbuy) echo"checked";?> /> - ClickandBuy<br/>
              <input type="checkbox" name="pgr_rsb_payneteller" value="1"  <?php if($pgr_rsb_payneteller) echo"checked";?> /> - Neteller<br/>
              <input type="checkbox" name="pgr_rsb_paybookers" value="1"  <?php if($pgr_rsb_paybookers) echo"checked";?> /> - Moneybookers<br/>
              <input type="checkbox" name="pgr_rsb_payclickpay" value="1"  <?php if($pgr_rsb_payclickpay) echo"checked";?> /> - ClickandPay<br/>
              <input type="checkbox" name="pgr_rsb_payentro" value="1"  <?php if($pgr_rsb_payentro) echo"checked";?> /> - Entropay<br/>
              <!--<input style="display:none" type="checkbox" name="pgr_rsb_payecash" value="1"  <?php #if($pgr_rsb_payecash) echo"checked";?> /> - ECash<br/>-->
              <input type="checkbox" name="pgr_rsb_paydebit" value="1"  <?php if($pgr_rsb_paydebit) echo"checked";?> /> - Debit Card<br/>
              <input type="checkbox" name="pgr_rsb_paycheques" value="1"  <?php if($pgr_rsb_paycheques) echo"checked";?> /> - Cheques<br/>
              <input type="checkbox" name="pgr_rsb_paywire" value="1"  <?php if($pgr_rsb_paywire) echo"checked";?> /> - Wire Transfers<br/>
              <input type="checkbox" name="pgr_rsb_paydiners" value="1"  <?php if($pgr_rsb_paydiners) echo"checked";?> /> - Diners Club<br/>
              <input type="checkbox" name="pgr_rsb_paywu" value="1"  <?php if($pgr_rsb_paywu) echo"checked";?> /> - Western Union<br/>
              <input type="checkbox" name="pgr_rsb_paypal" value="1"  <?php if($pgr_rsb_paypal) echo"checked";?> /> - PayPal<br/>
              <!--<input type="checkbox" name="pgr_rsb_paytransfers" value="1"  <?php if($pgr_rsb_paytransfers) echo"checked";?> /> - Transfers<br/>-->
            </td>
          </tr>
		</table>
		</td>
	</tr>
</table>
		
    <p style="text-align: center;">
          <input type="button" value="<?php _e('Update Review', 'pg-review'); ?>" onclick="document.mainform.doaction.value='<?php _e('Update Review', 'pg-review'); ?>'; document.mainform.submit();">
        </p>
        <!-- Multiplay Boxes -->
		
        <h3><?php _e('MULTIPLE BOXES', 'pg-review'); ?></h3>
        <table class="widefat">
         <thead>
			<tr>
            <th width="20%" scope="row" valign="top"><b>Title</b></th>
            <th width="80%"><b>Actions</b></th>
          </tr>
		  </thead>
		  <tbody>
		  <?php

          $pgrmbox = $wpdb->get_results("SELECT * FROM $pgrvw_mbox WHERE pid = '$pgr_id' ORDER BY id ASC");
          // show mboxes
          if ($pgrmbox)
          {
            foreach($pgrmbox as $pgrmbox_data)
            {
              $data_mid = $pgrmbox_data->id;
              $data_mtitle = $pgrmbox_data->title;
              $data_mrating = $pgrmbox_data->rating;
              $data_mdescr = $pgrmbox_data->descr;
              ?>     
		  <tr>
            <td valign="top"><?php echo "$data_mtitle"; ?></td>
<!--                     
					 <tr>
                        <th width="20%" scope="row" valign="top"><b>Rating</b></th>
                        <td width="80%"><?php echo $data_mrating; ?></td>
                      </tr>
                      <tr>
                        <th width="20%" scope="row" valign="top"><b>Description</b></th>
                        <td width="80%"><?php echo $data_mdescr; ?></td>
                      </tr>
                      <tr>
-->					  
            <td>
        <input type="button" value="<?php _e('Edit', 'pg-review'); ?>" onclick="document.mainform.doaction.value='doedit_mbox'; document.mainform.mbox_id.value='<?php echo $data_mid; ?>'; document.mainform.submit();">
		<input type="button" value="<?php _e('Delete', 'pg-review'); ?>" onclick="document.mainform.doaction.value='dodel_mbox'; document.mainform.mbox_id.value='<?php echo $data_mid; ?>'; document.mainform.submit();">
            </td>

              </tr>
              <?php
            }
          }

          ?>
		  </tbody>
		  </table>
		  <table class="form-table">
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Title', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="20" name="pgr_mtitle" value="<?php echo $pgr_mtitle;?>" /></td>
          </tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Rating', 'pg-review') ?></th>
            <td width="80%">

              <select name="pgr_mrating">
                <option disabled selected value="">Please rating from dropdown list</option>
                <?php
                  $i = 0;
                  $imrating[$i] = 1;
                  echo "<option value=\"$imrating[$i]\">$imrating[$i]</option>\n";
                  while ($imrating[$i] < 10)
                  {
                    $i ++;
                    $imrating[$i] = $imrating[$i-1] + 0.5;
                    if($pgr_mrating=="$imrating[$i]") $txtselected = "selected";
                    else $txtselected = "";
                    echo "<option value=\"$imrating[$i]\" $txtselected>$imrating[$i]</option>\n";
                  }
                ?>
              </select>

            </td>
          </tr>

          <tr>
            <td colspan="2">

              <div id="poststuff" >
                <div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" class="postarea">
                  <div class="postbox">
                    <h3 class="hndle"><span><?php _e('Description', 'pg-review') ?></span></h3>
                    <div class="inside">
                      <?php the_editor_wtz(stripslashes($pgr_mdescr),'pgr_mdescr','pgr_mdescr'); ?>
                    </div>
                  </div>
                </div>
              </div>

            </td>
          </tr>

          <tr>
            <td colspan="2">
              <input type="button" value="<?php _e('Add MultiBox', 'pg-review'); ?>" onclick="document.mainform.doaction.value='<?php _e('Add MultiBox', 'pg-review'); ?>'; document.mainform.submit();">
            </td>
          </tr>
        </table>

        </td>
        </tr>
        </table>

        </p>
      </div>
    </form>

    <?php
  break;

  case del_id:
  ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo plugin_basename(__FILE__); ?>" enctype="multipart/form-data">
    <input type="hidden" name="doaction" value="" />
    <div class="wrap">
      <div id="icon-pg-review" class="icon32"><br /></div>
      <h2><?php _e('Delete PG Review', 'pg-review'); ?></h2>
      <br style="clear" />
      <table class="widefat">
        <tr>
          <td>
  <?php
          $pgr_padeid = $wpdb->get_var("SELECT padeid FROM $pgrvw WHERE id = $pgr_id");
          // delete post
          wp_delete_post($pgr_padeid);

          $pgr_title = $wpdb->get_var("SELECT title FROM $pgrvw WHERE id = $pgr_id");
          $delete_log = $wpdb->query("DELETE FROM $pgrvw WHERE id = '$pgr_id'");
          if($delete_log)
          {
            $delete_log = $wpdb->query("DELETE FROM $pgrvw_mbox WHERE pid = '$pgr_id'");
            echo '<p style="color: green;">'.sprintf(__('All Logs For \'%s\' Has Been Deleted', 'pg-review'), stripslashes($pgr_title)).'</p>';
          }
          else
          {
            echo '<p style="color: red;">'.sprintf(__('An Error Has Occured While Deleting \'%s\'.', 'pg-review'), stripslashes($pgr_title)).'</p>';
          }
  ?>
          </td>
        </tr>
        <tr>
          <td align="center"><input type="submit" name="doaction" value="<?php _e('Back to Manage Review', 'pg-review'); ?>"  class="button" /></td>
        </tr>
      </table>
    </div>
    </form>
  <?php
  break;

  // Main Page
  default:
  ?>
    <!-- Last Action -->
    <div id="message" class="updated" style="display: none;"></div>

    <!-- Manage Review -->
    <div class="wrap">
      <div id="icon-pg-review" class="icon32"><br /></div>
      <h2><?php _e('Manage PG Review', 'pg-review'); ?></h2>
      <h3><?php _e('Review', 'pg-review'); ?></h3>
      <br style="clear" />
      <table class="widefat">
        <thead>
          <tr>
            <th><?php _e('ID', 'pg-review'); ?></th>
            <th><?php _e('Title', 'pg-review'); ?></th>
            <th><?php _e('Type', 'pg-review'); ?></th>
            <th><?php _e('Player', 'pg-review'); ?></th>
            <th><?php _e('Subtitle', 'pg-review'); ?></th>
            <th><?php _e('Description', 'pg-review'); ?></th>
            <th><?php _e('Name', 'pg-review'); ?></th>
            <th><?php _e('Country', 'pg-review'); ?></th>
            <th><?php _e('Network', 'pg-review'); ?></th>
            <th colspan="2"><?php _e('Action', 'pg-review'); ?></th>
          </tr>
        </thead>
        <tbody id="manage_pgr">
          <?php
            $pgrs = $wpdb->get_results("SELECT * FROM $pgrvw");
            $cnt = count($pgrs);
            if($pgrs)
            {
              $i = 0;
              foreach($pgrs as $pgrdata)
              {
                if($i%2 == 0) $style = 'class="alternate"'; else  $style = '';
                $pgr_id = intval($pgrdata->id);
                $pgr_title = $pgrdata->title;
                $pgr_type = $pgrdata->review_type;
                $pgr_player = $pgrdata->player;
                $pgr_subtitle = $pgrdata->subtitle;
                $pgr_descr = $pgrdata->descr;
                $pgr_name = $pgrdata->name;
                $pgr_country = $pgrdata->country;
                $pgr_network = $pgrdata->network;

                echo "<tr id=\"pgr-$pgr_id\" $style>\n";
                echo '<td><strong>'.number_format_i18n($pgr_id).'</strong></td>'."\n";
                echo '<td><strong>'.$pgr_title.'</strong></td> ';
                echo '<td>'.$pgr_type.'</td> ';
                echo '<td>'.$pgr_player.'</td> ';
                echo '<td>'.$pgr_subtitle.'</td> ';
                echo '<td>'.$pgr_descr.'</td> ';
                echo '<td>'.$pgr_name.'</td> ';
                echo '<td>'.$pgr_country.'</td> ';
                echo '<td>'.$pgr_network.'</td> ';

                echo "<td><a href=\"$base_page&amp;doaction=Ledit&amp;pgr_id=$pgr_id\">".__('Edit', 'pg-review')."</a></td>\n";
                echo "<td><a href=\"$base_page&amp;doaction=del_id&amp;pgr_id=$pgr_id\">".__('Delete', 'pg-review')."</a></td>\n";
                echo '</tr>';
                $i++;
              }
            }
            else
            {
              echo '<tr><td colspan="11" align="center"><strong>'.__('No PG Review Found', 'pg-review').'</strong></td></tr>';
            }
          ?>
        </tbody>
      </table>
    </div>
    <p>&nbsp;</p>
    <?php
  break;
}
