<?php

get_header();

the_post();

?>

<div class="about s-inner">
    <div class="container">

        <ul class="breadcrumbs">
            <li><a href="<?= home_url(); ?>" class="breadcrumbs__home"><i class="ic ic-home"></i> Главная</a></li>
            <li>О нас</li>
        </ul>

        <div class="title-inn">
            <h2><?php the_title(); ?></h2>
        </div>

        <div class="about-box box">
            <div class="about-box__wrapper">
                <div class="about-box__wrap">
                    <img src="<?= get_img('img/logo.svg'); ?>" alt="" class="about-box__logo">
                </div>
            </div>
            <img src="<?= get_img('img/about/about-img.png'); ?>" alt="" class="about-box__img">
        </div>

    </div>
</div>

<?php print_company_in_numbers(); ?>

<div class="about-content">
    <div class="container">
        <div class="about-content__grid">
            <div class="about-content__img box">
                <div class="about-content__img-wrap">
                    <div class="title">
                        <h2>Собственное производство</h2>
                    </div>
                </div>
            </div>
            <div class="about-content__wrap">
                <div class="title">
                    <h2>о компании</h2>
                </div>
                <div class="content">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

print_main_map();

print_feedback();

get_footer();
