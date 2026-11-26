<?php

namespace App\Compat;

/**
 * CodeIgniter 3 compatible image manipulation class (resize/watermark).
 */
class LegacyImageLib
{
    /** @var array<string, mixed> */
    public array $config = [
        'image_library'  => 'gd2',
        'source_image'   => '',
        'new_image'      => '',
        'maintain_ratio' => true,
        'width'          => 0,
        'height'         => 0,
        'create_thumb'   => false,
        'wm_text'        => '',
        'wm_type'        => 'text',
        'wm_font_path'   => '',
        'wm_font_size'   => 16,
        'wm_font_color'  => 'ffffff',
        'wm_shadow_color' => '',
        'wm_vrt_alignment' => 'bottom',
        'wm_hor_alignment' => 'center',
        'wm_padding'     => 0,
    ];

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
    }

    public function clear(): void
    {
        $this->config['source_image'] = '';
        $this->config['new_image']    = '';
    }

    public function resize(): bool
    {
        $source = (string) $this->config['source_image'];

        if ($source === '' || ! is_file($source)) {
            return false;
        }

        $width  = (int) $this->config['width'];
        $height = (int) $this->config['height'];

        if ($width < 1 && $height < 1) {
            return false;
        }

        $image = service('image');
        $image->withFile($source);

        if ($width < 1) {
            $width = null;
        }
        if ($height < 1) {
            $height = null;
        }

        $image->resize($width, $height, (bool) $this->config['maintain_ratio']);

        $destination = (string) $this->config['new_image'];

        if ($destination === '') {
            return $image->save();
        }

        $directory = dirname($destination);
        if (! is_dir($directory)) {
            @mkdir($directory, 0755, true);
        }

        return $image->save($destination);
    }

    public function watermark(): bool
    {
        $source = (string) $this->config['source_image'];

        if ($source === '' || ! is_file($source)) {
            return false;
        }

        $text = (string) $this->config['wm_text'];
        if ($text === '' || $this->config['wm_type'] !== 'text') {
            return true;
        }

        $info = @getimagesize($source);
        if ($info === false) {
            return false;
        }

        $image = match ($info[2]) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($source),
            IMAGETYPE_PNG  => @imagecreatefrompng($source),
            IMAGETYPE_GIF  => @imagecreatefromgif($source),
            IMAGETYPE_WEBP => @imagecreatefromwebp($source),
            default        => false,
        };

        if (! $image) {
            return false;
        }

        $color = imagecolorallocate($image, 255, 255, 255);
        $font  = (string) $this->config['wm_font_path'];
        $size  = (int) $this->config['wm_font_size'];
        $pad   = 10;

        if ($font !== '' && is_file($font) && function_exists('imagettftext')) {
            $box      = imagettfbbox($size, 0, $font, $text);
            $textWidth = abs($box[4] - $box[0]);
            $x         = max($pad, (int) (($info[0] - $textWidth) / 2));
            imagettftext($image, $size, 0, $x, (int) ($info[1] - $pad), $color, $font, $text);
        } else {
            imagestring($image, 5, $pad, (int) ($info[1] - 20), $text, $color);
        }

        $destination = (string) $this->config['new_image'];
        $target      = $destination !== '' ? $destination : $source;

        $saved = match ($info[2]) {
            IMAGETYPE_JPEG => imagejpeg($image, $target, 90),
            IMAGETYPE_PNG  => imagepng($image, $target),
            IMAGETYPE_GIF  => imagegif($image, $target),
            IMAGETYPE_WEBP => imagewebp($image, $target),
            default        => false,
        };

        imagedestroy($image);

        return (bool) $saved;
    }
}
