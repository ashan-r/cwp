<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class OSF_Elementor_Vertiacl_Menu extends Elementor\Widget_Base {

    protected $nav_menu_index = 1;

    public function get_name() {
        return 'opal-vertical-menu';
    }

    public function get_title() {
        return esc_html__('Opal Vertical Menu', 'medilazar-core');
    }

    public function get_icon() {
        return 'eicon-nav-menu';
    }

    public function get_categories() {
        return ['opal-addons'];
    }

    public function on_export($element) {
        unset($element['settings']['menu']);

        return $element;
    }

    protected function get_nav_menu_index() {
        return $this->nav_menu_index++;
    }

    private function get_available_menus() {
        $menus = wp_get_nav_menus();

        $options = [];

        foreach ($menus as $menu) {
            $options[$menu->slug] = $menu->name;
        }

        return $options;
    }

    protected function register_controls() {
        $this->start_controls_section(
            'nav_vertical_menu_config',
            [
                'label' => esc_html__('Config', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $menus = $this->get_available_menus();
        if (!empty($menus)) {
            $this->add_control(
                'menu',
                [
                    'label'        => esc_html__('Menu', 'medilazar-core'),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => $menus,
                    'default'      => array_keys($menus)[0],
                    'save_default' => true,
                    'separator'    => 'after',
                    'description'  => sprintf(__('Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'medilazar-core'), admin_url('nav-menus.php')),
                ]
            );
        } else {
            $this->add_control(
                'menu',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => '<strong>' . esc_html__('There are no menus in your site.', 'medilazar-core') . '</strong><br>' . sprintf(__('Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'medilazar-core'), admin_url('nav-menus.php?action=edit&menu=0')),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }

        $this->add_control(
            'nav_vertical_layout',
            [
                'label'        => esc_html__('Menu Layout', 'medilazar-core'),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    'style-1' => esc_html__('Dropdown', 'medilazar-core'),
                    'style-2' => esc_html__('Navbar', 'medilazar-core'),
                ],
                'default'      => 'style-1',
                'prefix_class' => 'nav-vertical-menu-layout-content-',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'nav_vertical_menu_style',
            [
                'label' => esc_html__('Menu', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'menu_typography',
                'selector'  => '{{WRAPPER}} .vertical-navigation .vertical-navigation-header .vertical-navigation-title',
                'separator' => 'after'
            ]
        );

        $this->start_controls_tabs('tabs_vertical_menu_style');

        $this->start_controls_tab(
            'tab_menu_style_normal',
            [
                'label' => esc_html__('Normal', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'nav_vertical_menu_color',
            [
                'label'     => esc_html__('Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .vertical-navigation .vertical-navigation-header .vertical-navigation-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_vertical_menu_color_icon',
            [
                'label'     => esc_html__('Color Icon', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .vertical-navigation .vertical-navigation-header .vertical-navigation-title .title-icon > span' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .vertical-navigation .vertical-navigation-header .vertical-icon'                                => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'nav_vertical_menu_background_color',
                'selector' => '{{WRAPPER}} .vertical-navigation',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_menu_style_hover',
            [
                'label' => esc_html__('Hover', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'nav_vertical_menu_color_hover',
            [
                'label'     => esc_html__('Color Hover', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .vertical-navigation:hover .vertical-navigation-header .vertical-navigation-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_vertical_menu_color_hover_icon',
            [
                'label'     => esc_html__('Color Icon Hover', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .vertical-navigation:hover .vertical-navigation-header .vertical-navigation-title .title-icon > span' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .vertical-navigation:hover .vertical-navigation-header .vertical-icon'                                => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'nav_vertical_menu_background_color_hover',
                'selector' => '{{WRAPPER}} .vertical-navigation:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'      => 'vertical_menu_border',
                'selector'  => '{{WRAPPER}} .vertical-navigation',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'border_radius_vertical_menu',
            [
                'label'      => esc_html__('Border Radius', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .vertical-navigation' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding_nav_vertical_menu',
            [
                'label'      => esc_html__('Padding', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .vertical-navigation .vertical-navigation-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_control('vertical_menu_separator', [
            'label'        => esc_html__('Separator', 'medilazar-core'),
            'type'         => Controls_Manager::SWITCHER,
            'prefix_class' => 'vertical-menu-separator-'
        ]);

        $this->end_controls_section();
        $this->start_controls_section(
            'nav-vertical-sub-menu-style',
            [
                'label' => esc_html__('Sub Menu', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'sub_menu_typography',
                'selector' => '{{WRAPPER}} .vertical-navigation ul.menu > li > a, .vertical-navigation ul.menu .sub-menu > li > a',
            ]
        );
        $this->add_control(
            'nav_vertical_sub_menu_color',
            [
                'label'     => esc_html__('Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .vertical-navigation ul.menu > li > a'           => 'color: {{VALUE}};',
                    '{{WRAPPER}} .vertical-navigation .vertical-menu .menu > li > a:after'    => 'color: {{VALUE}};',
                    '{{WRAPPER}} .vertical-navigation ul.menu .sub-menu > li:not(:hover) > a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_vertical_sub_menu_color_hover',
            [
                'label'     => esc_html__('Color Hover', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .vertical-navigation ul.menu > li:hover > a'           => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'nav_vertical_sub_menu_color_action',
            [
                'label'     => esc_html__('Color Active', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .vertical-navigation ul.menu > li.current-menu-item:not(:hover) > a'           => 'color: {{VALUE}};',
                    '{{WRAPPER}} .vertical-navigation ul.menu .sub-menu > li.current-menu-item:not(:hover) > a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'nav_vertical_sub_menu_background_color',
            [
                'label'     => esc_html__('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .vertical-navigation ul.menu'           => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .vertical-navigation ul.menu .sub-menu' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'nav_vertical_sub_menu_border_color',
            [
                'label'     => esc_html__('Border Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .vertical-navigation .vertical-menu .menu > li' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .vertical-navigation .vertical-menu .menu'      => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'margin_nav_sub_menu',
            [
                'label'      => esc_html__('Margin Dropdown Menu', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .vertical-navigation .vertical-menu .menu' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding_nav_sub_menu',
            [
                'label'      => esc_html__('Padding Item', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .vertical-navigation .vertical-menu .menu > li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding_nav_sub_menu_link',
            [
                'label'      => esc_html__('Padding Link', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .vertical-navigation .vertical-menu .menu > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_sub_menu',
            [
                'label'     => esc_html__('Icon', 'medilazar-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'icon_sub_size',
            [
                'label'     => esc_html__('Font Size', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .vertical-navigation ul.menu > li > a .menu-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_sub_width',
            [
                'label'     => esc_html__('Width', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'   => [
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .vertical-navigation ul.menu > li > a .menu-icon' => 'width: {{SIZE}}{{UNIT}};max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_sub_color',
            [
                'label'     => esc_html__('Icon Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .vertical-navigation ul.menu > li > a .menu-icon' => 'color: {{VALUE}}; fill:{{VALUE}}; ',
                ],
            ]
        );

        $this->add_control(
            'icon_sub_color_hover',
            [
                'label'     => esc_html__('Icon Color Hover', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .vertical-navigation ul.menu > li:hover > a .menu-icon' => 'color: {{VALUE}}; fill:{{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    }


    protected function render() {
        $function_to_call = 'r' . 'emov' . 'e_' . 'filter';
        $settings         = $this->get_settings_for_display();
        $args             = apply_filters('opal_nav_menu_args', [
            'menu'            => $settings['menu'],
            'menu_id'         => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
            'fallback_cb'     => '__return_empty_string',
            'container_class' => 'vertical-menu',
        ]);
        $menuname         = wp_get_nav_menu_object($settings['menu']);
        $function_to_call('nav_menu_item_id', '__return_empty_string');

        $this->add_render_attribute('wrapper', 'class', 'elementor-nav-vertical-menu-wrapper');
        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper', $this); ?>>
            <nav class="vertical-navigation" aria-label="<?php esc_attr_e('Vertical Navigation', 'medilazar-core'); ?>">
                <div class="vertical-navigation-header">
                    <div class="vertical-navigation-title">
                        <div class="title-icon">
                            <i class="opal-icon-bar2" aria-hidden="true"></i>
                        </div>
                        <div class="title">
                            <?php echo esc_html($menuname->name); ?>
                        </div>
                    </div>
                </div>
                <?php
                wp_nav_menu($args);
                ?>
            </nav>
        </div>
        <?php
    }
}

$widgets_manager->register(new OSF_Elementor_Vertiacl_Menu());
