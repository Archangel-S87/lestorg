<?php

/*
 * Общий трейт для шаблонов
 */


trait Lestorg_Hooks
{
    protected $filters = [];
    protected $actions = [];

    private $default_filters = [];
    private $default_actions = [];

    protected function add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1)
    {
        $int = has_filter($tag, $function_to_add);
        if ($int != $priority) {
            add_filter($tag, $function_to_add, $priority, $accepted_args);
            $this->filters[] = [
                'tag' => $tag,
                'function_to_add' => $function_to_add,
                'priority' => $priority
            ];
        }
    }

    protected function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1)
    {
        $int = has_action($tag, $function_to_add);
        if ($int != $priority) {
            add_action($tag, $function_to_add, $priority, $accepted_args);
            $this->actions[] = [
                'tag' => $tag,
                'function_to_add' => $function_to_add,
                'priority' => $priority
            ];
        }
    }

    public function reset()
    {
        foreach ($this->filters as $filter) {
            remove_filter($filter['tag'], $filter['function_to_add'], $filter['priority']);
        }
        foreach ($this->actions as $action) {
            remove_action($action['tag'], $action['function_to_add'], $action['priority']);
        }
        $this->filters = [];
        $this->actions =[];
    }

    public function run() {}
}
