<?php

/*
 * Класс отвечает за вывод контента WooCommerce
 */

class WC_LT_Content
{
    use LT_Instance;

    private $term_id = 0;
    private $template = '';

    protected function __construct()
    {
        $this->hooks();
    }

    private function hooks()
    {
        // Меняю вывод breadcrumbs
        add_filter('woocommerce_breadcrumb_defaults', [$this, 'replace_breadcrumbs_defaults']);
        // Убираю из вывода родительскую категорию
        add_filter('woocommerce_get_breadcrumb', [$this, 'replace_woocommerce_breadcrumbs']);
    }

    /**
     * @param $term_id
     * @return $this
     */
    public function set_term($term_id = 0)
    {
        global $post;

        if (!$term_id) {
            $product = wc_get_product($post);
            if ($product) {
                $cats = $product->get_category_ids();
                $term_id = $cats[0] ?? 0;
            }
        }

        $this->term_id = $term_id;

        return $this;
    }

    /**
     * @return WC_LT_Category_Simple|WC_LT_Category_Tabs|null
     */
    public function get_class_template()
    {
        if (!$this->term_id) {
            $current_term = get_queried_object();
            $this->term_id = $current_term->term_id ?? 0;
        } else {
            $current_term = get_term($this->term_id, 'product_cat');
        }

        $template = get_field('category_template', 'product_cat_' . $this->term_id);

        switch ($template) {
            case 'tabs' :
                $class_template = WC_LT_Category_Tabs::get_instance();
                break;
            case 'sidebar' :
                $class_template = null;
                break;
            default :
                $class_template = WC_LT_Category_Simple::get_instance();
        }

        $this->template = $template ? 'category-' . $template : 'product';

        $class_template->set_term($current_term);

        return $class_template;
    }

    public function woocommerce_content()
    {
        if (is_singular('product')) {

            while (have_posts()) :
                the_post();
                wc_get_template_part('content', 'single-product');
            endwhile;

            return;
        }

        if (is_product_category()) {

            $class_template = $this->get_class_template();
            $class_template->run();

            do_action('woocommerce_before_shop_loop');

            woocommerce_product_loop_start();

            if (wc_get_loop_prop('total')) {
                while (have_posts()) {
                    the_post();
                    wc_get_template_part('content', 'product');
                }
            }

            woocommerce_product_loop_end();

            do_action('woocommerce_after_shop_loop');

            if (!woocommerce_product_loop()) {
                do_action('woocommerce_no_products_found');
            }

            return;
        }

        woocommerce_content();
    }

    public function replace_breadcrumbs_defaults($args)
    {
        return [
            'wrap_before' => '<ul class="breadcrumbs">',
            'wrap_after' => '</ul>',
            'before' => '<li>',
            'after' => '</li>',
            'home' => _x('Home', 'breadcrumb', 'woocommerce'),
        ];
    }

    public function replace_woocommerce_breadcrumbs($breadcrumbs)
    {
        $breadcrumbs[0][0] = '<i class="ic ic-home"></i> Главная';
        if (count($breadcrumbs) > 2) {
            unset($breadcrumbs[1]);
            sort($breadcrumbs);
        }
        return $breadcrumbs;
    }
}

$WC_LT_Content = WC_LT_Content::get_instance();
