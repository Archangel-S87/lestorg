<?php

/*
Template Name: Контакты
Template Post Type: page
*/

// TODO Шаблон Контакты добавить время работы

get_header();

?>

<div class="contacts s-inner">
    <div class="container">

        <ul class="breadcrumbs">
            <li><a href="<?= home_url(); ?>" class="breadcrumbs__home"><i class="ic ic-home"></i> Главная</a></li>
            <li>Контакты</li>
        </ul>

        <div class="title-inn">
            <h2>Контакты</h2>
        </div>

        <div class="contacts-box box">
            <div class="contacts-box__wrapper">
                <div class="contacts-box__wrap">

                    <?php if ($phone = get_option('phone')): ?>
                        <div class="contact-item">
                            <i class="contact-item__icon text-gradient ic ic-phone"></i>
                            <p class="contact-item__head">Телефон</p>
                            <p><a href="tel:<?= $phone ?>"><?= $phone ?></a></p>
                        </div>
                    <?php endif; ?>

                    <?php if ($address = get_option('address')): ?>
                        <div class="contact-item">
                            <i class="contact-item__icon text-gradient ic ic-mark"></i>
                            <p class="contact-item__head">Адрес</p>
                            <p><?= $address; ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="contact-item">
                        <i class="contact-item__icon text-gradient ic ic-clock"></i>
                        <p class="contact-item__head">Режим работы</p>
                        <p>Пн. – Пт.: с 09:00 до 18:00</p>
                        <p>Cб. – Вс.: по записи</p>
                    </div>

                    <?php if ($email = get_option('email')): ?>
                        <div class="contact-item">
                            <i class="contact-item__icon text-gradient ic ic-mail"></i>
                            <p class="contact-item__head">Почта</p>
                            <p><a href="mailto:<?= $email; ?>"><?= $email; ?></a></p>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

    </div>
</div>

<?php
/*
<section class="main-map">
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
</section>
*/
?>

<?php print_feedback(); ?>
<?php get_footer(); ?>
