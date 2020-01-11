<?php

/*
 * Отвечает за множественный вывод товаров на странице.
 */

class WC_LT_Loop
{
    public function __construct()
    {
        $this->remove_default_hooks();
        $this->init_hooks();
    }

    private function remove_default_hooks()
    {
        //  Убираю счётчик количества проектов в категории
        remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

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

    private function init_hooks()
    {
        /*
         * Обёртка для product_loop
         */
        add_filter('woocommerce_product_loop_start', [$this, 'product_loop_start']);
        add_filter('woocommerce_product_loop_end', [$this, 'product_loop_end']);

        // Мой фильтр на страницу категорий
        //add_action('woocommerce_before_shop_loop', [$this, 'filter_projects'], 20);

        /*
         * Относиться к фильтрам
         */
        //add_action('pre_get_posts', 'search_by_cat');
        //add_action('woocommerce_product_query', 't_woocommerce_parse_query');

        /*
         * Сортировка
         */
        // TODO Сделать сортировку как в макете

        /*
         * Вид карточки товара
         */
        add_action('woocommerce_before_shop_loop_item', [$this, 'template_product_open']);
        add_action('woocommerce_after_shop_loop_item', [$this, 'template_div_close']);

        add_action('woocommerce_before_shop_loop_item_title', [$this, 'template_product_link_thumbnail'], 5);

        add_action('woocommerce_before_shop_loop_item_title', [$this, 'template_product_main_open']);
        add_action('woocommerce_after_shop_loop_item', [$this, 'template_div_close'], 5);

        add_action('woocommerce_shop_loop_item_title', [$this, 'template_product_title_open'], 5);
        add_action('woocommerce_shop_loop_item_title', [$this, 'template_div_close'], 40);

        add_action('woocommerce_shop_loop_item_title', [$this, 'template_product_title']);

        add_action('woocommerce_shop_loop_item_title', [$this, 'template_product_cat_desc'], 20);

        add_action('woocommerce_after_shop_loop_item_title', [$this, 'template_loop_ploshhad'], 5);

        add_action('woocommerce_after_shop_loop_item_title', [$this, 'template_info'], 10);

        add_action('woocommerce_after_shop_loop_item_title', [$this, 'template_srok_stroitelstva'], 20);

        add_action('woocommerce_after_shop_loop_item', [$this, 'template_bottom'], 1);
    }

    public function t_woocommerce_parse_query($q) {
        $meta_query = $q->get('meta_query');
        $meta_query = apply_filters('woof_get_meta_query', $meta_query);
        $q->set('meta_query', $meta_query);
    }

    public function search_by_cat()
    {
        global $wp_query;

        if (is_search()) {

            $gorod =  intval($_GET['gorod']);
            if($gorod>0){
                $wp_query->query_vars['tax_query'][] = array( //для атрибутов товаров
                    "taxonomy" => "pa_gorod",
                    "field" => "id",
                    "terms" =>  $gorod
                );
            }

            $tip =  intval($_GET['peredvizhenie']);
            if($tip>0){
                $wp_query->query_vars['tax_query'][] = array(
                    "taxonomy" => "pa_peredvizhenie",
                    "field" => "id",
                    "terms" =>  $tip
                );
            }

            $vid =  intval($_GET['vid-puteshestvija']);
            if($vid>0){
                $wp_query->query_vars['tax_query'][] = array(
                    "taxonomy" => "pa_vid-puteshestvija",
                    "field" => "id",
                    "terms" =>  $vid
                );
            }

            $date = $_GET['put-date'];
            if($date){
                $wp_query->query_vars['meta_key'] = 'nearest_date'; // для мета-полей товаров
                $wp_query->query_vars['meta_value']  = strtotime($date);
            }

        }
    }

    public function template_bottom()
    {
        global $product;
        if (!$product instanceof WC_Product) return;

        $html = '<div class="catalog-item__bottom">';
        // TODO Сделать добавление в избранное
        //$html .= '<a href="#" class="catalog-item__icon active"><i class="ic ic-heart-full"></i></a>';
        if ($price_html = $product->get_price_html()) {
            $html .= '<p class="catalog-item__price">от ' . $price_html . '</p>';
        }
        $html .= '</div>';

        echo $html;
    }

    public function template_srok_stroitelstva()
    {
        global $product;
        if (!$product instanceof WC_Product) return;

        $srok = $product->get_attribute('pa_srok-stroitelstva');
        if (!$srok) return;

        $html = '<ul class="catalog-item__list">';
        $html .= '<li>Срок стоительства: <b>' . $srok .'</b></li>';
        $html .= '</ul>';

        echo $html;
    }

    public function template_info()
    {
        global $product;
        if (!$product instanceof WC_Product) return;

        $komnaty = $product->get_attribute('pa_komnaty');
        $sanuzly = $product->get_attribute('pa_sanuzly');
        if (!$komnaty && !$sanuzly) return;

        $html = '<div class="catalog-item__info">';

        if ($komnaty) {
            switch ($komnaty) {
                case 1 :
                    $label = 'комната';
                    break;
                case 2 :
                case 3 :
                case 4 :
                    $label = 'комнаты';
                    break;
                default :
                    $label = 'комнат';
            }
            $html .= '<p class="catalog-item__info-item"><i class="ic ic-bed"></i><b>' . $komnaty . '</b> ' . $label .'</p>';
        }

        if ($sanuzly) {
            switch ($sanuzly) {
                case 1 :
                    $label = 'санузел';
                    break;
                case 2 :
                case 3 :
                case 4 :
                    $label = 'санузла';
                    break;
                default :
                    $label = 'санузлов';
            }
            $html .= '<p class="catalog-item__info-item"><i class="ic ic-bath"></i><b>' . $sanuzly . '</b> ' . $label .'</p>';
        }

        $html .= '</div>';

        echo $html;
    }

    public function template_loop_ploshhad()
    {
        global $product;
        if (!$product instanceof WC_Product) return;

        $ploshhad = $product->get_attribute('pa_ploshhad');
        if (!$ploshhad) return;

        $ploshhad = str_replace('м2', 'м<sup>2</sup></strong>', $ploshhad);

        echo '<p class="catalog-item__square"><strong>' . $ploshhad . '</strong> площадь объекта
                        </p>';
    }

    public function template_product_cat_desc()
    {
        $current_term = get_queried_object();
        if (!$current_term) return;
        echo '<p class="catalog-item__cat">' . $current_term->description . '</p>';
    }

    public function template_product_title()
    {
        global $product;

        $link = apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product);

        echo '<h5 class="' . esc_attr(apply_filters('woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title catalog-item__head')) . '">';
        echo '<a href="'. $link .'" class="link-head">' . get_the_title() .'</a>';
        echo '</h5>';
    }

    public function template_product_title_open()
    {
        echo '<div class="catalog-item__top">';
    }

    public function template_product_main_open()
    {
        echo '<div class="catalog-item__main">';
    }

    public function template_product_link_thumbnail() {
        global $product;
        if (!$product instanceof WC_Product) return;

        $image_src = woocommerce_get_thumbnail_image();
        if (!$image_src) return;

        $link = apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product);

        $image_src = esc_url($image_src);

        $link_attr = [
            'href' => esc_url($link),
            'class' => 'woocommerce-LoopProduct-link woocommerce-loop-product__link catalog-item__img',
            'style' => "background-image: url('{$image_src}');"
        ];

        $html = '<a';
        foreach ( $link_attr as $name => $value ) {
            $html .= " $name=" . '"' . $value . '"';
        }
        $html .= '></a>';

        echo $html;
    }

    public function template_product_open()
    {
        echo '<div class="catalog-item box">';
    }


    public function product_loop_start()
    {
        return '<div class="catalog-grid">';
    }

    public function product_loop_end()
    {
        return '</div>';
    }

    public function template_div_close()
    {
        echo '</div>';
    }

    public function filter_projects()
    {
        // TODO сделать фильтр товаров
        wc_get_template('loop/custom-filter.php', []);
    }

}

$WC_LT_Loop = new WC_LT_Loop();
