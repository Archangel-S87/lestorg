jQuery(document).ready(function ($) {

    const ajax_url = lestorg_ajax.url || {};

    let scrollWidth = window.innerWidth - document.documentElement.clientWidth;

    $('img, a').on('dragstart', function (event) {
        event.preventDefault();
    });

    $('[type="tel"]').mask('+7 (999) 999-99-99');

    $('.btn').prepend('<span class="btn__shadow"></span>');

    /*
    Отправка заявок
     */
    $('.form-box').submit(send_email_forms);
    $('.quiz-form').submit(send_email_forms);

    function send_email_forms() {
        const form = $(this);

        let error = 0;

        form.find('.error').removeClass('error');

        //проверяем поля формы на пустоту
        form.find('.required').each(function () {
            if ($(this).val() === '' || ($(this).attr('type') === 'tel' && $(this).val().indexOf('_') > -1)) {
                $(this).addClass('error');
                error = 1;
            }
        });

        // если ошибок нет то отправляем данные
        if (error === 0) {
            const formData = form.serializeArray(),
                data = {};

            formData.forEach(function (item) {
                data[item.name] = item.value;
            });

            $.ajax({
                url: ajax_url,
                type: 'post',
                dataType: 'json',
                data: {
                    action: 'lestorg_ajax_send_forms',
                    form_data: data,
                },
                success: function (result) {
                    if (result.errors) {
                        console.log(result.errors);
                    } else {
                        popup_open('#thanks-popup');
                        setTimeout(function () {
                            if (form.hasClass('quiz-form')) {
                                window.location.href = window.location.origin;
                            }
                            $.magnificPopup.close();
                        }, 3000);
                    }
                }
            });

        }

        return false;
    }

    $('.filter-fields .filter-field').on('keypress', function (e) {
        if (e.which !== 32 && (e.which < 48 || e.which > 57)) return false;
    });

    function numberFormat(number) {
        return (number < 10) ? '0' + number : number;
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
        let select = $(this),
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
        if (type === 'iframe' || type === 'image') args['type'] = type;
        args['items'] = {
            src: src
        };
        $.magnificPopup.open(args);
    }

    $('body').on('click', '[data-popup]', function () {
        let type = $(this).attr('data-popup');
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
        let dropdown = $(this);
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
        let dropdown = $(this);
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
        let dropdown = $(this).closest('.mob-menu__list-dropdown');
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

        let catalogSlider = new Swiper('#catalogSlider-' + i, {
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

    let otherServicesSlider = new Swiper('.other-services__slider', {
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
        let slider = $(this),
            thumbs = slider.next('.product-gallery__thumbs');

        slider.attr('id', 'productSlider-' + i);
        thumbs.attr('id', 'productThumbsSlider-' + i);

        thumbs.find('.product-gallery__thumb').each(function (i) {
            $(this).attr('data-index', i);
        });

        let productSlider = new Swiper('#productSlider-' + i, {
            init: false,
            watchOverflow: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
        let productThumbsSlider = new Swiper('#productThumbsSlider-' + i, {
            slidesPerView: 4,
            spaceBetween: 10,
            mousewheel: true,
            centerInsufficientSlides: true,
            navigation: {
                prevEl: '.swiper-button-prev',
                nextEl: '.swiper-button-next',
            }
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

            if (productThumbsSlider.slides.length === 1) $(productThumbsSlider.params.el).hide();
        }
        productSlider.init();
    });

    new Swiper('.cat-looked__slider', {
        slidesPerView: 'auto',
        freeMode: true
    });

    // Sliders END

    // Tabs

    $('.tabs').each(function () {
        if ($(this).next('.tabs-wrap').length > 0) {
            $(this).find('.tabs__item').eq(0).addClass('active');
        }
    });

    $('.tabs__item').click(function () {
        let wrap = $(this).closest('.tabs'),
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
        let wrap = $(this).closest('.tabs');
        wrap.find('.tabs__toggle-text').html(wrap.find('.tabs__item.active').eq(0).html());
        $(this).click(function () {
            $(this).toggleClass('active').siblings('.tabs__grid').toggle();
        });
    });

    // Tabs END

    $('.window-item__tab:nth-child(1)').addClass('active');

    $('.window-item__tab').click(function () {
        if ($(this).hasClass('active')) return false;

        let wrap = $(this).closest('.window-item__tabs'),
            items = $(this).closest('.window-item').find('.window-item__box'),
            i = $(this).index();

        wrap.find('.window-item__tab').removeClass('active');
        $(this).addClass('active');

        items.hide().eq(i).fadeIn();

        return false;
    });

    /*
    Сортировка товаров
     */
    $('.sort__item').on('click', function () {
        const item = $(this),
            form = item.closest('.sort'),
            orderBy = item.attr('data-orderby');
        let order = '-desc';

        if (item.hasClass('active')) {
            item.toggleClass('active_2');
            if (item.hasClass('active_2')) {
                order = '';
            }
        } else {
            form.find('.sort__item').removeClass('active active_2');
            item.addClass('active');
        }

        $('#sort_product_input').val(orderBy + order);

        form.submit();

        return false;
    });


    $('.product-table__select select').change(function () {
        let table = $(this).closest('.product-table');
        table.find('[data-item]').hide();
        table.find('[data-item="' + $(this).val() + '"]').show();
    });

    // Quiz

    let quiz_steps = $('.quiz-form__step').length;
    let quiz_percent = 100 / quiz_steps;
    let quiz_percent_active = 0;

    function quiz_progress() {
        let step = $('.quiz-form__step:visible').index() + 1;

        quiz_percent_active = quiz_percent_active + quiz_percent;

        if (step === quiz_steps) $('.quiz-progress__head').text('Поздравляем!');
        else $('.quiz-progress__head').text('Вопрос ' + step + ' из ' + quiz_steps);

        return quiz_percent_active + '%';
    }

    $('<div></div>').appendTo('.quiz-progress__line').css('width', quiz_progress());

    $('.quiz-form__next').click(function () {
        let step = $(this).closest('.quiz-form__step'),
            error = 0;

        if (step.find('.quiz-radio').length > 0 && step.find('.quiz-radio__input:checked').length === 0) {
            step.find('.quiz-radio').addClass('error');
            error = 1;
        } else {
            step.find('.quiz-radio').removeClass('error');
        }

        if (error === 0) {
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

        let wrap = $(this).closest('.price-tabs'),
            buttons = wrap.find('.price-tabs__toggle button'),
            prices = wrap.find('.price-tabs__price p'),
            i = $(this).index();

        buttons.removeClass('active');
        $(this).addClass('active');

        prices.hide().eq(i).fadeIn(300);
    });
    $('.price-tabs__toggle button:nth-child(1)').addClass('active');


    /*
    Пагинация
     */
    $('#pagination_count_select').on('change', function() {
        $(this).closest('#pagination_count').submit();
    });


    /*
    Избранное
     */
    add_favorite('.toggle-favorites');

    function add_favorite(selector) {
        $(selector).on('click', function() {
            const btn = $(this),
                productId = btn.attr('data-product'),
                title = {
                    remove: 'Добавить в избранное',
                    add: 'Убрать из избраного'
                };

            let action = 'add';

            if (btn.hasClass('active')) {
                action = 'remove'
            }

            $.ajax({
                url: ajax_url,
                type: 'post',
                dataType: 'json',
                data: {
                    action: 'lestorg_ajax_' + action + '_favorites',
                    product_id: productId,
                },
                success: function (result) {
                    if (result.errors) {
                        console.log(result.errors);
                    }

                    const count = result.count_products;

                    // Меняю значение в шапке
                    $('.favorite-link').each(function () {
                        const link = $(this);
                        link.find('span').html(count);
                        if (count) {
                            link.addClass('active');
                        } else {
                            link.removeClass('active');
                        }
                    });

                    btn.attr('title', title[action]);
                    btn.toggleClass('active');
                }
            });

            return false;
        });
    }


    /*
    Большой фильтр
     */
    $('#filter_product').submit(function () {
        const form = $(this),
            inputs = $('input[type="text"]', form),
            selects = $('select', form);

        if (form.attr('data-reset')) {
            form.removeAttr('data-reset');
            return true;
        }

        $('input[name="filter"]', form).val(1);

        inputs.each(function () {
            setName($(this))
        });

        selects.each(function () {
            setName($(this))
        });

        function setName(field) {
            if (field.val() === field.attr('data-default')) return;
            const name = field.attr('id').replace('filter_', '');
            field.attr('name', name);
        }
    });

    // Сброс фильтра
    $('.filter__del').on('click', function () {
        const form = $('#filter_product'),
            inputs = $('input[type="text"]', form),
            selects = $('select', form);

        inputs.each(function () {
            setDefaultVal($(this));
        });

        selects.each(function () {
            setDefaultVal($(this));
        });

        function setDefaultVal(field) {
            field.val(field.attr('data-default'));
            field.removeAttr('name');
        }

        $('input[name="filter"]', form).val(0);

        form.attr('data-reset', '1');
        form.submit();

        return false;
    });


    /*
    Вы смотрели
     */
    const showWatched = $('#show_watched');
    if (showWatched.length) {
        const postId = + showWatched.attr('data-product_id'),
            catId = + showWatched.attr('data-cat_id');

        let watched = localStorage.getItem('watched'),
            showPosts, // Просмотренные посты
            tempShowPosts = [];

        watched = watched ? JSON.parse(watched) : {};
        showPosts = watched[catId] ? new Set(watched[catId]) : new Set();

        // Добавляю текущий пост в локальное хранилище
        showPosts.add(postId);
        for(let id of showPosts) {
            tempShowPosts.push(id);
        }
        watched[catId] = tempShowPosts;

        localStorage.setItem('watched', JSON.stringify(watched));

        if (showPosts.size > 1) {
            // Запрос на загрузку просмотренных товаров из текущей категории

            showPosts.delete(postId); // Убираю текущий товар из showPosts

            tempShowPosts = [];
            for(let id of showPosts) {
                tempShowPosts.push(id);
            }

            $.ajax({
                url: ajax_url,
                type: 'post',
                dataType: 'json',
                data: {
                    action: 'lestorg_ajax_get_watched',
                    cat_id: catId,
                    product_ids: tempShowPosts
                },
                success: function (result) {
                    if (result.errors) {
                        console.log(result.errors);
                    }

                    showWatched.find('#slider_watched').addClass('catalog-slider swiper-container');
                    showWatched.find('.swiper-wrapper').html(result.html);

                    showWatched.removeClass('hidden');

                    let newSlider = new Swiper('#slider_watched', {
                        slidesPerView: 3,
                        spaceBetween: 15,
                        centerInsufficientSlides: false,
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

                    if ($(newSlider.params.el).length > 0) {
                        $(window).on('load resize', function () {
                            newSlider.update();
                        });

                        setTimeout(function () {
                            $('.tabs__item').click(function () {
                                newSlider.update();
                            });
                        }, 10);
                    }

                    // Избранное
                    add_favorite('#slider_watched .toggle-favorites');

                }
            });
        }

    }

});
