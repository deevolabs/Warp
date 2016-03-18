<?php
/*
* Add-on Name: dx NewsTicker
* Add-on URI: https://www.deevo.com
*/
if(!class_exists("dx_newsTicker")){
	class dx_newsTicker{
		function __construct(){
			add_action("init",array($this,"dx_newsTicker_init"));
			add_shortcode("dx_newsTicker",array($this,"display_dx_newsTicker"));
			function newsTicker_loadScripts(){
				wp_register_style('dx.newsTicker',get_template_directory_uri() . '/libs/dx/dx.news.ticker.css');
				wp_register_script('dx.newsTicker',get_template_directory_uri() . '/libs/dx/dx.news.ticker.js', 'jquery');
				wp_register_script('jquery.timer', get_template_directory_uri() . '/libs/jquery/jquery.timer.js', 'jquery');

				wp_enqueue_style( 'dx.newsTicker' );
				wp_enqueue_script( 'jquery.timer' );				
				wp_enqueue_script( 'dx.newsTicker' );				
			}
			add_action('wp_enqueue_scripts', 'newsTicker_loadScripts');
		}

		function dx_newsTicker_init(){
			if (function_exists('vc_map'))
			{
				vc_map( array(
					"name" => __("News Ticker", "deevo_components"),
					"base" => "dx_newsTicker",
					"class" => "",
					"controls" => "full",
					"show_settings_on_create" => true,
					"icon" => "",
					"holder" => "div",
					"description" => __("News Ticker.", "deevo_components"),
					"category" => "Deevo Components",
					"params" => array(
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Classe", "deevo_components"),
							"param_name" => "el_class",
							"admin_label" => true,
							"value" => "",
							"description" => __('Classe CSS do elemento','deevo_components'),
							"group" => "Geral"
						),

						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Intervalo", "deevo_components"),
							"param_name" => "interval",
							"admin_label" => true,
							"value" => "5000",
							"description" => __('Intervalo em milissegundos','deevo_components'),
							"group" => "Geral"
						)
					)
				));
			}
		}



		function display_dx_newsTicker($atts, $content = null){			
			$el_class = '';
			$options = shortcode_atts(array(
				"el_class" => ""
			), $atts);
			ob_start();
			?>
				<div class="dx_newsTicker">

					<div class="group">
						<span class="icon-bullhorn"></span>
						<div class="text">
							<ul class="news">
							<?php
								$args = array('post_type' => 'post');
								$the_query = new WP_Query( $args );
								if ( $the_query->have_posts() ) {
								  while ( $the_query->have_posts() ) {
								    $the_query->the_post();
								    echo '<li><a href="'.get_the_permalink().'">' . get_the_title() . '</a></li>';
								  }
								}
								wp_reset_postdata();
							?>
							</ul>
						</div>
					</div>			
					
				</div>

			<?php
			$output = ob_get_contents();
			ob_end_clean();

			return $output;
		}


	}




	new dx_newsTicker;
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_dx_newsTicker extends WPBakeryShortCode {
		}
	}
}