/*
*
Responsive Header
*
*/
(function($) {
    responsiveHeader = function(el) {


        /* =============================== global vars =========================*/
        var theme_folder = $('html head meta[name="themefolder"]').attr('content');
        var homepath = $('html head meta[name="homepath"]').attr('content');


        /* =============================== search function =========================*/
        el.find('#search-button').keyup(function(e) {
            var code = e.keyCode || e.which;
            if(code == 13) { 
                search();
            }
        });


        function show_search_field(){
            if(!el.hasClass('searching')){
                el.removeClass('showing_menu')
                el.addClass('searching');
                el.find('#search-button input').focus();
            } 
        }

        el.find('#search-button a').tap(function(event){
            if(el.hasClass('searching')){
                search();
                event.stopPropagation();
                return false; 
            }
        });


        function search(){
            var url = homepath+'?s=' + el.find('#search-button input').val();
            document.location = url;               
        }






        /* =============================== dismiss behaviors on tap =========================*/
        /**/
        $('body *').tap(function(event){
            
            //clicked on search
            if($(this).parents('#search-button').length>0){
                el.removeClass('showing_menu');
                el.find('ul.navbar li').removeClass('active'); 
                show_search_field();
                event.stopPropagation();
                return false; 
            }
            //clicked on menu button
            else if($(this).parents('#menu-button').length>0){
                el.removeClass('searching');
                
                if (el.hasClass('showing_menu')){
                    el.removeClass('showing_menu').removeClass('browserHeight');
                    el.find('#menuHolder').css("height","0");

                } 
                else{
                    el.addClass('showing_menu');


                    if($(window).width()<=650){
                        
                        var h = el.find('#menuHolder ul.navbar').outerHeight();
                        var h2 = el.find('#secondRow').outerHeight();
                        if(isNaN(h)) h=0;
                        el.find('#menuHolder').css("height",h+"px");
                        //$('#main').css("margin-top",(h+h2)+"px");

                        //disable body scrolling
                        //$('html').css('overflow','hidden');
                    }
                    else{
                        el.find('#menuHolder').css("height","0");
                        
                    }
                } 

                event.stopPropagation();
                return false;
            }
            //clicked an item of the main menu
            else if($(this).parent().hasClass('menu-item')){
                
                el.removeClass('searching');
                var thisItem = $(this);
                var thisItemId = '#' + $(this).parent().attr('id');

                //first, deactivate all submenus that are not ancestors

                el.find('ul.navbar li').each(function(){
                    //console.log($(this));
                    if(!$(this).has(thisItemId).length > 0){//not ancestors
                        $(this).removeClass('active');
                        //console.log('found:' + $(this).attr('id'));
                    }
                });

                //activate its own submenu
                if($(this).siblings("ul.sub-menu").length>0){
                    $(this).parent().addClass('active');
                    event.stopPropagation();
                    return false; 
                }
                else{
                    /*
                    var href = $(this).attr('href');
                    //check if is an internal link
                    if(href.substr(0,1)=="#" && href.length>1){
                        window.smoothScrollTo(href,80);
                        console.log('yeah');
                        event.stopPropagation();
                        return false;  

                    }
                    //if not, navigate to the page
                    else{
                        document.location = href;
                    }
                    */
                }
               // event.stopPropagation();
               // return false;                
            }
            else{
                //any other element clears the controls
                el.removeClass('searching');  
                el.removeClass('showing_menu');
                el.find('ul.navbar li').removeClass('active');   
                //event.stopPropagation();      
            }

        });



         /* =============================== minimized header =========================*/
        $(document).scroll(function() {

            var h = el.outerHeight();
            if($(window).scrollTop()<=320){
                el.find('ul.navbar a').removeClass('active');
                el.removeClass('minimized');
            }
            else{
               if(!el.hasClass('minimized')) el.addClass('minimized');
            }
            el.removeClass('searching');
            el.removeClass('showing_menu');
            el.find('ul.navbar li').removeClass('active');
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
                    el.find('ul.navbar a').removeClass('active');//removing all
                    el.find('ul.navbar a[href="#'+this_id+'"]').addClass('active');                    
                }
            },
            doOut: function() {
                if($(this).attr('id')!=undefined){
                    var this_id = $(this).attr('id');
                    el.find('ul.navbar a[href="#'+this_id+'"]').removeClass('active');
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
            el.removeClass('searching');
            el.removeClass('showing_menu')   
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
        var header = new responsiveHeader($('header.responsiveHeader'));
        header.show();   
})
})(jQuery);