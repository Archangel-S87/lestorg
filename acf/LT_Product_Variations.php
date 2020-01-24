<?php

/*
 * формирует вариации товаров для различных категорий
 */

class LT_Product_Variations
{
    static $prefix_key = 'field_';

    // Список категорий товаров с разными характеристиками
    public $product_cats = [
        'doma'
    ];

    private $current_cat = '';

    private $variant_labels = [
        'Домокомплект',
        'Под усадку',
        'Под ключ'
    ];

    public function __construct()
    {
        $this->hooks();
    }

    private function hooks()
    {
        add_action('init', [$this, 'add_all_fields']);
    }

    /*
     * Отображает атрибуты привязаные к категории
     */
    public function get_category_binding($taxonomies)
    {
        return lt_get_attached_attrs_cat_product($taxonomies);
    }

    public function add_all_fields()
    {
        foreach ($this->product_cats as $cat) {
            $this->current_cat = $cat;
            $args = call_user_func([$this, 'get_setting_' . $cat], $cat);
            acf_add_local_field_group($args);
        }
    }

    private function get_location_group($cat_slug)
    {
        $location = [];

        $match_type = [
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'product'
        ];

        $cat = get_term_by('slug', $cat_slug, 'product_cat');

        if ($cat) {
            $terms = get_terms([
                'hide_empty' => false,
                'taxonomy' => 'product_cat',
                'child_of' => $cat->term_id
            ]);
            if ($terms) {
                foreach ($terms as $key => $term) {
                    $match_cat = [
                        'param' => 'post_taxonomy',
                        'operator' => '==',
                        'value' => 'product_cat:' . $term->slug,
                    ];
                    $location[] = [$match_type, $match_cat];
                }
            }
        }

        return $location;
    }

    /*
     * Уникальный ключ поля
     */
    private function get_key($slug)
    {
        $hash = substr(md5($slug), 0, 13);
        return self::$prefix_key . $hash;
    }

    private function get_field_price($args = [])
    {
        $default = [
            'key' => '',
            'label' => 'Цена',
            'name' => 'price',
            'type' => 'number',
            'required' => 0,
            'default_value' => '',
            'min' => '0',
            'max' => '',
            'step' => ''
        ];
        return wp_parse_args($args, $default);
    }

    private function get_field_prices() {
        $prices = [];
        foreach ($this->variant_labels as $index => $variant) {
            $args = [
                'key' => $this->get_key($this->current_cat . '_price_' . $index),
                'name' => 'price_' . $index,
                'label' => $variant,
                'required' => 1,
                'wrapper' => [
                    'width' => '33.333'
                ]
            ];
            $prices[] = $this->get_field_price($args);
        }
        return [
            'key' => $this->get_key($this->current_cat . '_prices'),
            'label' => 'Цены',
            'name' => 'prices',
            'type' => 'group',
            'layout' => 'block',
            'sub_fields' => $prices
        ];
    }

    private function get_field_repeater() {
        return [
            'key' => $this->get_key($this->current_cat . '_repeater'),
            'label' => 'Свойства товара',
            'name' => 'repeater_custom_options',
            'type' => 'repeater',
            'collapsed' => '',
            'layout' => 'block',
            'button_label' => 'Новое Свойство',
            'sub_fields' => [
                [
                    'key' => $this->get_key($this->current_cat . '_product_attributes'),
                    'name' => 'product_attributes',
                    'type' => 'product_attributes',
                    'count_variants' => count($this->variant_labels)
                ]
            ]
        ];
    }

    public function get_setting_doma($cat_slug)
    {
        add_filter('acf/fields/product_attributes/wp_attribute_taxonomies', [$this, 'get_category_binding']);

        return [
            'key' => 'group_equipment_' . $this->current_cat,
            'title' => 'Комплектация дома',
            'fields' => [
                $this->get_field_prices(),
                $this->get_field_repeater()
            ],
            'location' => $this->get_location_group($cat_slug),
            'position' => 'normal',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'active' => 1
        ];
    }
}

$LT_Product_Variations = new LT_Product_Variations();
