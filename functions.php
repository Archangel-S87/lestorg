<?php

define('LT_PATCH', dirname(__FILE__));

require_once 'libs/tgm/tgm.php';

require_once 'inc/functions-templates.php';

include_once 'inc/Lestorg.php';

function LT() : Lestorg {
    return Lestorg::instance();
}

$GLOBALS['lestorg'] = LT();


function get_img($file) {
    return get_template_directory_uri() . '/assets/' . $file;
}

function remove_value_array($value, $arr) {
    if (!is_array($arr)) return $arr;
    $arr = array_unique($arr);
    $key = array_search($value, $arr);
    if ($key) {
        unset($arr[$key]);
    }
    return $arr;
}

function get_tag_attr($attrs = [], $echo = true) {

    $str = '';

    foreach ($attrs as $key => $attr) {

        if (!$attr) continue;

        if ($key == 'attrs' && is_array($attr)) {
            $str_attrs = '';
            foreach ($attr as $attr_key => $value) {
                $str_attrs .= $attr_key . '="' . $value . '" ';
            }
            $str .= $str_attrs;
            continue;
        }

        if (is_array($attr)) {
            $attr = esc_attr(implode(' ', $attr));
        }

        $str .= trim($key) . '="' . trim($attr) . '" ';

    }

    $str = trim($str);

    if ($echo) {
        echo $str;
    }

    return $str;
}

// Получает thumbnail src продукта
function lestorg_woocommerce_get_thumbnail_image($size = 'woocommerce_thumbnail', $placeholder = true) {
    global $product;
    if (!$product instanceof WC_Product) return null;

    $size = apply_filters('single_product_archive_thumbnail_size', $size);

    $image = null;
    if ($product->get_image_id()) {
        $image = wp_get_attachment_image_url($product->get_image_id(), $size);
    } elseif ($product->get_parent_id()) {
        $parent_product = wc_get_product($product->get_parent_id());
        if ($parent_product) {
            $image = wp_get_attachment_image_url($parent_product->get_image_id(), $size);
        }
    }

    if (!$image && $placeholder) {
        $image = wc_placeholder_img_src($size);
    }

    return apply_filters('lestorg_product_get_image', $image, $product, $size, $image, $placeholder);
}

function set_product_loop_in_swiper($attrs) {
    $classes = $attrs['class'] ?? [];
    $classes = remove_value_array('catalog-grid__col', $classes);
    $classes[] = 'swiper-slide';
    $attrs['class'] = $classes;
    return $attrs;
}

function get_top_parent_id_product_cat($category_id) {
    do {
        $cat = get_term($category_id, 'product_cat');
        $category_id = $cat->parent;
        $category_parent_id = $cat->term_id;
    } while ($category_id);
    return $category_parent_id;
}

/*
 * Находит товар в карзине по переданому id
 */
function find_cart_item_by_id($product_id) {
    $cart_item_key = '';
    foreach (WC()->cart->get_cart() as $key => $item) {
        if ($item['product_id'] == $product_id) {
            $cart_item_key = $key;
            break;
        }
    }
    return $cart_item_key;
}


/**
 * Получает информацию обо всех зарегистрированных размерах картинок.
 *
 * @global $_wp_additional_image_sizes
 * @uses   get_intermediate_image_sizes()
 *
 * @param  boolean [$unset_disabled = true] Удалить из списка размеры с 0 высотой и шириной?
 * @return array Данные всех размеров.
 */
function get_image_sizes($unset_disabled = true) {
    $wais = &$GLOBALS['_wp_additional_image_sizes'];

    $sizes = [];

    foreach (get_intermediate_image_sizes() as $_size) {
        if (in_array($_size, ['thumbnail', 'medium', 'medium_large', 'large'])) {
            $sizes[$_size] = [
                'width' => get_option("{$_size}_size_w"),
                'height' => get_option("{$_size}_size_h"),
                'crop' => (bool)get_option("{$_size}_crop"),
            ];
        } elseif (isset($wais[$_size])) {
            $sizes[$_size] = [
                'width' => $wais[$_size]['width'],
                'height' => $wais[$_size]['height'],
                'crop' => $wais[$_size]['crop'],
            ];
        }

        // size registered, but has 0 width and height
        if ($unset_disabled && ($sizes[$_size]['width'] == 0) && ($sizes[$_size]['height'] == 0)) {
            unset($sizes[$_size]);
        }
    }

    return $sizes;
}

/*add_action('wp', function() {
    $ss = get_image_sizes(1);
    $qqq = 0;
});*/


/*
 * Этот треш для замены абсалютных путей относительными
 */
//add_filter('stylesheet_directory_uri', 'replace_main_url', 20);
//add_filter('template_directory_uri', 'replace_main_url', 20);
//add_filter('theme_file_uri', 'replace_main_url', 20);
//add_filter('script_loader_src', 'replace_main_url', 20);
//add_filter('option_siteurl', 'replace_option_siteurl', 999);
//add_action('wp_enqueue_scripts', 'replace_base_url', 999);

function replace_main_url($uri) {
    $uri = str_replace('http://lestorg.loc/', '/', $uri);
    return $uri;
}

function replace_base_url() {
    global $wp_styles;
    $wp_styles->base_url = '';
}

function replace_option_siteurl($er) {
    return '';
}
