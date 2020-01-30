<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <?php wp_head(); ?>

    <meta name="description" content="<?php bloginfo('description'); ?>">

</head>
<body <?php body_class(); ?>>

<?php

$count_favorite = count(WC()->cart->get_cart());
$classes_favorite = $count_favorite ? 'favorite-link active' : 'favorite-link';

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
                        <a href="<?= home_url('favorite'); ?>" class="<?= $classes_favorite; ?>" title="Избранное">
                            <i class="ic ic-favorite"></i>
                            <span><?= $count_favorite; ?></span>
                        </a>
                    </div>

                    <ul class="mob-menu__list">

                    <?php
                    if (has_nav_menu('main_header_menu')) :
                        wp_nav_menu([
                            'theme_location' => 'main_header_menu',
                            'menu_id' => 'mob_main_header_menu',
                            'container' => false,
                            'items_wrap' => '%3$s',
                            'fallback_cb' => '__return_false'
                        ]);
                    endif;

                    if (has_nav_menu('top_header_menu')) :
                        wp_nav_menu([
                            'theme_location' => 'top_header_menu',
                            'menu_id' => 'mob_top_header_menu',
                            'container' => false,
                            'items_wrap' => '%3$s',
                            'fallback_cb' => '__return_false'
                        ]);
                    endif;
                    ?>

                    </ul>

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

                        <div class="header__favorite">
                            <a href="<?= home_url('favorite'); ?>" class="<?= $classes_favorite; ?>" title="Избранное">
                                <i class="ic ic-favorite"></i>
                                <span><?= $count_favorite; ?></span>
                            </a>
                        </div>

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
