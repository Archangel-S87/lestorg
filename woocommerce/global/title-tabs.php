<?php

$current_term = get_queried_object();
$parent_term = get_term($current_term->parent, 'product_cat');

if (!$parent_term || is_wp_error($parent_term)) return;

$all_terms = get_term_children($parent_term->term_id, 'product_cat');

?>

<div class="title-tabs">
    <div class="title-tabs__grid">
        <div class="title-tabs__content">
            <h2><?= $parent_term->name; ?></h2>
        </div>
        <div class="title-tabs__wrap">
            <div class="tabs">
                <button class="tabs__toggle">
                    <span class="tabs__toggle-text">Выбрать</span>
                    <i class="tabs__toggle-icon ic ic-bottom"></i>
                </button>
                <div class="tabs__grid">
                    <?php foreach ($all_terms as $term) :
                        $class = 'tabs__item';
                        $class = $term == $current_term->term_id ? $class . ' active' : $class;
                        $term = get_term($term, 'product_cat');
                        $link = get_term_link($term->term_id, 'product_cat');
                        $label = $term->description;
                        echo '<a href="'. $link . '" class="' . $class . '">' . $label . '</a>';
                    endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
