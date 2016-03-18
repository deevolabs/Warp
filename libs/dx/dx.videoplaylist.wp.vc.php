<?php 

function dx_video_playlist_func( $atts ) {

	//get necessary files
	wp_enqueue_script( 'respond' );
	wp_enqueue_style( 'dx.video.playlist' );
	wp_enqueue_script( 'dx.video.playlist' );
	


	//extract params
	extract( shortcode_atts( array(
		'title' => '','subtext' => '','id'=>'','class'=>'',
		'thumb_size' => '',
		'mode' => 'horizontal','autoplay' => 'no'
	), $atts ) );


	//set css class
	$css_class ='dx_video_playlist ' . $class;

	

	//start composing HTML structure
	ob_start();
?>

		<div id="<?php echo $id;?>" class="<?php echo $css_class ;?>" data-mode="<?php echo $mode ?>" data-autoplay="<?php echo $autoplay === 'true' ? 'true' : 'false' ?>">

			<!-- title -->
			<?php if($title):?>
				<div class="title">
					<h3><?php echo $title; ?></h3>
					<p class="subtext"><?php echo $subtext; ?></p>
				</div>
			<?php endif; ?>


        <div id="rp_plugin">
            <div id="rp_videoContainer">
                <div id="rp_video">
                </div>
            </div>
            <div id="rp_playlistContainer">
                <ul id="rp_playlist">
                </ul>
            </div>
        </div>

		</div>
<?php 
	$output = ob_get_contents();
	ob_end_clean();
    return $output;
}
add_shortcode('dx_video_playlist', 'dx_video_playlist_func');



//apply vc map
vc_map( array(
    "name" => "Video Playlist",
    "base" => "dx_video_playlist",
    'class'=>'',
    'icon'=>'icon-wpb-vc_carousel',
    "show_settings_on_create" => true,
	"category" => "Deevo Components",

    // component params
    "params" => array(
    	// general tab
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Title",
			"param_name" => "title",
			'group' =>  'General',
			'description' => "Leave empty if you don't want a title above your carousel"
		),	
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => "Subtext",
			"param_name" => "subtext",
			'group' =>  'General',
			'description' => "Text to appear near the title"
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

 
		// post appearance tab
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Image Size",
			"value" => list_thumbnail_sizes(),
			"param_name" => "thumb_size",
			'group' =>  'Slide Appearance',
			"description" => "this is the image that will be used to compose the thumbnail. It will be stretched to fill the thumbnail size as defined by the CSS rules."
		),


		// slider settings tab
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "View Mode",
			"value" => array('horizontal'=>'horizontal','vertical'=>'vertical'),
			"param_name" => "mode",
			'group' =>  'Slider Settings',
			"description" => ""
		),

		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "Autoplay",
			"value" => array("autoplay?" => "true" ),
			"param_name" => "autoplay",
			'group' =>  'Slider Settings',
			"description" => ""
		)


      
    )
) );


//BUG: confusion!! See above
//class WPBakeryShortCode_Carousel extends WPBakeryShortCode_Post_Query {}


?>