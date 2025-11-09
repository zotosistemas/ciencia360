<?php
namespace Ciencia360\Config;

class Config
{
    private static array $env = [];

    public static function load(string $path): void
    {
        if (!file_exists($path)) return;
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) continue;
            $parts = explode('=', $line, 2);
            if (count($parts) !== 2) continue;
            [$key, $value] = array_map('trim', $parts);
            self::$env[$key] = $value;
        }
    }

    public static function get(string $key, $default = null)
    {
        return self::$env[$key] ?? $default;
    }
}
