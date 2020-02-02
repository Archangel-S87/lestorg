<?php get_header(); ?>

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

print_main_map();

print_feedback();

get_footer();
