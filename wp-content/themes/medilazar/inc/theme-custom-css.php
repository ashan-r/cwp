<?php
/**
 * @return string
 */
function medilazar_custom_css() {

	$css = <<<CSS
CSS;
	/**
	 * Filters Medilazar custom colors CSS.
	 *
	 * @param string $css Base theme colors CSS.
	 *
	 * @since Medilazar 1.0
	 *
	 */
	$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
	$css = str_replace( ': ', ':', $css );
	$css = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $css );

	return apply_filters( 'medilazar_theme_customizer_css', $css );
}