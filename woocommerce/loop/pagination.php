<?php

if (!defined('ABSPATH')) {
    exit;
}

$total = isset($total) ? $total : wc_get_loop_prop('total_pages');
$current = isset($current) ? $current : wc_get_loop_prop('current_page');
$base = isset($base) ? $base : esc_url_raw(str_replace(999999999, '%#%', remove_query_arg('add-to-cart', get_pagenum_link(999999999, false))));
$format = isset($format) ? $format : '';

if ($total <= 1) {
    return;
}

add_filter('next_posts_link_attributes', function ($attrs) {
    return 'class="pagination__more"';
});

?>

<nav class="pagination">
    <?php
    echo paginate_links(apply_filters('woocommerce_pagination_args', array( // WPCS: XSS ok.
        'base' => $base,
        'format' => $format,
        'add_args' => false,
        'current' => max(1, $current),
        'total' => $total,
        'prev_text' => '<i class="ic ic-first"></i>',
        'next_text' => '<i class="ic ic-last"></i>',
        'type' => 'list',
        'end_size' => 3,
        'mid_size' => 3
    )));
    echo get_next_posts_link('Следующая страница');
    ?>
    <!--    <div class="pagination__count">-->
    <!--        <p class="pagination__count-head">На странице</p>-->
    <!--        <label class="pagination__count-select">-->
    <!--            <select>-->
    <!--                <option>9</option>-->
    <!--                <option>12</option>-->
    <!--                <option>15</option>-->
    <!--                <option>18</option>-->
    <!--                <option>21</option>-->
    <!--            </select>-->
    <!--        </label>-->
    <!--    </div>-->
</nav>
