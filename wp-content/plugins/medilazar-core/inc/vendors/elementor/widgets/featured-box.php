<?php

namespace Elementor;
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor featured box widget.
 *
 * Elementor widget that displays an image, a headline and a text.
 *
 * @since 1.0.0
 */
class OSF_Widget_Featured_Box extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve featured box widget name.
     *
     * @return string Widget name.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_name() {
        return 'featured-box';
    }

    /**
     * Get widget title.
     *
     * Retrieve featured box widget title.
     *
     * @return string Widget title.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_title() {
        return __('Featured Box', 'medilazar-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve featured box widget icon.
     *
     * @return string Widget icon.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-image-box';
    }

    public function get_categories() {
        return ['opal-addons'];
    }

    /**
     * Register featured box widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_icon',
            [
                'label' => __('Featured Box', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'icon',
            [
                'label'   => __('Icon', 'medilazar-core'),
                'type'    => Controls_Manager::ICON,
                'default' => 'fa fa-star',
            ]
        );

        $this->add_control(
            'show_icon_bg',
            [

                'label'        => __('Show Icon Background', 'medilazar-core'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => __('Show', 'medilazar-core'),
                'label_off'    => __('Hide', 'medilazar-core'),
                'prefix_class' => 'elementor-icon-bg-',
            ]
        );


        $this->add_control(
            'title_text',
            [
                'label'       => __('Title', 'medilazar-core'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => __('This is the heading', 'medilazar-core'),
                'placeholder' => __('Enter your title', 'medilazar-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description_text',
            [
                'label'       => __('Description', 'medilazar-core'),
                'type'        => Controls_Manager::TEXTAREA,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => __('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'medilazar-core'),
                'placeholder' => __('Enter your description', 'medilazar-core'),
                'separator'   => 'none',
                'rows'        => 10,
            ]
        );

        $this->add_control(
            'link',
            [
                'label'       => __('Link to', 'medilazar-core'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => __('https://your-link.com', 'medilazar-core'),
                'separator'   => 'before',
            ]
        );
        $this->add_control(
            'button_text',
            [
                'label'       => __('Button', 'medilazar-core'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => __('Read more', 'medilazar-core'),
                'separator'   => 'none',
            ]
        );
        $this->add_control(
            'button_icon',
            [
                'label'       => __('Icon', 'medilazar-core'),
                'type'        => Controls_Manager::ICON,
                'label_block' => true,
                'default'     => '',
            ]
        );
//        $this->add_control(
//            'button_show_hover',
//            [
//                'label' => __('Show when Hover', 'erios-core'),
//                'type' => Controls_Manager::SWITCHER,
//                'prefix_class' => 'button-show-hover-',
//            ]
//        );
        $this->add_control(
            'box_display',
            [
                'label'        => __('Style', 'medilazar-core'),
                'type'         => Controls_Manager::SELECT,
                'default'      => '',
                'options'      => [
                    ''  => __('Style 1', 'medilazar-core'),
                    '2' => __('Style 2', 'medilazar-core'),
                ],
                'prefix_class' => 'elementor-featured-box-style-'
            ]
        );

        $this->add_control(
            'alignment',
            [
                'label'     => __('Alignment', 'medilazar-core'),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'left',
                'options'   => [
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
                //'prefix_class' => 'elementor-position-',
                //'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .elementor-featured-box-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_size',
            [
                'label'   => __('Title HTML Tag', 'medilazar-core'),
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
                'label'   => __('View', 'medilazar-core'),
                'type'    => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->end_controls_section();

        //Wrapper
        $this->start_controls_section(
            'section_style_wrapper',
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

        $this->add_control(
            'bg_wrapper',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-featured-box-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_wrapper_hover',
            [
                'label' => __('Hover', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'bg_wrapper_hover',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-featured-box-wrapper:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'boder_wrapper_hover',
            [
                'label'     => __('Border Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-featured-box-wrapper:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_wrapper',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-featured-box-wrapper',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'wrapper_radius',
            [
                'label'      => __('Border Radius', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-featured-box-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label'      => __('Padding', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-featured-box-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_margin',
            [
                'label'      => __('Margin', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-featured-box-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //Icon

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => __('Icon', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
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
            'icon_bg_color',
            [
                'label'     => __('Bg Icon Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-featured-box-wrapper i:after' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_icon_bg'   => 'yes',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => __(' Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-featured-box-wrapper i' => 'color: {{VALUE}};',
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
            'icon_color_hover',
            [
                'label'     => __(' Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-featured-box-wrapper:hover i:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icon_size',
            [
                'label'      => __('Size', 'medilazar-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-featured-box-wrapper i' => 'font-size:{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label'      => __('Margin', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-featured-box-wrapper i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //Title

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => __('Title', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_title_style');

        $this->start_controls_tab(
            'tab_title_normal',
            [
                'label' => __('Normal', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __(' Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-featured-box-wrapper .elementor-featured-box-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            [
                'label' => __('Hover', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label'     => __(' Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-featured-box-wrapper:hover .elementor-featured-box-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .elementor-featured-box-title',
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label'      => __('Spacing', 'medilazar-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-featured-box-title' => 'margin-bottom:{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //Description

        $this->start_controls_section(
            'section_style_description',
            [
                'label' => __('Description', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => __(' Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-featured-box-wrapper .elementor-featured-box-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'selector' => '{{WRAPPER}} .elementor-featured-box-description',
            ]
        );

        $this->end_controls_section();


        //button
        $this->start_controls_section(
            'button_style',
            [
                'label' => __('Button', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
                //                'condition' => [
                //                    'button!' => '',
                //                ],
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
                'default'      => 'default',
                'options'      => [
                    'default'           => __('Default', 'medilazar-core'),
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
                'selector' => '{{WRAPPER}} .elementor-button',
            ]
        );
        $this->add_control(
            'button_spacing',
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
                    '{{WRAPPER}} .elementor-button' => 'margin-top: {{SIZE}}{{UNIT}};',
                ]
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
                    '{{WRAPPER}} .elementor-button:not(:hover)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:not(:hover)' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_color_style',
            [
                'label'     => __('Border Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:not(:hover)' => 'border-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background_color',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label'     => __('Border Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'button_border',
                'selector'  => '{{WRAPPER}} .elementor-button',
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
                    '{{WRAPPER}} .elementor-button' => 'border-radius: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
                'label'   => __('Position', 'medilazar-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'left'  => __('Before', 'medilazar-core'),
                    'right' => __('After', 'medilazar-core'),
                ]
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
                    'button_icon!' => '',
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
                    'size' => 5,
                ],
                'condition' => [
                    'button_icon!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-button .elementor-align-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
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

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('wrapper', 'class', 'elementor-featured-box-wrapper');

        $html = '<div ' . $this->get_render_attribute_string("wrapper") . '>';

        if (!empty($settings['link']['url'])) {
            $this->add_render_attribute('link', 'href', $settings['link']['url']);

            if ($settings['link']['is_external']) {
                $this->add_render_attribute('link', 'target', '_blank');
            }

            if (!empty($settings['link']['nofollow'])) {
                $this->add_render_attribute('link', 'rel', 'nofollow');
            }
        }

        //icon

        $html .= '<div class="elementor-featured-box-top">';


        if (!empty($settings['icon'])) {

            $this->add_render_attribute('icon', 'class', $settings['icon']);

            $this->add_render_attribute('icon', 'aria-hidden', 'true');

            $html .= '<div class="elementor-featured-box-icon">';

            $html .= '<i class="' . $settings['icon'] . '" aria-hidden="true" ></i>';

            $html .= '</div>';
        }

        $html .= '</div>';

        //end icon


        $html .= '<div class="elementor-featured-box-bottom">';

        if (!empty($settings['title_text'])) {
            $this->add_render_attribute('title_text', 'class', 'elementor-featured-box-title typo-heading');

            $title_html = $settings['title_text'];

            if (!empty($settings['link']['url'])) {
                $title_html = '<a ' . $this->get_render_attribute_string('link') . '>' . $title_html . '</a>';
            }

            $html .= sprintf('<%1$s %2$s>%3$s</%1$s>', $settings['title_size'], $this->get_render_attribute_string('title_text'), $title_html);
        }

        if (!empty($settings['description_text'])) {

            $this->add_render_attribute('description_text', 'class', 'elementor-featured-box-description');

            $html .= sprintf('<p %1$s>%2$s</p>', $this->get_render_attribute_string('description_text'), $settings['description_text']);
        }

        if (!empty($settings['button_text']) || !empty($settings['button_icon'])) {
            $this->add_render_attribute('button_wrapper', 'class', 'elementor-featured-box-button');
            $this->add_render_attribute('button_link', 'class', [
                'elementor-button',
                'elementor-size-' . $settings['button_size'],
            ]);

            $this->add_render_attribute('icon-align', 'class',
                [
                    'elementor-button-icon',
                    'elementor-align-icon-' . $settings['icon_align'],
                ]
            );
            $this->add_inline_editing_attributes('button_wrapper');
            $this->add_inline_editing_attributes('button_link');
            $this->add_inline_editing_attributes('icon-align');

            $button_html = '<span class="elementor-button-content-wrapper">';
            if (!empty($settings['button_icon'])) {
                $button_html .= ' <span ' . $this->get_render_attribute_string('icon-align') . '>';
                $button_html .= '<i class="' . esc_attr($settings['button_icon']) . '" aria-hidden="true"></i>';
                $button_html .= '</span>';
            }
            if (!empty($settings['button_text'])) {
                $button_html .= '<span class="elementor-button-text">' . $settings['button_text'] . '</span>';
            }
            $button_html .= '</span>';
            if (!empty($settings['link']['url'])) {
                $this->add_render_attribute('button_link', 'href', $settings['link']['url']);

                if ($settings['link']['is_external']) {
                    $this->add_render_attribute('button_link', 'target', '_blank');
                }

                if (!empty($settings['link']['nofollow'])) {
                    $this->add_render_attribute('button_link', 'rel', 'nofollow');
                }
            } else {
                $this->add_render_attribute('button_link', 'href', '#');
            }


            $button_html = '<a ' . $this->get_render_attribute_string('button_link') . '>' . $button_html . '</a>';
            $html        .= sprintf('<div %1$s>%2$s</div>', $this->get_render_attribute_string('button_wrapper'), $button_html);
        }

        $html .= '</div>';

        $html .= '</div>';

        echo $html;
    }
}

$widgets_manager->register(new OSF_Widget_Featured_Box());
