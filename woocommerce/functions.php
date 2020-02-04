<?php

// Получает thumbnail src продукта
function lestorg_woocommerce_get_thumbnail_image($size = 'woocommerce_thumbnail', $placeholder = true) {
    global $product;
    if (!$product instanceof WC_Product) return null;

    $size = apply_filters('single_product_archive_thumbnail_size', $size);

    $image = null;
    if ($product->get_image_id()) {
        $image = wp_get_attachment_image_url($product->get_image_id(), $size);
    } elseif ($product->get_parent_id()) {
        $parent_product = wc_get_product($product->get_parent_id());
        if ($parent_product) {
            $image = wp_get_attachment_image_url($parent_product->get_image_id(), $size);
        }
    }

    if (!$image && $placeholder) {
        $image = wc_placeholder_img_src($size);
    }

    return apply_filters('lestorg_product_get_image', $image, $product, $size, $image, $placeholder);
}

function set_product_loop_in_swiper($attrs) {
    $classes = $attrs['class'] ?? [];
    $classes = remove_value_array('catalog-grid__col', $classes);
    $classes[] = 'swiper-slide';
    $attrs['class'] = $classes;
    return $attrs;
}

function get_top_parent_id_product_cat($category_id) {
    do {
        $cat = get_term($category_id, 'product_cat');
        $category_id = $cat->parent;
        $category_parent_id = $cat->term_id;
    } while ($category_id);
    return $category_parent_id;
}

/*
 * Находит товар в карзине по переданому id
 */
function find_cart_item_by_id($product_id) {
    $cart_item_key = '';
    foreach (WC()->cart->get_cart() as $key => $item) {
        if ($item['product_id'] == $product_id) {
            $cart_item_key = $key;
            break;
        }
    }
    return $cart_item_key;
}
