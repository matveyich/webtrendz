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

<div class="scroller">
			
			<div class="scrollable" id="carousel">
				<ul class="items" id="images">
<?php foreach ( $images as $image ) : 
if ( !$image->hidden ) 
{
?>					
					<li id="<?php echo $image->pid ?>">
<? if (isset($image->ngg_custom_fields["Link"]) && $image->ngg_custom_fields["Link"] != "") 
	{/*?>
	<a href="<?php echo $image->ngg_custom_fields["Link"];?>">
<?	*/} ?>						
						<img src="<?php echo $image->imageURL ?>" />
						
						<div class="caption">
							<div class="container">
								<div class="inner">
								
								<strong><? echo $image->alttext;?></strong>
			<? 
			// shows edited text in html
			echo '<span>'.htmlspecialchars_decode($image->description).'</span>'; ?>
			<? if (isset($image->ngg_custom_fields["Link"]) && $image->ngg_custom_fields["Link"] != "") {?>
			
			
			<a href="<?php echo $image->ngg_custom_fields["Link"];?>" class="readMore" alt="<?echo htmlspecialchars_decode($image->description);?>">Find out more</a>
			
			<?}?>
								</div>
							</div>
						</div>
<? if (isset($image->ngg_custom_fields["Link"]) && $image->ngg_custom_fields["Link"] != "") 
	{/*?>
	</a>
<?	*/} ?>							
					
					</li>
<?php 
}
endforeach; ?>					
					
				</ul>
			</div>	
</div>			
<div class="scrollNav">
			
			<ul id="navigation">
<?php 
$imgs_num = count($images);
$i = 1;
foreach ( $images as $image ) : 
if ( !$image->hidden ) 
{
if ($i==$imgs_num) {$_class="last";} if (1==$i) {$_class="first";} $i++;
?>			
			<li class="<?echo $_class;?>">	
				<a class="<?echo $_class;?>" href="<?php if (isset($image->ngg_custom_fields["Link"]) && $image->ngg_custom_fields["Link"] != "") echo $image->ngg_custom_fields["Link"]; else echo "#"?>" rel="<?php echo $image->pid ?>"><?echo $image->alttext;?></a>
			</li>	
<?php 
}
endforeach; ?>				
			</ul>
</div>
			

<script>

$(document).ready(function() {

// initialize galleries, hide all apart from the 1st ones
$("#images, #info_images").children().hide();
$("#images").children(":first").show();
$("#navigation li:first a").addClass("current");
$("#info_images").children(":first").show();

// another autoplay thing
var stop;
stop_gal = false;
var curr;
curr = 0;
var delay;
delay = 5000;

	
// work with galleries' buttons
$("#navigation a").mouseover(function() {
	$("#navigation li a").each(function(){$(this).removeClass("current");});
	$(this).addClass("current");
	if ($("#images #" + this.rel).css("display") == "none") {$("#images").children().fadeOut();$("#images #" + this.rel).fadeIn();}
	//$("#debug").html("stop_gal="+stop_gal+" mouseover");	
	
	// autoplay things
	stop_gal = true;
	curr = $(this).parent().index();
	});

// autoshow thing

<?
if (nggcf_get_gallery_field($gallery->ID, "autoplay") == "yes") 
{
?>
    $.fn.wait = function(option, options) {
		milli = 1000; 
        if (option && (typeof option == 'function' || isNaN(option)) ) { 
            options = option;
        } else if (option) { 
            milli = option;
        }
        // set defaults
        var defaults = {
            msec: milli,
            onEnd: options
        },
        settings = $.extend({},defaults, options);

        if(typeof settings.onEnd == 'function') {
            this.each(function() {
                setTimeout(settings.onEnd, settings.msec);
            });
            return this;
        } else {
            return this.queue('fx',
            function() {
                var self = this;
                setTimeout(function() { $.dequeue(self); },settings.msec);
            });
        }

    }
	
$("#navigation a").mouseout(function() {
	stop_gal = false;
	//$("#debug").html("stop_gal="+stop_gal+" mouseout");
	});	

function autoplay_gal()
{
if(stop_gal==false) 
{
	var prev;
	if (curr == 0) {prev =  <?echo $imgs_num-1;?>;}
			else {prev = curr-1;}

	$("#navigation li:eq("+prev+") a").delay(10).removeClass("current");
	$("#images li:eq("+curr+")").delay(10).fadeIn(450).wait(delay/5).wait(delay/5).wait(delay/5).wait(delay/5).wait(delay/5).fadeOut(150);
	//$("#navigation li:eq("+curr+")").delay(10).fadeIn(450).wait(delay).fadeOut(150);
	$("#navigation li:eq("+curr+") a").delay(10).addClass("current").wait(450).wait(delay/5).wait(delay/5).wait(delay/5).wait(delay/5).wait(delay/5).wait(150);
	curr++;
	if (curr == <?echo $imgs_num;?>) curr = 0;
	//$("#debug").html("curr="+curr+" prev="+prev);
} //else $("#debug").html("stop_gal="+stop_gal+" mouseout autoplay_stopped");
}
	setInterval(autoplay_gal,delay+620);

<?
}
?>
});
</script>
<div id="debug"></div>
<?php endif; ?>