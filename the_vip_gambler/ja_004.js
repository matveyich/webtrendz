var JASlideshow2 = new Class({	
	initialize: function(element, options) {
		this.options = Object.extend({
			startItem: 0,
			showItem: 4,
			mainWidth: 360,
			mainHeight: 240,
			itemWidth: 60,
			itemHeight: 60,
			duration: 400,
			interval: 5000,
			transition: Fx.Transitions.Back.easeOut,
			thumbOpacity:'0.8',			
			maskDesc : 'maskDesc',
			but_prev:'but_prev',
			but_next: 'but_next',
			maskOpacity: '0.8',
			buttonOpacity: '0.4',
			overlap: 0,
			navigation: '',
			animation: 'fade',
			thumbSpaces: [3,3],
			urls: [],
			autoPlay: false
		}, options || {});
		
		if (!this.options.animation.test(/move/)) this.options.overlap = 0;
		
		this.el = $(element);
		this.fxOptions = {duration:this.options.duration, transition:this.options.transition, wait: false}
		
		this.elmain = this.el.getElement('.ja-slide-main-wrap');
		var conWidth = this.options.overlap?'100%':this.options.mainWidth;
		this.elmain.setStyles ({'width':conWidth, 'height':this.options.mainHeight});
		this.els = this.el.getElements('.ja-slide-item');
		this.els.setStyles ({'width':this.options.mainWidth, 'height':this.options.mainHeight});
		this.options.rearWidth = 0;
		this.options.mainSpace = 0;
		if (this.options.overlap) {
			this.options.mainSpace = 10;
			this.options.rearWidth = Math.ceil((this.elmain.offsetWidth - this.options.mainWidth)/2) - this.options.mainSpace;
			this.but_prev = this.el.getElement('.'+this.options.but_prev);
			this.but_next = this.el.getElement('.'+this.options.but_next);
			this.but_prev.setStyles({'opacity': this.options.buttonOpacity, 'width': this.options.rearWidth, 'height': this.options.mainHeight});
			this.but_next.setStyles({'opacity': this.options.buttonOpacity, 'width': this.options.rearWidth, 'height': this.options.mainHeight});
			this.but_prev.addEvents ({
				'mouseover': function (){this.but_prev.setStyle('opacity', this.options.buttonOpacity/2);}.bind(this),
				'mouseout': function (){this.but_prev.setStyle('opacity', this.options.buttonOpacity);}.bind(this)
			});
			
			this.but_next.addEvents ({
				'mouseenter': function (){this.but_next.setStyle('opacity', this.options.buttonOpacity/2);}.bind(this),
				'mouseleave': function (){this.but_next.setStyle('opacity', this.options.buttonOpacity);}.bind(this)
			});
			this.els.setStyle ('margin-right', this.options.mainSpace);
		}
		/*Need to be fixed to work with moving up/down*/
		
		if(this.options.navigation){
			this.el.getElement('.ja-slide-thumbs-wrap').setStyles ({'width':this.options.itemWidth*this.options.showItem, 'height':this.options.itemHeight});
			var thumbs_thumbs 	= this.el.getElement('.ja-slide-thumbs');
			thumbs_thumbs.setStyle('left',0);
			thumbs_thumbs.getChildren().setStyles ({'width':this.options.itemWidth, 'height':this.options.itemHeight});
			var thumbs_handles 	= this.el.getElement('.ja-slide-thumbs-handles');
			thumbs_handles.setStyle('left',0);
			thumbs_handles.getChildren().setStyles ({'width':this.options.itemWidth, 'height':this.options.itemHeight});
			
			var thumbsFx_thumbs = new Fx.Style(thumbs_thumbs,'left',this.fxOptions);			
			var thumbsFx_handles= new Fx.Style(thumbs_handles,'left',this.fxOptions);

			this.el.getElement('.ja-slide-thumbs-mask-left').setStyles ({'height':this.options.itemHeight,'width':2000,'opacity':this.options.thumbOpacity});
			this.el.getElement('.ja-slide-thumbs-mask-right').setStyles ({'height':this.options.itemHeight,'width':2000,'opacity':this.options.thumbOpacity});
			this.el.getElement('.ja-slide-thumbs-mask-center').setStyles ({'height':this.options.itemHeight,'width':this.options.itemWidth,'opacity':this.options.thumbOpacity});
			var thumbs_mask = this.el.getElement('.ja-slide-thumbs-mask').setStyles ({'left':this.options.startItem*this.options.itemWidth-2000,'width':5000});
			//var thumbs_mask 	= this.el.getElement('.ja-slide-thumbs-mask').setStyle('left',(this.options.startItem*this.options.itemWidth-this.options.maskPos)+'px').setOpacity(this.options.thumbOpacity);	
			
			var thumbsFx_mask 	= new Fx.Style(thumbs_mask,'left',this.fxOptions);			
		}
		//When slideshow animate
		this.onWalk = function (currentIndex) {
			if (this.options.navigation) {
				if (currentIndex <= this.options.startItem || currentIndex - this.options.startItem >= this.options.showItem-1) {
					this.options.startItem = currentIndex - this.options.showItem+2;
					if (this.options.startItem < 0) this.options.startItem = 0;
					if (this.options.startItem > this.els.length-this.options.showItem) this.options.startItem = this.els.length-this.options.showItem;
				}
				thumbsFx_mask.start((currentIndex - this.options.startItem)*this.options.itemWidth-2000);
				thumbsFx_thumbs.start(-this.options.startItem*this.options.itemWidth);
				thumbsFx_handles.start(-this.options.startItem*this.options.itemWidth);
			}
			if (this.options.descMode.test(/load/)){
				this.hideDesc();
			}
			if (this.el.getElement('.readon')) this.el.getElement('.readon').href = this.options.urls[currentIndex];
		}
		
		//Description
		this.maskDesc = this.el.getElement ('.'+this.options.maskDesc);
		this.maskDesc.setStyles ({'display':'block',
													 'position':'absolute',
													 'top': 0,
													 'left': this.options.rearWidth+this.options.mainSpace,
													 'width': this.options.mainWidth,
													 'height': this.options.mainHeight,
													 'opacity': 0.01
													 });

		if (this.options.showDesc) {
			this.descFx = new Fx.Style (this.maskDesc, 'opacity',{duration:200,transition:Fx.Transitions.linear});
			this.descs = this.el.getElements ('.ja-slide-desc');
			this.showDesc = function() {
				this.descFx.stop();
				this.descFx.start(this.options.maskOpacity);
			};
			this.hideDesc = function () {
				this.descFx.stop();
				this.descFx.start(0.01);
				
			};
			this.swapDesc = function (currentIndex) {
			//console.log('swap '+currentIndex);
				if (this.maskDesc.currentIndex == currentIndex) return;
				if (this.maskDesc.desc) {
					this.maskDesc.desc.remove();
					this.maskDesc.desc = null;
				}
				if (this.descs[currentIndex] && this.descs[currentIndex].innerHTML) this.maskDesc.desc = this.descs[currentIndex].inject (this.maskDesc);
				this.maskDesc.currentIndex = currentIndex;
			}
			
			if (this.options.descMode.test(/mouseover/)){
				this.maskDesc.addEvent ('mouseover', this.showDesc.bind(this));
				this.maskDesc.addEvent ('mouseout', this.hideDesc.bind(this));
			} else {
				this.maskDesc.setStyle ('opacity', this.options.maskOpacity);
			}
		}
		this.fxOptions.onComplete = function() {
			if (this.options.showDesc) {
				this.swapDesc(this.hs.currentIndex);
				if (this.options.descMode.test(/load/)){
					this.showDesc();
				}
			}
			if(this.hs.options.handles && this.hs.options.handles.length) {
				this.hs.options.handles[this.hs.lastIndex].removeClass ('active');
				this.hs.options.handles[this.hs.currentIndex].addClass ('active');
				this.el.getElements ('.ja-slide-thumb')[this.hs.lastIndex].removeClass ('active');
				this.el.getElements ('.ja-slide-thumb')[this.hs.currentIndex].addClass ('active');
			}
		}.bind(this);
		
		//Click on Main image
		if (this.options.urls) {
			this.maskDesc.addEvent('click', function () {
				var url = this.options.urls[this.hs.currentIndex];
				if (url) window.open(url,'_blank');
			}.bind(this));
		}

		this.hs = new JASlideshow({
			box: this.el.getElement('.ja-slide-main'),			
			items: this.els,
			handles: thumbs_handles?thumbs_handles.getChildren():[],
			fxOptions: this.fxOptions,
			interval: this.options.interval,
			onWalk: this.onWalk.bind(this),
			size: this.options.mainWidth + this.options.mainSpace,
			animation: this.options.animation,
			buttons: {
				previous: this.el.getElements('.ja-slide-prev'),
				play: this.el.getElements('.ja-slide-play'),
				stop: this.el.getElements('.ja-slide-stop'),
				playback: this.el.getElements('.ja-slide-playback'),
				next: this.el.getElements('.ja-slide-next')
			},
			startItem: this.options.startItem,
			offset: this.options.overlap?this.options.rearWidth-this.options.mainWidth:0,
			autoPlay: this.options.autoPlay
		});
		//Case xxxx
		if(this.options.overlap){
			this.hs.box.getChildren()[0].clone().inject(this.hs.box);
			this.hs.box.getChildren()[this.hs.items.length-1].clone().injectTop(this.hs.box);
			this.hs.box.setStyle(this.hs.modes[this.hs.options.mode][1],(this.hs.options.size*(this.hs.items.length+2)+200)+'px');			
		}
		this.el.setStyle('visibility', 'visible');
		//End case xxxx
		//hs.walk(this.options.startItem);
	}
});