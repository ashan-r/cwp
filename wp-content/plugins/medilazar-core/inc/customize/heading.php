<?php
if (!defined('ABSPATH')) {
    exit;
}
$heading_css    = '';
$tertiary_css   = '';
$quaternary_css = '';
/**
 * @var array $heading_font
 */
$heading_font = sanitize_font_weight(get_theme_mod('osf_typography_general_heading_font'));
if (is_array($heading_font)) {
    if ($heading_font['family'] && $heading_font['family'] != '') {
        $heading_css .= "font-family:\"{$heading_font['family']}\",-apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif;";
        if (isset($heading_font['fontWeight'])) {
            $heading_css .= "font-weight:{$heading_font['fontWeight']};";
        }
    }
}


$font_style = get_theme_mod('osf_typography_general_heading_font_style');
if (is_array($font_style)) {
    if ($font_style['italic']) {
        $heading_css .= "font-style:italic;";
    }
    if ($font_style['underline']) {
        $heading_css .= "text-decoration:underline;";
    }
    if ($font_style['fontWeight']) {
        $heading_css .= "font-weight:bold;";
    }

    if ($font_style['uppercase']) {
        $heading_css .= "text-transform:uppercase;";
    }
}

/**
 * @var $line_height
 */
//$line_height = get_theme_mod( 'osf_typography_general_heading_line_height', 30 );
//if ($line_height && $line_height != 30){
//    $heading_css .= "line-height: {$line_height}px;";
//}

/**
 * @var array $tertiary_font
 */
$tertiary_font = sanitize_font_weight(get_theme_mod('osf_typography_general_tertiary_font'));
if (is_array($tertiary_font)) {
    if ($tertiary_font['family']) {
        $tertiary_css .= "font-family:\"{$tertiary_font['family']}\",-apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif;";
    }
    if (isset($tertiary_font['fontWeight']) && $tertiary_font['fontWeight']) {
        $tertiary_css .= "font-weight:{$tertiary_font['fontWeight']};";
    }
}

/**
 * @var array $tertiary_font
 */
$quaternary_font = sanitize_font_weight(get_theme_mod('osf_typography_general_quaternary_font'));
if (is_array($quaternary_font)) {
    if ($quaternary_font['family']) {
        $quaternary_css .= "font-family:\"{$quaternary_font['family']}\",-apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif;";
    }
    if (isset($quaternary_font['fontWeight']) && $quaternary_font['fontWeight']) {
        $quaternary_css .= "font-weight:{$quaternary_font['fontWeight']};";
    }
}

/**
 * @var $letter_spacing
 */
$letter_spacing = get_theme_mod('osf_typography_general_heading_letter_spacing', 0);
if ($letter_spacing && $letter_spacing != 0) {
    $heading_css .= "letter-spacing: {$letter_spacing}px;";
}

if (is_array($heading_font)) {
    if (isset($heading_font['family']) && $heading_font['family']) {
        $cssCode .= <<<CSS
            .elementor-widget-heading .elementor-heading-title{
                font-family: "{$heading_font['family']}", -apple-system, BlinkMacSystemFont, Sans-serif;
            }
CSS;
    }

    if (isset($heading_font['fontWeight']) && $heading_font['family'] != '') {
        $cssCode .= <<<CSS
            .elementor-widget-heading .elementor-heading-title,
            .elementor-text-editor b {
                font-weight: {$heading_font['fontWeight']};
            }
CSS;
    }
}


$cssCode .= apply_filters('osf_customize_typo_heading', $cssCode, $heading_css);
$cssCode .= apply_filters('osf_customize_typo_tertiary', $cssCode, $tertiary_css);
$cssCode .= apply_filters('osf_customize_typo_quaternary', $cssCode, $quaternary_css);

return $cssCode;