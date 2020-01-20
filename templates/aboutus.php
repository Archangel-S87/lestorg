<?php

/*
Template Name: О нас
Template Post Type: page
*/

get_header();

the_post();

// TODO Обновить шаблон О Нас

?>

    <div class="about s-inner">
        <div class="container">

            <ul class="breadcrumbs">
                <li><a href="<?= home_url(); ?>" class="breadcrumbs__home"><i class="ic ic-home"></i> Главная</a></li>
                <li>О нас</li>
            </ul>

            <div class="title-inn">
                <h2><?php the_title(); ?></h2>
            </div>

            <div class="about-box box">
                <div class="about-box__wrapper">
                    <div class="about-box__wrap">
                        <img src="<?= get_img('img/logo.svg'); ?>" alt="" class="about-box__logo">
                    </div>
                </div>
                <img src="<?= get_img('img/about/about-img.png'); ?>" alt="" class="about-box__img">
            </div>

        </div>
    </div>

    <div class="numbers numbers_about">
        <div class="container">
            <div class="title">
                <h2>Наша компания в цифрах</h2>
            </div>
            <div class="numbers__grid">
                <div class="numbers__col">
                    <div class="number-item">
                        <p class="number-item__main"><span>50</span></p>
                        <p class="number-item__descr">мастеров</p>
                    </div>
                </div>
                <div class="numbers__col">
                    <div class="number-item">
                        <p class="number-item__main"><span>5164</span></p>
                        <p class="number-item__descr">проектов</p>
                    </div>
                </div>
                <div class="numbers__col">
                    <div class="number-item">
                        <p class="number-item__main"><span>100</span><span>м²<br>тыс</span></p>
                        <p class="number-item__descr">произ-во</p>
                    </div>
                </div>
                <div class="numbers__col">
                    <div class="number-item">
                        <p class="number-item__main"><span>100</span><span>га<br>тыс</span></p>
                        <p class="number-item__descr">делянок леса</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="about-content">
        <div class="container">
            <div class="about-content__grid">
                <div class="about-content__img box">
                    <div class="about-content__img-wrap">
                        <div class="title">
                            <h2>Собственное производство</h2>
                        </div>
                    </div>
                </div>
                <div class="about-content__wrap">
                    <div class="title">
                        <h2>о компании</h2>
                    </div>
                    <div class="content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
/*
<div class="main-map">
        <div class="container">
            <div class="title">
                <h2>Карта выполненных проектов</h2>
            </div>
        </div>
        <div class="main-map__wrapper">

            <div id="js-main-map" class="main-map__map"></div>
            <script>
                var mainMapPoints = [{
                    coord: [56.34325900455667, 44.035097843539496],
                    head: 'Ястреб 45',
                    link: '/case.html'
                },
                    {
                        coord: [56.29747090529711, 44.004885441195746],
                        head: 'Ястреб 45',
                        link: '/case.html'
                    },
                    {
                        coord: [56.342877664857554, 43.92592120779731],
                        head: 'Ястреб 45',
                        link: '/case.html'
                    },
                    {
                        coord: [56.32545748347558, 44.07774520534666],
                        head: 'Ястреб 45',
                        link: '/case.html'
                    },
                    {
                        coord: [56.32698351863247, 43.854585415307604],
                        head: 'Ястреб 45',
                        link: '/case.html'
                    },
                ];
            </script>

            <div class="main-map__wrap">
                <div class="container">
                    <div class="main-map__box">
                        <form class="form-box form box">
                            <div class="form-box__title">
                                <h5>Еще сомневаетесь?</h5>
                                <p>Мы очень открытые, поэтому приглашаем вас на экскурсию на наше производство, строящиеся или готовые объекты</p>
                            </div>
                            <div class="form-box__subtitle">
                                <p>Заполните форму, чтобы записаться на экскурсию</p>
                            </div>
                            <div class="form-item">
                                <i class="form-item__icon ic ic-user"></i>
                                <input type="text" class="form-field" placeholder="Введите Ваше имя" required>
                            </div>
                            <div class="form-item">
                                <i class="form-item__icon ic ic-phone"></i>
                                <input type="tel" class="form-field" placeholder="Введите Ваш телефон" required>
                            </div>
                            <div class="form-action">
                                <button class="btn btn_button">Записаться на экскурсию</button>
                                <label class="form-checkbox">
                                    <input type="checkbox" checked>
                                    <span>Я принимаю условия <a href="#">передачи информации</a></span>
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
*/
?>

<?php

print_feedback();

get_footer();
