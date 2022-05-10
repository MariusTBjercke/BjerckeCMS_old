<?php

abstract class Singleton
{
    private static array $instances = [];

    protected function __construct() {}

    public static function getInstance() {
        $class = static::class;

        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }

        return self::$instances[$class];
    }

    /**
     * Should not be cloneable.
     *
     */
    private function __clone() {}

    /**
     * Should not be restorable.
     *
     */
    public function __wakeup() {}
}