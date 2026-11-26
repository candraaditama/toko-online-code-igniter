<?php

namespace App\Compat;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * CodeIgniter 3 compatible controller base.
 *
 * Legacy controllers are ported unchanged: they extend the global CI_Controller
 * alias of this class and call parent::__construct().
 */
#[\AllowDynamicProperties]
class LegacyController extends Controller
{
    protected bool $legacyBooted = false;

    /** @var array<string, mixed> */
    protected array $legacyViewData = [];

    public function __construct()
    {
        $this->request  = service('request');
        $this->response = service('response');
        $this->logger   = service('logger');

        $this->bootLegacy();
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param LoggerInterface $logger
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->bootLegacy();
    }

    protected function bootLegacy(): void
    {
        if ($this->legacyBooted) {
            return;
        }

        $this->legacyBooted           = true;
        Registry::$controller         = $this;
        $this->load                   = new LegacyLoader($this);

        // Libraries that CodeIgniter 3 autoloads on every request.
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('cart');
    }

    /**
     * Resolve legacy services, models and libraries on demand.
     *
     * @return mixed|null
     */
    public function __get($name)
    {
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

        // Auto-load a model that was referenced without load->model().
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

    /**
     * Render a legacy view file. Rendering happens inside this controller so
     * that $this inside the view refers to the controller, exactly like CI3.
     *
     * @param array<string, mixed> $vars
     *
     * @return string|void
     */
    public function renderLegacyView(string $view, array $vars = [], bool $return = false)
    {
        $file = APPPATH . 'Views/' . trim($view, '/') . '.php';

        if (! is_file($file)) {
            throw new \RuntimeException('Legacy view not found: ' . $view);
        }

        $vars = array_merge($this->legacyViewData, $vars);
        unset($vars['this']);

        extract($vars, EXTR_SKIP);

        ob_start();
        include $file;
        $output = ob_get_clean();

        if ($return) {
            return $output;
        }

        echo $output;

        if (! isset($this->output)) {
            $this->output = new \App\Compat\LegacyOutput();
        }
        $this->output->append_output($output);

        return null;
    }
}
