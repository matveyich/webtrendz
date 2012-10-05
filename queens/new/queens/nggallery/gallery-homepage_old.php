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
?>	
<script src="<?bloginfo('template_url'); ?>/js/home/index.js" type="text/javascript"></script>

<script src="<?bloginfo('template_url'); ?>/js/home/slide.js" type="text/javascript"></script>

<script type="text/javascript"> 
var slideShowSpeed = 5000;
var crossFadeDuration = 12;
var Pic = new Array();
<?php 
$i = 0;
foreach ( $images as $image ) : 

if ( !$image->hidden ) 
{?>
Pic[<?echo $i?>] = '<?php echo $image->imageURL ?>'
<?
$i++;
}
endforeach; ?>	 
var t;
var j = 0;
var p = Pic.length;
 
var preLoad = new Array();
 
for (i = 0; i < p; i++) {
   preLoad[i] = new Image();
   preLoad[i].src = Pic[i];
}
</script>


<div id="imagescroller">

	<img id="SlideShow" alt="" src="">
				
</div>	
			
<?php endif; ?>