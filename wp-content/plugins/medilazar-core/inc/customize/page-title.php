<?php
$cssCode             = '';
$breadcrumb_css      = '';
$breadcrumb_font_css = '';
$page_title_bar      = '';

$page_title_bg_color = get_theme_mod( 'osf_colors_page_title_bg', '#fafafa' );
$page_title_bg_image = get_theme_mod( 'osf_colors_page_title_bg_image' );
$page_title_color    = get_theme_mod( 'osf_colors_page_title_heading_color', '#666' );
$breadcrumb_color    = get_theme_mod( 'osf_colors_page_title_breadcrumb_color', '#222' );


$breadcrumb_color = ariColor::new_color( $breadcrumb_color );

if ( ! empty( $page_title_bg_color ) && $page_title_bg_color != '#fafafa' ) {
	$page_title_bar .= "background-color: {$page_title_bg_color};";
}


if ( ! empty( $page_title_bg_image ) ) {
	$page_title_bar .= "background-image: url({$page_title_bg_image});";
}

$page_title_bg_repeat = get_theme_mod( 'osf_colors_page_title_bg_repeat', 1 );
if ( ! empty( $page_title_bg_image ) && $page_title_bg_repeat ) {
	$page_title_bar .= "background-repeat: no-repeat;";
}
$page_title_bg_position = get_theme_mod( 'osf_colors_page_title_bg_position', 'top left' );
if ( ! empty( $page_title_bg_position ) ) {
	$page_title_bar .= "background-position: {$page_title_bg_position};";
}

if ( ! empty( $page_title_bar ) ) {
	$cssCode .= <<<CSS
.page-title-bar {
    {$page_title_bar};
}
CSS;
}
$page_title_css_color = '';
if ( $page_title_color && $page_title_color != '#666' ) {
	$page_title_css_color .= "color: {$page_title_color};";
}

if ( ! empty( $page_title_css_color ) ) {
	$cssCode .= <<<CSS
    .page-title-bar .page-title{
        $page_title_css_color 
    }
CSS;
}

$breadcrumb_css .= "color: {$breadcrumb_color->toCSS()};";
if ( ! empty( $breadcrumb_css ) ) {
	$cssCode
		.= <<<CSS
    .breadcrumb, .breadcrumb span, .breadcrumb * {
        {$breadcrumb_css};
    }
CSS;
}
if ( ! empty( $breadcrumb_font_css ) ) {
	$cssCode
		.= <<<CSS
    .breadcrumb {
        {$breadcrumb_font_css};
    }
CSS;
}

$breadcrumb_color_hover = get_theme_mod( 'osf_colors_page_title_breadcrumb_color_hover', '#222' );
if ( $breadcrumb_color_hover && $breadcrumb_color_hover != '#222' ) {
	$cssCode .= <<<CSS
.breadcrumb a:hover,.breadcrumb a:hover span{
    color: {$breadcrumb_color_hover};
}
CSS;
}


/**
 * @return string Css Typograply page title
 */
return $cssCode;
