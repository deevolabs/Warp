
// -------------------------------------------------------------------------------------------
// Accordion
// -------------------------------------------------------------------------------------------
(function($)
{
	$.fn.accordion = function()
	{
		var container = $(this);


		//parse collapsible feature
		var collapsible = false;
		if(container.hasClass('collapsible')) collapsible = true;

		//parse data-active-tab
		var active_tab = parseInt(container.attr('data-active-tab'));
		var target = container.find('.toggler:nth-child('+active_tab+')')
		activateToggler(target);

		//click event
		container.find("a.toggler_heading").tap(function(){
			activateToggler($(this).parent());
			return false;
		})

		//individual toggler activation
		function activateToggler(el){
			var h = el.find('.toggler_content').outerHeight();

			if(el.hasClass('active')){
				el.removeClass('active');
				el.find('.toggler_container').css('max-height','0px');
			}
			else
			{
				if(collapsible) deactivateAllTogglers();
				el.find('.toggler_container').css('max-height',h+'px');
				el.addClass('active');
			}
		}

		function deactivateAllTogglers(){
				container.find('.toggler_container').css('max-height','0px');
				container.find('.toggler').removeClass('active');			
		}
	};

	$(document).on("ready", function(){
		if(jQuery.fn.accordion){
			if(jQuery('.accordion').length>0){
				jQuery('.accordion').accordion();		
			} 	
		} 
		
	});



})(jQuery);

