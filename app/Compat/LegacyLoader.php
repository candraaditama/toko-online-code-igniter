<?php

namespace App\Compat;

/**
 * CodeIgniter 3 compatible loader ($this->load).
 */
class LegacyLoader
{
    protected object $owner;

    /** @var array<string, class-string> */
    protected array $libraryMap = [
        'm_db'            => \App\Libraries\M_db::class,
        'm_file'          => \App\Libraries\M_file::class,
        'rajaongkir'      => \App\Libraries\Rajaongkir::class,
        'elfinder_lib'    => \App\Libraries\Elfinder_lib::class,
        'cart'            => LegacyCart::class,
        'session'         => LegacySession::class,
        'form_validation' => LegacyFormValidation::class,
        'upload'          => LegacyUpload::class,
        'image_lib'       => LegacyImageLib::class,
        'dbutil'          => LegacyDbutil::class,
        'dbforge'         => LegacyDbforge::class,
    ];

    public function __construct(object $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @param array<string, mixed> $vars
     *
     * @return string|void
     */
    public function view(string $view, array $vars = [], bool $return = false)
    {
        if (method_exists($this->owner, 'renderLegacyView')) {
            return $this->owner->renderLegacyView($view, $vars, $return);
        }

        $file = APPPATH . 'Views/' . trim($view, '/') . '.php';
        if (! is_file($file)) {
            throw new \RuntimeException('Legacy view not found: ' . $view);
        }

        unset($vars['this']);
        extract($vars, EXTR_SKIP);

        ob_start();
        include $file;
        $output = ob_get_clean();

        if ($return) {
            return $output;
        }

        echo $output;
    }

    public function model(string $model, string $name = '')
    {
        $key      = 'model:' . strtolower($model);
        $instance = Registry::get($key);

        if ($instance === null) {
            $class = 'App\\Models\\' . ucfirst($model);
            if (! class_exists($class)) {
                throw new \RuntimeException('Unable to locate the model: ' . $model);
            }

            $instance = new $class();
            Registry::set($key, $instance);
        }

        $property           = $name !== '' ? $name : $model;
        $this->owner->{$property} = $instance;

        return $instance;
    }

    /**
     * @param mixed $params
     *
     * @return object
     */
    public function library(string $library, $params = null, string $name = '')
    {
        $key      = 'lib:' . strtolower($library);
        $instance = Registry::get($key);

        if ($instance === null) {
            $class = $this->libraryMap[strtolower($library)] ?? null;

            if ($class === null) {
                $class = 'App\\Libraries\\' . ucfirst($library);
                if (! class_exists($class)) {
                    throw new \RuntimeException('Unable to locate the library: ' . $library);
                }
            }

            $instance = $params === null ? new $class() : new $class($params);
            Registry::set($key, $instance);
        } elseif (is_array($params) && method_exists($instance, 'initialize')) {
            $instance->initialize($params);
        }

        $property           = $name !== '' ? $name : strtolower($library);
        $this->owner->{$property} = $instance;

        return $instance;
    }

    /**
     * @param string|string[] $helpers
     */
    public function helper($helpers): void
    {
        helper($helpers);
    }

    public function database($params = '', bool $return = false, $query_builder = null)
    {
        return Registry::db();
    }

    public function dbutil(bool $return = false)
    {
        $util = new LegacyDbutil();
        if (! $return) {
            $this->owner->dbutil = $util;
        }

        return $util;
    }

    public function dbforge(bool $return = false)
    {
        $forge = new LegacyDbforge();
        if (! $return) {
            $this->owner->dbforge = $forge;
        }

        return $forge;
    }

    /**
     * @param array<string, mixed> $config
     */
    public function config(string $file = '', bool $use_sections = false, bool $fail_gracefully = false)
    {
        $file = $file === '' ? 'config' : $file;

        return (new LegacyConfig())->load($file);
    }

    /**
     * @param array<string, mixed>|string $vars
     * @param mixed $value
     */
    public function vars($vars, $value = null): void
    {
        if (is_array($vars)) {
            foreach ($vars as $key => $val) {
                $this->owner->legacyViewData[$key] = $val;
            }

            return;
        }

        $this->owner->legacyViewData[$vars] = $value;
    }

    public function file(string $path): bool
    {
        if (! is_file($path)) {
            return false;
        }

        include $path;

        return true;
    }

    /**
     * @param string|string[] $file
     */
    public function language($file = '', string $lang = ''): void
    {
    }

    /**
     * @param mixed $params
     */
    public function driver(string $library, $params = null, string $name = '')
    {
        return $this->library($library, $params, $name);
    }
}
