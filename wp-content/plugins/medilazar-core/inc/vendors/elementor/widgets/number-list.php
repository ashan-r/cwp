<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor icon list widget.
 *
 * Elementor widget that displays a bullet list with any chosen icons and texts.
 *
 * @since 1.0.0
 */
class OSF_Widget_Number_List extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve icon list widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'number-list';
    }

    /**
     * Get widget title.
     *
     * Retrieve icon list widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Number List', 'medilazar-core' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve icon list widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-bullet-list';
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
        return [ 'number list', 'icon', 'list' ];
    }

    /**
     * Register icon list widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_icon',
            [
                'label' => __( 'Icon List', 'medilazar-core' ),
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => __( 'Layout', 'medilazar-core' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'traditional',
                'options' => [
                    'traditional' => [
                        'title' => __( 'Default', 'medilazar-core' ),
                        'icon' => 'eicon-editor-list-ul',
                    ],
                    'inline' => [
                        'title' => __( 'Inline', 'medilazar-core' ),
                        'icon' => 'eicon-ellipsis-h',
                    ],
                ],
                'render_type' => 'template',
                'classes' => 'elementor-control-start-end',
                'label_block' => false,
                'style_transfer' => true,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'text',
            [
                'label' => __( 'Text', 'medilazar-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => __( 'List Item', 'medilazar-core' ),
                'default' => __( 'List Item', 'medilazar-core' ),
            ]
        );

        $repeater->add_control(
            'number',
            [
                'label' => __( 'Number', 'medilazar-core' ),
                'type' => Controls_Manager::NUMBER,
                'label_block' => true,
                'default' => '1',
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => __( 'Link', 'medilazar-core' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'placeholder' => __( 'https://your-link.com', 'medilazar-core' ),
            ]
        );

        $this->add_control(
            'number_list',
            [
                'label' => '',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'text' => __( 'List Item #1', 'medilazar-core' ),
                        'number' => '1',
                    ],
                    [
                        'text' => __( 'List Item #2', 'medilazar-core' ),
                        'number' => '2',
                    ],
                    [
                        'text' => __( 'List Item #3', 'medilazar-core' ),
                        'number' => '3',
                    ],
                ],
                'title_field' => '{{ number }} {{{ text }}}',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_number_list',
            [
                'label' => __( 'List', 'medilazar-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_list_item',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-number-list-item',
            ]
        );

        $this->add_control(
            'list_item_border_radius',
            [
                'label'      => __( 'Border Radius', 'medilazar-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-number-list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_item_padding',
            [
                'label'      => __( 'Padding', 'medilazar-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-number-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'list_item_margin',
            [
                'label'      => __( 'Margin', 'medilazar-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-number-list-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'number_align',
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
                ],
                'prefix_class' => 'elementor%s-align-',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'number_position',
            [
                'label' => __( 'Position', 'medilazar-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Above', 'medilazar-core' ),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'medilazar-core' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => __( 'Below', 'medilazar-core' ),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-number-list-item,{{WRAPPER}} .elementor-number-list-item a' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_number_style',
            [
                'label' => __( 'Number', 'medilazar-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'number_font_size',
            [
                'label' => __( 'Font Size', 'medilazar-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 14,
                ],
                'range' => [
                    'px' => [
                        'min' => 6,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-number-list-number' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'number_size',
            [
                'label' => __( 'Font Size', 'medilazar-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-number-list-number' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_icon',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-number-list-number',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'number_border_radius',
            [
                'label'      => __( 'Border Radius', 'medilazar-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-number-list-number' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'number_margin',
            [
                'label'      => __( 'Margin', 'medilazar-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-number-list-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_number_style' );

        $this->start_controls_tab(
            'tab_number_normal',
            [
                'label' => __( 'Normal', 'medilazar-core' ),
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label' => __( 'Color', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-number-list .elementor-number-list-item:not(:hover)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_number_hover',
            [
                'label' => __( 'Hover', 'medilazar-core' ),
            ]
        );

        $this->add_control(
            'number_color_hover',
            [
                'label' => __( 'Color', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-number-list .elementor-number-list-item:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'number_border_color_hover',
            [
                'label' => __( 'Border Color', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-number-list-item:hover .elementor-number-list-number' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_text_style',
            [
                'label' => __( 'Text', 'medilazar-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_indent',
            [
                'label' => __( 'Text Indent', 'medilazar-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-number-list-text' => is_rtl() ? 'margin-right: {{SIZE}}{{UNIT}};' : 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'number_typography',
                'selector' => '{{WRAPPER}} .elementor-number-list-item',
            ]
        );

        $this->start_controls_tabs( 'tabs_text_style' );

        $this->start_controls_tab(
            'tab_text_normal',
            [
                'label' => __( 'Normal', 'medilazar-core' ),
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-number-list .elementor-number-list-item:not(:hover) .elementor-number-list-text' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-text-underline-yes .elementor-number-list-item:not(:hover) .elementor-number-list-text:before' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_text_hover',
            [
                'label' => __( 'Hover', 'medilazar-core' ),
            ]
        );

        $this->add_control(
            'text_color_hover',
            [
                'label' => __( 'Hover', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-number-list .elementor-number-list-item:hover .elementor-number-list-text' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}}.elementor-text-underline-yes .elementor-number-list-item:hover .elementor-number-list-text:before' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'text_underline',
            [
                'label' => __( 'Show Underline', 'medilazar-core' ),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'prefix_class'  => 'elementor-text-underline-'
            ]
        );

        $this->add_responsive_control(
            'text_underline_spacing',
            [
                'label' => __( 'Underline spacing', 'medilazar-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -10,
                        'max'   => 10,
                        'step'  => 1
                    ],
                ],
                'condition' => [
                        'text_underline'    => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-text-underline-yes  .elementor-number-list-text:before' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render icon list widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'number_list', 'class', 'elementor-number-list-items' );
        $this->add_render_attribute( 'list_item', 'class', 'elementor-number-list-item' );

        if ( 'inline' === $settings['view'] ) {
            $this->add_render_attribute( 'number_list', 'class', 'elementor-inline-items' );
            $this->add_render_attribute( 'list_item', 'class', 'elementor-inline-item' );
        }
        ?>
        <ul <?php echo $this->get_render_attribute_string( 'number_list' ); ?>>
            <?php
            foreach ( $settings['number_list'] as $index => $item ) :
                $repeater_setting_key = $this->get_repeater_setting_key( 'text', 'number_list', $index );

                $this->add_render_attribute( $repeater_setting_key, 'class', 'elementor-number-list-text' );

                $this->add_inline_editing_attributes( $repeater_setting_key );
                ?>
                <li class="elementor-number-list-item" >
                    <?php
                    if ( ! empty( $item['link']['url'] ) ) {
                        $link_key = 'link_' . $index;

                        $this->add_render_attribute( $link_key, 'href', $item['link']['url'] );

                        if ( $item['link']['is_external'] ) {
                            $this->add_render_attribute( $link_key, 'target', '_blank' );
                        }

                        if ( $item['link']['nofollow'] ) {
                            $this->add_render_attribute( $link_key, 'rel', 'nofollow' );
                        }

                        echo '<a ' . $this->get_render_attribute_string( $link_key ) . '>';
                    }

                    if ( ! empty( $item['number'] ) ) :
                        ?>
                        <span class="elementor-number-list-number">
                            <?php echo esc_attr( $item['number'] ); ?>
<!--							<i class="--><?php //echo esc_attr( $item['number'] ); ?><!--" aria-hidden="true"></i>-->
						</span>
                    <?php endif; ?>
                    <span <?php echo $this->get_render_attribute_string( $repeater_setting_key ); ?>><?php echo $item['text']; ?></span>
                    <?php if ( ! empty( $item['link']['url'] ) ) : ?>
                        </a>
                    <?php endif; ?>
                </li>
            <?php
            endforeach;
            ?>
        </ul>
        <?php
    }
}
$widgets_manager->register(new OSF_Widget_Number_List());