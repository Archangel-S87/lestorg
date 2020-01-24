<?php

/*
 * Вывод дополнительных полей на странице категорий товаров
 */


class LT_Category_Product
{
    public function __construct()
    {
        add_action('init', [$this, 'add_all_fields']);
    }

    public function add_all_fields()
    {
        $location = [
            [
                [
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'product_cat'
                ]
            ]
        ];
        $fields = [
            [
                'key' => 'field_category_template',
                'label' => 'Шаблон',
                'name' => 'category_template',
                'type' => 'select',
                'instructions' => 'Вид вывода категории',
                'required' => 1,
                'conditional_logic' => 0,
                'choices' => [
                    'simple' => 'Простой',
                    'tabs' => 'С табами',
                    'sidebar' => 'С сайдбаром'
                ],
                'default_value' => [
                    0 => 'simple'
                ],
                'return_format' => 'value'
            ]
        ];
        $group = [
            'key' => 'group_category_template',
            'title' => 'Настройки отображения',
            'fields' => $fields,
            'location' => $location,
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ];

        acf_add_local_field_group($group);
    }
}

$LT_Category_Product = new LT_Category_Product();
