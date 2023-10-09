<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
if (!osf_is_woocommerce_activated()) {
    return;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Products_Categories extends OSF_Elementor_Carousel_Base {

    public function get_categories() {
        return array('opal-addons');
    }

    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @return string Widget name.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_name() {
        return 'opal-product-categories';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @return string Widget title.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_title() {
        return __('Opal Product Categories', 'medilazar-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @return string Widget icon.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-tabs';
    }


    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_controls() {

        //Section Query
        $this->start_controls_section(
            'section_setting',
            [
                'label' => __('Settings', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'categories_name',
            [
                'label'       => __('Alternate Name', 'medilazar-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Alternate Name',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label'      => __('Choose Image', 'medilazar-core'),
                'default'    => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'type'       => Controls_Manager::MEDIA,
                'show_label' => false,

            ]
        );

        $repeater->add_control(
            'categories',
            [
                'label'       => __('Categories', 'medilazar-core'),
                'type'        => Controls_Manager::SELECT2,
                'options'     => $this->get_product_categories(),
                'multiple'    => false,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'background__categories_item',
            [
                'label'     => __('Background', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:not(.product-cate-style-2.elementor-align-center) {{CURRENT_ITEM}}.elementor-product-categories-item .elementor-product-categories-item-inner' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.product-cate-style-2.elementor-align-center {{CURRENT_ITEM}}.elementor-product-categories-item .elementor-product-categories-item-inner .elementor-product-categories-image' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'categories_items',
            [
                'label'       => __('Categories Items', 'medilazar-core'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'categories_name' => __('Categories #1', 'medilazar-core'),
                        'image'           => [
                            'url' => Elementor\Utils::get_placeholder_image_src()
                        ]
                    ],
                    [
                        'categories_name' => __('Categories #2', 'medilazar-core'),
                        'image'           => [
                            'url' => Elementor\Utils::get_placeholder_image_src()
                        ]
                    ],
                    [
                        'categories_name' => __('Categories #3', 'medilazar-core'),
                        'image'           => [
                            'url' => Elementor\Utils::get_placeholder_image_src()
                        ]
                    ],
                ],
                'title_field' => '{{{ categories_name }}}',
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label'     => __('Columns', 'medilazar-core'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 3,
                'options'   => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7],
                'condition' => [
                    'enable_carousel' => 'yes'
                ]
            ]
        );
        $this->add_responsive_control(
            'columns',
            [
                'label'     => __('Columns', 'medilazar-core'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 3,
                'options'   => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 6 => 6],
                'condition' => [
                    'enable_carousel!' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `testimonial_image_size` and `testimonial_image_custom_dimension`.
                'default'   => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'product_cate_style',
            [
                'label'        => esc_html__('Style', 'medilazar-core'),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    'style-1' => esc_html__('Style 1', 'medilazar-core'),
                    'style-2' => esc_html__('Style 2', 'medilazar-core'),
                    'style-3' => esc_html__('Style 3', 'medilazar-core'),
                ],
                'default'      => 'style-1',
                'prefix_class' => 'product-cate-'
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
                ],
                'condition' => [
                    'product_cate_style' => 'style-2',
                ],
                'prefix_class' => 'elementor%s-align-',
                'default'      => '',
            ]
        );

        $this->add_control(
            'show_total',
            [
                'label'        => esc_html__('Show Total', 'medilazar-core'),
                'type'         => Controls_Manager::SWITCHER,
                'prefix_class' => 'show-total-',
                'default'      => '',
            ]
        );

        $this->add_responsive_control(
            'gutter',
            [
                'label'     => __('Gutter', 'medilazar-core'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-product-categories-wrapper'              => 'margin-left: calc({{SIZE}}{{UNIT}} / -2); margin-right: calc({{SIZE}}{{UNIT}} / -2);',
                    '{{WRAPPER}} .elementor-product-categories-wrapper .column-item' => 'padding-left: calc({{SIZE}}{{UNIT}} / 2); padding-right: calc({{SIZE}}{{UNIT}} / 2); padding-bottom: calc({{SIZE}}{{UNIT}})',
                ],
                'condition' => [
                    'enable_carousel!' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        //STYLE
        $this->start_controls_section(
            'section_wrapper_box_style',
            [
                'label' => __('Box', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_background',
            [
                'label'     => __('Background', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-product-categories-item .elementor-product-categories-item-inner' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'box_padding',
            [
                'label'      => __('Padding', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-product-categories-item .elementor-product-categories-item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label'      => __('Border Radius', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-product-categories-item .elementor-product-categories-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_wrapper_images_style',
            [
                'label' => __('Images', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'Image_width',
            [
                'label'     => __('Width', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-product-categories-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label'          => esc_html__('Height', 'medilazar-core'),
                'type'           => Controls_Manager::SLIDER,
                'default'        => [
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'size_units'     => ['px', 'vh'],
                'range'          => [
                    'px' => [
                        'min' => 1,
                        'max' => 500,
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'condition'      => [
                    'product_cate_style' => 'style-2',
                ],

                'selectors' => [
                    '{{WRAPPER}} .elementor-product-categories-image img' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .layout-2 .category-product-img'         => 'height: 100%;',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_object_fit',
            [
                'label'     => esc_html__('Object Fit', 'medilazar-core'),
                'type'      => Controls_Manager::SELECT,
                'condition' => [
                    'image_height[size]!' => '',
                ],
                'options'   => [
                    ''        => esc_html__('Default', 'medilazar-core'),
                    'fill'    => esc_html__('Fill', 'medilazar-core'),
                    'cover'   => esc_html__('Cover', 'medilazar-core'),
                    'contain' => esc_html__('Contain', 'medilazar-core'),
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-product-categories-image img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label'      => esc_html__('Padding', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-product-categories-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'image_margin',
            [
                'label'      => esc_html__('Margin', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-product-categories-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label'      => __('Border Radius', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-product-categories-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_wrapper_style',
            [
                'label' => __('Content', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'wrapper_pr_cate_padding',
            [
                'label'      => __('Padding', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-product-categories-meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'category_name_typography',
                'selector'  => '{{WRAPPER}} .elementor-product-categories-title',
                'label'     => 'Typography',
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'name_spacing',
            [
                'label'      => esc_html__('Margin', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-product-categories-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_name_style');

        $this->start_controls_tab(
            'tab_name_normal',
            [
                'label' => __('Normal', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label'     => __('Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-product-categories-item-inner .elementor-product-categories-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'total_color',
            [
                'label'     => __('Total Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-product-categories-item-inner .elementor-product-categories-meta .cat-total' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_name_hover',
            [
                'label' => __('Hover', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'name_color_hover',
            [
                'label'     => __('Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-product-categories-item-inner:hover .elementor-product-categories-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'total_color_hover',
            [
                'label'     => __('Total Color Hover', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-product-categories-item-inner:hover .elementor-product-categories-meta .cat-total' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tabs();

        $this->end_controls_section();

        //carousel
        $this->add_control_carousel();

    }


    protected function get_product_categories() {
        $categories = get_terms(array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
            )
        );
        $results    = array();
        if (!is_wp_error($categories)) {
            foreach ($categories as $category) {
                $results[$category->slug] = $category->name;
            }
        }
        return $results;
    }

    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $class_item = '';
        if ($settings['enable_carousel'] === 'yes') {

            $this->add_render_attribute('row', 'class', 'owl-carousel owl-theme');
            $carousel_settings = $this->get_carousel_settings();
            $this->add_render_attribute('row', 'data-settings', wp_json_encode($carousel_settings));

        } else {
            $class_item = 'column-item';
            // Row
            $this->add_render_attribute('row', 'class', 'row');
            $this->add_render_attribute('row', 'data-elementor-columns', $settings['columns']);

            if (!empty($settings['column_tablet'])) {
                $this->add_render_attribute('row', 'data-elementor-columns-tablet', $settings['columns_tablet']);
            }

            if (!empty($settings['column_mobile'])) {
                $this->add_render_attribute('row', 'data-elementor-columns-mobile', $settings['columns_mobile']);
            }
        } ?>
        <div class="elementor-product-categories-wrapper">
            <div <?php echo $this->get_render_attribute_string('row') ?>>
                <?php
                foreach ($settings['categories_items'] as $index => $item):
                    if ($item['categories']) {
                        $category = get_term_by('slug', $item['categories'], 'product_cat');

                        if (!is_wp_error($category) && !empty($category)) {
                            if (!empty($item['image']['id'])) {
                                $item['image_size']             = $settings['image_size'];
                                $item['image_custom_dimension'] = $settings['image_custom_dimension'];
                                $image                          = Group_Control_Image_Size::get_attachment_image_html($item, 'image');
                            } else {
                                $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                                if (!empty($thumbnail_id)) {
                                    $image = '<img src="' . wp_get_attachment_url($thumbnail_id) . '" alt="" >';
                                } else {
                                    $image = '<img src="' . wc_placeholder_img_src() . '" alt="" >';
                                }
                            }

                            $link_key = 'item_' . $index;
                            $this->add_render_attribute($link_key, 'class', [
                                'elementor-repeater-item-' . $item['_id'],
                                'elementor-product-categories-item',
                                $class_item
                            ]);

                            ?>
                            <div <?php echo $this->get_render_attribute_string($link_key); ?>>
                                <div class="elementor-product-categories-item-inner">
                                    <div class="elementor-product-categories-image">
                                        <a href="<?php echo esc_url(get_term_link($category)); ?>" title="<?php echo esc_attr($category->name); ?>"><?php echo $image; ?></a>
                                    </div>
                                    <div class="elementor-product-categories-meta">
                                        <div class="elementor-product-categories-title">
                                            <a href="<?php echo esc_url(get_term_link($category)); ?>" title="<?php echo esc_attr($category->name); ?>">
                                                <span class="elementor-product-categories-title-text"><?php echo empty($item['categories_name']) ? esc_html($category->name) : wp_kses_post($item['categories_name']); ?></span>
                                            </a>
                                        </div>
                                        <div class="cat-total">
                                            <span class="count"><?php echo esc_html($category->count); ?></span>
                                            <span class="text"><?php echo esc_html__('products', 'medilazar-core'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    }
                endforeach; ?>
            </div>
        </div>
        <?php
    }

}

$widgets_manager->register(new OSF_Elementor_Products_Categories());

