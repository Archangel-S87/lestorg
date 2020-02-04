<?php


class Lestorg_Customizer
{
    public function __construct(WP_Customize_Manager $wp_customize)
    {
        $this->add_contacts($wp_customize);
        $this->add_setting_home($wp_customize);
    }

    // Настройка контактов
    public function add_contacts(WP_Customize_Manager $wp_customize)
    {
        $wp_customize->add_panel('contacts', [
            'title' => 'Контакты',
            'description' => 'Связь с нами',
        ]);

        $setting_args = [
            'type' => 'option',
            'validate_callback' => [$this, 'validate_url']
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
            'validate_callback' => [$this, 'validate_phone']
        ]);
        $wp_customize->add_control('phone', [
            'section' => 'other',
            'label' => 'Телефон',
            'description' => 'Телефон для связи',
            'type' => 'text'
        ]);

        $wp_customize->add_setting('email', [
            'type' => 'option',
            'validate_callback' => [$this, 'validate_email']
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
    public function add_setting_home(WP_Customize_Manager $wp_customize)
    {
        $wp_customize->add_panel('lestorg_front_page', [
            'title' => 'Главная страница',
            'description' => 'Секции на главной странице',
        ]);

        $setting_args = [
            'type' => 'option'
        ];

        $wp_customize->add_section('popular_projects', [
            'title' => 'Популярные проекты',
            'panel' => 'lestorg_front_page'
        ]);

        $terms = get_terms([
            'taxonomy' => 'product_cat',
        ]);

        $choices = [];
        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $choices[$term->term_id] = $term->name;
            }
        }

        $wp_customize->add_setting('lestorg_popular_projects', $setting_args);
        $wp_customize->add_control(
            new CF_Select_Control(
                $wp_customize, 'lestorg_popular_projects', [
                'section' => 'popular_projects',
                'label' => 'Категории',
                'description' => 'Категорий будут отображаться на главной',
                'multi' => 1,
                'choices' => $choices
            ])
        );
    }

    // Валидирует значения Customize_Manager setting на url
    public function validate_url(WP_Error $validity, $value, $setting)
    {
        if ($value && !filter_var($value, FILTER_VALIDATE_URL)) {
            $validity->add('url_invalid', 'Не валидный url');
        }
        return $validity;
    }

    // Валидирует значения Customize_Manager setting на email
    public function validate_email(WP_Error $validity, $value, $setting)
    {
        if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $validity->add('url_invalid', 'Не валидный email');
        }
        return $validity;
    }

    // Валидирует значения Customize_Manager setting на phone
    public function validate_phone(WP_Error $validity, $value, $setting)
    {
        $pattern = '/^(\s*)?(\+)?([- _():=+{1}]?\d[- _():=+]?){7,14}(\s*)?$/';
        if ($value && !preg_match($pattern, $value)) {
            $validity->add('url_invalid', 'Не валидный телефон');
        }
        return $validity;
    }
}
