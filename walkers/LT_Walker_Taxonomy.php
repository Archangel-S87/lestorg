<?php


class LT_Walker_Taxonomy extends Walker
{
    public $field = null;
    public $tree_type = 'category';
    public $db_fields = [
        'parent' => 'parent',
        'id' => 'term_id'
    ];

    function __construct($field)
    {
        $this->field = $field;
    }

    function start_el(&$output, $term, $depth = 0, $args = array(), $current_object_id = 0)
    {
        $selected = in_array($term->term_id, $this->field['value']);

        $output .= '<li><label>' . PHP_EOL;
        $output .= '<input type="' . $this->field['field_type'] . '" name="' . $this->field['name'] . '" value="' . $term->term_id . '" ' . checked($selected, 1, false) . '>' . PHP_EOL;
        $output .= '<span>' . $term->name . '</span>' . PHP_EOL;
        $output .= '</label>';
    }

    function end_el(&$output, $term, $depth = 0, $args = array())
    {
        $output .= '</li>' . PHP_EOL;
    }

    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $output .= '<ul class="children acf-bl">' . PHP_EOL;
    }

    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $output .= '</ul>' . PHP_EOL;
    }
}
