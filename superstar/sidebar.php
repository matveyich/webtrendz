<!--SideBarCell-->
<td>
<div id="sidebar">
<div id="col1">
<? if (function_exists('dynamic_sidebar')) dynamic_sidebar("sidebar"); 
?>			
			<div class="brochureDownload">
              <div class="header"></div>
              <div class="content">
                <div class="search" id="searchForm">
                  <h2>Start your search here!</h2>
                  <img class="new" src="<?php bloginfo('template_url'); ?>/images/new.png" alt="New online booking facility" />
                  <ol class="SearchTypeoptions">
                    <li>
                      <input id="hotels" type="radio" name="myRadio" value="myDiv_1" />
                      <label for="hotels">Hotel Only</label>
                    </li>
                    <li>
                      <input id="fltHot" type="radio" checked="checked" name="myRadio" value="myDiv_2" />
                      <label for="fltHot">Flight + Hotel</label>
                    </li>
                  </ol>
                  <div id="myDiv_1" class="MyDiv searchForm">
                    <p>Use the Hotel availability search form below and book your hotel in Israel with Superstar Holidays.</p>
                    <form target="_blank" method="get" action="http://online.superstar.co.uk/UI_NET/Products/Hotel/Hotel.aspx?" enctype="multipart/form-data">
                      <input id="LeavingFrom" value="LON" name="LeavingFrom" type="hidden" />
                      <ul>
                        <li>
<?

$destinations = $wpdb->get_results("SELECT Name, pid FROM so_destination;");
$select = '
                          <label for="AreaName">Destination: </label>
                          <select id="AreaName" name="AreaName">
						  <option value="" disabled> Select Resort </option>
';
foreach ($destinations as $destination)
{
	$select .= '<option value="'.$destination->Name.'"';
	if ($post->ID == $destination->pid) $select.= ' selected';
	$select .= '>'.$destination->Name.'</option>';
}
$select .= '
                          </select>
';
echo $select;
?>

                        </li>
                        <li>
                          <label for="datepicker">Check-In Date: </label>
                          <input id="datepicker" value="please select" name="CheckInDate" type="text" size="10" />
                        </li>
                        <li>
                          <label for="NumOfNights">No. Nights: </label>
                          <select id="NumOfNights" name="NumOfNights">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3" selected="selected">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                          </select>
                        </li>
                        <li>
                          <label for="NumOfAdult">No. Of Adults: </label>
                          <select id="NumOfAdult" name="NumOfAdult">
                            <option value="1">1</option>
                            <option value="2" selected="selected">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                          </select>
                        </li>
                        <li>
                          <label for="numOfChildren">No. Of Children: </label>
                          <select id="numOfChildren" name="numOfChildren">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                          </select>
                        </li>
                        <li class="btn">
                          <input name="submit" type="submit" class="wht-btn" value="Check Hotel Availability" />
                        </li>
                      </ul>
                    </form>
                  </div>
                  <div id="myDiv_2" class="MyDiv searchForm">
                    <p><strong>Book your flight and hotel together and Superstar guarantee that you will get a cheaper price than booking them seperately.</strong></p>
                    <p>Use the Flight + Hotel search options below to begin your holiday search in Israel with Superstar Holidays.</p>
                    <form target="_blank" method="get" action="http://online.superstar.co.uk/UI_NET/Products/DynamicPackage/DynamicPackage.aspx?" enctype="multipart/form-data">
                      <input id="LeavingFrom" value="LON" name="LeavingFrom" type="hidden" />
                      <ul>
                        <li class="full">
<?
echo $select;
?>							
                        </li>
                        <li>
                          <label for="datepicker2">Departing: </label>
                          <input id="datepicker2" value="please select" name="Departing" type="text" size="10"/>
                        </li>
                        <li>
                          <label for="datepicker3">Returning: </label>
                          <input id="datepicker3" value="please select" name="Returning" type="text" size="10"/>
                        </li>
                        <li>
                          <label for="NumOfAdult">No. Of Adults: </label>
                          <select id="NumOfAdult" name="NumOfAdult">
                            <option value="1">1</option>
                            <option value="2" selected="selected">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                          </select>
                        </li>
                        <li>
                          <label for="numOfChildren">No. Of Children: </label>
                          <select id="numOfChildren" name="numOfChildren">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                          </select>
                        </li>
                        <li class="btn">
                          <input name="submit" type="submit" class="wht-btn" value="Check Flight + Hotel  Availability" />
                        </li>
                      </ul>
                    </form>
                  </div>
                </div>
              </div>
              <div class="footer"></div>
            </div>
			<div class="leftNav">
              <div class="header"></div>
              <div class="content">
                <h1>What are you looking for? </h1>
                <ol>
                  <li><a href="http://www.superstar.co.uk/flights-2.html" tppabs="<?php bloginfo('template_url'); ?>/israel_holidays/flights.html" title="Flights to Israel">Flights to Israel</a> </li>
                  <li><a href="http://www.superstar.co.uk/holiday-planner/accommodation.html" tppabs="<?php bloginfo('template_url'); ?>/holiday-planner/accommodation.html" title="Accommodation in Israel">Hotels in Israel</a> </li>
                  <li><a href="http://www.superstar.co.uk/car-rental.html" tppabs="<?php bloginfo('template_url'); ?>/car-rental.html" title="Car Rental">Car Rental</a></li>
                  <li><a href="http://www.superstar.co.uk/city_breaks.html" tppabs="<?php bloginfo('template_url'); ?>/city_breaks.html"  title="Israel City Breaks">City Breaks</a></li>
                  <li><a href="http://www.superstar.co.uk/tours/discover-israel.html" tppabs="<?php bloginfo('template_url'); ?>/tours/discover-israel.html" title="Discover Israel Tour">Discover Israel</a></li>
                  <li><a href="http://www.superstar.co.uk/tours/kibbutz-touring.html" tppabs="<?php bloginfo('template_url'); ?>/tours/kibbutz-touring.html" title="Kibbutz Touring">Kibbutz Touring</a></li>
                  <li><a href="http://www.superstar.co.uk/spa_breaks.html" tppabs="<?php bloginfo('template_url'); ?>/spa_breaks.html" title="Spa Breaks">Spa Breaks</a></li>
                  <li><a href="http://www.superstar.co.uk/holiday-planner/build-you-own-holiday.html" tppabs="<?php bloginfo('template_url'); ?>/holiday-planner/build-you-own-holiday.html" title="Tailor made packages">Holiday packages</a></li>
                  <li><a href="http://www.superstar.co.uk/special-interests.html" tppabs="<?php bloginfo('template_url'); ?>/special-interests.html" title="Special Interests - Wine Tasting Tours">Special Interests</a></li>
                  <li><a href="http://www.superstar.co.uk/Holiday_destinations_within_Israel/tel-aviv-100.html" tppabs="<?php bloginfo('template_url'); ?>/Holiday_destinations_within_Israel/tel-aviv-100.html" title="Tel Aviv city breaks">Breaks in Tel Aviv</a></li>
                </ol>
              </div>
              <div class="footer"></div>
            </div>
			<div class="promo">
              <div class="header"></div>
              <div class="content">
                <h1 class="promoTitle"> Book your holiday to Israel <a href="javascript:if(confirm('http://online.superstar.co.uk/  \n\nThis file was not retrieved by Teleport Pro, because it is addressed on a domain or path outside the boundaries set for its Starting Address.  \n\nDo you want to open it from the server?'))window.location='http://online.superstar.co.uk/'" tppabs="http://online.superstar.co.uk/" title="Book for Hotel in Israel online" class="lghtTxt undlne">online</a> and take in all the sights with <br />
                  <a href="javascript:if(confirm('http://online.superstar.co.uk/  \n\nThis file was not retrieved by Teleport Pro, because it is addressed on a domain or path outside the boundaries set for its Starting Address.  \n\nDo you want to open it from the server?'))window.location='http://online.superstar.co.uk/'" tppabs="http://online.superstar.co.uk/" class="highlight" title="Book for Hotel in Israel online">Superstar Holidays</a></h1>
<?
/* WTZ 
this gets image gallery from homepage gallery and puts it into carousel
*/
$wplink = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_select_db(DB_NAME,$wplink);
// query
$query = "SELECT gid FROM ".$wpdb->nggallery." WHERE title = 'left column gallery' LIMIT 0,1;";
$result = mysql_query($query, $wplink); echo mysql_error($wplink);
$row = mysql_fetch_array($result);

if (function_exists('nggShowGallery')) echo nggShowGallery($row['gid'], "sidebar"); else echo "no nggShowGallery function";
/*WTZ */
?>                
              </div>
              <div class="footer"></div>
            </div>
			
            <div class="brochureDownload">
			  <div class="header"></div>
              <div class="content">
              <a href="http://www.superstar.co.uk/brochure.html" title="Download our brochures"><img src="<?php bloginfo('template_url'); ?>/images/dwnldbro.png" alt="Download our brochure" border="0"/></a> </div>
              <div class="footer"></div>
            </div></div>
			<!--</div>-->
			</td>
			<!--EndOfSideBarCell-->