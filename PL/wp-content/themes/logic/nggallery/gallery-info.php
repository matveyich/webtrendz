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
			
			<div class="scrollable_info" id="carousel_info">
				<ul class="items_info" id="images_info">
<?php
$i = 0;
foreach ( $images as $image ) : 
if ( !$image->hidden ) 
{
?>					
					<li>
<? if (isset($image->ngg_custom_fields["Link"]) && $image->ngg_custom_fields["Link"] != "") 
	{?>
	<a href="<?php echo $image->ngg_custom_fields["Link"];?>">
<?	} ?>						
						<img src="<?php echo $image->imageURL ?>" />
						
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

<?/*?>
			
			<div class="navi_info" id="navigation_info">
<?php 
$i = 0;
foreach ( $images as $image ) : 
if ( !$image->hidden ) 
{
?>			
				
<?php 
}
endforeach; ?>				
			</div>
<?*/?>
<script>
jq(function() {
jq("#carousel_info").scrollable({disabledClass: 'disabled', circular: true})<?if (nggcf_get_gallery_field($gallery->ID, "autoplay") == "yes") echo ".autoscroll({ autoplay: true })";?>;
}
);
</script>
<?php endif; ?>
