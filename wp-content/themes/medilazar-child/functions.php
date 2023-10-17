<?php

/**
 * Enqueue script and styles for child theme
 */
function cm_child_enqueue_styles_and_scripts()
{
	wp_enqueue_style('child-styles', get_stylesheet_directory_uri() . '/style.css', false, time(), 'all');
	wp_enqueue_script("si_script", get_stylesheet_directory_uri() . "/js/custom.js", '', time());
}
add_action('wp_enqueue_scripts', 'cm_child_enqueue_styles_and_scripts', 110000);

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
