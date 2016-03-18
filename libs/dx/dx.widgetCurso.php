<?php
/*
* Add-on Name: dx Call to Action
* Add-on URI: https://www.deevo.com
*/

if(!class_exists("dx_widgetCurso")){
	


	class dx_widgetCurso{
		function __construct(){
			add_action("init",array($this,"dx_widgetCurso_init"));
			add_shortcode("dx_widgetCurso",array($this,"display_dx_widgetCurso"));

			function widgetCurso_loadScripts(){
				wp_register_style('dx.widgetCurso',get_template_directory_uri() . '/libs/dx/dx.widgetCurso.css');
				wp_register_script('dx.widgetCurso',get_template_directory_uri() . '/libs/dx/dx.widgetCurso.js', 'jquery');
				wp_enqueue_style( 'dx.widgetCurso' );
				wp_enqueue_script( 'dx.widgetCurso' );				
			}

			add_action('wp_enqueue_scripts', 'widgetCurso_loadScripts');

		}
		function dx_widgetCurso_init(){
			if (function_exists('vc_map'))
			{
				vc_map( array(
					"name" => __("Widget Curso", "deevo_components"),
					"base" => "dx_widgetCurso",
					"class" => "",
					"controls" => "full",
					"show_settings_on_create" => true,
					"icon" => "",
					"holder" => "div",
					"description" => __("Widget Curso.", "deevo_components"),
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





		function display_dx_widgetCurso($atts, $content = null){			
			$el_class = '';
			$options = shortcode_atts(array(
				"el_class" => ""
			), $atts);
			ob_start();
			?>
				<div class="dx_widgetCurso aberto <?php echo $options['el_class']; ?>">
					<div class="title">
						<h2><?php the_title(); ?></h2>
					</div>				
					<div class="meta">
						<div class="duracao">
							<span class="title">Duração:</span>
							<span class="value">8 semestres</span>
						</div>
					</div>
					<form>
						<div class="group">
							<span class="title">Períodos:</span>
							<div class="group_periodo">

								<?php if(types_render_field("matutino")): ?>
									<div class="field field_manha">
										<input type="radio" id="periodo_manha" name="periodo" data-periodo="matutino" value="<?php echo types_render_field("matutino") ?>" checked="">
										<label for="periodo_manha">manhã</label>
									</div>
								<?php endif;?>


								<?php if(types_render_field("noturno")): ?>
									<div class="field field_noite">
										<input type="radio" id="periodo_noite" name="periodo" data-periodo="noturno" value="<?php echo types_render_field("noturno") ?>">
										<label for="periodo_noite">noite</label>
									</div>
								<?php endif; ?>
							</div>							
						</div>
						
						<div class="group_mensalidade">
							<span class="title">Mensalidade:</span>
							<?php if(types_render_field("mensalidade-matutino")): ?>
								<div class="mensalidade mensalidade-matutino">R$ <?php echo types_render_field("mensalidade-matutino"); ?></div>
							<?php endif; ?>
							
							<?php if(types_render_field("mensalidade-matutino")): ?>
								<div class="mensalidade mensalidade-noturno">R$ <?php echo types_render_field("mensalidade-noturno"); ?></div>							
							<?php endif; ?>

						</div>



					</form>

					<div class="inscricoesAbertas">
						<div class="text">Inscrições abertas</div>
						<a class='button active inscrever' href='http://estudenafam.com.br'>Inscreva-se</a>						
					</div>

					<div class="interesse">
						<div class="text">Interessado no curso? Deixe seu email e fique informado de novidades!</div>
						<div class="group">
							<input type="email" placeholder="digite seu email">
							<a class='button active enviar' href='#'>ok</a>							
						</div>
					</div>


				</div>
			<?php
			$output = ob_get_contents();
			ob_end_clean();

			return $output;
		}


	}










	new dx_widgetCurso;
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_dx_widgetCurso extends WPBakeryShortCode {
		}
	}
}

