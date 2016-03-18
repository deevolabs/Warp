(function($) {

var lightbox_gallery_component;


    function initGallery(){

        lightbox_gallery_component = $(".lightbox_gallery_component");

        //listeners
        $(".lightbox").tap(function(){
            openGallery($(this));
            return false;
        });

        $(".lightbox_gallery_component .btClose").tap(function(){
            closeGallery();
            return false;
        });
        $(".lightbox_gallery_component .lightbox_overlay").tap(function(){
            closeGallery();
            return false;
        });


        $(document).on("tap",".lightbox_gallery_component .thumbscroller a.thumb",function(){
            switchImage($(this));
            return false;                       
        });
     	$(".lightbox_gallery_component .thumbscroller a.thumb").tap(function(){
			switchImage($(this));
			return false;     		
     	});
    };


    function destroyGallery(){

        if(maincarousel!=null){
            maincarousel.off();
            maincarousel.slick('unslick');            
        }

        if(thumbcarousel!=null){
            thumbcarousel.off();
            thumbcarousel.slick('unslick');            
        }
        lightbox_gallery_component.find(".imageBox>.content").html("");
        lightbox_gallery_component.find(".thumbscroller>ul").html("");

    }


    function openGallery(item){

        //destroy previous gallery
        destroyGallery();

        //load Images
        var images = eval(item.attr("data-images"));

        //gallery mode
        if(images!=null && images!=undefined){
            //set gallery title and description
            lightbox_gallery_component.attr("data-metainfo","true");
            lightbox_gallery_component.find("h2").html(item.attr("title"));
            lightbox_gallery_component.find("p").html(item.attr("data-excerpt"));
            createScrollers(images);            
        }
        else{
            //single mode
            lightbox_gallery_component.attr("data-metainfo","false");
            lightbox_gallery_component.attr("data-thumbs","false");
            var imgcode = $('<img class="mainImage" src="'+item.attr("href")+'" alt="'+item.attr("title")+'"/><div class="caption">'+item.attr("title")+'</div>');
            lightbox_gallery_component.find(".imageBox>.content").prepend(imgcode);

        }


        //open gallery
        lightbox_gallery_component.addClass("active");
        if ($(document).height() > $(window).height()) {
             var scrollTop = ($('html').scrollTop()) ? $('html').scrollTop() : $('body').scrollTop(); // Works for Chrome, Firefox, IE...
             $('html').addClass('noscroll').css('top',-scrollTop);             
        }        
        reposition();
    }

    var maincarousel;
    var thumbcarousel;




    function createScrollers(images){

        if(images.length>0){
            populateMainScroller(images);            
        }


        if(images.length>1){
            populateThumbScroller(images);
            lightbox_gallery_component.attr("data-thumbs","true");
        }
        else{
            lightbox_gallery_component.attr("data-thumbs","true");            

        }   


        //listeners
        maincarousel.on('afterChange', function(event, slick, currentSlide, nextSlide){
            console.log(currentSlide);
            if(images[currentSlide].caption!=null){
                $(".imageBox .caption").html(images[currentSlide].caption);                
            }
        });

        //listeners
        maincarousel.on('lazyLoaded', function(event, slick, image){
            console.log(image);
            maincarousel.slick('setPosition');
        });

    }



    function populateMainScroller(images){


        var li="";            
        for (var i = images.length - 1; i >= 0; i--) {
            li += "<li>";
            li += "<img data-lazy='"+images[i].href+"'/>";
            li += "</li>";
        }

        var slidercode = $('<div class="mainscroller horizontal"><ul></ul></div><div class="caption"></div>');   
        lightbox_gallery_component.find(".imageBox>.content").prepend(slidercode);
        lightbox_gallery_component.find(".mainscroller>ul").html("").append(li);

        maincarousel = lightbox_gallery_component.find(".mainscroller>ul").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows:false,
            fade:false,
            asNavFor: '.thumbscroller>ul',
            lazyLoad: 'ondemand',
            //adaptiveHeight: true,
        });

    }


    function populateThumbScroller(images){

        var li="";            
        for (var i = images.length - 1; i >= 0; i--) {
            li += "<li data-index='item item-"+i+"'>";
            li += "<a class='thumb' href='"+images[i].href+"'>";            
            li += "<img data-lazy='"+images[i].thumbnail+"'/>";
            li += "</a>";
            li += "</li>";
        }


        lightbox_gallery_component.find(".thumbscroller>ul").append(li);
        thumbcarousel = lightbox_gallery_component.find(".thumbscroller>ul").slick({
            infinite:true,
            slidesToShow: 10,
            arrows:true,
            nextArrow: '<span class="arrow-right icon-arrow-right2"></span>',
            prevArrow: '<span class="arrow-left icon-arrow-left2"></span>',            
            dots:true,
            //slidesToScroll: 10, 
            variableWidth:true,
            asNavFor: '.mainscroller>ul',
            lazyLoad: 'ondemand',
            centerMode: false,
            focusOnSelect: false
        });

    }




    function closeGallery(){
        lightbox_gallery_component.removeClass("active");
        destroyGallery();
        var scrollTop = parseInt($('html').css('top'));
        $('html').removeClass('noscroll');
        $('html,body').scrollTop(-scrollTop);
    }

    function switchImage(a){
        console.log("switching to " + a.attr("href"));
        console.log("switching to " + a.parent().attr("data-index"));
    }

    function refresh(el){
        console.log("refreshing lightbox_gallery_component");
        reposition();
    }

    function reposition(){
        if(!lightbox_gallery_component) return;
        var scrolltop = $("body").scrollTop();
        lightbox_gallery_component.find(".lightbox_container").offset({ top: scrolltop, left: 0});        
    }


    $(document).ready(function() {
        if($(".lightbox_gallery_component").length==1) initGallery();
    });

    $(window).resize(function(){
        $('.lightbox_gallery_component').each(function(){      
            refresh($(this));
        })
    });


})(jQuery);