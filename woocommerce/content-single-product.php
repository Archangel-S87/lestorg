<?php

/*
 * Все фунции описаны в классе WC_LT_Single_Product
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}

?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
    <?php
    /**
     * Hook: woocommerce_before_single_product_summary.
     * Заголовок товара
     * Обёртка product-grid open
     * Галерея
     *
     * @hooked template_title_inn - 5
     * @hooked template_wrapper_grid_open - 10
     * @hooked template_gallery - 15
     */
    do_action('woocommerce_before_single_product_summary');
    ?>

    <?php
    /**
     * Hook: woocommerce_single_product_summary.
     * Обёртка для info open
     * Блок инфо
     * Обёртка для info close
     *
     * @hooked ggg - 5
     * @hooked ggg - 5
     * @hooked ggg - 5
     */
    do_action('woocommerce_single_product_summary');
    ?>

    <div class="product-grid__col">
        <div class="product-info box">
            <div class="product-info__wrap">

                <!--//----------->
                <div class="product-info__title">
                    <h4>Характеристики</h4>
                </div>
                <table class="product-info__table">
                    <tr>
                        <td>Технология</td>
                        <td>Проф. брус</td>
                    </tr>
                    <tr>
                        <td>Общая площадь</td>
                        <td><b class="text-green">128 м<sup>2</sup></b></td>
                    </tr>
                    <tr>
                        <td>Габариты</td>
                        <td>8х8 м</td>
                    </tr>
                    <tr>
                        <td>Этажность</td>
                        <td>2</td>
                    </tr>
                    <tr>
                        <td>Срок строительства</td>
                        <td>от 1 месяца</td>
                    </tr>
                    <tr>
                        <td>Комнаты</td>
                        <td>5</td>
                    </tr>
                    <tr>
                        <td>Санузлы</td>
                        <td>2</td>
                    </tr>
                    <tr>
                        <td>Крыша</td>
                        <td>4-скатная</td>
                    </tr>
                    <tr>
                        <td>Угол наклона крыши</td>
                        <td>30/25</td>
                    </tr>
                </table>
                <!--//----------->
                <div class="product-action">
                    <div class="product-action__price">
                        <p class="product-action__price-descr">Цена</p>
                        <p>от 4 120 000 ₽</p>
                    </div>
                    <a href="#" class="product-action__icon ic ic-heart"></a>
                    <div class="product-action__btn">
                        <a href="#" class="btn">Оставить заявку</a>
                    </div>
                </div>
                <!--//----------->
                <div class="share">
                    <p class="share__head">Сохранить проект:</p>
                    <div class="share__grid">
                        <a href="#" class="share-item ic ic-vk"></a>
                        <a href="#" class="share-item ic ic-facebook"></a>
                        <a href="#" class="share-item ic ic-ok"></a>
                        <a href="#" class="share-item ic ic-pinterest"></a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php
    /**
     * Hook: woocommerce_single_product_summary.
     *
     *
     * @hooked woocommerce_template_single_title - 5
     * @hooked woocommerce_template_single_rating - 10
     * @hooked woocommerce_template_single_price - 10
     * @hooked woocommerce_template_single_excerpt - 20
     * @hooked woocommerce_template_single_add_to_cart - 30
     * @hooked woocommerce_template_single_meta - 40
     * @hooked woocommerce_template_single_sharing - 50
     * @hooked WC_Structured_Data::generate_product_data() - 60
     */
    //do_action( 'woocommerce_single_product_summary' );
    ?>

    <?php
    /**
     * Hook: woocommerce_after_single_product_summary.
     * Обёртка product-grid close
     * Остальная инфа
     *
     * @hooked template_wrapper_grid_close - 5 Моё
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 20
     */
    do_action('woocommerce_after_single_product_summary');
    ?>

    <div class="product__row">
        <div class="container">
            <div class="product__row-title">
                <h3>Комплектации</h3>
            </div>

            <div class="product-table-select">
                <select>
                    <option value="1">1 вариант, 598 000 ₽</option>
                    <option value="2">2 вариант, 858 000 ₽</option>
                    <option value="3">3 вариант, 1 043 000 ₽</option>
                </select>
            </div>

            <div class="product-table">
                <div class="product-table__box box">
                    <table>
                        <thead>
                        <tr>
                            <th>Варианты комплектаций</th>
                            <th data-item="1">1 вариант <br><b>598 000 ₽</b></th>
                            <th data-item="2">2 вариант <br><b>858 000 ₽</b></th>
                            <th data-item="3">3 вариант <br><b>1 043 000 ₽</b></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Высота этажа</td>
                            <td data-item="1">1 этаж-2,45 м <br>2 этаж-2,3 м</td>
                            <td data-item="2">1 этаж-2,45 м <br>2 этаж-2,3 м</td>
                            <td data-item="3">1 этаж-2,6 м <br>2 этаж-2,3 м</td>
                        </tr>
                        <tr>
                            <td>Кровля</td>
                            <td data-item="1"><s>Оцинкованный профнастил</s><br><b class="text-green">Крашенный
                                    профнастил в подарок!</b></td>
                            <td data-item="2">Крашенный профнастил <br>(цвет на выбор)</td>
                            <td data-item="3">Металлочерепица <br>(цвет на выбор)</td>
                        </tr>
                        <tr>
                            <td>Карнизы</td>
                            <td data-item="1">—</td>
                            <td data-item="2"><s>Вагонка</s><br><b class="text-green">Имитация бруса в подарок!</b></td>
                            <td data-item="3"><s>Вагонка</s><br><b class="text-green">Имитация бруса в подарок!</b></td>
                        </tr>
                        <tr>
                            <td>Вентилируемая наружная отделка фронтонов</td>
                            <td data-item="1">Имитация бруса</td>
                            <td data-item="2">Имитация бруса</td>
                            <td data-item="3">Имитация бруса</td>
                        </tr>
                        <tr>
                            <td>Пол</td>
                            <td data-item="1">—</td>
                            <td data-item="2">Подготовка под чистовой пол, доска 25х100 мм</td>
                            <td data-item="3">Шпунтованная доска, сорт АВ</td>
                        </tr>
                        <tr>
                            <td>Внутренняя отделка</td>
                            <td data-item="1">—</td>
                            <td data-item="2">ГСП</td>
                            <td data-item="3">Вагонка</td>
                        </tr>
                        <tr>
                            <td>Утепление</td>
                            <td data-item="1">—</td>
                            <td data-item="2">Плитный утеплитель, 150 мм</td>
                            <td data-item="3">Плитный утеплитель, 150 мм</td>
                        </tr>
                        <tr>
                            <td>Двухкамерные пластиковые окна</td>
                            <td data-item="1">—</td>
                            <td data-item="2"><s>Пластиковые, <br>1,0 х 1,0 м</s> <br><b class="text-green">1,0 х 1,2 м
                                    в подарок!</b></td>
                            <td data-item="3"><s>Пластиковые, <br>1,0 х 1,0 м</s> <br><b class="text-green">1,0 х 1,2 м
                                    в подарок!</b></td>
                        </tr>
                        <tr>
                            <td>Лестница</td>
                            <td data-item="1">Строительная</td>
                            <td data-item="2">Строительная</td>
                            <td data-item="3">Г-образная</td>
                        </tr>
                        <tr>
                            <td>Входная дверь</td>
                            <td data-item="1">—</td>
                            <td data-item="2">Металлическая</td>
                            <td data-item="3">Металлическая</td>
                        </tr>
                        <tr>
                            <td>Угловое соединение</td>
                            <td data-item="1">Тёплый угол</td>
                            <td data-item="2">Тёплый угол</td>
                            <td data-item="3">Тёплый угол</td>
                        </tr>
                        <tr>
                            <td>Скрепление венцов</td>
                            <td data-item="1">Березовые нагеля, скобы 8х200 мм</td>
                            <td data-item="2">Березовые нагеля, скобы 8х200 мм</td>
                            <td data-item="3">Березовые нагеля, скобы 8х200 мм</td>
                        </tr>
                        <tr>
                            <td>Лаги пола, перекрытий и стропильных ног</td>
                            <td data-item="1">50х150 мм, <br>шаг 590 мм</td>
                            <td data-item="2">50х150 мм, <br>шаг 590 мм</td>
                            <td data-item="3">50х150 мм, <br>шаг 590 мм</td>
                        </tr>
                        <tr>
                            <td>Антисептирование лаг и обвязочных венцов</td>
                            <td data-item="1">—</td>
                            <td data-item="2">Огнебиозащита</td>
                            <td data-item="3">Огнебиозащита</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="product-table__action">
                        <a href="#" class="btn btn_bd">Хочу другую комплектацию</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="product__row">
        <div class="container">
            <div class="product__row-title">
                <h3>Описание проекта</h3>
            </div>
            <div class="product-content box">
                <div class="content">
                    <p>Двухэтажный дом из профилированного бруса с тремя спальнями, кухней-гостиной и просторной
                        террасой. Собственная территория подарит большой семье необходимое пространство, а современная
                        планировка сделает его функциональным.
                        Если
                        у Вас есть машина – можно пристроить навес или гараж для авто, решив вопрос парковки. В Вас
                        дремлет ландшафтный дизайнер? <br>Декорируйте участок цветочными клумбами, растениями, садовыми
                        дорожками и малыми архитектурными
                        формами!
                        Также на участке можно разместить игровую площадку, если в семье есть дети. Собственный дом
                        открывает множество возможностей своим владельцам. <br>Кстати, стоимость можно зафиксировать уже
                        сегодня, не боясь сезонного повышения
                        цен, а строиться в удобное для Вас время.</p>
                </div>
                <div class="action-box">
                    <a href="#" class="btn">Оставить заявку</a>
                    <a href="#" class="btn btn_bd">Задать вопрос</a>
                </div>
            </div>
        </div>
    </div>

    <div class="product__row">
        <div class="container">
            <div class="product__row-title">
                <h3>Вы смотрели</h3>
            </div>

            <div class="catalog-slider swiper-container">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="catalog-item box">
                            <a href="#" class="catalog-item__img"
                               style="background-image: url('img/catalog/catalog-1.jpg');"></a>
                            <div class="catalog-item__main">
                                <div class="catalog-item__top">
                                    <h5 class="catalog-item__head"><a href="#" class="link-head">Калипсо</a></h5>
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
                                <div class="catalog-item__bottom">
                                    <a href="#" class="catalog-item__icon"><i class="ic ic-heart"></i></a>
                                    <p class="catalog-item__price">от 4 120 000 ₽</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="catalog-item box">
                            <a href="#" class="catalog-item__img"
                               style="background-image: url('img/catalog/catalog-1.jpg');"></a>
                            <div class="catalog-item__main">
                                <div class="catalog-item__top">
                                    <h5 class="catalog-item__head"><a href="#" class="link-head">Оберон</a></h5>
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
                                <div class="catalog-item__bottom">
                                    <a href="#" class="catalog-item__icon"><i class="ic ic-heart"></i></a>
                                    <p class="catalog-item__price">от 4 120 000 ₽</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="catalog-item box">
                            <a href="#" class="catalog-item__img"
                               style="background-image: url('img/catalog/catalog-1.jpg');"></a>
                            <div class="catalog-item__main">
                                <div class="catalog-item__top">
                                    <h5 class="catalog-item__head"><a href="#" class="link-head">скандинавия</a></h5>
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
                                <div class="catalog-item__bottom">
                                    <a href="#" class="catalog-item__icon"><i class="ic ic-heart"></i></a>
                                    <p class="catalog-item__price">от 4 120 000 ₽</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="catalog-item box">
                            <a href="#" class="catalog-item__img"
                               style="background-image: url('img/catalog/catalog-1.jpg');"></a>
                            <div class="catalog-item__main">
                                <div class="catalog-item__top">
                                    <h5 class="catalog-item__head"><a href="#" class="link-head">Калипсо</a></h5>
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
                                <div class="catalog-item__bottom">
                                    <a href="#" class="catalog-item__icon"><i class="ic ic-heart"></i></a>
                                    <p class="catalog-item__price">от 4 120 000 ₽</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="catalog-item box">
                            <a href="#" class="catalog-item__img"
                               style="background-image: url('img/catalog/catalog-1.jpg');"></a>
                            <div class="catalog-item__main">
                                <div class="catalog-item__top">
                                    <h5 class="catalog-item__head"><a href="#" class="link-head">Оберон</a></h5>
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
                                <div class="catalog-item__bottom">
                                    <a href="#" class="catalog-item__icon"><i class="ic ic-heart"></i></a>
                                    <p class="catalog-item__price">от 4 120 000 ₽</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="catalog-item box">
                            <a href="#" class="catalog-item__img"
                               style="background-image: url('img/catalog/catalog-1.jpg');"></a>
                            <div class="catalog-item__main">
                                <div class="catalog-item__top">
                                    <h5 class="catalog-item__head"><a href="#" class="link-head">скандинавия</a></h5>
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
                                <div class="catalog-item__bottom">
                                    <a href="#" class="catalog-item__icon"><i class="ic ic-heart"></i></a>
                                    <p class="catalog-item__price">от 4 120 000 ₽</p>
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
    </div>

</div>

<?php do_action('woocommerce_after_single_product'); ?>
