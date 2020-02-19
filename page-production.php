<?php

get_header();

the_post();

?>

    <section class="production s-inner">
        <div class="container">

            <ul class="breadcrumbs">
                <li><a href="<?= home_url(); ?>" class="breadcrumbs__home"><i class="ic ic-home"></i> Главная</a></li>
                <li>Производство</li>
            </ul>

            <div class="title-inn">
                <h2><?php the_title(); ?></h2>
            </div>

            <div class="production__content content"><?php the_content(); ?></div>

            <div class="production__wrap">

                <?php if (have_rows('type_production')) : ?>
                    <?php while (have_rows('type_production')) : the_row(); ?>
                        <?php $title = get_sub_field('title'); ?>
                        <?php if (!$title) continue; ?>

                        <div class="production-item">
                            <div class="title">
                                <h3><?= esc_html($title); ?></h3>
                            </div>
                            <div class="content"><?php the_sub_field('description'); ?></div>

                            <?php if ($gallery = get_sub_field('gallery')) : ?>
                                <div class="gallery-slider">
                                    <div class="swiper-container js-gallery">
                                        <div class="swiper-wrapper">

                                            <?php foreach ($gallery as $image_id) : ?>

                                                <?php $full_image_url = wp_get_attachment_image_url($image_id, 'full'); ?>
                                                <?php $image_url = wp_get_attachment_image_url($image_id, 'woocommerce_thumbnail'); ?>

                                                <div class="swiper-slide">
                                                    <a href="<?= $full_image_url; ?>" class="gallery-slider__item"
                                                       style="background-image: url('<?= $image_url; ?>');"></a>
                                                </div>

                                            <?php endforeach; ?>

                                        </div>
                                        <div class="swiper-nav">
                                            <div class="swiper-button-prev"><i class="ic ic-left"></i></div>
                                            <div class="swiper-pagination"></div>
                                            <div class="swiper-button-next"><i class="ic ic-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php $video = get_sub_field('video'); ?>

                            <?php if ($url = $video['url']) : ?>
                                <div class="production-item__video">
                                    <a href="<?= esc_url($url); ?>" data-popup="iframe" class="video-box" style="background-image: url('<?= esc_url($video['preview'] ?: ''); ?>');"></a>
                                </div>
                            <?php endif; ?>

                        </div>

                    <?php endwhile; ?>
                <?php endif; ?>

            </div>

        </div>
    </section>

<?php

print_main_map();

print_feedback();

get_footer();
