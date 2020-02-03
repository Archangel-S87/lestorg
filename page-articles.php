<?php

$query = new WP_Query([
    'numberposts' => 0,
    'tax_query' => [
        [
            'taxonomy' => 'category',
            'terms' => 1,
            'operator' => 'NOT IN'
        ]
    ],
    'posts_per_page' => 20,
    'paged' => get_query_var('paged') ?? 1
]);

$pagination = [
    'current' => get_query_var('paged') ?: 1,
    'add_args' => false,
    'prev_text' => '<i class="ic ic-first"></i>',
    'next_text' => '<i class="ic ic-last"></i>',
    'type' => 'list',
    'total' => $query->max_num_pages,
    'end_size' => 3,
    'mid_size' => 3
];

add_filter('body_class', 'add_classes_archive_post');
function add_classes_archive_post($classes) {
    $classes[] = 'page-news';
    return $classes;
}

get_header();

?>

<div class="news s-inner">
    <div class="container">

        <ul class="breadcrumbs">
            <li><a href="<?= get_home_url(); ?>" class="breadcrumbs__home"><i class="ic ic-home"></i> Главная</a></li>
            <li>Статьи</li>
        </ul>

        <div id="primary" class="content-area">
            <main id="main" class="site-main">

                <div class="title-inn">
                    <h2>Полезные статьи</h2>
                </div>

                <?php if ($query->have_posts()) : ?>

                    <div class="news-grid">
                        <?php while ($query->have_posts()) : ?>
                            <?php $query->the_post(); ?>
                            <?php get_template_part('template-parts/parts/loop', 'post'); ?>
                        <?php endwhile; ?>
                    </div>

                    <nav class="pagination">
                        <?= paginate_links($pagination); ?>
                        <?= get_next_posts_link('Следующая страница', $query->max_num_pages); ?>
                    </nav>

                    <?php wp_reset_postdata(); ?>

                <?php endif; ?>

            </main><!-- #main -->
        </div><!-- #primary -->

    </div>
</div>

<?php

get_footer();
