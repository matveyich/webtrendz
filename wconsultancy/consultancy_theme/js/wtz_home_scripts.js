var jq = jQuery.noConflict();
jq(document).ready(function() {

//stuff we know about

jq("#tabbedContent").children().hide();
jq("#tabbedContent").children().eq(0).show();
jq("#tabbedNav").find("a").removeClass('current');
jq("#tabbedNav").find("a").eq(0).addClass('current');
jq("#tabbedNav").find("a").click(function(){

	var curRel = jq("#tabbedNav").find('.current').attr("rel");
	var curDiv = jq("#tabbedContent").find("[rel="+curRel+"]");
	var selDiv = jq("#tabbedContent").find("[rel="+jq(this).attr("rel")+"]");
	
		// get index of select li
		var sel_index = jq(this).parent().index(); 
		//sel_index = jq("#tabbedNav").index(sel_index);
		// get index of currently selected li
		var cur_index = jq('#tabbedNav').find('.current').parent().index();
		//cur_index = jq("#tabbedNav").index(cur_index); 

		if(cur_index < sel_index)
		{
			jq(curDiv).slideUp({ duration: 1000, easing: 'easeOutBounce'}); // slideUp current Div with easing plugin
			jq(selDiv).show('slide', { direction: "down" }, 1000); // show selected Div with slide jQuery UI effect
		}
		else
		{
			jq(curDiv).hide('slide', { direction: "down" }, 1000); // hide current Div with slide jQuery UI effect
			jq(selDiv).slideDown({ duration: 1000, easing: 'easeOutBounce'});	// slideUp selected Div with easing plugin
		}
	//jq('div.tabbedContentNav h2').text(sel_index+';'+cur_index);
	jq("#tabbedNav").find("a").removeClass('current');
	jq(this).addClass('current');		
});

//testimonials
jq("#iconNav ul li:first").addClass('current');
jq("#testimonialsContent").children().hide();
jq("#testimonialsContent").find("div.aTestimonial:first").show();
jq("#iconNav ul li").click(function(){
	jq("#iconNav ul").children().removeClass('current');
	jq(this).addClass('current');
	jq("#testimonialsContent").children().fadeOut(100);
	jq("#testimonialsContent").children("[rel="+jq(this).find('a').attr("rel")+"]").delay(100).fadeIn(350);
}
);

});