<?php
if (version_compare($GLOBALS['wp_version'], '4.7-alpha', '<')) {
	require get_theme_file_path('inc/back-compat.php');

	return;
}
if (is_admin()) {
	require get_theme_file_path('inc/admin/class-admin.php');
}

require get_theme_file_path('inc/tgm-plugins.php');
require get_theme_file_path('inc/template-tags.php');
require get_theme_file_path('inc/template-functions.php');
require get_theme_file_path('inc/class-main.php');
require get_theme_file_path('inc/starter-settings.php');

if (!class_exists('MedilazarCore')) {
	if (medilazar_is_woocommerce_activated()) {
		require get_theme_file_path('inc/vendors/woocommerce/woocommerce-template-functions.php');
		require get_theme_file_path('inc/vendors/woocommerce/class-woocommerce.php');
		require get_theme_file_path('inc/vendors/woocommerce/woocommerce-template-hooks.php');
	}
	// Blog Sidebar
	require get_theme_file_path('inc/class-sidebar.php');
}

function action_woocommerce_admin_order_item_headers()
{ ?>
	<th class="item sortable" colspan="2" data-sort="string-ins"><?php _e('Categoria', 'woocommerce'); ?></th>
<?php
};


// define the woocommerce_admin_order_item_values callback
function action_woocommerce_admin_order_item_values($_product, $item, $item_id)
{ ?>
	<td class="name" colspan="2">
		<?php
		$category_names = [];
		if ($_product) {
			$termsp = get_the_terms($_product->get_id(), 'product_cat');
			if (!empty($termsp)) {
				foreach ($termsp as $term) {
					$_categoryid = $term->term_id;
					if ($term = get_term_by('id', $_categoryid, 'product_cat')) {

						$category_names[] = $term->name;
					}
				}
			}
		}
		echo implode(', ', $category_names)
		?>
	</td>
<?php
};

// add the action
add_action('woocommerce_admin_order_item_values', 'action_woocommerce_admin_order_item_values', 10, 3);
add_action('woocommerce_admin_order_item_headers', 'action_woocommerce_admin_order_item_headers', 10, 0);
