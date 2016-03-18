/*

JSBillboard component

requires:iscroll_mod 
		 jquery timer plugin	
Author: Dex
BUG: IE7 não centraliza  navegaçâo (problema do inline-block)
BUG: swipe não funciona no Windows Phone
BUG: barras de rolagem q apareçam durante a renderização do conteúdo podem interferir nas larguras e alturas caso o container não tenha tamanho fixo em pixels.
TODO: implementar loop infinito - adicionar e remover slides dinamiamente
TODO: implementar vídeo
TODO: aplcar compactação gzip

*/

(function($){	
	$.fn.Billboard = function(settings){
	
		//vars ----------------------------------------------------------------------
		var obj = $(this);
		var me = this;
		var slides;	
		var iscroller;		
		var nSlides = 0;
		var interval;
		var busy = false;
		var progress = 0;
		var curSlide = 0;
		var nnSlide = 0;
		var indicators = "";
		var oldHeight = 0;			
				

		//browser detection vars
    	var isiDevice = (/iphone|ipad/gi).test(navigator.appVersion);
		var isiPad = (/ipad/gi).test(navigator.appVersion);
		var isiPhone = (/iphone/gi).test(navigator.appVersion);		
		
		var isAndroid = (/android/gi).test(navigator.appVersion);		
		var isAndroidMobile = false; 
		var isAndroidTablet = false;		
		if(isAndroid){
			if(/mobile/gi.test(navigator.userAgent)){
				isAndroidMobile = true;
				isAndroidTablet = false;
				$('body').addClass('AndroidMobile');
				$('body').removeClass('AndroidTablet');
			}
			else{
				isAndroidMobile = false;
				isAndroidTablet = true;			
				$('body').addClass('AndroidTablet');
				$('body').removeClass('AndroidMobile');
			}
		}
		var isIE = $.browser.msie;
		var isOldIE = false;		
		if ( $.browser.msie && parseInt($.browser.version)<9) isOldIE = true;	
		
		//alert('isAndroid:'+isAndroid+'; ' + 'isIDevice:'+isiDevice+'; ' + 'isAndroidMobile:'+isAndroidMobile+'; ' + 'isAndroidTablet:'+isAndroidTablet+'; ');

		


	
		//properties -----------------------------------------------------------------		
		this.me = this;
		this.dir = 0;
		this.settings = settings;
		
		if(!settings) settings= new Object();
		if(typeof settings == 'object') {
			var paramList = ['showNavigation','initialHeight','autoHeight','slideshow','slideshowDelay'];
			for(var arg in paramList) {if(settings[paramList[arg]] != undefined) {eval(paramList[arg] + " = settings[paramList[arg]]");}};			
		}		
		
		if(!settings.initialHeight) settings.initialHeight = 200;
		if(settings.showNavigation) settings.showNavigation = 'block';
		else settings.showNavigation = 'none'
		if(!settings.slideshowDelay) settings.slideshowDelay = 200;
		



	
		// create HTML sructure----------------------------------------------------------------
		slides = obj.children();
		var indicators = "";
		var i = 0;				
		slides.each(function(){
			$(this).addClass('slide');
			$(this).attr('id','slide'+i);
			indicators += '<li id="i'+i+'"></li>';
			i++;
		});
		nSlides = i;
		var sliderCode = '<div class="viewport"><div class="slides"></div></div>';
		var navCode = '<div class="navBar"><ul class="nav">'+indicators+'</ul></div>';
		var buttonsCode = '<a class="btNav left" href="#"></a><a class="btNav right" href="#"></a>';
		obj.prepend(sliderCode+buttonsCode+navCode);
		$(obj).children('.slide').appendTo($(obj).find('.slides'));

		
		obj.find('.slides').css({'width':''+(slides.length*100)+'%'});
		obj.find('.slides .slide').css({'width':''+(100/slides.length)+'%'});	
		obj.find('.slides .slide').disableSelection();
		if(me.autoHeight) obj.css({'height':'auto'});
		
		
		//create scroller --------------------------------------
		iscroller = new iScroll(obj.find('.viewport').get(0),{
			vScroll: false,
			hScrollbar: false,
			vScrollbar: false,
			lockDirection:true,
			snap: true,
			momentum: false,
			desktopCompatibility: true,
			onBeforeScrollStart: function (e) { 
				busy = true;
				if(!isiDevice && !isAndroidTablet) return;
				point = e.touches[0]; 
				pointStartX = point.pageX; 
				pointStartY = point.pageY; 
				null; 
			}, 
			onScrollStart: function(e){
				me.dir = this.dir;
				obj.trigger('scrollStart', parseInt(iscroller.currPageX));
				timer.pause();
				curSlide = parseInt(iscroller.currPageX);
				progress = 0					
			},				
			onBeforeScrollMove: function(e){ 
				if(!isiDevice && !isAndroidTablet) return;
				deltaX = Math.abs(point.pageX - pointStartX); 
				deltaY = Math.abs(point.pageY - pointStartY); 
				if (deltaX >= deltaY) { 
					e.preventDefault(); 
				} 
				else{ 
					null; 
				}
			},
			onMoving: function(p){
				//calculate nextSlide
				var nextSlide = curSlide;
				if(iscroller.nextPageX!= null) nextSlide = iscroller.nextPageX;
				else nextSlide = curSlide+iscroller.directionX;
				nnSlide = nextSlide;
				if(nextSlide>=nSlides || nextSlide<0) return;
				
				var deltaSlides =0;
				if(nextSlide>curSlide) deltaSlides = Math.abs(nextSlide-curSlide);		
				else if(curSlide>nextSlide) deltaSlides = Math.abs(curSlide-nextSlide);		
				
			
				var curSlideH = obj.find('.slide').eq(curSlide).height();
				var nextSlideH = obj.find('.slide').eq(nextSlide).height();
				
				var slideWidth = (obj.find('.slides').width()/nSlides);
				var x1 = (-p.x - ((curSlide)*slideWidth));
				progress = Math.abs((x1*100)/slideWidth);


				/*BUG:
					a construção abaixo tinha por objetivo ajustar a altura do viewport conforme a altura do slider, de forma suave.
					não funciona no iPad fdp
				*/
				
				var h = curSlideH + ((nextSlideH-curSlideH)/100)*(progress/deltaSlides);
				if(!isiDevice && !isAndroid && !isOldIE){
					if(obj.find('.viewport').height()!=h)	{
						obj.find('.viewport').height(h);
						var bt_h = (h/2) + ('px');
						obj.find('.btNav').css({'top':bt_h})						
					}
				}
				
			
			},		
			onScrollEnd: function(e){
				obj.trigger('scrollEnd', parseInt(iscroller.currPageX));
				curSlide = parseInt(iscroller.currPageX);
				progress = 0;											
				if(settings.slideshow) timer.play(true);
				busy = false;	
				/* workaround para o bug acima*/
				if(isiDevice || isAndroid || isOldIE) me.refresh();
				
			}	
							
		});
		
		

		//arrow  buttons -------------------------------------------------------
		obj.find('.btNav.right').click(function(e) {
			me.nextSlide();
			return false;
		});
		
		obj.find('.btNav.left').click(function(e) {
			me.previousSlide();
			return false;
		});				
			
		obj.mouseenter(function(e){
			obj.find('.btNav').addClass('active');
		}).mouseleave(function(e){
			obj.find('.btNav').removeClass('active');
		});				
		
		
		
		
		

		//navigation bar -----------------------------------------------------
		
		
		
		obj.find('.nav li').click(function(e) {
			var id = parseInt($(this).attr('id').substr(1,2));
			me.gotoSlide(id);
			return false;
		});	
		
		obj.bind('scrollEnd', function(event, curSlide) {
			obj.find('.nav li.active').removeClass('active');
			obj.find('.nav li#i' + nnSlide).addClass('active');
			
		});
		obj.find('.nav li#i0').addClass('active');
		if(nSlides<=1) obj.find('.navBar').hide();



		//timer -----------------------------------------------------
		var timer = $.timer(function() {			
			var s = slides.eq(iscroller.currPageX+1);
			if(!s.hasClass('loading'))
			{
				if(iscroller.currPageX<slides.length-1) iscroller.scrollToPage('next',0)
				else iscroller.scrollToPage(0,0)
			}
	    });
	
		//start Timer
		if(settings.slideshow)
		    timer.set({ time : settings.slideshowDelay, autostart : true });
		
		//pause on mouseover - only on desktops		
		obj.find('.slide').hover(
			function(){
				timer.pause();
			},
			function(){
				if(settings.slideshow && !busy)	timer.play(true);
			}
		);	




		//resize ------------------------------------------		
		$(window).resize(function() {		
			iscroller.disable();
			me.refresh();
			iscroller.enable();
			iscroller.scrollToPage(iscroller.currPageX,0);
		});	





		//methods ----------------------------------------------
		this.nextSlide = function(){
			iscroller.scrollToPage('next', 0);
			timer.pause();			
		}
		
		this.previousSlide = function(){
			iscroller.scrollToPage('prev', 0);
			timer.pause();			
		}
		
		this.gotoSlide = function(slideNumber){
			var curItem = iscroller.currPageX;
			timer.pause();
			iscroller.scrollToPage(slideNumber,0);
		}
		
		this.refresh = function(){
			var h = obj.find('.slide').eq(curSlide).height();
			//$.log('refresh:' + obj.find('.slide img').eq(curSlide).height());
			if(h!=oldHeight){ 
				obj.find('.viewport').height(h);
				var bt_h = (h/2) + ('px');
				obj.find('.btNav').css({'top':bt_h})
				iscroller.refresh();
			}
			oldHeight = h;
		}		


		//image preloading ---------------------------------------



		function renderImage(event, el){
			$.log('just finished downloading'+$(el).attr('src'));
			$(el).addClass('ready');											
			$(el).parent().removeClass('loading');				
			var curID = parseInt($(el).parent().attr('id').substr(5,2));
			if(curSlide==curID)	me.refresh();	
			
			obj.find('.nav li#i'+curID).addClass('ready');
		}


		obj.find(".slide img").each(function(){
			var imgheight = $(this).height();
			//console.log(imgheight);
			//renderImage(null, $(this).get(0));
		
			var imageMode;			
			if($(this).attr('src').length>3) imageMode = 'direct';
			else imageMode = 'preload';
			
			if(imageMode == 'preload'){
				$.q.add($(this));	
				$(this).parent().addClass('loading');			
				$(this).bind('finished', function (event, el) {renderImage(event, el);});
			}
			else{
				//console.log($(this).attr('src'));
				$(this).load(function(event){
					renderImage(event,$(this).get(0));
					$.log('loaded:' + $(this).get(0))
				});
				if(isIE){
					var url = $(this).attr("src");					 
					$(this).attr("src",url+ "?" + new Date().getTime());					
				}
			}
			
			
		
		});

		//slides listeners	
		if(isiDevice){	
			obj.find('a.slide').each(function(){
				//new NoClickDelay(document.getElementById($(this).attr('id')))
			});
		}



		//ready -----------------------------------------------
		this.refresh();
		obj.addClass('ready');			
		obj.trigger('ready');;
		if(isiDevice) obj.find('.viewport').css({'-webkit-transition':'height 0.25s ease-out'});

				
		return this;
	}	
	
	
	/*
	dxBillboard start
	********************************************************************/
	$(document).ready(function(){
		if($('#Billboard').length>0)
		{
			var billboardSlider = jQuery('.billboard').Billboard({
				initialHeight:540,
				autoHeight:true,
				showNavigation: true,
				slideshow:false,
				slideshowDelay:5000				
			});		
		}	
	});	
	
})(jQuery);