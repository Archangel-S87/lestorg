<?php

/**
 * Выводит иконки мессенджеров
 */
function print_messengers() {
    $items = $other_options = get_field('contacts_messengers', 'option') ?: [];
    echo get_socials_icon_list($items, 'messenger-item', 'messengers__grid');
}

/**
 * Выводит иконки соц сетей
 */
function print_socials() {
    $items = $other_options = get_field('contacts_social_networks', 'option') ?: [];
    echo get_socials_icon_list($items, 'social-item', 'social__grid');
}

function get_socials_icon_list($items = [], $base_class = '', $container_class = '') {
    $html = '<div class="' . $container_class . '">';
    foreach ($items as $name => $url) {
        if (!$url) continue;
        $classes = [$base_class, 'ic', 'ic-' . $name];
        $html .= '<a href="' . $url . '" class="' . implode(' ', $classes) . '"></a>';
    }
    $html .= '</div>';
    return $html;
}

function print_feedback() {
    include LT_PATCH . '/template-parts/parts/other/feedback.php';
}

function print_company_in_numbers() {
    include LT_PATCH . '/template-parts/parts/other/company-in-numbers.php';
}

function print_main_map() {
    include LT_PATCH . '/template-parts/parts/other/main-map.php';
}

function print_popular_project() {
    include LT_PATCH . '/template-parts/parts/other/popular-project.php';
}

function print_cases() {
    include LT_PATCH . '/template-parts/parts/other/cases.php';
}

function print_offers() {
    include LT_PATCH . '/template-parts/parts/other/offers.php';
}

function print_reviews() {
    include LT_PATCH . '/template-parts/parts/other/reviews.php';
}
