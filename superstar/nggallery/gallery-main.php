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
			
<!--BeginOfSlideShow-->			  
<div id="scrollContentArea">
 <div id="content">
 <div id="slider">
	<ul>
<?php
$i = 0;
foreach ( $images as $image ) : 
if ( !$image->hidden ) 
{
?>					
		<li>
<? if (isset($image->ngg_custom_fields["Link"]) && $image->ngg_custom_fields["Link"] != "") 
	{?>
	<a title="<?echo $image->alttext;?>" href="<?php echo $image->ngg_custom_fields["Link"];?>">
<?	} ?>
						
		<img src="<?php echo $image->imageURL ?>" tppabs="<?php echo $image->imageURL ?>" alt="<?echo $image->alttext;?>" />
						
<? if (isset($image->ngg_custom_fields["Link"]) && $image->ngg_custom_fields["Link"] != "") 
	{?>
	</a>
<?	} ?>							
					
		</li>
<?php 
}
endforeach; ?>					
					
        </ul>
     </div>
       <p id="controls"><span id="prevBtn"><a href="javascript:void(0);">Previous</a></span> 
	   					<span id="nextBtn"><a href="javascript:void(0);">Next</a></span></p>
   </div>
</div>
<!--EndOfSlideShow-->	
<? endif;?>