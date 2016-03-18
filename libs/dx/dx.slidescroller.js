(function($) {

var slide_scrollers = [];


    function initScroller(el){

        //vars 
        if(!el.attr("id")||el.attr("id")==''){
            el.attr("id","slide_scroller_"+ guid());
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

        slide_scrollers[scroller_id] = el.find(".slides").slick({
            arrows:navigation,
            nextArrow: '<span class="arrow-right icon-arrow-right2"></span>',
            prevArrow: '<span class="arrow-left icon-arrow-left2"></span>',            
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
                }],
                //evento aqui
                setPosition:function(){
                    console.log("teste ----------------------------------------------")
                }

        });

    }

$(window).resize(function(){


});


$(document).ready(function() {
    if($('.dx_slidescroller').length==0) return;
    $('.dx_slidescroller').each(function(){
        initScroller($(this));
    });
});
// contador de slides

var numero = $("div", ".slick-track").size();

$(".container-count").html(numero);


})(jQuery);