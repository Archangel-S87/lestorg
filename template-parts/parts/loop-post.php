<?php

global $post;

$cats = get_the_category();
$title_cat = $cats[0] ? $cats[0]->name : '';

?>

<div class="news-grid__col">
    <div class="news-item box">
        <a href="<?php the_permalink(); ?>" class="news-item__img"
           style="background-image: url('<?= get_the_post_thumbnail_url(); ?>');"></a>
        <div class="news-item__main">
            <div class="news-item__title">
                <h3 class="news-item__head"><a href="<?php the_permalink(); ?>" class="link-head"><?php the_title(); ?></a></h3>
                <div class="news-item__info">
                    <p class="news-item__info-item text-green"><?= get_the_date(); ?></p>
                    <p class="news-item__info-item"><?= $title_cat; ?></p>
                </div>
            </div>
            <p class="news-item__descr"><?= wp_trim_words(get_the_content(), 30); ?></p>
            <div class="news-item__btn">
                <a href="<?php the_permalink(); ?>" class="btn btn_bd btn_little">Подробнее</a>
            </div>
        </div>
    </div>
</div>
