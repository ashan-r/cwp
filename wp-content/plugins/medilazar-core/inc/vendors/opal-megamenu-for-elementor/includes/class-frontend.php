<?php

defined( 'ABSPATH' ) || exit();

class OSF_Megamenu_Frontend {

	/**
	 *
	 */
	function __construct() {
		add_action( 'elementor/frontend/after_register_styles', [ $this, 'register_style_frontend' ], 99 );

	}

	/**
	 * enqueue editor.js for edit mode
	 */
	public function register_style_frontend() {
		$load = apply_filters( 'osf_megamenu_load_frontend_style', true );
		if ( $load ) {
			wp_enqueue_script( 'opal-megamenu-frontend', trailingslashit( OM_PLUGIN_URI ) . 'assets/js/frontend.js', array( 'jquery' ), false, true );
		}
	}

}

new OSF_Megamenu_Frontend();

