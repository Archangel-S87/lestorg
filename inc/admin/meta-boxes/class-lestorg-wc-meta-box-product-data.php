<?php

/*
 * Настройка Основного метабокса товара
 */


class Lestorg_WC_Meta_Box_Product_Data extends WC_Meta_Box_Product_Data
{
    const wc_path_meta_box = WC_ABSPATH . 'includes/admin/meta-boxes/';

    public static function output($post)
    {
        global $thepostid, $product_object;

        $thepostid = $post->ID;
        $product_object = $thepostid ? wc_get_product($thepostid) : new WC_Product();

        wp_nonce_field('woocommerce_save_data', 'woocommerce_meta_nonce');

        include 'views/html-product-data-panel.php';
    }

    private static function lestorg_output_tabs()
    {
        global $post, $thepostid, $product_object;

        if (self::check_replace_data_general()) {
            include 'views/html-product-data-general.php';
        } else {
            include self::wc_path_meta_box . 'views/html-product-data-general.php';
        }

        include self::wc_path_meta_box . 'views/html-product-data-inventory.php';
        include self::wc_path_meta_box . 'views/html-product-data-shipping.php';
        include self::wc_path_meta_box . 'views/html-product-data-linked-products.php';
        include 'views/html-product-data-attributes.php';
        include self::wc_path_meta_box . 'views/html-product-data-advanced.php';
    }

    public static function save_custom_fields(WC_Product $product)
    {
        if ($locality = $_POST['_locality_project'] ?? '') {
            $product->update_meta_data('locality_project', $locality);
        }
        if ($cords = $_POST['_cords_project'] ?? '') {
            $product->update_meta_data('cords_project', $cords);
        }
    }

    /**
     * Проверяет относиться ли товар к категории наши проекты
     *
     * @return boolean
     */
    private static function check_replace_data_general()
    {
        global $post;

        $product = wc_get_product($post);

        $cats = $product->get_category_ids();
        $cat_id = $cats[0] ?? 0;
        if (!$cat_id) return false;

        $cat_parent_id = get_top_parent_id_product_cat($cat_id);
        $cat = get_term($cat_parent_id, 'product_cat');

        return $cat->slug == 'completed';
    }

    private static function lestorg_get_product_type_options() {
        return apply_filters(
            'product_type_options',
            array(
                'virtual'      => array(
                    'id'            => '_virtual',
                    'wrapper_class' => 'show_if_simple',
                    'label'         => __( 'Virtual', 'woocommerce' ),
                    'description'   => __( 'Virtual products are intangible and are not shipped.', 'woocommerce' ),
                    'default'       => 'no',
                ),
                'downloadable' => array(
                    'id'            => '_downloadable',
                    'wrapper_class' => 'show_if_simple',
                    'label'         => __( 'Downloadable', 'woocommerce' ),
                    'description'   => __( 'Downloadable products give access to a file upon purchase.', 'woocommerce' ),
                    'default'       => 'no',
                ),
            )
        );
    }

    private static function lestorg_get_product_data_tabs() {
        $tabs = apply_filters(
            'woocommerce_product_data_tabs',
            array(
                'general'        => array(
                    'label'    => __( 'General', 'woocommerce' ),
                    'target'   => 'general_product_data',
                    'class'    => array( 'hide_if_grouped' ),
                    'priority' => 10,
                ),
                'inventory'      => array(
                    'label'    => __( 'Inventory', 'woocommerce' ),
                    'target'   => 'inventory_product_data',
                    'class'    => array( 'show_if_simple', 'show_if_variable', 'show_if_grouped', 'show_if_external' ),
                    'priority' => 20,
                ),
                'shipping'       => array(
                    'label'    => __( 'Shipping', 'woocommerce' ),
                    'target'   => 'shipping_product_data',
                    'class'    => array( 'hide_if_virtual', 'hide_if_grouped', 'hide_if_external' ),
                    'priority' => 30,
                ),
                'linked_product' => array(
                    'label'    => __( 'Linked Products', 'woocommerce' ),
                    'target'   => 'linked_product_data',
                    'class'    => array(),
                    'priority' => 40,
                ),
                'attribute'      => array(
                    'label'    => __( 'Attributes', 'woocommerce' ),
                    'target'   => 'product_attributes',
                    'class'    => array(),
                    'priority' => 50,
                ),
                'variations'     => array(
                    'label'    => __( 'Variations', 'woocommerce' ),
                    'target'   => 'variable_product_options',
                    'class'    => array( 'variations_tab', 'show_if_variable' ),
                    'priority' => 60,
                ),
                'advanced'       => array(
                    'label'    => __( 'Advanced', 'woocommerce' ),
                    'target'   => 'advanced_product_data',
                    'class'    => array(),
                    'priority' => 70,
                ),
            )
        );

        // Sort tabs based on priority.
        uasort( $tabs, array( __CLASS__, 'lestorg_product_data_tabs_sort' ) );

        return $tabs;
    }

    private static function lestorg_product_data_tabs_sort( $a, $b ) {
        if ( ! isset( $a['priority'], $b['priority'] ) ) {
            return -1;
        }

        if ( $a['priority'] === $b['priority'] ) {
            return 0;
        }

        return $a['priority'] < $b['priority'] ? -1 : 1;
    }
}
