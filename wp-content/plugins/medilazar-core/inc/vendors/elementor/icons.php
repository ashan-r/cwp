<?php
add_action( 'elementor/controls/controls_registered', 'osf_elementor_opal_icon_control_custom' );

/**
 * @var \Elementor\Controls_Manager $manager
 */
function osf_elementor_opal_icon_control_custom( $manager ) {
	$new_icons = json_decode( file_get_contents( trailingslashit( MEDILAZAR_CORE_PLUGIN_DIR ) . 'inc/vendors/elementor/icons.json' ), true );
	$icons     = $manager->get_control( 'icon' )->get_settings( 'options' );
	$new_icons = array_merge(
		$new_icons,
		$icons
	);
	// Then we set a new list of icons as the options of the icon control
	$manager->get_control( 'icon' )->set_settings( 'options', $new_icons );
}


// Version 2.6
add_action( 'elementor/icons_manager/native', 'osf_elementor_opal_icon_control_custom_26' );
function osf_elementor_opal_icon_control_custom_26( $tabs ) {
	$tabs['opal-custom'] = [
		'name'          => 'opal-custom',
		'label'         => __( 'Opal Custom Font', 'medilazar-core' ),
		'prefix'        => 'opal-icon-',
		'displayPrefix' => 'opal-icon-',
		'labelIcon'     => 'fab fa-font-awesome-alt',
		'ver'           => '5.9.0',
		'fetchJson'     => MEDILAZAR_CORE_PLUGIN_URL . 'inc/vendors/elementor/icons26.json',
		'native'        => true,
	];

	return $tabs;
}