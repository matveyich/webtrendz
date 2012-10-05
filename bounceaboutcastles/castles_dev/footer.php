<?php
/**
 * @package WordPress
 * @subpackage Castles_Theme
 */
?>

    <div class="footer">
    	<div class="top">
        	<span class="tl"></span>
        </div>

        <div class="mid">
        	<div class="contentContainer">
			
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
		<?php wp_footer(); ?>
</body>
</html>
