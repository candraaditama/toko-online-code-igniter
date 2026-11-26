<?php

namespace App\Compat;

/**
 * CodeIgniter 3 compatible URI class.
 */
class LegacyUri
{
    /**
     * @return array<int, string>
     */
    protected function segments(): array
    {
        $path = trim(service('request')->getPath(), '/');

        if ($path === '') {
            return [];
        }

        return explode('/', $path);
    }

    public function segment(int $n, ?string $no_result = null): ?string
    {
        $segments = $this->segments();

        return $segments[$n - 1] ?? $no_result;
    }

    public function segment_array(): array
    {
        return $this->segments();
    }

    public function total_segments(): int
    {
        return count($this->segments());
    }

    public function uri_string(): string
    {
        return implode('/', $this->segments());
    }

    public function ruri_string(): string
    {
        return $this->uri_string();
    }

    public function slash_segment(int $n, string $where = 'trailing'): string
    {
        $segment = (string) $this->segment($n);
        if ($segment === '') {
            return '';
        }

        $leading  = in_array($where, ['leading', 'both'], true) ? '/' : '';
        $trailing = in_array($where, ['trailing', 'both'], true) ? '/' : '';

        return $leading . $segment . $trailing;
    }
}
