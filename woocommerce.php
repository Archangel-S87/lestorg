<?php

get_header();

/**
 * Hook: lestorg_before_woocommerce_content
 *
 */
do_action('lestorg_before_woocommerce_content');

?>

<div class="<?= implode(' ', apply_filters('lestorg_woocommerce_wrapper_class', ['s-inner'])); ?>">
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

        LT()->content->woocommerce_content();

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

/**
 * Hook: lestorg_after_woocommerce_content
 *
 * @hooked print_bottom_wc_archive - 10
 */
do_action('lestorg_after_woocommerce_content');

get_footer();
