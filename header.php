<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <script>
        function lt_get_map_coordinates() {
            <?php $cords = get_option('coordinates_map_pc'); ?>
            let cords = <?= ($cords ? '[' . $cords . ']' : 0); ?>;
            if (window.matchMedia('(max-width: 767px)').matches) {
                <?php $cords = get_option('coordinates_map_mob'); ?>
                let mob = <?= ($cords ? '[' . $cords . ']' : 0); ?>;
                cords = mob ? mob : cords;
            }
            if (cords) return cords;
            return null;
        }
    </script>

    <?php wp_head(); ?>

    <meta name="description" content="<?php bloginfo('description'); ?>">

</head>
<body <?php body_class(); ?>>

<?php
// TODO Исправить вывод меню для мобилки!
?>

<div id="wrapper">
    <div id="wrapper__wrap">

        <div id="wrapper__overlay"></div>

        <div id="wrapper__main">

            <div class="mob-menu">
                <div class="mob-menu__wrap">

                    <div class="mob-header__grid">
                        <button class="mob-header__toggle" data-close></button>
                        <div class="mob-header__logo">
                            <a href="<?= home_url(); ?>" class="logo">
                                <img src="<?= get_theme_file_uri('assets/img/logo.svg'); ?>"
                                     alt="<?php bloginfo('name') ?>">
                            </a>
                        </div>
                        <?php /*
    <a href="#" class="favorite-link"><i class="ic ic-favorite"></i><span>0</span></a>
 */ ?>
                    </div>

                    <?php if (has_nav_menu('main_header_menu')):
                        wp_nav_menu([
                            'theme_location' => 'main_header_menu',
                            'menu_id' => 'mob_main_header_menu',
                            'container' => false,
                            'menu_class' => 'mob-menu__list',
                            'fallback_cb' => '__return_false'
                        ]);
                    endif; ?>

                    <div class="mob-menu__sep"></div>

                    <div class="header__phone">
                        <?php if ($phone = get_option('phone')): ?>
                            <a href="tel:<?= $phone ?>" class="header__phone-link"><?= $phone ?></a><br>
                        <?php endif; ?>
                        <a href="#call-popup" data-popup class="header__phone-call">Заказать звонок</a>
                    </div>

                    <div class="mob-menu__messengers">
                        <p class="mob-menu__messengers-head">Или напишите нам:</p>
                        <div class="messengers messengers_small">
                            <?php print_messengers(); ?>
                        </div>
                    </div>

                </div>
            </div>

            <header class="header">
                <div class="container">

                    <div class="header__top">

                        <?php if (has_nav_menu('top_header_menu')):
                            wp_nav_menu([
                                'theme_location' => 'top_header_menu',
                                'container' => 'nav',
                                'container_class' => 'header__menu',
                                'menu_class' => 'header__menu-list',
                                'fallback_cb' => '__return_false'
                            ]);
                        endif; ?>

                        <div class="header__messengers">
                            <div class="messengers messengers_small">
                                <?php print_messengers(); ?>
                            </div>
                        </div>

                    </div>

                    <div class="header__main">

                        <div class="header__logo">
                            <?php if (has_custom_logo()): ?>
                                <?php the_custom_logo(); ?>
                            <?php else: ?>
                                <a href="<?= home_url(); ?>" class="logo">
                                    <img src="<?= get_theme_file_uri('assets/img/logo.svg'); ?>"
                                         alt="<?php bloginfo('name') ?>">
                                </a>
                            <?php endif; ?>
                        </div>

                        <?php if (has_nav_menu('main_header_menu')):
                            wp_nav_menu([
                                'theme_location' => 'main_header_menu',
                                'menu_id' => 'main_header_menu',
                                'container' => 'nav',
                                'container_class' => 'header__menu',
                                'menu_class' => 'header__menu-list',
                                'fallback_cb' => '__return_false'
                            ]);
                        endif; ?>

                        <?php
                        /*
                        // TODO Добавить избранное

                            <div class="header__favorite">
                            <a href="#" class="favorite-link"><i class="ic ic-favorite"></i><span>0</span></a>
                        </div>
                        */

                        ?>
                        <div class="header__sep"></div>

                        <div class="header__phone">
                            <?php if ($phone = get_option('phone')): ?>
                                <a href="tel:<?= $phone ?>" class="header__phone-link"><?= $phone ?></a><br>
                            <?php endif; ?>
                            <a href="#call-popup" data-popup class="header__phone-call">Заказать звонок</a>
                        </div>

                    </div>
                </div>
            </header>

            <header class="mob-header">
                <div class="mob-header__wrapper">
                    <div class="mob-header__grid">
                        <button class="mob-header__toggle"></button>
                        <div class="mob-header__logo">
                            <a href="<?= home_url(); ?>" class="logo">
                                <img src="<?= get_theme_file_uri('assets/img/logo.svg'); ?>"
                                     alt="<?php bloginfo('name') ?>">
                            </a>
                        </div>
                        <?php if ($phone = get_option('phone')): ?>
                            <a href="tel:<?= $phone ?>" class="mob-header__call ic ic-phone"></a>
                        <?php endif; ?>
                    </div>
                </div>
            </header>
