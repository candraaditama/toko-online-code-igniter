<?php

namespace App\Compat;

/**
 * CodeIgniter 3 compatible file upload class.
 */
class LegacyUpload
{
    /** @var array<string, mixed> */
    public array $config = [
        'upload_path'   => '',
        'allowed_types' => '',
        'file_name'     => '',
        'file_ext_tolower' => false,
        'overwrite'     => false,
        'max_size'      => 0,
        'max_width'     => 0,
        'max_height'    => 0,
        'min_width'     => 0,
        'min_height'    => 0,
        'max_filename'  => 0,
        'remove_spaces' => true,
        'encrypt_name'  => false,
        'file_ext'      => '',
    ];

    /** @var array<string, mixed> */
    protected array $data = [];

    /** @var string[] */
    protected array $errors = [];

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config = [])
    {
        $this->initialize($config);
    }

    /**
     * @param array<string, mixed> $config
     */
    public function initialize(array $config = []): void
    {
        $this->config = array_merge($this->config, $config);
        $this->errors = [];
        $this->data   = [];
    }

    public function do_upload(string $field = 'userfile'): bool
    {
        $this->errors = [];

        if (! isset($_FILES[$field])) {
            $this->errors[] = 'You did not select a file to upload.';

            return false;
        }

        $file = $_FILES[$field];

        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            $this->errors[] = $this->uploadErrorMessage((int) $file['error']);

            return false;
        }

        $uploadPath = rtrim((string) $this->config['upload_path'], '/\\') . DIRECTORY_SEPARATOR;
        if ($uploadPath === DIRECTORY_SEPARATOR || ! is_dir($uploadPath)) {
            $this->errors[] = 'The upload path does not appear to be valid.';

            return false;
        }

        $origName = (string) $file['name'];
        $ext      = strtolower(pathinfo($origName, PATHINFO_EXTENSION));

        if ($this->config['file_ext_tolower']) {
            $ext = strtolower($ext);
        }

        if (($file['size'] ?? 0) === 0) {
            $this->errors[] = 'The file you are attempting to upload is empty.';

            return false;
        }

        $maxSize = (int) $this->config['max_size'];
        if ($maxSize > 0 && $file['size'] > $maxSize * 1024) {
            $this->errors[] = 'The file you are attempting to upload is larger than the permitted size.';

            return false;
        }

        if (! $this->isAllowedType($ext, $origName)) {
            $this->errors[] = 'The filetype you are attempting to upload is not allowed.';

            return false;
        }

        [$width, $height] = @getimagesize($file['tmp_name']) ?: [0, 0];
        $isImage = $width > 0 && $height > 0;

        if ($isImage) {
            foreach (['max_width' => $width, 'max_height' => $height] as $key => $actual) {
                $limit = (int) $this->config[$key];
                if ($limit > 0 && $actual > $limit) {
                    $this->errors[] = 'The image you are attempting to upload exceeds the maximum ' . ($key === 'max_width' ? 'width' : 'height') . ' allowed.';

                    return false;
                }
            }

            foreach (['min_width' => $width, 'min_height' => $height] as $key => $actual) {
                $limit = (int) $this->config[$key];
                if ($limit > 0 && $actual < $limit) {
                    $this->errors[] = 'The image you are attempting to upload does not meet the minimum ' . ($key === 'min_width' ? 'width' : 'height') . ' allowed.';

                    return false;
                }
            }
        }

        $baseName = (string) $this->config['file_name'];
        $rawName  = $baseName !== '' ? $baseName : pathinfo($origName, PATHINFO_FILENAME);

        if ($this->config['remove_spaces']) {
            $rawName = str_replace(' ', '-', $rawName);
        }

        if ($this->config['encrypt_name']) {
            $rawName = md5(uniqid((string) mt_rand(), true));
        }

        $maxFilename = (int) $this->config['max_filename'];
        if ($maxFilename > 0) {
            $rawName = substr($rawName, 0, $maxFilename);
        }

        $fileName = ($ext === '') ? $rawName : $rawName . '.' . $ext;
        $target   = $uploadPath . $fileName;

        if (! $this->config['overwrite'] && file_exists($target)) {
            $i = 1;
            do {
                $fileName = $rawName . '_' . $i . ($ext === '' ? '' : '.' . $ext);
                $target   = $uploadPath . $fileName;
                $i++;
            } while (file_exists($target) && $i < 1000);
        }

        if (is_uploaded_file($file['tmp_name'])) {
            $moved = @move_uploaded_file($file['tmp_name'], $target);
        } else {
            $moved = @copy($file['tmp_name'], $target);
        }

        if (! $moved) {
            $this->errors[] = 'The file could not be written to disk.';

            return false;
        }

        @chmod($target, 0644);

        $this->data = [
            'file_name'      => $fileName,
            'file_type'      => $file['type'] ?? '',
            'file_path'      => $uploadPath,
            'full_path'      => $target,
            'raw_name'       => $rawName,
            'orig_name'      => $origName,
            'client_name'    => $origName,
            'file_ext'       => $ext === '' ? '' : '.' . $ext,
            'file_size'      => round(((int) ($file['size'] ?? 0)) / 1024, 2),
            'is_image'       => $isImage,
            'image_width'    => $width,
            'image_height'   => $height,
            'image_type'     => $isImage ? (string) (exif_imagetype($target) ?: '') : '',
            'image_size_str' => $isImage ? 'width="' . $width . '" height="' . $height . '"' : '',
        ];

        return true;
    }

    protected function isAllowedType(string $ext, string $origName): bool
    {
        $allowed = (string) $this->config['allowed_types'];

        if ($allowed === '' || $allowed === '*') {
            return true;
        }

        $allowed = str_replace('|', ',', $allowed);

        foreach (explode(',', $allowed) as $type) {
            $type = strtolower(trim($type));
            if ($type === '') {
                continue;
            }

            if ($type === $ext) {
                return true;
            }

            if (str_contains($type, '/') && str_starts_with($type, 'image/') && @getimagesize($origName) === false) {
                // mime style type: fall through to MIME detection below
            }
        }

        $mime = @mime_content_type($origName);
        if ($mime !== false && str_contains($allowed, '/') && str_contains($allowed, $mime)) {
            return true;
        }

        return false;
    }

    protected function uploadErrorMessage(int $code): string
    {
        return match ($code) {
            UPLOAD_ERR_INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
            UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
            UPLOAD_ERR_PARTIAL    => 'The uploaded file was only partially uploaded.',
            UPLOAD_ERR_NO_FILE    => 'You did not select a file to upload.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.',
            default               => 'The file could not be uploaded.',
        };
    }

    /**
     * @return mixed
     */
    public function data(string $key = '')
    {
        if ($key === '') {
            return $this->data;
        }

        return $this->data[$key] ?? null;
    }

    public function display_errors(string $open = '', string $close = ''): string
    {
        return implode('', array_map(static fn ($error) => $open . $error . $close, $this->errors));
    }

    public function set_error(string $error): void
    {
        $this->errors[] = $error;
    }
}
