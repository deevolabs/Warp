<?php
/*
* Add-on Name: dx Call to Action
* Add-on URI: https://www.deevo.com
*/


if(!class_exists("dx_CallToAction")){
	class dx_CallToAction{
		function __construct(){
			add_action("init",array($this,"calltoaction_init"));
			add_shortcode("dx_call_to_action",array($this,"display_dx_cta"));

			function CTAloadScripts(){
				wp_register_style('dx.calltoaction',get_template_directory_uri() . '/libs/dx/dx.calltoaction.css');
				wp_register_script('dx.calltoaction',get_template_directory_uri() . '/libs/dx/dx.calltoaction.js', 'jquery');
				wp_enqueue_style( 'dx.calltoaction' );
				wp_enqueue_script( 'dx.calltoaction' );				
			}

			add_action('wp_enqueue_scripts', 'CTAloadScripts');

		}
		function calltoaction_init(){
			if (function_exists('vc_map'))
			{
				vc_map( array(
					"name" => __("Call to Action", "deevo_components"),
					"base" => "dx_call_to_action",
					"class" => "",
					"controls" => "full",
					"show_settings_on_create" => true,
					"icon" => "",
					"holder" => "div",
					"description" => __("Call to Action.", "deevo_components"),
					"category" => "Deevo Components",
					"params" => array(
						array(
							"type" => "textarea_html",
							"class" => "",
							"heading" => __("Texto da chamada", "deevo_components"),
							"param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
							"value" => "",
							"group" => "General"
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Texto do Botão", "deevo_components"),
							"param_name" => "button_text",
							"admin_label" => true,
							"value" => "Go!",
							"group" => "General"
						),

						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("URL do Botão", "deevo_components"),
							"param_name" => "button_url",
							"admin_label" => true,
							"value" => "http://www.google.com",
							"group" => "General"
						),


						array(
							"type" => "checkbox",
							"heading" => "",
							"param_name" => "open_new_window",
							"value" => array(
								__("Abrir em uma nova janela?", "deevo_components") => "true",
							),
							"group" => "General"
						),



						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Classe", "deevo_components"),
							"param_name" => "el_class",
							"admin_label" => true,
							"value" => "",
							"description" => __('Classe CSS do elemento','deevo_components'),
							"group" => "General"
						),


						array(
							"type" => "colorpicker",
							"class" => "",
							"heading" => "Background Color",
							"param_name" => "bg_color",
							"value" => "",
							"description" => "",
							"group" =>"Background Options"
						),


						array(
							"type" => "attach_image",
							"class" => "",
							"heading" => "Background Image",
							"param_name" => "bg_image",
							"value" => "",
							"description" => "",
							"group" =>"Background Options"
						),







					)
				));
			}
		}
		function display_dx_cta($atts, $content = null){			
			$button_text = $button_url = $open_new_window = $bg_color = $bg_image = $el_class = '';
			extract(shortcode_atts(array(
				"button_text" => "",
				"button_url" => "",
				"open_new_window" => "",
				"bg_color" => "",
				"bg_image" => "",
				"el_class" => ""
			), $atts));


			$id = "cta_".uniqid();
			
			if($open_new_window == "true"){
				$target = '_blank';
			} else {
				$target = '_self';				
			}


			$style = "";
			if($bg_color) $style = "background-color:".$bg_color.";";

			if(!empty($bg_image)) {
				$bg_image_src = wp_get_attachment_image_src($bg_image, 'full');
				$style.= "background-image:url(".$bg_image_src[0].")";
			}

			$style = "style='".$style."'";


			$output .= "<div id='" . $id . "' class='dx_calltoaction ".$el_class."' ".$style.">";
			$output .= "<div class='heading'>";
			$output .= wpb_js_remove_wpautop($content, true); 
			$output .= "</div>";
			$output .= "<a class='button active' href='".$button_url."' target='".$target."'>";
			$output .= $button_text;
			$output .= "</a>";
			$output .= "</div>";
			
			return $output;
		}
	}
	
	new dx_CallToAction;
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_dx_call_to_action extends WPBakeryShortCode {
		}
	}
}