<!--</div>-->
<tr>
<!--FooterCell-->
<td colspan="2">
<div class="destinationslist">
			<h2>Take a look at some of the great holiday destinations and recommended hotels in Israel</h2>
			<ul>
			<?php
               $parentPage = get_page_by_title('Resorts in Israel');
               $pages = get_pages('child_of='.$parentPage->ID .'&meta_key=isHotel&meta_value=1');
              foreach ($pages as $pagg) {
                    $output  = '<li><a href="';
                    $output .= get_page_link($pagg->ID).'"';
                    $output .= ' title="'.$pagg->post_title.'">'.$pagg->post_title.'</a>';
                     echo $output;
              }        
             ?>

				</ul>
			</div>
<div id="footer">
<div class="abta"><a target="_blank" title="we are ATOL protected {2982}" href="javascript:if(confirm('http://www.caa.co.uk/application.aspx?catid=490&pagetype=65&appid=2&mode=detailnosummary&atolNbr=2982  \n\nThis file was not retrieved by Teleport Pro, because it is addressed on a domain or path outside the boundaries set for its Starting Address.  \n\nDo you want to open it from the server?'))window.location='http://www.caa.co.uk/application.aspx?catid=490&pagetype=65&appid=2&mode=detailnosummary&atolNbr=2982'" tppabs="http://www.caa.co.uk/application.aspx?catid=490&pagetype=65&appid=2&mode=detailnosummary&atolNbr=2982"><img src="<?php bloginfo('template_url'); ?>/images/atol-abta.png" alt="ABTA | ATOL 2982" border="0"  /></a></div>
				<ul>
				   <?php
   
                      $pages = get_pages('parent=0&sort_column=menu_order&sort_order=asc&meta_key=isFooterLink&meta_value=1');
                      foreach ($pages as $pagg) {
                            $output  = '<li><a href="';
                            $output .= get_page_link($pagg->ID).'"';
                            $output .= ' title="'.$pagg->post_title.'">'.$pagg->post_title.'</a>';
                            echo $output;
                    }        
                    ?>

					<li>&copy;2009</li>
				</ul>					
				<span class="end"></span>
			</div>
			</td></tr></table>
</div> <!-- ????? ?????? ????? -->
</div> <!-- ????? ??????????? -->

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www./");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-1319487-2");
pageTracker._setDomainName(".superstar.co.uk.htm"/*tpa=<?php bloginfo('template_url'); ?>/.superstar.co.uk*/);
pageTracker._trackPageview();
} catch(err) {}</script>
<ul class="webtrendz">
			<li><a href="http://www.webtrendz.co.uk">.::. Design by Webtrendz.co.uk .::.</a></li>
		</ul>
</body>
</html>