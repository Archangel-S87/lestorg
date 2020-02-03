<?php


trait Lestorg_Instance
{
    protected static $instance = false;

    public static function instance(): self
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
