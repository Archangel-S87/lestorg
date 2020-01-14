<?php

/*
 * Все модификации плгина WooCommerce в админке
 */

class WC_LT_Admin
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'admin_init']);
    }

    private function hooks()
    {
        /*
         * Убираю у товаров не нужные флажки
         * Убираю в списке товаров не нужные пункты сортировки
         */
        add_filter('product_type_options', [$this, 'product_type_options']);
        add_filter('woocommerce_products_admin_list_table_filters', [$this, 'render_filters']);
        add_filter('product_type_selector', [$this, 'product_type_selector']);

        /*
         * Настройка основного метабокса товара
         */
        add_filter('woocommerce_product_data_tabs', [$this, 'get_product_data_tabs']);

        /*
         * Удаляю стандартный метабокс данных и добавляю свой
         */
        add_action('add_meta_boxes', array($this, 'replace_wc_product_data'), 40);
    }

    public function admin_init()
    {
        $this->hooks();

        /*
         * Фильтр атрибутов на странице редактирования товара.
         * Возвращает только атрибуты прикреплённые к к категориям товара.
         */

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
        require_once dirname( __FILE__ ) . '/meta-boxes/class-lt-wc-meta-box-product-data.php';

        remove_meta_box('woocommerce-product-data', 'product', 'normal');
        add_meta_box('woocommerce-product-data', __('Product data', 'woocommerce'), 'LT_WC_Meta_Box_Product_Data::output', 'product', 'normal', 'high');
    }

    public function get_product_data_tabs($options)
    {
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
