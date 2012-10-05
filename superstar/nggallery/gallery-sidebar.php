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
<div class="subCol">
		<h3>Views of <?echo $post-post_title;?></h3>
			<ul class="grid teaser">
<?php
$i = 0;
foreach ( $images as $image ) : 
if ( !$image->hidden ) 
{
?>					
		<li>
<? if (isset($image->ngg_custom_fields["Link"]) && $image->ngg_custom_fields["Link"] != "") 
	{?>
	<a href="<?php echo $image->imageURL ?>" title="<?echo $image->description;?>">
<?	} ?>
						
		<img src="<?php echo $image->imageURL ?>" alt="<?echo $image->description;?>" border="0" class="lightbox"/>
						
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
<!--EndOfSlideShow-->	
<? endif;?>