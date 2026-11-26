<?php

/**
 * Bootstrap for the CodeIgniter 3 compatibility layer.
 *
 * Loaded from Composer's "files" autoload so that the legacy globals and class
 * aliases exist before any controller or model is loaded.
 */

defined('BASEPATH') || define('BASEPATH', dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'codeigniter4' . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR);

require_once __DIR__ . '/../Config/Legacy/constants.php';

if (! function_exists('get_instance')) {
    /**
     * Return the active legacy controller instance.
     *
     * @return \App\Compat\LegacyController|null
     */
    function &get_instance()
    {
        return \App\Compat\Registry::$controller;
    }
}

if (! class_exists('CI_Controller', false)) {
    class_alias(\App\Compat\LegacyController::class, 'CI_Controller');
}

if (! class_exists('CI_Model', false)) {
    class_alias(\App\Compat\LegacyModel::class, 'CI_Model');
}

if (! function_exists('config_item')) {
    /**
     * @return mixed|null
     */
    function config_item(string $item)
    {
        return (new \App\Compat\LegacyConfig())->item($item);
    }
}

if (! function_exists('html_escape')) {
    /**
     * @param mixed $var
     *
     * @return mixed
     */
    function html_escape($var, bool $double_encode = true)
    {
        if (is_array($var)) {
            return array_map(static fn ($value) => html_escape($value, $double_encode), $var);
        }

        if (! is_string($var)) {
            return $var;
        }

        return htmlspecialchars($var, ENT_QUOTES, 'UTF-8', $double_encode);
    }
}

if (! function_exists('show_error')) {
    /**
     * @return never
     */
    function show_error(string $message, int $status_code = 500, string $heading = 'An Error Was Encountered')
    {
        throw new \CodeIgniter\HTTP\Exceptions\HTTPException($message, $status_code);
    }
}

if (! function_exists('is_php')) {
    function is_php(string $version): bool
    {
        return version_compare(PHP_VERSION, $version, '>=');
    }
}

if (! function_exists('get_config')) {
    /**
     * @return array<string, mixed>
     */
    function get_config(?string $file = null): array
    {
        if (function_exists('config') && $file !== null) {
            $cfg = config($file);

            return is_object($cfg) ? get_object_vars($cfg) : (array) $cfg;
        }

        return (new \App\Compat\LegacyConfig())->load($file ?? 'config');
    }
}

if (! function_exists('legacy_redirect')) {
    /**
     * CodeIgniter 3 style redirect: sends the Location header and stops the
     * request, like CI3 did (CI4's legacy_redirect() returns a response object).
     */
    function legacy_redirect(string $uri = '', string $method = 'auto', ?int $code = null): void
    {
        $uri = str_replace(["\r", "\n", '%0d', '%0a'], '', $uri);

        if ($uri === '') {
            $uri = site_url();
        } elseif (! str_contains($uri, '://')) {
            $uri = site_url($uri);
        }

        if (! headers_sent()) {
            header('Location: ' . $uri, true, $code ?? 302);
        }

        exit;
    }
}

if (! function_exists('show_404')) {
    /**
     * CI3 compatible 404 handler.
     *
     * @return never
     */
    function show_404(string $page = '', bool $log_error = true)
    {
        if ($log_error) {
            log_message('error', '404 Page Not Found --> ' . $page);
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound($page);
    }
}
