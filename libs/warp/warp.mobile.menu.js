(function($) {
    mobileMenu = function(el) {
    	        /* =============================== mobile menu =========================*/
        
        el.find("ul.nav_menu>li>a").tap(function(){
            el.find("ul.nav_menu .sub-menu").removeClass("active");
            $(this).next(".sub-menu").addClass("active");
            return false;
        });


        el.find(".menu-button a").tap(function(){
            if(!el.hasClass("menuopen"))
                el.addClass("menuopen");
            else
                el.removeClass("menuopen");
            return false;
        });

        function init(){
            $(window).resize(function(){reposition();})
            reposition();
        }

    /* =============================== resize =========================*/
    function reposition(){
        var browserWidth = $(window).width();
        var browserHeight = $(window).height();

        if($('html').hasClass("smallScreen")){
            if(el.find('#menuHolder ul.navbar'.length==0))
                el.find('ul.navbar').appendTo(el.find('#menuHolder>.container'));
        }
        el.find('ul.navbar li').removeClass('active'); 

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
	    var header = new mobileMenu($('header.mobileMenu'));
	    header.show();   
	})



})(jQuery);
