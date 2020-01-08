<?php

require_once get_template_directory() . '/tgm/tgm.php';
require_once get_template_directory() . '/cody-framework/admin.php';

require_once get_template_directory() . '/inc/init.php';
require_once get_template_directory() . '/inc/functioms-templates.php';


// Изменяем атрибут class у тега li
add_filter('nav_menu_css_class', 'filter_nav_menu_css_classes', 10, 4);
function filter_nav_menu_css_classes($classes, $item, $args, $depth) {
    if ($args->theme_location === 'main_header_menu') {
        if (in_array('menu-item-has-children', $classes)) {
            $classes = ['header__menu-dropdown'];
        }
    }
    return $classes;
}


/*
 * Этот треш для замены абсалютных путей относительными
 */
add_filter('stylesheet_directory_uri', 'replace_main_url', 20);
add_filter('template_directory_uri', 'replace_main_url', 20);
add_filter('theme_file_uri', 'replace_main_url', 20);
add_filter('script_loader_src', 'replace_main_url', 20);
add_action('wp_enqueue_scripts', 'action_function_name_7714', 999);

add_filter('option_siteurl', function ($er) {
    return '';
}, 999);

function replace_main_url($uri) {
    $uri = str_replace('http://lestorg.loc/', '/', $uri);
    return $uri;
}

function action_function_name_7714(){
    global $wp_styles;
    $wp_styles->base_url = '';
}


