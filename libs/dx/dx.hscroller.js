
(function($){

	$.fn.hscroller = function(){
		//vars ----------------------------------------------------------------------
		var me = this;
		var obj = $(this);
    	var isOldIE = false;
    	//if ( $.browser.msie && parseInt($.browser.version)<10) isOldIE = true;
		var isiPad = navigator.userAgent.match(/iPad/i) != null;
		var iscroll;
		var nSlides;
		var nPages;
		var scroller;
		var scrollerBox;
		var currentPage = 0;
		var items ='';

	  	//methods -------------------------------------------------------------------
		this.nextPage = $(this).nextPage = function(){
			iscroll.scrollToPage('next', 0);
		}
		this.previousPage = $(this).previousPage = function(){
			iscroll.scrollToPage('prev', 0);
		}
		this.scrollTo = $(this).scrollTo = function(x, y, time, relative){
			iscroll.scrollTo(x, y, time, relative);
		}


		this.refresh = $(this)[0].refresh = function(){

			scroller = obj.find("#scroller");
			scrollerBox = obj.find("#scrollBox");
			var indicators = "";
			var h = obj.find('.slide').height() + 'px';


			//if($.browser.msie) obj.find('#scrollBox').css({'height':h});
			obj.find('#scrollBox>#scroller').css({'min-width':''+(getTotalWidth()) + 'px'});

			if(iscroll!=undefined) iscroll.refresh();

			nPages = Math.ceil(scroller.width()/scrollerBox.width());
			for (i=1;i<=nPages;i++){
				indicators+='<li id="i'+i+'"><a href="#">'+i+'</a></li>';
			}
			obj.find('.navBar.pages ul#pagelist').html(indicators);
		}


		//flow-----------------------------------------------------------------------
		init();
		this.refresh();
		createiScroll();
		addControlsListeners();
		showUI();
		return this;






		//functions -----------------------------------------------------------------

		function getTotalWidth(){
			var sliders_length=0;
			slides = obj.find('.slide')
			var i = 0;
			slides.each(function(){
				var ww = $(this).width();
				var margins = parseInt($(this).css('margin-right')) + parseInt($(this).css('margin-left'));
				if(isNaN(margins)) margins = 5;//ie maldito
				sliders_length+=ww + margins;
				i++;
			});
			nSlides = i;
			return sliders_length+15;//segurança
		}



		// create HTML
		function init(){
			slides = obj.children('.slide');

			var i = 0;
			slides.each(function(){
				$(this).addClass('slide-'+i);
				items+='<li id="i'+i+'"><a href="#"></a></li>';
				i++;
			});

			var sliderCode = '<a href="#" class="arrow right" title="Próxima Página"></a><a href="#" class="arrow left" title="Anterior"></a><div id="scrollBox"><div id="scroller"></div></div>';
			var navCode = '<div class="navBar items"><ul>'+items+'</ul></div>';
			navCode+= '<div class="navBar pages"><ul><li><a href="#" id="btFirst">primeira</a></li><li><ul id="pagelist"></ul></li><li><a href="#" id="btLast">última</a></li></ul><div>';

			obj.prepend(sliderCode+navCode);
			$(obj).children('.slide').appendTo($(obj).find('#scroller'));
			obj.find('.slide').disableSelection();
		}

		function createiScroll(){
			//CUSTOMIZATION: //disabling snapping for ipad/iphone
			var prop_snap = true;
			var prop_momentum = false;

			if(isiDevice){
				prop_snap = false;
				prop_momentum = true;
			}

			iscroll = new IScroll(obj.find('#scrollBox').get(0),{
				vScroll: false,
				hScrollbar: false,
				vScrollbar: false,
				lockDirection:true,
				snap: prop_snap,
				momentum: prop_momentum,
				desktopCompatibility: true,
				onBeforeScrollStart: function (e) {
					if(!isiPad) return;
					point = e.touches[0];
					pointStartX = point.pageX;
					pointStartY = point.pageY;
					null;
				},
				onScrollStart: function(e){
					obj.trigger('scrollStart', parseInt(iscroll.currPageX));
					//timer.pause();
				},
				onBeforeScrollMove: function(e){
					if(!isiPad) return;
					deltaX = Math.abs(point.pageX - pointStartX);
					deltaY = Math.abs(point.pageY - pointStartY);
					if (deltaX >= deltaY) {
						e.preventDefault();
					}
					else{
						null;
					}
				},
				onScrollEnd: function(e){
					obj.trigger('scrollEnd', parseInt(iscroll.currPageX));
					obj.find('.navBar li.active').removeClass('active');
					obj.find('.navBar.items li#i' + (iscroll.currPageX+1)).addClass('active');//errado!!!!! tem q mostrar o objeto atual
					obj.find('.navBar.pages li#i' + (iscroll.currPageX+1)).addClass('active');


					//obj.trigger('scrollEnd', parseInt(currentPage));
				}
			});
		}


		function addControlsListeners(){


			obj.find('.arrow.right').click(function(e) {
                me.nextPage();
				return false;
            });
			obj.find('.arrow.left').click(function(e) {
                me.previousPage();
				return false;
            });

            // pages navigation
			obj.find('.navBar.pages #pagelist li a').click(function(e) {
				var n = parseInt($(this).parent().attr('id').substr(1,2))-1;
				iscroll.scrollToPage(n,0);
				return false;
            });
			obj.find('.navBar.pages #btLast').click(function(e) {
                iscroll.scrollToPage(nSlides,0);
				return false;
            });
			obj.find('.navBar.pages #btFirst').click(function(e) {
                iscroll.scrollToPage(0,0);
				return false;
            });


			obj.find('.slide').click(function(e) {
                obj.find('.slide').removeClass('active');
                $(this).addClass('active');

				if(!isSlideVisible($(this)))
					iscroll.scrollToElement(this,500);
				return false;
            });


			//new NoClickDelay(obj.get(0));

		}

		function isSlideVisible(slide_element){
			var left = parseInt(slide_element.position().left)
			var width = slide_element.width();
			var limite = left+width;
			if(left>=0 && limite<=scrollerBox.width()) return true;
			return false;
		}

		function showUI()
		{
			obj.find('navBar li:nth-child(1)').addClass('active');
			obj.addClass('ready');
			setTimeout(function(){obj.trigger('ready');},1000);
		}


	}

$(document).ready(function($) {
	//if($('#hscroller').length>0) var gallery01 = $('#hscroller').hscroller();
});


})(jQuery);