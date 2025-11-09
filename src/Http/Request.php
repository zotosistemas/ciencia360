<?php
namespace Ciencia360\Http;

class Request
{
    public static function get(string $key, $default = null): ?string
    {
        return isset($_GET[$key]) ? trim((string)$_GET[$key]) : $default;
    }
}
