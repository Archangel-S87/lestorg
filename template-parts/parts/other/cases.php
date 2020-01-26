<?php

$posts = get_posts([
    'numberposts' => 8,
    'post_type' => 'product',
    'tax_query' => [
        [
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => 'completed'
        ]
    ]
]);

if (!$posts) return;

?>

<div class="cases">
    <div class="container">
        <div class="title">
            <h2>Недавние объекты</h2>
        </div>
    </div>
    <div class="cases-grid">
        <div class="cases-grid__wrap">

            <?php foreach ($posts as $post) :
                setup_postdata($post);
                $product = wc_get_product($post);
                if (!$product) continue;
                $image_src = lt_woocommerce_get_thumbnail_image();
                if (!$image_src) continue;
                ?>
                <div class="cases-grid__col">
                    <a href="<?= $product->get_permalink(); ?>" class="case-item">
                        <div class="case-item__img" style="background-image: url('<?= $image_src; ?>');"></div>
                        <div class="case-item__content">
                            <div class="case-item__content-wrap">
                                <h6><?= $product->get_title(); ?></h6>
                                <p><?= $product->get_meta('locality_project'); ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>

        </div>
    </div>
    <div class="container">
        <div class="action-box">
            <a href="<?= get_term_link('completed', 'product_cat') ?>" class="btn btn_bd btn_more">Смотреть все проекты</a>
        </div>
    </div>
</div>
