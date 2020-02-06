<?php

/*
 * настройки темы
 */


class Lestorg_Acf_Options
{
    public function __construct()
    {
        $this->add_setting_pages();
        $this->add_contacts();
        $this->add_theme_settings();

        // В популярные проекты должны попасть не пустые категории
        add_filter('acf/fields/taxonomy/query/name=popular_projects', [$this, 'set_terms_popular_projects']);
    }

    public function set_terms_popular_projects($args)
    {
        $args['hide_empty'] = true;
        return $args;
    }

    private function add_setting_pages()
    {
        acf_add_options_page([
            'page_title' => 'Настроки темы',
            'menu_title' => 'Настроки темы',
            'menu_slug' => 'theme-settings',
            'capability' => 'edit_posts',
            'redirect' => false
        ]);

        acf_add_options_sub_page([
            'page_title' => 'Контакты',
            'menu_title' => 'Контакты',
            'parent_slug' => 'theme-settings'
        ]);
    }

    private function add_contacts()
    {
        acf_add_local_field_group([
            'key' => 'group_theme_settings_contacts',
            'title' => 'Контакты',
            'fields' => [
                [
                    'key' => 'field_tab_contacts_messengers',
                    'label' => 'Мессенджеры',
                    'type' => 'tab',
                    'placement' => 'top'
                ],
                [
                    'key' => 'field_group_contacts_messengers',
                    'label' => '',
                    'name' => 'contacts_messengers',
                    'type' => 'group',
                    'layout' => 'block',
                    'sub_fields' => [
                        [
                            'key' => 'field_telegram',
                            'label' => 'Telegram',
                            'name' => 'telegram',
                            'type' => 'url',
                            'instructions' => 'Ссылка на Telegram'
                        ],
                        [
                            'key' => 'field_whatsapp',
                            'label' => 'Whats App',
                            'name' => 'whatsapp',
                            'type' => 'url',
                            'instructions' => 'Ссылка на Whats App'
                        ],
                        [
                            'key' => 'field_viber',
                            'label' => 'Viber',
                            'name' => 'viber',
                            'type' => 'url',
                            'instructions' => 'Ссылка на Viber'
                        ]
                    ]
                ],
                [
                    'key' => 'field_tab_contacts_social_networks',
                    'label' => 'Социальные сети',
                    'type' => 'tab',
                    'placement' => 'top'
                ],
                [
                    'key' => 'field_group_contacts_social_networks',
                    'label' => '',
                    'name' => 'contacts_social_networks',
                    'type' => 'group',
                    'layout' => 'block',
                    'sub_fields' => [
                        [
                            'key' => 'field_vk',
                            'label' => 'ВК',
                            'name' => 'vk',
                            'type' => 'url',
                            'instructions' => 'Ссылка на ВК'
                        ],
                        [
                            'key' => 'field_facebook',
                            'label' => 'Facebook',
                            'name' => 'facebook',
                            'type' => 'url',
                            'instructions' => 'Ссылка на Facebook'
                        ],
                        [
                            'key' => 'field_instagram',
                            'label' => 'Instagram',
                            'name' => 'instagram',
                            'type' => 'url',
                            'instructions' => 'Ссылка на Instagram'
                        ]
                    ]
                ],
                [
                    'key' => 'field_tab_contacts_other',
                    'label' => 'Другие',
                    'type' => 'tab',
                    'placement' => 'top'
                ],
                [
                    'key' => 'field_group_contacts_other',
                    'label' => '',
                    'name' => 'contacts_other',
                    'type' => 'group',
                    'layout' => 'block',
                    'sub_fields' => [
                        [
                            'key' => 'field_phone',
                            'label' => 'Телефон',
                            'name' => 'phone',
                            'type' => 'text',
                            'instructions' => 'Телефон для связи'
                        ],
                        [
                            'key' => 'field_email',
                            'label' => 'Email',
                            'name' => 'email',
                            'type' => 'email',
                            'instructions' => 'Email для связи'
                        ],
                        [
                            'key' => 'field_address',
                            'label' => 'Адрес',
                            'name' => 'address',
                            'type' => 'textarea',
                            'instructions' => 'Адрес компании',
                            'rows' => 2
                        ],
                        [
                            'key' => 'field_group_coordinates',
                            'label' => 'Координаты карты',
                            'name' => 'coordinates',
                            'type' => 'group',
                            'instructions' => 'Координаты центра карты Яндекс.',
                            'layout' => 'block',
                            'sub_fields' => [
                                [
                                    'key' => 'field_coordinates_desktop',
                                    'label' => 'Координаты карты Desktop',
                                    'name' => 'desktop',
                                    'type' => 'text',
                                    'default_value' => '56.30960728549371, 44.25847738337088'
                                ],
                                [
                                    'key' => 'field_coordinates_mobile',
                                    'label' => 'Координаты карты Mobile',
                                    'name' => 'mobile',
                                    'type' => 'text',
                                    'default_value' => '56.32410818951451, 43.99145196679677'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'location' => [
                [
                    [
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'acf-options-kontakty',
                    ]
                ]
            ],
            'position' => 'acf_after_title',
            'active' => true
        ]);
    }

    private function add_theme_settings()
    {
        acf_add_local_field_group([
            'key' => 'group_theme-settings',
            'title' => 'Настройки темы',
            'fields' => [
                [
                    'key' => 'field_tab_front_page',
                    'label' => 'Главная страница',
                    'type' => 'tab'
                ],
                [
                    'key' => 'field_group_front_page',
                    'label' => '',
                    'name' => 'front_page',
                    'type' => 'group',
                    'layout' => 'block',
                    'sub_fields' => [
                        [
                            'key' => 'field_popular_projects',
                            'label' => 'Популярные проекты',
                            'name' => 'popular_projects',
                            'type' => 'taxonomy',
                            'taxonomy' => 'product_cat',
                            'field_type' => 'multi_select',
                            'allow_null' => 1,
                            'return_format' => 'object'
                        ],
                        [
                            'key' => 'field_accordion_other_services',
                            'label' => 'Наши услуги',
                            'type' => 'accordion'
                        ],
                        [
                            'key' => 'field_group_other_services',
                            'label' => '',
                            'name' => 'other_services',
                            'type' => 'group',
                            'instructions' => 'В описании поддерживается перенос строки.',
                            'layout' => 'block',
                            'sub_fields' => $this->get_group_other_services(6)
                        ]
                    ]
                ],
                [
                    'key' => 'field_tab_different',
                    'label' => 'Разное',
                    'type' => 'tab'
                ],
                [
                    'key' => 'field_group_different',
                    'label' => '',
                    'name' => 'different',
                    'type' => 'group',
                    'layout' => 'block',
                    'sub_fields' => [
                        [
                            'key' => 'field_reviews',
                            'label' => 'Отзывы',
                            'name' => 'reviews',
                            'type' => 'repeater',
                            'layout' => 'table',
                            'button_label' => 'Добавить отзыв',
                            'sub_fields' => [
                                [
                                    'key' => 'field_reviews_preview',
                                    'label' => 'Изображение превью',
                                    'name' => 'preview',
                                    'type' => 'image',
                                    'required' => 1,
                                    'return_format' => 'url',
                                    'preview_size' => 'thumbnail',
                                    'library' => 'all',
                                    'min_width' => 680,
                                    'min_height' => 470
                                ],
                                [
                                    'key' => 'field_reviews_url',
                                    'label' => 'Ссылка на видео',
                                    'name' => 'url',
                                    'type' => 'url',
                                    'required' => 1
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'location' => [
                [
                    [
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'theme-settings',
                    ]
                ]
            ],
            'position' => 'acf_after_title',
            'active' => 1
        ]);
    }

    private function get_group_other_services($count_groups)
    {
        $groups = [];
        for ($i = 0; $i < $count_groups; $i++) {
            $number = $i + 1;
            $groups[] = [
                'key' => 'field_group_other_services_' . $number,
                'label' => $number,
                'name' => $number,
                'type' => 'group',
                'wrapper' => [
                    'width' => '33.333'
                ],
                'layout' => 'block',
                'sub_fields' => [
                    [
                        'key' => 'field_other_services_title_' . $number,
                        'label' => 'Заголовок',
                        'name' => 'title',
                        'type' => 'text'
                    ],
                    [
                        'key' => 'field_other_services_description_' . $number,
                        'label' => 'Описание',
                        'name' => 'description',
                        'type' => 'textarea',
                        'rows' => 6,
                        'new_lines' => 'br'
                    ],
                    [
                        'key' => 'field_other_services_article_id_' . $number,
                        'label' => 'Статья',
                        'name' => 'article_id',
                        'type' => 'post_object',
                        'instructions' => 'Ссылка на статью',
                        'post_type' => [
                            0 => 'post'
                        ],
                        'taxonomy' => '',
                        'allow_null' => 1,
                        'return_format' => 'id',
                        'ui' => 1
                    ]
                ]
            ];
        }
        return $groups;
    }
}

$Lestorg_Acf_Options = new Lestorg_Acf_Options();
