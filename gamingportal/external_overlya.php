<html>

<head>
	<title>jQuery Tools standalone demo</title>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<!-- ALL jQuery Tools. No jQuery library -->
<script type="text/javascript" src="jquery.tools.overlay.min.js"></script>
<script type="text/javascript" src="jquery.tools.expose.min.js"></script>
<style>
/* the overlayed element */
.simple_overlay {
	
	/* must be initially hidden */
	display:none;
	
	/* place overlay on top of other elements */
	z-index:10000;
	
	/* styling */
	background-color:#333;
	
	min-width:675px;	
	min-height:200px;
	border:1px solid #666;
}

/* close button positioned on upper right corner */
.simple_overlay .close {
	background-image:url(img/overlay/close.png);
	position:absolute;
	right:-15px;
	top:-15px;
	cursor:pointer;
	height:35px;
	width:35px;
}
/* use a semi-transparent image for the overlay */
	#overlay {
		/*background-image:url(img/overlay/transparent.png);*/
		color:#efefef;
		height:auto;
	}
	
	/* container for external content. uses vertical scrollbar, if needed */
	div.contentWrap {
		height:auto;
		overflow:hidden;
	}


</style>
</head>
<body>
<!-- external page is given in the href attribute (as it should be) -->
<a href="" rel="#overlay" link="http://google.com">

	<!-- remember that you can use any element inside the trigger -->
	<button type="button">Show external page in overlay</button>	
</a>

<!-- another link. uses the same overlay -->
<a href="" link="http://crap.ru" rel="#overlay">
	<button type="button">Show another page</button>
</a>


<!-- overlayed element -->
<div class="simple_overlay" id="overlay">

	<!-- the external content is loaded inside this tag -->
	<div class="contentWrap">
	<iframe id="dataframe" src="" frameborder=0 width=800 height=600></iframe>
	</div>

</div>

<!-- make all links with the 'rel' attribute open overlays -->
<script>
var jq = jQuery.noConflict();
jq(function() {

	// if the function argument is given to overlay,
	// it is assumed to be the onBeforeLoad event listener
	jq("a[rel]").overlay({
mask: '#123448',
		//effect: 'apple',
		oneInstance: true,
		onBeforeLoad: function() {

			// grab wrapper element inside content
			var wrap = this.getOverlay().find("#dataframe");
			
			// load the page specified in the trigger
			wrap.attr('src', this.getTrigger().attr("link"));

		},
	});
});
</script>

</body>
</html>