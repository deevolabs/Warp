(function($){
var canvas, stage, exportRoot;
var easeljs_loaders = [];

function handleFileLoad(evt) {
	//console.log(evt);
	if (evt.item.type == "image") { images[evt.item.id] = evt.result; }
}

function handleComplete() {
	exportRoot = new lib.radar();
	stage = new createjs.Stage(canvas);
	stage.addChild(exportRoot);
	stage.update();

	createjs.Ticker.setFPS(lib.properties.fps);
	createjs.Ticker.addEventListener("tick", stage);
}

$(document).ready(function(){
	$('.dx_canvas').each(function(){
		var div = $(this);
		canvas = div.find('canvas')[0];

		//load dependencies
		var loader = new createjs.LoadQueue(false);
		loader.addEventListener("fileload", handleFileLoad);
		loader.addEventListener("complete", handleComplete);
		loader.loadManifest(lib.properties.manifest);
	})


});



})(jQuery);
