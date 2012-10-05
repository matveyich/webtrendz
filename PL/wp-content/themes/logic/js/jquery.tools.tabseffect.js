jq.tools.tabs.addEffect("slide", function(i, done) {

	// 1. upon hiding, the active pane has a ruby background color
	//this.getPanes().slideUp().css({backgroundColor: "#b8128f"});
	this.getPanes().hide();

	// 2. after a pane is revealed, its background is set to its original color (transparent)
	this.getPanes().eq(i).slideDown(function()  {
		jq(this).css({backgroundColor: 'transparent'});

		// the supplied callback must be called after the effect has finished its job
		done.call();
	});
});