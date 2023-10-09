<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class OSF_Elementor_Flip_Box extends Elementor\Widget_Base {

	public function get_name() {
		return 'opal-flip-box';
	}

	public function get_title() {
		return __( 'Opal Flip Box', 'medilazar-core' );
	}

	public function get_icon() {
		return 'eicon-flip-box';
	}

    public function get_categories() {
        return [ 'opal-addons' ];
    }

	protected function register_controls() {

		$this->start_controls_section(
			'section_side_a_content',
			[
				'label' => __( 'Front', 'medilazar-core' ),
			]
		);

		$this->start_controls_tabs( 'side_a_content_tabs' );

		$this->start_controls_tab( 'side_a_content_tab', [ 'label' => __( 'Content', 'medilazar-core' ) ] );

		$this->add_control(
			'graphic_element',
			[
				'label' => __( 'Graphic Element', 'medilazar-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'none' => [
						'title' => __( 'None', 'medilazar-core' ),
						'icon' => 'eicon-ban',
					],
					'image' => [
						'title' => __( 'Image', 'medilazar-core' ),
						'icon' => 'eicon-image',
					],
					'icon' => [
						'title' => __( 'Icon', 'medilazar-core' ),
						'icon' => 'eicon-star',
					],
				],
				'default' => 'none',
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'medilazar-core' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image', // Actually its `image_size`
				'default' => 'thumbnail',
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'medilazar-core' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-star',
				'condition' => [
					'graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_view',
			[
				'label' => __( 'View', 'medilazar-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => __( 'Default', 'medilazar-core' ),
					'stacked' => __( 'Stacked', 'medilazar-core' ),
					'framed' => __( 'Framed', 'medilazar-core' ),
				],
				'default' => 'default',
				'condition' => [
					'graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_shape',
			[
				'label' => __( 'Shape', 'medilazar-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'circle' => __( 'Circle', 'medilazar-core' ),
					'square' => __( 'Square', 'medilazar-core' ),
				],
				'default' => 'circle',
				'condition' => [
					'icon_view!' => 'default',
					'graphic_element' => 'icon',
				],
			]
		);

        $this->add_control(
            'sub_title_text_a',
            [
                'label' => __( 'Sub Title', 'medilazar-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'This is the sub title', 'medilazar-core' ),
                'placeholder' => __( 'Enter your sub title', 'medilazar-core' ),
                'label_block' => true,
                'separator' => 'before',
            ]
        );

		$this->add_control(
			'title_text_a',
			[
				'label' => __( 'Title', 'medilazar-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'This is the heading', 'medilazar-core' ),
				'placeholder' => __( 'Enter your title', 'medilazar-core' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'description_text_a',
			[
				'label' => __( 'Description', 'medilazar-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Enter your description', 'medilazar-core' ),
				'separator' => 'none',
				'rows' => 10,
                'label_block' => true,
//				'show_label' => false,
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'side_a_background_tab', [ 'label' => __( 'Background', 'medilazar-core' ) ] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_a',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .elementor-flip-box__front',
			]
		);

		$this->add_control(
			'background_overlay_a',
			[
				'label' => __( 'Background Overlay', 'medilazar-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__overlay' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
					'background_a_image[id]!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_side_b_content',
			[
				'label' => __( 'Back', 'medilazar-core' ),
			]
		);

		$this->start_controls_tabs( 'side_b_content_tabs' );

		$this->start_controls_tab( 'side_b_content_tab', [ 'label' => __( 'Content', 'medilazar-core' ) ] );

        $this->add_control(
            'sub_title_text_b',
            [
                'label' => __( 'Sub Title', 'medilazar-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'This is the sub title', 'medilazar-core' ),
                'placeholder' => __( 'Enter your sub title', 'medilazar-core' ),
                'label_block' => true,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_text_b',
            [
                'label' => __( 'Title', 'medilazar-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'This is the heading', 'medilazar-core' ),
                'placeholder' => __( 'Enter your title', 'medilazar-core' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description_text_b',
            [
                'label' => __( 'Description', 'medilazar-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => __( 'Enter your description', 'medilazar-core' ),
                'separator' => 'none',
                'rows' => 10,
                'label_block' => true,
            ]
        );

		$this->add_control(
			'button_text',
			[
				'label' => __( 'Button Text', 'medilazar-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Click Here', 'medilazar-core' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'medilazar-core' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'medilazar-core' ),
			]
		);

		$this->add_control(
			'link_click',
			[
				'label' => __( 'Apply Link On', 'medilazar-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'box' => __( 'Whole Box', 'medilazar-core' ),
					'button' => __( 'Button Only', 'medilazar-core' ),
				],
				'default' => 'button',
				'condition' => [
					'link[url]!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'side_b_background_tab', [ 'label' => __( 'Background', 'medilazar-core' ) ] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_b',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .elementor-flip-box__back',
			]
		);

		$this->add_control(
			'background_overlay_b',
			[
				'label' => __( 'Background Overlay', 'medilazar-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__overlay' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
					'background_b_image[id]!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_settings',
			[
				'label' => __( 'Settings', 'medilazar-core' ),
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => __( 'Height', 'medilazar-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', 'vh' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'medilazar-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__layer, {{WRAPPER}} .elementor-flip-box__layer__overlay' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'flip_effect',
			[
				'label' => __( 'Flip Effect', 'medilazar-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'flip',
				'options' => [
					'flip' => 'Flip',
					'slide' => 'Slide',
					'push' => 'Push',
					'zoom-in' => 'Zoom In',
					'zoom-out' => 'Zoom Out',
					'fade' => 'Fade',
				],
                'default' => 'slide',
				'prefix_class' => 'elementor-flip-box--effect-',
			]
		);

		$this->add_control(
			'flip_direction',
			[
				'label' => __( 'Flip Direction', 'medilazar-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'up',
				'options' => [
					'left' => __( 'Left', 'medilazar-core' ),
					'right' => __( 'Right', 'medilazar-core' ),
					'up' => __( 'Up', 'medilazar-core' ),
					'down' => __( 'Down', 'medilazar-core' ),
				],
				'condition' => [
					'flip_effect!' => [
							'fade',
							'zoom-in',
							'zoom-out',
						],
				],
				'prefix_class' => 'elementor-flip-box--direction-',
			]
		);

		$this->add_control(
			'flip_3d',
			[
				'label' => __( '3D Depth', 'medilazar-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'medilazar-core' ),
				'label_off' => __( 'Off', 'medilazar-core' ),
				'return_value' => 'elementor-flip-box--3d',
				'default' => '',
				'prefix_class' => '',
				'condition' => [
					'flip_effect' => 'flip',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_a',
			[
				'label' => __( 'Front', 'medilazar-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'padding_a',
			[
				'label' => __( 'Padding', 'medilazar-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'alignment_a',
			[
				'label' => __( 'Alignment', 'medilazar-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'medilazar-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'medilazar-core' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'medilazar-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__overlay' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'vertical_position_a',
			[
				'label' => __( 'Vertical Position', 'medilazar-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'top' => [
						'title' => __( 'Top', 'medilazar-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'medilazar-core' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'medilazar-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary' => [
					'top' => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
                'default' => 'bottom',
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__overlay' => 'justify-content: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_a',
				'selector' => '{{WRAPPER}} .elementor-flip-box__front',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'heading_image_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Image', 'medilazar-core' ),
				'condition' => [
					'graphic_element' => 'image',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_spacing',
			[
				'label' => __( 'Spacing', 'medilazar-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_control(
			'image_width',
			[
				'label' => __( 'Size (%)', 'medilazar-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
				],
				'range' => [
					'%' => [
						'min' => 5,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__image img' => 'width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label' => __( 'Opacity', 'medilazar-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__image' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .elementor-flip-box__image img',
				'condition' => [
					'graphic_element' => 'image',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'medilazar-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__image img' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_control(
			'heading_icon_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Icon', 'medilazar-core' ),
				'condition' => [
					'graphic_element' => 'icon',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_spacing',
			[
				'label' => __( 'Spacing', 'medilazar-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_primary_color',
			[
				'label' => __( 'Primary Color', 'medilazar-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .elementor-view-framed .elementor-icon, {{WRAPPER}} .elementor-view-default .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}}',
				],
				'condition' => [
					'graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_secondary_color',
			[
				'label' => __( 'Secondary Color', 'medilazar-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'graphic_element' => 'icon',
					'icon_view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-view-framed .elementor-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .elementor-view-stacked .elementor-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'medilazar-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_padding',
			[
				'label' => __( 'Icon Padding', 'medilazar-core' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
				],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'condition' => [
					'graphic_element' => 'icon',
					'icon_view!' => 'default',
				],
			]
		);

		$this->add_control(
			'icon_rotate',
			[
				'label' => __( 'Icon Rotate', 'medilazar-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon i' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
				'condition' => [
					'graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_border_width',
			[
				'label' => __( 'Border Width', 'medilazar-core' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'border-width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'graphic_element' => 'icon',
					'icon_view' => 'framed',
				],
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label' => __( 'Border Radius', 'medilazar-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'graphic_element' => 'icon',
					'icon_view!' => 'default',
				],
			]
		);


        $this->add_control(
            'heading_sub_title_style_a',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Sub Title', 'medilazar-core' ),
                'separator' => 'before',
                'condition' => [
                    'sub_title_text_a!' => '',
                ],
            ]
        );

        $this->add_control(
            'sub_title_spacing_a',
            [
                'label' => __( 'Spacing', 'medilazar-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__sub_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'sub_title_text_a!' => '',
                ],
            ]
        );

        $this->add_control(
            'sub_title_color_a',
            [
                'label' => __( 'Text Color', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__sub_title' => 'color: {{VALUE}}',

                ],
                'condition' => [
                    'sub_title_text_a!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sub_title_typography_a',
                'selector' => '{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__sub_title',
                'condition' => [
                    'sub_title_text_a!' => '',
                ],
            ]
        );

        $this->add_control(
            'svg_style_a',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'SVG', 'medilazar-core' ),
                'separator' => 'before',
                'condition' => [
                    'title_text_a!' => '',
                ],
            ]
        );

        $this->add_control(
            'show_svg_a',
            [
                'label'     => __('Show', 'medilazar-core'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => 'Show',
                'label_off' => 'Hide',
                'default'   => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__inner svg' => 'display: block;',

                ],
            ]
        );

        $this->add_control(
            'svg_color_a',
            [
                'label' => __( 'Color', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__inner svg' => 'fill: {{VALUE}}',

                ],
                'condition' => [
                    'title_text_a!' => '',
                    'show_svg_a!' => '',
                ],
            ]
        );

        $this->add_control(
            'svg_spacing_a',
            [
                'label' => __( 'Spacing', 'medilazar-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
//                'default'    => [
//                    'size' => 20,
//                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__inner svg' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'title_text_a!' => '',
                    'show_svg_a!' => '',
                ],
            ]
        );

		$this->add_control(
			'heading_title_style_a',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Title', 'medilazar-core' ),
				'separator' => 'before',
				'condition' => [
					'title_text_a!' => '',
				],
			]
		);

		$this->add_control(
			'title_spacing_a',
			[
				'label' => __( 'Spacing', 'medilazar-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'title_text_a!' => '',
				],
			]
		);

		$this->add_control(
			'title_color_a',
			[
				'label' => __( 'Text Color', 'medilazar-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__title' => 'color: {{VALUE}}',

				],
				'condition' => [
					'title_text_a!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography_a',
				'selector' => '{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__title',
				'condition' => [
					'title_text_a!' => '',
				],
			]
		);

		$this->add_control(
			'heading_description_style_a',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Description', 'medilazar-core' ),
				'separator' => 'before',
				'condition' => [
					'description_text_a!' => '',
				],
			]
		);

		$this->add_control(
			'description_color_a',
			[
				'label' => __( 'Text Color', 'medilazar-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__description' => 'color: {{VALUE}}',

				],
				'condition' => [
					'description_text_a!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography_a',
				'selector' => '{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__description',
				'condition' => [
					'description_text_a!' => '',
				],
			]
		);

        $this->add_control(
            'description_spacing_a',
            [
                'label' => __( 'Spacing', 'medilazar-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'description_text_a!' => '',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_b',
			[
				'label' => __( 'Back', 'medilazar-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'padding_b',
			[
				'label' => __( 'Padding', 'medilazar-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'alignment_b',
			[
				'label' => __( 'Alignment', 'medilazar-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'medilazar-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'medilazar-core' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'medilazar-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__overlay' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .elementor-flip-box__button' => 'margin-{{VALUE}}: 0',
				],
			]
		);

		$this->add_control(
			'vertical_position_b',
			[
				'label' => __( 'Vertical Position', 'medilazar-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'top' => [
						'title' => __( 'Top', 'medilazar-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'medilazar-core' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'medilazar-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary' => [
					'top' => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
                'default' => 'bottom',
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__overlay' => 'justify-content: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_b',
				'selector' => '{{WRAPPER}} .elementor-flip-box__back',
				'separator' => 'before',
			]
		);

        $this->add_control(
            'heading_sub_title_style_b',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Sub Title', 'medilazar-core' ),
                'separator' => 'before',
                'condition' => [
                    'sub_title_text_b!' => '',
                ],
            ]
        );

        $this->add_control(
            'sub_title_spacing_b',
            [
                'label' => __( 'Spacing', 'medilazar-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__sub_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'sub_title_text_b!' => '',
                ],
            ]
        );

        $this->add_control(
            'sub_title_color_b',
            [
                'label' => __( 'Text Color', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__sub_title' => 'color: {{VALUE}}',

                ],
                'condition' => [
                    'sub_title_text_b!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sub_title_typography_b',
                'selector' => '{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__sub_title',
                'condition' => [
                    'sub_title_text_b!' => '',
                ],
            ]
        );

        $this->add_control(
            'svg_style_b',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'SVG', 'medilazar-core' ),
                'separator' => 'before',
                'condition' => [
                    'title_text_b!' => '',
                ],
            ]
        );

        $this->add_control(
            'show_svg_b',
            [
                'label'     => __('Show', 'medilazar-core'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => 'Show',
                'label_off' => 'Hide',
                'default'   => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__inner svg' => 'display: block;',

                ],
            ]
        );

        $this->add_control(
            'svg_color_b',
            [
                'label' => __( 'Color', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__inner svg' => 'fill: {{VALUE}}',

                ],
                'condition' => [
                    'title_text_b!' => '',
                    'show_svg_b!' => '',
                ],
            ]
        );

        $this->add_control(
            'svg_spacing_b',
            [
                'label' => __( 'Spacing', 'medilazar-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'size' => 25,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__inner svg' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'title_text_b!' => '',
                    'show_svg_b!' => '',
                ],
            ]
        );

		$this->add_control(
			'heading_title_style_b',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Title', 'medilazar-core' ),
				'separator' => 'before',
				'condition' => [
					'title_text_b!' => '',
				],
			]
		);

		$this->add_control(
			'title_spacing_b',
			[
				'label' => __( 'Spacing', 'medilazar-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'title_text_b!' => '',
				],
			]
		);

		$this->add_control(
			'title_color_b',
			[
				'label' => __( 'Text Color', 'medilazar-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__title' => 'color: {{VALUE}}',

				],
				'condition' => [
					'title_text_b!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography_b',
				'selector' => '{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__title',
				'condition' => [
					'title_text_b!' => '',
				],
			]
		);

		$this->add_control(
			'heading_description_style_b',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Description', 'medilazar-core' ),
				'separator' => 'before',
				'condition' => [
					'description_text_b!' => '',
				],
			]
		);

		$this->add_control(
			'description_spacing_b',
			[
				'label' => __( 'Spacing', 'medilazar-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
                'default'    => [
                    'size' => 30,
                ],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
                'condition' => [
                    'description_text_b!' => '',
                ],
			]
		);

		$this->add_control(
			'description_color_b',
			[
				'label' => __( 'Text Color', 'medilazar-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__description' => 'color: {{VALUE}}',

				],
				'condition' => [
					'description_text_b!' => '',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography_b',
				'selector' => '{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__description',
				'condition' => [
					'description_text_b!' => '',
				],
			]
		);

		$this->add_control(
			'heading_button',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Button', 'medilazar-core' ),
				'separator' => 'before',
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_size',
			[
				'label' => __( 'Size', 'medilazar-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'md',
				'options' => [
					'xs' => __( 'Extra Small', 'medilazar-core' ),
					'sm' => __( 'Small', 'medilazar-core' ),
					'md' => __( 'Medium', 'medilazar-core' ),
					'lg' => __( 'Large', 'medilazar-core' ),
					'xl' => __( 'Extra Large', 'medilazar-core' ),
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .elementor-flip-box__button',
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab( 'normal',
			[
				'label' => __( 'Normal', 'medilazar-core' ),
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'medilazar-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button' => 'color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label' => __( 'Background Color', 'medilazar-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label' => __( 'Border Color', 'medilazar-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover',
			[
				'label' => __( 'Hover', 'medilazar-core' ),
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label' => __( 'Text Color', 'medilazar-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label' => __( 'Background Color', 'medilazar-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'medilazar-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'button_border_width',
			[
				'label' => __( 'Border Width', 'medilazar-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button' => 'border-width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'medilazar-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();
		$wrapper_tag = 'div';
		$button_tag = 'a';
		$link_url = empty( $settings['link']['url'] ) ? '#' : $settings['link']['url'];
		$this->add_render_attribute( 'button', 'class', [
				'elementor-flip-box__button',
				'elementor-button',
				'elementor-size-' . $settings['button_size'],
			]
		);

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-flip-box__layer elementor-flip-box__back' );
		if ( 'box' === $settings['link_click'] ) {
			$wrapper_tag = 'a';
			$button_tag = 'button';
			$this->add_render_attribute( 'wrapper', 'href', $link_url );
			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'wrapper', 'target', '_blank' );
			}
		} else {
			$this->add_render_attribute( 'button', 'href', $link_url );
			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'button', 'target', '_blank' );
			}
		}

		if ( 'icon' === $settings['graphic_element'] ) {
			$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-icon-wrapper' );
			$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-view-' . $settings['icon_view'] );
			if ( 'default' != $settings['icon_view'] ) {
				$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-shape-' . $settings['icon_shape'] );
			}
			if ( ! empty( $settings['icon'] ) ) {
				$this->add_render_attribute( 'icon', 'class', $settings['icon'] );
			}
		}

		?>
		<div class="elementor-flip-box">
			<div class="elementor-flip-box__layer elementor-flip-box__front">
				<div class="elementor-flip-box__layer__overlay">
					<div class="elementor-flip-box__layer__inner">
						<?php if ( 'image' === $settings['graphic_element'] && ! empty( $settings['image']['url'] ) ) : ?>
							<div class="elementor-flip-box__image">
								<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings ); ?>
							</div>
						<?php elseif ( 'icon' === $settings['graphic_element'] && ! empty( $settings['icon'] ) ) : ?>
							<div <?php echo $this->get_render_attribute_string( 'icon-wrapper' ); ?>>
								<div class="elementor-icon">
									<i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
								</div>
							</div>
						<?php endif; ?>

                        <?php if ( ! empty( $settings['sub_title_text_a'] ) ) : ?>
                            <span class="elementor-flip-box__layer__sub_title">
                                <?php echo $settings['sub_title_text_a']; ?>
                            </span>
                        <?php endif; ?>

						<?php if ( ! empty( $settings['title_text_a'] ) ) : ?>
							<h3 class="elementor-flip-box__layer__title">
								<?php echo $settings['title_text_a']; ?>
							</h3>
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="88" height="11" x="0px" y="0px" viewBox="0 0 88 10.7" enable-background="new 0 0 88 10.7" xml:space="preserve"> <path fill-rule="evenodd" clip-rule="evenodd" d="M0.7,6.6C0.4,6.6,0.4,6.4,0,6.4C0,6.3,0.9,6.4,0.7,6.6z M0.4,5.9 	c0.3-0.3,0.6,0,1.1,0C1.3,6,0.9,6,0.4,5.9z M1.7,6.5c-0.3,0.1-0.6,0.1-0.9,0C1,6.3,1.4,6.5,1.7,6.5z M4.8,4.2c-0.5,0.1-1-0.1-1.6,0 	C3.5,3.9,4.4,4.2,4.8,4.2z M16.6,7.7C12.4,7.8,8.1,7.3,4.3,7c0-0.1,0.1-0.1,0.1-0.2C8.2,7.2,13,7.1,16.6,7.7z M5.5,5.5 	C5.4,5.4,5.3,5.3,5.1,5.2C5.8,5.1,6.2,5,6.8,5.1c0,0.4-0.6,0.2-0.7,0.2C7.1,5.9,8.5,5.6,10,5.8c-1.6,0.5-3.7-0.1-5.5,0 	c0-0.1,0-0.2,0-0.2C4.9,5.6,5.3,5.6,5.5,5.5z M7.9,5.2c0.3-0.1,0.8-0.2,1,0C8.7,5.4,8.1,5.5,7.9,5.2z M9.5,6.5 	c-0.2,0.2-1.1,0.3-1.3,0C8.5,6.1,9,6.4,9.5,6.5z M9.1,5.3c0-0.1,0-0.2,0-0.2c0.8,0.4,1.3-0.1,1.9,0.2C10.7,5.7,9.6,5.5,9.1,5.3z 	 M14.3,4.6c-0.6,0.2-1.4,0.2-2.4,0.1c0-0.1,0-0.2,0-0.2C12.7,4.5,13.6,4.4,14.3,4.6z M11.6,6.8c0.3-0.4,1.3-0.1,1.8,0 	C12.9,6.9,12.3,6.9,11.6,6.8z M11.9,5.6c0.3-0.4,0.7-0.3,1.4-0.1C12.9,5.8,12.6,5.6,11.9,5.6z M14.5,5.9c-1,0-1.7,0.4-2.6,0.2 	c0.2-0.3,0.8-0.2,1.4-0.2C14.6,5,17.1,5.7,19,5.5c-0.3,0.3-1.2,0.7-1.8,0.7C16.3,6.3,15.4,5.9,14.5,5.9z M14.5,0.3 	c0.1-0.3,0.5-0.1,0.8-0.1c-0.1,0.2,0.2,0.1,0.2,0.3c0,0.3-0.3,0.1-0.4,0.3C14.9,0.6,15,0.2,14.5,0.3z M16.6,9.4 	c-0.4,1-1.7-0.3-2.7-0.1C14.5,9.1,15.8,9.1,16.6,9.4z M19.2,7c-1.4,0.3-3.3,0.1-4.9-0.1c0.1-0.1,0.1-0.1,0.1-0.2 	C15.9,6.6,17.6,6.4,19.2,7z M15.1,4.7c0.3-0.1,0.6-0.2,1-0.1C16,4.9,15.1,5,15.1,4.7z M15.8,0.7c0.6-0.4,1.4-0.5,2.1-0.7 	C17.9,0.5,16.7,1,15.8,0.7z M17.2,4.8c0-0.1,0-0.2,0-0.2c0.2,0,0.3,0.1,0.4,0.1C17.5,4.9,17.4,4.9,17.2,4.8z M17.9,1.8 	c0.3,0,0.2-0.1,0.4,0.1C18.3,2.2,17.7,2.1,17.9,1.8z M18.4,0.2c0.2,0,0.2-0.1,0.4,0c0,0.1-0.1,0.1-0.1,0.1c0.1,0.1,0.3,0,0.2,0.4 	c0.1-0.1,0.4,0,0.6,0c-0.1,0.4-0.7,0.1-1.1,0.1C18.5,0.4,18.4,0.3,18.4,0.2z M21,4.8C20.2,5,18.7,5.1,18,4.7 	C18.9,4.4,20.2,4.5,21,4.8z M20.1,0.8c0-0.3-0.4-0.5-0.1-0.7c0.4,0.1,0.7,0,1,0.1c0.1,0.2-0.4,0.4-0.3,0.7 	C20.6,0.9,20.4,0.9,20.1,0.8z M22.1,9.5c0.1,0.3-0.7,0.5-1.1,0.2c-0.7,0.3-1.7,0.2-2.8,0.1C19,8.9,20.9,9.9,22.1,9.5z M20.5,2 	c0.3-0.1,0.5-0.2,0.9-0.2C21.6,2.1,20.7,2.2,20.5,2z M21.2,0.9c0.1-0.3,0.6-0.3,0.7-0.7c1,0.1,2.2,0,2.9,0.1 	c-0.2,0.3-1.1,0.2-0.9,0.6C23.2,0.6,22.3,0.9,21.2,0.9z M20.5,7.1c0.1-0.2,0.3-0.2,0.4-0.4c0.5,0.1,1,0.1,1.2,0.3 	C21.7,7.4,20.9,7.2,20.5,7.1z M21.6,4.8c0.4-0.1,1-0.4,1.4-0.2C22.7,4.9,22,5,21.6,4.8z M24.3,2.1c-0.5,0.1-1.3,0.1-1.9,0.1 	C22.3,1.8,23.9,1.7,24.3,2.1z M23.2,7.1c0.3-0.2,1-0.4,1.6-0.1C24.5,7.2,23.6,7.5,23.2,7.1z M24.4,9.9c-0.4,0.3-1.1,0-1.4-0.3 	C23.5,9.5,24.1,9.8,24.4,9.9z M25.3,0.7c0-0.1,0-0.1,0-0.2c0.1,0,0.1,0,0.1-0.1c0.1,0,0.1,0,0.2,0c0,0.1,0,0.1,0.1,0.1 	c0,0.1,0,0.1,0,0.2c-0.1,0-0.1,0-0.1,0.1C25.6,0.8,25.5,0.8,25.3,0.7C25.5,0.8,25.4,0.7,25.3,0.7z M25.8,0.5 	c-0.2-0.2,0.3-0.4,0.6-0.3C26.4,0.5,25.9,0.4,25.8,0.5z M24.9,7c0.9-0.5,2.9-0.2,4.2,0C28.7,7.5,27.4,7,27,7.4 	C26.3,7,25.4,7.5,24.9,7z M26.5,9.9c-0.6,0.4-1.6-0.1-2,0C25,9.5,26.1,9.9,26.5,9.9z M27.3,0.4c0-0.3,0.2-0.3,0.5-0.3 	C27.8,0.4,27.6,0.5,27.3,0.4z M28.4,2.8c0.5-0.5,1.6-0.1,2,0C30,3.3,28.8,2.7,28.4,2.8z M28.5,9.9c-0.2,0.2-0.7,0.3-0.8,0.1 	C27.8,9.8,28.3,9.8,28.5,9.9z M36.6,1.2c0.2-0.2,0.6-0.5,0.9-0.3C37.2,1,37,1.2,36.6,1.2z M37.8,0.5c0.1-0.1,0.1-0.1,0-0.2 	c0.1-0.1,0.4-0.1,0.6-0.1C38.4,0.5,38.1,0.5,37.8,0.5z M39.6,0.4c0.5-0.2,1.9-0.2,2.7,0c1.1-0.3,2.8-0.1,4.3,0 	c-0.9,0.7-2.6,1-4.2,0.6c0.1-0.3,0.7-0.1,0.9-0.3C42,0.1,40.7,0.8,39.6,0.4z M41.4,0.9c-0.1,0.2-0.4,0.2-0.7,0.1 	C40.7,0.6,41.3,0.7,41.4,0.9z M52,10.5c-0.1,0.1-0.1,0.1,0,0.2c-0.2,0.1-0.5,0.1-0.8,0C51.1,10.6,51.7,10.5,52,10.5z M64.6,10.1 	c0,0.4-0.3,0.1-0.6,0.1c-1.9,0.4-4.7,0.6-6.7,0.2c-0.8,0.2-1.7,0.4-2.8,0.3c0-0.1,0.1-0.1,0.1-0.2c0.8-0.1,1.9,0,2.5-0.3 	c0.3,0,0.5,0.1,0.8,0.1c1.8,0.1,4.3-0.3,5.9-0.3C64,9.9,64.9,9.9,64.6,10.1z M84.4,4.5c0-0.3-0.2-0.6,0-0.7c0.1,0.1,0.1,0.1,0.3,0.1 	C84.6,4.2,85,4.6,84.4,4.5z M7.2,6.4C7,6.5,6.8,6.5,6.6,6.4c0.1-0.2,0.4,0,0.4-0.2C7.2,6.3,7,6.3,7.2,6.4z M9.3,4.5 	c0.2-0.3,1,0.1,1.4,0C10.5,4.6,9.7,4.7,9.3,4.5z M12.8,9.3c-0.2,0.2-0.6,0-0.9-0.1c0.2-0.1,0.6-0.2,0.7,0c0.1,0,0.1,0,0.1-0.1 	C12.9,9.1,12.6,9.2,12.8,9.3z M19.5,6.1c0-0.2-0.2-0.2-0.1-0.4c0.2-0.1,0.7,0,0.9,0c-0.2,0.3,0.5,0.2,0.4,0.5 	C20.3,5.6,20.2,6.3,19.5,6.1z M25.7,4.7c0.4-0.5,1.2-0.1,1.7-0.1c0.2,0.1-0.6,0-0.7,0.2c-0.3,0-0.2-0.3-0.4-0.3 	C26.1,4.6,26.1,4.9,25.7,4.7z M87.2,7.6c-0.6,0.7-2.4,0-2.9,0.7c-5.2-0.2-9.2,0.1-14.5-0.2c-0.3,0.1,0.3,0.2,0.1,0.5 	c-0.7,0.2-1.9-0.1-2.5,0.1c0.6,0.5,2.5,0,3,0.4c-0.1,0.4-0.8,0.2-1.3,0.2c-2,0.5-4.3,0.1-6.6,0.1c-1.5,0-3.2,0.1-4.8,0.1 	c-6.2,0.1-12.3,0.3-19,0.6C38.4,10.3,38.5,10,38,10c-1.4-0.1-2.9,0.5-4.4,0.4c-1.2-0.1-2.8-0.5-3.9-0.3c0.2-0.4,1.4-0.2,1.8-0.1 	c3.5-0.6,7.5-0.3,10.8-0.3c1-0.4,2.8,0.1,3.7-0.5c0-0.1-0.1-0.1-0.1-0.2c-0.4-0.3-0.9,0.2-1.4,0.1c-0.3,0-0.1-0.3-0.3-0.4 	c-1,0.1-1.9-0.2-3.1,0c0,0.4,0.5,0,0.7,0.3c-0.9,0.1-2.6,0.6-2.7-0.4c0.1,0.1,0.5,0.2,0.2,0.4c0.5-0.1,0.9-0.1,1.4-0.2 	c-0.1-0.4-0.9,0-1.3,0c-0.1-0.2-0.4-0.2-0.5-0.4C35,8.2,30.5,8.7,26.2,7.9c2.2-0.3,5.2,0.1,7.6-0.4c0.5,0.7,1.7,0.2,2.5,0.3 	c-0.2-0.5-1.3-0.4-1.7-0.2c0.1-0.3-0.6-0.1-0.4-0.4c-1.6-0.1-3.3,0.7-4.7-0.3c0.5-0.3,1.3-0.2,2-0.3c-1.8-0.7-3.7-0.1-5.5-0.2 	c-0.4,0-0.9-0.3-1.4-0.3c-0.4,0-0.8,0.2-1.2,0.2c-0.8,0-1.6-0.5-2.5-0.4c0.1-0.4,0.7-0.2,1.2-0.2c1.4-0.4,2.9-0.1,4.3-0.3 	C27.8,5.4,29,4.6,30.3,5c0.2-0.2,0.5-0.4,0.9-0.4c0,0.2,0.2,0.3,0.6,0.3c0.1-0.2-0.2-0.2-0.3-0.3c0.3-0.3,0.6,0,0.9,0.1 	c0.2,0-0.1-0.3,0.3-0.3c0.4,0,0.3,0.2,0.4,0.3c1.5-0.3,3.3,0.3,4.5-0.3c0.4,0,0.6,0.1,0.9,0.2c0.2,0,0.2-0.3,0.4-0.4 	c3.3,0.3,6.7,0,10.1,0c-0.4-0.2-1.5,0-2.2-0.4c-0.5,0-2.2,0.3-2.5,0.2c-0.1,0-0.2-0.3-0.4-0.3c-0.9-0.1-1.5,0.5-2.7,0.3 	c-0.3,0-0.1-0.3-0.3-0.4c-0.9,0-2,0.1-3.4,0c-0.7,0-1.9-0.3-2.1,0c0,0,0.2,0.2,0.3,0.1c-0.3,0.1-0.8,0.1-1,0.2 	c0-0.3,0.3-0.3,0.1-0.5c-0.9,0.1-1.1-0.3-1.7-0.4c0-0.7,1.2,0,1.4-0.5c-0.8-0.3-2.6-0.6-3.5,0c-1.7-0.9-4,0-5.7-0.4 	c0.4-0.5,1.6-0.5,2.3-0.4c1.3-0.5,3,0.2,4.2-0.3c0.4,0.5,1.1,0.1,1.7,0.4c1.6-0.9,4,0.2,5.8-0.5c0.2,0.1,0.2,0.2,0.5,0.2 	c0.8-0.2,2,0,2.7-0.4c0.8,0.2,1.4-0.1,2,0.2c0.5-0.1,1-0.2,1.7-0.1c0.6-0.4,1.8-0.2,2.3-0.7c-0.4-0.3-0.9,0.2-1.5,0 	c-0.1-0.1,0-0.3-0.2-0.4c2.5-0.4,5.4,0,8.2-0.1c0.2,0.1,0.5,0.2,0.3,0.3c0.4,0,0.5-0.3,0.8-0.3c2.6-0.2,5.3,0.1,7.8,0.3 	c1.8,0.1,3.6-0.2,5.1,0.6c1.4,0.1,3.2,0,4.9,0.5c0.8,0.2,1.3,0.6,2.1,0.6c0.5,0,1.1-0.2,1.6-0.1c0.2,0.1,0.1,0.4,0.2,0.5 	c0.8,0.1,1.5-0.3,2.1,0c0,0.2-0.3,0.1-0.4,0.4C79.7,3,80,3.1,80.2,2.9C80.6,4.3,83.3,4,84,5.2c1.5,0.1,3.9,0.5,4,1.5 	c-0.6-0.2-1.5-0.8-2.2-0.4C85.9,6.9,87.3,7.1,87.2,7.6z M35.7,0.1c0.2,0-0.1,0.1,0.1,0.2c-0.2,0.1-0.6,0.2-0.8,0.2 	C34.2,0.5,34.6,0,35.7,0.1z M53.2,10.6c0.3-0.2,0.7-0.2,1.1-0.1c-0.1,0.4-0.9,0.1-1.3,0.2C53.2,10.6,53.4,10.6,53.2,10.6z M27.3,0.8 	c1.6-0.9,5.1-0.7,7.1-0.6c-1.3,0.6-3.4,1.1-5.2,0.6c0.1-0.2,0.5,0,0.7-0.2C28.9,0.2,28.1,1.3,27.3,0.8z"/></svg>
						<?php endif; ?>

						<?php if ( ! empty( $settings['description_text_a'] ) ) : ?>
							<div class="elementor-flip-box__layer__description">
								<?php echo $settings['description_text_a']; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<<?php echo $wrapper_tag; ?> <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<div class="elementor-flip-box__layer__overlay">
					<div class="elementor-flip-box__layer__inner">

                        <?php if ( ! empty( $settings['sub_title_text_b'] ) ) : ?>
                            <span class="elementor-flip-box__layer__sub_title">
                                <?php echo $settings['sub_title_text_b']; ?>
                            </span>
                        <?php endif; ?>

						<?php if ( ! empty( $settings['title_text_b'] ) ) : ?>
							<h3 class="elementor-flip-box__layer__title">
								<?php echo $settings['title_text_b']; ?>
							</h3>
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="88" height="11" x="0px" y="0px" viewBox="0 0 88 10.7" enable-background="new 0 0 88 10.7" xml:space="preserve"> <path fill-rule="evenodd" clip-rule="evenodd" d="M0.7,6.6C0.4,6.6,0.4,6.4,0,6.4C0,6.3,0.9,6.4,0.7,6.6z M0.4,5.9 	c0.3-0.3,0.6,0,1.1,0C1.3,6,0.9,6,0.4,5.9z M1.7,6.5c-0.3,0.1-0.6,0.1-0.9,0C1,6.3,1.4,6.5,1.7,6.5z M4.8,4.2c-0.5,0.1-1-0.1-1.6,0 	C3.5,3.9,4.4,4.2,4.8,4.2z M16.6,7.7C12.4,7.8,8.1,7.3,4.3,7c0-0.1,0.1-0.1,0.1-0.2C8.2,7.2,13,7.1,16.6,7.7z M5.5,5.5 	C5.4,5.4,5.3,5.3,5.1,5.2C5.8,5.1,6.2,5,6.8,5.1c0,0.4-0.6,0.2-0.7,0.2C7.1,5.9,8.5,5.6,10,5.8c-1.6,0.5-3.7-0.1-5.5,0 	c0-0.1,0-0.2,0-0.2C4.9,5.6,5.3,5.6,5.5,5.5z M7.9,5.2c0.3-0.1,0.8-0.2,1,0C8.7,5.4,8.1,5.5,7.9,5.2z M9.5,6.5 	c-0.2,0.2-1.1,0.3-1.3,0C8.5,6.1,9,6.4,9.5,6.5z M9.1,5.3c0-0.1,0-0.2,0-0.2c0.8,0.4,1.3-0.1,1.9,0.2C10.7,5.7,9.6,5.5,9.1,5.3z 	 M14.3,4.6c-0.6,0.2-1.4,0.2-2.4,0.1c0-0.1,0-0.2,0-0.2C12.7,4.5,13.6,4.4,14.3,4.6z M11.6,6.8c0.3-0.4,1.3-0.1,1.8,0 	C12.9,6.9,12.3,6.9,11.6,6.8z M11.9,5.6c0.3-0.4,0.7-0.3,1.4-0.1C12.9,5.8,12.6,5.6,11.9,5.6z M14.5,5.9c-1,0-1.7,0.4-2.6,0.2 	c0.2-0.3,0.8-0.2,1.4-0.2C14.6,5,17.1,5.7,19,5.5c-0.3,0.3-1.2,0.7-1.8,0.7C16.3,6.3,15.4,5.9,14.5,5.9z M14.5,0.3 	c0.1-0.3,0.5-0.1,0.8-0.1c-0.1,0.2,0.2,0.1,0.2,0.3c0,0.3-0.3,0.1-0.4,0.3C14.9,0.6,15,0.2,14.5,0.3z M16.6,9.4 	c-0.4,1-1.7-0.3-2.7-0.1C14.5,9.1,15.8,9.1,16.6,9.4z M19.2,7c-1.4,0.3-3.3,0.1-4.9-0.1c0.1-0.1,0.1-0.1,0.1-0.2 	C15.9,6.6,17.6,6.4,19.2,7z M15.1,4.7c0.3-0.1,0.6-0.2,1-0.1C16,4.9,15.1,5,15.1,4.7z M15.8,0.7c0.6-0.4,1.4-0.5,2.1-0.7 	C17.9,0.5,16.7,1,15.8,0.7z M17.2,4.8c0-0.1,0-0.2,0-0.2c0.2,0,0.3,0.1,0.4,0.1C17.5,4.9,17.4,4.9,17.2,4.8z M17.9,1.8 	c0.3,0,0.2-0.1,0.4,0.1C18.3,2.2,17.7,2.1,17.9,1.8z M18.4,0.2c0.2,0,0.2-0.1,0.4,0c0,0.1-0.1,0.1-0.1,0.1c0.1,0.1,0.3,0,0.2,0.4 	c0.1-0.1,0.4,0,0.6,0c-0.1,0.4-0.7,0.1-1.1,0.1C18.5,0.4,18.4,0.3,18.4,0.2z M21,4.8C20.2,5,18.7,5.1,18,4.7 	C18.9,4.4,20.2,4.5,21,4.8z M20.1,0.8c0-0.3-0.4-0.5-0.1-0.7c0.4,0.1,0.7,0,1,0.1c0.1,0.2-0.4,0.4-0.3,0.7 	C20.6,0.9,20.4,0.9,20.1,0.8z M22.1,9.5c0.1,0.3-0.7,0.5-1.1,0.2c-0.7,0.3-1.7,0.2-2.8,0.1C19,8.9,20.9,9.9,22.1,9.5z M20.5,2 	c0.3-0.1,0.5-0.2,0.9-0.2C21.6,2.1,20.7,2.2,20.5,2z M21.2,0.9c0.1-0.3,0.6-0.3,0.7-0.7c1,0.1,2.2,0,2.9,0.1 	c-0.2,0.3-1.1,0.2-0.9,0.6C23.2,0.6,22.3,0.9,21.2,0.9z M20.5,7.1c0.1-0.2,0.3-0.2,0.4-0.4c0.5,0.1,1,0.1,1.2,0.3 	C21.7,7.4,20.9,7.2,20.5,7.1z M21.6,4.8c0.4-0.1,1-0.4,1.4-0.2C22.7,4.9,22,5,21.6,4.8z M24.3,2.1c-0.5,0.1-1.3,0.1-1.9,0.1 	C22.3,1.8,23.9,1.7,24.3,2.1z M23.2,7.1c0.3-0.2,1-0.4,1.6-0.1C24.5,7.2,23.6,7.5,23.2,7.1z M24.4,9.9c-0.4,0.3-1.1,0-1.4-0.3 	C23.5,9.5,24.1,9.8,24.4,9.9z M25.3,0.7c0-0.1,0-0.1,0-0.2c0.1,0,0.1,0,0.1-0.1c0.1,0,0.1,0,0.2,0c0,0.1,0,0.1,0.1,0.1 	c0,0.1,0,0.1,0,0.2c-0.1,0-0.1,0-0.1,0.1C25.6,0.8,25.5,0.8,25.3,0.7C25.5,0.8,25.4,0.7,25.3,0.7z M25.8,0.5 	c-0.2-0.2,0.3-0.4,0.6-0.3C26.4,0.5,25.9,0.4,25.8,0.5z M24.9,7c0.9-0.5,2.9-0.2,4.2,0C28.7,7.5,27.4,7,27,7.4 	C26.3,7,25.4,7.5,24.9,7z M26.5,9.9c-0.6,0.4-1.6-0.1-2,0C25,9.5,26.1,9.9,26.5,9.9z M27.3,0.4c0-0.3,0.2-0.3,0.5-0.3 	C27.8,0.4,27.6,0.5,27.3,0.4z M28.4,2.8c0.5-0.5,1.6-0.1,2,0C30,3.3,28.8,2.7,28.4,2.8z M28.5,9.9c-0.2,0.2-0.7,0.3-0.8,0.1 	C27.8,9.8,28.3,9.8,28.5,9.9z M36.6,1.2c0.2-0.2,0.6-0.5,0.9-0.3C37.2,1,37,1.2,36.6,1.2z M37.8,0.5c0.1-0.1,0.1-0.1,0-0.2 	c0.1-0.1,0.4-0.1,0.6-0.1C38.4,0.5,38.1,0.5,37.8,0.5z M39.6,0.4c0.5-0.2,1.9-0.2,2.7,0c1.1-0.3,2.8-0.1,4.3,0 	c-0.9,0.7-2.6,1-4.2,0.6c0.1-0.3,0.7-0.1,0.9-0.3C42,0.1,40.7,0.8,39.6,0.4z M41.4,0.9c-0.1,0.2-0.4,0.2-0.7,0.1 	C40.7,0.6,41.3,0.7,41.4,0.9z M52,10.5c-0.1,0.1-0.1,0.1,0,0.2c-0.2,0.1-0.5,0.1-0.8,0C51.1,10.6,51.7,10.5,52,10.5z M64.6,10.1 	c0,0.4-0.3,0.1-0.6,0.1c-1.9,0.4-4.7,0.6-6.7,0.2c-0.8,0.2-1.7,0.4-2.8,0.3c0-0.1,0.1-0.1,0.1-0.2c0.8-0.1,1.9,0,2.5-0.3 	c0.3,0,0.5,0.1,0.8,0.1c1.8,0.1,4.3-0.3,5.9-0.3C64,9.9,64.9,9.9,64.6,10.1z M84.4,4.5c0-0.3-0.2-0.6,0-0.7c0.1,0.1,0.1,0.1,0.3,0.1 	C84.6,4.2,85,4.6,84.4,4.5z M7.2,6.4C7,6.5,6.8,6.5,6.6,6.4c0.1-0.2,0.4,0,0.4-0.2C7.2,6.3,7,6.3,7.2,6.4z M9.3,4.5 	c0.2-0.3,1,0.1,1.4,0C10.5,4.6,9.7,4.7,9.3,4.5z M12.8,9.3c-0.2,0.2-0.6,0-0.9-0.1c0.2-0.1,0.6-0.2,0.7,0c0.1,0,0.1,0,0.1-0.1 	C12.9,9.1,12.6,9.2,12.8,9.3z M19.5,6.1c0-0.2-0.2-0.2-0.1-0.4c0.2-0.1,0.7,0,0.9,0c-0.2,0.3,0.5,0.2,0.4,0.5 	C20.3,5.6,20.2,6.3,19.5,6.1z M25.7,4.7c0.4-0.5,1.2-0.1,1.7-0.1c0.2,0.1-0.6,0-0.7,0.2c-0.3,0-0.2-0.3-0.4-0.3 	C26.1,4.6,26.1,4.9,25.7,4.7z M87.2,7.6c-0.6,0.7-2.4,0-2.9,0.7c-5.2-0.2-9.2,0.1-14.5-0.2c-0.3,0.1,0.3,0.2,0.1,0.5 	c-0.7,0.2-1.9-0.1-2.5,0.1c0.6,0.5,2.5,0,3,0.4c-0.1,0.4-0.8,0.2-1.3,0.2c-2,0.5-4.3,0.1-6.6,0.1c-1.5,0-3.2,0.1-4.8,0.1 	c-6.2,0.1-12.3,0.3-19,0.6C38.4,10.3,38.5,10,38,10c-1.4-0.1-2.9,0.5-4.4,0.4c-1.2-0.1-2.8-0.5-3.9-0.3c0.2-0.4,1.4-0.2,1.8-0.1 	c3.5-0.6,7.5-0.3,10.8-0.3c1-0.4,2.8,0.1,3.7-0.5c0-0.1-0.1-0.1-0.1-0.2c-0.4-0.3-0.9,0.2-1.4,0.1c-0.3,0-0.1-0.3-0.3-0.4 	c-1,0.1-1.9-0.2-3.1,0c0,0.4,0.5,0,0.7,0.3c-0.9,0.1-2.6,0.6-2.7-0.4c0.1,0.1,0.5,0.2,0.2,0.4c0.5-0.1,0.9-0.1,1.4-0.2 	c-0.1-0.4-0.9,0-1.3,0c-0.1-0.2-0.4-0.2-0.5-0.4C35,8.2,30.5,8.7,26.2,7.9c2.2-0.3,5.2,0.1,7.6-0.4c0.5,0.7,1.7,0.2,2.5,0.3 	c-0.2-0.5-1.3-0.4-1.7-0.2c0.1-0.3-0.6-0.1-0.4-0.4c-1.6-0.1-3.3,0.7-4.7-0.3c0.5-0.3,1.3-0.2,2-0.3c-1.8-0.7-3.7-0.1-5.5-0.2 	c-0.4,0-0.9-0.3-1.4-0.3c-0.4,0-0.8,0.2-1.2,0.2c-0.8,0-1.6-0.5-2.5-0.4c0.1-0.4,0.7-0.2,1.2-0.2c1.4-0.4,2.9-0.1,4.3-0.3 	C27.8,5.4,29,4.6,30.3,5c0.2-0.2,0.5-0.4,0.9-0.4c0,0.2,0.2,0.3,0.6,0.3c0.1-0.2-0.2-0.2-0.3-0.3c0.3-0.3,0.6,0,0.9,0.1 	c0.2,0-0.1-0.3,0.3-0.3c0.4,0,0.3,0.2,0.4,0.3c1.5-0.3,3.3,0.3,4.5-0.3c0.4,0,0.6,0.1,0.9,0.2c0.2,0,0.2-0.3,0.4-0.4 	c3.3,0.3,6.7,0,10.1,0c-0.4-0.2-1.5,0-2.2-0.4c-0.5,0-2.2,0.3-2.5,0.2c-0.1,0-0.2-0.3-0.4-0.3c-0.9-0.1-1.5,0.5-2.7,0.3 	c-0.3,0-0.1-0.3-0.3-0.4c-0.9,0-2,0.1-3.4,0c-0.7,0-1.9-0.3-2.1,0c0,0,0.2,0.2,0.3,0.1c-0.3,0.1-0.8,0.1-1,0.2 	c0-0.3,0.3-0.3,0.1-0.5c-0.9,0.1-1.1-0.3-1.7-0.4c0-0.7,1.2,0,1.4-0.5c-0.8-0.3-2.6-0.6-3.5,0c-1.7-0.9-4,0-5.7-0.4 	c0.4-0.5,1.6-0.5,2.3-0.4c1.3-0.5,3,0.2,4.2-0.3c0.4,0.5,1.1,0.1,1.7,0.4c1.6-0.9,4,0.2,5.8-0.5c0.2,0.1,0.2,0.2,0.5,0.2 	c0.8-0.2,2,0,2.7-0.4c0.8,0.2,1.4-0.1,2,0.2c0.5-0.1,1-0.2,1.7-0.1c0.6-0.4,1.8-0.2,2.3-0.7c-0.4-0.3-0.9,0.2-1.5,0 	c-0.1-0.1,0-0.3-0.2-0.4c2.5-0.4,5.4,0,8.2-0.1c0.2,0.1,0.5,0.2,0.3,0.3c0.4,0,0.5-0.3,0.8-0.3c2.6-0.2,5.3,0.1,7.8,0.3 	c1.8,0.1,3.6-0.2,5.1,0.6c1.4,0.1,3.2,0,4.9,0.5c0.8,0.2,1.3,0.6,2.1,0.6c0.5,0,1.1-0.2,1.6-0.1c0.2,0.1,0.1,0.4,0.2,0.5 	c0.8,0.1,1.5-0.3,2.1,0c0,0.2-0.3,0.1-0.4,0.4C79.7,3,80,3.1,80.2,2.9C80.6,4.3,83.3,4,84,5.2c1.5,0.1,3.9,0.5,4,1.5 	c-0.6-0.2-1.5-0.8-2.2-0.4C85.9,6.9,87.3,7.1,87.2,7.6z M35.7,0.1c0.2,0-0.1,0.1,0.1,0.2c-0.2,0.1-0.6,0.2-0.8,0.2 	C34.2,0.5,34.6,0,35.7,0.1z M53.2,10.6c0.3-0.2,0.7-0.2,1.1-0.1c-0.1,0.4-0.9,0.1-1.3,0.2C53.2,10.6,53.4,10.6,53.2,10.6z M27.3,0.8 	c1.6-0.9,5.1-0.7,7.1-0.6c-1.3,0.6-3.4,1.1-5.2,0.6c0.1-0.2,0.5,0,0.7-0.2C28.9,0.2,28.1,1.3,27.3,0.8z"/></svg>
						<?php endif; ?>

						<?php if ( ! empty( $settings['description_text_b'] ) ) : ?>
							<div class="elementor-flip-box__layer__description">
								<?php echo $settings['description_text_b']; ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $settings['button_text'] ) ) : ?>
							<<?php echo $button_tag; ?> <?php echo $this->get_render_attribute_string( 'button' ); ?>>
								<?php echo $settings['button_text']; ?>
							</<?php echo $button_tag; ?>>
						<?php endif; ?>
					</div>
				</div>
			</<?php echo $wrapper_tag; ?>>
		</div>
		<?php
	}

	protected function content_template() {
		?>
		<#
			var btnClasses = 'elementor-flip-box__button elementor-button elementor-size-' + settings.button_size;

			if ( 'image' === settings.graphic_element && '' !== settings.image.url ) {
				var image = {
					id: settings.image.id,
					url: settings.image.url,
					size: settings.image_size,
					dimension: settings.image_custom_dimension,
					model: view.getEditModel()
				};

				var imageUrl = elementor.imagesManager.getImageUrl( image );
			}

			var wrapperTag = 'div',
				buttonTag = 'a';

			if ( 'box' === settings.link_click ) {
				wrapperTag = 'a';
				buttonTag = 'button';
			}

			if ( 'icon' === settings.graphic_element ) {
				var iconWrapperClasses = 'elementor-icon-wrapper';
					iconWrapperClasses += ' elementor-view-' + settings.icon_view;
				if ( 'default' !== settings.icon_view ) {
					iconWrapperClasses += ' elementor-shape-' + settings.icon_shape;
				}
			}
		#>

		<div class="elementor-flip-box">
			<div class="elementor-flip-box__layer elementor-flip-box__front">
				<div class="elementor-flip-box__layer__overlay">
					<div class="elementor-flip-box__layer__inner">
						<# if ( 'image' === settings.graphic_element && '' !== settings.image.url ) { #>
							<div class="elementor-flip-box__image">
								<img src="{{ imageUrl }}">
							</div>
						<#  } else if ( 'icon' === settings.graphic_element && settings.icon ) { #>
							<div class="{{ iconWrapperClasses }}" >
								<div class="elementor-icon">
									<i class="{{ settings.icon }}"></i>
								</div>
							</div>
						<# } #>

                        <# if ( settings.sub_title_text_a ) { #>
                        <span class="elementor-flip-box__layer__sub_title">{{{ settings.sub_title_text_a }}}</span>
                        <# } #>

						<# if ( settings.title_text_a ) { #>
							<h3 class="elementor-flip-box__layer__title">{{{ settings.title_text_a }}}</h3>
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="88" height="11" x="0px" y="0px" viewBox="0 0 88 10.7" enable-background="new 0 0 88 10.7" xml:space="preserve"> <path fill-rule="evenodd" clip-rule="evenodd" d="M0.7,6.6C0.4,6.6,0.4,6.4,0,6.4C0,6.3,0.9,6.4,0.7,6.6z M0.4,5.9 	c0.3-0.3,0.6,0,1.1,0C1.3,6,0.9,6,0.4,5.9z M1.7,6.5c-0.3,0.1-0.6,0.1-0.9,0C1,6.3,1.4,6.5,1.7,6.5z M4.8,4.2c-0.5,0.1-1-0.1-1.6,0 	C3.5,3.9,4.4,4.2,4.8,4.2z M16.6,7.7C12.4,7.8,8.1,7.3,4.3,7c0-0.1,0.1-0.1,0.1-0.2C8.2,7.2,13,7.1,16.6,7.7z M5.5,5.5 	C5.4,5.4,5.3,5.3,5.1,5.2C5.8,5.1,6.2,5,6.8,5.1c0,0.4-0.6,0.2-0.7,0.2C7.1,5.9,8.5,5.6,10,5.8c-1.6,0.5-3.7-0.1-5.5,0 	c0-0.1,0-0.2,0-0.2C4.9,5.6,5.3,5.6,5.5,5.5z M7.9,5.2c0.3-0.1,0.8-0.2,1,0C8.7,5.4,8.1,5.5,7.9,5.2z M9.5,6.5 	c-0.2,0.2-1.1,0.3-1.3,0C8.5,6.1,9,6.4,9.5,6.5z M9.1,5.3c0-0.1,0-0.2,0-0.2c0.8,0.4,1.3-0.1,1.9,0.2C10.7,5.7,9.6,5.5,9.1,5.3z 	 M14.3,4.6c-0.6,0.2-1.4,0.2-2.4,0.1c0-0.1,0-0.2,0-0.2C12.7,4.5,13.6,4.4,14.3,4.6z M11.6,6.8c0.3-0.4,1.3-0.1,1.8,0 	C12.9,6.9,12.3,6.9,11.6,6.8z M11.9,5.6c0.3-0.4,0.7-0.3,1.4-0.1C12.9,5.8,12.6,5.6,11.9,5.6z M14.5,5.9c-1,0-1.7,0.4-2.6,0.2 	c0.2-0.3,0.8-0.2,1.4-0.2C14.6,5,17.1,5.7,19,5.5c-0.3,0.3-1.2,0.7-1.8,0.7C16.3,6.3,15.4,5.9,14.5,5.9z M14.5,0.3 	c0.1-0.3,0.5-0.1,0.8-0.1c-0.1,0.2,0.2,0.1,0.2,0.3c0,0.3-0.3,0.1-0.4,0.3C14.9,0.6,15,0.2,14.5,0.3z M16.6,9.4 	c-0.4,1-1.7-0.3-2.7-0.1C14.5,9.1,15.8,9.1,16.6,9.4z M19.2,7c-1.4,0.3-3.3,0.1-4.9-0.1c0.1-0.1,0.1-0.1,0.1-0.2 	C15.9,6.6,17.6,6.4,19.2,7z M15.1,4.7c0.3-0.1,0.6-0.2,1-0.1C16,4.9,15.1,5,15.1,4.7z M15.8,0.7c0.6-0.4,1.4-0.5,2.1-0.7 	C17.9,0.5,16.7,1,15.8,0.7z M17.2,4.8c0-0.1,0-0.2,0-0.2c0.2,0,0.3,0.1,0.4,0.1C17.5,4.9,17.4,4.9,17.2,4.8z M17.9,1.8 	c0.3,0,0.2-0.1,0.4,0.1C18.3,2.2,17.7,2.1,17.9,1.8z M18.4,0.2c0.2,0,0.2-0.1,0.4,0c0,0.1-0.1,0.1-0.1,0.1c0.1,0.1,0.3,0,0.2,0.4 	c0.1-0.1,0.4,0,0.6,0c-0.1,0.4-0.7,0.1-1.1,0.1C18.5,0.4,18.4,0.3,18.4,0.2z M21,4.8C20.2,5,18.7,5.1,18,4.7 	C18.9,4.4,20.2,4.5,21,4.8z M20.1,0.8c0-0.3-0.4-0.5-0.1-0.7c0.4,0.1,0.7,0,1,0.1c0.1,0.2-0.4,0.4-0.3,0.7 	C20.6,0.9,20.4,0.9,20.1,0.8z M22.1,9.5c0.1,0.3-0.7,0.5-1.1,0.2c-0.7,0.3-1.7,0.2-2.8,0.1C19,8.9,20.9,9.9,22.1,9.5z M20.5,2 	c0.3-0.1,0.5-0.2,0.9-0.2C21.6,2.1,20.7,2.2,20.5,2z M21.2,0.9c0.1-0.3,0.6-0.3,0.7-0.7c1,0.1,2.2,0,2.9,0.1 	c-0.2,0.3-1.1,0.2-0.9,0.6C23.2,0.6,22.3,0.9,21.2,0.9z M20.5,7.1c0.1-0.2,0.3-0.2,0.4-0.4c0.5,0.1,1,0.1,1.2,0.3 	C21.7,7.4,20.9,7.2,20.5,7.1z M21.6,4.8c0.4-0.1,1-0.4,1.4-0.2C22.7,4.9,22,5,21.6,4.8z M24.3,2.1c-0.5,0.1-1.3,0.1-1.9,0.1 	C22.3,1.8,23.9,1.7,24.3,2.1z M23.2,7.1c0.3-0.2,1-0.4,1.6-0.1C24.5,7.2,23.6,7.5,23.2,7.1z M24.4,9.9c-0.4,0.3-1.1,0-1.4-0.3 	C23.5,9.5,24.1,9.8,24.4,9.9z M25.3,0.7c0-0.1,0-0.1,0-0.2c0.1,0,0.1,0,0.1-0.1c0.1,0,0.1,0,0.2,0c0,0.1,0,0.1,0.1,0.1 	c0,0.1,0,0.1,0,0.2c-0.1,0-0.1,0-0.1,0.1C25.6,0.8,25.5,0.8,25.3,0.7C25.5,0.8,25.4,0.7,25.3,0.7z M25.8,0.5 	c-0.2-0.2,0.3-0.4,0.6-0.3C26.4,0.5,25.9,0.4,25.8,0.5z M24.9,7c0.9-0.5,2.9-0.2,4.2,0C28.7,7.5,27.4,7,27,7.4 	C26.3,7,25.4,7.5,24.9,7z M26.5,9.9c-0.6,0.4-1.6-0.1-2,0C25,9.5,26.1,9.9,26.5,9.9z M27.3,0.4c0-0.3,0.2-0.3,0.5-0.3 	C27.8,0.4,27.6,0.5,27.3,0.4z M28.4,2.8c0.5-0.5,1.6-0.1,2,0C30,3.3,28.8,2.7,28.4,2.8z M28.5,9.9c-0.2,0.2-0.7,0.3-0.8,0.1 	C27.8,9.8,28.3,9.8,28.5,9.9z M36.6,1.2c0.2-0.2,0.6-0.5,0.9-0.3C37.2,1,37,1.2,36.6,1.2z M37.8,0.5c0.1-0.1,0.1-0.1,0-0.2 	c0.1-0.1,0.4-0.1,0.6-0.1C38.4,0.5,38.1,0.5,37.8,0.5z M39.6,0.4c0.5-0.2,1.9-0.2,2.7,0c1.1-0.3,2.8-0.1,4.3,0 	c-0.9,0.7-2.6,1-4.2,0.6c0.1-0.3,0.7-0.1,0.9-0.3C42,0.1,40.7,0.8,39.6,0.4z M41.4,0.9c-0.1,0.2-0.4,0.2-0.7,0.1 	C40.7,0.6,41.3,0.7,41.4,0.9z M52,10.5c-0.1,0.1-0.1,0.1,0,0.2c-0.2,0.1-0.5,0.1-0.8,0C51.1,10.6,51.7,10.5,52,10.5z M64.6,10.1 	c0,0.4-0.3,0.1-0.6,0.1c-1.9,0.4-4.7,0.6-6.7,0.2c-0.8,0.2-1.7,0.4-2.8,0.3c0-0.1,0.1-0.1,0.1-0.2c0.8-0.1,1.9,0,2.5-0.3 	c0.3,0,0.5,0.1,0.8,0.1c1.8,0.1,4.3-0.3,5.9-0.3C64,9.9,64.9,9.9,64.6,10.1z M84.4,4.5c0-0.3-0.2-0.6,0-0.7c0.1,0.1,0.1,0.1,0.3,0.1 	C84.6,4.2,85,4.6,84.4,4.5z M7.2,6.4C7,6.5,6.8,6.5,6.6,6.4c0.1-0.2,0.4,0,0.4-0.2C7.2,6.3,7,6.3,7.2,6.4z M9.3,4.5 	c0.2-0.3,1,0.1,1.4,0C10.5,4.6,9.7,4.7,9.3,4.5z M12.8,9.3c-0.2,0.2-0.6,0-0.9-0.1c0.2-0.1,0.6-0.2,0.7,0c0.1,0,0.1,0,0.1-0.1 	C12.9,9.1,12.6,9.2,12.8,9.3z M19.5,6.1c0-0.2-0.2-0.2-0.1-0.4c0.2-0.1,0.7,0,0.9,0c-0.2,0.3,0.5,0.2,0.4,0.5 	C20.3,5.6,20.2,6.3,19.5,6.1z M25.7,4.7c0.4-0.5,1.2-0.1,1.7-0.1c0.2,0.1-0.6,0-0.7,0.2c-0.3,0-0.2-0.3-0.4-0.3 	C26.1,4.6,26.1,4.9,25.7,4.7z M87.2,7.6c-0.6,0.7-2.4,0-2.9,0.7c-5.2-0.2-9.2,0.1-14.5-0.2c-0.3,0.1,0.3,0.2,0.1,0.5 	c-0.7,0.2-1.9-0.1-2.5,0.1c0.6,0.5,2.5,0,3,0.4c-0.1,0.4-0.8,0.2-1.3,0.2c-2,0.5-4.3,0.1-6.6,0.1c-1.5,0-3.2,0.1-4.8,0.1 	c-6.2,0.1-12.3,0.3-19,0.6C38.4,10.3,38.5,10,38,10c-1.4-0.1-2.9,0.5-4.4,0.4c-1.2-0.1-2.8-0.5-3.9-0.3c0.2-0.4,1.4-0.2,1.8-0.1 	c3.5-0.6,7.5-0.3,10.8-0.3c1-0.4,2.8,0.1,3.7-0.5c0-0.1-0.1-0.1-0.1-0.2c-0.4-0.3-0.9,0.2-1.4,0.1c-0.3,0-0.1-0.3-0.3-0.4 	c-1,0.1-1.9-0.2-3.1,0c0,0.4,0.5,0,0.7,0.3c-0.9,0.1-2.6,0.6-2.7-0.4c0.1,0.1,0.5,0.2,0.2,0.4c0.5-0.1,0.9-0.1,1.4-0.2 	c-0.1-0.4-0.9,0-1.3,0c-0.1-0.2-0.4-0.2-0.5-0.4C35,8.2,30.5,8.7,26.2,7.9c2.2-0.3,5.2,0.1,7.6-0.4c0.5,0.7,1.7,0.2,2.5,0.3 	c-0.2-0.5-1.3-0.4-1.7-0.2c0.1-0.3-0.6-0.1-0.4-0.4c-1.6-0.1-3.3,0.7-4.7-0.3c0.5-0.3,1.3-0.2,2-0.3c-1.8-0.7-3.7-0.1-5.5-0.2 	c-0.4,0-0.9-0.3-1.4-0.3c-0.4,0-0.8,0.2-1.2,0.2c-0.8,0-1.6-0.5-2.5-0.4c0.1-0.4,0.7-0.2,1.2-0.2c1.4-0.4,2.9-0.1,4.3-0.3 	C27.8,5.4,29,4.6,30.3,5c0.2-0.2,0.5-0.4,0.9-0.4c0,0.2,0.2,0.3,0.6,0.3c0.1-0.2-0.2-0.2-0.3-0.3c0.3-0.3,0.6,0,0.9,0.1 	c0.2,0-0.1-0.3,0.3-0.3c0.4,0,0.3,0.2,0.4,0.3c1.5-0.3,3.3,0.3,4.5-0.3c0.4,0,0.6,0.1,0.9,0.2c0.2,0,0.2-0.3,0.4-0.4 	c3.3,0.3,6.7,0,10.1,0c-0.4-0.2-1.5,0-2.2-0.4c-0.5,0-2.2,0.3-2.5,0.2c-0.1,0-0.2-0.3-0.4-0.3c-0.9-0.1-1.5,0.5-2.7,0.3 	c-0.3,0-0.1-0.3-0.3-0.4c-0.9,0-2,0.1-3.4,0c-0.7,0-1.9-0.3-2.1,0c0,0,0.2,0.2,0.3,0.1c-0.3,0.1-0.8,0.1-1,0.2 	c0-0.3,0.3-0.3,0.1-0.5c-0.9,0.1-1.1-0.3-1.7-0.4c0-0.7,1.2,0,1.4-0.5c-0.8-0.3-2.6-0.6-3.5,0c-1.7-0.9-4,0-5.7-0.4 	c0.4-0.5,1.6-0.5,2.3-0.4c1.3-0.5,3,0.2,4.2-0.3c0.4,0.5,1.1,0.1,1.7,0.4c1.6-0.9,4,0.2,5.8-0.5c0.2,0.1,0.2,0.2,0.5,0.2 	c0.8-0.2,2,0,2.7-0.4c0.8,0.2,1.4-0.1,2,0.2c0.5-0.1,1-0.2,1.7-0.1c0.6-0.4,1.8-0.2,2.3-0.7c-0.4-0.3-0.9,0.2-1.5,0 	c-0.1-0.1,0-0.3-0.2-0.4c2.5-0.4,5.4,0,8.2-0.1c0.2,0.1,0.5,0.2,0.3,0.3c0.4,0,0.5-0.3,0.8-0.3c2.6-0.2,5.3,0.1,7.8,0.3 	c1.8,0.1,3.6-0.2,5.1,0.6c1.4,0.1,3.2,0,4.9,0.5c0.8,0.2,1.3,0.6,2.1,0.6c0.5,0,1.1-0.2,1.6-0.1c0.2,0.1,0.1,0.4,0.2,0.5 	c0.8,0.1,1.5-0.3,2.1,0c0,0.2-0.3,0.1-0.4,0.4C79.7,3,80,3.1,80.2,2.9C80.6,4.3,83.3,4,84,5.2c1.5,0.1,3.9,0.5,4,1.5 	c-0.6-0.2-1.5-0.8-2.2-0.4C85.9,6.9,87.3,7.1,87.2,7.6z M35.7,0.1c0.2,0-0.1,0.1,0.1,0.2c-0.2,0.1-0.6,0.2-0.8,0.2 	C34.2,0.5,34.6,0,35.7,0.1z M53.2,10.6c0.3-0.2,0.7-0.2,1.1-0.1c-0.1,0.4-0.9,0.1-1.3,0.2C53.2,10.6,53.4,10.6,53.2,10.6z M27.3,0.8 	c1.6-0.9,5.1-0.7,7.1-0.6c-1.3,0.6-3.4,1.1-5.2,0.6c0.1-0.2,0.5,0,0.7-0.2C28.9,0.2,28.1,1.3,27.3,0.8z"/></svg>
						<# } #>

						<# if ( settings.description_text_a ) { #>
							<div class="elementor-flip-box__layer__description">{{{ settings.description_text_a }}}</div>
						<# } #>
					</div>
				</div>
			</div>
			<{{ wrapperTag }} class="elementor-flip-box__layer elementor-flip-box__back">
				<div class="elementor-flip-box__layer__overlay">
					<div class="elementor-flip-box__layer__inner">

                        <# if ( settings.sub_title_text_b ) { #>
                        <span class="elementor-flip-box__layer__sub_title">{{{ settings.sub_title_text_b }}}</span>
                        <# } #>

						<# if ( settings.title_text_b ) { #>
							<h3 class="elementor-flip-box__layer__title">{{{ settings.title_text_b }}}</h3>
						<# } #>

						<# if ( settings.description_text_b ) { #>
							<div class="elementor-flip-box__layer__description">{{{ settings.description_text_b }}}</div>
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="88" height="11" x="0px" y="0px" viewBox="0 0 88 10.7" enable-background="new 0 0 88 10.7" xml:space="preserve"> <path fill-rule="evenodd" clip-rule="evenodd" d="M0.7,6.6C0.4,6.6,0.4,6.4,0,6.4C0,6.3,0.9,6.4,0.7,6.6z M0.4,5.9 	c0.3-0.3,0.6,0,1.1,0C1.3,6,0.9,6,0.4,5.9z M1.7,6.5c-0.3,0.1-0.6,0.1-0.9,0C1,6.3,1.4,6.5,1.7,6.5z M4.8,4.2c-0.5,0.1-1-0.1-1.6,0 	C3.5,3.9,4.4,4.2,4.8,4.2z M16.6,7.7C12.4,7.8,8.1,7.3,4.3,7c0-0.1,0.1-0.1,0.1-0.2C8.2,7.2,13,7.1,16.6,7.7z M5.5,5.5 	C5.4,5.4,5.3,5.3,5.1,5.2C5.8,5.1,6.2,5,6.8,5.1c0,0.4-0.6,0.2-0.7,0.2C7.1,5.9,8.5,5.6,10,5.8c-1.6,0.5-3.7-0.1-5.5,0 	c0-0.1,0-0.2,0-0.2C4.9,5.6,5.3,5.6,5.5,5.5z M7.9,5.2c0.3-0.1,0.8-0.2,1,0C8.7,5.4,8.1,5.5,7.9,5.2z M9.5,6.5 	c-0.2,0.2-1.1,0.3-1.3,0C8.5,6.1,9,6.4,9.5,6.5z M9.1,5.3c0-0.1,0-0.2,0-0.2c0.8,0.4,1.3-0.1,1.9,0.2C10.7,5.7,9.6,5.5,9.1,5.3z 	 M14.3,4.6c-0.6,0.2-1.4,0.2-2.4,0.1c0-0.1,0-0.2,0-0.2C12.7,4.5,13.6,4.4,14.3,4.6z M11.6,6.8c0.3-0.4,1.3-0.1,1.8,0 	C12.9,6.9,12.3,6.9,11.6,6.8z M11.9,5.6c0.3-0.4,0.7-0.3,1.4-0.1C12.9,5.8,12.6,5.6,11.9,5.6z M14.5,5.9c-1,0-1.7,0.4-2.6,0.2 	c0.2-0.3,0.8-0.2,1.4-0.2C14.6,5,17.1,5.7,19,5.5c-0.3,0.3-1.2,0.7-1.8,0.7C16.3,6.3,15.4,5.9,14.5,5.9z M14.5,0.3 	c0.1-0.3,0.5-0.1,0.8-0.1c-0.1,0.2,0.2,0.1,0.2,0.3c0,0.3-0.3,0.1-0.4,0.3C14.9,0.6,15,0.2,14.5,0.3z M16.6,9.4 	c-0.4,1-1.7-0.3-2.7-0.1C14.5,9.1,15.8,9.1,16.6,9.4z M19.2,7c-1.4,0.3-3.3,0.1-4.9-0.1c0.1-0.1,0.1-0.1,0.1-0.2 	C15.9,6.6,17.6,6.4,19.2,7z M15.1,4.7c0.3-0.1,0.6-0.2,1-0.1C16,4.9,15.1,5,15.1,4.7z M15.8,0.7c0.6-0.4,1.4-0.5,2.1-0.7 	C17.9,0.5,16.7,1,15.8,0.7z M17.2,4.8c0-0.1,0-0.2,0-0.2c0.2,0,0.3,0.1,0.4,0.1C17.5,4.9,17.4,4.9,17.2,4.8z M17.9,1.8 	c0.3,0,0.2-0.1,0.4,0.1C18.3,2.2,17.7,2.1,17.9,1.8z M18.4,0.2c0.2,0,0.2-0.1,0.4,0c0,0.1-0.1,0.1-0.1,0.1c0.1,0.1,0.3,0,0.2,0.4 	c0.1-0.1,0.4,0,0.6,0c-0.1,0.4-0.7,0.1-1.1,0.1C18.5,0.4,18.4,0.3,18.4,0.2z M21,4.8C20.2,5,18.7,5.1,18,4.7 	C18.9,4.4,20.2,4.5,21,4.8z M20.1,0.8c0-0.3-0.4-0.5-0.1-0.7c0.4,0.1,0.7,0,1,0.1c0.1,0.2-0.4,0.4-0.3,0.7 	C20.6,0.9,20.4,0.9,20.1,0.8z M22.1,9.5c0.1,0.3-0.7,0.5-1.1,0.2c-0.7,0.3-1.7,0.2-2.8,0.1C19,8.9,20.9,9.9,22.1,9.5z M20.5,2 	c0.3-0.1,0.5-0.2,0.9-0.2C21.6,2.1,20.7,2.2,20.5,2z M21.2,0.9c0.1-0.3,0.6-0.3,0.7-0.7c1,0.1,2.2,0,2.9,0.1 	c-0.2,0.3-1.1,0.2-0.9,0.6C23.2,0.6,22.3,0.9,21.2,0.9z M20.5,7.1c0.1-0.2,0.3-0.2,0.4-0.4c0.5,0.1,1,0.1,1.2,0.3 	C21.7,7.4,20.9,7.2,20.5,7.1z M21.6,4.8c0.4-0.1,1-0.4,1.4-0.2C22.7,4.9,22,5,21.6,4.8z M24.3,2.1c-0.5,0.1-1.3,0.1-1.9,0.1 	C22.3,1.8,23.9,1.7,24.3,2.1z M23.2,7.1c0.3-0.2,1-0.4,1.6-0.1C24.5,7.2,23.6,7.5,23.2,7.1z M24.4,9.9c-0.4,0.3-1.1,0-1.4-0.3 	C23.5,9.5,24.1,9.8,24.4,9.9z M25.3,0.7c0-0.1,0-0.1,0-0.2c0.1,0,0.1,0,0.1-0.1c0.1,0,0.1,0,0.2,0c0,0.1,0,0.1,0.1,0.1 	c0,0.1,0,0.1,0,0.2c-0.1,0-0.1,0-0.1,0.1C25.6,0.8,25.5,0.8,25.3,0.7C25.5,0.8,25.4,0.7,25.3,0.7z M25.8,0.5 	c-0.2-0.2,0.3-0.4,0.6-0.3C26.4,0.5,25.9,0.4,25.8,0.5z M24.9,7c0.9-0.5,2.9-0.2,4.2,0C28.7,7.5,27.4,7,27,7.4 	C26.3,7,25.4,7.5,24.9,7z M26.5,9.9c-0.6,0.4-1.6-0.1-2,0C25,9.5,26.1,9.9,26.5,9.9z M27.3,0.4c0-0.3,0.2-0.3,0.5-0.3 	C27.8,0.4,27.6,0.5,27.3,0.4z M28.4,2.8c0.5-0.5,1.6-0.1,2,0C30,3.3,28.8,2.7,28.4,2.8z M28.5,9.9c-0.2,0.2-0.7,0.3-0.8,0.1 	C27.8,9.8,28.3,9.8,28.5,9.9z M36.6,1.2c0.2-0.2,0.6-0.5,0.9-0.3C37.2,1,37,1.2,36.6,1.2z M37.8,0.5c0.1-0.1,0.1-0.1,0-0.2 	c0.1-0.1,0.4-0.1,0.6-0.1C38.4,0.5,38.1,0.5,37.8,0.5z M39.6,0.4c0.5-0.2,1.9-0.2,2.7,0c1.1-0.3,2.8-0.1,4.3,0 	c-0.9,0.7-2.6,1-4.2,0.6c0.1-0.3,0.7-0.1,0.9-0.3C42,0.1,40.7,0.8,39.6,0.4z M41.4,0.9c-0.1,0.2-0.4,0.2-0.7,0.1 	C40.7,0.6,41.3,0.7,41.4,0.9z M52,10.5c-0.1,0.1-0.1,0.1,0,0.2c-0.2,0.1-0.5,0.1-0.8,0C51.1,10.6,51.7,10.5,52,10.5z M64.6,10.1 	c0,0.4-0.3,0.1-0.6,0.1c-1.9,0.4-4.7,0.6-6.7,0.2c-0.8,0.2-1.7,0.4-2.8,0.3c0-0.1,0.1-0.1,0.1-0.2c0.8-0.1,1.9,0,2.5-0.3 	c0.3,0,0.5,0.1,0.8,0.1c1.8,0.1,4.3-0.3,5.9-0.3C64,9.9,64.9,9.9,64.6,10.1z M84.4,4.5c0-0.3-0.2-0.6,0-0.7c0.1,0.1,0.1,0.1,0.3,0.1 	C84.6,4.2,85,4.6,84.4,4.5z M7.2,6.4C7,6.5,6.8,6.5,6.6,6.4c0.1-0.2,0.4,0,0.4-0.2C7.2,6.3,7,6.3,7.2,6.4z M9.3,4.5 	c0.2-0.3,1,0.1,1.4,0C10.5,4.6,9.7,4.7,9.3,4.5z M12.8,9.3c-0.2,0.2-0.6,0-0.9-0.1c0.2-0.1,0.6-0.2,0.7,0c0.1,0,0.1,0,0.1-0.1 	C12.9,9.1,12.6,9.2,12.8,9.3z M19.5,6.1c0-0.2-0.2-0.2-0.1-0.4c0.2-0.1,0.7,0,0.9,0c-0.2,0.3,0.5,0.2,0.4,0.5 	C20.3,5.6,20.2,6.3,19.5,6.1z M25.7,4.7c0.4-0.5,1.2-0.1,1.7-0.1c0.2,0.1-0.6,0-0.7,0.2c-0.3,0-0.2-0.3-0.4-0.3 	C26.1,4.6,26.1,4.9,25.7,4.7z M87.2,7.6c-0.6,0.7-2.4,0-2.9,0.7c-5.2-0.2-9.2,0.1-14.5-0.2c-0.3,0.1,0.3,0.2,0.1,0.5 	c-0.7,0.2-1.9-0.1-2.5,0.1c0.6,0.5,2.5,0,3,0.4c-0.1,0.4-0.8,0.2-1.3,0.2c-2,0.5-4.3,0.1-6.6,0.1c-1.5,0-3.2,0.1-4.8,0.1 	c-6.2,0.1-12.3,0.3-19,0.6C38.4,10.3,38.5,10,38,10c-1.4-0.1-2.9,0.5-4.4,0.4c-1.2-0.1-2.8-0.5-3.9-0.3c0.2-0.4,1.4-0.2,1.8-0.1 	c3.5-0.6,7.5-0.3,10.8-0.3c1-0.4,2.8,0.1,3.7-0.5c0-0.1-0.1-0.1-0.1-0.2c-0.4-0.3-0.9,0.2-1.4,0.1c-0.3,0-0.1-0.3-0.3-0.4 	c-1,0.1-1.9-0.2-3.1,0c0,0.4,0.5,0,0.7,0.3c-0.9,0.1-2.6,0.6-2.7-0.4c0.1,0.1,0.5,0.2,0.2,0.4c0.5-0.1,0.9-0.1,1.4-0.2 	c-0.1-0.4-0.9,0-1.3,0c-0.1-0.2-0.4-0.2-0.5-0.4C35,8.2,30.5,8.7,26.2,7.9c2.2-0.3,5.2,0.1,7.6-0.4c0.5,0.7,1.7,0.2,2.5,0.3 	c-0.2-0.5-1.3-0.4-1.7-0.2c0.1-0.3-0.6-0.1-0.4-0.4c-1.6-0.1-3.3,0.7-4.7-0.3c0.5-0.3,1.3-0.2,2-0.3c-1.8-0.7-3.7-0.1-5.5-0.2 	c-0.4,0-0.9-0.3-1.4-0.3c-0.4,0-0.8,0.2-1.2,0.2c-0.8,0-1.6-0.5-2.5-0.4c0.1-0.4,0.7-0.2,1.2-0.2c1.4-0.4,2.9-0.1,4.3-0.3 	C27.8,5.4,29,4.6,30.3,5c0.2-0.2,0.5-0.4,0.9-0.4c0,0.2,0.2,0.3,0.6,0.3c0.1-0.2-0.2-0.2-0.3-0.3c0.3-0.3,0.6,0,0.9,0.1 	c0.2,0-0.1-0.3,0.3-0.3c0.4,0,0.3,0.2,0.4,0.3c1.5-0.3,3.3,0.3,4.5-0.3c0.4,0,0.6,0.1,0.9,0.2c0.2,0,0.2-0.3,0.4-0.4 	c3.3,0.3,6.7,0,10.1,0c-0.4-0.2-1.5,0-2.2-0.4c-0.5,0-2.2,0.3-2.5,0.2c-0.1,0-0.2-0.3-0.4-0.3c-0.9-0.1-1.5,0.5-2.7,0.3 	c-0.3,0-0.1-0.3-0.3-0.4c-0.9,0-2,0.1-3.4,0c-0.7,0-1.9-0.3-2.1,0c0,0,0.2,0.2,0.3,0.1c-0.3,0.1-0.8,0.1-1,0.2 	c0-0.3,0.3-0.3,0.1-0.5c-0.9,0.1-1.1-0.3-1.7-0.4c0-0.7,1.2,0,1.4-0.5c-0.8-0.3-2.6-0.6-3.5,0c-1.7-0.9-4,0-5.7-0.4 	c0.4-0.5,1.6-0.5,2.3-0.4c1.3-0.5,3,0.2,4.2-0.3c0.4,0.5,1.1,0.1,1.7,0.4c1.6-0.9,4,0.2,5.8-0.5c0.2,0.1,0.2,0.2,0.5,0.2 	c0.8-0.2,2,0,2.7-0.4c0.8,0.2,1.4-0.1,2,0.2c0.5-0.1,1-0.2,1.7-0.1c0.6-0.4,1.8-0.2,2.3-0.7c-0.4-0.3-0.9,0.2-1.5,0 	c-0.1-0.1,0-0.3-0.2-0.4c2.5-0.4,5.4,0,8.2-0.1c0.2,0.1,0.5,0.2,0.3,0.3c0.4,0,0.5-0.3,0.8-0.3c2.6-0.2,5.3,0.1,7.8,0.3 	c1.8,0.1,3.6-0.2,5.1,0.6c1.4,0.1,3.2,0,4.9,0.5c0.8,0.2,1.3,0.6,2.1,0.6c0.5,0,1.1-0.2,1.6-0.1c0.2,0.1,0.1,0.4,0.2,0.5 	c0.8,0.1,1.5-0.3,2.1,0c0,0.2-0.3,0.1-0.4,0.4C79.7,3,80,3.1,80.2,2.9C80.6,4.3,83.3,4,84,5.2c1.5,0.1,3.9,0.5,4,1.5 	c-0.6-0.2-1.5-0.8-2.2-0.4C85.9,6.9,87.3,7.1,87.2,7.6z M35.7,0.1c0.2,0-0.1,0.1,0.1,0.2c-0.2,0.1-0.6,0.2-0.8,0.2 	C34.2,0.5,34.6,0,35.7,0.1z M53.2,10.6c0.3-0.2,0.7-0.2,1.1-0.1c-0.1,0.4-0.9,0.1-1.3,0.2C53.2,10.6,53.4,10.6,53.2,10.6z M27.3,0.8 	c1.6-0.9,5.1-0.7,7.1-0.6c-1.3,0.6-3.4,1.1-5.2,0.6c0.1-0.2,0.5,0,0.7-0.2C28.9,0.2,28.1,1.3,27.3,0.8z"/></svg>
						<# } #>

						<# if ( settings.button_text ) { #>
							<{{ buttonTag }} href="#" class="{{ btnClasses }}">{{{ settings.button_text }}}</{{ buttonTag }}>
						<# } #>
					</div>
				</div>
			</{{ wrapperTag }}>
		</div>
		<?php
	}
}

$widgets_manager->register(new OSF_Elementor_Flip_Box());