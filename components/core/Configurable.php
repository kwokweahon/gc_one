<?php

namespace components\core;

interface Configurable
{
    /**
     * @param $object
     * @param array $properties  this object properties
     * @return mixed
     */
    public static function configure($object, $properties);
}
