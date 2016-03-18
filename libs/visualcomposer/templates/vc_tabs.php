<?php

extract( shortcode_atts( array(
	'id' => '',
	'class' =>''
), $atts ) );

wp_enqueue_script('dx.tabs');
wp_enqueue_style('dx.tabs');

$element = 'wpb_tabs';
if ( 'vc_tour' == $this->shortcode ) $class = 'vertical ' . $class;
else $class = 'horizontal ' . $class;
/**/

// Extract tab titles
preg_match_all( '/vc_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
$tab_titles = array();
/**
 * vc_tabs
 *
 */
if ( isset( $matches[1] ) ) {
	$tab_titles = $matches[1];
}

$tabs_nav = '';

// ul
$tabs_nav .= '<ul class="nav">';
foreach ( $tab_titles as $tab ) {
    $tab_atts = shortcode_parse_atts($tab[0]);
    if(isset($tab_atts['title'])) {
        $tabs_nav .= '<li><a href="#tab-' . ( isset( $tab_atts['tab_id'] ) ? $tab_atts['tab_id'] : sanitize_title( $tab_atts['title'] ) ) . '">' . $tab_atts['title'] . '</a></li>';
    }
}
$tabs_nav .= '</ul>' . "\n";

// select
$tabs_nav .= '<select class="nav">';
foreach ( $tab_titles as $tab ) {
	$tab_atts = shortcode_parse_atts($tab[0]);
	if(isset($tab_atts['title'])) {
		$tabs_nav .= '<option value="#tab-' . ( isset( $tab_atts['tab_id'] ) ? $tab_atts['tab_id'] : sanitize_title( $tab_atts['title'] ) ) . '">' . $tab_atts['title'] . '</value>';
	}
}
$tabs_nav .= '</select>' . "\n";

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

$output .= '';
$output .= "\n\t" . '<div id="'.$id.'" class="tabs ' . $css_class . '">';
//$output .= "\n\t\t" . '<div class="wpb_wrapper wpb_tour_tabs_wrapper ui-tabs vc_clearfix">';
//$output .= wpb_widget_title( array( 'title' => $title ) );
$output .= "\n\t\t\t" . $tabs_nav;
$output .= "\n\t\t\t" . '<ul class="content">';
$output .= "\n\t\t\t" . wpb_js_remove_wpautop( $content );
$output .= "\n\t\t\t" . '</ul>';
/*
if ( 'vc_tour' == $this->shortcode ) {
	$output .= "\n\t\t\t" . '<div class="wpb_tour_next_prev_nav vc_clearfix"> <span class="wpb_prev_slide"><a href="#prev" title="' . __( 'Previous slide', 'js_composer' ) . '">' . __( 'Previous slide', 'js_composer' ) . '</a></span> <span class="wpb_next_slide"><a href="#next" title="' . __( 'Next slide', 'js_composer' ) . '">' . __( 'Next slide', 'js_composer' ) . '</a></span></div>';
}
*/
//$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
$output .= "\n\t" . '</div> ' . $this->endBlockComment( $element );

echo $output;