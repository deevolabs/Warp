(function($) {

var post_scrollers = [];


    function initScroller(el){

        //vars 
        if(!el.attr("id")||el.attr("id")==''){
            el.attr("id","post_scroller_"+ guid());
        }
        
        var scroller_id = el.attr('id');
        var mode = el.attr("data-mode");
        var per_view = parseInt(el.attr("data-per-view")); 
        var interval = parseInt(el.attr("data-interval"));
        var navigation = eval(el.attr("data-navigation")); 
        var indicators = eval(el.attr("data-indicators"));
        var gutters = eval(el.attr("data-gutters"));

        var infinite = eval(el.attr("data-infinite"));
        var variableWidth = eval(el.attr("data-variable_width"));
        var adaptiveHeight = eval(el.attr("data-adaptive_height"));
        var centerMode = eval(el.attr("data-center_mode"));




        var autoplay = false;
        if(interval>0) autoplay = true;

        post_scrollers[scroller_id] = el.find(".posts").slick({
            dots: indicators,
            speed: 300,
            slidesToShow: per_view,
            autoplay: autoplay,
            autoplaySpeed: interval,            
            infinite: infinite,
            variableWidth: variableWidth,
            adaptiveHeight:adaptiveHeight,
            centerMode: centerMode,
            responsive: [
                {
                  breakpoint: 1024,
                  settings: {
                    slidesToShow: per_view,
                  }
                },
                {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: 1,
                  }
                }]

        });

    }

$(window).resize(function(){


});


$(document).ready(function() {
    if($('.post_scroller').length==0) return;
    $('.post_scroller').each(function(){
        initScroller($(this));
    });
});



})(jQuery);