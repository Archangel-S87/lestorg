<?php

if (empty(WC_ABSPATH)) return;

require_once 'admin/WC_LT_Admin.php';
require_once 'admin/functions.php';
require_once 'admin/WC_LT_Attributes.php';

require_once 'includes/WC_LT_Product_Gallery_Images.php';
require_once 'includes/WC_LT_Loop.php';
require_once 'includes/WC_LT_Single_Product.php';
require_once 'includes/WC_LT_Filters.php';

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

/*
 * Меняю вывод breadcrumbs
 */
add_filter('woocommerce_breadcrumb_defaults', 'replace_breadcrumbs_defaults');
function replace_breadcrumbs_defaults($args)
{
    return [
        'wrap_before' => '<ul class="breadcrumbs">',
        'wrap_after' => '</ul>',
        'before' => '<li>',
        'after' => '</li>',
        'home' => _x('Home', 'breadcrumb', 'woocommerce'),
    ];
}

add_filter('woocommerce_get_breadcrumb', 'replace_woocommerce_breadcrumbs');
function replace_woocommerce_breadcrumbs($breadcrumbs)
{
    $breadcrumbs[0][0] = '<i class="ic ic-home"></i> Главная';
    // Убираю из вывода родительскую категорию
    if (count($breadcrumbs) > 2) {
        unset($breadcrumbs[1]);
        sort($breadcrumbs);
    }
    return $breadcrumbs;
}

function woocommerce_content() {

    if (is_singular('product')) {

        while (have_posts()) :
            the_post();
            wc_get_template_part('content', 'single-product');
        endwhile;

    } else {

        if (apply_filters('woocommerce_show_page_title', true)) {
            $current_term = get_queried_object();
            if (apply_filters('print_title_tabs_in_category', true, $current_term)) {
                // Выводит фильтр в категориях товаров
                wc_get_template('global/title-tabs.php');
            } else {
                echo '<div class="title-inn"><h2>' . $current_term->name . '</h2></div>';
            }
        }

        if (!woocommerce_product_loop()) {
            do_action('woocommerce_no_products_found');
            return;
        }

        do_action('woocommerce_before_shop_loop');

        woocommerce_product_loop_start();

        if (wc_get_loop_prop('total')) {
            while (have_posts()) {
                the_post();
                wc_get_template_part('content', 'product');
            }
        }

        woocommerce_product_loop_end();

        do_action('woocommerce_after_shop_loop');

    }

}
