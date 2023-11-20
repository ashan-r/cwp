<?php

/**
 * Enqueue script and styles for child theme
 */
function cm_child_enqueue_styles_and_scripts()
{
	wp_enqueue_style('child-styles', get_stylesheet_directory_uri() . '/style.css', false, time(), 'all');
	wp_enqueue_style('cm-elementor-styles', get_stylesheet_directory_uri() . '/css/cm-elementor.css', false, time(), 'all');
	wp_enqueue_script("si_script", get_stylesheet_directory_uri() . "/js/custom.js", '', time());
}
add_action('wp_enqueue_scripts', 'cm_child_enqueue_styles_and_scripts', 110000);

/**
 * Add category column to Woocommerce order details page in admin
 */
function cm_action_woocommerce_admin_order_item_headers()
{ ?>
	<th class="item sortable" colspan="2" data-sort="string-ins"><?php _e('Categoria', 'woocommerce'); ?></th>
<?php
};

function cm_action_woocommerce_admin_order_item_values($_product, $item, $item_id)
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

add_action('woocommerce_admin_order_item_values', 'cm_action_woocommerce_admin_order_item_values', 10, 3);
add_action('woocommerce_admin_order_item_headers', 'cm_action_woocommerce_admin_order_item_headers', 10, 0);


/**
 * Override osf_single_product_quantity_label with 
 */
remove_action('woocommerce_before_add_to_cart_quantity', 'osf_single_product_quantity_label', 10);
add_action('woocommerce_before_add_to_cart_quantity', 'cm_single_product_quantity_label', 10);
function cm_single_product_quantity_label() {
	global $product;
	$min_value = apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product);
	$max_value = apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product);
	if ($max_value && $min_value !== $max_value) {
	echo '<label class="quantity_label">' . __('Cantidad:', 'medilazar') . ' </label>';
	}
}

/**
 * Change add to cart button text on single page
 */
function cm_woocommerce_add_to_cart_button_text_single() {
    return __( 'Añadir a la cesta', 'woocommerce' ); 
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'cm_woocommerce_add_to_cart_button_text_single' ); 