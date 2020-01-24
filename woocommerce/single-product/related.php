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

add_filter('lt_wc_product_wrap_loop', 'set_product_loop_in_swiper', 20);

lt_run_category_template();

if ($related_products ?? []) : ?>

    <div class="product__row">
        <div class="container">
            <div class="product__row-title">
                <h3>Вам будет интерестно</h3>
            </div>

            <div class="catalog-slider swiper-container">
                <div class="swiper-wrapper">

                    <?php
                    foreach ($related_products as $related_product) :
                        $post_object = get_post($related_product->get_id());
                        setup_postdata($GLOBALS['post'] =& $post_object);
                        wc_get_template_part('content', 'product');
                    endforeach;
                    ?>

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

lt_reset_category_template();

wp_reset_postdata();
