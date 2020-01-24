<?php
// TODO Неверно отображается карта на разных страницах
?>

<div class="main-map">
    <div class="container">
        <div class="title">
            <h2>Карта выполненных проектов</h2>
        </div>
    </div>
    <div class="main-map__wrapper">

        <div id="js-main-map" class="main-map__map"></div>
        <script>
            let mainMapPoints = [{
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
                }
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
                        <label class="form-item">
                            <i class="form-item__icon ic ic-user"></i>
                            <input type="text" class="form-field required" placeholder="Введите Ваше имя">
                        </label>
                        <label class="form-item">
                            <i class="form-item__icon ic ic-phone"></i>
                            <input type="tel" class="form-field required" placeholder="Введите Ваш телефон">
                        </label>
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
