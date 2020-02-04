<?php

/*
 * Все фунции описаны в классе Lestorg_Single
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
     *
     * @hooked get_the_title - 10
     */
    do_action('woocommerce_before_single_product_summary');

    /**
     * Hook: woocommerce_single_product_summary.
     *
     * @hooked get_the_preview - 10
     * @hooked WC_Structured_Data::generate_product_data() - 60
     */
    do_action('woocommerce_single_product_summary');

    /**
     * Hook: woocommerce_after_single_product_summary.
     *
     * @hooked get_the_description - 10
     */
    do_action('woocommerce_after_single_product_summary');
    ?>
</div>

<?php do_action('woocommerce_after_single_product'); ?>
