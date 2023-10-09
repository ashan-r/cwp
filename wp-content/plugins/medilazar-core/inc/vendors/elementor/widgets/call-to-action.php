<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class OSF_Elementor_CallToAction extends Elementor\Widget_Base {


    public function get_name() {
        return 'call-to-action';
    }

    public function get_categories() {
        return ['opal-addons'];
    }


    public function get_title() {
        return __('Call to Action', 'medilazar-core');
    }

    public function get_icon() {
        return 'eicon-image-rollover';
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_main_image',
            [
                'label' => __('Image', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'skin',
            [
                'label'        => __('Skin', 'medilazar-core'),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    'classic' => __('Classic', 'medilazar-core'),
                    'cover'   => __('Cover', 'medilazar-core'),
                ],
                'render_type'  => 'template',
                'prefix_class' => 'elementor-cta--skin-',
                'default'      => 'classic',
            ]
        );

        $this->add_responsive_control(
            'layout',
            [
                'label'        => __('Layout', 'medilazar-core'),
                'type'         => Controls_Manager::CHOOSE,
                'label_block'  => false,
                'options'      => [
                    'left'  => [
                        'title' => __('Left', 'medilazar-core'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'above' => [
                        'title' => __('Above', 'medilazar-core'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'right' => [
                        'title' => __('Right', 'medilazar-core'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                    'below' => [
                        'title' => __('Below', 'medilazar-core'),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'prefix_class' => 'elementor-cta-%s-layout-image-',
                'condition'    => [
                    'skin!' => 'cover',
                ],
            ]
        );

        $this->add_control(
            'bg_image',
            [
                'label'      => __('Choose Image', 'medilazar-core'),
                'type'       => Controls_Manager::MEDIA,
                'default'    => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'show_label' => false,
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'bg_image', // Actually its `image_size`
                'label'     => __('Image Resolution', 'medilazar-core'),
                'default'   => 'large',
                'condition' => [
                    'bg_image[id]!' => '',
                ],
                'separator' => 'none',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'graphic_element',
            [
                'label'       => __('Graphic Element', 'medilazar-core'),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options'     => [
                    'none'  => [
                        'title' => __('None', 'medilazar-core'),
                        'icon'  => 'eicon-ban',
                    ],
                    'image' => [
                        'title' => __('Image', 'medilazar-core'),
                        'icon'  => 'eicon-image',
                    ],
                    'icon'  => [
                        'title' => __('Icon', 'medilazar-core'),
                        'icon'  => 'eicon-star',
                    ],
                ],
                'separator'   => 'before',
                'default'     => 'none',
            ]
        );

        $this->add_control(
            'graphic_image',
            [
                'label'      => __('Choose Image', 'medilazar-core'),
                'type'       => Controls_Manager::MEDIA,
                'default'    => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition'  => [
                    'graphic_element' => 'image',
                ],
                'show_label' => false,
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'graphic_image', // Actually its `image_size`
                'default'   => 'thumbnail',
                'condition' => [
                    'graphic_element'    => 'image',
                    'graphic_image[id]!' => '',
                ],
            ]
        );

        $this->add_control(
            'icon',
            [
                'label'     => __('Icon', 'medilazar-core'),
                'type'      => Controls_Manager::ICON,
                'default'   => 'fa fa-star',
                'condition' => [
                    'graphic_element' => 'icon',
                ],
            ]
        );

        $this->add_control(
            'icon_view',
            [
                'label'     => __('View', 'medilazar-core'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'default' => __('Default', 'medilazar-core'),
                    'stacked' => __('Stacked', 'medilazar-core'),
                    'framed'  => __('Framed', 'medilazar-core'),
                ],
                'default'   => 'default',
                'condition' => [
                    'graphic_element' => 'icon',
                ],
            ]
        );

        $this->add_control(
            'icon_shape',
            [
                'label'     => __('Shape', 'medilazar-core'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'circle' => __('Circle', 'medilazar-core'),
                    'square' => __('Square', 'medilazar-core'),
                ],
                'default'   => 'circle',
                'condition' => [
                    'icon_view!'      => 'default',
                    'graphic_element' => 'icon',
                ],
            ]
        );

        $this->add_control(
            'status_text',
            [
                'label'       => __('Status Text', 'medilazar-core'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __('Enter your text', 'medilazar-core'),
                'label_block' => true,
                'condition'   => [
                    'icon_view' => 'default'
                ],
                'separator'   => 'before'
            ]
        );

        $this->add_control(
            'title',
            [
                'label'       => __('Title & Description', 'medilazar-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('This is the heading', 'medilazar-core'),
                'placeholder' => __('Enter your title', 'medilazar-core'),
                'label_block' => true,
            ]
        );
        $this->add_responsive_control(
            'title_width',
            [
                'label'      => __('Max Width', 'medilazar-core'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 2000,
                    ],
                    '%'  => [
                        'min' => 1,
                        'max' => 100,
                    ]

                ],
                'size_units' => [
                    'px',
                    '%'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-cta__title' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'title!' => '',
                ],
            ]
        );

        $this->add_control(
            'title_reverse',
            [
                'label'        => __('Title Reverse', 'medilazar-core'),
                'type'         => Controls_Manager::SWITCHER,
                'prefix_class' => 'elementor-title-reverse-',
                'condition'    => [
                    'status_text!' => '',
                ],
            ]
        );

        $this->add_control(
            'description',
            [
                'label'       => __('Description', 'medilazar-core'),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => __('Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'medilazar-core'),
                'placeholder' => __('Enter your description', 'medilazar-core'),
                'separator'   => 'none',
                'rows'        => 5,
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label'     => __('Title HTML Tag', 'medilazar-core'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                ],
                'default'   => 'h2',
                'condition' => [
                    'title!' => '',
                ],
            ]
        );

        $this->add_control(
            'button',
            [
                'label'     => __('Button Text', 'medilazar-core'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Click Here', 'medilazar-core'),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'icon_cta',
            [
                'label'       => __('Icon', 'medilazar-core'),
                'type'        => Controls_Manager::ICON,
                'label_block' => true,
                'default'     => 'opal-icon-next',
            ]
        );


        $this->add_control(
            'link',
            [
                'label'       => __('Link', 'medilazar-core'),
                'type'        => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'medilazar-core'),

            ]
        );

        $this->add_control(
            'link_click',
            [
                'label'     => __('Apply Link On', 'medilazar-core'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'box'    => __('Whole Box', 'medilazar-core'),
                    'button' => __('Button Only', 'medilazar-core'),
                ],
                'default'   => 'button',
                'separator' => 'none',
                'condition' => [
                    'link[url]!' => '',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_ribbon',
            [
                'label' => __('Ribbon', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'ribbon_title',
            [
                'label' => __('Title', 'medilazar-core'),
                'type'  => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'ribbon_horizontal_position',
            [
                'label'       => __('Horizontal Position', 'medilazar-core'),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options'     => [
                    'left'  => [
                        'title' => __('Left', 'medilazar-core'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __('Right', 'medilazar-core'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'condition'   => [
                    'ribbon_title!' => '',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'wrapper_style',
            [
                'label' => __('Wrapper', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_wrapper_style');

        $this->start_controls_tab(
            'tab_wrapper_normal',
            [
                'label' => __('Normal', 'medilazar-core'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'background_wrapper',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .elementor-cta',
            ]
        );


        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'wrapper_box_shadow',
                'selector' => '{{WRAPPER}} .elementor-cta',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_wrapper_hover',
            [
                'label' => __('Hover', 'medilazar-core'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'background_wrapper_hover',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .elementor-cta:hover',
            ]
        );


        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'wrapper_box_shadow_hover',
                'selector' => '{{WRAPPER}} .elementor-cta:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label'      => __('Padding', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'wrapper_border',
                'selector' => '{{WRAPPER}} .elementor-cta',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label'      => __('Border Radius', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wrapper_transformation',
            [
                'label'        => __('Hover Animation', 'medilazar-core'),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    'none'      => 'None',
                    'move-up'   => 'Move Up',
                    'move-down' => 'Move Down',
                ],
                'default'      => 'none',
                'prefix_class' => 'call-to-action-wrapper-transform-',
                'separator'    => 'before',
            ]
        );

        $this->add_control(
            'wrapper_effect_duration',
            [
                'label'     => __('Effect Duration', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 500,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 3000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta' => 'transition-duration: {{SIZE}}ms',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'box_style',
            [
                'label' => __('Box', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_responsive_control(
            'min-height',
            [
                'label'      => __('Min. Height', 'medilazar-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'vh'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-cta__content' => 'min-height: {{SIZE}}{{UNIT}}',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_responsive_control(
            'min-height-hover',
            [
                'label'      => __('Min. Height Hover', 'medilazar-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'vh'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-cta:hover .elementor-cta__content' => 'min-height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label'       => __('Alignment', 'medilazar-core'),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options'     => [
                    'left'   => [
                        'title' => __('Left', 'medilazar-core'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'medilazar-core'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'medilazar-core'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default'     => 'center',
                'selectors'   => [
                    '{{WRAPPER}} .elementor-cta__content' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'vertical_position',
            [
                'label'        => __('Vertical Position', 'medilazar-core'),
                'type'         => Controls_Manager::CHOOSE,
                'label_block'  => false,
                'options'      => [
                    'top'    => [
                        'title' => __('Top', 'medilazar-core'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'middle' => [
                        'title' => __('Middle', 'medilazar-core'),
                        'icon'  => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => __('Bottom', 'medilazar-core'),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'prefix_class' => 'elementor-cta--valign-',
                'separator'    => 'none',
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label'      => __('Padding', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-cta__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'heading_bg_image_style',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => __('Image', 'medilazar-core'),
                'condition' => [
                    'bg_image[url]!' => '',
                    'skin'           => 'classic',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'image_min_width',
            [
                'label'      => __('Min. Width', 'medilazar-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-cta__bg-wrapper' => 'min-width: {{SIZE}}{{UNIT}}',
                ],
                'condition'  => [
                    'skin' => 'classic',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_responsive_control(
            'image_min_height',
            [
                'label'      => __('Min. Height', 'medilazar-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'vh'],

                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__bg-wrapper' => 'min-height: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'skin' => 'classic',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'graphic_element_style',
            [
                'label'     => __('Graphic Element', 'medilazar-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'graphic_element!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'graphic_image_spacing',
            [
                'label'     => __('Spacing', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'graphic_element' => 'image',
                ],
            ]
        );

        $this->add_control(
            'graphic_image_width',
            [
                'label'      => __('Size (%)', 'medilazar-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'default'    => [
                    'unit' => '%',
                ],
                'range'      => [
                    '%' => [
                        'min' => 5,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-cta__image img' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition'  => [
                    'graphic_element' => 'image',
                ],
            ]
        );

        $this->add_control(
            'graphic_image_opacity',
            [
                'label'     => __('Opacity', 'medilazar-core'),
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
                    '{{WRAPPER}} .elementor-cta__image' => 'opacity: {{SIZE}};',
                ],
                'condition' => [
                    'graphic_element' => 'image',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'graphic_image_border',
                'selector'  => '{{WRAPPER}} .elementor-cta__image img',
                'condition' => [
                    'graphic_element' => 'image',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'graphic_image_border_radius',
            [
                'label'     => __('Border Radius', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__image img' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'graphic_element' => 'image',
                ],
            ]
        );

        $this->add_control(
            'icon_spacing',
            [
                'label'     => __('Spacing', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
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
                'label'     => __('Primary Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-view-stacked .elementor-icon'                                                     => 'background-color: {{VALUE}}',
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
                'label'     => __('Secondary Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'condition' => [
                    'graphic_element' => 'icon',
                    'icon_view!'      => 'default',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-view-framed .elementor-icon'  => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-view-stacked .elementor-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label'     => __('Icon Size', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
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
                'label'     => __('Icon Padding', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
                ],
                'range'     => [
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                ],
                'condition' => [
                    'graphic_element' => 'icon',
                    'icon_view!'      => 'default',
                ],
            ]
        );

        $this->add_control(
            'icon_border_width',
            [
                'label'     => __('Border Width', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'border-width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'graphic_element' => 'icon',
                    'icon_view'       => 'framed',
                ],
            ]
        );

        $this->add_control(
            'icon_border_radius',
            [
                'label'      => __('Border Radius', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'graphic_element' => 'icon',
                    'icon_view!'      => 'default',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_style',
            [
                'label'      => __('Content', 'medilazar-core'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'or',
                    'terms'    => [
                        [
                            'name'     => 'title',
                            'operator' => '!==',
                            'value'    => '',
                        ],
                        [
                            'name'     => 'description',
                            'operator' => '!==',
                            'value'    => '',
                        ],
                        [
                            'name'     => 'button',
                            'operator' => '!==',
                            'value'    => '',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'style_status_text',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => __('Status Text', 'medilazar-core'),
                'separator' => 'before',
                'condition' => [
                    'status_text!' => '',
                    'icon_view'    => 'default'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'status_text_typography',
                'selector'  => '{{WRAPPER}} .elementor-cta__status-text',
                'condition' => [
                    'status_text!' => '',
                    'icon_view'    => 'default'
                ]
            ]
        );

        $this->add_control(
            'status_animated_bg_text',
            [
                'label'        => __('Status Animated BG Text', 'medilazar-core'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'prefix_class' => 'elementor-animated-bg-text-',
                'condition'    => [
                    'status_text!' => '',
                ],
            ]
        );


        $this->add_responsive_control(
            'status_text_spacing',
            [
                'label'     => __('Spacing', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__status-text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'status_text!' => '',
                    'icon_view'    => 'default'
                ]
            ]
        );

        $this->add_control(
            'heading_style_title',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => __('Title', 'medilazar-core'),
                'separator' => 'before',
                'condition' => [
                    'title!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'title_typography',
                'selector'  => '{{WRAPPER}} .elementor-cta__title',
                'condition' => [
                    'title!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label'     => __('Spacing', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__title:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'title!' => '',
                ],
            ]
        );

        $this->add_control(
            'heading_style_description',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => __('Description', 'medilazar-core'),
                'separator' => 'before',
                'condition' => [
                    'description!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'description_typography',
                'selector'  => '{{WRAPPER}} .elementor-cta__description',
                'condition' => [
                    'description!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'description_spacing',
            [
                'label'     => __('Spacing', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__description:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'description!' => '',
                ],
            ]
        );

        $this->add_control(
            'heading_content_colors',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => __('Colors', 'medilazar-core'),
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('color_tabs');

        $this->start_controls_tab('colors_normal',
            [
                'label' => __('Normal', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'content_bg_color',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__content' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'skin' => 'classic',
                ],
            ]
        );

        $this->add_control(
            'status_text_color',
            [
                'label'     => __('Status text Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__status-text' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'status_text!' => '',
                    'icon_view'    => 'default'
                ]
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Title Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'title!' => '',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => __('Description Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__description' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'description!' => '',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label'     => __('Button Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__button' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                ],
                'condition' => [
                    'button!' => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'colors_hover',
            [
                'label' => __('Hover', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'content_bg_color_hover',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta:hover .elementor-cta__content' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'skin' => 'classic',
                ],
            ]
        );

        $this->add_control(
            'status_text_color_hover',
            [
                'label'     => __('Status text Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta:hover .elementor-cta__status-text' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'status_text!' => '',
                    'icon_view'    => 'default'
                ]
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label'     => __('Title Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta .elementor-cta__title:before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .elementor-cta:hover .elementor-cta__title'  => 'color: transparent',
                ],
                'condition' => [
                    'title!' => '',
                ],
            ]
        );

        $this->add_control(
            'description_color_hover',
            [
                'label'     => __('Description Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta:hover .elementor-cta__description' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'description!' => '',
                ],
            ]
        );

        $this->add_control(
            'button_color_hover',
            [
                'label'     => __('Button Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta:hover .elementor-cta__button' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                ],
                'condition' => [
                    'button!' => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        //button

        $this->start_controls_section(
            'button_style',
            [
                'label'     => __('Button', 'medilazar-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'button!' => '',
                ],
            ]
        );

        $this->add_control(
            'button_size',
            [
                'label'   => __('Size', 'medilazar-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'sm',
                'options' => [
                    'xs' => __('Extra Small', 'medilazar-core'),
                    'sm' => __('Small', 'medilazar-core'),
                    'md' => __('Medium', 'medilazar-core'),
                    'lg' => __('Large', 'medilazar-core'),
                    'xl' => __('Extra Large', 'medilazar-core'),
                ],
            ]
        );
        $this->add_control(
            'button_type',
            [
                'label'        => __('Type', 'medilazar-core'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'link',
                'options'      => [
                    'primary'           => __('Primary', 'medilazar-core'),
                    'secondary'         => __('Secondary', 'medilazar-core'),
                    'dark'              => __('Dark', 'medilazar-core'),
                    'light'             => __('Light', 'medilazar-core'),
                    'link'              => __('Link', 'medilazar-core'),
                    'outline_primary'   => __('Outline Primary', 'medilazar-core'),
                    'outline_secondary' => __('Outline Secondary', 'medilazar-core'),
                    'outline_dark'      => __('Outline Dark', 'medilazar-core'),
                    'info'              => __('Info', 'medilazar-core'),
                    'success'           => __('Success', 'medilazar-core'),
                    'warning'           => __('Warning', 'medilazar-core'),
                    'danger'            => __('Danger', 'medilazar-core'),
                ],
                'prefix_class' => 'elementor-button-',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography',
                'label'    => __('Typography', 'medilazar-core'),
                'selector' => '{{WRAPPER}} .elementor-cta__button',
            ]
        );

        $this->start_controls_tabs('button_tabs');

        $this->start_controls_tab('button_normal',
            [
                'label' => __('Normal', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label'     => __('Text Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__button:not(:hover)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__button:not(:hover)' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_color_style',
            [
                'label'     => __('Border Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__button:not(:hover)' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button-hover',
            [
                'label' => __('Hover', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'button_hover_text_color',
            [
                'label'     => __('Text Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background_color',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label'     => __('Border Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__button:hover' => 'border-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'button_border',
                'selector'  => '{{WRAPPER}} .elementor-cta__button',
                'separator' => 'before',
            ]);

        $this->add_control(
            'button_border_radius',
            [
                'label'     => __('Border Radius', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__button' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => __('Padding', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-cta__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_style',
            [
                'label'     => __('Icon Button', 'medilazar-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'icon!' => '',
                ]
            ]
        );


        $this->add_control(
            'icon_align',
            [
                'label'     => __('Position', 'medilazar-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'left',
                'options'   => [
                    'left'  => __('Before', 'medilazar-core'),
                    'right' => __('After', 'medilazar-core'),
                ],
                'condition' => [
                    'icon_cta!' => '',
                ],
            ]
        );

        $this->add_control(
            'icon_size_cta',
            [
                'label'     => __('Size', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'default'   => [
                    'size' => 14,
                ],
                'condition' => [
                    'icon!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button .elementor-button-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_indent',
            [
                'label'     => __('Spacing', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'default'   => [
                    'size' => 15,
                ],
                'condition' => [
                    'icon!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-button .elementor-align-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_icon_style');

        $this->start_controls_tab(
            'tab_icon_normal',
            [
                'label' => __('Normal', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'button_icon_color',
            [
                'label'     => __('Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button .elementor-button-icon, {{WRAPPER}} .elementor-button .elementor-button-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'button_icon_bgcolor',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button .elementor-button-icon, {{WRAPPER}} .elementor-button .elementor-button-icon' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            [
                'label' => __('Hover', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'button_icon_hover_color',
            [
                'label'     => __('Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button:hover .elementor-button-icon, {{WRAPPER}} .elementor-button:hover .elementor-button-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'button_icon_hover_bgcolor',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button:hover .elementor-button-icon, {{WRAPPER}} .elementor-button:hover .elementor-button-icon' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon-rotate',
            [
                'label'     => __('Icon Rotate', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover .elementor-button-icon' => 'transform: rotate({{SIZE}}deg);',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_ribbon_style',
            [
                'label'      => __('Ribbon', 'medilazar-core'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
                'condition'  => [
                    'ribbon_title!' => '',
                ],
            ]
        );

        $this->add_control(
            'ribbon_bg_color',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-ribbon-inner' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ribbon_text_color',
            [
                'label'     => __('Text Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-ribbon-inner' => 'color: {{VALUE}}',
                ],
            ]
        );

        $ribbon_distance_transform = is_rtl() ? 'translateY(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg)' : 'translateY(-50%) translateX(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg)';

        $this->add_responsive_control(
            'ribbon_distance',
            [
                'label'     => __('Distance', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-ribbon-inner' => 'margin-top: {{SIZE}}{{UNIT}}; transform: ' . $ribbon_distance_transform,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'ribbon_typography',
                'selector' => '{{WRAPPER}} .elementor-ribbon-inner',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'box_shadow',
                'selector' => '{{WRAPPER}} .elementor-ribbon-inner',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'img_hover_effects',
            [
                'label' => __('Image Hover Effects', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_hover_heading',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => __('Content', 'medilazar-core'),
                'separator' => 'before',
                'condition' => [
                    'skin' => 'cover',
                ],
            ]
        );

        $this->add_control(
            'content_animation',
            [
                'label'        => __('Hover Animation', 'medilazar-core'),
                'type'         => Controls_Manager::SELECT,
                'groups'       => [
                    [
                        'label'   => __('None', 'medilazar-core'),
                        'options' => [
                            '' => __('None', 'medilazar-core'),
                        ],
                    ],
                    [
                        'label'   => __('Entrance', 'medilazar-core'),
                        'options' => [
                            'enter-from-right'  => 'Slide In Right',
                            'enter-from-left'   => 'Slide In Left',
                            'enter-from-top'    => 'Slide In Up',
                            'enter-from-bottom' => 'Slide In Down',
                            'enter-zoom-in'     => 'Zoom In',
                            'enter-zoom-out'    => 'Zoom Out',
                            'fade-in'           => 'Fade In',
                        ],
                    ],
                    [
                        'label'   => __('Reaction', 'medilazar-core'),
                        'options' => [
                            'grow'       => 'Grow',
                            'shrink'     => 'Shrink',
                            'move-right' => 'Move Right',
                            'move-left'  => 'Move Left',
                            'move-up'    => 'Move Up',
                            'move-down'  => 'Move Down',
                        ],
                    ],
                    [
                        'label'   => __('Exit', 'medilazar-core'),
                        'options' => [
                            'exit-to-right'  => 'Slide Out Right',
                            'exit-to-left'   => 'Slide Out Left',
                            'exit-to-top'    => 'Slide Out Up',
                            'exit-to-bottom' => 'Slide Out Down',
                            'exit-zoom-in'   => 'Zoom In',
                            'exit-zoom-out'  => 'Zoom Out',
                            'fade-out'       => 'Fade Out',
                        ],
                    ],
                ],
                'default'      => 'grow',
                'prefix_class' => 'content_animation-',
                'condition'    => [
                    'skin' => 'cover',
                ],
            ]
        );

        /*
         *
         * Add class 'elementor-animated-content' to widget when assigned content animation
         *
         */
        $this->add_control(
            'animation_class',
            [
                'label'        => 'Animation',
                'type'         => Controls_Manager::HIDDEN,
                'default'      => 'animated-content',
                'prefix_class' => 'elementor-',
                'condition'    => [
                    'content_animation!' => '',
                ],
            ]
        );

        $this->add_control(
            'content_animation_duration',
            [
                'label'       => __('Animation Duration', 'medilazar-core'),
                'type'        => Controls_Manager::SLIDER,
                'render_type' => 'template',
                'default'     => [
                    'size' => 1000,
                ],
                'range'       => [
                    'px' => [
                        'min' => 0,
                        'max' => 3000,
                    ],
                ],
                'selectors'   => [
                    '{{WRAPPER}} .elementor-cta__content-item'                                                 => 'transition-duration: 500ms',
                    '{{WRAPPER}}.elementor-cta--sequenced-animation .elementor-cta__content-item:nth-child(2)' => 'transition-delay: calc( {{SIZE}}ms / 3 )',
                    '{{WRAPPER}}.elementor-cta--sequenced-animation .elementor-cta__content-item:nth-child(3)' => 'transition-delay: calc( ( {{SIZE}}ms / 3 ) * 2 )',
                    '{{WRAPPER}}.elementor-cta--sequenced-animation .elementor-cta__content-item:nth-child(4)' => 'transition-delay: calc( ( {{SIZE}}ms / 3 ) * 3 )',
                ],
                'condition'   => [
                    'content_animation!' => '',
                    'skin'               => 'cover',
                ],
            ]
        );

        $this->add_control(
            'sequenced_animation',
            [
                'label'        => __('Sequenced Animation', 'medilazar-core'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('On', 'medilazar-core'),
                'label_off'    => __('Off', 'medilazar-core'),
                'return_value' => 'elementor-cta--sequenced-animation',
                'prefix_class' => '',
                'condition'    => [
                    'content_animation!' => '',
                ],
            ]
        );

        $this->add_control(
            'background_hover_heading',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => __('Background', 'medilazar-core'),
                'separator' => 'before',
                'condition' => [
                    'skin' => 'cover',
                ],
            ]
        );

        $this->add_control(
            'transformation',
            [
                'label'        => __('Hover Animation', 'medilazar-core'),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    ''           => 'None',
                    'zoom-in'    => 'Zoom In',
                    'zoom-out'   => 'Zoom Out',
                    'move-left'  => 'Move Left',
                    'move-right' => 'Move Right',
                    'move-up'    => 'Move Up',
                    'move-down'  => 'Move Down',
                ],
                'default'      => 'zoom-in',
                'prefix_class' => 'elementor-bg-transform elementor-bg-transform-',
            ]
        );

        $this->start_controls_tabs('bg_effects_tabs');

        $this->start_controls_tab('normal',
            [
                'label' => __('Normal', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'overlay_color',
            [
                'label'     => __('Overlay Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta:not(:hover) .elementor-cta__bg-overlay' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'overlay_blend_mode',
            [
                'label'     => __('Blend Mode', 'medilazar-core'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    ''            => __('Normal', 'medilazar-core'),
                    'multiply'    => 'Multiply',
                    'screen'      => 'Screen',
                    'overlay'     => 'Overlay',
                    'darken'      => 'Darken',
                    'lighten'     => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation'  => 'Saturation',
                    'color'       => 'Color',
                    'luminosity'  => 'Luminosity',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta__bg-overlay' => 'mix-blend-mode: {{VALUE}}',
                ],
                'separator' => 'none',
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab('hover',
            [
                'label' => __('Hover', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'overlay_color_hover',
            [
                'label'     => __('Overlay Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cta:hover .elementor-cta__bg-overlay' => 'background-color: {{VALUE}}',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'effect_duration',
            [
                'label'       => __('Effect Duration', 'medilazar-core'),
                'type'        => Controls_Manager::SLIDER,
                'render_type' => 'template',
                'default'     => [
                    'size' => 500,
                ],
                'range'       => [
                    'px' => [
                        'min' => 0,
                        'max' => 3000,
                    ],
                ],
                'selectors'   => [
                    '{{WRAPPER}} .elementor-cta .elementor-cta__bg, {{WRAPPER}} .elementor-cta .elementor-cta__bg-overlay' => 'transition-duration: {{SIZE}}ms',
                ],
                'separator'   => 'before',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings          = $this->get_settings();
        $title_tag         = $settings['title_tag'];
        $wrapper_tag       = 'div';
        $button_tag        = 'a';
        $link_url          = empty($settings['link']['url']) ? false : $settings['link']['url'];
        $bg_image          = '';
        $content_animation = $settings['content_animation'];
        $animation_class   = '';
        $print_bg          = true;
        $print_content     = true;

        if (!empty($settings['bg_image']['id'])) {
            $bg_image = Group_Control_Image_Size::get_attachment_image_src($settings['bg_image']['id'], 'bg_image', $settings);
        } elseif (!empty($settings['bg_image']['url'])) {
            $bg_image = $settings['bg_image']['url'];
        }

        if (empty($bg_image) && 'classic' == $settings['skin']) {
            $print_bg = false;
        }

        if (empty($settings['title']) && empty($settings['description']) && empty($settings['status_text']) && empty($settings['button']) && 'none' == $settings['graphic_element']) {
            $print_content = false;
        }
        $this->add_render_attribute('wrapper', 'class', [
            'elementor-cta',
        ]);
        $this->add_render_attribute('background_image', 'style', [
            'background-image: url(' . $bg_image . ');',
        ]);

        $this->add_render_attribute('title', 'class', [
            'elementor-cta__title',
            'elementor-cta__content-item',
            'elementor-content-item',
        ]);
        $this->add_render_attribute('title', 'data-letter', [
            strip_tags($settings['title']),
        ]);

        $this->add_render_attribute('description', 'class', [
            'elementor-cta__description',
            'elementor-cta__content-item',
            'elementor-content-item',
        ]);

        $this->add_render_attribute('button', 'class', [
            'elementor-cta__button',
            'elementor-button',
            'elementor-size-' . $settings['button_size'],
        ]);

        $this->add_render_attribute('graphic_element', 'class',
            [
                'elementor-content-item',
                'elementor-cta__content-item',
            ]
        );

        $this->add_render_attribute('icon-align', 'class',
            [
                'elementor-button-icon',
                'elementor-align-icon-' . $settings['icon_align'],
            ]
        );

        if ('icon' === $settings['graphic_element']) {
            $this->add_render_attribute('graphic_element', 'class',
                [
                    'elementor-icon-wrapper',
                    'elementor-cta__icon',
                ]
            );
            $this->add_render_attribute('graphic_element', 'class', 'elementor-view-' . $settings['icon_view']);
            if ('default' != $settings['icon_view']) {
                $this->add_render_attribute('graphic_element', 'class', 'elementor-shape-' . $settings['icon_shape']);
            }
            if (!empty($settings['icon'])) {
                $this->add_render_attribute('icon', 'class', $settings['icon']);
            }
        } elseif ('image' === $settings['graphic_element'] && !empty($settings['graphic_image']['url'])) {
            $this->add_render_attribute('graphic_element', 'class', 'elementor-cta__image');
        }

        if (!empty($content_animation) && 'cover' == $settings['skin']) {

            $animation_class = 'elementor-animated-item--' . $content_animation;

            $this->add_render_attribute('title', 'class', $animation_class);

            $this->add_render_attribute('graphic_element', 'class', $animation_class);

            $this->add_render_attribute('description', 'class', $animation_class);

        }
        $wrapper_tag = 'div';
        if (!empty($link_url)) {

            if ('box' === $settings['link_click']) {
                $wrapper_tag = 'a';
                $button_tag  = 'button';
                $this->add_render_attribute('link-box', 'class', 'link-box');
                $this->add_render_attribute('link-box', 'href', $link_url);

                if ($settings['link']['is_external']) {
                    $this->add_render_attribute('link-box', 'target', '_blank');
                }
            } else {
                $this->add_render_attribute('button', 'href', $link_url);
                if ($settings['link']['is_external']) {
                    $this->add_render_attribute('button', 'target', '_blank');
                }
            }
        }

        $this->add_inline_editing_attributes('title');
        $this->add_inline_editing_attributes('description');
        $this->add_inline_editing_attributes('button');

        ?>
    <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>

        <?php if ($print_bg) : ?>
            <div class="elementor-cta__bg-wrapper">
                <?php if ('box' === $settings['link_click']): ?>
                    <a <?php echo $this->get_render_attribute_string('link-box'); ?>></a>
                <?php endif; ?>
                <div class="elementor-cta__bg elementor-bg" <?php echo $this->get_render_attribute_string('background_image'); ?>></div>
                <div class="elementor-cta__bg-overlay"></div>
            </div>
        <?php endif; ?>
        <?php if ($print_content) : ?>
            <div class="elementor-cta__content">

            <?php if ('box' === $settings['link_click']): ?>
                <a <?php echo $this->get_render_attribute_string('link-box'); ?>></a>
            <?php endif; ?>

            <?php if ('image' === $settings['graphic_element'] && !empty($settings['graphic_image']['url'])) : ?>
                <div <?php echo $this->get_render_attribute_string('graphic_element'); ?>>
                    <?php echo Group_Control_Image_Size::get_attachment_image_html($settings, 'graphic_image'); ?>
                </div>
            <?php elseif ('icon' === $settings['graphic_element'] && !empty($settings['icon'])) : ?>
                <div <?php echo $this->get_render_attribute_string('graphic_element'); ?>>
                    <div class="elementor-icon">
                        <i <?php echo $this->get_render_attribute_string('icon'); ?>></i>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($settings['status_text']): ?>
                <div class="elementor-cta__status-text elementor-cta__content-item">
                    <span><?php echo $settings['status_text']; ?></span>
                </div>
            <?php endif; ?>

            <?php if (!empty($settings['title'])) : ?>
                <<?php echo $title_tag . ' ' . $this->get_render_attribute_string('title'); ?>>
                <?php echo $settings['title']; ?>
                </<?php echo $title_tag; ?>>
            <?php endif; ?>

            <?php if (!empty($settings['description'])) : ?>
                <div <?php echo $this->get_render_attribute_string('description'); ?>>
                    <?php echo $settings['description']; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($settings['button'])) : ?>
            <div class="elementor-cta__button-wrapper elementor-cta__content-item elementor-content-item <?php echo $animation_class; ?>">
                <<?php echo $button_tag . ' ' . $this->get_render_attribute_string('button'); ?>>
                <?php if (!empty($settings['icon_cta'])) : ?>
                    <span <?php echo $this->get_render_attribute_string('icon-align'); ?>>
                                <i class="<?php echo esc_attr($settings['icon_cta']); ?>" aria-hidden="true"></i>
                            </span>
                <?php endif; ?>
                <span><?php echo $settings['button']; ?></span>
                </<?php echo $button_tag; ?>>
                </div>
            <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($settings['ribbon_title'])) :
            $this->add_render_attribute('ribbon-wrapper', 'class', 'elementor-ribbon');

            if (!empty($settings['ribbon_horizontal_position'])) {
                $this->add_render_attribute('ribbon-wrapper', 'class', 'elementor-ribbon-' . $settings['ribbon_horizontal_position']);
            } ?>
            <div <?php echo $this->get_render_attribute_string('ribbon-wrapper'); ?>>
                <div class="elementor-ribbon-inner"><?php echo $settings['ribbon_title']; ?></div>
            </div>
        <?php endif; ?>
        </div>
        <?php
    }
}

$widgets_manager->register(new OSF_Elementor_CallToAction());