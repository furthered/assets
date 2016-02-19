<?php

namespace Assets;

use Assets\AssetType\CSS;
use Assets\AssetType\Image;
use Assets\AssetType\JS;

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

    public function url($path)
    {
        if (str_contains($path, ['http://', 'https://'])) {
            return $path;
        }

        $path = ltrim($path, '/');

        if (app()->environment('vagrant')) {
            return '/' . $path;
        }

        return sprintf('%s/assets/%s/%s', rtrim(env('CDN_URL'), '/'), $this->consumer, $path);
    }

    public function reset()
    {
        $this->css->reset();
        $this->js->reset();
    }
}
