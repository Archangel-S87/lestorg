<?php

$reviews = get_field('different_reviews', 'option') ?: [];

if (!$reviews) return;

?>

<div class="reviews">
    <div class="container">
        <div class="title">
            <h2>Отзывы клиентов</h2>
        </div>
    </div>

    <div class="reviews-slider swiper-container">
        <div class="swiper-wrapper">

            <?php foreach ($reviews as $review) : ?>
                <div class="swiper-slide">
                    <a href="<?= esc_url($review['url']); ?>" data-popup="iframe" class="video-box"
                       style="background-image: url('<?= $review['preview']; ?>');"></a>
                </div>
            <?php endforeach; ?>

        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"><i class="ic ic-left"></i></div>
        <div class="swiper-button-next"><i class="ic ic-right"></i></div>
    </div>
</div>
