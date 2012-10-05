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
	 <div class="ja-moduletable moduletable_tabs  clearfix fog_box" id="Mod_fog">
                <div class="ja-box-ct clearfix fog_box_inner">	
				
<li id="fog" class="widget widget_text">
<!-- fog stands for free online games -->
<h3 class="clearfix">
<?echo $gallery->title;?>
</h3>

<div class="ja-box-ct clearfix">
	<div class="textwidget">

<div class="freeGames">	
	<?php
	foreach ( $images as $image ) : ?>
	
	<?php if ( !$image->hidden ) 
{ //print_r($image);
?>
			
<div class="featured_review">
<div class="featured_review_title">
	<a rel="<?php if (isset($image->ngg_custom_fields["Link"])) echo "#fog_overlay";?>" link="<? echo $image->ngg_custom_fields["Link"];?>">
		<? echo $image->alttext;?>
	</a>
</div>
	
	<a rel="<?php if (isset($image->ngg_custom_fields["Link"])) echo "#fog_overlay";?>" link="<? echo $image->ngg_custom_fields["Link"];?>">
		<img title="<?php echo $image->alttext ?>" alt="<?php echo $image->alttext ?>" src="<?php echo $image->imageURL; ?>" />
	</a>
	<? 
	if (isset($image->description)&&($image->description != " ")) 
	{?>
	<div class="featured_review_text">
	<? 
		// shows edited text in html
		echo str_replace("href", "style=\"cursor:pointer\" rel", htmlspecialchars_decode($image->description)); 
	?>
	</div>
	<?}?>
	<div class="featured_review_bottom">
		<a class="readon" rel="<?php if (isset($image->ngg_custom_fields["Link"])) echo "#fog_overlay";?>" link="<? echo $image->ngg_custom_fields["Link"];?>">
		Play now
		</a>
	</div>
	

</div>
			
	<?php
} ?>
	<?php if ( $image->hidden ) continue; ?>
	
 	<?php endforeach; ?>

</div>

	</div>
</div>
</li>
                </div>
              </div>	

<script>

jq(function() {

	jq("#fog a[rel]").overlay({mask: '#000',fixed:true,oneInstance: true,onBeforeLoad: function() {var wrap = this.getOverlay().find("#dataframe");wrap.attr('src', this.getTrigger().attr("link"));}});
});
</script>
<?endif;?>