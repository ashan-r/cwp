<?php

defined( 'ABSPATH' ) || exit();

/**
 * OSF_Megamenu_Walker
 *
 * extends Walker_Nav_Menu
 */
class OSF_Admin_Megamenu_Assets {

	public static function init() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		add_action( 'elementor/editor/after_enqueue_scripts', array( __CLASS__, 'add_scripts_editor' ) );
	}

	public static function add_scripts_editor() {
		if ( isset( $_REQUEST['opal-menu-editable'] ) && $_REQUEST['opal-menu-editable'] ) {
			wp_register_script( 'opal-elementor-menu', OM_PLUGIN_ASSET_URI . 'js/editor.js' );
			wp_enqueue_script( 'opal-elementor-menu' );
		}
	}

	/**
	 * enqueue scripts
	 */
	public static function enqueue_scripts( $page ) {
		if ( $page === 'nav-menus.php' ) {
			wp_enqueue_script( 'backbone' );
			wp_enqueue_script( 'underscore' );
			//wp_enqueue_script( 'elementor-select2', plugins_url( 'assets/lib/e-select2/js/e-select2.full.js', ELEMENTOR__FILE__ ) );
			// wp_enqueue_style( 'elementor-select2', plugins_url( 'assets/lib/e-select2/css/e-select2.min.css', ELEMENTOR__FILE__ ) );

			if ( defined( "ELEMENTOR_ASSETS_URL" ) ) {
				$suffix = '.min';
				wp_register_script(
					'jquery-elementor-select2',
					ELEMENTOR_ASSETS_URL . 'lib/e-select2/js/e-select2.full' . $suffix . '.js',
					[
						'jquery',
					],
					'4.0.6-rc.1',
					true
				);
				wp_enqueue_script( 'jquery-elementor-select2' );
				wp_register_style(
					'elementor-select2',
					ELEMENTOR_ASSETS_URL . 'lib/e-select2/css/e-select2' . $suffix . '.css',
					[],
					'4.0.6-rc.1'
				);
				wp_enqueue_style( 'elementor-select2' );
			}
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_register_script( 'otf-megamenu', OM_PLUGIN_URI . 'assets/js/admin.js', array(
				'jquery',
				'backbone',
				'underscore'
			), '1.0.0', true );
			wp_localize_script( 'otf-megamenu', 'osf_memgamnu_params', apply_filters( 'osf_admin_megamenu_localize_scripts', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'i18n'    => array(
					'close'  => __( 'Close', 'medilazar-core' ),
					'submit' => __( 'Save', 'medilazar-core' )
				),
				'nonces'  => array(
					'load_menu_data' => wp_create_nonce( 'osf-menu-data-nonce' )
				)
			) ) );
			wp_enqueue_script( 'otf-megamenu' );

			wp_enqueue_style( 'otf-megamenu', OM_PLUGIN_URI . 'assets/css/admin.css' );
		}

	}

}

OSF_Admin_Megamenu_Assets::init();
