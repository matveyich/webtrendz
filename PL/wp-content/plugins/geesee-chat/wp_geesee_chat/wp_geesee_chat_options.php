<?php
/*
Description: GeeSee Chat options
*/

		
$plugin_location = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'wp_geesee_chat.php';
$plugin_data = get_plugin_data($plugin_location);
$location = get_option('siteurl') . '/wp-admin/admin.php?page=wp_geesee_chat/wp_geesee_chat_options.php'; // Form Action URI

/*Lets add some default options if they don't exist*/
add_option('geesee_chat_width', 500);
add_option('geesee_chat_height', 500);
add_option('geesee_chat_default_room', 'WordPress Geesee chat plugin');

/*check form submission and update options*/
if ('process' == $_POST['stage'])
{
	update_option('geesee_chat_width', $_POST['geesee_chat_width']);
	update_option('geesee_chat_height', $_POST['geesee_chat_height']);
	update_option('geesee_chat_default_room', $_POST['geesee_chat_default_room']);
}

/*Get options for form fields*/
$gc_width = stripslashes(get_option('geesee_chat_width'));
$gc_height = stripslashes(get_option('geesee_chat_height'));
$gc_default_room = stripslashes(get_option('geesee_chat_default_room'));

?>
<div class="wrap">
  <h2><?php _e('Geesee chat options', 'geesee_chat') ?></h2>
  <form name="form1" method="post" action="<?php echo $location ?>&amp;updated=true">
	<input type="hidden" name="stage" value="process" />
    <table width="100%" cellspacing="2" cellpadding="5" class="editform">
      <tr valign="top">
        <th scope="row"><?php _e('Width:') ?></th>
        <td><input name="geesee_chat_width" type="text" id="geesee_chat_width" value="<?php echo $gc_width; ?>" size="50" />
        <br />
<?php _e('This is Geesee chat width in pixels. <b>The minimum widht is 470px</b>. If you enter a lower width, the minimum width is used.', 'wpcf') ?></td>
      </tr>
      <tr valign="top">
        <th scope="row"><?php _e('Height:') ?></th>
        <td><input name="geesee_chat_height" type="text" id="geesee_chat_height" value="<?php echo $gc_height; ?>" size="50" />
        <br />
<?php _e('This is Geesee chat height in pixels. <b>The minimum height is 460px</b>. If you enter a lower height, the minimum height is used.', 'wpcf') ?></td>
      </tr>
      <tr valign="top">
        <th scope="row" width="130"><?php _e('Default chat room name:') ?></th>
        <td><input name="geesee_chat_default_room" type="text" id="geesee_chat_default_room" value="<?php echo $gc_default_room; ?>" size="50" />
        <br />
<?php _e('This is the name of a default chat room, which will open upon Geesee start. You can <a href="http://www.geesee.com/chat/live-chat.aspx" target="_blank">search for chat room names directly in any Geesee chat</a>. If you enter an invalid room name, the chat room with default name (Geesee WordPress Plugin) will open.', 'wpcf') ?></td>
      </tr>
      <tr valign="top">
        <th scope="row"><?php _e('Page/Post usage:') ?></th>
        <td><?php _e('To add Geesee chat into your page or post body, simply click on the "Add Geesee chat" button above the text editor, while you are craeting or editing page or post.', 'wpcf') ?></td>
      </tr>
      <tr valign="top">
        <th scope="row"><?php _e('Sidebar usage:') ?></th>
        <td><?php _e('To add Geesee chat link to your sidebar, add the following code into the sidebar.php of your current WordPress theme on a place, where you want the link to appear.<br /><br />' . htmlspecialchars('<?php wp_add_geesee_chat(); ?>'), 'wpcf') ?></td>
      </tr>
      <tr valign="top">
        <th scope="row"><?php _e('Plugin version:') ?></th>
        <td><?php _e($plugin_data['Version'] . '<br />Please check <a href="http://geesee.com/provide/plugins.aspx" target="_blank">Geesee plugins page</a> for the latest plugin version. If you have any problems with the plugin, please contact Geesee <a href="http://geesee.com/provide/support.aspx" target="_blank">customer support</a>.', 'wpcf') ?></td>
      </tr>
     </table>
    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Update Options', 'geesee_chat') ?> &raquo;" />
    </p>
  </form>
</div>
?>