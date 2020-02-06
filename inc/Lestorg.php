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
        require_once LT_PATCH . '/acf/Lestorg_Acf_Options.php';
        require_once LT_PATCH . '/acf/Lestorg_Acf_Category_Product.php';
        require_once LT_PATCH . '/acf/Lestorg_Acf_Offers.php';
        require_once LT_PATCH . '/acf/Lestorg_Acf_Product_Variations.php';

        // Admin
        require_once LT_PATCH . '/inc/admin/meta-boxes/class-lestorg-wc-meta-box-product-data.php';
        require_once LT_PATCH . '/inc/Lestorg_Admin.php';

        // Content
        require_once LT_PATCH . '/inc/Lestorg_Content.php';

        // Ajax
        require_once LT_PATCH . '/ajax/Lestorg_Ajax_Mailer.php';
        require_once LT_PATCH . '/ajax/Lestorg_Ajax_Favorites.php';
        require_once LT_PATCH . '/ajax/Lestorg_Ajax_Watched.php';

        $this->content = Lestorg_Content::instance();
    }
}
