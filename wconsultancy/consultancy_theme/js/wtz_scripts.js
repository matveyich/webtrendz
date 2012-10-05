var jq = jQuery.noConflict();
jq(document).ready(function() {

	// main menu
	jq("#menu ul li ul.sub-menu").wrap("<div/>");
	jq("#menu ul>li.current").removeClass("current");
	jq("#menu ul").find("li.current-menu-ancestor, li.current-menu-item").addClass("current selectedLava");

	// footer menu
	jq("#footer-menu ul li:first").addClass("first");
	jq("#footer-menu ul li:last").addClass("last");

	// FOR search form
	jq("#s").attr('value', 'search...');
	jq("#s").focus(function() {jq(this).attr('value', '');});
	jq("#s").blur(function() {jq(this).attr('value', 'search...');});
});

// Lava
jQuery(function(){
var $ = jQuery;
$.fn.retarder = function(delay, method){
var node = this;if (node.length){if (node[0]._timer_) clearTimeout(node[0]._timer_);node[0]._timer_ = setTimeout(function(){ method(node); }, delay);}return this;};
$('#menu').addClass('js-active');
$('ul div','#menu').css('visibility','hidden');
$('.menu>li','#menu').hover(function(){var ul=$('div:first',this);if(ul.length){if(!ul[0].hei)ul[0].hei=ul.height();ul.css({height:20,overflow:'hidden'}).retarder(400,function(i){i.css('visibility','visible').animate({height:ul[0].hei},{duration:500,complete:function(){ul.css('overflow','visible')}})})}},function(){var ul=$('div:first',this);if(ul.length){var css={visibility:'hidden',height:ul[0].hei};ul.stop().retarder(1,function(i){i.css(css)})}});$('ul ul li','#menu').hover(function(){var ul=$('div:first',this);if(ul.length){if(!ul[0].wid)ul[0].wid=ul.width();ul.css({width:0,overflow:'hidden'}).retarder(100,function(i){i.css('visibility','visible').animate({width:ul[0].wid},{duration:500,complete:function(){ul.css('overflow','visible')}})})}},function(){var ul=$('div:first',this);if(ul.length){var css={visibility:'hidden',width:ul[0].wid};ul.stop().retarder(1,function(i){i.css(css)})}});
var links=$('.menu>li>a, .menu>li>a span','#menu').css({background:'none'});
$('#menu ul.menu').lavaLamp({speed:600,container:'li'});
if(!($.browser.msie&&$.browser.version.substr(0,1)=='6')){$('.menu>li>a span','#menu').hover(function(){$(this).animate({color:'rgb(32,32,32)'},500)},function(){$(this).animate({color:'rgb(123,135,138)'},200)});$('ul ul a','#menu').hover(function(){$(this).animate({backgroundColor:'rgb(11,68,71)'},500)},function(){$(this).animate({backgroundColor:'rgb(11,68,71)'},{duration:100,complete:function(){$(this).css('backgroundColor','rgb(20,117,142)')}})})}});