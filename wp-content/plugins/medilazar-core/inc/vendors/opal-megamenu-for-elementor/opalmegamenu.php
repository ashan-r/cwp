<?php

defined( 'ABSPATH' ) || exit();


class OSF_Megamenu {

	private $version = '1.0.0';

	public static $instance;

	/**
	 * instance
	 */
	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * constructor
	 */
	public function __construct() {
		$this->set_constants();
		$this->includes();
		$this->init_hooks();

		do_action( 'opal_elementor_menu_loaded', $this );
	}

	/**
	 * set all constants
	 */
	private function set_constants() {
		$this->define( 'OM_PLUGIN_FILE', __FILE__ );
		$this->define( 'OM_VERSION', $this->version );
		$this->define( 'OM_PLUGIN_URI', plugin_dir_url( OM_PLUGIN_FILE ) );
		$this->define( 'OM_PLUGIN_DIR', plugin_dir_path( OM_PLUGIN_FILE ) );
		$this->define( 'OM_PLUGIN_ASSET_URI', trailingslashit( OM_PLUGIN_URI . 'assets' ) );
		$this->define( 'OM_PLUGIN_INC_DIR', trailingslashit( OM_PLUGIN_DIR . 'includes' ) );
		$this->define( 'OM_PLUGIN_TEMPLATE_DIR', trailingslashit( OM_PLUGIN_DIR . 'templates' ) );
	}

	/**
	 * set define
	 *
	 * @param string name
	 * @param string | boolean | anythings
	 *
	 * @since 1.0.0
	 */
	private function define( $name = '', $value = '' ) {
		defined( $name ) || define( $name, $value );
	}

	/**
	 * include all required files
	 */
	private function includes() {

		if ( is_admin() ) {
			$this->_include( 'includes/admin/class-admin.php' );
		}
		$this->_include( 'includes/core-functions.php' );
		$this->_include( 'includes/hook-functions.php' );
		$this->_include( 'includes/class-menu-walker.php' );
		$this->_include( 'includes/class-menu-item-post-type.php' );

		if ( ! is_admin() ) {
			$this->_include( 'includes/class-frontend.php' );
		}

		$this->_include( 'includes/class-frontend-assets.php' );
	}

	/**
	 * include single file
	 */
	private function _include( $file = '' ) {
		$file = OM_PLUGIN_DIR . $file;
		if ( file_exists( $file ) ) {
			include_once $file;
		}
	}

	/**
	 * init main plugin hooks
	 */
	private function init_hooks() {
		// trigger init hooks
		do_action( 'opal_elementor_menu_init', $this );
	}

}

function osf_megamenu() {
	return OSF_Megamenu::instance();
}

$GLOBALS['osf_megamenu'] = osf_megamenu();
