<?php
/*
Uses:
\wp-content\themes\thevipgambler\css\base_126.css
and images from this folder.
*/
$contentofpage = "";

$contentofpage .= "<div id=\"main-wrap\">";
$contentofpage .= "  <div id=\"content\">";
$contentofpage .= "    <div id=\"review-page\" class=\"wrapper\">";

$contentofpage .= "      <div class=\"line\">";
$contentofpage .= "        <div class=\"unit size1of1 lastUnit\">";
$contentofpage .= "          <div id=\"review-head\" class=\"mod mod-review-head\">";
$contentofpage .= "            <div class=\"inner\">";
$contentofpage .= "              <div class=\"bd\">";
$contentofpage .= "                <div class=\"unit size3of5\">";
$contentofpage .= "                  <div  class=\"mod frame unit media\">";
$contentofpage .= "                    <div class=\"inner\">";
$contentofpage .= "                      <div class=\"t\">";
$contentofpage .= "                        <div class=\"tl\"></div>";
$contentofpage .= "                        <div class=\"tr\"></div>";
$contentofpage .= "                      </div>";
// Here $pgr_pageid-number of the page of review
//$logo_url- url of the logo image
//$pgr_title - Title of the Review
$contentofpage .= "                      <div class=\"bd\"><a href=\"$pgr_rurl\" target=\"_blank\"><img src=\"$logo_url\" alt=\"$pgr_title\" /></a></div>";
$contentofpage .= "                      <div class=\"bg\"></div>";
$contentofpage .= "                      <div class=\"b\">";
$contentofpage .= "                        <div class=\"bl\"></div>";
$contentofpage .= "                        <div class=\"br\"></div>";
$contentofpage .= "                      </div>";
$contentofpage .= "                    </div>";
$contentofpage .= "                  </div>";
$contentofpage .= "                  <div class=\"review-head-heading\">";
$contentofpage .= "                    <div class=\"line\">";
//$pgr_title - Title of the Review
$contentofpage .= "                      <h1>$pgr_title</h1>";
$contentofpage .= "                      <div class=\"landing-pages\">";
//$pgr_rurl - Review URL
//$pgr_durl - Download URL
$contentofpage .= "                        <a href=\"$pgr_rurl\" target=\"_blank\"><strong>Visit Now</strong></a> &nbsp; | &nbsp; <a href=\"$pgr_durl\"><strong>Download Now</strong></a>";
$contentofpage .= "                      </div>";
$contentofpage .= "                      <div class=\"landing-pages\">";
//$pgr_player - Players
$contentofpage .= "                        Players: $pgr_player";
$contentofpage .= "                      </div>";
$contentofpage .= "                    </div>";
$contentofpage .= "                    <div class=\"line\">";
$contentofpage .= "                      <span class=\"rating rating-review\">";
$contentofpage .= "                        <span class=\"label\">Score</span>";
$contentofpage .= "                        <span class=\"meter-container\">";
$contentofpage .= "                          <span class=\"meter\" style=\"width:".($pgr_score*10)."%\"></span>";
$contentofpage .= "                        </span>";
//$pgr_score - Score
$contentofpage .= "                        <span class=\"numbers\">$pgr_score/10</span></span>";
$contentofpage .= "                      </div>";
$contentofpage .= "                    </div>";
$contentofpage .= "                  </div>";
$contentofpage .= "                </div>";
$contentofpage .= "                <div class=\"bg\"></div>";
$contentofpage .= "              </div>";
$contentofpage .= "            </div>";
$contentofpage .= "          </div>";
$contentofpage .= "        </div>";
//!!!END!!!class="line"
$contentofpage .= "      </div>";



$contentofpage .= "      <div class=\"line\">";
$contentofpage .= "        <div  class=\"mod mod-review-bd\">";
$contentofpage .= "          <div class=\"inner\">";
$contentofpage .= "            <div class=\"bd\">";
$contentofpage .= "              <div class=\"unit size4of6\">";
$contentofpage .= "                <div id=\"review-exclusive-hits\" class=\"line\">";
// $pgr_subtitle - Subtitle of the Review
$contentofpage .= "                  <h3>Why Play at $pgr_subtitle?</h3>";
$contentofpage .= "                    <ul class=\"list-attribute-alt list-attribute-alt-pro\">";
// $pgr_descr - Description of the Review
//$contentofpage .= "                      <li>";
foreach(explode("\n",$pgr_descr) as $line) {
$contentofpage .= "<li>".$line."</li>";
}
//$contentofpage .= "                      </li>";
$contentofpage .= "                    </ul>";
$contentofpage .= "                  </div>";
$contentofpage .= "                  <div class=\"line\">";
$contentofpage .= "                    <div  class=\"mod mod-article mod-review-head-internal\">";
$contentofpage .= "                      <div class=\"inner\">";
$contentofpage .= "                        <div class=\"t\">";
$contentofpage .= "                          <div class=\"tl\"></div>";
$contentofpage .= "                          <div class=\"tr\"></div>";
$contentofpage .= "                        </div>";
$contentofpage .= "                        <div class=\"hd\">";
// $pgr_offtitle - Offer title
$contentofpage .= "                          <h4>$pgr_offtitle</h4>";
$contentofpage .= "                        </div>";
$contentofpage .= "                        <div class=\"bd\">";
$contentofpage .= "                        <div class=\"inside\">";

$contentofpage .= "                          <div id=\"review-exclusive\">";
// $pgr_offvalue - Offer value

$contentofpage .= "                          <div class=\"percent\">$pgr_offvaluef</div>";
$contentofpage .= "                          <div class=\"sep\">Up<br>To</div>";
$contentofpage .= "                          <div class=\"amount\">$pgr_offvaluet</div>";
$contentofpage .= "                        </div>";
$contentofpage .= "                        <div id=\"review-exclusive-label\">";
$contentofpage .= "                          <div class=\"line\">";
$contentofpage .= "                            <div class=\"unit size1of2\">";
// $pgr_offbcode - Offer bonus code
$contentofpage .= "                              <div class=\"label\">Bonus Code: <span class=\"bonus_code\">$pgr_offbcode</span></div>";
$contentofpage .= "                            </div>";
$contentofpage .= "                            <div class=\"unit size1of2 last-unit\">";
// $pgr_offbreg - Offer regular bonus
$contentofpage .= "                              <div class=\"label label-last\">Regular Bonus: <span>$pgr_offbreg</span></div>";
$contentofpage .= "                            </div>";
$contentofpage .= "                          </div>";
$contentofpage .= "                        </div>";
$contentofpage .= "                        <div id=\"review-exclusive-label\">";
$contentofpage .= "                          <div class=\"line1\">";
$contentofpage .= "                   <strong><a href=\"$pgr_rurl\" target=\"_blank\">$pgr_offrvwlnktitle</a></strong>";
$contentofpage .= "                          </div>";
$contentofpage .= "                        </div>";
$contentofpage .= "                        </div>";

$contentofpage .= "                      </div>";
$contentofpage .= "                      <div class=\"bg\"></div>";
$contentofpage .= "                    </div>";
$contentofpage .= "                  </div>";
$contentofpage .= "                </div>";
$contentofpage .= "              </div>";

$contentofpage .= "              <div class=\"unit size2of6 lastUnit\">";
$contentofpage .= "                <div id=\"review-screenshots\" class=\"mod review-head-screenshot\">";
$contentofpage .= "                  <div class=\"inner\">";
$contentofpage .= "                    <div class=\"t\">";
$contentofpage .= "                      <div class=\"tl\"></div>";
$contentofpage .= "                      <div class=\"tr\"></div>";
$contentofpage .= "                    </div>";
$contentofpage .= "                    <div class=\"bd\">";
$contentofpage .= "                      <p>";
$contentofpage .= "                        <span id=\"review-screeshots-holder\">";
// $pgr_img - Review image
$contentofpage .= "                          <a class=\"lightbox\" href=\"$pgr_rurl\" target=\"_blank\"><img src=\"$pgr_img\" alt=\"Table\"/><span class=\"hover-bg\"></span></a>";
$contentofpage .= "                        </span>";
//$pgr_rurl - Review URL
//$pgr_durl - Download URL
$contentofpage .= "                        <a href=\"$pgr_rurl\" target=\"_blank\" class=\"button button-download-alt\"><span>Play Now</span></a><br/>";
$contentofpage .= "                        <a href=\"$pgr_durl\" target=\"_blank\"><strong>Free Download</strong></a>";
$contentofpage .= "                      </p>";
$contentofpage .= "                      <ul class=\"footer section-fullwidth\">";
$contentofpage .= "                        <li><div>*Tested Spyware Free</div></li>";
$contentofpage .= "                        <li>";
$contentofpage .= "                          <div class=\"last\">";
// If $pgr_os_pc not NULL output value PC
if ($pgr_os_pc) $contentofpage .= "<span class=\"icon-comp icon-comp-win\">PC</span>";
// If $pgr_os_mac not NULL output value Mac
if ($pgr_os_mac) $contentofpage .= "<span class=\"icon-comp icon-comp-mac\">Mac</span>";
$contentofpage .= "                          </div>";
$contentofpage .= "                        </li>";
$contentofpage .= "                      </ul>";
$contentofpage .= "                    </div>";
$contentofpage .= "                    <div class=\"bg\"></div>";
$contentofpage .= "                    <div class=\"b\">";
$contentofpage .= "                      <div class=\"bl\"></div>";
$contentofpage .= "                      <div class=\"br\"></div>";
$contentofpage .= "                    </div>";
$contentofpage .= "                  </div>";
$contentofpage .= "                </div>";
$contentofpage .= "              </div>";
$contentofpage .= "            </div>";
$contentofpage .= "            <div class=\"bg\"></div>";
$contentofpage .= "            <div class=\"b\">";
$contentofpage .= "              <div class=\"bl\"></div>";
$contentofpage .= "              <div class=\"br\"></div>";
$contentofpage .= "            </div>";
$contentofpage .= "          </div>";
$contentofpage .= "        </div>";
$contentofpage .= "      </div>";

//!!!Block 2(Full html)::1(Right boxes)
$contentofpage .= "      <div class=\"line\">";
$contentofpage .= "        <div class=\"unit size2of3\">";
$contentofpage .= "          <div id=\"review-full\" class=\"mod mod-article\">";
$contentofpage .= "            <div class=\"inner\">";
$contentofpage .= "              <div class=\"t\">";
$contentofpage .= "                <div class=\"tl\"></div>";
$contentofpage .= "                <div class=\"tr\"></div>";
$contentofpage .= "              </div>";
$contentofpage .= "              <h2 class=\"hd\">Full Review</h2>";
$contentofpage .= "              <div class=\"bd\">";
// output Full Html fron variable $pgr_fullhtml
$contentofpage .= "                <p>".$pgr_fullhtml;

if (isset($pgr_offrvwlnktitle) && $pgr_offrvwlnktitle != "") 
	{
	$visitlnk = $pgr_offrvwlnktitle;
	} elseif (isset($pgr_rurl) && $pgr_rurl != "") 
		{
		$visitlnk = "Visit ".$pgr_subtitle;
		}
$contentofpage .= "                <br><br><a href=\"$pgr_rurl\" target=\"_blank\">$visitlnk</a>";
$contentofpage .= "                </p>";

$contentofpage .= "              </div>";
$contentofpage .= "              <div class=\"bg\"></div>";
$contentofpage .= "              <div class=\"b\">";
$contentofpage .= "                <div class=\"bl\"></div>";
$contentofpage .= "                <div class=\"br\"></div>";
$contentofpage .= "              </div>";
$contentofpage .= "            </div>";
$contentofpage .= "          </div>";
//!!!END!!class=\"unit size2of3
$contentofpage .= "        </div>";


$contentofpage .= "        <div class=\"unit size1of3 lastUnit\">";
$contentofpage .= "          <div class=\"line\">";
$contentofpage .= "            <div id=\"info\" class=\"mod mod-article\">";
$contentofpage .= "              <div class=\"inner\">";
$contentofpage .= "                <div class=\"t\">";
$contentofpage .= "                  <div class=\"tl\"></div>";
$contentofpage .= "                  <div class=\"tr\"></div>";
$contentofpage .= "                </div>";
$contentofpage .= "                <h2 class=\"hd\">Info</h2>";
$contentofpage .= "                <div class=\"bd\">";
$contentofpage .= "                  <div class=\"block\">";
//$pgr_rurl - Review URL
$contentofpage .= "                    <a href=\"$pgr_rurl\"  target=\"_blank\">";
//$logo_url - URL for Logo image
//$pgr_title - Title of Review
$contentofpage .= "                      <img class=\"image-main block-logo\" src=\"$logo_url\" alt=\"$pgr_title\" />";
$contentofpage .= "                    </a>";
$contentofpage .= "                  </div>";
$contentofpage .= "                  <dl class=\"list-property list-property-info\">";
$contentofpage .= "                    <dt>Name</dt>";
//$pgr_rsb_name - Name on right box
$contentofpage .= "                    <dd><a href=\"$pgr_rurl\" target=\"_blank\">$pgr_rsb_name</a></dd>";
$contentofpage .= "                    <dt>Established</dt>";
//$pgr_rsb_establish - Established on right box
$contentofpage .= "                    <dd>$pgr_rsb_establish</dd>";
$contentofpage .= "                    <dt>Country</dt>";
//$pgr_rsb_country - Country on right box
$contentofpage .= "                    <dd>$pgr_rsb_country</dd>";
$contentofpage .= "                    <dt>Auditor</dt>";
//$pgr_rsb_auditor - Auditor on right box
$contentofpage .= "                    <dd>$pgr_rsb_auditor</dd>";
$contentofpage .= "                    <dt>Network</dt>";
//$pgr_rsb_network - Network on right box
$contentofpage .= "                    <dd>$pgr_rsb_network</dd>";
$contentofpage .= "                    <dt>Size</dt>";
//$pgr_rsb_size - Size on right box
$contentofpage .= "                    <dd>$pgr_rsb_size</dd>";
$contentofpage .= "                    <dt>E-Mail</dt>";
//$pgr_rsb_email - e-mail on right box
$contentofpage .= "                    <dd><a href=\"mailto:$pgr_rsb_email\">$pgr_rsb_email</a></dd>";
$contentofpage .= "                    <dt>Telephone</dt>";
//$pgr_rsb_tel - Telephone on right box
$contentofpage .= "                    <dd>$pgr_rsb_tel</dd>";
$contentofpage .= "                    <dt>Payment Options</dt>";
$contentofpage .= "                    <dd>";

$contentofpage .= "                      <ul class=\"payment\">";
// if $pgr_rsb_payvisa not NULL output Visa
if ($pgr_rsb_payvisa)
  $contentofpage .= "                      <li class=\"visa\" title=\"Visa\">Visa</li>";
// if $pgr_rsb_paymaster not NULL output MasterCard
if ($pgr_rsb_paymaster)
  $contentofpage .= "                      <li class=\"mastercard\" title=\"MasterCard\">MasterCard</li>";
if ($pgr_rsb_payukash)
  $contentofpage .= "                      <li class=\"ukash\" title=\"Ukash\">Ukash</li>";
if ($pgr_rsb_payclickbuy)
  $contentofpage .= "                      <li class=\"click-and-buy\" title=\"ClickandBuy\">ClickandBuy</li>";
if ($pgr_rsb_payneteller)
  $contentofpage .= "                      <li class=\"neteller\" title=\"Neteller\">Neteller</li>";
if ($pgr_rsb_paybookers)
  $contentofpage .= "                      <li class=\"money-bookers\" title=\"Moneybookers\">Moneybookers</li>";
if ($pgr_rsb_payclickpay)
  $contentofpage .= "                      <li class=\"click2pay\" title=\"ClickandPay\">ClickandPay</li>";
if ($pgr_rsb_payentro)
  $contentofpage .= "                      <li class=\"entro-pay\" title=\"Entropay\">Entropay</li>";
#if ($pgr_rsb_payecash)
  #$contentofpage .= "                      <li class=\"ecash\">ECash</li>";
if ($pgr_rsb_paydebit)
  $contentofpage .= "                      <li class=\"instadebit\" title=\"Debit Card\">Debit Card</li>";
if ($pgr_rsb_paycheques)
  $contentofpage .= "                      <li class=\"cheques\" title=\"Cheques\">Cheques</li>";
if ($pgr_rsb_paywire)
  $contentofpage .= "                      <li class=\"wire-transfer\" title=\"Wire Transfers\">Wire Transfers</li>";
if ($pgr_rsb_paydiners)
  $contentofpage .= "                      <li class=\"diners\" title=\"Diners Club\">Diners Club</li>";
if ($pgr_rsb_paywu)
  $contentofpage .= "                      <li class=\"wu\" title=\"Western Union\">Western Union</li>";
if ($pgr_rsb_paypal)
  $contentofpage .= "                      <li class=\"paypal\" title=\"Pay Pal\">Pay Pal</li>";
#if ($pgr_rsb_paytransfers)
  #$contentofpage .= "                      <li class=\"transfers\">Transfers</li>";

$contentofpage .= "                      </ul>";
$contentofpage .= "                    </dd>";
$contentofpage .= "                  </dl>";
$contentofpage .= "                </div>";
$contentofpage .= "                <div class=\"bg\"></div>";
$contentofpage .= "                <div class=\"b\">";
$contentofpage .= "                  <div class=\"bl\"></div>";
$contentofpage .= "                  <div class=\"br\"></div>";
$contentofpage .= "                </div>";
$contentofpage .= "              </div>";
$contentofpage .= "            </div>";
$contentofpage .= "          </div>";

// Adding Multiplay boxes
if ($pgract == __('Update Review', 'pg-review'))
{
  $tmp_mbox = $wpdb->get_results("SELECT * FROM $pgrvw_mbox WHERE pid = '$pgr_id'");
  if ($tmp_mbox)
  {
    foreach($tmp_mbox as $pgrmbox_data)
    {
      $data_mid = $pgrmbox_data->id;
      $data_mtitle = $pgrmbox_data->title;
      $data_mrating = $pgrmbox_data->rating;
      $data_mdescr = $pgrmbox_data->descr;

      $contentofpage .= "    <div class=\"line\">";
      $contentofpage .= "      <div id=\"score\" class=\"mod mod-toplist\">";
      $contentofpage .= "        <div class=\"inner\">";
      $contentofpage .= "          <div class=\"t\">";
      $contentofpage .= "            <div class=\"tl\"></div>";
      $contentofpage .= "            <div class=\"tr\"></div>";
      $contentofpage .= "          </div>";
//$data_mtitle - Title for multi boxes
      $contentofpage .= "          <h2 class=\"hd\">$data_mtitle</h2>";
      $contentofpage .= "          <div class=\"bd\">";
      $contentofpage .= "            <div class=\"block\">";
//$data_mrating - Rating for multi boxes
      $contentofpage .= "              <span class=\"rating\"><span class=\"meter-container\"><span class=\"meter\" style=\"width:".($data_mrating*10)."%\"></span></span><span class=\"numbers\">$data_mrating/10</span></span>";
      $contentofpage .= "            </div>";
      $contentofpage .= "            <dl class=\"list-property list-property-score\">";
//$data_mdescr - Description for multi boxes
      $contentofpage .= "              $data_mdescr";
      $contentofpage .= "            </dl>";
      $contentofpage .= "          </div>";
      $contentofpage .= "          <div class=\"bg\"></div>";
      $contentofpage .= "          <div class=\"b\">";
      $contentofpage .= "            <div class=\"bl\"></div>";
      $contentofpage .= "            <div class=\"br\"></div>";
      $contentofpage .= "          </div>";
      $contentofpage .= "        </div>";
      $contentofpage .= "      </div>";
      $contentofpage .= "    </div>";
    }
  }
}
//!!!END!!class=\"unit size1of3 lastUnit
$contentofpage .= "        </div>";
//!!!END!!Block 2(Full html)::1(Right boxes)
$contentofpage .= "      </div>";
//!!!END!!id="review-page"
$contentofpage .= "    </div>";
//!!!END!!id="content"
$contentofpage .= "  </div>";
//!!!END!!id="main-wrap"
$contentofpage .= "</div>";

//$contentofpage .= "</div>";
?>