<?php

$terms = $other_options = get_field('front_page_popular_projects', 'option');

if (!$terms) return;

add_filter('lestorg_wc_product_wrap_loop', 'set_product_loop_in_swiper', 20);

?>

<div class="popular">
    <div class="container">

        <div class="title">
            <h2>Популярные проекты</h2>
        </div>

        <div class="tabs">
            <button class="tabs__toggle">
                <span class="tabs__toggle-text">Выбрать</span>
                <i class="tabs__toggle-icon ic ic-bottom"></i>
            </button>
            <div class="tabs__grid">
                <?php foreach ($terms as $term) : ?>
                    <a href="#" class="tabs__item"><?= $term->name; ?></a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="tabs-wrap">

            <?php
            foreach ($terms as $term) :

                $term_id = $term->term_id;

                $posts = get_posts([
                    'numberposts' => 3,
                    'tax_query' => [
                        [
                            'taxonomy' => 'product_cat',
                            'terms' => $term_id
                        ]
                    ],
                    'post_type' => 'product',
                    'orderby' => 'rand'
                ]);

                if (!$posts) continue;

                LT()->content->get_loop_class_template($term_id)->run();

                ?>

                <div class="tabs-wrap__item">
                    <div class="catalog-slider swiper-container">
                        <div class="swiper-wrapper">

                            <?php
                            foreach ($posts as $post) :
                                setup_postdata($post);
                                wc_get_template_part('content', 'product');
                            endforeach;
                            ?>

                        </div>
                        <div class="swiper-nav">
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>

                    <div class="action-box">
                        <a href="<?= get_term_link($term); ?>" class="btn btn_bd btn_more">Смотреть все проекты</a>
                    </div>

                </div>

                <?php  LT()->content->get_loop_class_template($term_id)->reset(); ?>

            <?php endforeach; ?>

        </div>

    </div>
</div>
