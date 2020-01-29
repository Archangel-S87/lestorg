<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>

    <meta name="description" content="404">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php wp_head(); ?>
</head>

<body class="page-error">
<div id="wrapper">
    <div id="wrapper__wrap">

        <div id="wrapper__overlay"></div>

        <div id="wrapper__main">

            <section class="s-error">
                <div class="container">
                    <div class="s-error__grid">
                        <div class="s-error__img">
                            <img src="<?= get_img('img/error.svg'); ?>" alt="">
                        </div>
                        <div class="s-error__main">
                            <div class="s-error__title">
                                <h1>404</h1>
                                <h4 class="text-green">Упс.. Страница не найдена</h4>
                            </div>
                            <div class="content">
                                <p>Страница, на которую Вы пытаетесь попасть, не существует или была удалена</p>
                            </div>
                            <div class="s-error__action">
                                <a href="<?= home_url(); ?>" class="btn btn_button">Вернуться на главную</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div><!-- #wrapper__main -->

    </div><!-- #wrapper__wrap -->
</div><!-- #wrapper -->

</body>
</html>
