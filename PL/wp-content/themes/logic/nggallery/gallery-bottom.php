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

<ul>

	
	<!-- Thumbnails -->
	<?php 
$imgs_num = count($images);
$i = 1;	
	foreach ( $images as $image ) : ?>

	<li<?if ($i==$imgs_num) {echo " class=last";} if (1==$i) {echo " class=first";} $i++;?>>

			<?php if ( !$image->hidden ) { ?>
			<? if (isset($image->ngg_custom_fields["Link"]) && $image->ngg_custom_fields["Link"] != "") {?>
			<a href="<?php echo $image->ngg_custom_fields["Link"]; ?>" title="<?php echo $image->description ?>">
			<?} else {?>
			<a href="<?php echo $image->imageURL ?>" title="<?php echo $image->description ?>" <?php echo $image->thumbcode ?> >
				<?}?>
				<img title="<?php echo $image->alttext ?>" alt="<?php echo $image->alttext ?>" src="<?php echo $image->imageURL ?>" <?php #echo $image->size ?> />
				
			</a>
			<?php } ?>

	</li>
	
	<?php if ( $image->hidden ) continue; ?>

 	<?php endforeach; ?>
 	
	<!-- Pagination -->
 	<?php echo $pagination ?>
 	
</ul>
	<!-- overlayed element -->

<div class="simple_overlay" id="fog_overlay">

	<!-- the external content is loaded inside this tag -->
	<div class="contentWrap">
	<iframe id="dataframe" src="" frameborder=0 width=752 height=560></iframe>
	</div>

</div>

<?php endif; ?>