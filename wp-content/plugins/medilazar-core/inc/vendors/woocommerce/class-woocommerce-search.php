<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('osf_WooCommerce_Search')) :


    class osf_WooCommerce_Search {
        public function __construct() {
            add_action('wp_ajax_osf_woo_search', array($this, 'ajax_search_product'));
            add_action('wp_ajax_nopriv_osf_woo_search', array($this, 'ajax_search_product'));
        }

        public function ajax_search_product() {

            $the_query = new WP_Query(array(
                'posts_per_page' => 8,
                's'              => esc_attr($_REQUEST['keyword']),
                'post_type'      => 'product'
            ));
            if ($the_query->have_posts()) :
                echo '<ul class="product_list_widget">';
                while ($the_query->have_posts()): $the_query->the_post();
                    wc_get_template_part('content', 'widget-product');
                endwhile;
                echo '</ul>';
                ?>
                <a class="button-link-search" href="<?php echo get_site_url() . '?s=' . esc_attr($_REQUEST['keyword']) . '&post_type=product'; ?>"><?php printf(__('Show All %s Results', 'medilazar-core'), $the_query->found_posts); ?>
                    <i class="opal-icon-arrow" aria-hidden="true"></i></a>
            <?php
            else:
                ?>
                <h4><?php echo __('No products found', 'medilazar-core'); ?></h4>
                <?php
                wp_reset_postdata();
            endif;

            die;

        }

    }

endif;

new osf_WooCommerce_Search();
