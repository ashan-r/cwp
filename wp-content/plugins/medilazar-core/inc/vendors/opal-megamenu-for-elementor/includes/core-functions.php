<?php

defined('ABSPATH') || exit();
/**
 * @param $menu_id
 *
 * @return array menu settings data
 */
function osf_get_megamenu_item_data($menu_id = false) {
    return get_post_meta($menu_id, 'osf_megamenu_item_data', true);
}

/**
 * update item data
 *
 * @param $menu_id
 * @param $data
 */
function osf_update_item_data($menu_id = false, $data = array()) {
    update_post_meta($menu_id, 'osf_megamenu_item_data', $data);
    do_action('osf_menu_item_updated', $menu_id, $data);
}

/**
 * delete menu item settings data
 *
 * @param int $menu_id
 */
function osf_delete_item_data($menu_id = false) {
    delete_post_meta($menu_id, 'osf_megamenu_item_data');
    do_action('osf_megamenu_item_deleted', $menu_id);
}

/**
 * get elementor post id as menu item id
 *
 * @param int $menu_id
 *
 * @return boolean
 */
function osf_get_post_related_menu($menu_id = false) {
    $post_id = 0;
    $slug    = get_post_meta($menu_id, 'opal_elementor_post_name', true);
    if ($slug) {
        $queried_post = get_page_by_path($slug, OBJECT, 'opal_menu_item');
        if (isset($queried_post->ID)) {
            $post_id = $queried_post->ID;
        }
    }

    return apply_filters('osf_post_related_menu_post_id', $post_id, $menu_id);
}

/**
 * create releated post menu id
 *
 * @param $menu_id
 */
function osf_create_related_post($menu_id = false) {


    $args = apply_filters('osf_megamenu_create_related_post_args', array(
        'post_type'   => 'opal_menu_item',
        'post_title'  => '#' . $menu_id,
        'post_name'   => 'megamenu' . $menu_id,
        'post_status' => 'publish'
    ));

    $post_related_id = wp_insert_post($args);
    // save elementor_post_id meta value
    update_post_meta($menu_id, 'opal_elementor_post_id', $post_related_id);
    update_post_meta($menu_id, 'opal_elementor_post_name', 'megamenu' . $menu_id);
    // trigger events
    do_action('opal_megamenu_releated_post_created', $post_related_id, $args);

    return apply_filters('opal_megamenu_create_releated_post', $post_related_id);
}

/**
 * get menu icon html
 *
 * @param $icon
 *
 * @return string html
 */
function osf_get_icon_html($icon, $data) {
    $style = '';
    if (isset($data['icon_color']) && $data['icon_color']) {
        $style .= 'style="color:' . $data['icon_color'] . '"';
    }

    return apply_filters('osf_menu_icon_html', '<i class="menu-icon ' . $icon . '" ' . $style . '></i>');
}

/**
 * is enabled megamenu
 */
function osf_is_mega_enabled($menu_item_id = false) {
    $item_settings = osf_get_megamenu_item_data($menu_item_id);
    $boolean       = isset($item_settings['enabled']) && $item_settings['enabled'];

    return apply_filters('osf_megamenu_item_enabled', $boolean);
}

/**
 * get megamenu option
 *
 * @param $name
 * @param $deafault
 */
function osf_menu_get_option($name = '', $default = false) {
    $name = 'osf_megamenu_' . $name;

    return apply_filters('osf_megamenu_option', get_option($name, $default));
}

/**
 * get bagde html
 *
 * @param $badge
 */
function osf_get_badge_html($badge, $data) {

    $style = '';
    // echo '<pre>' . print_r( $data ,1 );die;
    if ((isset($data['badge_color']) && $data['badge_color']) || (isset($data['badges_bg_color']) && $data['badges_bg_color'])) {
        $style .= 'style="';
        if ($data['badge_color']) {
            $style .= '	color:' . $data['badge_color'] . '; ';
        }
        if ($data['badges_bg_color']) {
            $style .= '	background-color:' . $data['badges_bg_color'] . '; ';
        }
        $style .= ' "';
    }

    $format = '<small class="menu-badge" %2$s>%1$s</small>';

    return sprintf($format, esc_attr($badge), $style);
}

/**
 * get dropdown arrow html
 */
function osf_get_dropdown_arrow_html($icon = '') {
    return apply_filters('opal_menu_dropdown_arrow_icon_format', sprintf('<i class="opal-dropdown-arrow fa %s"></i>', esc_attr($icon)));
}

/**
 * get arrows icons
 */
function osf_get_arrows_icons() {
    return apply_filters('osf_arrows_icons', array(
        'fa fa-angle-down',
        'fa fa-angle-double-down',
        'fa fa-arrow-circle-down',
        'fa fa-arrow-down',
        'fa fa-caret-down',
        'fa fa-chevron-circle-down',
        'fa fa-chevron-down',
        'fa fa-long-arrow-down',
        'fa fa-angle-right',
        'fa-angle-double-right',
        'fa-arrow-circle-right',
        'fa-arrow-right',
        'fa-caret-right',
        'fa-chevron-circle-right',
        'fa-chevron-right',
        'fa-long-arrow-right',
        'fa-angle-left',
        'fa-angle-double-left',
        'fa-arrow-circle-left',
        'fa-arrow-left',
        'fa-caret-left',
        'fa-chevron-circle-left',
        'fa-chevron-left',
        'fa-long-arrow-left'
    ));
}

function osf_get_fontawesome_icons() {
    if (defined('ELEMENTOR_PATH') && !class_exists('Elementor\Icon')) {
        include_once ELEMENTOR_PATH . "includes/controls/icon.php";
    }
    $icons = json_decode(file_get_contents(trailingslashit(MEDILAZAR_CORE_PLUGIN_DIR) . 'inc/vendors/elementor/icons.json'), true);
    $icons = apply_filters('osf_languages_directory', array_merge($icons, Elementor\Control_Icon::get_icons()));
    return $icons;
}