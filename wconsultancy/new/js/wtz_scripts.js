var js = jQuery.noConflict();
js(document).ready(function() {
	
	js("#menu ul li ul.sub-menu").wrap("<div/>");
	// FOR search form 
	jq("#s").attr('value', 'search...');
	jq("#s").focus(function() {jq(this).attr('value', '');});
	jq("#s").blur(function() {jq(this).attr('value', 'search...');});

});