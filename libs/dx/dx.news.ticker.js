(function($) {

var news_tickers = [];


function initNewsTicker(el){

    var current = 0;

    var timer = $.timer(function() {        
        var list = el.find("ul.news");
        var n = current+1;

        list.find(">li").removeClass("active");        
        var li = list.find(">li:nth-child("+n+")")
        var top = li.position().top;        
        list.css("top","-"+top+"px");
        li.addClass("active");
        
        if(current<(list.find(">li").length-1)){
          current++;  
        } 
        else{
        //TODO: fade
          current=0;  
        } 


    });

    timer.set({ time : 3000, autostart : true });    


    //pause
    el.mouseover(function(e){
        timer.pause();
    });

    el.mouseout(function(e){
        timer.play();
    });




}










//resize
$(window).resize(function(){


});



//render
$(document).ready(function() {
    if($('.dx_newsTicker').length==0) return;
    $('.dx_newsTicker').each(function(){
        initNewsTicker($(this));
    });
});









})(jQuery);