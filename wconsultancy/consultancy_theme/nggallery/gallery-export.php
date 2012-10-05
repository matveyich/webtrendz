<?php
/**
Template Page for the gallery overview

Follow variables are useable :

	$gallery     : Contain all about the gallery
	$images      : Contain all images, path, title
	$pagination  : Contain the pagination content

 You can check the content when you insert the tag <?php var_dump($variable) ?>
 If you would like to show the timestamp of the image ,you can use <?php echo $exif['created_timestamp'] ?>
**/
?>
<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><?php if (!empty ($gallery)) :
	//print_r($gallery);
	global $wpdb,$table_prefix;
	$gal_path = $wpdb->get_var('SELECT path FROM '.$table_prefix.'ngg_gallery WHERE gid='.$gallery->ID);
?>
<?php foreach ( $images as $image ) :
if ( !$image->hidden )
{
?><Image Filename="<?php echo $gal_path.'/'.$image->filename ?>">
    <Text>
      <headline><? echo $image->alttext;?></headline>
      <break></break>
      <paragraph><? echo htmlspecialchars_decode($image->description);?></paragraph>
      <break></break>
    </Text>
  </Image><?php
}
endforeach; ?>
<?php endif; ?>