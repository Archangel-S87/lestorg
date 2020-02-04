<?php

/*
 * Выводит ранее просмотренные товары из текщей категории
 */

class Lestorg_Ajax_Watched
{
    public function __construct()
    {
        add_action('wp_ajax_nopriv_lestorg_ajax_get_watched', [$this, 'get_watched']);
    }

    public function get_watched()
    {
        $errors = false;
        $html = '';

        $cat_id = $_POST['cat_id'] ?? 0;
        $product_ids = $_POST['product_ids'] ?? [];

        if (!$cat_id || !$product_ids) {
            $errors = 'Неверные входные данные';
        }

        if (!$errors) {

            $class_template = LT()->content->get_loop_class_template($cat_id);
            $class_template->run();

            $short = new WC_Shortcode_Products([
                'ids' => implode(', ', $product_ids),
                'category' => $cat_id,
                'cache' => false,
                'columns' => false
            ]);

            //$html = $short->get_content();
            $query = new WP_Query;
            $query_args = $short->get_query_args();
            $products_id = $query->query($query_args);

            if ($products_id) {

                wc_setup_loop([
                    'name' => 'product',
                    'is_shortcode' => true,
                    'is_search' => false,
                    'is_paginated' => false
                ]);

                ob_start();

                foreach ($products_id as $product_id) {

                    $GLOBALS['post'] = get_post($product_id);
                    setup_postdata($GLOBALS['post']);

                    echo '<div class="swiper-slide">' . PHP_EOL;

                    do_action('woocommerce_before_shop_loop_item');

                    do_action('woocommerce_before_shop_loop_item_title');

                    do_action('woocommerce_shop_loop_item_title');

                    do_action('woocommerce_after_shop_loop_item_title');

                    do_action('woocommerce_after_shop_loop_item');

                    echo '</div>' . PHP_EOL;
                }

                wp_reset_postdata();
                wc_reset_loop();

                $html = ob_get_clean();
            }
        }

        wp_send_json([
            'errors' => $errors,
            'html' => $html
        ]);
    }
}

$Lestorg_Ajax_Watched = new Lestorg_Ajax_Watched();
