<?php

namespace Assets;

use Assets\AssetType\CSS;
use Assets\AssetType\Image;
use Assets\AssetType\JS;

class Assets {

    protected $css;

    protected $js;

    protected $image;

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

    public function reset()
    {
        $this->css->reset();
        $this->js->reset();
    }

}
