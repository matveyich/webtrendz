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
$pgract = isset($_REQUEST['do']) ? $_REQUEST['do'] : '';
//==Decide What To Do==
switch($pgract)
{
  // Save info for main, summary, offer
  // Ask info Right side boxes
  case __('Add Review RIGHT SIDE BOX', 'pg-review'):
  case __('Add Review', 'pg-review'):

//echo"parent_id=$parent_id<br/>";
echo"full=$pgr_fullhtml<br/>";
echo"descr=$pgr_descr<br/>";

    $pgr_ids = $wpdb->get_results("SELECT id FROM $pgrvw");
    $cntr_pgr = count($pgr_ids);
    // Create a WP page
    global $user_ID;
    // Add a new page
    include_once('pgr-template.php');
    $page['post_type'] = 'page';
    $page['post_content'] = $contentofpage;
    $page['post_parent'] = $parent_id;
    $page['post_author'] = $user_ID;
    $page['post_status'] = 'publish';
    $page['post_title'] = $pgr_title;
    $pgr_pageid = wp_insert_post ($page);
	add_post_meta($pgr_pageid, '_wp_page_template', 'review_page.php');
    $result = $wpdb->query("INSERT INTO $pgrvw (urllogo,title,parent_id,review_type,score,urlreview,urldownload,player,fullhtml,subtitle,descr,urlimg,ospc,osmac,offertitle,offervaluef,offervaluet,offerbcode,offerbregular,offerlnktitle,name,establish,country,auditor,network,size,email,tel,payvisa,paymaster,payukash,payclickbuy,payneteller,paybookers,payclickpay,payentro,paydebit,paycheques,paywire,paydiners,paywu,paypal,padeid,featured,shdescr) VALUES ('$logo_url','$pgr_title','$parent_id','$pgr_type','$pgr_score','$pgr_rurl','$pgr_durl','$pgr_player','$pgr_fullhtml','$pgr_subtitle','$pgr_descr','$pgr_img','$pgr_os_pc','$pgr_os_mac','$pgr_offtitle','$pgr_offvaluef','$pgr_offvaluet','$pgr_offbcode','$pgr_offbreg','$pgr_offrvwlnktitle','$pgr_rsb_name','$pgr_rsb_establish','$pgr_rsb_country','$pgr_rsb_auditor','$pgr_rsb_network','$pgr_rsb_size','$pgr_rsb_email','$pgr_rsb_tel','$pgr_rsb_payvisa','$pgr_rsb_paymaster','$pgr_rsb_payukash','$pgr_rsb_payclickbuy','$pgr_rsb_payneteller','$pgr_rsb_paybookers','$pgr_rsb_payclickpay','$pgr_rsb_payentro','$pgr_rsb_paydebit','$pgr_rsb_paycheques','$pgr_rsb_paywire','$pgr_rsb_paydiners','$pgr_rsb_paywu','$pgr_rsb_paypal','$pgr_pageid','$pgr_featured','$pgr_shdescr')");
echo mysql_error();
    ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo plugin_basename(__FILE__); ?>" enctype="multipart/form-data">
    <div class="wrap">
      <div id="icon-wp-pgr" class="icon32"><br /></div>
      <h2><?php _e('Add New Review', 'pg-review'); ?></h2>
        <table class="form-table">
          <tr>
          <?php
          if ($result)
          {
          ?>
          <td width="80%">Page Review added</td>
          <?php
          }
          else
          {
          ?>
          <td width="80%">Page Review NOT Added.<br/> Error: Record not stored in database.</td>
          <?php
          }
          ?>
          </tr>
          <tr>
            <td width="80%"><input type="submit" name="do" value="<?php _e('Add Next Review', 'pg-review'); ?>"  class="button" />&nbsp;&nbsp;<input type="button" name="cancel" value="<?php _e('Back', 'pg-review'); ?>" class="button" onclick="javascript:history.go(-1)" /></td>
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
          <td width="80%"><input type="submit" name="do" value="<?php _e('Upload', 'pg-review'); ?>"  class="button" />&nbsp;&nbsp;<input type="button" name="cancel" value="<?php _e('Back', 'pg-review'); ?>" class="button" onclick="javascript:history.go(-1)" /></td>
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
          <td width="80%"><input type="submit" name="do" value="<?php _e('Upload Image', 'pg-review'); ?>"  class="button" />&nbsp;&nbsp;<input type="button" name="cancel" value="<?php _e('Back', 'pg-review'); ?>" class="button" onclick="javascript:history.go(-1)" /></td>
        </tr>
      </table>
    </div>
    </form>
    <?php
  break;

  // Main Page
  default:
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
    if ($fr_url) $pgr_img = $fr_url;

    ?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo plugin_basename(__FILE__); ?>">
      <input type="hidden" name="logo_url" value="<?php echo $logo_url ?>" />
      <input type="hidden" name="pgr_img" value="<?php echo $pgr_img ?>" />
      <div class="wrap">
        <div id="icon-wp-pgr" class="icon32"><br /></div>
        <h2><?php _e('Add New Review', 'pg-review'); ?></h2>
        <table class="form-table">
        <tr>
        <td width="100%">

        <table class="form-table">
          <!-- Main Info -->
          <h3><?php _e('MAIN INFO', 'pg-review'); ?></h3>
          <tr>
            <th width="20%" scope="row" valign="top">Featured</th>
            <td width="80%"><input type="checkbox" size="50" name="pgr_featured" value="1" /></td>
          </tr>
		  <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Logo image', 'pg-review') ?></th>
            <td width="80%">
            <?php
              if (!$logo_url)
              {
                ?>
                  <input type="submit" name="do" value="<?php _e('Upload Logo Image', 'pg-review'); ?>">
                <?php
              }
              else
              {
            ?>
              <img src="<?php echo $logo_url ?>" title="Logo" alt="logo"/>
              &nbsp;&nbsp;&nbsp;<input type="submit" name="do" value="<?php _e('Change Logo Image', 'pg-review'); ?>">
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
            <td width="80%"><textarea style="width:100%;height:60px" name="pgr_shdescr"><? echo $pgr_shdescr;?></textarea></td>
          </tr>
		  <!-- Full Page -->
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
            <th width="20%" scope="row" valign="top"><?php _e('Page Parent', 'pg-review') ?></th>
            <td width="80%">
              <select name="parent_id">
                <option value="0"><?php _e ('Main page (No parent)', 'pg-review'); ?></option>
                <?php parent_dropdown (); ?>
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
                  <input type="submit" name="do" value="<?php _e('Upload Review Image', 'pg-review'); ?>">
                <?php
              }
              else
              {
            ?>
              <img src="<?php echo $pgr_img ?>" title="Review Image" alt="Review Image"/>
              &nbsp;&nbsp;&nbsp;<input type="submit" name="do" value="<?php _e('Change Review Image', 'pg-review'); ?>">
            <?php
              }
            ?>
            </td>
          </tr>
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Subtitle', 'pg-review') ?></th>
            <td width="80%"><input type="text" size="50" name="pgr_subtitle" value="<?php echo $pgr_subtitle;?>" /></td>
          </tr>
<?php
/*
          <tr>
            <th width="20%" scope="row" valign="top"><?php _e('Description', 'pg-review') ?></th>
            <td width="80%"><textarea name="pgr_descr" cols="40" rows="8"><?php echo $pgr_descr;?></textarea></td>
          </tr>
*/
?>
          <tr>
            <td colspan="2">
              <div id="poststuff">
                <div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" class="postarea">
                  <div class="postbox">
                    <h3 class="hndle"><span><?php _e('Description') ?></span></h3>
                    <div class="inside">
                      <?php the_editor_wtz(stripslashes($pgr_descr),'descr_pgr','descr_pgr'); ?>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
		  
          <tr>
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
              <!--<input type="checkbox" name="pgr_rsb_paytransfers" value="1"  <?php #if($pgr_rsb_paytransfers) echo"checked";?> /> - Transfers<br/>-->
            </td>
          </tr>
        </table>
		</td>
	</tr>
</table>

        </td>
        </tr>
        </table>

        <p style="text-align: center;"><input type="submit" name="do" value="<?php _e('Add Review', 'pg-review'); ?>" class="button" /></p>
      </div>
    </form>
    <?php
  break;

}
