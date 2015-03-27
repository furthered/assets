<?php

namespace Assets\AssetType;

class JS extends AssetType {

    protected $angular_app;

    protected function addLib()
    {
        $this->lib = \Config::get('assets.js.lib', []);
    }

    protected function addDefaults()
    {
        $this->add(\Config::get('assets.js.defaults', []));

        $this->setAngularApp(\Config::get('assets.js.angular_app'));
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

    protected function wrapInTag($path)
    {
        return '<script type="text/javascript" src="' . $path . '"></script>';
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
