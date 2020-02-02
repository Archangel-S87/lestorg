<?php

the_post();

add_filter('body_class', 'add_classes_single_post');
function add_classes_single_post($classes) {
    $classes[] = 'page-post';
    return $classes;
}

get_header();

?>

<div class="post s-inner">
    <div class="container">

        <ul class="breadcrumbs">
            <li><a href="<?= get_home_url(); ?>" class="breadcrumbs__home"><i class="ic ic-home"></i> Главная</a>
            </li>
            <li><a href="<?= get_home_url(null, 'articles'); ?>">Статьи</a></li>
            <li><?php the_title(); ?></li>
        </ul>

        <div id="primary" class="content-area">
            <main id="main" class="site-main">

                <div class="title-inn">
                    <h2><?= the_title(); ?></h2>
                </div>

                <div class="content content-area"><?php the_content(); ?></div>

            </main><!-- #main -->
        </div><!-- #primary -->

    </div>
</div>


<?php

get_footer();
