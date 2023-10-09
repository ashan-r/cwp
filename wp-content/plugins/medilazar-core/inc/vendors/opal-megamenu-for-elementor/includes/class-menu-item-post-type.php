<?php

defined( 'ABSPATH' ) || exit();

/**
 * OSF_Megamenu_Walker
 *
 * extends Walker_Nav_Menu
 */
class OSF_Menu_Item_Post_Type {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'template_include', array( $this, 'template_include' ), 99 );
	}

	/**
	 * register post types
	 */
	public function register_post_types() {
		$labels = array(
			'name'               => _x( 'Menu Item', 'post type general name', 'medilazar-core' ),
			'singular_name'      => _x( 'Menu', 'post type singular name', 'medilazar-core' ),
			'menu_name'          => _x( 'Menu Items', 'admin menu', 'medilazar-core' ),
			'name_admin_bar'     => _x( 'Menu', 'add new on admin bar', 'medilazar-core' ),
			'add_new'            => _x( 'Add New', 'book', 'medilazar-core' ),
			'add_new_item'       => __( 'Add New Menu', 'medilazar-core' ),
			'new_item'           => __( 'New Menu', 'medilazar-core' ),
			'edit_item'          => __( 'Edit Menu', 'medilazar-core' ),
			'view_item'          => __( 'View Menu', 'medilazar-core' ),
			'all_items'          => __( 'All Menu', 'medilazar-core' ),
			'search_items'       => __( 'Search Items', 'medilazar-core' ),
			'parent_item_colon'  => __( 'Parent Items:', 'medilazar-core' ),
			'not_found'          => __( 'No menus found.', 'medilazar-core' ),
			'not_found_in_trash' => __( 'No menus found in Trash.', 'medilazar-core' )
		);

		$args = array(
			'labels'              => $labels,
			'hierarchical'        => false,
			'description'         => 'description',
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_admin_bar'   => true,
			'menu_position'       => null,
			'menu_icon'           => null,
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => true,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'query_var'           => true,
			'can_export'          => true,
			'capability_type'     => 'post',
			'supports'            => array( 'title', 'editor' ),
			'rewrite'             => array( 'slug' => 'opal-menus' )
		);

		register_post_type( 'opal_menu_item', apply_filters( 'opal_elementor_menu_item_post_type', $args ) );

		add_post_type_support( 'opal_menu_item', 'elementor' );
	}

	/**
	 * template include function callback
	 */
	public function template_include( $template ) {
		if ( get_query_var( 'post_type' ) !== 'opal_menu_item' ) {
			return $template;
		}

		$template = locate_template( $this->get_templates() );


		if ( ! $template ) {
			$template = OM_PLUGIN_TEMPLATE_DIR . 'single-menu.php';
		}

		return $template;
	}

	/**
	 * templates
	 */
	public function get_templates() {
		$templates   = array();
		$object      = get_queried_object();
		$templates[] = 'single-menu-' . $object->post_name . '.php';
		$templates[] = 'single-menu.php';

		return $templates;
	}

}

new OSF_Menu_Item_Post_Type();