<?php

namespace App\Compat;

/**
 * Per-request registry for the legacy (CodeIgniter 3 style) application.
 */
class Registry
{
    public static ?LegacyController $controller = null;

    /** @var array<string, mixed> */
    protected static array $shared = [];

    /**
     * @return mixed|null
     */
    public static function get(string $key)
    {
        if ($key === 'db') {
            return self::db();
        }

        return self::$shared[$key] ?? null;
    }

    /**
     * @param mixed $value
     */
    public static function set(string $key, $value): void
    {
        self::$shared[$key] = $value;
    }

    public static function has(string $key): bool
    {
        return isset(self::$shared[$key]);
    }

    /**
     * @return \CodeIgniter\Database\BaseConnection
     */
    public static function db()
    {
        if (! isset(self::$shared['db'])) {
            self::$shared['db'] = \Config\Database::connect();
        }

        return self::$shared['db'];
    }
}
