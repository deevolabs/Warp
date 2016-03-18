<?php

require_once(get_template_directory() . '/libs/visualcomposer/WPBakeryShortCode_Post_Query.php');

function carousel_func( $atts ) {

	//get necessary files
	wp_enqueue_script( 'iscroll' );
	//wp_enqueue_style( 'dx.slider' );
	//wp_enqueue_script( 'dx.slider' );
	wp_enqueue_style( 'slick' );
	//wp_enqueue_style( 'slick-theme' );
	wp_enqueue_script( 'slick' );	
	wp_enqueue_style( 'dx.postscroller' );
	wp_enqueue_script( 'dx.postscroller' );


	//extract params
	extract( shortcode_atts( array(
		'title' => '','subtext' => '','id'=>'','class'=>'',
		'slider_content'=>'images','images'=>'','posts_query' => '',
		'post_style'=>'thumb_overlay',
		'thumb_size' => '',
		'center_mode' =>'', 'infinite' =>'', 'variable_width' =>'', 'adaptive_height' =>'',
		'mode' => 'horizontal','slides_per_view' => '1','indicators' => '','navigation' => '','gutters' => '','autoplay' => 'no','speed' => '5000'
	), $atts ) );


	//set slider unique id for IScroll
	$random = '';
	for ($i = 0; $i < 16; $i++) {
		$random .= chr(rand(ord('a'), ord('z')));
	}
	$scroller_unique_id = 'post_scroller_' . $random;

	//set css class
	$css_class ='post_scroller ' . $class;

	// ----------------------------- set content  ----------------------------------------
	$posts = array();//used for posts AND for images

	//parse thumb_size;
	$pipe_pos = strpos($thumb_size, ' | ');
	$thumb_size = substr($thumb_size, 0, $pipe_pos);

	if($slider_content=='images'){
		$images = explode( ',', $images );
		$i = - 1;

		foreach ( $images as $attach_id ) {
			$post = new stdClass();
			$post->thumb_img = wp_get_attachment_image_src( $attach_id, $thumb_size );
			$post->thumb_url =$post->thumb_img[0];
			$post->thumb_width = $post->thumb_img[1];
			$post->thumb_height = $post->thumb_img[2];
			$post->link = "#";
			$posts[] = $post;
		}
	}
	else if($slider_content=='posts'){
		//create "posts" object, looping through posts
		//BUG: here is a confusion about how to inherit the class methods

		$c = new WPBakeryShortCode_Carousel(array());
		/*
		$methods = array();
		$d = new ReflectionClass('WPBakeryShortCode_Carousel');
		foreach ($d->getMethods() as $m) {
		     $methods[] = $m->name;
		}
		print_r($methods);
		*/
		$c->resetTaxonomies();
		$c->getLoop( $posts_query );
		$my_query = $c->query;


		while ( $my_query->have_posts() ) {
			$my_query->the_post();
			$post = new stdClass();
			$post->id = get_the_ID();
			$post->date = get_the_date('Y-m-d');
			$post->link = get_permalink( $post->id );
			$post->title = the_title( "", "", false );
			$post->post_type = get_post_type();
			//$post->content = get_the_content();
			$post->excerpt = get_the_excerpt();

			$post->thumb_id = get_post_thumbnail_id( $post->id );
			$post->thumb_img = wp_get_attachment_image_src( $post->thumb_id, $thumb_size );
			$post->thumb_url =$post->thumb_img[0];
			$post->thumb_width = $post->thumb_img[1];
			$post->thumb_height = $post->thumb_img[2];

			//$post->categories_css = $this->getCategoriesCss( $post->id );
			$posts[] = $post;
		}
		wp_reset_query();
	}


	//start composing HTML structure
	ob_start();
?>


		<div id="<?php echo $id;?>" class="<?php echo $css_class;?>" data-infinite="<?php echo $infinite === 'true' ? 'true' : 'false'; ?>" data-adaptive_height="<?php echo $adaptive_height === 'true' ? 'true' : 'false'; ?>" data-center_mode="<?php echo $center_mode === 'true' ? 'true' : 'false'; ?>" data-variable_width="<?php echo $variable_width === 'true' ? 'true' : 'false'; ?>" 
 data-mode="<?php echo $mode; ?>" data-per-view="<?php echo $slides_per_view; ?>" data-interval="<?php echo $autoplay === 'true' ? $speed : 0 ?>" data-navigation="<?php echo $navigation === 'true' ? 'true' : 'false' ?>" data-indicators="<?php echo $indicators === 'true' ? 'true' : 'false'; ?>" data-gutters="<?php echo $gutters === 'true' ? 'true' : 'false' ?>">
			<!-- Wrapper for slides -->
			<div class="posts">
				<?php foreach ( $posts as $post ): ?>
				<div class="post-container">
					<div class="post <?php echo $post_style; ?>">
						<div class="post-thumb">
							<a href="<?php echo $post->link; ?>" class="" title="<?php echo $post->title; ?>">
								<img width="<?php echo $post->thumb_width; ?>" height="<?php echo $post->thumb_height ?>" src="<?php echo $post->thumb_url; ?>" class="lazy" alt="">
							</a>
						</div>
						<?php if($slider_content=='posts'): ?>
						<div class="post-info">
							<h3 class="post-title">
								<a href="<?php echo $post->link; ?>" class="" title="<?php echo $post->title; ?>"><?php echo $post->title; ?></a>
							</h3>
							<p class="excerpt"><?php echo $post->excerpt; ?></p>
						</div>
						<?php endif; ?>
					</div>
				</div>
				<?php endforeach; ?>
			</div>

		</div>
<?php
	$output = ob_get_contents();
	ob_end_clean();
    return $output;
}
add_shortcode('carousel', 'carousel_func');

//apply vc map
vc_map( array(
    "name" => "Post Scroller",
    "base" => "carousel",
    'class'=>'',
    'icon'=>'icon-wpb-vc_carousel',
    "show_settings_on_create" => true,
	"category" => "Deevo Components",

    // component params
    "params" => array(
    	// general tab
        array(
            "type" => "textfield",
            "heading" => "Extra classes",
            "param_name" => "class",
            'group' =>  'General',
            "description" => "CSS Class Name."
        ),

        // content tab


		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Scroller Content",
			"value" => array('Images'=>'images','Teaser Posts'=>'posts'),
			"param_name" => "slider_content",
			'group' =>  'Content',
			"description" => ""
		),


		array(
			"type" => "attach_images",
			"class" => "",
			"heading" => "Images",
			"param_name" => "images",
			'group' =>  'Content',
			"description" => "",
			"dependency" => Array('element' => "slider_content", 'value' => array('images'))
		),
		array(
			"type" => "loop",
			"heading" => __('Posts Query', 'js_composer'),
			"param_name" => "posts_query",
			'value' => 'size:10|order_by:date',
			'settings' => array(
				'size' => array( 'hidden' => false, 'value' => 10 ),
				'order_by' => array( 'value' => 'date' ),
			),
			'group' =>  'Content',
			"description" => "",
			// "dependency" => Array('element' => "slider_content", 'value' => array('posts'))
		),

		// post appearance tab
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => "Post Style",
			"value" => array('thumbnail with overlay'=>'thumb_overlay','post teaser'=>'teaser'),
			"param_name" => "post_style",
			'group' =>  'Slide Appearance',
			"description" => ""
		),

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
			"heading" => "Indicators",
			"value" => array("Show indicators?" => "true" ),
			"param_name" => "indicators",
			'group' =>  'Slider Settings',
			"description" => ""
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "Navigation arrows",
			"value" => array("Show navigation arrows?" => "true" ),
			"param_name" => "navigation",
			'group' =>  'Slider Settings',
			"description" => ""
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "Gutters",
			"value" => array("Show gutters?" => "true" ),
			"param_name" => "gutters",
			'group' =>  'Slider Settings',
			"description" => ""
		),

		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "Center Mode",
			"value" => array("Center Mode?" => "true" ),
			"param_name" => "center_mode",
			'group' =>  'Slider Settings',
			"description" => ""
		),

		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "Infinite",
			"value" => array("Infinite Scroll?" => "true" ),
			"param_name" => "infinite",
			'group' =>  'Slider Settings',
			"description" => ""
		),		

		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "Variable Width",
			"value" => array("Variable Width?" => "true" ),
			"param_name" => "variable_width",
			'group' =>  'Slider Settings',
			"description" => ""
		),
		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => "Adaptive Height",
			"value" => array("Adaptive Height?" => "true" ),
			"param_name" => "adaptive_height",
			'group' =>  'Slider Settings',
			"description" => ""
		),

		 array(
            "type" => "textfield",
            "heading" => "Slides per View",
            "param_name" => "slides_per_view",
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
		),

		array(
            "type" => "textfield",
            "heading" => "Transition speed",
            "param_name" => "speed",
            "value" => "5000",
            'group' =>  'Slider Settings',
            "description" => "Transition speed in milisseconds",
            "dependency" => Array('element' => "autoplay", 'not_empty' => true)

        )

    )
));


//BUG: confusion!! See above
class WPBakeryShortCode_Carousel extends WPBakeryShortCode_Post_Query {}


?>
