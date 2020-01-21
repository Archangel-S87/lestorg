<?php

// Дополнительные поля на страницк атрибуты


class WC_LT_Attributes
{
    const option_name = '_wc_lt_attributes_list_categories';

    private $field = [];

    public function __construct($field = [])
    {
        $this->field = wp_parse_args($field, [
            'taxonomy' => 'product_cat',
            'field_type' => 'checkbox',
            'input_name' => 'list_categories',
            'value' => []
        ]);

        $this->hooks();
    }

    private function hooks()
    {
        // Выводит дополнительное поле с категориями товаров
        add_action('woocommerce_after_add_attribute_fields', [$this, 'add_attribute_field_product_categories']);
        add_action('woocommerce_after_edit_attribute_fields', [$this, 'edit_attribute_field_product_categories']);

        // Сохранение атрибутов
        add_action('woocommerce_attribute_added', [$this, 'save_attribute']);
        add_action('woocommerce_attribute_updated', [$this, 'save_attribute']);
    }

    public function save_attribute($attr_id)
    {
        $list_categories = $_POST['list_categories'] ?? [];

        $option_list_categories = get_option(self::option_name, []);

        $option_list_categories[$attr_id] = $list_categories;

        update_option(self::option_name, $option_list_categories, false);
    }

    private function render_categories()
    {
        $edit = isset($_GET['edit']) ? absint($_GET['edit']) : 0;

        $field = $this->field;

        if ($edit) {
            $list_categories = get_option(self::option_name);
            $field['value'] = $list_categories[$edit] ?? [];
        }

        $input_name = $field['input_name'];
        $field['name'] = $field['field_type'] == 'checkbox' ? $input_name . '[]' : $input_name;

        require_once get_template_directory() . '/walkers/LT_Walker_Taxonomy.php';

        echo '<input type="hidden" name="' . $field['input_name'] . '">' . PHP_EOL;

        echo '<input type="hidden" name="list_categories">' . PHP_EOL;
        echo '<ul class="checkbox-list acf-bl">'. PHP_EOL;

        wp_list_categories([
            'taxonomy' => $field['taxonomy'],
            'hide_empty' => false,
            'depth' => 3,
            'style' => 'none',
            'walker' => new LT_Walker_Taxonomy($field),
        ]);

        echo '</ul>' . PHP_EOL;
    }

    public function add_attribute_field_product_categories()
    {
        ?>
        <div class="form-field">
            <label for="list_categories">Список объектов</label>
            <div class="wrapper-list-categories add-attribute">
                <?php $this->render_categories(); ?>
            </div>
            <p class="description">Атрибут буден виден на странице товара отмеченой категории</p>
        </div>
        <?php
    }

    public function edit_attribute_field_product_categories()
    {
        ?>
        <tr class="form-field">
            <th>
                <label for="list_categories">Список объектов</label>
            </th>
            <td>
                <div class="wrapper-list-categories edit-attribute">
                    <?php $this->render_categories(); ?>
                </div>
                <p class="description">Атрибут буден виден на странице товара отмеченой категории</p>
            </td>
        </tr>
        <?php
    }
}

$WC_LT_Attributes = new WC_LT_Attributes();
