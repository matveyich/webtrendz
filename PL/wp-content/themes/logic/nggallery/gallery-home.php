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

		<div class="slider">
			
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
						
						<div class="descr">
							<div class="container">
								<div class="inner">
								<h1><? echo $image->alttext;?></h1>
			<? 
			// shows edited text in html
			echo '<p>'.htmlspecialchars_decode($image->description).'</p>'; ?>
			<? if (isset($image->ngg_custom_fields["Link"]) && $image->ngg_custom_fields["Link"] != "") {?>
			<p>
			
			<a href="<?php echo $image->ngg_custom_fields["Link"];?>"><strong>Free!</strong> Get started here</a>
			
			</p>
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
			

			
			<ul class="navi nav" id="navigation">
<?php 
$imgs_num = count($images);
$i = 1;
foreach ( $images as $image ) : 
if ( !$image->hidden ) 
{
?>			
			<li<?if ($i==$imgs_num) {echo " class=last";} if (1==$i) {echo " class=first";} $i++;?>>	
				<a href="#" rel="<?php echo $image->pid ?>"><?echo $image->alttext;?></a>
			</li>	
<?php 
}
endforeach; ?>				
			</ul>
		</div>
<script>

jq(document).ready(function() {

// initialize galleries, hide all apart from the 1st ones
jq("#images, #info_images").children().hide();
jq("#images").children(":first").show();
jq("#navigation li:first a").addClass("active");
jq("#info_images").children(":first").show();

// another autoplay thing
var stop;
stop_gal = false;
var curr;
curr = 0;
var delay;
delay = 5000;

	
// work with galleries' buttons
jq("#navigation a").mouseover(function() {
	jq("#navigation li a").each(function(){jq(this).removeClass("active");});
	jq(this).addClass("active");
	if (jq("#images #" + this.rel).css("display") == "none") {jq("#images").children().fadeOut();jq("#images #" + this.rel).fadeIn();}
	//jq("#debug").html("stop_gal="+stop_gal+" mouseover");	
	
	// autoplay things
	stop_gal = true;
	curr = jq(this).parent().index();
	});

// autoshow thing

<?
if (nggcf_get_gallery_field($gallery->ID, "autoplay") == "yes") 
{
?>
    jq.fn.wait = function(option, options) {
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
        settings = jq.extend({},defaults, options);

        if(typeof settings.onEnd == 'function') {
            this.each(function() {
                setTimeout(settings.onEnd, settings.msec);
            });
            return this;
        } else {
            return this.queue('fx',
            function() {
                var self = this;
                setTimeout(function() { jq.dequeue(self); },settings.msec);
            });
        }

    }
	
jq("#navigation a").mouseout(function() {
	stop_gal = false;
	//jq("#debug").html("stop_gal="+stop_gal+" mouseout");
	});	

function autoplay_gal()
{
if(stop_gal==false) 
{
	var prev;
	if (curr == 0) {prev =  <?echo $imgs_num-1;?>;}
			else {prev = curr-1;}

	jq("#navigation li:eq("+prev+") a").delay(10).removeClass("active");
	jq("#images li:eq("+curr+")").delay(10).fadeIn(450).wait(delay/5).wait(delay/5).wait(delay/5).wait(delay/5).wait(delay/5).fadeOut(150);
	//jq("#navigation li:eq("+curr+")").delay(10).fadeIn(450).wait(delay).fadeOut(150);
	jq("#navigation li:eq("+curr+") a").delay(10).addClass("active").wait(450).wait(delay/5).wait(delay/5).wait(delay/5).wait(delay/5).wait(delay/5).wait(150);
	curr++;
	if (curr == <?echo $imgs_num;?>) curr = 0;
	//jq("#debug").html("curr="+curr+" prev="+prev);
} //else jq("#debug").html("stop_gal="+stop_gal+" mouseout autoplay_stopped");
}
	setInterval(autoplay_gal,delay+620);

<?
}
?>
});
</script>
<div id="debug"></div>
<?php endif; ?>