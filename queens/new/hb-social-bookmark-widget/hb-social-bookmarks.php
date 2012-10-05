<?php
/*
Plugin Name: HB Social Bookmarks
Plugin URI: http://www.hendrikbahr.de/social-bookmark-wordpress-plugin/
Description: Plugin displays several social bookmark icons in the sidebar as a widget. After activation place the social bookmark widget on any space in your sidebar through the design -> widgets menu in WordPress admin. NEW: Select, which of the icons are displayed!
Author: Hendrik Bahr
Version: 1.3.0
Author URI: http://www.hendrikbahr.de/
*/
class hb_social_bookmark {
	
	
	
	/**
	 * initializes plugin
	 */
	function init(){
		
		$widget = new hb_social_bookmark();
		$widget->image_path			= get_option('siteurl').'/wp-content/plugins/hb-social-bookmark-widget';
		$widget->options			= get_option('widget_hb-social-bookmark');
		
		//initial option setting
		if (!isset($widget->options['title'])){
			$options = array(
				'title' 		=> 'Social Bookmarks',
				'browser' 		=> 1,
				'wong' 			=> 1,
				'facebook' 		=> 1,
				'stumbleupon' 	=> 1,
				'technorati' 	=> 1,
				'furl' 			=> 1,
				'delicious'		=> 1,
				'yahoo' 		=> 1,
				'linkarena'		=> 1,
				'oneview' 		=> 1,
				'webnews' 		=> 1,
				'digg' 			=> 1,
				'myspace' 		=> 1,
				'windowslive' 	=> 1,
				'google' 		=> 1,
				'folkd' 		=> 1,
				'blinklist' 	=> 1,
				'favoritende' 	=> 1,
				'yigg'			=> 1,
				'weblinkr' 		=> 1,
				'kledy' 		=> 1,
				'twitter'		=> 1
				);
			add_option('widget_hb-social-bookmark', $options);
			$widget->options	= get_option('widget_hb-social-bookmark');
		}
    	register_sidebar_widget('HB Social Bookmarks', array($widget,'display'));
    	register_widget_control('HB Social Bookmarks', array($widget,'admin_control'));
	}
	/** 
	 * echos HTML output for social bookmark widget
	 */
	function display($args){
	extract($args);
	global $pr_user_properties_slug,$pr_user_downloads_slug,$pr_tennant_slug; // WTZ properties globals
if (!(is_page('my-account') or is_page($pr_user_properties_slug) or is_page($pr_user_downloads_slug) or is_page($pr_tennant_slug)))
	{		
		/*Preparing variables */
			$image_path			= $this->image_path;
			$url 				= htmlentities('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		/*
		if (is_single() || is_page()) {
			$description_iso 	= get_the_excerpt();
			$description 		= urlencode($description_iso);
			$title_iso			= get_the_title();
			$title				= urlencode($title_iso);
		}elseif (is_home()) {
			$description_iso 	= get_bloginfo('description');
			$description 		= urlencode($description_iso);
			$title_iso 			= get_bloginfo('name');
			$title 				= urlencode($title_iso);
		}elseif (is_archive()){
			$description_iso 	= single_tag_title('', false).' - '.get_bloginfo('description');
			$description 		= urlencode($description_iso);		
			$title_iso 			= single_tag_title('', false);
			$title 				= urlencode($title_iso);	
		}else {*/
			$description_iso 	= '';
			$description 		= '';
			$title_iso 			= '';
			$title 				= '';
		/*}*/

		/* printing Output */
		echo $before_widget;
		//echo '<li class="widget widget_links">';
		echo '	    <script type="text/javascript">
				<!--
					/* Function for Displaying Platform Title */
					function displayBookmark(text){
					//	myDiv = document.getElementById(\'bookmark\');
					//	myDiv.innerHTML = text;
				    	}
					/* Function for Add to Facebook */
					function fbs_click() {
					        u=location.href;
					        t=document.title;
					        window.open("http://www.facebook.com/sharer.php?u="+encodeURIComponent(u)+"&t="+encodeURIComponent(t),"sharer","toolbar=0 ,status=0,width=626,height=436");
					        return false;
				        }
				    /* Function for Add to MySpace */
				    function GetThis(T, C, U, L){
							var targetUrl = "http://www.myspace.com/Modules/PostTo/Pages/?"+"t="+encodeURIComponent(T)+"&c="+encodeURIComponent(C)+"&u="+encodeURIComponent(U)+"&l="+L;
							window.open(targetUrl);
						}
					/* Function for adding to browser favorites */
					function AddFavorite(){
							if(navigator.appName != "Microsoft Internet Explorer"){
								window.external.addPanel(\''.$title_iso.'\',\''.$url.'\', \'\')
							} else {
								window.external.addFavorite(location.href, \''.$title_iso.'\');
							}							
						}
				-->
				</script>';
echo $before_title.$this->options['title'].$after_title;
/*	
		  <h2 class="widgettitle">'.$this->options['title'].'</h2>';			
*/	
		#echo '		Bookmark in:	<span id="bookmark" style="font-weight: bold;"></span><br /><br />';

		if ($this->options['browser'] == 1) {
		echo '	<!-- Favourites -->
				<a href="javascript:AddFavorite();"
					onmouseover="displayBookmark(\'Favourites\')" onmouseout="displayBookmark(\'\')"	
					title="Favourites">
					<img src="'.$image_path.'/book_favorites.png" alt="Browser Favourites" /></a>';
		}
		if ($this->options['wong'] == 1) {			
		echo '	<!-- Mister Wong -->
				<a href="http://www.mister-wong.de/?action=addurl&amp;bm_url='.$url.'&amp;bm_description='.$title.'"
					onmouseover="displayBookmark(\'Mr. Wong\')" onmouseout="displayBookmark(\'\')"
					title="Bei Mr. Wong bookmark" target="_blank"><img
					src="'.$image_path.'/book_wong.gif" alt="Mr. Wong" /></a>';
		}
		if ($this->options['facebook'] == 1) {
		echo'	<!-- Facebook -->
				<a href="http://www.facebook.com/share.php" 
					onmouseover="displayBookmark(\'Facebook\')" onmouseout="displayBookmark(\'\')"
					onclick="return fbs_click()" title="Facebook"
					target="_blank"><img
					src="'.$image_path.'/book_facebook.gif" alt="Facebook" /></a>';
		}
		if ($this->options['stumbleupon'] == 1) {
		echo'	<!-- StumbleUpon -->
				<a href="http://www.stumbleupon.com/submit?url='.$url.'"
					onmouseover="displayBookmark(\'StumbleUpon\')" onmouseout="displayBookmark(\'\')" 
					title="StumbledUpon">
					<img src="'.$image_path.'/book_su.gif" alt="StumbleUpon" />
					</a>';
		}
		if ($this->options['technorati'] == 1) {			
		echo'	<!-- Technorati -->
				<a href="http://www.technorati.com/faves/?add='.$url.'"
					onmouseover="displayBookmark(\'Technorati\')" onmouseout="displayBookmark(\'\')"
					title="Technorati" target="_blank"><img
					src="'.$image_path.'/book_technorati.png"
					alt="technorati" /></a>';
		}
		if ($this->options['furl'] == 1) {
		echo'	<!-- Furl -->
				<a href="http://furl.net/storeIt.jsp?u='.$url.'&amp;t='.$title.'"
					onmouseover="displayBookmark(\'Furl\')" onmouseout="displayBookmark(\'\')"
					title="Furl" target="_blank"><img
					src="'.$image_path.'/book_furl.png" alt="Furl" /></a>';
		}
		if ($this->options['delicious'] == 1) {		
		echo'	<!-- Del.icio.us -->
				<a href="http://del.icio.us/post?url='.$url.'&amp;title='.$title.'"
					onmouseover="displayBookmark(\'Del.icio.us\')" onmouseout="displayBookmark(\'\')"
					title="del.icio.us" target="_blank"><img
					src="'.$image_path.'/book_delicious.png"
					alt="del.icio.us" /></a>';
		}
		if ($this->options['yahoo'] == 1) {		
		echo'	<!-- Yahoo -->
				<a href="http://myweb2.search.yahoo.com/myresults/bookmarklet?u='.$url.'&amp;t='.$title.'"
					onmouseover="displayBookmark(\'Yahoo\')" onmouseout="displayBookmark(\'\')"
					title="My Yahoo" target="_blank"><img
					src="'.$image_path.'/book_yahoo.png" alt="yahoo" /></a>';
		}
		if ($this->options['linkarena'] == 1) {		
		echo'	<!-- Linkarena -->
				<a href="http://www.linkarena.com/bookmarks/addlink/?url='.$url.'&amp;title='.$title.'"
					onmouseover="displayBookmark(\'Linkarena\')" onmouseout="displayBookmark(\'\')"
					title="Linkarena" target="_blank"><img
					src="'.$image_path.'/book_linkarena.png" alt="Linkarena" /></a>';
		}
		if ($this->options['oneview'] == 1) {		
		echo'	<!-- Oneview -->
				<a href="http://oneview.de/quickadd/neu/addBookmark.jsf?URL='.$url.'&amp;title='.$title.'"
					onmouseover="displayBookmark(\'Oneview\')" onmouseout="displayBookmark(\'\')"
					title="Oneview" target="_blank"><img
					src="'.$image_path.'/book_oneview.png" alt="Oneview" /></a>';
		}
		if ($this->options['webnews'] == 1) {		
		echo'	<!-- Webnews -->
				<a href="http://www.webnews.de"
					onmouseover="displayBookmark(\'Webnews\')" onmouseout="displayBookmark(\'\')" 
					onclick="document.location = \'http://www.webnews.de/einstellen?url=\'+encodeURIComponent(document.location)+\'&amp;title=\'+encodeURIComponent(document.title); return false;" 
					title="Webnews">
					<img src="'.$image_path.'/book_webnews.gif" alt="Webnews" /></a>';
		}
		if ($this->options['digg'] == 1) {		
		echo'	<!-- Digg -->
				<a href="http://digg.com/submit?url='.$url.'&amp;title='.$title.'&amp;bodytext='.$description.'&amp;media=news&amp;topic=tech_news"
					onmouseover="displayBookmark(\'Digg\')" onmouseout="displayBookmark(\'\')" 
					title="Digg it">
					<img src="'.$image_path.'/book_digg.png" width="16" height="16" alt="Digg!" />
					</a>';
		}
		if ($this->options['myspace'] == 1) {			
		echo'	<!-- Myspace -->
				<a href="javascript: GetThis(\''.$title_iso.' \', \''.$description_iso.' \', \' '.$url.' \', 5)"
					onmouseover="displayBookmark(\'MySpace\')" onmouseout="displayBookmark(\'\')" 
					title="MySpace">
					<img src="'.$image_path.'/book_myspace.gif" alt="MySpace" /></a>';
		}
		if ($this->options['windowslive'] == 1) {			
		echo'	<!-- Windows live -->
				<a href="https://favorites.live.com/quickadd.aspx?marklet=1&amp;mkt=de&amp;url='.$url.'&amp;title='.$title.'&amp;top=1"
					onmouseover="displayBookmark(\'Windows Live\')" onmouseout="displayBookmark(\'\')"
					title="Windows live Favorites">
					<img src="'.$image_path.'/book_live.png" alt="Windows Live" /></a>';
		}
		if ($this->options['google'] == 1) {
		echo'	<!-- Google -->
				<a href="http://www.google.com/bookmarks/mark?op=add&amp;hl=de&amp;bkmk='.$url.'&amp;title='.$title.'"
					onmouseover="displayBookmark(\'Google\')" onmouseout="displayBookmark(\'\')"
					title="iGoogle" target="_blank"><img
					src="'.$image_path.'/book_google.png" alt="google" /></a>';
		}
		if ($this->options['folkd'] == 1) {			
		echo'	<!-- folkd -->
				<a href="http://www.folkd.com/submit/'.$url.'"
					onmouseover="displayBookmark(\'folkd\')" onmouseout="displayBookmark(\'\')"
					title="folkd" target="_blank"><img
					src="'.$image_path.'/book_folkd.png" alt="folkd" /></a>';
		}
		if ($this->options['blinklist'] == 1) {
		echo'	<!-- Blinklist -->
				<a href="http://www.blinklist.com/?Action=Blink/addblink.php&amp;Url='.$url.'&amp;Title='.$title.'&amp;Tag=&amp;Description='.$description.'"
					onmouseover="displayBookmark(\'Blinklist\')" onmouseout="displayBookmark(\'\')"
					title="Blinklist" target="_blank"><img
					src="'.$image_path.'/book_blinklist.png" alt="Blinklist" /></a>';
		}
		if ($this->options['favoritende'] == 1) {			
		echo'	<!-- Favoriten.de -->
					<a href="http://www.favoriten.de/url-hinzufuegen.html" 
					onmouseover="displayBookmark(\'Favoriten.de\')" onmouseout="displayBookmark(\'\')"
					onclick="location.href=&quot;http://www.favoriten.de/url-hinzufuegen.html?bm_url=&quot;+encodeURIComponent(location.href)+&quot;&amp;bm_title=&quot;+encodeURIComponent(document.title);return false" 
					title="Favoriten.de" target="_top">
					<img src="'.$image_path.'/book_favoritende.gif" alt="Favoriten.de" /></a>';
		}
		if ($this->options['yigg'] == 1) {		
		echo'	<!-- Yigg -->
					<a href="http://yigg.de/neu?exturl='.$url.'&amp;exttitle='.$title.'&amp;extdesc='.$description.'"
					onmouseover="displayBookmark(\'Yigg\')" onmouseout="displayBookmark(\'\')"
					title="Yigg" target="_blank">
					<img src="'.$image_path.'/book_yigg.png" alt="Yigg" /></a>';
		}
		if ($this->options['weblinkr'] == 1) {		
		echo'	<!-- Weblinkr -->
					<a href="http://weblinkr.com" onclick="window.open(\'http://weblinkr.com/add/?popup=1&amp;address=\'+encodeURIComponent(location.href)+\'&amp;title=\'+encodeURIComponent(document.title), \'Weblinkr\',\'width=730, height=500, scrollbars=1, toolbar=0, resizable=1\'); return false;"
					onmouseover="displayBookmark(\'Weblinkr\')" onmouseout="displayBookmark(\'\')"
					title="Weblinkr" target="_blank">
					<img src="'.$image_path.'/book_weblinkr.png" alt="Weblinkr" /></a>';
		}
		if ($this->options['kledy'] == 1) {
		echo'	<!-- Kledy -->
				<a href="http://www.kledy.de/" onclick="document.location = \'http://www.kledy.de/submit.php?url=\'+encodeURIComponent(document.location); return false;" 
				onmouseover="displayBookmark(\'Kledy\')" onmouseout="displayBookmark(\'\')"
				title="KLEDY">
				<img src="'.$image_path.'/book_kledy.png" alt="Kledy" />
				</a>';
		
		}		
		if ($this->options['twitter'] == 1) {
		echo'	<!-- Kledy -->
				<a href="http://www.twitter.com/" onclick="document.location = \'http://www.twitter.com/?status=\'+document.location; return false;" 
				onmouseover="displayBookmark(\'Twitter\')" onmouseout="displayBookmark(\'\')"
				title="Twitter">
				<img src="'.$image_path.'/book_twitter.png" alt="Twitter" />
				</a>';
		
		}
		
		/*
		 * echos plugin credentials - thank you for supporting the author by not removing it, but it's up to you.
		
		echo '<div>Plugin by <a href="http://www.hendrikbahr.de">Hendrik Bahr</a>.</div>';
 */
		echo $after_widget;
		/*
		echo '
			</li>';
		*/
		}
	}
	
	function admin_control() {
		$options = $newoptions = $this->options;
		if ( isset($_POST["hb-social-bookmark-submit"]) ) {
			$newoptions['title'] 		= strip_tags(stripslashes($_POST["hb-social-bookmark-title"]));
			$newoptions['browser'] 		= ($_POST["hb-social-bookmark-browser"] == 1) ? 1 : 0;
			$newoptions['wong'] 		= ($_POST["hb-social-bookmark-wong"] == 1) ? 1 : 0;
			$newoptions['facebook'] 	= ($_POST["hb-social-bookmark-facebook"] == 1) ? 1 : 0;
			$newoptions['stumbleupon'] 	= ($_POST["hb-social-bookmark-stumbleupon"] == 1) ? 1 : 0;
			$newoptions['technorati'] 	= ($_POST["hb-social-bookmark-technorati"] == 1) ? 1 : 0;
			$newoptions['furl'] 		= ($_POST["hb-social-bookmark-furl"] == 1) ? 1 : 0;
			$newoptions['delicious'] 	= ($_POST["hb-social-bookmark-delicious"] == 1) ? 1 : 0;
			$newoptions['yahoo'] 		= ($_POST["hb-social-bookmark-yahoo"] == 1) ? 1 : 0;
			$newoptions['linkarena'] 	= ($_POST["hb-social-bookmark-linkarena"] == 1) ? 1 : 0;
			$newoptions['oneview'] 		= ($_POST["hb-social-bookmark-oneview"] == 1) ? 1 : 0;
			$newoptions['webnews'] 		= ($_POST["hb-social-bookmark-webnews"] == 1) ? 1 : 0;
			$newoptions['digg'] 		= ($_POST["hb-social-bookmark-digg"] == 1) ? 1 : 0;
			$newoptions['myspace'] 		= ($_POST["hb-social-bookmark-myspace"] == 1) ? 1 : 0;
			$newoptions['windowslive'] 	= ($_POST["hb-social-bookmark-windowslive"] == 1) ? 1 : 0;
			$newoptions['google'] 		= ($_POST["hb-social-bookmark-google"] == 1) ? 1 : 0;
			$newoptions['folkd'] 		= ($_POST["hb-social-bookmark-folkd"] == 1) ? 1 : 0;
			$newoptions['blinklist'] 	= ($_POST["hb-social-bookmark-blinklist"] == 1) ? 1 : 0;
			$newoptions['favoritende'] 	= ($_POST["hb-social-bookmark-favoritende"] == 1) ? 1 : 0;
			$newoptions['yigg'] 		= ($_POST["hb-social-bookmark-yigg"] == 1) ? 1 : 0;
			$newoptions['weblinkr'] 	= ($_POST["hb-social-bookmark-weblinkr"] == 1) ? 1 : 0;
			$newoptions['kledy'] 		= ($_POST["hb-social-bookmark-kledy"] == 1) ? 1 : 0;
			$newoptions['twitter'] 		= ($_POST["hb-social-bookmark-twitter"] == 1) ? 1 : 0;
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_hb-social-bookmark', $options);
		}
		$title = attribute_escape($options['title']);
		?>
			<p><label for="hb-social-bookmark-title"><?php _e('Title:'); ?> <input class="widefat" id="hb-social-bookmark-title" name="hb-social-bookmark-title" type="text" value="<?php echo $title; ?>" /></label></p>
			
			<p><label for="hb-social-bookmark-browser"><img src="<?php echo $this->image_path; ?>/book_favorites.png" /> <input id="hb-social-bookmark-browser" name="hb-social-bookmark-browser" type="checkbox" value="1" <?php if ($options['browser'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('Browser-Favoriten'); ?></label></p>
			<p><label for="hb-social-bookmark-wong"><img src="<?php echo $this->image_path; ?>/book_wong.gif" /> <input id="hb-social-bookmark-wong" name="hb-social-bookmark-wong" type="checkbox" value="1" <?php if ($options['wong'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('Mister Wong'); ?></label></p>
			<p><label for="hb-social-bookmark-facebook"><img src="<?php echo $this->image_path; ?>/book_facebook.gif" /> <input id="hb-social-bookmark-facebook" name="hb-social-bookmark-facebook" type="checkbox" value="1" <?php if ($options['facebook'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('Facebook'); ?></label></p>
			<p><label for="hb-social-bookmark-stumbleupon"><img src="<?php echo $this->image_path; ?>/book_su.gif" /> <input id="hb-social-bookmark-stumbleupon" name="hb-social-bookmark-stumbleupon" type="checkbox" value="1" <?php if ($options['stumbleupon'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('Stumble Upon'); ?></label></p>
			<p><label for="hb-social-bookmark-technorati"><img src="<?php echo $this->image_path; ?>/book_technorati.png" /> <input id="hb-social-bookmark-technorati" name="hb-social-bookmark-technorati" type="checkbox" value="1" <?php if ($options['technorati'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('Technorati'); ?></label></p>
			<p><label for="hb-social-bookmark-furl"><img src="<?php echo $this->image_path; ?>/book_furl.png" /> <input id="hb-social-bookmark-furl" name="hb-social-bookmark-furl" type="checkbox" value="1" <?php if ($options['furl'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('fUrl'); ?></label></p>
			<p><label for="hb-social-bookmark-delicious"><img src="<?php echo $this->image_path; ?>/book_delicious.png" /> <input id="hb-social-bookmark-delicious" name="hb-social-bookmark-delicious" type="checkbox" value="1" <?php if ($options['delicious'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('Del.icio.us'); ?></label></p>
			<p><label for="hb-social-bookmark-yahoo"><img src="<?php echo $this->image_path; ?>/book_yahoo.png" /> <input id="hb-social-bookmark-yahoo" name="hb-social-bookmark-yahoo" type="checkbox" value="1" <?php if ($options['yahoo'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('Yahoo'); ?></label></p>
			<p><label for="hb-social-bookmark-linkarena"><img src="<?php echo $this->image_path; ?>/book_linkarena.png" /> <input id="hb-social-bookmark-linkarena" name="hb-social-bookmark-linkarena" type="checkbox" value="1" <?php if ($options['linkarena'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('Linkarena'); ?></label></p>
			<p><label for="hb-social-bookmark-oneview"><img src="<?php echo $this->image_path; ?>/book_oneview.png" /> <input id="hb-social-bookmark-oneview" name="hb-social-bookmark-oneview" type="checkbox" value="1" <?php if ($options['oneview'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('Oneview'); ?></label></p>
			<p><label for="hb-social-bookmark-webnews"><img src="<?php echo $this->image_path; ?>/book_webnews.gif" /> <input id="hb-social-bookmark-webnews" name="hb-social-bookmark-webnews" type="checkbox" value="1" <?php if ($options['webnews'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('Webnews'); ?></label></p>
			<p><label for="hb-social-bookmark-digg"><img src="<?php echo $this->image_path; ?>/book_digg.png" /> <input id="hb-social-bookmark-digg" name="hb-social-bookmark-digg" type="checkbox" value="1" <?php if ($options['digg'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('Digg'); ?></label></p>
			<p><label for="hb-social-bookmark-myspace"><img src="<?php echo $this->image_path; ?>/book_myspace.gif" /> <input id="hb-social-bookmark-myspace" name="hb-social-bookmark-myspace" type="checkbox" value="1" <?php if ($options['myspace'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('Myspace'); ?></label></p>
			<p><label for="hb-social-bookmark-windowslive"><img src="<?php echo $this->image_path; ?>/book_live.png" /> <input id="hb-social-bookmark-windowslive" name="hb-social-bookmark-windowslive" type="checkbox" value="1" <?php if ($options['windowslive'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('Windows Live'); ?></label></p>
			<p><label for="hb-social-bookmark-google"><img src="<?php echo $this->image_path; ?>/book_google.png" /> <input id="hb-social-bookmark-google" name="hb-social-bookmark-google" type="checkbox" value="1" <?php if ($options['google'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('Google'); ?></label></p>
			<p><label for="hb-social-bookmark-folkd"><img src="<?php echo $this->image_path; ?>/book_folkd.png" /> <input id="hb-social-bookmark-folkd" name="hb-social-bookmark-folkd" type="checkbox" value="1" <?php if ($options['folkd'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('folkd'); ?></label></p>
			<p><label for="hb-social-bookmark-blinklist"><img src="<?php echo $this->image_path; ?>/book_blinklist.png" /> <input id="hb-social-bookmark-blinklist" name="hb-social-bookmark-blinklist" type="checkbox" value="1" <?php if ($options['blinklist'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('Blinklist'); ?></label></p>
			<p><label for="hb-social-bookmark-favoritende"><img src="<?php echo $this->image_path; ?>/book_favoritende.gif" /> <input id="hb-social-bookmark-favoritende" name="hb-social-bookmark-favoritende" type="checkbox" value="1" <?php if ($options['favoritende'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('Favoriten.de'); ?></label></p>
			<p><label for="hb-social-bookmark-yigg"><img src="<?php echo $this->image_path; ?>/book_yigg.png" /> <input id="hb-social-bookmark-yigg" name="hb-social-bookmark-yigg" type="checkbox" value="1" <?php if ($options['yigg'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('Yigg'); ?></label></p>
			<p><label for="hb-social-bookmark-weblinkr"><img src="<?php echo $this->image_path; ?>/book_weblinkr.png" /> <input id="hb-social-bookmark-weblinkr" name="hb-social-bookmark-weblinkr" type="checkbox" value="1" <?php if ($options['weblinkr'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('Weblinkr'); ?></label></p>
			<p><label for="hb-social-bookmark-kledy"><img src="<?php echo $this->image_path; ?>/book_kledy.png" /> <input id="hb-social-bookmark-kledy" name="hb-social-bookmark-kledy" type="checkbox" value="1" <?php if ($options['kledy'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('Kledy'); ?></label></p>			<p><label for="hb-social-bookmark-twitter"><img src="<?php echo $this->image_path; ?>/book_twitter.png" /> <input id="hb-social-bookmark-twitter" name="hb-social-bookmark-twitter" type="checkbox" value="1" <?php if ($options['twitter'] == 1){ ?>checked="checked"<?php } ?> /> <?php _e('Twitter'); ?></label></p>
			
			<input type="hidden" id="hb-social-bookmark-submit" name="hb-social-bookmark-submit" value="1" />
		<?php
	}
}

add_action('widgets_init',array('hb_social_bookmark','init'));

?>