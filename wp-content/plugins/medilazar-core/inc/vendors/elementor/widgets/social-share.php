<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class OSF_Element_Social_Share extends Elementor\Widget_Base {

    public function get_name() {
        // `theme` prefix is to avoid conflicts with a dynamic-tag with same name.
        return 'opal-social-share';
    }

    public function get_title() {
        return __('Opal Social Share', 'medilazar-core');
    }

    public function get_icon() {
        return 'eicon-share';
    }

    public function get_categories() {
        return ['opal-addons'];
    }

    public function socials() {
        return [
            'facebook'  => esc_html__('Facebook', 'medilazar-core'),
            'twitter'   => esc_html__('Twitter', 'medilazar-core'),
            'linkedin'  => esc_html__('LinkedIn', 'medilazar-core'),
            'pinterest' => esc_html__('Pinterest', 'medilazar-core'),
            'tumblr'    => esc_html__('Tumblr', 'medilazar-core'),
            'email'     => esc_html__('Email', 'medilazar-core'),
            'google'    => esc_html__('Google', 'medilazar-core'),
        ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_buttons_content',
            [
                'label' => __('Share Buttons', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'socials',
            [
                'label'    => __('Select Socials', 'medilazar-core'),
                'type'     => Controls_Manager::SELECT2,
                'options'  => $this->socials(),
                'multiple' => true,
            ]
        );


        $this->add_control(
            'view',
            [
                'label'        => __('View', 'medilazar-core'),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    'icon-text' => 'Icon & Text',
                    'icon'      => 'Icon',
                    'text'      => 'Text',
                ],
                'default'      => 'icon-text',
                'separator'    => 'before',
                'prefix_class' => 'elementor-share-buttons--view-',
                'render_type'  => 'template',
            ]
        );

        $this->add_control(
            'show_label',
            [
                'label'     => __('Label', 'medilazar-core'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __('Show', 'medilazar-core'),
                'label_off' => __('Hide', 'medilazar-core'),
                'default'   => 'yes',
                'condition' => [
                    'view' => 'icon-text',
                ],
            ]
        );

        $this->add_control(
            'skin',
            [
                'label'        => __('Skin', 'medilazar-core'),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    'gradient' => __('Gradient', 'medilazar-core'),
                    'minimal'  => __('Minimal', 'medilazar-core'),
                    'framed'   => __('Framed', 'medilazar-core'),
                    'boxed'    => __('Boxed Icon', 'medilazar-core'),
                    'flat'     => __('Flat', 'medilazar-core'),
                ],
                'default'      => 'gradient',
                'prefix_class' => 'elementor-share-buttons--skin-',
            ]
        );

        $this->add_control(
            'shape',
            [
                'label'        => __('Shape', 'medilazar-core'),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    'square'  => __('Square', 'medilazar-core'),
                    'rounded' => __('Rounded', 'medilazar-core'),
                    'circle'  => __('Circle', 'medilazar-core'),
                ],
                'default'      => 'square',
                'prefix_class' => 'elementor-share-buttons--shape-',
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label'        => __('Columns', 'medilazar-core'),
                'type'         => Controls_Manager::SELECT,
                'default'      => '0',
                'options'      => [
                    '0' => 'Auto',
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
                'prefix_class' => 'elementor-grid%s-',
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label'        => __('Alignment', 'medilazar-core'),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'left'    => [
                        'title' => __('Left', 'medilazar-core'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'  => [
                        'title' => __('Center', 'medilazar-core'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'   => [
                        'title' => __('Right', 'medilazar-core'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justify', 'medilazar-core'),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'prefix_class' => 'elementor-share-buttons%s--align-',
                'condition'    => [
                    'columns' => '0',
                ],
            ]
        );

        $this->add_control(
            'share_url_type',
            [
                'label'     => __('Target URL', 'medilazar-core'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'current_page' => __('Current Page', 'medilazar-core'),
                    'custom'       => __('Custom', 'medilazar-core'),
                ],
                'default'   => 'current_page',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'share_url',
            [
                'label'              => __('Link', 'medilazar-core'),
                'type'               => Controls_Manager::URL,
                'options'            => false,
                'placeholder'        => __('https://your-link.com', 'medilazar-core'),
                'condition'          => [
                    'share_url_type' => 'custom',
                ],
                'show_label'         => false,
                'frontend_available' => true,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_buttons_style',
            [
                'label' => __('Share Buttons', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'column_gap',
            [
                'label'     => __('Columns Gap', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}}'          => '--grid-side-margin: {{SIZE}}{{UNIT}}; --grid-column-gap: {{SIZE}}{{UNIT}}; --grid-row-gap: {{SIZE}}{{UNIT}}',
                    '(tablet) {{WRAPPER}}' => '--grid-side-margin: {{SIZE}}{{UNIT}}; --grid-column-gap: {{SIZE}}{{UNIT}}',
                    '(mobile) {{WRAPPER}}' => '--grid-side-margin: {{SIZE}}{{UNIT}}; --grid-column-gap: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'row_gap',
            [
                'label'     => __('Rows Gap', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}}'          => '--grid-row-gap: {{SIZE}}{{UNIT}}; --grid-bottom-margin: {{SIZE}}{{UNIT}}',
                    '(tablet) {{WRAPPER}}' => '--grid-row-gap: {{SIZE}}{{UNIT}}; --grid-bottom-margin: {{SIZE}}{{UNIT}}',
                    '(mobile) {{WRAPPER}}' => '--grid-row-gap: {{SIZE}}{{UNIT}}; --grid-bottom-margin: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_size',
            [
                'label'     => __('Button Size', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min'  => 0.5,
                        'max'  => 2,
                        'step' => 0.05,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-share-btn' => 'font-size: calc({{SIZE}}{{UNIT}} * 10);',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'          => __('Icon Size', 'medilazar-core'),
                'type'           => Controls_Manager::SLIDER,
                'range'          => [
                    'em' => [
                        'min'  => 0.5,
                        'max'  => 4,
                        'step' => 0.1,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'        => [
                    'unit' => 'em',
                ],
                'tablet_default' => [
                    'unit' => 'em',
                ],
                'mobile_default' => [
                    'unit' => 'em',
                ],
                'size_units'     => ['em', 'px'],
                'selectors'      => [
                    '{{WRAPPER}} .elementor-share-btn__icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition'      => [
                    'view!' => 'text',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_height',
            [
                'label'          => __('Button Height', 'medilazar-core'),
                'type'           => Controls_Manager::SLIDER,
                'range'          => [
                    'em' => [
                        'min'  => 1,
                        'max'  => 7,
                        'step' => 0.1,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'        => [
                    'unit' => 'em',
                ],
                'tablet_default' => [
                    'unit' => 'em',
                ],
                'mobile_default' => [
                    'unit' => 'em',
                ],
                'size_units'     => ['em', 'px'],
                'selectors'      => [
                    '{{WRAPPER}} .elementor-share-btn' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'border_size',
            [
                'label'      => __('Border Size', 'medilazar-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'default'    => [
                    'size' => 2,
                ],
                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                    'em' => [
                        'max'  => 2,
                        'step' => 0.1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-share-btn' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'skin' => ['framed', 'boxed'],
                ],
            ]
        );

        $this->add_control(
            'color_source',
            [
                'label'        => __('Color', 'medilazar-core'),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    'official' => __('Official', 'medilazar-core'),
                    'custom'   => __('Custom', 'medilazar-core'),
                ],
                'default'      => 'official',
                'prefix_class' => 'elementor-share-buttons--color-',
                'separator'    => 'before',
            ]
        );

        $this->start_controls_tabs(
            'tabs_button_style',
            [
                'condition' => [
                    'color_source' => 'custom',
                ],
            ]
        );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __('Normal', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'primary_color',
            [
                'label'     => __('Primary Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-share-buttons--skin-flat .elementor-share-btn,
					 {{WRAPPER}}.elementor-share-buttons--skin-gradient .elementor-share-btn,
					 {{WRAPPER}}.elementor-share-buttons--skin-boxed .elementor-share-btn .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-minimal .elementor-share-btn .elementor-share-btn__icon' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}}.elementor-share-buttons--skin-framed .elementor-share-btn,
					 {{WRAPPER}}.elementor-share-buttons--skin-minimal .elementor-share-btn,
					 {{WRAPPER}}.elementor-share-buttons--skin-boxed .elementor-share-btn'          => 'color: {{VALUE}}; border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'secondary_color',
            [
                'label'     => __('Secondary Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-share-buttons--skin-flat .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-flat .elementor-share-btn__text,
					 {{WRAPPER}}.elementor-share-buttons--skin-gradient .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-gradient .elementor-share-btn__text,
					 {{WRAPPER}}.elementor-share-buttons--skin-boxed .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-minimal .elementor-share-btn__icon' => 'color: {{VALUE}}',
                ],
                'separator' => 'after',
                'condition' => [
                    'skin!' => 'framed',
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
            'primary_color_hover',
            [
                'label'     => __('Primary Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-share-buttons--skin-flat .elementor-share-btn:hover,
					 {{WRAPPER}}.elementor-share-buttons--skin-gradient .elementor-share-btn:hover'                                               => 'background-color: {{VALUE}}',
                    '{{WRAPPER}}.elementor-share-buttons--skin-framed .elementor-share-btn:hover,
					 {{WRAPPER}}.elementor-share-buttons--skin-minimal .elementor-share-btn:hover,
					 {{WRAPPER}}.elementor-share-buttons--skin-boxed .elementor-share-btn:hover'                              => 'color: {{VALUE}}; border-color: {{VALUE}}',
                    '{{WRAPPER}}.elementor-share-buttons--skin-boxed .elementor-share-btn:hover .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-minimal .elementor-share-btn:hover .elementor-share-btn__icon' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'secondary_color_hover',
            [
                'label'     => __('Secondary Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-share-buttons--skin-flat .elementor-share-btn:hover .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-flat .elementor-share-btn:hover .elementor-share-btn__text,
					 {{WRAPPER}}.elementor-share-buttons--skin-gradient .elementor-share-btn:hover .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-gradient .elementor-share-btn:hover .elementor-share-btn__text,
					 {{WRAPPER}}.elementor-share-buttons--skin-boxed .elementor-share-btn:hover .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-minimal .elementor-share-btn:hover .elementor-share-btn__icon' => 'color: {{VALUE}}',
                ],
                'separator' => 'after',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'selector' => '{{WRAPPER}} .elementor-share-btn__title',
                'exclude'  => ['line_height'],
            ]
        );

        $this->add_control(
            'text_padding',
            [
                'label'      => __('Text Padding', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} a.elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
                'condition'  => [
                    'view' => 'text',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_active_settings();
        if (empty($settings['socials'])) {
            return;
        }

        $button_classes = 'elementor-share-btn';

        $show_text = 'text' === $settings['view'] || 'yes' === $settings['show_label'];
        ?>
        <div class="elementor-grid">
            <?php foreach ($settings['socials'] as $button) {

                $network_name         = $button;
                $social_network_class = ' elementor-share-btn_' . $network_name;

                if ('email' == $button):
                    $button = 'envelope';
                    $title  = 'Email';
                else:
                    $title = $button;
                endif;
                ?>
                <div class="elementor-grid-item">
                    <a href="<?php $this->render_html_social($button) ?>">
                        <div class="<?php echo esc_attr($button_classes . $social_network_class); ?>">

                            <?php if ('icon' === $settings['view'] || 'icon-text' === $settings['view']) : ?>
                                <span class="elementor-share-btn__icon">
								<i class="fa fa-<?php echo str_replace('_', '-', $button); ?>"></i>
								<span class="elementor-screen-only"><?php echo sprintf(__('Share on %s', 'medilazar-core'), $network_name); ?></span>
							</span>
                            <?php endif; ?>
                            <?php if ($show_text) : ?>
                                <div class="elementor-share-btn__text">
                                    <?php if ('yes' === $settings['show_label'] || 'text' === $settings['view']) : ?>
                                        <span class="elementor-share-btn__title">
										<?php echo $title; ?>
									</span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
        <?php
    }

    public function render_html_social($key) {
        $ssl = is_ssl() ? 'https://' : 'http://';
        switch ($key) {
            case 'facebook':
                echo $ssl . 'facebook.com/sharer.php?s=100&p&#91;url&#93;=' . get_the_permalink() . '&p&#91;title&#93;=' . get_the_title();
                break;

            case 'twitter':
                echo $ssl . 'twitter.com/home?status=' . get_the_permalink();
                break;

            case 'linkedin':
                echo $ssl . 'linkedin.com/shareArticle?mini=true&amp;url=' . get_the_permalink() . '&amp;title=' . get_the_title();
                break;

            case 'tumblr':
                echo $ssl . 'tumblr.com/share/link?url=' . urlencode(get_permalink()) . '&amp;name=' . urlencode(get_the_title()) . '&amp;description=' . urlencode(get_the_excerpt());
                break;

            case 'google_plus':
                echo $ssl . 'plus.google.com/share?url=' . get_the_permalink();
                break;

            case 'pinterest':
                echo $ssl . 'pinterest.com/pin/create/button/?url=' . urlencode(get_permalink()) . '&amp;description=' . urlencode(get_the_title());
                break;

            case 'envelope':
                echo 'mailto:?subject=' . get_the_title() . '&amp;body=' . get_the_permalink();
                break;
        }
    }
}

$widgets_manager->register(new OSF_Element_Social_Share());

