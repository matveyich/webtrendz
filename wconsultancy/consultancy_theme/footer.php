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

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
	</div>
	<!--- page wraper -->

	<div class="horzDivider"></div>

	<div class="footerArea">
        <div class="aboutUs">
<?php
/*
$post_id = 53;
$footer_post = get_post($post_id);
//print_r($footer_post);
?>
			<h2><?echo $footer_post->post_title?></h2>
			<?echo $footer_post->post_content
*/
dynamic_sidebar( 'footer-widgets' );				?>
        </div>
<?wtz_latest_news("news");?>
        <div class="contactDetails">
            <h2>... contact info</h2>
            <h3 class="name">Rahim Haji</h3>
            <ul>
                <li><strong>New Business Director</strong></li>
                <li>Work Number: 0208 292 6028</li>
                <li>Mobile Number: 07957459902</li>
                <li>Email: rahim@webtrendz.co.uk</li>
            </ul>
            <h3>Vitalik Kalishevych</h3>
            <ul>
                <li><strong>Development Manager</strong></li>
                <li>Work Number: 0208 292 6028</li>
                <li>Mobile Number: 07891540984</li>
                <li>Email: vitalik@webtrendz.co.uk</li>
            </ul>
        </div>
    </div>

</div>

</body>
</html>
