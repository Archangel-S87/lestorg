<?php

if (!defined('ABSPATH')) {
    exit;
}

$total = $total ?? wc_get_loop_prop('total_pages');
$current = $current ?? wc_get_loop_prop('current_page');
$base = $base ?? esc_url_raw(str_replace(999999999, '%#%', remove_query_arg('add-to-cart', get_pagenum_link(999999999, false))));
$format = $format ?? '';

if ($total <= 1) {
    return;
}

$args = apply_filters('woocommerce_pagination_args', [ // WPCS: XSS ok.
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
]);

add_filter('next_posts_link_attributes', function ($attrs) {
    return 'class="pagination__more"';
});

$category_template = WC_LT_Content::get_instance()->get_class_template();
$count_cards = $category_template->get_count_cards();
$current_count_cards = $count_cards['current_count_cards'];
$count_cards = $count_cards['count_cards'];

?>

<nav class="pagination">
    <?php
    echo paginate_links($args);
    echo get_next_posts_link('Следующая страница');
    ?>
    <form id="pagination_count" class="pagination__count" method="get">
        <input type="hidden" name="paged" value="1"/>
        <?php wc_query_string_form_fields(null, ['count_cards', 'submit', 'paged', 'product-page']); ?>
        <p class="pagination__count-head">На странице</p>
        <label class="pagination__count-select">
            <select id="pagination_count_select" name="count_cards">
                <?php foreach ($count_cards as $value) : ?>
                    <option value="<?= $value; ?>" <?php selected($current_count_cards, $value); ?>><?= $value; ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </form>
</nav>
