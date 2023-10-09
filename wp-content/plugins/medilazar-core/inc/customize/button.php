<?php
$cssCode       = '';
$enable_custom = get_theme_mod( 'osf_colors_buttons_enable_custom', false );
if ( $enable_custom ) {
	$primary               = get_theme_mod( 'osf_colors_buttons_primary_bg', '#222' );
	$primary_border        = get_theme_mod( 'osf_colors_buttons_primary_border', '#222' );
	$primary_color         = get_theme_mod( 'osf_colors_buttons_primary_color', '#fff' );
	$primary_color_outline = get_theme_mod( 'osf_colors_buttons_primary_color_outline', '#222' );
	$primary_hover         = get_theme_mod( 'osf_colors_buttons_primary_hover_bg', '#222' );
	$primary_border_hover  = get_theme_mod( 'osf_colors_buttons_primary_hover_border', '#222' );
	$primary_color_hover   = get_theme_mod( 'osf_colors_buttons_primary_hover_color', '#fff' );

	$secondary               = get_theme_mod( 'osf_colors_buttons_secondary_bg', '#767676' );
	$secondary_border        = get_theme_mod( 'osf_colors_buttons_secondary_border', '#767676' );
	$secondary_color         = get_theme_mod( 'osf_colors_buttons_secondary_color', '#fff' );
	$secondary_color_outline = get_theme_mod( 'osf_colors_buttons_secondary_color_outline', '#767676' );
	$secondary_hover         = get_theme_mod( 'osf_colors_buttons_secondary_hover_bg', '#767676' );
	$secondary_border_hover  = get_theme_mod( 'osf_colors_buttons_secondary_hover_border', '#767676' );
	$secondary_color_hover   = get_theme_mod( 'osf_colors_buttons_secondary_hover_color', '#fff' );
} else {
	$ariPrimary    = ariColor::new_color( get_theme_mod( 'osf_colors_general_primary', '#0160b4' ) );
	$primary       = $primary_border = $primary_color_outline = $ariPrimary->toCSS();
	$primary_hover = $primary_border_hover = $ariPrimary->get_new( 'lightness', $ariPrimary->lightness - 10 )->toCSS();

	$ariSecondary    = ariColor::new_color( get_theme_mod( 'osf_colors_general_secondary', '#00c484' ) );
	$secondary       = $secondary_border = $secondary_color_outline = $ariSecondary->toCSS();
	$secondary_hover = $secondary_border_hover = $ariSecondary->get_new( 'lightness', $ariSecondary->lightness - 10 )->toCSS();

	$primary_color = $primary_color_hover = $secondary_color = $secondary_color_hover = '#fff';
}

$button_css  = '';
$button_font = sanitize_font_weight( get_theme_mod( 'osf_typography_button_font_family' ) );
if ( is_array( $button_font ) ) {
	if ( $button_font['family'] ) {
		$button_css .= "font-family:\"{$button_font['family']}\",-apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif;";
	}
	if ( isset( $button_font['fontWeight'] ) ) {
		$button_css .= "font-weight:{$button_font['fontWeight']};";
	}
}

$button_letter_spacing = get_theme_mod( 'osf_typography_buttom_letter_spacing', 0 );
if ( $button_letter_spacing && $button_letter_spacing != 0 ) {
	$button_css .= "letter-spacing: {$button_letter_spacing}px;";
}

$font_style      = get_theme_mod( 'osf_typography_button_font_style' );
$font_style_code = '';
if ( is_array( $font_style ) ) {
	if ( $font_style['italic'] ) {
		$font_style_code .= "font-style:italic;";
	}
	if ( $font_style['underline'] ) {
		$font_style_code .= "text-decoration:underline;";
	}
	if ( $font_style['fontWeight'] ) {
		$font_style_code .= "font-weight:bold;";
	}

	if ( $font_style['uppercase'] ) {
		$font_style_code .= "text-transform:uppercase;";
	}
}

//$font_size = get_theme_mod('osf_typography_button_font_size', 11);
//$button_css .= "font-size:{$font_size}px;";



$cssCode .= apply_filters( 'osf_customize_button_primary_color', $cssCode, $primary, $primary_hover, $primary_border, $primary_border_hover, $primary_color, $primary_color_hover, $primary_color_outline, $button_css, $font_style_code );
$cssCode .= apply_filters( 'osf_customize_button_secondary_color', $cssCode, $secondary, $secondary_hover, $secondary_border, $secondary_border_hover, $secondary_color, $secondary_color_hover, $secondary_color_outline, $button_css, $font_style_code );

$cssCode .= <<<CSS
    button ,input[type="submit"], input[type="reset"], input[type="button"], .button, .btn {
        {$button_css}
        {$font_style_code}
    }
    .elementor-button[class*='elementor-size-'] {
    }
CSS;

return $cssCode;
