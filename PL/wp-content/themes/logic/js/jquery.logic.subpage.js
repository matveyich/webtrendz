jq(document).ready(function() {

// initialize galleries, hide all apart from the 1st ones
jq("#info_images").children().hide();
jq("#info_images").children(":first").show();

jq("#info_block a").click(function() {
	if (jq("#info_images #" + this.rel).css("display") == "none") {	
	jq("#info_images").children().fadeOut();
	jq("#info_images #" + this.rel).fadeIn();
	}
	});

jq("#tabs_right").tabs("#panes_right > div", {history:true,effect: 'slide'});

});