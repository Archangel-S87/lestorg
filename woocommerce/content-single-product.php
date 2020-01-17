<?php

/*
 * Все фунции описаны в классе WC_LT_Single_Product
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}

?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
    <?php
    /**
     * Hook: woocommerce_before_single_product_summary.
     * Заголовок товара
     * Обёртка product-grid open
     * Галерея
     *
     * @hooked template_title_inn - 5
     * @hooked template_wrapper_grid_open - 10
     * @hooked template_gallery - 15
     */
    do_action('woocommerce_before_single_product_summary');

    /**
     * Hook: woocommerce_single_product_summary.
     * Обёртка для info open
     * Блок инфо
     * Обёртка для info close
     *
     * @hooked template_wrapper_info_open - 5
     * @hooked template_info_title - 10
     * @hooked template_info_table - 15
     * @hooked template_info_action - 20
     * @hooked template_info_share - 25
     * @hooked template_wrapper_info_close - 50
     * @hooked WC_Structured_Data::generate_product_data() - 60
     */
    do_action('woocommerce_single_product_summary');

    /**
     * Hook: woocommerce_after_single_product_summary.
     * Обёртка product-grid close
     * Остальная инфа
     *
     * @hooked template_wrapper_grid_close - 5
     * @hooked template_product_variations_table - 10
     * @hooked template_product_description - 15
     * // TODO заменить Похожие товары на Вы смотрели. Шаблон related_products есть в теме
     * @hooked woocommerce_output_related_products - 20
     */
    do_action('woocommerce_after_single_product_summary');
    ?>
</div>

<?php do_action('woocommerce_after_single_product'); ?>
