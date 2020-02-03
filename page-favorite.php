<?php

get_header();
the_post();

$product_ids = [];
foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
    $product_ids[] = $cart_item['product_id'];
}

if ($product_ids) {

    // Показывать товары только из нужных категорий
    $categories = get_terms([
        'taxonomy' => 'product_cat',
        'fields' => 'ids',
        'slug' => ['doma', 'bani', 'besedki']
    ]);;

    $content = LT()->content;
    $content->set_loop_class_template('Lestorg_Loop_Main');

    $class_template = $content->get_loop_class_template($categories[0]);
    $class_template->run();

    remove_action('woocommerce_before_shop_loop', [$class_template, 'set_title'], 20);
    remove_action('woocommerce_before_shop_loop', [$class_template, 'filter_projects'], 20);

    $content = new WC_Shortcode_Products([
        'ids' => implode(', ', $product_ids),
        'category' => implode(', ', $categories),
        'paginate' => true,
        'cache' => false,
        'limit' => $class_template->get_current_count_cards()
    ]);

}

add_action('woocommerce_before_shop_loop', 'favorite_set_title', 20);
function favorite_set_title() {
    echo '<div class="title text-left"><h2>' . get_the_title() . '</h2></div>';
}

// Выводить товары с ценой
add_filter('woocommerce_shortcode_products_query', 'remove_product_has_not_price');
function remove_product_has_not_price($query_args) {
    $query_args['meta_query'] = [
        [
            'key' => '_price',
            'value' => 0,
            'compare' => '>',
            'type'    => 'NUMERIC'
        ]
    ];
    return $query_args;
}

?>

<div class="<?= implode(' ', apply_filters('lt_woocommerce_wrapper_class', ['s-inner'])); ?>">
    <div class="container">
        <?php

        /**
         * Hook: woocommerce_before_main_content.
         *
         * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
         * @hooked woocommerce_breadcrumb - 20
         * @hooked WC_Structured_Data::generate_website_data() - 30
         */
        do_action('woocommerce_before_main_content');

        if ($product_ids) {
            echo $content->get_content();
        } else {
            echo '<div class="title text-left"><h2>' . get_the_title() . '</h2></div>';
            echo '<p>Здесь пока ничего нет.</p>';
        }

        /**
         * Hook: woocommerce_after_main_content.
         *
         * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
         */
        do_action('woocommerce_after_main_content');

        ?>
    </div>
</div>

<?php

get_footer();
