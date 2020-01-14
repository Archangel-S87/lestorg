<?php

/**
 * Выводит иконки мессенджеров
 */
function print_messengers() {
    $items = ['telegram', 'whatsapp', 'viber'];
    echo get_socials_icon_list($items, 'messenger-item', 'messengers__grid');
}

/**
 * Выводит иконки соц сетей
 */
function print_socials() {
    $items = ['vk', 'facebook', 'instagram'];
    echo get_socials_icon_list($items, 'social-item', 'social__grid');
}

function get_socials_icon_list($items = [], $base_class = '', $container_class = '') {
    $html = '<div class="' . $container_class . '">';
    foreach ($items as $item) {
        $url = get_option($item);
        if (!$url) continue;
        $classes = [$base_class, 'ic', 'ic-' . $item];
        $html .= '<a href="' . $url . '" class="' . implode(' ', $classes) . '"></a>';
    }
    $html .= '</div>';
    return $html;
}
