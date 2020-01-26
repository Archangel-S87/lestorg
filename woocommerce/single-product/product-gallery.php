<?php

defined('ABSPATH') || exit;

if (empty($images)) return;

$wrapper_classes = apply_filters('lt_single_product_gallery_classes', ['product-gallery', 'box']);

?>

<div class="<?php echo esc_attr(implode(' ', $wrapper_classes)); ?>">

    <?php // Видно везде. img средний размер. Ссылка орегинальный размер ?>
    <div class="product-gallery__slider swiper-container js-gallery">
        <div class="swiper-wrapper">

            <?php foreach ($images as $image) : ?>
                <div class="swiper-slide">
                    <a href="<?= $image['sizes']['full']; ?>" class="product-gallery__img img-box" style="background-image: url('<?= $image['sizes']['woocommerce_single']; ?>')">
                    </a>
                </div>
            <?php endforeach; ?>

        </div>
        <div class="swiper-pagination"></div>
    </div>

    <?php // Видно на PC. Выводить маленькие иконки ?>
    <div class="product-gallery__thumbs swiper-container">
        <div class="swiper-wrapper">

            <?php foreach ($images as $image) : ?>
                <div class="swiper-slide">
                    <div class="product-gallery__thumb" style="background-image: url('<?= $image['sizes']['thumbnail']; ?>')">
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>

</div>
