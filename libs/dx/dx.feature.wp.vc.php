<?php 

function dx_feature_func( $atts ) {


	//extract params
	extract( shortcode_atts( array(
		'title' => '','subtext' => '','id'=>'','class'=>'',
		'alignment' => 'none','image'=> '','thumb_size' => 'full','lazyload' => 'false','lightbox' => 'false','link_to'=>'no_link','custom_link'=>''
		
	), $atts ) );


	//set image
	$pipe_pos = strpos($thumb_size, ' | ');
	$thumb_size = substr($thumb_size, 0, $pipe_pos);
	$thumb_img = wp_get_attachment_image_src( $image, $thumb_size );
	$thumb_url =$thumb_img[0];
	$thumb_width = $thumb_img[1];
	$thumb_height = $thumb_img[2];


	//set css class
	if($alignment!='none') $alignment_class = 'alignment-' .$alignment ;
	else $alignment_class = '';

	//link_to
	if($link_to==='link_larger'){
		$large_img = wp_get_attachment_image_src( $image,'full' );
		$link =$large_img[0];		
	}
	else if($link_to==='link_custom'){
		$link = $custom_link;
	}
	else{$link="#";}

	//set css class
	$css_class ='dx_feature ' . $class. $alignment_class;;

	//start composing HTML structure
	ob_start();
?>
	<div id="<?php echo $id;?>" class="<?php echo $css_class;?>">
		<img src="<?php echo $thumb_url; ?>" alt="" width="<?php echo $thumb_width; ?>" height="<?php echo $thumb_height; ?>" />
		<h3><?php echo $title; ?></h3>
		<p class="subtext"><?php echo $subtext; ?></p>
	</div>
<?php 
	$output = ob_get_contents();
	ob_end_clean();
    return $output;
}
add_shortcode('dx_feature', 'dx_feature_func');



//apply vc map
vc_map( array(
    "name" => "Feature",
    "base" => "dx_feature",
    'class'=>'',
    'icon'=>'',
    //"show_settings_on_create" => true,
    // component params
    "params" => array(
    	// general tab

		array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Title",
			"param_name" => "title",
			'group' =>  'General',
			'description' => ""
		),
        array(
            "type" => "textarea",
            "heading" => "Subtext",
            "param_name" => "subtext",
            'group' =>  'General',
            "description" => ""
        ),	

		array(
			"type" => "textfield",
			"class" => "",
			"heading" => "ID",
			"param_name" => "id",
			'group' =>  'General',
			'description' => ""
		),
        array(
            "type" => "textfield",
            "heading" => "Extra classes",
            "param_name" => "class",
            'group' =>  'General',
            "description" => "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file."
        ),	


        //appearance
		array(
			"type" => "attach_image",
			"class" => "",
			"heading" => "Image",
			"param_name" => "image",
			"value" => "",
			'group' =>  'Appearance',
			"description" => ""
		),	               
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Image Size",
			"value" => list_thumbnail_sizes(),
			"param_name" => "thumb_size",
			'group' =>  'Appearance',
			"description" => "this is the image that will be used to compose the thumbnail. It will be stretched to fill the thumbnail size as defined by the CSS rules.",
		),	        
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Image Link",
			"value" =>  array('No link'=>'no_link','Link to larger Image'=>'link_larger','Custom Link'=>'link_custom'),
			"param_name" => "link_to",
			'group' =>  'Appearance',
			"description" => ""
		),	
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Custom link",
			"param_name" => "custom_link",
			'group' =>  'Appearance',
			'description' => "",
			"dependency" => Array('element' => "link_to", 'value' => array('link_custom')),
		),
	    array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "",
			"value" => array("Open in lightbox" => "true" ),
			"param_name" => "lightbox",
			'group' =>  'Appearance',
			"description" => "",
		),
	    array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "",
			"value" => array("enable lazyload" => "true" ),
			"param_name" => "lazyload",
			'group' =>  'Appearance',
			"description" => ""
		),
        array(
            "type" => "textfield",
            "heading" => "Caption",
            "param_name" => "caption",
            'group' =>  'Appearance',
            "description" => "This text will appear as a caption below the image"
        ),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Horizontal Alignment",
			"value" =>  array('None'=>'none','left'=>'left','right'=>'right','center'=>'center'),
			"param_name" => "alignment",
			'group' =>  'Appearance',
			"description" => ""
		),
    )
) );

?>