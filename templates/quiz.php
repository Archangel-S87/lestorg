<?php

/*
Template Name: Quiz
Template Post Type: page
*/

get_header();

?>

<div class="quiz s-inner">
    <div class="container">

        <ul class="breadcrumbs">
            <li><a href="<?= home_url(); ?>" class="breadcrumbs__home"><i class="ic ic-home"></i> Главная</a></li>
            <li>Калькулятор проекта</li>
        </ul>

        <div class="title-inn">
            <h2>Расчет стоимости вашего дома</h2>
        </div>

        <form class="quiz-form box">

            <div class="quiz-progress">
                <p class="quiz-progress__head"></p>
                <div class="quiz-progress__line"></div>
            </div>
            <div class="quiz-form__wrap">

                <div class="quiz-form__step">
                    <div class="quiz-form__title">
                        <h3>Что планируете строить?</h3>
                    </div>
                    <div class="quiz-radio">
                        <div class="quiz-radio__grid">
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Строю" class="quiz-radio__input" value="Дом из профилированного бруса">
                                    <img src="<?= get_img('img/quiz/quiz-1.1.jpg'); ?>" alt=""
                                         class="quiz-radio__img">
                                    <span class="quiz-radio__main">Дом из профилированного бруса</span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Строю" class="quiz-radio__input" value="Дом из оцилиндрованного бревна">
                                    <img src="<?= get_img('img/quiz/quiz-1.2.jpg'); ?>" alt=""
                                         class="quiz-radio__img">
                                    <span class="quiz-radio__main">Дом из оцилиндрованного бревна</span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Строю" class="quiz-radio__input" value="Каркасный дом">
                                    <img src="<?= get_img('img/quiz/quiz-1.3.jpg'); ?>" alt=""
                                         class="quiz-radio__img">
                                    <span class="quiz-radio__main">Каркасный дом</span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Строю" class="quiz-radio__input" value="Дача">
                                    <img src="<?= get_img('img/quiz/quiz-1.4.jpg'); ?>" alt=""
                                         class="quiz-radio__img">
                                    <span class="quiz-radio__main">Дача</span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Строю" class="quiz-radio__input" value="Баня">
                                    <img src="<?= get_img('img/quiz/quiz-1.5.jpg'); ?>" alt=""
                                         class="quiz-radio__img">
                                    <span class="quiz-radio__main">Баня</span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Строю" class="quiz-radio__input" value="Беседка">
                                    <img src="<?= get_img('img/quiz/quiz-1.6.jpg'); ?>" alt=""
                                         class="quiz-radio__img">
                                    <span class="quiz-radio__main">Беседка</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="quiz-form__action">
                        <span class="quiz-form__next btn btn_icon-right">Следующий шаг <i class="ic ic-right"></i></span>
                    </div>
                </div>

                <div class="quiz-form__step">
                    <div class="quiz-form__title">
                        <h3>Когда планируете начать строительство?</h3>
                    </div>
                    <div class="quiz-radio quiz-radio_small">
                        <div class="quiz-radio__grid">
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Планируете начать" class="quiz-radio__input" value="В этом месяце">
                                    <span class="quiz-radio__main">В этом месяце</span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Планируете начать" class="quiz-radio__input" value="В течении года (В этом году)">
                                    <span class="quiz-radio__main">В течении года (В этом году)</span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="quiz[2]" class="quiz-radio__input">
                                    <span class="quiz-radio__main">Ближайшие 1-3 месяца</span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Планируете начать" class="quiz-radio__input" value="Присматриваюсь">
                                    <span class="quiz-radio__main">Присматриваюсь</span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Планируете начать" class="quiz-radio__input" value="Ближайшие 6 месяцев">
                                    <span class="quiz-radio__main">Ближайшие 6 месяцев</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="quiz-form__action">
                        <span class="quiz-form__next btn btn_icon-right">Следующий шаг <i class="ic ic-right"></i></span>
                    </div>
                </div>

                <div class="quiz-form__step">
                    <div class="quiz-form__title">
                        <h3>Регион строительства</h3>
                    </div>
                    <div class="quiz-radio quiz-radio_small">
                        <div class="quiz-radio__grid">
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Регион" class="quiz-radio__input" value="Нижний Новгород">
                                    <span class="quiz-radio__main">Нижний Новгород</span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Регион" class="quiz-radio__input" value="Нижегородская область">
                                    <span class="quiz-radio__main">Нижегородская область</span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Регион" class="quiz-radio__input" value="Владимир">
                                    <span class="quiz-radio__main">Владимир</span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Регион" class="quiz-radio__input" value="Владимирская область">
                                    <span class="quiz-radio__main">Владимирская область</span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item d-block">
                                    <input type="radio" name="Регион" class="quiz-radio__input" value="other_region">
                                    <span class="quiz-radio__main quiz-radio__main_grid">
                                        <span class="quiz-radio__main-left">Другое</span>
                                        <span class="quiz-radio__main-right">
                                            <input type="text" name="other_region" placeholder="Введите населеный пункт" class="quiz-radio__field">
                                        </span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="quiz-form__action">
                        <span class="quiz-form__next btn btn_icon-right">Следующий шаг <i class="ic ic-right"></i></span>
                    </div>
                </div>

                <div class="quiz-form__step">
                    <div class="quiz-form__title">
                        <h3>Площадь дома или постройки</h3>
                    </div>
                    <div class="quiz-radio quiz-radio_small">
                        <div class="quiz-radio__grid">
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Площадь" class="quiz-radio__input" value="до 60 м2">
                                    <span class="quiz-radio__main">до 60<sup>2</sup></span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Площадь" class="quiz-radio__input" value="60-100 м2">
                                    <span class="quiz-radio__main">60-100<sup>2</sup></span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Площадь" class="quiz-radio__input" value="100-150 м2">
                                    <span class="quiz-radio__main">100-150<sup>2</sup></span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Площадь" class="quiz-radio__input" value="150-200 м2">
                                    <span class="quiz-radio__main">150-200<sup>2</sup></span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Площадь" class="quiz-radio__input" value="200-250 м2">
                                    <span class="quiz-radio__main">200-250<sup>2</sup></span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Площадь" class="quiz-radio__input" value="Свыше 250 м2">
                                    <span class="quiz-radio__main">Свыше 250 м<sup>2</sup></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="quiz-form__action">
                        <span class="quiz-form__next btn btn_icon-right">Следующий шаг <i class="ic ic-right"></i></span>
                    </div>
                </div>

                <div class="quiz-form__step">
                    <div class="quiz-form__title">
                        <h3>Какой бюджет строительства?</h3>
                    </div>
                    <div class="quiz-radio quiz-radio_small">
                        <div class="quiz-radio__grid">
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Бюджет" class="quiz-radio__input" value="До 1 млн ₽">
                                    <span class="quiz-radio__main">До 1 млн ₽</span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Бюджет" class="quiz-radio__input" value="1 млн - 2 млн ₽">
                                    <span class="quiz-radio__main">1 млн - 2 млн ₽</span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Бюджет" class="quiz-radio__input" value="2 млн - 3 млн ₽">
                                    <span class="quiz-radio__main">2 млн - 3 млн ₽</span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Бюджет" class="quiz-radio__input" value="4 млн - 5 млн ₽">
                                    <span class="quiz-radio__main">4 млн - 5 млн ₽</span>
                                </label>
                            </div>
                            <div class="quiz-radio__col">
                                <label class="quiz-radio__item">
                                    <input type="radio" name="Бюджет" class="quiz-radio__input" value="Свыше 5 млн ₽">
                                    <span class="quiz-radio__main">Свыше 5 млн ₽</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="quiz-form__action">
                        <span class="quiz-form__next btn btn_icon-right">Следующий шаг <i class="ic ic-right"></i></span>
                    </div>
                </div>

                <div class="quiz-form__step">
                    <div class="quiz-form__title">
                        <h3>Оставьте свои контактные данные, чтобы получить расчет</h3>
                    </div>
                    <div class="quiz-form__form">
                        <label class="form-item">
                            <i class="form-item__icon ic ic-user"></i>
                            <input type="text" name="Имя" class="form-field" placeholder="Имя">
                        </label>
                        <label class="form-item">
                            <i class="form-item__icon ic ic-phone"></i>
                            <input type="tel" name="Телефон" class="form-field required" placeholder="Телефон">
                        </label>
                        <label class="form-item">
                            <i class="form-item__icon ic ic-mail"></i>
                            <input type="text" name="Email" class="form-field" placeholder="Email">
                        </label>
                        <div class="form-action">
                            <button type="submit" class="btn btn_button">Получить расчет</button>
                            <label class="form-checkbox">
                                <input type="checkbox" checked>
                                <span>Я принимаю условия <a href="#">передачи информации</a></span>
                            </label>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>

<?php

get_footer();
