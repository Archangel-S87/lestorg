<?php

if (empty(WC_ABSPATH) || !function_exists('acf_add_local_field_group')) return;

/*
 * формирует вариации товаров для различных категорий
 */

// TODO Не работает select - ajax

class LT_Product_Variations
{
    static $prefix_key = 'field_';

    // Список категорий товаров с разными характеристиками
    public $product_cats = [
        'doma'
    ];

    private $current_cat = '';

    private $post_id = 0;

    // Доступные атрибуты для текущего поста
    private $available_attr_taxonomies = [];

    private $field_key = '';

    public function __construct()
    {
        $action = $_GET['action'] ?? '';
        $post_id = $_GET['post'] ?? 0;

        //if ($action != 'edit' || !$post_id) return;

        $this->post_id = $post_id;

        $this->hooks();
    }

    private function hooks()
    {
        add_action('admin_init', [$this, 'add_all_fields']);
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

    private function get_field_price($index)
    {
        return [
            'key' => $this->get_key($this->current_cat . '_price_' . $index),
            'label' => 'Цена',
            'name' => 'price',
            'type' => 'number',
            'required' => 1,
            'default_value' => '',
            'min' => '0',
            'max' => '',
            'step' => ''
        ];
    }

    private function get_tab_group($index)
    {
        return [
            'key' => $this->get_key($this->current_cat . '_group_' . $index),
            'label' => '',
            'name' => 'group_' . $index,
            'type' => 'group',
            'required' => 0,
            'conditional_logic' => 0,
            'layout' => 'block',
            'sub_fields' => [
                $this->get_field_price($index),
                [
                    'key' => $this->get_key($this->current_cat . '_repeater_' . $index),
                    'label' => '',
                    'name' => 'repeater_custom_options',
                    'type' => 'repeater',
                    'collapsed' => '',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'table',
                    'button_label' => 'Добавить опцию',
                    'sub_fields' => [
                        [
                            'key' => $this->get_key($this->current_cat . '_product_attributes_' . $index),
                            'label' => 'Атрибуты товара',
                            'name' => 'product_attributes',
                            'type' => 'product_attributes'
                        ]
                    ]
                ]
            ]
        ];
    }

    private function get_tab($label, $index)
    {
        return [
            'key' => $this->get_key($this->current_cat . '_tab_' . $index),
            'label' => $label,
            'type' => 'tab'
        ];
    }

    private function get_variants()
    {
        $variants = [];
        $variant_labels = [
            'Домокомплект',
            'Под усадку',
            'Под ключ'
        ];
        foreach ($variant_labels as $index => $label) {
            $variants[] = $this->get_tab($label, $index);
            $variants[] = $this->get_tab_group($index);
        }
        return $variants;
    }

    public function get_setting_doma($cat_slug)
    {
        add_filter('acf/fields/product_attributes/wp_attribute_taxonomies', [$this, 'get_category_binding']);

        return [
            'key' => 'group_equipment_' . $this->current_cat,
            'title' => 'Комплектация дома',
            'fields' => $this->get_variants(), // смотри $origin_fields,
            'location' => $this->get_location_group($cat_slug),
            'menu_order' => 500,
            'position' => 'normal',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => 1
        ];
    }

}

$LT_Product_Variations = new LT_Product_Variations();
