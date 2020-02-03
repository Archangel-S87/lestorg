<?php

/*
 * Все настройки темы
 */


class Lestorg_Init
{
    public function __construct()
    {
        add_action('after_setup_theme', [$this, 'setup']);

        // Регистрация контента Акции
        add_action('init', [$this, 'register_offer']);

        // Меняю Запись на Статья
        add_filter('post_type_labels_post', [$this, 'rename_posts_labels']);

        // Разрешения на загрузку типов файлов
        add_filter('upload_mimes', [$this, 'upload_allow_types']);
    }

    public function setup() {
        add_theme_support('html5', [
            'style',
            'comment-list',
            'comment-form',
            'search-form',
            'gallery',
            'caption'
        ]);

        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('align-wide');

        add_theme_support('woocommerce', [
            'thumbnail_image_width' => 380,
            'single_image_width' => 700,
            'product_grid' => [] // Отключено
        ]);

        add_theme_support('custom-logo', [
            'width'       => 230,
            'height'      => 60,
            'flex-width'  => true,
            'flex-height' => true
        ]);

        register_nav_menus([
            'top_header_menu' => 'Верхнее меню',
            'main_header_menu' => 'Главное меню',
            'footer_menu_1' => 'Нижнее меню 1',
            'footer_menu_2' => 'Нижнее меню 2'
        ]);

        //Хак плагина folder
        /*    if (get_option('folder_old_plugin_folder_status') < 500) {
                update_option('folder_old_plugin_folder_status', 500);
            }*/
    }

    public function register_offer()
    {
        register_post_type('offer', [
            'label' => 'Акции',
            'labels' => [
                'name' => 'Акции',
                'singular_name' => 'Акция',
                'add_new' => 'Добавить акцию',
                'add_new_item' => 'Добавление акции',
                'edit_item' => 'Редактирование акции',
                'new_item' => 'Новый акция',
                'view_item' => 'Смотреть акцию',
                'search_items' => 'Искать акцию',
                'not_found' => 'Акция не найден',
                'not_found_in_trash' => 'Акция не найден в корзине',
                'parent_item_colon' => '',
                'menu_name' => 'Акции'
            ],
            'description' => 'Наши акции',
            'public' => true,
            'show_in_menu' => true,
            'show_in_rest' => false,
            'rest_base' => null,
            'menu_position' => 5,
            'menu_icon' => null,
            'hierarchical' => false,
            'supports' => [
                'title',
                'editor'
            ],
            'taxonomies' => [],
            'has_archive' => 'offer',
            'rewrite' => [
                'with_front' => false
            ],
            'query_var' => true
        ]);
    }

    public function rename_posts_labels($labels) {
        return (object) array_merge((array) $labels, [
            'name' => 'Статьи',
            'singular_name' => 'Статья',
            'add_new' => 'Добавить статью',
            'add_new_item' => 'Добавить статью',
            'edit_item' => 'Редактировать статью',
            'new_item' => 'Новая статья',
            'view_item' => 'Просмотреть статью',
            'search_items' => 'Поиск статей',
            'not_found' => 'Статей не найдено.',
            'not_found_in_trash' => 'Статей в корзине не найдено.',
            'parent_item_colon' => '',
            'all_items' => 'Все статьи',
            'archives' => 'Архивы статей',
            'insert_into_item' => 'Вставить в статью',
            'uploaded_to_this_item' => 'Загруженные для этой статьи',
            'featured_image' => 'Миниатюра статьи',
            'filter_items_list' => 'Фильтровать список статей',
            'items_list_navigation' => 'Навигация по списку статей',
            'items_list' => 'Список статей',
            'menu_name' => 'Статьи',
            'name_admin_bar' => 'Статью' // пункте "добавить"
        ]);
    }

    public function upload_allow_types($mimes)
    {
        $mimes['svg']  = 'text/plain';
        return $mimes;
    }
}

$Lestorg_Init = new Lestorg_Init();
