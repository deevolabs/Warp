<?php
/*
* Add-on Name: dx slidescroller
* Add-on URI: https://www.deevo.com
*/

class dx_slidescroller{
	function __construct(){
		
		add_shortcode("dx_slidescroller",array($this,"display_dx_slidescroller"));

		add_shortcode("dx_slide",array($this,"display_dx_slide"));
		
		add_action("init",array($this,"dx_slidescroller_init"));


		function slidescroller_loadScripts(){
			wp_register_style('dx.slidescroller',get_template_directory_uri() . '/libs/dx/dx.slidescroller.css');
			wp_register_script('dx.slidescroller',get_template_directory_uri() . '/libs/dx/dx.slidescroller.js', 'jquery');
			wp_enqueue_style( 'slick' );
			wp_enqueue_script( 'slick' );	
			wp_enqueue_style( 'dx.slidescroller' );
			wp_enqueue_script( 'dx.slidescroller' );
		}
		add_action('wp_enqueue_scripts', 'slidescroller_loadScripts');
	}

	function dx_slidescroller_init(){

			//container object
			vc_map( array(
				"name" => __("Slide Scroller", "deevo_components"),
				"base" => "dx_slidescroller",
				"class" => "",
				"controls" => "full",
				"icon" => "",
				"holder" => "div",
				"description" => __("Scrollable carousel with slides.", "deevo_components"),
				"category" => "Deevo Components",
				'is_container' => true,
				'show_settings_on_create' => false,
				'as_parent' => array(
					'only' => 'dx_slide'
				),		
				'allowed_container_element' => 'vc_row,vc_row_inner,vc_column',				
				'js_view' => 'VcBackendTtaPageableView',
			    "params" => array(
			    	// general tab
			        array(
			            "type" => "textfield",
			            "heading" => "Extra classes",
			            "param_name" => "class",
			            'group' =>  'General',
			            "description" => "CSS Class Name."
			        ),

					array(
						"type" => "checkbox",
						"class" => "",
						"heading" => "Indicators",
						"value" => array("Show indicators?" => "true" ),
						"param_name" => "indicators",
						'group' =>  'General',
						"description" => ""
					),
					array(
						"type" => "checkbox",
						"class" => "",
						"heading" => "Navigation arrows",
						"value" => array("Show navigation arrows?" => "true" ),
						"param_name" => "navigation",
						'group' =>  'General',
						"description" => ""
					),


					array(
						"type" => "checkbox",
						"class" => "",
						"heading" => "Center Mode",
						"value" => array("Center Mode?" => "true" ),
						"param_name" => "center_mode",
						'group' =>  'General',
						"description" => ""
					),

					array(
						"type" => "checkbox",
						"class" => "",
						"heading" => "Infinite",
						"value" => array("Infinite Scroll?" => "true" ),
						"param_name" => "infinite",
						'group' =>  'General',
						"description" => ""
					),		

					array(
						"type" => "checkbox",
						"class" => "",
						"heading" => "Variable Width",
						"value" => array("Variable Width?" => "true" ),
						"param_name" => "variable_width",
						'group' =>  'General',
						"description" => ""
					),
					array(
						"type" => "checkbox",
						"class" => "",
						"heading" => "Adaptive Height",
						"value" => array("Adaptive Height?" => "true" ),
						"param_name" => "adaptive_height",
						'group' =>  'General',
						"description" => ""
					),

					 array(
			            "type" => "textfield",
			            "heading" => "Slides per View",
			            "value"=>"1",
			            "param_name" => "slides_per_view",
			            'group' =>  'General',
			            "description" => ""
			        ),

					array(
						"type" => "checkbox",
						"class" => "",
						"heading" => "Autoplay",
						"value" => array("autoplay?" => "true" ),
						"param_name" => "autoplay",
						'group' =>  'General',
						"description" => ""
					),

					array(
			            "type" => "textfield",
			            "heading" => "Transition speed",
			            "param_name" => "speed",
			            "value" => "5000",
			            'group' =>  'General',
			            "description" => "Transition speed in milisseconds",
			            "dependency" => Array('element' => "autoplay", 'not_empty' => true)

			        ),
			        array(
			            'type' => 'css_editor',
			            'heading' => __( 'Css', 'my-text-domain' ),
			            'param_name' => 'css',
			            'group' => __( 'Design options', 'my-text-domain' ),
			        )			        

			    ),
				'custom_markup' => '

						<style>
							.vc_tta-dx-slidescroller{margin-top:0 !important;}

							.wpb_dx_slidescroller > .vc_controls {
							    opacity: 1 !important;
							    filter: alpha(opacity=100) !important;
							    visibility: visible;
							    position: relative;
							    height: 23px;
							    margin: 18px 0 0px 0;
							    border: 1px dotted #e6e6e6;
							    border-bottom-width: 0;
							    background: whitesmoke;

							    }			
							.wpb_dx_slidescroller > .wpb_element_wrapper {
							    padding: 10px !important;
							    border: 1px solid transparent !important;
							    border-radius: 2px !important;
							    background-color: whitesmoke !important;
							    background-position: 10px 10px !important;
							    background-repeat: no-repeat !important;
							    min-height: 33px !important;
							}    			
							.wpb_dx_slide>.wpb_element_wrapper .vc_tta-panel-body>.vc_controls {
							    position: relative;
							    height: 45px;
							    margin-top: -15px;
							    opacity: 1 !important;
							    filter: alpha(opacity=100) !important;
							    visibility: visible;
							}

							.wpb_dx_slidescroller .vc_tta-section-append{
								display:none !important;
							}

							.wpb_dx_slidescroller .addSlide{
								float:right;
							}

						</style>

						<div class="vc_tta-dx-slidescroller vc_tta-container vc_tta-o-non-responsive" data-vc-action="collapse">
							<div class="vc_general vc_tta vc_tta-tabs vc_tta-pageable vc_tta-color-backend-tabs-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-spacing-1 vc_tta-tabs-position-top vc_tta-controls-align-left">
								<div class="vc_tta-tabs-container">'
												. '<a href="#" class="addSlide">Adicionar Slide</a> '
							                   . '<ul class="vc_tta-tabs-list">'
							                   . '<li class="vc_tta-tab" data-vc-tab data-vc-target-model-id="{{ model_id }}" data-element_type="vc_tta_section"><a href="javascript:;" data-vc-tabs data-vc-container=".vc_tta" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-target-model-id="{{ model_id }}"><span class="vc_tta-title-text">{{ section_title }}</span></a></li>'
							                   . '</ul>
								</div>
								<div class="vc_tta-panels vc_clearfix {{container-class}}">
								  {{ content }}
								</div>
							</div>
						</div>

						',
				
				'default_content' => '
					[dx_slide title="' . sprintf( "%s %d", __( 'Slide', 'js_composer' ), 1 ) . '"][/dx_slide]
					[dx_slide title="' . sprintf( "%s %d", __( 'Slide', 'js_composer' ), 2 ) . '"][/dx_slide]
					',
				
				'admin_enqueue_js' => array(
						//vc_asset_url( 'lib/vc_tabs/vc-tabs.js' );
						get_template_directory_uri() . '/libs/dx/dx.slidescroller.vc.admin.js'
					)


			));



			//slide component
			vc_map( array(
				'name' => __( 'Slide', 'js_composer' ),
				'base' => 'dx_slide',
				'icon' => 'icon-wpb-ui-tta-section',
				'show_settings_on_create' => false,
				'category' => __( 'Deevo Components', 'js_composer' ),
				'description' => __( 'Section for Tabs, Tours, Accordions.', 'js_composer' ),
				'allowed_container_element' => 'dx_slidescroller',
				'is_container' => true,
				'as_child' => array(
					'only' => 'dx_slidescroller',
				),
				"content_element" => true,		
				'js_view' => 'VcBackendTtaSectionView',
				'custom_markup' => '
					<div class="vc_tta-panel-heading">
					titulo
					    <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left"><a href="javascript:;" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-accordion data-vc-container=".vc_tta-container"><span class="vc_tta-title-text">{{ section_title }}</span><i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i></a></h4>
					</div>
					<div class="vc_tta-panel-body">
						{{ editor_controls }}
						<div class="{{ container-class }}">
						{{ content }}
						</div>
					</div>',
				'default_content' => '',
				"params" => array(
					array(
						'type' => 'textfield',
						'param_name' => 'title',
						'heading' => __( 'Title', 'js_composer' ),
						'description' => __( 'Enter section title (Note: you can leave it empty).', 'js_composer' ),
					),
					array(
						'type' => 'el_id',
						'param_name' => 'tab_id',
						'settings' => array(
							'auto_generate' => true,
						),
						'heading' => __( 'Section ID', 'js_composer' ),
						'description' => __( 'Enter section ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'js_composer' ),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Extra class name', 'js_composer' ),
						'param_name' => 'el_class',
						'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
					)

				),				
			) );
	}



	function display_dx_slidescroller($atts, $content = null){			
		$el_class = '';
		extract(shortcode_atts(array(
		'class'=>'',
		'center_mode' =>'', 'infinite' =>'', 'variable_width' =>'', 'adaptive_height' =>'',
		'mode' => 'horizontal','slides_per_view' => '1','indicators' => '','navigation' => '','gutters' => '','autoplay' => 'no','speed' => '5000'
		), $atts));



			//set css class
		$css_class ='dx_slidescroller ' . $class;


		ob_start();
		?>
			<div class="<?php echo $css_class;?>" data-infinite="<?php echo $infinite === 'true' ? 'true' : 'false'; ?>" data-adaptive_height="<?php echo $adaptive_height === 'true' ? 'true' : 'false'; ?>" data-center_mode="<?php echo $center_mode === 'true' ? 'true' : 'false'; ?>" data-variable_width="<?php echo $variable_width === 'true' ? 'true' : 'false'; ?>" 
 data-mode="<?php echo $mode; ?>" data-per-view="<?php echo $slides_per_view; ?>" data-interval="<?php echo $autoplay === 'true' ? $speed : 0 ?>" data-navigation="<?php echo $navigation === 'true' ? 'true' : 'false' ?>" data-indicators="<?php echo $indicators === 'true' ? 'true' : 'false'; ?>" >
				
				<div class="slides">
					<?php echo wpb_js_remove_wpautop( $content ); ?>					
				</div>
			</div>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	function display_dx_slide($atts, $content = null){			
		$el_class = '';
		$options = shortcode_atts(array(
			"el_class" => ""
		), $atts);

		ob_start();
		?>
			<div class="dx_slide">
				<?php echo wpb_js_remove_wpautop( $content ); ?>		
			</div>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}




new dx_slidescroller;

VcShortcodeAutoloader::getInstance()->includeClass( 'WPBakeryShortCode_VC_Tta_Pageable' );

//o nome da classe é formado por 'WPBakeryShortCode_' + o nome do shortcode com as primeiras letras maiúsculas
class WPBakeryShortCode_Dx_Slidescroller extends WPBakeryShortCode_VC_Tta_Pageable {

	public function __construct( $settings ) {
		parent::__construct( $settings );
		//$this->shortcodeScripts();
		//echo "hello";
	}

	public function shortcodeScripts() {

	}


}

VcShortcodeAutoloader::getInstance()->includeClass( 'WPBakeryShortCode_VC_Tta_Section' );
//if ( class_exists( 'WPBakeryShortCode_VC_Tta_Section' ) ) {
    class WPBakeryShortCode_Dx_Slide extends WPBakeryShortCode_VC_Tta_Section {



    }
//}