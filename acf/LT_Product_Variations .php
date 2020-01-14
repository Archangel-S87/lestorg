<?php

if (empty(WC_ABSPATH) || !function_exists('acf_add_local_field_group')) return;

/*
 * формирует вариации товаров для различных категорий
 */

// TODO Не работает select - ajax

class LT_Product_Variations
{
    static $prefix_key = 'field_';

    public $product_cats = [
        'doma'
    ];

    private $post_id = 0;

    // Доступные атрибуты для текущего поста
    private $available_attr_taxonomies = [];

    private $field_price = [
        'label' => 'Цена',
        'name' => 'price',
        'type' => 'number',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => [
            'width' => '',
            'class' => '',
            'id' => ''
        ],
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'min' => '',
        'max' => '',
        'step' => ''
    ];

    private $field_taxonomy = [
        'type' => 'taxonomy',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => [
            'width' => '25',
            'class' => '',
            'id' => '',
        ],
        'field_type' => 'radio', //select checkbox
        'allow_null' => 0,
        'add_term' => 1,
        'save_terms' => 0,
        'load_terms' => 0,
        'return_format' => 'id',
        'multiple' => 0
    ];

    public function __construct()
    {
        $action = $_GET['action'] ?? '';
        $post_id = $_GET['post'] ?? 0;

        if ($action != 'edit' || !$post_id) return;

        $this->post_id = $post_id;

        $this->hooks();
    }

    private function hooks()
    {
        add_action('admin_init', [$this, 'add_all_fields']);
    }

    public function add_all_fields()
    {
        foreach ($this->product_cats as $cat) {
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

    private function get_key($product, $slug)
    {
        $str = $product->get_id() . '_' . $slug;
        $hash = substr(md5($str), 0, 13);
        return self::$prefix_key . $hash;
    }

    private function get_sub_fields_group()
    {
        $product = wc_get_product($this->post_id);

        if (!$product) return [];

        $attr_taxonomies = wc_get_attribute_taxonomies();
        $this->available_attr_taxonomies = lt_get_attached_attrs_cat_product($attr_taxonomies);

        $use_attr_taxonomies = $product->get_attributes();

        $free_attrs = [];
        foreach ($this->available_attr_taxonomies as $attr_tax) {
            $name = 'pa_' . $attr_tax->attribute_name;
            if (!isset($use_attr_taxonomies[$name])) {
                $free_attrs[] = $attr_tax;
            }
        }

        $sub_fields[] = wp_parse_args([
            'key' => $this->get_key($product, 'price')
        ], $this->field_price);

        foreach ($free_attrs as $attr) {
            $args = [
                'key' => $this->get_key($product, $attr->attribute_name),
                'label' => $attr->attribute_label,
                'name' => $attr->attribute_name,
                'taxonomy' => 'pa_' . $attr->attribute_name
            ];
            $sub_fields[] = wp_parse_args($args, $this->field_taxonomy);
        }

        return $sub_fields;
    }

    public function get_setting_doma($cat_slug)
    {
        $location = $this->get_location_group($cat_slug);

        $sub_fields = $this->get_sub_fields_group();

        if (!$sub_fields) return [];

        return [
            'key' => 'group_5e1b7278c9459',
            'title' => 'Комплектация дома',
            'fields' => [
                [
                    'key' => 'field_5jh4588eda2c9',
                    'label' => '',
                    'name' => 'variants',
                    'type' => 'flexible_content',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'layouts' => [
                        'layout_5e1bgd9f2581fd6' => [
                            'key' => 'layout_5e1bgd9f2581fd6',
                            'name' => 'variant',
                            'label' => 'Вариант',
                            'display' => 'block', //block row
                            'sub_fields' => $sub_fields,
                            'min' => '',
                            'max' => '',
                        ]
                    ],
                    'button_label' => 'Добавить',
                    'min' => 3,
                    'max' => 3,
                ]
            ],
            'location' => $location,
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => 1,
            'description' => ''
        ];
    }

}

$LT_Product_Variations = new LT_Product_Variations();
