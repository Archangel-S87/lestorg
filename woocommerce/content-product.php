<?php

/*
 * Все фунции описаны в классе WC_LT_Loop
 */

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
     * @hooked template_product_open - 10
     */
    do_action('woocommerce_before_shop_loop_item');

    /**
     * Hook: woocommerce_before_shop_loop_item_title.
     * Ссылка и картинка
     * Обёртка для инфы
     *
     * @hooked template_product_link_thumbnail - 5
     * @hooked template_product_main_open - 10
     */
    do_action('woocommerce_before_shop_loop_item_title');

    /**
     * Hook: woocommerce_shop_loop_item_title.
     * Заголовок и технология
     *
     * @hooked template_product_title_open - 5
     * @hooked template_product_title - 10
     * @hooked template_product_cat_desc - 20
     * @hooked template_div_close - 40
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
     * @hooked template_loop_ploshhad - 5
     * @hooked template_info - 10
     * @hooked template_srok_stroitelstva - 20
     */
    do_action('woocommerce_after_shop_loop_item_title');

    /**
     * Hook: woocommerce_after_shop_loop_item.
     *
     * @hooked template_bottom - 1
     * @hooked template_div_close - 5
     * @hooked template_div_close - 10
     */
    do_action('woocommerce_after_shop_loop_item');
    ?>
</div>
