<?php get_header(); ?>

<?php the_post(); ?>

<section class="banner">
    <div class="container">
        <div class="banner__content">
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </div>
        <div class="banner__action">
            <a href="#" class="btn btn_big">Подобрать проект за 6 шагов</a>
            <p class="banner__action-descr">Ответьте на 6 вопросов и узнайте какой тип дома подойдет именно вам</p>
        </div>
    </div>
</section>

<!--<section class="popular">
    <div class="container">
        <div class="title">
            <h2>Популярные проекты</h2>
        </div>
        <div class="tabs">
            <button class="tabs__toggle">
                <span class="tabs__toggle-text">Выбрать</span>
                <i class="tabs__toggle-icon ic ic-bottom"></i>
            </button>
            <div class="tabs__grid">
                <a href="#" class="tabs__item active">Дома из блоков</a>
                <a href="#" class="tabs__item">Дома из бруса</a>
                <a href="#" class="tabs__item">Каркасные</a>
                <a href="#" class="tabs__item">Бани</a>
            </div>
        </div>
        <div class="catalog-slider swiper-container">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <a href="#" class="catalog-item box">
                        <img src="img/catalog/catalog-1.jpg" alt="" class="catalog-item__img">
                        <div class="catalog-item__main">
                            <div class="catalog-item__top">
                                <h5 class="catalog-item__head">Калипсо</h5>
                                <p class="catalog-item__cat">Дом из блоков</p>
                            </div>
                            <p class="catalog-item__square"><strong>153 м<sup>2</sup></strong> площадь объекта</p>
                            <div class="catalog-item__info">
                                <p class="catalog-item__info-item"><i class="ic ic-bed"></i><b>4</b> комнаты</p>
                                <p class="catalog-item__info-item"><i class="ic ic-bath"></i><b>2</b> санузла</p>
                            </div>
                            <ul class="catalog-item__list">
                                <li>Срок стоительства: <b>5 мес.</b></li>
                            </ul>
                            <p class="catalog-item__price">от 4 120 000 ₽</p>
                        </div>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="catalog-item box">
                        <img src="img/catalog/catalog-1.jpg" alt="" class="catalog-item__img">
                        <div class="catalog-item__main">
                            <div class="catalog-item__top">
                                <h5 class="catalog-item__head">Оберон</h5>
                                <p class="catalog-item__cat">Дом из блоков</p>
                            </div>
                            <p class="catalog-item__square"><strong>153 м<sup>2</sup></strong> площадь объекта</p>
                            <div class="catalog-item__info">
                                <p class="catalog-item__info-item"><i class="ic ic-bed"></i><b>4</b> комнаты</p>
                                <p class="catalog-item__info-item"><i class="ic ic-bath"></i><b>2</b> санузла</p>
                            </div>
                            <ul class="catalog-item__list">
                                <li>Срок стоительства: <b>5 мес.</b></li>
                            </ul>
                            <p class="catalog-item__price">от 4 120 000 ₽</p>
                        </div>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="catalog-item box">
                        <img src="img/catalog/catalog-1.jpg" alt="" class="catalog-item__img">
                        <div class="catalog-item__main">
                            <div class="catalog-item__top">
                                <h5 class="catalog-item__head">скандинавия</h5>
                                <p class="catalog-item__cat">Дом из блоков</p>
                            </div>
                            <p class="catalog-item__square"><strong>153 м<sup>2</sup></strong> площадь объекта</p>
                            <div class="catalog-item__info">
                                <p class="catalog-item__info-item"><i class="ic ic-bed"></i><b>4</b> комнаты</p>
                                <p class="catalog-item__info-item"><i class="ic ic-bath"></i><b>2</b> санузла</p>
                            </div>
                            <ul class="catalog-item__list">
                                <li>Срок стоительства: <b>5 мес.</b></li>
                            </ul>
                            <p class="catalog-item__price">от 4 120 000 ₽</p>
                        </div>
                    </a>
                </div>

            </div>
            <div class="swiper-nav">
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <div class="action-box">
            <a href="#" class="btn btn_bd btn_more">Смотреть все проекты</a>
        </div>
    </div>
</section>-->

<!--<section class="advantages">
    <div class="container">
        <div class="title">
            <h2>Почему работать с нами <span class="text-green">выгодно</span>?</h2>
        </div>
        <div class="advantages__grid">

            <div class="advantage">
                <div class="advantage__img">
                    <div class="img-box">
                        <img src="img/advantages/advant-1.png" alt="">
                    </div>
                </div>
                <p class="advantage__text">Свои делянки леса. <br><b>Материал дешевле</b>, чем в магазине</p>
            </div>
            <div class="advantage">
                <div class="advantage__img">
                    <div class="img-box">
                        <img src="img/advantages/advant-2.png" alt="">
                    </div>
                </div>
                <p class="advantage__text"><b>Собственное производство</b>. <br>Подготавливаем и обрабатываем пиломатериалы</p>
            </div>
            <div class="advantage">
                <div class="advantage__img">
                    <div class="img-box">
                        <img src="img/advantages/advant-3.png" alt="">
                    </div>
                </div>
                <p class="advantage__text">Работаем <b>под ключ</b>. <br>От фундамента до чистовой отделки</p>
            </div>
            <div class="advantage">
                <div class="advantage__img">
                    <div class="img-box">
                        <img src="img/advantages/advant-4.png" alt="">
                    </div>
                </div>
                <p class="advantage__text">В бригадах работают квалифицированные <b>специалисты</b></p>
            </div>
            <div class="advantage">
                <div class="advantage__img">
                    <div class="img-box">
                        <img src="img/advantages/advant-5.png" alt="">
                    </div>
                </div>
                <p class="advantage__text"><b>Столярный цех</b> - производство мебели из массива дерева</p>
            </div>
            <div class="advantage">
                <div class="advantage__img">
                    <div class="img-box">
                        <img src="img/advantages/advant-6.png" alt="">
                    </div>
                </div>
                <p class="advantage__text">Соблюдаем заявленные <b>сроки</b></p>
            </div>

        </div>
    </div>
</section>-->

<!--<section class="services overlay-bottom">
    <div class="container">
        <div class="title">
            <h2>мы строим</h2>
        </div>
        <div class="services__grid">

            <div class="services__col" data-medium>
                <div class="service box">
                    <img src="img/services/service-1.jpg" alt="" class="service__img">
                    <div class="service__content">
                        <h3 class="service__head">Дома из бруса</h3>
                        <a href="#" class="more-link">Подробнее</a>
                    </div>
                </div>
            </div>
            <div class="services__col" data-medium>
                <div class="service box">
                    <img src="img/services/service-2.jpg" alt="" class="service__img">
                    <div class="service__content">
                        <h3 class="service__head">Дома из бревна</h3>
                        <a href="#" class="more-link">Подробнее</a>
                    </div>
                </div>
            </div>
            <div class="services__col">
                <div class="service box">
                    <img src="img/services/service-3.jpg" alt="" class="service__img">
                    <div class="service__content">
                        <h3 class="service__head">Дома из клееного бруса</h3>
                        <a href="#" class="more-link">Подробнее</a>
                    </div>
                </div>
            </div>
            <div class="services__col">
                <div class="service box">
                    <img src="img/services/service-4.jpg" alt="" class="service__img">
                    <div class="service__content">
                        <h3 class="service__head">Бани</h3>
                        <a href="#" class="more-link">Подробнее</a>
                    </div>
                </div>
            </div>
            <div class="services__col">
                <div class="service box">
                    <img src="img/services/service-5.jpg" alt="" class="service__img">
                    <div class="service__content">
                        <h3 class="service__head">беседки</h3>
                        <a href="#" class="more-link">Подробнее</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>-->

<section class="numbers overlay-bottom">
    <div class="container">
        <div class="title">
            <h2>Наша компания в цифрах</h2>
        </div>
        <div class="numbers__grid">
            <div class="numbers__col">
                <div class="number-item">
                    <p class="number-item__main">3177</p>
                    <p>Дома</p>
                </div>
            </div>
            <div class="numbers__col">
                <div class="number-item">
                    <p class="number-item__main">1987</p>
                    <p>бань</p>
                </div>
            </div>
            <div class="numbers__col">
                <div class="number-item">
                    <p class="number-item__main">30</p>
                    <p>лет опыта</p>
                </div>
            </div>
            <div class="numbers__col">
                <div class="number-item">
                    <p class="number-item__main">50</p>
                    <p>мастеров</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!--<section class="other-services overlay-bottom">
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
                <img src="img/other-services/house.png" alt="" class="other-services__house-img">
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
</section>-->

<!--<section class="cases">
    <div class="container">
        <div class="title">
            <h2>Недавние объекты</h2>
        </div>
    </div>
    <div class="cases-grid">
        <div class="cases-grid__wrap">

            <div class="cases-grid__col">
                <a href="#" class="case-item">
                    <img src="img/cases/case-1.jpg" alt="" class="case-item__img">
                    <div class="case-item__content">
                        <div class="case-item__content-wrap">
                            <h6>Двухэтажный дом из бруса с балконами</h6>
                            <p>д. Климотино</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="cases-grid__col">
                <a href="#" class="case-item">
                    <img src="img/cases/case-2.jpg" alt="" class="case-item__img">
                    <div class="case-item__content">
                        <div class="case-item__content-wrap">
                            <h6>Двухэтажный дом из бруса с балконами</h6>
                            <p>д. Климотино</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="cases-grid__col">
                <a href="#" class="case-item">
                    <img src="img/cases/case-1.jpg" alt="" class="case-item__img">
                    <div class="case-item__content">
                        <div class="case-item__content-wrap">
                            <h6>Двухэтажный дом из бруса с балконами</h6>
                            <p>д. Климотино</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="cases-grid__col">
                <a href="#" class="case-item">
                    <img src="img/cases/case-2.jpg" alt="" class="case-item__img">
                    <div class="case-item__content">
                        <div class="case-item__content-wrap">
                            <h6>Двухэтажный дом из бруса с балконами</h6>
                            <p>д. Климотино</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="cases-grid__col">
                <a href="#" class="case-item">
                    <img src="img/cases/case-1.jpg" alt="" class="case-item__img">
                    <div class="case-item__content">
                        <div class="case-item__content-wrap">
                            <h6>Двухэтажный дом из бруса с балконами</h6>
                            <p>д. Климотино</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="cases-grid__col">
                <a href="#" class="case-item">
                    <img src="img/cases/case-2.jpg" alt="" class="case-item__img">
                    <div class="case-item__content">
                        <div class="case-item__content-wrap">
                            <h6>Двухэтажный дом из бруса с балконами</h6>
                            <p>д. Климотино</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="cases-grid__col">
                <a href="#" class="case-item">
                    <img src="img/cases/case-1.jpg" alt="" class="case-item__img">
                    <div class="case-item__content">
                        <div class="case-item__content-wrap">
                            <h6>Двухэтажный дом из бруса с балконами</h6>
                            <p>д. Климотино</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="cases-grid__col">
                <a href="#" class="case-item">
                    <img src="img/cases/case-2.jpg" alt="" class="case-item__img">
                    <div class="case-item__content">
                        <div class="case-item__content-wrap">
                            <h6>Двухэтажный дом из бруса с балконами</h6>
                            <p>д. Климотино</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
    <div class="container">
        <div class="action-box">
            <a href="#" class="btn btn_bd btn_more">Смотреть все проекты</a>
        </div>
    </div>
</section>-->

<div class="home-bg-1 overlay-bottom">

<!-- <section class="offers">
    <div class="container">
        <div class="offers-slider swiper-container">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="offer-item box" style="background-image: url('img/offers/offer-1.jpg');">
                        <div class="offer-item__wrapper">
                            <div class="offer-item__wrap">
                                <div class="offer-item__content">
                                    <h3><span class="text-green">Скидка 10%</span> на доп работы</h3>
                                    <p>Мы дарим своим клиентам скидку 10% на все виды дополнительных работ при строительстве дома или бани.</p>
                                </div>
                                <p class="offer-item__descr">Акция действует до 30.12.2019 года</p>
                                <div class="offer-item__action">
                                    <a href="#" class="btn btn_small">УЧАСТВОВАТЬ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="offer-item box" style="background-image: url('img/offers/offer-1.jpg');">
                        <div class="offer-item__wrapper">
                            <div class="offer-item__wrap">
                                <div class="offer-item__content">
                                    <h3><span class="text-green">Скидка 10%</span> на доп работы</h3>
                                    <p>Мы дарим своим клиентам скидку 10% на все виды дополнительных работ при строительстве дома или бани.</p>
                                </div>
                                <p class="offer-item__descr">Акция действует до 30.12.2019 года</p>
                                <div class="offer-item__action">
                                    <a href="#" class="btn btn_small">УЧАСТВОВАТЬ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="offer-item box" style="background-image: url('img/offers/offer-1.jpg');">
                        <div class="offer-item__wrapper">
                            <div class="offer-item__wrap">
                                <div class="offer-item__content">
                                    <h3><span class="text-green">Скидка 10%</span> на доп работы</h3>
                                    <p>Мы дарим своим клиентам скидку 10% на все виды дополнительных работ при строительстве дома или бани.</p>
                                </div>
                                <p class="offer-item__descr">Акция действует до 30.12.2019 года</p>
                                <div class="offer-item__action">
                                    <a href="#" class="btn btn_small">УЧАСТВОВАТЬ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="swiper-nav">
                <div class="swiper-button-prev"><i class="ic ic-left"></i></div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"><i class="ic ic-right"></i></div>
            </div>
        </div>
    </div>
</section>-->

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

<!--<section class="main-map">
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
</section>-->

<section class="feedback">
    <div class="container">
        <div class="feedback-box box">
            <div class="feedback-box__wrapper">
                <div class="feedback-box__wrap">
                    <div class="feedback-box__content">
                        <h3>Нужна консультация?</h3>
                        <p>Подробно расскажем о наших услугах, видах работ и типовых проектах, рассчитаем стоимость и подготовим индивидуальное предложение! </p>
                    </div>
                    <div class="feedback-box__action">
                        <a href="#feedback-popup" data-popup class="btn">Задать вопрос</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
