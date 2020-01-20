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
                <?php if (has_nav_menu('footer_menu_1')):
                    wp_nav_menu([
                        'theme_location' => 'footer_menu_1',
                        'menu_id' => 'footer_menu_1',
                        'container' => false,
                        'menu_class' => 'footer__list',
                        'fallback_cb' => '__return_false'
                    ]);
                endif; ?>
            </div>
            <div class="footer__col">
                <?php if (has_nav_menu('footer_menu_2')):
                    wp_nav_menu([
                        'theme_location' => 'footer_menu_2',
                        'menu_id' => 'footer_menu_2',
                        'container' => false,
                        'menu_class' => 'footer__list',
                        'fallback_cb' => '__return_false'
                    ]);
                endif; ?>
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
    <?php include_once 'template-parts/parts/popups/call-popup.php'; ?>
    <?php include_once 'template-parts/parts/popups/feedback-popup.php'; ?>
    <?php include_once 'template-parts/parts/popups/thanks-popup.php'; ?>
</div>

<?php wp_footer(); ?>

</body>

</html>
