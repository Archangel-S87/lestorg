<?php

$classes = 'offer-item box';
$classes = get_field('text_layout') == 'left' ? $classes . ' text-left' : $classes . ' text-right';

$title = str_replace(['[', ']'], ['<span class="text-green">', '</span>'], get_field('title'));

?>

<div class="<?= $classes; ?>" style="background-image: url('<?= get_field('image'); ?>');">
    <div class="offer-item__wrapper">
        <div class="offer-item__wrap">
            <div class="offer-item__content">
                <h3><?= $title; ?></h3>
                <p><?= get_field('description'); ?></p>
            </div>
            <p class="offer-item__descr"><?= get_field('time_action'); ?></p>
            <div class="offer-item__action">
                <a href="#call-popup" data-popup class="btn btn_small"><?= get_field('button_label'); ?></a>
            </div>
        </div>
    </div>
</div>
