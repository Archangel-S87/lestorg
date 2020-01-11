<?php

function lt_div_close() {
    echo '</div>';
}

// Получает thumbnail src продукта
function woocommerce_get_thumbnail_image($size = 'woocommerce_thumbnail', $placeholder = true) {
    global $product;
    if (!$product instanceof WC_Product) return null;

    $size = apply_filters('single_product_archive_thumbnail_size', $size);

    $image = null;
    $image_src = '';
    if ($product->get_image_id()) {
        $image = wp_get_attachment_image_src($product->get_image_id(), $size);
    } elseif ($product->get_parent_id()) {
        $parent_product = wc_get_product($product->get_parent_id());
        if ($parent_product) {
            $image = wp_get_attachment_image_src($parent_product->get_image_id(), $size);
        }
    }

    if (!empty($image[0])) {
        $image_src = $image[0];
    }

    if (!$image_src && $placeholder) {
        $image_src = wc_placeholder_img_src($size);
    }

    return apply_filters('lt_product_get_image_src', $image_src, $product, $size, $image, $placeholder);

}

/*
 * Меняю вывод breadcrumbs
 */
add_filter('woocommerce_breadcrumb_defaults', 'replace_breadcrumbs_defaults');
function replace_breadcrumbs_defaults($args)
{
    return [
        'wrap_before' => '<ul class="breadcrumbs">',
        'wrap_after' => '</ul>',
        'before' => '<li>',
        'after' => '</li>',
        'home' => _x('Home', 'breadcrumb', 'woocommerce'),
    ];
}

add_filter('woocommerce_get_breadcrumb', 'replace_woocommerce_breadcrumbs');
function replace_woocommerce_breadcrumbs($breadcrumbs)
{
    $breadcrumbs[0][0] = '<i class="ic ic-home"></i> Главная';
    // Убираю из вывода родительскую категорию
    if (count($breadcrumbs) > 2) {
        unset($breadcrumbs[1]);
        sort($breadcrumbs);
    }
    return $breadcrumbs;
}

function woocommerce_content() {

    if (is_singular('product')) {

        while (have_posts()) :
            the_post();
            wc_get_template_part('content', 'single-product');
        endwhile;

    } else {

        if (apply_filters('woocommerce_show_page_title', true)) {
            $current_term = get_queried_object();
            if (apply_filters('print_title_tabs_in_category', true, $current_term)) {
                // Выводит фильтр в категориях товаров
                wc_get_template('global/title-tabs.php');
            } else {
                echo '<div class="title-inn"><h2>' . $current_term->name . '</h2></div>';
            }
        }

        if (!woocommerce_product_loop()) {
            do_action('woocommerce_no_products_found');
            return;
        }

        //echo do_shortcode('[woof]');
        do_action('woocommerce_before_shop_loop');

        woocommerce_product_loop_start();

        if (wc_get_loop_prop('total')) {
            while (have_posts()) {
                the_post();
                wc_get_template_part('content', 'product');
            }
        }

        woocommerce_product_loop_end();

        do_action('woocommerce_after_shop_loop');

    }

}

//  Убираю счётчик количества проектов в категории
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

//  Убираю счётчик количества проектов в категории
//add_action('woocommerce_before_shop_loop', 'custom_filters_project', 20);
function custom_filters_project() {
    // TODO сделать фильтр товаров
    wc_get_template('loop/custom-filter.php', []);
}

add_action('pre_get_posts', 'search_by_cat');
function search_by_cat() {
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

add_action('woocommerce_product_query', 't_woocommerce_parse_query');
function t_woocommerce_parse_query($q) {
    $meta_query = $q->get('meta_query');
    $meta_query = apply_filters('woof_get_meta_query', $meta_query);
    $q->set('meta_query', $meta_query);
}


/*
 * Сортировка
 */
// TODO Сделать сортировку как в макете


/*
 * Обёртка для product_loop
 */
add_filter('woocommerce_product_loop_start', 'custom_product_loop_start');
function custom_product_loop_start() {
    return '<div class="catalog-grid">';
}
add_filter('woocommerce_product_loop_end', 'custom_product_loop_end');
function custom_product_loop_end() {
    return '</div>';
}

/*
 * Вид товара
 */
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open');
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');

add_action('woocommerce_before_shop_loop_item', 'lt_template_loop_product_open');
function lt_template_loop_product_open() {
    echo '<div class="catalog-item box">';
}
add_action('woocommerce_after_shop_loop_item', 'lt_div_close');

remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash');
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail');

add_action('woocommerce_before_shop_loop_item_title', 'lt_template_loop_product_link_thumbnail', 5);
function lt_template_loop_product_link_thumbnail() {
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

add_action('woocommerce_before_shop_loop_item_title', 'lt_template_loop_product_main_open');
function lt_template_loop_product_main_open() {
    echo '<div class="catalog-item__main">';
}
add_action('woocommerce_after_shop_loop_item', 'lt_div_close', 5);


remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title');

add_action('woocommerce_shop_loop_item_title', 'lt_template_loop_product_title_open', 5);
function lt_template_loop_product_title_open() {
    echo '<div class="catalog-item__top">';
}
add_action('woocommerce_shop_loop_item_title', 'lt_div_close', 40);

add_action('woocommerce_shop_loop_item_title', 'lt_template_loop_product_title');
function lt_template_loop_product_title() {
    global $product;

    $link = apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product);

    echo '<h5 class="' . esc_attr(apply_filters('woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title catalog-item__head')) . '">';
    echo '<a href="'. $link .'" class="link-head">' . get_the_title() .'</a>';
    echo '</h5>';

}

add_action('woocommerce_shop_loop_item_title', 'lt_template_loop_product_cat_desc', 20);
function lt_template_loop_product_cat_desc() {
    $current_term = get_queried_object();
    if (!$current_term) return;
    echo '<p class="catalog-item__cat">' . $current_term->description . '</p>';
}


remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price');

add_action('woocommerce_after_shop_loop_item_title', 'lt_template_loop_ploshhad', 5);
function lt_template_loop_ploshhad() {
    global $product;
    if (!$product instanceof WC_Product) return;

    $ploshhad = $product->get_attribute('pa_ploshhad');
    if (!$ploshhad) return;

    $ploshhad = str_replace('м2', 'м<sup>2</sup></strong>', $ploshhad);

    echo '<p class="catalog-item__square"><strong>' . $ploshhad . '</strong> площадь объекта
                        </p>';
}

add_action('woocommerce_after_shop_loop_item_title', 'lt_template_loop_info', 10);
function lt_template_loop_info() {
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

add_action('woocommerce_after_shop_loop_item_title', 'lt_template_loop_srok_stroitelstva', 20);
function lt_template_loop_srok_stroitelstva() {
    global $product;
    if (!$product instanceof WC_Product) return;

    $srok = $product->get_attribute('pa_srok-stroitelstva');
    if (!$srok) return;

    $html = '<ul class="catalog-item__list">';
    $html .= '<li>Срок стоительства: <b>' . $srok .'</b></li>';
    $html .= '</ul>';

    echo $html;
}

add_action('woocommerce_after_shop_loop_item', 'lt_template_loop_bottom', 1);
function lt_template_loop_bottom() {
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


