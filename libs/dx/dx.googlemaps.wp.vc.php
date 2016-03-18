<?php
/*
* Add-on Name: dx Google Maps
* Add-on URI: https://www.deevo.com
*/
if(!class_exists("dx_Google_Maps")){
	class dx_Google_Maps{
		function __construct(){
			add_action("init",array($this,"google_maps_init"));
			add_shortcode("dx_google_map",array($this,"display_dx_map"));

			function googlemaps_loadScripts(){
				wp_register_script("googleapis","https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false",array(),ULTIMATE_VERSION,false);
				//wp_register_script("googleapis","http://maps.googleapis.com/maps/api/js?v=3key=AIzaSyDrrFLqQH6YrFsmqkg4MpdfL67vbUO8c6o&sensor=false",array(),ULTIMATE_VERSION,false);
				wp_register_style('dx.googlemaps',get_template_directory_uri() . '/libs/dx/dx.googlemaps.css');
				wp_register_script('dx.googlemaps',get_template_directory_uri() . '/libs/dx/dx.googlemaps.js', 'jquery');
				wp_enqueue_style( 'dx.googlemaps' );
				wp_enqueue_script( 'googleapis' );				
				wp_enqueue_script( 'dx.googlemaps' );				
			}

			add_action('wp_enqueue_scripts', 'googlemaps_loadScripts');

		}
		function google_maps_init(){
			if ( function_exists('vc_map'))
			{
				vc_map( array(
					"name" => __("dx Google Map", "deevo_components"),
					"base" => "dx_google_map",
					"class" => "vc_google_map",
					"controls" => "full",
					"show_settings_on_create" => true,
					"icon" => "vc_google_map",
					"description" => __("Display Google Maps to indicate your location.", "deevo_components"),
					"category" => "Deevo Components",
					"params" => array(
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Map type", "deevo_components"),
							"param_name" => "map_type",
							"admin_label" => true,
							"value" => array(__("Roadmap", "deevo_components") => "ROADMAP", __("Satellite", "deevo_components") => "SATELLITE", __("Hybrid", "deevo_components") => "HYBRID", __("Terrain", "deevo_components") => "TERRAIN"),
							"group" => "General Settings"
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Latitude", "deevo_components"),
							"param_name" => "lat",
							"admin_label" => true,
							"value" => "-23.54363",
							"description" => '<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">'.__('Here is a tool','deevo_components').'</a> '.__('where you can find Latitude & Longitude of your location', 'deevo_components'),
							"group" => "General Settings"
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Longitude", "deevo_components"),
							"param_name" => "lng",
							"admin_label" => true,
							"value" => "-46.65820",
							"description" => '<a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">'.__('Here is a tool','deevo_components').'</a> '.__('where you can find Latitude & Longitude of your location', "deevo_components"),
							"group" => "General Settings"
						),
						array(
							"type" => "dropdown",
							"heading" => __("Map Zoom", "deevo_components"),
							"param_name" => "zoom",
							"value" => array(
								__("18 - Default", "deevo_components") => 12, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 13, 14, 15, 16, 17, 18, 19, 20
							),
							"group" => "General Settings"
						),
						array(
							"type" => "checkbox",
							"heading" => "",
							"param_name" => "scrollwheel",
							"value" => array(
								__("Disable map zoom on mouse wheel scroll", "deevo_components") => "disable",
							),
							"group" => "General Settings"
						),
						array(
							"type" => "textarea_html",
							"class" => "",
							"heading" => __("Info Window Text", "deevo_components"),
							"param_name" => "content",
							"value" => "",
							"group" => "Info Window"
						),

						array(
							"type" => "ult_switch",
							"heading" => __("Open on Marker Click","deevo_components"),
							"param_name" => "infowindow_open",
							"options" => array(
								"infowindow_open_value" => array(
									"label" => "",
									"on" => __("Yes","deevo_components"),
									"off" => __("No","deevo_components"),
								)
							),
							"value" => "infowindow_open_value",
							"group" => "Info Window",
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Marker/Point icon", "deevo_components"),
							"param_name" => "marker_icon",
							"value" => array(__("Use Google Default", "deevo_components") => "default",  __("Upload Custom", "deevo_components") => "custom"),
							"group" => "Marker"
						),
						array(
							"type" => "attach_image",
							"class" => "",
							"heading" => __("Upload Image Icon:", "deevo_components"),
							"param_name" => "icon_img",
							"admin_label" => true,
							"value" => "",
							"description" => __("Upload the custom image icon.", "deevo_components"),
							"dependency" => Array("element" => "marker_icon","value" => array("custom")),
							"group" => "Marker"
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Street view control", "deevo_components"),
							"param_name" => "streetviewcontrol",
							"value" => array(__("Disable", "deevo_components") => "false", __("Enable", "deevo_components") => "true"),
							"group" => "Advanced"
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Map type control", "deevo_components"),
							"param_name" => "maptypecontrol",
							"value" => array(__("Disable", "deevo_components") => "false", __("Enable", "deevo_components") => "true"),
							"group" => "Advanced"
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Map pan control", "deevo_components"),
							"param_name" => "pancontrol",
							"value" => array(__("Disable", "deevo_components") => "false", __("Enable", "deevo_components") => "true"),
							"group" => "Advanced"
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Zoom control", "deevo_components"),
							"param_name" => "zoomcontrol",
							"value" => array(__("Disable", "deevo_components") => "false", __("Enable", "deevo_components") => "true"),
							"group" => "Advanced"
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Zoom control size", "deevo_components"),
							"param_name" => "zoomcontrolsize",
							"value" => array(__("Small", "deevo_components") => "SMALL", __("Large", "deevo_components") => "LARGE"),
							"dependency" => Array("element" => "zoomControl","value" => array("true")),
							"group" => "Advanced"
						),
						
						array(
							"type" => "textarea_raw_html",
							"class" => "",
							"heading" => __("Google Styled Map JSON","deevo_components"),
							"param_name" => "map_style",
							"value" => "",
							"description" => "<a target='_blank' href='http://gmaps-samples-v3.googlecode.com/svn/trunk/styledmaps/wizard/index.html'>".__("Click here","deevo_components")."</a> ".__("to get the style JSON code for styling your map.","deevo_components"),
							"group" => "Styling",
						),
						array(
								"type" => "textfield",
								"heading" => __("Extra class name", "deevo_components"),
								"param_name" => "el_class",
								"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "deevo_components"),
								"group" => "General Settings"
						),
						array(
							"type" => "ult_param_heading",
							"text" => "<span style='display: block;'><a href='http://bsf.io/f57sh' target='_blank'>".__("Watch Video Tutorial","deevo_components")." &nbsp; <span class='dashicons dashicons-video-alt3' style='font-size:30px;vertical-align: middle;color: #e52d27;'></span></a></span>",
							"param_name" => "notification",
							'edit_field_class' => 'ult-param-important-wrapper ult-dashicon ult-align-right ult-bold-font ult-blue-font vc_column vc_col-sm-12',
							"group" => "General Settings"
						),
					)
				));
			}
		}
		function display_dx_map($atts, $content = null){

			$width = $height = $map_type = $lat = $lng = $zoom = $streetviewcontrol = $maptypecontrol = $top_margin = $pancontrol = $zoomcontrol = $zoomcontrolsize = $marker_icon = $icon_img = $map_override = $output = $map_style = $scrollwheel = $el_class = '';
			extract(shortcode_atts(array(
				//"id" => "map",
				"map_type" => "ROADMAP",
				"lat" => "18.591212",
				"lng" => "73.741261",
				"zoom" => "14",
				"scrollwheel" => "",
				"streetviewcontrol" => "",
				"maptypecontrol" => "",
				"pancontrol" => "",
				"zoomcontrol" => "",
				"zoomcontrolsize" => "",
				"marker_icon" => "",
				"icon_img" => "",
				"map_style" => "",
				"el_class" => "",
				"infowindow_open" => "",
				"map_vc_template" => ""
			), $atts));

			if($marker_icon == "default"){
				$icon_url = "";
			} else {
				$ico_img = wp_get_attachment_image_src( $icon_img, 'large');
				$icon_url = $ico_img[0];
			}

			$id = "map_".uniqid();
			$map_type = strtoupper($map_type);
			
			if($scrollwheel == "disable"){
				$scrollwheel = 'false';
			} else {
				$scrollwheel = 'true';
			}

			$styling = rawurldecode(base64_decode(strip_tags($map_style)));

			$output .= "<div id='" . $id . "' class='dx_googlemap' data-coordinates='".$lat . '|' . $lng."' data-zoom='".$zoom."' data-map-type='".$map_type."' data-marker-url='".$icon_url."' data-scrollwheel='".$scrollwheel."' data-streetviewcontrol='".$streetviewcontrol."' data-maptypecontrol='".$maptypecontrol."' data-pancontrol='".$pancontrol."' data-zoomcontrol='".$zoomcontrol."' data-zoomcontrolsize='".$zoomcontrolsize."' data-styling='".$styling."'>";
			$output .= "</div>";

			$content = str_replace("<p>", "", $content);
			$content = str_replace("</p>", "", $content);

			$output .= "<div data-mapa-id='".$id."' style='display: none;'>".$content."</div>";

			return $output;
		}
	}
	new dx_Google_Maps;
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_dx_google_map extends WPBakeryShortCode {
		}
	}
}