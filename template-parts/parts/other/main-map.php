<?php

if (!function_exists('parse_cords')) {
    // Парсит координаты
    function parse_cords($str, $echo = true) {
        $coords = explode(',', $str);
        $coords = array_map('trim', $coords);
        if ($echo) {
            echo '[' . implode($coords, ',') . ']';
        }
        return $coords;
    }
}

$posts = get_posts([
    'numberposts' => -1,
    'post_type' => 'product',
    'tax_query' => [
        [
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => 'completed'
        ]
    ]
]);

$points = [];
if ($posts) {
    foreach ($posts as $post) {
        $product = wc_get_product($post);
        if (!$product) continue;
        $coords = $product->get_meta('cords_project');
        if (!$coords) continue;
        $coords = parse_cords($coords, false);
        $points[] = [
            'coords' => $coords,
            'head' => $product->get_title(),
            'link' => $product->get_permalink()
        ];
    }
}
$points = json_encode($points);

?>

<div class="main-map">
    <div class="container">
        <div class="title">
            <h2>Карта выполненных проектов</h2>
        </div>
    </div>
    <div class="main-map__wrapper">

        <div id="js-main-map" class="main-map__map"></div>

        <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>

        <script>
            ymaps.ready(function () {
                const args = {
                        center: <?php parse_cords(get_field('contacts_other_coordinates_desktop', 'option')); ?>,
                        zoom: 11,
                        controls: ['zoomControl']
                    },
                    markArgs = {
                        iconLayout: 'default#image',
                        iconImageHref: '<?= get_img('img/ic-mark.svg'); ?>',
                        iconImageSize: [39, 56],
                        iconImageOffset: [-20, -56]
                    },
                    points = JSON.parse('<?= $points; ?>');

                if (window.matchMedia('(max-width: 767px)').matches) {
                    args['center'] = <?php parse_cords(get_field('contacts_other_coordinates_mobile', 'option')); ?>;
                    args['zoom'] = 10;

                    markArgs['iconImageSize'] = [24, 36];
                    markArgs['iconImageOffset'] = [-12, -36];
                }

                // Создание экземпляра карты.
                const mainMap = new ymaps.Map('js-main-map', args);

                for (let i = 0, l = points.length; i < l; i++) {
                    const point = points[i],
                        placemark = new ymaps.Placemark(point.coords, {
                            hintContent: point.head
                        }, markArgs);

                    mainMap.geoObjects.add(placemark);

                    placemark.events.add('click', function () {
                        document.location.href = point.link;
                    });
                }

                mainMap.behaviors.disable('scrollZoom');
            });
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
