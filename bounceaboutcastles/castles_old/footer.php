<?php
/**
 * @package WordPress
 * @subpackage Castles_Theme
 */
?>
			</td>
		</tr>
	</table>	
	</td>

    <td align="center">&nbsp;</td>
  </tr>
  <tr>
      <td colspan="3" align="center" class="address">

    <div class="footer">
    	<div class="top">
        	<span class="tl"></span>
        </div>

        <div class="mid">
        	<div class="contentContainer">
			<div class="footer-menu">
				<ul>
<? wp_list_pages("title_li=&child_of=32&sort_column=menu_order&sort_order=ASC&depth=1");?>			
				</ul>
			</div>
<?
//Footer information
if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('bottom bar') ) : endif;
?>
			
        	
			</div>
        </div>
        <div class="bot">
        	<span class="bl"></span>
        </div>
	
    </div>
	
</div>

<div class="webtrendz">
	web design & developed by <a href="http://www.webtrendz.co.uk">webtrendz.co.uk</a>
</div>



		
		</td> 
    </tr>
	
</table>
 		<?php wp_footer(); ?> 
</body>
</html>
