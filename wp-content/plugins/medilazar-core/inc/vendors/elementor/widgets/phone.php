<?php
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class OSF_Elementor_Phone extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-phone';
    }

    public function get_title() {
        return __('Opal Phone', 'medilazar-core');
    }

    public function get_categories() {
        return array('opal-addons');
    }


    protected function register_controls() {
        $this->start_controls_section(
            'section_phone',
            [
                'label' => __('Phone', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'phone',
            [
                'label'       => __('Phone', 'medilazar-core'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __('Enter your phone', 'medilazar-core'),
                'default'     => __('844 1800 33 555', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __( 'Choose Icon', 'medilazar-core' ),
                'type' => Controls_Manager::ICON,
                'default' => 'fa fa-phone',
            ]
        );

        $this->add_control(
            'title',
            [
                'label'       => __('Title', 'medilazar-core'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __('Enter your title', 'medilazar-core'),
                'default'     => __('Make a call', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label'       => __('Sub Title', 'medilazar-core'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __('Enter your sub title', 'medilazar-core'),
                'default'     => __('+844 1800 33 555', 'medilazar-core'),
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
                ],
                'prefix_class' => 'elementor%s-align-',
                'separator'   => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_style',
            [
                'label' => __( 'Icon', 'medilazar-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_font_size',
            [
                'label' => __( 'Font Size', 'medilazar-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 14,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label'      => __( 'Margin', 'medilazar-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_icon_style' );

        $this->start_controls_tab(
            'tab_icon_normal',
            [
                'label' => __( 'Normal', 'medilazar-core' ),
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __( 'Color', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:not(:hover) i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            [
                'label' => __( 'Hover', 'medilazar-core' ),
            ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label' => __( 'Color', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => __( 'Title', 'medilazar-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_spacing',
            [
                'label' => __( 'Spacing', 'medilazar-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-phone-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .elementor-phone-title',

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
                'label' => __( 'Color', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:not(:hover) .elementor-phone-title' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}}:hover .elementor-phone-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        $this->start_controls_section(
            'section_subtitle_style',
            [
                'label' => __( 'Sub Title', 'medilazar-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'selector' => '{{WRAPPER}} .elementor-phone-subtitle',
            ]
        );

        $this->start_controls_tabs( 'tabs_subtitle_style' );

        $this->start_controls_tab(
            'tab_subtitle_normal',
            [
                'label' => __( 'Normal', 'medilazar-core' ),
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label' => __( 'Color', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:not(:hover) .elementor-phone-subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_subtitle_hover',
            [
                'label' => __( 'Hover', 'medilazar-core' ),
            ]
        );

        $this->add_control(
            'subtitle_color_hover',
            [
                'label' => __( 'Hover', 'medilazar-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .elementor-phone-subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'phone_item', 'class', 'elementor-phone' );
        $this->add_render_attribute( 'phone_link', 'class', 'elementor-phone-link' );
        $this->add_render_attribute( 'phone_title', 'class', 'elementor-phone-title' );
        $this->add_render_attribute( 'phone_sub_title', 'class', 'elementor-phone-subtitle' );

        if ( ! empty( $settings['icon'] ) ) {
            $this->add_render_attribute( 'icon', 'class', $settings['icon'] );
            $this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
        }

        ?>

        <div <?php echo $this->get_render_attribute_string( 'phone_item' ); ?>>
            <i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
            <div class="phone-box">
                <?php
                if ( ! empty( $settings['title'] ) ) {
                    ?>
                    <span <?php echo $this->get_render_attribute_string( 'phone_title' ); ?>>
                    <?php echo $settings['title']; ?>
                </span>
                    <?php
                }
                if ( ! empty( $settings['sub_title'] ) ) {
                    ?>
                    <span <?php echo $this->get_render_attribute_string( 'phone_sub_title' ); ?>>
                    <?php echo $settings['sub_title']; ?>
                </span>
                    <?php
                }
                ?>
            </div>
            <a href="tel:<?php echo esc_attr(preg_replace('/\s+/m', '', $settings['phone'])); ?>" <?php echo $this->get_render_attribute_string( 'phone_link' ); ?>></a>
        </div>

        <?php
    }

}
$widgets_manager->register(new OSF_Elementor_Phone());