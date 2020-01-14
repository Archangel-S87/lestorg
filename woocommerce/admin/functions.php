<?php

function lt_get_attached_attrs_cat_product($taxonomies) {
    global $post;

    $product = wc_get_product($post);
    $rel_attrs = get_option(WC_LT_Attributes::option_name, []);
    if (!$product || !$rel_attrs) return $taxonomies;

    $cats = get_the_terms($product->get_id(), 'product_cat');
    $cat = (isset($cats[0]) && $cats[0]->slug !== 'uncategorized') ? $cats[0] : null;
    if (!$cat) return $taxonomies;

    $new_taxonomies = [];
    foreach ($taxonomies as $taxonomy) {
        $rel_attr = $rel_attrs[$taxonomy->attribute_id] ?? [];
        if (!$rel_attr && !in_array($cat->term_id, $rel_attr)) continue;
        $new_taxonomies[] = $taxonomy;
    }

    return $new_taxonomies;
}
