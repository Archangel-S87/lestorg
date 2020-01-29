<?php

/*
 * Все модификации плгина WooCommerce в админке
 */

class WC_LT_Admin
{
    // Список атрибутов для сортировки
    public $sort_attributes = [
        'pa_ploshhad'
    ];

    public function __construct()
    {
        add_action('admin_init', [$this, 'admin_init']);
    }

    public function admin_init()
    {
        $this->include();
        $this->hooks();

        // TODO Запускать для пересохранения всех товаров!
        //$this->save_all_products();
    }

    public function include()
    {
        require_once dirname(__FILE__) . '/meta-boxes/class-lt-wc-meta-box-product-data.php';
        require_once 'WC_LT_Attributes.php';
    }

    public function hooks()
    {
        /*
        * Убираю у товаров не нужные флажки
        * Убираю в списке товаров не нужные пункты сортировки
        */
        add_filter('product_type_options', [$this, 'product_type_options']);
        add_filter('woocommerce_products_admin_list_table_filters', [$this, 'render_filters']);
        add_filter('product_type_selector', [$this, 'product_type_selector']);

        // Настройка основного метабокса товара
        add_filter('woocommerce_product_data_tabs', [$this, 'get_product_data_tabs']);

        // Удаляю стандартный метабокс данных и добавляю свой
        add_action('add_meta_boxes', array($this, 'replace_wc_product_data'), 40);

        /*
         * Сохранение метабоксов
         */
        // Сохранение местоположения объекта
        add_action('woocommerce_admin_process_product_object', 'LT_WC_Meta_Box_Product_Data::save_custom_fields');
        // Сохранение атрибутов участвующих в сортировке
        add_action('woocommerce_admin_process_product_object', [$this, 'save_order_by_attributes']);
        // Обновляю метаполе для сортировки
        add_action('woocommerce_admin_process_product_object', [$this, 'add_meta_key_for_order']);

        /*
         * На странице категории товаров удаляю поле Тип отображения и изображение
         */
        if (class_exists('WC_Admin_Taxonomies')) {
            $wc_admin_taxonomies = WC_Admin_Taxonomies::get_instance();;
            remove_action('product_cat_add_form_fields', [$wc_admin_taxonomies, 'add_category_fields']);
            remove_action('product_cat_edit_form_fields', [$wc_admin_taxonomies, 'edit_category_fields']);
            // Удаляю излбражения из таблицы
            remove_filter('manage_edit-product_cat_columns', [$wc_admin_taxonomies, 'product_cat_columns']);
            remove_filter('manage_product_cat_custom_column', [$wc_admin_taxonomies, 'product_cat_column']);
        }

        /*
         * На странице категорий добавляю в таблицу колонку с названием шаблона
         */
        add_filter('manage_edit-product_cat_columns', [$this, 'product_cat_columns']);
        add_filter('manage_product_cat_custom_column', [$this, 'product_cat_column'], 10, 3);
    }

    public function save_all_products()
    {
        $posts = get_posts([
            'numberposts' => -1,
            'post_type' => 'product',
        ]);
        foreach ($posts as $post) {
            $product = wc_get_product($post);
            $this->add_meta_key_for_order($product);
            $product->save();
        }
    }

    public function save_order_by_attributes(WC_Product $product)
    {
        foreach ($_POST['attribute_names'] as $index => $value) {
            if (!in_array($value, $this->sort_attributes)) continue;

            $attribute_id = $_POST['attribute_values'][$index][0] ?? 0;
            $term = get_term($attribute_id, $value);
            if (is_wp_error($term)) continue;

            preg_match('/^([\d.]+)/', $term->name, $match);
            $attribute_values = $match[0] ?? 0;
            if (!$attribute_values) continue;

            $product->update_meta_data('order_' . $value, $attribute_values);
        }
    }

    public function add_meta_key_for_order(WC_Product $product)
    {
        $popularity = $product->get_meta('order_favorite') ?: 0;
        $product->update_meta_data('order_favorite', $popularity);
    }

    public function product_cat_columns($columns)
    {
        $posts = $columns['posts'] ?? '';
        $columns['template'] = 'Шаблон';
        if ($posts) {
            unset($columns['posts']);
            $columns['posts'] = $posts;
        }
        $columns['handle'] = '';
        return $columns;
    }

    public function product_cat_column($columns, $column, $id)
    {
        if ($column == 'template') {
            $field = get_field_object('category_template', 'product_cat_' . $id);
            $val = $field['choices'][$field['value']] ?? '';
            $columns .= "<span>{$val}</span>";
        }
        return $columns;
    }

    public function product_type_selector($types)
    {
        if (isset($types['grouped'])) {
            unset($types['grouped']);
        }
        if (isset($types['external'])) {
            unset($types['external']);
        }
        if (isset($types['variable'])) {
            unset($types['variable']);
        }
        return $types;
    }

    public function replace_wc_product_data()
    {
        global $wp_meta_boxes;

        remove_meta_box('woocommerce-product-data', 'product', 'normal');
        add_meta_box('woocommerce-product-data', 'Данные проекта', 'LT_WC_Meta_Box_Product_Data::output', 'product', 'normal', 'high');

        // Сортировка метабоксов
        // Метабокс ACF должне быть после Данных товара
        $high = $wp_meta_boxes['product']['normal']['high'];
        $wp_meta_boxes['product']['normal']['high'] = array_reverse($high);
    }

    public function get_product_data_tabs($options)
    {
        $options['attribute']['label'] = 'Характериситики';
        $options['inventory']['class'] = ['show_if_virtual'];
        $options['shipping']['class'] = ['show_if_virtual'];
        $options['linked_product']['class'] = ['show_if_virtual'];
        $options['variations']['class'] = ['show_if_virtual'];
        $options['advanced']['class'] = ['show_if_virtual'];
        return $options;
    }

    public function product_type_callback()
    {
        $current_product_type = isset($_REQUEST['product_type']) ? wc_clean(wp_unslash($_REQUEST['product_type'])) : false;
        $output = '<select name="product_type" id="dropdown_product_type"><option value="">Filter by product type</option>';

        foreach (wc_get_product_types() as $value => $label) {
            $output .= '<option value="' . esc_attr($value) . '" ';
            $output .= selected($value, $current_product_type, false);
            $output .= '>' . esc_html($label) . '</option>';
        }

        $output .= '</select>';
        echo $output;
    }

    public function render_filters($filters)
    {
        if (isset($filters['product_type'])) {
            $filters['product_type'] = [$this, 'product_type_callback'];
        }
        return $filters;
    }

    public function product_type_options($options)
    {
        // remove "Virtual" checkbox
        if (isset($options['virtual'])) {
            unset($options['virtual']);
        }
        // remove "Downloadable" checkbox
        if (isset($options['downloadable'])) {
            unset($options['downloadable']);
        }
        return $options;
    }
}

$WC_LT_Admin = new WC_LT_Admin();
