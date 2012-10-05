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

		
<div id="footer">

<?php
	/* A sidebar in the footer? Yep. You can can customize
	 * your footer with four columns of widgets.
	 */
	get_sidebar( 'footer' );
?>
<p class="left">Copyright 2009 by Alan Wyatt Estates. <div id="footer_menu">
<script>
$(document).ready(function() {
$('#footer_menu ul li:first').addClass('first');
$('#footer_menu ul li:last').addClass('last');
});
</script>
<?php wp_nav_menu( array( 'container' => '', 'container_class' => '', 'theme_location' => 'footer') ); ?>
</div>	</p>

<p class="right">Developed by <a href="http://www.webtrendz.co.uk" target="_blank">Webtrendz</a></p>

	</div>
	<div class="clear"></div>


<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
