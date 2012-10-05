<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>
	
	<div class="footer">
        	
 <?php wp_nav_menu( array( 'container' => 'div', 'container_class' => '', 'theme_location' => 'footer','menu_class' => 'footerNav') ); ?>
<script>
$('#menu-footer li:first').addClass('first');
$('#menu-footer li:last').addClass('last');
</script> 
            <div class="social">
            	
                    <?get_sidebar('footer');?>
            	
            </div>
        </div>
    
		<div class="webtrendz"><a href="http://www.webtrendz.co.uk">.::. designed and developed by webtrendz .::.</a></div>
    
	</div>

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
