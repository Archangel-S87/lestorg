<?php

define('LT_PATCH', dirname(__FILE__));

require_once 'libs/tgm/tgm.php';
require_once 'libs/cody-framework/admin.php';
require_once 'acf/init.php';

require_once 'inc/includes/LT_Instance.php';
require_once 'inc/includes/LT_Hooks.php';
require_once 'inc/init.php';
require_once 'inc/functions-templates.php';

require_once 'woocommerce/functions.php';

require_once 'ajax/init.php';


// Изменяем атрибут class у тега li в меню
add_filter('nav_menu_css_class', 'filter_nav_menu_css_classes', 10, 4);
function filter_nav_menu_css_classes($classes, $item, $args, $depth) {
    if ($args->theme_location != 'main_header_menu') return $classes;

    if (in_array('menu-item-has-children', $classes)) {
        if ($args->menu_id == 'mob_main_header_menu') {
            $classes[] = 'mob-menu__list-dropdown';
        }
        if ($args->menu_id == 'main_header_menu') {
            $classes[] = 'header__menu-dropdown';
        }
    }

    if ($args->menu_id == 'mob_main_header_menu') {
        if (strripos($item->post_title, 'ic-') !== false) {
            $classes[] = 'mob-menu__list-icon';
        }
    }

    if ($args->menu_id == 'main_header_menu') {
        if (strripos($item->post_title, 'ic-') !== false) {
            $classes[] = 'header__menu-icon';
        }
    }

    return $classes;
}

/*
 * Классы для внутренних страниц
 */
add_filter('body_class', 'change_body_classes');
function change_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'page-home';
    }
    if (!is_front_page()) {
        $classes[] = 'page-inner';
    }
    if (is_product()) {
        $classes[] = 'page-product';
    }
    if (is_page(['about', 'contacts', 'favorite'])) {
        $classes[] = 'page-contacts';
    }
    return $classes;
}

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
