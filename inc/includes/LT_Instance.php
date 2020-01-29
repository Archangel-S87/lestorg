<?php


trait LT_Instance
{
    protected static $instance = false;

    public static function get_instance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function __construct()
    {
    }
}
