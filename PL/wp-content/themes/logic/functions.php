<?php
/**
 * @package WordPress
 * @subpackage Logic theme
 */

function top_earners($cat = "Top earners",$num = 2)
{
	$args = array(
		'numberposts' => $num,
		'orderby' => 'date',
		'order' => 'DESC',
		'category_name' => $cat
	);
	$lastposts = get_posts($args);
	if ($lastposts){
	echo "<h2>".$cat."</h2>";
	echo "<ul>";
	$i=1;foreach ($lastposts as $post) {
		$class=($i==count($lastposts))?' class="last"':false;
		setup_postdata($post);?>
	<li<?=$class?>>
       <span class="earnerImg"><?if(function_exists("p75GetThumbnail")) {?><a href="<?echo get_permalink($post->ID);?>"><img src="<? echo p75GetThumbnail($post->ID);?>"></a><?}?></span>
	<span class="earnerDetails">
		<span class="earnerTitle"><a href="<?echo get_permalink($post->ID);?>"><? echo $post->post_title;?></a></span> 
		<span class="earnerDesc"><?echo $post->post_excerpt;?></span>                     	
	</span>
   </li>
    <?
	$i++;}
	echo "</ul>";
	}
}
function last_posts_by_cat_id_featured($cat_id,$num = 10)
{

$args = array(
		'numberposts' => $num,
		'orderby' => 'date',
		'order' => 'DESC',
		'category' => "12,$cat_id",
	);
	$lastposts = get_posts($args);
	echo "<div>";
	//echo "<p>".$cat."</p>";
	if ($lastposts) {
		foreach ($lastposts as $post) {
		setup_postdata($post);
		?>
		<p><a href="<? echo get_permalink($post->ID);?>"><? echo $post->post_title;?></a></p>
		<?
		}
	}	
	echo "</div>";
} 
function last_posts($cat,$num = 10,$content = false)
{

$args = array(
		'numberposts' => $num,
		'orderby' => 'date',
		'order' => 'DESC',
		'category_name' => $cat
	);
	$lastposts = get_posts($args);
	echo "<div>";
	//echo "<p>".$cat."</p>";
	if ($lastposts) {
		foreach ($lastposts as $post) {
		setup_postdata($post);
		if ($content == false)
    {?>
		<p><a href="<? echo get_permalink($post->ID);?>"><? echo $post->post_title;?></a></p>
		<?
		} else 
		  {
      $cat = get_category(get_category_by_slug($cat));
      echo "<h3><a href=\"".get_permalink($post->ID)."\">$post->post_title</a></h3><p>$post->post_content</p><p><a href=\"".get_category_link($cat->cat_ID)."\" class=\"archive\">$cat->name archive</a></p>";
      }
		}
	}	
	echo "</div>";
}   
function last_posts_accordion($cat,$num = 0)
{

$args = array(
		'numberposts' => $num,
		'orderby' => 'date',
		'order' => 'DESC',
		'category_name' => $cat
	);
	$lastposts = get_posts($args);
	echo "<ul id=\"accordion_$cat\" class=\"accordion\">";
	//echo "<p>".$cat."</p>";
	if ($lastposts) {
		foreach ($lastposts as $post) {
		setup_postdata($post);
		?>
		<li>
		<h2><? echo $post->post_title;?></h2>
		<p class="pane">
		<?echo $post->post_content;?>
		</p>
		</li>
		<?
		}
	}	
	echo "</ul>";
	?>
<script>
jq(function() { 

jq("#accordion<?echo "_$cat";?> p.pane").each(function(index) {jq(this).height(jq(this).height());});// устанавливаем высоту каждой ячейки
jq("#accordion<?echo "_$cat";?> p.pane").css('display','none'); // сворачиваем все ячейки
jq("#accordion<?echo "_$cat";?> h2").click(function(){
var index = jq(this).parent("li").eq();// кажется можно закомнетить это
//jq("#accordion<?echo "_$cat";?> li.open p.pane").slideUp(300);
//jq("#accordion<?echo "_$cat";?> li.open p.pane").not(jq(this).parent().children('p.pane')).css('display','none');
jq("#accordion<?echo "_$cat";?> li.open p.pane").not(jq(this).parent().children('p.pane')).slideUp(600); // закрываем текущий открытый блок при нажатии на его заголовке
jq("#accordion<?echo "_$cat";?> li.open").not(jq(this).parent()).toggleClass('open');// переключаем класс его открытости
jq("#accordion<?echo "_$cat";?> li h2.current").not(jq(this)).toggleClass('current');// переключаем класс того, что он текущий открытый
if(jq(this).parent("li").children("p.pane").css('display') == 'none') // если блок скрыт
{
jq(this).parent("li").children("p.pane").slideDown(600); // открываем его
//jq(this).parent("li").children("p.pane").css('display','block');
}
	else {
    jq(this).parent("li").children("p.pane").slideUp(600); // закрываем если он открыт
    //jq(this).parent("li").children("p.pane").css('display','none');
    }
jq(this).toggleClass('current'); // переключаем класс
jq(this).parent("li").toggleClass('open'); // переключаем класс его родителя

});
/*
jq("#accordion<?echo "_$cat";?>").tabs("#accordion<?echo "_$cat";?> p.pane", {tabs: 'h2', effect: 'slide', initialIndex: -1, onClick: function(tabIndex){
var currPane = this.getCurrentPane();
currPane.click(function(){
jq(this).slideUp(300);
});
}});
*/
// additional open/close on click
/*
jq("#accordion<?echo "_$cat";?> .current").click(function(){
jq(this).removeClass('current').parent().removeClass('open').children('.pane').slideUp(300);});*/
});
</script>
<script>

// add new effect to the tabs
/*
jq.tools.tabs.addEffect("slide", function(i, done) {

	// 1. upon hiding, the active pane has a ruby background color
	this.getPanes().slideUp(300,function()  {
		jq(this).parent().removeClass('open');

		// the supplied callback must be called after the effect has finished its job
		done.call();
	});

	// 2. after a pane is revealed, its background is set to its original color (transparent)
	this.getPanes().eq(i).slideDown(600,function()  {
		jq(this).parent().addClass('open');

		// the supplied callback must be called after the effect has finished its job
		done.call();
	});
	
  	/*this.getPanes().eq(i).click(function() {
    jq(this).parent().removeClass('open');
    jq(this).slideUp(300);
    onClick.call();
  }); */
/*	
}); */ 
</script>
	<?
}            
function last_posts_ext($cat,$num = 10)
{

$args = array(
		'numberposts' => $num,
		'orderby' => 'date',
		'order' => 'DESC',
		'category_name' => $cat
	);
	$lastposts = get_posts($args);
	echo "<div>";
	//echo "<p>".$cat."</p>";
	if ($lastposts) {
		foreach ($lastposts as $post) {
		setup_postdata($post);
		?>
			<p class="tabs_post_date"><a href="<? echo get_permalink($post->ID);?>"><?echo $post->post_title;?></a><?//echo date("jS M Y",strtotime($post->post_date));#the_date("jS M Y");?></p>
			<?
			if($_src = p75GetThumbnail(get_the_ID()))
			{
?>			
<p class="tabs_post_pic"><a href="<? echo get_permalink($post->ID);?>"><img src="<?echo $_src;?>" /></a>
<?			
			}
			?>
			<p class="tabs_post_excerpt"><?echo $post->post_excerpt;?><br><a href="<? echo get_permalink($post->ID);?>">More</a></p>
			
		<?
		}
	}	
	echo "</div>";
} 
////////////////////// WIDGETS
class Bigtabs extends WP_Widget {
    /** constructor */
    function Bigtabs() {
	                $widget_ops = array('classname' => 'widget_text', 'cat' => 'Posts category');
	                //$control_ops = array('width' => 400, 'height' => 350);
	                $this->WP_Widget('Bigtabs', 'Big tabs', $widget_ops);
	        }
	
	        function widget( $args, $instance ) {
	                extract($args);
	                $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
	                $cat = apply_filters( 'widget_text', $instance['cat'], $instance );
	                echo $before_widget;

	                if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } 
	
	$args = array(
		'numberposts' => 5,
		'orderby' => 'date',
		'order' => 'DESC',
		'category_name' => $cat
	);
	
	$lastposts = get_posts($args);
	
	if ($lastposts) 
	{
					?>
					<h2>Our Brands</h2>
					<div class="Brands">
					<ul id="tabs" class="multiAreaNav">
					<?
					foreach ($lastposts as $post) 
					{
					setup_postdata($post);
					?>
						<li><a id="tab<?echo $post->ID?>" href="#"><? echo $post->post_title;?></a></li>
					<?
					}					
					?>
                    </ul>
					
                    <div id="panes" class="multiAreaContent">
					<?
					foreach ($lastposts as $post) 
					{
					setup_postdata($post);
					?>					
                        <div>
						<p>
						<?if(function_exists("p75GetThumbnail")) 
						{?>
						<img src="<? echo p75GetThumbnail($post->ID);?>">
						<?
						}
						echo $post->post_content;?>
						<br />
						<a href="<?echo get_permalink($post->ID);?>" class="readMore">Read More</a>
						</p>
						</div>
					<?
					}					
					?>						
						
                    </div>
					</div>
					<?
	}
	                echo $after_widget;
	        }
	
	        function update( $new_instance, $old_instance ) {
	                $instance = $old_instance;
	                $instance['title'] = strip_tags($new_instance['title']);
	                
	                $instance['cat'] =  $new_instance['cat'];
	               
	                return $instance;
	        }
	
	        function form( $instance ) {
	                $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'gid' => '' ) );
	                $title = strip_tags($instance['title']);
	                $cat = format_to_edit($instance['cat']);
	?>
	                <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
	                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
					<p><label for="<?php echo $this->get_field_id('cat'); ?>"><?php echo $this->widget_ops['cat']; ?></label>
	                <input class="widefat" id="<?php echo $this->get_field_id('cat'); ?>" name="<?php echo $this->get_field_name('cat'); ?>" type="text" value="<?php echo esc_attr($cat); ?>" /></p>

	<?php
	        }

}
add_action('widgets_init', create_function('', 'return register_widget("Bigtabs");'));

class Bottomgallery extends WP_Widget {
    /** constructor */
    function Bottomgallery() {
	                $widget_ops = array('classname' => 'widget_text', 'gid' => __('Gallery ID'));
	                //$control_ops = array('width' => 400, 'height' => 350);
	                $this->WP_Widget('Bottomgallery', __('Bottom gallery'), $widget_ops);
	        }
	
	        function widget( $args, $instance ) {
	                extract($args);
	                $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
	                $gid = apply_filters( 'widget_text', $instance['gid'], $instance );
	                echo $before_widget;

	                if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } 
					
					if (function_exists('nggShowGallery')) echo nggShowGallery($gid, "bottom"); else echo "no nggShowGallery function";

	                echo $after_widget;
	        }
	
	        function update( $new_instance, $old_instance ) {
	                $instance = $old_instance;
	                $instance['title'] = strip_tags($new_instance['title']);
	                
	                $instance['gid'] =  $new_instance['gid'];
	               
	                return $instance;
	        }
	
	        function form( $instance ) {
	                $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'gid' => '' ) );
	                $title = strip_tags($instance['title']);
	                $gid = format_to_edit($instance['gid']);
	?>
	                <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
	                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
					<p><label for="<?php echo $this->get_field_id('gid'); ?>"><?php _e('gid:'); ?></label>
	                <input class="widefat" id="<?php echo $this->get_field_id('gid'); ?>" name="<?php echo $this->get_field_name('gid'); ?>" type="text" value="<?php echo esc_attr($gid); ?>" /></p>

	<?php
	        }

}
add_action('widgets_init', create_function('', 'return register_widget("Bottomgallery");'));

class Infoblock extends WP_Widget {
    /** constructor */
    function Infoblock() {
	                $widget_ops = array('classname' => 'widget_text', 'gid' => __('Gallery ID'));
	                //$control_ops = array('width' => 400, 'height' => 350);
	                $this->WP_Widget('Infoblock', __('Infoblock'), $widget_ops);
	        }
	
	        function widget( $args, $instance ) {
	                extract($args);
	                $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
	                $gid = apply_filters( 'widget_text', $instance['gid'], $instance );
	                echo $before_widget;
					?>
				<div class="fltLft clr bdr mrgTop rightcolblock">
					<?
					echo $before_title;
	                if ( !empty( $title ) ) {  echo $title;  } 
					?>
					<div class="info_nav">
						<a class="prev browse left"></a>					
						<a class="next browse right"></a>
					</div>
					<?
					echo $after_title;?>

	                <?php 
					if (function_exists('nggShowGallery')) echo nggShowGallery($gid, "info"); else echo "no nggShowGallery function";
					?>
				</div>
					<?php
	                echo $after_widget;
	        }
	
	        function update( $new_instance, $old_instance ) {
	                $instance = $old_instance;
	                $instance['title'] = strip_tags($new_instance['title']);
	                
	                $instance['gid'] =  $new_instance['gid'];
	               
	                return $instance;
	        }
	
	        function form( $instance ) {
	                $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'gid' => '' ) );
	                $title = strip_tags($instance['title']);
	                $gid = format_to_edit($instance['gid']);
	?>
	                <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
	                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
					<p><label for="<?php echo $this->get_field_id('gid'); ?>"><?php _e('gid:'); ?></label>
	                <input class="widefat" id="<?php echo $this->get_field_id('gid'); ?>" name="<?php echo $this->get_field_name('gid'); ?>" type="text" value="<?php echo esc_attr($gid); ?>" /></p>

	<?php
	        }

}
add_action('widgets_init', create_function('', 'return register_widget("Infoblock");'));

class Tabs extends WP_Widget {
    /** constructor */
    function Tabs() {
	                //$widget_ops = array('classname' => 'widget_text');
	                $this->WP_Widget('Tabs', __('Tabs'));
	        }
	
	        function widget( $args, $instance ) {
	                extract($args);
	                $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

	                echo $before_widget;?>
	            <div class="multiArea mrgTop">    
<?	                if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>				
					<ul id="tabs_right" class="multiAreaNav">
                        <li><a href="#" id="tr1">News</a></li>
                        <li><a href="#" id="tr2">Info</a></li>
                        <li><a href="#" id="tr3">FAQ</a></li>
                    </ul>
					<div id="panes_right" class="multiAreaContent">
					<?php 
						last_posts_ext("News",2);						
						last_posts_ext("Info",2);						
						last_posts_ext("featured-faq");						
						//last_posts_by_cat_id_featured(5);
					?>					
					</div>
				</div>
	                <?php
	                echo $after_widget;
	        }
	
	        function update( $new_instance, $old_instance ) {
	                $instance = $old_instance;
	                $instance['title'] = strip_tags($new_instance['title']);
	                return $instance;
	        }
	
	        function form( $instance ) {
	                $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
	                $title = strip_tags($instance['title']);
	?>
	                <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
	                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
	<?php
	        }

}
add_action('widgets_init', create_function('', 'return register_widget("Tabs");'));

/**
 * YoutubeWidget Class
 */
class Youtube extends WP_Widget {
    /** constructor */
    function Youtube() {
	                $widget_ops = array('classname' => 'widget_text', 'code' => __('You tube code'));
	                $control_ops = array('width' => 400, 'height' => 350);
	                $this->WP_Widget('Youtube', __('Youtube'), $widget_ops, $control_ops);
	        }
	
	        function widget( $args, $instance ) {
	                extract($args);
	                $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
	                $code = apply_filters( 'widget_text', $instance['code'], $instance );
	                echo $before_widget;
					?>
				<div class="fltLft clr bdr mrgTop rightcolblock">
					<?
	                if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
	                <?php echo $code; ?>
				</div>
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

/*
Newsletter Widget class
*/
class Newsletter extends WP_Widget {
    /** constructor */
    function Newsletter() {
	                //$widget_ops = array('classname' => 'widget_text');
	                $this->WP_Widget('Newsletter', __('Newsletter'));
	        }
	
	        function widget( $args, $instance ) {
	                extract($args);
	                $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

	                echo $before_widget;
	                ?>
<div class="mrgTop fltLft clr">
  <?if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>

  	<?php if (class_exists('ajaxNewsletter')): ?>
    <!-- place your HTML code here -->
    <?php ajaxNewsletter::newsletterForm(); ?>
    <!-- place your HTML code here -->
    <?php endif; ?>

</div>
	                <?php
	                echo $after_widget;
	        }
	
	        function update( $new_instance, $old_instance ) {
	                $instance = $old_instance;
	                $instance['title'] = strip_tags($new_instance['title']);
	                return $instance;
	        }
	
	        function form( $instance ) {
	                $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
	                $title = strip_tags($instance['title']);
	?>
	                <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
	                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
	<?php
	        }

}
add_action('widgets_init', create_function('', 'return register_widget("Newsletter");'));

/**
 * Chat Widget Class
 */
class Chat extends WP_Widget {
    /** constructor */
    function Chat() {
	                $widget_ops = array('classname' => 'widget_text', 'code' => __('Chat code'));
	                $control_ops = array('width' => 400, 'height' => 350);
	                $this->WP_Widget('Chat', __('Chat'), $widget_ops, $control_ops);
	        }
	
	        function widget( $args, $instance ) {
	                extract($args);
	                $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
	                $code = apply_filters( 'widget_text', $instance['code'], $instance );
	                echo $before_widget;
					?>
				<div class="fltLft clr bdr mrgTop rightcolblock">
					<?
	                if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
	                <?php echo $code; ?>
				</div>
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
add_action('widgets_init', create_function('', 'return register_widget("Chat");')); 
// Latest news widget
function widget_blogposts($args) {
          extract($args);
      ?>
              <?php echo $before_widget; ?>
                  <?php echo $before_title
                      . ''
                      . $after_title; ?>
<?php
$args = array(
		'numberposts' => 6,
		'orderby' => 'date',
		'order' => 'DESC',
		'category_name' => 'blog'
	);
	$lastposts = get_posts($args);
	//print_r($lastposts);
	if ($lastposts) {
	?>
 <h2>Blog Posts</h2>
						<div class="firstCol">
								<div class="blogPost">
<?
$post = $lastposts[0];
setup_postdata($post);
?>                            	
								<h3><a href="<?echo get_permalink($post->ID);?>"><? echo $post->post_title;?></a></h3> 
								<span class="blogImg"><?if(function_exists("p75GetThumbnail")) {?>
<a href="<?echo get_permalink($post->ID);?>"><img src="<? echo p75GetThumbnail($post->ID);?>"></a><?}?></span>		
								<span class="txt"><?echo $post->post_excerpt;?></span>
								<br /><a href="<?echo get_permalink($post->ID);?>" class="readMore">Read More</a>
								</div>
                                
                            <div class="blogPost">
<?
$post = $lastposts[1];
setup_postdata($post);
?> 
								<h3><a href="<?echo get_permalink($post->ID);?>"><? echo $post->post_title;?></a></h3> 
                               	<span class="blogImg"><?if(function_exists("p75GetThumbnail")) {?>
<a href="<?echo get_permalink($post->ID);?>"><img src="<? echo p75GetThumbnail($post->ID);?>"></a><?}?></span>
								<span class="txt"><?echo $post->post_excerpt;?></span>
								<br /><a href="<?echo get_permalink($post->ID);?>" class="readMore">Read More</a>
							</div>
<div class="most_recent_posts">Most Recent Posts</div>							
							<ul class="recentPostLinks">
<?
for ($i = 3; $i<6; $i++)
{
	$post = $lastposts[$i];
	setup_postdata($post);
?>
								<li><a href="<?echo get_permalink($post->ID);?>"><? echo $post->post_title;?></a></li>
<?
}
?>								
							</ul>
                                
                               
                            
                    </div>
					
					<div class="secondCol">
<?
$post = $lastposts[2];
setup_postdata($post);
?> 					
						<span class="blogImgBig"><?if(function_exists("p75GetThumbnail")) {?>
<a href="<?echo get_permalink($post->ID);?>"><img src="<? echo p75GetThumbnail($post->ID);?>"><a><?}?></span>
						<h3><a href="<?echo get_permalink($post->ID);?>"><? echo $post->post_title;?></a></h3> 
						<span class="txt"><?echo $post->post_excerpt;?></span>
						<br /><a href="<?echo get_permalink($post->ID);?>" style="margin-right:10px;" class="readMore">Read More</a>
					</div>
	<?
	}              
?>              
			  <?php echo $after_widget; ?>
      <?php
}

register_sidebar_widget('Blog Posts Widget', 'widget_blogposts');


/////////////////// SIDEBARS	  
// Latest news widget END
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'sidebar',
		'before_widget' => '<div class="%2$s %1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
}
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Blog posts',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	));
}
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Homepage posts',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	));
}
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'footer_left',
		'before_widget' => '<div class="fltLft com30">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
}
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'footer_center',
		'before_widget' => '<div class="fltLft com30 mrgBth">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
}
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'footer_right',
		'before_widget' => '<div class="fltLft com30">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
}
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'footer_gallery',
		'before_widget' => '<div class="icons mrgTop">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
}
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'contact_sidebar',
		'before_widget' => '<div class="%2$s %1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
}

// admin menu chat button
add_action('admin_menu', 'pl_admin_menu');
function pl_admin_menu()
{
$role = get_role('administrator');
if(!$role->has_cap('use_chat'))
{
  $role->add_cap('use_chat');
  $view_level= 'administrator';
}
	$chat_page = get_bloginfo('template_url').'/chat_page.php';
	add_menu_page('Chat','Chat', 'use_chat', $chat_page,'pl_chat',get_bloginfo('template_url').'/img/chat.png');
}
function pl_chat()
{
	?>
	<div class="chatwindow">
		<iframe width="100%" height="500" src="http://www.chat.webtrendz.co.uk/interpartners/setup/login.php"></iframe>
	</div>
	<?
}

/// WTZ part for content filtering for showing accordions
add_filter('the_content','pl_content_filter');
function pl_content_filter($content)
{

	$exprs = array('/\[accordion([\s]+)([a-zA-Z0-9_]+)\]/', '/\[last-post([\s]+)([a-zA-Z0-9_-]+)\]/'); // to find
	foreach ($exprs as $expr) 
  {	

		if (preg_match_all($expr, $content, $params,PREG_PATTERN_ORDER))
		{
			//print_r($params);
		  foreach ($params[2] as $param)
		  {
    	switch ($expr)
      {
        case '/\[accordion([\s]+)([a-zA-Z0-9_]+)\]/':
        $content = str_replace("[accordion $param]", pl_parse_params($param), $content);
        break;
        case '/\[last-post([\s]+)([a-zA-Z0-9_-]+)\]/':
        $content = str_replace("[last-post $param]",last_posts($param,1,true),$content);
        break;
      }
		  }
    }

	}
	return $content;
}

function pl_parse_params($param)
{
	$result = last_posts_accordion($param);
	return $result;
}

//3rd
function selfURL() 
{ 
	$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : ""; 
	$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; 
	$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]); 
	return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI']; 
} 

function strleft($s1, $s2) 
{ 
	return substr($s1, 0, strpos($s1, $s2)); 
}
?>