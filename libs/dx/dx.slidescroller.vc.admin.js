(function($) {

	//Add slide to the Scroller
	$(document).on("click",".vc_tta-dx-slidescroller .addSlide",function(e){
		console.log("clicado");
		var newTabTitle, params, shortcode;
		newTabTitle = "Slide";
		params = {
			shortcode: "dx_slide",
			params: { title: newTabTitle },
			parent_id: $(this).parents(".wpb_dx_slidescroller").attr("data-model-id"),
			//order: (_.isBoolean( prepend ) && prepend ? vc.add_element_block_view.getFirstPositionIndex() : vc.shortcodes.getNextOrder()),
			//prepend: prepend // used in notifySectionRendered to create in correct place tab
		};
		shortcode = vc.shortcodes.create( params );
		e.preventDefault();
		e.stopPropagation();
		return false;
	});


})(jQuery);