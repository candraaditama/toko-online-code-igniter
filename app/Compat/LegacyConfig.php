<?php

namespace App\Compat;

/**
 * CodeIgniter 3 compatible config class, reading legacy array based config
 * files from app/Config/Legacy.
 */
class LegacyConfig
{
    /** @var array<string, array<string, mixed>> */
    protected array $loaded = [];

    /**
     * @return mixed|null
     */
    public function item($item, string $index = '')
    {
        $config = $this->load($index === '' ? 'config' : $index);

        return $config[$item] ?? null;
    }

    /**
     * @return array<string, mixed>
     */
    public function load(string $file = 'config', bool $use_sections = false, bool $fail_gracefully = false): array
    {
        $key = $file === '' ? 'config' : $file;

        if (isset($this->loaded[$key])) {
            return $this->loaded[$key];
        }

        $path   = APPPATH . 'Config/Legacy/' . $key . '.php';
        $config = [];

        if (is_file($path)) {
            include $path;
        }

        return $this->loaded[$key] = is_array($config) ? $config : [];
    }

    /**
     * @param mixed $value
     */
    public function set_item(string $item, $value): void
    {
        $this->loaded['config'][$item] = $value;
    }

    public function slash_item(string $item): ?string
    {
        $value = $this->item($item);

        return $value === null ? null : rtrim((string) $value, '/') . '/';
    }
}
