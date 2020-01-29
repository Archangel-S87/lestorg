<?php

/*
 * Класс для страниц категорий
 */


abstract class WC_LT_Category
{
    protected $term;

    // Количество карточек на странице
    protected $count_cards = [9, 12, 15, 18, 21];

    // Варианты сортировкм
    protected $catalog_orderby = [];

    use LT_Hooks;

    public function set_term(WP_Term $term)
    {
        $this->term = $term;
    }

    public function set_loop(WP_Query $query, WC_Query $wc_query)
    {
        // Устанавливает количество карточек на странице
        $query->set('posts_per_page', $this->get_current_count_cards());
    }

    // Фильтрация товаров по параметрам
    protected function set_filter_products(WP_Query $query)
    {

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
