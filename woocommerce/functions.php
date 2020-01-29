<?php

if (empty(WC_ABSPATH)) return;

require_once 'admin/WC_LT_Admin.php';
require_once 'admin/functions.php';

require_once 'includes/WC_LT_Content.php';
require_once 'includes/WC_LT_Product_Gallery_Images.php';
require_once 'includes/WC_LT_Single_Product.php';
require_once 'includes/WC_LT_Filters.php';

require_once 'includes/WC_LT_Category.php';
require_once 'includes/WC_LT_Category_Tabs.php';
require_once 'includes/WC_LT_Category_Simple.php';


// Получает thumbnail src продукта
function lt_woocommerce_get_thumbnail_image($size = 'woocommerce_thumbnail', $placeholder = true) {
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

    return apply_filters('lt_product_get_image', $image, $product, $size, $image, $placeholder);
}

function lt_run_category_template($term_id = 0) {
    $content = WC_LT_Content::get_instance();
    $content->set_term($term_id);
    $category_template = $content->get_class_template();
    $category_template->run();
    $GLOBALS['lt_wc_category_template'] = $category_template;
}

function lt_reset_category_template() {
    global $lt_wc_category_template;
    if (!$lt_wc_category_template instanceof WC_LT_Category) return;
    $lt_wc_category_template->reset();
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

/**
 * Получает корзину из глобального объекта $woocommerce
 * @return WC_Cart | null
 */
function lt_get_cart() {
    global $woocommerce;
    $cart = $woocommerce->cart;
    if (!$cart instanceof WC_Cart) return null;
    return $cart;
}

/*
 * Получает количество товаров в карзине
 */
function lt_get_count_products_in_cart() {
    $cart = lt_get_cart();
    return count($cart->cart_contents);
}

/*
 * Находит товар в карзине по переданому id
 */
function find_cart_item_by_id($product_id)
{
    $cart = lt_get_cart();

    $cart_item_key = '';
    $contents = $cart->cart_contents;

    foreach ($contents as $key => $item) {
        if ($item['product_id'] == $product_id) {
            $cart_item_key = $key;
            break;
        }
    }

    return $cart_item_key;
}
