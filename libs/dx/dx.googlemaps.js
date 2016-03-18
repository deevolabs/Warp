
(function($) {

	window.googlemaps = [];

	function initMaps(el){

		var id = el.attr("id");

		//get coordinates
		getCoordinates(el)


		//get props
		var marker_url = el.attr("data-marker-url");
		var zoom = parseInt(el.attr("data-zoom"));
		var map_type = el.attr("data-map-type")
		
		var scrollwheel = eval(el.attr("data-scrollwheel"));
		var zoomcontrol = eval(el.attr("data-zoomcontrol"));
		var maptypecontrol = eval(el.attr("data-maptypecontrol"));
		var streetviewcontrol = eval(el.attr("data-streetviewcontrol"));
		var pancontrol = eval(el.attr("data-pancontrol"));
		var zoomcontrolsize = el.attr("data-zoomcontrolsize");

		if($('[data-mapa-id="' + id + '"]').length != 0){
			var content = $('[data-mapa-id="' + id + '"]').html();
		}else{
			var content = false;
		}

		//getStyling
		var styling = el.attr("data-styling");
		var styles = eval(styling);

		var myOptions = {
			center: getCoordinates(el),
			zoom: zoom,
			mapTypeControl: maptypecontrol,
			navigationControlOptions: { style: google.maps.NavigationControlStyle.SMALL},
			mapTypeId: eval("google.maps.MapTypeId."+ map_type),
			scrollwheel: scrollwheel,
			zoomControl: zoomcontrol,
			scaleControl: true,
			streetViewControl: streetviewcontrol,
			mapTypeControl: maptypecontrol,
			panControl: pancontrol,			
			disableDefaultUI: true,
			/*
			zoomControlOptions: {
			  style: eval("google.maps.ZoomControlStyle."+zoomcontrolsize)
			},
			*/
			mapTypeControlOptions: {
        		mapTypeIds: ['Styled']
    		},
			mapTypeId: 'Styled'
		};

		var map = new google.maps.Map(el[0], myOptions);
		var styledMap = new google.maps.StyledMapType(styles,{name: "Styled"});
		map.mapTypes.set('Styled', styledMap);

		if(content != false){
	        var infoWindow = new google.maps.InfoWindow({
	            content: content
	        });
	    }
	

	var marker_image = {
		url: marker_url,
		size: new google.maps.Size(51, 72),
		scaledSize: new google.maps.Size(25, 36),
		origin: new google.maps.Point(-12.5, 0),
		anchor: new google.maps.Point(25, 0)
	};

	
	map.marker_image = marker_image;
	map.coordinates = getCoordinates(el);
	map.markers=[];
	map.infoWindow = infoWindow;

	window.googlemaps[id] = map;

	$.event.trigger({
	  type:    "mapReady",
	  message: "Map Ready",
	  time:    new Date(),
	  srcElement: [map]
	});

    

}

function getCoordinates(el){
	var coord_attr = el.attr("data-coordinates")
	var coords = coord_attr.split("|");
	var lat = coords[0];
	var lng = coords[1];
	return new google.maps.LatLng(lat,lng);
}



function showMarkers(map_component){

	var map = getMap(map_component.attr("id"));

	map.markers[0] = new google.maps.Marker({
		position: map.coordinates, 
		map: map, 
		title:"",
		label: "",
		animation:  google.maps.Animation.DROP,
		icon: map.marker_image
	});

	setTimeout(function(){
		map.infoWindow.open(map, map.markers[0]);
	},500);

}

function hideMarkers(map_component){
	var map = getMap(map_component.attr("id"));
	map.markers[0].setMap(null);
	map.infoWindow.close();
}


function refresh(el){
	var id = el.attr("id");
	google.maps.event.trigger(window.googlemaps[id], 'resize');
	if(window.googlemaps[id]!=null) window.googlemaps[id].setCenter(getCoordinates(el));	
}

function getMap(mapElementId){
	return window.googlemaps[mapElementId];
}

$(document).ready(function() {
    
    if($('.dx_googlemap').length==0) return;
    
    $('.dx_googlemap').each(function(){
        initMaps($(this));
    });

    $(window).resize(function(){
        $('.dx_googlemap').each(function(){      
            refresh($(this));
        })
    })


    $('.dx_googlemap').each(function(){

    	var map_component = $(this);

	    map_component.onScreen({
	        container: window,
	        direction: 'vertical',
	        tolerance: 300,
	        throttle: 0,
	        toggleClass: 'onScreen',
	        doIn: function() {
	     		showMarkers(map_component);
	   		},
		   	doOut: function() {
		     	hideMarkers(map_component)
		    }
		});

    });


	});
})(jQuery);