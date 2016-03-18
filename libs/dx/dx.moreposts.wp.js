/*
More Posts Button
*******************************************************************/
(function($){
$(document).ready(function(){


	if($('button.MorePosts').length<=0) return;
	
	var btMorePosts = $('button.MorePosts');
	var dataUrl = btMorePosts.attr('data-url');
	var totalPosts = parseInt(btMorePosts.attr('data-total-posts'));
	var posts_per_page = parseInt(btMorePosts.attr('data-posts-per-page'));
	var offset = parseInt(btMorePosts.attr('data-offset'));	
	var post_type = btMorePosts.attr('data-post-type');				
	var category = btMorePosts.attr('data-post-category');				
	var remaining = totalPosts;
	var container = btMorePosts.attr('data-container');
	btMorePosts.append('<div class="icon"></div>');
	
	btMorePosts.click(function(e) {
		offset = parseInt(btMorePosts.attr('data-offset'));
		$(this).addClass('loading');
		var query  = dataUrl + '?post_type='+post_type+'&category_name='+category+'&posts_per_page='+posts_per_page+'&offset='+offset;
		$.ajax({
		   type: "GET",
		   url: query,
		   success: function(postlist){
				offset = offset+posts_per_page;
				btMorePosts.attr('data-offset',offset)
				remaining = totalPosts - offset;
				if(remaining<=0) btMorePosts.hide();
				var h = $(container).height();
				console.log($(container).height())
				$(container).height(h);
				$(container).height(h+185);
				$(container).append(postlist);
				//$("img.lazy").lazyload();
				btMorePosts.removeClass('loading');
		   }
		});
		return false;
	});
	


});

})(jQuery);