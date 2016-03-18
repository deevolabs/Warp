// -------------------------------------------------------------------------------------------
// section onscreen class
// -------------------------------------------------------------------------------------------
(function($) {


    function set_videoBG_position(){
        $('.row.videobg').each(function(){
            var video = $(this).find("video");
            var row = $(this);
            var row_id = row.attr("id");
            var w = video.width();
            var h = video.height();
            var ww = row.width();
            var hh = row.height();
            var video_ratio = w/h;
            var row_ratio = ww/hh;
            console.log("row#"+row_id+" size:" + ww + "x" + hh + "; ratio:" + row_ratio);
            console.log("row#"+row_id+" video size:" + w + "x" + h + "; ratio:" + video_ratio);
            if(row_ratio<video_ratio){
                //use row's height as base
                video.height(hh);
                //video.width = hh*video_ratio;
                video.css("width","auto"); 
            }else{
                //use row's width as base
                video.width(ww);
                video.css("height","auto");
                //video.width = hh*video_ratio;
            }

        });

    }


    $(window).resize(function(){
        set_videoBG_position();
    });

    $(document).ready(function() {



    //set videobg
    set_videoBG_position();


    //parallax effect
      if(!$("body").hasClass("smartphone")){

        	$(window).stellar( { 
          	// Set scrolling to be in either one or both directions
            horizontalScrolling: false,
            verticalScrolling: true,

            // Set the global alignment offsets
            horizontalOffset: 0,
            verticalOffset: 0,

            // Refreshes parallax content on window load and resize
            responsive: true,

            // Select which property is used to calculate scroll.
            // Choose 'scroll', 'position', 'margin' or 'transform',
            // or write your own 'scrollProperty' plugin.
            scrollProperty: 'scroll',

            // Select which property is used to position elements.
            // Choose between 'position' or 'transform',
            // or write your own 'positionProperty' plugin.
            positionProperty: 'position',

            // Enable or disable the two types of parallax
            parallaxBackgrounds: true,
            parallaxElements: true,

            // Hide parallax elements that move outside the viewport
            hideDistantElements: false,

            // Customise how elements are shown and hidden
            //hideElement: function($elem) { $elem.hide(); },
            //showElement: function($elem) { $elem.show(); }
          });
    }



    //section activation
    $('.section').onScreen({
        container: window,
        direction: 'vertical',
        tolerance: 300,
        throttle: 0,
        toggleClass: 'onScreen'
    });




    });
})(jQuery);