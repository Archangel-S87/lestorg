<?php

$current_term = get_queried_object();
$current_term_link = get_term_link($current_term->term_id, 'product_cat');

if (is_wp_error($current_term_link)) {
    $current_term_link = '';
}

global $wp;
if ('' == get_option('permalink_structure')) {
    $form_action = remove_query_arg(array('page', 'paged'), add_query_arg($wp->query_string, '', home_url($wp->request)));
} else {
    $form_action = preg_replace('%\/page/[0-9]+%', '', home_url(trailingslashit($wp->request)));
}

$custom_filter = $_GET['custom_filter'] ?? 1;
$min_price = $_GET['min_price'] ?? 0;
$max_price = $_GET['max_price'] ?? '2000000';
$min_ploshhad = $_GET['min_ploshhad'] ?? '0';
$max_ploshhad = $_GET['max_ploshhad'] ?? '200';
$etazhnost = $_GET['etazhnost'] ?? 1;

$ee = 0;

//echo do_shortcode('[woof]');

?>

<div class="filter box">
    <div class="filter__top">
        <h3 class="filter__head">Подбор проекта</h3>
        <a href="#" class="filter__del"><i class="ic ic-bin"></i> Сбросить фильтр</a>
    </div>
    <form id="big_filter_product" class="filter__grid" role="search" action="<?= $current_term_link; ?>">
        <input type="hidden" name="term_id" value="<?= $current_term->term_id; ?>"/>
        <div class="filter__col">
            <div class="filter-item">
                <p class="filter-item__place">По цене, ₽</p>
                <div class="filter-fields">
                    <label class="filter-fields__item" data-text="От">
                        <input name="min_price" type="text" class="filter-field" value="<?= $min_price; ?>">
                    </label>
                    <label class="filter-fields__item" data-text="До">
                        <input name="max_price" type="text" class="filter-field" value="<?= $max_price; ?>">
                    </label>
                </div>
            </div>
        </div>
        <div class="filter__col">
            <div class="filter-item">
                <p class="filter-item__place">По площади, м<sup>2</sup></p>
                <div class="filter-fields">
                    <label class="filter-fields__item" data-text="От">
                        <input name="min_ploshhad" type="text" class="filter-field" value="<?= $min_ploshhad; ?>">
                    </label>
                    <label class="filter-fields__item" data-text="До">
                        <input name="max_ploshhad" type="text" class="filter-field" value="<?= $max_ploshhad; ?>">
                    </label>
                </div>
            </div>
        </div>
        <div class="filter__col" data-small>
            <div class="filter-item">
                <p class="filter-item__place">По этажности</p>
                <label for="">
                    <select name="etazhnost" value="<?= $etazhnost; ?>">
                        <option value="1">Одноэтажные</option>
                        <option value="2">Двухэтажные</option>
                    </select>
                </label>
            </div>
        </div>
        <div class="filter__col" data-small>
            <button class="btn btn_bd btn_filter">Подобрать</button>
        </div>
    </form>
</div>
