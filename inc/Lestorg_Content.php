<?php


class Lestorg_Content
{
    use Lestorg_Instance;

    /**
     * @var Lestorg_Loop_Simple | Lestorg_Loop_Main | null
     */
    private $loop_class_template;

    /**
     * @var Lestorg_Single_Simple | Lestorg_Single_Main | null
     */
    private $single_class_template;


    protected function __construct()
    {
        /**
         * Отключаю стили WooCommerce
         */
        remove_action('wp_enqueue_scripts', 'WC_Frontend_Scripts::load_scripts');
        remove_action('wp_print_scripts', 'WC_Frontend_Scripts::localize_printed_scripts', 5);
        remove_action('wp_print_footer_scripts', 'WC_Frontend_Scripts::localize_printed_scripts', 5);

        // Свои стили
        add_action('wp_enqueue_scripts', [$this, 'content_scripts']);

        // Классы для страниц
        add_filter('body_class', [$this, 'change_body_classes']);

        // Изменяем атрибут class у тега li в меню
        add_filter('nav_menu_css_class', [$this, 'filter_nav_menu_css_classes'], 10, 4);

        /*
         * Убираю обёртку контента
         */
        remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper');
        remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end');

        // Меняю вывод breadcrumbs
        add_filter('woocommerce_breadcrumb_defaults', [$this, 'replace_breadcrumbs_defaults']);
        // Убираю из вывода родительскую категорию
        add_filter('woocommerce_get_breadcrumb', [$this, 'replace_woocommerce_breadcrumbs']);

        // Настройка пагинации
        add_filter('next_posts_link_attributes', [$this, 'set_attributes_next_posts_link']);

        // Определяю каой шаблон применить для карточек
        add_action('woocommerce_product_query', [$this, 'loop_product_query'], 10, 2);

        // Определяю шаблон страницы товара
        add_action('wp', [$this, 'define_single_product_template']);
    }

    public function content_scripts()
    {
        $version = wp_get_theme()->get('Version');

        wp_enqueue_style('lestorg-icomoon', get_theme_file_uri('assets/libs/icomoon/style.css'));

        wp_enqueue_style('lestorg-style', get_theme_file_uri('assets/css/main.min.css'), [], $version);

        wp_enqueue_script('lestorg-libs', get_theme_file_uri('assets/js/libs.min.js'), ['jquery'], $version);

        wp_enqueue_script('lestorg-scripts', get_theme_file_uri('assets/js/common.js'), ['lestorg-libs'], $version);

        wp_localize_script('lestorg-scripts', 'lestorg_ajax', ['url' => admin_url('admin-ajax.php')]);
    }

    public function change_body_classes($classes)
    {
        if (is_front_page()) {
            $classes[] = 'page-home';
        }
        if (!is_front_page()) {
            $classes[] = 'page-inner';
        }
        if (is_product()) {
            $classes[] = 'page-product';
        }
        if (is_page(['contacts', 'favorite'])) {
            $classes[] = 'page-contacts';
        }
        if (is_page('production')) {
            $classes[] = 'page-production';
        }
        return $classes;
    }

    public function filter_nav_menu_css_classes($classes, $item, $args, $depth)
    {
        if ($args->theme_location != 'main_header_menu') return $classes;

        if (in_array('menu-item-has-children', $classes)) {
            if ($args->menu_id == 'mob_main_header_menu') {
                $classes[] = 'mob-menu__list-dropdown';
            }
            if ($args->menu_id == 'main_header_menu') {
                $classes[] = 'header__menu-dropdown';
            }
        }

        if ($args->menu_id == 'mob_main_header_menu') {
            if (strripos($item->post_title, 'ic-') !== false) {
                $classes[] = 'mob-menu__list-icon';
            }
        }

        if ($args->menu_id == 'main_header_menu') {
            if (strripos($item->post_title, 'ic-') !== false) {
                $classes[] = 'header__menu-icon';
            }
        }

        return $classes;
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

    public function set_attributes_next_posts_link($attrs)
    {
        return 'class="pagination__more"';
    }


    public function loop_product_query(WP_Query $query, WC_Query $wc_query)
    {
        $class_template = $this->get_loop_class_template();
        $class_template->set_loop($query, $wc_query);
        $class_template->run();
    }

    public function define_single_product_template($wp)
    {
        if (is_singular('product')) {
            global $post;
            $product = wc_get_product($post);
            $class_template = $this->get_single_class_template($product);
            $class_template->run();
        }
    }

    public function set_loop_class_template($class_name)
    {
        if (!class_exists($class_name)) return;
        $this->loop_class_template = call_user_func($class_name . '::get_instance');
    }

    /**
     * @param int $term_id
     * @param WC_Product | int | null $product
     * @return Lestorg_Loop_Simple | Lestorg_Loop_Main | null
     */
    public function get_loop_class_template($term_id = 0, $product = null)
    {
        if (!$term_id) {

            if ($product) {
                $product = wc_get_product($product);
                $cats = $product->get_category_ids();
                $term_id = $cats[0] ?? 0;
            } else {
                $current_term = get_queried_object();
                $term_id = $current_term->term_id ?? 0;
            }

        }

        if (empty($current_term)) {
            $current_term = get_term($term_id, 'product_cat');
        }

        $template = get_field('category_template', 'product_cat_' . $term_id);

        switch ($template) {
            case 'main' :
                require_once 'view/Lestorg_Loop_Main.php';
                $this->loop_class_template = Lestorg_Loop_Main::instance();
                break;
            case 'other' :
                $this->loop_class_template = null;
                break;
            default :
                require_once 'view/Lestorg_Loop_Simple.php';
                $this->loop_class_template = Lestorg_Loop_Simple::instance();
        }

        $this->loop_class_template->set_term($current_term);

        return $this->loop_class_template;
    }

    /**
     * @param WC_Product $product
     * @return Lestorg_Single_Main | Lestorg_Single_Simple | null
     */
    public function get_single_class_template(WC_Product $product)
    {
        $cats = $product->get_category_ids();
        $term_id = $cats[0] ?? 0;

        $parent_cat = get_top_parent_id_product_cat($term_id);
        $parent_cat = get_term($parent_cat, 'product_cat');
        $slug = $parent_cat->slug;

        if (in_array($slug, ['doma', 'bani', 'besedki'])) {
            require_once 'view/Lestorg_Single_Main.php';
            $this->single_class_template = Lestorg_Single_Main::instance();
        } else {
            require_once 'view/Lestorg_Single_Simple.php';
            $this->single_class_template = Lestorg_Single_Simple::instance();
        }

        $this->single_class_template->set_product($product);
        $this->single_class_template->set_parent_term($parent_cat);

        return $this->single_class_template;
    }

    public function woocommerce_content()
    {
        if (is_singular('product')) {

            while (have_posts()) {
                the_post();
                wc_get_template_part('content', 'single-product');
            }

            return;
        }

        if (is_product_category()) {

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
}
