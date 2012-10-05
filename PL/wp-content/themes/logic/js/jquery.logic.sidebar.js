
jq(document).ready(function() {

// tabs in sidebar
jq("#tabs_right").tabs("#panes_right > div", {history:true, current: 'active'});
/*
jq("#LC24").click(function() {
	if (jq('.zopim:eq(2)').css('visibility') == 'visible') jq('.zopim:eq(2)').css('visibility', 'hidden');
		else jq('.zopim:eq(2)').css('visibility', 'visible');
	
	if (jq('.zopim:eq(1)').css('visibility') == 'visible') jq('.zopim:eq(1)').css('visibility', 'hidden');
		else jq('.zopim:eq(1)').css('visibility', 'visible');
	});
*/	
});
