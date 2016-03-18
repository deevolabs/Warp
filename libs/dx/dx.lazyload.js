(function($){
    $(document).ready(function(){


        //load event fired
        $('img.lazy').on('load',function(){
            el = $(this);

            if(el.attr('src').indexOf('data:image')>-1) return;  
            if(el.attr('src').indexOf('transparent.png')>-1) return;
            if(el.hasClass('loaded')) return;

            //console.log('finish loading ' + el.attr('src'));
            //listen for end transition event
            if(el.parent().parent().hasClass('post-thumb')){
                //console.log('finished loading ')
                //console.log(el);
            }

            el.removeAttr('style');

            el.on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',function(){
                //el.css('transition','none');
                //el.css('-webkit-transition','none');
                //el.height('auto');
                
                //console.log('transition end:',el.css('height'),el);

            })

            el.removeClass('loading');
            el.addClass('loaded');  

        }).each(function(){
            var el = $(this);
            if(el.attr('src').indexOf('data:image')>-1) return;  
            if(el.attr('src').indexOf('transparent.png')>-1) return;
            //console.log('checking:'+this.complete)
            if(this.complete) $(this).load();
        });

         //videos load events
        $("video.lazy").on("error", function(err) {
            for (var i in err.currentTarget.error) {
                console.log(i + ": " + err.currentTarget.error[i]);
            }
        });
        /*
        $("video.lazy").on("progress", function() {
            console.log('video progress');
        });
*/

        $("video.lazy").on("loadstart", function() {
            //console.log('video loadstart');
        });

        $("video.lazy").on("canplaythrough", function() {
            //console.debug("video canplaythrough triggered");
            el = $(this);  
            el.removeClass('loading');
            el.addClass('loaded'); 
        });

        $("video.lazy").on("canplay", function (e) {
          //console.debug("video canplay triggered");
        });


        window.lazyload = function lazyload(el){ 
        	if(el.hasClass('loading') || el.hasClass('loaded')) return; 
        	//console.log( "loading " + el.attr('data-src'));
         	el.addClass('loading'); 

            //images 
            if(el.prop('tagName')=='img' || el.prop('tagName')=='IMG'){
                
                var newsrc=el.attr('data-src');
                el.attr('data-src','');
                el.attr('src',newsrc); 
                //console.log('start loading ' + newsrc);

            }//videos
            else if(el.prop('tagName')=='video' || el.prop('tagName')=='VIDEO'){
                var newsrc=el.find('source')
                el.get(0).pause();
                newsrc.each(function(){
                    var oldsrc = $(this).attr('data-src');
                    $(this).attr('data-src','');
                    $(this).attr('src',oldsrc);              
                });
                el.get(0).load();
                //el.get(0).pause();
            }

           
        }

        //last action 
        $('img.lazy').each(function(){
            var el = $(this);
            var h_nominal = el.attr('height');
            var w_nominal = el.attr('width');
            var w_current = el.width();
            var h = (h_nominal*w_current) / w_nominal;
            


            if(el.parent().parent().hasClass('post-thumb')){

            var a_w = el.parent().width();
            var post_thumb_w = el.parent().parent().width();
            var post_width = el.parent().parent().parent().width();
            var li_width = el.parent().parent().parent().parent().width();

                //console.log('calculating height: ' + h + ';parent');
                //console.log(el);

            }
            //console.log('calculating height: ' + h + ';parent');
            //el.css('height',h+'px !important');            
            el.height(h);            
        });                


        function pauseVideo(target){
            target.get(0).pause();
        }

        function playVideo(target){
            target.get(0).play();
        }


        //detect if onscreen
        $('.lazy').onScreen({
            //container: window,
            //direction: 'vertical',
            doIn: function() {
                lazyload($(this));
                if($(this).prop('tagName')=='VIDEO') playVideo($(this));
            },
            doOut: function() {
                if($(this).prop('tagName')=='VIDEO') pauseVideo($(this));
            },
            tolerance: 100,
            //throttle: 0
        });


    });

})(jQuery);