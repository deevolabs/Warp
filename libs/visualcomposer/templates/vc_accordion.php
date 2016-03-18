<?php
wp_enqueue_script('dx.accordion');
wp_enqueue_style('dx.accordion');
$output = $collapsible = $active_tab = '';
//
extract(shortcode_atts(array(
    'collapsible' => 'no',
    'active_tab' => '1',
	'id' => '',
	'class' =>''    
), $atts));
$collapsible_class = '';
if($collapsible=='yes') $collapsible_class = 'collapsible ';

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'accordion ' . $collapsible_class . $class, $this->settings['base'], $atts );

$output .= "\n\t".'<div id="'.$id.'" class="'.$css_class.'" data-active-tab="'.$active_tab.'">'; 
$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
$output .= "\n\t".'</div>';

echo $output;