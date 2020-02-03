<?php

/*
 * Вывод дополнительных полей в Акциях
 */


class Lestorg_Acf_Offers
{
    public function __construct()
    {
        add_action('init', [$this, 'add_all_fields']);
    }

    public function add_all_fields()
    {
        acf_add_local_field_group([
            'key' => 'group_offer',
            'title' => 'Акция',
            'fields' => [
                [
                    'key' => 'field_image',
                    'label' => 'Изображение',
                    'name' => 'image',
                    'type' => 'image',
                    'return_format' => 'url',
                    'preview_size' => 'full',
                    'library' => 'all',
                ],
                [
                    'key' => 'field_text_layout',
                    'label' => 'Расположение текста',
                    'name' => 'text_layout',
                    'type' => 'radio',
                    'choices' => [
                        'left' => 'Текст слева',
                        'right' => 'Текст справа'
                    ],
                    'default_value' => 'left',
                    'layout' => 'horizontal'
                ],
                [
                    'key' => 'field_title',
                    'label' => 'Заголовок',
                    'name' => 'title',
                    'type' => 'text',
                    'instructions' => 'Для выделения части заголовка используйте символы "[" и "]" без кавычек. Пример: [Скидка 10%] на доп работы'
                ],
                [
                    'key' => 'field_description',
                    'label' => 'Краткое описание',
                    'name' => 'description',
                    'type' => 'textarea',
                    'rows' => 2,
                    'new_lines' => ''
                ],
                [
                    'key' => 'field_time_action',
                    'label' => 'Время действия акции',
                    'name' => 'time_action',
                    'type' => 'text',
                    'instructions' => 'Пример: Акция действует до 30.12.2019 года'
                ],
                [
                    'key' => 'field_button_label',
                    'label' => 'Текст кнопки',
                    'name' => 'button_label',
                    'type' => 'text',
                    'default_value' => 'Участвовать'
                ]
            ],
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'offer'
                    ]
                ]
            ],
            'menu_order' => 0,
            'position' => 'acf_after_title',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => [
                'the_content',
                'excerpt',
                'discussion',
                'comments',
                'revisions',
                'slug',
                'author',
                'format',
                'page_attributes',
                'featured_image',
                'categories',
                'tags',
                'send-trackbacks'
            ],
            'active' => true,
            'description' => ''
        ]);
    }
}

$Lestorg_Acf_Offers = new Lestorg_Acf_Offers();
