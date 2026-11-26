<?php

namespace App\Compat;

/**
 * CodeIgniter 3 compatible model base (global alias CI_Model).
 */
#[\AllowDynamicProperties]
class LegacyModel
{
    /**
     * @return mixed|null
     */
    public function __get($name)
    {
        if ($name === 'load') {
            $loader     = new LegacyLoader($this);
            $this->load = $loader;

            return $loader;
        }

        $shared = Registry::get($name);
        if ($shared !== null) {
            $this->{$name} = $shared;

            return $shared;
        }

        $services = [
            'input'           => static fn () => new LegacyInput(),
            'uri'             => static fn () => new LegacyUri(),
            'config'          => static fn () => new LegacyConfig(),
            'session'         => static fn () => new LegacySession(),
            'form_validation' => static fn () => new LegacyFormValidation(),
            'cart'            => static fn () => new LegacyCart(),
        ];

        if (isset($services[$name])) {
            $service = $services[$name]();
            Registry::set($name, $service);
            $this->{$name} = $service;

            return $service;
        }

        $model = 'App\\Models\\' . ucfirst($name);
        if (class_exists($model)) {
            return $this->load->model($name);
        }

        return null;
    }

    public function __isset($name)
    {
        return $this->__get($name) !== null;
    }
}
