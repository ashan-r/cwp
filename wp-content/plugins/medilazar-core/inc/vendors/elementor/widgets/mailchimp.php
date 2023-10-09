<?php

namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! osf_is_mailchimp_activated() ) {
	return;
}

//use Elementor\Group_Control_Border;
//use Elementor\Group_Control_Typography;
//use Elementor\Controls_Manager;


class OSF_Elementor_Mailchimp extends Widget_Base {

	public function get_name() {
		return 'opal-mailchmip';
	}

	public function get_title() {
		return __( 'MailChimp Sign-Up Form', 'medilazar-core' );
	}

	public function get_categories() {
		return array( 'opal-addons' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_script_depends() {
		return [ 'magnific-popup' ];
	}

	public function get_style_depends() {
		return [ 'magnific-popup' ];
	}


	protected function register_controls() {
		$this->start_controls_section(
			'mailchmip',
			[
				'label' => __( 'General', 'medilazar-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'hide_text',
			[
				'label'        => __( 'Hide Text', 'medilazar-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Off', 'medilazar-core' ),
				'label_on'     => __( 'On', 'medilazar-core' ),
				'default'      => '',
				'return_value' => 'none',
				'selectors'    => [
					'{{WRAPPER}} .mc4wp-form-fields span' => 'display: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'hide_icon',
			[
				'label'        => __( 'Hide Icon', 'medilazar-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Off', 'medilazar-core' ),
				'label_on'     => __( 'On', 'medilazar-core' ),
				'default'      => '',
				'return_value' => 'none',
				'selectors'    => [
					'{{WRAPPER}} .mc4wp-form-fields i' => 'display: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'spacing_icon',
			[
				'label'     => __( 'Icon Spacing', 'medilazar-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form-fields i' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'setting_mailchmip',
			[
				'label' => __( 'Setting', 'medilazar-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_responsive_control(
			'setting_block',
			[
				'label'     => __( 'Layout', 'medilazar-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'row',
				'options'   => [
					'row'    => __( 'Horizontal', 'medilazar-core' ),
					'column' => __( 'Vertical', 'medilazar-core' ),
				],

                'prefix_class' => 'elementor-mailchmip-',
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form-fields' => '    flex-direction: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'width_form',
			[
				'label'      => __( 'Form Width', 'medilazar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 100,
					'unit' => '%'
				],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mc4wp-form-fields' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'align_form',
			[
				'label'     => __( 'Alignment', 'medilazar-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => __( 'Left', 'medilazar-core' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'     => [
						'title' => __( 'Center', 'medilazar-core' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'   => [
						'title' => __( 'Right', 'medilazar-core' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		//wrapper style
		$this->start_controls_section(
			'mailchip_style_wrapper',
			[
				'label' => __( 'Wrapper', 'medilazar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'mailchimp_wrapper_bkg',
			[
				'label'     => __( 'Background color', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form-fields' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_wrapper_style' );

		$this->start_controls_tab(
			'tab_wrapper_normal',
			[
				'label' => __( 'Normal', 'medilazar-core' ),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'border_wrapper',
				'selector' => '{{WRAPPER}} .mc4wp-form-fields:not(:focus-within)',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_wrapper_focus',
			[
				'label' => __( 'Focus', 'medilazar-core' ),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'border_wrapper_focus',
				'selector' => '{{WRAPPER}} .mc4wp-form-fields:focus-within',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		//INPUT
		$this->start_controls_section(
			'mailchip_style_input',
			[
				'label' => __( 'Input', 'medilazar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography_email',
				'selector' => '{{WRAPPER}} .mc4wp-form-fields input[type="email"]',
			]
		);

		$this->start_controls_tabs( 'tabs_input_style' );

		$this->start_controls_tab(
			'tab_input_normal',
			[
				'label' => __( 'Normal', 'medilazar-core' ),
			]
		);


		$this->add_control(
			'input_background',
			[
				'label'     => __( 'Background Color', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form-fields input[type="email"]' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_color',
			[
				'label'     => __( 'Color', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form-fields input[type="email"]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'placeholder_color',
			[
				'label'     => __( 'Placeholder Color', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form-fields ::-webkit-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mc4wp-form-fields ::-moz-placeholder'          => 'color: {{VALUE}};',
					'{{WRAPPER}} .mc4wp-form-fields ::-ms-input-placeholder'     => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_input_focus',
			[
				'label' => __( 'Focus', 'medilazar-core' ),
			]
		);

		$this->add_control(
			'input_background_focus',
			[
				'label'     => __( 'Background Color', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form-fields input[type="email"]:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_border_color_focus',
			[
				'label'     => __( 'Border Color', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form-fields input[type="email"]:focus' => 'border-color: {{VALUE}}  !important;',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'align_input',
			[
				'label'     => __( 'Alignment', 'medilazar-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'medilazar-core' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'medilazar-core' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'medilazar-core' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form-fields input[type="email"]' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(

			Group_Control_Border::get_type(),
			[
				'name'        => 'border_input',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .mc4wp-form-fields input[type="email"]',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'input_border_radius',
			[
				'label'      => __( 'Border Radius', 'medilazar-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mc4wp-form-fields input[type="email"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'input_padding',
			[
				'label'      => __( 'Padding', 'medilazar-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mc4wp-form-fields input[type="email"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'spacing_input',
			[
				'label'     => __( 'Margin', 'medilazar-core' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form-fields input[type="email"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		//Button
		$this->start_controls_section(
			'mailchip_style_button',
			[
				'label' => __( 'Button', 'medilazar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .mc4wp-form-fields button,{{WRAPPER}} .mc4wp-form-fields input[type="submit"]',
			]
		);

		$this->add_responsive_control(
			'width_button',
			[
				'label'      => __( 'Width', 'medilazar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mc4wp-form-fields button, {{WRAPPER}} .mc4wp-form-fields input[type="submit"]' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_type',
			[
				'label'        => __( 'Type', 'medilazar-core' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'default',
				'options'      => [
					'default'           => __( 'Deafault', 'medilazar-core' ),
					'primary'           => __( 'Primary', 'medilazar-core' ),
					'secondary'         => __( 'Secondary', 'medilazar-core' ),
					'outline_primary'   => __( 'Outline Primary', 'medilazar-core' ),
					'outline_secondary' => __( 'Outline Secondary', 'medilazar-core' ),
					'outline_dark'      => __( 'Outline Dark', 'medilazar-core' ),
					'dark'              => __( 'Dark', 'medilazar-core' ),
					'light'             => __( 'Light', 'medilazar-core' ),
					'link'              => __( 'Link', 'medilazar-core' ),
				],
				'prefix_class' => 'mailchimp-button-',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'medilazar-core' ),
			]
		);

		$this->add_control(
			'button_bacground',
			[
				'label'     => __( 'Background Color', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form-fields button[type="submit"], {{WRAPPER}} .mc4wp-form-fields input[type="submit"]' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_color',
			[
				'label'     => __( 'Color', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form-fields button[type="submit"]:not(:hover), {{WRAPPER}} .mc4wp-form-fields input[type="submit"]:not(:hover)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'medilazar-core' ),
			]
		);

		$this->add_control(
			'button_bacground_hover',
			[
				'label'     => __( 'Background Color', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form-fields button[type="submit"]:hover, {{WRAPPER}} .mc4wp-form-fields input[type="submit"]:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_color_hover',
			[
				'label'     => __( 'Color', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form-fields button[type="submit"]:hover, {{WRAPPER}} .mc4wp-form-fields input[type="submit"]:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_hover',
			[
				'label'     => __( 'Border Color', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form-fields button[type="submit"]:hover, {{WRAPPER}} .mc4wp-form-fields input[type="submit"]:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon-rotate',
			[
				'label'     => __( 'Icon Rotate', 'medilazar-core' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form-fields button[type="submit"]:hover i' => 'transform: rotate({{SIZE}}deg);',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'border_button',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .mc4wp-form-fields button[type="submit"], {{WRAPPER}} .mc4wp-form-fields input[type="submit"]',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => __( 'Border Radius', 'medilazar-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mc4wp-form-fields button[type="submit"], {{WRAPPER}} .mc4wp-form-fields input[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => __( 'Padding', 'medilazar-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mc4wp-form-fields button[type="submit"], {{WRAPPER}} .mc4wp-form-fields input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_margin',
			[
				'label'      => __( 'Margin', 'medilazar-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .mc4wp-form-fields button[type="submit"], {{WRAPPER}} .mc4wp-form-fields input[type="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_align_vertical',
			[
				'label'     => __( 'Alignment', 'medilazar-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => __( 'Left', 'medilazar-core' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'     => [
						'title' => __( 'Center', 'medilazar-core' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'   => [
						'title' => __( 'Right', 'medilazar-core' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => 'stretch',
				'selectors' => [
					'{{WRAPPER}} .mc4wp-form-fields' => 'align-items: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		echo '<div class="form-style">';
		mc4wp_show_form();
		echo '</div>';
	}
}

$widgets_manager->register( new OSF_Elementor_Mailchimp() );