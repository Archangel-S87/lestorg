<?php

require_once 'Lestorg_Single.php';


class Lestorg_Single_Main extends Lestorg_Single
{
    use Lestorg_Instance;

    public function run()
    {
        parent::run();

        $this->add_action('woocommerce_before_single_product_summary', [$this, 'add_local_storage'], 5);

        $this->add_action('woocommerce_single_product_summary', [$this, 'get_the_preview']);

        $this->add_action('woocommerce_after_single_product_summary', [$this, 'get_the_variations_table'], 5);

        $this->add_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 10);
    }

    public function get_the_preview()
    {
        ?>
        <div class="product-grid">
            <div class="product-grid__col">
                <?php $this->get_the_gallery(); ?>
            </div>
            <div class="product-grid__col">

                <div class="product-info box">
                    <div class="product-info__wrap">
                        <div class="product-info__main">
                            <?php $this->get_the_info_table(); ?>
                        </div>

                        <div class="product-action">

                            <?php if ($price_html = $this->product->get_price_html()) : ?>
                                <div class="product-action__price">
                                    <p class="product-action__price-descr">Цена</p>
                                    <p>от <?= $price_html; ?></p>
                                </div>
                            <?php endif; ?>

                            <?php
                            $has_favorites = find_cart_item_by_id($this->product->get_id());
                            $classes_icon = 'product-action__icon ic ic-heart toggle-favorites';
                            $classes_icon = $has_favorites ? $classes_icon . ' active' : $classes_icon;
                            $title_icon = $has_favorites ? 'Убрать из избраного' : 'Добавить в избранное';
                            ?>
                            <a href="#" class="<?= $classes_icon; ?>" data-product="<?= $this->product->get_id(); ?>" title="<?= $title_icon; ?>"></a>

                            <div class="product-action__btn">
                                <a href="#call-popup" data-popup class="btn">Оставить заявку</a>
                            </div>

                        </div>

                        <?php $this->get_the_share(); ?>

                    </div>
                </div>

            </div>
        </div>
        <?php
    }

    public function get_the_variations_table()
    {
        $options = get_field('repeater_custom_options', $this->product->get_id());

        if (!is_array($options) || !count($options)) return;

        $prices_db = get_field('prices');
        $prices = [];
        $variants_name = ['Домокомплект', 'Под усадку', 'Под ключ'];
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

                <div class="product-table">

                    <label class="product-table__select">
                        <select>
                            <?php foreach ($prices as $key => $price) : ?>
                                <option value="<?= $key; ?>"><?= $variants_name[$key]; ?>, <?= $price; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <div class="product-table__box box">
                        <table>
                            <thead>
                            <tr>
                                <th>Варианты комплектаций</th>
                                <?php foreach ($prices as $key => $price) : ?>
                                    <th data-item="<?= $key; ?>"><?= $variants_name[$key]; ?> <br><b><?= $price; ?></b>
                                    </th>
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
                                        $view = $variant['view'] ?? '';
                                        switch ($view) {
                                            case 'accent' :
                                                $val = '<b class="text-green">' . $val . '</b>';
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
                            <a href="#call-popup" data-popup class="btn btn_bd">Хочу другую комплектацию</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php
    }
}
