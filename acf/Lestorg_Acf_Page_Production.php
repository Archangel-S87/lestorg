<?php

/*
 * Вывод дополнительных полей на странице Производство
 */


class Lestorg_Acf_Page_Production
{
    private $page_id = 0;

    public function __construct()
    {
        if ($page = get_page_by_path('production')) {
            $this->page_id = $page->ID;
            add_action('init', [$this, 'add_all_fields']);
        }
    }

    public function add_all_fields() {
        acf_add_local_field_group([
            'key' => 'group_production',
            'title' => 'Наше производства',
            'fields' => [
                [
                    'key' => 'field_type_production',
                    'label' => '',
                    'name' => 'type_production',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'sub_fields' => [
                        [
                            'key' => 'field_type_production_title',
                            'label' => 'Заголовок',
                            'name' => 'title',
                            'type' => 'text',
                            'required' => 1
                        ],
                        [
                            'key' => 'field_accordion_description',
                            'label' => 'Описание',
                            'type' => 'accordion',
                            'open' => 1
                        ],
                        [
                            'key' => 'field_type_production_description',
                            'label' => '',
                            'name' => 'description',
                            'type' => 'wysiwyg',
                            'toolbar' => 'basic',
                            'media_upload' => 0,
                            'delay' => 0
                        ],
                        [
                            'key' => 'field_accordion_gallery',
                            'label' => 'Фото галерея',
                            'type' => 'accordion'
                        ],
                        [
                            'key' => 'field_type_production_gallery',
                            'label' => '',
                            'name' => 'gallery',
                            'type' => 'gallery',
                            'return_format' => 'id',
                            'preview_size' => 'medium',
                            'insert' => 'append',
                            'library' => 'all',
                            'min_width' => 680
                        ],
                        [
                            'key' => 'field_accordion_video',
                            'label' => 'Видио',
                            'type' => 'accordion'
                        ],
                        [
                            'key' => 'field_type_production_video',
                            'label' => '',
                            'name' => 'video',
                            'type' => 'group',
                            'layout' => 'table',
                            'sub_fields' => [
                                [
                                    'key' => 'field_group_video_preview',
                                    'label' => 'Изображение превью',
                                    'name' => 'preview',
                                    'type' => 'image',
                                    'required' => 1,
                                    'wrapper' => [
                                        'width' => '20'
                                    ],
                                    'return_format' => 'url',
                                    'preview_size' => 'thumbnail',
                                    'library' => 'all',
                                    'min_width' => 680,
                                    'min_height' => 470
                                ],
                                [
                                    'key' => 'field_group_video_url',
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
                        'param' => 'page',
                        'operator' => '==',
                        'value' => $this->page_id
                    ]
                ]
            ],
            'active' => true
        ]);
    }
}

$Lestorg_Acf_Page_Production = new Lestorg_Acf_Page_Production();
