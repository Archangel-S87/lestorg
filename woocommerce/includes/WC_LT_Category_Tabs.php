<?php

/*
 * Отвечает за вывод товаров с табами и фильтром.
 */

class WC_LT_Category_Tabs extends WC_LT_Category
{
    use LT_Instance;

    protected $catalog_orderby = [
        'popularity' => 'Популярности', // TODO Заменить total_view. Сейчас ищет по полю total_sales
        'popularity-desc' => '',
        'ploshhad' => 'Площади',
        'ploshhad-desc' => '',
        'price' => 'Цене',
        'price-desc' => ''
    ];

    public function __construct()
    {
        /*
         * Сортировка товаров
         */
        $this->add_filter('woocommerce_catalog_orderby', [$this, 'catalog_orderby']);
        $this->add_filter('woocommerce_get_catalog_ordering_args', [$this, 'get_catalog_ordering_args'], 10, 3);
    }

    public function get_catalog_ordering_args($args, $orderby, $order)
    {
        if ($orderby == 'ploshhad') {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'order_pa_ploshhad';
        }
        return $args;
    }

    public function run()
    {
        parent::run();

        // Классы body
        $this->add_filter('body_class', [$this, 'change_body_classes']);

        // Заголовок категории
        $this->add_action('woocommerce_before_shop_loop', [$this, 'set_title'], 20);

        // Мой фильтр на страницу категорий
        //$this->add_action('woocommerce_before_shop_loop', [$this, 'filter_projects'], 20);
        // Стандартный фильтр
        $this->add_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

        /*
         * Относиться к фильтрам
         */
        //add_action('pre_get_posts', 'search_by_cat');
        //add_action('woocommerce_product_query', 't_woocommerce_parse_query');

        /*
         * Сортировка TODO Сделать сортировку как в макете
         */


        /*
         * Вид карточки товара
         */
        $this->add_action('woocommerce_before_shop_loop_item', [$this, 'template_product_open']);
        $this->add_action('woocommerce_before_shop_loop_item_title', [$this, 'template_product_link_thumbnail'], 5);
        $this->add_action('woocommerce_shop_loop_item_title', [$this, 'template_product_title']);
        $this->add_action('woocommerce_after_shop_loop_item', [$this, 'template_product_close']);

        /*
         * Вывод дополнительных секций после основного контента в категориях
         */
        $this->add_action('lt_after_woocommerce_content', 'print_cases');
        $this->add_action('lt_after_woocommerce_content', 'print_feedback', 15);
    }

    public function change_body_classes($classes)
    {
        $classes[] = 'page-catalog';
        return $classes;
    }

    public function set_title()
    {
        if (apply_filters('woocommerce_show_page_title', true)) {
            wc_get_template('global/title-tabs.php');
        }
    }

    public function filter_projects()
    {
        // TODO сделать фильтр товаров
        wc_get_template('loop/custom-filter.php', []);
    }

    public function t_woocommerce_parse_query($q)
    {
        $meta_query = $q->get('meta_query');
        $meta_query = apply_filters('woof_get_meta_query', $meta_query);
        $q->set('meta_query', $meta_query);
    }

    public function search_by_cat()
    {
        global $wp_query;

        if (is_search()) {

            $gorod = intval($_GET['gorod']);
            if ($gorod > 0) {
                $wp_query->query_vars['tax_query'][] = array( //для атрибутов товаров
                    "taxonomy" => "pa_gorod",
                    "field" => "id",
                    "terms" => $gorod
                );
            }

            $tip = intval($_GET['peredvizhenie']);
            if ($tip > 0) {
                $wp_query->query_vars['tax_query'][] = array(
                    "taxonomy" => "pa_peredvizhenie",
                    "field" => "id",
                    "terms" => $tip
                );
            }

            $vid = intval($_GET['vid-puteshestvija']);
            if ($vid > 0) {
                $wp_query->query_vars['tax_query'][] = array(
                    "taxonomy" => "pa_vid-puteshestvija",
                    "field" => "id",
                    "terms" => $vid
                );
            }

            $date = $_GET['put-date'];
            if ($date) {
                $wp_query->query_vars['meta_key'] = 'nearest_date'; // для мета-полей товаров
                $wp_query->query_vars['meta_value'] = strtotime($date);
            }

        }
    }

    public function template_product_title()
    {
        global $product;
        if (!$product instanceof WC_Product) return;

        $link = apply_filters('woocommerce_loop_product_link', $product->get_permalink(), $product);

        $terms = $product->get_category_ids();
        $term_id = $terms[0] ?? 0;
        $term = $term_id ? get_term($term_id, 'product_cat') : null;

        $ploshhad = $product->get_attribute('pa_ploshhad');

        $komnaty = $product->get_attribute('pa_komnaty');
        if ($komnaty) {
            switch ($komnaty) {
                case 1 :
                    $komnaty_label = 'комната';
                    break;
                case 2 :
                case 3 :
                case 4 :
                    $komnaty_label = 'комнаты';
                    break;
                default :
                    $komnaty_label = 'комнат';
            }
        }

        $sanuzly = $product->get_attribute('pa_sanuzly');
        if ($sanuzly) {
            switch ($sanuzly) {
                case 1 :
                    $sanuzly_label = 'санузел';
                    break;
                case 2 :
                case 3 :
                case 4 :
                    $sanuzly_label = 'санузла';
                    break;
                default :
                    $sanuzly_label = 'санузлов';
            }
        }

        $srok = $product->get_attribute('pa_srok-stroitelstva');

        $price_html = $product->get_price_html()
        ?>

        <div class="catalog-item__main">
            <div class="catalog-item__top">
                <h5 class="catalog-item__head">
                    <a href="<?= $link; ?>" class="link-head"><?= $product->get_title(); ?></a>
                </h5>
                <?php if ($term && !is_wp_error($term)) : ?>
                    <p class="catalog-item__cat"><?= esc_html($term->description); ?></p>
                <?php endif; ?>
            </div>
            <?php if ($ploshhad) : ?>
                <?php $ploshhad = str_replace('м2', 'м<sup>2</sup></strong>', $ploshhad); ?>
                <p class="catalog-item__square"><strong><?= $ploshhad; ?></strong> площадь объекта</p>
            <?php endif; ?>
            <div class="catalog-item__info">
                <?php if ($komnaty) : ?>
                    <p class="catalog-item__info-item">
                        <i class="ic ic-bed"></i>
                        <b><?= $komnaty; ?></b> <?= $komnaty_label; ?>
                    </p>
                <?php endif; ?>
                <?php if ($sanuzly) : ?>
                    <p class="catalog-item__info-item">
                        <i class="ic ic-bath"></i>
                        <b><?= $sanuzly; ?></b> <?= $sanuzly_label; ?>
                    </p>
                <?php endif; ?>
            </div>
            <ul class="catalog-item__list">
                <?php if ($srok) : ?>
                    <li>Срок стоительства: <b><?= $srok; ?></b></li>
                <?php endif; ?>
            </ul>
            <div class="catalog-item__bottom">
                <?php // TODO Сделать добавление в избранное
                ?>
                <?php // <a href="#" class="catalog-item__icon active"><i class="ic ic-heart-full"></i></a>
                ?>
                <?php if ($price_html) : ?>
                    <p class="catalog-item__price">от <?= $price_html; ?></p>
                <?php endif; ?>
            </div>
        </div>

        <?php
    }
}

$WC_LT_Category_Tabs = WC_LT_Category_Tabs::get_instance();
