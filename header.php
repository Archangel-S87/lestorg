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
                        <a href="#" class="favorite-link"><i class="ic ic-favorite"></i><span>0</span></a>
                    </div>

                    <ul class="mob-menu__list">
                        <li class="mob-menu__list-dropdown">
                            <a href="#">Дома</a>
                            <ul>
                                <li><a href="#">Дома из профилированного бруса</a></li>
                                <li><a href="#">Дома из клееного бруса</a></li>
                                <li><a href="#">Дома из оцилиндрованного бревна</a></li>
                                <li><a href="#">Каркасные дома</a></li>
                            </ul>
                        </li>
                        <li class="mob-menu__list-dropdown">
                            <a href="#">Бани</a>
                            <ul>
                                <li><a href="#">Пункт 1</a></li>
                                <li><a href="#">Пункт 2</a></li>
                                <li><a href="#">Пункт 3</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Интерьеры и материалы</a></li>
                        <li><a href="#">Услуги</a></li>
                        <li class="mob-menu__list-icon">
                            <a href="#">
                                <i class="ic ic-calculate"></i>
                                Калькулятор проекта
                            </a>
                        </li>
                        <li><a href="#">О нас</a></li>
                        <li><a href="#">Наши работы</a></li>
                        <li><a href="#">Акции</a></li>
                        <li><a href="#">Статьи</a></li>
                        <li><a href="#">Контакты</a></li>
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
                                'container' => 'nav',
                                'container_class' => 'header__menu',
                                'menu_class' => 'header__menu-list',
                                'fallback_cb' => '__return_false'
                            ]);
                        endif; ?>
                        
<!--                        <nav class="header__menu">
                            <ul class="header__menu-list">
                                <li class="header__menu-dropdown">
                                    <a href="#">Дома</a>
                                    <ul>
                                        <li><a href="#">Дома из профилированного бруса</a></li>
                                        <li><a href="#">Дома из клееного бруса</a></li>
                                        <li><a href="#">Дома из оцилиндрованного бревна</a></li>
                                        <li><a href="#">Каркасные дома</a></li>
                                    </ul>
                                </li>
                                <li class="header__menu-dropdown">
                                    <a href="#">Бани</a>
                                    <ul>
                                        <li><a href="#">Пункт 1</a></li>
                                        <li><a href="#">Пункт 2</a></li>
                                        <li><a href="#">Пункт 3</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Интерьеры<br>и материалы</a></li>
                                <li><a href="#">Услуги</a></li>
                                <li class="header__menu-icon">
                                    <a href="#">
                                        <i class="ic ic-calculate"></i>
                                        Калькулятор<br>проекта
                                    </a>
                                </li>
                            </ul>
                        </nav>-->

                        <div class="header__favorite">
                            <a href="#" class="favorite-link"><i class="ic ic-favorite"></i><span>0</span></a>
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
