(function($) {

    $(document).ready(function() {

        if (!$.fancybox) return;
        $.fancybox.hideLoading();

        $('button.lightbox_close').click(function(e) {
            $.fancybox.close();
        });

        var fancyOptions = {
            padding: 0,
            openEffect: 'elastic',
            openSpeed: 300,
            closeEffect: 'elastic',
            closeSpeed: 150,
            nextEffect: 'linear',
            nextSpeed: 150,
            prevEffect: 'linear',
            prevSpeed: 150,
            openOpacity: true,
            closeOpacity: true,
            margin: 0,
            closeBtn: false,
            helpers: {
                title: {
                    //type : 'outside'
                },
                overlay: {
                    speedIn: 300,
                    speedOut: 300,
                    opacity: 0.5
                }
            },
            type:"iframe",
            beforeLoad: function() {
                console.log('fancybox beforeLoad');
            }
        };



        $(".lightbox").tap(function(){
            if($(this).hasClass("gallery")){
                openGallery();
            }else{
                openFancybox($(this));
            }           
            return false;
        });



        function openFancybox(el){
            var _href = el.attr("href");
            var _title = el.attr("title");
            content = {href:_href,title:_title};
            $.fancybox.open(content,fancyOptions);

        }



        function openGallery(el){
            var _href = el.attr("href");
            var _title = el.attr("title");
            content = {href:_href,title:_title};
            $.fancybox.open(content,fancyOptions);

        }


        //$(".lightbox").fancybox(fancyOptions);


    });
})(jQuery);
