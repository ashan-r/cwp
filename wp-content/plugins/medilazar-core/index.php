<?php

/**
 * @package  medilazar-core
 * @category Plugins
 * @author   Themelexus
 * Plugin Name: Medilazar Core
 * Plugin URI: http://www.themelexus.com/
 * Version: 1.2.5
 * Description: Implement rich functions for themes base on WpOpal. Wordpress framework and load widgets for theme
 * used, this is required. Version: 1.2.5 Author: themelexus Author URI:  http://www.themelexus.com/ License: GNU/GPLv3
 * http://www.gnu.org/licenses/gpl-3.0.html
 */

final class MedilazarCore {
	/**
	 * @var MedilazarCore
	 */
	private static $instance;

	/**
	 * MedilazarCore constructor.
	 */
	public function __construct() {
		$this->setup_constants();
		$this->plugin_update();
		$this->init_hooks();
	}

	/**
	 * @return void
	 */
	public function setup_constants() {
		if ( ! defined( 'MEDILAZAR_CORE_VERSION' ) ) {
			define( 'MEDILAZAR_CORE_VERSION', '1.2.5' );
		}

		if ( ! defined( 'MEDILAZAR_CORE_PLUGIN_DIR' ) ) {
			define( 'MEDILAZAR_CORE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		if ( ! defined( 'MEDILAZAR_CORE_PLUGIN_URL' ) ) {
			define( 'MEDILAZAR_CORE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		if ( ! defined( 'MEDILAZAR_CORE_PLUGIN_FILE' ) ) {
			define( 'MEDILAZAR_CORE_PLUGIN_FILE', __FILE__ );
		}
	}

	/**
	 * @return void
	 */
	private function load_textdomain() {
		$lang_dir      = dirname( plugin_basename( MEDILAZAR_CORE_PLUGIN_FILE ) ) . '/languages/';
		$lang_dir      = apply_filters( 'osf_languages_directory', $lang_dir );
		$locale        = apply_filters( 'plugin_locale', get_locale(), 'medilazar-core' );
		$mofile        = sprintf( '%1$s-%2$s.mo', 'medilazar-core', $locale );
		$mofile_local  = $lang_dir . $mofile;
		$mofile_global = WP_LANG_DIR . '/medilazar-core/' . $mofile;

		if ( file_exists( $mofile_global ) ) {
			load_textdomain( 'medilazar-core', $mofile_global );
		} else {
			if ( file_exists( $mofile_local ) ) {
				load_textdomain( 'medilazar-core', $mofile_local );
			} else {
				load_plugin_textdomain( 'medilazar-core', false, $lang_dir );
			}
		}
	}

	public function plugin_update() {
		if ( ! is_admin() ) {
			return false;
		}
		require 'plugin-updates/plugin-update-checker.php';
		Puc_v4_Factory::buildUpdateChecker(
			'http://source.wpopal.com/medilazar/dummy_data/update-plugin.json',
			__FILE__,
			'medilazar-core'
		);
	}

	/**
	 * @return void
	 */
	public function includes() {
		$this->load_textdomain();
		// Require plugin.php to use is_plugin_active() below
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		include_once 'inc/vendors/ariColor.php';
		require_once 'inc/core-functions.php';
		require_once 'inc/style-functions.php';
		require_once 'inc/class-abstract-post-type.php';
//        require_once 'inc/class-admin-menu.php';
		require_once 'inc/class-customize.php';
		require_once 'inc/class-meta-box.php';
		require_once 'inc/class-scripts.php';
		require_once 'inc/class-theme.php';
		require_once 'inc/class-user.php';
		require_once 'inc/class-widgets.php';
		require_once 'inc/class-template-loader.php';
		require_once 'inc/typography.php';
		require_once 'inc/shortcodes.php';

		if ( osf_is_elementor_activated() ) {
			require_once 'inc/vendors/elementor/class-elementor.php';
			require_once 'inc/vendors/elementor/class-elementor-pro.php';
			require_once 'inc/vendors/elementor/icons.php';
			require_once 'inc/vendors/opal-megamenu-for-elementor/opalmegamenu.php';
			//require_once 'inc/megamenu/megamenu.php';
		}

		// CMB2
		if ( ! class_exists( 'CMB2' ) ) {
			require_once 'inc/vendors/cmb2/libraries/init.php';
		}


		// AJAX Load More
		require_once 'inc/vendors/ajax-load-more/class-ajax-load-more.php';

//        require_once 'inc/vendors/cmb2/custom-fields/map/map.php';
//        require_once 'inc/vendors/cmb2/custom-fields/upload/upload.php';
//        require_once 'inc/vendors/cmb2/custom-fields/user/user.php';
//        require_once 'inc/vendors/cmb2/custom-fields/user_upload/user_upload.php';
		require_once 'inc/vendors/cmb2/custom-fields/switch/switch.php';
		require_once 'inc/vendors/cmb2/custom-fields/tabs/cmb2-tabs.php';
		require_once 'inc/vendors/cmb2/custom-fields/button_set.php';
//        require_once 'inc/vendors/cmb2/custom-fields/text_password.php';
//        require_once 'inc/vendors/cmb2/custom-fields/agent_info.php';
//		require_once 'inc/vendors/cmb2/custom-fields/text_price.php';
		require_once 'inc/vendors/cmb2/custom-fields/switch-layout.php';
		require_once 'inc/vendors/cmb2/custom-fields/slider/slider.php';
		require_once 'inc/vendors/cmb2/custom-fields/footer-layout.php';
		require_once 'inc/vendors/cmb2/custom-fields/header-layout.php';


		if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			require 'inc/vendors/woocommerce/class-woocommerce.php';
			require 'inc/vendors/woocommerce/woocommerce-mobile-handhed-footer-bar.php';
			require 'inc/vendors/woocommerce/class-woocommerce-extra.php';
			require 'inc/vendors/woocommerce/woocommerce-template-functions.php';
			require 'inc/vendors/woocommerce/woocommerce-template-hooks.php';

			require 'inc/vendors/woocommerce/class-yith.php';

			require 'inc/vendors/woocommerce/class-woocommerce-search.php';
		}

		require_once 'inc/class-import.php';
		if ( ! osf_is_one_click_import_activated() ) {
			require_once 'inc/vendors/one-click-demo-import/one-click-demo-import.php';
		}


	}

	/**
	 * @return void
	 */
	private function init_hooks() {
		add_action( 'plugins_loaded', array( $this, 'includes' ), 99 );
		add_action( 'init', array( $this, 'init_theme_support' ), 1 );
		add_action( 'customize_register', array( $this, 'init_customize_control' ), 1 );
	}

	/**
	 * @return MedilazarCore
	 */
	public static function getInstance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof MedilazarCore ) ) {
			self::$instance = new MedilazarCore();
		}

		return self::$instance;
	}

	/**
	 * @return void
	 */
	public function init_customize_control() {
		if ( get_theme_support( 'opal-customize-css' ) ) {
			/** inject:customize_control */
			require_once 'inc/customize-control/background-position.php';
			require_once 'inc/customize-control/button-group.php';
			require_once 'inc/customize-control/button-move.php';
			require_once 'inc/customize-control/button-switch.php';
			require_once 'inc/customize-control/color.php';
			require_once 'inc/customize-control/editor.php';
			require_once 'inc/customize-control/font-style.php';
			require_once 'inc/customize-control/footer.php';
			require_once 'inc/customize-control/google-font.php';
			require_once 'inc/customize-control/header.php';
			require_once 'inc/customize-control/heading.php';
			require_once 'inc/customize-control/image-select.php';
			require_once 'inc/customize-control/import-export.php';
			require_once 'inc/customize-control/sidebar.php';
			require_once 'inc/customize-control/slider.php';
			/** end:customize_control */
		}
	}

	/**
	 * @return void
	 */
	public function init_theme_support() {
		if ( osf_is_elementor_activated() ) {
			if ( get_theme_support( 'opal-header-builder' ) ) {
				require_once 'inc/post-type/header.php';
				require_once 'inc/class-header-builder.php';
			}
			if ( get_theme_support( 'opal-footer-builder' ) ) {
				require_once 'inc/post-type/footer.php';
				require_once 'inc/class-footer-builder.php';
			}
		}

		new OSF_Metabox();
	}
}

return MedilazarCore::getInstance();