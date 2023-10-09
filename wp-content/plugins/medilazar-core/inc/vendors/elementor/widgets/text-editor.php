<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor text editor widget.
 *
 * Elementor widget that displays a WYSIWYG text editor, just like the WordPress
 * editor.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Text_Editor extends Widget_Text_Editor {

    /**
     * Get widget name.
     *
     * Retrieve text editor widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'text-editor';
    }

    /**
     * Get widget title.
     *
     * Retrieve text editor widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Text Editor', 'medilazar-core' );
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the text editor widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'basic' ];
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return [ 'text', 'editor' ];
    }

    /**
     * Register text editor widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_editor',
            [
                'label' => __( 'Text Editor', 'medilazar-core' ),
            ]
        );

        $this->add_control(
            'editor',
            [
                'label' => '',
                'type' => Controls_Manager::WYSIWYG,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'medilazar-core' ),
            ]
        );

        $this->add_control(
            'drop_cap', [
                'label' => __( 'Drop Cap', 'medilazar-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __( 'Off', 'medilazar-core' ),
                'label_on' => __( 'On', 'medilazar-core' ),
                'prefix_class' => 'elementor-drop-cap-',
                'frontend_available' => true,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => __( 'Text Editor', 'medilazar-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => __( 'Alignment', 'medilazar-core' ),
                'type' => Controls_Manager::CHOOSE,
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
                    'justify' => [
                        'title' => __( 'Justified', 'medilazar-core' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-text-editor' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_link',
            [
                'label' => __( 'Link', 'medilazar-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_link',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} a',
                'separator'   => 'before',
            ]
        );

        $this->start_controls_tabs( 'tabs_link_style' );

        $this->start_controls_tab(
            'tab_link_normal',
            [
                'label' => __( 'Normal', 'medilazar-core' ),
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label' => __( 'Color', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} a:not(:hover)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_background_color',
            [
                'label' => __( 'Background_Color', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_link_hover',
            [
                'label' => __( 'Hover', 'medilazar-core' ),
            ]
        );
        $this->add_control(
            'link_hover_color',
            [
                'label' => __( 'Color', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_hover_background_color',
            [
                'label' => __( 'Background Color', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} a:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'link_hover_border_color',
            [
                'label' => __( 'Border Color', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_drop_cap',
            [
                'label' => __( 'Drop Cap', 'medilazar-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'drop_cap' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'drop_cap_view',
            [
                'label' => __( 'View', 'medilazar-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => __( 'Default', 'medilazar-core' ),
                    'stacked' => __( 'Stacked', 'medilazar-core' ),
                    'framed' => __( 'Framed', 'medilazar-core' ),
                ],
                'default' => 'default',
                'prefix_class' => 'elementor-drop-cap-view-',
                'condition' => [
                    'drop_cap' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'drop_cap_primary_color',
            [
                'label' => __( 'Primary Color', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-drop-cap-view-stacked .elementor-drop-cap' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-drop-cap-view-framed .elementor-drop-cap, {{WRAPPER}}.elementor-drop-cap-view-default .elementor-drop-cap' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                ],
                'condition' => [
                    'drop_cap' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'drop_cap_secondary_color',
            [
                'label' => __( 'Secondary Color', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-drop-cap-view-framed .elementor-drop-cap' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-drop-cap-view-stacked .elementor-drop-cap' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'drop_cap_view!' => 'default',
                ],
            ]
        );

        $this->add_control(
            'drop_cap_size',
            [
                'label' => __( 'Size', 'medilazar-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 5,
                ],
                'range' => [
                    'px' => [
                        'max' => 30,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-drop-cap' => 'padding: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'drop_cap_view!' => 'default',
                ],
            ]
        );

        $this->add_control(
            'drop_cap_space',
            [
                'label' => __( 'Space', 'medilazar-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .elementor-drop-cap' => 'margin-right: {{SIZE}}{{UNIT}};',
                    'body.rtl {{WRAPPER}} .elementor-drop-cap' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'drop_cap_border_radius',
            [
                'label' => __( 'Border Radius', 'medilazar-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
                'default' => [
                    'unit' => '%',
                ],
                'range' => [
                    '%' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-drop-cap' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'drop_cap_border_width', [
                'label' => __( 'Border Width', 'medilazar-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .elementor-drop-cap' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'drop_cap_view' => 'framed',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'drop_cap_typography',
                'selector' => '{{WRAPPER}} .elementor-drop-cap-letter',
                'exclude' => [
                    'letter_spacing',
                ],
                'condition' => [
                    'drop_cap' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render text editor widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $editor_content = $this->get_settings_for_display( 'editor' );

        $editor_content = $this->parse_text_editor( $editor_content );

        $this->add_render_attribute( 'editor', 'class', [ 'elementor-text-editor', 'elementor-clearfix' ] );

        $this->add_inline_editing_attributes( 'editor', 'advanced' );
        ?>
        <div <?php echo $this->get_render_attribute_string( 'editor' ); ?>><?php echo $editor_content; ?></div>
        <?php
    }

    /**
     * Render text editor widget as plain content.
     *
     * Override the default behavior by printing the content without rendering it.
     *
     * @since 1.0.0
     * @access public
     */
    public function render_plain_content() {
        // In plain mode, render without shortcode
        echo $this->get_settings( 'editor' );
    }

    /**
     * Render text editor widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function content_template() {
        ?>
        <#
        view.addRenderAttribute( 'editor', 'class', [ 'elementor-text-editor', 'elementor-clearfix' ] );

        view.addInlineEditingAttributes( 'editor', 'advanced' );
        #>
        <div {{{ view.getRenderAttributeString( 'editor' ) }}}>{{{ settings.editor }}}</div>
        <?php
    }
}

$widgets_manager->register(new OSF_Elementor_Text_Editor());
