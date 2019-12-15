<?php

namespace GameserverApp\Interfaces;

interface ModelTransformerInterface
{
    public static function model(array $args);

    public static function transformableInput($args);
}