<?php

class My_acf {

    public function __construct()
    {
        $this->hooks();
    }

    private function hooks()
    {
        /*
         * Тип записи для места расположения /product_attributes
         */
        //add_filter('acf/location/rule_types', [$this, 'location_rules_types']);
        //add_filter('acf/location/rule_values/page_type', [$this, 'location_rule_values_page_type']);
        //add_filter('acf/location/rule_match', [$this, 'location_rule_match_page'], 10, 3);
    }

    public function location_rules_types($choices)
    {
        return $choices;
    }

    public function location_rule_values_page_type($choices)
    {
        $choices['product_attributes'] = 'Атрибут товара';
        return $choices;
    }

    public function location_rule_match_page($match, $rule, $options)
    {
        $taxonomy = $_GET['taxonomy'] ?? '';
        $tag_ID = $_GET['tag_ID'] ?? '';
        return strripos($taxonomy, 'pa_') !== false && !$tag_ID;
    }

}

$My_acf = new My_acf();
