<?php

require_once 'class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'lestorg_register_required_plugins');

function lestorg_register_required_plugins()
{
    $plugins = [
        [
            'name' => 'WooCommerce',
            'slug' => 'woocommerce',
            'required' => true,
            'force_activation' => true
        ],
        [
            'name' => 'Cyr-To-Lat',
            'slug' => 'cyr2lat',
            'required' => true,
            'force_activation' => true
        ],
        [
            'name' => 'Advanced Custom Fields PRO',
            'slug' => 'advanced-custom-fields-pro',
            'source' => get_template_directory() . '/libs/tgm/plugins/advanced-custom-fields-pro.zip',
            'required' => true,
            'version' => '5.8.7',
            'force_activation' => true,
            'force_deactivation' => false
        ],
        [
            'name' => 'Advanced Custom Fields: Атрибуты товара WooCommerce',
            'slug' => 'acf-product-attributes',
            'source' => get_template_directory() . '/libs/tgm/plugins/acf-product-attributes.zip',
            'required' => true,
            'version' => '1.0.0',
            'force_activation' => true,
            'force_deactivation' => false
        ],
        [
            'name' => 'Folders',
            'slug' => 'folders',
            'required' => true,
            'force_activation' => true
        ],
        [
            'name' => 'PublishPress Capabilities',
            'slug' => 'capability-manager-enhanced',
            'required' => true,
            'force_activation' => true
        ]
    ];

    $config = [
        'id' => 'lestorg',
        'default_path' => '',
        'menu' => 'tgmpa-install-plugins',
        'parent_slug' => 'themes.php',
        'capability' => 'edit_theme_options',
        'has_notices' => true,
        'dismissable' => true,
        'dismiss_msg' => '',
        'is_automatic' => false,
        'message' => ''
    ];

    tgmpa($plugins, $config);
}
