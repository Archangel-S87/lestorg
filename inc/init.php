<?php

add_action('after_setup_theme', 'lestorg_setup');
function lestorg_setup() {
    add_theme_support('html5', [
        'style',
        'comment-list',
        'comment-form',
        'search-form',
        'gallery',
        'caption'
    ]);

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('align-wide');

    add_theme_support('woocommerce', [
        'thumbnail_image_width' => 380,
        'single_image_width' => 700,
        'product_grid' => [ // Отключено
            'default_rows' => 3,
            'min_rows' => 1,
            'max_rows' => 4,
            'default_columns' => 3,
            'min_columns' => 2,
            'max_columns' => 3
        ]
    ]);

    add_theme_support('custom-logo', [
        'width'       => 230,
        'height'      => 60,
        'flex-width'  => true,
        'flex-height' => true
    ]);

    register_nav_menus([
        'top_header_menu' => 'Верхнее меню',
        'main_header_menu' => 'Главное меню',
        'footer_menu_1' => 'Нижнее меню 1',
        'footer_menu_2' => 'Нижнее меню 2'
    ]);

    //Хак плагина folder
    if (get_option('folder_old_plugin_folder_status') < 500) {
        update_option('folder_old_plugin_folder_status', 500);
    }
}

add_filter('upload_mimes', 'upload_allow_types');
function upload_allow_types($mimes) {
    $mimes['svg']  = 'text/plain';
    return $mimes;
}

add_action('wp_enqueue_scripts', 'lestorg_scripts');
function lestorg_scripts() {
    wp_enqueue_style('lestorg-icomoon', get_theme_file_uri('assets/libs/icomoon/style.css'));
    wp_enqueue_style('lestorg-style', get_theme_file_uri('assets/css/main.min.css'), [], wp_get_theme()->get('Version'));

    wp_enqueue_script('lestorg-libs', get_theme_file_uri('assets/js/libs.min.js'), ['jquery'], wp_get_theme()->get('Version'));
    wp_enqueue_script('lestorg-scripts', get_theme_file_uri('assets/js/common.js'), ['lestorg-libs'], wp_get_theme()->get('Version'));
}

add_action('admin_enqueue_scripts', 'lt_admin_scripts');
function lt_admin_scripts() {
    wp_enqueue_style('lt-admin-style', get_theme_file_uri('assets/css/admin.css'), [], wp_get_theme()->get('Version'));
    wp_enqueue_script('lt-admin-scripts', get_theme_file_uri('assets/js/admin.js'), ['jquery'], wp_get_theme()->get('Version'));
}

// Настройка контактов
add_action('customize_register', 'admin_add_contacts');
function admin_add_contacts(WP_Customize_Manager $wp_customize) {

    $wp_customize->add_panel('contacts', [
        'title' => 'Контакты',
        'description' => 'Связь с нами',
    ]);

    $setting_args = [
        'type' => 'option',
        'validate_callback' => 'validate_url_customize_manager'
    ];

    // messengers
    $wp_customize->add_section('messengers', [
        'title' => 'Мессенджеры',
        'panel' => 'contacts'
    ]);

    $wp_customize->add_setting('telegram', $setting_args);
    $wp_customize->add_control('telegram', [
        'section' => 'messengers',
        'label' => 'Telegram',
        'description' => 'Ссылка на Telegram',
        'type' => 'url'
    ]);

    $wp_customize->add_setting('whatsapp', $setting_args);
    $wp_customize->add_control('whatsapp', [
        'section' => 'messengers',
        'label' => 'Whats App',
        'description' => 'Ссылка на Whats App',
        'type' => 'url'
    ]);

    $wp_customize->add_setting('viber', $setting_args);
    $wp_customize->add_control('viber', [
        'section' => 'messengers',
        'label' => 'Viber',
        'description' => 'Ссылка на Viber',
        'type' => 'url'
    ]);

    // social_networks
    $wp_customize->add_section('social_networks', [
        'title' => 'Социальные сети',
        'panel' => 'contacts'
    ]);

    $wp_customize->add_setting('vk', $setting_args);
    $wp_customize->add_control('vk', [
        'section' => 'social_networks',
        'label' => 'ВК',
        'description' => 'Ссылка на ВК',
        'type' => 'url'
    ]);

    $wp_customize->add_setting('facebook', $setting_args);
    $wp_customize->add_control('facebook', [
        'section' => 'social_networks',
        'label' => 'Facebook',
        'description' => 'Ссылка на Facebook',
        'type' => 'url'
    ]);

    $wp_customize->add_setting('instagram', $setting_args);
    $wp_customize->add_control('instagram', [
        'section' => 'social_networks',
        'label' => 'Instagram',
        'description' => 'Ссылка на Instagram',
        'type' => 'url'
    ]);

    // other
    $wp_customize->add_section('other', [
        'title' => 'Другие',
        'panel' => 'contacts'
    ]);

    $wp_customize->add_setting('phone', [
        'type' => 'option',
        'validate_callback' => 'validate_phone_customize_manager'
    ]);
    $wp_customize->add_control('phone', [
        'section' => 'other',
        'label' => 'Телефон',
        'description' => 'Телефон для связи',
        'type' => 'text'
    ]);

    $wp_customize->add_setting('email', [
        'type' => 'option',
        'validate_callback' => 'validate_email_customize_manager'
    ]);
    $wp_customize->add_control('email', [
        'section' => 'other',
        'label' => 'Email',
        'description' => 'Email для связи',
        'type' => 'email'
    ]);

    $wp_customize->add_setting('address', [
        'type' => 'option'
    ]);
    $wp_customize->add_control('address', [
        'section' => 'other',
        'label' => 'Адрес',
        'description' => 'Адрес компании',
        'type' => 'textarea'
    ]);

    $wp_customize->add_setting('coordinates_map_pc', [
        'type' => 'option'
    ]);
    $wp_customize->add_control('coordinates_map_pc', [
        'section' => 'other',
        'label' => 'Координаты карты Desktop',
        'default' => '56.30960728549371, 44.25847738337088',
        'description' => 'Координаты центра карты Яндекс.'
    ]);

    $wp_customize->add_setting('coordinates_map_mob', [
        'type' => 'option'
    ]);
    $wp_customize->add_control('coordinates_map_mob', [
        'section' => 'other',
        'label' => 'Координаты карты Mobile',
        'default' => '56.32410818951451, 43.99145196679677',
        'description' => 'Координаты центра карты Яндекс.'
    ]);
}

// Настройки Главная страница
add_action('customize_register', 'admin_add_setting_home', 99);
function admin_add_setting_home(WP_Customize_Manager $wp_customize) {

    $wp_customize->add_panel('lt_front_page', [
        'title' => 'Главная страница',
        'description' => 'Секции на главной странице',
    ]);

    $setting_args = [
        'type' => 'option'
    ];

    $wp_customize->add_section('popular_projects', [
        'title' => 'Популярные проекты',
        'panel' => 'lt_front_page'
    ]);

    $terms = get_terms([
        'taxonomy' => 'product_cat',
    ]);

    $choices = [];
    if ($terms && !is_wp_error($terms))  {
        foreach ($terms as $term) {
            $choices[$term->term_id] = $term->name;
        }
    }

    $wp_customize->add_setting('lt_popular_projects', $setting_args);
    $wp_customize->add_control(
        new CF_Select_Control(
            $wp_customize, 'lt_popular_projects', [
            'section' => 'popular_projects',
            'label' => 'Категории',
            'description' => 'Категорий будут отображаться на главной',
            'multi' => 1,
            'choices' => $choices
        ])
    );
}

// Валидирует значения Customize_Manager setting на url
function validate_url_customize_manager(WP_Error $validity, $value, $setting) {
    if ($value && !filter_var($value, FILTER_VALIDATE_URL)) {
        $validity->add('url_invalid', 'Не валидный url');
    }
    return $validity;
}

// Валидирует значения Customize_Manager setting на email
function validate_email_customize_manager(WP_Error $validity, $value, $setting) {
    if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
        $validity->add('url_invalid', 'Не валидный email');
    }
    return $validity;
}

// Валидирует значения Customize_Manager setting на phone
function validate_phone_customize_manager(WP_Error $validity, $value, $setting) {
    $pattern = '/^(\s*)?(\+)?([- _():=+{1}]?\d[- _():=+]?){7,14}(\s*)?$/';
    if ($value && !preg_match($pattern, $value)) {
        $validity->add('url_invalid', 'Не валидный телефон');
    }
    return $validity;
}
