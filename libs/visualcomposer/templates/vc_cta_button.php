<?php
	//extract params
	extract( shortcode_atts( array(
		'id'=>'','class'=>'','caption'=>'',
		'title' => 'This is a great oportunuty!','call_text'=> 'This is the CTA text. Click on the button now!','button_text' => 'click here','button_class' => '','target' => '','href'=>'#'
	), $atts ) );

	$css_class = 'dx_cta ' . $class;
	ob_start();
?>

	<div id="<?php echo $id;?>" class="<?php echo $css_class; ?>">
		<h2><?php echo $title;?></h2>
		<p><?php echo $call_text;?></p>
		<button class="<?php echo $button_class;?>" href="<?php echo $href;?>" target="<?php echo $target;?>"><?php echo $button_text;?></button>
	</div>

<?php 
	$output = ob_get_contents();
	ob_end_clean();
    echo $output;
?>