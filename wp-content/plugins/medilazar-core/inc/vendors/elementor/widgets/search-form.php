<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class OSF_Elementor_Search_Form extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-search-form';
    }

    public function get_title() {
        return __('Opal Search Form', 'medilazar-core');
    }

    public function get_icon() {
        return 'eicon-site-search';
    }

    public function get_categories() {
        return ['opal-addons'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'search_content',
            [
                'label' => __('Search Form', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'skin',
            [
                'label'              => __('Skin', 'medilazar-core'),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'classic',
                'options'            => [
                    'classic'     => __('Classic', 'medilazar-core'),
                    'minimal'     => __('Minimal', 'medilazar-core'),
                    'full_screen' => __('Full Screen', 'medilazar-core'),
                ],
                'prefix_class'       => 'elementor-search-form--skin-',
                'render_type'        => 'template',
                'frontend_available' => true,
            ]
        );


        $this->add_control(
            'placeholder',
            [
                'label'   => __('Placeholder', 'medilazar-core'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Search', 'medilazar-core') . '...',
            ]
        );

        $this->add_control(
            'hide_search',
            [
                'label'        => esc_html__('Hide filter categories', 'medilazar-core'),
                'type'         => Controls_Manager::SWITCHER,
                'condition' => [
                    'skin!' => [
                        'full_screen',
                    ],
                ],
                'prefix_class' => 'search-form-hide-search-',
            ]
        );

        $this->add_control(
            'heading_button_content',
            [
                'label'     => __('Button', 'medilazar-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'skin' => 'classic',
                ],
            ]
        );


        $this->add_control(
            'button_type',
            [
                'label'        => __('Type', 'medilazar-core'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'icon',
                'options'      => [
                    'icon'      => __('Icon', 'medilazar-core'),
                    'text'      => __('Text', 'medilazar-core'),
                    'text_icon' => __('Text & Icon', 'medilazar-core'),
                ],
                'prefix_class' => 'elementor-search-form--button-type-',
                'render_type'  => 'template',
                'condition'    => [
                    'skin' => 'classic',
                ],
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'     => __('Text', 'medilazar-core'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Search', 'medilazar-core'),
                'condition' => [
                    'button_type!' => 'icon',
                    'skin'         => 'classic',
                ],
            ]
        );

        $this->add_control(
            'size_minimal',
            [
                'label'     => __('Size', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__container'                                                                                 => 'min-height: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .elementor-search-form__submit'                                                                                    => 'min-width: {{SIZE}}{{UNIT}}',
                    'body:not(.rtl) {{WRAPPER}} .elementor-search-form__icon'                                                                       => 'padding-left: calc({{SIZE}}{{UNIT}} / 3)',
                    'body.rtl {{WRAPPER}} .elementor-search-form__icon'                                                                             => 'padding-right: calc({{SIZE}}{{UNIT}} / 3)',
                    '{{WRAPPER}} .elementor-search-form__input, {{WRAPPER}}.elementor-search-form--button-type-text .elementor-search-form__submit' => 'padding-left: calc({{SIZE}}{{UNIT}} / 3); padding-right: calc({{SIZE}}{{UNIT}} / 3)',
                ],
                'separator' => 'before',
                'condition' => [
                    'skin' => 'minimal',
                ],
            ]
        );

        $this->add_control(
            'toggle_button_content',
            [
                'label'     => __('Toggle', 'medilazar-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'skin' => 'full_screen',
                ],
            ]
        );

        $this->add_control(
            'icon_skin',
            [
                'label'     => __('Choose Icon', 'medilazar-core'),
                'type'      => Controls_Manager::ICON,
                'default'   => 'opal-icon-search',
                'condition' => [
                    'button_type!' => 'text',
                ],
            ]
        );

        $this->add_control(
            'toggle_align',
            [
                'label'       => __('Alignment', 'medilazar-core'),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default'     => 'center',
                'options'     => [
                    'flex-start' => [
                        'title' => __('Left', 'medilazar-core'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center'     => [
                        'title' => __('Center', 'medilazar-core'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'flex-end'   => [
                        'title' => __('Right', 'medilazar-core'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'selectors'   => [
                    '{{WRAPPER}} .elementor-search-form__toggle' => 'display: flex; justify-content: {{VALUE}}',
                ],
                'condition'   => [
                    'skin' => 'full_screen',
                ],
            ]
        );

        $this->add_control(
            'toggle_size',
            [
                'label'     => __('Size', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 33,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle i' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'skin' => 'full_screen',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_wrapper_style',
            [
                'label'     => __('Wrapper', 'medilazar-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'skin!' => 'full_screen',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_size',
            [
                'label'     => __('Height', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__container:not(.elementor-search-form--full-screen) ' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'skin!' => 'full_screen',
                ],
            ]
        );

        $this->add_control(
            'bg_wrapper',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__container:not(.elementor-search-form--full-screen)' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'skin!' => 'full_screen',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_wrapper',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-search-form__container:not(.elementor-search-form--full-screen)',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'wrapper_border_radius',
            [
                'label'      => __('Border Radius', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-search-form__container:not(.elementor-search-form--full-screen)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'wrapper_box_shadow',
                'selector' => '{{WRAPPER}} .elementor-search-form__container:not(.elementor-search-form--full-screen)',
            ]
        );


        $this->end_controls_section();


        $this->start_controls_section(
            'section_input_style',
            [
                'label' => __('Input', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_size_minimal',
            [
                'label'     => __('Icon Size', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__icon' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'skin' => 'minimal',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'overlay_background_color',
            [
                'label'     => __('Overlay Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-search-form--skin-full_screen .elementor-search-form__container' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'skin' => 'full_screen',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'input_typography',
                'selector' => '{{WRAPPER}} input[type="search"].elementor-search-form__input',
            ]
        );

        $this->add_responsive_control(
            'input_padding',
            [
                'label'      => __('Padding', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} input[type="search"].elementor-search-form__input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'skin' => 'classic',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_input_colors');

        $this->start_controls_tab(
            'tab_input_normal',
            [
                'label' => __('Normal', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'input_text_color',
            [
                'label'     => __('Text Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__input,
					{{WRAPPER}} .elementor-search-form__icon,
					{{WRAPPER}} .elementor-lightbox .dialog-lightbox-close-button,
					{{WRAPPER}} .elementor-lightbox .dialog-lightbox-close-button:hover,
					{{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'input_background_color',
                'selector'  => '{{WRAPPER}} input[type="search"].elementor-search-form__input',
                'types'     => ['classic', 'gradient'],
                'condition' => [
                    'skin!' => 'full_screen',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'input_border',
                'selector' => '{{WRAPPER}} input[type="search"].elementor-search-form__input',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'           => 'input_box_shadow',
                'selector'       => '{{WRAPPER}} .elementor-search-form__container',
                'fields_options' => [
                    'box_shadow_type' => [
                        'separator' => 'default',
                    ],
                ],
                'condition'      => [
                    'skin!' => 'full_screen',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_input_focus',
            [
                'label' => __('Focus', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'input_text_color_focus',
            [
                'label'     => __('Text Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:not(.elementor-search-form--skin-full_screen) .elementor-search-form--focus .elementor-search-form__input,
					{{WRAPPER}} .elementor-search-form--focus .elementor-search-form__icon,
					{{WRAPPER}} .elementor-lightbox .dialog-lightbox-close-button:hover,
					{{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input:focus' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'input_background_color_focus',
                'selector'  => '{{WRAPPER}} input[type="search"].elementor-search-form__input:focus',
                'types'     => ['classic', 'gradient'],
                'condition' => [
                    'skin!' => 'full_screen',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'input_border_focus',
                'selector' => '{{WRAPPER}} input[type="search"].elementor-search-form__input:focus',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'           => 'input_box_shadow_focus',
                'selector'       => '{{WRAPPER}} .elementor-search-form--focus .elementor-search-form__container',
                'fields_options' => [
                    'box_shadow_type' => [
                        'separator' => 'default',
                    ],
                ],
                'condition'      => [
                    'skin!' => 'full_screen',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_style',
            [
                'label'     => __('Button', 'medilazar-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'skin' => 'classic',
                ],
            ]
        );

        $this->add_control(
            'heading_style_button',
            [
                'label' => __('Style', 'medilazar-core'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'button_width',
            [
                'label'      => __('Button Width', 'medilazar-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-search-form .elementor-search-form__submit' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'skin' => 'classic',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_typography',
                'selector'  => '{{WRAPPER}} .elementor-search-form .elementor-search-form__submit span',
                'condition' => [
                    'button_type!' => 'icon',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_button_colors');

        $this->start_controls_tab(
            'tab_button_normal',
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
                    '{{WRAPPER}} .elementor-search-form .elementor-search-form__submit' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form .elementor-search-form__submit' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __('Hover', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label'     => __('Text Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form .elementor-search-form__submit:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_background_color_hover',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form .elementor-search-form__submit:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_border_color_hover',
            [
                'label'     => __('Border Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form .elementor-search-form__submit:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_group_control(

            Group_Control_Border::get_type(),
            [
                'name'        => 'border_button_search',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-search-form .elementor-search-form__submit',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'button_search_border_radius',
            [
                'label'      => __('Border Radius', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-search-form .elementor-search-form__submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_search_padding',
            [
                'label'      => __('Padding', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-search-form .elementor-search-form__submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_search_margin',
            [
                'label'      => __('Margin', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-search-form .elementor-search-form__submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_icon',
            [
                'label'     => __('Icon', 'medilazar-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'button_type!' => 'text',
                    'skin!'        => 'full_screen',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'     => __('Icon Size', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__submit i' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'button_type!' => 'text',
                    'skin!'        => 'full_screen',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label'     => __('Icon Spacing', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 15,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__submit i' => 'margin-right: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'button_type!' => 'text',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_toggle_style',
            [
                'label'     => __('Toggle', 'medilazar-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'skin' => 'full_screen',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_toggle_color');

        $this->start_controls_tab(
            'tab_toggle_normal',
            [
                'label' => __('Normal', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'toggle_color',
            [
                'label'     => __('Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'toggle_background_color',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle i' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_toggle_hover',
            [
                'label' => __('Hover', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'toggle_color_hover',
            [
                'label'     => __('Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle:hover' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'toggle_background_color_hover',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle i:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'toggle_icon_size',
            [
                'label'     => __('Icon Size', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle i:before' => 'font-size: calc({{SIZE}}em / 100)',
                ],
                'condition' => [
                    'skin' => 'full_screen',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'toggle_border_width',
            [
                'label'     => __('Border Width', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle i' => 'border-width: {{SIZE}}{{UNIT}}',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'toggle_border_radius',
            [
                'label'      => __('Border Radius', 'medilazar-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-search-form__toggle i' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();
        $this->add_render_attribute(
            'input', [
                'placeholder' => $settings['placeholder'],
                'class'       => osf_is_woocommerce_activated() ? 'elementor-search-form__input elementor-search-form__input_product ' : 'elementor-search-form__input',
                'type'        => 'search',
                'name'        => 's',
                'title'       => __('Search', 'medilazar-core'),
                'value'       => get_search_query(),
            ]
        );

        // Set the selected icon.
        if ('icon' == $settings['button_type']) {
            $icon_class = 'search';

            if ('arrow' == $settings['icon_skin']) {
                $icon_class = is_rtl() ? 'arrow-left' : 'arrow-right';
            }

            $this->add_render_attribute('icon', [
                'class' => 'fa fa-' . $icon_class,
            ]);
        }

        ?>
        <form class="elementor-search-form" role="search" action="<?php echo home_url(); ?>" method="get">
            <?php if ('full_screen' === $settings['skin']) : ?>
                <div class="elementor-search-form__toggle">
                    <i class="<?php echo $settings['icon_skin']; ?>" aria-hidden="true"></i>
                </div>
            <?php endif; ?>

            <div class="elementor-search-form__container">
                <?php if ('full_screen' === $settings['skin']) : ?>
                <div class="w-100 elementor-search-form--full-screen-inner">
                    <?php endif; ?>
                    <?php if ('minimal' === $settings['skin']) : ?>
                        <div class="elementor-search-form__icon">
                            <i class="<?php echo $settings['icon_skin']; ?>" aria-hidden="true"></i>
                        </div>
                    <?php endif; ?>
                    <input <?php echo $this->get_render_attribute_string('input'); ?>>
                    <?php if (osf_is_woocommerce_activated()): ?>
                        <?php osf_show_categories_dropdown(); ?>
                        <div class="elementor-search-data-fetch" style="display:none;"></div>
                        <input type="hidden" name="post_type" value="product"/>
                    <?php endif; ?>
                    <?php if ('classic' === $settings['skin']) : ?>
                        <button class="elementor-search-form__submit" type="submit">
                            <?php if ('icon' === $settings['button_type']) : ?>
                                <i class="<?php echo $settings['icon_skin']; ?>" aria-hidden="true"></i>
                            <?php elseif ('text' === $settings['button_type']) : ?>
                                <span><?php echo $settings['button_text']; ?></span>
                            <?php elseif ('text_icon' === $settings['button_type']) : ?>
                                <i class="<?php echo $settings['icon_skin']; ?> align-middle" aria-hidden="true"></i>
                                <span class="align-middle"><?php echo $settings['button_text']; ?></span>
                            <?php endif; ?>
                        </button>
                    <?php endif; ?>
                    <?php if ('full_screen' === $settings['skin']) : ?>
                    <div class="dialog-lightbox-close-button dialog-close-button">
                        <i class="eicon-close" aria-hidden="true"></i>
                        <span class="elementor-screen-only"><?php esc_html_e('Close', 'medilazar-core'); ?></span>
                    </div>
                </div>
            <?php endif ?>
            </div>
        </form>
        <?php
    }
}

$widgets_manager->register(new OSF_Elementor_Search_Form());
