<?php

namespace App\Compat;

/**
 * CodeIgniter 3 compatible form validation class.
 *
 * Rule syntax matches CI3: "required|min_length[3]|valid_email".
 */
class LegacyFormValidation
{
    protected static ?self $lastInstance = null;

    /** @var array<string, array{label: string, rules: string}> */
    protected array $rules = [];

    /** @var array<string, string> */
    protected array $errors = [];

    /** @var array<string, mixed> */
    protected array $data = [];

    /** @var array<string, string> */
    protected array $messages = [];

    /**
     * @param array<int, array<int, string>>|string $field
     * @param string $label
     * @param string|array<int, string> $rules
     *
     * @return $this
     */
    public function set_rules($field, $label = '', $rules = '')
    {
        if (is_array($field)) {
            foreach ($field as $row) {
                $this->set_rules($row[0] ?? '', $row[1] ?? '', $row[2] ?? '');
            }

            return $this;
        }

        if ($field === '') {
            return $this;
        }

        if (is_array($rules)) {
            $rules = implode('|', $rules);
        }

        $this->rules[$field] = [
            'label' => $label !== '' ? $label : $field,
            'rules' => (string) $rules,
        ];

        return $this;
    }

    /**
     * @param array<string, mixed>|string $lang
     * @param string $val
     *
     * @return $this
     */
    public function set_message($lang, $val = '')
    {
        if (is_array($lang)) {
            foreach ($lang as $key => $message) {
                $this->messages[$key] = $message;
            }

            return $this;
        }

        $this->messages[$lang] = $val;

        return $this;
    }

    /**
     * @return $this
     */
    public function set_error(string $field, string $error)
    {
        $this->errors[$field] = $error;

        return $this;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function set_data(array $data): void
    {
        $this->data = $data;
    }

    public function run($group = '', $action = ''): bool
    {
        $this->errors = [];
        $this->data   = service('request')->getPost() ?? [];

        foreach ($this->rules as $field => $rule) {
            $value    = $this->data[$field] ?? null;
            $is_array = is_array($value);
            $string   = $is_array ? implode(',', $value) : (string) ($value ?? '');

            foreach (explode('|', $rule['rules']) as $single) {
                if ($single === '') {
                    continue;
                }

                $param = null;
                if (preg_match('/^([a-z_]+)\[(.*)\]$/i', $single, $matches)) {
                    $single = $matches[1];
                    $param  = $matches[2];
                }

                if ($single === 'xss_clean' || $single === 'trim' || $single === 'prep_for_form') {
                    continue;
                }

                $error = $this->check($field, $rule['label'], $single, $param, $string, $value, $is_array);

                if ($error !== null) {
                    $this->errors[$field] = $error;
                    break;
                }
            }
        }

        self::$lastInstance = $this;

        return $this->errors === [];
    }

    /**
     * @param mixed $value
     */
    protected function check(string $field, string $label, string $rule, ?string $param, string $string, $value, bool $isArray): ?string
    {
        $failed = static fn (string $message): ?string => $message;

        switch ($rule) {
            case 'required':
                if ($isArray ? $value === [] : trim($string) === '') {
                    return $failed($this->message($field, $label, 'required', 'The %s field is required.'));
                }

                return null;

            case 'matches':
                if ($string !== (string) ($this->data[$param] ?? '')) {
                    return $failed($this->message($field, $label, 'matches', 'The %s field does not match the %s field.'));
                }

                return null;

            case 'min_length':
                if ($string !== '' && mb_strlen($string) < (int) $param) {
                    return $failed($this->message($field, $label, 'min_length', 'The %s field must be at least %s characters in length.'));
                }

                return null;

            case 'max_length':
                if (mb_strlen($string) > (int) $param) {
                    return $failed($this->message($field, $label, 'max_length', 'The %s field cannot exceed %s characters in length.'));
                }

                return null;

            case 'exact_length':
                if ($string !== '' && mb_strlen($string) !== (int) $param) {
                    return $failed($this->message($field, $label, 'exact_length', 'The %s field must be exactly %s characters in length.'));
                }

                return null;

            case 'valid_email':
                if ($string !== '' && ! filter_var($string, FILTER_VALIDATE_EMAIL)) {
                    return $failed($this->message($field, $label, 'valid_email', 'The %s field must contain a valid email address.'));
                }

                return null;

            case 'valid_emails':
                if ($string !== '') {
                    foreach (explode(',', $string) as $email) {
                        if (! filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
                            return $failed($this->message($field, $label, 'valid_emails', 'The %s field must contain all valid email addresses.'));
                        }
                    }
                }

                return null;

            case 'numeric':
                if ($string !== '' && ! is_numeric($string)) {
                    return $failed($this->message($field, $label, 'numeric', 'The %s field must contain only numbers.'));
                }

                return null;

            case 'integer':
                if ($string !== '' && ! preg_match('/^[\-+]?[0-9]+$/', $string)) {
                    return $failed($this->message($field, $label, 'integer', 'The %s field must contain an integer.'));
                }

                return null;

            case 'decimal':
                if ($string !== '' && ! preg_match('/^[\-+]?[0-9]+\.[0-9]+$/', $string)) {
                    return $failed($this->message($field, $label, 'decimal', 'The %s field must contain a decimal number.'));
                }

                return null;

            case 'is_natural':
                if ($string !== '' && ! preg_match('/^[0-9]+$/', $string)) {
                    return $failed($this->message($field, $label, 'is_natural', 'The %s field must contain only positive numbers.'));
                }

                return null;

            case 'is_natural_no_zero':
                if ($string !== '' && (! preg_match('/^[0-9]+$/', $string) || (int) $string === 0)) {
                    return $failed($this->message($field, $label, 'is_natural_no_zero', 'The %s field must contain a number greater than zero.'));
                }

                return null;

            case 'alpha':
                if ($string !== '' && ! preg_match('/^[a-zA-Z]+$/', $string)) {
                    return $failed($this->message($field, $label, 'alpha', 'The %s field may only contain alphabetical characters.'));
                }

                return null;

            case 'alpha_numeric':
                if ($string !== '' && ! preg_match('/^[a-zA-Z0-9]+$/', $string)) {
                    return $failed($this->message($field, $label, 'alpha_numeric', 'The %s field may only contain alpha-numeric characters.'));
                }

                return null;

            case 'alpha_dash':
                if ($string !== '' && ! preg_match('/^[a-zA-Z0-9_\-]+$/', $string)) {
                    return $failed($this->message($field, $label, 'alpha_dash', 'The %s field may only contain alpha-numeric characters, underscores, and dashes.'));
                }

                return null;

            case 'alpha_numeric_spaces':
                if ($string !== '' && ! preg_match('/^[a-zA-Z0-9 ]+$/', $string)) {
                    return $failed($this->message($field, $label, 'alpha_numeric_spaces', 'The %s field may only contain alpha-numeric characters and spaces.'));
                }

                return null;

            case 'valid_url':
                if ($string !== '' && ! filter_var($string, FILTER_VALIDATE_URL)) {
                    return $failed($this->message($field, $label, 'valid_url', 'The %s field must contain a valid URL.'));
                }

                return null;

            case 'greater_than':
                if ($string !== '' && (float) $string <= (float) $param) {
                    return $failed($this->message($field, $label, 'greater_than', 'The %s field must contain a number greater than %s.'));
                }

                return null;

            case 'less_than':
                if ($string !== '' && (float) $string >= (float) $param) {
                    return $failed($this->message($field, $label, 'less_than', 'The %s field must contain a number less than %s.'));
                }

                return null;

            case 'in_list':
                $list = explode(',', (string) $param);
                if ($string !== '' && ! in_array($string, $list, true)) {
                    return $failed($this->message($field, $label, 'in_list', 'The %s field must be one of: %s.'));
                }

                return null;

            case 'regex_match':
                if ($string !== '' && @preg_match('/' . $param . '/', $string) !== 1) {
                    return $failed($this->message($field, $label, 'regex_match', 'The %s field is not in the correct format.'));
                }

                return null;

            case 'is_unique':
                [$table, $column] = array_pad(explode('.', (string) $param), 2, '');
                if ($table !== '' && $column !== '' && $string !== '') {
                    $db  = Registry::db();
                    $row = $db->table($table)->where($column, $string)->countAllResults();
                    if ($row > 0) {
                        return $failed($this->message($field, $label, 'is_unique', 'The %s field must contain a unique value.'));
                    }
                }

                return null;
        }

        return null;
    }

    protected function message(string $field, string $label, string $rule, string $default): string
    {
        $message = $this->messages[$field . '.' . $rule]
            ?? $this->messages[$rule]
            ?? $default;

        return str_replace(['%s', '%1$s'], [$label, $label], $message);
    }

    /**
     * @return array<string, string>
     */
    public function error_array(): array
    {
        return $this->errors;
    }

    public function error(string $field, string $prefix = '', string $suffix = ''): string
    {
        return isset($this->errors[$field]) ? $prefix . $this->errors[$field] . $suffix : '';
    }

    public function errors(string $prefix = '', string $suffix = ''): string
    {
        return $this->validation_errors($prefix, $suffix);
    }

    public function validation_errors(string $prefix = '', string $suffix = ''): string
    {
        if ($this->errors === []) {
            return '';
        }

        $output = '';
        foreach ($this->errors as $error) {
            $output .= $prefix . $error . $suffix;
        }

        return $output;
    }

    public function error_string(string $prefix = '', string $suffix = ''): string
    {
        return $this->validation_errors($prefix, $suffix);
    }

    /**
     * @return array<string, string>
     */
    public static function lastErrors(): array
    {
        return self::$lastInstance?->errors ?? [];
    }
}
