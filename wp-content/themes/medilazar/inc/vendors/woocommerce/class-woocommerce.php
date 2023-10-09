<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('medilazar_WooCommerce')) :


    class medilazar_WooCommerce {

        static $instance;

        /**
         * @var array
         */
        public $list_shortcodes;

        private $list_size = 'shop_thumbnail';

        /**
         * @return medilazar_WooCommerce
         */
        public static function getInstance() {
            if (!isset(self::$instance) && !(self::$instance instanceof medilazar_WooCommerce)) {
                self::$instance = new medilazar_WooCommerce();
            }

            return self::$instance;
        }

        /**
         * Setup class.
         *
         * @since 1.0
         *
         */
        public function __construct() {
            $this->list_shortcodes = array(
                'recent_products',
                'sale_products',
                'best_selling_products',
                'top_rated_products',
                'featured_products',
                'related_products',
                'product_category',
                'products',
            );
            $this->init_shortcodes();

            add_action('after_setup_theme', array($this, 'after_setup_theme'));

            add_filter('body_class', array($this, 'body_class'));
            add_filter('opal_theme_sidebar', array($this, 'set_sidebar'), 20);
            add_filter('medilazar_customizer_buttons', array($this, 'customizer_buttons'));

            add_action('wp_enqueue_scripts', array($this, 'woocommerce_scripts'), 20);
            add_filter('woocommerce_enqueue_styles', '__return_empty_array');

            add_filter('woocommerce_output_related_products_args', array($this, 'related_products_args'));
            add_filter('loop_shop_per_page', array($this, 'products_per_page'));
            add_filter('woocommerce_breadcrumb_defaults', array($this, 'change_breadcrumb_delimiter'));
            add_filter('woocommerce_show_page_title', '__return_false');
            add_filter('woocommerce_product_review_comment_form_args', array($this, 'custom_comment_form'));

            add_filter('wc_get_template_part', array($this, 'change_template_part'), 10, 3);
            //Elementor Widget
            add_action('elementor/widgets/register', array($this, 'include_widgets'));

            add_action('widgets_init', array($this, 'widgets_init'));

            if (defined('WC_VERSION') && version_compare(WC_VERSION, '2.5', '<')) {
                add_action('wp_footer', array($this, 'star_rating_script'));
            }

            if (class_exists('YITH_WCWL_Init')) {
                remove_action('wp_head', array(YITH_WCWL_Init::get_instance(), 'detect_javascript'), 0);
            }

            add_action('woocommerce_before_template_part', array($this, 'add_layout_before_cross_sells'), 10, 4);
            add_action('woocommerce_after_template_part', array($this, 'add_layout_after_cross_sells'), 10, 4);
            add_action('wp_footer', array($this, 'added_to_cart_template'));

            // Thirt-party
            add_filter('ywsfd_share_position', array($this, 'ywsfd_share_position'));
            if (class_exists('YITH_WCWL')) {
                add_action('wp_ajax_medilazar_update_wishlist_count', array($this, 'yith_wcwl_ajax_update_count'));
                add_action('wp_ajax_nopriv_medilazar_update_wishlist_count', array(
                    $this,
                    'yith_wcwl_ajax_update_count'
                ));
            }

            add_action('wp_footer', array($this, 'label_tooltip'));

            add_action('wp_print_styles', array($this, 'remove_css_vendors'), 999);


            // Woocommerce 3.3
            if (medilazar_woocommerce_version_check('3.3')) {
                add_action('customize_register', array($this, 'edit_section_customizer'), 99);
            }

            // Wocommerce filter
            if (is_active_sidebar('sidebar-woocommerce-shop')) {
                add_action('woocommerce_before_shop_loop', array($this, 'render_button_shop_canvas'), 2);
                add_action('wp_footer', array($this, 'render_woocommerce_shop_canvas'), 1);
            }


            // Elementor
            add_action('admin_action_elementor', array($this, 'register_elementor_wc_hook'), 1);

            // Variation-swatches-for-woocommerce
            add_filter('woocommerce_layered_nav_term_html', array($this, 'layered_nav_term_html'), 10, 4);

            //Add Custom field Product Video for Single Product
            add_action('cmb2_admin_init', array($this, 'product_video_custom_field'));

            add_action('wp_footer', array($this, 'mobile_handheld_footer_bar'));

            add_filter('woocommerce_grouped_product_columns', array($this, 'grouped_product_columns'));
            add_action('woocommerce_grouped_product_list_before_label', array(
                $this,
                'grouped_product_column_image'
            ), 10, 1);

            add_filter('woocommerce_layered_nav_count', [$this, 'layered_nav_count'], 10, 2);

            add_action('wp_ajax_medilazar_product_view', array($this, 'medilazar_ajax_wc_track_product_view'));
            add_action('wp_ajax_nopriv_medilazar_product_view', array($this, 'medilazar_ajax_wc_track_product_view'));
        }

        function medilazar_ajax_wc_track_product_view() {

            $product_id = $_POST['productid'];

            if (!isset($_COOKIE['otf_woocommerce_recently_viewed']) || isset($_COOKIE['otf_woocommerce_recently_viewed']) && empty($_COOKIE['otf_woocommerce_recently_viewed'])) {
                $viewed_products = array();
            } else {
                $viewed_products = (array)explode('|', $_COOKIE['otf_woocommerce_recently_viewed']);
            }

            // Unset if already in viewed products list.
            $keys = array_flip($viewed_products);
            if (isset($keys[$product_id])) {
                unset($viewed_products[$keys[$product_id]]);
            }

            wc_setcookie('otf_woocommerce_recently_viewed', implode('|', $viewed_products));
        }

        public function layered_nav_count($content, $count) {
            return '<span class="count">' . absint($count) . '</span>';
        }


        /**
         * @param $grouped_product_child WC_Product_Simple
         */
        public function grouped_product_column_image($grouped_product_child) {
            echo '<td class="woocommerce-grouped-product-image">' . $grouped_product_child->get_image('thumbnail') . '</td>';
        }

        public function grouped_product_columns() {
            return array(
                'label',
                'price',
                'quantity',
            );
        }

        public function mobile_handheld_footer_bar() {
            $links = array(
                'my-account' => '<a class="my-accrount-footer" href="' . esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))) . '">' . esc_attr__('My Account', 'medilazar') . '</a>',
                'search'     => '<a class="search-footer" href="">' . esc_attr__('Search', 'medilazar') . '</a><div class="site-search">' . get_search_form(false) . '</div>',
                'cart'       => ' <a class="footer-cart-contents" href="' . esc_url(wc_get_cart_url()) . '" title="' . esc_attr__('View your shopping cart', 'medilazar') . '">  <span class="count">' . wp_kses_data(WC()->cart->get_cart_contents_count()) . '</span></a>'
            );

            if (wc_get_page_id('myaccount') === -1) {
                unset($links['my-account']);
            }

            if (wc_get_page_id('cart') === -1) {
                unset($links['cart']);
            }

            $links = apply_filters('storefront_handheld_footer_bar_links', $links);
            ?>
            <div class="handheld-footer-bar">
                <ul class="columns-<?php echo count($links); ?>">
                    <?php foreach ($links as $key => $content) : ?>
                        <li class="<?php echo esc_attr($key); ?>">
                            <?php echo trim($content); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php
        }

        public function layered_nav_term_html($term_html, $term, $link, $count) {
            if (function_exists('wvs_get_wc_attribute_taxonomy')) {
                $attr = wvs_get_wc_attribute_taxonomy($term->taxonomy);
                switch ($attr->attribute_type) {
                    case 'color':
                        $color = get_term_meta($term->term_id, 'product_attribute_color', true);
                        $html  = '';
                        $html  .= '<a class="osf-color-type" href="' . esc_url($link) . '">';
                        $html  .= '<span class="color-label" style="background: ' . esc_attr($color) . ';"></span>';
                        $html  .= '<span class="color-name">' . esc_html($term->name) . '</span>';
                        $html  .= '<span class="color-count">' . esc_html($count) . '</span>';
                        $html  .= '</a>';

                        return $html;
                    case 'button':
                        $label = get_term_meta($term->term_id, 'product_attribute_button', true);
                        $html  = '';
                        $html  .= '<a class="osf-label-type" href="' . esc_url($link) . '">';
                        $html  .= '<span class="attr-label">' . esc_html($term->name) . '</span>';
                        $html  .= '</a>';

                        return $html;
                    case 'image':
                        $image = get_term_meta($term->term_id, 'product_attribute_image', true);;
                        $html = '';
                        $html .= '<a class="osf-image-type" href="' . esc_url($link) . '">';
                        $html .= '<span class="attr-image" style="background-image: url(' . wp_get_attachment_image_url($image) . ')"></span>';
                        $html .= '</a>';

                        return $html;
                }

                return $term_html;
            } else {
                return $term_html;
            }

        }

        public function register_elementor_wc_hook() {
            wc()->frontend_includes();
            medilazar_include_hooks_product_blocks();
        }

        /**
         * @param $wp_customizer WP_Customize_Manager
         */
        public function edit_section_customizer($wp_customizer) {
            $wp_customizer->get_control('woocommerce_single_image_width')->section  = 'medilazar_woocommerce_single';
            $wp_customizer->get_control('woocommerce_single_image_width')->priority = 9;

            $wp_customizer->get_control('woocommerce_thumbnail_image_width')->section = 'medilazar_woocommerce_product';
            $wp_customizer->get_control('woocommerce_thumbnail_cropping')->section    = 'medilazar_woocommerce_product';

            $wp_customizer->get_control('woocommerce_shop_page_display')->section  = 'medilazar_woocommerce_archive';
            $wp_customizer->get_control('woocommerce_shop_page_display')->priority = 21;

            $wp_customizer->get_control('woocommerce_category_archive_display')->section  = 'medilazar_woocommerce_archive';
            $wp_customizer->get_control('woocommerce_category_archive_display')->priority = 21;

            $wp_customizer->get_control('woocommerce_default_catalog_orderby')->section  = 'medilazar_woocommerce_archive';
            $wp_customizer->get_control('woocommerce_default_catalog_orderby')->priority = 21;
        }

        /**
         * @param $out
         * @param $pairs
         * @param $atts
         *
         * @return array
         */
        public function set_shortcode_attributes($out, $pairs, $atts) {
            $out = wp_parse_args($atts, $out);

            return $out;
        }

        public function include_widgets($widgets_manager) {


        }

        public function remove_css_vendors() {
            wp_dequeue_style('dgwt-wcas-style');
        }

        public function label_tooltip() {
            echo '<div class="woocommerce-lablel-tooltip" style="display: none!important;">';
            echo '<div id="osf-woocommerce-cart">' . esc_html__('Add to cart', 'medilazar') . '</div>';
            echo '</div>';
        }

        public function yith_wcwl_ajax_update_count() {
            wp_send_json(array(
                'count' => yith_wcwl_count_all_products(),
            ));
        }

        public function ywsfd_share_position($args) {
            $args['priority'] = 45;

            return $args;
        }

        public function added_to_cart_template() {
            $text = esc_html__('has been added to your cart', 'medilazar');
            echo <<<HTML
        <script type="text/html" id="tmpl-added-to-cart-template"><div class="notification-added-to-cart"><div class="notification-wrap"><div class="ns-thumb d-inline-block"><img src="{{{data.src}}}" alt="{{{data.name}}}"></div><div class="ns-content d-inline-block"><p><strong>{{{data.name}}}</strong> $text </p></div></div></div></script>
HTML;
        }

        protected function get_query_results($query_args) {
            $query_args['paged'] = $query_args['page'] + 1;
            $query               = new WP_Query($query_args);

            return empty($query->posts) ? true : false;
        }


        public function add_layout_before_cross_sells($template_name, $template_path, $located, $args) {
            if ($template_name === 'cart/cross-sells.php') {
                echo '<div class="columns-' . esc_attr($args["columns"]) . '">';
            }
        }

        public function add_layout_after_cross_sells($template_name, $template_path, $located, $args) {
            if ($template_name === 'cart/cross-sells.php') {
                echo '</div>';
            }
        }

        public function widgets_init() {
            register_sidebar(array(
                'name'          => esc_html__('WooCommerce Shop', 'medilazar'),
                'id'            => 'sidebar-woocommerce-shop',
                'description'   => esc_html__('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'medilazar'),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            ));
            register_sidebar(array(
                'name'          => esc_html__('WooCommerce Detail', 'medilazar'),
                'id'            => 'sidebar-woocommerce-detail',
                'description'   => esc_html__('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'medilazar'),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            ));
        }

        public function render_woocommerce_shop_canvas() {

            $position = get_theme_mod('medilazar_woocommerce_archive_layout', '2cl');
            if (is_active_sidebar('sidebar-woocommerce-shop')) {
                echo '<div id="opal-canvas-filter" class="opal-canvas-filter position-' . esc_attr($position) . '"><span class="filter-close">' . esc_html__('CLOSE', 'medilazar') . '</span><div class="opal-canvas-filter-wrap">';
                dynamic_sidebar('sidebar-woocommerce-shop');
                echo '</div></div>';
                echo '<div class="opal-overlay-filter"></div>';
            }

        }

        public function render_button_shop_canvas() {
            if (is_active_sidebar('sidebar-woocommerce-shop')) {
                echo '<button class="filter-toggle" aria-expanded="false"><span class="filter-icon"></span>' . esc_html__('Filter', 'medilazar') . '</button>';
            }
        }

        public function productIdAutocompleteRender($query) {
            $query = trim($query['value']); // get value from requested
            if (!empty($query)) {
                // get product
                $product_object = wc_get_product((int)$query);
                if (is_object($product_object)) {
                    $product_sku   = $product_object->get_sku();
                    $product_title = $product_object->get_title();
                    $product_id    = $product_object->get_id();

                    $product_sku_display = '';
                    if (!empty($product_sku)) {
                        $product_sku_display = ' - ' . esc_html__('Sku', 'medilazar') . ': ' . esc_html($product_sku);
                    }

                    $product_title_display = '';
                    if (!empty($product_title)) {
                        $product_title_display = ' - ' . esc_html__('Title', 'medilazar') . ': ' . esc_html($product_title);
                    }

                    $product_id_display = esc_html__('Id', 'medilazar') . ': ' . esc_html($product_id);

                    $data          = array();
                    $data['value'] = $product_id;
                    $data['label'] = $product_id_display . $product_title_display . $product_sku_display; // WPCS: XSS ok.

                    return !empty($data) ? $data : false;
                }

                return false;
            }

            return false;
        }

        public function productCategoryAutocompleteRender($query) {
            $query = $query['value'];
            $query = trim($query);
            $term  = get_term_by('slug', $query, 'product_cat');

            $term_slug  = $term->slug;
            $term_title = $term->name;
            $term_id    = $term->term_id;

            $term_slug_display = '';
            if (!empty($term_slug)) {
                $term_slug_display = ' - ' . esc_html__('Sku', 'medilazar') . ': ' . $term_slug; // WPCS: XSS ok.
            }

            $term_title_display = '';
            if (!empty($term_title)) {
                $term_title_display = ' - ' . esc_html__('Title', 'medilazar') . ': ' . $term_title; // WPCS: XSS ok.
            }

            $term_id_display = esc_html__('Id', 'medilazar') . ': ' . $term_id; // WPCS: XSS ok.

            $data          = array();
            $data['value'] = $term_id;
            $data['label'] = $term_id_display . $term_title_display . $term_slug_display; // WPCS: XSS ok.

            return !empty($data) ? $data : false;
        }

        public function taxonomy_metaboxes() {
            $prefix   = 'product_cat_';
            $cmb_term = new_cmb2_box(array(
                'id'           => 'product_cat',
                'title'        => esc_html__('Product Metabox', 'medilazar'), // Doesn't output for term boxes
                'object_types' => array('term'),
                'taxonomies'   => array('product_cat'),
                // 'new_term_section' => true, // Will display in the "Add New Category" section
            ));

            $cmb_term->add_field(array(
                'name'       => esc_html__('Banner', 'medilazar'),
                //                'desc' => esc_html__('Location image', 'medilazar'),
                'id'         => $prefix . 'banner',
                'type'       => 'file',
                'options'    => array(
                    'url' => false, // Hide the text input for the url
                ),
                'query_args' => array(
                    'type' => 'image',
                ),
            ));
        }

        public function product_video_custom_field() {
            $prefix = 'medilazar_products_';
            $cmb    = new_cmb2_box(array(
                'id'           => $prefix . 'product_video',
                'title'        => esc_html__('Product Video Config', 'medilazar'),
                'object_types' => array('product'),
                'context'      => 'normal',
                'priority'     => 'default',
            ));

            $cmb->add_field(array(
                'name' => esc_html__('Product video', 'medilazar'),
                'desc' => esc_html__('Supports video from youtube and vimeo.', 'medilazar'),
                'id'   => $prefix . 'video',
                'type' => 'oembed',
            ));

            $cmb->add_field(array(
                'name'         => esc_html__('Video Thumbnail', 'medilazar'),
                'desc'         => 'Upload an image or enter an URL.',
                'id'           => $prefix . 'video_thumbnail',
                'type'         => 'file',
                'text'         => array(
                    'add_upload_file_text' => 'Add Image' // Change upload button text. Default: "Add or Upload File"
                ),
                'options'      => array(
                    'url' => false, // Hide the text input for the url
                ),
                'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
            ));


        }

        /**
         * @return void
         */
        public function after_setup_theme() {
            add_theme_support('woocommerce');
        }

        /**
         * @return void
         *
         * @see do_shortcode()
         */
        private function init_shortcodes() {
            foreach ($this->list_shortcodes as $shortcode) {
                add_filter('shortcode_atts_' . $shortcode, array($this, 'set_shortcode_attributes'), 10, 3); // WPCS: XSS ok.
                add_action('woocommerce_shortcode_before_' . $shortcode . '_loop', array( // WPCS: XSS ok.
                                                                                          $this,
                                                                                          'style_loop_start'
                ));
                add_action('woocommerce_shortcode_after_' . $shortcode . '_loop', array($this, 'style_loop_end')); // WPCS: XSS ok.

            }
        }

        // Check list style
        public function style_loop_start($atts = array()) {
            if (isset($atts['product_layout']) && $atts['product_layout'] != 'grid') {
                $classes = '';
                if ($atts['product_layout'] === 'list' || $atts['product_layout'] === 'list-carousel') {
                    if (!empty($atts['show_category'])) {
                        add_action('medilazar_product_list_before_title', 'medilazar_woocommerce_get_product_category', 10);
                    }

                    if (!empty($atts['show_rating'])) {
                        add_action('medilazar_product_list_before_price', 'medilazar_woocommerce_list_show_rating', 15);
                    }

                    if (!empty($atts['show_except'])) {
                        add_action('medilazar_product_list_before_price', 'medilazar_woocommerce_list_show_excerpt', 10);
                    }

                    if (!empty($atts['show_time_sale'])) {
                        add_action('medilazar_product_list_after_price', 'medilazar_woocommerce_time_sale', 20);
                    }


                    echo '<div class="woocommerce-product-' . esc_attr($atts['product_layout']) . esc_attr($classes) . '">';
                }
            }
        }


        public function style_loop_end($atts = array()) {
            if (isset($atts['product_layout']) && $atts['product_layout'] != 'grid') {
                if ($atts['product_layout'] === 'list') {
                    echo '</div>';
                    if (!empty($atts['show_category'])) {
                        remove_action('medilazar_product_list_before_title', 'medilazar_woocommerce_get_product_category', 10);
                    }

                    if (!empty($atts['show_rating'])) {
                        remove_action('medilazar_product_list_before_price', 'medilazar_woocommerce_list_show_rating', 15);
                    }

                    if (!empty($atts['show_except'])) {
                        remove_action('medilazar_product_list_before_price', 'medilazar_woocommerce_list_show_excerpt', 10);
                    }

                    if (!empty($atts['show_time_sale'])) {
                        remove_action('medilazar_product_list_after_price', 'medilazar_woocommerce_time_sale', 20);
                    }
                }
            }
        }

        public function body_class($classes) {
            $classes[] = 'woocommerce-active';
            if (medilazar_is_product_archive()) {
                $classes = array_diff($classes, array(
                    'opal-content-layout-2cl',
                    'opal-content-layout-2cr',
                    'opal-content-layout-1c'
                ));
                if (get_theme_mod('medilazar_woocommerce_archive_style', 'default') == 'default') {
                    $classes[] = 'opal-woocommerce-archive-style-default';
                    if (is_active_sidebar('sidebar-woocommerce-shop') && get_theme_mod('medilazar_woocommerce_archive_layout') !== '2cr') {
                        $classes[] = 'opal-content-layout-2cl';
                    }

                    if (is_active_sidebar('sidebar-woocommerce-shop') && get_theme_mod('medilazar_woocommerce_archive_layout') == '2cr') {
                        $classes[] = 'opal-content-layout-2cr';
                    }
                } else {
                    $classes[] = 'opal-woocommerce-archive-style-with-filter';
                }
                if (get_theme_mod('medilazar_woocommerce_archive_product_width', 0)) {
                    $classes[] = 'medilazar_woocommerce_archive_product_style_full';
                }
            } else {
                if (is_product()) {
                    $classes = array_diff($classes, array(
                        'opal-content-layout-2cl',
                        'opal-content-layout-2cr',
                        'opal-content-layout-1c'
                    ));

                    if (is_active_sidebar('sidebar-woocommerce-detail') && get_theme_mod('medilazar_woocommerce_single_layout') !== '2cl') {
                        $classes[] = 'opal-content-layout-2cr';
                    }

                    if (is_active_sidebar('sidebar-woocommerce-detail') && get_theme_mod('medilazar_woocommerce_single_layout') == '2cl') {
                        $classes[] = 'opal-content-layout-2cl';
                    }

                    $classes[] = 'woocommerce-single-style-' . get_theme_mod('medilazar_woocommerce_single_product_style', '1');

                }
            }

            $classes[] = 'product-style-' . get_theme_mod('medilazar_woocommerce_product_style', 1);

            return $classes;
        }

        public function set_sidebar($name) {
            if (medilazar_is_product_archive() && is_active_sidebar('sidebar-woocommerce-shop') && (get_theme_mod('medilazar_woocommerce_archive_style', 'default') == 'default')) {
                $name = 'sidebar-woocommerce-shop';
            } else {
                if (is_product() && is_active_sidebar('sidebar-woocommerce-detail')) {
                    $name = 'sidebar-woocommerce-detail';
                }
            }

            return $name;
        }

        /**
         * WooCommerce specific scripts & stylesheets
         *
         * @since 1.0.0
         */
        public function woocommerce_scripts() {
            wp_enqueue_script('flexslider');
        }

        /**
         * Star rating backwards compatibility script (WooCommerce <2.5).
         *
         * @since 1.6.0
         */
        public function star_rating_script() {
            if (wp_script_is('jquery', 'done') && is_product()) {
                ?>
                <script type="text/javascript">
                    jQuery(function ($) {
                        $('body').on('click', '#respond p.stars a', function () {
                            var $container = $(this).closest('.stars');
                            $container.addClass('selected');
                        });
                    });
                </script>
                <?php
            }
        }

        /**
         * Related Products Args
         *
         * @param array $args related products args.
         *
         * @return  array $args related products args
         * @since 1.0.0
         */
        public function related_products_args($args) {
            $args = apply_filters('medilazar_related_products_args', array(
                'posts_per_page' => get_theme_mod('medilazar_woocommerce_single_related_number', 3),
                'columns'        => get_theme_mod('medilazar_woocommerce_single_related_columns', 3),
            ));

            return $args;
        }

        /**
         * Product gallery thumnail columns
         *
         * @return integer number of columns
         * @since  1.0.0
         */
        public function thumbnail_columns() {
            $columns = get_theme_mod('medilazar_woocommerce_product_thumbnail_columns', 3);

            return intval(apply_filters('medilazar_product_thumbnail_columns', $columns));
        }

        /**
         * Products per page
         *
         * @return integer number of products
         * @since  1.0.0
         */
        public function products_per_page() {
            $number = get_theme_mod('medilazar_woocommerce_archive_number', 12);

            return intval(apply_filters('medilazar_products_per_page', $number));
        }


        /**
         * Remove the breadcrumb delimiter
         *
         * @param array $defaults thre breadcrumb defaults
         *
         * @return array           thre breadcrumb defaults
         * @since 2.2.0
         */
        public function change_breadcrumb_delimiter($defaults) {
            $defaults['delimiter'] = '<span class="breadcrumb-separator"> / </span>';

            return $defaults;
        }

        public function customizer_buttons($buttons) {
            $buttons = wp_parse_args($buttons, array(
                '.single-product #content'             => array(
                    array(
                        'id'   => 'medilazar_woocommerce_single',
                        'icon' => 'default',
                        'type' => 'section',
                    ),
                ),
                '.archive.woocommerce-page #content'   => array(
                    array(
                        'id'   => 'medilazar_woocommerce_archive',
                        'icon' => 'default',
                        'type' => 'section',
                    ),
                ),
                '.woocommerce-pagination'              => array(
                    array(
                        'id'      => 'medilazar_layout_pagination_style',
                        'icon'    => 'default',
                        'type'    => 'control',
                        'trigger' => '.button-change-image|click',
                    ),
                ),
                '.single-product .flex-control-thumbs' => array(
                    array(
                        'id'      => 'medilazar_woocommerce_product_thumbnail_columns',
                        'icon'    => 'default',
                        'type'    => 'control',
                        'trigger' => 'select|focus',
                    ),
                ),
                '.single-product .related'             => array(
                    array(
                        'id'      => 'medilazar_woocommerce_single_related_columns',
                        'icon'    => 'default',
                        'type'    => 'control',
                        'trigger' => 'select|focus',
                    ),
                ),
                '.single-product .upsells'             => array(
                    array(
                        'id'      => 'medilazar_woocommerce_single_upsale_columns',
                        'icon'    => 'default',
                        'type'    => 'control',
                        'trigger' => 'select|focus',
                    ),
                ),
                '.products .type-product'              => array(
                    array(
                        'id'      => 'medilazar_woocommerce_product_hover',
                        'icon'    => 'default',
                        'type'    => 'control',
                        'trigger' => 'select|focus',
                    ),
                ),
                '#osf-accordion-container'             => array(
                    array(
                        'id'      => 'medilazar_woocommerce_single_product_tab_style',
                        'icon'    => 'layout',
                        'type'    => 'control',
                        'trigger' => 'select|focus',
                    ),
                ),
            ));

            return $buttons;
        }

        public function add_support_zoom() {
            add_theme_support('wc-product-gallery-zoom');
        }

        public function add_support_lightbox() {
            add_theme_support('wc-product-gallery-lightbox');
        }

        public function add_support_slider() {
            add_theme_support('wc-product-gallery-slider');
        }

        public function add_support_gallery_all() {
            add_theme_support('wc-product-gallery-zoom');
            add_theme_support('wc-product-gallery-lightbox');
            add_theme_support('wc-product-gallery-slider');
        }

        public function custom_comment_form($comment_form) {
            $commenter                     = wp_get_current_commenter();
            $comment_form['fields']        = array(
                'author' => '<p class="comment-form-author"><input id="author" name="author" type="text" placeholder="' . esc_attr__("Name", "medilazar") . '" value="' . esc_attr($commenter['comment_author']) . '" size="30" required /></p>',
                'email'  => '<p class="comment-form-email"><input id="email" name="email" type="email" placeholder="' . esc_attr__("Email", "medilazar") . '" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" required /></p>',
                'url'    => '<p class="comment-form-url"> <input id="url" name="url" type="url" placeholder="' . esc_attr__("Website", "medilazar") . '" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200" /></p>'
            );
            $comment_form['comment_field'] = '';

            if (wc_review_ratings_enabled()) {
                $comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__('Your rating', 'medilazar') . '</label><select name="rating" id="rating" required>
						<option value="">' . esc_html__('Rate&hellip;', 'medilazar') . '</option>
						<option value="5">' . esc_html__('Perfect', 'medilazar') . '</option>
						<option value="4">' . esc_html__('Good', 'medilazar') . '</option>
						<option value="3">' . esc_html__('Average', 'medilazar') . '</option>
						<option value="2">' . esc_html__('Not that bad', 'medilazar') . '</option>
						<option value="1">' . esc_html__('Very poor', 'medilazar') . '</option>
					</select></div>';
            }


            $comment_form['comment_field'] .= '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="2" required placeholder="' . esc_attr__("Your review", "medilazar") . '"></textarea></p>';
            $comment_form['submit_button'] = '<button name="%1$s" type="submit" id="%2$s" class="%3$s"><span>%4$s</span></button>';
            $comment_form['label_submit']  = esc_html__('Submit Your Review', 'medilazar');

            return $comment_form;
        }

        public function change_template_part($template, $slug, $name) {

            if (isset($_GET['display'])) {
                if ($slug == 'content' && $name == 'product' && $_GET['display'] == 'list') {
                    $template = wc_get_template_part('content', 'product-list');
                }
            }

            return $template;
        }

    }
endif;

medilazar_WooCommerce::getInstance();