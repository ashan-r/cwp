<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Typography;

class OSF_Ajax_Load_More {
    public static $instance;

    private $template;

    public static function getInstance() {
        if (!isset(self::$instance) && !(self::$instance instanceof OSF_Ajax_Load_More)) {
            self::$instance = new OSF_Ajax_Load_More();
        }
        return self::$instance;
    }

    public function __construct() {
        $this->template = trailingslashit(dirname(__FILE__)) . 'templates';
        add_action('alm_get_theme_repeater', [$this, 'render_template'], 9999, 1);
    }

    public function render_template($template) {
        $template = $this->template . '/' . $template;
        if (file_exists($template)) {
            include $template;
        } else {
            include alm_get_current_repeater('default', 'default');
        }
    }

    public function add_control_ajax_load_more($widget, $condition = array()) {
        $widget->start_controls_section(
            'section_ajax_options',
            [
                'label'     => __('Ajax Load More', 'medilazar-core'),
                'tab'      => Controls_Manager::SECTION,
                'condition' => $condition,
            ]
        );
        $widget->add_control(
            'ajax_show',
            [
                'label' => __('Enable load more', 'medilazar-core'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $widget->add_control(
            'button_label',
            [
                'label'     => __('Button Label', 'medilazar-core'),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'ajax_show' => 'yes'
                ]
            ]
        );

        $widget->add_control(
            'button_loading_label',
            [
                'label'     => __('Button Loading Label', 'medilazar-core'),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'ajax_show' => 'yes'
                ]
            ]
        );
        $widget->add_control(
            'ajax_scroll',
            [
                'label'        => __('Enable Scrolling', 'medilazar-core'),
                'type'         => Controls_Manager::SWITCHER,
                'description'  => __('Load more posts as the user scrolls the page.', 'medilazar-core'),
                'default'      => 'false',
                'return_value' => 'true',
                'condition'    => [
                    'ajax_show' => 'yes'
                ]
            ]
        );
        $widget->end_controls_section();

        $widget->start_controls_section(
            'section_ajax_style',
            [
                'label'     => __('Load More Button', 'medilazar-core'),
                'tab'      => Controls_Manager::TAB_STYLE,
                'condition'    => [
                    'ajax_show' => 'yes'
                ]
            ]
        );
        $widget->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'button_ajax_typography',
                'selector' => '{{WRAPPER}} .alm-btn-wrap .alm-load-more-btn',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
                'label'    =>  __('Button Typo', 'medilazar-core'),
            ]
        );

        $widget->start_controls_tabs('button_ajax_tab');

        $widget->start_controls_tab(
            'button_ajax_normal',
            [
                'label' => __('Normal', 'medilazar-core'),
            ]
        );
        $widget->add_control(
            'button_ajax_color',
            [
                'label'     => __('Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .alm-btn-wrap .alm-load-more-btn' => 'color: {{VALUE}};',
                ],
            ]
        );
        $widget->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'button_ajax_background',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .alm-btn-wrap .alm-load-more-btn',
            ]
        );
        $widget->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'button_ajax_border',
                'selector' => '{{WRAPPER}} .alm-btn-wrap .alm-load-more-btn',
            ]
        );

        $widget->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_ajax_box_shadow',
                'selector' => '{{WRAPPER}} .alm-btn-wrap .alm-load-more-btn',
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'button_ajax_hover',
            [
                'label' => __('Hover', 'medilazar-core'),
            ]
        );
        $widget->add_control(
            'button_ajax_color_hover',
            [
                'label'     => __('Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .alm-btn-wrap .alm-load-more-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $widget->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'button_ajax_background_hover',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .alm-btn-wrap .alm-load-more-btn:hover',
            ]
        );
        $widget->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'button_ajax_border_hover',
                'selector' => '{{WRAPPER}} .alm-btn-wrap .alm-load-more-btn:hover',
            ]
        );
        $widget->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_ajax_box_shadow_hover',
                'selector' => '{{WRAPPER}} .alm-btn-wrap .alm-load-more-btn:hover',
            ]
        );

        $widget->end_controls_tab();

        $widget->end_controls_tabs();

        $widget->add_control(
            'button_ajax_padding',
            [
                'label'      => __('Padding', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .alm-btn-wrap .alm-load-more-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $widget->end_controls_section();
    }
}

OSF_Ajax_Load_More::getInstance();