<?php
/**
 * @package WordPress
 * @subpackage Logic Theme
 */
?>
<script src="<? bloginfo('template_url');?>/js/jquery.logic.sidebar.js"></script>
			<div class="rightCol">
        	<div class="container">

<? if (function_exists('dynamic_sidebar')) dynamic_sidebar("sidebar"); ?>					
 
 
              
            </div>
            
    	</div>