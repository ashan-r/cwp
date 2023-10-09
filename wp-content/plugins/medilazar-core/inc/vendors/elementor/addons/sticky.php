<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class OSF_Elementor_Section {
	public function __construct() {
		add_action( 'elementor/element/section/section_layout/after_section_end', [
			$this,
			'register_controls'
		], 10, 2 );
		add_action( 'elementor/element/section/section_advanced/before_section_end', [
			$this,
			'register_controls_advanced'
		], 10, 2 );
		add_action( 'elementor/element/section/section_background/before_section_end', [
			$this,
			'register_controls_background'
		], 10, 2 );
	}

	public function register_controls( $element, $args ) {

		$element->start_controls_section(
			'section_sticky',
			[
				'label' => __( 'Sticky ', 'medilazar-core' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);

		$element->add_control(
			'sticky_show',
			[
				'label'        => __( 'Enable Sticky', 'medilazar-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => 'Yes',
				'label_off'    => 'No',
				'return_value' => 'active',
				'prefix_class' => 'osf-sticky-',
			]
		);

		$element->end_controls_section();

	}

	public function register_controls_advanced( $element, $args ) {

		$element->add_responsive_control(
			'sticky_padding',
			[
				'label'              => __( 'Padding Sticky', 'medilazar-core' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px', '%' ],
				'allowed_dimensions' => 'vertical',
				'placeholder'        => [
					'top'    => '',
					'right'  => 'auto',
					'bottom' => '',
					'left'   => 'auto',
				],
				'selectors'          => [
					'{{WRAPPER}}.sticky-show' => 'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}}'
				],
				'condition'          => [
					'sticky_show' => 'active'
				],
				'description'        => __( 'padding when sticky active', 'medilazar-core' ),
			]
		);
	}

	public function register_controls_background( $element, $args ) {

		$element->add_control(
			'sticky_heading_background',
			[
				'label'     => __( 'Background Sticky Active', 'medilazar-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'sticky_show' => 'active'
				],
			]
		);
		$element->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'sticky_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}}.sticky-show',
				'condition' => [
					'sticky_show' => 'active'
				],
			]
		);
	}
}

new OSF_Elementor_Section();