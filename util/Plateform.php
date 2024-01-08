<?php
namespace Util;

class Plateform
{
    public static function transform_path(string $path) {
        $delimiters = ['/', '\\'];

        return str_replace($delimiters, DIRECTORY_SEPARATOR, $path);
    }
}