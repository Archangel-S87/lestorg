<?php if (!$product_object = $product_object ?? null) return; ?>

<div id="general_product_data" class="panel woocommerce_options_panel">
    <div class="options_group location">

        <?php
        woocommerce_wp_text_input([
            'id' => '_locality_project',
            'value' => $product_object->get_meta('locality_project', true, 'edit'),
            'label' => 'Населённый пункт',
            'description' => 'Пример: д. Климотино'
        ]);

        woocommerce_wp_text_input([
            'id' => '_cords_project',
            'value' => $product_object->get_meta('cords_project', true, 'edit'),
            'label' => 'Координаты проекта',
            'description' => 'Координаты проекта на карте Яндекс<br> Пример: 56.34325900455667, 44.035097843539496'
        ]);
        ?>

    </div>
</div>
