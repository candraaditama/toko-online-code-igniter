<?php

/**
 * CodeIgniter 3 compatible form helpers.
 *
 * The legacy views were written against the CI3 form helper, whose function
 * signatures and validation error rendering differ from CodeIgniter 4.
 */

use App\Compat\LegacyFormValidation;

if (! function_exists('form_open')) {
    /**
     * @param array<string, mixed>|string $attributes
     * @param array<string, mixed> $hidden
     */
    function form_open(string $action = '', $attributes = [], array $hidden = []): string
    {
        return legacy_form_open($action, $attributes, $hidden, false);
    }
}

if (! function_exists('form_open_multipart')) {
    /**
     * @param array<string, mixed>|string $attributes
     * @param array<string, mixed> $hidden
     */
    function form_open_multipart(string $action = '', $attributes = [], array $hidden = []): string
    {
        return legacy_form_open($action, $attributes, $hidden, true);
    }
}

if (! function_exists('legacy_form_open')) {
    /**
     * @param array<string, mixed>|string $attributes
     * @param array<string, mixed> $hidden
     */
    function legacy_form_open(string $action, $attributes, array $hidden, bool $multipart): string
    {
        if ($action === '') {
            $action = base_url(uri_string());
        } elseif (! str_contains($action, '://')) {
            $action = base_url($action);
        }

        if (is_array($attributes)) {
            $atts = '';
            foreach ($attributes as $key => $value) {
                $atts .= ' ' . $key . '="' . html_escape($value) . '"';
            }
        } else {
            $atts = ' ' . (string) $attributes;
        }

        if (! str_contains(strtolower($atts), 'method=')) {
            $atts .= ' method="post"';
        }
        if (! str_contains(strtolower($atts), 'accept-charset=')) {
            $atts .= ' accept-charset="utf-8"';
        }
        if ($multipart && ! str_contains(strtolower($atts), 'enctype=')) {
            $atts .= ' enctype="multipart/form-data"';
        }

        $output = '<form action="' . html_escape($action) . '"' . $atts . '>';

        if ($hidden !== []) {
            $output .= form_hidden($hidden);
        }

        return $output;
    }
}

if (! function_exists('form_close')) {
    function form_close(string $extra = ''): string
    {
        return '</form>' . $extra;
    }
}

if (! function_exists('form_prep')) {
    function form_prep(string $str = '', bool $is_textarea = false): string
    {
        $str = html_escape($str, true);

        return $is_textarea ? $str : str_replace(['"', "'"], ['&quot;', '&#39;'], $str);
    }
}

if (! function_exists('form_hidden')) {
    /**
     * @param array<string, mixed>|string $name
     * @param mixed $value
     * @param string $recursing
     */
    function form_hidden($name, $value = '', $recursing = ''): string
    {
        if (! is_array($name)) {
            return '<input type="hidden" name="' . $name . '" value="' . form_prep((string) $value) . '" />';
        }

        $output = '';
        foreach ($name as $key => $val) {
            if (is_array($val)) {
                foreach ($val as $k => $v) {
                    $output .= '<input type="hidden" name="' . $key . '[' . $k . ']" value="' . form_prep((string) $v) . '" />';
                }
            } else {
                $output .= '<input type="hidden" name="' . $key . '" value="' . form_prep((string) $val) . '" />';
            }
        }

        return $output;
    }
}

if (! function_exists('form_input')) {
    /**
     * @param array<string, mixed>|string $data
     * @param string $value
     * @param string $extra
     */
    function form_input($data = '', string $value = '', string $extra = ''): string
    {
        if (is_array($data)) {
            $data['name'] ??= '';
            $data['id'] ??= $data['name'];
            $data['value'] ??= $value;
            $data['type'] ??= 'text';
            $atts = '';
            foreach ($data as $key => $val) {
                $atts .= ' ' . $key . '="' . form_prep((string) $val) . '"';
            }

            return '<input' . $atts . ($extra !== '' ? ' ' . $extra : '') . ' />';
        }

        return '<input type="text" name="' . $data . '" value="' . form_prep($value) . '"' . ($extra !== '' ? ' ' . $extra : '') . ' />';
    }
}

if (! function_exists('form_textarea')) {
    /**
     * @param array<string, mixed>|string $data
     * @param string $value
     * @param string $extra
     */
    function form_textarea($data = '', string $value = '', string $extra = ''): string
    {
        if (is_array($data)) {
            $data['name'] ??= '';
            $data['id'] ??= $data['name'];
            $val = $data['value'] ?? $value;
            unset($data['value']);
            $atts = '';
            foreach ($data as $key => $v) {
                $atts .= ' ' . $key . '="' . form_prep((string) $v) . '"';
            }

            return '<textarea' . $atts . ($extra !== '' ? ' ' . $extra : '') . '>' . form_prep((string) $val, true) . '</textarea>';
        }

        return '<textarea name="' . $data . '"' . ($extra !== '' ? ' ' . $extra : '') . '>' . form_prep($value, true) . '</textarea>';
    }
}

if (! function_exists('form_submit')) {
    function form_submit(string $name = '', string $value = 'Submit', string $extra = ''): string
    {
        return '<input type="submit" name="' . $name . '" value="' . form_prep($value) . '"' . ($extra !== '' ? ' ' . $extra : '') . ' />';
    }
}

if (! function_exists('form_close_tag')) {
    function form_close_tag(): string
    {
        return '</form>';
    }
}

if (! function_exists('set_value')) {
    /**
     * @param mixed $default
     */
    function set_value(string $field, $default = ''): string
    {
        $request = service('request');

        if ($request->getMethod() === 'post') {
            $value = $request->getPost($field) ?? $default;
        } else {
            $value = $request->getGet($field) ?? $default;
        }

        return form_prep((string) (is_array($value) ? $default : $value));
    }
}

if (! function_exists('set_select')) {
    /**
     * @param mixed $value
     */
    function set_select(string $field, string $value = '', bool $default = false): string
    {
        $request = service('request');
        $posted  = $request->getMethod() === 'post' ? $request->getPost($field) : $request->getGet($field);

        if ($posted === null) {
            return $default ? ' selected="selected"' : '';
        }

        return (string) $posted === (string) $value ? ' selected="selected"' : '';
    }
}

if (! function_exists('set_checkbox')) {
    function set_checkbox(string $field, string $value = '', bool $default = false): string
    {
        $request = service('request');
        $posted  = $request->getMethod() === 'post' ? $request->getPost($field) : $request->getGet($field);

        if ($posted === null) {
            return $default ? ' checked="checked"' : '';
        }

        return (string) $posted === (string) $value ? ' checked="checked"' : '';
    }
}

if (! function_exists('set_radio')) {
    function set_radio(string $field, string $value = '', bool $default = false): string
    {
        return set_checkbox($field, $value, $default);
    }
}

if (! function_exists('validation_errors')) {
    function validation_errors(string $prefix = '<p>', string $suffix = '</p>'): string
    {
        // Jangan tampilkan error validasi pada kunjungan biasa (GET),
        // hanya setelah formulir dikirim.
        if (strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            return '';
        }

        $errors = LegacyFormValidation::lastErrors();

        if ($errors === []) {
            return '';
        }

        $output = '';
        foreach ($errors as $error) {
            $output .= $prefix . $error . $suffix;
        }

        return $output;
    }
}

if (! function_exists('form_error')) {
    function form_error(string $field, string $prefix = '<p>', string $suffix = '</p>'): string
    {
        $errors = LegacyFormValidation::lastErrors();

        return isset($errors[$field]) ? $prefix . $errors[$field] . $suffix : '';
    }
}

if (! function_exists('form_dropdown')) {
    /**
     * @param array<string, mixed>|string $name
     * @param array<string, mixed> $options
     * @param array<int, string>|string $selected
     * @param string $extra
     */
    function form_dropdown($name = '', array $options = [], $selected = [], string $extra = ''): string
    {
        $selected = is_array($selected) ? $selected : [$selected];

        $output = '<select name="' . $name . '"' . ($extra !== '' ? ' ' . $extra : '') . '>';
        foreach ($options as $value => $label) {
            $isSelected = in_array((string) $value, array_map('strval', $selected), true) ? ' selected="selected"' : '';
            $output .= '<option value="' . html_escape((string) $value) . '"' . $isSelected . '>' . html_escape((string) $label) . '</option>';
        }

        return $output . '</select>';
    }
}
