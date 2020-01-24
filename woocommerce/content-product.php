<?php

/*
 * Все фунции описаны в классах описаных в WC_LT_Content
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (!$product || !$product->is_visible()) return;

$attrs = apply_filters('lt_wc_product_wrap_loop', [
    'class' => wc_get_product_class('', $product)
]);

?>

<div <?php get_tag_attr($attrs); ?>>

    <?php
    /**
     * Hook: woocommerce_before_shop_loop_item.
     *
     * @hooked template_product_open - 10
     */
    do_action('woocommerce_before_shop_loop_item');

    /**
     * Hook: woocommerce_before_shop_loop_item_title.
     *
     * @hooked template_product_link_thumbnail - 5
     */
    do_action('woocommerce_before_shop_loop_item_title');

    /**
     * Hook: woocommerce_shop_loop_item_title.
     *
     * @hooked template_product_title - 10
     */
    do_action('woocommerce_shop_loop_item_title');

    /**
     * Hook: woocommerce_after_shop_loop_item_title.
     */
    do_action('woocommerce_after_shop_loop_item_title');

    /**
     * Hook: woocommerce_after_shop_loop_item.
     *
     * @hooked template_product_close - 10
     */
    do_action('woocommerce_after_shop_loop_item');
    ?>

</div>
