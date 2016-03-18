(function($) {

	var galleries = [];

    function initGallery(el){
    	console.log("initGallery");

    	if(!el.attr("id")||el.attr("id")==''){
    		el.attr("id","gallery_"+ guid());
    	}

    	//var gallery_id = el.attr("id");
    	
    	//galleries[gallery_id] = this_gallery;

     	//console.log("just created gallery:" + this_gallery);
    	
     	el.find(".post_scroller .post a").tap(function(){
			switchImage($(this));
			return false;     		
     	});
    };


    function switchImage(a){
    	console.log("switching to " + a.attr("href"));
    	var gal = a.parents('.gallery');
    	gal.find('.viewport img').attr("src",a.attr("href"));
    	gal.find('.legenda').html(a.attr("data-caption"));
    }

    function refresh(el){
    	console.log("refreshing");
    }

    $(document).ready(function() {
        if($('.gallery').length==0) return;
        $('.gallery').each(function(){
            initGallery($(this));
        });
    });

    $(window).resize(function(){
        $('.gallery').each(function(){      
            refresh($(this));
        })
    });


})(jQuery);