<?
//////////// widgets

class maingallery extends WP_Widget {
    /** constructor */
    function maingallery() {
	                $widget_ops = array('classname' => 'widget_text', 'gid' => __('Gallery ID'));
	                //$control_ops = array('width' => 400, 'height' => 350);
	                $this->WP_Widget('maingallery', __('Main gallery'), $widget_ops);
	        }
	
	        function widget( $args, $instance ) {
	                extract($args);
	                $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
	                $gid = apply_filters( 'widget_text', $instance['gid'], $instance );
	                echo $before_widget;

	                if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } 
					
					if (function_exists('nggShowGallery')) echo nggShowGallery($gid, "main"); else echo "no nggShowGallery function";

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
add_action('widgets_init', create_function('', 'return register_widget("maingallery");'));

///////////// sidebars

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'left sidebar',
		'before_widget' => '
		<div class="brochureDownload">
              <div class="header"></div>
              <div class="content">',
		'after_widget' => '
			  </div>
              <div class="footer"></div>
            </div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));	
	register_sidebar(array(
		'name' => 'main gallery sidebar',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));	
	register_sidebar(array(
		'name' => 'special offers sidebar',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2 class=clear>',
		'after_title' => '</h2>',
	));
	register_sidebar(array(
		'name' => 'homepage bottom sidebar',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2 class=clear>',
		'after_title' => '</h2>',
	));
}
?>