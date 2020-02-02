<?php get_header(); ?>

<?php the_post(); ?>

<div class="banner">
    <div class="container">
        <div class="banner__content">
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </div>
        <div class="banner__action">
            <a href="<?= home_url('quiz'); ?>" class="btn btn_big">Подобрать проект за 6 шагов</a>
            <p class="banner__action-descr">Ответьте на 6 вопросов и узнайте какой тип дома подойдет именно вам</p>
        </div>
    </div>
</div>

<?php print_popular_project(); ?>

<div class="advantages">
    <div class="container">
        <div class="title">
            <h2>Почему работать с нами <span class="text-green">выгодно</span>?</h2>
        </div>
        <div class="advantages__grid">

            <div class="advantage">
                <div class="advantage__img">
                    <div class="img-box">
                        <img src="<?= get_img('img/advantages/advant-1.png'); ?>" alt="">
                    </div>
                </div>
                <p class="advantage__text">Свои делянки леса. <br><b>Материал дешевле</b>, чем в магазине</p>
            </div>
            <div class="advantage">
                <div class="advantage__img">
                    <div class="img-box">
                        <img src="<?= get_img('img/advantages/advant-2.png'); ?>" alt="">
                    </div>
                </div>
                <p class="advantage__text"><b>Собственное производство</b>. <br>Подготавливаем и обрабатываем пиломатериалы</p>
            </div>
            <div class="advantage">
                <div class="advantage__img">
                    <div class="img-box">
                        <img src="<?= get_img('img/advantages/advant-3.png'); ?>" alt="">
                    </div>
                </div>
                <p class="advantage__text">Работаем <b>под ключ</b>. <br>От фундамента до чистовой отделки</p>
            </div>
            <div class="advantage">
                <div class="advantage__img">
                    <div class="img-box">
                        <img src="<?= get_img('img/advantages/advant-4.png'); ?>" alt="">
                    </div>
                </div>
                <p class="advantage__text">В бригадах работают квалифицированные <b>специалисты</b></p>
            </div>
            <div class="advantage">
                <div class="advantage__img">
                    <div class="img-box">
                        <img src="<?= get_img('img/advantages/advant-5.png'); ?>" alt="">
                    </div>
                </div>
                <p class="advantage__text"><b>Столярный цех</b> - производство мебели из массива дерева</p>
            </div>
            <div class="advantage">
                <div class="advantage__img">
                    <div class="img-box">
                        <img src="<?= get_img('img/advantages/advant-6.png'); ?>" alt="">
                    </div>
                </div>
                <p class="advantage__text">Соблюдаем заявленные <b>сроки</b></p>
            </div>

        </div>
    </div>
</div>

<div class="services overlay-bottom">
    <div class="container">
        <div class="title">
            <h2>мы строим</h2>
        </div>
        <div class="services__grid">

            <div class="services__col" data-medium>
                <div class="service box">
                    <img src="<?= get_img('img/services/service-1.jpg'); ?>" alt="" class="service__img">
                    <div class="service__content">
                        <h3 class="service__head">Дома из бруса</h3>
                        <?php if ($term = get_term_by('slug', 'doma-iz-profilirovannogo-brusa', 'product_cat')) : ?>
                            <a href="<?= get_term_link($term) ?>" class="more-link">Подробнее</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="services__col" data-medium>
                <div class="service box">
                    <img src="<?= get_img('img/services/service-2.jpg'); ?>" alt="" class="service__img">
                    <div class="service__content">
                        <h3 class="service__head">Дома из бревна</h3>
                        <?php if ($term = get_term_by('slug', 'doma-iz-oczilindrovannogo-brevna', 'product_cat')) : ?>
                            <a href="<?= get_term_link($term) ?>" class="more-link">Подробнее</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="services__col">
                <div class="service box">
                    <img src="<?= get_img('img/services/service-3.jpg'); ?>" alt="" class="service__img">
                    <div class="service__content">
                        <h3 class="service__head">Дома из клееного бруса</h3>
                        <?php if ($term = get_term_by('slug', 'doma-iz-kleenogo-brusa', 'product_cat')) : ?>
                            <a href="<?= get_term_link($term) ?>" class="more-link">Подробнее</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="services__col">
                <div class="service box">
                    <img src="<?= get_img('img/services/service-4.jpg'); ?>" alt="" class="service__img">
                    <div class="service__content">
                        <h3 class="service__head">Бани</h3>
                        <?php if ($term = get_term_by('slug', 'bani', 'product_cat')) : ?>
                            <a href="<?= get_term_link($term) ?>" class="more-link">Подробнее</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="services__col">
                <div class="service box">
                    <img src="<?= get_img('img/services/service-5.jpg'); ?>" alt="" class="service__img">
                    <div class="service__content">
                        <h3 class="service__head">беседки</h3>
                        <?php if ($term = get_term_by('slug', 'besedki', 'product_cat')) : ?>
                            <a href="<?= get_term_link($term) ?>" class="more-link">Подробнее</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php print_company_in_numbers(); ?>

<div class="other-services overlay-bottom">
    <div class="container">
        <div class="title">
            <h2>другие наши услуги</h2>
        </div>
        <div class="other-services__wrapper">

            <div class="other-services__slider swiper-container">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="other-service box">
                            <div class="other-service__top">
                                <h5 class="other-service__head">Фундамент</h5>
                                <p class="other-service__step"></p>
                            </div>
                            <div class="other-service__content">
                                <p>Очень важно подойти к данному вопросу со всей ответственностью, для того чтобы потом не столкнуться с печальными последствиями, многие из которых потом не возможно исправить. Кроме этого, выбор фундамента должен быть не
                                    случайным, а тщательно спланированным, так как это достаточно большая статья расходов при строительстве дома, бани. <br>"Закапывать деньги" в землю, причем немалые, врятли кому то захочется.</p>
                            </div>
                            <div class="other-more-link">
                                <a href="#" class="more-link">Подробнее</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="other-service box">
                            <div class="other-service__top">
                                <h5 class="other-service__head">Очень длинное название</h5>
                                <p class="other-service__step"></p>
                            </div>
                            <div class="other-service__content">
                                <p>Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты. Проектах безорфографичный последний залетают, lorem переписали предложения строчка пояс снова обеспечивает домах текстами которое вдали
                                    силуэт? Он дорогу, щеке подпоясал текста запятых инициал.</p>
                            </div>
                            <div class="other-more-link">
                                <a href="#" class="more-link">Подробнее</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="other-service box">
                            <div class="other-service__top">
                                <h5 class="other-service__head">Фундамент</h5>
                                <p class="other-service__step"></p>
                            </div>
                            <div class="other-service__content">
                                <p>Очень важно подойти к данному вопросу со всей ответственностью, для того чтобы потом не столкнуться с печальными последствиями, многие из которых потом не возможно исправить. Кроме этого, выбор фундамента должен быть не
                                    случайным, а тщательно спланированным, так как это достаточно большая статья расходов при строительстве дома, бани. <br>"Закапывать деньги" в землю, причем немалые, врятли кому то захочется.</p>
                            </div>
                            <div class="other-more-link">
                                <a href="#" class="more-link">Подробнее</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="other-service box">
                            <div class="other-service__top">
                                <h5 class="other-service__head">Очень длинное название</h5>
                                <p class="other-service__step"></p>
                            </div>
                            <div class="other-service__content">
                                <p>Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты. Проектах безорфографичный последний залетают, lorem переписали предложения строчка пояс снова обеспечивает домах текстами которое вдали
                                    силуэт? Он дорогу, щеке подпоясал текста запятых инициал.</p>
                            </div>
                            <div class="other-more-link">
                                <a href="#" class="more-link">Подробнее</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="other-service box">
                            <div class="other-service__top">
                                <h5 class="other-service__head">Фундамент</h5>
                                <p class="other-service__step"></p>
                            </div>
                            <div class="other-service__content">
                                <p>Очень важно подойти к данному вопросу со всей ответственностью, для того чтобы потом не столкнуться с печальными последствиями, многие из которых потом не возможно исправить. Кроме этого, выбор фундамента должен быть не
                                    случайным, а тщательно спланированным, так как это достаточно большая статья расходов при строительстве дома, бани. <br>"Закапывать деньги" в землю, причем немалые, врятли кому то захочется.</p>
                            </div>
                            <div class="other-more-link">
                                <a href="#" class="more-link">Подробнее</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="other-service box">
                            <div class="other-service__top">
                                <h5 class="other-service__head">Очень длинное название</h5>
                                <p class="other-service__step"></p>
                            </div>
                            <div class="other-service__content">
                                <p>Далеко-далеко за словесными горами в стране, гласных и согласных живут рыбные тексты. Проектах безорфографичный последний залетают, lorem переписали предложения строчка пояс снова обеспечивает домах текстами которое вдали
                                    силуэт? Он дорогу, щеке подпоясал текста запятых инициал.</p>
                            </div>
                            <div class="other-more-link">
                                <a href="#" class="more-link">Подробнее</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"><i class="ic ic-left"></i></div>
                <div class="swiper-button-next"><i class="ic ic-right"></i></div>
            </div>

            <div class="other-services__house">
                <img src="<?= get_img('img/other-services/house.png'); ?>" alt="" class="other-services__house-img">
                <ul class="other-services__house-list">
                    <li style="top: 75%; left: 52%;">1</li>
                    <li style="top: 63%; left: 39%;">2</li>
                    <li style="top: 25%; left: 42%;">3</li>
                    <li style="top: 21%; left: 66%;">4</li>
                    <li style="top: 54%; left: 55%;">5</li>
                    <li style="top: 50%; left: 24.5%;">6</li>
                </ul>
            </div>

        </div>
    </div>
</div>

<?php print_cases(); ?>

<div class="home-bg-1 overlay-bottom">

 <div class="offers">
    <div class="container">
        <div class="offers-slider swiper-container">
            <div class="swiper-wrapper">
                <?php $offers = get_posts(['post_type' => 'offer', 'numberposts' => -1]); ?>
                <?php foreach ($offers as $post) : ?>
                    <?php setup_postdata($post); ?>
                    <div class="swiper-slide">
                        <?php get_template_part('template-parts/parts/loop', 'offer'); ?>
                    </div>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
            </div>
            <div class="swiper-nav">
                <div class="swiper-button-prev"><i class="ic ic-left"></i></div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"><i class="ic ic-right"></i></div>
            </div>
        </div>
    </div>
</div>

<!--    <section class="reviews">
        <div class="container">
            <div class="title">
                <h2>Отзывы клиентов</h2>
            </div>
        </div>

        <div class="reviews-slider swiper-container">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <a href="https://www.youtube.com/watch?v=1Z9pnRRLPfE" data-popup="iframe" class="video-box" style="background-image: url('img/reviews/review-1.jpg');"></a>
                </div>
                <div class="swiper-slide">
                    <a href="https://www.youtube.com/watch?v=1Z9pnRRLPfE" data-popup="iframe" class="video-box" style="background-image: url('img/reviews/review-1.jpg');"></a>
                </div>
                <div class="swiper-slide">
                    <a href="https://www.youtube.com/watch?v=1Z9pnRRLPfE" data-popup="iframe" class="video-box" style="background-image: url('img/reviews/review-1.jpg');"></a>
                </div>

            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"><i class="ic ic-left"></i></div>
            <div class="swiper-button-next"><i class="ic ic-right"></i></div>
        </div>
    </section>-->

</div>

<?php

print_main_map();

print_feedback();

get_footer();
