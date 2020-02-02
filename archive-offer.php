<?php get_header(); ?>

<div class="product s-inner">
    <div class="container">

        <ul class="breadcrumbs">
            <li><a href="<?= get_home_url(); ?>" class="breadcrumbs__home"><i class="ic ic-home"></i> Главная</a></li>
            <li>Акции</li>
        </ul>

        <div id="primary" class="content-area">
            <main id="main" class="site-main">

                <div class="title-inn">
                    <h2>Актуальные акции компании</h2>
                </div>

                <div class="offers-wrap">
                    <?php if (have_posts()) : ?>
                        <?php while (have_posts()) : ?>
                            <?php the_post(); ?>
                            <?php get_template_part('template-parts/parts/loop', 'offer'); ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>

            </main><!-- #main -->
        </div><!-- #primary -->

    </div>
</div>

<?php

get_footer();
