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

        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs');

    }

    private function init_hooks()
    {
        // Заголовок и краткое описание
        add_action('woocommerce_before_single_product_summary', [$this, 'template_title_inn'], 5);

        add_action('woocommerce_before_single_product_summary', [$this, 'template_wrapper_grid_open']);
        add_action('woocommerce_after_single_product_summary', [$this, 'template_wrapper_grid_close'], 5);

        add_action('woocommerce_before_single_product_summary', [$this, 'template_gallery']);

        add_action('woocommerce_single_product_summary', [$this, 'template_wrapper_info_open'], 5);
        add_action('woocommerce_single_product_summary', [$this, 'template_wrapper_info_close'], 50);

        add_action('woocommerce_single_product_summary', [$this, 'template_info_title']);
        add_action('woocommerce_single_product_summary', [$this, 'template_info_table'], 15);
        add_action('woocommerce_single_product_summary', [$this, 'template_info_action'], 20);
        add_action('woocommerce_single_product_summary', [$this, 'template_info_share'], 25);

        add_action('woocommerce_after_single_product_summary', [$this, 'template_product_variations_table']);
        add_action('woocommerce_after_single_product_summary', [$this, 'template_product_description'], 15);
    }

    public function template_product_description()
    {
        global $product;
        if (!$product instanceof WC_Product) return;
        if (!$ee = $product->get_description()) return;

        ?>
        <div class="product__row">
            <div class="container">
                <div class="product__row-title">
                    <h3>Описание проекта</h3>
                </div>
                <div class="product-content box">
                    <div class="content">
                        <?= $product->get_description(); ?>
                    </div>
                    <div class="action-box">
                        <a href="#" class="btn">Оставить заявку</a>
                        <a href="#" class="btn btn_bd">Задать вопрос</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function template_product_variations_table()
    {
        $options = get_field('repeater_custom_options');

        if (!count($options)) return;

        $prices_db = get_field('prices');
        $prices = [];
        foreach ($prices_db as $value) {
            $value = (float)$value;
            $value = $value ? number_format($value, 0, '.', ' ') . ' ₽' : '-';
            $prices[] = $value;
        }

        ?>
        <div class="product__row">
            <div class="container">

                <div class="product__row-title">
                    <h3>Комплектации</h3>
                </div>

                <label class="product-table-select">
                    <select>
                        <?php foreach ($prices as $key => $price) : ?>
                            <option value="<?= $key; ?>">2 вариант, <?= $price; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <div class="product-table">
                    <div class="product-table__box box">
                        <table>
                            <thead>
                            <tr>
                                <th>Варианты комплектаций</th>
                                <?php foreach ($prices as $key => $price) : ?>
                                    <th data-item="<?= $key; ?>">1 вариант <br><b><?= $price; ?></b></th>
                                <?php endforeach; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($options as $option) : ?>
                                <?php $attr = $option['product_attributes'] ?? false; ?>
                                <?php if (!$attr) continue; ?>
                                <tr>
                                <td><?= $attr['attribute_label']; ?></td>
                                <?php foreach ($attr['variants'] as $key => $variant) : ?>
                                    <?php
                                    $val = $variant['term_label'];
                                    switch ($variant['view']) {
                                        case 'accent' :
                                            $val = '<b class="text-green">'. $val . '</b>';
                                            break;
                                        case 'crossed' :
                                            $val = '<s>' . $val . '</s>';
                                            break;
                                    }
                                    ?>
                                    <td data-item="<?= $key; ?>"><?= $val; ?></td>
                                <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="product-table__action">
                            <a href="#" class="btn btn_bd">Хочу другую комплектацию</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php
    }

    public function template_info_share()
    {
        // TODO сделать шаринг
        global $product;
        if (!$product instanceof WC_Product) return;
        echo '<div class="share">';

        /*<div class="share">
            <p class="share__head">Сохранить проект:</p>
            <div class="share__grid">
                <a href="#" class="share-item ic ic-vk"></a>
                <a href="#" class="share-item ic ic-facebook"></a>
                <a href="#" class="share-item ic ic-ok"></a>
                <a href="#" class="share-item ic ic-pinterest"></a>
            </div>
        </div>*/

        echo '</div>';
    }

    public function template_info_action()
    {
        global $product;
        if (!$product instanceof WC_Product) return;

        $html = '<div class="product-action">';

        if ($price_html = $product->get_price_html()) {
            $html .= '<div class="product-action__price">';
            $html .= '<p class="product-action__price-descr">Цена</p>';
            $html .= ' <p>от ' . $price_html . '</p>';
            $html .= '</div>';
        }

        // TODO Сделать добавление в избранное
        //$html .= '<a href="#" class="product-action__icon ic ic-heart"></a>';

        $html .= '<div class="product-action__btn">';
        $html .= '<a href="#" class="btn">Оставить заявку</a>';
        $html .= '</div>';

        $html .= '</div>';

        echo $html;
    }

    public function template_info_table()
    {
        global $product;
        if (!$product instanceof WC_Product) return;

        $attr = $product->get_attribute('pa_gabarity');
        $attributes = $product->get_attributes();
        $data = $product->get_data();

        echo '<table class="product-info__table">' . PHP_EOL;

        foreach ($attributes as $attr_name => $attribute) {
            $attr_id = wc_attribute_taxonomy_id_by_name($attr_name);
            $attribute = wc_get_attribute($attr_id);

            $value = $product->get_attribute($attr_name);

            $html = '<td>' . $attribute->name . '</td>' . PHP_EOL;
            $html .= '<td>' . $value . '</td>' . PHP_EOL;

            echo '<tr>' . $html . '</tr>' . PHP_EOL;
        }

        echo '</table>' . PHP_EOL;
    }

    public function template_info_title()
    {
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
