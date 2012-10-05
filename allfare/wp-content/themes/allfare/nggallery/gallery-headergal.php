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
<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><?php if (!empty ($gallery)) : ?>

	

	
	<?php
	foreach ( $images as $image ) : ?>
	<?if (isset($image->ngg_custom_fields["Link to"])) $piclink = $image->ngg_custom_fields["Link to"]; else $piclink = "#";?>
	<?php if ( !$image->hidden ) 
{ ?>
						<li>
							<a class="thumb" name="leaf" href="<?php echo $image->imageURL; ?>" wtz_lnk="<?echo $piclink;?>" title="<?php echo $image->description ?>">
								<img src="<? bloginfo('template_url');?>/images/img-off.png" alt="<?php echo $image->description ?>" width="17" height="17" border="0" />							
                            </a>
							<div class="caption">
								
								<div class="image-title"><?php echo $image->description ?></div>
								<!-- <div class="image-desc">Description</div> -->
							</div>						
						</li>
	<?php
} ?>
	<?php if ( $image->hidden ) continue; ?>
	
 	<?php endforeach; ?>


<?php endif; ?>