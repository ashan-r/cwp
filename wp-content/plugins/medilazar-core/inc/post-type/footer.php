<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class OSF_Custom_Post_Type_Footer
 */
class OSF_Custom_Post_Type_Footer extends OSF_Custom_Post_Type_Abstract {

	/**
	 * @return void
	 */
	public function create_post_type() {

		$labels = array(
			'name'               => __( 'Footer', "medilazar-core" ),
			'singular_name'      => __( 'Footer', "medilazar-core" ),
			'add_new'            => __( 'Add New Footer', "medilazar-core" ),
			'add_new_item'       => __( 'Add New Footer', "medilazar-core" ),
			'edit_item'          => __( 'Edit Footer', "medilazar-core" ),
			'new_item'           => __( 'New Footer', "medilazar-core" ),
			'view_item'          => __( 'View Footer', "medilazar-core" ),
			'search_items'       => __( 'Search Footers', "medilazar-core" ),
			'not_found'          => __( 'No Footers found', "medilazar-core" ),
			'not_found_in_trash' => __( 'No Footers found in Trash', "medilazar-core" ),
			'parent_item_colon'  => __( 'Parent Footer:', "medilazar-core" ),
			'menu_name'          => __( 'Footer Builder', "medilazar-core" ),
		);

		$args = array(
			'labels'              => $labels,
			'hierarchical'        => true,
			'description'         => __( 'List Footer', "medilazar-core" ),
			'supports'            => array( 'title', 'editor', 'thumbnail' ), //page-attributes, post-formats
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => $this->get_icon( __FILE__ ),
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => true,
			'exclude_from_search' => true,
			'has_archive'         => true,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => true,
			'capability_type'     => 'post'
		);
		register_post_type( 'footer', $args );
	}


}

new OSF_Custom_Post_Type_Footer;