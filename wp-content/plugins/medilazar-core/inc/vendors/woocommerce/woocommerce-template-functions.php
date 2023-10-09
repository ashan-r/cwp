<?php

if (!function_exists('osf_woocommerce_widget_shopping_cart_button_view_cart')) {

    /**
     * Output the view cart button.
     */
    function osf_woocommerce_widget_shopping_cart_button_view_cart() {
        echo '<a href="' . esc_url(wc_get_cart_url()) . '" class="button wc-forward"><span>' . esc_html__('View cart', 'medilazar-core') . '</span></a>';
    }
}

if (!function_exists('osf_woocommerce_widget_shopping_cart_proceed_to_checkout')) {

    /**
     * Output the proceed to checkout button.
     */
    function osf_woocommerce_widget_shopping_cart_proceed_to_checkout() {
        echo '<a href="' . esc_url(wc_get_checkout_url()) . '" class="button checkout wc-forward"><span>' . esc_html__('Checkout', 'medilazar-core') . '</span></a>';
    }
}

if (!function_exists('osf_woocommerce_version_check')) {
    function osf_woocommerce_version_check($version = '3.3') {
        if (osf_is_woocommerce_activated()) {
            global $woocommerce;
            if (version_compare($woocommerce->version, $version, ">=")) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('osf_before_content')) {
    /**
     * Before Content
     * Wraps all WooCommerce content in wrappers which match the theme markup
     *
     * @return  void`
     * @since   1.0.0
     */
    function osf_before_content() {
        ?>
        <div class="wrap">
        <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
        <?php
        if (is_product_category()) {
            $cate      = get_queried_object();
            $cateID    = $cate->term_id;
            $banner_id = get_term_meta($cateID, 'product_cat_banner_id', true);

            if ($banner_id) {
                echo '<div class="product-category-banner">';
                echo wp_get_attachment_image($banner_id, 'full');
                echo '</div>';
            }
        }
    }
}

if (!function_exists('osf_after_content')) {
    /**
     * After Content
     * Closes the wrapping divs
     *
     * @return  void
     * @since   1.0.0
     */
    function osf_after_content() {
        ?>
        </main><!-- #main -->
        </div><!-- #primary -->
        <?php get_sidebar(); ?>
        </div>
        <?php
    }
}

if (!function_exists('osf_cart_link_fragment')) {
    /**
     * Cart Fragments
     * Ensure cart contents update when products are added to the cart via AJAX
     *
     * @param array $fragments Fragments to refresh via AJAX.
     *
     * @return array            Fragments to refresh via AJAX
     */
    function osf_cart_link_fragment($fragments) {
        global $woocommerce;

        ob_start();
        $fragments['a.cart-contents .amount']     = osf_cart_amount();
        $fragments['a.cart-contents .count']      = osf_cart_count();
        $fragments['a.cart-contents .count-text'] = osf_cart_count_text();

        ob_start();
        osf_handheld_footer_bar_cart_link();
        $fragments['a.footer-cart-contents'] = ob_get_clean();

        return $fragments;
    }
}

if (!function_exists('osf_cart_link')) {
    /**
     * Cart Link
     * Displayed a link to the cart including the number of items present and the cart total
     *
     * @return string
     * @since  1.0.0
     */
    function osf_cart_link() {
        if (!empty(WC()->cart) && WC()->cart instanceof WC_Cart) {
            $items = '';
            $items .= '<a data-toggle="toggle" class="cart-contents header-button" href="' . esc_url(wc_get_cart_url()) . '" title="' . __("View your shopping cart", "medilazar-core") . '">';
            $items .= '<i class="opal-icon-cart" aria-hidden="true"></i>';
            $items .= '<span class="count">' . wp_kses_data(WC()->cart->get_cart_contents_count()) . '</span>';
            $items .= '</a>';

            return $items;
        }

        return '';
    }
}

if (!function_exists('osf_cart_amount')) {
    /**
     *
     * @return string
     *
     */
    function osf_cart_amount() {
        if (!empty(WC()->cart) && WC()->cart instanceof WC_Cart) {
            return '<span class="amount 1">' . wp_kses_data(WC()->cart->get_cart_subtotal()) . '</span>';
        }

        return '';
    }
}

if (!function_exists('osf_cart_count')) {
    /**
     *
     * @return string
     *
     */
    function osf_cart_count() {
        if (!empty(WC()->cart) && WC()->cart instanceof WC_Cart) {
            return '<span class="count">' . wp_kses_data(WC()->cart->get_cart_contents_count()) . '</span>';
        }

        return '';
    }
}

if (!function_exists('osf_cart_count_text')) {
    /**
     *
     * @return string
     *
     */
    function osf_cart_count_text() {
        if (!empty(WC()->cart) && WC()->cart instanceof WC_Cart) {
            return '<span class="count-text">' . wp_kses_data(_n("item", "items", WC()->cart->get_cart_contents_count(), "medilazar-core")) . '</span>';
        }

        return '';
    }
}

if (!function_exists('osf_upsell_display')) {
    /**
     * Upsells
     * Replace the default upsell function with our own which displays the correct number product columns
     *
     * @return  void
     * @since   1.0.0
     * @uses    woocommerce_upsell_display()
     */
    function osf_upsell_display() {
        global $product;
        $number = count($product->get_upsell_ids());
        if ($number <= 0) {
            return;
        }
        $columns = absint(get_theme_mod('osf_woocommerce_single_upsell_columns', 3));
        if ($columns < $number) {
            echo '<div class="woocommerce-product-carousel owl-theme" data-columns="' . esc_attr($columns) . '">';
        } else {
            echo '<div class="columns-' . esc_attr($columns) . '">';
        }
        woocommerce_upsell_display();
        echo '</div>';
    }
}

if (!function_exists('osf_output_related_products')) {
    /**
     * Related
     *
     * @return  void
     * @since   1.0.0
     * @uses    woocommerce_related_products()
     */
    function osf_output_related_products() {
        $columns = absint(get_theme_mod('osf_woocommerce_single_related_columns', 3));
        $number  = absint(get_theme_mod('osf_woocommerce_single_related_number', 3));
        if ($columns < $number) {
            echo '<div class="woocommerce-product-carousel owl-theme" data-columns="' . esc_attr($columns) . '">';
        } else {
            echo '<div class="columns-' . esc_attr($columns) . '">';
        }
        $args = array(
            'posts_per_page' => $number,
            'columns'        => $columns,
            'orderby'        => 'rand'
        );
        woocommerce_related_products($args);
        echo '</div>';
    }
}

if (!function_exists('osf_sorting_wrapper')) {
    /**
     * Sorting wrapper
     *
     * @return  void
     * @since   1.4.3
     */
    function osf_sorting_wrapper() {
        echo '<div class="osf-sorting-wrapper"><div class="osf-sorting">';
    }
}

if (!function_exists('osf_sorting_wrapper_close')) {
    /**
     * Sorting wrapper close
     *
     * @return  void
     * @since   1.4.3
     */
    function osf_sorting_wrapper_close() {
        echo '</div></div>';
    }
}

if (!function_exists('osf_sorting_group')) {
    /**
     * Sorting wrapper
     *
     * @return  void
     * @since   1.4.3
     */
    function osf_sorting_group() {
        echo '<div class="osf-sorting-group col-lg-6 col-sm-12">';
    }
}

if (!function_exists('osf_sorting_group_close')) {
    /**
     * Sorting wrapper close
     *
     * @return  void
     * @since   1.4.3
     */
    function osf_sorting_group_close() {
        echo '</div>';
    }
}


if (!function_exists('osf_product_columns_wrapper')) {
    /**
     * Product columns wrapper
     *
     * @return  void
     * @since   2.2.0
     */
    function osf_product_columns_wrapper() {
        $columns = osf_loop_columns();
        if (isset($_GET['display']) && $_GET['display'] === 'list') {
            $columns = 1;
        }
        echo '<div class="columns-' . intval($columns) . '">';
    }
}

if (!function_exists('osf_loop_columns')) {
    /**
     * Default loop columns on product archives
     *
     * @return integer products per row
     * @since  1.0.0
     */
    function osf_loop_columns() {
        $columns = get_theme_mod('osf_woocommerce_archive_columns', 4);

        return intval(apply_filters('osf_products_columns', $columns));
    }
}

if (!function_exists('osf_product_columns_wrapper_close')) {
    /**
     * Product columns wrapper close
     *
     * @return  void
     * @since   2.2.0
     */
    function osf_product_columns_wrapper_close() {
        echo '</div>';
    }
}

if (!function_exists('osf_shop_messages')) {
    /**
     * homefinder shop messages
     *
     * @since   1.4.4
     * @uses    osf_do_shortcode
     */
    function osf_shop_messages() {
        if (!is_checkout()) {
            echo wp_kses_post(osf_do_shortcode('woocommerce_messages'));
        }
    }
}

if (!function_exists('osf_woocommerce_pagination')) {
    /**
     * homefinder WooCommerce Pagination
     * WooCommerce disables the product pagination inside the woocommerce_product_subcategories() function
     * but since homefinder adds pagination before that function is excuted we need a separate function to
     * determine whether or not to display the pagination.
     *
     * @since 1.4.4
     */
    function osf_woocommerce_pagination() {
        if (woocommerce_products_will_display()) {
            woocommerce_pagination();
        }
    }
}


if (!function_exists('osf_handheld_footer_bar_search')) {
    /**
     * The search callback function for the handheld footer bar
     *
     * @since 2.0.0
     */
    function osf_handheld_footer_bar_search() {
        echo '<a href="">' . esc_attr__('Search', 'medilazar-core') . '</a>';
        osf_product_search();
    }
}

if (!function_exists('osf_handheld_footer_bar_cart_link')) {
    /**
     * The cart callback function for the handheld footer bar
     *
     * @since 2.0.0
     */
    function osf_handheld_footer_bar_cart_link() {
        ?>
        <a class="footer-cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>"
           title="<?php esc_attr_e('View your shopping cart', 'medilazar-core'); ?>">
            <span class="count"><?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?></span>
        </a>
        <?php
    }
}

if (!function_exists('osf_handheld_footer_bar_account_link')) {
    /**
     * The account callback function for the handheld footer bar
     *
     * @since 2.0.0
     */
    function osf_handheld_footer_bar_account_link() {
        echo '<a href="' . esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))) . '">' . esc_attr__('My Account', 'medilazar-core') . '</a>';
    }
}


if (!function_exists('osf_checkout_before_customer_details_container')) {
    function osf_checkout_before_customer_details_container() {
        if (WC()->checkout()->get_checkout_fields()) {
            echo '<div class="row"><div class="col-lg-7 col-md-12 col-sm-12"><div class="inner">';
        }
    }
}

if (!function_exists('osf_checkout_after_customer_details_container')) {
    function osf_checkout_after_customer_details_container() {
        if (WC()->checkout()->get_checkout_fields()) {
            echo '</div></div><div class="col-lg-5 col-md-12 col-sm-12"><div class="inner order_review_inner"> ';
        }
    }
}

if (!function_exists('osf_checkout_after_order_review_container')) {
    function osf_checkout_after_order_review_container() {
        if (WC()->checkout()->get_checkout_fields()) {
            echo '</div></div></div>';
        }
    }
}

if (!function_exists('osf_woocommerce_single_product_add_to_cart_before')) {
    function osf_woocommerce_single_product_add_to_cart_before() {
        echo '<div class="woocommerce-cart"><div class="inner woocommerce-cart-inner">';
    }
}

if (!function_exists('osf_woocommerce_single_product_add_to_cart_after')) {
    function osf_woocommerce_single_product_add_to_cart_after() {
        echo '</div></div>';
    }
}

if (!function_exists('osf_woocommerce_single_product_4_wrap_start')) {
    function osf_woocommerce_single_product_4_wrap_start() {
        echo '<div class="single-style-4-wrap">';
    }
}

if (!function_exists('osf_woocommerce_single_product_4_wrap_end')) {
    function osf_woocommerce_single_product_4_wrap_end() {
        echo '</div>';
    }
}

if (!function_exists('osf_woocommerce_before_single_product_summary_inner_start')) {
    function osf_woocommerce_before_single_product_summary_inner_start() {
        echo '<div class="product-inner">';
    }
}

if (!function_exists('osf_woocommerce_before_single_product_summary_inner_end')) {
    function osf_woocommerce_before_single_product_summary_inner_end() {
        echo '</div>';
    }
}

if (!function_exists('osf_woocommerce_single_product_summary_inner_start')) {
    function osf_woocommerce_single_product_summary_inner_start() {
        echo '<div class="inner">';
    }
}

if (!function_exists('osf_woocommerce_single_product_summary_inner_end')) {
    function osf_woocommerce_single_product_summary_inner_end() {
        echo '</div>';
    }
}

if (!function_exists('osf_woocommerce_product_best_selling')) {
    function osf_woocommerce_product_best_selling() {
        ?>
        <div class="best-selling">
            <div class="best-selling-inner">
                <h4 class="best-selling-title"><?php echo esc_html__('Trending', 'medilazar-core'); ?></h4>
                <ul class="product_list_widget product-best-selling">
                    <?php
                    $args = array(
                        'post_type'      => 'product',
                        'meta_key'       => 'total_sales',
                        'orderby'        => 'meta_value_num',
                        'posts_per_page' => 6
                    );
                    $loop = new WP_Query($args);
                    if ($loop->have_posts()) {
                        while ($loop->have_posts()) : $loop->the_post();
                            wc_get_template_part('content', 'widget-product');
                        endwhile;
                    } else {
                        echo __('No products found', 'medilazar-core');
                    }
                    wp_reset_postdata();
                    ?>
                </ul>
            </div>
        </div>
        <?php
    }
}

if (!function_exists('osf_template_loop_product_thumbnail')) {
    function osf_template_loop_product_thumbnail($size = 'woocommerce_thumbnail', $deprecated1 = 0, $deprecated2 = 0) {
        echo osf_get_loop_product_thumbnail();

    }
}
if (!function_exists('osf_woocommerce_order_review_heading')) {
    function osf_woocommerce_order_review_heading() {
        echo ' <h3 class="order_review_heading">' . esc_attr__('Your order', 'medilazar-core') . '</h3>';
    }
}


if (!function_exists('osf_get_loop_product_thumbnail')) {
    function osf_get_loop_product_thumbnail($size = 'woocommerce_thumbnail', $deprecated1 = 0, $deprecated2 = 0) {
        global $product;
        if (!$product) {
            return '';
        }
        $gallery    = $product->get_gallery_image_ids();
        $hover_skin = get_theme_mod('osf_woocommerce_product_hover', 'none');
        if ($hover_skin == '0' || count($gallery) <= 0) {
            echo '<div class="product-image">' . $product->get_image('shop_catalog') . '</div>';

            return '';
        }
        $image_featured = '<div class="product-image">' . $product->get_image('shop_catalog') . '</div>';
        $image_featured .= '<div class="product-image second-image">' . wp_get_attachment_image($gallery[0], 'shop_catalog') . '</div>';

        echo <<<HTML
<div class="product-img-wrap {$hover_skin}">
    <div class="inner">
        {$image_featured}
    </div>
</div>
HTML;
    }
}

if (!function_exists('osf_woocommerce_product_loop_image_start')) {
    function osf_woocommerce_product_loop_image_start() {
        echo '<div class="product-transition">';
    }
}

if (!function_exists('osf_woocommerce_product_loop_image_end')) {
    function osf_woocommerce_product_loop_image_end() {
        echo '</div>';
    }
}


if (!function_exists('osf_woocommerce_product_loop_action')) {
    function osf_woocommerce_product_loop_action() {
        ?>
        <div class="group-action">
            <div class="shop-action">
                <?php do_action('osf_woocommerce_product_loop_action'); ?>
            </div>
        </div>
        <?php
    }
}

if (!function_exists('osf_woocommerce_product_loop_footer')) {
    function osf_woocommerce_product_loop_footer() {
        ?>
        <div class="product-footer">
            <div class="shop-action">
                <?php do_action('osf_woocommerce_product_loop_footer'); ?>
            </div>
        </div>
        <?php
    }
}


if (!function_exists('osf_woocommerce_product_loop_wishlist_button')) {
    function osf_woocommerce_product_loop_wishlist_button() {
        if (osf_is_woocommerce_extension_activated('YITH_WCWL')) {
            echo osf_do_shortcode('yith_wcwl_add_to_wishlist');
        }
    }
}

if (!function_exists('osf_woocommerce_product_loop_compare_button')) {
    function osf_woocommerce_product_loop_compare_button() {
        if (osf_is_woocommerce_extension_activated('YITH_Woocompare')) {
            echo osf_do_shortcode('yith_compare_button');
        }
    }
}

if (!function_exists('osf_woocommerce_change_path_shortcode')) {
    function osf_woocommerce_change_path_shortcode($template, $slug, $name) {
        wc_get_template('content-widget-product.php', array('show_rating' => false));
    }
}

if (!function_exists('osf_woocommerce_product_loop_start')) {
    function osf_woocommerce_product_loop_start() {
        echo '<div class="product-block">';
    }
}

if (!function_exists('osf_woocommerce_product_loop_end')) {
    function osf_woocommerce_product_loop_end() {
        echo '</div>';
    }
}

if (!function_exists('osf_woocommerce_product_loop_caption_start')) {
    function osf_woocommerce_product_loop_caption_start() {
        echo '<div class="caption">';
    }
}

if (!function_exists('osf_woocommerce_product_loop_caption_end')) {
    function osf_woocommerce_product_loop_caption_end() {
        echo '</div>';
    }
}

if (!function_exists('osf_woocommerce_product_loop_group_transititon_start')) {
    function osf_woocommerce_product_loop_group_transititon_start() {
        echo '<div class="group-transition"><div class="group-transition-inner">';
    }
}

if (!function_exists('osf_woocommerce_product_loop_group_transititon_end')) {
    function osf_woocommerce_product_loop_group_transititon_end() {
        echo '</div></div>';
    }
}

if (!function_exists('osf_woocommerce_product_loop_label_start')) {
    function osf_woocommerce_product_loop_label_start() {
        echo '<div class="group-label">';
    }
}

if (!function_exists('osf_woocommerce_product_loop_label_end')) {
    function osf_woocommerce_product_loop_label_end() {
        echo '</div>';
    }
}

if (!function_exists('osf_woocommerce_product_rating')) {
    function osf_woocommerce_product_rating() {
        global $product;
        if (get_option('woocommerce_enable_review_rating') === 'no') {
            return;
        }
        if ($rating_html = wc_get_rating_html($product->get_average_rating())) {
            echo apply_filters('osf_woocommerce_rating_html', $rating_html);
        } else {
            echo '<div class="star-rating"></div>';
        }
    }
}

if (!function_exists('oft_woocommerce_template_loop_product_excerpt')) {

    /**
     * Show the excerpt in the product loop.
     */
    function osf_woocommerce_template_loop_product_excerpt() {
        global $product;
        echo '<div class="excerpt">' . get_the_excerpt() . '</div>';
    }
}
if (!function_exists('woocommerce_template_loop_product_title')) {

    /**
     * Show the product title in the product loop.
     */
    function woocommerce_template_loop_product_title() {
        echo '<h3 class="woocommerce-loop-product__title"><a href="' . esc_url_raw(get_the_permalink()) . '">' . get_the_title() . '</a></h3>';
    }
}


if (!function_exists('osf_woocommerce_get_product_category')) {
    function osf_woocommerce_get_product_category() {
        global $product;
        echo wc_get_product_category_list($product->get_id(), ', ', '<div class="posted_in">', '</div>');
    }
}

if (!function_exists('osf_woocommerce_get_product_label_stock')) {
    function osf_woocommerce_get_product_label_stock() {
        /**
         * @var $product WC_Product
         */
        global $product;
        if ($product->get_stock_status() == 'outofstock') {
            echo '<span class="stock-label outofstock"><span>' . esc_html__('Out Of Stock', 'medilazar-core') . '</span></span>';
        } elseif ($product->get_stock_status() == 'instock') {
            echo '<span class="stock-label instock"><span>' . esc_html__('In Stock', 'medilazar-core') . '</span></span>';
        } else {
            echo '<span class="stock-label onbackorder"><span>' . esc_html__('On backorder', 'medilazar-core') . '</span></span>';
        }
    }
}

if (!function_exists('osf_woocommerce_get_product_label_new')) {
    function osf_woocommerce_get_product_label_new() {
        global $product;
        $newness_days = 30;
        $created      = strtotime($product->get_date_created());
        if ((time() - (60 * 60 * 24 * $newness_days)) < $created) {
            echo '<span class="new-label"><span>' . esc_html__('New!', 'medilazar-core') . '</span></span>';
        }
    }
}

if (!function_exists('osf_woocommerce_get_product_label_sale')) {
    function osf_woocommerce_get_product_label_sale() {
        /**
         * @var $product WC_Product
         */
        global $product;
        if ($product->is_on_sale() && $product->is_type('simple')) {
            $sale  = $product->get_sale_price();
            $price = $product->get_regular_price();
            $ratio = round(($price - $sale) / $price * 100);
            echo '<span class="onsale">-' . esc_html($ratio) . '% ' . esc_html__('Off', 'medilazar-core') . ' </span>';
        }
    }
}


if (!function_exists('osf_woocommerce_get_product_label_feature')) {
    function osf_woocommerce_get_product_label_feature() {
        /**
         * @var $product WC_Product
         */
        global $product;
        if ($product->is_featured()) {
            echo '<span class="trend"><span>' . esc_html__('Trend', 'medilazar-core') . '</span></span>';
        }
    }
}

if (!function_exists('osf_woocommerce_set_register_text')) {
    function osf_woocommerce_set_register_text() {
        echo '<div class="user-text">' . __("Creating an account is quick and easy, and will allow you to move through our checkout quicker.", "medilazar-core") . '</div>';
    }
}


if (!function_exists('osf_header_cart_nav')) {
    /**
     * Display Header Cart
     *
     * @return string
     * @uses   osf_is_woocommerce_activated() check if WooCommerce is activated
     * @since  1.0.0
     */

    function osf_header_cart_nav() {
        if (osf_is_woocommerce_activated()) {
            $items = '';
            $items .= '<li class="megamenu-item menu-item  menu-item-has-children menu-item-cart site-header-cart " data-level="0">';
            $items .= osf_cart_link();
            if (!is_cart() && !is_checkout()) {
                $items .= '<ul class="shopping_cart_nav shopping_cart"><li><div class="widget_shopping_cart_content"></div></li></ul>';
            }
            $items .= '</li>';

            return $items;
        }

        return '';
    }
}

if (!function_exists('osf_woocommerce_add_woo_cart_to_nav')) {
    function osf_woocommerce_add_woo_cart_to_nav($items, $args) {

        if ('top' == $args->theme_location) {
            global $osf_header;
            if ($osf_header && $osf_header instanceof WP_Post) {
                if (osf_get_metabox($osf_header->ID, 'osf_enable_cart', false)) {
                    $items .= osf_header_cart_nav();
                }

                return $items;
            }

            if (get_theme_mod('osf_header_layout_enable_cart_in_menu', true)) {
                $items .= osf_header_cart_nav();
            }
        }

        return $items;
    }
}

if (!function_exists('osf_woocommerce_list_get_excerpt')) {
    function osf_woocommerce_list_show_excerpt() {
        echo '<div class="product-excerpt">' . get_the_excerpt() . '</div>';
    }
}

if (!function_exists('osf_woocommerce_list_get_rating')) {
    function osf_woocommerce_list_show_rating() {
        global $product;
        echo wc_get_rating_html($product->get_average_rating());
    }
}

if (!function_exists('osf_woocommerce_time_sale')) {
    function osf_woocommerce_time_sale() {
        /**
         * @var $product WC_Product
         */
        global $product;
        $time_sale = get_post_meta($product->get_id(), '_sale_price_dates_to', true);
        if ($time_sale) {
            wp_enqueue_script('otf-countdown');
            $time_sale += (get_option('gmt_offset') * 3600);
            echo '<div class="time">
                    <div class="deal-text d-none">' . esc_html__('Hurry up. Offer end in', 'medilazar-core') . '</div>
                    <div class="opal-countdown clearfix typo-quaternary"
                        data-countdown="countdown"
                        data-days="' . esc_html__("days", "medilazar-core") . '" 
                        data-hours="' . esc_html__("hours", "medilazar-core") . '"
                        data-minutes="' . esc_html__("mins", "medilazar-core") . '"
                        data-seconds="' . esc_html__("secs", "medilazar-core") . '"
                        data-Message="' . esc_html__('Expired', 'medilazar-core') . '"
                        data-date="' . date('m', $time_sale) . '-' . date('d', $time_sale) . '-' . date('Y', $time_sale) . '-' . date('H', $time_sale) . '-' . date('i', $time_sale) . '-' . date('s', $time_sale) . '">
                    </div>
            </div>';
        }
    }
}
if (!function_exists('osf_output_product_data_accordion')) {
    function osf_output_product_data_accordion() {
        $tabs = apply_filters('woocommerce_product_tabs', array());
        if (!empty($tabs)) : ?>
            <div id="osf-accordion-container" class="woocommerce-tabs wc-tabs-wrapper">
                <?php $_count = 0; ?>
                <?php foreach ($tabs as $key => $tab) : ?>
                    <div data-accordion<?php echo $_count == 0 ? ' class="accordion open"' : ''; ?>>
                        <div data-control class="<?php echo esc_attr($key); ?>_tab"
                             id="tab-title-<?php echo esc_attr($key); ?>">
                            <?php echo apply_filters('woocommerce_product_' . $key . '_tab_title', esc_html($tab['title']), $key); ?>
                        </div>
                        <div data-content>
                            <?php call_user_func($tab['callback'], $key, $tab); ?>
                        </div>
                    </div>
                    <?php $_count++; ?>
                <?php endforeach; ?>
            </div>
        <?php endif;
    }
}


if (!function_exists('osf_woocommerce_cross_sell_display')) {
    function osf_woocommerce_cross_sell_display() {
        echo '<div class="col-12">';
        woocommerce_cross_sell_display(get_theme_mod('osf_woocommerce_cart_cross_sells_limit', 4), get_theme_mod('osf_woocommerce_cart_cross_sells_columns', 4));
        echo '</div>';
    }
}

function osf_woocommerce_render_variable_size() {
    /**
     * @var $product WC_Product_Variable
     */
    global $product;
    if ($product->is_type('variable')) {
        $attr_name = 'pa_size';
        $variables = $product->get_variation_attributes()[$attr_name];
        $terms     = wc_get_product_terms($product->get_id(), $attr_name, array('fields' => 'all'));
        $html      = '<div class="variable-size">';
        foreach ($terms as $term) {
            if (in_array($term->slug, $variables)) {
                $html .= '<span>' . $term->name . '</span>';
            }
        }
        $html .= '</div>';
        echo $html;
    }
}

function osf_woocommerce_render_variable() {
    /**
     * @var $product WC_Product_Variable
     */
    if (!function_exists('TA_WCVS')) {
        return;
    }
    global $product;
    if ($product->is_type('variable')) {
        $attr_name = 'pa_size';
        $variables = $product->get_variation_attributes()[$attr_name];
        $attr      = TA_WCVS()->get_tax_attribute($attr_name);
        $options   = $product->get_available_variations();
        $html      = '<div class="osf-wrap-swatches"><div class="inner">';
        $terms     = wc_get_product_terms($product->get_id(), $attr_name, array('fields' => 'all'));
        foreach ($terms as $term) {
            if (in_array($term->slug, $variables)) {
                $html .= osf_woocommerce_get_swatch_html($term, $attr, $options, $attr_name);
            }
        }
        $html .= '</div></div>';
        echo $html;
    }
}

function osf_woocommerce_get_swatch_html($term, $attr, $options, $attr_name) {
    $html      = '';
    $selected  = '';
    $attr_name = 'attribute_' . $attr_name;
    $name      = esc_html(apply_filters('woocommerce_variation_option_name', $term->name));
    $image     = array();
    foreach ($options as $option) {
        foreach ($option['attributes'] as $_k => $_v) {
            if ($_k === $attr_name && $_v === $term->slug) {
                $image = $option['image'];
                break;
            }
            if (count($image) > 0) {
                break;
            }
        }
    }
    switch ($attr->attribute_type) {
        case 'color':
            $color = get_term_meta($term->term_id, 'color', true);
            list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");
            $html = sprintf(
                '<span class="swatch swatch-color osf-tooltip swatch-%s %s" data-image="%s" style="background-color:%s;color:%s;" title="%s" data-value="%s">%s</span>',
                esc_attr($term->slug),
                $selected,
                htmlspecialchars(wp_json_encode($image)),
                esc_attr($color),
                "rgba($r,$g,$b,0.5)",
                esc_attr($name),
                esc_attr($term->slug),
                $name
            );
            break;

        case 'image':
            $image = get_term_meta($term->term_id, 'image', true);
            $image = $image ? wp_get_attachment_image_src($image) : '';
            $image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
            $html  = sprintf(
                '<span class="swatch swatch-image swatch-%s osf-tooltip %s" data-image="%s" title="%s" data-value="%s"><img src="%s" alt="%s">%s</span>',
                esc_attr($term->slug),
                $selected,
                htmlspecialchars(wp_json_encode($image)),
                esc_attr($name),
                esc_attr($term->slug),
                esc_url($image),
                esc_attr($name),
                esc_attr($name)
            );
            break;

        case 'label':
            $label = get_term_meta($term->term_id, 'label', true);
            $label = $label ? $label : $name;
            $html  = sprintf(
                '<span class="swatch swatch-label swatch-%s %s" data-image="%s" title="%s" data-value="%s">%s</span>',
                esc_attr($term->slug),
                $selected,
                htmlspecialchars(wp_json_encode($image)),
                esc_attr($name),
                esc_attr($term->slug),
                esc_html($label)
            );
            break;
    }

    return $html;
}


function osf_woocommerce_single_product_image_thumbnail_html($image, $attachment_id) {
    return wc_get_gallery_image_html($attachment_id, true);
}

if (!function_exists('osf_active_filters')) {
    function osf_active_filters() {
        if (is_filtered()) {
            $link_remove_all = $_SERVER['REQUEST_URI'];
            $link_remove_all = strtok($link_remove_all, '?');
            echo '<div class="osf-active-filters"> <span class="osf_active_filters_label">' . esc_html__('Active Filters: ', 'medilazar-core') . '</span>';
            the_widget('WC_Widget_Layered_Nav_Filters');
            echo '
                <a class="clear-all" href="' . esc_url($link_remove_all) . '">' . __('Clear Filters', 'medilazar-core') . '</a>
            </div>';
        }

    }
}

if (!function_exists('osf_single_product_video')) {
    function osf_single_product_video() {
        global $product;
        $video = get_post_meta($product->get_id(), 'osf_products_video', true);
        if (!$video) {
            return;
        }
        $video_thumbnail = get_post_meta($product->get_id(), 'osf_products_video_thumbnail_id', true);
        if ($video_thumbnail) {
            $video_thumbnail = wp_get_attachment_image_url($video_thumbnail, 'thumbnail');
        } else {
            $video_thumbnail = wc_placeholder_img_src();
        }
        $video = wc_do_oembeds($video);
        echo '<div data-thumb="' . esc_url_raw($video_thumbnail) . '" class="woocommerce-product-gallery__image">
    <a>
        ' . $video . '

    </a>
</div>';
    }
}

if (!function_exists('osf_single_product_social')) {
    function osf_single_product_social() {
        if (get_theme_mod('osf_socials')) {
            $template      = MEDILAZAR_CORE_PLUGIN_DIR . 'templates/socials.php';
            $socials_label = true;
            if (file_exists($template)) {
                require $template;
            }
        }
    }
}

if (!function_exists('osf_single_product_review_author')) {
    function osf_single_product_review_author() {
        echo '<strong class="woocommerce-review__author">' . get_comment_author() . ' </strong>';
    }
}

if (!function_exists('osf_single_product_quantity_label')) {
    function osf_single_product_quantity_label() {
        global $product;
        $min_value = apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product);
        $max_value = apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product);
        if ($max_value && $min_value !== $max_value) {
            echo '<label class="quantity_label">' . __('Quantity:', 'medilazar-core') . ' </label>';
        }
    }
}

/**
 * Check if a product is a deal
 *
 * @param int|object $product
 *
 * @return bool
 */

if (!function_exists('osf_woocommerce_is_deal_product')) {
    function osf_woocommerce_is_deal_product($product) {
        $product = is_numeric($product) ? wc_get_product($product) : $product;

        // It must be a sale product first
        if (!$product->is_on_sale()) {
            return false;
        }

        if (!$product->is_in_stock()) {
            return false;
        }

        // Only support product type "simple" and "external"
        if (!$product->is_type('simple') && !$product->is_type('external')) {
            return false;
        }

        $deal_quantity = get_post_meta($product->get_id(), '_deal_quantity', true);

        if ($deal_quantity > 0) {
            return true;
        }

        return false;
    }
}


/**
 * Display deal progress on shortcode
 */
if (!function_exists('osf_woocommerce_deal_progress')) {
    function osf_woocommerce_deal_progress() {
        global $product;

        $limit = get_post_meta($product->get_id(), '_deal_quantity', true);
        $sold  = intval(get_post_meta($product->get_id(), '_deal_sales_counts', true));
        if (empty($limit)) {
            return;
        }

        ?>

        <div class="deal-sold">
            <span class="deal-text d-block"><span><?php esc_html_e('Hurry! only', 'medilazar-core') ?></span>
                <span class="c-primary"><?php echo esc_attr(trim($limit - $sold)) ?></span> <span><?php esc_html_e('left in stock.', 'medilazar-core') ?></span></span>
            <div>
                <div class="deal-progress">
                    <div class="progress-bar">
                        <div class="progress-value" style="width: <?php echo trim($sold / $limit * 100) ?>%"></div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
}

if (!function_exists('osf_woocommerce_single_deal')) {
    function osf_woocommerce_single_deal() {
        global $product;


        if (!osf_woocommerce_is_deal_product($product)) {
            return;
        }
        ?>

        <div class="opal-woocommerce-deal deal">
            <?php
            osf_woocommerce_deal_progress();
            osf_woocommerce_time_sale();
            ?>
        </div>
        <?php
    }
}

//Recently Viewed Product
function otf_woocommerce_recently_viewed_product() {
    if (get_theme_mod('otf_woocommerce_extra_enable_product_recently_viewed', false)) {
        $columns = get_theme_mod('otf_woocommerce_extra_product_recently_viewed_columns', 5);
        if (!empty($_COOKIE['otf_woocommerce_recently_viewed'])) {
            echo '<div class="otf-product-recently-review">';
            echo '<h2 class="otf-woocommerce-recently-viewed">' . esc_html__('Your Recently Viewed', 'medilazar-core') . '</h2>';
            echo '<div class="otf-product-recently-content" id="otf-woocommerce-recently-viewed"><div class="otf-product-recently-content-overlay"></div>';
            echo '<div class="woocommerce-product" data-columns="' . esc_attr($columns) . '">';
            otf_woocommerce_widget_recently_viewed();
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

    }
}

function otf_wc_track_product_view() {

    if (!is_singular('product')) {
        return;
    }

    global $post;

    if (!isset($_COOKIE['otf_woocommerce_recently_viewed']) || isset($_COOKIE['otf_woocommerce_recently_viewed']) && empty($_COOKIE['otf_woocommerce_recently_viewed'])) {
        $viewed_products = array();
    } else {
        $viewed_products = (array)explode('|', $_COOKIE['otf_woocommerce_recently_viewed']);
    }

    // Unset if already in viewed products list.
    $keys = array_flip($viewed_products);
    if (isset($keys[$post->ID])) {
        unset($viewed_products[$keys[$post->ID]]);
    }

    $viewed_products[] = $post->ID;

    if (count($viewed_products) > 15) {
        array_shift($viewed_products);
    }

    // Store for session only.
    wc_setcookie('otf_woocommerce_recently_viewed', implode('|', $viewed_products));
}

add_action('template_redirect', 'otf_wc_track_product_view', 20);

function otf_woocommerce_widget_recently_viewed() {
    $viewed_products = !empty($_COOKIE['otf_woocommerce_recently_viewed']) ? (array)explode('|', wp_unslash($_COOKIE['otf_woocommerce_recently_viewed'])) : array(); // @codingStandardsIgnoreLine
    $viewed_products = array_reverse(array_filter(array_map('absint', $viewed_products)));
    if (empty($viewed_products)) {
        return;
    }

    $columns = get_theme_mod('otf_woocommerce_extra_product_recently_viewed_columns', 5);

    ob_start();


    $query_args = array(
        'posts_per_page' => $columns,
        'no_found_rows'  => 1,
        'post_status'    => 'publish',
        'post_type'      => 'product',
        'post__in'       => $viewed_products,
        'orderby'        => 'post__in',
    );

    if ('yes' === get_option('woocommerce_hide_out_of_stock_items')) {
        $query_args['tax_query'] = array(
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'outofstock',
                'operator' => 'NOT IN',
            ),
        ); // WPCS: slow query ok.
    }

    $products = new WP_Query($query_args);

    if ($products->have_posts()) {
        echo '<div class="widget woocommerce widget_recently_viewed_products">';

        echo '<ul class="product_list_widget products columns-' . $columns . '">';

        while ($products->have_posts()) {
            $products->the_post();
            global $product;

            if (!is_a($product, 'WC_Product')) {
                return;
            }
            ?>
            <li class="recently_viewed_product-item">
                <a href="#" class="recently_viewed_product-item-remove"
                   data-productid="<?php echo $product->get_id(); ?>"><i class="fa fa-times-circle"></i></a>
                <div class="inner">
                    <a class="product-thumbnail" href="<?php echo esc_url($product->get_permalink()); ?>">
                        <?php echo apply_filters('the_content', $product->get_image()); ?>
                    </a>
                    <div class="product-content">
                        <h3 class="product-title">
                            <a href="<?php echo esc_url($product->get_permalink()); ?>"><?php echo wp_kses_post($product->get_name()); ?></a>
                        </h3>
                    </div>

                </div>
            </li>
            <?php
        }

        echo '</ul>';

        echo '</div>';
    }

    wp_reset_postdata();

    $content = ob_get_clean();

    echo $content; // WPCS: XSS ok.
}


function osf_woocommerce_single_breadcrumb() {
    if (function_exists('bcn_display')) {
        bcn_display();
    }
}


function filter_yith_woocompare_main_script_localize_array($var) {
    $var['loader'] = '';

    return $var;
}

add_filter('yith_woocompare_main_script_localize_array', 'filter_yith_woocompare_main_script_localize_array', 10, 1);

function filter_yith_quick_view_loader_gif() {
    return '';
}

add_filter('yith_quick_view_loader_gif', 'filter_yith_quick_view_loader_gif', 10, 1);


function osf_woocommerce_single_product_image_gallery_classes($array) {
    global $product;
    $gallery = $product->get_gallery_image_ids();
    if (count($gallery) > 0) {
        $array[] = 'osf_has_image_gallery';
    } else {
        $array[] = 'osf_no_image_gallery';
    }

    return $array;
}

add_filter('woocommerce_single_product_image_gallery_classes', 'osf_woocommerce_single_product_image_gallery_classes', 10, 1);

function osf_woocommerce_pagination_args($args) {
    $args['prev_text'] = '<span class="opal-icon-angle-left"></span>' . __('PREV', 'medilazar-core');
    $args['next_text'] = __('NEXT', 'medilazar-core') . '<span class="opal-icon-angle-right"></span>';
    $args['type']      = 'plain';

    return $args;
}

add_filter('woocommerce_pagination_args', 'osf_woocommerce_pagination_args', 10, 1);

// define the woocommerce_empty_price_html callback
function filter_woocommerce_empty_price_html($var, $instance) {
    return esc_html__('Free', 'medilazar-core');
}

;

// add the filter
add_filter('woocommerce_empty_price_html', 'filter_woocommerce_empty_price_html', 10, 2);

/**
 * @snippet       Display "Quantity: #" @ WooCommerce Single Product Page
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 3.6.2
 */

//add_filter( 'woocommerce_get_availability_text', 'woocommerce_custom_get_availability_text', 99, 2 );

function woocommerce_custom_get_availability_text($availability, $product) {
    $availability = '<span class="label">' . esc_html__('Availability: ', 'medilazar-core') . '</span><span class="stock-availability">' . $availability . '</span>';

    return $availability;
}

if (!function_exists('osf_button_grid_list_layout')) {
    function osf_button_grid_list_layout() {
        ?>
        <div class="gridlist-toggle desktop-hide-down">
            <a href="<?php echo esc_url(add_query_arg('display', 'grid')); ?>" id="grid" class="<?php echo isset($_GET['display']) && $_GET['display'] == 'list' ? '' : 'active'; ?>" title="<?php echo esc_html__('Grid View', 'medilazar-core'); ?>"><i class="opal-icon-th-grid" aria-hidden="true"></i></a>
            <a href="<?php echo esc_url(add_query_arg('display', 'list')); ?>" id="list" class="<?php echo isset($_GET['display']) && $_GET['display'] == 'list' ? 'active' : ''; ?>" title="<?php echo esc_html__('List View', 'medilazar-core'); ?>"><i class="opal-icon-th-list" aria-hidden="true"></i></a>
        </div>
        <?php
    }
}

add_filter('woocommerce_sale_flash', 'osf_woocommerce_show_product_sale_flash');
function osf_woocommerce_show_product_sale_flash() {

    global $post, $product;
    if ($product->is_on_sale()) :

        return '<span class="onsale"><span>' . esc_html__('Sale!', 'medilazar-core') . '</span></span>';
    endif;

}

class osf_Custom_Walker_Category extends Walker_Category {

    public function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0) {
        /** This filter is documented in wp-includes/category-template.php */
        $cat_name = apply_filters(
            'list_cats',
            esc_attr($category->name),
            $category
        );

        // Don't generate an element if the category name is empty.
        if (!$cat_name) {
            return;
        }

        $link = '<a class="pf-value" href="' . esc_url(get_term_link($category)) . '" data-val="' . esc_attr($category->slug) . '" data-title="' . esc_attr($category->name) . '" ';
        if ($args['use_desc_for_title'] && !empty($category->description)) {
            /**
             * Filters the category description for display.
             *
             * @param string $description Category description.
             * @param object $category Category object.
             *
             * @since 1.2.0
             *
             */
            $link .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $category->description, $category))) . '"';
        }

        $link .= '>';
        $link .= $cat_name . '</a>';

        if (!empty($args['feed_image']) || !empty($args['feed'])) {
            $link .= ' ';

            if (empty($args['feed_image'])) {
                $link .= '(';
            }

            $link .= '<a href="' . esc_url(get_term_feed_link($category->term_id, $category->taxonomy, $args['feed_type'])) . '"';

            if (empty($args['feed'])) {
                $alt = ' alt="' . sprintf(esc_html__('Feed for all posts filed under %s', 'medilazar-core'), $cat_name) . '"';
            } else {
                $alt  = ' alt="' . $args['feed'] . '"';
                $name = $args['feed'];
                $link .= empty($args['title']) ? '' : $args['title'];
            }

            $link .= '>';

            if (empty($args['feed_image'])) {
                $link .= $name;
            } else {
                $link .= "<img src='" . $args['feed_image'] . "'$alt" . ' />';
            }
            $link .= '</a>';

            if (empty($args['feed_image'])) {
                $link .= ')';
            }
        }

        if (!empty($args['show_count'])) {
            $link .= ' (' . number_format_i18n($category->count) . ')';
        }
        if ('list' == $args['style']) {
            $output      .= "\t<li";
            $css_classes = array(
                'cat-item',
                'cat-item-' . $category->term_id,
            );

            if (!empty($args['current_category'])) {
                // 'current_category' can be an array, so we use `get_terms()`.
                $_current_terms = get_terms(
                    $category->taxonomy,
                    array(
                        'include'    => $args['current_category'],
                        'hide_empty' => false,
                    )
                );

                foreach ($_current_terms as $_current_term) {
                    if ($category->term_id == $_current_term->term_id) {
                        $css_classes[] = 'current-cat pf-active';
                    } elseif ($category->term_id == $_current_term->parent) {
                        $css_classes[] = 'current-cat-parent';
                    }
                    while ($_current_term->parent) {
                        if ($category->term_id == $_current_term->parent) {
                            $css_classes[] = 'current-cat-ancestor';
                            break;
                        }
                        $_current_term = get_term($_current_term->parent, $category->taxonomy);
                    }
                }
            }

            /**
             * Filters the list of CSS classes to include with each category in the list.
             *
             * @param array $css_classes An array of CSS classes to be applied to each list item.
             * @param object $category Category data object.
             * @param int $depth Depth of page, used for padding.
             * @param array $args An array of wp_list_categories() arguments.
             *
             * @since 4.2.0
             *
             * @see wp_list_categories()
             *
             */
            $css_classes = implode(' ', apply_filters('category_css_class', $css_classes, $category, $depth, $args));

            $output .= ' class="' . $css_classes . '"';
            $output .= ">$link\n";
        } elseif (isset($args['separator'])) {
            $output .= "\t$link" . $args['separator'] . "\n";
        } else {
            $output .= "\t$link<br />\n";
        }
    }
}

if (!function_exists('osf_show_categories_dropdown')) {
    function osf_show_categories_dropdown() {
        static $id = 0;
        $args  = array(
            'hide_empty' => 1,
            'parent'     => 0
        );
        $terms = get_terms('product_cat', $args);
        if (!empty($terms) && !is_wp_error($terms)) {
            ?>
            <div class="search-by-category input-dropdown">
                <div class="input-dropdown-inner medilazar-scroll-content">
                    <!--                    <input type="hidden" name="product_cat" value="0">-->
                    <a href="#" data-val="0"><span><?php esc_html_e('All category', 'medilazar-core'); ?></span></a>
                    <?php
                    $args_dropdown = array(
                        'id'               => 'product_cat' . $id++,
                        'show_count'       => 0,
                        'class'            => 'dropdown_product_cat_ajax',
                        'show_option_none' => esc_html__('All category', 'medilazar-core'),
                    );
                    wc_product_dropdown_categories($args_dropdown);
                    ?>
                    <div class="list-wrapper medilazar-scroll">
                        <ul class="medilazar-scroll-content">
                            <li class="d-none1">
                                <a href="#" data-val="0"><?php esc_html_e('All category', 'medilazar-core'); ?></a></li>
                            <?php
                            if (!apply_filters('medilazar_show_only_parent_categories_dropdown', false)) {
                                $args_list = array(
                                    'title_li'           => false,
                                    'taxonomy'           => 'product_cat',
                                    'use_desc_for_title' => false,
                                    'walker'             => new osf_Custom_Walker_Category(),
                                );
                                wp_list_categories($args_list);
                            } else {
                                foreach ($terms as $term) {
                                    ?>
                                    <li>
                                        <a href="#" data-val="<?php echo esc_attr($term->slug); ?>"><?php echo esc_attr($term->name); ?></a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
