jQuery(document).ready(function ($) {

    var scrollWidth = window.innerWidth - document.documentElement.clientWidth;

    $('img, a').on('dragstart', function (event) {
        event.preventDefault();
    });

    $('[type="tel"]').mask('+7 (999) 999-99-99');

    $('.btn').prepend('<span class="btn__shadow"></span>');

    $('.form').submit(function () {
        var form = $(this),
            error = 0;

        form.find('.error').removeClass('error');

        //проверяем поля формы на пустоту
        form.find('.required').each(function () {
            if ($(this).val() == '' || ($(this).attr('type') == 'tel' && $(this).val().indexOf('_') > -1)) {
                $(this).addClass('error');
                error = 1;
            }
        });

        // если ошибок нет то отправляем данные
        if (error == 0) {
            popup_open('#thanks-popup');
        }

        return false;
    });

    $('.filter-fields .filter-field').on('keypress', function (e) {
        if (e.which != 32 && (e.which < 48 || e.which > 57)) return false;
    });

    function numberFormat(number) {
        return (number < 10) ? '0' + number : number;
    }

    function mainMapInit() {

        var center = [56.30960728549371, 44.25847738337088];
        var zoom = 11;
        var markArgs = {
            iconLayout: 'default#image',
            iconImageHref: 'img/ic-mark.svg',
            iconImageSize: [39, 56],
            iconImageOffset: [-20, -56]
        };

        if (window.matchMedia('(max-width: 767px)').matches) {
            center = [56.32410818951451, 43.99145196679677];
            zoom = 10;

            markArgs['iconImageSize'] = [24, 36];
            markArgs['iconImageOffset'] = [-12, -36];
        }

        // Создание экземпляра карты.
        var mainMap = new ymaps.Map('js-main-map', {
            center: center,
            zoom: zoom,
            controls: ['zoomControl'],
        });

        // for (let i = 0, l = mainMapPoints.length; i < l; i++) {
        //   let point = mainMapPoints[i];
        //   mainMap.geoObjects.add();
        // }

        $.each(mainMapPoints, function (i, point) {

            var placemark = new ymaps.Placemark(point.coord, {
                hintContent: point.head
            }, markArgs);

            mainMap.geoObjects.add(placemark);

            placemark.events.add('click', function () {
                document.location.href = point.link;
            });

        });

        mainMap.behaviors.disable('scrollZoom');
    }

    if ($("#js-main-map").length > 0) {
        ymaps.ready(mainMapInit);
    }

    $('.mob-header, .mob-header__wrapper').matchHeight({
        byRow: false,
    });
    $(window).on('load', function () {
        $('.mob-header__wrapper').addClass('fixed');
    });
    $(window).on('load scroll', function () {
        if ($(this).scrollTop() > 0) {
            $('.mob-header__wrapper').addClass("scroll");
        } else {
            $('.mob-header__wrapper').removeClass("scroll");
        }
    });

    $('select').each(function () {
        var select = $(this),
            placeholder = $(this).data('placeholder');

        select.wrap('<div class="select-wrapper"></div>');

        select.css('width', '100%').select2({
            placeholder: placeholder,
            minimumResultsForSearch: Infinity,
            dropdownParent: select.closest('.select-wrapper')
        });
    });

    // Popups

    const magnificPopupArgs = {
        type: 'inline',
        removalDelay: 400,
        mainClass: 'mfp-fade',
        tClose: 'Закрыть',
        callbacks: {
            open: function () {
                // $('.header__wrapper.fixed').css('margin-right', scrollWidth);
            },
            close: function () {
                // $('.header__wrapper.fixed').css('margin-right', '');
            }
        }
    };

    function popup_open(src, type) {
        let args = $.extend(true, {}, magnificPopupArgs);
        if (type == 'iframe' || type == 'image') args['type'] = type;
        args['items'] = {
            src: src
        };
        $.magnificPopup.open(args);
    }

    $('body').on('click', '[data-popup]', function () {
        var type = $(this).attr('data-popup');
        popup_open($(this).attr('href'), type);
        return false;
    });
    $('body').on('click', '[data-popup-close]', function () {
        $.magnificPopup.close();
        return false;
    });

    $('.js-gallery').each(function () {
        let items = $(this).find('a').not('[data-popup]'),
            args = $.extend(true, {}, magnificPopupArgs);

        args['type'] = 'image';
        args['gallery'] = {
            enabled: true
        };

        items.magnificPopup(args);
    });

    // Popups END

    // Menu

    $('.header__menu-list>.header__menu-dropdown').mouseenter(function () {
        let dropdown = $(this);

        $('.header__menu-list>.header__menu-dropdown').removeClass('hover');

        dropdown.addClass('hover');
        dropdown.find('>ul').css('left', dropdown.position().left);

    }).mouseleave(function () {
        var dropdown = $(this);
        setTimeout(function () {
            if (!dropdown.is(':hover')) {
                dropdown.removeClass('hover');
            }
        }, 500);
    });

    $('.header__menu-dropdown .header__menu-dropdown').mouseenter(function () {
        let dropdown = $(this),
            menu = $(this).closest('.header__menu-list');

        $('.header__menu-dropdown .header__menu-dropdown').removeClass('hover');

        dropdown.addClass('hover');

        dropdown.find('>ul').css('min-width', '').addClass('js-12345').appendTo(menu);
        $('.js-12345').css('min-width', $('.js-12345').outerWidth() + 1).appendTo(dropdown).removeClass('js-12345');

    }).mouseleave(function () {
        var dropdown = $(this);
        setTimeout(function () {
            if (!dropdown.is(':hover')) {
                dropdown.removeClass('hover');
            }
        }, 500);
    });

    // Menu END

    // Mob Menu

    $('.mob-header__toggle').click(function () {
        $(this).toggleClass('active');
    });

    $('.mob-menu__list-dropdown>a').click(function () {
        var dropdown = $(this).closest('.mob-menu__list-dropdown');
        dropdown.toggleClass('hover').find('>ul').slideToggle();
        return false;
    });

    function mobMenuShow() {
        $('.mob-menu').addClass('active');
        $('#wrapper__overlay').fadeIn(600);
        $('body').css({
            'overflow': 'hidden',
            'margin-right': scrollWidth
        });
    }

    function mobMenuClose() {
        $('.mob-menu').removeClass('active');
        $('#wrapper__overlay').fadeOut(600);
        $('body').css({
            'overflow': '',
            'margin-right': ''
        });
    }

    $('.mob-header__toggle').click(function () {
        if (!$('.mob-menu').hasClass('active')) mobMenuShow();
        else mobMenuClose();
    });

    $('#wrapper__overlay').on('click touchstart', function () {
        mobMenuClose();
    });

    // Mob Menu END

    $('.catalog-slider .catalog-item').matchHeight({
        property: 'min-height'
    });

    // Sliders

    $('.catalog-slider').each(function (i) {
        $(this).attr('id', 'catalogSlider-' + i);

        var catalogSlider = new Swiper('#catalogSlider-' + i, {
            slidesPerView: 3,
            spaceBetween: 15,
            centerInsufficientSlides: true,
            watchOverflow: true,
            watchSlidesProgress: true,
            watchSlidesVisibility: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                prevEl: '.swiper-button-prev',
                nextEl: '.swiper-button-next',
            },
            breakpoints: {
                1199: {
                    slidesPerView: 2,
                },
                767: {
                    slidesPerView: 1,
                },
            }
        });
        if ($(catalogSlider.params.el).length > 0) {
            $(window).on('load resize', function () {
                catalogSlider.update();
            });

            setTimeout(function () {

                $('.tabs__item').click(function () {
                    catalogSlider.update();
                });

            }, 10);
        }
    });

    var otherServicesSlider = new Swiper('.other-services__slider', {
        init: false,
        spaceBetween: 100,
        watchOverflow: true,
        autoHeight: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            prevEl: '.swiper-button-prev',
            nextEl: '.swiper-button-next',
        },
    });
    if ($(otherServicesSlider.params.el).length > 0) {
        $('.other-service').each(function (i) {
            $(this).find('.other-service__step').html('<b>' + numberFormat(i + 1) + '</b>/' + numberFormat($('.other-service').length));
        });

        otherServicesSlider.on('slideChange init', function () {
            $('.other-services__house-list li').removeClass('active').eq(otherServicesSlider.realIndex).addClass('active');
        }).init();

        $('.other-services__house-list li').click(function () {
            otherServicesSlider.slideTo($(this).index());
        });
    }

    new Swiper('.offers-slider', {
        spaceBetween: 100,
        centerInsufficientSlides: true,
        watchOverflow: true,
        autoHeight: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            prevEl: '.swiper-button-prev',
            nextEl: '.swiper-button-next',
        },
    });

    new Swiper('.reviews-slider', {
        loop: true,
        slidesPerView: 'auto',
        centeredSlides: true,
        effect: 'coverflow',
        coverflowEffect: {
            rotate: 0,
            depth: 220,
            stretch: -200,
            slideShadows: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            prevEl: '.swiper-button-prev',
            nextEl: '.swiper-button-next',
        },
        breakpoints: {
            1199: {
                coverflowEffect: {
                    rotate: 0,
                    depth: 220,
                    stretch: -120,
                    slideShadows: false,
                },
            },
            767: {
                coverflowEffect: {
                    rotate: 0,
                    depth: 0,
                    stretch: -15,
                    slideShadows: false,
                },
            },
        }
    });

    $('.product-gallery__slider').each(function (i) {
        var slider = $(this),
            thumbs = slider.next('.product-gallery__thumbs');

        slider.attr('id', 'productSlider-' + i);
        thumbs.attr('id', 'productThumbsSlider-' + i);

        thumbs.find('.product-gallery__thumb').each(function (i) {
            $(this).attr('data-index', i);
        });

        var productSlider = new Swiper('#productSlider-' + i, {
            init: false,
            watchOverflow: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
        var productThumbsSlider = new Swiper('#productThumbsSlider-' + i, {
            slidesPerView: 4,
            spaceBetween: 10,
            mousewheel: true,
            centerInsufficientSlides: true,
            navigation: {
                prevEl: '.swiper-button-prev',
                nextEl: '.swiper-button-next',
            },
        });
        if ($(productThumbsSlider.params.el).length > 0 && $(productSlider.params.el).length > 0) {
            productSlider.on('slideChange init', function () {
                thumbs.find('.product-gallery__thumb').removeClass('active');
                thumbs.find('.product-gallery__thumb[data-index="' + productSlider.realIndex + '"]').addClass('active');
                productThumbsSlider.slideTo(productSlider.realIndex);
            });

            thumbs.find('.product-gallery__thumb').click(function () {
                productSlider.slideTo($(this).attr('data-index'));
                return false;
            });

            if (productThumbsSlider.slides.length == 1) $(productThumbsSlider.params.el).hide();
        }
        productSlider.init();
    });

    new Swiper('.cat-looked__slider', {
        slidesPerView: 'auto',
        freeMode: true
    });

    $('.gallery-slider').each(function (i) {
        $(this).attr('id', 'gallerySlider-' + i);

        var slider = new Swiper('#gallerySlider-' + i + ' .swiper-container', {
            slidesPerView: 3,
            spaceBetween: 8,
            watchOverflow: true,
            watchSlidesProgress: true,
            watchSlidesVisibility: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                prevEl: '.swiper-button-prev',
                nextEl: '.swiper-button-next',
            },
            breakpoints: {
                767: {
                    slidesPerView: 2,
                    spaceBetween: 2,
                },
            }
        });
        if ($(slider.params.el).length > 0) {
            $(window).on('load resize', function () {
                slider.update();
            });
        }
    });

    // Sliders END

    // Tabs

    $('.tabs').each(function () {
        if ($(this).next('.tabs-wrap').length > 0) {
            $(this).find('.tabs__item').eq(0).addClass('active');
        }
    });

    $('.tabs__item').click(function () {
        var wrap = $(this).closest('.tabs'),
            items_wrap = wrap.next('.tabs-wrap'),
            items = items_wrap.find('.tabs-wrap__item'),
            i = $(this).index();

        if (items_wrap.length > 0) {

            if ($(this).hasClass('active')) return false;

            wrap.find('.tabs__item').removeClass('active');
            $(this).addClass('active');

            items.hide().eq(i).fadeIn();

            wrap.find('.tabs__toggle').removeClass('active').siblings('.tabs__grid').hide();
            wrap.find('.tabs__toggle-text').html($(this).html());

            return false;

        }
    });

    $('.tabs__toggle').each(function () {
        var wrap = $(this).closest('.tabs');
        wrap.find('.tabs__toggle-text').html(wrap.find('.tabs__item.active').eq(0).html());
        $(this).click(function () {
            $(this).toggleClass('active').siblings('.tabs__grid').toggle();
        });
    });

    // Tabs END

    $('.window-item__tab:nth-child(1)').addClass('active');

    $('.window-item__tab').click(function () {
        if ($(this).hasClass('active')) return false;

        var wrap = $(this).closest('.window-item__tabs'),
            items = $(this).closest('.window-item').find('.window-item__box'),
            i = $(this).index();

        wrap.find('.window-item__tab').removeClass('active');
        $(this).addClass('active');

        items.hide().eq(i).fadeIn();

        return false;
    });

    $('.sort__item').click(function () {
        let wrap = $(this).closest('.sort');
        if ($(this).hasClass('active')) {
            $(this).toggleClass('active_2');
        } else {
            wrap.find('.sort__item').removeClass('active active_2');
            $(this).addClass('active');
        }
        return false;
    });
    $('.sort__item:nth-of-type(1)').addClass('active');

    $('.product-table__select select').change(function () {
        var table = $(this).closest('.product-table');
        table.find('[data-item]').hide();
        table.find('[data-item="' + $(this).val() + '"]').show();
    });

    // Quiz

    var quiz_steps = $('.quiz-form__step').length;
    var quiz_percent = 100 / quiz_steps;
    var quiz_percent_active = 0;

    function quiz_progress() {
        let step = $('.quiz-form__step:visible').index() + 1;

        quiz_percent_active = quiz_percent_active + quiz_percent;

        if (step == quiz_steps) $('.quiz-progress__head').text('Поздравляем!');
        else $('.quiz-progress__head').text('Вопрос ' + step + ' из ' + quiz_steps);

        return quiz_percent_active + '%';
    }

    $('<div></div>').appendTo('.quiz-progress__line').css('width', quiz_progress());

    $('.quiz-form__next').click(function () {
        var step = $(this).closest('.quiz-form__step'),
            error = 0;

        if (step.find('.quiz-radio').length > 0 && step.find('.quiz-radio__input:checked').length == 0) {
            step.find('.quiz-radio').addClass('error');
            error = 1;
        } else {
            step.find('.quiz-radio').removeClass('error');
        }

        if (error == 0) {
            step.hide().next('.quiz-form__step').fadeIn(300);
            $('.quiz-progress__line>div').css('width', quiz_progress());

            $(window).scrollTop(($('.mob-header').is(':visible')) ? $('.quiz-form').offset().top - $('.mob-header').outerHeight() : $('.quiz-form').offset().top);
        }

    });

    $('.quiz-radio__input').change(function () {
        $(this).closest('.quiz-radio').removeClass('error');
    });

    $('.quiz-radio__field').focus(function () {
        $(this).closest('.quiz-radio__item').find('.quiz-radio__input').prop('checked', true);
    });

    // Quiz END

    $('.mfilter-item__head').click(function () {
        $(this).toggleClass('is-hidden');
        $(this).siblings('.mfilter-item__wrap').slideToggle();
    });

    $('.mfilter-item.is-hidden').each(function () {
        $(this).find('.mfilter-item__head').addClass('is-hidden');
        $(this).find('.mfilter-item__wrap').hide();
    });

    $('.price-tabs__toggle button').click(function () {
        if ($(this).hasClass('active')) return false;

        var wrap = $(this).closest('.price-tabs'),
            buttons = wrap.find('.price-tabs__toggle button'),
            prices = wrap.find('.price-tabs__price p'),
            i = $(this).index();

        buttons.removeClass('active');
        $(this).addClass('active');

        prices.hide().eq(i).fadeIn(300);
    });
    $('.price-tabs__toggle button:nth-child(1)').addClass('active');

});
