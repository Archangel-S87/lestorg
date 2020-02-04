<?php

/*
 * Отвечает за вывод товаров с табами и фильтром.
 */

require_once 'Lestorg_Loop.php';


class Lestorg_Loop_Main extends Lestorg_Loop
{
    use Lestorg_Instance;

    // Стандартные поля фильтра со значениями
    private $filter_fields = [
        'filter' => 1,
        'min_price' => 0,
        'max_price' => 0,
        'min_ploshhad' => 0,
        'max_ploshhad' => 0,
        'etazhnost' => 1
    ];

    // Знаения запроса по фильтру
    private $filter_values = [];

    // Сортировка товаров
    protected $catalog_orderby = [
        'favorite' => 'Популярности',
        'favorite-desc' => '',
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
        $this->add_filter('woocommerce_default_catalog_orderby', [$this, 'set_default_catalog_orderby']);
        $this->add_filter('woocommerce_catalog_orderby', [$this, 'catalog_orderby']);
        $this->add_filter('woocommerce_get_catalog_ordering_args', [$this, 'get_catalog_ordering_args'], 10, 3);
    }

    public function set_default_catalog_orderby()
    {
        return 'favorite-desc';
    }

    public function get_catalog_ordering_args($args, $orderby, $order)
    {
        switch ($orderby) {
            case 'favorite' :
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = 'order_favorite';
                break;
            case 'ploshhad' :
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = 'order_pa_ploshhad';
                break;
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

        // Фильтр товаров
        $this->add_action('woocommerce_before_shop_loop', [$this, 'filter_projects'], 20);

        // Сортировка
        $this->add_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

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
        $this->add_action('lestorg_after_woocommerce_content', 'print_cases');
        $this->add_action('lestorg_after_woocommerce_content', 'print_feedback', 15);
    }

    public function set_loop(WP_Query $query, WC_Query $wc_query)
    {
        parent::set_loop($query, $wc_query);

        $ss = $_GET;

        // Убираю стандартный фильтр woocommerce по цене.
        remove_filter('posts_clauses', [WC()->query, 'price_filter_post_clauses']);

        $this->set_filter_query($query, $wc_query);
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

    private function set_default_filter()
    {
        $max_min_price = $this->get_min_max_value_by_meta_key('_price');
        $max_min_ploshhad = $this->get_min_max_value_by_meta_key('order_pa_ploshhad');

        $default = [
            'min_price' => $max_min_price->min_price ?: 0,
            'max_price' => $max_min_price->max_price ?: 999999999,
            'min_ploshhad' => $max_min_ploshhad->min_order_pa_ploshhad ?: 0,
            'max_ploshhad' => $max_min_ploshhad->max_order_pa_ploshhad ?: 999999999
        ];

        return wp_parse_args($default, $this->filter_fields);
    }

    private function set_filter_query(WP_Query $query, WC_Query $WC_Query)
    {
        $this->filter_fields = $this->filter_values = $this->set_default_filter();

        if (!($_GET['filter'] ?? 0)) return;

        $default = $this->filter_fields;
        $values = $this->filter_values;

        // Тестовый запрос для проверки наличия товаров
        $check_query = new WP_Query;
        $check_query->query_vars = $query->query_vars;

        $meta_query = $check_query->get('meta_query');

        $min_price = $_GET['min_price'] ?? $default['min_price'];
        $max_price = $_GET['max_price'] ?? $default['max_price'];

        if ($min_price > $max_price) {
            $min_price = $default['min_price'];
            $max_price = $default['max_price'];
        }

        if ($min_price != $default['min_price']) {
            $meta_query['relation'] = 'AND';
            $meta_query[] = [
                'key' => '_price',
                'value' => wp_unslash($min_price),
                'compare' => '>=',
                'type' => 'NUMERIC'
            ];
            $values['min_price'] = $min_price;
        }

        if ($max_price != $default['max_price']) {
            $meta_query['relation'] = 'AND';
            $meta_query[] = [
                'key' => '_price',
                'value' => wp_unslash($max_price),
                'compare' => '<=',
                'type' => 'NUMERIC'
            ];
            $values['max_price'] = $max_price;
        }

        $min_ploshhad = $_GET['min_ploshhad'] ?? $default['min_ploshhad'];
        $max_ploshhad = $_GET['max_ploshhad'] ?? $default['max_ploshhad'];

        if ($min_ploshhad > $max_ploshhad) {
            $min_ploshhad = $default['min_ploshhad'];
            $max_ploshhad = $default['max_ploshhad'];
        }

        if ($min_ploshhad != $default['min_ploshhad']) {
            $meta_query['relation'] = 'AND';
            $meta_query[] = [
                'key' => 'order_pa_ploshhad',
                'value' => wp_unslash($min_ploshhad),
                'compare' => '>=',
                'type' => 'NUMERIC'
            ];
            $values['min_ploshhad'] = $min_ploshhad;
        }

        if ($max_ploshhad != $default['max_ploshhad']) {
            $meta_query['relation'] = 'AND';
            $meta_query[] = [
                'key' => 'order_pa_ploshhad',
                'value' => wp_unslash($max_ploshhad),
                'compare' => '<=',
                'type' => 'NUMERIC'
            ];
            $values['max_ploshhad'] = $max_ploshhad;
        }

        $check_query->set('meta_query', $meta_query);

        $etazhnost = $_GET['etazhnost'] ?? $default['etazhnost'];

        $tax_query = $check_query->get('tax_query');
        $tax_query['relation'] = 'AND';
        $tax_query[] = [
            'taxonomy' => 'pa_etazhnost',
            'field' => 'slug',
            'terms' => wp_unslash($etazhnost)
        ];
        $check_query->set('tax_query', $tax_query);
        $values['etazhnost'] = $etazhnost;

        $products = $check_query->query($check_query->query_vars);

        if (!$products) {
            // Нечего отображать. Убрать все параметры запроса фильтра - редиректом
            $term = get_queried_object();

            $params = [];
            foreach ($_GET as $key => $value) {
                if (isset($default[$key])) continue;
                $params[$key] = $value;
            }
            $params['filter'] = 1;

            $link = add_query_arg($params, get_term_link($term->term_id));

            wp_redirect($link);
            exit;
        }

        $query->query_vars = $check_query->query_vars;

        $this->filter_values = $values;
    }

    public function filter_projects()
    {
        wc_get_template('loop/big-filter.php', [
            'default' => $this->filter_fields,
            'values' => $this->filter_values
        ]);
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

        $has_favorites = find_cart_item_by_id($product->get_id());
        $classes_icon = 'catalog-item__icon toggle-favorites';
        $classes_icon = $has_favorites ? $classes_icon . ' active' : $classes_icon;
        $title_icon = $has_favorites ? 'Убрать из избраного' : 'Добавить в избранное';

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
                        <b><?= $komnaty; ?></b> <?= $komnaty_label ?? ''; ?>
                    </p>
                <?php endif; ?>
                <?php if ($sanuzly) : ?>
                    <p class="catalog-item__info-item">
                        <i class="ic ic-bath"></i>
                        <b><?= $sanuzly; ?></b> <?= $sanuzly_label ?? ''; ?>
                    </p>
                <?php endif; ?>
            </div>
            <ul class="catalog-item__list">
                <?php if ($srok) : ?>
                    <li>Срок стоительства: <b><?= $srok; ?></b></li>
                <?php endif; ?>
            </ul>
            <div class="catalog-item__bottom">

                <a href="#" class="<?= $classes_icon; ?>" data-product="<?= $product->get_id(); ?>"
                   title="<?= $title_icon ?>">
                    <i class="ic ic-heart-full"></i>
                </a>
                <?php if ($price_html) : ?>
                    <p class="catalog-item__price">от <?= $price_html; ?></p>
                <?php endif; ?>
            </div>
        </div>

        <?php
    }
}
