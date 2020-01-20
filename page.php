<?php

get_header();

if (have_posts()) {

    while (have_posts()) {
        the_post();
        get_template_part('template-parts/content', get_post_format());
    }

    the_posts_pagination([
        'prev_text' => __('Previous page', 'twentysixteen'),
        'next_text' => __('Next page', 'twentysixteen'),
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'twentysixteen') . ' </span>',
    ]);

} else {

    get_template_part('template-parts/content', 'none');

}

get_footer();
