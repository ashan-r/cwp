<?php

class medilazar_setup_sidebar {
    public function __construct() {
        add_action('widgets_init', array($this, 'init_sidebar'), 9);
        add_filter('body_class', array($this, 'body_class'));
        add_filter('opal_theme_sidebar', array($this, 'set_sidebar'));
    }

    public function body_class($classes) {
        if (medilazar_is_product_archive() || (function_exists('is_product') && is_product())) {
            $sidebar = '';
        } else {
            if (medilazar_is_woocommerce_activated() && (is_checkout() || is_cart())) {
                $classes[] = '';
            } elseif (is_active_sidebar('sidebar-blog') && !is_404()) {
                $classes[] = 'opal-content-layout-2cr';
            }
        }

        $classes[] = 'opal-default-content-layout';

        return $classes;
    }

    public function init_sidebar() {
        register_sidebar(array(
            'name'          => esc_html__('Blog Sidebar', 'medilazar'),
            'id'            => 'sidebar-blog',
            'description'   => esc_html__('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'medilazar'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
    }

    public function set_sidebar($sidebar) {
        if (medilazar_is_product_archive() || (function_exists('is_product') && is_product())) {
            $sidebar = '';
        } else {
            if (medilazar_is_woocommerce_activated() && (is_checkout() || is_cart())) {
                $sidebar = '';
            } elseif (is_active_sidebar('sidebar-blog') && !is_404()) {
                $sidebar = 'sidebar-blog';
            }
        }

        return $sidebar;
    }
}

return new medilazar_setup_sidebar();