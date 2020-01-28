<?php

if (!defined('ABSPATH')) exit;

$catalog_orderby_options = $catalog_orderby_options ?? [];
$orderby = $orderby ?? '';

$catalog_order_by_options = [];
foreach ($catalog_orderby_options as $name => $label) {
    if (!$label) continue;
    $catalog_order_by_options[$name] = $label;
}

$order_by = explode('-', $orderby);
$order = $order_by[1] ?? '';
$order_by = $order_by[0];

?>

<form id="sort_product" class="sort" method="get">
    <input type="hidden" name="paged" value="1"/>
    <input id="sort_product_input" type="hidden" name="orderby" value="<?= $orderby; ?>">
    <?php wc_query_string_form_fields(null, ['orderby', 'submit', 'paged', 'product-page']); ?>
    <div class="sort__grid">
        <p class="sort__head">Сортировать по:</p>
        <?php
        foreach ($catalog_order_by_options as $name => $label) :
            $classes = ['sort__item'];
            if ($name == $order_by) {
                $classes[] = 'active';
                if (!$order) {
                    $classes[] = 'active_2';
                }
            }
            ?>
            <a href="#" class="<?= implode(' ', $classes); ?>" data-orderby="<?= $name; ?>"><u><?= $label; ?></u></a>
        <?php endforeach; ?>

    </div>
</form>
