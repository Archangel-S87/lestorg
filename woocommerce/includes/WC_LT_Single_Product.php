<?php

/*
 * Отвечает за вывод подробного описания товара.
 */

class WC_LT_Single_Product
{
    public function __construct()
    {
        $this->remove_default_hooks();
        $this->init_hooks();
    }

    private function remove_default_hooks()
    {
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash');
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);

        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating');
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price');
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
    }

    private function init_hooks()
    {
        // Заголовок и краткое описание
        add_action('woocommerce_before_single_product_summary', [$this, 'template_title_inn'], 5);

        add_action('woocommerce_before_single_product_summary', [$this, 'template_wrapper_grid_open']);
        add_action('woocommerce_after_single_product_summary', [$this, 'template_wrapper_grid_close'], 5);

        add_action('woocommerce_before_single_product_summary', [$this, 'template_gallery']);
    }



    private function get_gallery()
    {
        global $product;

        $gallery = new WC_LT_Product_Gallery_Images($product, [
            'thumbnail',
            'woocommerce_thumbnail',
            'full'
        ]);

        $images = $gallery->get_images();

        if (!$images) return;

        wc_get_template('single-product/product-gallery.php', [
            'images' => $images
        ]);
    }

    public function template_gallery()
    {
        echo '<div class="product-grid__col">';
        $this->get_gallery();
        echo '</div><!--.product-grid__col-->';
    }

    public function template_wrapper_grid_close()
    {
        echo '</div><!--.product-grid-->';
    }

    public function template_wrapper_grid_open()
    {
        echo '<div class="product-grid">';
    }

    public function template_title_inn()
    {
        global $product;
        if (!$product instanceof WC_Product) return;

        $html = '<div class="title-inn">';
        $html .= '<h2 class="product_title entry-title">' . get_the_title() . '</h2>';
        $html .= '<p>' . $product->get_short_description() . '</p>';
        $html .= '</div>';

        echo $html;
    }

}

$WC_LT_Single_Product = new WC_LT_Single_Product();
