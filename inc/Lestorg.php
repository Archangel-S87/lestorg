<?php

/*
 * Основной класс темы
 */

include_once 'Lestorg_Instance.php';


class Lestorg
{
    use Lestorg_Instance;

    /**
     * Основной класс контента
     *
     * @var Lestorg_Content
     */
    public $content;

    protected function __construct()
    {
        if (empty(WC_ABSPATH) || !function_exists('acf_add_local_field_group')) return;

        // Init
        require_once LT_PATCH . '/inc/Lestorg_Init.php';

        // Acf
        require_once LT_PATCH . '/acf/Lestorg_Acf_Category_Product.php';
        require_once LT_PATCH . '/acf/Lestorg_Acf_Offers.php';
        require_once LT_PATCH . '/acf/Lestorg_Acf_Product_Variations.php';

        // Admin
        require_once LT_PATCH . '/inc/Lestorg_Admin.php';

        // Content
        require_once LT_PATCH . '/inc/Lestorg_Content.php';

        // Ajax
        require_once LT_PATCH . '/ajax/Lestorg_Ajax_Mailer.php';
        require_once LT_PATCH . '/ajax/Lestorg_Ajax_Favorites.php';

        // Customizer
        add_action('customize_register', [$this, 'init_customizer']);

        $this->content = Lestorg_Content::instance();
    }

    public function init_customizer(WP_Customize_Manager $wp_customize) {
        require_once LT_PATCH . '/libs/cody-framework/admin.php';
        require_once LT_PATCH . '/inc/Lestorg_Customizer.php';
        cody_framework_include($wp_customize);
        new Lestorg_Customizer($wp_customize);
    }
}
