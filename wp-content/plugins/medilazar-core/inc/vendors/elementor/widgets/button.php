<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor button widget.
 *
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Widget_Button extends Widget_Button {

    /**
     * Get widget name.
     *
     * Retrieve button widget name.
     *
     * @return string Widget name.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_name() {
        return 'button';
    }

    /**
     * Get widget title.
     *
     * Retrieve button widget title.
     *
     * @return string Widget title.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_title() {
        return __('Button', 'medilazar-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve button widget icon.
     *
     * @return string Widget icon.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-button';
    }

    public function get_script_depends() {
        return ['magnific-popup'];
    }

    public function get_style_depends() {
        return ['magnific-popup'];
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the button widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @return array Widget categories.
     * @since  2.0.0
     * @access public
     *
     */
    public function get_categories() {
        return ['basic'];
    }

    /**
     * Get button sizes.
     *
     * Retrieve an array of button sizes for the button widget.
     *
     * @return array An array containing button sizes.
     * @since  1.0.0
     * @access public
     * @static
     *
     */
    public static function get_button_sizes() {
        return [
            'xs' => __('Extra Small', 'medilazar-core'),
            'sm' => __('Small', 'medilazar-core'),
            'md' => __('Medium', 'medilazar-core'),
            'lg' => __('Large', 'medilazar-core'),
            'xl' => __('Extra Large', 'medilazar-core'),
        ];
    }

    /**
     * Register button widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_button',
            [
                'label' => __('Button', 'medilazar-core'),
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


        $this->add_control(
            'text',
            [
                'label'       => __('Text', 'medilazar-core'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => __('Click here', 'medilazar-core'),
                'placeholder' => __('Click here', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'link',
            [
                'label'       => __('Link', 'medilazar-core'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => __('https://your-link.com', 'medilazar-core'),
                'default'     => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'        => __('Alignment', 'medilazar-core'),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'left'    => [
                        'title' => __('Left', 'medilazar-core'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center'  => [
                        'title' => __('Center', 'medilazar-core'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right'   => [
                        'title' => __('Right', 'medilazar-core'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', 'medilazar-core'),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'prefix_class' => 'elementor%s-align-',
                'default'      => '',
            ]
        );

        $this->add_control(
            'size',
            [
                'label'          => __('Size', 'medilazar-core'),
                'type'           => Controls_Manager::SELECT,
                'default'        => 'lg',
                'options'        => self::get_button_sizes(),
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'icon',
            [
                'label'       => __('Icon', 'medilazar-core'),
                'type'        => Controls_Manager::ICON,
                'label_block' => true,
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

        $this->add_control(
            'button_css_id',
            [
                'label'       => __('Button ID', 'medilazar-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => '',
                'title'       => __('Add your custom id WITHOUT the Pound key. e.g: my-id', 'medilazar-core'),
                'label_block' => false,
                'description' => __('Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'medilazar-core'),
                'separator'   => 'before',

            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'contactform7',
            [
                'label' => __('Contact Form Popup', 'medilazar-core'),
            ]
        );
        $cf7 = get_posts('post_type="wpcf7_contact_form"&numberposts=-1');

        $contact_forms[''] = __('Please select form', 'medilazar-core');
        if ($cf7) {
            foreach ($cf7 as $cform) {
                $contact_forms[$cform->post_name] = $cform->post_title;
            }
        } else {
            $contact_forms[0] = __('No contact forms found', 'medilazar-core');
        }

        $this->add_control(
            'contact_slug',
            [
                'label'   => __('Select contact form', 'medilazar-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => $contact_forms,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Button', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

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
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
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
            'hover_color',
            [
                'label'     => __('Text Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'button_background_hover_color',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label'     => __('Border Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => __('Hover Animation', 'medilazar-core'),
                'type'  => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-button',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label'      => __('Border Radius', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .elementor-button',
            ]
        );

        $this->add_responsive_control(
            'text_padding',
            [
                'label'      => __('Padding', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->end_controls_section();

        // ICON BUTTON

        $this->start_controls_section(
            'section_icon_style',
            [
                'label'     => __('Icon', 'medilazar-core'),
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
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'icon_size',
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
            'icon_width',
            [
                'label'     => __('Width', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'condition' => [
                    'icon!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button .elementor-button-icon' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_height',
            [
                'label'     => __('Height', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'condition' => [
                    'icon!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button .elementor-button-icon' => 'height: {{SIZE}}{{UNIT}};',
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
                    'size' => 8,
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

        $this->add_control(
            'icon_border_radius',
            [
                'label'      => __('Border Radius', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-button .elementor-button-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        // CONTACT FORM

        $this->start_controls_section(
            'section_lable_style',
            [
                'label'     => __('Lable', 'medilazar-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'contact_slug!' => '',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'label_typography',
                'selector' => '.contactform-content .wpcf7 .wpcf7-form label,.contactform-content .wpcf7 .wpcf7-form .wpcf7-list-item-label',
            ]
        );
        $this->add_control(
            'label_color',
            [
                'label'     => __('Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.contactform-content .wpcf7 .wpcf7-form label ,.contactform-content .wpcf7 .wpcf7-form .wpcf7-list-item-label' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_input_style',
            [
                'label'     => __('Input', 'medilazar-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'contact_slug!' => '',
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'input_typography',
                'selector' => '.contactform-content .wpcf7 .wpcf7-form input:not([type="submit"]), .contactform-content .wpcf7-form textarea',
            ]
        );

        $this->add_control(
            'input_color_placeholder',
            [
                'label'     => __('Placeholder Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.contactform-content .wpcf7 .wpcf7-form input::placeholder, .contactform-content .wpcf7-form textarea::placeholder' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label'     => __('Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.contactform-content .wpcf7 .wpcf7-form input:not([type="submit"]), .contactform-content .wpcf7-form textarea' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_input_style');

        $this->start_controls_tab(
            'tab_input_normal',
            [
                'label' => __('Normal', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'input_background_color',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.contactform-content .wpcf7 .wpcf7-form input:not([type="submit"]), .contactform-content .wpcf7-form textarea' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_input_hover',
            [
                'label' => __('Hover', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'input_background_color_hover',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.contactform-content .wpcf7 .wpcf7-form input:not([type="submit"]):hover, .contactform-content .wpcf7-form textarea:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_border_bottom_color_hover',
            [
                'label'     => __('Border Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.contactform-content .wpcf7 .wpcf7-form input:not([type="submit"]):hover, .contactform-content .wpcf7-form textarea:hover' => 'border-color: {{VALUE}};',
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
            'input_background_color_focus',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.contactform-content .wpcf7 .wpcf7-form input:not([type="submit"]):focus, .contactform-content .wpcf7-form textarea:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_border_bottom_color_focus',
            [
                'label'     => __('Border Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.contactform-content .wpcf7 .wpcf7-form input:not([type="submit"]):focus, .contactform-content .wpcf7-form textarea:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_input',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .wpcf7 .wpcf7-form input:not([type="submit"]), .contactform-content .wpcf7-form textarea',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'input_border_radius',
            [
                'label'      => __('Border Radius', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '.contactform-content .wpcf7 .wpcf7-form input:not([type="submit"]), .contactform-content .wpcf7-form textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_padding',
            [
                'label'      => __('Padding', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '.contactform-content .wpcf7 .wpcf7-form input:not([type="submit"]), .contactform-content .wpcf7-form textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'input_margin',
            [
                'label'      => __('Margin', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '.contactform-content .wpcf7 .wpcf7-form .wpcf7-text, .contactform-content .wpcf7-form .wpcf7-textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_valid_style',
            [
                'label'     => __('Valid', 'medilazar-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'contact_slug!' => '',
                ]
            ]
        );

        $this->add_control(
            'valid_color',
            [
                'label'     => __('Text Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '.contactform-content .wpcf7 .wpcf7-form .wpcf7-not-valid-tip ' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'valid_typography',
                'selector' => '.contactform-content .wpcf7 .wpcf7-form .wpcf7-not-valid-tip ',
            ]
        );

        $this->add_responsive_control(
            'valid_margin',
            [
                'label'      => __('Margin', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '.contactform-content .wpcf7 .wpcf7-form .wpcf7-not-valid-tip' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_seclect_style',
            [
                'label'     => __('Select', 'medilazar-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'contact_slug!' => '',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'select_typography',
                'selector' => '.contactform-content .wpcf7 select',
            ]
        );

        $this->add_control(
            'select_text_color',
            [
                'label'     => __('Text Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '.contactform-content .wpcf7 select'                => 'color: {{VALUE}};',
                    '.contactform-content .wpcf7 [class*="menu"]:after' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'select_bg_color',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '.contactform-content .wpcf7 select' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_select',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '.contactform-content .wpcf7 select',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'select_padding',
            [
                'label'      => __('Padding', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '.contactform-content .wpcf7 select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_style_ctf',
            [
                'label'     => __('Button Submit', 'medilazar-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'contact_slug!' => '',
                ]
            ]
        );

        $this->add_control(
            'button_type_ctf',
            [
                'label'        => __('Type', 'medilazar-core'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'secondary',
                'options'      => [
                    ''                  => __('Default', 'medilazar-core'),
                    'primary'           => __('Primary', 'medilazar-core'),
                    'secondary'         => __('Secondary', 'medilazar-core'),
                    'outline_primary'   => __('Outline Primary', 'medilazar-core'),
                    'outline_secondary' => __('Outline Secondary', 'medilazar-core'),
                ],
                'prefix_class' => 'elementor-wpcf7-button-',
            ]
        );

        $this->add_control(
            'button_size__ctf',
            [
                'label'        => __('Size', 'medilazar-core'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'md',
                'options'      => [
                    'xs' => __('Extra Small', 'medilazar-core'),
                    'sm' => __('Small', 'medilazar-core'),
                    'md' => __('Medium', 'medilazar-core'),
                    'lg' => __('Large', 'medilazar-core'),
                    'xl' => __('Extra Large', 'medilazar-core'),
                ],
                'prefix_class' => 'elementor-wpcf7-button-',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography_ctf',
                'selector' => '.contactform-content .wpcf7 .wpcf7-form input[type="submit"], .contactform-content button',
            ]
        );

        $this->start_controls_tabs('tabs_button_style_ctf');

        $this->start_controls_tab(
            'tab_button_normal_ctf',
            [
                'label' => __('Normal', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'button_text_color_ctf',
            [
                'label'     => __('Text Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '.contactform-content .wpcf7 .wpcf7-form input[type="submit"], .contactform-content button' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'background_color_ctf',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.contactform-content .wpcf7 .wpcf7-form input[type="submit"], .contactform-content button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover_ctf',
            [
                'label' => __('Hover', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'hover_color_ctf',
            [
                'label'     => __('Text Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.contactform-content .wpcf7 .wpcf7-form input[type="submit"]:hover, .contactform-content button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_hover_color_ctf',
            [
                'label'     => __('Background Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.contactform-content .wpcf7 .wpcf7-form input[type="submit"]:hover, .contactform-content button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color_ctf',
            [
                'label'     => __('Border Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '.contactform-content .wpcf7 .wpcf7-form input[type="submit"]:hover, .contactform-content button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_animation_ctf',
            [
                'label' => __('Hover Animation', 'medilazar-core'),
                'type'  => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_ctf',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '.contactform-content .wpcf7 .wpcf7-form input[type="submit"], .contactform-content button',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'button_border_radius_ctf',
            [
                'label'      => __('Border Radius', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '.contactform-content .wpcf7 .wpcf7-form input[type="submit"], .contactform-content button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_box_shadow_ctf',
                'selector' => '.contactform-content .wpcf7 .wpcf7-form input[type="submit"], .contactform-content button',
            ]
        );
        $this->add_responsive_control(
            'align_ctf',
            [
                'label'     => __('Alignment', 'medilazar-core'),
                'type'      => Controls_Manager::CHOOSE,
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
                'selectors' => [
                    '.contactform-content .wpcf7'        => 'text-align: {{VALUE}};',
                    '.contactform-content .wpcf7-submit' => 'width: auto',
                ],
                'default'   => '',
            ]
        );
        $this->add_responsive_control(
            'text_padding_ctf',
            [
                'label'      => __('Padding', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '.contactform-content input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_margin_ctf',
            [
                'label'      => __('Margin', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '.contactform-content input[type="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        // end contact form
    }

    /**
     * Render button widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render(Widget_Base $instance = null) {
        if (empty($instance)) {
            $instance = $this;
        }
        $settings = $instance->get_settings_for_display();

        $this->add_render_attribute('wrapper', 'class', 'elementor-button-wrapper');

        if (!empty($settings['link']['url'])) {
            $this->add_render_attribute('button', 'href', $settings['link']['url']);
            $this->add_render_attribute('button', 'class', 'elementor-button-link');

            if ($settings['link']['is_external']) {
                $this->add_render_attribute('button', 'target', '_blank');
            }

            if ($settings['link']['nofollow']) {
                $this->add_render_attribute('button', 'rel', 'nofollow');
            }
        }

        $this->add_render_attribute('button', 'class', 'elementor-button');
        $this->add_render_attribute('button', 'role', 'button');

        if (!empty($settings['button_css_id'])) {
            $this->add_render_attribute('button', 'id', $settings['button_css_id']);
        }

        if (!empty($settings['size'])) {
            $this->add_render_attribute('button', 'class', 'elementor-size-' . $settings['size']);
        }

        if ($settings['hover_animation']) {
            $this->add_render_attribute('button', 'class', 'elementor-animation-' . $settings['hover_animation']);
        }

        // Contact Form
        $contact = $this->get_contact_id($settings['contact_slug']);
        if ($contact) {
            $this->set_render_attribute('button', 'href', '#opal-contactform-popup-' . esc_attr($this->get_id()));
            $this->add_render_attribute('button', 'data-effect', 'mfp-zoom-in');
            $this->add_render_attribute('wrapper', 'class', 'opal-button-contact7');
        }

        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <a <?php echo $this->get_render_attribute_string('button'); ?>>
                <?php $this->render_text(); ?>
            </a>
        </div>
        <?php

        if ($contact) {
            ?>
            <div id="opal-contactform-popup-<?php echo esc_attr($this->get_id()); ?>"
                 class="mfp-hide contactform-content">
                <div class="heading-form">
                    <div class="form-title"><?php echo esc_html($contact->post_title); ?></div>
                </div>
                <?php echo osf_do_shortcode('contact-form-7', array(
                    'id'    => $contact->ID,
                    'title' => $contact->post_title
                )); ?>
            </div>
            <?php
        }
    }

    /**
     * Render button widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function content_template() {
        ?>
        <#

        view.addRenderAttribute( 'text', 'class', 'elementor-button-text' );

        view.addInlineEditingAttributes( 'text', 'none' );
        #>
        <div class="elementor-button-wrapper">
            <a id="{{ settings.button_css_id }}"
               class="elementor-button elementor-size-{{ settings.size }} elementor-animation-{{ settings.hover_animation }} "
               href="{{ settings.link.url }}" role="button">
				<span class="elementor-button-content-wrapper">
					<# if ( settings.icon ) { #>
					<span class="elementor-button-icon elementor-align-icon-{{ settings.icon_align }}">
						<i class="{{ settings.icon }}" aria-hidden="true"></i>
					</span>
					<# } #>
					<span {{{ view.getRenderAttributeString( 'text' ) }}}>{{{ settings.text }}}</span>
                </span>
            </a>
        </div>
        <?php
    }

    /**
     * Render button text.
     *
     * Render button widget text.
     *
     * @since  1.5.0
     * @access protected
     */
    protected function render_text(Widget_Base $instance = null) {
        if (empty($instance)) {
            $instance = $this;
        }
        $settings = $instance->get_settings_for_display();

        $this->add_render_attribute([
            'content-wrapper' => [
                'class' => 'elementor-button-content-wrapper',
            ],
            'icon-align'      => [
                'class' => [
                    'elementor-button-icon',
                    'elementor-align-icon-' . $settings['icon_align'],
                ],
            ],
            'text'            => [
                'class' => 'elementor-button-text',
            ],
        ]);

        $this->add_inline_editing_attributes('text', 'none');
        ?>
        <span <?php echo $this->get_render_attribute_string('content-wrapper'); ?>>
			<?php if (!empty($settings['icon'])) : ?>
                <span <?php echo $this->get_render_attribute_string('icon-align'); ?>>
				<i class="<?php echo esc_attr($settings['icon']); ?>" aria-hidden="true"></i>
			</span>
            <?php endif; ?>
            <span <?php echo $this->get_render_attribute_string('text'); ?>><?php echo $settings['text']; ?></span>
		</span>


    <?php }

    private function get_contact_id($slug) {
        $contact = get_page_by_path($slug, OBJECT, 'wpcf7_contact_form');
        if ($contact) {
            return $contact;
        }

        return false;
    }


}

$widgets_manager->register(new OSF_Elementor_Widget_Button());