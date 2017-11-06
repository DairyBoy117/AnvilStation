<?php
$output = $el_class = $css_animation = '';

extract(shortcode_atts(array(
    'el_class' => '',
    'css_animation' => '',
	'el_text_title' => '',
    'css' => '',
    'remove_boxed' => ''
), $atts));

$el_class = $this->getExtraClass($el_class);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_text_column wpb_content_element ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
$css_class .= $this->getCSSAnimation($css_animation);

$output .= "\n\t".'<div class="'.esc_attr($css_class).'">';
$output .= "\n\t\t".'<div class="wpb_wrapper">';
if(!empty($el_text_title)){
    $output .= '<div class="title-wrapper"><h3 class="widget-title">'.esc_attr($el_text_title).'</h3></div>';
}
if($remove_boxed != 'Yes'){
$output .= '<div class="wcontainer">';
}
$output .= "\n\t\t\t".wpb_js_remove_wpautop($content, true);
if($remove_boxed != 'Yes'){
$output .= '</div>';
}
$output .= "\n\t\t".'</div> ' . $this->endBlockComment('.wpb_wrapper');
$output .= "\n\t".'</div> ' . $this->endBlockComment('.wpb_text_column');

echo $output;