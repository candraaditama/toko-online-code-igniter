<?php

namespace App\Compat;

use CodeIgniter\Session\Session;

/**
 * CodeIgniter 3 compatible session class backed by the CI4 session service.
 */
class LegacySession
{
    protected Session $session;

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config = [])
    {
        $this->session = \Config\Services::session();

        if (session_status() !== PHP_SESSION_ACTIVE) {
            $this->session->start();
        }
    }

    /**
     * @return Session
     */
    public function instance(): Session
    {
        return $this->session;
    }

    /**
     * @param array<string, mixed>|string $key
     * @param mixed $value
     */
    public function set_userdata($key, $value = null): void
    {
        if (is_array($key)) {
            $this->session->set($key);

            return;
        }

        $this->session->set($key, $value);
    }

    /**
     * @return mixed|null
     */
    public function userdata($key = null)
    {
        if ($key === null) {
            return $this->session->get();
        }

        return $this->session->get($key);
    }

    public function has_userdata(string $key): bool
    {
        return $this->session->has($key);
    }

    /**
     * @param string|string[]|null $key
     */
    public function unset_userdata($key): void
    {
        foreach ((array) $key as $name) {
            $this->session->remove($name);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function all_userdata(): array
    {
        return (array) $this->session->get();
    }

    /**
     * @param array<string, mixed>|string $key
     * @param mixed $value
     */
    public function set_flashdata($key, $value = null): void
    {
        if (is_array($key)) {
            foreach ($key as $name => $val) {
                $this->session->setFlashdata($name, $val);
            }

            return;
        }

        $this->session->setFlashdata($key, $value);
    }

    /**
     * @return mixed|null
     */
    public function flashdata($key = null)
    {
        if ($key === null) {
            return $this->session->getFlashdata();
        }

        return $this->session->getFlashdata($key);
    }

    /**
     * @param string|string[] $key
     */
    public function keep_flashdata($key): void
    {
        foreach ((array) $key as $name) {
            $this->session->keepFlashdata($name);
        }
    }

    /**
     * @param string|string[] $key
     */
    public function unset_flashdata($key): void
    {
        foreach ((array) $key as $name) {
            $this->session->unsetFlashdata($name);
        }
    }

    public function regenerate_id(bool $destroy = false): void
    {
        $this->session->regenerate($destroy);
    }

    public function sess_destroy(): void
    {
        $this->session->destroy();
    }
}
