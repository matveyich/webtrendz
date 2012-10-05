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
/*
?>			

<div class="img_carousel">
<!-- "previous page" action -->
<a class="prev browse left"></a>

<!-- root element for scrollable -->
<div class="scrollable" id=carousel>	

<ul class="items">

	<?php
	
	foreach ( $images as $image ) : 
	
	?>
	
	<?php if ( !$image->hidden ) 
{ ?>
			
			<li>
<div class="inside">
	<? if (isset($image->ngg_custom_fields["Link"])) {
	$pic_page_id = explode("=",$image->ngg_custom_fields["Link"]);
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
	
	<? if (isset($image->ngg_custom_fields["Link"])) {?>
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
<a class="next browse right"></a>
<!-- wrapper for navigator elements -->
<div class="navi" id=navigation></div>
<br clear="all" />
</div>
<!-- javascript coding -->
<script>
jq(document).ready(function() {

jq("#carousel").scrollable({
	circular: true,
	}).navigator('#navigation');	

});
</script>

<? */	?>
 
 
<div id="ja-slideshow"><!--ja-slideshow-->
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ja_contentslide.css" type="text/css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ja.css" type="text/css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ja_002.css" type="text/css">
	
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/mootools.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/caption.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/ja_contentslide.js"></script>

<script src="<?php bloginfo('template_url'); ?>/js/ja_004.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_url'); ?>/js/ja.js" type="text/javascript"></script>



                <div class="ja-slidewrap" id="ja-slide-44" style="visibility: visible;">
                    <div style="width: 640px; height: 300px;" class="ja-slide-main-wrap">
                        <div class="ja-slide-main">
                          <?php
              //WTZ FIX
	$flink = "urls:[";
	foreach ( $images as $image ) {
	if ( !$image->hidden ) {
printf ('
	<div style="width: 640px; height: 300px; position: absolute; left: 0px; top: 0px; display: none; visibility: hidden; opacity: 0; z-index: 9;" class="ja-slide-item">
		<a href="'.$image->ngg_custom_fields["Link"].'" target="_blank"><img src="'.$image->imageURL.'" alt="'.$image->alttext.'" /></a>
	</div>');
	$flink .= "'".$image->ngg_custom_fields["Link"]."',";	
	}
	}
	$flink .= "],";	
              // WTZ FIX END
              ?>
                        </div>
                        <div style="display: block; position: absolute; top: 0px; left: 0px; width: 640px; height: 300px; visibility: visible; opacity: 0.01;" class="maskDesc">
                            <div class="inner"><a href="#" class="readon" title=""><span>Readmore</span></a></div>
							<?php
              //WTZ FIX
	foreach ( $images as $image ) {
		if ( !$image->hidden ) {
printf ('
	<div class="ja-slide-desc">
		<h3>'.$image->alttext.'</h3>
		<br />
		<p>'.htmlspecialchars_decode($image->description).'</p>
	</div>
	');
    }
	}
                //mysql_free_result($ban);
              // WTZ FIX END
              ?>
                        </div>
                    </div>
                    <div class="ja-slide-descs"></div>
                    <div class="ja-slide-mask"></div>
                    <div style="min-width: 42px; height: 42px;" class="ja-slide-thumbs-wrap">
                      <div style="left: 0px;" class="ja-slide-thumbs">
                           <?php
              //WTZ FIX
	$thumbcount = 0;
	foreach ( $images as $image ) {
	if ( !$image->hidden ) {
printf ('
	<div style="width: 42px; height: 42px;" class="ja-slide-thumb">
		<img src="'.$image->thumbURL.'" alt="'.$image->alttext.'" />
    </div>');
	$thumbcount++;
	}
	}
              // WTZ FIX END
              ?>
                      </div>
                        <div style="left: -2000px; width: 5000px;" class="ja-slide-thumbs-mask">
                          <span style="height: 42px; width: 2000px; visibility: visible; opacity: 0.8;" class="ja-slide-thumbs-mask-left">&nbsp;</span>
                            <span style="height: 42px; width: 42px; visibility: visible; opacity: 0.8;" class="ja-slide-thumbs-mask-center">&nbsp;</span>
                            <span style="height: 42px; width: 2000px; visibility: visible; opacity: 0.8;" class="ja-slide-thumbs-mask-right">&nbsp;</span>
                            <span style="height: 42px; width: 42px; visibility: visible; opacity: 0.8;" class="ja-slide-thumbs-mask-right">&nbsp;</span>
                            <span style="height: 42px; width: 2000px; visibility: visible; opacity: 0.8;" class="ja-slide-thumbs-mask-left">&nbsp;</span>
                            <span style="height: 42px; width: 42px; visibility: visible; opacity: 0.8;" class="ja-slide-thumbs-mask-center">&nbsp;</span>
                            <span style="height: 42px; width: 2000px; visibility: visible; opacity: 0.8;" class="ja-slide-thumbs-mask-right">&nbsp;</span>
                            <span style="height: 42px; width: 42px; visibility: visible; opacity: 0.8;" class="ja-slide-thumbs-mask-right">&nbsp;</span>
                            <span style="height: 42px; width: 2000px; visibility: visible; opacity: 0.8;" class="ja-slide-thumbs-mask-right">&nbsp;</span>
                            <span style="height: 42px; width: 42px; visibility: visible; opacity: 0.8;" class="ja-slide-thumbs-mask-right">&nbsp;</span>

                        </div>
                        <p style="left: 0px;" class="ja-slide-thumbs-handles">
                          <span class="" style="width: 42px; height: 42px;">&nbsp;</span>
                          <span class="" style="width: 42px; height: 42px;">&nbsp;</span>
                          <span class="" style="width: 42px; height: 42px;">&nbsp;</span>
                          <span class="" style="width: 42px; height: 42px;">&nbsp;</span>
                          <span class="" style="width: 42px; height: 42px;">&nbsp;</span>
                          <span class="" style="width: 42px; height: 42px;">&nbsp;</span>
                          <span class="" style="width: 42px; height: 42px;">&nbsp;</span>
                          <span class="" style="width: 42px; height: 42px;">&nbsp;</span>
						  <span class="" style="width: 42px; height: 42px;">&nbsp;</span>
                          <span class="active" style="width: 42px; height: 42px;">&nbsp;</span>
                        </p>
                    </div>
                </div>
                <script type="text/javascript">
              window.addEvent('load', function(){
                new JASlideshow2('ja-slide-44', {
                            startItem: 0,
                            showItem: <?echo $thumbcount;?>,
                            itemWidth: 42,
                            itemHeight: 42,
                            mainWidth: 600,
                            mainHeight: 300,
                            duration: 300,
                            transition: Fx.Transitions.quadOut,
                            animation: 'fade',
                            thumbOpacity:0.8,
                            maskOpacity: 0.8,
                            buttonOpacity: 0.6,
                            showDesc: 'desc-readmore',
                            descMode: 'mouseover',
                            readmoretext: 'Readmore',
                            overlap: 0,
                            navigation:'thumbs',
                            <?php echo $flink ?>
                                            autoPlay: 1,
                                            interval: 7000              });
              });
            </script>
</div><!--/ja-slideshow-->

<?endif;?>