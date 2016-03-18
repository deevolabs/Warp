(function($) {

var post_scrollers = [];


    function initScroller(el){

        //vars 
        if(!el.attr("id")||el.attr("id")==''){
            el.attr("id","post_scroller_"+ guid());
        }
        var scroller_id = el.attr('id');
        var mode = el.attr('data-mode');
        var scroller_wrapper = el.find('.scroller_wrapper');

        //create structure
        var btprev = '<a class="navigation nav-prev icon-arrow-left3 vertical_center" href="#"></a>';
        var btnext = '<a class="navigation nav-next icon-arrow-right3 vertical_center" href="#"></a>';
        var indicators = '<ol class="indicators"></ol>';

        el.find('.wrapper').append(btprev);
        el.find('.wrapper').append(btnext);
        el.append(indicators);

        //create scroller
        if(mode=='horizontal'){
            post_scrollers[scroller_id] = new IScroll(scroller_wrapper[0], {
                scrollX: true,
                scrollY: false,
                momentum: false,
                snap: 'li',
                snapSpeed: 400,
                keyBindings: true,
                eventPassthrough:true,
                preventDefault:false,
                useTransition:true

            });
        } else post_scrollers[scroller_id] = new IScroll(scroller_wrapper[0]);

        //TODO:complement IScroll5 component with custom variables
        var this_scroller = post_scrollers[scroller_id];
        this_scroller.interval = 0;
        this_scroller.mode = el.attr('data-mode');

        //listen to events
        this_scroller.on('scrollEnd', function(){onScrollEnd(el);});
        this_scroller.on('scrollStart', function(){onScrollStart(el);});
        this_scroller.on('beforeScrollStart', function(){onBeforeScrollStart(el);});

        //refresh
        refresh(el);

    }




    function refresh(el){

        //TODO:complement IScroll5 component with custom variables
        var this_scroller = getScroller(el);
        var wrapper = el.find('.scroller_wrapper');
        var slidesPerView = el.attr('data-per-view');
        var totalWidth = el.width();
        this_scroller.interval = 0;
        clearInterval(this_scroller.interval); 

        //setting scroller's width
        if($('body').hasClass('smartphone')) slidesPerView = 1;
        var totalSlides = wrapper.find('ul li').length;
        var availableWidth = wrapper.width();
        var slide_w = availableWidth/slidesPerView;
        var ul_width = slide_w*totalSlides;
        var slide_w_percent = (1/totalSlides)*100;

        wrapper.find('ul').css('width',ul_width+'px');
        
        wrapper.find('ul li').each(function(){
            $(this).css('width',slide_w_percent+'%');
        });   

        

        //TODO: set navigation arrows active or inactive, depending on scrollers content
        

        //refresh indicators
        var nslides = el.find('.scroller_wrapper>ul>li').length;
        var nPages = this_scroller.pages.length;
        el.find('ol.indicators li').remove();
        for (var i = 0; i < nPages; i++) {            
            indicator = '<li id="page_'+i+'"><a href="#"></a></li>';
            el.find('ol.indicators').append(indicator)
        };



        //refresh iScroll5
        setTimeout(function(){ this_scroller.refresh(); },50);

        //calculate height
        //var h = this_scroller.wrapperHeight;
        //wrapper.closest('.wrapper').height(h+'px');      
        
        //autoplay        
        checkAutoPlay(el);
    }


    function onScrollEnd(el){
        
        var this_scroller = getScroller(el);
        
        var curX =  parseInt(this_scroller.x);
        //console.log(curX);
        //BUG: iscroll nao informa o x correto quando usado o método scrollToElement
        var totalWidth = el.find('ul').width();
        var totalElements = el.find('ul li').length;
        var curElementIndex = parseInt(Math.abs((curX/totalWidth)*totalElements));
        //console.log("curElementIndex:" + curElementIndex);
        var curElement = el.find('ul li:nth-child('+(curElementIndex+1)+')');


        //console.log(curElement);
        el.find('ul li').removeClass('active');
        curElement.addClass('active');
        el.find('.indicators li').removeClass('active');
        el.find('.indicators li:nth-child('+(curElementIndex+1)+')').addClass('active');

        checkAutoPlay(el);

    }

    function onBeforeScrollStart(el){
        var this_scroller = getScroller(el);
        clearInterval(this_scroller.interval);
    }
    function onScrollStart(el){
        var this_scroller = getScroller(el);
        clearInterval(this_scroller.interval);
    }

    function checkAutoPlay(el){
        var this_scroller = getScroller(el);  
        clearInterval(this_scroller.interval); 
        var autoplay = parseInt(el.attr('data-interval'));
        if(!isNaN(autoplay) && autoplay>0){  
            this_scroller.interval = setTimeout(function(){
                advanceOnePage(el);
            },autoplay);
        }            
    }


    function advanceOnePage(el){
        var this_scroller = getScroller(el);
        var currPage = this_scroller.currentPage.pageX + 1;
          if(currPage == this_scroller.pages.length) {
            this_scroller.goToPage(0, 0, 1000);
          } else {
            this_scroller.goToPage(currPage, 0, 1000);
          }            
    }


    function getScroller(el){
        var scroller_id = el.attr('id');
        return post_scrollers[scroller_id];  
    }



    $(document).ready(function() {


        if($('.post_scroller').length==0) return;
        $('.post_scroller').each(function(){
            initScroller($(this));
        });

        $(window).resize(function(){
            $('.post_scroller').each(function(){      
                refresh($(this));
            })
        })

        //detect lazy images
        $(".post_scroller img.lazy").bind('cssClassChanged', function(){ 
            if($(this).hasClass('loaded')) {
                var scroller_id = $(this).closest('.scroller_wrapper').attr('id');
                parent = $(this).closest('.post_scroller');
                //console.log('refreshing scroller ' + scroller_id);
                refresh(parent);
            }
        });

        //navigation arrows
        $('.post_scroller a.navigation ').tap(function(){            
            var el = $(this).parents('.post_scroller');
            var this_scroller = getScroller(el); 
            if($(this).hasClass('nav-next')) this_scroller.next();
            else this_scroller.prev();
            return false;
        });   

        //indicators
        $('.post_scroller .indicators li a').tap(function(){
            var el = $(this).parents('.post_scroller');
            var this_scroller = getScroller(el);
            var index = parseInt($(this).attr('id').substr(4,100));
            if(!isNaN(index)) this_scroller.goToPage(index, 0, 1000)
            return false;
        });


    });


})(jQuery);