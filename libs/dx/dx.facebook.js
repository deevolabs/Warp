(function($){

	facebook = function(){        

        var timeline;
        this.refresh = refresh;

		function constructor(){
            createScroller();
			getFacebookPosts();


		}

        function getFacebookPosts(){
            $('#timeline').addClass('loading');
            $.ajax({
            dataType: "json",
              url: "facebook/getposts.php",
              beforeSend: function ( xhr ) {
                xhr.overrideMimeType("text/plain; charset=x-user-defined");
              }
            }).done(function ( data ) {
                $.log(data['data']);
                createPosts(data);
                //addListeners();
                //timeline.refresh();

                $('#timeline').removeClass('loading');
                //timeline.refresh();
            });
        }



        function createPosts(data){
            console.log(data)
            var items=[];   
            var i =  0;    
          $.each(data['data'], function(key, val) {
            if (i>10) return false;
            var n_likes = 0;
            var id = 0;
            var message = '';
            var name = '';
            var avatar = '';
            var img_src = '';
            var img_src_large = '';
            var post_time = '';
            var post_link = '#';
            var title = '';

            if(val['application']) return;
            if(!val['message'] && !val['picture']) return;

            if(val['id']) id = val["id"];
            if(val['message']) message = val["message"];
            if(val['name']) title = val["name"];
            if(message=='' && title !='')
                message = title;

            if(val['from']['name']) name = val["from"]['name'];
            if(val['icon']) avatar = val["icon"];
            if(val['picture']) img_src = val["picture"];
            var p0 = img_src.lastIndexOf('_s.');
            var p1 = p0+2;
            var first_part = img_src.substr(0,p0);
            var extension = img_src.substr(p1,6);
            img_src_large = first_part+'_n'+extension;
            if(val['link']) post_link = val["link"];
            var pic_src="";
            //if(device=='handset'){
             //   pic_src = img_src;
            //}else {
                pic_src = img_src_large;
            //}

            moment.lang('br', {
                relativeTime : {
                    future: "em %s",
                    past:   "%s atrás",
                    s:  "segundos",
                    m:  "um minuto",
                    mm: "%d minutos",
                    h:  "uma hora",
                    hh: "%d horas",
                    d:  "um dia",
                    dd: "%d dias",
                    M:  "um mês",
                    MM: "%d meses",
                    y:  "um ano",
                    yy: "%d anos"
                }
            });
            if(val['created_time']) post_time = val["created_time"];
            post_time = moment(post_time, "YYYY-MM-DDTHH:mm:ss Z").fromNow();
            if(val['likes']) {
                if(val["likes"]['count']) n_likes = val["likes"]['count'];
            }
           
            var post = '';
            post += '<div class="large-12 small-12 columns">';
            post += '<div class="baloon">';
            post += '<div class="header"><div class="facebook icon-facebook"></div><div class="name">'+name+'</div></div>';
            //if(img_src!='')  post += '<a class="pic" target="_blank" href="'+post_link+'"><img class="picture lazy" src="images/transparent.png" data-original="'+pic_src+'" alt="" /></a>';
            post += '<div class="message"><div class="postTime">'+post_time+'</div><a class="messageLink" href="'+post_link+'" target="_blank">'+message+'</a></div>';
            post += '<div class="footer"><div class="likes"><span class="icon icon-thumbs-up"></span><a target="_blank" href="'+post_link+'">'+n_likes+' pessoas</a><span>curtiram isso</span></div></div>';
            post += '</div>';
            post += '</div>';
            post += '</div>';

            var li = '<div class="fbPost row" id="'+id+'">' + post + '</div>'


            items.push(li);
            i++;
          });
           
            $('.fbTimeline .posts').append(items.join(''));

/*
            $('.fbTimeline .fbPost').each(function(){
                $(this).find('.message').jTruncate({
                    length: 50,
                    minTrail: 0,
                    moreText: " [mais]",
                    lessText: " [minimizar]",
                    ellipsisText: "...",
                    moreAni: "fast",
                    lessAni: "fast"
                });
            });
*/
            $('.fbTimeline .fbPost .message').click(function(){
                //timeline.refresh();
            });


/*
            $(".fbTimeline .posts img.lazy").lazyload({
                container: $('div#timeline')
            });


            $('.fbTimeline .posts img').load(function(){
                
                if($(this).attr('src')=='images/transparent.png') return;
                $(this).addClass('active');
                timeline.refresh();
            });
*/

        }



        function createScroller(){
            console.log($('#timeline'));
            /*
            timeline = new IScroll('timeline',{
                snap:false,
                hScrollbar: false,
                vScrollbar: true,
                vScroll:true,
                hScroll:false,
                lockDirection: true,
                fadeScrollbar:true,
                hideScrollbar:true,                
                onScrollStart: function (){
                    //$.log('timeline scrollstart');
                    //$('div#timeline').trigger('scroll');
                },
                onScrollEnd: function(){
                    //$.log('timeline scrollend');
                    //$('div#timeline').trigger('scroll');
                }
            });


            timeline = new IScroll('#timeline',{
                scrollX: false,
                scrollY: true,
                momentum: true,
                snap: true,
                snapSpeed: 400,
                keyBindings: false             
            });

*/
            console.log("timeline>>>>");
            console.log(timeline);
        }



        
        function refresh() {
            //timeline.refresh();
        }

		constructor();
		return this;
	}

})(jQuery);