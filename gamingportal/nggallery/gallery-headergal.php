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
<!-- "previous page" action -->
<a class="prevPage browse left"></a>

<!-- root element for scrollable -->
<div class="scrollable" id=carousel>	

<ul class="items">
	
	<?php
	foreach ( $images as $image ) : ?>
	
	<?php if ( !$image->hidden ) 
{ ?>
			
			<li>
<div class="inside">
	<? if (isset($image->ngg_custom_fields["Link to"])) {
	$pic_page_id = explode("=",$image->ngg_custom_fields["Link to"]);
	$pic_lnk = get_permalink($pic_page_id[1]);
	?>
	<a href="<?php echo $pic_lnk;?>" title="<?php #echo $image->description ?>" <?php echo $image->thumbcode ?> >
	<? } ?>

	<img title="<?php echo $image->alttext ?>" alt="<?php echo $image->alttext ?>" src="<?php echo $image->imageURL; ?>" />
	
	<? if (isset($image->description)&&($image->description != " ")) {?>
	<div class="descr">
		<div class="container">
			<div class="inner">
			<h1>
			<? echo $image->alttext;?>
			</h1>
			<? 
			// shows edited text in html
			echo htmlspecialchars_decode($image->description); ?>
			<p>
			<input type="button" value="more" onClick="location.href='<?php echo $pic_lnk;?>'">
			</p>
			</div>
		</div>
	</div>
	<?}?>
	
	<? if (isset($image->ngg_custom_fields["Link to"])) {?>
	</a> 
	<? } ?>
</div>
			</li>
			
	<?php
} ?>
	<?php if ( $image->hidden ) continue; ?>
	
 	<?php endforeach; ?>

</ul>
</div>

<!-- "next page" action -->
<a class="nextPage browse right"></a>
<!-- wrapper for navigator elements -->
<div class="navi" id=navigation></div>
<br clear="all" />

<!-- javascript coding -->
<script>
// What is $(document).ready ? See: http://flowplayer.org/tools/using.html#document_ready
jq(document).ready(function() {

// heeeeeeeeeeere we go.
jq("#carousel").scrollable({vertical:false, hoverClass: 'hover', size:1, clickable:false}).circular().navigator("#navigation");	
});
</script>
<?endif;?>