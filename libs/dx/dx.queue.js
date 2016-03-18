/*
Download Queue plugin
by Dex
*/

(function($) {
	var imgList = [];
	var id = 0;
	$.extend({
		q:{
			downloading:false,
			add: function(el) {				
				el.attr('data-load-order',id);
				imgList.push([el,false]);
				//console.log('added:'+el.attr('data-src-full') + '('+id+')');
				id++;
				this.checklist();
			},
			checklist:function(){	
				//console.log('checking list')
				if(!$.q.downloading){
					for (i=0;i<imgList.length;i++){
						if(imgList[i][1]==false){
							//console.log('sending '+(imgList[i][0]).attr('data-src-full')+ ' to download queue')
							$.q.download(imgList[i][0])							
							break;	
						}
					}
				}
			},
			download:function(el){
				$.q.downloading = true;
				var that = this;
				
				var newsrc;
				if(screen.width>1024) newsrc= el.attr('data-src-full');
				else if(screen.width<1024 && screen.width>480) newsrc = el.attr('data-src-large');
				else if(screen.width<=480) newsrc = el.attr('data-src-small');				
				
				el.addClass('loading');
				//console.log('downloading ' + newsrc);
				
				el.load(function(success){
					var this_id = $(this).attr('data-load-order');
					//console.log('finished downloading: #'+$(this).attr('src'));
					$(this).removeClass('loading').addClass('ready');
					imgList[this_id][1] = true;
					$.q.downloading = false;
					$(this).trigger('finished', $(this));
					that.checklist();
				})
				//console.log('newsrc:' + newsrc)
				el.attr('src',newsrc);
				
			}
	
		}

		
	});
	//$.q.checklist();
	//setInterval($.q.checklist,100);		
})(jQuery);