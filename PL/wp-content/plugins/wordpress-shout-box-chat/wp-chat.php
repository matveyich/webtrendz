<?php   
/**
 * @package Wordpress Shout Box / Chat
 * @author Shaon
 * @version 1.4
 */
/*
Plugin Name: Wordpress Shout Box / Chat
Plugin URI: http://www.intelisoftbd.com/open-source-projects/wordpress-shout-box-chat-plugin.html
Description: This plugin can be used to communicate among the online visitor on a wordpress site. Simple use `WP Chat` widget from your widgets. If your theme is not widget ready then use `&lt;?php wp_chat(); ?&gt;` anywhere in sidebar you want to place chat box.
Author: Shaon
Version: 1.4
Author URI: http://www.intelisoftbd.com/open-source-projects/wordpress-shout-box-chat-plugin.html
*/
                    


class WP_Chat extends WP_Widget {
    
    function WP_Chat() {
            update_option('cht_border_thickness', 1);
            update_option('cht_border_color', '444444');
            update_option('cht_border_radius', 5);    
        parent::WP_Widget(false, $name = 'WP Chat');    
    }

    
    function widget($args, $instance) {        
        extract( $args );
        ?>
        
        <style>
#chatboard{
    border:2px solid #444444;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    background: #FFFFFF;
    color: #0000;
    padding:3px;
    font:9pt 'Segoe UI';
}
#ctitle{
    background: #444444;
    color: #FFFFFF;
    padding: 5px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
}
#msgs div{
    clear:both;
    border-bottom: 1px solid #EEEEEE;
    line-height: 30px;
}
#msg {padding:3px;}
#msgs fieldset{
    border:1px solid #EEEEEE;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    margin-top:3px;
}
#msgs legend{
 background: #333333;;
 padding:2px 5px 2px 5px;
 font-size:10px;
 -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
 color: #FFFFFF;
}


.jScrollPaneContainer {
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.jScrollPaneTrack {
    position: absolute;
    cursor: pointer;
    right: 0;
    top: 0;
    height: 100%;
    background: #aaa;
}
.jScrollPaneDrag {
    position: absolute;
    background: #666;
    cursor: pointer;
    overflow: hidden;
}
.jScrollPaneDragTop {
    position: absolute;
    top: 0;
    left: 0;
    overflow: hidden;
}
.jScrollPaneDragBottom {
    position: absolute;
    bottom: 0;
    left: 0;
    overflow: hidden;
}
a.jScrollArrowUp {
    display: block;
    position: absolute;
    z-index: 1;
    top: 0;
    right: 0;
    text-indent: -2000px;
    overflow: hidden;
    /*background-color: #666;*/
    height: 9px;
}
a.jScrollArrowUp:hover {
    /*background-color: #f60;*/
}

a.jScrollArrowDown {
    display: block;
    position: absolute;
    z-index: 1;
    bottom: 0;
    right: 0;
    text-indent: -2000px;
    overflow: hidden;
    /*background-color: #666;*/
    height: 9px;
}
a.jScrollArrowDown:hover {
    /*background-color: #f60;*/
}
a.jScrollActiveArrowButton, a.jScrollActiveArrowButton:hover {
    /*background-color: #f00;*/
}
</style>
        
        <?php
        $title = get_option('chat_title');
               echo $before_widget;  
              if ( $title )
                        echo $before_title . $title . $after_title; 
                        include(dirname(__FILE__)."/chat.php");
                        echo $after_widget; 
        
    }

 
    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {                
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {                
        $title = esc_attr($instance['title']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <?php 
    }


} // class FooWidget


function wp_chat(){
    WP_Chat::widget(array(),'');
}
    
add_action('widgets_init', create_function('', 'return register_widget("WP_Chat");'));

?>