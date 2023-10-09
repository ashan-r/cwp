<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

abstract class OSF_Elementor_Carousel_Base extends Elementor\Widget_Base {

    public function get_categories() {
        return array('opal-addons');
    }

    public function get_name() {
        return 'opal-carousel-base';
    }


    protected function add_control_carousel($condition = array()) {
        $this->start_controls_section(
            'section_carousel_options',
            [
                'label'     => __('Carousel Options', 'medilazar-core'),
                'type'      => Controls_Manager::SECTION,
                'condition' => $condition,
            ]
        );

        $this->add_control(
            'enable_carousel',
            [
                'label' => __('Enable', 'medilazar-core'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );
        $this->add_responsive_control(
            'owl_item_spacing',
            [
                'label'     => __('Spacing', 'medilazar-core'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 30,
                'condition' => [
                    'enable_carousel' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'enable_center',
            [
                'label'        => __('Center', 'medilazar-core'),
                'type'         => Controls_Manager::SWITCHER,
                'prefix_class' => 'owl-item-',
                'condition'    => [
                    'enable_carousel' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'navigation',
            [
                'label'     => __('Navigation', 'medilazar-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'dots',
                'options'   => [
                    'both'   => __('Arrows and Dots', 'medilazar-core'),
                    'arrows' => __('Arrows', 'medilazar-core'),
                    'dots'   => __('Dots', 'medilazar-core'),
                    'none'   => __('None', 'medilazar-core'),
                ],
                'condition' => [
                    'enable_carousel' => 'yes'
                ],
            ]
        );
        $this->add_control(
            'nav_position',
            [
                'label'        => __('Nav Position', 'medilazar-core'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'top',
                'options'      => [
                    'top'    => __('Top', 'medilazar-core'),
                    'center' => __('Center', 'medilazar-core'),
                    'bottom' => __('Bottom', 'medilazar-core'),
                ],
                'conditions'   => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'enable_carousel',
                            'operator' => '==',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'none',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'dots',
                        ],
                    ],
                ],
                'prefix_class' => 'owl-nav-position-',
            ]
        );
        $this->add_control(
            'nav_align',
            [
                'label'        => __('Nav Align', 'medilazar-core'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'right',
                'options'      => [
                    'left'   => __('Left', 'medilazar-core'),
                    'center' => __('Center', 'medilazar-core'),
                    'right'  => __('Right', 'medilazar-core'),
                ],
                //                'condition' => [
                //                    'navigation' => ['arrows', 'both'],
                //                    'nav_position' => ['bottom', 'top'],
                //                ],
                'conditions'   => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'enable_carousel',
                            'operator' => '==',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'none',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'dots',
                        ],
                        [
                            'name'     => 'nav_position',
                            'operator' => '!==',
                            'value'    => 'center',
                        ],
                    ],
                ],
                'prefix_class' => 'owl-nav-align-',
            ]
        );
        $this->add_responsive_control(
            'nav_spacing_vertical',
            [
                'label'      => __('Nav Spacing Vertical', 'medilazar-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.owl-nav-position-top .owl-nav'                      => 'top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.owl-nav-position-bottom .owl-nav'                   => 'bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.owl-nav-position-center .owl-nav [class*=\'owl-\']' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'enable_carousel',
                            'operator' => '==',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'none',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'dots',
                        ],
                        //                        [
                        //                            'name'     => 'nav_position',
                        //                            'operator' => '!==',
                        //                            'value'    => 'center',
                        //                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_spacing_horizontal',
            [
                'label'      => __('Nav Spacing Horizontal', 'medilazar-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.owl-nav-position-center .owl-theme.owl-carousel .owl-nav [class*=\'owl-\'].owl-prev' => 'left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.owl-nav-position-center .owl-theme.owl-carousel .owl-nav [class*=\'owl-\'].owl-next' => 'right: {{SIZE}}{{UNIT}};',
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'enable_carousel',
                            'operator' => '==',
                            'value'    => 'yes',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'none',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'dots',
                        ],
                        [
                            'name'     => 'nav_position',
                            'operator' => '==',
                            'value'    => 'center',
                        ],
                    ],
                ],
            ]
        );


        $this->add_control(
            'pause_on_hover',
            [
                'label'     => __('Pause on Hover', 'medilazar-core'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'condition' => [
                    'enable_carousel' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'     => __('Autoplay', 'medilazar-core'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'condition' => [
                    'enable_carousel' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'     => __('Autoplay Speed', 'medilazar-core'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5000,
                'condition' => [
                    'autoplay'        => 'yes',
                    'enable_carousel' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-slide-bg' => 'animation-duration: calc({{VALUE}}ms*1.2); transition-duration: calc({{VALUE}}ms)',
                ],
            ]
        );

        $this->add_control(
            'infinite',
            [
                'label'     => __('Infinite Loop', 'medilazar-core'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'condition' => [
                    'enable_carousel' => 'yes'
                ],
            ]
        );

//        $this->add_control(
//            'transition',
//            [
//                'label' => __( 'Transition', 'elementor-pro' ),
//                'type' => Controls_Manager::SELECT,
//                'default' => 'slide',
//                'options' => [
//                    'slide' => __( 'Slide', 'elementor-pro' ),
//                    'fade' => __( 'Fade', 'elementor-pro' ),
//                ],
//                'condition' => [
//                    'enable_carousel' => 'yes'
//                ],
//            ]
//        );
//
//        $this->add_control(
//            'transition_speed',
//            [
//                'label' => __( 'Transition Speed (ms)', 'elementor-pro' ),
//                'type' => Controls_Manager::NUMBER,
//                'default' => 500,
//                'condition' => [
//                    'enable_carousel' => 'yes'
//                ],
//            ]
//        );

//        $this->add_control(
//            'content_animation',
//            [
//                'label' => __( 'Content Animation', 'elementor-pro' ),
//                'type' => Controls_Manager::SELECT,
//                'default' => 'fadeInUp',
//                'options' => [
//                    '' => __( 'None', 'elementor-pro' ),
//                    'fadeInDown' => __( 'Down', 'elementor-pro' ),
//                    'fadeInUp' => __( 'Up', 'elementor-pro' ),
//                    'fadeInRight' => __( 'Right', 'elementor-pro' ),
//                    'fadeInLeft' => __( 'Left', 'elementor-pro' ),
//                    'zoomIn' => __( 'Zoom', 'elementor-pro' ),
//                ],
//                'condition' => [
//                    'enable_carousel' => 'yes'
//                ],
//            ]
//        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_carousel_style',
            [
                'label'     => __('Carousel', 'medilazar-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'enable_carousel' => 'yes'
                ],
            ]
        );
        $this->add_control(
            'carousel_navs_color',
            [
                'label'     => __('Nav Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-carousel .owl-nav' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .products  .owl-nav'    => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->start_controls_tabs('tabs_nav_style');


        $this->start_controls_tab(
            'tab_nav_normal',
            [
                'label' => __('Normal', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'carousel_nav_color',
            [
                'label'     => __('Arrow Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-nav [class*="owl-"]:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_nav_bg_color',
            [
                'label'     => __('Arrow Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-nav [class*="owl-"]:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_nav_border_color',
            [
                'label'     => __('Arrow Border Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-nav [class*="owl-"]:before' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_dot_color',
            [
                'label'     => __('Dot Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-dots .owl-dot' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_nav_hover',
            [
                'label' => __('Hover', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'carousel_nav_color_hover',
            [
                'label'     => __('Arrow Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-nav [class*="owl-"]:hover:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_nav_bg_color_hover',
            [
                'label'     => __('Arrow Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-nav [class*="owl-"]:hover:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_nav_border_color_hover',
            [
                'label'     => __('Arrow Border Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-nav [class*="owl-"]:hover:before' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_dot_color_hover',
            [
                'label'     => __('Dot Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-dots .owl-dot:hover'  => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-dots .owl-dot.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function get_carousel_settings() {
        $settings = $this->get_settings_for_display();
        $rtl      = false;
        if (is_rtl()) {
            $rtl = true;
        }
        return array(
            'navigation'         => $settings['navigation'],
            'autoplayHoverPause' => $settings['pause_on_hover'] === 'yes' ? true : false,
            'autoplay'           => $settings['autoplay'] === 'yes' ? true : false,
            'center'             => $settings['enable_center'] === 'yes' ? true : false,
            'autoplayTimeout'    => $settings['autoplay_speed'],
            'items'              => $settings['column'],
            'items_tablet'       => $settings['column_tablet'] ? $settings['column_tablet'] : $settings['column'],
            'items_mobile'       => $settings['column_mobile'] ? $settings['column_mobile'] : 1,
            'loop'               => $settings['infinite'] === 'yes' ? true : false,
            'rtl'                => $rtl,
            'margin'             => !empty($settings['owl_item_spacing']) ? $settings['owl_item_spacing'] : 0,
            'margin_tablet'      => !empty($settings['owl_item_spacing_tablet']) ? $settings['owl_item_spacing_tablet'] : $settings['owl_item_spacing'],
            'margin_mobile'      => !empty($settings['owl_item_spacing_mobile']) ? $settings['owl_item_spacing_mobile'] : 1,
        );
    }

    protected function render_carousel_template() {
        ?>
        var carousel_settings = {
        navigation: settings.navigation,
        autoplayHoverPause: settings.pause_on_hover === 'yes' ? true : false,
        autoplay: settings.autoplay === 'yes' ? true : false,
        autoplayTimeout: settings.autoplay_speed,
        items: settings.column,
        items_tablet: settings.column_tablet ? settings.column_tablet : settings.column,
        items_mobile: settings.column_mobile ? settings.column_mobile : 1,
        loop: settings.infinite === 'yes' ? true : false,
        margin: settings.owl_item_spacing ? settings.owl_item_spacing : 0,
        margin_tablet: settings.owl_item_spacing_tablet ? settings.owl_item_spacing_tablet : settings.owl_item_spacing,
        margin_mobile: settings.owl_item_spacing_mobile ? settings.owl_item_spacing_mobile : 1,
        };
        <?php
    }
}