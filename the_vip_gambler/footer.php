<!-- FOOTER -->
<?php wp_footer(); ?>
<div id="ja-footer" class="wrap">

<div class="main clearfix">
<div class="footer_imgs">
	<a href="http://www.gambleaware.co.uk/" target="blank_"><img src="<?bloginfo('template_url');?>/images/Gambleaware-logo.gif">
	<img src="<?bloginfo('template_url');?>/images/18_only.gif">
</div>
  <ul id="mainlevel-nav">
      <?php /*?><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('bottom menu') ) : ?><?php endif; ?><?php */?>
        <?php //wp_list_pages('child_of=296title_li=&depth=2&sort_column=menu_order'); ?>
        <?php wp_list_pages('child_of=296sort_column=menu_order&title_li='); ?>
    </ul>

  <small>&copy; 2010 by The VIP Gambler | Designed &amp; Developed by Webtrendz</small>
<!--<small><a href="http://www.joomla.org">Joomla!</a> is Free Software released under the <a href="http://www.gnu.org/licenses/gpl-2.0.html">GNU/GPL License.</a></small> -->

</div>
</div>
<!-- //FOOTER -->


<script type="text/javascript">
  //addSpanToTitle();
  //jaAddFirstItemToTopmenu();
  //jaRemoveLastContentSeparator();
  //jaRemoveLastTrBg();
  //moveReadmore();
  //addIEHover();
  //slideshowOnWalk ();
  //apply png ie6 main background
</script>
</div>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-15478675-1");
pageTracker._trackPageview();
} catch(err) {}</script>

</body></html>