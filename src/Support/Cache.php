<?php
namespace Ciencia360\Support;

class Cache
{
    private string $path;
    private int $ttl;

    public function __construct(string $path, int $ttl = 600) {
        $this->path = rtrim($path, '/');
        $this->ttl  = $ttl;
        if (!is_dir($this->path)) { @mkdir($this->path, 0775, true); }
    }

    private function apcuEnabled(): bool {
        return function_exists('apcu_fetch') && (bool) ini_get('apc.enabled');
    }

    public function get(string $key) {
        $k = 'c360_' . md5($key);
        if ($this->apcuEnabled()) {
            $val = apcu_fetch($k, $ok);
            return $ok ? $val : null;
        }
        $file = "{$this->path}/{$k}.json";
        if (!file_exists($file)) return null;
        if (filemtime($file) + $this->ttl < time()) { @unlink($file); return null; }
        $json = @file_get_contents($file);
        return $json ? json_decode($json, true) : null;
    }

    public function set(string $key, $value): void {
        $k = 'c360_' . md5($key);
        if ($this->apcuEnabled()) {
            apcu_store($k, $value, $this->ttl);
            return;
        }
        $file = "{$this->path}/{$k}.json";
        @file_put_contents($file, json_encode($value), LOCK_EX);
        @touch($file, time());
    }
}
