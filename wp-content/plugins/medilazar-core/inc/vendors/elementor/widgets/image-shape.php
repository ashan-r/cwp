<?php

namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor image box widget.
 *
 * Elementor widget that displays an image, a headline and a text.
 *
 * @since 1.0.0
 */
class OSF_Widget_Image_Shape extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve image box widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'image-shape';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve image box widget title.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Image Shape', 'medilazar-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve image box widget icon.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-image-box';
	}

	public function get_categories() {
		return [ 'opal-addons' ];
	}

	/**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since  1.3.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'anime' ];
	}

	/**
	 * Register image box widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_image',
			[
				'label' => __( 'Image Box', 'medilazar-core' ),
			]
		);

		$this->add_control(
			'media_type',
			[
				'label'   => __( 'Media Type', 'medilazar-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'image' => __( 'Image', 'medilazar-core' ),
					'svg'   => __( 'SVG Code', 'medilazar-core' ),
				],
				'default' => 'image',
			]
		);

		$this->add_control(
			'svgcode',
			[
				'label'     => __( 'Code', 'medilazar-core' ),
				'type'      => Controls_Manager::TEXTAREA,
				'condition' => [
					'media_type' => 'svg'
				]
			]
		);

		$this->add_control(
			'image',
			[
				'label'     => __( 'Choose Image', 'medilazar-core' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [
					'active' => true,
				],
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'media_type' => 'image'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default'   => 'full',
				'separator' => 'none',
				'condition' => [
					'media_type' => 'image'
				]
			]
		);


		$this->add_control(
			'title_text',
			[
				'label'       => __( 'Title & Description', 'medilazar-core' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => __( 'This is the heading', 'medilazar-core' ),
				'placeholder' => __( 'Enter your title', 'medilazar-core' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'sub_title_text',
			[
				'label'       => __( 'Sub Title', 'medilazar-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your sub-title', 'medilazar-core' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'description_text',
			[
				'label'       => __( 'Description', 'medilazar-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'medilazar-core' ),
				'placeholder' => __( 'Enter your description', 'medilazar-core' ),
				'separator'   => 'none',
				'rows'        => 10,
			]
		);
		$this->add_control(
			'hover_animation_wrapper',
			[
				'label'        => __( 'Hover Wrapper Animation', 'medilazar-core' ),
				'type'         => Controls_Manager::HOVER_ANIMATION,
				'prefix_class' => 'elementor-animation-',
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => __( 'Link to', 'medilazar-core' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'medilazar-core' ),
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'link_download',
			[
				'label' => __( 'Download Link ?', 'medilazar-core' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'position',
			[
				'label'        => __( 'Image Position', 'medilazar-core' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'top',
				'options'      => [
					'left'  => [
						'title' => __( 'Left', 'medilazar-core' ),
						'icon'  => 'eicon-h-align-left',
					],
					'top'   => [
						'title' => __( 'Top', 'medilazar-core' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'medilazar-core' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'elementor-position-',
				'toggle'       => false,
			]
		);

		$this->add_control(
			'title_size',
			[
				'label'   => __( 'Title HTML Tag', 'medilazar-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'default' => 'h3',
			]
		);

		$this->add_control(
			'view',
			[
				'label'   => __( 'View', 'medilazar-core' ),
				'type'    => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->add_control(
			'show_button',
			[
				'label'     => __( 'Button', 'medilazar-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'Show', 'medilazar-core' ),
				'label_off' => __( 'Hide', 'medilazar-core' ),
			]
		);

		$this->end_controls_section();

//        control button

		$this->start_controls_section(
			'section_button',
			[
				'label'     => __( 'Button', 'medilazar-core' ),
				'condition' => [
					'show_button' => 'yes',
				]
			]
		);

		$this->add_control(
			'icon',
			[
				'label'   => __( 'Choose Icon', 'medilazar-core' ),
				'type'    => Controls_Manager::ICON,
				'default' => 'opal-icon-arrow-right',
			]
		);

		$this->add_control(
			'button_type',
			[
				'label'        => __( 'Type', 'medilazar-core' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'default',
				'options'      => [
					'default'           => __( 'Default', 'medilazar-core' ),
					'primary'           => __( 'Primary', 'medilazar-core' ),
					'secondary'         => __( 'Secondary', 'medilazar-core' ),
					'outline_primary'   => __( 'Outline Primary', 'medilazar-core' ),
					'outline_secondary' => __( 'Outline Secondary', 'medilazar-core' ),
					'link'              => __( 'Link', 'medilazar-core' ),
					'info'              => __( 'Info', 'medilazar-core' ),
					'success'           => __( 'Success', 'medilazar-core' ),
					'warning'           => __( 'Warning', 'medilazar-core' ),
					'danger'            => __( 'Danger', 'medilazar-core' ),
				],
				'prefix_class' => 'elementor-button-',
			]
		);

		$this->add_control(
			'button_size',
			[
				'label'   => __( 'Size', 'medilazar-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'md',
				'options' => [
					'xs' => __( 'Extra Small', 'medilazar-core' ),
					'sm' => __( 'Small', 'medilazar-core' ),
					'md' => __( 'Medium', 'medilazar-core' ),
					'lg' => __( 'Large', 'medilazar-core' ),
					'xl' => __( 'Extra Large', 'medilazar-core' ),
				],
			]
		);

		$this->add_control(
			'button_link',
			[
				'label'       => __( 'Link', 'medilazar-core' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'medilazar-core' ),
				'default'     => [
					'url' => '#',
				],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section_animation_bg',
			[
				'label' => __( 'Animation Background', 'medilazar-core' ),
			]
		);

		$this->add_control(
			'hover_animation_bg',
			[
				'label' => __( 'Enable Animation', 'medilazar-core' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'hover_animation_style',
			[
				'label'     => __( 'Style', 'medilazar-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'0' => __( 'Style 1', 'medilazar-core' ),
					'1' => __( 'Style 2', 'medilazar-core' ),
					'2' => __( 'Style 3', 'medilazar-core' ),
				],
				'default'   => '1',
				'condition' => [
					'hover_animation_bg' => 'yes'
				]
			]
		);

		$this->add_control(
			'bg_animation_color',
			[
				'label'     => __( 'Color', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .item__svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'hover_animation_bg' => 'yes'
				]
			]
		);

		$this->add_control(
			'bg_animation_width',
			[
				'label'      => __( 'Width', 'medilazar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'size' => 50,
					'unit' => 'px'
				],
				'selectors'  => [
					'{{WRAPPER}} svg.item__svg ' => 'width: {{SIZE}}{{UNIT}}'
				],
				'condition'  => [
					'hover_animation_bg' => 'yes'
				]
			]
		);

		$this->add_control(
			'bg_animation_height',
			[
				'label'      => __( 'Height', 'medilazar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'size' => 50,
					'unit' => 'px'
				],
				'selectors'  => [
					'{{WRAPPER}} svg.item__svg ' => 'height: {{SIZE}}{{UNIT}}'
				],
				'condition'  => [
					'hover_animation_bg' => 'yes'
				]
			]
		);

		$this->add_control(
			'bg_animation_rotate',
			[
				'label'     => __( 'Rotate', 'medilazar-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 0,
					'unit' => 'deg'
				],
				'selectors' => [
					'{{WRAPPER}} svg.item__svg ' => 'rotate({{SIZE}}{{UNIT}})'
				],
				'condition' => [
					'hover_animation_bg' => 'yes'
				]
			]
		);

		$this->add_control( 'bg_animation_duration',
			[
				'label'     => esc_html__( 'Duration', 'medilazar-core' ),
				'type'      => Controls_Manager::NUMBER,
				'title'     => esc_html__( 'Set the animation duration in milliseconds, default is 1200', 'medilazar-core' ),
				'default'   => 1200,
				'condition' => [
					'hover_animation_bg' => 'yes'
				]
			]
		);

		$this->add_control( 'bg_animation_elasticity',
			[
				'label'     => esc_html__( 'Elasticity', 'medilazar-core' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 400,
				'condition' => [
					'hover_animation_bg' => 'yes'
				]
			]
		);

		$this->end_controls_section();

//        end control button

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Image', 'medilazar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_space',
			[
				'label'     => __( 'Spacing', 'medilazar-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 15,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-position-right .elementor-image-box-img' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-position-left .elementor-image-box-img'  => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-position-top .elementor-image-box-img'   => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'(mobile){{WRAPPER}} .elementor-image-box-img'                  => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'border_image',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img img',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label'      => __( 'Border Radius', 'medilazar-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'images_padding',
			[
				'label'      => __( 'Padding', 'medilazar-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-image-box-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs( 'tabs_image_hover_style' );

		$this->start_controls_tab(
			'tab_image_hover_style_normal',
			[
				'label' => __( 'Normal', 'medilazar-core' ),
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label'     => __( 'Opacity', 'medilazar-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 1,
				],
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img img' => 'opacity: {{SIZE}};',
					'{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img svg' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_image_hover_style_hover',
			[
				'label' => __( 'Hover', 'medilazar-core' ),
			]
		);

		$this->add_control(
			'image_opacity_hover',
			[
				'label'     => __( 'Opacity', 'medilazar-core' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 1,
				],
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}}:hover .elementor-image-box-wrapper .elementor-image-box-img img' => 'opacity: {{SIZE}};',
					'{{WRAPPER}}:hover .elementor-image-box-wrapper .elementor-image-box-img svg' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'medilazar-core' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'animation_moveup',
			[
				'label'     => __( 'Hover Move Up', 'medilazar-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container:hover' => 'transform: translateY(-5px);',
				],
				'label_on'  => 'Show',
				'label_off' => 'Hide',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => __( 'Content', 'medilazar-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label'     => __( 'Alignment', 'medilazar-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => __( 'Left', 'medilazar-core' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'medilazar-core' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'medilazar-core' ),
						'icon'  => 'eicon-h-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'medilazar-core' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image-box-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_vertical_alignment',
			[
				'label'        => __( 'Vertical Alignment', 'medilazar-core' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'top'    => __( 'Top', 'medilazar-core' ),
					'middle' => __( 'Middle', 'medilazar-core' ),
					'bottom' => __( 'Bottom', 'medilazar-core' ),
				],
				'default'      => 'top',
				'prefix_class' => 'elementor-vertical-align-',
			]
		);

		$this->add_control(
			'heading_title',
			[
				'label'     => __( 'Title', 'medilazar-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-title',
			]
		);

		$this->add_responsive_control(
			'title_bottom_space',
			[
				'label'     => __( 'Spacing', 'medilazar-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs( 'tabs_view_title_style' );

		$this->start_controls_tab(
			'view_title_button_normal',
			[
				'label' => __( 'Normal', 'medilazar-core' ),
			]
		);
		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-image-box-content .elementor-image-box-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'view_title_button_hover',
			[
				'label' => __( 'Hover', 'medilazar-core' ),
			]
		);
		$this->add_control(
			'title_color_hover',
			[
				'label'     => __( 'Color Hover (Wrapper)', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}:hover .elementor-image-box-content .elementor-image-box-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_transition',
			[
				'label'     => __( 'Transition Duration', 'medilazar-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image-box-content .elementor-image-box-title' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->add_control(
			'heading_sub_title',
			[
				'label'     => __( 'Sub-title', 'medilazar-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sub_title_typography',
				'selector' => '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-sub-title',
			]
		);

		$this->add_responsive_control(
			'sub_title_bottom_space',
			[
				'label'     => __( 'Spacing', 'medilazar-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image-box-sub-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_view_subtitle_style' );

		$this->start_controls_tab(
			'view_subtitle_button_normal',
			[
				'label' => __( 'Normal', 'medilazar-core' ),
			]
		);

		$this->add_control(
			'sub_title_color',
			[
				'label'     => __( 'Color', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-image-box-content .elementor-image-box-sub-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'view_subtitle_button_hover',
			[
				'label' => __( 'Hover', 'medilazar-core' ),
			]
		);

		$this->add_control(
			'sub_title_color_hover',
			[
				'label'     => __( 'Color Hover (Wrapper)', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}:hover .elementor-image-box-content .elementor-image-box-sub-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sub_title_hover_transition',
			[
				'label'     => __( 'Transition Duration', 'medilazar-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image-box-content .elementor-image-box-sub-title' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'heading_description',
			[
				'label'     => __( 'Description', 'medilazar-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-description',
			]
		);

		$this->start_controls_tabs( 'tabs_view_description_style' );

		$this->start_controls_tab(
			'view_description_button_normal',
			[
				'label' => __( 'Normal', 'medilazar-core' ),
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => __( 'Color', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-image-box-content .elementor-image-box-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'view_description_button_hover',
			[
				'label' => __( 'Hover', 'medilazar-core' ),
			]
		);

		$this->add_control(
			'description_color_hover',
			[
				'label'     => __( 'Color Hover (Wrapper)', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}:hover .elementor-image-box-content .elementor-image-box-description' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'description_hover_transition',
			[
				'label'     => __( 'Transition Duration', 'medilazar-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image-box-content .elementor-image-box-description' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'button_style_tab',
			[
				'label'     => __( 'Button', 'medilazar-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_button' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'btn_icon_spacing',
			[
				'label'     => __( 'Spacing', 'medilazar-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'   => [
					'size' => 70,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-button' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'btn_icon_size',
			[
				'label'      => __( 'Icon Size', 'medilazar-core' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 35,
				],
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-image-box-wrapper .elementor-button i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'btn_style_hover' );

		$this->start_controls_tab(
			'btn_normal_style',
			[
				'label' => __( 'Normal', 'medilazar-core' ),
			]
		);

		$this->add_control(
			'btn_icon_color',
			[
				'label'     => __( 'Color', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-image-box-button i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_icon_background',
			[
				'label'     => __( 'Background', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-image-box-button .elementor-button' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'btn_hover_style',
			[
				'label' => __( 'Hover', 'medilazar-core' ),
			]
		);

		$this->add_control(
			'btn_icon_color_hover',
			[
				'label'     => __( 'Color', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .elementor-image-box-button .elementor-button:hover i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_icon_background_hover',
			[
				'label'     => __( 'Background', 'medilazar-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-image-box-button .elementor-button:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->add_control(
			'btn_padding',
			[
				'label'     => __( 'Padding', 'medilazar-core' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .elementor-image-box-button .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'border_btn',
				'selector' => '{{WRAPPER}} .elementor-image-box-wrapper .elementor-button',
			]
		);

		$this->end_controls_section();
	}

	private function morph() {
		return [
			[
				"start" => 'M 4.799,29.57 C 4.425,25.29 7.233,19.57 11.04,16.7 16.96,12.24 25.9,10.61 32.96,12.88 38.13,14.54 42.8,19.3 44.37,24.5 45.33,27.7 46.49,32.24 42.46,34.35 36.9,37.27 30.42,31.01 23.91,31.9 19.09,32.55 15.3,38 10.76,37.34 6.497,36.73 5.068,32.64 4.799,29.57 Z',
				'end'   => 'M 3.003,24.04 C 3.135,18.62 3.967,12.0 8.595,8.614 16.25,3.012 30.2,0.3296 37.87,5.908 41.31,8.414 38.36,14.0 39.51,17.88 41.16,23.44 47.78,28.07 46.95,33.77 46.26,38.41 42.09,42.9 37.38,44.77 28.61,48.25 16.18,48.24 8.779,42.7 3.304,38.6 2.846,30.5 3.003,24.04 Z'
			],
			[
				"start" => 'M 18.9,8.037 C 23.26,4.667 35.25,6.706 35.09,12.41 34.95,17.34 31.17,16.8 31.24,24.81 31.29,30.11 38.25,31.92 36.85,37.91 34.94,46.06 13.77,46.75 11.76,38.63 9.868,30.97 17.15,29.22 18.36,24.01 19.57,18.82 12.38,13.07 18.9,8.037 Z',
				'end'   => 'M 18.4,12.74 C 23.54,9.238999999999999 31.97,7.926999999999998 35.99,13.22 38.32,16.3 35.71,21.66 35.58,25.88 35.48,29.12 37.13,33.29 35.29,35.6 30.61,41.44 20.51,41.93 15.37,36.72 12.38,33.68 12.86,27.21 13.61,22.52 14.21,18.78 15.7,14.57 18.4,12.74 Z'
			],
			[
				"start" => 'M 45.15,18.58 C 44.15,26.62 33.96,30.5 27.23,35.02 20.77,39.36 22.67,44.47 18.26,44.79 13.28,45.14 8.397,39.99 6.637,35.31 3.46,26.84 4.116,14.18 11.2,8.544 18.61,2.632999999999999 31.38,5.41 39.6,10.14 42.52,11.82 45.56,15.24 45.15,18.58 Z',
				'end'   => 'M 36.81,4.642 C 46.1,9.669 47.37,26.62 42.23,35.84 37.91,43.6 25.96,48.48 17.5,45.75 10.75,43.57 1.265,32.98 6.093,27.77 9.518,24.08 15.4,37.93 19.42,34.89 25.07,30.6 11.6,20.41 14.84,14.09 18.48,7.002 29.8,0.8455 36.81,4.642 Z'
			]
		];
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();

		?>
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 380 500" style="enable-background:new 0 0 380 500;">
            <g>
                <defs>
                    <path id="mainHeroBlock1"
                          d="M349.86501,83.53172 C387.9,147.13418 302.01343,162.85668 351.5962,256.09928 C401.17897,349.34188 281.8856,505.25067 159.47545,487.24629 C37.0653,469.24191 -24.796190000000003,342.95693 55.91708,139.28682 C136.63035000000002,-64.38328 311.83002,19.92926 349.86501,83.53172 z"></path>
                </defs>
                <clipPath id="clippath-<?php echo esc_attr($this->get_id()); ?>">
                    <use xlink:href="#mainHeroBlock1" style="overflow:visible;"></use>
                </clipPath>
                <g style="clip-path:url(#<?php echo esc_attr($this->get_id()); ?>);">
                    <image id="SVGMainHeroImg1" style="overflow:visible;" width="380" height="500" xlink:href="http://localhost/wordpress/startor/wp-content/uploads/elementor/thumbs/blog-15-o5pyu41kfatbu0bydgipxvv2ed04vw4nutkd9ndhp8.jpeg"></image>M17.15545,226.87379C36.6618,115.62905 2.25628,78.73529 19.78327,48.94446C45.66164,-1.05096 272.48146,-12.21793 333.73909,40.34299C366.92809,71.4123 324.97978,155.95177 335.55734,197.5332C350.7338,257.11897 347.76155,277.88826 340.12731,338.97438C333.78078,388.70063 353.37013,451.28346 296.8221,462.51849C236.22023,457.77645 125.54616,471.14623 56.34729,456.94227C4.98897,415.00314 3.65513,297.04561 17.15545,226.87379z
                </g>
            </g>
</svg>
		<?php
	}

}

$widgets_manager->register( new OSF_Widget_Image_Shape() );