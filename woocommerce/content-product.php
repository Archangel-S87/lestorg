<?php

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product instanceof WC_Product || !$product->is_visible()) return;

?>

<div <?php wc_product_class('catalog-grid__col', $product); ?>>
    <?php
    /**
     * Hook: woocommerce_before_shop_loop_item.
     *
     * @hooked lt_template_loop_product_open - 10
     */
    do_action('woocommerce_before_shop_loop_item');

    /**
     * Hook: woocommerce_before_shop_loop_item_title.
     * Ссылка и картинка
     * Обёртка для инфы
     *
     * @hooked lt_template_loop_product_link_thumbnail - 5
     * @hooked lt_template_loop_product_main_open - 10
     */
    do_action('woocommerce_before_shop_loop_item_title');

    /**
     * Hook: woocommerce_shop_loop_item_title.
     * Заголовок и технология
     *
     * @hooked lt_template_loop_product_title_open - 5
     * @hooked lt_template_loop_product_title - 10
     * @hooked lt_template_loop_product_cat_desc - 20
     * @hooked lt_div_close - 40
     */
    do_action('woocommerce_shop_loop_item_title');

    /**
     * Hook: woocommerce_after_shop_loop_item_title.
     * Обшая площадь
     * Краткая информация
     * Сроки строительства
     * Кнопка в избранное
     * Цена
     *
     * @hooked lt_template_loop_ploshhad - 5
     * @hooked lt_template_loop_info - 10
     * @hooked lt_template_loop_srok_stroitelstva - 20
     * @hooked woocommerce_template_loop_price - 10
     */
    do_action('woocommerce_after_shop_loop_item_title');

    /**
     * Hook: woocommerce_after_shop_loop_item.
     *
     * @hooked lt_div_close - 5
     * @hooked lt_div_close - 10
     */
    do_action('woocommerce_after_shop_loop_item');
    ?>
</div>
