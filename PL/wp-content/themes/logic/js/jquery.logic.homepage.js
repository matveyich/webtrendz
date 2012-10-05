
jq(document).ready(function() {

	// tabs in homepage
jq("#tabs").tabs("#panes > div", {history:true, current:'active'});
/*
jq("#info_block a").click(function() {
	if (jq("#info_images #" + this.rel).css("display") == "none") {	
	jq("#info_images").children().fadeOut();
	jq("#info_images #" + this.rel).fadeIn();
	}
	});
*/	
//jq("#infoblock").scrollable({circular: true}).navigator('#info_navigation');	

});
