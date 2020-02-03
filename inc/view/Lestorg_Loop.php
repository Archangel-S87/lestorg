<?php

/*
 * Класс для страниц категорий
 */

require_once LT_PATCH . '/inc/Lestorg_Hooks.php';


abstract class Lestorg_Loop
{
    use Lestorg_Hooks;

    protected $term;

    // Количество карточек на странице
    protected $count_cards = [9, 12, 15, 18, 21];

    // Варианты сортировкм TODO Добавить в часть админки
    protected $catalog_orderby = [];

    public function set_term(WP_Term $term)
    {
        $this->term = $term;
    }

    public function set_loop(WP_Query $query, WC_Query $wc_query)
    {
        // Устанавливает количество карточек на странице
        $query->set('posts_per_page', $this->get_current_count_cards());
    }

    /**
     * Функия отдаёт min и max значение по переданому meta_key товара
     * Код взят с плагина WooCommerce Products Filter.
     * Класс WOOF_HELPER. Метод get_filtered_price
     * Модифицирована.
     *
     * @param $meta_key
     * @return object
     */
    protected function get_min_max_value_by_meta_key($meta_key) {
        global $wpdb, $wp_the_query;

        $meta_key = esc_sql($meta_key);
        $min_val = str_replace('__', '_', 'min_' . $meta_key);
        $max_val = str_replace('__', '_', 'max_' . $meta_key);

        $args = $wp_the_query->query_vars;
        $tax_query = isset($args['tax_query']) ? $args['tax_query'] : array();

        if (is_object($wp_the_query->tax_query)) {
            $tax_query = $wp_the_query->tax_query->queries; //fix for cat page
        }
        $meta_query = isset($args['meta_query']) ? $args['meta_query'] : array();

        $temp_arr = array();
        if (isset($args['taxonomy']) AND isset($args[$args['taxonomy']]) AND ! empty($args[$args['taxonomy']])) {
            $temp_arr = explode(',', $args[$args['taxonomy']]);
            if (!$temp_arr OR count($temp_arr) < 1) {
                $temp_arr = array();
            }
        }
        if (!empty($args['taxonomy']) && !empty($args['term'])) {
            $tax_query[] = array(
                'taxonomy' => $args['taxonomy'],
                'terms' => (empty($temp_arr)) ? array($args['term']) : $temp_arr,
                'field' => 'slug',
            );
        }

        if (!empty($meta_query) AND is_array($meta_query)) {
            foreach ($meta_query as $key => $query) {
                if (!empty($query['price_filter']) || !empty($query['rating_filter'])) {
                    unset($meta_query[$key]);
                }
            }
        }

        $meta_query = new WP_Meta_Query($meta_query);
        $tax_query = new WP_Tax_Query($tax_query);

        $meta_query_sql = $meta_query->get_sql('post', $wpdb->posts, 'ID');
        $tax_query_sql = $tax_query->get_sql($wpdb->posts, 'ID');

        $sql = "SELECT " . PHP_EOL;
        $sql .= " min( FLOOR( meta_key.meta_value + 0.0 ) ) as {$min_val}," . PHP_EOL;
        $sql .= " max( CEILING( meta_key.meta_value + 0.0 ) ) as {$max_val}" . PHP_EOL;
        $sql .= "FROM {$wpdb->posts}" . PHP_EOL;
        $sql .= "LEFT JOIN {$wpdb->postmeta} as meta_key" . PHP_EOL;
        $sql .= "ON {$wpdb->posts}.ID = meta_key.post_id" . PHP_EOL;
        $sql .= $tax_query_sql['join'] . PHP_EOL;
        $sql .= $meta_query_sql['join'] . PHP_EOL;
        $sql .= "WHERE {$wpdb->posts}.post_type = 'product'" . PHP_EOL;
        $sql .= " AND {$wpdb->posts}.post_status = 'publish'" . PHP_EOL;
        $sql .= " AND meta_key.meta_key IN ('{$meta_key}')" . PHP_EOL;
        $sql .= " AND meta_key.meta_value > ''" . PHP_EOL;
        $sql .= $tax_query_sql['where'] . PHP_EOL;
        $sql .= $meta_query_sql['where'];

        return $wpdb->get_row($sql);
    }

    public function catalog_orderby() {
        return $this->catalog_orderby;
    }

    public function get_catalog_ordering_args($args, $orderby, $order) {}

    public function get_current_count_cards()
    {
        $count = $_GET['count_cards'] ?? 0;
        if ($count && in_array($count, $this->count_cards)) {
            $count = (int)$count;
        } else {
            $count = $this->count_cards[0];
        }
        return $count;
    }

    public function get_count_cards()
    {
        return [
            'current_count_cards' => $this->get_current_count_cards(),
            'count_cards' => $this->count_cards
        ];
    }

    private function remove_default_hooks()
    {
        //  Убираю счётчик количества проектов в категории
        remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

        // Убираю фильтр
        remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

        // Вид товара
        remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open');
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
        remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash');
        remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail');
        remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title');
        remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
        remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price');
    }

    public function run()
    {
        $this->remove_default_hooks();

        /*
         * Обёртка для product_loop
         */
        $this->add_filter('woocommerce_product_loop_start', [$this, 'product_loop_start']);
        $this->add_filter('woocommerce_product_loop_end', [$this, 'product_loop_end']);

        $this->add_filter('lt_wc_product_wrap_loop', [$this, 'set_attrs_product_wrap'], 5);
    }

    public function set_attrs_product_wrap($attrs)
    {
        $attrs['class'][] = 'catalog-grid__col';
        return $attrs;
    }

    public function product_loop_start()
    {
        return '<div class="catalog-grid">' . PHP_EOL;
    }

    public function product_loop_end()
    {
        return '</div><!--.catalog-grid-->' . PHP_EOL;
    }

    public function template_product_open()
    {
        echo '<div class="catalog-item box">' . PHP_EOL;
    }

    public function template_product_close()
    {
        echo '</div><!--.catalog-item-->' . PHP_EOL;
    }

    public function template_product_link_thumbnail()
    {
        global $product;
        if (!$product instanceof WC_Product) return;

        $image_src = lt_woocommerce_get_thumbnail_image();
        if (!$image_src) return;

        $link = apply_filters('woocommerce_loop_product_link', $product->get_permalink(), $product);

        $attrs = [
            'href' => esc_url($link),
            'class' => [
                'woocommerce-LoopProduct-link',
                'woocommerce-loop-product__link',
                'catalog-item__img'
            ],
            'style' => 'background-image: url(' . esc_url($image_src) . ');'
        ];

        echo '<a ' . get_tag_attr($attrs, false) . '></a>';
    }

    public function template_product_main_open()
    {
        echo '<div class="catalog-item__main">';
    }
}
