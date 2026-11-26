<?php

namespace App\Compat;

/**
 * Minimal CI3 output class shim.
 */
class LegacyOutput
{
    protected string $output = '';

    public function append_output(string $output): self
    {
        $this->output .= $output;

        return $this;
    }

    public function set_output(string $output): self
    {
        $this->output = $output;

        return $this;
    }

    public function get_output(): string
    {
        return $this->output;
    }

    public function set_header(string $header, string $replace = 'true'): void
    {
        header($header, $replace !== 'false');
    }

    public function set_status_header(int $code, string $text = ''): void
    {
        http_response_code($code);
    }

    public function set_content_type(string $mime_type = 'text/html'): self
    {
        header('Content-Type: ' . $mime_type);

        return $this;
    }
}
