<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor image gallery widget.
 *
 * Elementor widget that displays a set of images in an aligned grid.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Image_Gallery extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve image gallery widget name.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'opal-image-gallery';
    }

    /**
     * Get widget title.
     *
     * Retrieve image gallery widget title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Opal Image Gallery', 'medilazar-core');
    }

    public function get_script_depends() {
        return [
            'isotope',
            'imagesloaded',
            'magnific-popup',
            'hoverdir',
        ];
    }

    public function get_style_depends() {
        return ['magnific-popup'];
    }


    /**
     * Get widget icon.
     *
     * Retrieve image gallery widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since  2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['image', 'photo', 'visual', 'gallery'];
    }

    /**
     * Register image gallery widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_gallery',
            [
                'label' => __('Image Gallery', 'medilazar-core'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'filter_title',
            [
                'label'       => __('Filter Title', 'medilazar-core'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => __('List Item', 'medilazar-core'),
                'default'     => __('List Item', 'medilazar-core'),
            ]
        );

        $repeater->add_control(
            'wp_gallery',
            [
                'label'      => __('Add Images', 'medilazar-core'),
                'type'       => Controls_Manager::GALLERY,
                'show_label' => false,
                'dynamic'    => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'filter',
            [
                'label'       => '',
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'filter_title' => __('Gallery 1', 'medilazar-core'),
                    ],
                ],
                'title_field' => '{{{ filter_title }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_layout',
            [
                'label' => __('Layout', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_LAYOUT
            ]
        );

        $this->add_control(
            'show_filter_bar',
            [
                'label'     => __('Filter Bar', 'medilazar-core'),
                'type'      => Controls_Manager::SWITCHER,
                'label_off' => __('Off', 'medilazar-core'),
                'label_on'  => __('On', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'active_infinite_scroll',
            [
                'label'     => __('Infinite Scroll', 'medilazar-core'),
                'type'      => Controls_Manager::SWITCHER,
                'label_off' => __('Off', 'medilazar-core'),
                'label_on'  => __('On', 'medilazar-core'),
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'thumbnail',
                // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
//                'exclude'   => ['custom'],
                'separator' => 'none',
                'default'   => 'maisonco-gallery-image'
            ]
        );


        $this->add_responsive_control(
            'columns',
            [
                'label'   => __('Columns', 'medilazar-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 3,
                'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6],
            ]
        );

        $this->add_responsive_control(
            'gutter',
            [
                'label'      => __('Gutter', 'medilazar-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .column-item' => 'padding-left: calc({{SIZE}}{{UNIT}} / 2); padding-right: calc({{SIZE}}{{UNIT}} / 2); padding-bottom: calc({{SIZE}}{{UNIT}})',
                    '{{WRAPPER}} .row'         => 'margin-left: calc({{SIZE}}{{UNIT}} / -2); margin-right: calc({{SIZE}}{{UNIT}} / -2);',
                ],
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

        $this->start_controls_section(
            'section_gallery_images',
            [
                'label' => __('Images', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'image_spacing',
            [
                'label'        => __('Spacing', 'medilazar-core'),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    ''       => __('Default', 'medilazar-core'),
                    'custom' => __('Custom', 'medilazar-core'),
                ],
                'prefix_class' => 'gallery-spacing-',
                'default'      => '',
            ]
        );

        $columns_margin = is_rtl() ? '0 0 -{{SIZE}}{{UNIT}} -{{SIZE}}{{UNIT}};' : '0 -{{SIZE}}{{UNIT}} -{{SIZE}}{{UNIT}} 0;';
        $columns_padding = is_rtl() ? '0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}};' : '0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0;';

        $this->add_control(
            'image_spacing_custom',
            [
                'label'      => __('Image Spacing', 'medilazar-core'),
                'type'       => Controls_Manager::SLIDER,
                'show_label' => false,
                'range'      => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'size' => 15,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .gallery-item' => 'padding:' . $columns_padding,
                    '{{WRAPPER}} .gallery'      => 'margin: ' . $columns_margin,
                ],
                'condition'  => [
                    'image_spacing' => 'custom',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'image_border',
                'selector'  => '{{WRAPPER}} .gallery-item img',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label'      => __('Border Radius', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .gallery-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_design_filter',
            [
                'label'     => __('Filter Bar', 'medilazar-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_filter_bar' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography_filter',
                'selector' => '{{WRAPPER}} .elementor-galerry__filter',
            ]
        );

        $this->add_control(
            'filter_item_spacing',
            [
                'label'     => __('Space Between', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 5,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-galerry__filter:not(:last-child)'  => 'margin-right: calc({{SIZE}}{{UNIT}}/2)',
                    '{{WRAPPER}} .elementor-galerry__filter:not(:first-child)' => 'margin-left: calc({{SIZE}}{{UNIT}}/2)',
                ],
            ]
        );

        $this->add_responsive_control(
            'filter_spacing',
            [
                'label'     => __('Spacing', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 45,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-galerry__filters' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'filter_padding',
            [
                'label'      => __('Filter Padding', 'medilazar-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-galerry__filters' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'filter_align',
            [
                'label'        => __('Alignment', 'medilazar-core'),
                'type'         => Controls_Manager::CHOOSE,
                'default'      => 'top',
                'options'      => [
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
                    ]
                ],
                'toggle'       => false,
                'prefix_class' => 'elementor-filter-',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render image gallery widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('row', 'class', 'row grid isotope-grid');
        if ($settings['active_infinite_scroll'] == 'yes') {
            $this->add_render_attribute('row', 'class', 'active-infinite-scroll');
        }

        if (!empty($settings['columns'])) {
            $this->add_render_attribute('row', 'data-elementor-columns', $settings['columns']);
        }

        if (!empty($settings['columns_tablet'])) {
            $this->add_render_attribute('row', 'data-elementor-columns-tablet', $settings['columns_tablet']);
        }
        if (!empty($settings['columns_mobile'])) {
            $this->add_render_attribute('row', 'data-elementor-columns-mobile', $settings['columns_mobile']);
        }

        if ($settings['show_filter_bar'] == 'yes') {
            ?>
            <ul class="elementor-galerry__filters"
                data-related="isotope-<?php echo esc_attr($this->get_id()); ?>">
                <li class="elementor-galerry__filter elementor-active"
                    data-filter=".__all"><?php echo __('All', 'medilazar-core'); ?></li>
                <?php foreach ($settings['filter'] as $key => $term) { ?>
                    <li class="elementor-galerry__filter"
                        data-filter=".gallery_group_<?php echo esc_attr($key); ?>"><?php echo $term['filter_title']; ?></li>
                <?php } ?>
            </ul>
            <?php
        }
        ?>

        <div class="elementor-opal-image-gallery">
            <div <?php echo $this->get_render_attribute_string('row') ?>>
                <?php

                if (Plugin::$instance->editor->is_edit_mode()) {
                    $this->add_render_attribute('link', [
                        'class' => 'elementor-clickable',
                    ]);
                }
                $image_gallery = array();
                foreach ($settings['filter'] as $index => $item) {
                    if (!empty($item['wp_gallery'])):
                        foreach ($item['wp_gallery'] as $items => $attachment) {
                            $attachment['thumbnail_url'] = Group_Control_Image_Size::get_attachment_image_src($attachment['id'], 'thumbnail', $settings);
                            $attachment['group'] = $index;
                            $image_gallery[] = $attachment;
                        }
                    endif;
                }
                if ($settings['active_infinite_scroll'] == 'yes') {
                    foreach ($image_gallery as $index => $item) {
                        $image_url = Group_Control_Image_Size::get_attachment_image_src($item['id'], 'thumbnail', $settings);
                        $image_url_full = wp_get_attachment_image_url($item['id'], 'full');

                        if ($index < 10) {
                            ?>
                            <div class="column-item grid__item masonry-item __all <?php echo 'gallery_group_' . esc_attr($item['group']); ?>">
                                <a data-elementor-open-lightbox="no" <?php echo $this->get_render_attribute_string('link'); ?>
                                   href="<?php echo esc_attr($image_url_full); ?>">
                                    <img src="<?php echo esc_attr($image_url); ?>"
                                         alt="<?php echo esc_attr(Control_Media::get_image_alt($item)); ?>"/>
                                    <div class="gallery-item-overlay">
                                        <i class="opal-icon-search"></i>
                                    </div>
                                </a>
                            </div>
                            <?php
                        }
                    }
                } else {
                    foreach ($image_gallery as $index => $item) {
                        $image_url = Group_Control_Image_Size::get_attachment_image_src($item['id'], 'thumbnail', $settings);
                        $image_url_full = wp_get_attachment_image_url($item['id'], 'full');
                        ?>
                        <div class="column-item grid__item masonry-item __all <?php echo 'gallery_group_' . esc_attr($item['group']); ?>">
                            <a data-elementor-open-lightbox="no" <?php echo $this->get_render_attribute_string('link'); ?>
                               href="<?php echo esc_attr($image_url_full); ?>">
                                <img src="<?php echo esc_attr($image_url); ?>"
                                     alt="<?php echo esc_attr(Control_Media::get_image_alt($item)); ?>"/>
                                <div class="gallery-item-overlay">
                                    <i class="opal-icon-search"></i>
                                </div>
                            </a>
                        </div>
                        <?php
                    }
                }
                ?>
            </div> 
        </div>

        <?php if ($settings['active_infinite_scroll'] == 'yes') {
            array_splice($image_gallery, 0, 10);
            $this->add_render_attribute('load-more', 'data-gallery', json_encode(array_chunk($image_gallery, 10, false)));
            ?>
            <div class="gallery-item-load" <?php echo $this->get_render_attribute_string('load-more') ?>></div>
            <?php
        }
    }
}

$widgets_manager->register(new OSF_Elementor_Image_Gallery());
