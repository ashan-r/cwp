<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
if (!osf_is_woocommerce_activated()) {
    return;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Products extends OSF_Elementor_Carousel_Base {


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
        return 'opal-products';
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
        return __('Opal Products', 'medilazar-core');
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

    public function get_script_depends() {
        return [
            'imagesloaded',
        ];
    }


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


        $this->add_control(
            'limit',
            [
                'label'   => __('Posts Per Page', 'medilazar-core'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label'     => __('columns', 'medilazar-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 3,
                'options'   => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7],
                'condition' => [
                    'product_layout!' => 'masonry'
                ]
            ]
        );


        $this->add_control(
            'advanced',
            [
                'label' => __('Advanced', 'medilazar-core'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'   => __('Order By', 'medilazar-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date'       => __('Date', 'medilazar-core'),
                    'id'         => __('Post ID', 'medilazar-core'),
                    'menu_order' => __('Menu Order', 'medilazar-core'),
                    'popularity' => __('Number of purchases', 'medilazar-core'),
                    'rating'     => __('Average Product Rating', 'medilazar-core'),
                    'title'      => __('Product Title', 'medilazar-core'),
                    'rand'       => __('Random', 'medilazar-core'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => __('Order', 'medilazar-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'asc'  => __('ASC', 'medilazar-core'),
                    'desc' => __('DESC', 'medilazar-core'),
                ],
            ]
        );

        $this->add_control(
            'categories',
            [
                'label'    => __('Categories', 'medilazar-core'),
                'type'     => Controls_Manager::SELECT2,
                'options'  => $this->get_product_categories(),
                'multiple' => true,
            ]
        );

        $this->add_control(
            'cat_operator',
            [
                'label'     => __('Category Operator', 'medilazar-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'IN',
                'options'   => [
                    'AND'    => __('AND', 'medilazar-core'),
                    'IN'     => __('IN', 'medilazar-core'),
                    'NOT IN' => __('NOT IN', 'medilazar-core'),
                ],
                'condition' => [
                    'categories!' => ''
                ],
            ]
        );

        $this->add_control(
            'product_type',
            [
                'label'   => __('Product Type', 'medilazar-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'newest',
                'options' => [
                    'newest'       => __('Newest Products', 'medilazar-core'),
                    'on_sale'      => __('On Sale Products', 'medilazar-core'),
                    'best_selling' => __('Best Selling', 'medilazar-core'),
                    'top_rated'    => __('Top Rated', 'medilazar-core'),
                    'featured'     => __('Featured Product', 'medilazar-core'),
                ],
            ]
        );

        $this->add_control(
            'show_time_sale',
            [
                'label'        => __('Show Time Sale', 'medilazar-core'),
                'type'         => Controls_Manager::SWITCHER,
                'condition'    => [
                    'product_type' => 'on_sale',
                ],
                'prefix_class' => 'elementor-product-time-sale-'
            ]
        );

        $this->add_control(
            'paginate',
            [
                'label'   => __('Paginate', 'medilazar-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none'       => __('None', 'medilazar-core'),
                    'pagination' => __('Pagination', 'medilazar-core'),
                ],
            ]
        );

        $this->add_control(
            'product_layout',
            [
                'label'   => __('Product Layout', 'medilazar-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid' => __('Grid', 'medilazar-core'),
                    'list' => __('List', 'medilazar-core')
                ],
            ]
        );

        $this->add_control(
            'grid_layout',
            [
                'label'     => __('Grid Layout', 'medilazar-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '1',
                'options'   => [
                    '1' => __('Style 1', 'medilazar-core'),
                    '2' => __('Style 2', 'medilazar-core'),
                ],
                'condition' => [
                    'product_layout' => 'grid'
                ]
            ]
        );

        $this->add_control(
            'list_layout',
            [
                'label'     => __('List Layout', 'medilazar-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '1',
                'options'   => [
                    '1' => __('Style 1', 'medilazar-core'),
                    '2' => __('Style 2', 'medilazar-core'),
                    '3' => __('Style 3', 'medilazar-core'),
                ],
                'condition' => [
                    'product_layout' => 'list'
                ]
            ]
        );

        $this->add_responsive_control(
            'product_gutter',
            [
                'label'      => __('Gutter', 'medilazar-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} ul.products li' => 'padding-left: calc({{SIZE}}{{UNIT}} / 2); padding-right: calc({{SIZE}}{{UNIT}} / 2);',
                    '{{WRAPPER}} ul.products'    => 'margin-left: calc({{SIZE}}{{UNIT}} / -2); margin-right: calc({{SIZE}}{{UNIT}} / -2);',
                ],
                'condition'  => [
                    'enable_carousel!' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();
        // End Section Query

        $this->start_controls_section(
            'products_title_style',
            [
                'label' => __('Title', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'product_title_typo',
                'selector' => '{{WRAPPER}} .product .woocommerce-loop-product__title',

            ]
        );

        $this->add_control(
            'product_title_color',
            [
                'label'     => __('Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .product .woocommerce-loop-product__title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'product_title_spacing',
            [
                'label'     => __('Spacing', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .product .woocommerce-loop-product__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'products_price_style',
            [
                'label' => __('Price', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'products_price_typo',
                'selector' => '{{WRAPPER}} ul.products li.product .price',

            ]
        );

        $this->add_control(
            'products_price_color',
            [
                'label'     => __('Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ul.products li.product .price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Carousel Option
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

    protected function get_product_type($atts, $product_type) {
        switch ($product_type) {
            case 'featured':
                $atts['visibility'] = "featured";
                break;

            case 'on_sale':
                $atts['on_sale'] = true;
                break;

            case 'best_selling':
                $atts['best_selling'] = true;
                break;

            case 'top_rated':
                $atts['top_rated'] = true;
                break;

            default:
                break;
        }

        return $atts;
    }

    protected function get_column() {
        $settings = $this->get_settings_for_display();
        $option   = [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6];
        if ($settings['enable_carousel'] === 'yes') {
            $option = [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7];
        }
        return $option;
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
        $this->woocommerce_default($settings);
    }

    private function woocommerce_default($settings) {
        $type = 'products';
        $atts = [
            'limit'          => $settings['limit'],
            'columns'        => $settings['column'],
            'orderby'        => $settings['orderby'],
            'order'          => $settings['order'],
            'product_layout' => $settings['product_layout'],
            'class'          => 'elementor-product-style-' . $settings['product_layout'],
        ];

        if ($settings['product_layout'] == 'grid') {
            $atts['class']          = 'woocommerce-product-grid';
            $atts['product_layout'] = 'grid';

            if (!empty($settings['grid_layout'])) {
                $atts['class'] .= ' woocommerce-product-grid-' . $settings['grid_layout'];
            }
        }

        if ($settings['product_layout'] == 'list') {
            $atts['class']          = 'woocommerce-product-list';
            $atts['product_layout'] = 'grid';

            if (!empty($settings['list_layout'])) {
                $atts['class'] .= ' woocommerce-product-list-' . $settings['list_layout'];
            }

            if (!empty($settings['list_layout']) && $settings['list_layout'] == 3) {
                $atts['product_layout'] = 'list';
                $atts['show_rating']    = true;
            }
        }

        $atts = $this->get_product_type($atts, $settings['product_type']);

        if (isset($atts['on_sale']) && wc_string_to_bool($atts['on_sale'])) {
            $type = 'sale_products';
            if (!empty($settings['show_time_sale']) && $settings['show_time_sale'] == 'yes') {
                $atts['show_time_sale'] = true;
            }
        } elseif (isset($atts['best_selling']) && wc_string_to_bool($atts['best_selling'])) {
            $type = 'best_selling_products';
        } elseif (isset($atts['top_rated']) && wc_string_to_bool($atts['top_rated'])) {
            $type = 'top_rated_products';
        }

        if (!empty($settings['categories'])) {
            $atts['category']     = implode(',', $settings['categories']);
            $atts['cat_operator'] = $settings['cat_operator'];
        }

        // Carousel
        if ($settings['enable_carousel'] === 'yes') {
            $atts['carousel_settings'] = json_encode(wp_slash($this->get_carousel_settings()));
            $atts['enable_carousel']   = 'yes';

        } else {

            if (!empty($settings['column_tablet'])) {
                $atts['class'] .= ' columns-tablet-' . $settings['column_tablet'];
            }

            if (!empty($settings['column_mobile'])) {
                $atts['class'] .= ' columns-mobile-' . $settings['column_mobile'];
            }
        }

        if ($settings['paginate'] === 'pagination') {
            $atts['paginate'] = 'true';
        }

        $shortcode = new WC_Shortcode_Products($atts, $type);

        echo $shortcode->get_content();
    }
}

$widgets_manager->register(new OSF_Elementor_Products());