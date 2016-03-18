<?php 

#-----------------------------------------------------------------#
# VC Config
//Este arquivo está beeeem confuso. Na verdade toda essa configuração do visual composer merece ser revisada
#-----------------------------------------------------------------#

function configVC(){


	//set templates path 
	vc_set_template_dir(get_template_directory() . '/libs/visualcomposer/templates/');




	//disable frontend 
	//vc_disable_frontend();
	//disable unused elements
	//vc_remove_element("vc_accordion");
	//vc_remove_element("vc_accordion_tab");
	vc_remove_element("vc_button");
	vc_remove_element("vc_button2");
	vc_remove_element("vc_btn");
	vc_remove_element("vc_carousel");
	//vc_remove_element("vc_cta");
	//vc_remove_element("vc_column");
	//vc_remove_element("vc_column_text");
	//vc_remove_element("vc_cta_button");
	//vc_remove_element("vc_cta_button2");
	vc_remove_element("vc_facebook");
	vc_remove_element("vc_flickr");
	vc_remove_element("vc_gallery");
	vc_remove_element("vc_gmaps");
	vc_remove_element("vc_googleplus");
	vc_remove_element("vc_images_carousel");
	//vc_remove_element("vc_item");
	//vc_remove_element("vc_items");
	vc_remove_element("vc_message");
	vc_remove_element("vc_pie");
	vc_remove_element("vc_pinterest");
	vc_remove_element("vc_posts_grid");
	vc_remove_element("vc_posts_slider");
	vc_remove_element("vc_progress_bar");
	//vc_remove_element("vc_raw_html");
	//vc_remove_element("vc_row");
	//vc_remove_element("vc_separator");
	//vc_remove_element("vc_single_image");
	//vc_remove_element("vc_tab");
	//vc_remove_element("vc_tabs");
	//vc_remove_element("vc_teaser_grid");
	//vc_remove_element("vc_text_separator");
	vc_remove_element("vc_toggle");
	vc_remove_element("vc_tweetmeme");
	vc_remove_element("vc_twitter");
	//vc_remove_element("vc_video");







	vc_remove_element("vc_custom_heading");
	vc_remove_element("vc_empty_space");
	vc_remove_element("vc_media_grid");
	vc_remove_element("vc_basic_grid");
	vc_remove_element("vc_masonry_grid");
	vc_remove_element("vc_masonry_media_grid");
	vc_remove_element("vc_raw_js");
	vc_remove_element("vc_icon");
	

	vc_remove_element("vc_widget_sidebar");
	vc_remove_element("vc_wp_archives");
	vc_remove_element("vc_wp_calendar");
	vc_remove_element("vc_wp_categories");
	vc_remove_element("vc_wp_custommenu");
	vc_remove_element("vc_wp_links");
	vc_remove_element("vc_wp_meta");
	vc_remove_element("vc_wp_pages");
	vc_remove_element("vc_wp_posts");
	vc_remove_element("vc_wp_recentcomments");
	vc_remove_element("vc_wp_rss");
	vc_remove_element("vc_wp_search");
	vc_remove_element("vc_wp_tagcloud");
	vc_remove_element("vc_wp_text");



	// VC_Row Mods/Additions --------------------------------------------------------------------------
	vc_remove_param("vc_row", "font_color");
	vc_remove_param("vc_row", "margin_bottom");
	vc_remove_param("vc_row", "padding");
	vc_remove_param("vc_row", "el_class");
	//vc_remove_param('vc_row', 'css' );
	vc_remove_param('vc_row', 'full_width' );
	vc_remove_param('vc_row', 'parallax' );
	vc_remove_param('vc_row', 'parallax_image' );
	vc_remove_param('vc_row', 'el_id' );
	

	vc_add_param("vc_row", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "ID",
		"param_name" => "id",
		"value" => "",
		'description' => "",
		'group' =>'General'
	));

	vc_add_param("vc_row", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "Extra Classes",
		"param_name" => "class",
		"value" => "",
		"group" => "General"
	));

/*
	vc_add_param("vc_row", array(
		"type" => "checkbox",
		"class" => "",
		"heading" => "Fullwidth",
		"value" => array("Fullwidth row?" => "true" ),
		"param_name" => "fullwidth",
		"description" => "",
		"group" =>"General"
	));
*/
	vc_add_param("vc_row", array(
		"type" => "dropdown",
		"class" => "",
		"heading" => "Row Stretching",
		"value" => array('Default'=>'default','Fullwidth row'=>'fullwidth','Fullwidth row and content'=>'fullwidth_content'),
		"param_name" => "row_stretching",
		'group' =>  'General',
		"description" => "",
	));



	vc_add_param("vc_row", array(
		"type" => "colorpicker",
		"class" => "",
		"heading" => "Background Color",
		"param_name" => "bg_color",
		"value" => "",
		"description" => "",
		"group" =>"Background Options"
	));


	vc_add_param("vc_row", array(
		"type" => "attach_image",
		"class" => "",
		"heading" => "Background Image",
		"param_name" => "bg_image",
		"value" => "",
		"description" => "",
		"group" =>"Background Options"
	));


	vc_add_param("vc_row", array(
		"type" => "checkbox",
		"class" => "",
		"heading" => "Parallax Background",
		"value" => array("Enable Parallax Background?" => "true" ),
		"param_name" => "parallax_bg",
		"description" => "",
		"group" =>"Background Options"
	));


	vc_add_param("vc_row", array(
		"type" => "checkbox",
		"class" => "",
		"heading" => "Video Background",
		"value" => array("Enable Video Background?" => "use_video" ),
		"param_name" => "video_bg",
		"description" => "",
		"group" =>"Background Options"
	));

	vc_add_param("vc_row", array(
		"type" => "checkbox",
		"class" => "",
		"heading" => "Video Color Overlay",
		"value" => array("Enable a color overlay ontop of your video?" => "true" ),
		"param_name" => "enable_video_color_overlay",
		"description" => "",
		"group" =>"Background Options",
		"dependency" => Array('element' => "video_bg", 'value' => array('use_video'))
	));

	vc_add_param("vc_row", array(
		"type" => "colorpicker",
		"class" => "",
		"heading" => "Overlay Color",
		"param_name" => "video_overlay_color",
		"value" => "",
		"description" => "",
		"group" =>"Background Options",
		"dependency" => Array('element' => "enable_video_color_overlay", 'value' => array('true'))
	));

	vc_add_param("vc_row", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "WebM File URL",
		"value" => "",
		"param_name" => "video_webm",
		"description" => "You must include this format & the mp4 format to render your video with cross browser compatibility. OGV is optional.
	Video must be in a 16:9 aspect ratio.",
		"group" =>"Background Options",
		"dependency" => Array('element' => "video_bg", 'value' => array('use_video'))
	));

	vc_add_param("vc_row", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "MP4 File URL",
		"value" => "",
		"param_name" => "video_mp4",
		"description" => "Enter the URL for your mp4 video file here",
		"group" =>"Background Options",
		"dependency" => Array('element' => "video_bg", 'value' => array('use_video'))
	));

	vc_add_param("vc_row", array(
		"type" => "attach_image",
		"class" => "",
		"heading" => "Video Background Image",
		"param_name" => "video_poster",
		"value" => "",
		"description" => "Image to be used intead of the video, in mobile devices",
		"group" =>"Background Options",
		"dependency" => Array('element' => "video_bg", 'value' => array('use_video'))

	));


	// VC_Row Mods/Additions --------------------------------------------------------------------------
	vc_remove_param("vc_row_inner", "font_color");
	vc_remove_param("vc_row_inner", "margin_bottom");
	vc_remove_param("vc_row_inner", "padding");
	vc_remove_param("vc_row_inner", "el_class");
	vc_remove_param('vc_row_inner', 'css' );
	vc_remove_param('vc_row', 'parallax' );
	vc_remove_param('vc_row', 'parallax_image' );
	vc_remove_param('vc_row', 'el_id' );


	vc_add_param("vc_row_inner", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "ID",
		"param_name" => "id",
		"value" => "",
		'description' => ""
	));

	vc_add_param("vc_row_inner", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "Extra Classes",
		"param_name" => "class",
		"value" => ""
	));


	vc_add_param("vc_row_inner", array(
		"type" => "colorpicker",
		"class" => "",
		"heading" => "Background Color",
		"param_name" => "bg_color",
		"value" => "",
		"description" => ""
	));


	vc_add_param("vc_row_inner", array(
		"type" => "attach_image",
		"class" => "",
		"heading" => "Background Image",
		"param_name" => "bg_image",
		"value" => "",
		"description" => ""
	));


	vc_add_param("vc_row_inner", array(
		"type" => "checkbox",
		"class" => "",
		"heading" => "Parallax Background",
		"value" => array("Enable Parallax Background?" => "true" ),
		"param_name" => "parallax_bg",
		"description" => "",
		"dependency" => Array('element' => "bg_image", 'not_empty' => true)
	));


	vc_add_param("vc_row_inner", array(
		"type" => "checkbox",
		"class" => "",
		"heading" => "Video Background",
		"value" => array("Enable Video Background?" => "use_video" ),
		"param_name" => "video_bg",
		"description" => ""
	));

	vc_add_param("vc_row_inner", array(
		"type" => "checkbox",
		"class" => "",
		"heading" => "Video Color Overlay",
		"value" => array("Enable a color overlay ontop of your video?" => "true" ),
		"param_name" => "enable_video_color_overlay",
		"description" => "",
		"dependency" => Array('element' => "video_bg", 'value' => array('use_video'))
	));

	vc_add_param("vc_row_inner", array(
		"type" => "colorpicker",
		"class" => "",
		"heading" => "Overlay Color",
		"param_name" => "video_overlay_color",
		"value" => "",
		"description" => "",
		"dependency" => Array('element' => "enable_video_color_overlay", 'value' => array('true'))
	));

	vc_add_param("vc_row_inner", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "WebM File URL",
		"value" => "",
		"param_name" => "video_webm",
		"description" => "You must include this format & the mp4 format to render your video with cross browser compatibility. OGV is optional.
	Video must be in a 16:9 aspect ratio.",
		"dependency" => Array('element' => "video_bg", 'value' => array('use_video'))
	));

	vc_add_param("vc_row_inner", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "MP4 File URL",
		"value" => "",
		"param_name" => "video_mp4",
		"description" => "Enter the URL for your mp4 video file here",
		"dependency" => Array('element' => "video_bg", 'value' => array('use_video'))
	));

	vc_add_param("vc_row_inner", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "OGV File URL",
		"value" => "",
		"param_name" => "video_ogv",
		"description" => "Enter the URL for your ogv video file here",
		"dependency" => Array('element' => "video_bg", 'value' => array('use_video'))
	));

	vc_add_param("vc_row_inner", array(
		"type" => "attach_image",
		"class" => "",
		"heading" => "Video Preview Image",
		"value" => "",
		"param_name" => "video_image",
		"description" => "",
		"dependency" => Array('element' => "video_bg", 'value' => array('use_video'))
	));


	// VC_column -------------------------------------------------------------------------
	vc_remove_param('vc_column', 'css');
	vc_remove_param('vc_column', 'css');


	// VC_column_text -------------------------------------------------------------------------
	vc_remove_param('vc_column_text', 'css');
	vc_remove_param('vc_column_text', 'css_animation');
	vc_add_param("vc_column_text", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "ID",
		"param_name" => "id",
		"value" => "",
		'description' => ""
	));


	vc_add_param("vc_column_text", array(
		"type" => "checkbox",
		"class" => "",
		"heading" => "Parallax Effect",
		"param_name" => "parallax_effect",
		"value" => array("Apply Parallax Effect?" => "false" ),
		'group' =>  'Appearance',
		"description" => ""
	));

	vc_add_param("vc_column_text", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "Parallax Ratio",
		"param_name" => "parallax_ratio",
		"value" => "0.5",
		'description' => "The ratio of parallax scroll effect"
	));


	// VC_Tabs --------------------------------------------------------------------------

	vc_remove_param("vc_tabs", "title");
	vc_remove_param("vc_tabs", "interval");
	vc_remove_param("vc_tabs", "el_class");
	vc_remove_param('vc_tabs', 'css' );

	vc_add_param("vc_tabs", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "ID",
		"param_name" => "id",
		"value" => "",
		'description' => ""
	));

	vc_add_param("vc_tabs", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "Extra Classes",
		"param_name" => "class",
		"value" => ""
	));

	// VC_Accordion --------------------------------------------------------------------------

	vc_remove_param("vc_accordion", "title");
	vc_remove_param("vc_accordion", "interval");
	vc_remove_param("vc_accordion", "el_class");
	vc_remove_param('vc_accordion', 'css' );
	

	vc_add_param("vc_accordion", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "ID",
		"param_name" => "id",
		"value" => "",
		'description' => ""
	));

	vc_add_param("vc_accordion", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "Extra Classes",
		"param_name" => "class",
		"value" => ""
	));



	// VC_Text_Separator --------------------------------------------------------------------------


	vc_remove_param("vc_text_separator", "el_width");
	vc_remove_param("vc_text_separator", "style");
	vc_remove_param("vc_text_separator", "color");
	vc_remove_param("vc_text_separator", "accent_color");
	vc_remove_param("vc_text_separator", "el_class");
	vc_remove_param('vc_text_separator', 'css' );

	vc_add_param("vc_text_separator", array(
		"type" => "textarea",
		"class" => "",
		"heading" => "Subtext",
		"param_name" => "subtext",
		"value" => "",
		'description' => ""
	));

	vc_add_param("vc_text_separator", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "ID",
		"param_name" => "id",
		"value" => "",
		'description' => ""
	));

	vc_add_param("vc_text_separator", array(
		"type" => "textfield",
		"class" => "",
		"heading" => "Extra Classes",
		"param_name" => "class",
		"value" => ""
	));

	// VC_Single_Image --------------------------------------------------------------------------

	vc_remove_param("vc_single_image", "title");
	vc_remove_param("vc_single_image", "image");
	vc_remove_param("vc_single_image", "img_size");
	vc_remove_param("vc_single_image", "img_link_large");
	vc_remove_param("vc_single_image", "img_link");
	vc_remove_param("vc_single_image", "link");
	vc_remove_param("vc_single_image", "img_link_target");
	vc_remove_param("vc_single_image", "alignment");
	vc_remove_param("vc_single_image", "el_class");
	vc_remove_param("vc_single_image", "css_animation");
	vc_remove_param("vc_single_image", "style");
	vc_remove_param("vc_single_image", "border_color");
	vc_remove_param("vc_single_image", "css");

    	// general tab		
		vc_add_param("vc_single_image", array(
			"type" => "textfield",
			"class" => "",
			"heading" => "ID",
			"param_name" => "id",
			'group' =>  'General',
			'description' => ""
		));
        vc_add_param("vc_single_image", array(
            "type" => "textfield",
            "heading" => "Extra classes",
            "param_name" => "class",
            'group' =>  'General',
            "description" => "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file."
        ));
        //appearance
		vc_add_param("vc_single_image", array(
			"type" => "attach_image",
			"class" => "",
			"heading" => "Image",
			"param_name" => "image",
			"value" => "",
			'group' =>  'Appearance',
			"description" => ""
		));	               
		vc_add_param("vc_single_image", array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Image Size",
			"value" => list_thumbnail_sizes(),
			"param_name" => "thumb_size",
			'group' =>  'Appearance',
			"description" => "this is the image that will be used to compose the thumbnail. It will be stretched to fill the thumbnail size as defined by the CSS rules.",
		));	        
		vc_add_param("vc_single_image", array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Image Link",
			"value" =>  array('No link'=>'no_link','Link to larger Image'=>'link_larger','Custom Link'=>'link_custom'),
			"param_name" => "link_to",
			'group' =>  'Appearance',
			"description" => ""
		));	
		vc_add_param("vc_single_image", array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Custom link",
			"param_name" => "custom_link",
			'group' =>  'Appearance',
			'description' => "",
			"dependency" => Array('element' => "link_to", 'value' => array('link_custom')),
		));
	    vc_add_param("vc_single_image", array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "",
			"value" => array("Open in lightbox" => "true" ),
			"param_name" => "lightbox",
			'group' =>  'Appearance',
			"description" => "",
		));
	    vc_add_param("vc_single_image", array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "",
			"value" => array("enable lazyload" => "true" ),
			"param_name" => "lazyload",
			'group' =>  'Appearance',
			"description" => ""
		));
        vc_add_param("vc_single_image", array(
            "type" => "textfield",
            "heading" => "Caption",
            "param_name" => "caption",
            'group' =>  'Appearance',
            "description" => "This text will appear as a caption below the image"
        ));
		vc_add_param("vc_single_image", array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Horizontal Alignment",
			"value" =>  array('None'=>'none','left'=>'left','right'=>'right','center'=>'center'),
			"param_name" => "alignment",
			'group' =>  'Appearance',
			"description" => ""
		));




	// VC_Single_Image --------------------------------------------------------------------------

	vc_remove_param("vc_cta_button", "color");
	vc_remove_param("vc_cta_button", "icon");
	vc_remove_param("vc_cta_button", "size");
	vc_remove_param("vc_cta_button", "href");
	vc_remove_param("vc_cta_button", "title");
	vc_remove_param("vc_cta_button", "target");
	vc_remove_param("vc_cta_button", "call_text");
	vc_remove_param("vc_cta_button", "alignment");
	vc_remove_param("vc_cta_button", "el_class");
	vc_remove_param("vc_cta_button", "css_animation");
	vc_remove_param("vc_cta_button", "position");
	vc_remove_param("vc_cta_button", "css");












    	// general tab		
		vc_add_param("vc_cta_button", array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Title",
			"param_name" => "title",
			'group' =>  'General',
			'description' => ""
		));

		vc_add_param("vc_cta_button", array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Engaging Text",
			"param_name" => "call_text",
			'group' =>  'General',
			'description' => ""
		));

		vc_add_param("vc_cta_button", array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Text on the button",
			"param_name" => "button_text",
			'group' =>  'General',
			'description' => ""
		));


    		
		vc_add_param("vc_cta_button", array(
			"type" => "textfield",
			"class" => "",
			"heading" => "ID",
			"param_name" => "id",
			'group' =>  'General',
			'description' => ""
		));
        vc_add_param("vc_cta_button", array(
            "type" => "textfield",
            "heading" => "Extra classes",
            "param_name" => "class",
            'group' =>  'General',
            "description" => "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file."
        ));


        // Link Parameters tab	
		vc_add_param("vc_cta_button", array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Button Class",
			"param_name" => "button_class",
			'group' =>  'Link Parameters',
			'description' => ""
		));


		vc_add_param("vc_cta_button", array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Button Link",
			"param_name" => "href",
			'group' =>  'Link Parameters',
			'description' => ""
		));		

		vc_add_param("vc_cta_button", array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Button Link target",
			"param_name" => "target",
			'group' =>  'Link Parameters',
			'description' => ""
		));
}

add_action("init","configVC");



// Filter to Replace default css class for vc_row shortcode and vc_column
function custom_css_classes_for_vc_row_and_vc_column($class_string, $tag) {
    $class_string = str_replace('vc_row-fluid', '', $class_string);
    $class_string = str_replace('wpb_row', '', $class_string);
    $class_string = preg_replace('/vc_span(\d{1,2})/', 'large-$1 columns', $class_string);
    $class_string = preg_replace('/vc_col-sm-(\d{1,2})/', 'large-$1 columns', $class_string);
    $class_string = str_replace('wpb_column', '', $class_string);
    $class_string = str_replace('column_container', '', $class_string);

	return $class_string;
}

add_filter('vc_shortcodes_css_class', 'custom_css_classes_for_vc_row_and_vc_column', 10, 2);

?>