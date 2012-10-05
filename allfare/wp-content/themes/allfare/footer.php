<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
?>

<div class="footer">
		<ul>
			<li class="no_bdr">&copy; All The Worlds Fare Ltd 2010</li>
<?php wp_list_pages('title_li=&sort_column=menu_order&sort_order=ASC&depth=1&child_of=28'); ?>
            <li class="cert"><a href="http://www.nsf-cmi.com/" target="_blank" title="NSF-CMi Certification Q Mark"><img src="<? bloginfo('template_url');?>/images/nsf-cmi-cert-q-mark.gif" alt="NSF-CMi Certification Q Mark" /></a></li>
			<li class="cert"><a href="http://www.brcdirectory.com/Site.aspx?BrcSiteCode=1379093" target="_blank" title="BRC Acreditation: 1379093"><img src="<? bloginfo('template_url');?>/images/brc-cred.gif" alt="BRC Acreditation: 1379093" /></a></li>
		</ul>
	</div>
</div>
<ul class="webtrendzFooter">
    	<li class="s_bookmarks"><?dynamic_sidebar('Footer blocks');?></li>
    	<li class="webtrendz">.::. <a href="http://www.webtrendz.co.uk" title="Site by Webtrendz.co.uk">Site by Webtrendz.co.uk</a> .::.</li>
</ul>


<?php /* "Just what do you think you're doing Dave?" */ ?>

		<?php wp_footer(); ?>
<?
if (is_front_page()||is_page('our-products'))
{
?>

<script type="text/javascript">
			jQuery(document).ready(function($) {
				// We only want these styles applied when javascript is enabled
				$('div.navigation').css({'width' : '205px', 'float' : 'left'});
				$('div.content').css('display', 'block');

				// Initially set opacity on thumbs and add
				// additional styling for hover effect on thumbs
				var onMouseOutOpacity = 0.67;
				$('#thumbs ul.thumbs li').opacityrollover({
					mouseOutOpacity:   onMouseOutOpacity,
					mouseOverOpacity:  1.0,
					fadeSpeed:         'fast',
					exemptionSelector: '.selected'
				});

				// Initialize Advanced Galleriffic Gallery
				var gallery = $('#thumbs').galleriffic({
					delay:                     2500,
					numThumbs:                 15,
					preloadAhead:              10,
					enableTopPager:            false,
					enableBottomPager:         false,
					maxPagesToShow:            20,
					imageContainerSel:         '#slideshow',
					controlsContainerSel:      '',
					captionContainerSel:       '#caption',
					loadingContainerSel:       '#loading',
					renderSSControls:          true,
					renderNavControls:         true,
					playLinkText:              'Play Slideshow',
					pauseLinkText:             'Pause Slideshow',
					prevLinkText:              '&lsaquo; Previous Photo',
					nextLinkText:              'Next Photo &rsaquo;',
					nextPageLinkText:          'Next &rsaquo;',
					prevPageLinkText:          '&lsaquo; Prev',
					enableHistory:             true,
					autoStart:                 true,
					syncTransitions:           true,
					defaultTransitionDuration: 900,
					onSlideChange:             function(prevIndex, nextIndex) {
						// 'this' refers to the gallery, which is an extension of $('#thumbs')
						this.find('ul.thumbs').children()
							.eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()

							.eq(nextIndex).fadeTo('fast', 1.0);
					},
					onPageTransitionOut:       function(callback) {
						this.fadeTo('fast', 0.0, callback);
					},
					onPageTransitionIn:        function() {
						this.fadeTo('fast', 1.0);
					}
				});
			});
</script>
<?
}
?>
<div id="overlay" style="display: none; width: 100%; height: 1727px; opacity: 0.8;"></div>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-16048602-1");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>
</html>
