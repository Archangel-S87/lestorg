<?php

$default = $default ?? [];
$values = $values ?? [];

if (!$default || !$values) return;

$min_price = $_GET['min_price'] ?? 0;
$max_price = $_GET['max_price'] ?? '2000000';
$min_ploshhad = $_GET['min_ploshhad'] ?? '0';
$max_ploshhad = $_GET['max_ploshhad'] ?? '200';
$etazhnost = $_GET['etazhnost'] ?? 1;

$hidden_exclude = array_keys($default);
$hidden_exclude[] = 'paged';
$hidden_exclude[] = 'submit';
$hidden_exclude[] = 'product-page';

?>

<div class="filter box">

    <div class="filter__top">
        <h3 class="filter__head">Подбор проекта</h3>
        <a href="#" class="filter__del"><i class="ic ic-bin"></i> Сбросить фильтр</a>
    </div>

    <form id="filter_product" class="filter__grid" method="get">
        <input type="hidden" name="paged" value="1"/>
        <input type="hidden" name="filter" value="<?= $default['filter']; ?>">

        <?php wc_query_string_form_fields(null, $hidden_exclude); ?>

        <div class="filter__col">
            <div class="filter-item">
                <p class="filter-item__place">По цене, ₽</p>
                <div class="filter-fields">
                    <label class="filter-fields__item" data-text="От">
                        <input id="filter_min_price" type="text" class="filter-field" value="<?= $values['min_price']; ?>" data-default="<?= $default['min_price']; ?>">
                    </label>
                    <label class="filter-fields__item" data-text="До">
                        <input id="filter_max_price" type="text" class="filter-field" value="<?= $values['max_price']; ?>" data-default="<?= $default['max_price']; ?>">
                    </label>
                </div>
            </div>
        </div>

        <div class="filter__col">
            <div class="filter-item">
                <p class="filter-item__place">По площади, м<sup>2</sup></p>
                <div class="filter-fields">
                    <label class="filter-fields__item" data-text="От">
                        <input id="filter_min_ploshhad" type="text" class="filter-field" value="<?= $values['min_ploshhad']; ?>" data-default="<?= $default['min_ploshhad']; ?>">
                    </label>
                    <label class="filter-fields__item" data-text="До">
                        <input id="filter_max_ploshhad" type="text" class="filter-field" value="<?= $values['max_ploshhad']; ?>" data-default="<?= $default['max_ploshhad']; ?>">
                    </label>
                </div>
            </div>
        </div>

        <div class="filter__col" data-small>
            <div class="filter-item">
                <p class="filter-item__place">По этажности</p>
                <label>
                    <select id="filter_etazhnost" data-default="<?= $default['etazhnost']; ?>">
                        <?php foreach ([1 => 'Одноэтажные', 2 => 'Двухэтажные'] as $key => $label) : ?>
                            <option value="<?= $key; ?>" <?php selected($values['etazhnost'], $key); ?>><?= $label; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>
        </div>

        <div class="filter__col" data-small>
            <button type="submit" class="btn btn_bd btn_filter">Подобрать</button>
        </div>

    </form>

</div>
