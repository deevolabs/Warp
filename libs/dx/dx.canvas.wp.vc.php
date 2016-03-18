<?php 

function canvas_func( $atts ) {


	//extract params
	extract( shortcode_atts( array(
		'width' => '256','height' => '256','id'=>'','class'=>'',
		'raw_content' => '','easeljs' => 'false'
	), $atts ) );




	//set canvas unique id for IScroll
	$random = '';
	for ($i = 0; $i < 16; $i++) {
		$random .= chr(rand(ord('a'), ord('z')));
	}
	$canvas_unique_id = 'dx_canvas_' . $random;

	$raw_content =  rawurldecode(base64_decode(strip_tags($raw_content)));

	//get necessary files
	if($easeljs){
		wp_enqueue_script( 'easeljs' );
		wp_enqueue_script( 'tweenjs' );
		wp_enqueue_script( 'movieclip' );
		wp_enqueue_script( 'preloadjs' );		
	}

	//set css class
	$css_class ='dx_canvas ' . $class;

	//start composing HTML structure
	ob_start();
?>

	<div id="<?php echo $id;?>" class="<?php echo $css_class ;?>" >
		<canvas id="<?php echo $canvas_unique_id;?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>"></canvas>
	</div>

<?php 
	$output = ob_get_contents();
	ob_end_clean();
	dx_enqueue_canvas_animation($canvas_unique_id,$raw_content);
    return $output;
}
add_shortcode('dx_canvas', 'canvas_func');




#-----------------------------------------------------------------#
# Get all the canvases scripts in the current page and 
#-----------------------------------------------------------------#
$canvas_anims = Array();
function dx_enqueue_canvas_animation($id,$raw_js){
	global $canvas_anims; 
	$canvas_anims[$id] = $raw_js;

}

function dx_get_canvas_animations(){
	global $canvas_anims; 
	return $canvas_anims;
}



function addCanvasAnimations(){
	$c = dx_get_canvas_animations();
	foreach ($c as $script) {
		echo '<script type="text/javascript">'.$script.'</script>';
	}
	echo '<script src="'.get_bloginfo("template_url").'/libs/dx/dx.canvas.js"></script>';
}
add_action('wp_footer', 'addCanvasAnimations',31);//adds canvas scripts to the ffoter






//apply vc map
vc_map( array(
    "name" => "HTML5 Canvas",
    "base" => "dx_canvas",
    'class'=>'',
    'icon'=>'icon-wpb-raw-javascript',
    //"show_settings_on_create" => true,
	"category" => "Deevo Components",

    // component params
    "params" => array(
    	// general tab
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => "ID",
			"param_name" => "id",
			//'group' =>  'General',
			'description' => ""
		),
        array(
            "type" => "textfield",
            "heading" => "Extra classes",
            "param_name" => "class",
            //'group' =>  'General',
            "description" => "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file."
        ),	
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => "width",
			"param_name" => "width",
			//'group' =>  'General',
			'description' => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => "height",
			"param_name" => "height",
			//'group' =>  'General',
			'description' => ""
		),		


        
        array(
            "type" => "textarea_raw_html",
            "heading" => "Javascript",
            "param_name" => "raw_content",
            //'group' =>  'General',
            "description" => ""
        ),
       
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "",
			"value" => array("Use Easeljs libraries?" => "true" ),
			"param_name" => "easeljs",
			//'group' =>  'General',
			"description" => ""
		)		
      /* */
    )
) );

?>