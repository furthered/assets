<?php

namespace Assets\AssetType;

class CSS extends AssetType
{
    protected function addLib()
    {
        $this->lib = $this->config->get('assets.css.lib', []);
    }

    protected function addDefaults()
    {
        $this->add($this->config->get('assets.css.defaults', []));
    }

    protected function getDir()
    {
        return 'css';
    }

    protected function getExtension()
    {
        return '.css';
    }

    protected function srcTag($path)
    {
        return '<link rel="stylesheet" href="' . $path . '" />';
    }

    protected function wrapInTag($content)
    {
        return '<style type="text/css">' . $content . '</style>';
    }

    protected function getMainFile()
    {
        return 'main' . $this->getExtension();
    }
}
