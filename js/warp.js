// -------------------------------------------------------------------------------------------
// IE9 Console log bug
// -------------------------------------------------------------------------------------------
if (!window.console) {window.console = {};}
if (!console.log) {console.log = function() {};}


// -------------------------------------------------------------------------------------------
// Pointer-events polyfill
// -------------------------------------------------------------------------------------------
(function($) {

    $(document).ready(function(){
        jQuery.noConflict();
        PointerEventsPolyfill.initialize({});
    });

})(jQuery);   


// -------------------------------------------------------------------------------------------
// Page dimensions detection
// -------------------------------------------------------------------------------------------
(function($) {
           
    function detectDimensions(){


        var browser = {
                isIe: function () {
                    return navigator.appVersion.indexOf("MSIE") != -1;
                },
                navigator: navigator.appVersion,
                getVersion: function() {
                    var version = 999; // we assume a sane browser
                    if (navigator.appVersion.indexOf("MSIE") != -1)
                        // bah, IE again, lets downgrade version number
                        version = parseFloat(navigator.appVersion.split("MSIE")[1]);
                    return version;
                }
            };

        if (browser.isIe() && browser.getVersion() <= 9) {
            $("html").addClass("ie9")
            console.log("You are currently using Internet Explorer" + browser.getVersion() + " or are viewing the site in Compatibility View, please upgrade for a better user experience.")
        }



        if (window.innerWidth <=768){
            $('html').removeClass("tablet").removeClass("desktop").removeClass('largeScreen').addClass('smallScreen').addClass('smartphone');
        }
        else if(window.innerWidth >768 && window.innerWidth<1280){
            $('html').removeClass("desktop").removeClass("smartphone").removeClass('smallScreen').addClass('largeScreen').addClass('tablet');
        }
        else if(window.innerWidth >=1280){
            $('html').removeClass("tablet").removeClass("smartphone").removeClass('smallScreen').addClass('largeScreen').addClass('desktop');
        }                        

        var browserWidth, browserHeight;
        var browserWidth = $(window).width();
        var browserHeight = $(window).height();
        
       $('html').removeClass('portrait').removeClass('landscape');   
        if(browserWidth>browserHeight)  $('html').addClass('landscape');
        else $('html').addClass('portrait'); 

        $('html').removeClass('dimensions_unavailable');            

        $.event.trigger({   
          type:    "dimensionUpdate",
          message: "html class update",
          time:    new Date()
        });

    }



    
    $(document).ready(function() {
        detectDimensions();
        $(window).resize(function(){detectDimensions();});
    });

})(jQuery);        


(function($) {
    $(document).scroll(function() {
        if($(window).scrollTop()==0){
            $("html").removeClass('scrolling');
        }
        else{
           if(!$("html").hasClass('scrolling')) $("html").addClass('scrolling');
        }
    });
})(jQuery);      


// -------------------------------------------------------------------------------------------
// Utils
// -------------------------------------------------------------------------------------------

//is url
function isUrl(strUrl) {
    if (strUrl.indexOf('http') >= 0) return true;
    else return false;
}

//guid
var guid = (function() {
  function s4() {
    return Math.floor((1 + Math.random()) * 0x10000)
               .toString(16)
               .substring(1);
  }
  return function() {
    return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
           s4() + '-' + s4() + s4() + s4();
  };
})();



//cssClassChanged Event
(function(){
    // Your base, I'm in it!
    var originalAddClassMethod = jQuery.fn.addClass;

    jQuery.fn.addClass = function(){
        // Execute the original method.
        var result = originalAddClassMethod.apply( this, arguments );

        // trigger a custom event
        jQuery(this).trigger('cssClassChanged');

        // return the original result
        return result;
    }
})();


// -------------------------------------------------------------------------------------------
// smoothScrollTo
// -------------------------------------------------------------------------------------------

(function($) {
    window.smoothScrollTo = function(_target,_offset){

        target = $(_target);
        var currentOffset = $('body').scrollTop();
        if(!_offset || isNaN(_offset)) _offset = 0;
        var targetOffset = target.offset().top - _offset;
        var time = Math.abs(currentOffset - targetOffset);
        if (target.length) {
            $('body,html').animate({
                scrollTop: targetOffset,
                easing:"easeInOutQuad"
            },500,function(){
                
                $('header').focus();
            })
        }
    }

})(jQuery);

// -------------------------------------------------------------------------------------------
// stickyfloat
// -------------------------------------------------------------------------------------------
(function($){
    $(document).ready(function() {
       $('.sticky').parent().height('1000px');
        $('.sticky').parent().css("position","relative");
        $('.sticky').css("position","relative");
       $('.sticky').stickyfloat();
    });
})(jQuery);


/**
 * ...
 * @author Dex
 * Opens a modal
 */

(function($) {
    $.modal = function(id, _modal) {
        if (_modal === false) _modal = false;
        else _modal = true;
        $.fancybox({
            href: id,
            padding: 0,
            closeBtn: false,
            modal: _modal,
            scrolling: false,
            openEffect: 'fade',
            openSpeed: 250,
            closeEffect: 'fade',
            closeSpeed: 150,
            closeClick: false,
            helpers: {
                title: {
                    type: 'inside'
                },
                overlay: {
                    css: {
                        //'background-color' : '#000'
                    },
                    //opacity:0.95
                }
            },
            type: 'inline'
        });
    };
})(jQuery);






// -------------------------------------------------------------------------------------------
// scrollers
// -------------------------------------------------------------------------------------------
(function($) {
   window.scrollers = []
    var scrollers = window.scrollers;
    $(document).ready(function() {
            if($('.scroller').length==0) return;
            var i = 0;
            $('.scroller').each(function(){
                var id = $(this).attr('id');
                if(id=='' || id==undefined) id = "scroller_" + guid();
                $(this).attr('id',id);
                id = "#" + id;

                    $(this).find("ul").slick({
                        dots: true,
                        speed: 300,
                        slidesToShow: 4,
                        autoplay: false,
                        autoplaySpeed: 3000,            
                        infinite: true,
                        variableWidth: true,
                        adaptiveHeight:true,
                        centerMode: false,
                        responsive: [{
                                      breakpoint: 1024,
                                      settings: {
                                        slidesToShow: 4,
                                      }
                                    },
                                    {
                                      breakpoint: 480,
                                      settings: {
                                        slidesToShow: 1,
                                      }
                                    }]

                    });
                i++;
            });
    });
})(jQuery);

// -------------------------------------------------------------------------------------------
// Copy Protection
// -------------------------------------------------------------------------------------------

(function($) {
   $.fn.extend({
        disableSelection : function() {
            return this.each(function() {
                this.onselectstart = function() {
                    return false;
                };
                this.unselectable = "on";
                $(this).css('user-select', 'none');
                $(this).css('-o-user-select', 'none');
                $(this).css('-moz-user-select', 'none');
                $(this).css('-khtml-user-select', 'none');
                $(this).css('-webkit-user-select', 'none');
            });
        },
        disableSelectedAll : function() {
            return this.each(function() {
                this.onkeydown = function(event) {
                    if( event.ctrlKey && (event.keyCode == 65 || event.keyCode == 97) ){
                        event.preventDefault();
                    }
                };
            });
        }
    });
})(jQuery);


// -------------------------------------------------------------------------------------------
// hasScrollbar
// -------------------------------------------------------------------------------------------
(function($) {
    $.fn.hasScrollbar = function() {
        return this.get(0).scrollHeight > this.height();
    }
})(jQuery);





