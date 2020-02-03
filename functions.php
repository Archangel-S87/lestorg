<?php

define('LT_PATCH', dirname(__FILE__));

require_once 'libs/tgm/tgm.php';

require_once 'inc/functions-templates.php';

require_once 'woocommerce/functions.php';

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
