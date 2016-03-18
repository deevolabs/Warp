/*
*
Responsive Header
*
*/
(function($) {
    megamenu = function(el) {
     
        var one_page_site = false;

        /* =============================== LOGO =========================*/
        var logo = $("header .logo");
        logo.tap(function(){
            if(one_page_site){
                smoothScrollTo($("#top"));
                return false;
            }
        });

        var spacer = $("<div id='top' class='header_spacer'></div>");
        spacer.insertAfter(el);


      
        /* =============================== creating large structure =========================*/
       
        var area_template =  $(".megamenu .area.template");
        var submenuWrapper =  $("<div class='submenu_wrapper'></div>");
        var areas = el.find(".menu_areas ul.original_menu>li>ul.sub-menu");
        var i = 1;

        //el.find(".menu_areas ul.original_menu>li>a").remove();


        /* =============================== largeMenu mechanism =========================*/
        var area_scroller = el.find(".menu_areas ul.original_menu").slick({
            dots: false,
            arrows:false,
            speed: 300,
            slidesToShow: 1,
            autoplay: false,
            infinite: false,
            variableWidth: false,
            adaptiveHeight:true,
            centerMode: false,
            speed:150,
            fade:false

        });

        var currentSlide = 0;

         el.find(".largeMenu .main_menu ul li a").tap(function(e){


            //---------- one page site only -----------------
            var offset =0;
            if($("#wpadminbar")){
                offset+=$("#wpadminbar").height();
            }
            if($(".megamenu")){
                offset+=$(".megamenu").height();
            }

            if(one_page_site){
                window.smoothScrollTo($(this).attr("href"),offset);
                e.stopPropagation();
                return false;
            }
            //-------------------------------------------------------------


            //---------- megamenu -----------------

            var n_area = el.find(".largeMenu .main_menu ul li").index($(this).parent())       
            currentSlide = area_scroller.slick('slickCurrentSlide');           
            if(n_area == currentSlide){
                if(el.find(".menu_areas").hasClass("active")){
                   el.find(".menu_areas").removeClass("active");
                   resetMegamenu();
                    e.stopPropagation();
                    return false;                        
                }
                else activateArea(n_area);
            }
            else if(n_area != currentSlide){
                activateArea(n_area);
            }
                        
            //move tip
            var x = $(this).offset().left;
            var w = $(this).outerWidth();
            var x = x+(w/2)           
            el.find(".largeMenu .tip").addClass("active").css("left",x+"px").addClass("active");   
            
            e.stopPropagation();
            return false;
         });


        function activateArea(n_area){
            el.find(".menu_areas").addClass("active");
            area_scroller.slick("slickGoTo",n_area);            
            el.find(".menu_areas .area").removeClass("active");
            el.find(".menu_areas .area:nth-child("+(n_area)+")").addClass("active");            
        }


         /* =============================== dismiss menus =========================*/
        $('html').tap(function() {          
            resetMegamenu();
        });

        function resetMegamenu(){
            el.find(".area").removeClass("active");
            el.find(".submenu_wrapper").removeClass("active");
            el.find(".largeMenu").removeClass("searching");
            el.find(".largeMenu .tip").removeClass("active");

            //activating graduacao
            el.find(".menu_areas").removeClass('active')
            el.find(".menu_areas .area.cursos .left_pane a").removeClass('active');
            el.find(".menu_areas .area.cursos .left_pane .tipo-graduacao a").addClass("active");
        }

         /* =============================== minimized header =========================*/
        $(document).scroll(function() {

            var h = el.outerHeight();

            if($(window).scrollTop()==0){
                el.removeClass('minimized');
                $("#top.header_spacer").height(0);
            }
            else{
               if(!el.hasClass('minimized')) el.addClass('minimized');
               $("#top.header_spacer").height(h);
            }
            resetMegamenu();
        });







         /* =============================== breaking news =========================*/
        el.find(".breakingNews .btClose").tap(function() {
            el.find(".breakingNews").removeClass("active");
            $.cookie('breakingNews','closed')
            return false;
        });


        if(!$.cookie('breakingNews') || $.cookie('breakingNews')!="closed"){
            setTimeout(function(){
                el.find(".breakingNews").addClass("active");    
            },5000)
        }


         /* =============================== search =========================*/
        el.find(".search-field a.icon-search").tap(function(e) {
            if(!el.find(".largeMenu").hasClass("searching")){
                el.find(".largeMenu").addClass("searching");
                el.find(".search-field input").val("");                  
                el.find(".search-field input").focus();             
            }
            else{
                //execute search   
            }
            e.stopPropagation();
            return false;
        });
        el.find(".search-field input").tap(function(e){
            e.stopPropagation();
            return false;
        });
        
        el.find(".search-field input").keydown(function(e){
          if ( e.which == 13 ) {
            document.location = "/?s="+el.find(".search-field input").val();
          }
        });


        // -------------------------------------------------------------------------------------------
        // scroll to section
        // -------------------------------------------------------------------------------------------

        $('.section').onScreen({
            container: window,
            direction: 'vertical',
            doIn: function() {
                if($(this).attr('id')!=undefined){
                    var this_id = $(this).attr('id');
                    el.find('.largeMenu a').removeClass('active');//removing all
                    el.find('.largeMenu a[href="#'+this_id+'"]').addClass('active');                    
                }
            },
            doOut: function() {
                if($(this).attr('id')!=undefined){
                    var this_id = $(this).attr('id');
                    el.find('.largeMenu a[href="#'+this_id+'"]').removeClass('active');
                }                
                
            },
            tolerance: 300,
            //throttle: 0,
            //toggleClass: 'onScreen',
            //lazyAttr: null,
            //lazyPlaceholder: 'someImage.jpg',
        });


        /* =============================== resize =========================*/
        function reposition(){
            var browserWidth = $(window).width();
            var browserHeight = $(window).height();

            if($('html').hasClass("smallScreen")){
                if(el.find('#menuHolder ul.navbar'.length==0))
                    el.find('ul.navbar').appendTo(el.find('#menuHolder>.container'));
            }
            else if($('html').hasClass("largeScreen")){
                if(el.find('#secondRow #mainMenu ul.navbar'.length==0))                
                    el.find('ul.navbar').appendTo(el.find('#secondRow #mainMenu .vertical_center'));
            }   
            el.find(".largeMenu").removeClass("searching");
            el.find('ul.navbar li').removeClass('active'); 

        }


        el.on('webkitTransitionEnd.done oTransitionEnd.done otransitionend.done transitionend.done msTransitionEnd.done',function(){
            //console.log('header transition end');
            //setTopMargin()
        })


        function init(){
            $(window).resize(function(){reposition();})
            reposition();
        }

        this.show = function(){
            el.addClass('active');
        }
        this.hide = function(){
            el.removeClass('active');
        }

        init();
        return this;
}

$(document).ready(function(){
        var header = new megamenu($('header.megamenu'));
        header.show();   
})
})(jQuery);


