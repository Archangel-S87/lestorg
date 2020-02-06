<?php

global $post;

$offers = get_posts([
    'post_type' => 'offer',
    'numberposts' => -1
]);

?>

<div class="offers">
    <div class="container">
        <div class="offers-slider swiper-container">
            <div class="swiper-wrapper">
                <?php foreach ($offers as $post) : ?>
                    <?php setup_postdata($post); ?>
                    <div class="swiper-slide">
                        <?php get_template_part('template-parts/parts/loop', 'offer'); ?>
                    </div>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
            </div>
            <div class="swiper-nav">
                <div class="swiper-button-prev"><i class="ic ic-left"></i></div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"><i class="ic ic-right"></i></div>
            </div>
        </div>
    </div>
</div>
