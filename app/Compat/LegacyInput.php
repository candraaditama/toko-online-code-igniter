<?php

namespace App\Compat;

/**
 * CodeIgniter 3 compatible input class.
 */
class LegacyInput
{
    /** @var \CodeIgniter\HTTP\IncomingRequest */
    protected $request;

    public function __construct()
    {
        $this->request = service('request');
    }

    /**
     * @return mixed
     */
    public function post($index = null, bool $xss_clean = false)
    {
        if ($index === null) {
            return $this->request->getPost() ?? [];
        }

        return $this->request->getPost($index);
    }

    /**
     * @return mixed
     */
    public function get($index = null, bool $xss_clean = false)
    {
        if ($index === null) {
            return $this->request->getGet() ?? [];
        }

        return $this->request->getGet($index);
    }

    /**
     * @return mixed
     */
    public function post_get($index)
    {
        $value = $this->post($index);
        if ($value === null) {
            $value = $this->get($index);
        }

        return $value;
    }

    /**
     * @return mixed
     */
    public function server($index = '', bool $xss_clean = false)
    {
        $index = strtoupper((string) $index);
        $server = $this->request->getServer();

        if ($index === '') {
            return $server;
        }

        return $server[$index] ?? null;
    }

    /**
     * @return mixed
     */
    public function cookie($index = null)
    {
        if ($index === null) {
            return $this->request->getCookie() ?? [];
        }

        return $this->request->getCookie($index);
    }

    public function method(bool $upper = false): string
    {
        $method = $this->request->getMethod();

        return $upper ? strtoupper($method) : strtolower($method);
    }

    public function is_ajax_request(): bool
    {
        return $this->request->isAJAX();
    }

    public function ip_address(): string
    {
        return $this->request->getIPAddress();
    }

    public function user_agent(): string
    {
        return (string) $this->request->getUserAgent()->getAgentString();
    }

    /**
     * @return string|null
     */
    public function get_request_header(string $index, bool $xss_clean = false)
    {
        return $this->request->getHeaderLine($index) ?: null;
    }
}
