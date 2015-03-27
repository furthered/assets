<?php

namespace Assets\AssetType;

class CSS extends AssetType {

    protected $lib = [
        'datepicker' => '/bower_components/ngQuickDate/dist/ng-quick-date.css',
    ];

    protected function addDefaults()
    {
        $this->add(['/']);
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
        return 'style' . $this->getExtension();
    }

}
