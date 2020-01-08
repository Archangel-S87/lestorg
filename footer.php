<?php ?>

</div><!-- #wrapper__main -->

<footer class="footer">
    <div class="container">
        <div class="footer__grid">
            <div class="footer__col">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php else: ?>
                    <a href="<?= home_url(); ?>" class="logo">
                        <img src="<?= get_theme_file_uri('assets/img/logo.svg'); ?>"
                             alt="<?php bloginfo('name') ?>">
                    </a>
                <?php endif; ?>
                <p class="footer__policy"><a href="#">Политика конфедициальности</a></p>
                <div class="messengers">
                    <?php print_messengers(); ?>
                </div>
            </div>
            <div class="footer__col">
                <ul class="footer__list">
                    <li><a href="#">Дома</a></li>
                    <li><a href="#">Бани</a></li>
                    <li><a href="#">Другие товары</a></li>
                    <li><a href="#">Услуги</a></li>
                    <li><a href="#">Калькулятор проекта</a></li>
                </ul>
            </div>
            <div class="footer__col">
                <ul class="footer__list">
                    <li><a href="#">Наши работы</a></li>
                    <li><a href="#">Акции</a></li>
                    <li><a href="#">О нас</a></li>
                    <li><a href="#">Контакты</a></li>
                </ul>
                <div class="social">
                    <?php print_socials(); ?>
                </div>
            </div>
            <div class="footer__col">
                <div class="footer__phone">
                    <?php if ($phone = get_option('phone')): ?>
                        <a href="tel:<?= $phone ?>" class="footer__phone-link"><?= $phone ?></a><br>
                    <?php endif; ?>
                    <a href="#call-popup" data-popup class="footer__phone-call">Заказать звонок</a>
                </div>
                <div class="footer__contacts">
                    <?php if ($address = get_option('address')): ?>
                        <p class="foot-contact">
                            <i class="ic ic-mark"></i>
                            <?= $address; ?>
                        </p>
                    <?php endif; ?>
                    <?php if ($email = get_option('email')): ?>
                        <p class="foot-contact">
                            <i class="ic ic-mail"></i>
                            <a href="mailto:<?= $email; ?>"><?= $email; ?></a>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <p class="footer__dev">Разработка сайта: <a href="http://www.minkov-marketing.by/" target="_blank">Minkov Marketing Company</a></p>
    </div>
</footer>

</div><!-- #wrapper__wrap -->
</div><!-- #wrapper -->

<div class="hidden">
    <div id="call-popup" class="call-popup popup box">
        <form class="form-box form">
            <div class="form-box__title">
                <h5>Специалист свяжется с вами в течении <span class="text-green">30 минут</span></h5>
            </div>
            <div class="form-box__subtitle">
                <p>Оставьте свои контакты, мы перезвоним:</p>
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
                <button class="btn btn_button">Заказать звонок</button>
                <label class="form-checkbox">
                    <input type="checkbox" checked>
                    <span>Я принимаю условия <a href="#">передачи информации</a></span>
                </label>
            </div>
        </form>
    </div>
    <div id="feedback-popup" class="feedback-popup popup box">
        <form class="form-box form">
            <div class="form-box__title">
                <h5>Есть дополнительные вопросы?</h5>
            </div>
            <div class="form-box__subtitle">
                <p>Оставьте свои контакты, мы перезвоним:</p>
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
                <button class="btn btn_button">Заказать звонок</button>
                <label class="form-checkbox">
                    <input type="checkbox" checked>
                    <span>Я принимаю условия <a href="#">передачи информации</a></span>
                </label>
            </div>
        </form>
    </div>
</div>

<?php wp_footer(); ?>

</body>

</html>
