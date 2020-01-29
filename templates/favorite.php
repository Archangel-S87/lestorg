<?php

/*
Template Name: Избранное
Template Post Type: page
*/

get_header();
the_post();

$product_ids = [];
foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
    $product_ids[] = $cart_item['product_id'];
}

$WC_LT_Content = WC_LT_Content::get_instance();
$WC_LT_Content->set_class_template('WC_LT_Category_Tabs');

$class_template = $WC_LT_Content->get_class_template();
$class_template->run();

remove_action('woocommerce_before_shop_loop', [$class_template, 'set_title'], 20);
remove_action('woocommerce_before_shop_loop', [$class_template, 'filter_projects'], 20);

add_action('woocommerce_before_shop_loop', 'favorite_set_title', 20);
function favorite_set_title() {
    echo '<div class="title text-left"><h2>' . get_the_title() . '</h2></div>';
}

$shortcode = new WC_Shortcode_Products([
    'ids' => implode(', ', $product_ids),
    'paginate' => true,
    'cache' => false,
    'limit' => $class_template->get_current_count_cards()
]);

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

        echo $shortcode->get_content();

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
