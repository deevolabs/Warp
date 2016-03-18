
(function($) {

var CTAs = [];

	function initCTAs(el){

		var id = el.attr("id");
		CTAs[id] = el;
		onResize(el);
}


function refresh(el){
	onResize(el);
}

function onResize(el){
    if (el.width() > 600){
        el.removeClass("small").addClass('large');
    }
    else if(el.width() <600){
        el.removeClass("large").addClass('small');
    }
}



$(document).ready(function() {
    
    if($('.dx_calltoaction').length==0) return;
    
    $('.dx_calltoaction').each(function(){
        initCTAs($(this));
    });

    $(window).resize(function(){
        $('.dx_calltoaction').each(function(){      
            refresh($(this));
        })
    })
});




})(jQuery);