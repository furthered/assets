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

        $this->setAngularApp($this->config->get('assets.js.angular_app'), false);
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

    public function setInlineVar($key, $value, $add = true)
    {
        $content = sprintf('var %s = %s;', $key, json_encode($value));

        if ($add) {
            return $this->inline($content);
        }

        return $this->wrapInTag($content);
    }

    public function setAngularApp($app, $remove_default_app = true)
    {
        $this->angular_app = $app;

        if ($remove_default_app) {
            $this->remove('lawline');
        }
    }

    public function getAngularApp()
    {
        return $this->angular_app;
    }
}
