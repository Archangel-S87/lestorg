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

        //add_action('woocommerce_single_product_summary', [$this, 'template_wrapper_info_open'], 5);
        //add_action('woocommerce_single_product_summary', [$this, 'template_wrapper_info_close'], 50);

        //add_action('woocommerce_single_product_summary', [$this, 'template_info_title']);
        //add_action('woocommerce_single_product_summary', [$this, 'template_info_table'], 15);
    }

    public function template_info_table()
    {
        ?>
        <table class="product-info__table">
            <tr>
                <td>Технология</td>
                <td>Проф. брус</td>
            </tr>
            <tr>
                <td>Общая площадь</td>
                <td><b class="text-green">128 м<sup>2</sup></b></td>
            </tr>
            <tr>
                <td>Габариты</td>
                <td>8х8 м</td>
            </tr>
            <tr>
                <td>Этажность</td>
                <td>2</td>
            </tr>
            <tr>
                <td>Срок строительства</td>
                <td>от 1 месяца</td>
            </tr>
            <tr>
                <td>Комнаты</td>
                <td>5</td>
            </tr>
            <tr>
                <td>Санузлы</td>
                <td>2</td>
            </tr>
            <tr>
                <td>Крыша</td>
                <td>4-скатная</td>
            </tr>
            <tr>
                <td>Угол наклона крыши</td>
                <td>30/25</td>
            </tr>
        </table>
        <!--//----------->
        <div class="product-action">
            <div class="product-action__price">
                <p class="product-action__price-descr">Цена</p>
                <p>от 4 120 000 ₽</p>
            </div>
            <a href="#" class="product-action__icon ic ic-heart"></a>
            <div class="product-action__btn">
                <a href="#" class="btn">Оставить заявку</a>
            </div>
        </div>
        <!--//----------->
        <div class="share">
            <p class="share__head">Сохранить проект:</p>
            <div class="share__grid">
                <a href="#" class="share-item ic ic-vk"></a>
                <a href="#" class="share-item ic ic-facebook"></a>
                <a href="#" class="share-item ic ic-ok"></a>
                <a href="#" class="share-item ic ic-pinterest"></a>
            </div>
        </div>
        <?php
    }

    public function template_info_title() {
        echo '<div class="product-info__title"><h4>Характеристики</h4></div>';
    }

    public function template_wrapper_info_open()
    {
        echo '<div class="product-grid__col">';
        echo '<div class="product-info box">';
        echo '<div class="product-info__wrap">';
    }

    public function template_wrapper_info_close()
    {
        echo '</div><!--.product-info__wrap-->';
        echo '</div><!--.product-info-->';
        echo '</div><!--.product-grid__col-->';
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
        echo '<div class="product-grid__col" style="width: 100%;">';
        echo '
<style>
    .product-grid__col:nth-child(1) {
    max-width: 100%;
    flex: 0 0 auto;
    }
    .product-gallery {
    margin: 0 auto;
    }
    .product-grid {
    margin-bottom: 40px;
    }
</style>        
        ';
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
