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

<div class="scroller" id="imagescroller">

			<div id="carousel">
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


<? if (isset($image->ngg_custom_fields["Link"]) && $image->ngg_custom_fields["Link"] != "")
{/*?>
   </a>
   <?	*/} ?>

					</li>
<?php
}
endforeach;
$imgs_num = count($images);
?>

				</ul>
			</div>
</div>


<script>

$(document).ready(function() {
 //$("#carousel").scrollable({circular: true});

// initialize galleries, hide all apart from the 1st ones
$("#images").attr("overflow","hidden");
$("#images, #info_images").children().hide();
$("#images").children(":first").show();
$("#info_images").children(":first").show();

// another autoplay thing
var stop;
stop_gal = false;
var curr;
curr = 0;
var delay;
delay = 5000;

// autoshow thing

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

function autoplay_gal()
{
if(stop_gal==false)
{
	var prev;
	if (curr == 0) {prev =  <?echo $imgs_num-1;?>;}
			else {prev = curr-1;}


	$("#images li:eq("+curr+")").delay(10).fadeIn(450).wait(delay/5).wait(delay/5).wait(delay/5).wait(delay/5).wait(delay/5).fadeOut(150);


	curr++;
	if (curr == <?echo $imgs_num;?>) curr = 0;
	//$("#debug").html("curr="+curr+" prev="+prev);
} //else $("#debug").html("stop_gal="+stop_gal+" mouseout autoplay_stopped");
}
	setInterval(autoplay_gal,delay+620);

});

</script>
<div id="debug"></div>
<?php endif; ?>