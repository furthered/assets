<?php

namespace Assets\AssetType;

class CSS extends AssetType {

    protected function addLib()
    {
        $this->lib = \Config::get('assets.css.lib', []);
    }

    protected function addDefaults()
    {
        $this->add(\Config::get('assets.css.defaults', []));
    }

    protected function getDir()
    {
        return 'css';
    }

    protected function getExtension()
    {
        return '.css';
    }

    protected function wrapInTag($path)
    {
        return '<link rel="stylesheet" href="' . $path . '">';
    }

    protected function getMainFile()
    {
        return 'main' . $this->getExtension();
    }

}
