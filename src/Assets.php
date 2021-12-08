<?php

namespace Assets;

use Assets\AssetType\CSS;
use Assets\AssetType\Image;
use Assets\AssetType\JS;
use Illuminate\Support\Str;

class Assets
{
    protected $css;

    protected $js;

    protected $image;

    protected $consumer;

    public function __construct(CSS $css, JS $js, Image $image)
    {
        $this->css   = $css;
        $this->js    = $js;
        $this->image = $image;
    }

    public function css()
    {
        return $this->css;
    }

    public function js()
    {
        return $this->js;
    }

    public function image()
    {
        return $this->image;
    }

    public function setConsumer($consumer)
    {
        $this->consumer = $consumer;
    }

    public function url($path, $type = 'general')
    {
        $cloudinary_url = config('services.cloudinary.fetch_url', '//res.cloudinary.com/furthered/image/fetch/');
        $transformation = config('image.cloudinary.' . $type, 'g_auto,q_auto,f_auto');

        if (Str::contains($path, ['http://', 'https://'])) {
            return $path;
        }

        $path = ltrim($path, '/');

        if (app()->environment('docker')) {
            return '/' . $path;
        }

        return sprintf(
            '%s/%s/assets/%s/%s',
            $cloudinary_url . $transformation . '/',
            rtrim(config('services.cdn.url'), '/'),
            $this->consumer,
            $path
        );
    }

    public function cdnUrl($path)
    {
        if (Str::contains($path, ['http://', 'https://'])) {
            return $path;
        }

        $path = ltrim($path, '/');

        if (app()->environment('docker')) {
            return '/' . $path;
        }

        return sprintf('%s/assets/%s/%s',
            rtrim(config('services.cdn.url'), '/'),
            $this->consumer,
            $path
        );
    }

    public function reset()
    {
        $this->css->reset();
        $this->js->reset();
    }
}
