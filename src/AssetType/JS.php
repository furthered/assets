<?php

namespace Assets\AssetType;

class JS extends AssetType
{
    protected $angular_app;

    protected function addLib()
    {
        $this->lib = $this->config->get('assets.js.lib', []);
    }

    protected function addDefaults()
    {
        $this->add($this->config->get('assets.js.defaults', []));

        $this->setAngularApp($this->config->get('assets.js.angular_app'));
    }

    protected function getDir()
    {
        return 'js/apps';
    }

    protected function getExtension()
    {
        return '.js';
    }

    protected function getMainFile()
    {
        return 'app' . $this->getExtension();
    }

    protected function srcTag($path)
    {
        return '<script type="text/javascript" src="' . $path . '"></script>';
    }

    protected function wrapInTag($content)
    {
        return '<script type="text/javascript">' . $content . '</script>';
    }

    public function setAngularApp($app)
    {
        $this->angular_app = $app;
    }

    public function getAngularApp()
    {
        return $this->angular_app;
    }
}
