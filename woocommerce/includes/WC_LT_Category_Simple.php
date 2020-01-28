<?php

/*
 * Отвечает за вывод товаров с табами и фильтром.
 */


class WC_LT_Category_Simple extends WC_LT_Category
{
    use LT_Instance;

    // Количество карточек на странице
    protected $count_cards = [4, 6, 12, 16, 20];

    public function run()
    {
        parent::run();

        // Классы body
        $this->add_filter('body_class', [$this, 'change_body_classes']);

        // Заголовок категории
        $this->add_action('woocommerce_before_shop_loop', [$this, 'set_title'], 20);

        /*
         * Вид карточки товара
         */
        $this->add_action('woocommerce_before_shop_loop_item', [$this, 'template_product_open']);
        $this->add_action('woocommerce_before_shop_loop_item_title', [$this, 'template_product_link_thumbnail'], 5);
        $this->add_action('woocommerce_shop_loop_item_title', [$this, 'template_product_title']);
        $this->add_action('woocommerce_after_shop_loop_item', [$this, 'template_product_close']);

        // Вывод дополнительных секций после основного контента в категориях
        $this->add_action('lt_after_woocommerce_content', 'print_feedback', 15);
    }

    public function product_query(WP_Query $query, WC_Query $wc_query)
    {

    }

    public function change_body_classes($classes)
    {
        $classes[] = 'page-catalog';
        return $classes;
    }

    public function set_title()
    {
        if (apply_filters('woocommerce_show_page_title', true)) {
            echo '<div class="title-inn"><h2>' . $this->term->name . '</h2></div>';
        }
    }

    public function set_attrs_product_wrap($attrs)
    {
        $attrs['class'][] = 'catalog-grid__col';
        $attrs['attrs']['data-medium'] = '';
        return $attrs;
    }

    public function template_product_open()
    {
        echo '<div class="catalog-item catalog-item_case box">' . PHP_EOL;
    }

    public function template_product_title()
    {
        global $product;
        if (!$product instanceof WC_Product) return;

        $link = apply_filters('woocommerce_loop_product_link', $product->get_permalink(), $product);
        ?>

        <div class="catalog-item__main">
            <h5 class="catalog-item__head">
                <a href="<?= $link; ?>" class="link-head"><?= $product->get_title(); ?></a>
            </h5>
            <p class="catalog-item__descr"><?= $product->get_short_description(); ?></p>
            <div class="catalog-item__btn">
                <a href="<?= $link; ?>" class="btn btn_bd btn_little">Подробнее</a>
            </div>
        </div>

        <?php
    }
}

$WC_LT_Category_Simple = WC_LT_Category_Simple::get_instance();
