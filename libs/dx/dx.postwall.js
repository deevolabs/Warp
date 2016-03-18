(function($){

    window.postwalls = [];


    function postwall(el) {

        var container = el;
        var filter_ul = el.find('ul.filter');
        var taxSelect = el.find('select.taxonomies');
        var wall_ul = el.find('ul.wall');
        var mode = container.attr('data-mode');
        var isotope_obj;
        var strFilter = '*';


        /*----------------------- Refresh Wall -------------------------*/
        function refresh(_filter){
            if(!el.hasClass('isotope')) return;

            strFilter = _filter;
            isotope_obj = wall_ul.isotope({
              itemSelector : 'ul.wall>li',
              layoutMode : mode,
              filter:strFilter,
            }, function(items){
                var id = el.attr('id'),
                len = items.length;
                console.log( 'Isotope has filtered for ' + len + ' items in #' + id );
            });

            var currentTax = taxSelect.val();
            var allterms = filter_ul.find('li');
            var termsList = filter_ul.find('li[data-category-tax="'+currentTax+'"]');
            var allLink = filter_ul.find('li[data-category="*"]');
            allterms.hide();
            termsList.show();
            allLink.show();
            btMorePosts.attr('data-post-category', _filter);
        }
        this.refresh = refresh;




         /*----------------------- Lazy Images -------------------------*/
        $(".postwall img.lazy").bind('cssClassChanged', function(){ 
            if($(this).hasClass('loaded')) {
                parent = $(this).closest('.postwall');
                refresh(strFilter);//TODO: identificar para dar refresh apenas no wall pai
            }
        });

        /*-----------------------Filter -------------------------*/

        filter_ul.find('a').tap(function(){
            var f = $(this).parent().attr('data-category');
            if(f!='*') f = '.'+f;
            refresh(f);
            filter_ul.find('a').removeClass('active');
            $(this).addClass('active');
            return false;
        });
        taxSelect.change(function(){
            refresh(strFilter);            
        });


        /*----------------------- More Posts -------------------------*/
/*        
        //EXEMPLO appending items example (delete on implementation)
        var exampleNodes = ''
        exampleNodes += '<li class="large-3 columns cat2"><a href="#" class="lightbox">21</a></li>';
        exampleNodes += '<li class="large-3 columns cat1"><a href="#" class="lightbox">22</a></li>';
        exampleNodes += '<li class="large-3 columns cat4"><a href="#" class="lightbox">23</a></li>';
        exampleNodes += '<li class="large-3 columns cat3"><a href="#" class="lightbox">24</a></li>';

        container.find('.morePosts button').tap(function(){
            var content = $(exampleNodes);
            wall_ul.append(content);
            wall_ul.isotope( 'appended', content, morePosts_callback )

        });*/



        var btMorePosts = container.find('.morePosts .button');
        btMorePosts.tap(function(e){
            var dataUrl = btMorePosts.attr('data-url');
            var totalPosts = parseInt(btMorePosts.attr('data-total-posts'));
            var posts_per_page = parseInt(btMorePosts.attr('data-posts-per-page'));
            var offset = parseInt(btMorePosts.attr('data-offset'));
            var post_type = btMorePosts.attr('data-post-type');
            var category = btMorePosts.attr('data-post-category');
            var remaining = totalPosts;
            var container = btMorePosts.attr('data-container');
            offset = parseInt(btMorePosts.attr('data-offset'));
            $(this).addClass('loading');
            var query = dataUrl + '?post_type=' + post_type + '&category_name=' + category + '&posts_per_page=' + posts_per_page + '&offset=' + offset;
            $.ajax({
                type: "GET",
                url: query,
                success: function(postlist) {
                    offset = offset + posts_per_page;
                    btMorePosts.attr('data-offset', offset)
                    remaining = totalPosts - offset;
                    if (remaining <= 0) btMorePosts.hide();
                    appended_posts = $(postlist)
                    wall_ul.append(appended_posts);
                    //registerImagesCallback();
                    btMorePosts.removeClass('loading');
                    wall_ul.isotope('appended', appended_posts, morePosts_callback);
                }
            }); 

        });







        function morePosts_callback(){   
            console.log('Just appended items to the wall')
        }




        /*----------------------- resize -------------------------*/    
        $(window).resize(function(){
            refresh(strFilter);            
        });

        //init
        refresh('*');

        // main function's return value
        return this;
}


$(document).on("ready", function(){
    
    if($('.postwall').length==0) return;
    $('.postwall').each(function(){
        var this_postwall = new postwall($(this));
        postwall_id = $(this).attr('id');
        window.postwalls[postwall_id] = this_postwall;
    });

});

})(jQuery);