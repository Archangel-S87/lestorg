<?php

/*
 * Класс для работы с избранным
 */


class LT_Ajax_Favorites
{
    public function __construct()
    {
        add_action('wp_ajax_nopriv_lt_ajax_add_favorites', [$this, 'add_favorites']);
        add_action('wp_ajax_nopriv_lt_ajax_remove_favorites', [$this, 'remove_favorites']);
    }

    public function add_favorites()
    {
        $post_id = $_POST['product_id'] ?? 0;

        $cart_item_key = '';
        $errors = false;

        try {
            $cart_item_key = WC()->cart->add_to_cart($post_id, 1);
        } catch (Exception $e) {
            $errors = $e->getMessage();
        }

        // Добавляю товару балл популярности
        if (!$errors && $cart_item_key) {
            $product = wc_get_product($post_id);
            $popularity = $product->get_meta('order_favorite');
            $popularity = absint($popularity);
            $product->update_meta_data('order_favorite', ++$popularity);
            $product->save();
        }

        wp_send_json([
            'errors' => $errors,
            'count_products' => count(WC()->cart->get_cart()) // Количество в избранном
        ]);
    }

    public function remove_favorites()
    {
        $post_id = $_POST['product_id'] ?? 0;

        $product = wc_get_product($post_id);
        $errors = $product ? false : 'Товар с таким id не найден';

        if (!$errors) {
            $cart_item_key = find_cart_item_by_id($product->get_id());
            $errors = $cart_item_key ? false : 'В избранном нет такого товара';
            if ($cart_item_key) {
                // Удалить из карзины товар
                WC()->cart->remove_cart_item($cart_item_key);
            }
        }

        // Популярность менять не нужно!

        wp_send_json([
            'errors' => $errors,
            'count_products' => count(WC()->cart->get_cart()) // Количество в избранном
        ]);
    }
}

$LT_Ajax_Favorites = new LT_Ajax_Favorites();
