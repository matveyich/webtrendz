
var JASlideshow = new Class({

	initialize: function(options){
		this.options = Object.extend({
			buttons : {},
			interval:5000,
			handle_event: 'click',
			button_event: 'click',
			box: {},
			size: 240,
			mode: 'horizontal',
			items:[],
			handles:[],
			onWalk:{},
			animation: 'fade',
			autoPlay: false
		}, options || {});
		
		this.items = this.options.items;
		this.modes = {horizontal:['left','width'], vertical:['top','height']};
		
		this.box = $(this.options.box);
		
		this.buttons = {previous: [], next: [], play: [], playback: [], stop: []};
		
		this.allbuttons = [];
		if(this.options.buttons){
			for(var action in this.options.buttons){
				this.addActionButtons(action, $type(this.options.buttons[action])=='array' ? this.options.buttons[action] : [this.options.buttons[action]]);
			}
		}
		this.handles = this.options.handles;
		if(this.handles){
			this.addHandleButtons(this.handles);
		}
		//this.fx = new Fx.Style(this.box,this.modes[this.options.mode][0],this.options.fxOptions||{duration:500,wait:false});
		this.allbuttons.each (function (button){
			button.addEvent ('mouseover', function (){this.addClass ('hover');});
			button.addEvent ('mouseout', function (){this.removeClass ('hover');});
		});
		
		this.currentIndex = this.options.startItem || 0;
		this.previousIndex = null;
		this.nextIndex = null;
		this._auto = null;
		this.initFx();
		if(this.options.autoPlay) this.play(this.options.interval,'next',true);
		this.walk (this.currentIndex);
	},

	previous: function(manual){
		this.lastIndex = this.currentIndex;
		this.currentIndex += this.currentIndex>0 ? -1 : this.items.length-1;
		this.walk(null,manual);
	},

	next: function(manual){
		this.lastIndex = this.currentIndex;
		this.currentIndex += this.currentIndex<this.items.length-1 ? 1 : 1-this.items.length;
		this.walk(null,manual);
	},

	play: function(delay,direction,wait){
		this.stop();
		if(!wait){
			this[direction](false);
		}
		this._auto = this[direction].periodical(delay,this,false);
	},

	stop: function(){
		$clear(this._auto);
	},

	walk: function(item,manual){
		//alert(item + ' ' + manual);
		if($defined(item)){
			this.lastIndex = this.currentIndex;
			//if(item==this.currentIndex) return;
			this.currentIndex=item;
		}
		this.previousIndex = this.currentIndex + (this.currentIndex>0 ? -1 : this.items.length-1);
		this.nextIndex = this.currentIndex + (this.currentIndex<this.items.length-1 ? 1 : 1-this.items.length);
		if(manual){ this.stop(); }
		//this.fx.start(-this.currentIndex*this.options.size + this.options.offset);
		if(this.options.onWalk){ this.options.onWalk(this.currentIndex,(this.handles?this.handles[this.currentIndex]:null)); }
		this.animate();
		if(manual && this.options.autoPlay){ this.play(this.options.interval,'next',true); }
	},
	initFx: function () {
		if (this.options.animation.test (/move/)) {
			this.box.setStyle(this.modes[this.options.mode][1],(this.options.size*this.options.items.length+200)+'px');
			this.box.setStyle(this.modes[this.options.mode][0],(-this.currentIndex*this.options.size) + this.options.offset+'px');
			this.fx = new Fx.Style(this.box,this.modes[this.options.mode][0],this.options.fxOptions||{duration:500,wait:false});
			return;
		}
		this.items.setStyles({'position':'absolute', 'left':0, 'top':0, 'display':'none'});
		this.items[this.currentIndex].setStyle ('display', 'block');
		if (this.options.animation.test (/fade/)) {
			for (var i=0;i<this.items.length;i++) {
				this.items[i].fx = new Fx.Style(this.items[i],'opacity',this.options.fxOptions||{duration:500,wait:false});
			}
		}
	},
	animate: function () {
		if (this.options.animation.test (/move/)) {
			this.fx.start(-this.currentIndex*this.options.size + this.options.offset);
			return;
		}
		var others = [];
		for (var i=0;i<this.items.length;i++) {
			this.items[i].fx.stop();
			if (i!=this.currentIndex && i!= this.lastIndex) others.push (this.items[i]);
		}
		$$(others).setStyle ('display', 'none');
		if (this.lastIndex == this.currentIndex) {
			this.items[this.currentIndex].setStyles ({'display':'block', 'opacity': 1});
		} else {
			this.items[this.currentIndex].setStyles ({'display':'block', 'opacity': 0, 'z-index': 10});
			this.items[this.lastIndex].setStyles ({'z-index': 9});
		}
		if (this.options.animation.test (/fade/)) {
			this.items[this.lastIndex].fx.start(0);
			this.items[this.currentIndex].fx.start(1);
			return;
		}
	},
	
	addHandleButtons: function(handles){
		for(var i=0;i<handles.length;i++){
			handles[i].addEvent(this.options.handle_event,this.walk.bind(this,[i,true]));
			this.allbuttons.push (handles[i]);
		}
		//handles.addEvent(this.options.handle_event, function(){this.blur();});
	},

	addActionButtons: function(action,buttons){
		for(var i=0; i<buttons.length; i++){
			switch(action){
				case 'previous': buttons[i].addEvent(this.options.button_event,this.previous.bind(this,true)); break;
				case 'next': buttons[i].addEvent(this.options.button_event,this.next.bind(this,true)); break;
				case 'play': buttons[i].addEvent(this.options.button_event,this.play.bind(this,[this.options.interval,'next',false])); break;
				case 'playback': buttons[i].addEvent(this.options.button_event,this.play.bind(this,[this.options.interval,'previous',false])); break;
				case 'stop': buttons[i].addEvent(this.options.button_event,this.stop.bind(this)); break;
			}
			this.buttons[action].push(buttons[i]);
			buttons[i].addEvent(this.options.button_event, function(){this.blur();});
			this.allbuttons.push (buttons[i]);
		}
	}
	
});