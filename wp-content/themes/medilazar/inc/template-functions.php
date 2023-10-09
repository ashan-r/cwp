<?php
/**
 * Checks to see if we're on the homepage or not.
 */
if (!function_exists('medilazar_is_frontpage')) {

    function medilazar_is_frontpage() {
        return (is_front_page() || is_home());
    }
}

if (!function_exists('medilazar_is_elementor_activated')) {
    function medilazar_is_elementor_activated() {
        return function_exists('elementor_load_plugin_textdomain');
    }
}

if (!function_exists('medilazar_is_woocommerce_activated')) {
    function medilazar_is_woocommerce_activated() {
        return class_exists('WooCommerce') ? true : false;
    }
}

if (!function_exists('medilazar_is_woocommerce_extension_activated')) {
    function medilazar_is_woocommerce_extension_activated($extension = 'WC_Bookings') {
        if ($extension == 'YITH_WCQV') {
            return class_exists($extension) && class_exists('YITH_WCQV_Frontend') ? true : false;
        }

        return class_exists($extension) ? true : false;
    }
}

if (!function_exists('medilazar_is_product_archive')) {

    /**
     * Checks if the current page is a product archive
     * @return boolean
     */
    function medilazar_is_product_archive() {
        if (medilazar_is_woocommerce_activated()) {
            if (is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

if (!function_exists('medilazar_page_enable_breadcrumb')) {
    /**
     * @return bool
     */
    function medilazar_page_enable_breadcrumb() {

        if (!is_page()) {
            return true;
        }

        $check = medilazar_get_metabox(get_the_ID(), 'osf_enable_breadcrumb', true);

        return $check;
    }
}

/**
 * Determines if post thumbnail can be displayed.
 */
function medilazar_can_show_post_thumbnail() {
    return apply_filters('medilazar_can_show_post_thumbnail', !post_password_required() && !is_attachment() && has_post_thumbnail());
}

if (!function_exists('medilazar_get_query')) {

    /**
     * @param $args
     *
     * @return WP_Query
     */
    function medilazar_get_query($args) {
        global $wp_query;
        $default  = array(
            'post_type' => 'post',
        );
        $args     = wp_parse_args($args, $default);
        $wp_query = new WP_Query($args);

        return $wp_query;
    }
}

if (!function_exists('medilazar_get_placeholder_image')) {

    /**
     * @return string
     */
    function medilazar_get_placeholder_image() {
        return get_parent_theme_file_uri('/assets/images/placeholder.png');
    }

}

if (!function_exists('medilazar_is_osf_framework_activated')) {
    /**
     * Query WooCommerce activation
     */
    function medilazar_is_osf_framework_activated() {
        return class_exists('MedilazarCore') ? true : false;
    }
}


if (!function_exists('medilazar_get_metabox')) {

    /**
     * @param int $id
     * @param string $key
     * @param bool $default
     *
     * @return bool|mixed
     */
    function medilazar_get_metabox($id, $key, $default = false) {
        $value = get_post_meta($id, $key, true);
        if ($value === '') {
            return $default;
        } else {
            return $value;
        }
    }
}

if (!function_exists('medilazar_is_blog_archive')) {
    function medilazar_is_blog_archive() {
        return (is_home() && is_front_page()) || is_category() || is_tag() || is_post_type_archive('post');
    }
}

if (!function_exists('medilazar_get_excerpt')) {
    function medilazar_get_excerpt($excerpt_length = 55) {
        global $post;

        $text = $post->post_excerpt;
        if (empty($text)) {
            $text = $post->post_content;
        }
        $text = strip_shortcodes($text);
        /** This filter is documented in wp-includes/post-template.php */
        $text = apply_filters('the_content', $text);
        $text = str_replace(']]>', ']]&gt;', $text);

        /**
         * Filters the string in the "more" link displayed after a trimmed excerpt.
         *
         * @param string $more_string The string shown within the more link.
         *
         * @since 2.9.0
         *
         */
        $excerpt      = '<span class="more-link-wrap"><a class="more-link" href="' . get_permalink($post->ID) . '"><span>' . esc_html__('Read more', 'medilazar') . '</span></a></span>';
        $excerpt_more = '';
        $excerpt_more = apply_filters('excerpt_more', $excerpt_more);

        return wp_trim_words($text, $excerpt_length, $excerpt_more);
    }
}

if (!function_exists('medilazar_do_shortcode')) {

    /**
     * Call a shortcode function by tag name.
     *
     * @param string $tag The shortcode whose function to call.
     * @param array $atts The attributes to pass to the shortcode function. Optional.
     * @param array $content The shortcode's content. Default is null (none).
     *
     * @return string|bool False on failure, the result of the shortcode on success.
     * @since  1.4.6
     *
     */
    function medilazar_do_shortcode($tag, array $atts = array(), $content = null) {
        global $shortcode_tags;

        if (!isset($shortcode_tags[$tag])) {
            return false;
        }

        return call_user_func($shortcode_tags[$tag], $atts, $content, $tag);
    }
}

if (!function_exists('medilazar_nav_menu_social_icons')) {

    /**
     * Display SVG icons in social links menu.
     *
     * @param string $item_output The menu item output.
     * @param WP_Post $item Menu item object.
     * @param int $depth Depth of the menu.
     * @param object $args wp_nav_menu() arguments.
     *
     * @return string  $item_output The menu item output with social icon.
     */
    function medilazar_nav_menu_social_icons($item_output, $item, $depth, $args) {
        // Get supported social icons.
        $social_icons = medilazar_social_links_icons();

        // Change SVG icon inside social links menu if there is supported URL.
        if ('social' === $args->theme_location) {
            foreach ($social_icons as $attr => $value) {
                if (false !== strpos($item_output, $attr)) {
                    $item_output = str_replace($args->link_after, '</span><i class="' . esc_attr($value) . '" aria-hidden="true"></i>', $item_output);
                }
            }
        }

        return $item_output;
    }
}
add_filter('walker_nav_menu_start_el', 'medilazar_nav_menu_social_icons', 10, 4);

if (!function_exists('medilazar_social_links_icons')) {

    /**
     * Returns an array of supported social links (URL and icon name).
     *
     * @return array $social_links_icons
     */
    function medilazar_social_links_icons() {
        // Supported social links icons.
        $social_links_icons = array(
            'behance.net'     => 'fa fa-behance',
            'codepen.io'      => 'fa fa-codepen',
            'deviantart.com'  => 'fa fa-deviantart',
            'digg.com'        => 'fa fa-digg',
            'dribbble.com'    => 'fa fa-dribbble',
            'dropbox.com'     => 'fa fa-dropbox',
            'facebook.com'    => 'fa fa-facebook',
            'flickr.com'      => 'fa fa-flickr',
            'foursquare.com'  => 'fa fa-foursquare',
            'plus.google.com' => 'fa fa-google-plus',
            'github.com'      => 'fa fa-github',
            'instagram.com'   => 'fa fa-instagram',
            'linkedin.com'    => 'fa fa-linkedin',
            'mailto:'         => 'fa fa-envelope-o',
            'medium.com'      => 'fa fa-medium',
            'pinterest.com'   => 'fa fa-pinterest-p',
            'getpocket.com'   => 'fa fa-get-pocket',
            'reddit.com'      => 'fa fa-reddit-alien',
            'skype.com'       => 'fa fa-skype',
            'skype:'          => 'fa fa-skype',
            'slideshare.net'  => 'fa fa-slideshare',
            'snapchat.com'    => 'fa fa-snapchat-ghost',
            'soundcloud.com'  => 'fa fa-soundcloud',
            'spotify.com'     => 'fa fa-spotify',
            'stumbleupon.com' => 'fa fa-stumbleupon',
            'tumblr.com'      => 'fa fa-tumblr',
            'twitch.tv'       => 'fa fa-twitch',
            'twitter.com'     => 'fa fa-twitter',
            'vimeo.com'       => 'fa fa-vimeo',
            'vine.co'         => 'fa fa-vine',
            'vk.com'          => 'fa fa-vk',
            'wordpress.org'   => 'fa fa-wordpress',
            'wordpress.com'   => 'fa fa-wordpress',
            'yelp.com'        => 'fa fa-yelp',
            'youtube.com'     => 'fa fa-youtube',
        );

        return apply_filters('medilazar_social_links_icons', $social_links_icons);
    }
}

if (!function_exists('medilazar_dropdown_icon_to_menu_link')) {
    /**
     * Add dropdown icon if menu item has children.
     *
     * @param string $title The menu item's title.
     * @param object $item The current menu item.
     * @param object $args An array of wp_nav_menu() arguments.
     * @param int $depth Depth of menu item. Used for padding.
     *
     * @return string $title The menu item's title with dropdown icon.
     */
    function medilazar_dropdown_icon_to_menu_link($title, $item, $args, $depth) {
        if ('top' === $args->theme_location) {
            foreach ($item->classes as $value) {
                if ('menu-item-has-children' === $value || 'page_item_has_children' === $value) {
//                    $title = $title . '<i class="fa fa-angle-down 1"></i>';
                    $title = $title . '<i class="sub-arrow"></i>';
                }
            }
        }

        return $title;
    }
}
add_filter('nav_menu_item_title', 'medilazar_dropdown_icon_to_menu_link', 10, 4);

if (!function_exists('medilazar_is_header_builder')) {
    /**
     * @return bool
     */
    function medilazar_is_header_builder() {
        global $osf_header;
        if ($osf_header && $osf_header instanceof WP_Post) {
            return true;
        }

        return false;
    }
}


if (!function_exists('medilazar_the_header_builder')) {
    /**
     * @return void
     */
    function medilazar_the_header_builder() {
        echo medilazar_get_header_builder_html();
    }
}

if (!function_exists('medilazar_get_header_builder_html')) {

    /**
     * @return string
     */
    function medilazar_get_header_builder_html() {
        $header_content = OSF_Header_builder::getInstance()->render();

        return $header_content;
    }
}

if (!function_exists('medilazar_is_footer_builder')) {
    /**
     * @return bool
     */
    function medilazar_is_footer_builder() {
        global $osf_footer;
        if ($osf_footer && $osf_footer instanceof WP_Post) {
            return true;
        }

        return false;
    }
}

if (!function_exists('medilazar_the_footer_builder')) {
    /**
     * @return void
     */
    function medilazar_the_footer_builder() {
        echo medilazar_get_footer_builder_html();
    }
}


if (!function_exists('medilazar_get_footer_builder_html')) {
    function medilazar_get_footer_builder_html() {
        $footer_content = '<div class="wrap"><div class="container">';
        $footer_content .= OSF_Footer_builder::getInstance()->render();
        $footer_content .= '</div></div>';

        return $footer_content;
    }
}
if (!function_exists('medilazar_license_get_option')) {
    function medilazar_license_get_option($key = '', $default = false) {
        if (function_exists('cmb2_get_option')) {
            // Use cmb2_get_option as it passes through some key filters.
            return cmb2_get_option('lexus-theme-license', $key, $default);
        }
        // Fallback to get_option if CMB2 is not loaded yet.
        $opts = get_option('lexus-theme-license', $default);
        $val  = $default;
        if ('all' == $key) {
            $val = $opts;
        } elseif (is_array($opts) && array_key_exists($key, $opts) && false !== $opts[$key]) {
            $val = $opts[$key];
        }

        return $val;
    }
}


function medilazar_social_share() {
    if (medilazar_is_osf_framework_activated() && get_theme_mod('osf_socials', true)) {
        $template = WP_PLUGIN_DIR . '/medilazar-core/templates/socials.php';
        if (file_exists($template)) {
            require $template;
        }
    }
}

function medilazar_social_heading() {
    return esc_html__('Share:', 'medilazar');
}

add_filter('osf_social_heading', 'medilazar_social_heading');

function medilazar_get_post_link($taxonomy = 'category', $post_type = ['any']) {

    $id    = get_queried_object_id(); // Get the current post ID
    $links = [
        'previous_post' => null,
        'next_post'     => null,
        'previous'      => null,
        'next'          => null
    ];

    // Use a tax_query to get all posts from the given term
    // Just retrieve the ids to speed up the query
    $post_args = [
        'post_type'      => $post_type,
        'fields'         => 'ids',
        'posts_per_page' => -1,
    ];

    // Get all the posts having the given term from all post types
    $q = get_posts($post_args);

    //Get the current post position. Will be used to determine next/previous post
    $current_post_position = array_search($id, $q);

    // Get the previous/older post ID
    if (array_key_exists($current_post_position + 1, $q)) {
        $previous = $q[$current_post_position + 1];
    }
    // Get post title link to the previous post
    if (isset($previous)) {
        $previous_post      = get_post($previous);
        $previous_post_link = get_permalink($previous);
        $previous_title     = '<a href="' . esc_url($previous_post_link) . '">' . esc_html($previous_post->post_title) . '</a>';

    }

    // Get the next/newer post ID
    if (array_key_exists($current_post_position - 1, $q)) {
        $next = $q[$current_post_position - 1];
    }

    // Get post title link to the next post
    if (isset($next)) {
        $next_post      = get_post($next);
        $next_post_link = get_permalink($next);
        $next_title     = '<a href="' . esc_url($next_post_link) . '">' . esc_html($next_post->post_title) . '</a>';

    }

    if (isset($previous_title)) {
        $links['previous_post']  = $previous_title;
        $links['previous']       = $previous_post->ID;
        $links['previous_title'] = $previous_post->post_title;
    }

    if (isset($next_title)) {
        $links['next_post']  = $next_title;
        $links['next']       = $next_post->ID;
        $links['next_title'] = $next_post->post_title;
    }

    return (object)$links;
}


if (!function_exists('medilazar_fnc_related_post')) {
    function medilazar_fnc_related_post($relate_count = 4, $posttype = 'post', $taxonomy = 'category') {

        $terms   = get_the_terms(get_the_ID(), $taxonomy);
        $termids = array();

        if ($terms) {
            foreach ($terms as $term) {
                $termids[] = $term->term_id;
            }
        }

        $args = array(
            'post_type'      => $posttype,
            'posts_per_page' => $relate_count,
            'post__not_in'   => array(get_the_ID()),
            'tax_query'      => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'id',
                    'terms'    => $termids,
                    'operator' => 'IN'
                )
            )
        );

        $related = new WP_Query($args);

        if ($related->have_posts()) {
            echo '<div class="related-posts">';
            echo '<h3 class="related-heading">' . esc_html__('You might also like', 'medilazar') . '</h3>';

            echo '<div class="row">';

            while ($related->have_posts()) : $related->the_post();

                get_template_part('template-parts/posts-grid/item-post', 'style-6');

            endwhile;
            echo '</div>';
            echo '</div>';

            wp_reset_postdata();
        }


    }
}

if (!function_exists('medilazar_get_review_counting')) {
    function medilazar_get_review_counting() {

        global $post;
        $output = array();

        for ($i = 1; $i <= 5; $i++) {
            $args       = array(
                'post_id'    => ($post->ID),
                'meta_query' => array(
                    array(
                        'key'   => 'rating',
                        'value' => $i
                    )
                ),
                'count'      => true
            );
            $output[$i] = get_comments($args);
        }

        return $output;
    }
}


add_action('medilazar_single_after_content', 'medilazar_fnc_nav_post', 10);
if (!function_exists('medilazar_fnc_nav_post')) {
    function medilazar_fnc_nav_post() {
        $obj       = medilazar_get_post_link('category', 'post');
        $prev_link = $obj->previous_post;
        $next_link = $obj->next_post;

        $next_id    = $obj->next;
        $prev_id    = $obj->previous;
        $prev_title = isset($obj->previous_title) ? $obj->previous_title : '';
        $next_title = isset($obj->next_title) ? $obj->next_title : '';


        if (!empty($prev_link) || !empty($next_link)):
            ?>
            <div class="post-navigation">
                <?php if (!empty($prev_link)): ?>
                    <div class="previous-nav">
                        <div class="nav-content">
                            <?php if (get_the_post_thumbnail($prev_id, 'thumbnail')): ?>
                                <div class="thumbnail-nav"><?php echo get_the_post_thumbnail($prev_id, 'thumbnail'); ?></div>
                            <?php endif; ?>
                            <div class="nav-link">
                                <div class="nav-title"><?php esc_html_e('Prev', 'medilazar'); ?></div>
                                <?php if (!empty($prev_title)) echo wp_kses($prev_link, 'post'); // WPCS: XSS ok. ?>
                            </div>
                            <?php echo wp_kses($prev_link, 'post'); // WPCS: XSS ok. ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($next_link)): ?>
                    <div class="next-nav">
                        <div class="nav-content">

                            <div class="nav-link">
                                <div class="nav-title"><?php esc_html_e('Next', 'medilazar'); ?></div>
                                <?php if (!empty($next_title)) echo wp_kses($next_link, 'post'); // WPCS: XSS ok. ?>
                            </div>
                            <?php echo wp_kses($next_link, 'post'); // WPCS: XSS ok. ?>
                            <?php if (get_the_post_thumbnail($next_id, 'thumbnail')): ?>
                                <div class="thumbnail-nav"><?php echo get_the_post_thumbnail($next_id, 'thumbnail'); ?></div>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endif; ?>
            </div>
        <?php endif;
    }
}

if (!function_exists('wp_body_open')) {

    /**
     * Shim for wp_body_open, ensuring backward compatibility with versions of WordPress older than 5.2.
     */
    function wp_body_open() {
        do_action('wp_body_open');
    }
}

function osf_get_the_category_list($separator = '', $parents = '', $post_id = false) {
    global $wp_rewrite;

    if (!is_object_in_taxonomy(get_post_type($post_id), 'category')) {
        /** This filter is documented in wp-includes/category-template.php */
        return apply_filters('the_category', '', $separator, $parents);
    }

    /**
     * Filters the categories before building the category list.
     *
     * @since 4.4.0
     *
     * @param WP_Term[] $categories An array of the post's categories.
     * @param int|bool $post_id ID of the post we're retrieving categories for.
     *                              When `false`, we assume the current post in the loop.
     */
    $categories = apply_filters('the_category_list', get_the_category($post_id), $post_id);

    if (empty($categories)) {
        /** This filter is documented in wp-includes/category-template.php */
        return apply_filters('the_category', __('Uncategorized', 'medilazar'), $separator, $parents);
    }

    $rel = (is_object($wp_rewrite) && $wp_rewrite->using_permalinks()) ? 'rel="category tag"' : 'rel="category"';

    $thelist = '';
    if ('' === $separator) {
        $thelist .= '<ul class="post-categories">';
        foreach ($categories as $category) {
            $thelist .= "\n\t<li>";
            switch (strtolower($parents)) {
                case 'multiple':
                    if ($category->parent) {
                        $thelist .= get_category_parents($category->parent, true, $separator);
                    }
                    $thelist .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" ' . $rel . '><span>' . $category->name . '</span></a></li>';
                    break;
                case 'single':
                    $thelist .= '<a href="' . esc_url(get_category_link($category->term_id)) . '"  ' . $rel . '>';
                    if ($category->parent) {
                        $thelist .= get_category_parents($category->parent, false, $separator);
                    }
                    $thelist .= $category->name . '</a></li>';
                    break;
                case '':
                default:
                    $thelist .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" ' . $rel . '><span>' . $category->name . '</span></a></li>';
            }
        }
        $thelist .= '</ul>';
    } else {
        $i = 0;
        foreach ($categories as $category) {
            if (0 < $i) {
                $thelist .= $separator;
            }
            switch (strtolower($parents)) {
                case 'multiple':
                    if ($category->parent) {
                        $thelist .= get_category_parents($category->parent, true, $separator);
                    }
                    $thelist .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" ' . $rel . '><span>' . $category->name . '</span></a>';
                    break;
                case 'single':
                    $thelist .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" ' . $rel . '>';
                    if ($category->parent) {
                        $thelist .= get_category_parents($category->parent, false, $separator);
                    }
                    $thelist .= "$category->name</a>";
                    break;
                case '':
                default:
                    $thelist .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" ' . $rel . '><span>' . $category->name . '</span></a>';
            }
            ++$i;
        }
    }

    /**
     * Filters the category or list of categories.
     *
     * @since 1.2.0
     *
     * @param string $thelist List of categories for the current post.
     * @param string $separator Separator used between the categories.
     * @param string $parents How to display the category parents. Accepts 'multiple',
     *                          'single', or empty.
     */
    return apply_filters('the_category', $thelist, $separator, $parents);
}
