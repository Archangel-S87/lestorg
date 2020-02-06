<?php

require_once LT_PATCH . '/inc/Lestorg_Hooks.php';


abstract class Lestorg_Single
{
    use Lestorg_Hooks;

    /**
     * @var WC_Product
     */
    protected $product;

    /**
     * @var WP_Term
     */
    protected $parent_term;


    public function set_product(WC_Product $product): self
    {
        $this->product = $product;
        return $this;
    }

    public function set_parent_term(WP_Term $term)
    {
        $this->parent_term = $term;
        return $this;
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

        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
    }

    public function run()
    {
        $this->remove_default_hooks();

        // Теги Open Graph
        $this->add_action('wp_head', [$this, 'add_open_graph']);

        // Классы обёртки
        $this->add_filter('lestorg_woocommerce_wrapper_class', [$this, 'add_wrapper_class']);

        // Заголовок и краткое описание
        $this->add_action('woocommerce_before_single_product_summary', [$this, 'get_the_title']);

        // Описание проекта
        $this->add_action('lestorg_after_woocommerce_main_container', [$this, 'get_the_description']);
    }

    public function add_wrapper_class($classes)
    {
        array_unshift($classes, 'product');
        return $classes;
    }

    public function get_the_title()
    {
        ?>

        <div class="title-inn">
            <h2><?php the_title(); ?></h2>
            <p><?= $this->product->get_short_description(); ?></p>
        </div>

        <?php
    }

    public function get_the_gallery()
    {
        require_once LT_PATCH . '/inc/Lestorg_Product_Gallery_Images.php';

        $gallery = new Lestorg_Product_Gallery_Images($this->product, [
            'thumbnail',
            'woocommerce_single',
            'full'
        ]);
        $gallery->get_images();
        $gallery->get_html();
    }

    public function get_the_info_table()
    {
        $attributes = $this->product->get_attributes();
        ?>
        <div class="product-info__title">
            <h4>Характеристики</h4>
        </div>
        <table class="product-info__table">
            <?php foreach ($attributes as $attr_name => $attribute) : ?>
                <?php
                $attr_id = wc_attribute_taxonomy_id_by_name($attr_name);
                $attribute = wc_get_attribute($attr_id);
                ?>
                <tr>
                    <td><?= $attribute->name; ?></td>
                    <td><?= $this->product->get_attribute($attr_name) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php
    }

    // Добавление тегов Open Graph
    public function add_open_graph()
    {
        $product = $this->product;

        $els = [
            '<meta property="og:locale" content="' . get_locale() . '" />',
            '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '" />',
            '<meta property="og:title" content="' . esc_attr($product->get_title()) . '" />',
            '<meta property="og:description" content="' . esc_attr($product->get_short_description()) . '" />',
            '<meta property="og:url" content="' . esc_attr($product->get_permalink()) . '" />'
        ];

        if ($attachment_id = $this->product->get_image_id()) {
            $attachment = wp_get_attachment_image_src($attachment_id, 'woocommerce_single');
            if ($attachment) {
                $els[] = '<meta property="og:image" content="' . esc_url($attachment[0]) . '" />';
                $els[] = '<meta property="og:image:width" content="' . (int) $attachment[1] . '" />';
                $els[] = '<meta property="og:image:height" content="' . (int) $attachment[2] . '" />';
            }
        }

        echo "\n\n" . implode("\n", $els) . "\n\n";
    }

    public function get_the_share()
    {
        $url = esc_url($this->product->get_permalink());
        ?>
        <div class="share">
            <p class="share__head">Сохранить проект:</p>
            <div class="share__grid">
                <a href="https://vk.com/share.php?url=<?= $url; ?>" class="share-item ic ic-vk" target="_blank"></a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $url; ?>" class="share-item ic ic-facebook" target="_blank"></a>
                <a href="https://connect.ok.ru/offer?url=<?= $url; ?>" class="share-item ic ic-ok" target="_blank"></a>
                <a href="http://profitquery.com/add-to/pinterest/?url=<?= $url; ?>" class="share-item ic ic-pinterest" target="_blank"></a>
            </div>
        </div>
        <?php
    }

    public function get_the_description()
    {
        if (!$this->product->get_description()) return;
        ?>
        <div class="product__row">
            <div class="container">
                <div class="product__row-title">
                    <h3>Описание проекта</h3>
                </div>
                <div class="product-content box">
                    <div class="content">
                        <?= $this->product->get_description(); ?>
                    </div>
                    <div class="action-box">
                        <a href="#call-popup" data-popup class="btn">Оставить заявку</a>
                        <a href="#feedback-popup" data-popup class="btn btn_bd">Задать вопрос</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    // Блок Вы смотрели
    public function get_the_watched()
    {
        ?>

        <div id="show_watched" class="product__row hidden" data-product_id="<?= $this->product->get_id(); ?>"
             data-cat_id="<?= $this->parent_term->term_id ?>">
            <div class="container">

                <div class="product__row-title">
                    <h3>Вы смотрели</h3>
                </div>

                <div id="slider_watched">
                    <div class="swiper-wrapper"></div>
                    <div class="swiper-nav">
                        <div class="swiper-button-prev"><i class="ic ic-left"></i></div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"><i class="ic ic-right"></i></div>
                    </div>
                </div>

            </div>
        </div>

        <?php
    }
}
