<?php

namespace Zebba\Component\Loader;

interface LoaderInterface
{
    public static function parse($input, array $options = array());

    public static function dump($array, array $options = array());
} 