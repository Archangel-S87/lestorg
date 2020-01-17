<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce/Templates
 * @version     3.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

add_filter('woocommerce_product_loop_start', '__return_null');
add_filter('woocommerce_product_loop_end', '__return_null');

if ($related_products ?? []) : ?>

    <div class="product__row">
        <div class="container">
            <div class="product__row-title">
                <h3>Вам будет интерестно</h3>
            </div>

            <div class="catalog-slider swiper-container">
                <div class="swiper-wrapper">

                    <?php woocommerce_product_loop_start(); ?>

                    <?php foreach ($related_products as $related_product) : ?>

                        <div class="swiper-slide">
                            <?php
                            $post_object = get_post($related_product->get_id());

                            setup_postdata($GLOBALS['post'] =& $post_object);

                            do_action('woocommerce_before_shop_loop_item');
                            do_action('woocommerce_before_shop_loop_item_title');
                            do_action('woocommerce_shop_loop_item_title');
                            do_action('woocommerce_after_shop_loop_item_title');
                            do_action('woocommerce_after_shop_loop_item');
                            ?>
                        </div>

                    <?php endforeach; ?>

                    <?php woocommerce_product_loop_end(); ?>

                </div>
                <div class="swiper-nav">
                    <div class="swiper-button-prev"><i class="ic ic-left"></i></div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"><i class="ic ic-right"></i></div>
                </div>
            </div>

        </div>
    </div>

<?php endif;

wp_reset_postdata();
