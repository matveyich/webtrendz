<?php
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'gifts' ),
		'footer' => __( 'Footer navigation', 'gifts' ),
	) );
	
	register_sidebar( array(
		'name' => __( 'Services', 'gifts' ),
		'id' => 'services-widget-area',
		'description' => __( 'Services widget area', 'gifts' ),
		'before_widget' => '<div class="col">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );	
	
	register_sidebar( array(
		'name' => __( 'See also', 'gifts' ),
		'id' => 'see-also',
		'description' => __( 'See also widget area', 'gifts' ),
		'before_widget' => '<div class="seeAlso">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );
	register_sidebar( array(
		'name' => __( 'header', 'gifts' ),
		'id' => 'header',
		'description' => __( 'See also widget area', 'gifts' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );
	register_sidebar( array(
		'name' => __( 'footer', 'gifts' ),
		'id' => 'footer',
		'description' => __( 'See also widget area', 'gifts' ),
		'before_widget' => '<div class="icons">',
		'after_widget' => '</div>',
		'before_title' => '<div>',
		'after_title' => '</div>',
	) );

function mpg_subpage_banner()
{
global $wpdb,$table_prefix;
	// picture for current page
	//echo '<img alt="" src="'.get_bloginfo('template_url').'/images/subPage-img.jpg">';
	
	$sql = 'select f.field_value as page,f.pid as pid from '.$table_prefix.'nggcf_field_values f inner join '.$table_prefix.'nggcf_fields fs on f.fid = fs.id where fs.field_name = \'page\'';
	$pids = $wpdb->get_results($sql);
	$_sub_pic = false;
	foreach($pids as $pid)
	{
		if(is_page($pid->page))
		{
			$img_src = nggSinglePicture_wtz($pid->pid,702,250);
			$_sub_pic = true;
		}
		if ($pid->page == 'default') $default_src = nggSinglePicture_wtz($pid->pid,702,250);
	}
	if ($_sub_pic==true) echo $img_src; else echo $default_src;
}
function mpg_video_banner()
{
// some video magic here
}	
function mpg_breadcrumbs()
{
/*?>
<div class="breadcrumb">
<?php
*/
if (class_exists('breadcrumb_navigation_xt')) {
// Display a prefix
echo '<ul>';
echo '<li>You are here: </li>';
// new breadcrumb object
$mybreadcrumb = new breadcrumb_navigation_xt;
// Display the breadcrumb
$mybreadcrumb->display();
echo '</ul>';
} 
elseif(function_exists('breadcrumbs')) { 
	
	$bcrumbs = breadcrumbs(false,'home'); 
	
	// last element
//	echo $bcrumbs;

	//$bcrumbs = preg_replace('/&gt;(.*)</div>/','&gt;<li class="current"></div>',$bcrumbs);
	
	$bcrumbs = str_replace('<a ','<li class="previous"><a ',$bcrumbs);
	
	$bcrumbs = str_replace('</a>','</a></li>',$bcrumbs);
	$bcrumbs = str_replace('&gt;','<li class="seperator">&gt;</li>',$bcrumbs);
	$bcrumbs = str_replace('<li class="current">','<li class="current"><a href="">',$bcrumbs);
	//$bcrumbs = str_replace('</div>','</ddiv>',$bcrumbs);
	//$bcrumbs = str_replace('</li>','</a></li>',$bcrumbs);
	
	$bcrumbs = str_replace('<div class="breadcrumb>"','',$bcrumbs);
	$bcrumbs = str_replace('</div>','',$bcrumbs);	
	$bcrumbs = '
	<ul>
		<li>You are here:</li>
		'.$bcrumbs.'
	</ul>
	';
	
	echo $bcrumbs;
	
	
	
	}
else {
?>
		
			<ul>
            	<li>You are here:</li>
                <li class="previous"><a href="">home</a></li>
                <li class="seperator">&gt;</li>
                <li class="current"><a href="">here now</a></li>
            </ul>
		
<?
	}
/*	
?>
</div> <!-- [breadcrumb] -->
<?
*/
}
function mpg_front_page_gallery()
{
global $wpdb;
// next gen gallery template should be called
/* WTZ 
this gets image gallery from homepage gallery and puts it into carousel
*/


if (function_exists('nggShowGallery')) 
{
	$wplink = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	mysql_select_db(DB_NAME,$wplink);
// query
	$query = "SELECT gid FROM ".$wpdb->nggallery." WHERE title = 'main' LIMIT 0,1;";
	$result = mysql_query($query, $wplink); echo mysql_error($wplink);
	$row = mysql_fetch_array($result);
	echo nggShowGallery($row['gid'], "home"); 
}
	else {
		?>
        	<div class="scroller">
        	<ul>
            	<li>
                	
                    	<img src="<?echo get_bloginfo('template_url')?>/images/scroll-img.jpg" alt="Mobile Gift Vouche">
                    	<div class="caption">
                        	<strong>Mobile Gift Vouchers</strong> 
                            <span>Whatever a normal gift voucher or gift card can do a mobile voucher can do and more… </span>
                            <a href="sub-pages.html" class="readMore" title="whatever a normal gift voucher or gift card can do a mobile voucher can do and more…">Find out more</a>                        
                        </div>
                </li>
            </ul>
        </div>
        <div class="scrollNav">
        	<ul>
            	<li>
                	<a class="current" href="#">Mobile Gift Vouchers</a>
                </li>
                <li>
                	<a href="#">Mobile Marketing</a>
                </li>
                <li>
                	<a href="#">Mobile Ticketing</a>
                </li>
                <li class="last">
                	<a href="#">Another Title</a>
                </li>
            </ul>
        </div>		
		<?
		}
/*WTZ */

}
/**
 * YoutubeWidget Class
 */
class Youtube extends WP_Widget {
    /** constructor */
    function Youtube() {
	                $widget_ops = array('classname' => 'widget_text', 'code' => __('You tube code'));
	                $control_ops = array('width' => 125, 'height' => 125);
	                $this->WP_Widget('Youtube', __('Youtube'), $widget_ops, $control_ops);
	        }
	
	        function widget( $args, $instance ) {
	                extract($args);
	                $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
	                $code = apply_filters( 'widget_text', $instance['code'], $instance );
	                echo $before_widget;
	                if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
	                <?php echo $code; ?>
				
					<?php
	                echo $after_widget;
	        }
	
	        function update( $new_instance, $old_instance ) {
	                $instance = $old_instance;
	                $instance['title'] = strip_tags($new_instance['title']);
	                if ( current_user_can('unfiltered_html') )
	                        $instance['code'] =  $new_instance['code'];
	                else
	                        $instance['code'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['code']) ) ); // wp_filter_post_kses() expects slashed
	                $instance['filter'] = isset($new_instance['filter']);
	                return $instance;
	        }
	
	        function form( $instance ) {
	                $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'code' => '' ) );
	                $title = strip_tags($instance['title']);
	                $code = format_to_edit($instance['code']);
	?>
	                <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
	                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
					<p>
	                <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('code'); ?>" name="<?php echo $this->get_field_name('code'); ?>"><?php echo $code; ?></textarea>
	
	                </p>
	<?php
	        }

}
add_action('widgets_init', create_function('', 'return register_widget("Youtube");'));

// WTZ standard links widget modification
/**
 * Links widget class
 *
 * @since 2.8.0
 */
class WP_Widget_Links_wtz extends WP_Widget {

	function WP_Widget_Links_wtz() {
		$widget_ops = array('description' => __( "Your blogroll wtz" ) );
		$this->WP_Widget('links_wtz', __('Links wtz'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args, EXTR_SKIP);

		$show_description = isset($instance['description']) ? $instance['description'] : false;
		$show_name = isset($instance['name']) ? $instance['name'] : false;
		$show_rating = isset($instance['rating']) ? $instance['rating'] : false;
		$show_images = isset($instance['images']) ? $instance['images'] : true;
		$category = isset($instance['category']) ? $instance['category'] : false;

		if ( is_admin() && !$category ) {
			// Display All Links widget as such in the widgets screen
			echo $before_widget . $before_title. __('All Links') . $after_title . $after_widget;
			return;
		}

		$before_widget = preg_replace('/id="[^"]*"/','id="%id"', $before_widget);
		$arg = array(
			'title_before' => $before_title, 'title_after' => $after_title,
			'category_before' => $before_widget, 'category_after' => $after_widget,
			'show_images' => $show_images, 'show_description' => $show_description,
			'show_name' => $show_name, 'show_rating' => $show_rating,
			'category' => $category, 'class' => 'linkcat widget',
			'title_li' => '', 'categorize' => 0, 'link_before' => '', 'link_after' => '',
			'before' => '', 'after' => ''
		);
		wp_list_bookmarks(apply_filters('widget_links_args', $arg));
	}

	function update( $new_instance, $old_instance ) {
		$new_instance = (array) $new_instance;
		$instance = array( 'images' => 0, 'name' => 0, 'description' => 0, 'rating' => 0);
		foreach ( $instance as $field => $val ) {
			if ( isset($new_instance[$field]) )
				$instance[$field] = 1;
		}
		$instance['category'] = intval($new_instance['category']);

		return $instance;
	}

	function form( $instance ) {

		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'images' => true, 'name' => true, 'description' => false, 'rating' => false, 'category' => false ) );
		$link_cats = get_terms( 'link_category');
?>
		<p>
		<label for="<?php echo $this->get_field_id('category'); ?>" class="screen-reader-text"><?php _e('Select Link Category'); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
		
		<?php
		foreach ( $link_cats as $link_cat ) {
			echo '<option value="' . intval($link_cat->term_id) . '"'
				. ( $link_cat->term_id == $instance['category'] ? ' selected="selected"' : '' )
				. '>' . $link_cat->name . "</option>\n";
		}
		?>
		</select></p>
		<p>
		<input class="checkbox" type="checkbox" <?php checked($instance['images'], true) ?> id="<?php echo $this->get_field_id('images'); ?>" name="<?php echo $this->get_field_name('images'); ?>" />
		<label for="<?php echo $this->get_field_id('images'); ?>"><?php _e('Show Link Image'); ?></label><br />
		<input class="checkbox" type="checkbox" <?php checked($instance['name'], true) ?> id="<?php echo $this->get_field_id('name'); ?>" name="<?php echo $this->get_field_name('name'); ?>" />
		<label for="<?php echo $this->get_field_id('name'); ?>"><?php _e('Show Link Name'); ?></label><br />
		<input class="checkbox" type="checkbox" <?php checked($instance['description'], true) ?> id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" />
		<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Show Link Description'); ?></label><br />
		<input class="checkbox" type="checkbox" <?php checked($instance['rating'], true) ?> id="<?php echo $this->get_field_id('rating'); ?>" name="<?php echo $this->get_field_name('rating'); ?>" />
		<label for="<?php echo $this->get_field_id('rating'); ?>"><?php _e('Show Link Rating'); ?></label>
		</p>
<?php
	}
}
	register_widget('WP_Widget_Links_wtz');


// WTZ
/**
 * nggSinglePicture() - show a single picture based on the id
 * 
 * @access public 
 * @param int $imageID, db-ID of the image
 * @param int (optional) $width, width of the image
 * @param int (optional) $height, height of the image
 * @param string $mode (optional) could be none, watermark, web20
 * @param string $float (optional) could be none, left, right
 * @param string $template (optional) name for a template file, look for singlepic-$template
 * @param string $caption (optional) additional caption text
 * @param string $link (optional) link to a other url instead the full image
 * @return the content
 */
function nggSinglePicture_wtz($imageID, $width = 250, $height = 250, $mode = '', $float = '' , $template = '', $caption = '', $link = '') {
    global $post;
    
    $ngg_options = nggGallery::get_option('ngg_options');
    
    // get picturedata
    $picture = nggdb::find_image($imageID);
    
    // if we didn't get some data, exit now
    if ($picture == null)
        return __('[SinglePic not found]','nggallery');
            
    // add float to img
    switch ($float) {
        
        case 'left': 
            $float =' ngg-left';
        break;
        
        case 'right': 
            $float =' ngg-right';
        break;

        case 'center': 
            $float =' ngg-center';
        break;
        
        default: 
            $float ='';
        break;
    }
    
    // clean mode if needed 
    $mode = ( preg_match('/(web20|watermark)/i', $mode) ) ? $mode : '';
    
    //let's initiate the url
    $picture->thumbnailURL = false;

    // check fo cached picture
    if ( ($ngg_options['imgCacheSinglePic']) && ($post->post_status == 'publish') )
        $picture->thumbnailURL = $picture->cached_singlepic_file($width, $height, $mode );
    
    // if we didn't use a cached image then we take the on-the-fly mode 
    if (!$picture->thumbnailURL) 
        $picture->thumbnailURL = get_option ('siteurl') . '/' . 'index.php?callback=image&amp;pid=' . $imageID . '&amp;width=' . $width . '&amp;height=' . $height . '&amp;mode=' . $mode;

    // add more variables for render output
    $picture->imageURL = ( empty($link) ) ? $picture->imageURL : $link;
    /*
	$picture->href_link = $picture->get_href_link();
    $picture->alttext = html_entity_decode( stripslashes(nggGallery::i18n($picture->alttext)) );
    $picture->linktitle = htmlspecialchars( stripslashes(nggGallery::i18n($picture->description)) );
    $picture->description = html_entity_decode( stripslashes(nggGallery::i18n($picture->description)) );
    $picture->classname = 'ngg-singlepic'. $float;
    $picture->thumbcode = $picture->get_thumbcode( 'singlepic' . $imageID);
    $picture->height = (int) $height;
    $picture->width = (int) $width;
    $picture->caption = nggGallery::i18n($caption);

    // filter to add custom content for the output
    $picture = apply_filters('ngg_image_object', $picture, $imageID);

    // let's get the meta data
    $meta = new nggMeta($imageID);
    $exif = $meta->get_EXIF();
    $iptc = $meta->get_IPTC();
    $xmp  = $meta->get_XMP();
    $db   = $meta->get_saved_meta();
    
    //if we get no exif information we try the database 
    $exif = ($exif == false) ? $db : $exif;
	       
    // look for singlepic-$template.php or pure singlepic.php
    $filename = ( empty($template) ) ? 'singlepic' : 'singlepic-' . $template;

    // create the output
    $out = nggGallery::capture ( $filename, array ('image' => $picture , 'meta' => $meta, 'exif' => $exif, 'iptc' => $iptc, 'xmp' => $xmp, 'db' => $db) );

    $out = apply_filters('ngg_show_singlepic_content', $out, $picture );
    
    return $out;
	*/
	return "<img src=$picture->imageURL width=$width height=$height>";
}

?>